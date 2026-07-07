<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Rozholy_Widget_Gallery_Grid extends \Elementor\Widget_Base {
	public function get_name(): string {
		return 'rozholy_gallery_grid'; }
	public function get_title(): string {
		return esc_html__( 'Gallery Grid', 'rozholy-companion' ); }
	public function get_icon(): string {
		return 'eicon-gallery-masonry'; }
	public function get_categories(): array {
		return array( 'rozholy-salon' ); }
	public function get_keywords(): array {
		return array( 'gallery', 'images', 'photos' ); }

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Images', 'rozholy-companion' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'gallery',
			array(
				'label'   => esc_html__( 'Gallery', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::GALLERY,
				'default' => array(),
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
					'5' => '5',
					'6' => '6',
				),
			)
		);
		$this->add_control(
			'image_height',
			array(
				'label'   => esc_html__( 'Image Height (px)', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 250,
			)
		);
		$this->add_control(
			'lightbox',
			array(
				'label'   => esc_html__( 'Lightbox', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);
		$this->end_controls_section();
	}

	public function render(): void {
		$s      = $this->get_settings_for_display();
		$images = $s['gallery'] ?? array();
		if ( empty( $images ) ) {
			return;
		}
		$cols   = $s['columns'] ?? '3';
		$height = $s['image_height'] ?? 250;
		?>
		<div style="display:grid;grid-template-columns:repeat(<?php echo intval( $cols ); ?>,1fr);gap:8px;">
			<?php
			foreach ( $images as $img ) :
				$src = $img['url'] ?? '';
				?>
				<div style="overflow:hidden;border-radius:8px;">
					<?php
					if ( $s['lightbox'] === 'yes' ) :
						?>
						<a href="<?php echo esc_url( $src ); ?>" data-fancybox="gallery-<?php echo esc_attr( $this->get_id() ); ?>" style="display:block;"><?php endif; ?>
						<img src="<?php echo esc_url( $src ); ?>" alt="" style="width:100%;height:<?php echo intval( $height ); ?>px;object-fit:cover;transition:transform .4s;" />
					<?php
					if ( $s['lightbox'] === 'yes' ) :
						?>
						</a><?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}
}

class Rozholy_Widget_Before_After extends \Elementor\Widget_Base {
	public function get_name(): string {
		return 'rozholy_before_after'; }
	public function get_title(): string {
		return esc_html__( 'Before / After', 'rozholy-companion' ); }
	public function get_icon(): string {
		return 'eicon-image-before-after'; }
	public function get_categories(): array {
		return array( 'rozholy-salon' ); }
	public function get_keywords(): array {
		return array( 'before', 'after', 'comparison' ); }

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Images', 'rozholy-companion' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'before_image',
			array(
				'label'   => esc_html__( 'Before Image', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => array(),
			)
		);
		$this->add_control(
			'after_image',
			array(
				'label'   => esc_html__( 'After Image', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => array(),
			)
		);
		$this->add_control(
			'before_label',
			array(
				'label'   => esc_html__( 'Before Label', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Before', 'rozholy-companion' ),
			)
		);
		$this->add_control(
			'after_label',
			array(
				'label'   => esc_html__( 'After Label', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'After', 'rozholy-companion' ),
			)
		);
		$this->end_controls_section();
	}

	public function render(): void {
		$s      = $this->get_settings_for_display();
		$before = $s['before_image']['url'] ?? '';
		$after  = $s['after_image']['url'] ?? '';
		if ( ! $before || ! $after ) {
			return;
		}
		?>
		<div class="rz-before-after" style="position:relative;overflow:hidden;border-radius:12px;cursor:ew-resize;user-select:none;">
			<div style="width:100%;"><img src="<?php echo esc_url( $after ); ?>" alt="<?php echo esc_attr( $s['after_label'] ?: 'After' ); ?>" style="display:block;width:100%;height:auto;" /></div>
			<div class="rz-ba-before" style="position:absolute;top:0;left:0;width:50%;height:100%;overflow:hidden;"><img src="<?php echo esc_url( $before ); ?>" alt="<?php echo esc_attr( $s['before_label'] ?: 'Before' ); ?>" style="display:block;width:auto;height:100%;max-width:none;min-width:100%;" /></div>
			<div style="position:absolute;top:0;left:50%;width:4px;height:100%;background:#fff;transform:translateX(-50%);z-index:10;"><div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:40px;height:40px;border-radius:50%;background:#fff;box-shadow:0 2px 10px rgba(0,0,0,.3);display:flex;align-items:center;justify-content:center;font-size:18px;">⟷</div></div>
			<span style="position:absolute;bottom:12px;left:12px;background:rgba(0,0,0,.6);color:#fff;padding:4px 12px;border-radius:4px;font-size:.8rem;"><?php echo esc_html( $s['before_label'] ?: 'Before' ); ?></span>
			<span style="position:absolute;bottom:12px;right:12px;background:rgba(0,0,0,.6);color:#fff;padding:4px 12px;border-radius:4px;font-size:.8rem;"><?php echo esc_html( $s['after_label'] ?: 'After' ); ?></span>
		</div>
		<script>document.querySelectorAll('.rz-before-after').forEach(function(e){var h=!1,b=e.querySelector('.rz-ba-before'),d=function(t){if(!h)return;var n=e.getBoundingClientRect(),r=((t.clientX||t.touches?.[0]?.clientX)-n.left)/n.width*100;r=Math.max(0,Math.min(100,r));b.style.width=r+'%'};e.addEventListener('mousedown',function(){h=!0});e.addEventListener('touchstart',function(){h=!0},{passive:!0});document.addEventListener('mouseup',function(){h=!1});document.addEventListener('touchend',function(){h=!1});document.addEventListener('mousemove',d);document.addEventListener('touchmove',d,{passive:!0})});</script>
		<?php
	}
}

class Rozholy_Widget_Video_Popup extends \Elementor\Widget_Base {
	public function get_name(): string {
		return 'rozholy_video_popup'; }
	public function get_title(): string {
		return esc_html__( 'Video Popup', 'rozholy-companion' ); }
	public function get_icon(): string {
		return 'eicon-youtube'; }
	public function get_categories(): array {
		return array( 'rozholy-salon' ); }
	public function get_keywords(): array {
		return array( 'video', 'popup', 'youtube' ); }

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Video', 'rozholy-companion' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'video_url',
			array(
				'label'       => esc_html__( 'Video URL (YouTube/Vimeo)', 'rozholy-companion' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => 'https://www.youtube.com/watch?v=',
				'default'     => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
			)
		);
		$this->add_control(
			'thumbnail',
			array(
				'label' => esc_html__( 'Custom Thumbnail', 'rozholy-companion' ),
				'type'  => \Elementor\Controls_Manager::MEDIA,
			)
		);
		$this->add_control(
			'title',
			array(
				'label' => esc_html__( 'Overlay Title', 'rozholy-companion' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
			)
		);
		$this->end_controls_section();
	}

	public function render(): void {
		$s     = $this->get_settings_for_display();
		$video = $s['video_url'] ?? '';
		$thumb = $s['thumbnail']['url'] ?? '';
		if ( ! $video ) {
			return;
		}
		?>
		<div style="position:relative;border-radius:16px;overflow:hidden;cursor:pointer;">
			<div style="aspect-ratio:16/9;background:<?php echo $thumb ? "url({$thumb}) center/cover" : '#222'; ?>;display:flex;align-items:center;justify-content:center;">
				<div style="width:72px;height:72px;border-radius:50%;background:rgba(255,255,255,.95);display:flex;align-items:center;justify-content:center;box-shadow:0 4px 20px rgba(0,0,0,.3);">
					<svg width="28" height="28" viewBox="0 0 24 24" fill="#c08080"><polygon points="5,3 19,12 5,21"/></svg>
				</div>
			</div>
			<?php
			if ( $s['title'] ) :
				?>
				<div style="position:absolute;bottom:0;left:0;right:0;background:linear-gradient(transparent,rgba(0,0,0,.7));padding:20px;color:#fff;font-weight:600;"><?php echo esc_html( $s['title'] ); ?></div><?php endif; ?>
			<a href="<?php echo esc_url( $video ); ?>" data-fancybox style="position:absolute;inset:0;z-index:2;"></a>
		</div>
		<?php
	}
}

class Rozholy_Widget_Instagram_Feed extends \Elementor\Widget_Base {
	public function get_name(): string {
		return 'rozholy_instagram_feed'; }
	public function get_title(): string {
		return esc_html__( 'Instagram Feed', 'rozholy-companion' ); }
	public function get_icon(): string {
		return 'eicon-instagram'; }
	public function get_categories(): array {
		return array( 'rozholy-salon' ); }
	public function get_keywords(): array {
		return array( 'instagram', 'feed', 'social' ); }

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Settings', 'rozholy-companion' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'username',
			array(
				'label'   => esc_html__( 'Instagram Username', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'rozholy_salon',
			)
		);
		$this->add_control(
			'limit',
			array(
				'label'   => esc_html__( 'Number of Photos', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 6,
				'min'     => 1,
				'max'     => 12,
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
					'6' => '6',
				),
			)
		);
		$this->end_controls_section();
	}

	public function render(): void {
		$s        = $this->get_settings_for_display();
		$username = $s['username'] ?? '';
		$limit    = intval( $s['limit'] ?: 6 );
		$columns  = $s['columns'] ?? '3';
		if ( ! $username ) {
			return;
		}
		?>
		<div style="display:grid;grid-template-columns:repeat(<?php echo intval( $columns ); ?>,1fr);gap:4px;">
			<?php for ( $i = 0; $i < min( $limit, 12 ); $i++ ) : ?>
				<a href="https://instagram.com/<?php echo esc_attr( $username ); ?>" target="_blank" rel="noopener" style="display:block;aspect-ratio:1;background:linear-gradient(135deg,#f0d0d0,#e8ddd5);border-radius:4px;overflow:hidden;position:relative;">
					<img src="https://via.placeholder.com/300/f0d0d0/333?text=📷" alt="" style="width:100%;height:100%;object-fit:cover;" />
					<span style="position:absolute;top:8px;right:8px;font-size:.7rem;color:#fff;text-shadow:0 1px 3px rgba(0,0,0,.5);">@<?php echo esc_html( $username ); ?></span>
				</a>
			<?php endfor; ?>
		</div>
		<?php
	}
}

class Rozholy_Widget_Brands_Carousel extends \Elementor\Widget_Base {
	public function get_name(): string {
		return 'rozholy_brands_carousel'; }
	public function get_title(): string {
		return esc_html__( 'Brands Carousel', 'rozholy-companion' ); }
	public function get_icon(): string {
		return 'eicon-logo'; }
	public function get_categories(): array {
		return array( 'rozholy-salon' ); }
	public function get_keywords(): array {
		return array( 'brands', 'partners', 'logos' ); }

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Brands', 'rozholy-companion' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'logo',
			array(
				'label' => esc_html__( 'Logo', 'rozholy-companion' ),
				'type'  => \Elementor\Controls_Manager::MEDIA,
			)
		);
		$repeater->add_control(
			'link',
			array(
				'label' => esc_html__( 'Link', 'rozholy-companion' ),
				'type'  => \Elementor\Controls_Manager::URL,
			)
		);
		$this->add_control(
			'brands',
			array(
				'label'       => esc_html__( 'Brands', 'rozholy-companion' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => esc_html__( 'Brand', 'rozholy-companion' ) . ' #{{ index }}',
			)
		);
		$this->end_controls_section();
	}

	public function render(): void {
		$s      = $this->get_settings_for_display();
		$brands = $s['brands'] ?? array();
		?>
		<div style="display:flex;gap:32px;align-items:center;justify-content:center;flex-wrap:wrap;padding:20px 0;">
			<?php
			foreach ( $brands as $brand ) :
				$url  = $brand['logo']['url'] ?? '';
				$link = ! empty( $brand['link']['url'] ) ? $brand['link']['url'] : '';
				if ( ! $url ) {
					continue;}
				?>
				<?php
				if ( $link ) :
					?>
					<a href="<?php echo esc_url( $link ); ?>" target="_blank" rel="noopener"><?php endif; ?>
					<img src="<?php echo esc_url( $url ); ?>" alt="" style="height:50px;width:auto;opacity:.55;transition:opacity .3s;filter:grayscale(1);" />
				<?php
				if ( $link ) :
					?>
					</a><?php endif; ?>
			<?php endforeach; ?>
		</div>
		<?php
	}
}
