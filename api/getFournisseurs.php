
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
$stmt = $conn->prepare("SELECT Id_Fournisseur FROM utilisateur WHERE id_Utilisateur = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($current_fournisseur);
$stmt->fetch();
$stmt->close();

$req = "SELECT Id_Fournisseur, Fnom, TarifElect FROM fournisseur";
$result = $conn->query($req);

$fournisseurs = [];
while ($row = $result->fetch_assoc()) {
    $fournisseurs[] = $row;
}

$conn->close();

echo json_encode(["success" => true, "fournisseurs" => $fournisseurs, "currentFournisseur" => $current_fournisseur]);
?>
