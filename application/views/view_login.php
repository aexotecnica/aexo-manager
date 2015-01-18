<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Avant</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Avant">
	<meta name="author" content="The Red Team">

	<!-- <link href="<?= base_url() ?>assets/less/styles.less" rel="stylesheet/less" media="all"> -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/styles.css">
	<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>

	<!-- <script type="text/javascript" src="<?= base_url() ?>assets/js/less.js"></script> -->
</head>
<body class="focusedform">

	<div class="verticalcenter">
		<img src="<?= base_url() ?>assets/aexo-manager/img/logo_aexo_transparente.png" alt="Logo" class="brand" />
		<div class="panel panel-primary">
			<div class="panel-body">
				<h4 class="text-center" style="margin-bottom: 25px;">Inicie session para comenzar</h4>
				<form action="<?= base_url() ?>index.php/login/autenticar" method="post" class="form-horizontal" style="margin-bottom: 0px !important;">
					<div class="form-group">
						<div class="col-sm-12">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-user"></i></span>
								<input type="text" class="form-control" id="username" name="username" placeholder="Username">
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-lock"></i></span>
								<input type="password" class="form-control" id="password" name="password" placeholder="Password">
							</div>
						</div>
					</div>
					<div class="panel-footer">
						<div class="pull-right">
							<button class="btn-primary btn">Log In</button>
						</div>
					</div>
				</form>

			</div>

		</div>
	</div>

</body>
</html>