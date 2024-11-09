<?php
function acf_field( $field ) {
    if(is_admin() && get_post_type() === 'acf-field-group') {
        return $field;
    }

    if($field['type'] === 'flexible_content') {
        foreach ($field['layouts'] as &$layout) {
            $label = substr($layout['label'], 0);
            $filename = str_replace('_', '-',$layout['name'] ) . '.png';
            $url = get_template_directory() . '/dist/images/flexible-content-preview/' . $filename;

            $layout['label'] = '<div class="acf-fc-block">';
            if ( file_exists($url)) {
                $layout['label'] .= '<div class="acf-fc-block-image" style="background-image:url(' .  get_template_directory_uri() . '/dist/images/flexible-content-preview/' . $filename . ')"></div>';
            } else {
                $layout['label'] .= '<div class="acf-fc-block-image" style="background-image:url(' . get_template_directory_uri() . '/dist/images/flexible-content-preview/no-image-available.png' . ')"></div>';
            }
            $layout['label'] .= '<div class="acf-fc-block-title">';
            $layout['label'] .= '<p class="acf-fc-block-title-text">' . $label . '</p>';
            $layout['label'] .= '<button class="acf-fc-block-title-button button button-primary">' . __('Invoegen', 'flexible-content-preview' ) . '</button>';
            $layout['label'] .= '</div>';
            $layout['label'] .= '</div>';
        }
    }
    return $field;
}

add_filter('acf/load_field', 'acf_field');