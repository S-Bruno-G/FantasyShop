<?php
    include 'functions.php';

?>

<!DOCTYPE html>
<html>
    <head>
        <title> Fantasy Shop</title>
        <link rel='stylesheet' href='css/styles.css' type='text/css' />
    </head>
    <body>
        <h1> Fantasy Shop </h1>
        <h2> Product Search </h2>
        
        <form>
            Product: <input type="text" name="productName" placeholder="Product keyword" /> <br />
            
            Category: 
            <select name="category">
               <option value=""> Select one </option>  
               <?=displayCategories()?>
            </select>
            <br>
            Price: From: <input type="text" name="priceFrom" size="7"/> 
             To: <input type="text" name="priceTo" size="7"/>
            <br>
            
            Order Price By <br>
              <input type="radio" name="orderBy" value="low-high"
                <?php if ($_GET['orderBy'] == "ASC") {
                //echo "checked";
                } ?>
                /> ASC <br>
              <input type="radio" name="orderBy" value="high-low"
                <?php if ($_GET['orderBy'] == "DECS") {
                //echo "checked";
                } ?>
                /> DECS <br>
            <br>
            
            <input type="submit" name="submit" value="Search!"/>
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
    <hr width='75%' size='10px' color='#a6a6a6'>
    <footer>
        CST336 Internet Programming Team Project: Fantasy Shop. 2018
    </footer>
</html>