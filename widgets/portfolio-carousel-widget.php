<?php
/**
 * Portfolio Carousel for Elementor Widget.
 *
 * @since 1.0.0
 */
class Portfolio_Carousel_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Portfolio Carousel widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'portfolio-carousel';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Portfolio Carousel widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Portfolio Carousel', 'portfolio-carousel' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Portfolio Carousel widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Portfolio Carousel widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'general' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the Portfolio Carousel widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'portfolio', 'carousel', 'gallery', 'slider', 'swiper', 'thumbnails' ];
	}

	/**
	 * Register Portfolio Carousel widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'section_gallery',
			[
				'label' => esc_html__( 'Gallery', 'portfolio-carousel' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'gallery',
			[
				'label' => esc_html__( 'Add Images', 'portfolio-carousel' ),
				'type' => \Elementor\Controls_Manager::GALLERY,
				'default' => [],
				'show_label' => false,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail',
				'default' => 'large',
				'separator' => 'none',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout', 'portfolio-carousel' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'thumb_columns',
			[
				'label' => esc_html__( 'Thumbnails Columns', 'portfolio-carousel' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '5',
				'tablet_default' => '4',
				'mobile_default' => '3',
				'options' => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
				],
				'prefix_class' => 'thumbnail-columns-',
				'selectors' => [
					'{{WRAPPER}} .portfolio-thumbs-swiper .swiper-slide' => 'width: calc(100% / {{VALUE}});',
				],
			]
		);

		$this->add_responsive_control(
			'space_between',
			[
				'label' => esc_html__( 'Space Between', 'portfolio-carousel' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .portfolio-thumbs-swiper' => '--space-between: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_main_image',
			[
				'label' => esc_html__( 'Main Image', 'portfolio-carousel' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'image_height',
			[
				'label' => esc_html__( 'Height', 'portfolio-carousel' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
					'vh' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'size_units' => [ 'px', 'vh' ],
				'default' => [
					'size' => 400,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .portfolio-main-swiper' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'portfolio-carousel' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .portfolio-main-swiper .swiper-slide' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_thumbnails',
			[
				'label' => esc_html__( 'Thumbnails', 'portfolio-carousel' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'thumbnail_height',
			[
				'label' => esc_html__( 'Height', 'portfolio-carousel' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 300,
					],
				],
				'default' => [
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .portfolio-thumbs-swiper' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'thumbnail_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'portfolio-carousel' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .portfolio-thumbs-swiper .swiper-slide' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'thumbnail_opacity',
			[
				'label' => esc_html__( 'Opacity', 'portfolio-carousel' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0.1,
						'max' => 1,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 0.6,
				],
				'selectors' => [
					'{{WRAPPER}} .portfolio-thumbs-swiper .swiper-slide:not(.swiper-slide-thumb-active)' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_caption',
			[
				'label' => esc_html__( 'Caption', 'portfolio-carousel' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'caption_color',
			[
				'label' => esc_html__( 'Text Color', 'portfolio-carousel' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .portfolio-carousel-caption' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'caption_typography',
				'selector' => '{{WRAPPER}} .portfolio-carousel-caption',
			]
		);

		$this->add_responsive_control(
			'caption_padding',
			[
				'label' => esc_html__( 'Padding', 'portfolio-carousel' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .portfolio-carousel-caption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => '10',
					'right' => '10',
					'bottom' => '10',
					'left' => '10',
					'unit' => 'px',
					'isLinked' => true,
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render Portfolio Carousel widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['gallery'] ) ) {
			return;
		}

		$unique_id = 'portfolio-carousel-' . $this->get_id();

		$this->add_render_attribute( 'carousel', 'class', 'portfolio-carousel-container' );
		$this->add_render_attribute( 'carousel', 'id', $unique_id );
		
		// Enqueue required assets
		wp_enqueue_style( 'portfolio-carousel-swiper' );
		wp_enqueue_style( 'portfolio-carousel' );
		wp_enqueue_script( 'portfolio-carousel-swiper' );
		wp_enqueue_script( 'portfolio-carousel' );
		
		?>
		<div <?php $this->print_render_attribute_string( 'carousel' ); ?>>
			<div style="overflow: hidden;" class="portfolio-main-swiper">
				<div class="swiper-wrapper">
					<?php foreach ( $settings['gallery'] as $index => $item ) : 
						$image_url = \Elementor\Group_Control_Image_Size::get_attachment_image_src( $item['id'], 'thumbnail', $settings );
						$image_caption = wp_get_attachment_caption( $item['id'] );
					?>
						<div class="swiper-slide">
							<div class="portfolio-carousel-item">
								<div class="portfolio-carousel-image">
									<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_caption ); ?>">
								</div>
								<?php if ( ! empty( $image_caption ) ) : ?>
									<div class="portfolio-carousel-caption">
										<?php echo esc_html( $image_caption ); ?>
									</div>
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
			
			<div class="portfolio-thumbs-swiper">
				<div class="swiper-wrapper">
					<?php foreach ( $settings['gallery'] as $index => $item ) : 
						// Use original or large size image but let CSS handle the sizing
						$thumb_url = wp_get_attachment_image_src( $item['id'], 'medium' )[0];
						$image_caption = wp_get_attachment_caption( $item['id'] );
					?>
						<div class="swiper-slide">
							<div class="portfolio-carousel-thumb">
								<img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo esc_attr( $image_caption ); ?>">
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>

		<script>
		jQuery(document).ready(function($) {
			// Initialize main Swiper
			var <?php echo $unique_id; ?>_main = new Swiper('#<?php echo $unique_id; ?> .portfolio-main-swiper', {
				spaceBetween: 0,
				navigation: {
					nextEl: '.swiper-button-next',
					prevEl: '.swiper-button-prev',
				}
			});
			
			// Manual thumbnail click handling
			$('#<?php echo $unique_id; ?> .portfolio-thumbs-swiper .swiper-slide').on('click', function() {
				var index = $(this).index();
				<?php echo $unique_id; ?>_main.slideTo(index);
				
				// Update active thumbnail
				$('#<?php echo $unique_id; ?> .portfolio-thumbs-swiper .swiper-slide').removeClass('swiper-slide-thumb-active');
				$(this).addClass('swiper-slide-thumb-active');
			});
			
			// Update thumbnail when main slide changes
			<?php echo $unique_id; ?>_main.on('slideChange', function() {
				var activeIndex = this.activeIndex;
				$('#<?php echo $unique_id; ?> .portfolio-thumbs-swiper .swiper-slide').removeClass('swiper-slide-thumb-active');
				$('#<?php echo $unique_id; ?> .portfolio-thumbs-swiper .swiper-slide').eq(activeIndex).addClass('swiper-slide-thumb-active');
			});
			
			// Set first thumbnail as active on initial load
			$('#<?php echo $unique_id; ?> .portfolio-thumbs-swiper .swiper-slide').first().addClass('swiper-slide-thumb-active');
		});
		</script>
		<?php
	}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function content_template() {
		?>
		<# if ( settings.gallery.length ) { #>
			<div class="portfolio-carousel-container elementor-editor-element-wrap">
				<div class="portfolio-main-swiper elementor-editor-main-swiper">
					<div class="swiper-wrapper">
						<# _.each( settings.gallery, function( item, index ) { #>
							<#
							var image = {
								id: item.id,
								url: item.url,
								size: settings.thumbnail_size,
								dimension: settings.thumbnail_custom_dimension,
								model: view.getEditModel()
							};
							var image_url = elementor.imagesManager.getImageUrl( image );
							#>
							<div class="swiper-slide">
								<div class="portfolio-carousel-item">
									<div class="portfolio-carousel-image">
										<img src="{{ image_url }}" alt="" style="max-width: 100%; max-height: 100%; width: auto; height: auto;">
									</div>
									<# if (item.caption) { #>
									<div class="portfolio-carousel-caption">
										{{{ item.caption }}}
									</div>
									<# } #>
								</div>
							</div>
						<# }); #>
					</div>
				</div>
				
				<div class="portfolio-thumbs-swiper">
					<div class="swiper-wrapper">
						<# _.each( settings.gallery, function( item, index ) { #>
							<div class="swiper-slide">
								<div class="portfolio-carousel-thumb">
									<img src="{{ item.url }}" alt="" style="max-width: 100%; max-height: 100%; width: auto; height: auto;">
								</div>
							</div>
						<# }); #>
					</div>
				</div>
			</div>
		<# } #>
		<?php
	}
} 