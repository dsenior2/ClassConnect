<?php ?>
<!DOCTYPE html>
<!--
	Transit by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title> </title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<!--[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="loginstyle.css" />
	

		<!-- Latest compiled and minified CSS -->
		<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->

		<!-- Latest compiled and minified JavaScript -->
		<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> -->

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

		
	</head>
	<body class="landing">

<!-- 	<nav class="navbar navbar-default">
		<div class="container-fluid">
	    	<div class="navbar-header">

	    	</div>
		</div>
	</nav> -->
<nav class = "navbar navbar-default" role = "navigation">
   <div class = "navbar-header">
      <a class = "navbar-brand" href = "login.html" style="font-weight: bold; font-size: 30px">
      	ClassConnect
      	<!-- <p style="font-family:Courier; color:Blue; font-size: 50px;">ClassConnect</p> -->
      </a>
<!--       <p class="navbar-text navbar-right">Login/Register</p>  -->
   </div>
</nav>

		<div class = "container">
			<div class="wrapper">
				<div role="form" class="form-signin"> <!-- form action="" method="post" name="Login_Form" class="form-signin" -->       
				    <h3 class="form-signin-heading">Welcome to ClassConnect.</h3>
					  <hr class="colorgraph"><br>
					  
					  <input id="username" type="text" class="form-control" name="username" placeholder="Username" autofocus="" />
					  <input id="password" type="password" class="form-control" name="password" placeholder="Password"/>     		  
					 
					  <button class="btn btn-lg btn-primary btn-block" name="Submit" value="Login" type="Submit" onclick="login()">Login</button>  			
				</div>			
			</div>
		</div>

<div class="container" style="text-align:center;">
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-default btn-lg" id="myBtn">Register?</button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="padding:35px 50px;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4><span class="glyphicon glyphicon-lock"></span> Register</h4>
        </div>
        <div class="modal-body" style="padding:40px 50px;">
          <div>
           
            <!--the name of the new user-->
            <div class="form-group">
              <label for="name"><span class="glyphicon glyphicon-user"></span> Name</label>
              <input type="text" class="form-control" id="name" placeholder="Enter full name">
            </div>
            
            <!--the email of the new user-->
            <div class="form-group">
              <label for="usrname"><span class="glyphicon glyphicon-user"></span> Username</label>
              <input type="text" class="form-control" id="usrname" placeholder="Enter email">
            </div>
            
            <!--the password of the new user-->
            <div class="form-group">
              <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Password</label>
              <input type="password" class="form-control" id="psw" placeholder="Enter password">
            </div>
            
            
              <button type="submit" class="btn btn-info btn-block" onclick="register();"><span class="glyphicon glyphicon-ok"></span> Register</button>
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
        </div>

      </div>
      
    </div>
  </div> 
</div>
 
<script>
$(document).ready(function(){
    $("#myBtn").click(function(){
        $("#myModal").modal();
    });
});
</script>


	<footer class="footer">
		<div class="container" style="text-align:center;">
			<a href="#">F.A.Q. Page</a>
		</div>
	</footer>

		
</html>

<script>
	function login() {
		debugger;
		$.ajax({
			type: "POST",
			url: "../4_14_2017_jesus.php",
			dataType: "json",
			data: {
				action : 'login',
				username : $("#username").val(),
				password : $("#password").val()
			},
			success: function(response) {
				if (response['result'] == false)
				{
					console.log('Username and/or password is invalid. Please try again or register.');
				}
				else if (response['result'] == true)
				{
					console.log(JSON.stringify(response));
					location = "../html/home.php";
				}
			},
            error: function(response) {
                console.log('ERROR:' + JSON.stringify(response));
            }
		});
	}
 	function register() {    
		 console.log("mm");
	    $.ajax({
	      type: "POST",
	      url: "../4_14_2017_jesus.php",
	      dataType: "json",
	      data: {
	        action : 'register',
	        username : $("#usrname").val(),
	        password : $("#psw").val(),
	        name: $("#name").val()
	      },
	      success: function(response) {
					debugger;
	        if (response['result'] == false)
	        {
	          console.log('failed to register.');
	        }
	        else if (response['result'] == true)
	        {
	          console.log(JSON.stringify(response));
						location = "../html/home.php";
	        }
	      },
	      error: function(response) {	
	            console.log('ERROR:' + JSON.stringify(response));
	        }
	    });
  }
</script>