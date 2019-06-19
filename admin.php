<?php include("includes/header.php") ?>

<?php include("includes/nav.php")  ?>
  


	<div class="jumbotron">
		<h1 class="text-center"><?php if(logged_in()){
			echo "Logged In";
		}else{
			redirect("index.php");
		}

		?></h1>
	</div>





<?php include("includes/footer.php") ?>