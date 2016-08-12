<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>XZBox | Login</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/app.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--	<link rel="stylesheet" href="assets/css/bootstrap-theme.css">-->
</head>
<body>
<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<a class="navbar-brand" href="http://xzbox.com" target="_blank">XZBox</a>
		</div>
	</div><!-- /.container-fluid -->
</nav>

<div class="container">
	<div class="row">
		<div class=" col-md-6 col-lg-5 col-sm-12 col-xs-12  center-block">
			<div class="panel panel-black">
				<div class="panel-heading">Login</div>
				<form method="post" autocomplete="off">
					<div class="panel-body">
						<div class="form-group">
							<label for="username" class="col-sm-3 control-label">Username:</label>

							<div class="col-sm-9">
								<input type="text" class="form-control" id="username" placeholder="Username..." autocomplete="off">
							</div>
						</div>
						<br>
						<div class="form-group">
							<label for="password" class="col-sm-3 control-label">Password:</label>

							<div class="col-sm-9">
								<input type="password" class="form-control" id="password" placeholder="Password..." autocomplete="off">
							</div>
						</div>
					</div>
					<div class="panel-footer">
						<button type="submit" class="btn btn-black btn-block">Login</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<hr>
	<div class="text-center">&copy; QTIƎE</div>
</div>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script>
	$('[data-toggle="tooltip"]').tooltip()
</script>
</body>
</html>