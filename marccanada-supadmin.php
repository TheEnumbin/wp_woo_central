<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              enumbin.com
 * @since             1.0.0
 * @package           Marccanada_Supadmin
 *
 * @wordpress-plugin
 * Plugin Name:       MarcCanada Super Admin
 * Plugin URI:        enumbin.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Enamul Hassan
 * Author URI:        enumbin.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       marccanada-supadmin
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'MARCCANADA_SUPADMIN_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-marccanada-supadmin-activator.php
 */
function activate_marccanada_supadmin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-marccanada-supadmin-activator.php';
	Marccanada_Supadmin_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-marccanada-supadmin-deactivator.php
 */
function deactivate_marccanada_supadmin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-marccanada-supadmin-deactivator.php';
	Marccanada_Supadmin_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_marccanada_supadmin' );
register_deactivation_hook( __FILE__, 'deactivate_marccanada_supadmin' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-marccanada-supadmin.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_marccanada_supadmin() {

	$plugin = new Marccanada_Supadmin();
	$plugin->run();

}
run_marccanada_supadmin();

add_action( 'admin_enqueue_scripts', 'woo_admin_styles' );
function woo_admin_styles() {
    global $wp_scripts;

    $version   = time();
    $screen    = get_current_screen();
    $screen_id = $screen ? $screen->id : '';

    

    // Register admin styles.
    wp_register_style( 'woocommerce_admin_menu_styles', WC()->plugin_url() . '/assets/css/menu.css', array(), $version );
    wp_register_style( 'woocommerce_admin_styles', WC()->plugin_url() . '/assets/css/admin.css', array(), $version );
    wp_register_style( 'jquery-ui-style', WC()->plugin_url() . '/assets/css/jquery-ui/jquery-ui.min.css', array(), $version );
    wp_register_style( 'woocommerce_admin_dashboard_styles', WC()->plugin_url() . '/assets/css/dashboard.css', array(), $version );
    wp_register_style( 'woocommerce_admin_print_reports_styles', WC()->plugin_url() . '/assets/css/reports-print.css', array(), $version, 'print' );
    wp_register_style( 'woocommerce_admin_marketplace_styles', WC()->plugin_url() . '/assets/css/marketplace-suggestions.css', array(), $version );
    wp_register_style( 'woocommerce_admin_privacy_styles', WC()->plugin_url() . '/assets/css/privacy.css', array(), $version );



 if ( $screen_id == 'toplevel_page_site-reports-network' ) {
        wp_register_style( 'woocommerce-general', WC()->plugin_url() . '/assets/css/woocommerce.css', array(), $version );
        wp_style_add_data( 'woocommerce-general', 'rtl', 'replace' );
 }

    // Sitewide menu CSS.
    wp_enqueue_style( 'woocommerce_admin_menu_styles' );

    // Admin styles for WC pages only.
 if ( $screen_id == 'toplevel_page_site-reports-network' ) {
        wp_enqueue_style( 'woocommerce_admin_styles' );
        wp_enqueue_style( 'jquery-ui-style' );
        wp_enqueue_style( 'wp-color-picker' );
 }

 if ( $screen_id == 'toplevel_page_site-reports-network' ) {
        wp_enqueue_style( 'woocommerce_admin_dashboard_styles' );
 }

 if ( $screen_id == 'toplevel_page_site-reports-network' ) {
        wp_enqueue_style( 'woocommerce_admin_print_reports_styles' );
 }

}

add_action( 'admin_enqueue_scripts', 'woo_admin_scripts' );

function woo_admin_scripts() {
    global $wp_query, $post;

    $screen       = get_current_screen();
    $screen_id    = $screen ? $screen->id : '';
    $wc_screen_id = sanitize_title( __( 'WooCommerce', 'woocommerce' ) );
    $suffix       = '.min';
    $version      = time();





    // Reports Pages.
if ( $screen_id == 'toplevel_page_site-reports-network' ) {
        wp_register_script( 'wc-reports', WC()->plugin_url() . '/assets/js/admin/reports' . $suffix . '.js', array( 'jquery', 'jquery-ui-datepicker' ), $version );

        wp_enqueue_script( 'wc-reports' );
 }

    
}





add_action('network_admin_menu', 'admin_menu', 11, 0);

function admin_menu() {
		
	add_menu_page( 
		__( 'All Orders', 'woocommerce' ), 
		__( 'All Sitewise Orders', 'woocommerce' ), 
		'view_woocommerce_reports', 
		'site-reports', 
		'marcinc_list_sitewise_orders',
		'dashicons-chart-bar', 
		'55.6' 
	);
	
}


 function marcinc_list_sitewise_orders(){
    $woo_dir = plugin_dir_path( WC_PLUGIN_FILE );
        
    include_once $woo_dir . 'includes/admin/reports/class-wc-admin-report.php';
    include_once $woo_dir . 'includes/admin/reports/class-wc-report-sales-by-date.php';
    
    $posts = array();
    $your_list_of_blog_ids = array(2,3,4);
    
    foreach ( $your_list_of_blog_ids as $blog_id ) {
        switch_to_blog( $blog_id );
        $all_url = get_admin_url() . 'edit.php?post_type=shop_order';
        $all_rep_url = get_admin_url() . 'admin.php?page=wc-reports';
        
        $sales_by_date = new WC_Report_Sales_By_Date();
        $ranges = array(
			'year'       => __( 'Year', 'woocommerce' ),
			'last_month' => __( 'Last month', 'woocommerce' ),
			'month'      => __( 'This month', 'woocommerce' ),
			'7day'       => __( 'Last 7 days', 'woocommerce' )
		);

		$sales_by_date->chart_colours = array(
			'sales_amount'     => '#b1d4ea',
			'net_sales_amount' => '#3498db',
			'average'          => '#b1d4ea',
			'net_average'      => '#3498db',
			'order_count'      => '#dbe1e3',
			'item_count'       => '#ecf0f1',
			'shipping_amount'  => '#5cc488',
			'coupon_amount'    => '#f1c40f',
			'refund_amount'    => '#e74c3c',
		);
        $current_range = ! empty( $_GET['range'] ) ? sanitize_text_field( wp_unslash( $_GET['range'] ) ) : 'month'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

		if ( ! in_array( $current_range, array( 'custom', 'year', 'last_month', 'month', '7day' ), true ) ) {
			$current_range = 'month';
		}

		$sales_by_date->check_current_range_nonce( $current_range );
		$sales_by_date->calculate_current_range( $current_range );

?>
<div class="heading_site">
    <h1 class="site_heading_mcanada">Summery of <?php  echo get_bloginfo('name'); ?> Site | <a href="<?php echo $all_url; ?>">See All Orders</a> | <a href="<?php echo $all_rep_url; ?>">See Detailed Report</a></h1>  
</div>
<div id="poststuff" class="woocommerce-reports-wide">
	<div class="postbox">

	<?php if ( 'custom' === $current_range && isset( $_GET['start_date'], $_GET['end_date'] ) ) : ?>
		<h3 class="screen-reader-text">
			<?php
			/* translators: 1: start date 2: end date */
			printf(
				esc_html__( 'From %1$s to %2$s', 'woocommerce' ),
				esc_html( wc_clean( wp_unslash( $_GET['start_date'] ) ) ),
				esc_html( wc_clean( wp_unslash( $_GET['end_date'] ) ) )
			);
			?>
		</h3>
	<?php else : ?>
		<h3 class="screen-reader-text"><?php echo esc_html( $ranges[ $current_range ] ); ?></h3>
	<?php endif; ?>

		<div class="stats_range">
		    <ul>
				<li class="custom active">
					<h2>Sales Report</h2>
				</li>
			</ul>
			<ul>
				<?php
				foreach ( $ranges as $range => $name ) {
					echo '<li class="' . ( $current_range == $range ? 'active' : '' ) . '"><a href="' . esc_url( remove_query_arg( array( 'start_date', 'end_date' ), add_query_arg( 'range', $range ) ) ) . '">' . esc_html( $name ) . '</a></li>';
				}
				?>
				<li class="custom <?php echo ( 'custom' === $current_range ) ? 'active' : ''; ?>">
					<?php esc_html_e( 'Custom:', 'woocommerce' ); ?>
					<form method="GET">
						<div>
							<?php
							// Maintain query string.
							foreach ( $_GET as $key => $value ) {
								if ( is_array( $value ) ) {
									foreach ( $value as $v ) {
										echo '<input type="hidden" name="' . esc_attr( sanitize_text_field( $key ) ) . '[]" value="' . esc_attr( sanitize_text_field( $v ) ) . '" />';
									}
								} else {
									echo '<input type="hidden" name="' . esc_attr( sanitize_text_field( $key ) ) . '" value="' . esc_attr( sanitize_text_field( $value ) ) . '" />';
								}
							}
							?>
							<input type="hidden" name="range" value="custom" />
							<input type="text" size="11" placeholder="yyyy-mm-dd" value="<?php echo ( ! empty( $_GET['start_date'] ) ) ? esc_attr( wp_unslash( $_GET['start_date'] ) ) : ''; ?>" name="start_date" class="range_datepicker from" autocomplete="off" /><?php //@codingStandardsIgnoreLine ?>
							<span>&ndash;</span>
							<input type="text" size="11" placeholder="yyyy-mm-dd" value="<?php echo ( ! empty( $_GET['end_date'] ) ) ? esc_attr( wp_unslash( $_GET['end_date'] ) ) : ''; ?>" name="end_date" class="range_datepicker to" autocomplete="off" /><?php //@codingStandardsIgnoreLine ?>
							<button type="submit" class="button" value="<?php esc_attr_e( 'Go', 'woocommerce' ); ?>"><?php esc_html_e( 'Go', 'woocommerce' ); ?></button>
							<?php wp_nonce_field( 'custom_range', 'wc_reports_nonce', false ); ?>
						</div>
					</form>
				</li>
			</ul>
		</div>
		<div class="stats_range stats-inventory">
			<ul>
				<li class="custom active">
					<h2>Inventory Report</h2>
				</li>
			</ul>
		</div>
		<div class="inside chart-with-sidebar">
			<div class="chart-sidebar">
				<?php if ( $legends = $sales_by_date->get_chart_legend() ) : ?>
					<ul class="chart-legend">
						<?php foreach ( $legends as $legend ) : ?>
							<?php // @codingStandardsIgnoreStart ?>
							<li style="border-color: <?php echo $legend['color']; ?>" <?php if ( isset( $legend['highlight_series'] ) ) echo 'class="highlight_series ' . ( isset( $legend['placeholder'] ) ? 'tips' : '' ) . '" data-series="' . esc_attr( $legend['highlight_series'] ) . '"'; ?> data-tip="<?php echo isset( $legend['placeholder'] ) ? $legend['placeholder'] : ''; ?>">
								<?php echo $legend['title']; ?>
							</li>
							<?php // @codingStandardsIgnoreEnd ?>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
				<ul class="chart-widgets">
					<?php foreach ( $sales_by_date->get_chart_widgets() as $widget ) : ?>
						<li class="chart-widget">
							<?php if ( $widget['title'] ) : ?>
								<h4><?php echo esc_html( $widget['title'] ); ?></h4>
							<?php endif; ?>
							<?php call_user_func( $widget['callback'] ); ?>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="chart-sidebar">
				<ul class="wc_status_list chart-legend">
				<?php 
                    $on_hold_count    = 0;
        			$processing_count = 0;
        
        			foreach ( wc_get_order_types( 'order-count' ) as $type ) {
        				$counts            = (array) wp_count_posts( $type );
        				$on_hold_count    += isset( $counts['wc-on-hold'] ) ? $counts['wc-on-hold'] : 0;
        				$processing_count += isset( $counts['wc-processing'] ) ? $counts['wc-processing'] : 0;
        			}
        			?>
        			<li class="processing-orders">
        			<a href="<?php echo esc_url( admin_url( 'edit.php?post_status=wc-processing&post_type=shop_order' ) ); ?>">
        				<?php
        					printf(
        						/* translators: %s: order count */
        						_n( '<strong>%s order</strong> awaiting processing', '<strong>%s orders</strong> awaiting processing', $processing_count, 'woocommerce' ),
        						$processing_count
        					); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
        				?>
        				</a>
        			</li>
        			<li class="on-hold-orders">
        				<a href="<?php echo esc_url( admin_url( 'edit.php?post_status=wc-on-hold&post_type=shop_order' ) ); ?>">
        				<?php
        					printf(
        						/* translators: %s: order count */
        						_n( '<strong>%s order</strong> on-hold', '<strong>%s orders</strong> on-hold', $on_hold_count, 'woocommerce' ),
        						$on_hold_count
        					); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
        				?>
        				</a>
        			</li>
        			<?php
        			global $wpdb;

			// Requires lookup table added in 3.6.
			if ( version_compare( get_option( 'woocommerce_db_version', null ), '3.6', '<' ) ) {
				return;
			}

			$stock   = absint( max( get_option( 'woocommerce_notify_low_stock_amount' ), 1 ) );
			$nostock = absint( max( get_option( 'woocommerce_notify_no_stock_amount' ), 0 ) );

			$transient_name   = 'wc_low_stock_count';
			$lowinstock_count = get_transient( $transient_name );

			if ( false === $lowinstock_count ) {
				/**
				 * Status widget low in stock count pre query.
				 *
				 * @since 4.3.0
				 * @param null|string $low_in_stock_count Low in stock count, by default null.
				 * @param int         $stock              Low stock amount.
				 * @param int         $nostock            No stock amount
				 */
				$lowinstock_count = apply_filters( 'woocommerce_status_widget_low_in_stock_count_pre_query', null, $stock, $nostock );

				if ( is_null( $lowinstock_count ) ) {
					$lowinstock_count = $wpdb->get_var(
						$wpdb->prepare(
							"SELECT COUNT( product_id )
							FROM {$wpdb->wc_product_meta_lookup} AS lookup
							INNER JOIN {$wpdb->posts} as posts ON lookup.product_id = posts.ID
							WHERE stock_quantity <= %d
							AND stock_quantity > %d
							AND posts.post_status = 'publish'",
							$stock,
							$nostock
						)
					);
				}

				set_transient( $transient_name, (int) $lowinstock_count, DAY_IN_SECONDS * 30 );
			}

			$transient_name   = 'wc_outofstock_count';
			$outofstock_count = get_transient( $transient_name );
			$lowstock_link    = 'admin.php?page=wc-reports&tab=stock&report=low_in_stock';
			$outofstock_link  = 'admin.php?page=wc-reports&tab=stock&report=out_of_stock';


			if ( false === $outofstock_count ) {
				/**
				 * Status widget out of stock count pre query.
				 *
				 * @since 4.3.0
				 * @param null|string $outofstock_count Out of stock count, by default null.
				 * @param int         $nostock          No stock amount
				 */
				$outofstock_count = apply_filters( 'woocommerce_status_widget_out_of_stock_count_pre_query', null, $nostock );

				if ( is_null( $outofstock_count ) ) {
					$outofstock_count = (int) $wpdb->get_var(
						$wpdb->prepare(
							"SELECT COUNT( product_id )
							FROM {$wpdb->wc_product_meta_lookup} AS lookup
							INNER JOIN {$wpdb->posts} as posts ON lookup.product_id = posts.ID
							WHERE stock_quantity <= %d
							AND posts.post_status = 'publish'",
							$nostock
						)
					);
				}

				set_transient( $transient_name, (int) $outofstock_count, DAY_IN_SECONDS * 30 );
			}
			?>
			<li class="low-in-stock">
			<a href="<?php echo esc_url( admin_url( $lowstock_link ) ); ?>">
				<?php
					printf(
						/* translators: %s: order count */
						_n( '<strong>%s product</strong> low in stock', '<strong>%s products</strong> low in stock', $lowinstock_count, 'woocommerce' ),
						$lowinstock_count
					); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
				?>
				</a>
			</li>
			<li class="out-of-stock">
				<a href="<?php echo esc_url( admin_url( $outofstock_link ) ); ?>">
				<?php
					printf(
						/* translators: %s: order count */
						_n( '<strong>%s product</strong> out of stock', '<strong>%s products</strong> out of stock', $outofstock_count, 'woocommerce' ),
						$outofstock_count
					); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
				?>
				</a>
			</li>
                </ul>
			</div>
		</div>
	</div>
</div>
<?php
        restore_current_blog();
    }
}


add_action( 'admin_menu', 'marcinc_remove_menus', 999999 );

function marcinc_remove_menus() {
	/* Use remove_menu_page() and remove_submenu_page() here. */
	$your_list_of_blog_ids = array(2,3,4);
	
	foreach ( $your_list_of_blog_ids as $blog_id ) {
		switch_to_blog( $blog_id );
	    remove_menu_page('edit.php');
	    remove_menu_page('edit-comments.php');
		restore_current_blog();
	}

}