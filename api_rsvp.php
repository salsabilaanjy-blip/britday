
<?php

header("Content-Type: application/json");

require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    http_response_code(405);

    echo json_encode([
        "success" => false,
        "message" => "Metode tidak diizinkan."
    ]);

    exit;
}

$name = trim($_POST["name"] ?? "");
$whatsapp = trim($_POST["whatsapp"] ?? "");
$attendance = trim($_POST["attendance"] ?? "");
$wish = trim($_POST["wish"] ?? "");

if ($name === "" || $whatsapp === "" || $attendance === "") {

    http_response_code(400);

    echo json_encode([
        "success" => false,
        "message" => "Nama, WhatsApp, dan kehadiran wajib diisi."
    ]);

    exit;
}

if (!in_array($attendance, ["Hadir", "Tidak Hadir"])) {

    http_response_code(400);

    echo json_encode([
        "success" => false,
        "message" => "Pilihan kehadiran tidak valid."
    ]);

    exit;
}

$sql = "INSERT INTO birthday_rsvp
        (name, whatsapp, attendance, wish)
        VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "Query database gagal."
    ]);

    exit;
}

$stmt->bind_param(
    "ssss",
    $name,
    $whatsapp,
    $attendance,
    $wish
);

if ($stmt->execute()) {

    echo json_encode([
        "success" => true,
        "message" => "RSVP berhasil disimpan."
    ]);

} else {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "Gagal menyimpan RSVP."
    ]);

}

$stmt->close();
$conn->close();

?>
