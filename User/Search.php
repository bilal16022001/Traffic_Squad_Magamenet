<?php
  session_start();

  if(isset($_SESSION['phone_user'])){
    $title="Search";
    include "init.php";
    include "SideBar.php";
   
    if($_SERVER['REQUEST_METHOD'] == "POST"){

         $phone_user = $_SESSION['phone_user'];
         $offens = $_POST['offens'];
         $items = getdb("*","offenses","WHERE","offender_name LIKE '%$offens%' AND Phone = '$phone_user'");

    }
?>
     <div class="parent">
    <div class="search">
       <form class="mb-2" method="POST">
          <label>search Offense</label>
          <input type="text" name="offens" required /><br/>
          <input class="btn btn-primary" type="submit" value="submit" />
       </form>
    </div>
    <?php
        if(!empty($items)){
     ?>
    <h3 class="text-center mb-3">Result "<?php echo $offens; ?>" keyword</h3>

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