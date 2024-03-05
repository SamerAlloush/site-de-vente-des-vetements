<?php 
function admin_header($title) {
    // Get the number of items in the shopping cart, which will be displayed in the header.
    //$num_items_in_cart = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
echo <<<EOT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>$title</title>
		<link href="../style/style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
	</head>
	<body>
        <header>
            <div class="content-wrapper">
                    <h1>Z&&S DashBoard</h1>
                <div class="link-icons">
                    <a href="profile.php">
                        <img src="../imgs/myprofile.png" width="30px" height="30px">My Profile
                    </a>   
                        
                    <a href="clients.php">
                        <img src="../imgs/customer.png" width="30px" height="30px">Clients
                    </a>

                    <a href="orders.php">
                        <img src="../imgs/checkout.png" width="30px" height="30px">Orders
                    </a>
                
                    <a href="insert.php">
						<img src="../imgs/add-to-basket.png" width="30px" height="30px">Insert
                    </a>

                    <a href="delete.php">
                        <img src="../imgs/removeitem.png" width="30px" height="30px">Delete
                    </a>

                    <a href="edit.php">
                        <img src="../imgs/edit.png" width="30px" height="30px">Edit
					</a>
                </div>

                <div class="link-icons">
                    <a href="../index.php?page=logout">
						<img src="../imgs/logout.png" width="30px" height="30px">
					</a>
                </div>
            </div>
        </header>
        <main>
EOT;
}
?> 