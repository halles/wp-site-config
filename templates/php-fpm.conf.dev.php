<?php

$config = <<< END

[${'domain'}]

listen = 127.0.0.1:${'php.port'}

listen.allowed_clients = 127.0.0.1

user = ${'user'}
group = ${'group'}

pm = dynamic
pm.max_children = 50
pm.start_servers = 5
pm.min_spare_servers = 5
pm.max_spare_servers = 35

slowlog = ${'site.directory'}/logs/php-fpm-slow.log

php_admin_value[error_log] = ${'site.directory'}/logs/php-fpm-error.log
php_admin_flag[log_errors] = on

php_value[session.save_handler] = files
php_value[session.save_path]    = ${'site.directory'}/session
php_value[soap.wsdl_cache_dir]  = ${'site.directory'}/wsdlcache


END;

return $config;