<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="row mb-2 ml-1 mr-1">
        <div class="col-sm-6">
            <h1 class="m-0"> Machine Inspection Record Checksheet</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo $system . "/pages/checksheet" ?>">MIR</a></li>
                <li class="breadcrumb-item active">Checksheet</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content d-flex flex-row justify-content-center">
    <div class="" style="width:85%;">
        <form id="mir_checksheet_form" class="mb-2">
            <button type="submit" class="btn btn-block btn-success">Submit Checksheet</button>
        </form>
    </div>
</div>

<script type="text/javascript">
    // DOMContentLoaded function
    document.addEventListener("DOMContentLoaded", () => {
        get_checksheet_template();
    });

    const get_checksheet_template = () => {
        $.ajax({
            url: '<?php echo $system; ?>/api/checksheet/get_checksheet_template.php',
            type: 'GET',
            cache: false,
            success: function (response) {
                document.getElementById("mir_checksheet_form").insertAdjacentHTML('afterbegin', response);
            }
        });
    }
</script>