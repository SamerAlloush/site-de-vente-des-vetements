<?php
    $id = $_SESSION['id'];

    if(isset($_POST['backproducts'])){
        header('Location: index.php?page=products');
        exit;
    }   

?>
<head>
    <style>
        input[type="button"]{
	margin-left: 5px;
	padding: 12px 20px;
	border: 0;
	background: #4e5c70;
	color: #FFFFFF;
	font-size: 14px;
	font-weight: bold;
	cursor: pointer;
	border-radius: 5px;}
    </style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $("#confirm").click(function(){
            $.ajax({
                url:'confirm.php',
                type:'get',
                data:{name:$("#name").val() , email:$("#email").val() , address:$("#address").val()},
                success: function(output){
                    $("#resultat").html(output);
                }
            });
        });
    });
</script>
</head> 

<?=template_header('Place Order')?>

<div class="cart content-wrapper">
    <h1>Confirm Order</h1>
    <form method="post">
        <table>
            <thead>
                <tr>
                    <td colspan="2">Name</td>
                    <td>Email</td>
                    <!-- <td></td> -->
                    <td>Address</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                    <input type="text" name = "name" id = "name" value = "<?=$_SESSION['user']?>">
                    </td>
                    <td></td>
                    <td>
                    <input type="text" name = "email" id = "email" value = "<?=$_SESSION['email']?>">
                    </td>
                    <!-- <td></td>
                    <td>
                    </td> -->
                    <td><input type="text" name = "address" id = "address" value = "<?=$_SESSION['address']?>"></td>
                </tr>
            </tbody>
        </table>
        <br>
        <div class="buttons">
            <input type="submit" value="Back to Products" name="backproducts">
            <input type="button" value="Confirm Order" name="confirm" id="confirm">
        </div>
        <div id="resultat">

        </div>
    </form>
</div>

<?=template_footer()?>

