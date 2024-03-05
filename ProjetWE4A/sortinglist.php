<?php
    if(isset($_GET['sortingtype'])){
        include 'functions.php';
        $pdo = pdo_connect_mysql();
        
        

        $num = $_GET['sortingtype'];

        if($num == 1)
            $stmt = $pdo->prepare('SELECT * FROM products ORDER BY dateadded ASC');
        if($num == 2)
            $stmt = $pdo->prepare('SELECT * FROM products ORDER BY dateadded DESC');
        if($num == 3)
            $stmt = $pdo->prepare('SELECT * FROM products ORDER BY price Desc');
        if($num == 4)
            $stmt = $pdo->prepare('SELECT * FROM products ORDER BY price ASC');
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