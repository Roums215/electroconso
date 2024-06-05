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
$nom_prise = htmlspecialchars($data->nom_prise);
$code_connexion = htmlspecialchars($data->code_connexion);
$user_id = $_SESSION['id'];

$stmt = $conn->prepare("INSERT INTO prise (NomP, CodeConnexion, Id_Utilisateur) VALUES (?, ?, ?)");
$stmt->bind_param("ssi", $nom_prise, $code_connexion, $user_id);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Erreur : " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
