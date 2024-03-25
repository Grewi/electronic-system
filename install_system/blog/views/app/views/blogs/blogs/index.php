<use layout="index" />

<block name="index">
    <div class="container">
        <div class="row">
            <div class="col-md-3 d-none d-md-block">
                <h5 class="mt-3">Категории</h5>
                <?php
                function categoriesTree($arr)
                {
                    $str = '<div class="list-group">';
                    foreach ($arr as $i) {
                        // $active = $i->id == $blog->category_id ? 'list-group-item-secondary' : '';
                        $str .= '<a class="list-group-item " href="/blogs/category/' . $i->url . '">' . $i->name . '</a>';
                        if ($i->children) {
                            $str .= categoriesTree($i->children);
                        }
                    }
                    $str .= '</div>';
                    return $str;
                }
                ?>
                <?= categoriesTree($rootCategory); ?>

                <div class="my-3">
                    <h5>Статьи в категоии</h5>
                </div>
                <div class="list-group">
                    <?php foreach ($postsCategory as $i) : ?>
                        <a class="list-group-item" href="/blogs/<?= $i->url ?>"><?= $i->name ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-md-9">
                <include file="include/bc" />

                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <?php if ($blog->image_id) : ?>
                                <?php $img = \app\models\images::find($blog->image_id); ?>
                                <img src="/images/thumbnail/mini/<?= $blog->image_id ?>.png" class="img-fluid rounded-start" alt="<?= $img->name ?>">
                            <?php endif; ?>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h1><?= $blog->name ?></h1>
                                <div class="text-muted"><?= $blog->description ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-body-secondary">
                        <i class="bi bi-calendar3"></i> <?= eDateLang($blog->date_create) ?>
                    </div>
                </div>

                <div>
                    <?= htmlspecialchars_decode($blog->content) ?>
                </div>
            </div>
        </div>
    </div>
</block>