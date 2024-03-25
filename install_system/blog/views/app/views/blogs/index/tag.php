<use layout="index" />

<block name="index">
    <div class="container">
        <div class="row">
            <div class="col-md-2">

            </div>
            <div class="col-md-10">
                <include file="include/bc" />
                <div class="card mb-3">
                    <div class="card-body">
                        <h1><?=$tag->name?></h1>
                    </div>
                </div>
                <div class="row">
                    <?php foreach ($blogs as $blog) : ?>
                        <div class="col-md-4 mb-3">
                            <include file="blogs/card" />
                        </div>
                        <?php if (($a + 1) % 3 == 0) : ?>
                        </div>
                        <div class="row mb-4">
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</block>