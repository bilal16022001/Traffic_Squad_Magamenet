<?php
  session_start();

  if(isset($_SESSION['email_police'])){
    $title="dashboard";
    include "init.php";
    include "SideBar.php";
   
?>
  <div class="dashboard">

      <div class="admin">

        <div class="">
        <div class="con">
        <i class="fas fa-folder"></i>
           </div>
           <div class="">
             <h4>Total Offenses</h4>
             <?php
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

               $count = CountItem("id","offenses","WHERE place_violation = '$station'");
             ?>
             <span><?php echo $count; ?></span>
           </div>
           <div class="view">
              <a href="allOffense.php">View All</a>
           </div>
        </div>

        <div class="">
        <div class="con">
        <i class="fas fa-times"></i>
           </div>
           <div class="">
             <h4>Total Pending Offenses</h4>
             <?php
               $count = CountItem("id","offenses","WHERE paidStatut = 0 AND PaidBy = 0 AND place_violation = '$station'");
             ?>
             <span><?php echo $count; ?></span>
           </div>
           <div class="view">
              <a href="pendingOffense.php">View All</a>
           </div>
        </div>

        <div class="">
        <div class="con">
          <i class="fas fa-check"></i>
        </div>
           <div class="">
             <h4>Total Completed Offenses</h4>
             <?php
               $count = CountItem("id","offenses","WHERE paidStatut != 0 AND PaidBy != 0 AND place_violation = '$station'");
             ?>
             <span><?php echo $count; ?></span>
           </div>
           <div class="view">
              <a href="completOffense.php">View All</a>
           </div>
        </div>

      </div>
  </div>
<?php 
 include $tp . "/footer.php";


} else{
    header("Location: login.php");
}