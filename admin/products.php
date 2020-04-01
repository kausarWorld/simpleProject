<?php require_once $_SERVER['DOCUMENT_ROOT'].'/clothes8/core/init.php'; 
include 'includes/head.php';
include 'includes/navi.php';
if(isset($_GET['add'])) { 
$sql="SELECT * FROM brand";
$brandresult=$db->query($sql);
$parentquery="SELECT * FROM c WHERE parent=0";
$parentarray=$db->query($parentquery);
if ($_POST) {
	$title=$_POST['title'];
	$brand=$_POST['brand'];
	$price=$_POST['price'];
	$child=$_POST['child'];
	$listprice=$_POST['listprice'];
	$sizes=$_POST['sizes'];
	$photo=$_POST['photo'];
	$description=$_POST['description'];
	$errors=array();
	if(!empty($_POST['sizes'])){
		$sizedata=$_POST['sizes'];
		 $Asize=array();
             $Qsize=array();
		$sizearray=explode(',', $sisesarray);
		foreach($sizearray as $ss){
             $s=explode(':', $ss);
             $Asize=$s[0];
              $Asize=$s[1];
            

		}

	}else{$sizearray=array();}
	$required=array('title','brand','parent','child','price','photo','description');
	foreach($required as $filed){
		if ($_POST[$filed]=='') {
			$errors[]="all fileds must be filed";
			break;
		}
	}
	if (!empty($_FILES)) {
		
	}
	if (!empty($errors)) {
		echo display_errors($errors);
	}else
	{
		$update="INSERT INTO products(`title`,`price`,`list_price`,`brand`,`category`,`image`,`description`) VALUES('$title','$price','$listprice','$brand','$child','$photo','$description')";
		$db->query($update);
		header('Location:products.php');
	}

}
 ?>
<h2 class="text-center">products</h4>
<form action="products.php?add=1" method="post" enctype="mutipart/form-data">

	<div class="form-group col-md-3">
		<label for="title">title:*</label>
		<input type="text" name="title" class="form-control" id="title" value="">
	</div>
	<div class="form-group col-md-3">
		<label for=brand>brand:*</label>
		<select id="brand" class="form-control" name="brand">
			<option value=""></option>
			<?php while($brand=mysqli_fetch_assoc($brandresult)):?>
			<option value="<?=$brand['id'];?>"><?=$brand['brand'];?></option>
            <?php endwhile;?>
		</select>
	
	</div>
	<div class="form-group col-md-3">
		<label for=parent>parent:*</label>
		<select id="parent" class="form-control" name="parent" >
			<option value=""></option>
			<?php while($parent=mysqli_fetch_assoc($parentarray)):?>
			<option value="<?=$parent['id'];?>"><?=$parent['category'];?></option>
            <?php endwhile;?>
		</select>
	</div>
	<div class="form-group col-md-3">
		<label for=child>child:*</label>
		<select id="child" class="form-control" name="child">
		</select>
	</div>
	<div class="form-group col-md-3">
		<label for="price">price:*</label>
		<input type="text" name="price" class="form-control" id="price" value="">
	</div>
<div class="form-group col-md-3">
		<label for="list_price"> list price:*</label>
		<input type="text" name=" listprice" class="form-control" id="list_price" value="">
	</div>
	<div class="form-group col-md-3">
		 <label >sizes &qty </label>
	<button class="form-control" onclick="jQuery('#sizesmodal').modal('toggle');return false;" data-toggle="modal" data-target="#sizesodal"></button>

	</div>
	<div class="form-group col-md-3">
    <label for="sizes">sizes &qty review</label>
    <input type="text" name="sizes" id="sizes" class="form-control" readonly value="">
</div>
<div class="form-group col-md-6">
    <label for="photo" class="text-center">photo</label>
    <input type="file" name="photo" id="photo" class="form-control">
    </div>
    <div class="form-group col-md-6">
    	<label for="description">description</label>
    	<textarea rows="6" class="form-control" name="description" value=""></textarea>
    	
    </div>
    <div class="form-group col-md-3">
    	<input type="submit" name="submit" class="form-control btn btn-sm btn-success pull-right" value="submit form" ><div class="clearfix"></div>
    </div>
    

<!-- Modal -->

   

</form>
<div id="sizesmodal" class="modal fade" role="dialog" aria-labelledby="sizesmodalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
      	<div class="container-fluid">
      		<?php for($i=1;$i<=12;$i++):?>
                <div class="form-group col-sm-4">
                	<label for="size<?=$i;?>">size</label>
                	<input type="text" name="size<?=$i?>" class="form-control" id="size<?=$i;?>"" value="<?=((!empty($Asize[$i-1]))?$Asize[$i-1]:'');?>">
                </div>
                 <div class="form-group col-sm-2">
                	<label for="qty<?=$i;?>">qty</label>
                	<input type="number" name="qty<?=$i?>" class="form-control" id="qty<?=$i;?>" value="<?=((!empty($Qsize[$i-1]))?$Qsize[$i-1]:'');?>">
                </div>
<?php endfor;?>
      	</div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="updatesizes();jQuery('#sizesmodal').modal('toggle');return false;">update sizes</button>
      </div>
    </div>

  </div>
</div>



<?php } else{
$sql="SELECT * FROM products";
$result=$db->query($sql);
if (isset($_GET['featured'])) {
	$featured1=$_GET['featured'];
	$id1=$_GET['id'];
	$fresult="UPDATE products SET featured=$featured1 WHERE id='$id1'"; 
    $db->query($fresult);
    header('Location:products.php');
}

?>
<h2 class="text-center">products</h2>
<a href="products.php?add=1" class="btn btn-sm btn-success pull-right" style="margin-top:-20px;">add products</a><hr>
<table class="table table-striped table-bordered">
	<thead><th></th><th>products</th><th>price</th><th>category</th><th>featured</th><th>sold</th>
	</thead>
	<tbody>
		<?php while($product=mysqli_fetch_assoc($result)):
		$productchildid=$product['category'];
                $catresult="SELECT * FROM c WHERE id='$productchildid'";
                $catquery=$db->query($catresult);
                $cat=mysqli_fetch_assoc($catquery);
                $catparent=$cat['parent'];
                $presult="SELECT * FROM c WHERE id='$catparent'";
                $pquery=$db->query($presult);
                $pat=mysqli_fetch_assoc($pquery);
                $fullcat=$pat['category'].'~'.$cat['category'];
		?>
		<tr>
			<td>
				<a href="products.php?edit=1" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
				<a href="products.php?delete=1" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>
				
			</td>
			<td><?=$product['title'];?></td>
			<td><?=$product['price'];?></td>
			<td><?=$fullcat;?></td>
			<td><a href="products.php?featured=<?=(($product['featured']==1)?'0':'1');?>&id=<?=$product['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-<?=(($product['featured']==0)?'plus':'minus');?>"></span></a></td>
			<td>0</td>
		</tr>
	<?php endwhile;?>
	</tbody>
</table>



<?php } include 'includes/foot.php';?>