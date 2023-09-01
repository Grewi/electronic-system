<use layout="admin" />

<block name="index">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    Создание пользователя
                </div>
                <div class="card-body">
                    <form method="post">
                        <csrf type="input" name="pageCreate" />
                        <div class="mb-3">
                            <input type="text" class="form-control <?= $class_url ?>" name="url" placeholder="URL" value="<?= $url ?>">
                            <div class="invalid-feedback"><?= $error_url ?></div>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control <?= $class_view ?>" name="view" placeholder="view" value="<?= $view ?>">
                            <div class="invalid-feedback"><?= $error_view ?></div>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control <?= $class_title ?>" name="title" placeholder="title">
                            <div class="invalid-feedback"><?= $error_title ?></div>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control <?= $class_description ?>" name="description" placeholder="description" value="<?= $description ?>">
                            <div class="invalid-feedback"><?= $error_description ?></div>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control <?= $class_name ?>" name="name" placeholder="name" value="<?= $name ?>">
                            <div class="invalid-feedback"><?= $error_name ?></div>
                        </div>
                        <div class="mb-3 form-check">
                            <input id="active" type="checkbox" class="form-check-input" name="active" value="1" checked>
                            <label for="active">active</label>
                        </div>
                        <div class="mb-3">
                            <input class="btn btn-primary" type="submit" value="Сохранить">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</block>