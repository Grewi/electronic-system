<use layout="admin" />

<block name="index">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <?=lang('admin', 'editSetting')?>
                </div>
                <div class="card-body">
                    <form method="post">
                        <csrf type="input" name="editSetting" />

                        <div class="mb-3">
                            <select name="setting_category_id" class="form-select <?= $class_setting_category_id ?>">
                                <option disabled selected><?=lang('admin', 'categorySeatting')?></option>
                                <?php foreach ($settingCategory as $category) : ?>
                                    <option value="<?= $category->id ?>" <?=$setting->setting_category_id == $category->id ? 'selected' : ''?>><?= $category->name ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= $error_setting_category_id ?></div>
                        </div>

                        <div class="mb-3">
                            <select name="setting_type_id" class="form-select <?= $class_setting_type_id ?>">
                                <option disabled selected><?=lang('admin', 'categorySeatting')?></option>
                                <?php foreach ($settingsType as $type) : ?>
                                    <option value="<?= $type->id ?>" <?=$setting->setting_type_id == $type->id ? 'selected' : ''?>><?= $type->name ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= $error_setting_type_id ?></div>
                        </div>
                        
                        <div class="mb-3">
                            <input type="text" class="form-control <?= $class_name ?>" name="name" placeholder="name" value="<?= $setting->name ?>">
                            <div class="invalid-feedback"><?= $error_name ?></div>
                        </div>

                        <div class="mb-3">
                            <input type="text" class="form-control <?= $class_description ?>" name="description" placeholder="description" value="<?= $setting->description ?>">
                            <div class="invalid-feedback"><?= $error_description ?></div>
                        </div>

                        <div class="mb-3">
                            <input type="text" class="form-control <?= $class_value  ?>" name="value" placeholder="value " value="<?= $setting->value  ?>">
                            <div class="invalid-feedback"><?= $error_value  ?></div>
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