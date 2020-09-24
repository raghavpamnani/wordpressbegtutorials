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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'begtutorial' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         '~BC(7(!OGtkJG5vdM1E)7+Ek/) il}Vy)Smi%e<%YA:0R(CJ9`a?JzFhO1Y?y>Rn' );
define( 'SECURE_AUTH_KEY',  ',8zI4Yx]is.nKl;%mwm4}|A?QQ8&/rWMK.]U~|AR}XIRVy(T1.iCrk9[Y:k~sgTY' );
define( 'LOGGED_IN_KEY',    'C#2Vg/>M8K.!rS?w}<h#sy9ME}|E3NXW6c(#P67W+<`-6H~S9tC{9h.Mt).2MG~A' );
define( 'NONCE_KEY',        'J,]=FP;l`AhwiTzF;RUMo1I76Z3DDb}D(?UC3jnS}csj>L[l,1>yJl@CR!:_ozd6' );
define( 'AUTH_SALT',        'AM}X~=ZQ+(A0RZf(bVhov7y6aKD>5<UY<eQpjWUTFqQ_+Qf,?YN29klt5eT[~$dG' );
define( 'SECURE_AUTH_SALT', 'q9J5%%>d8okDui_Z-GSZc%@,MZxQ %|J{8I|=8dt~!k6Ii{V/Om@;oYHrYP$GSIb' );
define( 'LOGGED_IN_SALT',   'wnwk4P/dgtAM~a=Rf.hGL[S|(Kb+a,Z}Kg`VNBH2]wOV?#t^PqxmHR4=c11z0jjG' );
define( 'NONCE_SALT',       ';?M?5Jl?S!ZUVQ7)m>.HfQ=30{JbwB|PJ^r~Kd2=|8SI8i, 1*Qm/74;_@9=&XST' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpbe_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
