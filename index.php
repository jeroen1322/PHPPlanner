<?php
    require('./resources/info.php');
    require('./resources/lib.php');
?>
<html>
    <head>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" media="screen" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css">
        <script type="text/javascript" src="./resources/js/jquery.js"></script>
        <title>PHPLanner</title>
        <link href="./resources/css/style.css" rel="stylesheet" type="text/css">
    </head>

    <body>
        <div class="container">
            <?php
            
                if(manageDB($server, $username, $passw, $dbname, $mysqli) === true){
                    $conn = new mysqli($server, $username, $passw, $dbname);

                    if(showConfigForm($conn) === true){
                        ?>
                            <div class="task-list">
                                <h1>Stuff to do</h1>
                                <button class="btn btn-default" id="new_reminder">Add something to do</button><br><br>
                                <div class="new_reminder_field">
                                    <form method="post">
                                        <input type="text" class="form-control" placeholder="Name" name="task_name" autocomplete="off"><br>
                                        <textarea class="form-control" rows="4" placeholder="Description" name="task_description" autocomplete="off"></textarea><br>
                                        <button class="btn btn-default" name="add_reminder" type="submit">Submit</button><br><br>
                                    </form>
                                </div>
                                
                                <?php
                                    if(isset($_POST['add_reminder'])){
                                        $taskName = htmlspecialchars($_POST['task_name']);
                                        $taskDescription = htmlspecialchars($_POST['task_description']);
                                        addReminder($conn, $taskName, $taskDescription);
                                    }
                                ?>
                                <ul class="list-group">
                                    <?php
                                        showTasks($conn);
                                    ?>
                                </ul>
                    <?php
                    }
                } else {
                    echo "There seems to be a problem. Please come back later.";
                }
            
            ?>
            </div>
        </div>
    </body>

</html>

