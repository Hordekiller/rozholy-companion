import { registerBlockType } from '@wordpress/blocks';
import {
  TextControl,
  TextareaControl,
  RangeControl,
  PanelBody,
} from '@wordpress/components';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

registerBlockType('rozholy-companion/testimonial', {
  edit: function ({ attributes, setAttributes }) {
    const blockProps = useBlockProps();
    const stars = '⭐'.repeat(attributes.rating);

    return (
      <div {...blockProps}>
        <InspectorControls>
          <PanelBody title={__('تنظیمات نظر', 'rozholy-companion')}>
            <TextControl
              label={__('نام', 'rozholy-companion')}
              value={attributes.name}
              onChange={(name) => setAttributes({ name })}
            />
            <TextControl
              label={__('نقش', 'rozholy-companion')}
              value={attributes.role}
              onChange={(role) => setAttributes({ role })}
              placeholder={__('مشتری ثابت', 'rozholy-companion')}
            />
            <RangeControl
              label={__('امتیاز', 'rozholy-companion')}
              value={attributes.rating}
              onChange={(rating) => setAttributes({ rating })}
              min={1}
              max={5}
              marks={[
                { value: 1, label: '1' },
                { value: 2, label: '2' },
                { value: 3, label: '3' },
                { value: 4, label: '4' },
                { value: 5, label: '5' },
              ]}
            />
          </PanelBody>
        </InspectorControls>

        <div
          style={{
            background: '#fff',
            border: '1px solid #e8ddd5',
            borderRadius: 16,
            padding: 30,
            textAlign: 'right',
          }}
        >
          <div style={{ display: 'flex', gap: 3, marginBottom: 12, fontSize: '1rem' }}>
            {stars}
          </div>
          <RichText
            tagName="blockquote"
            value={attributes.content}
            onChange={(content) => setAttributes({ content })}
            placeholder={__('متن نظر مشتری را وارد کنید...', 'rozholy-companion')}
            style={{
              margin: '0 0 20px',
              padding: 0,
              border: 'none',
              fontSize: '1rem',
              lineHeight: 1.8,
              color: '#4a4a4a',
              fontStyle: 'italic',
            }}
          />
          <div style={{ display: 'flex', alignItems: 'center', gap: 12 }}>
            <div
              style={{
                width: 44,
                height: 44,
                borderRadius: '50%',
                background: 'linear-gradient(135deg, #d4a0a0, #b8a0c0)',
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                color: '#fff',
                fontWeight: 700,
                fontSize: '1.1rem',
                flexShrink: 0,
              }}
            >
              {attributes.name ? attributes.name.charAt(0) : '?'}
            </div>
            <div>
              <RichText
                tagName="strong"
                value={attributes.name}
                onChange={(name) => setAttributes({ name })}
                placeholder={__('نام مشتری', 'rozholy-companion')}
                style={{ display: 'block', fontSize: '0.95rem', color: '#2d2d2d' }}
              />
              {attributes.role && (
                <span style={{ fontSize: '0.8rem', color: '#7a7a7a' }}>
                  {attributes.role}
                </span>
              )}
            </div>
          </div>
        </div>
      </div>
    );
  },

  save: function () {
    return null;
  },
});
