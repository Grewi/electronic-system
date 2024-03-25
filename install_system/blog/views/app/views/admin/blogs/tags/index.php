<use layout="admin" />

<block name="index">
    <div class="card shadow mb-4 ">
        <div class="card-header py-3 d-flex justify-content-between">
            <div>
                <h6 class="m-0 font-weight-bold text-primary">Теги</h6>
            </div>
            <div>
                <a class="btn btn-primary btn-sm" href="/<?= ADMIN ?>/blogs/tags/create">
                    <i class="bi bi-plus-circle"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <?php if (count($tags) > 0) : ?>
                <div class="table-responsive">
                <form action="/admin/blogs/tag/sort" method="post">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Name</th>
                                <!-- <th>Description</th> -->
                                <th>url</th>
                                <th>title</th>
                                <th>---</th>
                                <th width="100">Sort</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tags as $a => $tag) : ?>
                                <tr>
                                    <td><?= $tag->id ?></td>
                                    <td>
                                        <a href="/<?= ADMIN ?>/blogs/tags/edit/<?= $tag->id ?>"><?= $tag->name ?></a>
                                    </td>
                                    <!-- <td>
                                        <?= $tag->description ?>
                                    </td> -->
                                    <td>
                                        <code class="hljs">
                                            <?= $tag->url ?>
                                        </code>
                                    </td>
                                    <td><?= $tag->title ?></td>
                                    <td>
                                        <a class="btn btn-primary btn-sm" href="/<?= ADMIN ?>/blogs/tags/edit/<?= $tag->id ?>">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <a class="btn btn-danger btn-sm" href="/<?= ADMIN ?>/blogs/tags/delete/<?= $tag->id ?>">
                                            <i class="bi bi-trash3-fill"></i>
                                        </a>
                                    </td>
                                    <td>
                                            <input class="form-control" type="text" name="sort[<?=$tag->id?>]" value="<?= $tag->sort ?>">
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
            <?php else : ?>
                <div>
                    Тегов нет
                </div>
            <?php endif; ?>
        </div>
    </div>
</block>