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
    else if (isset($_GET["results_submit"]))
    {
        header("Location: results_page.php");
    }
    else if (isset($_GET["logs_submit"]))
    {
        header("Location: log_page.php");
    }

    // AJAX HANDLERS
    if (isset($_POST["cnp_pentru_nume"]))
    {
        echo GetNumeCandidatByCNP($_POST["cnp_pentru_nume"]);
        exit;
    }
    if (isset($_POST["cnp_pentru_inittata"]))
    {
        echo GetInitialaTataCandidatByCNP($_POST["cnp_pentru_inittata"]);
        exit;
    }
    if (isset($_POST["cnp_pentru_prenume"]))
    {
        echo GetPrenumeCandidatByCNP($_POST["cnp_pentru_prenume"]);
        exit;
    }
    if (isset($_POST["cnp"]))
    {
        echo $_POST["cnp"];
        exit;
    }
    if (isset($_POST["cnp_pentru_datanastere"]))
    {
        echo GetDataNastereCandidatByCNP($_POST["cnp_pentru_datanastere"]);
        exit;
    }
    if (isset($_POST["cnp_pentru_liceuabsolvit"]))
    {
        echo GetDenumireLiceuCandidatByCNP($_POST["cnp_pentru_liceuabsolvit"]);
        exit;
    }
    if (isset($_POST["cnp_pentru_medieliceu"]))
    {
        echo GetMedieLiceuCandidatByCNP($_POST["cnp_pentru_medieliceu"]);
        exit;
    }
    if (isset($_POST["cnp_pentru_mediebac"]))
    {
        echo GetMedieBacCandidatByCNP($_POST["cnp_pentru_mediebac"]);
        exit;
    }
    if (isset($_POST["cnp_pentru_examstable"]))
    {
        $denumireExamen = GetDenumireExamenCandidatByCNP($_POST["cnp_pentru_examstable"]);
        $locatieExamen = GetLocatieExamenCandidatByCNP($_POST["cnp_pentru_examstable"]);
        $dataExamen = GetDataExamenCandidatByCNP($_POST["cnp_pentru_examstable"]);
        
        $row = "";
        for ($i = 0; $i < count($denumireExamen); $i++)
        {
            $nota = GetNotaCandidat($_POST["cnp_pentru_examstable"], $denumireExamen[$i]);

            $row = $row."<tr>";
            
            $row = $row."<td><b>";
            $row  = $row."".($i + 1);
            $row = $row."</td></b>";

            $row = $row."<td>";
            $row = $row.$denumireExamen[$i];
            $row = $row."</td>";
        
            $row = $row."<td>";
            $row = $row.$locatieExamen[$i];
            $row = $row."</td>";
        
            $row = $row."<td>";
            $row = $row.$dataExamen [$i];
            $row = $row."</td>";
        
            $row = $row."<td>";
            $row = $row."<input type='number' id='nota' name='nota' class='form-control' min='0' max='10' step='0.01' ";
            $row = $row."value='".$nota."'";
            $row = $row.">";
            $row = $row."</td>";

            $row = $row."</tr>";
        }
        
        echo $row;
        exit;
    }

    if (isset($_POST["cnp_pentru_delete"]))
    {
        $cod_c = GetCodCandidatByCNP($_POST["cnp_pentru_delete"]);
        DeleteRezultateCandidatByCodCandidat($cod_c);
        DeleteOptiuniCandidatByCodCandidat($cod_c);
        DeleteCandidatByCodCandidat($cod_c);

        // Logging the operation
        date_default_timezone_set('Europe/Bucharest');
        $cod_u = GetCodUserByUsername($_SESSION['user']);
        $time = date('Y-m-d H:i:s');
        $action = "DELETE";
        $query = "DELETE FROM candidat WHERE candidat.CNP = $_POST[cnp_pentru_delete]";
        AddLog($cod_u, $time, $action, $query);
        exit;
    }

    // Submitting the form
    if (isset($_POST["formsubmit"])){
        // Checking for cnp duplicates
        // $duplicates = -1;
        // if (isset($_POST["checkcnpforduplicates"])){
        //     $duplicates = GetCountCNPByCNP($_POST["checkcnpforduplicates"]);
        // }
        // if ($duplicates > 1) {
        //     echo $duplicates;
        //     exit;
        // } else {
        //     echo 0;
        // }

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
        else if (!isset($_POST["cnpcandidat"]))
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

        $nume = $_POST["nume"];
        $init_tata = $_POST["inittata"];
        $prenume = $_POST["prenume"];
        $cnp = $_POST["cnpcandidat"];
        $data_n = $_POST["datanastere"];
        $den_liceu = $_POST["liceuabsolvit"];
        $medie_liceu = $_POST["medieliceu"];
        $medie_bac = $_POST["mediebac"];

        if ($ready){
            // Updating info candidat
            UpdateCandidat($nume, $init_tata, $prenume, $cnp, $data_n, $den_liceu, $medie_liceu, $medie_bac);

            // Logging the operation
            date_default_timezone_set('Europe/Bucharest');
            $cod_u = GetCodUserByUsername($_SESSION['user']);
            $time = date('Y-m-d H:i:s');
            $action = "UPDATE";
            $query = "UPDATE candidat SET nume = '$nume', init_tata = '$init_tata', prenume = '$prenume', cnp = '$cnp', data_n = '$data_n', den_liceu = $den_liceu, medie_liceu = $medie_liceu, medie_bac = $medie_bac";
            AddLog($cod_u, $time, $action, $query);

            // Update nota candidat
            if (isset($_POST["numeexamen"]) && isset($_POST["notaexamen"]))
            {
                $den_e = $_POST["numeexamen"];
                $nota = $_POST["notaexamen"];
                
                for ($i = 0; $i < count($den_e); $i++) 
                {
                    UpdateNota($cnp, $den_e[$i], $nota[$i]);

                    // Logging the operation
                    date_default_timezone_set('Europe/Bucharest');
                    $cod_u = GetCodUserByUsername($_SESSION['user']);
                    $time = date('Y-m-d H:i:s');
                    $action = "UPDATE";
                    $query = "UPDATE rezultat SET nota = $nota[$i] - candidat.CNP = $cnp";
                    AddLog($cod_u, $time, $action, $query);
                }
            }
        }
        echo 0;
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
        
        <title>Actualizeaza | ADMITERE LA FACULTATE</title>

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

            /* UPDATE CONTROLS */
            .tableandinfo {
                display: flex;
                flex-direction: row;
            }
            .candidatitable {
                border: solid 1px #212529;
                border-radius: 0.5em;
                margin-left: 1em;
                margin-top: 1em;
                margin-bottom: 1em;
                margin-right: 1em;
                width: 78em;
                min-width: 10em;
                height: 42.25em;
                overflow-y: auto;
            }
            .candidatitable tr:hover {
                background-color: #DCDCDC;
            }

            .fieldsetborder {
                margin-top: 4px;
                margin-right: 1em;
                margin-bottom: 1em;
                border: solid 1px #DDD;
                border-radius: 0.5em;
                padding: 0em 1em 1em 1em;
                height: 18.5em;
                
            }   
            .fieldsettext {
                width: auto;
                border: none;
                font-size: 1em;
                font-weight: bold;
            }

            .updatedata {
                display: flex;
                flex-direction: row;
            }

            .updatedata .datecandidat {
                width: auto;
            }

            .updatedata .datecandidat .numecomplet {
                display: flex;
                flex-direction: row;
            }

            .updatedata .datecandidat .numecomplet .nume {
                margin-bottom: 1em;
                width: 20em;
            }
            .updatedata .datecandidat .numecomplet .inittata {
                margin-bottom: 1em;
                margin-left: 1em;
                width: 5em;
            }
            .updatedata .datecandidat .numecomplet .prenume {
                width: 20em;
                margin-bottom: 1em;
                margin-left: 1em;
            }

            .updatedata .datecandidat .cnpsidatanastere {
                display: flex;
                flex-direction: row;
            }
            .updatedata .datecandidat .cnpsidatanastere .cnp {
                margin-bottom: 1em;
                width: 20em;            
            }
            .updatedata .datecandidat .cnpsidatanastere .datanastere {
                margin-bottom: 1em;
                margin-left: 1em;
                width: 12.5em;            
            }

            .updatedata .datecandidat .liceusimedie {
                display: flex;
                flex-direction: row;
            }
            .updatedata .datecandidat .liceusimedie .liceu {
                width: 20em;
            }
            .updatedata .datecandidat .liceusimedie .medieliceu{
                width: 12.5em;
                margin-left: 1em;
            }
            .updatedata .datecandidat .liceusimedie .mediebac {
                width: 12.5em;
                margin-left: 1em;
            }

            .examstable {
                margin-top: 1em;
                margin-bottom: 1em;
                margin-right: 1em;
                border: solid 1px #212529;
                border-radius: 0.5em;
                min-width: 39em;
                height: 18em;
                overflow-y: auto;
            }
            .updatedata .examstable tr:hover {
                background-color: #DCDCDC;
            }

            .deleteandsubmit {
                display: flex;
                justify-content: space-between;
            }

            .deleteandsubmit .submitbutton {
                margin-top: 2em;
            }
            .deleteandsubmit .deletebutton {
                margin-right: 1em;
                margin-top: 2em;
            }

            tr.highlighted td {
                background: #8FD3FE;
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

                if (liceuAbsolvitField.length == 35){
                    return false;
                }

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
                var cnp;
                $("#candidatitable tbody tr").click(function() {
                    cnp = $(this).find('td:eq(2)').html();

                    $('#candidatitable tr').removeClass('highlighted');
                    $(this).toggleClass('highlighted');

                    // Candidate data
                    $.ajax({
                    type: "post",
                        data: {cnp_pentru_nume: cnp},
                        success: function(response){
                            $("#nume").val(response);
                        }
                    });
                    
                    $.ajax({
                        type: "post",
                        data: {cnp_pentru_inittata: cnp},
                        success: function(response){
                            $("#inittata").val(response);
                        }
                    });

                    $.ajax({
                        type: "post",
                        data: {cnp_pentru_prenume: cnp},
                        success: function(response){
                            $("#prenume").val(response);
                        }
                    });

                    $.ajax({
                        type: "post",
                        data: {cnp: cnp},
                        success: function(response){
                            $("#cnp").val(response);
                        }
                    });

                    $.ajax({
                        type: "post",
                        data: {cnp_pentru_datanastere: cnp},
                        success: function(response){
                            $("#datanastere").val(response);
                        }
                    });

                    $.ajax({
                        type: "post",
                        data: {cnp_pentru_liceuabsolvit: cnp},
                        success: function(response){
                            $("#liceuabsolvit").val(response);
                        }
                    });
                    
                    $.ajax({
                        type: "post",
                        data: {cnp_pentru_medieliceu: cnp},
                        success: function(response){
                            $("#medieliceu").val(response);
                        }
                    });

                    $.ajax({
                        type: "post",
                        data: {cnp_pentru_mediebac: cnp},
                        success: function(response){
                            $("#mediebac").val(response);
                        }
                    });

                    // Exams table 
                    $.ajax({
                    type: "post",
                    data: {cnp_pentru_examstable: cnp},
                    success: function(response){
                        $("#examstable tbody tr").each(function(){
                            this.parentNode.removeChild(this); 
                        });
                        $("#examstable > tbody:last-child").append(response);
                    }
                    });
                });

                $("#delete").click(function() {
                    if (cnp == undefined){
                        alert("Trebuie sa selectati un candidat.");
                        return;
                    }

                    $.ajax({
                        type: "post",
                        data: {cnp_pentru_delete: cnp},
                        success: function(response){
                            alert("Candidat sters cu succes!");
                            location.reload();
                        }
                    });
                });

                $("#update").click(function() {
                    event.preventDefault();

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

                    var numeExamen = [];
                    var notaExamen = [];
                    var index = 0;
                    $('#examstable tr').each(function() {
                        if (index != 0) {
                            let examen = $(this).find('td:eq(1)');
                            let nota = $(this).find('td:eq(4) input[type=\'number\']');
                            numeExamen.push(examen.html());
                            notaExamen.push(nota.val());
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

                    $.ajax({
                        type: "post",
                        data: {
                            formsubmit: "ok",
                            checkcnpforduplicates: cnp,
                            nume: nume,
                            inittata: initTata,
                            prenume: prenume,
                            cnpcandidat: cnp,
                            datanastere: dataNastere,
                            liceuabsolvit: liceuAbsolvit,
                            medieliceu: medieLiceu,
                            mediebac: medieBac,
                            numeexamen: numeExamen,
                            notaexamen: notaExamen
                        },
                        success: function(response){
                            if (response == 0) {
                                alert("Datele candidatului au fost actualizate cu succes!");
                                window.location.reload();
                            } 
                            // else {
                            //     alert("Un alt candidat cu acelasi CNP a fost deja adaugat.");
                            // }
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
                <button class="btn btn-outline-dark" type="submit" name="add_submit">ADAUGA</button>

                <!-- BUTON ACTUALIZEAZA -->
                <button class="btn btn-dark" type="submit" name="update_submit">ACTUALIZEAZA</button>

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
        <form action="" method="get">
            <div class="tableandinfo">
                <!-- CANDIDATI TABLE -->
                <div class="candidatitable">
                    <table class="table" id="candidatitable">
                        <!-- TABLE HEADER -->
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">NUME</th>
                                <th scope="col">CNP</th>
                            </tr>
                        </thead>
                        <!-- TABLE BODY -->
                        <tbody>
                            <?php 
                                $nume = GetNumeCandidati();
                                $cnp = GetCNPCandidati();

                                for ($i = 0; $i < count($nume); $i++)
                                {
                            ?>
                            <tr class="datarow">
                                <td><b><?php echo $i+1; ?></b></td>
                                <td><?php echo $nume[$i]; ?></td>
                                <td><?php echo $cnp[$i]; ?></td>
                            </tr>
                            <?php 
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- UPDATE DATA -->
                <div class="updatedata">
                    <div class="dateandexams">
                        <!-- DATE CANDIDAT -->
                        <fieldset class="fieldsetborder">
                        <legend class="fieldsettext">Date candidat</legend>
                        <div class="datecandidat">
                            <div class="numecomplet">
                                <!-- NUME -->
                                <div class="nume">
                                    <label for="nume">Nume</label>
                                    <input type="text" id="nume" name="nume" placeholder="Popescu" class="form-control" minlength="3" maxlength="20"  onkeypress="return numeFieldKeyPressed()" required <?php if ($_SESSION['role'] == "MANAGER") echo "disabled"; ?>>
                                </div>
                                <!-- INITIALA TATA -->
                                <div class="inittata">
                                    <label for="inittata">Initiala tata</label>
                                    <input type="text" id="inittata" name="inittata" placeholder="M" class="form-control" minlength="1" maxlength="1" onkeypress="return initTataFieldKeyPressed()" required <?php if ($_SESSION['role'] == "MANAGER") echo "disabled"; ?>>
                                </div>
                                <!-- PRENUME -->
                                <div class="prenume">
                                    <label for="prenume" >Prenume</label>
                                    <input type="text" id="prenume" name="prenume" placeholder="Ion" class="form-control" minlength="3" maxlength="20" onkeypress="return prenumeFieldKeyPressed()" required <?php if ($_SESSION['role'] == "MANAGER") echo "disabled"; ?>>
                                </div>
                            </div>
                            <div class="cnpsidatanastere">
                                <!-- CNP -->
                                <div class="cnp">
                                    <label for="cnp" >Cod Numeric Personal (CNP)</label>
                                    <input type="text" id="cnp" name="cnp" placeholder="1990101123456" class="form-control" minlength="13" maxlength="13" onkeypress="return cnpFieldKeyPressed()" required <?php if ($_SESSION['role'] == "MANAGER") echo "disabled"; ?>>
                                </div>
                                <!-- DATA NASTERE -->
                                <div class="datanastere">
                                    <label for="datanastere">Data nastere</label>
                                    <input type="date" id="datanastere" name="datanastere" class="form-control" min="1900-01-01" max="<?php echo date("Y-m-d"); ?>" required <?php if ($_SESSION['role'] == "MANAGER") echo "disabled"; ?>>
                                </div>
                            </div>
                            <div class="liceusimedie">
                                <!-- LICEU ABSOLVIT -->
                                <div class="liceu">
                                    <label for="liceuabsolvit">Liceu absolvit</label>
                                    <input type="text" id="liceuabsolvit" name="liceuabsolvit" class="form-control" minlength="10" maxlength="35" list="licee" placeholder="Selectati liceul absolvit" onkeypress="return liceuAbsolvitFieldKeyPressed()" required <?php if ($_SESSION['role'] == "MANAGER") echo "disabled"; ?>>
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
                                <!-- MEDIE LICEU -->
                                <div class="medieliceu">
                                    <label for="medieliceu" >Medie liceu</label>
                                    <input type="number" id="medieliceu" name="medieliceu" class="form-control" min="5" max="10" step="0.01" required <?php if ($_SESSION['role'] == "MANAGER") echo "disabled"; ?>>
                                </div>
                                <!-- MEDIE BACALAUREAT -->
                                <div class="mediebac">
                                    <label for="mediebac" >Medie bacalaureat</label>
                                    <input type="number" id="mediebac" name="mediebac" class="form-control" min="5" max="10" step="0.01" required <?php if ($_SESSION['role'] == "MANAGER") echo "disabled"; ?>>
                                </div>
                            </div>
                        </div>
                        </fieldset>
                        <!-- EXAMS TABLE -->
                        <div class="exams">
                            <div class="examstable">
                                <table class="table" id="examstable">
                                    <!-- TABLE HEADER -->
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">EXAMEN</th>
                                            <th scope="col">LOCATIE</th>
                                            <th scope="col">DATA</th>
                                            <th scope="col">NOTA</th>
                                        </tr>
                                    </thead>
                                    <!-- TABLE BODY -->
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="deleteandsubmit">
                            <div class="submitbutton">
                                <button type="submit" id="update" name="update" class="btn btn-primary">ACTUALIZEAZA</button>
                            </div>
                            <div class="deletebutton">
                                <button type="button" id="delete" name="delete" class="btn btn-danger" <?php if ($_SESSION['role'] == "MANAGER") echo "disabled"; ?>>STERGE</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </body>
</html> 
