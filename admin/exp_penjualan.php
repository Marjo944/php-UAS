<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
</head>
<body>
    <table border="1">
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Tanggal</th>
            <th>Qty</th>
        </tr>
        <?php
        // Set headers for Excel export
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan_Penjualan.xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        // Create database connection using MySQLi Object-Oriented style
        $koneksi = new mysqli("localhost", "root", "", "dbpw192_18410100054");

        // Check if connection was successful
        if ($koneksi->connect_error) {
            die("Connection failed: " . $koneksi->connect_error);
        }

        // Get date range from the form
        $date1 = $_POST['date1'];
        $date2 = $_POST['date2'];

        // Query to fetch sales data
        $query = "SELECT * FROM produksi WHERE terima = 1 AND tanggal BETWEEN ? AND ?";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("ss", $date1, $date2);  // Bind the date parameters
        $stmt->execute();

        // Get result from the query
        $result = $stmt->get_result();
        $no = 1;
        $total = 0;

        // Loop through the results and display them in the table
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $no . "</td>";
            echo "<td>" . $row['nama_produk'] . "</td>";
            echo "<td>" . $row['tanggal'] . "</td>";
            echo "<td>" . $row['qty'] . "</td>";
            echo "</tr>";

            // Add qty to the total count
            $total += $row['qty'];
            $no++;
        }

        // Display total quantity
        echo "<tr>";
        echo "<td colspan='4' class='text-right'><b>Total Jumlah Terjual = " . $total . "</b></td>";
        echo "</tr>";

        // Close the statement and database connection
        $stmt->close();
        $koneksi->close();
        ?>
    </table>
</body>
</html>
