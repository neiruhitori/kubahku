<?php
session_start();

// ============================================
// SIKUBAH ROUTING - Handle admin routes
// ============================================

define('APPPATH', __DIR__ . '/application/');
define('BASEPATH', __DIR__ . '/system/');
define('VIEWPATH', APPPATH . 'views/');

// Auto-loader untuk classes
spl_autoload_register(function ($class) {
    $file = APPPATH . 'models/' . $class . '.php';
    if (file_exists($file)) {
        require $file;
        return;
    }

    $file = APPPATH . 'controllers/' . $class . '.php';
    if (file_exists($file)) {
        require $file;
        return;
    }
});

// Simple Database Class
class Database
{
    public $conn;

    public function __construct()
    {
        $this->conn = new mysqli('localhost', 'root', '', 'db_sikubah');
        if ($this->conn->connect_error) {
            die('Database connection failed: ' . $this->conn->connect_error);
        }
        $this->conn->set_charset('utf8mb4');
    }

    public function query($sql)
    {
        return $this->conn->query($sql);
    }

    public function prepare($sql)
    {
        return $this->conn->prepare($sql);
    }

    public function escape_string($str)
    {
        return $this->conn->real_escape_string($str);
    }

    public function insert_id()
    {
        return $this->conn->insert_id;
    }

    public function affected_rows()
    {
        return $this->conn->affected_rows;
    }
}

// Base Controller
class Controller
{
    public $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function load_view($view, $data = [])
    {
        extract($data);
        require VIEWPATH . $view . '.php';
    }
}

// Check if this is an admin route request
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = str_replace('/SIKUBAH', '', $uri); // Remove base path
$uri = trim($uri, '/');

// Admin routes that need special handling
$admin_routes = ['auth', 'dashboard', 'pages', 'portfolio', 'articles', 'content', 'settings'];
$is_admin_route = false;

foreach ($admin_routes as $route) {
    if (strpos($uri, $route) === 0) {
        $is_admin_route = true;
        break;
    }
}

if ($is_admin_route) {
    // Route to admin controllers
    if (strpos($uri, 'auth') === 0) {
        $segments = explode('/', 'auth/' . trim(str_replace('auth', '', $uri), '/'));
    } elseif (strpos($uri, 'dashboard') === 0) {
        $segments = explode('/', 'dashboard/' . trim(str_replace('dashboard', '', $uri), '/'));
    } else {
        $segments = explode('/', $uri);
    }

    // Clean up empty segments
    $segments = array_filter($segments, function ($v) {
        return $v !== '';
    });
    $segments = array_values($segments); // Re-index array

    $controller = ucfirst($segments[0] ?? 'Auth');
    $method = isset($segments[1]) && !empty($segments[1]) ? $segments[1] : 'index';
    $params = array_slice($segments, 2);

    // Load appropriate controller
    $controller_file = APPPATH . 'controllers/' . $controller . '.php';

    if (file_exists($controller_file)) {
        require $controller_file;
        if (class_exists($controller)) {
            $ctrl_obj = new $controller();
            if (method_exists($ctrl_obj, $method)) {
                call_user_func_array([$ctrl_obj, $method], $params);
                exit;
            }
        }
    }
}

// Check for blog and other frontend routes
if (strpos($uri, 'blog') === 0) {
    $segments = explode('/', $uri);
    $segments = array_filter($segments, function ($v) {
        return $v !== '';
    });
    $segments = array_values($segments);

    require APPPATH . 'controllers/Home.php';
    $ctrl_obj = new Home();

    if (isset($segments[1]) && !empty($segments[1])) {
        // Single article: /blog/article-slug
        $slug = $segments[1];
        $ctrl_obj->article($slug);
    } else {
        // Blog listing: /blog
        $ctrl_obj->blog();
    }
    exit;
}

// If not an admin route or blog route, continue with landing page
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US" prefix="og: https://ogp.me/ns#">

