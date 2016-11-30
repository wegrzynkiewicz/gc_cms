<?php

/* Bootstapuje aplikację */

define('START_TIME',    microtime(true));

session_start();

if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = [];
}

require_once __DIR__.'/config/config.php';
require_once __DIR__.'/functions.php';
//require_once __DIR__.'/error-handler.php';

require_once ROOT_PATH.'/src/GrafCenter/Normalizer.php';
require_once ROOT_PATH.'/src/GrafCenter/Translator.php';
require_once ROOT_PATH.'/src/GrafCenter/Storage/Database.php';
require_once ROOT_PATH.'/src/GrafCenter/Storage/Entity.php';
require_once ROOT_PATH.'/src/GrafCenter/Storage/Model.php';
require_once ROOT_PATH.'/src/GrafCenter/Storage/Node.php';
require_once ROOT_PATH.'/src/GrafCenter/Trait/ColumnTrait.php';
require_once ROOT_PATH.'/src/GrafCenter/Trait/ContainFrameTrait.php';
require_once ROOT_PATH.'/src/GrafCenter/Trait/NodeTrait.php';
require_once ROOT_PATH.'/src/GrafCenter/Trait/PositionTrait.php';
require_once ROOT_PATH.'/src/GrafCenter/Trait/PrimaryTrait.php';
require_once ROOT_PATH.'/src/GrafCenter/Trait/TaxonomyTrait.php';
require_once ROOT_PATH.'/src/GrafCenter/Trait/TreeTrait.php';
require_once ROOT_PATH.'/src/GrafCenter/Model/Frame.php';
require_once ROOT_PATH.'/src/GrafCenter/Model/FrameModule.php';
require_once ROOT_PATH.'/src/GrafCenter/Model/FramePosition.php';
require_once ROOT_PATH.'/src/GrafCenter/Model/Gallery.php';
require_once ROOT_PATH.'/src/GrafCenter/Model/GalleryImage.php';
require_once ROOT_PATH.'/src/GrafCenter/Model/GalleryPosition.php';
require_once ROOT_PATH.'/src/GrafCenter/Model/Menu.php';
require_once ROOT_PATH.'/src/GrafCenter/Model/MenuTaxonomy.php';
require_once ROOT_PATH.'/src/GrafCenter/Model/MenuTree.php';
require_once ROOT_PATH.'/src/GrafCenter/Model/Page.php';
require_once ROOT_PATH.'/src/GrafCenter/Model/Post.php';
require_once ROOT_PATH.'/src/GrafCenter/Model/PostCategory.php';
require_once ROOT_PATH.'/src/GrafCenter/Model/PostMembership.php';
require_once ROOT_PATH.'/src/GrafCenter/Model/PostTaxonomy.php';
require_once ROOT_PATH.'/src/GrafCenter/Model/PostTree.php';
require_once ROOT_PATH.'/src/GrafCenter/Model/Staff.php';
require_once ROOT_PATH.'/src/GrafCenter/Model/StaffGroup.php';
require_once ROOT_PATH.'/src/GrafCenter/Model/StaffMembership.php';
require_once ROOT_PATH.'/src/GrafCenter/Model/StaffPermission.php';
require_once ROOT_PATH.'/src/GrafCenter/Model/Widget.php';

header_remove("X-Powered-By");
setHeaderMimeType('text/html');
date_default_timezone_set($config['timezone']);

if ($config["debug"]) {
    error_reporting(E_ALL);
    ini_set('display_errors', 'on');
}

$pdo = new PDO($config["db"]["dns"], $config["db"]["user"], $config["db"]["password"]);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

Database::$pdo    = $pdo;
Database::$prefix = $config["db"]["prefix"];

require_once __DIR__.'/routing.php';

logger(sprintf("[RESPONSE] %s :: ExecutionTime: %s",
    http_response_code(),
    (microtime(true) - START_TIME)
));
