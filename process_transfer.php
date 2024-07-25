<?php
session_start();
include 'amirulpay.php';
include 'ovo_payment.php';

// Pastikan pengguna telah login
if (!isset($_SESSION['user_id'])) {
    die("Anda harus login untuk mengakses halaman ini.");
}

$userId = $_SESSION['user_id'];
$amount = $_POST['amount'];
$phone = $_POST['phone'];
$transactionId = uniqid();

// Kurangi saldo AmirulPay pengguna
if (deductAmirulPayBalance($userId, $amount)) {
    // Tambahkan transaksi ke database
    addTransaction($userId, $amount, $transactionId);

    // Inisiasi pembayaran ke OVO menggunakan nomor telepon
    $response = initiateOvoPayment($amount, $phone, $transactionId);

    if ($response['status'] == 'success') {
        // Perbarui status transaksi
        updateTransactionStatus($transactionId, 'success');
        echo "Pembayaran berhasil!";
    } else {
        echo "Pembayaran gagal: " . $response['message'];
        // Kembalikan saldo AmirulPay pengguna jika pembayaran gagal
        deductAmirulPayBalance($userId, -$amount);
    }
} else {
    echo "Saldo tidak mencukupi!";
}
?>
