<?php

if (isset($_POST['cancel']))
    header("Location: index.php");

    $salt = 'Ja_sqAXF^%';
    $stored_hash = '17b1927e658a6ccc5d2861105bf77dd1'; #password is "php123"

    session_start();

if (isset($_POST['login']))
{
    if (strlen($_POST['email'] < 1 || $_POST['pass'] < 1)){
       $_SESSION['error'] = "User name and password are required";
        header("Location: login.php");
        return;
    }
       else if (!str_contains($_POST['email'], '@')){
        $_SESSION['error'] = "Email must have an at-sign (@)";
        header("Location: login.php");
        return;
    }
    else 
    {
        $check = hash('md5', $salt . $_POST['pass']);
        if ($stored_hash == $check)
        {
            $_SESSION['name'] = $_POST['email'];
            error_log("Login success ".$_POST['email']);
            header("Location: index.php");
            return;
        }
        else
        {
            $_SESSION['error'] = "Incorrect password";
            error_log("Login fail ".$_POST['email']);
            header("Location: login.php");
            return;
            
        }
    }

}

?>
<html>
    <head>
        <title>kusay varde</title>
    </head>
    <body>
        <h1>Please Log In</h1>
        <?php
        if ( isset($_SESSION['error']) ) {
            echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
            unset($_SESSION['error']);
        }
        ?>
        <form method="post">
        <p>Email <input name="email" type="text"></p>
        <p>Password <input name="pass" type="text"></p>
        <input type="submit" name="login" value="Log In">
        <input type="submit" name="cancel" value="Cancel">

        </form>
    </body>
</html>