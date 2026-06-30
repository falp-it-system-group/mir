<?php 
    $root = $_SERVER['DOCUMENT_ROOT'] . '/mir/';
    include $root . 'api/common/server_date_time.php';
    include $root . 'api/common/consts.php';
    include $root . 'api/common/sessions.php';
?>
<!DOCTYPE html>
<html lang="en">
	<head>
        <?php 
            include $root . 'api/common/imports.php';
        ?>
	</head>

	<body class="hold-transition layout-top-nav accent-primary">
        <div class="wrapper">
            <?php include 'reusable/navigation.php'; ?>
            <div class="content-wrapper">
            </div>
            <?php include 'reusable/footer.php'; ?>
        </div>
		<?php 
			include $root . 'api/common/notification_handler.php';
		?>
	</body>
</html>