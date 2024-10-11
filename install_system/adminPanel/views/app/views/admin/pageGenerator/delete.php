<use layout="admin" />

<block name="index">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    Удаление Страницы <?= $page->title ?>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <csrf type="input" name="pageDelete" />
                        <input class="btn btn-primary" type="submit" value="Удалить страницу?">
                    </form>
                </div>
            </div>
        </div>
    </div>
</block>