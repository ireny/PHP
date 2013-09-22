<?php
$htmlTitle = 'Добавяне на продукт';
include 'header.php';
$currentDate = date('d.m.Y');
$LineNumber = $_POST['indexForEdit'];

if (isset($_POST['indexForEdit'])) {
    $MustBeEdited = true;
}
if ($MustBeEdited) {
    $DataForEdit = explode(';', $ProductsList[$_POST['indexForEdit']]);
    $SubmitValue = 'Редактирай';
    $textValue = $DataForEdit[1];
    $PriceValue = $DataForEdit[2];
    $dateValue = trim($DataForEdit[0]);
} else {
    $SubmitValue = 'Добави';
    $textValue = '';
    $PriceValue = '';
    $dateValue = '';
}
?>
<button><a href="index.php"><b>Списък</b></a></button>
<form method="POST"action="form.php">
    <label for="product">Име:</label>
    <input type="text" name="product" value="<?= $textValue ?>" placeholder="Продукт"><br>
    <label for="price">Сума:</label>
    <input type="text" name="price" value="<?= $PriceValue ?>" placeholder="Цена (0.00)"><br>
    <label for="kinds">Вид:</label>
    <select name="kinds" >
        <?php
        foreach ($PossibleKinds as $key => $val) {
            echo '<option value="' . $key . '">' . $val . '</option>';
        }
        ?>
    </select><br>
    <label for="date">Дата:</label>
    <input type="text" name="date" value="<?= $dateValue ?>" placeholder="<?= $currentDate ?>"><br>
    <?php
    if ($MustBeEdited)
        echo '<input type="hidden" name="LineNumber" value="' . $LineNumber . '">';
    ?>
    <input type="submit" value="<?= $SubmitValue ?>">
</form>
<?php
if ($_POST['kinds']) {
    $ReplaceString = array(';', '<', '>');
    $ProductName = trim(str_replace($ReplaceString, '', $_POST['product']));
    $ProductPrice = trim(str_replace(';', '', $_POST['price']));
    $ProductKind = $_POST['kinds'];
    if (strlen(trim(str_replace(';', '', $_POST['date']))) > 0) {
        $ProductDate = trim(str_replace(';', '', $_POST['date']));
    } else {
        $ProductDate = $currentDate;
    }
    $CorrectInput = TRUE;
    $ErrorMassge = '';
    if (mb_strlen($ProductName) < 3 || mb_strlen($ProductName) > 30) {
        $CorrectInput = FALSE;
        $ErrorMassge = $ErrorMassge . 'Дължината на името трябва да бъде в интервала от 3 до 30 символа!<br>';
    }
    if (!is_numeric($ProductPrice) || $ProductPrice < 0 || $ProductPrice > 1000000) {
        $CorrectInput = FALSE;
        $ErrorMassge = $ErrorMassge . 'Сумата трябва да е по-голяма от 0 и по малка от 1 000 000!<br>';
    }
    $DateParams = explode('.', $ProductDate);
    if (DateValidation($DateParams) === FALSE) {
        $CorrectInput = FALSE;
        $ErrorMassge = $ErrorMassge . 'Датата е в невалиден формат! Валиден Формат: 01.12.2013<br>';
    }

    if ($CorrectInput) {
        $FinalInput = ($ProductDate . ';' . $ProductName . ';' . $ProductPrice . ';' . $ProductKind . "\n");
        if (isset($_POST['LineNumber'])) {
            $ProductsList[$_POST['LineNumber']] = $FinalInput;
            file_put_contents('Products.txt', '');
            foreach ($ProductsList as $FinalValue) {
                file_put_contents('Products.txt', $FinalValue, FILE_APPEND);
            }
            header('location: index.php');
        } else {
            file_put_contents('Products.txt', $FinalInput, FILE_APPEND);
            echo 'Успешен запис';
        }
    } else {
        if (isset($_POST['LineNumber'])) {
            echo 'Неуспешна редакция!!!<br>';
            echo $ErrorMassge;
        } else {
            echo 'Невалиден запис!<br>';
            echo $ErrorMassge;
        }
    }
}
