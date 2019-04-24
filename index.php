<?
header('Content-Type: text/html; charset=utf-8', true);
define("ROOT",$_SERVER['DOCUMENT_ROOT']);
require_once(ROOT."/main/autoload.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$router= new \main\router();

$router->addRoute("www\.(.*)","http://$1")->host()->code(301);
$router->addRoute("/action/([a-zA-Z0-9\_]+)/([a-zA-Z0-9\_]+)/","$1/$2");
$router->addRoute("(.*)/page/1/","$1/")->code(301);

$router->addRoute("/","main");
$router->addRoute("/page/([0-9]+)/","main");

$router->addRoute("/c-([0-9]+)-([a-zA-Z0-9\_\-]+)/","main/games");
$router->addRoute("/c-([0-9]+)-([a-zA-Z0-9\_\-]+)/page/([0-9]+)/","main/games");

$router->addRoute("/g-([0-9]+)-([a-zA-Z0-9\_\-]+)/","main/game");

$router->addRoute("/ckeditor/.*","_site/ckeditor");
$router->addRoute("/search/.*","main/search");

$router->addRoute("/admin/","admin");
$router->addRoute("/admin/([a-zA-Z0-9\_]+)/","admin/$1");


$route=$router->getRoute();
_siteC::launchSite($route);


?>
