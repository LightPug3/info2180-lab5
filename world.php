<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

// Check if there's a GET parameter for country
$country = isset($_GET['country']) ? $_GET['country'] : null;

if ($country) {
    // Use LIKE for partial matching
    $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
    $stmt->bindValue(':country', '%' . $country . '%');
} else {
    // If no country is specified, fetch all countries
    $stmt = $conn->query("SELECT * FROM countries");
}

$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Start the HTML table
echo "<table border='1'>
        <tr>
            <th>Country Name</th>
            <th>Continent</th>
            <th>Independence Year</th>
            <th>Head of State</th>
        </tr>";

// Loop through the results and output each row in the table
foreach ($results as $row) {
    echo "<tr>
            <td>" . htmlspecialchars($row['name']) . "</td>
            <td>" . htmlspecialchars($row['continent']) . "</td>
            <td>" . htmlspecialchars($row['independence_year']) . "</td>
            <td>" . htmlspecialchars($row['head_of_state']) . "</td>
          </tr>";
}

// Close the table
echo "</table>";
?>
