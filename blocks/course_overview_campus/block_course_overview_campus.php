<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Block "course overview (campus)"
 *
 * @package     block
 * @subpackage  block_course_overview_campus
 * @copyright   2013 Alexander Bias, University of Ulm <alexander.bias@uni-ulm.de>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */



require_once(dirname(__FILE__) . '/lib.php');

class block_course_overview_campus extends block_base {

    /**
     * Returns list of courses current $USER is enrolled in and can access
     *
     * - $fields is an array of field names to ADD
     *   so name the fields you really need, which will
     *   be added and uniq'd
     *
     * @param string|array $fields
     * @param string $sort
     * @param int $limit max number of courses
     * @return array
     */
     
 
     
    function enrol_get_my_courses_mark($fields = NULL, $sort = 'visible DESC,sortorder ASC', $limit = 0, $archived = 4) {
        
        global $DB, $USER;
        
        
        // Guest account does not have any courses
        if (isguestuser() or !isloggedin()) {
            return(array());
        }

        $basefields = array('id', 'category', 'sortorder',
                            'shortname', 'fullname', 'idnumber',
                            'startdate', 'visible',
                            'groupmode', 'groupmodeforce');

        if (empty($fields)) {
            $fields = $basefields;
        } else if (is_string($fields)) {
            // turn the fields from a string to an array
            $fields = explode(',', $fields);
            $fields = array_map('trim', $fields);
            $fields = array_unique(array_merge($basefields, $fields));
        } else if (is_array($fields)) {
            $fields = array_unique(array_merge($basefields, $fields));
        } else {
            throw new coding_exception('Invalid $fileds parameter in enrol_get_my_courses()');
        }
        if (in_array('*', $fields)) {
            $fields = array('*');
        }

        $orderby = "";
        $sort    = trim($sort);
        if (!empty($sort)) {
            $rawsorts = explode(',', $sort);
            $sorts = array();
            foreach ($rawsorts as $rawsort) {
                $rawsort = trim($rawsort);
                if (strpos($rawsort, 'c.') === 0) {
                    $rawsort = substr($rawsort, 2);
                }
                $sorts[] = trim($rawsort);
            }
            $sort = 'c.'.implode(',c.', $sorts);
            $orderby = "ORDER BY $sort";
        }
        
        $wheres = array("c.id <> :siteid");
        $params = array('siteid'=>SITEID);

        if (isset($USER->loginascontext) and $USER->loginascontext->contextlevel == CONTEXT_COURSE) {
            // list _only_ this course - anything else is asking for trouble...
            $wheres[] = "courseid = :loginas";
            $params['loginas'] = $USER->loginascontext->instanceid;
        }

        $coursefields = 'c.' .join(',c.', $fields);
        list($ccselect, $ccjoin) = context_instance_preload_sql('c.id', CONTEXT_COURSE, 'ctx');
        $wheres = implode(" AND ", $wheres);
        
        //AND  Instr(cc.path, '/4/' )  = false

        //note: we can not use DISTINCT + text fields due to Oracle and MS limitations, that is why we have the subselect there
        $sql = "SELECT  $coursefields $ccselect 
  , cc.idnumber is not null and Instr(cc.idnumber, 'archive' ) > 0 as archived
              FROM {course} c
              JOIN {course_categories} cc ON (cc.id = c.category )
              JOIN (SELECT DISTINCT e.courseid
                      FROM {enrol} e
                      JOIN {user_enrolments} ue ON (ue.enrolid = e.id AND ue.userid = :userid)
                      
                     WHERE ue.status = :active AND e.status = :enabled AND ue.timestart < :now1 AND (ue.timeend = 0 OR ue.timeend > :now2)
                   ) en ON (en.courseid = c.id)  
           $ccjoin
             WHERE $wheres            
          order by  cc.idnumber is not null and Instr(cc.idnumber, 'archive' ) > 0, shortname asc";
        $params['userid']  = $USER->id;
        $params['active']  = ENROL_USER_ACTIVE;
        $params['enabled'] = ENROL_INSTANCE_ENABLED;
        $params['now1']    = round(time(), -2); // improves db caching
        $params['now2']    = $params['now1'];

        $courses = $DB->get_records_sql($sql, $params, 0, $limit);


        // preload contexts and check visibility
        foreach ($courses as $id=>$course) {
            context_instance_preload($course);
            if (!$course->visible) {
                if (!$context = context_course::instance($id, IGNORE_MISSING)) {
                    unset($courses[$id]);
                    continue;
                }
                if (!has_capability('moodle/course:viewhiddencourses', $context)) {
                    unset($courses[$id]);
                    continue;
                }
            }
            $courses[$id] = $course;
        }

        //wow! Is that really all? :-D

        return $courses;
    }





