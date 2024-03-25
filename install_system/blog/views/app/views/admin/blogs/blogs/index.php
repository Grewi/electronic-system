<use layout="admin" />

<block name="index">
    <div class="card shadow mb-4 ">
        <div class="card-header py-3 d-flex justify-content-between">
            <div>
                <h6 class="m-0 font-weight-bold text-primary">Записи </h6>
            </div>
            <div>
                <a class="btn btn-primary btn-sm" href="/<?= ADMIN ?>/blogs/create">
                    <i class="bi bi-plus-circle"></i>
                </a>
            </div>
        </div>

        <div class="card-body">
        <div class="mb-3">
            <?php foreach($parents as $parent): ?>
                <a class="btn btn-sm btn-secondary" href="/admin/blogs/<?=$parent->id?>"><?=$parent->name?></a>
            <?php endforeach; ?>
        </div>            
            <?php if (count($blogs) > 0) : ?>
                <div class="table-responsive">
                    <form action="/admin/blogs/sort" method="post">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Name</th>
                                    <th>---</th>
                                    <th width="100">Sort</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($blogs as $a => $blog) : ?>
                                    <tr>
                                        <td><?= $blog->id ?></td>
                                        <td>
                                            <a href="/<?= ADMIN ?>/blogs/edit/<?= $blog->id ?>"><?= $blog->name ?></a>
                                            <div>
                                                <?php
                                                $bcp = [];
                                                if ($blog->category_id) {
                                                    $bc = \app\models\blogs_categories::find($blog->category_id);
                                                    $bcp = \app\models\blogs_categories::bc($bc->id, true);
                                                }
                                                ?>
                                                <nav aria-label="breadcrumb">
                                                    <ol class="breadcrumb">
                                                        <?php foreach ($bcp as $i) : ?>
                                                            <li class="breadcrumb-item"><a class="text-secondary" href="<?= '/admin/blogs/' . $i->id ?>"><?= $i->name; ?></a></li>
                                                        <?php endforeach; ?>
                                                    </ol>
                                                </nav>
                                            </div>
                                        </td>
                                        <td>
                                            <a class="btn btn-primary btn-sm" href="/<?= ADMIN ?>/blogs/edit/<?= $blog->id ?>">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm" href="/<?= ADMIN ?>/blogs/delete/<?= $blog->id ?>">
                                                <i class="bi bi-trash3-fill"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="sort[<?= $blog->id ?>]" value="<?= $blog->sort ?>">
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div class="mt-3">
                            <input class="btn btn-sm btn-primary" type="submit" value="Сохранить">
                        </div>
                    </form>
                </div>
                <include file="include/pagination" />
            <?php else : ?>
                <div>
                    Записей нет
                </div>
            <?php endif; ?>
        </div>
    </div>
</block>