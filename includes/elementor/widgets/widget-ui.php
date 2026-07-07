<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Rozholy_Widget_FAQ_Accordion extends \Elementor\Widget_Base {
	public function get_name(): string {
		return 'rozholy_faq_accordion'; }
	public function get_title(): string {
		return esc_html__( 'FAQ Accordion', 'rozholy-companion' ); }
	public function get_icon(): string {
		return 'eicon-accordion'; }
	public function get_categories(): array {
		return array( 'rozholy-salon' ); }
	public function get_keywords(): array {
		return array( 'faq', 'accordion', 'questions' ); }

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
			'question',
			array(
				'label'   => esc_html__( 'Question', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Frequently Asked Question?', 'rozholy-companion' ),
			)
		);
		$repeater->add_control(
			'answer',
			array(
				'label'   => esc_html__( 'Answer', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Answer goes here.', 'rozholy-companion' ),
			)
		);
		$this->add_control(
			'items',
			array(
				'label'       => esc_html__( 'FAQ Items', 'rozholy-companion' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'question' => esc_html__( 'How do I book an appointment?', 'rozholy-companion' ),
						'answer'   => esc_html__( 'You can book via our online form or call us directly.', 'rozholy-companion' ),
					),
					array(
						'question' => esc_html__( 'What services do you offer?', 'rozholy-companion' ),
						'answer'   => esc_html__( 'We offer haircuts, styling, coloring, skincare, and more.', 'rozholy-companion' ),
					),
				),
				'title_field' => '{{{ question }}}',
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
		<div style="border-top:1px solid #e8ddd5;">
			<?php foreach ( $items as $i => $item ) : ?>
				<details style="border-bottom:1px solid #e8ddd5;padding:16px 0;"<?php echo $i === 0 ? ' open' : ''; ?>>
					<summary style="font-weight:600;font-size:1.05rem;cursor:pointer;list-style:none;display:flex;justify-content:space-between;align-items:center;">
						<?php echo esc_html( $item['question'] ?? '' ); ?>
						<span style="font-size:.8rem;color:#c08080;">▼</span>
					</summary>
					<?php
					if ( $item['answer'] ) :
						?>
						<div style="margin-top:12px;color:#7a7a7a;line-height:1.8;"><?php echo wp_kses_post( wpautop( $item['answer'] ) ); ?></div><?php endif; ?>
				</details>
			<?php endforeach; ?>
		</div>
		<?php
	}
}

class Rozholy_Widget_Social_Links extends \Elementor\Widget_Base {
	public function get_name(): string {
		return 'rozholy_social_links'; }
	public function get_title(): string {
		return esc_html__( 'Social Links', 'rozholy-companion' ); }
	public function get_icon(): string {
		return 'eicon-social-icons'; }
	public function get_categories(): array {
		return array( 'rozholy-salon' ); }
	public function get_keywords(): array {
		return array( 'social', 'links', 'media' ); }

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Networks', 'rozholy-companion' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'network',
			array(
				'label'   => esc_html__( 'Platform', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'facebook',
				'options' => array(
					'facebook'  => 'Facebook',
					'x'         => 'X (Twitter)',
					'instagram' => 'Instagram',
					'linkedin'  => 'LinkedIn',
					'youtube'   => 'YouTube',
					'telegram'  => 'Telegram',
					'whatsapp'  => 'WhatsApp',
					'pinterest' => 'Pinterest',
					'tiktok'    => 'TikTok',
				),
			)
		);
		$repeater->add_control(
			'url',
			array(
				'label'       => esc_html__( 'URL', 'rozholy-companion' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => 'https://',
				'default'     => array( 'url' => '#' ),
			)
		);
		$this->add_control(
			'networks',
			array(
				'label'       => esc_html__( 'Networks', 'rozholy-companion' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'network' => 'instagram',
						'url'     => array( 'url' => '#' ),
					),
					array(
						'network' => 'telegram',
						'url'     => array( 'url' => '#' ),
					),
					array(
						'network' => 'whatsapp',
						'url'     => array( 'url' => '#' ),
					),
				),
				'title_field' => '{{{ network }}}',
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
			'size',
			array(
				'label'   => esc_html__( 'Size', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'medium',
				'options' => array(
					'small'  => esc_html__( 'Small', 'rozholy-companion' ),
					'medium' => esc_html__( 'Medium', 'rozholy-companion' ),
					'large'  => esc_html__( 'Large', 'rozholy-companion' ),
				),
			)
		);
		$this->add_control(
			'icon_style',
			array(
				'label'   => esc_html__( 'Style', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'colored',
				'options' => array(
					'colored'    => esc_html__( 'Colored', 'rozholy-companion' ),
					'monochrome' => esc_html__( 'Monochrome', 'rozholy-companion' ),
					'outline'    => esc_html__( 'Outline', 'rozholy-companion' ),
				),
			)
		);
		$this->end_controls_section();
	}

	public function render(): void {
		$s        = $this->get_settings_for_display();
		$networks = $s['networks'] ?? array();
		$size     = $s['size'] ?? 'medium';
		$style    = $s['icon_style'] ?? 'colored';
		$sizeMap  = array(
			'small'  => 32,
			'medium' => 44,
			'large'  => 56,
		);
		$labels   = array(
			'facebook'  => 'fb',
			'x'         => '𝕏',
			'instagram' => 'ig',
			'linkedin'  => 'in',
			'youtube'   => 'yt',
			'telegram'  => 'tg',
			'whatsapp'  => 'wa',
			'pinterest' => 'pi',
			'tiktok'    => 'tt',
		);
		?>
		<div style="display:flex;gap:8px;flex-wrap:wrap;">
			<?php
			foreach ( $networks as $net ) :
				$sz  = $sizeMap[ $size ] ?? 44;
				$url = ! empty( $net['url']['url'] ) ? $net['url']['url'] : '#';
				?>
				<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener" style="width:<?php echo $sz; ?>px;height:<?php echo $sz; ?>px;border-radius:50%;display:flex;align-items:center;justify-content:center;text-decoration:none;font-size:<?php echo round( $sz * .4 ); ?>px;font-weight:700;background:<?php echo $style === 'colored' ? '#d4a0a0' : ( $style === 'outline' ? 'transparent' : '#f0ece8' ); ?>;color:<?php echo $style === 'colored' ? '#fff' : ( $style === 'outline' ? '#d4a0a0' : '#555' ); ?>;border:<?php echo $style === 'outline' ? '2px solid #d4a0a0' : 'none'; ?>;"><?php echo esc_html( $labels[ $net['network'] ] ?? $net['network'] ); ?></a>
			<?php endforeach; ?>
		</div>
		<?php
	}
}

class Rozholy_Widget_Highlight_Box extends \Elementor\Widget_Base {
	public function get_name(): string {
		return 'rozholy_highlight_box'; }
	public function get_title(): string {
		return esc_html__( 'Highlight Box', 'rozholy-companion' ); }
	public function get_icon(): string {
		return 'eicon-alert'; }
	public function get_categories(): array {
		return array( 'rozholy-salon' ); }
	public function get_keywords(): array {
		return array( 'highlight', 'box', 'alert', 'info' ); }

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
					'value'   => 'fas fa-info-circle',
					'library' => 'fa-solid',
				),
			)
		);
		$this->add_control(
			'content',
			array(
				'label'   => esc_html__( 'Content', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Highlighted message here.', 'rozholy-companion' ),
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
			'variant',
			array(
				'label'   => esc_html__( 'Variant', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'info',
				'options' => array(
					'info'    => esc_html__( 'Info', 'rozholy-companion' ),
					'success' => esc_html__( 'Success', 'rozholy-companion' ),
					'warning' => esc_html__( 'Warning', 'rozholy-companion' ),
					'danger'  => esc_html__( 'Danger', 'rozholy-companion' ),
				),
			)
		);
		$this->end_controls_section();
	}

	public function render(): void {
		$s    = $this->get_settings_for_display();
		$vars = array(
			'info'    => array(
				'bg'     => '#e3f2fd',
				'border' => '#90caf9',
				'color'  => '#1565c0',
			),
			'success' => array(
				'bg'     => '#e8f5e9',
				'border' => '#a5d6a7',
				'color'  => '#2e7d32',
			),
			'warning' => array(
				'bg'     => '#fff3e0',
				'border' => '#ffcc80',
				'color'  => '#e65100',
			),
			'danger'  => array(
				'bg'     => '#fce4ec',
				'border' => '#ef9a9a',
				'color'  => '#c62828',
			),
		);
		$v    = $vars[ $s['variant'] ?? 'info' ] ?? $vars['info'];
		?>
		<div style="padding:16px 20px;border-radius:12px;background:<?php echo esc_attr( $v['bg'] ); ?>;border:1px solid <?php echo esc_attr( $v['border'] ); ?>;color:<?php echo esc_attr( $v['color'] ); ?>;display:flex;gap:12px;align-items:flex-start;">
			<?php
			$hi_icon = is_string( $s['icon'] ) ? array( 'value' => $s['icon'], 'library' => 'fa-solid' ) : ( $s['icon'] ?? array() );
			if ( ! empty( $hi_icon['value'] ) ) :
				?>
				<span style="font-size:1.5rem;flex-shrink:0;"><?php \Elementor\Icons_Manager::render_icon( $hi_icon, array( 'aria-hidden' => 'true' ) ); ?></span><?php endif; ?>
			<div><?php echo wp_kses_post( wpautop( $s['content'] ) ); ?></div>
		</div>
		<?php
	}
}

class Rozholy_Widget_Step_By_Step extends \Elementor\Widget_Base {
	public function get_name(): string {
		return 'rozholy_step_by_step'; }
	public function get_title(): string {
		return esc_html__( 'Step by Step', 'rozholy-companion' ); }
	public function get_icon(): string {
		return 'eicon-number-field'; }
	public function get_categories(): array {
		return array( 'rozholy-salon' ); }
	public function get_keywords(): array {
		return array( 'steps', 'process', 'guide' ); }

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Steps', 'rozholy-companion' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'title',
			array(
				'label'   => esc_html__( 'Title', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Step', 'rozholy-companion' ),
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
		$this->add_control(
			'steps',
			array(
				'label'       => esc_html__( 'Steps', 'rozholy-companion' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array( array( 'title' => esc_html__( 'Consultation', 'rozholy-companion' ) ), array( 'title' => esc_html__( 'Treatment', 'rozholy-companion' ) ), array( 'title' => esc_html__( 'Results', 'rozholy-companion' ) ) ),
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
			'layout',
			array(
				'label'   => esc_html__( 'Layout', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'vertical',
				'options' => array(
					'vertical'   => esc_html__( 'Vertical', 'rozholy-companion' ),
					'horizontal' => esc_html__( 'Horizontal', 'rozholy-companion' ),
				),
			)
		);
		$this->end_controls_section();
	}

	public function render(): void {
		$s     = $this->get_settings_for_display();
		$steps = $s['steps'] ?? array();
		if ( empty( $steps ) ) {
			return;
		}
		$h = $s['layout'] === 'horizontal';
		?>
		<div style="display:flex;flex-direction:<?php echo $h ? 'row' : 'column'; ?>;gap:24px;">
			<?php foreach ( $steps as $i => $step ) : ?>
				<div style="flex:1;position:relative;padding:<?php echo $h ? '20px 16px' : '20px 16px 20px 48px'; ?>;background:#fff;border:1px solid #e8ddd5;border-radius:16px;">
					<div style="<?php echo $h ? '' : 'position:absolute;top:20px;right:16px;'; ?>width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#d4a0a0,#b8a0c0);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;margin-bottom:8px;"><?php echo $i + 1; ?></div>
					<?php
					if ( $step['title'] ) :
						?>
						<h4 style="margin:0 0 6px;"><?php echo esc_html( $step['title'] ); ?></h4><?php endif; ?>
					<?php
					if ( $step['description'] ) :
						?>
						<p style="margin:0;color:#7a7a7a;font-size:.9rem;"><?php echo esc_html( $step['description'] ); ?></p><?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}
}

class Rozholy_Widget_Empty_State extends \Elementor\Widget_Base {
	public function get_name(): string {
		return 'rozholy_empty_state'; }
	public function get_title(): string {
		return esc_html__( 'Empty State', 'rozholy-companion' ); }
	public function get_icon(): string {
		return 'eicon-info-box'; }
	public function get_categories(): array {
		return array( 'rozholy-salon' ); }
	public function get_keywords(): array {
		return array( 'empty', 'state', 'placeholder' ); }

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
					'value'   => 'fas fa-box-open',
					'library' => 'fa-solid',
				),
			)
		);
		$this->add_control(
			'title',
			array(
				'label'   => esc_html__( 'Title', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Coming Soon', 'rozholy-companion' ),
			)
		);
		$this->add_control(
			'description',
			array(
				'label' => esc_html__( 'Description', 'rozholy-companion' ),
				'type'  => \Elementor\Controls_Manager::TEXTAREA,
				'rows'  => 2,
			)
		);
		$this->add_control(
			'button_text',
			array(
				'label' => esc_html__( 'Button Text', 'rozholy-companion' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
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
		$btn_url = ! empty( $s['button_url']['url'] ) ? $s['button_url']['url'] : '';
		?>
		<div style="text-align:center;padding:60px 20px;background:#f9f6f3;border:2px dashed #e8ddd5;border-radius:20px;">
			<?php
			$so_icon = is_string( $s['icon'] ) ? array( 'value' => $s['icon'], 'library' => 'fa-solid' ) : ( $s['icon'] ?? array() );
			if ( ! empty( $so_icon['value'] ) ) :
				?>
				<div style="font-size:3rem;margin-bottom:12px;"><?php \Elementor\Icons_Manager::render_icon( $so_icon, array( 'aria-hidden' => 'true' ) ); ?></div><?php endif; ?>
			<?php
			if ( $s['title'] ) :
				?>
				<h3 style="margin:0 0 8px;font-family:'Playfair Display',serif;"><?php echo esc_html( $s['title'] ); ?></h3><?php endif; ?>
			<?php
			if ( $s['description'] ) :
				?>
				<p style="color:#7a7a7a;margin:0 0 20px;"><?php echo esc_html( $s['description'] ); ?></p><?php endif; ?>
			<?php
			if ( $s['button_text'] && $btn_url ) :
				?>
				<a href="<?php echo esc_url( $btn_url ); ?>" style="display:inline-block;padding:12px 28px;border-radius:50px;background:linear-gradient(135deg,#d4a0a0,#b8a0c0);color:#fff;font-weight:600;text-decoration:none;"><?php echo esc_html( $s['button_text'] ); ?></a><?php endif; ?>
		</div>
		<?php
	}
}

class Rozholy_Widget_Floating_Contact extends \Elementor\Widget_Base {
	public function get_name(): string {
		return 'rozholy_floating_contact'; }
	public function get_title(): string {
		return esc_html__( 'Floating Contact', 'rozholy-companion' ); }
	public function get_icon(): string {
		return 'eicon-chat'; }
	public function get_categories(): array {
		return array( 'rozholy-salon' ); }
	public function get_keywords(): array {
		return array( 'floating', 'contact', 'chat', 'phone' ); }

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Buttons', 'rozholy-companion' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'phone',
			array(
				'label'   => esc_html__( 'Phone Number', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '+989123456789',
			)
		);
		$this->add_control(
			'whatsapp',
			array(
				'label'   => esc_html__( 'WhatsApp Number', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '+989123456789',
			)
		);
		$this->add_control(
			'telegram',
			array(
				'label'   => esc_html__( 'Telegram Username', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'rozholy_salon',
			)
		);
		$this->add_control(
			'position',
			array(
				'label'   => esc_html__( 'Position', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'bottom-left',
				'options' => array(
					'bottom-left'  => esc_html__( 'Bottom Left', 'rozholy-companion' ),
					'bottom-right' => esc_html__( 'Bottom Right', 'rozholy-companion' ),
				),
			)
		);
		$this->end_controls_section();
	}

	public function render(): void {
		$s   = $this->get_settings_for_display();
		$pos = $s['position'] === 'bottom-right' ? 'right:20px;' : 'left:20px;';
		?>
		<div style="position:fixed;bottom:20px;<?php echo esc_attr( $pos ); ?>z-index:999;display:flex;flex-direction:column;gap:8px;">
			<?php
			if ( $s['phone'] ) :
				?>
				<a href="tel:<?php echo esc_attr( $s['phone'] ); ?>" style="width:52px;height:52px;border-radius:50%;background:#4CAF50;color:#fff;display:flex;align-items:center;justify-content:center;text-decoration:none;box-shadow:0 4px 12px rgba(0,0,0,.2);font-size:24px;">📞</a><?php endif; ?>
			<?php
			if ( $s['whatsapp'] ) :
				?>
				<a href="https://wa.me/<?php echo esc_attr( preg_replace( '/[^0-9]/', '', $s['whatsapp'] ) ); ?>" target="_blank" rel="noopener" style="width:52px;height:52px;border-radius:50%;background:#25D366;color:#fff;display:flex;align-items:center;justify-content:center;text-decoration:none;box-shadow:0 4px 12px rgba(0,0,0,.2);font-size:24px;">💬</a><?php endif; ?>
			<?php
			if ( $s['telegram'] ) :
				?>
				<a href="https://t.me/<?php echo esc_attr( $s['telegram'] ); ?>" target="_blank" rel="noopener" style="width:52px;height:52px;border-radius:50%;background:#0088cc;color:#fff;display:flex;align-items:center;justify-content:center;text-decoration:none;box-shadow:0 4px 12px rgba(0,0,0,.2);font-size:24px;">✈️</a><?php endif; ?>
		</div>
		<?php
	}
}
