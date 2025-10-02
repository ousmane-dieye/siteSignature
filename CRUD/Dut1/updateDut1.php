<?php
// Include config file
require "../../db.php";
 
// Define variables and initialize with empty values
$nom = $prenom = $username = $telephone = $nbre_signature = $mot_de_passe = "";
$nom_err = $prenom_err = $username_err = $telephone_err = $nbre_signature_err = $mot_de_passe_err = "";

 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Valider un nom
    $input_nom = trim($_POST["nom"]);
    if(empty($input_nom)){
        $nom_err = "Please enter a nom.";
    } elseif(!filter_var($input_nom, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $nom_err = "Please enter a valid nom.";
    } else{
        $nom = $input_nom;
    }
    
    // Valider prenom
    $input_prenom = trim($_POST["prenom"]);
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

    // Valider mot de passe
    $input_mot_de_passe = trim($_POST["mot_de_passe"]);
    if(empty($mot_de_passe)){
        $mot_de_passe_err = "Please enter a mot_de_passe";
    } elseif(!filter_var($mot_de_passe, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $mot_de_passe_err = "Please enter a valid mot_de_passe.";
    } else{
        $mot_de_passe = $input_mot_de_passe;
    }

    // Valider nombre de signature
    $input_nombre_signature = trim($_POST["nombre_signature"]);
    if(empty($input_nombre_signature)){
        $nombre_signature_err = "Please enter the number amount.";     
    } elseif(!ctype_digit($input_username)){
        $nombre_signature_err = "Please enter a positive integer value.";
    } else{
        $nombre_signature = $input_nombre_signature;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($prenom_err) && empty($username_err) && empty($telephone_err) && empty($mot_de_passe_err) && empty($nombre_signature_err)){
        // Prepare an update statement
        $sql = "UPDATE du1 SET nom=:nom, prenom=:prenom, username=:username, telephone=:telephone, mot_de_passe=:mot_de_passe,  WHERE id=:id";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":name", $param_name);
            $stmt->bindParam(":prenom", $param_prenom);
            $stmt->bindParam(":username", $param_username);
            $stmt->bindParam(":telephone", $param_telephone);
            $stmt->bindParam(":mot_de_passe", $param_mot_de_passe);
             $stmt->bindParam(":nombre_signature", $param_nombre_signature);
            // Set parameters
            $param_name = $name;
            $param_prenom = $prenom;
            $param_username = $username;
            $param_telephone = $telephone;
            $param_mot_de_passe = $mot_de_passe; 
            $param_nombre_signature = $nombre_signature;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records updated successfully. Redirect to landing page
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
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM dut1 WHERE id = :id";
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":id", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                    // Retrieve individual field value
                    $nom = $row["nom"];
                    $prenom = $row["prenom"];
                    $username = $row["username"];
                    $telephone = $row["telephone"];
                    $mot_de_passe = $row["mot_de_passe"];
                    $nombre_signature = $row["nombre_signature"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: errorDut1.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        unset($stmt);
        
        // Close connection
        unset($pdo);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: errorDut1.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the employee record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
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
                        </div>
                        <div class="form-group">
                            <label>Mot de passe</label>
                            <input type="password" name="mot_de_passe" class="form-control <?php echo (!empty($mot_de_passe_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $mot_de_passe; ?>">
                            <span class="invalid-feedback"><?php echo $mot_de_passe_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Nombre de signature</label>
                            <input type="number" name="nombre_signature" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                            <span class="invalid-feedback"><?php echo $username_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>