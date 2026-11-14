<?php
$data = $args['data'];
js_log($data);

$page_title   = $data['page_title'] ?? '';
$photo        = $data['photo'] ?? null;
$name_heading = $data['name_heading'] ?? '';
$bio_text     = $data['bio_text'] ?? '';
?>

<section data-module="about_page">
    <div class="about-page-inner">
        <?php if ($page_title) : ?>
            <h1 class="about-page-title"><?= esc_html($page_title); ?></h1>
        <?php endif; ?>

        <div class="about-page-grid">
            <div class="about-page-media">
                <?php if (!empty($photo['src'])) : ?>
                    <img class="about-page-photo" src="<?= esc_url($photo['src']); ?>" alt="<?= esc_attr($photo['alt'] ?? $name_heading); ?>">
                <?php endif; ?>

                <img class="about-page-paper" src="<?= get_template_directory_uri(); ?>/frontend/assets/images/paper-corner.png" alt="" aria-hidden="true">
            </div>

            <div class="about-page-content">
                <?php if ($name_heading) : ?>
                    <h2 class="about-page-heading"><?= esc_html($name_heading); ?></h2>
                <?php endif; ?>

                <?php if ($bio_text) : ?>
                    <div class="about-page-bio">
                        <?= wp_kses_post(wpautop($bio_text)); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>