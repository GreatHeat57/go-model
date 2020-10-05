! function(t, e) {
    "use strict";
    "object" == typeof module && "object" == typeof module.exports ? module.exports = t.document ? e(t, !0) : function(t) {
        if (!t.document) throw new Error("jQuery requires a window with a document");
        return e(t)
    } : e(t)
}("undefined" != typeof window ? window : this, function(t, e) {
    "use strict";

    function n(t, e, n) {
        var i, r = (e = e || st).createElement("script");
        if (r.text = t, n)
            for (i in xt) n[i] && (r[i] = n[i]);
        e.head.appendChild(r).parentNode.removeChild(r)
    }

    function i(t) {
        return null == t ? t + "" : "object" == typeof t || "function" == typeof t ? ht[dt.call(t)] || "object" : typeof t
    }

    function r(t) {
        var e = !!t && "length" in t && t.length,
            n = i(t);
        return !yt(t) && !wt(t) && ("array" === n || 0 === e || "number" == typeof e && e > 0 && e - 1 in t)
    }

    function o(t, e) {
        return t.nodeName && t.nodeName.toLowerCase() === e.toLowerCase()
    }

    function s(t, e, n) {
        return yt(e) ? bt.grep(t, function(t, i) {
            return !!e.call(t, i, t) !== n
        }) : e.nodeType ? bt.grep(t, function(t) {
            return t === e !== n
        }) : "string" != typeof e ? bt.grep(t, function(t) {
            return pt.call(e, t) > -1 !== n
        }) : bt.filter(e, t, n)
    }

    function a(t, e) {
        for (;
            (t = t[e]) && 1 !== t.nodeType;);
        return t
    }

    function l(t) {
        var e = {};
        return bt.each(t.match($t) || [], function(t, n) {
            e[n] = !0
        }), e
    }

    function u(t) {
        return t
    }

    function c(t) {
        throw t
    }

    function p(t, e, n, i) {
        var r;
        try {
            t && yt(r = t.promise) ? r.call(t).done(e).fail(n) : t && yt(r = t.then) ? r.call(t, e, n) : e.apply(void 0, [t].slice(i))
        } catch (t) {
            n.apply(void 0, [t])
        }
    }

    function h() {
        st.removeEventListener("DOMContentLoaded", h), t.removeEventListener("load", h), bt.ready()
    }

    function d(t, e) {
        return e.toUpperCase()
    }

    function f(t) {
        return t.replace(Nt, "ms-").replace(Lt, d)
    }

    function g() {
        this.expando = bt.expando + g.uid++
    }

    function m(t) {
        return "true" === t || "false" !== t && ("null" === t ? null : t === +t + "" ? +t : Bt.test(t) ? JSON.parse(t) : t)
    }

    function v(t, e, n) {
        var i;
        if (void 0 === n && 1 === t.nodeType)
            if (i = "data-" + e.replace(Rt, "-$&").toLowerCase(), "string" == typeof(n = t.getAttribute(i))) {
                try {
                    n = m(n)
                } catch (t) {}
                qt.set(t, e, n)
            } else n = void 0;
        return n
    }

    function y(t, e, n, i) {
        var r, o, s = 20,
            a = i ? function() {
                return i.cur()
            } : function() {
                return bt.css(t, e, "")
            },
            l = a(),
            u = n && n[3] || (bt.cssNumber[e] ? "" : "px"),
            c = (bt.cssNumber[e] || "px" !== u && +l) && Ft.exec(bt.css(t, e));
        if (c && c[3] !== u) {
            for (l /= 2, u = u || c[3], c = +l || 1; s--;) bt.style(t, e, c + u), (1 - o) * (1 - (o = a() / l || .5)) <= 0 && (s = 0), c /= o;
            c *= 2, bt.style(t, e, c + u), n = n || []
        }
        return n && (c = +c || +l || 0, r = n[1] ? c + (n[1] + 1) * n[2] : +n[2], i && (i.unit = u, i.start = c, i.end = r)), r
    }

    function w(t) {
        var e, n = t.ownerDocument,
            i = t.nodeName,
            r = Qt[i];
        return r || (e = n.body.appendChild(n.createElement(i)), r = bt.css(e, "display"), e.parentNode.removeChild(e), "none" === r && (r = "block"), Qt[i] = r, r)
    }

    function x(t, e) {
        for (var n, i, r = [], o = 0, s = t.length; o < s; o++)(i = t[o]).style && (n = i.style.display, e ? ("none" === n && (r[o] = Mt.get(i, "display") || null, r[o] || (i.style.display = "")), "" === i.style.display && Ut(i) && (r[o] = w(i))) : "none" !== n && (r[o] = "none", Mt.set(i, "display", n)));
        for (o = 0; o < s; o++) null != r[o] && (t[o].style.display = r[o]);
        return t
    }

    function b(t, e) {
        var n;
        return n = void 0 !== t.getElementsByTagName ? t.getElementsByTagName(e || "*") : void 0 !== t.querySelectorAll ? t.querySelectorAll(e || "*") : [], void 0 === e || e && o(t, e) ? bt.merge([t], n) : n
    }

    function _(t, e) {
        for (var n = 0, i = t.length; n < i; n++) Mt.set(t[n], "globalEval", !e || Mt.get(e[n], "globalEval"))
    }

    function C(t, e, n, r, o) {
        for (var s, a, l, u, c, p, h = e.createDocumentFragment(), d = [], f = 0, g = t.length; f < g; f++)
            if ((s = t[f]) || 0 === s)
                if ("object" === i(s)) bt.merge(d, s.nodeType ? [s] : s);
                else if (Jt.test(s)) {
            for (a = a || h.appendChild(e.createElement("div")), l = (Zt.exec(s) || ["", ""])[1].toLowerCase(), u = Kt[l] || Kt._default, a.innerHTML = u[1] + bt.htmlPrefilter(s) + u[2], p = u[0]; p--;) a = a.lastChild;
            bt.merge(d, a.childNodes), (a = h.firstChild).textContent = ""
        } else d.push(e.createTextNode(s));
        for (h.textContent = "", f = 0; s = d[f++];)
            if (r && bt.inArray(s, r) > -1) o && o.push(s);
            else if (c = bt.contains(s.ownerDocument, s), a = b(h.appendChild(s), "script"), c && _(a), n)
            for (p = 0; s = a[p++];) Gt.test(s.type || "") && n.push(s);
        return h
    }

    function T() {
        return !0
    }

    function E() {
        return !1
    }

    function k() {
        try {
            return st.activeElement
        } catch (t) {}
    }

    function S(t, e, n, i, r, o) {
        var s, a;
        if ("object" == typeof e) {
            "string" != typeof n && (i = i || n, n = void 0);
            for (a in e) S(t, a, n, i, e[a], o);
            return t
        }
        if (null == i && null == r ? (r = n, i = n = void 0) : null == r && ("string" == typeof n ? (r = i, i = void 0) : (r = i, i = n, n = void 0)), !1 === r) r = E;
        else if (!r) return t;
        return 1 === o && (s = r, (r = function(t) {
            return bt().off(t), s.apply(this, arguments)
        }).guid = s.guid || (s.guid = bt.guid++)), t.each(function() {
            bt.event.add(this, e, r, i, n)
        })
    }

    function A(t, e) {
        return o(t, "table") && o(11 !== e.nodeType ? e : e.firstChild, "tr") ? bt(t).children("tbody")[0] || t : t
    }

    function j(t) {
        return t.type = (null !== t.getAttribute("type")) + "/" + t.type, t
    }

    function D(t) {
        return "true/" === (t.type || "").slice(0, 5) ? t.type = t.type.slice(5) : t.removeAttribute("type"), t
    }

    function O(t, e) {
        var n, i, r, o, s, a, l, u;
        if (1 === e.nodeType) {
            if (Mt.hasData(t) && (o = Mt.access(t), s = Mt.set(e, o), u = o.events)) {
                delete s.handle, s.events = {};
                for (r in u)
                    for (n = 0, i = u[r].length; n < i; n++) bt.event.add(e, r, u[r][n])
            }
            qt.hasData(t) && (a = qt.access(t), l = bt.extend({}, a), qt.set(e, l))
        }
    }

    function $(t, e) {
        var n = e.nodeName.toLowerCase();
        "input" === n && Vt.test(t.type) ? e.checked = t.checked : "input" !== n && "textarea" !== n || (e.defaultValue = t.defaultValue)
    }

    function z(t, e, i, r) {
        e = ut.apply([], e);
        var o, s, a, l, u, c, p = 0,
            h = t.length,
            d = h - 1,
            f = e[0],
            g = yt(f);
        if (g || h > 1 && "string" == typeof f && !vt.checkClone && se.test(f)) return t.each(function(n) {
            var o = t.eq(n);
            g && (e[0] = f.call(this, n, o.html())), z(o, e, i, r)
        });
        if (h && (o = C(e, t[0].ownerDocument, !1, t, r), s = o.firstChild, 1 === o.childNodes.length && (o = s), s || r)) {
            for (l = (a = bt.map(b(o, "script"), j)).length; p < h; p++) u = o, p !== d && (u = bt.clone(u, !0, !0), l && bt.merge(a, b(u, "script"))), i.call(t[p], u, p);
            if (l)
                for (c = a[a.length - 1].ownerDocument, bt.map(a, D), p = 0; p < l; p++) u = a[p], Gt.test(u.type || "") && !Mt.access(u, "globalEval") && bt.contains(c, u) && (u.src && "module" !== (u.type || "").toLowerCase() ? bt._evalUrl && bt._evalUrl(u.src) : n(u.textContent.replace(ae, ""), c, u))
        }
        return t
    }

    function I(t, e, n) {
        for (var i, r = e ? bt.filter(e, t) : t, o = 0; null != (i = r[o]); o++) n || 1 !== i.nodeType || bt.cleanData(b(i)), i.parentNode && (n && bt.contains(i.ownerDocument, i) && _(b(i, "script")), i.parentNode.removeChild(i));
        return t
    }

    function P(t, e, n) {
        var i, r, o, s, a = t.style;
        return (n = n || ue(t)) && ("" !== (s = n.getPropertyValue(e) || n[e]) || bt.contains(t.ownerDocument, t) || (s = bt.style(t, e)), !vt.pixelBoxStyles() && le.test(s) && ce.test(e) && (i = a.width, r = a.minWidth, o = a.maxWidth, a.minWidth = a.maxWidth = a.width = s, s = n.width, a.width = i, a.minWidth = r, a.maxWidth = o)), void 0 !== s ? s + "" : s
    }

    function N(t, e) {
        return {
            get: function() {
                if (!t()) return (this.get = e).apply(this, arguments);
                delete this.get
            }
        }
    }

    function L(t) {
        if (t in me) return t;
        for (var e = t[0].toUpperCase() + t.slice(1), n = ge.length; n--;)
            if ((t = ge[n] + e) in me) return t
    }

    function H(t) {
        var e = bt.cssProps[t];
        return e || (e = bt.cssProps[t] = L(t) || t), e
    }

    function M(t, e, n) {
        var i = Ft.exec(e);
        return i ? Math.max(0, i[2] - (n || 0)) + (i[3] || "px") : e
    }

    function q(t, e, n, i, r, o) {
        var s = "width" === e ? 1 : 0,
            a = 0,
            l = 0;
        if (n === (i ? "border" : "content")) return 0;
        for (; s < 4; s += 2) "margin" === n && (l += bt.css(t, n + Xt[s], !0, r)), i ? ("content" === n && (l -= bt.css(t, "padding" + Xt[s], !0, r)), "margin" !== n && (l -= bt.css(t, "border" + Xt[s] + "Width", !0, r))) : (l += bt.css(t, "padding" + Xt[s], !0, r), "padding" !== n ? l += bt.css(t, "border" + Xt[s] + "Width", !0, r) : a += bt.css(t, "border" + Xt[s] + "Width", !0, r));
        return !i && o >= 0 && (l += Math.max(0, Math.ceil(t["offset" + e[0].toUpperCase() + e.slice(1)] - o - l - a - .5))), l
    }

    function B(t, e, n) {
        var i = ue(t),
            r = P(t, e, i),
            o = "border-box" === bt.css(t, "boxSizing", !1, i),
            s = o;
        if (le.test(r)) {
            if (!n) return r;
            r = "auto"
        }
        return s = s && (vt.boxSizingReliable() || r === t.style[e]), ("auto" === r || !parseFloat(r) && "inline" === bt.css(t, "display", !1, i)) && (r = t["offset" + e[0].toUpperCase() + e.slice(1)], s = !0), (r = parseFloat(r) || 0) + q(t, e, n || (o ? "border" : "content"), s, i, r) + "px"
    }

    function R(t, e, n, i, r) {
        return new R.prototype.init(t, e, n, i, r)
    }

    function W() {
        ye && (!1 === st.hidden && t.requestAnimationFrame ? t.requestAnimationFrame(W) : t.setTimeout(W, bt.fx.interval), bt.fx.tick())
    }

    function F() {
        return t.setTimeout(function() {
            ve = void 0
        }), ve = Date.now()
    }

    function X(t, e) {
        var n, i = 0,
            r = {
                height: t
            };
        for (e = e ? 1 : 0; i < 4; i += 2 - e) r["margin" + (n = Xt[i])] = r["padding" + n] = t;
        return e && (r.opacity = r.width = t), r
    }

    function U(t, e, n) {
        for (var i, r = (V.tweeners[e] || []).concat(V.tweeners["*"]), o = 0, s = r.length; o < s; o++)
            if (i = r[o].call(n, e, t)) return i
    }

    function Y(t, e, n) {
        var i, r, o, s, a, l, u, c, p = "width" in e || "height" in e,
            h = this,
            d = {},
            f = t.style,
            g = t.nodeType && Ut(t),
            m = Mt.get(t, "fxshow");
        n.queue || (null == (s = bt._queueHooks(t, "fx")).unqueued && (s.unqueued = 0, a = s.empty.fire, s.empty.fire = function() {
            s.unqueued || a()
        }), s.unqueued++, h.always(function() {
            h.always(function() {
                s.unqueued--, bt.queue(t, "fx").length || s.empty.fire()
            })
        }));
        for (i in e)
            if (r = e[i], we.test(r)) {
                if (delete e[i], o = o || "toggle" === r, r === (g ? "hide" : "show")) {
                    if ("show" !== r || !m || void 0 === m[i]) continue;
                    g = !0
                }
                d[i] = m && m[i] || bt.style(t, i)
            } if ((l = !bt.isEmptyObject(e)) || !bt.isEmptyObject(d)) {
            p && 1 === t.nodeType && (n.overflow = [f.overflow, f.overflowX, f.overflowY], null == (u = m && m.display) && (u = Mt.get(t, "display")), "none" === (c = bt.css(t, "display")) && (u ? c = u : (x([t], !0), u = t.style.display || u, c = bt.css(t, "display"), x([t]))), ("inline" === c || "inline-block" === c && null != u) && "none" === bt.css(t, "float") && (l || (h.done(function() {
                f.display = u
            }), null == u && (c = f.display, u = "none" === c ? "" : c)), f.display = "inline-block")), n.overflow && (f.overflow = "hidden", h.always(function() {
                f.overflow = n.overflow[0], f.overflowX = n.overflow[1], f.overflowY = n.overflow[2]
            })), l = !1;
            for (i in d) l || (m ? "hidden" in m && (g = m.hidden) : m = Mt.access(t, "fxshow", {
                display: u
            }), o && (m.hidden = !g), g && x([t], !0), h.done(function() {
                g || x([t]), Mt.remove(t, "fxshow");
                for (i in d) bt.style(t, i, d[i])
            })), l = U(g ? m[i] : 0, i, h), i in m || (m[i] = l.start, g && (l.end = l.start, l.start = 0))
        }
    }

    function Q(t, e) {
        var n, i, r, o, s;
        for (n in t)
            if (i = f(n), r = e[i], o = t[n], Array.isArray(o) && (r = o[1], o = t[n] = o[0]), n !== i && (t[i] = o, delete t[n]), (s = bt.cssHooks[i]) && "expand" in s) {
                o = s.expand(o), delete t[i];
                for (n in o) n in t || (t[n] = o[n], e[n] = r)
            } else e[i] = r
    }

    function V(t, e, n) {
        var i, r, o = 0,
            s = V.prefilters.length,
            a = bt.Deferred().always(function() {
                delete l.elem
            }),
            l = function() {
                if (r) return !1;
                for (var e = ve || F(), n = Math.max(0, u.startTime + u.duration - e), i = 1 - (n / u.duration || 0), o = 0, s = u.tweens.length; o < s; o++) u.tweens[o].run(i);
                return a.notifyWith(t, [u, i, n]), i < 1 && s ? n : (s || a.notifyWith(t, [u, 1, 0]), a.resolveWith(t, [u]), !1)
            },
            u = a.promise({
                elem: t,
                props: bt.extend({}, e),
                opts: bt.extend(!0, {
                    specialEasing: {},
                    easing: bt.easing._default
                }, n),
                originalProperties: e,
                originalOptions: n,
                startTime: ve || F(),
                duration: n.duration,
                tweens: [],
                createTween: function(e, n) {
                    var i = bt.Tween(t, u.opts, e, n, u.opts.specialEasing[e] || u.opts.easing);
                    return u.tweens.push(i), i
                },
                stop: function(e) {
                    var n = 0,
                        i = e ? u.tweens.length : 0;
                    if (r) return this;
                    for (r = !0; n < i; n++) u.tweens[n].run(1);
                    return e ? (a.notifyWith(t, [u, 1, 0]), a.resolveWith(t, [u, e])) : a.rejectWith(t, [u, e]), this
                }
            }),
            c = u.props;
        for (Q(c, u.opts.specialEasing); o < s; o++)
            if (i = V.prefilters[o].call(u, t, c, u.opts)) return yt(i.stop) && (bt._queueHooks(u.elem, u.opts.queue).stop = i.stop.bind(i)), i;
        return bt.map(c, U, u), yt(u.opts.start) && u.opts.start.call(t, u), u.progress(u.opts.progress).done(u.opts.done, u.opts.complete).fail(u.opts.fail).always(u.opts.always), bt.fx.timer(bt.extend(l, {
            elem: t,
            anim: u,
            queue: u.opts.queue
        })), u
    }

    function Z(t) {
        return (t.match($t) || []).join(" ")
    }

    function G(t) {
        return t.getAttribute && t.getAttribute("class") || ""
    }

    function K(t) {
        return Array.isArray(t) ? t : "string" == typeof t ? t.match($t) || [] : []
    }

    function J(t, e, n, r) {
        var o;
        if (Array.isArray(e)) bt.each(e, function(e, i) {
            n || Oe.test(t) ? r(t, i) : J(t + "[" + ("object" == typeof i && null != i ? e : "") + "]", i, n, r)
        });
        else if (n || "object" !== i(e)) r(t, e);
        else
            for (o in e) J(t + "[" + o + "]", e[o], n, r)
    }

    function tt(t) {
        return function(e, n) {
            "string" != typeof e && (n = e, e = "*");
            var i, r = 0,
                o = e.toLowerCase().match($t) || [];
            if (yt(n))
                for (; i = o[r++];) "+" === i[0] ? (i = i.slice(1) || "*", (t[i] = t[i] || []).unshift(n)) : (t[i] = t[i] || []).push(n)
        }
    }

    function et(t, e, n, i) {
        function r(a) {
            var l;
            return o[a] = !0, bt.each(t[a] || [], function(t, a) {
                var u = a(e, n, i);
                return "string" != typeof u || s || o[u] ? s ? !(l = u) : void 0 : (e.dataTypes.unshift(u), r(u), !1)
            }), l
        }
        var o = {},
            s = t === We;
        return r(e.dataTypes[0]) || !o["*"] && r("*")
    }

    function nt(t, e) {
        var n, i, r = bt.ajaxSettings.flatOptions || {};
        for (n in e) void 0 !== e[n] && ((r[n] ? t : i || (i = {}))[n] = e[n]);
        return i && bt.extend(!0, t, i), t
    }

    function it(t, e, n) {
        for (var i, r, o, s, a = t.contents, l = t.dataTypes;
            "*" === l[0];) l.shift(), void 0 === i && (i = t.mimeType || e.getResponseHeader("Content-Type"));
        if (i)
            for (r in a)
                if (a[r] && a[r].test(i)) {
                    l.unshift(r);
                    break
                } if (l[0] in n) o = l[0];
        else {
            for (r in n) {
                if (!l[0] || t.converters[r + " " + l[0]]) {
                    o = r;
                    break
                }
                s || (s = r)
            }
            o = o || s
        }
        if (o) return o !== l[0] && l.unshift(o), n[o]
    }

    function rt(t, e, n, i) {
        var r, o, s, a, l, u = {},
            c = t.dataTypes.slice();
        if (c[1])
            for (s in t.converters) u[s.toLowerCase()] = t.converters[s];
        for (o = c.shift(); o;)
            if (t.responseFields[o] && (n[t.responseFields[o]] = e), !l && i && t.dataFilter && (e = t.dataFilter(e, t.dataType)), l = o, o = c.shift())
                if ("*" === o) o = l;
                else if ("*" !== l && l !== o) {
            if (!(s = u[l + " " + o] || u["* " + o]))
                for (r in u)
                    if ((a = r.split(" "))[1] === o && (s = u[l + " " + a[0]] || u["* " + a[0]])) {
                        !0 === s ? s = u[r] : !0 !== u[r] && (o = a[0], c.unshift(a[1]));
                        break
                    } if (!0 !== s)
                if (s && t.throws) e = s(e);
                else try {
                    e = s(e)
                } catch (t) {
                    return {
                        state: "parsererror",
                        error: s ? t : "No conversion from " + l + " to " + o
                    }
                }
        }
        return {
            state: "success",
            data: e
        }
    }
    var ot = [],
        st = t.document,
        at = Object.getPrototypeOf,
        lt = ot.slice,
        ut = ot.concat,
        ct = ot.push,
        pt = ot.indexOf,
        ht = {},
        dt = ht.toString,
        ft = ht.hasOwnProperty,
        gt = ft.toString,
        mt = gt.call(Object),
        vt = {},
        yt = function(t) {
            return "function" == typeof t && "number" != typeof t.nodeType
        },
        wt = function(t) {
            return null != t && t === t.window
        },
        xt = {
            type: !0,
            src: !0,
            noModule: !0
        },
        bt = function(t, e) {
            return new bt.fn.init(t, e)
        },
        _t = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
    bt.fn = bt.prototype = {
        jquery: "3.3.1",
        constructor: bt,
        length: 0,
        toArray: function() {
            return lt.call(this)
        },
        get: function(t) {
            return null == t ? lt.call(this) : t < 0 ? this[t + this.length] : this[t]
        },
        pushStack: function(t) {
            var e = bt.merge(this.constructor(), t);
            return e.prevObject = this, e
        },
        each: function(t) {
            return bt.each(this, t)
        },
        map: function(t) {
            return this.pushStack(bt.map(this, function(e, n) {
                return t.call(e, n, e)
            }))
        },
        slice: function() {
            return this.pushStack(lt.apply(this, arguments))
        },
        first: function() {
            return this.eq(0)
        },
        last: function() {
            return this.eq(-1)
        },
        eq: function(t) {
            var e = this.length,
                n = +t + (t < 0 ? e : 0);
            return this.pushStack(n >= 0 && n < e ? [this[n]] : [])
        },
        end: function() {
            return this.prevObject || this.constructor()
        },
        push: ct,
        sort: ot.sort,
        splice: ot.splice
    }, bt.extend = bt.fn.extend = function() {
        var t, e, n, i, r, o, s = arguments[0] || {},
            a = 1,
            l = arguments.length,
            u = !1;
        for ("boolean" == typeof s && (u = s, s = arguments[a] || {}, a++), "object" == typeof s || yt(s) || (s = {}), a === l && (s = this, a--); a < l; a++)
            if (null != (t = arguments[a]))
                for (e in t) n = s[e], s !== (i = t[e]) && (u && i && (bt.isPlainObject(i) || (r = Array.isArray(i))) ? (r ? (r = !1, o = n && Array.isArray(n) ? n : []) : o = n && bt.isPlainObject(n) ? n : {}, s[e] = bt.extend(u, o, i)) : void 0 !== i && (s[e] = i));
        return s
    }, bt.extend({
        expando: "jQuery" + ("3.3.1" + Math.random()).replace(/\D/g, ""),
        isReady: !0,
        error: function(t) {
            throw new Error(t)
        },
        noop: function() {},
        isPlainObject: function(t) {
            var e, n;
            return !(!t || "[object Object]" !== dt.call(t) || (e = at(t)) && ("function" != typeof(n = ft.call(e, "constructor") && e.constructor) || gt.call(n) !== mt))
        },
        isEmptyObject: function(t) {
            var e;
            for (e in t) return !1;
            return !0
        },
        globalEval: function(t) {
            n(t)
        },
        each: function(t, e) {
            var n, i = 0;
            if (r(t))
                for (n = t.length; i < n && !1 !== e.call(t[i], i, t[i]); i++);
            else
                for (i in t)
                    if (!1 === e.call(t[i], i, t[i])) break;
            return t
        },
        trim: function(t) {
            return null == t ? "" : (t + "").replace(_t, "")
        },
        makeArray: function(t, e) {
            var n = e || [];
            return null != t && (r(Object(t)) ? bt.merge(n, "string" == typeof t ? [t] : t) : ct.call(n, t)), n
        },
        inArray: function(t, e, n) {
            return null == e ? -1 : pt.call(e, t, n)
        },
        merge: function(t, e) {
            for (var n = +e.length, i = 0, r = t.length; i < n; i++) t[r++] = e[i];
            return t.length = r, t
        },
        grep: function(t, e, n) {
            for (var i = [], r = 0, o = t.length, s = !n; r < o; r++) !e(t[r], r) !== s && i.push(t[r]);
            return i
        },
        map: function(t, e, n) {
            var i, o, s = 0,
                a = [];
            if (r(t))
                for (i = t.length; s < i; s++) null != (o = e(t[s], s, n)) && a.push(o);
            else
                for (s in t) null != (o = e(t[s], s, n)) && a.push(o);
            return ut.apply([], a)
        },
        guid: 1,
        support: vt
    }), "function" == typeof Symbol && (bt.fn[Symbol.iterator] = ot[Symbol.iterator]), bt.each("Boolean Number String Function Array Date RegExp Object Error Symbol".split(" "), function(t, e) {
        ht["[object " + e + "]"] = e.toLowerCase()
    });
    var Ct = function(t) {
        function e(t, e, n, i) {
            var r, o, s, a, l, c, h, d = e && e.ownerDocument,
                f = e ? e.nodeType : 9;
            if (n = n || [], "string" != typeof t || !t || 1 !== f && 9 !== f && 11 !== f) return n;
            if (!i && ((e ? e.ownerDocument || e : M) !== O && D(e), e = e || O, z)) {
                if (11 !== f && (l = gt.exec(t)))
                    if (r = l[1]) {
                        if (9 === f) {
                            if (!(s = e.getElementById(r))) return n;
                            if (s.id === r) return n.push(s), n
                        } else if (d && (s = d.getElementById(r)) && L(e, s) && s.id === r) return n.push(s), n
                    } else {
                        if (l[2]) return Z.apply(n, e.getElementsByTagName(t)), n;
                        if ((r = l[3]) && x.getElementsByClassName && e.getElementsByClassName) return Z.apply(n, e.getElementsByClassName(r)), n
                    } if (x.qsa && !F[t + " "] && (!I || !I.test(t))) {
                    if (1 !== f) d = e, h = t;
                    else if ("object" !== e.nodeName.toLowerCase()) {
                        for ((a = e.getAttribute("id")) ? a = a.replace(wt, xt) : e.setAttribute("id", a = H), o = (c = T(t)).length; o--;) c[o] = "#" + a + " " + p(c[o]);
                        h = c.join(","), d = mt.test(t) && u(e.parentNode) || e
                    }
                    if (h) try {
                        return Z.apply(n, d.querySelectorAll(h)), n
                    } catch (t) {} finally {
                        a === H && e.removeAttribute("id")
                    }
                }
            }
            return k(t.replace(ot, "$1"), e, n, i)
        }

        function n() {
            function t(n, i) {
                return e.push(n + " ") > b.cacheLength && delete t[e.shift()], t[n + " "] = i
            }
            var e = [];
            return t
        }

        function i(t) {
            return t[H] = !0, t
        }

        function r(t) {
            var e = O.createElement("fieldset");
            try {
                return !!t(e)
            } catch (t) {
                return !1
            } finally {
                e.parentNode && e.parentNode.removeChild(e), e = null
            }
        }

        function o(t, e) {
            for (var n = t.split("|"), i = n.length; i--;) b.attrHandle[n[i]] = e
        }

        function s(t, e) {
            var n = e && t,
                i = n && 1 === t.nodeType && 1 === e.nodeType && t.sourceIndex - e.sourceIndex;
            if (i) return i;
            if (n)
                for (; n = n.nextSibling;)
                    if (n === e) return -1;
            return t ? 1 : -1
        }

        function a(t) {
            return function(e) {
                return "form" in e ? e.parentNode && !1 === e.disabled ? "label" in e ? "label" in e.parentNode ? e.parentNode.disabled === t : e.disabled === t : e.isDisabled === t || e.isDisabled !== !t && _t(e) === t : e.disabled === t : "label" in e && e.disabled === t
            }
        }

        function l(t) {
            return i(function(e) {
                return e = +e, i(function(n, i) {
                    for (var r, o = t([], n.length, e), s = o.length; s--;) n[r = o[s]] && (n[r] = !(i[r] = n[r]))
                })
            })
        }

        function u(t) {
            return t && void 0 !== t.getElementsByTagName && t
        }

        function c() {}

        function p(t) {
            for (var e = 0, n = t.length, i = ""; e < n; e++) i += t[e].value;
            return i
        }

        function h(t, e, n) {
            var i = e.dir,
                r = e.next,
                o = r || i,
                s = n && "parentNode" === o,
                a = B++;
            return e.first ? function(e, n, r) {
                for (; e = e[i];)
                    if (1 === e.nodeType || s) return t(e, n, r);
                return !1
            } : function(e, n, l) {
                var u, c, p, h = [q, a];
                if (l) {
                    for (; e = e[i];)
                        if ((1 === e.nodeType || s) && t(e, n, l)) return !0
                } else
                    for (; e = e[i];)
                        if (1 === e.nodeType || s)
                            if (p = e[H] || (e[H] = {}), c = p[e.uniqueID] || (p[e.uniqueID] = {}), r && r === e.nodeName.toLowerCase()) e = e[i] || e;
                            else {
                                if ((u = c[o]) && u[0] === q && u[1] === a) return h[2] = u[2];
                                if (c[o] = h, h[2] = t(e, n, l)) return !0
                            } return !1
            }
        }

        function d(t) {
            return t.length > 1 ? function(e, n, i) {
                for (var r = t.length; r--;)
                    if (!t[r](e, n, i)) return !1;
                return !0
            } : t[0]
        }

        function f(t, n, i) {
            for (var r = 0, o = n.length; r < o; r++) e(t, n[r], i);
            return i
        }

        function g(t, e, n, i, r) {
            for (var o, s = [], a = 0, l = t.length, u = null != e; a < l; a++)(o = t[a]) && (n && !n(o, i, r) || (s.push(o), u && e.push(a)));
            return s
        }

        function m(t, e, n, r, o, s) {
            return r && !r[H] && (r = m(r)), o && !o[H] && (o = m(o, s)), i(function(i, s, a, l) {
                var u, c, p, h = [],
                    d = [],
                    m = s.length,
                    v = i || f(e || "*", a.nodeType ? [a] : a, []),
                    y = !t || !i && e ? v : g(v, h, t, a, l),
                    w = n ? o || (i ? t : m || r) ? [] : s : y;
                if (n && n(y, w, a, l), r)
                    for (u = g(w, d), r(u, [], a, l), c = u.length; c--;)(p = u[c]) && (w[d[c]] = !(y[d[c]] = p));
                if (i) {
                    if (o || t) {
                        if (o) {
                            for (u = [], c = w.length; c--;)(p = w[c]) && u.push(y[c] = p);
                            o(null, w = [], u, l)
                        }
                        for (c = w.length; c--;)(p = w[c]) && (u = o ? K(i, p) : h[c]) > -1 && (i[u] = !(s[u] = p))
                    }
                } else w = g(w === s ? w.splice(m, w.length) : w), o ? o(null, s, w, l) : Z.apply(s, w)
            })
        }

        function v(t) {
            for (var e, n, i, r = t.length, o = b.relative[t[0].type], s = o || b.relative[" "], a = o ? 1 : 0, l = h(function(t) {
                    return t === e
                }, s, !0), u = h(function(t) {
                    return K(e, t) > -1
                }, s, !0), c = [function(t, n, i) {
                    var r = !o && (i || n !== S) || ((e = n).nodeType ? l(t, n, i) : u(t, n, i));
                    return e = null, r
                }]; a < r; a++)
                if (n = b.relative[t[a].type]) c = [h(d(c), n)];
                else {
                    if ((n = b.filter[t[a].type].apply(null, t[a].matches))[H]) {
                        for (i = ++a; i < r && !b.relative[t[i].type]; i++);
                        return m(a > 1 && d(c), a > 1 && p(t.slice(0, a - 1).concat({
                            value: " " === t[a - 2].type ? "*" : ""
                        })).replace(ot, "$1"), n, a < i && v(t.slice(a, i)), i < r && v(t = t.slice(i)), i < r && p(t))
                    }
                    c.push(n)
                } return d(c)
        }

        function y(t, n) {
            var r = n.length > 0,
                o = t.length > 0,
                s = function(i, s, a, l, u) {
                    var c, p, h, d = 0,
                        f = "0",
                        m = i && [],
                        v = [],
                        y = S,
                        w = i || o && b.find.TAG("*", u),
                        x = q += null == y ? 1 : Math.random() || .1,
                        _ = w.length;
                    for (u && (S = s === O || s || u); f !== _ && null != (c = w[f]); f++) {
                        if (o && c) {
                            for (p = 0, s || c.ownerDocument === O || (D(c), a = !z); h = t[p++];)
                                if (h(c, s || O, a)) {
                                    l.push(c);
                                    break
                                } u && (q = x)
                        }
                        r && ((c = !h && c) && d--, i && m.push(c))
                    }
                    if (d += f, r && f !== d) {
                        for (p = 0; h = n[p++];) h(m, v, s, a);
                        if (i) {
                            if (d > 0)
                                for (; f--;) m[f] || v[f] || (v[f] = Q.call(l));
                            v = g(v)
                        }
                        Z.apply(l, v), u && !i && v.length > 0 && d + n.length > 1 && e.uniqueSort(l)
                    }
                    return u && (q = x, S = y), m
                };
            return r ? i(s) : s
        }
        var w, x, b, _, C, T, E, k, S, A, j, D, O, $, z, I, P, N, L, H = "sizzle" + 1 * new Date,
            M = t.document,
            q = 0,
            B = 0,
            R = n(),
            W = n(),
            F = n(),
            X = function(t, e) {
                return t === e && (j = !0), 0
            },
            U = {}.hasOwnProperty,
            Y = [],
            Q = Y.pop,
            V = Y.push,
            Z = Y.push,
            G = Y.slice,
            K = function(t, e) {
                for (var n = 0, i = t.length; n < i; n++)
                    if (t[n] === e) return n;
                return -1
            },
            J = "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",
            tt = "[\\x20\\t\\r\\n\\f]",
            et = "(?:\\\\.|[\\w-]|[^\0-\\xa0])+",
            nt = "\\[" + tt + "*(" + et + ")(?:" + tt + "*([*^$|!~]?=)" + tt + "*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|(" + et + "))|)" + tt + "*\\]",
            it = ":(" + et + ")(?:\\((('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|((?:\\\\.|[^\\\\()[\\]]|" + nt + ")*)|.*)\\)|)",
            rt = new RegExp(tt + "+", "g"),
            ot = new RegExp("^" + tt + "+|((?:^|[^\\\\])(?:\\\\.)*)" + tt + "+$", "g"),
            st = new RegExp("^" + tt + "*," + tt + "*"),
            at = new RegExp("^" + tt + "*([>+~]|" + tt + ")" + tt + "*"),
            lt = new RegExp("=" + tt + "*([^\\]'\"]*?)" + tt + "*\\]", "g"),
            ut = new RegExp(it),
            ct = new RegExp("^" + et + "$"),
            pt = {
                ID: new RegExp("^#(" + et + ")"),
                CLASS: new RegExp("^\\.(" + et + ")"),
                TAG: new RegExp("^(" + et + "|[*])"),
                ATTR: new RegExp("^" + nt),
                PSEUDO: new RegExp("^" + it),
                CHILD: new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" + tt + "*(even|odd|(([+-]|)(\\d*)n|)" + tt + "*(?:([+-]|)" + tt + "*(\\d+)|))" + tt + "*\\)|)", "i"),
                bool: new RegExp("^(?:" + J + ")$", "i"),
                needsContext: new RegExp("^" + tt + "*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + tt + "*((?:-\\d)?\\d*)" + tt + "*\\)|)(?=[^-]|$)", "i")
            },
            ht = /^(?:input|select|textarea|button)$/i,
            dt = /^h\d$/i,
            ft = /^[^{]+\{\s*\[native \w/,
            gt = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,
            mt = /[+~]/,
            vt = new RegExp("\\\\([\\da-f]{1,6}" + tt + "?|(" + tt + ")|.)", "ig"),
            yt = function(t, e, n) {
                var i = "0x" + e - 65536;
                return i !== i || n ? e : i < 0 ? String.fromCharCode(i + 65536) : String.fromCharCode(i >> 10 | 55296, 1023 & i | 56320)
            },
            wt = /([\0-\x1f\x7f]|^-?\d)|^-$|[^\0-\x1f\x7f-\uFFFF\w-]/g,
            xt = function(t, e) {
                return e ? "\0" === t ? "�" : t.slice(0, -1) + "\\" + t.charCodeAt(t.length - 1).toString(16) + " " : "\\" + t
            },
            bt = function() {
                D()
            },
            _t = h(function(t) {
                return !0 === t.disabled && ("form" in t || "label" in t)
            }, {
                dir: "parentNode",
                next: "legend"
            });
        try {
            Z.apply(Y = G.call(M.childNodes), M.childNodes), Y[M.childNodes.length].nodeType
        } catch (t) {
            Z = {
                apply: Y.length ? function(t, e) {
                    V.apply(t, G.call(e))
                } : function(t, e) {
                    for (var n = t.length, i = 0; t[n++] = e[i++];);
                    t.length = n - 1
                }
            }
        }
        x = e.support = {}, C = e.isXML = function(t) {
            var e = t && (t.ownerDocument || t).documentElement;
            return !!e && "HTML" !== e.nodeName
        }, D = e.setDocument = function(t) {
            var e, n, i = t ? t.ownerDocument || t : M;
            return i !== O && 9 === i.nodeType && i.documentElement ? (O = i, $ = O.documentElement, z = !C(O), M !== O && (n = O.defaultView) && n.top !== n && (n.addEventListener ? n.addEventListener("unload", bt, !1) : n.attachEvent && n.attachEvent("onunload", bt)), x.attributes = r(function(t) {
                return t.className = "i", !t.getAttribute("className")
            }), x.getElementsByTagName = r(function(t) {
                return t.appendChild(O.createComment("")), !t.getElementsByTagName("*").length
            }), x.getElementsByClassName = ft.test(O.getElementsByClassName), x.getById = r(function(t) {
                return $.appendChild(t).id = H, !O.getElementsByName || !O.getElementsByName(H).length
            }), x.getById ? (b.filter.ID = function(t) {
                var e = t.replace(vt, yt);
                return function(t) {
                    return t.getAttribute("id") === e
                }
            }, b.find.ID = function(t, e) {
                if (void 0 !== e.getElementById && z) {
                    var n = e.getElementById(t);
                    return n ? [n] : []
                }
            }) : (b.filter.ID = function(t) {
                var e = t.replace(vt, yt);
                return function(t) {
                    var n = void 0 !== t.getAttributeNode && t.getAttributeNode("id");
                    return n && n.value === e
                }
            }, b.find.ID = function(t, e) {
                if (void 0 !== e.getElementById && z) {
                    var n, i, r, o = e.getElementById(t);
                    if (o) {
                        if ((n = o.getAttributeNode("id")) && n.value === t) return [o];
                        for (r = e.getElementsByName(t), i = 0; o = r[i++];)
                            if ((n = o.getAttributeNode("id")) && n.value === t) return [o]
                    }
                    return []
                }
            }), b.find.TAG = x.getElementsByTagName ? function(t, e) {
                return void 0 !== e.getElementsByTagName ? e.getElementsByTagName(t) : x.qsa ? e.querySelectorAll(t) : void 0
            } : function(t, e) {
                var n, i = [],
                    r = 0,
                    o = e.getElementsByTagName(t);
                if ("*" === t) {
                    for (; n = o[r++];) 1 === n.nodeType && i.push(n);
                    return i
                }
                return o
            }, b.find.CLASS = x.getElementsByClassName && function(t, e) {
                if (void 0 !== e.getElementsByClassName && z) return e.getElementsByClassName(t)
            }, P = [], I = [], (x.qsa = ft.test(O.querySelectorAll)) && (r(function(t) {
                $.appendChild(t).innerHTML = "<a id='" + H + "'></a><select id='" + H + "-\r\\' msallowcapture=''><option selected=''></option></select>", t.querySelectorAll("[msallowcapture^='']").length && I.push("[*^$]=" + tt + "*(?:''|\"\")"), t.querySelectorAll("[selected]").length || I.push("\\[" + tt + "*(?:value|" + J + ")"), t.querySelectorAll("[id~=" + H + "-]").length || I.push("~="), t.querySelectorAll(":checked").length || I.push(":checked"), t.querySelectorAll("a#" + H + "+*").length || I.push(".#.+[+~]")
            }), r(function(t) {
                t.innerHTML = "<a href='' disabled='disabled'></a><select disabled='disabled'><option/></select>";
                var e = O.createElement("input");
                e.setAttribute("type", "hidden"), t.appendChild(e).setAttribute("name", "D"), t.querySelectorAll("[name=d]").length && I.push("name" + tt + "*[*^$|!~]?="), 2 !== t.querySelectorAll(":enabled").length && I.push(":enabled", ":disabled"), $.appendChild(t).disabled = !0, 2 !== t.querySelectorAll(":disabled").length && I.push(":enabled", ":disabled"), t.querySelectorAll("*,:x"), I.push(",.*:")
            })), (x.matchesSelector = ft.test(N = $.matches || $.webkitMatchesSelector || $.mozMatchesSelector || $.oMatchesSelector || $.msMatchesSelector)) && r(function(t) {
                x.disconnectedMatch = N.call(t, "*"), N.call(t, "[s!='']:x"), P.push("!=", it)
            }), I = I.length && new RegExp(I.join("|")), P = P.length && new RegExp(P.join("|")), e = ft.test($.compareDocumentPosition), L = e || ft.test($.contains) ? function(t, e) {
                var n = 9 === t.nodeType ? t.documentElement : t,
                    i = e && e.parentNode;
                return t === i || !(!i || 1 !== i.nodeType || !(n.contains ? n.contains(i) : t.compareDocumentPosition && 16 & t.compareDocumentPosition(i)))
            } : function(t, e) {
                if (e)
                    for (; e = e.parentNode;)
                        if (e === t) return !0;
                return !1
            }, X = e ? function(t, e) {
                if (t === e) return j = !0, 0;
                var n = !t.compareDocumentPosition - !e.compareDocumentPosition;
                return n || (1 & (n = (t.ownerDocument || t) === (e.ownerDocument || e) ? t.compareDocumentPosition(e) : 1) || !x.sortDetached && e.compareDocumentPosition(t) === n ? t === O || t.ownerDocument === M && L(M, t) ? -1 : e === O || e.ownerDocument === M && L(M, e) ? 1 : A ? K(A, t) - K(A, e) : 0 : 4 & n ? -1 : 1)
            } : function(t, e) {
                if (t === e) return j = !0, 0;
                var n, i = 0,
                    r = t.parentNode,
                    o = e.parentNode,
                    a = [t],
                    l = [e];
                if (!r || !o) return t === O ? -1 : e === O ? 1 : r ? -1 : o ? 1 : A ? K(A, t) - K(A, e) : 0;
                if (r === o) return s(t, e);
                for (n = t; n = n.parentNode;) a.unshift(n);
                for (n = e; n = n.parentNode;) l.unshift(n);
                for (; a[i] === l[i];) i++;
                return i ? s(a[i], l[i]) : a[i] === M ? -1 : l[i] === M ? 1 : 0
            }, O) : O
        }, e.matches = function(t, n) {
            return e(t, null, null, n)
        }, e.matchesSelector = function(t, n) {
            if ((t.ownerDocument || t) !== O && D(t), n = n.replace(lt, "='$1']"), x.matchesSelector && z && !F[n + " "] && (!P || !P.test(n)) && (!I || !I.test(n))) try {
                var i = N.call(t, n);
                if (i || x.disconnectedMatch || t.document && 11 !== t.document.nodeType) return i
            } catch (t) {}
            return e(n, O, null, [t]).length > 0
        }, e.contains = function(t, e) {
            return (t.ownerDocument || t) !== O && D(t), L(t, e)
        }, e.attr = function(t, e) {
            (t.ownerDocument || t) !== O && D(t);
            var n = b.attrHandle[e.toLowerCase()],
                i = n && U.call(b.attrHandle, e.toLowerCase()) ? n(t, e, !z) : void 0;
            return void 0 !== i ? i : x.attributes || !z ? t.getAttribute(e) : (i = t.getAttributeNode(e)) && i.specified ? i.value : null
        }, e.escape = function(t) {
            return (t + "").replace(wt, xt)
        }, e.error = function(t) {
            throw new Error("Syntax error, unrecognized expression: " + t)
        }, e.uniqueSort = function(t) {
            var e, n = [],
                i = 0,
                r = 0;
            if (j = !x.detectDuplicates, A = !x.sortStable && t.slice(0), t.sort(X), j) {
                for (; e = t[r++];) e === t[r] && (i = n.push(r));
                for (; i--;) t.splice(n[i], 1)
            }
            return A = null, t
        }, _ = e.getText = function(t) {
            var e, n = "",
                i = 0,
                r = t.nodeType;
            if (r) {
                if (1 === r || 9 === r || 11 === r) {
                    if ("string" == typeof t.textContent) return t.textContent;
                    for (t = t.firstChild; t; t = t.nextSibling) n += _(t)
                } else if (3 === r || 4 === r) return t.nodeValue
            } else
                for (; e = t[i++];) n += _(e);
            return n
        }, (b = e.selectors = {
            cacheLength: 50,
            createPseudo: i,
            match: pt,
            attrHandle: {},
            find: {},
            relative: {
                ">": {
                    dir: "parentNode",
                    first: !0
                },
                " ": {
                    dir: "parentNode"
                },
                "+": {
                    dir: "previousSibling",
                    first: !0
                },
                "~": {
                    dir: "previousSibling"
                }
            },
            preFilter: {
                ATTR: function(t) {
                    return t[1] = t[1].replace(vt, yt), t[3] = (t[3] || t[4] || t[5] || "").replace(vt, yt), "~=" === t[2] && (t[3] = " " + t[3] + " "), t.slice(0, 4)
                },
                CHILD: function(t) {
                    return t[1] = t[1].toLowerCase(), "nth" === t[1].slice(0, 3) ? (t[3] || e.error(t[0]), t[4] = +(t[4] ? t[5] + (t[6] || 1) : 2 * ("even" === t[3] || "odd" === t[3])), t[5] = +(t[7] + t[8] || "odd" === t[3])) : t[3] && e.error(t[0]), t
                },
                PSEUDO: function(t) {
                    var e, n = !t[6] && t[2];
                    return pt.CHILD.test(t[0]) ? null : (t[3] ? t[2] = t[4] || t[5] || "" : n && ut.test(n) && (e = T(n, !0)) && (e = n.indexOf(")", n.length - e) - n.length) && (t[0] = t[0].slice(0, e), t[2] = n.slice(0, e)), t.slice(0, 3))
                }
            },
            filter: {
                TAG: function(t) {
                    var e = t.replace(vt, yt).toLowerCase();
                    return "*" === t ? function() {
                        return !0
                    } : function(t) {
                        return t.nodeName && t.nodeName.toLowerCase() === e
                    }
                },
                CLASS: function(t) {
                    var e = R[t + " "];
                    return e || (e = new RegExp("(^|" + tt + ")" + t + "(" + tt + "|$)")) && R(t, function(t) {
                        return e.test("string" == typeof t.className && t.className || void 0 !== t.getAttribute && t.getAttribute("class") || "")
                    })
                },
                ATTR: function(t, n, i) {
                    return function(r) {
                        var o = e.attr(r, t);
                        return null == o ? "!=" === n : !n || (o += "", "=" === n ? o === i : "!=" === n ? o !== i : "^=" === n ? i && 0 === o.indexOf(i) : "*=" === n ? i && o.indexOf(i) > -1 : "$=" === n ? i && o.slice(-i.length) === i : "~=" === n ? (" " + o.replace(rt, " ") + " ").indexOf(i) > -1 : "|=" === n && (o === i || o.slice(0, i.length + 1) === i + "-"))
                    }
                },
                CHILD: function(t, e, n, i, r) {
                    var o = "nth" !== t.slice(0, 3),
                        s = "last" !== t.slice(-4),
                        a = "of-type" === e;
                    return 1 === i && 0 === r ? function(t) {
                        return !!t.parentNode
                    } : function(e, n, l) {
                        var u, c, p, h, d, f, g = o !== s ? "nextSibling" : "previousSibling",
                            m = e.parentNode,
                            v = a && e.nodeName.toLowerCase(),
                            y = !l && !a,
                            w = !1;
                        if (m) {
                            if (o) {
                                for (; g;) {
                                    for (h = e; h = h[g];)
                                        if (a ? h.nodeName.toLowerCase() === v : 1 === h.nodeType) return !1;
                                    f = g = "only" === t && !f && "nextSibling"
                                }
                                return !0
                            }
                            if (f = [s ? m.firstChild : m.lastChild], s && y) {
                                for (w = (d = (u = (c = (p = (h = m)[H] || (h[H] = {}))[h.uniqueID] || (p[h.uniqueID] = {}))[t] || [])[0] === q && u[1]) && u[2], h = d && m.childNodes[d]; h = ++d && h && h[g] || (w = d = 0) || f.pop();)
                                    if (1 === h.nodeType && ++w && h === e) {
                                        c[t] = [q, d, w];
                                        break
                                    }
                            } else if (y && (w = d = (u = (c = (p = (h = e)[H] || (h[H] = {}))[h.uniqueID] || (p[h.uniqueID] = {}))[t] || [])[0] === q && u[1]), !1 === w)
                                for (;
                                    (h = ++d && h && h[g] || (w = d = 0) || f.pop()) && ((a ? h.nodeName.toLowerCase() !== v : 1 !== h.nodeType) || !++w || (y && ((c = (p = h[H] || (h[H] = {}))[h.uniqueID] || (p[h.uniqueID] = {}))[t] = [q, w]), h !== e)););
                            return (w -= r) === i || w % i == 0 && w / i >= 0
                        }
                    }
                },
                PSEUDO: function(t, n) {
                    var r, o = b.pseudos[t] || b.setFilters[t.toLowerCase()] || e.error("unsupported pseudo: " + t);
                    return o[H] ? o(n) : o.length > 1 ? (r = [t, t, "", n], b.setFilters.hasOwnProperty(t.toLowerCase()) ? i(function(t, e) {
                        for (var i, r = o(t, n), s = r.length; s--;) t[i = K(t, r[s])] = !(e[i] = r[s])
                    }) : function(t) {
                        return o(t, 0, r)
                    }) : o
                }
            },
            pseudos: {
                not: i(function(t) {
                    var e = [],
                        n = [],
                        r = E(t.replace(ot, "$1"));
                    return r[H] ? i(function(t, e, n, i) {
                        for (var o, s = r(t, null, i, []), a = t.length; a--;)(o = s[a]) && (t[a] = !(e[a] = o))
                    }) : function(t, i, o) {
                        return e[0] = t, r(e, null, o, n), e[0] = null, !n.pop()
                    }
                }),
                has: i(function(t) {
                    return function(n) {
                        return e(t, n).length > 0
                    }
                }),
                contains: i(function(t) {
                    return t = t.replace(vt, yt),
                        function(e) {
                            return (e.textContent || e.innerText || _(e)).indexOf(t) > -1
                        }
                }),
                lang: i(function(t) {
                    return ct.test(t || "") || e.error("unsupported lang: " + t), t = t.replace(vt, yt).toLowerCase(),
                        function(e) {
                            var n;
                            do {
                                if (n = z ? e.lang : e.getAttribute("xml:lang") || e.getAttribute("lang")) return (n = n.toLowerCase()) === t || 0 === n.indexOf(t + "-")
                            } while ((e = e.parentNode) && 1 === e.nodeType);
                            return !1
                        }
                }),
                target: function(e) {
                    var n = t.location && t.location.hash;
                    return n && n.slice(1) === e.id
                },
                root: function(t) {
                    return t === $
                },
                focus: function(t) {
                    return t === O.activeElement && (!O.hasFocus || O.hasFocus()) && !!(t.type || t.href || ~t.tabIndex)
                },
                enabled: a(!1),
                disabled: a(!0),
                checked: function(t) {
                    var e = t.nodeName.toLowerCase();
                    return "input" === e && !!t.checked || "option" === e && !!t.selected
                },
                selected: function(t) {
                    return t.parentNode && t.parentNode.selectedIndex, !0 === t.selected
                },
                empty: function(t) {
                    for (t = t.firstChild; t; t = t.nextSibling)
                        if (t.nodeType < 6) return !1;
                    return !0
                },
                parent: function(t) {
                    return !b.pseudos.empty(t)
                },
                header: function(t) {
                    return dt.test(t.nodeName)
                },
                input: function(t) {
                    return ht.test(t.nodeName)
                },
                button: function(t) {
                    var e = t.nodeName.toLowerCase();
                    return "input" === e && "button" === t.type || "button" === e
                },
                text: function(t) {
                    var e;
                    return "input" === t.nodeName.toLowerCase() && "text" === t.type && (null == (e = t.getAttribute("type")) || "text" === e.toLowerCase())
                },
                first: l(function() {
                    return [0]
                }),
                last: l(function(t, e) {
                    return [e - 1]
                }),
                eq: l(function(t, e, n) {
                    return [n < 0 ? n + e : n]
                }),
                even: l(function(t, e) {
                    for (var n = 0; n < e; n += 2) t.push(n);
                    return t
                }),
                odd: l(function(t, e) {
                    for (var n = 1; n < e; n += 2) t.push(n);
                    return t
                }),
                lt: l(function(t, e, n) {
                    for (var i = n < 0 ? n + e : n; --i >= 0;) t.push(i);
                    return t
                }),
                gt: l(function(t, e, n) {
                    for (var i = n < 0 ? n + e : n; ++i < e;) t.push(i);
                    return t
                })
            }
        }).pseudos.nth = b.pseudos.eq;
        for (w in {
                radio: !0,
                checkbox: !0,
                file: !0,
                password: !0,
                image: !0
            }) b.pseudos[w] = function(t) {
            return function(e) {
                return "input" === e.nodeName.toLowerCase() && e.type === t
            }
        }(w);
        for (w in {
                submit: !0,
                reset: !0
            }) b.pseudos[w] = function(t) {
            return function(e) {
                var n = e.nodeName.toLowerCase();
                return ("input" === n || "button" === n) && e.type === t
            }
        }(w);
        return c.prototype = b.filters = b.pseudos, b.setFilters = new c, T = e.tokenize = function(t, n) {
            var i, r, o, s, a, l, u, c = W[t + " "];
            if (c) return n ? 0 : c.slice(0);
            for (a = t, l = [], u = b.preFilter; a;) {
                i && !(r = st.exec(a)) || (r && (a = a.slice(r[0].length) || a), l.push(o = [])), i = !1, (r = at.exec(a)) && (i = r.shift(), o.push({
                    value: i,
                    type: r[0].replace(ot, " ")
                }), a = a.slice(i.length));
                for (s in b.filter) !(r = pt[s].exec(a)) || u[s] && !(r = u[s](r)) || (i = r.shift(), o.push({
                    value: i,
                    type: s,
                    matches: r
                }), a = a.slice(i.length));
                if (!i) break
            }
            return n ? a.length : a ? e.error(t) : W(t, l).slice(0)
        }, E = e.compile = function(t, e) {
            var n, i = [],
                r = [],
                o = F[t + " "];
            if (!o) {
                for (e || (e = T(t)), n = e.length; n--;)(o = v(e[n]))[H] ? i.push(o) : r.push(o);
                (o = F(t, y(r, i))).selector = t
            }
            return o
        }, k = e.select = function(t, e, n, i) {
            var r, o, s, a, l, c = "function" == typeof t && t,
                h = !i && T(t = c.selector || t);
            if (n = n || [], 1 === h.length) {
                if ((o = h[0] = h[0].slice(0)).length > 2 && "ID" === (s = o[0]).type && 9 === e.nodeType && z && b.relative[o[1].type]) {
                    if (!(e = (b.find.ID(s.matches[0].replace(vt, yt), e) || [])[0])) return n;
                    c && (e = e.parentNode), t = t.slice(o.shift().value.length)
                }
                for (r = pt.needsContext.test(t) ? 0 : o.length; r-- && (s = o[r], !b.relative[a = s.type]);)
                    if ((l = b.find[a]) && (i = l(s.matches[0].replace(vt, yt), mt.test(o[0].type) && u(e.parentNode) || e))) {
                        if (o.splice(r, 1), !(t = i.length && p(o))) return Z.apply(n, i), n;
                        break
                    }
            }
            return (c || E(t, h))(i, e, !z, n, !e || mt.test(t) && u(e.parentNode) || e), n
        }, x.sortStable = H.split("").sort(X).join("") === H, x.detectDuplicates = !!j, D(), x.sortDetached = r(function(t) {
            return 1 & t.compareDocumentPosition(O.createElement("fieldset"))
        }), r(function(t) {
            return t.innerHTML = "<a href='#'></a>", "#" === t.firstChild.getAttribute("href")
        }) || o("type|href|height|width", function(t, e, n) {
            if (!n) return t.getAttribute(e, "type" === e.toLowerCase() ? 1 : 2)
        }), x.attributes && r(function(t) {
            return t.innerHTML = "<input/>", t.firstChild.setAttribute("value", ""), "" === t.firstChild.getAttribute("value")
        }) || o("value", function(t, e, n) {
            if (!n && "input" === t.nodeName.toLowerCase()) return t.defaultValue
        }), r(function(t) {
            return null == t.getAttribute("disabled")
        }) || o(J, function(t, e, n) {
            var i;
            if (!n) return !0 === t[e] ? e.toLowerCase() : (i = t.getAttributeNode(e)) && i.specified ? i.value : null
        }), e
    }(t);
    bt.find = Ct, bt.expr = Ct.selectors, bt.expr[":"] = bt.expr.pseudos, bt.uniqueSort = bt.unique = Ct.uniqueSort, bt.text = Ct.getText, bt.isXMLDoc = Ct.isXML, bt.contains = Ct.contains, bt.escapeSelector = Ct.escape;
    var Tt = function(t, e, n) {
            for (var i = [], r = void 0 !== n;
                (t = t[e]) && 9 !== t.nodeType;)
                if (1 === t.nodeType) {
                    if (r && bt(t).is(n)) break;
                    i.push(t)
                } return i
        },
        Et = function(t, e) {
            for (var n = []; t; t = t.nextSibling) 1 === t.nodeType && t !== e && n.push(t);
            return n
        },
        kt = bt.expr.match.needsContext,
        St = /^<([a-z][^\/\0>:\x20\t\r\n\f]*)[\x20\t\r\n\f]*\/?>(?:<\/\1>|)$/i;
    bt.filter = function(t, e, n) {
        var i = e[0];
        return n && (t = ":not(" + t + ")"), 1 === e.length && 1 === i.nodeType ? bt.find.matchesSelector(i, t) ? [i] : [] : bt.find.matches(t, bt.grep(e, function(t) {
            return 1 === t.nodeType
        }))
    }, bt.fn.extend({
        find: function(t) {
            var e, n, i = this.length,
                r = this;
            if ("string" != typeof t) return this.pushStack(bt(t).filter(function() {
                for (e = 0; e < i; e++)
                    if (bt.contains(r[e], this)) return !0
            }));
            for (n = this.pushStack([]), e = 0; e < i; e++) bt.find(t, r[e], n);
            return i > 1 ? bt.uniqueSort(n) : n
        },
        filter: function(t) {
            return this.pushStack(s(this, t || [], !1))
        },
        not: function(t) {
            return this.pushStack(s(this, t || [], !0))
        },
        is: function(t) {
            return !!s(this, "string" == typeof t && kt.test(t) ? bt(t) : t || [], !1).length
        }
    });
    var At, jt = /^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]+))$/;
    (bt.fn.init = function(t, e, n) {
        var i, r;
        if (!t) return this;
        if (n = n || At, "string" == typeof t) {
            if (!(i = "<" === t[0] && ">" === t[t.length - 1] && t.length >= 3 ? [null, t, null] : jt.exec(t)) || !i[1] && e) return !e || e.jquery ? (e || n).find(t) : this.constructor(e).find(t);
            if (i[1]) {
                if (e = e instanceof bt ? e[0] : e, bt.merge(this, bt.parseHTML(i[1], e && e.nodeType ? e.ownerDocument || e : st, !0)), St.test(i[1]) && bt.isPlainObject(e))
                    for (i in e) yt(this[i]) ? this[i](e[i]) : this.attr(i, e[i]);
                return this
            }
            return (r = st.getElementById(i[2])) && (this[0] = r, this.length = 1), this
        }
        return t.nodeType ? (this[0] = t, this.length = 1, this) : yt(t) ? void 0 !== n.ready ? n.ready(t) : t(bt) : bt.makeArray(t, this)
    }).prototype = bt.fn, At = bt(st);
    var Dt = /^(?:parents|prev(?:Until|All))/,
        Ot = {
            children: !0,
            contents: !0,
            next: !0,
            prev: !0
        };
    bt.fn.extend({
        has: function(t) {
            var e = bt(t, this),
                n = e.length;
            return this.filter(function() {
                for (var t = 0; t < n; t++)
                    if (bt.contains(this, e[t])) return !0
            })
        },
        closest: function(t, e) {
            var n, i = 0,
                r = this.length,
                o = [],
                s = "string" != typeof t && bt(t);
            if (!kt.test(t))
                for (; i < r; i++)
                    for (n = this[i]; n && n !== e; n = n.parentNode)
                        if (n.nodeType < 11 && (s ? s.index(n) > -1 : 1 === n.nodeType && bt.find.matchesSelector(n, t))) {
                            o.push(n);
                            break
                        } return this.pushStack(o.length > 1 ? bt.uniqueSort(o) : o)
        },
        index: function(t) {
            return t ? "string" == typeof t ? pt.call(bt(t), this[0]) : pt.call(this, t.jquery ? t[0] : t) : this[0] && this[0].parentNode ? this.first().prevAll().length : -1
        },
        add: function(t, e) {
            return this.pushStack(bt.uniqueSort(bt.merge(this.get(), bt(t, e))))
        },
        addBack: function(t) {
            return this.add(null == t ? this.prevObject : this.prevObject.filter(t))
        }
    }), bt.each({
        parent: function(t) {
            var e = t.parentNode;
            return e && 11 !== e.nodeType ? e : null
        },
        parents: function(t) {
            return Tt(t, "parentNode")
        },
        parentsUntil: function(t, e, n) {
            return Tt(t, "parentNode", n)
        },
        next: function(t) {
            return a(t, "nextSibling")
        },
        prev: function(t) {
            return a(t, "previousSibling")
        },
        nextAll: function(t) {
            return Tt(t, "nextSibling")
        },
        prevAll: function(t) {
            return Tt(t, "previousSibling")
        },
        nextUntil: function(t, e, n) {
            return Tt(t, "nextSibling", n)
        },
        prevUntil: function(t, e, n) {
            return Tt(t, "previousSibling", n)
        },
        siblings: function(t) {
            return Et((t.parentNode || {}).firstChild, t)
        },
        children: function(t) {
            return Et(t.firstChild)
        },
        contents: function(t) {
            return o(t, "iframe") ? t.contentDocument : (o(t, "template") && (t = t.content || t), bt.merge([], t.childNodes))
        }
    }, function(t, e) {
        bt.fn[t] = function(n, i) {
            var r = bt.map(this, e, n);
            return "Until" !== t.slice(-5) && (i = n), i && "string" == typeof i && (r = bt.filter(i, r)), this.length > 1 && (Ot[t] || bt.uniqueSort(r), Dt.test(t) && r.reverse()), this.pushStack(r)
        }
    });
    var $t = /[^\x20\t\r\n\f]+/g;
    bt.Callbacks = function(t) {
        t = "string" == typeof t ? l(t) : bt.extend({}, t);
        var e, n, r, o, s = [],
            a = [],
            u = -1,
            c = function() {
                for (o = o || t.once, r = e = !0; a.length; u = -1)
                    for (n = a.shift(); ++u < s.length;) !1 === s[u].apply(n[0], n[1]) && t.stopOnFalse && (u = s.length, n = !1);
                t.memory || (n = !1), e = !1, o && (s = n ? [] : "")
            },
            p = {
                add: function() {
                    return s && (n && !e && (u = s.length - 1, a.push(n)), function e(n) {
                        bt.each(n, function(n, r) {
                            yt(r) ? t.unique && p.has(r) || s.push(r) : r && r.length && "string" !== i(r) && e(r)
                        })
                    }(arguments), n && !e && c()), this
                },
                remove: function() {
                    return bt.each(arguments, function(t, e) {
                        for (var n;
                            (n = bt.inArray(e, s, n)) > -1;) s.splice(n, 1), n <= u && u--
                    }), this
                },
                has: function(t) {
                    return t ? bt.inArray(t, s) > -1 : s.length > 0
                },
                empty: function() {
                    return s && (s = []), this
                },
                disable: function() {
                    return o = a = [], s = n = "", this
                },
                disabled: function() {
                    return !s
                },
                lock: function() {
                    return o = a = [], n || e || (s = n = ""), this
                },
                locked: function() {
                    return !!o
                },
                fireWith: function(t, n) {
                    return o || (n = [t, (n = n || []).slice ? n.slice() : n], a.push(n), e || c()), this
                },
                fire: function() {
                    return p.fireWith(this, arguments), this
                },
                fired: function() {
                    return !!r
                }
            };
        return p
    }, bt.extend({
        Deferred: function(e) {
            var n = [
                    ["notify", "progress", bt.Callbacks("memory"), bt.Callbacks("memory"), 2],
                    ["resolve", "done", bt.Callbacks("once memory"), bt.Callbacks("once memory"), 0, "resolved"],
                    ["reject", "fail", bt.Callbacks("once memory"), bt.Callbacks("once memory"), 1, "rejected"]
                ],
                i = "pending",
                r = {
                    state: function() {
                        return i
                    },
                    always: function() {
                        return o.done(arguments).fail(arguments), this
                    },
                    catch: function(t) {
                        return r.then(null, t)
                    },
                    pipe: function() {
                        var t = arguments;
                        return bt.Deferred(function(e) {
                            bt.each(n, function(n, i) {
                                var r = yt(t[i[4]]) && t[i[4]];
                                o[i[1]](function() {
                                    var t = r && r.apply(this, arguments);
                                    t && yt(t.promise) ? t.promise().progress(e.notify).done(e.resolve).fail(e.reject) : e[i[0] + "With"](this, r ? [t] : arguments)
                                })
                            }), t = null
                        }).promise()
                    },
                    then: function(e, i, r) {
                        function o(e, n, i, r) {
                            return function() {
                                var a = this,
                                    l = arguments,
                                    p = function() {
                                        var t, p;
                                        if (!(e < s)) {
                                            if ((t = i.apply(a, l)) === n.promise()) throw new TypeError("Thenable self-resolution");
                                            p = t && ("object" == typeof t || "function" == typeof t) && t.then, yt(p) ? r ? p.call(t, o(s, n, u, r), o(s, n, c, r)) : (s++, p.call(t, o(s, n, u, r), o(s, n, c, r), o(s, n, u, n.notifyWith))) : (i !== u && (a = void 0, l = [t]), (r || n.resolveWith)(a, l))
                                        }
                                    },
                                    h = r ? p : function() {
                                        try {
                                            p()
                                        } catch (t) {
                                            bt.Deferred.exceptionHook && bt.Deferred.exceptionHook(t, h.stackTrace), e + 1 >= s && (i !== c && (a = void 0, l = [t]), n.rejectWith(a, l))
                                        }
                                    };
                                e ? h() : (bt.Deferred.getStackHook && (h.stackTrace = bt.Deferred.getStackHook()), t.setTimeout(h))
                            }
                        }
                        var s = 0;
                        return bt.Deferred(function(t) {
                            n[0][3].add(o(0, t, yt(r) ? r : u, t.notifyWith)), n[1][3].add(o(0, t, yt(e) ? e : u)), n[2][3].add(o(0, t, yt(i) ? i : c))
                        }).promise()
                    },
                    promise: function(t) {
                        return null != t ? bt.extend(t, r) : r
                    }
                },
                o = {};
            return bt.each(n, function(t, e) {
                var s = e[2],
                    a = e[5];
                r[e[1]] = s.add, a && s.add(function() {
                    i = a
                }, n[3 - t][2].disable, n[3 - t][3].disable, n[0][2].lock, n[0][3].lock), s.add(e[3].fire), o[e[0]] = function() {
                    return o[e[0] + "With"](this === o ? void 0 : this, arguments), this
                }, o[e[0] + "With"] = s.fireWith
            }), r.promise(o), e && e.call(o, o), o
        },
        when: function(t) {
            var e = arguments.length,
                n = e,
                i = Array(n),
                r = lt.call(arguments),
                o = bt.Deferred(),
                s = function(t) {
                    return function(n) {
                        i[t] = this, r[t] = arguments.length > 1 ? lt.call(arguments) : n, --e || o.resolveWith(i, r)
                    }
                };
            if (e <= 1 && (p(t, o.done(s(n)).resolve, o.reject, !e), "pending" === o.state() || yt(r[n] && r[n].then))) return o.then();
            for (; n--;) p(r[n], s(n), o.reject);
            return o.promise()
        }
    });
    var zt = /^(Eval|Internal|Range|Reference|Syntax|Type|URI)Error$/;
    bt.Deferred.exceptionHook = function(e, n) {
        // t.console && t.console.warn && e && zt.test(e.name) && t.console.warn("jQuery.Deferred exception: " + e.message, e.stack, n)
    }, bt.readyException = function(e) {
        // t.setTimeout(function() {
        //     throw e
        // })
    };
    var It = bt.Deferred();
    bt.fn.ready = function(t) {
        return It.then(t).catch(function(t) {
            bt.readyException(t)
        }), this
    }, bt.extend({
        isReady: !1,
        readyWait: 1,
        ready: function(t) {
            (!0 === t ? --bt.readyWait : bt.isReady) || (bt.isReady = !0, !0 !== t && --bt.readyWait > 0 || It.resolveWith(st, [bt]))
        }
    }), bt.ready.then = It.then, "complete" === st.readyState || "loading" !== st.readyState && !st.documentElement.doScroll ? t.setTimeout(bt.ready) : (st.addEventListener("DOMContentLoaded", h), t.addEventListener("load", h));
    var Pt = function(t, e, n, r, o, s, a) {
            var l = 0,
                u = t.length,
                c = null == n;
            if ("object" === i(n)) {
                o = !0;
                for (l in n) Pt(t, e, l, n[l], !0, s, a)
            } else if (void 0 !== r && (o = !0, yt(r) || (a = !0), c && (a ? (e.call(t, r), e = null) : (c = e, e = function(t, e, n) {
                    return c.call(bt(t), n)
                })), e))
                for (; l < u; l++) e(t[l], n, a ? r : r.call(t[l], l, e(t[l], n)));
            return o ? t : c ? e.call(t) : u ? e(t[0], n) : s
        },
        Nt = /^-ms-/,
        Lt = /-([a-z])/g,
        Ht = function(t) {
            return 1 === t.nodeType || 9 === t.nodeType || !+t.nodeType
        };
    g.uid = 1, g.prototype = {
        cache: function(t) {
            var e = t[this.expando];
            return e || (e = {}, Ht(t) && (t.nodeType ? t[this.expando] = e : Object.defineProperty(t, this.expando, {
                value: e,
                configurable: !0
            }))), e
        },
        set: function(t, e, n) {
            var i, r = this.cache(t);
            if ("string" == typeof e) r[f(e)] = n;
            else
                for (i in e) r[f(i)] = e[i];
            return r
        },
        get: function(t, e) {
            return void 0 === e ? this.cache(t) : t[this.expando] && t[this.expando][f(e)]
        },
        access: function(t, e, n) {
            return void 0 === e || e && "string" == typeof e && void 0 === n ? this.get(t, e) : (this.set(t, e, n), void 0 !== n ? n : e)
        },
        remove: function(t, e) {
            var n, i = t[this.expando];
            if (void 0 !== i) {
                if (void 0 !== e) {
                    n = (e = Array.isArray(e) ? e.map(f) : (e = f(e)) in i ? [e] : e.match($t) || []).length;
                    for (; n--;) delete i[e[n]]
                }(void 0 === e || bt.isEmptyObject(i)) && (t.nodeType ? t[this.expando] = void 0 : delete t[this.expando])
            }
        },
        hasData: function(t) {
            var e = t[this.expando];
            return void 0 !== e && !bt.isEmptyObject(e)
        }
    };
    var Mt = new g,
        qt = new g,
        Bt = /^(?:\{[\w\W]*\}|\[[\w\W]*\])$/,
        Rt = /[A-Z]/g;
    bt.extend({
        hasData: function(t) {
            return qt.hasData(t) || Mt.hasData(t)
        },
        data: function(t, e, n) {
            return qt.access(t, e, n)
        },
        removeData: function(t, e) {
            qt.remove(t, e)
        },
        _data: function(t, e, n) {
            return Mt.access(t, e, n)
        },
        _removeData: function(t, e) {
            Mt.remove(t, e)
        }
    }), bt.fn.extend({
        data: function(t, e) {
            var n, i, r, o = this[0],
                s = o && o.attributes;
            if (void 0 === t) {
                if (this.length && (r = qt.get(o), 1 === o.nodeType && !Mt.get(o, "hasDataAttrs"))) {
                    for (n = s.length; n--;) s[n] && 0 === (i = s[n].name).indexOf("data-") && (i = f(i.slice(5)), v(o, i, r[i]));
                    Mt.set(o, "hasDataAttrs", !0)
                }
                return r
            }
            return "object" == typeof t ? this.each(function() {
                qt.set(this, t)
            }) : Pt(this, function(e) {
                var n;
                if (o && void 0 === e) {
                    if (void 0 !== (n = qt.get(o, t))) return n;
                    if (void 0 !== (n = v(o, t))) return n
                } else this.each(function() {
                    qt.set(this, t, e)
                })
            }, null, e, arguments.length > 1, null, !0)
        },
        removeData: function(t) {
            return this.each(function() {
                qt.remove(this, t)
            })
        }
    }), bt.extend({
        queue: function(t, e, n) {
            var i;
            if (t) return e = (e || "fx") + "queue", i = Mt.get(t, e), n && (!i || Array.isArray(n) ? i = Mt.access(t, e, bt.makeArray(n)) : i.push(n)), i || []
        },
        dequeue: function(t, e) {
            e = e || "fx";
            var n = bt.queue(t, e),
                i = n.length,
                r = n.shift(),
                o = bt._queueHooks(t, e),
                s = function() {
                    bt.dequeue(t, e)
                };
            "inprogress" === r && (r = n.shift(), i--), r && ("fx" === e && n.unshift("inprogress"), delete o.stop, r.call(t, s, o)), !i && o && o.empty.fire()
        },
        _queueHooks: function(t, e) {
            var n = e + "queueHooks";
            return Mt.get(t, n) || Mt.access(t, n, {
                empty: bt.Callbacks("once memory").add(function() {
                    Mt.remove(t, [e + "queue", n])
                })
            })
        }
    }), bt.fn.extend({
        queue: function(t, e) {
            var n = 2;
            return "string" != typeof t && (e = t, t = "fx", n--), arguments.length < n ? bt.queue(this[0], t) : void 0 === e ? this : this.each(function() {
                var n = bt.queue(this, t, e);
                bt._queueHooks(this, t), "fx" === t && "inprogress" !== n[0] && bt.dequeue(this, t)
            })
        },
        dequeue: function(t) {
            return this.each(function() {
                bt.dequeue(this, t)
            })
        },
        clearQueue: function(t) {
            return this.queue(t || "fx", [])
        },
        promise: function(t, e) {
            var n, i = 1,
                r = bt.Deferred(),
                o = this,
                s = this.length,
                a = function() {
                    --i || r.resolveWith(o, [o])
                };
            for ("string" != typeof t && (e = t, t = void 0), t = t || "fx"; s--;)(n = Mt.get(o[s], t + "queueHooks")) && n.empty && (i++, n.empty.add(a));
            return a(), r.promise(e)
        }
    });
    var Wt = /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source,
        Ft = new RegExp("^(?:([+-])=|)(" + Wt + ")([a-z%]*)$", "i"),
        Xt = ["Top", "Right", "Bottom", "Left"],
        Ut = function(t, e) {
            return "none" === (t = e || t).style.display || "" === t.style.display && bt.contains(t.ownerDocument, t) && "none" === bt.css(t, "display")
        },
        Yt = function(t, e, n, i) {
            var r, o, s = {};
            for (o in e) s[o] = t.style[o], t.style[o] = e[o];
            r = n.apply(t, i || []);
            for (o in e) t.style[o] = s[o];
            return r
        },
        Qt = {};
    bt.fn.extend({
        show: function() {
            return x(this, !0)
        },
        hide: function() {
            return x(this)
        },
        toggle: function(t) {
            return "boolean" == typeof t ? t ? this.show() : this.hide() : this.each(function() {
                Ut(this) ? bt(this).show() : bt(this).hide()
            })
        }
    });
    var Vt = /^(?:checkbox|radio)$/i,
        Zt = /<([a-z][^\/\0>\x20\t\r\n\f]+)/i,
        Gt = /^$|^module$|\/(?:java|ecma)script/i,
        Kt = {
            option: [1, "<select multiple='multiple'>", "</select>"],
            thead: [1, "<table>", "</table>"],
            col: [2, "<table><colgroup>", "</colgroup></table>"],
            tr: [2, "<table><tbody>", "</tbody></table>"],
            td: [3, "<table><tbody><tr>", "</tr></tbody></table>"],
            _default: [0, "", ""]
        };
    Kt.optgroup = Kt.option, Kt.tbody = Kt.tfoot = Kt.colgroup = Kt.caption = Kt.thead, Kt.th = Kt.td;
    var Jt = /<|&#?\w+;/;
    ! function() {
        var t = st.createDocumentFragment().appendChild(st.createElement("div")),
            e = st.createElement("input");
        e.setAttribute("type", "radio"), e.setAttribute("checked", "checked"), e.setAttribute("name", "t"), t.appendChild(e), vt.checkClone = t.cloneNode(!0).cloneNode(!0).lastChild.checked, t.innerHTML = "<textarea>x</textarea>", vt.noCloneChecked = !!t.cloneNode(!0).lastChild.defaultValue
    }();
    var te = st.documentElement,
        ee = /^key/,
        ne = /^(?:mouse|pointer|contextmenu|drag|drop)|click/,
        ie = /^([^.]*)(?:\.(.+)|)/;
    bt.event = {
        global: {},
        add: function(t, e, n, i, r) {
            var o, s, a, l, u, c, p, h, d, f, g, m = Mt.get(t);
            if (m)
                for (n.handler && (n = (o = n).handler, r = o.selector), r && bt.find.matchesSelector(te, r), n.guid || (n.guid = bt.guid++), (l = m.events) || (l = m.events = {}), (s = m.handle) || (s = m.handle = function(e) {
                        return void 0 !== bt && bt.event.triggered !== e.type ? bt.event.dispatch.apply(t, arguments) : void 0
                    }), u = (e = (e || "").match($t) || [""]).length; u--;) d = g = (a = ie.exec(e[u]) || [])[1], f = (a[2] || "").split(".").sort(), d && (p = bt.event.special[d] || {}, d = (r ? p.delegateType : p.bindType) || d, p = bt.event.special[d] || {}, c = bt.extend({
                    type: d,
                    origType: g,
                    data: i,
                    handler: n,
                    guid: n.guid,
                    selector: r,
                    needsContext: r && bt.expr.match.needsContext.test(r),
                    namespace: f.join(".")
                }, o), (h = l[d]) || ((h = l[d] = []).delegateCount = 0, p.setup && !1 !== p.setup.call(t, i, f, s) || t.addEventListener && t.addEventListener(d, s)), p.add && (p.add.call(t, c), c.handler.guid || (c.handler.guid = n.guid)), r ? h.splice(h.delegateCount++, 0, c) : h.push(c), bt.event.global[d] = !0)
        },
        remove: function(t, e, n, i, r) {
            var o, s, a, l, u, c, p, h, d, f, g, m = Mt.hasData(t) && Mt.get(t);
            if (m && (l = m.events)) {
                for (u = (e = (e || "").match($t) || [""]).length; u--;)
                    if (a = ie.exec(e[u]) || [], d = g = a[1], f = (a[2] || "").split(".").sort(), d) {
                        for (p = bt.event.special[d] || {}, h = l[d = (i ? p.delegateType : p.bindType) || d] || [], a = a[2] && new RegExp("(^|\\.)" + f.join("\\.(?:.*\\.|)") + "(\\.|$)"), s = o = h.length; o--;) c = h[o], !r && g !== c.origType || n && n.guid !== c.guid || a && !a.test(c.namespace) || i && i !== c.selector && ("**" !== i || !c.selector) || (h.splice(o, 1), c.selector && h.delegateCount--, p.remove && p.remove.call(t, c));
                        s && !h.length && (p.teardown && !1 !== p.teardown.call(t, f, m.handle) || bt.removeEvent(t, d, m.handle), delete l[d])
                    } else
                        for (d in l) bt.event.remove(t, d + e[u], n, i, !0);
                bt.isEmptyObject(l) && Mt.remove(t, "handle events")
            }
        },
        dispatch: function(t) {
            var e, n, i, r, o, s, a = bt.event.fix(t),
                l = new Array(arguments.length),
                u = (Mt.get(this, "events") || {})[a.type] || [],
                c = bt.event.special[a.type] || {};
            for (l[0] = a, e = 1; e < arguments.length; e++) l[e] = arguments[e];
            if (a.delegateTarget = this, !c.preDispatch || !1 !== c.preDispatch.call(this, a)) {
                for (s = bt.event.handlers.call(this, a, u), e = 0;
                    (r = s[e++]) && !a.isPropagationStopped();)
                    for (a.currentTarget = r.elem, n = 0;
                        (o = r.handlers[n++]) && !a.isImmediatePropagationStopped();) a.rnamespace && !a.rnamespace.test(o.namespace) || (a.handleObj = o, a.data = o.data, void 0 !== (i = ((bt.event.special[o.origType] || {}).handle || o.handler).apply(r.elem, l)) && !1 === (a.result = i) && (a.preventDefault(), a.stopPropagation()));
                return c.postDispatch && c.postDispatch.call(this, a), a.result
            }
        },
        handlers: function(t, e) {
            var n, i, r, o, s, a = [],
                l = e.delegateCount,
                u = t.target;
            if (l && u.nodeType && !("click" === t.type && t.button >= 1))
                for (; u !== this; u = u.parentNode || this)
                    if (1 === u.nodeType && ("click" !== t.type || !0 !== u.disabled)) {
                        for (o = [], s = {}, n = 0; n < l; n++) void 0 === s[r = (i = e[n]).selector + " "] && (s[r] = i.needsContext ? bt(r, this).index(u) > -1 : bt.find(r, this, null, [u]).length), s[r] && o.push(i);
                        o.length && a.push({
                            elem: u,
                            handlers: o
                        })
                    } return u = this, l < e.length && a.push({
                elem: u,
                handlers: e.slice(l)
            }), a
        },
        addProp: function(t, e) {
            Object.defineProperty(bt.Event.prototype, t, {
                enumerable: !0,
                configurable: !0,
                get: yt(e) ? function() {
                    if (this.originalEvent) return e(this.originalEvent)
                } : function() {
                    if (this.originalEvent) return this.originalEvent[t]
                },
                set: function(e) {
                    Object.defineProperty(this, t, {
                        enumerable: !0,
                        configurable: !0,
                        writable: !0,
                        value: e
                    })
                }
            })
        },
        fix: function(t) {
            return t[bt.expando] ? t : new bt.Event(t)
        },
        special: {
            load: {
                noBubble: !0
            },
            focus: {
                trigger: function() {
                    if (this !== k() && this.focus) return this.focus(), !1
                },
                delegateType: "focusin"
            },
            blur: {
                trigger: function() {
                    if (this === k() && this.blur) return this.blur(), !1
                },
                delegateType: "focusout"
            },
            click: {
                trigger: function() {
                    if ("checkbox" === this.type && this.click && o(this, "input")) return this.click(), !1
                },
                _default: function(t) {
                    return o(t.target, "a")
                }
            },
            beforeunload: {
                postDispatch: function(t) {
                    void 0 !== t.result && t.originalEvent && (t.originalEvent.returnValue = t.result)
                }
            }
        }
    }, bt.removeEvent = function(t, e, n) {
        t.removeEventListener && t.removeEventListener(e, n)
    }, bt.Event = function(t, e) {
        if (!(this instanceof bt.Event)) return new bt.Event(t, e);
        t && t.type ? (this.originalEvent = t, this.type = t.type, this.isDefaultPrevented = t.defaultPrevented || void 0 === t.defaultPrevented && !1 === t.returnValue ? T : E, this.target = t.target && 3 === t.target.nodeType ? t.target.parentNode : t.target, this.currentTarget = t.currentTarget, this.relatedTarget = t.relatedTarget) : this.type = t, e && bt.extend(this, e), this.timeStamp = t && t.timeStamp || Date.now(), this[bt.expando] = !0
    }, bt.Event.prototype = {
        constructor: bt.Event,
        isDefaultPrevented: E,
        isPropagationStopped: E,
        isImmediatePropagationStopped: E,
        isSimulated: !1,
        preventDefault: function() {
            var t = this.originalEvent;
            this.isDefaultPrevented = T, t && !this.isSimulated && t.preventDefault()
        },
        stopPropagation: function() {
            var t = this.originalEvent;
            this.isPropagationStopped = T, t && !this.isSimulated && t.stopPropagation()
        },
        stopImmediatePropagation: function() {
            var t = this.originalEvent;
            this.isImmediatePropagationStopped = T, t && !this.isSimulated && t.stopImmediatePropagation(), this.stopPropagation()
        }
    }, bt.each({
        altKey: !0,
        bubbles: !0,
        cancelable: !0,
        changedTouches: !0,
        ctrlKey: !0,
        detail: !0,
        eventPhase: !0,
        metaKey: !0,
        pageX: !0,
        pageY: !0,
        shiftKey: !0,
        view: !0,
        char: !0,
        charCode: !0,
        key: !0,
        keyCode: !0,
        button: !0,
        buttons: !0,
        clientX: !0,
        clientY: !0,
        offsetX: !0,
        offsetY: !0,
        pointerId: !0,
        pointerType: !0,
        screenX: !0,
        screenY: !0,
        targetTouches: !0,
        toElement: !0,
        touches: !0,
        which: function(t) {
            var e = t.button;
            return null == t.which && ee.test(t.type) ? null != t.charCode ? t.charCode : t.keyCode : !t.which && void 0 !== e && ne.test(t.type) ? 1 & e ? 1 : 2 & e ? 3 : 4 & e ? 2 : 0 : t.which
        }
    }, bt.event.addProp), bt.each({
        mouseenter: "mouseover",
        mouseleave: "mouseout",
        pointerenter: "pointerover",
        pointerleave: "pointerout"
    }, function(t, e) {
        bt.event.special[t] = {
            delegateType: e,
            bindType: e,
            handle: function(t) {
                var n, i = this,
                    r = t.relatedTarget,
                    o = t.handleObj;
                return r && (r === i || bt.contains(i, r)) || (t.type = o.origType, n = o.handler.apply(this, arguments), t.type = e), n
            }
        }
    }), bt.fn.extend({
        on: function(t, e, n, i) {
            return S(this, t, e, n, i)
        },
        one: function(t, e, n, i) {
            return S(this, t, e, n, i, 1)
        },
        off: function(t, e, n) {
            var i, r;
            if (t && t.preventDefault && t.handleObj) return i = t.handleObj, bt(t.delegateTarget).off(i.namespace ? i.origType + "." + i.namespace : i.origType, i.selector, i.handler), this;
            if ("object" == typeof t) {
                for (r in t) this.off(r, e, t[r]);
                return this
            }
            return !1 !== e && "function" != typeof e || (n = e, e = void 0), !1 === n && (n = E), this.each(function() {
                bt.event.remove(this, t, n, e)
            })
        }
    });
    var re = /<(?!area|br|col|embed|hr|img|input|link|meta|param)(([a-z][^\/\0>\x20\t\r\n\f]*)[^>]*)\/>/gi,
        oe = /<script|<style|<link/i,
        se = /checked\s*(?:[^=]|=\s*.checked.)/i,
        ae = /^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g;
    bt.extend({
        htmlPrefilter: function(t) {
            return t.replace(re, "<$1></$2>")
        },
        clone: function(t, e, n) {
            var i, r, o, s, a = t.cloneNode(!0),
                l = bt.contains(t.ownerDocument, t);
            if (!(vt.noCloneChecked || 1 !== t.nodeType && 11 !== t.nodeType || bt.isXMLDoc(t)))
                for (s = b(a), i = 0, r = (o = b(t)).length; i < r; i++) $(o[i], s[i]);
            if (e)
                if (n)
                    for (o = o || b(t), s = s || b(a), i = 0, r = o.length; i < r; i++) O(o[i], s[i]);
                else O(t, a);
            return (s = b(a, "script")).length > 0 && _(s, !l && b(t, "script")), a
        },
        cleanData: function(t) {
            for (var e, n, i, r = bt.event.special, o = 0; void 0 !== (n = t[o]); o++)
                if (Ht(n)) {
                    if (e = n[Mt.expando]) {
                        if (e.events)
                            for (i in e.events) r[i] ? bt.event.remove(n, i) : bt.removeEvent(n, i, e.handle);
                        n[Mt.expando] = void 0
                    }
                    n[qt.expando] && (n[qt.expando] = void 0)
                }
        }
    }), bt.fn.extend({
        detach: function(t) {
            return I(this, t, !0)
        },
        remove: function(t) {
            return I(this, t)
        },
        text: function(t) {
            return Pt(this, function(t) {
                return void 0 === t ? bt.text(this) : this.empty().each(function() {
                    1 !== this.nodeType && 11 !== this.nodeType && 9 !== this.nodeType || (this.textContent = t)
                })
            }, null, t, arguments.length)
        },
        append: function() {
            return z(this, arguments, function(t) {
                1 !== this.nodeType && 11 !== this.nodeType && 9 !== this.nodeType || A(this, t).appendChild(t)
            })
        },
        prepend: function() {
            return z(this, arguments, function(t) {
                if (1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) {
                    var e = A(this, t);
                    e.insertBefore(t, e.firstChild)
                }
            })
        },
        before: function() {
            return z(this, arguments, function(t) {
                this.parentNode && this.parentNode.insertBefore(t, this)
            })
        },
        after: function() {
            return z(this, arguments, function(t) {
                this.parentNode && this.parentNode.insertBefore(t, this.nextSibling)
            })
        },
        empty: function() {
            for (var t, e = 0; null != (t = this[e]); e++) 1 === t.nodeType && (bt.cleanData(b(t, !1)), t.textContent = "");
            return this
        },
        clone: function(t, e) {
            return t = null != t && t, e = null == e ? t : e, this.map(function() {
                return bt.clone(this, t, e)
            })
        },
        html: function(t) {
            return Pt(this, function(t) {
                var e = this[0] || {},
                    n = 0,
                    i = this.length;
                if (void 0 === t && 1 === e.nodeType) return e.innerHTML;
                if ("string" == typeof t && !oe.test(t) && !Kt[(Zt.exec(t) || ["", ""])[1].toLowerCase()]) {
                    t = bt.htmlPrefilter(t);
                    try {
                        for (; n < i; n++) 1 === (e = this[n] || {}).nodeType && (bt.cleanData(b(e, !1)), e.innerHTML = t);
                        e = 0
                    } catch (t) {}
                }
                e && this.empty().append(t)
            }, null, t, arguments.length)
        },
        replaceWith: function() {
            var t = [];
            return z(this, arguments, function(e) {
                var n = this.parentNode;
                bt.inArray(this, t) < 0 && (bt.cleanData(b(this)), n && n.replaceChild(e, this))
            }, t)
        }
    }), bt.each({
        appendTo: "append",
        prependTo: "prepend",
        insertBefore: "before",
        insertAfter: "after",
        replaceAll: "replaceWith"
    }, function(t, e) {
        bt.fn[t] = function(t) {
            for (var n, i = [], r = bt(t), o = r.length - 1, s = 0; s <= o; s++) n = s === o ? this : this.clone(!0), bt(r[s])[e](n), ct.apply(i, n.get());
            return this.pushStack(i)
        }
    });
    var le = new RegExp("^(" + Wt + ")(?!px)[a-z%]+$", "i"),
        ue = function(e) {
            var n = e.ownerDocument.defaultView;
            return n && n.opener || (n = t), n.getComputedStyle(e)
        },
        ce = new RegExp(Xt.join("|"), "i");
    ! function() {
        function e() {
            if (u) {
                l.style.cssText = "position:absolute;left:-11111px;width:60px;margin-top:1px;padding:0;border:0", u.style.cssText = "position:relative;display:block;box-sizing:border-box;overflow:scroll;margin:auto;border:1px;padding:1px;width:60%;top:1%", te.appendChild(l).appendChild(u);
                var e = t.getComputedStyle(u);
                i = "1%" !== e.top, a = 12 === n(e.marginLeft), u.style.right = "60%", s = 36 === n(e.right), r = 36 === n(e.width), u.style.position = "absolute", o = 36 === u.offsetWidth || "absolute", te.removeChild(l), u = null
            }
        }

        function n(t) {
            return Math.round(parseFloat(t))
        }
        var i, r, o, s, a, l = st.createElement("div"),
            u = st.createElement("div");
        u.style && (u.style.backgroundClip = "content-box", u.cloneNode(!0).style.backgroundClip = "", vt.clearCloneStyle = "content-box" === u.style.backgroundClip, bt.extend(vt, {
            boxSizingReliable: function() {
                return e(), r
            },
            pixelBoxStyles: function() {
                return e(), s
            },
            pixelPosition: function() {
                return e(), i
            },
            reliableMarginLeft: function() {
                return e(), a
            },
            scrollboxSize: function() {
                return e(), o
            }
        }))
    }();
    var pe = /^(none|table(?!-c[ea]).+)/,
        he = /^--/,
        de = {
            position: "absolute",
            visibility: "hidden",
            display: "block"
        },
        fe = {
            letterSpacing: "0",
            fontWeight: "400"
        },
        ge = ["Webkit", "Moz", "ms"],
        me = st.createElement("div").style;
    bt.extend({
        cssHooks: {
            opacity: {
                get: function(t, e) {
                    if (e) {
                        var n = P(t, "opacity");
                        return "" === n ? "1" : n
                    }
                }
            }
        },
        cssNumber: {
            animationIterationCount: !0,
            columnCount: !0,
            fillOpacity: !0,
            flexGrow: !0,
            flexShrink: !0,
            fontWeight: !0,
            lineHeight: !0,
            opacity: !0,
            order: !0,
            orphans: !0,
            widows: !0,
            zIndex: !0,
            zoom: !0
        },
        cssProps: {},
        style: function(t, e, n, i) {
            if (t && 3 !== t.nodeType && 8 !== t.nodeType && t.style) {
                var r, o, s, a = f(e),
                    l = he.test(e),
                    u = t.style;
                if (l || (e = H(a)), s = bt.cssHooks[e] || bt.cssHooks[a], void 0 === n) return s && "get" in s && void 0 !== (r = s.get(t, !1, i)) ? r : u[e];
                "string" == (o = typeof n) && (r = Ft.exec(n)) && r[1] && (n = y(t, e, r), o = "number"), null != n && n === n && ("number" === o && (n += r && r[3] || (bt.cssNumber[a] ? "" : "px")), vt.clearCloneStyle || "" !== n || 0 !== e.indexOf("background") || (u[e] = "inherit"), s && "set" in s && void 0 === (n = s.set(t, n, i)) || (l ? u.setProperty(e, n) : u[e] = n))
            }
        },
        css: function(t, e, n, i) {
            var r, o, s, a = f(e);
            return he.test(e) || (e = H(a)), (s = bt.cssHooks[e] || bt.cssHooks[a]) && "get" in s && (r = s.get(t, !0, n)), void 0 === r && (r = P(t, e, i)), "normal" === r && e in fe && (r = fe[e]), "" === n || n ? (o = parseFloat(r), !0 === n || isFinite(o) ? o || 0 : r) : r
        }
    }), bt.each(["height", "width"], function(t, e) {
        bt.cssHooks[e] = {
            get: function(t, n, i) {
                if (n) return !pe.test(bt.css(t, "display")) || t.getClientRects().length && t.getBoundingClientRect().width ? B(t, e, i) : Yt(t, de, function() {
                    return B(t, e, i)
                })
            },
            set: function(t, n, i) {
                var r, o = ue(t),
                    s = "border-box" === bt.css(t, "boxSizing", !1, o),
                    a = i && q(t, e, i, s, o);
                return s && vt.scrollboxSize() === o.position && (a -= Math.ceil(t["offset" + e[0].toUpperCase() + e.slice(1)] - parseFloat(o[e]) - q(t, e, "border", !1, o) - .5)), a && (r = Ft.exec(n)) && "px" !== (r[3] || "px") && (t.style[e] = n, n = bt.css(t, e)), M(t, n, a)
            }
        }
    }), bt.cssHooks.marginLeft = N(vt.reliableMarginLeft, function(t, e) {
        if (e) return (parseFloat(P(t, "marginLeft")) || t.getBoundingClientRect().left - Yt(t, {
            marginLeft: 0
        }, function() {
            return t.getBoundingClientRect().left
        })) + "px"
    }), bt.each({
        margin: "",
        padding: "",
        border: "Width"
    }, function(t, e) {
        bt.cssHooks[t + e] = {
            expand: function(n) {
                for (var i = 0, r = {}, o = "string" == typeof n ? n.split(" ") : [n]; i < 4; i++) r[t + Xt[i] + e] = o[i] || o[i - 2] || o[0];
                return r
            }
        }, "margin" !== t && (bt.cssHooks[t + e].set = M)
    }), bt.fn.extend({
        css: function(t, e) {
            return Pt(this, function(t, e, n) {
                var i, r, o = {},
                    s = 0;
                if (Array.isArray(e)) {
                    for (i = ue(t), r = e.length; s < r; s++) o[e[s]] = bt.css(t, e[s], !1, i);
                    return o
                }
                return void 0 !== n ? bt.style(t, e, n) : bt.css(t, e)
            }, t, e, arguments.length > 1)
        }
    }), bt.Tween = R, R.prototype = {
        constructor: R,
        init: function(t, e, n, i, r, o) {
            this.elem = t, this.prop = n, this.easing = r || bt.easing._default, this.options = e, this.start = this.now = this.cur(), this.end = i, this.unit = o || (bt.cssNumber[n] ? "" : "px")
        },
        cur: function() {
            var t = R.propHooks[this.prop];
            return t && t.get ? t.get(this) : R.propHooks._default.get(this)
        },
        run: function(t) {
            var e, n = R.propHooks[this.prop];
            return this.options.duration ? this.pos = e = bt.easing[this.easing](t, this.options.duration * t, 0, 1, this.options.duration) : this.pos = e = t, this.now = (this.end - this.start) * e + this.start, this.options.step && this.options.step.call(this.elem, this.now, this), n && n.set ? n.set(this) : R.propHooks._default.set(this), this
        }
    }, R.prototype.init.prototype = R.prototype, R.propHooks = {
        _default: {
            get: function(t) {
                var e;
                return 1 !== t.elem.nodeType || null != t.elem[t.prop] && null == t.elem.style[t.prop] ? t.elem[t.prop] : (e = bt.css(t.elem, t.prop, "")) && "auto" !== e ? e : 0
            },
            set: function(t) {
                bt.fx.step[t.prop] ? bt.fx.step[t.prop](t) : 1 !== t.elem.nodeType || null == t.elem.style[bt.cssProps[t.prop]] && !bt.cssHooks[t.prop] ? t.elem[t.prop] = t.now : bt.style(t.elem, t.prop, t.now + t.unit)
            }
        }
    }, R.propHooks.scrollTop = R.propHooks.scrollLeft = {
        set: function(t) {
            t.elem.nodeType && t.elem.parentNode && (t.elem[t.prop] = t.now)
        }
    }, bt.easing = {
        linear: function(t) {
            return t
        },
        swing: function(t) {
            return .5 - Math.cos(t * Math.PI) / 2
        },
        _default: "swing"
    }, bt.fx = R.prototype.init, bt.fx.step = {};
    var ve, ye, we = /^(?:toggle|show|hide)$/,
        xe = /queueHooks$/;
    bt.Animation = bt.extend(V, {
            tweeners: {
                "*": [function(t, e) {
                    var n = this.createTween(t, e);
                    return y(n.elem, t, Ft.exec(e), n), n
                }]
            },
            tweener: function(t, e) {
                yt(t) ? (e = t, t = ["*"]) : t = t.match($t);
                for (var n, i = 0, r = t.length; i < r; i++) n = t[i], V.tweeners[n] = V.tweeners[n] || [], V.tweeners[n].unshift(e)
            },
            prefilters: [Y],
            prefilter: function(t, e) {
                e ? V.prefilters.unshift(t) : V.prefilters.push(t)
            }
        }), bt.speed = function(t, e, n) {
            var i = t && "object" == typeof t ? bt.extend({}, t) : {
                complete: n || !n && e || yt(t) && t,
                duration: t,
                easing: n && e || e && !yt(e) && e
            };
            return bt.fx.off ? i.duration = 0 : "number" != typeof i.duration && (i.duration in bt.fx.speeds ? i.duration = bt.fx.speeds[i.duration] : i.duration = bt.fx.speeds._default), null != i.queue && !0 !== i.queue || (i.queue = "fx"), i.old = i.complete, i.complete = function() {
                yt(i.old) && i.old.call(this), i.queue && bt.dequeue(this, i.queue)
            }, i
        }, bt.fn.extend({
            fadeTo: function(t, e, n, i) {
                return this.filter(Ut).css("opacity", 0).show().end().animate({
                    opacity: e
                }, t, n, i)
            },
            animate: function(t, e, n, i) {
                var r = bt.isEmptyObject(t),
                    o = bt.speed(e, n, i),
                    s = function() {
                        var e = V(this, bt.extend({}, t), o);
                        (r || Mt.get(this, "finish")) && e.stop(!0)
                    };
                return s.finish = s, r || !1 === o.queue ? this.each(s) : this.queue(o.queue, s)
            },
            stop: function(t, e, n) {
                var i = function(t) {
                    var e = t.stop;
                    delete t.stop, e(n)
                };
                return "string" != typeof t && (n = e, e = t, t = void 0), e && !1 !== t && this.queue(t || "fx", []), this.each(function() {
                    var e = !0,
                        r = null != t && t + "queueHooks",
                        o = bt.timers,
                        s = Mt.get(this);
                    if (r) s[r] && s[r].stop && i(s[r]);
                    else
                        for (r in s) s[r] && s[r].stop && xe.test(r) && i(s[r]);
                    for (r = o.length; r--;) o[r].elem !== this || null != t && o[r].queue !== t || (o[r].anim.stop(n), e = !1, o.splice(r, 1));
                    !e && n || bt.dequeue(this, t)
                })
            },
            finish: function(t) {
                return !1 !== t && (t = t || "fx"), this.each(function() {
                    var e, n = Mt.get(this),
                        i = n[t + "queue"],
                        r = n[t + "queueHooks"],
                        o = bt.timers,
                        s = i ? i.length : 0;
                    for (n.finish = !0, bt.queue(this, t, []), r && r.stop && r.stop.call(this, !0), e = o.length; e--;) o[e].elem === this && o[e].queue === t && (o[e].anim.stop(!0), o.splice(e, 1));
                    for (e = 0; e < s; e++) i[e] && i[e].finish && i[e].finish.call(this);
                    delete n.finish
                })
            }
        }), bt.each(["toggle", "show", "hide"], function(t, e) {
            var n = bt.fn[e];
            bt.fn[e] = function(t, i, r) {
                return null == t || "boolean" == typeof t ? n.apply(this, arguments) : this.animate(X(e, !0), t, i, r)
            }
        }), bt.each({
            slideDown: X("show"),
            slideUp: X("hide"),
            slideToggle: X("toggle"),
            fadeIn: {
                opacity: "show"
            },
            fadeOut: {
                opacity: "hide"
            },
            fadeToggle: {
                opacity: "toggle"
            }
        }, function(t, e) {
            bt.fn[t] = function(t, n, i) {
                return this.animate(e, t, n, i)
            }
        }), bt.timers = [], bt.fx.tick = function() {
            var t, e = 0,
                n = bt.timers;
            for (ve = Date.now(); e < n.length; e++)(t = n[e])() || n[e] !== t || n.splice(e--, 1);
            n.length || bt.fx.stop(), ve = void 0
        }, bt.fx.timer = function(t) {
            bt.timers.push(t), bt.fx.start()
        }, bt.fx.interval = 13, bt.fx.start = function() {
            ye || (ye = !0, W())
        }, bt.fx.stop = function() {
            ye = null
        }, bt.fx.speeds = {
            slow: 600,
            fast: 200,
            _default: 400
        }, bt.fn.delay = function(e, n) {
            return e = bt.fx ? bt.fx.speeds[e] || e : e, n = n || "fx", this.queue(n, function(n, i) {
                var r = t.setTimeout(n, e);
                i.stop = function() {
                    t.clearTimeout(r)
                }
            })
        },
        function() {
            var t = st.createElement("input"),
                e = st.createElement("select").appendChild(st.createElement("option"));
            t.type = "checkbox", vt.checkOn = "" !== t.value, vt.optSelected = e.selected, (t = st.createElement("input")).value = "t", t.type = "radio", vt.radioValue = "t" === t.value
        }();
    var be, _e = bt.expr.attrHandle;
    bt.fn.extend({
        attr: function(t, e) {
            return Pt(this, bt.attr, t, e, arguments.length > 1)
        },
        removeAttr: function(t) {
            return this.each(function() {
                bt.removeAttr(this, t)
            })
        }
    }), bt.extend({
        attr: function(t, e, n) {
            var i, r, o = t.nodeType;
            if (3 !== o && 8 !== o && 2 !== o) return void 0 === t.getAttribute ? bt.prop(t, e, n) : (1 === o && bt.isXMLDoc(t) || (r = bt.attrHooks[e.toLowerCase()] || (bt.expr.match.bool.test(e) ? be : void 0)), void 0 !== n ? null === n ? void bt.removeAttr(t, e) : r && "set" in r && void 0 !== (i = r.set(t, n, e)) ? i : (t.setAttribute(e, n + ""), n) : r && "get" in r && null !== (i = r.get(t, e)) ? i : null == (i = bt.find.attr(t, e)) ? void 0 : i)
        },
        attrHooks: {
            type: {
                set: function(t, e) {
                    if (!vt.radioValue && "radio" === e && o(t, "input")) {
                        var n = t.value;
                        return t.setAttribute("type", e), n && (t.value = n), e
                    }
                }
            }
        },
        removeAttr: function(t, e) {
            var n, i = 0,
                r = e && e.match($t);
            if (r && 1 === t.nodeType)
                for (; n = r[i++];) t.removeAttribute(n)
        }
    }), be = {
        set: function(t, e, n) {
            return !1 === e ? bt.removeAttr(t, n) : t.setAttribute(n, n), n
        }
    }, bt.each(bt.expr.match.bool.source.match(/\w+/g), function(t, e) {
        var n = _e[e] || bt.find.attr;
        _e[e] = function(t, e, i) {
            var r, o, s = e.toLowerCase();
            return i || (o = _e[s], _e[s] = r, r = null != n(t, e, i) ? s : null, _e[s] = o), r
        }
    });
    var Ce = /^(?:input|select|textarea|button)$/i,
        Te = /^(?:a|area)$/i;
    bt.fn.extend({
        prop: function(t, e) {
            return Pt(this, bt.prop, t, e, arguments.length > 1)
        },
        removeProp: function(t) {
            return this.each(function() {
                delete this[bt.propFix[t] || t]
            })
        }
    }), bt.extend({
        prop: function(t, e, n) {
            var i, r, o = t.nodeType;
            if (3 !== o && 8 !== o && 2 !== o) return 1 === o && bt.isXMLDoc(t) || (e = bt.propFix[e] || e, r = bt.propHooks[e]), void 0 !== n ? r && "set" in r && void 0 !== (i = r.set(t, n, e)) ? i : t[e] = n : r && "get" in r && null !== (i = r.get(t, e)) ? i : t[e]
        },
        propHooks: {
            tabIndex: {
                get: function(t) {
                    var e = bt.find.attr(t, "tabindex");
                    return e ? parseInt(e, 10) : Ce.test(t.nodeName) || Te.test(t.nodeName) && t.href ? 0 : -1
                }
            }
        },
        propFix: {
            for: "htmlFor",
            class: "className"
        }
    }), vt.optSelected || (bt.propHooks.selected = {
        get: function(t) {
            var e = t.parentNode;
            return e && e.parentNode && e.parentNode.selectedIndex, null
        },
        set: function(t) {
            var e = t.parentNode;
            e && (e.selectedIndex, e.parentNode && e.parentNode.selectedIndex)
        }
    }), bt.each(["tabIndex", "readOnly", "maxLength", "cellSpacing", "cellPadding", "rowSpan", "colSpan", "useMap", "frameBorder", "contentEditable"], function() {
        bt.propFix[this.toLowerCase()] = this
    }), bt.fn.extend({
        addClass: function(t) {
            var e, n, i, r, o, s, a, l = 0;
            if (yt(t)) return this.each(function(e) {
                bt(this).addClass(t.call(this, e, G(this)))
            });
            if ((e = K(t)).length)
                for (; n = this[l++];)
                    if (r = G(n), i = 1 === n.nodeType && " " + Z(r) + " ") {
                        for (s = 0; o = e[s++];) i.indexOf(" " + o + " ") < 0 && (i += o + " ");
                        r !== (a = Z(i)) && n.setAttribute("class", a)
                    } return this
        },
        removeClass: function(t) {
            var e, n, i, r, o, s, a, l = 0;
            if (yt(t)) return this.each(function(e) {
                bt(this).removeClass(t.call(this, e, G(this)))
            });
            if (!arguments.length) return this.attr("class", "");
            if ((e = K(t)).length)
                for (; n = this[l++];)
                    if (r = G(n), i = 1 === n.nodeType && " " + Z(r) + " ") {
                        for (s = 0; o = e[s++];)
                            for (; i.indexOf(" " + o + " ") > -1;) i = i.replace(" " + o + " ", " ");
                        r !== (a = Z(i)) && n.setAttribute("class", a)
                    } return this
        },
        toggleClass: function(t, e) {
            var n = typeof t,
                i = "string" === n || Array.isArray(t);
            return "boolean" == typeof e && i ? e ? this.addClass(t) : this.removeClass(t) : yt(t) ? this.each(function(n) {
                bt(this).toggleClass(t.call(this, n, G(this), e), e)
            }) : this.each(function() {
                var e, r, o, s;
                if (i)
                    for (r = 0, o = bt(this), s = K(t); e = s[r++];) o.hasClass(e) ? o.removeClass(e) : o.addClass(e);
                else void 0 !== t && "boolean" !== n || ((e = G(this)) && Mt.set(this, "__className__", e), this.setAttribute && this.setAttribute("class", e || !1 === t ? "" : Mt.get(this, "__className__") || ""))
            })
        },
        hasClass: function(t) {
            var e, n, i = 0;
            for (e = " " + t + " "; n = this[i++];)
                if (1 === n.nodeType && (" " + Z(G(n)) + " ").indexOf(e) > -1) return !0;
            return !1
        }
    });
    var Ee = /\r/g;
    bt.fn.extend({
        val: function(t) {
            var e, n, i, r = this[0];
            return arguments.length ? (i = yt(t), this.each(function(n) {
                var r;
                1 === this.nodeType && (null == (r = i ? t.call(this, n, bt(this).val()) : t) ? r = "" : "number" == typeof r ? r += "" : Array.isArray(r) && (r = bt.map(r, function(t) {
                    return null == t ? "" : t + ""
                })), (e = bt.valHooks[this.type] || bt.valHooks[this.nodeName.toLowerCase()]) && "set" in e && void 0 !== e.set(this, r, "value") || (this.value = r))
            })) : r ? (e = bt.valHooks[r.type] || bt.valHooks[r.nodeName.toLowerCase()]) && "get" in e && void 0 !== (n = e.get(r, "value")) ? n : "string" == typeof(n = r.value) ? n.replace(Ee, "") : null == n ? "" : n : void 0
        }
    }), bt.extend({
        valHooks: {
            option: {
                get: function(t) {
                    var e = bt.find.attr(t, "value");
                    return null != e ? e : Z(bt.text(t))
                }
            },
            select: {
                get: function(t) {
                    var e, n, i, r = t.options,
                        s = t.selectedIndex,
                        a = "select-one" === t.type,
                        l = a ? null : [],
                        u = a ? s + 1 : r.length;
                    for (i = s < 0 ? u : a ? s : 0; i < u; i++)
                        if (((n = r[i]).selected || i === s) && !n.disabled && (!n.parentNode.disabled || !o(n.parentNode, "optgroup"))) {
                            if (e = bt(n).val(), a) return e;
                            l.push(e)
                        } return l
                },
                set: function(t, e) {
                    for (var n, i, r = t.options, o = bt.makeArray(e), s = r.length; s--;)((i = r[s]).selected = bt.inArray(bt.valHooks.option.get(i), o) > -1) && (n = !0);
                    return n || (t.selectedIndex = -1), o
                }
            }
        }
    }), bt.each(["radio", "checkbox"], function() {
        bt.valHooks[this] = {
            set: function(t, e) {
                if (Array.isArray(e)) return t.checked = bt.inArray(bt(t).val(), e) > -1
            }
        }, vt.checkOn || (bt.valHooks[this].get = function(t) {
            return null === t.getAttribute("value") ? "on" : t.value
        })
    }), vt.focusin = "onfocusin" in t;
    var ke = /^(?:focusinfocus|focusoutblur)$/,
        Se = function(t) {
            t.stopPropagation()
        };
    bt.extend(bt.event, {
        trigger: function(e, n, i, r) {
            var o, s, a, l, u, c, p, h, d = [i || st],
                f = ft.call(e, "type") ? e.type : e,
                g = ft.call(e, "namespace") ? e.namespace.split(".") : [];
            if (s = h = a = i = i || st, 3 !== i.nodeType && 8 !== i.nodeType && !ke.test(f + bt.event.triggered) && (f.indexOf(".") > -1 && (f = (g = f.split(".")).shift(), g.sort()), u = f.indexOf(":") < 0 && "on" + f, e = e[bt.expando] ? e : new bt.Event(f, "object" == typeof e && e), e.isTrigger = r ? 2 : 3, e.namespace = g.join("."), e.rnamespace = e.namespace ? new RegExp("(^|\\.)" + g.join("\\.(?:.*\\.|)") + "(\\.|$)") : null, e.result = void 0, e.target || (e.target = i), n = null == n ? [e] : bt.makeArray(n, [e]), p = bt.event.special[f] || {}, r || !p.trigger || !1 !== p.trigger.apply(i, n))) {
                if (!r && !p.noBubble && !wt(i)) {
                    for (l = p.delegateType || f, ke.test(l + f) || (s = s.parentNode); s; s = s.parentNode) d.push(s), a = s;
                    a === (i.ownerDocument || st) && d.push(a.defaultView || a.parentWindow || t)
                }
                for (o = 0;
                    (s = d[o++]) && !e.isPropagationStopped();) h = s, e.type = o > 1 ? l : p.bindType || f, (c = (Mt.get(s, "events") || {})[e.type] && Mt.get(s, "handle")) && c.apply(s, n), (c = u && s[u]) && c.apply && Ht(s) && (e.result = c.apply(s, n), !1 === e.result && e.preventDefault());
                return e.type = f, r || e.isDefaultPrevented() || p._default && !1 !== p._default.apply(d.pop(), n) || !Ht(i) || u && yt(i[f]) && !wt(i) && ((a = i[u]) && (i[u] = null), bt.event.triggered = f, e.isPropagationStopped() && h.addEventListener(f, Se), i[f](), e.isPropagationStopped() && h.removeEventListener(f, Se), bt.event.triggered = void 0, a && (i[u] = a)), e.result
            }
        },
        simulate: function(t, e, n) {
            var i = bt.extend(new bt.Event, n, {
                type: t,
                isSimulated: !0
            });
            bt.event.trigger(i, null, e)
        }
    }), bt.fn.extend({
        trigger: function(t, e) {
            return this.each(function() {
                bt.event.trigger(t, e, this)
            })
        },
        triggerHandler: function(t, e) {
            var n = this[0];
            if (n) return bt.event.trigger(t, e, n, !0)
        }
    }), vt.focusin || bt.each({
        focus: "focusin",
        blur: "focusout"
    }, function(t, e) {
        var n = function(t) {
            bt.event.simulate(e, t.target, bt.event.fix(t))
        };
        bt.event.special[e] = {
            setup: function() {
                var i = this.ownerDocument || this,
                    r = Mt.access(i, e);
                r || i.addEventListener(t, n, !0), Mt.access(i, e, (r || 0) + 1)
            },
            teardown: function() {
                var i = this.ownerDocument || this,
                    r = Mt.access(i, e) - 1;
                r ? Mt.access(i, e, r) : (i.removeEventListener(t, n, !0), Mt.remove(i, e))
            }
        }
    });
    var Ae = t.location,
        je = Date.now(),
        De = /\?/;
    bt.parseXML = function(e) {
        var n;
        if (!e || "string" != typeof e) return null;
        try {
            n = (new t.DOMParser).parseFromString(e, "text/xml")
        } catch (t) {
            n = void 0
        }
        return n && !n.getElementsByTagName("parsererror").length || bt.error("Invalid XML: " + e), n
    };
    var Oe = /\[\]$/,
        $e = /\r?\n/g,
        ze = /^(?:submit|button|image|reset|file)$/i,
        Ie = /^(?:input|select|textarea|keygen)/i;
    bt.param = function(t, e) {
        var n, i = [],
            r = function(t, e) {
                var n = yt(e) ? e() : e;
                i[i.length] = encodeURIComponent(t) + "=" + encodeURIComponent(null == n ? "" : n)
            };
        if (Array.isArray(t) || t.jquery && !bt.isPlainObject(t)) bt.each(t, function() {
            r(this.name, this.value)
        });
        else
            for (n in t) J(n, t[n], e, r);
        return i.join("&")
    }, bt.fn.extend({
        serialize: function() {
            return bt.param(this.serializeArray())
        },
        serializeArray: function() {
            return this.map(function() {
                var t = bt.prop(this, "elements");
                return t ? bt.makeArray(t) : this
            }).filter(function() {
                var t = this.type;
                return this.name && !bt(this).is(":disabled") && Ie.test(this.nodeName) && !ze.test(t) && (this.checked || !Vt.test(t))
            }).map(function(t, e) {
                var n = bt(this).val();
                return null == n ? null : Array.isArray(n) ? bt.map(n, function(t) {
                    return {
                        name: e.name,
                        value: t.replace($e, "\r\n")
                    }
                }) : {
                    name: e.name,
                    value: n.replace($e, "\r\n")
                }
            }).get()
        }
    });
    var Pe = /%20/g,
        Ne = /#.*$/,
        Le = /([?&])_=[^&]*/,
        He = /^(.*?):[ \t]*([^\r\n]*)$/gm,
        Me = /^(?:about|app|app-storage|.+-extension|file|res|widget):$/,
        qe = /^(?:GET|HEAD)$/,
        Be = /^\/\//,
        Re = {},
        We = {},
        Fe = "*/".concat("*"),
        Xe = st.createElement("a");
    Xe.href = Ae.href, bt.extend({
        active: 0,
        lastModified: {},
        etag: {},
        ajaxSettings: {
            url: Ae.href,
            type: "GET",
            isLocal: Me.test(Ae.protocol),
            global: !0,
            processData: !0,
            async: !0,
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            accepts: {
                "*": Fe,
                text: "text/plain",
                html: "text/html",
                xml: "application/xml, text/xml",
                json: "application/json, text/javascript"
            },
            contents: {
                xml: /\bxml\b/,
                html: /\bhtml/,
                json: /\bjson\b/
            },
            responseFields: {
                xml: "responseXML",
                text: "responseText",
                json: "responseJSON"
            },
            converters: {
                "* text": String,
                "text html": !0,
                "text json": JSON.parse,
                "text xml": bt.parseXML
            },
            flatOptions: {
                url: !0,
                context: !0
            }
        },
        ajaxSetup: function(t, e) {
            return e ? nt(nt(t, bt.ajaxSettings), e) : nt(bt.ajaxSettings, t)
        },
        ajaxPrefilter: tt(Re),
        ajaxTransport: tt(We),
        ajax: function(e, n) {
            function i(e, n, i, a) {
                var u, h, d, x, b, _ = n;
                c || (c = !0, l && t.clearTimeout(l), r = void 0, s = a || "", C.readyState = e > 0 ? 4 : 0, u = e >= 200 && e < 300 || 304 === e, i && (x = it(f, C, i)), x = rt(f, x, C, u), u ? (f.ifModified && ((b = C.getResponseHeader("Last-Modified")) && (bt.lastModified[o] = b), (b = C.getResponseHeader("etag")) && (bt.etag[o] = b)), 204 === e || "HEAD" === f.type ? _ = "nocontent" : 304 === e ? _ = "notmodified" : (_ = x.state, h = x.data, u = !(d = x.error))) : (d = _, !e && _ || (_ = "error", e < 0 && (e = 0))), C.status = e, C.statusText = (n || _) + "", u ? v.resolveWith(g, [h, _, C]) : v.rejectWith(g, [C, _, d]), C.statusCode(w), w = void 0, p && m.trigger(u ? "ajaxSuccess" : "ajaxError", [C, f, u ? h : d]), y.fireWith(g, [C, _]), p && (m.trigger("ajaxComplete", [C, f]), --bt.active || bt.event.trigger("ajaxStop")))
            }
            "object" == typeof e && (n = e, e = void 0), n = n || {};
            var r, o, s, a, l, u, c, p, h, d, f = bt.ajaxSetup({}, n),
                g = f.context || f,
                m = f.context && (g.nodeType || g.jquery) ? bt(g) : bt.event,
                v = bt.Deferred(),
                y = bt.Callbacks("once memory"),
                w = f.statusCode || {},
                x = {},
                b = {},
                _ = "canceled",
                C = {
                    readyState: 0,
                    getResponseHeader: function(t) {
                        var e;
                        if (c) {
                            if (!a)
                                for (a = {}; e = He.exec(s);) a[e[1].toLowerCase()] = e[2];
                            e = a[t.toLowerCase()]
                        }
                        return null == e ? null : e
                    },
                    getAllResponseHeaders: function() {
                        return c ? s : null
                    },
                    setRequestHeader: function(t, e) {
                        return null == c && (t = b[t.toLowerCase()] = b[t.toLowerCase()] || t, x[t] = e), this
                    },
                    overrideMimeType: function(t) {
                        return null == c && (f.mimeType = t), this
                    },
                    statusCode: function(t) {
                        var e;
                        if (t)
                            if (c) C.always(t[C.status]);
                            else
                                for (e in t) w[e] = [w[e], t[e]];
                        return this
                    },
                    abort: function(t) {
                        var e = t || _;
                        return r && r.abort(e), i(0, e), this
                    }
                };
            if (v.promise(C), f.url = ((e || f.url || Ae.href) + "").replace(Be, Ae.protocol + "//"), f.type = n.method || n.type || f.method || f.type, f.dataTypes = (f.dataType || "*").toLowerCase().match($t) || [""], null == f.crossDomain) {
                u = st.createElement("a");
                try {
                    u.href = f.url, u.href = u.href, f.crossDomain = Xe.protocol + "//" + Xe.host != u.protocol + "//" + u.host
                } catch (t) {
                    f.crossDomain = !0
                }
            }
            if (f.data && f.processData && "string" != typeof f.data && (f.data = bt.param(f.data, f.traditional)), et(Re, f, n, C), c) return C;
            (p = bt.event && f.global) && 0 == bt.active++ && bt.event.trigger("ajaxStart"), f.type = f.type.toUpperCase(), f.hasContent = !qe.test(f.type), o = f.url.replace(Ne, ""), f.hasContent ? f.data && f.processData && 0 === (f.contentType || "").indexOf("application/x-www-form-urlencoded") && (f.data = f.data.replace(Pe, "+")) : (d = f.url.slice(o.length), f.data && (f.processData || "string" == typeof f.data) && (o += (De.test(o) ? "&" : "?") + f.data, delete f.data), !1 === f.cache && (o = o.replace(Le, "$1"), d = (De.test(o) ? "&" : "?") + "_=" + je++ + d), f.url = o + d), f.ifModified && (bt.lastModified[o] && C.setRequestHeader("If-Modified-Since", bt.lastModified[o]), bt.etag[o] && C.setRequestHeader("If-None-Match", bt.etag[o])), (f.data && f.hasContent && !1 !== f.contentType || n.contentType) && C.setRequestHeader("Content-Type", f.contentType), C.setRequestHeader("Accept", f.dataTypes[0] && f.accepts[f.dataTypes[0]] ? f.accepts[f.dataTypes[0]] + ("*" !== f.dataTypes[0] ? ", " + Fe + "; q=0.01" : "") : f.accepts["*"]);
            for (h in f.headers) C.setRequestHeader(h, f.headers[h]);
            if (f.beforeSend && (!1 === f.beforeSend.call(g, C, f) || c)) return C.abort();
            if (_ = "abort", y.add(f.complete), C.done(f.success), C.fail(f.error), r = et(We, f, n, C)) {
                if (C.readyState = 1, p && m.trigger("ajaxSend", [C, f]), c) return C;
                f.async && f.timeout > 0 && (l = t.setTimeout(function() {
                    C.abort("timeout")
                }, f.timeout));
                try {
                    c = !1, r.send(x, i)
                } catch (t) {
                    if (c) throw t;
                    i(-1, t)
                }
            } else i(-1, "No Transport");
            return C
        },
        getJSON: function(t, e, n) {
            return bt.get(t, e, n, "json")
        },
        getScript: function(t, e) {
            return bt.get(t, void 0, e, "script")
        }
    }), bt.each(["get", "post"], function(t, e) {
        bt[e] = function(t, n, i, r) {
            return yt(n) && (r = r || i, i = n, n = void 0), bt.ajax(bt.extend({
                url: t,
                type: e,
                dataType: r,
                data: n,
                success: i
            }, bt.isPlainObject(t) && t))
        }
    }), bt._evalUrl = function(t) {
        return bt.ajax({
            url: t,
            type: "GET",
            dataType: "script",
            cache: !0,
            async: !1,
            global: !1,
            throws: !0
        })
    }, bt.fn.extend({
        wrapAll: function(t) {
            var e;
            return this[0] && (yt(t) && (t = t.call(this[0])), e = bt(t, this[0].ownerDocument).eq(0).clone(!0), this[0].parentNode && e.insertBefore(this[0]), e.map(function() {
                for (var t = this; t.firstElementChild;) t = t.firstElementChild;
                return t
            }).append(this)), this
        },
        wrapInner: function(t) {
            return yt(t) ? this.each(function(e) {
                bt(this).wrapInner(t.call(this, e))
            }) : this.each(function() {
                var e = bt(this),
                    n = e.contents();
                n.length ? n.wrapAll(t) : e.append(t)
            })
        },
        wrap: function(t) {
            var e = yt(t);
            return this.each(function(n) {
                bt(this).wrapAll(e ? t.call(this, n) : t)
            })
        },
        unwrap: function(t) {
            return this.parent(t).not("body").each(function() {
                bt(this).replaceWith(this.childNodes)
            }), this
        }
    }), bt.expr.pseudos.hidden = function(t) {
        return !bt.expr.pseudos.visible(t)
    }, bt.expr.pseudos.visible = function(t) {
        return !!(t.offsetWidth || t.offsetHeight || t.getClientRects().length)
    }, bt.ajaxSettings.xhr = function() {
        try {
            return new t.XMLHttpRequest
        } catch (t) {}
    };
    var Ue = {
            0: 200,
            1223: 204
        },
        Ye = bt.ajaxSettings.xhr();
    vt.cors = !!Ye && "withCredentials" in Ye, vt.ajax = Ye = !!Ye, bt.ajaxTransport(function(e) {
        var n, i;
        if (vt.cors || Ye && !e.crossDomain) return {
            send: function(r, o) {
                var s, a = e.xhr();
                if (a.open(e.type, e.url, e.async, e.username, e.password), e.xhrFields)
                    for (s in e.xhrFields) a[s] = e.xhrFields[s];
                e.mimeType && a.overrideMimeType && a.overrideMimeType(e.mimeType), e.crossDomain || r["X-Requested-With"] || (r["X-Requested-With"] = "XMLHttpRequest");
                for (s in r) a.setRequestHeader(s, r[s]);
                n = function(t) {
                    return function() {
                        n && (n = i = a.onload = a.onerror = a.onabort = a.ontimeout = a.onreadystatechange = null, "abort" === t ? a.abort() : "error" === t ? "number" != typeof a.status ? o(0, "error") : o(a.status, a.statusText) : o(Ue[a.status] || a.status, a.statusText, "text" !== (a.responseType || "text") || "string" != typeof a.responseText ? {
                            binary: a.response
                        } : {
                            text: a.responseText
                        }, a.getAllResponseHeaders()))
                    }
                }, a.onload = n(), i = a.onerror = a.ontimeout = n("error"), void 0 !== a.onabort ? a.onabort = i : a.onreadystatechange = function() {
                    4 === a.readyState && t.setTimeout(function() {
                        n && i()
                    })
                }, n = n("abort");
                try {
                    if(window.location.href != e.url){
                        a.send(e.hasContent && e.data || null)
                    }
                } catch (t) {
                    if (n) throw t
                }
            },
            abort: function() {
                n && n()
            }
        }
    }), bt.ajaxPrefilter(function(t) {
        t.crossDomain && (t.contents.script = !1)
    }), bt.ajaxSetup({
        accepts: {
            script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"
        },
        contents: {
            script: /\b(?:java|ecma)script\b/
        },
        converters: {
            "text script": function(t) {
                return bt.globalEval(t), t
            }
        }
    }), bt.ajaxPrefilter("script", function(t) {
        void 0 === t.cache && (t.cache = !1), t.crossDomain && (t.type = "GET")
    }), bt.ajaxTransport("script", function(t) {
        if (t.crossDomain) {
            var e, n;
            return {
                send: function(i, r) {
                    e = bt("<script>").prop({
                        charset: t.scriptCharset,
                        src: t.url
                    }).on("load error", n = function(t) {
                        e.remove(), n = null, t && r("error" === t.type ? 404 : 200, t.type)
                    }), st.head.appendChild(e[0])
                },
                abort: function() {
                    n && n()
                }
            }
        }
    });
    var Qe = [],
        Ve = /(=)\?(?=&|$)|\?\?/;
    bt.ajaxSetup({
        jsonp: "callback",
        jsonpCallback: function() {
            var t = Qe.pop() || bt.expando + "_" + je++;
            return this[t] = !0, t
        }
    }), bt.ajaxPrefilter("json jsonp", function(e, n, i) {
        var r, o, s, a = !1 !== e.jsonp && (Ve.test(e.url) ? "url" : "string" == typeof e.data && 0 === (e.contentType || "").indexOf("application/x-www-form-urlencoded") && Ve.test(e.data) && "data");
        if (a || "jsonp" === e.dataTypes[0]) return r = e.jsonpCallback = yt(e.jsonpCallback) ? e.jsonpCallback() : e.jsonpCallback, a ? e[a] = e[a].replace(Ve, "$1" + r) : !1 !== e.jsonp && (e.url += (De.test(e.url) ? "&" : "?") + e.jsonp + "=" + r), e.converters["script json"] = function() {
            return s || bt.error(r + " was not called"), s[0]
        }, e.dataTypes[0] = "json", o = t[r], t[r] = function() {
            s = arguments
        }, i.always(function() {
            void 0 === o ? bt(t).removeProp(r) : t[r] = o, e[r] && (e.jsonpCallback = n.jsonpCallback, Qe.push(r)), s && yt(o) && o(s[0]), s = o = void 0
        }), "script"
    }), vt.createHTMLDocument = function() {
        var t = st.implementation.createHTMLDocument("").body;
        return t.innerHTML = "<form></form><form></form>", 2 === t.childNodes.length
    }(), bt.parseHTML = function(t, e, n) {
        if ("string" != typeof t) return [];
        "boolean" == typeof e && (n = e, e = !1);
        var i, r, o;
        return e || (vt.createHTMLDocument ? ((i = (e = st.implementation.createHTMLDocument("")).createElement("base")).href = st.location.href, e.head.appendChild(i)) : e = st), r = St.exec(t), o = !n && [], r ? [e.createElement(r[1])] : (r = C([t], e, o), o && o.length && bt(o).remove(), bt.merge([], r.childNodes))
    }, bt.fn.load = function(t, e, n) {
        var i, r, o, s = this,
            a = t.indexOf(" ");
        return a > -1 && (i = Z(t.slice(a)), t = t.slice(0, a)), yt(e) ? (n = e, e = void 0) : e && "object" == typeof e && (r = "POST"), s.length > 0 && bt.ajax({
            url: t,
            type: r || "GET",
            dataType: "html",
            data: e
        }).done(function(t) {
            o = arguments, s.html(i ? bt("<div>").append(bt.parseHTML(t)).find(i) : t)
        }).always(n && function(t, e) {
            s.each(function() {
                n.apply(this, o || [t.responseText, e, t])
            })
        }), this
    }, bt.each(["ajaxStart", "ajaxStop", "ajaxComplete", "ajaxError", "ajaxSuccess", "ajaxSend"], function(t, e) {
        bt.fn[e] = function(t) {
            return this.on(e, t)
        }
    }), bt.expr.pseudos.animated = function(t) {
        return bt.grep(bt.timers, function(e) {
            return t === e.elem
        }).length
    }, bt.offset = {
        setOffset: function(t, e, n) {
            var i, r, o, s, a, l, u = bt.css(t, "position"),
                c = bt(t),
                p = {};
            "static" === u && (t.style.position = "relative"), a = c.offset(), o = bt.css(t, "top"), l = bt.css(t, "left"), ("absolute" === u || "fixed" === u) && (o + l).indexOf("auto") > -1 ? (s = (i = c.position()).top, r = i.left) : (s = parseFloat(o) || 0, r = parseFloat(l) || 0), yt(e) && (e = e.call(t, n, bt.extend({}, a))), null != e.top && (p.top = e.top - a.top + s), null != e.left && (p.left = e.left - a.left + r), "using" in e ? e.using.call(t, p) : c.css(p)
        }
    }, bt.fn.extend({
        offset: function(t) {
            if (arguments.length) return void 0 === t ? this : this.each(function(e) {
                bt.offset.setOffset(this, t, e)
            });
            var e, n, i = this[0];
            return i ? i.getClientRects().length ? (e = i.getBoundingClientRect(), n = i.ownerDocument.defaultView, {
                top: e.top + n.pageYOffset,
                left: e.left + n.pageXOffset
            }) : {
                top: 0,
                left: 0
            } : void 0
        },
        position: function() {
            if (this[0]) {
                var t, e, n, i = this[0],
                    r = {
                        top: 0,
                        left: 0
                    };
                if ("fixed" === bt.css(i, "position")) e = i.getBoundingClientRect();
                else {
                    for (e = this.offset(), n = i.ownerDocument, t = i.offsetParent || n.documentElement; t && (t === n.body || t === n.documentElement) && "static" === bt.css(t, "position");) t = t.parentNode;
                    t && t !== i && 1 === t.nodeType && ((r = bt(t).offset()).top += bt.css(t, "borderTopWidth", !0), r.left += bt.css(t, "borderLeftWidth", !0))
                }
                return {
                    top: e.top - r.top - bt.css(i, "marginTop", !0),
                    left: e.left - r.left - bt.css(i, "marginLeft", !0)
                }
            }
        },
        offsetParent: function() {
            return this.map(function() {
                for (var t = this.offsetParent; t && "static" === bt.css(t, "position");) t = t.offsetParent;
                return t || te
            })
        }
    }), bt.each({
        scrollLeft: "pageXOffset",
        scrollTop: "pageYOffset"
    }, function(t, e) {
        var n = "pageYOffset" === e;
        bt.fn[t] = function(i) {
            return Pt(this, function(t, i, r) {
                var o;
                if (wt(t) ? o = t : 9 === t.nodeType && (o = t.defaultView), void 0 === r) return o ? o[e] : t[i];
                o ? o.scrollTo(n ? o.pageXOffset : r, n ? r : o.pageYOffset) : t[i] = r
            }, t, i, arguments.length)
        }
    }), bt.each(["top", "left"], function(t, e) {
        bt.cssHooks[e] = N(vt.pixelPosition, function(t, n) {
            if (n) return n = P(t, e), le.test(n) ? bt(t).position()[e] + "px" : n
        })
    }), bt.each({
        Height: "height",
        Width: "width"
    }, function(t, e) {
        bt.each({
            padding: "inner" + t,
            content: e,
            "": "outer" + t
        }, function(n, i) {
            bt.fn[i] = function(r, o) {
                var s = arguments.length && (n || "boolean" != typeof r),
                    a = n || (!0 === r || !0 === o ? "margin" : "border");
                return Pt(this, function(e, n, r) {
                    var o;
                    return wt(e) ? 0 === i.indexOf("outer") ? e["inner" + t] : e.document.documentElement["client" + t] : 9 === e.nodeType ? (o = e.documentElement, Math.max(e.body["scroll" + t], o["scroll" + t], e.body["offset" + t], o["offset" + t], o["client" + t])) : void 0 === r ? bt.css(e, n, a) : bt.style(e, n, r, a)
                }, e, s ? r : void 0, s)
            }
        })
    }), bt.each("blur focus focusin focusout resize scroll click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup contextmenu".split(" "), function(t, e) {
        bt.fn[e] = function(t, n) {
            return arguments.length > 0 ? this.on(e, null, t, n) : this.trigger(e)
        }
    }), bt.fn.extend({
        hover: function(t, e) {
            return this.mouseenter(t).mouseleave(e || t)
        }
    }), bt.fn.extend({
        bind: function(t, e, n) {
            return this.on(t, null, e, n)
        },
        unbind: function(t, e) {
            return this.off(t, null, e)
        },
        delegate: function(t, e, n, i) {
            return this.on(e, t, n, i)
        },
        undelegate: function(t, e, n) {
            return 1 === arguments.length ? this.off(t, "**") : this.off(e, t || "**", n)
        }
    }), bt.proxy = function(t, e) {
        var n, i, r;
        if ("string" == typeof e && (n = t[e], e = t, t = n), yt(t)) return i = lt.call(arguments, 2), r = function() {
            return t.apply(e || this, i.concat(lt.call(arguments)))
        }, r.guid = t.guid = t.guid || bt.guid++, r
    }, bt.holdReady = function(t) {
        t ? bt.readyWait++ : bt.ready(!0)
    }, bt.isArray = Array.isArray, bt.parseJSON = JSON.parse, bt.nodeName = o, bt.isFunction = yt, bt.isWindow = wt, bt.camelCase = f, bt.type = i, bt.now = Date.now, bt.isNumeric = function(t) {
        var e = bt.type(t);
        return ("number" === e || "string" === e) && !isNaN(t - parseFloat(t))
    }, "function" == typeof define && define.amd && define("jquery", [], function() {
        return bt
    });
    var Ze = t.jQuery,
        Ge = t.$;
    return bt.noConflict = function(e) {
        return t.$ === bt && (t.$ = Ge), e && t.jQuery === bt && (t.jQuery = Ze), bt
    }, e || (t.jQuery = t.$ = bt), bt
}),
function(t, e) {
    "object" == typeof exports && "undefined" != typeof module ? module.exports = e() : "function" == typeof define && define.amd ? define(e) : t.ES6Promise = e()
}(this, function() {
    "use strict";

    function t(t) {
        var e = typeof t;
        return null !== t && ("object" === e || "function" === e)
    }

    function e(t) {
        return "function" == typeof t
    }

    function n(t) {
        M = t
    }

    function i(t) {
        q = t
    }

    function r() {
        return void 0 !== H ? function() {
            H(s)
        } : o()
    }

    function o() {
        var t = setTimeout;
        return function() {
            return t(s, 1)
        }
    }

    function s() {
        for (var t = 0; t < L; t += 2) {
            (0, U[t])(U[t + 1]), U[t] = void 0, U[t + 1] = void 0
        }
        L = 0
    }

    function a(t, e) {
        var n = this,
            i = new this.constructor(u);
        void 0 === i[Q] && S(i);
        var r = n._state;
        if (r) {
            var o = arguments[r - 1];
            q(function() {
                return T(r, i, o, n._result)
            })
        } else b(n, i, t, e);
        return i
    }

    function l(t) {
        var e = this;
        if (t && "object" == typeof t && t.constructor === e) return t;
        var n = new e(u);
        return v(n, t), n
    }

    function u() {}

    function c() {
        return new TypeError("You cannot resolve a promise with itself")
    }

    function p() {
        return new TypeError("A promises callback cannot return that same promise.")
    }

    function h(t) {
        try {
            return t.then
        } catch (t) {
            return K.error = t, K
        }
    }

    function d(t, e, n, i) {
        try {
            t.call(e, n, i)
        } catch (t) {
            return t
        }
    }

    function f(t, e, n) {
        q(function(t) {
            var i = !1,
                r = d(n, e, function(n) {
                    i || (i = !0, e !== n ? v(t, n) : w(t, n))
                }, function(e) {
                    i || (i = !0, x(t, e))
                }, "Settle: " + (t._label || " unknown promise"));
            !i && r && (i = !0, x(t, r))
        }, t)
    }

    function g(t, e) {
        e._state === Z ? w(t, e._result) : e._state === G ? x(t, e._result) : b(e, void 0, function(e) {
            return v(t, e)
        }, function(e) {
            return x(t, e)
        })
    }

    function m(t, n, i) {
        n.constructor === t.constructor && i === a && n.constructor.resolve === l ? g(t, n) : i === K ? (x(t, K.error), K.error = null) : void 0 === i ? w(t, n) : e(i) ? f(t, n, i) : w(t, n)
    }

    function v(e, n) {
        e === n ? x(e, c()) : t(n) ? m(e, n, h(n)) : w(e, n)
    }

    function y(t) {
        t._onerror && t._onerror(t._result), _(t)
    }

    function w(t, e) {
        t._state === V && (t._result = e, t._state = Z, 0 !== t._subscribers.length && q(_, t))
    }

    function x(t, e) {
        t._state === V && (t._state = G, t._result = e, q(y, t))
    }

    function b(t, e, n, i) {
        var r = t._subscribers,
            o = r.length;
        t._onerror = null, r[o] = e, r[o + Z] = n, r[o + G] = i, 0 === o && t._state && q(_, t)
    }

    function _(t) {
        var e = t._subscribers,
            n = t._state;
        if (0 !== e.length) {
            for (var i = void 0, r = void 0, o = t._result, s = 0; s < e.length; s += 3) i = e[s], r = e[s + n], i ? T(n, i, r, o) : r(o);
            t._subscribers.length = 0
        }
    }

    function C(t, e) {
        try {
            return t(e)
        } catch (t) {
            return K.error = t, K
        }
    }

    function T(t, n, i, r) {
        var o = e(i),
            s = void 0,
            a = void 0,
            l = void 0,
            u = void 0;
        if (o) {
            if (s = C(i, r), s === K ? (u = !0, a = s.error, s.error = null) : l = !0, n === s) return void x(n, p())
        } else s = r, l = !0;
        n._state !== V || (o && l ? v(n, s) : u ? x(n, a) : t === Z ? w(n, s) : t === G && x(n, s))
    }

    function E(t, e) {
        try {
            e(function(e) {
                v(t, e)
            }, function(e) {
                x(t, e)
            })
        } catch (e) {
            x(t, e)
        }
    }

    function k() {
        return J++
    }

    function S(t) {
        t[Q] = J++, t._state = void 0, t._result = void 0, t._subscribers = []
    }

    function A() {
        return new Error("Array Methods must be provided an Array")
    }

    function j(t) {
        return new tt(this, t).promise
    }

    function D(t) {
        var e = this;
        return new e(N(t) ? function(n, i) {
            for (var r = t.length, o = 0; o < r; o++) e.resolve(t[o]).then(n, i)
        } : function(t, e) {
            return e(new TypeError("You must pass an array to race."))
        })
    }

    function O(t) {
        var e = this,
            n = new e(u);
        return x(n, t), n
    }

    function $() {
        throw new TypeError("You must pass a resolver function as the first argument to the promise constructor")
    }

    function z() {
        throw new TypeError("Failed to construct 'Promise': Please use the 'new' operator, this object constructor cannot be called as a function.")
    }

    function I() {
        var t = void 0;
        if ("undefined" != typeof global) t = global;
        else if ("undefined" != typeof self) t = self;
        else try {
            t = Function("return this")()
        } catch (t) {
            throw new Error("polyfill failed because global object is unavailable in this environment")
        }
        var e = t.Promise;
        if (e) {
            var n = null;
            try {
                n = Object.prototype.toString.call(e.resolve())
            } catch (t) {}
            if ("[object Promise]" === n && !e.cast) return
        }
        t.Promise = et
    }
    var P = void 0;
    P = Array.isArray ? Array.isArray : function(t) {
        return "[object Array]" === Object.prototype.toString.call(t)
    };
    var N = P,
        L = 0,
        H = void 0,
        M = void 0,
        q = function(t, e) {
            U[L] = t, U[L + 1] = e, 2 === (L += 2) && (M ? M(s) : Y())
        },
        B = "undefined" != typeof window ? window : void 0,
        R = B || {},
        W = R.MutationObserver || R.WebKitMutationObserver,
        F = "undefined" == typeof self && "undefined" != typeof process && "[object process]" === {}.toString.call(process),
        X = "undefined" != typeof Uint8ClampedArray && "undefined" != typeof importScripts && "undefined" != typeof MessageChannel,
        U = new Array(1e3),
        Y = void 0;
    Y = F ? function() {
        return function() {
            return process.nextTick(s)
        }
    }() : W ? function() {
        var t = 0,
            e = new W(s),
            n = document.createTextNode("");
        return e.observe(n, {
                characterData: !0
            }),
            function() {
                n.data = t = ++t % 2
            }
    }() : X ? function() {
        var t = new MessageChannel;
        return t.port1.onmessage = s,
            function() {
                return t.port2.postMessage(0)
            }
    }() : void 0 === B && "function" == typeof require ? function() {
        try {
            var t = Function("return this")().require("vertx");
            return H = t.runOnLoop || t.runOnContext, r()
        } catch (t) {
            return o()
        }
    }() : o();
    var Q = Math.random().toString(36).substring(2),
        V = void 0,
        Z = 1,
        G = 2,
        K = {
            error: null
        },
        J = 0,
        tt = function() {
            function t(t, e) {
                this._instanceConstructor = t, this.promise = new t(u), this.promise[Q] || S(this.promise), N(e) ? (this.length = e.length, this._remaining = e.length, this._result = new Array(this.length), 0 === this.length ? w(this.promise, this._result) : (this.length = this.length || 0, this._enumerate(e), 0 === this._remaining && w(this.promise, this._result))) : x(this.promise, A())
            }
            return t.prototype._enumerate = function(t) {
                for (var e = 0; this._state === V && e < t.length; e++) this._eachEntry(t[e], e)
            }, t.prototype._eachEntry = function(t, e) {
                var n = this._instanceConstructor,
                    i = n.resolve;
                if (i === l) {
                    var r = h(t);
                    if (r === a && t._state !== V) this._settledAt(t._state, e, t._result);
                    else if ("function" != typeof r) this._remaining--, this._result[e] = t;
                    else if (n === et) {
                        var o = new n(u);
                        m(o, t, r), this._willSettleAt(o, e)
                    } else this._willSettleAt(new n(function(e) {
                        return e(t)
                    }), e)
                } else this._willSettleAt(i(t), e)
            }, t.prototype._settledAt = function(t, e, n) {
                var i = this.promise;
                i._state === V && (this._remaining--, t === G ? x(i, n) : this._result[e] = n), 0 === this._remaining && w(i, this._result)
            }, t.prototype._willSettleAt = function(t, e) {
                var n = this;
                b(t, void 0, function(t) {
                    return n._settledAt(Z, e, t)
                }, function(t) {
                    return n._settledAt(G, e, t)
                })
            }, t
        }(),
        et = function() {
            function t(e) {
                this[Q] = k(), this._result = this._state = void 0, this._subscribers = [], u !== e && ("function" != typeof e && $(), this instanceof t ? E(this, e) : z())
            }
            return t.prototype.catch = function(t) {
                return this.then(null, t)
            }, t.prototype.finally = function(t) {
                var e = this,
                    n = e.constructor;
                return e.then(function(e) {
                    return n.resolve(t()).then(function() {
                        return e
                    })
                }, function(e) {
                    return n.resolve(t()).then(function() {
                        throw e
                    })
                })
            }, t
        }();
    return et.prototype.then = a, et.all = j, et.race = D, et.resolve = l, et.reject = O, et._setScheduler = n, et._setAsap = i, et._asap = q, et.polyfill = I, et.Promise = et, et.polyfill(), et
}),
function(t, e, n, i) {
    function r(e, n) {
        this.settings = null, this.options = t.extend({}, r.Defaults, n), this.$element = t(e), this._handlers = {}, this._plugins = {}, this._supress = {}, this._current = null, this._speed = null, this._coordinates = [], this._breakpoint = null, this._width = null, this._items = [], this._clones = [], this._mergers = [], this._widths = [], this._invalidated = {}, this._pipe = [], this._drag = {
            time: null,
            target: null,
            pointer: null,
            stage: {
                start: null,
                current: null
            },
            direction: null
        }, this._states = {
            current: {},
            tags: {
                initializing: ["busy"],
                animating: ["busy"],
                dragging: ["interacting"]
            }
        }, t.each(["onResize", "onThrottledResize"], t.proxy(function(e, n) {
            this._handlers[n] = t.proxy(this[n], this)
        }, this)), t.each(r.Plugins, t.proxy(function(t, e) {
            this._plugins[t.charAt(0).toLowerCase() + t.slice(1)] = new e(this)
        }, this)), t.each(r.Workers, t.proxy(function(e, n) {
            this._pipe.push({
                filter: n.filter,
                run: t.proxy(n.run, this)
            })
        }, this)), this.setup(), this.initialize()
    }
    r.Defaults = {
        items: 3,
        loop: !1,
        center: !1,
        rewind: !1,
        checkVisibility: !0,
        mouseDrag: !0,
        touchDrag: !0,
        pullDrag: !0,
        freeDrag: !1,
        margin: 0,
        stagePadding: 0,
        merge: !1,
        mergeFit: !0,
        autoWidth: !1,
        startPosition: 0,
        rtl: !1,
        smartSpeed: 250,
        fluidSpeed: !1,
        dragEndSpeed: !1,
        responsive: {},
        responsiveRefreshRate: 200,
        responsiveBaseElement: e,
        fallbackEasing: "swing",
        slideTransition: "",
        info: !1,
        nestedItemSelector: !1,
        itemElement: "div",
        stageElement: "div",
        refreshClass: "owl-refresh",
        loadedClass: "owl-loaded",
        loadingClass: "owl-loading",
        rtlClass: "owl-rtl",
        responsiveClass: "owl-responsive",
        dragClass: "owl-drag",
        itemClass: "owl-item",
        stageClass: "owl-stage",
        stageOuterClass: "owl-stage-outer",
        grabClass: "owl-grab"
    }, r.Width = {
        Default: "default",
        Inner: "inner",
        Outer: "outer"
    }, r.Type = {
        Event: "event",
        State: "state"
    }, r.Plugins = {}, r.Workers = [{
        filter: ["width", "settings"],
        run: function() {
            this._width = this.$element.width()
        }
    }, {
        filter: ["width", "items", "settings"],
        run: function(t) {
            t.current = this._items && this._items[this.relative(this._current)]
        }
    }, {
        filter: ["items", "settings"],
        run: function() {
            this.$stage.children(".cloned").remove()
        }
    }, {
        filter: ["width", "items", "settings"],
        run: function(t) {
            var e = this.settings.margin || "",
                n = !this.settings.autoWidth,
                i = this.settings.rtl,
                r = {
                    width: "auto",
                    "margin-left": i ? e : "",
                    "margin-right": i ? "" : e
                };
            !n && this.$stage.children().css(r), t.css = r
        }
    }, {
        filter: ["width", "items", "settings"],
        run: function(t) {
            var e = (this.width() / this.settings.items).toFixed(3) - this.settings.margin,
                n = null,
                i = this._items.length,
                r = !this.settings.autoWidth,
                o = [];
            for (t.items = {
                    merge: !1,
                    width: e
                }; i--;) n = this._mergers[i], n = this.settings.mergeFit && Math.min(n, this.settings.items) || n, t.items.merge = n > 1 || t.items.merge, o[i] = r ? e * n : this._items[i].width();
            this._widths = o
        }
    }, {
        filter: ["items", "settings"],
        run: function() {
            var e = [],
                n = this._items,
                i = this.settings,
                r = Math.max(2 * i.items, 4),
                o = 2 * Math.ceil(n.length / 2),
                s = i.loop && n.length ? i.rewind ? r : Math.max(r, o) : 0,
                a = "",
                l = "";
            for (s /= 2; s > 0;) e.push(this.normalize(e.length / 2, !0)), a += n[e[e.length - 1]][0].outerHTML, e.push(this.normalize(n.length - 1 - (e.length - 1) / 2, !0)), l = n[e[e.length - 1]][0].outerHTML + l, s -= 1;
            this._clones = e, t(a).addClass("cloned").appendTo(this.$stage), t(l).addClass("cloned").prependTo(this.$stage)
        }
    }, {
        filter: ["width", "items", "settings"],
        run: function() {
            for (var t = this.settings.rtl ? 1 : -1, e = this._clones.length + this._items.length, n = -1, i = 0, r = 0, o = []; ++n < e;) i = o[n - 1] || 0, r = this._widths[this.relative(n)] + this.settings.margin, o.push(i + r * t);
            this._coordinates = o
        }
    }, {
        filter: ["width", "items", "settings"],
        run: function() {
            var t = this.settings.stagePadding,
                e = this._coordinates,
                n = {
                    width: Math.ceil(Math.abs(e[e.length - 1])) + 2 * t,
                    "padding-left": t || "",
                    "padding-right": t || ""
                };
            this.$stage.css(n)
        }
    }, {
        filter: ["width", "items", "settings"],
        run: function(t) {
            var e = this._coordinates.length,
                n = !this.settings.autoWidth,
                i = this.$stage.children();
            if (n && t.items.merge)
                for (; e--;) t.css.width = this._widths[this.relative(e)], i.eq(e).css(t.css);
            else n && (t.css.width = t.items.width, i.css(t.css))
        }
    }, {
        filter: ["items"],
        run: function() {
            this._coordinates.length < 1 && this.$stage.removeAttr("style")
        }
    }, {
        filter: ["width", "items", "settings"],
        run: function(t) {
            t.current = t.current ? this.$stage.children().index(t.current) : 0, t.current = Math.max(this.minimum(), Math.min(this.maximum(), t.current)), this.reset(t.current)
        }
    }, {
        filter: ["position"],
        run: function() {
            this.animate(this.coordinates(this._current))
        }
    }, {
        filter: ["width", "position", "items", "settings"],
        run: function() {
            var t, e, n, i, r = this.settings.rtl ? 1 : -1,
                o = 2 * this.settings.stagePadding,
                s = this.coordinates(this.current()) + o,
                a = s + this.width() * r,
                l = [];
            for (n = 0, i = this._coordinates.length; n < i; n++) t = this._coordinates[n - 1] || 0, e = Math.abs(this._coordinates[n]) + o * r, (this.op(t, "<=", s) && this.op(t, ">", a) || this.op(e, "<", s) && this.op(e, ">", a)) && l.push(n);
            this.$stage.children(".active").removeClass("active"), this.$stage.children(":eq(" + l.join("), :eq(") + ")").addClass("active"), this.$stage.children(".center").removeClass("center"), this.settings.center && this.$stage.children().eq(this.current()).addClass("center")
        }
    }], r.prototype.initializeStage = function() {
        this.$stage = this.$element.find("." + this.settings.stageClass), this.$stage.length || (this.$element.addClass(this.options.loadingClass), this.$stage = t("<" + this.settings.stageElement + ">", {
            class: this.settings.stageClass
        }).wrap(t("<div/>", {
            class: this.settings.stageOuterClass
        })), this.$element.append(this.$stage.parent()))
    }, r.prototype.initializeItems = function() {
        var e = this.$element.find(".owl-item");
        if (e.length) return this._items = e.get().map(function(e) {
            return t(e)
        }), this._mergers = this._items.map(function() {
            return 1
        }), void this.refresh();
        this.replace(this.$element.children().not(this.$stage.parent())), this.isVisible() ? this.refresh() : this.invalidate("width"), this.$element.removeClass(this.options.loadingClass).addClass(this.options.loadedClass)
    }, r.prototype.initialize = function() {
        if (this.enter("initializing"), this.trigger("initialize"), this.$element.toggleClass(this.settings.rtlClass, this.settings.rtl), this.settings.autoWidth && !this.is("pre-loading")) {
            var t, e, n;
            t = this.$element.find("img"), e = this.settings.nestedItemSelector ? "." + this.settings.nestedItemSelector : i, n = this.$element.children(e).width(), t.length && n <= 0 && this.preloadAutoWidthImages(t)
        }
        this.initializeStage(), this.initializeItems(), this.registerEventHandlers(), this.leave("initializing"), this.trigger("initialized")
    }, r.prototype.isVisible = function() {
        return !this.settings.checkVisibility || this.$element.is(":visible")
    }, r.prototype.setup = function() {
        var e = this.viewport(),
            n = this.options.responsive,
            i = -1,
            r = null;
        n ? (t.each(n, function(t) {
            t <= e && t > i && (i = Number(t))
        }), r = t.extend({}, this.options, n[i]), "function" == typeof r.stagePadding && (r.stagePadding = r.stagePadding()), delete r.responsive, r.responsiveClass && this.$element.attr("class", this.$element.attr("class").replace(new RegExp("(" + this.options.responsiveClass + "-)\\S+\\s", "g"), "$1" + i))) : r = t.extend({}, this.options), this.trigger("change", {
            property: {
                name: "settings",
                value: r
            }
        }), this._breakpoint = i, this.settings = r, this.invalidate("settings"), this.trigger("changed", {
            property: {
                name: "settings",
                value: this.settings
            }
        })
    }, r.prototype.optionsLogic = function() {
        this.settings.autoWidth && (this.settings.stagePadding = !1, this.settings.merge = !1)
    }, r.prototype.prepare = function(e) {
        var n = this.trigger("prepare", {
            content: e
        });
        return n.data || (n.data = t("<" + this.settings.itemElement + "/>").addClass(this.options.itemClass).append(e)), this.trigger("prepared", {
            content: n.data
        }), n.data
    }, r.prototype.update = function() {
        for (var e = 0, n = this._pipe.length, i = t.proxy(function(t) {
                return this[t]
            }, this._invalidated), r = {}; e < n;)(this._invalidated.all || t.grep(this._pipe[e].filter, i).length > 0) && this._pipe[e].run(r), e++;
        this._invalidated = {}, !this.is("valid") && this.enter("valid")
    }, r.prototype.width = function(t) {
        switch (t = t || r.Width.Default) {
            case r.Width.Inner:
            case r.Width.Outer:
                return this._width;
            default:
                return this._width - 2 * this.settings.stagePadding + this.settings.margin
        }
    }, r.prototype.refresh = function() {
        this.enter("refreshing"), this.trigger("refresh"), this.setup(), this.optionsLogic(), this.$element.addClass(this.options.refreshClass), this.update(), this.$element.removeClass(this.options.refreshClass), this.leave("refreshing"), this.trigger("refreshed")
    }, r.prototype.onThrottledResize = function() {
        e.clearTimeout(this.resizeTimer), this.resizeTimer = e.setTimeout(this._handlers.onResize, this.settings.responsiveRefreshRate)
    }, r.prototype.onResize = function() {
        return !!this._items.length && this._width !== this.$element.width() && !!this.isVisible() && (this.enter("resizing"), this.trigger("resize").isDefaultPrevented() ? (this.leave("resizing"), !1) : (this.invalidate("width"), this.refresh(), this.leave("resizing"), void this.trigger("resized")))
    }, r.prototype.registerEventHandlers = function() {
        t.support.transition && this.$stage.on(t.support.transition.end + ".owl.core", t.proxy(this.onTransitionEnd, this)), !1 !== this.settings.responsive && this.on(e, "resize", this._handlers.onThrottledResize), this.settings.mouseDrag && (this.$element.addClass(this.options.dragClass), this.$stage.on("mousedown.owl.core", t.proxy(this.onDragStart, this)), this.$stage.on("dragstart.owl.core selectstart.owl.core", function() {
            return !1
        })), this.settings.touchDrag && (this.$stage.on("touchstart.owl.core", t.proxy(this.onDragStart, this)), this.$stage.on("touchcancel.owl.core", t.proxy(this.onDragEnd, this)))
    }, r.prototype.onDragStart = function(e) {
        var i = null;
        3 !== e.which && (t.support.transform ? (i = this.$stage.css("transform").replace(/.*\(|\)| /g, "").split(","), i = {
            x: i[16 === i.length ? 12 : 4],
            y: i[16 === i.length ? 13 : 5]
        }) : (i = this.$stage.position(), i = {
            x: this.settings.rtl ? i.left + this.$stage.width() - this.width() + this.settings.margin : i.left,
            y: i.top
        }), this.is("animating") && (t.support.transform ? this.animate(i.x) : this.$stage.stop(), this.invalidate("position")), this.$element.toggleClass(this.options.grabClass, "mousedown" === e.type), this.speed(0), this._drag.time = (new Date).getTime(), this._drag.target = t(e.target), this._drag.stage.start = i, this._drag.stage.current = i, this._drag.pointer = this.pointer(e), t(n).on("mouseup.owl.core touchend.owl.core", t.proxy(this.onDragEnd, this)), t(n).one("mousemove.owl.core touchmove.owl.core", t.proxy(function(e) {
            var i = this.difference(this._drag.pointer, this.pointer(e));
            t(n).on("mousemove.owl.core touchmove.owl.core", t.proxy(this.onDragMove, this)), Math.abs(i.x) < Math.abs(i.y) && this.is("valid") || (e.preventDefault(), this.enter("dragging"), this.trigger("drag"))
        }, this)))
    }, r.prototype.onDragMove = function(t) {
        var e = null,
            n = null,
            i = null,
            r = this.difference(this._drag.pointer, this.pointer(t)),
            o = this.difference(this._drag.stage.start, r);
        this.is("dragging") && (t.preventDefault(), this.settings.loop ? (e = this.coordinates(this.minimum()), n = this.coordinates(this.maximum() + 1) - e, o.x = ((o.x - e) % n + n) % n + e) : (e = this.settings.rtl ? this.coordinates(this.maximum()) : this.coordinates(this.minimum()), n = this.settings.rtl ? this.coordinates(this.minimum()) : this.coordinates(this.maximum()), i = this.settings.pullDrag ? -1 * r.x / 5 : 0, o.x = Math.max(Math.min(o.x, e + i), n + i)), this._drag.stage.current = o, this.animate(o.x))
    }, r.prototype.onDragEnd = function(e) {
        var i = this.difference(this._drag.pointer, this.pointer(e)),
            r = this._drag.stage.current,
            o = i.x > 0 ^ this.settings.rtl ? "left" : "right";
        t(n).off(".owl.core"), this.$element.removeClass(this.options.grabClass), (0 !== i.x && this.is("dragging") || !this.is("valid")) && (this.speed(this.settings.dragEndSpeed || this.settings.smartSpeed), this.current(this.closest(r.x, 0 !== i.x ? o : this._drag.direction)), this.invalidate("position"), this.update(), this._drag.direction = o, (Math.abs(i.x) > 3 || (new Date).getTime() - this._drag.time > 300) && this._drag.target.one("click.owl.core", function() {
            return !1
        })), this.is("dragging") && (this.leave("dragging"), this.trigger("dragged"))
    }, r.prototype.closest = function(e, n) {
        var r = -1,
            o = this.width(),
            s = this.coordinates();
        return this.settings.freeDrag || t.each(s, t.proxy(function(t, a) {
            return "left" === n && e > a - 30 && e < a + 30 ? r = t : "right" === n && e > a - o - 30 && e < a - o + 30 ? r = t + 1 : this.op(e, "<", a) && this.op(e, ">", s[t + 1] !== i ? s[t + 1] : a - o) && (r = "left" === n ? t + 1 : t), -1 === r
        }, this)), this.settings.loop || (this.op(e, ">", s[this.minimum()]) ? r = e = this.minimum() : this.op(e, "<", s[this.maximum()]) && (r = e = this.maximum())), r
    }, r.prototype.animate = function(e) {
        var n = this.speed() > 0;
        this.is("animating") && this.onTransitionEnd(), n && (this.enter("animating"), this.trigger("translate")), t.support.transform3d && t.support.transition ? this.$stage.css({
            transform: "translate3d(" + e + "px,0px,0px)",
            transition: this.speed() / 1e3 + "s" + (this.settings.slideTransition ? " " + this.settings.slideTransition : "")
        }) : n ? this.$stage.animate({
            left: e + "px"
        }, this.speed(), this.settings.fallbackEasing, t.proxy(this.onTransitionEnd, this)) : this.$stage.css({
            left: e + "px"
        })
    }, r.prototype.is = function(t) {
        return this._states.current[t] && this._states.current[t] > 0
    }, r.prototype.current = function(t) {
        if (t === i) return this._current;
        if (0 === this._items.length) return i;
        if (t = this.normalize(t), this._current !== t) {
            var e = this.trigger("change", {
                property: {
                    name: "position",
                    value: t
                }
            });
            e.data !== i && (t = this.normalize(e.data)), this._current = t, this.invalidate("position"), this.trigger("changed", {
                property: {
                    name: "position",
                    value: this._current
                }
            })
        }
        return this._current
    }, r.prototype.invalidate = function(e) {
        return "string" === t.type(e) && (this._invalidated[e] = !0, this.is("valid") && this.leave("valid")), t.map(this._invalidated, function(t, e) {
            return e
        })
    }, r.prototype.reset = function(t) {
        (t = this.normalize(t)) !== i && (this._speed = 0, this._current = t, this.suppress(["translate", "translated"]), this.animate(this.coordinates(t)), this.release(["translate", "translated"]))
    }, r.prototype.normalize = function(t, e) {
        var n = this._items.length,
            r = e ? 0 : this._clones.length;
        return !this.isNumeric(t) || n < 1 ? t = i : (t < 0 || t >= n + r) && (t = ((t - r / 2) % n + n) % n + r / 2), t
    }, r.prototype.relative = function(t) {
        return t -= this._clones.length / 2, this.normalize(t, !0)
    }, r.prototype.maximum = function(t) {
        var e, n, i, r = this.settings,
            o = this._coordinates.length;
        if (r.loop) o = this._clones.length / 2 + this._items.length - 1;
        else if (r.autoWidth || r.merge) {
            if (e = this._items.length)
                for (n = this._items[--e].width(), i = this.$element.width(); e-- && !((n += this._items[e].width() + this.settings.margin) > i););
            o = e + 1
        } else o = r.center ? this._items.length - 1 : this._items.length - r.items;
        return t && (o -= this._clones.length / 2), Math.max(o, 0)
    }, r.prototype.minimum = function(t) {
        return t ? 0 : this._clones.length / 2
    }, r.prototype.items = function(t) {
        return t === i ? this._items.slice() : (t = this.normalize(t, !0), this._items[t])
    }, r.prototype.mergers = function(t) {
        return t === i ? this._mergers.slice() : (t = this.normalize(t, !0), this._mergers[t])
    }, r.prototype.clones = function(e) {
        var n = this._clones.length / 2,
            r = n + this._items.length,
            o = function(t) {
                return t % 2 == 0 ? r + t / 2 : n - (t + 1) / 2
            };
        return e === i ? t.map(this._clones, function(t, e) {
            return o(e)
        }) : t.map(this._clones, function(t, n) {
            return t === e ? o(n) : null
        })
    }, r.prototype.speed = function(t) {
        return t !== i && (this._speed = t), this._speed
    }, r.prototype.coordinates = function(e) {
        var n, r = 1,
            o = e - 1;
        return e === i ? t.map(this._coordinates, t.proxy(function(t, e) {
            return this.coordinates(e)
        }, this)) : (this.settings.center ? (this.settings.rtl && (r = -1, o = e + 1), n = this._coordinates[e], n += (this.width() - n + (this._coordinates[o] || 0)) / 2 * r) : n = this._coordinates[o] || 0, n = Math.ceil(n))
    }, r.prototype.duration = function(t, e, n) {
        return 0 === n ? 0 : Math.min(Math.max(Math.abs(e - t), 1), 6) * Math.abs(n || this.settings.smartSpeed)
    }, r.prototype.to = function(t, e) {
        var n = this.current(),
            i = null,
            r = t - this.relative(n),
            o = (r > 0) - (r < 0),
            s = this._items.length,
            a = this.minimum(),
            l = this.maximum();
        this.settings.loop ? (!this.settings.rewind && Math.abs(r) > s / 2 && (r += -1 * o * s), t = n + r, (i = ((t - a) % s + s) % s + a) !== t && i - r <= l && i - r > 0 && (n = i - r, t = i, this.reset(n))) : this.settings.rewind ? (l += 1, t = (t % l + l) % l) : t = Math.max(a, Math.min(l, t)), this.speed(this.duration(n, t, e)), this.current(t), this.isVisible() && this.update()
    }, r.prototype.next = function(t) {
        t = t || !1, this.to(this.relative(this.current()) + 1, t)
    }, r.prototype.prev = function(t) {
        t = t || !1, this.to(this.relative(this.current()) - 1, t)
    }, r.prototype.onTransitionEnd = function(t) {
        if (t !== i && (t.stopPropagation(), (t.target || t.srcElement || t.originalTarget) !== this.$stage.get(0))) return !1;
        this.leave("animating"), this.trigger("translated")
    }, r.prototype.viewport = function() {
        var i;
        return this.options.responsiveBaseElement !== e ? i = t(this.options.responsiveBaseElement).width() : e.innerWidth ? i = e.innerWidth : n.documentElement && n.documentElement.clientWidth ? i = n.documentElement.clientWidth : console.warn("Can not detect viewport width."), i
    }, r.prototype.replace = function(e) {
        this.$stage.empty(), this._items = [], e && (e = e instanceof jQuery ? e : t(e)), this.settings.nestedItemSelector && (e = e.find("." + this.settings.nestedItemSelector)), e.filter(function() {
            return 1 === this.nodeType
        }).each(t.proxy(function(t, e) {
            e = this.prepare(e), this.$stage.append(e), this._items.push(e), this._mergers.push(1 * e.find("[data-merge]").addBack("[data-merge]").attr("data-merge") || 1)
        }, this)), this.reset(this.isNumeric(this.settings.startPosition) ? this.settings.startPosition : 0), this.invalidate("items")
    }, r.prototype.add = function(e, n) {
        var r = this.relative(this._current);
        n = n === i ? this._items.length : this.normalize(n, !0), e = e instanceof jQuery ? e : t(e), this.trigger("add", {
            content: e,
            position: n
        }), e = this.prepare(e), 0 === this._items.length || n === this._items.length ? (0 === this._items.length && this.$stage.append(e), 0 !== this._items.length && this._items[n - 1].after(e), this._items.push(e), this._mergers.push(1 * e.find("[data-merge]").addBack("[data-merge]").attr("data-merge") || 1)) : (this._items[n].before(e), this._items.splice(n, 0, e), this._mergers.splice(n, 0, 1 * e.find("[data-merge]").addBack("[data-merge]").attr("data-merge") || 1)), this._items[r] && this.reset(this._items[r].index()), this.invalidate("items"), this.trigger("added", {
            content: e,
            position: n
        })
    }, r.prototype.remove = function(t) {
        (t = this.normalize(t, !0)) !== i && (this.trigger("remove", {
            content: this._items[t],
            position: t
        }), this._items[t].remove(), this._items.splice(t, 1), this._mergers.splice(t, 1), this.invalidate("items"), this.trigger("removed", {
            content: null,
            position: t
        }))
    }, r.prototype.preloadAutoWidthImages = function(e) {
        e.each(t.proxy(function(e, n) {
            this.enter("pre-loading"), n = t(n), t(new Image).one("load", t.proxy(function(t) {
                n.attr("src", t.target.src), n.css("opacity", 1), this.leave("pre-loading"), !this.is("pre-loading") && !this.is("initializing") && this.refresh()
            }, this)).attr("src", n.attr("src") || n.attr("data-src") || n.attr("data-src-retina"))
        }, this))
    }, r.prototype.destroy = function() {
        this.$element.off(".owl.core"), this.$stage.off(".owl.core"), t(n).off(".owl.core"), !1 !== this.settings.responsive && (e.clearTimeout(this.resizeTimer), this.off(e, "resize", this._handlers.onThrottledResize));
        for (var i in this._plugins) this._plugins[i].destroy();
        this.$stage.children(".cloned").remove(), this.$stage.unwrap(), this.$stage.children().contents().unwrap(), this.$stage.children().unwrap(), this.$stage.remove(), this.$element.removeClass(this.options.refreshClass).removeClass(this.options.loadingClass).removeClass(this.options.loadedClass).removeClass(this.options.rtlClass).removeClass(this.options.dragClass).removeClass(this.options.grabClass).attr("class", this.$element.attr("class").replace(new RegExp(this.options.responsiveClass + "-\\S+\\s", "g"), "")).removeData("owl.carousel")
    }, r.prototype.op = function(t, e, n) {
        var i = this.settings.rtl;
        switch (e) {
            case "<":
                return i ? t > n : t < n;
            case ">":
                return i ? t < n : t > n;
            case ">=":
                return i ? t <= n : t >= n;
            case "<=":
                return i ? t >= n : t <= n
        }
    }, r.prototype.on = function(t, e, n, i) {
        t.addEventListener ? t.addEventListener(e, n, i) : t.attachEvent && t.attachEvent("on" + e, n)
    }, r.prototype.off = function(t, e, n, i) {
        t.removeEventListener ? t.removeEventListener(e, n, i) : t.detachEvent && t.detachEvent("on" + e, n)
    }, r.prototype.trigger = function(e, n, i, o, s) {
        var a = {
                item: {
                    count: this._items.length,
                    index: this.current()
                }
            },
            l = t.camelCase(t.grep(["on", e, i], function(t) {
                return t
            }).join("-").toLowerCase()),
            u = t.Event([e, "owl", i || "carousel"].join(".").toLowerCase(), t.extend({
                relatedTarget: this
            }, a, n));
        return this._supress[e] || (t.each(this._plugins, function(t, e) {
            e.onTrigger && e.onTrigger(u)
        }), this.register({
            type: r.Type.Event,
            name: e
        }), this.$element.trigger(u), this.settings && "function" == typeof this.settings[l] && this.settings[l].call(this, u)), u
    }, r.prototype.enter = function(e) {
        t.each([e].concat(this._states.tags[e] || []), t.proxy(function(t, e) {
            this._states.current[e] === i && (this._states.current[e] = 0), this._states.current[e]++
        }, this))
    }, r.prototype.leave = function(e) {
        t.each([e].concat(this._states.tags[e] || []), t.proxy(function(t, e) {
            this._states.current[e]--
        }, this))
    }, r.prototype.register = function(e) {
        if (e.type === r.Type.Event) {
            if (t.event.special[e.name] || (t.event.special[e.name] = {}), !t.event.special[e.name].owl) {
                var n = t.event.special[e.name]._default;
                t.event.special[e.name]._default = function(t) {
                    return !n || !n.apply || t.namespace && -1 !== t.namespace.indexOf("owl") ? t.namespace && t.namespace.indexOf("owl") > -1 : n.apply(this, arguments)
                }, t.event.special[e.name].owl = !0
            }
        } else e.type === r.Type.State && (this._states.tags[e.name] ? this._states.tags[e.name] = this._states.tags[e.name].concat(e.tags) : this._states.tags[e.name] = e.tags, this._states.tags[e.name] = t.grep(this._states.tags[e.name], t.proxy(function(n, i) {
            return t.inArray(n, this._states.tags[e.name]) === i
        }, this)))
    }, r.prototype.suppress = function(e) {
        t.each(e, t.proxy(function(t, e) {
            this._supress[e] = !0
        }, this))
    }, r.prototype.release = function(e) {
        t.each(e, t.proxy(function(t, e) {
            delete this._supress[e]
        }, this))
    }, r.prototype.pointer = function(t) {
        var n = {
            x: null,
            y: null
        };
        return t = t.originalEvent || t || e.event, t = t.touches && t.touches.length ? t.touches[0] : t.changedTouches && t.changedTouches.length ? t.changedTouches[0] : t, t.pageX ? (n.x = t.pageX, n.y = t.pageY) : (n.x = t.clientX, n.y = t.clientY), n
    }, r.prototype.isNumeric = function(t) {
        return !isNaN(parseFloat(t))
    }, r.prototype.difference = function(t, e) {
        return {
            x: t.x - e.x,
            y: t.y - e.y
        }
    }, t.fn.owlCarousel = function(e) {
        var n = Array.prototype.slice.call(arguments, 1);
        return this.each(function() {
            var i = t(this),
                o = i.data("owl.carousel");
            o || (o = new r(this, "object" == typeof e && e), i.data("owl.carousel", o), t.each(["next", "prev", "to", "destroy", "refresh", "replace", "add", "remove"], function(e, n) {
                o.register({
                    type: r.Type.Event,
                    name: n
                }), o.$element.on(n + ".owl.carousel.core", t.proxy(function(t) {
                    t.namespace && t.relatedTarget !== this && (this.suppress([n]), o[n].apply(this, [].slice.call(arguments, 1)), this.release([n]))
                }, o))
            })), "string" == typeof e && "_" !== e.charAt(0) && o[e].apply(o, n)
        })
    }, t.fn.owlCarousel.Constructor = r
}(window.Zepto || window.jQuery, window, document),
function(t, e, n, i) {
    var r = function(e) {
        this._core = e, this._interval = null, this._visible = null, this._handlers = {
            "initialized.owl.carousel": t.proxy(function(t) {
                t.namespace && this._core.settings.autoRefresh && this.watch()
            }, this)
        }, this._core.options = t.extend({}, r.Defaults, this._core.options), this._core.$element.on(this._handlers)
    };
    r.Defaults = {
        autoRefresh: !0,
        autoRefreshInterval: 500
    }, r.prototype.watch = function() {
        this._interval || (this._visible = this._core.isVisible(), this._interval = e.setInterval(t.proxy(this.refresh, this), this._core.settings.autoRefreshInterval))
    }, r.prototype.refresh = function() {
        this._core.isVisible() !== this._visible && (this._visible = !this._visible, this._core.$element.toggleClass("owl-hidden", !this._visible), this._visible && this._core.invalidate("width") && this._core.refresh())
    }, r.prototype.destroy = function() {
        var t, n;
        e.clearInterval(this._interval);
        for (t in this._handlers) this._core.$element.off(t, this._handlers[t]);
        for (n in Object.getOwnPropertyNames(this)) "function" != typeof this[n] && (this[n] = null)
    }, t.fn.owlCarousel.Constructor.Plugins.AutoRefresh = r
}(window.Zepto || window.jQuery, window, document),
function(t, e, n, i) {
    var r = function(e) {
        this._core = e, this._loaded = [], this._handlers = {
            "initialized.owl.carousel change.owl.carousel resized.owl.carousel": t.proxy(function(e) {
                if (e.namespace && this._core.settings && this._core.settings.lazyLoad && (e.property && "position" == e.property.name || "initialized" == e.type)) {
                    var n = this._core.settings,
                        i = n.center && Math.ceil(n.items / 2) || n.items,
                        r = n.center && -1 * i || 0,
                        o = (e.property && void 0 !== e.property.value ? e.property.value : this._core.current()) + r,
                        s = this._core.clones().length,
                        a = t.proxy(function(t, e) {
                            this.load(e)
                        }, this);
                    for (n.lazyLoadEager > 0 && (i += n.lazyLoadEager, n.loop && (o -= n.lazyLoadEager, i++)); r++ < i;) this.load(s / 2 + this._core.relative(o)), s && t.each(this._core.clones(this._core.relative(o)), a), o++
                }
            }, this)
        }, this._core.options = t.extend({}, r.Defaults, this._core.options), this._core.$element.on(this._handlers)
    };
    r.Defaults = {
        lazyLoad: !1,
        lazyLoadEager: 0
    }, r.prototype.load = function(n) {
        var i = this._core.$stage.children().eq(n),
            r = i && i.find(".owl-lazy");
        !r || t.inArray(i.get(0), this._loaded) > -1 || (r.each(t.proxy(function(n, i) {
            var r, o = t(i),
                s = e.devicePixelRatio > 1 && o.attr("data-src-retina") || o.attr("data-src") || o.attr("data-srcset");
            this._core.trigger("load", {
                element: o,
                url: s
            }, "lazy"), o.is("img") ? o.one("load.owl.lazy", t.proxy(function() {
                o.css("opacity", 1), this._core.trigger("loaded", {
                    element: o,
                    url: s
                }, "lazy")
            }, this)).attr("src", s) : o.is("source") ? o.one("load.owl.lazy", t.proxy(function() {
                this._core.trigger("loaded", {
                    element: o,
                    url: s
                }, "lazy")
            }, this)).attr("srcset", s) : (r = new Image, r.onload = t.proxy(function() {
                o.css({
                    "background-image": 'url("' + s + '")',
                    opacity: "1"
                }), this._core.trigger("loaded", {
                    element: o,
                    url: s
                }, "lazy")
            }, this), r.src = s)
        }, this)), this._loaded.push(i.get(0)))
    }, r.prototype.destroy = function() {
        var t, e;
        for (t in this.handlers) this._core.$element.off(t, this.handlers[t]);
        for (e in Object.getOwnPropertyNames(this)) "function" != typeof this[e] && (this[e] = null)
    }, t.fn.owlCarousel.Constructor.Plugins.Lazy = r
}(window.Zepto || window.jQuery, window, document),
function(t, e, n, i) {
    var r = function(n) {
        this._core = n, this._previousHeight = null, this._handlers = {
            "initialized.owl.carousel refreshed.owl.carousel": t.proxy(function(t) {
                t.namespace && this._core.settings.autoHeight && this.update()
            }, this),
            "changed.owl.carousel": t.proxy(function(t) {
                t.namespace && this._core.settings.autoHeight && "position" === t.property.name && this.update()
            }, this),
            "loaded.owl.lazy": t.proxy(function(t) {
                t.namespace && this._core.settings.autoHeight && t.element.closest("." + this._core.settings.itemClass).index() === this._core.current() && this.update()
            }, this)
        }, this._core.options = t.extend({}, r.Defaults, this._core.options), this._core.$element.on(this._handlers), this._intervalId = null;
        var i = this;
        t(e).on("load", function() {
            i._core.settings.autoHeight && i.update()
        }), t(e).resize(function() {
            i._core.settings.autoHeight && (null != i._intervalId && clearTimeout(i._intervalId), i._intervalId = setTimeout(function() {
                i.update()
            }, 250))
        })
    };
    r.Defaults = {
        autoHeight: !1,
        autoHeightClass: "owl-height"
    }, r.prototype.update = function() {
        var e = this._core._current,
            n = e + this._core.settings.items,
            i = this._core.settings.lazyLoad,
            r = this._core.$stage.children().toArray().slice(e, n),
            o = [],
            s = 0;
        t.each(r, function(e, n) {
            o.push(t(n).height())
        }), s = Math.max.apply(null, o), s <= 1 && i && this._previousHeight && (s = this._previousHeight), this._previousHeight = s, this._core.$stage.parent().height(s).addClass(this._core.settings.autoHeightClass)
    }, r.prototype.destroy = function() {
        var t, e;
        for (t in this._handlers) this._core.$element.off(t, this._handlers[t]);
        for (e in Object.getOwnPropertyNames(this)) "function" != typeof this[e] && (this[e] = null)
    }, t.fn.owlCarousel.Constructor.Plugins.AutoHeight = r
}(window.Zepto || window.jQuery, window, document),
function(t, e, n, i) {
    var r = function(e) {
        this._core = e, this._videos = {}, this._playing = null, this._handlers = {
            "initialized.owl.carousel": t.proxy(function(t) {
                t.namespace && this._core.register({
                    type: "state",
                    name: "playing",
                    tags: ["interacting"]
                })
            }, this),
            "resize.owl.carousel": t.proxy(function(t) {
                t.namespace && this._core.settings.video && this.isInFullScreen() && t.preventDefault()
            }, this),
            "refreshed.owl.carousel": t.proxy(function(t) {
                t.namespace && this._core.is("resizing") && this._core.$stage.find(".cloned .owl-video-frame").remove()
            }, this),
            "changed.owl.carousel": t.proxy(function(t) {
                t.namespace && "position" === t.property.name && this._playing && this.stop()
            }, this),
            "prepared.owl.carousel": t.proxy(function(e) {
                if (e.namespace) {
                    var n = t(e.content).find(".owl-video");
                    n.length && (n.css("display", "none"), this.fetch(n, t(e.content)))
                }
            }, this)
        }, this._core.options = t.extend({}, r.Defaults, this._core.options), this._core.$element.on(this._handlers), this._core.$element.on("click.owl.video", ".owl-video-play-icon", t.proxy(function(t) {
            this.play(t)
        }, this))
    };
    r.Defaults = {
        video: !1,
        videoHeight: !1,
        videoWidth: !1
    }, r.prototype.fetch = function(t, e) {
        var n = function() {
                return t.attr("data-vimeo-id") ? "vimeo" : t.attr("data-vzaar-id") ? "vzaar" : "youtube"
            }(),
            i = t.attr("data-vimeo-id") || t.attr("data-youtube-id") || t.attr("data-vzaar-id"),
            r = t.attr("data-width") || this._core.settings.videoWidth,
            o = t.attr("data-height") || this._core.settings.videoHeight,
            s = t.attr("href");
        if (!s) throw new Error("Missing video URL.");
        if (i = s.match(/(http:|https:|)\/\/(player.|www.|app.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com|be\-nocookie\.com)|vzaar\.com)\/(video\/|videos\/|embed\/|channels\/.+\/|groups\/.+\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/), i[3].indexOf("youtu") > -1) n = "youtube";
        else if (i[3].indexOf("vimeo") > -1) n = "vimeo";
        else {
            if (!(i[3].indexOf("vzaar") > -1)) throw new Error("Video URL not supported.");
            n = "vzaar"
        }
        i = i[6], this._videos[s] = {
            type: n,
            id: i,
            width: r,
            height: o
        }, e.attr("data-video", s), this.thumbnail(t, this._videos[s])
    }, r.prototype.thumbnail = function(e, n) {
        var i, r, o, s = n.width && n.height ? "width:" + n.width + "px;height:" + n.height + "px;" : "",
            a = e.find("img"),
            l = "src",
            u = "",
            c = this._core.settings,
            p = function(n) {
                r = '<div class="owl-video-play-icon"></div>', i = c.lazyLoad ? t("<div/>", {
                    class: "owl-video-tn " + u,
                    srcType: n
                }) : t("<div/>", {
                    class: "owl-video-tn",
                    style: "opacity:1;background-image:url(" + n + ")"
                }), e.after(i), e.after(r)
            };
        if (e.wrap(t("<div/>", {
                class: "owl-video-wrapper",
                style: s
            })), this._core.settings.lazyLoad && (l = "data-src", u = "owl-lazy"), a.length) return p(a.attr(l)), a.remove(), !1;
        "youtube" === n.type ? (o = "//img.youtube.com/vi/" + n.id + "/hqdefault.jpg", p(o)) : "vimeo" === n.type ? t.ajax({
            type: "GET",
            url: "//vimeo.com/api/v2/video/" + n.id + ".json",
            jsonp: "callback",
            dataType: "jsonp",
            success: function(t) {
                o = t[0].thumbnail_large, p(o)
            }
        }) : "vzaar" === n.type && t.ajax({
            type: "GET",
            url: "//vzaar.com/api/videos/" + n.id + ".json",
            jsonp: "callback",
            dataType: "jsonp",
            success: function(t) {
                o = t.framegrab_url, p(o)
            }
        })
    }, r.prototype.stop = function() {
        this._core.trigger("stop", null, "video"), this._playing.find(".owl-video-frame").remove(), this._playing.removeClass("owl-video-playing"), this._playing = null, this._core.leave("playing"), this._core.trigger("stopped", null, "video")
    }, r.prototype.play = function(e) {
        var n, i = t(e.target),
            r = i.closest("." + this._core.settings.itemClass),
            o = this._videos[r.attr("data-video")],
            s = o.width || "100%",
            a = o.height || this._core.$stage.height();
        this._playing || (this._core.enter("playing"), this._core.trigger("play", null, "video"), r = this._core.items(this._core.relative(r.index())), this._core.reset(r.index()), n = t('<iframe frameborder="0" allowfullscreen mozallowfullscreen webkitAllowFullScreen ></iframe>'), n.attr("height", a), n.attr("width", s), "youtube" === o.type ? n.attr("src", "//www.youtube.com/embed/" + o.id + "?autoplay=1&rel=0&v=" + o.id) : "vimeo" === o.type ? n.attr("src", "//player.vimeo.com/video/" + o.id + "?autoplay=1") : "vzaar" === o.type && n.attr("src", "//view.vzaar.com/" + o.id + "/player?autoplay=true"), t(n).wrap('<div class="owl-video-frame" />').insertAfter(r.find(".owl-video")), this._playing = r.addClass("owl-video-playing"))
    }, r.prototype.isInFullScreen = function() {
        var e = n.fullscreenElement || n.mozFullScreenElement || n.webkitFullscreenElement;
        return e && t(e).parent().hasClass("owl-video-frame")
    }, r.prototype.destroy = function() {
        var t, e;
        this._core.$element.off("click.owl.video");
        for (t in this._handlers) this._core.$element.off(t, this._handlers[t]);
        for (e in Object.getOwnPropertyNames(this)) "function" != typeof this[e] && (this[e] = null)
    }, t.fn.owlCarousel.Constructor.Plugins.Video = r
}(window.Zepto || window.jQuery, window, document),
function(t, e, n, i) {
    var r = function(e) {
        this.core = e, this.core.options = t.extend({}, r.Defaults, this.core.options), this.swapping = !0, this.previous = i, this.next = i, this.handlers = {
            "change.owl.carousel": t.proxy(function(t) {
                t.namespace && "position" == t.property.name && (this.previous = this.core.current(), this.next = t.property.value)
            }, this),
            "drag.owl.carousel dragged.owl.carousel translated.owl.carousel": t.proxy(function(t) {
                t.namespace && (this.swapping = "translated" == t.type)
            }, this),
            "translate.owl.carousel": t.proxy(function(t) {
                t.namespace && this.swapping && (this.core.options.animateOut || this.core.options.animateIn) && this.swap()
            }, this)
        }, this.core.$element.on(this.handlers)
    };
    r.Defaults = {
        animateOut: !1,
        animateIn: !1
    }, r.prototype.swap = function() {
        if (1 === this.core.settings.items && t.support.animation && t.support.transition) {
            this.core.speed(0);
            var e, n = t.proxy(this.clear, this),
                i = this.core.$stage.children().eq(this.previous),
                r = this.core.$stage.children().eq(this.next),
                o = this.core.settings.animateIn,
                s = this.core.settings.animateOut;
            this.core.current() !== this.previous && (s && (e = this.core.coordinates(this.previous) - this.core.coordinates(this.next), i.one(t.support.animation.end, n).css({
                left: e + "px"
            }).addClass("animated owl-animated-out").addClass(s)), o && r.one(t.support.animation.end, n).addClass("animated owl-animated-in").addClass(o))
        }
    }, r.prototype.clear = function(e) {
        t(e.target).css({
            left: ""
        }).removeClass("animated owl-animated-out owl-animated-in").removeClass(this.core.settings.animateIn).removeClass(this.core.settings.animateOut), this.core.onTransitionEnd()
    }, r.prototype.destroy = function() {
        var t, e;
        for (t in this.handlers) this.core.$element.off(t, this.handlers[t]);
        for (e in Object.getOwnPropertyNames(this)) "function" != typeof this[e] && (this[e] = null)
    }, t.fn.owlCarousel.Constructor.Plugins.Animate = r
}(window.Zepto || window.jQuery, window, document),
function(t, e, n, i) {
    var r = function(e) {
        this._core = e, this._call = null, this._time = 0, this._timeout = 0, this._paused = !0, this._handlers = {
            "changed.owl.carousel": t.proxy(function(t) {
                t.namespace && "settings" === t.property.name ? this._core.settings.autoplay ? this.play() : this.stop() : t.namespace && "position" === t.property.name && this._paused && (this._time = 0)
            }, this),
            "initialized.owl.carousel": t.proxy(function(t) {
                t.namespace && this._core.settings.autoplay && this.play()
            }, this),
            "play.owl.autoplay": t.proxy(function(t, e, n) {
                t.namespace && this.play(e, n)
            }, this),
            "stop.owl.autoplay": t.proxy(function(t) {
                t.namespace && this.stop()
            }, this),
            "mouseover.owl.autoplay": t.proxy(function() {
                this._core.settings.autoplayHoverPause && this._core.is("rotating") && this.pause()
            }, this),
            "mouseleave.owl.autoplay": t.proxy(function() {
                this._core.settings.autoplayHoverPause && this._core.is("rotating") && this.play()
            }, this),
            "touchstart.owl.core": t.proxy(function() {
                this._core.settings.autoplayHoverPause && this._core.is("rotating") && this.pause()
            }, this),
            "touchend.owl.core": t.proxy(function() {
                this._core.settings.autoplayHoverPause && this.play()
            }, this)
        }, this._core.$element.on(this._handlers), this._core.options = t.extend({}, r.Defaults, this._core.options)
    };
    r.Defaults = {
        autoplay: !1,
        autoplayTimeout: 5e3,
        autoplayHoverPause: !1,
        autoplaySpeed: !1
    }, r.prototype._next = function(i) {
        this._call = e.setTimeout(t.proxy(this._next, this, i), this._timeout * (Math.round(this.read() / this._timeout) + 1) - this.read()), this._core.is("interacting") || n.hidden || this._core.next(i || this._core.settings.autoplaySpeed)
    }, r.prototype.read = function() {
        return (new Date).getTime() - this._time
    }, r.prototype.play = function(n, i) {
        var r;
        this._core.is("rotating") || this._core.enter("rotating"), n = n || this._core.settings.autoplayTimeout, r = Math.min(this._time % (this._timeout || n), n), this._paused ? (this._time = this.read(), this._paused = !1) : e.clearTimeout(this._call), this._time += this.read() % n - r, this._timeout = n, this._call = e.setTimeout(t.proxy(this._next, this, i), n - r)
    }, r.prototype.stop = function() {
        this._core.is("rotating") && (this._time = 0, this._paused = !0, e.clearTimeout(this._call), this._core.leave("rotating"))
    }, r.prototype.pause = function() {
        this._core.is("rotating") && !this._paused && (this._time = this.read(), this._paused = !0, e.clearTimeout(this._call))
    }, r.prototype.destroy = function() {
        var t, e;
        this.stop();
        for (t in this._handlers) this._core.$element.off(t, this._handlers[t]);
        for (e in Object.getOwnPropertyNames(this)) "function" != typeof this[e] && (this[e] = null)
    }, t.fn.owlCarousel.Constructor.Plugins.autoplay = r
}(window.Zepto || window.jQuery, window, document),
function(t, e, n, i) {
    "use strict";
    var r = function(e) {
        this._core = e, this._initialized = !1, this._pages = [], this._controls = {}, this._templates = [], this.$element = this._core.$element, this._overrides = {
            next: this._core.next,
            prev: this._core.prev,
            to: this._core.to
        }, this._handlers = {
            "prepared.owl.carousel": t.proxy(function(e) {
                e.namespace && this._core.settings.dotsData && this._templates.push('<div class="' + this._core.settings.dotClass + '">' + t(e.content).find("[data-dot]").addBack("[data-dot]").attr("data-dot") + "</div>")
            }, this),
            "added.owl.carousel": t.proxy(function(t) {
                t.namespace && this._core.settings.dotsData && this._templates.splice(t.position, 0, this._templates.pop())
            }, this),
            "remove.owl.carousel": t.proxy(function(t) {
                t.namespace && this._core.settings.dotsData && this._templates.splice(t.position, 1)
            }, this),
            "changed.owl.carousel": t.proxy(function(t) {
                t.namespace && "position" == t.property.name && this.draw()
            }, this),
            "initialized.owl.carousel": t.proxy(function(t) {
                t.namespace && !this._initialized && (this._core.trigger("initialize", null, "navigation"), this.initialize(), this.update(), this.draw(), this._initialized = !0, this._core.trigger("initialized", null, "navigation"))
            }, this),
            "refreshed.owl.carousel": t.proxy(function(t) {
                t.namespace && this._initialized && (this._core.trigger("refresh", null, "navigation"), this.update(), this.draw(), this._core.trigger("refreshed", null, "navigation"))
            }, this)
        }, this._core.options = t.extend({}, r.Defaults, this._core.options), this.$element.on(this._handlers)
    };
    r.Defaults = {
        nav: !1,
        navText: ['<span aria-label="Previous">&#x2039;</span>', '<span aria-label="Next">&#x203a;</span>'],
        navSpeed: !1,
        navElement: 'button type="button" role="presentation"',
        navContainer: !1,
        navContainerClass: "owl-nav",
        navClass: ["owl-prev", "owl-next"],
        slideBy: 1,
        dotClass: "owl-dot",
        dotsClass: "owl-dots",
        dots: !0,
        dotsEach: !1,
        dotsData: !1,
        dotsSpeed: !1,
        dotsContainer: !1
    }, r.prototype.initialize = function() {
        var e, n = this._core.settings;
        this._controls.$relative = (n.navContainer ? t(n.navContainer) : t("<div>").addClass(n.navContainerClass).appendTo(this.$element)).addClass("disabled"), this._controls.$previous = t("<" + n.navElement + ">").addClass(n.navClass[0]).html(n.navText[0]).prependTo(this._controls.$relative).on("click", t.proxy(function(t) {
            this.prev(n.navSpeed)
        }, this)), this._controls.$next = t("<" + n.navElement + ">").addClass(n.navClass[1]).html(n.navText[1]).appendTo(this._controls.$relative).on("click", t.proxy(function(t) {
            this.next(n.navSpeed)
        }, this)), n.dotsData || (this._templates = [t('<button role="button">').addClass(n.dotClass).append(t("<span>")).prop("outerHTML")]), this._controls.$absolute = (n.dotsContainer ? t(n.dotsContainer) : t("<div>").addClass(n.dotsClass).appendTo(this.$element)).addClass("disabled"), this._controls.$absolute.on("click", "button", t.proxy(function(e) {
            var i = t(e.target).parent().is(this._controls.$absolute) ? t(e.target).index() : t(e.target).parent().index();
            e.preventDefault(), this.to(i, n.dotsSpeed)
        }, this));
        for (e in this._overrides) this._core[e] = t.proxy(this[e], this)
    }, r.prototype.destroy = function() {
        var t, e, n, i, r;
        r = this._core.settings;
        for (t in this._handlers) this.$element.off(t, this._handlers[t]);
        for (e in this._controls) "$relative" === e && r.navContainer ? this._controls[e].html("") : this._controls[e].remove();
        for (i in this.overides) this._core[i] = this._overrides[i];
        for (n in Object.getOwnPropertyNames(this)) "function" != typeof this[n] && (this[n] = null)
    }, r.prototype.update = function() {
        var t, e, n, i = this._core.clones().length / 2,
            r = i + this._core.items().length,
            o = this._core.maximum(!0),
            s = this._core.settings,
            a = s.center || s.autoWidth || s.dotsData ? 1 : s.dotsEach || s.items;
        if ("page" !== s.slideBy && (s.slideBy = Math.min(s.slideBy, s.items)), s.dots || "page" == s.slideBy)
            for (this._pages = [], t = i, e = 0, n = 0; t < r; t++) {
                if (e >= a || 0 === e) {
                    if (this._pages.push({
                            start: Math.min(o, t - i),
                            end: t - i + a - 1
                        }), Math.min(o, t - i) === o) break;
                    e = 0, ++n
                }
                e += this._core.mergers(this._core.relative(t))
            }
    }, r.prototype.draw = function() {
        var e, n = this._core.settings,
            i = this._core.items().length <= n.items,
            r = this._core.relative(this._core.current()),
            o = n.loop || n.rewind;
        this._controls.$relative.toggleClass("disabled", !n.nav || i), n.nav && (this._controls.$previous.toggleClass("disabled", !o && r <= this._core.minimum(!0)), this._controls.$next.toggleClass("disabled", !o && r >= this._core.maximum(!0))), this._controls.$absolute.toggleClass("disabled", !n.dots || i), n.dots && (e = this._pages.length - this._controls.$absolute.children().length, n.dotsData && 0 !== e ? this._controls.$absolute.html(this._templates.join("")) : e > 0 ? this._controls.$absolute.append(new Array(e + 1).join(this._templates[0])) : e < 0 && this._controls.$absolute.children().slice(e).remove(), this._controls.$absolute.find(".active").removeClass("active"), this._controls.$absolute.children().eq(t.inArray(this.current(), this._pages)).addClass("active"))
    }, r.prototype.onTrigger = function(e) {
        var n = this._core.settings;
        e.page = {
            index: t.inArray(this.current(), this._pages),
            count: this._pages.length,
            size: n && (n.center || n.autoWidth || n.dotsData ? 1 : n.dotsEach || n.items)
        }
    }, r.prototype.current = function() {
        var e = this._core.relative(this._core.current());
        return t.grep(this._pages, t.proxy(function(t, n) {
            return t.start <= e && t.end >= e
        }, this)).pop()
    }, r.prototype.getPosition = function(e) {
        var n, i, r = this._core.settings;
        return "page" == r.slideBy ? (n = t.inArray(this.current(), this._pages), i = this._pages.length, e ? ++n : --n, n = this._pages[(n % i + i) % i].start) : (n = this._core.relative(this._core.current()), i = this._core.items().length, e ? n += r.slideBy : n -= r.slideBy), n
    }, r.prototype.next = function(e) {
        t.proxy(this._overrides.to, this._core)(this.getPosition(!0), e)
    }, r.prototype.prev = function(e) {
        t.proxy(this._overrides.to, this._core)(this.getPosition(!1), e)
    }, r.prototype.to = function(e, n, i) {
        var r;
        !i && this._pages.length ? (r = this._pages.length, t.proxy(this._overrides.to, this._core)(this._pages[(e % r + r) % r].start, n)) : t.proxy(this._overrides.to, this._core)(e, n)
    }, t.fn.owlCarousel.Constructor.Plugins.Navigation = r
}(window.Zepto || window.jQuery, window, document),
function(t, e, n, i) {
    "use strict";
    var r = function(n) {
        this._core = n, this._hashes = {}, this.$element = this._core.$element, this._handlers = {
            "initialized.owl.carousel": t.proxy(function(n) {
                n.namespace && "URLHash" === this._core.settings.startPosition && t(e).trigger("hashchange.owl.navigation")
            }, this),
            "prepared.owl.carousel": t.proxy(function(e) {
                if (e.namespace) {
                    var n = t(e.content).find("[data-hash]").addBack("[data-hash]").attr("data-hash");
                    if (!n) return;
                    this._hashes[n] = e.content
                }
            }, this),
            "changed.owl.carousel": t.proxy(function(n) {
                if (n.namespace && "position" === n.property.name) {
                    var i = this._core.items(this._core.relative(this._core.current())),
                        r = t.map(this._hashes, function(t, e) {
                            return t === i ? e : null
                        }).join();
                    if (!r || e.location.hash.slice(1) === r) return;
                    e.location.hash = r
                }
            }, this)
        }, this._core.options = t.extend({}, r.Defaults, this._core.options), this.$element.on(this._handlers), t(e).on("hashchange.owl.navigation", t.proxy(function(t) {
            var n = e.location.hash.substring(1),
                i = this._core.$stage.children(),
                r = this._hashes[n] && i.index(this._hashes[n]);
            void 0 !== r && r !== this._core.current() && this._core.to(this._core.relative(r), !1, !0)
        }, this))
    };
    r.Defaults = {
        URLhashListener: !1
    }, r.prototype.destroy = function() {
        var n, i;
        t(e).off("hashchange.owl.navigation");
        for (n in this._handlers) this._core.$element.off(n, this._handlers[n]);
        for (i in Object.getOwnPropertyNames(this)) "function" != typeof this[i] && (this[i] = null)
    }, t.fn.owlCarousel.Constructor.Plugins.Hash = r
}(window.Zepto || window.jQuery, window, document),
function(t, e, n, i) {
    function r(e, n) {
        var r = !1,
            o = e.charAt(0).toUpperCase() + e.slice(1);
        return t.each((e + " " + a.join(o + " ") + o).split(" "), function(t, e) {
            if (s[e] !== i) return r = !n || e, !1
        }), r
    }

    function o(t) {
        return r(t, !0)
    }
    var s = t("<support>").get(0).style,
        a = "Webkit Moz O ms".split(" "),
        l = {
            transition: {
                end: {
                    WebkitTransition: "webkitTransitionEnd",
                    MozTransition: "transitionend",
                    OTransition: "oTransitionEnd",
                    transition: "transitionend"
                }
            },
            animation: {
                end: {
                    WebkitAnimation: "webkitAnimationEnd",
                    MozAnimation: "animationend",
                    OAnimation: "oAnimationEnd",
                    animation: "animationend"
                }
            }
        },
        u = {
            csstransforms: function() {
                return !!r("transform")
            },
            csstransforms3d: function() {
                return !!r("perspective")
            },
            csstransitions: function() {
                return !!r("transition")
            },
            cssanimations: function() {
                return !!r("animation")
            }
        };
    u.csstransitions() && (t.support.transition = new String(o("transition")), t.support.transition.end = l.transition.end[t.support.transition]), u.cssanimations() && (t.support.animation = new String(o("animation")), t.support.animation.end = l.animation.end[t.support.animation]), u.csstransforms() && (t.support.transform = new String(o("transform")), t.support.transform3d = u.csstransforms3d())
}(window.Zepto || window.jQuery, window, document),
function(t, e) {
    "function" == typeof define && define.amd ? define(["jquery"], e) : "object" == typeof exports ? module.exports = e(require("jquery")) : e(t.jQuery)
}(this, function(t) {
    function e(t) {
        if (t in c.style) return t;
        for (var e = ["Moz", "Webkit", "O", "ms"], n = t.charAt(0).toUpperCase() + t.substr(1), i = 0; i < e.length; ++i) {
            var r = e[i] + n;
            if (r in c.style) return r
        }
    }

    function n(t) {
        return "string" == typeof t && this.parse(t), this
    }

    function i(t, e, n) {
        !0 === e ? t.queue(n) : e ? t.queue(e, n) : t.each(function() {
            n.call(this)
        })
    }

    function r(e) {
        var n = [];
        return t.each(e, function(e) {
            e = t.camelCase(e), e = t.transit.propertyMap[e] || t.cssProps[e] || e, e = a(e), p[e] && (e = a(p[e])), -1 === t.inArray(e, n) && n.push(e)
        }), n
    }

    function o(e, n, i, o) {
        var s = r(e);
        t.cssEase[i] && (i = t.cssEase[i]);
        var a = u(n) + " " + i;
        parseInt(o, 10) > 0 && (a += " " + u(o));
        var l = [];
        return t.each(s, function(t, e) {
            l.push(e + " " + a)
        }), l.join(", ")
    }

    function s(e, n) {
        n || (t.cssNumber[e] = !0), t.transit.propertyMap[e] = p.transform, t.cssHooks[e] = {
            get: function(n) {
                return t(n).css("transit:transform").get(e)
            },
            set: function(n, i) {
                var r = t(n).css("transit:transform");
                r.setFromString(e, i), t(n).css({
                    "transit:transform": r
                })
            }
        }
    }

    function a(t) {
        return t.replace(/([A-Z])/g, function(t) {
            return "-" + t.toLowerCase()
        })
    }

    function l(t, e) {
        return "string" != typeof t || t.match(/^[\-0-9\.]+$/) ? "" + t + e : t
    }

    function u(e) {
        var n = e;
        return "string" != typeof n || n.match(/^[\-0-9\.]+/) || (n = t.fx.speeds[n] || t.fx.speeds._default), l(n, "ms")
    }
    t.transit = {
        version: "0.9.12",
        propertyMap: {
            marginLeft: "margin",
            marginRight: "margin",
            marginBottom: "margin",
            marginTop: "margin",
            paddingLeft: "padding",
            paddingRight: "padding",
            paddingBottom: "padding",
            paddingTop: "padding"
        },
        enabled: !0,
        useTransitionEnd: !1
    };
    var c = document.createElement("div"),
        p = {},
        h = navigator.userAgent.toLowerCase().indexOf("chrome") > -1;
    p.transition = e("transition"), p.transitionDelay = e("transitionDelay"), p.transform = e("transform"), p.transformOrigin = e("transformOrigin"), p.filter = e("Filter"), p.transform3d = function() {
        return c.style[p.transform] = "", c.style[p.transform] = "rotateY(90deg)", "" !== c.style[p.transform]
    }();
    var d = {
            transition: "transitionend",
            MozTransition: "transitionend",
            OTransition: "oTransitionEnd",
            WebkitTransition: "webkitTransitionEnd",
            msTransition: "MSTransitionEnd"
        },
        f = p.transitionEnd = d[p.transition] || null;
    for (var g in p) p.hasOwnProperty(g) && void 0 === t.support[g] && (t.support[g] = p[g]);
    return c = null, t.cssEase = {
        _default: "ease",
        in: "ease-in",
        out: "ease-out",
        "in-out": "ease-in-out",
        snap: "cubic-bezier(0,1,.5,1)",
        easeInCubic: "cubic-bezier(.550,.055,.675,.190)",
        easeOutCubic: "cubic-bezier(.215,.61,.355,1)",
        easeInOutCubic: "cubic-bezier(.645,.045,.355,1)",
        easeInCirc: "cubic-bezier(.6,.04,.98,.335)",
        easeOutCirc: "cubic-bezier(.075,.82,.165,1)",
        easeInOutCirc: "cubic-bezier(.785,.135,.15,.86)",
        easeInExpo: "cubic-bezier(.95,.05,.795,.035)",
        easeOutExpo: "cubic-bezier(.19,1,.22,1)",
        easeInOutExpo: "cubic-bezier(1,0,0,1)",
        easeInQuad: "cubic-bezier(.55,.085,.68,.53)",
        easeOutQuad: "cubic-bezier(.25,.46,.45,.94)",
        easeInOutQuad: "cubic-bezier(.455,.03,.515,.955)",
        easeInQuart: "cubic-bezier(.895,.03,.685,.22)",
        easeOutQuart: "cubic-bezier(.165,.84,.44,1)",
        easeInOutQuart: "cubic-bezier(.77,0,.175,1)",
        easeInQuint: "cubic-bezier(.755,.05,.855,.06)",
        easeOutQuint: "cubic-bezier(.23,1,.32,1)",
        easeInOutQuint: "cubic-bezier(.86,0,.07,1)",
        easeInSine: "cubic-bezier(.47,0,.745,.715)",
        easeOutSine: "cubic-bezier(.39,.575,.565,1)",
        easeInOutSine: "cubic-bezier(.445,.05,.55,.95)",
        easeInBack: "cubic-bezier(.6,-.28,.735,.045)",
        easeOutBack: "cubic-bezier(.175, .885,.32,1.275)",
        easeInOutBack: "cubic-bezier(.68,-.55,.265,1.55)"
    }, t.cssHooks["transit:transform"] = {
        get: function(e) {
            return t(e).data("transform") || new n
        },
        set: function(e, i) {
            var r = i;
            r instanceof n || (r = new n(r)), "WebkitTransform" !== p.transform || h ? e.style[p.transform] = r.toString() : e.style[p.transform] = r.toString(!0), t(e).data("transform", r)
        }
    }, t.cssHooks.transform = {
        set: t.cssHooks["transit:transform"].set
    }, t.cssHooks.filter = {
        get: function(t) {
            return t.style[p.filter]
        },
        set: function(t, e) {
            t.style[p.filter] = e
        }
    }, t.fn.jquery < "1.8" && (t.cssHooks.transformOrigin = {
        get: function(t) {
            return t.style[p.transformOrigin]
        },
        set: function(t, e) {
            t.style[p.transformOrigin] = e
        }
    }, t.cssHooks.transition = {
        get: function(t) {
            return t.style[p.transition]
        },
        set: function(t, e) {
            t.style[p.transition] = e
        }
    }), s("scale"), s("scaleX"), s("scaleY"), s("translate"), s("rotate"), s("rotateX"), s("rotateY"), s("rotate3d"), s("perspective"), s("skewX"), s("skewY"), s("x", !0), s("y", !0), n.prototype = {
        setFromString: function(t, e) {
            var i = "string" == typeof e ? e.split(",") : e.constructor === Array ? e : [e];
            i.unshift(t), n.prototype.set.apply(this, i)
        },
        set: function(t) {
            var e = Array.prototype.slice.apply(arguments, [1]);
            this.setter[t] ? this.setter[t].apply(this, e) : this[t] = e.join(",")
        },
        get: function(t) {
            return this.getter[t] ? this.getter[t].apply(this) : this[t] || 0
        },
        setter: {
            rotate: function(t) {
                this.rotate = l(t, "deg")
            },
            rotateX: function(t) {
                this.rotateX = l(t, "deg")
            },
            rotateY: function(t) {
                this.rotateY = l(t, "deg")
            },
            scale: function(t, e) {
                void 0 === e && (e = t), this.scale = t + "," + e
            },
            skewX: function(t) {
                this.skewX = l(t, "deg")
            },
            skewY: function(t) {
                this.skewY = l(t, "deg")
            },
            perspective: function(t) {
                this.perspective = l(t, "px")
            },
            x: function(t) {
                this.set("translate", t, null)
            },
            y: function(t) {
                this.set("translate", null, t)
            },
            translate: function(t, e) {
                void 0 === this._translateX && (this._translateX = 0), void 0 === this._translateY && (this._translateY = 0), null !== t && void 0 !== t && (this._translateX = l(t, "px")), null !== e && void 0 !== e && (this._translateY = l(e, "px")), this.translate = this._translateX + "," + this._translateY
            }
        },
        getter: {
            x: function() {
                return this._translateX || 0
            },
            y: function() {
                return this._translateY || 0
            },
            scale: function() {
                var t = (this.scale || "1,1").split(",");
                return t[0] && (t[0] = parseFloat(t[0])), t[1] && (t[1] = parseFloat(t[1])), t[0] === t[1] ? t[0] : t
            },
            rotate3d: function() {
                for (var t = (this.rotate3d || "0,0,0,0deg").split(","), e = 0; e <= 3; ++e) t[e] && (t[e] = parseFloat(t[e]));
                return t[3] && (t[3] = l(t[3], "deg")), t
            }
        },
        parse: function(t) {
            var e = this;
            t.replace(/([a-zA-Z0-9]+)\((.*?)\)/g, function(t, n, i) {
                e.setFromString(n, i)
            })
        },
        toString: function(t) {
            var e = [];
            for (var n in this)
                if (this.hasOwnProperty(n)) {
                    if (!p.transform3d && ("rotateX" === n || "rotateY" === n || "perspective" === n || "transformOrigin" === n)) continue;
                    "_" !== n[0] && (t && "scale" === n ? e.push(n + "3d(" + this[n] + ",1)") : t && "translate" === n ? e.push(n + "3d(" + this[n] + ",0)") : e.push(n + "(" + this[n] + ")"))
                } return e.join(" ")
        }
    }, t.fn.transition = t.fn.transit = function(e, n, r, s) {
        var a = this,
            l = 0,
            c = !0,
            h = t.extend(!0, {}, e);
        "function" == typeof n && (s = n, n = void 0), "object" == typeof n && (r = n.easing, l = n.delay || 0, c = void 0 === n.queue || n.queue, s = n.complete, n = n.duration), "function" == typeof r && (s = r, r = void 0), void 0 !== h.easing && (r = h.easing, delete h.easing), void 0 !== h.duration && (n = h.duration, delete h.duration), void 0 !== h.complete && (s = h.complete, delete h.complete), void 0 !== h.queue && (c = h.queue, delete h.queue), void 0 !== h.delay && (l = h.delay, delete h.delay), void 0 === n && (n = t.fx.speeds._default), void 0 === r && (r = t.cssEase._default), n = u(n);
        var d = o(h, n, r, l),
            g = t.transit.enabled && p.transition,
            m = g ? parseInt(n, 10) + parseInt(l, 10) : 0;
        if (0 === m) {
            return i(a, c, function(t) {
                a.css(h), s && s.apply(a), t && t()
            }), a
        }
        var v = {},
            y = function(e) {
                var n = !1,
                    i = function() {
                        n && a.unbind(f, i), m > 0 && a.each(function() {
                            this.style[p.transition] = v[this] || null
                        }), "function" == typeof s && s.apply(a), "function" == typeof e && e()
                    };
                m > 0 && f && t.transit.useTransitionEnd ? (n = !0, a.bind(f, i)) : window.setTimeout(i, m), a.each(function() {
                    m > 0 && (this.style[p.transition] = d), t(this).css(h)
                })
            };
        return i(a, c, function(t) {
            this.offsetWidth, y(t)
        }), this
    }, t.transit.getTransitionValue = o, t
}),
function(t) {
    "function" == typeof define && define.amd ? define(["jquery"], t) : t("object" == typeof exports ? require("jquery") : window.jQuery || window.Zepto)
}(function(t) {
    var e, n, i, r, o, s, a = "Close",
        l = "BeforeClose",
        u = "MarkupParse",
        c = "Open",
        p = "Change",
        h = "mfp",
        d = "." + h,
        f = "mfp-ready",
        g = "mfp-removing",
        m = "mfp-prevent-close",
        v = function() {},
        y = !!window.jQuery,
        w = t(window),
        x = function(t, n) {
            e.ev.on(h + t + d, n)
        },
        b = function(e, n, i, r) {
            var o = document.createElement("div");
            return o.className = "mfp-" + e, i && (o.innerHTML = i), r ? n && n.appendChild(o) : (o = t(o), n && o.appendTo(n)), o
        },
        _ = function(n, i) {
            e.ev.triggerHandler(h + n, i), e.st.callbacks && (n = n.charAt(0).toLowerCase() + n.slice(1), e.st.callbacks[n] && e.st.callbacks[n].apply(e, t.isArray(i) ? i : [i]))
        },
        C = function(n) {
            return n === s && e.currTemplate.closeBtn || (e.currTemplate.closeBtn = t(e.st.closeMarkup.replace("%title%", e.st.tClose)), s = n), e.currTemplate.closeBtn
        },
        T = function() {
            t.magnificPopup.instance || (e = new v, e.init(), t.magnificPopup.instance = e)
        },
        E = function() {
            var t = document.createElement("p").style,
                e = ["ms", "O", "Moz", "Webkit"];
            if (void 0 !== t.transition) return !0;
            for (; e.length;)
                if (e.pop() + "Transition" in t) return !0;
            return !1
        };
    v.prototype = {
        constructor: v,
        init: function() {
            var n = navigator.appVersion;
            e.isLowIE = e.isIE8 = document.all && !document.addEventListener, e.isAndroid = /android/gi.test(n), e.isIOS = /iphone|ipad|ipod/gi.test(n), e.supportsTransition = E(), e.probablyMobile = e.isAndroid || e.isIOS || /(Opera Mini)|Kindle|webOS|BlackBerry|(Opera Mobi)|(Windows Phone)|IEMobile/i.test(navigator.userAgent), i = t(document), e.popupsCache = {}
        },
        open: function(n) {
            var r;
            if (!1 === n.isObj) {
                e.items = n.items.toArray(), e.index = 0;
                var s, a = n.items;
                for (r = 0; r < a.length; r++)
                    if (s = a[r], s.parsed && (s = s.el[0]), s === n.el[0]) {
                        e.index = r;
                        break
                    }
            } else e.items = t.isArray(n.items) ? n.items : [n.items], e.index = n.index || 0;
            if (e.isOpen) return void e.updateItemHTML();
            e.types = [], o = "", n.mainEl && n.mainEl.length ? e.ev = n.mainEl.eq(0) : e.ev = i, n.key ? (e.popupsCache[n.key] || (e.popupsCache[n.key] = {}), e.currTemplate = e.popupsCache[n.key]) : e.currTemplate = {}, e.st = t.extend(!0, {}, t.magnificPopup.defaults, n), e.fixedContentPos = "auto" === e.st.fixedContentPos ? !e.probablyMobile : e.st.fixedContentPos, e.st.modal && (e.st.closeOnContentClick = !1, e.st.closeOnBgClick = !1, e.st.showCloseBtn = !1, e.st.enableEscapeKey = !1), e.bgOverlay || (e.bgOverlay = b("bg").on("click" + d, function() {
                e.close()
            }), e.wrap = b("wrap").attr("tabindex", -1).on("click" + d, function(t) {
                e._checkIfClose(t.target) && e.close()
            }), e.container = b("container", e.wrap)), e.contentContainer = b("content"), e.st.preloader && (e.preloader = b("preloader", e.container, e.st.tLoading));
            var l = t.magnificPopup.modules;
            for (r = 0; r < l.length; r++) {
                var p = l[r];
                p = p.charAt(0).toUpperCase() + p.slice(1), e["init" + p].call(e)
            }
            _("BeforeOpen"), e.st.showCloseBtn && (e.st.closeBtnInside ? (x(u, function(t, e, n, i) {
                n.close_replaceWith = C(i.type)
            }), o += " mfp-close-btn-in") : e.wrap.append(C())), e.st.alignTop && (o += " mfp-align-top"), e.fixedContentPos ? e.wrap.css({
                overflow: e.st.overflowY,
                overflowX: "hidden",
                overflowY: e.st.overflowY
            }) : e.wrap.css({
                top: w.scrollTop(),
                position: "absolute"
            }), (!1 === e.st.fixedBgPos || "auto" === e.st.fixedBgPos && !e.fixedContentPos) && e.bgOverlay.css({
                height: i.height(),
                position: "absolute"
            }), e.st.enableEscapeKey && i.on("keyup" + d, function(t) {
                27 === t.keyCode && e.close()
            }), w.on("resize" + d, function() {
                e.updateSize()
            }), e.st.closeOnContentClick || (o += " mfp-auto-cursor"), o && e.wrap.addClass(o);
            var h = e.wH = w.height(),
                g = {};
            if (e.fixedContentPos && e._hasScrollBar(h)) {
                var m = e._getScrollbarSize();
                m && (g.marginRight = m)
            }
            e.fixedContentPos && (e.isIE7 ? t("body, html").css("overflow", "hidden") : g.overflow = "hidden");
            var v = e.st.mainClass;
            return e.isIE7 && (v += " mfp-ie7"), v && e._addClassToMFP(v), e.updateItemHTML(), _("BuildControls"), t("html").css(g), e.bgOverlay.add(e.wrap).prependTo(e.st.prependTo || t(document.body)), e._lastFocusedEl = document.activeElement, setTimeout(function() {
                e.content ? (e._addClassToMFP(f), e._setFocus()) : e.bgOverlay.addClass(f), i.on("focusin" + d, e._onFocusIn)
            }, 16), e.isOpen = !0, e.updateSize(h), _(c), n
        },
        close: function() {
            e.isOpen && (_(l), e.isOpen = !1, e.st.removalDelay && !e.isLowIE && e.supportsTransition ? (e._addClassToMFP(g), setTimeout(function() {
                e._close()
            }, e.st.removalDelay)) : e._close())
        },
        _close: function() {
            _(a);
            var n = g + " " + f + " ";
            if (e.bgOverlay.detach(), e.wrap.detach(), e.container.empty(), e.st.mainClass && (n += e.st.mainClass + " "), e._removeClassFromMFP(n), e.fixedContentPos) {
                var r = {
                    marginRight: ""
                };
                e.isIE7 ? t("body, html").css("overflow", "") : r.overflow = "", t("html").css(r)
            }
            i.off("keyup.mfp focusin" + d), e.ev.off(d), e.wrap.attr("class", "mfp-wrap").removeAttr("style"), e.bgOverlay.attr("class", "mfp-bg"), e.container.attr("class", "mfp-container"), !e.st.showCloseBtn || e.st.closeBtnInside && !0 !== e.currTemplate[e.currItem.type] || e.currTemplate.closeBtn && e.currTemplate.closeBtn.detach(), e.st.autoFocusLast && e._lastFocusedEl && t(e._lastFocusedEl).focus(), e.currItem = null, e.content = null, e.currTemplate = null, e.prevHeight = 0, _("AfterClose")
        },
        updateSize: function(t) {
            if (e.isIOS) {
                var n = document.documentElement.clientWidth / window.innerWidth,
                    i = window.innerHeight * n;
                e.wrap.css("height", i), e.wH = i
            } else e.wH = t || w.height();
            e.fixedContentPos || e.wrap.css("height", e.wH), _("Resize")
        },
        updateItemHTML: function() {
            var n = e.items[e.index];
            e.contentContainer.detach(), e.content && e.content.detach(), n.parsed || (n = e.parseEl(e.index));
            var i = n.type;
            if (_("BeforeChange", [e.currItem ? e.currItem.type : "", i]), e.currItem = n, !e.currTemplate[i]) {
                var o = !!e.st[i] && e.st[i].markup;
                _("FirstMarkupParse", o), e.currTemplate[i] = !o || t(o)
            }
            r && r !== n.type && e.container.removeClass("mfp-" + r + "-holder");
            var s = e["get" + i.charAt(0).toUpperCase() + i.slice(1)](n, e.currTemplate[i]);
            e.appendContent(s, i), n.preloaded = !0, _(p, n), r = n.type, e.container.prepend(e.contentContainer), _("AfterChange")
        },
        appendContent: function(t, n) {
            e.content = t, t ? e.st.showCloseBtn && e.st.closeBtnInside && !0 === e.currTemplate[n] ? e.content.find(".mfp-close").length || e.content.append(C()) : e.content = t : e.content = "", _("BeforeAppend"), e.container.addClass("mfp-" + n + "-holder"), e.contentContainer.append(e.content)
        },
        parseEl: function(n) {
            var i, r = e.items[n];
            if (r.tagName ? r = {
                    el: t(r)
                } : (i = r.type, r = {
                    data: r,
                    src: r.src
                }), r.el) {
                for (var o = e.types, s = 0; s < o.length; s++)
                    if (r.el.hasClass("mfp-" + o[s])) {
                        i = o[s];
                        break
                    } r.src = r.el.attr("data-mfp-src"), r.src || (r.src = r.el.attr("href"))
            }
            return r.type = i || e.st.type || "inline", r.index = n, r.parsed = !0, e.items[n] = r, _("ElementParse", r), e.items[n]
        },
        addGroup: function(t, n) {
            var i = function(i) {
                i.mfpEl = this, e._openClick(i, t, n)
            };
            n || (n = {});
            var r = "click.magnificPopup";
            n.mainEl = t, n.items ? (n.isObj = !0, t.off(r).on(r, i)) : (n.isObj = !1, n.delegate ? t.off(r).on(r, n.delegate, i) : (n.items = t, t.off(r).on(r, i)))
        },
        _openClick: function(n, i, r) {
            if ((void 0 !== r.midClick ? r.midClick : t.magnificPopup.defaults.midClick) || !(2 === n.which || n.ctrlKey || n.metaKey || n.altKey || n.shiftKey)) {
                var o = void 0 !== r.disableOn ? r.disableOn : t.magnificPopup.defaults.disableOn;
                if (o)
                    if (t.isFunction(o)) {
                        if (!o.call(e)) return !0
                    } else if (w.width() < o) return !0;
                n.type && (n.preventDefault(), e.isOpen && n.stopPropagation()), r.el = t(n.mfpEl), r.delegate && (r.items = i.find(r.delegate)), e.open(r)
            }
        },
        updateStatus: function(t, i) {
            if (e.preloader) {
                n !== t && e.container.removeClass("mfp-s-" + n), i || "loading" !== t || (i = e.st.tLoading);
                var r = {
                    status: t,
                    text: i
                };
                _("UpdateStatus", r), t = r.status, i = r.text, e.preloader.html(i), e.preloader.find("a").on("click", function(t) {
                    t.stopImmediatePropagation()
                }), e.container.addClass("mfp-s-" + t), n = t
            }
        },
        _checkIfClose: function(n) {
            if (!t(n).hasClass(m)) {
                var i = e.st.closeOnContentClick,
                    r = e.st.closeOnBgClick;
                if (i && r) return !0;
                if (!e.content || t(n).hasClass("mfp-close") || e.preloader && n === e.preloader[0]) return !0;
                if (n === e.content[0] || t.contains(e.content[0], n)) {
                    if (i) return !0
                } else if (r && t.contains(document, n)) return !0;
                return !1
            }
        },
        _addClassToMFP: function(t) {
            e.bgOverlay.addClass(t), e.wrap.addClass(t)
        },
        _removeClassFromMFP: function(t) {
            this.bgOverlay.removeClass(t), e.wrap.removeClass(t)
        },
        _hasScrollBar: function(t) {
            return (e.isIE7 ? i.height() : document.body.scrollHeight) > (t || w.height())
        },
        _setFocus: function() {
            (e.st.focus ? e.content.find(e.st.focus).eq(0) : e.wrap).focus()
        },
        _onFocusIn: function(n) {
            return n.target === e.wrap[0] || t.contains(e.wrap[0], n.target) ? void 0 : (e._setFocus(), !1)
        },
        _parseMarkup: function(e, n, i) {
            var r;
            i.data && (n = t.extend(i.data, n)), _(u, [e, n, i]), t.each(n, function(n, i) {
                if (void 0 === i || !1 === i) return !0;
                if (r = n.split("_"), r.length > 1) {
                    var o = e.find(d + "-" + r[0]);
                    if (o.length > 0) {
                        var s = r[1];
                        "replaceWith" === s ? o[0] !== i[0] && o.replaceWith(i) : "img" === s ? o.is("img") ? o.attr("src", i) : o.replaceWith(t("<img>").attr("src", i).attr("class", o.attr("class"))) : o.attr(r[1], i)
                    }
                } else e.find(d + "-" + n).html(i)
            })
        },
        _getScrollbarSize: function() {
            if (void 0 === e.scrollbarSize) {
                var t = document.createElement("div");
                t.style.cssText = "width: 99px; height: 99px; overflow: scroll; position: absolute; top: -9999px;", document.body.appendChild(t), e.scrollbarSize = t.offsetWidth - t.clientWidth, document.body.removeChild(t)
            }
            return e.scrollbarSize
        }
    }, t.magnificPopup = {
        instance: null,
        proto: v.prototype,
        modules: [],
        open: function(e, n) {
            return T(), e = e ? t.extend(!0, {}, e) : {}, e.isObj = !0, e.index = n || 0, this.instance.open(e)
        },
        close: function() {
            return t.magnificPopup.instance && t.magnificPopup.instance.close()
        },
        registerModule: function(e, n) {
            n.options && (t.magnificPopup.defaults[e] = n.options), t.extend(this.proto, n.proto), this.modules.push(e)
        },
        defaults: {
            disableOn: 0,
            key: null,
            midClick: !1,
            mainClass: "",
            preloader: !0,
            focus: "",
            closeOnContentClick: !1,
            closeOnBgClick: !0,
            closeBtnInside: !0,
            showCloseBtn: !0,
            enableEscapeKey: !0,
            modal: !1,
            alignTop: !1,
            removalDelay: 0,
            prependTo: null,
            fixedContentPos: "auto",
            fixedBgPos: "auto",
            overflowY: "auto",
            closeMarkup: '<button title="%title%" type="button" class="mfp-close">&#215;</button>',
            tClose: "Close (Esc)",
            tLoading: "Loading...",
            autoFocusLast: !0
        }
    }, t.fn.magnificPopup = function(n) {
        T();
        var i = t(this);
        if ("string" == typeof n)
            if ("open" === n) {
                var r, o = y ? i.data("magnificPopup") : i[0].magnificPopup,
                    s = parseInt(arguments[1], 10) || 0;
                o.items ? r = o.items[s] : (r = i, o.delegate && (r = r.find(o.delegate)), r = r.eq(s)), e._openClick({
                    mfpEl: r
                }, i, o)
            } else e.isOpen && e[n].apply(e, Array.prototype.slice.call(arguments, 1));
        else n = t.extend(!0, {}, n), y ? i.data("magnificPopup", n) : i[0].magnificPopup = n, e.addGroup(i, n);
        return i
    };
    var k, S, A, j = "inline",
        D = function() {
            A && (S.after(A.addClass(k)).detach(), A = null)
        };
    t.magnificPopup.registerModule(j, {
        options: {
            hiddenClass: "hide",
            markup: "",
            tNotFound: "Content not found"
        },
        proto: {
            initInline: function() {
                e.types.push(j), x(a + "." + j, function() {
                    D()
                })
            },
            getInline: function(n, i) {
                if (D(), n.src) {
                    var r = e.st.inline,
                        o = t(n.src);
                    if (o.length) {
                        var s = o[0].parentNode;
                        s && s.tagName && (S || (k = r.hiddenClass, S = b(k), k = "mfp-" + k), A = o.after(S).detach().removeClass(k)), e.updateStatus("ready")
                    } else e.updateStatus("error", r.tNotFound), o = t("<div>");
                    return n.inlineElement = o, o
                }
                return e.updateStatus("ready"), e._parseMarkup(i, {}, n), i
            }
        }
    });
    var O, $ = "ajax",
        z = function() {
            O && t(document.body).removeClass(O)
        },
        I = function() {
            z(), e.req && e.req.abort()
        };
    t.magnificPopup.registerModule($, {
        options: {
            settings: null,
            cursor: "mfp-ajax-cur",
            tError: '<a href="%url%">The content</a> could not be loaded.'
        },
        proto: {
            initAjax: function() {
                e.types.push($), O = e.st.ajax.cursor, x(a + "." + $, I), x("BeforeChange." + $, I)
            },
            getAjax: function(n) {
                O && t(document.body).addClass(O), e.updateStatus("loading");
                var i = t.extend({
                    url: n.src,
                    success: function(i, r, o) {
                        var s = {
                            data: i,
                            xhr: o
                        };
                        _("ParseAjax", s), e.appendContent(t(s.data), $), n.finished = !0, z(), e._setFocus(), setTimeout(function() {
                            e.wrap.addClass(f)
                        }, 16), e.updateStatus("ready"), _("AjaxContentAdded")
                    },
                    error: function() {
                        z(), n.finished = n.loadError = !0, e.updateStatus("error", e.st.ajax.tError.replace("%url%", n.src))
                    }
                }, e.st.ajax.settings);
                return e.req = t.ajax(i), ""
            }
        }
    });
    var P, N = function(n) {
        if (n.data && void 0 !== n.data.title) return n.data.title;
        var i = e.st.image.titleSrc;
        if (i) {
            if (t.isFunction(i)) return i.call(e, n);
            if (n.el) return n.el.attr(i) || ""
        }
        return ""
    };
    t.magnificPopup.registerModule("image", {
        options: {
            markup: '<div class="mfp-figure"><div class="mfp-close"></div><figure><div class="mfp-img"></div><figcaption><div class="mfp-bottom-bar"><div class="mfp-title"></div><div class="mfp-counter"></div></div></figcaption></figure></div>',
            cursor: "mfp-zoom-out-cur",
            titleSrc: "title",
            verticalFit: !0,
            tError: '<a href="%url%">The image</a> could not be loaded.'
        },
        proto: {
            initImage: function() {
                var n = e.st.image,
                    i = ".image";
                e.types.push("image"), x(c + i, function() {
                    "image" === e.currItem.type && n.cursor && t(document.body).addClass(n.cursor)
                }), x(a + i, function() {
                    n.cursor && t(document.body).removeClass(n.cursor), w.off("resize" + d)
                }), x("Resize" + i, e.resizeImage), e.isLowIE && x("AfterChange", e.resizeImage)
            },
            resizeImage: function() {
                var t = e.currItem;
                if (t && t.img && e.st.image.verticalFit) {
                    var n = 0;
                    e.isLowIE && (n = parseInt(t.img.css("padding-top"), 10) + parseInt(t.img.css("padding-bottom"), 10)), t.img.css("max-height", e.wH - n)
                }
            },
            _onImageHasSize: function(t) {
                t.img && (t.hasSize = !0, P && clearInterval(P), t.isCheckingImgSize = !1, _("ImageHasSize", t), t.imgHidden && (e.content && e.content.removeClass("mfp-loading"), t.imgHidden = !1))
            },
            findImageSize: function(t) {
                var n = 0,
                    i = t.img[0],
                    r = function(o) {
                        P && clearInterval(P), P = setInterval(function() {
                            return i.naturalWidth > 0 ? void e._onImageHasSize(t) : (n > 200 && clearInterval(P), n++, void(3 === n ? r(10) : 40 === n ? r(50) : 100 === n && r(500)))
                        }, o)
                    };
                r(1)
            },
            getImage: function(n, i) {
                var r = 0,
                    o = function() {
                        n && (n.img[0].complete ? (n.img.off(".mfploader"), n === e.currItem && (e._onImageHasSize(n), e.updateStatus("ready")), n.hasSize = !0, n.loaded = !0, _("ImageLoadComplete")) : (r++, 200 > r ? setTimeout(o, 100) : s()))
                    },
                    s = function() {
                        n && (n.img.off(".mfploader"), n === e.currItem && (e._onImageHasSize(n), e.updateStatus("error", a.tError.replace("%url%", n.src))), n.hasSize = !0, n.loaded = !0, n.loadError = !0)
                    },
                    a = e.st.image,
                    l = i.find(".mfp-img");
                if (l.length) {
                    var u = document.createElement("img");
                    u.className = "mfp-img", n.el && n.el.find("img").length && (u.alt = n.el.find("img").attr("alt")), n.img = t(u).on("load.mfploader", o).on("error.mfploader", s), u.src = n.src, l.is("img") && (n.img = n.img.clone()), u = n.img[0], u.naturalWidth > 0 ? n.hasSize = !0 : u.width || (n.hasSize = !1)
                }
                return e._parseMarkup(i, {
                    title: N(n),
                    img_replaceWith: n.img
                }, n), e.resizeImage(), n.hasSize ? (P && clearInterval(P), n.loadError ? (i.addClass("mfp-loading"), e.updateStatus("error", a.tError.replace("%url%", n.src))) : (i.removeClass("mfp-loading"), e.updateStatus("ready")), i) : (e.updateStatus("loading"), n.loading = !0, n.hasSize || (n.imgHidden = !0, i.addClass("mfp-loading"), e.findImageSize(n)), i)
            }
        }
    });
    var L, H = function() {
        return void 0 === L && (L = void 0 !== document.createElement("p").style.MozTransform), L
    };
    t.magnificPopup.registerModule("zoom", {
        options: {
            enabled: !1,
            easing: "ease-in-out",
            duration: 300,
            opener: function(t) {
                return t.is("img") ? t : t.find("img")
            }
        },
        proto: {
            initZoom: function() {
                var t, n = e.st.zoom,
                    i = ".zoom";
                if (n.enabled && e.supportsTransition) {
                    var r, o, s = n.duration,
                        u = function(t) {
                            var e = t.clone().removeAttr("style").removeAttr("class").addClass("mfp-animated-image"),
                                i = "all " + n.duration / 1e3 + "s " + n.easing,
                                r = {
                                    position: "fixed",
                                    zIndex: 9999,
                                    left: 0,
                                    top: 0,
                                    "-webkit-backface-visibility": "hidden"
                                },
                                o = "transition";
                            return r["-webkit-" + o] = r["-moz-" + o] = r["-o-" + o] = r[o] = i, e.css(r), e
                        },
                        c = function() {
                            e.content.css("visibility", "visible")
                        };
                    x("BuildControls" + i, function() {
                        if (e._allowZoom()) {
                            if (clearTimeout(r), e.content.css("visibility", "hidden"), !(t = e._getItemToZoom())) return void c();
                            o = u(t), o.css(e._getOffset()), e.wrap.append(o), r = setTimeout(function() {
                                o.css(e._getOffset(!0)), r = setTimeout(function() {
                                    c(), setTimeout(function() {
                                        o.remove(), t = o = null, _("ZoomAnimationEnded")
                                    }, 16)
                                }, s)
                            }, 16)
                        }
                    }), x(l + i, function() {
                        if (e._allowZoom()) {
                            if (clearTimeout(r), e.st.removalDelay = s, !t) {
                                if (!(t = e._getItemToZoom())) return;
                                o = u(t)
                            }
                            o.css(e._getOffset(!0)), e.wrap.append(o), e.content.css("visibility", "hidden"), setTimeout(function() {
                                o.css(e._getOffset())
                            }, 16)
                        }
                    }), x(a + i, function() {
                        e._allowZoom() && (c(), o && o.remove(), t = null)
                    })
                }
            },
            _allowZoom: function() {
                return "image" === e.currItem.type
            },
            _getItemToZoom: function() {
                return !!e.currItem.hasSize && e.currItem.img
            },
            _getOffset: function(n) {
                var i;
                i = n ? e.currItem.img : e.st.zoom.opener(e.currItem.el || e.currItem);
                var r = i.offset(),
                    o = parseInt(i.css("padding-top"), 10),
                    s = parseInt(i.css("padding-bottom"), 10);
                r.top -= t(window).scrollTop() - o;
                var a = {
                    width: i.width(),
                    height: (y ? i.innerHeight() : i[0].offsetHeight) - s - o
                };
                return H() ? a["-moz-transform"] = a.transform = "translate(" + r.left + "px," + r.top + "px)" : (a.left = r.left, a.top = r.top), a
            }
        }
    });
    var M = "iframe",
        q = function(t) {
            if (e.currTemplate[M]) {
                var n = e.currTemplate[M].find("iframe");
                n.length && (t || (n[0].src = "//about:blank"), e.isIE8 && n.css("display", t ? "block" : "none"))
            }
        };
    t.magnificPopup.registerModule(M, {
        options: {
            markup: '<div class="mfp-iframe-scaler"><div class="mfp-close"></div><iframe class="mfp-iframe" src="//about:blank" frameborder="0" allowfullscreen></iframe></div>',
            srcAction: "iframe_src",
            patterns: {
                youtube: {
                    index: "youtube.com",
                    id: "v=",
                    src: "//www.youtube.com/embed/%id%?autoplay=1"
                },
                vimeo: {
                    index: "vimeo.com/",
                    id: "/",
                    src: "//player.vimeo.com/video/%id%?autoplay=1"
                },
                gmaps: {
                    index: "//maps.google.",
                    src: "%id%&output=embed"
                }
            }
        },
        proto: {
            initIframe: function() {
                e.types.push(M), x("BeforeChange", function(t, e, n) {
                    e !== n && (e === M ? q() : n === M && q(!0))
                }), x(a + "." + M, function() {
                    q()
                })
            },
            getIframe: function(n, i) {
                var r = n.src,
                    o = e.st.iframe;
                t.each(o.patterns, function() {
                    return r.indexOf(this.index) > -1 ? (this.id && (r = "string" == typeof this.id ? r.substr(r.lastIndexOf(this.id) + this.id.length, r.length) : this.id.call(this, r)), r = this.src.replace("%id%", r), !1) : void 0
                });
                var s = {};
                return o.srcAction && (s[o.srcAction] = r), e._parseMarkup(i, s, n), e.updateStatus("ready"), i
            }
        }
    });
    var B = function(t) {
            var n = e.items.length;
            return t > n - 1 ? t - n : 0 > t ? n + t : t
        },
        R = function(t, e, n) {
            return t.replace(/%curr%/gi, e + 1).replace(/%total%/gi, n)
        };
    t.magnificPopup.registerModule("gallery", {
        options: {
            enabled: !1,
            arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>',
            preload: [0, 2],
            navigateByImgClick: !0,
            arrows: !0,
            tPrev: "Previous (Left arrow key)",
            tNext: "Next (Right arrow key)",
            tCounter: "%curr% of %total%"
        },
        proto: {
            initGallery: function() {
                var n = e.st.gallery,
                    r = ".mfp-gallery";
                return e.direction = !0, !(!n || !n.enabled) && (o += " mfp-gallery", x(c + r, function() {
                    n.navigateByImgClick && e.wrap.on("click" + r, ".mfp-img", function() {
                        return e.items.length > 1 ? (e.next(), !1) : void 0
                    }), i.on("keydown" + r, function(t) {
                        37 === t.keyCode ? e.prev() : 39 === t.keyCode && e.next()
                    })
                }), x("UpdateStatus" + r, function(t, n) {
                    n.text && (n.text = R(n.text, e.currItem.index, e.items.length))
                }), x(u + r, function(t, i, r, o) {
                    var s = e.items.length;
                    r.counter = s > 1 ? R(n.tCounter, o.index, s) : ""
                }), x("BuildControls" + r, function() {
                    if (e.items.length > 1 && n.arrows && !e.arrowLeft) {
                        var i = n.arrowMarkup,
                            r = e.arrowLeft = t(i.replace(/%title%/gi, n.tPrev).replace(/%dir%/gi, "left")).addClass(m),
                            o = e.arrowRight = t(i.replace(/%title%/gi, n.tNext).replace(/%dir%/gi, "right")).addClass(m);
                        r.click(function() {
                            e.prev()
                        }), o.click(function() {
                            e.next()
                        }), e.container.append(r.add(o))
                    }
                }), x(p + r, function() {
                    e._preloadTimeout && clearTimeout(e._preloadTimeout), e._preloadTimeout = setTimeout(function() {
                        e.preloadNearbyImages(), e._preloadTimeout = null
                    }, 16)
                }), void x(a + r, function() {
                    i.off(r), e.wrap.off("click" + r), e.arrowRight = e.arrowLeft = null
                }))
            },
            next: function() {
                e.direction = !0, e.index = B(e.index + 1), e.updateItemHTML()
            },
            prev: function() {
                e.direction = !1, e.index = B(e.index - 1), e.updateItemHTML()
            },
            goTo: function(t) {
                e.direction = t >= e.index, e.index = t, e.updateItemHTML()
            },
            preloadNearbyImages: function() {
                var t, n = e.st.gallery.preload,
                    i = Math.min(n[0], e.items.length),
                    r = Math.min(n[1], e.items.length);
                for (t = 1; t <= (e.direction ? r : i); t++) e._preloadItem(e.index + t);
                for (t = 1; t <= (e.direction ? i : r); t++) e._preloadItem(e.index - t)
            },
            _preloadItem: function(n) {
                if (n = B(n), !e.items[n].preloaded) {
                    var i = e.items[n];
                    i.parsed || (i = e.parseEl(n)), _("LazyLoad", i), "image" === i.type && (i.img = t('<img class="mfp-img" />').on("load.mfploader", function() {
                        i.hasSize = !0
                    }).on("error.mfploader", function() {
                        i.hasSize = !0, i.loadError = !0, _("LazyLoadError", i)
                    }).attr("src", i.src)), i.preloaded = !0
                }
            }
        }
    });
    var W = "retina";
    t.magnificPopup.registerModule(W, {
        options: {
            replaceSrc: function(t) {
                return t.src.replace(/\.\w+$/, function(t) {
                    return "@2x" + t
                })
            },
            ratio: 1
        },
        proto: {
            initRetina: function() {
                if (window.devicePixelRatio > 1) {
                    var t = e.st.retina,
                        n = t.ratio;
                    (n = isNaN(n) ? n() : n) > 1 && (x("ImageHasSize." + W, function(t, e) {
                        e.img.css({
                            "max-width": e.img[0].naturalWidth / n,
                            width: "100%"
                        })
                    }), x("ElementParse." + W, function(e, i) {
                        i.src = t.replaceSrc(i, n)
                    }))
                }
            }
        }
    }), T()
}), $(window).on("load", function() {
    $(".block .testimonials").owlCarousel({
        slideSpeed: 300,
        paginationSpeed: 400,
        autoHeight: !0,
        loop: !1,
        autoplay: !1,
        autoplayTimeout: 5e3,
        autoplayHoverPause: !0,
        startPosition: 0,
        responsive: {
            0: {
                items: 1,
                nav: !0,
                margin: 0,
                navigation: !0
            },
            767: {
                items: 2,
                nav: !0,
                margin: 0,
                navigation: !0
            },
            1399: {
                items: 3,
                nav: !0,
                margin: 0,
                navigation: !0
            }
        }
    }), $(".block .testimonials").on("resized.owl.carousel", function(t) {
        var e = $(this);
        e.find(".owl-height").css("height", e.find(".owl-item.active").height())
    }), $(".block .featured-models").owlCarousel({
        slideSpeed: 300,
        paginationSpeed: 400,
        autoHeight: !0,
        loop: !1,
        autoplay: !1,
        autoplayTimeout: 5e3,
        autoplayHoverPause: !0,
        startPosition: 0,
        responsive: {
            0: {
                items: 2,
                nav: !0,
                margin: 20,
                navigation: !0
            },
            767: {
                items: 3,
                nav: !0,
                margin: 20,
                navigation: !0
            },
            979: {
                items: 5,
                nav: !0,
                margin: 20,
                navigation: !0
            },
            1599: {
                items: 6,
                nav: !0,
                margin: 20,
                navigation: !0
            }
        }
    }), $(".block .featured-models").on("resized.owl.carousel", function(t) {
        var e = $(this);
        e.find(".owl-height").css("height", e.find(".owl-item.active").height())
    })
});
var languageOpen = !1;
$("body").on("click", ".languages .link", function(t) {
    languageOpen ? ($(this).parent().find("ul").slideUp("fast"), languageOpen = !1) : ($(this).parent().find("ul").slideDown("fast"), languageOpen = !0), t.preventDefault()
});
var menuOpened = !1;
$("body").on("click", "header a.mobile-menu", function(t) {
    menuOpened ? ($("#mobile-menu").transition({
        x: 0,
        delay: 0
    }), $(this).removeClass("close"), $("body").css("overflow", "visible"), menuOpened = !1) : ($("#mobile-menu").transition({
        x: "-110%",
        delay: 0
    }), $(this).addClass("close"), $("body").css("overflow", "hidden"), menuOpened = !0), t.preventDefault()
}), $("body").on("click", "#mobile-menu .dd", function(t) {
    var e = $(this).parent().find("ul");
    $(e).hasClass("opened") ? $(e).removeClass("opened").slideUp(500) : $(e).addClass("opened").slideDown(500), t.preventDefault()
}), $("body").on("click", ".mfp-register", function(t) {
    $.magnificPopup.open({
        items: {
            src: "#mfp-sign-up"
        },
        type: "inline"
    }), t.preventDefault()
}), $("body").on("click", '[name="show-password"]', function() {
    $(this).is(":checked") ? $("#registration-password").attr("type", "text") : $("#registration-password").attr("type", "password")
}),$("body").on("click", ".home-video", function(t) {
    $.magnificPopup.open({
        items: {
            // src: "https://www.youtube.com/watch?v=CO6JArY1nvg"
            src: "https://vimeo.com/300998474"
        },
        type: "iframe"
    }), t.preventDefault()
}),$("body").on("click", ".model-video", function(t) {
    $.magnificPopup.open({
        items: {
            src: "https://www.youtube.com/watch?v=ycnuKbBmNjU"
        },
        type: "iframe"
    }), t.preventDefault()
});

// scroll to top function on scroll of 30 px
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 30 || document.documentElement.scrollTop > 30) {
    document.getElementById("btnScrollTop").style.display = "block";
  } else {
    document.getElementById("btnScrollTop").style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}

