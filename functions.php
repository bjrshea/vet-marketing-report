<?php
/**
 * GeneratePress.
 *
 * Please do not make any edits to this file. All edits should be done in a child theme.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action('wp_enqueue_scripts', 'front_end_scripts');
function front_end_scripts() {
	wp_enqueue_script('frontEndScripts', get_template_directory_uri() . '/ivetJS/scripts.js', array('jquery'));
}

// Set our theme version.
define( 'GENERATE_VERSION', '2.2.2' );

if ( ! function_exists( 'generate_setup' ) ) {
	add_action( 'after_setup_theme', 'generate_setup' );
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * @since 0.1
	 */
	function generate_setup() {
		// Make theme available for translation.
		load_theme_textdomain( 'generatepress' );

		// Add theme support for various features.
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link', 'status' ) );
		add_theme_support( 'woocommerce' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'editor-color-palette', array() );
		add_theme_support( 'responsive-embeds' );

		add_theme_support( 'custom-logo', array(
			'height' => 70,
			'width' => 350,
			'flex-height' => true,
			'flex-width' => true,
		) );

		// Register primary menu.
		register_nav_menus( array(
			'primary' => __( 'Primary Menu', 'generatepress' ),
		) );

		/**
		 * Set the content width to something large
		 * We set a more accurate width in generate_smart_content_width()
		 */
		global $content_width;
		if ( ! isset( $content_width ) ) {
			$content_width = 1200; /* pixels */
		}

		// This theme styles the visual editor to resemble the theme style.
		add_editor_style( 'css/admin/editor-style.css' );
	}
}

/**
 * Get all necessary theme files
 */
require get_template_directory() . '/inc/theme-functions.php';
require get_template_directory() . '/inc/defaults.php';
require get_template_directory() . '/inc/class-css.php';
require get_template_directory() . '/inc/css-output.php';
require get_template_directory() . '/inc/general.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/markup.php';
require get_template_directory() . '/inc/typography.php';
require get_template_directory() . '/inc/plugin-compat.php';
require get_template_directory() . '/inc/block-editor.php';
require get_template_directory() . '/inc/migrate.php';
require get_template_directory() . '/inc/deprecated.php';

if ( is_admin() ) {
	require get_template_directory() . '/inc/meta-box.php';
	require get_template_directory() . '/inc/dashboard.php';
}

/**
 * Load our theme structure
 */
require get_template_directory() . '/inc/structure/archives.php';
require get_template_directory() . '/inc/structure/comments.php';
require get_template_directory() . '/inc/structure/featured-images.php';
require get_template_directory() . '/inc/structure/footer.php';
require get_template_directory() . '/inc/structure/header.php';
require get_template_directory() . '/inc/structure/navigation.php';
require get_template_directory() . '/inc/structure/post-meta.php';
require get_template_directory() . '/inc/structure/sidebars.php';

function custom_style_sheet() {
wp_enqueue_style( 'custom-styling', get_stylesheet_directory_uri() . '/custom.css' );
}
add_action('wp_enqueue_scripts', 'custom_style_sheet');

function add_file_types_to_uploads($file_types){
$new_filetypes = array();
$new_filetypes['svg'] = 'image/svg+xml';
$file_types = array_merge($file_types, $new_filetypes );
return $file_types;
}
add_filter('upload_mimes', 'add_file_types_to_uploads');

function splash_page() {
	ob_start();
	?>
	<div class="splash-page-container">
		<div class="splash-page-content">
			<div class="content-left">
				<img src="/wp-content/uploads/2020/01/iVET360-2016-BrandID-W.png" alt="iVET360 Logo">
			</div>
			<div class="content-right">
				<ul>
					<a href="/competitor-analysis/"><li>Competitor Analysis Report</li></a>
					<a href="/google-ads-report/"><li>Google Ads Report</li></a>
					<a href="/vmbr-form/"><li>Marketing Benchmark Report</li></a>
					<a href="/scorecard/"><li>Marketing Scorecard Report</li></a>
				</ul>
			</div>
		</div>
	</div>
	<?php return ob_get_clean();
}
add_shortcode('splash_page','splash_page');

