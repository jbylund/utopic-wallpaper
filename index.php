<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>
<?php
echo passthru("/usr/bin/python make_title.py ".$_SERVER['HTTP_HOST']);
?>
</title>
<!-- Main style sheets for CSS2 capable browsers -->
<link rel="stylesheet" type="text/css" media="screen" href="https://assets.ubuntu.com/sites/guidelines/css/dev/beta/ubuntu-styles.css" />
<link rel="stylesheet" type="text/css" media="screen" href="https://assets.ubuntu.com/sites/ubuntu/latest/u/css/styles.css" />
<link rel="stylesheet" type="text/css" media="screen and (min-width: 768px)" href="https://assets.ubuntu.com/sites/ubuntu/latest/u/css/global.css" />
<link rel="stylesheet" type="text/css" media="print" href="https://assets.ubuntu.com/sites/ubuntu/latest/u/css/core-print.css" />
<link rel="stylesheet" type="text/css" media="screen" href="local.css" />
<link rel="stylesheet" type="text/css" media="screen" href="css/slimbox2.css" />

<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
<script type="text/javascript" src="src/slimbox2.js"></script>
<script type="text/javascript" src="src/autoload.js"></script>
<script type="text/javascript" src="test.js"></script>

</head>
<body>
<div class="headerwrapper">
  <div class="header">
    <div>
      <?php echo passthru("python make_title.py ".$_SERVER['HTTP_HOST']); ?>
    </div>
  </div>
</div>
<?php
require_once "common.php";
session_start();

function draw_login_button()
{
  if (isset($_SESSION['logged']) && $_SESSION['logged'] )
  {
    echo "          Logout:\n";
    echo '          <a href="logout.php" title="Logout">'."\n".
         '            <img style="vertical-align: bottom; margin: 3px; padding: 0px;" src="https://assets.ubuntu.com/sites/ubuntu/latest/u/img/logos/logo-ubuntu-orange.svg">'."\n".
         '          </a>'."\n";
  }
  else
  {
    echo '          Login with Ubuntu SSO:';
    echo '          <a href="try_auth.php" title="Login">'."\n".
         '            <img style="vertical-align: bottom; margin: 3px; padding: 0px;" src="https://assets.ubuntu.com/sites/ubuntu/latest/u/img/logos/logo-ubuntu-orange.svg">'."\n".
         '          </a>'."\n";
  }
  echo "          <div></div>\n";
}

// seed the randomness, it's very confusing if within a session things are moving around
if(! isset($_SESSION['seed']))
{
  $_SESSION['seed'] = rand();
}

if(isset($_GET["seed"]))
{
  $_SESSION['seed'] = $_GET["seed"];
}

echo '  <div id="wrapper">'."\n".
     '    <div id="leftcontainer">'."\n".
     '      <div id="leftcontents">'."\n";

echo passthru("./filter_photos.py ".$_SERVER['HTTP_HOST']." ".$_SESSION['seed']);

echo '      </div>'."\n".
     '    </div>'."\n".
     '    <div id="rightcontainer">'."\n".
     '      <div id="rightcontents">'."\n".
     '        <div id="rightinner">'."\n";
draw_login_button();
echo passthru("python make_drop_targets.py");
echo '        </div>'."\n".
     '      </div>'."\n".
     '    </div>'."\n".
     '  </div>'."\n".
     '  <div class="headerwrapper">'."\n";
echo passthru("cat footer_contents.html");
echo '  </div>'."\n";

?>
</body>
</html>
