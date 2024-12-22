<?php
// Mulai sesi untuk login (jika diperlukan)
session_start();

// Dummy data untuk produk baju
$products = [
    ["name" => "Bomber Vintage", "price" => 20.50, "image" => "images/BOMBER.jpg"],
    ["name" => "Varsity Jacket", "price" => 19.00, "image" => "images/VARSITY.jpg"],
    ["name" => "Workwear Jacket", "price" => 17.99, "image" => "images/WORKWEAR.jpg"],
    ["name" => "Jaket Vintage", "price" => 22.50, "image" => "images/vintage.jpg"],
];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected_product = $_POST['product'] ?? '';
    $quantity = (int) ($_POST['quantity'] ?? 1);

    if ($selected_product && $quantity > 0) {
        $product = array_filter($products, fn($p) => $p['name'] === $selected_product);
        if (!empty($product)) {
            $product = array_values($product)[0];
            $total_price = $quantity * $product['price'];

            // Redirect ke nota.php dengan parameter transaksi
            $transaction_id = rand(1000, 9999); // Dummy ID transaksi untuk contoh
            $_SESSION['transaction'] = [
                'transaction_id' => $transaction_id,
                'product_name' => $product['name'],
                'quantity' => $quantity,
                'total_price' => $total_price
            ];

            header("Location: PHP-Login-Template-master/includes/nota.php?transaction_id=$transaction_id");
            exit;
        }
    } else {
        echo "<script>alert('Pilih produk dan masukkan jumlah yang valid.');</script>";
    }
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Pembelian</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Dashboard Pembelian Baju</h1>
    <div class="row mt-4">
        <?php foreach ($products as $product): ?>
            <div class="col-md-3">
                <div class="card mb-4">
                    <img src="<?= $product['image']; ?>" class="card-img-top" alt="<?= $product['name']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $product['name']; ?></h5>
                        <p class="card-text">Harga: $<?= number_format($product['price'], 2); ?></p>
                        <form method="POST" action="">
                            <input type="hidden" name="product" value="<?= $product['name']; ?>">
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Jumlah</label>
                                <input type="number" name="quantity" class="form-control" min="1" value="1" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Beli Sekarang</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
