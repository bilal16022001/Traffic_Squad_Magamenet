<?php
   session_start();

   $title="login";
   include "init.php";

   if($_SERVER['REQUEST_METHOD'] == "POST"){

       $email = $_POST['email'];
       $pass = sha1($_POST['password']);

       $stmt = $con->prepare("SELECT * FROM `traffic_police` WHERE Email = ? AND password = ?");
       $stmt->execute(array($email,$pass));
       $count = $stmt->rowCount();

    
       if($count > 0) {
         $_SESSION['email_police']=$email;
         header("Location: Dashboard.php");
         exit();


       }
    
   }

?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" class="adminForm" method="POST">
    <div>
        <h2 class="mb-3">Login</h2>
        <input class="form-control" type="email" placeholder="your email" name="email" /><br/>
        <input class="form-control" type="password" placeholder="password"  name="password" /><br/>
        <input class="form-control mb-3 btn btn-primary" type="submit" value="login" /><br/>
        <a href="#">Go To webSite</a>
    </div>
</form>

<?php

 include $tp . "/footer.php";

?>