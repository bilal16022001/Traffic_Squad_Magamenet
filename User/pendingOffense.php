<?php
  session_start();

  if(isset($_SESSION['phone_user'])){
    $title="Pending  Offense";
    include "init.php";
    include "SideBar.php";
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    if($do == "Manage"){
?>
   <div class="parent">
   <?php
    $phoneUser  = $_SESSION['phone_user'];
     $allOffense = getdb("*","offenses","WHERE","paidStatut = 0 AND PaidBy = 0 AND Phone = '$phoneUser'");
      if(!empty($allOffense)){
    ?>
        <h2 class="text-center mb-3">Pending Offenses</h2>

        <div class="container police">
                    <div class="table-responsive">
                        <table class="main-table text-center table table-bordered">
                            <tr>
                                 <td>#</td>
                                 <td>Offense Number</td>
                                 <td>offender Name</td>
                                 <td>offender Phone</td>
                                 <td>Paid Statuts</td>
                                 <td>offense date</td>
                                 <td>Paid By</td>
                                 <td>Action</td>
                            </tr>
                            <?php
                             foreach($allOffense as $offense){
                                echo "<tr>";
                                   echo "<td>" . $offense['id'] . "</td>";
                                   echo "<td>" . $offense['offense_number']  . "</td>";
                                   echo "<td>" . $offense['offender_name'] . "</td>";
                                   echo "<td>" . $offense['Phone'] . "</td>";
                                   echo "<td>";
                                      if($offense['paidStatut']==0){
                                        echo "not paid yet";
                                      }else{
                                         echo "completed";
                                      }
                                   echo "</td>";
                                   echo "<td>" . $offense['offense_date'] . "</td>";
                                   echo "<td>";
                                       if($offense['PaidBy']==0){
                                          echo "not yet";
                                       } else if($offense['PaidBy']==1){
                                          echo "Traffic Police";
                                       }else{
                                          echo "Offense";
                                       }
                                     echo "</td>";
                                   echo "<td>";
                                      echo '<a href="allOffense.php?do=view&id='. $offense['id'] .'" >view</a>';
                                   echo "</td>";
                                echo "</tr>";
                             }
                            
                            ?>
                      </table>
            </div>
   </div>
<?php 
      }
      else{
         echo "there is not pending offenses";
      }
    }

    if($do == "view"){
         $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
         $items = getdb("*","offenses","WHERE","id = '$id'");
         $_SESSION['off_id'] = $id;
       ?>
        <div class="parent">
         
        <div class="container allof">
                    <div class="table-responsive">
                        <table class="main-table text-center table table-bordered">
                            <?php
                             foreach($items as $item){
                              echo "<tr>";
                                    echo "<td>offense number</td>";
                                    echo "<td>" . $item['offense_number']  . "</td>";
                              echo "</tr>";
                                echo "<tr>";
                                   echo "<td>offender_name</td>";
                                   echo "<td>" . $item['offender_name']  . "</td>";
                                echo "</tr>";
                                echo "<tr>";
                                       echo "<td>offense date</td>";
                                       echo "<td>" . $item['offense_date']  . "</td>";
                                echo "</tr>";
                                echo "<tr>";
                                       echo "<td>license number</td>";
                                       echo "<td>" . $item['license_number']  . "</td>";
                                echo "</tr>";
                                echo "<tr>";
                                       echo "<td>place violation</td>";
                                       echo "<td>" . $item['place_violation']  . "</td>";
                                echo "</tr>";
                                echo "<tr>";
                                       echo "<td>Vehicle number</td>";
                                       echo "<td>" . $item['Vehicle_number']  . "</td>";
                                echo "</tr>";
                                echo "<tr>";
                                    echo "<td>offender Phone</td>";
                                    echo "<td>" . $item['Phone']  . "</td>";
                                echo "</tr>";
                                echo "<tr>";
                                    echo "<td>Paid Statuts</td>";
                                    echo "<td>";
                                          if($item['paidStatut']==0){
                                          echo "not paid yet";
                                          }else{
                                             echo "completed";
                                          }
                                   echo "</td>";
                                echo "</tr>";
                                echo "<tr>";
                                    echo "<td>offense date</td>";
                                    echo "<td>" . $item['offense_date']  . "</td>";
                                echo "</tr>";
                                echo "<tr>";
                                    echo "<td>Paid by</td>";
                                    echo "<td>";
                                    if($item['PaidBy']==0){
                                       echo "not yet";
                                    } else if($item['PaidBy']==1){
                                       echo "Traffic Police";
                                    }else{
                                       echo "Offense";
                                    }
                                    echo "</td>";
                                echo "</tr>";
                                echo "<tr>";
                                       echo "<td>vehicle image</td>";
                                       echo "<td>";
                                       ?>
                                           <img  src="uploads/attach/<?php echo $item['image'] ?>"/>
                                       <?php
                                       echo "</td>";
                                echo "</tr>";
                                echo "<tr>";
                                    echo "<td>amount</td>";
                                    echo "<td>" . $item['amount']  . "</td>";
                                echo "</tr>";
           
                             }
                            
                            ?>
                      </table>
            </div>
        </div>
       <?php
    }


    include $tp . "/footer.php";
  } else{
    header("Location: login.php");
}