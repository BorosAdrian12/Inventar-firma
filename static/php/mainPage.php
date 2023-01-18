<?php
// session_start();
//nu stiu ce are dar nu merge cum ar trebuii

//aici trebuie ceva cu cookie sa verifice daca le ai , si daca ai sa ia de acolo datele ca asa te tine minte 
if(isset($_SESSION["user"])){
    // echo '<script>alert("'.$_SESSION["user"]["username"].'")</script>';//this was for debuging
    //aici cum fac , daca am cookie de unde iau datele pentru logare
    echo '<script>
    let userdata='.json_encode($_SESSION["user"]).';
    </script>';
}
else{
   //  header("Location: login.php"); inca nu ii implementat
}

// if(isset($_SERVER["dataGlobal"])){
//     echo '<script>
//     console.log("exista date in global");
//     </script>';//this was for debuging
// }else{
//     echo '<script>
//     console.log("nu a mers globalul");
//     </script>';//this was for debuging
// }
?>
<html>
    <!-- aici o sa fie siteul de la proiect  -->
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://<?php echo $_SERVER['SERVER_NAME'] ?>/static/css/mainPage.css">
        
    </head>
    <body>
        <div class="notification" id="notification">aceasta este o notificare</div>
        <div class=" searchbar">
            <?php 
            include($_SERVER['DOCUMENT_ROOT'].'/static/php/searchbar.php');
            ?>
            
        </div>
        <div class="container-sm">
            <div class="col-sm-2 control">
                <?php 
                include($_SERVER['DOCUMENT_ROOT'].'/static/html/meniu.html')
               ?>
            </div>
        </div>
        <div class="col-sm-10 display">
            <?php 
            // include('display.php')
            ?>
            <display id="display"></display>
        </div>
    </body>
    <?php
    // var_dump($_SESSION["user"]);
    ?>
    <script>
        
    </script>
    <script>
      console.log("detasd");
    </script>
    <!-- <script src="./javascript/produse.js"></script> -->
    <script><?php
   //   require($_SERVER['DOCUMENT_ROOT'] . '/static/javascript/mainPage.js')?></script>
    <script src="https://<?php echo $_SERVER['SERVER_NAME'] ?>/static/javascript/mainPage.js"></script>
</html>