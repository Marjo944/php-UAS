<?php 
include '../../koneksi/koneksi.php';

$inv = $_GET['inv'];

$query = "UPDATE produksi SET tolak = 1, terima = 2 WHERE invoice = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("s", $inv);

if ($stmt->execute()) {
    echo "
    <script>
    alert('PESANAN DITOLAK');
    window.location = '../produksi.php';
    </script>
    ";
} else {
    echo "
    <script>
    alert('Gagal Memproses Pesanan');
    window.location = '../produksi.php';
    </script>
    ";
}

$stmt->close();
?>
