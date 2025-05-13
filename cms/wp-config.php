<?php
/**
 * WordPress の基本設定
 *
 * このファイルは、インストール時に wp-config.php 作成ウィザードが利用します。
 * ウィザードを介さずにこのファイルを "wp-config.php" という名前でコピーして
 * 直接編集して値を入力してもかまいません。
 *
 * このファイルは、以下の設定を含みます。
 *
 * * MySQL 設定
 * * 秘密鍵
 * * データベーステーブル接頭辞
 * * ABSPATH
 *
 * @link https://ja.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// 注意:
// Windows の "メモ帳" でこのファイルを編集しないでください !
// 問題なく使えるテキストエディタ
// (http://wpdocs.osdn.jp/%E7%94%A8%E8%AA%9E%E9%9B%86#.E3.83.86.E3.82.AD.E3.82.B9.E3.83.88.E3.82.A8.E3.83.87.E3.82.A3.E3.82.BF 参照)
// を使用し、必ず UTF-8 の BOM なし (UTF-8N) で保存してください。

// ** MySQL 設定 - この情報はホスティング先から入手してください。 ** //
/** WordPress のためのデータベース名 */
define( 'DB_NAME', 'kokurakinen_main' );

/** MySQL データベースのユーザー名 */
define( 'DB_USER', 'kokurakinen' );

/** MySQL データベースのパスワード */
define( 'DB_PASSWORD', 'wl9MCIRM7w' );

/** MySQL のホスト名 */
define( 'DB_HOST', 'mysql624.db.sakura.ne.jp' );

/** データベースのテーブルを作成する際のデータベースの文字セット */
define( 'DB_CHARSET', 'utf8mb4' );

/** データベースの照合順序 (ほとんどの場合変更する必要はありません) */
define( 'DB_COLLATE', '' );

/** 市民公開講座の格納先 */
define( 'DB_NAME_LECTURE', 'kokurakinen_data' );

/** 市民公開講座のFROM送付先 */
define( 'EMAIL_FROM_LECTURE', 'shiminkoukaikouza@kokurakinen.or.jp' );

/** 市民公開講座のBCC送付先 */
define( 'EMAIL_BCC_LECTURE', 'shiminkoukaikouza@kokurakinen.or.jp' );

/**#@+
 * 認証用ユニークキー
 *
 * それぞれを異なるユニーク (一意) な文字列に変更してください。
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org の秘密鍵サービス} で自動生成することもできます。
 * 後でいつでも変更して、既存のすべての cookie を無効にできます。これにより、すべてのユーザーを強制的に再ログインさせることになります。
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'OC-[yc4#~`Z ;M=i5nt !X[b}`eaz=RpE|s#-|$yC-O5^<HOKkDmx,uEVkn1;zq*' );
define( 'SECURE_AUTH_KEY',  ']<L?|q8)~n9OF~aS`2LEdBXApQrmhLn[4%wQI{$FfDl95ZV!Ns];py(i.)!n6|L`' );
define( 'LOGGED_IN_KEY',    'k*m7KVvp{OPN v:T~Nq1.8#ikpVwSTzm2itgE27g_u?IBkqd^w;yV$k&Bg-(ELhw' );
define( 'NONCE_KEY',        'ox~LIhge[?Cu1|H?+@iA#x`!ZH?-,5C8+xYm!EQy2TOhMziIaJmpdV^4BW&0im S' );
define( 'AUTH_SALT',        'A8]pjX_cK2SR0zaN+@[H@v/5PDe)M#B%eZ<s7?%6C[sb?.ViuRht}H{J`[iERC!a' );
define( 'SECURE_AUTH_SALT', '=~9|eRPF~GLXrnk<<!n0=_CV;xh/{V@5g;Q,9z.C/;bL1`d?Li0q98hP4 {96Q D' );
define( 'LOGGED_IN_SALT',   ')Y0M5$UF$>$VDgMV ;Gf)uh!~=E/D.rrjV4b{_=<CoAp|,,#j4T2?EcXFdUL^wh^' );
define( 'NONCE_SALT',       '2;^udNsnI>9lW9JvFRgQ4V=@_=!7So`xsQ6G,yz[.FU*eD-3;_IL};[Z(>RRbYV^' );

/**#@-*/

/**
 * WordPress データベーステーブルの接頭辞
 *
 * それぞれにユニーク (一意) な接頭辞を与えることで一つのデータベースに複数の WordPress を
 * インストールすることができます。半角英数字と下線のみを使用してください。
 */
$table_prefix = 'wp_';

/**
 * 開発者へ: WordPress デバッグモード
 *
 * この値を true にすると、開発中に注意 (notice) を表示します。
 * テーマおよびプラグインの開発者には、その開発環境においてこの WP_DEBUG を使用することを強く推奨します。
 *
 * その他のデバッグに利用できる定数についてはドキュメンテーションをご覧ください。
 *
 * @link https://ja.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* 編集が必要なのはここまでです ! WordPress でのパブリッシングをお楽しみください。 */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
