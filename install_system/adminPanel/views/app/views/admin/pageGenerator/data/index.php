<use layout="admin" />

<block name="index">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <div>
                <h6 class="m-0 font-weight-bold text-primary">Данные для страницы "<?= $page->name ?>"</h6>
            </div>
            <div>
                <a class="btn btn-primary btn-sm" href="/<?=ADMIN?>/pg/data/create/<?= $page->id ?>">
                <i class="bi bi-plus-circle"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <?php if (count($datas) > 0) : ?>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>name</th>
                                <th>value</th>
                                <th>---</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($datas as $a => $d) : ?>
                                <tr>
                                    <td><?= $d->id ?></td>
                                    <td><?= $d->name ?></td>
                                    <td><?= json_decode($d->data) ?></td>
                                    <td>
                                        <a class="btn btn-primary btn-sm" href="/<?=ADMIN?>/pg/data/edit/<?=$d->id?>"><i class="bi bi-pencil-fill"></i></a>
                                        <a class="btn btn-danger btn-sm" href="/<?=ADMIN?>/pg/data/delete/<?=$d->id?>"><i class="bi bi-trash3-fill"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                Данных нет
            <?php endif; ?>
        </div>
    </div>
</block>