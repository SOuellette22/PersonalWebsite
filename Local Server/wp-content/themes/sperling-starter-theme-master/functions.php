<?php
/*
 *  Author: Todd Motto | @toddmotto
 *  URL: sperling.com | @sperling
 *  Custom functions, support, custom post types and more.
 */

/*------------------------------------*\
	External Modules/Files
\*------------------------------------*/

// Load any external files you have here

// Required and suggested plugins


/*------------------------------------*\
    Theme Support
\*------------------------------------*/
if ( ! isset( $content_width ) ) {
    $content_width = 900;
}
if ( function_exists( 'add_theme_support' ) ) {
    // Add Thumbnail Theme Support.
    add_theme_support( 'post-thumbnails' );
    add_image_size( 'head_slider', 0, 195, true ); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');
	
    // Enables post and comment RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );
    // Enable HTML5 support.
    add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
    // Localisation Support.
    load_theme_textdomain( 'html5blank', get_template_directory() . '/languages' );
}

/*------------------------------------*\
	Functions
\*------------------------------------*/

// Dump & Die (echo provide code to the screen and halt execution of the script to debug)
function dd($code)
{
  echo '<pre>';
  var_dump($code);
  echo '</pre>';
  die();
}

// Move Yoast to bottom
 function yoasttobottom() {
     return 'low';
}
add_filter( 'wpseo_metabox_prio', 'yoasttobottom');

// Sperling navigation
function sperling_nav()
{
	wp_nav_menu(
	array(
		'theme_location'  => 'header-menu',
		'menu'            => '',
		'container'       => 'div',
		'container_class' => 'menu-{menu slug}-container',
		'container_id'    => '',
		'menu_class'      => 'menu',
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul>%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
		)
	);
}

// Load Sperling scripts (header.php)
function sperling_header_scripts()
{
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {

      // Font Awesome: https://fontawesome.com/
      wp_register_script('fontawesome', '//kit.fontawesome.com/daa1cd7805.js', array('jquery'));
      wp_enqueue_script('fontawesome'); // Enqueue it!
      // Your scripts here!
      wp_register_script('sperlingscripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.0'); // Custom scripts
      wp_enqueue_script('sperlingscripts'); // Enqueue it!
    }
}
// Enqueue AOS (Animate on Scroll) - NOTE: Function is not initially loaded, uncomment the add_action for this function below
function enqueue_aos()
{
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {
        // Animate on Scroll CSS
        wp_enqueue_style( 'load-aos', '//unpkg.com/aos@2.3.1/dist/aos.css' );

        wp_enqueue_script('aos', '//unpkg.com/aos@2.3.1/dist/aos.js',array('jquery'), '2.3.1', true );
        wp_add_inline_script('aos', '<script>AOS.init({once: true, disable: window.matchMedia("(prefers-reduced-motion: reduce)").matches});</script>', 'after' );
    }
}

// Load conditional scripts
function sperling_conditional_scripts()
{
   if (is_page('pagenamehere')) {
       wp_register_script('scriptname', get_template_directory_uri() . '/js/scriptname.js', array('jquery'), '1.0.0'); // Conditional script(s)
       wp_enqueue_script('scriptname'); // Enqueue it!
   }
	// Slick slider: http://kenwheeler.github.io/slick/
        wp_register_script('slick', get_template_directory_uri() . '/js/lib/slick.min.js', array('jquery'), '1.8.0');
        wp_enqueue_script('slick'); // Enqueue it!
	
	// To Enqueue, uncomment the the corresponding add action below
	wp_enqueue_script('googlemapsapi', '//maps.googleapis.com/maps/api/js?key=AIzaSyD6z4Jo2z4ongqx8njcstKYNJHNdHDh0FQ', array( 'jquery' )); 
        wp_register_script('googlemaps', get_template_directory_uri() . '/js/lib/googlemaps.js', array('jquery'), '1.0.0'); // Conditional script(s)
        wp_enqueue_script('googlemaps'); // Enqueue it!
}

// Enables Google Maps API access in Wordpress Backend
function my_acf_google_map_api( $api ){
    $api['key'] = 'AIzaSyD6z4Jo2z4ongqx8njcstKYNJHNdHDh0FQ';
    return $api;
}

