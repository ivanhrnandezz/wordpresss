<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'ivanwordpress' );

/** Database username */
define( 'DB_USER', 'ivanwordpress' );

/** Database password */
define( 'DB_PASSWORD', 'ivanwordpress' );

/** Database hostname */
define( 'DB_HOST', 'localhost:3307' );

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
define( 'AUTH_KEY',         '^H=Joe-x_LNWsZDP>J#|>QYM0Er9rODO]ggB*pGA<19{jf;XDlA7f!eI:}JK(=I{' );
define( 'SECURE_AUTH_KEY',  'T!~U7l=+mtc$D){HTs8 pD8Qi>]!VEM:95ui7$.E?R4v+&>j-3V=QR`3&VT*hMcL' );
define( 'LOGGED_IN_KEY',    'D-vbc7@S@nUTdO).p:dBFSIEVR{b$T`=24`QGvmIfSk%h*p#oayS$|Z#LDq{9khR' );
define( 'NONCE_KEY',        '8|%9%NJ!KGB+?+IqZ_[K#(;;Egj4MT|jOrq8L<Q:XG|p}3hU>p.7SN._#D:nE/IZ' );
define( 'AUTH_SALT',        '$PN%?#fZRz BjR;Ih)Y^hW!|i_]=3sca,;R _v{]jAB$^a8Mp(3Giryw_^+X9t>s' );
define( 'SECURE_AUTH_SALT', 'd7PP>q{NN<y4Sbm5eIyY06DuUxz[|hl8O`:cg`[qEGz]1;MW[O<?3_MdfpZiQ_D ' );
define( 'LOGGED_IN_SALT',   'a fTb7g6/h,X~#9%v:P~=$=IgG}Cc{S{P*sZY>V)hXGgQ.>SP58?zQ]ef!OI({nZ' );
define( 'NONCE_SALT',       'h.]4,TtE$N)=qy,ra)r&7J&<S+PO<!)}#5+osl>c;+YMg9[Y9!lcmE<LF;dYaqs)' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
