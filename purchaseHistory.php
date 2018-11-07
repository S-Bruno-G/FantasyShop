<?php
include 'functions.php';
session_start();

?>


<!DOCTYPE html>
<html>
    <head>
        <title> Product Purchase History </title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel='stylesheet' href='css/styles.css' type='text/css' />
    </head>
    <body>
        <!-- Bootstrap Navagation Bar -->
            <nav class='navbar navbar-default - navbar-fixed-top'>
                <div class='container-fluid'>
                    <div class='navbar-header'>
                        <a class='navbar-brand' href='index.php'>Fantasy Shop</a>
                    </div>
                    <ul class='nav navbar-nav'>
                        <li><a href='index.php'>Home</a></li>
                        <li><a href='scart.php'>
                        <span class='glyphicon glyphicon-shopping-cart' aria-hidden='true'>
                        </span> Cart: <?php displayCartCount(); ?></a></li>
                        
                    </ul>
                </div>
            </nav>
            <br /> <br /> <br />
    </head>

        <h2>Product Purchase History</h2>
        <?=displayProductInfo()?>
        <br>
        <br>
        <form action='index.php'>
            <input id='back' type="submit" name="submit" value='Back!'/>
        </form>
    </body>
</html>