<head>
    <meta charset="UTF-8">
    <title>PKM - Produsen Kubah Masjid</title>

    <!-- All in One SEO 4.9.7.1 - aioseo.com -->
    <meta name="description"
        content="Cari tempat jual kubah masjid terdekat? Dapatkan kubah berkualitas dengan desain menawan, pemasangan tepat waktu, &amp; harga transparan. Hubungi tim kami sekarang!" />
    <meta name="robots" content="max-image-preview:large" />
    <meta name="keywords"
        content="kubah masjid,jual kubah masjid terdekat,jual kubah masjid,pembuatan kubah masjid,penjual kubah masjid terdekat,pembuat kubah masjid,jasa pembuatan kubah masjid,pembuat kubah masjid terdekat" />
    <link rel="canonical" href="https://www.jualkubahmasjid.id/" />
    <meta name="generator" content="All in One SEO (AIOSEO) 4.9.7.1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:site_name" content="JUAL KUBAH MASJID  Harga Kubah Masjid Terjangkau! |" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Jual Kubah Masjid Terdekat Pilihan Tepat untuk Masjid Anda" />
    <meta property="og:description"
        content="Cari tempat jual kubah masjid terdekat? Dapatkan kubah berkualitas dengan desain menawan, pemasangan tepat waktu, &amp; harga transparan. Hubungi tim kami sekarang!" />
    <meta property="og:url" content="https://www.jualkubahmasjid.id/" />
    <meta property="article:published_time" content="2025-12-11T03:16:47+00:00" />
    <meta property="article:modified_time" content="2026-01-21T03:29:31+00:00" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:title" content="Jual Kubah Masjid Terdekat Pilihan Tepat untuk Masjid Anda" />
    <meta name="twitter:description"
        content="Cari tempat jual kubah masjid terdekat? Dapatkan kubah berkualitas dengan desain menawan, pemasangan tepat waktu, &amp; harga transparan. Hubungi tim kami sekarang!" />
    <!-- All in One SEO -->

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel='dns-prefetch' href='//www.googletagmanager.com' />
    <link href='https://fonts.gstatic.com' crossorigin rel='preconnect' />
    <link href='https://fonts.googleapis.com' crossorigin rel='preconnect' />
    <link rel="alternate" title="oEmbed (JSON)" type="application/json+oembed"
        href="https://www.jualkubahmasjid.id/wp-json/oembed/1.0/embed?url=https%3A%2F%2Fwww.jualkubahmasjid.id%2F" />
    <link rel="alternate" title="oEmbed (XML)" type="text/xml+oembed"
        href="https://www.jualkubahmasjid.id/wp-json/oembed/1.0/embed?url=https%3A%2F%2Fwww.jualkubahmasjid.id%2F&#038;format=xml" />
    <style id='wp-img-auto-sizes-contain-inline-css'>
        img:is([sizes=auto i], [sizes^="auto," i]) {
            contain-intrinsic-size: 3000px 1500px
        }

        /*# sourceURL=wp-img-auto-sizes-contain-inline-css */
    </style>
    <link rel='stylesheet' id='generate-fonts-css'
        href='//fonts.googleapis.com/css?family=Open+Sans:300,300italic,regular,italic,600,600italic,700,700italic,800,800italic'
        media='all' />
    <style id='wp-emoji-styles-inline-css'>
        img.wp-smiley,
        img.emoji {
            display: inline !important;
            border: none !important;
            box-shadow: none !important;
            height: 1em !important;
            width: 1em !important;
            margin: 0 0.07em !important;
            vertical-align: -0.1em !important;
            background: none !important;
            padding: 0 !important;
        }

        /*# sourceURL=wp-emoji-styles-inline-css */
    </style>
    <style id='wp-block-library-inline-css'>
        :root {
            --wp-block-synced-color: #7a00df;
            --wp-block-synced-color--rgb: 122, 0, 223;
            --wp-bound-block-color: var(--wp-block-synced-color);
            --wp-editor-canvas-background: #ddd;
            --wp-admin-theme-color: #007cba;
            --wp-admin-theme-color--rgb: 0, 124, 186;
            --wp-admin-theme-color-darker-10: #006ba1;
            --wp-admin-theme-color-darker-10--rgb: 0, 107, 160.5;
            --wp-admin-theme-color-darker-20: #005a87;
            --wp-admin-theme-color-darker-20--rgb: 0, 90, 135;
            --wp-admin-border-width-focus: 2px
        }

        @media (min-resolution:192dpi) {
            :root {
                --wp-admin-border-width-focus: 1.5px
            }
        }

        .wp-element-button {
            cursor: pointer
        }

        :root .has-very-light-gray-background-color {
            background-color: #eee
        }

        :root .has-very-dark-gray-background-color {
            background-color: #313131
        }

        :root .has-very-light-gray-color {
            color: #eee
        }

        :root .has-very-dark-gray-color {
            color: #313131
        }

        :root .has-vivid-green-cyan-to-vivid-cyan-blue-gradient-background {
            background: linear-gradient(135deg, #00d084, #0693e3)
        }

        :root .has-purple-crush-gradient-background {
            background: linear-gradient(135deg, #34e2e4, #4721fb 50%, #ab1dfe)
        }

        :root .has-hazy-dawn-gradient-background {
            background: linear-gradient(135deg, #faaca8, #dad0ec)
        }

        :root .has-subdued-olive-gradient-background {
            background: linear-gradient(135deg, #fafae1, #67a671)
        }

        :root .has-atomic-cream-gradient-background {
            background: linear-gradient(135deg, #fdd79a, #004a59)
        }

        :root .has-nightshade-gradient-background {
            background: linear-gradient(135deg, #330968, #31cdcf)
        }

        :root .has-midnight-gradient-background {
            background: linear-gradient(135deg, #020381, #2874fc)
        }

        :root {
            --wp--preset--font-size--normal: 16px;
            --wp--preset--font-size--huge: 42px
        }

        .has-regular-font-size {
            font-size: 1em
        }

        .has-larger-font-size {
            font-size: 2.625em
        }

        .has-normal-font-size {
            font-size: var(--wp--preset--font-size--normal)
        }

        .has-huge-font-size {
            font-size: var(--wp--preset--font-size--huge)
        }

        .has-text-align-center {
            text-align: center
        }

        .has-text-align-left {
            text-align: left
        }

        .has-text-align-right {
            text-align: right
        }

        .has-fit-text {
            white-space: nowrap !important
        }

        #end-resizable-editor-section {
            display: none
        }

        .aligncenter {
            clear: both
        }

        .items-justified-left {
            justify-content: flex-start
        }

        .items-justified-center {
            justify-content: center
        }

        .items-justified-right {
            justify-content: flex-end
        }

        .items-justified-space-between {
            justify-content: space-between
        }

        .screen-reader-text {
            border: 0;
            clip-path: inset(50%);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
            word-wrap: normal !important
        }

        .screen-reader-text:focus {
            background-color: #ddd;
            clip-path: none;
            color: #444;
            display: block;
            font-size: 1em;
            height: auto;
            left: 5px;
            line-height: normal;
            padding: 15px 23px 14px;
            text-decoration: none;
            top: 5px;
            width: auto;
            z-index: 100000
        }

        html :where(.has-border-color) {
            border-style: solid
        }

        html :where([style*=border-top-color]) {
            border-top-style: solid
        }

        html :where([style*=border-right-color]) {
            border-right-style: solid
        }

        html :where([style*=border-bottom-color]) {
            border-bottom-style: solid
        }

        html :where([style*=border-left-color]) {
            border-left-style: solid
        }

        html :where([style*=border-width]) {
            border-style: solid
        }

        html :where([style*=border-top-width]) {
            border-top-style: solid
        }

        html :where([style*=border-right-width]) {
            border-right-style: solid
        }

        html :where([style*=border-bottom-width]) {
            border-bottom-style: solid
        }

        html :where([style*=border-left-width]) {
            border-left-style: solid
        }

        html :where(img[class*=wp-image-]) {
            height: auto;
            max-width: 100%
        }

        :where(figure) {
            margin: 0 0 1em
        }

        html :where(.is-position-sticky) {
            --wp-admin--admin-bar--position-offset: var(--wp-admin--admin-bar--height, 0px)
        }

        @media screen and (max-width:600px) {
            html :where(.is-position-sticky) {
                --wp-admin--admin-bar--position-offset: 0px
            }
        }

        /*# sourceURL=wp-block-library-inline-css */
    </style>
    <style id='classic-theme-styles-inline-css'>
        /*! This file is auto-generated */
        .wp-block-button__link {
            color: #fff;
            background-color: #32373c;
            border-radius: 9999px;
            box-shadow: none;
            text-decoration: none;
            padding: calc(.667em + 2px) calc(1.333em + 2px);
            font-size: 1.125em
        }

        .wp-block-file__button {
            background: #32373c;
            color: #fff;
            text-decoration: none
        }

        /*# sourceURL=/wp-includes/css/classic-themes.min.css */
    </style>
    <style id='global-styles-inline-css'>
        :root {
            --wp--preset--aspect-ratio--square: 1;
            --wp--preset--aspect-ratio--4-3: 4/3;
            --wp--preset--aspect-ratio--3-4: 3/4;
            --wp--preset--aspect-ratio--3-2: 3/2;
            --wp--preset--aspect-ratio--2-3: 2/3;
            --wp--preset--aspect-ratio--16-9: 16/9;
            --wp--preset--aspect-ratio--9-16: 9/16;
            --wp--preset--color--black: #000000;
            --wp--preset--color--cyan-bluish-gray: #abb8c3;
            --wp--preset--color--white: #ffffff;
            --wp--preset--color--pale-pink: #f78da7;
            --wp--preset--color--vivid-red: #cf2e2e;
            --wp--preset--color--luminous-vivid-orange: #ff6900;
            --wp--preset--color--luminous-vivid-amber: #fcb900;
            --wp--preset--color--light-green-cyan: #7bdcb5;
            --wp--preset--color--vivid-green-cyan: #00d084;
            --wp--preset--color--pale-cyan-blue: #8ed1fc;
            --wp--preset--color--vivid-cyan-blue: #0693e3;
            --wp--preset--color--vivid-purple: #9b51e0;
            --wp--preset--color--contrast: var(--contrast);
            --wp--preset--color--contrast-2: var(--contrast-2);
            --wp--preset--color--contrast-3: var(--contrast-3);
            --wp--preset--color--base: var(--base);
            --wp--preset--color--base-2: var(--base-2);
            --wp--preset--color--base-3: var(--base-3);
            --wp--preset--color--accent: var(--accent);
            --wp--preset--gradient--vivid-cyan-blue-to-vivid-purple: linear-gradient(135deg, rgb(6, 147, 227) 0%, rgb(155, 81, 224) 100%);
            --wp--preset--gradient--light-green-cyan-to-vivid-green-cyan: linear-gradient(135deg, rgb(122, 220, 180) 0%, rgb(0, 208, 130) 100%);
            --wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange: linear-gradient(135deg, rgb(252, 185, 0) 0%, rgb(255, 105, 0) 100%);
            --wp--preset--gradient--luminous-vivid-orange-to-vivid-red: linear-gradient(135deg, rgb(255, 105, 0) 0%, rgb(207, 46, 46) 100%);
            --wp--preset--gradient--very-light-gray-to-cyan-bluish-gray: linear-gradient(135deg, rgb(238, 238, 238) 0%, rgb(169, 184, 195) 100%);
            --wp--preset--gradient--cool-to-warm-spectrum: linear-gradient(135deg, rgb(74, 234, 220) 0%, rgb(151, 120, 209) 20%, rgb(207, 42, 186) 40%, rgb(238, 44, 130) 60%, rgb(251, 105, 98) 80%, rgb(254, 248, 76) 100%);
            --wp--preset--gradient--blush-light-purple: linear-gradient(135deg, rgb(255, 206, 236) 0%, rgb(152, 150, 240) 100%);
            --wp--preset--gradient--blush-bordeaux: linear-gradient(135deg, rgb(254, 205, 165) 0%, rgb(254, 45, 45) 50%, rgb(107, 0, 62) 100%);
            --wp--preset--gradient--luminous-dusk: linear-gradient(135deg, rgb(255, 203, 112) 0%, rgb(199, 81, 192) 50%, rgb(65, 88, 208) 100%);
            --wp--preset--gradient--pale-ocean: linear-gradient(135deg, rgb(255, 245, 203) 0%, rgb(182, 227, 212) 50%, rgb(51, 167, 181) 100%);
            --wp--preset--gradient--electric-grass: linear-gradient(135deg, rgb(202, 248, 128) 0%, rgb(113, 206, 126) 100%);
            --wp--preset--gradient--midnight: linear-gradient(135deg, rgb(2, 3, 129) 0%, rgb(40, 116, 252) 100%);
            --wp--preset--font-size--small: 13px;
            --wp--preset--font-size--medium: 20px;
            --wp--preset--font-size--large: 36px;
            --wp--preset--font-size--x-large: 42px;
            --wp--preset--spacing--20: 0.44rem;
            --wp--preset--spacing--30: 0.67rem;
            --wp--preset--spacing--40: 1rem;
            --wp--preset--spacing--50: 1.5rem;
            --wp--preset--spacing--60: 2.25rem;
            --wp--preset--spacing--70: 3.38rem;
            --wp--preset--spacing--80: 5.06rem;
            --wp--preset--shadow--natural: 6px 6px 9px rgba(0, 0, 0, 0.2);
            --wp--preset--shadow--deep: 12px 12px 50px rgba(0, 0, 0, 0.4);
            --wp--preset--shadow--sharp: 6px 6px 0px rgba(0, 0, 0, 0.2);
            --wp--preset--shadow--outlined: 6px 6px 0px -3px rgb(255, 255, 255), 6px 6px rgb(0, 0, 0);
            --wp--preset--shadow--crisp: 6px 6px 0px rgb(0, 0, 0);
        }

        :root :where(.is-layout-flow)> :first-child {
            margin-block-start: 0;
        }

        :root :where(.is-layout-flow)> :last-child {
            margin-block-end: 0;
        }

        :root :where(.is-layout-flow)>* {
            margin-block-start: 24px;
            margin-block-end: 0;
        }

        :root :where(.is-layout-constrained)> :first-child {
            margin-block-start: 0;
        }

        :root :where(.is-layout-constrained)> :last-child {
            margin-block-end: 0;
        }

        :root :where(.is-layout-constrained)>* {
            margin-block-start: 24px;
            margin-block-end: 0;
        }

        :root :where(.is-layout-flex) {
            gap: 24px;
        }

        :root :where(.is-layout-grid) {
            gap: 24px;
        }

        body .is-layout-flex {
            display: flex;
        }

        .is-layout-flex {
            flex-wrap: wrap;
            align-items: center;
        }

        .is-layout-flex> :is(*, div) {
            margin: 0;
        }

        body .is-layout-grid {
            display: grid;
        }

        .is-layout-grid> :is(*, div) {
            margin: 0;
        }

        .has-black-color {
            color: var(--wp--preset--color--black) !important;
        }

        .has-cyan-bluish-gray-color {
            color: var(--wp--preset--color--cyan-bluish-gray) !important;
        }

        .has-white-color {
            color: var(--wp--preset--color--white) !important;
        }

        .has-pale-pink-color {
            color: var(--wp--preset--color--pale-pink) !important;
        }

        .has-vivid-red-color {
            color: var(--wp--preset--color--vivid-red) !important;
        }

        .has-luminous-vivid-orange-color {
            color: var(--wp--preset--color--luminous-vivid-orange) !important;
        }

        .has-luminous-vivid-amber-color {
            color: var(--wp--preset--color--luminous-vivid-amber) !important;
        }

        .has-light-green-cyan-color {
            color: var(--wp--preset--color--light-green-cyan) !important;
        }

        .has-vivid-green-cyan-color {
            color: var(--wp--preset--color--vivid-green-cyan) !important;
        }

        .has-pale-cyan-blue-color {
            color: var(--wp--preset--color--pale-cyan-blue) !important;
        }

        .has-vivid-cyan-blue-color {
            color: var(--wp--preset--color--vivid-cyan-blue) !important;
        }

        .has-vivid-purple-color {
            color: var(--wp--preset--color--vivid-purple) !important;
        }

        .has-contrast-color {
            color: var(--wp--preset--color--contrast) !important;
        }

        .has-contrast-2-color {
            color: var(--wp--preset--color--contrast-2) !important;
        }

        .has-contrast-3-color {
            color: var(--wp--preset--color--contrast-3) !important;
        }

        .has-base-color {
            color: var(--wp--preset--color--base) !important;
        }

        .has-base-2-color {
            color: var(--wp--preset--color--base-2) !important;
        }

        .has-base-3-color {
            color: var(--wp--preset--color--base-3) !important;
        }

        .has-accent-color {
            color: var(--wp--preset--color--accent) !important;
        }

        .has-black-background-color {
            background-color: var(--wp--preset--color--black) !important;
        }

        .has-cyan-bluish-gray-background-color {
            background-color: var(--wp--preset--color--cyan-bluish-gray) !important;
        }

        .has-white-background-color {
            background-color: var(--wp--preset--color--white) !important;
        }

        .has-pale-pink-background-color {
            background-color: var(--wp--preset--color--pale-pink) !important;
        }

        .has-vivid-red-background-color {
            background-color: var(--wp--preset--color--vivid-red) !important;
        }

        .has-luminous-vivid-orange-background-color {
            background-color: var(--wp--preset--color--luminous-vivid-orange) !important;
        }

        .has-luminous-vivid-amber-background-color {
            background-color: var(--wp--preset--color--luminous-vivid-amber) !important;
        }

        .has-light-green-cyan-background-color {
            background-color: var(--wp--preset--color--light-green-cyan) !important;
        }

        .has-vivid-green-cyan-background-color {
            background-color: var(--wp--preset--color--vivid-green-cyan) !important;
        }

        .has-pale-cyan-blue-background-color {
            background-color: var(--wp--preset--color--pale-cyan-blue) !important;
        }

        .has-vivid-cyan-blue-background-color {
            background-color: var(--wp--preset--color--vivid-cyan-blue) !important;
        }

        .has-vivid-purple-background-color {
            background-color: var(--wp--preset--color--vivid-purple) !important;
        }

        .has-contrast-background-color {
            background-color: var(--wp--preset--color--contrast) !important;
        }

        .has-contrast-2-background-color {
            background-color: var(--wp--preset--color--contrast-2) !important;
        }

        .has-contrast-3-background-color {
            background-color: var(--wp--preset--color--contrast-3) !important;
        }

        .has-base-background-color {
            background-color: var(--wp--preset--color--base) !important;
        }

        .has-base-2-background-color {
            background-color: var(--wp--preset--color--base-2) !important;
        }

        .has-base-3-background-color {
            background-color: var(--wp--preset--color--base-3) !important;
        }

        .has-accent-background-color {
            background-color: var(--wp--preset--color--accent) !important;
        }

        .has-black-border-color {
            border-color: var(--wp--preset--color--black) !important;
        }

        .has-cyan-bluish-gray-border-color {
            border-color: var(--wp--preset--color--cyan-bluish-gray) !important;
        }

        .has-white-border-color {
            border-color: var(--wp--preset--color--white) !important;
        }

        .has-pale-pink-border-color {
            border-color: var(--wp--preset--color--pale-pink) !important;
        }

        .has-vivid-red-border-color {
            border-color: var(--wp--preset--color--vivid-red) !important;
        }

        .has-luminous-vivid-orange-border-color {
            border-color: var(--wp--preset--color--luminous-vivid-orange) !important;
        }

        .has-luminous-vivid-amber-border-color {
            border-color: var(--wp--preset--color--luminous-vivid-amber) !important;
        }

        .has-light-green-cyan-border-color {
            border-color: var(--wp--preset--color--light-green-cyan) !important;
        }

        .has-vivid-green-cyan-border-color {
            border-color: var(--wp--preset--color--vivid-green-cyan) !important;
        }

        .has-pale-cyan-blue-border-color {
            border-color: var(--wp--preset--color--pale-cyan-blue) !important;
        }

        .has-vivid-cyan-blue-border-color {
            border-color: var(--wp--preset--color--vivid-cyan-blue) !important;
        }

        .has-vivid-purple-border-color {
            border-color: var(--wp--preset--color--vivid-purple) !important;
        }

        .has-contrast-border-color {
            border-color: var(--wp--preset--color--contrast) !important;
        }

        .has-contrast-2-border-color {
            border-color: var(--wp--preset--color--contrast-2) !important;
        }

        .has-contrast-3-border-color {
            border-color: var(--wp--preset--color--contrast-3) !important;
        }

        .has-base-border-color {
            border-color: var(--wp--preset--color--base) !important;
        }

        .has-base-2-border-color {
            border-color: var(--wp--preset--color--base-2) !important;
        }

        .has-base-3-border-color {
            border-color: var(--wp--preset--color--base-3) !important;
        }

        .has-accent-border-color {
            border-color: var(--wp--preset--color--accent) !important;
        }

        .has-vivid-cyan-blue-to-vivid-purple-gradient-background {
            background: var(--wp--preset--gradient--vivid-cyan-blue-to-vivid-purple) !important;
        }

        .has-light-green-cyan-to-vivid-green-cyan-gradient-background {
            background: var(--wp--preset--gradient--light-green-cyan-to-vivid-green-cyan) !important;
        }

        .has-luminous-vivid-amber-to-luminous-vivid-orange-gradient-background {
            background: var(--wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange) !important;
        }

        .has-luminous-vivid-orange-to-vivid-red-gradient-background {
            background: var(--wp--preset--gradient--luminous-vivid-orange-to-vivid-red) !important;
        }

        .has-very-light-gray-to-cyan-bluish-gray-gradient-background {
            background: var(--wp--preset--gradient--very-light-gray-to-cyan-bluish-gray) !important;
        }

        .has-cool-to-warm-spectrum-gradient-background {
            background: var(--wp--preset--gradient--cool-to-warm-spectrum) !important;
        }

        .has-blush-light-purple-gradient-background {
            background: var(--wp--preset--gradient--blush-light-purple) !important;
        }

        .has-blush-bordeaux-gradient-background {
            background: var(--wp--preset--gradient--blush-bordeaux) !important;
        }

        .has-luminous-dusk-gradient-background {
            background: var(--wp--preset--gradient--luminous-dusk) !important;
        }

        .has-pale-ocean-gradient-background {
            background: var(--wp--preset--gradient--pale-ocean) !important;
        }

        .has-electric-grass-gradient-background {
            background: var(--wp--preset--gradient--electric-grass) !important;
        }

        .has-midnight-gradient-background {
            background: var(--wp--preset--gradient--midnight) !important;
        }

        .has-small-font-size {
            font-size: var(--wp--preset--font-size--small) !important;
        }

        .has-medium-font-size {
            font-size: var(--wp--preset--font-size--medium) !important;
        }

        .has-large-font-size {
            font-size: var(--wp--preset--font-size--large) !important;
        }

        .has-x-large-font-size {
            font-size: var(--wp--preset--font-size--x-large) !important;
        }

        /*# sourceURL=global-styles-inline-css */
    </style>

    <link rel='stylesheet' id='dashicons-css'
        href='https://www.jualkubahmasjid.id/wp-includes/css/dashicons.min.css?ver=6.9.4' media='all' />
    <link rel='stylesheet' id='admin-bar-css'
        href='https://www.jualkubahmasjid.id/wp-includes/css/admin-bar.min.css?ver=6.9.4' media='all' />
    <style id='admin-bar-inline-css'>
        /* Hide CanvasJS credits for P404 charts specifically */
        #p404RedirectChart .canvasjs-chart-credit {
            display: none !important;
        }

        #p404RedirectChart canvas {
            border-radius: 6px;
        }

        .p404-redirect-adminbar-weekly-title {
            font-weight: bold;
            font-size: 14px;
            color: #fff;
            margin-bottom: 6px;
        }

        #wpadminbar #wp-admin-bar-p404_free_top_button .ab-icon:before {
            content: "\f103";
            color: #dc3545;
            top: 3px;
        }

        #wp-admin-bar-p404_free_top_button .ab-item {
            min-width: 80px !important;
            padding: 0px !important;
        }

        /* Ensure proper positioning and z-index for P404 dropdown */
        .p404-redirect-adminbar-dropdown-wrap {
            min-width: 0;
            padding: 0;
            position: static !important;
        }

        #wpadminbar #wp-admin-bar-p404_free_top_button_dropdown {
            position: static !important;
        }

        #wpadminbar #wp-admin-bar-p404_free_top_button_dropdown .ab-item {
            padding: 0 !important;
            margin: 0 !important;
        }

        .p404-redirect-dropdown-container {
            min-width: 340px;
            padding: 18px 18px 12px 18px;
            background: #23282d !important;
            color: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
            margin-top: 10px;
            position: relative !important;
            z-index: 999999 !important;
            display: block !important;
            border: 1px solid #444;
        }

        /* Ensure P404 dropdown appears on hover */
        #wpadminbar #wp-admin-bar-p404_free_top_button .p404-redirect-dropdown-container {
            display: none !important;
        }

        #wpadminbar #wp-admin-bar-p404_free_top_button:hover .p404-redirect-dropdown-container {
            display: block !important;
        }

        #wpadminbar #wp-admin-bar-p404_free_top_button:hover #wp-admin-bar-p404_free_top_button_dropdown .p404-redirect-dropdown-container {
            display: block !important;
        }

        .p404-redirect-card {
            background: #2c3338;
            border-radius: 8px;
            padding: 18px 18px 12px 18px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            border: 1px solid #444;
        }

        .p404-redirect-btn {
            display: inline-block;
            background: #dc3545;
            color: #fff !important;
            font-weight: bold;
            padding: 5px 22px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 17px;
            transition: background 0.2s, box-shadow 0.2s;
            margin-top: 8px;
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.15);
            text-align: center;
            line-height: 1.6;
        }

        .p404-redirect-btn:hover {
            background: #c82333;
            color: #fff !important;
            box-shadow: 0 4px 16px rgba(220, 53, 69, 0.25);
        }

        /* Prevent conflicts with other admin bar dropdowns */
        #wpadminbar .ab-top-menu>li:hover>.ab-item,
        #wpadminbar .ab-top-menu>li.hover>.ab-item {
            z-index: auto;
        }

        #wpadminbar #wp-admin-bar-p404_free_top_button:hover>.ab-item {
            z-index: 999998 !important;
        }

        /*# sourceURL=admin-bar-inline-css */
    </style>
    <link rel='stylesheet' id='hide-metadata-style-css'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/hide-metadata/css/style.css?ver=2.0' media='all' />
    <link rel='stylesheet' id='landingkit-widgets-css'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/landingkit-elementor/assets/css/widgets.css?ver=2.1.0'
        media='all' />
    <link rel='stylesheet' id='generate-style-grid-css'
        href='https://www.jualkubahmasjid.id/wp-content/themes/generatepress/assets/css/unsemantic-grid.min.css?ver=3.6.1'
        media='all' />
    <link rel='stylesheet' id='generate-style-css'
        href='https://www.jualkubahmasjid.id/wp-content/themes/generatepress/assets/css/style.min.css?ver=3.6.1'
        media='all' />
    <style id='generate-style-inline-css'>
        body {
            background-color: #efefef;
            color: #3a3a3a;
        }

        a {
            color: #1e73be;
        }

        a:hover,
        a:focus,
        a:active {
            color: #000000;
        }

        body .grid-container {
            max-width: 1100px;
        }

        .wp-block-group__inner-container {
            max-width: 1100px;
            margin-left: auto;
            margin-right: auto;
        }

        :root {
            --contrast: #222222;
            --contrast-2: #575760;
            --contrast-3: #b2b2be;
            --base: #f0f0f0;
            --base-2: #f7f8f9;
            --base-3: #ffffff;
            --accent: #1e73be;
        }

        :root .has-contrast-color {
            color: var(--contrast);
        }

        :root .has-contrast-background-color {
            background-color: var(--contrast);
        }

        :root .has-contrast-2-color {
            color: var(--contrast-2);
        }

        :root .has-contrast-2-background-color {
            background-color: var(--contrast-2);
        }

        :root .has-contrast-3-color {
            color: var(--contrast-3);
        }

        :root .has-contrast-3-background-color {
            background-color: var(--contrast-3);
        }

        :root .has-base-color {
            color: var(--base);
        }

        :root .has-base-background-color {
            background-color: var(--base);
        }

        :root .has-base-2-color {
            color: var(--base-2);
        }

        :root .has-base-2-background-color {
            background-color: var(--base-2);
        }

        :root .has-base-3-color {
            color: var(--base-3);
        }

        :root .has-base-3-background-color {
            background-color: var(--base-3);
        }

        :root .has-accent-color {
            color: var(--accent);
        }

        :root .has-accent-background-color {
            background-color: var(--accent);
        }

        body,
        button,
        input,
        select,
        textarea {
            font-family: "Open Sans", sans-serif;
        }

        body {
            line-height: 1.5;
        }

        .entry-content>[class*="wp-block-"]:not(:last-child):not(.wp-block-heading) {
            margin-bottom: 1.5em;
        }

        .main-title {
            font-size: 45px;
        }

        .main-navigation .main-nav ul ul li a {
            font-size: 14px;
        }

        .sidebar .widget,
        .footer-widgets .widget {
            font-size: 17px;
        }

        h1 {
            font-weight: 300;
            font-size: 40px;
        }

        h2 {
            font-weight: 300;
            font-size: 30px;
        }

        h3 {
            font-size: 20px;
        }

        h4 {
            font-size: inherit;
        }

        h5 {
            font-size: inherit;
        }

        @media (max-width:768px) {
            .main-title {
                font-size: 30px;
            }

            h1 {
                font-size: 30px;
            }

            h2 {
                font-size: 25px;
            }
        }

        .top-bar {
            background-color: #636363;
            color: #ffffff;
        }

        .top-bar a {
            color: #ffffff;
        }

        .top-bar a:hover {
            color: #303030;
        }

        .site-header {
            background-color: #ffffff;
            color: #3a3a3a;
        }

        .site-header a {
            color: #3a3a3a;
        }

        .main-title a,
        .main-title a:hover {
            color: #222222;
        }

        .site-description {
            color: #757575;
        }

        .main-navigation,
        .main-navigation ul ul {
            background-color: #222222;
        }

        .main-navigation .main-nav ul li a,
        .main-navigation .menu-toggle,
        .main-navigation .menu-bar-items {
            color: #ffffff;
        }

        .main-navigation .main-nav ul li:not([class*="current-menu-"]):hover>a,
        .main-navigation .main-nav ul li:not([class*="current-menu-"]):focus>a,
        .main-navigation .main-nav ul li.sfHover:not([class*="current-menu-"])>a,
        .main-navigation .menu-bar-item:hover>a,
        .main-navigation .menu-bar-item.sfHover>a {
            color: #ffffff;
            background-color: #3f3f3f;
        }

        button.menu-toggle:hover,
        button.menu-toggle:focus,
        .main-navigation .mobile-bar-items a,
        .main-navigation .mobile-bar-items a:hover,
        .main-navigation .mobile-bar-items a:focus {
            color: #ffffff;
        }

        .main-navigation .main-nav ul li[class*="current-menu-"]>a {
            color: #ffffff;
            background-color: #3f3f3f;
        }

        .navigation-search input[type="search"],
        .navigation-search input[type="search"]:active,
        .navigation-search input[type="search"]:focus,
        .main-navigation .main-nav ul li.search-item.active>a,
        .main-navigation .menu-bar-items .search-item.active>a {
            color: #ffffff;
            background-color: #3f3f3f;
        }

        .main-navigation ul ul {
            background-color: #3f3f3f;
        }

        .main-navigation .main-nav ul ul li a {
            color: #ffffff;
        }

        .main-navigation .main-nav ul ul li:not([class*="current-menu-"]):hover>a,
        .main-navigation .main-nav ul ul li:not([class*="current-menu-"]):focus>a,
        .main-navigation .main-nav ul ul li.sfHover:not([class*="current-menu-"])>a {
            color: #ffffff;
            background-color: #4f4f4f;
        }

        .main-navigation .main-nav ul ul li[class*="current-menu-"]>a {
            color: #ffffff;
            background-color: #4f4f4f;
        }

        .separate-containers .inside-article,
        .separate-containers .comments-area,
        .separate-containers .page-header,
        .one-container .container,
        .separate-containers .paging-navigation,
        .inside-page-header {
            background-color: #ffffff;
        }

        .entry-meta {
            color: #595959;
        }

        .entry-meta a {
            color: #595959;
        }

        .entry-meta a:hover {
            color: #1e73be;
        }

        .sidebar .widget {
            background-color: #ffffff;
        }

        .sidebar .widget .widget-title {
            color: #000000;
        }

        .footer-widgets {
            background-color: #ffffff;
        }

        .footer-widgets .widget-title {
            color: #000000;
        }

        .site-info {
            color: #ffffff;
            background-color: #222222;
        }

        .site-info a {
            color: #ffffff;
        }

        .site-info a:hover {
            color: #606060;
        }

        .footer-bar .widget_nav_menu .current-menu-item a {
            color: #606060;
        }

        input[type="text"],
        input[type="email"],
        input[type="url"],
        input[type="password"],
        input[type="search"],
        input[type="tel"],
        input[type="number"],
        textarea,
        select {
            color: #666666;
            background-color: #fafafa;
            border-color: #cccccc;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="url"]:focus,
        input[type="password"]:focus,
        input[type="search"]:focus,
        input[type="tel"]:focus,
        input[type="number"]:focus,
        textarea:focus,
        select:focus {
            color: #666666;
            background-color: #ffffff;
            border-color: #bfbfbf;
        }

        button,
        html input[type="button"],
        input[type="reset"],
        input[type="submit"],
        a.button,
        a.wp-block-button__link:not(.has-background) {
            color: #ffffff;
            background-color: #666666;
        }

        button:hover,
        html input[type="button"]:hover,
        input[type="reset"]:hover,
        input[type="submit"]:hover,
        a.button:hover,
        button:focus,
        html input[type="button"]:focus,
        input[type="reset"]:focus,
        input[type="submit"]:focus,
        a.button:focus,
        a.wp-block-button__link:not(.has-background):active,
        a.wp-block-button__link:not(.has-background):focus,
        a.wp-block-button__link:not(.has-background):hover {
            color: #ffffff;
            background-color: #3f3f3f;
        }

        a.generate-back-to-top {
            background-color: rgba(0, 0, 0, 0.4);
            color: #ffffff;
        }

        a.generate-back-to-top:hover,
        a.generate-back-to-top:focus {
            background-color: rgba(0, 0, 0, 0.6);
            color: #ffffff;
        }

        :root {
            --gp-search-modal-bg-color: var(--base-3);
            --gp-search-modal-text-color: var(--contrast);
            --gp-search-modal-overlay-bg-color: rgba(0, 0, 0, 0.2);
        }

        @media (max-width:768px) {

            .main-navigation .menu-bar-item:hover>a,
            .main-navigation .menu-bar-item.sfHover>a {
                background: none;
                color: #ffffff;
            }
        }

        .inside-top-bar {
            padding: 10px;
        }

        .inside-header {
            padding: 40px;
        }

        .site-main .wp-block-group__inner-container {
            padding: 40px;
        }

        .entry-content .alignwide,
        body:not(.no-sidebar) .entry-content .alignfull {
            margin-left: -40px;
            width: calc(100% + 80px);
            max-width: calc(100% + 80px);
        }

        .rtl .menu-item-has-children .dropdown-menu-toggle {
            padding-left: 20px;
        }

        .rtl .main-navigation .main-nav ul li.menu-item-has-children>a {
            padding-right: 20px;
        }

        .site-info {
            padding: 20px;
        }

        @media (max-width:768px) {

            .separate-containers .inside-article,
            .separate-containers .comments-area,
            .separate-containers .page-header,
            .separate-containers .paging-navigation,
            .one-container .site-content,
            .inside-page-header {
                padding: 30px;
            }

            .site-main .wp-block-group__inner-container {
                padding: 30px;
            }

            .site-info {
                padding-right: 10px;
                padding-left: 10px;
            }

            .entry-content .alignwide,
            body:not(.no-sidebar) .entry-content .alignfull {
                margin-left: -30px;
                width: calc(100% + 60px);
                max-width: calc(100% + 60px);
            }
        }

        .one-container .sidebar .widget {
            padding: 0px;
        }

        @media (max-width:768px) {

            .main-navigation .menu-toggle,
            .main-navigation .mobile-bar-items,
            .sidebar-nav-mobile:not(#sticky-placeholder) {
                display: block;
            }

            .main-navigation ul,
            .gen-sidebar-nav {
                display: none;
            }

            [class*="nav-float-"] .site-header .inside-header>* {
                float: none;
                clear: both;
            }
        }

        /*# sourceURL=generate-style-inline-css */
    </style>
    <link rel='stylesheet' id='generate-mobile-style-css'
        href='https://www.jualkubahmasjid.id/wp-content/themes/generatepress/assets/css/mobile.min.css?ver=3.6.1'
        media='all' />
    <link rel='stylesheet' id='generate-font-icons-css'
        href='https://www.jualkubahmasjid.id/wp-content/themes/generatepress/assets/css/components/font-icons.min.css?ver=3.6.1'
        media='all' />
    <link rel='stylesheet' id='font-awesome-css'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/elementor/assets/lib/font-awesome/css/font-awesome.min.css?ver=4.7.0'
        media='all' />
    <link rel='stylesheet' id='elementor-icons-css'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/elementor/assets/lib/eicons/css/elementor-icons.min.css?ver=5.10.0'
        media='all' />
    <link rel='stylesheet' id='elementor-animations-css'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/elementor/assets/lib/animations/animations.min.css?ver=3.1.1'
        media='all' />
    <link rel='stylesheet' id='elementor-frontend-legacy-css'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/elementor/assets/css/frontend-legacy.min.css?ver=3.1.1'
        media='all' />
    <link rel='stylesheet' id='elementor-frontend-css'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/elementor/assets/css/frontend.min.css?ver=3.1.1'
        media='all' />
    <link rel='stylesheet' id='elementor-post-4567-css'
        href='https://www.jualkubahmasjid.id/wp-content/uploads/elementor/css/post-4567.css?ver=1757963715'
        media='all' />
    <link rel='stylesheet' id='elementor-pro-css'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/elementor-pro/assets/css/frontend.min.css?ver=3.0.10'
        media='all' />
    <link rel='stylesheet' id='font-awesome-5-all-css'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/elementor/assets/lib/font-awesome/css/all.min.css?ver=3.1.1'
        media='all' />
    <link rel='stylesheet' id='font-awesome-4-shim-css'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/elementor/assets/lib/font-awesome/css/v4-shims.min.css?ver=3.1.1'
        media='all' />
    <link rel='stylesheet' id='elementor-global-css'
        href='https://www.jualkubahmasjid.id/wp-content/uploads/elementor/css/global.css?ver=1757963715' media='all' />
    <link rel='stylesheet' id='elementor-post-20837-css'
        href='https://www.jualkubahmasjid.id/wp-content/uploads/elementor/css/post-20837.css?ver=1767910531'
        media='all' />
    <link rel='stylesheet' id='elementor-post-4296-css'
        href='https://www.jualkubahmasjid.id/wp-content/uploads/elementor/css/post-4296.css?ver=1757963715'
        media='all' />
    <link rel='stylesheet' id='elementor-post-4522-css'
        href='https://www.jualkubahmasjid.id/wp-content/uploads/elementor/css/post-4522.css?ver=1777551932'
        media='all' />
    <link rel='stylesheet' id='google-fonts-1-css'
        href='https://fonts.googleapis.com/css?family=Roboto%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic%7CRoboto+Slab%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic%7CExo%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic%7CPT+Sans%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic%7CPoppins%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic&#038;ver=6.9.4'
        media='all' />
    <link rel='stylesheet' id='elementor-icons-shared-0-css'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/elementor/assets/lib/font-awesome/css/fontawesome.min.css?ver=5.15.1'
        media='all' />
    <link rel='stylesheet' id='elementor-icons-fa-solid-css'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/elementor/assets/lib/font-awesome/css/solid.min.css?ver=5.15.1'
        media='all' />
    <link rel='stylesheet' id='elementor-icons-fa-brands-css'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/elementor/assets/lib/font-awesome/css/brands.min.css?ver=5.15.1'
        media='all' />
    <script
        src="https://www.jualkubahmasjid.id/wp-content/plugins/elementor/assets/lib/font-awesome/js/v4-shims.min.js?ver=3.1.1"
        id="font-awesome-4-shim-js"></script>

    <!-- Google tag (gtag.js) snippet added by Site Kit -->
    <!-- Google Analytics snippet added by Site Kit -->
    <!-- Google Ads snippet added by Site Kit -->
    <script src="https://www.googletagmanager.com/gtag/js?id=G-GBHP9RL402" id="google_gtagjs-js" async></script>
    <script id="google_gtagjs-js-after">
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag("set", "linker", {
            "domains": ["www.jualkubahmasjid.id"]
        });
        gtag("js", new Date());
        gtag("set", "developer_id.dZTNiMT", true);
        gtag("config", "G-GBHP9RL402", {
            "googlesitekit_post_type": "page"
        });
        gtag("config", "AW-737332955");
        //# sourceURL=google_gtagjs-js-after
    </script>
    <link rel="https://api.w.org/" href="https://www.jualkubahmasjid.id/wp-json/" />
    <link rel="alternate" title="JSON" type="application/json"
        href="https://www.jualkubahmasjid.id/wp-json/wp/v2/pages/20837" />
    <link rel="EditURI" type="application/rsd+xml" title="RSD" href="https://www.jualkubahmasjid.id/xmlrpc.php?rsd" />
    <meta name="generator" content="WordPress 6.9.4" />
    <link rel='shortlink' href='https://www.jualkubahmasjid.id/' />
    <meta name="generator" content="Site Kit by Google 1.178.0" />
    <style>
        #tombolhitung {
            background: #009EFC;
            border: 1px solid #0056C2;
            color: #fff;
            margin-bottom: 15px;
        }

        thead {
            font-weight: bold;
            text-transform: uppercase;
        }

        input {
            width: 330px !important;
            background: #eee;
            margin-bottom: 15px;
            margin-top: 5px;
        }

        @media only screen and (max-width: 767px) {
            input {
                width: 100% !important;
            }

            #tombolhitung {
                margin: 15px auto;
                display: block;
            }
        }
    </style>
    <!--BEGIN: TRACKING CODE MANAGER (v2.5.0) BY INTELLYWP.COM IN HEAD//-->
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-T5KVT6N');
    </script>
    <!-- End Google Tag Manager -->
    <!--END: https://wordpress.org/plugins/tracking-code-manager IN HEAD//-->
    <!-- Google Tag Manager snippet added by Site Kit -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-T5KVT6N');
    </script>

    <!-- End Google Tag Manager snippet added by Site Kit -->
    <link rel="icon" href="./images/icon.webp" type="image/png" />
    <link rel="apple-touch-icon" href="./images/icon.webp" />
    <link rel='stylesheet' id='elementor-post-17338-css'
        href='https://www.jualkubahmasjid.id/wp-content/uploads/elementor/css/post-17338.css?ver=1778159667'
        media='all' />

