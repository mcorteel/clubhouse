<?php

ini_set('display_errors', '1');
error_reporting(E_ALL);

session_start(array('cookie_lifetime' => 2592000));

$request = $_GET['request'];

$routes = include 'config/routes.php';

function dashesToCamelCase($string, $capitalizeFirstCharacter = false) {
    return preg_replace_callback("/_[a-zA-Z]/", 'removeDashAndCapitalize', $string);
}

function removeDashAndCapitalize($matches) {
    return strtoupper($matches[0][1]);
}

$content = null;
$controller = null;
try {
    foreach($routes as $route => $controller) {
        $regex = '/^' . $route . '$/';
        if(preg_match($regex, $request, $matches) === 1) {
            array_shift($matches);
            
            list($file, $method) = explode('/', $controller);
            
            include_once('controller/' . $file . '.php');
            
            $class = dashesToCamelCase($file, true) . 'Controller';
            
            $controller = new $class();
            
            if(null === $content = call_user_func_array(array($controller, $method), $matches)) {
                exit();
            }
            
            break;
        }
    }

    if($controller === null) {
        include_once('controller/controller.php');
        $controller = new Controller();
    }

    $user = $controller->getUser();
    $partners = $controller->query('SELECT * FROM partners');
} catch(Exception $e) {
    $content = '<p class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> ' . $e->getMessage() . '</p>';
    $partners = array();
    $user = null;
}

$menu = include 'config/menu.php';

?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/x-icon" href="/assets/img/logo.svg" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <script src="https://kit.fontawesome.com/806b38dd59.js" crossorigin="anonymous"></script>

	<title><?= $controller->getConfig('meta_title') ?></title>
	
	<meta name="description" content="<?= $controller->getConfig('meta_description') ?>" />
	<meta name="keywords" content="<?= $controller->getConfig('meta_keywords') ?>" />
    
	<link rel="shortcut icon" type="image/x-icon" href="/assets/img/logo.svg" />
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.6/js/standalone/selectize.min.js" integrity="sha512-pgmLgtHvorzxpKra2mmibwH/RDAVMlOuqU98ZjnyZrOZxgAR8hwL8A02hQFWEK25V40/9yPYb/Zc+kyWMplgaA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.6/css/selectize.default.min.css" integrity="sha512-vKflY6VSoNmvZitwWFIKY6r8j1R8DJwAoM25PFH2EzF49j9gka2gNYMAf31y0Ct++phlsyJSX+9zi/vO1aSSdw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link rel="stylesheet" href="/assets/css/style.css" type="text/css" />
    <link rel="stylesheet" href="/assets/css/custom.css" type="text/css" />
    
    <base href="<?= isset($_SERVER['HTTPS']) ? 'https' : 'http' ?>://<?= $_SERVER['HTTP_HOST'] ?>/" />
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand text-truncate" href="/">
                <img src="/assets/img/logo.svg" alt="Logo" height=40 />
                <span class="d-inline-block d-lg-none d-xl-inline-block">
                    <?= $controller->getConfig('meta_title') ?>
                </span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav flex-grow-1 mb-2 mb-lg-0">
                    <?php foreach($menu as $key => $def) { ?>
                        <?php if(isset($def['submenu'])) { ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php if(isset($def['icon']) && $def['icon']) { ?>
                                        <i class="fas fa-<?= $def['icon'] ?> fa-fw"></i>
                                    <?php } ?>
                                    <?= $def['title'] ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php foreach($def['submenu'] as $_key => $_def) { ?>
                                        <li>
                                            <a class="dropdown-item" href="<?= $controller->generateUrl($_key) ?>">
                                                <?php if(isset($_def['icon']) && $_def['icon']) { ?>
                                                    <i class="fas fa-<?= $_def['icon'] ?> fa-fw"></i>
                                                <?php } ?>
                                                <?= $_def['title'] ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } else { ?>
                            <li class="nav-item">
                                <a class="nav-link<?= substr($request, 0, strlen($key)) === $key ? ' active" aria-current="page' : '' ?>" href="<?= $controller->generateUrl($key) ?>">
                                    <?php if(isset($def['icon']) && $def['icon']) { ?>
                                        <i class="fas fa-<?= $def['icon'] ?> fa-fw"></i>
                                    <?php } ?>
                                    <?= $def['title'] ?>
                                </a>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
                <ul class="navbar-nav">
                    <?php if($user !== null) { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user fa-fw"></i> <?= $user['first_name'] ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?= $controller->generateUrl('utilisateur') ?>"><i class="fas fa-user-gear fa-fw"></i> Mon profil</a></li>
                                <?php if($controller->isGranted($user, 'admin')) { ?>
                                    <li><a class="dropdown-item" href="<?= $controller->generateUrl('admin') ?>"><i class="fas fa-cogs fa-fw"></i> Administration</a></li>
                                <?php } ?>
                                <li><a class="dropdown-item" href="<?= $controller->generateUrl('logout') ?>"><i class="fas fa-right-from-bracket fa-fw"></i> Déconnexion</a></li>
                            </ul>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $controller->generateUrl('login') ?>">
                                <i class="fas fa-sign-in fa-fw"></i> Connexion
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container pt-3" id="main_container">
        <div class="row">
            <?php if(!empty($partners)) { ?>
                <div class="col-md-4 col-xl-3 order-2 order-md-1">
                    <?php foreach($partners as $partner) { ?>
                        <div class="card mb-3">
                            <div class="card-header">
                                <i class="fas fa-user-tie fa-fw"></i> <?= $partner['name'] ?>
                            </div>
                            <div class="card-body">
                                <div class="small">
                                    <?= nl2br($partner['description']) ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-md-8 col-xl-9 order-1 order-md-2">
            <?php } else { ?>
                <div class="col-12">
            <?php } ?>
                <?php foreach($controller->getFlash() as $message) { ?>
                    <div class="alert alert-<?= $message['level'] ?>">
                        <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>
                        <?= $message['message'] ?>
                    </div>
                <?php } ?>
                <div id="page_content">
                    <?= $content ?>
                </div>
            </div>
        </div>
        
        <footer class="d-flex justify-content-center my-3">
            <div class="me-3 d-flex align-items-center">
                <img src="assets/img/fft.png" alt="FFT"/>
            </div>
            <div>
                <address class="mb-0">
                    <?= nl2br($controller->getConfig('club_address')) ?>
                </address>
                <?php $email = $controller->getConfig('club_email'); ?>
                <a href="mailto:<?= $email ?>"><?= $email ?></a>
            </div>
        </footer>
    </div>
    
    <div class="modal" tabindex="-1" id="modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    
    <script src="/assets/js/index.js"></script>
</body>
</html>
