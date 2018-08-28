<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Free Proxy List</title>
    <link rel="icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="/public/css/app.css">
    <script src="/public/js/app.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <style>
        .main{padding-top:30px;}
        select{padding: 5px;width: 100%;}
    </style>
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
</head>
<body>
<div class="container main">
    <div class="header clearfix">
        <nav>
            <ul class="nav nav-pills pull-right">
                <li role="presentation" class="active"><a href="/">Home</a></li>
                <li role="presentation"><a href="/api">Api</a></li>
            </ul>
        </nav>
        <h3 class="text-muted">Free Proxy List site</h3>
    </div>

    <div class="jumbotron">
        <h1>Digital resistance</h1>
        <p class="lead">Our premium list contains only anonymous proxies (elite + anonymous). It doesn't have a fixed number of proxies. Instead, it is updated every minute to ensure its 90% proxies are working. Moreover, you can choose to only download the HTTPS proxies (supporting surfing HTTPS sites) from the premium proxy list.</p>
        <p><a class="btn btn-lg btn-success" role="button" onclick="alert('TBD');">Sign up today</a></p>
    </div>

    <div class="row marketing">
        <div class="col-lg-12">
            <div id="table-container" style="width: 100%;">
                <div class="table-responsive">

                    <table class="table table-striped table-hover table-bordered" id="table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th id="n0"></th>
                            <th id="n1"></th>
                            <th id="n2"></th>
                            <th id="n3"></th>
                            <th id="n4"></th>
                            <th id="n5"></th>
                            <th id="n6"></th>

                        </tr>


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
                                <td>{{ $proxy->anonymity }}</td>
                                <td>{{ $proxy->speed * 1000 }}</td>
                                <td>{{ $proxy->type }}</td>
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
</body>
</html>
