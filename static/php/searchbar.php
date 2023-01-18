<input type="text" class="searchbox roundborder10" placeholder="Search.."> 
<button class=" width100 roundborder10 ">search</button>
<?php
$loginPath="https://".$_SERVER['SERVER_NAME']."/login";
$loginText="login";
if(isset($_SESSION["isLog"])){
    $loginPath.="/logoutUser";
    $loginText="logout";
}
echo '<a href="'.$loginPath.'"><button class="roundborder10">'.$loginText.'</button></a>';
?>
<span class="toleft" id="username"> username </span>
