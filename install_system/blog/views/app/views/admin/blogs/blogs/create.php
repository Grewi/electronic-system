<use layout="admin" />

<block name="index">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    Новая запись 
                </div>
                <div class="card-body">
                    <form  method="post">
                        <csrf type="input" name="blogCreate" />
                        <!-- <input name="referal" value="<?=referal_url()?>" hidden> -->

                        <div class="mb-3 form-floating">
                            <input type="text" class="form-control <?= $return->class->name ?>" name="name" placeholder="name" value="<?= $return->data->name ?>">
                            <label for="">Наименование <span class="text-danger">*</span></label>
                            <div class="invalid-feedback"><?= $return->error->name ?></div>
                        </div>                        

                        <div class="mb-3 form-floating">
                            <input type="text" class="form-control <?= $return->class->title ?>" name="title" placeholder="title" value="<?= $return->data->title ?>">
                            <label for="">Заголовок страницы</label>
                            <div class="invalid-feedback"><?= $return->error->title ?></div>
                        </div>
                        <div class="mb-3 form-floating">
                            <input type="text" class="form-control <?= $return->class->description ?>" name="description" placeholder="description" value="<?= $return->data->description ?>">
                            <label for="">Описание</label>
                            <div class="invalid-feedback"><?= $return->error->description ?></div>
                        </div>

                        <div class="mb-3 form-floating">
                            <input type="text" class="form-control <?= $return->class->url ?>" name="url" placeholder="url" value="<?= $return->data->url ?>">
                            <label for="">url</label>
                            <div class="invalid-feedback"><?= $return->error->url ?></div>
                        </div>

                        <div class="mb-3">
                            <input class="btn btn-primary" type="submit" value="Далее">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</block>