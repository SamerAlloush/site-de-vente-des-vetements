<?php
  session_start();
  include('../functions.php');
  include('admin_functions.php');
  pdo_connect_mysql();
?>

<!DOCTYPE html>
  <html>
    <head>
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <link href="../style/style.css" rel="stylesheet" type="text/css">
          <link href="../style/stylelogin.css" rel="stylesheet" type="text/css">
    </head>
    <!-- <?=admin_header('Login')?> -->
    <body>
      <div class="main">

        <h2>Welcome Admin!<br>Click here to login</h2>
        <button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Login</button>

      </div>

      <div id="id01" class="modal">

        <form class="modal-content animate" action="admin.php" method="post">
          <div class="imgcontainer">
            <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
            <img src="../imgs/profile.png" alt="Avatar" class="avatar" width="100px" height="250px">
          </div>

          <div class="container">
            <label for="uname"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="uname" id="uname" required>

            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="psw" id="psw" required>
            
            <div class="error"></div>
            <button type="submit" name="lg" id="lg">Login</button>    
          </div>

          <div class="container" style="background-color:#f1f1f1">
            <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button> 
            <!-- <span class="psw">Forgot <a href="#">password?</a></span> -->
          </div>
        </form>

      </div>

      <script>
      //Get the modal
      var modal = document.getElementById('id01');

      // When the user clicks anywhere outside of the modal, close it
      window.onclick = function(event) {
          if (event.target == modal) {
              modal.style.display = "none";
          }
      }
      </script>   

    </body>
  </html>
<?=template_footer()?>

