<?php
session_start();

header("Access-Control-Allow-Origin: https://electroconso.alwaysdata.net");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if (!isset($_SESSION['id'])) {
    echo json_encode(["success" => false, "message" => "Non autorisé"]);
    exit();
}

// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "electroconso";
$servername = "mysql-electroconso.alwaysdata.net";
$username = "361953";
$password = "Iulian2004!";
$dbname = "electroconso_bdd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

$user_id = $_SESSION['id'];
$stmt = $conn->prepare("SELECT Id_Prise, NomP, CodeConnexion FROM prise WHERE Id_Utilisateur = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$prises = [];
while ($row = $result->fetch_assoc()) {
    $prises[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode(["success" => true, "prises" => $prises]);
?>
