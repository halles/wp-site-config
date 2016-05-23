<?php

$config = <<< END

<?php

/**
 * Basic WP Config
 */

define('DB_NAME',     '${'db.name'}');
define('DB_USER',     '${'db.user'}');
define('DB_PASSWORD', '${'db.pass'}');
define('DB_HOST',     '${'db.host'}');
define('DB_CHARSET',  '${'db.charset'}');
define('DB_COLLATE',  '${'db.collate'}');

\$table_prefix  = '${'db.prefix'}';

${'wp.saltkeys'}

define('WPLANG', ${'wp.language'});

/**
 * Custom WordPress Install Path
 */

define( 'WP_SITEURL', '${'site.scheme'}://${'site.url'}/${'site.directory.wordpress'}' );
define( 'WP_HOME', '${'site.scheme'}://${'site.url'}' );

define( 'WP_CONTENT_DIR', dirname( __FILE__ ) . '/content' );
define( 'WP_CONTENT_URL', WP_HOME . '/content');

define( 'WP_PLUGIN_URL',  WP_CONTENT_URL . '/plugins' );

define( 'DISALLOW_FILE_EDIT', true);
define( 'DISALLOW_FILE_MODS', true);
define( 'RELOCATE', true);

define( 'AUTOMATIC_UPDATER_DISABLED', false );
define( 'WP_AUTO_UPDATE_CORE', false );

/**
 * SSL
 */

define( 'FORCE_SSL_LOGIN', true );
define( 'FORCE_SSL_ADMIN', true );

/**
 * Debug Flags
 */

define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
define('SAVEQUERIES', true);

/* KEEP OUT BELOW */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
    define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');


END;

return $config;

