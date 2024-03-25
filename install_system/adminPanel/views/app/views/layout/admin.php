<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $title ?></title>
    <link href="/adm/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="/adm/bootstrap/icon/bootstrap-icons.css" rel="stylesheet">
    <link href="/adm/style/css/style.css" rel="stylesheet">
    <script src="/adm/scripts/jquery-3.7.1.min.js"></script>
    <script src="/adm/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="/adm/scripts/e.ajax.js"></script>
</head>

<body id="page-top">
    <div class="container-fluid">
        <div class="row">
            <div class="col-auto adm-left-menu">
                <include file="admin/include/leftMenu" />
            </div>
            <div class="col adm-main p-0">

                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <div class="container-fluid d-flex justify-content-between">
                        <div>

                        </div>
                        <div>
                            
                        </div>
                        <ul class="navbar-nav ml-auto">
                            <include file="admin/include/topUserPanel" />
                        </ul>
                    </div>
                </nav>

                <div class="mx-3">
                    <include file="include/bc" />
                    <block name="index" />
                </div>
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; <?= config('globals', 'title'); ?> <?= date('Y'); ?></span>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <div id="modal"></div>
</body>

</html>