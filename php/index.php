<?php
// index.php

require_once('config.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['budgetAmount'])) {
        saveBudget($_POST['budgetAmount']);
    } elseif (isset($_POST['expenseDescription']) && isset($_POST['expenseAmount'])) {
        saveExpense($_POST['expenseDescription'], $_POST['expenseAmount']);
    }
}

function saveBudget($amount) {
    global $conn;
    $amount = floatval($amount);

    $sql = "INSERT INTO budget (amount) VALUES ($amount)";
    mysqli_query($conn, $sql);

    header('Location: index.html'); // Redirect to the HTML page
    exit();
}

function saveExpense($description, $amount) {
    global $conn;
    $description = mysqli_real_escape_string($conn, $description);
    $amount = floatval($amount);

    $sql = "INSERT INTO expenses (description, amount, budget_id) SELECT '$description', $amount, MAX(id) FROM budget";
    mysqli_query($conn, $sql);

    header('Location: index.html'); // Redirect to the HTML page
    exit();
}
?>
