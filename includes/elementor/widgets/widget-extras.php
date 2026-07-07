<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Rozholy_Widget_Gift_Card extends \Elementor\Widget_Base {
	public function get_name(): string {
		return 'rozholy_gift_card'; }
	public function get_title(): string {
		return esc_html__( 'Gift Card', 'rozholy-companion' ); }
	public function get_icon(): string {
		return 'eicon-gift'; }
	public function get_categories(): array {
		return array( 'rozholy-salon' ); }
	public function get_keywords(): array {
		return array( 'gift', 'card', 'voucher' ); }

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
				'default' => esc_html__( 'Gift Voucher', 'rozholy-companion' ),
			)
		);
		$this->add_control(
			'price',
			array(
				'label'   => esc_html__( 'Price', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '500,000 تومان',
			)
		);
		$this->add_control(
			'description',
			array(
				'label'   => esc_html__( 'Description', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'default' => esc_html__( 'The perfect gift for your loved ones.', 'rozholy-companion' ),
			)
		);
		$this->add_control(
			'image',
			array(
				'label' => esc_html__( 'Card Image', 'rozholy-companion' ),
				'type'  => \Elementor\Controls_Manager::MEDIA,
			)
		);
		$this->add_control(
			'button_text',
			array(
				'label'   => esc_html__( 'Button Text', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Purchase', 'rozholy-companion' ),
			)
		);
		$this->add_control(
			'button_url',
			array(
				'label' => esc_html__( 'Button URL', 'rozholy-companion' ),
				'type'  => \Elementor\Controls_Manager::URL,
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
			'card_bg',
			array(
				'label'     => esc_html__( 'Card Background', 'rozholy-companion' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#f9f6f3',
				'selectors' => array( '.elementor {{WRAPPER}} .rz-gift-card' => 'background: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'accent_color',
			array(
				'label'   => esc_html__( 'Accent Color', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '#d4a0a0',
			)
		);
		$this->end_controls_section();
	}

	public function render(): void {
		$s       = $this->get_settings_for_display();
		$img     = $s['image']['url'] ?? '';
		$btn_url = ! empty( $s['button_url']['url'] ) ? $s['button_url']['url'] : '#';
		?>
		<div class="rz-gift-card" style="background:#fff;border:2px solid #e8ddd5;border-radius:20px;overflow:hidden;max-width:380px;margin:0 auto;">
			<?php
			if ( $img ) :
				?>
				<div style="height:180px;overflow:hidden;"><img src="<?php echo esc_url( $img ); ?>" alt="" style="width:100%;height:100%;object-fit:cover;" /></div><?php endif; ?>
			<div style="padding:30px;text-align:center;">
				<div style="font-size:2.5rem;margin-bottom:12px;">🎁</div>
				<?php
				if ( $s['title'] ) :
					?>
					<h3 style="margin:0 0 8px;font-family:'Playfair Display',serif;"><?php echo esc_html( $s['title'] ); ?></h3><?php endif; ?>
				<?php
				if ( $s['price'] ) :
					?>
					<div style="font-size:2rem;font-weight:700;color:#d4a0a0;margin:0 0 12px;"><?php echo esc_html( $s['price'] ); ?></div><?php endif; ?>
				<?php
				if ( $s['description'] ) :
					?>
					<p style="color:#7a7a7a;font-size:.9rem;margin:0 0 20px;"><?php echo esc_html( $s['description'] ); ?></p><?php endif; ?>
				<?php
				if ( $s['button_text'] ) :
					?>
					<a href="<?php echo esc_url( $btn_url ); ?>" style="display:inline-block;padding:12px 32px;border-radius:50px;background:linear-gradient(135deg,#d4a0a0,#b8a0c0);color:#fff;font-weight:600;text-decoration:none;"><?php echo esc_html( $s['button_text'] ); ?></a><?php endif; ?>
			</div>
		</div>
		<?php
	}
}

class Rozholy_Widget_Loyalty_Card extends \Elementor\Widget_Base {
	public function get_name(): string {
		return 'rozholy_loyalty_card'; }
	public function get_title(): string {
		return esc_html__( 'Loyalty Card', 'rozholy-companion' ); }
	public function get_icon(): string {
		return 'eicon-star'; }
	public function get_categories(): array {
		return array( 'rozholy-salon' ); }
	public function get_keywords(): array {
		return array( 'loyalty', 'rewards', 'card' ); }

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
				'default' => esc_html__( 'Loyalty Program', 'rozholy-companion' ),
			)
		);
		$this->add_control(
			'description',
			array(
				'label'   => esc_html__( 'Description', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'default' => esc_html__( 'Earn points with every visit and redeem them for free services!', 'rozholy-companion' ),
			)
		);
		$this->add_control(
			'points_label',
			array(
				'label'   => esc_html__( 'Points Label', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Points Earned', 'rozholy-companion' ),
			)
		);
		$this->add_control(
			'points',
			array(
				'label'   => esc_html__( 'Points', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 250,
			)
		);
		$this->add_control(
			'rewards',
			array(
				'label'   => esc_html__( 'Rewards (one per line)', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'default' => '10% off on next visit\nFree haircut after 5 visits\n20% off on birthday month',
			)
		);
		$this->add_control(
			'button_text',
			array(
				'label'   => esc_html__( 'Button Text', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Join Now', 'rozholy-companion' ),
			)
		);
		$this->add_control(
			'button_url',
			array(
				'label' => esc_html__( 'Button URL', 'rozholy-companion' ),
				'type'  => \Elementor\Controls_Manager::URL,
			)
		);
		$this->end_controls_section();
	}

	public function render(): void {
		$s       = $this->get_settings_for_display();
		$btn_url = ! empty( $s['button_url']['url'] ) ? $s['button_url']['url'] : '#';
		?>
		<div style="background:linear-gradient(135deg,#f9f6f3,#f0ece8);border:1px solid #e8ddd5;border-radius:20px;padding:36px;text-align:center;">
			<div style="font-size:2.5rem;margin-bottom:12px;">⭐</div>
			<?php
			if ( $s['title'] ) :
				?>
				<h3 style="margin:0 0 8px;font-family:'Playfair Display',serif;"><?php echo esc_html( $s['title'] ); ?></h3><?php endif; ?>
			<?php
			if ( $s['description'] ) :
				?>
				<p style="color:#7a7a7a;margin:0 0 16px;"><?php echo esc_html( $s['description'] ); ?></p><?php endif; ?>
			<?php
			if ( $s['points'] ) :
				?>
				<div style="font-size:3rem;font-weight:700;background:linear-gradient(135deg,#d4a0a0,#b8a0c0);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;"><?php echo intval( $s['points'] ); ?></div><p style="color:#888;margin:0 0 16px;"><?php echo esc_html( $s['points_label'] ?: esc_html__( 'Points', 'rozholy-companion' ) ); ?></p><?php endif; ?>
			<?php
			if ( $s['rewards'] ) :
				?>
				<ul style="list-style:none;padding:0;margin:0 0 20px;text-align:center;">
				<?php
				foreach ( explode( "\n", $s['rewards'] ) as $r ) :
					?>
				<li style="padding:4px 0;">✓ <?php echo esc_html( trim( $r ) ); ?></li><?php endforeach; ?></ul><?php endif; ?>
			<?php
			if ( $s['button_text'] ) :
				?>
				<a href="<?php echo esc_url( $btn_url ); ?>" style="display:inline-block;padding:12px 32px;border-radius:50px;background:linear-gradient(135deg,#d4a0a0,#b8a0c0);color:#fff;font-weight:600;text-decoration:none;"><?php echo esc_html( $s['button_text'] ); ?></a><?php endif; ?>
		</div>
		<?php
	}
}

class Rozholy_Widget_Special_Offer extends \Elementor\Widget_Base {
	public function get_name(): string {
		return 'rozholy_special_offer'; }
	public function get_title(): string {
		return esc_html__( 'Special Offer', 'rozholy-companion' ); }
	public function get_icon(): string {
		return 'eicon-sale-badge'; }
	public function get_categories(): array {
		return array( 'rozholy-salon' ); }
	public function get_keywords(): array {
		return array( 'offer', 'sale', 'discount', 'promo' ); }

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'rozholy-companion' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'badge',
			array(
				'label'   => esc_html__( 'Badge Text', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '50% OFF', 'rozholy-companion' ),
			)
		);
		$this->add_control(
			'title',
			array(
				'label'   => esc_html__( 'Title', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Summer Special', 'rozholy-companion' ),
			)
		);
		$this->add_control(
			'description',
			array(
				'label'   => esc_html__( 'Description', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'rows'    => 2,
				'default' => esc_html__( 'Limited time offer. Book now!', 'rozholy-companion' ),
			)
		);
		$this->add_control(
			'button_text',
			array(
				'label'   => esc_html__( 'Button Text', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Claim Offer', 'rozholy-companion' ),
			)
		);
		$this->add_control(
			'button_url',
			array(
				'label' => esc_html__( 'Button URL', 'rozholy-companion' ),
				'type'  => \Elementor\Controls_Manager::URL,
			)
		);
		$this->add_control(
			'expiry',
			array(
				'label'   => esc_html__( 'Expiry Date', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::DATE_TIME,
				'default' => '2026-12-31',
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
			'badge_color',
			array(
				'label'   => esc_html__( 'Badge Color', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '#e74c3c',
			)
		);
		$this->end_controls_section();
	}

	public function render(): void {
		$s       = $this->get_settings_for_display();
		$btn_url = ! empty( $s['button_url']['url'] ) ? $s['button_url']['url'] : '#';
		?>
		<div style="background:#fff;border:2px dashed #d4a0a0;border-radius:20px;padding:36px;text-align:center;position:relative;overflow:hidden;">
			<?php
			if ( $s['badge'] ) :
				?>
				<div style="position:absolute;top:12px;right:-28px;background:<?php echo esc_attr( $s['badge_color'] ?: '#e74c3c' ); ?>;color:#fff;padding:6px 40px;font-weight:700;font-size:.85rem;transform:rotate(45deg);"><?php echo esc_html( $s['badge'] ); ?></div><?php endif; ?>
			<?php
			if ( $s['title'] ) :
				?>
				<h3 style="margin:0 0 8px;font-family:'Playfair Display',serif;font-size:1.5rem;"><?php echo esc_html( $s['title'] ); ?></h3><?php endif; ?>
			<?php
			if ( $s['description'] ) :
				?>
				<p style="color:#7a7a7a;margin:0 0 16px;"><?php echo esc_html( $s['description'] ); ?></p><?php endif; ?>
			<?php
			if ( $s['expiry'] ) :
				?>
				<p style="font-size:.85rem;color:#888;margin:0 0 20px;">⏳ <?php echo esc_html__( 'Expires:', 'rozholy-companion' ); ?> <?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $s['expiry'] ) ) ); ?></p><?php endif; ?>
			<?php
			if ( $s['button_text'] ) :
				?>
				<a href="<?php echo esc_url( $btn_url ); ?>" style="display:inline-block;padding:12px 32px;border-radius:50px;background:linear-gradient(135deg,#d4a0a0,#b8a0c0);color:#fff;font-weight:600;text-decoration:none;"><?php echo esc_html( $s['button_text'] ); ?></a><?php endif; ?>
		</div>
		<?php
	}
}

class Rozholy_Widget_Progress_Bar extends \Elementor\Widget_Base {
	public function get_name(): string {
		return 'rozholy_progress_bar'; }
	public function get_title(): string {
		return esc_html__( 'Progress Bar', 'rozholy-companion' ); }
	public function get_icon(): string {
		return 'eicon-skill-bar'; }
	public function get_categories(): array {
		return array( 'rozholy-salon' ); }
	public function get_keywords(): array {
		return array( 'progress', 'bar', 'skill', 'service' ); }

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Items', 'rozholy-companion' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'label',
			array(
				'label'   => esc_html__( 'Label', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Skill', 'rozholy-companion' ),
			)
		);
		$repeater->add_control(
			'percentage',
			array(
				'label'   => esc_html__( 'Percentage', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::SLIDER,
				'range'   => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default' => array( 'size' => 85 ),
			)
		);
		$this->add_control(
			'items',
			array(
				'label'       => esc_html__( 'Items', 'rozholy-companion' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'label'      => esc_html__( 'Hair Styling', 'rozholy-companion' ),
						'percentage' => array( 'size' => 95 ),
					),
					array(
						'label'      => esc_html__( 'Coloring', 'rozholy-companion' ),
						'percentage' => array( 'size' => 90 ),
					),
					array(
						'label'      => esc_html__( 'Skincare', 'rozholy-companion' ),
						'percentage' => array( 'size' => 85 ),
					),
				),
				'title_field' => '{{{ label }}}',
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
			'bar_color',
			array(
				'label'   => esc_html__( 'Bar Color', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '#d4a0a0',
			)
		);
		$this->add_control(
			'bar_bg',
			array(
				'label'   => esc_html__( 'Bar Background', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '#f0ece8',
			)
		);
		$this->end_controls_section();
	}

	public function render(): void {
		$s     = $this->get_settings_for_display();
		$items = $s['items'] ?? array();
		if ( empty( $items ) ) {
			return;
		}
		?>
		<div style="display:grid;gap:20px;">
			<?php
			foreach ( $items as $item ) :
				$pct = $item['percentage']['size'] ?? 0;
				?>
				<div>
					<div style="display:flex;justify-content:space-between;margin-bottom:6px;">
						<span style="font-weight:600;font-size:.95rem;"><?php echo esc_html( $item['label'] ); ?></span>
						<span style="color:#888;font-size:.85rem;"><?php echo intval( $pct ); ?>%</span>
					</div>
					<div style="height:10px;background:<?php echo esc_attr( $s['bar_bg'] ?: '#f0ece8' ); ?>;border-radius:5px;overflow:hidden;">
						<div style="height:100%;width:<?php echo intval( $pct ); ?>%;background:linear-gradient(90deg,<?php echo esc_attr( $s['bar_color'] ?: '#d4a0a0' ); ?>,<?php echo esc_attr( $s['bar_color'] ?: '#d4a0a0' ); ?>);border-radius:5px;transition:width 1s;"></div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}
}

class Rozholy_Widget_About_Section extends \Elementor\Widget_Base {
	public function get_name(): string {
		return 'rozholy_about_section'; }
	public function get_title(): string {
		return esc_html__( 'About Section', 'rozholy-companion' ); }
	public function get_icon(): string {
		return 'eicon-info-box'; }
	public function get_categories(): array {
		return array( 'rozholy-salon' ); }
	public function get_keywords(): array {
		return array( 'about', 'story', 'salon' ); }

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
				'default' => esc_html__( 'Our Story', 'rozholy-companion' ),
				'dynamic' => array( 'active' => true ),
			)
		);
		$this->add_control(
			'content',
			array(
				'label'   => esc_html__( 'Content', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'We are a premium beauty salon with years of experience.', 'rozholy-companion' ),
				'dynamic' => array( 'active' => true ),
			)
		);
		$this->add_control(
			'image',
			array(
				'label' => esc_html__( 'Image', 'rozholy-companion' ),
				'type'  => \Elementor\Controls_Manager::MEDIA,
			)
		);
		$this->add_control(
			'image_position',
			array(
				'label'   => esc_html__( 'Image Position', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'right',
				'options' => array(
					'left'  => esc_html__( 'Left', 'rozholy-companion' ),
					'right' => esc_html__( 'Right', 'rozholy-companion' ),
				),
			)
		);
		$this->end_controls_section();
	}

	public function render(): void {
		$s   = $this->get_settings_for_display();
		$img = $s['image']['url'] ?? '';
		$pos = $s['image_position'] ?? 'right';
		?>
		<div style="display:flex;align-items:center;gap:40px;flex-direction:<?php echo $pos === 'left' ? 'row' : 'row-reverse'; ?>;">
			<?php
			if ( $img ) :
				?>
				<div style="flex:1;border-radius:20px;overflow:hidden;"><img src="<?php echo esc_url( $img ); ?>" alt="" style="width:100%;height:auto;display:block;" /></div><?php endif; ?>
			<div style="flex:1;">
				<?php
				if ( $s['title'] ) :
					?>
					<h2 style="font-family:'Playfair Display',serif;margin:0 0 16px;font-size:2rem;"><?php echo esc_html( $s['title'] ); ?></h2><?php endif; ?>
				<?php
				if ( $s['content'] ) :
					?>
					<div style="color:#555;line-height:1.8;"><?php echo wp_kses_post( wpautop( $s['content'] ) ); ?></div><?php endif; ?>
			</div>
		</div>
		<?php
	}
}
