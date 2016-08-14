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
        <title>RemindMePHP</title>
        <link href="./resources/css/style.css" rel="stylesheet" type="text/css">
    </head>

    <body>
        <div class="container">
            <?php
            
                if(manageDB($server, $username, $passw, $dbname, $mysqli) === true){
                    $conn = new mysqli($server, $username, $passw, $dbname);

                    if(showConfigForm($conn) === true){
                        ?>
                            <div class="reminder-list">
                                <h1>Stuff to remind you about:</h1>
                                <button class="btn btn-default" id="new_reminder">Add new reminder</button><br><br>
                                <div class="new_reminder_field">
                                    <form method="post">
                                        <input type="text" class="form-control" placeholder="Add something I should remind you about" name="reminder_input" autocomplete="off"><button class="btn btn-default" name="add_reminder" type="submit">Submit</button><br><br>
                                    </form>
                                </div>
                                <?php
                                    if(isset($_POST['add_reminder'])){
                                        $reminderInput = htmlspecialchars($_POST['reminder_input']);
                                        addReminder($conn, $reminderInput);
                                    }
                                ?>
                                <ul class="list-group">
                                    <li class="list-group-item"><b>Test</b></li>
                                    <li class="list-group-item"><b>Test</b></li>
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

