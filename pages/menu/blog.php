<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_sikubah";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pagination setup
$articles_per_page = 5;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$current_page = max(1, $current_page); // Ensure page is at least 1
$offset = ($current_page - 1) * $articles_per_page;

// Count total articles
$count_sql = "SELECT COUNT(*) as total FROM articles WHERE published = 1";
$count_result = $conn->query($count_sql);
$total_articles = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_articles / $articles_per_page);

// Fetch articles from database with pagination
$sql = "SELECT * FROM articles WHERE published = 1 ORDER BY created_at DESC LIMIT $articles_per_page OFFSET $offset";
$result = $conn->query($sql);

$articles = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $articles[] = $row;
    }
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US" prefix="og: https://ogp.me/ns#">

<head>
    <meta charset="UTF-8">
    <title>Blog</title>

    <!-- All in One SEO 4.9.7.1 - aioseo.com -->
    <meta name="robots" content="max-image-preview:large" />
    <meta name="author" content="PT. Anugerah Kubah Indonesia" />
    <meta name="keywords"
        content="jual kubah masjid parigi moutong,jual kubah masjid terdekat,pembuat kubah masjid,kubah enamel,kubah galvalum,kubah stainless gold,kontraktor kubah masjid,jual kubah masjid palu,jual kubah masjid pangkalpinang,jual kubah masjid aceh besar,jual kubah masjid idi rayeuk,jual kubah masjid pidie,jual kubah masjid bireuen" />
    <link rel="canonical" href="https://www.jualkubahmasjid.id/blog/" />
    <link rel="next" href="https://www.jualkubahmasjid.id/blog/page/2/" />
    <meta name="generator" content="All in One SEO (AIOSEO) 4.9.7.1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:site_name" content="JUAL KUBAH MASJID  Harga Kubah Masjid Terjangkau! |" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Blog" />
    <meta property="og:url" content="https://www.jualkubahmasjid.id/blog/" />
    <meta property="article:published_time" content="2016-08-08T15:46:12+00:00" />
    <meta property="article:modified_time" content="2020-09-04T10:29:25+00:00" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:title" content="Blog" />
    <!-- All in One SEO -->

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel='dns-prefetch' href='//www.googletagmanager.com' />
    <link href='https://fonts.gstatic.com' crossorigin rel='preconnect' />
    <link href='https://fonts.googleapis.com' crossorigin rel='preconnect' />
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
    <link rel='stylesheet' id='eztoc-css'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/easy-table-of-contents/assets/css/screen.min.css?ver=2.0.83'
        media='all' />
    <style id='eztoc-inline-css'>
        div#ez-toc-container .ez-toc-title {
            font-size: 120%;
        }

        div#ez-toc-container .ez-toc-title {
            font-weight: 500;
        }

        div#ez-toc-container ul li,
        div#ez-toc-container ul li a {
            font-size: 95%;
        }

        div#ez-toc-container ul li,
        div#ez-toc-container ul li a {
            font-weight: 500;
        }

        div#ez-toc-container nav ul ul li {
            font-size: 90%;
        }

        .ez-toc-box-title {
            font-weight: bold;
            margin-bottom: 10px;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #666;
            padding-bottom: 5px;
            position: absolute;
            top: -4%;
            left: 5%;
            background-color: inherit;
            transition: top 0.3s ease;
        }

        .ez-toc-box-title.toc-closed {
            top: -25%;
        }

        .ez-toc-container-direction {
            direction: ltr;
        }

        .ez-toc-counter ul {
            counter-reset: item;
        }

        .ez-toc-counter nav ul li a::before {
            content: counters(item, '.', decimal) '. ';
            display: inline-block;
            counter-increment: item;
            flex-grow: 0;
            flex-shrink: 0;
            margin-right: .2em;
            float: left;
        }

        .ez-toc-widget-direction {
            direction: ltr;
        }

        .ez-toc-widget-container ul {
            counter-reset: item;
        }

        .ez-toc-widget-container nav ul li a::before {
            content: counters(item, '.', decimal) '. ';
            display: inline-block;
            counter-increment: item;
            flex-grow: 0;
            flex-shrink: 0;
            margin-right: .2em;
            float: left;
        }

        /*# sourceURL=eztoc-inline-css */
    </style>
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
    <link rel='stylesheet' id='elementor-post-4296-css'
        href='https://www.jualkubahmasjid.id/wp-content/uploads/elementor/css/post-4296.css?ver=1757963715'
        media='all' />
    <link rel='stylesheet' id='elementor-post-4522-css'
        href='https://www.jualkubahmasjid.id/wp-content/uploads/elementor/css/post-4522.css?ver=1777551932'
        media='all' />
    <link rel='stylesheet' id='google-fonts-1-css'
        href='https://fonts.googleapis.com/css?family=Roboto%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic%7CRoboto+Slab%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic%7CPoppins%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic%7CPT+Sans%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic&#038;ver=6.9.4'
        media='all' />
    <link rel='stylesheet' id='elementor-icons-shared-0-css'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/elementor/assets/lib/font-awesome/css/fontawesome.min.css?ver=5.15.1'
        media='all' />
    <link rel='stylesheet' id='elementor-icons-fa-brands-css'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/elementor/assets/lib/font-awesome/css/brands.min.css?ver=5.15.1'
        media='all' />
    <link rel='stylesheet' id='elementor-icons-fa-solid-css'
        href='https://www.jualkubahmasjid.id/wp-content/plugins/elementor/assets/lib/font-awesome/css/solid.min.css?ver=5.15.1'
        media='all' />
    <script src="https://www.jualkubahmasjid.id/wp-includes/js/jquery/jquery.min.js?ver=3.7.1"
        id="jquery-core-js"></script>
    <script src="https://www.jualkubahmasjid.id/wp-includes/js/jquery/jquery-migrate.min.js?ver=3.4.1"
        id="jquery-migrate-js"></script>
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
        gtag("config", "G-GBHP9RL402");
        gtag("config", "AW-737332955");
        //# sourceURL=google_gtagjs-js-after
    </script>
    <link rel="https://api.w.org/" href="https://www.jualkubahmasjid.id/wp-json/" />
    <link rel="EditURI" type="application/rsd+xml" title="RSD" href="https://www.jualkubahmasjid.id/xmlrpc.php?rsd" />
    <meta name="generator" content="WordPress 6.9.4" />
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
    <link rel="icon"
        href="https://www.jualkubahmasjid.id/wp-content/uploads/2021/02/cropped-QOOBAH-logo-PNG-2-32x32.png"
        sizes="32x32" />
    <link rel="icon"
        href="https://www.jualkubahmasjid.id/wp-content/uploads/2021/02/cropped-QOOBAH-logo-PNG-2-192x192.png"
        sizes="192x192" />
    <link rel="apple-touch-icon"
        href="https://www.jualkubahmasjid.id/wp-content/uploads/2021/02/cropped-QOOBAH-logo-PNG-2-180x180.png" />
    <meta name="msapplication-TileImage"
        content="https://www.jualkubahmasjid.id/wp-content/uploads/2021/02/cropped-QOOBAH-logo-PNG-2-270x270.png" />
    <link rel='stylesheet' id='elementor-post-22203-css'
        href='https://www.jualkubahmasjid.id/wp-content/uploads/elementor/css/post-22203.css?ver=1775776833'
        media='all' />
    <link rel='stylesheet' id='elementor-post-22211-css'
        href='https://www.jualkubahmasjid.id/wp-content/uploads/elementor/css/post-22211.css?ver=1776209448'
        media='all' />
    <link rel='stylesheet' id='google-fonts-2-css'
        href='https://fonts.googleapis.com/css?family=Exo%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic&#038;ver=6.9.4'
        media='all' />

