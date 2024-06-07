<?php
session_start();

header("Access-Control-Allow-Origin: https://electroconso.alwaysdata.net");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$servername = "mysql-electroconso.alwaysdata.net";
$username = "361953";
$password = "Iulian2004!";
$dbname = "electroconso_bdd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);

$firstname = htmlspecialchars($data['firstName']);
$lastname = htmlspecialchars($data['lastName']);
$email = htmlspecialchars($data['email']);
$password = password_hash($data['password'], PASSWORD_BCRYPT);

$stmt = $conn->prepare("INSERT INTO admin (ANom, APrenom, AMail, mdp) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $firstname, $lastname, $email, $password);

$response = [];

if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['success'] = false;
    $response['message'] = "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
