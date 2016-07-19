
<?php
	//include connection file 
	include_once("connection.php");
	

	$error = false;
	$tablename = '';
	$colIndex = $rowId = 0;
	
	$msg = array('status' => !$error, 'msg' => 'Failed! updation in database');

	if(isset($_POST)){
   
    if(isset($_POST['tablename']) && $_POST['tablename'] >= 0 &&  !$error) {
      $tablename = $_POST['tablename'];
      $error = false;
    } else {
      $error = true;
    }
    if(isset($_POST['id']) && $_POST['id'] > 0 && !$error) {
      $rowId = $_POST['id'];
      $error = false;
    } else {
      $error = true;
    }
	
	if(!$error) {
			$sql = "delete from ".$tablename." WHERE Id='".$rowId."'";
			$status = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
			$msg = array('error' => $error, 'msg' => 'Success! Deleted');
	} else {
		$msg = array('error' => $error, 'msg' => 'Failed! Deleted');
	}
	}
	// send data as json format
	echo json_encode($msg);
	
?>
	