<?php
session_start();
include('../functions.php');
include('admin_functions.php');
include('../connectionuser.php'); 

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE){

if(isset($_POST['backproducts'])){
    header('Location: index.php?page=products');
    exit;
}

// $queryorders = "SELECT * FROM confirmorder ORDER BY orderid ";
// $stmt = $pdo->prepare($queryorders);
// $stmt->execute();
// $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

$queryorders = "SELECT * FROM confirmorder ORDER BY orderid";
$result = $con->query($queryorders);

if ($result !== false) {
    $orders = array();
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
    //$result->free();
}


// $_SESSION['orders'] = array();
// $query = "SELECT * FROM placingorder ORDER BY orderdate DESC";
// $stmt = $pdo->prepare($query);
// $stmt->execute();
// $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total_orders = mysqli_query($con, 'SELECT * FROM confirmorder');
$rowCount = mysqli_num_rows($total_orders);
// $subtotal = 0;

$querysubtotal = "SELECT SUM(quantity*price) AS total FROM orderdetails";
$subtotalResult = mysqli_query($con, $querysubtotal);
$subtotalRow = mysqli_fetch_assoc($subtotalResult);
$subtotal = $subtotalRow['total'];


?>



<?=admin_header('Orders')?>
<body>
<div class="cart content-wrapper">
    <h1>Orders</h1>
    <b><p><?=$rowCount?> Orders</p>
            <span class="text">SUBTOTAL : </span>
            <span class="price">&dollar;<?=$subtotal?></span></b>
        <table>
            <thead>
                <tr>
                    <td>Order ID</td>
                    <td>Order Date</td>
                    <td>Name</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($orders)): ?>
                    <tr>
                        <td colspan="6" style="text-align:center;">There are no orders</td>
                    </tr>
                <?php else: ?>
                <?php foreach ($orders as $o): ?>
                    <tr>
                        <td>
                            <?=$o['orderid']?>
                        </td>
                        <td>
                            <?=$o['orderdate']?>
                        </td>
                        <td>
                            <?php
                                $id = $o['clientid'];
                                $query = "SELECT name FROM user WHERE id = ?";
                                $stmt = $con->prepare($query);
                                if ($stmt) {
                                    $stmt->bind_param("i", $id);
                                    $stmt->execute();
                                    $stmt->bind_result($name);
                                    $stmt->fetch();
                                    $stmt->close();
                                } else {
                                    // Handle the error if the statement preparation fails
                                    echo "Error preparing statement: " . $con->error;
                                }

                            ?>      
                            <?=$name?>
                        </td>
                        <td>
                            <div class="buttons">
                                <a href="orderdetails.php?id=<?=$o['orderid']?>&name=<?=$name?>"><input type="submit" name="details_<?=$o['orderid']?>" value="Details"></a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>        
</div>
</body>
</html>

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

    if(isset($_POST['backproducts'])){
        header('Location: index.php?page=products');
        exit;
    }

    // $queryorders = "SELECT * FROM confirmorder ORDER BY orderid ";
    // $stmt = $pdo->prepare($queryorders);
    // $stmt->execute();
    // $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $queryorders = "SELECT orderid, orderdate FROM orderdetails GROUP BY orderid ORDER BY orderid";
    $result = $con->query($queryorders);

    // Check if the query was successful
    if (!$result) {
        die("Query failed: " . $con->error);
    }

    // Fetch the results as an associative array
    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }

    // $_SESSION['orders'] = array();
    // $query = "SELECT * FROM placingorder ORDER BY orderdate DESC";
    // $stmt = $pdo->prepare($query);
    // $stmt->execute();
    // $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $total_orders = mysqli_query($con, 'SELECT * FROM orderdetails GROUP BY orderid');
    $rowCount = mysqli_num_rows($total_orders);
    // $subtotal = 0;

    $querysubtotal = "SELECT SUM(quantity*price) AS total FROM orderdetails";
    $subtotalResult = mysqli_query($con, $querysubtotal);
    $subtotalRow = mysqli_fetch_assoc($subtotalResult);
    $subtotal = $subtotalRow['total'];

?> -->



<!-- <?=admin_header('Orders')?>
<body>
<div class="cart content-wrapper">
    <h1>Orders</h1>
    <b><p><?=$rowCount?> Orders</p>
            <span class="text">SUBTOTAL : </span>
            <span class="price">&dollar;<?=$subtotal?></span></b>
        <table>
            <thead>
                <tr>
                    <td>Order ID</td>
                    <td>Order Date</td>
                    <td>Name</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($orders)): ?>
                    <tr>
                        <td colspan="6" style="text-align:center;">There are no orders</td>
                    </tr>
                <?php else: ?>
                <?php foreach ($orders as $o): ?>
                    <tr>
                        <td>
                            <?=$o['orderid']?>
                        </td>
                        <td>
                            <?=$o['orderdate']?>
                        </td>
                        <td>
                            <?php
                                // $stmt = $pdo->prepare("SELECT name FROM user WHERE id = ?");
                                // $stmt->execute([$o['clientid']]);
                                // $name = $stmt->fetchColumn();

                                $id = $o['idclient'];
                                $query = "SELECT name FROM user WHERE id = ?";
                                $stmt = $con->prepare($query);
                                $stmt->bind_param("i", $id);
                                $stmt->execute();
                                $stmt->bind_result($name);
                                $stmt->fetch();
                                $stmt->close();

                            ?>      
                            <?=$name?>
                        </td>
                        <td>
                            <div class="buttons">
                            <a href="orderdetails.php?id=<?=$o['orderid']?>&name=<?=$name?>"><input type="submit" name="details_<?=$o['orderid']?>" value="Details"></a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>        
</div>
</body>
</html>

<?=template_footer()?>

<?php
    }
    else{
        echo"<h1>You can not access this page!!</h1>";
        //header( "url=index.php?page=login" );
    }
?> -->
