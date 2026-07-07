var rzAdmin = (() => {
  var __create = Object.create;
  var __defProp = Object.defineProperty;
  var __getOwnPropDesc = Object.getOwnPropertyDescriptor;
  var __getOwnPropNames = Object.getOwnPropertyNames;
  var __getProtoOf = Object.getPrototypeOf;
  var __hasOwnProp = Object.prototype.hasOwnProperty;
  var __require = /* @__PURE__ */ ((x) => typeof require !== "undefined" ? require : typeof Proxy !== "undefined" ? new Proxy(x, {
    get: (a, b) => (typeof require !== "undefined" ? require : a)[b]
  }) : x)(function(x) {
    if (typeof require !== "undefined") return require.apply(this, arguments);
    throw Error('Dynamic require of "' + x + '" is not supported');
  });
  var __copyProps = (to, from, except, desc) => {
    if (from && typeof from === "object" || typeof from === "function") {
      for (let key of __getOwnPropNames(from))
        if (!__hasOwnProp.call(to, key) && key !== except)
          __defProp(to, key, { get: () => from[key], enumerable: !(desc = __getOwnPropDesc(from, key)) || desc.enumerable });
    }
    return to;
  };
  var __toESM = (mod, isNodeMode, target) => (target = mod != null ? __create(__getProtoOf(mod)) : {}, __copyProps(
    // If the importer is in node compatibility mode or this is not an ESM
    // file that has been converted to a CommonJS file using a Babel-
    // compatible transform (i.e. "__esModule" has not been set), then set
    // "default" to the CommonJS "module.exports" for node compatibility.
    isNodeMode || !mod || !mod.__esModule ? __defProp(target, "default", { value: mod, enumerable: true }) : target,
    mod
  ));

  // src/admin/index.js
  var import_element = __require("@wordpress/element");
  var import_components = __require("@wordpress/components");
  var import_data = __require("@wordpress/data");
  var import_i18n = __require("@wordpress/i18n");
  var import_icons = __require("@wordpress/icons");
  var import_api_fetch = __toESM(__require("@wordpress/api-fetch"));
  var import_jsx_runtime = __require("react/jsx-runtime");
  var STATUS_MAP = {
    pending: { label: (0, import_i18n.__)("\u062F\u0631 \u0627\u0646\u062A\u0638\u0627\u0631", "rozholy-companion"), color: "#f59e0b" },
    confirmed: { label: (0, import_i18n.__)("\u062A\u0627\u06CC\u06CC\u062F \u0634\u062F\u0647", "rozholy-companion"), color: "#10b981" },
    completed: { label: (0, import_i18n.__)("\u0627\u0646\u062C\u0627\u0645 \u0634\u062F\u0647", "rozholy-companion"), color: "#6366f1" },
    cancelled: { label: (0, import_i18n.__)("\u0644\u063A\u0648 \u0634\u062F\u0647", "rozholy-companion"), color: "#ef4444" }
  };
  function StatusBadge({ status }) {
    const s = STATUS_MAP[status] || STATUS_MAP.pending;
    return /* @__PURE__ */ (0, import_jsx_runtime.jsx)(
      "span",
      {
        style: {
          display: "inline-block",
          padding: "2px 10px",
          borderRadius: 999,
          fontSize: 12,
          fontWeight: 600,
          background: s.color,
          color: "#fff"
        },
        children: s.label
      }
    );
  }
  function BookingRow({ booking, onStatusUpdate, onDelete, onView }) {
    const [showActions, setShowActions] = (0, import_element.useState)(false);
    return /* @__PURE__ */ (0, import_jsx_runtime.jsxs)(
      "div",
      {
        style: {
          display: "grid",
          gridTemplateColumns: "2fr 1.5fr 1.5fr 1.5fr 1fr 80px",
          gap: 12,
          alignItems: "center",
          padding: "12px 16px",
          borderBottom: "1px solid #f0f0f1",
          fontSize: 14
        },
        children: [
          /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", { style: { fontWeight: 500, color: "#1e1e1e" }, children: booking.name }),
          /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", { style: { color: "#50575e" }, children: booking.phone }),
          /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", { style: { color: "#50575e" }, children: booking.service }),
          /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", { style: { color: "#50575e" }, children: booking.bookingDate }),
          /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", { children: /* @__PURE__ */ (0, import_jsx_runtime.jsx)(StatusBadge, { status: booking.status }) }),
          /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", { style: { position: "relative" }, children: [
            /* @__PURE__ */ (0, import_jsx_runtime.jsx)(
              import_components.Button,
              {
                icon: import_icons.moreHorizontal,
                onClick: () => setShowActions(!showActions),
                label: (0, import_i18n.__)("\u0639\u0645\u0644\u06CC\u0627\u062A", "rozholy-companion"),
                style: { minWidth: 36 }
              }
            ),
            showActions && /* @__PURE__ */ (0, import_jsx_runtime.jsxs)(
              "div",
              {
                style: {
                  position: "absolute",
                  right: 0,
                  top: "100%",
                  background: "#fff",
                  border: "1px solid #e2e4e7",
                  borderRadius: 4,
                  boxShadow: "0 2px 8px rgba(0,0,0,0.08)",
                  zIndex: 10,
                  minWidth: 150
                },
                children: [
                  /* @__PURE__ */ (0, import_jsx_runtime.jsx)(
                    import_components.Button,
                    {
                      onClick: () => {
                        onView(booking);
                        setShowActions(false);
                      },
                      style: { width: "100%", justifyContent: "flex-start", padding: "8px 12px" },
                      children: (0, import_i18n.__)("\u062C\u0632\u0626\u06CC\u0627\u062A", "rozholy-companion")
                    }
                  ),
                  booking.status !== "confirmed" && /* @__PURE__ */ (0, import_jsx_runtime.jsxs)(
                    import_components.Button,
                    {
                      onClick: () => {
                        onStatusUpdate(booking.id, "confirmed");
                        setShowActions(false);
                      },
                      style: { width: "100%", justifyContent: "flex-start", padding: "8px 12px" },
                      children: [
                        "\u2705 ",
                        (0, import_i18n.__)("\u062A\u0627\u06CC\u06CC\u062F", "rozholy-companion")
                      ]
                    }
                  ),
                  booking.status !== "completed" && /* @__PURE__ */ (0, import_jsx_runtime.jsxs)(
                    import_components.Button,
                    {
                      onClick: () => {
                        onStatusUpdate(booking.id, "completed");
                        setShowActions(false);
                      },
                      style: { width: "100%", justifyContent: "flex-start", padding: "8px 12px" },
                      children: [
                        "\u2705 ",
                        (0, import_i18n.__)("\u0627\u0646\u062C\u0627\u0645 \u0634\u062F\u0647", "rozholy-companion")
                      ]
                    }
                  ),
                  booking.status !== "cancelled" && /* @__PURE__ */ (0, import_jsx_runtime.jsxs)(
                    import_components.Button,
                    {
                      onClick: () => {
                        onStatusUpdate(booking.id, "cancelled");
                        setShowActions(false);
                      },
                      style: { width: "100%", justifyContent: "flex-start", padding: "8px 12px" },
                      children: [
                        "\u274C ",
                        (0, import_i18n.__)("\u0644\u063A\u0648", "rozholy-companion")
                      ]
                    }
                  ),
                  /* @__PURE__ */ (0, import_jsx_runtime.jsxs)(
                    import_components.Button,
                    {
                      onClick: () => {
                        onDelete(booking.id);
                        setShowActions(false);
                      },
                      style: { width: "100%", justifyContent: "flex-start", padding: "8px 12px", color: "#cc1818" },
                      children: [
                        "\u{1F5D1}\uFE0F ",
                        (0, import_i18n.__)("\u062D\u0630\u0641", "rozholy-companion")
                      ]
                    }
                  )
                ]
              }
            )
          ] })
        ]
      }
    );
  }
  function BookingDetail({ booking, onClose }) {
    return /* @__PURE__ */ (0, import_jsx_runtime.jsx)(
      import_components.Modal,
      {
        title: (0, import_i18n.sprintf)((0, import_i18n.__)("\u062C\u0632\u0626\u06CC\u0627\u062A \u0631\u0632\u0631\u0648: %s", "rozholy-companion"), booking.name),
        onRequestClose: onClose,
        children: /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", { style: { display: "flex", flexDirection: "column", gap: 16 }, children: [
          /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", { children: [
            /* @__PURE__ */ (0, import_jsx_runtime.jsx)("strong", { children: (0, import_i18n.__)("\u0646\u0627\u0645:", "rozholy-companion") }),
            " ",
            booking.name
          ] }),
          /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", { children: [
            /* @__PURE__ */ (0, import_jsx_runtime.jsx)("strong", { children: (0, import_i18n.__)("\u0634\u0645\u0627\u0631\u0647 \u062A\u0645\u0627\u0633:", "rozholy-companion") }),
            " ",
            booking.phone
          ] }),
          /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", { children: [
            /* @__PURE__ */ (0, import_jsx_runtime.jsx)("strong", { children: (0, import_i18n.__)("\u062E\u062F\u0645\u062A:", "rozholy-companion") }),
            " ",
            booking.service || "-"
          ] }),
          /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", { children: [
            /* @__PURE__ */ (0, import_jsx_runtime.jsx)("strong", { children: (0, import_i18n.__)("\u062A\u0627\u0631\u06CC\u062E \u0631\u0632\u0631\u0648:", "rozholy-companion") }),
            " ",
            booking.bookingDate || "-"
          ] }),
          /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", { children: [
            /* @__PURE__ */ (0, import_jsx_runtime.jsx)("strong", { children: (0, import_i18n.__)("\u0648\u0636\u0639\u06CC\u062A:", "rozholy-companion") }),
            " ",
            /* @__PURE__ */ (0, import_jsx_runtime.jsx)(StatusBadge, { status: booking.status })
          ] }),
          booking.message && /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", { children: [
            /* @__PURE__ */ (0, import_jsx_runtime.jsx)("strong", { children: (0, import_i18n.__)("\u067E\u06CC\u0627\u0645:", "rozholy-companion") }),
            /* @__PURE__ */ (0, import_jsx_runtime.jsx)("p", { style: { background: "#f6f7f7", padding: 12, borderRadius: 4, marginTop: 4 }, children: booking.message })
          ] }),
          /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", { children: [
            /* @__PURE__ */ (0, import_jsx_runtime.jsx)("strong", { children: (0, import_i18n.__)("\u062A\u0627\u0631\u06CC\u062E \u062B\u0628\u062A:", "rozholy-companion") }),
            " ",
            new Date(booking.createdAt).toLocaleDateString("fa-IR")
          ] })
        ] })
      }
    );
  }
  function BookingManager() {
    const [bookings, setBookings] = (0, import_element.useState)([]);
    const [loading, setLoading] = (0, import_element.useState)(true);
    const [error, setError] = (0, import_element.useState)(null);
    const [notice, setNotice] = (0, import_element.useState)(null);
    const [selectedBooking, setSelectedBooking] = (0, import_element.useState)(null);
    const [statusFilter, setStatusFilter] = (0, import_element.useState)("all");
    const [searchTerm, setSearchTerm] = (0, import_element.useState)("");
    const loadBookings = (0, import_element.useCallback)(async (status = "all") => {
      setLoading(true);
      setError(null);
      try {
        const params = { per_page: 100 };
        if (status !== "all") params.status = status;
        const data = await (0, import_api_fetch.default)({ path: `/rozholy-companion/v1/bookings?${new URLSearchParams(params)}` });
        setBookings(data.items || []);
      } catch {
        setError((0, import_i18n.__)("\u062E\u0637\u0627 \u062F\u0631 \u0628\u0627\u0631\u06AF\u0630\u0627\u0631\u06CC \u0631\u0632\u0631\u0648\u0647\u0627", "rozholy-companion"));
      } finally {
        setLoading(false);
      }
    }, []);
    (0, import_element.useEffect)(() => {
      loadBookings(statusFilter);
    }, [statusFilter, loadBookings]);
    const handleStatusUpdate = async (id, newStatus) => {
      try {
        await (0, import_api_fetch.default)({
          path: `/rozholy-companion/v1/bookings/${id}/status`,
          method: "PUT",
          data: { status: newStatus }
        });
        setNotice({ type: "success", message: (0, import_i18n.__)("\u0648\u0636\u0639\u06CC\u062A \u0628\u0647\u200C\u0631\u0648\u0632\u0631\u0633\u0627\u0646\u06CC \u0634\u062F", "rozholy-companion") });
        loadBookings(statusFilter);
      } catch {
        setNotice({ type: "error", message: (0, import_i18n.__)("\u062E\u0637\u0627 \u062F\u0631 \u0628\u0647\u200C\u0631\u0648\u0632\u0631\u0633\u0627\u0646\u06CC", "rozholy-companion") });
      }
    };
    const handleDelete = async (id) => {
      if (!confirm((0, import_i18n.__)("\u0622\u06CC\u0627 \u0627\u0632 \u062D\u0630\u0641 \u0627\u06CC\u0646 \u0631\u0632\u0631\u0648 \u0627\u0637\u0645\u06CC\u0646\u0627\u0646 \u062F\u0627\u0631\u06CC\u062F\u061F", "rozholy-companion"))) return;
      try {
        await (0, import_api_fetch.default)({ path: `/rozholy-companion/v1/bookings/${id}`, method: "DELETE" });
        setNotice({ type: "success", message: (0, import_i18n.__)("\u0631\u0632\u0631\u0648 \u062D\u0630\u0641 \u0634\u062F", "rozholy-companion") });
        loadBookings(statusFilter);
      } catch {
        setNotice({ type: "error", message: (0, import_i18n.__)("\u062E\u0637\u0627 \u062F\u0631 \u062D\u0630\u0641", "rozholy-companion") });
      }
    };
    const filteredBookings = bookings.filter(
      (b) => !searchTerm || b.name.includes(searchTerm) || b.phone.includes(searchTerm)
    );
    const tabs = [
      { name: "all", title: (0, import_i18n.__)("\u0647\u0645\u0647", "rozholy-companion") },
      { name: "pending", title: (0, import_i18n.__)("\u062F\u0631 \u0627\u0646\u062A\u0638\u0627\u0631", "rozholy-companion") },
      { name: "confirmed", title: (0, import_i18n.__)("\u062A\u0627\u06CC\u06CC\u062F \u0634\u062F\u0647", "rozholy-companion") },
      { name: "completed", title: (0, import_i18n.__)("\u0627\u0646\u062C\u0627\u0645 \u0634\u062F\u0647", "rozholy-companion") },
      { name: "cancelled", title: (0, import_i18n.__)("\u0644\u063A\u0648 \u0634\u062F\u0647", "rozholy-companion") }
    ];
    return /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", { style: { maxWidth: 1200, margin: "0 auto" }, children: [
      /* @__PURE__ */ (0, import_jsx_runtime.jsxs)(import_components.Card, { children: [
        /* @__PURE__ */ (0, import_jsx_runtime.jsxs)(import_components.CardHeader, { style: { display: "flex", justifyContent: "space-between", alignItems: "center", flexWrap: "wrap", gap: 12 }, children: [
          /* @__PURE__ */ (0, import_jsx_runtime.jsx)(import_components.__experimentalHeading, { level: 3, style: { margin: 0 }, children: (0, import_i18n.__)("\u0645\u062F\u06CC\u0631\u06CC\u062A \u0631\u0632\u0631\u0648\u0647\u0627", "rozholy-companion") }),
          /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", { style: { display: "flex", gap: 8 }, children: [
            /* @__PURE__ */ (0, import_jsx_runtime.jsx)(
              import_components.SearchControl,
              {
                value: searchTerm,
                onChange: setSearchTerm,
                placeholder: (0, import_i18n.__)("\u062C\u0633\u062A\u062C\u0648...", "rozholy-companion"),
                style: { minWidth: 200 }
              }
            ),
            /* @__PURE__ */ (0, import_jsx_runtime.jsx)(
              import_components.Button,
              {
                variant: "secondary",
                icon: import_icons.update,
                onClick: () => loadBookings(statusFilter),
                label: (0, import_i18n.__)("\u0628\u0631\u0648\u0632\u0631\u0633\u0627\u0646\u06CC", "rozholy-companion")
              }
            )
          ] })
        ] }),
        /* @__PURE__ */ (0, import_jsx_runtime.jsxs)(import_components.CardBody, { style: { padding: 0 }, children: [
          /* @__PURE__ */ (0, import_jsx_runtime.jsx)(
            import_components.TabPanel,
            {
              tabs,
              onSelect: (tab) => setStatusFilter(tab.name),
              initialTabName: statusFilter,
              style: { padding: "0 16px" },
              children: (tab) => null
            }
          ),
          notice && /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", { style: { padding: "8px 16px" }, children: /* @__PURE__ */ (0, import_jsx_runtime.jsx)(
            import_components.Notice,
            {
              status: notice.type,
              onRemove: () => setNotice(null),
              isDismissible: true,
              children: notice.message
            }
          ) }),
          /* @__PURE__ */ (0, import_jsx_runtime.jsxs)(
            "div",
            {
              style: {
                display: "grid",
                gridTemplateColumns: "2fr 1.5fr 1.5fr 1.5fr 1fr 80px",
                gap: 12,
                padding: "10px 16px",
                background: "#f6f7f7",
                borderBottom: "1px solid #e2e4e7",
                fontSize: 12,
                fontWeight: 600,
                color: "#50575e",
                textTransform: "uppercase"
              },
              children: [
                /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", { children: (0, import_i18n.__)("\u0646\u0627\u0645", "rozholy-companion") }),
                /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", { children: (0, import_i18n.__)("\u0634\u0645\u0627\u0631\u0647 \u062A\u0645\u0627\u0633", "rozholy-companion") }),
                /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", { children: (0, import_i18n.__)("\u062E\u062F\u0645\u062A", "rozholy-companion") }),
                /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", { children: (0, import_i18n.__)("\u062A\u0627\u0631\u06CC\u062E", "rozholy-companion") }),
                /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", { children: (0, import_i18n.__)("\u0648\u0636\u0639\u06CC\u062A", "rozholy-companion") }),
                /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", { children: (0, import_i18n.__)("\u0639\u0645\u0644\u06CC\u0627\u062A", "rozholy-companion") })
              ]
            }
          ),
          loading ? /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", { style: { textAlign: "center", padding: 40 }, children: [
            /* @__PURE__ */ (0, import_jsx_runtime.jsx)(import_components.Spinner, {}),
            /* @__PURE__ */ (0, import_jsx_runtime.jsx)("p", { children: (0, import_i18n.__)("\u062F\u0631 \u062D\u0627\u0644 \u0628\u0627\u0631\u06AF\u0630\u0627\u0631\u06CC...", "rozholy-companion") })
          ] }) : error ? /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", { style: { textAlign: "center", padding: 40, color: "#cc1818" }, children: [
            /* @__PURE__ */ (0, import_jsx_runtime.jsx)("p", { children: error }),
            /* @__PURE__ */ (0, import_jsx_runtime.jsx)(import_components.Button, { variant: "secondary", onClick: () => loadBookings(statusFilter), children: (0, import_i18n.__)("\u062A\u0644\u0627\u0634 \u0645\u062C\u062F\u062F", "rozholy-companion") })
          ] }) : filteredBookings.length === 0 ? /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", { style: { textAlign: "center", padding: 40, color: "#757575" }, children: /* @__PURE__ */ (0, import_jsx_runtime.jsx)("p", { children: (0, import_i18n.__)("\u0647\u06CC\u0686 \u0631\u0632\u0631\u0648\u06CC \u06CC\u0627\u0641\u062A \u0646\u0634\u062F", "rozholy-companion") }) }) : filteredBookings.map((booking) => /* @__PURE__ */ (0, import_jsx_runtime.jsx)(
            BookingRow,
            {
              booking,
              onStatusUpdate: handleStatusUpdate,
              onDelete: handleDelete,
              onView: setSelectedBooking
            },
            booking.id
          )),
          /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", { style: { padding: "12px 16px", borderTop: "1px solid #e2e4e7", fontSize: 13, color: "#757575" }, children: (0, import_i18n.sprintf)((0, import_i18n.__)("\u0646\u0645\u0627\u06CC\u0634 %d \u0627\u0632 %d \u0631\u0632\u0631\u0648", "rozholy-companion"), filteredBookings.length, bookings.length) })
        ] })
      ] }),
      selectedBooking && /* @__PURE__ */ (0, import_jsx_runtime.jsx)(
        BookingDetail,
        {
          booking: selectedBooking,
          onClose: () => setSelectedBooking(null)
        }
      )
    ] });
  }
  document.addEventListener("DOMContentLoaded", () => {
    const root = document.getElementById("rz-booking-root");
    if (root) {
      (0, import_element.render)(/* @__PURE__ */ (0, import_jsx_runtime.jsx)(BookingManager, {}), root);
    }
  });
})();
