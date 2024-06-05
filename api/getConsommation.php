<?php
session_start();

header("Access-Control-Allow-Origin: https://electroconso.alwaysdata.net");
header("Access-Control-Allow-Credentials: true");
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

$query = "
SELECT c.Id_Consommation, c.W, c.dateW, p.Id_Prise, p.NomP, f.TarifElect * c.W / 1000 AS Cout, f.TarifElect
FROM consommation c
JOIN prise p ON c.Id_Prise = p.Id_Prise
JOIN utilisateur u ON p.Id_Utilisateur = u.Id_Utilisateur
JOIN fournisseur f ON u.Id_Fournisseur = f.Id_Fournisseur
WHERE u.Id_Utilisateur = ?
ORDER BY c.dateW DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$consommations = [];
while ($row = $result->fetch_assoc()) {
    $consommations[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode(["success" => true, "consommations" => $consommations]);
?>
