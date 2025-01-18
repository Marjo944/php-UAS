<!DOCTYPE html>
<html>
<head>
    <title>Laporan Profit</title>
</head>
<body>
    <table>
        <tr>
            <th>No</th>
            <th>Invoice</th>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Qty</th>
            <th>Subtotal</th>
            <th>Tanggal</th>
        </tr>
        <?php 
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan_Profit.xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        // Database connection
        $koneksi = new mysqli("localhost", "root", "", "dbbangunan");

        // Check for connection errors
        if ($koneksi->connect_error) {
            die("Connection failed: " . $koneksi->connect_error);
        }

        // Get the date range from POST data
        $date1 = $_POST['date1'];
        $date2 = $_POST['date2'];

        // Query to fetch produk data
        $result = $koneksi->query("SELECT * FROM produksi WHERE terima = 1 AND tanggal BETWEEN '$date1' AND '$date2'");
        $no = 1;
        $total = 0;

        // Loop through produk data
        while ($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td><?= $no; ?></td>
                <td><?= $row['invoice']; ?></td>
                <td><?= $row['nama_produk']; ?></td>
                <td><?= number_format($row['harga']); ?></td>
                <td><?= $row['qty']; ?></td>
                <td><?= number_format($row['harga'] * $row['qty']); ?></td>
                <td><?= $row['tanggal']; ?></td>
            </tr>
            <?php 
            $total += $row['harga'] * $row['qty'];
            $no++;
        }
        ?>
        <tr>
            <td colspan="7" class="text-right"><b>Total Pendapatan Kotor = <?= number_format($total); ?></b></td>
        </tr>
    </table>

    <h4><b>Pemotongan dengan Biaya Bahan Baku</b></h4>
    <table class="table table-striped">
        <tr>
            <th>No</th>
            <th>Nama Bahan Baku</th>
            <th>Harga</th>
            <th>Kebutuhan</th>
            <th>Subtotal</th>
        </tr>
        <?php 
        // Reset values for bahan baku calculation
        $result = $koneksi->query("SELECT * FROM produksi WHERE terima = 1 AND tanggal BETWEEN '$date1' AND '$date2'");
        $no1 = 1;
        $totalb = 0;

        // Loop through produk data to fetch bahan baku details
        while ($row = $result->fetch_assoc()) {
            $kd = $row['kode_produk'];

            // Query to get bahan baku data for each produk
            $bahan = $koneksi->query("SELECT b.kebutuhan as kebutuhan, i.nama as nama, i.harga as harga 
                                      FROM bom_produk b 
                                      JOIN inventory i ON b.kode_bk = i.kode_bk 
                                      WHERE b.kode_produk = '$kd'");

            while ($row1 = $bahan->fetch_assoc()) {
                ?>
                <tr>
                    <td><?= $no1; ?></td>
                    <td><?= $row1['nama']; ?></td>
                    <td><?= number_format($row1['harga']); ?></td>
                    <td><?= $row1['kebutuhan']; ?></td>
                    <td><?= number_format($row1['harga'] * $row1['kebutuhan']); ?></td>
                </tr>
                <?php 
                $totalb += $row1['harga'] * $row1['kebutuhan'];
                $no1++;
            }
        }
        ?>
        <tr>
            <td colspan="7" class="text-right"><b>Total Biaya Bahan Baku = <?= number_format($totalb); ?></b></td>
        </tr>
        <tr>
            <td colspan="7" class="text-right bg-success" style="color: green;">
                <b>TOTAL PENDAPATAN BERSIH = <?= number_format($total - $totalb); ?></b>
            </td>
        </tr>
    </table>
</body>
</html>
