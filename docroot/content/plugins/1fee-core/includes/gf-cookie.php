<?php
class GFCookie {

    public static $cookie_prefix = 'gfc_';
    public static $session = false;
    public static $fresh_cookies = array();

    public static function init() {

        //GFCookie::delete_cookies(); exit;

        if(!is_admin()) {
            add_action('parse_request', array('GFCookie', 'save_cookie'), 9);
            add_action('gform_pre_render', array('GFCookie', 'load_cookie'));
        }

        add_shortcode('gf_cookied_link', array('GFCookie', 'cookied_link_shortcode'));

    }

    public static function save_cookie() {

        // if cookies are not enabled, default to session use
        // start the session regardless of $_GET being empty as session may have been previously populated
        if(!self::cookies_enabled()) {
            session_start();
        }

        // don't do anything with cookie if there is no data
        if(!empty($_GET))
            self::save_get_data();

        self::save_server_data();

    }

    public static function load_cookie($form = null) {

        $cookie = self::get_cookie_data(false);

        foreach($cookie as $key => $value) {

            // skip cookies that were not added by us
            if(strpos($key, self::$cookie_prefix) === false)
                continue;

            // load cookie value into $_GET for population into Gravity Forms
            $key = str_replace(self::$cookie_prefix, '', $key);
            $_GET[$key] = $value;

        }

        // if gfc referrer is set, find {referer} merge tag and replace
        if(self::get_cookie_data('HTTP_REFERER')) {
            foreach($form['fields'] as &$field) {
                if(strpos(rgar($field, 'defaultValue'), '{referer}') !== false)
                    $field['defaultValue'] = str_replace('{referer}', self::get_cookie_data('HTTP_REFERER'), $field['defaultValue']);
            }
        }

        return $form;
    }

    public static function get_cookie_data($key = false) {

        $session = isset($_SESSION) && is_array($_SESSION) ? $_SESSION : array();
        $cookie = self::cookies_enabled() ? $_COOKIE : $session;

        // cookies that have not yet been sent through the header are merged with existing cookies
        $cookie = array_merge($cookie, self::$fresh_cookies);

        if($key === false)
            return $cookie;

        $gfc_key = self::$cookie_prefix . $key;

        return rgar($cookie, $gfc_key);
    }

    public static function save_get_data() {

        $reserved_words = array('attachment_id', 'author', 'author_name', 'calendar', 'cat', 'category', 'category__and', 'category__in', 'category__not_in', 'category_name', 'comments_per_page', 'comments_popup', 'cpage', 'day', 'debug', 'error', 'exact', 'feed', 'hour', 'link_category', 'm', 'minute', 'monthnum', 'more', 'name', 'nav_menu', 'nopaging', 'offset', 'order', 'orderby', 'p', 'page', 'page_id', 'paged', 'pagename', 'pb', 'perm', 'post', 'post__in', 'post__not_in', 'post_format', 'post_mime_type', 'post_status', 'post_tag', 'post_type', 'posts', 'posts_per_archive_page', 'posts_per_page', 'preview', 'robots', 's', 'search', 'second', 'sentence', 'showposts', 'static', 'subpost', 'subpost_id', 'tag', 'tag__and', 'tag__in', 'tag__not_in', 'tag_id', 'tag_slug__and', 'tag_slug__in', 'taxonomy', 'tb', 'term', 'type', 'w', 'withcomments', 'withoutcomments', 'year', 'DBGSESSID');

        foreach($_GET as $key => $value) {
            if(!in_array($key, $reserved_words)) {
                self::save_data($key, $value);
            }
        }

    }

    public static function save_server_data() {

        $server_keys = array('HTTP_REFERER');

        foreach($_SERVER as $key => $value) {
            if(in_array($key, $server_keys))
                self::save_data($key, $value);
        }

    }

    public static function save_data($key, $value) {

        $gfc_key = self::$cookie_prefix . $key;

        if(self::cookies_enabled()) {
            if(!rgar($_COOKIE, $gfc_key)) {
                setcookie($gfc_key, $value, time() + 60*60*24*60, '/');
                self::$fresh_cookies[$gfc_key] = $value;
            }
        } else {
            if(!rgar($_SESSION, $gfc_key)) {
                $_SESSION[$gfc_key] = $value;
                self::$fresh_cookies[$gfc_key] = $value;
            }
        }

    }

    /**
    * WP uses cookies by default so if $_COOKIES global is empty, cookies are likely not enabled
    *
    */
    public static function cookies_enabled() {
        return !empty($_COOKIE);
    }

    public static function delete_cookies() {
        foreach($_COOKIE as $key => $value) {
            if(strpos($key, self::$cookie_prefix) !== false) {
                self::delete_cookie($key);
            }
        }
    }

    public static function delete_cookie($key) {
        setcookie($key, null, time() - 3600, '/');
    }

    public static function cookied_link_shortcode($atts) {

        extract( shortcode_atts( array(
            'url' => false
        ), $atts ) );

        return !$url ? '' : gf_get_cookied_link($url);
    }

}
