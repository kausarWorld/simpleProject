<?php
function display_errors($errors)
{
$display='<ul class="bg-danger">';
foreach ($errors as $error) {
	$display.='<li class="text-danger">'.$error.'</li>';
}
$display.='</ul>';
return $display;
}
function login($user_id)
{
	$_SESSION['SBUser']=$user_id;
	$date=date('Y-m-d h:i:s');
	global $db;
	$db->query("UPDATE users SET last_login='$date' WHERE id='$user_id'");
	header('Location:index.php');


}
function is_logged_in()
{
if (isset($_SESSION['SBUser'])&& $_SESSION['SBUser']>0) {
	return true;
}

	return false;
}

function logged_error_redirect($url='login.php')
{
$_SESSION['error_flash']='you must logged in to access this page';
header('Location:'.$url);
}
function has_permissions($permission='admin')
{
	global $user_data;
$permissions=explode(',', $user_data['permissions']);
if (in_array($permission,$permissions,true)) {
	return true;
}
return false;
}
function permissions_error_redirect($url='login.php')
{
	$_SESSION['error_flash']='you must logged in to access this page';
header('Location:'.$url);

}

?>