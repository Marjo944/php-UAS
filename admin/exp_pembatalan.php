<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pembatalan</title>
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
        header("Content-Disposition: attachment; filename=Laporan_Pembatalan.xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        // Create a MySQLi object-oriented connection
        $koneksi = new mysqli("localhost", "root", "", "dbpw192_18410100054");

        // Check if the connection was successful
        if ($koneksi->connect_error) {
            die("Connection failed: " . $koneksi->connect_error);
        }

        // Get the date range from the form
        $date1 = $_POST['date1'];
        $date2 = $_POST['date2'];

        // Prepare the SQL query
        $query = "SELECT * FROM produksi WHERE tolak = 1 AND tanggal BETWEEN ? AND ?";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("ss", $date1, $date2);  // Bind the date parameters to the query
        $stmt->execute();

        // Get the result from the query
        $result = $stmt->get_result();
        $no = 1;
        $total = 0;

        // Loop through the rows and display them
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $no . "</td>";
            echo "<td>" . $row['nama_produk'] . "</td>";
            echo "<td>" . $row['tanggal'] . "</td>";
            echo "<td>" . $row['qty'] . "</td>";
            echo "</tr>";

            // Add qty to the total
            $total += $row['qty'];
            $no++;
        }

        // Display total cancelled items
        echo "<tr>";
        echo "<td colspan='4' class='text-right'><b>Jumlah dibatalkan = " . $total . "</b></td>";
        echo "</tr>";

        // Close the statement and connection
        $stmt->close();
        $koneksi->close();
        ?>
    </table>
</body>
</html>
