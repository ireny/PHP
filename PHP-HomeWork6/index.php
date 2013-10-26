<?php

include './inc/functions.php';
if (isset($_GET['author_id'])) {
    $author_id = (int) $_GET['author_id'];
    $q = mysqli_query($db, 'SELECT * FROM `books_authors` as ba 
                    INNER JOIN books as b ON ba.book_id=b.book_id 
                    INNER JOIN books_authors as bba ON bba.book_id=b.book_id 
                    INNER JOIN authors as a ON bba.author_id=a.author_id 
                    WHERE ba.author_id=' .$author_id);
} else {
    $q = mysqli_query($db, 'SELECT * FROM books as b INNER JOIN 
    books_authors as ba ON b.book_id=ba.book_id INNER JOIN authors as a
     ON a.author_id=ba.author_id');
}

$result = [];
while ($row = mysqli_fetch_assoc($q)) {
    //echo '<pre>'.print_r($row, true).'</pre>';
    $result[$row['book_id']]['book_title'] = $row['book_title'];
    $result[$row['book_id']]['authors'][$row['author_id']] = $row['author_name'];
}
$data = [];

    $data['title'] = 'Списък';
    $data['result'] = $result;
    $data['content'] = $data['content'] = 'templates/index_public.php';
    render($data, 'templates/layouts/normal_layout.php');



    