<?php

// Agustin Nunez 2013
// Access to a PC Windows server and update Cumulus format file reading from HeavyWeather format
$infile='/mnt/ac0n/ProgramData/currdat.lst';
$outfile='/mnt/ac0n/Cumulus/data/EasyWeather.dat';
$tmpfile = tempnam(sys_get_temp_dir(), 'parse.tmp');

while(1){
if (file_exists($infile) && is_readable($infile))
{
//  Filter into temp file currdat.lst without comments lines, to avoid parse errors.
    $fh1 = fopen($infile, 'rb');
    $fh2 = fopen($tmpfile, 'wb');
    while(($line = fgets($fh1)) !== false) {
	if(strpos($line, 'comment') === false) {
	    fputs($fh2, $line);
     	}
    }
    fclose($fh2);
    fclose($fh1);

// $par will held an array of arrays with all parameters
    $par=parse_ini_file($tmpfile, true);

// Debug print currdat.lst array elements:

// print_r($par);  

// EasyWeather.dat format (WUHU template)

// ,%[time2]time_date_international_hms%,%[time2]time_date_international_hms%,,%[humidity_levels]indoor_percent_int%,%[indoor_temperature]deg_C%,%[humidity_levels]outdoor_percent_int%,%[outdoor_temperature]deg_C%,%[dewpoint]deg_C%,%[windchill]deg_C%,,%[pressure_relative]hpa%,%[wind_speed_average]mps%,,%[wind_speed]mps%,,,%[wind_direction]name%,,,,%[rain_1h]mm%,,,,%[rain_total_tweaked]mm%"

//echo ",".date("Y-m-d H:i:s").",".date("Y-m-d H:i:s").",,".$par["indoor_humidity"]["percent"].",".$par["indoor_temperature"]["deg_C"].",".$par["outdoor_humidity"]["percent"].",".$par["outdoor_temperature"]["deg_C"].",".$par["dewpoint"]["deg_C"].",".$par["windchill"]["deg_C"].",,".$par["pressure_relative"]["hpa"].",".$par["wind_speed"]["mps"].",,".$par["wind_speed"]["mps"].",,,".$par["wind_direction"]["name"].",,,,".$par["rain_1h"]["mm"].",,,,".$par["rain_total"]["mm"];

$line=",".date("Y-m-d H:i:s").",".date("Y-m-d H:i:s").",,".$par["indoor_humidity"]["percent"].",".$par["indoor_temperature"]["deg_C"].",".$par["outdoor_humidity"]["percent"].",".$par["outdoor_temperature"]["deg_C"].",".$par["dewpoint"]["deg_C"].",".$par["windchill"]["deg_C"].",,".$par["pressure_relative"]["hpa"].",".$par["wind_speed"]["mps"].",,".$par["wind_speed"]["mps"].",,,".$par["wind_direction"]["name"].",,,,".$par["rain_1h"]["mm"].",,,,".$par["rain_total"]["mm"];

$fh3 = fopen($outfile, 'wb');
fputs($fh3,$line);
fclose($fh3);

} else {
	die("Error: $infile file does not exist or is not readable!");
}
sleep(60);
}

?>
