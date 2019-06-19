<?php


/* HeLper Functions for cleaning htmltags and dislay he messages and setting the session message to be displayed in the session and generating a token */
function clean($string){

	return htmlentities($string);

}

function redirect($location){

	return header("Location: {$location}");

}



function set_message($message) {

  if(!empty($message)){
   
   $_SESSION['message']	= $message;
   
   }else {

	$message = "";
   }

}

function display_message(){

	if(isset($_SESSION['message'])){

		echo $_SESSION['message'];

		unset($_SESSION['message']);
	}
}


function token_generator(){

	$token =$_SESSION['token'] = md5(uniqid(mt_rand(),true));
	return $token;
  
}


function validation_errors($error_message){

	$error_message = <<<DELIMITER

        <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong=Warning</Strong> $error_message 
        </div>

DELIMITER;
        
return $error_message;
}



function email_exists($email){

	$sql = "SELECT id FROM users WHERE email ='$email'";

	$result = query($sql);

	if(row_count($result) ==1){
		return true;

	}else {
		return false;
	}
}


function username_exists($username){

	$sql = "SELECT id FROM users WHERE username ='$username'";

	$result = query($sql);

	if(row_count($result) ==1){
		return true;

	}else {
		return false;
	}
}



function send_email($email, $subject, $msg, $headers) {


return (mail($email, $subject, $msg, $headers));




}




/* Validation Functions*/

function validate_user_registration(){
  
   $errors = [];

   $min = 3;
   $max = 20;
   
  if($_SERVER['REQUEST_METHOD'] == "POST"){

  	$first_name = clean($_POST['first_name']);
  	$last_name = clean($_POST['last_name']);
  	$username = clean($_POST['username']);
  	$email = clean($_POST['email']);
  	$password = clean($_POST['password']);
  	$confirm_password = clean($_POST['confirm_password']);

   if(strlen($first_name) < $min) {

   	$errors[] = "Your first name cannor be less than {$min} characters ";

   }

   if(strlen($first_name) > $max) {

   	$errors[] = "Your first name cannor be greater than {$max} characters ";

   }


    if(empty($first_name)){

   	$errors[] = "Your Firstname cannot be empty";
   }


   if(strlen($last_name) < $min) {

   	$errors[] = "Your last name cannor be less than {$min} characters ";

   }

   if(strlen($last_name) > $max) {

   	$errors[] = "Your last name cannot be greater than {$max} characters ";

   }

    if(strlen($username) > $max) {

   	$errors[] = "Your username cannot be greater than {$max} characters ";

   }

   if(strlen($username) < $min) {

   	$errors[] = "Your user name cannot be less than {$min} characters ";

   }


    if(email_exists($email)){

     $errors[] = "Sorry that email is already registered ";

   }
    if(username_exists($username)){

     $errors[] = "Your that username is already registered ";

   }





   if(strlen($email) < $min) {

   	$errors[] = "Your email cannot be less than {$min} characters ";

   }

   if($password !== $confirm_password) {
 
    $errors[] = "Your passwords do not match";

   }
   
 



   
   if(!empty($errors)) {

   	foreach ($errors as $error) {
   		

   		echo validation_errors($error);
   	}
   } else {

        if(register_user($first_name, $last_name, $username, $email, $password)){

        	set_message("<p class='bg-success text-center'> Please Check Your Email for Activation Link</p>");

        	redirect("index.php");

        	echo "Users Registered";
        } else {

        	set_message("<p class='bg-danger text-center'> we could not register the user</p>");
        }

   }



  }//post request



} //function


/* ****************** Register user function**************  */
function register_user($first_name, $last_name, $username, $email, $password) {


	$first_name = escape($first_name);
	$last_name  = escape($last_name);
    $username   = escape($username);
    $email      = escape($email);
    $password   = escape($password);


	if(email_exists($email)) {

		return false;
	
	} else if (username_exists($username)) {

	   return false;

	 } else {
         
         $password        = md5($password);
           
         $validation_code = md5($username . microtime());  

	 	 $sql ="INSERT INTO users(first_name, last_name, username, email, password, validation_code, active)";
	    $sql.= " VALUES('$first_name','$last_name','$username','$email','$password','$validation_code', 0)";
	    $result = query($sql);
	    confirm($result);



	    $subject = "Activation of Account";
	    $msg = "Please Click the link below to activate your account
        http://localhost/udemy/activate.php?email=$email&code=$validation_code";

        $headers = "From: noreply@urwebsite.com";


        send_email($email, $subject, $msg, $headers);


        

	    return true;




	 }  

} 



/* ****************** Activate user function**************  */


function activate_user(){

	if($_SERVER['REQUEST_METHOD'] == "GET") {

		if(isset($_GET['email'])){


			echo $email = clean($_GET['email']);

			echo $validation_code = clean($_GET['code']);
		  
            $sql = "SELECT id FROM users WHERE email = '".escape($_GET['email'])."' AND validation_code ='".escape($_GET['code'])."' ";
            $result = query($sql);
            confirm($result);

            if(row_count($result) ==1) {

            $sql2 = "UPDATE users SET active =1, validation_code = 0 WHERE email ='".escape($email)."' AND validation_code ='" .escape($validation_code) ."' ";
            $result2 = query($sql2);
            confirm($result2);

            set_message("<p class='bg-success'>Your Account has been activated please login </p>");

            redirect("login.php");


          } else {


          	set_message("<p class='bg-danger'>Sorry Ur account is not activated</p>");
             redirect("login.php");
          }  

            
        }
	}

} //fucntion 


