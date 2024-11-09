<?php
function wpb_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_field('algemeen', 'option')['login_pagina_logo']['url']; ?>);
            height:100px;
            width:300px;
            background-size: 300px 100px;
            background-repeat: no-repeat;
            padding-bottom: 10px;
        }

        body.login {
            background-color: <?php echo get_field('algemeen', 'option')['login_pagina_achtergrond_kleur']; ?>;
        }

        .wp-core-ui .button-primary {
            background-color: <?php echo get_field('algemeen', 'option')['login_pagina_achtergrond_kleur']; ?>!important;
            border-color: <?php echo get_field('algemeen', 'option')['login_pagina_achtergrond_kleur']; ?> !important;
            color: <?php echo get_field('algemeen', 'option')['login_pagina_links_kleur']; ?>!important;
        }

        .login #backtoblog a, .login #nav a {
            color: <?php echo get_field('algemeen', 'option')['login_pagina_links_kleur']; ?>!important;
        }

        .login form {
            border-radius: 10px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'wpb_login_logo' );