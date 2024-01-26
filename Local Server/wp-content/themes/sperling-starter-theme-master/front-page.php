<?php get_header(); ?>

    <?php 

    $args = array(
        'post_type'         => 'players',
        'posts_per_page'    => 999999
    );

    $players_query = new WP_Query( $args );

    $args = array(
        'post_type'         => 'teams',
        'posts_per_page'    => 999999
    );

    $teams_query = new WP_Query( $args );

    $args = array(
        'post_type'         => 'games',
        'posts_per_page'    => 999999
    );

    $games_query = new WP_Query( $args );

    ?>

    <div class="columns headerColumns">
        <!-- logo -->
        <div class="column logoColumn">
        
            <div class="logo">
                <a href="<?php echo home_url(); ?>">
                    <img src="<?php echo get_theme_file_uri('/img/screenshot.png')?>" alt="Logo" class="logo-img no-lazy logoHeader" >
                </a>
            </div>
        </div>
        <!-- /logo -->

        <!-- team slider -->
        <div class="column header-slider1">
            <?php if ( $games_query ) : ?>

                <div class="team-caricel">

                <!-- the loop -->
                    <?php foreach($games_query->posts as $game):?>
                    <div>
                        <h2  class="header-h2">
                            <a href="<?php echo get_permalink($game->ID); ?>">
                                <?php if(has_post_thumbnail($game->ID)){
                                    echo get_the_post_thumbnail($game, 'head_slider');
                                } else {
                                    echo get_the_title($game);
                                } ?>
                                
                            </a>
                        </h2>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <!-- /team slider -->

        <!-- Somthing random -->
        <a href="http://localhost:8888/myform/">
            <div class="column random">
                <p style="margin:0px; text-align:center;color:#C992F0;"><b>Add Stats Form</b></p>
                <a href="http://localhost:8888/myform/">
                    <img src="<?php echo get_theme_file_uri('/img/add_stats.svg')?>" alt="Logo" class="logo-img no-lazy statsHeader">
                </a>
            </div>
        </a>
        <!-- /Somthing random -->
    </div>

    <div class="color-line-top"> </div>

    <div class="header-slider-div">
        <?php if ( $teams_query ) : ?>

            <div class="team-caricel-home">

            <!-- the loop -->
                <?php foreach($teams_query->posts as $team):?>
                <div>
                    <h2>
                        <a href="<?php echo get_permalink($team->ID); ?>" class="header-h2">
                            <?php if(has_post_thumbnail($team->ID)){
                                echo get_the_post_thumbnail($team);
                            } else {
                                echo get_the_title($team);
                            } ?>
                            
                        </a>
                    </h2>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="div-line"> </div>

    <div class="header-slider-div">
        <?php if ( $players_query ) : ?>

            <div class="team-caricel-home">

            <!-- the loop -->
                <?php foreach($players_query->posts as $player):?>
                <div>
                    <h2>
                        <a href="<?php echo get_permalink($player->ID); ?>" class="header-h2">
                            <?php if(has_post_thumbnail($player->ID)){
                                echo get_the_post_thumbnail($player);
                            } else {
                                echo get_the_title($player);
                            } ?>
                            
                        </a>
                    </h2>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>


    <div class="color-line-bottom"> </div>

    <script>
        (function($) {
            $('.team-caricel').slick({
                infinite: true,
                slidesToShow: 4,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 10000,
            });
            
        })( jQuery );

        (function($) {
            $('.team-caricel-home').slick({
                infinite: true,
                slidesToShow: 5,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 10000,
            });
            
        })( jQuery );
    </script>

<?php get_footer(); ?>
