<?php

?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Login Page </title>
    <link rel="stylesheet" href="https://<?php echo $_SERVER['SERVER_NAME'] ?>/static/css/login.css">

</head>
    
<body>
    <center>
    <div class="login-corp">
        <center>
            <h1> Login </h1>
        </center>
        <form action="https://<?php echo $_SERVER['SERVER_NAME'] ?>/login/confirmLogIn" method="POST">
            <div class="container">
                <label>Username : </label>
                <input type="text" placeholder="Enter Username" name="username" required>
                <label>Password : </label>
                <input type="password" placeholder="Enter Password" name="password" required>
                <button type="submit" class="login-btn">Login</button>
                <div><input type="checkbox" placeholder="" name="check"> Remember me
                
                &nbsp<a href="https://<?php echo $_SERVER['SERVER_NAME'] ?>/login/createAccount">Create a account</a></div>
            </div>
        </form>
    </div>
    </center>
</body>

</html>