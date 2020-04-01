<?php
require_once '../core/init.php'; 
include 'includes/head.php';
include 'includes/navi.php';
$brandarray = "SELECT * FROM brand";
$brandquery=$db->query($brandarray);
$errors=array(); 
//edit brand
if (isset($_GET['edit'])&& !empty($_GET['edit'])) {
	$edit_id=$_GET['edit'];
	$editquery="SELECT * FROM brand WHERE id='$edit_id'";
	$brandvalue=$db->query($editquery);
	$branddata=mysqli_fetch_assoc($brandvalue);
}
//delete brand
if(isset($_GET['delete'])&& !empty($_GET['delete']))
{
	$delete_id=$_GET['delete'];
	$deletequery="DELETE FROM brand WHERE id='$delete_id'";
               $db->query($deletequery);
               header('Location:brands.php');

 }

//form submit
if(isset($_POST['add_submit']))
{
	$brand=$_POST['brand1'];
	if ($_POST['brand1']=='') {
		$errors[].="plz enter brand cant left blnk";
		
	}
	$sql="SELECT * FROM brand WHERE brand='$brand'";
	if (isset($_GET['edit'])) {
		$sql="SELECT * FROM brand WHERE brand='$brand' AND id!='$edit_id'";
	}
	$brandres=$db->query($sql);
$count=mysqli_num_rows($brandres);
	if ($count>0) {
		$errors[].="brand alredy exist";
	}
	if (!empty($errors)) {
		echo display_errors($errors);
	}
	else
	{
		$insertbrand="INSERT INTO brand (brand) VALUES('$brand')";
		if (isset($_GET['edit'])) {
			$insertbrand="UPDATE brand SET brand='$brand' WHERE id='$edit_id'";
		}
		$db->query($insertbrand);
		header('Location:brands.php');
	}
}
$brand_value='';
if(isset($_GET['edit'])) {
	$brand_value=$branddata['brand'];

}
else{
	if(isset($_POST['brand1'])) {
	$brand_value=$brand;
}
}
?>

<h4 class="text-center">Brands</h4>

<hr>
<div class="text-center">
	<form class="form" action="brands.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:'');?>" method="post">
		<div class="form-inline">
			<label for="brand"><?=((isset($_GET['edit']))?'edit':'add');?> brand</label>
			<input type="text" name="brand1" value="<?=$brand_value;?>" class="form-control">
			<?php if(isset($_GET['edit'])):?>
            <a href="brands.php" class="btn btn-default btn-sm">cancel</a>
			<?php endif;?>

			<input type="submit" name="add_submit" class="btn btn-success btn-sm" value="<?=((isset($_GET['edit']))?'edit':'add');?>brand">

		</div>
	</form>
	
</div>
<br>
<table class="table table-bordered table-striped table-condensed" id="table-auto">
	<thead>
		<th></th><th>brands</th><th></th>
	</thead>
	<?php while($brands=mysqli_fetch_assoc($brandquery)):
	?>
	<tr>
		<td>
			<a href="brands.php?edit=<?=$brands['id'];?>" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
		</td>
		<td><?=$brands['brand'];?></td>
		<td>
			<a href="brands.php?delete=<?=$brands['id'];?>" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>
		</td>
	</tr>
<?php endwhile;?>
</table>
<?php include 'includes/foot.php';?>
