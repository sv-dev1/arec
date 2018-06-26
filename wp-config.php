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
define('DB_NAME', 'cixvydmy_arecdb');

/** MySQL database username */
define('DB_USER', 'cixvydmy_arecusr');

/** MySQL database password */
define('DB_PASSWORD', 'dCD#NqC[mJ+a');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '&7/PcvsN:?/K)o^_q0z7ANcQ<i?dzjU~90/)0o.3:nP+nm@bK/%g:CZFMB>:ftya');
define('SECURE_AUTH_KEY',  ',KQ9rss]SC<,b2)J.B<P/Q?UR6ePp2`k)eG22GnY&]m!8yQeQ.t3;MdLYTsZUKhE');
define('LOGGED_IN_KEY',    '+)},h0<Z36bhn5]va8l/BKKT=@pz_=P7. -zPy[[?V&n<{3l2Z;,W5xQ!oU{P_NA');
define('NONCE_KEY',        '22k:0GOm:HsoW:?I3Fe<gXL&U.]LeXoA3r8Z[mVb}~.Q`TS9}> S<;J;V=;EY;4J');
define('AUTH_SALT',        'y[Z]ZNNyV-Oho@tG:k,B-#Q$|6L#6|OQ1vM=~[d51/fzbI/=[H;qF]e8j!|G(Y<M');
define('SECURE_AUTH_SALT', 'yP{Y=mBze:~=pF&56Ln` a9)jIpQ3Z;Cz#zO+-c46 [Pu)^D=fb51+],(7oFX|h-');
define('LOGGED_IN_SALT',   '*APor}8#OgHs@V^(8.~ *R&y`Q&K!B<vhMu3y^)K/,Nv~a<5<nb*lu6i3Kg%|8Qt');
define('NONCE_SALT',       '+gcBcVqh+{vEUN(EsIx+U6(q#W2Mt&KZ*sVC(R_)Z0hqmh|2ClS|MmYXdw`Kw!iP');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'arec_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
