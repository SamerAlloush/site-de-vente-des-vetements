<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE){

include('../connectionuser.php'); 
include('../functions.php');
include('admin_functions.php');




$sql = "SELECT * FROM admin WHERE name = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "s", $_SESSION['name']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if (isset($_POST['edit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $phonenumber = $_POST['number'];

    // $query = "UPDATE admin SET name = ?, email = ?, password = ?, address = ?, phonenumber = ? WHERE id = ?";
    // $stmt = $pdo->prepare($query);
    // $stmt->execute([$name, $email, $password, $address, $phonenumber, $row['id']]);

    $query = "UPDATE admin SET name = ?, email = ?, password = ?, address = ?, phonenumber = ? WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("sssssi", $name, $email, $password, $address, $phonenumber, $row['id']);
    $stmt->execute();
    $stmt->close();


    $sql = "SELECT * FROM admin WHERE name = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $_POST['name']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

}

?>

<?=admin_header('Profile')?>

<form action="profile.php" method="post">
    <div class="cart content-wrapper">
        <h1>My Profile</h1>
        <form method="post">
            <table>
                <thead>
                    <tr>
                        <td>Name</td>
                        <td>Email</td>
                        <td>Password</td>
                        <td>Address</td>
                        <td>Phone number</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input type="text" name="name" id="name" value="<?php echo $row['name']; ?>">
                        </td>
                        <td>
                            <input type="text" name="email" id="email" value="<?php echo $row['email']; ?>">
                        </td>
                        <td>
                            <input type="text" name="password" id="password" value="<?php echo $row['password']; ?>">
                        </td>
                        <td>
                            <input type="text" name="address" id="address" value="<?php echo $row['address']; ?>">
                        </td>
                        <td>
                            <input type="text" name="number" id="number" value="<?php echo $row['phonenumber']; ?>">
                        </td>
                    </tr>
                </tbody>
            </table>
            <br>
            <div class="buttons">
                <input type="submit" value="Edit My Informations" name="edit">
            </div>
        </form>
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






















