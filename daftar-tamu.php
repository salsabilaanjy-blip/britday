
<?php
require_once "koneksi.php";

$result = $conn->query(
    "SELECT name, attendance, wish, created_at
     FROM guests
     ORDER BY id DESC"
);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tamu - Aisyah</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<section class="guest-list-section">
    <div class="guest-list-container">

        <a href="index.php" class="back-button">← Kembali ke Undangan</a>

        <div class="guest-list-header">
            <p class="eyebrow">Birthday Celebration</p>
            <h1>Guest Book</h1>
            <p>Terima kasih atas doa dan ucapan kalian ♡</p>
        </div>

        <?php if ($result && $result->num_rows > 0): ?>

            <div class="guest-list">

                <?php while ($guest = $result->fetch_assoc()): ?>

                    <div class="guest-entry">

                        <div class="guest-entry-top">
                            <h3>
                                <?= htmlspecialchars($guest["name"], ENT_QUOTES, "UTF-8") ?>
                            </h3>

                            <span class="attendance-badge
                                <?= $guest["attendance"] === "Hadir" ? "attending" : "not-attending" ?>">
                                <?= htmlspecialchars($guest["attendance"], ENT_QUOTES, "UTF-8") ?>
                            </span>
                        </div>

                        <?php if (!empty($guest["wish"])): ?>
                            <p class="guest-wish">
                                “<?= htmlspecialchars($guest["wish"], ENT_QUOTES, "UTF-8") ?>”
                            </p>
                        <?php else: ?>
                            <p class="guest-wish empty-wish">
                                Tidak ada ucapan.
                            </p>
                        <?php endif; ?>

                        <span class="guest-time">
                            <?= date("d M Y, H:i", strtotime($guest["created_at"])) ?>
                        </span>

                    </div>

                <?php endwhile; ?>

            </div>

        <?php else: ?>

            <div class="empty-guest">
                <div class="empty-icon">♡</div>
                <h2>Belum ada tamu</h2>
                <p>Ucapan dan konfirmasi tamu akan muncul di sini.</p>
            </div>

        <?php endif; ?>

        <footer class="footer">
            <div class="footer-ornament">✧ ───────── ♡ ───────── ✧</div>
            <h2>With Love, Aisyah</h2>
        </footer>

    </div>
</section>

</body>
</html>
<?php
$conn->close();
?>
