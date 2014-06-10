<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Ubuntu 14.10 (Utopic Unicorn) Wallpaper Contest</title>
<!-- Main style sheets for CSS2 capable browsers -->

<link rel="stylesheet" type="text/css" media="screen" href="https://assets.ubuntu.com/sites/guidelines/css/dev/beta/ubuntu-styles.css" />
<link rel="stylesheet" type="text/css" media="screen" href="https://assets.ubuntu.com/sites/ubuntu/latest/u/css/styles.css" />
<link rel="stylesheet" type="text/css" media="screen and (min-width: 768px)" href="https://assets.ubuntu.com/sites/ubuntu/latest/u/css/global.css" />
<link rel="stylesheet" type="text/css" media="print" href="https://assets.ubuntu.com/sites/ubuntu/latest/u/css/core-print.css" />
<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="src/slimbox2.js"></script>
<script type="text/javascript" src="src/autoload.js"></script>
<link rel="stylesheet" href="css/slimbox2.css" type="text/css" media="screen" />

</head>
<body>
<div id="pageWrapper">
<?php
require_once "common.php";
session_start();

// seed the randomness, it's very confusing if within a session things are moving around
if(! isset($_SESSION['seed']))
{
  $_SESSION['seed'] = rand();
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
echo passthru("./filter_photos.py ".$_SESSION['seed'])
?>
</div>
</body>
</html>
