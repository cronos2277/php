<?php
function requireValidSession($requiresAdmin = false){
    
    if(!isset($_SESSION['user'])){
        header("Location: login.php");
        exit();
    }else if($requiresAdmin && !$_SESSION['user']->is_admin){
        addErrorMsg('Acesso negado!');
        header("Location: day_records.php");
        exit();
    }
}