<?php include "db_conn.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://db.onlinewebfonts.com/c/f1fcc5aed1e20fc0cdb9f8a7573625bd?family=Integral+CF+Regular" rel="stylesheet">
</head>
<body> 
    <nav class="sidenav">
        <div id="logo" style="color: white;">SHOP<span style="color: #00ADB5;">.CO</span></div>
        <div class="menu">
            <p>MENU</p>
            <a id="dashboard"><img src="../sidenav-seller-img/Chart.png">Dashboard</a>
            <a id="manage-order"><img src="../sidenav-seller-img/Document-active.png">Manage Order</a>
        </div>
    
        <div class="others">
            <p>OTHERS</p>
            <a id="settings"><img src="../sidenav-seller-img/Setting.png">Settings</a>
            <a id="accounts"><img src="../sidenav-seller-img/Profile.png">Accounts</a>
        </div>
    </nav>

    <section>
        <div class="isi" id="header">
            <form id="search-bar">
                <img width="20" height="20" src="../dashboard-seller/img/search.png"/>
                <input type="search" placeholder="Search" id="search">
            </form>
            <div>
                <div id="profile">
                    <img id="pp" src="../home-product/icon/profile.svg">
                    <a>User</a>
                    <a><img id="dropdown" src="https://img.icons8.com/ios-filled/50/expand-arrow--v1.png" alt="expand-arrow--v1"/></a>
                    <a><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAuElEQVR4nO2UQQoCMQxFu/MQeiA9jINHcOllNBFhtkICMpiIunVc6Rl0WyniMCBq2xlFcQIfCoX3kkBrzN8UsAyR1bq48+8I0nTXQtIESfeFgCQHkr67qwQfz7MOsGxv4LuQbGaLdTu686fwkiRqEmAdvIQXEk3CBSTiKwDWLFiApGdvAekpXOC7Hr6mEdhmRQ8/NvTPyLwRbr0lFeA26j18rJD1WOr0ULtgwsueA7tMadWtXfC1dQGPzHlQRmGhaQAAAABJRU5ErkJggg=="></a>
                </div>
            </div>
        </div>

        <div id="garis"></div>

        <div class="main">
            <h1>YOUR PRODUCTS</h1>
            <div class="add-product">
                <h3>Add Product</h3>
                
                <div>
                    <?php if(isset($_GET['error'])): ?>
                        <p><?php echo $_GET['error']; ?></p>
                    <?php endif ?>   
                    <form action="upload.php" method="POST" enctype="multipart/form-data">
                        <div id="left-side">
                            <label for="image">Product Image</label>
                            <input type="file" id="image" name="image" required><br><br>
                        </div>
                        <div class="right-side">
                            <div class="input-new-product">
                            <table>
                                <tr>
                                    <td><label for="product_name">Product Name</label><br>
                                        <input type="text" id="product_name" name="product_name" placeholder="Enter product name" required>
                                </tr>
                                <tr>
                                    <td><label for="price">Price</label><br>
                                        <input type="number" id="price" name="price" placeholder="Enter product price"  pattern="^(0|[1-9]\d*)" required>
                                </tr>
                                <tr>
                                    <td><label for="discount">Discount</label><br>
                                        <input type="number" id="discount" name="discount" placeholder="Enter product discount"  pattern="^(0|[1-9]\d*)" required>
                                </tr>
                            </table>
                            <table>
                                <tr>
                                    <td><label for="qty">Quantity</label><br>
                                        <input type="number" id="qty" name="qty" placeholder="Enter product Quantity"  pattern="^(0|[1-9]\d*)" required>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="category">Category</label><br>
                                        <select id="category" name="category">
                                        <option value="" disabled selected>Select an option</option>
                                        <option value="Makeup">Makeup</option>
                                        <option value="Gaming Accesories">Gaming Accesories</option>
                                        <option value="Kitchen Appliances">Kitchen Appliances</option>
                                        <option value="Clothes">Clothes</option>
                                        <option value="Books">Books</option>
                                        <option value="Toys">Toys</option>
                                    </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="description">Product Description</label><br>
                                        <input type="text" id="description" name="description" placeholder="Enter product description">
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <input type="submit" name="submit" value="Add Product" id="submit-add">
                        </div>
                    </form>
                </div>
            </div>

            <div class="cards" id="products">
                <div class="top">
                    <h3>Products</h3>
                </div>
                <table id="products-table">
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>Quantity</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                    <tr>
                    <?php
                    // Mengambil data produk dari database
                    $sql = "SELECT * FROM products ORDER BY product_id DESC";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        // Menampilkan data produk ke dalam tabel
                        while ($product = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$product['product_name']}</td>";
                            echo "<td>{$product['price']}</td>";
                            echo "<td>{$product['discount']}</td>";
                            echo "<td>{$product['qty']}</td>";
                            echo "<td>{$product['category']}</td>";
                            echo "<td>{$product['description']}</td>";
                            echo "<td><a href='delete_product.php?product_id={$product['product_id']}' onclick='return confirm(\"Are you sure you want to delete this product?\")'>Delete</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No products found</td></tr>";
                    }
                    ?>
                    </tr>
                </table>
            </div>
        </div>
        </div>
        <div class="footer">
            <footer>
                    <div class="banner">
                        <p>STAY UP TO DATE ABOUT OUR LATEST OFFERS</p>
                        <div class="mail">
                            <form id="e-mail">
                                <img width="18px" src="../footer-img/mail.png">
                                <input type="email" placeholder="Enter your email address"> 
                            </form>
                            <button id="Subscribe">Subscribe to Newsletter</button>
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
    </section>
</body>
</html>