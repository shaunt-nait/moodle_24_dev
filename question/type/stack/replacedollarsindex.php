<?php
// This file is part of Stack - http://stack.bham.ac.uk/
//
// Stack is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Stack is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Stack.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This script lets the user create or edit question tests for a question.
 *
 * @copyright  2012 the Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__).'/../../../config.php');

require_once($CFG->libdir . '/questionlib.php');
require_once(dirname(__FILE__) . '/locallib.php');
require_once(dirname(__FILE__) . '/stack/utils.class.php');


// Login and check permissions.
$context = context_system::instance();
require_login();
require_capability('moodle/site:config', $context);
$PAGE->set_url('/question/type/stack/replacedollarsindex.php');
$PAGE->set_context($context);
$PAGE->set_title(stack_string('replacedollarsindextitle'));

// Load the necessary data.
$counts = $DB->get_records_sql_menu("
            SELECT ctx.id, COUNT(q.id) AS numstackquestions
              FROM {context} ctx
              JOIN {question_categories} qc ON qc.contextid = ctx.id
              JOIN {question} q ON q.category = qc.id
             WHERE q.qtype = 'stack'
          GROUP BY ctx.id, ctx.path
          ORDER BY ctx.path
        ");

// Display.
echo $OUTPUT->header();
echo $OUTPUT->heading(stack_string('replacedollarsindex'));

echo html_writer::start_tag('ul');
foreach ($counts as $contextid => $numstackquestions) {
    echo html_writer::tag('li', html_writer::link(
            new moodle_url('/question/type/stack/replacedollars.php', array('contextid' => $contextid)),
            context::instance_by_id($contextid)->get_context_name(true, true) . ' (' . $numstackquestions . ')'));
}
echo html_writer::end_tag('ul');
echo $OUTPUT->footer();
