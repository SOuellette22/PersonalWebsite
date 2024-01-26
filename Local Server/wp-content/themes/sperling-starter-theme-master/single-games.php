<?php get_header(); ?>

    <?php 

    $argsP = array(
        'post_type'         => 'players',
        'posts_per_page'    => -1
    );

    $players_query = new WP_Query( $argsP );

    $argsT = array(
        'post_type'         => 'teams',
        'posts_per_page'    => -1
    );

    $teams_query = new WP_Query( $argsT );

    $argsG = array(
        'post_type'         => 'games',
        'posts_per_page'    => -1
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
            <?php if ( $games_query ) : ?>

                <div class="team-caricel">

                <!-- the loop -->
                    <?php foreach($games_query->posts as $game):?>
                    <div>
                        <h2 class="header-h2">
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
                    <img src="<?php echo get_theme_file_uri('/img/add_stats.svg')?>" alt="Logo" class="logo-img no-lazy statsHeader" style="height:155px;">
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
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 10000,
            });
            
        })( jQuery );
    </script>

    <?php $game_stats_G = array(); ?>
    <?php $game_stats_A = array(); ?>
    
    <?php if( have_rows('team_stats') ): ?>
        <?php while( have_rows('team_stats') ): the_row(); 
            $team = get_sub_field('team');
            $players = get_sub_field('players'); ?>
            <?php if($players): ?>
                <?php if(have_rows('players')): ?>
                    <?php while(have_rows('players')): the_row(); ?>
                        <?php $player = get_sub_field('player'); ?>
                        <?php if($player): ?>
                            <?php $stats_G['team'] = $team; ?>
                            <?php $stats_A['team'] = $team; ?>
                            <?php $stats_G['player'] = $player; ?>
                            <?php $stats_A['player'] = $player; ?>
                            <?php $total_goals = 0; ?>
                            <?php $total_assists = 0; ?>
                            <?php $total_seasons = 0; ?>
                            <?php $season_goals = array(); ?>
                            <?php $season_assists = array(); ?>
                            <?php for($i = 1; $i <= 10; $i++): ?>
                                <?php $seasons = get_sub_field('season_'.$i); ?>
                                <?php if ($seasons): ?>
                                    <?php if(have_rows('season_'.$i)): ?>
                                        <?php while(have_rows('season_'.$i)): the_row(); ?>
                                            <?php $goals = get_sub_field('goals'); ?>
                                            <?php $assists = get_sub_field('assists'); ?>
                                            <?php $total_goals = $total_goals + intval($goals); ?>
                                            <?php $total_assists = $total_assists + intval($assists); ?>
                                            <?php $season_goals[] = $goals; ?>
                                            <?php $season_assists[] = $assists; ?>
                                            <?php if(($goals !== '' && $goals !== null) && ($assists !== '' && $assists !== null)) {
                                                $total_seasons++;
                                            } ?>
                                        <?php endwhile; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endfor; ?>
                            <?php $stats_G['total_goals'] = $total_goals; ?>
                            <?php $stats_G['seasons_played'] = $total_seasons; ?>
                            <?php $stats_G['seasons'] = $season_goals; ?>
                            <?php $stats_G['goals/season'] = $total_goals/$total_seasons; ?>
                            <?php array_push($game_stats_G, $stats_G); ?>
                            <?php $stats_A['total_assists'] = $total_assists; ?>
                            <?php $stats_A['seasons_played'] = $total_seasons; ?>
                            <?php $stats_A['seasons'] = $season_assists; ?>
                            <?php $stats_A['assists/season'] = $total_assists/$total_seasons; ?>
                            <?php array_push($game_stats_A, $stats_A); ?>
                        <?php endif; ?>
                    <?php endwhile; ?>
                <?php endif; ?>
            <?php endif; ?>
        <?php endwhile; ?>
    <?php endif; ?>

    <?php $trophies_array = array(); ?>
    <?php if($teams_query): ?>
        <?php foreach($teams_query->posts as $teams): ?>
            <?php $trophies_team_array = array(); ?>
            <?php if(have_rows('team_trophies', $teams->ID)): ?>
                <?php while(have_rows('team_trophies', $teams->ID)): the_row(); ?>
                    <?php $league_title = get_sub_field('league_title')?>
                    <?php $league_cup = get_sub_field('league_cup')?>
                    <?php $champions_league = get_sub_field('champions_league')?>
                    <?php $europa_league = get_sub_field('europa_league')?>
                    <?php $super_copa = get_sub_field('super_copa')?>
                    <?php $conference_league = get_sub_field('conference_league')?>
                    <?php $game = get_sub_field('game')?>

                    <?php if($game === get_the_ID()): ?>
                        <?php $trophies_team_array['team'] = $teams->ID; ?>
                        <?php $trophies_team_array['league_title'] = intval($league_title); ?>
                        <?php $trophies_team_array['league_cup'] = intval($league_cup); ?>
                        <?php $trophies_team_array['champions_league'] = intval($champions_league); ?>
                        <?php $trophies_team_array['europa_league'] = intval($europa_league); ?>
                        <?php $trophies_team_array['super_copa'] = intval($super_copa); ?>
                        <?php $trophies_team_array['conference_league'] = intval($conference_league); ?>
                        <?php $trophies_team_array['total_trophies'] = $conference_league + $super_copa + $europa_league + $champions_league + $league_cup + $league_title; ?>
                    <?php endif; ?>
                    <?php array_push($trophies_array, $trophies_team_array); ?>
                <?php endwhile; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>

    <div class="container">
        <div class="columns">
            <div class="column">
                <?php the_post_thumbnail('medium'); ?>
                <?php $key_values_G = array_column($game_stats_G, 'total_goals'); 
                array_multisort($key_values_G, SORT_DESC, $game_stats_G);?>
                <h4>Top 5 Total Goals</h4>
                <table border="color:grey;" class="statsTable">
                    <tr>
                        <th>Position</th>
                        <th>Player</th>
                        <th>Team</th>
                        <th style="width: 50px">Seasons Played</th>
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
                    </tr>
                    <?php for($i = 0; $i <= 4; $i++): ?>
                        <tr>
                            <td><?php echo ++$i; ?></td> <?php --$i; ?>
                            <td><a href="<?php echo get_permalink($game_stats_G[$i]['player'])?>"><?php echo get_the_title($game_stats_G[$i]['player']) ?></a></td>
                            <td><a href="<?php echo get_permalink($game_stats_G[$i]['team'])?>"><?php echo get_the_title($game_stats_G[$i]['team']) ?></a></td>
                            <td class="<?php echo $game_stats_G[$i]['seasons_played'] === null || $game_stats_G[$i]['seasons_played'] === '' ? ' black-cell ' : ''?>"><?php echo $game_stats_G[$i]['seasons_played'] ?></td>
                            <?php for($j = 0; $j <= 9; $j++): ?>
                                <td class="<?php echo $game_stats_G[$i]['seasons'][$j] === null || $game_stats_G[$i]['seasons'][$j] === '' ? ' black-cell ' : ''?>"> <?php echo $game_stats_G[$i]['seasons'][$j] ?> </td>
                            <?php endfor; ?>
                            <td class="<?php echo $game_stats_G[$i]['total_goals'] === null || $game_stats_G[$i]['total_goals'] === '' ? ' black-cell ' : ''?>"><?php echo $game_stats_G[$i]['total_goals']?></td>
                        </tr>
                    <?php endfor; ?>
                </table>
                <a href="http://localhost:8888/top-goals/?ref=<?php echo get_the_ID()?>"><b> Look at the full list of top goal scorers </b></a>

                <?php $key_values_A = array_column($game_stats_A, 'total_assists'); 
                array_multisort($key_values_A, SORT_DESC, $game_stats_A);?>
                <h4>Top 5 Total Assists</h4>
                <table border="color:grey;" class="statsTable">
                    <tr>
                        <th>Position</th>
                        <th>Player</th>
                        <th>Team</th>
                        <th style="width: 50px">Seasons Played</th>
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
                    </tr>
                    <?php for($i = 0; $i <= 4; $i++): ?>
                        <tr>
                            <td><?php echo ++$i; ?></td> <?php --$i; ?>
                            <td><a href="<?php echo get_permalink($game_stats_A[$i]['player'])?>"><?php echo get_the_title($game_stats_A[$i]['player']) ?></a></td>
                            <td><a href="<?php echo get_permalink($game_stats_A[$i]['team'])?>"><?php echo get_the_title($game_stats_A[$i]['team']) ?></a></td>
                            <td class="<?php echo $game_stats_A[$i]['seasons_played'] === null || $game_stats_A[$i]['seasons_played'] === '' ? ' black-cell ' : ''?>"><?php echo $game_stats_A[$i]['seasons_played'] ?></td>
                            <?php for($j = 0; $j <= 9; $j++): ?>
                                <td class="<?php echo $game_stats_A[$i]['seasons'][$j] === null || $game_stats_A[$i]['seasons'][$j] === '' ? ' black-cell ' : ''?>"> <?php echo $game_stats_A[$i]['seasons'][$j] ?> </td>
                            <?php endfor; ?>
                            <td class="<?php echo $game_stats_A[$i]['total_assists'] === null || $game_stats_A[$i]['total_assists'] === '' ? ' black-cell ' : ''?>"><?php echo $game_stats_A[$i]['total_assists']?></td>
                        </tr>
                    <?php endfor; ?>
                </table>
                <a href="http://localhost:8888/top-assists/?ref=<?php echo get_the_ID()?>"><b> Look at the full list of top assisters </b></a>

                <?php $key_values_G = array_column($game_stats_G, 'goals/season'); 
                array_multisort($key_values_G, SORT_DESC, $game_stats_G);?>
                <h4>Top 5 Goals per Season</h4>
                <table border="color:grey;" class="statsTable">
                    <tr>
                        <th>Position</th>
                        <th>Player</th>
                        <th>Team</th>
                        <th style="width: 50px">Seasons Played</th>
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
                        <th>Goals/Season</th>
                    </tr>
                    <?php for($i = 0; $i <= 4; $i++): ?>
                        <tr>
                            <td><?php echo ++$i; ?></td> <?php --$i; ?>
                            <td><a href="<?php echo get_permalink($game_stats_G[$i]['player'])?>"><?php echo get_the_title($game_stats_G[$i]['player']) ?></a></td>
                            <td><a href="<?php echo get_permalink($game_stats_G[$i]['team'])?>"><?php echo get_the_title($game_stats_G[$i]['team']) ?></a></td>
                            <td class="<?php echo $game_stats_G[$i]['seasons_played'] === null || $game_stats_G[$i]['seasons_played'] === '' ? ' black-cell ' : ''?>"><?php echo $game_stats_G[$i]['seasons_played'] ?></td>
                            <?php for($j = 0; $j <= 9; $j++): ?>
                                <td class="<?php echo $game_stats_G[$i]['seasons'][$j] === null || $game_stats_G[$i]['seasons'][$j] === '' ? ' black-cell ' : ''?>"> <?php echo $game_stats_G[$i]['seasons'][$j] ?> </td>
                            <?php endfor; ?>
                            <td class="<?php echo $game_stats_G[$i]['goals/season'] === null || $game_stats_G[$i]['goals/season'] === '' ? ' black-cell ' : ''?>"><?php echo round($game_stats_G[$i]['goals/season'],4)?></td>
                        </tr>
                    <?php endfor; ?>
                </table>
                <a href="http://localhost:8888/top-goals-per-season/?ref=<?php echo get_the_ID()?>"><b> Look at the full list of top goals per season </b></a>

                <?php $key_values_A = array_column($game_stats_A, 'assists/season'); 
                array_multisort($key_values_A, SORT_DESC, $game_stats_A);?>
                <h4>Top 5 Assists per Season</h4>
                <table border="color:grey;" class="statsTable">
                    <tr>
                        <th>Position</th>
                        <th>Player</th>
                        <th>Team</th>
                        <th style="width: 50px">Seasons Played</th>
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
                        <th>Assists/season</th>
                    </tr>
                    <?php for($i = 0; $i <= 4; $i++): ?>
                        <tr>
                            <td><?php echo ++$i; ?></td> <?php --$i; ?>
                            <td><a href="<?php echo get_permalink($game_stats_A[$i]['player'])?>"><?php echo get_the_title($game_stats_A[$i]['player']) ?></a></td>
                            <td><a href="<?php echo get_permalink($game_stats_A[$i]['team'])?>"><?php echo get_the_title($game_stats_A[$i]['team']) ?></a></td>
                            <td class="<?php echo $game_stats_A[$i]['seasons_played'] === null || $game_stats_A[$i]['seasons_played'] === '' ? ' black-cell ' : ''?>"><?php echo $game_stats_A[$i]['seasons_played'] ?></td>
                            <?php for($j = 0; $j <= 9; $j++): ?>
                                <td class="<?php echo $game_stats_A[$i]['seasons'][$j] === null || $game_stats_A[$i]['seasons'][$j] === '' ? ' black-cell ' : ''?>"> <?php echo $game_stats_A[$i]['seasons'][$j] ?> </td>
                            <?php endfor; ?>
                            <td class="<?php echo $game_stats_A[$i]['assists/season'] === null || $game_stats_A[$i]['assists/season'] === '' ? ' black-cell ' : ''?>"><?php echo round($game_stats_A[$i]['assists/season'],4)?></td>
                        </tr>
                    <?php endfor; ?>
                </table>
                <a href="http://localhost:8888/top-assists-per-season/?ref=<?php echo get_the_ID()?>"><b> Look at the full list of top assists per season </b></a>

                <?php $key = array_column($trophies_array, 'total_trophies'); 
                array_multisort($key, SORT_DESC, $trophies_array);?>
                <h4>Top 5 Teams with the most Trophies</h4>
                <table border="color:grey;" class="statsTable">
                    <tr>
                        <th>Team</th>
                        <th>League Titles</th>
                        <th>League Cups</th>
                        <th>Champions League</th>
                        <th>Europa League</th>
                        <th>Super Copa</th>
                        <th>Conference League</th>
                        <th>Total Trophies</th>
                    </tr>
                    <?php for($i = 0; $i <= 4; $i++): ?>
                        <tr>
                            <td><a href="<?php echo get_permalink($trophies_array[$i]['team']) ?>"><?php echo get_the_title($trophies_array[$i]['team']) ?></a></td>
                            <td><?php echo $trophies_array[$i]['league_title'] ?></td>
                            <td><?php echo $trophies_array[$i]['league_cup'] ?></td>
                            <td><?php echo $trophies_array[$i]['champions_league'] ?></td>
                            <td><?php echo $trophies_array[$i]['europa_league'] ?></td>
                            <td><?php echo $trophies_array[$i]['super_copa'] ?></td>
                            <td><?php echo $trophies_array[$i]['conference_league'] ?></td>
                            <td style="background-color: lightgray;"><?php echo $trophies_array[$i]['total_trophies'] ?></td>
                        </tr>
                    <?php endfor; ?>
                </table>

                <?php $key = array_column($trophies_array, 'league_title'); 
                array_multisort($key, SORT_DESC, $trophies_array);?>
                <h4>Top 5 Teams with the most League Titles</h4>
                <table border="color:grey;" class="statsTable">
                    <tr>
                        <th>Team</th>
                        <th>League Titles</th>
                        <th>League Cups</th>
                        <th>Champions League</th>
                        <th>Europa League</th>
                        <th>Super Copa</th>
                        <th>Conference League</th>
                        <th>Total Trophies</th>
                    </tr>
                    <?php for($i = 0; $i <= 4; $i++): ?>
                        <tr>
                            <td><a href="<?php echo get_permalink($trophies_array[$i]['team']) ?>"><?php echo get_the_title($trophies_array[$i]['team']) ?></a></td>
                            <td style="background-color: lightgray;"><?php echo $trophies_array[$i]['league_title'] ?></td>
                            <td><?php echo $trophies_array[$i]['league_cup'] ?></td>
                            <td><?php echo $trophies_array[$i]['champions_league'] ?></td>
                            <td><?php echo $trophies_array[$i]['europa_league'] ?></td>
                            <td><?php echo $trophies_array[$i]['super_copa'] ?></td>
                            <td><?php echo $trophies_array[$i]['conference_league'] ?></td>
                            <td><?php echo $trophies_array[$i]['total_trophies'] ?></td>
                        </tr>
                    <?php endfor; ?>
                </table>

                <?php $key = array_column($trophies_array, 'league_cup'); 
                array_multisort($key, SORT_DESC, $trophies_array);?>
                <h4>Top 5 Teams with the most League Cups</h4>
                <table border="color:grey;" class="statsTable">
                    <tr>
                        <th>Team</th>
                        <th>League Titles</th>
                        <th>League Cups</th>
                        <th>Champions League</th>
                        <th>Europa League</th>
                        <th>Super Copa</th>
                        <th>Conference League</th>
                        <th>Total Trophies</th>
                    </tr>
                    <?php for($i = 0; $i <= 4; $i++): ?>
                        <tr>
                            <td><a href="<?php echo get_permalink($trophies_array[$i]['team']) ?>"><?php echo get_the_title($trophies_array[$i]['team']) ?></a></td>
                            <td><?php echo $trophies_array[$i]['league_title'] ?></td>
                            <td style="background-color: lightgray;"><?php echo $trophies_array[$i]['league_cup'] ?></td>
                            <td><?php echo $trophies_array[$i]['champions_league'] ?></td>
                            <td><?php echo $trophies_array[$i]['europa_league'] ?></td>
                            <td><?php echo $trophies_array[$i]['super_copa'] ?></td>
                            <td><?php echo $trophies_array[$i]['conference_league'] ?></td>
                            <td><?php echo $trophies_array[$i]['total_trophies'] ?></td>
                        </tr>
                    <?php endfor; ?>
                </table>

                <?php $key = array_column($trophies_array, 'champions_league'); 
                array_multisort($key, SORT_DESC, $trophies_array);?>
                <h4>Top 5 Teams with the most Champions League</h4>
                <table border="color:grey;" class="statsTable">
                    <tr>
                        <th>Team</th>
                        <th>League Titles</th>
                        <th>League Cups</th>
                        <th>Champions League</th>
                        <th>Europa League</th>
                        <th>Super Copa</th>
                        <th>Conference League</th>
                        <th>Total Trophies</th>
                    </tr>
                    <?php for($i = 0; $i <= 4; $i++): ?>
                        <tr>
                            <td><a href="<?php echo get_permalink($trophies_array[$i]['team']) ?>"><?php echo get_the_title($trophies_array[$i]['team']) ?></a></td>
                            <td><?php echo $trophies_array[$i]['league_title'] ?></td>
                            <td><?php echo $trophies_array[$i]['league_cup'] ?></td>
                            <td style="background-color: lightgray;"><?php echo $trophies_array[$i]['champions_league'] ?></td>
                            <td><?php echo $trophies_array[$i]['europa_league'] ?></td>
                            <td><?php echo $trophies_array[$i]['super_copa'] ?></td>
                            <td><?php echo $trophies_array[$i]['conference_league'] ?></td>
                            <td><?php echo $trophies_array[$i]['total_trophies'] ?></td>
                        </tr>
                    <?php endfor; ?>
                </table>

            </div>
        </div>
    </div>
    
    <?php //dd($game_stats_A); ?>

<?php get_footer(); ?>