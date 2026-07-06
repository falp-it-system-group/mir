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
        <div class="row mb-2">
            <div class="col-6">
                <label>Checksheet Type</label>
                <select class="form-control" name="opt" id="checksheet_type_opt" onchange="get_checksheet_template()" required></select>
            </div>
        </div>
        <form id="mir_checksheet_form" class="mb-2">
            <button type="submit" class="btn btn-block btn-success" id="btn_submit_checksheet" disabled>Submit Checksheet</button>
        </form>
    </div>
</div>

<script type="text/javascript">
    // DOMContentLoaded function
    document.addEventListener("DOMContentLoaded", () => {
        get_checksheet_latest_type();
    });

    // Global Variables
    let document_no = '';

    const get_checksheet_latest_type = () => {
        $.ajax({
            url: '<?php echo $system; ?>/api/checksheet/get_checksheet_latest_type.php',
            type: 'GET',
            cache: false,
            success: function (response) {
                if (response.error) {
                    // Handle error from the PHP response
                    document.getElementById("checksheet_type_opt").innerHTML = `<option value="" selected disabled>${response.error}</option>`;
                } else {
                    let default_opt = `<option value="" selected disabled>Select Checksheet Type</option>`;
                    const rows = response.map((row, index) => {
                        return `<option value="${row.documentNo}">${row.documentNo} - ${row.documentName}</option>`;
                    }).join('');
                    document.getElementById("checksheet_type_opt").innerHTML = default_opt + rows;
                }
            },
            error: function () {
                document.getElementById("checksheet_type_opt").innerHTML = `<option value="" selected disabled>An error occurred. Please try again.</option>`;
            }
        });
    }

    const get_checksheet_template = () => {
        let document_no_opt = document.getElementById("checksheet_type_opt").value;
        $.ajax({
            url: '<?php echo $system; ?>/api/checksheet/get_checksheet_template.php',
            type: 'GET',
            cache: false,
            data: {
                document_no: document_no_opt
            },
            success: function (response) {
                document.getElementById("mir_checksheet_form").insertAdjacentHTML('afterbegin', response);
                document_no = document_no_opt;
                document.getElementById("btn_submit_checksheet").disabled = false;
                document.getElementById("checksheet_type_opt").disabled = true;
            }
        });
    }
</script>