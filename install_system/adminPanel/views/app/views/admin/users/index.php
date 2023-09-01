<use layout="admin" />

<block name="index">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <div>
                <h6 class="m-0 font-weight-bold text-primary">пользователи</h6>
            </div>
            <div>
                <a class="btn btn-primary btn-sm" href="/<?=ADMIN?>/user/create">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <?php if (count($users) > 0) : ?>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Role</th>
                                <th>Email</th>
                                <th>login</th>
                                <th>Date</th>
                                <th>---</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $a => $user) : ?>
                                <?php
                                $role = \app\models\user_role::find($user->user_role_id);
                                ?>
                                <tr>
                                    <td><?= $user->id ?></td>
                                    <td><?= $role->name ?></td>
                                    <td><?= $user->email ?></td>
                                    <td><?= $user->login ?></td>
                                    <td><?= eDate($user->date_create) ?></td>
                                    <td>
                                        <a class="btn btn-primary btn-sm" href="/<?=ADMIN?>/user/edit/<?= $user->id ?>"><i class="fa fa-pen"></i></a>
                                        <a class="btm btn-danger btn-sm" href="/<?=ADMIN?>/user/delete/<?= $user->id ?>"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                Пользователей нет
            <?php endif; ?>
        </div>
    </div>
</block>