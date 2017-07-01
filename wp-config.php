<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clés secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur
 * {@link http://codex.wordpress.org/fr:Modifier_wp-config.php Modifier
 * wp-config.php}. C’est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define('DB_NAME', 'wms');

/** Utilisateur de la base de données MySQL. */
define('DB_USER', 'root');

/** Mot de passe de la base de données MySQL. */
define('DB_PASSWORD', 'root');

/** Adresse de l’hébergement MySQL. */
define('DB_HOST', 'localhost');

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8mb4');

/** Type de collation de la base de données.
  * N’y touchez que si vous savez ce que vous faites.
  */
define('DB_COLLATE', '');

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'Pi3;W0&y 4]3eFS2`LvK/1N{73$O+I(PM|IWe{QV`+PPm89Ov`Q(M&G ?Duj$^U<');
define('SECURE_AUTH_KEY',  'Bw}u)U,5knA~YIZ^QZ#_A5}P-H6s/ :Z6wJ_N<Zo <USOy~e@tmN&o1@,CI#5*!?');
define('LOGGED_IN_KEY',    '*cOaVefF<JYgEZ2LaIb!{?M=@)%2A6RD;mXKWB@90#EYO[:CTUG7y^)xh*`l)%ZV');
define('NONCE_KEY',        'I k0Vk4ZY!dsn7mf;U|vcJRysUOuQ8|w:C6_4RywwbUOpsKCHRdMu:rpqcJT)`lr');
define('AUTH_SALT',        ']RIp5!1`8Xy{6b[KXB32-Mk(S Ha76[L:zh[&e@ucm3io7T2Hb|e#]{r6#Ap9RSB');
define('SECURE_AUTH_SALT', 's2|R9Wg@c172to9Q}7lio]X._ANu^xi|[7[At@~FE>6!%?dL1w D9`~(23ee(OQl');
define('LOGGED_IN_SALT',   'U,[QI*z e}6:@;JQS%P&k}*c3X16:-zLU]zFHK$z}9Rk]}=)5:EM^JH/I/SsiqTU');
define('NONCE_SALT',       'F;uo,GBk&1gs)r4#{w@BE,D[)nLd7+pf/5+Wcgho#?p9c9:pe7z_v}3`ZBR2ZMi#');
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix  = 'wp_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortemment recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* C’est tout, ne touchez pas à ce qui suit ! */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');