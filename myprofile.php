<?php
session_start();
if($_SESSION["user_id"]=="")
	echo "<script>location.href='user_login.php'</script>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>AD-Team :: My Profile</title>
<link rel="icon" type="image/png" href="images/favicon.png" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/jquery.tabs.css" rel="stylesheet" type="text/css" media="print, projection, screen" />
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/jquery.tabs.pack.js" type="text/javascript"></script>
<script type="text/javascript">
	$(function() {
		$('#tabs_block').tabs({ fxFade: true });
	});
</script>
<script type="text/javascript" src="js/jquery.js"></script>
<script>
$(document).submit(function() 
{   
	var isValid = true; 
	var output = "";
	
	// add proper email validation
	if(!$("input[name=txtName]").val())
	{	
		isValid = false;
		output += "Full name, ";
	}
	
	if(!$("input[name=txtEmail]").val())
	{	
		isValid = false;
		output += "Email, ";
	}
	
	if(!isValid)
		$("div[id=pName]").text("Please fill in the following fields: "+output);
	return isValid;
});
</script>
<!-- Additional IE/Win specific style sheet (Conditional Comments) -->
<!--[if lte IE 7]>
<link rel="stylesheet" href="css/jquery.tabs-ie.css" type="text/css" media="projection, screen">
<![endif]-->
</head>
<body>
<div class="main">
  <?php  include_once("header.php");
  		include_once("lib/settings.php");
		include_once("lib/connect.php");
  ?>
  <div class="block_header">
     <?php
		$pageName = "myprofile";
		include_once("menu.php");
		
		
	
		
		function save()
		{
			// upload file if exists
			$filePath = "";
			$allowedExts = array("jpg", "jpeg", "gif", "png");
			@$extension = end(explode(".", $_FILES["txtPhoto"]["name"]));
			if ((($_FILES["txtPhoto"]["type"] == "image/gif")
			|| ($_FILES["txtPhoto"]["type"] == "image/jpeg")
			|| ($_FILES["txtPhoto"]["type"] == "image/png")
			|| ($_FILES["txtPhoto"]["type"] == "image/pjpeg"))
			&& ($_FILES["txtPhoto"]["size"] < 2000000)
			&& in_array($extension, $allowedExts))
			{
				if ($_FILES["txtPhoto"]["error"] > 0)
					$filePath="";
				else
				{
					$filePath="pics/".rand(1000, 9999).$_FILES["txtPhoto"]["name"];
					move_uploaded_file($_FILES["txtPhoto"]["tmp_name"], $filePath);
				}
  			}
			
			
			// update info
			if($filePath != "")
			{
				$sqlAddMessage = "UPDATE tbl_staff SET title='$_POST[txtTitle]', fullname='$_POST[txtName]', qualifications='$_POST[txtQualification]', role='$_POST[txtRole]', experience='$_POST[txtExperience]',`position`='$_POST[txtPosition]', profile=\"".nl2br($_POST["txtMessage"])."\", pic='$filePath', email='$_POST[txtEmail]' WHERE id=".$_SESSION["user_id"];
			}
			else
			{
				$sqlAddMessage = "UPDATE tbl_staff SET title='$_POST[txtTitle]', fullname='$_POST[txtName]', qualifications='$_POST[txtQualification]', role='$_POST[txtRole]', experience='$_POST[txtExperience]',`position`='$_POST[txtPosition]', profile=\"".nl2br($_POST["txtMessage"])."\", email='$_POST[txtEmail]' WHERE id=".$_SESSION["user_id"];
			}
			
			$connect = new Connect();
			$res =  $connect->ExecuteQuery($sqlAddMessage);
			
			if($res==1) return "<div class='msg_info'>Profile information updates sucessfully.</div>";
			else return "<div class='msg_error'>Soory there was a problem updating your profile information. Please try again later.</div>";
		}
	?>
    <div class="clr"></div>
    <div class="header_title">
      <img src="images/contact.png" alt="picture" width="110" height="70" class="img_title" />
      <h2>Welcome: <?php echo $_SESSION["title"]." ".$_SESSION["fullname"]." (<a href='user_login.php?task=logout'>Logout</a>)"; ?></h2>
      <p>You can change what your profile page displays on the website.</p>
      <div class="clr"></div>
    </div>
    <div class="clr"></div>
  </div>
  <div class="clr"></div>
  <div class="body">
    <div class="box_1_bg">
      <div class="box_1_b">
        <div class="box_1_t">
          <div class="body_two_side services">
            <h2 class="our_services_big">Change Profile Information</h2>
            <?php  
				if(isset($_POST['txtName'])) { echo save(); } 
				
				$row="";
				$sqlgetUser = "SELECT * FROM tbl_staff WHERE id='".$_SESSION["user_id"]."'";
				$connect = new Connect();
				$res =  $connect->ExecuteQuery($sqlgetUser);
				$row = mysql_fetch_array($res);
			?>
             <div id="pName" class="msg_error"></div>
                 <form action="myprofile.php" method="post" id="contactform" enctype="multipart/form-data">
                  <ol>
                    <li>
                      <label for="title">Title</label>
                      <input id="txtTitle" name="txtTitle" class="text" value="<?php  echo $row["title"]; ?>"/>
                    </li>
                    <li>
                      <label for="name">Fullname* </label>
                      <input id="txtName" name="txtName" class="text" value="<?php  echo $row["fullname"]; ?>" />
                    </li>
                     <li>
                      <label for="role">Role </label>
                      <input id="txtRole" name="txtRole" class="text" value="<?php  echo $row["role"]; ?>" />
                    </li>
                     <li>
                      <label for="qualification">Qualification</label>
                      <input id="txtQualification" name="txtQualification" class="text" value="<?php  echo $row["qualifications"]; ?>" />
                    </li>
                     <li>
                      <label for="experience">Experience </label>
                      <input id="txtExperience" name="txtExperience" class="text" value="<?php  echo $row["experience"]; ?>" />
                    </li>
                    <li>
                      <label for="position">Position </label>
                      <input id="txtPosition" name="txtPosition" class="text" value="<?php  echo $row["position"]; ?>" />
                    </li>
                    <li>
                      <label for="message">Profile</label>
                      <textarea id="txtMessage" name="txtMessage" rows="10" cols="50"><?php  echo str_replace("<br />", "", $row["profile"]); ?></textarea>
                    </li>
                    <li>
                      <label for="email">Your email* </label>
                      <input id="txtEmail" name="txtEmail" class="text" value="<?php  echo $row["email"]; ?>"/>
                    </li>
                     <li>
                      <label for="password">Profile Picture</label>
                      <input id="txtPhoto" name="txtPhoto" class="text" type="file"/>
                    </li>
                    <li class="buttons">
                     <input type="image" name="btnSend" id="btnSend" src="images/save.gif" />
                    </li>
                  </ol>
                </form>
			<div class="bg"></div>
          </div>
          <div class="body_right">
          <?php 
		  	if($_SESSION["admin_id"]!="")
				include_once("admin_links.php")
		  ?>
          <div class='clr'></div>
          <?php include_once("links.php") ?>
          </div>
          <div class="clr"></div>
        </div>
      </div>
      <div class="clr"></div>
    </div>
  </div>
  <div class="clr"></div>
    <?php  include_once("footer.php"); ?>
</div>
</body>
</html>