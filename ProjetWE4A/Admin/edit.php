<?php
session_start();
include('../functions.php');
include('admin_functions.php');
include('../connectionuser.php'); 


if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE){

// The amounts of products to show on each page
$num_products_on_each_page = 8;
// The current page - in the URL, will appear as index.php?page=products&p=1, index.php?page=products&p=2, etc...
$current_page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
// Select products ordered by the date added
// $stmt = $pdo->prepare('SELECT * FROM products ORDER BY dateadded DESC LIMIT ?,?');
// // bindValue will allow us to use an integer in the SQL statement, which we need to use for the LIMIT clause

// $stmt->bindValue(1, ($current_page - 1) * $num_products_on_each_page, PDO::PARAM_INT);
// $stmt->bindValue(2, $num_products_on_each_page, PDO::PARAM_INT);
// $stmt->execute();

// // Fetch the products from the database and return the result as an Array
// $products = $stmt->fetchAll(PDO::FETCH_ASSOC);


// $query = "SELECT * FROM products ORDER BY dateadded DESC LIMIT ?, ?";
// $stmt = $con->prepare($query);

// $stmt->bind_param("ii", ($current_page - 1) * $num_products_on_each_page, $num_products_on_each_page);
// $stmt->execute();
// $result = $stmt->get_result();

// $products = array();
// while ($row = $result->fetch_assoc()) {
//     $products[] = $row;
// }

$query = "SELECT * FROM products ORDER BY dateadded DESC LIMIT ?, ?";
$stmt = $con->prepare($query);

$offset = ($current_page - 1) * $num_products_on_each_page;
$stmt->bind_param("ii", $offset, $num_products_on_each_page);
$stmt->execute();

$result = $stmt->get_result();

$products = array();
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

// $stmt->close();




// Get the total number of products
// $total_products = $pdo->query('SELECT * FROM products')->rowCount();

$query = "SELECT COUNT(*) as total FROM products";
$result = $con->query($query);

if ($result !== false) {
    $row = $result->fetch_assoc();
    $total_products = $row['total'];
} else {
    // Handle the error, e.g., using mysqli_error($con)
}

?>



<?=admin_header('Edit')?>

<div class="products content-wrapper">
    <h1>Products</h1>
    <p><?=$total_products?> Products</p>
    <div class="products-wrapper">
        <?php foreach ($products as $product): ?>
        <a href="editproduct.php?id=<?=$product['id']?>" class="product">
            <img src="../imgs/<?=$product['image']?>" width="200" height="200" alt="<?=$product['name']?>">
            <span class="name"><?=$product['name']?></span>
            <span class="price">
                &dollar;<?=$product['price']?>
                <!-- <?php if ($product['rrp'] > 0): ?>
                <span class="rrp">&dollar;<?=$product['rrp']?></span>
                <?php endif; ?> -->
            </span>
        </a>
        <?php endforeach; ?>
    </div>
    <div class="buttons">
        <?php if ($current_page > 1): ?>
        <a href="edit.php?p=<?=$current_page-1?>">Prev</a>
        <?php endif; ?>
        <?php if ($total_products > ($current_page * $num_products_on_each_page) - $num_products_on_each_page + count($products)): ?>
        <a href="edit.php?p=<?=$current_page+1?>">Next</a>
        <?php endif; ?>
    </div>
</div>

<?=template_footer()?>

<?php
}
else{
    echo"<h1>You can not access this page!!</h1>";
    //header( "url=index.php?page=login" );
}
?>