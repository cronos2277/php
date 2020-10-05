<?php
loadModel('Login');
$exception = null;

if(count($_POST) > 0){
    $login = new Login($_POST);
    try{
        $user = $login->checkLogin();
        header("Location: day_records.php");
    }catch(Exception $ex){
        $exception = $ex;
    }
}

loadView('login',$_POST + ['exception' => $exception]);