<?php
require_once 'php/lib/config.php';
require_once 'php/lib/utils.php';

// Cookie session for dark mode
if (isset($_GET['cookie_theme'])){
    $theme = $_GET['cookie_theme'];

    // Store in cookie for 30 days
    setcookie('theme', $theme, time() + (60 * 60 * 24 * 30), '/');

    // Redirect index
    header('Location: index.php');
    exit;
}

// reset
if (isset($_GET['reset_cookie'])){
    $no = time();
    $expiry = time() - 3600;
    setcookie('theme', '', $expiry, '/');

    header('Location: index.php');
    exit;
}

// Theme options
$cookieTheme = isset($_COOKIE['theme']) ? $_COOKIE['theme'] : 'not set';

$themes = [
    'light' => ['bg' => '#ffffff', 'text' => '#333333'],
    'dark' => ['bg' => '#7070e2', 'text' => '#eaeaea'],
];

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
        <title>Books</title>
    </head>

    <body class="<?= $cookieTheme ? $cookieTheme : '' ?>">
    <div class="header">
        <div class="container">
            <div class="width-12">
                <?php require 'php/inc/flash_message.php'; ?>
            </div>
        

        <div class="width-12 header_contents">
                <div class="button">
                    <a href="book_create.php">Add New Book</a>
                </div>
                        
                <?php if (!empty($books)) { ?>
                <div class="width-12">
                    <form id="filters" class="filters">
                        <div class="input">
                            <label class="filter-label" for="title_filter">Title:</label>
                            <div>
                                <input type="text" id="title_filter" name="title_filter" placeholder="Part of a title">
                            </div>
                        </div>

                             <!-- ~~~~~~~~~Publishers Filter~~~~~~~~~ -->
                        <div class="input">
                            <label class="filter-label" for="publisher_filter">Publisher:</label>
                            <div>
                                <select id="publisher_filter" name="publisher_filter">
                                    <option value="">All Publisher</option>
                                    <?php foreach ($publishers as $publisher): ?>
                                        <option value="<?= htmlspecialchars($publisher->id) ?>">
                                            <?= htmlspecialchars($publisher->name) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                            <!-- ~~~~~~~~~Format Filter~~~~~~~~~ -->
                        <div class="input">
                            <label class="filter-label" for="format_filter">Format:</label>
                            <div>
                                <select id="format_filter" name="format_filter">
                                    <option value="">All Formats</option>
                                    <?php foreach ($formats as $format): ?>
                                        <option value="<?= htmlspecialchars($format->id) ?>">
                                            <?= htmlspecialchars($format->name) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                            <div class="clearApplyButtons">
                                <button type="button" id="apply_filters">Apply Filters</button>
                                <button type="button" id="clear_filters">Clear Filters</button>
                            </div>
                            
                        </form>
                    </div>
                <?php } ?>
        </div>
        </div>
    </div>

        <!-- books -->
        <div class="container">
            <?php if (empty($books)) { ?>
                <p>No books found.</p>
            <?php } else { ?>
                <div class="width-12 cards">
                    <?php 
                    foreach ($books as $book) { 
                        $bookFormats = Format::findByBook($book->id);
                        $formatIds = [];
                        foreach ($bookFormats as $f) {
                            $formatIds[] = $f->id;
                        }
                        $formatIdsStr = implode(' ', $formatIds);
                    ?>
                        <div class="card"
                             data-title="<?= $book->title ?>"
                             data-publisher="<?= $book->publisher_id ?>"
                             data-formats="<?= $formatIdsStr ?>"
                             data-year="<?= $book->year ?>"
                        >
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
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>

    <div class="footer">
        <div class="container">
            <div class="width-12 footer_contents">
                
                <div class="button">
                    <a href="?cookie_theme=light">Light</a> 
                </div>

                <div class="button">
                    <a href="?cookie_theme=dark">Dark</a> 
                </div>

                <div class="button">
                    <a href="?reset_cookie=1">Reset</a>
                </div> 

            </div>
        </div>
    </div>
        <script src="js/filters.js"></script>
    </body>
</html>
