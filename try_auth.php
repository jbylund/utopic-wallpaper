<?php
require_once "common.php";
session_start();

function run()
{
  $openid = "https://login.ubuntu.com/+openid";
  $consumer = getConsumer();

  // Begin the OpenID authentication process.
  $auth_request = $consumer->begin($openid);

  $required_vars = array('nickname', 'fullname', 'email');
  $opt_vars = array();
  $sreg_request = Auth_OpenID_SRegRequest::build($required_vars, $opt_vars);

  if ($sreg_request)
  {
    $auth_request->addExtension($sreg_request);
  }

  $policy_uris = null;
  if (isset($_GET['policies']))
  {
    $policy_uris = $_GET['policies'];
  }

  // Redirect the user to the OpenID server for authentication.
  // Store the token for this authentication so we can verify the response.

  // For OpenID 1, send a redirect.  For OpenID 2, use a Javascript
  // form to send a POST request to the server.
 
  // Generate form markup and render it.
  $form_id = 'openid_message';
#  file_put_contents('/tmp/logfile',"redir-ing to: ".getReturnTo()."\n", FILE_APPEND | LOCK_EX);
  $form_html = $auth_request->htmlMarkup(getTrustRoot(), getReturnTo(), false, array('id' => $form_id));

  // Display an error if the form markup couldn't be generated; otherwise, render the HTML.
  if (Auth_OpenID::isFailure($form_html))
  {
    displayError("Could not redirect to server: " . $form_html->message);
  }
  else
  {
    print $form_html;
  }
}

run();

?>
