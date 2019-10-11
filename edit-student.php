	

<?php 
	include('inc/header.php');

	include 'lib/Database.php'; 

?>
<div class="card bg-light my-md-4">
	<div class="card-header">
		<h2 class="text-success">Update Student <a href="index.php" class="btn btn-success btn-lg float-right">Home</a></h2>
	</div>
	<div class="card-body">

	<?php
		$Edit_id = $_GET['edit_id'];

		$db = new Database();
		$table = "tbl_students";

		$wherecond = array(
			'where'	=>array('std_id' => $Edit_id),
			
				'return_type' => 'single'
			);

		$getData = $db->select($table, $wherecond);

		if (!empty($getData)) {

	?>

	<form action="lib/process-student.php" method="post">

		<div class="form-group">
			<label for="name">Student Name</label>
			<input type="text" class="form-control" name="name" id="name" value="<?php echo $getData['std_name'];  ?>" required="1">
		</div>

		<div class="form-group">
			<label for="email">Student Email</label>
			<input type="email" class="form-control" name="email" id="email" value="<?php echo $getData['std_email'];  ?>" required="1">
		</div>

		<div class="form-group">
			<label for="phone">Student Phone</label>
			<input type="number" class="form-control" name="phone" id="phone" value="<?php echo $getData['std_phone'];  ?>" required="1">
		</div>

		<!-- <div class="form-group">
			<label for="avater">Student Avater</label>
			<input type="file" name="avater" id="avater" required="1">
		</div> -->

		<div class="form-group">
			<input type="hidden" name="Edit_id" value="<?php echo $getData['std_id']; ?>">
			<input type="hidden" name="action" value="edit">
			<input type="submit" class="btn btn-primary" name="submit" value="Update Student">
		</div>

		
	</form>

	<?php

		}

	?>	

	</div>
</div>




<?php include('inc/footer.php'); ?>	