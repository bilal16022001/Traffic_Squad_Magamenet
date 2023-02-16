
<?php
  session_start();

  if(isset($_SESSION['email_police'])){
    $title="Add Offense";
    include "init.php";
    include "SideBar.php";
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
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

    if($do == "Manage"){
?>
    <div class="parent">
        <div class="newOffense">
            <h2>Offense Detail</h2>
            <form action="?do=Insert" method="POST" enctype="multipart/form-data">
               <div class="row">
                  <div class="col-lg-6">
                      <label>License number</label>
                      <input type="text" name="License" required /><br/>
                      <label>Offender name</label>
                      <input type="text" name="name" required /><br/>
                      <label>place violation</label>
                      <input type="text" name="place" value="<?php echo $trafficPo[0]['nameSta'] ?>" required /><br/>
                      <label>section</label>
                      <input type="text" name="section" required /><br/>
                      <label>fine Amount</label>
                      <input type="text" name="Amount" required /><br/>
                  </div>
                  <div class="col-lg-6">
                      <label>Vehicle number</label>
                      <input type="text" name="Vehicle_number" required /><br/>
                      <label>Offender phone</label>
                      <input type="text" name="phone" required /><br/>
                      <label>image</label>
                      <input type="file" name="image" required /><br/>
                  </div>
               <div>
                <input type="submit" value="submit" />
            </form>
        </div>
    </div>
<?php 
 
    }

    if($do == "Insert"){

        $License = $_POST['License'];
        $offenderName = $_POST['name'];
        $place = $_POST['place'];
        $section = $_POST['section'];
        $Amount = $_POST['Amount'];
        $Vehicle_number = $_POST['Vehicle_number'];
        $phone = $_POST['phone'];

        $filename = $_FILES['image']['name'];
        // $type  = $_FILES['image']['Type'];
        $size  = $_FILES['image']['size'];
        $tmp   = $_FILES['image']['tmp_name'];
        $imageAr = explode(",",$filename);
        $fileEx = strtolower(end($imageAr));
        $typeImage = array("jpg","png","jpeg","jfif","gif");

        $arrErrour = [];
        if(!in_array($fileEx,$typeImage)){
            $arrErrour[] = "<div class='alert alert-danger'>ot allowed this exetntion</div>";
        }
        if($size > 4194304){
            $arrErrour = "<div class='alert alert-danger'>image can't be larger <strong>4MB</strong></div>";
        }

        if(!empty($arrErrour)){
            $offense_number = rand(0,10000000);
             $attach = rand(0,1000000) .  "_" . $filename;
             move_uploaded_file($tmp,"uploads\attach\\" . $attach);

             $stmt = $con->prepare("INSERT INTO `offenses`(`offense_number`,`offense_date`,`license_number`,`offender_name`,`place_violation`,`section`,`amount`,`Vehicle_number`,`Phone`,`image`)VALUES('$offense_number',now(),'$License','$offenderName','$place','$section','$Amount','$Vehicle_number','$phone','$attach') ");
             $stmt->execute();

             // insert data to user for login 
             $userPas = sha1($phone);

            $stmt2 = $con->prepare("INSERT INTO `users`(`userName`,`phone`,`password`)VALUES('$offenderName','$phone','$userPas')");
            $stmt2->execute();
        }


    }

    include $tp . "/footer.php";
}
else{
  header("Location: login.php");
}