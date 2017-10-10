<?php
	require("./templates/databaseConnection.php");
	$currentPage = "Home";

    $sql = "SELECT books.id as bookID, title, year, description, name, authors.id as authorID FROM books INNER JOIN authors ON books.author_id = authors.id";
    $result = mysqli_query($dbc, $sql);
    if(!$result){
        die("Something went wrong.");
    } else {
        $books = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
?>

<!DOCTYPE html>
<html>
    
    <?php require("./templates/styles.php") ?>

    <body>
        <div class="container">

        	<?php require("./templates/nav.php") ?>

            <h1>View Books</h1>
                <table class="table table-striped">
                    <thead>
                        <td>Title</td>
                        <td>Author</td>
                        <td>Description</td>
                        <td>Year Released</td>
                    </thead>

                    <tbody>
                        <?php foreach ($books as $book): ?>
                                <tr>
                                    <td><a href="book.php?id=<?=$book['bookID']?>"><?= $book['title'] ?></a></td>
                                    <td><?= $book['name']; ?></td>
                                    <td><?php echo substr($book['description'], 0, 75); ?> . . .</td>
                                    <td><?= $book['year']; ?></td>
                                </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <a href="addBooks.php" class="btn btn-primary">Add Books</a>
        </div>
        
        <?php require("./templates/scripts.php") ?>

    </body>
</html>