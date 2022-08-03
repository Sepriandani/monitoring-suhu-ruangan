<?php

//koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "tubes_pse_data");

function query($query)
{
    global $conn;
    $rows = [];
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}


$data = query("SELECT * FROM sensor_data order by reading_time desc limit 10")

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <title>Tubes PSE</title>
</head>

<body>
    <div class="container py-5">
        <!-- Tabel kelas -->
        <div class="card rounded shadow-sm mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">Tabel Data Sensor Tubes PSE</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Temperatur</th>
                                <th>Humidity</th>
                                <th>Pengunjung</th>
                                <th>Reading time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $d) : ?>
                                <tr>
                                    <td><?= $d['id']; ?></td>
                                    <td><?= $d['temp']; ?></td>
                                    <td><?= $d['humid']; ?></td>
                                    <td><?= $d['orang']; ?></td>
                                    <td><?= $d['reading_time']; ?></td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</body>

</html>