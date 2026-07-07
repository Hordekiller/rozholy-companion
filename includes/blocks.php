<?php

add_action('init', 'rozholy_companion_register_blocks');
function rozholy_companion_register_blocks() {
    $blocks = [
        'service-card' => [
            'render_callback' => 'rozholy_companion_render_service_card',
        ],
        'testimonial' => [
            'render_callback' => 'rozholy_companion_render_testimonial',
        ],
    ];

    foreach ($blocks as $name => $config) {
        $block_json = ROZHOLY_COMPANION_DIR . "build/blocks/{$name}/block.json";
        if (file_exists($block_json)) {
            register_block_type($block_json, $config);
        }
    }
}

function rozholy_companion_render_service_card($attributes) {
    $title       = $attributes['title'] ?? esc_html__('خدمت', 'rozholy-companion');
    $description = $attributes['description'] ?? '';
    $price       = $attributes['price'] ?? '';
    $icon        = $attributes['icon'] ?? '💇‍♀️';
    $link        = $attributes['link'] ?? '';
    $linkText    = $attributes['linkText'] ?? esc_html__('جزئیات بیشتر', 'rozholy-companion');

    ob_start();
    ?>
    <div class="rz-service-card wp-block-rozholy-companion-service-card" style="
      background:#fff;
      border:1px solid #e8ddd5;
      border-radius:16px;
      padding:35px 25px;
      text-align:center;
      transition:transform .3s ease,box-shadow .3s ease;
      position:relative;
      overflow:hidden;
    ">
      <div style="
        position:absolute;top:0;left:0;right:0;height:3px;
        background:linear-gradient(90deg,#d4a0a0,#b8a0c0);
      "></div>
      <div style="
        width:64px;height:64px;margin:0 auto 18px;
        background:linear-gradient(135deg,#f0d0d0,#f5ece4);
        border-radius:50%;display:flex;align-items:center;justify-content:center;
        font-size:1.5rem;
      "><?php echo esc_html($icon); ?></div>
      <h3 style="font-family:'Playfair Display',serif;font-size:1.15rem;margin:0 0 10px;color:#2d2d2d;">
        <?php echo esc_html($title); ?>
      </h3>
      <?php if ($description) : ?>
        <p style="color:#7a7a7a;font-size:0.9rem;line-height:1.7;margin:0 0 12px;">
          <?php echo esc_html($description); ?>
        </p>
      <?php endif; ?>
      <?php if ($price) : ?>
        <span style="display:inline-block;background:#f5ece4;padding:4px 14px;border-radius:999px;font-size:0.85rem;font-weight:600;color:#c08080;margin-bottom:12px;">
          <?php echo esc_html($price); ?>
        </span>
      <?php endif; ?>
      <?php if ($link) : ?>
        <a href="<?php echo esc_url($link); ?>" style="
          display:inline-flex;align-items:center;gap:5px;font-size:0.85rem;font-weight:600;color:#c08080;text-decoration:none;
        "><?php echo esc_html($linkText); ?> →</a>
      <?php endif; ?>
    </div>
    <?php
    $output = ob_get_clean();

    $wrapper_attrs = get_block_wrapper_attributes([
        'style' => 'height:100%;',
    ]);

    return sprintf('<div %s>%s</div>', $wrapper_attrs, $output);
}

function rozholy_companion_render_testimonial($attributes) {
    $name    = $attributes['name'] ?? '';
    $content = $attributes['content'] ?? '';
    $rating  = $attributes['rating'] ?? 5;
    $role    = $attributes['role'] ?? '';

    $stars = str_repeat('⭐', min(5, max(1, intval($rating))));

    ob_start();
    ?>
    <div class="rz-testimonial-card" style="
      background:#fff;
      border:1px solid #e8ddd5;
      border-radius:16px;
      padding:30px;
      text-align:right;
      transition:transform .3s ease,box-shadow .3s ease;
    ">
      <div style="display:flex;gap:3px;margin-bottom:12px;font-size:1rem;">
        <?php echo $stars; ?>
      </div>
      <blockquote style="
        margin:0 0 20px;padding:0;border:none;
        font-size:1rem;line-height:1.8;color:#4a4a4a;font-style:italic;
      ">"<?php echo esc_html($content); ?>"</blockquote>
      <div style="display:flex;align-items:center;gap:12px;">
        <div style="
          width:44px;height:44px;border-radius:50%;
          background:linear-gradient(135deg,#d4a0a0,#b8a0c0);
          display:flex;align-items:center;justify-content:center;
          color:#fff;font-weight:700;font-size:1.1rem;
          flex-shrink:0;
        "><?php echo esc_html(mb_substr($name, 0, 1)); ?></div>
        <div>
          <strong style="display:block;font-size:0.95rem;color:#2d2d2d;"><?php echo esc_html($name); ?></strong>
          <?php if ($role) : ?>
            <span style="font-size:0.8rem;color:#7a7a7a;"><?php echo esc_html($role); ?></span>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <?php
    $output = ob_get_clean();

    $wrapper_attrs = get_block_wrapper_attributes([
        'style' => 'height:100%;',
    ]);

    return sprintf('<div %s>%s</div>', $wrapper_attrs, $output);
}
