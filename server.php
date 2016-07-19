
<?php
	//include connection file 
	include_once("connection.php");
	
	//define index of column
	$columns = array(
		0 =>'company', 
		1 => 'model',
		2 => 'price'
	);
	$error = false;
	$colVal = '';
	$colIndex = $rowId = 0;
	
	$msg = array('status' => !$error, 'msg' => 'Failed! updation in database');

	if(isset($_POST)){
    if(isset($_POST['val']) && !empty($_POST['val']) && !$error) {
      $colVal = $_POST['val'];
      $error = false;
      
    } else {
      $error = true;
    }
    if(isset($_POST['index']) && $_POST['index'] >= 0 &&  !$error) {
      $colIndex = $_POST['index'];
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
			$sql = "UPDATE mobile_list SET ".$columns[$colIndex]." = '".$colVal."' WHERE Id='".$rowId."'";
			$status = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
			$msg = array('error' => $error, 'msg' => 'Success! updation in database');
	} else {
		$msg = array('error' => $error, 'msg' => 'Failed! updation in database');
	}
	}
	// send data as json format
	echo json_encode($msg);
	
?>
	