// Load Sperling styles
function sperling_styles()
{
    /*
      INCLUDES MINIFIED AND CONCATINATED COPIES OF:
        Normalize: https://necolas.github.io/normalize.css/
        Slick slider's base CSS and theme: http://kenwheeler.github.io/slick/
        Bulma's grid (and nothing else): https://bulma.io/documentation/columns/basics/
        Font Awesome: http://fontawesome.io/
    */
    wp_register_style('starter', get_template_directory_uri() . '/css/starter.min.css', array(), '1.0', 'all');
    wp_enqueue_style('starter'); // Enqueue it!

    wp_register_style('jquery-ui', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css', array(), '1.0', 'all');
    wp_enqueue_style('jquery-ui'); // Enqueue it!
	
    // Helper Stylesheet 
    wp_register_style('helper', get_template_directory_uri() . '/css/helper.css', array(), '1.0', 'all');
    wp_enqueue_style('helper'); // Enqueue it!
    

    // Your styles here!
    wp_register_style('sperling', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
    wp_enqueue_style('sperling'); // Enqueue it!
} 

// Load Google Fonts from CDN. 
function sperling_add_google_fonts() {
	// Enter the URL of your Google Fonts generated from https://fonts.google.com/ here.
	$google_fonts_url = 'https://fonts.googleapis.com/css2?family=Belleza&family=Libre+Franklin:wght@400;500&display=swap';
	?>

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

	<link href="<?php echo $google_fonts_url; ?>" rel="stylesheet">
<?php }


// Register Sperling Navigation
function register_menus()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'sperling'), // Main Navigation
        // duplicate if needed
    ));
}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

// If Dynamic Sidebar Exists
// if (function_exists('register_sidebar'))
// {
//     // Define Sidebar Widget Area 1
//     register_sidebar(array(
//         'name' => __('Widget Area 1', 'sperling'),
//         'description' => __('Description for this widget-area...', 'sperling'),
//         'id' => 'widget-area-1',
//         'before_widget' => '<div id="%1$s" class="%2$s">',
//         'after_widget' => '</div>',
//         'before_title' => '<h3>',
//         'after_title' => '</h3>'
//     ));

//     // Define Sidebar Widget Area 2
//     register_sidebar(array(
//         'name' => __('Widget Area 2', 'sperling'),
//         'description' => __('Description for this widget-area...', 'sperling'),
//         'id' => 'widget-area-2',
//         'before_widget' => '<div id="%1$s" class="%2$s">',
//         'after_widget' => '</div>',
//         'before_title' => '<h3>',
//         'after_title' => '</h3>'
//     ));
// }

// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function html5wp_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}

// Custom Excerpts
function html5wp_index($length) // Create 20 Word Callback for Index page Excerpts, call using html5wp_excerpt('html5wp_index');
{
    return 20;
}

// Create 40 Word Callback for Custom Post Excerpts, call using html5wp_excerpt('html5wp_custom_post');
function html5wp_custom_post($length)
{
    return 40;
}

// Create the Custom Excerpts callback
function html5wp_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}

// Custom View Article link to Post
function html5_blank_view_ellipses()  {
    return '...';
}

// Remove Admin bar
function remove_admin_bar()
{
    return false;
}

// Remove 'text/css' from our enqueued stylesheet
function html5_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

function custom_login_css_file() {
    wp_enqueue_style('login-styles', get_template_directory_uri() . '/css/login.css');
}

// Removes comments from admin menu
function my_remove_admin_menus() {
    remove_menu_page( 'edit-comments.php' );
}

// Removes comments from post and pages
function remove_comment_support() {
    remove_post_type_support( 'post', 'comments' );
    remove_post_type_support( 'page', 'comments' );
}
// Removes comments from admin bar
function mytheme_admin_bar_render() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
}

// Threaded Comments
function enable_threaded_comments()
{
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}

// Custom Comments Callback
function sperlingcomments($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
<!-- heads up: starting < for the html tag (li or div) in the next line: -->
<<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
    <?php if ( 'div' != $args['style'] ) : ?>
    <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
        <?php endif; ?>
        <div class="comment-author vcard">
            <?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['180'] ); ?>
            <?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
        </div>
        <?php if ($comment->comment_approved == '0') : ?>
        <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
        <br />
        <?php endif; ?>

        <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
                <?php
			printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','' );
		?>
        </div>

        <?php comment_text() ?>

        <div class="reply">
            <?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
        </div>
        <?php if ( 'div' != $args['style'] ) : ?>
    </div>
    <?php endif; ?>
    <?php }

