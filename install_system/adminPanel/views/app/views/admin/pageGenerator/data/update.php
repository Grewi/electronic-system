<use layout="admin" />

<block name="index">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    Добавить данные
                </div>
                <div class="card-body">
                    <form method="post">
                        <csrf type="input" name="pgData" />
                        <div class="mb-3">
                            <input type="text" class="form-control <?= $return->class->name ?>" name="name" placeholder="name" value="<?= $return->data->name ?>">
                            <div class="invalid-feedback"><?= $return->error->name ?></div>
                        </div>
                        <div class="mb-3">
                            <select name="type" class="form-select <?= $return->class->type ?>">
                                <option disabled selected>Тип</option>
                                <?php foreach ($listTypeData as $a => $i) : ?>
                                    <option value="<?= $a ?>" <?=$dataPg->type == $a ? 'selected' : ''?>><?= $i ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= $return->error->type ?></div>
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control <?= $return->class->value ?>" name="value" placeholder="value"><?= json_decode($dataPg->data) ?></textarea>
                            <div class="invalid-feedback"><?= $return->error->value ?></div>
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