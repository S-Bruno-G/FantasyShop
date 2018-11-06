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
        } else {
            
            $sql .= " ORDER BY price DESC";
        }
    }
    
        $stmt = $dbConn->prepare($sql);
        $stmt->execute($namedParameters);
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);  
        //print_r($records);
        //echo "<table>";
        foreach ($records as $record) {
            //echo "<tr>";
            echo "<hr width='75%'>";
            echo "<h2><a href='purchaseHistory.php?productId=".$record['productId']."'>";
            echo "<img src='" . $record['productImage'] . "'  width='4%'>";
            echo $record['productName'];
            echo "</a>";
            echo "Price: $" .$record['price']. "</h2>";
            //echo "</tr>";
        }
        //echo "</table>";
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
        $price = $records[0]['unitPrice'];
        $date = $records[0]['purchaseDate'];
        
        echo "<img src='" . $records[0]['productImage'] . "'  width='30%'>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        if (empty($records[0]['purchaseId'])) {
            echo "<h3> Product hasn't been purchased yet </h3>";
            $amount = "N/A";
            $price = 0;
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
    
?>