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
    else if (isset($_GET["update_submit"]))
    {
        header("Location: update_page.php");
    } 
    else if (isset($_GET["results_submit"]))
    {
        header("Location: results_page.php");   
    }
    else if (isset($_GET["logs_submit"]))
    {
        header("Location: log_page.php");
    }

    if (isset($_POST["selectedfacultate"]))
    {
        echo "<option>Selectati o facultate</option>";

        if ($_POST["selectedfacultate"] != "Selectati o universitate")
        {
            $facultati = GetFacultateByUniversitate($_POST["selectedfacultate"]);

            for ($i = 0; $i < count($facultati); $i++) {
                echo "<option";
                if ("" === $facultati[$i]) 
                { 
                    echo " selected"; 
                }
                echo ">";
                echo $facultati[$i]; 
                echo "</option>";
            }
        }
        exit;
    }

    if (isset($_POST["selecteddomeniu"]))
    {
        echo "<option>Selectati un domeniu</option>";

        if ($_POST["selecteddomeniu"] != "Selectati o facultate")
        {
            $domenii = GetDomeniuByFacultate($_POST["selecteddomeniu"]);

            for ($i = 0; $i < count($domenii); $i++)
            {
                echo "<option";
                if ("" === $domenii[$i]) 
                { 
                    echo " selected"; 
                }
                echo ">";
                echo $domenii[$i]; 
                echo "</option>";
            }
        }
        exit;
    }

    if (isset($_POST["selectedspecializare"]))
    {
        echo "<option>Selectati o specializare</option>";

        if ($_POST["selectedspecializare"] != "Selectati un domeniu")
        {
            $specializari = GetSpecializareByDomeniu($_POST["selectedspecializare"]);

            for ($i = 0; $i < count($specializari); $i++) {
                echo "<option";
                if ("" === $specializari[$i]) 
                { 
                    echo " selected"; 
                }
                echo ">";
                echo $specializari[$i]; 
                echo "</option>";
            }
        }
        exit;
    }

    if (isset($_POST["selectedbugettaxa"]))
    {
        echo "<option>Selectati o forma de invatamant</option>";

        if ($_POST["selectedbugettaxa"] != "Selectati o specializare")
        {
            $formeDeInvatamant = array("Buget", "Taxa");

            for ($i = 0; $i < count($formeDeInvatamant); $i++) {
                echo "<option";
                if ("" === $formeDeInvatamant[$i]) 
                { 
                    echo " selected"; 
                }
                echo ">";
                echo $formeDeInvatamant[$i]; 
                echo "</option>";
            }
        }
        exit;
    }

    // Submitting the form
    if (isset($_POST["formsubmit"])){
        // Checking for cnp duplicates
        $duplicates = -1;
        if (isset($_POST["checkcnpforduplicates"])){
            $duplicates = GetCountCNPByCNP($_POST["checkcnpforduplicates"]);
        }
        if ($duplicates != 0) {
            echo $duplicates;
            exit;
        } else {
            echo 0;
        }

        $ready = true;
        if (!isset($_POST["nume"]))
        {
            $ready = false;
        }
        else if (!isset($_POST["inittata"]))
        {
            $ready = false;
        }
        else if (!isset($_POST["prenume"]))
        {
            $ready = false;
        }
        else if (!isset($_POST["cnp"]))
        {
            $ready = false;
        }
        else if (!isset($_POST["datanastere"]))
        {
            $ready = false;
        }
        else if (!isset($_POST["liceuabsolvit"]))
        {
            $ready = false;
        }
        else if (!isset($_POST["medieliceu"]))
        {
            $ready = false;
        }
        else if (!isset($_POST["mediebac"]))
        {
            $ready = false;
        }
        else if (!isset($_POST["specializare"]))
        {
            $ready = false;
        }
        else if (!isset($_POST["bugettaxa"]))
        {
            $ready = false;
        }

        $nume = $_POST["nume"];
        $initTata = $_POST["inittata"];
        $prenume = $_POST["prenume"];
        $cnp = $_POST["cnp"];
        $dataNastere = $_POST["datanastere"];
        $liceuAbsolvit = $_POST["liceuabsolvit"];
        $medieLiceu = $_POST["medieliceu"];
        $medieBac = $_POST["mediebac"];
        $specializari = json_decode(stripslashes($_POST["specializare"]));
        $bugetTaxa = json_decode(stripslashes($_POST["bugettaxa"]));

        if ($ready){
            // Adding candidat
            AddCandidat($nume, $initTata, $prenume, $cnp, $dataNastere, $liceuAbsolvit, $medieLiceu, $medieBac);

            // Logging the operation
            date_default_timezone_set('Europe/Bucharest');
            $cod_u = GetCodUserByUsername($_SESSION['user']);
            $time = date('Y-m-d H:i:s');
            $action = "INSERT";
            $query = "INSERT INTO candidat(cod_c, nume, init_tata, prenume, cnp, data_n, den_liceu, medie_liceu, medie_bac) VALUES ($nume, $initTata, $prenume, $cnp, $dataNastere, $liceuAbsolvit, $medieLiceu, $medieBac)";
            AddLog($cod_u, $time, $action, $query);

            // Adding optiuni candidat
            for ($i = 0; $i < count($specializari); $i++) {
                AddOptiuneCandidat($bugetTaxa[$i], $specializari[$i]);

                // Logging the operation
                date_default_timezone_set('Europe/Bucharest');
                $cod_u = GetCodUserByUsername($_SESSION['user']);
                $time = date('Y-m-d H:i:s');
                $action = "INSERT";
                $query = "INSERT INTO optiune_candidat(den_s, buget_taxa) VALUES ($specializari[$i], $bugetTaxa[$i])";
                AddLog($cod_u, $time, $action, $query);
            }

            // Adding rezultate candidat
            AddRezultatCandidat();
        }
        exit;
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
        
        <title>Adauga | ADMITERE LA FACULTATE</title>

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

            /* ADD CONTROLS */
            .addpageobjects {
                margin: auto;
                margin-left: 1em;
                display: flex;
                flex-direction: row;
            }

            .fieldsetborder {
                margin-right: 1em;
                margin-top: 0.25em;
                border: solid 1px #DDD;
                border-radius: 0.5em;
                padding: 0em 1em 1em 1em;
                min-width: 27em;
            }   
            .fieldsettext {
                width: auto;
                border: none;
                font-size: 1em;
                font-weight: bold;
            }

            .addpageobjects .datecandidat {
                width: 25em;
                max-width: 25em;
                min-width: 25em;
            }

            .addpageobjects .datecandidat .numesiinittata {
                display: flex;
                flex-direction: row;
            }

            .addpageobjects .datecandidat .numesiinittata .nume {
                margin-bottom: 1em;
                width: 19em;
            }
            .addpageobjects .datecandidat .numesiinittata .inittata {
                margin-bottom: 1em;
                margin-left: 1em;
                width: 5em;
            }
            .addpageobjects .datecandidat .prenume {
                margin-bottom: 1em;
            }
            .addpageobjects .datecandidat .cnp {
                margin-bottom: 1em;
            }
            .addpageobjects .datecandidat .datanastere {
                margin-bottom: 1em;
            }
            .addpageobjects .datecandidat .liceu {
                margin-bottom: 1em;
            }
            .addpageobjects .datecandidat .medii {
                display: flex;
                flex-direction: row;
            }
            .addpageobjects .datecandidat .medii .medieliceu{
                width: 12em;
            }
            .addpageobjects .datecandidat .medii .mediebac {
                width: 12em;
                margin-left: 1em;
            }
            
            .addpageobjects .optiunicandidat {
                width: 25em;
                max-width: 25em;
            }

            .addpageobjects .optiunicandidat .universitate {
                margin-bottom: 1em;
            }
            .addpageobjects .optiunicandidat .facultate {
                margin-bottom: 1em;
            }
            .addpageobjects .optiunicandidat .domeniu {
                margin-bottom: 1em;
            }
            .addpageobjects .optiunicandidat .specializare {
                margin-bottom: 1em;
            }
            .addpageobjects .optiunicandidat .bugettaxa {
                margin-bottom: 1em;
            }
            .addpageobjects .optiunicandidat .addoption {
                margin-top: 3.25em;
                display: flex;
                justify-content: center;
            }
            
            .addpageobjects .optionstable {
                border: 1px solid #212529;
                border-radius: 0.5em;
                margin-right: 1em;
                margin-top: 1em;
                width: 70em;
                height: 34em;
                overflow-y: auto;
            }

            .submitbutton {
                margin-top: 3em;
                margin-bottom: 1em;
                width: 100%;
                display: flex;
                justify-content: center;
            }
            .submitbutton [type="submit"]{
                padding-left: 2em;
                padding-right: 2em;
            }
        </style>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script>
            function numeFieldKeyPressed(){
                var numeField = document.getElementById("nume").value;

                if (event.charCode >= 65 && event.charCode <= 90){
                    // A-Z
                    return true;
                }
                else if (event.charCode >= 95 && event.charCode <= 122){
                    // a-z
                    return true;
                }
                else if (event.charCode == 32 || event.charCode == 45){
                    // space ( ) or dash (-)
                    return true;
                }
                return false;
            }

            function initTataFieldKeyPressed(){
                var initTataField = document.getElementById("inittata").value;

                if (event.charCode >= 65 && event.charCode <= 90){
                    // A-Z
                    return true;
                }
                else if (event.charCode >= 95 && event.charCode <= 122){
                    // a-z
                    return true;
                }
                
                return false;
            }

            function prenumeFieldKeyPressed(){
                var prenumeField = document.getElementById("prenume").value;

                if (event.charCode >= 65 && event.charCode <= 90){
                    // A-Z
                    return true;
                }
                else if (event.charCode >= 95 && event.charCode <= 122){
                    // a-z
                    return true;
                }
                else if (event.charCode == 32 || event.charCode == 45){
                    // space ( ) or dash (-)
                    return true;
                }
                return false;
            }

            function cnpFieldKeyPressed(){
                var cnpField = document.getElementById("cnp").value;
                
                if (event.charCode >= 48 && event.charCode <= 57){
                    // 0-9
                    return true;
                }
                return false;
            }

            function liceuAbsolvitFieldKeyPressed(){
                var liceuAbsolvitField = document.getElementById("liceuabsolvit").value;

                if (event.charCode >= 48 && event.charCode <= 57){
                    // 0-9
                    return true;
                }

                if (event.charCode >= 65 && event.charCode <= 90){
                    // A-Z
                    return true;
                }
                else if (event.charCode >= 95 && event.charCode <= 122){
                    // a-z
                    return true;
                }
                else if (event.charCode == 32 || event.charCode == 46){
                    // space ( ) or dot (.)
                    return true;
                }
                return false;
            }
            $(document).ready(function () {
                $("#universitatecombobox").change(function () {
                    var value = $(this).val();

                    $.ajax({
                        type: "post",
                        data: {selectedfacultate: value},
                        success: function(response){
                            $("#facultatecombobox").html(response);
                        }
                    });
                });

                $("#facultatecombobox").change(function () {
                    var value = $(this).val();

                    $.ajax({
                        type: "post",
                        data: {selecteddomeniu: value},
                        success: function(response){
                            $("#domeniucombobox").html(response);
                        }
                    });
                });

                $("#domeniucombobox").change(function () {
                    var value = $(this).val();

                    $.ajax({
                        type: "post",
                        data: {selectedspecializare: value},
                        success: function(response){
                            $("#specializarecombobox").html(response);
                        }
                    });
                });

                $("#specializarecombobox").change(function () {
                    var value = $(this).val();

                    $.ajax({
                        type: "post",
                        data: {selectedbugettaxa: value},
                        success: function(response){
                            $("#bugettaxacombobox").html(response);
                        }
                    });
                });

                rowCount = 0;
                $("#addoption").click(function () {
                    var ok = true;

                    let selectedUniversitate = $("#universitatecombobox").val();
                    let selectedFacultate = $("#facultatecombobox").val();
                    let selectedDomeniu = $("#domeniucombobox").val();
                    let selectedSpecializare = $("#specializarecombobox").val();
                    let selectedBugetTaxa = $("#bugettaxacombobox").val();
                    
                    if (selectedUniversitate == "Selectati o universitate") {
                        ok = false;
                    }
                    else if (selectedFacultate == "Selectati o facultate") {
                        ok = false;
                    }
                    else if (selectedDomeniu == "Selectati un domeniu") {
                        ok = false;
                    }
                    else if (selectedSpecializare == "Selectati o specializare") {
                        ok = false;
                    }
                    else if (selectedBugetTaxa == "Selectati o forma de invatamant") {
                        ok = false;
                    }

                    if (!ok) {
                        return;
                    }
                    
                    if (rowCount > 0)
                    {
                        $('#optionstable tr').each(function() {
                            let universitate = $(this).find('td:eq(1)').html();
                            let facultate = $(this).find('td:eq(2)').html();
                            let domeniu = $(this).find('td:eq(3)').html();
                            let specializare = $(this).find('td:eq(4)').html();
                            let bugetTaxa = $(this).find('td:eq(5)').html();
                            
                            if (selectedUniversitate === universitate &&
                                selectedFacultate === facultate &&
                                selectedDomeniu === domeniu &&
                                selectedSpecializare === specializare &&
                                selectedBugetTaxa === bugetTaxa) {
                                    alert("Ati adaugat deja aceasta optiune.");
                                    ok = false;
                            }
                        });
                    }

                    if (!ok) {
                        return;
                    }

                    rowCount ++;
                    var row;
                    row = "<tr>";

                    row += "<td><b>";
                    row += rowCount;
                    row += "</td></b>";

                    row += "<td>";
                    row += $("#universitatecombobox").val();
                    row += "</td>";
                    
                    row += "<td>";
                    row += $("#facultatecombobox").val();
                    row += "</td>";
                    
                    row += "<td>";
                    row += $("#domeniucombobox").val();
                    row += "</td>";
                    
                    row += "<td>";
                    row += $("#specializarecombobox").val();
                    row += "</td>";

                    row += "<td>";
                    row += $("#bugettaxacombobox").val();
                    row += "</td>";

                    row += "<td>";
                    row += "<button type=\"button\" id=\"deleteoption\" class=\"btn btn-danger\">STERGE</button>";
                    row += "</td>";

                    row += "</tr>";
                    
                    $("#optionstable > tbody").append(row);
                });

                $(document).on("click","#optionstable tbody tr td button.btn", function() {
                    var index = $(this).parent().parent().index();                              
                    $("table tr:eq(" + (index + 1)+")").remove();
                    $('#optionstable tr').each(function() {
                        let col = $(this).find('td:eq(0)');
                        if (col.html() > index) {
                            col.html(++index);
                            rowCount = index;
                        }
                    });
                });

                $("#submit").click(function (event) {
                    var nume = $("#nume").val();
                    var initTata = $("#inittata").val();
                    var prenume = $("#prenume").val();
                    var cnp = $("#cnp").val();
                    var dataNastere = [
                        new Date($('#datanastere').val()).getFullYear(), 
                        new Date($('#datanastere').val()).getMonth() + 1, 
                        new Date($('#datanastere').val()).getDate()
                        ].join("-");
                    var liceuAbsolvit = $("#liceuabsolvit").val();
                    var medieLiceu = $("#medieliceu").val();
                    var medieBac = $("#mediebac").val();
                    var bugetTaxa = [];
                    var specializare = [];
                    
                    var index = 0;
                    $('#optionstable tr').each(function() {
                        if (index != 0) {
                            let sp = $(this).find('td:eq(4)');
                            let bt = $(this).find('td:eq(5)');
                            bugetTaxa.push(bt.html());
                            specializare.push(sp.html());
                        }
                        index++;
                    });

                    tempDataNastere = new Date($('#datanastere').val());
                    if (nume == "" || nume.length < 3
                    || initTata == ""
                    || prenume == "" || prenume.length < 3 
                    || cnp == "" || cnp.length != 13
                    || liceuAbsolvit == "" || liceuAbsolvit.length < 10
                    || tempDataNastere == "Invalid Date" || (tempDataNastere > new Date()) || (tempDataNastere < new Date("Jan 01 1900"))) {
                        return;
                    }
                    
                    if (index == 1){
                        event.preventDefault();
                        alert("Trebuie sa adaugati cel putin o optiune.");
                        return;
                    }

                    var jsonStringBugetTaxa = JSON.stringify(bugetTaxa);
                    var jsonStringSpecializare = JSON.stringify(specializare);

                    $.ajax({
                        type: "post",
                        data: {
                            formsubmit: "ok",
                            checkcnpforduplicates: cnp,
                            nume: nume,
                            inittata: initTata,
                            prenume: prenume,
                            cnp: cnp,
                            datanastere: dataNastere,
                            liceuabsolvit: liceuAbsolvit,
                            medieliceu: medieLiceu,
                            mediebac: medieBac,
                            bugettaxa: jsonStringBugetTaxa,
                            specializare: jsonStringSpecializare
                        },
                        success: function(response){
                            if (response == 0) {
                                alert("Candidat adaugat cu succes!");
                                window.location.reload();
                            } else {
                                alert("Un alt candidat cu acelasi CNP a fost deja adaugat.");
                            }
                        },
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
                <button class="btn btn-dark" type="submit" name="add_submit">ADAUGA</button>

                <!-- BUTON ACTUALIZEAZA -->
                <button class="btn btn-outline-dark" type="submit" name="update_submit">ACTUALIZEAZA</button>

                <!-- BUTON REZULTATE -->
                <button class="btn btn-outline-dark" type="submit" name="results_submit">REZULTATE</button>
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
        <!-- ADD FORM -->
        <form action="" method="post" id="addForm">
            <div class="addpageobjects">
                <fieldset class="fieldsetborder">
                <legend class="fieldsettext">Date candidat</legend>
                    <!-- DATE CANDIDAT -->
                    <div class="datecandidat">
                        <div class="numesiinittata">
                            <!-- NUME -->
                            <div class="nume">
                                <label for="nume">Nume</label>
                                <input type="text" id="nume" name="nume" placeholder="Popescu" class="form-control" minlength="3" maxlength="20" onkeypress="return numeFieldKeyPressed()" required>
                            </div>
                            <!-- INITIALA TATA -->
                            <div class="inittata">
                                <label for="inittata">Initiala tata</label>
                                <input type="text" id="inittata" name="inittata" placeholder="M" class="form-control" minlength="1" maxlength="1" onkeypress="return initTataFieldKeyPressed()" required>
                            </div>
                        </div>
                        <!-- PRENUME -->
                        <div class="prenume">
                            <label for="prenume" >Prenume</label>
                            <input type="text" id="prenume" name="prenume" placeholder="Ion" class="form-control" minlength="3" maxlength="20" onkeypress="return prenumeFieldKeyPressed()" required>
                        </div>
                        <!-- CNP -->
                        <div class="cnp">
                            <label for="cnp" >Cod Numeric Personal (CNP)</label>
                            <input type="text" id="cnp" name="cnp" placeholder="1990101123456" class="form-control" minlength="13" maxlength="13" onkeypress="return cnpFieldKeyPressed()" required>
                        </div>
                        <!-- DATA NASTERE -->
                        <div class="datanastere">
                            <label for="datanastere">Data nastere</label>
                            <input type="date" id="datanastere" name="datanastere" class="form-control" min="1900-01-01" max="<?php echo date("Y-m-d"); ?>" required>
                        </div>
                        <!-- LICEU ABSOLVIT -->
                        <div class="liceu">
                            <label for="liceuabsolvit">Liceu absolvit</label>
                            <input type="text" id="liceuabsolvit" name="liceuabsolvit" class="form-control" list="licee" placeholder="Selectati liceul absolvit" minlength="10" maxlength="35" onkeypress="return liceuAbsolvitFieldKeyPressed()" required>
                            <datalist id="licee">
                                <?php
                                    $licee = GetLiceu();
                                    for ($i = 0; $i < count($licee); $i++)
                                    {
                                ?>
                                <option><?php echo $licee[$i]; ?></option>
                                <?php
                                    }
                                ?>
                            </datalist>
                        </div>
                        <!-- MEDII -->
                        <div class="medii">
                            <!-- MEDIE LICEU -->
                            <div class="medieliceu">
                                <label for="medieliceu" >Medie liceu</label>
                                <input type="number" id="medieliceu" name="medieliceu" class="form-control" min="5" max="10" step="0.01" value="5" required>
                            </div>
                            <!-- MEDIE BACALAUREAT -->
                            <div class="mediebac">
                                <label for="mediebac" >Medie bacalaureat</label>
                                <input type="number" id="mediebac" name="mediebac" class="form-control" min="5" max="10" step="0.01" value="5" required>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="fieldsetborder">
                <legend class="fieldsettext">Optiuni candidat</legend>
                    <!-- OPTIUNE CANDIDAT -->
                    <div class="optiunicandidat">
                        <!-- UNIVERSITATE -->
                        <div class="universitate">
                            <label for="universitatecombobox">Universitate</label>
                            <select id="universitatecombobox" name="universitatecombobox" class="form-control">
                                <option selected>Selectati o universitate</option>
                                <?php
                                    $universitati = GetUniversitate();
                                    for ($i = 0; $i < count($universitati); $i++)
                                    {
                                ?>
                                <option><?php echo $universitati[$i]; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <!-- FACULTATE -->
                        <div class="facultate">
                            <label for="facultatecombobox">Facultate</label>
                            <select id="facultatecombobox" name="facultatecombobox" class="form-control">
                                <option selected>Selectati o facultate</option>
                            </select>
                        </div>
                        <!-- DOMENIU -->
                        <div class="domeniu">
                            <label for="domeniucombobox">Domeniu</label>
                            <select id="domeniucombobox" name="domeniucombobox" class="form-control">
                                <option selected>Selectati un domeniu</option>
                            </select>
                        </div>
                        <!-- SPECIALIZARE -->
                        <div class="specializare">
                            <label for="specializarecombobox">Specializare</label>
                            <select id="specializarecombobox" name="specializarecombobox" class="form-control">
                                <option selected>Selectati o specializare</option>
                            </select>
                        </div>
                        <!-- FORMA DE INVATAMANT -->
                        <div class="bugettaxa">
                            <label for="bugettaxacombobox">Forma de invatamant</label>
                            <select id="bugettaxacombobox" name="bugettaxacombobox" class="form-control">
                                <option selected>Selectati o forma de invatamant</option>
                            </select>
                        </div>
                        <!-- ADD BUTTON -->
                        <div class="addoption">
                            <button type="button" id="addoption" name="addoption" class="btn btn-success">ADAUGA</button>
                        </div>
                    </div>
                </fieldset>
                <!-- OPTIONS TABLE -->
                <div class="optionstable">
                    <table class="table" name="optionstable" id="optionstable">
                        <!-- TABLE HEADER -->
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">UNIVERSITATE</th>
                                <th scope="col">FACULTATE</th>
                                <th scope="col">DOMENIU</th>
                                <th scope="col">SPECIALIZARE</th>
                                <th scope="col">FORMA DE INVATAMANT</th>       
                                <th scope="col">ACTIUNE</th>
                            </tr>
                        </thead>

                        <!-- TABLE BODY -->
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div> 
            <div class="submitbutton">
                <button type="submit" id="submit" name="inscrie" class="btn btn-primary">INSCRIE</button>
            </div>
        </form>
    </body>
</html> 
