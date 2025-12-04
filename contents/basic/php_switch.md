# Switch PHP

### DEMO
```php
function printDayName($dayNumber) {
    $dayString = '';
    switch ($dayNumber) {
        case 1:
            $dayString = "Mâm đây";
            break;
        case 2:
            $dayString = "Tiêu đây";
            break;
        case 3:
            $dayString = "Quết đây";
            break;
        case 4:
            $dayString = "Thớt đây";
            break;
        case 5:
            $dayString = "Friday";
            break;
        case 6:
            $dayString = "Saturday";
            break;
        case 7:
            $dayString = "Sunday";
            break;
        default:
            echo "Invalid day number";
            return;
    }
    echo $dayString . "<br>";
}

printDayName(3);
printDayName(7);
printDayName(8);
```