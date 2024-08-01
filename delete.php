<?php
require_once "dbconnect.php";
session_start();
if (!isset($_SESSION['name']))
    die("ACCESS DENIED");
else{
    if (isset($_POST['cancel'])){
        header("Location: index.php");
        return;
    } 
    if (!is_numeric($_REQUEST['auto_id']))
    {
        $_SESSION['error'] = "Bad value for id";
        header("Location: index.php");
        return;   
    }
    $sql = "SELECT * FROM autos WHERE auto_id = " . htmlentities($_REQUEST['auto_id']);
    $stmt = $pdo->query($sql);
    
    if ($stmt->rowCount() == 0){
        $_SESSION['error'] = "Bad value for id";
        header("Location: index.php");
        return;
    }
    if (isset($_POST['update'])){
        $sql = "DELETE FROM autos WHERE auto_id = " . $_POST['auto_id'];
        $stmt = $pdo->query($sql);
        $_SESSION['success'] = "Record deleted";
        header("Location: index.php");
        return;
    }
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>

<html>
    <head>
        <title>kusay varde</title>
    </head>

    <body>
        <p>Confirm : Delete <?= htmlentities($row['make']) ?></p>
        <form method="post">
            <input type="hidden" name="auto_id" value="<?=htmlentities($_REQUEST['auto_id'])?>">
            <input type="submit" name="update" value="Delete">
            <input type="submit" name="cancel" value="Cancel">
        </form>
    </body>
</html>