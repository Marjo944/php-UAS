<?php 
include '../../koneksi/koneksi.php';

$kode = $_GET['kode'];
$produk = $koneksi->query("SELECT * FROM produk WHERE kode_produk ='$kode'");
$row = $produk->fetch_assoc();
unlink("../../image/produk/".$row['image']);
$koneksi->query("DELETE FROM bom_produk WHERE kode_produk = '$kode'");
$del = $koneksi->query("DELETE FROM produk WHERE kode_produk = '$kode'");

if($del){
    echo "
    <script>
    alert('DATA BERHASIL DIHAPUS');
    window.location = '../m_produk.php';
    </script>
    ";
}

?>
