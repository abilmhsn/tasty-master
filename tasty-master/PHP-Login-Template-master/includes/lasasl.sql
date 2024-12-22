-- Membuat database
CREATE DATABASE UserLoginDB;

-- Gunakan database yang baru dibuat
USE UserLoginDB;


-- Membuat tabel Transactions
CREATE TABLE Transactions (
    TransactionID INT AUTO_INCREMENT PRIMARY KEY, -- ID unik untuk transaksi
    UserID INT NOT NULL, -- ID pengguna yang melakukan transaksi
    TotalAmount DECIMAL(10, 2) NOT NULL, -- Total jumlah pembayaran
    TransactionDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Tanggal transaksi
    FOREIGN KEY (UserID) REFERENCES Users(UserID) -- Relasi ke tabel Users
);
