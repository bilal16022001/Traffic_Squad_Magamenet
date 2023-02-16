<?php
  session_start();

  if(isset($_SESSION['email_police'])){
    $title="Reports";
    include "init.php";
    include "SideBar.php";

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        
      $emailPolice = $_SESSION['email_police'];
      $stmt = $con->prepare("SELECT 
               traffic_police.*,police_station.Police_station AS nameSta
         FROM
            traffic_police
         INNER JOIN
            police_station
         ON
               traffic_police.Police_station = police_station.id
         WHERE
               Email = '$emailPolice'
    ");
      $stmt->execute();
      $trafficPo = $stmt->fetchAll();
      $station = $trafficPo[0]['nameSta'];

      $fromdate = $_POST['fromdate'];
      $todate = $_POST['todate'];

      $items = getdb("*","offenses","WHERE","offense_date BETWEEN '$fromdate' AND '$todate' AND place_violation = '$station'");

 }
   
?>
   <div class="parent">
    <div class="reports">
       <form method="POST">
          <label>From date</label>
          <input type="date" name="fromdate" required /><br/>
          <label>To date</label>
          <input type="date" name="todate" required /><br/>
          <input class="btn btn-primary" type="submit" value="submit" />
       </form>
    </div>
    <?php
        if(!empty($items)){
     ?>
    <h3 class="text-center mb-3">Report from <?php echo $fromdate; ?> to <?php echo $todate; ?></h3>

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
                        foreach($items as $offense){
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
                                   }else if($offense['PaidBy']==2){
                                      echo "Administartion";
                                   }else{
                                      echo "Offense";
                                   }
                                 echo "</td>";
                               echo "<td>";
                                  echo '<a href="allOffense.php?do=view&id='. $offense['id'] .'" >view</a>';
                               echo "</td>";
                            echo "</tr>";
                         }
                        
                       }else{
                             echo "there is nothing";
                       }
                    ?>
              </table>
    </div>
</div>
   </div>
<?php 
   include $tp . "/footer.php";
}else{
    header("Location: login.php");
}