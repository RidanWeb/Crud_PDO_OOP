<?php

include 'Database.php';

include 'session.php';
Session::init();

$db = new Database();
$table = "tbl_students";

// AddStudent Process start=============================

if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {

 	if ($_REQUEST['action'] == 'add') { 

 		$studentData = array(

 			'std_Name' => $_POST['name'],
 			'std_Email' => $_POST['email'],
 			'std_Phone' => $_POST['phone'],
 			'file_name' => $_FILES['avater']['name']
 			
 			'std_Avata_tmp' => $_FILES['avater']['tmp_name']
 			move_uploaded_file('std_Avata_tmp', "css/"."file_name")
 		);


 		$insert = $db->insert($table, $studentData);

 		if ($insert) 
 			{
 				$msg = "<h2 class='text-success text-center alert alert-success mt-4'>Data Inserted Successfully...</h2>";
 			}else
 				{
 					$msg = "<h2 class='text-danger text-center alert alert-danger mt-4'>Data Not Inserted...</h2>";
 			}

 		Session::set('msg', $msg );
 		$home_url = '../index.php';
 		header('location: '.$home_url);


 	}// AddStudent Process end=============================

 	// Edit Student process Start==========================

 	elseif ($_REQUEST['action'] == 'edit') 
 	{

 		$id = $_POST['Edit_id'];

 		if (!empty($id)) 
 		{
 		 	$studentData = array(

 			'std_Name' => $_POST['name'],
 			'std_Email' => $_POST['email'],
 			'std_Phone' => $_POST['phone']
 			// 'std_Avata' => $FILES['avater']['name'],
 			// 'std_Avata_tmp' = $FILES['avater']['tmp_Name']
 			// move_uploaded_file('std_Avata_tmp', "css/"."std_Avata");
	 		);


	 		$table = "tbl_students";

 		 	$condition = array('std_id' => $id);

	 		$update = $db->update($table, $studentData, $condition);
	 		if ($update) 
	 		{

	 			$msg = "<h2 class='text-success text-center alert alert-success mt-4'>Data Updated Successfully...</h2>";

	 		}else
	 		{

	 			$msg = "<h2 class='text-danger text-center alert alert-danger mt-4'>Data Not Updated...!</h2>";

	 		}


	 		Session::set('msg', $msg );
	 		$home_url = '../index.php';
	 		header('location: '.$home_url);


 		 } 

 	}// Edit Student process end==========================


 	// Delete Student Process Start=======================
 	elseif ($_REQUEST['action'] == 'delete') 
 	{
 		$id = $_GET['id'];

 		if (!empty($id)) 
 		{
 			$table = "tbl_students";

 		 	$condition = array('std_id' => $id);

 		 	$delete = $db->delete($table, $condition);
	 		if ($delete) 
	 		{
	 			$msg = "<h2 class='text-success text-center alert alert-success mt-4'>Data Deleted Successfully...</h2>";

	 		}else
	 		{
	 			$msg = "<h2 class='text-danger text-center alert alert-danger mt-4'>Data Not Deleted...!</h2>";
	 		}


	 		Session::set('msg', $msg );
	 		$home_url = '../index.php';
	 		header('location: '.$home_url);
 		}
 	}// Delete Student Process end=======================


 } 

?>