<use layout="admin" />

<block name="index">
    <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
            <div>
                <h6 class="m-0 font-weight-bold text-primary"><?=lang('admin', 'settings')?></h6>
            </div>
            <div>
                <a class="btn btn-primary btn-sm" href="/<?=ADMIN?>/settings/category/create">
                <i class="bi bi-plus-circle"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <?php if (count($categories) > 0) : ?>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th><?=lang('admin', 'categorySeatting')?></th>
                                <th>---</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $a => $category) : ?>
                                <?php 
                                ?>
                                <tr>
                                    <td><?= $category->id ?></td>
                                    <td><a href="/<?=ADMIN?>/settings/<?=$category->id?>"><?= $category->name ?></a></td>
                                    <td>
                                        <a class="btn btn-primary btn-sm" href="/<?=ADMIN?>/settings/category/edit/<?= $category->id ?>"><i class="bi bi-pencil-fill"></i></a>
                                        <a class="btn btn-danger btn-sm" href="/<?=ADMIN?>/settings/category/delete/<?= $category->id ?>"><i class="bi bi-trash3-fill"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <div>
                <?=lang('admin', 'noSettings')?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</block>