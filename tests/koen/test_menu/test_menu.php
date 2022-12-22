<?php
require_once 'siteDAO.php';
require_once 'menuview.php';

$siteDAO = new SiteDAO();
$menuitems = $siteDAO->getMenuItems();

$menuview = new MenuView($menuitems);
$menuview->show();