/*****************Validate user login Functions************** */
function validate_user_login() {
  
   $errors = [];

   $min = 3;
   $max = 20;
   
  if($_SERVER['REQUEST_METHOD'] == "POST"){

      


   $email    = clean($_POST['email']);
   $password = clean($_POST['password']); 
   $remember = isset($_POST['remember']);

   
  if(empty($email)) {

  	$errors[] = "Email Field cannot be empty";

  }

   if(empty($password)) {

  	$errors[] = "Password Field cannot be empty";
  	
  }


    
   if(!empty($errors)) {

   	foreach ($errors as $error) {
   		
        
   		echo  validation_errors($error);
   	}
   } else {

     
     if(login_user($email, $password, $remember)){

     	redirect("admin.php");
     } else {

     	echo validation_errors("Your Credenials are not correct");

     }
      

   }


 }
 


}//function



/********User Login Functions*************/


function login_user($email, $password, $remember) {


$sql = "SELECT password, id FROM users WHERE email = '".escape($email)."' AND active =1";

$result =query($sql);

if(row_count($result) ==1){

   $row = fetch_array($result);

   $db_password = $row['password'];

   if(md5($password) == $db_password){


    if($remember == "on") {

    	setcookie('email', $email, time() + 86400);
    }





    $_SESSION['email'] = $email; 	

   	return true;

   } else {

   	return false;
   }




	return true;
   } else {

   	return false;

   }



} ////end of function.


/**********Logged in Function*******/

function logged_in(){


	if(isset($_SESSION['email']) || isset($_COOKIE['email'])){

		return true;

	}else{

		return false;
	}


}  //funcion


/******* recover function ******/

function recover_password() {

	if($_SERVER['REQUEST_METHOD'] == "POST") {

       if(isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token'])  {

         
        $email = clean($_POST['email']);


        if(email_exists($email)){

         $validation_code = md5($email . microtime());

         setcookie('temp_access_code', $validation_code, time() + 900);


        $sql = "UPDATE users SET validation_code ='".escape($validation_code)."' WHERE email = '".escape($email)."'";
        $result = query($sql);
        confirm($result);
         	





        


         $subject = "please reset your password";
         $msg = "Here is the your password reset code {$validation_code}
           Click Here to reset your password http://localhost/udemy/code.php?email=$email&code=$validation_code";

         $headers = "From: noreply@urwebsite.com";


        	if(!send_email($email, $subject, $msg, $headers)) {

              // sending email via localhost
                 echo validation_errors("email could not be sent");
        	
        	}

        	set_message("<p class='bg-success text-center'>Please Check your Spam folder for a password reset</p>");

        	redirect("index.php");



        }else {

        	echo validation_errors("This email doesnot exists");
        }



         



       }else{  //token checking  if fails

       	redirect("index.php");
       }
        

     if(isset($_POST['cancel_submit'])){

        redirect("login.php");

     }  
     

    }// post request


     

}//functions 



/****** Code Validation****////
 
function validate_code(){

	if(isset($_COOKIE['temp_access_code'])) {

         
          if(!isset($_GET['email']) && !isset($_GET['code'])) {

                redirect("index.php");

         	} else if (empty($_GET['email']) || empty($_GET['code'])) {


                redirect("index.php");


         	}else {


         		if(isset($_POST['code'])){

                 
                 $email = clean($_GET['email']);

         		 $validation_code = clean($_POST['code']);

         		 $sql = "SELECT id FROM users WHERE validation_code ='".escape($validation_code)."' AND email ='".escape($email)."'";
         		 $result = query($sql);
         		 confirm($result);

         		 if(row_count($result) == 1){
                     
                    setcookie('temp_access_code', $validation_code, time() + 300);


         		 	redirect("reset.php?email=$email&code=$validation_code");

         		 }else {

         		 	echo validation_errors("Sorry wrong validation code");
         		 }
         		





         		}
         	}
         


	







	}else {

        set_message("<p class='bg-danger text-center'>Sorry Your Validation cookie was expired</p>");

         redirect("recover.php");
	}


} //function


/***********Password Reset*********/

function password_reset() {



	if(isset($_COOKIE['temp_access_code'])) {

      
        if(isset($_GET['email']) && isset($_GET['code'])) {


	        if(isset($_SESSION['token']) && isset($_POST['token']))  {


	         if($_POST['token'] === $_SESSION['token']) {


                
                if($_POST['password'] === $_POST['confirm_password']){

                  
                 $updated_password =md5($_POST['password']);



                $sql = "UPDATE users SET password ='".escape($updated_password)."', validation_code = 0 WHERE email = '".escape($_GET['email'])."' ";

                query($sql);


                set_message("<p class = 'bg-success text-center'> Your Password has been updated</p> ");

                redirect("login.php");

	        	    echo "Passwords Match";
                  }else {

                  	echo "Passwords donot Match"
                  }

	        	}

	
                
		
                       

            




              }

	   
	    }
    

    }else {



    	set_message("<p class='bg-danger text-center'>Sorry Your Time has expired </p>");
        


          redirect("recover.php");
    

          }



     }






?>