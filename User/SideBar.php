
<div class="home">
        <div class="s">
            <div class="sidebar">
                <div class="profile">
                <?php
                    $phone_user = $_SESSION['phone_user'];
                    $user = getdb("*","offenses","WHERE","Phone = '$phone_user'");

                ?>
                    <img src="uploads/attach/user.jpg" />
                       <a class="nav-link ad  dropdown-toggle  " dropdown-toggle href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">User : <?php echo $user[0]['offender_name']; ?> </a>

                        <ul class="dropdown-menu dropMenu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="profile.php"><i class="fa-solid fa-user"></i> My Account</a></li>
                            <li><a class="dropdown-item" href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> logout</a></li>
            
                        </ul>
                </div>
                <hr>
                <ul class="MenuSidebar">
                    <li><i class="fa-solid fa-house"></i><a href="Dashboard.php">dashboard</a></li>
                    <li><i class="fa-solid fa-rectangle-history"></i>
                    <a class="dropdown-toggle" dropdown-toggle href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Your Offenses</a>
                         <ul class="dropdown-menu dropMenu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="pendingOffense.php">Pending Offenses</a></li>
                            <li><a class="dropdown-item" href="completOffense.php">Completed Offenses</a></li>
                            <li><a class="dropdown-item" href="allOffense.php">All Offenses</a></li>
            
                        </ul>
                   </li>
                    <li><i class="fa-sharp fa-solid fa-magnifying-glass"></i><a href="Search.php">Search Offense</a></li>
                </ul>
            </div>
        </div>
        <div class="h">
            <div class="header">
                <div class="row">
                  <div class="col-md-4">
                  <i class="fa-solid fa-bars bars"></i>
                  </div>
                  <div class="col-md-6">
                    <h3>Traffic Squad Management</h3>
                  </div>
                  <div class="col-md-2 d-flex gap-4">

                      <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>
                  </div>
                </div>
            </div>