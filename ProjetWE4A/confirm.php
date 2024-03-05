<?php
// if(isset($_SESSION['id'])){
    include('connectionuser.php'); 
    include('functions.php');

    session_start();
    $id = $_SESSION['id'];
    $name = $_GET['name'];
    $email = $_GET['email'];
    $address = $_GET['address'];

    $sql1 = "update user set name = '$name' , email = '$email' , address = '$address' , nborder = nborder+1 where id = '$id'";  
    mysqli_query($con, $sql1); 

    // $sql2 = "select id from user where name = '$name' and email = '$email' and address = '$address'";  
    // $id = mysqli_query($con, $sql2); 
    
    // $neworder = "INSERT INTO confirmorder (clientid) VALUES (?)";
    // $stmtOrder = mysqli_prepare($con, $neworder);
    // mysqli_stmt_bind_param($stmtOrder, "i", $id);
    // mysqli_stmt_execute($stmtOrder);

    $neworder = "INSERT INTO confirmorder (clientid) VALUES ('$id')";
    mysqli_query($con, $neworder); 
    
    // Retrieve the recently inserted ID
    $orderId = mysqli_insert_id($con);

    foreach ($_SESSION['cart'] as $key => $value) {
        $idprod = $key;
        $quantite = $value;

        $sqlprice = "SELECT price FROM products WHERE id = ?";
        $stmtPrice = mysqli_prepare($con, $sqlprice);
        mysqli_stmt_bind_param($stmtPrice, "s", $idprod);
        mysqli_stmt_execute($stmtPrice);
        mysqli_stmt_bind_result($stmtPrice, $price);
        mysqli_stmt_fetch($stmtPrice);
        mysqli_stmt_close($stmtPrice);
        
        $insertproductsorder = "INSERT INTO orderdetails (orderid, productid, quantity, price) VALUES (?, ?, ?, ?)";
        $stmtOrderDetails = mysqli_prepare($con, $insertproductsorder);
        mysqli_stmt_bind_param($stmtOrderDetails, "iiid", $orderId, $idprod, $quantite, $price);
        mysqli_stmt_execute($stmtOrderDetails);
        mysqli_stmt_close($stmtOrderDetails);

        

        $sql = "UPDATE products SET quantity = quantity - ? WHERE id = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $quantite, $idprod);
        mysqli_stmt_execute($stmt);
        
    
        // $sqlInsert = "INSERT INTO placingorder(idclient, idproduit, quantity) VALUES (?, ?, ?)";
        // $stmtInsert = mysqli_prepare($con, $sqlInsert);
        // mysqli_stmt_bind_param($stmtInsert, "iii", $id, $idprod, $quantite);
        // mysqli_stmt_execute($stmtInsert);
    
        $query = "SELECT quantity FROM products WHERE id = ?";
        $stmtQuantity = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmtQuantity, "i", $idprod);
        mysqli_stmt_execute($stmtQuantity);
        $result = mysqli_stmt_get_result($stmtQuantity);
        $row = mysqli_fetch_assoc($result);
        $quantity = $row['quantity'];
    
        if ($quantity == 0) {
            $move = "INSERT INTO finishedproducts SELECT * FROM products WHERE id = ?";
            $stmtMove = mysqli_prepare($con, $move);
            mysqli_stmt_bind_param($stmtMove, "i", $idprod);
            mysqli_stmt_execute($stmtMove);
    
            $querydel = "DELETE FROM products WHERE id = ?";
            $stmtDelete = mysqli_prepare($con, $querydel);
            mysqli_stmt_bind_param($stmtDelete, "i", $idprod);
            mysqli_stmt_execute($stmtDelete);
        }
    }
    

    // $sqlInsert = "INSERT INTO placingorder(idclient,idproduit,quantity) SELECT * FROM cart where idclient = '$id'";
    // mysqli_query($con, $sqlInsert);    

    $sql4 = "delete from cart where idclient = '$id'";  
    mysqli_query($con, $sql4);

    unset($_SESSION['cart']);
  
    echo"<h1>Your Order Has Been Placed</h1>
    <h1>Thank you for ordering with us! We'll contact you by email with your order details.</h1> ";

// else{
//     echo"<h1>You can not access this page!!</h1>";
//     //header( "url=index.php?page=login" );
// }
?>