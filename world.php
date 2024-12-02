<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

// check if there's a GET parameter for country:
$country = isset($_GET['country']) ? $_GET['country'] : null;

if ($country) {
    // Use LIKE for partial matching
    /* used this method because method given in lab did not work for me. both achieve same results */
    $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
    $stmt->bindValue(':country', '%' . $country . '%');
} else {
    // fetch all countries if search string is empty:
    $stmt = $conn->query("SELECT * FROM countries");
}

$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// return data as JSON:
header('Content-Type: application/json');
echo json_encode($results);
