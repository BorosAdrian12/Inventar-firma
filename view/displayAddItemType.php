<div>
   <form action="/api" method="post">
      <label for="itemType">Numele tipului de Produs</label>
      <input type="text" name="itemType" value=""><br>
      <br>
      <br>
      <input type="submit" value="Submit" onclick="submitForm(this.form, '/api/addItemType'); return false;">
   </form>
</div>