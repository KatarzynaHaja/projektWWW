<?php
session_start();
if(!isset($_POST['login']) || $_POST['password'])
{
    header('Location:index.php');
    exit();
}
require_once "connection.php";
$connection = new mysqli($host,$db_user,$db_password,$db_name);
if($connection->errno!=0)
{
    echo "Error:".$connection->connect_errno."Opis:".$connection->connect_error;
}
else
{
    $login = $_POST['login'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM Users WHERE login='$login' and password = '$password'";
    if($result = @$connection->query($sql))
    {
        $number_user = $result->num_rows;
        if($number_user > 0)
        {
            $_SESSION[is_log] = true;
            $row = $result->fetch_assoc();
            $_SESSION['id'] = $row['id'];
            $_SESSION['user'] = $row['login'];
            unset($_SESSION['error']);
            $result->close();
            header('Location:panel.php');
        }
        else
        {
            $_SESSION['error'] = '<span style = "color:red">Nieprawidłowy login lub hasło</span>';
            header('Location: index.php');
        }
    }
    $connection->close();
}


?>