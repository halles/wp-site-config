<?php

$config = <<< END

server {
    listen      ${'site.portssl.internal'};
    server_name ${'domain'};

    access_log ${'site.directory'}/logs/nginx-access.log;
    error_log ${'site.directory'}/logs/nginx-error.log;

    root   ${'site.directory'}/www;
    index  index.php;
    autoindex  off;

    sendfile off;

    client_max_body_size 25M;

    port_in_redirect on;

    ########################
    ## SSL
    ########################

    ${sslconfig}

    ########################
    ## No Cache on Development
    ########################

    expires 1s;
    add_header Pragma "no-cache";
    add_header Cache-Control no-cache;
    add_header Cache-Control private;


    ########################
    ## Global Restrictions
    ########################

    location = /favicon.ico {
        log_not_found off;
        access_log off;
    }

    location = /robots.txt {
        allow all;
        log_not_found off;
        access_log off;
    }

    # Deny all attempts to access hidden files such as .htaccess, .htpasswd, .DS_Store (Mac).
    # Keep logging the requests to parse later (or to pass to firewall utilities such as fail2ban)
    location ~ /\. {
        access_log off;
        log_not_found off;
        deny all;
    }


    # Directives to send expires headers and turn off 404 error logging.
    location ~* ^.+\.(ogg|ogv|svg|svgz|eot|otf|woff|mp4|ttf|rss|atom|jpg|jpeg|gif|png|ico|zip|tgz|gz|rar|bz2|doc|xls|exe|ppt|tar|mid|midi|wav|bmp|rtf)$ {
       access_log off;
       log_not_found off;
       expires max;
    }

    ########################
    ## WordPress single blog rules.
    ## Designed to be included in any server {} block.
    ########################

    # This order might seem weird - this is attempted to match last if rules below fail.
    # http://wiki.nginx.org/HttpCoreModule
    location / {
        try_files \$uri \$uri/ /index.php?\$args;
    }

    # Add trailing slash to */wp-admin requests.
    rewrite /wp-admin$ \$scheme://\$host/wp/\$uri/ permanent;


    ########################
    ## Deny access to any files with a .php extension in the uploads directory
    ## Works in sub-directory installs and also in multisite network
    ## Keep logging the requests to parse later (or to pass to firewall utilities such as fail2ban)
    ########################

    location ~* /(?:uploads|files|media)/.*\.php$ {
        deny all;
    }

    ########################
    ## W3 Total Cache - Uncomment
    ########################

    # include ${'site.directory'}/www/nginx.conf;

    ########################
    ## PHP Proxy
    ########################

    # Pass all .php files onto a php-fpm/php-fcgi server.
    location ~ [^/]\.php(/|$) {

        fastcgi_split_path_info ^(.+\.php)(/.+)$;

        fastcgi_pass   127.0.0.1:8675;
        fastcgi_index  index.php;
        fastcgi_param  SCRIPT_FILENAME    \$document_root\$fastcgi_script_name;

        fastcgi_param  ENVIRONMENT        development;
        fastcgi_param  PATH_INFO          \$fastcgi_path_info;
        fastcgi_param  PATH_TRANSLATED    \$document_root\$fastcgi_script_name;
        
        fastcgi_param  QUERY_STRING       \$query_string;
        fastcgi_param  REQUEST_METHOD     \$request_method;
        fastcgi_param  CONTENT_TYPE       \$content_type;
        fastcgi_param  CONTENT_LENGTH     \$content_length;

        fastcgi_param  SCRIPT_NAME        \$fastcgi_script_name;
        fastcgi_param  REQUEST_URI        \$request_uri;
        fastcgi_param  DOCUMENT_URI       \$document_uri;
        fastcgi_param  DOCUMENT_ROOT      \$document_root;
        fastcgi_param  SERVER_PROTOCOL    \$server_protocol;
        fastcgi_param  HTTPS              \$https if_not_empty;

        fastcgi_param  GATEWAY_INTERFACE  CGI/1.1;
        fastcgi_param  SERVER_SOFTWARE    nginx/\$nginx_version;

        fastcgi_param  REMOTE_ADDR        \$remote_addr;
        fastcgi_param  REMOTE_PORT        \$remote_port;
        fastcgi_param  SERVER_ADDR        \$server_addr;
        fastcgi_param  SERVER_PORT        \$server_port;
        fastcgi_param  SERVER_NAME        \$server_name;

        # PHP only, required if PHP was built with --enable-force-cgi-redirect
        fastcgi_param  REDIRECT_STATUS    200;
        
    }

}

server {
    listen      ${'site.portssl.internal'};
    server_name ${'domain.alternates'};
    return 301  ${'site.scheme'}://${'site.url'}\$request_uri;
}

server {
    listen      ${'site.port.internal'};
    server_name ${'domain'} ${'domain.alternates'};
    return 301  ${'site.scheme'}://${'site.url'}\$request_uri;
}

END;

return $config;

