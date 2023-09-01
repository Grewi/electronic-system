<use layout="admin" />

<block name="index">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <?=lang('admin', 'addCategory')?>
                </div>
                <div class="card-body">
                    <form method="post">
                        <csrf type="input" name="addCategory" />
                        
                        <div class="mb-3">
                            <input type="text" class="form-control <?= $class_name ?>" name="name" placeholder="name" value="<?= $name ?>">
                            <div class="invalid-feedback"><?= $error_name ?></div>
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