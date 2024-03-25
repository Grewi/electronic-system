<div class="card mb-3">
    <div class="row g-0">
        <div class="col-sm-3 d-none d-sm-block">
            <?php if ($blog->image_id) : ?>
                <a class="" href="/blogs/<?= $blog->url ?>" class="mt-4">
                    <img src="/images/thumbnail/mini/<?= $blog->image_id ?>.png" class="img-fluid rounded-start">
                </a>
            <?php endif; ?>
        </div>
        <div class="col-sm-9">
            <div class="card-header">
                <?php 
                $category = \app\models\blogs_categories::find($blog->category_id);
                 ?>
                    <a href="/blogs/category/<?= $category->url ?>"><?= $category->name ?></a>
            </div>
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-4 d-block d-sm-none">
                        <?php if ($blog->image_id) : ?>
                            <a class="" href="/blogs/<?= $blog->url ?>" class="">
                                <img src="/images/thumbnail/mini/<?= $blog->image_id ?>.png" class="img-fluid ">
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="col-8 col-sm-12 px-3">
                        <h5 class="card-title"><a class="text-primary" href="/blogs/<?= $blog->url ?>"><?= $blog->name ?></a></h5>
                        <p class="card-text"><?= $blog->description ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between">
            <div>
                <i class="bi bi-calendar3"></i> <?= eDate($blog->date_create) ?>
            </div>
            <div style="font-size:0.8em">
            <?php 
            $tags = \app\models\blog_tag::where('blog_id', $blog->id)->all();
            ?>
                <?php foreach ($tags as $t) : ?>
                    <?php 
                        $tag = \app\models\blogs_tags::find($t->tag_id);    
                    ?>
                    <span class="text-muted"><a href="/blogs/tag/<?= $tag->url ?>"><i class="bi bi-tag-fill"></i> <?= $tag->name ?></a></span>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>