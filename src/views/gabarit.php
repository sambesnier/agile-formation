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

<!-- navigation principale-->
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <!-- brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" >Cyber Café</a>
        </div>

        <!-- collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">

                <li><a href="index.php?controller=accueil">Accueil</a></li>

            </ul>

            <?php if (!empty($_SESSION['user'])) : ?>
            <ul class="nav navbar-nav navbar-right">
                <?php if (!empty($_SESSION['user']) && $_SESSION['user']['role'] == "ADMIN") : ?>
                    <li><a href="index.php?controller=adminHome">Admin</a></li>
                <?php endif; ?>
                <li><a href="index.php?controller=contact">Contact</a></li>
                <li><a href="index.php?controller=computerHome">Réservation</a></li>
                <li><a href="index.php?controller=logout">Déconnexion</a></li>
            </ul>
            <?php endif; ?>
            <?php if (empty($_SESSION['user'])) : ?>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="index.php?controller=contact">Contact</a></li>
                    <li><a href="index.php?controller=inscription">Inscription</a></li>
                    <li><a href="index.php?controller=connexion">Connexion</a></li>
                </ul>
            <?php endif; ?>

        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

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
