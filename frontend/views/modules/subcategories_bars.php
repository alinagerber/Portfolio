<?php
$data = $args['data'];
js_log($data);

$title       = !empty($data['title']) ? $data['title'] : get_the_title();
$parent_data = $data['parent_category'] ?? [];
$taxonomy    = 'project_category';

if (empty($parent_data[0]['id'])) {
    return;
}

$parent_id = (int) $parent_data[0]['id'];

// Alle Unterkategorien dieser Überklasse laden
$subcategories = get_terms([
    'taxonomy'   => $taxonomy,
    'parent'     => $parent_id,
    'hide_empty' => false,
]);

if (empty($subcategories) || is_wp_error($subcategories)) {
    return;
}

$fallback_colors = ['blue', 'brown', 'olive', 'beige'];
?>

<section data-module="subcategories_bars">
    <div class="subcategories-inner">
        <?php if ($title) : ?>
            <h1 class="subcategories-title"><?= esc_html($title); ?></h1>
        <?php endif; ?>

        <div class="subcategories-list">
            <?php foreach ($subcategories as $index => $term) :
                $target_project = carbon_get_term_meta($term->term_id, 'category_target_project');
                $term_link      = !empty($target_project[0]['id'])
                    ? get_permalink((int) $target_project[0]['id'])
                    : get_term_link($term);

                $img_id  = carbon_get_term_meta($term->term_id, 'category_image');
                $media   = $img_id ? get_media_by_id($img_id, 'large') : null;
                $color   = carbon_get_term_meta($term->term_id, 'category_color') ?: $fallback_colors[$index % count($fallback_colors)];
                $img_pos = carbon_get_term_meta($term->term_id, 'category_image_position') ?: 'center center';
            ?>
                <a href="<?= esc_url($term_link); ?>" class="subcategory-bar is-<?= esc_attr($color); ?>">
                    <div class="subcategory-bar-bg">
                        <?php if (!empty($media['src'])) : ?>
                            <img
                                class="subcategory-bar-img"
                                src="<?= esc_url($media['src']); ?>"
                                alt="<?= esc_attr($media['alt'] ?: $term->name); ?>"
                                style="object-position: <?= esc_attr($img_pos); ?>;"
                                draggable="false"
                            >
                        <?php endif; ?>
                    </div>

                    <span class="subcategory-bar-label">
                        <?= esc_html($term->name); ?>
                    </span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>