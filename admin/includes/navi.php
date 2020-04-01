<nav class="navbar nav-navbar navbar-inverse navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
		<a class="navbar-brand" href="index.php">kausar'shop</a>
	</div>
	<ul class="nav navbar-nav">
		<li ><a href="brands.php">brands</a></li>
		<li ><a href="category.php">category</a></li>
		<li ><a href="products.php">products</a></li>
		<?php if (has_permissions('admin')): ?>
		<li ><a href="user.php">Users</a></li>
		<?php endif;?>
	</ul>
		
	</div>
	</nav>