function ads_results_page() {
	ob_start();
	?>
	<div class="form-results">
		<div class="title-row">
			<div class="title-text">
				<h2 class="ads-title">Google Ads Report</h2>
				<p id="ads-name-date"><?php echo $_GET['hospital_name'] ?> // <?php echo $_GET['date'] ?></p>
			</div>
			<img class="ivet360-logo" src="/wp-content/uploads/2020/01/ivet360_logo.png" alt="iVET360 Logo">
		</div>
		<div class="ads-row">
			<h2 class="ads-title">Google Ads Monthly Performance Summary</h2>
			<div class="divider-box website-divider">
				<i class="fas fa-dot-circle"></i>
				<div class="ads-title-divider"></div>
			</div>
			<h3 class="ads-box-title">Clicks</h3>
			<div class="inner-ads-row">
				<div class="ads-data-box left-ads">
					<p class="ads-big-score"><?php echo $_GET['clicks'] ?></p>
					<div class="ads-percentage-change">
						<p>MoM % Change</p>
						<p class="ads-percentage"><span class="percentage"><?php echo $_GET['clicks_%'] ?></span>%</p>
					</div>
				</div>
				<div class="ads-data-box right-ads">
					<p>This is when someone clicks your ad, such as when they click on the blue headline. Clicks can help you understand how well your ad is appealing to people who see it.</p>
				</div>
			</div>
		</div>
		<div class="ads-row">
			<h3 class="ads-box-title">Impressions (Impr.)</h3>
			<div class="inner-ads-row">
				<div class="ads-data-box left-ads">
					<p class="ads-big-score"><?php echo $_GET['impressions'] ?></p>
					<div class="ads-percentage-change">
						<p>MoM % Change</p>
						<p class="ads-percentage"><span class="percentage"><?php echo $_GET['impressions_%'] ?></span>%</p>
					</div>
				</div>
				<div class="ads-data-box right-ads">
					<p>An impression is the number of times your ad comes up or is shown in a search. The total number of impressions is the number of times your ad was shown during the selected timeframe.</p>
				</div>
			</div>
		</div>
		<div class="ads-row">
			<h3 class="ads-box-title">Clickthrough Rate (CTR)</h3>
			<div class="inner-ads-row">
				<div class="ads-data-box left-ads">
					<p class="ads-big-score"><?php echo $_GET['clickthrough'] ?>%</p>
					<div class="ads-percentage-change">
						<p>MoM % Change</p>
						<p class="ads-percentage"><span class="percentage"><?php echo $_GET['clickthrough_%'] ?></span>%</p>
					</div>
				</div>
				<div class="ads-data-box right-ads">
					<p>This number tells you how often people who see your ad click on it relative to the number of times your ad is shown (impressions). Clicks ÷ Impressions = CTR. It’s a good indicator of how well your ads are performing, and if the message in those ads is relevant to the people you’re trying to reach.</p>
					<p class="ads-industry-avg">Industry Average: <span class="ads-avg-numbers">3.27%</span> // iVET360 Client Average: <span class="ads-avg-numbers">3.78%</span></p>
				</div>
			</div>
		</div>
		<div class="ads-row">
			<h3 class="ads-box-title">Average Cost Per Click (Avg. CPC)</h3>
			<div class="inner-ads-row">
				<div class="ads-data-box left-ads">
					<p class="ads-big-score">$<?php echo $_GET['cpc'] ?></p>
					<div class="ads-percentage-change">
						<p>MoM % Change</p>
						<p class="ads-percentage reverse"><span class="percentage"><?php echo $_GET['cpc_%'] ?></span>%</p>
					</div>
				</div>
				<div class="ads-data-box right-ads">
					<p>This is the average amount you’re paying for each click. Total cost of your clicks ÷ Total number of clicks = Average CPC. Understanding this number will help you gauge how your ads are doing compared to other veterinary practices who are using Google Ads.</p>
					<p class="ads-industry-avg">Industry Average: <span class="ads-avg-numbers">$2.62</span> // iVET360 Client Average: <span class="ads-avg-numbers">$2.46</span></p>
				</div>
			</div>
		</div>
		<div class="ads-row">
			<h3 class="ads-box-title">Conversions</h3>
			<div class="inner-ads-row">
				<div class="ads-data-box left-ads">
					<p class="ads-big-score"><?php echo $_GET['conversions'] ?></p>
					<div class="ads-percentage-change">
						<p>MoM % Change</p>
						<p class="ads-percentage"><span class="percentage"><?php echo $_GET['conversions_%'] ?></span>%</p>
					</div>
				</div>
				<div class="ads-data-box right-ads">
					<p>This is one of the most important numbers to know, because it tells you if your ads are converting people into clients. A conversion is when someone who clicks on your Google Ad takes an action that benefits your practice. At iVET360, a conversion is counted each time one of the following actions take place:</p>
					<ul>
						<li>A contact form is submitted via your Google Ads landing page</li>
						<li>Someone clicks to call the practice, either from the landing page or the ad itself</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="ads-row">
			<h3 class="ads-box-title">Cost Per Conversion (Cost / conv.)</h3>
			<div class="inner-ads-row">
				<div class="ads-data-box left-ads">
					<p class="ads-big-score">$<?php echo $_GET['per_conversion'] ?></p>
					<div class="ads-percentage-change">
						<p>MoM % Change</p>
						<p class="ads-percentage reverse"><span class="percentage"><?php echo $_GET['per_conversion_%'] ?></span>%</p>
					</div>
				</div>
				<div class="ads-data-box right-ads">
					<p>This tells you the average cost of each conversion. Total spend for the month ÷ Number of conversions = Cost Per Conversion. Simply put, it’s what it costs you, on average, to acquire an appointment opportunity for the practice.</p>
					<p class="ads-industry-avg">Industry Average: <span class="ads-avg-numbers">$78.09</span> // iVET360 Client Average: <span class="ads-avg-numbers">$21.75</span></p>
				</div>
			</div>
		</div>
		<div class="ads-row">
			<h3 class="ads-box-title">Conversion Rate (Conv. rate)</h3>
			<div class="inner-ads-row">
				<div class="ads-data-box left-ads">
					<p class="ads-big-score"><?php echo $_GET['conversion_rate'] ?>%</p>
					<div class="ads-percentage-change">
						<p>MoM % Change</p>
						<p class="ads-percentage"><span class="percentage"><?php echo $_GET['conversion_rate_%'] ?></span>%</p>
					</div>
				</div>
				<div class="ads-data-box right-ads">
					<p>How often a click becomes a conversion is your conversion rate. Conversions ÷ Clicks = Conversion Rate. This conversion rate will help you understand how appealing and persuasive your ads, landing pages, and/or website are to your target audience.</p>
					<p class="ads-industry-avg">Industry Average: <span class="ads-avg-numbers">3.36%</span> // iVET360 Client Average: <span class="ads-avg-numbers">11.3%</span></p>
				</div>
			</div>
		</div>
		<?php if ( $_GET['utilize_tracking'] != 'No' ) { ?>
		<div class="ads-row">
			<h2 class="ads-title">Google Ads Call Tracking Performance</h2>
			<div class="divider-box website-divider">
				<i class="fas fa-dot-circle"></i>
				<div class="ads-title-divider"></div>
			</div>
			<h3 class="ads-box-title">Number of Calls</h3>
			<div class="inner-ads-row">
				<div class="ads-data-box left-ads">
					<p class="ads-big-score"><?php echo $_GET['calls_number'] ?></p>
				</div>
				<div class="ads-data-box right-ads">
					<p>This is the total number of times a prospective client called your practice after seeing one of your ads in Google Search.</p>
				</div>
			</div>
		</div>
		<div class="ads-row">
			<h3 class="ads-box-title">Number of Appointment Opportunities</h3>
			<div class="inner-ads-row">
				<div class="ads-data-box left-ads">
					<p class="ads-big-score"><?php echo $_GET['opportunities_number'] ?></p>
				</div>
				<div class="ads-data-box right-ads">
					<p>This refers to the total number of authentic appointment opportunities identified by CallBox. Vendors, spammers, or callers who are only inquiring about office hours, medication instructions, etc. are NOT counted as appointment opportunities.</p>
				</div>
			</div>
		</div>
		<div class="ads-row">
			<h3 class="ads-box-title">Number of Appointments Booked</h3>
			<div class="inner-ads-row">
				<div class="ads-data-box left-ads">
					<p class="ads-big-score"><?php echo $_GET['booked_number'] ?></p>
				</div>
				<div class="ads-data-box right-ads">
					<p>The number of appointments identified as booked by CallBox. This number helps us to understand how well your practice is maximizing the opportunities delivered by Google Ads, and ultimately, the return on your investment.</p>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
	<?php return ob_get_clean();
}
add_shortcode('ads_results_page','ads_results_page');


function benchmark_results_page() {
	ob_start();
	?>
	<div class="form-results">
		<?php if ( is_page( 'scorecard-results' ) ) { ?>
		<h1>Marketing Scorecard</h1>
		<?php } else { ?>
		<h1 id="hospital-name"><?php echo $_GET['hospital_name'] ?></h1>
		<h1>Veterinary Marketing Benchmark Report</h1>
		<?php } ?>
		<p>While the large part of a veterinary hospital’s success will always remain in the quality of care given to pets as a trusted presence in the community, it has also become increasingly important to have a strong digital presence. As the world continues to evolve and intertwine with the internet, simply having a personalized website (which every veterinary practice should have) is not enough; in fact, it’s only the first step. To be successful in a digital environment, hospitals should take care to create a marketing plan that spans the platforms and ecosystems that make up the internet—which can be a lot to think about.</p>

		<?php if ( is_page( 'scorecard-results' ) ) { ?>
		<div class="legend">
			<div class="legend-section">
				<div class="legend-title">
					<h2>Website Report</h2>
					<img src="/wp-content/uploads/2019/11/web-vmbr.png" alt="World Wide Web Icon">
				</div>
				<div class="legend-row">
					<div class="column-one">
						<p class="column-title">Topic</p>
					</div>
					<div class="column-two">
						<p class="column-title">Industry Average</p>
					</div>
					<div class="column-three">
						<p class="column-title">Your Hospital</p>
					</div>
				</div>
				<div class="legend-row">
					<div class="column-one">
						<a href="#domain" class="legend-link">Domain Name Set Up (Website URL)</a>
					</div>
					<div class="column-two">
						<p>83.7%</p>
					</div>
					<div class="column-three">
						<p class="yes-no"><?php echo $_GET['domain'] ?></p>
					</div>
				</div>
				<div class="legend-row">
					<div class="column-one">
						<a href="#responsive" class="legend-link">Mobile Responsive Website</a>
					</div>
					<div class="column-two">
						<p>93.9%</p>
					</div>
					<div class="column-three">
						<p class="yes-no"><?php echo $_GET['responsive'] ?></p>
					</div>
				</div>
				<div class="legend-row">
					<div class="column-one">
						<a href="#ssl" class="legend-link">SSL Certificates</a>
					</div>
					<div class="column-two">
						<p>73.4%</p>
					</div>
					<div class="column-three">
						<p class="yes-no"><?php echo $_GET['ssl'] ?></p>
					</div>
				</div>
				<div class="legend-row">
					<div class="column-one">
						<a href="#seo" class="legend-link">Search Engine Optimization (SEO)</a>
					</div>
					<div class="column-two">
						<p>18.5%</p>
					</div>
					<div class="column-three">
						<p class="yes-no"><?php echo $_GET['seo'] ?></p>
					</div>
				</div>
				<div class="legend-row">
					<div class="column-one">
						<a href="#google-analytics" class="legend-link">Google Analytics</a>
					</div>
					<div class="column-two">
						<p>83.2%</p>
					</div>
					<div class="column-three">
						<p class="yes-no"><?php echo $_GET['analytics'] ?></p>
					</div>
				</div>
				<div class="legend-row">
					<div class="column-one">
						<a href="#ada" class="legend-link">ADA Accessibility</a>
					</div>
					<div class="column-two">
						<p>46.6%</p>
					</div>
					<div class="column-three">
						<p class="yes-no"><?php echo $_GET['ada'] ?></p>
					</div>
				</div>
				<div class="legend-row">
					<div class="column-one">
						<a href="#web-speed" class="legend-link">Website Page Speed</a>
					</div>
					<div class="column-two">
						<p class="industry-avg">3.9 Seconds (4G)</p>
						<p class="industry-avg">8.2 Seconds (3G)</p>
					</div>
					<div class="column-three">
						<p class="inputted-number"><?php echo $_GET['4g'] ?> Seconds (4G)</p>
						<p class="inputted-number"><?php echo $_GET['3g'] ?> Seconds (3G)</p>
					</div>
				</div>
			</div>

			<div class="legend-section">
				<div class="legend-title">
					<h2>Google My Business</h2>
					<img src="/wp-content/uploads/2019/11/gmb-vmbr.png" alt="Google Icon">
				</div>
				<div class="legend-row">
					<div class="column-one">
						<p class="column-title">Topic</p>
					</div>
					<div class="column-two">
						<p class="column-title">Industry Average</p>
					</div>
					<div class="column-three">
						<p class="column-title">Your Hospital</p>
					</div>
				</div>
				<div class="legend-row">
					<div class="column-one">
						<a href="#google-reviews" class="legend-link">Google Reviews</a>
					</div>
					<div class="column-two">
						<p class="industry-avg">115</p>
					</div>
					<div class="column-three">
						<p class="inputted-number"><?php echo $_GET['g_reviews'] ?></p>
					</div>
				</div>
				<div class="legend-row">
					<div class="column-one">
						<a href="#google-ads" class="legend-link">Google Ads (Formerly Adwords)</a>
					</div>
					<div class="column-two">
						<p>11.8%</p>
					</div>
					<div class="column-three">
						<p class="yes-no"><?php echo $_GET['g_ads'] ?></p>
					</div>
				</div>
				<div class="legend-row">
					<div class="column-one">
						<a href="#gmb-claimed" class="legend-link">GMB Claimed</a>
					</div>
					<div class="column-two">
						<p>92.5%</p>
					</div>
					<div class="column-three">
						<p class="yes-no"><?php echo $_GET['gmb_verified'] ?></p>
					</div>
				</div>
				<div class="legend-row">
					<div class="column-one">
						<a href="#gmb-appt" class="legend-link">GMB Appointment Link</a>
					</div>
					<div class="column-two">
						<p>22.6%</p>
					</div>
					<div class="column-three">
						<p class="yes-no"><?php echo $_GET['gmb_appt'] ?></p>
					</div>
				</div>
				<div class="legend-row">
					<div class="column-one">
						<a href="#gmb-description" class="legend-link">GMB Description</a>
					</div>
					<div class="column-two">
						<p>35.6%</p>
					</div>
					<div class="column-three">
						<p class="yes-no"><?php echo $_GET['gmb_desc'] ?></p>
					</div>
				</div>
				<div class="legend-row">
					<div class="column-one">
						<a href="#gmb-short" class="legend-link">Google Short Name</a>
					</div>
					<div class="column-two">
						<p>8.3%</p>
					</div>
					<div class="column-three">
						<p class="yes-no"><?php echo $_GET['gmb_short'] ?></p>
					</div>
				</div>
				<div class="legend-row">
					<div class="column-one">
						<a href="#gmb-posts" class="legend-link">GMB Posts</a>
					</div>
					<div class="column-two">
						<p>21%</p>
					</div>
					<div class="column-three">
						<p class="yes-no"><?php echo $_GET['gmb_posts'] ?></p>
					</div>
				</div>
				<div class="legend-row">
					<div class="column-one">
						<a href="#gmb-offers" class="legend-link">GMB Offers</a>
					</div>
					<div class="column-two">
						<p>3.4%</p>
					</div>
					<div class="column-three">
						<p class="yes-no"><?php echo $_GET['gmb_offers'] ?></p>
					</div>
				</div>
				<!-- <div class="legend-row">
					<div class="column-one">
						<a href="#gmb-qa" class="legend-link">GMB Questions & Answers</a>
					</div>
					<div class="column-two">
						<p>17.1%</p>
						<p class="industry-avg">3</p>
					</div>
					<div class="column-three">
						<p class="yes-no"><?php /* echo $_GET['gmb_qa'] */ ?></p>
						<p class="inputted-number"><?php /* echo $_GET['gmb_biz'] */ ?></p>
					</div>
				</div> -->
			</div>

			<div class="legend-section">
				<div class="legend-title">
					<h2>Facebook</h2>
					<img src="/wp-content/uploads/2019/11/fb-vmbr.png" alt="Facebook Icon">
				</div>
				<div class="legend-row">
					<div class="column-one">
						<p class="column-title">Topic</p>
					</div>
					<div class="column-two">
						<p class="column-title">Industry Average</p>
					</div>
					<div class="column-three">
						<p class="column-title">Your Hospital</p>
					</div>
				</div>
				<!-- <div class="legend-row">
					<div class="column-one">
						<a href="#fb-reviews" class="legend-link">Facebook Reviews</a>
					</div>
					<div class="column-two">
						<p class="industry-avg">69</p>
					</div>
					<div class="column-three">
						<p class="inputted-number"><?php /* echo $_GET['fb_reviews'] */ ?></p>
					</div>
				</div> -->
				<?php if ( $_GET['fb_recs'] != null ) { ?>
				<div class="legend-row">
					<div class="column-one">
						<a href="#fb-recs" class="legend-link">Facebook Recommendations</a>
					</div>
					<div class="column-two">
						<p class="industry-avg">155</p>
					</div>
					<div class="column-three">
						<p class="inputted-number"><?php echo $_GET['fb_recs'] ?></p>
					</div>
				</div>
				<?php } ?>
				<div class="legend-row">
					<div class="column-one">
						<a href="#fb-un" class="legend-link">Facebook Vanity URL (Username)</a>
					</div>
					<div class="column-two">
						<p>80.1%</p>
					</div>
					<div class="column-three">
						<p class="yes-no"><?php echo $_GET['fb_vanity'] ?></p>
					</div>
				</div>
				<div class="legend-row">
					<div class="column-one">
						<a href="#fb-branding" class="legend-link">Facebook Branding</a>
					</div>
					<div class="column-two">
						<p>63.1%</p>
					</div>
					<div class="column-three">
						<p class="yes-no"><?php echo $_GET['fb_branded'] ?></p>
					</div>
				</div>
			</div>

			<div class="legend-section">
				<div class="legend-title">
					<h2>Yelp</h2>
					<img src="/wp-content/uploads/2019/11/yelp-vmbr.png" alt="Yelp Icon">
				</div>
				<div class="legend-row">
					<div class="column-one">
						<p class="column-title">Topic</p>
					</div>
					<div class="column-two">
						<p class="column-title">Industry Average</p>
					</div>
					<div class="column-three">
						<p class="column-title">Your Hospital</p>
					</div>
				</div>
				<div class="legend-row">
					<div class="column-one">
						<a href="#yelp-reviews" class="legend-link">Yelp Reviews</a>
					</div>
					<div class="column-two">
						<p class="industry-avg">30</p>
					</div>
					<div class="column-three">
						<p class="inputted-number"><?php echo $_GET['y_reviews'] ?></p>
					</div>
				</div>
				<div class="legend-row">
					<div class="column-one">
						<a href="#yelp-claimed" class="legend-link">Yelp Claimed</a>
					</div>
					<div class="column-two">
						<p>89%</p>
					</div>
					<div class="column-three">
						<p class="yes-no"><?php echo $_GET['y_claimed'] ?></p>
					</div>
				</div>
				<div class="legend-row">
					<div class="column-one">
						<a href="#yelp-check" class="legend-link">Yelp Check-In Offers</a>
					</div>
					<div class="column-two">
						<p>9.3%</p>
					</div>
					<div class="column-three">
						<p class="yes-no"><?php echo $_GET['y_checkin'] ?></p>
					</div>
				</div>
			</div>

			<div class="legend-section">
				<div class="legend-title">
					<h2>Nextdoor</h2>
					<img src="/wp-content/uploads/2019/11/nd-vmbr.png" alt="Nextdoor Icon">
				</div>
				<div class="legend-row">
					<div class="column-one">
						<p class="column-title">Topic</p>
					</div>
					<div class="column-two">
						<p class="column-title">Industry Average</p>
					</div>
					<div class="column-three">
						<p class="column-title">Your Hospital</p>
					</div>
				</div>
				<div class="legend-row">
					<div class="column-one">
						<a href="#nd-recs" class="legend-link">Nextdoor Recommendations</a>
					</div>
					<div class="column-two">
						<p class="industry-avg">82</p>
					</div>
					<div class="column-three">
						<p class="inputted-number"><?php echo $_GET['nd_recs'] ?></p>
					</div>
				</div>
				<div class="legend-row">
					<div class="column-one">
						<a href="#nd-claimed" class="legend-link">Nextdoor Claimed</a>
					</div>
					<div class="column-two">
						<p>29.3%</p>
					</div>
					<div class="column-three">
						<p class="yes-no"><?php echo $_GET['nd_claimed'] ?></p>
					</div>
				</div>
				<div class="legend-row">
					<div class="column-one">
						<a href="#nd-faves" class="legend-link">Nextdoor Favorites</a>
					</div>
					<div class="column-two">
						<p class="industry-avg">5</p>
					</div>
					<div class="column-three">
						<p class="inputted-number"><?php echo $_GET['nd_faves'] ?></p>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>

		<div class="data-section" id="website-report">
			<div class="divider-box website-divider">
				<i class="fas fa-dot-circle"></i>
				<div class="divider"></div>
			</div>
			<div class="section-title fade-element">
				<h1>Website Report</h1>
				<img src="/wp-content/uploads/2019/11/web-vmbr.png" alt="World Wide Web Icon">
			</div>
			<div class="section-description fade-element">
				<p>A veterinary hospital’s website should be a digital manifestation of the information and personality a client would be able to receive by walking through the doors of the physical hospital. This would include answers to any question a client or potential client would have about the practice and multiple points of contact should they not find the information they were looking for. Basically, the website should be the go-to resource for anything and everything related to its respective hospital.</p>
				<p>You’ve heard it all before: as a business, you need a fast, mobile-friendly, secure website with SEO, SEO, SEO. But the truth is, you really need to start comparing your hospital’s website with other, local animal hospitals, and stop comparing your site to standards set up outside the industry. The key is to learn the what, why and how to make sure your hospital’s website will out-perform any local competition.</p>
				<p>Here we dive into the foundational best practices of what your website should shoot for.</p>
			</div>

			<div id="domain">
				<div class="data-set fade-element">
					<div class="data-title">
						<h2 class="website-title">DOMAIN NAME SET UP (WEBSITE URL)</h2>
						<div class="more-info">
							<p>Learn More</p>
							<i class="far fa-question-circle"></i>
						</div>
					</div>
					<div class="data-row main-row">
						<div class="benchmark-data-box">
							<h3 class="box-title">Your Score</h3>
							<p class="big-score yes-no"><?php echo $_GET['domain'] ?></p>
							<p class="score-description">Is your website domain set up correctly</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Industry Average</h3>
							<p class="big-score">83.3%</p>
							<p class="score-description">Have their website domain set up correctly</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Prior Year Stats</h3>
							<p class="small-score">2018: 84.2%</p>
							<p class="small-score">2017: 70.9%</p>
						</div>
						<div class="benchmark-data-box last-benchmark-data-box">
							<h3 class="box-title">Industry Notes</h3>
							<p class="score-description">The industry saw a 7% decline over last year, but is up 17% overall over the past two years. 100% of iVET360 clients have a correctly set up URL.</p>
						</div>
					</div>
					<div class="hover-text">
						<h3>The What:</h3>
						<p>We start with one of the most basic—though also one of the most important—questions: is your website domain set up correctly? On first glance, you may think that it is, but the fact of the matter is that there are many veterinary pages that are incorrectly set up—meaning they have two versions of the same website out there, competing with each other.</p>
						<p>To be more specific, we’ll use the example of a fictional practice called Good Veterinary Hospital. Now, this veterinarian does not have their domain set up correctly—as such, their website can be reached at www.GoodVeterinaryHospital.com as well as at GoodVeterinaryHospital.com (notice the second version does not have www). This is bad—by having two versions of the same website, search engines like Google view this as duplicate content, which lowers the “value” of Good Veterinary Hospital’s SEO.</p>
						<h3>The Why:</h3>
						<p>Considering the simplicity of this issue, this year’s decline in corrected domains is concerning. It’s likely that many of the practices that caused the rather large increase in secure websites did not install their SSL certificates correctly. This could cause a separation of domains, making one “secure” and one “not secure,” neither of which would be able to redirect to the other. The example for this would be https://www.GoodVeterinaryHospital.com versus http://www.GoodVeterinaryHospital.com.</p>
						<h3>The How:</h3>
						<p><b>How to check if your website domain is set up correctly:</b> Type your domain name into your browser’s address bar including the “www.” (for example: www. YourHospitalName.com). Once the page loads completely, remove the www. from the address bar and hit return. If your domain reloads and displays without the www. (as “YourHospitalName.com”), your website is duplicated—this is detrimental. If it reloads with the www. automatically, you are set up correctly. This also works vice versa with the www. redirecting to no www. The important thing is to not have both versions load.</p>
						<p>If you or your developer has added an SSL certification to your website, type in “http://” before your domain name. Your website should automatically reload to “https://” if the certificate was installed correctly.</p>
						<p><b>How To Fix This:</b> Both of these issues are pretty technical, so talk to your web developer ASAP. If you don’t have one, you can fix the “www.” redirect by using this link from <a href="https://www.namecheap.com/" target="_blank">NameCheap</a> to set up the DNS record yourself. For the incorrect SSL installation, you’ll need to contact your service provider if you don’t have a developer.</p>
					</div>
				</div>
			</div>

			<div id="responsive">
				<div class="data-set fade-element">
					<div class="data-title">
						<h2 class="website-title">MOBILE RESPONSIVE WEBSITE</h2>
						<div class="more-info">
							<p>Learn More</p>
							<i class="far fa-question-circle"></i>
						</div>
					</div>
					<div class="data-row main-row">
						<div class="benchmark-data-box">
							<h3 class="box-title">Your Score</h3>
							<p class="big-score yes-no"><?php echo $_GET['responsive'] ?></p>
							<p class="score-description">Do you have a mobile responsive website</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Industry Average</h3>
							<p class="big-score">93.9%</p>
							<p class="score-description">Have a mobile responsive website</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Prior Year Stats</h3>
							<p class="small-score">2018: 93.2%</p>
							<p class="small-score">2017: 85.2%</p>
						</div>
						<div class="benchmark-data-box last-benchmark-data-box">
							<h3 class="box-title">Industry Notes</h3>
							<p class="score-description">The industry saw a mere 1% growth over last year, but an overall growth of 10% over the past two years. 100% of iVET360 clients have a responsive website.</p>
						</div>
					</div>
					<div class="hover-text">
						<h3>The What:</h3>
						<p>With the number of varied devices people use to access the internet—and to search for veterinary hospitals—it is incredibly important for a website to behave responsively. For you, this means that the backend of your website needs to be adjusted so that it can change depending on the device used; whether it be accessed by tablet, smartphone, or plain old desktop, your website should to boast easy engagement and be entirely user-friendly. While this may not have been as consequential a few years ago, there is evidence that <a href="https://www.statista.com/statistics/241462/global-mobile-phone-website-traffic-share/" target="_blank">mobile searches have increased by a consistent 50 percent</a>, year after year. This means your current and potential clients are most likely going to look for, and find, a veterinarian using their phone or tablet.</p>
						<p>If that wasn’t enough, Google has also been penalizing non-mobile-friendly sites since 2015.</p>
						<p>Despite this development, there are still some veterinary websites (and marketing providers) that have not adjusted their backend to be responsive to all devices. Since a website appears differently on a desktop computer than it does on a tablet or cellphone, certain elements need to be tweaked to ensure that its readability is compatible on all devices.</p>
						<p>This affects not only the user-experience, but also search rankings—if a page is not responsive, its visibility will suffer. This simple-yet-important step is critical in this digital, smartphone-driven age, and while it seems the industry has plateaued this year, we still believe every veterinary practice should have a responsive website.</p>
						<h3>The Why:</h3>
						<p>This metric has inched closer and closer to 100 percent for the past three years. With the continued push by Google to be Mobile First, we don’t foresee this metric declining.</p>
						<h3>The How:</h3>
						<p><b>How to check if your website is responsive:</b> Visit <a href="https://search.google.com/test/mobile-friendly" target="_blank">search.google.com/test/mobile-friendly</a> and enter your veterinary hospital’s website address. Google will do the rest.</p>
					</div>
				</div>
			</div>

			<div id="ssl">
				<div class="data-set fade-element">
					<div class="data-title">
						<h2 class="website-title">SSL CERTIFICATES</h2>
						<div class="more-info">
							<p>Learn More</p>
							<i class="far fa-question-circle"></i>
						</div>
					</div>
					<div class="data-row main-row">
						<div class="benchmark-data-box">
							<h3 class="box-title">Your Score</h3>
							<p class="big-score yes-no"><?php echo $_GET['ssl'] ?></p>
							<p class="score-description">Do you have a secure website</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Industry Average</h3>
							<p class="big-score">73.4%</p>
							<p class="score-description">Have a secure website</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Prior Year Stats</h3>
							<p class="small-score">2018: 44.6%</p>
							<p class="small-score">2017: 3.9%</p>
						</div>
						<div class="benchmark-data-box last-benchmark-data-box">
							<h3 class="box-title">Industry Notes</h3>
							<p class="score-description">The industry saw a 65% growth over last year and an incredible 1782% growth over the past two years. 100% of iVET360 clients have a secure website.</p>
						</div>
					</div>
					<div class="hover-text">
						<h3>The What:</h3>
						<p>The breakdown for website security is simple—hyperlinks on safe pages begin with “https,” while unsafe pages begin with “http.” To make it easier to remember, think of the extra “s” in https pages as standing for “secure.”</p>
						<p>If your website is encrypted, it is guaranteed as safe for people to visit without fear of being attacked by viruses. If it’s not encrypted, the floodgates of are left open, leaving visitors vulnerable to online hackers who can access their personal information.</p>
						<p>To help the general public determine whether or not they should venture onto an unfamiliar site, <a href="https://www.blog.google/products/chrome/milestone-chrome-security-marking-http-not-secure/" target="_blank">Google has placed a “Not Secure” warning</a> on the left side of the address bar whenever the user enters an unencrypted site. This was done in an effort to make the internet safer by somewhat shaming those websites that have not put the privacy of their visitors first.</p>
						<p>As you can imagine, this distinction could seriously hurt your client growth and retention as a hospital if you have not taken the extra step of having your website encrypted. Not only will the visitor avoid entering any information (whether in a comment box or appointment portal) on your hospital’s site, they may also conclude that you or your marketing provider does not care for the safety or wellbeing of others—and how could they trust you with their pet if that’s the case?</p>
						<h3>The Why:</h3>
						<p>While our numbers show a dramatic increase in secure websites for the third year in a row, there are still a decent number of hospitals who have not taken the important step of encrypting their website. Thankfully, major website providers in the industry have begun adding the SSL certificate on their client’s sites—without charging an extra fee. While this is likely a response to competition from free services, it is also a major contributor to a growth of over 65 percent from last year.</p>
						<h3>The How:</h3>
						<p><b>How to check if your website is secure:</b> Pull up your veterinary hospital’s website. Check the address bar of your browser to see if there is a lock symbol in front of your domain name. This will be present on all major browsers, including Chrome, Firefox and Safari. If there is a lock symbol, your website is secure. If there is not a lock symbol, or if you see the words “Not Secure” preceding your hyperlink, your website is not secure.</p>
						<p><b>How To Fix This:</b> <a href="https://www.blog.google/products/chrome/milestone-chrome-security-marking-http-not-secure/" target="_blank">Read our article here on all things SSL</a>.</p>
					</div>
				</div>
			</div>


			<div id="seo">
				<div class="data-set fade-element">
					<div class="data-title">
						<h2 class="website-title">SEARCH ENGINE OPTIMIZATION (SEO)</h2>
						<div class="more-info">
							<p>Learn More</p>
							<i class="far fa-question-circle"></i>
						</div>
					</div>
					<div class="data-row main-row">
						<div class="benchmark-data-box">
							<h3 class="box-title">Your Score</h3>
							<p class="big-score yes-no"><?php echo $_GET['seo'] ?></p>
							<p class="score-description">Is your SEO optimized</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Industry Average</h3>
							<p class="big-score">18.5%</p>
							<p class="score-description">Have an SEO optimized website</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Prior Year Stats</h3>
							<p class="small-score">2018: 17.5%</p>
							<p class="small-score">2017: 36.7%</p>
						</div>
						<div class="benchmark-data-box last-benchmark-data-box">
							<h3 class="box-title">Industry Notes</h3>
							<p class="score-description">The industry saw a 6% growth over last year, but this is part of an overall 50% decline over the past two years. 100% of iVET360 clients have optimized SEO.</p>
						</div>
					</div>
					<div class="hover-text">
						<h3>The What:</h3>
						<p>If your website’s SEO is optimized, your page has been set up for maximum visibility based on search results. For this study, we break down our results based on some simple criteria—have you set up 100 percent of your title tags*, and have you set up 100 percent of your meta descriptions**? On top of this, are these title tags and meta descriptions unique?</p>
						<p>Often, even if some of your website’s pages have the SEO configured, some marketing providers will forget to add it to new content or blog posts. Even those that do may choose to reuse a title tag and meta description for every page on a website, which does very little to help a page.</p>
						<p>A good metaphor for SEO would be a house that has been built and has a brilliant interior layout and decor but lacks proper siding and is completely hidden from the road by a copse of trees. On the inside, things are up to date, but without the curb appeal, no one will give notice to the site, especially not search engines. Proper SEO is the foundation for effective marketing, and if your veterinary website is struggling to rank on Google, this will undoubtedly affect your visibility and client count.</p>
						<p><i>*Title tags—technically “title elements”—define the title of a document. They are often used on search engine results pages (SERPs) to display preview snippets for a given web page, making them important for both SEO and social sharing</i></p>
						<p><i>**Meta descriptions are HTML attributes that provide concise explanations of the contents of web pages. The meta description tag serves as advertisement for copy, drawing readers to a website from the SERP, making it an extremely important part of search marketing.</i></p>
						<h3>The Why:</h3>
						<p>One major reason for the continued decline in the industry’s SEO optimization is the increased use of free platforms such as Wix or Weebly. With these sites, it is incredibly hard, if not impossible, to input unique SEO modifications, which creates a major pitfall and reveals the quality of sites built with these platforms.</p>
						<h3>The How:</h3>
						<p>This one is a bit more challenging, as you have to download a program to review these stats. Screaming Frog is our go-to for running tests like this—it’s a free tool you can use to review the backend of your website, including SEO. You can download it here: <a href="https://www.screamingfrog.co.uk/seo-spider" target="_blank">screamingfrog.co.uk/seo-spider</a>. Once this program is installed, simply type your hospital URL into the search field and let the program do the rest. It will highlight all missing or duplicate titles/descriptions as well as a number of other SEO components.</p>
					</div>
				</div>
			</div>

			<div id="google-analytics">
				<div class="data-set fade-element">
					<div class="data-title">
						<h2 class="website-title">GOOGLE ANALYTICS</h2>
						<div class="more-info">
							<p>Learn More</p>
							<i class="far fa-question-circle"></i>
						</div>
					</div>
					<div class="data-row main-row">
						<div class="benchmark-data-box">
							<h3 class="box-title">Your Score</h3>
							<p class="big-score yes-no"><?php echo $_GET['analytics'] ?></p>
							<p class="score-description">Do you have Google Analytics installed</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Industry Average</h3>
							<p class="big-score">83.2%</p>
							<p class="score-description">Have Google Analytics installed</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Prior Year Stats</h3>
							<p class="small-score">2018: 77.9%</p>
							<p class="small-score">2017: 69.7%</p>
						</div>
						<div class="benchmark-data-box last-benchmark-data-box">
							<h3 class="box-title">Industry Notes</h3>
							<p class="score-description">The industry saw a 7% growth in installations over last year and a growth of 19% over the past two years. 100% of iVET360 clients utilize Google Analytics.</p>
						</div>
					</div>
					<div class="hover-text">
						<h3>The What:</h3>
						<p>Having Google Analytics installed on your website gives you access to more information than you may have believed possible. Want to know how many people are viewing your site? How far down the page those people are typically scrolling? What they searched to get to your website in the first place? Or what the most popular or time-greedy page on your website is? Just ask Google Analytics!</p>
						<p>With the data you receive from Google Analytics, you can create a more pointed and intentional marketing plan that responds to the places of your website that are getting more or less traffic than you’d prefer. This is a much more efficient and cost-effective plan than projecting out and basically guessing at what people’s eyes will tend toward (whether that be colors, images or even turns of phrase.</p>
						<h3>The Why:</h3>
						<p>Every single website should have Google Analytics installed, and while there continues to be a slow increase, we still see only 83 percent of the industry utilizing this vital—and free—tool. Without GA, your marketing plan is aimless; wandering and left to chance.</p>
						<h3>The How:</h3>
						<p><b>How to check if you have Google Analytics on your website:</b> There are a number of ways to check this:</p>
						<ul>
							<li><b>Option one:</b> visit <a href="https://analytics.google.com/analytics/web/" target="_blank">https://analytics.google.com/</a> and log into your Google account. You’ll see the domains for which you control Google Analytics. If your website was built by a third party, though, they will most likely have access.</li>
							<li><b>Option two:</b> while on your website, the keyboard shortcut is Command + U (or CTRL +U on PC). For Chrome, navigate to “View” and then click on “Developer” and then “View Source.” While reviewing the code, search for “UA” on the page. If you see something along the lines of “UA-45947023-1” then you’re set. If nothing comes up, you’re probably not tracking website visitors.</li>
						</ul>
						<p><b>How to fix this:</b> <a href="https://support.google.com/analytics/answer/1008015?hl=en" target="_blank">Google provides a step-by-step guide here</a>.</p>
					</div>
				</div>
			</div>

			<div id="ada">
				<div class="data-set fade-element">
					<div class="data-title">
						<h2 class="website-title">ADA ACCESSIBILITY</h2>
						<div class="more-info">
							<p>Learn More</p>
							<i class="far fa-question-circle"></i>
						</div>
					</div>
					<div class="data-row main-row">
						<div class="benchmark-data-box">
							<h3 class="box-title">Your Score</h3>
							<p class="big-score yes-no"><?php echo $_GET['ada'] ?></p>
							<p class="score-description">Do you have a ADA compliant website</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Industry Average</h3>
							<p class="big-score">46.6%</p>
							<p class="score-description">Have an ADA compliant website</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Prior Year Stats</h3>
							<p class="small-score">2018: N/A</p>
							<p class="small-score">2017: N/A</p>
						</div>
						<div class="benchmark-data-box last-benchmark-data-box">
							<h3 class="box-title">Industry Notes</h3>
							<p class="score-description">100% of iVET360 clients have complete ADA Compliance on their websites. </p>
						</div>
					</div>
					<div class="hover-text">
						<h3>The What:</h3>
						<p>The Americans with Disabilities Act (ADA) is a civil rights law that prohibits discrimination (intentional or not) against people with disabilities in all areas of public life, ensuring equal opportunity. Because this act was signed in 1990, before the advent of the internet, the rules of how it should apply to publicly-accessed websites have been rather up in the air. There has been a lot of discussion on the topic in the veterinary industry, but the bottom line is that digital accessibility is an absolute necessity.</p>
						<p>The benefits of building a website following ADA guidelines are greater than just meeting the law in every area of your practice. By making your site accessible, you are allowing more people to access the information on your website, and to do so with increased ease. Showing the public that you are aware of differences in ability and functionality could also be a good representation of how well you’ll care for their pets. </p>
						<p>Beyond ADA compliance, which covers basic functions like alternative text for images, we created the metric with complete accessibility in mind, a distinction which is often missed. For example, your site should be able to flip its content to be accessible to multiple audiences. Currently, less than half of websites in the industry are accessible and ADA compliant, which is a sad percentage considering the heart of the industry is helping people and their pets, some of which may be service animals that aid in accessibility themselves.</p>
						<h3>The How:</h3>
						<p><b>How to check if your website is ADA compliant:</b> Run your website through this free online tool at <a href="https://info.user1st.com/ada-website-compliance-checker?" target="_blank">info.user1st.com/ada-website-compliance-checker</a>.</p>
					</div>
				</div>
			</div>

			<div id="web-speed">
				<div class="data-set last-data-set fade-element">
					<div class="data-title">
						<h2 class="website-title">WEBSITE PAGE SPEED</h2>
						<div class="more-info">
							<p>Learn More</p>
							<i class="far fa-question-circle"></i>
						</div>
					</div>
					<div class="data-row main-row">
						<div class="benchmark-data-box">
							<h3 class="box-title">Your Score</h3>
							<div class="two-score-box">
								<p class="medium-score inputted-number"><?php echo $_GET['4g'] ?> Seconds</p>
								<p class="score-description">Your website load time (4G)</p>
							</div>
							<div class="two-score-box">
								<p class="medium-score inputted-number"><?php echo $_GET['3g'] ?> Seconds</p>
								<p class="score-description">Your website load time (3G)</p>
							</div>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Industry Average</h3>
							<div class="two-score-box">
								<p class="medium-score industry-avg">3.9 Seconds</p>
								<p class="score-description">Average website load time (4G)</p>
							</div>
							<div class="two-score-box">
								<p class="medium-score industry-avg">8.2 Seconds</p>
								<p class="score-description">Average website load time (3G)</p>
							</div>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Prior Year Stats</h3>
							<p class="small-score">2018: 8.6 Secs. (3G)</p>
							<p class="small-score">2017: 6.7 Secs. (3G)</p>
						</div>
						<div class="benchmark-data-box last-benchmark-data-box">
							<h3 class="box-title">Industry Notes</h3>
							<p class="score-description">Industry websites have sped up by 5% over last year, but they are still 23% slower than they were two years ago. The speed of iVET360 clients websites is 2.9 seconds (4G).</p>
						</div>
					</div>
					<div class="hover-text">
						<h3>The What:</h3>
						<p>Site speed is a metric that Google takes into account when deciding whose websites to feature on the SERP. This year, they altered their algorithm, which
						prioritizes the speed of a site on mobile devices over desktop—a speed they’d still like to be under 2 seconds. Theoretically, this is a good thing, because Google
						wants users to be able to get into a site securely and efficiently. You just need to make sure your website speed is at least on the faster side of the average for
						veterinary hospitals so that your competitors don’t start out-ranking you on Google.</p>
						<p>For 4G, the veterinary industry is currently sitting at an average loading speed of just under 4 seconds—and it’s been found that by that time, 24 percent of
						potential visitors have grown impatient and left the site.</p>
						<p>Data-consuming images are a large reason why the veterinary industry isn’t up to Google’s standard. People want a visual of how well their dog is going to be cared for. While this isn’t entirely a bad thing—we too love endless puppy videos—it’s important to cater to what clients want to see on your website without forcing them to wait so long for a high-def cat GIF that they end up leaving your site to find another vet in the area.</p>
						<h3>The Why:</h3>
						<p>In their effort to prioritize mobile site speed, Google has updated the tool we use for this metric to measure speed at 4G as well as 3G, as much of the population relies on the former when using mobile devices. While moving forward, we will focus on the 4G data as well, it’s still important to note that there was a small increase in 3G speed (or a decrease in seconds) since last year. While still much slower than the 2017 statistics, this is definitely a step in the right direction, especially considering 4G speed tends to be about twice as fast as 3G. A major factor to this increase in speed is the site theme and server upgrades that a major industry provider did in 2019. It is likely other major providers will follow suit in the coming years.</p>
						<h3>The How:</h3>
						<p><b>How to check your site:</b> You can test your site here: <a href="https://www.thinkwithgoogle.com/feature/testmysite/" target="_blank">thinkwithgoogle.com/feature/testmysite</a>.</p>
						<p><b>How to fix this:</b> Once you test your site speed, Google will provide a detailed report on how to fix the issues that are slowing down your site as well as providing a link to share with your current webmaster. The best part, like with most things Google, is that it’s free.</p>
					</div>
				</div>
			</div>

		</div>

		<div class="data-section" id="google-report">
			<div class="divider-box google-divider">
				<i class="fas fa-dot-circle"></i>
				<div class="divider"></div>
			</div>
			<div class="section-title fade-element">
				<h1>Google My Business</h1>
				<img src="/wp-content/uploads/2019/11/gmb-vmbr.png" alt="Google Icon">
			</div>
			<div class="section-description fade-element">
				<p>As the most relied-upon search engine, Google has a deep and expansive influence. There are so many different websites and pages that advertise similar things, though, that it’s important to let Google know you matter to the public and belong in their search results. The best way to do this is with the Google My Business Knowledge Panel, which can be thought of as a mini website that pops up after a search is made, which gives Google searchers an idea of what your hospital is, how you operate and why they should bring their beloved pet to you instead of anyone else. From answering questions to keeping updated business hours, Google’s broad-stroke feature lets you communicate directly to your clients using this.</p>
				<p>The Knowledge Panel is absolutely necessary, in this day and age, to not only maintain your veterinary hospital’s presence but to maximize your clientele and, ultimately, maximize your revenue as well. We’ve included below the different aspects of this profile that Google takes into account and which you should as well if your want the best online traffic and visibility possible.</p>
			</div>

			<div id="google-reviews">
				<div class="data-set fade-element">
					<div class="data-title">
						<h2 class="google-title">GOOGLE REVIEWS</h2>
						<div class="more-info">
							<p>Learn More</p>
							<i class="far fa-question-circle"></i>
						</div>
					</div>
					<div class="data-row main-row">
						<div class="benchmark-data-box">
							<h3 class="box-title">Your Score</h3>
							<p class="big-score inputted-number"><?php echo $_GET['g_reviews'] ?></p>
							<p class="score-description">Number of reviews on Google</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Industry Average</h3>
							<p class="big-score industry-avg">115</p>
							<p class="score-description">Google reviews for the average veterinary hospital</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Prior Year Stats</h3>
							<p class="small-score">2018: 73</p>
							<p class="small-score">2017: 40</p>
						</div>
						<div class="benchmark-data-box last-benchmark-data-box">
							<h3 class="box-title">Industry Notes</h3>
							<p class="score-description">The industry saw a 57% increase over last year, part of a promising 187% increase over the past two years. iVET360 clients average at 125 reviews.</p>
						</div>
					</div>
					<div class="hover-text">
						<h3>The What:</h3>
						<p>Reviews matter for so many reasons. They give you a good idea of how your clients see your services, and they give potential clients a first-hand look at the care their pet will receive at your hospital. Google Reviews also play a major role in where your business is located on the Google search results page.</p>
						<p>Google Reviews are the first thing that show up under the name of your hospital in the Google Knowledge Panel. The more reviews you have, and the higher the average number of stars, the more likely you are to appear more attractive to potential patrons, and Google knows that. It’s easier to trust the quality of a veterinary hospital that 40 people agreed deserved 4.6 stars than one that 6 people agreed should have the full 5.0 stars, and while Google’s algorithm for search results is rather complicated, it is this that is taken into account more than anything—along with proximity to the person searching.</p>
						<p>That being said, if the veterinarian with only 6 Google Reviews is only five miles away, it will be placed after the practice that has 40 reviews, yet is 10 miles away.</p>
						<p>The good news is, local pet-owning communities are becoming more involved and leaving veterinary hospitals more reviews. In fact, the average practice received 3.5 new reviews every month during 2019. That may not seem like much, but from our data, it sings to the tune of 57 percent growth over last year. As a whole, too, Google continues to lead the pack of business listing services in average number of reviews; this makes sense, considering it’s the first thing your client sees when they Google “vet near me.”</p>
						<h3>The How:</h3>
						<p><b>How to gain more Google reviews:</b> Ask your clients. Your hospital sees 10s to 100s of people every day, and a simple request to review your services goes a long way in growing your online reviews.</p>
					</div>
				</div>
			</div>

			<div id="google-ads">
				<div class="data-set fade-element">
					<div class="data-title">
						<h2 class="google-title">GOOGLE ADS (FORMERLY ADWORDS)</h2>
						<div class="more-info">
							<p>Learn More</p>
							<i class="far fa-question-circle"></i>
						</div>
					</div>
					<div class="data-row main-row">
						<div class="benchmark-data-box">
							<h3 class="box-title">Your Score</h3>
							<p class="big-score yes-no"><?php echo $_GET['g_ads'] ?></p>
							<p class="score-description">Are you using Google Ads</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Industry Average</h3>
							<p class="big-score">11.8%</p>
							<p class="score-description">Of hospitals are utilizing Google Ads</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Prior Year Stats</h3>
							<p class="small-score">2018: 10.7%</p>
							<p class="small-score">2017: N/A</p>
						</div>
						<div class="benchmark-data-box last-benchmark-data-box">
							<h3 class="box-title">Industry Notes</h3>
							<p class="score-description">The industry saw a 10% growth over last year’s first data collection. 96% of iVET360 clients utilize Google Ads.</p>
						</div>
					</div>
					<div class="hover-text">
						<h3>The What:</h3>
						<p>Much like a chain bookstore where the books near the front are more likely to be sponsored rather than organized to be set there, when you search the web for a veterinary hospital, the frontmost results are more likely to be practices that paid Google for preference so that pet owners would be able to find their site easier without having to browse shelf after shelf of similar domains. These hospitals have wisely chosen make use of a service called Google Ads, which has constantly been proven to be successful in the veterinary industry.</p>
						<p>Google Ads has a surprisingly large learning curve. They want to make sure that the content they are promoting doesn’t look like it was written by a second grader—which is fair—so they created an online course outlining the details of this service. Individuals who complete the course are designated as “Google Ads Certified.” A small business may try to navigate the world of Google Ads for the first time by themselves, but we very much warn against this. Oftentimes, the hospitals that choose the DIY path end up giving up by the end.</p>
						<p>In 2018, the Veterinary Hospital Managers Association (VHMA) revealed that new clients are down 13 percent in the veterinary industry, which is even greater than the 9 percent decline seen at this time last year—however, hospitals that are utilizing Google Ads have continued to increase their clientele. Our data has also revealed that the discrepancy in client growth/loss is entirely attributed to successful implementation of Google Ads. So, if your hospital is not using this service, you need to only look at the numbers to show you how valuable it really is.</p>
						<h3>The Why:</h3>
						<p>Hospitals that utilize Google Ads saw a 19 percent increase in number of reviews over those that did not. For iVET360 clients in particular, Google Ads are currently the leading contributor to new client generation.</p>
						<h3>The How:</h3>
						<p><b>How to set up Google Ads:</b> We recommend your veterinary hospital finds a <a href="https://www.google.com/partners/about/" target="_blank">Google Certified Partner</a>. But if you’d like to venture out on your own, <a href="https://ads.google.com/home/resources/how-to-setup-googleads-a-checklist/" target="_blank">Google has provided this checklist to help</a>.</p>
						<p>Google also offers AdWords Express, which has solutions for every business. Google’s advertising technology will optimize your ad to help you accomplish specific goals. Despite being fairly easy to set up, it’s likely you still won’t see the same results as working with a marketing professional.</p>
					</div>
				</div>
			</div>

			<div id="gmb-claimed">
				<div class="data-set fade-element">
					<div class="data-title">
						<h2 class="google-title">GMB CLAIMED</h2>
						<div class="more-info">
							<p>Learn More</p>
							<i class="far fa-question-circle"></i>
						</div>
					</div>
					<div class="data-row main-row">
						<div class="benchmark-data-box">
							<h3 class="box-title">Your Score</h3>
							<p class="big-score yes-no"><?php echo $_GET['gmb_verified'] ?></p>
							<p class="score-description">Have you claimed your GMB listing</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Industry Average</h3>
							<p class="big-score">92.5%</p>
							<p class="score-description">Of hospitals have claimed their GMB listing</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Prior Year Stats</h3>
							<p class="small-score">2018: 91.7%</p>
							<p class="small-score">2017: 90.8%</p>
						</div>
						<div class="benchmark-data-box last-benchmark-data-box">
							<h3 class="box-title">Industry Notes</h3>
							<p class="score-description">The industry saw a slight 1% growth over last year, evening growth to just 2% over the past two years. 100% of iVET360 clients are verified on GMB.</p>
						</div>
					</div>
					<div class="hover-text">
						<h3>The What:</h3>
						<p>By verifying your practice with Google My Business, you gain control of how your information appears on Google—this includes your hours, phone number, photos and more. As long as you are a representative of your hospital, you can verify—or “claim”—your listing.</p>
						<p>Depending on your eligibility, there are several ways you can be verified, such as a phone call, email, snail mail or through immediate verification. There’s no reason a practice should not be verified on Google, and thankfully the percentage of practices who are has continued its slow growth.</p>
						<p>With unverified practices that have not updated their Google listing, information as elementary as their holiday hours are often inaccurate online. This is where you will see Google stating, “These hours may vary depending on holidays.” With a verified Google listing, you can edit your hours and let clients know what your holiday hours or closures may be, instead of leaving them—and Google—guessing. You can also add a bunch of new features for clients that we will describe more in-depth later in this report.</p>
						<h3>The How:</h3>
						<p><b>How to verify your Google listing:</b> If your hospital is eligible to be verified by phone, you’ll see the “Verify by phone” option when you request verification. From there, sign in to Google My Business and click “Verify now.” Google will then call your hospital and give you a verification code. Now enter the code from the message.</p>
						<p>If you’re eligible to be verified by email, first make sure you can access the email address shown in the verification screen. Now go to Google My Business and click “Verify now” then click “Email” from the list of verification options. You will then be sent an email, which contains the “Verify” button.</p>
						<p>To verify your business listing by snail mail, sign in to Google My Business. On the postcard request screen, check if your address is correct. If it isn’t, edit the address before requesting your letter. Now click “Send postcard.” Check the mail for your postcard, which should arrive within 14 days. This postcard will contain a Google Verification code. On your Google My Business account, click the “Verify now” button, then enter your code in the code field.</p>
					</div>
				</div>
			</div>

			<div id="gmb-appt">
				<div class="data-set fade-element">
					<div class="data-title">
						<h2 class="google-title">GMB APPOINTMENT LINK</h2>
						<div class="more-info">
							<p>Learn More</p>
							<i class="far fa-question-circle"></i>
						</div>
					</div>
					<div class="data-row main-row">
						<div class="benchmark-data-box">
							<h3 class="box-title">Your Score</h3>
							<p class="big-score yes-no"><?php echo $_GET['gmb_appt'] ?></p>
							<p class="score-description">Do you have a GMB appointment link</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Industry Average</h3>
							<p class="big-score">22.6%</p>
							<p class="score-description">Of hospitals have a GMB appointment link</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Prior Year Stats</h3>
							<p class="small-score">2018: 14.7%</p>
							<p class="small-score">2017: N/A</p>
						</div>
						<div class="benchmark-data-box last-benchmark-data-box">
							<h3 class="box-title">Industry Notes</h3>
							<p class="score-description">The industry saw 54% more hospitals using the appointment link over last year. 100% of iVET360 clients utilize this tool.</p>
						</div>
					</div>
					<div class="hover-text">
						<h3>The What:</h3>
						<p>The goal of your Google Knowledge Panel is for it to be so chock full of genuine information about your practice that clients would feel comfortable making an appointment then and there. Thankfully, there’s a feature right in your Knowledge Panel specifically for that purpose! This appointment link is not available for all businesses, so consider yourself lucky that the entire veterinary industry gets to keep this efficient little button in the same area as the map, phone number and hours of your hospital.</p>
						<p>Consumers like having multiple options to get in contact with the services they’ll be partaking in (or that their animals will be). This is especially true for people who are searching for a veterinary hospital using a mobile device. In fact, according to Google, 68 percent of consumers value the option to either call a business or interact with them online while using their smartphone, and we at iVET360 can only see this percentage going up as the handheld device becomes more and more functional for tasks that are usually saved for a laptop or desktop computer. Adding the appointment link is a step toward that functionality, making it much easier for people on the go to schedule a visit for their pet.</p>
						<p>As hospitals are devoting more time to their Google My Business profiles, free opportunities such as the appointment link are surfacing, as well as the benefits of these simple solutions. This would account in great measure for the 54 percent increase in veterinary hospitals making use of this free and convenient feature.</p>
						<h3>The Why:</h3>
						<p>Hospitals that have set up their appointment link also saw a 4 percent increase in number of reviews over those that have not. We also found that adding the appointment link <a href="https://ivet360.com/gmb-appointment-links/" target="_blank">drove 15 percent of the clicks on a business listing</a>, equaling more booked appointments.</p>
						<h3>The How:</h3>
						<p><b>How to add an appointment link:</b> Sign in to your Google My Business account and then choose the “My Business” listing. Then click on the URLs section, which should show you fields for relevant links that you will want to add, and add an appointment link to the correct field.</p>
					</div>
				</div>
			</div>

			<div id="gmb-description">
				<div class="data-set fade-element">
					<div class="data-title">
						<h2 class="google-title">GMB DESCRIPTION</h2>
						<div class="more-info">
							<p>Learn More</p>
							<i class="far fa-question-circle"></i>
						</div>
					</div>
					<div class="data-row main-row">
						<div class="benchmark-data-box">
							<h3 class="box-title">Your Score</h3>
							<p class="big-score yes-no"><?php echo $_GET['gmb_desc'] ?></p>
							<p class="score-description">Do you have a GMB Description</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Industry Average</h3>
							<p class="big-score">35.6%</p>
							<p class="score-description">Of hospitals have a GMB description</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Prior Year Stats</h3>
							<p class="small-score">2018: 12.7%</p>
							<p class="small-score">2017: N/A</p>
						</div>
						<div class="benchmark-data-box last-benchmark-data-box">
							<h3 class="box-title">Industry Notes</h3>
							<p class="score-description">The industry saw a solid 180% increase in hospitals with this description. 100% of iVET360 clients have their description on the Google My Business listing.</p>
						</div>
					</div>
					<div class="hover-text">
						<h3>The What:</h3>
						<p>A description of your practice is an easy thing to create as a person who’s intimately familiar with their hospital, but just because it’s easy doesn’t mean it isn’t effective. Google has an optional section at the bottom of your hospital’s Knowledge Panel that allows you to use up to 750 characters talking about your practice in anyway you choose—this is the Google My Business Description. If you don’t want to add a general overview of your practice, you can include your mission statement, more information about your doctors or really anything else you see fit! </p>
						<p>Your Google Description is worth an entire 15 percent of your profile when Google is calculating how complete your hospital’s profile is. This is big, considering the less complete a profile is, the lower your practice’s search listing is ranked. This means it won’t show up in internet searches as often as those that have a more fleshed out profile.</p>
						<p>If you don’t see the option to add a description on your Google My Business page, it’s possible your business is inappropriately categorized within Google My Business. This can often be rectified by simply reducing the number of categories your hospital is claiming to be under. Keeping the category to the most accurate will remove any confusion Google may have about your business, and the Google Description feature should become available.</p>
						<h3>The Why:</h3>
						<p>Hospitals that have a Google Description also saw a 10 percent increase in the number of reviews over those that did not.</p>
						<h3>The How:</h3>
						<p><b>How to add a Google My Business description:</b> Log in to your Google My Business account, click on the “Info” button on the menu bar and look for a section labeled “Add business description.” Click on the pencil icon next to that field, which will bring up a menu that will let you enter a brief description of your business.</p>
					</div>
				</div>
			</div>

			<div id="gmb-short">
				<div class="data-set fade-element">
					<div class="data-title">
						<h2 class="google-title">GOOGLE SHORT NAME</h2>
						<div class="more-info">
							<p>Learn More</p>
							<i class="far fa-question-circle"></i>
						</div>
					</div>
					<div class="data-row main-row">
						<div class="benchmark-data-box">
							<h3 class="box-title">Your Score</h3>
							<p class="big-score yes-no"><?php echo $_GET['gmb_short'] ?></p>
							<p class="score-description">Do you have a GMB Short Name</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Industry Average</h3>
							<p class="big-score">8.3%</p>
							<p class="score-description">Of hospitals have a Google Short Name</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Prior Year Stats</h3>
							<p class="small-score">2018: N/A</p>
							<p class="small-score">2017: N/A</p>
						</div>
						<div class="benchmark-data-box last-benchmark-data-box">
							<h3 class="box-title">Industry Notes</h3>
							<p class="score-description">100% of iVET360 clients have a short name to their Google Knowledge Panels.</p>
						</div>
					</div>
					<div class="hover-text">
						<h3>The What:</h3>
						<p>We’ve already talked quite a bit about the Google Knowledge Panel, home to your business’s Google Reviews, Appointment Link, Questions and Answers, Posts, Offers and Description, on top of the more basic contact, location and website information. In order to fully complete your Google My Business Profile, though, you need to have claimed a Google Short Name, which will direct current and prospective clients straight to this Google Knowledge Panel, where they can then take part in Offers, ask Questions and see this amalgamation of great information you’ve compiled for them.</p>
						<p>The Short Name is a unique, simplified URL that can easily be recalled, and therefore easily shared. The key here is to claim your Google Short Name ASAP, before another business with a similar name, wherever they may be around the world, takes yours out from under you. As of right now, the URL for your Knowledge Panel is an unnecessarily long string of letters and numbers, like a code that needs cracking. To be more accessible and visible, it is pertinent that you go into your Google My Business Profile and change it to one that starts with “g.page/” and ends with the name of your hospital or some adaptation of it that fits within the 32 character limit—with nothing in between.</p>
						<p>An example of a Google Short Name would be “g.page/CityVet/”</p>
						<h3>The Why:</h3>
						<p>Hospitals that have a Google Short Name also saw a 14 percent increase in number of reviews over those that did not.</p>
						<h3>The How:</h3>
						<p><b>How to claim a Google Short Name:</b> If you’re on a computer, sign in to your Google My Business account, then open the location that you want to create a Short Name for. From the menu, click “Info” and then “Add profile Short Name”. Now you can enter your Short Name (If your name isn’t available, it will prompt you to choose a different name.) and click “Apply.” Your Short Name will show as pending at first, but it’ll eventually show up on your Business Profile when it’s ready.</p>
						<p>If you’re on a mobile device, you’ll first need the Google My Business app. Once you have that, open it and click on “My Business.” Next, tap “Profile” and “Add profile Short Name.” This is where you can enter your desired Google Short Name before pressing “Save.” Just as with the computer method, your Short Name will show as pending at first, but will eventually show up on your Business Profile when it’s ready.</p>
					</div>
				</div>
			</div>

			<div id="gmb-posts">
				<div class="data-set fade-element">
					<div class="data-title">
						<h2 class="google-title">GMB POSTS</h2>
						<div class="more-info">
							<p>Learn More</p>
							<i class="far fa-question-circle"></i>
						</div>
					</div>
					<div class="data-row main-row">
						<div class="benchmark-data-box">
							<h3 class="box-title">Your Score</h3>
							<p class="big-score yes-no"><?php echo $_GET['gmb_posts'] ?></p>
							<p class="score-description">Are you utilizing Google Posts</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Industry Average</h3>
							<p class="big-score">21%</p>
							<p class="score-description">Are utilizing Google My Business Posts</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Prior Year Stats</h3>
							<p class="small-score">2018: 10.2%</p>
							<p class="small-score">2017: 1.7%</p>
						</div>
						<div class="benchmark-data-box last-benchmark-data-box">
							<h3 class="box-title">Industry Notes</h3>
							<p class="score-description">With a growth of 106% over last year, the industry has increased its use of Google Posts by a whopping 1135% over the past two years. 68.5% of iVET360 clients make use of this tool.</p>
						</div>
					</div>
					<div class="hover-text">
						<h3>The What:</h3>
						<p>Google Posts are a great way to share content with people searching for your hospital. The posts are situated within your Google Knowledge Panel and, in addition to the space for up to 300 words of content, they can include an image and a link with a call to action. This link could send viewers to a blog post, appointment form or contact page among other destinations, and allows Google Posts to work as a strong marketing tool worth having on hand.</p>
						<p>For example, if somebody had heard about your hospital, but they weren’t sure if they wanted to make an appointment, you could use a Google Post to share your “Free First Exam” offer with them and provide a link to your website. For them, this simplifies the process of scheduling an appointment, while also providing incentive to do so, and to choose your hospital in particular.</p>
						<p>In this way, Google Posts are a way for practices to stand out from the competition—when a client is looking through a listing of hospitals and sees a practice with an offer and a practice without an offer, the client is likely to make their appointment with the former. Plus, Google itself will reward the business that chooses to utilize their free tools, meaning your practice will actually be more readily found when prospective clients are searching for a new veterinary hospital in their area.</p>
						<p>If it isn’t intuitive that visibility makes a business money, the fact that the use of Google Posts has grown by 1200 percent over the past two years should be evidence enough. People are noticing the benefits of posting straight to their Google Knowledge Panel, and it’s worth jumping on the trend now while only 21 percent of the industry is participating in this growth strategy.</p>
						<h3>The Why:</h3>
						<p>Hospitals that utilize Google Posts also saw a 10 percent increase in the number of reviews over those that did not.</p>
						<h3>The How:</h3>
						<p><b>How to create a Google Post:</b> Sign in to your Google My Business account. Click “Create post,” or click “Posts” from the menu. On the “Create post” screen, choose which type of post you’d like to create based on the available options, then enter any relevant information. Click “Preview” to see a preview of your post and, if you’re happy with it, click “Publish” in the top right corner of the screen.</p>
					</div>
				</div>
			</div>

			<div id="gmb-offers">
				<div class="data-set fade-element">
					<div class="data-title">
						<h2 class="google-title">GMB OFFERS</h2>
						<div class="more-info">
							<p>Learn More</p>
							<i class="far fa-question-circle"></i>
						</div>
					</div>
					<div class="data-row main-row">
						<div class="benchmark-data-box">
							<h3 class="box-title">Your Score</h3>
							<p class="big-score yes-no"><?php echo $_GET['gmb_offers'] ?></p>
							<p class="score-description">Are you utilizing Google Offers</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Industry Average</h3>
							<p class="big-score">3.4%</p>
							<p class="score-description">Are utilizing Google My Business offers</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Prior Year Stats</h3>
							<p class="small-score">2018: N/A</p>
							<p class="small-score">2017: N/A</p>
						</div>
						<div class="benchmark-data-box last-benchmark-data-box">
							<h3 class="box-title">Industry Notes</h3>
							<p class="score-description">56% of iVET360 clients are utilizing this tool.</p>
						</div>
					</div>
					<div class="hover-text">
						<h3>The What:</h3>
						<p>Google My Business Offers are much like the Posts. In fact, they’re really a subset of this effective tool. What makes Google Offers different, though, is where they’re placed, specifically when people are searching for your practice on mobile. Instead of sitting at the bottom of the knowledge panel like the rest of the Google Posts, Offers are positioned right beneath the standard business information (i.e. address, hours, phone number etc.). This is only for mobile devices, however, and the desktop version will sort the Offers down among the Google Posts.</p>
						<p>Google Offers can be used to promote, well, offers to new clients. We typically recommend the somewhat counterintuitive strategy of placing a Free First Exam offer here. These are proven to be quite profitable in the long run, and they are extremely attractive to the pet owner in search of a caring and affordable veterinary hospital.</p>
						<p>Only 3.4 percent of the industry is currently making use of both Google Posts and Google Offers, so we’re hoping you’ll make use of the deficit to increase client growth and engagement. With the incredible amount of time people are spending on their phones instead of laptops or other desk computers, it makes sense to invest in a form of community engagement that is so specifically catered to small products.</p>
						<h3>The Why:</h3>
						<p>Hospitals that have utilized Google Offers also saw a 32 percent increase in number of reviews over those that did not.</p>
						<h3>The How:</h3>
						<p><b>How to create a Google Offer:</b> First, follow the instructions for making a Google Post. Make sure you pick the kind Post that reads “Google Offer” instead of something more simple. When entering information, you’ll be able to add a description of the deal, a coupon code, any terms and conditions that apply to the promo, a phone number and/or a link to a form on their website. We suggest using a tracking number or link here so that you can keep track of how many people contact you simply because of that Offer, thus getting an idea of how effective such a tool would be for your hospital.</p>
					</div>
				</div>
			</div>

			<!-- <div id="gmb-qa">
				<div class="data-set last-data-set fade-element">
					<div class="data-title">
						<h2 class="google-title">GMB QUESTIONS & ANSWERS</h2>
						<div class="more-info">
							<p>Learn More</p>
							<i class="far fa-question-circle"></i>
						</div>
					</div>
					<div class="data-row main-row">
						<div class="benchmark-data-box">
							<h3 class="box-title">Your Score</h3>
							<div class="two-score-box">
								<p class="medium-score yes-no"><?php /* echo $_GET['gmb_qa'] */ ?></p>
								<p class="score-description">Are you using GMB Questions & Answers</p>
							</div>
							<div class="two-score-box">
								<p class="medium-score inputted-number"><?php /* echo $_GET['gmb_biz'] */ ?></p>
								<p class="score-description">Number of GMB questions</p>
							</div>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Industry Average</h3>
							<div class="two-score-box">
								<p class="medium-score">17.1%</p>
								<p class="score-description">Are using GMB Questions & Answers</p>
							</div>
							<div class="two-score-box">
								<p class="medium-score industry-avg">3</p>
								<p class="score-description">Average number of GMB questions</p>
							</div>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Prior Year Stats</h3>
							<p class="small-score">2018: 5.3%</p>
							<p class="small-score">2017: N/A</p>
						</div>
						<div class="benchmark-data-box last-benchmark-data-box">
							<h3 class="box-title">Industry Notes</h3>
							<p class="score-description">The industry saw a serious growth over last year of 223% more hospitals paying attention to Google Questions and Answers. 42.6% of iVET360 clients make use of this feature.</p>
						</div>
					</div>
					<div class="hover-text">
						<h3>The What:</h3>
						<p>Displayed within your Google Knowledge Panel, Google Questions and Answers allows any user to easily ask questions related to your practice. This is a very useful tool for informing and interacting with the public. If ignored or employed improperly, though, this forum-style feature could easily have negative consequences. </p>
						<p>To use Google Q/A as an effective marketing tool, you could populate the section with your own questions and answers—almost like an FAQ. Not only does this get information out faster, it is also a good way to push services or features of your hospital you want the public to be more aware of. For example, if your hospital has avian services, you can submit a question as if it came from a bird owner in the community asking whether or not you do see birds. From there, you can go back in and respond with a strong, marketing-oriented answer to let them know that you do, in fact, treat birds.</p>
						<p>The problem is, if you aren’t actively replying to the questions people leave, anyone else can answer them. This could leave the question askers trusting the wrong parties and the wrong information. By being proactive and answering these questions right away, you can prevent this issue from the get-go, while also making current and potential clients feel valued.</p>
						<p>The spike in Google Q/A metrics comes mainly from the consumer. People are getting more used to using this platform to find answers to their questions. In fact, the average hospital has no less than three questions posted and ready to answer, and people who receive responses are statistically more likely to call the practice to follow up on their questions.</p>
						<h3>The Why:</h3>
						<p>Hospitals that answer Google Q/A also saw a 23 percent increase in number of reviews over those that did not.</p>
						<h3>The How:</h3>
						<p><b>How to manage Google Questions and Answers:</b> Once you’re signed into your Google My Business account, navigate to your Google Knowledge Panel by searching or simply using your Google Short Name. After clicking into “See all questions” under the “Questions and Answers” section, you will be able to reply to questions, ask your own and upvote the accurate and relevant questions and answers about your hospital. </p>
					</div>
				</div>
			</div> -->

		</div>

		<div class="data-section" id="facebook-report">
			<div class="divider-box facebook-divider">
				<i class="fas fa-dot-circle"></i>
				<div class="divider"></div>
			</div>
			<div class="section-title fade-element">
				<h1>Facebook</h1>
				<img src="/wp-content/uploads/2019/11/fb-vmbr.png" alt="Facebook Icon">
			</div>
			<div class="section-description fade-element">
				<p>Facebook: you either love to hate it or you hate to love it. No matter which category you fall under, though, there’s no arguing its overwhelming presence on the internet. It seems that everything goes right back to Facebook these days, so imagine how much traffic your hospital’s Facebook page could get if you made use of the extra features Facebook has set up for you to use.</p>
				<p>The first step to Facebook is creating one for your practice, but that certainly isn’t the last. We’ve outlined some tips and free features that could leave your practice in the best shape possible for today’s social media climate.</p>
			</div>

			<!-- <div id="fb-reviews">
				<div class="data-set fade-element">
					<div class="data-title">
						<h2 class="facebook-title">FACEBOOK REVIEWS</h2>
						<div class="more-info">
							<p>Learn More</p>
							<i class="far fa-question-circle"></i>
						</div>
					</div>
					<div class="data-row main-row">
						<div class="benchmark-data-box">
							<h3 class="box-title">Your Score</h3>
							<p class="big-score inputted-number"><?php /* echo $_GET['fb_reviews'] */ ?></p>
							<p class="score-description">Number of GMB questions</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Industry Average</h3>
							<p class="big-score industry-avg">69</p>
							<p class="score-description">Facebook reviews for the average veterinary hospital</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Prior Year Stats</h3>
							<p class="small-score">2018: 86</p>
							<p class="small-score">2017: 58</p>
						</div>
						<div class="benchmark-data-box last-benchmark-data-box">
							<h3 class="box-title">Industry Notes</h3>
							<p class="score-description">The industry technically saw a 20% decline in reviews over last year, which brought down its two-year increase of 19%. iVET360 clients have an average of 77 reviews on Facebook.</p>
						</div>
					</div>
					<div class="hover-text">
						<h3>The What:</h3>
						<p>Facebook Reviews have gone through a lot of changes over the past three years, making the numbers a bit hard to follow.</p>
						<p>Before 2018, Facebook only allowed users to contribute starred reviews to the pages of local businesses, like your animal hospital. Around mid-May of last year, however, they decided to switch things up by allowing users to comment on their starred reviews. This personalized content was classified as a “recommendation,” and played a role in calculating a “recommendation score” which, according to Facebook, was “based on how many people recommend or don’t recommend the Page, as well as any past ratings and reviews it may have.” This should explain the jump in numbers from 2017 to 2018.</p>
						<p>As of 2019, Facebook reclassified every starred rating as a “recommendation,” saving the word “review” for those recommendations that also include that personal content mentioned earlier (hence the dramatic decrease in what Facebook qualifies as reviews for the industry this year).</p>
						<p>To make this development a little simpler, we’ve included in the metrics both the review and recommendation (see following page) numbers for 2019. This should give a clearer picture of how many review-type interactions Facebook users have had on average with veterinary hospitals around the country.</p>
						<h3>The How:</h3>
						<p><b>How to gain more Facebook reviews:</b> Make your page more visible by following our guidelines on branding and verifying your page. Then respectfully ask your clients to review your hospital.</p>
					</div>
				</div>
			</div> -->
			<?php if ( $_GET['fb_recs'] != null ) { ?>
			<div id="fb-recs">
				<div class="data-set fade-element">
					<div class="data-title">
						<h2 class="facebook-title">FACEBOOK RECOMMENDATIONS</h2>
						<div class="more-info">
							<p>Learn More</p>
							<i class="far fa-question-circle"></i>
						</div>
					</div>
					<div class="data-row main-row">
						<div class="benchmark-data-box">
							<h3 class="box-title">Your Score</h3>
							<p class="big-score inputted-number"><?php echo $_GET['fb_recs'] ?></p>
							<p class="score-description">Number of reviews on Facebook</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Industry Average</h3>
							<p class="big-score industry-avg">155</p>
							<p class="score-description">Facebook recommendations for the average veterinary hospital</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Prior Year Stats</h3>
							<p class="small-score">2018: N/A</p>
							<p class="small-score">2017: N/A</p>
						</div>
						<div class="benchmark-data-box last-benchmark-data-box">
							<h3 class="box-title">Industry Notes</h3>
							<p class="score-description">iVET360 clients average at 133 recommendations per practice.</p>
						</div>
					</div>
					<div class="hover-text">
						<h3>The What:</h3>
						<p>Facebook Recommendations are currently created by users answering a simple yes or no question as to whether they recommend a hospital. If the user in question wants to, they can also leave a “review,” which is more of a written explanation for the recommendation or lack thereof. Together, the binary answers are averaged, with the antiquated starred reviews of previous years taken into account, resulting in a solid “recommendation score.”</p>
						<p>The recommendation score remains the same as it was in 2018 (calculating the average amount of times people do or don’t recommend a practice out of five), but is focused more on the simple opinions Facebook users have shared. This recommendation score is not only in a prominent position on your practice’s Facebook page, but it’s featured on your Google Knowledge Panel as well, showing anyone searching for your hospital just how many other pet owners would vote for your practice as a good place to take their pets.</p>
						<h3>The How:</h3>
						<p><b>How to gain more Facebook Recommendations:</b> Once you have verified your Facebook business page and created a cohesive brand, send your clients to check out the page and ask politely if they wouldn’t mind leaving a recommendation to help show the rest of your community how much you care about veterinary sciences and, more specifically, their pets.</p>
					</div>
				</div>
			</div>
			<?php } ?>
			<div id="fb-un">
				<div class="data-set fade-element">
					<div class="data-title">
						<h2 class="facebook-title">FACEBOOK VANITY URL (USERNAME)</h2>
						<div class="more-info">
							<p>Learn More</p>
							<i class="far fa-question-circle"></i>
						</div>
					</div>
					<div class="data-row main-row">
						<div class="benchmark-data-box">
							<h3 class="box-title">Your Score</h3>
							<p class="big-score yes-no"><?php echo $_GET['fb_vanity'] ?></p>
							<p class="score-description">Do you have a Facebook Vanity URL</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Industry Average</h3>
							<p class="big-score">80.1%</p>
							<p class="score-description">Have a Facebook vanity URL</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Prior Year Stats</h3>
							<p class="small-score">2018: 78.9%</p>
							<p class="small-score">2017: 75.6%</p>
						</div>
						<div class="benchmark-data-box last-benchmark-data-box">
							<h3 class="box-title">Industry Notes</h3>
							<p class="score-description">The industry improved by a slight 2% over the past year, and a full 6% over the past two years. 100% of iVET360 clients have a unique vanity URL for Facebook.</p>
						</div>
					</div>
					<div class="hover-text">
						<h3>The What:</h3>
						<p>A Facebook vanity URL is a customized web address your clients can use to find your Facebook page (much like Google’s new Google My Business Short Name we addressed earlier in the report). When you first create your hospital’s page, Facebook assigns you a randomized URL with lots of numbers attached at the end. By adapting it into a vanity URL, you are simplifying your address into a username, thus making it easier for your clients to find you on Facebook.</p>
						<p>The vanity URL also allows for easier branding of your hospital’s Facebook page with the “@” symbol, meaning your business can be found or tagged within Facebook. For example, at iVET360, the vanity URL of our Facebook page is: facebook.com/ iVET360. Now, in addition to being much less confusing than what it would have been before (something like, facebook.com/pages/iVET360/839408), our URL can be adapted so that anyone could find us on Facebook with @iVET360.</p>
						<p>This is a simple, minimal thing for your practice to do, but it would make a big impact on the ease with which your clients find and communicate with you.</p>
						<h3>The Why:</h3>
						<p>Hospitals that have a vanity URL also saw a 4 percent increase in number of reviews/recommendations over those that did not.</p>
						<h3>The How:</h3>
						<p><b>How to set up a Facebook vanity URL:</b> If you’re an admin of your hospital’s Facebook page, you will see on the left side of the page a button that says “Create Page @Username.” Clicking this, you can enter your desired username/vanity URL, or variations of it until you find one that’s available, and select “Create Username.”</p>
						<p>It’s also important to make sure the URL you’re trying to create adheres to <a href="https://www.facebook.com/help/105399436216001" target="_blank">Facebook’s username guidelines</a>.</p>
					</div>
				</div>
			</div>

			<div id="fb-branding">
				<div class="data-set fade-element">
					<div class="data-title">
						<h2 class="facebook-title">FACEBOOK BRANDING</h2>
						<div class="more-info">
							<p>Learn More</p>
							<i class="far fa-question-circle"></i>
						</div>
					</div>
					<div class="data-row main-row">
						<div class="benchmark-data-box">
							<h3 class="box-title">Your Score</h3>
							<p class="big-score yes-no"><?php echo $_GET['fb_branded'] ?></p>
							<p class="score-description">Is your Facebook page branded to your practice</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Industry Average</h3>
							<p class="big-score">63.1%</p>
							<p class="score-description">Have a Facebook branded page</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Prior Year Stats</h3>
							<p class="small-score">2018: 62.8%</p>
							<p class="small-score">2017: 61%</p>
						</div>
						<div class="benchmark-data-box last-benchmark-data-box">
							<h3 class="box-title">Industry Notes</h3>
							<p class="score-description">In the past year, the industry saw a mere 0.3% growth as a part of the 3% growth of the past two years. 93% of iVET360 clients have their Facebook page branded.</p>
						</div>
					</div>
					<div class="hover-text">
						<h3>The What:</h3>
						<p>As the internet continues to expand, your Facebook page’s visibility naturally dwindles, so having your brand stand out within the newsfeed is a must.</p>
						<p>So that your clients and other members of the community can recognize your hospital on Facebook immediately, the practice’s visual branding should extend to your Facebook page. Think of it this way—your practice will be listed in a user’s newsfeed along with their friends, so you want your content to be easily noticeable and not just something that gets skipped over.</p>
						<p>In this study, we are scoring practices based on a rubric of visibility—is your logo used? Are your colors user-friendly? We have seen hospitals switch out their Facebook image for something like a staff member’s pet, or a pet of the month—while this is cute, it does degrade visibility. Simply put, your profile photo needs to be your logo or another identifiable marker that makes your hospital stand out.</p>
						<h3>The Why:</h3>
						<p>Hospitals that have a branded page also saw a 1 percent increase in the number of reviews/recommendations over those that did not.</p>
						<h3>The How:</h3>
						<p><b>How to brand your hospital’s Facebook page:</b> As an admin, go to your page and hover over or tap on your profile picture. Click “Update”, then select an option and follow the on-screen instructions.</p>
					</div>
				</div>
			</div>

			<div id="fb-messenger">
				<div class="data-set fade-element">
					<div class="data-title">
						<h2 class="facebook-title">FACEBOOK MESSENGER</h2>
						<div class="more-info">
							<p>Learn More</p>
							<i class="far fa-question-circle"></i>
						</div>
					</div>
					<div class="data-row main-row">
						<div class="benchmark-data-box">
							<h3 class="box-title">Your Score</h3>
							<p class="big-score yes-no"><?php echo $_GET['fb_mess'] ?></p>
							<p class="score-description">Are you using Facebook Messenger</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Industry Average</h3>
							<p class="big-score">86.1%</p>
							<p class="score-description">Are using Facebook messenger</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Prior Year Stats</h3>
							<p class="small-score">2018: 87.6%</p>
							<p class="small-score">2017: 89.6%</p>
						</div>
						<div class="benchmark-data-box last-benchmark-data-box">
							<h3 class="box-title">Industry Notes</h3>
							<p class="score-description">The industry has seen a 2% decline in the past year, contributing to the 4% decline over the past two years. 96% of iVET360 clients actively use Messenger.</p>
						</div>
					</div>
					<div class="hover-text">
						<h3>The What:</h3>
						<p>In our increasingly digital age, having a platform where clients can easily reach you without having to speak—whether as a face-to-face or over the phone, is ideal. The chat feature in question is known as Facebook Messenger. While it’s perfectly set up for group chats or sharing Facebook posts with a friend, it is also perfect for individualized messages and quick conversations with businesses.</p>
						<p>You can turn this feature on or off—having it off limits your lines of communication to your clients, yet some businesses prefer turning it off, so they can limit the number of platforms their front office utilizes. Having it turned on doesn’t necessarily mean you have to answer medical questions or respond to every single message. Rather, certain practices utilize Messenger to leave an auto response with their phone number or with a link to their website to make an appointment.</p>
						<p>It’s likely that the mixed bag and added hassle of Facebook Messaging have played a large part in the past two years of declining industry usage, but the fact is, this feature can often do more good than bad. Having Messenger turned on doesn’t necessarily mean you have to answer medical questions or respond to every single message. In fact, some businesses, including many veterinary practices, will utilize Messenger by leaving an auto-response with their phone number or a link to make an appointment on their website, which both encourages clients to engage further and streamlines the points of contact that require maintenance.</p>
						<p>All in all, by making your hospital available on Facebook Messenger, you open your practice to more conversations, which leads to more appointments—and your office staff doesn’t even have to keep up on it if you set up the automated message.</p>
						<h3>The Why:</h3>
						<p>Hospitals that utilized Facebook Messenger also saw an 11 percent increase in number of reviews/recommendations over those that did not.</p>
						<h3>The How:</h3>
						<p><b>How to set up or dismantle Messenger:</b> As an admin of your hospital’s Facebook page, first look at the top of the page for the “Settings” button. From “General,” click on “Messages.” Here, you should see the statement, “Allow people to contact my page privately by showing the message button,” beside which is a box you can check or uncheck depending on your preference. Then, click to save changes.</p>
					</div>
				</div>
			</div>

			<div id="fb-story">
				<div class="data-set last-data-set fade-element">
					<div class="data-title">
						<h2 class="facebook-title">FACEBOOK STORY</h2>
						<div class="more-info">
							<p>Learn More</p>
							<i class="far fa-question-circle"></i>
						</div>
					</div>
					<div class="data-row main-row">
						<div class="benchmark-data-box">
							<h3 class="box-title">Your Score</h3>
							<p class="big-score yes-no"><?php echo $_GET['fb_story'] ?></p>
							<p class="score-description">Do you have a Facebook Story</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Industry Average</h3>
							<p class="big-score">25%</p>
							<p class="score-description">Have setup their Facebook Story</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Prior Year Stats</h3>
							<p class="small-score">2018: N/A</p>
							<p class="small-score">2017: N/A</p>
						</div>
						<div class="benchmark-data-box last-benchmark-data-box">
							<h3 class="box-title">Industry Notes</h3>
							<p class="score-description">83% of iVET360 clients have their Story displayed on their Facebook Page.</p>
						</div>
					</div>
					<div class="hover-text">
						<h3>The What:</h3>
						<p>In late 2017, Facebook rolled out with a new feature where those with Facebook Business Pages could basically extend their “About” section by adding their “Story,” otherwise known as “Our Story.” The Story is simply a more detailed look at your hospital, focused on history, culture, values or really anything else you want. You could even re-purpose copy from your website if you’d like to keep things simple.</p>
						<p>By developing your hospital’s Story, you are providing potential clients with an inside look at how your practice is run and what they can expect from you and your staff. You can even provide a picture that will sit on top of the Story (much as a cover photo would) to set the vibe.</p>
						<p>We know not everyone will have a good story to tell, but filling out all of Facebook’s suggested features helps not only you, but your clients as well. The Story, as any other recommended section, will help people find you and get to know you—making them increasingly more likely to set up an appointment with you. This is especially true now that the “Story” feature can be viewed on both Facebook’s desktop and mobile app versions.</p>
						<h3>The Why:</h3>
						<p>Hospitals that utilized Facebook Story also saw a 59 percent increase in number of reviews/recommendations over those that did not.</p>
						<h3>The How:</h3>
						<p>How to set up your Facebook Story: After logging into your Facebook Business Page, you should see an empty section titled “Our Story.” Within that section, click on “+Tell people about your business,” from which you should be able to add a photo, rename the title and write a description of your business.</p>
					</div>
				</div>
			</div>

		</div>

		<div class="data-section" id="yelp-report">
			<div class="divider-box yelp-divider">
				<i class="fas fa-dot-circle"></i>
				<div class="divider"></div>
			</div>
			<div class="section-title fade-element">
				<h1>Yelp</h1>
				<img src="/wp-content/uploads/2019/11/yelp-vmbr.png" alt="Yelp Icon">
			</div>
			<div class="section-description fade-element">
				<p>We hear it from the managers and practice owners of iVET360 hospitals on the daily: Yelp is no fun. Okay, maybe they don’t use those exact words, and maybe the sentiment isn’t expressed on a day-to-day basis, but the distaste for Yelp is definitely there. And we understand. With all the business listing websites and the innovative newcomers (*cough* Nextdoor), it’s hard to feel the need to continue using Yelp and its features—especially with their evidenced monthly decline of users.</p>
				<p>BUT, as long as Yelp still takes up such a large section of internet real estate, we’ll have to set aside our annoyance with their filtered reviews, and continue to partake and appease them—and all the other humans who use Yelp more regularly than other platforms. With 114 million unique users every per month, Yelp is still a powerful tool for gaining new clients and managing your reputation. Much like your website, Facebook page and Google page, it is essential to properly utilize the tools offered by Yelp to maximize and maintain your hospital’s online presence.</p>
			</div>

			<div id="yelp-reviews">
				<div class="data-set fade-element">
					<div class="data-title">
						<h2 class="yelp-title">YELP REVIEWS</h2>
						<div class="more-info">
							<p>Learn More</p>
							<i class="far fa-question-circle"></i>
						</div>
					</div>
					<div class="data-row main-row">
						<div class="benchmark-data-box">
							<h3 class="box-title">Your Score</h3>
							<p class="big-score inputted-number"><?php echo $_GET['y_reviews'] ?></p>
							<p class="score-description">Number of reviewson Yelp</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Industry Average</h3>
							<p class="big-score industry-avg">30</p>
							<p class="score-description">Yelp reviews for the average veterinary hospital</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Prior Year Stats</h3>
							<p class="small-score">2018: 27</p>
							<p class="small-score">2017: 23</p>
						</div>
						<div class="benchmark-data-box last-benchmark-data-box">
							<h3 class="box-title">Industry Notes</h3>
							<p class="score-description">The industry saw a 10% increase in reviews over the last year, and an average 30% growth over the past two years. iVET360 clients average at 55 reviews on Yelp.</p>
						</div>
					</div>
					<div class="hover-text">
						<h3>The What:</h3>
						<p>Yelp reviews are feedback written by Yelp users about your practice, and they are a powerful tool for your hospital’s search rankings. The more reviews you have, the better your search results will be. Yelp relies on an algorithm that dictates which reviews appear and in what order they will appear. This algorithm depends on how active the reviewer is and takes into account factors such as number of reviews written by the user and whether or not they have a picture on their account.</p>
						<p>The industry is looking pretty sparse in terms of reviews added every year, but that doesn’t mean there aren’t reviews to be had. The average veterinary hospital has gained only 7 reviews in the past two years, but that’s only a fraction of how many clients would have walked through their doors.</p>
						<p>Unfortunately, Yelp strongly advocates against asking your clients for reviews, and they do monitor this. There are, however, ways to encourage your clients to pen reviews. You could add a Yelp button to your website that prompts returning customers to review, or you could add the Yelp Review button to your email signature.</p>
						<p>Additionally, you could inform clients that you are on Yelp by posting some signage in your storefront. As stated earlier, the more reviews you have, the better your search results will be, which will affect your traffic and, ultimately, your hospital’s success.</p>
						<h3>The Why:</h3>
						<p>Yelp reviews help drive SEO. Barnacle SEO is the practice of using larger, reputable websites to promote your own business’ website and gain more traffic. Will Scott of Search Influence, the man who coined the term, explains it in his original post as “attaching oneself to a large fixed object and waiting for the customers to float by in the current.”</p>
						<p>For example, a local grocery shop owner can get his business ranking well on SERPs if it’s listed with a Yelp account in the correct local business category. By identifying popular sites and sites specific to your niche, you can take full advantage of barnacle SEO.</p>
						<h3>The How:</h3>
						<p><b>How to get more Yelp reviews:</b> Utilize the Yelp Check-In offer. Or better yet, politely ask your clients for a review.</p>
					</div>
				</div>
			</div>

			<div id="yelp-claimed">
				<div class="data-set fade-element">
					<div class="data-title">
						<h2 class="yelp-title">YELP CLAIMED</h2>
						<div class="more-info">
							<p>Learn More</p>
							<i class="far fa-question-circle"></i>
						</div>
					</div>
					<div class="data-row main-row">
						<div class="benchmark-data-box">
							<h3 class="box-title">Your Score</h3>
							<p class="big-score yes-no"><?php echo $_GET['y_claimed'] ?></p>
							<p class="score-description">Is your Yelp listing claimed</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Industry Average</h3>
							<p class="big-score">89%</p>
							<p class="score-description">Of hospitals have claimed their Yelp business listing</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Prior Year Stats</h3>
							<p class="small-score">2018: 86.9%</p>
							<p class="small-score">2017: 82.2%</p>
						</div>
						<div class="benchmark-data-box last-benchmark-data-box">
							<h3 class="box-title">Industry Notes</h3>
							<p class="score-description">A 2% growth in the last year brought the industry to an 8% increase in claimed hospitals over the past two years. 100% of iVET360 clients have a claimed Yelp listing.</p>
						</div>
					</div>
					<div class="hover-text">
						<h3>The What:</h3>
						<p>Facebook and Google have business verifications—Yelp has claims. And just like with the other two, it is essential that you take the simple step to claiming your veterinary hospital’s Yelp page. This is not only to avoid strangers and competitors taking control of a potential online profile of your practice, though. Claiming your business listing is the first and most important step toward having a complete profile, and according to Yelp, the more complete the profile, the more customer leads a business is likely to have.</p>
						<p>With a claimed Yelp listing, your hospital has all the tools necessary to start personalizing and increasing the value of this page. Adding photos, responding to reviews and making offers are only a few of the things your practice can do to make your listing more attractive and informative for potential clients.</p>
						<p>The industry continues to grow only slightly in the number of claimed Yelp listings, but ideally, the percentage would be at 100. This is such a simple check off the list, but it significantly strengthens the hospital’s reach and credibility online.</p>
						<h3>The Why:</h3>
						<p>Hospitals that have a claimed Yelp profile also saw an 8 percent increase in number of reviews over those that did not.</p>
						<h3>The How:</h3>
						<p><b>How to claim your hospital’s Yelp page:</b> Search for your hospital on Yelp. If your page has not been claimed, there will be a link that says, “Claim your business.” Select this link, and it will lead you through a series of steps to create a business account. Once your account is set up, continue the instructions to claim the business. Yelp will call the number listed on the business page, and provide you with a code. Once you get this code, type it in to verify ownership of your page.</p>
					</div>
				</div>
			</div>

			<div id="yelp-ads">
				<div class="data-set fade-element">
					<div class="data-title">
						<h2 class="yelp-title">YELP ADS</h2>
						<div class="more-info">
							<p>Learn More</p>
							<i class="far fa-question-circle"></i>
						</div>
					</div>
					<div class="data-row main-row">
						<div class="benchmark-data-box">
							<h3 class="box-title">Your Score</h3>
							<p class="big-score yes-no"><?php echo $_GET['y_ads'] ?></p>
							<p class="score-description">Are you using Yelp Ads</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Industry Average</h3>
							<p class="big-score">13.9%</p>
							<p class="score-description">Of hospitals are utilizing Yelp Ads</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Prior Year Stats</h3>
							<p class="small-score">2018: 15.9%</p>
							<p class="small-score">2017: 11.9%</p>
						</div>
						<div class="benchmark-data-box last-benchmark-data-box">
							<h3 class="box-title">Industry Notes</h3>
							<p class="score-description">After a 13% industry decline in the past year, the last two years have seen an overall 17% growth in hospitals using Yelp Ads. Only 15% of iVET360 clients make use of this.</p>
						</div>
					</div>
					<div class="hover-text">
						<h3>The What:</h3>
						<p>If your hospital purchases a Yelp Ad, it will appear on the pages that consumers see when they’re looking for other veterinary hospitals or similar businesses. This means that not only will your ad be included in relevant search pages, but on the Yelp business pages of competitors as well. The ad will also get promoted across all Yelp platforms, including online and on the app, and encourages potential clients to visit your page.</p>
						<p>A Yelp ad could also be anything from adding a call-to-action button on your business page (taking clients directly to an appointment page, coupon image etc.) torestricting competitors’ ads from appearing on your Yelp page.</p>
						<p>While we did see a slight increase in hospitals choosing to push this feature in 2018, 2019’s decline seemed to even out the difference between the two previous years. This is likely because it’s harder to see a return on investment when it comes to Yelp Ads; in fact, the percentage of practices who are using the feature is slightly skewed as it is. Some hospitals were offered somewhat complementary Yelp Ads after investing in ads for Yellow Pages and choosing the cross-platform option. Choosing the most effective avenue for your marketing budget to go toward is important, and it’s likely that much of the industry has hospital locatons in less competitive areas.</p>
						<h3>The Why:</h3>
						<p>Hospitals that utilize Yelp Ads also saw a 92 percent increase in number of reviews over those that do not.</p>
						<h3>The How:</h3>
						<p><b>How to set up Yelp Ads:</b> Yelp makes it easy to advertise on their platform. <a href="https://biz.yelp.com/advertise" target="_blank">Simply click here for their detailed run down</a>.</p>
					</div>
				</div>
			</div>

			<div id="yelp-check">
				<div class="data-set fade-element">
					<div class="data-title">
						<h2 class="yelp-title">YELP CHECK-IN OFFERS</h2>
						<div class="more-info">
							<p>Learn More</p>
							<i class="far fa-question-circle"></i>
						</div>
					</div>
					<div class="data-row main-row">
						<div class="benchmark-data-box">
							<h3 class="box-title">Your Score</h3>
							<p class="big-score yes-no"><?php echo $_GET['y_checkin'] ?></p>
							<p class="score-description">Do you have a Yelp Check-In offer</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Industry Average</h3>
							<p class="big-score">9.3%</p>
							<p class="score-description">Of hospitals have a Yelp Check-In offer</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Prior Year Stats</h3>
							<p class="small-score">2018: 9.6%</p>
							<p class="small-score">2017: 5%</p>
						</div>
						<div class="benchmark-data-box last-benchmark-data-box">
							<h3 class="box-title">Industry Notes</h3>
							<p class="score-description">Despite a 3% decline over the past year, the industry has still seen an 86% growth over the past two years. 48% of iVET360 clients have Check-In offers.</p>
						</div>
					</div>
					<div class="hover-text">
						<h3>The What:</h3>
						<p>When clients use Yelp Check-In at your hospital, they’re essentially broadcasting to their friends that they chose you for their pet’s veterinary needs. This opens up the situation for both digital and person-to-person advertising. To encourage your loyal clients to “check-in,” or report their location, often businesses will digitally offer small discounts, free items or other special deals.</p>
						<p>The feature is available both on desktop and with the mobile app, and you can track how many people checked-in as well as how many people redeemed an offer if you have one in place at the time.</p>
						<p>Though there was a tiny decline in the numbers for 2019, this feature clearly helps drive reviews for the hospitals that are choosing to take part in this niche feature. The most successful hospitals practice this Yelp feature/hospital deal combination, as seen in the fact that they have over twice as many reviews as those that don’t take part.</p>
						<h3>The Why:</h3>
						<p>Hospitals that utilize a Yelp Check-In offer saw a 124 percent increase in number of reviews over those that did not.</p>
						<h3>The How:</h3>
						<p><b>How to set up a Yelp Check-In Offer:</b> First, establish a Check-In Offer with clients, like $5 off an exam, a free nail trim, a free branded frisbee or a small bag of treats they could get from a vendor. Ideally, give away little things you already have around the clinic. Then go to biz.yelp.com and log in.</p>
						<p>Click “Check-In Offers,” and then “Create a Check-In Offer.” Select what type of offer to give—from percent off, price off, fixed price or free item. Add a headline and description details, such as: “Check in at [Hospital Name] to receive [offer].” Click “Create Offer.” Once it has been created, you will see it on the “Check-In Offers” page, which will also show you how many people have checked in and received this offer.</p>
					</div>
				</div>
			</div>

			<div id="yelp-deals">
				<div class="data-set fade-element">
					<div class="data-title">
						<h2 class="yelp-title">YELP DEALS</h2>
						<div class="more-info">
							<p>Learn More</p>
							<i class="far fa-question-circle"></i>
						</div>
					</div>
					<div class="data-row main-row">
						<div class="benchmark-data-box">
							<h3 class="box-title">Your Score</h3>
							<p class="big-score yes-no"><?php echo $_GET['y_deals'] ?></p>
							<p class="score-description">Are you offering a Yelp Deal</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Industry Average</h3>
							<p class="big-score">1%</p>
							<p class="score-description">Of hospitals are offering a Yelp Deal</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Prior Year Stats</h3>
							<p class="small-score">2018: 1.1%</p>
							<p class="small-score">2017: N/A</p>
						</div>
						<div class="benchmark-data-box last-benchmark-data-box">
							<h3 class="box-title">Industry Notes</h3>
							<p class="score-description">The industry has decreased usage by 9% since last year’s first data collection. Only 2% of iVET360 clients offer Yelp Deals.</p>
						</div>
					</div>
					<div class="hover-text">
						<h3>The What:</h3>
						<p>Similar to Groupon, Yelp Deal is a feature that encourages clients to purchase coupons or discounts. For example, they may be able to spend $20 to receive a $40 voucher for services. This would create a simple incentive for pet owners to pick your hospital over others if they see the deal while searching.</p>
						<p>Our data shows that the already small percentage of hospitals who used this feature last year got even smaller in 2019. It seems that the Yelp Deals are still a rather flat marketing strategy for many hospitals, even leaving some to lose money over it, considering Yelp takes up to 30 percent of the revenue straight from the client. Yelp Check-In actually seems to be much more valuable.</p>
						<h3>The Why:</h3>
						<p>Hospitals that utilize a Yelp Deal did saw a 123 percent increase in number of reviews over those that did not.</p>
						<h3>The How:</h3>
						<p><b>How to post a Yelp Deal:</b> To create a Yelp Deal, log in to Yelp for Business Owners and then click “Deals & Gift Certificates” in the sidebar menu. Then click “Set Up Deals and Gift Certificates.” From there, choose a price, the number of vouchers to make available and any other special terms. Now review and agree to the Merchant Terms then click “Post this Deal” to finalize the process.</p>
					</div>
				</div>
			</div>

			<div id="yelp-comm">
				<div class="data-set last-data-set fade-element">
					<div class="data-title">
						<h2 class="yelp-title">YELP ASK THE COMMUNITY</h2>
						<div class="more-info">
							<p>Learn More</p>
							<i class="far fa-question-circle"></i>
						</div>
					</div>
					<div class="data-row main-row">
						<div class="benchmark-data-box">
							<h3 class="box-title">Your Score</h3>
							<div class="two-score-box">
								<p class="medium-score yes-no"><?php echo $_GET['y_comm'] ?></p>
								<p class="score-description">Are you using Yelp Ask The Community</p>
							</div>
							<div class="two-score-box">
								<p class="medium-score inputted-number"><?php echo $_GET['y_ques'] ?></p>
								<p class="score-description">Number of Yelp questions</p>
							</div>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Industry Average</h3>
							<div class="two-score-box">
								<p class="medium-score">3.2%</p>
								<p class="score-description">Of hospitals are using Yelp ask the community</p>
							</div>
							<div class="two-score-box">
								<p class="medium-score industry-avg">.2</p>
								<p class="score-description">Average number of Yelp questions</p>
							</div>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Prior Year Stats</h3>
							<p class="small-score">2018: N/A</p>
							<p class="small-score">2017: N/A</p>
						</div>
						<div class="benchmark-data-box last-benchmark-data-box">
							<h3 class="box-title">Industry Notes</h3>
							<p class="score-description">5.6% of iVET360 clients are active with Yelp Asks, with an average of less than one question asked on each hospital’s listing.</p>
						</div>
					</div>
					<div class="hover-text">
						<h3>The What:</h3>
						<p>Similar to Google’s Questions and Answers, Yelp’s Ask The Community allows their users to ask public questions to your business. Also like Google, this needs to be a feature you keep track of, as it allows other users in the community to respond without authority.</p>
						<h3>The Why:</h3>
						<p>With less than one question on average per hospital, the data says that Yelp users aren’t really utilizing this feature at all—outside of California. However, that doesn’t mean your hospital shouldn’t pay attention to it. Be aware the feature exists and be ready to answer when the questions do come. You’ll want to control the narrative and provide the correct answers.</p>
						<h3>The How:</h3>
						<p><b>How to respond to Yelp Asks:</b> After logging in to your Yelper account, go to the “Ask the Community” section on the business page. Scroll down to find the specific question you’d like to respond to, then click or tap the “Answer” button. Your response will be posted shortly after submitting it.</p>
					</div>
				</div>
			</div>

		</div>

		<div class="data-section" id="nextdoor-report">
			<div class="divider-box nextdoor-divider">
				<i class="fas fa-dot-circle"></i>
				<div class="divider"></div>
			</div>
			<div class="section-title fade-element">
				<h1>Nextdoor</h1>
				<img src="/wp-content/uploads/2019/11/nd-vmbr.png" alt="Nextdoor Icon">
			</div>
			<div class="section-description fade-element">
				<p>No longer a “nice to have,” Nextdoor has become a must have for your hospital. With the number of recommendations growing by 77 percent over the course of last year, the time is now to claim your Nextdoor Business listing and start interacting with your neighbors on this incredibly successful platform.</p>
				<p>Think of Nextdoor like Yelp, but with content limited to people that actually live in a certain area of town. The residents of Portland, Oregon cannot see any Nextdoor content that the residents of Portland, Maine can—and vice versa. But it actually gets deeper than that. There are 243 neighborhoods in Portland, OR and 28 in Portland, ME, each with unique conversations happening, a lot of which are about the vets their neighbors love and ones to stay away from. Nextdoor bills itself as a platform that lets neighbors connect online and make their neighborhoods better, including the local businesses. While everyone has heard of Facebook and Yelp, Nextdoor has quietly been making their presence known. In fact, it has become important to ask: has your hospital been active on Nextdoor?</p>
				<p>Regardless of whether your practice has been active or not, your hospital already has a Nextdoor business listing, and it’s clear that the people are talking. This makes it crucial that you not only have your listing claimed, but that you are monitoring the conversation.</p>
			</div>

			<div id="nd-recs">
				<div class="data-set fade-element">
					<div class="data-title">
						<h2 class="nextdoor-title">NEXTDOOR RECOMMENDATIONS</h2>
						<div class="more-info">
							<p>Learn More</p>
							<i class="far fa-question-circle"></i>
						</div>
					</div>
					<div class="data-row main-row">
						<div class="benchmark-data-box">
							<h3 class="box-title">Your Score</h3>
							<p class="big-score inputted-number"><?php echo $_GET['nd_recs'] ?></p>
							<p class="score-description">Number of Nextdoor recommendations</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Industry Average</h3>
							<p class="big-score industry-avg">82</p>
							<p class="score-description">Recommendations for the average veterinary hospital</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Prior Year Stats</h3>
							<p class="small-score">2018: 46</p>
							<p class="small-score">2017: N/A</p>
						</div>
						<div class="benchmark-data-box last-benchmark-data-box">
							<h3 class="box-title">Industry Notes</h3>
							<p class="score-description">The industry saw a 77% increase over last year’s first collection of data. iVET360 clients average at 108 reviews per listing.</p>
						</div>
					</div>
					<div class="hover-text">
						<h3>The What:</h3>
						<p>Wouldn’t you rather know what people are saying about you than guess and hope that the reviews are positive? Or maybe you don’t even know that people are talking at all—and how could you possibly manage to moderate the conversation or interact with these reviewers? This situation could very well be the case for your hospital. And the worst part, is that the people talking are the clients that live right in your own community, the ones who know you best, who may even call you a friend—they’re your neighbors!</p>
						<p>This is why it’s so important to claim your Nextdoor listing—whether they’re singing praises, or spouting unfair, negative reviews, it can only benefit your practice to be aware and ready to respond. Unfortunately, the majority of hospitals remain unaware and defenseless to what people are saying about them on this the fastest growing local listing service out there. Luckily, it’s really easy to join the Nextdoor party.</p>
						<h3>The Why:</h3>
						<p>With recommendations nearly doubling in the last year and already sitting at almost triple the amount of Yelp reviews, it’s easy to see why your hospital needs to be active on Nextdoor...like, yesterday.</p>
						<h3>The How:</h3>
						<p><b>How to claim your Nextdoor listing:</b> To claim your listing, you must (of course) first be affiliated with your hospital, then you need to create an account, search for your practice and click “Claim”—make sure to claim it as a business.</p>
						<p>Then enter your name, email and a chosen password. Once you claim your page, you will have to go through a basic phone verification protocol to confirm you are who you say you are. When you are finished claiming your hospital, you can see what people are saying about you, respond to comments and update your profile information.</p>
					</div>
				</div>
			</div>

			<div id="nd-claimed">
				<div class="data-set fade-element">
					<div class="data-title">
						<h2 class="nextdoor-title">NEXTDOOR CLAIMED</h2>
						<div class="more-info">
							<p>Learn More</p>
							<i class="far fa-question-circle"></i>
						</div>
					</div>
					<div class="data-row main-row">
						<div class="benchmark-data-box">
							<h3 class="box-title">Your Score</h3>
							<p class="big-score yes-no"><?php echo $_GET['nd_claimed'] ?></p>
							<p class="score-description">Is your Nextdoor listing claimed</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Industry Average</h3>
							<p class="big-score">29.3%</p>
							<p class="score-description">Of hospitals have claimed their Nextdoor listing</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Prior Year Stats</h3>
							<p class="small-score">2018: 15%</p>
							<p class="small-score">2017: N/A</p>
						</div>
						<div class="benchmark-data-box last-benchmark-data-box">
							<h3 class="box-title">Industry Notes</h3>
							<p class="score-description">The industry saw a promising 95% increase in claimed hospitals over the past year. 100% of iVET360 clients have claimed their listing on Nextdoor.</p>
						</div>
					</div>
					<div class="hover-text">
						<h3>The What:</h3>
						<p>On your public Nextdoor business page, there is a button with a heart logo that says “Recommend.” Users can click this button and follow it up with a positive comment about your hospital, which everyone in your network can see. However, people can also just write a comment about your hospital without hitting the “Recommend” button; this shows up in the same feed as the recommendation comments, and is usually how users will post negative reviews of your hospital.</p>
						<p>While this negative feedback can’t necessarily be avoided, there are ways to resolve the situation. You can either reply publicly on the forum or you can send the commenter a private message to mend any wrongdoing. Negative reviews can also be removed by Nextdoor if the content violates their guidelines, but the violation must first be noticed and reported to the company before they can take the users off the site.</p>
						<h3>The Why:</h3>
						<p>Despite the possibility of negative comments, Recommendations are incredibly valuable to the practice itself, as well as its visibility and, ultimately, its client count. Just like with Google Reviews, the more that people recommend your practice on Nextdoor, the higher you show up on search results in your network.</p>
						<p>Speaking of Google, it’s a sure testament to the extreme growth of Nextdoor that the average veterinary hospital has already received 71 percent of the reviews that practice might currently have on Google, which has been around much, much longer.</p>
					</div>
				</div>
			</div>

			<div id="nd-faves">
				<div class="data-set fade-element zero-translate">
					<div class="data-title">
						<h2 class="nextdoor-title">NEXTDOOR FAVORITES</h2>
						<div class="more-info">
							<p>Learn More</p>
							<i class="far fa-question-circle"></i>
						</div>
					</div>
					<div class="data-row main-row">
						<div class="benchmark-data-box">
							<h3 class="box-title">Your Score</h3>
							<p class="big-score inputted-number"><?php echo $_GET['nd_faves'] ?></p>
							<p class="score-description">Number of favorite neighborhoods</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Industry Average</h3>
							<p class="big-score industry-avg">5</p>
							<p class="score-description">Average number of neighborhoods a hospital is a favorite in</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Prior Year Stats</h3>
							<p class="small-score">2018: N/A</p>
							<p class="small-score">2017: N/A</p>
						</div>
						<div class="benchmark-data-box last-benchmark-data-box">
							<h3 class="box-title">Industry Notes</h3>
							<p class="score-description">iVET360 clients are favorites in an average of 6 neighborhoods.</p>
						</div>
					</div>
					<div class="hover-text">
						<h3>The What:</h3>
						<p>Since 2017, Nextdoor has encouraged neighbors to vote annually in over 30 categories for the small businesses that mean the most to them in their particular area. Depending on the reach of a business, or of your veterinary hospital, it could become a Favorite in quite a number of surrounding neighborhoods.</p>
						<p>The ranking of “Neighborhood Favorite” gives your hospital a certain amount of marketing in and of itself, considering a list of each neighborhood’s 30 small businesses of choice is sent to each person community. Besides that, though, the prize for gaining this title is a free month of advertising, which is the source of the most explosive growth we’re seeing through Nextdoor this year.</p>
						<h3>The Why:</h3>
						<p>Nextdoor Favorites is free advertising, with the clients in your community ready to share with their friends how great your hospital is. Committed clients will tell even pet-less friends why they should vote for your practice as a neighborhood favorite veterinary hospital. And that’s not even starting to touch on the free month of digital advertising offered if you do become a neighborhood favorite.</p>
					</div>
				</div>
			</div>

			<div id="nd-local">
				<div class="data-set last-data-set fade-element zero-translate">
					<div class="data-title">
						<h2 class="nextdoor-title">NEXTDOOR LOCAL DEALS</h2>
						<div class="more-info">
							<p>Learn More</p>
							<i class="far fa-question-circle"></i>
						</div>
					</div>
					<div class="data-row main-row">
						<div class="benchmark-data-box">
							<h3 class="box-title">Your Score</h3>
							<p class="big-score yes-no"><?php echo $_GET['nd_biz'] ?></p>
							<p class="score-description">Are you using Nextdoor Local Deals</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Industry Average</h3>
							<p class="big-score">.3%</p>
							<p class="score-description">Are utilizing Nextdoor Local Deals</p>
						</div>
						<div class="benchmark-data-box">
							<h3 class="box-title">Prior Year Stats</h3>
							<p class="small-score">2018: N/A</p>
							<p class="small-score">2017: N/A</p>
						</div>
						<div class="benchmark-data-box last-benchmark-data-box">
							<h3 class="box-title">Industry Notes</h3>
							<p class="score-description">Over 37% of iVET360 clients make use of Nextdoor’s Local Deals.</p>
						</div>
					</div>
					<div class="hover-text">
						<h3>The What:</h3>
						<p>Created as a response to local businesses wanting to interact more with their most valued and invested clientele, Nextdoor has brought forth an ad-based tool called “Local Deals.” These can be used by veterinary hospitals to promote discounts or specials on services to both existing and potential clients in specific neighborhoods. Keeping the audience of these ads within driving distance creates a level of intimacy with the community, and shows your neighbors that you really do care about them and their pets—enough to give them certain deals or incentives to visit your practice.</p>
						<p>As this is a brand new feature, there isn’t any data to compare this year’s numbers with, but that doesn’t mean you shouldn’t be paying attention. With such a wide open space for your hospital to climb into, there’s no reason not to claim a spot and start using this feature to get a leg up and beat any local competition to the punch.</p>
						<h3>The Why:</h3>
						<p>These days, everyone is online, and most of these people care a lot about their community. This care shows through their interactions on Nextdoor. And one of the best parts of Local Deals, is that they’re able to be seen in so many of those interactions: in residents’ feeds, featured on business pages and the Business section, in a neighborhood-specific Local Deals area, and as a sponsored listing in search results.</p>
						<p>The reach of these deals, shows, too. Nextdoor keeps track of users who save and who redeem deals that you’ve chosen to advertise, and the numbers speak for themselves. As an example, <a href="https://ivet360.com/nextdoor-local-deals-veterinary/" target="_blank">some of our iVET360 hospitals</a> that ran the Local Deal for a month had a return on investment of over 400 percent. Even within their inaugural year, these deals could not be more of an obvious investment.</p>
						<h3>The How:</h3>
						<p><b>How to create a Local Deal:</b> After claiming your business on Nextdoor, you can <a href="https://vimeo.com/nextdoor/review/364411251/cea08e132f" target="_blank">watch this video</a>, created by Nextdoor, that walks you through the process of picking neighborhoods to appeal to, the length of time you want your Local Deal to be featured etc. Or, you can just follow the incredibly user-friendly ad creation wizard on the site.</p>
					</div>
				</div>
			</div>

		</div>

	</div>
	<?php return ob_get_clean();
}
add_shortcode('benchmark_results_page','benchmark_results_page');

function competitor_analysis() {
	ob_start();
	?>
	<div class="competitor-analysis">
		<div id="competitor-analysis-intro">
			<h1>Competitor Audit Summary</h1>
			<h2><?php echo $_GET['hospital'] ?> // <?php echo $_GET['date'] ?></h2>
			<p>At iVET360, we are often asked by clients how their hospital stacks up against local competitors. This customized competitor audit is designed to highlight your hospital's performance in comparison to your competition. The competitors included in the report below were carefully selected based on a variety of factors, including but not limited to: proximity, hospital size, hospital type, and your perception (i.e. hospitals you personally feel qualify as competitors). For the purpose of this audit, two hospitals were selected to be benchmarked against your practice. A variety of key performance indicators have been evaluated, each of which are summarized below.</p>
			<p>The purpose of this audit is not only to understand how your hospital compares to local competitors, but also to highlight your progress to date with iVET360 and identify opportunities for continued improvement.</p>
		</div>
		<div class="category-section">
			<h2>Category 1: Website Health</h2>
			<p>You’ve heard it all before: as a business, you need a fast, mobile-friendly, secure website with SEO, SEO, SEO. But the truth is, you really need to start comparing your hospital’s website with other, local animal hospitals, and stop comparing your site to standards set up outside the industry. The key is to learn the what, why and how to make sure your hospital’s website will out-perform any local competition.</p>
			<div class="category-chart">
				<div class="category-row hospital-row">
					<div class="category-box"></div>
					<div class="category-box">
						<p><?php echo $_GET['hospital'] ?></p>
					</div>
					<div class="category-box">
						<p><?php echo $_GET['competitor_one'] ?></p>
					</div>
					<div class="category-box">
						<p><?php echo $_GET['competitor_two'] ?></p>
					</div>
				</div>
				<div class="category-row">
					<div class="category-box">
						<p>Performance</p>
					</div>
					<div class="category-box">
						<p class="hos-result cat-number cat-performance hos-performance"><?php echo $_GET['performance'] ?></p>
					</div>
					<div class="category-box">
						<p class="one-result cat-number cat-performance one-performance"><?php echo $_GET['performance_one'] ?></p>
					</div>
					<div class="category-box">
						<p class="two-result cat-number cat-performance two-performance"><?php echo $_GET['performance_two'] ?></p>
					</div>
				</div>
				<div class="category-row">
					<div class="category-box">
						<p>Accessibility</p>
					</div>
					<div class="category-box">
						<p class="hos-result pass-fail hos-performance"><?php echo $_GET['accessibility'] ?></p>
					</div>
					<div class="category-box">
						<p class="one-result pass-fail one-performance"><?php echo $_GET['accessibility_one'] ?></p>
					</div>
					<div class="category-box">
						<p class="two-result pass-fail two-performance"><?php echo $_GET['accessibility_two'] ?></p>
					</div>
				</div>
				<div class="category-row">
					<div class="category-box">
						<p>Best Practices</p>
					</div>
					<div class="category-box">
						<p class="hos-result pass-fail hos-performance"><?php echo $_GET['best_practices'] ?></p>
					</div>
					<div class="category-box">
						<p class="one-result pass-fail one-performance"><?php echo $_GET['best_practices_one'] ?></p>
					</div>
					<div class="category-box">
						<p class="two-result pass-fail two-performance"><?php echo $_GET['best_practices_two'] ?></p>
					</div>
				</div>
				<div class="category-row">
					<div class="category-box">
						<p>SEO Score</p>
					</div>
					<div class="category-box">
						<p class="hos-result cat-number cat-seo hos-performance"><?php echo $_GET['seo'] ?></p>
					</div>
					<div class="category-box">
						<p class="one-result cat-number cat-seo one-performance"><?php echo $_GET['seo_one'] ?></p>
					</div>
					<div class="category-box">
						<p class="two-result cat-number cat-seo two-performance"><?php echo $_GET['seo_two'] ?></p>
					</div>
				</div>
				<div class="category-row">
					<div class="category-box">
						<p>User Experience</p>
					</div>
					<div class="category-box">
						<p class="hos-result pass-fail hos-performance"><?php echo $_GET['user_exp'] ?></p>
					</div>
					<div class="category-box">
						<p class="one-result pass-fail one-performance"><?php echo $_GET['user_exp_one'] ?></p>
					</div>
					<div class="category-box">
						<p class="two-result pass-fail two-performance"><?php echo $_GET['user_exp_two'] ?></p>
					</div>
				</div>
			</div>
		</div>
		<div class="category-section">
			<h2>Category 2: Local Listings</h2>
			<p>Google My Business is absolutely necessary, in this day and age, to not only maintain your veterinary hospital’s presence but to maximize your clientele and, ultimately, maximize your revenue as well. We’ve included below the different aspects of this profile that Google prioritizes. The more boxes your business checks, the more SEO clout, online traffic and visibility your website will have.</p>
			<div class="category-chart">
				<div class="category-row hospital-row">
					<div class="category-box"></div>
					<div class="category-box">
						<p><?php echo $_GET['hospital'] ?></p>
					</div>
					<div class="category-box">
						<p><?php echo $_GET['competitor_one'] ?></p>
					</div>
					<div class="category-box">
						<p><?php echo $_GET['competitor_two'] ?></p>
					</div>
				</div>
				<div class="category-row">
					<div class="category-box">
						<p>Address</p>
					</div>
					<div class="category-box">
						<p class="hos-result pass-fail hos-local"><?php echo $_GET['address'] ?></p>
					</div>
					<div class="category-box">
						<p class="one-result pass-fail one-local"><?php echo $_GET['address_one'] ?></p>
					</div>
					<div class="category-box">
						<p class="two-result pass-fail two-local"><?php echo $_GET['address_two'] ?></p>
					</div>
				</div>
				<div class="category-row">
					<div class="category-box">
						<p>Service Area</p>
					</div>
					<div class="category-box">
						<p class="hos-result pass-fail hos-local"><?php echo $_GET['service_area'] ?></p>
					</div>
					<div class="category-box">
						<p class="one-result pass-fail one-local"><?php echo $_GET['service_area_one'] ?></p>
					</div>
					<div class="category-box">
						<p class="two-result pass-fail two-local"><?php echo $_GET['service_area_two'] ?></p>
					</div>
				</div>
				<div class="category-row">
					<div class="category-box">
						<p>Category</p>
					</div>
					<div class="category-box">
						<p class="hos-result pass-fail hos-local"><?php echo $_GET['category'] ?></p>
					</div>
					<div class="category-box">
						<p class="one-result pass-fail one-local"><?php echo $_GET['category_one'] ?></p>
					</div>
					<div class="category-box">
						<p class="two-result pass-fail two-local"><?php echo $_GET['category_two'] ?></p>
					</div>
				</div>
				<div class="category-row">
					<div class="category-box">
						<p>Hours</p>
					</div>
					<div class="category-box">
						<p class="hos-result pass-fail hos-local"><?php echo $_GET['hours'] ?></p>
					</div>
					<div class="category-box">
						<p class="one-result pass-fail one-local"><?php echo $_GET['hours_one'] ?></p>
					</div>
					<div class="category-box">
						<p class="two-result pass-fail two-local"><?php echo $_GET['hours_two'] ?></p>
					</div>
				</div>
				<div class="category-row">
					<div class="category-box">
						<p>Phone Number</p>
					</div>
					<div class="category-box">
						<p class="hos-result pass-fail hos-local"><?php echo $_GET['phone'] ?></p>
					</div>
					<div class="category-box">
						<p class="one-result pass-fail one-local"><?php echo $_GET['phone_one'] ?></p>
					</div>
					<div class="category-box">
						<p class="two-result pass-fail two-local"><?php echo $_GET['phone_two'] ?></p>
					</div>
				</div>
				<div class="category-row">
					<div class="category-box">
						<p>Short Name</p>
					</div>
					<div class="category-box">
						<p class="hos-result pass-fail hos-local"><?php echo $_GET['short_name'] ?></p>
					</div>
					<div class="category-box">
						<p class="one-result pass-fail one-local"><?php echo $_GET['short_name_one'] ?></p>
					</div>
					<div class="category-box">
						<p class="two-result pass-fail two-local"><?php echo $_GET['short_name_two'] ?></p>
					</div>
				</div>
				<div class="category-row">
					<div class="category-box">
						<p>Website Link</p>
					</div>
					<div class="category-box">
						<p class="hos-result pass-fail hos-local"><?php echo $_GET['website'] ?></p>
					</div>
					<div class="category-box">
						<p class="one-result pass-fail one-local"><?php echo $_GET['website_one'] ?></p>
					</div>
					<div class="category-box">
						<p class="two-result pass-fail two-local"><?php echo $_GET['website_two'] ?></p>
					</div>
				</div>
				<div class="category-row">
					<div class="category-box">
						<p>Appointment Link</p>
					</div>
					<div class="category-box">
						<p class="hos-result pass-fail hos-local"><?php echo $_GET['appt_link'] ?></p>
					</div>
					<div class="category-box">
						<p class="one-result pass-fail one-local"><?php echo $_GET['appt_link_one'] ?></p>
					</div>
					<div class="category-box">
						<p class="two-result pass-fail two-local"><?php echo $_GET['appt_link_two'] ?></p>
					</div>
				</div>
				<div class="category-row">
					<div class="category-box">
						<p>Attributes</p>
					</div>
					<div class="category-box">
						<p class="hos-result pass-fail hos-local"><?php echo $_GET['attributes'] ?></p>
					</div>
					<div class="category-box">
						<p class="one-result pass-fail one-local"><?php echo $_GET['attributes_one'] ?></p>
					</div>
					<div class="category-box">
						<p class="two-result pass-fail two-local"><?php echo $_GET['attributes_two'] ?></p>
					</div>
				</div>
				<div class="category-row">
					<div class="category-box">
						<p>Business Description</p>
					</div>
					<div class="category-box">
						<p class="hos-result pass-fail hos-local"><?php echo $_GET['biz_desc'] ?></p>
					</div>
					<div class="category-box">
						<p class="one-result pass-fail one-local"><?php echo $_GET['biz_desc_one'] ?></p>
					</div>
					<div class="category-box">
						<p class="two-result pass-fail two-local"><?php echo $_GET['biz_desc_two'] ?></p>
					</div>
				</div>
				<div class="category-row">
					<div class="category-box">
						<p>Logo</p>
					</div>
					<div class="category-box">
						<p class="hos-result pass-fail hos-local"><?php echo $_GET['logo'] ?></p>
					</div>
					<div class="category-box">
						<p class="one-result pass-fail one-local"><?php echo $_GET['logo_one'] ?></p>
					</div>
					<div class="category-box">
						<p class="two-result pass-fail two-local"><?php echo $_GET['logo_two'] ?></p>
					</div>
				</div>
				<div class="category-row">
					<div class="category-box">
						<p>Cover Photo</p>
					</div>
					<div class="category-box">
						<p class="hos-result pass-fail hos-local"><?php echo $_GET['cover_photo'] ?></p>
					</div>
					<div class="category-box">
						<p class="one-result pass-fail one-local"><?php echo $_GET['cover_photo_one'] ?></p>
					</div>
					<div class="category-box">
						<p class="two-result pass-fail two-local"><?php echo $_GET['cover_photo_two'] ?></p>
					</div>
				</div>
				<div class="category-row">
					<div class="category-box">
						<p>Post/Offer/Update</p>
					</div>
					<div class="category-box">
						<p class="hos-result pass-fail hos-local"><?php echo $_GET['pou'] ?></p>
					</div>
					<div class="category-box">
						<p class="one-result pass-fail one-local"><?php echo $_GET['pou_one'] ?></p>
					</div>
					<div class="category-box">
						<p class="two-result pass-fail two-local"><?php echo $_GET['pou_two'] ?></p>
					</div>
				</div>
			</div>
		</div>
		<div class="category-section">
			<h2>Category 3: Social Media</h2>
			<p>Facebook: You either love to hate it or you hate to love it. No matter which category you fall under, though, there’s no arguing its overwhelming presence on the internet. Keeping your Facebook Page current is critical for providing your clients and prospective clients with accurate information about your practice.</p>
			<div class="category-chart">
				<div class="category-row hospital-row">
					<div class="category-box"></div>
					<div class="category-box">
						<p><?php echo $_GET['hospital'] ?></p>
					</div>
					<div class="category-box">
						<p><?php echo $_GET['competitor_one'] ?></p>
					</div>
					<div class="category-box">
						<p><?php echo $_GET['competitor_two'] ?></p>
					</div>
				</div>
				<div class="category-row">
					<div class="category-box">
						<p>Posting Cadence</p>
					</div>
					<div class="category-box">
						<p class="hos-result cat-cadence hos-social"><?php echo $_GET['posting'] ?></p>
					</div>
					<div class="category-box">
						<p class="one-result cat-cadence one-social"><?php echo $_GET['posting_one'] ?></p>
					</div>
					<div class="category-box">
						<p class="two-result cat-cadence two-social"><?php echo $_GET['posting_two'] ?></p>
					</div>
				</div>
				<div class="category-row">
					<div class="category-box">
						<p>Engagement</p>
					</div>
					<div class="category-box">
						<p class="hos-result cat-engagement hos-social"><?php echo $_GET['engagement'] ?></p>
					</div>
					<div class="category-box">
						<p class="one-result cat-engagement one-social"><?php echo $_GET['engagement_one'] ?></p>
					</div>
					<div class="category-box">
						<p class="two-result cat-engagement two-social"><?php echo $_GET['engagement_two'] ?></p>
					</div>
				</div>
			</div>
		</div>
		<div class="category-section">
			<h2>Category 4: Essential Client Services</h2>
			<p>As the landscape of the veterinary industry continues to evolve, so too do the services and conveniences that your clients come to expect. With the emergence of COVID-19, veterinary hospitals implemented a number of advanced practices that weren’t commonplace before — from telemedicine to online pharmacies and more. Conveniences like these have become the new normal, and pet owners will be taking them into consideration when choosing a new veterinary hospital for their furry friend. By staying ahead of the curve, you can protect your hospital from being left behind.</p>
			<div class="category-chart">
				<div class="category-row hospital-row">
					<div class="category-box"></div>
					<div class="category-box">
						<p><?php echo $_GET['hospital'] ?></p>
					</div>
					<div class="category-box">
						<p><?php echo $_GET['competitor_one'] ?></p>
					</div>
					<div class="category-box">
						<p><?php echo $_GET['competitor_two'] ?></p>
					</div>
				</div>
				<div class="category-row">
					<div class="category-box">
						<p>Telemedicine</p>
					</div>
					<div class="category-box">
						<p class="hos-result pass-fail hos-ecs"><?php echo $_GET['telemedicine'] ?></p>
					</div>
					<div class="category-box">
						<p class="one-result pass-fail one-ecs"><?php echo $_GET['telemedicine_one'] ?></p>
					</div>
					<div class="category-box">
						<p class="two-result pass-fail two-ecs"><?php echo $_GET['telemedicine_two'] ?></p>
					</div>
				</div>
				<div class="category-row">
					<div class="category-box">
						<p>Online Pharmacy</p>
					</div>
					<div class="category-box">
						<p class="hos-result pass-fail hos-ecs"><?php echo $_GET['pharmacy'] ?></p>
					</div>
					<div class="category-box">
						<p class="one-result pass-fail one-ecs"><?php echo $_GET['pharmacy_one'] ?></p>
					</div>
					<div class="category-box">
						<p class="two-result pass-fail two-ecs"><?php echo $_GET['pharmacy_two'] ?></p>
					</div>
				</div>
				<div class="category-row">
					<div class="category-box">
						<p>Reminder Platform or App</p>
					</div>
					<div class="category-box">
						<p class="hos-result pass-fail hos-ecs"><?php echo $_GET['reminder'] ?></p>
					</div>
					<div class="category-box">
						<p class="one-result pass-fail one-ecs"><?php echo $_GET['reminder_one'] ?></p>
					</div>
					<div class="category-box">
						<p class="two-result pass-fail two-ecs"><?php echo $_GET['reminder_two'] ?></p>
					</div>
				</div>
				<div class="category-row">
					<div class="category-box">
						<p>Alternative Payment Options</p>
					</div>
					<div class="category-box">
						<p class="hos-result pass-fail hos-ecs"><?php echo $_GET['payment'] ?></p>
					</div>
					<div class="category-box">
						<p class="one-result pass-fail one-ecs"><?php echo $_GET['payment_one'] ?></p>
					</div>
					<div class="category-box">
						<p class="two-result pass-fail two-ecs"><?php echo $_GET['payment_two'] ?></p>
					</div>
				</div>
			</div>
		</div>
		<div class="category-section">
			<h2>Category 5: Google Ads & SEO</h2>
			<p>If your website’s SEO is optimized, your page has been set up for maximum visibility based on search results. Often, even if some of your website’s pages have SEO configured, some marketing providers will forget to add it to new content or blog posts. However, if your hospital’s SEO is properly maintained, it will have a positive impact on your practice’s ability to show up in search results for organic (unpaid) search results.</p>
			<div class="category-chart">
				<div class="category-row hospital-row">
					<div class="category-box"></div>
					<div class="category-box">
						<p><?php echo $_GET['hospital'] ?></p>
					</div>
					<div class="category-box">
						<p><?php echo $_GET['competitor_one'] ?></p>
					</div>
					<div class="category-box">
						<p><?php echo $_GET['competitor_two'] ?></p>
					</div>
				</div>
				<div class="category-row">
					<div class="category-box">
						<p>Are they running Google Ads?</p>
					</div>
					<div class="category-box">
						<p class="hos-result pass-fail hos-google"><?php echo $_GET['running_ads'] ?></p>
					</div>
					<div class="category-box">
						<p class="one-result pass-fail one-google"><?php echo $_GET['running_ads_one'] ?></p>
					</div>
					<div class="category-box">
						<p class="two-result pass-fail two-google"><?php echo $_GET['running_ads_two'] ?></p>
					</div>
				</div>
				<div class="category-row">
					<div class="category-box">
						<p>Any special offers mentioned in Google Ads?</p>
					</div>
					<div class="category-box">
						<p class="hos-result pass-fail hos-google"><?php echo $_GET['special_offers'] ?></p>
					</div>
					<div class="category-box">
						<p class="one-result pass-fail one-google"><?php echo $_GET['special_offers_one'] ?></p>
					</div>
					<div class="category-box">
						<p class="two-result pass-fail two-google"><?php echo $_GET['special_offers_two'] ?></p>
					</div>
				</div>
				<div class="category-row">
					<div class="category-box">
						<p>Number of Organic Keywords Triggering</p>
					</div>
					<div class="category-box">
						<p class="hos-result cat-number cat-organic hos-google"><?php echo $_GET['organic'] ?></p>
					</div>
					<div class="category-box">
						<p class="one-result cat-number cat-organic one-google"><?php echo $_GET['organic_one'] ?></p>
					</div>
					<div class="category-box">
						<p class="two-result cat-number cat-organic two-google"><?php echo $_GET['organic_two'] ?></p>
					</div>
				</div>
			</div>
		</div>
		<div class="category-section">
			<h2>Category 6: Special Offers</h2>
			<p>One of the most effective strategies that iVET360 recommends to our veterinarians is for them to offer a free first exam (FFE) to new clients. Essentially, we want new clients to experience the amazing service and care your hospital provides, without the concern of an initial fee. Often, the idea of a risk-free chance to meet prospective veterinarians is all it takes for someone to leave their current hospital and migrate to a new one. But seasonal offers can be effective, too — they incentivize your existing clientele to bring their pet in for services they may not have considered otherwise.</p>
			<div class="category-chart">
				<div class="category-row hospital-row">
					<div class="category-box"></div>
					<div class="category-box">
						<p><?php echo $_GET['hospital'] ?></p>
					</div>
					<div class="category-box">
						<p><?php echo $_GET['competitor_one'] ?></p>
					</div>
					<div class="category-box">
						<p><?php echo $_GET['competitor_two'] ?></p>
					</div>
				</div>
				<div class="category-row">
					<div class="category-box">
						<p>New Client Offer</p>
					</div>
					<div class="category-box">
						<p class="hos-result pass-fail hos-special"><?php echo $_GET['new_client'] ?></p>
					</div>
					<div class="category-box">
						<p class="one-result pass-fail one-special"><?php echo $_GET['new_client_one'] ?></p>
					</div>
					<div class="category-box">
						<p class="two-result pass-fail two-special"><?php echo $_GET['new_client_two'] ?></p>
					</div>
				</div>
				<div class="category-row">
					<div class="category-box">
						<p>Loyalty Program</p>
					</div>
					<div class="category-box">
						<p class="hos-result pass-fail hos-special"><?php echo $_GET['loyalty'] ?></p>
					</div>
					<div class="category-box">
						<p class="one-result pass-fail one-special"><?php echo $_GET['loyalty_one'] ?></p>
					</div>
					<div class="category-box">
						<p class="two-result pass-fail two-special"><?php echo $_GET['loyalty_two'] ?></p>
					</div>
				</div>
				<div class="category-row">
					<div class="category-box">
						<p>Seasonal Offers</p>
					</div>
					<div class="category-box">
						<p class="hos-result pass-fail hos-special"><?php echo $_GET['seasonal'] ?></p>
					</div>
					<div class="category-box">
						<p class="one-result pass-fail one-special"><?php echo $_GET['seasonal_one'] ?></p>
					</div>
					<div class="category-box">
						<p class="two-result pass-fail two-special"><?php echo $_GET['seasonal_two'] ?></p>
					</div>
				</div>
				<div class="category-row">
					<div class="category-box">
						<p>Referral Program</p>
					</div>
					<div class="category-box">
						<p class="hos-result pass-fail hos-special"><?php echo $_GET['referral'] ?></p>
					</div>
					<div class="category-box">
						<p class="one-result pass-fail one-special"><?php echo $_GET['referral_one'] ?></p>
					</div>
					<div class="category-box">
						<p class="two-result pass-fail two-special"><?php echo $_GET['referral_two'] ?></p>
					</div>
				</div>
			</div>
		</div>
		<?php if ($_GET['notes'] != null): ?>
		<div class="category-section">
			<h2>Additional Notes</h2>
			<p><?php echo $_GET['notes'] ?></p>
		</div>
		<?php endif; ?>
		<div class="category-section">
			<h2>Hospital Results</h2>
			<div id="legend">
				<div class="pf-legend">
					<div class="pf-marker pass-marker"></div>
					<p class="pf-title">Pass</p>
				</div>
				<div class="pf-legend">
					<div class="pf-marker fail-marker"></div>
					<p class="pf-title">Fail</p>
				</div>
			</div>
			<div id="results-box">
				<div class="results-column">
					<h3><?php echo $_GET['hospital'] ?></h3>
					<div class="chart" id="hospital-hover">
						<div id="hospital-chart" class="test"></div>
						<div class="inner-chart">
							<div class="percentages-box">
								<div class="ind-percentage">
									<div class="pf-marker pass-marker"></div>
									<span id="hos-pass"></span>%
								</div>
								<div class="ind-percentage">
									<div class="pf-marker fail-marker"></div>
									<span id="hos-fail"></span>%
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="results-column">
					<h3><?php echo $_GET['competitor_one'] ?></h3>
					<div class="chart" id="comp-one-hover">
						<div id="comp-one-chart" class="test"></div>
						<div class="inner-chart">
							<div class="percentages-box">
								<div class="ind-percentage">
									<div class="pf-marker pass-marker"></div>
									<span id="one-pass"></span>%
								</div>
								<div class="ind-percentage">
									<div class="pf-marker fail-marker"></div>
									<span id="one-fail"></span>%
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="results-column">
					<h3><?php echo $_GET['competitor_two'] ?></h3>
					<div class="chart" id="comp-two-hover">
						<div id="comp-two-chart" class="test"></div>
						<div class="inner-chart">
							<div class="percentages-box">
								<div class="ind-percentage">
									<div class="pf-marker pass-marker"></div>
									<span id="two-pass"></span>%
								</div>
								<div class="ind-percentage">
									<div class="pf-marker fail-marker"></div>
									<span id="two-fail"></span>%
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="bar-chart-container">
				<div id="bar-chart">
					<div class="chart-row"><p id="row-hundid">100%</p></div>
					<div class="chart-row"><p>90%</p></div>
					<div class="chart-row"><p>80%</p></div>
					<div class="chart-row"><p>70%</p></div>
					<div class="chart-row"><p>60%</p></div>
					<div class="chart-row"><p>50%</p></div>
					<div class="chart-row"><p>40%</p></div>
					<div class="chart-row"><p>30%</p></div>
					<div class="chart-row"><p>20%</p></div>
					<div class="chart-row"><p>10%</p></div>
				</div>
				<div id="bar-chart-cats">
					<div class="bar-chart-cat">
						<div class="bar-box">
							<div class="bar hospital-bar"></div>
							<div class="bar one-bar"></div>
							<div class="bar two-bar"></div>
						</div>
						<h3 class="bar-title">Website Health</h3>
					</div>
					<div class="bar-chart-cat">
						<div class="bar-box">
							<div class="bar hospital-bar"></div>
							<div class="bar one-bar"></div>
							<div class="bar two-bar"></div>
						</div>
						<h3 class="bar-title">Local Listings</h3>
					</div>
					<div class="bar-chart-cat">
						<div class="bar-box">
							<div class="bar hospital-bar"></div>
							<div class="bar one-bar"></div>
							<div class="bar two-bar"></div>
						</div>
						<h3 class="bar-title">Social Media</h3>
					</div>
					<div class="bar-chart-cat">
						<div class="bar-box">
							<div class="bar hospital-bar"></div>
							<div class="bar one-bar"></div>
							<div class="bar two-bar"></div>
						</div>
						<h3 class="bar-title">Essential Client Services</h3>
					</div>
					<div class="bar-chart-cat">
						<div class="bar-box">
							<div class="bar hospital-bar"></div>
							<div class="bar one-bar"></div>
							<div class="bar two-bar"></div>
						</div>
						<h3 class="bar-title">Google Ads & SEO</h3>
					</div>
					<div class="bar-chart-cat">
						<div class="bar-box">
							<div class="bar hospital-bar"></div>
							<div class="bar one-bar"></div>
							<div class="bar two-bar"></div>
						</div>
						<h3 class="bar-title">Special Offers</h3>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode('competitor_analysis','competitor_analysis');

function new_benchmark() {
	ob_start();
	?>
	<div class="wrapper">
		<div class="intro-container website-pattern">
			<div class="text-container">
				<h1>Your Results</h1>
				<h2>Veterinary Marketing<br>Benchmark Report</h2>
			</div>
		</div>
		<div class="intro-container">
			<div class="text-container">
				<h3><?php echo $_GET['hospital_name'] ?></h3>
				<p>While the large part of a veterinary hospital’s success will always remain in the quality of care given to pets as a trusted presence in the community, it has also become increasingly important to have a strong digital presence. As the world continues to evolve and intertwine with the internet, simply having a personalized website (which every veterinary practice should have) is not enough; in fact, it’s only the first step. To be successful in a digital environment, hospitals should take care to create a marketing plan that spans the platforms and ecosystems that make up the internet.</p>
			</div>
		</div>
		<div class="section-container" id="website-container">
			<div class="intro-container website-pattern" id="website-report">
				<div class="text-container">
					<img src="/wp-content/uploads/2020/10/iVET-VMBR-icon-web.svg" alt="Website Icon">
					<h2>Website Report</h2>
				</div>
			</div>
			<div id="nav-shell">
				<div id="nav-container">
					<div id="inner-nav">
						<div id="inner-nav-left">
							<p>Reports:</p>
						</div>
						<div id="inner-nav-right">
							<a id="website-anchor" href="#website-report">Website</a>
							<a id="google-anchor" href="#google-report">Google</a>
							<a id="facebook-anchor" href="#facebook-report">Facebook</a>
							<a id="yelp-anchor" href="#yelp-report">Yelp</a>
							<a id="nextdoor-anchor" href="#nextdoor-report">Nextdoor</a>
						</div>
					</div>
				</div>
			</div>
			<div class="section-inner-container">
				<div class="section-intro-text">
					<h3>Understanding the Data</h3>
					<p>A veterinary hospital’s website should be a digital manifestation of the information and personality a client would be able to receive by walking through the doors of the physical hospital. This would include answers to any question a client or potential client would have about the practice and multiple points of contact should they not find the information they were looking for. Basically, the website should be the go-to resource for anything and everything related to its respective hospital.</p>
					<p>You’ve heard it all before: as a business, you need a fast, mobile-friendly, secure website with SEO, SEO, SEO. But the truth is, you really need to start comparing your hospital’s website with other, local animal hospitals, and stop comparing your site to standards set up outside the industry. The key is to learn the what, why and how to make sure your hospital’s website will out-perform any local competition.</p>
					<p>Here we dive into the foundational best practices of what your website should shoot for.</p>
				</div>

				<div class="dp-container">
					<div class="top-row">
						<h4 class="dp-title">DOMAIN NAME SET UP (WEBSITE URL)</h4>
						<div class="learn-more">
							<p>Learn More</p>
							<div class="plus-minus-box">
								<span></span><span></span>
							</div>
						</div>
					</div>
					<div class="middle-row">
						<div class="middle-column">
							<div class="pass-fail">
								<div class="pass-fail-inner">
									<p class="hospital-score"><?php echo $_GET['domain'] ?></p>
									<i style="display: none;" class="fas fa-check-circle"></i>
									<i style="display: none;" class="fas fa-times-circle"></i>
								</div>
							</div>
							<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
							<p class="column-text">Is your website domain set up correctly?</p>
						</div>
						<div class="middle-column">
							<div class="pass-fail">
								<div class="pass-fail-inner">
									<p class="industry-score">86.9%</p>
									<i class="fas fa-caret-up"></i>
								</div>
							</div>
							<div class="pass-fail-bar industry-bar"><div style="width: 86.9%;" class="colored-bar-two"></div></div>
							<p class="column-text">Of hospitals have their domain set up correctly</p>
						</div>
						<div class="middle-column">
							<div class="stats-row">
								<p class="yearly-stat">83.3%</p>
								<p class="stat-year">2019</p>
							</div>
							<div class="stats-row">
								<p class="yearly-stat">84.2%</p>
								<p class="stat-year">2018</p>
							</div>
							<div class="stats-row">
								<p class="yearly-stat">70.9%</p>
								<p class="stat-year">2017</p>
							</div>
						</div>
					</div>
					<div class="bottom-row">
						<p class="text-title"><b>Bottom Line</b></p>
						<p>After a dip in 2019, there was a 4% increase in 2020 in the number of practices that have their URL set up correctly, mostly owing to Google’s penalizing of those who do not. 100% of iVET360’s clients have their domains done right.</p>
					</div>
					<div class="hidden-row" style="max-height: 0;">
						<p class="text-title"><b>The What</b></p>
						<p>It’s one of the most basic—but important—must-haves: a website domain that is set up correctly. Luckily, it appears most practices have accomplished this, but still too many have not.</p>
						<p>When your site’s domain isn’t set up properly, you essentially have two versions of your website on the internet competing with each other. One has a “www.” in front of the URL, the other does not. Google sees this is duplicate content and lowers the value of your SEO.</p>
						<p class="text-title"><b>The Why</b></p>
						<p>It’s likely the 13% of practices with a faulty domain set-up did not install their SSL certificates correctly. That usually results in a “separation of domains”, where one is secure and the other is not. Neither will redirect to the other, unfortunately.</p>
						<p class="text-title"><b>The How</b></p>
						<p>Check and make sure your website domain is set up correctly by typing your domain name into your browser’s address bar including the “www.” (for example: www.YourHospitalName.com). Once the page loads completely, remove the www. from the address bar and hit return. If your domain reloads and displays without the www. (as “YourHospitalName.com”), your website is duplicated. This is detrimental. If it reloads with the www. automatically, you are set up correctly.</p>
						<p>This also works vice versa with the www. redirecting to no www. The important thing is to not have both versions load. If you or your developer has added an SSL certification to your website, type in “http://” before your domain name. Your website should automatically reload to “https://” if the certificate was installed correctly.</p>
						<p>Both issues are pretty technical, so talk to your web developer ASAP. If you don’t have one, you can fix the “www.” redirect by using this link from <a href="https://tribulant.com/docs/hosting-domains/hosting/9867/redirecting-to-www-or-non-www/" target="_blank">Tribulant</a> to set up the DNS record yourself. For the incorrect SSL installation, you’ll need to contact your service provider if you don’t have a developer.</p>
					</div>
				</div>

				<div class="dp-container">
					<div class="top-row">
						<h4 class="dp-title">MOBILE RESPONSIVE WEBSITE</h4>
						<div class="learn-more">
							<p>Learn More</p>
							<div class="plus-minus-box">
								<span></span><span></span>
							</div>
						</div>
					</div>
					<div class="middle-row">
						<div class="middle-column">
							<div class="pass-fail">
								<div class="pass-fail-inner">
									<p class="hospital-score"><?php echo $_GET['responsive'] ?></p>
									<i style="display: none;" class="fas fa-check-circle"></i>
									<i style="display: none;" class="fas fa-times-circle"></i>
								</div>
							</div>
							<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
							<p class="column-text">Do you have a mobile responsive website?</p>
						</div>
						<div class="middle-column">
							<div class="pass-fail">
								<div class="pass-fail-inner">
									<p class="industry-score">94.1%</p>
									<i class="fas fa-caret-up"></i>
								</div>
							</div>
							<div class="pass-fail-bar industry-bar"><div style="width: 94.1%;" class="colored-bar-two"></div></div>
							<p class="column-text">Have a mobile responsive website</p>
						</div>
						<div class="middle-column">
							<div class="stats-row">
								<p class="yearly-stat">93.9%</p>
								<p class="stat-year">2019</p>
							</div>
							<div class="stats-row">
								<p class="yearly-stat">93.2%</p>
								<p class="stat-year">2018</p>
							</div>
							<div class="stats-row">
								<p class="yearly-stat">85.2%</p>
								<p class="stat-year">2017</p>
							</div>
						</div>
					</div>
					<div class="bottom-row">
						<p class="text-title"><b>Bottom Line</b></p>
						<p>Google punishes websites that aren’t mobile-friendly, so it’s no surprise that the numbers inch closer to 100% every year. 100% of iVET360 clients have a responsive website.</p>
					</div>
					<div class="hidden-row" style="max-height: 0;">
						<p class="text-title"><b>The What</b></p>
						<p>Mobile searches have increased by a consistent 50% every year. This means your current and potential clients are most likely going to look for, and find, a veterinarian using their phone or tablet.</p>
						<p>With the number of varied devices people use to access the internet—and to search for veterinary hospitals—it is incredibly important for a website to “look right” and be easily navigated whether someone is using a cell phone, a tablet, or plain old desktop.  For you, this means that the backend of your website needs to be adjusted so that it is responsive—meaning it can change depending on the device used.</p>
						<p>If that wasn’t enough, Google has also been penalizing non-mobile-friendly sites since 2015. This means that not only is the user experience poor, but search rankings will suffer as well.</p>
						<p class="text-title"><b>The Why</b></p>
						<p>This metric has inched closer and closer to 100 percent for the past three years. With the continued push by Google to be Mobile First, we don’t foresee this metric declining. This simple-yet-important step is critical in our digital, phone-driven age, and while it seems the industry has plateaued again this year, we still believe every veterinary practice should have a responsive website.</p>
						<p class="text-title"><b>The How</b></p>
						<p>To check if your website is responsive, visit <a href="https://search.google.com/test/mobile-friendly" target="_blank">Google’s mobile-friendly test page</a> and enter your veterinary hospital’s website address. Google will do the rest.</p>
					</div>
				</div>

				<div class="dp-container">
					<div class="top-row">
						<h4 class="dp-title">SSL CERTIFICATES</h4>
						<div class="learn-more">
							<p>Learn More</p>
							<div class="plus-minus-box">
								<span></span><span></span>
							</div>
						</div>
					</div>
					<div class="middle-row">
						<div class="middle-column">
							<div class="pass-fail">
								<div class="pass-fail-inner">
									<p class="hospital-score"><?php echo $_GET['ssl'] ?></p>
									<i style="display: none;" class="fas fa-check-circle"></i>
									<i style="display: none;" class="fas fa-times-circle"></i>
								</div>
							</div>
							<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
							<p class="column-text">Do you have a secure website?</p>
						</div>
						<div class="middle-column">
							<div class="pass-fail">
								<div class="pass-fail-inner">
									<p class="industry-score">83.2%</p>
									<i class="fas fa-caret-up"></i>
								</div>
							</div>
							<div class="pass-fail-bar industry-bar"><div style="width: 83.2%;" class="colored-bar-two"></div></div>
							<p class="column-text">Have a secure website</p>
						</div>
						<div class="middle-column">
							<div class="stats-row">
								<p class="yearly-stat">73.4%</p>
								<p class="stat-year">2019</p>
							</div>
							<div class="stats-row">
								<p class="yearly-stat">44.6%</p>
								<p class="stat-year">2018</p>
							</div>
							<div class="stats-row">
								<p class="yearly-stat">3.9%</p>
								<p class="stat-year">2017</p>
							</div>
						</div>
					</div>
					<div class="bottom-row">
						<p class="text-title"><b>Bottom Line</b></p>
						<p>The industry saw a 13% increase in SSL certificate compliance, which is not surprising given the increased emphasis on website security. 100% of iVET360 clients have a secure website.</p>
					</div>
					<div class="hidden-row" style="max-height: 0;">
						<p class="text-title"><b>The What</b></p>
						<p>The breakdown for website security is simple: hyperlinks on safe pages begin with “https,” while unsafe pages begin with “http.” To make it easier to remember, think of the extra “s” in https pages as standing for “secure.”</p>
						<p>Encrypted (secure) websites are guaranteed safe for people to visit without fear of being attacked by viruses. Without encryption, visitors on your site are vulnerable to online hackers who can access their personal information. To help the public determine whether they should venture onto an unfamiliar site, Google has placed a “Not Secure” warning on the left side of the address bar whenever the user enters an unencrypted site.</p>
						<p>If that pops up when pet owners go to your site, it could seriously hurt your client growth and retention. Not only will the visitor avoid entering any information (whether in a comment box or appointment portal), they may also conclude that you don’t value the safety or privacy of others. If that’s the case, then how could they trust you with a pet they love?</p>
						<p class="text-title"><b>The Why</b></p>
						<p>While our numbers show a dramatic increase in secure websites for the fourth year in a row, there are still a number of hospitals who have not taken the important step of encrypting their website. Thankfully, major website providers in the industry now usually add the SSL certificate on their client’s sites without charging an extra fee. We expect SSL compliance to be near 100% by next year.</p>
						<p class="text-title"><b>The How</b></p>
						<p>Check if your website is secure by pulling up your veterinary hospital’s website. If there is a lock symbol in front of your domain name in the address bar, you’re good. This will be present on all major browsers, including Chrome, Firefox, and Safari. If there is not a lock symbol, or if you see the words “Not Secure” preceding your hyperlink, your website is not secure.</p>
						<p><b>How to fix this:</b> <a href="https://ivet360.com/secure-veterinary-websites/" target="_blank">Read our article here on all things SSL</a></p>
					</div>
				</div>

				<div class="dp-container">
					<div class="top-row">
						<h4 class="dp-title">SEARCH ENGINE OPTIMIZATION (SEO)</h4>
						<div class="learn-more">
							<p>Learn More</p>
							<div class="plus-minus-box">
								<span></span><span></span>
							</div>
						</div>
					</div>
					<div class="middle-row">
						<div class="middle-column">
							<div class="pass-fail">
								<div class="pass-fail-inner">
									<p class="hospital-score"><?php echo $_GET['seo'] ?></p>
									<i style="display: none;" class="fas fa-check-circle"></i>
									<i style="display: none;" class="fas fa-times-circle"></i>
								</div>
							</div>
							<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
							<p class="column-text">Is your SEO optimized?</p>
						</div>
						<div class="middle-column">
							<div class="pass-fail">
								<div class="pass-fail-inner">
									<p class="industry-score">18.2%</p>
									<i class="fas fa-caret-down"></i>
								</div>
							</div>
							<div class="pass-fail-bar industry-bar"><div style="width: 18.2%;" class="colored-bar-two"></div></div>
							<p class="column-text">Have an SEO optimized website</p>
						</div>
						<div class="middle-column">
							<div class="stats-row">
								<p class="yearly-stat">18.5%</p>
								<p class="stat-year">2019</p>
							</div>
							<div class="stats-row">
								<p class="yearly-stat">17.5%</p>
								<p class="stat-year">2018</p>
							</div>
							<div class="stats-row">
								<p class="yearly-stat">36.7%</p>
								<p class="stat-year">2017</p>
							</div>
						</div>
					</div>
					<div class="bottom-row">
						<p class="text-title"><b>Bottom Line</b></p>
						<p>Prioritizing the look of a website over performance as well as the prevalence of DIY sites means that SEO is often neglected. 100% of iVET360’s clients have websites with optimized SEO.</p>
					</div>
					<div class="hidden-row" style="max-height: 0;">
						<p class="text-title"><b>The What</b></p>
						<p>No matter how great your site looks it won’t matter if it never shows up in a top position when people are searching for a vet in their area. SEO is about making sure that happens.</p>
						<p>Proper SEO is the foundation for effective marketing, and if your veterinary website is struggling to rank on Google, this will undoubtedly affect your visibility and client count.</p>
						<p>When it is optimized, SEO can ensure your page gets maximum visibility and there are two parts to it: <a href="https://www.w3schools.com/tags/tag_title.asp" target="_blank">title tags</a> and <a href="https://www.w3schools.com/tags/tag_meta.asp" target="_blank">meta descriptions</a>. Not only do they need to be set up, but they should be in some way unique.</p>
						<p class="text-title"><b>The Why</b></p>
						<p>One major reason for the stagnation and decline in the industry’s SEO optimization is because many practices have changed providers. They often do this based on the promise of a flashy new website— but without the necessary back end SEO work, that beautiful site won’t get any more traffic than the old one.</p>
						<p>The increased use of free platforms such as Wix, Weebly or SquareSpace to build sites is also a culprit for the lapse in SEO. With these sites, it is incredibly hard, if not impossible, to input unique SEO modifications, which creates a major pitfall when creating sites with these platforms.</p>
						<p class="text-title"><b>The How</b></p>
						<p>This one is a bit more challenging, as you need to download a program to review these stats. <a href="https://www.screamingfrog.co.uk/seo-spider/" target="_blank">Screaming Frog</a> is a free tool for reviewing the backend of websites, including SEO. Once you’ve installed it, simply type your hospital URL into the search field and let the program do the rest. It will highlight all missing or duplicate titles/descriptions as well as many other SEO components.</p>
					</div>
				</div>

				<div class="dp-container">
					<div class="top-row">
						<h4 class="dp-title">GOOGLE ANALYTICS</h4>
						<div class="learn-more">
							<p>Learn More</p>
							<div class="plus-minus-box">
								<span></span><span></span>
							</div>
						</div>
					</div>
					<div class="middle-row">
						<div class="middle-column">
							<div class="pass-fail">
								<div class="pass-fail-inner">
									<p class="hospital-score"><?php echo $_GET['analytics'] ?></p>
									<i style="display: none;" class="fas fa-check-circle"></i>
									<i style="display: none;" class="fas fa-times-circle"></i>
								</div>
							</div>
							<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
							<p class="column-text">Do you have Google Analytics installed?</p>
						</div>
						<div class="middle-column">
							<div class="pass-fail">
								<div class="pass-fail-inner">
									<p class="industry-score">83.4%</p>
									<i class="fas fa-caret-up"></i>
								</div>
							</div>
							<div class="pass-fail-bar industry-bar"><div style="width: 83.4%;" class="colored-bar-two"></div></div>
							<p class="column-text">Have Google Analytics installed</p>
						</div>
						<div class="middle-column">
							<div class="stats-row">
								<p class="yearly-stat">83.2%</p>
								<p class="stat-year">2019</p>
							</div>
							<div class="stats-row">
								<p class="yearly-stat">77.9%</p>
								<p class="stat-year">2018</p>
							</div>
							<div class="stats-row">
								<p class="yearly-stat">69.7%</p>
								<p class="stat-year">2017</p>
							</div>
						</div>
					</div>
					<div class="bottom-row">
						<p class="text-title"><b>Bottom Line</b></p>
						<p>The industry saw some slight growth in installations over last year, but it’s still not what it should be given the value of this free tool to your marketing efforts. 100% of iVET360 clients utilize Google Analytics.</p>
					</div>
					<div class="hidden-row" style="max-height: 0;">
						<p class="text-title"><b>The What</b></p>
						<p>Google Analytics gives you invaluable information about your website, including:</p>
						<ul>
							<li><b>How many people are visiting and when</b></li>
							<li><b>What they searched to get to your site</b></li>
							<li><b>How far down visitors are scrolling</b></li>
							<li><b>The most popular pages</b></li>
						</ul>
						<p>With this data, you can create an efficient and effective marketing plan based on reality, rather than just a guess. It will also show you which pages are getting more or less traffic than you’d prefer so they can be fine-tuned to get the results you’re after.</p>
						<p class="text-title"><b>The Why</b></p>
						<p>Every single website should have Google Analytics installed! While there continues to be an incremental increase, the number of practices utilizing this vital—and FREE—tool is still well below what it should be. Without GA, your marketing plan will lack focus and precision.</p>
						<p class="text-title"><b>The How</b></p>
						<p>There are two ways to check to see if you have Google Analytics on your website.</p>
						<p><b>Option 1:</b> Visit the Google Analytics webpage and log into your Google account. You’ll see the domains for which you control Google Analytics—unless your website was built by a third party. In that case, they will have the access.</p>
						<p><b>Option 2:</b> While on your website, the keyboard shortcut is Command + U (or CTRL + U on PC). For Chrome, navigate to “View” and then click on “Developer” and then “View Source.” While reviewing the code, search for “UA” on the page. If you see something along the lines of “UA-45947023-1” then you’re set. If nothing comes up, you’re probably not tracking website visitors.</p>
						<p><b>Option 2:</b> <a href="https://support.google.com/analytics/answer/1008015?hl=en" target="_blank">Google provides a step-by-step guide here.</a></p>
					</div>
				</div>

				<div class="dp-container">
					<div class="top-row">
						<h4 class="dp-title">ADA ACCESSIBILITY</h4>
						<div class="learn-more">
							<p>Learn More</p>
							<div class="plus-minus-box">
								<span></span><span></span>
							</div>
						</div>
					</div>
					<div class="middle-row">
						<div class="middle-column">
							<div class="pass-fail">
								<div class="pass-fail-inner">
									<p class="hospital-score"><?php echo $_GET['ada'] ?></p>
									<i style="display: none;" class="fas fa-check-circle"></i>
									<i style="display: none;" class="fas fa-times-circle"></i>
								</div>
							</div>
							<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
							<p class="column-text">Do you have a ADA compliant website?</p>
						</div>
						<div class="middle-column">
							<div class="pass-fail">
								<div class="pass-fail-inner">
									<p class="industry-score">52.2%</p>
									<i class="fas fa-caret-up"></i>
								</div>
							</div>
							<div class="pass-fail-bar industry-bar"><div style="width: 52.2%;" class="colored-bar-two"></div></div>
							<p class="column-text">Have an ADA compliant website</p>
						</div>
						<div class="middle-column">
							<div class="stats-row">
								<p class="yearly-stat">46.6%</p>
								<p class="stat-year">2019</p>
							</div>
							<div class="stats-row">
								<p class="yearly-stat">N/A</p>
								<p class="stat-year">2018</p>
							</div>
							<div class="stats-row">
								<p class="yearly-stat">N/A</p>
								<p class="stat-year">2017</p>
							</div>
						</div>
					</div>
					<div class="bottom-row">
						<p class="text-title"><b>Bottom Line</b></p>
						<p>There’s been a 12% increase in website accessibility, which is going to become increasingly important for the veterinary industry as the population ages. 100% of iVET360 clients have complete ADA compliance on their websites.</p>
					</div>
					<div class="hidden-row" style="max-height: 0;">
						<p class="text-title"><b>The What</b></p>
						<p>The Americans with Disabilities Act (ADA) is a civil rights law that prohibits discrimination (intentional or not) against people with disabilities in all areas of public life, ensuring equal opportunity. Because this act was signed before the advent of the internet, the rules of how it should apply to publicly accessed websites are unclear, but it is agreed that digital accessibility is an absolute necessity.</p>
						<p>Currently, just over half of websites in the industry are ADA compliant and accessible, which isn’t great when you consider that the heart of this industry is helping people and their pets—some of which may be service animals that aid in accessibility themselves.</p>
						<p class="text-title"><b>The Why</b></p>
						<p>The benefits of building a website following ADA guidelines are greater than just meeting the law.
							By making your site accessible, you are making it possible and easier for people to access the information on your website, and to do so with increased ease. Showing the public that you are aware of differences in ability and functionality is also a good representation of how well you’ll care for their pets.</p>
							<p class="text-title"><b>The How</b></p>
							<p>Beyond ADA compliance, which covers basic functions like alternative text for images, iVET360 has created a metric with complete accessibility in mind, a distinction which is often missed. For example, your site should be able to flip its content to be accessible to multiple audiences.</p>
							<p>To check if your website is ADA compliant, you can run it through this <a href="https://adascan.app/" target="_blank">free online tool.</a></p>
							<p>Accessible features can be difficult to implement on websites that are already up and running. It would be best to talk to your provider to see if they are able to reconfigure the necessary HTML. We also recommend this <a href="https://userway.org/" target="_blank">free website plug-in.</a></p>
						</div>
					</div>

					<div class="dp-container">
						<div class="top-row">
							<h4 class="dp-title">WEBSITE PAGE SPEED</h4>
							<div class="learn-more">
								<p>Learn More</p>
								<div class="plus-minus-box">
									<span></span><span></span>
								</div>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['4g'] ?><span style="text-transform: lowercase;">s</span></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">Your website load time</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">4.2<span style="text-transform: lowercase;">s</span></p>
										<i class="fas fa-caret-up"></i>
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 100%;" class="colored-bar-two"></div></div>
								<p class="column-text">Average website load time</p>
							</div>
							<div class="middle-column">
								<div class="stats-row">
									<p class="yearly-stat">3.9s</p>
									<p class="stat-year">2019</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">N/A</p>
									<p class="stat-year">2018</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">N/A</p>
									<p class="stat-year">2017</p>
								</div>
							</div>
						</div>
						<div class="bottom-row">
							<p class="text-title"><b>Bottom Line</b></p>
							<p>The veterinary industry is currently sitting at an average loading speed of just over 4 seconds (an 6% increase over 2019). It’s been found that by that time, 24% of potential visitors have left the site. The average speed of iVET360 client websites is 2.9 seconds.</p>
						</div>
						<div class="hidden-row" style="max-height: 0;">
							<p class="text-title"><b>The What</b></p>
							<p>Data-consuming images and videos are a large reason why the veterinary industry isn’t up to Google’s standard. While everyone loves seeing running puppies and adorable kittens pawing at the screen, what’s more important is that your clients don’t wait so long to see what they really came for— information about your services and how to reach you.</p>
							<p class="text-title"><b>The Why</b></p>
							<p>In addition to losing impatient clients, a slow website load also hurts you with Google, who uses it as a metric when determining search results. Google prioritizes the speed of a site on mobile devices over desktop—a speed they’d still like to be between 0-2.5 seconds.</p>
							<p>While that “two-second rule” is a good thing theoretically, all you need to be sure of is that your site is at least on the faster side of the average for veterinary hospitals so that your competitors don’t start out-ranking you on Google. The trick is to stop comparing your website with the one for the brewpub down the street--it’s apples and oranges.</p>
							<p class="text-title"><b>The How</b></p>
							<p>Check your website’s speed using this <a href="https://www.thinkwithgoogle.com/feature/testmysite/" target="_blank">online tool</a>. Once you test your site speed, Google will provide a detailed report on how to fix the issues that are slowing down your site as well as providing a link to share with your current webmaster. The best part, like with most things Google, is that it’s free.</p>
						</div>
					</div>

					<div class="dp-container" id="website-exp-container">
						<div class="top-row">
							<h4 class="dp-title">WEBSITE EXPERIENCE</h4>
							<div class="learn-more">
								<p>Learn More</p>
								<div class="plus-minus-box">
									<span></span><span></span>
								</div>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['exp_performance'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">YOUR PERFORMANCE SCORE</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">37</p>
										<!-- <i class="fas fa-caret-up"></i> -->
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 37%;" class="colored-bar-two"></div></div>
								<p class="column-text">AVERAGE PERFORMANCE SCORE</p>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['exp_access'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">YOUR ACCESSIBILITY SCORE</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">83</p>
										<!-- <i class="fas fa-caret-up"></i> -->
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 83%;" class="colored-bar-two"></div></div>
								<p class="column-text">AVERAGE ACCESSIBILITY SCORE</p>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['exp_practices'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">YOUR BEST PRACTICES SCORE</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">73</p>
										<!-- <i class="fas fa-caret-up"></i> -->
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 73%;" class="colored-bar-two"></div></div>
								<p class="column-text">AVERAGE BEST PRACTICES SCORE</p>
							</div>
							<!-- <div class="middle-column">
							</div> -->
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['exp_seo'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">YOUR SEO SCORE</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">86</p>
										<!-- <i class="fas fa-caret-up"></i> -->
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 86%;" class="colored-bar-two"></div></div>
								<p class="column-text">AVERAGE SEO SCORE</p>
							</div>
							<!-- <div class="middle-column">
							</div> -->
						</div>
						<div class="bottom-row">
							<p class="text-title"><b>Bottom Line</b></p>
							<p>These new auditing tools pinpoint exactly what your website needs to run fast and effectively. iVET360 client websites score above the industry average for all metrics: 72 in Performance, 92 in Accessibility, 85 in Best Practices, and 91 in SEO.</p>
						</div>
						<div class="hidden-row" style="max-height: 0;">
							<p class="text-title"><b>The What</b></p>
							<p>These new Lighthouse Web.Dev audits from Google are specific to your website’s most important page—your homepage—and measure how well that “front door” of your site is performing based on key metrics.</p>
							<p class="text-title"><b>The How</b></p>
							<p>This is all pretty technical stuff, so if you built your own site you may want to enlist the help of a web developer to run these free diagnostics and assist with correcting what you can within the parameters of the tool used to create the site.</p>
							<p>Otherwise, make sure your provider runs these tests to see where your site lands for these key metrics. They may tell you that the beautiful site they built for you is at 100% performance, but the Web.Dev tools below will show you the real story.</p>
							<ul>
								<li><b><a href="https://web.dev/lighthouse-performance/" target="_blank">Audit for Website Performance</a></b></li>
								<li><b><a href="https://web.dev/lighthouse-accessibility/" target="_blank">Audit for Accessibility</a></b></li>
								<li><b><a href="https://web.dev/lighthouse-best-practices/" target="_blank">Audit for Best Practices</a></b></li>
								<li><b><a href="https://web.dev/lighthouse-seo/" target="_blank">Audit for SEO</a></b></li>
							</ul>
						</div>
					</div>
					<?php if ($_GET['website_cta'] == "Yes") { ?>
					<div class="cta-box">
						<div class="cta-inner">
							<h2>Get a custom website in <span class="cta-teal">7 days</span></h2>
							<p>The truth is, your website isn’t what it needs to be for potential new clients and the ones you’ve already got. We can help.</p>
							<a href="https://ivet360.com/introduction/?utm_source=vmbr&utm_medium=web&utm_campaign=vmbr-website" target="_blank">Tell Me More</a>
						</div>
					</div>
					<?php } ?>
					<?php if ($_GET['marketing_cta'] == "Yes") { ?>
					<div class="cta-box">
						<div class="cta-inner">
							<h2>effective marketing with iVET360</h2>
							<p>This custom report tells us what you already know: that your online presence and digital marketing isn’t what it needs to be if your practice is going to thrive. Let us show you how to make marketing more effective, less expensive, and easier.</p>
							<a href="https://ivet360.com/introduction/?utm_source=vmbr&utm_medium=web&utm_campaign=vmbr-marketing" target="_blank">Help Me Grow</a>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>

			<div class="section-container" id="google-container">
				<div class="intro-container google-pattern" id="google-report">
					<div class="text-container">
						<img src="/wp-content/uploads/2020/10/iVET-VMBR-icon-google.svg" alt="Google Icon">
						<h2>Google My Business</h2>
					</div>
				</div>
				<div class="section-inner-container">
					<div class="section-intro-text">
						<h3>Understanding the Data</h3>
						<p>Google remains the 800-pound gorilla of search engines, so as the marketplace becomes more crowded it’s important you do everything possible to let Google know you matter and belong in their search results. The best way to do this is with the Google My Business (GMB) Knowledge Panel.</p>
						<p>The GMB Knowledge Panel is kind of like a mini website that pops up on the right of the search results page when someone searches for your practice specifically. This panel shows searchers your hours, location, phone, ratings & reviews from clients, has a link to your website, and Q & A feature where you can answer questions about your practice directly.</p>
						<p>It’s no exaggeration to say that with this Knowledge Panel, Google is becoming more valuable than your practice website: Google itself has more users, a larger variety of them, and subsequently has greater visibility and gets many more reviews than other platforms. We’ll spend a lot of time in this report talking about Google’s features because frankly, that’s how important we feel maximizing this search engine’s tools are to your practice’s marketing efforts.</p>
					</div>

					<div class="dp-container">
						<div class="top-row">
							<h4 class="dp-title">GOOGLE REVIEWS</h4>
							<div class="learn-more">
								<p>Learn More</p>
								<div class="plus-minus-box">
									<span></span><span></span>
								</div>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['g_reviews'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">Number of reviews on Google</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">165</p>
										<i class="fas fa-caret-up"></i>
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 100%;" class="colored-bar-two"></div></div>
								<p class="column-text">Google reviews for the average veterinary hospital</p>
							</div>
							<div class="middle-column">
								<div class="stats-row">
									<p class="yearly-stat">115</p>
									<p class="stat-year">2019</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">73</p>
									<p class="stat-year">2018</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">40</p>
									<p class="stat-year">2017</p>
								</div>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['g_star'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">YOUR STAR RATING (OUT OF 5)</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">4.6</p>
										<!-- <i class="fas fa-caret-up"></i> -->
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 100%;" class="colored-bar-two"></div></div>
								<p class="column-text">AVERAGE STAR RATING (OUT OF 5)</p>
							</div>
							<div class="middle-column">
							</div>
						</div>
						<div class="bottom-row">
							<p class="text-title"><b>Bottom Line</b></p>
							<p>The industry saw a 43% increase in the number of reviews over last year, part of a promising 125% over the past two years. iVET360 clients average 155 reviews and a 4.7 rating.</p>
						</div>
						<div class="hidden-row" style="max-height: 0;">
							<p class="text-title"><b>The What</b></p>
							<p>Reviews and ratings matter for so many reasons. Ratings give you and your potential clients an at- a-glance idea of how your practice is perceived, while reviews give you details. Ratings and reviews also play a major role in where your business is located on the Google search results page, as the rating and a link to reviews are at the top of the Knowledge Panel. The more reviews you have, and the higher the average number of stars, the more attractive you’ll appear to pet parents...and Google knows that.</p>
							<p>While Google’s algorithm for search results is complicated, the number of ratings and reviews—along with proximity to the person searching—weigh heaviest when it comes to determining your placement in search results. That being said, a veterinarian with only 6 Google reviews who is only five miles away will be placed after the practice that’s 10 miles away but has 40 reviews.</p>
							<p>Also keep in mind that while most social media platforms have a ratings and/or reviews feature, Google is likely to be more accurate in its assessment of your practice. This is because Google has the largest number and variety of users, and therefore a greater number of reviews--the average practice received 4.2 new Google reviews every month during 2020. That’s a 20% increase over last year.</p>
							<p class="text-title"><b>The How</b></p>
							<p>How to gain more Google ratings and reviews: Ask your clients. Your hospital sees many people every day, and a simple request to review your services goes a long way in growing your online reviews. You can do this one-on-one, or with in-hospital reminder signs in waiting areas and on statements.</p>
						</div>
					</div>

					<div class="dp-container">
						<div class="top-row">
							<h4 class="dp-title">GMB CLAIMED</h4>
							<div class="learn-more">
								<p>Learn More</p>
								<div class="plus-minus-box">
									<span></span><span></span>
								</div>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['gmb_claimed'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">Have you claimed your GMB listing?</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">89%</p>
										<i class="fas fa-caret-down"></i>
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 89%;" class="colored-bar-two"></div></div>
								<p class="column-text">Of hospitals have claimed their GMB listing</p>
							</div>
							<div class="middle-column">
								<div class="stats-row">
									<p class="yearly-stat">92.5%</p>
									<p class="stat-year">2019</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">91.7%</p>
									<p class="stat-year">2018</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">90.8%</p>
									<p class="stat-year">2017</p>
								</div>
							</div>
						</div>
						<div class="bottom-row">
							<p class="text-title"><b>Bottom Line</b></p>
							<p>There’s been a 4% decline this year and that’s likely due to practices switching providers and not requesting their local listing login credentials. 100% of iVET360’s clients are verified on GMB.</p>
						</div>
						<div class="hidden-row" style="max-height: 0;">
							<p class="text-title"><b>The What</b></p>
							<p>By verifying your practice with Google My Business, you gain control of how your information appears on Google—this includes your hours, phone number, photos and more. As long as you are a representative of your hospital, there are several ways you can verify—or “claim”—your listing. There’s no reason a practice should not be verified on Google, and thankfully the %age of practices who are has continued to grow.</p>
							<p class="text-title"><b>The Why</b></p>
							<p>When practices fail to claim their listing on GMB, basic information such as changes in hours of operation—something that has been very common during the pandemic—are often inaccurate. With a claimed Google listing, you can edit your hours whenever you need, instead of leaving your clients guessing. There are also other important features you can add for clients that we’ll discuss later in this report.</p>
							<p class="text-title"><b>The How</b></p>
							<p>You can verify your Google listing easily by phone, email or even snail mail. If your hospital is eligible to be verified by phone, you’ll see the “Verify by phone” option when you request verification. From there, sign in to Google My Business and click “Verify now.” Google will then call your hospital and give you a verification code. Now enter the code from the message.</p>
							<p>If you’re eligible to be verified by email, first make sure you can access the email address shown in the verification screen. Now go to Google My Business and click “Verify now” then click “Email” from the list of verification options. You will then be sent an email which contains the “Verify” button.</p>
							<p>To verify your business listing by regular mail, sign in to Google My Business. On the postcard request screen, check if your address is correct. If it isn’t, edit the address before requesting your letter. Now click “Send postcard.” Check the mail for your postcard, which should arrive within 14 days. This postcard will contain a Google Verification code. On your Google My Business account, click the “Verify now” button, then enter your code in the code field.</p>
						</div>
					</div>

					<div class="dp-container">
						<div class="top-row">
							<h4 class="dp-title">GMB APPOINTMENT LINK</h4>
							<div class="learn-more">
								<p>Learn More</p>
								<div class="plus-minus-box">
									<span></span><span></span>
								</div>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['gmb_appt'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">Do you have a GMB appointment link?</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">28.8%</p>
										<i class="fas fa-caret-up"></i>
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 28.8%;" class="colored-bar-two"></div></div>
								<p class="column-text">Of hospitals have a GMB appointment link</p>
							</div>
							<div class="middle-column">
								<div class="stats-row">
									<p class="yearly-stat">22.6%</p>
									<p class="stat-year">2019</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">14.7%</p>
									<p class="stat-year">2018</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">N/A</p>
									<p class="stat-year">2017</p>
								</div>
							</div>
						</div>
						<div class="bottom-row">
							<p class="text-title"><b>Bottom Line</b></p>
							<p>The industry saw an over 27% increase in the number of hospitals using the appointment link, which is a must-have feature in a world dominated by cell phones. 100% of iVET360 clients use this free tool.</p>
						</div>
						<div class="hidden-row" style="max-height: 0;">
							<p class="text-title"><b>The What</b></p>
							<p>The goal of your Google Knowledge Panel is for it to be so chock full of genuine information about your practice that clients would feel comfortable making an appointment then and there. Luckily, there’s a feature right in your Knowledge Panel specifically for that purpose!</p>
							<p>People like having multiple options for contacting a business, and that’s especially true for those who are searching for a veterinary hospital by cell (these days, that’s most people). In fact, Google’s research shows that 68% of consumers value the option to either call a business or interact with them online while using their phone. Adding the appointment link makes it that much easier for them to go ahead and schedule a visit for their pet.</p>
							<p>As hospitals devote more time to their Google My Business profiles, awareness is growing about free opportunities and benefits of simple solutions like the appointment link. This would account for the 96% % increase in veterinary hospitals making use of this free and convenient feature in the last two years.</p>
							<p class="text-title"><b>The Why</b></p>
							<p>Hospitals that have set up their appointment link also saw a 2% increase in number of reviews over those that have not. We also found that adding the appointment link drove 15% of the clicks on a business listing, equaling more booked appointments.</p>
							<p class="text-title"><b>The How</b></p>
							<p>Adding an appointment link couldn’t be easier. Sign in to your Google My Business account and choose the “My Business” listing. Then click on the URLs section, which should show you fields where you can add relevant links, including a link to your appointment or contact page.</p>
						</div>
					</div>

					<div class="dp-container">
						<div class="top-row">
							<h4 class="dp-title">GMB QUESTIONS & ANSWERS</h4>
							<div class="learn-more">
								<p>Learn More</p>
								<div class="plus-minus-box">
									<span></span><span></span>
								</div>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['gmb_qa'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">Do you use GMB Questions & Answers?</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">23.9%</p>
										<i class="fas fa-caret-up"></i>
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 23.9%;" class="colored-bar-two"></div></div>
								<p class="column-text">Of hospitals are using GMB Questions & Answers</p>
							</div>
							<div class="middle-column">
								<div class="stats-row">
									<p class="yearly-stat">17.1%</p>
									<p class="stat-year">2019</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">5.3%</p>
									<p class="stat-year">2018</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">N/A</p>
									<p class="stat-year">2017</p>
								</div>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['gmb_ques'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">YOUR NUMBER OF GMB QUESTIONS</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">4</p>
										<i class="fas fa-caret-up"></i>
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 100%;" class="colored-bar-two"></div></div>
								<p class="column-text">AVERAGE NUMBER OF GMB QUESTIONS</p>
							</div>
							<div class="middle-column">
							</div>
						</div>
						<div class="bottom-row">
							<p class="text-title"><b>Bottom Line</b></p>
							<p>This feature has shown a nearly 40% growth in the last year, and 351% in the last two years. There’s also been an increase of 75% of average number of questions asked. 46.7% of iVET360 clients make use of this tool and average 5 questions.</p>
						</div>
						<div class="hidden-row" style="max-height: 0;">
							<p class="text-title"><b>The What</b></p>
							<p>Displayed within your Google Knowledge Panel, Google Questions and Answers allows any user to easily ask questions related to your practice. This is a useful tool for informing and interacting with the public. If ignored or employed improperly, though, this forum-style feature could easily have negative consequences.</p>
							<p>One way to use Google Q&A as an effective marketing tool is to populate the section with your own questions and answers—almost like an FAQ. Not only does this get information out faster, it also creates awareness about specific services or features of your hospital—such as the fact that you treat birds or offer acupuncture.</p>
							<p>The problem is, if you aren’t actively replying to the questions people leave, anyone else can answer them. By being proactive and answering these questions right away, you can prevent this issue from the get-go, while also making current and potential clients feel valued.</p>
							<p class="text-title"><b>The Why</b></p>
							<p>Hospitals that answer Google Q&A saw a 5% increase in the number of reviews over those that did not. The spike in Google Q&A metrics comes mainly from the consumer. People are getting more familiar with this platform as a place to to find answers to their questions. In fact, the average hospital has no less than three questions posted and ready to answer, and people who receive responses are statistically more likely to call the practice to follow up on their questions.</p>
							<p class="text-title"><b>The How</b></p>
							<p>To manage Google Q&A, sign in to your Google My Business account. Then navigate to your Google Knowledge Panel by searching or simply using your Google Short Name. After clicking into “See all questions” under the “Questions & Answers” section, you will be able to reply to questions, ask your own and upvote the accurate and relevant questions and answers about your hospital.</p>
						</div>
					</div>

					<div class="dp-container">
						<div class="top-row">
							<h4 class="dp-title">GMB POSTS</h4>
							<div class="learn-more">
								<p>Learn More</p>
								<div class="plus-minus-box">
									<span></span><span></span>
								</div>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['gmb_posts'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">Are you utilizing Google Posts?</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">32.9%</p>
										<i class="fas fa-caret-up"></i>
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 32.9%;" class="colored-bar-two"></div></div>
								<p class="column-text">Are utilizing Google My Business Posts</p>
							</div>
							<div class="middle-column">
								<div class="stats-row">
									<p class="yearly-stat">21%</p>
									<p class="stat-year">2019</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">10.2%</p>
									<p class="stat-year">2018</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">1.7%</p>
									<p class="stat-year">2017</p>
								</div>
							</div>
						</div>
						<div class="bottom-row">
							<p class="text-title"><b>Bottom Line</b></p>
							<p>The industry has shown a 57% increase in the use of GMB Posts this year, as due to COVID-19 practices are finding this tool. Use has more than tripled in the past two years. 72% of iVET360 clients make use of this tool.</p>
						</div>
						<div class="hidden-row" style="max-height: 0;">
							<p class="text-title"><b>The What</b></p>
							<p>Google Posts illustrates another example of how practices and their clients are using Google more and more. It’s simply easier and faster to update and access information about your hospital there.</p>
							<p>Posts are situated within your Google Knowledge Panel and, in addition to the space for up to 300 words of content, they can include an image and a link with a call to action. This link could send viewers to a blog post, appointment form, or contact page among other destinations, and is a strong marketing tool.</p>
							<p>Most importantly, Google Posts are a way for practices to stand out from the competition. When a client is looking through a listing of hospitals, they’re much more likely to make an appointment at the practice with an offer and an appointment link posted on the Knowledge Panel. Plus, Google rewards the businesses that utilize their free tools, meaning your practice will be found more easily when prospective clients are searching for a new veterinarian in their area.</p>
							<p class="text-title"><b>The Why</b></p>
							<p>Hospitals that utilize Google Posts saw a 2% increase in the number of reviews over those that did not. If it isn’t intuitive that visibility makes a business money, the fact that the use of Google Posts has grown significantly over the past two years should be evidence enough. People are noticing the benefits of posting straight to their Google Knowledge Panel, and it’s worth jumping on the trend now while only a third of the industry is participating in this growth strategy.</p>
							<p class="text-title"><b>The How</b></p>
							<p>How to create a Google Post: Sign in to your Google My Business account. Click “Create post,” or click “Posts” from the menu. On the “Create post” screen, choose which type of post you’d like to create based on the available options, then enter any relevant information. Click “Preview” to see a preview of your post and, if you’re happy with it, click “Publish” in the top right corner of the screen.</p>
						</div>
					</div>

					<div class="dp-container">
						<div class="top-row">
							<h4 class="dp-title">GMB OFFERS</h4>
							<div class="learn-more">
								<p>Learn More</p>
								<div class="plus-minus-box">
									<span></span><span></span>
								</div>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['gmb_offers'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">Are you utilizing Google Offers?</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">5.3%</p>
										<i class="fas fa-caret-up"></i>
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 5.3%;" class="colored-bar-two"></div></div>
								<p class="column-text">Are utilizing Google My Business offers</p>
							</div>
							<div class="middle-column">
								<div class="stats-row">
									<p class="yearly-stat">3.4%</p>
									<p class="stat-year">2019</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">N/A</p>
									<p class="stat-year">2018</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">N/A</p>
									<p class="stat-year">2017</p>
								</div>
							</div>
						</div>
						<div class="bottom-row">
							<p class="text-title"><b>Bottom Line</b></p>
							<p>A significant 56% growth for the Offers tool, but it is still underutilized in our industry. 41.2% of iVET360 clients make use of this tool.</p>
						</div>
						<div class="hidden-row" style="max-height: 0;">
							<p class="text-title"><b>The What</b></p>
							<p>It’s all about placement when it comes to GMB Offers, which are really just a subset of Posts. Instead of sitting on the bottom of the Knowledge Panel, Offers are positioned right beneath the standard business information (i.e. address, hours, phone number etc.). This is only for mobile devices, however—the desktop version will sort the Offers down among the Google Posts.</p>
							<p>This effective tool can be used to promote offers to new clients, making them much more likely to choose your practice over another in their vicinity. We typically recommend the somewhat counterintuitive strategy of placing a Free First Exam offer here.</p>
							<p class="text-title"><b>The Why</b></p>
							<p>Only 5.3% of the industry is currently making use of both Google Posts and Google Offers, so we’re hoping you’ll take advantage of the deficit to increase client growth and engagement. With the incredible amount of time people are spending on their phones instead of laptops or other desk computers, it makes sense to invest in a form of community engagement that is so specifically catered to small products.</p>
							<p class="text-title"><b>The How</b></p>
							<p>To create a Google Offer, follow the instructions for making a Google Post. Make sure you pick the kind of Post that reads “Google Offer” instead of something more simple. When entering information, you’ll be able to add a description of the deal, a coupon code, any terms and conditions that apply to the promo, a phone number and/or a link to a form on their website. We suggest using a tracking number or link here so that you can monitor how many people contact you because of that Offer, which will give you an idea of how effective it is for your hospital.</p>
						</div>
					</div>

					<div class="dp-container">
						<div class="top-row">
							<h4 class="dp-title">GMB DESCRIPTION</h4>
							<div class="learn-more">
								<p>Learn More</p>
								<div class="plus-minus-box">
									<span></span><span></span>
								</div>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['gmb_desc'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">Do you have a GMB Description?</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">44.5%</p>
										<i class="fas fa-caret-up"></i>
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 44.5%;" class="colored-bar-two"></div></div>
								<p class="column-text">Of hospitals have a GMB description</p>
							</div>
							<div class="middle-column">
								<div class="stats-row">
									<p class="yearly-stat">35.6%</p>
									<p class="stat-year">2019</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">12.7%</p>
									<p class="stat-year">2018</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">N/A</p>
									<p class="stat-year">2017</p>
								</div>
							</div>
						</div>
						<div class="bottom-row">
							<p class="text-title"><b>Bottom Line</b></p>
							<p>The industry saw a 25% increase in the number of practices using this easy and effective tool to increase search engine visibility. 100% of iVET360 clients have their description on their Google My Business listing.</p>
						</div>
						<div class="hidden-row" style="max-height: 0;">
							<p class="text-title"><b>The What</b></p>
							<p>Google has an optional section at the bottom of your hospital’s Knowledge Panel that gives you up to 750 characters to talk about your practice in any way you choose—this is the Google My Business Description. If you don’t want to add a general overview of your practice, you can include your mission statement, more information about your doctors, or really anything else you think is important for clients to know about your practice.</p>
							<p>The description should be easy for anyone familiar with your hospital to complete, and it is wonderfully effective—it’s worth an entire 15% of your profile when Google calculates the completion of your profile. The less complete your profile, the lower your practice’s search listing is ranked.</p>
							<p><b>Pro tip:</b> If you don’t see the option to add a description on your Google My Business page, it’s possible your business is incorrectly categorized within Google My Business. This can often be rectified by simply reducing the number of categories your hospital is under. Keeping the category to the most accurate will remove any confusion Google may have about your business, and the Google Description feature should become available.</p>
							<p class="text-title"><b>The Why</b></p>
							<p>Hospitals that have a Google Description saw a 4% increase in the number of ratings and reviews over those that did not.</p>
							<p class="text-title"><b>The How</b></p>
							<p>To add a Google My Business description, log in to your Google My Business account, click on the “Info” button on the menu bar and look for a section labeled “Add business description.” Click on the pencil icon next to that field, which will bring up a menu that will let you enter a brief description of your business.</p>
						</div>
					</div>

					<div class="dp-container">
						<div class="top-row">
							<h4 class="dp-title">GOOGLE SHORT NAME</h4>
							<div class="learn-more">
								<p>Learn More</p>
								<div class="plus-minus-box">
									<span></span><span></span>
								</div>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['gmb_short'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">Do you have a GMB Short Name?</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">23%</p>
										<i class="fas fa-caret-up"></i>
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 23%;" class="colored-bar-two"></div></div>
								<p class="column-text">Of hospitals have a Google Short Name</p>
							</div>
							<div class="middle-column">
								<div class="stats-row">
									<p class="yearly-stat">8.3%</p>
									<p class="stat-year">2019</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">N/A</p>
									<p class="stat-year">2018</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">N/A</p>
									<p class="stat-year">2017</p>
								</div>
							</div>
						</div>
						<div class="bottom-row">
							<p class="text-title"><b>Bottom Line</b></p>
							<p>The industry saw an increase of over 177% in the use of the short name URL. 100% of iVET360 clients have a short name for their Knowledge Panel.</p>
						</div>
						<div class="hidden-row" style="max-height: 0;">
							<p class="text-title"><b>The What</b></p>
							<p>To fully complete your business profile, you should claim a Google Short Name, which will direct current and prospective clients straight to the fabulous Google Knowledge Panel you’ve created.</p>
							<p>The Short Name is a unique, simplified URL that can easily be recalled and shared. Initially, the URL for your Knowledge Panel is a lorem ipsum of letters and numbers. To be more accessible and visible, it’s pertinent that you go into your Google My Business Profile and change it to one that starts with “g.page/” and ends with the name of your hospital or some adaptation of it. Oh, and there’s a 32 character limit—with nothing in between. An example of a Google Short Name would be “g.page/CityVet/”</p>
							<p class="text-title"><b>The Why</b></p>
							<p>Hospitals that have a Google Short Name saw a 12% increase in number of reviews over those that did not. The key here is to claim your Google Short Name ASAP, before another business with a similar name takes yours out from under you.</p>
							<p class="text-title"><b>The How</b></p>
							<p>To claim a Google Short Name on a computer, sign in to your Google My Business account, then open the location that you want to create a Short Name for. From the menu, click “Info” and then “Add profile Short Name”. Now you can enter your Short Name (If your name isn’t available, it will prompt you to choose a different name.) and click “Apply.”</p>
							<p>If you’re on mobile, you’ll first need the Google My Business app. Once you have that, open it and click on “My Business.” Next, tap “Profile” and “Add profile Short Name.” This is where you can enter your desired Google Short Name before pressing “Save.” Whether you’re on computer or mobile, your Short Name will be pending at first, but will eventually show up on your Business Profile when it’s ready.</p>
						</div>
					</div>

					<div class="dp-container">
						<div class="top-row">
							<h4 class="dp-title">GOOGLE ADS</h4>
							<div class="learn-more">
								<p>Learn More</p>
								<div class="plus-minus-box">
									<span></span><span></span>
								</div>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['google_ads'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">Are you using Google Ads?</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">10.5%</p>
										<i class="fas fa-caret-down"></i>
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 10.5%;" class="colored-bar-two"></div></div>
								<p class="column-text">Of hospitals are utilizing Google Ads</p>
							</div>
							<div class="middle-column">
								<div class="stats-row">
									<p class="yearly-stat">11.8%</p>
									<p class="stat-year">2019</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">10.7%</p>
									<p class="stat-year">2018</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">N/A</p>
									<p class="stat-year">2017</p>
								</div>
							</div>
						</div>
						<div class="bottom-row">
							<p class="text-title"><b>Bottom Line</b></p>
							<p>The number of practices using the Ads feature remains flat, and will probably stay that way due to cost and the time involved to create them. 96.2% of iVET360’s clients utilize Google Ads.</p>
						</div>
						<div class="hidden-row" style="max-height: 0;">
							<p class="text-title"><b>The What</b></p>
							<p>No surprise—if you pay for advertising on Google, you’re more likely to get preferential treatment when it comes to search engine results. These hospitals have wisely chosen to make use of a service called Google Ads, which from our experience has been consistently successful for veterinary practices.</p>
							<p>In addition to cost, another possible reason for the stagnation in usage numbers for this platform is that Google Ads has a surprisingly large learning curve. They want to make sure that the content they are promoting looks professionally written, so they have developed an online training course. However, it’s an investment in time and energy that many practices don’t have right now. You can try to navigate the world of Google Ads for the first time by yourself, but research shows us that hospitals choosing the DIY path give up before they ever placed their first ad.</p>
							<p class="text-title"><b>The Why</b></p>
							<p>High adoption rates during the pandemic may have substantially increased your new client numbers, but keeping yourself in front of your clients and at the top of search engine results is an investment in the continuing financial health of your practice.</p>
							<p>Hospitals that utilize Google Ads saw a 5% increase in the number of reviews over those that did not. For iVET360 clients in particular, Google Ads are currently the leading contributor to new client generation.</p>
							<p class="text-title"><b>The How</b></p>
							<p>If you want to dive in to Google Ads (and we strongly suggest you do) we recommend finding someone who has completed the Google Ads training course—a <a href="https://www.google.com/partners/about/" target="_blank">Google Certified Partner</a>. If you’d like to venture out on your own, <a href="https://ads.google.com/home/resources/how-to-setup-googleads-a-checklist/" target="_blank">here’s a checklist</a> to get you started.</p>
							<p>By the way, if you’re looking for Google Adwords Express as an easy way to do this, it is now part of Google Ads as a “Smart” campaign and no longer exists as a standalone option.</p>
						</div>
					</div>

				</div>
			</div>

			<div class="section-container" id="facebook-container">
				<div class="intro-container facebook-pattern" id="facebook-report">
					<div class="text-container">
						<img src="/wp-content/uploads/2020/10/iVET-VMBR-icon-facebook.svg" alt="Facebook Icon">
						<h2>Facebook</h2>
					</div>
				</div>
				<div class="section-inner-container">
					<div class="section-intro-text">
						<h3>Understanding the Data</h3>
						<p>Facebook is so ubiquitous that it’s almost a shorthand for social media, much like how the name Kleenex is used when talking about facial tissues. Despite some bad press in the last year, this media giant remains a major online platform—and it’s one you don’t want to unfriend because a significant number of your clients still live and communicate here. Effectively using Facebook and the extra features it offers can make a huge difference to your bottom line.</p>
						<p>Here’s a breakdown of some of those features, how much they’re being utilized by the veterinary industry, and an assessment of their effectiveness.</p>
					</div>

					<div class="dp-container">
						<div class="top-row">
							<h4 class="dp-title">FACEBOOK RECOMMENDATIONS</h4>
							<div class="learn-more">
								<p>Learn More</p>
								<div class="plus-minus-box">
									<span></span><span></span>
								</div>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['fb_recs'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">Number of reviews on Facebook</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">40*</p>
										<i class="fas fa-caret-down"></i>
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 100%;" class="colored-bar-two"></div></div>
								<p class="column-text">Facebook recommendations for the average veterinary hospital</p>
							</div>
							<div class="middle-column">
								<div class="stats-row">
									<p class="yearly-stat">69</p>
									<p class="stat-year">2019</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">86</p>
									<p class="stat-year">2018</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">N/A</p>
									<p class="stat-year">2017</p>
								</div>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['fb_star'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">YOUR STAR RATING (OUT OF 5)</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">4.7</p>
										<!-- <i class="fas fa-caret-down"></i> -->
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 100%;" class="colored-bar-two"></div></div>
								<p class="column-text">AVERAGE STAR RATING (OUT OF 5)</p>
							</div>
							<div class="middle-column">
							</div>
						</div>
						<div class="bottom-row">
							<p class="text-title"><b>Bottom Line</b></p>
							<p>Facebook has recently changed their format for ratings, reviews, and recommendations, which probably accounts for the large drop off in number. iVET360 clients average 39 reviews and a 4.7 rating.</p>
						</div>
						<div class="hidden-row" style="max-height: 0;">
							<p class="text-title"><b>The What</b></p>
							<p>Facebook gave itself a facelift this past year which included revamping the way they present reviews and recommendations. Although there is still a “Reviews” tab, an actual written review only comes into play after someone leaves a “yes” or “no” recommendation. At that point, they are invited to leave a review.</p>
							<p>This change was also accompanied by several others that account for the decline, including:</p>
							<ul>
								<li><b>Past ratings that had no accompanying review are no longer counted by Facebook in their tabulations of your star rating</b></li>
								<li><b>Star ratings are determined by a new algorithm that combines Recommendations and Reviews</b></li>
								<li><b>The new Facebook layout allows you to put the Reviews tab anywhere you like, so on many pages, it is no longer visible</b></li>
							</ul>
							<p>You can opt to turn off the reviews/recommendations option, which some practices do after receiving negative feedback--in fact, we found that 8.3% of practices surveyed have them turned off. We strongly advise against this, because you need Facebook ratings and recommendations for your SEO.</p>
							<p class="text-title"><b>The Why</b></p>
							<p>In addition to affecting your search engine results, ratings and recommendations give you and your potential clients an at-a-glance idea of how your practice is perceived.</p>
							<p class="text-title"><b>The How</b></p>
							<p>To increase your number of Facebook ratings and recommendations, it’s important that you have first verified your page—more on this later. Once that’s done, you can send your clients to check out your page and suggest that if they’ve had a good experience at your practice to leave a recommendation and review to help other pet owners in your community.</p>
						</div>
					</div>

					<div class="dp-container" id="likes-followers-container">
						<div class="top-row">
							<h4 class="dp-title">FACEBOOK LIKES & FOLLOWERS</h4>
							<div class="learn-more">
								<p>Learn More</p>
								<div class="plus-minus-box">
									<span></span><span></span>
								</div>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['fb_likes'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">YOUR NUMBERS OF LIKES</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">1403</p>
										<!-- <i class="fas fa-caret-down"></i> -->
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 100%;" class="colored-bar-two"></div></div>
								<p class="column-text">AVERAGE NUMBERS OF LIKES</p>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['fb_followers'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">YOUR NUMBERS OF FOLLOWERS</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">1439</p>
										<!-- <i class="fas fa-caret-down"></i> -->
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 100%;" class="colored-bar-two"></div></div>
								<p class="column-text">AVERAGE NUMBERS OF FOLLOWERS</p>
							</div>
						</div>
						<div class="bottom-row">
							<p class="text-title"><b>Bottom Line</b></p>
							<p>It’s nice to be liked. It’s even better to be followed. iVET360’s clients have an average of 1585 likes and 1628 followers.</p>
						</div>
						<div class="hidden-row" style="max-height: 0;">
							<p class="text-title"><b>The What</b></p>
							<p>Ok the truth is “likes” on Facebook are a dime a dozen, but they do give you a good sense of how many people might see your posts—about 5% of them. When someone clicks “Like” on your page, by default they also automatically “Follow” your page, which means they will see updates about your page in their newsfeed.</p>
							<p>So why aren’t Likes and Follows always the same number? Because someone who likes your page can also manually decide to unfollow you because they don’t want to see your content. Someone can also decide to follow you without liking your page.</p>
							<p class="text-title"><b>The Why</b></p>
							<p>It’s obvious that getting as many people as possible to like your page is a good thing—because the more likes, the more potential followers to see your messages. The key here is to make sure they don’t unfollow you, so your content needs to be relevant to them, entertaining, or informative.</p>
							<p>With all the concern about the pandemic, some practices have made it a point to keep their clients informed about health issues and changing hospital protocols via their social media. But others are overwhelmed by the challenges and have let their content slide. The large disparity in likes vs. followers may be the result of that in attention.</p>
							<p class="text-title"><b>The How</b></p>
							<p>Increasing likes is easy—you can simply ask clients to like your page in person, via the “invite” button, post signage, or run a Facebook “like” campaign. But take a look at those follower numbers! If they are considerably lower than your likes, it’s time to rethink and refresh your content, which can be time-consuming. Think about your clients and what their concerns are related to their pets. How can you help them keep their pet healthy? Save them money? Learn about local pet events? In addition to relevant content, posting consistently matters as well.</p>
						</div>
					</div>

					<div class="dp-container">
						<div class="top-row">
							<h4 class="dp-title">FACEBOOK CHECK-INS</h4>
							<div class="learn-more">
								<p>Learn More</p>
								<div class="plus-minus-box">
									<span></span><span></span>
								</div>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['fb_checkins'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">Number of Facebook check-ins</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">733</p>
										<!-- <i class="fas fa-caret-up"></i> -->
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 100%;" class="colored-bar-two"></div></div>
								<p class="column-text">The average number of hospital check-ins</p>
							</div>
							<div class="middle-column">
								<div class="stats-row">
									<p class="yearly-stat">N/A</p>
									<p class="stat-year">2019</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">N/A</p>
									<p class="stat-year">2018</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">N/A</p>
									<p class="stat-year">2017</p>
								</div>
							</div>
						</div>
						<div class="bottom-row">
							<p class="text-title"><b>Bottom Line</b></p>
							<p>Check-ins may be one of the unsung heroes of Facebook marketing. iVET360 clients have an average of 506 client check-ins.</p>
						</div>
						<div class="hidden-row" style="max-height: 0;">
							<p class="text-title"><b>The What</b></p>
							<p>This easy, simple feature allows your clients to alert their friends that they’re at your practice. In doing so, they also supply your practice location, a link to your Facebook page, business rating, and even a clickable map. If they view it on mobile, driving directions are easily accessible as well.</p>
							<p>Facebook also enhances check-ins by highlighting photos and reviews of other friends who have been to your practice and gives you the opportunity to promote an offer as well.</p>
							<p class="text-title"><b>The Why</b></p>
							<p>At first, a check-in may not seem like much—it’s just a client posting that they are currently at your practice. But this free, quick post gives you a lot of bang for no bucks! Consider that anyone who checks in at your practice is assuming this is information their friends and acquaintances want to know, and it comes with vital info about your hospital. In effect, it is a soft-sell, person-to-person recommendation, which as anyone can tell you is the best kind of advertising there is.</p>
							<p>It’s estimated that typically about 200 friends of the person checking in will see this type of post. Consistently promoting check-ins for your practice is a great way to increase likes and potential followers and show them vital information about you at a glance.</p>
							<p class="text-title"><b>The How</b></p>
							<p>It’s important that your page be configured correctly to allow Check-Ins. Make sure your page’s category is set to “Local Business” by navigating to Settings at the top of the page, clicking Page Info in the left column, then selecting Category > Local Business. You will then need to choose a category for your business. Don’t forget to add your business address, and to check the boxes for Show Map, Star Ratings, and Check-Ins and click the button to save your changes.</p>
						</div>
					</div>

					<div class="dp-container">
						<div class="top-row">
							<h4 class="dp-title">FACEBOOK USERNAME</h4>
							<div class="learn-more">
								<p>Learn More</p>
								<div class="plus-minus-box">
									<span></span><span></span>
								</div>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['fb_vanity'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">Do you have a Facebook Username?</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">81.6%</p>
										<i class="fas fa-caret-up"></i>
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 81.6%;" class="colored-bar-two"></div></div>
								<p class="column-text">Have a Facebook Facebook Username</p>
							</div>
							<div class="middle-column">
								<div class="stats-row">
									<p class="yearly-stat">80.1%</p>
									<p class="stat-year">2019</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">78.9%</p>
									<p class="stat-year">2018</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">75.6%</p>
									<p class="stat-year">2017</p>
								</div>
							</div>
						</div>
						<div class="bottom-row">
							<p class="text-title"><b>Bottom Line</b></p>
							<p>There’s steady growth in the number of practices taking this step to make their Facebook pages easier to find. 100% of iVET360 clients have a unique vanity URL for Facebook.</p>
						</div>
						<div class="hidden-row" style="max-height: 0;">
							<p class="text-title"><b>The What</b></p>
							<p>A Facebook vanity URL is a customized web address your clients can use to find your Facebook page (much like Google’s new Google My Business Short Name we addressed earlier in the report). When you first create your hospital’s page, Facebook assigns you a randomized URL with lots of numbers attached at the end. By adapting it into a vanity URL, you are simplifying your address into a username, making it easier for your clients to find you on Facebook.</p>
							<p>The vanity URL also allows for better branding of your hospital’s Facebook page with the “@” symbol, meaning your business can be found or tagged within Facebook. For example, at iVET360, the vanity URL of our Facebook page is: facebook.com/ iVET360. Now, in addition to being much less confusing than what it would have been before (something like, facebook.com/pages/iVET360/839), our URL can be adapted so that anyone could find us on Facebook with @iVET360.</p>
							<p class="text-title"><b>The Why</b></p>
							<p>Anything you can do to make it easier for clients to find and communicate with you is worth doing. Hospitals that have a vanity URL also saw a 5% increase in number of reviews/recommendations over those that did not.</p>
							<p class="text-title"><b>The How</b></p>
							<p>Setting up a Facebook vanity URL is simple. If you’re an admin of your hospital’s Facebook page, you will see on the left side of the page a button that says “Create Page @Username.” Clicking this, you can enter your desired username/vanity URL, or variations of it until you find one that’s available. Once you do, click select “Create Username.” It’s also important to make sure the URL you’re trying to create adheres to Facebook’s <a href="https://www.facebook.com/help/105399436216001/" target="_blank">username guidelines.</a></p>
						</div>
					</div>

					<div class="dp-container">
						<div class="top-row">
							<h4 class="dp-title">FACEBOOK BRANDING</h4>
							<div class="learn-more">
								<p>Learn More</p>
								<div class="plus-minus-box">
									<span></span><span></span>
								</div>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['fb_branded'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">Is your Facebook page branded to your practice?</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">63.9%</p>
										<i class="fas fa-caret-up"></i>
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 63.9%;" class="colored-bar-two"></div></div>
								<p class="column-text">Have a Facebook branded page</p>
							</div>
							<div class="middle-column">
								<div class="stats-row">
									<p class="yearly-stat">63.1%</p>
									<p class="stat-year">2019</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">62.8%</p>
									<p class="stat-year">2018</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">61%</p>
									<p class="stat-year">2017</p>
								</div>
							</div>
						</div>
						<div class="bottom-row">
							<p class="text-title"><b>Bottom Line</b></p>
							<p>Awareness about the importance of branding has motivated more hospitals to make the effort when it comes to the look of their social media. 91.8% of iVET360’s clients have branded Facebook pages.</p>
						</div>
						<div class="hidden-row" style="max-height: 0;">
							<p class="text-title"><b>The What</b></p>
							<p>As the internet continues to expand, your Facebook page’s visibility naturally dwindles. So that your clients and other members of the community can recognize your hospital on Facebook immediately, the practice’s visual branding should extend to your Facebook page. Think of it this way: your practice will be listed in a user’s newsfeed along with their friends, so you want your content to be easily noticeable and not just something that gets skipped over.</p>
							<p>In this study, we are scoring practices based on a rubric of visibility. Is your logo used? Are your colors user-friendly? We have seen hospitals switch out their Facebook image for something like a staff member’s pet, or a pet of the month--and while this is cute, it does degrade visibility. Simply put, your profile photo needs to be your logo or another identifiable marker that makes your hospital stand out.</p>
							<p class="text-title"><b>The Why</b></p>
							<p>Hospitals that have a branded page also saw a 2.5 percent increase in the number of reviews/ recommendations over those that did not.</p>
							<p class="text-title"><b>The How</b></p>
							<p>How to brand your hospital’s Facebook page: As an admin, go to your page and hover over or tap on your profile picture. Click “Update”, then select an option and follow the on-screen instructions.</p>
						</div>
					</div>

					<div class="dp-container">
						<div class="top-row">
							<h4 class="dp-title">FACEBOOK MESSENGER</h4>
							<div class="learn-more">
								<p>Learn More</p>
								<div class="plus-minus-box">
									<span></span><span></span>
								</div>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['fb_mess'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">Are you using Facebook Messenger?</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">83.3%</p>
										<i class="fas fa-caret-down"></i>
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 83.3%;" class="colored-bar-two"></div></div>
								<p class="column-text">Are using Facebook messenger</p>
							</div>
							<div class="middle-column">
								<div class="stats-row">
									<p class="yearly-stat">86.1%</p>
									<p class="stat-year">2019</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">87.6%</p>
									<p class="stat-year">2018</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">89.6%</p>
									<p class="stat-year">2017</p>
								</div>
							</div>
						</div>
						<div class="bottom-row">
							<p class="text-title"><b>Bottom Line</b></p>
							<p>There’s been a 3% decrease in the use of this feature, and it may be because the pandemic has hospital staff stretched to the limit. 91.2% of iVET360 clients actively use Messenger.</p>
						</div>
						<div class="hidden-row" style="max-height: 0;">
							<p class="text-title"><b>The What</b></p>
							<p>Having a platform where clients can easily reach you without having to speak—whether face-to- face or over the phone—is ideal. Facebook Messenger (or just simply “Messenger”) is set up to host group chats, share posts, and is also perfect for individual messages and quick conversations.</p>
							<p>You can turn this feature off if you like, but doing so limits your lines of communication to your clients. Some practices want to do that, as having so many platforms to answer can be demanding on your reception staff. But Messenger remains an extremely popular way to communicate, and having it turned on doesn’t necessarily mean you must answer involved medical questions or respond to every single message. Instead, consider setting up an auto response with your phone number or link to your website to make an appointment.</p>
							<p class="text-title"><b>The Why</b></p>
							<p>Hospitals that utilized Facebook Messenger also saw a 2.5% increase in number of reviews/ recommendations over those that did not.</p>
							<p>It’s likely that the mixed bag and added hassle of Facebook Messaging have played a large part in the past four years of declining industry usage. The fact remains, however, that by making your hospital available on Messenger—even via auto-message—you open your practice to more conversations, which leads to more appointments.</p>
							<p class="text-title"><b>The How</b></p>
							<p>To set up or dismantle Messenger, you must be an admin of your hospital’s Facebook page. First, look at the top of the page for the “Settings” button. From “General,” click on “Messages.” Here, you should see the statement, “Allow people to contact my page privately by showing the message button,” beside which is a box you can check or uncheck depending on your preference. Then, click to save changes.</p>
						</div>
					</div>

					<div class="dp-container">
						<div class="top-row">
							<h4 class="dp-title">FACEBOOK OFFERS</h4>
							<div class="learn-more">
								<p>Learn More</p>
								<div class="plus-minus-box">
									<span></span><span></span>
								</div>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['fb_offers'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">Are you using Facebook Offers?</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">7.4%</p>
										<!-- <i class="fas fa-caret-up"></i> -->
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 7.4%;" class="colored-bar-two"></div></div>
								<p class="column-text">Are using Facebook Offers</p>
							</div>
							<div class="middle-column">
								<div class="stats-row">
									<p class="yearly-stat">N/A</p>
									<p class="stat-year">2019</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">N/A</p>
									<p class="stat-year">2018</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">N/A</p>
									<p class="stat-year">2017</p>
								</div>
							</div>
						</div>
						<div class="bottom-row">
							<p class="text-title"><b>Bottom Line</b></p>
							<p>This new feature shows promise because it is so easy to use. 13.2% of iVET360 clients place Facebook Offers.</p>
						</div>
						<div class="hidden-row" style="max-height: 0;">
							<p class="text-title"><b>The What</b></p>
							<p>Facebook Offers are essentially posts that feature a special discount or promotion. Offers can be created from the sharing tool on your Facebook page, and when it appears on people’s newsfeeds, there’s a “Get Offer” button that encourages those seeing it to claim it. Offers can be targeted to a specific audience, and the cost tailored to your budget.</p>
							<p class="text-title"><b>The Why</b></p>
							<p>Facebook Offers seems to be a slightly more popular platform for our industry than GMB Offers, which may be more about the ease of use and pervasiveness of Facebook. What’s good about hopping on board the Offers train now is that the field is uncrowded, so your message won’t be buried by competition.</p>
							<p class="text-title"><b>The How</b></p>
							<p>Placing a Facebook Offer is almost as simple as regular posting. Go to the “Create Post” window and select “Offer”. The Facebook tool for creating an offer will appear on your left. You can then choose the type of offer, write a headline, add an image, set an expiration date, and specify your audience and budget. Monitor the effectiveness of your offer on the Page Insights tab.</p>
						</div>
					</div>

					<div class="dp-container">
						<div class="top-row">
							<h4 class="dp-title">FACEBOOK ADS</h4>
							<div class="learn-more">
								<p>Learn More</p>
								<div class="plus-minus-box">
									<span></span><span></span>
								</div>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['fb_ads'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">Are you using Facebook Ads?</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">8%</p>
										<!-- <i class="fas fa-caret-up"></i> -->
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 8%;" class="colored-bar-two"></div></div>
								<p class="column-text">Are using Facebook Ads</p>
							</div>
							<div class="middle-column">
								<div class="stats-row">
									<p class="yearly-stat">N/A</p>
									<p class="stat-year">2019</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">N/A</p>
									<p class="stat-year">2018</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">N/A</p>
									<p class="stat-year">2017</p>
								</div>
							</div>
						</div>
						<div class="bottom-row">
							<p class="text-title"><b>Bottom Line</b></p>
							<p>19.8% of iVET360 clients are using Facebook Ads.</p>
						</div>
						<div class="hidden-row" style="max-height: 0;">
							<p class="text-title"><b>The What</b></p>
							<p>This paid feature allows you to place advertising across all of Facebook’s platforms including Instagram and Messenger. Depending upon the placement and type of campaign you choose, the ads can appear directly in the newsfeed, to the right of the newsfeed, between videos, in Facebook’s Marketplace, and in Messenger inboxes.</p>
							<p class="text-title"><b>The Why</b></p>
							<p>Facebook has over 1.6 billion users, and because you can hyper-target your ad’s audience, we’d say this tool is worth what you pay for it. For better or worse, Facebook’s value is enhanced by the fact that it knows more about its users--and what makes them “click”--than any other platform, so your advertising is more likely to give you a good return on investment.</p>
							<p><b>Pro tip:</b> Facebook ads are most effective when you include an offer of some kind, rather than just using it for general branding of your practice.</p>
							<p class="text-title"><b>The How</b></p>
							<p>Creating a good Facebook ad can be time-consuming, though the learning curve is not as steep as the one for Google Ads. Once you’ve created your business account in Facebook, you’ll need to go to the Ad Manager to start setting up advertising campaigns. If you don’t have a provider to help you place and test your Facebook Ads, you can try the DIY route with <a href="https://www.facebook.com/business/ads" target="_blank">these steps provided by Facebook</a>. You can use the same tool to place ads on Facebook’s other affiliates such as Instagram and Messenger.</p>
						</div>
					</div>

				</div>
			</div>

			<div class="section-container" id="yelp-container">
				<div class="intro-container yelp-pattern" id="yelp-report">
					<div class="text-container">
						<img src="/wp-content/uploads/2020/10/iVET-VMBR-icon-yelp.svg" alt="Yelp Icon">
						<h2>Yelp</h2>
					</div>
				</div>
				<div class="section-inner-container">
					<div class="section-intro-text">
						<h3>Understanding the Data</h3>
						<p>Yelp isn’t anyone’s favorite social media platform, but the fact is that it’s still important to Google, and in certain areas of the country it’s a go-to for recommendations (we’re looking at you, California.)</p>
						<p>Even with growing user dissatisfaction, heavily filtered reviews, and declining usage, Yelp still manages to attract 114 million [check this stat] unique users every month. Google features Yelp pages on the top of search engine results and in the knowledge panel if you have an engaged client base on the platform. For these reasons, it makes sense that you take advantage of Yelp’s tools to maximize your online presence—and do it sooner rather than later.</p>
					</div>

					<div class="dp-container">
						<div class="top-row">
							<h4 class="dp-title">YELP REVIEWS</h4>
							<div class="learn-more">
								<p>Learn More</p>
								<div class="plus-minus-box">
									<span></span><span></span>
								</div>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['y_reviews'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">Number of reviews on Yelp</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">34</p>
										<i class="fas fa-caret-up"></i>
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 100%;" class="colored-bar-two"></div></div>
								<p class="column-text">Yelp reviews for the average veterinary hospital</p>
							</div>
							<div class="middle-column">
								<div class="stats-row">
									<p class="yearly-stat">30</p>
									<p class="stat-year">2019</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">27</p>
									<p class="stat-year">2018</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">23</p>
									<p class="stat-year">2017</p>
								</div>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['y_star'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">YOUR STAR RATING (OUT OF 5)</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">4</p>
										<!-- <i class="fas fa-caret-up"></i> -->
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 100%;" class="colored-bar-two"></div></div>
								<p class="column-text">AVERAGE STAR RATING (OUT OF 5)</p>
							</div>
							<div class="middle-column">
							</div>
						</div>
						<div class="bottom-row">
							<p class="text-title"><b>Bottom Line</b></p>
							<p>The industry saw a 13% increase in the number of reviews over last year. iVET360 clients average 39 reviews and a 4 star rating.</p>
						</div>
						<div class="hidden-row" style="max-height: 0;">
							<p class="text-title"><b>The What</b></p>
							<p>Yelp reviews are feedback written by Yelp users about your practice, and they are a powerful tool for your hospital’s search rankings. Yelp relies on an algorithm based on user activity that dictates which reviews appear and in what order they will appear.</p>
							<p>Star ratings are determined by the number of visible reviews divided by the number of stars, rounded to a .5 (1⁄2 star). This is ultimately helpful to businesses because it means you shouldn’t stress when you get a 1-star review. While you should respond to it promptly, the fact is that because of the way Yelp tabulates these, a single 1-star post won’t completely decimate your overall star rating.</p>
							<p class="text-title"><b>The Why</b></p>
							<p>Simply put, the more Yelp reviews you have, the better your search engine results will be. The indus- try is looking pretty sparse in terms of reviews added every year, but that doesn’t mean there aren’t reviews to be had. Obviously, you have a much greater number of clients walking through your doors than is reflected in the reviews.</p>
							<p class="text-title"><b>The How</b></p>
							<p>Unfortunately, Yelp strongly advocates against asking your clients for reviews, and they do monitor this. There are, however, ways to encourage your clients to pen reviews. You could add a Yelp button to your website that prompts returning customers to review, or you could add the Yelp Review button to your email signature. Additionally, you could inform clients that you are on Yelp by posting some signage in your storefront.</p>
						</div>
					</div>

					<div class="dp-container">
						<div class="top-row">
							<h4 class="dp-title">YELP NOT RECOMMENDED</h4>
							<div class="learn-more">
								<p>Learn More</p>
								<div class="plus-minus-box">
									<span></span><span></span>
								</div>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['y_not_rec'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">Number of not recommended reviews on Yelp</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">18</p>
										<!-- <i class="fas fa-caret-up"></i> -->
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 100%;" class="colored-bar-two"></div></div>
								<p class="column-text">Yelp not recommended reviews for the average veterinary hospital</p>
							</div>
							<div class="middle-column">
								<div class="stats-row">
									<p class="yearly-stat">N/A</p>
									<p class="stat-year">2019</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">N/A</p>
									<p class="stat-year">2018</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">N/A</p>
									<p class="stat-year">2017</p>
								</div>
							</div>
						</div>
						<div class="bottom-row">
							<p class="text-title"><b>Bottom Line</b></p>
							<p>Because they have higher numbers of reviews overall, iVET360 clients average about 19 Not Recommended reviews.</p>
						</div>
						<div class="hidden-row" style="max-height: 0;">
							<p class="text-title"><b>The What</b></p>
							<p>Essentially, a “Not Recommended” review is a review of a review—Yelp’s judgement call about a review that is posted for a business by a customer. Some reasons Yelp might flag a review as “not recommended”:</p>
							<ul>
								<li><b>The user is not well-established with a profile picture, lots of friends, and high activity on the platform</b></li>
								<li><b>The review seems biased</b></li>
								<li><b>The review is an unhelpful rant or rave about the business</b></li>
							</ul>
							<p>These reviews might indeed be legitimate, but because of one of the above reasons, they may mark it as “not recommended”.</p>
							<p>In its defense, Yelp says that 75% of reviews submitted are recommended and posted. However, many smaller businesses—like veterinary practices—feel that Yelp is penalizing them by hiding positive reviews from clients who may not be regular users of the platform.</p>
							<p class="text-title"><b>The Why</b></p>
							<p>Obviously, having a lot of positive reviews unseen in the “Not Recommended” category can degrade your rating. This has become a major bone of contention for many businesses, as in addition to being unseen, these reviews now have questionable credibility due to being designated as “not recommended”.</p>
							<p class="text-title"><b>The How</b></p>
							<p>Yelp is obviously trying to weed out illegitimate reviews and strengthen their platform by forcing people to become more active in order for their reviews to carry any weight and be easily seen. Respond to the review because that is best practice...if someone does go there to see the reviews, your response will be there. Will not help it become more visible.</p>
						</div>
					</div>

					<div class="dp-container">
						<div class="top-row">
							<h4 class="dp-title">YELP CLAIMED</h4>
							<div class="learn-more">
								<p>Learn More</p>
								<div class="plus-minus-box">
									<span></span><span></span>
								</div>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['y_claimed'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">Is your Yelp listing claimed?</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">45%</p>
										<i class="fas fa-caret-down"></i>
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 45%;" class="colored-bar-two"></div></div>
								<p class="column-text">Of hospitals have claimed their Yelp business listing</p>
							</div>
							<div class="middle-column">
								<div class="stats-row">
									<p class="yearly-stat">89%</p>
									<p class="stat-year">2019</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">86.9%</p>
									<p class="stat-year">2018</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">82.2%</p>
									<p class="stat-year">2017</p>
								</div>
							</div>
						</div>
						<div class="bottom-row">
							<p class="text-title"><b>Bottom Line</b></p>
							<p>Yikes—the industry has seen a nearly 50% decline in the number of claimed business listings in just the last year, mostly as a result of inactivity. 100% iVET360 clients have a claimed Yelp listing.</p>
						</div>
						<div class="hidden-row" style="max-height: 0;">
							<p class="text-title"><b>The What</b></p>
							<p>Just as with Google and Facebook pages, it is essential that you take the simple step of claiming your veterinary hospital’s Yelp page. This not only prevents strangers and competitors from taking control of your practice profile--it’s also the first and most important step toward having a complete profile, which according to Yelp will mean more customer leads for your business.</p>
							<p class="text-title"><b>The Why</b></p>
							<p>Though they won’t reveal specifics, it appears that Yelp has automatically begun “unclaiming” pages that have been inactive for 90 days or more. Hospitals that have a claimed Yelp profile also saw a 51% increase in number of reviews over those that did not, and as stated earlier in this report, an active Yelp page means a higher profile in Google search results.</p>
							<p>Without a claimed Yelp listing, your hospital is essentially flying blind on this platform, which has all the free tools necessary so you can personalize and get maximum value from your page. Adding photos, responding to reviews, and making offers are just a few of the things your practice can do to make your listing more attractive and informative. Yelp has also created timely (and free) new features that can be of real help during the pandemic--they showcase “Updated Services”, “Health & Safety Measures”, and more so you can let your clients know the latest about your hospital’s procedures and protocols.</p>
							<p class="text-title"><b>The How</b></p>
							<p>To claim your hospital’s Yelp page, search for your hospital on Yelp. If your page has not been claimed, there will be a link that says, “Claim your business.” Select this link, and it will lead you through a series of steps to create a business account. Once your account is set up, continue the instructions to claim the business. Yelp will call the number listed on the business page and provide you with a code. Once you get this code, type it in to verify.</p>
						</div>
					</div>

					<div class="dp-container">
						<div class="top-row">
							<h4 class="dp-title">YELP CHECK-IN OFFERS</h4>
							<div class="learn-more">
								<p>Learn More</p>
								<div class="plus-minus-box">
									<span></span><span></span>
								</div>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['y_checkin'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">Do you have a Yelp Check-In offer?</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">8.9%</p>
										<i class="fas fa-caret-down"></i>
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 8.9%;" class="colored-bar-two"></div></div>
								<p class="column-text">Of hospitals have a Yelp Check-In offer</p>
							</div>
							<div class="middle-column">
								<div class="stats-row">
									<p class="yearly-stat">9.3%</p>
									<p class="stat-year">2019</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">9.6%</p>
									<p class="stat-year">2018</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">5%</p>
									<p class="stat-year">2017</p>
								</div>
							</div>
						</div>
						<div class="bottom-row">
							<p class="text-title"><b>Bottom Line</b></p>
							<p>Check-In Offers are down slightly from last year which is sad given the underlying value of this free tool. 35.7% of iVET360 clients have check-in offers.</p>
						</div>
						<div class="hidden-row" style="max-height: 0;">
							<p class="text-title"><b>The What</b></p>
							<p>When clients use Yelp Check-In at your hospital, they’re essentially broadcasting to their friends that they chose you for their pet’s veterinary needs. This opens up the situation for both digital and person-to-person advertising. To encourage your loyal clients to “check-in,” or report their location, often businesses will digitally offer small discounts, free items, or other special deals.</p>
							<p>The feature allows you to track how many people checked-in as well as how many people redeemed an offer if you have one in place at the time.</p>
							<p class="text-title"><b>The Why</b></p>
							<p>The most successful hospitals use this Yelp feature/hospital deal combination, as seen in the fact that those practices saw a 129% increase in the number of reviews over those that did not.</p>
							<p class="text-title"><b>The How</b></p>
							<p>To set up a Yelp Check-In Offer, you’ll need to first decide what to offer your clients—something like $5 off an exam, a free nail trim, a free branded frisbee or a small bag of treats when they check in at your practice. Then go to biz.yelp.com and log in. Click “Check-In Offers,” then “Create a Check-In Offer.” Select the type of offer you’re giving—% off, price off, fixed price or free item. Add a headline and description details, such as: “Check in at [Hospital Name] to receive [offer].” Click “Create Of-fer.” Once it has been created, you will see it on the “Check-In Offers” page.</p>
						</div>
					</div>

					<div class="dp-container">
						<div class="top-row">
							<h4 class="dp-title">YELP ASK THE COMMUNITY</h4>
							<div class="learn-more">
								<p>Learn More</p>
								<div class="plus-minus-box">
									<span></span><span></span>
								</div>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['y_comm'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">Are you using Yelp Ask The Community?</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">3.5%</p>
										<i class="fas fa-caret-up"></i>
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 3.5%;" class="colored-bar-two"></div></div>
								<p class="column-text">Of hospitals are using Yelp ask the community</p>
							</div>
							<div class="middle-column">
								<div class="stats-row">
									<p class="yearly-stat">3%</p>
									<p class="stat-year">2019</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">N/A</p>
									<p class="stat-year">2018</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">N/A</p>
									<p class="stat-year">2017</p>
								</div>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['y_ques'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">YOUR NUMBER OF YELP QUESTION</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">.3</p>
										<i class="fas fa-caret-up"></i>
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 100%;" class="colored-bar-two"></div></div>
								<p class="column-text">AVERAGE NUMBER OF YELP QUESTION</p>
							</div>
							<div class="middle-column">
							</div>
						</div>
						<div class="bottom-row">
							<p class="text-title"><b>Bottom Line</b></p>
							<p>Like most of Yelp, your clients aren’t using this feature. 8.2% of iVET360 clients are active with Yelp Asks, with an average of 1 question asked on each hospital’s listing.</p>
						</div>
						<div class="hidden-row" style="max-height: 0;">
							<p class="text-title"><b>The What</b></p>
							<p>Similar to Google’s Questions and Answers, Yelp’s Ask The Community allows their users to ask public questions of your business. Also like Google Q&A, this needs to be a feature you monitor, as it allows other users in the community to respond without authority.</p>
							<p class="text-title"><b>The Why</b></p>
							<p>With less than one question on average per hospital, the data says that Yelp users aren’t utilizing this feature at all—outside of California. However, that doesn’t mean your hospital can ignore it. Check in on the feature regularly and be ready to answer so you can control the narrative and provide correct answers. Hospitals that utilize a Yelp Ask The Community did see a whopping 279% increase in the number of reviews over those that did not.</p>
							<p class="text-title"><b>The How</b></p>
							<p>Responding to questions on Yelp Asks is simply a matter of logging in to your Yelper account and going to the “Ask the Community” section on the business page. Scroll down to find the specific question you’d like to respond to, then click or tap the “Answer” button. Your response will be posted shortly after submitting it.</p>
						</div>
					</div>

					<div class="dp-container">
						<div class="top-row">
							<h4 class="dp-title">YELP ADS</h4>
							<div class="learn-more">
								<p>Learn More</p>
								<div class="plus-minus-box">
									<span></span><span></span>
								</div>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['y_ads'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">Are you using Yelp Ads?</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">17.5%</p>
										<i class="fas fa-caret-up"></i>
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 17.5%;" class="colored-bar-two"></div></div>
								<p class="column-text">Of hospitals are utilizing Yelp Ads</p>
							</div>
							<div class="middle-column">
								<div class="stats-row">
									<p class="yearly-stat">13.9%</p>
									<p class="stat-year">2019</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">15.9%</p>
									<p class="stat-year">2018</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">11.9%</p>
									<p class="stat-year">2017</p>
								</div>
							</div>
						</div>
						<div class="bottom-row">
							<p class="text-title"><b>Bottom Line</b></p>
							<p>Up 26% over last year, it appears* the industry is seeing more value in Yelp’s advertising feature. 9.9% of iVET360 clients make use of this.</p>
						</div>
						<div class="hidden-row" style="max-height: 0;">
							<p class="text-title"><b>The What</b></p>
							<p>If your hospital purchases a Yelp Ad, it will appear on the pages that consumers see when they’re looking for other veterinary hospitals or similar businesses. This means that not only will your ad be included in relevant search pages, but on the Yelp business pages of competitors as well. The ad will also get promoted across all Yelp platforms, including online and on the app, and encourages potential clients to visit your page.</p>
							<p>A Yelp ad could also be anything from adding a call-to-action button on your business page (taking clients directly to an appointment page, coupon image etc.) to restricting competitors’ ads from appearing on your Yelp page.</p>
							<p><em>*9.8% of the industry are using Yellow Pages Business to manage their Yelp Page which includes a Yelp Ads budget. Thus our data shows only 7.7% of the industry is actually paying Yelp directly.</em></p>
							<p class="text-title"><b>The Why</b></p>
							<p>While it can be difficult to see a return on investment when it comes to Yelp Ads, hospitals that utilize them show an estimated 64% increase in number of reviews over those that do not.</p>
							<p class="text-title"><b>The How</b></p>
							<p>Yelp makes it easy to advertise on their platform with Self Service (SS) ads. Simply <a href="https://biz.yelp.com/video/getting_started_ss_ads" target="_blank">click here</a> for their detailed run down.</p>
						</div>
					</div>

					<div class="dp-container">
						<div class="top-row">
							<h4 class="dp-title">YELP DEALS</h4>
							<div class="learn-more">
								<p>Learn More</p>
								<div class="plus-minus-box">
									<span></span><span></span>
								</div>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['y_deals'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">Are you offering a Yelp Deal?</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">0.7%</p>
										<i class="fas fa-caret-down"></i>
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 0.7%;" class="colored-bar-two"></div></div>
								<p class="column-text">Of hospitals are offering a Yelp Deal</p>
							</div>
							<div class="middle-column">
								<div class="stats-row">
									<p class="yearly-stat">1%</p>
									<p class="stat-year">2019</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">1.1%</p>
									<p class="stat-year">2018</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">N/A</p>
									<p class="stat-year">2017</p>
								</div>
							</div>
						</div>
						<div class="bottom-row">
							<p class="text-title"><b>Bottom Line</b></p>
							<p>Use of this feature has basically stayed flat for the last 3 years of data collection. Only 1% of iVET360 clients offer Yelp Deals.</p>
						</div>
						<div class="hidden-row" style="max-height: 0;">
							<p class="text-title"><b>The What</b></p>
							<p>This Groupon-style feature offers clients the chance to purchase coupons or discounts—like paying $20 for a $40 worth of services. The idea is that it would create an incentive for new clients to try your hospital over another in the same area.</p>
							<p>Unfortunately, our data shows that the already small number of hospitals using this marketing strategy continues to shrink and is nearly negligible at this point. That could be due to the fact that these types of offers may not be a good fit for veterinary practices—but it’s most likely because Yelp takes up to 30% of the revenue straight from the client, making it a money-losing proposition for many.</p>
							<p class="text-title"><b>The Why</b></p>
							<p>Hospitals that utilize a Yelp Deal did see a 24% increase in the number of reviews over those that did not. However, a Yelp Check-In Offer might be a much better tool for increasing clients and reviews for most hospitals.</p>
							<p class="text-title"><b>The How</b></p>
							<p>To post a Yelp Deal, log in to Yelp for Business Owners and then click “Deals & Gift Certificates” in the sidebar menu. Then click “Set Up Deals and Gift Certificates.” From there, choose a price, the number of vouchers to make available and any other special terms. Now review and agree to the Merchant Terms, then click “Post this Deal” to finalize the process.</p>
						</div>
					</div>

					<div class="dp-container">
						<div class="top-row">
							<h4 class="dp-title">YELP CONNECT (POSTS)</h4>
							<div class="learn-more">
								<p>Learn More</p>
								<div class="plus-minus-box">
									<span></span><span></span>
								</div>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['y_posts'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">Are you using Yelp Posts?</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">0.2%</p>
										<!-- <i class="fas fa-caret-up"></i> -->
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 0.2%;" class="colored-bar-two"></div></div>
								<p class="column-text">Of hospitals are using Yelp Posts</p>
							</div>
							<div class="middle-column">
								<div class="stats-row">
									<p class="yearly-stat">N/A</p>
									<p class="stat-year">2019</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">N/A</p>
									<p class="stat-year">2018</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">N/A</p>
									<p class="stat-year">2017</p>
								</div>
							</div>
						</div>
						<div class="bottom-row">
							<p class="text-title"><b>Bottom Line</b></p>
							<p>New to Yelp in 2020, this paid feature has yet to take off in the veterinary industry. 0% of iVET360 clients are using Yelp Posts as the return on investment doesn’t seem to be there.</p>
						</div>
						<div class="hidden-row" style="max-height: 0;">
							<p class="text-title"><b>The What</b></p>
							<p>Comparable to a boosted Facebook post, Yelp Connect is a paid feature that lets businesses post updates and news relevant to the business directly on their page. These posts will appear to all Yelpers on your business page, and also be promoted to your followers in emails and elsewhere in Yelp’s app.</p>
							<p>Yelp Connect allows for posts to stay live until you choose to take them down, or to specify dates if you are posting an update or event.</p>
							<p class="text-title"><b>The Why</b></p>
							<p>Depending on how many followers you have on your Yelp page, paying for this feature might be to your advantage, especially since it appears most veterinary hospitals aren’t hip to the feature yet. Hospitals that utilize Yelp Connect did see a 85% increase in the number of reviews over those that did not.</p>
							<p class="text-title"><b>The How</b></p>
							<p>To post on Yelp Connect, you can follow these <a href="https://www.yelp-support.com/article/How-do-I-post-with-Yelp-Connect?l=en_US" target="_blank">simple instructions.</a></p>
						</div>
					</div>

				</div>
			</div>

			<div class="section-container" id="nextdoor-container">
				<div class="intro-container nextdoor-pattern" id="nextdoor-report">
					<div class="text-container">
						<img src="/wp-content/uploads/2020/10/iVET-VMBR-icon-nextdoor.svg" alt="Nextdoor Icon">
						<h2>Nextdoor</h2>
					</div>
				</div>
				<div class="section-inner-container">
					<div class="section-intro-text">
						<h3>Understanding the Data</h3>
						<p>Nextdoor has really come into its own in the past few years—so much so that it even has its own <a href="https://www.bestofnextdoor.com/" target="_blank">parody site</a> now that highlights all the neighborhood drama.</p>
						<p>Coyote sightings and back-fence feuds aside, Nextdoor is a must-have for any business that builds its success on clientele in the immediate vicinity. Think of it like Yelp, only hyper-local, with content limited to people who actually reside in a certain area of town. Users can only see content that is from—and targeted to— where they live, so there are a lot of relevant conversations happening, including recommendations about what area veterinarian they recommend.Imagine having 90+ online reviews your hospital never knew about!</p>
						<p>If your practice hasn’t been active on Nextdoor, it’s time to change that. In this next section, we’ll tell you how and why to do it.</p>
					</div>

					<div class="dp-container">
						<div class="top-row">
							<h4 class="dp-title">NEXTDOOR CLAIMED</h4>
							<div class="learn-more">
								<p>Learn More</p>
								<div class="plus-minus-box">
									<span></span><span></span>
								</div>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['nd_claimed'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">Is your Nextdoor listing claimed?</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">33%</p>
										<i class="fas fa-caret-up"></i>
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 33%;" class="colored-bar-two"></div></div>
								<p class="column-text">Of hospitals have claimed their Nextdoor listing</p>
							</div>
							<div class="middle-column">
								<div class="stats-row">
									<p class="yearly-stat">29%</p>
									<p class="stat-year">2019</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">15%</p>
									<p class="stat-year">2018</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">N/A</p>
									<p class="stat-year">2017</p>
								</div>
							</div>
						</div>
						<div class="bottom-row">
							<p class="text-title"><b>Bottom Line</b></p>
							<p>The industry saw a 13% increase in claimed practice listings this past year as the social media platform gains awareness. 78.6% of iVET360 clients have claimed their listing on Nextdoor.</p>
						</div>
						<div class="hidden-row" style="max-height: 0;">
							<p class="text-title"><b>The What</b></p>
							<p>Claiming your page on Nextdoor is pretty much the same as verifying on Facebook and claiming your listing on Google—and becoming just as important. Unless you do this, you can’t respond to or manage reviews, recommendations, or anything the most important people—your friends and neighbors—are saying about your practice to potential clients.</p>
							<p class="text-title"><b>The Why</b></p>
							<p>Wouldn’t you rather know what your friends and neighbors are saying about you than guess and hope that the reviews are positive? This is why it’s so important to claim your Nextdoor listing—but unfortunately, the majority of hospitals still remain unaware and defenseless to what people are saying about them on this fast-growing local listing service.</p>
							<p class="text-title"><b>The How</b></p>
							<p>Luckily, it’s easy to join the Nextdoor block party. First you create an account, <a href="https://nextdoor.com/create-business" target="_blank">search for your practice</a> and click “Claim”—and make sure to claim it as a business. Then enter your name, email, and a chosen password. Once you claim your page, you will have to go through a basic phone verification protocol to confirm you are who you say you are. When you are finished claiming your hospital, you can see what people are saying about you, respond to comments, and update your profile information.</p>
						</div>
					</div>

					<div class="dp-container">
						<div class="top-row">
							<h4 class="dp-title">NEXTDOOR RECOMMENDATIONS</h4>
							<div class="learn-more">
								<p>Learn More</p>
								<div class="plus-minus-box">
									<span></span><span></span>
								</div>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['nd_recs'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">Number of Nextdoor recommendations?</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">92</p>
										<i class="fas fa-caret-up"></i>
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 100%;" class="colored-bar-two"></div></div>
								<p class="column-text">Recommendations for the average veterinary hospital</p>
							</div>
							<div class="middle-column">
								<div class="stats-row">
									<p class="yearly-stat">82</p>
									<p class="stat-year">2019</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">46</p>
									<p class="stat-year">2018</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">N/A</p>
									<p class="stat-year">2017</p>
								</div>
							</div>
						</div>
						<div class="bottom-row">
							<p class="text-title"><b>Bottom Line</b></p>
							<p>Though the 13% growth in recommendations in 2020 seems minor, Nextdoor Recommendations have seen 100% growth since 2018. This rise reflects Nextdoor’s exponential growth as a social media platform. iVET360 clients average 87 recommendations per listing.</p>
						</div>
						<div class="hidden-row" style="max-height: 0;">
							<p class="text-title"><b>The What</b></p>
							<p>On your public Nextdoor business page, there is a button with a heart logo that says “Recommend.” Users can click this button and follow it up with a positive comment about your hospital, which everyone in your network can see.</p>
							<p>People can also just write a comment about your hospital without hitting the “Recommend” button. This shows up in the same feed as the recommendation comments, and is usually how users will post negative reviews of your hospital.</p>
							<p>While this negative feedback can’t necessarily be avoided, there are ways to resolve the situation. You can either reply publicly on the forum or you can send the commenter a private message to mend any wrongdoing. Negative reviews can also be removed by Nextdoor if the content violates their guidelines, but the violation must first be noticed and reported to the company before they can take the users off the site.</p>
							<p class="text-title"><b>The Why</b></p>
							<p>With recommendations on the rise and still sitting at almost triple the amount of Yelp reviews, it’s easy to see why your hospital needs to be active on Nextdoor...like, yesterday.</p>
							<p class="text-title"><b>The How</b></p>
							<p>Unlike Yelp, Nextdoor doesn’t frown on asking clients for recommendations and you can do so in many ways. But first you must claim your business listing. Once you’ve done that, you can then ask clients to leave a review on Nextdoor, in the same ways you do for Google and Facebook: a verbal ask, signage in your practice, icons on your website, etc.</p>
						</div>
					</div>

					<div class="dp-container">
						<div class="top-row">
							<h4 class="dp-title">NEXTDOOR FAVORITES</h4>
							<div class="learn-more">
								<p>Learn More</p>
								<div class="plus-minus-box">
									<span></span><span></span>
								</div>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['nd_faves'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">Number of Nextdoor recommendations?</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">5</p>
										<!-- <i class="fas fa-caret-up"></i> -->
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 100%;" class="colored-bar-two"></div></div>
								<p class="column-text">Recommendations for the average veterinary hospital</p>
							</div>
							<div class="middle-column">
								<div class="stats-row">
									<p class="yearly-stat">5</p>
									<p class="stat-year">2019</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">N/A</p>
									<p class="stat-year">2018</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">N/A</p>
									<p class="stat-year">2017</p>
								</div>
							</div>
						</div>
						<div class="bottom-row">
							<p class="text-title"><b>Bottom Line</b></p>
							<p>Growth isn’t always a bad thing--wIth more hospitals claiming their listings this year, it equals more competition for the coveted “Neighborhood Favorite” title, giving the designation more credibility if you win. iVET360 clients are favorites in an average of 4 neighborhoods in their local areas.</p>
						</div>
						<div class="hidden-row" style="max-height: 0;">
							<p class="text-title"><b>The What</b></p>
							<p>Since 2017, Nextdoor has encouraged neighbors to vote annually in over 30 categories for the small businesses that they think deserve recognition. Depending on the reach of a business, or of your veterinary hospital, it could become a Favorite in quite a number of surrounding neighborhoods.</p>
							<p>The voting process for “Neighborhood Favorite” gives your hospital a certain amount of marketing in and of itself, since a list of each neighborhood’s small businesses of choice is sent to every person in the community. Even more of an incentive is the prize of a free month of advertising if you win the title—which in past years has been the source of significant growth for the practices we consult.</p>
							<p class="text-title"><b>The Why</b></p>
							<p>Nextdoor Favorites is free advertising, with the clients in your community ready to share with their friends how great your hospital is. Even better is the free month of digital advertising offered if you do become a Neighborhood Favorite.</p>
							<p class="text-title"><b>The How</b></p>
							<p>Each year when the voting is announced on Nextdoor, you can enhance your chances of winning by reaching out to your clients and asking them to vote for your practice via email, in-hospital signage, or personal request. Pro tip: Don’t forget to thank your clients if you win a Favorites title!</p>
						</div>
					</div>

					<div class="dp-container">
						<div class="top-row">
							<h4 class="dp-title">NEXTDOOR LOCAL DEALS</h4>
							<div class="learn-more">
								<p>Learn More</p>
								<div class="plus-minus-box">
									<span></span><span></span>
								</div>
							</div>
						</div>
						<div class="middle-row">
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="hospital-score"><?php echo $_GET['nd_biz'] ?></p>
										<i style="display: none;" class="fas fa-check-circle"></i>
										<i style="display: none;" class="fas fa-times-circle"></i>
									</div>
								</div>
								<div class="pass-fail-bar hospital-bar"><div class="colored-bar-one"></div></div>
								<p class="column-text">Are you using Nextdoor Local Deals?</p>
							</div>
							<div class="middle-column">
								<div class="pass-fail">
									<div class="pass-fail-inner">
										<p class="industry-score">0.6%</p>
										<i class="fas fa-caret-up"></i>
									</div>
								</div>
								<div class="pass-fail-bar industry-bar"><div style="width: 0.6%;" class="colored-bar-two"></div></div>
								<p class="column-text">Are utilizing Nextdoor Local Deals</p>
							</div>
							<div class="middle-column">
								<div class="stats-row">
									<p class="yearly-stat">0.3%</p>
									<p class="stat-year">2019</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">N/A</p>
									<p class="stat-year">2018</p>
								</div>
								<div class="stats-row">
									<p class="yearly-stat">N/A</p>
									<p class="stat-year">2017</p>
								</div>
							</div>
						</div>
						<div class="bottom-row">
							<p class="text-title"><b>Bottom Line</b></p>
							<p>While growth of this feature is slow, the 9.9% of iVET360 clients who make use of Nextdoor Local Deals find them effective, though return on investment has declined.</p>
						</div>
						<div class="hidden-row" style="max-height: 0;">
							<p class="text-title"><b>The What</b></p>
							<p>Just like Google and Facebook, Nextdoor has a feature that allows hospitals to promote discounts or specials on services to both existing and potential clients in specific neighborhoods. Keeping the audience of these ads within driving distance creates a level of intimacy with the community that other social media platforms don’t have. It also shows your neighbors that you really do care about them and their pets—enough to give them certain deals or incentives to visit your practice.</p>
							<p class="text-title"><b>The Why</b></p>
							<p>People who use Nextdoor tend to be very invested in supporting their community. The best part of Local Deals is that they’re shown to these users in so many places on the site: residents’ feeds, business pages, in the Business section, on a neighborhood-specific Local Deals area, and as a sponsored listing in search results.</p>
							<p>On the downside, more businesses are now using this feature and there’s more competition in other verticals taking up ad space. That has resulted in a decline in effectiveness for ND Local Deals when compared with other social media advertising.</p>
							<p class="text-title"><b>The How</b></p>
							<p>To create a Local Deal, you’ll first need to claim your business listing. Once you’ve done that, you can follow Nextdoor’s user-friendly Local Deal creation tool <a href="https://help.nextdoor.com/s/article/How-to-create-an-offer-official?language=en_US+" target="_blank">here</a>.</p>
						</div>
					</div>

				</div>
			</div>

		</div>
		<?php
		return ob_get_clean();
	}
	add_shortcode('new_benchmark','new_benchmark');
