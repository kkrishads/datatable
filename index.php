<?php
//include connection file 
include_once("connection.php");
$sql = "SELECT * FROM `mobile_list` limit 1,10 ";
$queryRecords = mysqli_query($conn, $sql) or die("error to fetch employees data");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<script type="text/javascript" src="jquery-1.11.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="bootstrap.min.css"/>
 <link href="jquery-ui.css" rel="stylesheet">
      <script src="jquery-1.10.2.js"></script>
      <script src="jquery-ui.js"></script>
	  <!-- Javascript -->
      <script>
         $(function() {
            var availableTutorials = [
               "ActionScript",
               "Boostrap",
               "C",
               "C++",
            ];
           
         });
      </script>
<title>phpflow.com : Simple Example of In-line Editing with HTML5,PHP and MySQL</title>
</head>
<script type="text/javascript">
function deleteNewRow(row)
{
	var i=row.parentNode.parentNode.rowIndex;
    document.getElementById('employee_grid').deleteRow(i);
}


function insRow()
{
    // Find a <table> element with id="myTable":
var table = document.getElementById("_editable_table");

// Create an empty <tr> element and add it to the 1st position of the table:
var row = table.insertRow(0);
row.setAttribute("data-row-id","000");
row.id="000";
// Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
var cell1 = row.insertCell(0);
var cell2 = row.insertCell(1);
var cell3 = row.insertCell(2);
var cell4 = row.insertCell(3);
var element1 = document.createElement("input");
			element1.type = "text";
			element1.name = "tmp0";
			element1.id="tmp0";
			cell1.appendChild(element1);
			
			var element2 = document.createElement("input");
			element2.type = "text";
			element2.name = "tmp1";
			element2.id="tmp1";
			cell2.appendChild(element2);
var element3 = document.createElement("input");
			element3.type = "text";
			element3.name = "tmp2";
			element3.id="tmp2";
			cell3.appendChild(element3);
			var element4 = document.createElement("input");
			element4.type = "button";
			element4.name = "save";
			element4.id="save";
			element4.value="save";
			element4.setAttribute("onClick","saveNewRow(this);");
			cell4.appendChild(element4);
			
			var element5 = document.createElement("input");
			element5.type = "button";
			element5.name = "delete";
			element5.id="delete";
			element5.value="delete";
			element5.setAttribute("onClick","deleteNewRow(this);");
			cell4.appendChild(element5);

}


</script>

<body>
<div class="container" style="padding:50px 250px;">
<h1>Simple Example of Inline Editing with HTML5,PHP and MySQL</h1>
<input type="button" name="addrow" value="AddRow" onClick="insRow();" />
<div id="msg" class="alert"></div>
<table id="employee_grid" class="table table-condensed table-hover table-striped bootgrid-table" width="60%" cellspacing="0">
   <thead>
      <tr>
         <th>Name</th>
         <th>Salary</th>
         <th>Age</th>
      </tr>
   </thead>
   <tbody id="_editable_table">
   

   
      <?php foreach($queryRecords as $res) :?>
	  <?php
	  $id= $res['Id'];
	  ?>
      <tr data-row-id="<?php echo $res['Id'];?>">
	     <td class="editable-col" contenteditable="true" col-index='0' id="<?php echo $id;?>" onKeyUp="showAutoComplete(this);" oldVal ="<?php echo $res['company'];?>"><?php echo $res['company'];?></td>
         <td class="editable-col" contenteditable="true" col-index='1' oldVal ="<?php echo $res['model'];?>"><?php echo $res['model'];?></td>
         <td class="editable-col" contenteditable="true" col-index='2' oldVal ="<?php echo $res['price'];?>"><?php echo $res['price'];?></td>
		   <td><input type="button" onClick="deleteData(this,'<?php echo $id;?>','mobile_list');" value="Delete"/></td>
      </tr>
	  <?php endforeach;?>
   </tbody>
</table>
<div  class="taginput" contenteditable="true" tabindex="1" style="min-height: 25px;
    width: 60%;
    background:lightyellow;
    box-shadow: 1px 1px 2px 2px darkgrey;"></div>
</div>
</body>
</html>
<script type="text/javascript">

function saveNewRow(row) {
	var data;
	data=readTableData();
	var myJsonString = JSON.stringify(data);
	alert(myJsonString);
	
	$.ajax({   
				  
					type: "POST",  
					url: "save_new.php",  
					cache:false,  
					data: data,
					dataType: "json",				
					success: function(response)  
					{   
						//$("#loading").hide();
						if(!response.error) {
				
							$("#msg").removeClass('alert-danger');
							$("#msg").addClass('alert-success').html(response.msg);
					  deleteNewRow(row);	
						} else {
							$("#msg").removeClass('alert-success');
							$("#msg").addClass('alert-danger').html(response.msg);
					    
						}
					}

				
				});
}
  function readTableData(){

	data = {};
		
    var table = document.getElementById("employee_grid");
    var column_count = table.rows[0].cells.length;
    var row = table.rows[0];
    if(column_count>0){
        for(var index = 0; index < column_count;index++){

	  var row = table.rows[index];
		data["tmp"+index] =  document.getElementById("tmp"+index).value;
	
        }
    }

    return data;
}

function deleteData(row,id,tablename){
	data = {};
	
		data['id'] = id;
		data['tablename'] =tablename;
	

		$.ajax({   
				  
					type: "POST",  
					url: "data_delete.php",  
					cache:false,  
					data: data,
					dataType: "json",				
					success: function(response)  
					{   
						//$("#loading").hide();
						if(!response.error) {
							$("#msg").removeClass('alert-danger');
							$("#msg").addClass('alert-success').html(response.msg);
							deleteNewRow(row);	
						} else {
							$("#msg").removeClass('alert-success');
							$("#msg").addClass('alert-danger').html(response.msg);
						}
					}   
				});
}

function showAutoComplete(raw){
			
			$(function() {
    $("#"+raw.id ).autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "http://api.stackexchange.com/2.1/users",
                data: {
                    pagesize: 10,
                    order: 'desc',
                    sort: 'reputation',
                    site: 'stackoverflow',
                    inname: request.term
                },
                dataType: 'jsonp'
            }).done(function(data) {
                if (data.items) {
                    response($.map(data.items, function(item) {
                        return item.display_name;
                    }));
                } else {
                    response([]);
                }
            });
        },
        delay: 100,
        minLength: 0
    });
});
			
}

$(document).ready(function(){

	
	$('td.editable-col').on('focusout', function() {
		data = {};
		data['val'] = $(this).text();
		data['id'] = $(this).parent('tr').attr('data-row-id');
		data['index'] = $(this).attr('col-index');
	    if($(this).attr('oldVal') === data['val'])
		return false;

		$.ajax({   
				  
					type: "POST",  
					url: "server.php",  
					cache:false,  
					data: data,
					dataType: "json",				
					success: function(response)  
					{   
						//$("#loading").hide();
						if(!response.error) {
							$("#msg").removeClass('alert-danger');
							$("#msg").addClass('alert-success').html(response.msg);
						} else {
							$("#msg").removeClass('alert-success');
							$("#msg").addClass('alert-danger').html(response.msg);
						}
					}   
				});
	});
});

</script>