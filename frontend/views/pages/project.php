<?php
$project = get_project_by_id(get_the_ID());
js_log($project);
?>

<main>
 <h1><?= $project['title'] ?></h1>
    <img src="<?= $project['image']['src'] ?>" alt="<?= $project['image']['alt'] ?>">
<div>
<?= wpautop($project['text']) ?>
</div>

<?php if (!empty($project['button_url'])) : ?>
        <a href="<?= esc_url($project['button_url']) ?>" class="btn-custom" target="_blank" rel="noopener noreferrer">
            <?= esc_html($project['button_label'] ?: 'Zum Film') ?>
        </a>
    <?php endif; ?>

</main>