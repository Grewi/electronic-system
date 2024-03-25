<div class="card h-100">
    <?php if ($blog->image_id) : ?>
        <a href="/blogs/<?= $blog->url ?>" class="mt-4">
            <img src="/images/thumbnail/mini/<?= $blog->image_id ?>.png" class="card-img-top" alt="...">
        </a>
    <?php endif; ?>
    <!-- <div class="card-img-overlay p-0" style="bottom:auto;">
        <div class="p-1 bg-white">
            <?php
            $category = \app\models\blogs_categories::find($blog->category_id);
            ?>
            <a href="/blogs/category/<?= $category->url ?>"><?= $category->name ?></a>
        </div>
    </div> -->
    <div class="card-body">

        <h5 class="card-title"><a href="/blogs/<?= $blog->url ?>"><?= $blog->name ?></a></h5>

        <div>
            <?php
            $tags = \app\models\blog_tag::where('blog_id', $blog->id)->all();
            ?>
            <?php foreach ($tags as $t) : ?>
                <?php
                $tag = \app\models\blogs_tags::find($t->tag_id);
                ?>
                <span><a href="/blogs/tag/<?= $tag->url ?>"><i class="bi bi-tag-fill"></i> <?= $tag->name ?></a></span>
            <?php endforeach; ?>
        </div>
        <p class="card-text"><?= $blog->description ?></p>
    </div>
</div>