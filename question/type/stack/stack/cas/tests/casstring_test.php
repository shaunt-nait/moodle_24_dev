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
 * Unit tests for stack_cas_casstring.
 *
 * @copyright  2012 The University of Birmingham
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once(dirname(__FILE__) . '/../../../locallib.php');
require_once(dirname(__FILE__) . '/../casstring.class.php');


/**
 * Unit tests for {@link stack_cas_casstring}.
 * @group qtype_stack
 */
class stack_cas_casstring_test extends basic_testcase {

    public function get_valid($s, $st, $te) {

        $at1 = new stack_cas_casstring($s);
        $this->assertEquals($st, $at1->get_valid('s'));

        $at2 = new stack_cas_casstring($s);
        $this->assertEquals($te, $at2->get_valid('t'));
    }

    public function test_get_valid() {
        $cases = array(
            array('', false, false),
            array('1', true, true),
            array('a b', false, true),
            array('%pi', true, true), // Only %pi %e, %i, %gamma, %phi.
            array('1+%e', true, true),
            array('e^%i*%pi', true, true),
            array('%gamma', true, true),
            array('%phi', true, true),
            array('%o1', false, false),
            // Literal unicode character, instead of name.
            array('π', false, false),
            // Non-matching brackets.
            array('(x+1', false, false),
            array('(y^2+1))', false, false),
            array('[sin(x)+1)', false, false),
            array('([y^2+1)]', false, false),
            // Function which does not appears on the teacher's list.
            array('setelmx(2,1,1,C)', false, true),
            array('2*reallytotalnonsensefunction(x)', false, true),
            array('system(rm *)', false, false), // This should never occur.
            array('$', false, false),
            array('@', false, false),
            // Inequalities.
            array('x>=1', true, true),
            array('x=>1', false, false),
        );

        foreach ($cases as $case) {
            $this->get_valid($case[0], $case[1], $case[2]);
        }
    }

    public function test_validation_error() {
        $casstring = new stack_cas_casstring('π');
        $casstring->validate('s');
        $this->assertEquals(stack_string('stackCas_forbiddenChar', array('char' => 'π')),
                $casstring->get_errors());
        $this->assertEquals('forbiddenChar', $casstring->get_answernote());
    }

    public function test_spurious_operators() {
        $casstring = new stack_cas_casstring('2/*x');
        $casstring->validate('s');
        $this->assertEquals('Unknown operator: <span class="stacksyntaxexample">/*</span>.',
                $casstring->get_errors());
        $this->assertEquals('spuriousop', $casstring->get_answernote());
    }

    public function test_get_valid_inequalities() {
        $cases = array(
                array('x>1 and x<4', true, true),
                array('not (x>1)', true, true),
                array('x<=2 or not (x>1)', true, true),
                array('x<1 or (x>1 and t<sin(x))', true, true),
                array('[x<1, x>3]', true, true),
                array('pg:if x<x0 then f0 else if x<x1 then 1000 else f1', false, true),
                array('1<x<7', false, false),
                array('1<a<=x^2', false, false),
                array('{1<x<y, c>0}', false, false),
        );

        foreach ($cases as $case) {
            $this->get_valid($case[0], $case[1], $case[2]);
        }
    }

    public function get_key($s, $key, $val) {
        $at1 = new stack_cas_casstring($s);
        $this->assertEquals($key, $at1->get_key());
        $this->assertEquals($s, $at1->get_raw_casstring()); // Note the difference between the two!
        $this->assertEquals($val, $at1->get_casstring());
    }

    public function test_get_key() {
        $cases = array(
            array('x=1', '', 'x=1'),
            array('a:1', 'a', '1'),
            array('a1:1', 'a1', '1'),
            array('f(x):=x^2', '', 'f(x):=x^2'),
            array('a:b:1', 'a', 'b:1'),
            array('ta:x^3=-3', 'ta', 'x^3=-3')
        );

        foreach ($cases as $case) {
            $this->get_key($case[0], $case[1], $case[2]);
        }
    }

    public function test_global_forbidden_words() {

        $s = 'system(rm *)';
        $at1 = new stack_cas_casstring($s);
        $this->assertFalse($at1->get_valid('s'));
        $this->assertEquals('The expression <span class="stacksyntaxexample">system</span> is forbidden.',
                $at1->get_errors());

        $at2 = new stack_cas_casstring($s);
        $this->assertFalse($at2->get_valid('t'));
        $this->assertEquals('The expression <span class="stacksyntaxexample">system</span> is forbidden.',
                $at2->get_errors());
    }

