<?php
require 'connection.php'; 

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM games WHERE id = ?");
$stmt->execute([$id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title  = $_POST['title'];
    $dev    = $_POST['developer'];
    $cat_id = $_POST['category_id'];
    $status = $_POST['status'];

    $sql = "UPDATE games SET title=?, developer=?, category_id=?, status=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$title, $dev, $cat_id, $status, $id])) {
        header("Location: index.php"); 
        exit;
    }
}

$categories = $pdo->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Game - GameVault</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2> Edit Data Game</h2>
            <form method="POST">
                <label>Judul Game:</label>
                <input type="text" name="title" value="<?= htmlspecialchars($data['title']); ?>" required>
                
                <label>Developer:</label>
                <input type="text" name="developer" value="<?= htmlspecialchars($data['developer']); ?>">
                
                <label>Genre:</label>
                <select name="category_id">
                    <?php foreach($categories as $c): ?>
                        <option value="<?= $c['id'] ?>" <?= $c['id'] == $data['category_id'] ? 'selected' : '' ?>>
                            <?= $c['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label>Status:</label>
                <select name="status">
                    <option value="Wishlist" <?= $data['status'] == 'Wishlist' ? 'selected' : '' ?>>Wishlist</option>
                    <option value="Playing" <?= $data['status'] == 'Playing' ? 'selected' : '' ?>>Playing</option>
                    <option value="Finished" <?= $data['status'] == 'Finished' ? 'selected' : '' ?>>Finished</option>
                </select>

                <button type="submit" class="btn btn-edit">✅ Update Data</button>
                <div style="text-align: center; margin-top: 15px;">
                    <a href="index.php" style="color: #cf6679; text-decoration: none;">❌ Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>