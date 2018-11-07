<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel='stylesheet' href='css/styles.css' type='text/css' />
        <title>Shopping Cart</title>
    </head>
    <?php
    session_start();
    include 'functions.php';
    if (isset($_POST['eraseCart'])) {
        unset($_SESSION['cart']);
        $_SESSION['cart'] = array();
    }
    
    if (isset($_POST['removeId'])) {
        foreach ($_SESSION['cart'] as $itemKey => $item) {
            if ($item['id'] == $_POST['removeId']) {
                unset($_SESSION['cart'][$itemKey]);
            }
        }
    }
    
    if (isset($_POST['itemId'])) {
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $_POST['itemId']) {
                if ($_POST['update'] != "")
                {$item['quantity'] = $_POST['update'];}
            }
        }
    }
    
    
    
    ?>
    <body>
        <div class='container'>
            <div class='text-center'>
                
                <!-- Bootstrap Navagation Bar -->
                <nav class='navbar navbar-default - navbar-fixed-top'>
                    <div class='container-fluid'>
                        <div class='navbar-header'>
                            <a class='navbar-brand' href='#'>Fantasy Shop</a>
                        </div>
                        <ul class='nav navbar-nav'>
                        <li><a href='index.php'>Home</a></li>
                        <li><a href='scart.php'>
                            <span class='glyphicon glyphicon-shopping-cart' aria=hidden='true'>
                            </span> Cart: <?php displayCartCount(); ?></a></li>
                    </ul>
                    </div>
                </nav>
                <br /> <br /> <br />
                <img src="https://fontmeme.com/permalink/181105/4a00f79cfe7a04a29bbd1289d37dd1ca.png" alt="dragon-ball-z-font" border="0">
                <h2>Shopping Cart</h2>
                <!-- Cart Items -->
                <?php
                if (isset($_SESSION['cart'])) {
                    echo "<form method= 'post'>";
                    echo "<input type='hidden' name='eraseCart' value ='eraseCart'>";
                    echo "<button class='btn btn-danger'>Erase Cart</button>";
                    echo "</form>";
                    
                    echo "<h3>";
                    displayCartCount();
                    echo "</h3>";
                    
                    displayCart();
                }
                
                
                
                ?>
            </div>
        </div>
    </body>
    <hr id='bottom' width='100%' size='10px' color='#a6a6a6'>
    <footer>
        CST336 Internet Programming Team Project: Fantasy Shop. 2018
    </footer>
</html>