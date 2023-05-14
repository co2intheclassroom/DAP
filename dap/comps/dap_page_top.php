<?php require_once($_SERVER['DOCUMENT_ROOT'].'/dap/comps/authorise.php');  ?>

<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="https://co2intheclassroom.co.uk/">CO2 in the Classroom</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav me-auto mb-2 mb-md-0">
        <li class="nav-item">
          <a class="nav-link <?php if ($pagenav==1) {echo "active";};?>" href="https://co2intheclassroom.co.uk/dap/">Home</a>
        </li>
		<li class="nav-item">
          <a class="nav-link <?php if ($pagenav==2) {echo "active";};?>" href="https://co2intheclassroom.co.uk/dap/locations.php">School</a>
        </li>
		
		<?php
			if ($_SESSION['isAdmin'] == 1){
				include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/adminmenu.php');
			}
		?>
		<li class="nav-item">
          <a class="nav-link <?php if ($pagenav==4) {echo "active";};?>" href="https://co2intheclassroom.co.uk/dap/user/viewuser.php">Settings</a>
        </li>
		<li class="nav-item">
          <a class="nav-link <?php if ($pagenav==5) {echo "active";};?>" href="https://co2intheclassroom.co.uk/dap/about.php">About</a>
        </li>
		<li class="nav-item">
          <a class="nav-link" href="https://co2intheclassroom.co.uk/logout.php">Logout</a>
        </li>
      </ul>

    </div>
  </div>
</nav>
