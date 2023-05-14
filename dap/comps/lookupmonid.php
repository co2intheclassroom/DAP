<?php
	include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/connection.php');
				
	$query = "SELECT Location_Name FROM Locations WHERE ID = ".$querylocation."";
		
				
		$exec = mysqli_query($conn,$query);
		
		if(mysqli_num_rows($exec) == 0){
			header("Location: https://co2intheclassroom.co.uk/dap/index.php");
		};
		
		while($row = mysqli_fetch_array($exec)){
			$locationtext = $row['Location_Name'];
			echo $locationtext;
		};
		
		
		
?>
