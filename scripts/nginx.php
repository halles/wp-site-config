<?php

include dirname(dirname(dirname(__FILE__))).'/env.php';

include dirname(dirname(__FILE__)).'/scripts/defaults.php';

if($env['site.ssl']){
	include dirname(__FILE__).'/ssl-generation.php';
}