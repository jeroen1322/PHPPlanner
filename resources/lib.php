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
    
    //Check if the database 'phpplanner' exists.
    $dbSelect = mysqli_select_db($mysqli, $dbname);
    
    if($dbSelect === TRUE){
        $conn = new mysqli($server, $username, $passw, $dbname);
        //Query to create the table 'reminders'
        $reminders_sql = "CREATE TABLE IF NOT EXISTS `tasks` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL, 
            `description` varchar(255) NOT NULL,
            PRIMARY KEY (`id`)
        )";
        
        //Query to create the table 'config' 
        $config_sql = "CREATE TABLE IF NOT EXISTS `config` (
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
            <h4>This is your first time running PHPPlanner! <br> Would you be so kind to please fill in your name? :) </h4>
            <form method="post">
              <div class="form-group">
                <label for="pwd">Name:</label>
                <input type="text" class="form-control" id="pwd" name="name" autocomplete="off">
              </div>
              <button type="submit" class="btn btn-default" name="submit_config">Submit</button>
            </form>
            
            <?php
                if(isset($_POST['submit_config'])){
                    $config_name = $_POST['name'];
                    
                    if($config_name !== ""){
                        
                        $config_insert_sql = "INSERT INTO config (name) VALUES ('$config_name')";
                        
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

function addReminder($conn, $taskName, $taskDescription){
    $reminder_sql = "INSERT INTO tasks (name, description) VALUES ('$taskName', '$taskDescription')";
    if($conn->query($reminder_sql) === TRUE){
        echo "<div class='alert alert-success'>The task has been added successfully!</div>";
        return true;
    } else {
        die("A error occured while adding the reminder. See further information: " . $conn->error);
    }
}

function showTasks($conn){
    $showTask_sql = "SELECT * FROM tasks";
    $result = $conn->query($showTask_sql);
    
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo "<li class='list-group-item'><b>" . $row['name'] . "</b><br><div class='description'>" . $row['description'] . "</div></li>";
        }
    } else {
        echo "<div class='alert alert-warning'>No reminders yet</div>";
    }
}