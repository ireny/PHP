<?php
$htmlTitle = 'Изтриване на елемент';
include 'header.php';
$LineNumber=$_POST['indexForDelete'];
unset($ProductsList[$LineNumber]);
file_put_contents('Products.txt', '');
            foreach ($ProductsList as $FianlValue) {
                file_put_contents('Products.txt', $FianlValue, FILE_APPEND);
            }
            header('location: index.php');
?>