</head>

<body
    class="home wp-singular page-template page-template-elementor_header_footer page page-id-20837 wp-embed-responsive wp-theme-generatepress hide-meta-author hide-meta-date right-sidebar nav-below-header separate-containers fluid-header active-footer-widgets-3 nav-aligned-left header-aligned-left dropdown-hover elementor-default elementor-template-full-width elementor-kit-4567 elementor-page elementor-page-20837 full-width-content"
    itemtype="https://schema.org/WebPage" itemscope>
    <!-- Google Tag Manager (noscript) snippet added by Site Kit -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T5KVT6N" height="0" width="0"
            style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) snippet added by Site Kit -->

    <!--BEGIN: TRACKING CODE MANAGER (v2.5.0) BY INTELLYWP.COM IN BODY//-->
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T5KVT6N" height="0"
            width="0"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <!--END: https://wordpress.org/plugins/tracking-code-manager IN BODY//--><a class="screen-reader-text skip-link"
        href="#content" title="Skip to content">Skip to content</a>
    <div data-elementor-type="header" data-elementor-id="4296"
        class="elementor elementor-4296 elementor-location-header" data-elementor-settings="[]">
        <div class="elementor-section-wrap">
            <section
                class="elementor-section elementor-top-section elementor-element elementor-element-440dfc41 elementor-section-height-min-height elementor-section-boxed elementor-section-height-default elementor-section-items-middle"
                data-id="440dfc41" data-element_type="section"
                data-settings="{&quot;background_background&quot;:&quot;gradient&quot;,&quot;sticky&quot;:&quot;top&quot;,&quot;sticky_on&quot;:[&quot;desktop&quot;,&quot;tablet&quot;,&quot;mobile&quot;],&quot;sticky_offset&quot;:0,&quot;sticky_effects_offset&quot;:0}">
                <div class="elementor-container elementor-column-gap-default">
                    <div class="elementor-row">
                        <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-6b418c64"
                            data-id="6b418c64" data-element_type="column">
                            <div class="elementor-column-wrap elementor-element-populated">
                                <div class="elementor-widget-wrap">
                                    <div class="elementor-element elementor-element-394efcd4 elementor-widget elementor-widget-image"
                                        data-id="394efcd4" data-element_type="widget" data-widget_type="image.default">
                                        <div class="elementor-widget-container">
                                            <div class="elementor-image">
                                                <a href="#">
                                                    <img width="60" height="2"
                                                        src="./images/icon.webp"
                                                        class="attachment-large size-large" alt="qoobah"
                                                        decoding="async" fetchpriority="high" /> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-bd4a942"
                            data-id="bd4a942" data-element_type="column">
                            <div class="elementor-column-wrap elementor-element-populated">
                                <div class="elementor-widget-wrap">
                                    <div class="elementor-element elementor-element-2f88c2bf elementor-nav-menu__align-right elementor-nav-menu--indicator-chevron elementor-nav-menu--stretch elementor-nav-menu--dropdown-tablet elementor-nav-menu__text-align-aside elementor-nav-menu--toggle elementor-nav-menu--burger elementor-widget elementor-widget-nav-menu"
                                        data-id="2f88c2bf" data-element_type="widget"
                                        data-settings="{&quot;full_width&quot;:&quot;stretch&quot;,&quot;layout&quot;:&quot;horizontal&quot;,&quot;toggle&quot;:&quot;burger&quot;}"
                                        data-widget_type="nav-menu.default">
                                        <div class="elementor-widget-container">
                                            <nav role="navigation"
                                                class="elementor-nav-menu--main elementor-nav-menu__container elementor-nav-menu--layout-horizontal e--pointer-none">
                                                <ul id="menu-1-2f88c2bf" class="elementor-nav-menu">
                                                    <li
                                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-20837 current_page_item menu-item-20961">
                                                        <a href="http://localhost/SIKUBAH/" aria-current="page"
                                                            class="elementor-item elementor-item-active">Home</a>
                                                    </li>
                                                    <li
                                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-11694">
                                                        <a href="http://localhost/SIKUBAH/pages/menu/produk.php"
                                                            class="elementor-item">Produk</a>
                                                    </li>
                                                    <li
                                                        class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-has-children menu-item-16529">
                                                        <a href="#" aria-current="page"
                                                            class="elementor-item elementor-item-anchor">Aksesoris</a>
                                                        <ul class="sub-menu elementor-nav-menu--dropdown">
                                                            <li
                                                                class="menu-item menu-item-type-post_type menu-item-object-post menu-item-16530">
                                                                <a href="http://localhost/SIKUBAH/pages/menu/assesoris/replika-pintu-nabawi.php"
                                                                    class="elementor-sub-item">Replika Pintu Nabawi</a>
                                                            </li>
                                                            <li
                                                                class="menu-item menu-item-type-post_type menu-item-object-post menu-item-17507">
                                                                <a href="http://localhost/SIKUBAH/pages/menu/assesoris/mihrab-masjid-grc.php"
                                                                    class="elementor-sub-item">Mihrab Masjid GRC</a>
                                                            </li>
                                                            <li
                                                                class="menu-item menu-item-type-post_type menu-item-object-post menu-item-17509">
                                                                <a href="http://localhost/SIKUBAH/pages/menu/assesoris/menara-masjid.php"
                                                                    class="elementor-sub-item">Menara Masjid</a>
                                                            </li>
                                                            <li
                                                                class="menu-item menu-item-type-post_type menu-item-object-post menu-item-18277">
                                                                <a href="http://localhost/SIKUBAH/pages/menu/assesoris/lampu-gantung-masjid.php"
                                                                    class="elementor-sub-item">Lampu Gantung Masjid</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li
                                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-155">
                                                        <a href="http://localhost/SIKUBAH/pages/menu/harga.php"
                                                            class="elementor-item">Harga</a>
                                                    </li>
                                                    <!-- <li
                                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-5307">
                                                        <a href="http://localhost/SIKUBAH/pages/menu/video.php"
                                                            class="elementor-item">Video</a>
                                                    </li> -->
                                                    <li
                                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-17606">
                                                        <a href="http://localhost/SIKUBAH/pages/menu/kontak.php"
                                                            class="elementor-item">Kontak</a>
                                                    </li>
                                                    <li
                                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-153">
                                                        <a href="http://localhost/SIKUBAH/pages/menu/blog.php"
                                                            class="elementor-item">Blog</a>
                                                    </li>
                                                </ul>
                                            </nav>
                                            <div class="elementor-menu-toggle" role="button" tabindex="0"
                                                aria-label="Menu Toggle" aria-expanded="false">
                                                <i class="eicon-menu-bar" aria-hidden="true"></i>
                                                <span class="elementor-screen-only">Menu</span>
                                            </div>
                                            <nav class="elementor-nav-menu--dropdown elementor-nav-menu__container"
                                                role="navigation" aria-hidden="true">
                                                <ul id="menu-2-2f88c2bf" class="elementor-nav-menu">
                                                    <li
                                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-20837 current_page_item menu-item-20961">
                                                        <a href="http://localhost/SIKUBAH/" aria-current="page"
                                                            class="elementor-item elementor-item-active">Home</a>
                                                    </li>
                                                    <li
                                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-11694">
                                                        <a href="http://localhost/SIKUBAH/pages/menu/produk.php"
                                                            class="elementor-item">Produk</a>
                                                    </li>
                                                    <li
                                                        class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-has-children menu-item-16529">
                                                        <a href="http://localhost/SIKUBAH/#" aria-current="page"
                                                            class="elementor-item elementor-item-anchor">Aksesoris</a>
                                                        <ul class="sub-menu elementor-nav-menu--dropdown">
                                                            <li
                                                                class="menu-item menu-item-type-post_type menu-item-object-post menu-item-16530">
                                                                <a href="http://localhost/SIKUBAH/pages/menu/assesoris/replika-pintu-nabawi.php"
                                                                    class="elementor-sub-item">Replika Pintu Nabawi</a>
                                                            </li>
                                                            <li
                                                                class="menu-item menu-item-type-post_type menu-item-object-post menu-item-17507">
                                                                <a href="http://localhost/SIKUBAH/pages/menu/assesoris/mihrab-masjid-grc.php"
                                                                    class="elementor-sub-item">Mihrab Masjid GRC</a>
                                                            </li>
                                                            <li
                                                                class="menu-item menu-item-type-post_type menu-item-object-post menu-item-17509">
                                                                <a href="http://localhost/SIKUBAH/pages/menu/assesoris/menara-masjid.php"
                                                                    class="elementor-sub-item">Menara Masjid</a>
                                                            </li>
                                                            <li
                                                                class="menu-item menu-item-type-post_type menu-item-object-post menu-item-18277">
                                                                <a href="http://localhost/SIKUBAH/pages/menu/assesoris/lampu-gantung-masjid.php"
                                                                    class="elementor-sub-item">Lampu Gantung Masjid</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li
                                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-155">
                                                        <a href="http://localhost/SIKUBAH/pages/menu/harga.php"
                                                            class="elementor-item">Harga</a>
                                                    </li>
                                                    <!-- <li
                                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-5307">
                                                        <a href="http://localhost/SIKUBAH/pages/menu/video.php"
                                                            class="elementor-item">Video</a>
                                                    </li> -->
                                                    <li
                                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-17606">
                                                        <a href="http://localhost/SIKUBAH/pages/menu/kontak.php"
                                                            class="elementor-item">Kontak</a>
                                                    </li>
                                                    <li
                                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-153">
                                                        <a href="http://localhost/SIKUBAH/pages/menu/blog.php"
                                                            class="elementor-item">Blog</a>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="site grid-container container hfeed grid-parent" id="page">
        <div class="site-content" id="content">
            <div data-elementor-type="wp-page" data-elementor-id="20837" class="elementor elementor-20837"
                data-elementor-settings="[]">
                <div class="elementor-inner">
                    <div class="elementor-section-wrap">
                        <section
                            class="elementor-section elementor-top-section elementor-element elementor-element-446af0b elementor-section-content-middle elementor-section-boxed elementor-section-height-default elementor-section-height-default"
                            data-id="446af0b" data-element_type="section"
                            data-settings="{&quot;background_background&quot;:&quot;classic&quot;,&quot;animation&quot;:&quot;none&quot;}">
                            <div class="elementor-background-overlay"></div>
                            <div class="elementor-container elementor-column-gap-wide">
                                <div class="elementor-row">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-add91e8"
                                        data-id="add91e8" data-element_type="column">
                                        <div class="elementor-column-wrap elementor-element-populated">
                                            <div class="elementor-widget-wrap">
                                                <div class="elementor-element elementor-element-6e47e90 elementor-widget elementor-widget-spacer"
                                                    data-id="6e47e90" data-element_type="widget"
                                                    data-widget_type="spacer.default">
                                                    <div class="elementor-widget-container">
                                                        <div class="elementor-spacer">
                                                            <div class="elementor-spacer-inner"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <section
                                                    class="elementor-section elementor-inner-section elementor-element elementor-element-3c505df elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-invisible"
                                                    data-id="3c505df" data-element_type="section"
                                                    data-settings="{&quot;animation&quot;:&quot;fadeInUp&quot;,&quot;animation_delay&quot;:300}">
                                                    <div class="elementor-container elementor-column-gap-default">
                                                        <div class="elementor-row">
                                                            <div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-d52d130"
                                                                data-id="d52d130" data-element_type="column">
                                                                <div
                                                                    class="elementor-column-wrap elementor-element-populated">
                                                                    <div class="elementor-widget-wrap">
                                                                        <div class="elementor-element elementor-element-39be8bc elementor-widget-divider--view-line_text elementor-widget-divider--element-align-right elementor-hidden-phone elementor-widget elementor-widget-divider"
                                                                            data-id="39be8bc" data-element_type="widget"
                                                                            data-settings="{&quot;_animation&quot;:&quot;none&quot;}"
                                                                            data-widget_type="divider.default">
                                                                            <div class="elementor-widget-container">
                                                                                <div class="elementor-divider">
                                                                                    <span
                                                                                        class="elementor-divider-separator">
                                                                                        <span
                                                                                            class="elementor-divider__text elementor-divider__element">PKM</span>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="elementor-element elementor-element-cbc76ff elementor-widget-divider--view-line_text elementor-hidden-desktop elementor-hidden-tablet elementor-widget-divider--element-align-center elementor-widget elementor-widget-divider"
                                                                            data-id="cbc76ff" data-element_type="widget"
                                                                            data-settings="{&quot;_animation&quot;:&quot;none&quot;}"
                                                                            data-widget_type="divider.default">
                                                                            <div class="elementor-widget-container">
                                                                                <div class="elementor-divider">
                                                                                    <span
                                                                                        class="elementor-divider-separator">
                                                                                        <span
                                                                                            class="elementor-divider__text elementor-divider__element">PKM</span>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="elementor-element elementor-element-b080f68 elementor-widget elementor-widget-heading"
                                                                            data-id="b080f68" data-element_type="widget"
                                                                            data-widget_type="heading.default">
                                                                            <div class="elementor-widget-container">
                                                                                <h1
                                                                                    class="elementor-heading-title elementor-size-default">
                                                                                    Produsen Kubah Masjid</h1>
                                                                            </div>
                                                                        </div>
                                                                        <div class="elementor-element elementor-element-fe04910 elementor-widget elementor-widget-text-editor"
                                                                            data-id="fe04910" data-element_type="widget"
                                                                            data-widget_type="text-editor.default">
                                                                            <div class="elementor-widget-container">
                                                                                <div
                                                                                    class="elementor-text-editor elementor-clearfix">
                                                                                    <p>Jasa Kubah Harga urah, mitra terpercaya sebagai
                                                                                        penjual kubah masjid terdekat di
                                                                                        kota anda, menghadirkan desain
                                                                                        kubah yang kokoh dan estetis.
                                                                                    </p>
                                                                                    <p>Dikerjakan oleh tenaga ahli,
                                                                                        hasil pengerjaan rapi dan tepat
                                                                                        waktu.</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="elementor-element elementor-element-5a6ab02 elementor-align-left elementor-mobile-align-center elementor-widget elementor-widget-button"
                                                                            data-id="5a6ab02" data-element_type="widget"
                                                                            data-widget_type="button.default">
                                                                            <div class="elementor-widget-container">
                                                                                <div class="elementor-button-wrapper">
                                                                                    <a href="https://wa.me/6285188588596?text=Assalamualaikum%20PT%20KUBAH%20MANDIRI%20INDONESIA%2C%20mohon%20info%20kubahnya%3F"
                                                                                        class="elementor-button-link elementor-button elementor-size-lg elementor-animation-grow"
                                                                                        role="button" id="wa-generic" target="_blank">
                                                                                        <span
                                                                                            class="elementor-button-content-wrapper">
                                                                                            <span
                                                                                                class="elementor-button-text">HUBUNGI
                                                                                                KAMI</span>
                                                                                        </span>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-e983a09"
                                                                data-id="e983a09" data-element_type="column">
                                                                <div
                                                                    class="elementor-column-wrap elementor-element-populated">
                                                                    <div class="elementor-widget-wrap">
                                                                        <div class="elementor-element elementor-element-3d62411 elementor-widget elementor-widget-image"
                                                                            data-id="3d62411" data-element_type="widget"
                                                                            data-widget_type="image.default">
                                                                            <div class="elementor-widget-container">
                                                                                <div class="elementor-image">
                                                                                    <img decoding="async" width="510"
                                                                                        height="472"
                                                                                        src="./images/indexpertama.webp"
                                                                                        class="attachment-full size-full"
                                                                                        alt="jual kubah masjid" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section
                            class="elementor-section elementor-top-section elementor-element elementor-element-80c082e elementor-section-boxed elementor-section-height-default elementor-section-height-default"
                            data-id="80c082e" data-element_type="section"
                            data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                            <div class="elementor-background-overlay"></div>
                            <div class="elementor-container elementor-column-gap-wide">
                                <div class="elementor-row">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-8778020"
                                        data-id="8778020" data-element_type="column">
                                        <div class="elementor-column-wrap elementor-element-populated">
                                            <div class="elementor-widget-wrap">
                                                <section
                                                    class="elementor-section elementor-inner-section elementor-element elementor-element-c6631d8 elementor-reverse-mobile elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-invisible"
                                                    data-id="c6631d8" data-element_type="section"
                                                    data-settings="{&quot;background_background&quot;:&quot;gradient&quot;,&quot;animation&quot;:&quot;fadeInUp&quot;}">
                                                    <div class="elementor-background-overlay"></div>
                                                    <div class="elementor-container elementor-column-gap-no">
                                                        <div class="elementor-row">
                                                            <div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-1a7f64b"
                                                                data-id="1a7f64b" data-element_type="column">
                                                                <div
                                                                    class="elementor-column-wrap elementor-element-populated">
                                                                    <div class="elementor-widget-wrap">
                                                                        <div class="elementor-element elementor-element-3c23b1c elementor-widget elementor-widget-image"
                                                                            data-id="3c23b1c" data-element_type="widget"
                                                                            data-widget_type="image.default">
                                                                            <div class="elementor-widget-container">
                                                                                <div class="elementor-image">
                                                                                    <img decoding="async" width="314"
                                                                                        height="430"
                                                                                        src="https://www.jualkubahmasjid.id/wp-content/uploads/2025/07/jasa-pembuatan-kubah-masjid.webp"
                                                                                        class="attachment-large size-large"
                                                                                        alt="jasa pembuatan kubah masjid"
                                                                                        srcset="https://www.jualkubahmasjid.id/wp-content/uploads/2025/07/jasa-pembuatan-kubah-masjid.webp 314w, https://www.jualkubahmasjid.id/wp-content/uploads/2025/07/jasa-pembuatan-kubah-masjid-219x300.webp 219w"
                                                                                        sizes="(max-width: 314px) 100vw, 314px" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-578cd8e"
                                                                data-id="578cd8e" data-element_type="column">
                                                                <div
                                                                    class="elementor-column-wrap elementor-element-populated">
                                                                    <div class="elementor-widget-wrap">
                                                                        <div class="elementor-element elementor-element-3a03bcd elementor-widget elementor-widget-heading"
                                                                            data-id="3a03bcd" data-element_type="widget"
                                                                            data-widget_type="heading.default">
                                                                            <div class="elementor-widget-container">
                                                                                <p
                                                                                    class="elementor-heading-title elementor-size-default">
                                                                                    Anda pasti masih bingung bagaimana
                                                                                    cara menghitung diameter kubah
                                                                                    sehingga dapat diketahui berapa
                                                                                    harga kubah masjid per meter.






                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="elementor-element elementor-element-29a40de elementor-widget elementor-widget-heading"
                                                                            data-id="29a40de" data-element_type="widget"
                                                                            data-widget_type="heading.default">
                                                                            <div class="elementor-widget-container">
                                                                                <p
                                                                                    class="elementor-heading-title elementor-size-default">
                                                                                    Tenang, kami bantu menghitungkan
                                                                                    harganya</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="elementor-element elementor-element-e196afe elementor-widget elementor-widget-heading"
                                                                            data-id="e196afe" data-element_type="widget"
                                                                            data-widget_type="heading.default">
                                                                            <div class="elementor-widget-container">
                                                                                <p
                                                                                    class="elementor-heading-title elementor-size-default">
                                                                                    Mari kami jelaskan dengan klik
                                                                                    tombol di bawah ini</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="elementor-element elementor-element-ea19a84 elementor-align-center elementor-tablet-align-right elementor-mobile-align-center elementor-widget elementor-widget-button"
                                                                            data-id="ea19a84" data-element_type="widget"
                                                                            data-widget_type="button.default">
                                                                            <div class="elementor-widget-container">
                                                                                <div class="elementor-button-wrapper">
                                                                                    <a href="https://wa.me/6285188588596?text=Assalamualaikum%20PT%20KUBAH%20MANDIRI%20INDONESIA%2C%20mohon%20info%20kubahnya%3F"
                                                                                        class="elementor-button-link elementor-button elementor-size-md elementor-animation-grow"
                                                                                        role="button" id="wa-generic" target="_blank">
                                                                                        <span
                                                                                            class="elementor-button-content-wrapper">
                                                                                            <span
                                                                                                class="elementor-button-text">Hubungi
                                                                                                Kami</span>
                                                                                        </span>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <?php include __DIR__ . '/application/views/home/portfolio_section.php'; ?>

                        <section
                            class="elementor-section elementor-top-section elementor-element elementor-element-dd5a777 elementor-section-content-middle elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-invisible"
                            data-id="dd5a777" data-element_type="section"
                            data-settings="{&quot;background_background&quot;:&quot;classic&quot;,&quot;animation&quot;:&quot;fadeInUp&quot;}">
                            <div class="elementor-container elementor-column-gap-wide">
                                <div class="elementor-row">
                                    <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-7689e18"
                                        data-id="7689e18" data-element_type="column">
                                        <div class="elementor-column-wrap elementor-element-populated">
                                            <div class="elementor-widget-wrap">
                                                <div class="elementor-element elementor-element-acbdc60 elementor-widget elementor-widget-image"
                                                    data-id="acbdc60" data-element_type="widget"
                                                    data-widget_type="image.default">
                                                    <div class="elementor-widget-container">
                                                        <div class="elementor-image">
                                                            <img loading="lazy" decoding="async" width="659"
                                                                height="923"
                                                                src="https://www.jualkubahmasjid.id/wp-content/uploads/2025/07/jual-kubah-masjid-terdekat.webp"
                                                                class="attachment-full size-full"
                                                                alt="jual kubah masjid terdekat"
                                                                srcset="https://www.jualkubahmasjid.id/wp-content/uploads/2025/07/jual-kubah-masjid-terdekat.webp 659w, https://www.jualkubahmasjid.id/wp-content/uploads/2025/07/jual-kubah-masjid-terdekat-214x300.webp 214w"
                                                                sizes="auto, (max-width: 659px) 100vw, 659px" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-8e0960a"
                                        data-id="8e0960a" data-element_type="column">
                                        <div class="elementor-column-wrap elementor-element-populated">
                                            <div class="elementor-widget-wrap">
                                                <div class="elementor-element elementor-element-a434830 elementor-widget elementor-widget-heading"
                                                    data-id="a434830" data-element_type="widget"
                                                    data-widget_type="heading.default">
                                                    <div class="elementor-widget-container">
                                                        <p class="elementor-heading-title elementor-size-default">Inilah
                                                            Nilai Plus Jika Anda Memilih Kubah Masjid dari Kami</p>
                                                    </div>
                                                </div>
                                                <div class="elementor-element elementor-element-60a65c9 elementor-position-left elementor-vertical-align-middle elementor-widget elementor-widget-image-box"
                                                    data-id="60a65c9" data-element_type="widget"
                                                    data-widget_type="image-box.default">
                                                    <div class="elementor-widget-container">
                                                        <div class="elementor-image-box-wrapper">
                                                            <figure class="elementor-image-box-img"><img loading="lazy"
                                                                    decoding="async" width="74" height="57"
                                                                    src="https://www.jualkubahmasjid.id/wp-content/uploads/2023/03/001.png"
                                                                    class="attachment-full size-full" alt="" /></figure>
                                                            <div class="elementor-image-box-content">
                                                                <p class="elementor-image-box-description">Pengerjaan
                                                                    kubah selalu tepat waktu tanpa molor, karena
                                                                    kepercayaan anda prioritas kami.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="elementor-element elementor-element-ab8a5ad elementor-position-left elementor-vertical-align-middle elementor-widget elementor-widget-image-box"
                                                    data-id="ab8a5ad" data-element_type="widget"
                                                    data-widget_type="image-box.default">
                                                    <div class="elementor-widget-container">
                                                        <div class="elementor-image-box-wrapper">
                                                            <figure class="elementor-image-box-img"><img loading="lazy"
                                                                    decoding="async" width="74" height="57"
                                                                    src="https://www.jualkubahmasjid.id/wp-content/uploads/2023/03/02.png"
                                                                    class="attachment-full size-full" alt="" /></figure>
                                                            <div class="elementor-image-box-content">
                                                                <p class="elementor-image-box-description">Hemat hingga
                                                                    40% biaya perawatan akibat kebocoran, retak, dan
                                                                    warna pudar.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="elementor-element elementor-element-effe184 elementor-position-left elementor-vertical-align-middle elementor-widget elementor-widget-image-box"
                                                    data-id="effe184" data-element_type="widget"
                                                    data-widget_type="image-box.default">
                                                    <div class="elementor-widget-container">
                                                        <div class="elementor-image-box-wrapper">
                                                            <figure class="elementor-image-box-img"><img loading="lazy"
                                                                    decoding="async" width="74" height="57"
                                                                    src="https://www.jualkubahmasjid.id/wp-content/uploads/2023/03/03.png"
                                                                    class="attachment-full size-full" alt="" /></figure>
                                                            <div class="elementor-image-box-content">
                                                                <p class="elementor-image-box-description">Garansi warna
                                                                    kubah 20 tahun tetap memukau, solid, tak suram
                                                                    berkat lapisan enamel terbaik.”</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="elementor-element elementor-element-141d9aa elementor-position-left elementor-vertical-align-middle elementor-widget elementor-widget-image-box"
                                                    data-id="141d9aa" data-element_type="widget"
                                                    data-widget_type="image-box.default">
                                                    <div class="elementor-widget-container">
                                                        <div class="elementor-image-box-wrapper">
                                                            <figure class="elementor-image-box-img"><img loading="lazy"
                                                                    decoding="async" width="74" height="57"
                                                                    src="https://www.jualkubahmasjid.id/wp-content/uploads/2023/03/04.png"
                                                                    class="attachment-full size-full" alt="" /></figure>
                                                            <div class="elementor-image-box-content">
                                                                <p class="elementor-image-box-description">Rangka kubah
                                                                    masjid memakai pipa galvanis diameter 3 inchi tebal
                                                                    3 mm, pilihan kokoh dan awet untuk kubah masjid
                                                                    Anda.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="elementor-element elementor-element-aaa84aa elementor-position-left elementor-vertical-align-middle elementor-widget elementor-widget-image-box"
                                                    data-id="aaa84aa" data-element_type="widget"
                                                    data-widget_type="image-box.default">
                                                    <div class="elementor-widget-container">
                                                        <div class="elementor-image-box-wrapper">
                                                            <figure class="elementor-image-box-img"><img loading="lazy"
                                                                    decoding="async" width="74" height="57"
                                                                    src="https://www.jualkubahmasjid.id/wp-content/uploads/2023/03/05.png"
                                                                    class="attachment-full size-full" alt="" /></figure>
                                                            <div class="elementor-image-box-content">
                                                                <p class="elementor-image-box-description">Gratis
                                                                    konsultasi material kubah sesuai kondisi iklim
                                                                    lokasi masjid Anda agar hasilnya optimal.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section
                            class="elementor-section elementor-top-section elementor-element elementor-element-31b90b6 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
                            data-id="31b90b6" data-element_type="section"
                            data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                            <div class="elementor-container elementor-column-gap-default">
                                <div class="elementor-row">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-03a4163"
                                        data-id="03a4163" data-element_type="column">
                                        <div class="elementor-column-wrap elementor-element-populated">
                                            <div class="elementor-widget-wrap">
                                                <section
                                                    class="elementor-section elementor-inner-section elementor-element elementor-element-7942809 elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-invisible"
                                                    data-id="7942809" data-element_type="section"
                                                    data-settings="{&quot;background_background&quot;:&quot;classic&quot;,&quot;animation&quot;:&quot;fadeInUp&quot;}">
                                                    <div class="elementor-background-overlay"></div>
                                                    <div class="elementor-container elementor-column-gap-no">
                                                        <div class="elementor-row">
                                                            <div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-56e9085"
                                                                data-id="56e9085" data-element_type="column">
                                                                <div
                                                                    class="elementor-column-wrap elementor-element-populated">
                                                                    <div class="elementor-widget-wrap">
                                                                        <div class="elementor-element elementor-element-5d3e5ae elementor-widget elementor-widget-image"
                                                                            data-id="5d3e5ae" data-element_type="widget"
                                                                            data-widget_type="image.default">
                                                                            <div class="elementor-widget-container">
                                                                                <div class="elementor-image">
                                                                                    <img loading="lazy" decoding="async"
                                                                                        width="369" height="336"
                                                                                        src="https://www.jualkubahmasjid.id/wp-content/uploads/2023/03/garansi-20-tahun-min.png"
                                                                                        class="attachment-large size-large"
                                                                                        alt=""
                                                                                        srcset="https://www.jualkubahmasjid.id/wp-content/uploads/2023/03/garansi-20-tahun-min.png 369w, https://www.jualkubahmasjid.id/wp-content/uploads/2023/03/garansi-20-tahun-min-300x273.png 300w"
                                                                                        sizes="auto, (max-width: 369px) 100vw, 369px" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-05246a1"
                                                                data-id="05246a1" data-element_type="column">
                                                                <div
                                                                    class="elementor-column-wrap elementor-element-populated">
                                                                    <div class="elementor-widget-wrap">
                                                                        <div class="elementor-element elementor-element-4937542 elementor-widget elementor-widget-heading"
                                                                            data-id="4937542" data-element_type="widget"
                                                                            data-widget_type="heading.default">
                                                                            <div class="elementor-widget-container">
                                                                                <p
                                                                                    class="elementor-heading-title elementor-size-default">
                                                                                    Karena itu kami beri garansi
                                                                                    keretakan <br /><span>5 tahun</span>
                                                                                    & garansi warna mengkilap hingga
                                                                                    <span>20 tahun</span>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section
                            class="elementor-section elementor-top-section elementor-element elementor-element-b3fbef5 elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-invisible"
                            data-id="b3fbef5" data-element_type="section"
                            data-settings="{&quot;animation&quot;:&quot;fadeInUp&quot;,&quot;background_background&quot;:&quot;classic&quot;}">
                            <div class="elementor-container elementor-column-gap-wider">
                                <div class="elementor-row">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-dbe5767"
                                        data-id="dbe5767" data-element_type="column">
                                        <div class="elementor-column-wrap elementor-element-populated">
                                            <div class="elementor-widget-wrap">
                                                <div class="elementor-element elementor-element-80d6dbd elementor-widget elementor-widget-heading"
                                                    data-id="80d6dbd" data-element_type="widget"
                                                    data-settings="{&quot;_animation&quot;:&quot;none&quot;}"
                                                    data-widget_type="heading.default">
                                                    <div class="elementor-widget-container">
                                                        <p class="elementor-heading-title elementor-size-default">Produk
                                                            Kubah Kami</p>
                                                    </div>
                                                </div>
                                                <div class="elementor-element elementor-element-e1828d7 elementor-widget elementor-widget-heading"
                                                    data-id="e1828d7" data-element_type="widget"
                                                    data-widget_type="heading.default">
                                                    <div class="elementor-widget-container">
                                                        <p class="elementor-heading-title elementor-size-default">
                                                            Berikut ini beberapa produk kubah masjid yang kami sediakan
                                                            untuk Anda</p>
                                                    </div>
                                                </div>
                                                <section
                                                    class="elementor-section elementor-inner-section elementor-element elementor-element-aff5419 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
                                                    data-id="aff5419" data-element_type="section">
                                                    <div class="elementor-container elementor-column-gap-extended">
                                                        <div class="elementor-row">
                                                            <div class="elementor-column elementor-col-33 elementor-inner-column elementor-element elementor-element-cb1a970"
                                                                data-id="cb1a970" data-element_type="column">
                                                                <div
                                                                    class="elementor-column-wrap elementor-element-populated">
                                                                    <div class="elementor-widget-wrap">
                                                                        <div class="elementor-element elementor-element-841399c elementor-widget elementor-widget-image"
                                                                            data-id="841399c" data-element_type="widget"
                                                                            data-widget_type="image.default">
                                                                            <div class="elementor-widget-container">
                                                                                <div class="elementor-image">
                                                                                    <img decoding="async"
                                                                                        src="./images/bahan-enamel.webp"
                                                                                        title="" alt="" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="elementor-element elementor-element-42d6801 elementor-widget__width-auto elementor-widget elementor-widget-heading"
                                                                            data-id="42d6801" data-element_type="widget"
                                                                            data-widget_type="heading.default">
                                                                            <div class="elementor-widget-container">
                                                                                <p
                                                                                    class="elementor-heading-title elementor-size-default">
                                                                                    <a href="#"
                                                                                        target="_blank">Kubah Enamel</a>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="elementor-column elementor-col-33 elementor-inner-column elementor-element elementor-element-a99e54d"
                                                                data-id="a99e54d" data-element_type="column">
                                                                <div
                                                                    class="elementor-column-wrap elementor-element-populated">
                                                                    <div class="elementor-widget-wrap">
                                                                        <div class="elementor-element elementor-element-e5013e1 elementor-widget elementor-widget-image"
                                                                            data-id="e5013e1" data-element_type="widget"
                                                                            data-widget_type="image.default">
                                                                            <div class="elementor-widget-container">
                                                                                <div class="elementor-image">
                                                                                    <img loading="lazy" decoding="async"
                                                                                        width="600" height="600"
                                                                                        src="./images/bahan-galvalum.webp"
                                                                                        class="attachment-large size-large"
                                                                                        alt=""/>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="elementor-element elementor-element-fff3376 elementor-widget__width-auto elementor-widget elementor-widget-heading"
                                                                            data-id="fff3376" data-element_type="widget"
                                                                            data-widget_type="heading.default">
                                                                            <div class="elementor-widget-container">
                                                                                <p
                                                                                    class="elementor-heading-title elementor-size-default">
                                                                                    Kubah Galvalum</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="elementor-column elementor-col-33 elementor-inner-column elementor-element elementor-element-a6bd097"
                                                                data-id="a6bd097" data-element_type="column">
                                                                <div
                                                                    class="elementor-column-wrap elementor-element-populated">
                                                                    <div class="elementor-widget-wrap">
                                                                        <div class="elementor-element elementor-element-d1b3211 elementor-widget elementor-widget-image"
                                                                            data-id="d1b3211" data-element_type="widget"
                                                                            data-widget_type="image.default">
                                                                            <div class="elementor-widget-container">
                                                                                <div class="elementor-image">
                                                                                    <img loading="lazy" decoding="async"
                                                                                        width="581" height="581"
                                                                                        src="./images/bahan-stainlessgold.webp"
                                                                                        class="attachment-large size-large"
                                                                                        alt="" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="elementor-element elementor-element-a9a2ffb elementor-widget__width-auto elementor-widget elementor-widget-heading"
                                                                            data-id="a9a2ffb" data-element_type="widget"
                                                                            data-widget_type="heading.default">
                                                                            <div class="elementor-widget-container">
                                                                                <p
                                                                                    class="elementor-heading-title elementor-size-default">
                                                                                    <a href="#"
                                                                                        target="_blank">Kubah Stainless
                                                                                        Gold</a>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section
                            class="elementor-section elementor-top-section elementor-element elementor-element-9b5f0b8 elementor-reverse-mobile elementor-section-boxed elementor-section-height-default elementor-section-height-default"
                            data-id="9b5f0b8" data-element_type="section"
                            data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                            <div class="elementor-container elementor-column-gap-wider">
                                <div class="elementor-row">
                                    <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-eab2b50"
                                        data-id="eab2b50" data-element_type="column">
                                        <div class="elementor-column-wrap elementor-element-populated">
                                            <div class="elementor-widget-wrap">
                                                <div class="elementor-element elementor-element-a0f311a elementor-widget elementor-widget-heading"
                                                    data-id="a0f311a" data-element_type="widget"
                                                    data-widget_type="heading.default">
                                                    <div class="elementor-widget-container">
                                                        <h2 class="elementor-heading-title elementor-size-default">
                                                            Kalkulator Kubah Untuk Memperkirakan Harga Kubah Masjid</h2>
                                                    </div>
                                                </div>
                                                <div class="elementor-element elementor-element-5c36942 elementor-widget elementor-widget-html"
                                                    data-id="5c36942" data-element_type="widget"
                                                    data-widget_type="html.default">
                                                    <div class="elementor-widget-container">
                                                        <style>
                                                            #relatedar {
                                                                font-weight: 400;
                                                                font-family: "roboto" !important;
                                                                font-size: 16px;
                                                            }

                                                            #relatedar ul {
                                                                list-style: none;
                                                                padding: 0;
                                                                margin: 0;
                                                            }

                                                            #relatedar li {
                                                                padding-left: 1.5em;
                                                            }

                                                            #relatedar li:before {
                                                                content: "\f058";
                                                                /* FontAwesome Unicode */
                                                                font-family: "Font Awesome 5 Free" !important;
                                                                display: inline-block;
                                                                margin-left: -1.6em;
                                                                /* same as padding-left set on li */
                                                                width: 1.3em;
                                                                /* same as padding-left set on li */
                                                                color: #008fd7;
                                                            }

                                                            #relatedar a {
                                                                color: #444;
                                                                font-weight: 400;
                                                                font-family: "roboto" !important;
                                                            }

                                                            #relatedar a:hover {
                                                                color: #0172AA;
                                                            }

                                                            #relatedar h5 {
                                                                display: hidden !important;
                                                                line-height: 0;
                                                            }



                                                            @media screen and (max-width:1024px) {
                                                                #relatedar {
                                                                    font-size: 13px;
                                                                    margin-top: 30px;
                                                                }
                                                            }




                                                            #artikel h1,
                                                            #artikel h2,
                                                            #artikel h3,
                                                            #artikel h4 {
                                                                font-family: "exo" !important;
                                                                margin-top: 25px;
                                                            }

                                                            #artikel h2 {
                                                                font-size: 145%
                                                            }

                                                            #artikel h3 {
                                                                font-size: 125%
                                                            }

                                                            #artikel h4 {
                                                                font-size: 105%
                                                            }

                                                            #artikel a {
                                                                font-size: 92%;
                                                            }

                                                            #artikel blockquote {
                                                                font-size: 95%;
                                                            }


                                                            #ez-toc-container {
                                                                display: none;
                                                            }

                                                            .generate-back-to-top {
                                                                display: none;
                                                            }

                                                            .elementor-nav-menu--main a {
                                                                font-family: "exo" !important;
                                                                font-weight: 500 !important;
                                                            }
                                                        </style>
                                                    </div>
                                                </div>
                                                <div class="elementor-element elementor-element-118295d elementor-widget elementor-widget-text-editor"
                                                    data-id="118295d" data-element_type="widget"
                                                    data-widget_type="text-editor.default">
                                                    <div class="elementor-widget-container">
                                                        <div class="elementor-text-editor elementor-clearfix">
                                                            <p>Harga kubah masjid ditentukan dari <strong
                                                                    style="box-sizing: border-box;"><span
                                                                        style="font-family: Helvetica;">diameter</span></strong>
                                                                dan <strong style="box-sizing: border-box;"><span
                                                                        style="font-family: Helvetica;">tinggi</span></strong>
                                                                kubah. Silakan input diameter dan tinggi kubah yang anda
                                                                inginkan ke dalam isian di bawah ini:</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="elementor-element elementor-element-54f1843 elementor-widget elementor-widget-html"
                                                    data-id="54f1843" data-element_type="widget"
                                                    data-widget_type="html.default">
                                                    <div class="elementor-widget-container">
                                                        Diameter terbesar kubah (m) <br><input type="text" onkeyup="d()"
                                                            id="d" placeholder="Diameter terbesar kubah"> <br>Tinggi
                                                        kubah (m) <br><input type="text" onkeyup="t()" id="t"
                                                            placeholder="Tinggi kubah"> <br><button
                                                            id="tombolhitung">Hitung</button><br>
                                                        <table class="atas-3">
                                                            <thead>
                                                                <tr>
                                                                    <td>Jenis Bahan</td>
                                                                    <td>Perkiraan Harga</td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Enamel</td>
                                                                    <td id="enamel"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Galvalum</td>
                                                                    <td id="galvalum"></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="elementor-element elementor-element-ad9a1fd elementor-widget elementor-widget-text-editor"
                                                    data-id="ad9a1fd" data-element_type="widget"
                                                    data-widget_type="text-editor.default">
                                                    <div class="elementor-widget-container">
                                                        <div class="elementor-text-editor elementor-clearfix">
                                                            <p>Harga kubah di atas hanya perkiraan. Untuk tahu biaya
                                                                pembuatan kubah masjid yang lebih akurat, silakan
                                                                konsultasi gratis ke kami di <a
                                                                    href="https://wa.me/6285188588596?text=Assalamualaikum%20PT%20KUBAH%20MANDIRI%20INDONESIA%2C%20mohon%20info%20kubahnya%3F">+62
                                                                    851-8858-8596</a> (<strong>bisa dinego</strong>).
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-c4e1747"
                                        data-id="c4e1747" data-element_type="column">
                                        <div class="elementor-column-wrap elementor-element-populated">
                                            <div class="elementor-widget-wrap">
                                                <div class="elementor-element elementor-element-be21c7a elementor-invisible elementor-widget elementor-widget-image"
                                                    data-id="be21c7a" data-element_type="widget"
                                                    data-settings="{&quot;_animation&quot;:&quot;fadeInUp&quot;}"
                                                    data-widget_type="image.default">
                                                    <div class="elementor-widget-container">
                                                        <div class="elementor-image">
                                                            <img loading="lazy" decoding="async" width="1086"
                                                                height="1536"
                                                                src="https://www.jualkubahmasjid.id/wp-content/uploads/2025/07/pembuatan-kubah-masjid1.webp"
                                                                class="attachment-full size-full"
                                                                alt="jual kubah masjid"
                                                                srcset="https://www.jualkubahmasjid.id/wp-content/uploads/2025/07/pembuatan-kubah-masjid1.webp 1086w, https://www.jualkubahmasjid.id/wp-content/uploads/2025/07/pembuatan-kubah-masjid1-212x300.webp 212w, https://www.jualkubahmasjid.id/wp-content/uploads/2025/07/pembuatan-kubah-masjid1-724x1024.webp 724w, https://www.jualkubahmasjid.id/wp-content/uploads/2025/07/pembuatan-kubah-masjid1-768x1086.webp 768w"
                                                                sizes="auto, (max-width: 1086px) 100vw, 1086px" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section
                            class="elementor-section elementor-top-section elementor-element elementor-element-b340879 elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-invisible"
                            data-id="b340879" data-element_type="section"
                            data-settings="{&quot;animation&quot;:&quot;fadeInUp&quot;,&quot;background_background&quot;:&quot;classic&quot;}">
                            <div class="elementor-container elementor-column-gap-wider">
                                <div class="elementor-row">
                                    <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-7069200"
                                        data-id="7069200" data-element_type="column">
                                        <div class="elementor-column-wrap elementor-element-populated">
                                            <div class="elementor-widget-wrap">
                                                <div class="elementor-element elementor-element-c1c5460 elementor-widget elementor-widget-heading"
                                                    data-id="c1c5460" data-element_type="widget"
                                                    data-widget_type="heading.default">
                                                    <div class="elementor-widget-container">
                                                        <p class="elementor-heading-title elementor-size-default">
                                                            Tertarik Konsultasi?</p>
                                                    </div>
                                                </div>
                                                <div class="elementor-element elementor-element-a597aa2 elementor-widget elementor-widget-text-editor"
                                                    data-id="a597aa2" data-element_type="widget"
                                                    data-widget_type="text-editor.default">
                                                    <div class="elementor-widget-container">
                                                        <div class="elementor-text-editor elementor-clearfix">
                                                            <p>Konsultasi gratis. Jangan ragu berkonsultasi kepada kami.
                                                                Ajukan pertanyaan seputar penjualan kubah masjid.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="elementor-element elementor-element-0d6b74d elementor-align-left elementor-mobile-align-center elementor-widget elementor-widget-button"
                                                    data-id="0d6b74d" data-element_type="widget"
                                                    data-widget_type="button.default">
                                                    <div class="elementor-widget-container">
                                                        <div class="elementor-button-wrapper">
                                                            <a href="https://wa.me/6285188588596?text=Assalamualaikum%20PT%20KUBAH%20MANDIRI%20INDONESIA%2C%20mohon%20info%20kubahnya%3F"
                                                                class="elementor-button-link elementor-button elementor-size-md elementor-animation-grow"
                                                                role="button" id="wa-generic" target="_blank">
                                                                <span class="elementor-button-content-wrapper">
                                                                    <span class="elementor-button-text">HUBUNGI
                                                                        KAMI</span>
                                                                </span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="elementor-element elementor-element-70c4af8 elementor-widget elementor-widget-spacer"
                                                    data-id="70c4af8" data-element_type="widget"
                                                    data-widget_type="spacer.default">
                                                    <div class="elementor-widget-container">
                                                        <div class="elementor-spacer">
                                                            <div class="elementor-spacer-inner"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-a0867a2"
                                        data-id="a0867a2" data-element_type="column">
                                        <div class="elementor-column-wrap elementor-element-populated">
                                            <div class="elementor-widget-wrap">
                                                <div class="elementor-element elementor-element-65d63b6 elementor-widget elementor-widget-image"
                                                    data-id="65d63b6" data-element_type="widget"
                                                    data-widget_type="image.default">
                                                    <div class="elementor-widget-container">
                                                        <div class="elementor-image">
                                                            <img loading="lazy" decoding="async" width="600"
                                                                height="600"
                                                                src="https://www.jualkubahmasjid.id/wp-content/uploads/2025/07/kubah-masjid.webp"
                                                                class="attachment-full size-full" alt="kubah masjid"
                                                                srcset="https://www.jualkubahmasjid.id/wp-content/uploads/2025/07/kubah-masjid.webp 600w, https://www.jualkubahmasjid.id/wp-content/uploads/2025/07/kubah-masjid-300x300.webp 300w, https://www.jualkubahmasjid.id/wp-content/uploads/2025/07/kubah-masjid-150x150.webp 150w"
                                                                sizes="auto, (max-width: 600px) 100vw, 600px" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section
                            class="elementor-section elementor-top-section elementor-element elementor-element-6541113 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
                            data-id="6541113" data-element_type="section"
                            data-settings="{&quot;background_background&quot;:&quot;gradient&quot;,&quot;animation&quot;:&quot;none&quot;}">
                            <div class="elementor-background-overlay"></div>
                            <div class="elementor-container elementor-column-gap-wider">
                                <div class="elementor-row">
                                    <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-d041b25"
                                        data-id="d041b25" data-element_type="column">
                                        <div class="elementor-column-wrap elementor-element-populated">
                                            <div class="elementor-widget-wrap">
                                                <div class="elementor-element elementor-element-33b0710 elementor-invisible elementor-widget elementor-widget-html"
                                                    data-id="33b0710" data-element_type="widget"
                                                    data-settings="{&quot;_animation&quot;:&quot;fadeInUp&quot;}"
                                                    data-widget_type="html.default">
                                                    <div class="elementor-widget-container">
                                                        <iframe
                                                            src="https://www.google.com/maps?q=-8.13276834379213,111.6860444625708&hl=id&z=17&output=embed"
                                                            width="800" height="550" style="border:0;margin-bottom:-8px"
                                                            allowfullscreen="" loading="lazy"
                                                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-151443e"
                                        data-id="151443e" data-element_type="column"
                                        data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                                        <div class="elementor-column-wrap elementor-element-populated">
                                            <div class="elementor-widget-wrap">
                                                <div class="elementor-element elementor-element-f40bfda elementor-widget-divider--view-line_text elementor-widget-divider--element-align-right elementor-widget elementor-widget-divider"
                                                    data-id="f40bfda" data-element_type="widget"
                                                    data-widget_type="divider.default">
                                                    <div class="elementor-widget-container">
                                                        <div class="elementor-divider">
                                                            <span class="elementor-divider-separator">
                                                                <span
                                                                    class="elementor-divider__text elementor-divider__element">ALAMAT
                                                                    KAMI</span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="elementor-element elementor-element-a063228 elementor-widget elementor-widget-heading"
                                                    data-id="a063228" data-element_type="widget"
                                                    data-widget_type="heading.default">
                                                    <div class="elementor-widget-container">
                                                        <p class="elementor-heading-title elementor-size-default">PT KUBAH MANDIRI INDONESIA</p>
                                                    </div>
                                                </div>
                                                <div class="elementor-element elementor-element-ac37aff elementor-widget elementor-widget-text-editor"
                                                    data-id="ac37aff" data-element_type="widget"
                                                    data-widget_type="text-editor.default">
                                                    <div class="elementor-widget-container">
                                                        <div class="elementor-text-editor elementor-clearfix">
                                                            <p>Silakan kunjungi kantor dan workshop kami di :</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="elementor-element elementor-element-72c654f elementor-align-left elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list"
                                                    data-id="72c654f" data-element_type="widget"
                                                    data-widget_type="icon-list.default">
                                                    <div class="elementor-widget-container">
                                                        <ul class="elementor-icon-list-items">
                                                            <li class="elementor-icon-list-item">
                                                                <span class="elementor-icon-list-text">Jln. Poros Sukorejo,
                                                                    Nglayur, Sukorejo, Gandusari, Trenggalek, Jawa Timur Indonesia</span>
                                                            </li>
                                                            <li class="elementor-icon-list-item">
                                                                <span class="elementor-icon-list-icon">
                                                                    <i aria-hidden="true"
                                                                        class="fas fa-chevron-circle-right"></i> </span>
                                                                <span class="elementor-icon-list-text"><b> &#160;+62
                                                                        851-6861-3452</b></span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- <section
                            class="elementor-section elementor-top-section elementor-element elementor-element-28cb6e6 elementor-reverse-mobile elementor-section-boxed elementor-section-height-default elementor-section-height-default"
                            data-id="28cb6e6" data-element_type="section"
                            data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                            <div class="elementor-container elementor-column-gap-wider">
                                <div class="elementor-row">
                                    <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-7ab73ee"
                                        data-id="7ab73ee" data-element_type="column">
                                        <div class="elementor-column-wrap elementor-element-populated">
                                            <div class="elementor-widget-wrap">
                                                <div class="elementor-element elementor-element-7048404 elementor-widget elementor-widget-heading"
                                                    data-id="7048404" data-element_type="widget"
                                                    data-widget_type="heading.default">
                                                    <div class="elementor-widget-container">
                                                        <p class="elementor-heading-title elementor-size-default">
                                                            Artikel Bermanfaat Lainnya</p>
                                                    </div>
                                                </div>
                                                <div class="elementor-element elementor-element-64d436d elementor-widget elementor-widget-html"
                                                    data-id="64d436d" data-element_type="widget"
                                                    data-widget_type="html.default">
                                                    <div class="elementor-widget-container">
                                                        <style>
                                                            #relatedar {
                                                                font-weight: 400;
                                                                font-family: "roboto" !important;
                                                                font-size: 16px;
                                                            }

                                                            #relatedar ul {
                                                                list-style: none;
                                                                padding: 0;
                                                                margin: 0;
                                                            }

                                                            #relatedar li {
                                                                padding-left: 1.5em;
                                                            }

                                                            #relatedar li:before {
                                                                content: "\f058";
                                                                /* FontAwesome Unicode */
                                                                font-family: "Font Awesome 5 Free" !important;
                                                                display: inline-block;
                                                                margin-left: -1.6em;
                                                                /* same as padding-left set on li */
                                                                width: 1.3em;
                                                                /* same as padding-left set on li */
                                                                color: #008fd7;
                                                            }

                                                            #relatedar a {
                                                                color: #444;
                                                                font-weight: 400;
                                                                font-family: "roboto" !important;
                                                            }

                                                            #relatedar a:hover {
                                                                color: #0172AA;
                                                            }

                                                            #relatedar h5 {
                                                                display: hidden !important;
                                                                line-height: 0;
                                                            }



                                                            @media screen and (max-width:1024px) {
                                                                #relatedar {
                                                                    font-size: 13px;
                                                                    margin-top: 30px;
                                                                }
                                                            }




                                                            #artikel h1,
                                                            #artikel h2,
                                                            #artikel h3,
                                                            #artikel h4 {
                                                                font-family: "exo" !important;
                                                                margin-top: 25px;
                                                            }

                                                            #artikel h2 {
                                                                font-size: 145%
                                                            }

                                                            #artikel h3 {
                                                                font-size: 125%
                                                            }

                                                            #artikel h4 {
                                                                font-size: 105%
                                                            }

                                                            #artikel a {
                                                                font-size: 92%;
                                                            }

                                                            #artikel blockquote {
                                                                font-size: 95%;
                                                            }


                                                            #ez-toc-container {
                                                                display: none;
                                                            }

                                                            .generate-back-to-top {
                                                                display: none;
                                                            }

                                                            .elementor-nav-menu--main a {
                                                                font-family: "exo" !important;
                                                                font-weight: 500 !important;
                                                            }
                                                        </style>
                                                    </div>
                                                </div>
                                                <div class="elementor-element elementor-element-82457d2 elementor-widget elementor-widget-wp-widget-recent-posts"
                                                    data-id="82457d2" data-element_type="widget"
                                                    data-widget_type="wp-widget-recent-posts.default">
                                                    <div class="elementor-widget-container">


                                                        <h5>Recent Posts</h5>
                                                        <ul>
                                                            <li>
                                                                <a
                                                                    href="https://www.jualkubahmasjid.id/masjid-pusdai-bandung/">Mengintip
                                                                    Desain Ikonik Masjid PUSDAI Bandung Jawa Barat</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    href="https://www.jualkubahmasjid.id/masjid-raya-al-muttaqin-bogor/">Fasilitas
                                                                    dan Kegiatan di Masjid Raya Al Muttaqin Bogor</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    href="https://www.jualkubahmasjid.id/masjid-nurani-kranji/">Megahnya
                                                                    Masjid Nurani Kranji Perpaduan Modern dan
                                                                    Spanyol</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    href="https://www.jualkubahmasjid.id/masjid-raya-raudhatul-irfan/">Pesona
                                                                    Arsitektur Masjid Raya Raudhatul Irfan Sukabumi</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    href="https://www.jualkubahmasjid.id/masjid-agung-kalianda/">Pesona
                                                                    Masjid Agung Kalianda Ikon Megah Lampung Selatan</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    href="https://www.jualkubahmasjid.id/nama-nama-masjid-yang-bagus/">90
                                                                    Daftar Nama-Nama Masjid yang Bagus dan Maknanya</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    href="https://www.jualkubahmasjid.id/masjid-terdekat/">Cara
                                                                    Cepat Cari Masjid Terdekat Agar Ibadah Tetap
                                                                    Lancar</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    href="https://www.jualkubahmasjid.id/jual-kubah-masjid-donggala/">Jual
                                                                    Kubah Masjid Donggala Harga Pabrik Termurah
                                                                    Bergaransi</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    href="https://www.jualkubahmasjid.id/jasa-pembuatan-kubah-enamel-dan-galvalum-di-parigi-moutong/">Jual
                                                                    Kubah Masjid Parigi Moutong Desain Mewah Tahan
                                                                    Gempa</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    href="https://www.jualkubahmasjid.id/anugerah-kubah-penjual-kubah-masjid-terbaik-di-palu/">Jual
                                                                    Kubah Masjid Palu Garansi 20 Tahun Warna Anti
                                                                    Pudar</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    href="https://www.jualkubahmasjid.id/jual-kubah-masjid-di-pangkalpinang-ahli-enamel-dan-galvalum-harga-murah/">Jual
                                                                    Kubah Masjid Pangkalpinang Garansi 20 Tahun Pasti
                                                                    Aman</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    href="https://www.jualkubahmasjid.id/penjual-kubah-masjid-di-kab-aceh-besar-garansi-warna-20-th/">Jual
                                                                    Kubah Masjid Aceh Besar Desain Mewah Harga
                                                                    Pabrik</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    href="https://www.jualkubahmasjid.id/jasa-pembuat-dan-penjual-kubah-masjid-di-kab-aceh-timur/">Jual
                                                                    Kubah Masjid Idi Rayeuk Harga Pabrik Desain
                                                                    Modern</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    href="https://www.jualkubahmasjid.id/penjual-kubah-masjid-enamel-dan-galvalum-di-kab-pidie/">Jual
                                                                    Kubah Masjid Pidie Terpercaya Ratusan Proyek
                                                                    Sukses</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    href="https://www.jualkubahmasjid.id/pembuat-dan-penjual-kubah-masjid-di-bireuen-aceh-bergaransi/">Jual
                                                                    Kubah Masjid Bireuen Spek Mewah Pengerjaan Cepat</a>
                                                            </li>
                                                        </ul>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-3d5ffdb"
                                        data-id="3d5ffdb" data-element_type="column">
                                        <div class="elementor-column-wrap elementor-element-populated">
                                            <div class="elementor-widget-wrap">
                                                <div class="elementor-element elementor-element-8cee626 elementor-invisible elementor-widget elementor-widget-image"
                                                    data-id="8cee626" data-element_type="widget"
                                                    data-settings="{&quot;_animation&quot;:&quot;fadeInUp&quot;}"
                                                    data-widget_type="image.default">
                                                    <div class="elementor-widget-container">
                                                        <div class="elementor-image">
                                                            <img loading="lazy" decoding="async" width="600"
                                                                height="720"
                                                                src="https://www.jualkubahmasjid.id/wp-content/uploads/2025/07/penjual-kubah-masjid-terdekat.webp"
                                                                class="attachment-full size-full" alt=""
                                                                srcset="https://www.jualkubahmasjid.id/wp-content/uploads/2025/07/penjual-kubah-masjid-terdekat.webp 600w, https://www.jualkubahmasjid.id/wp-content/uploads/2025/07/penjual-kubah-masjid-terdekat-250x300.webp 250w"
                                                                sizes="auto, (max-width: 600px) 100vw, 600px" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section> -->
                        <section
                            class="elementor-section elementor-top-section elementor-element elementor-element-d3a2500 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
                            data-id="d3a2500" data-element_type="section"
                            data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                            <div class="elementor-container elementor-column-gap-default">
                                <div class="elementor-row">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-3a279f6 elementor-invisible"
                                        data-id="3a279f6" data-element_type="column"
                                        data-settings="{&quot;animation&quot;:&quot;fadeInUp&quot;}">
                                        <div class="elementor-column-wrap elementor-element-populated">
                                            <div class="elementor-widget-wrap">
                                                <div class="elementor-element elementor-element-b0e572b elementor-widget elementor-widget-heading"
                                                    data-id="b0e572b" data-element_type="widget"
                                                    data-widget_type="heading.default">
                                                    <div class="elementor-widget-container">
                                                        <h2 class="elementor-heading-title elementor-size-default">
                                                            Mengapa Qoobah Layak Jadi Pilihan Utama sebagai Penjual
                                                            Kubah Masjid?</h2>
                                                    </div>
                                                </div>
                                                <div class="elementor-element elementor-element-5f451ba elementor-widget elementor-widget-image"
                                                    data-id="5f451ba" data-element_type="widget"
                                                    data-widget_type="image.default">
                                                    <div class="elementor-widget-container">
                                                        <div class="elementor-image">
                                                            <img loading="lazy" decoding="async" width="717"
                                                                height="473"
                                                                src="https://www.jualkubahmasjid.id/wp-content/uploads/2020/01/kubah-tumpuk-min.png"
                                                                class="attachment-large size-large"
                                                                alt="kontraktor kubah masjid"
                                                                srcset="https://www.jualkubahmasjid.id/wp-content/uploads/2020/01/kubah-tumpuk-min.png 717w, https://www.jualkubahmasjid.id/wp-content/uploads/2020/01/kubah-tumpuk-min-300x198.png 300w, https://www.jualkubahmasjid.id/wp-content/uploads/2020/01/kubah-tumpuk-min-400x264.png 400w, https://www.jualkubahmasjid.id/wp-content/uploads/2020/01/kubah-tumpuk-min-430x284.png 430w, https://www.jualkubahmasjid.id/wp-content/uploads/2020/01/kubah-tumpuk-min-150x99.png 150w, https://www.jualkubahmasjid.id/wp-content/uploads/2020/01/kubah-tumpuk-min-100x66.png 100w"
                                                                sizes="auto, (max-width: 717px) 100vw, 717px" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="elementor-element elementor-element-ed17b00 elementor-widget elementor-widget-text-editor"
                                                    data-id="ed17b00" data-element_type="widget"
                                                    data-widget_type="text-editor.default">
                                                    <div class="elementor-widget-container">
                                                        <div class="elementor-text-editor elementor-clearfix">
                                                            <p style="text-align: left;">Mencari penjual kubah masjid
                                                                yang benar-benar berpengalaman dan profesional tentu
                                                                menjadi prioritas bagi panitia pembangunan masjid.</p>
                                                            <p style="text-align: left;">Qoobah hadir memberikan solusi
                                                                terbaik bagi anda yang menginginkan kubah masjid
                                                                berkualitas tinggi, desain eksklusif, serta pengerjaan
                                                                tepat waktu.</p>
                                                            <p style="text-align: left;">Dengan rekam jejak yang jelas
                                                                dan portofolio yang tersebar di berbagai daerah, Qoobah
                                                                pantas menjadi pilihan utama.</p>
                                                            <h3 style="text-align: left;"><strong>Reputasi Terpercaya
                                                                    Sebagai Pembuat Kubah Masjid</strong></h3>
                                                            <h3 style="padding-left: 40px; text-align: left;"><strong>a.
                                                                    Pengalaman menangani ratusan proyek</strong></h3>
                                                            <p style="padding-left: 40px; text-align: left;">Qoobah
                                                                telah mengerjakan ratusan proyek kubah masjid di
                                                                berbagai kota besar dan pelosok daerah di Indonesia.
                                                                Setiap proyek dikerjakan dengan standar tinggi, baik
                                                                dari sisi teknis maupun estetika.</p>
                                                            <p style="padding-left: 40px; text-align: left;">Tim yang
                                                                berpengalaman memastikan setiap pekerjaan dilakukan
                                                                sesuai spesifikasi dan harapan klien.</p>
                                                            <h3 style="padding-left: 40px; text-align: left;"><strong>b.
                                                                    Komitmen terhadap kepuasan pelanggan</strong></h3>
                                                            <p style="padding-left: 40px; text-align: left;">Kepuasan
                                                                pelanggan adalah prioritas utama Qoobah. Setiap detail
                                                                proyek dipastikan berjalan sesuai rencana, mulai dari
                                                                desain awal, pemilihan material, hingga proses
                                                                instalasi.</p>
                                                            <p style="padding-left: 40px; text-align: left;">Dukungan
                                                                layanan purna jual juga menjadi bukti nyata bahwa Qoobah
                                                                menjaga hubungan jangka panjang dengan setiap mitra
                                                                pembangunan masjid.</p>
                                                            <h2 style="text-align: left;"><strong>Ragam Pilihan Material
                                                                    Kubah Masjid Berkualitas</strong></h2>
                                                            <h3 style="padding-left: 40px; text-align: left;"><strong>a.
                                                                    Kubah galvalum untuk efisiensi dan
                                                                    keindahan</strong></h3>
                                                            <p style="padding-left: 40px; text-align: left;">Material
                                                                galvalum menjadi pilihan populer karena bobotnya yang
                                                                ringan serta tampilan yang modern.</p>
                                                            <p style="padding-left: 40px; text-align: left;">Qoobah
                                                                menyediakan berbagai opsi desain dan warna yang dapat
                                                                disesuaikan dengan arsitektur masjid, menjadikan kubah
                                                                galvalum sebagai solusi ekonomis dan menarik.</p>
                                                            <h3 style="padding-left: 40px; text-align: left;"><strong>b.
                                                                    Kubah enamel infinith dengan estetika
                                                                    premium</strong></h3>
                                                            <p style="padding-left: 40px; text-align: left;">Kubah
                                                                enamel dikenal karena kualitas visualnya yang cemerlang
                                                                dan proses finishing yang presisi. Qoobah memproduksi
                                                                kubah enamel dengan teknologi tinggi dan standar
                                                                produksi terbaik, menjadikan tampilannya mengkilap serta
                                                                mudah dirawat.</p>
                                                            <p style="padding-left: 40px; text-align: left;">Informasi
                                                                mengenai harga kubah enamel per m2 juga transparan dan
                                                                dapat dikonsultasikan langsung kepada tim sales kami.
                                                            </p>
                                                            <h3 style="padding-left: 40px; text-align: left;"><strong>c.
                                                                    Kubah stainless gold yang elegan dan
                                                                    eksklusif</strong></h3>
                                                            <p style="padding-left: 40px; text-align: left;">Untuk
                                                                masjid dengan konsep arsitektur megah, kubah stainless
                                                                gold menjadi pilihan favorit. Lapisan warna keemasan
                                                                memberikan kesan mewah dan elegan. Material ini juga
                                                                memiliki karakteristik yang kokoh terhadap perubahan
                                                                cuaca serta tidak mudah mengalami perubahan warna.</p>
                                                            <h2 style="text-align: left;"><strong>Proses Produksi yang
                                                                    Profesional dan Terstandar</strong></h2>
                                                            <h3 style="padding-left: 40px; text-align: left;"><strong>a.
                                                                    Desain custom sesuai kebutuhan</strong></h3>
                                                            <p style="padding-left: 40px; text-align: left;">Setiap
                                                                masjid memiliki karakteristik unik. Oleh karena itu,
                                                                Qoobah menyediakan layanan desain kubah yang disesuaikan
                                                                dengan permintaan klien. Mulai dari bentuk, warna,
                                                                hingga ornamen, semua dirancang untuk menyatu dengan
                                                                bangunan utama masjid.</p>
                                                            <h3 style="padding-left: 40px; text-align: left;"><strong>b.
                                                                    Pengerjaan presisi di pabrik milik sendiri</strong>
                                                            </h3>
                                                            <p style="padding-left: 40px; text-align: left;">Dengan
                                                                fasilitas produksi yang lengkap, semua komponen kubah
                                                                dibuat langsung oleh tim teknis Qoobah. Proses fabrikasi
                                                                dilakukan secara presisi menggunakan mesin-mesin modern
                                                                dan tenaga kerja terlatih, sehingga hasil akhirnya
                                                                sesuai dengan rencana gambar teknis.</p>
                                                            <h2 style="text-align: left;"><strong>Harga Kompetitif dan
                                                                    Penawaran Transparan</strong></h2>
                                                            <h3 style="padding-left: 40px; text-align: left;"><strong>a.
                                                                    Estimasi Harga yang Sesuai Kebutuhan</strong></h3>
                                                            <p style="padding-left: 40px; text-align: left;">Qoobah
                                                                memberikan estimasi harga yang jujur dan sesuai dengan
                                                                jenis kubah yang dipilih. Mulai dari kubah galvalum
                                                                hingga enamel dan stainless gold, semua ditawarkan
                                                                dengan skema harga yang kompetitif dan transparan.</p>
                                                            <p style="padding-left: 40px; text-align: left;">Informasi
                                                                mengenai harga
                                                                kubah enamel per m2</a> serta material lainnya dapat
                                                                dikonsultasikan secara langsung untuk mendapatkan
                                                                penawaran terbaik.</p>
                                                            <h3 style="padding-left: 40px; text-align: left;"><strong>b.
                                                                    Solusi Anggaran dan Konsultasi Gratis</strong></h3>
                                                            <p style="padding-left: 40px; text-align: left;">Qoobah juga
                                                                siap memberikan masukan terbaik bagi panitia pembangunan
                                                                masjid yang memiliki batas anggaran tertentu. Tim kami
                                                                akan membantu menentukan material dan desain yang tepat
                                                                agar tetap berkualitas tanpa mengorbankan anggaran yang
                                                                tersedia.</p>
                                                            <h2 style="text-align: left;"><strong>Layanan dan Jangkauan
                                                                    Qoobah yang Luas</strong></h2>
                                                            <h3 style="padding-left: 40px; text-align: left;"><strong>a.
                                                                    Siap Menjangkau Berbagai Kota di Indonesia</strong>
                                                            </h3>
                                                            <p style="padding-left: 40px; text-align: left;">Qoobah
                                                                telah mengirimkan dan memasang kubah masjid ke berbagai
                                                                wilayah Indonesia. Mulai dari Sumatera, Jawa,
                                                                Kalimantan, hingga Sulawesi.</p>
                                                            <p style="padding-left: 40px; text-align: left;">Anda yang
                                                                sedang mencari penjual kubah masjid terdekat di kota
                                                                anda juga bisa menghubungi tim kami untuk jadwal survei
                                                                lokasi.</p>
                                                            <h3 style="padding-left: 40px; text-align: left;"><strong>b.
                                                                    Tim Ahli Siap Kunjungan Lapangan</strong></h3>
                                                            <p style="padding-left: 40px; text-align: left;">Kami
                                                                memiliki tim teknis dan arsitek yang dapat melakukan
                                                                kunjungan langsung ke lokasi pembangunan masjid. Hal ini
                                                                dilakukan untuk memastikan semua aspek struktur,
                                                                pondasi, dan kebutuhan bangunan diperhitungkan secara
                                                                cermat sebelum proses produksi dimulai.</p>
                                                            <h2 style="text-align: left;"><strong>Pilihan Terbaik untuk
                                                                    Kubah Masjid Anda</strong></h2>
                                                            <p style="text-align: left;">Dengan pengalaman panjang,
                                                                kualitas material unggulan, desain yang dapat
                                                                disesuaikan, serta layanan profesional dari awal hingga
                                                                akhir proyek, Qoobah adalah mitra terbaik dalam
                                                                pembangunan kubah masjid.</p>
                                                            <p style="text-align: left;">Jika anda sedang mencari
                                                                penjual kubah masjid yang profesional, segera hubungi
                                                                tim kami dan konsultasikan kebutuhan anda. Dapatkan
                                                                informasi lengkap tentang desain, material, serta
                                                                estimasi harga kubah enamel per m2 dan jenis kubah
                                                                lainnya secara langsung dari konsultan kami.</p>
                                                            <p style="text-align: left;">Qoobah siap membantu anda
                                                                mewujudkan kubah masjid yang megah dan indah dipandang,
                                                                sesuai impian jamaah dan identitas masjid anda. Hubungi
                                                                tim sales kami di <strong>+62 851-8858-8596</strong>
                                                                untuk konsultasi langsung.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="elementor-element elementor-element-9693364 elementor-toc--minimized-on-tablet elementor-widget elementor-widget-table-of-contents"
                                                    data-id="9693364" data-element_type="widget"
                                                    data-settings="{&quot;exclude_headings_by_selector&quot;:&quot;.eae-tl-item-title&quot;,&quot;headings_by_tags&quot;:[&quot;h2&quot;,&quot;h3&quot;,&quot;h4&quot;,&quot;h5&quot;,&quot;h6&quot;],&quot;marker_view&quot;:&quot;numbers&quot;,&quot;minimize_box&quot;:&quot;yes&quot;,&quot;minimized_on&quot;:&quot;tablet&quot;,&quot;hierarchical_view&quot;:&quot;yes&quot;,&quot;min_height&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;min_height_tablet&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;min_height_mobile&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]}}"
                                                    data-widget_type="table-of-contents.default">
                                                    <div class="elementor-widget-container">
                                                        <div class="elementor-toc__header">
                                                            <h4 class="elementor-toc__header-title">Daftar Isi:</h4>
                                                            <div
                                                                class="elementor-toc__toggle-button elementor-toc__toggle-button--expand">
                                                                <i class="fas fa-chevron-down"></i>
                                                            </div>
                                                            <div
                                                                class="elementor-toc__toggle-button elementor-toc__toggle-button--collapse">
                                                                <i class="fas fa-chevron-up"></i>
                                                            </div>
                                                        </div>
                                                        <div class="elementor-toc__body">
                                                            <div class="elementor-toc__spinner-container">
                                                                <i class="elementor-toc__spinner eicon-loading eicon-animation-spin"
                                                                    aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- <section
                            class="elementor-section elementor-top-section elementor-element elementor-element-405dac9 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
                            data-id="405dac9" data-element_type="section"
                            data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                            <div class="elementor-container elementor-column-gap-default">
                                <div class="elementor-row">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-5b35ed8"
                                        data-id="5b35ed8" data-element_type="column">
                                        <div class="elementor-column-wrap elementor-element-populated">
                                            <div class="elementor-widget-wrap">
                                                <div class="elementor-element elementor-element-4a83147 elementor-widget__width-initial elementor-widget elementor-widget-heading"
                                                    data-id="4a83147" data-element_type="widget"
                                                    data-widget_type="heading.default">
                                                    <div class="elementor-widget-container">
                                                        <h2 class="elementor-heading-title elementor-size-default">
                                                            Berita terbaru</h2>
                                                    </div>
                                                </div>
                                                <div class="elementor-element elementor-element-1f7ad7e list-blog elementor-widget elementor-widget-wp-widget-recent-posts"
                                                    data-id="1f7ad7e" data-element_type="widget"
                                                    data-widget_type="wp-widget-recent-posts.default">
                                                    <div class="elementor-widget-container">


                                                        <h5>Artikel Bermanfaat Lainnya</h5>
                                                        <ul>
                                                            <li>
                                                                <a
                                                                    href="https://www.jualkubahmasjid.id/masjid-pusdai-bandung/">Mengintip
                                                                    Desain Ikonik Masjid PUSDAI Bandung Jawa Barat</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    href="https://www.jualkubahmasjid.id/masjid-raya-al-muttaqin-bogor/">Fasilitas
                                                                    dan Kegiatan di Masjid Raya Al Muttaqin Bogor</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    href="https://www.jualkubahmasjid.id/masjid-nurani-kranji/">Megahnya
                                                                    Masjid Nurani Kranji Perpaduan Modern dan
                                                                    Spanyol</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    href="https://www.jualkubahmasjid.id/masjid-raya-raudhatul-irfan/">Pesona
                                                                    Arsitektur Masjid Raya Raudhatul Irfan Sukabumi</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    href="https://www.jualkubahmasjid.id/masjid-agung-kalianda/">Pesona
                                                                    Masjid Agung Kalianda Ikon Megah Lampung Selatan</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    href="https://www.jualkubahmasjid.id/nama-nama-masjid-yang-bagus/">90
                                                                    Daftar Nama-Nama Masjid yang Bagus dan Maknanya</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    href="https://www.jualkubahmasjid.id/masjid-terdekat/">Cara
                                                                    Cepat Cari Masjid Terdekat Agar Ibadah Tetap
                                                                    Lancar</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    href="https://www.jualkubahmasjid.id/jual-kubah-masjid-donggala/">Jual
                                                                    Kubah Masjid Donggala Harga Pabrik Termurah
                                                                    Bergaransi</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    href="https://www.jualkubahmasjid.id/jasa-pembuatan-kubah-enamel-dan-galvalum-di-parigi-moutong/">Jual
                                                                    Kubah Masjid Parigi Moutong Desain Mewah Tahan
                                                                    Gempa</a>
                                                            </li>
                                                            <li>
                                                                <a
                                                                    href="https://www.jualkubahmasjid.id/anugerah-kubah-penjual-kubah-masjid-terbaik-di-palu/">Jual
                                                                    Kubah Masjid Palu Garansi 20 Tahun Warna Anti
                                                                    Pudar</a>
                                                            </li>
                                                        </ul>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section> -->
                    </div>
                </div>
            </div>

        </div>
    </div>


    <div class="site-footer">
        <div data-elementor-type="footer" data-elementor-id="4522"
            class="elementor elementor-4522 elementor-location-footer" data-elementor-settings="[]">
            <div class="elementor-section-wrap">
                <section
                    class="elementor-section elementor-top-section elementor-element elementor-element-76459804 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
                    data-id="76459804" data-element_type="section"
                    data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                    <div class="elementor-container elementor-column-gap-default">
                        <div class="elementor-row">
                            <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-230081a8"
                                data-id="230081a8" data-element_type="column">
                                <div class="elementor-column-wrap elementor-element-populated">
                                    <div class="elementor-widget-wrap">
                                        <div class="elementor-element elementor-element-16bbe883 elementor-widget elementor-widget-heading"
                                            data-id="16bbe883" data-element_type="widget"
                                            data-widget_type="heading.default">
                                            <div class="elementor-widget-container">
                                                <p class="elementor-heading-title elementor-size-default">©
                                                    PT KUBAH MANDIRI INDONESIA - All rights reserved</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-153e7792"
                                data-id="153e7792" data-element_type="column">
                                <div class="elementor-column-wrap elementor-element-populated">
                                    <div class="elementor-widget-wrap">
                                        <div class="elementor-element elementor-element-6aa9e778 elementor-icon-list--layout-inline elementor-align-right elementor-mobile-align-center elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list"
                                            data-id="6aa9e778" data-element_type="widget"
                                            data-widget_type="icon-list.default">
                                            <div class="elementor-widget-container">
                                                <ul class="elementor-icon-list-items elementor-inline-items">
                                                    <li class="elementor-icon-list-item elementor-inline-item">
                                                        <span class="elementor-icon-list-text">Ikuti Kami :</span>
                                                    </li>
                                                    <li class="elementor-icon-list-item elementor-inline-item">
                                                        <a href="https://www.facebook.com/people/ptkubah-mandiri-indonesia/61579226071407/" target="_blank" rel="nofollow">
                                                            <
                                                                <span class="elementor-icon-list-icon">
                                                                <i aria-hidden="true" class="fab fa-facebook-square"></i>
                                                                </span>
                                                                <span class="elementor-icon-list-text">Facebook</span>
                                                    </li>
                                                    <!-- <li class="elementor-icon-list-item elementor-inline-item">
                                                        <a href="https://www.youtube.com/channel/UCMUM-6H_fqenbj6rxCJBirQ/videos"
                                                            target="_blank" rel="nofollow"> <span
                                                                class="elementor-icon-list-icon">
                                                                <i aria-hidden="true" class="fab fa-youtube"></i>
                                                            </span>
                                                            <span class="elementor-icon-list-text">Youtube</span>
                                                        </a>
                                                    </li>
                                                    <li class="elementor-icon-list-item elementor-inline-item">
                                                        <span class="elementor-icon-list-icon">
                                                            <i aria-hidden="true" class="fab fa-instagram"></i> </span>
                                                        <span class="elementor-icon-list-text">Instagram</span>
                                                    </li> -->
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section
                    class="elementor-section elementor-top-section elementor-element elementor-element-f6fbfe4 elementor-hidden-tablet elementor-hidden-phone elementor-section-boxed elementor-section-height-default elementor-section-height-default"
                    data-id="f6fbfe4" data-element_type="section"
                    data-settings="{&quot;background_background&quot;:&quot;classic&quot;,&quot;sticky&quot;:&quot;bottom&quot;,&quot;sticky_on&quot;:[&quot;desktop&quot;,&quot;tablet&quot;,&quot;mobile&quot;],&quot;sticky_offset&quot;:0,&quot;sticky_effects_offset&quot;:0}">
                    <div class="elementor-container elementor-column-gap-default">
                        <div class="elementor-row">
                            <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-4e09d0fc"
                                data-id="4e09d0fc" data-element_type="column">
                                <div class="elementor-column-wrap elementor-element-populated">
                                    <div class="elementor-widget-wrap">
                                        <div class="elementor-element elementor-element-6f8ee73 elementor-widget elementor-widget-button"
                                            data-id="6f8ee73" data-element_type="widget"
                                            data-widget_type="button.default">
                                            <div class="elementor-widget-container">
                                                <div class="elementor-button-wrapper">
                                                    <a href="https://wa.me/6285188588596?text=Assalamualaikum%20PT%20KUBAH%20MANDIRI%20INDONESIA%2C%20mohon%20info%20kubahnya%3F"
                                                        class="elementor-button-link elementor-button elementor-size-xs"
                                                        role="button" id="wa-generic" target="_blank">
                                                        <span class="elementor-button-content-wrapper">
                                                            <span
                                                                class="elementor-button-icon elementor-align-icon-left">
                                                                <i aria-hidden="true" class="fab fa-whatsapp"></i>
                                                            </span>
                                                            <span class="elementor-button-text">WhatsApp
                                                                085188588596</span>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section
                    class="elementor-section elementor-top-section elementor-element elementor-element-6803c2cc elementor-hidden-desktop elementor-section-boxed elementor-section-height-default elementor-section-height-default"
                    data-id="6803c2cc" data-element_type="section"
                    data-settings="{&quot;background_background&quot;:&quot;classic&quot;,&quot;sticky&quot;:&quot;bottom&quot;,&quot;sticky_on&quot;:[&quot;desktop&quot;,&quot;tablet&quot;,&quot;mobile&quot;],&quot;sticky_offset&quot;:0,&quot;sticky_effects_offset&quot;:0}">
                    <div class="elementor-container elementor-column-gap-default">
                        <div class="elementor-row">
                            <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-1e424efd"
                                data-id="1e424efd" data-element_type="column">
                                <div class="elementor-column-wrap elementor-element-populated">
                                    <div class="elementor-widget-wrap">
                                        <div class="elementor-element elementor-element-415227aa elementor-widget elementor-widget-button"
                                            data-id="415227aa" data-element_type="widget"
                                            data-widget_type="button.default">
                                            <div class="elementor-widget-container">
                                                <div class="elementor-button-wrapper">
                                                    <a href="https://wa.me/6285188588596?text=Assalamualaikum%20PT%20KUBAH%20MANDIRI%20INDONESIA%2C%20mohon%20info%20kubahnya%3F"
                                                        class="elementor-button-link elementor-button elementor-size-sm"
                                                        role="button" id="wa-generic" target="_blank">
                                                        <span class="elementor-button-content-wrapper">
                                                            <span
                                                                class="elementor-button-icon elementor-align-icon-left">
                                                                <i aria-hidden="true" class="fab fa-whatsapp"></i>
                                                            </span>
                                                            <span class="elementor-button-text">WhatsApp</span>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-70a558ee"
                                data-id="70a558ee" data-element_type="column">
                                <div class="elementor-column-wrap elementor-element-populated">
                                    <div class="elementor-widget-wrap">
                                        <div class="elementor-element elementor-element-1ebb6fff call-generic elementor-widget elementor-widget-button"
                                            data-id="1ebb6fff" data-element_type="widget"
                                            data-widget_type="button.default">
                                            <div class="elementor-widget-container">
                                                <div class="elementor-button-wrapper">
                                                    <a href="https://wa.me/6285188588596?text=Assalamualaikum%20PT%20KUBAH%20MANDIRI%20INDONESIA%2C%20mohon%20info%20kubahnya%3F"
                                                        class="elementor-button-link elementor-button elementor-size-sm"
                                                        role="button" id="call-generic">
                                                        <span class="elementor-button-content-wrapper">
                                                            <span
                                                                class="elementor-button-icon elementor-align-icon-left">
                                                                <i aria-hidden="true" class="fas fa-phone-alt"></i>
                                                            </span>
                                                            <span class="elementor-button-text">Call</span>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <script type="speculationrules">
        {"prefetch":[{"source":"document","where":{"and":[{"href_matches":"/*"},{"not":{"href_matches":["/wp-*.php","/wp-admin/*","/wp-content/uploads/*","/wp-content/*","/wp-content/plugins/*","/wp-content/themes/generatepress/*","/*\\?(.+)"]}},{"not":{"selector_matches":"a[rel~=\"nofollow\"]"}},{"not":{"selector_matches":".no-prefetch, .no-prefetch a"}}]},"eagerness":"conservative"}]}
