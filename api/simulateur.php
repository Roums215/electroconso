<?php
$servername = "mysql-electroconso.alwaysdata.net";
$username = "361953";
$password = "Iulian2004!";
$dbname = "electroconso_bdd";

// Fichier de log
$log_file = '/home/usermanagementbtssio/www/simulateur.log';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error, 3, $log_file);
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT Id_Prise FROM prise";
$result = $conn->query($query);

if (!$result) {
    error_log("Erreur de requête: " . $conn->error, 3, $log_file);
    die("Erreur de requête: " . $conn->error);
}

while ($row = $result->fetch_assoc()) {
    $id_prise = $row['Id_Prise'];
    $watt = rand(50, 1500); 

    $data = json_encode([
        'id_prise' => $id_prise,
        'watt' => $watt
    ]);

    $options = [
        'http' => [
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => $data,
        ],
    ];

    $context  = stream_context_create($options);
    $result = file_get_contents('https://electroconso.alwaysdata.net/api/addConsommation.php', false, $context);

    if ($result === FALSE) {
        error_log("Erreur lors de l'envoi des données pour la prise $id_prise", 3, $log_file);
    } else {
        error_log("Données envoyées pour la prise $id_prise : $result", 3, $log_file);
    }
}

$conn->close();
?>

