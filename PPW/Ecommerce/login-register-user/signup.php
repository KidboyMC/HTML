<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        include "../functionality/functionality.php";
        include "../functionality/const.php";

        $is_saved = false;
        $conn = new mysqli("localhost", "root","","ecommerce_db");

        if ($conn->connect_error) {
            die("Connection failed: ". $conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST["username"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $confirmed_password = $_POST["confirmed_password"];

            $username_duplicate = any_duplicate($conn, "username", $username,"users");

            if (empty($username)) {
                $username_error = "Username is required";
            } else if (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
                $username_error = "Username can only contain letters, numbers, and underscores";
            } else if ($username_duplicate->num_rows > 0) {
                $username_error = "Username already taken";
            }

            $email_duplicate = any_duplicate($conn, "email", $email,"users");
            
            if (empty($email)) {
                $email_error = "Email is required";
            }   else if ($email_duplicate->num_rows > 0) {
                $email_error = "Email already registered";
            }

            if (empty($password)) {
                $password_error = "Password is required";
            } else if (strlen($password) < 8) {
                $password_error = "Password must be at least 8 characters long";
            }

            if ($password != $confirmed_password) {
                $confirmed_password_error = "Password does not confirm";
            }

            if (!isset($username_error) && !isset($email_error) && !isset($password_error) && !isset($confirmed_password_error)) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
                $user_entry = $conn->prepare($query);
                $user_entry->bind_param("sss", $username, $email, $hashed_password);
                $user_entry->execute();
                $user_entry->close();
                
                $is_saved = true;
            }
        }

        $conn->close();
    ?>

    <section class="image">
        <div><img style="width: 100%; object-fit: contain" src="img/signup.png"></div>
    </section>
    
    <section class="right-side">
        <div>
            <h1>Create an Account</h1>
            <p>Please enter your contact detail to create account</p>
            <form id="regisform" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <table>
                    <tr>
                        <td colspan="3">
                            <button id="google">
                                <img width="20vw" src="img/google.png">
                                <a>Sign up with Google</a>
                            </button>
                        </td>
                    </tr>
        
                    <tr>
                        <td style="width: 45%;">
                            <div id="garis"></div>
                        </td>
                        <td style="width: 10%; text-align: center;">
                            <p>OR</p>
                        </td>
                        <td style="width: 45%;">
                            <div id="garis"></div>
                        </td>
                    </tr>

                    <?php
                        if (isset($username_error)) {
                            echo "<tr><td colspan=\"3\" style=\"color: red;\">$username_error</td></tr>";
                        } else {
                            echo "<tr><td colspan=\"3\"><label>Username</label></td></tr>";
                        }

                        if (isset($username)) {
                            dynamic_element("Username", $username, $is_saved);
                        } else {
                            echo "<tr><td colspan=\"3\"><input type=\"text\" name=\"username\" placeholder=\"username\"></td></tr>";
                        }
                    
                        if (isset($email_error)) {
                            echo "<tr><td colspan=\"3\"><label style=\"color: red;\">$email_error</label></td></tr>";
                        } else {
                            echo "<tr><td colspan=\"3\"><label>Email</label></td></tr>";
                        }

                        if (isset($email)) {
                            dynamic_element("Email", $email, $is_saved);
                        } else {
                            echo "<tr><td colspan=\"3\"><input type=\"email\" name=\"email\" placeholder=\"email\"></td></tr>";
                        }
                        
                        $static_field = "<td colspan=\"3\"><input type=\"password\" name=\"confirmed_password\" placeholder=\"confirmed password\"></td>";

                        if (isset($password_error) || isset($confirmed_password_error)) {
                            $password_label = "<td colspan=\"1\"";
                            $password_field = "<td colspan=\"1\"><input type=\"password\" name=\"password\" ";

                            if (isset($password_error)) {
                                $password_label = $password_label . "style=\"color: red;\">$password_error</td>";
                                $password_field = $password_field . "placeholder=\"password\"></td>";
                            } else {
                                $password_label = $password_label . "><label>Password</label></td>";
                                $password_field = $password_field . "value=\"$password\"></td>";
                            }
                            
                            $confirmed_password_label = "<td colspan=\"3\"";

                            if (isset($confirmed_password_error)) {
                                $confirmed_password_label = $confirmed_password_label . "style=\"color: red;\">$confirmed_password_error</td>";
                            } else {
                                $confirmed_password_label = $confirmed_password_label . "><label>Confirmed Password</label></td>";
                            }
                            
                            echo "<tr>
                                    $password_label
                                    <td></td>
                                    $confirmed_password_label
                                 </tr>";
                            echo "<tr>
                                    $password_field
                                    <td></td>
                                    $static_field
                                 </tr>";
                        } else {
                            echo "<tr>
                                    <td colspan=\"1\"><label>Password</label></td>
                                    <td></td>
                                    <td colspan=\"3\"><label>Confirmed Password</label></td>
                                 </tr>";
                            echo "<tr>
                                    <td colspan=\"1\"><input type=\"password\" name=\"password\" placeholder=\"password\"></td>
                                    <td></td>
                                    $static_field
                                 </tr>";
                        }
                    
                        if ($is_saved) {
                            echo "<tr><td colspan=\"3\" style=\"color: green;\">Registration Successful</td></tr>";
                        }
                    ?>

                    <tr>
                        <td colspan="3">
                            <button id="submit" type="submit">Sign up</button>
                        </td>
                    </tr>
    
                    <tr>
                        <td colspan="3" style="text-align: center;">
                            Already have an account? 
                            <a href= <?php echo htmlspecialchars("login.php") ?> style="text-decoration:none;">
                            <strong style="color: #00ADB5;">Sign In</strong></a>
                        </td>
                    </tr>
                </form>
            </table>
        </div>
    </section>
</body>
</html>