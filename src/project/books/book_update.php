<?php
require_once 'php/lib/config.php';
require_once 'php/lib/session.php';
require_once 'php/lib/forms.php';
require_once 'php/lib/utils.php';

startSession();

try {
    $data = [];
    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method.');
    }

    // Get form data
    $data = [
        'id' => $_POST['id'] ?? null,
        'title' => $_POST['title'] ?? null,
        'author' => $_POST['author'] ?? null,
        'publisher_id' => $_POST['publisher_id'] ?? null,
        'year' => $_POST['year'] ?? null,
        'isbn' => $_POST['isbn'] ?? null,
        'description' => $_POST['description'] ?? null,
        'format_ids' => $_POST['format_ids'] ?? [],
        'cover' => $_FILES['cover'] ?? null
    ];

    // Validation rules
    $rules = [
        'id' => 'required|integer',
        'title' => 'required|notempty|min:1|max:255',
        'author' => 'required|notempty|min:1|max:255',
        'year' => 'required|integer|min:0|max:2100',
        'isbn' => 'required|notempty|min:5|max:20',
        'description' => 'required|notempty|min:10|max:5000',
        'image' => 'file|image|mimes:jpg,jpeg,png|max_file_size:5242880'
    ];

    $validator = new Validator($data, $rules);
    if ($validator->fails()) {
        foreach ($validator->errors() as $field => $fieldErrors) {
            $errors[$field] = $fieldErrors[0];
        }
        throw new Exception('Validation failed.');
    }

    // Find the book
    $book = Book::findById($data['id']);
    if (!$book) throw new Exception('Book not found.');

    // Handle cover image
    $coverFilename = null;
    $uploader = new ImageUpload();
    if ($uploader->hasFile('cover')) {
        if ($book->cover_filename) {
            $uploader->deleteImage($book->cover_filename);
        }
        $coverFilename = $uploader->process($_FILES['cover']);
        if (!$coverFilename) throw new Exception('Failed to save cover image.');
    }

    // Update book properties
    $book->title = $data['title'];
    $book->author = $data['author'];
    $book->publisher_id = $data['publisher_id'];
    $book->year = $data['year'];
    $book->isbn = $data['isbn'];
    $book->description = $data['description'];
    if ($coverFilename) $book->cover_filename = $coverFilename;

    // Save book
    $book->save();


    BookFormat::deleteByBook($book->id);
    // Create new platform associations
    if (!empty($data['format_ids']) && is_array($data['format_ids'])) {
        foreach ($data['format_ids'] as $formatids) {
            BookFormat::create($book->id, $formatids);
        }
    }

    // Clear old form data/errors
    clearFormData();
    clearFormErrors();

    setFlashMessage('success', 'Book updated successfully.');
    redirect('book_view.php?id=' . $book->id);

} catch (Exception $e) {
    // Delete uploaded cover if something failed
    if ($coverFilename) {
        $uploader->deleteImage($coverFilename);
    }

    setFlashMessage('error', 'Error: ' . $e->getMessage());
    setFormData($data);
    setFormErrors($errors);

    if (isset($data['id']) && $data['id']) {
        redirect('book_edit.php?id=' . $data['id']);
    }
    else {
        redirect('index.php');
    }
}