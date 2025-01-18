<?php 
include 'header.php';
?>

<!-- IMAGE -->
<div class="container-fluid" style="margin: 0;padding: 0;">
	<div class="image" style="margin-top: -21px">
		<img src="image/home/1.jpg" style="width: 100%;  height: 650px;">
	</div>
</div>
<br>
<br>

<!-- PRODUK TERBARU -->
<div class="container">

	<h4 class="text-center" style="font-family: arial; padding-top: 10px; padding-bottom: 10px; font-style: italic; line-height: 29px; border-top: 2px solidrgb(4, 21, 219); border-bottom: 2px solid #ff8d87;">
		Temukan segala kebutuhan proyek bangunan Anda di sini! Harga terjangkau, kualitas terjamin. Dapatkan penawaran terbaik dengan berbagai pilihan produk berkualitas yang siap mendukung suksesnya proyek Anda. Belanja sekarang dan nikmati promo spesial hanya di toko kami!
	</h4>

	<h2 style="width: 100%; border-bottom: 4px solidrgb(42, 7, 243); margin-top: 80px;"><b>Produk Kami</b></h2>

	<div class="row">
		<?php 
		// Menggunakan koneksi mysqli dengan new mysqli
		$host = 'localhost';  // Ganti dengan host Anda
		$username = 'root';   // Ganti dengan username database Anda
		$password = '';       // Ganti dengan password database Anda
		$database = 'db_bangunan';  // Ganti dengan nama database Anda
		
		$conn = new mysqli("localhost", "root", "", "dbbangunan");

		// Cek koneksi
		if ($conn->connect_error) {
			die("Koneksi gagal: " . $conn->connect_error);
		}

		// Mengambil data produk dari database
		$query = "SELECT * FROM produk";
		$result = $conn->query($query);

		// Mengecek apakah query berhasil
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
		?>
				<div class="col-sm-6 col-md-4">
					<div class="thumbnail">
						<img src="image/produk/<?= $row['image']; ?>" >
						<div class="caption">
							<h3><?= $row['nama'];  ?></h3>
							<h4>Rp. <?= number_format($row['harga']); ?></h4>
							<div class="row">
								<div class="col-md-6">
									<a href="detail_produk.php?produk=<?= $row['kode_produk']; ?>" class="btn btn-warning btn-block">Detail</a> 
								</div>
								<?php if(isset($_SESSION['kd_cs'])){ ?>
									<div class="col-md-6">
										<a href="proses/add.php?produk=<?= $row['kode_produk']; ?>&kd_cs=<?= $kode_cs; ?>&hal=1" class="btn btn-success btn-block" role="button"><i class="glyphicon glyphicon-shopping-cart"></i> Tambah</a>
									</div>
								<?php 
								}
								else{
								?>
									<div class="col-md-6">
										<a href="keranjang.php" class="btn btn-success btn-block" role="button"><i class="glyphicon glyphicon-shopping-cart"></i> Tambah</a>
									</div>
								<?php 
								}
								?>
							</div>
						</div>
					</div>
				</div>
		<?php 
			}
		} else {
			// Jika tidak ada produk
			echo "<p>No products available.</p>";
		}

		// Menutup koneksi
		$conn->close();
		?>
	</div>

</div>
<br>
<br>
<br>
<br>

<?php 
include 'footer.php';
?>
