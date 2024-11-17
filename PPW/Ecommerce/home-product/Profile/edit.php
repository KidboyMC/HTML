<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <?php
            include "../../functionality/functionality.php";
            include "../../functionality/const.php";

            session_start();
            $is_existed = false;
            $conn = new mysqli("localhost", "root","","ecommerce_db");

            if ($conn->connect_error) {
                die("Connection failed: ". $conn->connect_error);
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $first_name = $_POST["first_name"];
                $last_name = $_POST["last_name"];
                $dob = $_POST["dob"];
                $phone = $_POST["phone"];
                $address1 = $_POST["address1"];
                $address2 = $_POST["address2"];
                $city = $_POST["city"];
                $state = $_POST["state"];
                $country = $_POST["country"];
                $zip = $_POST["zip"];

                $phone_duplicate = any_duplicate($conn, "phone", $phone, "user_profile");
                $row = $phone_duplicate->fetch_assoc();

                if ($phone_duplicate->num_rows > 0 && $_SESSION["user_id"] != $row["user_id"]) {
                    $phone_error = "Phone already registered";
                }

                if (!isset($phone_error)) {
                    if ($_SESSION["is_profile_complete"]) {
                        $query = "UPDATE user_profile SET first_name=?, last_name=?, dob=?, phone=?, address1=?, address2=?, city=?, 
                        state=?, country=?, zip=? WHERE user_id = ?;";
                        $user_entry = $conn->prepare($query);
                        $user_entry->bind_param(
                            "ssssssssssi", 
                            $first_name, $last_name, $dob, $phone, $address1, $address2, $city, 
                            $state, $country, $zip, $_SESSION["user_id"]
                        );

                        $user_entry->execute();
                        $user_entry->close();
                    } else {
                        $query = "INSERT INTO user_profile (user_id, first_name, last_name, dob, phone, address1, address2, city, state,
                        country, zip) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                        $user_entry = $conn->prepare($query);
                        $user_entry->bind_param(
                            "issssssssss", 
                            $_SESSION["user_id"], $first_name, $last_name, $dob, $phone, $address1, $address2, $city, 
                            $state, $country, $zip
                        );
                        
                        $user_entry->execute();
                        $user_entry->close();
                        $_SESSION["is_profile_complete"] = true;
                        $href = $GLOBALS["home_page"];
                        header("Location: ". $href ."");
                    }
                }
            }
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
                <a href=<?php echo htmlspecialchars($GLOBALS["cart_url"]) ?>>
                    <img src="../icon/cart.svg" alt="Cart">
                </a>
                <a href=<?php echo htmlspecialchars($GLOBALS["profile_url"]) ?>>
                    <img src="../icon/profile.svg" alt="Profile">
                </a>
                <label>
                    <?php echo "<strong style=\"color: #00ADB5;\">" . $_SESSION["username"] . "</strong>";?>
                </label>
            </div>     
        </nav>
    </header>

    <section class="section-edit">
        <form id="edit" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="POST">
            <div class="left-side">
                <?php 
                    if (!$_SESSION["is_profile_complete"]) {
                        echo "<h2>Isi dulu data diri kamu ya...</h2>";
                    }

                    $stmt = $conn->prepare("SELECT * FROM user_profile WHERE user_id = ?");
                    $stmt->bind_param("i", $_SESSION["user_id"]);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();

                    if ($result->num_rows > 0) {
                        $is_existed = true;
                    }
                ?>
                
                <label>First Name:</label>
                <?php
                    if ($is_existed) {
                        $the_name = $row["first_name"];
                        echo "<input type=\"text\" name=\"first_name\" value=\"$the_name\">";
                    } else {
                        echo "<input type=\"text\" name=\"first_name\">";
                    }
                ?>
                
                <label>Last Name:</label>
                <?php
                    if ($is_existed) {
                        $the_value = $row["last_name"];
                        echo "<input type=\"text\" name=\"last_name\" value=\"$the_value\">";
                    } else {
                        echo "<input type=\"text\" name=\"last_name\">";
                    }
                ?>

                <label>Date of Birth:</label>
                <?php
                    if ($is_existed) {
                        $the_value = $row["dob"];
                        echo "<input type=\"date\" name=\"dob\" value=\"$the_value\">";
                    } else {
                        echo "<input type=\"date\" name=\"dob\" value=\">";
                    }
                ?>
    
                <?php
                    $the_value = $row["phone"];
                    echo isset($phone_error) ? "<label style=\"color: red;\">$phone_error:</label>" : "<label>Phone Number:</label>";
                    echo isset($phone_error) ? "<input type=\"text\" name=\"phone\">" : "<input type=\"text\" name=\"phone\" value=\"$the_value\">";
                ?>

                <label>Address Line 1:</label>
                <?php
                    if ($is_existed) {
                        $the_value = $row["address1"];
                        echo "<input type=\"text\" name=\"address1\" value=\"$the_value\">";
                    } else {
                        echo "<input type=\"text\" name=\"address1\">";
                    }
                ?>

                <label>Address Line 2:</label>
                <?php
                    if ($is_existed) {
                        $the_value = $row["address2"];
                        echo "<input type=\"text\" name=\"address2\" value=\"$the_value\">";
                    } else {
                        echo "<input type=\"text\" name=\"address2\">";
                    }
                ?>

                <label>City:</label>
                <?php
                    if ($is_existed) {
                        $the_value = $row["city"];
                        echo "<input type=\"text\" name=\"city\" value=\"$the_value\">";
                    } else {
                        echo "<input type=\"text\" name=\"city\">";
                    }
                ?>

                <label>State:</label>
                <?php
                    if ($is_existed) {
                        $the_value = $row["state"];
                        echo "<input type=\"text\" name=\"state\" value=\"$the_value\">";
                    } else {
                        echo "<input type=\"text\" name=\"state\">";
                    }
                ?>

                <label>Country:</label>
                <?php
                if ($is_existed) {
                    $the_value = $row["country"];
                    echo "<input type=\"text\" name=\"country\" value=\"$the_value\">";
                } else {
                    echo "<input type=\"text\" name=\"country\">";
                }
                ?>

                <label>Postal Code:</label>
                <?php
                if ($is_existed) {
                    $the_value = $row["zip"];
                    echo "<input type=\"text\" name=\"zip\" value=\"$the_value\">";
                } else {
                    echo "<input type=\"text\" name=\"zip\">";
                }
                ?>
    
                <input type="submit" id="submit-edit">
            </div>
            <?php 
                $stmt->close();
                $conn->close();
            ?>
            <div class="right-side">
                <div><img></div>
                <button class="change-pp">Change Profile Picture</button>
            </div>
        </form>
    </section>
    

    <section class="newsletter">
        <div class="newsletter-content">
            <h2>STAY UPDATE ABOUT OUR LATEST OFFERS</h2><br>
            <form class="newsletter-form">
                <input type="email" placeholder="Enter your email address" required>
                <button type="submit">Subscribe to Newsletter</button>
            </form>
        </div>
    </section>

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