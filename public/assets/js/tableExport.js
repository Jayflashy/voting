/*
 tableExport.jquery.plugin

 Version 1.10.2

 Copyright (c) 2015-2018 hhurz, https://github.com/hhurz

 Original Work Copyright (c) 2014 Giri Raj

 Licensed under the MIT License
*/
var $jscomp = $jscomp || {};
$jscomp.scope = {};
$jscomp.findInternal = function (d, l, u) {
    d instanceof String && (d = String(d));
    for (var w = d.length, x = 0; x < w; x++) {
        var P = d[x];
        if (l.call(u, P, x, d)) return { i: x, v: P };
    }
    return { i: -1, v: void 0 };
};
$jscomp.ASSUME_ES5 = !1;
$jscomp.ASSUME_NO_NATIVE_MAP = !1;
$jscomp.ASSUME_NO_NATIVE_SET = !1;
$jscomp.defineProperty =
    $jscomp.ASSUME_ES5 || "function" == typeof Object.defineProperties
        ? Object.defineProperty
        : function (d, l, u) {
              d != Array.prototype && d != Object.prototype && (d[l] = u.value);
          };
$jscomp.getGlobal = function (d) {
    return "undefined" != typeof window && window === d ? d : "undefined" != typeof global && null != global ? global : d;
};
$jscomp.global = $jscomp.getGlobal(this);
$jscomp.polyfill = function (d, l, u, w) {
    if (l) {
        u = $jscomp.global;
        d = d.split(".");
        for (w = 0; w < d.length - 1; w++) {
            var x = d[w];
            x in u || (u[x] = {});
            u = u[x];
        }
        d = d[d.length - 1];
        w = u[d];
        l = l(w);
        l != w && null != l && $jscomp.defineProperty(u, d, { configurable: !0, writable: !0, value: l });
    }
};
$jscomp.polyfill(
    "Array.prototype.find",
    function (d) {
        return d
            ? d
            : function (d, u) {
                  return $jscomp.findInternal(this, d, u).v;
              };
    },
    "es6",
    "es3"
);
(function (d) {
    d.fn.tableExport = function (l) {
        function u(b) {
            var c = [];
            x(b, "thead").each(function () {
                c.push.apply(c, x(d(this), a.theadSelector).toArray());
            });
            return c;
        }
        function w(b) {
            var c = [];
            x(b, "tbody").each(function () {
                c.push.apply(c, x(d(this), a.tbodySelector).toArray());
            });
            a.tfootSelector.length &&
                x(b, "tfoot").each(function () {
                    c.push.apply(c, x(d(this), a.tfootSelector).toArray());
                });
            return c;
        }
        function x(b, c) {
            var a = b[0].tagName,
                h = b.parents(a).length;
            return b.find(c).filter(function () {
                return h === d(this).closest(a).parents(a).length;
            });
        }
        function P(b) {
            var c = [];
            d(b)
                .find("thead")
                .first()
                .find("th")
                .each(function (b, a) {
                    void 0 !== d(a).attr("data-field") ? (c[b] = d(a).attr("data-field")) : (c[b] = b.toString());
                });
            return c;
        }
        function Q(b) {
            var c = "undefined" !== typeof b[0].cellIndex,
                a = "undefined" !== typeof b[0].rowIndex,
                h = c || a ? Ea(b) : b.is(":visible"),
                g = b.data("tableexport-display");
            c && "none" !== g && "always" !== g && ((b = d(b[0].parentNode)), (a = "undefined" !== typeof b[0].rowIndex), (g = b.data("tableexport-display")));
            a && "none" !== g && "always" !== g && (g = b.closest("table").data("tableexport-display"));
            return "none" !== g && (!0 === h || "always" === g);
        }
        function Ea(b) {
            var c = [];
            U &&
                (c = I.filter(function () {
                    var c = !1;
                    this.nodeType === b[0].nodeType &&
                        ("undefined" !== typeof this.rowIndex && this.rowIndex === b[0].rowIndex
                            ? (c = !0)
                            : "undefined" !== typeof this.cellIndex &&
                              this.cellIndex === b[0].cellIndex &&
                              "undefined" !== typeof this.parentNode.rowIndex &&
                              "undefined" !== typeof b[0].parentNode.rowIndex &&
                              this.parentNode.rowIndex === b[0].parentNode.rowIndex &&
                              (c = !0));
                    return c;
                }));
            return !1 === U || 0 === c.length;
        }
        function Fa(b, c, f) {
            var h = !1;
            Q(b)
                ? 0 < a.ignoreColumn.length && (-1 !== d.inArray(f, a.ignoreColumn) || -1 !== d.inArray(f - c, a.ignoreColumn) || (R.length > f && "undefined" !== typeof R[f] && -1 !== d.inArray(R[f], a.ignoreColumn))) && (h = !0)
                : (h = !0);
            return h;
        }
        function D(b, c, f, h, g) {
            if ("function" === typeof g) {
                var k = !1;
                "function" === typeof a.onIgnoreRow && (k = a.onIgnoreRow(d(b), f));
                if (!1 === k && -1 === d.inArray(f, a.ignoreRow) && -1 === d.inArray(f - h, a.ignoreRow) && Q(d(b))) {
                    var y = x(d(b), c),
                        q = 0;
                    y.each(function (b) {
                        var c = d(this),
                            a,
                            h = S(this),
                            k = T(this);
                        d.each(F, function () {
                            if (f >= this.s.r && f <= this.e.r && q >= this.s.c && q <= this.e.c) for (a = 0; a <= this.e.c - this.s.c; ++a) g(null, f, q++);
                        });
                        if (!1 === Fa(c, y.length, b)) {
                            if (k || h) (h = h || 1), F.push({ s: { r: f, c: q }, e: { r: f + (k || 1) - 1, c: q + h - 1 } });
                            g(this, f, q++);
                        }
                        if (h) for (a = 0; a < h - 1; ++a) g(null, f, q++);
                    });
                    d.each(F, function () {
                        if (f >= this.s.r && f <= this.e.r && q >= this.s.c && q <= this.e.c) for (aa = 0; aa <= this.e.c - this.s.c; ++aa) g(null, f, q++);
                    });
                }
            }
        }
        function pa(b, c, a, d) {
            if ("undefined" !== typeof d.images && ((a = d.images[a]), "undefined" !== typeof a)) {
                c = c.getBoundingClientRect();
                var g = b.width / b.height,
                    f = c.width / c.height,
                    h = b.width,
                    q = b.height,
                    e = 19.049976 / 25.4,
                    l = 0;
                f <= g ? ((q = Math.min(b.height, c.height)), (h = (c.width * q) / c.height)) : f > g && ((h = Math.min(b.width, c.width)), (q = (c.height * h) / c.width));
                h *= e;
                q *= e;
                q < b.height && (l = (b.height - q) / 2);
                try {
                    d.doc.addImage(a.src, b.textPos.x, b.y + l, h, q);
                } catch (Ka) {}
                b.textPos.x += h;
            }
        }
        function qa(b, c) {
            if ("string" === a.outputMode) return b.output();
            if ("base64" === a.outputMode) return J(b.output());
            if ("window" === a.outputMode) (window.URL = window.URL || window.webkitURL), window.open(window.URL.createObjectURL(b.output("blob")));
            else
                try {
                    var d = b.output("blob");
                    saveAs(d, a.fileName + ".pdf");
                } catch (h) {
                    G(a.fileName + ".pdf", "data:application/pdf" + (c ? "" : ";base64") + ",", c ? b.output("blob") : b.output());
                }
        }
        function ra(b, c, a) {
            var d = 0;
            "undefined" !== typeof a && (d = a.colspan);
            if (0 <= d) {
                for (var g = b.width, f = b.textPos.x, y = c.table.columns.indexOf(c.column), q = 1; q < d; q++) g += c.table.columns[y + q].width;
                1 < d && ("right" === b.styles.halign ? (f = b.textPos.x + g - b.width) : "center" === b.styles.halign && (f = b.textPos.x + (g - b.width) / 2));
                b.width = g;
                b.textPos.x = f;
                "undefined" !== typeof a && 1 < a.rowspan && (b.height *= a.rowspan);
                if ("middle" === b.styles.valign || "bottom" === b.styles.valign)
                    (a = ("string" === typeof b.text ? b.text.split(/\r\n|\r|\n/g) : b.text).length || 1), 2 < a && (b.textPos.y -= (((2 - 1.15) / 2) * c.row.styles.fontSize * (a - 2)) / 3);
                return !0;
            }
            return !1;
        }
        function sa(b, a, f) {
            "undefined" !== typeof b &&
                null !== b &&
                (b.hasAttribute("data-tableexport-canvas")
                    ? ((a = new Date().getTime()), d(b).attr("data-tableexport-canvas", a), (f.images[a] = { url: '[data-tableexport-canvas="' + a + '"]', src: null }))
                    : "undefined" !== a &&
                      null != a &&
                      a.each(function () {
                          if (d(this).is("img")) {
                              var a = ta(this.src);
                              f.images[a] = { url: this.src, src: this.src };
                          }
                          sa(b, d(this).children(), f);
                      }));
        }
        function Ga(b, a) {
            function c(b) {
                if (b.url)
                    if (b.src) {
                        var c = new Image();
                        h = ++g;
                        c.crossOrigin = "Anonymous";
                        c.onerror = c.onload = function () {
                            if (c.complete && (0 === c.src.indexOf("data:image/") && ((c.width = b.width || c.width || 0), (c.height = b.height || c.height || 0)), c.width + c.height)) {
                                var d = document.createElement("canvas"),
                                    f = d.getContext("2d");
                                d.width = c.width;
                                d.height = c.height;
                                f.drawImage(c, 0, 0);
                                b.src = d.toDataURL("image/png");
                            }
                            --g || a(h);
                        };
                        c.src = b.url;
                    } else {
                        var f = d(b.url);
                        f.length &&
                            ((h = ++g),
                            html2canvas(f[0]).then(function (c) {
                                b.src = c.toDataURL("image/png");
                                --g || a(h);
                            }));
                    }
            }
            var h = 0,
                g = 0;
            if ("undefined" !== typeof b.images) for (var k in b.images) b.images.hasOwnProperty(k) && c(b.images[k]);
            (b = g) || (a(h), (b = void 0));
            return b;
        }
        function ua(b, c, f) {
            c.each(function () {
                if (d(this).is("div")) {
                    var c = ba(K(this, "background-color"), [255, 255, 255]),
                        g = ba(K(this, "border-top-color"), [0, 0, 0]),
                        k = ca(this, "border-top-width", a.jspdf.unit),
                        y = this.getBoundingClientRect(),
                        q = this.offsetLeft * f.wScaleFactor,
                        e = this.offsetTop * f.hScaleFactor,
                        l = y.width * f.wScaleFactor;
                    y = y.height * f.hScaleFactor;
                    f.doc.setDrawColor.apply(void 0, g);
                    f.doc.setFillColor.apply(void 0, c);
                    f.doc.setLineWidth(k);
                    f.doc.rect(b.x + q, b.y + e, l, y, k ? "FD" : "F");
                } else d(this).is("img") && ((c = ta(this.src)), pa(b, this, c, f));
                ua(b, d(this).children(), f);
            });
        }
        function va(b, c, f) {
            if ("function" === typeof f.onAutotableText) f.onAutotableText(f.doc, b, c);
            else {
                var h = b.textPos.x,
                    g = b.textPos.y,
                    k = { halign: b.styles.halign, valign: b.styles.valign };
                if (c.length) {
                    for (c = c[0]; c.previousSibling; ) c = c.previousSibling;
                    for (var y = !1, q = !1; c; ) {
                        var e = c.innerText || c.textContent || "",
                            l = e.length && " " === e[0] ? " " : "",
                            m = 1 < e.length && " " === e[e.length - 1] ? " " : "";
                        !0 !== a.preserve.leadingWS && (e = l + ha(e));
                        !0 !== a.preserve.trailingWS && (e = ia(e) + m);
                        d(c).is("br") && ((h = b.textPos.x), (g += f.doc.internal.getFontSize()));
                        d(c).is("b") ? (y = !0) : d(c).is("i") && (q = !0);
                        (y || q) && f.doc.setFontType(y && q ? "bolditalic" : y ? "bold" : "italic");
                        if ((l = f.doc.getStringUnitWidth(e) * f.doc.internal.getFontSize())) {
                            "linebreak" === b.styles.overflow &&
                                h > b.textPos.x &&
                                h + l > b.textPos.x + b.width &&
                                (0 <= ".,!%*;:=-".indexOf(e.charAt(0)) &&
                                    ((m = e.charAt(0)),
                                    (l = f.doc.getStringUnitWidth(m) * f.doc.internal.getFontSize()),
                                    h + l <= b.textPos.x + b.width && (f.doc.autoTableText(m, h, g, k), (e = e.substring(1, e.length))),
                                    (l = f.doc.getStringUnitWidth(e) * f.doc.internal.getFontSize())),
                                (h = b.textPos.x),
                                (g += f.doc.internal.getFontSize()));
                            if ("visible" !== b.styles.overflow) for (; e.length && h + l > b.textPos.x + b.width; ) (e = e.substring(0, e.length - 1)), (l = f.doc.getStringUnitWidth(e) * f.doc.internal.getFontSize());
                            f.doc.autoTableText(e, h, g, k);
                            h += l;
                        }
                        if (y || q) d(c).is("b") ? (y = !1) : d(c).is("i") && (q = !1), f.doc.setFontType(y || q ? (y ? "bold" : "italic") : "normal");
                        c = c.nextSibling;
                    }
                    b.textPos.x = h;
                    b.textPos.y = g;
                } else f.doc.autoTableText(b.text, b.textPos.x, b.textPos.y, k);
            }
        }
        function da(b, a, d) {
            return null == b ? "" : b.toString().replace(new RegExp(null == a ? "" : a.toString().replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1"), "g"), d);
        }
        function ha(b) {
            return null == b ? "" : b.toString().replace(/^\s+/, "");
        }
        function ia(b) {
            return null == b ? "" : b.toString().replace(/\s+$/, "");
        }
        function ja(b) {
            b = da(b || "0", a.numbers.html.thousandsSeparator, "");
            b = da(b, a.numbers.html.decimalMark, ".");
            return "number" === typeof b || !1 !== jQuery.isNumeric(b) ? b : !1;
        }
        function Ha(b) {
            -1 < b.indexOf("%") ? ((b = ja(b.replace(/%/g, ""))), !1 !== b && (b /= 100)) : (b = !1);
            return b;
        }
        function B(b, c, f) {
            var h = "";
            if (null !== b) {
                var g = d(b);
                if (g[0].hasAttribute("data-tableexport-canvas")) var k = "";
                else if (g[0].hasAttribute("data-tableexport-value")) k = (k = g.data("tableexport-value")) ? k + "" : "";
                else if (((k = g.html()), "function" === typeof a.onCellHtmlData)) k = a.onCellHtmlData(g, c, f, k);
                else if ("" !== k) {
                    var e = d.parseHTML(k),
                        q = 0,
                        l = 0;
                    k = "";
                    d.each(e, function () {
                        if (d(this).is("input"))
                            k += g
                                .find("input")
                                .eq(q++)
                                .val();
                        else if (d(this).is("select"))
                            k += g
                                .find("select option:selected")
                                .eq(l++)
                                .text();
                        else if (d(this).is("br")) k += "<br>";
                        else if ("undefined" === typeof d(this).html()) k += d(this).text();
                        else if (void 0 === jQuery().bootstrapTable || (!0 !== d(this).hasClass("filterControl") && 0 === d(b).parents(".detail-view").length)) k += d(this).html();
                    });
                }
                if (!0 === a.htmlContent) h = d.trim(k);
                else if (k && "" !== k)
                    if ("" !== d(b).data("tableexport-cellformat")) {
                        var m = k.replace(/\n/g, "\u2028").replace(/(<\s*br([^>]*)>)/gi, "\u2060"),
                            n = d("<div/>").html(m).contents();
                        e = !1;
                        m = "";
                        d.each(n.text().split("\u2028"), function (b, c) {
                            0 < b && (m += " ");
                            !0 !== a.preserve.leadingWS && (c = ha(c));
                            m += !0 !== a.preserve.trailingWS ? ia(c) : c;
                        });
                        d.each(m.split("\u2060"), function (b, c) {
                            0 < b && (h += "\n");
                            !0 !== a.preserve.leadingWS && (c = ha(c));
                            !0 !== a.preserve.trailingWS && (c = ia(c));
                            h += c.replace(/\u00AD/g, "");
                        });
                        h = h.replace(/\u00A0/g, " ");
                        if ("json" === a.type || ("excel" === a.type && "xmlss" === a.mso.fileFormat) || !1 === a.numbers.output) (e = ja(h)), !1 !== e && (h = Number(e));
                        else if (a.numbers.html.decimalMark !== a.numbers.output.decimalMark || a.numbers.html.thousandsSeparator !== a.numbers.output.thousandsSeparator)
                            if (((e = ja(h)), !1 !== e)) {
                                n = ("" + e.substr(0 > e ? 1 : 0)).split(".");
                                1 === n.length && (n[1] = "");
                                var p = 3 < n[0].length ? n[0].length % 3 : 0;
                                h =
                                    (0 > e ? "-" : "") +
                                    (a.numbers.output.thousandsSeparator ? (p ? n[0].substr(0, p) + a.numbers.output.thousandsSeparator : "") + n[0].substr(p).replace(/(\d{3})(?=\d)/g, "$1" + a.numbers.output.thousandsSeparator) : n[0]) +
                                    (n[1].length ? a.numbers.output.decimalMark + n[1] : "");
                            }
                    } else h = k;
                !0 === a.escape && (h = escape(h));
                "function" === typeof a.onCellData && (h = a.onCellData(g, c, f, h));
            }
            return h;
        }
        function wa(b) {
            return 0 < b.length && !0 === a.preventInjection && 0 <= "=+-@".indexOf(b.charAt(0)) ? "'" + b : b;
        }
        function Ia(b, a, d) {
            return a + "-" + d.toLowerCase();
        }
        function ba(b, a) {
            (b = /^rgb\((\d{1,3}),\s*(\d{1,3}),\s*(\d{1,3})\)$/.exec(b)) && (a = [parseInt(b[1]), parseInt(b[2]), parseInt(b[3])]);
            return a;
        }
        function xa(b) {
            var a = K(b, "text-align"),
                d = K(b, "font-weight"),
                h = K(b, "font-style"),
                g = "";
            "start" === a && (a = "rtl" === K(b, "direction") ? "right" : "left");
            700 <= d && (g = "bold");
            "italic" === h && (g += h);
            "" === g && (g = "normal");
            a = { style: { align: a, bcolor: ba(K(b, "background-color"), [255, 255, 255]), color: ba(K(b, "color"), [0, 0, 0]), fstyle: g }, colspan: S(b), rowspan: T(b) };
            null !== b && ((b = b.getBoundingClientRect()), (a.rect = { width: b.width, height: b.height }));
            return a;
        }
        function S(b) {
            var a = d(b).data("tableexport-colspan");
            "undefined" === typeof a && d(b).is("[colspan]") && (a = d(b).attr("colspan"));
            return parseInt(a) || 0;
        }
        function T(b) {
            var a = d(b).data("tableexport-rowspan");
            "undefined" === typeof a && d(b).is("[rowspan]") && (a = d(b).attr("rowspan"));
            return parseInt(a) || 0;
        }
        function K(b, a) {
            try {
                return window.getComputedStyle ? ((a = a.replace(/([a-z])([A-Z])/, Ia)), window.getComputedStyle(b, null).getPropertyValue(a)) : b.currentStyle ? b.currentStyle[a] : b.style[a];
            } catch (f) {}
            return "";
        }
        function ca(b, a, d) {
            a = K(b, a).match(/\d+/);
            if (null !== a) {
                a = a[0];
                b = b.parentElement;
                var c = document.createElement("div");
                c.style.overflow = "hidden";
                c.style.visibility = "hidden";
                b.appendChild(c);
                c.style.width = 100 + d;
                d = 100 / c.offsetWidth;
                b.removeChild(c);
                return a * d;
            }
            return 0;
        }
        function ka() {
            if (!(this instanceof ka)) return new ka();
            this.SheetNames = [];
            this.Sheets = {};
        }
        function ya(b) {
            for (var a = new ArrayBuffer(b.length), d = new Uint8Array(a), h = 0; h !== b.length; ++h) d[h] = b.charCodeAt(h) & 255;
            return a;
        }
        function Ja(b) {
            for (var a = {}, d = { s: { c: 1e7, r: 1e7 }, e: { c: 0, r: 0 } }, h = 0; h !== b.length; ++h)
                for (var g = 0; g !== b[h].length; ++g) {
                    d.s.r > h && (d.s.r = h);
                    d.s.c > g && (d.s.c = g);
                    d.e.r < h && (d.e.r = h);
                    d.e.c < g && (d.e.c = g);
                    var k = { v: b[h][g] };
                    if (null !== k.v) {
                        var e = XLSX.utils.encode_cell({ c: g, r: h });
                        if ("number" === typeof k.v) k.t = "n";
                        else if ("boolean" === typeof k.v) k.t = "b";
                        else if (k.v instanceof Date) {
                            k.t = "n";
                            k.z = XLSX.SSF._table[14];
                            var q = k;
                            var l = (Date.parse(k.v) - new Date(Date.UTC(1899, 11, 30))) / 864e5;
                            q.v = l;
                        } else k.t = "s";
                        a[e] = k;
                    }
                }
            1e7 > d.s.c && (a["!ref"] = XLSX.utils.encode_range(d));
            return a;
        }
        function ta(b) {
            var a = 0,
                d;
            if (0 === b.length) return a;
            var h = 0;
            for (d = b.length; h < d; h++) {
                var g = b.charCodeAt(h);
                a = (a << 5) - a + g;
                a |= 0;
            }
            return a;
        }
        function G(a, c, d) {
            var b = window.navigator.userAgent;
            if (!1 !== a && window.navigator.msSaveOrOpenBlob) window.navigator.msSaveOrOpenBlob(new Blob([d]), a);
            else if (!1 !== a && (0 < b.indexOf("MSIE ") || b.match(/Trident.*rv:11\./))) {
                if ((c = document.createElement("iframe"))) {
                    document.body.appendChild(c);
                    c.setAttribute("style", "display:none");
                    c.contentDocument.open("txt/plain", "replace");
                    c.contentDocument.write(d);
                    c.contentDocument.close();
                    c.contentDocument.focus();
                    switch (a.substr(a.lastIndexOf(".") + 1)) {
                        case "doc":
                        case "json":
                        case "png":
                        case "pdf":
                        case "xls":
                        case "xlsx":
                            a += ".txt";
                    }
                    c.contentDocument.execCommand("SaveAs", !0, a);
                    document.body.removeChild(c);
                }
            } else {
                var g = document.createElement("a");
                if (g) {
                    var k = null;
                    g.style.display = "none";
                    !1 !== a ? (g.download = a) : (g.target = "_blank");
                    "object" === typeof d
                        ? ((window.URL = window.URL || window.webkitURL), (a = []), a.push(d), (k = window.URL.createObjectURL(new Blob(a, { type: c }))), (g.href = k))
                        : 0 <= c.toLowerCase().indexOf("base64,")
                        ? (g.href = c + J(d))
                        : (g.href = c + encodeURIComponent(d));
                    document.body.appendChild(g);
                    if (document.createEvent) null === ea && (ea = document.createEvent("MouseEvents")), ea.initEvent("click", !0, !1), g.dispatchEvent(ea);
                    else if (document.createEventObject) g.fireEvent("onclick");
                    else if ("function" === typeof g.onclick) g.onclick();
                    setTimeout(function () {
                        k && window.URL.revokeObjectURL(k);
                        document.body.removeChild(g);
                    }, 100);
                }
            }
        }
        function J(a) {
            var b,
                d = "",
                h = 0;
            if ("string" === typeof a) {
                a = a.replace(/\x0d\x0a/g, "\n");
                var g = "";
                for (b = 0; b < a.length; b++) {
                    var k = a.charCodeAt(b);
                    128 > k
                        ? (g += String.fromCharCode(k))
                        : (127 < k && 2048 > k ? (g += String.fromCharCode((k >> 6) | 192)) : ((g += String.fromCharCode((k >> 12) | 224)), (g += String.fromCharCode(((k >> 6) & 63) | 128))), (g += String.fromCharCode((k & 63) | 128)));
                }
                a = g;
            }
            for (; h < a.length; ) {
                var e = a.charCodeAt(h++);
                g = a.charCodeAt(h++);
                b = a.charCodeAt(h++);
                k = e >> 2;
                e = ((e & 3) << 4) | (g >> 4);
                var q = ((g & 15) << 2) | (b >> 6);
                var l = b & 63;
                isNaN(g) ? (q = l = 64) : isNaN(b) && (l = 64);
                d =
                    d +
                    "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=".charAt(k) +
                    "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=".charAt(e) +
                    "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=".charAt(q) +
                    "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=".charAt(l);
            }
            return d;
        }
        var a = {
                csvEnclosure: '"',
                csvSeparator: ",",
                csvUseBOM: !0,
                displayTableName: !1,
                escape: !1,
                exportHiddenCells: !1,
                fileName: "tableExportss",
                htmlContent: !1,
                ignoreColumn: [],
                ignoreRow: [],
                jsonScope: "all",
                jspdf: {
                    orientation: "p",
                    unit: "pt",
                    format: "a4",
                    margins: { left: 20, right: 10, top: 10, bottom: 10 },
                    onDocCreated: null,
                    autotable: {
                        styles: { cellPadding: 2, rowHeight: 12, fontSize: 8, fillColor: 255, textColor: 50, fontStyle: "normal", overflow: "ellipsize", halign: "inherit", valign: "middle" },
                        headerStyles: { fillColor: [52, 73, 94], textColor: 255, fontStyle: "bold", halign: "inherit", valign: "middle" },
                        alternateRowStyles: { fillColor: 245 },
                        tableExport: { doc: null, onAfterAutotable: null, onBeforeAutotable: null, onAutotableText: null, onTable: null, outputImages: !0 },
                    },
                },
                mso: { fileFormat: "xlshtml", onMsoNumberFormat: null, pageFormat: "a4", pageOrientation: "portrait", rtl: !1, styles: [], worksheetName: "" },
                numbers: { html: { decimalMark: ".", thousandsSeparator: "," }, output: { decimalMark: ".", thousandsSeparator: "," } },
                onCellData: null,
                onCellHtmlData: null,
                onIgnoreRow: null,
                outputMode: "file",
                pdfmake: { enabled: !1, docDefinition: { pageOrientation: "portrait", defaultStyle: { font: "Roboto" } }, fonts: {} },
                preserve: { leadingWS: !1, trailingWS: !1 },
                preventInjection: !0,
                tbodySelector: "tr",
                tfootSelector: "tr",
                theadSelector: "tr",
                tableName: "Table",
                type: "csv",
            },
            L = {
                a0: [2383.94, 3370.39],
                a1: [1683.78, 2383.94],
                a2: [1190.55, 1683.78],
                a3: [841.89, 1190.55],
                a4: [595.28, 841.89],
                a5: [419.53, 595.28],
                a6: [297.64, 419.53],
                a7: [209.76, 297.64],
                a8: [147.4, 209.76],
                a9: [104.88, 147.4],
                a10: [73.7, 104.88],
                b0: [2834.65, 4008.19],
                b1: [2004.09, 2834.65],
                b2: [1417.32, 2004.09],
                b3: [1000.63, 1417.32],
                b4: [708.66, 1000.63],
                b5: [498.9, 708.66],
                b6: [354.33, 498.9],
                b7: [249.45, 354.33],
                b8: [175.75, 249.45],
                b9: [124.72, 175.75],
                b10: [87.87, 124.72],
                c0: [2599.37, 3676.54],
                c1: [1836.85, 2599.37],
                c2: [1298.27, 1836.85],
                c3: [918.43, 1298.27],
                c4: [649.13, 918.43],
                c5: [459.21, 649.13],
                c6: [323.15, 459.21],
                c7: [229.61, 323.15],
                c8: [161.57, 229.61],
                c9: [113.39, 161.57],
                c10: [79.37, 113.39],
                dl: [311.81, 623.62],
                letter: [612, 792],
                "government-letter": [576, 756],
                legal: [612, 1008],
                "junior-legal": [576, 360],
                ledger: [1224, 792],
                tabloid: [792, 1224],
                "credit-card": [153, 243],
            },
            v = this,
            ea = null,
            r = [],
            t = [],
            n = 0,
            p = "",
            R = [],
            F = [],
            I = [],
            U = !1;
        d.extend(!0, a, l);
        "xlsx" === a.type && ((a.mso.fileFormat = a.type), (a.type = "excel"));
        "undefined" !== typeof a.excelFileFormat && "undefined" === a.mso.fileFormat && (a.mso.fileFormat = a.excelFileFormat);
        "undefined" !== typeof a.excelPageFormat && "undefined" === a.mso.pageFormat && (a.mso.pageFormat = a.excelPageFormat);
        "undefined" !== typeof a.excelPageOrientation && "undefined" === a.mso.pageOrientation && (a.mso.pageOrientation = a.excelPageOrientation);
        "undefined" !== typeof a.excelRTL && "undefined" === a.mso.rtl && (a.mso.rtl = a.excelRTL);
        "undefined" !== typeof a.excelstyles && "undefined" === a.mso.styles && (a.mso.styles = a.excelstyles);
        "undefined" !== typeof a.onMsoNumberFormat && "undefined" === a.mso.onMsoNumberFormat && (a.mso.onMsoNumberFormat = a.onMsoNumberFormat);
        "undefined" !== typeof a.worksheetName && "undefined" === a.mso.worksheetName && (a.mso.worksheetName = a.worksheetName);
        a.mso.pageOrientation = "l" === a.mso.pageOrientation.substr(0, 1) ? "landscape" : "portrait";
        R = P(v);
        if ("csv" === a.type || "tsv" === a.type || "txt" === a.type) {
            var M = "",
                X = 0;
            F = [];
            n = 0;
            var la = function (b, c, f) {
                b.each(function () {
                    p = "";
                    D(this, c, n, f + b.length, function (b, d, c) {
                        var g = p,
                            k = "";
                        if (null !== b)
                            if (((b = B(b, d, c)), (d = null === b || "" === b ? "" : b.toString()), "tsv" === a.type)) b instanceof Date && b.toLocaleString(), (k = da(d, "\t", " "));
                            else if (b instanceof Date) k = a.csvEnclosure + b.toLocaleString() + a.csvEnclosure;
                            else if (((k = wa(d)), (k = da(k, a.csvEnclosure, a.csvEnclosure + a.csvEnclosure)), 0 <= k.indexOf(a.csvSeparator) || /[\r\n ]/g.test(k))) k = a.csvEnclosure + k + a.csvEnclosure;
                        p = g + (k + ("tsv" === a.type ? "\t" : a.csvSeparator));
                    });
                    p = d.trim(p).substring(0, p.length - 1);
                    0 < p.length && (0 < M.length && (M += "\n"), (M += p));
                    n++;
                });
                return b.length;
            };
            X += la(d(v).find("thead").first().find(a.theadSelector), "th,td", X);
            x(d(v), "tbody").each(function () {
                X += la(x(d(this), a.tbodySelector), "td,th", X);
            });
            a.tfootSelector.length && la(d(v).find("tfoot").first().find(a.tfootSelector), "td,th", X);
            M += "\n";
            if ("string" === a.outputMode) return M;
            if ("base64" === a.outputMode) return J(M);
            if ("window" === a.outputMode) {
                G(!1, "data:text/" + ("csv" === a.type ? "csv" : "plain") + ";charset=utf-8,", M);
                return;
            }
            try {
                var C = new Blob([M], { type: "text/" + ("csv" === a.type ? "csv" : "plain") + ";charset=utf-8" });
                saveAs(C, a.fileName + "." + a.type, "csv" !== a.type || !1 === a.csvUseBOM);
            } catch (b) {
                G(a.fileName + "." + a.type, "data:text/" + ("csv" === a.type ? "csv" : "plain") + ";charset=utf-8," + ("csv" === a.type && a.csvUseBOM ? "\ufeff" : ""), M);
            }
        } else if ("sql" === a.type) {
            n = 0;
            F = [];
            var z = "INSERT INTO `" + a.tableName + "` (";
            r = u(d(v));
            d(r).each(function () {
                D(this, "th,td", n, r.length, function (a, d, f) {
                    z += "'" + B(a, d, f) + "',";
                });
                n++;
                z = d.trim(z).substring(0, z.length - 1);
            });
            z += ") VALUES ";
            t = w(d(v));
            d(t).each(function () {
                p = "";
                D(this, "td,th", n, r.length + t.length, function (a, d, f) {
                    p += "'" + B(a, d, f) + "',";
                });
                3 < p.length && ((z += "(" + p), (z = d.trim(z).substring(0, z.length - 1)), (z += "),"));
                n++;
            });
            z = d.trim(z).substring(0, z.length - 1);
            z += ";";
            if ("string" === a.outputMode) return z;
            if ("base64" === a.outputMode) return J(z);
            try {
                (C = new Blob([z], { type: "text/plain;charset=utf-8" })), saveAs(C, a.fileName + ".sql");
            } catch (b) {
                G(a.fileName + ".sql", "data:application/sql;charset=utf-8,", z);
            }
        } else if ("json" === a.type) {
            var V = [];
            F = [];
            r = u(d(v));
            d(r).each(function () {
                var a = [];
                D(this, "th,td", n, r.length, function (b, d, h) {
                    a.push(B(b, d, h));
                });
                V.push(a);
            });
            var ma = [];
            t = w(d(v));
            d(t).each(function () {
                var a = {},
                    c = 0;
                D(this, "td,th", n, r.length + t.length, function (b, d, g) {
                    V.length ? (a[V[V.length - 1][c]] = B(b, d, g)) : (a[c] = B(b, d, g));
                    c++;
                });
                !1 === d.isEmptyObject(a) && ma.push(a);
                n++;
            });
            l = "";
            l = "head" === a.jsonScope ? JSON.stringify(V) : "data" === a.jsonScope ? JSON.stringify(ma) : JSON.stringify({ header: V, data: ma });
            if ("string" === a.outputMode) return l;
            if ("base64" === a.outputMode) return J(l);
            try {
                (C = new Blob([l], { type: "application/json;charset=utf-8" })), saveAs(C, a.fileName + ".json");
            } catch (b) {
                G(a.fileName + ".json", "data:application/json;charset=utf-8;base64,", l);
            }
        } else if ("xml" === a.type) {
            n = 0;
            F = [];
            var N = '<?xml version="1.0" encoding="utf-8"?>';
            N += "<tabledata><fields>";
            r = u(d(v));
            d(r).each(function () {
                D(this, "th,td", n, r.length, function (a, d, f) {
                    N += "<field>" + B(a, d, f) + "</field>";
                });
                n++;
            });
            N += "</fields><data>";
            var za = 1;
            t = w(d(v));
            d(t).each(function () {
                var a = 1;
                p = "";
                D(this, "td,th", n, r.length + t.length, function (b, d, h) {
                    p += "<column-" + a + ">" + B(b, d, h) + "</column-" + a + ">";
                    a++;
                });
                0 < p.length && "<column-1></column-1>" !== p && ((N += '<row id="' + za + '">' + p + "</row>"), za++);
                n++;
            });
            N += "</data></tabledata>";
            if ("string" === a.outputMode) return N;
            if ("base64" === a.outputMode) return J(N);
            try {
                (C = new Blob([N], { type: "application/xml;charset=utf-8" })), saveAs(C, a.fileName + ".xml");
            } catch (b) {
                G(a.fileName + ".xml", "data:application/xml;charset=utf-8;base64,", N);
            }
        } else if ("excel" === a.type && "xmlss" === a.mso.fileFormat) {
            var na = [],
                E = [];
            d(v)
                .filter(function () {
                    return Q(d(this));
                })
                .each(function () {
                    function b(a, b, c) {
                        var g = [];
                        d(a).each(function () {
                            var b = 0,
                                k = 0;
                            p = "";
                            D(this, "td,th", n, c + a.length, function (a, c, f) {
                                if (null !== a) {
                                    var h = "";
                                    c = B(a, c, f);
                                    f = "String";
                                    if (!1 !== jQuery.isNumeric(c)) f = "Number";
                                    else {
                                        var e = Ha(c);
                                        !1 !== e && ((c = e), (f = "Number"), (h += ' ss:StyleID="pct1"'));
                                    }
                                    "Number" !== f && (c = c.replace(/\n/g, "<br>"));
                                    e = S(a);
                                    a = T(a);
                                    d.each(g, function () {
                                        if (n >= this.s.r && n <= this.e.r && k >= this.s.c && k <= this.e.c) for (var a = 0; a <= this.e.c - this.s.c; ++a) k++, b++;
                                    });
                                    if (a || e) (a = a || 1), (e = e || 1), g.push({ s: { r: n, c: k }, e: { r: n + a - 1, c: k + e - 1 } });
                                    1 < e && ((h += ' ss:MergeAcross="' + (e - 1) + '"'), (k += e - 1));
                                    1 < a && (h += ' ss:MergeDown="' + (a - 1) + '" ss:StyleID="rsp1"');
                                    0 < b && ((h += ' ss:Index="' + (k + 1) + '"'), (b = 0));
                                    p += "<Cell" + h + '><Data ss:Type="' + f + '">' + d("<div />").text(c).html() + "</Data></Cell>\r";
                                    k++;
                                }
                            });
                            0 < p.length && (H += '<Row ss:AutoFitHeight="0">\r' + p + "</Row>\r");
                            n++;
                        });
                        return a.length;
                    }
                    var c = d(this),
                        f = "";
                    "string" === typeof a.mso.worksheetName && a.mso.worksheetName.length ? (f = a.mso.worksheetName + " " + (E.length + 1)) : "undefined" !== typeof a.mso.worksheetName[E.length] && (f = a.mso.worksheetName[E.length]);
                    f.length || (f = c.find("caption").text() || "");
                    f.length || (f = "Table " + (E.length + 1));
                    f = d.trim(f.replace(/[\\\/[\]*:?'"]/g, "").substring(0, 31));
                    E.push(d("<div />").text(f).html());
                    !1 === a.exportHiddenCells && ((I = c.find("tr, th, td").filter(":hidden")), (U = 0 < I.length));
                    n = 0;
                    R = P(this);
                    H = "<Table>\r";
                    var h = b(u(c), "th,td", h);
                    b(w(c), "td,th", h);
                    H += "</Table>\r";
                    na.push(H);
                });
            l = {};
            for (var A = {}, m, O, W = 0, aa = E.length; W < aa; W++)
                (m = E[W]), (O = l[m]), (O = l[m] = null == O ? 1 : O + 1), 2 === O && (E[A[m]] = E[A[m]].substring(0, 29) + "-1"), 1 < l[m] ? (E[W] = E[W].substring(0, 29) + "-" + l[m]) : (A[m] = W);
            l =
                '<?xml version="1.0" encoding="UTF-8"?>\r<?mso-application progid="Excel.Sheet"?>\r<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"\r xmlns:o="urn:schemas-microsoft-com:office:office"\r xmlns:x="urn:schemas-microsoft-com:office:excel"\r xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"\r xmlns:html="http://www.w3.org/TR/REC-html40">\r<DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">\r  <Created>' +
                new Date().toISOString() +
                '</Created>\r</DocumentProperties>\r<OfficeDocumentSettings xmlns="urn:schemas-microsoft-com:office:office">\r  <AllowPNG/>\r</OfficeDocumentSettings>\r<ExcelWorkbook xmlns="urn:schemas-microsoft-com:office:excel">\r  <WindowHeight>9000</WindowHeight>\r  <WindowWidth>13860</WindowWidth>\r  <WindowTopX>0</WindowTopX>\r  <WindowTopY>0</WindowTopY>\r  <ProtectStructure>False</ProtectStructure>\r  <ProtectWindows>False</ProtectWindows>\r</ExcelWorkbook>\r<Styles>\r  <Style ss:ID="Default" ss:Name="Normal">\r    <Alignment ss:Vertical="Bottom"/>\r    <Borders/>\r    <Font/>\r    <Interior/>\r    <NumberFormat/>\r    <Protection/>\r  </Style>\r  <Style ss:ID="rsp1">\r    <Alignment ss:Vertical="Center"/>\r  </Style>\r  <Style ss:ID="pct1">\r    <NumberFormat ss:Format="Percent"/>\r  </Style>\r</Styles>\r';
            for (A = 0; A < na.length; A++)
                (l += '<Worksheet ss:Name="' + E[A] + '" ss:RightToLeft="' + (a.mso.rtl ? "1" : "0") + '">\r' + na[A]),
                    (l = a.mso.rtl ? l + '<WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">\r<DisplayRightToLeft/>\r</WorksheetOptions>\r' : l + '<WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel"/>\r'),
                    (l += "</Worksheet>\r");
            l += "</Workbook>\r";
            if ("string" === a.outputMode) return l;
            if ("base64" === a.outputMode) return J(l);
            try {
                (C = new Blob([l], { type: "application/xml;charset=utf-8" })), saveAs(C, a.fileName + ".xml");
            } catch (b) {
                G(a.fileName + ".xml", "data:application/xml;charset=utf-8;base64,", l);
            }
        } else if ("excel" === a.type && "xlsx" === a.mso.fileFormat) {
            var Aa = [],
                oa = [];
            n = 0;
            t = u(d(v));
            t.push.apply(t, w(d(v)));
            d(t).each(function () {
                var b = [];
                D(this, "th,td", n, t.length, function (c, f, e) {
                    if ("undefined" !== typeof c && null !== c) {
                        e = B(c, f, e);
                        f = S(c);
                        c = T(c);
                        d.each(oa, function () {
                            if (n >= this.s.r && n <= this.e.r && b.length >= this.s.c && b.length <= this.e.c) for (var a = 0; a <= this.e.c - this.s.c; ++a) b.push(null);
                        });
                        if (c || f) (f = f || 1), oa.push({ s: { r: n, c: b.length }, e: { r: n + (c || 1) - 1, c: b.length + f - 1 } });
                        "function" !== typeof a.onCellData && "" !== e && e === +e && (e = +e);
                        b.push("" !== e ? e : null);
                        if (f) for (c = 0; c < f - 1; ++c) b.push(null);
                    }
                });
                Aa.push(b);
                n++;
            });
            l = new ka();
            A = Ja(Aa);
            A["!merges"] = oa;
            XLSX.utils.book_append_sheet(l, A, a.mso.worksheetName);
            l = XLSX.write(l, { type: "binary", bookType: a.mso.fileFormat, bookSST: !1 });
            try {
                (C = new Blob([ya(l)], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=UTF-8" })), saveAs(C, a.fileName + "." + a.mso.fileFormat);
            } catch (b) {
                G(a.fileName + "." + a.mso.fileFormat, "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=UTF-8,", ya(l));
            }
        } else if ("excel" === a.type || "xls" === a.type || "word" === a.type || "doc" === a.type) {
            l = "excel" === a.type || "xls" === a.type ? "excel" : "word";
            A = "excel" === l ? "xls" : "doc";
            m = 'xmlns:x="urn:schemas-microsoft-com:office:' + l + '"';
            var H = "",
                Y = "";
            d(v)
                .filter(function () {
                    return Q(d(this));
                })
                .each(function () {
                    var b = d(this);
                    "" === Y && ((Y = a.mso.worksheetName || b.find("caption").text() || "Table"), (Y = d.trim(Y.replace(/[\\\/[\]*:?'"]/g, "").substring(0, 31))));
                    !1 === a.exportHiddenCells && ((I = b.find("tr, th, td").filter(":hidden")), (U = 0 < I.length));
                    n = 0;
                    F = [];
                    R = P(this);
                    H += "<table><thead>";
                    r = u(b);
                    d(r).each(function () {
                        p = "";
                        D(this, "th,td", n, r.length, function (b, e, h) {
                            if (null !== b) {
                                var c = "";
                                p += "<th";
                                for (var k in a.mso.styles)
                                    if (a.mso.styles.hasOwnProperty(k)) {
                                        var f = d(b).css(a.mso.styles[k]);
                                        "" !== f && "0px none rgb(0, 0, 0)" !== f && "rgba(0, 0, 0, 0)" !== f && ((c += "" === c ? 'style="' : ";"), (c += a.mso.styles[k] + ":" + f));
                                    }
                                "" !== c && (p += " " + c + '"');
                                c = S(b);
                                0 < c && (p += ' colspan="' + c + '"');
                                c = T(b);
                                0 < c && (p += ' rowspan="' + c + '"');
                                p += ">" + B(b, e, h) + "</th>";
                            }
                        });
                        0 < p.length && (H += "<tr>" + p + "</tr>");
                        n++;
                    });
                    H += "</thead><tbody>";
                    t = w(b);
                    d(t).each(function () {
                        var b = d(this);
                        p = "";
                        D(this, "td,th", n, r.length + t.length, function (c, e, g) {
                            if (null !== c) {
                                var k = B(c, e, g),
                                    f = "",
                                    h = d(c).data("tableexport-msonumberformat");
                                "undefined" === typeof h && "function" === typeof a.mso.onMsoNumberFormat && (h = a.mso.onMsoNumberFormat(c, e, g));
                                "undefined" !== typeof h && "" !== h && (f = "style=\"mso-number-format:'" + h + "'");
                                for (var l in a.mso.styles)
                                    a.mso.styles.hasOwnProperty(l) &&
                                        ((h = d(c).css(a.mso.styles[l])),
                                        "" === h && (h = b.css(a.mso.styles[l])),
                                        "" !== h && "0px none rgb(0, 0, 0)" !== h && "rgba(0, 0, 0, 0)" !== h && ((f += "" === f ? 'style="' : ";"), (f += a.mso.styles[l] + ":" + h)));
                                p += "<td";
                                "" !== f && (p += " " + f + '"');
                                e = S(c);
                                0 < e && (p += ' colspan="' + e + '"');
                                c = T(c);
                                0 < c && (p += ' rowspan="' + c + '"');
                                "string" === typeof k && "" !== k && ((k = wa(k)), (k = k.replace(/\n/g, "<br>")));
                                p += ">" + k + "</td>";
                            }
                        });
                        0 < p.length && (H += "<tr>" + p + "</tr>");
                        n++;
                    });
                    a.displayTableName && (H += "<tr><td></td></tr><tr><td></td></tr><tr><td>" + B(d("<p>" + a.tableName + "</p>")) + "</td></tr>");
                    H += "</tbody></table>";
                });
            m = '<html xmlns:o="urn:schemas-microsoft-com:office:office" ' + m + ' xmlns="http://www.w3.org/TR/REC-html40">' + ('<meta http-equiv="content-type" content="application/vnd.ms-' + l + '; charset=UTF-8">') + "<head>";
            "excel" === l &&
                ((m += "\x3c!--[if gte mso 9]>"),
                (m += "<xml>"),
                (m += "<x:ExcelWorkbook>"),
                (m += "<x:ExcelWorksheets>"),
                (m += "<x:ExcelWorksheet>"),
                (m += "<x:Name>"),
                (m += Y),
                (m += "</x:Name>"),
                (m += "<x:WorksheetOptions>"),
                (m += "<x:DisplayGridlines/>"),
                a.mso.rtl && (m += "<x:DisplayRightToLeft/>"),
                (m += "</x:WorksheetOptions>"),
                (m += "</x:ExcelWorksheet>"),
                (m += "</x:ExcelWorksheets>"),
                (m += "</x:ExcelWorkbook>"),
                (m += "</xml>"),
                (m += "<![endif]--\x3e"));
            m += "<style>";
            m += "@page { size:" + a.mso.pageOrientation + "; mso-page-orientation:" + a.mso.pageOrientation + "; }";
            m += "@page Section1 {size:" + L[a.mso.pageFormat][0] + "pt " + L[a.mso.pageFormat][1] + "pt";
            m += "; margin:1.0in 1.25in 1.0in 1.25in;mso-header-margin:.5in;mso-footer-margin:.5in;mso-paper-source:0;}";
            m += "div.Section1 {page:Section1;}";
            m += "@page Section2 {size:" + L[a.mso.pageFormat][1] + "pt " + L[a.mso.pageFormat][0] + "pt";
            m += ";mso-page-orientation:" + a.mso.pageOrientation + ";margin:1.25in 1.0in 1.25in 1.0in;mso-header-margin:.5in;mso-footer-margin:.5in;mso-paper-source:0;}";
            m += "div.Section2 {page:Section2;}";
            m += "br {mso-data-placement:same-cell;}";
            m += "</style>";
            m += "</head>";
            m += "<body>";
            m += '<div class="Section' + ("landscape" === a.mso.pageOrientation ? "2" : "1") + '">';
            m += H;
            m += "</div>";
            m += "</body>";
            m += "</html>";
            if ("string" === a.outputMode) return m;
            if ("base64" === a.outputMode) return J(m);
            try {
                (C = new Blob([m], { type: "application/vnd.ms-" + a.type })), saveAs(C, a.fileName + "." + A);
            } catch (b) {
                G(a.fileName + "." + A, "data:application/vnd.ms-" + l + ";base64,", m);
            }
        } else if ("png" === a.type)
            html2canvas(d(v)[0]).then(function (b) {
                b = b.toDataURL();
                for (var d = atob(b.substring(22)), e = new ArrayBuffer(d.length), h = new Uint8Array(e), g = 0; g < d.length; g++) h[g] = d.charCodeAt(g);
                if ("string" === a.outputMode) return d;
                if ("base64" === a.outputMode) return J(b);
                if ("window" === a.outputMode) window.open(b);
                else
                    try {
                        (C = new Blob([e], { type: "image/png" })), saveAs(C, a.fileName + ".png");
                    } catch (k) {
                        G(a.fileName + ".png", "data:image/png,", C);
                    }
            });
        else if ("pdf" === a.type)
            if (!0 === a.pdfmake.enabled) {
                l = [];
                var Ba = [];
                n = 0;
                F = [];
                A = function (a, c, e) {
                    var b = 0;
                    d(a).each(function () {
                        var a = [];
                        D(this, c, n, e, function (b, d, c) {
                            if ("undefined" !== typeof b && null !== b) {
                                var g = S(b),
                                    e = T(b);
                                b = B(b, d, c) || " ";
                                1 < g || 1 < e ? a.push({ colSpan: g || 1, rowSpan: e || 1, text: b }) : a.push(b);
                            } else a.push(" ");
                        });
                        a.length && Ba.push(a);
                        b < a.length && (b = a.length);
                        n++;
                    });
                    return b;
                };
                r = u(d(this));
                m = A(r, "th,td", r.length);
                for (O = l.length; O < m; O++) l.push("*");
                t = w(d(this));
                A(t, "th,td", r.length + t.length);
                l = { content: [{ table: { headerRows: r.length, widths: l, body: Ba } }] };
                d.extend(!0, l, a.pdfmake.docDefinition);
                pdfMake.fonts = { Roboto: { normal: "Roboto-Regular.ttf", bold: "Roboto-Medium.ttf", italics: "Roboto-Italic.ttf", bolditalics: "Roboto-MediumItalic.ttf" } };
                d.extend(!0, pdfMake.fonts, a.pdfmake.fonts);
                pdfMake.createPdf(l).getBuffer(function (b) {
                    try {
                        var d = new Blob([b], { type: "application/pdf" });
                        saveAs(d, a.fileName + ".pdf");
                    } catch (f) {
                        G(a.fileName + ".pdf", "application/pdf", b);
                    }
                });
            } else if (!1 === a.jspdf.autotable) {
                l = { dim: { w: ca(d(v).first().get(0), "width", "mm"), h: ca(d(v).first().get(0), "height", "mm") }, pagesplit: !1 };
                var Ca = new jsPDF(a.jspdf.orientation, a.jspdf.unit, a.jspdf.format);
                Ca.addHTML(d(v).first(), a.jspdf.margins.left, a.jspdf.margins.top, l, function () {
                    qa(Ca, !1);
                });
            } else {
                var e = a.jspdf.autotable.tableExport;
                if ("string" === typeof a.jspdf.format && "bestfit" === a.jspdf.format.toLowerCase()) {
                    var fa = "",
                        Z = "",
                        Da = 0;
                    d(v).each(function () {
                        if (Q(d(this))) {
                            var a = ca(d(this).get(0), "width", "pt");
                            if (a > Da) {
                                a > L.a0[0] && ((fa = "a0"), (Z = "l"));
                                for (var c in L) L.hasOwnProperty(c) && L[c][1] > a && ((fa = c), (Z = "l"), L[c][0] > a && (Z = "p"));
                                Da = a;
                            }
                        }
                    });
                    a.jspdf.format = "" === fa ? "a4" : fa;
                    a.jspdf.orientation = "" === Z ? "w" : Z;
                }
                if (null == e.doc && ((e.doc = new jsPDF(a.jspdf.orientation, a.jspdf.unit, a.jspdf.format)), (e.wScaleFactor = 1), (e.hScaleFactor = 1), "function" === typeof a.jspdf.onDocCreated)) a.jspdf.onDocCreated(e.doc);
                !0 === e.outputImages && (e.images = {});
                "undefined" !== typeof e.images &&
                    (d(v)
                        .filter(function () {
                            return Q(d(this));
                        })
                        .each(function () {
                            var b = 0;
                            F = [];
                            !1 === a.exportHiddenCells && ((I = d(this).find("tr, th, td").filter(":hidden")), (U = 0 < I.length));
                            r = u(d(this));
                            t = w(d(this));
                            d(t).each(function () {
                                D(this, "td,th", r.length + b, r.length + t.length, function (a) {
                                    sa(a, d(a).children(), e);
                                });
                                b++;
                            });
                        }),
                    (r = []),
                    (t = []));
                Ga(e, function () {
                    d(v)
                        .filter(function () {
                            return Q(d(this));
                        })
                        .each(function () {
                            var b;
                            n = 0;
                            F = [];
                            !1 === a.exportHiddenCells && ((I = d(this).find("tr, th, td").filter(":hidden")), (U = 0 < I.length));
                            R = P(this);
                            e.columns = [];
                            e.rows = [];
                            e.teCells = {};
                            if ("function" === typeof e.onTable && !1 === e.onTable(d(this), a)) return !0;
                            a.jspdf.autotable.tableExport = null;
                            var c = d.extend(!0, {}, a.jspdf.autotable);
                            a.jspdf.autotable.tableExport = e;
                            c.margin = {};
                            d.extend(!0, c.margin, a.jspdf.margins);
                            c.tableExport = e;
                            "function" !== typeof c.beforePageContent &&
                                (c.beforePageContent = function (a) {
                                    if (1 === a.pageCount) {
                                        var b = a.table.rows.concat(a.table.headerRow);
                                        d.each(b, function () {
                                            0 < this.height && ((this.height += ((2 - 1.15) / 2) * this.styles.fontSize), (a.table.height += ((2 - 1.15) / 2) * this.styles.fontSize));
                                        });
                                    }
                                });
                            "function" !== typeof c.createdHeaderCell &&
                                (c.createdHeaderCell = function (a, b) {
                                    a.styles = d.extend({}, b.row.styles);
                                    if ("undefined" !== typeof e.columns[b.column.dataKey]) {
                                        var g = e.columns[b.column.dataKey];
                                        if ("undefined" !== typeof g.rect) {
                                            a.contentWidth = g.rect.width;
                                            if ("undefined" === typeof e.heightRatio || 0 === e.heightRatio) {
                                                var k = b.row.raw[b.column.dataKey].rowspan ? b.row.raw[b.column.dataKey].rect.height / b.row.raw[b.column.dataKey].rowspan : b.row.raw[b.column.dataKey].rect.height;
                                                e.heightRatio = a.styles.rowHeight / k;
                                            }
                                            k = b.row.raw[b.column.dataKey].rect.height * e.heightRatio;
                                            k > a.styles.rowHeight && (a.styles.rowHeight = k);
                                        }
                                        a.styles.halign = "inherit" === c.headerStyles.halign ? "center" : c.headerStyles.halign;
                                        a.styles.valign = c.headerStyles.valign;
                                        "undefined" !== typeof g.style &&
                                            !0 !== g.style.hidden &&
                                            ("inherit" === c.headerStyles.halign && (a.styles.halign = g.style.align),
                                            "inherit" === c.styles.fillColor && (a.styles.fillColor = g.style.bcolor),
                                            "inherit" === c.styles.textColor && (a.styles.textColor = g.style.color),
                                            "inherit" === c.styles.fontStyle && (a.styles.fontStyle = g.style.fstyle));
                                    }
                                });
                            "function" !== typeof c.createdCell &&
                                (c.createdCell = function (a, b) {
                                    b = e.teCells[b.row.index + ":" + b.column.dataKey];
                                    a.styles.halign = "inherit" === c.styles.halign ? "center" : c.styles.halign;
                                    a.styles.valign = c.styles.valign;
                                    "undefined" !== typeof b &&
                                        "undefined" !== typeof b.style &&
                                        !0 !== b.style.hidden &&
                                        ("inherit" === c.styles.halign && (a.styles.halign = b.style.align),
                                        "inherit" === c.styles.fillColor && (a.styles.fillColor = b.style.bcolor),
                                        "inherit" === c.styles.textColor && (a.styles.textColor = b.style.color),
                                        "inherit" === c.styles.fontStyle && (a.styles.fontStyle = b.style.fstyle));
                                });
                            "function" !== typeof c.drawHeaderCell &&
                                (c.drawHeaderCell = function (a, b) {
                                    var d = e.columns[b.column.dataKey];
                                    return (!0 !== d.style.hasOwnProperty("hidden") || !0 !== d.style.hidden) && 0 <= d.rowIndex ? ra(a, b, d) : !1;
                                });
                            "function" !== typeof c.drawCell &&
                                (c.drawCell = function (a, b) {
                                    var c = e.teCells[b.row.index + ":" + b.column.dataKey];
                                    if (!0 !== ("undefined" !== typeof c && c.isCanvas))
                                        ra(a, b, c) &&
                                            (e.doc.rect(a.x, a.y, a.width, a.height, a.styles.fillStyle),
                                            "undefined" !== typeof c && "undefined" !== typeof c.elements && c.elements.length
                                                ? ((b = a.height / c.rect.height),
                                                  b > e.hScaleFactor && (e.hScaleFactor = b),
                                                  (e.wScaleFactor = a.width / c.rect.width),
                                                  (b = a.textPos.y),
                                                  ua(a, c.elements, e),
                                                  (a.textPos.y = b),
                                                  va(a, c.elements, e))
                                                : va(a, {}, e));
                                    else {
                                        c = c.elements[0];
                                        var g = d(c).attr("data-tableexport-canvas"),
                                            f = c.getBoundingClientRect();
                                        a.width = f.width * e.wScaleFactor;
                                        a.height = f.height * e.hScaleFactor;
                                        b.row.height = a.height;
                                        pa(a, c, g, e);
                                    }
                                    return !1;
                                });
                            e.headerrows = [];
                            r = u(d(this));
                            d(r).each(function () {
                                b = 0;
                                e.headerrows[n] = [];
                                D(this, "th,td", n, r.length, function (a, d, c) {
                                    var g = xa(a);
                                    g.title = B(a, d, c);
                                    g.key = b++;
                                    g.rowIndex = n;
                                    e.headerrows[n].push(g);
                                });
                                n++;
                            });
                            if (0 < n)
                                for (var f = n - 1; 0 <= f; )
                                    d.each(e.headerrows[f], function () {
                                        var a = this;
                                        0 < f && null === this.rect && (a = e.headerrows[f - 1][this.key]);
                                        null !== a && 0 <= a.rowIndex && (!0 !== a.style.hasOwnProperty("hidden") || !0 !== a.style.hidden) && e.columns.push(a);
                                    }),
                                        (f = 0 < e.columns.length ? -1 : f - 1);
                            var h = 0;
                            t = [];
                            t = w(d(this));
                            d(t).each(function () {
                                var a = [];
                                b = 0;
                                D(this, "td,th", n, r.length + t.length, function (c, f, g) {
                                    if ("undefined" === typeof e.columns[b]) {
                                        var k = { title: "", key: b, style: { hidden: !0 } };
                                        e.columns.push(k);
                                    }
                                    "undefined" !== typeof c && null !== c
                                        ? ((k = xa(c)), (k.isCanvas = c.hasAttribute("data-tableexport-canvas")), (k.elements = k.isCanvas ? d(c) : d(c).children()))
                                        : ((k = d.extend(!0, {}, e.teCells[h + ":" + (b - 1)])), (k.colspan = -1));
                                    e.teCells[h + ":" + b++] = k;
                                    a.push(B(c, f, g));
                                });
                                a.length && (e.rows.push(a), h++);
                                n++;
                            });
                            if ("function" === typeof e.onBeforeAutotable) e.onBeforeAutotable(d(this), e.columns, e.rows, c);
                            e.doc.autoTable(e.columns, e.rows, c);
                            if ("function" === typeof e.onAfterAutotable) e.onAfterAutotable(d(this), c);
                            a.jspdf.autotable.startY = e.doc.autoTableEndPosY() + c.margin.top;
                        });
                    qa(e.doc, "undefined" !== typeof e.images && !1 === jQuery.isEmptyObject(e.images));
                    "undefined" !== typeof e.headerrows && (e.headerrows.length = 0);
                    "undefined" !== typeof e.columns && (e.columns.length = 0);
                    "undefined" !== typeof e.rows && (e.rows.length = 0);
                    delete e.doc;
                    e.doc = null;
                });
            }
        return this;
    };
})(jQuery);
