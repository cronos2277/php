<?php
loadModel('Login');
session_start();
$exception = null;

if(count($_POST) > 0){
    $login = new Login($_POST);
    try{
        $user = $login->checkLogin();                               
        $_SESSION['user'] = $user;
        //$_SESSION['user']['id'] = $user->id;
        //$_SESSION['user']['name'] = $user->name;
        //$_SESSION['user']['password'] = $user->password;
        //$_SESSION['user']['email'] = $user->email;
        //$_SESSION['user']['start_date'] = $user->start_date;
        //$_SESSION['user']['end_date'] = $user->end_date;
        //$_SESSION['user']['is_admin'] = $user->is_admin;                     
        header("Location: day_records.php");
    }catch(Exception $ex){
        $exception = $ex;
    }
}

loadView('login',$_POST + ['exception' => $exception]);