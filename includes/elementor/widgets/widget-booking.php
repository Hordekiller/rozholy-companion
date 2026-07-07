<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Rozholy_Widget_Booking_Form extends \Elementor\Widget_Base {
	public function get_name(): string {
		return 'rozholy_booking_form'; }
	public function get_title(): string {
		return esc_html__( 'Booking Form', 'rozholy-companion' ); }
	public function get_icon(): string {
		return 'eicon-form-horizontal'; }
	public function get_categories(): array {
		return array( 'rozholy-salon' ); }
	public function get_keywords(): array {
		return array( 'booking', 'appointment', 'form' ); }

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
				'default' => esc_html__( 'Book an Appointment', 'rozholy-companion' ),
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
			'success_message',
			array(
				'label'   => esc_html__( 'Success Message', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Your appointment has been booked successfully!', 'rozholy-companion' ),
			)
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'service',
			array(
				'label'   => esc_html__( 'Service Name', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Haircut', 'rozholy-companion' ),
			)
		);
		$this->add_control(
			'services',
			array(
				'label'       => esc_html__( 'Services List', 'rozholy-companion' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ service }}}',
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
			'form_bg',
			array(
				'label'     => esc_html__( 'Form Background', 'rozholy-companion' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array( '.elementor {{WRAPPER}} .rz-booking-form' => 'background: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'btn_color',
			array(
				'label'   => esc_html__( 'Button Color', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '#d4a0a0',
			)
		);
		$this->end_controls_section();
	}

	public function render(): void {
		$s        = $this->get_settings_for_display();
		$services = $s['services'] ?? array();
		$rest_url = rest_url( 'rozholy-companion/v1/submit-booking' );
		?>
		<div class="rz-booking-form" style="background:#fff;border:1px solid #e8ddd5;border-radius:20px;padding:40px;max-width:600px;margin:0 auto;">
			<?php
			if ( $s['title'] ) :
				?>
				<h3 style="margin:0 0 8px;font-family:'Playfair Display',serif;text-align:center;"><?php echo esc_html( $s['title'] ); ?></h3><?php endif; ?>
			<?php
			if ( $s['description'] ) :
				?>
				<p style="color:#7a7a7a;text-align:center;margin:0 0 24px;"><?php echo esc_html( $s['description'] ); ?></p><?php endif; ?>
			<div id="rz-booking-message" style="display:none;padding:12px 16px;border-radius:8px;margin-bottom:16px;text-align:center;"></div>
			<form class="rz-booking-ajax-form" data-rest-url="<?php echo esc_url( $rest_url ); ?>" data-nonce="<?php echo esc_attr( wp_create_nonce( 'wp_rest' ) ); ?>">
				<div style="display:grid;gap:16px;">
					<input type="text" name="name" required placeholder="<?php esc_attr_e( 'Full Name', 'rozholy-companion' ); ?>" style="width:100%;padding:12px 16px;border:1px solid #ddd;border-radius:8px;font-size:1rem;" />
					<input type="tel" name="phone" required placeholder="<?php esc_attr_e( 'Phone Number', 'rozholy-companion' ); ?>" style="width:100%;padding:12px 16px;border:1px solid #ddd;border-radius:8px;font-size:1rem;" />
					<select name="service" style="width:100%;padding:12px 16px;border:1px solid #ddd;border-radius:8px;font-size:1rem;">
						<option value=""><?php esc_html_e( 'Select Service', 'rozholy-companion' ); ?></option>
						<?php
						foreach ( $services as $svc ) :
							?>
							<option value="<?php echo esc_attr( $svc['service'] ?? '' ); ?>"><?php echo esc_html( $svc['service'] ?? '' ); ?></option><?php endforeach; ?>
					</select>
					<input type="date" name="date" required style="width:100%;padding:12px 16px;border:1px solid #ddd;border-radius:8px;font-size:1rem;" />
					<input type="time" name="time" required style="width:100%;padding:12px 16px;border:1px solid #ddd;border-radius:8px;font-size:1rem;" />
					<textarea name="message" rows="3" placeholder="<?php esc_attr_e( 'Notes (optional)', 'rozholy-companion' ); ?>" style="width:100%;padding:12px 16px;border:1px solid #ddd;border-radius:8px;font-size:1rem;"></textarea>
					<button type="submit" style="width:100%;padding:14px;border:none;border-radius:50px;background:linear-gradient(135deg,<?php echo esc_attr( $s['btn_color'] ?: '#d4a0a0' ); ?>,<?php echo esc_attr( $s['btn_color'] ?: '#d4a0a0' ); ?>);color:#fff;font-size:1rem;font-weight:600;cursor:pointer;"><?php esc_html_e( 'Book Appointment', 'rozholy-companion' ); ?></button>
				</div>
			</form>
		</div>
		<script>
		(function(){
			var forms = document.querySelectorAll('.rz-booking-ajax-form');
			forms.forEach(function(form){
				form.addEventListener('submit', function(e){
					e.preventDefault();
					var msg = document.getElementById('rz-booking-message');
					var data = {};
					new FormData(form).forEach(function(v, k){ data[k] = v; });
					var btn = form.querySelector('button[type="submit"]');
					btn.disabled = true;
					btn.textContent = '<?php echo esc_js( __( 'در حال ارسال...', 'rozholy-companion' ) ); ?>';
					fetch(form.getAttribute('data-rest-url'), {
						method: 'POST',
						headers: { 'Content-Type': 'application/json', 'X-WP-Nonce': form.getAttribute('data-nonce') },
						body: JSON.stringify(data)
					}).then(function(r){ return r.json(); }).then(function(res){
						msg.style.display = 'block';
						if (res.success) {
							msg.style.background = '#d1fae5';
							msg.style.color = '#065f46';
							msg.textContent = '<?php echo esc_js( $s['success_message'] ?: __( 'Your appointment has been booked successfully!', 'rozholy-companion' ) ); ?>';
							form.reset();
						} else {
							msg.style.background = '#fef3c7';
							msg.style.color = '#92400e';
							msg.textContent = res.message || '<?php echo esc_js( __( 'Submission failed. Please try again.', 'rozholy-companion' ) ); ?>';
						}
					}).catch(function(){
						msg.style.display = 'block';
						msg.style.background = '#fee2e2';
						msg.style.color = '#991b1b';
						msg.textContent = '<?php echo esc_js( __( 'Network error. Please try again.', 'rozholy-companion' ) ); ?>';
					}).finally(function(){
						btn.disabled = false;
						btn.textContent = '<?php echo esc_js( __( 'Book Appointment', 'rozholy-companion' ) ); ?>';
					});
				});
			});
		})();
		</script>
		<?php
	}
}

class Rozholy_Widget_Opening_Hours extends \Elementor\Widget_Base {
	public function get_name(): string {
		return 'rozholy_opening_hours'; }
	public function get_title(): string {
		return esc_html__( 'Opening Hours', 'rozholy-companion' ); }
	public function get_icon(): string {
		return 'eicon-clock-o'; }
	public function get_categories(): array {
		return array( 'rozholy-salon' ); }
	public function get_keywords(): array {
		return array( 'hours', 'schedule', 'time' ); }

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Hours', 'rozholy-companion' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$days = array(
			'saturday'  => esc_html__( 'Saturday', 'rozholy-companion' ),
			'sunday'    => esc_html__( 'Sunday', 'rozholy-companion' ),
			'monday'    => esc_html__( 'Monday', 'rozholy-companion' ),
			'tuesday'   => esc_html__( 'Tuesday', 'rozholy-companion' ),
			'wednesday' => esc_html__( 'Wednesday', 'rozholy-companion' ),
			'thursday'  => esc_html__( 'Thursday', 'rozholy-companion' ),
			'friday'    => esc_html__( 'Friday', 'rozholy-companion' ),
		);
		foreach ( $days as $key => $label ) {
			$this->add_control(
				$key . '_status',
				array(
					'label'   => $label,
					'type'    => \Elementor\Controls_Manager::SELECT,
					'default' => 'open',
					'options' => array(
						'open'   => esc_html__( 'Open', 'rozholy-companion' ),
						'closed' => esc_html__( 'Closed', 'rozholy-companion' ),
					),
				)
			);
			$this->add_control(
				$key . '_open',
				array(
					'label'     => esc_html__( 'Open Time', 'rozholy-companion' ),
					'type'      => \Elementor\Controls_Manager::TEXT,
					'default'   => '09:00',
					'condition' => array( $key . '_status' => 'open' ),
				)
			);
			$this->add_control(
				$key . '_close',
				array(
					'label'     => esc_html__( 'Close Time', 'rozholy-companion' ),
					'type'      => \Elementor\Controls_Manager::TEXT,
					'default'   => '21:00',
					'condition' => array( $key . '_status' => 'open' ),
				)
			);
		}
		$this->add_control(
			'note',
			array(
				'label' => esc_html__( 'Footer Note', 'rozholy-companion' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
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
				'default'   => '#ffffff',
				'selectors' => array( '.elementor {{WRAPPER}} .rz-hours' => 'background: {{VALUE}};' ),
			)
		);
		$this->end_controls_section();
	}

	public function render(): void {
		$s      = $this->get_settings_for_display();
		$days   = array( 'saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday' );
		$labels = array(
			'saturday'  => esc_html__( 'Saturday', 'rozholy-companion' ),
			'sunday'    => esc_html__( 'Sunday', 'rozholy-companion' ),
			'monday'    => esc_html__( 'Monday', 'rozholy-companion' ),
			'tuesday'   => esc_html__( 'Tuesday', 'rozholy-companion' ),
			'wednesday' => esc_html__( 'Wednesday', 'rozholy-companion' ),
			'thursday'  => esc_html__( 'Thursday', 'rozholy-companion' ),
			'friday'    => esc_html__( 'Friday', 'rozholy-companion' ),
		);
		?>
		<div class="rz-hours" style="background:#fff;border:1px solid #e8ddd5;border-radius:16px;padding:24px;">
			<table style="width:100%;border-collapse:collapse;">
				<tbody>
					<?php foreach ( $days as $day ) : ?>
						<tr style="border-bottom:1px solid #f0ece8;">
							<td style="padding:10px 0;font-weight:600;"><?php echo esc_html( $labels[ $day ] ); ?></td>
							<td style="padding:10px 0;text-align:left;">
								<?php if ( ( $s[ $day . '_status' ] ?? 'open' ) === 'closed' ) : ?>
									<span style="color:#e74c3c;"><?php esc_html_e( 'Closed', 'rozholy-companion' ); ?></span>
								<?php else : ?>
									<span><?php echo esc_html( $s[ $day . '_open' ] ?? '09:00' ); ?> — <?php echo esc_html( $s[ $day . '_close' ] ?? '21:00' ); ?></span>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<?php
			if ( $s['note'] ) :
				?>
				<p style="font-size:.85rem;color:#888;margin:16px 0 0;text-align:center;"><?php echo esc_html( $s['note'] ); ?></p><?php endif; ?>
		</div>
		<?php
	}
}

class Rozholy_Widget_Contact_Info extends \Elementor\Widget_Base {
	public function get_name(): string {
		return 'rozholy_contact_info'; }
	public function get_title(): string {
		return esc_html__( 'Contact Info', 'rozholy-companion' ); }
	public function get_icon(): string {
		return 'eicon-info-circle'; }
	public function get_categories(): array {
		return array( 'rozholy-salon' ); }
	public function get_keywords(): array {
		return array( 'contact', 'info', 'phone', 'address' ); }

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Details', 'rozholy-companion' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'phone',
			array(
				'label'   => esc_html__( 'Phone', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '+98 21 1234 5678',
			)
		);
		$this->add_control(
			'mobile',
			array(
				'label'   => esc_html__( 'Mobile', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '+98 912 345 6789',
			)
		);
		$this->add_control(
			'email',
			array(
				'label'   => esc_html__( 'Email', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'info@rozholy.com',
			)
		);
		$this->add_control(
			'address',
			array(
				'label'   => esc_html__( 'Address', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'rows'    => 2,
				'default' => esc_html__( '123 Beauty Street, Tehran', 'rozholy-companion' ),
			)
		);
		$this->add_control(
			'map_url',
			array(
				'label'       => esc_html__( 'Google Maps Embed URL', 'rozholy-companion' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => 'https://maps.google.com/...',
			)
		);
		$this->end_controls_section();
	}

	public function render(): void {
		$s = $this->get_settings_for_display();
		?>
		<div style="display:grid;gap:16px;">
			<?php
			if ( $s['phone'] ) :
				?>
				<div style="display:flex;align-items:center;gap:12px;background:#f9f6f3;padding:14px 18px;border-radius:12px;"><span style="font-size:1.3rem;">📞</span><div><strong style="display:block;font-size:.8rem;color:#888;"><?php esc_html_e( 'Phone', 'rozholy-companion' ); ?></strong><span><?php echo esc_html( $s['phone'] ); ?></span></div></div><?php endif; ?>
			<?php
			if ( $s['mobile'] ) :
				?>
				<div style="display:flex;align-items:center;gap:12px;background:#f9f6f3;padding:14px 18px;border-radius:12px;"><span style="font-size:1.3rem;">📱</span><div><strong style="display:block;font-size:.8rem;color:#888;"><?php esc_html_e( 'Mobile', 'rozholy-companion' ); ?></strong><span><?php echo esc_html( $s['mobile'] ); ?></span></div></div><?php endif; ?>
			<?php
			if ( $s['email'] ) :
				?>
				<div style="display:flex;align-items:center;gap:12px;background:#f9f6f3;padding:14px 18px;border-radius:12px;"><span style="font-size:1.3rem;">✉️</span><div><strong style="display:block;font-size:.8rem;color:#888;"><?php esc_html_e( 'Email', 'rozholy-companion' ); ?></strong><span><?php echo esc_html( $s['email'] ); ?></span></div></div><?php endif; ?>
			<?php
			if ( $s['address'] ) :
				?>
				<div style="display:flex;align-items:center;gap:12px;background:#f9f6f3;padding:14px 18px;border-radius:12px;"><span style="font-size:1.3rem;">📍</span><div><strong style="display:block;font-size:.8rem;color:#888;"><?php esc_html_e( 'Address', 'rozholy-companion' ); ?></strong><span><?php echo nl2br( esc_html( $s['address'] ) ); ?></span></div></div><?php endif; ?>
			<?php
			if ( $s['map_url'] ) :
				?>
				<div style="border-radius:12px;overflow:hidden;height:300px;margin-top:8px;"><iframe src="<?php echo esc_url( $s['map_url'] ); ?>" width="100%" height="100%" style="border:0;" allowfullscreen loading="lazy"></iframe></div><?php endif; ?>
		</div>
		<?php
	}
}

class Rozholy_Widget_Newsletter_Form extends \Elementor\Widget_Base {
	public function get_name(): string {
		return 'rozholy_newsletter_form'; }
	public function get_title(): string {
		return esc_html__( 'Newsletter Form', 'rozholy-companion' ); }
	public function get_icon(): string {
		return 'eicon-mail'; }
	public function get_categories(): array {
		return array( 'rozholy-salon' ); }
	public function get_keywords(): array {
		return array( 'newsletter', 'subscribe', 'email' ); }

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
				'default' => esc_html__( 'Subscribe to Our Newsletter', 'rozholy-companion' ),
			)
		);
		$this->add_control(
			'description',
			array(
				'label'   => esc_html__( 'Description', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'rows'    => 2,
				'default' => esc_html__( 'Get the latest updates and offers.', 'rozholy-companion' ),
			)
		);
		$this->add_control(
			'placeholder',
			array(
				'label'   => esc_html__( 'Input Placeholder', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Enter your email', 'rozholy-companion' ),
			)
		);
		$this->add_control(
			'button_text',
			array(
				'label'   => esc_html__( 'Button Text', 'rozholy-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Subscribe', 'rozholy-companion' ),
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
				'selectors' => array( '.elementor {{WRAPPER}} .rz-newsletter' => 'background: {{VALUE}};' ),
			)
		);
		$this->end_controls_section();
	}

	public function render(): void {
		$s = $this->get_settings_for_display();
		?>
		<div class="rz-newsletter" style="background:linear-gradient(135deg,#f9f6f3,#f0ece8);border:1px solid #e8ddd5;border-radius:20px;padding:40px;text-align:center;">
			<?php
			if ( $s['title'] ) :
				?>
				<h3 style="margin:0 0 8px;font-family:'Playfair Display',serif;"><?php echo esc_html( $s['title'] ); ?></h3><?php endif; ?>
			<?php
			if ( $s['description'] ) :
				?>
				<p style="color:#7a7a7a;margin:0 0 20px;"><?php echo esc_html( $s['description'] ); ?></p><?php endif; ?>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="display:flex;gap:8px;max-width:480px;margin:0 auto;">
				<input type="hidden" name="action" value="rozholy_newsletter_subscribe" />
				<?php wp_nonce_field( 'rozholy_newsletter_nonce', '_newsletter_nonce' ); ?>
				<input type="email" name="newsletter_email" required placeholder="<?php echo esc_attr( $s['placeholder'] ?: esc_html__( 'Enter your email', 'rozholy-companion' ) ); ?>" style="flex:1;padding:12px 16px;border:1px solid #ddd;border-radius:50px;font-size:1rem;" />
				<button type="submit" style="padding:12px 28px;border:none;border-radius:50px;background:linear-gradient(135deg,#d4a0a0,#b8a0c0);color:#fff;font-weight:600;cursor:pointer;white-space:nowrap;"><?php echo esc_html( $s['button_text'] ?: esc_html__( 'Subscribe', 'rozholy-companion' ) ); ?></button>
			</form>
		</div>
		<?php
	}
}
