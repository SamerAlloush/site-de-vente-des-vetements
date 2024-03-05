<?php
if(isset($_GET['product'])){

    include 'functions.php';
    $pdo = pdo_connect_mysql();
    header('url = index.php?page=sortproducts');


    $prenom = $_GET['product'];
    
 $stmt = $pdo->prepare("SELECT * FROM products where category = '".$prenom."' ORDER BY dateadded DESC" );
 $stmt->execute();
 $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
 $resultat = "";
 
  foreach ($products as $product){

   
         $resultat .= " <a href=' index.php?page=product&id={$product['id']} ' class='product'> 
         <img src=' imgs/{$product['image']} ' width='200' height='200' alt=' {$product['name']} '>
         <span class='name'>{$product['name']}</span>
         <span class='price'>
             &dollar;{$product['price']}
         </span>
     </a>";
 }

 if($resultat == "")
     $resultat = "Aucune Information";

 echo $resultat;

}

?>