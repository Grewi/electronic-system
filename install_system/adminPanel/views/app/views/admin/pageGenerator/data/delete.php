<use layout="admin" />

<block name="index">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    Удаление данных
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <csrf type="input" name="dataDelete" />
                        <input class="btn btn-primary" type="submit" value="Удалить данные?">
                    </form>
                </div>
            </div>
        </div>
    </div>
</block>