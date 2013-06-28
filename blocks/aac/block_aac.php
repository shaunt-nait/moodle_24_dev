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
 * Blog Menu Block page.
 *
 * @package    block
 * @subpackage blog_menu
 * @copyright  2009 Nicolas Connault
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * The blog menu block class
 */
class block_aac extends block_base {

    function init() {
        global $CFG, $COURSE, $USER;

        $this->title = get_string('pluginname', 'block_aac');

        

    }

    function instance_allow_multiple() {
        return false;
    }

    function has_config() {
        return false;
    }

    function applicable_formats() {
        return array('all' => true, 'my' => false, 'tag' => false);
    }

    function instance_allow_config() {
        return true;
    }

    function get_content() {
        global $CFG, $COURSE, $USER;

        if ($this->content !== NULL) {
            return $this->content;
        }

        if (!isloggedin() or isguestuser()) {
            $this->content = new stdClass();
            $this->content->text = '';
            return $this->content;
        }
        
        $context = get_context_instance(CONTEXT_COURSE, $COURSE->id);
        
        $isEditingTeacher = false;
        $isStudent = false;
        $roles = get_user_roles($context, $USER->id);
        foreach($roles as $role)
        {
            
            //$content  .= "test:" .$role->name.  "</br>";
            if($role->shortname == "student")
                $isStudent = true;
        }
        

        
        $this->title =  $isStudent ? "Useful Links" :  get_string('pluginname', 'block_aac'); 
		
        if(has_capability('moodle/grade:manage', $context) ) {
            $isEditingTeacher = true;
        }
    
        //$content  .= "test:" .$isStudent. "  isEdit:" .$isEditingTeacher. "</br>";
        $content = '';
        if($isStudent == true)
        {        
            $content .= '<ul>
						    <li><a href="/blocks/aac/studentmoodlesupport.php?id='.$COURSE->id.'">Moodle Support</a></li>
						    <li><a href="https://mynait.nait.ca/student-services.htm" target="_blank">Student Services</a></li>
						    <li><a href="https://mynait.nait.ca" target="_blank">myNAIT Portal</a></li>
						</ul>'; 
		}
        else if ($isEditingTeacher == true)
        {                 
              $content .= '<ul style="list-style-type: none;margin-left:0px">								
                                <li style="background-image:url(\'/theme/image.php?theme=nait&image=i%2Fedit\');background-repeat:no-repeat;padding-left:20px;margin-top:8px;margin-bottom:8px;font-weight:bold"><a href="'.$CFG->wwwroot.'/blocks/aac/index.php?id='.$COURSE->id.'"  />Manage My Course...</a></li>
						        <li style="padding-left:20px"><hr/></li>
                                <li style="background-image:url(\'/theme/image.php?theme=nait&image=i%2Fuser\');background-repeat:no-repeat;padding-left:20px;margin-bottom:8px"><a href="'.$CFG->wwwroot.'/blocks/aac/aac_removeme.php?id='.$COURSE->id.'" >Remove me from this course</a></li>
                                <li style="background-image:url(\'/theme/image.php?theme=nait&image=i%2Fusers\');background-repeat:no-repeat;padding-left:20px;margin-bottom:8px"><a href="'.$CFG->wwwroot.'/blocks/aac/aac_addremovecolleague.php?id='.$COURSE->id.'" >Add/remove staff</a></li>
						</ul>';
		}
		else
        {
            $content .= '<ul style="list-style-type: none;margin-left:0px">
                                <li style="background-image:url(\'/theme/image.php?theme=nait&image=i%2Fuser\');background-repeat:no-repeat;padding-left:20px;margin-bottom:8px"><a href="'.$CFG->wwwroot.'/blocks/aac/aac_removeme.php?id='.$COURSE->id.'" >Remove me from this course</a></li>                                
						</ul>';
        }

 
        $this->content->text = $content;

        // Return the content object
        return $this->content;
    }
    

}
//<li style="background-image:url(\'/theme/image.php?theme=nait&image=i%2Fedit\');background-repeat:no-repeat;padding-left:20px;margin-bottom:3px"><a href="https://staffsites.nait.ca/sites/techsupport/eLearning/moodle/Pages/default.aspx" target="_blank">Get in touch with my LAE</a></li>