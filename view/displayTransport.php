<h2>mutarea itemelor</h2>



<div>
   <input type="text" id="search-input" placeholder="cauta produsul">
   <div id="search-result-local" class="item-search"></div>
</div>
<br><br>
<form method="post" id="item-formid">
   <table >
      <tr>
         <td>ID Item</td>
         <td><input type="text" id="itemId"></td>
      </tr>
      <tr>
         <td>nume </td>
         <td><input type="text" name="nameItem" id="nameItem"></td>
      </tr>
      <tr>
         <td>locatie</td>
         <td id="location">asd</td>
      </tr>
      <tr>
         <td>noua locatie tip</td>
         <td>
            <select name="locationType" id="item-form-locationType" onchange="getComboA(this)">
               <option value="null"></option>
               <option value="deposit">deposit</option>
               <option value="user">user</option>
            </select></td>
      </tr>
      <tr>
         <td>noua locatie nume</td>
         <td><select name="selectedPlace" id="item-form-selectData"></select></td>
      </tr>
      
      
   </table>
   <button type="submit">trimite</button>
</form>