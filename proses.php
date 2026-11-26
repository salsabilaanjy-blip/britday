<?php
header("Content-Type: application/json; charset=UTF-8");

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli("localhost", "root", "", "asassalsa");
    $conn->set_charset("utf8mb4");

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        echo json_encode([
            "success" => false,
            "message" => "Request harus POST."
        ]);
        exit;
    }

    $name = trim($_POST["name"] ?? "");
    $whatsapp = trim($_POST["whatsapp"] ?? "");
    $attendance = trim($_POST["attendance"] ?? "");
    $wish = trim($_POST["wish"] ?? "");

    if ($name === "" || $whatsapp === "" || $attendance === "") {
        echo json_encode([
            "success" => false,
            "message" => "Nama, WhatsApp, dan kehadiran wajib diisi."
        ]);
        exit;
    }

    $stmt = $conn->prepare(
        "INSERT INTO guests (name, whatsapp, attendance, wish)
         VALUES (?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "ssss",
        $name,
        $whatsapp,
        $attendance,
        $wish
    );

    $stmt->execute();

    echo json_encode([
        "success" => true,
        "message" => "Pesan berhasil dikirim! ♡"
    ]);

    $stmt->close();
    $conn->close();

} catch (Throwable $e) {
    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "Kesalahan server: " . $e->getMessage()
    ]);
}
?>