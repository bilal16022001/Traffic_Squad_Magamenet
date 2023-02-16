<?php
  session_start();

  if(isset($_SESSION['email_admin'])){
    $title="Traffic Police";
    include "init.php";
    include "SideBar.php";
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    if($do == "Manage"){
?>
 <div class="parent">
    <?php

     $stmt = $con->prepare("SELECT 
            traffic_police.*,police_station.Police_station AS nameSta
        FROM
            traffic_police
        INNER JOIN
            police_station
        ON
            traffic_police.Police_station = police_station.id
    ");
    $stmt->execute();
    $trafficPo = $stmt->fetchAll();

      if(!empty($trafficPo)){
    ?>
        <h2 class="text-center mb-3">Manage info Police</h2>
        <a class="addSt" href="TrafficPolice.php?do=Add">Add Police</a>
        <div class="container police">
                    <div class="table-responsive">
                        <table class="main-table text-center table table-bordered">
                            <tr>
                                 <td>#</td>
                                 <td>Police ID</td>
                                 <td>Name</td>
                                 <td>Station</td>
                                 <td>Mobile Number</td>
                                 <td>Email</td>
                                 <td>Action</td>
                            </tr>
                            <?php
                             foreach($trafficPo as $traffic){
                                echo "<tr>";
                                   echo "<td>" . $traffic['id'] . "</td>";
                                   echo "<td>" . $traffic['Police_id'] . "</td>";
                                   echo "<td>" . $traffic['Name'] . "</td>";
                                   echo "<td>" . $traffic['nameSta'] . "</td>";
                                   echo "<td>" . $traffic['Phone'] . "</td>";
                                   echo "<td>" . $traffic['Email'] . "</td>";
                                   echo "<td>";
                                      echo '<a href="TrafficPolice.php?do=Edit&id='. $traffic['id'] .'" >Edit</a>';
                                      echo '<a class="delet" href="TrafficPolice.php?do=Delete&id='. $traffic['id'] .'" >Delete</a>';
                                   echo "</td>";
                                echo "</tr>";
                             }
                            
                            ?>
                      </table>
            </div>
        </div>
      <?php  } 
        else{
        echo "There is not police station";
        echo '<a class="addSt" href="TrafficPolice.php?do=Add">Add Police</a>';
       }?>
     </div>
<?php

  }

  if($do == "Add"){
    ?>
        <div class="parent">
          <div class="AddPolice">
        <h2 class="mb-2">Add Police Detail</h2>
          <form action="" method="POST">
              <label>Police Station</label>
              <select name="station">
                <!-- <option>Select Police station</option> -->
                 <?php
                 $policeStation = getdb("*","police_station");
                   if(!empty($policeStation)){
                      foreach($policeStation as $st){
                         ?>
                                <option value="<?php echo $st['id'] ?>"><?php echo $st['Police_station'] ?></option>
                         <?php
                           
                      }
                   }
                 ?>
              </select>
              <br/>
              <label>Police ID</label>
              <input type="text"  name="PoliceId"  class="mb-2" requried /><br/>
              <label>Name</label>
              <input type="text"  name="Name"  class="mb-2" requried /><br/>
              <label>Email</label>
              <input type="text"  name="Email"  class="mb-2" requried /><br/>
              <label>Mobile Number</label>
              <input type="text"  name="Phone"  class="mb-2"  requried /><br/>
              <label>Address</label>
              <input type="text"  name="Address"  class="mb-2" requried /><br/>
              <label>Password</label>
              <input type="text"  name="password"  class="mb-2" requried /><br/>
              <input class="btn btn-primary" type="submit" value="Add" />
          </form>
        </div>
    </div>
    <?php

   // insert data to database

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $station = $_POST['station'];
        $policeId = $_POST['PoliceId'];
        $Name    = $_POST['Name'];
        $Email = $_POST['Email'];
        $Phone = $_POST['Phone'];
        $Address = $_POST['Address'];
        $password = sha1($_POST['password']);

        $check = checkitem("Police_station","traffic_police","WHERE","Police_station = $station");
        if($check == 0){
          $stmt = $con->prepare("INSERT INTO `traffic_police`(`Police_station`,`Police_id`,`Name`,`Email`,`Phone`,`Address`,`Password`)VALUES('$station','$policeId','$Name','$Email','$Phone','$Address','$password')");
          $stmt->execute();
        }else{
            echo "<div class='alert alert-danger'>this is already</div>";
        }
    }
  }
  if($do == "Edit"){
    $editid = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
    $policeStation = getdb("*","traffic_police","WHERE","id = '$editid'");
    $poId = $policeStation[0]['Police_station'];
      ?>
  <div class="parent">
          <div class="AddPolice">
        <h2 class="mb-2">Edit Police Detail</h2>
        <?php
                   $stmt = $con->prepare("SELECT 
                   traffic_police.*,police_station.Police_station AS nameSta
                          FROM
                              traffic_police
                          INNER JOIN
                              police_station
                          ON
                              traffic_police.Police_station = police_station.id
                      ");
                      $stmt->execute();
                      $trafficPoEdit = $stmt->fetchAll();
                      $_SESSION['password_police'] = $trafficPoEdit[0]['Password'];
        ?>
          <form action="" method="POST">
              <label>Police Station</label>
              <select name="station">
                <!-- <option>Select Police station</option> -->
                 <?php
                 $policeStation = getdb("*","police_station");
     
                   if(!empty($policeStation)){
                      foreach($policeStation as $st){
                         ?>
                                <option value="<?php echo $st['id'] ?>" <?php if($poId==$st['id']){echo "selected";} ?>><?php echo $st['Police_station'] ?></option>
                         <?php
                           
                      }
                   }
                 ?>
              </select>
              <br/>
              <label>Police ID</label>
              <input type="text"  name="PoliceId" value="<?php echo $trafficPoEdit[0]['Police_id'] ?>"  class="mb-2" requried /><br/>
              <label>Name</label>
              <input type="text"  name="Name" value="<?php echo $trafficPoEdit[0]['Name'] ?>"  class="mb-2" requried /><br/>
              <label>Email</label>
              <input type="text"  name="Email" value="<?php echo $trafficPoEdit[0]['Email'] ?>"   class="mb-2" requried /><br/>
              <label>Mobile Number</label>
              <input type="text"  name="Phone" value="<?php echo $trafficPoEdit[0]['Phone'] ?>"   class="mb-2"  requried /><br/>
              <label>Address</label>
              <input type="text"  name="Address" value="<?php echo $trafficPoEdit[0]['Address'] ?>"   class="mb-2" requried /><br/>
              <label>Password</label>
              <input type="text"  name="password"  class="mb-2" requried /><br/>
              <input class="btn btn-primary" type="submit" value="update" />
          </form>
        </div>
    </div>     
     <?php

       // update dataBase

      if($_SERVER['REQUEST_METHOD'] == "POST"){
            $station = $_POST['station'];
            $policeId = $_POST['PoliceId'];
            $Name    = $_POST['Name'];
            $Email = $_POST['Email'];
            $Phone = $_POST['Phone'];
            $Address = $_POST['Address'];
            $password = sha1($_POST['password']);

            $pass="";
             if(!empty($password)){
                 $pass=$password;
             }else{
                $pass = sha1($_SESSION['password_police']);
             }
             
           $checkitem = checkitem("*","traffic_police","WHERE","Police_station = '$station' AND id!='$editid'");
          //  echo $checkitem;
           if($checkitem == 0){
               $stmt = $con->prepare("UPDATE `traffic_police` SET `Police_station` = '$station' , `Police_id` = '$policeId' , `Name` = '$Name' , `Email` = '$Email' , `Phone` = '$Phone' , `Address` = '$Address' , `Password` = '$pass'  WHERE `traffic_police`.`id` = '$editid' ");
               $stmt->execute();
           }else{
              echo "<div class='alert alert-danger'>this is already</div>";
           }
      }
  }
  
  if($do == "Delete"){
        $deletid = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        $deletItem = deleteItem("traffic_police","WHERE id=$deletid");

     ?>
      <div class="alert alert-success">
        <?php echo $deletItem . " Record Deleted" ?>
      </div>
     <?php
}


  include $tp . "/footer.php";

}else{
    header("Location: login.php");
}