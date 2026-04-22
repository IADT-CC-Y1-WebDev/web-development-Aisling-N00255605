<?php
require_once 'php/lib/config.php';
require_once 'php/lib/session.php';
require_once 'php/lib/forms.php';
require_once 'php/lib/utils.php';

startSession();

// dd($_SESSION);

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        throw new Exception('Invalid request method.');
    }
    if (!array_key_exists('id', $_GET)) {
        throw new Exception('No game ID provided.');
    }
    $id = $_GET['id'];

    $book = Book::findById($id);
    if ($book === null) {
        throw new Exception("Book not found.");
    }

    $bookFormats = Format::findByBook($book->id);
    $bookFormatIds = [];
    foreach ($bookFormats as $format) {
        $bookFormatIds[] = $format->id;
    }

    $publishers = Publisher::findAll();
    $formats = Format::findAll();

} catch (PDOException $e) {
    setFlashMessage('error', 'Error: ' . $e->getMessage());
    redirect('index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'php/inc/head_content.php'; ?>
    <title>Edit Book</title>
</head>
<body>
    <div class="container">
        <div class="width-12">
            <?php require 'php/inc/flash_message.php'; ?>
        </div>

        <div class="width-12">
            <h1>Edit Book</h1>
        </div>

        <div class="width-12">
            <form action="book_update.php" method="POST" enctype="multipart/form-data">
                
                <input type="hidden" name="id" value="<?= h($book->id) ?>">

                <!-- Edit Title -->
                <div class="input">
                    <label class="special" for="title">Title:</label>
                    <div>
                        <input type="text" id="title" name="title" 
                               value="<?= old('title', $book->title) ?>" required>
                        <p><?= error('title') ?></p>
                    </div>
                </div>

                <!-- Edit Author -->
                <div class="input">
                    <label class="special" for="author">Author:</label>
                    <div>
                        <input type="text" id="author" name="author" 
                               value="<?= old('author', $book->author) ?>" required>
                        <p><?= error('author') ?></p>
                    </div>
                </div>

                <!-- Edit Publisher -->
                 <div class="input">
                        <label class="special" for="publisher_id">Publisher:</label>
                        <div>
                            <select id="publisher_id" name="publisher_id" required>
                                <?php foreach ($publishers as $pub) { ?>
                                    <option value="<?= h($pub->id) ?>" <?= chosen('publisher_id', $pub->id, $book->publisher_id) ? "selected" : "" ?>>
                                        <?= h($pub->name) ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <p><?= error('publisher_id') ?></p>
                        </div>
                    </div>

                <!-- Edit Year -->
                <div class="input">
                    <label class="special" for="year">Year:</label>
                    <div>
                        <input type="text" id="year" name="year" value="<?= old('year', $book->year) ?>" required>
                            <p><?= error('year') ?></p>
                    </div>
                </div>

                <!-- Edit ISBN -->
                <div class="input">
                    <label class="special" for="isbn">ISBN:</label>
                    <div>
                        <input type="text" id="isbn" name="isbn" 
                               value="<?= old('isbn', $book->isbn) ?>" required>
                        <p><?= error('isbn') ?></p>
                    </div>
                </div>

                <!-- Edit Formats -->
                <div class="input">
                    <label class="special">Formats:</label>
                    <div>
                        <?php foreach ($formats as $format): ?>
                            <div>
                                <input type="checkbox" 
                                       id="format_<?= h($format->id) ?>" 
                                       name="format_ids[]" 
                                       value="<?= h($format->id) ?>"
                                       <?= chosen('format_ids', $format->id, $bookFormatIds) ? 'checked' : '' ?>>
                                <label for="format_<?= h($format->id) ?>"><?= h($format->name) ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <p><?= error('format_ids') ?></p>
                </div>

                <!-- Edit Description -->
                <div class="input">
                    <label class="special" for="description">Description:</label>
                    <div>
                        <textarea id="description" name="description" required><?= old('description', $book->description) ?></textarea>
                        <p><?= error('description') ?></p>
                    </div>
                </div>

                <!-- Current Cover -->
                <?php if ($book->cover_filename): ?>
                    <div class="input">
                        <label class="special">Current Cover:</label>
                        <div>
                            <img src="images/<?= h($book->cover_filename) ?>" alt="Book Cover" style="max-width:200px;">
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Edit Image -->
                <div class="input">
                    <label class="special" for="cover">New Cover:</label>
                    <div>
                        <input type="file" id="cover" name="cover" accept="image/*">
                        <p><?= error('cover') ?></p>
                    </div>
                </div>

                <!-- Submit -->
                <div class="input">
                    <button class="button" type="submit">Update Book</button>
                    <div class="button"><a href="index.php">Cancel</a></div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

<?php
// Clear sticky data and errors after displaying
clearFormData();
clearFormErrors();
?>