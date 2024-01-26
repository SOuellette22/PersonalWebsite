<?php get_header(); ?>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

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
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 10000,
            });
            
        })( jQuery );
    </script>

    <div class="color-line">

    </div>

    <div class="container">

    <h1><?php the_title(); ?></h1>

        <div class="columns">
            <div class="column is-8-desktop">
     

                <?php $submit = false; ?>
                <?php $goals_displayed = $game_displayed = $team_displayed = $player_displayed = $assists_displayed = $season_displayed = $newGameText = $newTeamText = $newPlayerText = ""?>
                <?php if(isset($_POST['submit'])): ?>
                    <?php
                    $goals_displayed = $_POST['numGoals'];
                    $game_displayed = $_POST['gamesSelect'];
                    $team_displayed = $_POST['teamsSelect'];
                    $player_displayed = $_POST['playersSelect'];
                    $assists_displayed = $_POST['numAssists'];
                    $season_displayed = $_POST['numSeasons'];
                    if($game_displayed === "0") {
                        $newGameText = $_POST['newGameText'];
                        $game_displayed = "";
                    }
                    if($team_displayed === "0") {
                        $newTeamText = $_POST['newTeamText'];
                        $team_displayed = "";
                    }
                    if($player_displayed === "0") {
                        $newPlayerText = $_POST['newPlayerText'];
                        $player_displayed = "";
                    }

                    if ($newGameText !== '' || $newTeamText !== '' || $newPlayerText !== '') {
                        $submit = true;

                        require_once( ABSPATH . 'wp-admin/includes/image.php' );
                        require_once( ABSPATH . 'wp-admin/includes/file.php' );
                        require_once( ABSPATH . 'wp-admin/includes/media.php' );

                        // ADDS NEW GAME/TEAM/PLAYER
                        if($newGameText !== "") {
                            $postTitle = $_POST['newGameText'];
                            $postType = 'games';
                        }

                        if($newTeamText !== "") {
                            $postTitle = $_POST['newTeamText'];
                            $postType = 'teams';
                        }

                        if($newPlayerText !== "") {
                            $postTitle = $_POST['newPlayerText'];
                            $postType = 'players';
                        }

                        $my_post = array(
                            'post_title'    => $postTitle,
                            'post_type'  => $postType,
                            'post_status'   => 'publish',
                        );

                        $post_id = wp_insert_post( $my_post );

                        $attachment_id = media_handle_upload( 'upload', $post_id);
                            set_post_thumbnail( $post_id, $attachment_id );

                        echo "<h3><b>Updated stats Successfull</b></h3>";
                        // END ADDS NEW GAME/TEAM/PLAYER
                    }

                    if ($goals_displayed!=='' && ($game_displayed!=='') && $team_displayed!=='' && $player_displayed!=='' && $assists_displayed!=='' && $seasons_displayed!=='') {
                        $submit = true;
                        // GAME SETTING CHECK
                        if (get_field('team_stats', $game_displayed)) {
                            $game_stats = get_field('team_stats', $game_displayed);
                        } else {
                            $game_stats = array();
                        }
                        // END GAME SETTIING CHECK
                        
                        // TEAM IN GAME/PLAYER IN TEAM?
                        $team_index = false;
                        $player_index = false;

                        foreach($game_stats as $keyT => $team) {
                            if($team['team']->ID === intval($team_displayed)) {
                                $team_index = $keyT;
                                break;
                            }
                        }

                        foreach($game_stats[$team_index]['players'] as $keyP => $players) {
                            if($players['player']->ID === intval($player_displayed)) {
                                $player_index = $keyP;
                                break;
                                }
                        }
                        // END TEAM IN GAME/PLAYER IN TEAM?

                        // ADD NEW PLAYER/TEAM TO DATABASE
                        if ($team_index === false) {
                            $new_team_row = array( 
                                'team'  => $team_displayed,
                                'players'   => array( array(
                                    'player' => $player_displayed,
                                    $season_displayed => array(
                                        'goals' => $goals_displayed,
                                        'assists' => $assists_displayed
                                    )
                                ))
                            );
                            array_push($game_stats, $new_team_row);
                        }

                        if ($player_index === false && $team_index !== false) {
                            $new_player_row = array(
                                'player' => $player_displayed,
                                $season_displayed => array(
                                    'goals' => $goals_displayed,
                                    'assists' => $assists_displayed
                                )
                            );
                            if(!is_array($game_stats[$team_index]['players'])) {
                                $game_stats[$team_index]['players'] = array();
                            }
                            array_push($game_stats[$team_index]['players'], $new_player_row);

                        }

                        // END ADD NEW PLAYER/TEAM TO DATABASE


                        // ADD GOALS/ASSISTS TO EXCISTING PLAYER IN CORRECT GAME AND TEAM
                        if ($player_index !== false && $team_index !== false) {
                            $game_stats[$team_index]['players'][$player_index][$season_displayed]['goals'] = $goals_displayed;
                            $game_stats[$team_index]['players'][$player_index][$season_displayed]['assists'] = $assists_displayed;
                        }
                        // END ADD GOALS/ASSISTS TO EXCISTING PLAYER IN CORRECT GAME AND TEAM

                        // UPDATE THE STATS
                        update_field('field_646facee2b084', $game_stats, $game_displayed);
                        // END UPDATE THE STATS

                        echo "<h3><b>Updated stats Successfull</b></h3>";
                    } 

                    if (!$submit) {
                        echo '<h3>You did not input enough information to update or add stats</h3>';
                    }

                    ?>
                <?php endif ?>
            
                <div class="columns">

                    <div class="column is-5-desktop">
                        <form method="post" action="" enctype='multipart/form-data'>
                            <div class="ui-widget game-wrapper ">
                                <div id="gamesSelecter" name="newGame">
                                    <label>What game: </label>
                                    <select id="js__apply_now1" name="gamesSelect">
                                        <option value=""></option>
                                        <option value="0" id="game">-- Add New Game --</option>
                                        <?php foreach($games_query->posts as $game):?>
                                            <option value="<?php echo $game->ID;?>" id="game"><?php echo $game->post_title;?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <div id="newGame-wrapper">
                                    <label>New game: </label>
                                    <input type="text" name="newGameText">
                                </div>
                            </div>

                            <div class="ui-widget team-wrapper">
                                <div id="teamsSelecter" name="newTeam">
                                    <label>What team: </label>
                                    <select id="js__apply_now2" name="teamsSelect">
                                        <option value=""></option>
                                        <option value="0" id="team">-- Add New Team --</option>
                                        <?php foreach($teams_query->posts as $team):?>
                                            <option value="<?php echo $team->ID;?>" id="team"><?php echo $team->post_title;?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <div id="newTeam-wrapper">
                                    <label>New team: </label>
                                    <input type="text" name="newTeamText">
                                </div>
                            </div>

                            <div class="ui-widget player-wrapper">
                                <div id="playersSelecter" name="newPlayers">
                                    <label>What player: </label>
                                    <select id="js__apply_now3" name="playersSelect">
                                        <option value=""></option>
                                        <option value="0" id="player">-- Add New Player --</option>
                                        <?php foreach($players_query->posts as $player):?>
                                            <option value="<?php echo $player->ID;?>" id="player"><?php echo $player->post_title;?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <div id="newPlayer-wrapper">
                                    <label>New player: </label>
                                    <input type="text" name="newPlayerText">
                                </div>
                            </div>
                    </div>
                    <div class="column">
                            <div id="seasonsSelector" class="stats-styles">
                                <label>What Seasons is it: </label>
                                <select name="numSeasons" id="seasons">
                                    <option value="">Select one...</option>
                                    <option id="season_1" value="season_1">Season 1</option>
                                    <option id="season_2" value="season_2">Season 2</option>
                                    <option id="season_3" value="season_3">Season 3</option>
                                    <option id="season_4" value="season_4">Season 4</option>
                                    <option id="season_5" value="season_5">Season 5</option>
                                    <option id="season_6" value="season_6">Season 6</option>
                                    <option id="season_7" value="season_7">Season 7</option>
                                    <option id="season_8" value="season_8">Season 8</option>
                                    <option id="season_9" value="season_9">Season 9</option>
                                    <option id="season_10" value="season_10">Season 10</option>
                                </select>
                            </div>

                            <div id='goalsNum' class="stats-styles">
                                <label>Number of Goals: </label>
                                <input type="number" id="goals" name="numGoals" value="<?php echo $goals_displayed?>" autocomplete="off">
                            </div>

                            <div id='assistsNum' class="stats-styles">
                                <label>Number of Assists: </label>
                                <input type="number" id="assists" name="numAssists" value="<?php echo $assists_displayed?>" autocomplete="off">
                            </div>

                            <div id="imageUpload">
                                <input type="file" id="uplaod" name="upload" value="<?php echo $uploadImage ?>">
                            </div>
                    </div>
                </div>

                            <input type="submit" id="submit" value="Submit" name="submit" onsubmit="return submit();">
                        </form>
            </div>
            <div class="column">
                <?php if($goals_displayed!=='' && $game_displayed!=='' && $team_displayed!=='' && $player_displayed!=='' && $assists_displayed!=='' && $seasons_displayed!==''):?>
                    <h3>Recently added stats: </h3>
                    <p><b>Game:</b> <a href="<?php echo get_permalink($game_displayed)?>"><?php echo get_the_title($game_displayed)?></a> </p>
                    <p><b>Team:</b> <a href="<?php echo get_permalink($team_displayed)?>"><?php echo get_the_title($team_displayed)?></a> </p>
                    <p><b>Player:</b> <a href="<?php echo get_permalink($player_displayed)?>"><?php echo get_the_title($player_displayed)?></a> </p>
                    <p><b>Season:</b> <?php echo $season_displayed?> </p>
                    <p><b>Goals:</b> <?php echo $goals_displayed?> </p>
                    <p><b>Assists:</b> <?php echo $assists_displayed?> </p>
                <?php endif; ?>
                <?php if($newGameText !== ''): ?>
                    <h3>Recently added stats: </h3>
                    <p><b>Game Added:</b> <?php echo $newGameText?> </p>
                <?php endif; ?>
                <?php if($newTeamText !== ''): ?>
                    <h3>Recently added stats: </h3>
                    <p><b>Team Added:</b> <?php echo $newTeamText?> </p>
                <?php endif; ?>
                <?php if($newPlayerText !== ''): ?>
                    <h3>Recently added stats: </h3>
                    <p><b>Player Added:</b> <?php echo $newPlayerText?> </p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>

        // SELECTOR FUNCTIONS
        (function($) {
            $( function() {
                $.widget( "custom.combobox", {
                    _create: function() {
                        this.wrapper = $( "<span>" )
                            .addClass( "custom-combobox" )
                            .insertAfter( this.element );
                        this.element.hide();
                        this._createAutocomplete();
                        this._createShowAllButton();
                    },

                    _createAutocomplete: function() {
                        var selected = this.element.children( ":selected" ),
                            value = selected.val() ? selected.text() : "";

                        this.input = $( "<input>" )
                            .appendTo( this.wrapper )
                            .val( value )
                            .attr( "title", "" )
                            .attr( "placeholder", "game" )
                            .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left text-input" )
                            .autocomplete({
                                delay: 0,
                                minLength: 0,
                                source: $.proxy( this, "_source" )
                            })
                            .tooltip({
                                classes: {
                                    "ui-tooltip": "ui-state-highlight"
                                }
                            });

                        this._on( this.input, {
                            autocompleteselect: function( event, ui ) {
                                ui.item.option.selected = true;
                                this._trigger( "select", event, {
                                    item: ui.item.option
                                });

                                // NEW ITEM INPUTS
                                if(ui.item.option.id === 'player') {
                                    if(ui.item.value === '-- Add New Player --'){
                                        $('#newPlayer-wrapper').show();
                                        $('#imageUpload').show();
                                        $('#teamsSelecter').hide();
                                        $('#gamesSelecter').hide();
                                        $('#seasonsSelector').hide();
                                        $('#goalsNum').hide();
                                        $('#assistsNum').hide();
                                    } else {
                                        $('#newPlayer-wrapper').hide();
                                        $('#imageUpload').hide();
                                        $('#teamsSelecter').show();
                                        $('#gamesSelecter').show();
                                        $('#seasonsSelector').show();
                                        $('#goalsNum').show();
                                        $('#assistsNum').show();
                                    }
                                }
                                
                                if(ui.item.option.id === 'game' ) {
                                    if(ui.item.value === '-- Add New Game --'){
                                        $('#newGame-wrapper').show();
                                        $('#imageUpload').show();
                                        $('#playersSelecter').hide();
                                        $('#teamsSelecter').hide();
                                        $('#seasonsSelector').hide();
                                        $('#goalsNum').hide();
                                        $('#assistsNum').hide();
                                    } else {
                                        $('#newGame-wrapper').hide();
                                        $('#imageUpload').hide();
                                        $('#playersSelecter').show();
                                        $('#teamsSelecter').show();
                                        $('#seasonsSelector').show();
                                        $('#goalsNum').show();
                                        $('#assistsNum').show();
                                    }
                                }
                                
                                if(ui.item.option.id === 'team') {
                                    if(ui.item.value === '-- Add New Team --'){
                                        $('#newTeam-wrapper').show();
                                        $('#imageUpload').show();
                                        $('#playersSelecter').hide();
                                        $('#gamesSelecter').hide();
                                        $('#seasonsSelector').hide();
                                        $('#goalsNum').hide();
                                        $('#assistsNum').hide();
                                    } else {
                                        $('#newTeam-wrapper').hide();
                                        $('#imageUpload').hide();
                                        $('#playersSelecter').show();
                                        $('#gamesSelecter').show();
                                        $('#seasonsSelector').show();
                                        $('#goalsNum').show();
                                        $('#assistsNum').show();
                                    }
                                }
                                // END OF NEW ITEM INPUT
                            },

                            autocompletechange: "_removeIfInvalid"
                        });
                    },

                    _createShowAllButton: function() {
                        var input = this.input,
                            wasOpen = false;

                        $( "<a>" )
                            .attr( "tabIndex", -1 )
                            .attr( "title", "Show All Items" )
                            .tooltip()
                            .appendTo( this.wrapper )
                            .button({
                                icons: {
                                    primary: "ui-icon-triangle-1-s"
                                },
                                text: false
                            })
                            .removeClass( "ui-corner-all" )
                            .addClass( "custom-combobox-toggle ui-corner-right" )
                            .on( "mousedown", function() {
                                wasOpen = input.autocomplete( "widget" ).is( ":visible" );
                            })
                            .on( "click", function() {
                                input.trigger( "focus" );

                                // Close if already visible
                                if ( wasOpen ) {
                                    return;
                                }

                                // Pass empty string as value to search for, displaying all results
                                input.autocomplete( "search", "" );
                            });
                    },

                    _source: function( request, response ) {
                        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
                        response( this.element.children( "option" ).map(function() {
                            var text = $( this ).text();
                            if ( this.value && ( !request.term || matcher.test(text) ) )
                                return {
                                    label: text,
                                    value: text,
                                    option: this
                                };
                        }) );
                    },

                    _removeIfInvalid: function( event, ui ) {

                        // Selected an item, nothing to do
                        if ( ui.item ) {
                            return;
                        }

                        // Search for a match (case-insensitive)
                        var value = this.input.val(),
                            valueLowerCase = value.toLowerCase(),
                            valid = false;
                        this.element.children( "option" ).each(function() {
                            if ( $( this ).text().toLowerCase() === valueLowerCase ) {
                                this.selected = valid = true;
                                return false;
                            }
                        });

                        // Found a match, nothing to do
                        if ( valid ) {
                            return;
                        }

                        // Remove invalid value
                        this.input
                            .val( "" )
                            .attr( "title", value + " didn't match any item" )
                            .tooltip( "open" );
                        this.element.val( "" );
                        this._delay(function() {
                            this.input.tooltip( "close" ).attr( "title", "" );
                        }, 2500 );
                        this.input.autocomplete( "instance" ).term = "";
                    },

                    _destroy: function() {
                        this.wrapper.remove();
                        this.element.show();
                    }
                });

                $( "#js__apply_now1" ).combobox();
                $( "#js__apply_now2" ).combobox();
                $( "#js__apply_now3" ).combobox();

                $(".team-wrapper .text-input").attr("placeholder", "team");
                $(".player-wrapper .text-input").attr("placeholder", "player");
                
            } );
        
        // END OF SELECTOR FUNCTIONS
        })( jQuery );
    </script>
<?php get_footer(); ?>
