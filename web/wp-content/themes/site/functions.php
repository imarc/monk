<?php
if (! class_exists('Timber')) {
	add_action('admin_notices', function() {
        echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
    });
    return;
}

Timber::$dirname = array('templates', 'views');

class Site extends TimberSite {
	public function __construct() {
		add_theme_support('post-formats');
		add_theme_support('post-thumbnails');
		add_theme_support('menus' );

		add_filter('timber_context', array($this, 'add_to_context'));
		add_filter('get_twig', array($this, 'add_to_twig'));

		add_action('init', array($this, 'register_post_types'));
		add_action('init', array($this, 'register_taxonomies'));

        remove_filter('template_redirect', 'redirect_canonical');
        add_action('template_redirect', array($this, 'custom_redirect_canonical'));

		parent::__construct();
	}

    // custom redirect canonical
    public function custom_redirect_canonical()
    {
        // disable all category, author, and date pages
        if (is_category() || is_author() || is_date()) {
            $wp_query->set_404();
            status_header(404);
            return;
        }

        redirect_canonical();
    }

	public function register_post_types() {
		//this is where you can register custom post types
	}

	public function register_taxonomies() {
		//this is where you can register custom taxonomies
	}

	public function add_to_context( $context ) {
        // these values are available everytime you call TImber::get_context()
		$context['menu'] = new TimberMenu();
		$context['site'] = $this;
		return $context;
	}

	public function add_to_twig( $twig ) {
		/* this is where you can add your own fuctions to twig */
		$twig->addFilter('mix', new Twig_SimpleFilter('mix', array($this, 'mix')));
		return $twig;
	}

    public function mix($path)
    {
        static $manifest;

        $path = '/' . ltrim($path, '/');

        if (!$manifest && $manifestPath = realpath(get_template_directory() . '/mix-manifest.json')) {
            $manifest = json_decode(file_get_contents($manifestPath), true);
        }

        if (!$manifest) {
            throw new Exception("mix-manifest.json doesn't exist");
        }

        if (isset($manifest[$path])) {
            return get_template_directory_uri() . $manifest[$path];
        }

        return '';
    }

}

new Site();
