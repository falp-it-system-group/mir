<!-- Preloader -->
<div class="preloader flex-column justify-content-center align-items-center bg-white">
	<img class="animation__shake elevation-3 p-1 bg-light" src="<?php echo $system . "/static/img/favicon.png" ?>" alt="Logo"
		height="60" width="60">
	<noscript>
		<br>
		<span>We are facing <strong>Script</strong> issues. Kindly enable <strong>JavaScript</strong>!!!</span>
		<br>
		<span>Call IT Personnel Immediately!!! They will fix it right away.</span>
	</noscript>
</div>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand-md navbar-dark text-light border-bottom-0">
	<a href="" class="navbar-brand ml-2">
		<img src="<?php echo $system . "/static/img/favicon.png" ?>" alt="Logo" class="brand-image img-circle elevation-3 bg-light p-1"
			style="opacity: .8">
		<span class="brand-text font-weight-light text-light">MIR</span>
	</a>

	<button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
		aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse order-3" id="navbarCollapse">
		<!-- Left navbar links -->
		<ul class="navbar-nav">
			<?php if (isset($_SESSION['user']) && $_SESSION['user'] != null) {?>

			<?php if ($_SERVER['REQUEST_URI'] == $system . '/pages/checksheet/') { ?>
			<li class="nav-item"><a class="nav-link active" href="<?php echo $system . '/pages/checksheet/' ?>">Checksheet</a></li>
			<?php } else { ?>
			<li class="nav-item"><a class="nav-link" href="<?php echo $system . '/pages/checksheet/' ?>">Checksheet</a></li>
			<?php } ?>

			<li class="nav-item">
				<a data-toggle="modal" data-target="#logout_modal" class="nav-link"><i class="fas fa-sign-out-alt"></i> Logout</a>
			</li>

			<?php } else { ?>

			<?php if ($_SERVER['REQUEST_URI'] == $system . '/pages/viewer/checksheets/') { ?>
			<li class="nav-item"><a class="nav-link active" href="<?php echo $system . '/pages/viewer/checksheets/' ?>">Checksheets</a></li>
			<?php } else { ?>
			<li class="nav-item"><a class="nav-link" href="<?php echo $system . '/pages/viewer/checksheets/' ?>">Checksheets</a></li>
			<?php } ?>

			<?php } ?>
		</ul>
	</div>

	<!-- Right navbar links -->
	<ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
		<li class="nav-item">
			<a class="nav-link" data-widget="fullscreen" role="button">
				<i class="fas fa-expand-arrows-alt"></i>
			</a>
		</li>
	</ul>
</nav>
<!-- /.navbar -->