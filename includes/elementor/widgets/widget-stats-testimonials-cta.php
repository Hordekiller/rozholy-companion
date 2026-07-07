<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Rozholy_Widget_Stats_Counter extends \Elementor\Widget_Base {
	public function get_name(): string {
		return 'rozholy_stats_counter'; }
	public function get_title(): string {
		return esc_html__( 'Stats Counter', 'rozholy-companion' ); }
	public function get_icon(): string {
		return 'eicon-counter'; }
	public function get_categories(): array {
		return array( 'rozholy-salon' ); }
	public function get_keywords(): array {
		return array( 'stats', 'counter', 'numbers', 'statistics' ); }

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Stats Items', 'rozholy-companion' ),
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
			'prefix',
			array(
				'label'   => esc_html__( 'Prefix', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			)
		);
		$repeater->add_control(
			'number',
			array(
				'label'   => esc_html__( 'Number', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 5000,
			)
		);
		$repeater->add_control(
			'suffix',
			array(
				'label'   => esc_html__( 'Suffix', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '+', 'rozholy-companion' ),
			)
		);
		$repeater->add_control(
			'label',
			array(
				'label'   => esc_html__( 'Label', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Customers', 'rozholy-companion' ),
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
						'icon'   => array(
							'value'   => 'fas fa-smile',
							'library' => 'fa-solid',
						),
						'number' => 5000,
						'label'  => esc_html__( 'مشتریان خوشحال', 'rozholy-companion' ),
					),
					array(
						'icon'   => array(
							'value'   => 'fas fa-cut',
							'library' => 'fa-solid',
						),
						'number' => 150,
						'label'  => esc_html__( 'خدمات ارائه شده', 'rozholy-companion' ),
					),
					array(
						'icon'   => array(
							'value'   => 'fas fa-award',
							'library' => 'fa-solid',
						),
						'number' => 12,
						'label'  => esc_html__( 'سال تجربه', 'rozholy-companion' ),
					),
					array(
						'icon'   => array(
							'value'   => 'fas fa-star',
							'library' => 'fa-solid',
						),
						'number' => 49,
						'label'  => esc_html__( 'امتیاز', 'rozholy-companion' ),
						'prefix' => '4.',
						'suffix' => '',
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
			'bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'rozholy-companion' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1a1a2e',
				'selectors' => array( '.elementor {{WRAPPER}} .rz-stats-wrap' => 'background-color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'number_color',
			array(
				'label'     => esc_html__( 'Number Color', 'rozholy-companion' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#d4a0a0',
				'selectors' => array( '.elementor {{WRAPPER}} .rz-stat-number' => 'color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'label_color',
			array(
				'label'     => esc_html__( 'Label Color', 'rozholy-companion' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(255,255,255,0.8)',
				'selectors' => array( '.elementor {{WRAPPER}} .rz-stat-label' => 'color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'columns',
			array(
				'label'   => esc_html__( 'Columns', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '4',
				'options' => array(
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'6' => '6',
				),
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
		$cols = $s['columns'] ?? '4';
		?>
		<div class="rz-stats-wrap" style="padding:60px 20px;text-align:center;">
			<div style="display:grid;grid-template-columns:repeat(<?php echo intval( $cols ); ?>,1fr);gap:30px;max-width:1100px;margin:0 auto;">
				<?php foreach ( $items as $item ) : ?>
					<div style="padding:10px;">
						<?php if ( $item['icon']['value'] ) : ?>
							<div style="font-size:2rem;margin-bottom:10px;color:#d4a0a0;"><?php \Elementor\Icons_Manager::render_icon( $item['icon'], array( 'aria-hidden' => 'true' ) ); ?></div>
						<?php endif; ?>
						<div class="rz-stat-number" style="font-size:clamp(2rem,4vw,3.5rem);font-weight:700;line-height:1.2;margin-bottom:4px;direction:ltr;">
							<?php echo esc_html( $item['prefix'] ?? '' ); ?><span class="rz-counter" data-target="<?php echo intval( $item['number'] ); ?>">0</span><?php echo esc_html( $item['suffix'] ?? '' ); ?>
						</div>
						<?php
						if ( $item['label'] ) :
							?>
							<div class="rz-stat-label" style="font-size:0.95rem;opacity:0.8;"><?php echo esc_html( $item['label'] ); ?></div><?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}
}

class Rozholy_Widget_Testimonials_Slider extends \Elementor\Widget_Base {
	public function get_name(): string {
		return 'rozholy_testimonials_slider'; }
	public function get_title(): string {
		return esc_html__( 'Testimonials Slider', 'rozholy-companion' ); }
	public function get_icon(): string {
		return 'eicon-testimonial-carousel'; }
	public function get_categories(): array {
		return array( 'rozholy-salon' ); }
	public function get_keywords(): array {
		return array( 'testimonial', 'review', 'carousel', 'slider' ); }

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Testimonials', 'rozholy-companion' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'avatar',
			array(
				'label' => esc_html__( 'Avatar', 'rozholy-companion' ),
				'type'  => \Elementor\Controls_Manager::MEDIA,
			)
		);
		$repeater->add_control(
			'name',
			array(
				'label'   => esc_html__( 'Name', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Mona', 'rozholy-companion' ),
			)
		);
		$repeater->add_control(
			'title',
			array(
				'label'   => esc_html__( 'Title', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Regular Client', 'rozholy-companion' ),
			)
		);
		$repeater->add_control(
			'content',
			array(
				'label'   => esc_html__( 'Testimonial', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'rows'    => 4,
				'default' => esc_html__( 'Amazing service! I love coming here.', 'rozholy-companion' ),
			)
		);
		$repeater->add_control(
			'rating',
			array(
				'label'   => esc_html__( 'Rating', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 5,
				'min'     => 1,
				'max'     => 5,
				'step'    => 0.5,
			)
		);
		$this->add_control(
			'testimonials',
			array(
				'label'       => esc_html__( 'Testimonials', 'rozholy-companion' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'name'    => 'سارا محمدی',
						'content' => esc_html__( 'بهترین salon تهران! از خدماتشون فوق‌العاده راضی هستم.', 'rozholy-companion' ),
					),
					array(
						'name'    => 'مریم احمدی',
						'content' => esc_html__( 'کیفیت کار و تیم حرفه‌ای‌شون عالیه. حتماً پیشنهاد می‌کنم.', 'rozholy-companion' ),
					),
					array(
						'name'    => 'زهرا کریمی',
						'content' => esc_html__( 'فضای salon بسیار زیبا و دلنشینه. نتیجه کار فراتر از انتظارم بود.', 'rozholy-companion' ),
					),
				),
				'title_field' => '{{{ name }}}',
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
			'bg_color',
			array(
				'label'     => esc_html__( 'Background', 'rozholy-companion' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#f9f6f3',
				'selectors' => array( '.elementor {{WRAPPER}} .rz-testimonials-wrap' => 'background-color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'card_bg',
			array(
				'label'     => esc_html__( 'Card Background', 'rozholy-companion' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array( '.elementor {{WRAPPER}} .rz-testimonial-card' => 'background-color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'rozholy-companion' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => array( '.elementor {{WRAPPER}} .rz-testimonial-card' => 'color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'autoplay',
			array(
				'label'   => esc_html__( 'Autoplay (ms)', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 4000,
				'min'     => 0,
			)
		);
		$this->end_controls_section();
	}

	public function render(): void {
		$s     = $this->get_settings_for_display();
		$items = $s['testimonials'] ?? array();
		if ( empty( $items ) ) {
			return;
		}
		$autoplay  = absint( $s['autoplay'] ?? 4000 );
		$slider_id = 'rz-test-' . $this->get_id();
		?>
		<div class="rz-testimonials-wrap" style="padding:60px 20px;overflow:hidden;">
			<div id="<?php echo esc_attr( $slider_id ); ?>" class="rz-testimonials-track" style="display:flex;gap:24px;transition:transform 0.5s ease;scroll-snap-type:x mandatory;overflow-x:auto;scrollbar-width:none;-ms-overflow-style:none;padding:20px 0;">
				<?php
				foreach ( $items as $item ) :
					$avatar_url = $item['avatar']['url'] ?? '';
					$rating     = floatval( $item['rating'] ?? 5 );
					?>
					<div class="rz-testimonial-card" style="flex:0 0 calc(33.333% - 16px);min-width:280px;background:#fff;border-radius:20px;padding:30px;box-shadow:0 4px 20px rgba(0,0,0,0.06);scroll-snap-align:start;display:flex;flex-direction:column;">
						<div style="display:flex;gap:4px;margin-bottom:14px;">
							<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
								<span style="color:<?php echo $i <= $rating ? '#f4b942' : '#ddd'; ?>;font-size:1.1rem;">★</span>
							<?php endfor; ?>
						</div>
						<blockquote style="margin:0 0 20px;font-style:italic;line-height:1.8;flex:1;font-size:0.95rem;color:#555;"><?php echo esc_html( $item['content'] ); ?></blockquote>
						<div style="display:flex;align-items:center;gap:12px;border-top:1px solid #f0ece8;padding-top:16px;">
							<?php if ( $avatar_url ) : ?>
								<img src="<?php echo esc_url( $avatar_url ); ?>" alt="" style="width:48px;height:48px;border-radius:50%;object-fit:cover;" />
							<?php else : ?>
								<div style="width:48px;height:48px;border-radius:50%;background:linear-gradient(135deg,#d4a0a0,#b8a0c0);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;"><?php echo esc_html( mb_substr( $item['name'], 0, 1 ) ); ?></div>
							<?php endif; ?>
							<div>
								<strong style="display:block;font-size:0.95rem;"><?php echo esc_html( $item['name'] ); ?></strong>
								<?php
								if ( $item['title'] ) :
									?>
									<span style="font-size:0.8rem;color:#999;"><?php echo esc_html( $item['title'] ); ?></span><?php endif; ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<div style="display:flex;justify-content:center;gap:8px;margin-top:24px;">
				<?php foreach ( $items as $i => $item ) : ?>
					<button type="button" data-index="<?php echo intval( $i ); ?>" aria-label="<?php esc_attr_e( 'Go to testimonial', 'rozholy-companion' ); ?> <?php echo intval( $i + 1 ); ?>" style="width:10px;height:10px;border-radius:50%;border:none;background:<?php echo $i === 0 ? '#d4a0a0' : '#ddd'; ?>;cursor:pointer;padding:0;transition:background 0.3s;" class="rz-test-dot"></button>
				<?php endforeach; ?>
			</div>
		</div>
		<?php if ( $autoplay > 0 ) : ?>
		<script>
		(function(){
			var track = document.getElementById('<?php echo esc_js( $slider_id ); ?>');
			if (!track) return;
			var dots = track.parentElement.querySelectorAll('.rz-test-dot');
			var scrollInterval = setInterval(function(){
				if (!track.matches(':hover')) {
					var max = track.scrollWidth - track.clientWidth;
					var next = track.scrollLeft + track.clientWidth * 0.9;
					if (next >= max) next = 0;
					track.scrollTo({ left: next, behavior: 'smooth' });
				}
			}, <?php echo intval( $autoplay ); ?>);
			dots.forEach(function(d){
				d.addEventListener('click', function(){
					var idx = parseInt(this.getAttribute('data-index'));
					var card = track.children[idx];
					if (card) card.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'start' });
				});
			});
			track.addEventListener('scroll', function(){
				var idx = Math.round(track.scrollLeft / (track.children[0]?.offsetWidth + 24 || 300));
				dots.forEach(function(d, i){ d.style.background = i === idx ? '#d4a0a0' : '#ddd'; });
			});
		})();
		</script>
			<?php
		endif;
	}
}

class Rozholy_Widget_Cta_Banner extends \Elementor\Widget_Base {
	public function get_name(): string {
		return 'rozholy_cta_banner'; }
	public function get_title(): string {
		return esc_html__( 'CTA Banner', 'rozholy-companion' ); }
	public function get_icon(): string {
		return 'eicon-call-to-action'; }
	public function get_categories(): array {
		return array( 'rozholy-salon' ); }
	public function get_keywords(): array {
		return array( 'cta', 'banner', 'call', 'action' ); }

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
				'default' => esc_html__( 'آماده‌ای تا تغییر را تجربه کنی؟', 'rozholy-companion' ),
				'dynamic' => array( 'active' => true ),
			)
		);
		$this->add_control(
			'subtitle',
			array(
				'label'   => esc_html__( 'Subtitle', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'rows'    => 2,
				'default' => esc_html__( 'همین حالا نوبت خود را رزرو کن و از تخفیف ویژه اولین جلسه بهره‌مند شو.', 'rozholy-companion' ),
				'dynamic' => array( 'active' => true ),
			)
		);
		$this->add_control(
			'button_text',
			array(
				'label'   => esc_html__( 'Button Text', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'رزرو نوبت', 'rozholy-companion' ),
			)
		);
		$this->add_control(
			'button_url',
			array(
				'label'       => esc_html__( 'Button URL', 'rozholy-companion' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => 'https://',
				'default'     => array( 'url' => '#' ),
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
				'name'           => 'background',
				'label'          => esc_html__( 'Background Gradient', 'rozholy-companion' ),
				'types'          => array( 'gradient' ),
				'selector'       => '.elementor {{WRAPPER}} .rz-cta-banner',
				'fields_options' => array(
					'background'     => array( 'default' => 'gradient' ),
					'gradient_angle' => array( 'default' => '135' ),
					'color_a'        => array( 'default' => '#d4a0a0' ),
					'color_b'        => array( 'default' => '#b8a0c0' ),
				),
			)
		);
		$this->add_control(
			'text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'rozholy-companion' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array( '.elementor {{WRAPPER}} .rz-cta-banner' => 'color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'btn_color',
			array(
				'label'     => esc_html__( 'Button Background', 'rozholy-companion' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array( '.elementor {{WRAPPER}} .rz-cta-btn' => 'background-color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'btn_text_color',
			array(
				'label'     => esc_html__( 'Button Text Color', 'rozholy-companion' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3a2a3a',
				'selectors' => array( '.elementor {{WRAPPER}} .rz-cta-btn' => 'color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'max_width',
			array(
				'label'   => esc_html__( 'Max Width (px)', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 900,
			)
		);
		$this->add_control(
			'border_radius',
			array(
				'label'   => esc_html__( 'Border Radius (px)', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 30,
			)
		);
		$this->end_controls_section();
	}

	public function render(): void {
		$s       = $this->get_settings_for_display();
		$btn_url = ! empty( $s['button_url']['url'] ) ? $s['button_url']['url'] : '#';
		$max_w   = absint( $s['max_width'] ?: 900 );
		$radius  = absint( $s['border_radius'] ?: 30 );
		?>
		<div class="rz-cta-banner" style="border-radius:<?php echo esc_attr( $radius ); ?>px;padding:clamp(40px,5vw,80px) clamp(24px,4vw,60px);text-align:center;max-width:<?php echo esc_attr( $max_w ); ?>px;margin:0 auto;">
			<?php
			if ( $s['title'] ) :
				?>
				<h2 style="font-size:clamp(1.5rem,3vw,2.5rem);font-family:'Playfair Display',serif;margin:0 0 12px;color:inherit;"><?php echo esc_html( $s['title'] ); ?></h2><?php endif; ?>
			<?php
			if ( $s['subtitle'] ) :
				?>
				<p style="font-size:1.05rem;opacity:0.9;margin:0 0 28px;line-height:1.8;max-width:600px;margin-left:auto;margin-right:auto;color:inherit;"><?php echo esc_html( $s['subtitle'] ); ?></p><?php endif; ?>
			<?php if ( $s['button_text'] ) : ?>
				<a href="<?php echo esc_url( $btn_url ); ?>" class="rz-cta-btn" style="display:inline-block;padding:16px 44px;border-radius:50px;font-weight:600;font-size:1.05rem;text-decoration:none;transition:transform 0.3s,box-shadow 0.3s;box-shadow:0 4px 15px rgba(0,0,0,0.15);">
					<?php echo esc_html( $s['button_text'] ); ?>
				</a>
			<?php endif; ?>
		</div>
		<?php
	}
}
