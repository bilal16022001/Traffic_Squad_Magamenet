<?php
  session_start();
  if(isset($_SESSION['phone_user'])){
      $title="Profile";
      include "init.php";
      $phone_user = $_SESSION['phone_user'];
      include "SideBar.php";
     ?>
      <div class="parent profile">
          <h2 class="text-center mb-4">User Profile</h2>

          <ul>
              <?php
                 $admin = getdb("*","offenses","WHERE","Phone = '$phone_user'");
                  foreach($admin as $info){
                    $_SESSION['userid'] = $info['id'];
                    // $_SESSION['userid'] = $info['id'];
                     ?>
                      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                            <li><span>User Name</span><input type="text" name="userName" value="<?php echo $info['offender_name'] ?>" /></li>
                            <input type="hidden" name="pass" value="<?php echo $info['password'] ?>" />
                            <li><span>password</span><input type="text" name="password" value=""  /></li>
                            <input type="hidden" name="hiddphone" value="<?php echo $info['Phone'] ?>" />
                            <li><span>Phone</span><input type="text" name="phone" value="<?php echo $info['Phone'] ?>" /></li>
                            
                            <input class="btn btn-primary d-block m-auto" type="submit" value="update" />
                      </form>
                     <?php
                  }
              ?>
          </ul>
      </div>
     <?php
       
     if($_SERVER['REQUEST_METHOD'] == "POST"){
            $userName = $_POST['userName'];
            $phone     = $_POST['phone'];
            $password  = $_POST['password'];
            $oldPss    = $_POST['pass'];
            $id = $_SESSION['userid'];
            $sqlPas = "";

            if(!empty($password)){
              
              $sqlPas  = sha1($password);
  
           
            }else{
  
              $sqlPas = $oldPss;

            }



            $geOffens = getdb("id","offenses","WHERE","Phone = '$phone_user'");
            $offenseId = $geOffens[0]['id'];
             
            $stmt2 = $con->prepare("UPDATE `offenses` SET `offender_name` = '$userName' , `Phone` = '$phone' , `password` = '$sqlPas' WHERE `offenses`.`id` = '$offenseId' ");
            $stmt2->execute();
              $count = $stmt2->rowCount();

            $_SESSION['phone_user'] = $phone;

            echo "<div class='alert alert-success'>$count  Record updated</div>";
            header("Refresh:0;");
     }
  

   include $tp . "/footer.php";   
  }
else {
    header("Location: login.php");
   }