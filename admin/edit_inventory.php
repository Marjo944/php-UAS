<?php 
include 'header.php';
$kode = $_GET['kode'];

// Establish connection to the database
$conn = new mysqli("localhost", "root", "", "db_bangunan");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data for the given kode_bk
$query = "SELECT * FROM inventory WHERE kode_bk = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $kode);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
?>

<div class="container">
    <h2 style=" width: 100%; border-bottom: 4px solid gray"><b>Edit Inventory</b></h2>

    <form action="proses/edit_inv.php" method="POST">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="kodeMaterial">Kode Material</label>
                    <input type="text" class="form-control" id="kodeMaterial" disabled value="<?= htmlspecialchars($row['kode_bk']); ?>">
                    <input type="hidden" class="form-control" name="kd_material" value="<?= htmlspecialchars($row['kode_bk']); ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="namaMaterial">Nama Material</label>
                    <input type="text" class="form-control" id="namaMaterial" placeholder="Masukkan Nama Material" name="nama" value="<?= htmlspecialchars($row['nama']); ?>">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="stokMaterial">Stok</label>
                    <input type="number" class="form-control" id="stokMaterial" name="stok" value="<?= htmlspecialchars($row['qty']); ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="satuanMaterial">Satuan</label>
                    <input type="text" class="form-control" id="satuanMaterial" placeholder="Contoh: Kg" name="satuan" value="<?= htmlspecialchars($row['satuan']); ?>">
                    <p class="help-block">Hanya Masukkan Satuan saja: Kg atau gram</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="hargaMaterial">Harga</label>
                    <input type="number" class="form-control" id="hargaMaterial" name="harga" placeholder="Contoh: 1000" value="<?= htmlspecialchars($row['harga']); ?>">
                    <p class="help-block">Harga termasuk harga per kg atau per gram</p>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-warning"><i class="glyphicon glyphicon-edit"></i> Edit</button>
        <a href="inventory.php" class="btn btn-danger">Cancel</a>
    </form>
</div>

<?php 
include 'footer.php';
?>
