<?php

$settings->add(new admin_setting_configselect('journal/showrecentactivity', get_string('showrecentactivity', 'journal'), 
                                              get_string('showrecentactivity', 'journal'), 0, 
                                              array('0' => get_string('no'), '1' => get_string('yes'))));

