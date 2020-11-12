<?php
loadModel('Login');
session_start();
$exception = null;

if(count($_POST) > 0){
    $login = new Login($_POST);
    try{
        $user = $login->checkLogin();
        $_SESSION['user'] = $user;
        header("Location: day_records.php");
    }catch(Exception $ex){
        $exception = $ex;
    }
}

loadView('login',$_POST + ['exception' => $exception]);