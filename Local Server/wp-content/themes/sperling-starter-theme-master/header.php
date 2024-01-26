<?php 

$args = array(
    'post_type'         => 'games',
    'posts_per_page'    => 999999
);

$game_query = new WP_Query( $args );

?>

<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?></title>

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<?php wp_head(); ?>

	</head>
	<body <?php body_class(); ?>>

		<!-- wrapper -->
		<div class="wrapper">

			<!-- header -->
			<header class="header clear" role="banner">
				<div class="columns columns-style-header">
					<div class="column is-10-desktop" style="margin:2.5px 0px;">
						<form class="gameForm">
							<select class="header-dropdown" name="game" id="game">
								<option value=""></option>
								<?php foreach($game_query->posts as $game):?>
									<option value="<?php echo get_permalink($game->ID);?>"><?php echo $game->post_title;?></option>
								<?php endforeach;?>
							</select>
							<input class="header-submit" type="submit" value="Load">
						</form>
					</div>
					<div class="column">
						<p class="header-p"> <b><?php the_title() ?></b> </p>
					</div>
				</div>

			</header>
			<!-- /header -->
