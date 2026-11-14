<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

// -> Konfiguration der verschiedenen Module
Container::make('post_meta', 'Module')
    ->where('post_type', '=', 'page')
    ->add_fields([
        Field::make('complex', 'modules', 'Module')
            // -> example
            ->add_fields('example', 'Beispiel', [
                Field::make('text', 'title', 'Titel')->set_required(),
                Field::make('image', 'image', 'Bild')->set_required(),
            ])

            // -> Frontseite hero_front
            ->add_fields('hero_front', 'Hero Startseite', [
                Field::make('text', 'quote', 'Quote über den Bergen'),
                Field::make('image', 'image', 'Bild von Bergen')->set_required(true),
            ])

            // -> Kontaktseite contact 
            ->add_fields('contact', 'Kontaktseite', [
                Field::make('text', 'lead', 'Einleitungstext'),
                Field::make('text', 'name', 'Name'),
                Field::make('text', 'email', 'E-Mail-Adresse'),
                Field::make('image', 'image', 'Bergbild'),
                Field::make('complex', 'socials', 'Social-Media-Icons')
                    ->add_fields([
                        Field::make('image', 'badge', 'Social-Badge (PNG mit Handle & Icon)'),
                        Field::make('text', 'url', 'Profil-URL'),
                    ]),
            ])

            // -> Karten für Einstiegsseite mit 4 Kategorien categories_grid
            ->add_fields('categories_grid', 'Überkategorien Startseite', [
                Field::make('complex', 'cards', 'Blaue Karten')
                    ->set_max(4)
                    ->set_header_template('<% if (title) { %><%- title %><% } %>')
                    ->add_fields([
                        Field::make('image', 'image', 'Vorschaubild')->set_required(true),
                        Field::make('text', 'title', 'Titel (z. B. Fotografie)')->set_required(true),
                        Field::make('textarea', 'description', 'Kurzbeschreibung')->set_rows(4),
                        Field::make('text', 'button_text', 'Button-Text')->set_default_value('Mehr Infos'),
                        Field::make('text', 'url', 'Ziel-URL (Link zur Kategorie-Seite)'),
                    ]),
            ])

            // -> Über mich Teaser Startseite about_teaser
            ->add_fields('about_teaser', 'Über mich Teaser Startseite', [
                Field::make('image', 'portrait', 'Porträtbild')->set_required(true),
                Field::make('image', 'signature', 'Unterschrift (weisses PNG/SVG)'),
                Field::make('text', 'title', 'Titel')->set_default_value('DAS GESICHT HINTER DER KAMERA'),
                Field::make('textarea', 'quote', 'Zitat / Statement')->set_rows(4),
                Field::make('text', 'button_text', 'Button-Text')->set_default_value('Mehr über mich'),
                Field::make('text', 'url', 'Ziel-URL (Link zur Über-mich-Seite)'),
            ])

            // -> Über mich Seite about_page
            ->add_fields('about_page', 'Über mich Seite', [
                Field::make('text', 'page_title', 'Seitentitel')->set_default_value('ÜBER MICH'),
                Field::make('image', 'photo', 'Foto')->set_required(true),
                Field::make('text', 'name_heading', 'Überschrift über Text')->set_default_value('ALINA GERBER'),
                Field::make('rich_text', 'bio_text', 'Über-mich-Text'),
            ])
            // todo: add new modules here
            // -> SETTINGS
            ->set_layout('tabbed-vertical')
    ]);

// -> Funktion, um die Module und die entsprechenden Templates auf der Seite zu laden
function render_modules(): void {
    $modules = carbon_get_the_post_meta('modules');
    if (empty($modules)) {
        return;
    }
    foreach ($modules as $module) {
        // -> Modifiziere die Daten des Moduls, falls nötig, basierend auf dem Modultyp
        switch ($module['_type']) {
            case 'example':
                $module['image'] = get_media_by_id($module['image'], 'full');
                break;
            case 'hero_front':
                $module['image'] = get_media_by_id($module['image'], 'full');
                break;
            case 'contact':
                if (!empty($module['image'])) {
                    $module['image'] = get_media_by_id($module['image'], 'full');
                }
                if (!empty($module['socials'])) {
                    foreach ($module['socials'] as $key => $social) {
                        if (!empty($social['badge'])) {
                            $module['socials'][$key]['badge'] = get_media_by_id($social['badge'], 'full');
                        }
                    }
                }
                break;
            case 'categories_grid':
                if (!empty($module['cards'])) {
                    foreach ($module['cards'] as $key => $card) {
                        if (!empty($card['image'])) {
                            $module['cards'][$key]['image'] = get_media_by_id($card['image'], 'large');
                        }
                    }
                }
                break;
                case 'about_teaser':
                if (!empty($module['portrait'])) {
                    $module['portrait'] = get_media_by_id($module['portrait'], 'large');
                }
                if (!empty($module['signature'])) {
                    $module['signature'] = get_media_by_id($module['signature'], 'full');
                }
                break;
                case 'about_page':
                if (!empty($module['photo'])) {
                    $module['photo'] = get_media_by_id($module['photo'], 'large');
                }
                break;
            // todo: add data modifications for modules here as a new case
        }
        // -> Laden des Templates basierend auf dem Modultyp und weitergeben der Daten
        get_template_part(
            'frontend/views/modules/' . $module['_type'],
            null,
            [
                'data' => $module
            ]
        );
    }
}