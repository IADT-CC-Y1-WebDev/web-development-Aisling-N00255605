<?php
require_once 'php/lib/config.php';

$books = Book::findAll();

echo "<pre>";
print_r($books);

?>