<?php
    session_start();
    include 'functions.php';
    // filters and displays the products
    
    
        
    if (!isset($_SESSION['cart'])){
        $_SESSION['cart'] = array();
    }
    
    if (isset($_POST['itemName'])) {
        $newItem = array();
        $newItem['name'] = $_POST['itemName'];
        $newItem['id'] = $_POST['itemId'];
        $newItem['price'] = $_POST['itemPrice'];
        $newItem['image'] = $_POST['itemImage'];
        
        
        foreach ($_SESSION['cart'] as &$item) {
            if ($newItem['id'] == $item['id'])
            {
            $item['quantity'] += 1;
            $found = true;
        }
        }
        if ($found != true) {
            $newItem['quantity'] = 1;
            array_push($_SESSION['cart'], $newItem);
        }
    }
    

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Fantasy Shop</title>
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
            
            <img src="https://fontmeme.com/permalink/181105/4a00f79cfe7a04a29bbd1289d37dd1ca.png" alt="dragon-ball-z-font" border="0">
            <h2>Search</h2>
        <form>
            Product: <input type="text" name="productName" placeholder="Product keyword" class ="searchInputs"/> <br />
            
            Category: 
            <select name="category" class ="searchInputs">
               <option value=""> -Select one- </option>  
               <?=displayCategories()?>
            </select>
            <br>
            Price: From: <input type="number" name="priceFrom" size="7" class ="searchInputs"/> 
             To: <input type="number" name="priceTo" size="7" class ="searchInputs"/>
            <br>
            
            Order Price By <br>
              <input type="radio" name="orderBy" value="low-high"
                <?php if ($_GET['orderBy'] == "ASC") {
                //echo "checked";
                } ?>
                /> low-high <br>
              <input type="radio" name="orderBy" value="high-low"
                <?php if ($_GET['orderBy'] == "DECS") {
                //echo "checked";
                } ?>
                /> high-low <br>
            <br>
            Order Name By<br>
                <input type = "radio" name = "orderBy" value ="az">A-Z
                <input type = "radio" name = "orderBy" value ="za">Z-A
               <br />
            <input id='search' type="submit" name="submit" value="Search!"/>
        </form>
        <br>
        <hr>
        
        <?php
            if($_GET['submit'] == "Search!") {
                echo "<h2>Search Results </h2>";
                filterProducts();
            }
        ?>
        
    </body>
    <hr id='bottom' width='100%' size='10px' color='#a6a6a6'>
    <footer>
        CST336 Internet Programming Team Project: Fantasy Shop. 2018
    </footer>
</html>