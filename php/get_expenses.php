<?php
// get_expenses.php

require_once('config.php');

$expensesResult = mysqli_query($conn, "SELECT * FROM expenses ORDER BY date_added DESC");
$expenses = [];

while ($row = mysqli_fetch_assoc($expensesResult)) {
    $expenses[] = [
        'description' => $row['description'],
        'amount' => $row['amount'],
        'date_added' => $row['date_added'],
    ];
}

foreach ($expenses as $expense) {
    echo $expense['description'] . ': $' . $expense['amount'] . ' on ' . $expense['date_added'] . '<br>';
}
?>
