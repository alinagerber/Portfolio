<?php
$data = $args['data'];
js_log($data);

$lead    = $data['lead'] ?? '';
$name    = $data['name'] ?? '';
$email   = $data['email'] ?? '';
$image   = $data['image'] ?? null;
$socials = $data['socials'] ?? [];
?>

<section data-module="contact">
    <div class="contact-inner">
        <h1 class="contact-title"><?= esc_html(get_the_title()); ?></h1>

        <div class="contact-info">
            <?php if ($lead) : ?>
                <p class="contact-lead"><?= esc_html($lead); ?></p>
            <?php endif; ?>

            <div class="contact-details">
                <?php if ($name) : ?>
                    <strong><?= esc_html($name); ?></strong><br>
                <?php endif; ?>
                <?php if ($email) : ?>
                    <a href="mailto:<?= esc_attr($email); ?>"><?= esc_html($email); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="contact-visual">
        <?php if (!empty($image['src'])) : ?>
            <img class="contact-mountain" src="<?= esc_url($image['src']); ?>" alt="<?= esc_attr($image['alt'] ?? ''); ?>">
        <?php endif; ?>

        <?php if (!empty($socials)) : ?>
            <div class="contact-socials">
                <?php foreach ($socials as $social) : 
                    $badge = $social['badge'] ?? null;
                ?>
                    <?php if (!empty($badge['src'])) : ?>
                        <a class="social-badge-link" href="<?= esc_url($social['url'] ?? '#'); ?>" target="_blank" rel="noopener">
                            <img class="social-badge" src="<?= esc_url($badge['src']); ?>" alt="<?= esc_attr($badge['alt'] ?? ''); ?>">
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>