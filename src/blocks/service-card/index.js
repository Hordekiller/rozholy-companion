import { registerBlockType } from '@wordpress/blocks';
import {
  TextControl,
  TextareaControl,
  SelectControl,
  __experimentalInputControl as InputControl,
  PanelBody,
  Icon,
} from '@wordpress/components';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

const ICON_OPTIONS = [
  { label: '💇‍♀️ ' + __('کوتاهی مو', 'rozholy-companion'), value: '💇‍♀️' },
  { label: '🎨 ' + __('رنگ مو', 'rozholy-companion'), value: '🎨' },
  { label: '💅 ' + __('ناخن', 'rozholy-companion'), value: '💅' },
  { label: '💄 ' + __('میکاپ', 'rozholy-companion'), value: '💄' },
  { label: '🧖 ' + __('اسپا', 'rozholy-companion'), value: '🧖' },
  { label: '✨ ' + __('پوست', 'rozholy-companion'), value: '✨' },
  { label: '🌸 ' + __('زیبایی', 'rozholy-companion'), value: '🌸' },
  { label: '🌟 ' + __('ویژه', 'rozholy-companion'), value: '🌟' },
];

registerBlockType('rozholy-companion/service-card', {
  edit: function ({ attributes, setAttributes }) {
    const blockProps = useBlockProps();

    return (
      <div {...blockProps}>
        <InspectorControls>
          <PanelBody title={__('تنظیمات کارت خدمات', 'rozholy-companion')}>
            <TextControl
              label={__('عنوان', 'rozholy-companion')}
              value={attributes.title}
              onChange={(title) => setAttributes({ title })}
            />
            <TextareaControl
              label={__('توضیحات', 'rozholy-companion')}
              value={attributes.description}
              onChange={(description) => setAttributes({ description })}
            />
            <TextControl
              label={__('قیمت', 'rozholy-companion')}
              value={attributes.price}
              onChange={(price) => setAttributes({ price })}
              placeholder="۵۰۰,۰۰۰ تومان"
            />
            <SelectControl
              label={__('آیکون', 'rozholy-companion')}
              value={attributes.icon}
              options={ICON_OPTIONS}
              onChange={(icon) => setAttributes({ icon })}
            />
            <TextControl
              label={__('لینک', 'rozholy-companion')}
              value={attributes.link}
              onChange={(link) => setAttributes({ link })}
              placeholder="https://"
            />
            <TextControl
              label={__('متن لینک', 'rozholy-companion')}
              value={attributes.linkText}
              onChange={(linkText) => setAttributes({ linkText })}
            />
          </PanelBody>
        </InspectorControls>

        <div
          style={{
            background: '#fff',
            border: '1px solid #e8ddd5',
            borderRadius: 16,
            padding: '35px 25px',
            textAlign: 'center',
            position: 'relative',
            overflow: 'hidden',
          }}
        >
          <div
            style={{
              position: 'absolute',
              top: 0,
              left: 0,
              right: 0,
              height: 3,
              background: 'linear-gradient(90deg, #d4a0a0, #b8a0c0)',
            }}
          />
          <div
            style={{
              width: 64,
              height: 64,
              margin: '0 auto 18px',
              background: 'linear-gradient(135deg, #f0d0d0, #f5ece4)',
              borderRadius: '50%',
              display: 'flex',
              alignItems: 'center',
              justifyContent: 'center',
              fontSize: '1.5rem',
            }}
          >
            {attributes.icon}
          </div>
          <h3
            style={{
              fontFamily: "'Playfair Display', serif",
              fontSize: '1.15rem',
              margin: '0 0 10px',
              color: '#2d2d2d',
            }}
          >
            {attributes.title || __('عنوان خدمت', 'rozholy-companion')}
          </h3>
          <p style={{ color: '#7a7a7a', fontSize: '0.9rem', lineHeight: 1.7, margin: '0 0 12px' }}>
            {attributes.description || __('توضیحات خدمت اینجا نمایش داده می‌شود.', 'rozholy-companion')}
          </p>
          {attributes.price && (
            <span
              style={{
                display: 'inline-block',
                background: '#f5ece4',
                padding: '4px 14px',
                borderRadius: 999,
                fontSize: '0.85rem',
                fontWeight: 600,
                color: '#c08080',
                marginBottom: 12,
              }}
            >
              {attributes.price}
            </span>
          )}
          {attributes.link && (
            <a
              href={attributes.link}
              style={{
                display: 'inline-flex',
                alignItems: 'center',
                gap: 5,
                fontSize: '0.85rem',
                fontWeight: 600,
                color: '#c08080',
                textDecoration: 'none',
              }}
            >
              {attributes.linkText || __('جزئیات بیشتر', 'rozholy-companion')} →
            </a>
          )}
        </div>
      </div>
    );
  },

  save: function () {
    return null;
  },
});
