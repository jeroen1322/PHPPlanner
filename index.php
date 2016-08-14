<?php
    require('./resources/info.php');
    require('./resources/lib.php');
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" media="screen" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css">
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
                                <input type="text" class="form-control" placeholder="Add something I should remind you about"><br>
                                <ul class="list-group">
                                    <li class="list-group-item"><b>Test</b></li>
                                    <li class="list-group-item"><b>Test</b></li>
                                </ul>
                            </div>
            
                        <?php
                    }
                } else {
                    echo "There seems to be a problem. Please come back later.";
                }
            
               
            ?>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </body>

</html>

