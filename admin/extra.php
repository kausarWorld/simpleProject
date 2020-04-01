if(isset($_GET['add'])){ 
$sql="SELECT * FROM brand";
$brandresult=$db->query($sql);
$parentquery="SELECT * FROM c WHERE parent=0";
$parentarray=$db->query($parentquery);
 ?>
<h2 class="text-center">products</h4>
<form action="products.php" method="post" enctype="mutipart/form-data">
	<div class="form-group col-md-3">
		<label for="title">title:*</label>
		<input type="text" name="title" class="form-control" id="title" value="">
	</div>
	<div class="form-group col-md-3">
		<label for=brand>brand:*</label>
		<select id="brand" class="form-control" >
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
	<button class="form-control" onclick="jQuery('#sizesmodal').modal('toggle');return false;"></button>

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
   

</form>