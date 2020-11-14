<?php
session_start();
requireValidSession();
loadModel('WorkingHours');
$records = WorkingHours::loadFromUserAndDate($_SESSION['user']->id,date('Y-m-d'));
try{
    $currentTime = strftime('%H:%M:%S',time());
    $records->innout($currentTime);    
    addSuccessMsg('inserido com sucesso!');    
}catch(AppException $e){
    addErrorMsg($e->getMessage());
}

header('Location: day_records.php');