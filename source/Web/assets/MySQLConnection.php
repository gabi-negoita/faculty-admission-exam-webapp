<?php
    // Login query
    function GetPasswordByUsername($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>")

            // Preparing statement
            $statement = $connection->prepare("SELECT user.PASSWORD "
                    . "FROM user "
                    . "WHERE user.USERNAME = :input");
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = null;
            
            while ($row = $statement->fetch()) {
                $results = $row['PASSWORD'];
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetFirstnameByUsername($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>")

            // Preparing statement
            $statement = $connection->prepare("SELECT user.FIRSTNAME "
                    . "FROM user "
                    . "WHERE user.USERNAME = :input");
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = null;
            
            while ($row = $statement->fetch()) {
                $results = $row['FIRSTNAME'];
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetLastnameByUsername($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>")

            // Preparing statement
            $statement = $connection->prepare("SELECT user.LASTNAME "
                    . "FROM user "
                    . "WHERE user.USERNAME = :input");
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = null;
            
            while ($row = $statement->fetch()) {
                $results = $row['LASTNAME'];
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetRoleByUsername($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>")

            // Preparing statement
            $statement = $connection->prepare("SELECT user.ROLE "
                    . "FROM user "
                    . "WHERE user.USERNAME = :input");
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = null;
            
            while ($row = $statement->fetch()) {
                $results = $row['ROLE'];
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }

    // Candidat queries
    function GetNumeCandidatByDenumireLiceu($input, $den_liceu)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT concat(candidat.NUME, ' ', candidat.INIT_TATA, '. ', candidat.prenume) as NUME "
                ."FROM candidat "
                ."WHERE (candidat.NUME LIKE :input "
                ."OR candidat.INIT_TATA LIKE :input "
                ."OR candidat.PRENUME LIKE :input) "
                ."AND candidat.DEN_LICEU LIKE :den_liceu");   
            
            // Renaiming variable for LIKE comparator
            $input = "%$input%";
            $den_liceu = "%$den_liceu%";
            
            // Binding variables
            $statement->bindParam(':input', $input);
            $statement->bindParam(':den_liceu', $den_liceu);
            

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = array();
            
            while ($row = $statement->fetch()) {
                array_push($results, $row['NUME']);
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetLiceuCandidatByDenumireLiceu($input, $den_liceu)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT candidat.DEN_LICEU "
                ."FROM candidat "
                ."WHERE (candidat.NUME LIKE :input "
                ."OR candidat.INIT_TATA LIKE :input "
                ."OR candidat.PRENUME LIKE :input) "
                ."AND candidat.DEN_LICEU LIKE :den_liceu");   
            
            // Renaiming variable for LIKE comparator
            $input = "%$input%";
            $den_liceu = "%$den_liceu%";
            
            // Binding variables
            $statement->bindParam(':input', $input);
            $statement->bindParam(':den_liceu', $den_liceu);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = array();
            
            while ($row = $statement->fetch()) {
                array_push($results, $row['DEN_LICEU']);
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetMedieLiceuCandidatByDenumireLiceu($input, $den_liceu)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT candidat.MEDIE_LICEU "
                ."FROM candidat "
                ."WHERE (candidat.NUME LIKE :input "
                ."OR candidat.INIT_TATA LIKE :input "
                ."OR candidat.PRENUME LIKE :input) "
                ."AND candidat.DEN_LICEU LIKE :den_liceu");   
            
            // Renaiming variable for LIKE comparator
            $input = "%$input%";
            $den_liceu = "%$den_liceu%";
            
            // Binding variables
            $statement->bindParam(':input', $input);
            $statement->bindParam(':den_liceu', $den_liceu);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = array();
            
            while ($row = $statement->fetch()) {
                array_push($results, $row['MEDIE_LICEU']);
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetMedieBacCandidatByDenumireLiceu($input, $den_liceu)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT candidat.MEDIE_BAC "
                ."FROM candidat "
                ."WHERE (candidat.NUME LIKE :input "
                ."OR candidat.INIT_TATA LIKE :input "
                ."OR candidat.PRENUME LIKE :input) "
                ."AND candidat.DEN_LICEU LIKE :den_liceu");   
            
            // Renaiming variable for LIKE comparator
            $input = "%$input%";
            $den_liceu = "%$den_liceu%";
            
            // Binding variables
            $statement->bindParam(':input', $input);
            $statement->bindParam(':den_liceu', $den_liceu);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = array();
            
            while ($row = $statement->fetch()) {
                array_push($results, $row['MEDIE_BAC']);
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }

    // Universitate queries
    function GetDenumireUniversitate($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT universitate.DEN_U "
                    . "FROM universitate "
                    . "WHERE universitate.DEN_U LIKE :input");   
            
            // Renaiming variable for LIKE comparator
            $input = "%$input%";
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = array();
            
            while ($row = $statement->fetch()) {
                array_push($results, $row['DEN_U']);
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetAdresaUniversitate($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT universitate.ADRESA_U "
                    . "FROM universitate "
                    . "WHERE universitate.DEN_U LIKE :input");   
            
            // Renaiming variable for LIKE comparator
            $input = "%$input%";
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = array();
            
            while ($row = $statement->fetch()) {
                array_push($results, $row['ADRESA_U']);
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }

    // Facultate queries
    function GetDenumireFacultate($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT facultate.DEN_F "
                    . "FROM facultate "
                    . "WHERE facultate.DEN_F LIKE :input");   
            
            // Renaiming variable for LIKE comparator
            $input = "%$input%";
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = array();
            
            while ($row = $statement->fetch()) {
                array_push($results, $row['DEN_F']);
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetUniversitateFacultate($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT universitate.DEN_U "
                    . "FROM facultate, universitate "
                    . "WHERE universitate.COD_U = facultate.COD_U "
                    . "AND facultate.DEN_F LIKE :input");   
            
            // Renaiming variable for LIKE comparator
            $input = "%$input%";
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = array();
            
            while ($row = $statement->fetch()) {
                array_push($results, $row['DEN_U']);
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetAdresaFacultate($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT facultate.ADRESA_F "
                    . "FROM facultate "
                    . "WHERE facultate.DEN_F LIKE :input");   
            
            // Renaiming variable for LIKE comparator
            $input = "%$input%";
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = array();
            
            while ($row = $statement->fetch()) {
                array_push($results, $row['ADRESA_F']);
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }

    // Domeniu queries
    function GetDenumireDomeniu($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT domeniu.DEN_D "
                    . "FROM domeniu "
                    . "WHERE domeniu.DEN_D LIKE :input");   
            
            // Renaiming variable for LIKE comparator
            $input = "%$input%";
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = array();
            
            while ($row = $statement->fetch()) {
                array_push($results, $row['DEN_D']);
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetFacultateDomeniu($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT facultate.DEN_F "
                    . "FROM domeniu, facultate "
                    . "WHERE domeniu.COD_F = facultate.COD_F "
                    . "AND domeniu.DEN_D LIKE :input");   
            
            // Renaiming variable for LIKE comparator
            $input = "%$input%";
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = array();
            
            while ($row = $statement->fetch()) {
                array_push($results, $row['DEN_F']);
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }

    // Specializare queries
    function GetDenumireSpecializare($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT specializare.DEN_S "
                    . "FROM specializare "
                    . "WHERE specializare.DEN_S LIKE :input");   
            
            // Renaiming variable for LIKE comparator
            $input = "%$input%";
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = array();
            
            while ($row = $statement->fetch()) {
                array_push($results, $row['DEN_S']);
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetDomeniuSpecializare($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT domeniu.DEN_D "
                    . "FROM specializare, domeniu "
                    . "WHERE specializare.COD_D = domeniu.COD_D "
                    . "AND specializare.DEN_S LIKE :input");   
            
            // Renaiming variable for LIKE comparator
            $input = "%$input%";
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = array();
            
            while ($row = $statement->fetch()) {
                array_push($results, $row['DEN_D']);
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetDurataSpecializare($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT specializare.DURATA_ANI "
                    . "FROM specializare "
                    . "WHERE specializare.DEN_S LIKE :input");   
            
            // Renaiming variable for LIKE comparator
            $input = "%$input%";
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = array();
            
            while ($row = $statement->fetch()) {
                array_push($results, $row['DURATA_ANI']);
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetRegulaAdmitereSpecializare($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT regula_admitere.DESCRIERE "
                    . "FROM specializare, regula_admitere "
                    . "WHERE specializare.COD_R = regula_admitere.COD_R "
                    . "AND specializare.DEN_S LIKE :input");   
            
            // Renaiming variable for LIKE comparator
            $input = "%$input%";
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = array();
            
            while ($row = $statement->fetch()) {
                array_push($results, $row['DESCRIERE']);
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetLocuriBugetSpecializare($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT loc.NR_LOCURI "
                    . "FROM specializare, loc "
                    . "WHERE specializare.COD_S = loc.COD_S "
                    . "AND loc.BUGET_TAXA = 'buget' "
                    . "AND specializare.DEN_S LIKE :input");
            
            // Renaiming variable for LIKE comparator
            $input = "%$input%";
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = array();
            
            while ($row = $statement->fetch()) {
                array_push($results, $row['NR_LOCURI']);
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetLocuriTaxaSpecializare($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT loc.NR_LOCURI "
                    . "FROM specializare, loc "
                    . "WHERE specializare.COD_S = loc.COD_S "
                    . "AND loc.BUGET_TAXA = 'taxa' "
                    . "AND specializare.DEN_S LIKE :input");   
            
            // Renaiming variable for LIKE comparator
            $input = "%$input%";
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = array();
            
            while ($row = $statement->fetch()) {
                array_push($results, $row['NR_LOCURI']);
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    
    // Other queries
    function GetLiceu()
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT DISTINCT candidat.DEN_LICEU "
                    . "FROM candidat "
                    . "ORDER BY candidat.DEN_LICEU"); 

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = array();
            
            while ($row = $statement->fetch()) {
                array_push($results, $row['DEN_LICEU']);
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }

    function GetUniversitate()
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT universitate.DEN_U "
                    . "FROM universitate"); 

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = array();
            
            while ($row = $statement->fetch()) {
                array_push($results, $row['DEN_U']);
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetFacultateByUniversitate($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT facultate.DEN_F "
                    . "FROM facultate, universitate "
                    . "WHERE facultate.COD_U = universitate.COD_U "
                    . "AND universitate.DEN_U = :input");   
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = array();
            
            while ($row = $statement->fetch()) {
                array_push($results, $row['DEN_F']);
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetDomeniuByFacultate($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT domeniu.DEN_D "
                    . "FROM domeniu, facultate "
                    . "WHERE domeniu.COD_F = facultate.COD_F "
                    . "AND facultate.DEN_F = :input");   
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = array();
            
            while ($row = $statement->fetch()) {
                array_push($results, $row['DEN_D']);
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetSpecializareByDomeniu($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT specializare.DEN_S "
                    . "FROM specializare, domeniu "
                    . "WHERE specializare.COD_D = domeniu.COD_D "
                    . "AND domeniu.DEN_D = :input");   
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = array();
            
            while ($row = $statement->fetch()) {
                array_push($results, $row['DEN_S']);
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetMaxCodCandidat()
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT max(candidat.COD_C) as COD_C "
                    . "FROM candidat");   

            // Executing statement
            $statement->execute();

            // Getting the data
            $result = 10000;
            
            while ($row = $statement->fetch()) {
                if ($row['COD_C'] != null)
                {
                    $result = $row['COD_C'];
                }
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $result;
    }

    function AddCandidat($nume, $init_tata, $prenume, $cnp, $data_nastere, $den_liceu, $medie_liceu, $medie_bac)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("INSERT INTO candidat (COD_C, NUME, INIT_TATA, PRENUME, CNP, DATA_N, DEN_LICEU, MEDIE_LICEU, MEDIE_BAC) "
                    . "VALUES (:cod_c, :nume, :init_tata, :prenume, :cnp, :data_nastere, :den_liceu, :medie_liceu, :medie_bac)");   

            // Getting next candidat code
            $cod_c = GetMaxCodCandidat() + 1;

            // Binding variables
            $statement->bindParam(':cod_c', $cod_c);
            $statement->bindParam(':nume', $nume);
            $statement->bindParam(':init_tata', $init_tata);
            $statement->bindParam(':prenume', $prenume);
            $statement->bindParam(':cnp', $cnp);
            $statement->bindParam(':data_nastere', $data_nastere);
            $statement->bindParam(':den_liceu', $den_liceu);
            $statement->bindParam(':medie_liceu', $medie_liceu);
            $statement->bindParam(':medie_bac', $medie_bac);

            // Executing statement
            $statement->execute();

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
    }
    function GetMaxCodOptiuneCandidat()
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT max(optiune_candidat.COD_O) as COD_O "
                    . "FROM optiune_candidat");   

            // Executing statement
            $statement->execute();

            // Getting the data
            $result = 100000;
            
            while ($row = $statement->fetch()) {
                if ($row['COD_O'] != null)
                {
                    $result = $row['COD_O'];
                }
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $result;
    }
    function GetCodSpecializareByDenumire($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT specializare.COD_S "
                    . "FROM specializare "
                    . "WHERE specializare.DEN_S = :input");   
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $result = "";

            while ($row = $statement->fetch()) {
                $result = $row['COD_S'];
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $result;
    }
    function GetCountCNPByCNP($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT count(*) as COUNT "
                    . "FROM candidat "
                    . "WHERE candidat.CNP = :input");   
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $result = -1;

            while ($row = $statement->fetch()) {
                $result = $row['COUNT'];
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $result;
    }
    function AddOptiuneCandidat($buget_taxa, $den_s)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("INSERT INTO optiune_candidat (COD_O, BUGET_TAXA, COD_C, COD_S) "
                    . "VALUES (:cod_o, :buget_taxa, :cod_c, :cod_s)");

            // Getting next candidat code
            $cod_o = GetMaxCodOptiuneCandidat() + 1;
            $cod_c = GetMaxCodCandidat();
            $cod_s = GetCodSpecializareByDenumire($den_s);

            // Binding variables
            $statement->bindParam(':cod_o', $cod_o);
            $statement->bindParam(':buget_taxa', $buget_taxa);
            $statement->bindParam(':cod_c', $cod_c);
            $statement->bindParam(':cod_s', $cod_s);

            // Executing statement
            $statement->execute();

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
    }
    function AddRezultatCandidat()
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("INSERT INTO `paw`.`rezultat` (`COD_C`, `COD_E`, `NOTA`) "
                ."SELECT :cod_c, examen.COD_E, 0 "
                ."FROM specializare, regula_admitere, examen "
                ."WHERE specializare.COD_R = regula_admitere.COD_R "
                ."AND regula_admitere.COD_E = examen.COD_E "
                ."AND specializare.DEN_S IN ( "
                    ."SELECT DEN_S "
                    ."FROM candidat, optiune_candidat, specializare "
                    ."WHERE candidat.COD_C = optiune_candidat.COD_C "
                    ."AND optiune_candidat.COD_S = specializare.COD_S "
                    ."AND candidat.COD_C = :cod_c)");

            // Getting next candidat code
            $cod_c = GetMaxCodCandidat();

            // Binding variables
            $statement->bindParam(':cod_c', $cod_c);

            // Executing statement
            $statement->execute();

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
    }

    function GetNumeCandidati()
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT concat(candidat.NUME, ' ', candidat.INIT_TATA, '. ', candidat.PRENUME) as NUME "
                    . "FROM candidat "
                    . "ORDER BY candidat.COD_C");

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = array();
            
            while ($row = $statement->fetch()) {
                array_push($results, $row['NUME']);
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetCNPCandidati()
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT candidat.CNP "
                    . "FROM candidat "
                    . "ORDER BY candidat.COD_C");

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = array();
            
            while ($row = $statement->fetch()) {
                array_push($results, $row['CNP']);
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }

    function GetNumeCandidatByCNP($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT candidat.NUME "
                    . "FROM candidat "
                    . "WHERE candidat.CNP = :input ");   
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = "";
            
            while ($row = $statement->fetch()) {
                $results = $row['NUME'];
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetInitialaTataCandidatByCNP($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT candidat.INIT_TATA "
                    . "FROM candidat "
                    . "WHERE candidat.CNP = :input ");   
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = "";
            
            while ($row = $statement->fetch()) {
                $results = $row['INIT_TATA'];
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetPrenumeCandidatByCNP($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT candidat.PRENUME "
                    . "FROM candidat "
                    . "WHERE candidat.CNP = :input ");   
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = "";
            
            while ($row = $statement->fetch()) {
                $results = $row['PRENUME'];
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetDataNastereCandidatByCNP($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT candidat.DATA_N "
                    . "FROM candidat "
                    . "WHERE candidat.CNP = :input ");   
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = "";
            
            while ($row = $statement->fetch()) {
                $results = $row['DATA_N'];
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetDenumireLiceuCandidatByCNP($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT candidat.DEN_LICEU "
                    . "FROM candidat "
                    . "WHERE candidat.CNP = :input ");   
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = "";
            
            while ($row = $statement->fetch()) {
                $results = $row['DEN_LICEU'];
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetMedieLiceuCandidatByCNP($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT candidat.MEDIE_LICEU "
                    . "FROM candidat "
                    . "WHERE candidat.CNP = :input ");   
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = 0;
            
            while ($row = $statement->fetch()) {
                $results = $row['MEDIE_LICEU'];
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetMedieBacCandidatByCNP($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT candidat.MEDIE_BAC "
                    . "FROM candidat "
                    . "WHERE candidat.CNP = :input ");   
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = 0;
            
            while ($row = $statement->fetch()) {
                $results = $row['MEDIE_BAC'];
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    
    function GetDenumireExamenCandidatByCNP($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT distinct examen.DEN_E "
                ."FROM candidat, optiune_candidat, specializare, regula_admitere, examen "
                ."WHERE candidat.COD_C = optiune_candidat.COD_C "
                ."AND optiune_candidat.COD_S = specializare.COD_S "
                ."AND specializare.COD_R = regula_admitere.COD_R "
                ."AND regula_admitere.COD_E = examen.COD_E "
                ."AND candidat.CNP = :input");
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = array();
            
            while ($row = $statement->fetch()) {
                array_push($results, $row['DEN_E']);
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  

        return $results;
    }
    function GetLocatieExamenCandidatByCNP($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT distinct examen.LOCATIE "
                ."FROM candidat, optiune_candidat, specializare, regula_admitere, examen "
                ."WHERE candidat.COD_C = optiune_candidat.COD_C "
                ."AND optiune_candidat.COD_S = specializare.COD_S "
                ."AND specializare.COD_R = regula_admitere.COD_R "
                ."AND regula_admitere.COD_E = examen.COD_E "
                ."AND candidat.CNP = :input");
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = array();
            
            while ($row = $statement->fetch()) {
                array_push($results, $row['LOCATIE']);
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetDataExamenCandidatByCNP($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT distinct examen.DATA "
                ."FROM candidat, optiune_candidat, specializare, regula_admitere, examen "
                ."WHERE candidat.COD_C = optiune_candidat.COD_C "
                ."AND optiune_candidat.COD_S = specializare.COD_S "
                ."AND specializare.COD_R = regula_admitere.COD_R "
                ."AND regula_admitere.COD_E = examen.COD_E "
                ."AND candidat.CNP = :input");
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = array();
            
            while ($row = $statement->fetch()) {
                array_push($results, $row['DATA']);
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetNotaCandidat($cnp, $den_e)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT rezultat.NOTA "
            ."FROM rezultat "
            ."WHERE rezultat.COD_C = ( "
                ."SELECT candidat.COD_C "
                ."FROM candidat "
                ."WHERE candidat.CNP = :cnp) "
            ."AND rezultat.COD_E = ( "
                ."SELECT examen.COD_E "
                ."FROM examen "
                ."WHERE examen.DEN_E = :den_e)");
            
            // Binding variables
            $statement->bindParam(':cnp', $cnp);
            $statement->bindParam(':den_e', $den_e);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = -1;
            
            while ($row = $statement->fetch()) {
                $results = $row['NOTA'];
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    
    function GetCodCandidatByCNP($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT candidat.COD_C "
                    . "FROM candidat "
                    . "WHERE candidat.CNP = :input ");   
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = "";
            
            while ($row = $statement->fetch()) {
                $results = $row['COD_C'];
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    
    function DeleteRezultateCandidatByCodCandidat($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("DELETE FROM rezultat "
                    . "WHERE rezultat.COD_C = :input ");   
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
    }
    function DeleteOptiuniCandidatByCodCandidat($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("DELETE FROM optiune_candidat "
                    . "WHERE optiune_candidat.COD_C = :input ");   
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
    }
    function DeleteCandidatByCodCandidat($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("DELETE FROM candidat "
                    . "WHERE candidat.COD_C = :input ");   
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
    }
    
    function UpdateCandidat($nume, $init_tata, $prenume, $cnp, $data_n, $den_liceu, $medie_liceu, $medie_bac)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("UPDATE candidat "
            ."SET candidat.NUME = :nume, "
            ."candidat.INIT_TATA = :init_tata, "
            ."candidat.PRENUME = :prenume, "
            ."candidat.CNP = :cnp, "
            ."candidat.DATA_N = :data_n, "
            ."candidat.DEN_LICEU = :den_liceu, "
            ."candidat.MEDIE_LICEU = :medie_liceu, "
            ."candidat.MEDIE_BAC = :medie_bac "
            ."WHERE candidat.COD_C = :cod_c");

            $cod_c = GetCodCandidatByCNP($cnp);
            // Binding variables
            $statement->bindParam(':nume', $nume);
            $statement->bindParam(':init_tata', $init_tata);
            $statement->bindParam(':prenume', $prenume);
            $statement->bindParam(':cnp', $cnp);
            $statement->bindParam(':data_n', $data_n);
            $statement->bindParam(':den_liceu', $den_liceu);
            $statement->bindParam(':medie_liceu', $medie_liceu);
            $statement->bindParam(':medie_bac', $medie_bac);
            $statement->bindParam(':cod_c', $cod_c);

            // Executing statement
            $statement->execute();

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
    }
    function GetCodExamenByDenumire($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT examen.COD_E "
                    . "FROM examen "
                    . "WHERE examen.DEN_E = :input");   
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $result = "";

            while ($row = $statement->fetch()) {
                $result = $row['COD_E'];
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $result;
    }
    function UpdateNota($cnp, $den_e, $nota)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("UPDATE rezultat "
            ."SET rezultat.NOTA = :nota "
            ."WHERE rezultat.COD_C = :cod_c "
            ."AND rezultat.COD_E = :cod_e");

            $cod_c = GetCodCandidatByCNP($cnp);
            $cod_e = GetCodExamenByDenumire($den_e);

            // Binding variables
            $statement->bindParam(':nota', $nota);
            $statement->bindParam(':cod_c', $cod_c);
            $statement->bindParam(':cod_e', $cod_e);

            // Executing statement
            $statement->execute();

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
    }
    
    function GetCountSpecializare()
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT count(*) as COUNT "
                    . "FROM specializare");   

            // Executing statement
            $statement->execute();

            // Getting the data
            $result = -1;

            while ($row = $statement->fetch()) {
                $result = $row['COUNT'];
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $result;
    }
    function GetDenumireSpecializareSiLocuriBuget()
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT specializare.DEN_S, loc.NR_LOCURI "
                ."FROM specializare, loc "
                ."WHERE specializare.COD_S = loc.COD_S "
                ."AND loc.BUGET_TAXA = 'buget'");

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = array();
            
            while ($row = $statement->fetch()) {
                $results[$row['DEN_S']] = $row['NR_LOCURI'];
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetDenumireSpecializareSiLocuriTaxa()
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT specializare.DEN_S, loc.NR_LOCURI "
                ."FROM specializare, loc "
                ."WHERE specializare.COD_S = loc.COD_S "
                ."AND loc.BUGET_TAXA = 'taxa'");

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = array();
            
            while ($row = $statement->fetch()) {
                $results[$row['DEN_S']] = $row['NR_LOCURI'];
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetCodCandidatAndOptiuniCandidat()
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT candidat.COD_C "
                ."FROM candidat");

            // Executing statement
            $statement->execute();

            // Getting the data
            $cod_c = array();
            
            while ($row = $statement->fetch()) {
                array_push($cod_c, $row['COD_C']);
            }

            $results = array();
            for ($i = 0; $i < count($cod_c); $i++)
            {
                $statement = $connection->prepare("SELECT specializare.DEN_S "
                ."FROM optiune_candidat, specializare "
                ."WHERE optiune_candidat.COD_S = specializare.COD_S "
                ."AND optiune_candidat.COD_C = :cod_c");

                // Binding variables
                $statement->bindParam(':cod_c', $cod_c[$i]);

                // Executing statement
                $statement->execute();

                // Getting the data
                $result = array();
                
                $tempArr = array();
                while ($row = $statement->fetch()) {
                    array_push($tempArr, $row['DEN_S']);
                }
                $results[$cod_c[$i]] = $tempArr;
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetDescriereRegulaAdmitereByDenumireSpecializare($den_s)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT regula_admitere.DESCRIERE "
                ."FROM specializare, regula_admitere "
                ."WHERE specializare.COD_R = regula_admitere.COD_R "
                ."AND specializare.DEN_S = :den_s");   
            
                // Binding variables
            $statement->bindParam(':den_s', $den_s);

            // Executing statement
            $statement->execute();

            // Getting the data
            $result = "";

            while ($row = $statement->fetch()) {
                $result = $row['DESCRIERE'];
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $result;
    }
    function GetAverageOfMedieLiceuAndMedieBac($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT CONVERT((candidat.MEDIE_LICEU + candidat.MEDIE_BAC)/2, DECIMAL(4,2)) as MEDIE "
                ."FROM candidat "
                ."WHERE candidat.COD_C = :input");   
            
            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $result = "";

            while ($row = $statement->fetch()) {
                $result = $row['MEDIE'];
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $result;
    }
    function GetAverageOfMedieBacAndNotaExamenByDenumireSpecializareAndCodCandidat($den_s, $cod_c)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT rezultat.NOTA "
            ."FROM rezultat "
            ."WHERE rezultat.COD_E = ( "
                ."SELECT regula_admitere.COD_E "
                ."FROM specializare, regula_admitere "
                ."WHERE specializare.COD_R = regula_admitere.COD_R "
                ."AND specializare.DEN_S = :den_s) "
            ."AND rezultat.COD_C = :cod_c");

            // Binding variables
            $statement->bindParam(':den_s', $den_s);
            $statement->bindParam(':cod_c', $cod_c);
            
            // Executing statement
            $statement->execute();

            // Getting the data
            $notaExamen = -1;
            
            while ($row = $statement->fetch()) {
                if ($row['NOTA'] >= 5) 
                {
                    $notaExamen = $row['NOTA'];
                }
            }

            $results = -1;
            if ($notaExamen != -1) 
            {
                // Preparing statement
                $statement = $connection->prepare("SELECT CONVERT((candidat.MEDIE_LICEU + :nota_examen)/2, DECIMAL(4,2)) as MEDIE "
                ."FROM candidat "
                ."WHERE candidat.COD_C = :cod_c");

                // Binding variables
                $statement->bindParam(':nota_examen', $notaExamen);
                $statement->bindParam(':cod_c', $cod_c);
                
                // Executing statement
                $statement->execute();

                // Getting the data
                $notaExamen = -1;
                
                while ($row = $statement->fetch()) {
                        $results = $row['MEDIE'];
                }
            } 
            else 
            {
                return $results;
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetNotaExamenByDenumireSpecializareAndCodCandidat($den_s, $cod_c)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT rezultat.NOTA "
            ."FROM rezultat "
            ."WHERE rezultat.COD_E = ( "
                ."SELECT regula_admitere.COD_E "
                ."FROM specializare, regula_admitere "
                ."WHERE specializare.COD_R = regula_admitere.COD_R "
                ."AND specializare.DEN_S = :den_s) "
            ."AND rezultat.COD_C = :cod_c");

            // Binding variables
            $statement->bindParam(':den_s', $den_s);
            $statement->bindParam(':cod_c', $cod_c);
            
            // Executing statement
            $statement->execute();

            // Getting the data
            $results = -1;
            
            while ($row = $statement->fetch()) {
                if ($row['NOTA'] >= 5) 
                {
                    $results = $row['NOTA'];
                }
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetNumeCompletCandidatByCodCandidat($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT concat(candidat.NUME, ' ', candidat.INIT_TATA, '. ', candidat.prenume) as NUME "
                ."FROM candidat "
                ."WHERE candidat.COD_C = :input");

            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = "";
            
            while ($row = $statement->fetch()) {
                $results = $row['NUME'];
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetBugetTaxaOptiuneCandidatByCodCandidatAndDenumireSpecializare($cod_c, $den_s)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT optiune_candidat.BUGET_TAXA "
                ."FROM optiune_candidat "
                ."WHERE optiune_candidat.COD_S = ( "
                    ."SELECT specializare.COD_S "
                    ."FROM specializare "
                    ."WHERE specializare.DEN_S = :den_s) "
                ."AND optiune_candidat.COD_C = :cod_c "
                ."LIMIT 1");

            // Binding variables
            $statement->bindParam(':cod_c', $cod_c);
            $statement->bindParam(':den_s', $den_s);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = "";
            
            while ($row = $statement->fetch()) {
                $results = $row['BUGET_TAXA'];
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    
    function GetCodUserByUsername($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT user.COD_U "
                ."FROM user "
                ."WHERE user.USERNAME = :input");

            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = -1;
            
            while ($row = $statement->fetch()) {
                $results = $row['COD_U'];
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function AddLog($cod_u, $time, $action, $query)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("INSERT INTO log (COD_U, TIME, ACTION, QUERY) "
                . "VALUES (:cod_u, :time, :action, :query)");   

            // Getting next candidat code
            $cod_c = GetMaxCodCandidat() + 1;

            // Binding variables
            $statement->bindParam(':cod_u', $cod_u);
            $statement->bindParam(':time', $time);
            $statement->bindParam(':action', $action);
            $statement->bindParam(':query', $query);

            // Executing statement
            $statement->execute();

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
    }

    function GetLogCodUser()
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT log.COD_U "
                ."FROM log "
                ."ORDER BY TIME");

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = array();
            
            while ($row = $statement->fetch()) {
                array_push($results, $row['COD_U']);
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetLogTime()
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT log.TIME "
                ."FROM log "
                ."ORDER BY TIME");

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = array();
            
            while ($row = $statement->fetch()) {
                array_push($results, $row['TIME']);
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetLogAction()
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT log.ACTION "
               ."FROM log "
               ."ORDER BY TIME");

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = array();
            
            while ($row = $statement->fetch()) {
                array_push($results, $row['ACTION']);
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetLogQuery()
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT log.QUERY "
                ."FROM log "
                ."ORDER BY TIME");

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = array();
            
            while ($row = $statement->fetch()) {
                array_push($results, $row['QUERY']);
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetUsernameByCodUser($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT user.USERNAME "
                ."FROM user "
                ."WHERE user.COD_U = :input");

            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = "";
            
            while ($row = $statement->fetch()) {
                $results = $row['USERNAME'];
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    function GetRoleByCodUser($input)
    {
        $DBServer = "localhost";
        $DBName= "paw";
        $DBUsername = "paw_root";
        $DBPassword = "root";
    
        try
        {
            $connection = new PDO("mysql:host=$DBServer;dbname=$DBName;port=3306", $DBUsername, $DBPassword);

            // Setting the atribute from error to exception so I can catch it 
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // No exception has occurred
            // print("Connected successfully"."<br/>");

            // Preparing statement
            $statement = $connection->prepare("SELECT user.ROLE "
                ."FROM user "
                ."WHERE user.COD_U = :input");

            // Binding variables
            $statement->bindParam(':input', $input);

            // Executing statement
            $statement->execute();

            // Getting the data
            $results = "";
            
            while ($row = $statement->fetch()) {
                $results = $row['ROLE'];
            }

            // Closing the connection (destroying the object)
            $connection = null;
        }
        catch(PDOException $e)
        {
            // Exception occurred
            print("Connection failed. Cause: " . $e->getMessage());
        }  
        
        return $results;
    }
    