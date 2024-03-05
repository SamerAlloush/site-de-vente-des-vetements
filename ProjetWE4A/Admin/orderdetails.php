<?php
session_start();
include('../functions.php');
include('admin_functions.php');
include('../connectionuser.php'); 

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE){

if (isset($_GET['id'])) {
    // $querydetails = "SELECT * FROM orderdetails WHERE orderid = '".$_GET['id']."'";
    // $stmt = $pdo->prepare($querydetails);
    // $stmt->execute();
    // $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $orderid = $_GET['id'];
    $querydetails = "SELECT * FROM orderdetails WHERE orderid = '$orderid'";
    $result = $con->query($querydetails);

    if ($result !== false) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        //$result->free();
    } 

}
$ordertotal = 0;

if(isset($_POST['backorders'])){
    header('Location: orders.php');
    exit;
}
?>

<?=admin_header('Orders')?>

<body>
    
<form method="post">

    <div class="container">
    <div class="cart content-wrapper">
    <h1>Order Details</h1>
    <p><b>Order Number <?=$_GET['id']?> done by <?=$_GET['name']?></b></p>
    <form method="post">
        <table>
            <thead>
                <tr>
                    <td colspan="2">Product</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td><b>Total</b></td>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($result)): ?>
                    <tr>
                        <td colspan="4" style="text-align:center;">There are no orders</td>
                    </tr>
                <?php else: ?>
                <?php foreach ($result as $r): ?>
                    <tr>
                        <td>
                        <?php
                                // $stmt = $pdo->prepare("SELECT image FROM products WHERE id = ?");
                                // $stmt->execute([$r['productid']]);
                                // $image = $stmt->fetchColumn();
                                // if ($stmt->rowCount() == 0) {
                                //     $stmt = $pdo->prepare("SELECT image FROM finishedproducts WHERE id = ?");
                                //     $stmt->execute([$r['productid']]);
                                //     $image = $stmt->fetchColumn();
                                // }                               

                                $productid = $r['productid'];
                                $query = "SELECT image FROM products WHERE id = ?";
                                $stmt = $con->prepare($query);
                                $stmt->bind_param("i", $productid);
                                $stmt->execute();
                                $image = $stmt->get_result()->fetch_assoc();

                                if (!$image) {
                                    // If the first query didn't return any results, try the second query
                                    $query = "SELECT image FROM finishedproducts WHERE id = ?";
                                    $stmt = $con->prepare($query);
                                    $stmt->bind_param("i", $productid);
                                    $stmt->execute();
                                    $image = $stmt->get_result()->fetch_assoc();
                                }

                                // Check if $image is still empty and handle the case accordingly
                                if (empty($image)) {
                                    // Handle the case when no image is found
                                }

                            ?>   
                        <img src="../imgs/<?=$image?>" width="50" height="50" alt="<?=$product['name']?>">

                        </td>
                        <td>
                        <?php
                                // $stmt = $pdo->prepare("SELECT name FROM products WHERE id = ?");
                                // $stmt->execute([$r['productid']]);
                                // $prod = $stmt->fetchColumn();
                                // if ($stmt->rowCount() == 0) {
                                //     $stmt = $pdo->prepare("SELECT name FROM finishedproducts WHERE id = ?");
                                //     $stmt->execute([$r['productid']]);
                                //     $prod = $stmt->fetchColumn();
                                // }        
                                
                                $productid = $r['productid'];
                                $query = "SELECT name FROM products WHERE id = ?";
                                $stmt = $con->prepare($query);
                                $stmt->bind_param("i", $productid);
                                $stmt->execute();
                                $stmt->store_result();

                                if ($stmt->num_rows == 0) {
                                    // If the first query didn't return any results, try the second query
                                    $query = "SELECT name FROM finishedproducts WHERE id = ?";
                                    $stmt = $con->prepare($query);
                                    $stmt->bind_param("i", $productid);
                                    $stmt->execute();
                                    $stmt->store_result();
                                }

                                if ($stmt->num_rows > 0) {
                                    $stmt->bind_result($prod);
                                    $stmt->fetch();
                                } else {
                                    // Handle the case when no name is found
                                }

                            ?>      
                            <?=$prod?> 
                        </td>
                        <td>     
                            <?=$r['price']?>
                        </td>
                        <td>
                            <?=$r['quantity']?>
                        </td>
                        <td>
                            <?php    
                                $tot = $r['price'] * $r['quantity'];
                                $ordertotal += $tot;
                            ?>
                            <b><?=$tot?></b>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="subtotal">
            <span class="text">Order's Total</span>
            <span class="price">&dollar;<?=$ordertotal?></span>
        </div>
        <div class="buttons">
            <input type="submit" value="Back to Orders" name="backorders">
        </div>        
    </form>
