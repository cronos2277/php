<?php
session_start();
requireValidSession();
$currentDate = new DateTime();
$user = $_SESSION['user'];
$registries = WorkingHours::getMonthlyReport($user->id, new DateTime());

$report = [];
$workDay = 0;
$sumOfWorkedTime = 0;
$lastday = getLastDayOfMonth(($currentDate)->format('d'));
for($day = 1; getLastDayOfMonth($currentDate)->format('d'); $day++){
    $date = $currentDate->format('Y-m').'-'.sprintf('%2d',$day);
    $registry = $registries[$date];
    if(isPastWorkday($date)) $workDay++;
    if($registry){
        $sumOfWorkedTime += $registry->worked_time;
        array_push($report,$registry);
    }else{
        array_push($report,new WorkingHours(
            [
                'work_date' => $date,
                'worked_time' => 0
            ]
        ));
    }
}

$expectedTime = $workDay * DAILY_TIME;
$balance = getTimeStringFromSeconds(abs($sumOfWorkedTime - $expectedTime));
$sign = ($sumOfWorkedTime >= $expectedTime) ? "+" : "-";

loadTemplateView('monthly_report',[
    'report' => $report,
    'sumOfWorkedTime' => $sumOfWorkedTime,
    'balance' => "{$sign}{$balance}"
]);