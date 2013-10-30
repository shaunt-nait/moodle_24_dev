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
 * Documentation system as a static wiki of markdown.
 *
 * This file serves the contents of a local directory and renders markup to html
 * A file is requested by appending it's path (from the doc root) to doc.php
 * e.g. for /CAS/Maxima.md    request    /doc.php/CAS/Maxima.md
 * Language selection is done automatically.
 *
 * @package stackDoc
 * @author Ben Holmes
 * @copyright  2012 The University of Birmingham
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../../../../config.php');
require_once($CFG->libdir . '/markdown.php');
require_once(dirname(__FILE__) . '/../locallib.php');
require_once(dirname(__FILE__) . '/../stack/utils.class.php');


require_login();

function report($d) {
    global $CFG;
    $dirroot = stack_utils::convert_slash_paths($CFG->dirroot.'/question/type/stack/doc/en');
    $wwwroot = $CFG->wwwroot;
    $webdocs = $wwwroot.'/question/type/stack/doc/en';
    $weburl = $wwwroot.'/question/type/stack/doc/doc.php';
    $a = array();
    $files_linked_to = array();

    if (is_dir($d)) {
        if ($dh = opendir($d)) {
            while (($f = readdir($dh)) !== false) {
                if (substr($f, 0, 1) != '.') {
                    $fpath = "$d/$f";
                    if (filetype($fpath) == 'dir') {
                        $a = array_merge($a, report($fpath));
                    } else {
                        $fname  = pathinfo($fpath, PATHINFO_FILENAME);
                        $fext   = pathinfo($fpath, PATHINFO_EXTENSION);
                        $fsize  = filesize($fpath);
                        $reldir = str_replace($dirroot, '', $d);

                        $a[] = array($fpath, 'F', 'Found file ' . "$fpath");

                        if ($fsize >= 18000) {
                            $a[] = array($fpath, 'W', "Large file ($fsize bytes)");
                        }

                        if ($fext != 'bak') {
                            if ($fext != 'md') {
                                $a[] = array($fpath, 'W', "Not a markdown file ($fext)");
                            }

                            // Let's do some link checking, step one: scrape the links off the document's web page.
                            $links = strip_tags(markdown(file_get_contents($fpath)), "<a>");
                            preg_match_all("/<a(?:[^>]*)href=\"([^\"]*)\"(?:[^>]*)>(?:[^<]*)<\/a>/is", $links, $found);
                            // Found[0] will have the full a tags, found[1] contains their href properties.
                            // Step two, visit these links and check for 404s.
                            foreach ($found[1] as $i => $link) {
                                if (strpos($link, 'mailto:') !== 0
                                    and strpos($link, 'maintenance.php') === false
                                    and (strpos($link, 'http') !== 0)) {
                                    // Don't check mailto:, this file (ARGH!)
                                    // Also if ?ext not true then better not be an external link.
                                    if (strpos($link, 'http') !== 0) {
                                        // If a local link, do some preparation.
                                        if (strpos($link, '/') === 0) {
                                            $link = $webdocs . $link; // Not a relative link.
                                        } else {
                                            $link = $webdocs . rtrim($reldir, '/') . '/' . $link;
                                        }
                                        // It looks like get_headers isn't evaluating these so lets do it manually.
                                        $segs = explode('/', $link);
                                        while (($pos = array_search('.', $segs)) !== false) {
                                            unset($segs[$pos]);
                                        }
                                        while (($pos = array_search('..', $segs)) !== false) {
                                            unset($segs[$pos], $segs[$pos - 1]);
                                        }
                                        $link = implode('/', $segs);

                                        // Finally it looks like #--- are getting parsed in the request, let's ommit them.
                                        if (strpos($link, '#') !== false) {
                                            $link = substr($link, 0, strpos($link, '#'));
                                        }
                                    }
                                    $hs = get_headers($link);
                                    if (strpos($hs[0], '404') !== false) {
                                        $a[] = array($fpath, 'E', 'Error 404 [' . $found[0][$i] . '] appears to be a dead link');
                                    } else {
                                        $files_linked_to[$found[0][$i]] = true;
                                    }
                                    if ('/' == substr($link, -1)) {
                                        $a[] = array($fpath, 'E', 'Link [' . $found[0][$i] .
                                                '] calls a directory.  This should have explicit <tt>index.md</tt> but does not.');
                                    }
                                }
                            }
                        }
                    }
                }
            }
            closedir($dh);
        }
    }

    return $a;
}

?>

<h2>STACK Documentation Maintenance</h2>

<p><a href="doc.php">STACK documentation</a></p>
<p>This script crawls the entire documentation and checks for dead links and other issues.
<pre><?php

$docs = stack_utils::convert_slash_paths($CFG->dirroot.'/question/type/stack/doc/en');
$a = report($docs);

echo "<table>";
foreach ($a as $data) {
    if ('F'!=$data[1]) {
        echo "<tr>";
        echo "<td>".$data[0]."</td>";
        echo "<td>".$data[2]."</td>";
        echo "</tr>";
    }
}
echo "</table>";

?></pre>

<p>Done.</p>
