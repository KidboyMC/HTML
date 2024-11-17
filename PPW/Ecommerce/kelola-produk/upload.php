<?php

if (isset($_POST['submit']) && isset($_FILES['image'])) {
    include "db_conn.php";

    $img_name = $_FILES['image']['name'];
    $img_size = $_FILES['image']['size'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $error = $_FILES['image']['error'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];
    $qty = $_POST['qty'];
    $category = $_POST['category'];
    $description = $_POST['description'];

    if ($error === 0) {
        if ($img_size > 1250000) {
            $em = "Sorry, your file is too large";
            header("Location: index.php?error=$em");
        }else {
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);

            $allowed_exs = array("jpg", "jpeg", "png");

            if (in_array($img_ex_lc, $allowed_exs)) {
                $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
                $img_upload_path = 'upload/'.$new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);

                // Insert to DB
                $sql = "INSERT INTO products (image, product_name, price, discount, qty, category, description) VALUES ('$new_img_name', '$product_name', '$price', '$discount', '$qty', '$category', '$description')";
                if (mysqli_query($conn, $sql)){
                    header("Location: index.php");
                }else {
                    $em = "Database insertion error!";
                    header("Location: index.php?error=$em");
                }
            }else {
                $em = "You can't upload files of this type";
                header("Location: index.php?error=$em");
            }
        }
    }else {
        $em = "unknown error occured!";
        header("Location: index.php?error=$em");
    }
    
}else {
    header("Location: index.php");
}
?>