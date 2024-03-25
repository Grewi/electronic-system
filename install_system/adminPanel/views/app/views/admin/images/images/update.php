<use layout="admin" />

<block name="index">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    Редактировать изображение
                </div>
                <div class="card-body">
                    <form action="" method="post" >
                        <csrf type="input" name="imageEdit" />
                        <input name="referal" value="<?=referal_url()?>" hidden>

                        <div class="mb-3">
                            <img src="/images/thumbnail/icon/<?= $return->data->id ?>.png" alt="...">
                        </div>

                        <div class="mb-3 form-floating">
                            <input class="form-control" type="text" name="name" placeholder="" value="<?=$return->data->name?>">
                            <label for="">Наименование</label>
                        </div>

                        <div class="mb-3 form-floating">
                            <input class="form-control" type="text" name="description" placeholder="" value="<?=$return->data->description?>">
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