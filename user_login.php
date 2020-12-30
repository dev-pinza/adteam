<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>AD-Team :: My profile</title>
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
	if(!$("input[name=txtEmail]").val())
	{	
		isValid = false;
		output += "Email Address, ";
	}
	
	if(!$("input[name=txtPassword]").val())
	{	
		isValid = false;
		output += "Password ";
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
		
		if(isset($_GET["task"]))
		{
			if($_GET["task"]=="logout")
			{
					$_SESSION["user_id"] = "";
					$_SESSION["title"] = "";
					$_SESSION["fullname"] = "";
					$_SESSION["admin_links"] = "";
			}
		}
		
		function login()
		{
			// connect to mail server and authenticate mail
			if((imap_open("{"."mail.adteam.com.ng:110/pop3/novalidate-cert"."}INBOX","$_POST[txtEmail]", $_POST['txtPassword'])) != null)
			{
				// add message to database for future  reference
				$sqlSaveUser = "SELECT * FROM tbl_staff WHERE email='$_POST[txtEmail]'";
				$connect = new Connect();
				$res =  $connect->ExecuteQuery($sqlSaveUser);
				
				while(@$row = mysql_fetch_array($res))
				{ 
					$_SESSION["user_id"] = $row["id"];
					$_SESSION["title"] = $row["title"];
					$_SESSION["fullname"] = $row["fullname"];
					if($row["isAdmin"]=="1") $_SESSION["admin_id"] = $row["id"];
					echo "<script>location.href='myprofile.php'</script>";
					break;
				}
				return "<div class='msg_error'>Soory we were unable to find an account matching the information you provided. Please try again later or contact the website administrator on admin@adteam.com.ng.</div>";
			}
			else
			{
				return "<div class='msg_error'>Soory we were unable to find an account matching the information you provided. Please try again later or contact the website administrator on admin@adteam.com.ng.</div>";
			}
		}
	?>
    <div class="clr"></div>
    <div class="header_title">
      <img src="images/contact.png" alt="picture" width="110" height="70" class="img_title" />
      <h2>My Profile</h2>
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
            <h2 class="our_services_big">Login</h2>
            <?php  if(isset($_POST['txtEmail'])) { echo login(); } ?>
             <div id="pName" class="msg_error"></div>
                 <form action="user_login.php" method="post" id="contactform">
                  <ol>
                    <li>
                      <label for="email">Your email* </label>
                      <input id="txtEmail" name="txtEmail" class="text" />
                    </li>
                    <li>
                      <label for="password">Password</label>
                      <input id="txtPassword" name="txtPassword" class="text" type="password" />
                    </li>
                    <li class="buttons">
                     <input type="image" name="btnSend" id="btnSend" src="images/login.gif" />
                    </li>
                  </ol>
                </form>
			<div class="bg"></div>
          </div>
          <div class="body_right">
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