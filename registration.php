<?php
    session_start();
    if(isset($_POST['mail']))
    {
        $all_ok = true;
        // Check login
        $login = $_POST['login'];
        if (strlen($login)<3 || strlen($login)>20)
        {
            $all_ok = false;
            $_SESSION['e_login'] = 'Login musi posiadać od 3 do 20 znaków';
        }

        if(ctype_alnum($login)==false)
        {
            $all_ok = false;
            $_SESSION['e_login'] = 'Login może składać się tylko z liter i cyfr bez polskich znaków';

        }

        //Check e-mail
        $mail = $_POST['mail'];
        $mail_clear = filter_var($mail,FILTER_SANITIZE_EMAIL);
        if(filter_var($mail_clear,FILTER_VALIDATE_EMAIL) == false || $mail != $mail_clear)
        {
            $all_ok = false;
            $_SESSION['e_mail'] = "Niepoprawny e-mail";
        }

        // Check password

        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];

        if(strlen($password1)<6 || strlen($password1)>20)
        {
            $all_ok = false;
            $_SESSION['e_password'] = " Hasło musi posiadać od 6 do 20 znaków";
        }

        if ($password1 != $password2)
        {
            $all_ok = false;
            $_SESSION['e_password'] = " Hasła muszą być takie same";
        }

        if($all_ok == true)
        {
            echo "Udana rejestracja";
            exit();
        }
    }

?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatibile" content="IE=edge,chrome=1"/>
    <title>Opinie - rejestracja</title>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <style>
        .error
        {
            color:red;
            margin-top:10px;
            margin-bottom:10px;
        }
    </style>
</head>
<body>
<form method="post">
    <br/><br/>

    Login:<br>
    <input type="text" name="login"/><br/>
    <?php
        if(isset($_SESSION['e_login']))
        {
            echo '<div class ="error">'.$_SESSION['e_login'].'</div>';
            unset($_SESSION['e_login']);
        }

    ?>

    E-mail:<br>
    <input type="text" name="mail"/><br/>

    <?php
    if(isset($_SESSION['e_mail']))
    {
        echo '<div class ="error">'.$_SESSION['e_mail'].'</div>';
        unset($_SESSION['e_mail']);
    }

    ?>


    Twoje hasło:<br>
    <input type="password" name="password1"/><br/>

    <?php
    if(isset($_SESSION['e_password']))
    {
        echo '<div class ="error">'.$_SESSION['e_password'].'</div>';
        unset($_SESSION['e_password']);
    }

    ?>

    Powtórz hasło:<br>
    <input type="password" name="password2"/><br/>


    <label>
    <input type="checkbox"/> Akceptuję regulamin <br/><br/>
    </label>

    <div class="g-recaptcha" data-sitekey="6LfFyxwUAAAAAGtZgBdxDbGstYuDFz34dAEscOTL"></div><br/>

    <input type="submit" value="Zarejestruj się"/>



</form>
</body>
</html>