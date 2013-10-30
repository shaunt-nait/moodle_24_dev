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
 * Unit tests for stack_anstest_atregexp.
 *
 * @copyright  2012 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once(dirname(__FILE__) . '/../anstest.class.php');
require_once(dirname(__FILE__) . '/../atregexp.class.php');


/**
 * Unit tests for stack_anstest_atregexp.
 *
 * @copyright  2012 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @group qtype_stack
 */
class stack_anstest_atregexp_test extends basic_testcase {

    public function test_true_when_matches() {
        $at = new stack_anstest_atregexp('3.1415927', '', array(), '{[0-9]*\.[0-9]*}');
        $this->assertTrue($at->do_test());
        $this->assertEquals(1, $at->get_at_mark());
    }

    public function test_false_when_doesnt_match() {
        $at = new stack_anstest_atregexp('cxcxcz', '', array(), '{[0-9]*\.[0-9]*}');
        $this->assertFalse($at->do_test());
        $this->assertEquals(0, $at->get_at_mark());
    }
}
