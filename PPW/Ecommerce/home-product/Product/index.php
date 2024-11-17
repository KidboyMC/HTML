<?php include '../../kelola-produk/db_conn.php';

// Mengambil ID produk dari parameter URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Mengambil data produk berdasarkan product_id
$sql = "SELECT * FROM products WHERE product_id = $product_id";
$result = $conn->query($sql);

// Memeriksa apakah produk ditemukan
if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail Page</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link the CSS file here -->
</head>
<body>

   <!-- Header -->
   <header>
        <?php
            include "../../functionality/functionality.php";
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
                <a href="#">
                    <img src="../icon/cart.svg" alt="Cart">
                </a>
                <a href="#">
                    <img src="../icon/profile.svg" alt="Profile">
                </a>
                <label>
                    <?php
                        $text_login = "<strong style=\"color: #00ADB5;\">Sign In</strong>";
                        $login = "<a href=\"http://localhost/project/Perancangan-dan-Pemrograman-Web/login-register-user/login.php\"
                                style=\"text-decoration: none\">$text_login</a>";
                        echo isset($_SESSION["username"]) ? "<strong style=\"color: #00ADB5;\">" . $_SESSION["username"] . "</strong>" : $login;
                    ?>
                </label>
            </div>     
        </nav>
    <hr id="hr1">
</header>

    <!-- Breadcrumbs -->
    <div class="breadcrumb">
        <a href="#">Home</a> / <a href="#">Shop</a> / <a href="#">Men</a> / <a href="#">T-shirts</a>
    </div>

     <!-- Product Section -->
     <section class="product-section">
        <!-- Product Images Table Layout -->
        <div class="product-images">
            <img src="../../kelola-produk/upload/<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
        </div>
        <div class="product-info">
            <h2 class="product-title"><?php echo htmlspecialchars($product['product_name']); ?></h2>
            <div class="product-rating">
                <span>★★★★☆</span>
                <span id="rating">4.5/5</span>
            </div>
            <div class="product-price">
                $<?php echo htmlspecialchars($product['price']); ?>
            </div>
            <p class="product-description">
                <?php echo htmlspecialchars($product['description']); ?>
            </p>
            <hr>

            <!-- Color Selector -->
            <p style="color:rgb(0, 0, 0, 0.5)">Select Colors</p>
            <div class="color-selector">
                <div class="color-option" style="background-color: #4a5b2e;"></div>
                <div class="color-option selected" style="background-color: #333333;"></div>
                <div class="color-option" style="background-color: #2c3e50;"></div>
            </div>
            <hr>

            <!-- Size Selector -->
            <p style="color:rgb(0, 0, 0, 0.5)">Choose Size</p>
            <div class="size-selector">
                <div class="size-option">Small</div>
                <div class="size-option selected">Medium</div>
                <div class="size-option">Large</div>
                <div class="size-option">X-Large</div>
            </div>
            <hr>

            <!-- Quantity and Add to Cart -->
            <div class="quantity-cart-container">
                <div class="quantity-selector">
                    <button>-</button>
                    <input type="number" value="1" min="1">
                    <button>+</button>
                </div>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
        </div>
    </section>

    <!-- Tabs for Product Details and Reviews -->
    <div class="tabs">
        <div class="tab">Product Details</div>
        <div class="tab active">Rating & Reviews</div>
        <div class="tab">FAQs</div>
    </div>

    <!-- Reviews Section -->
