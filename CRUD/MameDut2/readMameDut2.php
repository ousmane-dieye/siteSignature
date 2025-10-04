<?php
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require "../../db.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM parrainmarrainemame WHERE id = :id";
    
    if($stmt = $pdo->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":id", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
        
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
                $password = $row["mot_de_passe"];
                $niveau = $row["niveau"];

            }else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: errorMameDut2php");
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
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: errorMameDut2.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
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
                    <h1 class="mt-5 mb-3">View Record</h1>
                    <div class="form-group">
                        <label>Nom</label>
                        <p><b><?php echo $row["nom"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Prenom</label>
                        <p><b><?php echo $row["prenom"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <p><b><?php echo $row["username"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Telephone</label>
                        <p><b><?php echo $row["telephone"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Mot de passe</label>
                        <p><b><?php echo $row["mot_de_passe"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Niveau</label>
                        <p><b><?php echo $row["niveau"]; ?></b></p>
                    </div>
                    <p><a href="listeMameDut2.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
