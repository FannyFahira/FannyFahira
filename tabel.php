<?php
// Inisialisasi variable
$tableSize = 10;
$highlightedRow = isset($_POST['highlightRow']) ? $_POST['highlightRow'] : -1;
$highlightedCol = isset($_POST['highlightCol']) ? $_POST['highlightCol'] : -1;
$showDetails = isset($_POST['showDetails']) ? true : false;
$selectedNumber = isset($_POST['selectedNumber']) ? $_POST['selectedNumber'] : 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tabel Perkalian | Perpustakaan Fanny Fahira</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>
    
<body>   
    <!-- loader -->
    <div class="bg-loader">
        <div class="loader"></div>
    </div>
    
    <!-- header -->
    <div class="medsos">
        <div class="container">
            <ul>
                <li><a href="https://www.instagram.com/fny_fhira/"><i class="fa-brands fa-instagram"></i></a></li>
                <li><a href="https://www.youtube.com/@FannyFahira777"><i class="fa-brands fa-youtube"></i></a></li>
                <li><a href="https://x.com/funnylaa7"><i class="fa-brands fa-x-twitter"></i></a></li>
            </ul>
        </div>
    </div>
    <header>
        <div class="container">
            <h1><a href="index.html">FANNY FAHIRA</a></h1>
            <ul>
                <li><a href="index.html">HOME</a></li>
                <li><a href="about.html">ABOUT</a></li>
                <li><a href="contact.html">CONTACT</a></li>
                <li class="active"><a href="tabel.php">PHP</a></li>
                <li><a href="formulir.php">FORM</a></li>
            </ul>
        </div>
    </header>

    <section class="about">
        <div class="container">
            <h3>Tabel Perkalian Interaktif</h3>
            
            <div class="multiplication-container">
                <h2 class="multiplication-title">Tabel Perkalian 10 x 10</h2>
                
                <div class="multiplication-controls">
                    <div class="control-group">
                        <span class="control-label">Pilih Angka untuk Dihighlight:</span>
                        <div class="number-selector">
                            <?php for ($i = 1; $i <= $tableSize; $i++): ?>
                                <button class="number-btn <?php echo $selectedNumber == $i ? 'active' : ''; ?>" 
                                    onclick="selectNumber(<?php echo $i; ?>)"><?php echo $i; ?></button>
                            <?php endfor; ?>
                        </div>
                        
                        <div class="show-details-control">
                            <input type="checkbox" id="showDetails" <?php echo $showDetails ? 'checked' : ''; ?> 
                                onchange="toggleDetails()">
                            <label for="showDetails">Tampilkan Detail</label>
                        </div>
                    </div>
                </div>
                
                <form id="controlForm" method="post">
                    <input type="hidden" name="highlightRow" id="highlightRow" value="<?php echo $highlightedRow; ?>">
                    <input type="hidden" name="highlightCol" id="highlightCol" value="<?php echo $highlightedCol; ?>">
                    <input type="hidden" name="selectedNumber" id="selectedNumber" value="<?php echo $selectedNumber; ?>">
                    <input type="hidden" name="showDetails" id="showDetailsInput" value="<?php echo $showDetails ? '1' : ''; ?>">
                </form>
                
                <table class="multiplication-table">
                    <thead>
                        <tr>
                            <th>x</th>
                            <?php for ($i = 1; $i <= $tableSize; $i++): ?>
                                <th class="<?php echo $i == $selectedNumber ? 'highlighted' : ''; ?>"><?php echo $i; ?></th>
                            <?php endfor; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($row = 1; $row <= $tableSize; $row++): ?>
                            <tr>
                                <th class="<?php echo $row == $selectedNumber ? 'highlighted' : ''; ?>"><?php echo $row; ?></th>
                                <?php for ($col = 1; $col <= $tableSize; $col++): ?>
                                    <?php
                                    $isHighlighted = ($row == $highlightedRow && $col == $highlightedCol);
                                    $isInSelectedRow = ($row == $selectedNumber);
                                    $isInSelectedCol = ($col == $selectedNumber);
                                    $result = $row * $col;
                                    $isResultSelected = ($result == $selectedNumber);
                                    
                                    $cellClass = '';
                                    if ($isHighlighted) {
                                        $cellClass = 'highlighted';
                                    } elseif ($isInSelectedRow || $isInSelectedCol || $isResultSelected) {
                                        $cellClass = 'highlighted-light';
                                    }
                                    ?>
                                    <td class="<?php echo $cellClass; ?>" 
                                        onclick="highlightCell(<?php echo $row; ?>, <?php echo $col; ?>)">
                                        <?php echo $result; ?>
                                    </td>
                                <?php endfor; ?>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
                
                <?php if ($highlightedRow > 0 && $highlightedCol > 0): ?>
                <div class="details-section">
                    <h3 class="details-title">Detail Perkalian <?php echo $highlightedRow; ?> x <?php echo $highlightedCol; ?></h3>
                    
                    <div class="details-content">
                        <div class="details-card">
                            <h4>Formula</h4>
                            <div class="formula"><?php echo $highlightedRow; ?> × <?php echo $highlightedCol; ?> = <?php echo $highlightedRow * $highlightedCol; ?></div>
                            <div class="result">Hasil: <?php echo $highlightedRow * $highlightedCol; ?></div>
                        </div>
                        
                        <div class="details-card">
                            <h4>Penjumlahan Berurutan</h4>
                            <div class="formula">
                                <?php
                                $numbers = array();
                                for ($i = 0; $i < $highlightedRow; $i++) {
                                    $numbers[] = $highlightedCol;
                                }
                                echo implode(' + ', $numbers) . ' = ' . ($highlightedRow * $highlightedCol);
                                ?>
                            </div>
                        </div>
                        
                        <div class="details-card factors">
                            <h4>Faktor dari <?php echo $highlightedRow * $highlightedCol; ?></h4>
                            <ul>
                                <?php
                                $product = $highlightedRow * $highlightedCol;
                                for ($i = 1; $i <= $product; $i++) {
                                    if ($product % $i == 0) {
                                        echo "<li>$i</li>";
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <div class="action-buttons">
                    <button class="action-btn reset-btn" onclick="resetTable()">Reset Tabel</button>
                    <button class="action-btn print-btn" onclick="window.print()">Cetak Tabel</button>
                </div>
            </div>
        </div>
    </section>
    
    <!-- footer -->
    <footer>
        <div class="container">
            <small>Copyright &copy; 2025 Perpustakaan Fanny Fahira</small>
        </div>
    </footer>

    <script type="text/javascript">
        $(document).ready(function(){
            $(".bg-loader").hide();
        });
        
        function highlightCell(row, col) {
            document.getElementById('highlightRow').value = row;
            document.getElementById('highlightCol').value = col;
            document.getElementById('controlForm').submit();
        }
        
        function selectNumber(num) {
            document.getElementById('selectedNumber').value = num;
            document.getElementById('controlForm').submit();
        }
        
        function toggleDetails() {
            const checkbox = document.getElementById('showDetails');
            document.getElementById('showDetailsInput').value = checkbox.checked ? '1' : '';
            document.getElementById('controlForm').submit();
        }
        
        function resetTable() {
            document.getElementById('highlightRow').value = -1;
            document.getElementById('highlightCol').value = -1;
            document.getElementById('selectedNumber').value = 1;
            document.getElementById('showDetailsInput').value = '';
            document.getElementById('controlForm').submit();
        }
    </script>
</body>
</html>
