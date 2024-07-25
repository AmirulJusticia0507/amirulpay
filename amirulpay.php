<?php
include 'konekke_local.php';

function deductAmirulPayBalance($userId, $amount) {
    global $koneklocalhost;

    // Periksa saldo pengguna
    $query = "SELECT amirulpay_balance FROM users WHERE id = ?";
    $stmt = $koneklocalhost->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($balance);
    $stmt->fetch();
    $stmt->close();

    if ($balance >= $amount) {
        // Kurangi saldo
        $query = "UPDATE users SET amirulpay_balance = amirulpay_balance - ? WHERE id = ?";
        $stmt = $koneklocalhost->prepare($query);
        $stmt->bind_param("di", $amount, $userId);
        $stmt->execute();
        $stmt->close();
        return true;
    } else {
        return false;
    }
}

function addTransaction($userId, $amount, $transactionId) {
    global $koneklocalhost;

    $query = "INSERT INTO transactions (user_id, amount, transaction_id, status) VALUES (?, ?, ?, 'pending')";
    $stmt = $koneklocalhost->prepare($query);
    $stmt->bind_param("ids", $userId, $amount, $transactionId);
    $stmt->execute();
    $stmt->close();
}

function updateTransactionStatus($transactionId, $status) {
    global $koneklocalhost;

    $query = "UPDATE transactions SET status = ? WHERE transaction_id = ?";
    $stmt = $koneklocalhost->prepare($query);
    $stmt->bind_param("ss", $status, $transactionId);
    $stmt->execute();
    $stmt->close();
}
?>
