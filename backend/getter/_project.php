<?php

function get_project_by_id(int $id): array {
    $title        = get_the_title($id);
    $image_id     = carbon_get_post_meta($id, 'image');
    $image        = get_media_by_id($image_id);
    $text         = carbon_get_post_meta($id, 'text');
    $button_label = carbon_get_post_meta($id, 'button_label');
    $button_url   = carbon_get_post_meta($id, 'button_url');

    // -> Projektkategorie sicher laden:
    $terms = get_the_terms($id, 'project_category');
    $project_categories = $terms ? array_map(fn($item) => $item->name, $terms) : [];

    return [
        'title'              => $title,
        'image'              => $image,
        'text'               => $text,
        'button_label'       => $button_label,
        'button_url'         => $button_url,
        'project_categories' => $project_categories
    ];
}