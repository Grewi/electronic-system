<use layout="index" />

<block name="index">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="my-3">
                    <h5>Категории</h5>
                </div>
                <div class="list-group">
                    <?php foreach ($rootCategory as $i) : ?>
                        <a class="list-group-item" href="/blogs/category/<?= $i->url ?>"><?= $i->name ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-md-9">
                <include file="include/bc" />
                <div class="row">
                    <?php foreach ($blogs as $blog) : ?>
                        <div class="col-12">
                            <include file="blogs/cardLine" />
                        </div>
                    <?php endforeach; ?>
                </div>
                <include file="include/pagination" />
            </div>
        </div>
</block>