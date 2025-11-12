<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Database credentials (replace with your own)
$host = "sql12.freesqldatabase.com";
$user = "sql12807348";
$pass = "x6DpEqVTsQ";
$db   = "sql12807348";
$port = 3306;

// Connect to MySQL
$conn = new mysqli($host, $user, $pass, $db, $port);
if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}

// Get trader_id from query string
if (!isset($_GET['trader_id']) || empty($_GET['trader_id'])) {
    echo json_encode(["error" => "Missing trader_id"]);
    exit;
}

$trader_id = $conn->real_escape_string($_GET['trader_id']);

// Query your traders table
$query = "SELECT registered_via_you, deposited, last_deposit FROM traders WHERE trader_id='$trader_id'";
$result = $conn->query($query);

// Build response
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode([
        "found" => true,
        "registered_via_you" => (bool)$row['registered_via_you'],
        "deposited" => (bool)$row['deposited'],
        "last_deposit" => (float)$row['last_deposit']
    ]);
} else {
    echo json_encode(["found" => false]);
}

$conn->close();
?>
