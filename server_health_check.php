<?php

require('config.php');
//error_reporting(E_ALL | E_STRICT);

$ok = "<span style='color:green;font-weight:bold'>Ok</span>";
$notOk = "<span style='color:red;font-weight:bold'>Not Ok</span>";

$openMainSpan = "<span style=''>";
$closeMainSpan = "</span>";

echo '<h2>Moodle Service Status</h2>';

echo '<h3>Server: App Node INSERT_APP_NODE_NUMBER</h3>';

/// Check if the user has actually submitted login data to us
$user = authenticate_user_login('localmoodleaccount', 'thisisthepassword');

echo $openMainSpan."Local Account: ".$closeMainSpan;

echo ($user == null) ? $notOk : $ok;


echo "<br/>";
echo "<br/>";

//$user = authenticate_user_login('moodle_tloginpage', 'thisisthepassword');
$user = authenticate_user_login('moodle_eelyn', 'test12345');

echo $openMainSpan."AD Account: ".$closeMainSpan;
echo ($user == null) ? $notOk : $ok;

echo "<br/>";
echo "<br/>";

$test = is_readable($CFG->dataroot);

echo $openMainSpan."Moodle Data Folder Readable: ".$closeMainSpan;
echo ($test == 1) ? $ok : $notOk;

echo "<br/>";
echo "<br/>";

$test = is_writable($CFG->dataroot);

echo $openMainSpan."Moodle Data Folder Writable: ".$closeMainSpan;
echo ($test == 1) ? $ok : $notOk;


//We also need a service checker that will do 2 things in 1
//Create a webservice on AAC that returns a bool. This service calls the moodle webservice 
//and returns true if it can and false if it can't. If this page cannot call the 
//webservice then we know that there is a problem.

echo "<br/>";
echo "<br/>";

$serviceTest = true;

echo $openMainSpan."Academic Tools WebServices [not yet implented]: ".$closeMainSpan;

if( $serviceTest == true)
{
    echo $ok;
    
    echo "<br/>";
    echo "<br/>";

    //check return value from previous call
    $serviceTest = true;

    echo $openMainSpan."Moodle WebServices (via Academic Tools) [not yet implented]: ".$closeMainSpan;

    if( $serviceTest == true)
    {
        echo $ok;
    
        echo "<br/>";
        echo "<br/>";
    }
    else
    {
        echo $notOk;
    }
}
else
{
    echo $notOk;
}

$client;

echo $openMainSpan."Moodle WebServices (local call): ".$closeMainSpan;

try
{
    $options = array("trace" => 1);
                
    $wsdl = $CFG->wwwroot."/wspp/wsdl_pp.php";
    $client = new soapclient($wsdl,$options);
    $result = $client->login('moodle_eelyn','thisisthepassword');
    
    echo $ok;
    
}
catch(Exception $ex)
{
    $message = $ex->getMessage();
    
    //we are not checking for propper credentials, just making sure that the services are operational.
    if( $message == "Invalid username and / or password.")
    {
        echo $ok;
    }
    else
    {
        echo $notOk . ' [message: '.$message.']';
        echo 'Response: '.$client->__getLastResponse();
    }
    
}