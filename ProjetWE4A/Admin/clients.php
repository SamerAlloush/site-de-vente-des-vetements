<?php
    session_start();
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE){

        include('../connectionuser.php');  
        include('../functions.php');
        include('admin_functions.php');

        if(isset($_POST['backproducts'])){
            header('Location: index.php?page=products');
            exit;
        }

        $_SESSION['clients'] = array();
        $query = "SELECT * FROM user ";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);



        foreach ($result as $cl) {
            $id = (int)$cl['id'];
            $name = $cl['name'];
            $_SESSION['clients'][$id] = $name;
        }

        // Check the session variable for products in cart
        $clients_in_site = isset($_SESSION['clients']) ? $_SESSION['clients'] : array();
        $clients = array();
        $subtotal = 0.00;

        if ($clients_in_site) {
            $ids = array_keys($clients_in_site);
            $idPlaceholders = implode(',', array_fill(0, count($ids), '?'));

            // Assuming $con is your MySQLi connection object
            $sql = "SELECT * FROM user WHERE id IN ($idPlaceholders)";
            
            $stmt = $con->prepare($sql);

            if (!$stmt) {
                die("Prepare failed: " . $con->error);
            }

            // Bind the parameters (the IDs)
            $paramTypes = str_repeat('i', count($ids));
            $stmt->bind_param($paramTypes, ...$ids);

            if (!$stmt->execute()) {
                die("Execute failed: " . $stmt->error);
            }

            $result = $stmt->get_result();

            // Fetch the products from the database and return the result as an array
            while ($row = $result->fetch_assoc()) {
                $clients[] = $row;
            }


            // Calculate the subtotal
            foreach ($clients as $client) {
                $subtotal += (int)$client['access'];
            }
        }

        $total_clients = mysqli_query($con, 'SELECT * FROM user');
        $rowCount = mysqli_num_rows($total_clients);

?>



<?=admin_header('Clients')?>

<div class="cart content-wrapper">
    <h1>Clients</h1>
    <p><?=$rowCount?> Clients</p>
    <form action="index.php?page=clients" method="post">
        <table>
            <thead>
                <tr>
                    <td>Name</td>
                    <td>Address</td>
                    <td>Email</td>
                    <td>Orders</td>
                    <td>Visits</td>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($clients)): ?>
                <tr>
                    <td colspan="5" style="text-align:center;">You have no clients</td>
                </tr>
                <?php else: ?>
                <?php foreach ($clients as $client): ?>
                <tr>
                    <td>
                        <?=$client['name']?>
                    </td>
                    <td>
                        <?=$client['address']?>      
                    </td>
                    <td><?=$client['email']?></td>
                    <td><?=$client['nborder']?></td>
                    <td><?=$client['access']?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="subtotal">
            <span class="text">Total number of visits</span>
            <span class="price"><?=$subtotal?></span>
        </div>
        
    </form>
</div>

<?=template_footer()?>

<?php
    }
    else{
        echo"<h1>You can not access this page!!</h1>";
        //header( "url=index.php?page=login" );
    }
?>