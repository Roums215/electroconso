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

$servername = "mysql-electroconso.alwaysdata.net";
$username = "electroconso";
$password = "Iulian2004!";
$dbname = "electroconso_bdd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

$data = json_decode(file_get_contents("php://input"));
$id_prise = $data->id_prise;
$watt = $data->watt;

$stmt = $conn->prepare("INSERT INTO consommation (Id_Prise, W, dateW) VALUES (?, ?, NOW())");
$stmt->bind_param("id", $id_prise, $watt);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Erreur lors de l'ajout de la consommation: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
