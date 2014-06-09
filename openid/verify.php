<?php
if(isset($_POST['submit']))
{
    $dbHost = "localhost"; //Location Of Database usually its localhost
    $dbUser = "root";      //Database User Name
    $dbPass = "";          //Database Password
    $dbDatabase = "test_users"; //Database Name

    $db = mysql_connect($dbHost,$dbUser,$dbPass)or die("Error connecting to database.");
    //Connect to the databasse
    mysql_select_db($dbDatabase, $db)or die("Couldn't select the database.");
    //Selects the database

    /*
    The Above code can be in a different file, then you can place include'filename.php'; instead.
    */
    // pw_hash=sha(concat(salt, ":","password"))
    //Lets search the databse for the user name and password
    //Choose some sort of password encryption, I choose sha256
    //Password function (Not In all versions of MySQL).
    $usr = mysql_real_escape_string($_POST['username']);
    $pass = mysql_real_escape_string($_POST['password']);
    $query = "SELECT * FROM test_users.users
        WHERE username='$usr' AND
        pw_hash=sha(concat(salt, \":\",\"$pass\"))
        LIMIT 1";
    $sql = mysql_query($query);
    if(mysql_num_rows($sql) == 1)
    {
        $row = mysql_fetch_array($sql);
        session_start();
        $_SESSION['username'] = $row['username'];
        $_SESSION['fname'] = $row['first_name'];
        $_SESSION['lname'] = $row['last_name'];
        $_SESSION['logged'] = TRUE;
        header("Location: users_page.php"); // Modify to go to the page you would like
        exit;
    }
    else
    {
        header("Location: login_page.php");
        exit;
    }
}
else //If the form button wasn't submitted go to the index page, or login page
{
    header("Location: index.php");
    exit;
}
?>
