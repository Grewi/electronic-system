<use layout="admin" />

<block name="index">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    Загрузить изображение
                </div>
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <csrf type="input" name="imageCreate" />
                        <input name="referal" value="<?=referal_url()?>" hidden>

                        <div class="mb-3">
                            <label for="formFile" class="form-label">Добавить изображение</label>
                            <input class="form-control" type="file" name="image">
                        </div>

                        <div class="mb-3 form-floating">
                            <input class="form-control" type="text" name="name" placeholder="">
                            <label for="">Наименование</label>
                        </div>

                        <div class="mb-3 form-floating">
                            <input class="form-control" type="text" name="description" placeholder="">
                            <label for="">Описание</label>
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