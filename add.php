<?php
require_once "dbconnect.php";

session_start();
if (! isset($_SESSION['name']))
    die("ACCESS DENIED");

if (isset($_POST['cancel'])){
    header("Location: index.php");
    return;
}


if ((isset($_POST['make']) && strlen($_POST['make']) < 1) || (isset($_POST['model']) && strlen($_POST['model']) < 1)){
    $_SESSION['error'] = "All fields are required";
    header("Location: add.php");
    return;
}

else if (isset($_POST['year']) && isset($_POST['mileage']) && (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage']))){
    $_SESSION['error'] = "Mileage and year must be numeric";
    header("Location: add.php");
    return;
}
    

else if (isset($_POST['add'])){
    $stmt = $pdo->prepare('INSERT INTO autos (make, model, year, mileage) VALUES ( :mk, :md, :yr, :mi)');
    $stmt->execute(array(
        ':mk' => $_POST['make'],
        ':md' => $_POST['model'],
        ':yr' => $_POST['year'],
        ':mi' => $_POST['mileage'])
    );

    $_SESSION['success'] = "Record added";
    header("Location: index.php");
    return;
}

?>

<html>
    <head>
        <title>kusay varde</title>
    </head>

    <body>
        <h1>Tracking Autos for <?= htmlentities($_SESSION['name'])?></h1>
        <?php 
        if (isset($_SESSION['error'])){
            echo "<p style='color:red;'>" . htmlentities($_SESSION['error']) . "</p>" ;
            unset($_SESSION['error']);
        } 

        ?>
        <form method="post">
            <p>Make <input type="text" name="make"></p>
            <p>model <input type="text" name="model"></p>
            <p>Year <input type="text" name="year"></p>
            <p>Mileage <input type="text" name="mileage"></p>
            <input type="submit" name="add" value="Add">
            <input type="submit" name="cancel" value="Cancel">
        </form>
    </body>
</html>