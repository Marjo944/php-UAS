<!DOCTYPE html>
<html>
<head>
    <title>Laporan Produksi</title>
</head>
<body>
    <table border="1">
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Tanggal</th>
            <th>Total Produksi</th>
        </tr>
        <?php
        // Export headers for Excel file download
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan_Produksi.xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        // Database connection using object-oriented style
        $koneksi = new mysqli("localhost", "root", "", "dbpbangunan");

        // Check for connection errors
        if ($koneksi->connect_error) {
            die("Connection failed: " . $koneksi->connect_error);
        }

        // Get the date range from the form submission
        $date1 = $_POST['date1'];
        $date2 = $_POST['date2'];

        // Query to fetch the data from the 'produksi' table
        $result = $koneksi->query("SELECT * FROM produksi WHERE terima = 1 AND tanggal BETWEEN '$date1' AND '$date2'");

        // Check if there are results
        if ($result->num_rows > 0) {
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

                // Add the quantity to the total
                $total += $row['qty'];
                $no++;
            }

            // Display the total production
            echo "<tr>";
            echo "<td colspan='4' class='text-right'><b>Total Jumlah Produksi = " . $total . "</b></td>";
            echo "</tr>";
        } else {
            // If no records are found
            echo "<tr><td colspan='4'>No records found for the selected date range.</td></tr>";
        }

        // Close the database connection
        $koneksi->close();
        ?>
    </table>
</body>
</html>
