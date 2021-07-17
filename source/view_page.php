<?php
    session_start();
    if (!isset($_SESSION['user']) || !isset($_SESSION['role']))
    {
        header("Location: login_page.php");
    }

    if (isset($_GET["logout"]))
    {
        session_destroy();
        header("Location: login_page.php");
    }

    require 'Web/assets/MySQLConnection.php';

    // Tab buttons form
    if (isset($_GET["add_submit"])) 
    {
        header("Location: add_page.php");
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

    if (isset($_GET["searchforcandidat"]))
    {
        if (isset($_GET["liceucombobox"])) 
        {
            $nume = GetNumeCandidatByDenumireLiceu($_GET["searchforcandidat"], $_GET["liceucombobox"]);
            $liceu = GetLiceuCandidatByDenumireLiceu($_GET["searchforcandidat"], $_GET["liceucombobox"]);
            $medie_liceu = GetMedieLiceuCandidatByDenumireLiceu($_GET["searchforcandidat"], $_GET["liceucombobox"]);
            $medie_bac = GetMedieBacCandidatByDenumireLiceu($_GET["searchforcandidat"], $_GET["liceucombobox"]);

            for ($i = 0; $i < count($nume); $i++)
            {
                echo "<tr>";

                echo "<td><b>".($i + 1)."<b></td>";
                echo "<td>".$nume[$i]."</td>";
                echo "<td>".$liceu[$i]."</td>";
                echo "<td>".$medie_liceu[$i]."</td>";
                echo "<td>".$medie_bac[$i]."</td>";

                echo "</tr>";
            }

            // Logging the operation
            date_default_timezone_set('Europe/Bucharest');
            $cod_u = GetCodUserByUsername($_SESSION['user']);
            $time = date('Y-m-d H:i:s');
            $action = "SELECT";
            $query = "SELECT nume, den_liceu, medie_liceu, medie_bac FROM candidat WHERE (nume LIKE '%$_GET[searchforcandidat]%' OR init_tata LIKE '%$_GET[searchforcandidat]%' OR prenume LIKE '%$_GET[searchforcandidat]%') AND den_liceu LIKE '%$_GET[liceucombobox]%'";
            AddLog($cod_u, $time, $action, $query);
        }
        exit;
    }
    if (isset($_GET["searchforuniversitate"]))
    {
        $den_u = GetDenumireUniversitate($_GET["searchforuniversitate"]);
        $adresa_u = GetAdresaUniversitate($_GET["searchforuniversitate"]);

        for ($i = 0; $i < count($den_u); $i++)
        {
            echo "<tr>";

            echo "<td><b>".($i + 1)."</b></td>";
            echo "<td>".$den_u[$i]."</td>";
            echo "<td>".$adresa_u[$i]."</td>";

            $rows .= "</tr>";
        }

        // Logging the operation
        date_default_timezone_set('Europe/Bucharest');
        $cod_u = GetCodUserByUsername($_SESSION['user']);
        $time = date('Y-m-d H:i:s');
        $action = "SELECT";
        $query = "SELECT den_u, adresa_u FROM universitate WHERE den_u LIKE '%$_GET[searchforuniversitate]%'";
        AddLog($cod_u, $time, $action, $query);

        exit;            
    }
    if (isset($_GET["searchforfacultate"]))
    {
        $den_f = GetDenumireFacultate($_GET["searchforfacultate"]);
        $den_u = GetUniversitateFacultate($_GET["searchforfacultate"]);
        $adresa_f = GetAdresaFacultate($_GET["searchforfacultate"]);
        
        for ($i = 0; $i < count($den_f); $i++)
        {
            echo "<tr>";

            echo "<td><b>".($i + 1)."</b></td>";
            echo "<td>".$den_f[$i]."</td>";
            echo "<td>".$den_u[$i]."</td>";
            echo "<td>".$adresa_f[$i]."</td>";
            
            $rows .= "</tr>";
        }

        // Logging the operation
        date_default_timezone_set('Europe/Bucharest');
        $cod_u = GetCodUserByUsername($_SESSION['user']);
        $time = date('Y-m-d H:i:s');
        $action = "SELECT";
        $query = "SELECT den_f, den_u, adresa_f FROM universitate, facultate WHERE universitate.cod_u = facultate.cod_u AND den_f LIKE '%$_GET[searchforfacultate]%'";
        AddLog($cod_u, $time, $action, $query);

        exit;
    }   
    if (isset($_GET["searchfordomeniu"]))
    {
        $den_d = GetDenumireDomeniu($_GET["searchfordomeniu"]);
        $facultate_d = GetFacultateDomeniu($_GET["searchfordomeniu"]);
        
        for ($i = 0; $i < count($den_d); $i++)
        {
            echo "<tr>";

            echo "<td><b>".($i + 1)."</b></td>";
            echo "<td>".$den_d[$i]."</td>";
            echo "<td>".$facultate_d[$i]."</td>";
            
            $rows .= "</tr>";
        }

        // Logging the operation
        date_default_timezone_set('Europe/Bucharest');
        $cod_u = GetCodUserByUsername($_SESSION['user']);
        $time = date('Y-m-d H:i:s');
        $action = "SELECT";
        $query = "SELECT den_d, den_f FROM facultate, domeniu WHERE facultate.cod_f = domeniu.cod_f AND den_d LIKE '%$_GET[searchfordomeniu]%'";
        AddLog($cod_u, $time, $action, $query);
        
        exit;
    }   
    if (isset($_GET["searchforspecializare"]))
    {
        $den_s = GetDenumireSpecializare($_GET["searchforspecializare"]);
        $den_d = GetDomeniuSpecializare($_GET["searchforspecializare"]);
        $durata_ani = GetDurataSpecializare($_GET["searchforspecializare"]);
        $regula_admitere = GetRegulaAdmitereSpecializare($_GET["searchforspecializare"]);
        $locuri_buget = GetLocuriBugetSpecializare($_GET["searchforspecializare"]);
        $locuri_taxa = GetLocuriTaxaSpecializare($_GET["searchforspecializare"]);                            
        
        for ($i = 0; $i < count($den_s); $i++)
        {
            echo "<tr>";

            echo "<td><b>".($i + 1)."</b></td>";
            echo "<td>".$den_s[$i]."</td>";
            echo "<td>".$den_d[$i]."</td>";
            echo "<td>".$durata_ani[$i]."</td>";
            echo "<td>".$regula_admitere[$i]."</td>";
            echo "<td>".$locuri_buget[$i]."</td>";
            echo "<td>".$locuri_taxa[$i]."</td>";
            
            $rows .= "</tr>";
        }

        // Logging the operation
        date_default_timezone_set('Europe/Bucharest');
        $cod_u = GetCodUserByUsername($_SESSION['user']);
        $time = date('Y-m-d H:i:s');
        $action = "SELECT";
        $query = "SELECT den_s, den_d, durata_ani, descriere FROM domeniu, specializare, regula_admitere WHERE domeniu.cod_d = specializare.cod_d AND specializare.cod_r = regula_admitere.cod_r AND den_s LIKE '%$_GET[searchforspecializare]%'";
        AddLog($cod_u, $time, $action, $query);
        
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
        
        <title>Vizualizeaza | ADMITERE LA FACULTATE</title>

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
            
            /* VIEW CONTROLS */
            .searchfilter {
                display: flex;
                flex-direction: row;
                margin-bottom: 1em;
                margin-top: 2em;
            }
            .searchfilter .searchfield {
                margin-left: 1em;
                width: 20em;
            }

            .searchfilter .combobox {
                margin-left: 1em;
                width: 20em;
            }

            .searchfilter .liceucombobox {
                margin-left: 1em;
                width: 20em;
            }

            .resultstable {
                border: 1px solid #212529;
                border-radius: 0.5em;
                margin-left: 1em;
                margin-right: 1em;
                margin-bottom: 1em;
                height: 39em;
                overflow-y: auto;
            }

            .resultslabel {
                margin-left: 1em;
                margin-right: 1em;
                margin-bottom: 1em;
            }
        </style>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script>
            $(document).ready(function () {
                // Preloading table header
                var header = "";
                header += "<th>";
                header += "#";
                header += "</th>";

                header += "<th>";
                header += "NUME";
                header += "</th>";
                
                header += "<th>";
                header += "LICEU ABSOLVIT";
                header += "</th>";
                
                header += "<th>";
                header += "MEDIE LICEU";
                header += "</th>";
                
                header += "<th>";
                header += "MEDIE BACALAUREAT";
                header += "</th>";

                header += "</tr>";

                $("#resultstable > thead").html(header);

                // Search field key pressed
                $("#searchfield").on('keypress',function(e) {
                    if(e.which == 13 && $(this).val() != "") {
                        // Preventing form submition by pressing ENTER
                        event.preventDefault();

                        var keyword = $(this).val();
                        var combobox = $("#combobox").val();

                        if (combobox == "Candidat") {
                            var liceu = $("#liceucombobox").val();

                            if (liceu == "Selectati un liceu") {
                                liceu = "";
                            }

                            if (keyword == "") {
                                $("#resultstable tbody tr").each(function(){
                                    this.parentNode.removeChild(this); 
                                });
                            } else {
                                $("#resultstable tbody tr").each(function(){
                                    this.parentNode.removeChild(this); 
                                });

                                $.ajax({
                                    type: "get",
                                    data: {
                                        searchforcandidat: keyword,
                                        liceucombobox: liceu
                                    },
                                    success: function(response){
                                        // Adding rows
                                        $("#resultstable > tbody:last-child").append(response);
                                        
                                        // Setting results found text
                                        if (response == ""){
                                            $("#resultslabel").html("Rezultate gasite: <b>0</b>");
                                        } else {
                                            $("#resultslabel").html("Rezultate gasite: <b>" + ($("table#resultstable tr:last").index() + 1) + "</b>");
                                        }
                                    }
                                });
                            }
                        } else if (combobox == "Universitate") {
                            if (keyword == "") {
                                $("#resultstable tbody tr").each(function(){
                                    this.parentNode.removeChild(this); 
                                });
                            } else {
                                $("#resultstable tbody tr").each(function(){
                                    this.parentNode.removeChild(this); 
                                });

                                $.ajax({
                                    type: "get",
                                    data: {searchforuniversitate: keyword},
                                    success: function(response){
                                        // Adding rows
                                        $("#resultstable > tbody:last-child").append(response);
                                        
                                        // Setting results found text
                                        if (response == ""){
                                            $("#resultslabel").html("Rezultate gasite: <b>0</b>");
                                        } else {
                                            $("#resultslabel").html("Rezultate gasite: <b>" + ($("table#resultstable tr:last").index() + 1) + "</b>");
                                        }
                                    }
                                });
                            }
                        } else if (combobox == "Facultate") {
                            if (keyword == "") {
                                $("#resultstable tbody tr").each(function(){
                                    this.parentNode.removeChild(this); 
                                });
                            } else {
                                $("#resultstable tbody tr").each(function(){
                                    this.parentNode.removeChild(this); 
                                });

                                $.ajax({
                                    type: "get",
                                    data: {searchforfacultate: keyword},
                                    success: function(response){
                                        // Adding rows
                                        $("#resultstable > tbody:last-child").append(response);
                                        
                                        // Setting results found text
                                        if (response == ""){
                                            $("#resultslabel").html("Rezultate gasite: <b>0</b>");
                                        } else {
                                            $("#resultslabel").html("Rezultate gasite: <b>" + ($("table#resultstable tr:last").index() + 1) + "</b>");
                                        }
                                    }
                                });
                            }
                        } else if (combobox == "Domeniu") {
                            if (keyword == "") {
                                $("#resultstable tbody tr").each(function(){
                                    this.parentNode.removeChild(this); 
                                });
                            } else {
                                $("#resultstable tbody tr").each(function(){
                                    this.parentNode.removeChild(this); 
                                });

                                $.ajax({
                                    type: "get",
                                    data: {searchfordomeniu: keyword},
                                    success: function(response){
                                        // Adding rows
                                        $("#resultstable > tbody:last-child").append(response);
                                        
                                        // Setting results found text
                                        if (response == ""){
                                            $("#resultslabel").html("Rezultate gasite: <b>0</b>");
                                        } else {
                                            $("#resultslabel").html("Rezultate gasite: <b>" + ($("table#resultstable tr:last").index() + 1) + "</b>");
                                        }
                                    }
                                });
                            }
                        } else if (combobox == "Specializare") {
                            if (keyword == "") {
                                $("#resultstable tbody tr").each(function(){
                                    this.parentNode.removeChild(this); 
                                });
                            } else {
                                $("#resultstable tbody tr").each(function(){
                                    this.parentNode.removeChild(this); 
                                });

                                $.ajax({
                                    type: "get",
                                    data: {searchforspecializare: keyword},
                                    success: function(response){
                                        // Adding rows
                                        $("#resultstable > tbody:last-child").append(response);
                                        
                                        // Setting results found text
                                        if (response == ""){
                                            $("#resultslabel").html("Rezultate gasite: <b>0</b>");
                                        } else {
                                            $("#resultslabel").html("Rezultate gasite: <b>" + ($("table#resultstable tr:last").index() + 1) + "</b>");
                                        }
                                    }
                                });
                            }
                        }
                    }
                });

                // Combobox item changed
                $("#combobox").change(function() {
                    var combobox = $(this).val();
                    var header = "";

                    // Clearing the table rows
                    $("#resultstable tbody tr").each(function(){
                        this.parentNode.removeChild(this); 
                    });

                    // Clearing the search field
                    $("#searchfield").val("");

                    // Clearing the results found label
                    $("#resultslabel").html("");

                    // Setting the table header
                    if (combobox == "Candidat") {
                        $("#liceucombobox").css("visibility", "visible");
                        header = "<tr>";

                        header += "<th>";
                        header += "#";
                        header += "</th>";

                        header += "<th>";
                        header += "NUME";
                        header += "</th>";
                        
                        header += "<th>";
                        header += "LICEU ABSOLVIT";
                        header += "</th>";
                        
                        header += "<th>";
                        header += "MEDIE LICEU";
                        header += "</th>";
                        
                        header += "<th>";
                        header += "MEDIE BACALAUREAT";
                        header += "</th>";

                        header += "</tr>";
                    } else if (combobox == "Universitate") {
                        $("#liceucombobox").css("visibility", "hidden");
                        header = "<tr>";

                        header += "<th>";
                        header += "#";
                        header += "</th>";

                        header += "<th>";
                        header += "DENUMIRE";
                        header += "</th>";
                        
                        header += "<th>";
                        header += "ADRESA";
                        header += "</th>";

                        header += "</tr>";   
                    } else if (combobox == "Facultate") {
                        $("#liceucombobox").css("visibility", "hidden");
                        header = "<tr>";

                        header += "<th>";
                        header += "#";
                        header += "</th>";

                        header += "<th>";
                        header += "DENUMIRE";
                        header += "</th>";

                        header += "<th>";
                        header += "UNIVERSITATE";
                        header += "</th>";
                        
                        
                        header += "<th>";
                        header += "ADRESA";
                        header += "</th>";

                        header += "</tr>";   
                    } else if (combobox == "Domeniu") {
                        $("#liceucombobox").css("visibility", "hidden");
                        header = "<tr>";

                        header += "<th>";
                        header += "#";
                        header += "</th>";

                        header += "<th>";
                        header += "DENUMIRE";
                        header += "</th>";
                        
                        header += "<th>";
                        header += "FACULTATE";
                        header += "</th>";

                        header += "</tr>";   
                    } else if (combobox == "Specializare") {
                        $("#liceucombobox").css("visibility", "hidden");
                        header = "<tr>";

                        header += "<th>";
                        header += "#";
                        header += "</th>";

                        header += "<th>";
                        header += "DENUMIRE";
                        header += "</th>";
                        
                        header += "<th>";
                        header += "DOMENIU";
                        header += "</th>";
                        

                        header += "<th>";
                        header += "DURATA (ani)";
                        header += "</th>";

                        header += "<th>";
                        header += "REGULA ADMITERE";
                        header += "</th>";

                        header += "<th>";
                        header += "LOCURI BUGET";
                        header += "</th>";

                        header += "<th>";
                        header += "LOCURI TAXA";
                        header += "</th>";

                        header += "</tr>";
                    }

                    // Setting the header 
                    $("#resultstable > thead").html(header);                            
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
                <button class="btn btn-dark" type="submit" name="view_submit">VIZUALIZEAZA</button>
                <?php 
                    if ($_SESSION["role"] == "ADMINISTRATOR" || $_SESSION["role"] == "MANAGER") 
                    {
                ?>
                <!-- BUTON ADAUGA -->
                <button class="btn btn-outline-dark" type="submit" name="add_submit">ADAUGA</button>

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
        <form action="" method="get">
            <div class="searchfilter">
                <div class="searchfield">
                    <!-- FIELD CAUTARE -->
                    <input class="form-control" type="text" name="searchfield" id="searchfield" placeholder="Cauta dupa nume..." required>
                </div>
                <!-- COMBOBOX -->
                <div class="combobox">
                    <select name="combobox" class="form-control" id="combobox">
                        <option>Candidat</option>
                        <option>Universitate</option>
                        <option>Facultate</option>
                        <option>Domeniu</option>
                        <option>Specializare</option>
                    </select>
                </div>
                <!-- LICEU ABSOLVIT -->
                <div class="liceucombobox">
                    <select name="liceucombobox" id="liceucombobox" class="form-control">
                        <option>Selectati un liceu</option>
                        <?php
                            $licee = GetLiceu();
                            for ($i = 0; $i < count($licee); $i++)
                            {
                        ?>
                        <option><?php echo $licee[$i]; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
            </div>
        </form>
        <!-- RESULTS TABLE -->
        <div class="resultstable">
            <table class="table" name="resultstable" id="resultstable">
                <!-- TABLE HEADER -->
                <thead class="thead-dark">
                </thead>
                <!-- TABLE BODY -->
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="resultslabel">
            <p id="resultslabel"></p>
        </div>
    </body>
</html> 