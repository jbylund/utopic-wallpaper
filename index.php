<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Ubuntu 14.10 (Utopic Unicorn) Wallpaper Contest</title>
<!-- Main style sheets for CSS2 capable browsers -->

<link rel="stylesheet" type="text/css" media="screen" href="https://assets.ubuntu.com/sites/guidelines/css/dev/beta/ubuntu-styles.css" />
<link rel="stylesheet" type="text/css" media="screen" href="https://assets.ubuntu.com/sites/ubuntu/1072/u/css/styles.css" />
<link rel="stylesheet" type="text/css" media="screen and (min-width: 768px)" href="https://assets.ubuntu.com/sites/ubuntu/latest/u/css/global.css" />
<link rel="stylesheet" type="text/css" media="print" href="https://assets.ubuntu.com/sites/ubuntu/1072/u/css/core-print.css" />


</head>
<body>
<div id="pageWrapper">
<?php
require_once "common.php";
session_start();

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
echo passthru("./filter_photos.py")
?>
</div>
</body>
</html>
