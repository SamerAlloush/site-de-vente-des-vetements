<?php
    include('../functions.php');
    include('admin_functions.php');

    session_start();

    // Change this to your connection info.
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'shoppingonline';
    // Try and connect using the info above.
    $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    if ( mysqli_connect_errno() ) {
        // If there is an error with the connection, stop the script and display the error.
        exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }

    // Remove product from cart, check for the URL param "remove", this is the product id, make sure it's a number and check if it's in the cart
    if (isset($_GET['remove']) && is_numeric($_GET['remove'])) {
        // Remove the product from the shopping cart
        unset($_GET['remove']);
    }

    // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
    if ($stmt = $con->prepare('SELECT id, password FROM admin WHERE name = ?')) {
        // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
        $stmt->bind_param('s', $_POST['uname']);
        $stmt->execute();
        // Store the result so we can check if the account exists in the database.
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $password);
            $stmt->fetch();
            // Account exists, now we verify the password.
            // Note: remember to use password_hash in your registration file to store the hashed passwords.
            if ($_POST['psw'] === $password) {
                // Verification success! User has logged-in!
                // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
                session_regenerate_id();
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['name'] = $_POST['uname'];
                $_SESSION['id'] = $id;

                $sql = "SELECT * FROM products ORDER BY dateadded DESC";
                $result = $con->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $products[] = $row;
                    }
                } else {
                    echo "0 results";
                }

                // Get the total number of products
                $sql = "SELECT * FROM products";
                $result = $con->query($sql);
                if ($result) {
                    $total_products = $result->num_rows;
                } else {
                    die("Query failed: " . $mysqli->error);
                }
?>

<?=admin_header('Admin')?>
    <form action="admin.php" method="post">
        
        <h1 align="center" style="font-size: x-large;" ><b>Welcome <?=$_SESSION['name']?>  </b></h1>
        
        <div class="products content-wrapper">
            <p><?= $total_products?> Products</p>
            <div class="products-wrapper">
                <?php foreach ($products as $product): ?>
                <!-- <a href="index.php?page=admin&id=<?=$product['id']?>" class="product"> -->
                <div class="product">
                    <!-- <a href="index.php?page=admin" class="remove"><button>Remove</button></a> -->
                    <br>
                    <img src="../imgs/<?=$product['image']?>" width="200" height="200" alt="<?=$product['name']?>">
                    <span class="name"><?=$product['name']?></span>
                    <span class="price">
                        &dollar;<?=$product['price']?>
                        <!-- <?php if ($product['rrp'] > 0): ?>
                        <span class="rrp">&dollar;<?=$product['rrp']?></span>
                        <?php endif; ?> -->
                    </span>
                </div>
                <!-- </a> -->
                <?php endforeach; ?>
            </div>
        </div>
    </form>

<?=template_footer()?>

<?php

        } else {
            //header('Location: index.php?page=login');
            // Incorrect password
            echo 'Incorrect username and/or password!';
            header( "refresh:3;url=index.php?page=login" );
        }
    } else {
        // Incorrect username
        echo 'There is no such record ';
        header( "refresh:3;url=index.php?page=login" );
    }

	//$stmt->close();
}
?>




















