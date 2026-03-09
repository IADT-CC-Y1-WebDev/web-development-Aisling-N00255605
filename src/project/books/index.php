<?php
require_once 'php/lib/config.php';
require_once 'php/lib/utils.php';

try {
    $books = Book::findAll();

} 
catch (PDOException $e) {
    die("<p>PDO Exception: " . $e->getMessage() . "</p>");
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="/project/books/css/all.min.css">
        <link rel="stylesheet" href="/project/books/css/grid.css">
        <link rel="stylesheet" href="/project/books/css/reset.css">
        <link rel="stylesheet" href="/project/books/css/style.css">
        <?php include 'php/inc/head_content.php'; ?>
        <title>Books</title>
    </head>
    <body>
        <div class="container">
            <div class="width-12 header">
                <?php require 'php/inc/flash_message.php'; ?>
                <div class="button">
                    <a href="book_create.php">Add New Book</a>
                </div>
            </div>

        </div>

        <!-- books -->
        <div class="container">
            <?php if (empty($books)) { ?>
                <p>No books found.</p>
            <?php } else { ?>
                <div class="width-12 cards">
                    <?php foreach ($books as $book) { ?>
                        <div class="card">
                            <a href="book_view.php">
                            <div class="top-content">
                                <img src="images/<?= ($book->cover_filename) ?>" />
                                <h2>Title: <?= ($book->title) ?></h2>
                                <p>Author: <?= ($book->author) ?></p>
                                <p>Year: <?= ($book->year) ?></p>
                            </div>
                            <div class="bottom-content">

                                <div class="actions">
                                    <a href="book_view.php?id=<?= h($book->id) ?>">View</a>/ 
                                    <a href="book_edit.php?id=<?= h($book->id) ?>">Edit</a>/ 
                                    <a href="book_delete.php?id=<?= h($book->id) ?>">Delete</a>
                                </div></a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>


    </body>
</html>