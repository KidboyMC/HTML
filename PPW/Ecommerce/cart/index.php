<?php 
$servername = "localhost";
$username = "root";
$password = "";
$database_name = "produk-katalog";

// Buat koneksi ke database, langsung memasukkan nama database
$db = mysqli_connect($servername, $username, $password, $database_name);

$sql = "SELECT * FROM cart_items";
$total = "SELECT price, quantity, (price * quantity) AS total FROM cart_items";
$harga = $db->query($total);
$result = $db->query($sql);

// Check connection
if (!$db) {
  die("Connection failed: " . mysqli_connect_error());
}

$no = 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'];
    
    if (isset($_POST['delete'])) {
        $deleteSql = "DELETE FROM cart_items WHERE product_id = ?";
        $stmt = $db->prepare($deleteSql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
    } else {
        // Perbarui kuantitas produk
        $newQuantity = (int)$_POST['quantity'];

        if ($newQuantity <= 0) {
            // Hapus data jika kuantitas 0
            $deleteSql = "DELETE FROM cart_items WHERE product_id = ?";
            $stmt = $db->prepare($deleteSql);
            $stmt->bind_param("i", $productId);
            $stmt->execute();
            $stmt->close();
        } else {
            // Update kuantitas jika > 0
            $updateSql = "UPDATE cart_items SET quantity = ? WHERE product_id = ?";
            $stmt = $db->prepare($updateSql);
            $stmt->bind_param("ii", $newQuantity, $productId);
            $stmt->execute();
            $stmt->close();
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cart.css">
    <link href="https://db.onlinewebfonts.com/c/f1fcc5aed1e20fc0cdb9f8a7573625bd?family=Integral+CF+Regular" rel="stylesheet">
    <title>Cart</title>
</head>
<body>
    <header>
        <div class="top-bar">
            <p>Sign up and get 20% off your first order. <a href="#">Sign Up Now</a></p>
        </div>
        <nav class="navbar">
            <div class="logo">SHOP<span style="color: #00adb5;">.CO</span></div>
            <ul class="nav-links">
                <li><a href="#">Shop</a></li>
                <li><a href="#">Top Sales</a></li>
                <li><a href="#">Offers</a></li>
                <li><a href="#">Seller</a></li>
            </ul>
            <div class="search-container">
                <button>
                    <a href="#"><img src="../home-product/icon/search.svg"></a>
                </button>
                <input type="text" placeholder="Search for products...">
            </div>
            <div class="cart-profile">
                <a href="#">
                    <img src="../home-product/icon/cart.svg" alt="Cart">
                </a>
                <a href="#">
                    <img src="../home-product/icon/profile.svg" alt="Profile">
                </a>
            </div>     
        </nav>
    </header>

    <div class="path">
        <p><a>Home</a>/<a>Cart</a></p>
        <h2>Your Cart</h2>
    </div>

    <section>
        <div>
            <?php 
            if ($result->num_rows > 0) {
                while ($tampil = $result->fetch_assoc())  {
                        echo 
                        '<div class="product-cart" style="
                        margin-bottom: 3vh !important;">
                            <div class="product-pict"></div>
                            <div class="left-side">
                                <h3>' . htmlspecialchars($tampil['nama']) . '</h3>
                                <p><span style="font-weight: 600;">Type:</span>' . htmlspecialchars($tampil['category']) . '</p>
                                <p style="font-size: 11px; margin-top: 10px;">IDR <span id="price">' . number_format(($tampil['price']*$tampil['quantity']), 0, ',', '.') . '</span></p>
                            </div>
                            <div class="right-side">
                            <form method="POST">
                            <input type="hidden" name="product_id" value="' . $tampil['product_id'] . '">
                                <button style="background-color: #ffffff00;" type="submit" name="delete" class="delete-button">
                                    <img id="trash-icon" src="img/trash.png">
                                </button>
                            </form>
                            <form method="POST" id="quantity">
                            <input type="hidden" name="product_id" value="' . $tampil['product_id'] . '">
                            
                            <button type="submit" name="quantity" value="' . max(0, $tampil['quantity'] - 1) . '" class="tambah-kurang">-</button>
                            
                            <span>' . $tampil['quantity'] . '</span>
                            
                            <button type="submit" name="quantity" value="' . ($tampil['quantity'] + 1) . '" class="tambah-kurang">+</button>
                            </form>
                            </div>
                            </div>';
                        $no++;
                    
                }
            } else {
                echo "Data kosong";
            }
            
            $db->close();
            ?>
        </div>
        
        <div class="order-summary">
            <div class="price">
                <p>Sub-total</p>
                <?php 
                if ($harga->num_rows > 0) {
                    $subtotal = 0;
                    while ($row = $harga->fetch_assoc()) {
                        $subtotal += $row['price']*$row['quantity'];
                    }
                    echo '<p>IDR<span id="subtotal-price">'. number_format($subtotal, 0, ',', '.'). '</span></p>';
                    }?>
            </div>

            <button id="CO">Go to Checkout</button>
        </div>
    </section>
    <div class="footer">
        <footer>
                <div class="banner">
                    <p>STAY UP TO DATE ABOUT OUR LATEST OFFERS</p>
                    <div class="mail">
                        <form id="e-mail">
                            <img width="18px" src="../footer-img/mail.png">
                            <input type="email" placeholder="Enter your email address"> 
                        </form>
                        <button>Subscribe to Newsletter</button>
                    </div>
                </div>
                    <div class="detail">
                        <div style="max-width: 28%;">
                            <p class="logo-web">SHOP<span style="color: #00ADB5;">.CO</span></p>
                            <p style="font-size: 14px; font-weight: 50; line-height: 1.5; color: rgba(0, 0, 0, 0.6)">
                                We have clothes that suits your style and which you’re proud to wear. From women to men.</p>
                            <div class="medsos">
                                <div><img src="../footer-img/twitter.png"></div>
                                <div style="background-color: #222831;"><img src="../footer-img/facebook.png"></div>
                                <div><img src="../footer-img/insta.png"></div>
                                <div><img src="../footer-img/github.png"></div>
                            </div>
                        </div>
                        
                        <table id="about-us">
                            <tr>
                                <th>COMPANY</th>
                                <th>HELP</th>
                                <th>FAQ</th>
                                <th>RECOURCES</th>
                            </tr>
                            <tr>
                                <td>About</td>
                                <td>Customer Support</td>
                                <td>Account</td>
                                <td>Free eBooks</td>
                            </tr>
                            <tr>
                                <td>Features</td>
                                <td>Delivery Details</td>
                                <td>Manage Deliveries</td>
                                <td>Development Tutorial</td>
                            </tr>
                            <tr>
                                <td>Works</td>
                                <td>Terms & Conditions</td>
                                <td>Orders</td>
                                <td>How to -Blog</td>
                            </tr>
                            <tr>
                                <td>Career</td>
                                <td>Privacy Policy</td>
                                <td>Payment</td>
                                <td>YouTube Playlist</td>
                            </tr>
                        </table>
                </div>
                <div id="garis"></div>
                <div class="butom">
                    <p id="copyright">
                        Shop.co © 2000-2023, All Rights Reserved
                    </p>

                    <div class="badges">
                        <div><img src="../footer-img/Visa.png"></div>
                        <div><img src="../footer-img/Mastercard.png"></div>
                        <div><img src="../footer-img/Paypal.png"></div>
                        <div><img src="../footer-img/applepay.png"></div>
                        <div><img src="../footer-img/G Pay.png"></div>
                    </div>
                </div>
        </footer>
    </div>
</body>
</html>