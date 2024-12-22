<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "loginsystem";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mendapatkan data transaksi berdasarkan ID Transaksi
$transactionId = $_GET['transaction_id']; // Ambil ID transaksi dari URL atau input
$sql = "SELECT t.TransactionID, t.UserID, t.TotalAmount, t.TransactionDate
        FROM transactions t
        JOIN users u ON t.UserID = idUsers
        WHERE t.TransactionID = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $transactionId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Menampilkan data transaksi
    $row = $result->fetch_assoc();
    echo "<h1>Nota Pembelian</h1>";
    echo "<p><strong>ID Transaksi:</strong> " . $row['TransactionID'] . "</p>";
    echo "<p><strong>Nama Pengguna:</strong> " . $row['Username'] . "</p>";
    echo "<p><strong>Email:</strong> " . $row['Email'] . "</p>";
    echo "<p><strong>Tanggal Transaksi:</strong> " . $row['TransactionDate'] . "</p>";
    echo "<p><strong>Total Pembayaran:</strong> Rp" . number_format($row['TotalAmount'], 2, ',', '.') . "</p>";
} else {
    echo "<p>Transaksi tidak ditemukan.</p>";
}

// Tutup koneksi
$conn->close();
?>
