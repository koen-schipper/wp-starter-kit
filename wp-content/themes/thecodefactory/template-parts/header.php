<?php
/**
 * Basic header component
 *
 * @package Vzero
 * @since 1.0.0
 */

$menu_args = array(
    'theme_location' => 'primary',
    'container' => 'nav',
    'container_class' => 'main-nav',
)
?>
<div class="container" x-data="{ openMenu : false }">
    <div class="logo">
        <a href="<?php echo esc_url(home_url('/')); ?>">
            <img src="<?php echo get_template_directory_uri().'/dist/images/logo.png' ?>" alt="logo"/>
        </a>
    </div>

    <div class="hamburger-button-wrapper" :class="{'open' : openMenu, 'closed' : !openMenu }">
        <button class="hamburger-button" @click="openMenu = !openMenu"
                :class="{'open' : openMenu, 'closed' : !openMenu }">
            <i>Menu</i>
            <span class="text-xs">Menu</span>
        </button>
    </div>

    <div class="menu-wrapper" x-cloak :class="{'open' : openMenu, 'closed' : !openMenu }">
        <?php wp_nav_menu($menu_args); ?>
    </div>
</div>
