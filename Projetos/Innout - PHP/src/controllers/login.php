<?php
loadModel('Login');
$exception = null;

if(count($_POST) > 0){
    $login = new Login($_POST);
    try{
        $user = $login->checkLogin();
        print_r($user);
    }catch(Exception $ex){
        $exception = $ex;
    }
}

loadView('login',$_POST + ['exception' => $exception]);