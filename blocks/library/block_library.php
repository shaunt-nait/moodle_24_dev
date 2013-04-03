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
class block_library extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_library');
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
        global $CFG;

        // detect if blog enabled
        if ($this->content !== NULL) {
            return $this->content;
        }

        if (empty($CFG->bloglevel)) {
            $this->content = new stdClass();
            $this->content->text = '';
            if ($this->page->user_is_editing()) {
                $this->content->text = get_string('blogdisable', 'blog');
            }
            return $this->content;

        } else if ($CFG->bloglevel < BLOG_GLOBAL_LEVEL and (!isloggedin() or isguestuser())) {
            $this->content = new stdClass();
            $this->content->text = '';
            return $this->content;
        }

        // require necessary libs and get content
        require_once($CFG->dirroot .'/blog/lib.php');

        // Prep the content
        
        $this->content->text = '<p><a data-mce-href="http://www.nait.ca/library" target="_blank" href="http://www.nait.ca/library" title="Library Website">Library Website</a></p>
								<ul>
								<li><a data-mce-href="http://primo2.hosted.exlibrisgroup.com:1701/primo_library/libweb/action/search.do?menuitem=0&amp;fromTop=true&amp;fromPreferences=false&amp;fromEshelf=false&amp;vid=NAIT" target="_blank" href="http://primo2.hosted.exlibrisgroup.com:1701/primo_library/libweb/action/search.do?menuitem=0&amp;fromTop=true&amp;fromPreferences=false&amp;fromEshelf=false&amp;vid=NAIT" title="Library Search Tool">Library Search Tool </a></li>
								<li><a data-mce-href="http://www.nait.ca/library/852.htm" target="_blank" href="http://www.nait.ca/library/852.htm" title="Library Databases">Library Databases </a></li>
								<li><a data-mce-href="http://www.nait.ca/libresources/library_tutorial/LibraryTutorialPlayer.html" target="_blank" href="http://www.nait.ca/libresources/library_tutorial/LibraryTutorialPlayer.html" title="iNAIT Assignment Tutorial">iNAIT Assignment Tutorial </a></li>
								<li><a target="_blank" href="http://www.nait.ca/library/829.htm" title="Write &amp; Cite ">Write &amp; Cite</a></li>
								<li><a target="_blank" href="http://www.nait.ca/58450.htm" title="Project Factory ">Project Factory</a></li>
								<li><a data-mce-href="http://www.nait.ca/library/2713.htm" target="_blank" href="http://www.nait.ca/library/2713.htm" title="Ask Us">Ask Us </a></li>
								</ul>';

        // Return the content object
        return $this->content;
    }
}
