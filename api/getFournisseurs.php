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
$username = "361953";
$password = "Iulian2004!";
$dbname = "electroconso_bdd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

$user_id = $_SESSION['id'];

$fournisseurs = [];
$fournisseurQuery = "SELECT Id_Fournisseur, Fnom, TarifElect FROM fournisseur";
$result = $conn->query($fournisseurQuery);

while ($row = $result->fetch_assoc()) {
    $fournisseurs[] = $row;
}


$currentFournisseur = null;
$currentFournisseurQuery = "
    SELECT f.Id_Fournisseur, f.Fnom, f.TarifElect
    FROM utilisateur u
    JOIN fournisseur f ON u.Id_Fournisseur = f.Id_Fournisseur
    WHERE u.Id_Utilisateur = ?";
$stmt = $conn->prepare($currentFournisseurQuery);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $currentFournisseur = $result->fetch_assoc();
}

$stmt->close();
$conn->close();

echo json_encode(["success" => true, "fournisseurs" => $fournisseurs, "currentFournisseur" => $currentFournisseur]);
?>
