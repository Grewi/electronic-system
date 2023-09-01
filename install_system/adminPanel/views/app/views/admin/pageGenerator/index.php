<use layout="admin" />

<block name="index">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <div>
                <h6 class="m-0 font-weight-bold text-primary">Страницы</h6>
            </div>
            <div>
                <a class="btn btn-primary btn-sm" href="/<?=ADMIN?>/pg/create">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <?php if (count($pages) > 0) : ?>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Url</th>
                                <th>View</th>
                                <th>Title</th>
                                <th>Date</th>
                                <th>---</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pages as $a => $page) : ?>
                                <tr>
                                    <td><?= $page->id ?></td>
                                    <td><?= $page->url ?></td>
                                    <td><?= $page->view ?></td>
                                    <td><?= $page->title ?></td>
                                    <td><?= eDate($page->date_create) ?></td>
                                    <td>
                                        <a class="btn btn-primary btn-sm" href="/<?=ADMIN?>/pg/edit/<?=$page->id?>"><i class="fa fa-pen"></i></a>
                                        <a class="btm btn-danger btn-sm" href="/<?=ADMIN?>/pg/delete/<?=$page->id?>"><i class="fa fa-trash"></i></a>
                                        <a class="btm btn-success btn-sm" href="/<?=ADMIN?>/pg/data/<?= $page->id ?>"><i class="fa fa-wrench"></i></a>
                                        <a class="btm btn-secondary btn-sm" href="/<?= $page->url?>" target="_blank">
                                            <i class="fa fa-link"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                Страниц нет
            <?php endif; ?>
        </div>
    </div>
</block>