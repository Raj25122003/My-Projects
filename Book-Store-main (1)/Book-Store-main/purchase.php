<?php
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['bookID']) && isset($_POST['numCopies']) && isset($_POST['customerName'])) {
    $customerName = $_POST['customerName'];
    $purchaseDate = date('Y-m-d');

    // Insert a new purchase record into the Purchases table
    $insertPurchaseQuery = "INSERT INTO Purchases (CustomerName, PurchaseDate) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $insertPurchaseQuery);
    mysqli_stmt_bind_param($stmt, 'ss', $customerName, $purchaseDate);

    if (!mysqli_stmt_execute($stmt)) {
        die("Error inserting purchase record: " . mysqli_error($conn));
    }

    // Get the last inserted PurchaseID
    $purchaseID = mysqli_insert_id($conn);

    // Initialize total cost
    $totalCost = 0;

    // Loop through each book purchase
    for ($i = 0; $i < count($_POST['bookID']); $i++) {
        $bookID = $_POST['bookID'][$i];
        $numCopies = $_POST['numCopies'][$i];

        // Check if bookID exists and available copies are sufficient
        $selectCopiesQuery = "SELECT No_Of_Copies FROM Copies WHERE BookID = ?";
        $stmt = mysqli_prepare($conn, $selectCopiesQuery);
        mysqli_stmt_bind_param($stmt, 'i', $bookID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (!$result) {
            die("Error: " . mysqli_error($conn));
        }

        $row = mysqli_fetch_assoc($result);

        if (!$row) {
            die("Error: BookID $bookID not found");
        }

        $availableCopies = $row['No_Of_Copies'];

        if ($numCopies > $availableCopies) {
            echo "Error: Requested number of copies for BookID $bookID is more than the available copies.";
        } else {
            $newNumCopies = $availableCopies - $numCopies;
            $updateCopiesQuery = "UPDATE Copies SET No_Of_Copies = ? WHERE BookID = ?";
            $stmt = mysqli_prepare($conn, $updateCopiesQuery);
            mysqli_stmt_bind_param($stmt, 'ii', $newNumCopies, $bookID);

            if (!mysqli_stmt_execute($stmt)) {
                die("Error updating copies: " . mysqli_error($conn));
            } else {
                // Query the prices table to get the price of the book
                $selectPriceQuery = "SELECT price FROM prices WHERE BookID = ?";
                $stmt = mysqli_prepare($conn, $selectPriceQuery);
                mysqli_stmt_bind_param($stmt, 'i', $bookID);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if ($result) {
                    $row = mysqli_fetch_assoc($result);
                    $bookPrice = $row['price'];

                    // Calculate and update the total cost
                    $totalCost += ($bookPrice * $numCopies);
                }

                // Insert a record into the PurchaseDetails table
                $insertDetailsQuery = "INSERT INTO PurchaseDetails (PurchaseID, BookID, NumCopies) VALUES (?, ?, ?)";
                $stmt = mysqli_prepare($conn, $insertDetailsQuery);
                mysqli_stmt_bind_param($stmt, 'iii', $purchaseID, $bookID, $numCopies);

                if (!mysqli_stmt_execute($stmt)) {
                    die("Error inserting purchase details: " . mysqli_error($conn));
                }
            }
        }
    }

    // Display the total cost
    echo "Purchase completed successfully! Total cost: ₹" . $totalCost;
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Purchase page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Purchase page</h1>
    
    <form method="post" action="">
        <label for="customerName">Customer Name:</label>
        <input type="text" id="customerName" name="customerName"><br><br>
        
        <!-- Book selection for multiple books -->
        <div id="bookInputs">
            <div class="bookInput">
                <label for="bookID">BookID:</label>
                <input type="text" class="bookID" name="bookID[]">
                <label for="numCopies">Number of copies:</label>
                <input type="text" class="numCopies" name="numCopies[]">
            </div>
        </div>
        
        <button type="button" id="addBook">Add Another Book</button><br><br>
        
        <input type="submit" value="Submit">
    </form>

    <!-- Add this button wherever you want it on your page -->
    <button onclick="goBack()">Go Back</button>

    <script>
        // This function takes the user back to the previous page
        function goBack() {
            window.history.back();
        }

        // JavaScript to add more book input fields dynamically
        document.getElementById("addBook").addEventListener("click", function() {
            var bookInput = document.createElement("div");
            bookInput.className = "bookInput";
            bookInput.innerHTML = `
                <label for="bookID">BookID:</label>
                <input type="text" class="bookID" name="bookID[]">
                <label for="numCopies">Number of copies:</label>
                <input type="text" class="numCopies" name="numCopies[]">
            `;
            document.getElementById("bookInputs").appendChild(bookInput);
        });
    </script>
</body>
</html>
