<?php
require 'connection.php'; 

$stmt = $pdo->query("SELECT games.*, categories.name AS genre 
                     FROM games 
                     LEFT JOIN categories ON games.category_id = categories.id 
                     ORDER BY games.id DESC");

$games = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>GameVault - My Collection</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <h2>🎮 Daftar Koleksi Game</h2>
        <a href="tambah.php" class="btn btn-add">+ Tambah Game Baru</a>

        <table>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Developer</th>
                <th>Genre</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
            <?php $no = 1; foreach($games as $row): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><strong><?= htmlspecialchars($row['title']); ?></strong></td>
                <td><?= htmlspecialchars($row['developer']); ?></td>
                <td><?= htmlspecialchars($row['genre'] ?? 'Uncategorized'); ?></td>
                <td>
                    <span class="status status-<?= strtolower($row['status']); ?>">
                        <?= htmlspecialchars($row['status']); ?>
                    </span>
                </td>
                <td>
                    <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-edit">Edit</a>
                    <a href="#" class="btn btn-delete btn-hapus" data-id="<?= $row['id']; ?>">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <script>
        const tombolHapus = document.querySelectorAll('.btn-hapus');

        tombolHapus.forEach(tombol => {
            tombol.addEventListener('click', function(e) {
                e.preventDefault(); 
                const id = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Yakin mau hapus?',
                    text: "Data game ini bakal ilang selamanya dari vault lo!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#cf6679', 
                    cancelButtonColor: '#302b63', 
                    confirmButtonText: 'Ya, Hapus Saja!',
                    cancelButtonText: 'Batal',
                    background: '#1e1e1e', 
                    color: '#e0e0e0',      
                    backdrop: `rgba(0,0,0,0.6)` 
                }).then((result) => {
                    if (result.isConfirmed) {
                        
                        window.location.href = 'hapus.php?id=' + id;
                    }
                });
            });
        });
    </script>
</body>
</html>