// Change wp-login logo to site url
function custom_loginlogo_url($url) {
    return get_bloginfo('url');
}

// Remove old events from sitemap as well as noindex old events
/* add nofollow metatag to header of past events */

   /* exclude past events from the sitemap */ 
function my_find_expired_events( $ids ) {
    $args = array(
        'post_type'     => 'tribe_events',
        'nopaging'      => true,
        'fields'        => 'ids',
        'meta_query'    => array(
            array(
                'key'       => '_EventEndDate',
                'value'     => date( 'Y-m-d H:i:s' ),
                'compare'   => '<',
                'type'      => 'DATETIME',
            ),
        ),
    );
    $expired_events = get_posts( $args );
    $ids = array_merge( $ids, $expired_events );
    $ids = array_map( 'absint', $ids );
    $ids = array_unique( $ids );
    return $ids;
}

// Disable Author Pages (Archives)
function disable_author_archives() { 
    if (is_author()) { 
        global $wp_query; 
        $wp_query->set_404(); 
        status_header(404); 
    } else { 
        redirect_canonical(); 
    }
 } 

// Small Function to retrieve the Alt of any Post Thumbnail 
// Just pass the ID of the post for the post thumbnail alt that you need
function get_the_post_thumbnail_alt($ids) {
	$thumbnail_id = get_post_thumbnail_id($ids);
	$alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
	return $alt;
}



/**
 * Adds a responsive embed wrapper around oEmbed content
 * @param  string $html The oEmbed markup
 * @param  string $url  The URL being embedded
 * @param  array  $attr An array of attributes
 * @return string       Updated embed markup
 */

function setup_theme(  ) {
    // Filters the oEmbed process to run the responsive_embed() function
    add_filter('embed_oembed_html', 'responsive_embed', 10, 3);
}
function responsive_embed($html, $url, $attr) {
    return $html!=='' ? '<div class="embed-container">'.$html.'</div>' : '';
}

/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('init', 'sperling_header_scripts'); // Add Custom Scripts to wp_head
//add_action('init', 'enqueue_aos'); // Add AOS (animate on scroll) library
add_action('wp_print_scripts', 'sperling_conditional_scripts'); // Add Conditional Page Scripts
// add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
add_action('wp_enqueue_scripts', 'sperling_styles'); // Add Theme Stylesheet
add_action('init', 'register_menus'); // Add Sperling Menu
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
add_action('init', 'html5wp_pagination'); // Add our HTML5 Pagination
add_action('template_redirect', 'disable_author_archives'); // Disable Author Pages (Archives)
// add_action( 'wp_head', 'sperling_add_google_fonts' ); // Enqueue Google Font
add_action('login_enqueue_scripts', 'custom_login_css_file');
add_action('init', 'remove_comment_support', 100); // Removes comments from post and pages
add_action( 'admin_menu', 'my_remove_admin_menus' ); // Removes comments from admin menu
add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' ); // Removes comments from admin bar
add_action('after_setup_theme', 'setup_theme'); // Adds responsive wrapper to oEmbeds

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
// add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('style_loader_tag', 'html5_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter( 'excerpt_more', 'html5_blank_view_ellipses' ); // Add ... instead of [...] for Excerpts
add_filter( 'login_headerurl', 'custom_loginlogo_url' ); // Change wp-login logo to site url
add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');
add_filter( 'wpseo_exclude_from_sitemap_by_post_ids', 'my_find_expired_events' );

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether
remove_filter('template_redirect', 'redirect_canonical'); // Disable Author Pages (Archives)

// Teams post type
function create_teams_posttype() {
  
    register_post_type( 'teams',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Teams' ),
                'singular_name' => __( 'Team' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'teams'),
            'show_in_rest' => true,
            'supports' => array('title', 'editor', 'thumbnail'),
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_teams_posttype' );

// Players post type
function create_players_posttype() {
  
    register_post_type( 'players',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Players' ),
                'singular_name' => __( 'Player' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'players'),
            'show_in_rest' => true,
            'supports' => array('title', 'editor', 'thumbnail'),
  
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_players_posttype' );

// Players post type
function create_games_posttype() {
  
    register_post_type( 'games',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Games' ),
                'singular_name' => __( 'Game' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'games'),
            'show_in_rest' => true,
            'supports' => array('title', 'editor', 'thumbnail'),
  
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_games_posttype' );