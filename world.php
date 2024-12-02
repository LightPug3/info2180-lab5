<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

// get country from query string and check if cities param is present:
$country = isset($_GET['country']) ? $_GET['country'] : '';
$queryparam = isset($_GET['lookup']) ? $_GET['lookup'] : '';

// prepare the appropriate SQL query:
if ($queryparam === 'cities') {
  $stmt = $conn->prepare("SELECT cities.name AS city_name, cities.district, cities.population FROM cities INNER JOIN countries ON cities.country_code = countries.code WHERE countries.name LIKE :country");
  $stmt->bindValue(':country', '%' . $country . '%');
} else {
  $stmt = $conn->prepare("SELECT name, continent, independence_year, head_of_state FROM countries WHERE name LIKE :country");
  $stmt->bindValue(':country', '%' . $country . '%');
}

$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// return the appropriate results in an HTML table:
if ($queryparam === 'cities') {
    echo "<table>
            <tr>
                <th>City Name</th>
                <th>District</th>
                <th>Population</th>
            </tr>";
    foreach ($results as $row) {
        echo "<tr>
                <td>" . htmlspecialchars($row['city_name']) . "</td>
                <td>" . htmlspecialchars($row['district']) . "</td>
                <td>" . htmlspecialchars($row['population']) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<table>
            <tr>
                <th>Country Name</th>
                <th>Continent</th>
                <th>Independence Year</th>
                <th>Head of State</th>
            </tr>";
    foreach ($results as $row) {
        echo "<tr>
                <td>" . htmlspecialchars($row['name']) . "</td>
                <td>" . htmlspecialchars($row['continent']) . "</td>
                <td>" . htmlspecialchars($row['independence_year']) . "</td>
                <td>" . htmlspecialchars($row['head_of_state']) . "</td>
              </tr>";
    }
    echo "</table>";
}
?>