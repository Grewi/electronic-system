<use layout="index" />

<block name="index">
    <div class="container">
        <div class="row">
            <div class="col-md-3 d-none d-md-block">

                <?php if ($neighboringCategory && count($neighboringCategory) > 0) : ?>
                    <div class="my-3">
                        <h5>Категории раздела</h5>
                    </div>
                    <div class="list-group">
                        <?php foreach ($neighboringCategory as $i) : ?>
                            <?php $active = $i->id == $category->id ? 'list-group-item-secondary' : ''; ?>
                            <?php if ($i->id == $category->id) : ?>
                                <li class="list-group-item <?= $active ?>">
                                    <strong><?= $i->name ?></strong>
                                    <?php if ($rootCategory && count($rootCategory) > 0) : ?>
                                        <ul class="list-group list-group-flush">
                                            <?php foreach ($rootCategory as $ii) : ?>
                                                    <a class="list-group-item" href="/blogs/category/<?= $ii->url ?>"><?= $ii->name ?></a>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </li>
                            <?php else : ?>
                                    <a class="list-group-item <?= $active ?>" href="/blogs/category/<?= $i->url ?>"><?= $i->name ?></a>
                            <?php endif; ?>

                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            </div>
            <div class="col-md-9">
                <include file="include/bc" />
                <div class="card mb-3">
                    <div class="card-body">
                        <h1><?= $category->name ?></h1>
                    </div>
                </div>
                <div class="row">
                    <?php foreach ($blogs as $a => $blog) : ?>
                        <div class="col-12">
                            <include file="blogs/cardLine" />
                        </div>
                    <?php endforeach; ?>
                </div>
                <include file="include/pagination" />
            </div>
        </div>
    </div>
</block>