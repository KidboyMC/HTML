<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Header -->
    <header>
        <?php
            include "../../functionality/const.php";
            
            session_start();
        ?>

        <nav class="navbar">
            <div class="logo">SHOP<span style="color: #00adb5;">.CO</span></div>
            <ul class="nav-links">
                <li><a href=<?php echo htmlspecialchars($GLOBALS["home_page"]); ?>>Shop</a></li>
                <li><a href=<?php echo htmlspecialchars(($GLOBALS["home_page"] . "#top-sales")); ?>>Top Sales</a></li>
                <li><a href=<?php echo htmlspecialchars(($GLOBALS["home_page"] . "#offers")); ?>>Offers</a></li>
                <li><a href="#">Seller</a></li>
            </ul>
            <div class="search-container">
                <button>
                    <a href="#"><img src="../icon/search.svg"></a>
                </button>
                <input type="text" placeholder="Search for products...">
            </div>
            <div class="cart-profile">
                <a href=<?php echo htmlspecialchars($GLOBALS["cart_url"]);?>>
                    <img src="../icon/cart.svg" alt="Cart">
                </a>
                <a href=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>>
                    <img src="../icon/profile.svg" alt="Profile">
                </a>
                <label>
                    <?php echo "<strong style=\"color: #00ADB5;\">" . $_SESSION["username"] . "</strong>";?>
                </label>
            </div>     
        </nav>
    </header>
    <div class="container">
        
        <!-- User Profile Section -->
        <div class="profile-section">
            <div class="profile-header">
                <img src="../pict/99129445_p0.jpg" alt="User Profile Picture" class="profile-pic">
                <div class="profile-info">
                    <h2 class="username"><?php echo $_SESSION["username"]?></h2>
                    <?php
                        if (!isset($_SESSION["created_at"])) {
                            $_SESSION["created_at"] = date("Y-m-d H:i:s"); // Default ke waktu sekarang
                        }

                        $date = new DateTime($_SESSION["created_at"]); 
                        echo "<p class=\"user-status\">Member since " . $date->format("F Y") . "</p>"; 
                    ?>
                    <a href="edit.php"><button class="edit-profile">Edit Profile</button></a>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <nav class="nav-tabs">
            <button class="tab active" onclick="openTab(event, 'orders')">Orders</button>
            <button class="tab" onclick="openTab(event, 'wishlist')">Wishlist</button>
            <button class="tab" onclick="openTab(event, 'reviews')">Reviews</button>
            <button class="tab" onclick="openTab(event, 'settings')">Settings</button>
        </nav>

        <!-- Orders Section -->
        <div id="orders" class="tab-content active">
            <h3>Current Orders</h3>
            <div class="order-item">
                <img src="../pict/110666530_p0.jpg" alt="Product Image">
                <div class="order-details">
                    <h4>Product Name</h4>
                    <p>Order Date: 01/01/2023</p>
                    <p>Status: Delivered</p>
                    <a href=<?php echo htmlspecialchars($GLOBALS["product_detail"]); ?>><button class="view-details">View Details</button></a>
                </div>
            </div>
            <!-- Additional order items can be added here -->
        </div>

         <!-- Wallet Section -->
         <section class="wallet-section">
            <div class="wallet-item">
                <div class="icon">💰</div>
                <p>Dana</p>
                <span>Rp520.000</span>
            </div>
            <div class="wallet-item">
                <div class="icon">💸</div>
                <p>Paypal</p>
                <span>Rp180.000</span>
            </div>
            <div class="wallet-item">
                <div class="icon">🎫</div>
                <p>Voucher</p>
                <span>50+ Voucher</span>
            </div>
            <div class="wallet-item">
                <div class="icon">💳</div>
                <p>Shop.Pay</p>
                <span>Rp100.000</span>
            </div>
        </section>

        <!-- My Activities Section -->
        <section class="activities-section">
            <h3>Aktivitas Saya</h3>
            <div class="activities-grid">
                <div class="activity-item">
                    <div class="icon">💼</div>
                    <p>Shop Affiliate Program</p>
                </div>
                <div class="activity-item">
                    <div class="icon">❤️</div>
                    <p>Favorit Saya</p>
                </div>
                <div class="activity-item">
                    <div class="icon">🎥</div>
                    <p>Live Center</p>
                </div>
                <div class="activity-item">
                    <div class="icon">🎬</div>
                    <p>Video Center</p>
                </div>
                <div class="activity-item">
                    <div class="icon">⏰</div>
                    <p>Terakhir Dilihat</p>
                </div>
                <div class="activity-item">
                    <div class="icon">🏬</div>
                    <p>Katalog Saya</p>
                </div>
            </div>
        </section>

        <!-- Help Section -->
        <section class="help-section">
            <h3>Bantuan</h3>
            <div class="help-item">
                <div class="icon">❓</div>
                <p>Pusat Bantuan</p>
            </div>
            <div class="help-item">
                <div class="icon">💬</div>
                <p>Chat dengan Shopee</p>
            </div>
        </section>
    </div>

    <!-- Newsletter Section -->
    <section class="newsletter">
        <div class="newsletter-content">
            <h2>STAY UPTO DATE ABOUT OUR LATEST OFFERS</h2><br>
            <form class="newsletter-form">
                <input type="email" placeholder="Enter your email address" required>
                <button type="submit">Subscribe to Newsletter</button>
            </form>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-brand">
                <h3>SHOP.CO</h3>
                <p>We have clothes that suits your style and which you’re proud to wear. From women to men.</p><br>
                <div class="social-icons">
                    <a href="#"><img src="../icon/twitter.svg"></a>
                    <a href="#"><img src="../icon/fb.svg"></a>
                    <a href="#"><img src="../icon/ig.svg"></i></a>
                    <a href="#"><img src="../icon/github.svg"></i></a>
                </div>
            </div>
            <div class="footer-links">
                <div class="footer-column">
                    <h4>COMPANY</h4>
                    <a href="#">About</a>
                    <a href="#">Features</a>
                    <a href="#">Works</a>
                    <a href="#">Career</a>
                </div>
                <div class="footer-column">
                    <h4>HELP</h4>
                    <a href="#">Customer Support</a>
                    <a href="#">Delivery Details</a>
                    <a href="#">Terms & Conditions</a>
                    <a href="#">Privacy Policy</a>
                </div>
                <div class="footer-column">
                    <h4>FAQ</h4>
                    <a href="#">Account</a>
                    <a href="#">Manage Deliveries</a>
                    <a href="#">Orders</a>
                    <a href="#">Payments</a>
                </div>
                <div class="footer-column">
                    <h4>RESOURCES</h4>
                    <a href="#">Free eBooks</a>
                    <a href="#">Development Tutorial</a>
                    <a href="#">How to - Blog</a>
                    <a href="#">Youtube Playlist</a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>Shop.co © 2000-2023, All Rights Reserved</p>
        </div>
    </footer>
</body>
</html>
