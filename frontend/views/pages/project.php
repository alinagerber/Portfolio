<?php
$project = get_project_by_id(get_the_ID());
?>

<main data-page="project">
    <?php if (!empty($project['category_title'])) : ?>
        <h1 class="project-category"><?= esc_html($project['category_title']) ?></h1>
    <?php endif; ?>

    <div class="project-grid">
        <div class="project-media">
            <img src="<?= esc_url($project['image']['src']) ?>" alt="<?= esc_attr($project['image']['alt']) ?>">
        </div>

        <div class="project-content">
            <h2 class="project-title"><?= esc_html($project['title']) ?></h2>

            <div class="project-text">
                <?= wpautop($project['text']) ?>
            </div>

            <?php if (!empty($project['button_url'])) : ?>
                <a href="<?= esc_url($project['button_url']) ?>" class="btn-custom" target="_blank" rel="noopener noreferrer">
                    <?= esc_html($project['button_label'] ?: 'Zum Film') ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</main>