<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Rozholy_Widget_Hero_Banner extends \Elementor\Widget_Base {
	public function get_name(): string {
		return 'rozholy_hero_banner'; }
	public function get_title(): string {
		return esc_html__( 'Hero Banner', 'rozholy-companion' ); }
	public function get_icon(): string {
		return 'eicon-post-excerpt'; }
	public function get_categories(): array {
		return array( 'rozholy-salon' ); }
	public function get_keywords(): array {
		return array( 'hero', 'banner', 'header', 'cover' ); }

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'rozholy-companion' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'title',
			array(
				'label'   => esc_html__( 'Title', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Welcome to Rozholy', 'rozholy-companion' ),
				'dynamic' => array( 'active' => true ),
			)
		);
		$this->add_control(
			'subtitle',
			array(
				'label'   => esc_html__( 'Subtitle', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'dynamic' => array( 'active' => true ),
			)
		);
		$this->add_control(
			'description',
			array(
				'label'   => esc_html__( 'Description', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::WYSIWYG,
				'dynamic' => array( 'active' => true ),
			)
		);
		$this->add_control(
			'button_text',
			array(
				'label'   => esc_html__( 'Button Text', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Get Started', 'rozholy-companion' ),
			)
		);
		$this->add_control(
			'button_url',
			array(
				'label'       => esc_html__( 'Button URL', 'rozholy-companion' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => 'https://',
				'dynamic'     => array( 'active' => true ),
			)
		);
		$this->add_control(
			'button2_text',
			array(
				'label' => esc_html__( 'Button 2 Text', 'rozholy-companion' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
			)
		);
		$this->add_control(
			'button2_url',
			array(
				'label'       => esc_html__( 'Button 2 URL', 'rozholy-companion' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => 'https://',
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'style_section',
			array(
				'label' => esc_html__( 'Style', 'rozholy-companion' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'height',
			array(
				'label'   => esc_html__( 'Height (vh)', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::SLIDER,
				'range'   => array(
					'px' => array(
						'min'  => 30,
						'max'  => 100,
						'step' => 5,
					),
				),
				'default' => array(
					'size' => 85,
					'unit' => 'vh',
				),
			)
		);
		$this->add_control(
			'overlay',
			array(
				'label'   => esc_html__( 'Overlay Opacity (%)', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::SLIDER,
				'range'   => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default' => array( 'size' => 50 ),
			)
		);
		$this->add_control(
			'bg_color',
			array(
				'label'   => esc_html__( 'Background Color', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '#1a1a2e',
			)
		);
		$this->add_control(
			'text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'rozholy-companion' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array( '.elementor {{WRAPPER}} .rz-hero-content' => 'color: {{VALUE}};' ),
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'bg_image',
				'label'    => esc_html__( 'Background Image', 'rozholy-companion' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '.elementor {{WRAPPER}} .rz-hero-banner',
			)
		);
		$this->end_controls_section();
	}

	public function render(): void {
		$s        = $this->get_settings_for_display();
		$btn_url  = ! empty( $s['button_url']['url'] ) ? $s['button_url']['url'] : '#';
		$btn2_url = ! empty( $s['button2_url']['url'] ) ? $s['button2_url']['url'] : '#';
		$height   = $s['height']['size'] ?? 85;
		$overlay  = ( $s['overlay']['size'] ?? 50 ) / 100;
		$bg_color = $s['bg_color'] ?? '#1a1a2e';
		?>
		<div class="rz-hero-banner" style="position:relative;min-height:<?php echo esc_attr( $height ); ?>vh;display:flex;align-items:center;justify-content:center;overflow:hidden;background-color:<?php echo esc_attr( $bg_color ); ?>;">
			<div style="position:absolute;inset:0;background:rgba(0,0,0,<?php echo esc_attr( $overlay ); ?>);z-index:1;"></div>
			<div class="rz-hero-content" style="position:relative;z-index:2;text-align:center;color:#fff;padding:20px;max-width:800px;">
				<?php
				if ( $s['title'] ) :
					?>
					<h1 style="font-size:clamp(2rem,5vw,4rem);margin:0 0 16px;font-family:'Playfair Display',serif;text-shadow:0 2px 20px rgba(0,0,0,.3);"><?php echo esc_html( $s['title'] ); ?></h1><?php endif; ?>
				<?php
				if ( $s['subtitle'] ) :
					?>
					<p style="font-size:clamp(1rem,2vw,1.25rem);opacity:.9;line-height:1.8;margin:0 0 16px;"><?php echo esc_html( $s['subtitle'] ); ?></p><?php endif; ?>
				<?php
				if ( $s['description'] ) :
					?>
					<div style="opacity:.85;line-height:1.8;margin:0 0 32px;"><?php echo wp_kses_post( $s['description'] ); ?></div><?php endif; ?>
				<div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
					<?php
					if ( $s['button_text'] ) :
						?>
						<a href="<?php echo esc_url( $btn_url ); ?>" style="display:inline-block;padding:14px 36px;border-radius:50px;background:linear-gradient(135deg,#d4a0a0,#b8a0c0);color:#fff;font-weight:600;text-decoration:none;transition:transform .3s;"><?php echo esc_html( $s['button_text'] ); ?></a><?php endif; ?>
					<?php
					if ( $s['button2_text'] ) :
						?>
						<a href="<?php echo esc_url( $btn2_url ); ?>" style="display:inline-block;padding:14px 36px;border-radius:50px;border:2px solid rgba(255,255,255,.6);color:#fff;font-weight:600;text-decoration:none;"><?php echo esc_html( $s['button2_text'] ); ?></a><?php endif; ?>
				</div>
			</div>
		</div>
		<?php
	}
}

class Rozholy_Widget_Promo_Banner extends \Elementor\Widget_Base {
	public function get_name(): string {
		return 'rozholy_promo_banner'; }
	public function get_title(): string {
		return esc_html__( 'Promo Banner', 'rozholy-companion' ); }
	public function get_icon(): string {
		return 'eicon-image-hotspot'; }
	public function get_categories(): array {
		return array( 'rozholy-salon' ); }
	public function get_keywords(): array {
		return array( 'promo', 'banner', 'cta', 'ad' ); }

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'rozholy-companion' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'title',
			array(
				'label'   => esc_html__( 'Title', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Special Offer', 'rozholy-companion' ),
				'dynamic' => array( 'active' => true ),
			)
		);
		$this->add_control(
			'description',
			array(
				'label'   => esc_html__( 'Description', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'dynamic' => array( 'active' => true ),
			)
		);
		$this->add_control(
			'button_text',
			array(
				'label'   => esc_html__( 'Button Text', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Learn More', 'rozholy-companion' ),
			)
		);
		$this->add_control(
			'button_url',
			array(
				'label'       => esc_html__( 'Button URL', 'rozholy-companion' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => 'https://',
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'style_section',
			array(
				'label' => esc_html__( 'Style', 'rozholy-companion' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'background',
				'label'    => esc_html__( 'Background', 'rozholy-companion' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '.elementor {{WRAPPER}} .rz-promo-banner',
			)
		);
		$this->add_control(
			'text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'rozholy-companion' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array( '.elementor {{WRAPPER}} .rz-promo-banner' => 'color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'overlay',
			array(
				'label'   => esc_html__( 'Show Overlay', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);
		$this->end_controls_section();
	}

	public function render(): void {
		$s       = $this->get_settings_for_display();
		$btn_url = ! empty( $s['button_url']['url'] ) ? $s['button_url']['url'] : '#';
		?>
		<div class="rz-promo-banner" style="position:relative;border-radius:16px;overflow:hidden;padding:60px 40px;text-align:center;">
			<?php
			if ( $s['overlay'] === 'yes' ) :
				?>
				<div style="position:absolute;inset:0;background:rgba(0,0,0,.4);"></div><?php endif; ?>
			<div style="position:relative;z-index:1;max-width:600px;margin:0 auto;">
				<?php
				if ( $s['title'] ) :
					?>
					<h2 style="margin:0 0 12px;font-family:'Playfair Display',serif;font-size:clamp(1.5rem,3vw,2.5rem);color:inherit;"><?php echo esc_html( $s['title'] ); ?></h2><?php endif; ?>
				<?php
				if ( $s['description'] ) :
					?>
					<p style="opacity:.9;margin:0 0 24px;line-height:1.8;color:inherit;"><?php echo esc_html( $s['description'] ); ?></p><?php endif; ?>
				<?php
				if ( $s['button_text'] ) :
					?>
					<a href="<?php echo esc_url( $btn_url ); ?>" style="display:inline-block;padding:14px 36px;border-radius:50px;background:#fff;color:#333;font-weight:600;text-decoration:none;"><?php echo esc_html( $s['button_text'] ); ?></a><?php endif; ?>
			</div>
		</div>
		<?php
	}
}

class Rozholy_Widget_Banner_Slider extends \Elementor\Widget_Base {
	public function get_name(): string {
		return 'rozholy_banner_slider'; }
	public function get_title(): string {
		return esc_html__( 'Banner Slider', 'rozholy-companion' ); }
	public function get_icon(): string {
		return 'eicon-slideshow'; }
	public function get_categories(): array {
		return array( 'rozholy-salon' ); }
	public function get_keywords(): array {
		return array( 'slider', 'banner', 'slides', 'carousel' ); }

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Slides', 'rozholy-companion' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'title',
			array(
				'label'   => esc_html__( 'Title', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Slide Title', 'rozholy-companion' ),
			)
		);
		$repeater->add_control(
			'subtitle',
			array(
				'label' => esc_html__( 'Subtitle', 'rozholy-companion' ),
				'type'  => \Elementor\Controls_Manager::TEXTAREA,
				'rows'  => 2,
			)
		);
		$repeater->add_control(
			'button_text',
			array(
				'label' => esc_html__( 'Button Text', 'rozholy-companion' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
			)
		);
		$repeater->add_control(
			'button_url',
			array(
				'label' => esc_html__( 'Button URL', 'rozholy-companion' ),
				'type'  => \Elementor\Controls_Manager::URL,
			)
		);
		$repeater->add_control(
			'image',
			array(
				'label' => esc_html__( 'Background Image', 'rozholy-companion' ),
				'type'  => \Elementor\Controls_Manager::MEDIA,
			)
		);
		$this->add_control(
			'slides',
			array(
				'label'       => esc_html__( 'Slides', 'rozholy-companion' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array( array( 'title' => esc_html__( 'Welcome to Our Salon', 'rozholy-companion' ) ) ),
				'title_field' => '{{{ title }}}',
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'settings_section',
			array(
				'label' => esc_html__( 'Settings', 'rozholy-companion' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'autoplay',
			array(
				'label'   => esc_html__( 'Autoplay', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);
		$this->add_control(
			'speed',
			array(
				'label'   => esc_html__( 'Speed (ms)', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 5000,
			)
		);
		$this->add_control(
			'height',
			array(
				'label'   => esc_html__( 'Slide Height (px)', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 600,
			)
		);
		$this->end_controls_section();
	}

	public function render(): void {
		$s      = $this->get_settings_for_display();
		$slides = $s['slides'] ?? array();
		if ( empty( $slides ) ) {
			return;
		}
		?>
		<div class="rz-banner-slider swiper" style="overflow:hidden;height:<?php echo intval( $s['height'] ?: 600 ); ?>px;">
			<div class="swiper-wrapper">
				<?php
				foreach ( $slides as $slide ) :
					$img     = $slide['image']['url'] ?? '';
					$btn_url = ! empty( $slide['button_url']['url'] ) ? $slide['button_url']['url'] : '#';
					?>
					<div class="swiper-slide" style="display:flex;align-items:center;justify-content:center;background:<?php echo $img ? "url({$img}) center/cover" : '#333'; ?>;position:relative;">
						<div style="position:absolute;inset:0;background:rgba(0,0,0,.4);"></div>
						<div style="position:relative;z-index:1;text-align:center;color:#fff;padding:20px;max-width:700px;">
							<?php
							if ( $slide['title'] ) :
								?>
								<h2 style="font-size:clamp(1.5rem,4vw,3rem);margin:0 0 12px;font-family:'Playfair Display',serif;"><?php echo esc_html( $slide['title'] ); ?></h2><?php endif; ?>
							<?php
							if ( $slide['subtitle'] ) :
								?>
								<p style="font-size:1.1rem;opacity:.9;margin:0 0 24px;"><?php echo esc_html( $slide['subtitle'] ); ?></p><?php endif; ?>
							<?php
							if ( $slide['button_text'] ) :
								?>
								<a href="<?php echo esc_url( $btn_url ); ?>" style="display:inline-block;padding:12px 32px;border-radius:50px;background:#fff;color:#333;font-weight:600;text-decoration:none;"><?php echo esc_html( $slide['button_text'] ); ?></a><?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="swiper-pagination"></div>
			<div class="swiper-button-prev"></div>
			<div class="swiper-button-next"></div>
		</div>
		<?php
	}
}

class Rozholy_Widget_Section_Heading extends \Elementor\Widget_Base {
	public function get_name(): string {
		return 'rozholy_section_heading'; }
	public function get_title(): string {
		return esc_html__( 'Section Heading', 'rozholy-companion' ); }
	public function get_icon(): string {
		return 'eicon-heading'; }
	public function get_categories(): array {
		return array( 'rozholy-salon' ); }
	public function get_keywords(): array {
		return array( 'heading', 'section', 'title', 'subtitle' ); }

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'rozholy-companion' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'title',
			array(
				'label'   => esc_html__( 'Title', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Our Services', 'rozholy-companion' ),
				'dynamic' => array( 'active' => true ),
			)
		);
		$this->add_control(
			'subtitle',
			array(
				'label'   => esc_html__( 'Subtitle', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'rows'    => 2,
				'dynamic' => array( 'active' => true ),
			)
		);
		$this->add_control(
			'alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'rozholy-companion' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'rozholy-companion' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'rozholy-companion' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default' => 'center',
				'toggle'  => true,
			)
		);
		$this->add_control(
			'show_divider',
			array(
				'label'   => esc_html__( 'Show Divider', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);
		$this->add_control(
			'gradient_text',
			array(
				'label' => esc_html__( 'Gradient Text', 'rozholy-companion' ),
				'type'  => \Elementor\Controls_Manager::SWITCHER,
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'style_section',
			array(
				'label' => esc_html__( 'Style', 'rozholy-companion' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Title Color', 'rozholy-companion' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array( '.elementor {{WRAPPER}} .rz-heading-title' => 'color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'subtitle_color',
			array(
				'label'     => esc_html__( 'Subtitle Color', 'rozholy-companion' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array( '.elementor {{WRAPPER}} .rz-heading-subtitle' => 'color: {{VALUE}};' ),
			)
		);
		$this->end_controls_section();
	}

	public function render(): void {
		$s        = $this->get_settings_for_display();
		$align    = $s['alignment'] ?? 'center';
		$gradient = $s['gradient_text'] === 'yes';
		?>
		<div class="rz-section-heading" style="text-align:<?php echo esc_attr( $align ); ?>;margin-bottom:40px;">
			<?php
			if ( $s['title'] ) :
				?>
				<h2 class="rz-heading-title" style="font-family:'Playfair Display',serif;font-size:clamp(1.5rem,3vw,2.5rem);margin:0;<?php echo $gradient ? 'background:linear-gradient(135deg,#d4a0a0,#b8a0c0);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;' : ''; ?>"><?php echo esc_html( $s['title'] ); ?></h2><?php endif; ?>
			<?php
			if ( $s['show_divider'] === 'yes' ) :
				?>
				<div style="width:60px;height:3px;background:linear-gradient(90deg,#d4a0a0,#b8a0c0);border-radius:2px;margin:12px <?php echo $align === 'center' ? 'auto' : ( $align === 'right' ? '0' : 'auto 0' ); ?>;"></div><?php endif; ?>
			<?php
			if ( $s['subtitle'] ) :
				?>
				<p class="rz-heading-subtitle" style="font-size:1.05rem;margin:8px 0 0;max-width:600px;<?php echo $align === 'center' ? 'margin:8px auto 0;' : ''; ?>"><?php echo esc_html( $s['subtitle'] ); ?></p><?php endif; ?>
		</div>
		<?php
	}
}
