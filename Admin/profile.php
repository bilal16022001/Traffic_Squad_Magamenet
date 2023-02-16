<?php
  session_start();
  if(isset($_SESSION['email_admin'])){
      $title="Profile";
      include "init.php";
      $email = $_SESSION['email_admin'];
      include "SideBar.php";
     ?>
      <div class="parent profile">
          <h2 class="text-center mb-4">User Profile</h2>

          <ul>
              <?php
                 $admin = getdb("*","users","WHERE","email = '$email'");
                  foreach($admin as $info){
                     ?>
                      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                            <li><span>User Name</span>  <input type="text" name="userName" value="<?php echo $info['userName'] ?>" /></li>
                            <input type="hidden" name="pass" value="<?php echo $info['password'] ?>" />
                            <li><span>password</span> <input type="text" name="password" value=""  /></li>
                            <li><span>Phone</span> <input type="text" name="phone" value="<?php echo $info['phone'] ?>" /></li>
                            <li><span>Email</span> <input type="text" name="email" value="<?php echo $info['Email'] ?>" /></li>
                            <input class="btn btn-primary d-block m-auto" type="submit" value="update" />
                      </form>
                     <?php
                  }
              ?>
          </ul>
      </div>
     <?php
       
     if($_SERVER['REQUEST_METHOD'] == "POST"){
            $userName  = $_POST['userName'];
            $phone     = $_POST['phone'];
            $password  = $_POST['password'];
            $email     = $_POST['email'];
            $oldPss    = $_POST['pass'];
            $sqlPas = "";

            if(empty($password)){
              
              $sqlPas  = $oldPss;
           
            }else{
  
              $sqlPas = sha1($password);
            }

            $email_admin = $_SESSION['email_admin'];
            $admin_id = getdb("id","users","WHERE","email = '$email_admin'");
            $id = $admin_id[0]['id'];
            $_SESSION['email_admin'] = $email;
            
            $stmt = $con->prepare("UPDATE `users` SET `userName` = '$userName' , `email` = '$email' , `phone` = '$phone' , `password` = '$sqlPas' WHERE `users`.`id` = '$id'  ");
            $stmt->execute();
            $count = $stmt->rowCount();

            echo "<div class='alert alert-success'>$count  Record updated</div>";
            header("Refresh:0;");
     }
  

   include $tp . "/footer.php";   
  }
else {
    header("Location: login.php");
   }