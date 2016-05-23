<?php

$defaults = array(

    'domain'   => 'local.default.com',
    'domain.alternates' => 'default.com www.default.com',
    
    'site.port' => '8080',
    'site.port.internal' => '8080',
    'site.portssl' => '8443',
    'site.portssl.internal' => '8443',
    'site.ssl' => true,
    'site.ssl.force' => true,
    'site.directory' => '/sites/default.com-site',
    'site.directory.public' => 'www',
    'site.directory.wordpress' => 'wp',
    'site.url' => '',
    'site.scheme' => 'https',

    'user' => 'foo',
    'group' => 'foo',
    
    'php.port' => '8675',

    'db.name' => 'foo_bar',
    'db.user' => 'root',
    'db.pass' => '',
    'db.host' => 'localhost',
    'db.charset' => 'utf8mb4',
    'db.collate' => '',
    'db.prefix' => 'wpfoo_',

    'wp.saltkeys' => null,
    'wp.language' => 'ES_es',

    'ssl.country'  => 'CL',
    'ssl.state'    => 'State',
    'ssl.location' => 'Location',
    'ssl.office'   => 'Office',
    'ssl.ou'       => 'Organizational Unit',
    'ssl.cn'       => 'Common Name',
    'ssl.directory'=> '/sites/default.com-site/certs',
    'ssl.key'      => 'server.key',
    'ssl.csr'      => 'server.csr',
    'ssl.crt'      => 'server.crt',

);


if($env['site.ssl']){

   if($env['site.port']!=443)
        $env['site.url'] = $env['domain'].':'.$env['site.portssl'];
    else
        $env['site.url'] = $env['domain'];
    
}else{

    if($env['site.port']!=80)
        $env['site.url'] = $env['domain'].':'.$env['site.port'];
    else
        $env['site.url'] = $env['domain'];

}

$env['site.scheme'] = $env['site.ssl']?'https':'http';


$env = array_merge($defaults, $env);