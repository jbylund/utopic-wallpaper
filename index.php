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
<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript" src="src/slimbox2.js"></script>
<script type="text/javascript" src="src/autoload.js"></script>
<link rel="stylesheet" href="css/slimbox2.css" type="text/css" media="screen" />

</head>
<body>
<div id="headerwrapper">
  <div id="header">
    <div>
      <?php echo passthru("python make_title.py ".$_SERVER['HTTP_HOST']); ?>
    </div>
  </div>
</div>
<div id="pageWrapper">
<?php
require_once "common.php";
session_start();

// seed the randomness, it's very confusing if within a session things are moving around
if(! isset($_SESSION['seed']))
{
  $_SESSION['seed'] = rand();
}

if(isset($_GET["seed"]))
{
  $_SESSION['seed'] = $_GET["seed"];
}

function draw_login_button()
{
  if (isset($_SESSION['logged']) && $_SESSION['logged'] )
  {
    echo '<a href="logout.php" title="Logout">
    <img src="https://assets.ubuntu.com/sites/ubuntu/latest/u/img/logos/logo-ubuntu-orange.svg">
    </a>';
  }
  else
  {
    echo '<a href="try_auth.php" title="Login">
    <img src="https://assets.ubuntu.com/sites/ubuntu/latest/u/img/logos/logo-ubuntu-orange.svg">
    </a>';
  }
}

draw_login_button(); 
echo passthru("./filter_photos.py ".$_SERVER['HTTP_HOST']." ".$_SESSION['seed'])
?>
</div>
</body>
</html>



<?php
#  <div id="wrapper">
#    <div id="leftcontainer">
#      <div id="leftcontents">
#        CONTENTS
#      </div>
#    </div>
#    <div id="rightcontainer">
#      <div id="rightcontents">
#        <div id="rightinner">
#          CONTENTS
#        </div>
#      </div>
#    </div>
#  </div>
#  <div id="footer">
#    Footer
#  </div>
?>
