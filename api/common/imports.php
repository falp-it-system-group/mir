<?php
    $system = "/mir";
    function import($system) {
        echo <<<HTML
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>MIR | Machine Inspection Record</title>
            <link rel="icon" href="{$system}/static/img/favicon.ico" type="image/x-icon">
            <link rel="stylesheet" href="{$system}/static/css/font.min.css">
            <link rel="stylesheet" href="{$system}/plugins/fontawesome-free/css/all.min.css">
            <link rel="stylesheet" href="{$system}/static/css/adminlte.min.css">
            <link rel="stylesheet" href="{$system}/plugins/sweetalert2/dist/sweetalert2.min.css">
            <link rel="stylesheet" href="{$system}/plugins/apexcharts/3.22.2/css/apexcharts.min.css">

            <style>
                .loader {
                    border: 16px solid #f3f3f3;
                    border-radius: 50%;
                    border-top: 16px solid #536A6D;
                    width: 50px;
                    height: 50px;
                    -webkit-animation: spin 2s linear infinite;
                    animation: spin 2s linear infinite;
                }

                @keyframes spin {
                    0% {
                        transform: rotate(0deg);
                    }

                    100% {
                        transform: rotate(1080deg);
                    }
                }

                .table-sm-custom td, .table-sm-custom th {
                    padding: 0; /* No padding */
                    margin: 0; /* No margin */
                    text-align: center; /* Center the text */
                    vertical-align: middle; /* Center the text vertically */
                    font-size: 0.8rem; /* Make the text smaller */
                }

                .btn-custom {
                    padding: 0.1rem 0.2rem; /* Adjust padding for smaller buttons */
                    font-size: 0.8rem; /* Adjust font size for smaller buttons */
                }
            </style>

            <script src="{$system}/plugins/jquery/dist/jquery.min.js"></script>
            <script type="text/javascript" src="{$system}/plugins/sweetalert2/dist/sweetalert2.min.js"></script>
            <script src="{$system}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
            <script src="{$system}/static/js/adminlte.js"></script>
            <script src="{$system}/plugins/chartjs/package/dist/chart.umd.js"></script>
            <script src="{$system}/plugins/apexcharts/3.22.2/js/apexcharts.min.js"></script>
        HTML;

    }
    import($system);