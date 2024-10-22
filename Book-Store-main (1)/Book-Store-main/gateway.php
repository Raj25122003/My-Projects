<?php
require_once 'db_connect.php';

// Initialize total amount for the purchase
$totalAmount = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['bookID']) && isset($_POST['numCopies']) && isset($_POST['customerName'])) {
    $customerName = $_POST['customerName'];
    $purchaseDate = date('Y-m-d');

    // Payment processing logic goes here (e.g., integrating with a payment gateway)
    // Assume a variable $paymentSuccess indicates whether the payment was successful
    
    $paymentSuccess = true; // Replace with actual payment logic

    if ($paymentSuccess) {
        // Payment was successful, proceed with purchase and database operations

        // Insert a new purchase record into the Purchases table
        $insertPurchaseQuery = "INSERT INTO Purchases (CustomerName, PurchaseDate) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $insertPurchaseQuery);
        mysqli_stmt_bind_param($stmt, 'ss', $customerName, $purchaseDate);

        if (!mysqli_stmt_execute($stmt)) {
            die("Error inserting purchase record: " . mysqli_error($conn));
        }

        // Get the last inserted PurchaseID
        $purchaseID = mysqli_insert_id($conn);

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
                    // Insert a record into the PurchaseDetails table
                    $insertDetailsQuery = "INSERT INTO PurchaseDetails (PurchaseID, BookID, NumCopies) VALUES (?, ?, ?)";
                    $stmt = mysqli_prepare($conn, $insertDetailsQuery);
                    mysqli_stmt_bind_param($stmt, 'iii', $purchaseID, $bookID, $numCopies);

                    if (!mysqli_stmt_execute($stmt)) {
                        die("Error inserting purchase details: " . mysqli_error($conn));
                    }

                    // Calculate the total amount for the purchase
                    $selectPriceQuery = "SELECT price FROM Prices WHERE BookID = ?";
                    $stmt = mysqli_prepare($conn, $selectPriceQuery);
                    mysqli_stmt_bind_param($stmt, 'i', $bookID);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    if ($result) {
                        $row = mysqli_fetch_assoc($result);
                        if ($row) {
                            $price = $row['price'];
                            $totalAmount += ($price * $numCopies); // Add to the total amount
                        }
                    }
                }
            }
        }

        // Display a success message after successful payment and database operations
        echo "Purchase completed successfully!";
    } else {
        // Payment failed, display an error message
        echo "Payment failed. Please try again.";
    }
}

mysqli_close($conn);
?>
