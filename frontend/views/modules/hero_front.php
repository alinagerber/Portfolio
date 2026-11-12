<?php
$data = $args['data'];
js_log($data);
?>

<section data-module="hero_front">
    <h1 class="hero-title"><?= $data['quote']; ?></h1>
    <img class="hero-image" src="<?= $data['image']['src']; ?>" alt="<?= $data['image']['alt']; ?>">
    <img class="paper-divider" src="<?= get_template_directory_uri(); ?>/frontend/assets/images/Paper_Divider.png" alt="Papierstreifen">
</section>
