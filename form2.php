<?php
if(isset($_POST["button"])) { 
  header('Location: login.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulir</title>
  <link rel="stylesheet" href="reg.css">
</head>
<body>
  <div class="container">
    <h2> Register Page</h2>
    <form action="konekregis.php" method="post">
      <input type="hidden" name="register" value="1">
      <div class="form-group">
        <label for="nama"> Name:</label>
        <input type="text" id="nama" name="username" required>
      </div>
      <div class="form-group">
        <label for="password"> Password:</label>
        <input type="text" id="password" name="password" required>
      </div>
      <div class="form-group">
        <label for="email"> Email:</label>
        <input type="email" id="email" name="email" required>
      </div>
      
      <button type="submit" name="button" >Submit</button>
    </form>
  </div>
</body>
</html>