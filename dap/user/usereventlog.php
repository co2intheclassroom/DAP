<!doctype html>
<?php
//Authorises user to view page. Access level - standard user
require_once($_SERVER['DOCUMENT_ROOT'].'/dap/comps/authorise.php'); 
  
if(!isset($_GET['userID'])) { 
	header("Location: viewuser.php");
}else{
	$viewuser = $_GET['userID'];
};

if (isset($_GET['pageno'])) {
	$pageno = $_GET['pageno'];
}else{
	$pageno = 1;
};
?>

<html lang="en">
    <head>
	<?php include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/header.php'); ?>
  </head>
  <body>
    
<?php include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/dap_page_top.php');?>
		
<main class="container">
  <div class="bg-light p-5 rounded">
		<div class="row align-items-center" align='center'>
			<?php 
			$previous = "javascript:history.go(-1)";
			
			
			//echo "<a href='viewuser.php'>Go back</a>";
		
			echo "<a href='https://co2intheclassroom.co.uk/dap/admin/users/edituser.php?userID=".$viewuser."'>Go back</a>"; ?>
		</div>
		
		
		<div class="row align-items-center" align='center'>
			<h4> Event Log (User ID : <?php echo $viewuser ;?>)</h4>
			
			<table class="table table-striped border"> <!-- Table is created -->
		<thead> <!-- Table header begins -->
			<tr>
				<th scope="col">TimeStamp</th>
				<th scope="col">Event Code</th>
				<th scope="col">Event Info</th>
			</tr>
		</thead> <!-- Table header ends -->
			
			<?php
			
			include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/connection.php');
			
			//pagination setup
			$no_of_records_per_page = 10;
			$offset = ($pageno-1) * $no_of_records_per_page; 
			
			$total_pages_sql = "SELECT COUNT(*) FROM User_Event_Log WHERE User_ID ='".$viewuser."'";
			$result = mysqli_query($conn,$total_pages_sql);
			$total_rows = mysqli_fetch_array($result)[0];
		
			$total_pages = ceil($total_rows / $no_of_records_per_page);
			//
			
			$statement = "SELECT TimeStamp,UEvent_Code,UEvent_Info FROM User_Event_Log WHERE User_ID = '".$viewuser."' ORDER BY TimeStamp DESC LIMIT $offset, $no_of_records_per_page"; //prepare sql statement

			$result = mysqli_query($conn, $statement); //run sql query statement on the database.
			
			if($result){//if the result has been successful
				while ($r = mysqli_fetch_assoc($result)) { //for each row in the result
					//for each result row create a row in the table.
					
					$timestamp = $r['TimeStamp'];
					$ukDate = date("d-m-Y - H:i:s", strtotime($timestamp));
					
					echo "<tr>";
					echo "<td>".$ukDate."</td>";
					echo "<td>".$r['UEvent_Code']."</td>";			
					echo "<td>".$r['UEvent_Info']."</td>";						
					echo "</tr>";
				}			
			}
			//if an error occurs a message is displayed on screen.
			else{
				echo "Database error";
				echo mysqli_error($conn);
			     }
		
		 ?>
		 </table>
		 
		</div>
	
			<div class="row align-items-center" align='center'>
			<div class="col">
				<a <?php if($pageno >1){echo "href=usereventlog.php?userID=".$viewuser."&pageno=1";}?>>First</a>

			</div>
			
			<div class="col">
				<a <?php if($pageno >1){echo "href=usereventlog.php?userID=".$viewuser."&pageno=".($pageno-1);}?>>Prev</a>
			</div>
			
			<div class="col <?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
				
				<a <?php if($pageno < $total_pages){echo "href=usereventlog.php?userID=".$viewuser."&pageno=".($pageno+1);}?>>Next</a>
			</div>
			
			<div class="col">
				<a <?php if($pageno < $total_pages){echo "href=usereventlog.php?userID=".$viewuser."&pageno=".$total_pages;}?>>Last</a>
				
			</div>
		</div>

	
  </div>

</main>
      
  </body>
  
<footer>
	<?php include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/footer.php'); ?>
</footer>

</html>
