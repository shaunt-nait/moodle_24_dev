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
 * Input that accepts a single character.
 *
 * TODO add extra validation to really make sure the user can never enter more than
 * one character, or that setDefault cannot be called with a longer string.
 *
 * @copyright  2012 University of Birmingham
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class stack_singlechar_input extends stack_input {

    public function render(stack_input_state $state, $fieldname, $readonly) {

        $attributes = array(
            'type'      => 'text',
            'name'      => $fieldname,
            'size'      => 1,
            'maxlength' => 1,
            'value'     => $this->contents_to_maxima($state->contents),
        );

        if ($readonly) {
            $attributes['readonly'] = 'readonly';
        }

        return html_writer::empty_tag('input', $attributes);
    }

    protected function extra_validation($contents) {
        if (strlen($contents[0]) > 1) {
            return stack_string('singlechargotmorethanone');
        }
        return '';
    }

    public function add_to_moodleform_testinput(MoodleQuickForm $mform) {
        $mform->addElement('text', $this->name, $this->name, array('size' => 1, 'maxlength' => 1));
        $mform->setType($this->name, PARAM_RAW);
    }

    /**
     * Return the default values for the parameters.
     * @return array parameters` => default value.
     */
    public static function get_parameters_defaults() {
        return array(
            'mustVerify'     => false,
            'hideFeedback'   => true);
    }
}
