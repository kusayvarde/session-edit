<?php
require_once "dbconnect.php";
session_start();



if (! isset($_SESSION['name']))
    die("ACCESS DENIED");

else {
    if (isset($_POST['cancel'])){
        header("Location: index.php");
        return;
    }


    if ((isset($_POST['make']) && strlen($_POST['make']) < 1) || (isset($_POST['model']) && strlen($_POST['model']) < 1)){
        $_SESSION['error'] = "All fields are required";
        header("Location: edit.php?auto_id=" . $_REQUEST['auto_id']);
        return;
    }

    else if (isset($_POST['year']) && isset($_POST['mileage']) && (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage']))){
        $_SESSION['error'] = "Mileage and year must be numeric";
        header("Location: edit.php?auto_id=" . $_REQUEST['auto_id']);
        return;
    }

    if (isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage'])){
        $sql = "UPDATE autos SET make = :make, model = :model, year = :year, mileage = :mileage WHERE auto_id = " . $_REQUEST['auto_id'];
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':make' => $_POST['make'],
            ':model' => $_POST['model'],
            ':year' => $_POST['year'],
            ':mileage' => $_POST['mileage']
        ));
            


        $_SESSION['success'] = "Record edited";
        header("Location: index.php");
        return;
    }
    if (!is_numeric($_REQUEST['auto_id']))
    {
        $_SESSION['error'] = "Bad value for id";
        header("Location: index.php");
        return;   
    }
    $sql = "SELECT * FROM autos WHERE auto_id = " . $_REQUEST['auto_id'];
    $stmt = $pdo->query($sql);
    if ($stmt->rowCount() == 0 ){
        $_SESSION['error'] = "Bad value for id";
        header("Location: index.php");
        return;
    }
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $make = $row['make'];
    $model = $row['model'];
    $year = $row['year'];
    $mileage = $row['mileage'];
}

?>

<html>
    <head>
        <title>kusay varde</title>
    </head>

    <body>
        <h1>Editing Automobile</h1>
        <?php 
            if (isset($_SESSION['error'])){
                echo "<p style='color:red;'>" . htmlentities($_SESSION['error']) . "</p>" ;
                unset($_SESSION['error']);
            } 
        ?>
        <form method="post">
            <p>make <input type="text" name="make" value="<?= htmlentities($make)?>"></p> 
            <p>model <input type="text" name="model" value="<?= htmlentities($model)?>"></p> 
            <p>year <input type="text" name="year" value="<?= htmlentities($year)?>"></p> 
            <p>mileage <input type="text" name="mileage" value="<?= htmlentities($mileage)?>"></p> 

            <input type="submit" name="save" value="Save">
            <input type="submit" name="cancel" value="Cancel">
        </form>
    </body>
</html>