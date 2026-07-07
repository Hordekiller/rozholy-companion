<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Rozholy_Widget_Testimonial_Card extends \Elementor\Widget_Base {
	public function get_name(): string {
		return 'rozholy_testimonial_card'; }
	public function get_title(): string {
		return esc_html__( 'Testimonial Card', 'rozholy-companion' ); }
	public function get_icon(): string {
		return 'eicon-testimonial'; }
	public function get_categories(): array {
		return array( 'rozholy-salon' ); }
	public function get_keywords(): array {
		return array( 'testimonial', 'review', 'customer' ); }

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'rozholy-companion' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'name',
			array(
				'label'   => esc_html__( 'Name', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Sarah Johnson', 'rozholy-companion' ),
				'dynamic' => array( 'active' => true ),
			)
		);
		$this->add_control(
			'role',
			array(
				'label'   => esc_html__( 'Role', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Regular Customer', 'rozholy-companion' ),
			)
		);
		$this->add_control(
			'content',
			array(
				'label'   => esc_html__( 'Testimonial', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'rows'    => 4,
				'default' => esc_html__( 'Amazing service! I love the results.', 'rozholy-companion' ),
				'dynamic' => array( 'active' => true ),
			)
		);
		$this->add_control(
			'rating',
			array(
				'label'   => esc_html__( 'Rating', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '5',
				'options' => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
				),
			)
		);
		$this->add_control(
			'avatar',
			array(
				'label' => esc_html__( 'Avatar', 'rozholy-companion' ),
				'type'  => \Elementor\Controls_Manager::MEDIA,
			)
		);
		$this->end_controls_section();
	}

	public function render(): void {
		$s      = $this->get_settings_for_display();
		$avatar = $s['avatar']['url'] ?? '';
		$stars  = str_repeat( '⭐', intval( $s['rating'] ?: 5 ) );
		?>
		<div style="background:#fff;border:1px solid #e8ddd5;border-radius:16px;padding:30px;transition:transform .3s ease,box-shadow .3s;">
			<div style="display:flex;gap:3px;margin-bottom:12px;font-size:1rem;"><?php echo $stars; ?></div>
			<blockquote style="margin:0 0 20px;padding:0;border:none;font-size:1rem;line-height:1.8;color:#4a4a4a;font-style:italic;">"<?php echo esc_html( $s['content'] ); ?>"</blockquote>
			<div style="display:flex;align-items:center;gap:12px;">
				<div style="width:44px;height:44px;border-radius:50%;overflow:hidden;flex-shrink:0;background:linear-gradient(135deg,#d4a0a0,#b8a0c0);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;">
					<?php
					if ( $avatar ) :
						?>
						<img src="<?php echo esc_url( $avatar ); ?>" alt="" style="width:100%;height:100%;object-fit:cover;" />
						<?php
else :
	?>
						<?php echo esc_html( mb_substr( $s['name'] ?: '?', 0, 1 ) ); ?><?php endif; ?>
				</div>
				<div><strong style="display:block;font-size:.95rem;color:#2d2d2d;"><?php echo esc_html( $s['name'] ); ?></strong>
				<?php
				if ( $s['role'] ) :
					?>
					<span style="font-size:.8rem;color:#7a7a7a;"><?php echo esc_html( $s['role'] ); ?></span><?php endif; ?></div>
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
		return 'eicon-slider-push'; }
	public function get_categories(): array {
		return array( 'rozholy-salon' ); }
	public function get_keywords(): array {
		return array( 'testimonials', 'slider', 'carousel' ); }

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
			'name',
			array(
				'label'   => esc_html__( 'Name', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Customer', 'rozholy-companion' ),
			)
		);
		$repeater->add_control(
			'role',
			array(
				'label' => esc_html__( 'Role', 'rozholy-companion' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
			)
		);
		$repeater->add_control(
			'content',
			array(
				'label' => esc_html__( 'Testimonial', 'rozholy-companion' ),
				'type'  => \Elementor\Controls_Manager::TEXTAREA,
				'rows'  => 3,
			)
		);
		$repeater->add_control(
			'rating',
			array(
				'label'   => esc_html__( 'Rating', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '5',
				'options' => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
				),
			)
		);
		$this->add_control(
			'testimonials',
			array(
				'label'       => esc_html__( 'Testimonials', 'rozholy-companion' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array( array( 'name' => esc_html__( 'Sarah', 'rozholy-companion' ) ), array( 'name' => esc_html__( 'Maria', 'rozholy-companion' ) ), array( 'name' => esc_html__( 'Emma', 'rozholy-companion' ) ) ),
				'title_field' => '{{{ name }}}',
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
		$this->end_controls_section();
	}

	public function render(): void {
		$s     = $this->get_settings_for_display();
		$items = $s['testimonials'] ?? array();
		if ( empty( $items ) ) {
			return;
		}
		?>
		<div class="rz-testimonials-slider swiper" style="overflow:hidden;padding:20px 0;">
			<div class="swiper-wrapper">
				<?php
				foreach ( $items as $item ) :
					$stars = str_repeat( '⭐', intval( $item['rating'] ?: 5 ) );
					?>
					<div class="swiper-slide" style="height:auto;">
						<div style="background:#fff;border:1px solid #e8ddd5;border-radius:16px;padding:30px;height:100%;display:flex;flex-direction:column;">
							<div style="display:flex;gap:3px;margin-bottom:12px;"><?php echo $stars; ?></div>
							<?php
							if ( $item['content'] ) :
								?>
								<blockquote style="margin:0 0 20px;font-size:1rem;line-height:1.8;color:#4a4a4a;font-style:italic;flex:1;">"<?php echo esc_html( $item['content'] ); ?>"</blockquote><?php endif; ?>
							<div style="display:flex;align-items:center;gap:12px;">
								<div style="width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,#d4a0a0,#b8a0c0);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;"><?php echo esc_html( mb_substr( $item['name'] ?: '?', 0, 1 ) ); ?></div>
								<div><strong style="display:block;"><?php echo esc_html( $item['name'] ); ?></strong>
								<?php
								if ( $item['role'] ) :
									?>
									<span style="font-size:.8rem;color:#7a7a7a;"><?php echo esc_html( $item['role'] ); ?></span><?php endif; ?></div>
							</div>
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

class Rozholy_Widget_Team_Member extends \Elementor\Widget_Base {
	public function get_name(): string {
		return 'rozholy_team_member'; }
	public function get_title(): string {
		return esc_html__( 'Team Member', 'rozholy-companion' ); }
	public function get_icon(): string {
		return 'eicon-person'; }
	public function get_categories(): array {
		return array( 'rozholy-salon' ); }
	public function get_keywords(): array {
		return array( 'team', 'member', 'staff', 'beautician' ); }

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'rozholy-companion' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'name',
			array(
				'label'   => esc_html__( 'Name', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Jane Doe', 'rozholy-companion' ),
				'dynamic' => array( 'active' => true ),
			)
		);
		$this->add_control(
			'role',
			array(
				'label'   => esc_html__( 'Role', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Senior Stylist', 'rozholy-companion' ),
			)
		);
		$this->add_control(
			'bio',
			array(
				'label' => esc_html__( 'Bio', 'rozholy-companion' ),
				'type'  => \Elementor\Controls_Manager::TEXTAREA,
				'rows'  => 3,
			)
		);
		$this->add_control(
			'image',
			array(
				'label' => esc_html__( 'Photo', 'rozholy-companion' ),
				'type'  => \Elementor\Controls_Manager::MEDIA,
			)
		);
		$this->add_control(
			'instagram',
			array(
				'label' => esc_html__( 'Instagram URL', 'rozholy-companion' ),
				'type'  => \Elementor\Controls_Manager::URL,
			)
		);
		$this->add_control(
			'linkedin',
			array(
				'label' => esc_html__( 'LinkedIn URL', 'rozholy-companion' ),
				'type'  => \Elementor\Controls_Manager::URL,
			)
		);
		$this->end_controls_section();
	}

	public function render(): void {
		$s   = $this->get_settings_for_display();
		$img = $s['image']['url'] ?? '';
		$ig  = ! empty( $s['instagram']['url'] ) ? $s['instagram']['url'] : '';
		$li  = ! empty( $s['linkedin']['url'] ) ? $s['linkedin']['url'] : '';
		?>
		<div style="background:#fff;border:1px solid #e8ddd5;border-radius:16px;padding:30px;text-align:center;transition:transform .3s;">
			<div style="width:120px;height:120px;border-radius:50%;margin:0 auto 16px;overflow:hidden;border:3px solid #f0d0d0;">
				<?php
				if ( $img ) :
					?>
					<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $s['name'] ); ?>" style="width:100%;height:100%;object-fit:cover;" />
					<?php
else :
	?>
					<div style="width:100%;height:100%;background:linear-gradient(135deg,#d4a0a0,#b8a0c0);display:flex;align-items:center;justify-content:center;color:#fff;font-size:2rem;"><?php echo esc_html( mb_substr( $s['name'] ?: '?', 0, 1 ) ); ?></div><?php endif; ?>
			</div>
			<?php
			if ( $s['name'] ) :
				?>
				<h3 style="margin:0 0 4px;font-family:'Playfair Display',serif;"><?php echo esc_html( $s['name'] ); ?></h3><?php endif; ?>
			<?php
			if ( $s['role'] ) :
				?>
				<p style="color:#c08080;font-size:.9rem;font-weight:600;margin:0 0 12px;"><?php echo esc_html( $s['role'] ); ?></p><?php endif; ?>
			<?php
			if ( $s['bio'] ) :
				?>
				<p style="color:#7a7a7a;font-size:.9rem;line-height:1.7;margin:0 0 16px;"><?php echo esc_html( $s['bio'] ); ?></p><?php endif; ?>
			<?php
			if ( $ig || $li ) :
				?>
				<div style="display:flex;gap:8px;justify-content:center;">
				<?php
				if ( $ig ) :
					?>
				<a href="<?php echo esc_url( $ig ); ?>" target="_blank" rel="noopener" style="width:36px;height:36px;border-radius:50%;background:#f5ece4;display:flex;align-items:center;justify-content:center;text-decoration:none;color:#c08080;font-size:.85rem;">ig</a><?php endif; ?>
				<?php
				if ( $li ) :
					?>
	<a href="<?php echo esc_url( $li ); ?>" target="_blank" rel="noopener" style="width:36px;height:36px;border-radius:50%;background:#f5ece4;display:flex;align-items:center;justify-content:center;text-decoration:none;color:#c08080;font-size:.85rem;">in</a><?php endif; ?></div><?php endif; ?>
		</div>
		<?php
	}
}

class Rozholy_Widget_Team_Grid extends \Elementor\Widget_Base {
	public function get_name(): string {
		return 'rozholy_team_grid'; }
	public function get_title(): string {
		return esc_html__( 'Team Grid', 'rozholy-companion' ); }
	public function get_icon(): string {
		return 'eicon-gallery-group'; }
	public function get_categories(): array {
		return array( 'rozholy-salon' ); }
	public function get_keywords(): array {
		return array( 'team', 'grid', 'staff' ); }

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Team Members', 'rozholy-companion' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'name',
			array(
				'label'   => esc_html__( 'Name', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Member', 'rozholy-companion' ),
			)
		);
		$repeater->add_control(
			'role',
			array(
				'label' => esc_html__( 'Role', 'rozholy-companion' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
			)
		);
		$repeater->add_control(
			'image',
			array(
				'label' => esc_html__( 'Photo', 'rozholy-companion' ),
				'type'  => \Elementor\Controls_Manager::MEDIA,
			)
		);
		$repeater->add_control(
			'instagram',
			array(
				'label' => esc_html__( 'Instagram', 'rozholy-companion' ),
				'type'  => \Elementor\Controls_Manager::URL,
			)
		);
		$this->add_control(
			'members',
			array(
				'label'       => esc_html__( 'Members', 'rozholy-companion' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array( array( 'name' => esc_html__( 'Jane', 'rozholy-companion' ) ), array( 'name' => esc_html__( 'Anna', 'rozholy-companion' ) ), array( 'name' => esc_html__( 'Lisa', 'rozholy-companion' ) ) ),
				'title_field' => '{{{ name }}}',
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
					'2' => '2',
					'3' => '3',
					'4' => '4',
				),
			)
		);
		$this->end_controls_section();
	}

	public function render(): void {
		$s       = $this->get_settings_for_display();
		$members = $s['members'] ?? array();
		if ( empty( $members ) ) {
			return;
		}
		?>
		<div style="display:grid;grid-template-columns:repeat(<?php echo intval( $s['columns'] ?: 3 ); ?>,1fr);gap:24px;">
			<?php
			foreach ( $members as $m ) :
				$img = $m['image']['url'] ?? '';
				$ig  = ! empty( $m['instagram']['url'] ) ? $m['instagram']['url'] : '';
				?>
				<div style="background:#fff;border:1px solid #e8ddd5;border-radius:16px;padding:24px;text-align:center;">
					<div style="width:90px;height:90px;border-radius:50%;margin:0 auto 12px;overflow:hidden;border:3px solid #f0d0d0;">
						<?php
						if ( $img ) :
							?>
							<img src="<?php echo esc_url( $img ); ?>" alt="" style="width:100%;height:100%;object-fit:cover;" />
							<?php
else :
	?>
							<div style="width:100%;height:100%;background:linear-gradient(135deg,#d4a0a0,#b8a0c0);display:flex;align-items:center;justify-content:center;color:#fff;"><?php echo esc_html( mb_substr( $m['name'] ?: '?', 0, 1 ) ); ?></div><?php endif; ?>
					</div>
					<?php
					if ( $m['name'] ) :
						?>
						<h4 style="margin:0 0 4px;"><?php echo esc_html( $m['name'] ); ?></h4><?php endif; ?>
					<?php
					if ( $m['role'] ) :
						?>
						<p style="color:#c08080;font-size:.85rem;margin:0 0 8px;"><?php echo esc_html( $m['role'] ); ?></p><?php endif; ?>
					<?php
					if ( $ig ) :
						?>
						<a href="<?php echo esc_url( $ig ); ?>" target="_blank" rel="noopener" style="display:inline-block;font-size:.8rem;color:#c08080;text-decoration:none;">@instagram</a><?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}
}


