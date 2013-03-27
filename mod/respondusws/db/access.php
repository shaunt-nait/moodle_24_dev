<?php
///////////////////////////////////////////////////////////////////////////////
// Respondus 4.0 Web Service Extension For Moodle
// Copyright (c) 2009-2011 Respondus, Inc.  All Rights Reserved.
// Date: March 08, 2013
defined("MOODLE_INTERNAL") || die();
$capabilities = array(
	"mod/respondusws:addinstance" => array(
	  "captype" => "write",
	  "contextlevel" => CONTEXT_COURSE,
	  "archetypes" => array(
	    "guest" => CAP_PROHIBIT,
		"student" => CAP_PROHIBIT,
		"teacher" => CAP_PROHIBIT,
		"editingteacher" => CAP_PROHIBIT,
		"manager" => CAP_PROHIBIT
	  )
	) 
);
