<?php
    require("./templates/databaseConnection.php");
    $currentPage = "Book";

    $id = $_GET['id'];
    $sql = "SELECT books.id as bookID, title, year, description, name, authors.id as authorID FROM books INNER JOIN authors ON books.author_id = authors.id WHERE books.id = $id";
    $result = mysqli_query($dbc, $sql);
    if($result){
        $book = mysqli_fetch_array($result, MYSQLI_ASSOC);
        extract($book);
    } else {
        die("Canot retrieve database connection for query.");
    }
?>

<!DOCTYPE html>
<html>
    
    <?php require("./templates/styles.php"); ?>
    
    <body>
        <div class="container">

            <?php require("./templates/nav.php"); ?>

            <h2><?= $title ?></h2>
            <h4><?= $name ?></h4>
            <p><small><?= $year ?></small></p>
            <hr>
            <p><?= $description ?></p>

            <a href="editBooks.php?id=<?= $book['bookID']; ?>" class="btn btn-warning">Edit Book</a>
            <a href="deleteBooks.php?id=<?=$book['bookID']?>" class="btn btn-danger">Delete Book</a>

        </div>
        <?php require("./templates/scripts.php"); ?>
    </body>
</html>