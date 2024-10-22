<?php

// establish a connection to the database
require_once 'db_connect.php';

// check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // get the username and password from the form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // query the database for the username and password
    $query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    // check if there is a match in the database
    if (mysqli_num_rows($result) == 1) {
        // login successful, redirect to dashboard
        header("Location: dashboard.html");
        exit();
    } else {
        // login failed, display an error message
        echo "Invalid username or password.";
    }
}

?>

<!-- HTML form for the login page -->
<head><h1>Login Page</h1>
<link rel="stylesheet" href="style.css">
</head>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>

    <input type="submit" value="Login">
</form>
