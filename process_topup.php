<?php
include 'konekke_local.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    $userId = 1; // Ganti dengan ID pengguna yang sesuai

    // Lakukan proses penyimpanan ke database
    $stmt = $koneklocalhost->prepare("UPDATE users SET amirulpay_balance = amirulpay_balance + ? WHERE id = ?");
    $stmt->bind_param("di", $amount, $userId);
    $stmt->execute();
    $stmt->close();

    // Kembalikan respons sukses
    echo json_encode(["status" => "success", "message" => "Top up berhasil"]);
}
?>
