<?php

require_once('../../../config.php');

require_once('add_test_students.php');

$courseid = $_GET["courseid"];
$userName = $USER->username;

AddStudentsToCourse($courseid,$userName);


