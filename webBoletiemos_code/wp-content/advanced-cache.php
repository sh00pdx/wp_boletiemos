<?php
/* PageSpeed Ninja Caching */
defined('ABSPATH') || die();
define('PAGESPEEDNINJA_CACHE_DIR', '/var/www/html/wp-content/plugins/psn-pagespeed-ninja/cache');
define('PAGESPEEDNINJA_CACHE_PLUGIN', '/var/www/html/wp-content/plugins/psn-pagespeed-ninja');
define('PAGESPEEDNINJA_CACHE_RESSDIR', '/var/www/html/wp-content/plugins/psn-pagespeed-ninja/ress');
define('PAGESPEEDNINJA_CACHE_DEVICEDEPENDENT', false);
define('PAGESPEEDNINJA_CACHE_TTL', 900);
define('PAGESPEEDNINJA_CACHE_GZIP', 0);
include '/var/www/html/wp-content/plugins/psn-pagespeed-ninja/public/advanced-cache.php';
