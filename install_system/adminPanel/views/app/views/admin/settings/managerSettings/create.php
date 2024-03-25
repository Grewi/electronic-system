<use layout="admin" />

<block name="index">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <?=lang('admin', 'addSetting')?>
                </div>
                <div class="card-body">
                    <form method="post">
                        <csrf type="input" name="addSetting" />

                        <div class="mb-3">
                            <select name="setting_category_id" class="form-select <?= $return->class->setting_category_id ?>">
                                <option disabled selected><?=lang('admin', 'categorySeatting')?></option>
                                <?php foreach ($settingCategory as $category) : ?>
                                    <option value="<?= $category->id ?>" <?=$categoryParent->id == $category->id ? 'selected' : ''?>><?= $category->name ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= $return->error->setting_category_id ?></div>
                        </div>

                        <div class="mb-3">
                            <select name="setting_type_id" class="form-select <?= $return->class->setting_type_id ?>">
                                <option disabled selected><?=lang('admin', 'settingType')?></option>
                                <?php foreach ($settingsType as $type) : ?>
                                    <option value="<?= $type->id ?>" <?=$return->data->setting_type_id == $type->id ? 'selected' : ''?>><?= $type->name ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= $return->error->setting_type_id ?></div>
                        </div>
                        
                        <div class="mb-3">
                            <input type="text" class="form-control <?= $return->class->name ?>" name="name" placeholder="name" value="<?= $return->data->name ?>">
                            <div class="invalid-feedback"><?= $return->error->name ?></div>
                        </div>

                        <div class="mb-3">
                            <input type="text" class="form-control <?= $return->class->description ?>" name="description" placeholder="description" value="<?= $return->data->description ?>">
                            <div class="invalid-feedback"><?= $return->error->description ?></div>
                        </div>

                        <div class="mb-3">
                            <input type="text" class="form-control <?= $return->class->value  ?>" name="value" placeholder="value " value="<?= $return->data->value  ?>">
                            <div class="invalid-feedback"><?= $return->error->value  ?></div>
                        </div>

                        <div class="mb-3">
                            <input class="btn btn-primary" type="submit" value="<?=lang('admin', 'save')?>">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</block>