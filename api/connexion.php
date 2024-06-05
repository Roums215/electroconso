
<?php
session_start();

header("Access-Control-Allow-Origin: https://electroconso.alwaysdata.net");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "electroconso";
$servername = "mysql-electroconso.alwaysdata.net";
$username = "361953";
$password = "Iulian2004!";
$dbname = "electroconso_bdd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

$data = json_decode(file_get_contents("php://input"));
$email = $data->email;
$password = $data->password;

$stmt = $conn->prepare("SELECT id_Utilisateur, UNom, UPrenom, mdp FROM utilisateur WHERE UMail = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $nom, $prenom, $hashed_password);
    $stmt->fetch();
    
    if (password_verify($password, $hashed_password)) {
        $_SESSION['id'] = $id;
        $_SESSION['nom'] = $nom;
        $_SESSION['prenom'] = $prenom;
        $_SESSION['email'] = $email;
        
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
