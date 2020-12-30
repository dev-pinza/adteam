<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>AD-Team :: People</title>
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
<!-- Additional IE/Win specific style sheet (Conditional Comments) -->
<!--[if lte IE 7]>
<link rel="stylesheet" href="css/jquery.tabs-ie.css" type="text/css" media="projection, screen">
<![endif]-->
</head>
<body>
<div class="main">
  <?php  include_once("header.php");
 				include_once("lib/settings.php"); 
				include_once("lib/connect.php");?>
  <div class="block_header">
     <?php
		$pageName = "people";
		include_once("menu.php"); 
	?>
    <div class="clr"></div>
    <div class="header_title">
      <img src="images/line_icon_1a.png" alt="picture" width="70" height="70" class="img_title" />
      <h2>Our People</h2>
      <p>Meet the people behind the AD-Team success story. </p>
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
            <?php
				// load staff info from database
				$noticeID = isset($_GET['noticeid']) ? $_GET['noticeid'] : 0;
				$upperBound = $noticeID==0?5:$noticeID;
				$sqlGetNotices = "SELECT * FROM tbl_staff WHERE isActive=1 ORDER BY rank ASC
									LIMIT ".$noticeID.",".$upperBound;
									
				$connect = new Connect();
				@$resGetInfo = $connect->ExecuteQuery($sqlGetNotices);
				
				while(@$row = mysql_fetch_array($resGetInfo))
				{
					if($row['pic']!="")
						echo "<img src='".$row['pic']."' alt='picture' width='120' height='150' hspace='10' vspace='10' align='left' style='border:solid 1px black;'/>";
					else
						echo "<img src='images/user.png' alt='picture' width='100' height='150' hspace='10' vspace='10' align='left' ' />";
						
					echo "<h3>".$row['title']." ".$row['fullname']."</h3>";
					echo "<p>";
					echo "<table width='0' cellpadding='0' cellspacing='2'>";
					echo "<tr style='height:20px;'><td colspan='2'><strong>".$row['role']."</strong></td></tr>";
					if($row['qualifications']!="")echo "<tr><td width='100px'><strong>Qualification:</strong></td><td>".$row['qualifications']."<br /></td></tr>";
					if($row['experience']!="")echo "<tr><td><strong>Experience:</strong></td><td>".$row['experience']."<br /></td></tr>";
					if($row['position']!="")echo "<tr><td><strong>Position:</strong></td><td>".$row['position']."<br /></td></tr>";
					echo "</table>";
					echo "</p>";
					echo "<p><a href='profile.php?id=".$row['id']."'><img src='images/button_read_more_3.gif' alt='picture' width='114' height='28' border='0' /></a></p>
            		<div class='bg'></div>";
				}
				
				// get total number of active notices
				$sqlGetTotal = "SELECT COUNT(*) from tbl_staff WHERE isActive=1";
				$totalActiveNotices = $connect->ExecuteScalar($sqlGetTotal, 0);
				
				if($noticeID==0)
					$previousLink="";
				else
					$previousLink="<a href=people.php?noticeid=".($noticeID-5)."><img src='images/prev.png' width='25' height='25' alt='previous' class='nav_image' /></a>";
					
				if(($noticeID+1)==$totalActiveNotices)
					$nextLink="";
				else
					$nextLink="<a href=people.php?noticeid=".($noticeID+5)."><img src='images/next.png' width='25' height='25' alt='next' class='nav_image' /></a>";
		?>
         <br />
        <p  align="center" class="nav_text" ><?php echo $previousLink." Profile  ".($noticeID+1). " to ".($noticeID+6>$totalActiveNotices?$totalActiveNotices:$noticeID+6)." of ".$totalActiveNotices." ".$nextLink; ?></p>
          </div>
          <div class="body_right">
          <?php include_once("links.php") ?>
          <?php include_once("fb.php") ?>
            <h2 class="testimonails">Construction News</h2>
            <p>
			<marquee direction="up" scrollamount="2" scrolldelay="200" height="220px" onMouseOver="this.stop();" onMouseOut="this.start();">
			<?php
				require_once("rsslib/rsslib.php");
				$url = "http://construction.com/rss/construction.xml";
				echo @RSS_Display($url, 15, false, false);
				?>
            </marquee>
            </p>
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