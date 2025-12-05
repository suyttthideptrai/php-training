<?php

$message = "Hello from PHP!";
echo $message;
function printData($data)
{
    $format = "| %3d | %-15s | %-6s | %-3d |<br>";
    printf($format, "#", "Name", "Sex", "Age");
    foreach ($data as $i => $row)
        {
            printf($format, $i + 1, $row[0], $row[1], $row[2]);
        }
    }
    $csv_value = [["ThanhNT", "male", 20], ["Quylaptrinh", "male", 21], ["Suytthideptrai", "female", 22]];
    printData($csv_value);
?>