<?php 
include 'header.php';
// Generate kode material
$kode_produk = $_GET['kode'];
$conn = new mysqli("localhost", "root", "", "your_database_name");

// Check for a successful database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch product details
$query = "SELECT * FROM produk WHERE kode_produk = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $kode_produk);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

?>

<div class="container">
    <h2 style=" width: 100%; border-bottom: 4px solid gray"><b>Edit Produk</b></h2>

    <form action="proses/edit_produk.php" method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <label for="exampleInputFile">
                <img src="../image/produk/<?= $data['image']; ?>" width="100">
            </label>
            <input type="file" id="exampleInputFile" name="files">
            <p class="help-block">Pilih Gambar untuk Produk</p>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="kodeProduk">Kode Produk</label>
                    <input type="text" class="form-control" id="kodeProduk" placeholder="Masukkan Kode Produk" disabled value="<?= $data['kode_produk']; ?>">
                    <input type="hidden" name="kode" class="form-control" id="kodeProduk" value="<?= $data['kode_produk']; ?>">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="namaProduk">Nama Produk</label>
                    <input type="text" class="form-control" id="namaProduk" placeholder="Masukkan Nama Produk" name="nama" value="<?= $data['nama']; ?>">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="hargaProduk">Harga</label>
                    <input type="number" class="form-control" id="hargaProduk" placeholder="Masukkan Harga" name="harga" value="<?= $data['harga']; ?>">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="deskripsiProduk">Deskripsi</label>
            <textarea name="desk" class="form-control" id="deskripsiProduk"><?= $data['deskripsi']; ?></textarea>
        </div>
        <hr>
        <h3 style=" width: 100%; border-bottom: 4px solid gray">BOM Produk</h3>

        <div class="row">
            <div class="col-md-6">
                <h4>Daftar Material</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Kode Material</th>
                            <th scope="col">Nama Material</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $result2 = $conn->query("SELECT * FROM inventory ORDER BY kode_bk ASC");
                        $no2 = 1;
                        while ($row2 = $result2->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $no2 . "</td>";
                            echo "<td>" . $row2['kode_bk'] . "</td>";
                            echo "<td>" . $row2['nama'] . "</td>";
                            echo "</tr>";
                            $no2++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="col-md-6">
                <h4>Pilih material yang hanya dibutuhkan untuk produk</h4>
                <div class="bg-danger" style="padding: 5px;">
                    <p style="color: red; font-weight: bold;">NB. Form dibawah tidak harus diisi semua</p>
                    <p style="color: red; font-weight: bold;">Kode Material tidak boleh sama</p>
                </div>
                <br>
                <?php 
                $result3 = $conn->prepare("SELECT * FROM bom_produk WHERE kode_produk = ?");
                $result3->bind_param("s", $kode_produk);
                $result3->execute();
                $result3 = $result3->get_result();
                $no3 = 1;
                while ($row3 = $result3->fetch_assoc()) {
                    ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="materialKode<?= $no3 ?>">Kode Material</label>
                                <input type="text" name="material[]" class="form-control" placeholder="Masukkan Kode Material" value="<?= $row3['kode_bk']; ?>" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="materialKebutuhan<?= $no3 ?>">Kebutuhan Material</label>
                                <input type="text" class="form-control" placeholder="Contoh : 250 atau 0.2" name="keb[]" value="<?= $row3['kebutuhan']; ?>" required>
                            </div>
                        </div>
                    </div>
                    <?php 
                    $no3++;
                }   
                ?>

            </div>

        </div>
        <div class="row">
            <div class="col-md-6">
                <button type="submit" class="btn btn-warning btn-block"><i class="glyphicon glyphicon-edit"></i> Edit</button>
            </div>    
            <div class="col-md-6">
                <a href="m_produk.php" class="btn btn-danger btn-block">Cancel</a>
            </div>
        </div>

        <br>

    </div>
</form>

</div>

<br><br><br><br><br><br><br><br><br><br><br><br>

<?php 
include 'footer.php';
?>
