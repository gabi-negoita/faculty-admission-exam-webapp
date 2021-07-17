<?php
    session_start();
    if (!isset($_SESSION['user']) || !isset($_SESSION['role']))
    {
        header("Location: login_page.php");
    }
    if ($_SESSION['role'] != 'ADMINISTRATOR')
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
    else if (isset($_GET["results_submit"]))
    {
        header("Location: results_page.php");
    }

    if (isset($_POST["filllogs"]))
    {
        $cod_u = GetLogCodUser();
        $time = GetLogTime();
        $actiune = GetLogAction();
        $query = GetLogQuery();
        
        $row = "";
        for ($i = 0; $i < count($cod_u); $i++)
        {
            $username = GetUsernameByCodUser($cod_u[$i]);
            $role = GetRoleByCodUser($cod_u[$i]);

            $row = $row."<tr>";
            
            $row = $row."<td><b>";
            $row  = $row."".($i + 1);
            $row = $row."</td></b>";

            $row = $row."<td>";
            $row = $row.$username;
            $row = $row."</td>";
        
            $row = $row."<td>";
            $row = $row.$role;
            $row = $row."</td>";
        
            $row = $row."<td>";
            $row = $row.$time [$i];
            $row = $row."</td>";
        
            $row = $row."<td>";
            $row = $row.$actiune [$i];
            $row = $row."</td>";
        
            $row = $row."<td>";
            $row = $row.$query [$i];
            $row = $row."</td>";
        
            $row = $row."</tr>";
        }
        
        echo $row;
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
        
        <title>Log-uri | ADMITERE LA FACULTATE</title>

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

            /* LOGS CONTROLS */
            .logstable {
                border: solid 1px #212529;
                border-radius: 0.5em;
                margin-left: 1em;
                margin-top: 2em;
                margin-bottom: 1em;
                margin-right: 1em;
                height: 44.75em;
                width: auto;
                overflow-y: auto;
            }
        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script>
            $(document).ready(function () {
                $.ajax({
                    type: "post",
                    data: {filllogs: "ok"},
                    success: function(response){
                        $("#logstable tbody tr").each(function(){
                            this.parentNode.removeChild(this); 
                        });
                        $("#logstable > tbody:last-child").append(response);
                    }
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
                <button class="btn btn-outline-dark" type="submit" name="results_submit">REZULTATE</button>
                <?php
                    }
                ?>
                <?php
                    if ($_SESSION["role"] == "ADMINISTRATOR")
                    {
                ?>
                <!-- BUTON LOG-uri -->
                <button class="btn btn-dark" type="submit" name="logs_submit">LOG-URI</button>
                <?php
                    }
                ?>
            </div>
        </form>
        <div class="logs">
            <!-- RESULTS TABLE -->
            <div class="logstable">
                <table class="table" id="logstable">
                    <!-- TABLE HEADER -->
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">UTILIZATOR</th>
                            <th scope="col">ROL</th>
                            <th scope="col" style="width: 10.75em">DATA SI ORA</th>
                            <th scope="col">ACTIUNE</th>
                            <th scope="col">QUERY</th>
                        </tr>
                    </thead>
                    <!-- TABLE BODY -->
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html> 
