<?php
$data = $args['data'];
js_log($data);

$title  = $data['title'] ?? '';
$images = $data['images'] ?? [];

if (empty($images)) {
    return;
}

$start_index = count($images) >= 5 ? 2 : (count($images) >= 3 ? 1 : 0);
?>

<section data-module="photo_gallery_about" data-start-index="<?= esc_attr($start_index); ?>">
    <div class="photo-gallery-inner">
        <?php if ($title) : ?>
            <h2 class="photo-gallery-title"><?= esc_html($title); ?></h2>
        <?php endif; ?>

        <div class="photo-gallery-stage-wrap">
            <button type="button" class="photo-gallery-arrow photo-gallery-prev" aria-label="Vorheriges Bild">
                <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </button>

            <div class="photo-gallery-stage" tabindex="0" aria-label="3D-Bildergalerie">
                <?php foreach ($images as $index => $image) : ?>
                    <div class="photo-gallery-item" data-index="<?= esc_attr($index); ?>">
                        <img
                            class="photo-gallery-image"
                            src="<?= esc_url($image['src']); ?>"
                            alt="<?= esc_attr($image['alt'] ?? 'Galeriebild ' . ($index + 1)); ?>"
                            draggable="false"
                        >
                    </div>
                <?php endforeach; ?>
            </div>

            <button type="button" class="photo-gallery-arrow photo-gallery-next" aria-label="Nächstes Bild">
                <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </button>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const getMetrics = () => {
        const isMobile = window.innerWidth <= 680;
        const isTablet = window.innerWidth <= 1100;
        return {
            stepAngle: isMobile ? 35 : (isTablet ? 28 : 25),
            radius: isMobile ? 460 : (isTablet ? 680 : 840) // <-- schmalerer Zylinder (vorher 980)
        };
    };

    document.querySelectorAll('[data-module="photo_gallery_about"]').forEach((gallery) => {
        const items = Array.from(gallery.querySelectorAll('.photo-gallery-item'));
        const prevBtn = gallery.querySelector('.photo-gallery-prev');
        const nextBtn = gallery.querySelector('.photo-gallery-next');
        const stage = gallery.querySelector('.photo-gallery-stage');
        const total = items.length;

        if (!total) return;

        let activeIndex = parseInt(gallery.dataset.startIndex || '0', 10) % total;

        const updatePositions = () => {
            const { stepAngle, radius } = getMetrics();

            items.forEach((item, i) => {
                let diff = (i - activeIndex) % total;
                if (diff > total / 2) diff -= total;
                if (diff < -total / 2) diff += total;

                const absDiff = Math.abs(diff);

                let scale = 0.5;
                if (absDiff === 0) scale = 1.38;
                else if (absDiff === 1) scale = 0.82;
                else if (absDiff === 2) scale = 0.62;

                if (absDiff <= 2) {
                    const angle = diff * stepAngle;
                    item.classList.add('is-visible');
                    item.style.opacity = absDiff === 2 ? '0.88' : '1';
                    item.style.zIndex = String(10 - absDiff);
                    item.style.transform = `translate(-50%, -50%) translateZ(-${radius}px) rotateY(${angle}deg) translateZ(${radius}px) scale(${scale})`;
                } else {
                    const side = diff < 0 ? -3 : 3;
                    const angle = side * stepAngle;
                    item.classList.remove('is-visible');
                    item.style.opacity = '0';
                    item.style.zIndex = '1';
                    item.style.transform = `translate(-50%, -50%) translateZ(-${radius}px) rotateY(${angle}deg) translateZ(${radius}px) scale(${scale})`;
                }
            });
        };

        const goTo = (index) => {
            activeIndex = (index + total) % total;
            updatePositions();
        };

        prevBtn?.addEventListener('click', () => goTo(activeIndex - 1));
        nextBtn?.addEventListener('click', () => goTo(activeIndex + 1));

        stage?.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') goTo(activeIndex - 1);
            if (e.key === 'ArrowRight') goTo(activeIndex + 1);
        });

        let touchStartX = 0;
        stage?.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });

        stage?.addEventListener('touchend', (e) => {
            const deltaX = e.changedTouches[0].screenX - touchStartX;
            if (Math.abs(deltaX) > 40) {
                goTo(deltaX > 0 ? activeIndex - 1 : activeIndex + 1);
            }
        }, { passive: true });

        window.addEventListener('resize', updatePositions);
        updatePositions();
    });
});
</script>