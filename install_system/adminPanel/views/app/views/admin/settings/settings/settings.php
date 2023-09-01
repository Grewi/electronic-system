<use layout="admin" />

<block name="index">
    <div class="card shadow mb-4">
        <form method="post">
        <div class="card-header py-3 d-flex justify-content-between">
            <div>
                <h6 class="m-0 font-weight-bold text-primary"><?= lang('admin', 'settings') ?></h6>
            </div>
            <div>
                <button type="submit" class="btn btn-primary btn-sm" href="/<?= ADMIN ?>/settings/save">
                    <i class="fa fa-floppy-o" aria-hidden="true"></i>
                </button>
                <a class="btn btn-primary btn-sm" href="/<?=ADMIN?>/settings/manager/create/<?=$category->id?>">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <?php if (count($settings) > 0) : ?>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th><?= lang('admin', 'categorySeatting') ?></th>
                                <th><?= lang('admin', 'valueSetting') ?></th>
                                <th>---</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($settings as $a => $setting) : ?>
                                <?php
                                $type = \app\models\settings_type::find($setting->setting_type_id);
                                ?>
                                <tr>
                                    <td><?= $setting->id ?></td>
                                    <td><?= $setting->name ?></td>
                                    <td>
                                        <?php if ($type->name == 'input') : ?>
                                            <input name="setting[<?=$setting->id?>]" class="form-control" value="<?= $setting->value ?>">
                                        <?php elseif ($type->name == 'checkbox') : ?>
                                            <div class="form-group form-check">
                                                <input name="setting[<?=$setting->id?>]" type="checkbox" class="form-check-input" <?=$setting->value == 1 ? 'checked' : ''?>>
                                                <!-- <label class="form-check-label" for="exampleCheck1">Check me out</label> -->
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                    <a class="btn btn-primary btn-sm" href="/<?=ADMIN?>/settings/manager/edit/<?= $setting->id ?>"><i class="fa fa-pen"></i></a>
                                        <a class="btm btn-danger btn-sm" href="/<?=ADMIN?>/settings/manager/delete/<?= $setting->id ?>"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <div>
                    <?= lang('admin', 'noSettings') ?>
                </div>
            <?php endif; ?>
        </div>
        </form>
    </div>
</block>