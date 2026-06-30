<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'bottom-end',
        customClass: {
            popup: 'colored-toast',
        },
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
    })
</script>
<!-- handles notification -->
<?php
if (isset($_SESSION['notification'])) {
	$notification = json_decode($_SESSION['notification'], true);
	echo <<<HTML
	<script>
	    Toast.fire({
		    icon: "{$notification['icon']}",
		    title: "{$notification['text']}",
	    })
	</script>
	HTML;
	$_SESSION['notification'] = null;
}
?>