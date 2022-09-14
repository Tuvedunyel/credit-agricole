<?php get_header();
$id_array = array();
$day = get_field('jour', 'option')
?>

<main class="front-page" id="root">
    <section class="hero-banner">
        <div class="left">
            <img src="<?= get_template_directory_uri() ?>/assets/credit-agricole-building.jpg" alt="Image d'un gratte
            ciel">
        </div>
        <div class="right">
            <h3><?php the_field('conference_dates'); ?></h3>
            <div class="first-conference">
                <div class="container">
                    <?php the_field('first_conference'); ?>
                </div>
            </div>
            <img src="<?= get_template_directory_uri(); ?>/assets/esperluette.svg" alt="esperluette"
                 class="esperluette">
            <div class="second-conference">
                <div class="container">
                    <?php the_field('second_conference') ?>
                </div>
            </div>
        </div>
    </section>
    <section class="expertpays">
        <div class="container-narrow">
            <h2>Je prends rendez-vous avec un expert pays pour <?= get_field('date', 'option'); ?></h2>
            <img src="<?= get_template_directory_uri() ?>/assets/pin.svg" alt="Pin de géolicalisation" class="pin">
            <div class="select-container">
                <select name="zone" id="zone" @change="showExpert">
                    <option value="0">Choisir ma zone géographique</option>
                    <option v-for=" pays in data " :value="pays.id">{{ pays.pays }}</option>
                </select>
                <div class="btn">
                    <div class="arrow-btn"></div>
                </div>
            </div>
        </div>
        <?php $args = array(
            'post_type' => 'post',
            'posts_per_page' => -1,
            'order' => 'ASC'
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) : ?>
            <div class="experts container-narrow">
                <?php while ($query->have_posts()) : $query->the_post();
                    $data = new stdClass();
                    $data->id = get_the_ID();
                    $data->pays = get_field('pays');
                    array_push($id_array, $data) ?>
                    <div class="expert <?= get_the_ID(); ?>">
                        <div class="thumbnail photo-expert">
                            <?php the_post_thumbnail('full'); ?>
                        </div>
                        <div :class=" switchBtn ?  'content active' : 'content' ">
                            <h2><?php the_title(); ?></h2>
                            <?php the_content(); ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            <?php wp_reset_postdata(); endif; ?>
    </section>
    <section class="conferences-generals">
        <div class="container-narrow">
            <h2>Inscription aux conférences <span class="border"></span></h2>
            <?php if (have_rows('conferences')) : ?>
                <div class="conférences">
                    <?php while (have_rows('conferences')) : the_row(); ?>
                        <article>
                            <div class="thumbnail">
                                <?php $image_conf = get_sub_field('image') ?>
                                <img src="<?= esc_url($image_conf['url']); ?> ?>" alt="<?= esc_attr($image_conf['alt']);
                                ?>>">
                            </div>
                            <div class="titles">
                                <?php if (get_sub_field('titre_normal') === 'Oui') : ?>
                                    <h3 class="regular"><?php the_sub_field('titre_petit'); ?></h3>
                                <?php endif; ?>
                                <h3><?php the_sub_field('titre'); ?></h3>
                            </div>
                            <div class="content">
                                <div class="txt">
                                    <?php the_sub_field('texte'); ?>
                                </div>
                                <div class="link">
                                    <p class="date-conference"><?php the_sub_field('date'); ?></p>
                                    <?php $lien = get_sub_field('lien_conference');
                                    $lien_target = $lien['target'] ? $lien['target'] : '_self';
                                    ?>
                                    <a href="<?= esc_url($lien['url']); ?>" target="<?= esc_attr($lien_target); ?>"
                                       class="inscription"
                                    ><?=
                                        esc_html($lien['title']); ?>
                                    </a>
                                </div>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
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

    <script>
        const { createApp } = Vue;

        createApp( {
            data () {
                return {
                    data: null,
                    formField: null,
                    switchBtn: false,
                    dates: null,
                    day: null,
                }
            },
            mounted () {
                this.data = <?php echo json_encode($id_array); ?>;
                this.day = <?= json_encode($day); ?>
                this.data.sort( (a, b) => {
                    return ( a.pays.toUpperCase() < b.pays.toUpperCase() ) ? -1 : ( a.pays.toUpperCase() > b.pays.toUpperCase() ) ? 1 : 0;
                });
            },
            methods: {
                showExpert ( e ) {
                    const experts = document.querySelectorAll( '.expert' );
                    experts.forEach( expert => {
                        expert.classList.remove( 'active' );
                        if ( expert.classList.contains( e.target.value ) ) {
                            expert.classList.add( 'active' )
                            this.dates = document.querySelectorAll( '.bc-col' );
                            this.dates.forEach( date => {
                                if ( date.dataset.date === `2022-10-${this.day}` ) {
                                    console.log( date );
                                    date.textContent = "Reservez votre rendez-vous"
                                    date.classList.add('currentDateActive')
                                } else {
                                    date.classList.add( 'remove' );
                                }
                            } )
                        }
                    } )
                },
                handleSwitchBtn () {
                    this.switchBtn = !this.switchBtn;
                }
            }
        } ).mount( '#root' )

    </script>
</main>

<?php get_footer(); ?>
