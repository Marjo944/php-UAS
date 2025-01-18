<?php
include 'header.php';
include 'koneksi/koneksi.php';  // Pastikan koneksi ke database sudah dilakukan

// Menampilkan Produk
?>
<div class="container">
	<h2 style=" width: 100%; border-bottom: 4px solid #ff8680"><b>Produk Kami</b></h2>

	<div class="row">
		<?php 
		// Query untuk mengambil semua produk
		$result = $koneksi->query("SELECT * FROM produk");
		
		// Menampilkan setiap produk
		while ($row = $result->fetch_assoc()) {
			?>
			<div class="col-sm-6 col-md-4">
				<div class="thumbnail">
					<!-- Menampilkan gambar produk -->
					<img src="image/produk/<?= htmlspecialchars($row['image']); ?>" alt="Product Image">
					<div class="caption">
						<!-- Menampilkan nama dan harga produk -->
						<h3><?= htmlspecialchars($row['nama']);  ?></h3>
						<h4>Rp.<?= number_format($row['harga']); ?></h4>
						
						<div class="row">
							<div class="col-md-6">
								<!-- Tombol Detail Produk -->
								<a href="detail_produk.php?produk=<?= urlencode($row['kode_produk']); ?>" class="btn btn-warning btn-block">Detail</a> 
							</div>
							
							<!-- Tombol Tambah ke Keranjang -->
							<?php if (isset($_SESSION['kd_cs'])) { ?>
								<div class="col-md-6">
									<!-- Menggunakan session untuk mengecek apakah pengguna sudah login -->
									<a href="proses/add.php?produk=<?= urlencode($row['kode_produk']); ?>&kd_cs=<?= urlencode($_SESSION['kd_cs']); ?>&hal=1" class="btn btn-success btn-block" role="button"><i class="glyphicon glyphicon-shopping-cart"></i> Tambah</a>
								</div>
							<?php } else { ?>
								<div class="col-md-6">
									<!-- Jika pengguna belum login, arahkan ke halaman keranjang -->
									<a href="keranjang.php" class="btn btn-success btn-block" role="button"><i class="glyphicon glyphicon-shopping-cart"></i> Tambah</a>
								</div>
							<?php } ?>
						</div>

					</div>
				</div>
			</div>
			<?php 
		}
		?>
	</div>

</div>

<?php 
include 'footer.php';
?>
