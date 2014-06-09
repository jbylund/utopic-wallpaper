<?php
session_start();
session_destroy();
header("Location: /"); // Modify to go to the page you would like
?>
