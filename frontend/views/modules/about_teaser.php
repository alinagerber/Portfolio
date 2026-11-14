<?php
$data = $args['data'];
js_log($data);

$portrait    = $data['portrait'] ?? null;
$signature   = $data['signature'] ?? null;
$title       = $data['title'] ?? '';
$quote       = $data['quote'] ?? '';
$button_text = $data['button_text'] ?: 'Mehr über mich';
$url         = $data['url'] ?? '#';
?>

<section data-module="about_teaser">
    <div class="about-teaser-inner">
        <div class="about-teaser-media">
            <?php if (!empty($portrait['src'])) : ?>
                <div class="about-teaser-portrait-wrap">
                    <img class="about-teaser-portrait" src="<?= esc_url($portrait['src']); ?>" alt="<?= esc_attr($portrait['alt'] ?? $title); ?>">
                </div>
            <?php endif; ?>

            <?php if (!empty($signature['src'])) : ?>
                <img class="about-teaser-signature" src="<?= esc_url($signature['src']); ?>" alt="<?= esc_attr($signature['alt'] ?? 'Unterschrift Alina Gerber'); ?>">
            <?php endif; ?>
        </div>

        <div class="about-teaser-content">
            <?php if ($title) : ?>
                <h2 class="about-teaser-title"><?= esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if ($quote) : ?>
                <blockquote class="about-teaser-quote">
                    <?= nl2br(esc_html($quote)); ?>
                </blockquote>
            <?php endif; ?>

            <a class="about-teaser-button" href="<?= esc_url($url); ?>" style="background-image: url('<?= get_template_directory_uri(); ?>/frontend/assets/images/Button_Hintergrund.png');">
                <?= esc_html($button_text); ?>
            </a>
        </div>
    </div>
</section>