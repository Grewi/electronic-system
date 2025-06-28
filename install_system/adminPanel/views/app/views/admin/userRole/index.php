<use layout="admin" />

<block name="index">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <div>
                <h6 class="m-0 font-weight-bold text-primary">Пользовательские роли</h6>
            </div>
            <div>
                <a class="btn btn-primary btn-sm" href="/<?=ADMIN?>/roles/create">
                <i class="bi bi-plus-circle"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <?php if (count($roles) > 0) : ?>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>---</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($roles as $a => $role) : ?>
                                <tr>
                                    <td><?= $role->id ?></td>
                                    <td><?= $role->name ?></td>
                                    <td><?= $role->slug ?></td>
                                    <td>
                                    <a class="btn btn-primary btn-sm" href=""><i class="bi bi-pencil-fill"></i></a>
                                        <a class="btn btn-danger btn-sm" href=""><i class="bi bi-trash3-fill"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                Данных нет
            <?php endif; ?>
        </div>
    </div>
</block>