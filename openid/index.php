<?php
require_once "common.php";
global $pape_policy_uris;
?>
<html>
  <head><title>PHP OpenID Authentication Example</title></head>
  <body>
    <h1>PHP OpenID Authentication Example</h1>
    <p>
      This example consumer uses the <a
      href="http://github.com/openid/php-openid">PHP
      OpenID</a> library. It just verifies that the URL that you enter
      is your identity URL.
    </p>

    <?php if (isset($msg)) { print "<div class=\"alert\">$msg</div>"; } ?>
    <?php if (isset($error)) { print "<div class=\"error\">$error</div>"; } ?>
    <?php if (isset($success)) { print "<div class=\"success\">$success</div>"; } ?>

    <div id="verify-form">
      <form method="get" action="try_auth.php">
        Identity&nbsp;URL:
        <input type="hidden" name="action" value="verify" />
        <input type="text" name="openid_identifier" value="" />
        <input type="submit" value="Verify" />
      </form>
    </div>
  </body>
</html>
