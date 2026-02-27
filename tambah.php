<?php
require 'connection.php'; 

$categories = $pdo->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title    = $_POST['title'];
    $dev      = $_POST['developer'];
    $cat_id   = $_POST['category_id'];
    $status   = $_POST['status'];

    $sql  = "INSERT INTO games (title, developer, category_id, status) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$title, $dev, $cat_id, $status])) {
        header("Location: index.php"); 
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Game - GameVault</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>➕ Tambah Game Ke Vault</h2>
            <form method="POST" action=""> 
                <label>Judul Game:</label>
                <input type="text" name="title" placeholder="Masukkan judul game..." required>
                
                <label>Developer:</label>
                <input type="text" name="developer" placeholder="Contoh: FromSoftware">
                
                <label>Genre:</label>
                <select name="category_id">
                    <?php foreach($categories as $c): ?>
                        <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
                    <?php endforeach; ?>
                </select>

                <label>Status:</label>
                <select name="status">
                    <option value="Wishlist">Wishlist</option>
                    <option value="Playing">Playing</option>
                    <option value="Finished">Finished</option>
                </select>

                <button type="submit" class="btn btn-add"> Simpan Game</button>
                <div style="text-align: center; margin-top: 15px;">
                    <a href="index.php" style="color: #cf6679; text-decoration: none;">❌ Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>