
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
    if(isset($_POST['tmp0']) && !empty($_POST['tmp0']) && isset($_POST['tmp1']) && !empty($_POST['tmp1']) && isset($_POST['tmp2']) && !empty($_POST['tmp2']) && !$error) {
      $tmp0 = $_POST['tmp0'];
	   $tmp1 = $_POST['tmp1'];
	    $tmp2 = $_POST['tmp2'];
      $error = false;
      
    } else {
      $error = true;
    }
	
		if(!$error) {
			$sql = "insert into mobile_list (company,model,price) values ('$tmp0','$tmp1','$tmp2')";
			$status = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
				$msg = array('error' => $error, 'msg' => 'Saved! in database');
		} else {
		
		$msg = array('error' => $error, 'msg' => 'Failed! updation in database');
		}

	}
	// send data as json format
	echo json_encode($msg);
	
?>
	