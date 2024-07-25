<?php
// Ambil data transaksi dari database
$koneklocalhost = new mysqli("localhost", "username", "password", "db_amirulpay");
$result = $koneklocalhost->query("SELECT id, tanggal, amount, type, status FROM transactions");
$transactions = [];
while ($row = $result->fetch_assoc()) {
    $transactions[] = $row;
}
$koneklocalhost->close();

// Kembalikan data dalam format yang sesuai dengan DataTables
echo json_encode(["data" => $transactions]);
?>
