<?php      
    include('connectionuser.php');  
    $username = $_POST['user'];  
    $password = $_POST['pass'];  
      
        //to prevent from mysqli injection  
        $username = stripcslashes($username);  
        $password = stripcslashes($password);  
        $username = mysqli_real_escape_string($con, $username);  
        $password = mysqli_real_escape_string($con, $password);  
      
        $sql = "select * from user where name = '$username' and password = '$password'";  
        $result = mysqli_query($con, $sql);  
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
        $count = mysqli_num_rows($result);  
          
        if($count == 1){  
            session_start();
            header("location: index.php?page=home ");
            mysqli_query($con , "Update user set access = access + 1 where name = '$username' and password = '$password'");
            $_SESSION['id'] = $row['id'];
            $_SESSION['address'] = $row['address'];
            $_SESSION['email'] = $row['email'];
            // mysqli_query($con , "Select id from user where name = '$username' and password = '$password'");
            $_SESSION["user"] = $_REQUEST['user'];
            $_SESSION['pass'] = $_REQUEST['pass'];
           

            if (!empty($_SESSION['product_id'])) {
                $id = mysqli_real_escape_string($con, $_SESSION['id']);
                $product_id = mysqli_real_escape_string($con, $_SESSION['product_id']);
                
                $q = "INSERT INTO favorites (idclient, idproduit) VALUES ('$id', '$product_id')";
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
                $pr = (int)$prd['idproduit'];
                $cl = (int)$prd['idclient'];
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
        }  
        else{  
            echo "<h1> Login failed. Invalid username or password.</h1>";  
        }     
?>  