<!DOCTYPE html>
<html>
<head>
    <title>Laporan Omset</title>
</head>
<body>
    <table border="1">
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
        // Set headers for Excel export
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan_Omset.xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        // Create a MySQLi object-oriented connection
        $koneksi = new mysqli("localhost", "root", "", "dbbangunan");

        // Check if the connection was successful
        if ($koneksi->connect_error) {
            die("Connection failed: " . $koneksi->connect_error);
        }

        // Get the date range from the form
        $date1 = $_POST['date1'];
        $date2 = $_POST['date2'];

        // Prepare the SQL query to prevent SQL injection
        $query = "SELECT * FROM produksi WHERE terima = 1 AND tanggal BETWEEN ? AND ?";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("ss", $date1, $date2);  // Bind the date parameters
        $stmt->execute();

        // Get the result from the query
        $result = $stmt->get_result();
        $no = 1;
        $total = 0;

        // Loop through the rows and display them
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $no . "</td>";
            echo "<td>" . $row['invoice'] . "</td>";
            echo "<td>" . $row['nama_produk'] . "</td>";
            echo "<td>" . number_format($row['harga'], 0, ',', '.') . "</td>";
            echo "<td>" . $row['qty'] . "</td>";
            echo "<td>" . number_format($row['harga'] * $row['qty'], 0, ',', '.') . "</td>";
            echo "<td>" . $row['tanggal'] . "</td>";
            echo "</tr>";

            // Add to the total
            $total += $row['harga'] * $row['qty'];
            $no++;
        }

        // Display the total revenue
        echo "<tr>";
        echo "<td colspan='7' class='text-right'><b>Total Pendapatan Kotor = " . number_format($total, 0, ',', '.') . "</b></td>";
        echo "</tr>";

        // Close the prepared statement and the connection
        $stmt->close();
        $koneksi->close();
        ?>
    </table>
</body>
</html>
