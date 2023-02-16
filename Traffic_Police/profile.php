<?php
  session_start();
  if(isset($_SESSION['email_police'])){
      $title="Profile";
      include "init.php";
      $email = $_SESSION['email_police'];
      include "SideBar.php";
     ?>
      <div class="parent profile">
          <h2 class="text-center mb-4">User Profile</h2>

          <ul>
              <?php

                 $admin = getdb("*","traffic_police","WHERE","Email = '$email'");
                  foreach($admin as $info){
                         $_SESSION['policeid'] = $info['id'];
                     ?>
                      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                            <li><span>User Name</span> <input type="text" name="Name" value="<?php echo $info['Name'] ?>" /></li>
                            <input type="hidden" name="pass" value="<?php echo $info['Password'] ?>" />
                            <li><span>password</span> <input type="text" name="password" value=""  /></li>
                            <li><span>Phone</span> <input type="text" name="phone" value="<?php echo $info['Phone'] ?>" /></li>
                            <li><span>Email</span><input type="text" name="Email" value="<?php echo $info['Email'] ?>" /></li>
                            <li><span>Address</span><input type="text" name="Address" value="<?php echo $info['Address'] ?>" /></li>
                            <input class="btn btn-primary d-block m-auto" type="submit" value="update" />
                      </form>
                     <?php
                  }
              ?>
          </ul>
      </div>
     <?php
       
     if($_SERVER['REQUEST_METHOD'] == "POST"){
            $Name = $_POST['Name'];
            $phone     = $_POST['phone'];
            $password  = $_POST['password'];
            $email     = $_POST['Email'];
            $Address     = $_POST['Address'];
            $oldPss    = $_POST['pass'];
            $sqlPas = "";
            $id =  $_SESSION['policeid'];

            if(empty($password)){
              
              $sqlPas  = $oldPss;
           
            }else{
  
              $sqlPas = sha1($password);
            }
            
            $_SESSION['email_police'] = $email;

            $stmt = $con->prepare("UPDATE `traffic_police` SET `Name` = '$Name' , `Email` = '$email' , `Phone` = '$phone' , `Password` = '$sqlPas' , `Address` = '$Address'  WHERE `traffic_police`.`id` = '$id'  ");
            $stmt->execute();
            $count = $stmt->rowCount();

            echo "<div class='alert alert-success'>$count  Record updated</div>";
     }
  

   include $tp . "/footer.php";   
  }
else {
    header("Location: login.php");
   }