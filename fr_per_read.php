<?php 
/* ---------------------------------------------------------------------------
 * filename    : fr_per_read.php
 * author      : George Corser, gcorser@gmail.com
 * description : This program displays one volunteer's details (table: fr_persons)
 * ---------------------------------------------------------------------------
 */
session_start();
if(!isset($_SESSION["fr_person_id"])){ // if "user" not set,
	session_destroy();
	header('Location: login.php');     // go to login page
	exit;
}

require '../database/database.php';
require 'functions.php';

$id = $_GET['id'];

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT * FROM fr_persons where id = ?";
$q = $pdo->prepare($sql);
$q->execute(array($id));
$data = $q->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link   href="css/bootstrap.min.css" rel="stylesheet">
		<script src="js/bootstrap.min.js"></script>
		<link rel="icon" href="cardinal_logo.png" type="image/png" />
	</head>

	<body>
		<div class="container">
			<?php
				Functions::logoDisplay2();
			?>
			<div class="row">
				<h3>View Volunteer Details</h3>
			</div>
			 
			<div class="form-horizontal" >
				
				<div class="control-group col-md-6">
				
					<label class="control-label">First Name</label>
					<div class="controls ">
						<label class="checkbox">
							<?php echo htmlspecialchars($data['fname']);?> 
						</label>
					</div>
					
					<label class="control-label">Last Name</label>
					<div class="controls ">
						<label class="checkbox">
							<?php echo htmlspecialchars($data['lname']);?> 
						</label>
					</div>
					
					<label class="control-label">Email</label>
					<div class="controls">
						<label class="checkbox">
							<?php echo htmlspecialchars($data['email']);?>
						</label>
					</div>
					
					<label class="control-label">Mobile</label>
					<div class="controls">
						<label class="checkbox">
							<?php echo htmlspecialchars($data['mobile']);?>
						</label>
					</div>     
					
					<label class="control-label">Address</label>
					<div class="controls">
						<label class="checkbox">
							<?php echo htmlspecialchars($data['address']);?>
						</label>
					</div>
					
					<label class="control-label">City</label>
					<div class="controls">
						<label class="checkbox">
							<?php echo htmlspecialchars($data['city']);?>
						</label>
					</div>   
					
					<label class="control-label">State</label>
					<div class="controls">
						<label class="checkbox">
							<?php echo htmlspecialchars($data['state']);?>
						</label>
					</div>   
					
					<label class="control-label">Zipcode</label>
					<div class="controls">
						<label class="checkbox">
							<?php echo htmlspecialchars($data['zipcode']);?>
						</label>
					</div>   
					
					<label class="control-label">Title</label>
					<div class="controls">
						<label class="checkbox">
							<?php echo htmlspecialchars($data['title']);?>
						</label>
					</div>   
					
					<!-- password omitted on Read/View -->
					
					<div class="form-actions">
						<a class="btn" href="fr_persons.php">Back</a>
					</div>
					
				</div>
				
				<!-- Display photo, if any --> 

				<div class='control-group col-md-6'>
					<div class="controls ">
					<?php 
					if ($data['filesize'] > 0) 
						echo '<img  height=5%; width=15%; src="data:image/jpeg;base64,' . 
							base64_encode( $data['filecontent'] ) . '" />'; 
					else 
						echo 'No photo on file.';
					?><!-- converts to base 64 due to the need to read the binary files code and display img -->
					</div>
				</div>
				
				<div class="row">
					<h4>Events for which this Volunteer has been assigned</h4>
				</div>
				
				<?php
					$sql = "SELECT * FROM fr_assignments, fr_events WHERE assign_event_id = fr_events.id AND assign_per_id = " . $id . " ORDER BY event_date ASC, event_time ASC";
					$countrows = 0;
					foreach ($pdo->query($sql) as $row) {
						echo htmlspecialchars(Functions::dayMonthDate($row['event_date'])) . ': ' . htmlspecialchars(Functions::timeAmPm($row['event_time'])) . ' - ' . htmlspecialchars($row['event_location'] . ' - ' . $row['event_description']) . '<br />';
						$countrows++;
					}
					if ($countrows == 0) echo 'none.';
				?>
				
			</div>  <!-- end div: class="form-horizontal" -->

		</div> <!-- end div: class="container" -->
		
	</body> 
	
</html>