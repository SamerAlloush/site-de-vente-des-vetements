<?php
if(isset($_SESSION['id'])){
// If the user clicked the add to cart button on the product page we can check for the form data
if (isset($_POST['idproduct'], $_POST['idquantity']) && is_numeric($_POST['idproduct']) && is_numeric($_POST['idquantity'])) {
    // Set the post variables so we easily identify them, also make sure they are integer
    $product_id = (int)$_POST['idproduct'];
    $quantity = (int)$_POST['idquantity'];

    // Prepare the SQL statement, we basically are checking if the product exists in our databaser
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$_POST['idproduct']]);
    // Fetch the product from the database and return the result as an Array
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    $id = (int)$_SESSION['id'];

    $stmt = $pdo->prepare('SELECT * FROM favorites WHERE idclient = '.$id.' and idproduit = '.$product_id.'');
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($row){}
    else{$stmt = $pdo->prepare("Insert into favorites values( ".$id."  ,  ".$product_id." )");
    $stmt->execute();}

    // Check if the product exists (array is not empty)
    if ($product && $quantity > 0) {
        // Product exists in database, now we can create/update the session variable for the cart
        if (isset($_SESSION['favorites']) && is_array($_SESSION['favorites'])) {
            if (array_key_exists($product_id, $_SESSION['favorites'])) {
                // Product exists in cart so just update the quanity
                $_SESSION['favorites'][$product_id] += $quantity;
            } else {
                // Product is not in cart so add it
                $_SESSION['favorites'][$product_id] = $quantity;
            }
        } else {
            // There are no products in cart, this will add the first product to cart
            $_SESSION['favorites'] = array($product_id => $quantity);
        }
    }
    // Prevent form resubmission...
    header('location: index.php?page=favorites');
    
    exit;
}






// Remove product from cart, check for the URL param "remove", this is the product id, make sure it's a number and check if it's in the cart
if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['favorites']) && isset($_SESSION['favorites'][$_GET['remove']])) {
    // Remove the product from the shopping cart
    unset($_SESSION['favorites'][$_GET['remove']]);

    $id = (int)$_SESSION['id'];
    $stmt = $pdo->prepare("DELETE FROM favorites WHERE idclient = ".$id."  and idproduit =  ".$_GET['remove']." ");
    $stmt->execute();
}





if(isset($_POST['backproducts'])){
    header('Location: index.php?page=products');
    exit;
}

// $id = (int)$_SESSION['id'];
// $stmt = $pdo->prepare("SELECT * FROM favorites WHERE idclient = ".$id." ");
// $stmt->execute();
// $idproducts = $stmt->fetch(PDO::FETCH_ASSOC);
// if($idproducts)
// {
//     foreach($idproducts as $prd)
//     {
//         echo"oui";
//         // $pr = (int)$prd['idproduit'];
//         // $cl = (int)$prd['idclient'];
//         // $_SESSION['favorites'] = array($pr => $cl);

//     }
// }




// Check the session variable for products in cart
$products_in_favorites = isset($_SESSION['favorites']) ? $_SESSION['favorites'] : array();
$products = array();
//$subtotal = 0.00;
// If there are products in cart
if ($products_in_favorites) {
    // There are products in the cart so we need to select those products from the database
    // Products in cart array to question mark string array, we need the SQL statement to include IN (?,?,?,...etc)
    $array_to_question_marks = implode(',', array_fill(0, count($products_in_favorites), '?'));
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id IN (' . $array_to_question_marks . ')');
    // We only need the array keys, not the values, the keys are the id's of the products
    $stmt->execute(array_keys($products_in_favorites));
    // Fetch the products from the database and return the result as an Array
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    
}
?>



<?=template_header('Favorites')?>

<div class="cart content-wrapper">
    <h1>Favorite List</h1>
    <form action="index.php?page=favorites" method="post">
        <table>
            <thead>
                <tr>
                    <td colspan="2">Product</td>
                    <td></td>
                    <td></td>
                    <td>Price</td>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                <tr>
                    <td colspan="5" style="text-align:center;">You have no products added in your Favorite List</td>
                </tr>
                <?php else: ?>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td class="img">
                        <a href="index.php?page=product&id=<?=$product['id']?>">
                            <img src="imgs/<?=$product['image']?>" width="50" height="50" alt="<?=$product['name']?>">
                        </a>
                    </td>
                    <td>
                        <a href="index.php?page=product&id=<?=$product['id']?>"><?=$product['name']?></a>
                        <br>
                        <a href="index.php?page=favorites&remove=<?=$product['id']?>" class="remove">Remove</a>
                    </td>
                    <td class="quantity">
                    </td>
                    <td></td>
                    <td class="price">&dollar;<?=$product['price']?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="buttons">
            <input type="submit" value="Back to Products" name="backproducts">
        </div>
    </form>
</div>

<?=template_footer()?>

<?php
}
else{
   // header('signup.php');
    header( "url=index.php?page=signup" );
}
?>