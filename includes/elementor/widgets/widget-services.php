<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Rozholy_Widget_Service_Card extends \Elementor\Widget_Base {
	public function get_name(): string {
		return 'rozholy_service_card'; }
	public function get_title(): string {
		return esc_html__( 'Service Card', 'rozholy-companion' ); }
	public function get_icon(): string {
		return 'eicon-info-box'; }
	public function get_categories(): array {
		return array( 'rozholy-salon' ); }
	public function get_keywords(): array {
		return array( 'service', 'card', 'beauty' ); }

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'rozholy-companion' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'icon',
			array(
				'label'   => esc_html__( 'Icon', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'fas fa-spa',
					'library' => 'fa-solid',
				),
			)
		);
		$this->add_control(
			'title',
			array(
				'label'   => esc_html__( 'Title', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Hair Styling', 'rozholy-companion' ),
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
			'price',
			array(
				'label'   => esc_html__( 'Price', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '500,000 تومان',
			)
		);
		$this->add_control(
			'link_text',
			array(
				'label'   => esc_html__( 'Link Text', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Details', 'rozholy-companion' ),
			)
		);
		$this->add_control(
			'link_url',
			array(
				'label'       => esc_html__( 'Link URL', 'rozholy-companion' ),
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
			'card_bg',
			array(
				'label'     => esc_html__( 'Background', 'rozholy-companion' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array( '.elementor {{WRAPPER}} .rz-service-card' => 'background: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'icon_color',
			array(
				'label'     => esc_html__( 'Icon Color', 'rozholy-companion' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#c08080',
				'selectors' => array( '.elementor {{WRAPPER}} .rz-service-card .rz-svc-icon' => 'color: {{VALUE}};' ),
			)
		);
		$this->end_controls_section();
	}

	public function render(): void {
		$s   = $this->get_settings_for_display();
		$url = ! empty( $s['link_url']['url'] ) ? $s['link_url']['url'] : '';
		?>
		<div class="rz-service-card" style="background:#fff;border:1px solid #e8ddd5;border-radius:16px;padding:35px 25px;text-align:center;transition:transform .3s ease,box-shadow .3s;position:relative;overflow:hidden;">
			<div style="position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#d4a0a0,#b8a0c0);"></div>
			<div style="width:64px;height:64px;margin:0 auto 18px;background:linear-gradient(135deg,#f0d0d0,#f5ece4);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.5rem;">
				<?php
				if ( $s['icon']['value'] ) :
					\Elementor\Icons_Manager::render_icon(
						$s['icon'],
						array(
							'class'       => 'rz-svc-icon',
							'aria-hidden' => 'true',
						)
					);
endif;
				?>
			</div>
			<?php
			if ( $s['title'] ) :
				?>
				<h3 style="font-family:'Playfair Display',serif;font-size:1.15rem;margin:0 0 10px;color:#2d2d2d;"><?php echo esc_html( $s['title'] ); ?></h3><?php endif; ?>
			<?php
			if ( $s['description'] ) :
				?>
				<p style="color:#7a7a7a;font-size:.9rem;line-height:1.7;margin:0 0 12px;"><?php echo esc_html( $s['description'] ); ?></p><?php endif; ?>
			<?php
			if ( $s['price'] ) :
				?>
				<span style="display:inline-block;background:#f5ece4;padding:4px 14px;border-radius:999px;font-size:.85rem;font-weight:600;color:#c08080;margin-bottom:12px;"><?php echo esc_html( $s['price'] ); ?></span><?php endif; ?>
			<?php
			if ( $url ) :
				?>
				<a href="<?php echo esc_url( $url ); ?>" style="display:inline-flex;align-items:center;gap:5px;font-size:.85rem;font-weight:600;color:#c08080;text-decoration:none;"><?php echo esc_html( $s['link_text'] ?: esc_html__( 'Details', 'rozholy-companion' ) ); ?> →</a><?php endif; ?>
		</div>
		<?php
	}
}

class Rozholy_Widget_Services_Grid extends \Elementor\Widget_Base {
	public function get_name(): string {
		return 'rozholy_services_grid'; }
	public function get_title(): string {
		return esc_html__( 'Services Grid', 'rozholy-companion' ); }
	public function get_icon(): string {
		return 'eicon-gallery-grid'; }
	public function get_categories(): array {
		return array( 'rozholy-salon' ); }
	public function get_keywords(): array {
		return array( 'services', 'grid' ); }

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Services', 'rozholy-companion' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'icon',
			array(
				'label'   => esc_html__( 'Icon', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'fas fa-star',
					'library' => 'fa-solid',
				),
			)
		);
		$repeater->add_control(
			'title',
			array(
				'label'   => esc_html__( 'Title', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Service', 'rozholy-companion' ),
			)
		);
		$repeater->add_control(
			'description',
			array(
				'label' => esc_html__( 'Description', 'rozholy-companion' ),
				'type'  => \Elementor\Controls_Manager::TEXTAREA,
				'rows'  => 2,
			)
		);
		$repeater->add_control(
			'price',
			array(
				'label' => esc_html__( 'Price', 'rozholy-companion' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
			)
		);
		$this->add_control(
			'services',
			array(
				'label'       => esc_html__( 'Services', 'rozholy-companion' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(),
				'title_field' => '{{{ title }}}',
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'layout_section',
			array(
				'label' => esc_html__( 'Layout', 'rozholy-companion' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'columns',
			array(
				'label'   => esc_html__( 'Columns', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '3',
				'options' => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'6' => '6',
				),
			)
		);
		$this->add_control(
			'gap',
			array(
				'label'   => esc_html__( 'Gap (px)', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 24,
			)
		);
		$this->end_controls_section();
	}

	public function render(): void {
		$s        = $this->get_settings_for_display();
		$services = $s['services'] ?? array();
		if ( empty( $services ) ) {
			return;
		}
		$cols = $s['columns'] ?? '3';
		$gap  = $s['gap'] ?? 24;
		?>
		<div style="display:grid;grid-template-columns:repeat(<?php echo intval( $cols ); ?>,1fr);gap:<?php echo intval( $gap ); ?>px;">
			<?php foreach ( $services as $svc ) : ?>
				<div class="rz-service-card" style="background:#fff;border:1px solid #e8ddd5;border-radius:16px;padding:30px 20px;text-align:center;">
					<?php
					if ( $svc['icon']['value'] ) :
						?>
						<div style="font-size:2rem;margin-bottom:12px;"><?php \Elementor\Icons_Manager::render_icon( $svc['icon'], array( 'aria-hidden' => 'true' ) ); ?></div><?php endif; ?>
					<?php
					if ( $svc['title'] ) :
						?>
						<h3 style="margin:0 0 8px;font-size:1.1rem;"><?php echo esc_html( $svc['title'] ); ?></h3><?php endif; ?>
					<?php
					if ( $svc['description'] ) :
						?>
						<p style="color:#7a7a7a;font-size:.9rem;line-height:1.7;margin:0 0 12px;"><?php echo esc_html( $svc['description'] ); ?></p><?php endif; ?>
					<?php
					if ( $svc['price'] ) :
						?>
						<span style="display:inline-block;background:#f5ece4;padding:4px 14px;border-radius:999px;font-size:.85rem;font-weight:600;color:#c08080;"><?php echo esc_html( $svc['price'] ); ?></span><?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}
}

class Rozholy_Widget_Pricing_Table extends \Elementor\Widget_Base {
	public function get_name(): string {
		return 'rozholy_pricing_table'; }
	public function get_title(): string {
		return esc_html__( 'Pricing Table', 'rozholy-companion' ); }
	public function get_icon(): string {
		return 'eicon-price-table'; }
	public function get_categories(): array {
		return array( 'rozholy-salon' ); }
	public function get_keywords(): array {
		return array( 'pricing', 'table', 'plans' ); }

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Plans', 'rozholy-companion' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'name',
			array(
				'label'   => esc_html__( 'Plan Name', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Basic', 'rozholy-companion' ),
			)
		);
		$repeater->add_control(
			'price',
			array(
				'label'   => esc_html__( 'Price', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '250,000',
			)
		);
		$repeater->add_control(
			'currency',
			array(
				'label'   => esc_html__( 'Currency', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'تومان',
			)
		);
		$repeater->add_control(
			'features',
			array(
				'label' => esc_html__( 'Features (one per line)', 'rozholy-companion' ),
				'type'  => \Elementor\Controls_Manager::TEXTAREA,
				'rows'  => 4,
			)
		);
		$repeater->add_control(
			'button_text',
			array(
				'label'   => esc_html__( 'Button Text', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Choose Plan', 'rozholy-companion' ),
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
			'featured',
			array(
				'label' => esc_html__( 'Featured', 'rozholy-companion' ),
				'type'  => \Elementor\Controls_Manager::SWITCHER,
			)
		);
		$this->add_control(
			'plans',
			array(
				'label'       => esc_html__( 'Plans', 'rozholy-companion' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'name'  => esc_html__( 'Basic', 'rozholy-companion' ),
						'price' => '250,000',
					),
					array(
						'name'     => esc_html__( 'Standard', 'rozholy-companion' ),
						'price'    => '500,000',
						'featured' => 'yes',
					),
					array(
						'name'  => esc_html__( 'Premium', 'rozholy-companion' ),
						'price' => '1,000,000',
					),
				),
				'title_field' => '{{{ name }}}',
			)
		);
		$this->end_controls_section();
	}

	public function render(): void {
		$s     = $this->get_settings_for_display();
		$plans = $s['plans'] ?? array();
		if ( empty( $plans ) ) {
			return;
		}
		?>
		<div style="display:grid;grid-template-columns:repeat(<?php echo count( $plans ); ?>,1fr);gap:24px;">
			<?php
			foreach ( $plans as $plan ) :
				$f = $plan['featured'] === 'yes';
				?>
				<div style="background:#fff;border:2px solid <?php echo $f ? '#d4a0a0' : '#e8ddd5'; ?>;border-radius:20px;padding:36px 24px;text-align:center;position:relative;transform:<?php echo $f ? 'scale(1.05)' : 'none'; ?>;">
					<?php
					if ( $f ) :
						?>
						<div style="position:absolute;top:-12px;left:50%;transform:translateX(-50%);background:#d4a0a0;color:#fff;padding:4px 20px;border-radius:999px;font-size:.8rem;font-weight:600;"><?php esc_html_e( 'Popular', 'rozholy-companion' ); ?></div><?php endif; ?>
					<?php
					if ( $plan['name'] ) :
						?>
						<h3 style="margin:0 0 16px;font-family:'Playfair Display',serif;"><?php echo esc_html( $plan['name'] ); ?></h3><?php endif; ?>
					<div style="font-size:2.5rem;font-weight:700;margin-bottom:20px;"><?php echo esc_html( $plan['price'] ); ?><small style="font-size:.9rem;font-weight:400;color:#888;"> <?php echo esc_html( $plan['currency'] ?: '' ); ?></small></div>
					<?php
					if ( $plan['features'] ) :
						?>
						<ul style="list-style:none;padding:0;margin:0 0 24px;text-align:center;">
						<?php
						foreach ( explode( "\n", $plan['features'] ) as $fitem ) :
							?>
	<li style="padding:6px 0;border-bottom:1px solid #f5ece4;"><?php echo esc_html( trim( $fitem ) ); ?></li><?php endforeach; ?></ul><?php endif; ?>
					<?php
					if ( $plan['button_text'] && ! empty( $plan['button_url']['url'] ) ) :
						?>
						<a href="<?php echo esc_url( $plan['button_url']['url'] ); ?>" style="display:inline-block;padding:12px 32px;border-radius:50px;background:<?php echo $f ? '#d4a0a0' : '#f5ece4'; ?>;color:<?php echo $f ? '#fff' : '#c08080'; ?>;font-weight:600;text-decoration:none;"><?php echo esc_html( $plan['button_text'] ); ?></a><?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}
}

class Rozholy_Widget_Products_Grid extends \Elementor\Widget_Base {
	public function get_name(): string {
		return 'rozholy_products_grid'; }
	public function get_title(): string {
		return esc_html__( 'Products Grid', 'rozholy-companion' ); }
	public function get_icon(): string {
		return 'eicon-products'; }
	public function get_categories(): array {
		return array( 'rozholy-salon' ); }
	public function get_keywords(): array {
		return array( 'products', 'woocommerce', 'shop' ); }

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Settings', 'rozholy-companion' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'columns',
			array(
				'label'   => esc_html__( 'Columns', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '3',
				'options' => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				),
			)
		);
		$this->add_control(
			'count',
			array(
				'label'   => esc_html__( 'Number of Products', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 6,
				'min'     => 1,
				'max'     => 48,
			)
		);
		$this->add_control(
			'orderby',
			array(
				'label'   => esc_html__( 'Order By', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'date',
				'options' => array(
					'date'       => esc_html__( 'Date', 'rozholy-companion' ),
					'price'      => esc_html__( 'Price', 'rozholy-companion' ),
					'popularity' => esc_html__( 'Popularity', 'rozholy-companion' ),
					'rating'     => esc_html__( 'Rating', 'rozholy-companion' ),
					'title'      => esc_html__( 'Title', 'rozholy-companion' ),
					'rand'       => esc_html__( 'Random', 'rozholy-companion' ),
				),
			)
		);
		$this->add_control(
			'category',
			array(
				'label'       => esc_html__( 'Category', 'rozholy-companion' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'description' => esc_html__( 'Product category slug', 'rozholy-companion' ),
			)
		);
		$this->end_controls_section();
	}

	public function render(): void {
		$s = $this->get_settings_for_display();
		if ( ! class_exists( 'WooCommerce' ) ) {
			echo '<p>' . esc_html__( 'WooCommerce is not active.', 'rozholy-companion' ) . '</p>';
			return; }
		$args = array(
			'post_type'      => 'product',
			'posts_per_page' => intval( $s['count'] ?: 6 ),
			'orderby'        => $s['orderby'] ?? 'date',
		);
		if ( $s['category'] ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'slug',
					'terms'    => $s['category'],
				),
			);
		}
		$query = new WP_Query( $args );
		if ( ! $query->have_posts() ) {
			echo '<p>' . esc_html__( 'No products found.', 'rozholy-companion' ) . '</p>';
			return; }
		?>
		<div style="display:grid;grid-template-columns:repeat(<?php echo intval( $s['columns'] ?: 3 ); ?>,1fr);gap:20px;">
			<?php
			while ( $query->have_posts() ) :
				$query->the_post();
				global $product;
				?>
				<div style="background:#fff;border:1px solid #e8ddd5;border-radius:16px;overflow:hidden;transition:transform .3s;">
					<a href="<?php the_permalink(); ?>" style="display:block;text-decoration:none;color:inherit;">
						<div style="aspect-ratio:1;overflow:hidden;background:#f9f6f3;"><?php echo $product->get_image( 'woocommerce_thumbnail', array( 'style' => 'width:100%;height:100%;object-fit:cover;' ) ); ?></div>
						<div style="padding:16px;"><h3 style="margin:0 0 6px;font-size:.95rem;"><?php echo esc_html( get_the_title() ); ?></h3><span style="color:#c08080;font-weight:600;"><?php echo $product->get_price_html(); ?></span></div>
					</a>
				</div>
				<?php
			endwhile;
			wp_reset_postdata();
			?>
		</div>
		<?php
	}
}
