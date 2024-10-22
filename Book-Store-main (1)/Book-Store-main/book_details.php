<html>
<head>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Book Details</h1>
    <form action="" method="post">
        Enter Book ID:<br>
        <input type="text" name="Book_ID"><br><br>
        <input type="submit" name="submit" value="submit">
    </form>

    <?php
        require_once 'db_connect.php';
        if (isset($_POST['submit'])) {
            $book_id=$_POST['Book_ID'];
            $sql = "SELECT b.*, a.AuthorName, c.Genre, c.No_Of_Copies
                    FROM Books b
                    INNER JOIN Authors a ON b.BookID = a.BookID
                    INNER JOIN Copies c ON b.BookID = c.BookID
                    WHERE b.BookID = $book_id";
            $result = mysqli_query($conn,$sql);
            if (mysqli_num_rows($result) > 0) {
                // Output data of each row
                echo '<div class="form-box">';
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<div>";
                    echo "Book ID: " . $row["BookID"]. "<br>";
                    echo "Title: " . $row["Title"]. "<br>";
                    echo "Publisher Name: " . $row["PublisherName"]. " publication"."<br>";
                    echo "Author Name: " . $row["AuthorName"]. "<br>";
                    echo "Genre: " . $row["Genre"]. "<br>";
                    echo "No Of Copies available: " . $row["No_Of_Copies"]. "<br>";
                    echo "</div>";
                }
                echo '</div>';
            } else {
                echo "0 results";
            }
            mysqli_close($conn);
        }
    ?>
</body>
</html>
