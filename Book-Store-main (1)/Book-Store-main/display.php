<?php

// establish a connection to the database
require_once 'db_connect.php';

// query the database for all books information
$query = "SELECT b.*, a.AuthorName, c.Genre, c.No_Of_Copies, p.price
          FROM Books b
          INNER JOIN Authors a ON b.BookID = a.BookID
          INNER JOIN Copies c ON b.BookID = c.BookID
          INNER JOIN prices p ON b.BookID = p.BookID";
$result = mysqli_query($conn, $query);


?>
<style>
    table {
        border-collapse: collapse;
        width: 100%;
        margin-bottom: 1em;
    }
    
    th, td {
        padding: 0.5em;
        text-align: left;
        border: 1px solid #ccc;
    }
    
    th {
        background-color: #f2f2f2;
    }
    
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    
    tr:hover {
        background-color: #ddd;
    }
</style>

<!-- HTML table to display the books information -->
<table>
    <thead>
        <tr>
            <th>BookID</th>
            <th>Title</th>
            <th>PublisherName</th>
            <th>AuthorName</th>
            <th>Genre</th>
            <th>No_Of_Copies</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['BookID']; ?></td>
            <td><?php echo $row['Title']; ?></td>
            <td><?php echo $row['PublisherName']; ?></td>
            <td><?php echo $row['AuthorName']; ?></td>
            <td><?php echo $row['Genre']; ?></td>
            <td><?php echo $row['No_Of_Copies']; ?></td>
            <td><?php echo $row['price']; ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<!-- Add this button wherever you want it on your page -->
<button onclick="goBack()">Go Back</button>

<script>
// This function takes the user back to the previous page
function goBack() {
  window.history.back();
}
</script>

<?php mysqli_close($conn); ?>
