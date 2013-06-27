<?php

$course = $DB->get_record('course', array('id' => $courseId));

if (!$course) {
    print_error("invalidcourseid");
}
require_login();

$context = get_context_instance(CONTEXT_COURSE, $course->id);
if (!$course->visible and !has_capability('moodle/course:viewhiddencourses', $context)) {
    print_error('coursehidden', '', $CFG->wwwroot .'/');
}

$PAGE->navbar->ignore_active();

$PAGE->set_context($context);
$PAGE->set_pagelayout('course');
$PAGE->set_pagetype('course-view-' . $course->format);
$PAGE->set_url('/mod/acc/aac_course.php', array('id' => $course->id));
$PAGE->set_title($course->shortname.': ' .$title);
$PAGE->set_heading($course->shortname.': ' .$title);
$PAGE->set_course($course);
$PAGE->navbar->add($course->shortname, new moodle_url('/course/view.php?id=' .$courseId));
$PAGE->navbar->add('Manage My Course', new moodle_url('index.php?id=' .$courseId));
$PAGE->navbar->add($title);
echo $OUTPUT->header();

?>

