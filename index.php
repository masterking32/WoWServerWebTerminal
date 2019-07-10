<?php
/**
 * @author       Amin Mahmoudi (MasterkinG)
 * @copyright    Copyright (c) 2019 - 2022, MsaterkinG32 Team, Inc. (https://masterking32.com)
 * @link         https://masterking32.com
 * @Github       https://github.com/masterking32/wow-telegram
 * @Description  It's not masterking32 framework !
 */

include 'config.php';
function login()
{
    global $admin_username, $admin_password, $recaptcha_secret, $enable_recaptcha;
    if (!empty($_POST['username']) || !empty($_POST['password'])) {

        if (!empty($enable_recaptcha)) {
            if (empty($_POST["g-recaptcha-response"])) {
                return false;
            }

            $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $recaptcha_secret . "&response=" . $_POST['g-recaptcha-response']);
            $responseKeys = json_decode($response, true);
            if (intval($responseKeys["success"]) !== 1) {
                return false;
            }
        }

        if (strtoupper($admin_username) == strtoupper($_POST['username']) && $admin_password == $_POST['password']) {
            $_SESSION["CM_Login"] = 1;
            header('location:./terminal.php');
            exit();
        }
        return false;
    }
}

if (!empty($_SESSION["CM_Login"])) {
    header('location:./terminal.php');
    exit();
}
login();
?>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="chrome=1"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Terminal Control</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        body {
            font-family: 'Raleway', sans-serif;
            background-image: url(https://api.masterking32.com/random_bg.php?wow);
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: 100% 100%;
            margin-bottom: 80px;
        }

        .text-center {
            text-align: center;
        }

        .g-recaptcha {
            display: inline-block;
        }
    </style>
<body>
<div style='margin: 10% auto; width:350px; background-color: rgba(255,255,255,0.8); padding:10px; border-radius:5px;text-align:center;'>
    <h3>Login Panel</h3>
    <form action='' method='POST'>
        <input type='text' name='username' placeholder='Username'
               style='font-family: "Raleway", sans-serif;background-color: rgba(255,255,255,0.8); border:none;padding:5px; border-radius:5px; width:100%;'>
        <input type='password' name='password' placeholder='Password'
               style='font-family: "Raleway", sans-serif;background-color: rgba(255,255,255,0.8); border:none;padding:5px; border-radius:5px; width:100%;margin-top:5px;'>
        <?php
        if (!empty($enable_recaptcha)) {
            echo '<div class="g-recaptcha" data-sitekey="' . $recaptcha_key . '" style=\'margin:10px auto\'></div>';
        }
        ?>
        <input type='submit' value='Login'
               style='color:#fff;font-family: "Raleway", sans-serif;background-color: rgba(0, 199, 116,0.8); border:none;padding:5px; border-radius:5px; width:100%;margin-top:5px;'>
    </form>
    <hr style='border:1px solid rgba(255,255,255,0.4)'>
    Designed by <a href='https://masterking32.com' target="_BLANK" style='color:#1a1a1a;'>MasterkinG32.CoM</a>
</div>
</body>
</html>