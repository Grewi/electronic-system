<use layout="admin" />

<block name="index">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <?=lang('admin', 'deleteCategory')?> <?= $setting->name ?>
                </div>
                <div class="card-body">
                    <p><?=lang('admin', 'settingCatDelDesc')?></p>
                    <form action="" method="post">
                        <csrf type="input" name="categoryDelete" />
                        <input class="btn btn-primary" type="submit" value="<?=lang('admin', 'del')?>">
                    </form>
                </div>
            </div>
        </div>
    </div>
</block>