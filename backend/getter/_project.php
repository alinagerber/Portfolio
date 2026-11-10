<?php

function get_project_by_id(int $id): array {
    $title = get_the_title($id);
    $image_id = carbon_get_post_meta($id, 'image');
    $image = get_media_by_id($image_id);
    $text = carbon_get_post_meta($id, 'text');
    $button_label = carbon_get_the_post_meta('button_label');
    $button_url   = carbon_get_the_post_meta('button_url');

    return [
        'title' => $title,
        'image' => $image,
        'text' => $text,
        'button_label' => $button_label,
        'button_url' => $button_url
    ];

    js_log($title);
    //js_log('soll infos zum Projekt zurückgeben mit ID:' . $id);  
}