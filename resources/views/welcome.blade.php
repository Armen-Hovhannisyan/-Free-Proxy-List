<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Free Proxy List</title>
    <link rel="icon" href="/favicon.ico" type="image/x-icon"/>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="{{ asset('js/dataTables/dataTables.min.js') }}" defer></script>
    <script src="{{ asset('js/dataTables/bootstrap4.min.js') }}" defer></script>

    <style>
        .main {
            padding-top: 30px;
        }

        select {
            padding: 5px;
            width: 100%;
        }
    </style>

</head>
<body>
<div class="container main">
    <div class="header clearfix">
        <nav>
            <ul class="nav nav-pills pull-right">
                <li role="presentation" class="active"><a class=" btn btn-lg" role="button" href="/">Home</a></li>
                <li role="presentation"><a class="btn btn-lg" role="button" href="/api">Api</a></li>
                <li role="presentation"><a class="btn btn-lg" role="button" href="/add">add</a></li>
                <li role="presentation"><a class="btn btn-lg" role="button" href="/check">check</a></li>
            </ul>
        </nav>
        <h3 class="text-muted">Free Proxy List site</h3>
    </div>


    <div class="row marketing">
        <div class="col-lg-12">
            <div id="table-container" style="width: 100%;">
                <div class="table-responsive">

                    <table class="table table-striped table-hover table-bordered" id="table" cellspacing="0"
                           width="100%">
                        <thead>


                        <tr>
                            <th>IP</th>
                            <th>Port</th>
                            <th>Country</th>
                            <th>Anonymity</th>
                            <th>Speed, ms</th>
                            <th>Type</th>
                            <th>Last Checked</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>IP</th>
                            <th>Port</th>
                            <th>Country</th>
                            <th>Anonymity</th>
                            <th>Speed, ms</th>
                            <th>Type</th>
                            <th>Last Checked</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach ($proxies as $proxy)
                            <tr>
                                <td>{{ $proxy->ip }}</td>
                                <td>{{ $proxy->port }}</td>
                                <td>{{ $proxy->country }}</td>
                                <td><?= ($proxy->anonymity > 0) ? "Transparent" : "Anonymous"?></td>
                                <td>{{ $proxy->speed * 1000 }}</td>
                                <td>
                                    @if($proxy->type ==1)
                                        HTTP

                                    @elseif($proxy->type ==2)
                                        HTTPS
                                    @elseif($proxy->type ==3)
                                        SOCKSS
                                    @elseif($proxy->type ==4)
                                        HTTP/HTTPS
                                    @endIf
                                </td>
                                <td>{{ $proxy->updated_at }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>

            </div>

            <footer class="footer">
                <p>&copy; 2018 Proxy, Inc.</p>
            </footer>

        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#table').DataTable({
            responcive: true,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "pageLength": 20,
            "order": [
                [4, "asc"]
            ],
            initComplete: function () {
                this.api().columns().every(function (index) {
                    var column = this;
                    var select = $('<select><option value="">Select...</option></select>')
                        .appendTo($('#n' + index) /*$(column.footer()).empty()*/)
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });
                    column.data().unique().sort() /*(function (a,b) { a = parseFloat(a); b = parseFloat(b); return b - a; })*/.each(function (d, j) {
                        select.append('<option value="' + d + '">' + d + '</option>')
                    });
                });
            }
        });
    });
</script>
</body>
</html>
