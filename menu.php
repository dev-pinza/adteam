<div class="menu">
      <ul>
        <li><a href="index.php" <?php if($pageName=="index") echo "class='active'"; ?>><span>Home</span></a></li>
        <li><a href="services.php" <?php if($pageName=="services") echo "class='active'"; ?>><span>Our Services</span></a></li>
        <li><a href="projects.php" <?php if($pageName=="projects") echo "class='active'"; ?>><span> Our Projects </span></a></li>
        <li><a href="people.php" <?php if($pageName=="people") echo "class='active'"; ?>><span> Our People </span></a></li>
        <li><a href="gallery/" target="_blank" <?php if($pageName=="photo") echo "class='active'"; ?>><span> Photo Gallery </span></a></li>
        <li><a href="about.php" <?php if($pageName=="about") echo "class='active'"; ?>><span>About Us</span></a></li>
        <li><a href="contact.php" <?php if($pageName=="contact") echo "class='active'"; ?>><span>Contact Us</span></a></li>
        <li><a href="myprofile.php" <?php if($pageName=="myprofile") echo "class='active'"; ?>><span>My Profile</span></a></li>
        <li><a href="/webmail" target="_blank" ><span> Email Login </span></a></li>
      </ul>
    </div>