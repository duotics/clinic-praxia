<?php

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ordonezmd";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the search term and page number from the request
$q = isset($_GET['q']) ? $_GET['q'] : '';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Define the number of items per page
$perPage = 20;

// Perform the search query using the search term and page number
$sql = "SELECT * FROM db_diagnosticos WHERE nombre LIKE '%$q%' OR codigo LIKE '%$q%' ORDER BY id_diag ASC LIMIT " . (($page - 1) * $perPage) . ", $perPage";
$result = $conn->query($sql);

$items = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $items[] = array(
            'id' => $row['id_diag'],
            'text' => "{$row['codigo']} {$row['nombre']}"
        );
    }
}

// Calculate the total number of pages
$sql = "SELECT COUNT(*) AS total FROM db_diagnosticos WHERE nombre LIKE '%$q%' OR codigo LIKE '%$q%'";
$result = $conn->query($sql);
$numPages = ceil($result->fetch_assoc()['total'] / $perPage);

// Return the results as a JSON response
echo json_encode(array(
    'results' => $items,
    'pagination' => array(
        'more' => $page < $numPages
    )
));

$conn->close();
