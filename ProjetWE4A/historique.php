<?php
if(isset($_SESSION['id'])){
include('connectionuser.php');

if (isset($_POST['backproducts'])) {
    header('Location: index.php?page=products');
    exit;
}

$_SESSION['historique'] = array();
$query = "SELECT * FROM confirmorder, orderdetails WHERE confirmorder.orderid = orderdetails.orderid and confirmorder.clientid = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "s", $_SESSION['id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$idproducts = mysqli_fetch_all($result, MYSQLI_ASSOC);

$subtotal = 0;
?>
<?= template_header('Historique') ?>

<div class="cart content-wrapper">
    <h1>History</h1>
    <form action="index.php?page=historique" method="post">
        <table>
            <thead>
                <tr>
                    <td colspan="2">Product</td>
                    <td>Date</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Total</td>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($idproducts)): ?>
                    <tr>
                        <td colspan="6" style="text-align:center;">You have no products added in your History yet</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($idproducts as $product): ?>
                        <?php
                        $query = "SELECT * FROM products WHERE id = ?";
                        $stmt = mysqli_prepare($con, $query);
                        mysqli_stmt_bind_param($stmt, "s", $product['productid']);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        if (mysqli_num_rows($result) == 0) {
                            $query = "SELECT * FROM finishedproducts WHERE id = ?";
                            $stmt = mysqli_prepare($con, $query);
                            mysqli_stmt_bind_param($stmt, "s", $product['productid']);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                        }
                        $row = mysqli_fetch_assoc($result);
                        ?>
                        <tr>
                            <td class="img">
                                <a href="index.php?page=product&id=<?= $row['id'] ?>">
                                    <img src="imgs/<?= $row['image'] ?>" width="50" height="50" alt="<?= $row['name'] ?>">
                                </a>
                            </td>
                            <td>
                                <a href="index.php?page=product&id=<?= $row['id'] ?>"><?= $row['name'] ?></a>
                            </td>
                            <td><?= $product['orderdate'] ?></td>
                            <td class="price">
                            <?php
                                $queryid = "SELECT orderid FROM confirmorder WHERE orderdate = '".$product['orderdate']."' AND clientid = '".$_SESSION['id']."'";
                                $resultId = mysqli_query($con, $queryid);
                                $orderRow = mysqli_fetch_assoc($resultId);

                                if ($orderRow) {
                                    $orderid = $orderRow['orderid'];

                                    $queryprice = "SELECT price FROM orderdetails WHERE orderid = '".$orderid."' AND productid = '".$product['productid']."'";
                                    $resultPrice = mysqli_query($con, $queryprice);
                                    $priceRow = mysqli_fetch_assoc($resultPrice);

                                    if ($priceRow) {
                                        $price = $priceRow['price'];
                                        echo "&dollar;". $price;
                                    } else {
                                        $queryprice = "SELECT price FROM products WHERE id = '".$product['productid']."'";
                                        $resultPrice = mysqli_query($con, $queryprice);
                                        $priceRow = mysqli_fetch_assoc($resultPrice);

                                        if ($priceRow) {
                                            $price = $priceRow['price'];
                                            echo "&dollar;". $price;
                                        }
                                    }
                                } else {
                                    echo "Order ID not found.";
                                }
                            ?>

                            </td>
                            <td class="quantity">
                                <?= $product['quantity'] ?>
                            </td>
                            <td class="price">&dollar;<?= $row['price'] * $product['quantity'] ?></td>
                            <?php
                            $subtotal += $row['price'] * $product['quantity'];
                            ?>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="subtotal">
            <span class="text">Subtotal</span>
            <span class="price">&dollar;<?= $subtotal ?></span>
        </div>
        <div class="buttons">
            <input type="submit" value="Back to Products" name="backproducts">
        </div>
    </form>
</div>

<?= template_footer() ?>
<?php
}
else{
    echo"<h1>You can not access this page!!</h1>";
    //header( "url=index.php?page=login" );
}
?>
