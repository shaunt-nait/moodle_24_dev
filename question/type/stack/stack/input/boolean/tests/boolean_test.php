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
 * Unit tests for the stack_boolean_input class.
 *
 * @copyright  2012 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


global $CFG;
require_once(dirname(__FILE__) . '/../../factory.class.php');
require_once(dirname(__FILE__) . '/../boolean.class.php');
require_once($CFG->dirroot . '/question/type/stack/tests/test_base.php');


/**
 * Unit tests for stack_boolean_input_test.
 *
 * @copyright  2012 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @group qtype_stack
 */
class stack_boolean_input_rendering_test extends question_testcase {

    protected function expected_choices() {
        return array(
            stack_boolean_input::F => stack_string('false'),
            stack_boolean_input::T => stack_string('true'),
            stack_boolean_input::NA => stack_string('notanswered'),
        );
    }

    public function test_render_not_answered() {
        $el = stack_input_factory::make('boolean', 'ans1', stack_boolean_input::T);
        $this->assert(new question_contains_select_expectation(
                        'stack1__ans1', $this->expected_choices(), stack_boolean_input::NA),
                $el->render(new stack_input_state(
                        stack_input::BLANK, array(stack_boolean_input::NA), '', '', '', ''),
                        'stack1__ans1', false, ''));
    }

    public function test_render_true() {
        $el = stack_input_factory::make('boolean', 'ans2', stack_boolean_input::T);
        $this->assert(new question_contains_select_expectation('stack1__ans2', $this->expected_choices(),
                stack_boolean_input::T), $el->render(new stack_input_state(
                        stack_input::VALID, array(stack_boolean_input::T), '', '', '', ''),
                        'stack1__ans2', false));
    }

    public function test_render_false() {
        $el = stack_input_factory::make('boolean', 'ans3', stack_boolean_input::T);
        $this->assert(new question_contains_select_expectation('stack1__ans3', $this->expected_choices(),
                stack_boolean_input::F), $el->render(new stack_input_state(
                        stack_input::VALID, array(stack_boolean_input::F), '', '', '', ''),
                        'stack1__ans3', false));
    }

    public function test_render_disabled() {
        $el = stack_input_factory::make('boolean', 'input', stack_boolean_input::T);
        $this->assert(new question_contains_select_expectation('stack1__ans1', $this->expected_choices(),
                stack_boolean_input::NA, false), $el->render(new stack_input_state(
                        stack_input::BLANK, array(), '', '', '', ''),
                        'stack1__ans1', true));
    }
}


/**
 * Unit tests for stack_boolean_input_test.
 *
 * @copyright  2012 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @group qtype_stack
 */
class stack_boolean_input_validation_test extends qtype_stack_testcase {
    public function test_validate_student_response_true() {
        $options = new stack_options();
        $el = stack_input_factory::make('boolean', 'sans1', 'true');
        $state = $el->validate_student_response(array('sans1' => 'true'), $options, 'true', null);
        $this->assertEquals(stack_input::SCORE, $state->status);
    }

    public function test_validate_student_response_false() {
        $options = new stack_options();
        $el = stack_input_factory::make('boolean', 'sans1', 'true');
        $state = $el->validate_student_response(array('sans1' => 'false'), $options, 'true', null);
        $this->assertEquals(stack_input::SCORE, $state->status);
    }

    public function test_validate_student_response_na() {
        $options = new stack_options();
        $el = stack_input_factory::make('boolean', 'sans1', 'true');
        $state = $el->validate_student_response(array(), $options, 'true', null);
        $this->assertEquals(stack_input::BLANK, $state->status);
    }

    public function test_validate_student_response_error() {
        $options = new stack_options();
        $el = stack_input_factory::make('boolean', 'sans1', 'true');
        $state = $el->validate_student_response(array('sans1' => 'frog'), $options, 'true', null);
        $this->assertEquals(stack_input::INVALID, $state->status);
    }
}
