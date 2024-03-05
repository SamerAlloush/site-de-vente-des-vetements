<head>

</head> 
<?php

function pdo_connect_mysql() {

    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'shoppingonline';
    try {
    	return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
    	// If there is an error with the connection, stop the script and display the error.
    	exit('Failed to connect to database!');
    }
 
}

function template_header($title) {
    // Get the number of items in the shopping cart, which will be displayed in the header.
    $num_items_in_cart = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
echo <<<EOT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>$title</title>
		<link href="style/style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script>
        $(document).ready(function(){
            $("#search").click(function(){
                $.ajax({
                    url:"liste_noms.php",
                    type:"get",
                    data:{product:$(this).val()},
                    success:function(reponse_serveur){
                        
                        $("#tableproducts").html(reponse_serveur);
                    }
                });
            });
        });
        </script>

	</head>
	<body>
        <header>
            <div class="content-wrapper">
                <h1>Z&&A SHOP</h1>
                <nav>
                    <a href="index.php?page=home">Home</a>
                    <a href="index.php?page=products">Products</a>

                    <a href="index.php?page=women">Women</a>
                    <a href="index.php?page=men">Men</a>
                
                    <select id="search" name="search">
                        <option value="Search">Searh a product</option>
                        <option value="Pants">Pants</option>
                        <option value="Shirts">Shirts</option>
                        <option value="TShirts">TShirts</option>
                        <option value="Skirt">Skirt</option>
                        <option value="Dress">Dress</option>
                        <option value="Top">Top</option>
                        <option value="Short">Short</option>
                        <option value="Jackets">Jackets</option>
                    </select>
                    

                </nav>
                <div class="link-icons">
                    <a href="index.php?page=sortproducts">
                        <img src="imgs/filter.png" width="30px" height="30px">   
                    </a>    
                </div>
                <div class="link-icons">
                    <a href="index.php?page=cart">
						<i class="fas fa-shopping-cart"></i>
                        <span>$num_items_in_cart</span>
					</a>
                </div>
                <div class="link-icons">
                    <a href="index.php?page=favorites">
                        <img src="imgs/heart.png" width="30px" height="30px">
                    </a>
                </div>
                <div class="link-icons">
                    <a href="index.php?page=historique">
                        <img src="imgs/historique.png" width="30px" height="30px">
                    </a>
                </div>
                <div class="link-icons">
EOT;

                if (isset($_SESSION['id'])) {
                    echo <<<EOT
                                <a href="index.php?page=logout">
                                    <img src="imgs/logout.png" width="30px" height="30px">
                                </a>
EOT;
                } else {
                    echo <<<EOT
                                <a href="signup.php">
                                    <img src="imgs/myprofile.png" width="30px" height="30px">
                                </a>
EOT;
                }
            
                echo <<<EOT
                            </div>
                        </div>
                    </header>
                    <main>
EOT;
            }


// Template footer
function template_footer() {
$year = date('Y');
echo <<<EOT
        </main>
        <footer>
            <div class="content-wrapper">
                <p>&copy; $year, Z&&S SHOP</p>
                Follow Us On <i class="fab fa-facebook"></i> <i class="fab fa-github"></i> <i class="fab fa-instagram"></i> <i class="fab fa-linkedin"></i>
            </div>
        </footer>
    </body>
</html>
EOT;
}



?>