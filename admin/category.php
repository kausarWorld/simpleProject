<?php
require_once '../core/init.php'; 
include 'includes/head.php';
include 'includes/navi.php';
$sql="SELECT * FROM c WHERE parent=0";
$catresult=$db->query($sql);
$errors=array();
$category_value='';
$parent_value='';
$category1='';
$parent_id1=0;
if (isset($_GET['edit'])&& !empty($_GET['edit'])) {
	$edit_id=$_GET['edit'];
	$editquery="SELECT * FROM c WHERE id='$edit_id'";
	$editrsult=$db->query($editquery);
	$editarray=mysqli_fetch_assoc($editrsult);
	echo $editarray['category'];


}
//delete category
if (isset($_GET['delete'])&& !empty($_GET['delete'])) {
	$delete_id=$_GET['delete'];
	$deltequery1="SELECT * FROM c WHERE id='$delete_id'";
	$querydelete=$db->query($deltequery1);
	$deleteone=mysqli_fetch_assoc($querydelete);
	$deleteid=$deleteone['id'];
	if($deleteone['parent']==0)
	{
           $deltequery="DELETE FROM c WHERE parent='$delete_id'";
           $db->query($deltequery);
	}
	$deltequery="DELETE FROM c WHERE id='$delete_id'";
	$db->query($deltequery);
	header('Location:category.php');
}
//form submit
if (isset($_POST['add_category'])) {
	$parent_id1=$_POST['parent'];
	$category1=$_POST['category'];
	if ($category1=='') {

		$errors[].="category cant be left blank";
	}
	$sql1="SELECT * FROM c WHERE category='$category1' AND parent='$parent_id1'";
	$checkresult=$db->query($sql1);
	$count=mysqli_num_rows($checkresult);
	if ($count>0) {

	 	$errors[].="ctaegory alredy exists";
	 } 
if (!empty($errors)) {
$display=display_errors($errors); ?>
<script>
	jQuery("document").ready(function(){
		jQuery('#error').html('<?=$display;?>');
	});
</script>

<?php }else {
	$updatecat="INSERT INTO c(category,parent) VALUES('$category1','$parent_id1')";
	if (isset($_GET['edit'])) {
		$updatecat="UPDATE c SET category='$category1',parent='$parent_id1' WHERE id='$edit_id'";
		
	}
$db->query($updatecat);
header('Location:category.php');
}



}
if (isset($_GET['edit'])) {
	$category_value=$editarray['category'];
	$parent_value=$editarray['parent'];
	
}
else
{
	if(isset($_POST))
	{
		$category_value=$category1;
		$parent_value=$parent_id1;
	}
}


?>
<h4 class="text-center">categories</h4>
<div class="col-md-6"> 
<form  action="category.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:'')?>" method="post">
	<legend><?=((isset($_GET['edit']))?'edit':'add');?> a category</legend>
	<div id="error"></div>
	<div class="form-group">
		<label for="parent">parent</label>
		<select class="form-control" id="parent" name="parent">
			<option value="0"<?=(($parent_value==0)?' selected="selected"':'');?>>parent</option>
			<?php while($parentvalue=mysqli_fetch_assoc($catresult)):?>
				<option value="<?=$parentvalue['id'];?>"<?=(($parent_value==$parentvalue['id'])?' selected="selected"':'');?>><?=$parentvalue['category'];?></option>
			<?php endwhile;?>
		</select>
	</div>
	<div class="form-roup">
		<label for=category>category</label>
		<input type="text" name="category" id="category" class="form-control" value="<?=$category_value;?>">
	</div>
	<div class="form-group">
		<input type="submit" name="add_category" value="<?=((isset($_GET['edit']))?'edit':'add');?> category" class="btn btn-success btn-default" style="margin-top: 10px;">
	</div>
	
 </form> 
</div>
<div class="col-md-6">
	<table  class="table table-bordered">
		<thead>
			<th>category</th><th>parent</th><th></th>
		</thead>
		<tbody>
			<?php
			$sql="SELECT * FROM c WHERE parent=0";
                 $catresult=$db->query($sql);
 
			while($parent=mysqli_fetch_assoc($catresult)):
			$parent_id=$parent['id'];
                 $catquery="SELECT * FROM c WHERE parent='$parent_id'";
                 $childresult=$db->query($catquery);
			?>
			<tr class="bg-primary">
				<td><?=$parent['category'];?></td>
				<td>parent</td>
				<td>
					<a href="category.php?edit=<?=$parent['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
					<a href="category.php?delete=<?=$parent['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>
					
				</td>
			</tr>
			<?php while($child=mysqli_fetch_assoc($childresult)):?>
			<tr class="bg-info">
				<td><?=$child['category'];?></td>
				<td><?=$parent['category'];?></td>
				<td>
				<a href="category.php?edit=<?=$child['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
					<a href="category.php?delete=<?=$child['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>
				</td>
					

			</tr>
		<?php endwhile;?>
		<?php endwhile;?>
		</tbody>
	</table>
</div>

<?php include 'includes/foot.php';?>