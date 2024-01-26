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
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'fifa_23_stats' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'A y@myR^FfT<Szs8Y/K ]za0oSz5bCGf}rl#>hC1Hl(eI<!|#}LR$I8_{k:A[6rm' );
define( 'SECURE_AUTH_KEY',  'e<$CuF/~=]8hT(!-}g#M8+7S:^<>M%geOpuqb>$h8ePe}[oonf,J[mYw7n@@V|DM' );
define( 'LOGGED_IN_KEY',    '6F~lXjJ.YehyWTlk4e~XpM>KTktwh_RG*kFWGv[ljBWE~L)1R!zBP4v]>%iZPNc=' );
define( 'NONCE_KEY',        'pVC<bVTi*=q]9fu3sp>}gq.1fv 0y6~P_TG!-O:DzRs)&a{.ky_5I+r-6UIKqDUm' );
define( 'AUTH_SALT',        '`nJuo5~A{qE!}8r~. >0wJnqOX*dR9X4gHS(U^M_q+|kN%Z!8g 4a%vI;R_^ W%N' );
define( 'SECURE_AUTH_SALT', '>aP^LNRtWl#iNV`GqF<eH0%;BzC!-.ssKU_~[.0=s(Aw4ffTkDXwhJKu~?#<eV;}' );
define( 'LOGGED_IN_SALT',   '|V{nqp9(*acGDQL-SVO.d@_Q,9rq0ccj,zJM g=3M,mazxCJy).in{%5{*9_a$fc' );
define( 'NONCE_SALT',       'OMzQ.(fTD-R3Qios:$.e(qu&ihCiqO^f5I6?Xsz(#M =E^e]u.)gtGS?`_1%fH9m' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', FALSE );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
