
<?php 

include 'lib/session.php';


include('inc/header.php');

include('lib/Database.php'); 

Session::init();

$msg = Session::get('msg');

if(!empty($msg)){
	echo $msg ;

	// unset($_SESSION['$msg']);
	Session::unset();
}


?>


<div class="card bg-light my-md-4">
	<div class="card-header">
		<h2 class="text-success">Student List <a href="addstudent.php" class="btn btn-success btn-lg float-right">Add Student</a></h2>
	</div>
	<div class="card-body pb-0">
		<table class="table table-striped table-hover table-dark">
		  <thead>
		    <tr>
		      <th scope="col">Serial</th>
		      <th scope="col">Name</th>
		      <th scope="col">Email</th>
		      <th scope="col">Phone</th>
		      <th scope="col">Avater</th>
		      <th scope="col">Action</th>
		    </tr>
		  </thead>


		<?php
		$db = new Database();
		$table = "tbl_students";
		$order_by = array('order_by' => 'std_id ASC' );
		// $selectcond = array('select' => 'std_name');
		/*
		$wherecond = array(
			'where'	=>array('std_id' => '2', 'std_email' => 'Ridan@gmail.com'),
			'return_type' => 'single'
		);
		*/
		$limit = array('start' => '2', 'limit' => '4');
		$limit = array('limit' => '4');
		
		$studentData = $db->select($table, $order_by);

		if (!empty($studentData)) {
			$i = 0;
			foreach ($studentData as $data) {  $i++; ?>
		

		
			
		  <tbody>
		    <tr>
		      <td><?php echo $i; ?></td>
		      <td><?php echo $data['std_name']; ?></td>
		      <td><?php echo $data['std_email']; ?></td>
		      <td><?php echo $data['std_phone']; ?></td>
		      <td><?php echo $data['std_avater']; ?></td>
		      <td>
		      	<a href="edit-student.php?edit_id=<?php echo $data['std_id']; ?>" class="btn btn-info">Edit</a>
		      	<a href="lib/process-student.php?action=delete&id=<?php echo $data['std_id']; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger">Delete</a>
		      </td>
		    </tr>
		  </tbody>
		
		<?php } }else{ ?>
			<tr>
		    	<td colspan="6">
		    		<h4 class="alert alert-danger text-center" role="alert">There Is No Data To Show!!!
				   <a href="#" class="alert-link">Please Add Some Data...</a></h4>
				</td>
		     </tr>
		<?php } ?>
		</table>
	</div>
</div>


<?php 

	include('inc/footer.php');
?>	
					