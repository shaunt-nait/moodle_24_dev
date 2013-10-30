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
 * "key=value" class to parse user-entered data into CAS sessions.
 *
 * @copyright  2012 University of Birmingham
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class stack_cas_keyval {

    /** @var Holds the raw text as entered by a question author. */
    private $raw;

    /** @var stack_cas_session */
    private $session;

    /** @var bool */
    private $valid;

    /** @var bool has this been sent to the CAS yet? */
    private $instantiated;

    /** @var string HTML error message that can be displayed to the user. */
    private $errors;

    /** @var string 's' or 't' for student or teacher security level. */
    private $security;

    /** @var bool whether to insert *s where there are implied multipliations. */
    private $insertstars;

    /** @var bool if true, apply strict syntax checks. */
    private $syntax;

    public function __construct($raw, $options = null, $seed=null, $security='s', $syntax=true, $stars=false) {
        $this->raw          = $raw;
        $this->security     = $security;
        $this->insertstars  = $stars;
        $this->syntax       = $syntax;

        $this->session      = new stack_cas_session(null, $options, $seed);

        if (!is_string($raw)) {
            throw new stack_exception('stack_cas_keyval: raw must be a string.');
        }

        if (!('s'===$security || 't'===$security)) {
            throw new stack_exception('stack_cas_keyval: 2nd argument, security level, must be "s" or "t" only.');
        }

        if (!is_bool($syntax)) {
            throw new stack_exception('stack_cas_keyval: 3 argument, syntax, must be boolean.');
        }

        if (!is_bool($stars)) {
            throw new stack_exception('stack_cas_keyval: 6th argument, stars, must be boolean.');
        }
    }

    private function validate() {
        if (empty($this->raw) or '' == trim($this->raw)) {
            $this->valid = true;
            return true;
        }

        // CAS keyval may not contain @ or $.
        if (strpos($this->raw, '@') !== false || strpos($this->raw, '$') !== false) {
            $this->errors = stack_string('illegalcaschars');
            $this->valid = false;
            return false;
        }

        $str = stack_utils::remove_comments(str_replace("\n", '; ', $this->raw));
        $str = str_replace(';', "\n", $str);
        $kv_array = explode("\n", $str);

        // 23/4/12 - significant changes to the way keyvals are interpreted.  Use Maxima assignmentsm i.e. x:2.
        $errors  = '';
        $valid   = true;
        $vars = array();
        foreach ($kv_array as $kvs) {
            $kvs = trim($kvs);
            if ('' != $kvs) {
                $cs = new stack_cas_casstring($kvs);
                $cs->validate($this->security, $this->syntax, $this->insertstars);
                $vars[] = $cs;
            }
        }

        $this->session->add_vars($vars);
        $this->valid       = $this->session->get_valid();
        $this->errors      = $this->session->get_errors();
    }

    public function get_valid() {
        if (null===$this->valid) {
            $this->validate();
        }
        return $this->valid;
    }

    public function get_errors($casdebug=false) {
        if (null===$this->valid) {
            $this->validate();
        }
        if ($casdebug) {
            return $this->errors.$this->session->get_debuginfo();
        }
        return $this->errors;
    }

    public function instantiate() {
        if (null===$this->valid) {
            $this->validate();
        }
        if (!$this->valid) {
            return false;
        }
        $this->session->instantiate();
        $this->instantiated = true;
    }

    public function get_session() {
        if (null===$this->valid) {
            $this->validate();
        }
        return $this->session;
    }

}
