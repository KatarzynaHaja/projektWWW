<?php
    session_start();
    if(!isset($_SESSION['is_log']))
    {
        header('Location:index.php');
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
<?php
    echo "<p> Witaj  ".$_SESSION['user']."  Logowanie powiodło się"."<br/>";
    echo '<a href ="logout.php">Wyloguj się</a></p>';
?>

</body>
</html>
