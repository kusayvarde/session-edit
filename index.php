<?php
session_start();
require_once "dbconnect.php";
if (! isset($_SESSION['name'])){
?>

<html>
    <head>
        <title>kusay varde</title>
    </head>

    <body>
        <h1>Welcome to Autos Database</h1>
        <p><a href="login.php">Please log in</a></p>
        <p>Attempt to go to <a href="edit.php">edit.php</a> without logging in - it should fail with an error message.</p>
        <p>Attempt to go to <a href="add.php">add.php</a> without logging in - it should fail with an error message.</p>
        

<?php
}
else{
    echo "<h1>Welcome to the Automobiles Database</h1>";

    if (isset($_SESSION['error']))
    {
        echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success']))
    {
        echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
        unset($_SESSION['success']);
    }

    $sql = "SELECT * FROM autos";
    $stmt = $pdo->query($sql);
    if ($stmt->rowCount() == 0)
        echo "No rows found";
    if ($stmt->rowCount() > 0)
        echo "<table border=1><tr><td> Make </td><td>Model</td><td>Year</td><td>Mileage</td><td>Action</td></tr>";    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        echo "<tr><td>".htmlentities($row['make']); 
        echo "</td><td>" .htmlentities($row['model']) ;
        echo "</td><td>" . htmlentities($row['year']) ;
        echo "</td><td>" . htmlentities($row['mileage']) ;
        echo "</td><td><a href='edit.php?auto_id=" . $row['auto_id'] . "'>Edit</a>/";
        echo "<a href='delete.php?auto_id=" . $row['auto_id'] . "'>Delete</a></td></tr>";
    }
    echo "</table>";
    
?>
        <br>
        <a href="add.php">Add New Entry</a>
        <br>
        <a href="logout.php">Log Out</a>
    </body>
</html>

<?php } ?>