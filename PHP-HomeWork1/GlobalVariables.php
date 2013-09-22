<?php

$PossibleKinds = array(1 => 'Храна', 2 => 'Дрехи', 3 => 'Месечни Сметки', 4 => 'Други',);
if (file_exists('Products.txt')) {
    $ProductsList = file('Products.txt');
}

$DateArray = array();
foreach ($ProductsList as $ValuesFromFile) {
    
    $AllProducts = explode(';', $ValuesFromFile);
    array_push($DateArray, $AllProducts[0]);
}

$result = array_unique($DateArray);
function CompareTwoDates($a, $b)
{
    $date1=DateTime::createFromFormat('d.m.Y', $a);
    $date2=DateTime::createFromFormat('d.m.Y', $b);
    if ($date1 == $date2) {
        return 0;
    }
    return ($date1 < $date2) ? -1 : 1;
}
usort($result , "CompareTwoDates");
array_unshift($result, 'Без Ограничение');
foreach ($result as $DateValue) {
    $DateFilterValues .= '<option value="'.$DateValue.'">'.$DateValue.'</option>';
}
function DateValidation($DateParams) {
    if (count($DateParams) == 3 && strlen($DateParams[1]) == 2 && strlen($DateParams[0]) == 2 && strlen($DateParams[2]) == 4 &&
            is_numeric($DateParams[1]) && is_numeric($DateParams[0]) && is_numeric($DateParams[2]) && (checkdate($DateParams[1], $DateParams[0], $DateParams[2]))) {
        return TRUE;
    } else {
        return FALSE;
    }
}
?>
