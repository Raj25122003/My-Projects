<?php
// Connect to database
require_once 'db_connect.php';

// Get form data
$bookID = $_POST["bookID"];
$title = $_POST["title"];
$publisherName = $_POST["publisherName"];
$authorName = $_POST["authorName"];
$genre = $_POST["genre"];
$noOfCopies = $_POST["noOfCopies"];
$price = $_POST["price"];

// Check if book exists
$sql = "SELECT * FROM Books WHERE BookID = '$bookID'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Book already exists, show message and exit
    echo "Book already exists!";
    exit();
} else {
    // Add new book
    $sql = "INSERT INTO Books (BookID, Title, PublisherName) VALUES ('$bookID', '$title', '$publisherName')";
    $conn->query($sql);

    $sql = "INSERT INTO Authors (BookID, AuthorName) VALUES ('$bookID', '$authorName')";
    $conn->query($sql);

    $sql = "INSERT INTO Copies(BookID, Genre, No_Of_Copies) VALUES ('$bookID', '$genre', '$noOfCopies')";
    $conn->query($sql);

    $sql = "INSERT INTO Prices(BookID, price) VALUES ('$bookID', '$price')";
    $conn->query($sql);
    echo "New book has been added successfully!";
}

    ?>
