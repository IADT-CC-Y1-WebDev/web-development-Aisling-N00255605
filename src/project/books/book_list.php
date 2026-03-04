<?php
require_once 'php/classes/book.php';

$books = book::findAll();
?>

<a href= "book_create.php"> Add new Book </a>

<table>
    <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($books as $book): ?>
    
    <tr>
        <td><?= htmlspecialchars($book -> title) ?></td>
        <td><?= htmlspecialchars($book -> author) ?></td>
        <td>
            <a href="book_view.php?id=<?= $book->id ?>">View</a>
            <a href="book_edit.php?id=<?= $book->id ?>">Edit</a>
            <a href="book_delete.php?id=<?= $book->id ?>">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>