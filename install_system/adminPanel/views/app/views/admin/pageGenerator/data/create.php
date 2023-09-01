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
                            <input type="text" class="form-control <?= $class_name ?>" name="name" placeholder="name" value="<?= $name ?>">
                            <div class="invalid-feedback"><?= $error_name ?></div>
                        </div>
                        <div class="mb-3">
                            <select name="type" class="form-select <?= $class_type ?>">
                                <option disabled selected>Тип</option>
                                <?php foreach ($listTypeData as $a => $i) : ?>
                                    <option value="<?= $a ?>"><?= $i ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= $error_type ?></div>
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control <?= $class_value ?>" name="value" placeholder="value"><?= $value ?></textarea>
                            <div class="invalid-feedback"><?= $error_value ?></div>
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