<?php
$data = $args['data'];
js_log($data);

$cards = $data['cards'] ?? [];
?>

<section data-module="categories_grid">
    <div class="categories-inner">
        <?php if (!empty($cards)) : ?>
            <div class="categories-grid">
                <?php foreach ($cards as $card) : 
                    $image       = $card['image'] ?? null;
                    $title       = $card['title'] ?? '';
                    $description = $card['description'] ?? '';
                    $button_text = $card['button_text'] ?: 'Mehr Infos';
                    $url         = $card['url'] ?? '#';
                ?>
                    <article class="category-card">
                        <div class="category-card-inner">
                            <div class="category-card-shape">
                                <div class="category-card-visual">
                                    <?php if (!empty($image['src'])) : ?>
                                        <img class="category-card-image" src="<?= esc_url($image['src']); ?>" alt="<?= esc_attr($image['alt'] ?? $title); ?>">
                                    <?php endif; ?>
                                </div>

                                <div class="category-card-body">
                                    <?php if ($title) : ?>
                                        <h2 class="category-card-title"><?= esc_html($title); ?></h2>
                                    <?php endif; ?>

                                    <?php if ($description) : ?>
                                        <p class="category-card-description"><?= esc_html($description); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <a class="category-card-button" href="<?= esc_url($url); ?>" style="background-image: url('<?= get_template_directory_uri(); ?>/frontend/assets/images/Button_Hintergrund.png');">
                                <?= esc_html($button_text); ?>
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>