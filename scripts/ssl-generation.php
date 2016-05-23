<?php


if(!file_exists($env['ssl.directory'])){
    if(!mkdir($env['ssl.directory'])){
        die('Directory for SSL certificate could not be created: '.$env['ssl.directory']."\n");
    }
}

if(!is_dir($env['ssl.directory'])){
    die('Directory for SSL certificate is a file: '.$env['ssl.directory']."\n");
}

if(!is_writable($env['ssl.directory'])){
    die('Directory for SSL in not writable: '.$env['ssl.directory']."\n");
}

exec(sprintf('openssl genrsa -out %s/%s 1024',
    $env['ssl.directory'],
    $env['ssl.key']
));

exec(sprintf('openssl req -new -key %s/%s -out %s/%s -subj "/C=%s/ST=%s/L=%s/O=%s/OU=%s/CN=%s"',
    $env['ssl.directory'],
    $env['ssl.key'],
    $env['ssl.directory'],
    $env['ssl.csr'],
    $env['ssl.country'],
    $env['ssl.state'],
    $env['ssl.location'],
    $env['ssl.office'],
    $env['ssl.ou'],
    $env['ssl.cn']
));

exec(sprintf('openssl x509 -req -days 365 -in %s/%s -signkey %s/%s -out %s/%s',
    $env['ssl.directory'],
    $env['ssl.csr'],
    $env['ssl.directory'],
    $env['ssl.key'],
    $env['ssl.directory'],
    $env['ssl.crt']
));

$env['sslconfig'] = <<< SSL
ssl                         on;
    ssl_certificate             {$env['ssl.directory']}/{$env['ssl.crt']};
    ssl_certificate_key         {$env['ssl.directory']}/{$env['ssl.key']};

    ssl_session_timeout         5m;
    ssl_protocols               SSLv2 SSLv3 TLSv1;
    ssl_ciphers                 HIGH:!aNULL:!MD5;
    ssl_prefer_server_ciphers   on;

SSL;
