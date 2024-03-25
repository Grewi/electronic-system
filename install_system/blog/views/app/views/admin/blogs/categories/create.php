<use layout="admin" />

<block name="index">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    Новая категория 
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <csrf type="input" name="categoryCreate" />
                        <input name="referal" value="<?= referal_url() ?>" hidden>

                        <div class="mb-3 form-floating">
                            <input type="text" class="form-control <?= $return->class->title ?>" name="title" placeholder="title" value="<?= $return->data->title ?>">
                            <div class="invalid-feedback"><?= $return->error->title ?></div>
                            <label for="">Заголовок</label>
                        </div>
                        <div class="mb-3 form-floating">
                            <input type="text" class="form-control <?= $return->class->description ?>" name="description" placeholder="description" value="<?= $return->data->description ?>">
                            <div class="invalid-feedback"><?= $return->error->description ?></div>
                            <label for="">Описание</label>
                        </div>

                        <div class="mb-3 form-floating">
                            <input type="text" class="form-control <?= $return->class->url ?>" name="url" placeholder="url" value="<?= $return->data->url ?>">
                            <div class="invalid-feedback"><?= $return->error->url ?></div>
                            <label for="">URL</label>
                        </div>

                        <div class="mb-3 form-floating">
                            <input type="text" class="form-control <?= $return->class->name ?>" name="name" placeholder="name" value="<?= $return->data->name ?>">
                            <div class="invalid-feedback"><?= $return->error->name ?></div>
                            <label for="">Наименование</label>
                        </div>

                        <div class="mb-3 form-floating">
                            <select class="form-select" name="sort_post">
                                <option selected></option>
                                <option value="id">id</option>
                                <option value="date_create">Дата создания</option>
                                <option value="sort">Метка сортировки</option>
                            </select>
                            <label for="">Сортировка записей в категории</label>
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