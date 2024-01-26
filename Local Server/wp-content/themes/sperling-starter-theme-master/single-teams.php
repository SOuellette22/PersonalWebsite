

<?php get_header(); ?>
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
            <?php if ( $teams_query ) : ?>

                <div class="team-caricel">

                <!-- the loop -->
                    <?php foreach($teams_query->posts as $team):?>
                    <div>
                        <h2 class="header-h2">
                            <a href="<?php echo get_permalink($team->ID); ?>">
                                <?php if(has_post_thumbnail($team->ID)){
                                    echo get_the_post_thumbnail($team, 'head_slider');
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
    
    <div class="container">
        <div class="columns">
            <div class="column is-4-desktop">       
                <?php the_post_thumbnail('medium');?>
            </div>
            <div class="column">
                <h1>
                    <?php the_title(); ?>
                </h1>
                <h3>Trophies Won</h3>
                <table border="color:grey;" class="statsTable">
                    <tr>
                        <th>Game</th>
                        <th>League Titles</th>
                        <th>League Cups</th>
                        <th>Champions League</th>
                        <th>Europa League</th>
                        <th>Super Copa</th>
                        <th>Conference League</th>
                        <th>Total Throphies Won</th>
                    </tr>
                    <?php if( have_rows('team_trophies', get_the_ID())):?>
                        <?php while(have_rows('team_trophies', get_the_ID())): the_row();?>
                            <?php $league_title = get_sub_field('league_title')?>
                            <?php $league_cup = get_sub_field('league_cup')?>
                            <?php $champions_league = get_sub_field('champions_league')?>
                            <?php $europa_league = get_sub_field('europa_league')?>
                            <?php $super_copa = get_sub_field('super_copa')?>
                            <?php $conference_league = get_sub_field('conference_league')?>
                            <?php $game = get_sub_field('game')?>
                            <tr>
                                <td> <?php echo get_the_title($game) ?> </td>
                                <td> <?php echo $league_title?> </td>
                                <td> <?php echo $league_cup?> </td>
                                <td> <?php echo $champions_league?> </td>
                                <td> <?php echo $europa_league?> </td>
                                <td> <?php echo $super_copa?> </td>
                                <td> <?php echo $conference_league?> </td>
                                <td> <?php echo $league_title + $league_cup + $champions_league + $europa_league + $conference_league + $super_copa?> </td>
                            </tr>
                        <?php endwhile ?>
                    <?php endif ?>
                </table>

            </div>
        </div>
        
        <div class="columns">
            <div class="column"> 
                 
                <?php if ( $games_query ):?>    
                    <?php foreach($games_query->posts as $games): ?>
                            <?php if( have_rows('team_stats', $games->ID) ):?>
                                <?php while (have_rows('team_stats', $games->ID)): the_row();
                                    $team = get_sub_field('team');
                                    $players = get_sub_field('players');
                                    if ($team === get_the_ID()):
                                        if ($players): ?>
                                            <?php if( have_rows('players')): ?>
                                                <?php $players_array_G = array(); ?>
                                                <?php $players_array_A = array(); ?>
                                                <?php while(have_rows('players')): the_row();
                                                    $player = get_sub_field('player'); ?>
                                                    <?php 
                                                    $player_array_G['id'] = $player;
                                                    $player_array_A['id'] = $player;
                                                    ?>
                                                    <?php $total_goals = null ?>
                                                    <?php $total_assists = null ?>
                                                    <?php $seasons_played_G = 0; ?>
                                                    <?php $seasons_played_A = 0; ?>
                                                    <?php $playerSeasons_G = array(); ?>
                                                    <?php $playerSeasons_A = array(); ?>
                                                    <?php for ($i = 1; $i <= 10; $i++):
                                                        $seasons = get_sub_field('season_'.$i);
                                                        if($seasons): ?>
                                                            <?php if(have_rows('season_'.$i)): ?>
                                                                <?php while(have_rows('season_'.$i)): the_row();
                                                                    $goals = get_sub_field('goals');
                                                                    $assists = get_sub_field('assists');
                                                                    $playerSeasons_G[] = $goals;
                                                                    $playerSeasons_A[] = $assists; ?>
                                                                <?php endwhile; ?>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                        <?php $total_goals = $total_goals + intval($goals); ?>
                                                        <?php $total_assists = $total_assists + intval($assists); ?>
                                                        <?php if(($goals !== '' && $goals !== null) && ($assists !== '' && $assists !== null)) {
                                                            $seasons_played_G++;
                                                            $seasons_played_A++;
                                                        } ?>
                                                    <?php endfor; ?>
                                                    <?php $player_array_G['total_goals'] = $total_goals;?>
                                                    <?php $player_array_G['seasons'] =  $playerSeasons_G;?>
                                                    <?php $player_array_G['seasons_played'] =  $seasons_played_G;?>
                                                    <?php array_push($players_array_G, $player_array_G)?>
                                                    <?php $player_array_A['total_assists'] = $total_assists;?>
                                                    <?php $player_array_A['seasons'] =  $playerSeasons_A;?>
                                                    <?php $player_array_A['seasons_played'] =  $seasons_played_A;?>
                                                    <?php array_push($players_array_A, $player_array_A)?>
                                                <?php endwhile; ?>


                                                <?php $key_values_G = array_column($players_array_G, 'total_goals'); 
                                                array_multisort($key_values_G, SORT_DESC, $players_array_G);?>
                                                <?php $key_values_A = array_column($players_array_A, 'total_assists'); 
                                                array_multisort($key_values_A, SORT_DESC, $players_array_A);?>

                                                <h4><a href="<?php echo get_permalink($games) ?>"><?php echo get_the_title($games) ?></a></h4>

                                                <h5>Goals</h5>
                                                <table border="color:grey;" class="statsTable-team">
                                                    <tr>
                                                        <th>Player</th>
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
                                                        <th>Ave Goals per Season</th>
                                                    </tr>
                                                <?php foreach($players_array_G as $player_G): 
                                                    ?>
                                                    <tr>
                                                        <td> <a href='<?php echo get_permalink($player_G['id']) ?>'> <?php echo get_the_title($player_G['id']) ?></a> </td>
                                                        <?php for($i = 0; $i < 10; $i++): ?>
                                                            <td class="<?php echo $player_G['seasons'][$i] === null || $player_G['seasons'][$i] === '' ? ' black-cell ' : ''?>"> <?php echo $player_G['seasons'][$i]?> </td>
                                                        <?php endfor; ?>
                                                        <td> <?php echo $player_G['total_goals'] ?> </td>
                                                        <td> <?php echo round(($player_G['total_goals'] / $player_G['seasons_played']),4) ?> </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                </table>

                                                <h5>Assists</h5>
                                                <table border="color:grey;" class="statsTable-team">
                                                    <tr>
                                                        <th>Player</th>
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
                                                        <th>Ave Assitss per Season</th>
                                                    </tr>
                                                <?php foreach($players_array_A as $player_A): ?>
                                                    <tr>
                                                        <td> <a href='<?php echo get_permalink($player_A['id']) ?>'> <?php echo get_the_title($player_A['id']) ?></a> </td>
                                                        <?php for($i = 0; $i < 10; $i++): ?>
                                                            <td class="<?php echo $player_A['seasons'][$i] === null || $player_A['seasons'][$i] === '' ? ' black-cell ' : ''?>"> <?php echo $player_A['seasons'][$i]?> </td>
                                                        <?php endfor; ?>
                                                        <td> <?php echo $player_A['total_assists']?> </td>
                                                        <td> <?php echo round(($player_A['total_assists'] / $player_A['seasons_played']),4)?>  </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                </table>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endwhile; ?>
                            <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php //dd($players_array_G); ?>
            </div>
        </div>
    </div>
    

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
    </script>

<?php get_footer(); ?>
