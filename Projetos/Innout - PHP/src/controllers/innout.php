<?php
session_start();
requireValidSession();
loadModel('WorkingHours');
$records = WorkingHours::loadFromUserAndDate($_SESSION['user']['id'],date('Y-m-d'));
$currentTime = strftime('%H:%M:%S',time());
$records->innout($currentTime);
header('Location: day_records.php');