<?php
    session_start();
    if(isset($_SESSION['registration_ok'])==false)
    {
        header('Location:index.php');
        exit();
    }
    else
    {
        unset($_SESSION['registration_ok']);
    }
    if(isset($_SESSION['f_login'])) unset($_SESSION['f_login']);
    if(isset($_SESSION['f_mail'])) unset($_SESSION['f_mail']);
    if(isset($_SESSION['f_regulations'])) unset($_SESSION['f_regulations']);
    if(isset($_SESSION['e_login'])) unset($_SESSION['e_login']);
    if(isset($_SESSION['e_mail'])) unset($_SESSION['e_mail']);
    if(isset($_SESSION['e_password'])) unset($_SESSION['e_password']);
    if(isset($_SESSION['e_regulations'])) unset($_SESSION['e_regulations']);
    if(isset($_SESSION['e_bot'])) unset($_SESSION['e_bot']);
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatibile" content="IE=edge,chrome=1"/>
    <title>Opinie</title>
</head>
<body>
Dziękujemy z rejestracje w serwisie. Możesz zalogować się na swoje konto <br/><br/>
<a href="index.php">Zaloguj się na swoje konto </a>
<br/><br/>
</body>
</html>