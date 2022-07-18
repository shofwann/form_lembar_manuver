<?php 
session_start();

if (!isset($_SESSION["username"])) {
	echo "<script>Anda Belum Login</script>";
  header("location:index.php");
	exit;
}

$user=$_SESSION["username"];





?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="icons/font-awesome-4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMO-HOME</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
  
    </style>
   </head>
<body>

  <div class="sidebar close">
    <div class="logo-details">
      <!-- <i class=''><img src="https://budaya.pln.co.id/assets/images/logo_pln.jpg" alt=""></i> -->
      <span class="logo_name">LM ONLINE</span>
    </div>
    <ul class="nav-links">
        <li>
          <a href="home.php">
            <i class='bx bx-grid-alt' ></i>
            <span class="link_name">Dashboard</span>
          </a>
          <ul class="sub-menu blank">
            <li><a class="link_name" href="#">Dashboard</a></li>
          </ul>
        </li>

        <?php if ($_SESSION["level"]=="initiator" || $_SESSION["level"] =="dispa" ) { ?>
          <li>
            <div class="iocn-link">
              <a href="#">
              <i class="fa fa-pencil-square" aria-hidden="true"></i>
                <span class="link_name">Create Form</span>
              </a>
              <i class='bx bxs-chevron-down arrow' ></i>
            </div>
            <ul class="sub-menu">
              <?php if ($_SESSION["level"]=="initiator") { ?>
                <li><a class="link_name" href="#">Create Form</a></li>
                <li><a href="?url=form-1">Form-1</a></li>
                <li><a href="?url=form-2">Form-2</a></li>
                <li><a href="?url=select-form">Form-Auto</a></li>
              <?php } ?>
              <?php if ($_SESSION["level"]=="dispa") { ?>
                <li><a class="link_name" href="#">Create Form</a></li>
                <li><a href="?url=form_emergency&form=3">Form Emergency 1</a></li>
                <li><a href="?url=form_emergency&form=4">Form Emergency 2</a></li>
                <li><a href="?url=select-form">Auto Form Emergency</a></li>
              <?php } ?>
            </ul>
          </li>
        <?php } ?>


        <?php if ($_SESSION["level"] == "initiator" || $_SESSION["level"] == "amn" || $_SESSION["level"] == "msb" || $_SESSION["level"] =="dispa" || $_SESSION["level"] =="amn_dispa" || $_SESSION["level"] =="plh_amn" || $_SESSION["level"] =="plh_msb") { ?>
          <li>
            <a href="?url=inbox">
            <i class="fa fa-inbox" aria-hidden="true"></i>
              <span class="link_name">Inbox</span>
            </a>
            <ul class="sub-menu blank">
              <li><a class="link_name" href="?url=inbox">Inbox</a></li>
            </ul>
          </li>
        <?php } ?>

        <?php if ($_SESSION["level"]=="initiator") { ?>
          <li>
            <div class="iocn-link">
              <a href="#">
              <i class="fa fa-database" aria-hidden="true"></i>
                <span class="link_name">Database</span>
              </a>
              <i class='bx bxs-chevron-down arrow' ></i>
            </div>
            <ul class="sub-menu">
              <li><a class="link_name" href="#">Database</a></li>
              <li><a href="?url=insertDB">Insert</a></li>
              <li><a href="?url=updateDB">Update</a></li>
            </ul>
          </li>
        <?php } ?>
        
        <?php if ($_SESSION["level"] =="initiator" || $_SESSION["level"] == "amn" || $_SESSION["level"] == "msb" || $_SESSION["level"] =="dispa" || $_SESSION["level"] =="amn_dispa" || $_SESSION["level"] =="plh_amn" || $_SESSION["level"] =="plh_msb") { ?>
          <li>
            <a href="?url=participant">
              <i class='fa fa-list' ></i>
              <span class="link_name">Participant</span>
            </a>
            <ul class="sub-menu blank">
              <li><a class="link_name" href="?url=participant">Participant</a></li>
            </ul>
          </li>
        <?php } ?>

        <?php if ($_SESSION["level"]=="admin") { ?>
          <li>
            <a href="?url=users">
              <i class='fa fa-user'></i>
              <span class="link_name">Users</span>
            </a>
            <ul class="sub-menu blank">
              <li><a class="link_name" href="?url=users">Users</a></li>
            </ul>
          </li>


          <li>
            <a href="?url=jobs">
              <i class='fa fa-tasks'></i>
              <span class="link_name">Task</span>
            </a>
            <ul class="sub-menu blank">
              <li><a class="link_name" href="?url=jobs">Task</a></li>
            </ul>
          </li>
        <?php } ?>

        
        <li>
          <div class="iocn-link">
            <a href="#">
              <i class="fa fa-cogs" aria-hidden="true"></i>
              <span class="link_name">Setting</span>
            </a>
            <i class='bx bxs-chevron-down arrow' ></i>
          </div>
          <ul class="sub-menu">
            <li><a class="link_name" href="#">Setting</a></li>
            <li><a href="?url=change-pass">Change Password</a></li>
            <li><a href="#">Activity Log</a></li>
            <li><a href="#">Theme</a></li>
          </ul>
        </li>


       

        <li>
          <div class="profile-details">
            <div class="profile-content right">
              <img src="icon/<?php echo substr($user,0,1); ?>.ico" style="height:50px; width:auto;"/>
              <!-- <div class="tooltip-2nd" id="hide"> -->
                <!-- <button type="button" class="netral"><a class="" href="logout.php" onclick="return confirm('Are you sure to logout?');">Logout</a></button> -->
              <!-- </div> -->
              <ul class="sub-menu">
                <li class="user"><h6><?= $_SESSION["username"] ?></h6><a class="link_name" href="logout.php" onclick="return confirm('Are you sure to logout?');">Logout</a></li>
                <!-- <li><a class="link_name" href="#">Setting</a></li> -->
              </ul>
            </div>
            <div class="name-job">
              <div class="profile_name"><?= $_SESSION['username']; ?></div>
              <div class="job"><?= $_SESSION['level']; ?></div>
            </div>
              <a class="" href="logout.php" onclick="return confirm('Are you sure to logout?');" action=""><i class='bx bx-log-out' ></i></a>
           
          </div>
        
        </li>

      </ul>
  </div>

  <section class="home-section">
    
    <div class="home-content">
      <i class='bx bx-menu' ></i>
      <!-- <span class="text">LEMBAR MANUVER ONLINE</span> -->
    </div>
  
    <div class="content">
        <?php include 'link.php'; ?>
    </div>

    <div class="footer">
    <i class='bx bx-menu' ></i>
      <span>Copyright &copy; PLN UIP2B JAMALI 2019</span>
    </div>

    
    
  </section>
  
  
  
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> 
  
  <script>
  let arrow = document.querySelectorAll(".arrow");
  for (var i = 0; i < arrow.length; i++) {
    arrow[i].addEventListener("click", (e)=>{
    let arrowParent = e.target.parentElement.parentElement;//selecting main parent of arrow
    arrowParent.classList.toggle("showMenu");
    });
  }
  let sidebar = document.querySelector(".sidebar");
  let sidebarBtn = document.querySelector(".bx-menu");
  let profileContent = document.querySelector(".profile-content");
  let hide = document.querySelector("#hide");
  //console.log(sidebarBtn);
  sidebarBtn.addEventListener("click", ()=>{
    sidebar.classList.toggle("close");
    profileContent.classList.toggle("right");
    hide.classList.toggle("hide");
  });

  function myFunction() {
			var dropdownContent = document.querySelector('.dropdown-isi');
			dropdownContent.classList.toggle('dropdown-toggle');
		}


    $(document).ready(function(){
        function check_session() {
          $.ajax({
              url: "check_session.php",
              method: "POST",
              success: function(data){
                if(data == "1"){
                  alert("login kembali untuk melanjutkan");
                  window.location.href = "logout.php";
                }
              }
          })
        }

        setInterval(function(){
          check_session();
        }, 3609000) //1 jam


		 })

   
  </script>
</body>
</html>
