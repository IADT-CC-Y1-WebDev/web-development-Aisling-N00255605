<?php
require_once 'php/lib/config.php';
require_once 'php/lib/session.php';
require_once 'php/lib/forms.php';
require_once 'php/lib/utils.php';

startSession();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="/project/books/css/all.min.css">
        <link rel="stylesheet" href="/project/books/css/grid.css">
        <link rel="stylesheet" href="/project/books/css/reset.css">
        <link rel="stylesheet" href="/project/books/css/style.css">
        <!-- <?php include 'php/inc/head_content.php'; ?> -->
        <title>Create Book</title>
    </head>
    <body>
        <div class="container">
            <div class="width-12">
                <!-- <?php require 'php/inc/flash_message.php'; ?> -->
            </div>
            <div class="width-12">
                <h1>Create Book</h1>
            </div>
            <div class="width-12">
                <form action="book_store.php" method="POST">
                    <div class="input">
                        <label class="special" for="title">Title:</label>
                        <div>
                            <input type="text" id="title" name="title" value="<?= old('title') ?>" required>
                            <p><?= error('title') ?></p>
                        </div>
                    </div>

                    <div class="input">
                        <label class="special" for="author">Author:</label>
                        <div>
                            <input type="text" id="author" name="author" value="<?= old('author') ?>" required>
                            <p><?= error('author') ?></p>
                        </div>
                    </div>

                    <div class="input">
                        <label class="special" for="year">Year:</label>
                        <div>
                            <input type="number" id="year" name="year" value="<?= old('year') ?>" required>
                            <p><?= error('year') ?></p>
                        </div>
                    </div>

                    <div class="input">
                        <label class="special" for="isbn">ISBN:</label>
                        <div>
                            <input type="text" id="isbn" name="isbn" value="<?= old('isbn') ?>" required>
                            <p><?= error('isbn') ?></p>
                        </div>
                    </div>

                    <div class="input">
                        <label class="special" for="description">Description:</label>
                        <div>
                            <textarea id="description" name="description" required><?= old('description') ?></textarea>
                            <p><?= error('description') ?></p>
                        </div>
                    </div>

                    <div class="input">
                        <label class="special" for="image">Image (required):</label>
                        <div>
                            <input type="file" id="image" name="image" accept="image/*" required>
                            <p><?= error('image') ?></p>
                        </div>
                    </div>
                    <div class="input">
                        <button class="button" type="submit">Store Book</button>
                        <div class="button"><a href="book_list.php">Cancel</a></div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
<?php
// Clear form data after displaying
clearFormData();
// Clear errors after displaying
clearFormErrors();
?>