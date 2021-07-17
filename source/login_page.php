<?php 
    session_start();
    
    require 'Web/assets/MySQLConnection.php';
    
    $username = "";
    $password = "";
    $loginError = false;

    if (isset($_POST["submit"]))
    {   
        $username = $_POST["username"];
        $password = $_POST["password"];
        
        if ($password === GetPasswordByUsername($username))
        {
            $_SESSION['user'] = $username;
            $_SESSION['fname'] = GetFirstnameByUsername($username);
            $_SESSION['lname'] = GetLastnameByUsername($username);
            $_SESSION['role'] = GetRoleByUsername($username);

            header("Location: page.php");
        }
        else 
        {
            $loginError = true;
        }        
    }
?>

<!DOCTYPE html>
<html>
    <head>     
        <link rel="icon" href="Resources/ugal-icon.png" type="image/ico">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <title>Login | ADMITERE LA FACULTATE</title>

        <style>
            html, body {
                
                font-family: Arial, Helvetica, sans-serif;
                background-color: #aee1f9;
                background-image: linear-gradient(315deg, #83eaf1 0%, #aee1f9 74%);
                height: 100%;
            }

            input[type=text], input[type=password] {
                padding: 0.5em 2em 0.5em 1em;
            }

            .imgcontainer {
                text-align: center;
                padding-top: 10em;
                margin-bottom: 5em;
            }
            .imgcontainer img {
                width: 10em;
                height: 10em;
            }

            .container {
                width: 100%;
            }
            .container .field {
                display: flex;
                justify-content: center;
                width: 100%;
            }
            .container .field [type=text], [type=password]{
                width: 20em;
                margin-bottom: 1em;
            }
            
            .container .button{
                width: 100%;
                display: flex;
                justify-content: center;
            }
            .container .button button {
                margin-top: 1em;
                width: 20em;
            }
        </style>
    </head>

    <body>
        <div class="imgcontainer">
            <img src="Resources/ugal-450x450-grayscale.png" alt="UGAL">
        </div>

        <form action="login_page.php" method="post">
            <div class="container">
                <!-- USERNAME FIELD -->
                <div class="field">
                    <input type="text" name="username" placeholder="Utilizator" class="form-control <?php if ($loginError) echo "is-invalid";?>" value="<?php echo htmlspecialchars($username); ?>" required>
                </div>

                <!-- PASSWORD FIELD -->
                <div class="field">
                    <input type="password" name="password" placeholder="Parola" class="form-control <?php if ($loginError) echo "is-invalid";?>" required>
                </div>

                <!-- LOGIN BUTTON -->
                <div class="button">
                    <button type="submit" name="submit" class="btn btn-dark">CONECTATI-VA</button>
                </div>
            </div>
        </form>
    </body>
</html>