<!DOCTYPE html>
<html>
<head>
	<title>Treasure System Login</title>
	<link rel="stylesheet" type="text/css" href="<?=base_url('css/bootstrap/bootstrap.min.css');?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('css/style.css');?>">
</head>
<body id="login-body">
	<div id="login-form" class="col-xs-10 col-sm-8 col-md-8 col-lg-6">
		<form>  
			<h3><span class="glyphicon glyphicon-user"></span> Login</h3>
			<div class="form-group"><input type="text" name="USERNAME" class="form-control" placeholder="Username"/></div>
			<div class="form-group"><input type="password" name="PASSWORD" class="form-control" placeholder="Password"/></div>
			<button class="btn btn-primary pull-right" type="submit">Login</button>
		</form>
	</div>
	<script type="text/javascript" src='js/jquery/jquery-1.11.3.js'></script>
	<script type="text/javascript" src='js/bootstrap/bootstrap.min.js'></script>
</body>
</html>