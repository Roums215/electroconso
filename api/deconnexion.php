<?php
session_start();

header("Access-Control-Allow-Origin: https://electroconso.alwaysdata.net");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if (isset($_SESSION['id']) || isset($_SESSION['admin_id'])) {
    session_unset();
    session_destroy();
    echo json_encode(["success" => true, "message" => "Déconnexion réussie"]);
} else {
    echo json_encode(["success" => false, "message" => "Aucune session active"]);
}
?>
