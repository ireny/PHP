<?php
$htmlTitle = 'Списък';
include 'header.php';
?>
<body>
    <button><a href="form.php"><b>Добавяне на разход</b></a></button>
    <form method="POST" action="index.php">
        <label for="startDayFilter">От:</label>
        <select name="startDayFilter" >
            <?= $DateFilterValues ?>
        </select>
        <label for="lastDayFilter">До:</label>
        <select name="lastDayFilter" >
            <?= $DateFilterValues ?>
        </select>
        <select name="KindForFilter">
            <option value="5">Всички</option>
            <?php
            foreach ($PossibleKinds as $key => $value) {
                echo '<option value="' . $key . '">' . $value . '</option>';
            }
            ?>
        </select>
        <input type="submit" value="Филтрирай">
    </form>

    <table border="1">
        <tr>
            <td>Дата</td>
            <td>Име</td>
            <td>Сума</td>
            <td>Вид</td>
            <td>Редактиране</td>
            <td>Изтриване</td>
        </tr>
        <?php
        $FilterFirstDate = $_POST['startDayFilter'];
        $FilterSecondDate = $_POST['lastDayFilter'];
        
        if (CompareTwoDates($FilterFirstDate,$FilterSecondDate) === -1 ||
                ($FilterFirstDate == 'Без Ограничение'|| $FilterSecondDate=='Без Ограничение')) {
            $DateFilterOn = TRUE;
        }else{
            $DateFilterOn = FALSE;
        }
        
    if(isset($_POST['KindForFilter']) &&!$DateFilterOn)
    {
        echo '<br>Първата дата трябва бъде преди втората!!!<br><br>';
    }
        $totalSum = 0;
        if (isset($ProductsList)) {
            foreach ($ProductsList as $ProductKey => $ProductValue) {
                $ProductData = explode(';', $ProductValue);
                if (isset($_POST['KindForFilter'])&&$_POST['KindForFilter'] != 5 && trim($ProductData[3]) != $_POST['KindForFilter']) {
                    continue;
                }
                if($FilterFirstDate != 'Без Ограничение'&&$DateFilterOn && (CompareTwoDates($FilterFirstDate, $ProductData[0])== 1))
                {
                    continue;
                }
                if($FilterSecondDate!='Без Ограничение'&&$DateFilterOn && (CompareTwoDates($FilterSecondDate, $ProductData[0])== -1))
                {
                    continue;
                }
                $totalSum+=$ProductData[2];
                echo '<tr>
            <td>' . $ProductData[0] . '</td>
            <td>' . $ProductData[1] . '</td>
            <td>' . number_format($ProductData[2], 2) . '</td>
            <td>' . $PossibleKinds[trim($ProductData[3])] . '</td>
            <td><form method="POST" action="Form.php">
            <input type="hidden" name="indexForEdit" value="' . $ProductKey . '">
            <input type="submit" value="Редактирай">
            </form></td>
            <td><form method="POST" action="deleteData.php">
            <input type="hidden" name="indexForDelete" value="' . $ProductKey . '">
            <input type="submit" value="Изтрий">
        </form></td></tr>';
            }
        }
        ?>
        <td></td>
        <td>Общо : </td>
        <td><?= number_format($totalSum, 2) ?></td>
        <td></td>

    </table>
    
</body>
</html>
