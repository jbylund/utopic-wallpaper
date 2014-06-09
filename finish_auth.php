<?php
require_once "common.php";
session_start();

function escape($thing) {
  return htmlentities($thing);
}

function run() 
{
  $consumer = getConsumer();

  // Complete the authentication process using the server's response.
  $return_to = getReturnTo();
  $response = $consumer->complete($return_to);

  // Check the response status.
  if ($response->status == Auth_OpenID_CANCEL)
  {
    $msg = 'Verification cancelled.'; // This means the authentication was cancelled.
  }
  else if ($response->status == Auth_OpenID_FAILURE)
  {
    $msg = "OpenID authentication failed: " . $response->message; // Authentication failed; display the error message.
  }
  else if ($response->status == Auth_OpenID_SUCCESS)
  {
    // This means the authentication succeeded; extract the identity URL and Simple Registration data (if it was returned).
    $openid = $response->getDisplayIdentifier();
    $esc_identity = escape($openid);

    $success = sprintf('You have successfully verified <a href="%s">%s</a> as your identity.<br>', $esc_identity, $esc_identity);

    if ($response->endpoint->canonicalID)
    {
      $escaped_canonicalID = escape($response->endpoint->canonicalID);
      $success .= '  (XRI CanonicalID: '.$escaped_canonicalID.') ';
    }

    $sreg_resp = Auth_OpenID_SRegResponse::fromSuccessResponse($response);

    $sreg = $sreg_resp->contents();

    foreach (array("email","nickname","fullname") as &$field)
    {
      if (@$sreg[$field])
      {
        $success .= "You returned '".escape($sreg[$field])."' as your ".$field.".<br>";
        $_SESSION[$field] = escape($sreg[$field]);
      }
    }
    $_SESSION['logged'] = TRUE;
#    header("Location: index.php"); // Modify to go to the page you would like
    header("Location: /"); // Modify to go to the page you would like
  }
}

run();

?>
