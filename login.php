<?php
    session_start();
    if(!isset($_POST['login']) || !isset($_POST['password']))
    {
        header('Location:index.php');
        exit();
    }
require_once "connection.php";
$connection = @new mysqli($host,$db_user,$db_password,$db_name);
if($connection->errno!=0)
{
    echo "Error:".$connection->connect_errno."Opis:".$connection->connect_error;
}
else
{
    $login = $_POST['login'];
    $password = $_POST['password'];
    $login = htmlentities($login,ENT_QUOTES,"UTF-8");


    if($result = @$connection->query(sprintf("SELECT * FROM Users WHERE login='%s'",
        mysqli_real_escape_string($connection,$login))))
    {
        $number_user = $result->num_rows;
        if($number_user > 0)
        {
            $row = $result->fetch_assoc();

            if(password_verify($password, $row['password']))
            {
                $_SESSION[is_log] = true;
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
        else
        {
            $_SESSION['error'] = '<span style = "color:red">Nieprawidłowy login lub hasło</span>';
            header('Location: index.php');
        }
    }
    $connection->close();
}


?>