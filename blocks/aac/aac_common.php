
<?php
function ShowPostBackForm($errored, $errorMessage,  $title, $shortName, $incidentNumber)
{
    
    if($errored  != "1")
    {    
        $html .= '      <h1 class="large_gear">' .$title. '</h1>';
        $html .= '      <div style="font-size:13pt"><label>Course:</label> ' .$shortName. '<b></b></div>';
        if($incidentNumber != null)
        {
            $html .= '  <p>Ticket <b>' .$incidentNumber. '</b> has been created. You should recieve an email shortly.</p>';
        }
        else
        {
            $html .= '      <p  style="margin-top:10px;font-size:13pt">The request has been submitted.</p>';
        }
    }
    else
    {        
        $html .=  '<h1>error</h1>';
        $html .=  '<p>Requested failed.</p>';
        $html .=  '<p>Server Error Message:' .$errorMessage.  '</p>';
        $html .=  '<p>Please email the help desk at <a href="mailto:helpline@nait.ca">helpline@nait.ca</a>.</p>';
    }
    $html .= '      <a class="btnCancel" href="/">ok</a>';  
    $html .= '  </div>';
    
    return $html;
}
function get_ws_client(){
    global $CFG;
	$client = new SoapClient( $CFG->academicToolsURL. "/Services/ServiceRequestServices.svc?singleWsdl");
    return $client;
}
function getEndOfFormAAC()
{
    $html = '<h3>What happens when I submit this form?</h3>';
    $html .= '<ol>';
    $html .= '    <li>When you submit this form, a request is created in the Academic Tools LMS Administration system. This is the same system that your Local Area Expert uses to administer your courses.</li>'; 
    $html .= '    <li>The Academic Tools LMS Administration system will process your request removing you from this course in Moodle. It may take several minutes.</li>';
    $html .= '    <li>You will be notified when the request is complete via email.</li>';
    $html .= '</ol>';
    $html .= '<img src="removemechart.png"/>';  

    return $html;
}

?>

