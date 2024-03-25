<use layout="admin" />

<block name="index">
<div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    Удаление изображение <?= $image->name ?>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <csrf type="input" name="imageDel" />
                        <input name="referal" value="<?=$referal?>" hidden>
                        <input class="btn btn-primary" type="submit" value="Удалить изображение?">
                    </form>
                </div>
            </div>
        </div>
    </div>
</block>