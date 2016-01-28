<?php
	define('ROOT', $_SERVER['DOCUMENT_ROOT']);
	define('ROOT_LIB', ROOT.'/lib/');
	define('ROOT_CONFIG', ROOT.'/config/');
//	define('WEBHOST', $_SERVER['HTTP_HOST']);
//	ROOT = $_SERVER['DOCUMENT_ROOT']);
	include ROOT_LIB.'constants.php';
	include ROOT_CONFIG.'setup.php';
	include ROOT_LIB.'form.php';
	include ROOT_LIB.'auth.php';
	include ROOT_LIB.'session.php';
