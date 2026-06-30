<?php 
	$root = $_SERVER['DOCUMENT_ROOT'] . '/mir/';
    include $root . 'api/common/sessions.php';
?>
<!DOCTYPE html>
<html lang="en">
	<head>
        <?php 
            include $root . 'api/common/imports.php';
        ?>
	</head>

	<body class="hold-transition login-page">
		<div class="login-box">
			<div class="login-logo d-flex flex-column justify-content-center align-items-center">
                <img src="<?php echo $system . '/static/img/favicon.png'; ?>" style="height:150px;">
				<h2 class="text-nowrap"><b>Machine Inspection Record</b></h2>
			</div>
			<!-- /.login-logo -->
			<div class="card">
				<div class="card-body login-card-body">
					<p class="login-box-msg"><b>Sign in to start your session</b></p>
                    <?php include $root . 'forms/signin/login.php';?>
				</div>
			</div>
		</div>
		<?php 
			include $root . 'api/common/notification_handler.php';
		?>
	</body>
</html>