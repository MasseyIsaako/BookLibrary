<?php
    require("./templates/databaseConnection.php");
    $currentPage = "Add Books";

    if($_POST){
        extract($_POST);
        $errors = array();

        if(!$title){
            array_push($errors, "Please enter a title.");
        } else if(strlen($title) < 2){
            array_push($errors, "Please enter more than 5 characters for title.");
        }

        if(!$description){
            array_push($errors, "Please enter a description.");
        } else if (strlen($description) > 2000){
            array_push($errors, "Please enter less than 2000 characters for description.");
        } else if (strlen($description) < 100){
            array_push($errors, "Please enter more than 100 characters.");
        }

        if(!$year){
            array_push($errors, "Please enter a year.");
        } else if (strlen($year) > 4){
            array_push($errors, "Please enter less than 4 characters for year.");
        }

        // if (!$authorid) {
            // array_push($errors, "Please check an author, or add a new one.");
        // }

        if($author){
            if(empty($errors)){
                $sql = "INSERT INTO authors VALUES (NULL, '$author')";
                $result = mysqli_query($dbc, $sql);

                if($result && mysqli_affected_rows($dbc) > 0){
                    $authorid = $dbc->insert_id;
                } else {
                    die("Cannot add author to the database.");
                }
            }
        } else {
            if(!isset($authorid)){
                array_push($errors, "Please check an author, or add a new one.");    
            }
        }

        if(empty($errors)){
            $title = mysqli_real_escape_string($dbc, $title);
            $description = mysqli_real_escape_string($dbc, $description);
            $year = mysqli_real_escape_string($dbc, $year);
            $sql = "INSERT INTO `books` VALUES (NULL, '$title', '$year', '$description', '$authorid')";
            $result = mysqli_query($dbc, $sql);

            if ($result && mysqli_affected_rows($dbc) > 0) {
                header("Location: index.php");
            } else {
                die("Something went wrong, cannot add entry into database.");
            }
        }

    } else {

    }

    $sql = "SELECT * FROM `authors`";
    $result = mysqli_query($dbc, $sql);
    
    if(!$result){
        die("Something went wrong, can't get authors");
    } else {
        $allAuthors = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }






?>

<!DOCTYPE html>
<html>

    <?php require("./templates/styles.php") ?>

    <body>
        <div class="container">

            <?php require("./templates/nav.php") ?>

            <h1>Add Books</h1>
            <hr>

            <?php if($_POST): ?>

            <div class="alert alert-danger">
                <ul>
                <?php foreach($errors as $singleError): ?>
                    <li><?= $singleError ?></li>
                <?php endforeach ?>
                </ul>
            </div>

            <?php endif ?>
            <form action="addBooks.php" method="post">
                <div class="form-group">
                    <label for="title">Book Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="<?php if (isset($_POST['title'])) {
                        echo $_POST['title'];
                    } ?>">
                </div>
                <div class="form-group">
                    <label for="year">Year Released</label>
                    <input type="number" class="form-control" id="year" name="year" placeholder="Year" value="<?php if (isset($_POST['year'])) {
                        echo $_POST['year'];
                    } ?>">
                </div>
                <div class="form-group">
                    <label for="author">Author</label><br>
                    <?php   foreach ($allAuthors as $singleAuthor): ?>
                        <label class="radio-inline"><input type="radio" <?php if(isset($_POST['authorid']) && $_POST['authorid'] == $singleAuthor['id']): ?> checked <?php endif; ?> name="authorid" value="<?= $singleAuthor['id'] ?>"><?= $singleAuthor['name'] ?></label>
                    <?php endforeach ?>
                    <br>
                    <button type="button" name="button" id="addNewAuthor" class="btn btn-link">add new author</button>
                    <input type="text" class="form-control" id="author" name="author" placeholder="Author" value="<?php if (isset($_POST['author'])) {
                        echo $_POST['author'];
                    } ?>">
                </div>
                <div class="form-group">
                    <label for="description">Book Description</label>
                    <textarea name="description" rows="8" cols="80" class="form-control" placeholder="Description of Book"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" name="button">Add Book</button>
                </div>
            </form>
        </div>

        <?php require("./templates/scripts.php") ?>

    </body>
</html>