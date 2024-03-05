<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
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
    include('connectionuser.php'); 

// Check to make sure the id parameter is specified in the URL
if (isset($_GET['id'])) {
    // Prepare statement and execute, prevents SQL injection
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    // Fetch the product from the database and return the result as an Array
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    // Check if the product exists (array is not empty)
    if (!$product) {
        // Simple error to display if the id for the product doesn't exists (array is empty)
        exit('Product does not exist!');
    }
} else {
    // Simple error to display if the id wasn't specified
    exit('Product does not exist!');
}
?>





<?=template_header('Product')?>

<div class="product content-wrapper">
    <img src="imgs/<?=$product['image']?>" width="500" height="500" alt="<?=$product['name']?>">
    <div>
        <h1 class="name"><?=$product['name']?></h1>
        <span class="price">
            &dollar;<?=$product['price']?>
            <!-- <?php if ($product['rrp'] > 0): ?>
            <span class="rrp">&dollar;<?=$product['rrp']?></span>
            <?php endif; ?> -->
        </span>
        <?php
            $query = "SELECT * FROM favorites WHERE idclient = ? AND idproduit = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('ii', $_SESSION['id'], $product['id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $rowCount = $result->num_rows;

                if ($rowCount == 1) {
                    echo "<img src='imgs/heart.png' width='30px' height='30px'>";
                } else {
                    echo "<img src='imgs/love.png' width='30px' height='30px'>";
                }
        ?>
        <!-- <script src="script.js"></script>  -->

           
         <form action="index.php?page=cart" method="post">
            <input type="number" name="quantity" value="1" min="1" max="<?=$product['quantity']?>" placeholder="Quantity" required>
            <input type="hidden" name="product_id" value="<?=$product['id']?>">
            <input type="submit" value="Add To Cart">
        </form>

        <?php
            if(isset($_SESSION['user']) && $_SESSION['user'] !== ''){
                echo '<form action="index.php?page=favorites" method="post">';
            } else {
                echo '<form action="index.php?page=signup" method="post">';
            }        
        ?>

            <input type="hidden" name="idquantity" value="1" min="1" max="<?=$product['quantity']?>" placeholder="Quantity" required>
            <input type="hidden" name="idproduct" value="<?=$product['id']?>">
            <input type="submit" value="Add To Favorites">
        </form>

        <div class="description">
            <?=$product['description']?>
        </div>
    </div>
</div>

<?=template_footer()?>