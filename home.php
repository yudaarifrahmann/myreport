<?php
include('../prosses/koneksi.php');
session_start();

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Ambil semua laporan publik (anonim = 0) beserta foto pengguna
$result = $conn->query("SELECT reports.*, users.foto AS user_foto FROM reports JOIN users ON reports.user_name = users.name WHERE reports.anonim = 0");

// Cek apakah query berhasil dijalankan
if ($result === false) {
    echo "Error: " . $conn->error;
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Report - Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/home.css">
</head>
<body>
    <div class="navbar">
        <img src="../img/MyReport-logo-RVB-couleurs-grand.png" alt="My Report Logo" class="navbar-logo">
    </div>

    <div class="post-container">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="post">
                <div class="post-header">
                    <img src="<?php echo htmlspecialchars($row['user_foto'] ? $row['user_foto'] : '../img/default.png'); ?>" alt="Profile" class="profile-pic"> <!-- Menggunakan foto profil pengguna -->
                    <div class="post-info">
                        <h3><?php echo htmlspecialchars($row['user_name']); ?></h3>
                        <span><?php echo $row['anonim'] ? 'Anonim' : 'Public'; ?></span>
                    </div>
                </div>
                <h2><?php echo htmlspecialchars($row['judul']); ?></h2>
                <p><?php echo htmlspecialchars($row['description']); ?></p>
                <?php if ($row['foto']): ?>
                    <img src="<?php echo htmlspecialchars($row['foto']); ?>" alt="Incident image" class="post-image"> <!-- Ini foto laporan -->
                <?php endif; ?>
                <div class="post-status"><?php echo htmlspecialchars($row['status']); ?></div>
                <div class="post-actions">
                    <button class="like-btn">👍</button>
                    <button class="comment-btn">💬</button>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    <a href="formulir.php" class="add-btn">+</a>
    
    <div class="bottom-nav">
        <a href="home.php" class="nav-item">
            <i class="fas fa-home"></i>
        </a>
        <a href="myreport.php" class="nav-item">
            <i class="fas fa-file-alt"></i>
        </a>
        <a href="profile.php" class="nav-item">
            <i class="fas fa-user"></i>
        </a>
    </div>
</body>
</html>
