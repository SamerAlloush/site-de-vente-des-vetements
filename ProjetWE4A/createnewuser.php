<html>  
<head>  
    <title>PHP login system</title>  
    <link rel = "stylesheet" type = "text/css" href = "styleuser.css">   
    
    <style>
                .custom-button {
                width: 150px;
                margin: 0 auto;
                display: block;
                padding: 10px;
                background-color: #007bff;
                color: #fff;
                border: none;
                border-radius: 5px;
                font-size: 16px;
                cursor: pointer;
                margin-top:3%;
            }
            
            .custom-button:hover {
                background-color: #0056b3;
            }
            
            .custom-link {
                color: #007bff;
                text-decoration: none;
                font-weight: bold;
                margin-top:4%;
                text-align:center;
            }
            
            .custom-link:hover {
                text-decoration: underline;
            }

    </style>
</head>  

<body style="background-image:url(imgs/clothesstore.jpg); background-repeat: no-repeat; background-size:cover; background-position:center;">  
<div style="width:100%;  display:flex; justify-content:center; flex-direction:column; align-items:center;">
    <div id = "frm" style="width:50% ;background-color: #e8e8e8 ;border-radius:15px;display:flex; justify-content:center; flex-direction:column; align-items:center;margin-top:20%;">  
        <h1>Sign up</h1>  
        <form name="f1" action = "authentication.php" onsubmit = "return validation()" method = "POST">  
            <table>
                <tr>  
                    <td><strong>Name: </strong> </td>  
                    <td><input class="" type = "text" id ="name" name  = "name" 
                    style="width: 200px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px; color: #333; background-color: #f7f7f7;"/>  </td>
                    <td></td>
                </tr> 
                <tr>  
                    <td><strong> Address: </strong></td>  
                    <td><input type = "text" id ="address" name  = "address" 
                    style="width: 200px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px; color: #333; background-color: #f7f7f7;"/> </td> 
                    <td></td>
                </tr> 
                <tr>  
                    <td><strong> Email: </strong></td>  
                    <td><input type = "text" id ="email" name  = "email" 
                    style="width: 200px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px; color: #333; background-color: #f7f7f7;"/> </td> 
                    <td></td>
                </tr>  
                <tr>  
                    <td><strong> Password: </strong></td>  
                    <td><input type = "password" id ="pass" name  = "pass" 
                    style="width: 200px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px; color: #333; background-color: #f7f7f7;"/>  
                    </td>
                    <td></td>
                </tr>  
                   
                
                <tr>  
                    <td>  </td>  
                    <td> <a href=""></a>  </td>
                    <td></td>
                </tr> 
            </table>
            
             <div style="display: flex; justify-content: center; align-items: center;margin-left:10%">
                        <div>
                            <input class="custom-button" type="submit" id="btn" value="Create Account" />
                            <a class="custom-link" href="signup.php">Already have an account?</a>
                        </div>
                </div>
        </form>  
    </div>  
</div>
    
    <script>  
            function validation()  
            {  
                var id=document.f1.name.value;  
                var ps=document.f1.pass.value;  
                if(id.length=="" && ps.length=="") {  
                    alert("User Name and Password fields are empty");  
                    return false;  
                }  
                else  
                {  
                    if(id.length=="") {  
                        alert("User Name is empty");  
                        return false;  
                    }   
                    if (ps.length=="") {  
                    alert("Password field is empty");  
                    return false;  
                    }  
                }                             
            }  
        </script>  
</body>     
</html>  