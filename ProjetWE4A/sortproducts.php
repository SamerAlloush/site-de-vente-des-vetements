<?php
// The amounts of products to show on each page
$num_products_on_each_page = 8;
// The current page - in the URL, will appear as index.php?page=products&p=1, index.php?page=products&p=2, etc...
$current_page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
// Select products ordered by the date added
//$stmt = $pdo->prepare('SELECT * FROM products ORDER BY dateadded DESC LIMIT ?,?');
// bindValue will allow us to use an integer in the SQL statement, which we need to use for the LIMIT clause

// $stmt->bindValue(1, ($current_page - 1) * $num_products_on_each_page, PDO::PARAM_INT);
// $stmt->bindValue(2, $num_products_on_each_page, PDO::PARAM_INT);
// $stmt->execute();

// Fetch the products from the database and return the result as an Array
//$products = $stmt->fetchAll(PDO::FETCH_ASSOC);




// Get the total number of products
$total_products = $pdo->query('SELECT * FROM products')->rowCount();
?>

<?=template_header('Products')?>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#sortselect").change(function(){
                if($(this).val()==0){
                    $("#tableproducts").html("");
                    return;
                }
                $.ajax({
                    url:"sortinglist.php",
                    type:"get",
                    data: { sortingtype : $(this).val() },
                    success:function(output){
                        $("#tableproducts").html(output);
                    }
                });
            });
        });
    </script>
</head>

<div class="products content-wrapper">
    <h1>Sorting Products</h1>
    <div id="sorting">
        <select id="sortselect">
            <option value="0">Select a sorting type</option>
            <option value="1">Oldest to Newest</option>
            <option value="2">Newest to Oldest</option>
            <option value="3">Higher to Lower</option>
            <option value="4">Lower to Higher</option>
        </select>
    </div>

    <p><?=$total_products?> Products</p>

    <div class="products-wrapper" id="tableproducts">
        
    </div>
    
</div>

<?=template_footer()?>