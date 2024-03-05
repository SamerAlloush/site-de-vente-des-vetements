<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<style>
input[type="submit"] {
	margin-left: 5px;
	padding: 12px 20px;
	border: 0;
	background: #4e5c70;
	color: #FFFFFF;
	font-size: 14px;
	font-weight: bold;
	cursor: pointer;
	border-radius: 5px;
}
</style>
    
    // $(document).ready(function(){
    //     $("#loveimg").click(function(){
    //         $.ajax({
    //             url : 'favorites.php',
    //             type : 'get';
    //             success : function(output){
    //                 $(this).val()='imgs/heart.png'
    //             }
    //         });
    //     });
    // });
</script>

</head>

<?php
session_start();
include('../functions.php');
include('admin_functions.php');
include('../connectionuser.php'); 


if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE){

// Check to make sure the id parameter is specified in the URL
if (isset($_GET['id'])) {
    // Prepare statement and execute, prevents SQL injection
    // $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    // $stmt->execute([$_GET['id']]);
    // // Fetch the product from the database and return the result as an Array
    // $product = $stmt->fetch(PDO::FETCH_ASSOC);
    // // Check if the product exists (array is not empty)
    // if (!$product) {
    //     // Simple error to display if the id for the product doesn't exists (array is empty)
    //     exit('Product does not exist!');
    // }

    $product_id = $_GET['id'];
    $query = "SELECT * FROM products WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if (!$product) {
        // Handle the case when the product doesn't exist
        exit('Product does not exist!');
    }

} else {
    // Simple error to display if the id wasn't specified
    exit('Product does not exist!');
}

if (isset($_POST['editproduct'])) {
    // $name = $_POST['name'];
    // $desc = $_POST['desc'];
    // $price = $_POST['price'];
    // $stock = $_POST['stock'];
    // $gender = $_POST['gender'];
    // $cat = $_POST['category'];
    // $image = $_POST['imagename'];

    // $query = "UPDATE products SET name = ?, description = ?, price = ?, category = ?, image = ?, quantity = ?, sexe = ? WHERE id = ?";
    // $stmt = $pdo->prepare($query);

    // $stmt->bindParam(1, $name);
    // $stmt->bindParam(2, $desc);
    // $stmt->bindParam(3, $price);
    // $stmt->bindParam(4, $cat);
    // $stmt->bindParam(5, $image);
    // $stmt->bindParam(6, $stock);
    // $stmt->bindParam(7, $gender);
    // $stmt->bindParam(8, $_GET['id']);

    // $stmt->execute();

    $name = $_POST['name'];
    $desc = $_POST['desc'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $gender = $_POST['gender'];
    $cat = $_POST['category'];
    $image = $_POST['imagename'];
    $product_id = $_GET['id'];

    $query = "UPDATE products SET name = ?, description = ?, price = ?, category = ?, image = ?, quantity = ?, sexe = ? WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ssdssisi", $name, $desc, $price, $cat, $image, $stock, $gender, $product_id);
    $stmt->execute();
    $stmt->close();


}

?>

<head>
    <link href="../style/style.css" rel="stylesheet" type="text/css">
</head>

<?=admin_header('EditProduct')?>
<form enctype="multipart/form-data" method="post">    
<div class="products content-wrapper">
    <p>Edit a Product</p>
    <div class="products-wrapper">
        <table width="100%">
            <tr>
                <th rowspan="7">
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
                        else{
                            echo"<img src='../imgs/".$product['image']."' width='500' height='500' alt='".$product['name']."'>";
                            echo"<input type='text' name='imagename' value='".$product['image']."'>";
 
                        }
                 
                    ?>        
                </th>
                <th>Name:</th>
                <th><input type='text' name='name' value='<?=$product['name']?>'></th>
            </tr>
            <tr>
                <!-- <th rowspan="6">
                    <img src="imgs/<?=$product['image']?>" width="500" height="500" alt="<?=$product['name']?>">
                </th> -->
                <th>Description:</th>
                <th><textarea name="desc" rows="7" cols="25"><?=$product['description']?></textarea></th>
            </tr>
            <tr>   
                <th>Price:</th>
                <th><input type='number' name='price' value='<?=$product['price']?>'></th>
            </tr>
            <tr>
                <!-- <th>Category</th>
                <th>             
                    <input type="radio" name="category" value="Pants" <?php echo ($product['category'] == 'Pants') ? 'checked' : ''; ?>> Pants
                    <input type="radio" name="category" value="TShirts" <?php echo ($product['category'] == 'TShirts') ? 'checked' : ''; ?>> TShirts
                    <input type="radio" name="category" value="Shirts" <?php echo ($product['category'] == 'Shirts') ? 'checked' : ''; ?>> Shirts
                    <input type="radio" name="category" value="Short" <?php echo ($product['category'] == 'Short') ? 'checked' : ''; ?>> Short
                    <input type="radio" name="category" value="Top" <?php echo ($product['category'] == 'Top') ? 'checked' : ''; ?>> Top
                    <input type="radio" name="category" value="Skirt" <?php echo ($product['category'] == 'Skirt') ? 'checked' : ''; ?>> Skirt
                    <input type="radio" name="category" value="Jackets" <?php echo ($product['category'] == 'Jackets') ? 'checked' : ''; ?>> Jackets
                    <input type="radio" name="category" value="Dress" <?php echo ($product['category'] == 'Dress') ? 'checked' : ''; ?>> Dress
                </th> -->

                <th>Category</th>
                <th>
                    <select name="category">
                        <option value="Pants" <?php echo ($product['category'] == 'Pants') ? 'selected' : ''; ?>>Pants</option>
                        <option value="TShirts" <?php echo ($product['category'] == 'TShirts') ? 'selected' : ''; ?>>TShirts</option>
                        <option value="Shirts" <?php echo ($product['category'] == 'Shirts') ? 'selected' : ''; ?>>Shirts</option>
                        <option value="Short" <?php echo ($product['category'] == 'Short') ? 'selected' : ''; ?>>Short</option>
                        <option value="Top" <?php echo ($product['category'] == 'Top') ? 'selected' : ''; ?>>Top</option>
                        <option value="Skirt" <?php echo ($product['category'] == 'Skirt') ? 'selected' : ''; ?>>Skirt</option>
                        <option value="Jackets" <?php echo ($product['category'] == 'Jackets') ? 'selected' : ''; ?>>Jackets</option>
                        <option value="Dress" <?php echo ($product['category'] == 'Dress') ? 'selected' : ''; ?>>Dress</option>
                    </select>
                </th>

            </tr>
            <tr>
                <th>Stock:</th>
                <th><input type='number' name='stock' value='<?=$product['quantity']?>'></th>
            </tr>
            <tr>
                <!-- <th>Gender:</th>
                <?php if ($product['sexe'] == 'Men'): ?>
                <th>
                    <input type="radio" name="gender" value="Men" checked> Men
                    <input type="radio" name="gender" value="Women"> Women
                </th>
                <?php else: ?>
                <th>
                    <input type="radio" name="gender" value="Men"> Men
                    <input type="radio" name="gender" value="Women" checked> Women
                </th>
                <?php endif; ?> -->

                <th>Gender:</th>
                <th>
                    <select name="gender">
                        <option value="Men" <?php echo ($product['sexe'] == 'Men') ? 'selected' : ''; ?>>Men</option>
                        <option value="Women" <?php echo ($product['sexe'] == 'Women') ? 'selected' : ''; ?>>Women</option>
                    </select>
                </th>

            </tr>
            <tr>
                <th></th>
                <th><input type="submit" value="Edit The Product" id="editproduct" name="editproduct"></th>
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