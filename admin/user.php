<?php 
require_once '../core/init.php';
echo $_SESSION['SBUser'];
if (!is_logged_in()) {
logged_error_redirect();
}

if (!has_permissions('admin')) {
	permission_error_redirect('brands.php');
}
include 'includes/head.php';
include 'includes/navigation.php';
$errors=array();

$userresult=$db->query("SELECT * FROM users");
if (isset($_GET['delete'])) {
	$delete_id=$_GET['delete'];
	$db->query("DELETE FROM users WHERE id='$delete_id'");
	header('Location:users.php');
}if(isset($_GET['add']))
{

		
	
$name=((isset($_POST['full_name']))?$_POST['full_name']:'');
$email=((isset($_POST['email']))?$_POST['email']:'');
$password=((isset($_POST['password']))?$_POST['password']:'');
$confirm=((isset($_POST['confirm']))?$_POST['confirm']:'');
$permissions=((isset($_POST['permissions']))?$_POST['permissions']:'');
if ($_POST) {
	$emailquery=$db->query("SELECT * FROM users WHERE email='$email'");
		$emailcount=mysqli_num_rows($emailquery);
		if($emailcount!=0)
		{
			$errors[]="email already exist in database";
		}
	$required=array('full_name','email','password','confirm','permissions');
	foreach($required as $req){
		if (empty($_POST[$req])) {
			$errors[]='all filileds must be filed';
			break;
		}
	}
	if ($password!=$confirm) {
		$errors[]="password not matching";
	}
	if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
		$errors[]="enter correct email";
	}
	if (strlen($password)<6) {
	$errors[]="password must be graeter than 6";
	}
	if (!empty($errors)) {
		echo display_error($errors);
	}else
	{
	$hashed=password_hash($password,PASSWORD_DEFAULT);
	$db->query("INSERT INTO users(full_name,email,password,permissions) VALUES('$name','$email','$hashed','$permissions')");
		$_SESSION['success_flash']="u have added user";
		header('Location:users.php');
	}
}
 ?>
	<h2 class="text-center">add new user</h2>
<form action="users.php?add=1" method="post" >
	<div class="col-md-6 form-group">
		<label for="full_name">name:</label>
		<input type="text" name="full_name" id="full_name" class="form-control" value="<?=$name;?>">
	</div>
	<div class="col-md-6 form-group">
		<label for="email">email:</label>
		<input type="text" name="email" id="email" class="form-control" value="<?=$email;?>">
	</div>
	<div class="col-md-6 form-group">
		<label for="password">password:</label>
		<input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
	</div>
	<div class="col-md-6 form-group">
		<label for="confirm">confirm:</label>
		<input type="password" name="confirm" id="confirm" class="form-control" value="<?=$confirm;?>">
	</div>
	<div class="col-md-6 form-group">
		<label for="permissions">permissions:</label>
		<select class="form-control" id="permissions" name="permissions" >
			<option value=""<?=(($permissions=='')?'selected':'');?>></option>
			<option value="editor"<?=(($permissions=='editor')?'selected':'');?>>editor</option>
			<option value="admin,editor"<?=(($permissions=='admin,editor')?'selected':'');?>>admin</option>
		</select>
		
	</div>
	<div class="form-group pull-right" style="margin-top: 30px;">
		<a href="users.php" class=" btn btn-default">cancel</a>
	<input type="submit" class="btn btn-default btn-primary">
	</div>
</form>

<?php
}
else{
?>
<h2 class="text-center">users</h2><hr>
<a href="users.php?add=1" class="btn btn-default btn-success pull-right" style="margin-top: -70px;">add a new user</a>
<table class="table table-bordered table table-striped">
	<thead>
		<th></th><th>full name</th><th>email</th><th>join date</th><th>last login</th><th>permissions</th>
	</thead>
	<tbody>
		<?php while($users=mysqli_fetch_assoc($userresult)):?>
		<tr>
           <td><?php if($users['id']!=$user_data['id']):?>
			
				<a href="users.php?delete=<?=$users['id'];?>" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-remove-sign"></span></a>
			
             <?php endif;?></td>
			<td><?=$users['full_name'];?></td>
			<td><?=$users['email'];?></td>
			<td><?=pretty_date($users['join_date']);?></td>
			<td><?=pretty_date($users['last_login']);?></td>
			<td><?=$users['permissions'];?></td>
		</tr>
	<?php endwhile;?>
	</tbody>
</table>
<?php } include 'includes/footer.php';?>