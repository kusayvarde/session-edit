<?php
try {
$pdo = new PDO ('mysql:host=localhost; dbname=misc', 'kusay', 'azaz');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $err) {
    die ("database connection problem: " . $err);
}
?>