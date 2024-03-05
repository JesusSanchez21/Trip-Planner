<?php
// get_budget_info.php

require_once('config.php');

$budgetResult = mysqli_query($conn, "SELECT * FROM budget");
$expensesResult = mysqli_query($conn, "SELECT SUM(amount) AS total FROM expenses");

$budget = mysqli_fetch_assoc($budgetResult);
$expenses = mysqli_fetch_assoc($expensesResult);

$budgetAmount = $budget ? $budget['amount'] : 0;
$expensesAmount = $expenses ? $expenses['total'] : 0;
$balance = $budgetAmount - $expensesAmount;

echo "Budget: $" . number_format($budgetAmount, 2) . " | Expenses: $" . number_format($expensesAmount, 2) . " | Balance: $" . number_format($balance, 2);
?>
