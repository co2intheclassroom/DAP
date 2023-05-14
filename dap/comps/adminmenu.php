<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/dap/comps/adminauthorise.php'); 

?>

		<li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?php if ($pagenav==3) {echo "active";};?>" href="#" data-bs-toggle="dropdown" aria-expanded="false">Admin</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="https://co2intheclassroom.co.uk/dap/admin/locations/locations.php">Locations</a></li>
            <li><a class="dropdown-item" href="https://co2intheclassroom.co.uk/dap/admin/monitors/monitors.php">Monitors</a></li>
            <li><a class="dropdown-item" href="https://co2intheclassroom.co.uk/dap/admin/users/users.php">Users</a></li>
          </ul>
        </li>