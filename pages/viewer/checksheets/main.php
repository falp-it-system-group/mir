<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="row mb-2 ml-1 mr-1">
        <div class="col-sm-6">
            <h1 class="m-0"> Machine Inspection Record Checksheets</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo $system . "/pages/checksheet" ?>">MIR</a></li>
                <li class="breadcrumb-item active">Checksheets</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="card card-gray-dark card-outline">
            <div class="card-header">
                <h3 class="card-title">Checksheets Table</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="maximize">
                        <i class="fas fa-expand"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form id="checksheets_search_form">
                    <div class="row mb-2">
                        <div class="col-sm-3">
                            <label>Checksheet Date Time From</label><label style="color: red;">*</label>
                            <input type="datetime-local" class="form-control" id="date_time_from_search" required>
                        </div>
                        <div class="col-sm-3">
                            <label>Checksheet Date Time To</label><label style="color: red;">*</label>
                            <input type="datetime-local" class="form-control" id="date_time_to_search" required>
                        </div>
                        <div class="col-3">
                            <label>Checksheet Type</label><label style="color: red;">*</label>
                            <select class="form-control" name="opt" id="checksheet_type_opt" required></select>
                        </div>
                        <div class="col-sm-3">
                            <label>Car Model</label>
                            <input type="text" class="form-control" id="car_model_search" autocomplete="off" maxlength="255">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-3">
                            <label>Machine No.</label>
                            <input type="text" class="form-control" id="machine_no_search" autocomplete="off" maxlength="255">
                        </div>
                        <div class="col-sm-3">
                            <label>Equipment No.</label>
                            <input type="text" class="form-control" id="equipment_no_search" autocomplete="off" maxlength="255">
                        </div>
                        <div class="col-sm-3">
                            <label>&nbsp;</label>
                            <button type="button" class="btn btn-secondary btn-block" onclick="export_checksheets('checksheetsTable')"><i class="fas fa-download"></i> Export</button>
                        </div>
                        <div class="col-sm-3">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn bg-primary btn-block"><i class="fas fa-search"></i> Search</button>
                        </div>
                    </div>
                </form>
                <div class="row mb-2">
                    <div class="col-sm-2">
                    <span id="count_view"></span>
                    </div>
                </div>
                <div id="checksheetsTableRes" class="table-responsive"
                    style="max-height: 500px; overflow: auto; display:inline-block;">
                    <table id="checksheetsTable" class="table table-sm table-sm-custom table-bordered table-head-fixed table-foot-fixed text-nowrap table-hover">
                        <thead id="checksheetsColumns" style="text-align: center;"></thead>
                        <tbody id="checksheetsData" style="text-align: center;"></tbody>
                    </table>
                </div>
            </div>
        </div>
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

    document.getElementById('checksheets_search_form').addEventListener('submit', e => {
        e.preventDefault();
        get_checksheets();
    });

    const get_checksheets = () => {
        let date_time_from = document.getElementById("date_time_from_search").value;
        let date_time_to = document.getElementById("date_time_to_search").value;
        let document_no = document.getElementById("checksheet_type_opt").value;
        let car_model = document.getElementById("car_model_search").value;
        let machine_no = document.getElementById("machine_no_search").value;
        let equipment_no = document.getElementById("equipment_no_search").value;

        document.getElementById("checksheetsColumns").innerHTML = '';

        var loading = `<tr id="loading"><td style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
        document.getElementById("checksheetsData").innerHTML = loading;

        $.ajax({
            url: '<?php echo $system; ?>/api/checksheet/get_checksheets.php',
            type: 'GET',
            cache: false,
            data: {
                date_time_from: date_time_from,
                date_time_to: date_time_to,
                document_no: document_no, 
                car_model: car_model,
                machine_no: machine_no,
                equipment_no: equipment_no
            },
            success: function (response) {
                if (response.error) {
                    // Handle error from the PHP response
                    document.getElementById("checksheetsData").innerHTML = `<tr><td style="text-align:center;">${response.error}</td></tr>`;
                } else {
                    document.getElementById("checksheetsData").innerHTML = '';

                    const symbols = ['', '◯', '△', 'X', 'N/A'];
                    const columns_except = ['id', 'revision_no'];

                    const columns = response.columns;
                    console.log(columns);
                    
                    // Create table header
                    const header = columns.map(col => `<th>${col}</th>`).join('');
                    document.getElementById("checksheetsColumns").insertAdjacentHTML('beforeend', header);

                    // Create table body
                    const rows = response.data.map(row => {
                        const cells = columns.map(col => {
                            let value = row[col];

                            // Convert only numeric values 1-4
                            if ([1, 2, 3, 4].includes(Number(value)) && !columns_except.includes(col)) {
                                value = symbols[Number(value)];
                            }

                            return `<td>${value ?? ''}</td>`;
                        }).join('');

                        return `<tr>${cells}</tr>`;
                    }).join('');
                    document.getElementById("checksheetsData").insertAdjacentHTML('beforeend', rows);

                    sessionStorage.setItem('mir_chksht_date_time_from_search', date_time_from);
                    sessionStorage.setItem('mir_chksht_date_time_to_search', date_time_to);
                    sessionStorage.setItem('mir_chksht_document_no_search', document_no);
                }
                let table_rows = response.data.length;
                document.getElementById("count_view").innerHTML = "Total: " + table_rows;
            },
            error: function () {
                document.getElementById("checksheetsData").innerHTML = `<tr><td style="text-align:center;">An error occurred. Please try again.</td></tr>`;
            }
        });
    }

    const export_checksheets = (table_id, separator = ',') => {
		let date_time_from = sessionStorage.getItem('mir_chksht_date_time_from_search');
		let date_time_to = sessionStorage.getItem('mir_chksht_date_time_to_search');
        let document_no = sessionStorage.getItem('mir_chksht_document_no_search');

        // Select rows from table_id
        var rows = document.querySelectorAll('table#' + table_id + ' tr');

        // Construct csv
        var csv = [];
        for (var i = 0; i < rows.length; i++) {
            var row = [], cols = rows[i].querySelectorAll('td, th');
            for (var j = 0; j < cols.length; j++) {
                var data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, '').replace(/(\s\s)/gm, ' ')
                data = data.replace(/"/g, '""');
                // Push escaped string
                row.push('"' + data + '"');
            }
            csv.push(row.join(separator));
        }

        var csv_string = csv.join('\n');

        // Download it
        var filename = 'MIR_Chechsheets';
		if (document_no) {
			filename += '_' + document_no;
		}
		
		date_time_from = new Date(date_time_from);
		var date = date_time_from.toISOString().split('T')[0];
		var time = date_time_from.toTimeString().split(' ')[0];
		date_time_from = `${date}_${time}`;

		date_time_to = new Date(date_time_to);
		var date = date_time_to.toISOString().split('T')[0];
		var time = date_time_to.toTimeString().split(' ')[0];
		date_time_to = `${date}_${time}`;

		filename += '_' + date_time_from + '_to_' + date_time_to + '.csv';
        var link = document.createElement('a');
        link.style.display = 'none';
        link.setAttribute('target', '_blank');
        link.setAttribute('href', 'data:text/csv;charset=utf-8,%EF%BB%BF' + encodeURIComponent(csv_string));
        link.setAttribute('download', filename);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>