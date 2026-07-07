var rzServiceCard = (() => {
  var __require = /* @__PURE__ */ ((x) => typeof require !== "undefined" ? require : typeof Proxy !== "undefined" ? new Proxy(x, {
    get: (a, b) => (typeof require !== "undefined" ? require : a)[b]
  }) : x)(function(x) {
    if (typeof require !== "undefined") return require.apply(this, arguments);
    throw Error('Dynamic require of "' + x + '" is not supported');
  });

  // src/blocks/service-card/index.js
  var import_blocks = __require("@wordpress/blocks");
  var import_components = __require("@wordpress/components");
  var import_block_editor = __require("@wordpress/block-editor");
  var import_i18n = __require("@wordpress/i18n");
  var import_jsx_runtime = __require("react/jsx-runtime");
  var ICON_OPTIONS = [
    { label: "\u{1F487}\u200D\u2640\uFE0F " + (0, import_i18n.__)("\u06A9\u0648\u062A\u0627\u0647\u06CC \u0645\u0648", "rozholy-companion"), value: "\u{1F487}\u200D\u2640\uFE0F" },
    { label: "\u{1F3A8} " + (0, import_i18n.__)("\u0631\u0646\u06AF \u0645\u0648", "rozholy-companion"), value: "\u{1F3A8}" },
    { label: "\u{1F485} " + (0, import_i18n.__)("\u0646\u0627\u062E\u0646", "rozholy-companion"), value: "\u{1F485}" },
    { label: "\u{1F484} " + (0, import_i18n.__)("\u0645\u06CC\u06A9\u0627\u067E", "rozholy-companion"), value: "\u{1F484}" },
    { label: "\u{1F9D6} " + (0, import_i18n.__)("\u0627\u0633\u067E\u0627", "rozholy-companion"), value: "\u{1F9D6}" },
    { label: "\u2728 " + (0, import_i18n.__)("\u067E\u0648\u0633\u062A", "rozholy-companion"), value: "\u2728" },
    { label: "\u{1F338} " + (0, import_i18n.__)("\u0632\u06CC\u0628\u0627\u06CC\u06CC", "rozholy-companion"), value: "\u{1F338}" },
    { label: "\u{1F31F} " + (0, import_i18n.__)("\u0648\u06CC\u0698\u0647", "rozholy-companion"), value: "\u{1F31F}" }
  ];
  (0, import_blocks.registerBlockType)("rozholy-companion/service-card", {
    edit: function({ attributes, setAttributes }) {
      const blockProps = (0, import_block_editor.useBlockProps)();
      return /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", { ...blockProps, children: [
        /* @__PURE__ */ (0, import_jsx_runtime.jsx)(import_block_editor.InspectorControls, { children: /* @__PURE__ */ (0, import_jsx_runtime.jsxs)(import_components.PanelBody, { title: (0, import_i18n.__)("\u062A\u0646\u0638\u06CC\u0645\u0627\u062A \u06A9\u0627\u0631\u062A \u062E\u062F\u0645\u0627\u062A", "rozholy-companion"), children: [
          /* @__PURE__ */ (0, import_jsx_runtime.jsx)(
            import_components.TextControl,
            {
              label: (0, import_i18n.__)("\u0639\u0646\u0648\u0627\u0646", "rozholy-companion"),
              value: attributes.title,
              onChange: (title) => setAttributes({ title })
            }
          ),
          /* @__PURE__ */ (0, import_jsx_runtime.jsx)(
            import_components.TextareaControl,
            {
              label: (0, import_i18n.__)("\u062A\u0648\u0636\u06CC\u062D\u0627\u062A", "rozholy-companion"),
              value: attributes.description,
              onChange: (description) => setAttributes({ description })
            }
          ),
          /* @__PURE__ */ (0, import_jsx_runtime.jsx)(
            import_components.TextControl,
            {
              label: (0, import_i18n.__)("\u0642\u06CC\u0645\u062A", "rozholy-companion"),
              value: attributes.price,
              onChange: (price) => setAttributes({ price }),
              placeholder: "\u06F5\u06F0\u06F0,\u06F0\u06F0\u06F0 \u062A\u0648\u0645\u0627\u0646"
            }
          ),
          /* @__PURE__ */ (0, import_jsx_runtime.jsx)(
            import_components.SelectControl,
            {
              label: (0, import_i18n.__)("\u0622\u06CC\u06A9\u0648\u0646", "rozholy-companion"),
              value: attributes.icon,
              options: ICON_OPTIONS,
              onChange: (icon) => setAttributes({ icon })
            }
          ),
          /* @__PURE__ */ (0, import_jsx_runtime.jsx)(
            import_components.TextControl,
            {
              label: (0, import_i18n.__)("\u0644\u06CC\u0646\u06A9", "rozholy-companion"),
              value: attributes.link,
              onChange: (link) => setAttributes({ link }),
              placeholder: "https://"
            }
          ),
          /* @__PURE__ */ (0, import_jsx_runtime.jsx)(
            import_components.TextControl,
            {
              label: (0, import_i18n.__)("\u0645\u062A\u0646 \u0644\u06CC\u0646\u06A9", "rozholy-companion"),
              value: attributes.linkText,
              onChange: (linkText) => setAttributes({ linkText })
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
              padding: "35px 25px",
              textAlign: "center",
              position: "relative",
              overflow: "hidden"
            },
            children: [
              /* @__PURE__ */ (0, import_jsx_runtime.jsx)(
                "div",
                {
                  style: {
                    position: "absolute",
                    top: 0,
                    left: 0,
                    right: 0,
                    height: 3,
                    background: "linear-gradient(90deg, #d4a0a0, #b8a0c0)"
                  }
                }
              ),
              /* @__PURE__ */ (0, import_jsx_runtime.jsx)(
                "div",
                {
                  style: {
                    width: 64,
                    height: 64,
                    margin: "0 auto 18px",
                    background: "linear-gradient(135deg, #f0d0d0, #f5ece4)",
                    borderRadius: "50%",
                    display: "flex",
                    alignItems: "center",
                    justifyContent: "center",
                    fontSize: "1.5rem"
                  },
                  children: attributes.icon
                }
              ),
              /* @__PURE__ */ (0, import_jsx_runtime.jsx)(
                "h3",
                {
                  style: {
                    fontFamily: "'Playfair Display', serif",
                    fontSize: "1.15rem",
                    margin: "0 0 10px",
                    color: "#2d2d2d"
                  },
                  children: attributes.title || (0, import_i18n.__)("\u0639\u0646\u0648\u0627\u0646 \u062E\u062F\u0645\u062A", "rozholy-companion")
                }
              ),
              /* @__PURE__ */ (0, import_jsx_runtime.jsx)("p", { style: { color: "#7a7a7a", fontSize: "0.9rem", lineHeight: 1.7, margin: "0 0 12px" }, children: attributes.description || (0, import_i18n.__)("\u062A\u0648\u0636\u06CC\u062D\u0627\u062A \u062E\u062F\u0645\u062A \u0627\u06CC\u0646\u062C\u0627 \u0646\u0645\u0627\u06CC\u0634 \u062F\u0627\u062F\u0647 \u0645\u06CC\u200C\u0634\u0648\u062F.", "rozholy-companion") }),
              attributes.price && /* @__PURE__ */ (0, import_jsx_runtime.jsx)(
                "span",
                {
                  style: {
                    display: "inline-block",
                    background: "#f5ece4",
                    padding: "4px 14px",
                    borderRadius: 999,
                    fontSize: "0.85rem",
                    fontWeight: 600,
                    color: "#c08080",
                    marginBottom: 12
                  },
                  children: attributes.price
                }
              ),
              attributes.link && /* @__PURE__ */ (0, import_jsx_runtime.jsxs)(
                "a",
                {
                  href: attributes.link,
                  style: {
                    display: "inline-flex",
                    alignItems: "center",
                    gap: 5,
                    fontSize: "0.85rem",
                    fontWeight: 600,
                    color: "#c08080",
                    textDecoration: "none"
                  },
                  children: [
                    attributes.linkText || (0, import_i18n.__)("\u062C\u0632\u0626\u06CC\u0627\u062A \u0628\u06CC\u0634\u062A\u0631", "rozholy-companion"),
                    " \u2192"
                  ]
                }
              )
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
