<?php
DEFINE("ARRIVAL",1);
DEFINE("DEPARTURE",0);

$input = fopen("input.txt",'r');
$output = fopen("output.txt", 'w');

$format = 'd.m.Y_H:i:sT';

$flightsNumber = fgets($input);

for($i=0; $i<$flightsNumber; $i++){
    $currentFlight = fgets($input);
    $unixFlightTime = [];
    $infoAboutFlight = explode(" ", $currentFlight);
    for($j=0;$j<count($infoAboutFlight);$j=$j+2) {
        $date = DateTime::createFromFormat($format,
                                     $infoAboutFlight[$j] . parseToRightForm($infoAboutFlight[$j+1]),
                                            new DateTimeZone('UTC'));
        array_push($unixFlightTime, $date->format("U"));
    }
    fwrite($output,$unixFlightTime[ARRIVAL]-$unixFlightTime[DEPARTURE]."\n");
}

fclose($input);
fclose($output);

echo "<h1>Загляните в файл output.txt</h1>";

function parseToRightForm($timezone){
    if ($timezone>=0){
        return "+".(int)$timezone;
    }
    else
        return (int)$timezone;
}