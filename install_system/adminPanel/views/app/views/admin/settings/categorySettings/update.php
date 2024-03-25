<use layout="admin" />

<block name="index">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <?=lang('admin', 'editCategory')?>
                </div>
                <div class="card-body">
                    <form method="post">
                        <csrf type="input" name="editCategory" />
                        
                        <div class="mb-3">
                            <input type="text" class="form-control <?= $return->class->name ?>" name="name" placeholder="name" value="<?= $return->data->name ?>">
                            <div class="invalid-feedback"><?= $return->error->name ?></div>
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