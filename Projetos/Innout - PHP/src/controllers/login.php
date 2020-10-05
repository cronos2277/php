<?php
loadModel('Login');

if(count($_POST) > 0){
    $login = new Login($_POST);
    try{
        $user = $login->checkLogin();
        print_r($user);
    }catch(Exception $ex){
        echo 'Falha no Login';
    }
}

loadView('login',$_POST);