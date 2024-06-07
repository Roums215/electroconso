
<?php
header("Access-Control-Allow-Origin: https://electroconso.alwaysdata.net");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

session_start();

$servername = "mysql-electroconso.alwaysdata.net";
$username = "361953";
$password = "Iulian2004!";
$dbname = "electroconso_bdd";

// Fichier de log
$log_file = '/home/electroconso/www/addConsommation.log';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error, 3, $log_file);
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

$data = json_decode(file_get_contents("php://input"), true);
$id_prise = $data['id_prise'];
$watt = $data['watt'];

$stmt = $conn->prepare("INSERT INTO consommation (Id_Prise, W, dateW) VALUES (?, ?, NOW())");
$stmt->bind_param("id", $id_prise, $watt);

if ($stmt->execute()) {
    error_log("Données enregistrées pour la prise $id_prise : $watt Watts", 3, $log_file);
    echo json_encode(["success" => true]);
} else {
    error_log("Erreur lors de l'ajout de la consommation pour la prise $id_prise : " . $stmt->error, 3, $log_file);
    echo json_encode(["success" => false, "message" => "Erreur lors de l'ajout de la consommation: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
