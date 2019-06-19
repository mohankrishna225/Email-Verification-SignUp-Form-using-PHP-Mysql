<?php include("includes/header.php") ?>


    <div class="row">
		<div class="col-lg-6 col-lg-offset-3">	
		
            <?php display_message (); ?>
            
            <?php validate_code (); ?>
  

			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert">
					<span aria-hidden="true">×</span><span class="sr-only">Close</span>
				</button>We have a sent a security code to your email <span>@edwin@email.com</span>
			</div>					
		</div>
	</div>

    <div class="row">
				<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3">
					<div class="alert-placeholder">
	
					</div>
					<div class="panel panel-success">
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									<div class="text-center"><h2><b> Enter Code</b></h2></div>
									<form id="register-form"  method="post" role="form" autocomplete="off">
										<div class="form-group">
											<input type="text" name="code" id="code" tabindex="1" class="form-control" placeholder="##########" value="" autocomplete="off" required/>
										</div>
										<div class="form-group">
											<div class="row">

												<div class="col-lg-3 col-lg-offset-2 col-md-3 col-md-offset-2 col-sm-3 col-sm-offset-2  col-xs-6">
													<input type="submit" name="code-cancel" id="code-cancel" tabindex="2" class="form-control btn btn-danger" value="Cancel" />
			
												</div>
												<div class="col-lg-3 col-lg-offset-2 col-md-3 col-md-offset-2 col-sm-3 col-sm-offset-2 col-xs-6">
													<input type="submit" name="code-submit" id="recover-submit" tabindex="2" class="form-control btn btn-success" value="Continue" />
													
												</div>

											</div>
										</div>
										<input type="hidden" class="hide" name="token" id="token" value="">
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

<?php include("includes/footer.php") ?>