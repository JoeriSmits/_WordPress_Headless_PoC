<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          '%j/)JOEWTc Y^Bf~2dh@YyubMK4l05c0|hCfKeM{JnCD:?N1GETT(sw=jQNiLup_' );
define( 'SECURE_AUTH_KEY',   'drBH@g6xMN,#RxLV^%z5w6dKMXs&tvm^K)bW/i*{`q~DPhQ*oKjQ+d6eQu#b0ZYm' );
define( 'LOGGED_IN_KEY',     'W4A>8xqq01Hru>w86S4:pyH%m]Gpm.P5jegWu6Z.di=|ax?)4lu5#tT2HZ0WX=*b' );
define( 'NONCE_KEY',         '7LYTLKPvY$I&x_`q,t8.Ve&*@wR*^:++mD39OqTg(V/X+Ff2fvd~0_Osvr!jlN1>' );
define( 'AUTH_SALT',         'bNi~{GRd?A,g>UGnOVlu:$Q@B<|E{(l|d?Mo>=<^wmle!q8F}nw3*6RcYCbwd]?&' );
define( 'SECURE_AUTH_SALT',  '4TqZatg8)h@p4|<>j483JvA=qs#(*e0>F6~%d1$i?yK4N]@S!iz[JPjw+9>I>A+`' );
define( 'LOGGED_IN_SALT',    'B6YV^mj7j3HeL?I>gy]k9X7YmB`HUT3Pb2I5Po$/C?}>+7wP|aQXIW=T83M`pH*8' );
define( 'NONCE_SALT',        '>uc31S}Sk[E@!kA}vdhQ~X<|B@4`&ZjG8VNtTdYu,}eR10F xI5/yo8F5)67lsFp' );
define( 'WP_CACHE_KEY_SALT', '/IV7h{WoH$OYqMv+StKq>d=8s<~O2J/+,55`H+iy%F/GO&vQy:h^ds=uzxktvkbk' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
// if ( ! defined( 'WP_DEBUG' ) ) {
// 	define( 'WP_DEBUG', false );
// }



define( 'WP_ALLOW_MULTISITE', true );
define( 'MULTISITE', true );
define( 'SUBDOMAIN_INSTALL', true );
$base = '/';
define( 'DOMAIN_CURRENT_SITE', 'wp-test.local' );
define( 'PATH_CURRENT_SITE', '/' );
define( 'SITE_ID_CURRENT_SITE', 1 );
define( 'BLOG_ID_CURRENT_SITE', 1 );

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

define('HEADLESS_SECRET', 'test');
define('HEADLESS_URL', 'http://wp-test.local'); // http://localhost:3000 for local development
define('GRAPHQL_JWT_AUTH_SECRET_KEY', 'test');
define('GRAPHQL_JWT_AUTH_CORS_ENABLE', true);
/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

