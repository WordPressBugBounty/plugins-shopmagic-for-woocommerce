<?php declare(strict_types=1);

namespace WPDesk\ShopMagic\Tracker;

use WPDesk\ShopMagic\Components\HookProvider\HookProvider;

/**
 * Sets WPDesk tracker notices.
 */
class TrackerNotices implements HookProvider {

	const USAGE_DATA_URL = 'https://docs.shopmagic.app/article/1045-usage-data?utm_source=settings&utm_medium=link&utm_campaign=shopmagic-notice&utm_content=read-more';

	public function hooks(): void {
		add_filter( 'wpdesk_tracker_notice_screens', [ $this, 'screens_where_notice_show' ] );
		add_filter( 'wpdesk_tracker_notice_content', [ $this, 'tracker_notice' ], 10, 3 );
	}

	/**
	 * On these screens tracker notice will be shown.
	 *
	 * @param \WP_Screen[] $screens
	 *
	 * @return \WP_Screen[]
	 */
	public function screens_where_notice_show( array $screens ): array {
		$screens[] = 'edit-shopmagic_automation';
		$screens[] = 'shopmagic_automation_page_shopmagic_welcome_page';
		$screens[] = 'shopmagic_automation';
		$screens[] = 'shopmagic_automation_page_shopmagic-settings';

		return $screens;
	}

	/**
	 * Tracker notice content.
	 *
	 * @param string $notice
	 * @param string $username
	 * @param string $terms_url
	 *
	 * @return string
	 */
	public function tracker_notice( $notice, $username, $terms_url ) {
		ob_start();
		?>
		<?php printf( esc_html__( 'Hey %s,', 'shopmagic-for-woocommerce' ), esc_html( $username ) ); ?><br/>
		<?php echo wp_kses_post( __( 'We need your help to improve <strong>ShopMagic</strong>, so it\'s more useful for you and the rest of our <strong>80,000+ users</strong>. By collecting data on how you use our plugins, you will help us a lot. We will not collect any sensitive data, so you can feel safe.', 'shopmagic-for-woocommerce' ) ); ?>
		<a href="<?php echo esc_url( self::USAGE_DATA_URL ); ?>" target="_blank"><?php esc_html_e( 'Find out more &raquo;', 'shopmagic-for-woocommerce' ); ?></a><br/>
		<?php esc_html_e( 'Thank you! ~ Mac @ ShopMagic Team', 'shopmagic-for-woocommerce' ); ?>
		<?php
		return ob_get_clean();
	}
}
