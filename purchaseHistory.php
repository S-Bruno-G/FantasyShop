<?php

include 'dbConnectionFS.php';
$dbConn = startConnection("fantasyShop");

function displayProductInfo(){
    global $dbConn;
    
    $productId = $_GET['productId'];
    $sql = "SELECT * 
            FROM fs_purchase 
            NATURAL RIGHT JOIN fs_product 
            WHERE productId = $productId";
    $stmt = $dbConn->prepare($sql);
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC); //fetchAll returns an Array of Arrays
    
    echo "<img src='" . $records[0]['productImage'] . "'  width='200'>";
    
    if (empty($records[0]['purchaseId'])) {
        
        echo "<h3> Product hasn't been purchased yet </h3>";
        
    }
    
    echo "<center>";
    echo "<table>";
    echo "<tr>";
    echo "<th>Description-</th><th>Quantity-</th><th>Unit Price-</th><th>Purchase Date</th>";
    foreach ($records as $record) {
        echo "<tr>";
        echo "<td>" . $record[productDescription] . "</td>";
        echo "<td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp" . $record[quantity] . "</td>";
        echo "<td>&nbsp&nbsp&nbsp $" . $record[unitPrice] . "</td>";
        echo "<td>&nbsp&nbsp&nbsp" . $record[purchaseDate] . "</td>";
        echo "</tr>";  
    }
    echo "</table>";
    echo "</center>";
    
    //print_r($records);
    
}


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
                        </span> Cart: </a></li>
                    </ul>
                </div>
            </nav>
            <br /> <br /> <br />
    </head>

        <h2>Product Purchase History</h2>
        <?=displayProductInfo()?>
        
    </body>
</html>