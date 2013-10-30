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
 * This script serves plot files that have been saved in the moodledata folder.
 *
 * @copyright  2012 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../../../config.php');
require_once($CFG->libdir . '/filelib.php');


$plot = $CFG->dataroot . '/stack/plots/' . clean_filename(get_file_argument());

if (!is_readable($plot)) {
    header('HTTP/1.0 404 Not Found');
    header('Content-Type: text/plain;charset=UTF-8');
    echo 'File not found';
    die();
}

// Handle If-Modified-Since.
$filedate = filemtime($plot);
if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) &&
        strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $filedate) {
    header('HTTP/1.0 304 Not Modified');
    die();
}
header('Last-Modified: '.gmdate('D, d M Y H:i:s', $filedate).' GMT');

// Type.
header('Content-Type: ' . mimeinfo('type', 'x.png'));
header('Content-Length: ' . filesize($plot));

// Output file.
session_get_instance()->write_close(); // unlock session during file serving.
readfile($plot);
