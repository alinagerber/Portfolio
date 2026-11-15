<?php
$term = get_queried_object();

$projects_query = new WP_Query([
    'post_type'      => 'project',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'tax_query'      => [
        [
            'taxonomy' => 'project_category',
            'field'    => 'term_id',
            'terms'    => $term->term_id,
        ],
    ],
]);
?>

<main data-page="project">
    <h1 class="project-category">
        <span class="category-item"><?= esc_html($term->name); ?></span>
    </h1>

    <?php if ($projects_query->have_posts()) : ?>
        <div class="project-category-list">
            <?php while ($projects_query->have_posts()) : $projects_query->the_post();
                $project = get_project_by_id(get_the_ID());
            ?>
                <div class="project-grid">
                    <?php if (!empty($project['image']['src'])) : ?>
                        <div class="project-media">
                            <img src="<?= esc_url($project['image']['src']); ?>" alt="<?= esc_attr($project['image']['alt'] ?: $project['title']); ?>">
                        </div>
                    <?php endif; ?>

                    <div class="project-content">
                        <h2 class="project-title"><?= esc_html($project['title']); ?></h2>

                        <?php if (!empty($project['text'])) : ?>
                            <div class="project-text">
                                <?= wpautop($project['text']); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($project['button_url'])) : ?>
                            <a href="<?= esc_url($project['button_url']); ?>" class="btn-custom" target="_blank" rel="noopener noreferrer">
                                <?= esc_html($project['button_label'] ?: 'Zum Film'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <?php wp_reset_postdata(); ?>
    <?php else : ?>
        <p class="project-category-empty">In dieser Kategorie sind aktuell noch keine Projekte hinterlegt.</p>
    <?php endif; ?>
</main>