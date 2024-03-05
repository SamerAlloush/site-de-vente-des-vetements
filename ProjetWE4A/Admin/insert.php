<?php
session_start();
include('../functions.php');
include('admin_functions.php');

//session_start();
// Change this to your connection info.
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE){

include('../connectionuser.php');

if (isset($_POST['insertbutton'])) {
    $name = $_POST['pname'];
    $description = $_POST['pdesc'];
    $price = $_POST['pprice'];
    $categorie = $_POST['pcat'];
    $quantity = $_POST['pquantity'];
    $sexe = $_POST['psexe'];
    $image = $_POST['imagename'];
    // // move_uploaded_file($_FILES['drpPhoto']['tmp_name'], $_FILES['drpPhoto']['name']);
    // $d = explode(".",$image);
    // $imagename = $d[0];
    // $imageextension = $d[1];
    // $image = $imagename . "." . $imageextension;

    $query = "INSERT INTO products(name, description, price, category, image, quantity, sexe) VALUES(?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ssdssis", $name, $description, $price, $categorie, $image, $quantity, $sexe);
    mysqli_stmt_execute($stmt);
}

?>

<!-- <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#insertbutton").click(function(){
                $.ajax({
                    url:"insertitem.php",
                    type:"get",
                    data: { sortingtype : $(this).val() },
                    success:function(output){
                        $("#tableproducts").html(output);
                    }
                });
            });
        });
    </script>
</head> -->


<?=admin_header('Products')?>
<form enctype="multipart/form-data" method="post">    
<div class="products content-wrapper">
    <p>Insert a Product</p>
    <div class="products-wrapper">
        <table width="100%">
            <tr>
                <td>Image</td>
                <td>Name</td>
                <td><input type="text" name="pname" id="pname"></td>
            </tr>
            <tr>
                <td rowspan="6">
                <?php
                        
                        $ph = 'imgs';
                        echo"
                        <form method='post' enctype='multipart/form-data'>
                        <p>Choose an image:<input type='file' name='drpPhoto'>                        
                        <input type='submit' name='btnDisplay' value='Display'></form>";  

                        if(isset($_REQUEST['btnDisplay'])){
                            $a = explode('.', $_FILES['drpPhoto']['name']);
                            $ext = $a[count($a)-1];
                            if($ext == 'avif' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'webp' || $ext == 'png' || $ext == 'gif')
                            {
                                copy($_FILES['drpPhoto']['tmp_name'] , "../imgs/".$_FILES['drpPhoto']['name']);
                                
                            }
                            
                            echo"<img src='../imgs/".$_FILES['drpPhoto']['name'] ."' width='300'>";
                            echo"<input type='text' name='imagename' value='".$_FILES['drpPhoto']['name']."'>";
                        }
                 
                    ?>
                
                    
                </td>
                <td>Description</td>
                <td><input type="text" name="pdesc" id="pdesc"></td>
            </tr>
            <tr>
                <td>Price</td>
                <td><input type="number" name="pprice" id="pprice"></td>
            </tr>
            <tr>
                <td>Categories</td>
                <td>
                    <select name="pcat" id="pcat">
                        <option value="Pants">Pants</option>
                        <option value="TShirts">TShirts</option>
                        <option value="Skirt">Skirt</option>
                        <option value="Shirts">Shirts</option>
                        <option value="Short">Short</option>
                        <option value="Jackets">Jackets</option>
                        <option value="Dress">Dress</option>
                        <option value="Top">Top</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Quantity</td>
                <td><input type="number" name="pquantity" value="1" id="pquantity"></td>
            </tr>
            <tr>
                <td>Sexe</td>
                <td>
                    <select name="psexe" id="psexe">
                        <option value="Men">Men</option>
                        <option value="Women">Women</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Insert The Product" id="insertbutton" name="insertbutton"></td>
            </tr>
        </table>
    </div>
</div>
</form>

<?=template_footer()?>

<?php
}
else{
    echo"<h1>You can not access this page!!</h1>";
    //header( "url=index.php?page=login" );
}
?>