<?php
require_once("dbcontroller.php");
$db_handle = new DBController();

$action = $_POST["action"];
if(!empty($action)) {
	switch($action) {
		case "add":
			$result = mysql_query("INSERT INTO comment(message) VALUES('".$_POST["txtmessage"]."')");
			if($result){
				  $insert_id = mysql_insert_id();
				  echo '<div class="message-box"  id="message_' . $insert_id . '">
						<div>
						<button class="btnEditAction" name="edit" onClick="showEditBox(this,' . $insert_id . ')">Edit</button>
<button class="btnDeleteAction" name="delete" onClick="callCrudAction(\'delete\',' . $insert_id . ')">Delete</button>
						</div>
						<div class="message-content">' . $_POST["txtmessage"] . '</div></div>';
			}
			break;
			
		case "edit":
			$result = mysql_query("UPDATE comment set message = '".$_POST["txtmessage"]."' WHERE  id=".$_POST["message_id"]);
			if($result){
				  echo $_POST["txtmessage"];
			}
			break;			
		
		case "delete": 
			if(!empty($_POST["message_id"])) {
				mysql_query("DELETE FROM comment WHERE id=".$_POST["message_id"]);
			}
			break;
	}
}
?>