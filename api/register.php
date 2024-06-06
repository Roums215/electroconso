<?php
header("Access-Control-Allow-Origin: https://electroconso.alwaysdata.net");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$servername = "mysql-electroconso.alwaysdata.net";
$username = "electroconso";
$password = "Iulian2004!";
$dbname = "electroconso_bdd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

$data = json_decode(file_get_contents("php://input"));
$nom = htmlspecialchars($data->nom);
$prenom = htmlspecialchars($data->prenom);
$email = htmlspecialchars($data->email);
$password = htmlspecialchars($data->password);



$stmt = $conn->prepare("SELECT * FROM utilisateur WHERE UMail = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "Cet email est déjà utilisé."]);
    $stmt->close();
    $conn->close();
    exit();
}


$hashed_password = password_hash($password, PASSWORD_BCRYPT);

$stmt = $conn->prepare("INSERT INTO utilisateur (UNom, UPrenom, UMail, mdp, Id_Fournisseur) VALUES (?, ?, ?, ?, 1)");
$stmt->bind_param("ssss", $nom, $prenom, $email, $hashed_password);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Compte créé avec succès"]);
} else {
    echo json_encode(["success" => false, "message" => "Erreur lors de la création du compte: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
