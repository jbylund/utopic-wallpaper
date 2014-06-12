<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
<head>
  <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
  <title>
    <?php
      echo passthru("./make_title.py ".$_SERVER['HTTP_HOST']);
    ?>
  </title>
  <link href="test.css" media="screen" rel="stylesheet" type="text/css">
  <script src="https://code.jquery.com/jquery-2.1.1.min.js" type=
  "text/javascript"></script>
  <script src="test.js" type="text/javascript"></script>
</head>

<body>
  <div id="headerwrapper">
    <div id="header">
      <div>
        <?php echo passthru("python make_title.py ".$_SERVER['HTTP_HOST']); ?>
      </div>
    </div>
  </div>
  <div id="wrapper">
    <div id="leftcontainer">
      <div id="leftcontents">
        <?php
          
        ?>
      </div>
    </div>

    <div id="rightcontainer">
      <div id="rightcontents">
        <div id="rightinner">
          <?php

          ?>
        </div>
      </div>
    </div>
  </div>
  <div id="footer">
    Footer
  </div>
</body>
</html>
