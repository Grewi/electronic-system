<use layout="admin" />

<block name="index">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    Удаление тега <?= $return->data->login ?>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <csrf type="input" name="tagDelete" />
                        <input class="btn btn-primary" type="submit" value="Удалить тег?">
                    </form>
                </div>
            </div>
        </div>
    </div>
</block>