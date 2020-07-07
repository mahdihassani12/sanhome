<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Partners_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'ere-partners-widget';
	}

	public function get_title() {
		return esc_html__( 'Partners', 'realhomes-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-carousel';
	}

	public function get_categories() {
		return [ 'real-homes' ];
	}

	protected function _register_controls() {





		$this->start_controls_section(
			'ere_partners_section',
			[
				'label' => esc_html__( 'Partners', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'ere_partners_spacing',
			[
				'label' => esc_html__( 'Spacing Between Icons (px)', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 10,
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => '',
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => '',
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .rh_section__partners_elementor .rh_partner' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rh_section__partners_elementor' => 'margin-left: -{{SIZE}}{{UNIT}}; margin-right: -{{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_partners_bottom_spacing',
			[
				'label' => esc_html__( 'Icon Bottom Margin (px)', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 10,
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => '',
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => '',
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .rh_section__partners_elementor .rh_partner' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'ere_partners_sizes',
			[
				'label' => esc_html__( 'Icon Size (%)', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => '16.666',
					'unit' => '%',
				],
				'tablet_default' => [
					'size' => '',
					'unit' => '%',
				],
				'mobile_default' => [
					'size' => '',
					'unit' => '%',
				],
				'selectors' => [
					'{{WRAPPER}} .rh_section__partners_elementor .rh_partner' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_control(
			'number_of_partners',
			[
				'label'   => esc_html__( 'Number of Partners', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 100,
				'step'    => 1,
				'default' => 6,
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		if ( ! $settings[ 'number_of_partners' ] ) {
			$settings[ 'number_of_partners' ] = 20;
		}

		$partners_args = array(
			'post_type'      => 'partners',
			'posts_per_page' => $settings[ 'number_of_partners' ],
		);

		$partners_query = new WP_Query( $partners_args );

		if ( $partners_query->have_posts() ) {
			?>
			<section class="rh_wrapper_partners_elementor">


					<div class="rh_section__partners_elementor">
						<?php
						while ( $partners_query->have_posts() ) {

							$partners_query->the_post();

							$partner_url = get_post_meta( get_the_ID(), 'REAL_HOMES_partner_url', true );
							?>
							<div <?php post_class( 'rh_partner' ); ?>>

								<?php if ( $partner_url ) { ?>
								<a target="_blank" href="<?php echo esc_url( $partner_url ); ?>" title="<?php the_title(); ?>">
								<?php } ?>

								<?php
								$thumb_title = trim( strip_tags( get_the_title( get_the_ID() ) ) );
								the_post_thumbnail(
									'partners-logo', array(
										'alt'   => $thumb_title,
										'title' => $thumb_title,
									)
								);
								?>

								<?php if ( $partner_url ) { ?>
								</a>
							<?php } ?>

							</div>
							<?php
							wp_reset_postdata();

						}
						?>
					</div>
			</section>
			<?php
		}

	}

}