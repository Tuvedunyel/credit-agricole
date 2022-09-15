<footer>
    <div class="container-narrow">
        <?php if (have_rows('footer_lien', 'option')) : ?>
            <div class="lien-footer">
                <?php while (have_rows('footer_lien', 'option')) : the_row();
                    $lien_footer = get_sub_field('lien');
                    ?>
                    <a href="<?= esc_url($lien_footer['url']); ?>"><?= esc_html($lien_footer['title']); ?></a>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
        <p class="realiser">Réalisation: <a href="https://www.btg-communication.fr" target="_blank">Btg
                Communication</a></p>
        <p class="credit">&copy; Crédit Agricole</p>
    </div>
</footer>
<?php wp_footer( ); ?>
</body>
</html>