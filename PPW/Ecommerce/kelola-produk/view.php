<?php include "db_conn.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>View</title>
    <style>
       body {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        min-height: 100vh;
        margin: 0;
        font-family: Arial, sans-serif;

        }
        .product-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* Membuat dua kolom */
            gap: 20px; /* Menambahkan jarak antar elemen */
            width: 80%; /* Mengatur lebar kontainer */
            max-width: 800px; /* Membatasi lebar maksimum */
            margin: 20px auto;
        }
        .alb {
            display: flex;
            flex-direction: column;
            align-items: center;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        .alb img {
            width: 100%; /* Memastikan gambar mengisi penuh kontainer .alb */
            height: auto;
            border-radius: 8px;
        }
        .product-info {
            margin-top: 10px;
            text-align: center;
        }
        a {
            text-decoration: none;
            color: black;
        }
    </style>
</head>
<body>
    <a href="index.php">&#8592;</a>
    <div class="product-container">
        <?php
            $sql = "SELECT * FROM products ORDER BY product_id DESC";
            $res = mysqli_query($conn, $sql);

            if (mysqli_num_rows($res) > 0) {
                while ($products = mysqli_fetch_assoc($res)) { ?>
                    <div class="alb">
                        <img src="upload/<?=$products['image']?>">
                    </div>
                <?php } } ?>
    </div>        
</body>
</html>