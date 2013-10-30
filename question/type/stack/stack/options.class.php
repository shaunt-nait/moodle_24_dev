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
 * Options enable a context to be set for each question, and information
 * made generally available to other classes.
 *
 * @copyright  2012 The University of Birmingham
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class stack_options {

    private $options;

    public function __construct($settings = array()) {

        // OptionType can be: boolean, string, html, list.
        $this->options  = array( // Array of public class settings for this class.
            'display'   =>  array(
                'type'       =>  'list',
                'value'      =>  'LaTeX',
                'strict'     =>  true,
                'values'     =>  array('LaTeX', 'MathML', 'String'),
                'caskey'     =>  'OPT_OUTPUT',
                'castype'    =>  'string',
             ),
            'multiplicationsign'   =>  array(
                'type'       =>  'list',
                'value'      =>  'dot',
                'strict'     =>  true,
                'values'     =>  array('dot', 'cross', 'none'),
                'caskey'     =>  'make_multsgn',
                'castype'    =>  'fun',
            ),
            'complexno'   =>  array(
                'type'       =>  'list',
                'value'      =>  'i',
                'strict'     =>  true,
                'values'     =>  array('i', 'j', 'symi', 'symj'),
                'caskey'     =>  'make_complexJ',
                'castype'    =>  'fun',
            ),
            'inversetrig'   =>  array(
                'type'       =>  'list',
                'value'      =>  'cos-1',
                'strict'     =>  true,
                'values'     =>  array('cos-1', 'acos', 'arccos'),
                'caskey'     =>  'make_arccos',
                'castype'    =>  'fun',
            ),
            'floats'   =>  array(
                'type'       =>  'boolean',
                'value'      =>  1,
                'strict'     =>  true,
                'values'     =>  array(),
                'caskey'     =>  'OPT_NoFloats',
                'castype'    =>  'ex',
            ),
            'sqrtsign'   =>  array(
                'type'       =>  'boolean',
                'value'      =>  true,
                'strict'     =>  true,
                'values'     =>  array(),
                'caskey'     =>  'sqrtdispflag',
                'castype'    =>  'ex',
            ),
            'simplify'   =>  array(
                'type'       =>  'boolean',
                'value'      =>  true,
                'strict'     =>  true,
                'values'     =>  array(),
                'caskey'     =>  'simp',
                'castype'    =>  'ex',
            ),
            'assumepos'   =>  array(
                'type'       =>  'boolean',
                'value'      =>  false,
                'strict'     =>  true,
                'values'     =>  array(),
                'caskey'     =>  'assume_pos',
                'castype'    =>  'ex',
            ),
        );

        if (!is_array($settings)) {
            throw new stack_exception('stack_options: $settings must be an array.');
        }

        // Overright them from any input.
        foreach ($settings as $key => $val) {
            if (!array_key_exists($key, $this->settings)) {
                throw new stack_exception('stack_options construct: $key '.$key.' is not a valid option name.');
            } else {
                $this->options[$key] = $val;
            }
        }
    }

    public function set_site_defaults() {
        $stackconfig = stack_utils::get_config();
        // Display option does not match up to $stackconfig->mathsdisplay).
        $this->set_option('multiplicationsign', $stackconfig->multiplicationsign);
        $this->set_option('complexno', $stackconfig->complexno);
        $this->set_option('inversetrig', $stackconfig->inversetrig);
        $this->set_option('floats', (bool) $stackconfig->inputforbidfloat);
        $this->set_option('sqrtsign', (bool) $stackconfig->sqrtsign);
        $this->set_option('simplify', (bool) $stackconfig->questionsimplify);
        $this->set_option('assumepos', (bool) $stackconfig->assumepositive);
        return true;
    }

    /*
     * This function validates the information.
     */
    private function validate_key($key, $val) {
        if (!array_key_exists($key, $this->options)) {
            throw new stack_exception('stack_options set_option: $key '.$key.' is not a valid option name.');
        }
        $optiontype = $this->options[$key]['type'];
        switch($optiontype) {
            case 'boolean':
                if (!is_bool($val)) {
                    throw new stack_exception('stack_options: set: boolean option '.$key.' Recieved non-boolean value '.$val);
                }
                break;

            case 'list':
                if (!in_array($val, $this->options[$key]['values'])) {
                    throw new stack_exception('stack_options set option '.$val.' for '.$key.' is invalid');
                }
                break;
        }
        return true;
    }

    public function get_option($key) {
        if (!array_key_exists($key, $this->options)) {
            throw new stack_exception('stack_options get_option: $key '.$key.' is not a valid option name.');
        } else {
            return $this->options[$key]['value'];
        }
    }

    public function set_option($key, $val) {
        $this->validate_key($key, $val); // Throws an exception on error.
        $this->options[$key]['value'] = $val;
    }

    public function get_cas_commands() {

        $names = '';
        $commands = '';

        foreach ($this->options as $key => $opt) {
            if (null!=$opt['castype']) {
                if ('boolean'===$opt['type']) {
                    if ($opt['value']) {
                        $value = 'true';
                    } else {
                        $value = 'false';
                    }
                } else {
                    $value = $opt['value'];
                }

                if ('ex' == $opt['castype']) {
                    $names      .= ', '.$opt['caskey'];
                    $commands   .= ', '.$opt['caskey'].':'.$value;
                } else if ('fun' == $opt['castype']) {
                    // Make sure these options are *strings*, otherwise they clash
                    // with Maxim names, particularly alias.
                    $commands   .= ', '.$opt['caskey'].'("'.$value.'")';
                }
            }
        }
        $ret = array('names'=>$names, 'commands'=>$commands);
        return $ret;
    }
}
