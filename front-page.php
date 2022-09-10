<?php get_header();
  $id_array = array();
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
            <h2>Je prends rendez-vous avec un expert pays</h2>
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
            'order' => 'DESC'
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) : ?>
            <div class="experts container-narrow">
                <?php while( $query->have_posts() ) : $query->the_post();
                $data = new stdClass();
                $data->id = get_the_ID();
                $data->pays = get_field('pays');
                array_push($id_array, $data) ?>
                    <div class="expert <?= get_the_ID(); ?>">
                        <div class="thumbnail">
                            <?php the_post_thumbnail('full'); ?>
                        </div>
                        <div class="content">
                            <h2><?php the_title(); ?></h2>
                            <?php the_content(); ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php wp_reset_postdata(); endif; ?>
    </section>

    <script>
        const { createApp } = Vue;

        createApp( {
            data () {
                return {
                    data: null,
                    slots: null
                }
            },
            mounted () {
                this.data = <?php echo json_encode($id_array); ?>;

            },
            methods: {
                showExpert(e) {
                    const experts = document.querySelectorAll('.expert');
                    experts.forEach(expert => {
                        expert.classList.remove('active');
                        if( expert.classList.contains(e.target.value) ) {
                            expert.classList.add('active')
                            this.slots = document.querySelectorAll('.availableslot > a');
                            this.slots = this.slots.forEach( slot => slot.textContent = slot.textContent.slice(0,2) + 'h' )
                        }
                    })
                }
            }
        } ).mount( '#root' )

    </script>
</main>

<?php get_footer(); ?>
