<?php

function addBusinessDaysToDate(string $date, int $numDays): string
{
    $currDate = new DateTime($date);
    $weekends = [6, 7]; // Saturday and Sunday

    while ($numDays > 0) {
        $currDate->modify('+1 day');
        if (!in_array($currDate->format('N'), $weekends)) {
            $numDays--;
        }
    }

    return $currDate->format('Y-m-d');
}

$date = '2023-03-22'; // Today's date
$numDays = 5; // Add 5 business days

$finalDate = addBusinessDaysToDate($date, $numDays);
echo $finalDate; // Outputs: 2023-03-29 (assuming no holidays in between)