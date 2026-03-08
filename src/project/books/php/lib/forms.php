<?php
// forms.php - simple helpers for old input and errors

function old($field) {
    return $_SESSION['form_data'][$field] ?? '';
}

function error($field) {
    return $_SESSION['form_errors'][$field] ?? '';
}

function setFormData(array $data) {
    $_SESSION['form_data'] = $data;
}

function setFormErrors(array $errors) {
    $_SESSION['form_errors'] = $errors;
}

function clearFormData() {
    unset($_SESSION['form_data']);
}

function clearFormErrors() {
    unset($_SESSION['form_errors']);
}

function chosen($field, $value) {
    if (!isset($_SESSION['form_data'][$field])) return false;
    $data = $_SESSION['form_data'][$field];
    if (is_array($data)) {
        return in_array($value, $data);
    }
    return $data == $value;
}
?>