<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tabel Perkalian 10x10</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        table {
            border-collapse: collapse;
            margin: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        caption {
            font-size: 1.5em;
            margin-bottom: 15px;
            font-weight: bold;
        }
        th, td {
            width: 50px;
            height: 50px;
            text-align: center;
            border: 1px solid #dee2e6;
            padding: 10px;
        }
        th {
            background-color: #343a40;
            color: white;
        }
        td {
            background-color: #ffffff;
            transition: background 0.3s ease;
        }
        td:hover {
            background-color: #e9ecef;
            font-weight: bold;
        }
        tr:nth-child(even) td {
            background-color: #f1f3f5;
        }
    </style>
</head>
<body>

    <table>
        <caption>Tabel Perkalian 10x10</caption>
        <thead>
            <tr>
                <th>&times;</th>
                <?php for ($i = 1; $i <= 10; $i++) { echo "<th>$i</th>"; } ?>
            </tr>
        </thead>
        <tbody>
            <?php
            for ($i = 1; $i <= 10; $i++) {
                echo "<tr>";
                echo "<th>$i</th>";
                for ($j = 1; $j <= 10; $j++) {
                    $hasil = $i * $j;
                    echo "<td>$hasil</td>";
                }
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>
