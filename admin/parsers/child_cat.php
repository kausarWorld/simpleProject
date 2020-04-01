<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/clothes8/core/init.php';
$childId=(int)$_POST['parentId'];
$childquery="SELECT * FROM c WHERE parent='$childId'";
$childs=$db->query($childquery);
ob_start();
?>
<option value=""></option>
<?php while($child=mysqli_fetch_assoc($childs)): ?>
	<option value="<?=$child['id'];?>"><?=$child['category'];?></option>
<?php endwhile;?>
<?php echo ob_get_clean();?>