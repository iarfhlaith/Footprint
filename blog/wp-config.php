<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'fpdb_live');

/** MySQL database username */
define('DB_USER', 'fpdb_user');

/** MySQL database password */
define('DB_PASSWORD', 'lamenux');

/** MySQL hostname */
define('DB_HOST', '78.153.209.37');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'Z1]J@9h$C)=LVr7H~yR8m:PI>1G*u^f*N=ek$iG^<5~YpVDy.St=<9>sf_-I*gV^');
define('SECURE_AUTH_KEY',  '}mtL%!QjwC:%L*aT@4AF`dK$py-lH{evvP=#u|<+uBY>LtEb$egNfl!)3.d54?%0');
define('LOGGED_IN_KEY',    '3d/UHXP+5d$+)#v^iSWo-LthnjzdfJoF]GfLWtVgTbE-4eO2&sWVWNk0q:R6,(5)');
define('NONCE_KEY',        '5XCAopVdXO]z{&S_TtH`?xAJT>N[w9<|=;K}/Q@J++- }j6%*r&)-{&KH+;zmo0V');
define('AUTH_SALT',        '{v]2<wO,HBuASviQr,%*@f;uk[_}s:|M;,b]@nVuy}^JLjEbcnd+7j|z^C(Q!HdP');
define('SECURE_AUTH_SALT', 'vm0y&No+@d-N}Y.(Av-|lYea|]olpR.D0PB.SLmw}^KU.5fM<[H-$u2j*KjG+]eX');
define('LOGGED_IN_SALT',   '5D5PwSEVuP&bFmW(,f+J:r1:X! H2eae;/~+Eyj~wt1|Bh)h|vVR6?[_:m^`lJ%:');
define('NONCE_SALT',       'NRt+@VB@!xmle`:,gR:G+O7L91NjZM`~`#U@(YeTRs,N)[EMNa||U~C6Id=tNS&Y');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'blog_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
