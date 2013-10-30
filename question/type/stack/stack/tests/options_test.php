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
 * Unit tests for stack_options.
 *
 * @copyright  2012 The University of Birmingham
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../options.class.php');


/**
 * Unit tests for stack_options.
 *
 * @copyright  2012 The University of Birmingham
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @group qtype_stack
 */
class stack_options_set_exception_test extends basic_testcase {

    public function test_set_exception_1() {
        $opts = new stack_options();
        $this->setExpectedException('stack_exception');
        $opts->set_option('nonoption', false);
    }

    public function test_set_exception_2() {
        $opts = new stack_options();
        $this->setExpectedException('stack_exception');
        $opts->set_option('floats', 0);
    }

    public function test_set_exception_3() {
        $opts = new stack_options();
        $this->setExpectedException('stack_exception');
        $opts->set_option('floats', null);
    }

    public function test_set_exception_4() {
        $opts = new stack_options();
        $this->setExpectedException('stack_exception');
        $opts->set_option('display', false);
    }

    public function test_set_exception_5() {
        $opts = new stack_options();
        $this->setExpectedException('stack_exception');
        $opts->set_option('display', 'latex');
    }
}
