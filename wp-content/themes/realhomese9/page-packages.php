<?php


get_header();

// Page Head.
$header_variation = get_option('inspiry_agents_header_variation');

if (empty($header_variation) || ('none' === $header_variation)) {
    get_template_part('assets/modern/partials/banner/header');
} elseif (!empty($header_variation) && ('banner' === $header_variation)) {
    get_template_part('assets/modern/partials/banner/image');
}

if (inspiry_show_header_search_form()) {
    get_template_part('assets/modern/partials/properties/search/advance');
}

if (have_posts()) {

    while (have_posts()) {
        the_post();

        echo the_content();

    }
}

get_template_part('assets/modern/partials/packages/modal');

get_footer();