<section class="reviews-section">
    <h3>
        All Reviews
        <span id="allreview">(451)</span>
    </h3>
    <div class="reviews-grid">
        <!-- Review 1 -->
        <div class="review-card">
            <p class="product-rating">★★★★★</p>
            <h4>Samantha D.</h4>
            <p>"I absolutely love this t-shirt! The design is unique and the fabric feels so comfortable..."</p>
            <p><small>Posted on August 14, 2023</small></p>
        </div>
        
        <!-- Review 2 -->
        <div class="review-card">
            <p class="product-rating">★★★★☆</p>
            <h4>Alex M.</h4>
            <p>"The t-shirt exceeded my expectations! The colors are vibrant and the print quality is top-notch..."</p>
            <p><small>Posted on August 15, 2023</small></p>
        </div>
        
        <!-- Review 3 -->
        <div class="review-card">
            <p class="product-rating">★★★★★</p>
            <h4>Ethan R.</h4>
            <p>"This t-shirt is a must-have for anyone who appreciates good design. The minimalist style caught my eye..."</p>
            <p><small>Posted on August 16, 2023</small></p>
        </div>
        
        <!-- Review 4 -->
        <div class="review-card">
            <p class="product-rating">★★★★☆</p>
            <h4>Olivia P.</h4>
            <p>"As a UX/UI enthusiast, I value simplicity and functionality. This t-shirt not only represents those principles..."</p>
            <p><small>Posted on August 17, 2023</small></p>
        </div>
        
        <!-- Review 5 -->
        <div class="review-card">
            <p class="product-rating">★★★★★</p>
            <h4>Liam K.</h4>
            <p>"This t-shirt is a fusion of comfort and creativity. The fabric is soft, and the design speaks volumes..."</p>
            <p><small>Posted on August 18, 2023</small></p>
        </div>
        
        <!-- Review 6 -->
        <div class="review-card">
            <p class="product-rating">★★★★☆</p>
            <h4>Ava H.</h4>
            <p>"I'm not just wearing a t-shirt; I'm wearing a piece of design philosophy. The intricate details..."</p>
            <p><small>Posted on August 19, 2023</small></p>
        </div>
    </div>
</section>

<button class="more-review">Load More Reviews</button>

     <!-- Offers Section -->
     <section class="offers">
        <h2>Offers</h2>
        <div class="products">
            <div class="product-card">
                <a href="#">
                    <img src="../pict/99129445_p0.jpg" alt="Product"><br>
                </a>
                <div class="product-card-details">
                    <a href="#">Product Name</a>
                    <div class="product-rating">
                        ★★★★☆ <span id="rating"> 4/5</span>
                    </div>
                    <div class="product-price">Price<span class="original-price">Price</span><span class="discount">XX%</span></div>
                </div>
            </div>

            <div class="product-card">
                <a href="#">
                    <img src="../pict/110666530_p0.jpg" alt="Product"><br>
                </a>
                <div class="product-card-details">
                    <a href="#">Product Name</a>
                    <div class="product-rating">
                        ★★★★☆ <span id="rating"> 4/5</span>
                    </div>
                    <div class="product-price">Price<span class="original-price">Price</span><span class="discount">XX%</span></div>
                </div>
            </div>

            <div class="product-card">
                <a href="#">
                    <img src="../pict/110666530_p0.jpg" alt="Product"><br>
                </a>
                <div class="product-card-details">
                    <a href="#">Product Name</a>
                    <div class="product-rating">
                        ★★★★☆ <span id="rating"> 4/5</span>
                    </div>
                    <div class="product-price">Price<span class="original-price">Price</span><span class="discount">XX%</span></div>
                </div>
            </div>

            <div class="product-card">
                <a href="#">
                    <img src="../pict/99129445_p0.jpg" alt="Product"><br>
                </a>
                <div class="product-card-details">
                    <a href="#">Product Name</a>
                    <div class="product-rating">
                        ★★★★☆ <span id="rating"> 4/5</span>
                    </div>
                    <div class="product-price">Price<span class="original-price">Price</span><span class="discount">XX%</span></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter">
        <div class="newsletter-content">
            <h2>STAY UPTO DATE ABOUT OUR LATEST OFFERS</h2>
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

<?php
} else {
    // Jika produk tidak ditemukan
    echo "<h1>Produk tidak ditemukan.</h1>";
}
