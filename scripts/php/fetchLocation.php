<?php
include_once '../../config/db_config.php';

try {
    $dbh = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "<div class='alert alert-danger' role='alert'>Error connecting to the database: " . $e->getMessage() . "</div>";
    exit(); // Terminate script execution after displaying the error message
}

$id = isset($_GET['id']) ? $_GET['id'] : 1; // Default ID is set to 1 if no ID is provided

$stmt = $dbh->prepare("SELECT longitude, latitude FROM Villa WHERE id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);

if ($stmt->execute()) {
    $locations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the data as JSON
    header('Content-Type: application/json');
    echo json_encode($locations);
} else {
    echo "<div class='alert alert-danger' role='alert'>Error executing the query.</div>";
    exit(); // Terminate script execution after displaying the error message
}
?>
