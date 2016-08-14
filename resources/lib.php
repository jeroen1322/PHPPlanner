<?php
function manageDB($server, $username, $passw, $dbname, $mysqli){
    //Check connection to the database host
    if($mysqli->connect_error){
        echo "<div id='error'>Could not establish a connection to the database host. See further information: " . $mysqli->connect_error . "</div>";
        die();
    }
    
    //Create the database 'remindmephp' and check for errors
    $sql = "CREATE DATABASE IF NOT EXISTS `$dbname`";
    if($mysqli->query($sql) === FALSE){
        echo "<div id='error'>A error occured while creating the database. See further information:  " . $mysqli->error . "</div>";
        die();
    }
    
    //Check if the database 'remindmephp' exists.
    $dbSelect = mysqli_select_db($mysqli, $dbname);
    
    if($dbSelect === TRUE){
        $conn = new mysqli($server, $username, $passw, $dbname);
        //Query to create the table 'reminders'
        $reminders_sql = "CREATE TABLE IF NOT EXISTS `reminders` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL, 
            PRIMARY KEY (`id`)
        )";
        
        //Query to create the table 'config' 
        $config_sql = "CREATE TABLE IF NOT EXISTS `config` (
            `email` varchar(255) NOT NULL,
            `name` varchar(255) NOT NULL
        )";
        
        //Run the querys and check for errors
        if($conn->query($reminders_sql) === FALSE){
            die("<div id='error'>A error occured while creating the table 'reminders' " . $conn->error . "</div>");
        }
        
        if($conn->query($config_sql) === FALSE){
            die("<div id='error'>A error occured while creating the table 'config' " . $conn->error . "</div>");
        }
    } else {
        die("There was a problem with connection to the database. Please try again.");
    }
    return true;
}

function showConfigForm($conn){
    //Check if config is filled in 
    $get_config = "SELECT * FROM config";
    $result = $conn->query($get_config);
    
    if($result->num_rows === 0){
        ?>
        <div class="config_form">
            <h1>Hello there!</h1>
            <h4>This is your first time running RemindMePHP! <br> We will need some information to send you the reminders. Please fill in your name and email address.</h4>
            <form method="post">
              <div class="form-group">
                <label for="pwd">Name:</label>
                <input type="text" class="form-control" id="pwd" name="name">
              </div>
              <div class="form-group">
                <label for="email">Email address:</label>
                <input type="email" class="form-control" id="email" name="email">
              </div>
              <button type="submit" class="btn btn-default" name="submit_config">Submit</button>
            </form>
            
            <?php
                if(isset($_POST['submit_config'])){
                    $config_name = $_POST['name'];
                    $config_email = $_POST['email'];
                    
                    if($config_name && $config_email !== ""){
                        
                        $config_insert_sql = "INSERT INTO config (email, name) VALUES ('$config_email', '$config_name')";
                        
                        if($conn->query($config_insert_sql) === TRUE){
                            echo "<div class='alert alert-success'>The configuration data has been stored. <br> <a href='index.php'><button class='btn btn-default'>Continue</button></a></div>";
                        } else {
                            die("<div class='alert alert-danger'>There was a problem inserting the data in to the table. See further information: ". $conn->error . "</div>");
                        }
                        
                    } else {
                        echo "<div class='alert alert-danger'>Please fill in everyting correctly.</div>";
                    }
                }
            ?>
        </div>
        <?php
    } else {
        return true;
    }
}