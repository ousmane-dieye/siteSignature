<?php
// Include config file
require "../../db.php";
 
// Define variables and initialize with empty values
$nom = $prenom = $username = $telephone = $nbre_signature = $password = "";
$nom_err = $prenom_err = $username_err = $telephone_err = $nbre_signature_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Valider nom
    $input_nom = trim($_POST["nom"]);
    if(empty($input_nom)){
        $nom_err = "Please enter a nom.";
    } elseif(!filter_var($input_nom, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $nom_err = "Please enter a valid nom.";
    } else{
        $nom = $input_nom;
    }

     // Valider prenom
    $input_prenom = trim($_POST["nom"]);
    if(empty($input_prenom)){
        $prenom_err = "Please enter a prenom.";
    } elseif(!filter_var($input_prenom, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $prenom_err = "Please enter a valid prenom.";
    } else{
        $prenom = $input_prenom;
    }

    // Valider username
    $input_username = trim($_POST["username"]);
    if(empty($input_username)){
        $username_err = "Please enter a username.";
    } elseif(!filter_var($input_username, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $username_err = "Please enter a valid username.";
    } else{
        $username = $input_username;
    }
    
    // Valider telephone
    $input_telephone = trim($_POST["telephone"]);
    if(empty($input_telephone)){
        $telephone_err = "Please enter an telephone number.";     
    } else{
        $telephone = $input_telephone;
    }
    
    //Valider mot de passe
    $input_password = trim($_POST["mot_de_passe"]);
    if(empty($password)){
        $password_err = "Please enter a password";
    } elseif(!filter_var($password, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $password_err = "Please enter a valid password.";
    } else{
        $password = hash($input_password);
    }


    // Valider nombre_signature
    $input_nombre_signature = trim($_POST["nombre_signature"]);
    if(empty($input_nombre_signature)){
        $nombre_signature_err = "Please enter the nombre_signature.";     
    } elseif(!ctype_digit($input_nombre_signature)){
        $nombre_signature_err = "Please enter a positive integer value.";
    } else{
        $nombre_signature = $input_nombre_signature;
    }
    
    // Check input errors before inserting in database
    if(empty($nom_err) && empty($prenom_err) && empty($username_err) && empty($password) && empty($telephone_err) && empty($nombre_signature_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO dut1 (nom, prenom, username, telephone, mot_de_passe, nombre_signature) VALUES (?, ?, ?, ?, ?, ?)";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":nom", $param_nom);
            $stmt->bindParam(":prenom", $param_prenom);
            $stmt->bindParam(":username", $param_username);
            $stmt->bindParam(":mot_de_passe", $param_password);
            $stmt->bindParam(":telephone", $param_telephone);
            $stmt->bindParam(":nombre_signature", $param_nombre_signature);
            
            // Set parameters
            $param_nom = $nom;
            $param_prenom = $prenom;
            $param_username = $username;
            $param_password = $password;
            $param_telephone = $telephone;
            $param_nombre_signature = $nombre_signature;

            
            // Attempt to execute the prepared statement
            if($stmt->execute([$nom, $prenom, $username, $telephone, $password, $nombre_signature])){
                // Records created successfully. Redirect to landing page liste dut1
                header("location: listeDut1.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        unset($stmt);
    }
    
    // Close connection
    unset($pdo);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add Dut1 record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Nom</label>
                            <input type="text" name="nom" class="form-control <?php echo (!empty($nom_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nom; ?>">
                            <span class="invalid-feedback"><?php echo $nom_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Prenom</label>
                            <input type="text" name="prenom" class="form-control <?php echo (!empty($prenom_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $prenom; ?>">
                            <span class="invalid-feedback"><?php echo $prenom_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                            <span class="invalid-feedback"><?php echo $username_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Telephone</label>
                            <input type="telephone" name="telephone" class="form-control <?php echo (!empty($telephone_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $telephone; ?>">
                            <span class="invalid-feedback"><?php echo $telephone_err;?></span>
                            <!-- <textarea name="address" class="form-control <?php #echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php# echo $address; ?></textarea>
                            <span class="invalid-feedback"><?php #echo $address_err;?></span> -->
                        </div>
                        <div class="form-group">
                            <label>mot de passe</label>
                            <input type="password" name="mot_de_passe" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                            <span class="invalid-feedback"><?php echo $password_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Nombre de signature</label>
                            <input type="number" name="nombre_signature" class="form-control <?php echo (!empty($nombre_signature_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nombre_signature; ?>">
                            <span class="invalid-feedback"><?php echo $nombre_signature_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>