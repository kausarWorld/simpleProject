
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/clothes8/core/init.php'; 
include 'includes/head.php';
$email=((isset($_POST['email']))?$_POST['email']:'');
$email=rtrim($email);
$password=((isset($_POST['password']))?$_POST['password']:'');
$email=rtrim($email);

?>
<div id="login-form">
	<div>
		<?php
         if ($_POST) {
         	$errors=array();
         	if (empty($_POST['email']) || empty($_POST['password'])) {
         		$errors[]="must enter email password";
         	}
         	$userresult=$db->query("SELECT * FROM users WHERE email='$email'");
         	$userid=mysqli_fetch_assoc($userresult);
         	$count=mysqli_num_rows($userresult);
         	$user_id=$userid['id'];
         	if($count<1)
         	{
         		$errors[]="doent exist in database";
         	}
         	if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
         		$errors[]="enter valid email";
         	}
         	if (strlen($password)<6) {
         	     $errors[]="password must be greater than 6";
         	}
         	if (!password_verify($passworduserid['password'])) {
         		# code...
         	}

            if (!empty($errors)) {
            echo display_errors($errors);
            }else,$
            {
            	login($user_id);
            }
         }


		?>
	</div>
	<form method="post" action="login.php">
		<div class="form-group">
			<label for="email">email</label>
			<input type="text" name="email" class="form-control" value="<?=$email;?>">
		</div>
		<div class="form-group">
			<label for="email">passoword</label>
			<input type="password" name="password" class="form-control" value="<?=$password;?>">

		</div>
		<div class="form-group">
			
			<input type="submit" name="submit" class="btn btn-primary btn-sm" value="login">
		</div>
	</form>
	
</div>