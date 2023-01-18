<?php
// echo "display produse";
// Database::returnData();
?>
<div>
    <div>
        <!-- aici o sa fie bara -->
        <!-- o bara de search  -->
        <input type="text" class="searchbox roundborder10" placeholder="Search.."> 
        <button onclick="displayContent('AddItemType')">adauga tip produs</button>
        
    </div>
    <div id="product_display_place">
        <!-- aici o sa fie produsele -->
        <!-- ce ii mai jos o sa fie un tameplate -->
        <div class="productRow" >
            
            
        </div>
    </div>
    <div>
        <button onclick="changePageProduct(-1)"><</button>
        <span id="index"></span>
        <button onclick="changePageProduct(1)">></button>
    </div>
</div>


