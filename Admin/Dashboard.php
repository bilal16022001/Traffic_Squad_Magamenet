<?php
  session_start();

  if(isset($_SESSION['email_admin'])){
    $title="dashboard";
    include "init.php";
    include "SideBar.php";
   
?>
  <div class="dashboard">

      <div class="admin">
        <div class="">
           <div class="con">
           <i class="fas fa-user"></i>
           </div>
           <div class="">
             <h4>Total Police</h4>
             <?php
                $count = CountItem("id","traffic_police");
              ?>
             <span><?php echo $count; ?></span>
           </div>
           <div class="view">
              <a href="TrafficPolice.php">View All</a>
           </div>
        </div>

        <div class="">
        <div class="con">
        <i class="fas fa-building"></i>
           </div>
           <div class="">
             <h4>Total Police Station</h4>
             <?php
               $count = CountItem("id","police_station");
             ?>
             <span><?php echo $count; ?></span>
           </div>
           <div class="view">
              <a href="PoliceStation.php">View All</a>
           </div>
        </div>

        <div class="">
        <div class="con">
        <i class="fas fa-folder"></i>
           </div>
           <div class="">
             <h4>Total Offenses</h4>
             <?php
               $count = CountItem("id","offenses");
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
               $count = CountItem("id","offenses","WHERE paidStatut = 0 AND PaidBy = 0");
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
               $count = CountItem("id","offenses","WHERE paidStatut != 0 AND PaidBy != 0");
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