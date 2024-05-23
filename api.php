<?php
$servername = "localhost";
$username = "root";
$password = "super3";
$dbname = "jobs";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['job_offer_id'])) {
        $job_offer_id = $_GET['job_offer_id'];

        $stmt = $conn->prepare("SELECT * FROM job_offers WHERE job_offer_id = ?");
        $stmt->execute([$job_offer_id]);
        $oferta = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($oferta) {
            echo json_encode($oferta);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "No se encontró la oferta con el ID especificado."));
        }
    } else {
        $stmt = $conn->query("SELECT * FROM job_offers");
        $ofertes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($ofertes) {
            echo json_encode($ofertes);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "No se encontraron ofertas."));
        }
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(array("message" => "Error en la conexión a la base de datos: " . $e->getMessage()));
}
