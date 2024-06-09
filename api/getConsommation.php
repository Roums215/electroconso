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
$current_month = date('Y-m-01'); // Premier jour du mois en cours

$query = "
SELECT SUM(c.W) as totalWatts, SUM(f.TarifElect * c.W / 1000) as totalCost
FROM consommation c
JOIN prise p ON c.Id_Prise = p.Id_Prise
JOIN utilisateur u ON p.Id_Utilisateur = u.Id_Utilisateur
JOIN fournisseur f ON u.Id_Fournisseur = f.Id_Fournisseur
WHERE u.Id_Utilisateur = ? AND c.dateW >= ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("is", $user_id, $current_month);
$stmt->execute();
$result = $stmt->get_result();

$response = ["success" => false];
if ($row = $result->fetch_assoc()) {
    $response["success"] = true;
    $response["totalWatts"] = $row["totalWatts"];
    $response["totalCost"] = $row["totalCost"];
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>
