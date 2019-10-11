	
<!-- Include header file -->
<?php 

	include('inc/header.php'); 

?>
<!-- Include header file -->


	<div class="card bg-light my-md-4">
		<div class="card-header">
			<h2 class="text-success">Add Student <a href="index.php" class="btn btn-success btn-lg float-right">Home</a></h2>
		</div>
		<div class="card-body">
			<form action="lib/process-student.php" method="POST" enctype="multipart/form-data">

				<div class="form-group">
					<label for="name">Student Name</label>
					<input type="text" class="form-control" name="name" id="name" required="1">
				</div>

				<div class="form-group">
					<label for="email">Student Email</label>
					<input type="email" class="form-control" name="email" id="email" required="1">
				</div>

				<div class="form-group">
					<label for="phone">Student Phone</label>
					<input type="number" class="form-control" name="phone" id="phone" required="1">
				</div>

				<div class="form-group">
					<label for="avater">Student Avater</label>
					<input type="file" name="avater" id="avater" required="1">
				</div>

				<div class="form-group">
					<input type="hidden" name="action" value="add">
					<input type="submit" class="btn btn-primary" name="submit" value="Add Student">
				</div>

				
			</form>
		</div>
	</div>


<!-- Include footer file -->
<?php 

	include('inc/footer.php');
?>	
<!-- Include footer file -->