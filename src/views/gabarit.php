<!DOCTYPE>
<html>
<head>
    <title><?= $pageTitle ?></title>
    <!--Chargement du CSS de Bootstrap-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="dependancies/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="dependancies/bootstrap/dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/style.css">
    <meta charset="utf-8">
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body class="container-fluid">



<!--contenu de l'application-->
<section class="row">
    <div class="col-md-8 col-md-offset-2 content">

        <?php if (!empty($_SESSION['flash'])) : ?>
            <div class="alert alert-<?= array_keys($_SESSION['flash'])[0] ?>">
                <?= $_SESSION['flash'][array_keys($_SESSION['flash'])[0]] ?>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <?php if (!empty($errors)) : ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error) : ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?= $content ?>
    </div>
</section>

<script src="dependancies/jquery/dist/jquery.min.js"></script>
<script src="dependancies/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="js/admin_panel.js"></script>

</body>
</html>
