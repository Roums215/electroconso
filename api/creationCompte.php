<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "electroconso";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);

$firstname = htmlspecialchars($data['firstName']);
$lastname = htmlspecialchars($data['lastName']);
$email = htmlspecialchars($data['email']);
$number = htmlspecialchars($data['number']);
$fournisseur = htmlspecialchars($data['fournisseur']);
$password = password_hash($data['password'], PASSWORD_BCRYPT);

$stmt = $conn->prepare("INSERT INTO utilisateur (UNom, UPrenom, UMail, UTel, mdp, Id_Fournisseur) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssi", $firstname, $lastname, $email, $number, $password, $fournisseur);

$response = [];

if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['success'] = false;
    $response['message'] = "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
