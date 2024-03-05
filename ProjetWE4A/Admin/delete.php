<?php
session_start();
include('../functions.php');
include('admin_functions.php');

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE){
//session_start();
// Change this to your connection info.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'shoppingonline';
// Try and connect using the info above.
$con = new PDO("mysql:host=$DATABASE_HOST;dbname=$DATABASE_NAME;charset=utf8", $DATABASE_USER, $DATABASE_PASS);
$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $insertquery = "INSERT INTO finishedproducts SELECT * FROM products WHERE id = ?";
    $stmt = $con->prepare($insertquery);
    $stmt->execute([$id]);
    
    $query = "DELETE FROM products WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->execute([$id]);
}

$stmt = $con->prepare('SELECT * FROM products ORDER BY dateadded DESC');
$stmt->execute();

// Fetch the products from the database and return the result as an Array
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of products
$total_products = $con->query('SELECT * FROM products')->rowCount();

?>

<head>
    <link href="../style/style.css" rel="stylesheet" type="text/css">
    <style>
    input[type="button"] {
	margin-left: 5px;
	padding: 12px 20px;
	border: 0;
	background: #4e5c70;
	color: #FFFFFF;
	font-size: 14px;
	font-weight: bold;
	cursor: pointer;
	border-radius: 5px;
}
    </style>
</head>

<?= admin_header('Delete') ?>
<form method="post">    
    <div class="products content-wrapper">  
        <p><?= $total_products ?> Products</p>
        <div class="products-wrapper">
            <?php foreach ($products as $product): ?>
                <div class="product">
                    <div class="buttons">
                        <a href="delete.php?id=<?= $product['id'] ?>">
                            <div style="display: flex; justify-content: center;">
                                <input type="button" name="delete" value="Remove">
                            </div>
                        </a>
                    </div>
                    <br>
                    <img src="../imgs/<?= $product['image'] ?>" width="200" height="200" alt="<?= $product['name'] ?>">
                    <span class="name"><?= $product['name'] ?></span>
                    <span class="price">
                        &dollar;<?= $product['price'] ?>
                    </span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</form>
<?= template_footer() ?>

<?php
}
else{
    echo"<h1>You can not access this page!!</h1>";
    //header( "url=index.php?page=login" );
}
?>



<!-- <?php
session_start();
include('../functions.php');
include('admin_functions.php');

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE){
//session_start();
// Change this to your connection info.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'shoppingonline';
// Try and connect using the info above.
$con = new PDO("mysql:host=$DATABASE_HOST;dbname=$DATABASE_NAME;charset=utf8", $DATABASE_USER, $DATABASE_PASS);
$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $insertquery = "UPDATE products SET status = 0 WHERE id=?";
    //$insertquery = "INSERT INTO finishedproducts SELECT * FROM products WHERE id = ?";
    $stmt = $con->prepare($insertquery);
    $stmt->execute([$id]);
    
    // $query = "DELETE FROM products WHERE id = ?";
    // $stmt = $con->prepare($query);
    // $stmt->execute([$id]);
}

$stmt = $con->prepare('SELECT * FROM products WHERE status = 1 ORDER BY dateadded DESC');
$stmt->execute();

// Fetch the products from the database and return the result as an Array
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of products
$total_products = $con->query('SELECT * FROM products WHERE status = 1')->rowCount();

?>

<?= admin_header('Delete') ?>
<form method="post">    
    <div class="products content-wrapper">  
        <p><?= $total_products ?> Products</p>
        <div class="products-wrapper">
            <?php foreach ($products as $product): ?>
                <div class="product">
                    <div class="buttons">
                        <a href="index.php?page=delete&id=<?= $product['id'] ?>">
                            <div style="display: flex; justify-content: center;">
                                <input type="button" name="delete" value="Remove">
                            </div>
                        </a>
                    </div>
                    <br>
                    <img src="../imgs/<?= $product['image'] ?>" width="200" height="200" alt="<?= $product['name'] ?>">
                    <span class="name"><?= $product['name'] ?></span>
                    <span class="price">
                        &dollar;<?= $product['price'] ?>
                    </span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</form>
<?= template_footer() ?>

<?php
}
else{
    echo"<h1>You can not access this page!!</h1>";
    //header( "url=index.php?page=login" );
}
?> -->
