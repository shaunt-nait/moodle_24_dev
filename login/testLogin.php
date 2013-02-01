<?php
require('../config.php');
if ($cancel) {
    redirect(new moodle_url('/'));
}
//HTTPS is required in this page when $CFG->loginhttps enabled
$PAGE->https_required();

/// Check if the user has actually submitted login data to us
$user = authenticate_user_login('localmoodleaccount', 'thisisthepassword');

echo "Local Account: ";

echo ($user == null) ? "Not Ok" : "Ok";

echo "<br/>";

//$user = authenticate_user_login('moodle_tloginpage', 'thisisthepassword');
$user = authenticate_user_login('moodle_eelyn', 'test12345');


echo "AD Account: ";
echo ($user == null) ? "Not Ok" : "Ok";
