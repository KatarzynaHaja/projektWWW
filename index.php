<?php
    session_start();
    if(isset($_SESSION['is_log']) && $_SESSION['is_log'] == true)
    {
        header('Location:panel.php');
        exit();
    }
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatibile" content="IE=edge,chrome=1"/>
    <title>Opinie</title>
</head>
<body>

<a href="registration.php">Zarejestruj się </a>
<form action="login.php" method="post">
    <br/><br/>

    Login:<br>
    <input type="text" name="login"/><br/>
    Hasło:<br>
    <input type="password" name="password"/><br/><br/>
    <input type="submit" value="Zaloguj się"/>

</form>
<?php
    if(isset($_SESSION['error']))
    {
        echo $_SESSION['error'];
    }

?>
</body>
</html>