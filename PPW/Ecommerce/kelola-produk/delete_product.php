<?php
include "db_conn.php";

if (isset($_GET['product_id'])) {
    $product = $_GET['product_id'];

    // Query untuk menghapus produk dari database
    $sql = "DELETE FROM products WHERE product_id = $product";
    if (mysqli_query($conn, $sql)) {
        // Redirect kembali ke halaman utama setelah hapus
        header("Location: index.php");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    header("Location: index.php");
    exit();
}
?>
