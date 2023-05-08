<?php $_SERVER['viewList'][] = 'index'; ?><!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) && (is_string($title) || is_numeric($title) ) ? $title : ""; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</head>

<body>
    <block name="index" />
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Установка</h1>
                <hr>
                <form method="post">
                    <div class="row mb-3">
                        <div class="col-3">
                            <label class="form-label">Публичная директория</label>
                        </div>
                        <div class="col-9">
                            <input type="text" class="form-control" name="public" value="public">
                            <div class="form-text">Директория которая будет доступна по http. Если не требуется, можно отправить пустую строку</div>                            
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-3">
                            <label class="form-label">Тип базы данных</label>
                        </div>
                        <div class="col-9">
                            <select class="form-select" aria-label="Пример выбора по умолчанию" name="database-type">
                                <option value="mysql">mySql</option>
                                <option value="sqlite">sqLite</option>
                                <option value="pgsql">pgSql</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">
                            <label class="form-label">Имя базы данных</label>
                        </div>
                        <div class="col-9">
                            <input type="text" class="form-control" name="database-name" value="">
                            <div class="form-text"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">
                            <label class="form-label">Пользователь базы данных</label>
                        </div>
                        <div class="col-9">
                            <input type="text" class="form-control" name="database-user" value="">
                            <div class="form-text"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">
                            <label class="form-label">Пароль базы данных</label>
                        </div>
                        <div class="col-9">
                            <input type="text" class="form-control" name="database-pass" value="">
                            <div class="form-text"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">
                            <label class="form-label">Host</label>
                        </div>
                        <div class="col-9">
                            <input type="text" class="form-control" name="database-host" value="localhost">
                            <div class="form-text"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">
                            <label class="form-label">Файл (sqLite)</label>
                        </div>
                        <div class="col-9">
                            <input type="text" class="form-control" name="database-file" value="">
                            <div class="form-text"></div>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3 form-check">
                        <input id="table-users" type="checkbox" class="form-check-input" name="table-users" value="1">
                        <label for="table-users" class="form-check-label">Создать таблицу users и sessions</label>
                    </div>
                    <div class="mb-3">
                        <input class="btn btn-primary btn-sm" type="submit" value="продолжить">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>