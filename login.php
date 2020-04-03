<?php
ob_start();
session_start();
?>
<html lang = "en">

<head>
   <title>BeeJee - test task - LOGIN</title>
   <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" rel="stylesheet">
   <link href="styles/main.css" rel="stylesheet">
</head>

<body>

   <h2>Enter Username and Password</h2> 
   <div class="container form-signin">

      <?php
      $msg = '';

      if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {

            if ($_POST['username'] == 'admin' && $_POST['password'] == '123') {
               $_SESSION['valid'] = true;
               $_SESSION['timeout'] = time();
               $_SESSION['username'] = 'admin';

               echo 'You have entered valid use name and password';
               header('Refresh: 2; URL = index.php');
         } else {
            $msg = 'Wrong username or password';
         }
      } ?>
</div>

<div class = "container">

   <form class = "form-signin" role = "form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);             ?>" method = "post">
      <h4 class = "form-signin-heading"><?php echo $msg; ?></h4>
      <input type = "text" class = "form-control" name = "username" placeholder = "username = admin" required autofocus></br>
      <input type = "password" class = "form-control" name = "password" placeholder = "password = 123" required>
      <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "login">Login</button>
   </form>

   Click here to clean <a href = "logout.php" tite = "Logout">Session.

</div> 

</body>
</html>