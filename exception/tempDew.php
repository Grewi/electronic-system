<!doctype html>
<html lang="ru">

<head>
    <meta charset="utf-8" />
    <title>503 Service Unavailable</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger mt-3" role="alert">
                    <div><?= localPathFile($message) ?></div>
                    <div>
                        <?= localPathFile($exeption->getFile()) ?>
                        <strong><?= $exeption->getLine() ?></strong>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <table class="table table-striped mt-3">
                    <thead>
                        <tr class="table-secondary">
                            <th>№</th>
                            <th scope="col">file</th>
                            <th scope="col">class</th>
                            <th scope="col">type</th>
                            <th scope="col">function</th>
                            <th scope="col">line</th>
                            <th scope="col">arg</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($exeption->getTrace() as $a => $e) : ?>
                            <tr>
                                <td class="text-muted"><?=$a + 1?></td>
                                <td class="text-primary-emphasis"><?= localPathFile($e['file']) ?></td>
                                <td class="fst-italic text-success"><?= isset($e['class']) ? $e['class'] : '' ?></td>
                                <td><?= isset($e['type']) ? $e['type'] : '' ?></td>
                                <td class="fst-italic text-danger"><?= isset($e['function']) ? $e['function'] : '' ?></td>
                                <td class="fw-bold"><?= isset($e['line']) ? $e['line'] : '' ?></td>
                                <td>
                                    <?php if(isset($e['args'])):?>
                                        <?php foreach($e['args'] as $i) : ?>
                                            <div class="text-muted" style="font-size:0.7em;">
                                                <?=$i?>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>