<?php
add_action('after_setup_theme', 'remove_admin_bar_frontend');
if (!current_user_can('administrator')) {
    add_action('admin_enqueue_scripts', 'admin_editor_css');
    add_action('wp_dashboard_setup', 'remove_dashboard_widgets');
    add_action('admin_menu', 'remove_tool_menu');
    add_filter('admin_footer_text', 'custom_admin_footer');
    add_action('admin_menu', 'linked_url', 999);
    add_action('admin_menu', 'linkedurl_function', 999);
    add_action('load-index.php', 'dashboard_redirect');
    add_filter('login_redirect', 'login_redirect', 10, 3);
    add_action('admin_menu', 'remove_menus');
}

function remove_admin_bar_frontend() {
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}

function admin_editor_css() {
    ?>
        <style type="text/css">
            div#wpadminbar, #toplevel_page_wpseo_workouts, #contextual-help-link-wrap { display: none!important; }
            html.wp-toolbar { padding-top: 0!important; }
            #wpcontent, #wpfooter { margin-left: 220px!important; }
            #adminmenu, #adminmenu .wp-submenu, #adminmenuback, #adminmenuwrap { width: 220px!important; }
            #adminmenu .wp-submenu { left: 220px!important; }
            #adminmenu .wp-has-current-submenu .wp-submenu, #adminmenu .wp-has-current-submenu .wp-submenu.sub-open, #adminmenu .wp-has-current-submenu.opensub .wp-submenu, .no-js li.wp-has-current-submenu:hover .wp-submenu { left: auto!important;}
            #toplevel_page_my_slug.wp-first-item { padding-bottom: 5px; border-bottom: 1px solid #f1f1f155!important; }
        </style>
        <?php
}

function remove_dashboard_widgets() {
    global $wp_meta_boxes;
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
    remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'side' );
    remove_meta_box('wpseo-wincher-dashboard-overview', 'dashboard', 'normal');
}

function remove_tool_menu() {
    if (!current_user_can('administrator')) {
        remove_menu_page('tools.php');
    }
}

function custom_admin_footer() {
    echo get_field('algemeen', 'options')['admin_credits'];
}

function linked_url() {
    add_menu_page( 'linked_url', 'Terug naar de website', 'read', 'my_slug', '', 'dashicons-admin-home', 1 );
}

function linkedurl_function() {
    global $menu;
    $menu[1][2] = get_home_url();
}

function dashboard_redirect(){
    wp_redirect(admin_url('edit.php?post_type=page'));
}

function login_redirect( $redirect_to, $request, $user ){
    return admin_url('edit.php?post_type=page');
}

function remove_menus () {
    global $menu;
    $restricted = array(__('Dashboard'));
    end($menu);
    while(prev($menu)){
        $value = explode(' ',$menu[key($menu)][0]);
        if(in_array($value[0]!= NULL?$value[0]:'',$restricted)){unset($menu[key($menu)]);}
    }
}