</div>    
    </div>


  </form>
</body>
<?=template_footer()?>

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
include('../connectionuser.php'); 

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE){

if (isset($_GET['id'])) {
    // $querydetails = "SELECT * FROM orderdetails WHERE orderid = '".$_GET['id']."'";
    // $stmt = $pdo->prepare($querydetails);
    // $stmt->execute();
    // $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $id = $_GET['id'];
    $querydetails = "SELECT * FROM orderdetails WHERE orderid = '$id'";
    $result = $con->query($querydetails);

    if ($result !== false) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        // $result->free();
    }

}
$ordertotal = 0;

if(isset($_POST['backorders'])){
    header('Location: index.php?page=orders');
    exit;
}
?>

<?=admin_header('Orders')?>

<body>
    
<form method="post">

    <div class="container">
    <div class="cart content-wrapper">
    <h1>Order Details</h1>
    <p><b>Order Number <?=$_GET['id']?> done by <?=$_GET['name']?></b></p>
    <form method="post">
        <table>
            <thead>
                <tr>
                    <td colspan="2">Product</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td><b>Total</b></td>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($result)): ?>
                    <tr>
                        <td colspan="4" style="text-align:center;">There are no orders</td>
                    </tr>
                <?php else: ?>
                <?php foreach ($result as $r): ?>
                    <tr>
                        <td>
                        <?php
                                // $stmt = $pdo->prepare("SELECT image FROM products WHERE id = ?");
                                // $stmt->execute([$r['productid']]);
                                // $image = $stmt->fetchColumn();

                                $productid = $r['productid'];
                                $query = "SELECT image FROM products WHERE id = ?";
                                $stmt = $con->prepare($query);
                                $stmt->bind_param("i", $productid);
                                $stmt->execute();
                                $stmt->bind_result($image);
                                $stmt->fetch();
                                //$stmt->close();

                                // if ($stmt->rowCount() == 0) {
                                //     $stmt = $pdo->prepare("SELECT image FROM finishedproducts WHERE id = ?");
                                //     $stmt->execute([$r['productid']]);
                                //     $image = $stmt->fetchColumn();
                                // }                               
                            ?>   
                        <img src="../imgs/<?=$image?>" width="50" height="50" alt="<?=$product['name']?>">
                        </td>
                        <td>
                        <?php
                                // $stmt = $pdo->prepare("SELECT name FROM products WHERE id = ?");
                                // $stmt->execute([$r['productid']]);
                                // $prod = $stmt->fetchColumn();
                                $productid = $r['productid'];
                                $query = "SELECT name FROM products WHERE id = ?";
                                $stmt = $con->prepare($query);
                                $stmt->bind_param("i", $productid);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $row = $result->fetch_assoc();
                                $prod = $row['name'];

                                //$stmt->close();

                                // if ($stmt->rowCount() == 0) {
                                //     $stmt = $pdo->prepare("SELECT name FROM finishedproducts WHERE id = ?");
                                //     $stmt->execute([$r['productid']]);
                                //     $prod = $stmt->fetchColumn();
                                // }                               
                            ?>      
                            <?=$prod?> 
                        </td>
                        <td>     
                            <?=$r['price']?>
                        </td>
                        <td>
                            <?=$r['quantity']?>
                        </td>
                        <td>
                            <?php    
                                $tot = $r['price'] * $r['quantity'];
                                $ordertotal += $tot;
                            ?>
                            <b><?=$tot?></b>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="subtotal">
            <span class="text">Order's Total</span>
            <span class="price">&dollar;<?=$ordertotal?></span>
        </div>
        <div class="buttons">
            <input type="submit" value="Back to Orders" name="backorders">
        </div>        
    </form>
</div>    
    </div>


  </form>
</body>
<?=template_footer()?>

<?php
}
else{
    echo"<h1>You can not access this page!!</h1>";
    //header( "url=index.php?page=login" );
}
?> -->