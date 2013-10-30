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


require_once(dirname(__FILE__) . '/stack/mathsoutput/mathsoutput.class.php');


/**
 * Base class for all the types of exception we throw.
 */
class stack_exception extends moodle_exception {
    public function __construct($error) {
        parent::__construct('exceptionmessage', 'qtype_stack', '', $error);
    }
}

/**
 * You need to call this method on the string you get from
 * $castext->get_display_castext() before you echo it. This ensures that equations
 * are displayed properly.
 * @param string $castext the result of calling $castext->get_display_castext().
 * @return string HTML ready to output.
 */
function stack_ouput_castext($castext) {
    return format_text(stack_maths::process_display_castext($castext));
}

/**
 * Equivalent to get_string($key, 'qtype_stack', $a), but this method ensure that
 * any equations in the string are displayed properly.
 * @param string $key the string name.
 * @param mixed $a (optional) any values to interpolate into the string.
 * @return string the language string
 */
function stack_string($key, $a = null) {
    return stack_maths::process_lang_string(get_string($key, 'qtype_stack', $a));
}

 /**
  * Translates a string taken as output from Maxima.
  *
  * This function takes a variable number of arguments, the first of which is assumed to be the identifier
  * of the string to be translated.
  */
function stack_trans() {
    $nargs = func_num_args();

    if ($nargs>0) {
        $arg_list = func_get_args();
        $identifier = func_get_arg(0);
        $a = array();
        if ($nargs>1) {
            for ($i=1; $i<$nargs; $i++) {
                $index=$i-1;
                $a["m{$index}"] = func_get_arg($i);
            }
        }
        $return = stack_string($identifier, $a);
        echo $return;
    }
}

function stack_maxima_translate($rawfeedback) {

    if (strpos($rawfeedback, 'stack_trans') === false) {
        return trim($rawfeedback);
    } else {
        $rawfeedback = str_replace('[[', '', $rawfeedback);
        $rawfeedback = str_replace(']]', '', $rawfeedback);
        $rawfeedback = str_replace('\n', '', $rawfeedback);
        $rawfeedback = str_replace('\\', '\\\\', $rawfeedback);
        $rawfeedback = str_replace('!quot!', '"', $rawfeedback);

        ob_start();
        eval($rawfeedback);
        $translated = ob_get_contents();
        ob_end_clean();

        return trim($translated);
    }
}

function stack_maxima_format_casstring($str) {
    return html_writer::tag('span', $str, array('class' => 'stacksyntaxexample'));
}

/**
 * Used by the questiontest*.php scripts, and deploy.php, to do some initialisation
 * that is needed on all of them.
 * @return array page context, selected seed (or null), and URL parameters.
 */
function qtype_stack_setup_question_test_page($question) {
    global $PAGE;

    $seed = optional_param('seed', null, PARAM_INT);
    $urlparams = array('questionid' => $question->id);
    if (!is_null($seed) && $question->has_random_variants()) {
        $urlparams['seed'] = $seed;
    }

    // Were we given a particular context to run the question in?
    // This affects things like filter settings, or forced theme or language.
    if ($cmid = optional_param('cmid', 0, PARAM_INT)) {
        $cm = get_coursemodule_from_id(false, $cmid);
        require_login($cm->course, false, $cm);
        $context = context_module::instance($cmid);
        $urlparams['cmid'] = $cmid;

    } else if ($courseid = optional_param('courseid', 0, PARAM_INT)) {
        require_login($courseid);
        $context = context_course::instance($courseid);
        $urlparams['courseid'] = $courseid;

    } else {
        require_login();
        $context = $question->get_context();
        $PAGE->set_context($context);
        // Note that in the other cases, require_login will set the correct page context.
    }

    return array($context, $seed, $urlparams);
}