    function init() {
        $this->title = get_string('pluginname', 'block_course_overview_campus');
    }

    function specialization() {
        $this->title = get_string('pluginname', 'block_course_overview');
    }

    function applicable_formats() {
        return array('my-index' => true, 'site-index' => true);
    }

    function has_config() {
        return true;
    }

    function instance_allow_multiple() {
        return false;
    }

    function instance_can_be_hidden() {
        return false;
    }
    
    


    function get_content() {
        global $USER, $CFG, $DB, $PAGE, $OUTPUT;

        if ($this->content !== null) {
            return $this->content;
        }
        

        /********************************************************************************/
        /***                              PREPROCESSING                               ***/
        /********************************************************************************/

        // Get block config
        $config = get_config('block_course_overview_campus');



        // Process GET parameters
        $hidecourse = optional_param('hidecourse', 0, PARAM_INT);
        $showcourse = optional_param('showcourse', 0, PARAM_INT);
        $hidenews = optional_param('hidenews', 0, PARAM_INT);
        $shownews = optional_param('shownews', 0, PARAM_INT);
        $manage = optional_param('manage', 0, PARAM_BOOL);



        // Set displaying preferences when set by GET parameters
        if ($hidecourse != 0) {
            set_user_preference('block_course_overview_campus-hidecourse-'.$hidecourse, 1);
        }
        if ($showcourse != 0) {
            set_user_preference('block_course_overview_campus-hidecourse-'.$showcourse, 0);
        }
        if ($hidenews != 0) {
            set_user_preference('block_course_overview_campus-hidenews-'.$hidenews, 1);
        }
        if ($shownews != 0) {
            set_user_preference('block_course_overview_campus-hidenews-'.$shownews, 0);
        }



        $courses = $this->enrol_get_my_courses_mark('id, shortname, modinfo, sectioncache', 'fullname ASC');

        // Remove frontpage course, if enrolled, from courses list
        $site = get_site();
        if (array_key_exists($site->id, $courses)) {
            unset($courses[$site->id]);
        }



        /********************************************************************************/
        /***                             PROCESS MY COURSES                           ***/
        /********************************************************************************/

        // No, I don't have any courses -> content is only a placeholder message
        if (empty($courses)) {
            $content = get_string('nocourses', 'block_course_overview_campus');
        }
        // Yes, I have courses
        else {
            // Start output buffer
            ob_start();


            // Get lastaccess of all courses to support course news
            foreach ($courses as $c) {
                if (isset($USER->lastcourseaccess[$c->id])) {
                    $courses[$c->id]->lastaccess = $USER->lastcourseaccess[$c->id];
                }
                else {
                    $courses[$c->id]->lastaccess = 0;
                }
            }
            
            // Get course news from my courses
            $coursenews = array();
            
            function isNotArchived($c)
            {               
                return($c->archived == 0);
            }
            
            $nonArchivedCourses = array_filter($courses, "isNotArchived");
            
            
            
            if ($modules = $DB->get_records('modules')) {
                foreach ($modules as $mod) {
                
                
                    if (file_exists($CFG->dirroot.'/mod/'.$mod->name.'/lib.php')) {
                        include_once($CFG->dirroot.'/mod/'.$mod->name.'/lib.php');
                        $fname = $mod->name.'_print_overview';
                        if (function_exists($fname)) {
                            $fname($nonArchivedCourses, $coursenews);
                        }
                    }
                }
            }
            


            // Create counter for hidden courses
            $hiddencourses = 0;

            // Create strings to remember courses and course news for YUI processing
            $yui_courseslist = ' ';
            $yui_coursenewslist = ' ';


            // Now iterate over courses and collect data about my courses
            foreach ($courses as $c) {
                


                // Check if this course should be shown or not
                $courses[$c->id]->hidecourse = get_user_preferences('block_course_overview_campus-hidecourse-'.$c->id, 0);
                if ($courses[$c->id]->hidecourse == 1) {
                    $hiddencourses++;
                }

                // Check if this course should show news or not
                $courses[$c->id]->hidenews = get_user_preferences('block_course_overview_campus-hidenews-'.$c->id, 0);
            }



            /********************************************************************************/
            /***               GENERATE OUTPUT FOR HIDDEN COURSES MANAGEMENT              ***/
            /********************************************************************************/

            // I have hidden courses
            if ($hiddencourses > 0) {
                // And hidden courses managing is off
                if ($manage == false) {
                    // Create footer with hidden courses information
                    $footer = '<div id="coc-hiddencoursesmanagement">'.get_string('youhave', 'block_course_overview_campus').' <span id="coc-hiddencoursescount">'.$hiddencourses.'</span> '.get_string('hiddencourses', 'block_course_overview_campus').' | <a href="'.$CFG->wwwroot.$PAGE->url->out_as_local_url(true, array('manage' => 1)).'">'.get_string('managehiddencourses', 'block_course_overview_campus').'</a></div>';
                }
                // And hidden courses managing is on
                else {
                    // Create toolbox with link for stopping management
                    echo '<div class="coursebox toolbox"><a href="'.$CFG->wwwroot.$PAGE->url->out_as_local_url(true, array('manage' => 0)).'">'.get_string('stopmanaginghiddencourses', 'block_course_overview_campus').'</a></div>';

                    // Create footer with link for stopping management
                    $footer = '<div id="coc-hiddencoursesmanagement"><a href="'.$CFG->wwwroot.$PAGE->url->out_as_local_url(true, array('manage' => 0)).'">'.get_string('stopmanaginghiddencourses', 'block_course_overview_campus').'</a></div>';
                }
            }
            // I have no hidden courses
            else {
                    // Prepare footer to appear as soon as a course is hidden
                    $footer = '<div id="coc-hiddencoursesmanagement" class="coc-hidden">'.get_string('youhave', 'block_course_overview_campus').' <span id="coc-hiddencoursescount">'.$hiddencourses.'</span> '.get_string('hiddencourses', 'block_course_overview_campus').' | <a href="'.$CFG->wwwroot.$PAGE->url->out_as_local_url(true, array('manage' => 1)).'">'.get_string('managehiddencourses', 'block_course_overview_campus').'</a></div>';
            }



            /********************************************************************************/
            /***                   GENERATE OUTPUT FOR COURSELIST                         ***/
            /********************************************************************************/

            // Start section
            echo '<div id="coc-courselist">';
            
             $isArchivedHeadingRendered = false;

            // Show courses
            foreach ($courses as $c) {
                // Remember course ID for YUI processing
                $yui_courseslist .= $c->id.' ';

                // Start course div as visible if it isn't hidden or if hidden courses are currently shwon
                if (($c->hidecourse == 0) || $manage == true) {
                    echo '<div id="coc-course-'.$c->id.'" class="coc-course">';
                }
                // Otherwise start course div as hidden
                else {
                    echo '<div id="coc-course-'.$c->id.'" class="coc-course coc-hidden">';
                }

                
                if( !$isArchivedHeadingRendered  && $c->archived == true)
                {
                    $isArchivedHeadingRendered = true;
                    echo $OUTPUT->box_start('coursebox');
                
                    echo $OUTPUT->heading( "Archived Courses", 1);
                
                    echo $OUTPUT->box_end();
                
                }


                // Start standard course overview coursebox
                echo $OUTPUT->box_start('coursebox');

                // Output course news visibility control icons
                if (array_key_exists($c->id, $coursenews)) {
                    // If course news are hidden
                    if ($c->hidenews == 0) {
                        echo '<div class="hidenewsicon">
                                <a href="'.$CFG->wwwroot.$PAGE->url->out_as_local_url(true, array('manage' => $manage, 'hidenews' => $c->id, 'shownews' => '')).'" id="coc-hidenews-'.$c->id.'" title="'.get_string('hidenews', 'block_course_overview_campus').'">
                                    <img src="'.$OUTPUT->pix_url('t/expanded').'" alt="'.get_string('hidenews', 'block_course_overview_campus').'" />
                                </a>
                                <a href="'.$CFG->wwwroot.$PAGE->url->out_as_local_url(true, array('manage' => $manage, 'hidenews' => '', 'shownews' => $c->id)).'" id="coc-shownews-'.$c->id.'" class="coc-hidden" title="'.get_string('shownews', 'block_course_overview_campus').'">
                                    <img src="'.$OUTPUT->pix_url('t/collapsed').'" alt="'.get_string('shownews', 'block_course_overview_campus').'" />
                                </a>
                            </div>';
                    }
                    // If course news are visible
                    else {
                        echo '<div class="hidenewsicon">
                                <a href="'.$CFG->wwwroot.$PAGE->url->out_as_local_url(true, array('manage' => $manage, 'hidenews' => $c->id, 'shownews' => '')).'" id="coc-hidenews-'.$c->id.'" class="coc-hidden" title="'.get_string('hidenews', 'block_course_overview_campus').'">
                                    <img src="'.$OUTPUT->pix_url('t/expanded').'" alt="'.get_string('hidenews', 'block_course_overview_campus').'" />
                                </a>
                                <a href="'.$CFG->wwwroot.$PAGE->url->out_as_local_url(true, array('manage' => $manage, 'hidenews' => '', 'shownews' => $c->id)).'" id="coc-shownews-'.$c->id.'" title="'.get_string('shownews', 'block_course_overview_campus').'">
                                    <img src="'.$OUTPUT->pix_url('t/collapsed').'" alt="'.get_string('shownews', 'block_course_overview_campus').'" />
                                </a>
                            </div>';
                    }
                }

                // Output course visibility control icons
                // If course is hidden
                if ($c->hidecourse == 0) {
                    echo '<div class="hidecourseicon">
                            <a href="'.$CFG->wwwroot.$PAGE->url->out_as_local_url(true, array('manage' => $manage, 'hidecourse' => $c->id, 'showcourse' => '')).'" id="coc-hidecourse-'.$c->id.'" title="'.get_string('hidecourse', 'block_course_overview_campus').'">
                                <img src="'.$OUTPUT->pix_url('t/hide').'" class="icon" alt="'.get_string('hidecourse', 'block_course_overview_campus').'" />
                            </a>
                            <a href="'.$CFG->wwwroot.$PAGE->url->out_as_local_url(true, array('manage' => $manage, 'hidecourse' => '', 'showcourse' => $c->id)).'" id="coc-showcourse-'.$c->id.'" class="coc-hidden" title="'.get_string('showcourse', 'block_course_overview_campus').'">
                                <img src="'.$OUTPUT->pix_url('t/show').'" class="icon" alt="'.get_string('showcourse', 'block_course_overview_campus').'" />
                            </a>
                        </div>';
                }
                // If course is visible
                else {
                    echo '<div class="hidecourseicon">
                            <a href="'.$CFG->wwwroot.$PAGE->url->out_as_local_url(true, array('manage' => $manage, 'hidecourse' => $c->id, 'showcourse' => '')).'" id="coc-hidecourse-'.$c->id.'" class="coc-hidden" title="'.get_string('hidecourse', 'block_course_overview_campus').'">
                                <img src="'.$OUTPUT->pix_url('t/hide').'" class="icon" alt="'.get_string('hidecourse', 'block_course_overview_campus').'" />
                            </a>
                            <a href="'.$CFG->wwwroot.$PAGE->url->out_as_local_url(true, array('manage' => $manage, 'hidecourse' => '', 'showcourse' => $c->id)).'" id="coc-showcourse-'.$c->id.'" title="'.get_string('showcourse', 'block_course_overview_campus').'">
                                <img src="'.$OUTPUT->pix_url('t/show').'" class="icon" alt="'.get_string('showcourse', 'block_course_overview_campus').'" />
                            </a>
                        </div>';
                }


                // Get course attributes for use with course link
                $attributes = array('title' => s($c->fullname));
                if (empty($c->visible)) {
                    $attributes['class'] = 'dimmed';
                }
                
                if($c->archived)
                {         
                    $attributes['style'] = 'padding-left:20px';
                    echo html_writer::link(new moodle_url('/course/view.php', array('id' => $c->id)), format_string($c->fullname), $attributes);
                    
                 }
                 else
                 {
                     echo $OUTPUT->heading(html_writer::link(new moodle_url('/course/view.php', array('id' => $c->id)), format_string($c->fullname), $attributes), 3);
                 }
                 
                //}
                
                

                // Output course news
                if (array_key_exists($c->id, $coursenews)) {
                    // Remember course ID for YUI processing
                    $yui_coursenewslist .= $c->id.' ';

                    // Start course news div as visible if the course's news aren't hidden
                    if ($c->hidenews == 0) {
                        echo '<div id="coc-coursenews-'.$c->id.'" class="coc-coursenews">';
                    }
                    // Otherwise start course news div as hidden
                    else {
                        echo '<div id="coc-coursenews-'.$c->id.'" class="coc-coursenews coc-hidden">';
                    }

                    // Output the course's preformatted news HTML
                    foreach ($coursenews[$c->id] as $modname => $html) {
                        echo '<div class="coc-module">';
                            echo $OUTPUT->pix_icon('icon', $modname, 'mod_'.$modname, array('class'=>'iconlarge'));
                            echo $html;
                        echo '</div>';
                    }

                    // End course news div
                    echo '</div>';
                }

                // End standard course overview coursebox
                echo $OUTPUT->box_end();

                // End course div
                echo '</div>';
            }

            // End section
            echo '</div>';



            /********************************************************************************/
            /***                             OUTPUT CONTENT                               ***/
            /********************************************************************************/

            // Get and end output buffer
            $content = ob_get_contents();
            ob_end_clean();



            /********************************************************************************/
            /***                             AJAX MANAGEMENT                              ***/
            /********************************************************************************/

            // Verify that course displaying parameters are updatable by AJAX
            foreach ($courses as $c) {
                user_preference_allow_ajax_update('block_course_overview_campus-hidecourse-'.$c->id, PARAM_INT);
                user_preference_allow_ajax_update('block_course_overview_campus-hidenews-'.$c->id, PARAM_INT);
            }

            //// Verify that filter parameters are updatable by AJAX
            //if ($config->termcoursefilter == true) {
            //    user_preference_allow_ajax_update('block_course_overview_campus-selectedterm', PARAM_TEXT);
            //}
            //if ($config->teachercoursefilter == true) {
            //    user_preference_allow_ajax_update('block_course_overview_campus-selectedteacher', PARAM_TEXT);
            //}
            //if ($config->categorycoursefilter == true) {
            //    user_preference_allow_ajax_update('block_course_overview_campus-selectedcategory', PARAM_TEXT);
            //}

            // Include YUI for hiding courses and news with AJAX
            $PAGE->requires->yui_module('moodle-block_course_overview_campus-hidenews', 'M.block_course_overview_campus.initHideNews', array(array('courses'=>trim($yui_coursenewslist))));
            $PAGE->requires->yui_module('moodle-block_course_overview_campus-hidecourse', 'M.block_course_overview_campus.initHideCourse', array(array('courses'=>trim($yui_courseslist), 'editing'=>$manage)));

            // Include YUI for filtering courses with AJAX
            if ($config->teachercoursefilter == true || $config->termcoursefilter == true || $config->categorycoursefilter == true) {
                $PAGE->requires->yui_module('moodle-block_course_overview_campus-filter', 'M.block_course_overview_campus.initFilter', array());
            }
        }



        /********************************************************************************/
        /***                             OUTPUT AND RETURN                            ***/
        /********************************************************************************/

        // Output content
        $this->content = new stdClass();

        if (!empty($content)) {
            $this->content->text = $content;
        }
        else {
            $this->content->text = '';
        }

        if (!empty($footer)) {
            $this->content->footer = $footer;
        }
        else {
            $this->content->footer = '';
        }

        return $this->content;
    }
    
    
    }
    
    
