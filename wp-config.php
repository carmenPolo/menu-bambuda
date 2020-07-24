<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'menubambudda' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '!i3U)Fb; u4qR3^b`$~%}3S%bp %w-bt7]lB,k=vc]hwyM32^X,{k]|}RklMY2.@' );
define( 'SECURE_AUTH_KEY',  '8^GoLU/kP.[QT9T%U@QP8vTjMi;Ubh{ u~h$-L[;b5e5G1,K#!prSJzE:[O_l/.6' );
define( 'LOGGED_IN_KEY',    '2tS0LOkjHL!>I=Hzy,}OvIDQmkn{C]gRVH&B:-W.bE5H}: f}-ny$^:~Jm( Cta5' );
define( 'NONCE_KEY',        'B]yCk8%&5o`<`zO^F)!K<EaEZ0S6bq~?k62/uOSghJhXj]1cGV5GHHKDcV02:oH4' );
define( 'AUTH_SALT',        'eR-L3LwuX2R$m1 _lb5OaOd434yD+o;D&k;t5/5G&2d?3pc3t+CoW%-gvNmO*zZ@' );
define( 'SECURE_AUTH_SALT', '8eiZ+JP[IFrnjW+FZRg8ZO<T06Bb!q3B^iY$|fb%mrwGbFu285t{q/Z#+]?S!Ks ' );
define( 'LOGGED_IN_SALT',   '>>qgnjQ_xC8iEOms,.~z-yhOxC[<XgkK>>vN@Hm8a0>h7Sub[+_%J(;-mzQ;v[j*' );
define( 'NONCE_SALT',       '*;QUjh+/CSY7E3O&tLLh|=u9i^w<EhkeucW{>gfG&)Lr=U8 /Q}=ks@KVZR:`CI ' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'dl_';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
