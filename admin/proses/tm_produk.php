<?php 
include 'header.php';  // Menyertakan file header.php
include 'koneksi/koneksi.php'; // Pastikan ini termasuk koneksi.php untuk koneksi MySQL

?>

<div class="container">
    <h2 style="width: 100%; border-bottom: 4px solid gray"><b>Master Produk</b></h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Kode Produk</th>
                <th scope="col">Nama Produk</th>
                <th scope="col">Image</th>
                <th scope="col">Harga</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // Menggunakan $koneksi untuk query
            // Menggunakan $koneksi yang sudah didefinisikan di koneksi.php
            $result = $koneksi->query("SELECT * FROM produk");

            // Mengecek apakah query berhasil
            if ($result === false) {
                die("Query gagal: " . $koneksi->error);
            }

            $no = 1;
            while ($row = $result->fetch_assoc()) {
            ?>
                <tr>
                    <td><?= $no; ?></td>
                    <td><?= $row['kode_produk']; ?></td>
                    <td><?= $row['nama']; ?></td>
                    <td><img src="../image/produk/<?= $row['image']; ?>" width="100"></td>
                    <td>Rp. <?= number_format($row['harga']); ?></td>
                    <td>
                        <a href="edit_produk.php?kode=<?= $row['kode_produk']; ?>" class="btn btn-warning">
                            <i class="glyphicon glyphicon-edit"></i> Edit
                        </a> 
                        <a href="proses/del_produk.php?kode=<?= $row['kode_produk']; ?>" class="btn btn-danger" onclick="return confirm('Yakin Ingin Menghapus Data ?')">
                            <i class="glyphicon glyphicon-trash"></i> Hapus
                        </a> 
                        <a href="bom.php?kode=<?= $row['kode_produk']; ?>" class="btn btn-primary">
                            <i class="glyphicon glyphicon-eye-open"></i> Lihat BOM
                        </a>
                    </td>
                </tr>
            <?php
                $no++; 
            }
            ?>
        </tbody>
    </table>

    <a href="tm_produk.php" class="btn btn-success"><i class="glyphicon glyphicon-plus-sign"></i> Tambah Produk</a>
</div>

<br><br><br><br><br><br><br><br><br><br><br><br>

<?php 
include 'footer.php'; // Menyertakan footer.php
?>
