<?php
   session_start();

   $title="login";
   include "init.php";

   if($_SERVER['REQUEST_METHOD'] == "POST"){

       $phone = $_POST['phone'];
       $pass = sha1($_POST['password']);

       $count = checkitem("*","offenses","WHERE","phone = '$phone' AND password = '$pass'");
   

       if($count > 0) {
         $_SESSION['phone_user']=$phone;
         header("Location: Dashboard.php");
         exit();


       }
    
   }

?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" class="adminForm" method="POST">
    <div>
        <h2 class="mb-3">Login</h2>
        <input class="form-control" type="text" placeholder="number phone" name="phone" /><br/>
        <input class="form-control" type="password" placeholder="password"  name="password" /><br/>
        <input class="form-control mb-3 btn btn-primary" type="submit" value="login" /><br/>
        <a href="#">Go To webSite</a>
    </div>
</form>

<?php

 include $tp . "/footer.php";

?>