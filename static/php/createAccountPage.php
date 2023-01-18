<?php
$arrProbleme = [];
if(isset($_POST["username"])&&isset($_POST["email"])&&isset($_POST["password"])&&isset($_POST["retypePassword"])){
    //if(($_POST["username"]=="")||($_POST["email"]=="")||($_POST["password"]=="")||($_POST["retypePassword"]==""))

    ///verifoca pentru sql injection 
    // if ($_POST["password"] !== $_POST["retypePassword"])
    //     $arrProbleme[] = "password doesn't match";
    // if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
    //     $arrProbleme[] = "email invalid";
    // if (preg_match('[;"]', $_POST["password"])||preg_match('[;"]', $_POST["username"]))//prevent sql injection
    //     $arrProbleme[] = "forbidden characters";

    
    // try {
    //     $user = new User();
    //     if($user->createAccount($_POST["username"], $_POST["password"], $_POST["retypePassword"], $_POST["email"]))
    //         header("Location: login.php");
    //     else
    //         echo "acest user exista deja";
    // } catch (\Throwable $th) {
    //     echo $th;
    // }
}
?>
<html lang="en">
<head>
    <title>Document</title>
</head>
<body>
    <form action="https://<?php echo $_SERVER['SERVER_NAME'] ?>/login/confirmCreateAccount" method="post">
            <label>Username : </label>   
            <input type="text" placeholder="Enter Username" name="username" ><br>  
            <label>Email : </label>   
            <input type="text" placeholder="Enter Username" name="email" required><br>
            <label>Password : </label>   
            <input type="password" placeholder="Enter Password" name="password" required><br>
            <label>Retype Password : </label>   
            <input type="password" placeholder="Retype Password" name="repassword" required> 
            <button type="submit">Login</button>   

    </form>
</body>
</html>