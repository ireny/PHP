<a href="index.php">Списък</a>
<a href="add_book.php">Нова книга</a>
<form method="post" action="authors.php">
    Име: <input type="text" name="author_name" />
    <input type="submit" value="Добави" />    
</form>
<table border='1'>
    <tr><th>Автор</th></tr>
    <?php
    foreach ($data['authors'] as $author) {
        echo '<tr><td>' . $author . '</td></tr>';
    }
    ?>
</table>
