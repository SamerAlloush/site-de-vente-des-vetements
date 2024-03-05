<?php
$_SESSION['loggedin'] = FALSE;
if (isset($_POST['idproduct'], $_POST['idquantity']) && is_numeric($_POST['idproduct']) && is_numeric($_POST['idquantity'])) {
    $_SESSION['product_id'] = (int)$_POST['idproduct'];
    // $_SESSION['quantity'] = (int)$_POST['idquantity'];

}
?>

<html>  
<head>  
    <title>PHP login system</title>  
    <link rel = "stylesheet" type = "text/css" href = "styleuser.css">  
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 
    
    <style>
        .custom-button {
    width: 100px;
    margin: 0 auto;
    display: block;
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    margin-top:3%;
}

.custom-button:hover {
    background-color: #0056b3;
}

.custom-link {
    color: #007bff;
    text-decoration: none;
    font-weight: bold;
    margin-top:3%;
    text-align:center;
}

.custom-link:hover {
    text-decoration: underline;
}


    </style>
</head>  
<body class="d-flex flex-column align-items-center" style="background-image:url(imgs/clothesstore.jpg); background-repeat: no-repeat; background-size:cover; background-position:center; backdrop-filter: blur(5px);">  
    <!-- <body>
    <div class="container">
 <div class="row">
    <div class="col-md-12">-->
      <!--<img src="imgs/clothesstore.jpg" alt="Your Image" class="img-fluid"> -->
   
    <div id = "frm" style="margin-top:20%;width:40% ;border-radius:15px;"  class="container  d-flex align-items-center justify-content-center">
    <div class="card ">
        <div class="card-body d-flex align-items-center flex-column justify-content-center">
            
            <form name="f1" action = "authentificationuser.php" onsubmit = "return validation()" method = "post">  
                <table>
                    <tr>  
                        <td> <strong>Your Name: </strong></td>  
                        <td>
                        
                        <input type="text" id="user" class="custom-input" name="user" style="width: 200px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px; color: #333; background-color: #f7f7f7;">

                        </td>
                        <td></td>
                    </tr> 
                    <tr class="">  
                        <td> <strong>Your Password: </strong></td>  
                        <td><input type="password" id ="pass" name  = "pass" style="width: 200px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px; color: #333; background-color: #f7f7f7;"/>  </td>
                        <td></td>
                    </tr> 
                    <tr>  
                        <td  colspan="3" width="300px">
                          <input type="submit" id="btn" value="Login" class="custom-button">

                        </td>
                        
                    </tr> 
                  
                     
                 
                    </table>
                </form>  
                
                    <div >  
                         <a href="ResetPassword.php" class="custom-link">Forgot Password?</a>
                    </div> 
                        <div>  
                            <strong>New costumer? </strong>
                            <a href="createnewuser.php" class="custom-link">Create Account.</a>
                        </div>  
            </div>
        <!-- </div>  
        </div>  
        </div> -->
 </div>
</div>
        <script>  
            function validation()  
            {  
                var id=document.f1.user.value;  
                var ps=document.f1.pass.value;  
                if(id.length=="" && ps.length=="") {  
                    alert("User Name and Password fields are empty");  
                    return false;  
                }  
                else  
                {  
                    if(id.length=="") {  
                        alert("User Name is empty");  
                        return false;  
                    }   
                    if (ps.length=="") {  
                    alert("Password field is empty");  
                    return false;  
                    }  
                }                             
            }  
        </script>  
</body>     
</html>  