<div>
   <form class="item-form" id="item-formid" method="post">
      <br>
      <center>
         <h2>Item</h2>
      </center>
      <table class="item-form-data">
         <tr>
            <th>name :</th>
            <th>
               <input type="text" placeholder="Enter the name of item" name="name" required id="item-form-name" />
            </th>
         </tr>
         <tr>
            <th>series :</th>
            <th>
               <input type="text" placeholder="Enter the series of item" name="series" required id="item-form-series" />
            </th>
         </tr>
         <tr>
            <th>type :</th>
            <th>
               <select name="type" id="item-form-type">
               </select>
            </th>
         </tr>
         <tr>
            <th>where it will be ? :</th>
            <th>
               <select name="locationType" id="item-form-locationType" onchange="getComboA(this)">
                  <option value="null"></option>
                  <option value="deposit">deposit</option>
                  <option value="user">user</option>
               </select>
            </th>
         </tr>
         <tr>
            <th>select</th>
            <th>
               <select name="selectedPlace" id="item-form-selectData"></select>
            </th>
         </tr>
         <tr>
            <th></th>
            <th>
               <center>
                  <button type="submit" class="submit-item">submit</button>
               </center>
            </th>
         </tr>
      </table>
      <br>
   </form>

</div>