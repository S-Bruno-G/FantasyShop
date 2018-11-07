<?php
    include 'dbConnectionFS.php';
    $dbConn = startConnection("fantasyShop");
    
    // used to display categories for dropdown
    function displayCategories() { 
        global $dbConn;
        
        $sql = "SELECT * FROM fs_category ORDER BY catName";
        $stmt = $dbConn->prepare($sql);
        $stmt->execute();
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($records as $record) {
            echo "<option value='".$record['catId']."'>" .$record['catName']. "</option>";
        }
    }
    
    function filterProducts() {
        global $dbConn;
        
        $namedParameters = array();
        $product = $_GET['productName'];
      
        $sql = "SELECT * FROM fs_product WHERE 1"; //Gettting all records from database
        
        if (!empty($product)){
            //This SQL prevents SQL INJECTION by using a named parameter
             $sql .=  " AND productName LIKE :product OR productDescription LIKE :product";
             $namedParameters[':product'] = "%$product%";
        }
        
        if (!empty($_GET['category'])){
            //This SQL prevents SQL INJECTION by using a named parameter
             $sql .=  " AND catId =  :category";
              $namedParameters[':category'] = $_GET['category'] ;
        }
        
        if (!empty($_GET['priceFrom'])){
            //This SQL prevents SQL INJECTION by using a named parameter
             $sql .=  " AND price >=  :priceFrom";
              $namedParameters[':priceFrom'] = $_GET['priceFrom'] ;
        }
        
        if (!empty($_GET['priceTo'])){
            //This SQL prevents SQL INJECTION by using a named parameter
             $sql .=  " AND price <=  :priceTo";
              $namedParameters[':priceTo'] = $_GET['priceTo'] ;
        }
        
        
        if (isset($_GET['orderBy'])) {
        if ($_GET['orderBy'] == "low-high") {
            $sql .= " ORDER BY price ASC";
        } else if ($_GET['orderBy'] == "high-low"){
                
                $sql .= " ORDER BY price DESC";
            }else if($_GET['orderBy'] == "az"){
                $sql .= " ORDER BY productName ASC";
            }else{
                $sql .= " ORDER BY productName DESC";
            }
    }
    
        $stmt = $dbConn->prepare($sql);
        $stmt->execute($namedParameters);
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);  
        //print_r($records);
        
        echo "<table class='table'>";
        foreach ($records as $record) {
            
            //echo "<hr width='75%'>";
            echo "<tr>";
            echo "<td><img src='" . $record['productImage'] . "'  width='100px'></td>";
            echo "<td><h2><a href='purchaseHistory.php?productId=".$record['productId']."'>";
            echo $record['productName'];
            echo "</a><h2></td>";
            echo "<td><h2>Price: $" .$record['price']. "</h2></td>";
            
            echo "<td><form method ='post'>";
            echo "<input type='hidden' name = itemName value='". $record['productName'] ."'>";
            echo "<input type='hidden' name = itemPrice value='". $record['price'] ."'>";
            echo "<input type='hidden' name = itemImage value='". $record['productImage'] ."'>";
            echo "<input type='hidden' name = itemId value='". $record['productId'] ."'>";
            if ($_POST['itemId'] == $record['productId']) {
            
            echo "<button class='btn btn-success'>Added</button>";
            } else {
            echo "<button class='btn btn-warning'>Add</button>";
            }
            echo "</form></td>";
            
            
            echo "</tr>";
            
        }
        
        echo "</table>";
    }
    
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
        
        $amount = $records[0]['quantity'];
        $price = $records[0]['price'];
        $date = $records[0]['purchaseDate'];
        
        echo "<img src='" . $records[0]['productImage'] . "'  width='30%'>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        if (empty($records[0]['purchaseId'])) {
            echo "<h3> Product hasn't been purchased yet </h3>";
            $amount = "N/A";
            //$price = 0;
            $date = "N/A";
        }
        
        echo "<center>";
        echo "<table id='productHistory'>";
        
        //echo "<th>Description-</th><th>Quantity-</th><th>Unit Price-</th><th>Purchase Date</th>";
        foreach ($records as $record) {
            echo "<tr>";
            echo "<th>Product Name:</th>";
            echo "<td>".$record[productName]."</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th>Description:</th>";
            echo "<td>".$record[productDescription]."</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th>Purchase Qty:</th>";
            echo "<td>".$amount."</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th>Unit Price:</th>";
            echo "<td>$".$price."</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th>Purchase Date:</th>";
            echo "<td>".$date."</td>";
            echo "</tr>";  
        }
        echo "</table>";
        echo "</center>";
        
        //print_r($records);
        
    }
    
    
    function displayCart() {
        if (isset($_SESSION['cart'])) {
            
            echo "<table class='table'>";
            foreach ($_SESSION['cart'] as $item) {
                $itemName = $item['name'];
                $itemPrice = $item['price'];
                $itemImage = $item['image'];
                $itemId = $item['id'];
                $itemQuant = $item['quantity'];
                echo "<tr>";
                
                echo "<td><img src='$itemImage' width='100px'></td>";
                echo "<td><h4>$itemName</h4></td>";
                echo "<td><h4>$itemPrice</h4></td>";
                
                echo "<form method= 'post'>";
                echo "<input type='hidden' name='itemId' value ='$itemId'>";
                echo "<td><input type='number' name='update' min='1' placeHolder = '$itemQuant'></td>";
                echo "<td><button class='btn btn-danger'>Update</button></td>";
                echo "</form>";
                
                echo "<form method= 'post'>";
                echo "<input type='hidden' name='removeId' value ='$itemId'>";
                echo "<td><button class='btn btn-danger'>Remove</button></td>";
                echo "</form>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }
    
    function displayCartCount() {
        
        //number of items, not including duplicates
        echo count($_SESSION['cart']);
        
        
        //number of items, including duplicates
        $total = 0;
        
        if (isset($_SESSION['cart'])){
        foreach ($_SESSION['cart'] as $item)
        {
            $total += $item['quantity'];
        }}
        
        echo " (". $total . ")";
    }
?>