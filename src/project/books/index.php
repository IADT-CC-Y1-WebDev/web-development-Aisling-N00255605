<?php
require_once 'php/lib/config.php';

try {
    $books = Book::findAll();
    // $genres = Genre::findAll();
    // $platforms = Platform::findAll();
} 
catch (PDOException $e) {
    die("<p>PDO Exception: " . $e->getMessage() . "</p>");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Books</title>
    </head>
    <body>
        <div class="container">
            <div class="width-12 header">
                <div class="button">
                    <a href="book_create.php">Add New Book</a>
                </div>
            </div>
            <?php if (!empty($books)) { ?>
                <div class="width-12 filters">
                    <form>
                        <div>
                            <label for="title_filter">Title:</label>
                            <input type="text" id="title_filter" name="title_filter">
                        </div>
                        <div>
                            <label for="author_filter">Author:</label>
                            <select id="author_filter" name="author_filter">
                                <option value="">All Author</option>
                                <?php foreach ($authors as $author) { ?>
                                    <option value="<?= h($author->id) ?>"><?= h($author->name) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div>
                            <button type="button" id="apply_filters">Apply Filters</button>
                            <button type="button" id="clear_filters">Clear Filters</button>
                        </div>
                    </form>
                </div>
            <?php } ?>
        </div>
        <div class="container">
            <?php if (empty($books)) { ?>
                <p>No books found.</p>
            <?php } else { ?>
                <div class="width-12 cards">
                    <?php foreach ($books as $book) { ?>
                        <div class="card">
                            <div class="top-content">
                                <h2>Title: <?= ($book->title) ?></h2>
                                <p>Year: <?= ($book->year) ?></p>
                            </div>
                            <div class="bottom-content">
                                <img src="images/<?= h($book->cover_filename) ?>" alt="Image for <?= h($book->title) ?>" />
                                <div class="actions">
                                    <a href="book_view.php?id=<?= h($book->id) ?>">View</a>/ 
                                    <a href="book_edit.php?id=<?= h($book->id) ?>">Edit</a>/ 
                                    <a href="book_delete.php?id=<?= h($book->id) ?>">Delete</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </body>
</html>