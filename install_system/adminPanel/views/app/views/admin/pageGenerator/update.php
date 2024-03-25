<use layout="admin" />

<block name="index">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    Редактирование страницы
                </div>
                <div class="card-body">
                    <form method="post">
                        <csrf type="input" name="pageUpdate" />
                        <div class="mb-3">
                            <input type="text" class="form-control <?= $return->class->url ?>" name="url" placeholder="URL" value="<?= $return->data->page->url ?>">
                            <div class="invalid-feedback"><?= $return->error->url ?></div>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control <?= $return->class->view ?>" name="view" placeholder="view" value="<?= $return->data->view ?>">
                            <div class="invalid-feedback"><?= $return->error->view ?></div>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control <?= $return->class->title ?>" name="title" placeholder="title" value="<?=$return->data->title?>">
                            <div class="invalid-feedback"><?= $return->error->title ?></div>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control <?= $return->class->description ?>" name="description" placeholder="description" value="<?= $return->data->description ?>">
                            <div class="invalid-feedback"><?= $error_description ?></div>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control <?= $return->class->name ?>" name="name" placeholder="name" value="<?= $return->data->name ?>">
                            <div class="invalid-feedback"><?= $return->error->name ?></div>
                        </div>
                        <div class="mb-3 form-check">
                            <input id="active" type="checkbox" class="form-check-input" name="active" value="<?=$return->data->active == 1 ? 1 : 0?>" checked>
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