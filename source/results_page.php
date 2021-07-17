<?php
    session_start();
    if (!isset($_SESSION['user']) || !isset($_SESSION['role']))
    {
        header("Location: login_page.php");
    }
    if ($_SESSION['role'] != 'ADMINISTRATOR' && $_SESSION["role"] != "MANAGER")
    {
        header("Location: page.php");
    }

    if (isset($_GET["logout"]))
    {
        session_destroy();
        header("Location: login_page.php");
    }

    require 'Web/assets/MySQLConnection.php';

    if (isset($_GET["view_submit"])) 
    {
        header("Location: view_page.php");
    }
    else if (isset($_GET["add_submit"])) 
    {
        header("Location: add_page.php");
    }
    else if (isset($_GET["update_submit"]))
    {
        header("Location: update_page.php");
    }
    else if (isset($_GET["logs_submit"]))
    {
        header("Location: log_page.php");
    }

    if (isset($_POST["fillcombobox"]))
    {
        $specializari = GetDenumireSpecializare("");
        echo "<option>Filtrati dupa specializare</option>";
        for ($i = 0; $i < count($specializari); $i++)
        {
            echo "<option>".$specializari[$i]."</option>";
        }
        exit;
    }
    
    if (isset($_POST["fillresults"]))
    {                    
        $candidati = GetCodCandidatAndOptiuniCandidat();

        $mediiConcurs = array();

        foreach ($candidati as $key => $value)
        {
            $regula_admitere = GetDescriereRegulaAdmitereByDenumireSpecializare($value[0]);
            
            switch($regula_admitere)
            {
                case "Medie: 50% medie bacalaureat + 50% medie liceu":
                    $mediiConcurs[$key] = GetAverageOfMedieLiceuAndMedieBac($key);
                    break;
                case "Medie: 50% medie bacalaureat + 50% nota examen":
                    $mediiConcurs[$key] = GetAverageOfMedieBacAndNotaExamenByDenumireSpecializareAndCodCandidat($value[0], $key);
                    break;
                case "Certificat competenta lingvistica + Medie: 50% medie bacalaureat + 50% medie liceu":
                    $mediiConcurs[$key] = GetAverageOfMedieLiceuAndMedieBac($key);
                    break;
                case "Testare capacitate motrica generala + Medie: 50% medie bacalaureat + 50% nota proba practica":
                    $mediiConcurs[$key] = GetAverageOfMedieBacAndNotaExamenByDenumireSpecializareAndCodCandidat($value[0], $key);
                    break;
                case "Testare aptitudini pedagogice + Medie: 50% medie bacalaureat + 50% medie liceu":
                    $mediiConcurs[$key] = GetAverageOfMedieLiceuAndMedieBac($key);
                    break;
                case "Testare aptitudini socio-umane + Medie: 50% medie bacalaureat + 50% nota proba practica":
                    $mediiConcurs[$key] = GetAverageOfMedieBacAndNotaExamenByDenumireSpecializareAndCodCandidat($value[0], $key);
                    break;
                case "Testare aptitudini socio-umane + Medie: 50% medie bacalaureat + 50% nota interviu":
                    $mediiConcurs[$key] = GetAverageOfMedieBacAndNotaExamenByDenumireSpecializareAndCodCandidat($value[0], $key);
                    break;
                case "Medie: 100% nota examen":
                    $mediiConcurs[$key] = GetNotaExamenByDenumireSpecializareAndCodCandidat($value[0], $key);
                    break;
                case "Medie: 100% nota proba practica":
                    $mediiConcurs[$key] = GetNotaExamenByDenumireSpecializareAndCodCandidat($value[0], $key);
                    break;
            }
        }

        $admisi = array();
        $respinsi = array();
        foreach ($mediiConcurs as $key => $value)
        {
            if ($value == -1) 
            {
                $respinsi[$key] = $value;
            }
            else 
            {
                $admisi[$key] = $value;
            }

        }
        // High to low sort
        arsort($admisi);

        $row = "";
        $index = 1;
        foreach ($admisi as $key => $value)
        {
            if (isset($_POST["specializare"]) && $_POST["specializare"] != "" && $_POST["specializare"] != $candidati[$key][0])
            {
                continue;
            }
            $numeComplet = GetNumeCompletCandidatByCodCandidat($key);
            $medieConcurs = $value;
            $specializare = $candidati[$key][0];
            $formaInvatamant = GetBugetTaxaOptiuneCandidatByCodCandidatAndDenumireSpecializare($key, $candidati[$key][0]);

            $row = $row."<tr>";
            
            $row = $row."<td><input type=\"hidden\" name=\"index[]\" value=\"$index\"><b>$index</b></input></td>";
            $row = $row."<td><input type=\"hidden\" name=\"nume[]\" value=\"$numeComplet\">$numeComplet</input></td>";
            $row = $row."<td><input type=\"hidden\" name=\"medie[]\" value=\"$medieConcurs\">$medieConcurs</input></td>";
            $row = $row."<td><input type=\"hidden\" name=\"specializare[]\" value=\"$specializare\">$specializare</input></td>";
            $row = $row."<td><input type=\"hidden\" name=\"formaInvatamant[]\" value=\"$formaInvatamant\">$formaInvatamant</input></td>";
            $row = $row."<td><input type=\"hidden\" name=\"rezultat[]\" value=\"ADMIS\">ADMIS</input></td>";

            $row = $row."</tr>";

            $index++;
        }

        foreach ($respinsi as $key => $value)
        {
            if (isset($_POST["specializare"]) && $_POST["specializare"] != "" && $_POST["specializare"] != $candidati[$key][0])
            {
                continue;
            }
            $numeComplet = GetNumeCompletCandidatByCodCandidat($key);
            $specializare = $candidati[$key][0];
            $formaInvatamant = GetBugetTaxaOptiuneCandidatByCodCandidatAndDenumireSpecializare($key, $candidati[$key][0]);

            $row = $row."<tr>";

            $row = $row."<td><input type=\"hidden\" name=\"index[]\" value=\"$index\"><b>$index</b></input></td>";
            $row = $row."<td><input type=\"hidden\" name=\"nume[]\" value=\"$numeComplet\">$numeComplet</input></td>";
            $row = $row."<td><input type=\"hidden\" name=\"medie[]\" value=\"\"></input></td>";
            $row = $row."<td><input type=\"hidden\" name=\"specializare[]\" value=\"$specializare\">$specializare</input></td>";
            $row = $row."<td><input type=\"hidden\" name=\"formaInvatamant[]\" value=\"$formaInvatamant\">$formaInvatamant</input></td>";
            $row = $row."<td><input type=\"hidden\" name=\"rezultat[]\" value=\"RESPINS\">RESPINS</input></td>";
            
            $row = $row."</tr>";

            $index++;
        }

        echo $row;
        exit;
    }

    if (isset($_POST["drawpiechart"]))
    {

        $dataPoints = array();
        $candidati = GetCodCandidatAndOptiuniCandidat();
        $mediiConcurs = array();

        foreach ($candidati as $key => $value)
        {
            $regula_admitere = GetDescriereRegulaAdmitereByDenumireSpecializare($value[0]);
            
            switch($regula_admitere)
            {
                case "Medie: 50% medie bacalaureat + 50% medie liceu":
                    $mediiConcurs[$key] = GetAverageOfMedieLiceuAndMedieBac($key);
                    break;
                case "Medie: 50% medie bacalaureat + 50% nota examen":
                    $mediiConcurs[$key] = GetAverageOfMedieBacAndNotaExamenByDenumireSpecializareAndCodCandidat($value[0], $key);
                    break;
                case "Certificat competenta lingvistica + Medie: 50% medie bacalaureat + 50% medie liceu":
                    $mediiConcurs[$key] = GetAverageOfMedieLiceuAndMedieBac($key);
                    break;
                case "Testare capacitate motrica generala + Medie: 50% medie bacalaureat + 50% nota proba practica":
                    $mediiConcurs[$key] = GetAverageOfMedieBacAndNotaExamenByDenumireSpecializareAndCodCandidat($value[0], $key);
                    break;
                case "Testare aptitudini pedagogice + Medie: 50% medie bacalaureat + 50% medie liceu":
                    $mediiConcurs[$key] = GetAverageOfMedieLiceuAndMedieBac($key);
                    break;
                case "Testare aptitudini socio-umane + Medie: 50% medie bacalaureat + 50% nota proba practica":
                    $mediiConcurs[$key] = GetAverageOfMedieBacAndNotaExamenByDenumireSpecializareAndCodCandidat($value[0], $key);
                    break;
                case "Testare aptitudini socio-umane + Medie: 50% medie bacalaureat + 50% nota interviu":
                    $mediiConcurs[$key] = GetAverageOfMedieBacAndNotaExamenByDenumireSpecializareAndCodCandidat($value[0], $key);
                    break;
                case "Medie: 100% nota examen":
                    $mediiConcurs[$key] = GetNotaExamenByDenumireSpecializareAndCodCandidat($value[0], $key);
                    break;
                case "Medie: 100% nota proba practica":
                    $mediiConcurs[$key] = GetNotaExamenByDenumireSpecializareAndCodCandidat($value[0], $key);
                    break;
                }
        }

        $admisi = 0;
        $respinsi = 0;
        foreach ($mediiConcurs as $key => $value)
        {
            if (isset($_POST["specializare"]) && $_POST["specializare"] != "" && $_POST["specializare"] != $candidati[$key][0])
            {
                continue;
            }
            if ($value == -1) 
            {
                $respinsi++;
            }
            else 
            {
                $admisi++;
            }
        }
        echo $admisi."#".$respinsi;
        exit;
    }   

    if (isset($_GET["pdfexport"]))
    {   
        $isReady = true;
        if (!isset($_GET["index"]))
        {
            $isReady = false;
        }
        else if (!isset($_GET["nume"]))
        {
            $isReady = false;
        }
        else if (!isset($_GET["medie"]))
        {
            $isReady = false;
        }
        else if (!isset($_GET["specializare"]))
        {
            $isReady = false;
        }
        else if (!isset($_GET["formaInvatamant"]))
        {
            $isReady = false;
        }
        else if (!isset($_GET["rezultat"]))
        {
            $isReady = false;
        }
        
        if ($isReady)
        {
            require('fpdf.php');


            class PDF extends FPDF
            {
                function BasicTable($header)
                {
                    $widths = [10, 62, 12, 70, 15, 18];
                    $height = 7;
                    // Header
                    for($i = 0; $i < count($header); $i++)
                        $this->Cell($widths[$i], 10, $header[$i], 1);
                    $this->Ln();
                    // Data
                    for($i = 0; $i < count($_GET["nume"]); $i++)
                    {
                        $this->Cell($widths[0], $height, $_GET["index"][$i], 1);
                        $this->Cell($widths[1], $height, $_GET["nume"][$i], 1);
                        $this->Cell($widths[2], $height, $_GET["medie"][$i], 1);
                        $this->Cell($widths[3], $height, $_GET["specializare"][$i], 1);
                        $this->Cell($widths[4], $height, $_GET["formaInvatamant"][$i], 1);
                        $this->Cell($widths[5], $height, $_GET["rezultat"][$i], 1);
                        $this->Ln();
                    }
                }
            }
            $header = array('#', 'Nume', 'Medie', 'Specializare', 'Forma f.', 'Rezultat');
            $pdf = new PDF();
            $pdf->SetTitle("Rezultate candidati admisi/respinsi", true);
            $pdf->AddPage();
            $pdf->SetFont('Arial', '', 10);
            $pdf->BasicTable($header);
            $pdf->Output("D", "Rezultate.pdf");
        }
    }

    if (isset($_GET["xlsexport"]))
    {
        $isReady = true;
        if (!isset($_GET["index"]))
        {
            $isReady = false;
        }
        else if (!isset($_GET["nume"]))
        {
            $isReady = false;
        }
        else if (!isset($_GET["medie"]))
        {
            $isReady = false;
        }
        else if (!isset($_GET["specializare"]))
        {
            $isReady = false;
        }
        else if (!isset($_GET["formaInvatamant"]))
        {
            $isReady = false;
        }
        else if (!isset($_GET["rezultat"]))
        {
            $isReady = false;
        }
        
        if ($isReady)
        {
            $data = array();
            for($i = 0; $i < count($_GET["nume"]); $i++)
            {
                array_push($data, array("#" => $_GET["index"][$i], 
                "NUME" => $_GET["nume"][$i], 
                "MEDIE CONCURS" => $_GET["medie"][$i], 
                "SPECIALIZARE" => $_GET["specializare"][$i], 
                "FORMA DE FINANTARE" => $_GET["formaInvatamant"][$i], 
                "REZULTAT" => $_GET["rezultat"][$i]));
            }

            function cleanData(&$str)
            {
                if($str == 't') $str = 'TRUE';
                if($str == 'f') $str = 'FALSE';
                if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {
                $str = "'$str";
                }
                if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
            }

            $filename = "Rezultate.csv";
            header("Content-Disposition: attachment; filename=\"$filename\"");
            header("Content-Type: text/csv");

            $out = fopen("php://output", 'w');

            $flag = false;
            foreach($data as $row) {
                if(!$flag) {
                fputcsv($out, array_keys($row), ',', '"');
                $flag = true;
                }
                array_walk($row, __NAMESPACE__ . '\cleanData');
                fputcsv($out, array_values($row), ',', '"');
            }

            fclose($out);
            exit;
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="icon" href="Resources/ugal-icon.png" type="image/ico">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        
        <title>Rezultate | ADMITERE LA FACULTATE</title>

        <style>
            .header {
                display: flex;
                justify-content: space-between;
                margin: 0.5em;
                margin-bottom: 2em;
                text-align: left;
                font-size: 20px;
                font-style: italic;
                color: rgb(24, 66, 115);
            }
            .header .ugallogo {
                width: 96px;
                height: 96px;
            }

            /* Style the tab bar*/
            .tab {
                overflow: hidden;
                background-color: #f1f1f1;
                margin-bottom: 1em;
            }
            /* Style the buttons inside the tab bar*/
            .tab button {
                float: left;
                border: none;
                outline: none;   
                padding: 1em 1em;
            }
            .logoutbutton button:active, button:focus {
                background: #212529;
            }

            /* RESULTS CONTROLS */
            .controls {
                width: 92em;
                display: flex;
                justify-content: space-between;
                margin-top: 2em;
                margin-left: 1em;
            }
            .controls .combobox {
                width: auto;
                margin-right: 1em;
            }
            .controls .exportbuttons {
                display: flex;
                flex-direction: row;
            }
            .controls .exportxls {
                margin-left: 1em;
            }
            
            .results {
                display: flex;
                flex-direction: row;
            }
            .resultstable {
                border: solid 1px #212529;
                border-radius: 0.5em;
                margin-left: 1em;
                margin-top: 1em;
                margin-bottom: 1em;
                margin-right: 1em;
                width: 92em;
                min-width: 92em;
                height: 41.5em;
                overflow-y: auto;
            }
            .piechart {
                background: red;
            }
        </style>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script>
            $(document).ready(function () {
                $.ajax({
                    type: "post",
                    data: {fillcombobox: "ok"},
                    success: function(response){
                        $("#combobox").html(response);
                    }
                });
                $.ajax({
                    type: "post",
                    data: {fillresults: "ok"},
                    success: function(response){
                        $("#resultstable tbody tr").each(function(){
                            this.parentNode.removeChild(this); 
                        });
                        $("#resultstable > tbody:last-child").append(response);
                    }
                });

                $.ajax({
                    type: "post",
                    data: {drawpiechart: "ok"},
                    success: function(response){
                        var admisi = parseInt(response.split("#")[0]);
                        var respinsi = parseInt(response.split("#")[1]);
                        
                        // Load google charts
                        google.charts.load('current', {'packages':['corechart']});
                        google.charts.setOnLoadCallback(drawChart);

                        // Draw the chart and set the chart values
                        function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                                ['Task', 'Rata admisi/respinsi'],
                                ['Admisi', admisi],
                                ['Respinsi', respinsi]]);

                            var options = {title:'Rata candidatilor admisi/respinsi', legend:'none', pieSliceText: 'percentage', colors: ['#238823', '#D2222D'], chartArea: {left: "5%", right: "5%", top: "0%", height: "100%",width: "100%"}}

                            // Display the chart inside the <div> element with id="piechart"
                            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                            chart.draw(data, options);
                        }
                    }     
                });

                $("#combobox").change(function () {
                    var value = $("#combobox").val();
                    
                    if (value == "Filtrati dupa specializare") {
                        value = "";
                    }

                    $.ajax({
                        type: "post",
                        data: {
                            fillresults: "ok",
                            specializare: value    
                        },
                        success: function(response){
                            $("#resultstable tbody tr").each(function(){
                                this.parentNode.removeChild(this); 
                            });
                            $("#resultstable > tbody:last-child").append(response);
                        }
                    });

                    $.ajax({
                        type: "post",
                        data: {
                            drawpiechart: "ok",
                            specializare: value
                        },
                        success: function(response){
                            var admisi = parseInt(response.split("#")[0]);
                            var respinsi = parseInt(response.split("#")[1]);
                            
                            // Load google charts
                            google.charts.load('current', {'packages':['corechart']});
                            google.charts.setOnLoadCallback(drawChart);

                            // Draw the chart and set the chart values
                            function drawChart() {
                                var data = google.visualization.arrayToDataTable([
                                    ['Task', 'Rata admisi/respinsi'],
                                    ['Admisi', admisi],
                                    ['Respinsi', respinsi]]);

                                var options = {legend:'none', pieSliceText: 'percentage', colors: ['#238823', '#D2222D'], chartArea: {left: "5%", right: "5%", top: "0%", height: "100%",width: "100%"}}

                                // Displaying the chart
                                var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                                chart.draw(data, options);
                            }
                        }     
                    });
                });
            });
        </script>
    </head>
    
    <body>
        <!-- IMAGINE UGAL + NUME -->
        <div class="header">
            <div class="ugallogo">
                <a href="<?php echo "page.php";?>"><img src="Resources/ugal-450x450-grayscale.png" alt="UGAL" class="ugallogo"></a>
            </div>
            <form action="" method="get">
                <div class="user">
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-dark" style="pointer-events: none"><b><?php echo ucfirst(strtolower($_SESSION["fname"][0])).". ".ucfirst(strtolower($_SESSION["lname"])); ?></b></button>
                        <button type="button" class="btn btn-outline-dark" style="pointer-events: none"><?php echo ucfirst(strtolower($_SESSION["role"])); ?></button>
                        <button type="button" class="btn btn-dark dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    </button>
                        <div class="dropdown-menu" style="margin-right: 5px; padding-left: 0px; padding-right: 0px; min-width: 0px;">
                            <div class="logoutbutton">
                                <button class="dropdown-item" name="logout" type="submit">Deconectati-va</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <form action="" method="get">
            <div class="tab">
                <!-- BUTON VIZUALIZEAZA -->
                <button class="btn btn-outline-dark" type="submit" name="view_submit">VIZUALIZEAZA</button>
                <?php 
                    if ($_SESSION["role"] == "ADMINISTRATOR" || $_SESSION["role"] == "MANAGER") 
                    {
                ?>
                <!-- BUTON ADAUGA -->
                <button class="btn btn-outline-dark" type="submit" name="add_submit">ADAUGA</button>

                <!-- BUTON ACTUALIZEAZA -->
                <button class="btn btn-outline-dark" type="submit" name="update_submit">ACTUALIZEAZA</button>

                <!-- BUTON REZULTATE -->
                <button class="btn btn-dark" type="submit" name="results_submit">REZULTATE</button>
                <?php
                    }
                ?>
                <?php
                    if ($_SESSION["role"] == "ADMINISTRATOR")
                    {
                ?>
                <!-- BUTON LOG-uri -->
                <button class="btn btn-outline-dark" type="submit" name="logs_submit">LOG-URI</button>
                <?php
                    }
                ?>
            </div>
        </form>
        <form action="" method="get">
        <div class="controls">
            <!-- COMBOBOX -->
            <div class="combobox">
                <select name="combobox" class="form-control" id="combobox"></select>
            </div>
            <div class="exportbuttons">
                <div class="exportpdf">
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-dark" style="pointer-events: none;"><b>PDF</b></button>
                        <button class="btn btn-outline-danger" type="submit" name="pdfexport" id="pdfexport">
                            <svg class="bi bi-download" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M.5 8a.5.5 0 01.5.5V12a1 1 0 001 1h12a1 1 0 001-1V8.5a.5.5 0 011 0V12a2 2 0 01-2 2H2a2 2 0 01-2-2V8.5A.5.5 0 01.5 8z" clip-rule="evenodd"/>
                                <path fill-rule="evenodd" d="M5 7.5a.5.5 0 01.707 0L8 9.793 10.293 7.5a.5.5 0 11.707.707l-2.646 2.647a.5.5 0 01-.708 0L5 8.207A.5.5 0 015 7.5z" clip-rule="evenodd"/>
                                <path fill-rule="evenodd" d="M8 1a.5.5 0 01.5.5v8a.5.5 0 01-1 0v-8A.5.5 0 018 1z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="exportxls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-dark" style="pointer-events: none;"><b>XLS</b></button>
                        <button class="btn btn-outline-success" type="submit" name="xlsexport" id="xlsexport">
                            <svg class="bi bi-download" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M.5 8a.5.5 0 01.5.5V12a1 1 0 001 1h12a1 1 0 001-1V8.5a.5.5 0 011 0V12a2 2 0 01-2 2H2a2 2 0 01-2-2V8.5A.5.5 0 01.5 8z" clip-rule="evenodd"/>
                                <path fill-rule="evenodd" d="M5 7.5a.5.5 0 01.707 0L8 9.793 10.293 7.5a.5.5 0 11.707.707l-2.646 2.647a.5.5 0 01-.708 0L5 8.207A.5.5 0 015 7.5z" clip-rule="evenodd"/>
                                <path fill-rule="evenodd" d="M8 1a.5.5 0 01.5.5v8a.5.5 0 01-1 0v-8A.5.5 0 018 1z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="results">
            <!-- RESULTS TABLE -->
            <div class="resultstable">
                <table class="table" id="resultstable">
                    <!-- TABLE HEADER -->
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">NUME</th>
                            <th scope="col">MEDIE CONCURS</th>
                            <th scope="col">SPECIALIZARE</th>
                            <th scope="col">FORMA DE FINANTARE</th>
                            <th scope="col">REZULTAT</th>
                        </tr>
                    </thead>
                    <!-- TABLE BODY -->
                    <tbody>
                    </tbody>
                </table>
            </div>
             <!-- RESULTS PIE CHART -->
             <div class="piechar" name="piechart" id="piechart"></div>
        </div>
        </form>
    </body>
</html> 
