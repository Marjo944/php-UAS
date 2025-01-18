<?php 
include '../../koneksi/koneksi.php';
$inv = $_GET['inv'];

$result = $koneksi->query("SELECT * FROM produksi WHERE invoice = '$inv'");

while($row = $result->fetch_assoc()){
    $kodep = $row['kode_produk'];
    $t_bom = $koneksi->query("SELECT * FROM bom_produk WHERE kode_produk = '$kodep'");

    while($row1 = $t_bom->fetch_assoc()){
        $kodebk = $row1['kode_bk'];

        $inventory = $koneksi->query("SELECT * FROM inventory WHERE kode_bk = '$kodebk'");
        $r_inv = $inventory->fetch_assoc();

        $kebutuhan = $row1['kebutuhan'];    
        $qtyorder = $row['qty'];
        $inven = $r_inv['qty'];
        $bom = ($kebutuhan * $qtyorder);
        $hasil = $inven - $bom;

        $inventory = $koneksi->query("UPDATE inventory SET qty = '$hasil' WHERE kode_bk = '$kodebk'");

        if($inventory){
            $koneksi->query("UPDATE produksi SET terima = '1', status = '0' WHERE invoice = '$inv'");

            echo "
            <script>
            alert('PESANAN BERHASIL DITERIMA, BAHAN BAKU TELAH DIKURANGKAN');
            window.location = '../produksi.php';
            </script>
            ";
        }
    }
}
?>
