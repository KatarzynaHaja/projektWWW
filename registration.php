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

        //Hash password

        $hashed_password = password_hash($password1,PASSWORD_DEFAULT);

        // Check if checkbox tick

        if(isset($_POST['regulations'])==false)
        {
            $all_ok = false;
            $_SESSION['e_regulations'] = "Potwierdź akceptacje regulaminu";
        }

        //Bot or not

        $secret_key = "6LfFyxwUAAAAAMYycH7IbrEhQApjh-li31pWqZIn";
        $check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$_POST['g-recaptcha-response']);

        $answer = json_decode($check);

        if($answer->success == false)
        {
            $all_ok = false;
            $_SESSION['e_bot'] = "Potwierdź, że nie jesteś botem";

        }
        //Remember date
        $_SESSION['f_login'] = $login;
        $_SESSION['f_mail'] = $mail;
        if(isset($_POST['regulations']))
        {
            $_SESSION['f_regulations'] = true;
        }


        //Check if unique

        require_once "connection.php";

        mysqli_report(MYSQLI_REPORT_STRICT);
        try
        {
            $connection = new mysqli($host,$db_user,$db_password,$db_name);
            if($connection->errno!=0)
            {
                throw new Exception(mysqli_connect_errno());
            }
            else
            {
                // if e- mail exist
                $result = $connection->query("SELECT id FROM users WHERE mail='$mail'");
                if($result == false)
                {
                    throw new Exception($connection->error);
                }
                else
                {
                    $numbers_mail = $result->num_rows;
                    if($numbers_mail > 0)
                    {
                        $all_ok = false;
                        $_SESSION['e_mail'] = "Taki mail istnieje już w bazie";
                    }
                }
                // if login exist
                $result = $connection->query("SELECT id FROM users WHERE login='$login'");
                if($result == false)
                {
                    throw new Exception($connection->error);
                }
                else
                {
                    $numbers_login = $result->num_rows;
                    if($numbers_login > 0)
                    {
                        $all_ok = false;
                        $_SESSION['e_login'] = "Taki login istnieje już w bazie";
                    }
                }
                if($all_ok == true)
                {
                   if($connection->query("INSERT INTO users values(NULL,'$login','$hashed_password','$mail')"))
                   {
                        $_SESSION['registration_ok'] = true;
                        header('Location:welcome.php');
                   }
                   else
                   {
                       throw new Exception($connection->error);
                   }
                }
                $connection->close();
            }
        }
        catch(Exception $e)
        {
            // here we should create own side with errors(404)
            echo "Błąd serwera prosimy o rejestracje w późniejszym terminie!";
            echo '<br/>'.$e;
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
    <input type="text" value ="<?php
        if(isset($_SESSION['f_login']))
        {
            echo $_SESSION['f_login'];
            unset($_SESSION['f_login']);
        }?>" name="login"/><br/>
    <?php
        if(isset($_SESSION['e_login']))
        {
            echo '<div class ="error">'.$_SESSION['e_login'].'</div>';
            unset($_SESSION['e_login']);
        }

    ?>

    E-mail:<br>
    <input type="text" value ="<?php
    if(isset($_SESSION['f_mail']))
    {
        echo $_SESSION['f_mail'];
        unset($_SESSION['f_mail']);
    }?>"  name="mail"/><br/>

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
    <input type="checkbox"  name="regulations" <?php
    if(isset($_SESSION['f_regulations']))
    {
        echo "checked";
        unset($_SESSION['f_regulations']);
    }?> /> Akceptuję regulamin <br/>
    </label>

    <?php
    if(isset($_SESSION['e_regulations']))
    {
        echo '<div class ="error">'.$_SESSION['e_regulations'].'</div>';
        unset($_SESSION['e_regulations']);
    }

    ?>

    <div class="g-recaptcha" data-sitekey="6LfFyxwUAAAAAGtZgBdxDbGstYuDFz34dAEscOTL"></div><br/>

    <?php
    if(isset($_SESSION['e_bot']))
    {
        echo '<div class ="error">'.$_SESSION['e_bot'].'</div>';
        unset($_SESSION['e_bot']);
    }

    ?>

    <input type="submit" value="Zarejestruj się"/>



</form>
</body>
</html>