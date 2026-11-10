<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make('post_meta', 'Projekt')
    ->where('post_type', '=', 'project')
    ->add_fields([
        Field::make('image', 'image', 'Bild')->set_required(true),
        Field::make('rich_text', 'text', 'Text')->set_required(true),
        Field::make('text', 'button_label', 'Button Beschriftung')->set_required(true),
        Field::make('text', 'button_url', 'Button Link (URL)')->set_required(true),
        // Felder hier einfügen
    ]);