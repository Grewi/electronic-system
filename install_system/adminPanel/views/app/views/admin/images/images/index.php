<use layout="admin" />

<block name="index">
    <div class="card shadow mb-4 ">
        <div class="card-header py-3 d-flex justify-content-between">
            <div>
                <h6 class="m-0 font-weight-bold text-primary">Изображения</h6>
            </div>
            <div>
                <a class="btn btn-primary btn-sm" href="/<?= ADMIN ?>/images/create">
                    <i class="bi bi-plus-circle"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <?php if (count($images) > 0) : ?>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Img</th>
                                <th>url</th>
                                <th>Name / Description</th>
                                <th>---</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($images as $a => $image) : ?>
                                <tr>
                                    <td><?= $image->id ?></td>
                                    <td>
                                        <a href="/<?= ADMIN ?>/images/edit/<?= $image->id ?>">
                                            <img src="/images/thumbnail/icon/<?= $image->id ?>.png" alt="...">
                                        </a>
                                    </td>
                                    <td>
                                        <?php $imageSize = \app\models\image_size::all(); ?>
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="img_tab<?= $image->id ?>" data-bs-toggle="tab" data-bs-target="#img_tab_pane<?= $image->id ?>" type="button" role="tab" aria-controls="img_tab_pane" aria-selected="true">Оригинал</button>
                                            </li>
                                            <?php foreach ($imageSize as $size) :  ?>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="img_tab<?= $image->id ?><?= $size->id ?>" data-bs-toggle="tab" data-bs-target="#img_tab_pane<?= $image->id ?><?= $size->id ?>" type="button" role="tab" aria-controls="img_tab_pane" aria-selected="true"><?= $size->name ?></button>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>

                                        <div class="tab-content">
                                            <div class="tab-pane fade show active" id="img_tab_pane<?= $image->id ?>" role="tabpanel" aria-labelledby="img_tab<?= $image->id ?>" tabindex="0">
                                                <code class="hljs"><?= $image->url ?></code>
                                            </div>
                                            <?php foreach ($imageSize as $size) :  ?>
                                                <div class="tab-pane fade " id="img_tab_pane<?= $image->id ?><?= $size->id ?>" role="tabpanel" aria-labelledby="img_tab<?= $image->id ?><?= $size->id ?>" tabindex="0">
                                                    <code class="hljs">/images/thumbnail/<?= $size->slug ?>/<?= $image->id ?>.png</code>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>




                                    </td>
                                    <td>
                                        <?= $image->name ?>
                                        <?= $image->description ?>
                                    </td>
                                    <td>
                                        <a class="btn btn-primary btn-sm" href="/<?= ADMIN ?>/images/edit/<?= $image->id ?>">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <a class="btn btn-danger btn-sm" href="/<?= ADMIN ?>/images/delete/<?= $image->id ?>">
                                            <i class="bi bi-trash3-fill"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <div>
                    Изображений нет
                </div>
            <?php endif; ?>
        </div>
    </div>
</block>