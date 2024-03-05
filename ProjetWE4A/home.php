<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script> 
    $(document).ready(function(){
    $("#search").change(function(){
        if($(this).val().length==0){
            $("#Resultat".html(""));
            return;
        }
        $.ajax({
            url:"liste_noms.php",
            type:"get",
            data:{product:$(this).val()},
            success:function(reponse_serveur){
                $("#Resultat").html(reponse_serveur);
            }
        });
    });
});
</script>
</head> 
<?php
// Get the 4 most recently added products
$stmt = $pdo->prepare('SELECT * FROM products WHERE SYSDATE() < DATE_ADD(dateadded, INTERVAL 1 MONTH) ORDER BY dateadded DESC');
//SELECT * FROM products ORDER BY dateadded DESC LIMIT 4
$stmt->execute();
$recently_added_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>




<?=template_header('Home')?>

<div class="featured">
    <h2>Zeina&Samer</h2>
    <p>Where you find all your needs</p>
</div>
<!-- <div>
    <?php
        echo $_SESSION['favorites'];
    ?>
</div>   -->
<div class="recentlyadded content-wrapper">
    <h2>Recently Added Products</h2>
    <div class="products">
        <?php foreach ($recently_added_products as $product): ?>
        <a href="index.php?page=product&id=<?=$product['id']?>" class="product">
            <img src="imgs/<?=$product['image']?>" width="200" height="200" alt="<?=$product['name']?>">
            <span class="name"><?=$product['name']?></span>
            <span class="price">
                &dollar;<?=$product['price']?>
                <!-- <?php if ($product['rrp'] > 0): ?>
                <span class="rrp">&dollar;<?=$product['rrp']?></span>
                <?php endif; ?> -->
            </span>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<?=template_footer()?>

<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head> 