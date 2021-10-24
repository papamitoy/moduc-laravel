



$(document).ready(function(){
	
	$("#loaddata").load("datatable.php",function(re){
		
	});
	
});

//searchdata

function onsearchData(){
	var searchBar = $("#searchdata").val();
	$("#loaddata").load("datatable.php",{searchBar:searchBar},function(re){
		
	});
}


//enterdata
	function addacount(){
		
	var firstname= $("#fname").val();
	var lastname=$("#lname").val();
	var username=$("#username").val();
	var password=$("#pass").val();
	var bday=$("#bbdate").val();
	console.log(firstname); 
	
	$.post("create-user.php",{fname:firstname,lname:lastname, uname:username, pass:password, bdate:bday},function(response){
		
		
		console.log(response);
			$("#fname").val("");
			$("#lname").val("");
			$("#username").val("");
			$("#pass").val("");
			$("#bbdate").val("");
	
			$("#loaddata").load("datatable.php",function(re){
		
			});
	})
	
}


function updateData(message,fname,lname,username,pass,bbdate,uid,button){
	var fname= $("#"+fname).val();
	var lname=$("#"+lname).val();
	var username=$("#"+username).val();
	var password=$("#"+pass).val();
	var bday=$("#"+bbdate).val();



	
	$.post("include/updateData.php",{data:uid,fname:fname,lname:lname, username:username, pass:password, bbdate:bday},function(response){
		console.log(response);
	
		$("#"+button).click();
		//$("#"+message).html(response);

		
	
$("#loaddata").load("datatable.php",function(re){});
	});
}

function deleteData(data){
	$.post("include/deleteData.php",{data:data},function(response){
		console.log(response);
		$("#loaddata").load("datatable.php",function(re){});
	});
}

