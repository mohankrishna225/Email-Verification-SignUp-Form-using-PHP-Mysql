<?php include("includes/header.php") ?>

	
	<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Login App</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">

            <li><a href="index.php">Home</a></li>
     
          </ul>


          
		  <ul class="nav navbar-nav navbar-right">
            
            <li ><a href="logout.php">Logout</a></li>
     
          </ul>



        
        </div><!--/.nav-collapse -->
      </div>
    </nav>
	
<div class="container">

	<div class="row">
		<div class="col-lg-6 col-lg-offset-3">
            
		<?php validate_user_registration(); ?>						
		</div>



	</div>
    	<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-login">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-6">
								<a href="login.php">Login</a>
							</div>
							<div class="col-xs-6">
								<a href="register.php" class="active" id="">Register</a>
							</div>
						</div>
						<hr>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<form id="register-form" method="post" role="form" >

									<div class="form-group">
										<input type="text" name="first_name" id="first_name" tabindex="1" class="form-control" placeholder="First Name" value="" required >
									</div>
									<div class="form-group">
										<input type="text" name="last_name" id="last_name" tabindex="1" class="form-control" placeholder="Last Name" value="" required >
									</div>

									<div class="form-group">
										<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="" required >
									</div>
									<div class="form-group">
										<input type="email" name="email" id="register_email" tabindex="1" class="form-control" placeholder="Email Address" value="" required >
									</div>
									<div class="form-group">
										<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password" required>
									</div>
									<div class="form-group">
										<input type="password" name="confirm_password" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirm Password" required>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Register Now">
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	
<?php include("includes/footer.php") ?>