<?php
  session_start();

  if(isset($_SESSION['email_admin'])){
    $title="Police Station";
    include "init.php";
    include "SideBar.php";
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    if($do == "Manage"){
?>
   <div class="parent">
    <?php
     $policeStation = getdb("*","police_station");
      if(!empty($policeStation)){
    ?>
        <h2 class="text-center mb-3">Manage Police Stataion</h2>
        <a class="addSt" href="PoliceStation.php?do=Add">Add Station</a>
        <div class="container police">
                    <div class="table-responsive">
                        <table class="main-table text-center table table-bordered">
                            <tr>
                                 <td>#</td>
                                 <td>Police Station</td>
                                 <td>Police Station Code</td>
                                 <td>Creation Date</td>
                                 <td>Action</td>
                            </tr>
                            <?php
                             foreach($policeStation as $station){
                                echo "<tr>";
                                   echo "<td>" . $station['id'] . "</td>";
                                   echo "<td>" . $station['Police_station'] . "</td>";
                                   echo "<td>" . $station['Police_code'] . "</td>";
                                   echo "<td>" . $station['Date'] . "</td>";
                                   echo "<td>";
                                      echo '<a href="PoliceStation.php?do=Edit&id='. $station['id'] .'" >Edit</a>';
                                      echo '<a class="delet" href="PoliceStation.php?do=Delete&id='. $station['id'] .'" >Delete</a>';
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
        echo '<a class="addSt" href="PoliceStation.php?do=Add">Add Station</a>';
       }?>
     </div>

    <?php }


    if($do == "Add"){
        ?>
        <div class="parent">
          <div class="editPolice">
        <h2 class="mb-2">Add Police Station</h2>
          <form action="" method="POST">
              <label>Police Station Name</label>
              <input type="text" placeholder="Name Station" name="NameStation" class="mb-2" /><br/>
              <label>Police Station Code</label>
              <input type="text" placeholder="Code Station" name="CodeStation"  class="mb-2"  /><br/>
              <input class="btn btn-primary" type="submit" value="Add" />
          </form>
        </div>
    </div>
    <?php
     if($_SERVER['REQUEST_METHOD'] == "POST"){
        $NameStation = $_POST['NameStation'];
        $CodeStation = $_POST['CodeStation'];

        $checkitem = checkitem("*","police_station","WHERE","Police_station = '$NameStation'");
        if($checkitem == 0){
             $stmt = $con->prepare("INSERT INTO `police_station`(`Police_station`,`Police_code`,`Date`)VALUES('$NameStation','$CodeStation',now()) ");
             $stmt->execute();
        }
        else{
          echo "<div class='alert alert-danger'>this is already</div>";
       }
     }

    }



    if($do == "Edit"){
      $editid = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
      $policeStation = getdb("*","police_station","WHERE","id = '$editid'");

        ?>
           <div class="parent">
             <div class="editPolice">
            <h2 class="mb-2">Edit Police Station</h2>
              <form action="" method="POST">
                  <label>Police Station Name</label>
                  <input type="text" placeholder="" name="NameStation" class="mb-2"  value="<?php echo $policeStation[0]['Police_station']; ?>" /><br/>
                  <label>Police Station Code</label>
                  <input type="text" placeholder="" name="CodeStation"  class="mb-2" value="<?php echo $policeStation[0]['Police_code']  ?>" /><br/>
                  <input class="btn btn-primary" type="submit" value="update" />
              </form>
           </div>
        </div>
        <?php

        if($_SERVER['REQUEST_METHOD'] == "POST"){
             $NameStation = $_POST['NameStation'];
             $CodeStation = $_POST['CodeStation'];
             $checkitem = checkitem("*","police_station","WHERE","Police_station = '$NameStation' AND id!='$editid'");
            //  echo $checkitem;
             if($checkitem == 0){
                 $stmt = $con->prepare("UPDATE `police_station` SET `Police_station` = '$NameStation' , `Police_code` = '$CodeStation' WHERE `police_station`.`id` = '$editid' ");
                 $stmt->execute();
             }else{
                echo "<div class='alert alert-danger'>this is already</div>";
             }
        }
    }
    
    if($do == "Delete"){
        $deletid = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        $deletItem = deleteItem("police_station","WHERE id=$deletid");

         ?>
          <div class="alert alert-success">
            <?php echo $deletItem . " Record Deleted" ?>
          </div>
         <?php
    }

    ?>

<?php 


 include $tp . "/footer.php";


} else{
    header("Location: login.php");
}