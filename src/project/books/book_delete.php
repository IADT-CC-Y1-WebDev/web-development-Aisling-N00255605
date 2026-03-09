<?php
require_once 'php/lib/config.php';
require_once 'php/lib/session.php';
require_once 'php/lib/forms.php';
require_once 'php/lib/utils.php';

startSession();

try {
    $data = [];
    $errors = [];
    
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        throw new Exception('Invalid request method.');
    }

    $data = [
        'id' => $_GET['id'] ?? null
    ];

    $rules = [
        'id' => 'required|integer'
    ];

    $validator = new Validator($data, $rules);

    if ($validator->fails()) {
        foreach ($validator->errors() as $field => $fieldErrors) {
            $errors[$field] = $fieldErrors[0];
        }

        throw new Exception('Validation failed.');
    }

    $game = Book::findById($data['id']);
    if (!$game) {
        throw new Exception('Book not found.');
    }

    if ($book->image_filename) {
        $uploader = new ImageUpload();
        $uploader->deleteImage($book->image_filename);
    }
    // Delete the game
    $book->delete();
    clearFormData();
    clearFormErrors();
    setFlashMessage('success', 'Game deleted successfully.');
    redirect('index.php');
}
catch (Exception $e) {
    setFlashMessage('error', 'Error: ' . $e->getMessage());

    setFormData($data);
    setFormErrors($errors);

    if (isset($data['id']) && $data['id']) {
        redirect('book_view.php?id=' . $data['id']);
    }
    else {
        redirect('index.php');
    }
}