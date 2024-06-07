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
    error_log("Connection failed: " . $conn->connect_error);
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

$data = json_decode(file_get_contents("php://input"), true);
if (!$data) {
    error_log("Invalid JSON input");
    echo json_encode(["success" => false, "message" => "Invalid JSON"]);
    exit();
}

$email = htmlspecialchars($data['email']);
$password = htmlspecialchars($data['password']);

$stmt = $conn->prepare("SELECT Id_Admin, ANom, APrenom, mdp FROM admin WHERE AMail = ?");
if (!$stmt) {
    error_log("Prepare statement failed: " . $conn->error);
    echo json_encode(["success" => false, "message" => "Database error"]);
    exit();
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['mdp'])) {
        $_SESSION['admin_id'] = $row['Id_Admin'];
        $_SESSION['admin_nom'] = $row['ANom'];
        $_SESSION['admin_prenom'] = $row['APrenom'];
        $_SESSION['admin_email'] = $email;

        echo json_encode(["success" => true, "message" => "Connexion réussie"]);
    } else {
        echo json_encode(["success" => false, "message" => "Mot de passe invalide"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Email non trouvé"]);
}

$stmt->close();
$conn->close();
?>
