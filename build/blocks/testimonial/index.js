var rzTestimonial = (() => {
  var __require = /* @__PURE__ */ ((x) => typeof require !== "undefined" ? require : typeof Proxy !== "undefined" ? new Proxy(x, {
    get: (a, b) => (typeof require !== "undefined" ? require : a)[b]
  }) : x)(function(x) {
    if (typeof require !== "undefined") return require.apply(this, arguments);
    throw Error('Dynamic require of "' + x + '" is not supported');
  });

  // src/blocks/testimonial/index.js
  var import_blocks = __require("@wordpress/blocks");
  var import_components = __require("@wordpress/components");
  var import_block_editor = __require("@wordpress/block-editor");
  var import_i18n = __require("@wordpress/i18n");
  var import_jsx_runtime = __require("react/jsx-runtime");
  (0, import_blocks.registerBlockType)("rozholy-companion/testimonial", {
    edit: function({ attributes, setAttributes }) {
      const blockProps = (0, import_block_editor.useBlockProps)();
      const stars = "\u2B50".repeat(attributes.rating);
      return /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", { ...blockProps, children: [
        /* @__PURE__ */ (0, import_jsx_runtime.jsx)(import_block_editor.InspectorControls, { children: /* @__PURE__ */ (0, import_jsx_runtime.jsxs)(import_components.PanelBody, { title: (0, import_i18n.__)("\u062A\u0646\u0638\u06CC\u0645\u0627\u062A \u0646\u0638\u0631", "rozholy-companion"), children: [
          /* @__PURE__ */ (0, import_jsx_runtime.jsx)(
            import_components.TextControl,
            {
              label: (0, import_i18n.__)("\u0646\u0627\u0645", "rozholy-companion"),
              value: attributes.name,
              onChange: (name) => setAttributes({ name })
            }
          ),
          /* @__PURE__ */ (0, import_jsx_runtime.jsx)(
            import_components.TextControl,
            {
              label: (0, import_i18n.__)("\u0646\u0642\u0634", "rozholy-companion"),
              value: attributes.role,
              onChange: (role) => setAttributes({ role }),
              placeholder: (0, import_i18n.__)("\u0645\u0634\u062A\u0631\u06CC \u062B\u0627\u0628\u062A", "rozholy-companion")
            }
          ),
          /* @__PURE__ */ (0, import_jsx_runtime.jsx)(
            import_components.RangeControl,
            {
              label: (0, import_i18n.__)("\u0627\u0645\u062A\u06CC\u0627\u0632", "rozholy-companion"),
              value: attributes.rating,
              onChange: (rating) => setAttributes({ rating }),
              min: 1,
              max: 5,
              marks: [
                { value: 1, label: "1" },
                { value: 2, label: "2" },
                { value: 3, label: "3" },
                { value: 4, label: "4" },
                { value: 5, label: "5" }
              ]
            }
          )
        ] }) }),
        /* @__PURE__ */ (0, import_jsx_runtime.jsxs)(
          "div",
          {
            style: {
              background: "#fff",
              border: "1px solid #e8ddd5",
              borderRadius: 16,
              padding: 30,
              textAlign: "right"
            },
            children: [
              /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", { style: { display: "flex", gap: 3, marginBottom: 12, fontSize: "1rem" }, children: stars }),
              /* @__PURE__ */ (0, import_jsx_runtime.jsx)(
                import_block_editor.RichText,
                {
                  tagName: "blockquote",
                  value: attributes.content,
                  onChange: (content) => setAttributes({ content }),
                  placeholder: (0, import_i18n.__)("\u0645\u062A\u0646 \u0646\u0638\u0631 \u0645\u0634\u062A\u0631\u06CC \u0631\u0627 \u0648\u0627\u0631\u062F \u06A9\u0646\u06CC\u062F...", "rozholy-companion"),
                  style: {
                    margin: "0 0 20px",
                    padding: 0,
                    border: "none",
                    fontSize: "1rem",
                    lineHeight: 1.8,
                    color: "#4a4a4a",
                    fontStyle: "italic"
                  }
                }
              ),
              /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", { style: { display: "flex", alignItems: "center", gap: 12 }, children: [
                /* @__PURE__ */ (0, import_jsx_runtime.jsx)(
                  "div",
                  {
                    style: {
                      width: 44,
                      height: 44,
                      borderRadius: "50%",
                      background: "linear-gradient(135deg, #d4a0a0, #b8a0c0)",
                      display: "flex",
                      alignItems: "center",
                      justifyContent: "center",
                      color: "#fff",
                      fontWeight: 700,
                      fontSize: "1.1rem",
                      flexShrink: 0
                    },
                    children: attributes.name ? attributes.name.charAt(0) : "?"
                  }
                ),
                /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", { children: [
                  /* @__PURE__ */ (0, import_jsx_runtime.jsx)(
                    import_block_editor.RichText,
                    {
                      tagName: "strong",
                      value: attributes.name,
                      onChange: (name) => setAttributes({ name }),
                      placeholder: (0, import_i18n.__)("\u0646\u0627\u0645 \u0645\u0634\u062A\u0631\u06CC", "rozholy-companion"),
                      style: { display: "block", fontSize: "0.95rem", color: "#2d2d2d" }
                    }
                  ),
                  attributes.role && /* @__PURE__ */ (0, import_jsx_runtime.jsx)("span", { style: { fontSize: "0.8rem", color: "#7a7a7a" }, children: attributes.role })
                ] })
              ] })
            ]
          }
        )
      ] });
    },
    save: function() {
      return null;
    }
  });
})();