    public function test_teacher_only_words() {

        $s = 'setelmx(2,1,1,C)';
        $at1 = new stack_cas_casstring($s);
        $this->assertFalse($at1->get_valid('s'));
        $this->assertEquals('Unknown function: <span class="stacksyntaxexample">setelmx</span>.',
                $at1->get_errors());

        $at2 = new stack_cas_casstring($s);
        $this->assertTrue($at2->get_valid('t'));
        $this->assertEquals('', $at2->get_errors());
    }

    public function test_check_external_forbidden_words() {
        // Remember, this function returns true if the literal is found.
        $cases = array(
            array('sin(ta)', array('ta'), true),
            array('sin(ta)', array('ta', 'a', 'b'), true),
            array('sin(ta)', array('sa'), false),
            array('sin(a)', array('a'), false), // This ignores single letters.
            array('diff(x^2,x)', array('[[BASIC-CALCULUS]]'), true),
        );

        foreach ($cases as $case) {
            $cs = new stack_cas_casstring($case[0]);
            $this->assertEquals($case[2], $cs->check_external_forbidden_words($case[1]));
        }
    }

    public function test_check_external_forbidden_words_literal() {
        $cases = array(
            array('3+5', '+', true),
            array('sin(a)', 'a', true), // It includes single letters.
            array('sin(a)', 'i', true), // Since it is a string match, this can be inside a name.
            array('sin(a)', 'b', false),
            array('sin(a)', 'b,\,,c', false), // Test escaped commas.
            array('[x,y,z]', 'b,\,,c', true),
            array('diff(x^2,x)', '[[BASIC-CALCULUS]]', true), // From lists.
            array('solve((x-6)^4,x)', '[[BASIC-ALGEBRA]]', true), // From lists.
        );

        foreach ($cases as $case) {
            $cs = new stack_cas_casstring($case[0]);
            $this->assertEquals($case[2], $cs->check_external_forbidden_words_literal($case[1]));
        }
    }

    public function test_html_1() {
        $s = '</span>n';
        $at1 = new stack_cas_casstring($s);
        $this->assertFalse($at1->get_valid('t'));
        $this->assertEquals('You appear to have some HTML elements in your expression. <pre></span>n</pre>',
                $at1->get_errors());
    }

    public function test_html_2() {
        $s = '<span>n';
        $at1 = new stack_cas_casstring($s);
        $this->assertFalse($at1->get_valid('t'));
        $this->assertEquals('You appear to have some HTML elements in your expression. <pre><span>n</pre>',
                $at1->get_errors());
    }

    public function test_strings_1() {
        $s = 'a:"hello"';
        $at1 = new stack_cas_casstring($s);
        $this->assertTrue($at1->get_valid('t'));
    }

    public function test_strings_2() {
        $s = 'a:"hello';
        $at1 = new stack_cas_casstring($s);
        $this->assertFalse($at1->get_valid('t'));
        $this->assertEquals('You are missing a quotation sign <code>"</code>. ',
                $at1->get_errors());
    }

    public function test_strings_3() {
        $s = 'a:["2x)",3*x]';
        $at1 = new stack_cas_casstring($s);
        $this->assertTrue($at1->get_valid('t'));
    }

    public function test_strings_4() {
        $s = 'a:["system(\'rm *\')",3*x]';
        $at1 = new stack_cas_casstring($s);
        $this->assertFalse($at1->get_valid('t'));
        $this->assertEquals('The expression <span class="stacksyntaxexample">system</span> is forbidden.',
                $at1->get_errors());
    }
}


/**
 * Unit tests for {@link stack_cas_casstring}.
 * @group qtype_stack
 */
class stack_cas_casstring_exception_test extends basic_testcase {

    public function test_exception_1() {
        $this->setExpectedException('stack_exception');
        $at1 = new stack_cas_casstring(array());
    }

    public function test_exception_2() {
        $at1 = new stack_cas_casstring("x=1");
        $this->setExpectedException('stack_exception');
        $at1->get_valid(false, false, false);
    }

    public function test_exception_3() {
        $at1 = new stack_cas_casstring("x=1");
        $this->setExpectedException('stack_exception');
        $at1->get_valid('z', false, false);
    }

    public function test_exception_4() {
        $at1 = new stack_cas_casstring("x=1");
        $this->setExpectedException('stack_exception');
        $at1->get_valid('t', 'a', false);
    }

    public function test_exception_5() {
        $at1 = new stack_cas_casstring("x=1");
        $this->setExpectedException('stack_exception');
        $at1->get_valid('t', true, 'a');
    }
}