</head>

<body
    class="blog wp-embed-responsive wp-theme-generatepress hide-meta-author hide-meta-date right-sidebar nav-below-header separate-containers fluid-header active-footer-widgets-3 nav-aligned-left header-aligned-left dropdown-hover elementor-default elementor-kit-4567"
    itemtype="https://schema.org/Blog" itemscope>
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
                                                <a href="https://www.jualkubahmasjid.id/">
                                                    <img width="60" height="2"
                                                        src="../../images/icontrans.png"
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
                                                    <!-- <li
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
                                                    </li> -->
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
                                                    <!-- <li
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
                                                    </li> -->
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

            <div class="content-area grid-parent mobile-grid-100 grid-75 tablet-grid-75" id="primary">
                <main class="site-main" id="main">
                    <!-- Hubungan Blog/ Artikel dari database -->
                    <?php if (!empty($articles)): ?>
                        <?php foreach ($articles as $article): ?>
                            <article id="post-<?php echo $article['id']; ?>"
                                class="post-<?php echo $article['id']; ?> post type-post status-publish format-standard hentry category-informatif"
                                itemtype="https://schema.org/CreativeWork" itemscope>
                                <div class="inside-article">
                                    <header class="entry-header">
                                        <h2 class="entry-title" itemprop="headline">
                                            <a href="http://localhost/SIKUBAH/pages/menu/article_detail.php?slug=<?php echo urlencode($article['slug']); ?>" rel="bookmark">
                                                <?php echo htmlspecialchars($article['title']); ?>
                                            </a>
                                        </h2>
                                        <div class="entry-meta">
                                            <span class="posted-on">
                                                <time class="entry-date published"
                                                    datetime="<?php echo date('c', strtotime($article['created_at'])); ?>"
                                                    itemprop="datePublished">
                                                    <?php echo date('d/m/Y', strtotime($article['created_at'])); ?>
                                                </time>
                                            </span>
                                            <span class="byline">by
                                                <span class="author vcard" itemprop="author" itemtype="https://schema.org/Person" itemscope>
                                                    <a class="url fn n" href="#" title="View all posts by PT. Anugerah Kubah Indonesia"
                                                        rel="author" itemprop="url">
                                                        <span class="author-name" itemprop="name">PT. Anugerah Kubah Indonesia</span>
                                                    </a>
                                        </div>
                                    </header>

                                    <div class="entry-content" itemprop="text">
                                        <?php if (!empty($article['featured_image'])): ?>
                                            <p>
                                                <img decoding="async"
                                                    alt="<?php echo htmlspecialchars($article['title']); ?>"
                                                    class="aligncenter size-full"
                                                    src="http://localhost/SIKUBAH/<?php echo htmlspecialchars($article['featured_image']); ?>"
                                                    style="max-width: 100%; height: auto;" />
                                            </p>
                                        <?php endif; ?>

                                        <?php
                                        // Show first 150 characters of content as excerpt
                                        $content = strip_tags($article['content']);
                                        $excerpt = mb_substr($content, 0, 150);
                                        echo '<p>' . htmlspecialchars($excerpt);
                                        if (mb_strlen($content) > 150) {
                                            echo '...';
                                        }
                                        echo '</p>';
                                        ?>

                                        <p>
                                            <a href="http://localhost/SIKUBAH/pages/menu/article_detail.php?slug=<?php echo urlencode($article['slug']); ?>"
                                                class="read-more-link">
                                                Baca Selengkapnya &rarr;
                                            </a>
                                        </p>
                                    </div>

                                    <footer class="entry-meta" aria-label="Entry meta">
                                        <span class="cat-links">
                                            <span class="screen-reader-text">Categories </span>
                                            <a href="#" rel="category tag">Informasi Masjid</a>
                                        </span>
                                    </footer>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <article class="post type-post status-publish">
                            <div class="inside-article">
                                <div class="entry-content">
                                    <p>Belum ada artikel yang dipublikasikan.</p>
                                </div>
                            </div>
                        </article>
                    <?php endif; ?>

                    <!-- Pagination Navigation -->
                    <?php if ($total_pages > 1): ?>
                        <nav id="nav-below" class="paging-navigation" aria-label="Archive Page">
                            <div class="nav-links">
                                <?php if ($current_page > 1): ?>
                                    <a class="prev page-numbers" href="?page=<?php echo ($current_page - 1); ?>">
                                        <span aria-hidden="true">&larr;</span> Previous
                                    </a>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                    <?php if ($i == $current_page): ?>
                                        <span aria-current="page" class="page-numbers current">
                                            <span class="screen-reader-text">Page </span><?php echo $i; ?>
                                        </span>
                                    <?php else: ?>
                                        <a class="page-numbers" href="?page=<?php echo $i; ?>">
                                            <span class="screen-reader-text">Page </span><?php echo $i; ?>
                                        </a>
                                    <?php endif; ?>
                                <?php endfor; ?>

                                <?php if ($current_page < $total_pages): ?>
                                    <a class="next page-numbers" href="?page=<?php echo ($current_page + 1); ?>">
                                        Next <span aria-hidden="true">&rarr;</span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </nav>
                    <?php endif; ?>
                </main>
            </div>

            <div class="widget-area sidebar is-right-sidebar grid-25 tablet-grid-25 grid-parent" id="right-sidebar">
                <div class="inside-right-sidebar">
                    <!-- <aside id="search-3" class="widget inner-padding widget_search">
                        <form method="get" class="search-form" action="https://www.jualkubahmasjid.id/">
                            <label>
                                <span class="screen-reader-text">Search for:</span>
                                <input type="search" class="search-field" placeholder="Search &hellip;" value=""
                                    name="s" title="Search for:">
                            </label>
                            <input type="submit" class="search-submit" value="Search">
                        </form>
                    </aside> -->
                    <aside id="text-4" class="widget inner-padding widget_text">
                        <div class="textwidget">
                            <p>&nbsp;</p>
                            <p><img loading="lazy" decoding="async" class="aligncenter wp-image-19892 size-medium"
                                    src="../../images/profile.webp"
                                    alt="" width="300" height="300"
                                    srcset="../../images/profile.webp"
                                    sizes="auto, (max-width: 300px) 100vw, 300px" /></p>
                            <p>&nbsp;</p>
                            <p>Assalamualaikum, saya <strong>Admin PT. Kubah Mandiri Indonesia</strong>.</p>
                            <p>Silakan konsultasi gratis dengan Call/WhatsApp saya di nomor <a
                                    href="tel:+6285168613452"><strong>085168613452</strong></a> untuk mengetahui info
                                harga pemesanan kubah enamel dan kubah masjid galvalum.</p>
                        </div>
                    </aside>
                    <aside id="text-5" class="widget inner-padding widget_text">
                        <h2 class="widget-title">Temukan PT. Anugerah Kubah Indonesia pada Google Maps</h2>
                        <div class="textwidget">
                            <p><iframe
                                    src="https://www.google.com/maps?q=-8.13276834379213,111.6860444625708&hl=id&z=17&output=embed"
                                    style="border:0;" allowfullscreen="" loading="lazy"></iframe></p>
                        </div>
                    </aside>
                    <!-- <aside id="recent-posts-2" class="widget inner-padding widget_recent_entries">
                        <h2 class="widget-title">Info Terkini</h2>
                        <ul>
                            <li>
                                <a href="https://www.jualkubahmasjid.id/masjid-pusdai-bandung/">Mengintip Desain Ikonik
                                    Masjid PUSDAI Bandung Jawa Barat</a>
                            </li>
                            <li>
                                <a href="https://www.jualkubahmasjid.id/masjid-raya-al-muttaqin-bogor/">Fasilitas dan
                                    Kegiatan di Masjid Raya Al Muttaqin Bogor</a>
                            </li>
                            <li>
                                <a href="https://www.jualkubahmasjid.id/masjid-nurani-kranji/">Megahnya Masjid Nurani
                                    Kranji Perpaduan Modern dan Spanyol</a>
                            </li>
                            <li>
                                <a href="https://www.jualkubahmasjid.id/masjid-raya-raudhatul-irfan/">Pesona Arsitektur
                                    Masjid Raya Raudhatul Irfan Sukabumi</a>
                            </li>
                            <li>
                                <a href="https://www.jualkubahmasjid.id/masjid-agung-kalianda/">Pesona Masjid Agung
                                    Kalianda Ikon Megah Lampung Selatan</a>
                            </li>
                            <li>
                                <a href="https://www.jualkubahmasjid.id/nama-nama-masjid-yang-bagus/">90 Daftar
                                    Nama-Nama Masjid yang Bagus dan Maknanya</a>
                            </li>
                            <li>
                                <a href="https://www.jualkubahmasjid.id/masjid-terdekat/">Cara Cepat Cari Masjid
                                    Terdekat Agar Ibadah Tetap Lancar</a>
                            </li>
                            <li>
                                <a href="https://www.jualkubahmasjid.id/jual-kubah-masjid-donggala/">Jual Kubah Masjid
                                    Donggala Harga Pabrik Termurah Bergaransi</a>
                            </li>
                        </ul>

                    </aside> -->
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
                                                    JUALKUBAHMASJID.ID - All rights reserved</p>
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
                                                        <span class="elementor-icon-list-icon">
                                                            <i aria-hidden="true" class="fab fa-facebook-square"></i>
                                                        </span>
                                                        <span class="elementor-icon-list-text">Facebook</span>
                                                    </li>
                                                    <li class="elementor-icon-list-item elementor-inline-item">
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
                                                    <a href="https://wa.me/6285168613452?text=Assalamualaikum%20PT%20KUBAH%20MANDIRI%20INDONESIA%2C%20mohon%20info%20kubahnya%3F"
                                                        class="elementor-button-link elementor-button elementor-size-xs"
                                                        role="button" id="wa-generic">
                                                        <span class="elementor-button-content-wrapper">
                                                            <span
                                                                class="elementor-button-icon elementor-align-icon-left">
                                                                <i aria-hidden="true" class="fab fa-whatsapp"></i>
                                                            </span>
                                                            <span class="elementor-button-text">WhatsApp
                                                                085168613452</span>
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
                                                    <a href="https://wa.me/6285168613452?text=Assalamualaikum%20PT%20KUBAH%20MANDIRI%20INDONESIA%2C%20mohon%20info%20kubahnya%3F"
                                                        class="elementor-button-link elementor-button elementor-size-sm"
                                                        role="button" id="wa-generic">
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
                                                    <a href="https://wa.me/6285168613452?text=Assalamualaikum%20PT%20KUBAH%20MANDIRI%20INDONESIA%2C%20mohon%20info%20kubahnya%3F"
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
    <script
        src="https://www.jualkubahmasjid.id/wp-content/plugins/easy-table-of-contents/assets/js/elementor-toc-anchor-fix.js?ver=2.0.83"
        id="eztoc-elementor-anchor-fix-js"></script>
    <script id="eztoc-scroll-scriptjs-js-extra">
        var eztoc_smooth_local = {
            "scroll_offset": "30",
            "add_request_uri": "",
            "add_self_reference_link": ""
        };
        //# sourceURL=eztoc-scroll-scriptjs-js-extra
    </script>
    <script
        src="https://www.jualkubahmasjid.id/wp-content/plugins/easy-table-of-contents/assets/js/smooth_scroll.min.js?ver=2.0.83"
        id="eztoc-scroll-scriptjs-js"></script>
    <script
        src="https://www.jualkubahmasjid.id/wp-content/plugins/easy-table-of-contents/vendor/js-cookie/js.cookie.min.js?ver=2.2.1"
        id="eztoc-js-cookie-js"></script>
    <script
        src="https://www.jualkubahmasjid.id/wp-content/plugins/easy-table-of-contents/vendor/sticky-kit/jquery.sticky-kit.min.js?ver=1.9.2"
        id="eztoc-jquery-sticky-kit-js"></script>
    <script id="eztoc-js-js-extra">
        var ezTOC = {
            "smooth_scroll": "1",
            "visibility_hide_by_default": "1",
            "scroll_offset": "30",
            "fallbackIcon": "\u003Cspan class=\"\"\u003E\u003Cspan class=\"eztoc-hide\" style=\"display:none;\"\u003EToggle\u003C/span\u003E\u003Cspan class=\"ez-toc-icon-toggle-span\"\u003E\u003Csvg style=\"fill: #999;color:#999\" xmlns=\"http://www.w3.org/2000/svg\" class=\"list-377408\" width=\"20px\" height=\"20px\" viewBox=\"0 0 24 24\" fill=\"none\"\u003E\u003Cpath d=\"M6 6H4v2h2V6zm14 0H8v2h12V6zM4 11h2v2H4v-2zm16 0H8v2h12v-2zM4 16h2v2H4v-2zm16 0H8v2h12v-2z\" fill=\"currentColor\"\u003E\u003C/path\u003E\u003C/svg\u003E\u003Csvg style=\"fill: #999;color:#999\" class=\"arrow-unsorted-368013\" xmlns=\"http://www.w3.org/2000/svg\" width=\"10px\" height=\"10px\" viewBox=\"0 0 24 24\" version=\"1.2\" baseProfile=\"tiny\"\u003E\u003Cpath d=\"M18.2 9.3l-6.2-6.3-6.2 6.3c-.2.2-.3.4-.3.7s.1.5.3.7c.2.2.4.3.7.3h11c.3 0 .5-.1.7-.3.2-.2.3-.5.3-.7s-.1-.5-.3-.7zM5.8 14.7l6.2 6.3 6.2-6.3c.2-.2.3-.5.3-.7s-.1-.5-.3-.7c-.2-.2-.4-.3-.7-.3h-11c-.3 0-.5.1-.7.3-.2.2-.3.5-.3.7s.1.5.3.7z\"/\u003E\u003C/svg\u003E\u003C/span\u003E\u003C/span\u003E",
            "visibility_hide_by_device": "1",
            "chamomile_theme_is_on": ""
        };
        //# sourceURL=eztoc-js-js-extra
    </script>
    <script
        src="https://www.jualkubahmasjid.id/wp-content/plugins/easy-table-of-contents/assets/js/front.min.js?ver=2.0.83-1778255783"
        id="eztoc-js-js"></script>
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
    <script
        src="https://www.jualkubahmasjid.id/wp-content/plugins/elementor-pro/assets/lib/smartmenus/jquery.smartmenus.min.js?ver=1.0.1"
        id="smartmenus-js"></script>
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
                "id": 0,
                "title": "Blog",
                "excerpt": ""
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
<?php
// Close database connection
$conn->close();
?>