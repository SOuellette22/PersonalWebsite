<?php 

$argsP = array(
    'post_type'         => 'players',
    'posts_per_page'    => 999999
);

$players_query = new WP_Query( $argsP );

$argsT = array(
    'post_type'         => 'teams',
    'posts_per_page'    => 999999
);

$teams_query = new WP_Query( $argsT );

$argsG = array(
    'post_type'         => 'games',
    'posts_per_page'    => 999999
);

$games_query = new WP_Query( $argsG );
?>

<?php get_header(); ?>

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
            <?php if ( $players_query ) : ?>

                <div class="team-caricel">

                <!-- the loop -->
                    <?php foreach($players_query->posts as $player):?>
                    <div>
                        <h2 class="header-h2">
                            <a href="<?php echo get_permalink($player->ID); ?>">
                                <?php if(has_post_thumbnail($player->ID)){
                                    echo get_the_post_thumbnail($player, 'head_slider');
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

    <script>
        (function($) {
            $('.team-caricel').slick({
                infinite: true,
                slidesToShow: 4,
                slidesToScroll: 4,
                autoplay: true,
                autoplaySpeed: 10000,
            });
            
        })( jQuery );
    </script>
    
    <div class="container">
        <div class="columns">
            <div class="column">       
                <?php the_post_thumbnail('medium');?>
            </div>
            <div class="column">
                <h1>
                    <?php the_title(); ?>
                </h1>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <?php $the_player_stats_G = array(); ?>
                <?php $the_player_stats_A = array(); ?>
                <?php if($games_query): ?>
                    <?php foreach($games_query->posts as $games): ?>
                        <?php $id_player_stats_G = array(); ?>
                        <?php $id_player_stats_A = array(); ?>
                        <?php if(have_rows('team_stats', $games->ID)): ?>
                            <?php while(have_rows('team_stats', $games->ID)): the_row(); ?>
                                <?php $team = get_sub_field('team'); ?>
                                <?php $players = get_sub_field('players'); ?>
                                <?php if($players): ?>
                                    <?php if(have_rows('players')): ?>
                                        <?php while(have_rows('players')): the_row();?> 
                                            <?php $player = get_sub_field('player'); ?>
                                            <?php if($player === get_the_ID()):?>
                                                <?php $id_player_stats_G['game_id'] = $games->ID ?>
                                                <?php $id_player_stats_A['game_id'] = $games->ID ?>
                                                <?php $id_player_stats_G['team_id'] = $team ?>
                                                <?php $id_player_stats_A['team_id'] = $team ?>
                                                <?php $total_goals = null ?>
                                                <?php $total_assists = null ?>
                                                <?php $seasons_played = 0 ?>
                                                <?php for ($i = 1; $i <= 10; $i++):
                                                    $seasons = get_sub_field('season_'.$i);
                                                    if($seasons): ?>
                                                        <?php if(have_rows('season_'.$i)): ?>
                                                            <?php while(have_rows('season_'.$i)): the_row();
                                                                $goals = get_sub_field('goals');
                                                                $assists = get_sub_field('assists');?>
                                                                <?php $total_goals = $total_goals + $goals; ?>
                                                                <?php $total_assists = $total_assists + $assists; ?>
                                                                <?php $player_seasons_G[$i] = $goals ?>
                                                                <?php $player_seasons_A[$i] = $assists ?>
                                                                <?php if(($goals !== '' && $goals !== null) && ($assists !== '' && $assists !== null)) {
                                                                    $seasons_played++;
                                                                } ?>
                                                            <?php endwhile; ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                <?php endfor; ?>
                                                <?php $id_player_stats_G['total_goals'] = $total_goals ?>
                                                <?php $id_player_stats_A['total_assists'] = $total_assists ?>
                                                <?php $id_player_stats_G['seasons_played'] = $seasons_played ?>
                                                <?php $id_player_stats_A['seasons_played'] = $seasons_played ?>
                                                <?php $id_player_stats_G['seasons'] = $player_seasons_G?>
                                                <?php $id_player_stats_A['seasons'] = $player_seasons_A?>
                                                <?php array_push($the_player_stats_G, $id_player_stats_G); ?>
                                                <?php array_push($the_player_stats_A, $id_player_stats_A); ?>
                                            <?php endif; ?>
                                        <?php endwhile; ?>
                                    <?php endif ?>
                                <?php endif; ?>
                            <?php endwhile ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php $key_values_G = array_column($the_player_stats_G, 'total_goals'); 
                array_multisort($key_values_G, SORT_DESC, $the_player_stats_G);?>
                <?php $key_values_A = array_column($the_player_stats_A, 'total_assists'); 
                array_multisort($key_values_A, SORT_DESC, $the_player_stats_A);?>

                <h4>Goals</h4>

                <table border="color:grey;" class="statsTable">
                    <tr>
                        <th>Game</th>
                        <th>Team</th>
                        <th>Season 1</th>
                        <th>Season 2</th>
                        <th>Season 3</th>
                        <th>Season 4</th>
                        <th>Season 5</th>
                        <th>Season 6</th>
                        <th>Season 7</th>
                        <th>Season 8</th>
                        <th>Season 9</th>
                        <th>Season 10</th>
                        <th>Total Goals</th>
                        <th>Ave Goals a Season</th>
                    </tr>
                    <?php foreach($the_player_stats_G as $key=>$player_stats_G): ?>
                        <tr>
                            <td><a href="<?php echo get_permalink($player_stats_G['game_id']); ?>"><?php echo get_the_title($player_stats_G['game_id'])?></a></td>
                            <td><a href="<?php echo get_permalink($player_stats_G['team_id']); ?>"><?php echo get_the_title($player_stats_G['team_id'])?></a></td>
                            <?php for($i = 1; $i <= 10; $i++): ?>
                                <td class="<?php echo $player_stats_G['seasons'][$i] === null || $player_stats_G['seasons'][$i] === '' ? ' black-cell ' : ''?>"> <?php echo $player_stats_G['seasons'][$i] ?> </td>
                            <?php endfor; ?>
                            <td><?php echo $player_stats_G['total_goals']?></td>
                            <td><?php echo round(($player_stats_G['total_goals'] / $player_stats_G['seasons_played']),4)?></td>
                        </tr>
                    <?php endforeach ?>

                </table>

                <h4>Assists</h4>

                <table border="color:grey;" class="statsTable">
                    <tr>
                        <th>Game</th>
                        <th>Team</th>
                        <th>Season 1</th>
                        <th>Season 2</th>
                        <th>Season 3</th>
                        <th>Season 4</th>
                        <th>Season 5</th>
                        <th>Season 6</th>
                        <th>Season 7</th>
                        <th>Season 8</th>
                        <th>Season 9</th>
                        <th>Season 10</th>
                        <th>Total Assists</th>
                        <th>Ave Assists a Season</th>
                    </tr>
                    <?php foreach($the_player_stats_A as $key=>$player_stats_A): ?>
                        <tr>
                            <td><a href="<?php echo get_permalink($player_stats_A['game_id']); ?>"><?php echo get_the_title($player_stats_A['game_id'])?></a></td>
                            <td><a href="<?php echo get_permalink($player_stats_A['team_id']); ?>"><?php echo get_the_title($player_stats_A['team_id'])?></a></td>
                            <?php for($i = 1; $i <= 10; $i++): ?>
                                <td class="<?php echo $player_stats_A['seasons'][$i] === null || $player_stats_A['seasons'][$i] === '' ? ' black-cell ' : ''?>"> <?php echo $player_stats_A['seasons'][$i] ?> </td>
                            <?php endfor; ?>
                            <td><?php echo $player_stats_A['total_assists']?></td>
                            <td><?php echo round(($player_stats_A['total_assists'] / $player_stats_A['seasons_played']),4)?></td>
                        </tr>
                    <?php endforeach ?>

                </table>
                <?php //dd($the_player_stats_G); ?>
            </div>
        </div>
    </div>

<?php get_footer(); ?>
