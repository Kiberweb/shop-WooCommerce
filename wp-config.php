<?php
define("WP_CACHE", true);

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
define("DB_NAME", "some_db");

/** Database username */
define("DB_USER", "some_user");

/** Database password */
define("DB_PASSWORD", "iQQI2wm0sX");

/** Database hostname */
define("DB_HOST", "127.0.0.1");

/** Database charset to use in creating database tables. */
define("DB_CHARSET", "utf8");

/** The database collate type. Don't change this if in doubt. */
define("DB_COLLATE", "");

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
define(
    "AUTH_KEY",
    "4kF=&fBsrcIBwP#i^g<Iv~=97?Y]xRmH01^vOerd^;K`^e,>58Oqx|yy_qqdJ*}r",
);
define(
    "SECURE_AUTH_KEY",
    'NS_<8Qt!eU_V%8{5@Ny]/oaY[pIOt[sTE-Lup_LNFvOM$@UT DgY4+AC>S|a]j@R',
);
define(
    "LOGGED_IN_KEY",
    'fx:;rEImq 5A}>gYP5zFf#nOHUe9;@2e SMr<$+^<{MJ)EG^.nK|FL,JX5o^m$Z5',
);
define(
    "NONCE_KEY",
    '.+2($yXXYa2JWWnRe05K5+ErLqr~un,KSr*+eVu8mZXhoK&)LcqT&Q{`.bD}@IO7',
);
define(
    "AUTH_SALT",
    't7rm9IqY$E~HW@eS;~0V: Zn,fbsnoic2)}t<uFr,]__AigmrT-M1ml=zQQDL$X3',
);
define(
    "SECURE_AUTH_SALT",
    ":*QIiF#e5K0/<B-TFb`v1IPdsp>>p#+`})WkPh6FNU(=t/Aq9cZtMY+S4}BSbgjL",
);
define(
    "LOGGED_IN_SALT",
    '{on9HvDBWI,37$&J&-eyj26*0rO`MYXY BOreqe0u:|t3JB]iK}?5f&z#>FYVT$2',
);
define(
    "NONCE_SALT",
    "W~dgqd,}SEl ~-SV,P%J;0qjtm[a>%^7tl~QcjNRM_d8|8L(6V25JD/G&Hu_R2M%",
);
define(
    "WP_CACHE_KEY_SALT",
    'Kq.lS)ngu8!8[6yB*jIqj23uu$!vG$9Kd[`_^+}i9Do_30Y/Z+Q|pV`i <+x6p]W',
);

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = "wp_";

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
if (!defined("WP_DEBUG")) {
    define("WP_DEBUG", false);
}

define("FS_METHOD", "direct");
define("COOKIEHASH", "1444a932db8a0d932d144068d12355a0");
define("WP_AUTO_UPDATE_CORE", "minor");
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (!defined("ABSPATH")) {
    define("ABSPATH", __DIR__ . "/");
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . "wp-settings.php";
