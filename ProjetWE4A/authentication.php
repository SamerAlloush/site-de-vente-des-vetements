<?php
    //include('index.php');
    include('connectionuser.php'); 
    $name = $_POST['name']; 
    $address = $_POST['address'];
    $email = $_POST['email']; 
    $password = $_POST['pass'];  

    
      
      
        $sql = "insert into user(name,address,password,email) values('$name','$address','$password','$email') ";  
        mysqli_query($con, $sql);  

        
        session_start();
        $result = mysqli_query($con, "SELECT id FROM user WHERE name = '$name' AND password = '$password'");
$row = mysqli_fetch_assoc($result);
$_SESSION['id'] = $row['id'];
$_SESSION['user'] = $name;
$_SESSION['pass'] = $password;
$_SESSION['address'] = $address;
$_SESSION['email'] = $email;

if (!empty($_SESSION['product_id'])) {
    $id = $_SESSION['id'];
    $product_id = mysqli_real_escape_string($con, $_SESSION['product_id']);
    
    $q = "INSERT INTO favorites (idclient, idproduit) VALUES ($id, $product_id)";
    mysqli_query($con, $q);
}

$_SESSION['favorites'] = array();
$query = "SELECT * FROM favorites WHERE idclient = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "s", $_SESSION['id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$idproducts = mysqli_fetch_all($result, MYSQLI_ASSOC);

foreach ($idproducts as $prd) {
    $pr = (int) $prd['idproduit'];
    $cl = (int) $prd['idclient'];
    
    $_SESSION['favorites'][$pr] = $pr;
}

$q = "UPDATE cart SET idclient = ".$_SESSION['id'] ." WHERE idclient = 0";
            mysqli_query($con, $q);


            $_SESSION['cart'] = array();
            $query = "SELECT * FROM cart WHERE idclient = ?";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, "s", $_SESSION['id']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $idproducts = mysqli_fetch_all($result, MYSQLI_ASSOC);

            foreach ($idproducts as $prd) {
                $pr = (int)$prd['idprod'];
                $q = (int)$prd['quantite'];
                $_SESSION['cart'][$pr] = $q;
            }


        mysqli_query($con , "Update user set access = access + 1 where name = '$name' and password = '$password'");

       header("location: index.php?page=home");
          
            // echo "<h1><center> Login successful </center></h1>";

?>