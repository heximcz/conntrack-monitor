<?php 
include_once __DIR__ . '/App/Arguments.php';
include_once __DIR__ . '/App/Parser.php';
include_once __DIR__ . '/App/Parser/Template/IParserTemplate.php';
include_once __DIR__ . '/App/Parser/Template/IPTrafTemplate.php';
include_once __DIR__ . '/App/Parser/Template/MailLogTemplate.php';
include_once __DIR__ . '/App/Parser/Template/ConntrackTemplate.php';

use App\Arguments;
use App\Parser;
use App\Parser\Template\IPTrafTemplate;
use App\Parser\Template\MailLogTemplate;
use App\Parser\Template\ConntrackTemplate;

$config = parse_ini_file(__DIR__ . '/config/settings.ini');

$args = new Arguments($argv);
$gcMin = $args->get("m", $config['gc_minimum']);
$tempSet = $args->get("t", $config['template']);

switch($tempSet){
	case "iptraf":
		$template = new IPTrafTemplate();
		break;
	case "maillog":
		$template = new MailLogTemplate();
		break;
	default:
	case "conntrack":
		$template = new ConntrackTemplate(); 
		break;
}

$parser = new Parser($template);
die("ououo");

$parser->setGcMinimum($gcMin)
	->setStream($args->getStream())
	->parse();

//var_dump($parser->getStats());
foreach($parser->getStats() as $key => $stat){
	echo $key . " " . $stat . "\n";
}
















?>