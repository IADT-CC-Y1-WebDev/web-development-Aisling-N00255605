<?php
require_once 'php/lib/config.php';
require_once 'php/lib/session.php';
require_once 'php/lib/forms.php';
require_once 'php/lib/utils.php';


startSession();

try {
    $books = Book::findAll();
    $publishers = Publisher::findAll();
    $formats = Format::findAll();
}

catch (PDOException $e) {
    die("<p>PDO Exception: " . $e->getMessage() . "</p>");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'php/inc/head_content.php'; ?>

    <link rel="stylesheet" href="/project/books/css/all.min.css">
    <link rel="stylesheet" href="/project/books/css/grid.css">
    <link rel="stylesheet" href="/project/books/css/reset.css">
    <link rel="stylesheet" href="/project/books/css/style.css">

    <title>Add New Book</title>
</head>
<body>


    <div class="container">
        <div class="width-12">
            <?php require 'php/inc/flash_message.php'; ?>
        </div>

        <div class="width-12">
            <h1>Add New Book</h1>
        </div>

        <div class="width-12">
            <form action="book_store.php" method="POST" enctype="multipart/form-data" novalidate>

                    <!-- Add Title -->
                <div class="form-group">
                    <label for="title">Book Title:</label>  
                    <input type="text" id="title" name="title" value="<?= h(old('title'))?>" >
                    <div>
                        <?php if (error('title')): ?>
                            <p class="error"><?= error('title') ?></p>
                        <?php endif; ?>
                    </div>
                </div>


                <!-- Add Author -->
                <div class="form-group">
                    <label for="author">Author:</label>
                    <input type="text" id="author" name="author" value="<?= h(old('author'))?>">

                    <div>
                        <?php if (error('author')): ?>
                            <p class="error"><?= error('author') ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Add Publisher -->
                <div class="form-group">
                    <label for="publisher_id">Publisher:</label>
                    <select id="publisher_id" name="publisher_id">
                        <option value="">-- Select Publisher --</option>

                        <?php foreach ($publishers as $pub): ?>
                            <option value="<?= $pub->id ?>" 
                            <?= chosen('publisher_id', $pub->id) ? "selected" : "" ?>
                            >
                                <?= h($pub->name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <div>
                        <?php if (error('publisher_id')): ?>
                            <p class="error"><?= error('publisher_id') ?></p>
                        <?php endif; ?>
                    </div>

                </div>

                <!-- Add Year -->
                <div class="form-group">
                    <label for="year">Year:</label>
                    <input type="text" id="year" name="year" value="<?= h(old('year'))?>">

                    <div>
                        <?php if (error('year')): ?>
                            <p class="error"><?= error('year') ?></p>
                        <?php endif; ?>
                    </div>

                </div>

                <!-- Add ISBN -->
                <div class="form-group">
                    <label for="isbn">ISBN:</label>
                    <input type="text" id="isbn" name="isbn" value="<?= h(old('isbn'))?>">

                    <div>
                        <?php if (error('isbn')): ?>
                            <p class="error"><?= error('isbn') ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Add Formats -->
                <div class="form-group">
                    <label>Available Formats:</label>
                    <div class="checkbox-group">

                        <?php foreach ($formats as $format): ?>
                            <label class="checkbox-label">
                                <input type="checkbox" name="format_ids[]" value="<?= $format->id ?>"
                                <?= chosen('format_ids', $format->id) ? "checked" : ""?>
                                >
                                <?= h($format->name) ?>
                            </label>
                        <?php endforeach; ?>
                    </div>

                    <div>
                        <?php if (error('format_ids')): ?>
                            <p class="error"><?= error('format_ids') ?></p>
                        <?php endif; ?>
                    </div>

                </div>

                    <!-- Add Description -->
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" rows="5"><?= h(old('description'))?></textarea>

                    <div>
                        <?php if (error('description')): ?>
                            <p class="error"><?= error('description') ?></p>
                        <?php endif; ?>
                    </div>

                </div>

                    <!-- Add Image -->
                <div class="form-group">
                    <label for="cover">Book Cover Image (max 2MB):</label>
                    <input type="file" id="cover" name="cover" accept="image/*">
                    <div>
                        <?php if (error('cover')): ?>
                            <p class="error"><?= error('cover') ?></p>
                        <?php endif; ?>
                    </div>                    
                </div>

                <div class="form-group">
                    <button type="submit" class="button">Save Book</button>
                    <div class="button"><a href="index.php">Cancel</a></div>
                </div>
            </form>
        </div>
    </div>
    <?php
    //   Clear form data and errors
    clearFormData();
    clearFormErrors();
    ?>
    </body>
</html>