</script>
    <script>
        function ht(a, b, c, d) {
            let z1 = a * c;
            let z2 = d * c;
            let h1 = Math.round(z1);
            let h2 = Math.round(z2);
            let hasil = fr(h1, "Rp. ") + " - " + fr(h2, "Rp. ");
            document.getElementById(b).innerHTML = hasil;
        }

        function bx() {
            let d = document.getElementById('d').value;
            let t = document.getElementById('t').value;
            let g = 3.1428571428571;
            let k = d * t * g;
            ht(2797727, "enamel", k, 3317273);
            ht(1499091, "galvalum", k, 1968636)
        }
        bx();

        function d() {
            bx();
        }

        function t() {
            bx();
        }

        function fr(ak, prefix) {
            var number_string = ak.toString().replace(/[^,\d]/g, '');
            var split = number_string.split(',');
            var sis = split[0].length % 3;
            var dph = split[0].substr(0, sis);
            var bnr = split[0].substr(sis).match(/\d{3}/gi);
            if (bnr) {
                separator = sis ? '.' : '';
                dph += separator + bnr.join('.');
            }
            dph = split[1] != undefined ? dph + ',' + split[1] : dph;
            return prefix == undefined ? dph : (dph ? 'Rp. ' + dph : '');
        };
        document.getElementById('tombolhitung').addEventListener('click', function() {
            bx();
        });
    </script>
    <script id="generate-a11y">
        ! function() {
            "use strict";
            if ("querySelector" in document && "addEventListener" in window) {
                var e = document.body;
                e.addEventListener("pointerdown", (function() {
                    e.classList.add("using-mouse")
                }), {
                    passive: !0
                }), e.addEventListener("keydown", (function() {
                    e.classList.remove("using-mouse")
                }), {
                    passive: !0
                })
            }
        }();
    </script>
    <style>
        presto-player:not(.hydrated) {
            position: relative;
            background: rgba(0, 0, 0, 0.1);
            width: 100%;
            display: block;
            aspect-ratio: var(--presto-player-aspect-ratio, 16/9);
        }

        presto-player:not(.hydrated) .presto-loader {
            display: block;
        }

        .presto-block-video:not(.presto-sticky-parent) {
            border-radius: var(--presto-player-border-radius, 0px);
            overflow: hidden;
            transform: translateZ(0);
        }

        /* Safari-specific fix - disable transform to prevent fullscreen black screen */
        @supports (hanging-punctuation: first) and (font: -apple-system-body) and (-webkit-appearance: none) {
            .presto-block-video:not(.presto-sticky-parent) {
                transform: none;
            }
        }

        .presto-block-video.presto-provider-audio {
            overflow: visible;
        }

        .presto-block-video .presto-sticky-parent {
            overflow: auto;
            transform: none;
        }

        .presto-sticky-parent {
            z-index: 99998 !important;
        }

        .presto-player-fullscreen-open {
            z-index: 9999999 !important;
            overflow: visible !important;
            transform: none !important;
        }


        presto-playlist,
        presto-player-skeleton,
        presto-timestamp,
        presto-video-curtain-ui,
        presto-search-bar-ui,
        presto-player-button,
        presto-cta-overlay-ui,
        presto-video,
        presto-action-bar-ui,
        presto-youtube-subscribe-button,
        presto-email-overlay-ui,
        presto-player-spinner,
        presto-action-bar,
        presto-cta-overlay,
        presto-email-overlay,
        presto-bunny,
        presto-dynamic-overlays,
        presto-search-bar,
        presto-youtube,
        presto-audio,
        presto-business-skin,
        presto-modern-skin,
        presto-muted-overlay,
        presto-stacked-skin,
        presto-vimeo,
        presto-action-bar-controller,
        presto-cta-overlay-controller,
        presto-email-overlay-controller,
        presto-dynamic-overlay-ui,
        presto-player,
        presto-playlist-item,
        presto-playlist-overlay,
        presto-playlist-ui {
            visibility: hidden;
        }

        .hydrated {
            visibility: inherit;
        }
    </style>
    <style>
        .presto-iframe-fallback-container {
            position: relative;
            padding-bottom: 56.25%;
            padding-top: 30px;
            height: 0;
            overflow: hidden
        }

        .presto-iframe-fallback-container embed,
        .presto-iframe-fallback-container iframe,
        .presto-iframe-fallback-container object {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%
        }
    </style>
    <script defer>
        window.addEventListener("load", function(event) {
            setTimeout(function() {
                var deferVideo = document.getElementsByClassName("presto-fallback-iframe");
                if (!deferVideo.length) return;
                Array.from(deferVideo).forEach(function(video) {
                    video && video.setAttribute("src", video.getAttribute("data-src"));
                });
            }, 2000);
        }, false);
    </script>
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-a271b9fb.entry.js'
        as='script' crossorigin />
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-CliI3pyn.js'
        as='script' crossorigin />
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-BxRAfMA5.js'
        as='script' crossorigin />
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-EuTDjLsB.js'
        as='script' crossorigin />
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-D8o-F2Bu.js'
        as='script' crossorigin />
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-1610cee0.entry.js'
        as='script' crossorigin />
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-G840BFTB.js'
        as='script' crossorigin />
    <style>
        .presto-iframe-fallback-container {
            position: relative;
            padding-bottom: 56.25%;
            padding-top: 30px;
            height: 0;
            overflow: hidden
        }

        .presto-iframe-fallback-container embed,
        .presto-iframe-fallback-container iframe,
        .presto-iframe-fallback-container object {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%
        }
    </style>
    <script defer>
        window.addEventListener("load", function(event) {
            setTimeout(function() {
                var deferVideo = document.getElementsByClassName("presto-fallback-iframe");
                if (!deferVideo.length) return;
                Array.from(deferVideo).forEach(function(video) {
                    video && video.setAttribute("src", video.getAttribute("data-src"));
                });
            }, 2000);
        }, false);
    </script>
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-a271b9fb.entry.js'
        as='script' crossorigin />
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-CliI3pyn.js'
        as='script' crossorigin />
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-BxRAfMA5.js'
        as='script' crossorigin />
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-EuTDjLsB.js'
        as='script' crossorigin />
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-D8o-F2Bu.js'
        as='script' crossorigin />
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-1610cee0.entry.js'
        as='script' crossorigin />
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-G840BFTB.js'
        as='script' crossorigin />
    <style>
        .presto-iframe-fallback-container {
            position: relative;
            padding-bottom: 56.25%;
            padding-top: 30px;
            height: 0;
            overflow: hidden
        }

        .presto-iframe-fallback-container embed,
        .presto-iframe-fallback-container iframe,
        .presto-iframe-fallback-container object {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%
        }
    </style>
    <script defer>
        window.addEventListener("load", function(event) {
            setTimeout(function() {
                var deferVideo = document.getElementsByClassName("presto-fallback-iframe");
                if (!deferVideo.length) return;
                Array.from(deferVideo).forEach(function(video) {
                    video && video.setAttribute("src", video.getAttribute("data-src"));
                });
            }, 2000);
        }, false);
    </script>
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-a271b9fb.entry.js'
        as='script' crossorigin />
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-CliI3pyn.js'
        as='script' crossorigin />
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-BxRAfMA5.js'
        as='script' crossorigin />
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-EuTDjLsB.js'
        as='script' crossorigin />
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-D8o-F2Bu.js'
        as='script' crossorigin />
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-1610cee0.entry.js'
        as='script' crossorigin />
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-G840BFTB.js'
        as='script' crossorigin />
    <style>
        .presto-iframe-fallback-container {
            position: relative;
            padding-bottom: 56.25%;
            padding-top: 30px;
            height: 0;
            overflow: hidden
        }

        .presto-iframe-fallback-container embed,
        .presto-iframe-fallback-container iframe,
        .presto-iframe-fallback-container object {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%
        }
    </style>
    <script defer>
        window.addEventListener("load", function(event) {
            setTimeout(function() {
                var deferVideo = document.getElementsByClassName("presto-fallback-iframe");
                if (!deferVideo.length) return;
                Array.from(deferVideo).forEach(function(video) {
                    video && video.setAttribute("src", video.getAttribute("data-src"));
                });
            }, 2000);
        }, false);
    </script>
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-a271b9fb.entry.js'
        as='script' crossorigin />
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-CliI3pyn.js'
        as='script' crossorigin />
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-BxRAfMA5.js'
        as='script' crossorigin />
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-EuTDjLsB.js'
        as='script' crossorigin />
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-D8o-F2Bu.js'
        as='script' crossorigin />
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-1610cee0.entry.js'
        as='script' crossorigin />
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-G840BFTB.js'
        as='script' crossorigin />
    <style>
        .presto-iframe-fallback-container {
            position: relative;
            padding-bottom: 56.25%;
            padding-top: 30px;
            height: 0;
            overflow: hidden
        }

        .presto-iframe-fallback-container embed,
        .presto-iframe-fallback-container iframe,
        .presto-iframe-fallback-container object {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%
        }
    </style>
    <script defer>
        window.addEventListener("load", function(event) {
            setTimeout(function() {
                var deferVideo = document.getElementsByClassName("presto-fallback-iframe");
                if (!deferVideo.length) return;
                Array.from(deferVideo).forEach(function(video) {
                    video && video.setAttribute("src", video.getAttribute("data-src"));
                });
            }, 2000);
        }, false);
    </script>
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-a271b9fb.entry.js'
        as='script' crossorigin />
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-CliI3pyn.js'
        as='script' crossorigin />
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-BxRAfMA5.js'
        as='script' crossorigin />
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-EuTDjLsB.js'
        as='script' crossorigin />
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-D8o-F2Bu.js'
        as='script' crossorigin />
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-1610cee0.entry.js'
        as='script' crossorigin />
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-G840BFTB.js'
        as='script' crossorigin />
    <style>
        .presto-iframe-fallback-container {
            position: relative;
            padding-bottom: 56.25%;
            padding-top: 30px;
            height: 0;
            overflow: hidden
        }

        .presto-iframe-fallback-container embed,
        .presto-iframe-fallback-container iframe,
        .presto-iframe-fallback-container object {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%
        }
    </style>
    <script defer>
        window.addEventListener("load", function(event) {
            setTimeout(function() {
                var deferVideo = document.getElementsByClassName("presto-fallback-iframe");
                if (!deferVideo.length) return;
                Array.from(deferVideo).forEach(function(video) {
                    video && video.setAttribute("src", video.getAttribute("data-src"));
                });
            }, 2000);
        }, false);
    </script>
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-a271b9fb.entry.js'
        as='script' crossorigin />
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-CliI3pyn.js'
        as='script' crossorigin />
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-BxRAfMA5.js'
        as='script' crossorigin />
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-EuTDjLsB.js'
        as='script' crossorigin />
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-D8o-F2Bu.js'
        as='script' crossorigin />
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-1610cee0.entry.js'
        as='script' crossorigin />
    <link rel='modulepreload'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/p-G840BFTB.js'
        as='script' crossorigin />
    <script id="generate-menu-js-before">
        var generatepressMenu = {
            "toggleOpenedSubMenus": true,
            "openSubMenuLabel": "Open Sub-Menu",
            "closeSubMenuLabel": "Close Sub-Menu"
        };
        //# sourceURL=generate-menu-js-before
    </script>
    <script src="https://www.jualkubahmasjid.id/wp-content/themes/generatepress/assets/js/menu.min.js?ver=3.6.1"
        id="generate-menu-js"></script>
    <script src="https://www.jualkubahmasjid.id/wp-includes/js/jquery/jquery.min.js?ver=3.7.1"
        id="jquery-core-js"></script>
    <script src="https://www.jualkubahmasjid.id/wp-includes/js/jquery/jquery-migrate.min.js?ver=3.4.1"
        id="jquery-migrate-js"></script>
    <script
        src="https://www.jualkubahmasjid.id/wp-content/plugins/elementor-pro/assets/lib/smartmenus/jquery.smartmenus.min.js?ver=1.0.1"
        id="smartmenus-js"></script>
    <script src="https://www.jualkubahmasjid.id/wp-includes/js/dist/hooks.min.js?ver=dd5603f07f9220ed27f1"
        id="wp-hooks-js"></script>
    <script src="https://www.jualkubahmasjid.id/wp-includes/js/dist/i18n.min.js?ver=c26c3dc7bed366793375"
        id="wp-i18n-js"></script>
    <script id="wp-i18n-js-after">
        wp.i18n.setLocaleData({
            'text direction\u0004ltr': ['ltr']
        });
        //# sourceURL=wp-i18n-js-after
    </script>
    <script id="presto-components-js-extra">
        var prestoComponents = {
            "url": "https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/web-components.esm.js?ver=1776095644"
        };
        var prestoPlayer = {
            "plugin_url": "https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/",
            "logged_in": "",
            "root": "https://www.jualkubahmasjid.id/wp-json/",
            "nonce": "980409ff13",
            "ajaxurl": "https://www.jualkubahmasjid.id/wp-admin/admin-ajax.php",
            "isAdmin": "",
            "isSetup": {
                "bunny": false
            },
            "proVersion": "",
            "isPremium": "",
            "wpVersionString": "wp/v2/",
            "prestoVersionString": "presto-player/v1/",
            "debug": "",
            "debug_navigator": "",
            "i18n": {
                "skip": "Skip",
                "rewatch": "Rewatch",
                "emailPlaceholder": "Email address",
                "emailDefaultHeadline": "Enter your email to play this episode.",
                "chapters": "Chapters",
                "show_chapters": "Show Chapters",
                "hide_chapters": "Hide Chapters",
                "restart": "Restart",
                "rewind": "Rewind {seektime}s",
                "play": "Play",
                "pause": "Pause",
                "fastForward": "Forward {seektime}s",
                "seek": "Seek",
                "seekLabel": "{currentTime} of {duration}",
                "played": "Played",
                "buffered": "Buffered",
                "currentTime": "Current time",
                "duration": "Duration",
                "volume": "Volume",
                "mute": "Mute",
                "unmute": "Unmute",
                "enableCaptions": "Enable captions",
                "disableCaptions": "Disable captions",
                "download": "Download",
                "enterFullscreen": "Enter fullscreen",
                "exitFullscreen": "Exit fullscreen",
                "frameTitle": "Player for {title}",
                "captions": "Captions",
                "settings": "Settings",
                "pip": "PIP",
                "menuBack": "Go back to previous menu",
                "speed": "Speed",
                "normal": "Normal",
                "quality": "Quality",
                "loop": "Loop",
                "start": "Start",
                "end": "End",
                "all": "All",
                "reset": "Reset",
                "disabled": "Disabled",
                "enabled": "Enabled",
                "advertisement": "Ad",
                "qualityBadge": {
                    "2160": "4K",
                    "1440": "HD",
                    "1080": "HD",
                    "720": "HD",
                    "576": "SD",
                    "480": "SD"
                },
                "auto": "AUTO",
                "next": "Next",
                "upNext": "Up Next",
                "startOver": "Start Over"
            },
            "trackViews": "1"
        };
        var prestoComponents = {
            "url": "https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/dist/components/web-components/web-components.esm.js?ver=1776095644"
        };
        var prestoPlayer = {
            "plugin_url": "https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/",
            "logged_in": "",
            "root": "https://www.jualkubahmasjid.id/wp-json/",
            "nonce": "980409ff13",
            "ajaxurl": "https://www.jualkubahmasjid.id/wp-admin/admin-ajax.php",
            "isAdmin": "",
            "isSetup": {
                "bunny": false
            },
            "proVersion": "",
            "isPremium": "",
            "wpVersionString": "wp/v2/",
            "prestoVersionString": "presto-player/v1/",
            "debug": "",
            "debug_navigator": "",
            "i18n": {
                "skip": "Skip",
                "rewatch": "Rewatch",
                "emailPlaceholder": "Email address",
                "emailDefaultHeadline": "Enter your email to play this episode.",
                "chapters": "Chapters",
                "show_chapters": "Show Chapters",
                "hide_chapters": "Hide Chapters",
                "restart": "Restart",
                "rewind": "Rewind {seektime}s",
                "play": "Play",
                "pause": "Pause",
                "fastForward": "Forward {seektime}s",
                "seek": "Seek",
                "seekLabel": "{currentTime} of {duration}",
                "played": "Played",
                "buffered": "Buffered",
                "currentTime": "Current time",
                "duration": "Duration",
                "volume": "Volume",
                "mute": "Mute",
                "unmute": "Unmute",
                "enableCaptions": "Enable captions",
                "disableCaptions": "Disable captions",
                "download": "Download",
                "enterFullscreen": "Enter fullscreen",
                "exitFullscreen": "Exit fullscreen",
                "frameTitle": "Player for {title}",
                "captions": "Captions",
                "settings": "Settings",
                "pip": "PIP",
                "menuBack": "Go back to previous menu",
                "speed": "Speed",
                "normal": "Normal",
                "quality": "Quality",
                "loop": "Loop",
                "start": "Start",
                "end": "End",
                "all": "All",
                "reset": "Reset",
                "disabled": "Disabled",
                "enabled": "Enabled",
                "advertisement": "Ad",
                "qualityBadge": {
                    "2160": "4K",
                    "1440": "HD",
                    "1080": "HD",
                    "720": "HD",
                    "576": "SD",
                    "480": "SD"
                },
                "auto": "AUTO",
                "next": "Next",
                "upNext": "Up Next",
                "startOver": "Start Over"
            },
            "trackViews": "1"
        };
        //# sourceURL=presto-components-js-extra
    </script>
    <script
        src="https://www.jualkubahmasjid.id/wp-content/plugins/presto-player/src/player/player-static.js?ver=1776095644"
        type="module" defer></script>
    <script src="https://www.jualkubahmasjid.id/wp-content/plugins/elementor/assets/js/webpack.runtime.min.js?ver=3.1.1"
        id="elementor-webpack-runtime-js"></script>
    <script
        src="https://www.jualkubahmasjid.id/wp-content/plugins/elementor/assets/js/frontend-modules.min.js?ver=3.1.1"
        id="elementor-frontend-modules-js"></script>
    <script
        src="https://www.jualkubahmasjid.id/wp-content/plugins/elementor-pro/assets/lib/sticky/jquery.sticky.min.js?ver=3.0.10"
        id="elementor-sticky-js"></script>
    <script id="elementor-pro-frontend-js-before">
        var ElementorProFrontendConfig = {
            "ajaxurl": "https:\/\/www.jualkubahmasjid.id\/wp-admin\/admin-ajax.php",
            "nonce": "7e3e625fa2",
            "i18n": {
                "toc_no_headings_found": "No headings were found on this page."
            },
            "shareButtonsNetworks": {
                "facebook": {
                    "title": "Facebook",
                    "has_counter": true
                },
                "twitter": {
                    "title": "Twitter"
                },
                "google": {
                    "title": "Google+",
                    "has_counter": true
                },
                "linkedin": {
                    "title": "LinkedIn",
                    "has_counter": true
                },
                "pinterest": {
                    "title": "Pinterest",
                    "has_counter": true
                },
                "reddit": {
                    "title": "Reddit",
                    "has_counter": true
                },
                "vk": {
                    "title": "VK",
                    "has_counter": true
                },
                "odnoklassniki": {
                    "title": "OK",
                    "has_counter": true
                },
                "tumblr": {
                    "title": "Tumblr"
                },
                "digg": {
                    "title": "Digg"
                },
                "skype": {
                    "title": "Skype"
                },
                "stumbleupon": {
                    "title": "StumbleUpon",
                    "has_counter": true
                },
                "mix": {
                    "title": "Mix"
                },
                "telegram": {
                    "title": "Telegram"
                },
                "pocket": {
                    "title": "Pocket",
                    "has_counter": true
                },
                "xing": {
                    "title": "XING",
                    "has_counter": true
                },
                "whatsapp": {
                    "title": "WhatsApp"
                },
                "email": {
                    "title": "Email"
                },
                "print": {
                    "title": "Print"
                }
            },
            "facebook_sdk": {
                "lang": "en_US",
                "app_id": ""
            },
            "lottie": {
                "defaultAnimationUrl": "https:\/\/www.jualkubahmasjid.id\/wp-content\/plugins\/elementor-pro\/modules\/lottie\/assets\/animations\/default.json"
            }
        };
        //# sourceURL=elementor-pro-frontend-js-before
    </script>
    <script src="https://www.jualkubahmasjid.id/wp-content/plugins/elementor-pro/assets/js/frontend.min.js?ver=3.0.10"
        id="elementor-pro-frontend-js"></script>
    <script src="https://www.jualkubahmasjid.id/wp-includes/js/jquery/ui/core.min.js?ver=1.13.3"
        id="jquery-ui-core-js"></script>
    <script src="https://www.jualkubahmasjid.id/wp-content/plugins/elementor/assets/lib/dialog/dialog.min.js?ver=4.8.1"
        id="elementor-dialog-js"></script>
    <script
        src="https://www.jualkubahmasjid.id/wp-content/plugins/elementor/assets/lib/waypoints/waypoints.min.js?ver=4.0.2"
        id="elementor-waypoints-js"></script>
    <script
        src="https://www.jualkubahmasjid.id/wp-content/plugins/elementor/assets/lib/share-link/share-link.min.js?ver=3.1.1"
        id="share-link-js"></script>
    <script src="https://www.jualkubahmasjid.id/wp-content/plugins/elementor/assets/lib/swiper/swiper.min.js?ver=5.3.6"
        id="swiper-js"></script>
    <script id="elementor-frontend-js-before">
        var elementorFrontendConfig = {
            "environmentMode": {
                "edit": false,
                "wpPreview": false,
                "isScriptDebug": false,
                "isImprovedAssetsLoading": false
            },
            "i18n": {
                "shareOnFacebook": "Share on Facebook",
                "shareOnTwitter": "Share on Twitter",
                "pinIt": "Pin it",
                "download": "Download",
                "downloadImage": "Download image",
                "fullscreen": "Fullscreen",
                "zoom": "Zoom",
                "share": "Share",
                "playVideo": "Play Video",
                "previous": "Previous",
                "next": "Next",
                "close": "Close"
            },
            "is_rtl": false,
            "breakpoints": {
                "xs": 0,
                "sm": 480,
                "md": 768,
                "lg": 1025,
                "xl": 1440,
                "xxl": 1600
            },
            "version": "3.1.1",
            "is_static": false,
            "experimentalFeatures": [],
            "urls": {
                "assets": "https:\/\/www.jualkubahmasjid.id\/wp-content\/plugins\/elementor\/assets\/"
            },
            "settings": {
                "page": [],
                "editorPreferences": []
            },
            "kit": {
                "global_image_lightbox": "yes",
                "lightbox_enable_counter": "yes",
                "lightbox_enable_fullscreen": "yes",
                "lightbox_enable_zoom": "yes",
                "lightbox_enable_share": "yes",
                "lightbox_title_src": "title",
                "lightbox_description_src": "description"
            },
            "post": {
                "id": 20837,
                "title": "Jual%20Kubah%20Masjid%20Terdekat%20Pilihan%20Tepat%20untuk%20Masjid%20Anda",
                "excerpt": "",
                "featuredImage": false
            }
        };
        //# sourceURL=elementor-frontend-js-before
    </script>
    <script src="https://www.jualkubahmasjid.id/wp-content/plugins/elementor/assets/js/frontend.min.js?ver=3.1.1"
        id="elementor-frontend-js"></script>
    <script
        src="https://www.jualkubahmasjid.id/wp-content/plugins/elementor/assets/js/preloaded-elements-handlers.min.js?ver=3.1.1"
        id="preloaded-elements-handlers-js"></script>
    <script id="wp-emoji-settings" type="application/json">
        {
            "baseUrl": "https://s.w.org/images/core/emoji/17.0.2/72x72/",
            "ext": ".png",
            "svgUrl": "https://s.w.org/images/core/emoji/17.0.2/svg/",
            "svgExt": ".svg",
            "source": {
                "concatemoji": "https://www.jualkubahmasjid.id/wp-includes/js/wp-emoji-release.min.js?ver=6.9.4"
            }
        }
    </script>
    <script type="module">
        /*! This file is auto-generated */
        const a = JSON.parse(document.getElementById("wp-emoji-settings").textContent),
            o = (window._wpemojiSettings = a, "wpEmojiSettingsSupports"),
            s = ["flag", "emoji"];

        function i(e) {
            try {
                var t = {
                    supportTests: e,
                    timestamp: (new Date).valueOf()
                };
                sessionStorage.setItem(o, JSON.stringify(t))
            } catch (e) {}
        }

        function c(e, t, n) {
            e.clearRect(0, 0, e.canvas.width, e.canvas.height), e.fillText(t, 0, 0);
            t = new Uint32Array(e.getImageData(0, 0, e.canvas.width, e.canvas.height).data);
            e.clearRect(0, 0, e.canvas.width, e.canvas.height), e.fillText(n, 0, 0);
            const a = new Uint32Array(e.getImageData(0, 0, e.canvas.width, e.canvas.height).data);
            return t.every((e, t) => e === a[t])
        }

        function p(e, t) {
            e.clearRect(0, 0, e.canvas.width, e.canvas.height), e.fillText(t, 0, 0);
            var n = e.getImageData(16, 16, 1, 1);
            for (let e = 0; e < n.data.length; e++)
                if (0 !== n.data[e]) return !1;
            return !0
        }

        function u(e, t, n, a) {
            switch (t) {
                case "flag":
                    return n(e, "\ud83c\udff3\ufe0f\u200d\u26a7\ufe0f", "\ud83c\udff3\ufe0f\u200b\u26a7\ufe0f") ? !1 : !n(e, "\ud83c\udde8\ud83c\uddf6", "\ud83c\udde8\u200b\ud83c\uddf6") && !n(e, "\ud83c\udff4\udb40\udc67\udb40\udc62\udb40\udc65\udb40\udc6e\udb40\udc67\udb40\udc7f", "\ud83c\udff4\u200b\udb40\udc67\u200b\udb40\udc62\u200b\udb40\udc65\u200b\udb40\udc6e\u200b\udb40\udc67\u200b\udb40\udc7f");
                case "emoji":
                    return !a(e, "\ud83e\u1fac8")
            }
            return !1
        }

        function f(e, t, n, a) {
            let r;
            const o = (r = "undefined" != typeof WorkerGlobalScope && self instanceof WorkerGlobalScope ? new OffscreenCanvas(300, 150) : document.createElement("canvas")).getContext("2d", {
                    willReadFrequently: !0
                }),
                s = (o.textBaseline = "top", o.font = "600 32px Arial", {});
            return e.forEach(e => {
                s[e] = t(o, e, n, a)
            }), s
        }

        function r(e) {
            var t = document.createElement("script");
            t.src = e, t.defer = !0, document.head.appendChild(t)
        }
        a.supports = {
            everything: !0,
            everythingExceptFlag: !0
        }, new Promise(t => {
            let n = function() {
                try {
                    var e = JSON.parse(sessionStorage.getItem(o));
                    if ("object" == typeof e && "number" == typeof e.timestamp && (new Date).valueOf() < e.timestamp + 604800 && "object" == typeof e.supportTests) return e.supportTests
                } catch (e) {}
                return null
            }();
            if (!n) {
                if ("undefined" != typeof Worker && "undefined" != typeof OffscreenCanvas && "undefined" != typeof URL && URL.createObjectURL && "undefined" != typeof Blob) try {
                    var e = "postMessage(" + f.toString() + "(" + [JSON.stringify(s), u.toString(), c.toString(), p.toString()].join(",") + "));",
                        a = new Blob([e], {
                            type: "text/javascript"
                        });
                    const r = new Worker(URL.createObjectURL(a), {
                        name: "wpTestEmojiSupports"
                    });
                    return void(r.onmessage = e => {
                        i(n = e.data), r.terminate(), t(n)
                    })
                } catch (e) {}
                i(n = f(s, u, c, p))
            }
            t(n)
        }).then(e => {
            for (const n in e) a.supports[n] = e[n], a.supports.everything = a.supports.everything && a.supports[n], "flag" !== n && (a.supports.everythingExceptFlag = a.supports.everythingExceptFlag && a.supports[n]);
            var t;
            a.supports.everythingExceptFlag = a.supports.everythingExceptFlag && !a.supports.flag, a.supports.everything || ((t = a.source || {}).concatemoji ? r(t.concatemoji) : t.wpemoji && t.twemoji && (r(t.twemoji), r(t.wpemoji)))
        });
        //# sourceURL=https://www.jualkubahmasjid.id/wp-includes/js/wp-emoji-loader.min.js
    </script>

</body>

</html>