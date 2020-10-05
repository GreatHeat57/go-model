function listView(t, e, i, n) {
    $(".grid-view,.compact-view").removeClass("active"), $(t).addClass("active"), e.addClass("make-list"), e.removeClass("make-grid"), e.removeClass("make-compact"), $(".adds-wrapper").hasClass("property-list") ? (i.removeClass("col-sm-9"), i.addClass("col-sm-6")) : (i.removeClass("col-sm-9"), i.addClass("col-sm-12")), $(function() {
        e.matchHeight("remove");
    })
}

function gridView(t, e, i, n) {
    $(".list-view,.compact-view").removeClass("active"), $(t).addClass("active"), e.addClass("make-grid"), e.removeClass("make-list"), e.removeClass("make-compact"), n.hasClass("property-list") && (i.toggleClass(""), i.addClass("no")), $(function() {
        e.matchHeight(), $.fn.matchHeight._apply(".item-list");
    })
}

function compactView(t, e, i, n) {
    $(".list-view,.grid-view").removeClass("active"), $(t).addClass("active"), e.addClass("make-compact"), e.removeClass("make-list"), e.removeClass("make-grid"), n.hasClass("property-list") ? i.addClass("col-sm-9").removeClass("col-sm-6") : (i.toggleClass("col-sm-9 col-sm-7"), i.addClass("no")), $(function() {
        $(".adds-wrapper .item-list").matchHeight("remove");
    })
}

function createCookie(t, e, i) {
    var n;
    if (i) {
        var s = new Date;
        s.setTime(s.getTime() + 24 * i * 60 * 60 * 1e3), n = "; expires=" + s.toGMTString()
    } else n = "";
    document.cookie = encodeURIComponent(t) + "=" + encodeURIComponent(e) + n + "; path=/"
}

function readCookie(t) {
    for (var e = encodeURIComponent(t) + "=", i = document.cookie.split(";"), n = 0; n < i.length; n++) {
        for (var s = i[n];
            " " === s.charAt(0);) s = s.substring(1, s.length);
        if (0 === s.indexOf(e)) return decodeURIComponent(s.substring(e.length, s.length))
    }
    return null
}

function eraseCookie(t) {
    createCookie(t, "", -1)
}

function setCountryPhoneCode(t, e) {
    return void 0 !== t && void 0 !== e && (void 0 !== e[t] && void $("#phoneCountry").html(e[t].phone))
}

function setUserType(t) {
    if ($("#companyBloc").hide(), $("#resumeBloc").hide(), void 0 === t) return !1;
    2 == t && $("#companyBloc").show(), 3 == t && $("#resumeBloc").show()
}

function getGoogleMaps(t, e, i) {
    if (void 0 === e) var n = encodeURIComponent($("#address").text());
    else var n = encodeURIComponent(e);
    if (void 0 === i) var i = "en";
    var s = "https://www.google.com/maps/embed/v1/place?key=" + t + "&q=" + n + "&language=" + i;
    $("#googleMaps").attr("src", s)
}

function showAmount(t, e, i) {
    $(".payable-amount").html(t), $(".amount-currency").html(e), 1 == i ? ($(".amount-currency.currency-in-left").show(), $(".amount-currency.currency-in-right").hide()) : ($(".amount-currency.currency-in-left").hide(), $(".amount-currency.currency-in-right").show()), t <= 0 ? $("#packagesTable tbody tr:last").hide() : $("#packagesTable tbody tr:last").show()
}

function getPackagePrice(t) {
    var e = $("#price-" + t + " .price-int").html();

    var b = $('#price-' + t + ' .tax-int').val();
    var s = parseFloat(e)+parseFloat(b);

    return s;
}

function redirect(t) {
    window.location.replace(t), window.location.href = t
}

function rawurlencode(t) {
    return t = (t + "").toString(), encodeURIComponent(t).replace(/!/g, "%21").replace(/'/g, "%27").replace(/\(/g, "%28").replace(/\)/g, "%29").replace(/\*/g, "%2A")
}

function isEmptyValue(t) {
    return !t || 0 === t.length
}

function isBlankValue(t) {
    return !t || /^\s*$/.test(t)
}

function getCompany(t) {
    if (0 == t) $("#logoField").hide(), $("#logoFieldValue").html(""), $("#companyFields").show();
    else {
        $("#companyFields").hide();
        var e = $("#companyId").find("option:selected").data("logo");
        $("#logoFieldValue").html('<img src="' + e + '">');
        var i = $("#companyFormLink").attr("href");
        i = i.replace(/companies\/([0-9]+)\/edit/, "companies/" + t + "/edit"), $("#companyFormLink").attr("href", i), $("#logoField").show()
    }
}

function getResume(t) {
    0 == t ? $("#resumeFields").show() : $("#resumeFields").hide()
}

function showPhone() {
    return !1
}

function savePost(t) {
    var e = $(t).closest("li").attr("id");
    return $.ajax({
        method: "POST",
        url: siteUrl + "/ajax/save/post",
        data: {
            postId: e,
            _token: $("input[name=_token]").val()
        }
    }).done(function(e) {
        return void 0 !== e.logged && ("0" == e.logged ? ($("#quickLogin").modal(), !1) : (1 == e.status ? ($(t).hasClass("btn") ? ($("#" + e.postId).removeClass("saved-job").addClass("saved-job"), $("#" + e.postId + " a").removeClass("save-job").addClass("saved-job")) : $(t).html('<span class="fa fa-heart"></span> ' + lang.labelSavePostRemove), alert(lang.confirmationSavePost)) : ($(t).hasClass("btn") ? ($("#" + e.postId).removeClass("save-job").addClass("save-job"), $("#" + e.postId + " a").removeClass("saved-job").addClass("save-job")) : $(t).html('<span class="fa fa-heart-o"></span> ' + lang.labelSavePostSave), alert(lang.confirmationRemoveSavePost)), !1))
    }), !1
}

function saveSearch(t) {
    var e = $(t).attr("name"),
        i = $(t).attr("count");
    return $.ajax({
        method: "POST",
        url: siteUrl + "/ajax/save/search",
        data: {
            url: e,
            countPosts: i,
            _token: $("input[name=_token]").val()
        }
    }).done(function(t) {
        return void 0 !== t.logged && ("0" == t.logged ? ($("#quickLogin").modal(), !1) : (1 == t.status ? alert(lang.confirmationSaveSearch) : alert(lang.confirmationRemoveSaveSearch), !1))
    }), !1
}
if (function(t, e) {
        function i(t) {
            var e = t.length,
                i = ht.type(t);
            return !ht.isWindow(t) && (!(1 !== t.nodeType || !e) || ("array" === i || "function" !== i && (0 === e || "number" == typeof e && e > 0 && e - 1 in t)))
        }

        function n(t) {
            var e = kt[t] = {};
            return ht.each(t.match(ut) || [], function(t, i) {
                e[i] = !0
            }), e
        }

        function s(t, i, n, s) {
            if (ht.acceptData(t)) {
                var o, r, a = ht.expando,
                    l = t.nodeType,
                    h = l ? ht.cache : t,
                    c = l ? t[a] : t[a] && a;
                if (c && h[c] && (s || h[c].data) || n !== e || "string" != typeof i) return c || (c = l ? t[a] = et.pop() || ht.guid++ : a), h[c] || (h[c] = l ? {} : {
                    toJSON: ht.noop
                }), "object" != typeof i && "function" != typeof i || (s ? h[c] = ht.extend(h[c], i) : h[c].data = ht.extend(h[c].data, i)), r = h[c], s || (r.data || (r.data = {}), r = r.data), n !== e && (r[ht.camelCase(i)] = n), "string" == typeof i ? null == (o = r[i]) && (o = r[ht.camelCase(i)]) : o = r, o
            }
        }

        function o(t, e, i) {
            if (ht.acceptData(t)) {
                var n, s, o = t.nodeType,
                    r = o ? ht.cache : t,
                    l = o ? t[ht.expando] : ht.expando;
                if (r[l]) {
                    if (e && (n = i ? r[l] : r[l].data)) {
                        ht.isArray(e) ? e = e.concat(ht.map(e, ht.camelCase)) : e in n ? e = [e] : (e = ht.camelCase(e), e = e in n ? [e] : e.split(" ")), s = e.length;
                        for (; s--;) delete n[e[s]];
                        if (i ? !a(n) : !ht.isEmptyObject(n)) return
                    }(i || (delete r[l].data, a(r[l]))) && (o ? ht.cleanData([t], !0) : ht.support.deleteExpando || r != r.window ? delete r[l] : r[l] = null)
                }
            }
        }

        function r(t, i, n) {
            if (n === e && 1 === t.nodeType) {
                var s = "data-" + i.replace($t, "-$1").toLowerCase();
                if ("string" == typeof(n = t.getAttribute(s))) {
                    try {
                        n = "true" === n || "false" !== n && ("null" === n ? null : +n + "" === n ? +n : Tt.test(n) ? ht.parseJSON(n) : n)
                    } catch (t) {}
                    ht.data(t, i, n)
                } else n = e
            }
            return n
        }

        function a(t) {
            var e;
            for (e in t)
                if (("data" !== e || !ht.isEmptyObject(t[e])) && "toJSON" !== e) return !1;
            return !0
        }

        function l() {
            return !0
        }

        function h() {
            return !1
        }

        function c() {
            try {
                return X.activeElement
            } catch (t) {}
        }

        function u(t, e) {
            do {
                t = t[e]
            } while (t && 1 !== t.nodeType);
            return t
        }

        function d(t, e, i) {
            if (ht.isFunction(e)) return ht.grep(t, function(t, n) {
                return !!e.call(t, n, t) !== i
            });
            if (e.nodeType) return ht.grep(t, function(t) {
                return t === e !== i
            });
            if ("string" == typeof e) {
                if (Wt.test(e)) return ht.filter(e, t, i);
                e = ht.filter(e, t)
            }
            return ht.grep(t, function(t) {
                return ht.inArray(t, e) >= 0 !== i
            })
        }

        function p(t) {
            var e = Ut.split("|"),
                i = t.createDocumentFragment();
            if (i.createElement)
                for (; e.length;) i.createElement(e.pop());
            return i
        }

        function f(t, e) {
            return ht.nodeName(t, "table") && ht.nodeName(1 === e.nodeType ? e : e.firstChild, "tr") ? t.getElementsByTagName("tbody")[0] || t.appendChild(t.ownerDocument.createElement("tbody")) : t
        }

        function g(t) {
            return t.type = (null !== ht.find.attr(t, "type")) + "/" + t.type, t
        }

        function m(t) {
            var e = ne.exec(t.type);
            return e ? t.type = e[1] : t.removeAttribute("type"), t
        }

        function v(t, e) {
            for (var i, n = 0; null != (i = t[n]); n++) ht._data(i, "globalEval", !e || ht._data(e[n], "globalEval"))
        }

        function y(t, e) {
            if (1 === e.nodeType && ht.hasData(t)) {
                var i, n, s, o = ht._data(t),
                    r = ht._data(e, o),
                    a = o.events;
                if (a) {
                    delete r.handle, r.events = {};
                    for (i in a)
                        for (n = 0, s = a[i].length; n < s; n++) ht.event.add(e, i, a[i][n])
                }
                r.data && (r.data = ht.extend({}, r.data))
            }
        }

        function b(t, e) {
            var i, n, s;
            if (1 === e.nodeType) {
                if (i = e.nodeName.toLowerCase(), !ht.support.noCloneEvent && e[ht.expando]) {
                    s = ht._data(e);
                    for (n in s.events) ht.removeEvent(e, n, s.handle);
                    e.removeAttribute(ht.expando)
                }
                "script" === i && e.text !== t.text ? (g(e).text = t.text, m(e)) : "object" === i ? (e.parentNode && (e.outerHTML = t.outerHTML), ht.support.html5Clone && t.innerHTML && !ht.trim(e.innerHTML) && (e.innerHTML = t.innerHTML)) : "input" === i && te.test(t.type) ? (e.defaultChecked = e.checked = t.checked, e.value !== t.value && (e.value = t.value)) : "option" === i ? e.defaultSelected = e.selected = t.defaultSelected : "input" !== i && "textarea" !== i || (e.defaultValue = t.defaultValue)
            }
        }

        function _(t, i) {
            var n, s, o = 0,
                r = typeof t.getElementsByTagName !== Q ? t.getElementsByTagName(i || "*") : typeof t.querySelectorAll !== Q ? t.querySelectorAll(i || "*") : e;
            if (!r)
                for (r = [], n = t.childNodes || t; null != (s = n[o]); o++) !i || ht.nodeName(s, i) ? r.push(s) : ht.merge(r, _(s, i));
            return i === e || i && ht.nodeName(t, i) ? ht.merge([t], r) : r
        }

        function w(t) {
            te.test(t.type) && (t.defaultChecked = t.checked)
        }

        function x(t, e) {
            if (e in t) return e;
            for (var i = e.charAt(0).toUpperCase() + e.slice(1), n = e, s = Ce.length; s--;)
                if ((e = Ce[s] + i) in t) return e;
            return n
        }

        function C(t, e) {
            return t = e || t, "none" === ht.css(t, "display") || !ht.contains(t.ownerDocument, t)
        }

        function k(t, e) {
            for (var i, n, s, o = [], r = 0, a = t.length; r < a; r++) n = t[r], n.style && (o[r] = ht._data(n, "olddisplay"), i = n.style.display, e ? (o[r] || "none" !== i || (n.style.display = ""), "" === n.style.display && C(n) && (o[r] = ht._data(n, "olddisplay", S(n.nodeName)))) : o[r] || (s = C(n), (i && "none" !== i || !s) && ht._data(n, "olddisplay", s ? i : ht.css(n, "display"))));
            for (r = 0; r < a; r++) n = t[r], n.style && (e && "none" !== n.style.display && "" !== n.style.display || (n.style.display = e ? o[r] || "" : "none"));
            return t
        }

        function T(t, e, i) {
            var n = me.exec(e);
            return n ? Math.max(0, n[1] - (i || 0)) + (n[2] || "px") : e
        }

        function $(t, e, i, n, s) {
            for (var o = i === (n ? "border" : "content") ? 4 : "width" === e ? 1 : 0, r = 0; o < 4; o += 2) "margin" === i && (r += ht.css(t, i + xe[o], !0, s)), n ? ("content" === i && (r -= ht.css(t, "padding" + xe[o], !0, s)), "margin" !== i && (r -= ht.css(t, "border" + xe[o] + "Width", !0, s))) : (r += ht.css(t, "padding" + xe[o], !0, s), "padding" !== i && (r += ht.css(t, "border" + xe[o] + "Width", !0, s)));
            return r
        }

        function D(t, e, i) {
            var n = !0,
                s = "width" === e ? t.offsetWidth : t.offsetHeight,
                o = he(t),
                r = ht.support.boxSizing && "border-box" === ht.css(t, "boxSizing", !1, o);
            if (s <= 0 || null == s) {
                if (s = ce(t, e, o), (s < 0 || null == s) && (s = t.style[e]), ve.test(s)) return s;
                n = r && (ht.support.boxSizingReliable || s === t.style[e]), s = parseFloat(s) || 0
            }
            return s + $(t, e, i || (r ? "border" : "content"), n, o) + "px"
        }

        function S(t) {
            var e = X,
                i = be[t];
            return i || (i = A(t, e), "none" !== i && i || (le = (le || ht("<iframe frameborder='0' width='0' height='0'/>").css("cssText", "display:block !important")).appendTo(e.documentElement), e = (le[0].contentWindow || le[0].contentDocument).document, e.write("<!doctype html><html><body>"), e.close(), i = A(t, e), le.detach()), be[t] = i), i
        }

        function A(t, e) {
            var i = ht(e.createElement(t)).appendTo(e.body),
                n = ht.css(i[0], "display");
            return i.remove(), n
        }

        function E(t, e, i, n) {
            var s;
            if (ht.isArray(e)) ht.each(e, function(e, s) {
                i || Te.test(t) ? n(t, s) : E(t + "[" + ("object" == typeof s ? e : "") + "]", s, i, n)
            });
            else if (i || "object" !== ht.type(e)) n(t, e);
            else
                for (s in e) E(t + "[" + s + "]", e[s], i, n)
        }

        function I(t) {
            return function(e, i) {
                "string" != typeof e && (i = e, e = "*");
                var n, s = 0,
                    o = e.toLowerCase().match(ut) || [];
                if (ht.isFunction(i))
                    for (; n = o[s++];) "+" === n[0] ? (n = n.slice(1) || "*", (t[n] = t[n] || []).unshift(i)) : (t[n] = t[n] || []).push(i)
            }
        }

        function P(t, e, i, n) {
            function s(a) {
                var l;
                return o[a] = !0, ht.each(t[a] || [], function(t, a) {
                    var h = a(e, i, n);
                    return "string" != typeof h || r || o[h] ? r ? !(l = h) : void 0 : (e.dataTypes.unshift(h), s(h), !1)
                }), l
            }
            var o = {},
                r = t === Fe;
            return s(e.dataTypes[0]) || !o["*"] && s("*")
        }

        function N(t, i) {
            var n, s, o = ht.ajaxSettings.flatOptions || {};
            for (s in i) i[s] !== e && ((o[s] ? t : n || (n = {}))[s] = i[s]);
            return n && ht.extend(!0, t, n), t
        }

        function M(t, i, n) {
            for (var s, o, r, a, l = t.contents, h = t.dataTypes;
                "*" === h[0];) h.shift(), o === e && (o = t.mimeType || i.getResponseHeader("Content-Type"));
            if (o)
                for (a in l)
                    if (l[a] && l[a].test(o)) {
                        h.unshift(a);
                        break
                    } if (h[0] in n) r = h[0];
            else {
                for (a in n) {
                    if (!h[0] || t.converters[a + " " + h[0]]) {
                        r = a;
                        break
                    }
                    s || (s = a)
                }
                r = r || s
            }
            if (r) return r !== h[0] && h.unshift(r), n[r]
        }

        function O(t, e, i, n) {
            var s, o, r, a, l, h = {},
                c = t.dataTypes.slice();
            if (c[1])
                for (r in t.converters) h[r.toLowerCase()] = t.converters[r];
            for (o = c.shift(); o;)
                if (t.responseFields[o] && (i[t.responseFields[o]] = e), !l && n && t.dataFilter && (e = t.dataFilter(e, t.dataType)), l = o, o = c.shift())
                    if ("*" === o) o = l;
                    else if ("*" !== l && l !== o) {
                if (!(r = h[l + " " + o] || h["* " + o]))
                    for (s in h)
                        if (a = s.split(" "), a[1] === o && (r = h[l + " " + a[0]] || h["* " + a[0]])) {
                            !0 === r ? r = h[s] : !0 !== h[s] && (o = a[0], c.unshift(a[1]));
                            break
                        } if (!0 !== r)
                    if (r && t.throws) e = r(e);
                    else try {
                        e = r(e)
                    } catch (t) {
                        return {
                            state: "parsererror",
                            error: r ? t : "No conversion from " + l + " to " + o
                        }
                    }
            }
            return {
                state: "success",
                data: e
            }
        }

        function H() {
            try {
                return new t.XMLHttpRequest
            } catch (t) {}
        }

        function j() {
            try {
                return new t.ActiveXObject("Microsoft.XMLHTTP")
            } catch (t) {}
        }

        function z() {
            return setTimeout(function() {
                Xe = e
            }), Xe = ht.now()
        }

        function L(t, e, i) {
            for (var n, s = (ii[e] || []).concat(ii["*"]), o = 0, r = s.length; o < r; o++)
                if (n = s[o].call(i, e, t)) return n
        }

        function R(t, e, i) {
            var n, s, o = 0,
                r = ei.length,
                a = ht.Deferred().always(function() {
                    delete l.elem
                }),
                l = function() {
                    if (s) return !1;
                    for (var e = Xe || z(), i = Math.max(0, h.startTime + h.duration - e), n = i / h.duration || 0, o = 1 - n, r = 0, l = h.tweens.length; r < l; r++) h.tweens[r].run(o);
                    return a.notifyWith(t, [h, o, i]), o < 1 && l ? i : (a.resolveWith(t, [h]), !1)
                },
                h = a.promise({
                    elem: t,
                    props: ht.extend({}, e),
                    opts: ht.extend(!0, {
                        specialEasing: {}
                    }, i),
                    originalProperties: e,
                    originalOptions: i,
                    startTime: Xe || z(),
                    duration: i.duration,
                    tweens: [],
                    createTween: function(e, i) {
                        var n = ht.Tween(t, h.opts, e, i, h.opts.specialEasing[e] || h.opts.easing);
                        return h.tweens.push(n), n
                    },
                    stop: function(e) {
                        var i = 0,
                            n = e ? h.tweens.length : 0;
                        if (s) return this;
                        for (s = !0; i < n; i++) h.tweens[i].run(1);
                        return e ? a.resolveWith(t, [h, e]) : a.rejectWith(t, [h, e]), this
                    }
                }),
                c = h.props;
            for (W(c, h.opts.specialEasing); o < r; o++)
                if (n = ei[o].call(h, t, c, h.opts)) return n;
            return ht.map(c, L, h), ht.isFunction(h.opts.start) && h.opts.start.call(t, h), ht.fx.timer(ht.extend(l, {
                elem: t,
                anim: h,
                queue: h.opts.queue
            })), h.progress(h.opts.progress).done(h.opts.done, h.opts.complete).fail(h.opts.fail).always(h.opts.always)
        }

        function W(t, e) {
            var i, n, s, o, r;
            for (i in t)
                if (n = ht.camelCase(i), s = e[n], o = t[i], ht.isArray(o) && (s = o[1], o = t[i] = o[0]), i !== n && (t[n] = o, delete t[i]), (r = ht.cssHooks[n]) && "expand" in r) {
                    o = r.expand(o), delete t[n];
                    for (i in o) i in t || (t[i] = o[i], e[i] = s)
                } else e[n] = s
        }

        function F(t, e, i) {
            var n, s, o, r, a, l, h = this,
                c = {},
                u = t.style,
                d = t.nodeType && C(t),
                p = ht._data(t, "fxshow");
            i.queue || (a = ht._queueHooks(t, "fx"), null == a.unqueued && (a.unqueued = 0, l = a.empty.fire, a.empty.fire = function() {
                a.unqueued || l()
            }), a.unqueued++, h.always(function() {
                h.always(function() {
                    a.unqueued--, ht.queue(t, "fx").length || a.empty.fire()
                })
            })), 1 === t.nodeType && ("height" in e || "width" in e) && (i.overflow = [u.overflow, u.overflowX, u.overflowY], "inline" === ht.css(t, "display") && "none" === ht.css(t, "float") && (ht.support.inlineBlockNeedsLayout && "inline" !== S(t.nodeName) ? u.zoom = 1 : u.display = "inline-block")), i.overflow && (u.overflow = "hidden", ht.support.shrinkWrapBlocks || h.always(function() {
                u.overflow = i.overflow[0], u.overflowX = i.overflow[1], u.overflowY = i.overflow[2]
            }));
            for (n in e)
                if (s = e[n], Ze.exec(s)) {
                    if (delete e[n], o = o || "toggle" === s, s === (d ? "hide" : "show")) continue;
                    c[n] = p && p[n] || ht.style(t, n)
                } if (!ht.isEmptyObject(c)) {
                p ? "hidden" in p && (d = p.hidden) : p = ht._data(t, "fxshow", {}), o && (p.hidden = !d), d ? ht(t).show() : h.done(function() {
                    ht(t).hide()
                }), h.done(function() {
                    var e;
                    ht._removeData(t, "fxshow");
                    for (e in c) ht.style(t, e, c[e])
                });
                for (n in c) r = L(d ? p[n] : 0, n, h), n in p || (p[n] = r.start, d && (r.end = r.start, r.start = "width" === n || "height" === n ? 1 : 0))
            }
        }

        function q(t, e, i, n, s) {
            return new q.prototype.init(t, e, i, n, s)
        }

        function B(t, e) {
            var i, n = {
                    height: t
                },
                s = 0;
            for (e = e ? 1 : 0; s < 4; s += 2 - e) i = xe[s], n["margin" + i] = n["padding" + i] = t;
            return e && (n.opacity = n.width = t), n
        }

        function U(t) {
            return ht.isWindow(t) ? t : 9 === t.nodeType && (t.defaultView || t.parentWindow)
        }
        var Y, V, Q = typeof e,
            K = t.location,
            X = t.document,
            G = X.documentElement,
            Z = t.jQuery,
            J = t.$,
            tt = {},
            et = [],
            it = et.concat,
            nt = et.push,
            st = et.slice,
            ot = et.indexOf,
            rt = tt.toString,
            at = tt.hasOwnProperty,
            lt = "1.10.2".trim,
            ht = function(t, e) {
                return new ht.fn.init(t, e, V)
            },
            ct = /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source,
            ut = /\S+/g,
            dt = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g,
            pt = /^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]*))$/,
            ft = /^<(\w+)\s*\/?>(?:<\/\1>|)$/,
            gt = /^[\],:{}\s]*$/,
            mt = /(?:^|:|,)(?:\s*\[)+/g,
            vt = /\\(?:["\\\/bfnrt]|u[\da-fA-F]{4})/g,
            yt = /"[^"\\\r\n]*"|true|false|null|-?(?:\d+\.|)\d+(?:[eE][+-]?\d+|)/g,
            bt = /^-ms-/,
            _t = /-([\da-z])/gi,
            wt = function(t, e) {
                return e.toUpperCase()
            },
            xt = function(t) {
                (X.addEventListener || "load" === t.type || "complete" === X.readyState) && (Ct(), ht.ready())
            },
            Ct = function() {
                X.addEventListener ? (X.removeEventListener("DOMContentLoaded", xt, !1), t.removeEventListener("load", xt, !1)) : (X.detachEvent("onreadystatechange", xt), t.detachEvent("onload", xt))
            };
        ht.fn = ht.prototype = {
                jquery: "1.10.2",
                constructor: ht,
                init: function(t, i, n) {
                    var s, o;
                    if (!t) return this;
                    if ("string" == typeof t) {
                        if (!(s = "<" === t.charAt(0) && ">" === t.charAt(t.length - 1) && t.length >= 3 ? [null, t, null] : pt.exec(t)) || !s[1] && i) return !i || i.jquery ? (i || n).find(t) : this.constructor(i).find(t);
                        if (s[1]) {
                            if (i = i instanceof ht ? i[0] : i, ht.merge(this, ht.parseHTML(s[1], i && i.nodeType ? i.ownerDocument || i : X, !0)), ft.test(s[1]) && ht.isPlainObject(i))
                                for (s in i) ht.isFunction(this[s]) ? this[s](i[s]) : this.attr(s, i[s]);
                            return this
                        }
                        if ((o = X.getElementById(s[2])) && o.parentNode) {
                            if (o.id !== s[2]) return n.find(t);
                            this.length = 1, this[0] = o
                        }
                        return this.context = X, this.selector = t, this
                    }
                    return t.nodeType ? (this.context = this[0] = t, this.length = 1, this) : ht.isFunction(t) ? n.ready(t) : (t.selector !== e && (this.selector = t.selector, this.context = t.context), ht.makeArray(t, this))
                },
                selector: "",
                length: 0,
                toArray: function() {
                    return st.call(this)
                },
                get: function(t) {
                    return null == t ? this.toArray() : t < 0 ? this[this.length + t] : this[t]
                },
                pushStack: function(t) {
                    var e = ht.merge(this.constructor(), t);
                    return e.prevObject = this, e.context = this.context, e
                },
                each: function(t, e) {
                    return ht.each(this, t, e)
                },
                ready: function(t) {
                    return ht.ready.promise().done(t), this
                },
                slice: function() {
                    return this.pushStack(st.apply(this, arguments))
                },
                first: function() {
                    return this.eq(0)
                },
                last: function() {
                    return this.eq(-1)
                },
                eq: function(t) {
                    var e = this.length,
                        i = +t + (t < 0 ? e : 0);
                    return this.pushStack(i >= 0 && i < e ? [this[i]] : [])
                },
                map: function(t) {
                    return this.pushStack(ht.map(this, function(e, i) {
                        return t.call(e, i, e)
                    }))
                },
                end: function() {
                    return this.prevObject || this.constructor(null)
                },
                push: nt,
                sort: [].sort,
                splice: [].splice
            }, ht.fn.init.prototype = ht.fn, ht.extend = ht.fn.extend = function() {
                var t, i, n, s, o, r, a = arguments[0] || {},
                    l = 1,
                    h = arguments.length,
                    c = !1;
                for ("boolean" == typeof a && (c = a, a = arguments[1] || {}, l = 2), "object" == typeof a || ht.isFunction(a) || (a = {}), h === l && (a = this, --l); l < h; l++)
                    if (null != (o = arguments[l]))
                        for (s in o) t = a[s], n = o[s], a !== n && (c && n && (ht.isPlainObject(n) || (i = ht.isArray(n))) ? (i ? (i = !1, r = t && ht.isArray(t) ? t : []) : r = t && ht.isPlainObject(t) ? t : {}, a[s] = ht.extend(c, r, n)) : n !== e && (a[s] = n));
                return a
            }, ht.extend({
                expando: "jQuery" + ("1.10.2" + Math.random()).replace(/\D/g, ""),
                noConflict: function(e) {
                    return t.$ === ht && (t.$ = J), e && t.jQuery === ht && (t.jQuery = Z), ht
                },
                isReady: !1,
                readyWait: 1,
                holdReady: function(t) {
                    t ? ht.readyWait++ : ht.ready(!0)
                },
                ready: function(t) {
                    if (!0 === t ? !--ht.readyWait : !ht.isReady) {
                        if (!X.body) return setTimeout(ht.ready);
                        ht.isReady = !0, !0 !== t && --ht.readyWait > 0 || (Y.resolveWith(X, [ht]), ht.fn.trigger && ht(X).trigger("ready").off("ready"))
                    }
                },
                isFunction: function(t) {
                    return "function" === ht.type(t)
                },
                isArray: Array.isArray || function(t) {
                    return "array" === ht.type(t)
                },
                isWindow: function(t) {
                    return null != t && t == t.window
                },
                isNumeric: function(t) {
                    return !isNaN(parseFloat(t)) && isFinite(t)
                },
                type: function(t) {
                    return null == t ? String(t) : "object" == typeof t || "function" == typeof t ? tt[rt.call(t)] || "object" : typeof t
                },
                isPlainObject: function(t) {
                    var i;
                    if (!t || "object" !== ht.type(t) || t.nodeType || ht.isWindow(t)) return !1;
                    try {
                        if (t.constructor && !at.call(t, "constructor") && !at.call(t.constructor.prototype, "isPrototypeOf")) return !1
                    } catch (t) {
                        return !1
                    }
                    if (ht.support.ownLast)
                        for (i in t) return at.call(t, i);
                    for (i in t);
                    return i === e || at.call(t, i)
                },
                isEmptyObject: function(t) {
                    var e;
                    for (e in t) return !1;
                    return !0
                },
                error: function(t) {
                    throw new Error(t)
                },
                parseHTML: function(t, e, i) {
                    if (!t || "string" != typeof t) return null;
                    "boolean" == typeof e && (i = e, e = !1), e = e || X;
                    var n = ft.exec(t),
                        s = !i && [];
                    return n ? [e.createElement(n[1])] : (n = ht.buildFragment([t], e, s), s && ht(s).remove(), ht.merge([], n.childNodes))
                },
                parseJSON: function(e) {
                    return t.JSON && t.JSON.parse ? t.JSON.parse(e) : null === e ? e : "string" == typeof e && (e = ht.trim(e)) && gt.test(e.replace(vt, "@").replace(yt, "]").replace(mt, "")) ? new Function("return " + e)() : void ht.error("Invalid JSON: " + e)
                },
                parseXML: function(i) {
                    var n, s;
                    if (!i || "string" != typeof i) return null;
                    try {
                        t.DOMParser ? (s = new DOMParser, n = s.parseFromString(i, "text/xml")) : (n = new ActiveXObject("Microsoft.XMLDOM"), n.async = "false", n.loadXML(i))
                    } catch (t) {
                        n = e
                    }
                    return n && n.documentElement && !n.getElementsByTagName("parsererror").length || ht.error("Invalid XML: " + i), n
                },
                noop: function() {},
                globalEval: function(e) {
                    e && ht.trim(e) && (t.execScript || function(e) {
                        t.eval.call(t, e)
                    })(e)
                },
                camelCase: function(t) {
                    return t.replace(bt, "ms-").replace(_t, wt)
                },
                nodeName: function(t, e) {
                    return t.nodeName && t.nodeName.toLowerCase() === e.toLowerCase()
                },
                each: function(t, e, n) {
                    var s = 0,
                        o = t.length,
                        r = i(t);
                    if (n) {
                        if (r)
                            for (; s < o && !1 !== e.apply(t[s], n); s++);
                        else
                            for (s in t)
                                if (!1 === e.apply(t[s], n)) break
                    } else if (r)
                        for (; s < o && !1 !== e.call(t[s], s, t[s]); s++);
                    else
                        for (s in t)
                            if (!1 === e.call(t[s], s, t[s])) break;
                    return t
                },
                trim: lt && !lt.call("\ufeff ") ? function(t) {
                    return null == t ? "" : lt.call(t)
                } : function(t) {
                    return null == t ? "" : (t + "").replace(dt, "")
                },
                makeArray: function(t, e) {
                    var n = e || [];
                    return null != t && (i(Object(t)) ? ht.merge(n, "string" == typeof t ? [t] : t) : nt.call(n, t)), n
                },
                inArray: function(t, e, i) {
                    var n;
                    if (e) {
                        if (ot) return ot.call(e, t, i);
                        for (n = e.length, i = i ? i < 0 ? Math.max(0, n + i) : i : 0; i < n; i++)
                            if (i in e && e[i] === t) return i
                    }
                    return -1
                },
                merge: function(t, i) {
                    var n = i.length,
                        s = t.length,
                        o = 0;
                    if ("number" == typeof n)
                        for (; o < n; o++) t[s++] = i[o];
                    else
                        for (; i[o] !== e;) t[s++] = i[o++];
                    return t.length = s, t
                },
                grep: function(t, e, i) {
                    var n, s = [],
                        o = 0,
                        r = t.length;
                    for (i = !!i; o < r; o++) n = !!e(t[o], o), i !== n && s.push(t[o]);
                    return s
                },
                map: function(t, e, n) {
                    var s, o = 0,
                        r = t.length,
                        a = i(t),
                        l = [];
                    if (a)
                        for (; o < r; o++) null != (s = e(t[o], o, n)) && (l[l.length] = s);
                    else
                        for (o in t) null != (s = e(t[o], o, n)) && (l[l.length] = s);
                    return it.apply([], l)
                },
                guid: 1,
                proxy: function(t, i) {
                    var n, s, o;
                    return "string" == typeof i && (o = t[i], i = t, t = o), ht.isFunction(t) ? (n = st.call(arguments, 2), s = function() {
                        return t.apply(i || this, n.concat(st.call(arguments)))
                    }, s.guid = t.guid = t.guid || ht.guid++, s) : e
                },
                access: function(t, i, n, s, o, r, a) {
                    var l = 0,
                        h = t.length,
                        c = null == n;
                    if ("object" === ht.type(n)) {
                        o = !0;
                        for (l in n) ht.access(t, i, l, n[l], !0, r, a)
                    } else if (s !== e && (o = !0, ht.isFunction(s) || (a = !0), c && (a ? (i.call(t, s), i = null) : (c = i, i = function(t, e, i) {
                            return c.call(ht(t), i)
                        })), i))
                        for (; l < h; l++) i(t[l], n, a ? s : s.call(t[l], l, i(t[l], n)));
                    return o ? t : c ? i.call(t) : h ? i(t[0], n) : r
                },
                now: function() {
                    return (new Date).getTime()
                },
                swap: function(t, e, i, n) {
                    var s, o, r = {};
                    for (o in e) r[o] = t.style[o], t.style[o] = e[o];
                    s = i.apply(t, n || []);
                    for (o in e) t.style[o] = r[o];
                    return s
                }
            }), ht.ready.promise = function(e) {
                if (!Y)
                    if (Y = ht.Deferred(), "complete" === X.readyState) setTimeout(ht.ready);
                    else if (X.addEventListener) X.addEventListener("DOMContentLoaded", xt, !1), t.addEventListener("load", xt, !1);
                else {
                    X.attachEvent("onreadystatechange", xt), t.attachEvent("onload", xt);
                    var i = !1;
                    try {
                        i = null == t.frameElement && X.documentElement
                    } catch (t) {}
                    i && i.doScroll && function t() {
                        if (!ht.isReady) {
                            try {
                                i.doScroll("left")
                            } catch (e) {
                                return setTimeout(t, 50)
                            }
                            Ct(), ht.ready()
                        }
                    }()
                }
                return Y.promise(e)
            }, ht.each("Boolean Number String Function Array Date RegExp Object Error".split(" "), function(t, e) {
                tt["[object " + e + "]"] = e.toLowerCase()
            }), V = ht(X),
            function(t, e) {
                function i(t, e, i, n) {
                    var s, o, r, a, l, h, d, p, f, g;
                    if ((e ? e.ownerDocument || e : z) !== E && A(e), e = e || E, i = i || [], !t || "string" != typeof t) return i;
                    if (1 !== (a = e.nodeType) && 9 !== a) return [];
                    if (P && !n) {
                        if (s = mt.exec(t))
                            if (r = s[1]) {
                                if (9 === a) {
                                    if (!(o = e.getElementById(r)) || !o.parentNode) return i;
                                    if (o.id === r) return i.push(o), i
                                } else if (e.ownerDocument && (o = e.ownerDocument.getElementById(r)) && H(e, o) && o.id === r) return i.push(o), i
                            } else {
                                if (s[2]) return G.apply(i, e.getElementsByTagName(t)), i;
                                if ((r = s[3]) && w.getElementsByClassName && e.getElementsByClassName) return G.apply(i, e.getElementsByClassName(r)), i
                            } if (w.qsa && (!N || !N.test(t))) {
                            if (p = d = j, f = e, g = 9 === a && t, 1 === a && "object" !== e.nodeName.toLowerCase()) {
                                for (h = c(t), (d = e.getAttribute("id")) ? p = d.replace(bt, "\\$&") : e.setAttribute("id", p), p = "[id='" + p + "'] ", l = h.length; l--;) h[l] = p + u(h[l]);
                                f = ct.test(t) && e.parentNode || e, g = h.join(",")
                            }
                            if (g) try {
                                return G.apply(i, f.querySelectorAll(g)), i
                            } catch (t) {} finally {
                                d || e.removeAttribute("id")
                            }
                        }
                    }
                    return b(t.replace(rt, "$1"), e, i, n)
                }

                function n() {
                    function t(i, n) {
                        return e.push(i += " ") > C.cacheLength && delete t[e.shift()], t[i] = n
                    }
                    var e = [];
                    return t
                }

                function s(t) {
                    return t[j] = !0, t
                }

                function o(t) {
                    var e = E.createElement("div");
                    try {
                        return !!t(e)
                    } catch (t) {
                        return !1
                    } finally {
                        e.parentNode && e.parentNode.removeChild(e), e = null
                    }
                }

                function r(t, e) {
                    for (var i = t.split("|"), n = t.length; n--;) C.attrHandle[i[n]] = e
                }

                function a(t, e) {
                    var i = e && t,
                        n = i && 1 === t.nodeType && 1 === e.nodeType && (~e.sourceIndex || Y) - (~t.sourceIndex || Y);
                    if (n) return n;
                    if (i)
                        for (; i = i.nextSibling;)
                            if (i === e) return -1;
                    return t ? 1 : -1
                }

                function l(t) {
                    return s(function(e) {
                        return e = +e, s(function(i, n) {
                            for (var s, o = t([], i.length, e), r = o.length; r--;) i[s = o[r]] && (i[s] = !(n[s] = i[s]))
                        })
                    })
                }

                function h() {}

                function c(t, e) {
                    var n, s, o, r, a, l, h, c = F[t + " "];
                    if (c) return e ? 0 : c.slice(0);
                    for (a = t, l = [], h = C.preFilter; a;) {
                        n && !(s = at.exec(a)) || (s && (a = a.slice(s[0].length) || a), l.push(o = [])), n = !1, (s = lt.exec(a)) && (n = s.shift(), o.push({
                            value: n,
                            type: s[0].replace(rt, " ")
                        }), a = a.slice(n.length));
                        for (r in C.filter) !(s = ft[r].exec(a)) || h[r] && !(s = h[r](s)) || (n = s.shift(), o.push({
                            value: n,
                            type: r,
                            matches: s
                        }), a = a.slice(n.length));
                        if (!n) break
                    }
                    return e ? a.length : a ? i.error(t) : F(t, l).slice(0)
                }

                function u(t) {
                    for (var e = 0, i = t.length, n = ""; e < i; e++) n += t[e].value;
                    return n
                }

                function d(t, e, i) {
                    var n = e.dir,
                        s = i && "parentNode" === n,
                        o = R++;
                    return e.first ? function(e, i, o) {
                        for (; e = e[n];)
                            if (1 === e.nodeType || s) return t(e, i, o)
                    } : function(e, i, r) {
                        var a, l, h, c = L + " " + o;
                        if (r) {
                            for (; e = e[n];)
                                if ((1 === e.nodeType || s) && t(e, i, r)) return !0
                        } else
                            for (; e = e[n];)
                                if (1 === e.nodeType || s)
                                    if (h = e[j] || (e[j] = {}), (l = h[n]) && l[0] === c) {
                                        if (!0 === (a = l[1]) || a === x) return !0 === a
                                    } else if (l = h[n] = [c], l[1] = t(e, i, r) || x, !0 === l[1]) return !0
                    }
                }

                function p(t) {
                    return t.length > 1 ? function(e, i, n) {
                        for (var s = t.length; s--;)
                            if (!t[s](e, i, n)) return !1;
                        return !0
                    } : t[0]
                }

                function f(t, e, i, n, s) {
                    for (var o, r = [], a = 0, l = t.length, h = null != e; a < l; a++)(o = t[a]) && (i && !i(o, n, s) || (r.push(o), h && e.push(a)));
                    return r
                }

                function g(t, e, i, n, o, r) {
                    return n && !n[j] && (n = g(n)), o && !o[j] && (o = g(o, r)), s(function(s, r, a, l) {
                        var h, c, u, d = [],
                            p = [],
                            g = r.length,
                            m = s || y(e || "*", a.nodeType ? [a] : a, []),
                            v = !t || !s && e ? m : f(m, d, t, a, l),
                            b = i ? o || (s ? t : g || n) ? [] : r : v;
                        if (i && i(v, b, a, l), n)
                            for (h = f(b, p), n(h, [], a, l), c = h.length; c--;)(u = h[c]) && (b[p[c]] = !(v[p[c]] = u));
                        if (s) {
                            if (o || t) {
                                if (o) {
                                    for (h = [], c = b.length; c--;)(u = b[c]) && h.push(v[c] = u);
                                    o(null, b = [], h, l)
                                }
                                for (c = b.length; c--;)(u = b[c]) && (h = o ? J.call(s, u) : d[c]) > -1 && (s[h] = !(r[h] = u))
                            }
                        } else b = f(b === r ? b.splice(g, b.length) : b), o ? o(null, r, b, l) : G.apply(r, b)
                    })
                }

                function m(t) {
                    for (var e, i, n, s = t.length, o = C.relative[t[0].type], r = o || C.relative[" "], a = o ? 1 : 0, l = d(function(t) {
                            return t === e
                        }, r, !0), h = d(function(t) {
                            return J.call(e, t) > -1
                        }, r, !0), c = [function(t, i, n) {
                            return !o && (n || i !== D) || ((e = i).nodeType ? l(t, i, n) : h(t, i, n))
                        }]; a < s; a++)
                        if (i = C.relative[t[a].type]) c = [d(p(c), i)];
                        else {
                            if (i = C.filter[t[a].type].apply(null, t[a].matches), i[j]) {
                                for (n = ++a; n < s && !C.relative[t[n].type]; n++);
                                return g(a > 1 && p(c), a > 1 && u(t.slice(0, a - 1).concat({
                                    value: " " === t[a - 2].type ? "*" : ""
                                })).replace(rt, "$1"), i, a < n && m(t.slice(a, n)), n < s && m(t = t.slice(n)), n < s && u(t))
                            }
                            c.push(i)
                        } return p(c)
                }

                function v(t, e) {
                    var n = 0,
                        o = e.length > 0,
                        r = t.length > 0,
                        a = function(s, a, l, h, c) {
                            var u, d, p, g = [],
                                m = 0,
                                v = "0",
                                y = s && [],
                                b = null != c,
                                _ = D,
                                w = s || r && C.find.TAG("*", c && a.parentNode || a),
                                k = L += null == _ ? 1 : Math.random() || .1;
                            for (b && (D = a !== E && a, x = n); null != (u = w[v]); v++) {
                                if (r && u) {
                                    for (d = 0; p = t[d++];)
                                        if (p(u, a, l)) {
                                            h.push(u);
                                            break
                                        } b && (L = k, x = ++n)
                                }
                                o && ((u = !p && u) && m--, s && y.push(u))
                            }
                            if (m += v, o && v !== m) {
                                for (d = 0; p = e[d++];) p(y, g, a, l);
                                if (s) {
                                    if (m > 0)
                                        for (; v--;) y[v] || g[v] || (g[v] = K.call(h));
                                    g = f(g)
                                }
                                G.apply(h, g), b && !s && g.length > 0 && m + e.length > 1 && i.uniqueSort(h)
                            }
                            return b && (L = k, D = _), y
                        };
                    return o ? s(a) : a
                }

                function y(t, e, n) {
                    for (var s = 0, o = e.length; s < o; s++) i(t, e[s], n);
                    return n
                }

                function b(t, e, i, n) {
                    var s, o, r, a, l, h = c(t);
                    if (!n && 1 === h.length) {
                        if (o = h[0] = h[0].slice(0), o.length > 2 && "ID" === (r = o[0]).type && w.getById && 9 === e.nodeType && P && C.relative[o[1].type]) {
                            if (!(e = (C.find.ID(r.matches[0].replace(_t, wt), e) || [])[0])) return i;
                            t = t.slice(o.shift().value.length)
                        }
                        for (s = ft.needsContext.test(t) ? 0 : o.length; s-- && (r = o[s], !C.relative[a = r.type]);)
                            if ((l = C.find[a]) && (n = l(r.matches[0].replace(_t, wt), ct.test(o[0].type) && e.parentNode || e))) {
                                if (o.splice(s, 1), !(t = n.length && u(o))) return G.apply(i, n), i;
                                break
                            }
                    }
                    return $(t, h)(n, e, !P, i, ct.test(t)), i
                }
                var _, w, x, C, k, T, $, D, S, A, E, I, P, N, M, O, H, j = "sizzle" + -new Date,
                    z = t.document,
                    L = 0,
                    R = 0,
                    W = n(),
                    F = n(),
                    q = n(),
                    B = !1,
                    U = function(t, e) {
                        return t === e ? (B = !0, 0) : 0
                    },
                    Y = 1 << 31,
                    V = {}.hasOwnProperty,
                    Q = [],
                    K = Q.pop,
                    X = Q.push,
                    G = Q.push,
                    Z = Q.slice,
                    J = Q.indexOf || function(t) {
                        for (var e = 0, i = this.length; e < i; e++)
                            if (this[e] === t) return e;
                        return -1
                    },
                    tt = "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",
                    et = "[\\x20\\t\\r\\n\\f]",
                    it = "(?:\\\\.|[\\w-]|[^\\x00-\\xa0])+",
                    nt = it.replace("w", "w#"),
                    st = "\\[" + et + "*(" + it + ")" + et + "*(?:([*^$|!~]?=)" + et + "*(?:(['\"])((?:\\\\.|[^\\\\])*?)\\3|(" + nt + ")|)|)" + et + "*\\]",
                    ot = ":(" + it + ")(?:\\(((['\"])((?:\\\\.|[^\\\\])*?)\\3|((?:\\\\.|[^\\\\()[\\]]|" + st.replace(3, 8) + ")*)|.*)\\)|)",
                    rt = new RegExp("^" + et + "+|((?:^|[^\\\\])(?:\\\\.)*)" + et + "+$", "g"),
                    at = new RegExp("^" + et + "*," + et + "*"),
                    lt = new RegExp("^" + et + "*([>+~]|" + et + ")" + et + "*"),
                    ct = new RegExp(et + "*[+~]"),
                    ut = new RegExp("=" + et + "*([^\\]'\"]*)" + et + "*\\]", "g"),
                    dt = new RegExp(ot),
                    pt = new RegExp("^" + nt + "$"),
                    ft = {
                        ID: new RegExp("^#(" + it + ")"),
                        CLASS: new RegExp("^\\.(" + it + ")"),
                        TAG: new RegExp("^(" + it.replace("w", "w*") + ")"),
                        ATTR: new RegExp("^" + st),
                        PSEUDO: new RegExp("^" + ot),
                        CHILD: new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" + et + "*(even|odd|(([+-]|)(\\d*)n|)" + et + "*(?:([+-]|)" + et + "*(\\d+)|))" + et + "*\\)|)", "i"),
                        bool: new RegExp("^(?:" + tt + ")$", "i"),
                        needsContext: new RegExp("^" + et + "*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + et + "*((?:-\\d)?\\d*)" + et + "*\\)|)(?=[^-]|$)", "i")
                    },
                    gt = /^[^{]+\{\s*\[native \w/,
                    mt = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,
                    vt = /^(?:input|select|textarea|button)$/i,
                    yt = /^h\d$/i,
                    bt = /'|\\/g,
                    _t = new RegExp("\\\\([\\da-f]{1,6}" + et + "?|(" + et + ")|.)", "ig"),
                    wt = function(t, e, i) {
                        var n = "0x" + e - 65536;
                        return n !== n || i ? e : n < 0 ? String.fromCharCode(n + 65536) : String.fromCharCode(n >> 10 | 55296, 1023 & n | 56320)
                    };
                try {
                    G.apply(Q = Z.call(z.childNodes), z.childNodes), Q[z.childNodes.length].nodeType
                } catch (t) {
                    G = {
                        apply: Q.length ? function(t, e) {
                            X.apply(t, Z.call(e))
                        } : function(t, e) {
                            for (var i = t.length, n = 0; t[i++] = e[n++];);
                            t.length = i - 1
                        }
                    }
                }
                T = i.isXML = function(t) {
                    var e = t && (t.ownerDocument || t).documentElement;
                    return !!e && "HTML" !== e.nodeName
                }, w = i.support = {}, A = i.setDocument = function(t) {
                    var e = t ? t.ownerDocument || t : z,
                        i = e.defaultView;
                    return e !== E && 9 === e.nodeType && e.documentElement ? (E = e, I = e.documentElement, P = !T(e), i && i.attachEvent && i !== i.top && i.attachEvent("onbeforeunload", function() {
                        A()
                    }), w.attributes = o(function(t) {
                        return t.className = "i", !t.getAttribute("className")
                    }), w.getElementsByTagName = o(function(t) {
                        return t.appendChild(e.createComment("")), !t.getElementsByTagName("*").length
                    }), w.getElementsByClassName = o(function(t) {
                        return t.innerHTML = "<div class='a'></div><div class='a i'></div>", t.firstChild.className = "i", 2 === t.getElementsByClassName("i").length
                    }), w.getById = o(function(t) {
                        return I.appendChild(t).id = j, !e.getElementsByName || !e.getElementsByName(j).length
                    }), w.getById ? (C.find.ID = function(t, e) {
                        if (void 0 !== e.getElementById && P) {
                            var i = e.getElementById(t);
                            return i && i.parentNode ? [i] : []
                        }
                    }, C.filter.ID = function(t) {
                        var e = t.replace(_t, wt);
                        return function(t) {
                            return t.getAttribute("id") === e
                        }
                    }) : (delete C.find.ID, C.filter.ID = function(t) {
                        var e = t.replace(_t, wt);
                        return function(t) {
                            var i = void 0 !== t.getAttributeNode && t.getAttributeNode("id");
                            return i && i.value === e
                        }
                    }), C.find.TAG = w.getElementsByTagName ? function(t, e) {
                        if (void 0 !== e.getElementsByTagName) return e.getElementsByTagName(t)
                    } : function(t, e) {
                        var i, n = [],
                            s = 0,
                            o = e.getElementsByTagName(t);
                        if ("*" === t) {
                            for (; i = o[s++];) 1 === i.nodeType && n.push(i);
                            return n
                        }
                        return o
                    }, C.find.CLASS = w.getElementsByClassName && function(t, e) {
                        if (void 0 !== e.getElementsByClassName && P) return e.getElementsByClassName(t)
                    }, M = [], N = [], (w.qsa = gt.test(e.querySelectorAll)) && (o(function(t) {
                        t.innerHTML = "<select><option selected=''></option></select>",
                            t.querySelectorAll("[selected]").length || N.push("\\[" + et + "*(?:value|" + tt + ")"), t.querySelectorAll(":checked").length || N.push(":checked")
                    }), o(function(t) {
                        var i = e.createElement("input");
                        i.setAttribute("type", "hidden"), t.appendChild(i).setAttribute("t", ""), t.querySelectorAll("[t^='']").length && N.push("[*^$]=" + et + "*(?:''|\"\")"), t.querySelectorAll(":enabled").length || N.push(":enabled", ":disabled"), t.querySelectorAll("*,:x"), N.push(",.*:")
                    })), (w.matchesSelector = gt.test(O = I.webkitMatchesSelector || I.mozMatchesSelector || I.oMatchesSelector || I.msMatchesSelector)) && o(function(t) {
                        w.disconnectedMatch = O.call(t, "div"), O.call(t, "[s!='']:x"), M.push("!=", ot)
                    }), N = N.length && new RegExp(N.join("|")), M = M.length && new RegExp(M.join("|")), H = gt.test(I.contains) || I.compareDocumentPosition ? function(t, e) {
                        var i = 9 === t.nodeType ? t.documentElement : t,
                            n = e && e.parentNode;
                        return t === n || !(!n || 1 !== n.nodeType || !(i.contains ? i.contains(n) : t.compareDocumentPosition && 16 & t.compareDocumentPosition(n)))
                    } : function(t, e) {
                        if (e)
                            for (; e = e.parentNode;)
                                if (e === t) return !0;
                        return !1
                    }, U = I.compareDocumentPosition ? function(t, i) {
                        if (t === i) return B = !0, 0;
                        var n = i.compareDocumentPosition && t.compareDocumentPosition && t.compareDocumentPosition(i);
                        return n ? 1 & n || !w.sortDetached && i.compareDocumentPosition(t) === n ? t === e || H(z, t) ? -1 : i === e || H(z, i) ? 1 : S ? J.call(S, t) - J.call(S, i) : 0 : 4 & n ? -1 : 1 : t.compareDocumentPosition ? -1 : 1
                    } : function(t, i) {
                        var n, s = 0,
                            o = t.parentNode,
                            r = i.parentNode,
                            l = [t],
                            h = [i];
                        if (t === i) return B = !0, 0;
                        if (!o || !r) return t === e ? -1 : i === e ? 1 : o ? -1 : r ? 1 : S ? J.call(S, t) - J.call(S, i) : 0;
                        if (o === r) return a(t, i);
                        for (n = t; n = n.parentNode;) l.unshift(n);
                        for (n = i; n = n.parentNode;) h.unshift(n);
                        for (; l[s] === h[s];) s++;
                        return s ? a(l[s], h[s]) : l[s] === z ? -1 : h[s] === z ? 1 : 0
                    }, e) : E
                }, i.matches = function(t, e) {
                    return i(t, null, null, e)
                }, i.matchesSelector = function(t, e) {
                    if ((t.ownerDocument || t) !== E && A(t), e = e.replace(ut, "='$1']"), w.matchesSelector && P && (!M || !M.test(e)) && (!N || !N.test(e))) try {
                        var n = O.call(t, e);
                        if (n || w.disconnectedMatch || t.document && 11 !== t.document.nodeType) return n
                    } catch (t) {}
                    return i(e, E, null, [t]).length > 0
                }, i.contains = function(t, e) {
                    return (t.ownerDocument || t) !== E && A(t), H(t, e)
                }, i.attr = function(t, e) {
                    (t.ownerDocument || t) !== E && A(t);
                    var i = C.attrHandle[e.toLowerCase()],
                        n = i && V.call(C.attrHandle, e.toLowerCase()) ? i(t, e, !P) : void 0;
                    return void 0 === n ? w.attributes || !P ? t.getAttribute(e) : (n = t.getAttributeNode(e)) && n.specified ? n.value : null : n
                }, i.error = function(t) {
                    throw new Error("Syntax error, unrecognized expression: " + t)
                }, i.uniqueSort = function(t) {
                    var e, i = [],
                        n = 0,
                        s = 0;
                    if (B = !w.detectDuplicates, S = !w.sortStable && t.slice(0), t.sort(U), B) {
                        for (; e = t[s++];) e === t[s] && (n = i.push(s));
                        for (; n--;) t.splice(i[n], 1)
                    }
                    return t
                }, k = i.getText = function(t) {
                    var e, i = "",
                        n = 0,
                        s = t.nodeType;
                    if (s) {
                        if (1 === s || 9 === s || 11 === s) {
                            if ("string" == typeof t.textContent) return t.textContent;
                            for (t = t.firstChild; t; t = t.nextSibling) i += k(t)
                        } else if (3 === s || 4 === s) return t.nodeValue
                    } else
                        for (; e = t[n]; n++) i += k(e);
                    return i
                }, C = i.selectors = {
                    cacheLength: 50,
                    createPseudo: s,
                    match: ft,
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
                            return t[1] = t[1].replace(_t, wt), t[3] = (t[4] || t[5] || "").replace(_t, wt), "~=" === t[2] && (t[3] = " " + t[3] + " "), t.slice(0, 4)
                        },
                        CHILD: function(t) {
                            return t[1] = t[1].toLowerCase(), "nth" === t[1].slice(0, 3) ? (t[3] || i.error(t[0]), t[4] = +(t[4] ? t[5] + (t[6] || 1) : 2 * ("even" === t[3] || "odd" === t[3])), t[5] = +(t[7] + t[8] || "odd" === t[3])) : t[3] && i.error(t[0]), t
                        },
                        PSEUDO: function(t) {
                            var e, i = !t[5] && t[2];
                            return ft.CHILD.test(t[0]) ? null : (t[3] && void 0 !== t[4] ? t[2] = t[4] : i && dt.test(i) && (e = c(i, !0)) && (e = i.indexOf(")", i.length - e) - i.length) && (t[0] = t[0].slice(0, e), t[2] = i.slice(0, e)), t.slice(0, 3))
                        }
                    },
                    filter: {
                        TAG: function(t) {
                            var e = t.replace(_t, wt).toLowerCase();
                            return "*" === t ? function() {
                                return !0
                            } : function(t) {
                                return t.nodeName && t.nodeName.toLowerCase() === e
                            }
                        },
                        CLASS: function(t) {
                            var e = W[t + " "];
                            return e || (e = new RegExp("(^|" + et + ")" + t + "(" + et + "|$)")) && W(t, function(t) {
                                return e.test("string" == typeof t.className && t.className || void 0 !== t.getAttribute && t.getAttribute("class") || "")
                            })
                        },
                        ATTR: function(t, e, n) {
                            return function(s) {
                                var o = i.attr(s, t);
                                return null == o ? "!=" === e : !e || (o += "", "=" === e ? o === n : "!=" === e ? o !== n : "^=" === e ? n && 0 === o.indexOf(n) : "*=" === e ? n && o.indexOf(n) > -1 : "$=" === e ? n && o.slice(-n.length) === n : "~=" === e ? (" " + o + " ").indexOf(n) > -1 : "|=" === e && (o === n || o.slice(0, n.length + 1) === n + "-"))
                            }
                        },
                        CHILD: function(t, e, i, n, s) {
                            var o = "nth" !== t.slice(0, 3),
                                r = "last" !== t.slice(-4),
                                a = "of-type" === e;
                            return 1 === n && 0 === s ? function(t) {
                                return !!t.parentNode
                            } : function(e, i, l) {
                                var h, c, u, d, p, f, g = o !== r ? "nextSibling" : "previousSibling",
                                    m = e.parentNode,
                                    v = a && e.nodeName.toLowerCase(),
                                    y = !l && !a;
                                if (m) {
                                    if (o) {
                                        for (; g;) {
                                            for (u = e; u = u[g];)
                                                if (a ? u.nodeName.toLowerCase() === v : 1 === u.nodeType) return !1;
                                            f = g = "only" === t && !f && "nextSibling"
                                        }
                                        return !0
                                    }
                                    if (f = [r ? m.firstChild : m.lastChild], r && y) {
                                        for (c = m[j] || (m[j] = {}), h = c[t] || [], p = h[0] === L && h[1], d = h[0] === L && h[2], u = p && m.childNodes[p]; u = ++p && u && u[g] || (d = p = 0) || f.pop();)
                                            if (1 === u.nodeType && ++d && u === e) {
                                                c[t] = [L, p, d];
                                                break
                                            }
                                    } else if (y && (h = (e[j] || (e[j] = {}))[t]) && h[0] === L) d = h[1];
                                    else
                                        for (;
                                            (u = ++p && u && u[g] || (d = p = 0) || f.pop()) && ((a ? u.nodeName.toLowerCase() !== v : 1 !== u.nodeType) || !++d || (y && ((u[j] || (u[j] = {}))[t] = [L, d]), u !== e)););
                                    return (d -= s) === n || d % n == 0 && d / n >= 0
                                }
                            }
                        },
                        PSEUDO: function(t, e) {
                            var n, o = C.pseudos[t] || C.setFilters[t.toLowerCase()] || i.error("unsupported pseudo: " + t);
                            return o[j] ? o(e) : o.length > 1 ? (n = [t, t, "", e], C.setFilters.hasOwnProperty(t.toLowerCase()) ? s(function(t, i) {
                                for (var n, s = o(t, e), r = s.length; r--;) n = J.call(t, s[r]), t[n] = !(i[n] = s[r])
                            }) : function(t) {
                                return o(t, 0, n)
                            }) : o
                        }
                    },
                    pseudos: {
                        not: s(function(t) {
                            var e = [],
                                i = [],
                                n = $(t.replace(rt, "$1"));
                            return n[j] ? s(function(t, e, i, s) {
                                for (var o, r = n(t, null, s, []), a = t.length; a--;)(o = r[a]) && (t[a] = !(e[a] = o))
                            }) : function(t, s, o) {
                                return e[0] = t, n(e, null, o, i), !i.pop()
                            }
                        }),
                        has: s(function(t) {
                            return function(e) {
                                return i(t, e).length > 0
                            }
                        }),
                        contains: s(function(t) {
                            return function(e) {
                                return (e.textContent || e.innerText || k(e)).indexOf(t) > -1
                            }
                        }),
                        lang: s(function(t) {
                            return pt.test(t || "") || i.error("unsupported lang: " + t), t = t.replace(_t, wt).toLowerCase(),
                                function(e) {
                                    var i;
                                    do {
                                        if (i = P ? e.lang : e.getAttribute("xml:lang") || e.getAttribute("lang")) return (i = i.toLowerCase()) === t || 0 === i.indexOf(t + "-")
                                    } while ((e = e.parentNode) && 1 === e.nodeType);
                                    return !1
                                }
                        }),
                        target: function(e) {
                            var i = t.location && t.location.hash;
                            return i && i.slice(1) === e.id
                        },
                        root: function(t) {
                            return t === I
                        },
                        focus: function(t) {
                            return t === E.activeElement && (!E.hasFocus || E.hasFocus()) && !!(t.type || t.href || ~t.tabIndex)
                        },
                        enabled: function(t) {
                            return !1 === t.disabled
                        },
                        disabled: function(t) {
                            return !0 === t.disabled
                        },
                        checked: function(t) {
                            var e = t.nodeName.toLowerCase();
                            return "input" === e && !!t.checked || "option" === e && !!t.selected
                        },
                        selected: function(t) {
                            return t.parentNode && t.parentNode.selectedIndex, !0 === t.selected
                        },
                        empty: function(t) {
                            for (t = t.firstChild; t; t = t.nextSibling)
                                if (t.nodeName > "@" || 3 === t.nodeType || 4 === t.nodeType) return !1;
                            return !0
                        },
                        parent: function(t) {
                            return !C.pseudos.empty(t)
                        },
                        header: function(t) {
                            return yt.test(t.nodeName)
                        },
                        input: function(t) {
                            return vt.test(t.nodeName)
                        },
                        button: function(t) {
                            var e = t.nodeName.toLowerCase();
                            return "input" === e && "button" === t.type || "button" === e
                        },
                        text: function(t) {
                            var e;
                            return "input" === t.nodeName.toLowerCase() && "text" === t.type && (null == (e = t.getAttribute("type")) || e.toLowerCase() === t.type)
                        },
                        first: l(function() {
                            return [0]
                        }),
                        last: l(function(t, e) {
                            return [e - 1]
                        }),
                        eq: l(function(t, e, i) {
                            return [i < 0 ? i + e : i]
                        }),
                        even: l(function(t, e) {
                            for (var i = 0; i < e; i += 2) t.push(i);
                            return t
                        }),
                        odd: l(function(t, e) {
                            for (var i = 1; i < e; i += 2) t.push(i);
                            return t
                        }),
                        lt: l(function(t, e, i) {
                            for (var n = i < 0 ? i + e : i; --n >= 0;) t.push(n);
                            return t
                        }),
                        gt: l(function(t, e, i) {
                            for (var n = i < 0 ? i + e : i; ++n < e;) t.push(n);
                            return t
                        })
                    }
                }, C.pseudos.nth = C.pseudos.eq;
                for (_ in {
                        radio: !0,
                        checkbox: !0,
                        file: !0,
                        password: !0,
                        image: !0
                    }) C.pseudos[_] = function(t) {
                    return function(e) {
                        return "input" === e.nodeName.toLowerCase() && e.type === t
                    }
                }(_);
                for (_ in {
                        submit: !0,
                        reset: !0
                    }) C.pseudos[_] = function(t) {
                    return function(e) {
                        var i = e.nodeName.toLowerCase();
                        return ("input" === i || "button" === i) && e.type === t
                    }
                }(_);
                h.prototype = C.filters = C.pseudos, C.setFilters = new h, $ = i.compile = function(t, e) {
                    var i, n = [],
                        s = [],
                        o = q[t + " "];
                    if (!o) {
                        for (e || (e = c(t)), i = e.length; i--;) o = m(e[i]), o[j] ? n.push(o) : s.push(o);
                        o = q(t, v(s, n))
                    }
                    return o
                }, w.sortStable = j.split("").sort(U).join("") === j, w.detectDuplicates = B, A(), w.sortDetached = o(function(t) {
                    return 1 & t.compareDocumentPosition(E.createElement("div"))
                }), o(function(t) {
                    return t.innerHTML = "<a href='#'></a>", "#" === t.firstChild.getAttribute("href")
                }) || r("type|href|height|width", function(t, e, i) {
                    if (!i) return t.getAttribute(e, "type" === e.toLowerCase() ? 1 : 2)
                }), w.attributes && o(function(t) {
                    return t.innerHTML = "<input/>", t.firstChild.setAttribute("value", ""), "" === t.firstChild.getAttribute("value")
                }) || r("value", function(t, e, i) {
                    if (!i && "input" === t.nodeName.toLowerCase()) return t.defaultValue
                }), o(function(t) {
                    return null == t.getAttribute("disabled")
                }) || r(tt, function(t, e, i) {
                    var n;
                    if (!i) return (n = t.getAttributeNode(e)) && n.specified ? n.value : !0 === t[e] ? e.toLowerCase() : null
                }), ht.find = i, ht.expr = i.selectors, ht.expr[":"] = ht.expr.pseudos, ht.unique = i.uniqueSort, ht.text = i.getText, ht.isXMLDoc = i.isXML, ht.contains = i.contains
            }(t);
        var kt = {};
        ht.Callbacks = function(t) {
            t = "string" == typeof t ? kt[t] || n(t) : ht.extend({}, t);
            var i, s, o, r, a, l, h = [],
                c = !t.once && [],
                u = function(e) {
                    for (s = t.memory && e, o = !0, a = l || 0, l = 0, r = h.length, i = !0; h && a < r; a++)
                        if (!1 === h[a].apply(e[0], e[1]) && t.stopOnFalse) {
                            s = !1;
                            break
                        } i = !1, h && (c ? c.length && u(c.shift()) : s ? h = [] : d.disable())
                },
                d = {
                    add: function() {
                        if (h) {
                            var e = h.length;
                            ! function e(i) {
                                ht.each(i, function(i, n) {
                                    var s = ht.type(n);
                                    "function" === s ? t.unique && d.has(n) || h.push(n) : n && n.length && "string" !== s && e(n)
                                })
                            }(arguments), i ? r = h.length : s && (l = e, u(s))
                        }
                        return this
                    },
                    remove: function() {
                        return h && ht.each(arguments, function(t, e) {
                            for (var n;
                                (n = ht.inArray(e, h, n)) > -1;) h.splice(n, 1), i && (n <= r && r--, n <= a && a--)
                        }), this
                    },
                    has: function(t) {
                        return t ? ht.inArray(t, h) > -1 : !(!h || !h.length)
                    },
                    empty: function() {
                        return h = [], r = 0, this
                    },
                    disable: function() {
                        return h = c = s = e, this
                    },
                    disabled: function() {
                        return !h
                    },
                    lock: function() {
                        return c = e, s || d.disable(), this
                    },
                    locked: function() {
                        return !c
                    },
                    fireWith: function(t, e) {
                        return !h || o && !c || (e = e || [], e = [t, e.slice ? e.slice() : e], i ? c.push(e) : u(e)), this
                    },
                    fire: function() {
                        return d.fireWith(this, arguments), this
                    },
                    fired: function() {
                        return !!o
                    }
                };
            return d
        }, ht.extend({
            Deferred: function(t) {
                var e = [
                        ["resolve", "done", ht.Callbacks("once memory"), "resolved"],
                        ["reject", "fail", ht.Callbacks("once memory"), "rejected"],
                        ["notify", "progress", ht.Callbacks("memory")]
                    ],
                    i = "pending",
                    n = {
                        state: function() {
                            return i
                        },
                        always: function() {
                            return s.done(arguments).fail(arguments), this
                        },
                        then: function() {
                            var t = arguments;
                            return ht.Deferred(function(i) {
                                ht.each(e, function(e, o) {
                                    var r = o[0],
                                        a = ht.isFunction(t[e]) && t[e];
                                    s[o[1]](function() {
                                        var t = a && a.apply(this, arguments);
                                        t && ht.isFunction(t.promise) ? t.promise().done(i.resolve).fail(i.reject).progress(i.notify) : i[r + "With"](this === n ? i.promise() : this, a ? [t] : arguments)
                                    })
                                }), t = null
                            }).promise()
                        },
                        promise: function(t) {
                            return null != t ? ht.extend(t, n) : n
                        }
                    },
                    s = {};
                return n.pipe = n.then, ht.each(e, function(t, o) {
                    var r = o[2],
                        a = o[3];
                    n[o[1]] = r.add, a && r.add(function() {
                        i = a
                    }, e[1 ^ t][2].disable, e[2][2].lock), s[o[0]] = function() {
                        return s[o[0] + "With"](this === s ? n : this, arguments), this
                    }, s[o[0] + "With"] = r.fireWith
                }), n.promise(s), t && t.call(s, s), s
            },
            when: function(t) {
                var e, i, n, s = 0,
                    o = st.call(arguments),
                    r = o.length,
                    a = 1 !== r || t && ht.isFunction(t.promise) ? r : 0,
                    l = 1 === a ? t : ht.Deferred(),
                    h = function(t, i, n) {
                        return function(s) {
                            i[t] = this, n[t] = arguments.length > 1 ? st.call(arguments) : s, n === e ? l.notifyWith(i, n) : --a || l.resolveWith(i, n)
                        }
                    };
                if (r > 1)
                    for (e = new Array(r), i = new Array(r), n = new Array(r); s < r; s++) o[s] && ht.isFunction(o[s].promise) ? o[s].promise().done(h(s, n, o)).fail(l.reject).progress(h(s, i, e)) : --a;
                return a || l.resolveWith(n, o), l.promise()
            }
        }), ht.support = function(e) {
            var i, n, s, o, r, a, l, h, c, u = X.createElement("div");
            if (u.setAttribute("className", "t"), u.innerHTML = "  <link/><table></table><a href='/a'>a</a><input type='checkbox'/>", i = u.getElementsByTagName("*") || [], !(n = u.getElementsByTagName("a")[0]) || !n.style || !i.length) return e;
            o = X.createElement("select"), a = o.appendChild(X.createElement("option")), s = u.getElementsByTagName("input")[0], n.style.cssText = "top:1px;float:left;opacity:.5", e.getSetAttribute = "t" !== u.className, e.leadingWhitespace = 3 === u.firstChild.nodeType, e.tbody = !u.getElementsByTagName("tbody").length, e.htmlSerialize = !!u.getElementsByTagName("link").length, e.style = /top/.test(n.getAttribute("style")), e.hrefNormalized = "/a" === n.getAttribute("href"), e.opacity = /^0.5/.test(n.style.opacity), e.cssFloat = !!n.style.cssFloat, e.checkOn = !!s.value, e.optSelected = a.selected, e.enctype = !!X.createElement("form").enctype, e.html5Clone = "<:nav></:nav>" !== X.createElement("nav").cloneNode(!0).outerHTML, e.inlineBlockNeedsLayout = !1, e.shrinkWrapBlocks = !1, e.pixelPosition = !1, e.deleteExpando = !0, e.noCloneEvent = !0, e.reliableMarginRight = !0, e.boxSizingReliable = !0, s.checked = !0, e.noCloneChecked = s.cloneNode(!0).checked, o.disabled = !0, e.optDisabled = !a.disabled;
            try {
                delete u.test
            } catch (t) {
                e.deleteExpando = !1
            }
            s = X.createElement("input"), s.setAttribute("value", ""), e.input = "" === s.getAttribute("value"), s.value = "t", s.setAttribute("type", "radio"), e.radioValue = "t" === s.value, s.setAttribute("checked", "t"), s.setAttribute("name", "t"), r = X.createDocumentFragment(), r.appendChild(s), e.appendChecked = s.checked, e.checkClone = r.cloneNode(!0).cloneNode(!0).lastChild.checked, u.attachEvent && (u.attachEvent("onclick", function() {
                e.noCloneEvent = !1
            }), u.cloneNode(!0).click());
            for (c in {
                    submit: !0,
                    change: !0,
                    focusin: !0
                }) u.setAttribute(l = "on" + c, "t"), e[c + "Bubbles"] = l in t || !1 === u.attributes[l].expando;
            u.style.backgroundClip = "content-box", u.cloneNode(!0).style.backgroundClip = "", e.clearCloneStyle = "content-box" === u.style.backgroundClip;
            for (c in ht(e)) break;
            return e.ownLast = "0" !== c, ht(function() {
                var i, n, s, o = "padding:0;margin:0;border:0;display:block;box-sizing:content-box;-moz-box-sizing:content-box;-webkit-box-sizing:content-box;",
                    r = X.getElementsByTagName("body")[0];
                r && (i = X.createElement("div"), i.style.cssText = "border:0;width:0;height:0;position:absolute;top:0;left:-9999px;margin-top:1px", r.appendChild(i).appendChild(u), u.innerHTML = "<table><tr><td></td><td>t</td></tr></table>", s = u.getElementsByTagName("td"), s[0].style.cssText = "padding:0;margin:0;border:0;display:none", h = 0 === s[0].offsetHeight, s[0].style.display = "", s[1].style.display = "none", e.reliableHiddenOffsets = h && 0 === s[0].offsetHeight, u.innerHTML = "", u.style.cssText = "box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;padding:1px;border:1px;display:block;width:4px;margin-top:1%;position:absolute;top:1%;", ht.swap(r, null != r.style.zoom ? {
                    zoom: 1
                } : {}, function() {
                    e.boxSizing = 4 === u.offsetWidth
                }), t.getComputedStyle && (e.pixelPosition = "1%" !== (t.getComputedStyle(u, null) || {}).top, e.boxSizingReliable = "4px" === (t.getComputedStyle(u, null) || {
                    width: "4px"
                }).width, n = u.appendChild(X.createElement("div")), n.style.cssText = u.style.cssText = o, n.style.marginRight = n.style.width = "0", u.style.width = "1px", e.reliableMarginRight = !parseFloat((t.getComputedStyle(n, null) || {}).marginRight)), typeof u.style.zoom !== Q && (u.innerHTML = "", u.style.cssText = o + "width:1px;padding:1px;display:inline;zoom:1", e.inlineBlockNeedsLayout = 3 === u.offsetWidth, u.style.display = "block", u.innerHTML = "<div></div>", u.firstChild.style.width = "5px", e.shrinkWrapBlocks = 3 !== u.offsetWidth, e.inlineBlockNeedsLayout && (r.style.zoom = 1)), r.removeChild(i), i = u = s = n = null)
            }), i = o = r = a = n = s = null, e
        }({});
        var Tt = /(?:\{[\s\S]*\}|\[[\s\S]*\])$/,
            $t = /([A-Z])/g;
        ht.extend({
            cache: {},
            noData: {
                applet: !0,
                embed: !0,
                object: "clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
            },
            hasData: function(t) {
                return !!(t = t.nodeType ? ht.cache[t[ht.expando]] : t[ht.expando]) && !a(t)
            },
            data: function(t, e, i) {
                return s(t, e, i)
            },
            removeData: function(t, e) {
                return o(t, e)
            },
            _data: function(t, e, i) {
                return s(t, e, i, !0)
            },
            _removeData: function(t, e) {
                return o(t, e, !0)
            },
            acceptData: function(t) {
                if (t.nodeType && 1 !== t.nodeType && 9 !== t.nodeType) return !1;
                var e = t.nodeName && ht.noData[t.nodeName.toLowerCase()];
                return !e || !0 !== e && t.getAttribute("classid") === e
            }
        }), ht.fn.extend({
            data: function(t, i) {
                var n, s, o = null,
                    a = 0,
                    l = this[0];
                if (t === e) {
                    if (this.length && (o = ht.data(l), 1 === l.nodeType && !ht._data(l, "parsedAttrs"))) {
                        for (n = l.attributes; a < n.length; a++) s = n[a].name, 0 === s.indexOf("data-") && (s = ht.camelCase(s.slice(5)), r(l, s, o[s]));
                        ht._data(l, "parsedAttrs", !0)
                    }
                    return o
                }
                return "object" == typeof t ? this.each(function() {
                    ht.data(this, t)
                }) : arguments.length > 1 ? this.each(function() {
                    ht.data(this, t, i)
                }) : l ? r(l, t, ht.data(l, t)) : null
            },
            removeData: function(t) {
                return this.each(function() {
                    ht.removeData(this, t)
                })
            }
        }), ht.extend({
            queue: function(t, e, i) {
                var n;
                if (t) return e = (e || "fx") + "queue", n = ht._data(t, e), i && (!n || ht.isArray(i) ? n = ht._data(t, e, ht.makeArray(i)) : n.push(i)), n || []
            },
            dequeue: function(t, e) {
                e = e || "fx";
                var i = ht.queue(t, e),
                    n = i.length,
                    s = i.shift(),
                    o = ht._queueHooks(t, e),
                    r = function() {
                        ht.dequeue(t, e)
                    };
                "inprogress" === s && (s = i.shift(), n--), s && ("fx" === e && i.unshift("inprogress"), delete o.stop, s.call(t, r, o)), !n && o && o.empty.fire()
            },
            _queueHooks: function(t, e) {
                var i = e + "queueHooks";
                return ht._data(t, i) || ht._data(t, i, {
                    empty: ht.Callbacks("once memory").add(function() {
                        ht._removeData(t, e + "queue"), ht._removeData(t, i)
                    })
                })
            }
        }), ht.fn.extend({
            queue: function(t, i) {
                var n = 2;
                return "string" != typeof t && (i = t, t = "fx", n--), arguments.length < n ? ht.queue(this[0], t) : i === e ? this : this.each(function() {
                    var e = ht.queue(this, t, i);
                    ht._queueHooks(this, t), "fx" === t && "inprogress" !== e[0] && ht.dequeue(this, t)
                })
            },
            dequeue: function(t) {
                return this.each(function() {
                    ht.dequeue(this, t)
                })
            },
            delay: function(t, e) {
                return t = ht.fx ? ht.fx.speeds[t] || t : t, e = e || "fx", this.queue(e, function(e, i) {
                    var n = setTimeout(e, t);
                    i.stop = function() {
                        clearTimeout(n)
                    }
                })
            },
            clearQueue: function(t) {
                return this.queue(t || "fx", [])
            },
            promise: function(t, i) {
                var n, s = 1,
                    o = ht.Deferred(),
                    r = this,
                    a = this.length,
                    l = function() {
                        --s || o.resolveWith(r, [r])
                    };
                for ("string" != typeof t && (i = t, t = e), t = t || "fx"; a--;)(n = ht._data(r[a], t + "queueHooks")) && n.empty && (s++, n.empty.add(l));
                return l(), o.promise(i)
            }
        });
        var Dt, St, At = /[\t\r\n\f]/g,
            Et = /\r/g,
            It = /^(?:input|select|textarea|button|object)$/i,
            Pt = /^(?:a|area)$/i,
            Nt = /^(?:checked|selected)$/i,
            Mt = ht.support.getSetAttribute,
            Ot = ht.support.input;
        ht.fn.extend({
            attr: function(t, e) {
                return ht.access(this, ht.attr, t, e, arguments.length > 1)
            },
            removeAttr: function(t) {
                return this.each(function() {
                    ht.removeAttr(this, t)
                })
            },
            prop: function(t, e) {
                return ht.access(this, ht.prop, t, e, arguments.length > 1)
            },
            removeProp: function(t) {
                return t = ht.propFix[t] || t, this.each(function() {
                    try {
                        this[t] = e, delete this[t]
                    } catch (t) {}
                })
            },
            addClass: function(t) {
                var e, i, n, s, o, r = 0,
                    a = this.length,
                    l = "string" == typeof t && t;
                if (ht.isFunction(t)) return this.each(function(e) {
                    ht(this).addClass(t.call(this, e, this.className))
                });
                if (l)
                    for (e = (t || "").match(ut) || []; r < a; r++)
                        if (i = this[r], n = 1 === i.nodeType && (i.className ? (" " + i.className + " ").replace(At, " ") : " ")) {
                            for (o = 0; s = e[o++];) n.indexOf(" " + s + " ") < 0 && (n += s + " ");
                            i.className = ht.trim(n)
                        } return this
            },
            removeClass: function(t) {
                var e, i, n, s, o, r = 0,
                    a = this.length,
                    l = 0 === arguments.length || "string" == typeof t && t;
                if (ht.isFunction(t)) return this.each(function(e) {
                    ht(this).removeClass(t.call(this, e, this.className))
                });
                if (l)
                    for (e = (t || "").match(ut) || []; r < a; r++)
                        if (i = this[r], n = 1 === i.nodeType && (i.className ? (" " + i.className + " ").replace(At, " ") : "")) {
                            for (o = 0; s = e[o++];)
                                for (; n.indexOf(" " + s + " ") >= 0;) n = n.replace(" " + s + " ", " ");
                            i.className = t ? ht.trim(n) : ""
                        } return this
            },
            toggleClass: function(t, e) {
                var i = typeof t;
                return "boolean" == typeof e && "string" === i ? e ? this.addClass(t) : this.removeClass(t) : ht.isFunction(t) ? this.each(function(i) {
                    ht(this).toggleClass(t.call(this, i, this.className, e), e)
                }) : this.each(function() {
                    if ("string" === i)
                        for (var e, n = 0, s = ht(this), o = t.match(ut) || []; e = o[n++];) s.hasClass(e) ? s.removeClass(e) : s.addClass(e);
                    else i !== Q && "boolean" !== i || (this.className && ht._data(this, "__className__", this.className), this.className = this.className || !1 === t ? "" : ht._data(this, "__className__") || "")
                })
            },
            hasClass: function(t) {
                for (var e = " " + t + " ", i = 0, n = this.length; i < n; i++)
                    if (1 === this[i].nodeType && (" " + this[i].className + " ").replace(At, " ").indexOf(e) >= 0) return !0;
                return !1
            },
            val: function(t) {
                var i, n, s, o = this[0]; {
                    if (arguments.length) return s = ht.isFunction(t), this.each(function(i) {
                        var o;
                        1 === this.nodeType && (o = s ? t.call(this, i, ht(this).val()) : t, null == o ? o = "" : "number" == typeof o ? o += "" : ht.isArray(o) && (o = ht.map(o, function(t) {
                            return null == t ? "" : t + ""
                        })), (n = ht.valHooks[this.type] || ht.valHooks[this.nodeName.toLowerCase()]) && "set" in n && n.set(this, o, "value") !== e || (this.value = o))
                    });
                    if (o) return (n = ht.valHooks[o.type] || ht.valHooks[o.nodeName.toLowerCase()]) && "get" in n && (i = n.get(o, "value")) !== e ? i : (i = o.value, "string" == typeof i ? i.replace(Et, "") : null == i ? "" : i)
                }
            }
        }), ht.extend({
            valHooks: {
                option: {
                    get: function(t) {
                        var e = ht.find.attr(t, "value");
                        return null != e ? e : t.text
                    }
                },
                select: {
                    get: function(t) {
                        for (var e, i, n = t.options, s = t.selectedIndex, o = "select-one" === t.type || s < 0, r = o ? null : [], a = o ? s + 1 : n.length, l = s < 0 ? a : o ? s : 0; l < a; l++)
                            if (i = n[l], (i.selected || l === s) && (ht.support.optDisabled ? !i.disabled : null === i.getAttribute("disabled")) && (!i.parentNode.disabled || !ht.nodeName(i.parentNode, "optgroup"))) {
                                if (e = ht(i).val(), o) return e;
                                r.push(e)
                            } return r
                    },
                    set: function(t, e) {
                        for (var i, n, s = t.options, o = ht.makeArray(e), r = s.length; r--;) n = s[r], (n.selected = ht.inArray(ht(n).val(), o) >= 0) && (i = !0);
                        return i || (t.selectedIndex = -1), o
                    }
                }
            },
            attr: function(t, i, n) {
                var s, o, r = t.nodeType;
                if (t && 3 !== r && 8 !== r && 2 !== r) return typeof t.getAttribute === Q ? ht.prop(t, i, n) : (1 === r && ht.isXMLDoc(t) || (i = i.toLowerCase(), s = ht.attrHooks[i] || (ht.expr.match.bool.test(i) ? St : Dt)), n === e ? s && "get" in s && null !== (o = s.get(t, i)) ? o : (o = ht.find.attr(t, i), null == o ? e : o) : null !== n ? s && "set" in s && (o = s.set(t, n, i)) !== e ? o : (t.setAttribute(i, n + ""), n) : void ht.removeAttr(t, i))
            },
            removeAttr: function(t, e) {
                var i, n, s = 0,
                    o = e && e.match(ut);
                if (o && 1 === t.nodeType)
                    for (; i = o[s++];) n = ht.propFix[i] || i, ht.expr.match.bool.test(i) ? Ot && Mt || !Nt.test(i) ? t[n] = !1 : t[ht.camelCase("default-" + i)] = t[n] = !1 : ht.attr(t, i, ""), t.removeAttribute(Mt ? i : n)
            },
            attrHooks: {
                type: {
                    set: function(t, e) {
                        if (!ht.support.radioValue && "radio" === e && ht.nodeName(t, "input")) {
                            var i = t.value;
                            return t.setAttribute("type", e), i && (t.value = i), e
                        }
                    }
                }
            },
            propFix: {
                for: "htmlFor",
                class: "className"
            },
            prop: function(t, i, n) {
                var s, o, r, a = t.nodeType;
                if (t && 3 !== a && 8 !== a && 2 !== a) return r = 1 !== a || !ht.isXMLDoc(t), r && (i = ht.propFix[i] || i, o = ht.propHooks[i]), n !== e ? o && "set" in o && (s = o.set(t, n, i)) !== e ? s : t[i] = n : o && "get" in o && null !== (s = o.get(t, i)) ? s : t[i]
            },
            propHooks: {
                tabIndex: {
                    get: function(t) {
                        var e = ht.find.attr(t, "tabindex");
                        return e ? parseInt(e, 10) : It.test(t.nodeName) || Pt.test(t.nodeName) && t.href ? 0 : -1
                    }
                }
            }
        }), St = {
            set: function(t, e, i) {
                return !1 === e ? ht.removeAttr(t, i) : Ot && Mt || !Nt.test(i) ? t.setAttribute(!Mt && ht.propFix[i] || i, i) : t[ht.camelCase("default-" + i)] = t[i] = !0, i
            }
        }, ht.each(ht.expr.match.bool.source.match(/\w+/g), function(t, i) {
            var n = ht.expr.attrHandle[i] || ht.find.attr;
            ht.expr.attrHandle[i] = Ot && Mt || !Nt.test(i) ? function(t, i, s) {
                var o = ht.expr.attrHandle[i],
                    r = s ? e : (ht.expr.attrHandle[i] = e) != n(t, i, s) ? i.toLowerCase() : null;
                return ht.expr.attrHandle[i] = o, r
            } : function(t, i, n) {
                return n ? e : t[ht.camelCase("default-" + i)] ? i.toLowerCase() : null
            }
        }), Ot && Mt || (ht.attrHooks.value = {
            set: function(t, e, i) {
                if (!ht.nodeName(t, "input")) return Dt && Dt.set(t, e, i);
                t.defaultValue = e
            }
        }), Mt || (Dt = {
            set: function(t, i, n) {
                var s = t.getAttributeNode(n);
                return s || t.setAttributeNode(s = t.ownerDocument.createAttribute(n)), s.value = i += "", "value" === n || i === t.getAttribute(n) ? i : e
            }
        }, ht.expr.attrHandle.id = ht.expr.attrHandle.name = ht.expr.attrHandle.coords = function(t, i, n) {
            var s;
            return n ? e : (s = t.getAttributeNode(i)) && "" !== s.value ? s.value : null
        }, ht.valHooks.button = {
            get: function(t, i) {
                var n = t.getAttributeNode(i);
                return n && n.specified ? n.value : e
            },
            set: Dt.set
        }, ht.attrHooks.contenteditable = {
            set: function(t, e, i) {
                Dt.set(t, "" !== e && e, i)
            }
        }, ht.each(["width", "height"], function(t, e) {
            ht.attrHooks[e] = {
                set: function(t, i) {
                    if ("" === i) return t.setAttribute(e, "auto"), i
                }
            }
        })), ht.support.hrefNormalized || ht.each(["href", "src"], function(t, e) {
            ht.propHooks[e] = {
                get: function(t) {
                    return t.getAttribute(e, 4)
                }
            }
        }), ht.support.style || (ht.attrHooks.style = {
            get: function(t) {
                return t.style.cssText || e
            },
            set: function(t, e) {
                return t.style.cssText = e + ""
            }
        }), ht.support.optSelected || (ht.propHooks.selected = {
            get: function(t) {
                var e = t.parentNode;
                return e && (e.selectedIndex, e.parentNode && e.parentNode.selectedIndex), null
            }
        }), ht.each(["tabIndex", "readOnly", "maxLength", "cellSpacing", "cellPadding", "rowSpan", "colSpan", "useMap", "frameBorder", "contentEditable"], function() {
            ht.propFix[this.toLowerCase()] = this
        }), ht.support.enctype || (ht.propFix.enctype = "encoding"), ht.each(["radio", "checkbox"], function() {
            ht.valHooks[this] = {
                set: function(t, e) {
                    if (ht.isArray(e)) return t.checked = ht.inArray(ht(t).val(), e) >= 0
                }
            }, ht.support.checkOn || (ht.valHooks[this].get = function(t) {
                return null === t.getAttribute("value") ? "on" : t.value
            })
        });
        var Ht = /^(?:input|select|textarea)$/i,
            jt = /^key/,
            zt = /^(?:mouse|contextmenu)|click/,
            Lt = /^(?:focusinfocus|focusoutblur)$/,
            Rt = /^([^.]*)(?:\.(.+)|)$/;
        ht.event = {
            global: {},
            add: function(t, i, n, s, o) {
                var r, a, l, h, c, u, d, p, f, g, m, v = ht._data(t);
                if (v) {
                    for (n.handler && (h = n, n = h.handler, o = h.selector), n.guid || (n.guid = ht.guid++), (a = v.events) || (a = v.events = {}), (u = v.handle) || (u = v.handle = function(t) {
                            return typeof ht === Q || t && ht.event.triggered === t.type ? e : ht.event.dispatch.apply(u.elem, arguments)
                        }, u.elem = t), i = (i || "").match(ut) || [""], l = i.length; l--;) r = Rt.exec(i[l]) || [], f = m = r[1], g = (r[2] || "").split(".").sort(), f && (c = ht.event.special[f] || {}, f = (o ? c.delegateType : c.bindType) || f, c = ht.event.special[f] || {}, d = ht.extend({
                        type: f,
                        origType: m,
                        data: s,
                        handler: n,
                        guid: n.guid,
                        selector: o,
                        needsContext: o && ht.expr.match.needsContext.test(o),
                        namespace: g.join(".")
                    }, h), (p = a[f]) || (p = a[f] = [], p.delegateCount = 0, c.setup && !1 !== c.setup.call(t, s, g, u) || (t.addEventListener ? t.addEventListener(f, u, !1) : t.attachEvent && t.attachEvent("on" + f, u))), c.add && (c.add.call(t, d), d.handler.guid || (d.handler.guid = n.guid)), o ? p.splice(p.delegateCount++, 0, d) : p.push(d), ht.event.global[f] = !0);
                    t = null
                }
            },
            remove: function(t, e, i, n, s) {
                var o, r, a, l, h, c, u, d, p, f, g, m = ht.hasData(t) && ht._data(t);
                if (m && (c = m.events)) {
                    for (e = (e || "").match(ut) || [""], h = e.length; h--;)
                        if (a = Rt.exec(e[h]) || [], p = g = a[1], f = (a[2] || "").split(".").sort(), p) {
                            for (u = ht.event.special[p] || {}, p = (n ? u.delegateType : u.bindType) || p, d = c[p] || [], a = a[2] && new RegExp("(^|\\.)" + f.join("\\.(?:.*\\.|)") + "(\\.|$)"), l = o = d.length; o--;) r = d[o], !s && g !== r.origType || i && i.guid !== r.guid || a && !a.test(r.namespace) || n && n !== r.selector && ("**" !== n || !r.selector) || (d.splice(o, 1), r.selector && d.delegateCount--, u.remove && u.remove.call(t, r));
                            l && !d.length && (u.teardown && !1 !== u.teardown.call(t, f, m.handle) || ht.removeEvent(t, p, m.handle), delete c[p])
                        } else
                            for (p in c) ht.event.remove(t, p + e[h], i, n, !0);
                    ht.isEmptyObject(c) && (delete m.handle, ht._removeData(t, "events"))
                }
            },
            trigger: function(i, n, s, o) {
                var r, a, l, h, c, u, d, p = [s || X],
                    f = at.call(i, "type") ? i.type : i,
                    g = at.call(i, "namespace") ? i.namespace.split(".") : [];
                if (l = u = s = s || X, 3 !== s.nodeType && 8 !== s.nodeType && !Lt.test(f + ht.event.triggered) && (f.indexOf(".") >= 0 && (g = f.split("."), f = g.shift(), g.sort()), a = f.indexOf(":") < 0 && "on" + f, i = i[ht.expando] ? i : new ht.Event(f, "object" == typeof i && i), i.isTrigger = o ? 2 : 3, i.namespace = g.join("."), i.namespace_re = i.namespace ? new RegExp("(^|\\.)" + g.join("\\.(?:.*\\.|)") + "(\\.|$)") : null, i.result = e, i.target || (i.target = s), n = null == n ? [i] : ht.makeArray(n, [i]), c = ht.event.special[f] || {}, o || !c.trigger || !1 !== c.trigger.apply(s, n))) {
                    if (!o && !c.noBubble && !ht.isWindow(s)) {
                        for (h = c.delegateType || f, Lt.test(h + f) || (l = l.parentNode); l; l = l.parentNode) p.push(l), u = l;
                        u === (s.ownerDocument || X) && p.push(u.defaultView || u.parentWindow || t)
                    }
                    for (d = 0;
                        (l = p[d++]) && !i.isPropagationStopped();) i.type = d > 1 ? h : c.bindType || f, r = (ht._data(l, "events") || {})[i.type] && ht._data(l, "handle"), r && r.apply(l, n), (r = a && l[a]) && ht.acceptData(l) && r.apply && !1 === r.apply(l, n) && i.preventDefault();
                    if (i.type = f, !o && !i.isDefaultPrevented() && (!c._default || !1 === c._default.apply(p.pop(), n)) && ht.acceptData(s) && a && s[f] && !ht.isWindow(s)) {
                        u = s[a], u && (s[a] = null), ht.event.triggered = f;
                        try {
                            s[f]()
                        } catch (t) {}
                        ht.event.triggered = e, u && (s[a] = u)
                    }
                    return i.result
                }
            },
            dispatch: function(t) {
                t = ht.event.fix(t);
                var i, n, s, o, r, a = [],
                    l = st.call(arguments),
                    h = (ht._data(this, "events") || {})[t.type] || [],
                    c = ht.event.special[t.type] || {};
                if (l[0] = t, t.delegateTarget = this, !c.preDispatch || !1 !== c.preDispatch.call(this, t)) {
                    for (a = ht.event.handlers.call(this, t, h), i = 0;
                        (o = a[i++]) && !t.isPropagationStopped();)
                        for (t.currentTarget = o.elem, r = 0;
                            (s = o.handlers[r++]) && !t.isImmediatePropagationStopped();) t.namespace_re && !t.namespace_re.test(s.namespace) || (t.handleObj = s, t.data = s.data, (n = ((ht.event.special[s.origType] || {}).handle || s.handler).apply(o.elem, l)) !== e && !1 === (t.result = n) && (t.preventDefault(), t.stopPropagation()));
                    return c.postDispatch && c.postDispatch.call(this, t), t.result
                }
            },
            handlers: function(t, i) {
                var n, s, o, r, a = [],
                    l = i.delegateCount,
                    h = t.target;
                if (l && h.nodeType && (!t.button || "click" !== t.type))
                    for (; h != this; h = h.parentNode || this)
                        if (1 === h.nodeType && (!0 !== h.disabled || "click" !== t.type)) {
                            for (o = [], r = 0; r < l; r++) s = i[r], n = s.selector + " ", o[n] === e && (o[n] = s.needsContext ? ht(n, this).index(h) >= 0 : ht.find(n, this, null, [h]).length), o[n] && o.push(s);
                            o.length && a.push({
                                elem: h,
                                handlers: o
                            })
                        } return l < i.length && a.push({
                    elem: this,
                    handlers: i.slice(l)
                }), a
            },
            fix: function(t) {
                if (t[ht.expando]) return t;
                var e, i, n, s = t.type,
                    o = t,
                    r = this.fixHooks[s];
                for (r || (this.fixHooks[s] = r = zt.test(s) ? this.mouseHooks : jt.test(s) ? this.keyHooks : {}), n = r.props ? this.props.concat(r.props) : this.props, t = new ht.Event(o), e = n.length; e--;) i = n[e], t[i] = o[i];
                return t.target || (t.target = o.srcElement || X), 3 === t.target.nodeType && (t.target = t.target.parentNode), t.metaKey = !!t.metaKey, r.filter ? r.filter(t, o) : t
            },
            props: "altKey bubbles cancelable ctrlKey currentTarget eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "),
            fixHooks: {},
            keyHooks: {
                props: "char charCode key keyCode".split(" "),
                filter: function(t, e) {
                    return null == t.which && (t.which = null != e.charCode ? e.charCode : e.keyCode), t
                }
            },
            mouseHooks: {
                props: "button buttons clientX clientY fromElement offsetX offsetY pageX pageY screenX screenY toElement".split(" "),
                filter: function(t, i) {
                    var n, s, o, r = i.button,
                        a = i.fromElement;
                    return null == t.pageX && null != i.clientX && (s = t.target.ownerDocument || X, o = s.documentElement, n = s.body, t.pageX = i.clientX + (o && o.scrollLeft || n && n.scrollLeft || 0) - (o && o.clientLeft || n && n.clientLeft || 0), t.pageY = i.clientY + (o && o.scrollTop || n && n.scrollTop || 0) - (o && o.clientTop || n && n.clientTop || 0)), !t.relatedTarget && a && (t.relatedTarget = a === t.target ? i.toElement : a), t.which || r === e || (t.which = 1 & r ? 1 : 2 & r ? 3 : 4 & r ? 2 : 0), t
                }
            },
            special: {
                load: {
                    noBubble: !0
                },
                focus: {
                    trigger: function() {
                        if (this !== c() && this.focus) try {
                            return this.focus(), !1
                        } catch (t) {}
                    },
                    delegateType: "focusin"
                },
                blur: {
                    trigger: function() {
                        if (this === c() && this.blur) return this.blur(), !1
                    },
                    delegateType: "focusout"
                },
                click: {
                    trigger: function() {
                        if (ht.nodeName(this, "input") && "checkbox" === this.type && this.click) return this.click(), !1
                    },
                    _default: function(t) {
                        return ht.nodeName(t.target, "a")
                    }
                },
                beforeunload: {
                    postDispatch: function(t) {
                        t.result !== e && (t.originalEvent.returnValue = t.result)
                    }
                }
            },
            simulate: function(t, e, i, n) {
                var s = ht.extend(new ht.Event, i, {
                    type: t,
                    isSimulated: !0,
                    originalEvent: {}
                });
                n ? ht.event.trigger(s, null, e) : ht.event.dispatch.call(e, s), s.isDefaultPrevented() && i.preventDefault()
            }
        }, ht.removeEvent = X.removeEventListener ? function(t, e, i) {
            t.removeEventListener && t.removeEventListener(e, i, !1)
        } : function(t, e, i) {
            var n = "on" + e;
            t.detachEvent && (typeof t[n] === Q && (t[n] = null), t.detachEvent(n, i))
        }, ht.Event = function(t, e) {
            if (!(this instanceof ht.Event)) return new ht.Event(t, e);
            t && t.type ? (this.originalEvent = t, this.type = t.type, this.isDefaultPrevented = t.defaultPrevented || !1 === t.returnValue || t.getPreventDefault && t.getPreventDefault() ? l : h) : this.type = t, e && ht.extend(this, e), this.timeStamp = t && t.timeStamp || ht.now(), this[ht.expando] = !0
        }, ht.Event.prototype = {
            isDefaultPrevented: h,
            isPropagationStopped: h,
            isImmediatePropagationStopped: h,
            preventDefault: function() {
                var t = this.originalEvent;
                this.isDefaultPrevented = l, t && (t.preventDefault ? t.preventDefault() : t.returnValue = !1)
            },
            stopPropagation: function() {
                var t = this.originalEvent;
                this.isPropagationStopped = l, t && (t.stopPropagation && t.stopPropagation(), t.cancelBubble = !0)
            },
            stopImmediatePropagation: function() {
                this.isImmediatePropagationStopped = l, this.stopPropagation()
            }
        }, ht.each({
            mouseenter: "mouseover",
            mouseleave: "mouseout"
        }, function(t, e) {
            ht.event.special[t] = {
                delegateType: e,
                bindType: e,
                handle: function(t) {
                    var i, n = this,
                        s = t.relatedTarget,
                        o = t.handleObj;
                    return s && (s === n || ht.contains(n, s)) || (t.type = o.origType, i = o.handler.apply(this, arguments), t.type = e), i
                }
            }
        }), ht.support.submitBubbles || (ht.event.special.submit = {
            setup: function() {
                if (ht.nodeName(this, "form")) return !1;
                ht.event.add(this, "click._submit keypress._submit", function(t) {
                    var i = t.target,
                        n = ht.nodeName(i, "input") || ht.nodeName(i, "button") ? i.form : e;
                    n && !ht._data(n, "submitBubbles") && (ht.event.add(n, "submit._submit", function(t) {
                        t._submit_bubble = !0
                    }), ht._data(n, "submitBubbles", !0))
                })
            },
            postDispatch: function(t) {
                t._submit_bubble && (delete t._submit_bubble, this.parentNode && !t.isTrigger && ht.event.simulate("submit", this.parentNode, t, !0))
            },
            teardown: function() {
                if (ht.nodeName(this, "form")) return !1;
                ht.event.remove(this, "._submit")
            }
        }), ht.support.changeBubbles || (ht.event.special.change = {
            setup: function() {
                if (Ht.test(this.nodeName)) return "checkbox" !== this.type && "radio" !== this.type || (ht.event.add(this, "propertychange._change", function(t) {
                    "checked" === t.originalEvent.propertyName && (this._just_changed = !0)
                }), ht.event.add(this, "click._change", function(t) {
                    this._just_changed && !t.isTrigger && (this._just_changed = !1), ht.event.simulate("change", this, t, !0)
                })), !1;
                ht.event.add(this, "beforeactivate._change", function(t) {
                    var e = t.target;
                    Ht.test(e.nodeName) && !ht._data(e, "changeBubbles") && (ht.event.add(e, "change._change", function(t) {
                        !this.parentNode || t.isSimulated || t.isTrigger || ht.event.simulate("change", this.parentNode, t, !0)
                    }), ht._data(e, "changeBubbles", !0))
                })
            },
            handle: function(t) {
                var e = t.target;
                if (this !== e || t.isSimulated || t.isTrigger || "radio" !== e.type && "checkbox" !== e.type) return t.handleObj.handler.apply(this, arguments)
            },
            teardown: function() {
                return ht.event.remove(this, "._change"), !Ht.test(this.nodeName)
            }
        }), ht.support.focusinBubbles || ht.each({
            focus: "focusin",
            blur: "focusout"
        }, function(t, e) {
            var i = 0,
                n = function(t) {
                    ht.event.simulate(e, t.target, ht.event.fix(t), !0)
                };
            ht.event.special[e] = {
                setup: function() {
                    0 == i++ && X.addEventListener(t, n, !0)
                },
                teardown: function() {
                    0 == --i && X.removeEventListener(t, n, !0)
                }
            }
        }), ht.fn.extend({
            on: function(t, i, n, s, o) {
                var r, a;
                if ("object" == typeof t) {
                    "string" != typeof i && (n = n || i, i = e);
                    for (r in t) this.on(r, i, n, t[r], o);
                    return this
                }
                if (null == n && null == s ? (s = i, n = i = e) : null == s && ("string" == typeof i ? (s = n, n = e) : (s = n, n = i, i = e)), !1 === s) s = h;
                else if (!s) return this;
                return 1 === o && (a = s, s = function(t) {
                    return ht().off(t), a.apply(this, arguments)
                }, s.guid = a.guid || (a.guid = ht.guid++)), this.each(function() {
                    ht.event.add(this, t, s, n, i)
                })
            },
            one: function(t, e, i, n) {
                return this.on(t, e, i, n, 1)
            },
            off: function(t, i, n) {
                var s, o;
                if (t && t.preventDefault && t.handleObj) return s = t.handleObj, ht(t.delegateTarget).off(s.namespace ? s.origType + "." + s.namespace : s.origType, s.selector, s.handler), this;
                if ("object" == typeof t) {
                    for (o in t) this.off(o, i, t[o]);
                    return this
                }
                return !1 !== i && "function" != typeof i || (n = i, i = e), !1 === n && (n = h), this.each(function() {
                    ht.event.remove(this, t, n, i)
                })
            },
            trigger: function(t, e) {
                return this.each(function() {
                    ht.event.trigger(t, e, this)
                })
            },
            triggerHandler: function(t, e) {
                var i = this[0];
                if (i) return ht.event.trigger(t, e, i, !0)
            }
        });
        var Wt = /^.[^:#\[\.,]*$/,
            Ft = /^(?:parents|prev(?:Until|All))/,
            qt = ht.expr.match.needsContext,
            Bt = {
                children: !0,
                contents: !0,
                next: !0,
                prev: !0
            };
        ht.fn.extend({
            find: function(t) {
                var e, i = [],
                    n = this,
                    s = n.length;
                if ("string" != typeof t) return this.pushStack(ht(t).filter(function() {
                    for (e = 0; e < s; e++)
                        if (ht.contains(n[e], this)) return !0
                }));
                for (e = 0; e < s; e++) ht.find(t, n[e], i);
                return i = this.pushStack(s > 1 ? ht.unique(i) : i), i.selector = this.selector ? this.selector + " " + t : t, i
            },
            has: function(t) {
                var e, i = ht(t, this),
                    n = i.length;
                return this.filter(function() {
                    for (e = 0; e < n; e++)
                        if (ht.contains(this, i[e])) return !0
                })
            },
            not: function(t) {
                return this.pushStack(d(this, t || [], !0))
            },
            filter: function(t) {
                return this.pushStack(d(this, t || [], !1))
            },
            is: function(t) {
                return !!d(this, "string" == typeof t && qt.test(t) ? ht(t) : t || [], !1).length
            },
            closest: function(t, e) {
                for (var i, n = 0, s = this.length, o = [], r = qt.test(t) || "string" != typeof t ? ht(t, e || this.context) : 0; n < s; n++)
                    for (i = this[n]; i && i !== e; i = i.parentNode)
                        if (i.nodeType < 11 && (r ? r.index(i) > -1 : 1 === i.nodeType && ht.find.matchesSelector(i, t))) {
                            i = o.push(i);
                            break
                        } return this.pushStack(o.length > 1 ? ht.unique(o) : o)
            },
            index: function(t) {
                return t ? "string" == typeof t ? ht.inArray(this[0], ht(t)) : ht.inArray(t.jquery ? t[0] : t, this) : this[0] && this[0].parentNode ? this.first().prevAll().length : -1
            },
            add: function(t, e) {
                var i = "string" == typeof t ? ht(t, e) : ht.makeArray(t && t.nodeType ? [t] : t),
                    n = ht.merge(this.get(), i);
                return this.pushStack(ht.unique(n))
            },
            addBack: function(t) {
                return this.add(null == t ? this.prevObject : this.prevObject.filter(t))
            }
        }), ht.each({
            parent: function(t) {
                var e = t.parentNode;
                return e && 11 !== e.nodeType ? e : null
            },
            parents: function(t) {
                return ht.dir(t, "parentNode")
            },
            parentsUntil: function(t, e, i) {
                return ht.dir(t, "parentNode", i)
            },
            next: function(t) {
                return u(t, "nextSibling")
            },
            prev: function(t) {
                return u(t, "previousSibling")
            },
            nextAll: function(t) {
                return ht.dir(t, "nextSibling")
            },
            prevAll: function(t) {
                return ht.dir(t, "previousSibling")
            },
            nextUntil: function(t, e, i) {
                return ht.dir(t, "nextSibling", i)
            },
            prevUntil: function(t, e, i) {
                return ht.dir(t, "previousSibling", i)
            },
            siblings: function(t) {
                return ht.sibling((t.parentNode || {}).firstChild, t)
            },
            children: function(t) {
                return ht.sibling(t.firstChild)
            },
            contents: function(t) {
                return ht.nodeName(t, "iframe") ? t.contentDocument || t.contentWindow.document : ht.merge([], t.childNodes)
            }
        }, function(t, e) {
            ht.fn[t] = function(i, n) {
                var s = ht.map(this, e, i);
                return "Until" !== t.slice(-5) && (n = i), n && "string" == typeof n && (s = ht.filter(n, s)), this.length > 1 && (Bt[t] || (s = ht.unique(s)), Ft.test(t) && (s = s.reverse())), this.pushStack(s)
            }
        }), ht.extend({
            filter: function(t, e, i) {
                var n = e[0];
                return i && (t = ":not(" + t + ")"), 1 === e.length && 1 === n.nodeType ? ht.find.matchesSelector(n, t) ? [n] : [] : ht.find.matches(t, ht.grep(e, function(t) {
                    return 1 === t.nodeType
                }))
            },
            dir: function(t, i, n) {
                for (var s = [], o = t[i]; o && 9 !== o.nodeType && (n === e || 1 !== o.nodeType || !ht(o).is(n));) 1 === o.nodeType && s.push(o), o = o[i];
                return s
            },
            sibling: function(t, e) {
                for (var i = []; t; t = t.nextSibling) 1 === t.nodeType && t !== e && i.push(t);
                return i
            }
        });
        var Ut = "abbr|article|aside|audio|bdi|canvas|data|datalist|details|figcaption|figure|footer|header|hgroup|mark|meter|nav|output|progress|section|summary|time|video",
            Yt = / jQuery\d+="(?:null|\d+)"/g,
            Vt = new RegExp("<(?:" + Ut + ")[\\s/>]", "i"),
            Qt = /^\s+/,
            Kt = /<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:]+)[^>]*)\/>/gi,
            Xt = /<([\w:]+)/,
            Gt = /<tbody/i,
            Zt = /<|&#?\w+;/,
            Jt = /<(?:script|style|link)/i,
            te = /^(?:checkbox|radio)$/i,
            ee = /checked\s*(?:[^=]|=\s*.checked.)/i,
            ie = /^$|\/(?:java|ecma)script/i,
            ne = /^true\/(.*)/,
            se = /^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g,
            oe = {
                option: [1, "<select multiple='multiple'>", "</select>"],
                legend: [1, "<fieldset>", "</fieldset>"],
                area: [1, "<map>", "</map>"],
                param: [1, "<object>", "</object>"],
                thead: [1, "<table>", "</table>"],
                tr: [2, "<table><tbody>", "</tbody></table>"],
                col: [2, "<table><tbody></tbody><colgroup>", "</colgroup></table>"],
                td: [3, "<table><tbody><tr>", "</tr></tbody></table>"],
                _default: ht.support.htmlSerialize ? [0, "", ""] : [1, "X<div>", "</div>"]
            },
            re = p(X),
            ae = re.appendChild(X.createElement("div"));
        oe.optgroup = oe.option, oe.tbody = oe.tfoot = oe.colgroup = oe.caption = oe.thead, oe.th = oe.td, ht.fn.extend({
            text: function(t) {
                return ht.access(this, function(t) {
                    return t === e ? ht.text(this) : this.empty().append((this[0] && this[0].ownerDocument || X).createTextNode(t))
                }, null, t, arguments.length)
            },
            append: function() {
                return this.domManip(arguments, function(t) {
                    if (1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) {
                        f(this, t).appendChild(t)
                    }
                })
            },
            prepend: function() {
                return this.domManip(arguments, function(t) {
                    if (1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) {
                        var e = f(this, t);
                        e.insertBefore(t, e.firstChild)
                    }
                })
            },
            before: function() {
                return this.domManip(arguments, function(t) {
                    this.parentNode && this.parentNode.insertBefore(t, this)
                })
            },
            after: function() {
                return this.domManip(arguments, function(t) {
                    this.parentNode && this.parentNode.insertBefore(t, this.nextSibling)
                })
            },
            remove: function(t, e) {
                for (var i, n = t ? ht.filter(t, this) : this, s = 0; null != (i = n[s]); s++) e || 1 !== i.nodeType || ht.cleanData(_(i)), i.parentNode && (e && ht.contains(i.ownerDocument, i) && v(_(i, "script")), i.parentNode.removeChild(i));
                return this
            },
            empty: function() {
                for (var t, e = 0; null != (t = this[e]); e++) {
                    for (1 === t.nodeType && ht.cleanData(_(t, !1)); t.firstChild;) t.removeChild(t.firstChild);
                    t.options && ht.nodeName(t, "select") && (t.options.length = 0)
                }
                return this
            },
            clone: function(t, e) {
                return t = null != t && t, e = null == e ? t : e, this.map(function() {
                    return ht.clone(this, t, e)
                })
            },
            html: function(t) {
                return ht.access(this, function(t) {
                    var i = this[0] || {},
                        n = 0,
                        s = this.length;
                    if (t === e) return 1 === i.nodeType ? i.innerHTML.replace(Yt, "") : e;
                    if ("string" == typeof t && !Jt.test(t) && (ht.support.htmlSerialize || !Vt.test(t)) && (ht.support.leadingWhitespace || !Qt.test(t)) && !oe[(Xt.exec(t) || ["", ""])[1].toLowerCase()]) {
                        t = t.replace(Kt, "<$1></$2>");
                        try {
                            for (; n < s; n++) i = this[n] || {}, 1 === i.nodeType && (ht.cleanData(_(i, !1)), i.innerHTML = t);
                            i = 0
                        } catch (t) {}
                    }
                    i && this.empty().append(t)
                }, null, t, arguments.length)
            },
            replaceWith: function() {
                var t = ht.map(this, function(t) {
                        return [t.nextSibling, t.parentNode]
                    }),
                    e = 0;
                return this.domManip(arguments, function(i) {
                    var n = t[e++],
                        s = t[e++];
                    s && (n && n.parentNode !== s && (n = this.nextSibling), ht(this).remove(), s.insertBefore(i, n))
                }, !0), e ? this : this.remove()
            },
            detach: function(t) {
                return this.remove(t, !0)
            },
            domManip: function(t, e, i) {
                t = it.apply([], t);
                var n, s, o, r, a, l, h = 0,
                    c = this.length,
                    u = this,
                    d = c - 1,
                    p = t[0],
                    f = ht.isFunction(p);
                if (f || !(c <= 1 || "string" != typeof p || ht.support.checkClone) && ee.test(p)) return this.each(function(n) {
                    var s = u.eq(n);
                    f && (t[0] = p.call(this, n, s.html())), s.domManip(t, e, i)
                });
                if (c && (l = ht.buildFragment(t, this[0].ownerDocument, !1, !i && this), n = l.firstChild, 1 === l.childNodes.length && (l = n), n)) {
                    for (r = ht.map(_(l, "script"), g), o = r.length; h < c; h++) s = l, h !== d && (s = ht.clone(s, !0, !0), o && ht.merge(r, _(s, "script"))), e.call(this[h], s, h);
                    if (o)
                        for (a = r[r.length - 1].ownerDocument, ht.map(r, m), h = 0; h < o; h++) s = r[h], ie.test(s.type || "") && !ht._data(s, "globalEval") && ht.contains(a, s) && (s.src ? ht._evalUrl(s.src) : ht.globalEval((s.text || s.textContent || s.innerHTML || "").replace(se, "")));
                    l = n = null
                }
                return this
            }
        }), ht.each({
            appendTo: "append",
            prependTo: "prepend",
            insertBefore: "before",
            insertAfter: "after",
            replaceAll: "replaceWith"
        }, function(t, e) {
            ht.fn[t] = function(t) {
                for (var i, n = 0, s = [], o = ht(t), r = o.length - 1; n <= r; n++) i = n === r ? this : this.clone(!0), ht(o[n])[e](i), nt.apply(s, i.get());
                return this.pushStack(s)
            }
        }), ht.extend({
            clone: function(t, e, i) {
                var n, s, o, r, a, l = ht.contains(t.ownerDocument, t);
                if (ht.support.html5Clone || ht.isXMLDoc(t) || !Vt.test("<" + t.nodeName + ">") ? o = t.cloneNode(!0) : (ae.innerHTML = t.outerHTML, ae.removeChild(o = ae.firstChild)), !(ht.support.noCloneEvent && ht.support.noCloneChecked || 1 !== t.nodeType && 11 !== t.nodeType || ht.isXMLDoc(t)))
                    for (n = _(o), a = _(t), r = 0; null != (s = a[r]); ++r) n[r] && b(s, n[r]);
                if (e)
                    if (i)
                        for (a = a || _(t), n = n || _(o), r = 0; null != (s = a[r]); r++) y(s, n[r]);
                    else y(t, o);
                return n = _(o, "script"), n.length > 0 && v(n, !l && _(t, "script")), n = a = s = null, o
            },
            buildFragment: function(t, e, i, n) {
                for (var s, o, r, a, l, h, c, u = t.length, d = p(e), f = [], g = 0; g < u; g++)
                    if ((o = t[g]) || 0 === o)
                        if ("object" === ht.type(o)) ht.merge(f, o.nodeType ? [o] : o);
                        else if (Zt.test(o)) {
                    for (a = a || d.appendChild(e.createElement("div")), l = (Xt.exec(o) || ["", ""])[1].toLowerCase(), c = oe[l] || oe._default, a.innerHTML = c[1] + o.replace(Kt, "<$1></$2>") + c[2], s = c[0]; s--;) a = a.lastChild;
                    if (!ht.support.leadingWhitespace && Qt.test(o) && f.push(e.createTextNode(Qt.exec(o)[0])), !ht.support.tbody)
                        for (o = "table" !== l || Gt.test(o) ? "<table>" !== c[1] || Gt.test(o) ? 0 : a : a.firstChild, s = o && o.childNodes.length; s--;) ht.nodeName(h = o.childNodes[s], "tbody") && !h.childNodes.length && o.removeChild(h);
                    for (ht.merge(f, a.childNodes), a.textContent = ""; a.firstChild;) a.removeChild(a.firstChild);
                    a = d.lastChild
                } else f.push(e.createTextNode(o));
                for (a && d.removeChild(a), ht.support.appendChecked || ht.grep(_(f, "input"), w), g = 0; o = f[g++];)
                    if ((!n || -1 === ht.inArray(o, n)) && (r = ht.contains(o.ownerDocument, o), a = _(d.appendChild(o), "script"), r && v(a), i))
                        for (s = 0; o = a[s++];) ie.test(o.type || "") && i.push(o);
                return a = null, d
            },
            cleanData: function(t, e) {
                for (var i, n, s, o, r = 0, a = ht.expando, l = ht.cache, h = ht.support.deleteExpando, c = ht.event.special; null != (i = t[r]); r++)
                    if ((e || ht.acceptData(i)) && (s = i[a], o = s && l[s])) {
                        if (o.events)
                            for (n in o.events) c[n] ? ht.event.remove(i, n) : ht.removeEvent(i, n, o.handle);
                        l[s] && (delete l[s], h ? delete i[a] : typeof i.removeAttribute !== Q ? i.removeAttribute(a) : i[a] = null, et.push(s))
                    }
            },
            _evalUrl: function(t) {
                return ht.ajax({
                    url: t,
                    type: "GET",
                    dataType: "script",
                    async: !1,
                    global: !1,
                    throws: !0
                })
            }
        }), ht.fn.extend({
            wrapAll: function(t) {
                if (ht.isFunction(t)) return this.each(function(e) {
                    ht(this).wrapAll(t.call(this, e))
                });
                if (this[0]) {
                    var e = ht(t, this[0].ownerDocument).eq(0).clone(!0);
                    this[0].parentNode && e.insertBefore(this[0]), e.map(function() {
                        for (var t = this; t.firstChild && 1 === t.firstChild.nodeType;) t = t.firstChild;
                        return t
                    }).append(this)
                }
                return this
            },
            wrapInner: function(t) {
                return ht.isFunction(t) ? this.each(function(e) {
                    ht(this).wrapInner(t.call(this, e))
                }) : this.each(function() {
                    var e = ht(this),
                        i = e.contents();
                    i.length ? i.wrapAll(t) : e.append(t)
                })
            },
            wrap: function(t) {
                var e = ht.isFunction(t);
                return this.each(function(i) {
                    ht(this).wrapAll(e ? t.call(this, i) : t)
                })
            },
            unwrap: function() {
                return this.parent().each(function() {
                    ht.nodeName(this, "body") || ht(this).replaceWith(this.childNodes)
                }).end()
            }
        });
        var le, he, ce, ue = /alpha\([^)]*\)/i,
            de = /opacity\s*=\s*([^)]*)/,
            pe = /^(top|right|bottom|left)$/,
            fe = /^(none|table(?!-c[ea]).+)/,
            ge = /^margin/,
            me = new RegExp("^(" + ct + ")(.*)$", "i"),
            ve = new RegExp("^(" + ct + ")(?!px)[a-z%]+$", "i"),
            ye = new RegExp("^([+-])=(" + ct + ")", "i"),
            be = {
                BODY: "block"
            },
            _e = {
                position: "absolute",
                visibility: "hidden",
                display: "block"
            },
            we = {
                letterSpacing: 0,
                fontWeight: 400
            },
            xe = ["Top", "Right", "Bottom", "Left"],
            Ce = ["Webkit", "O", "Moz", "ms"];
        ht.fn.extend({
            css: function(t, i) {
                return ht.access(this, function(t, i, n) {
                    var s, o, r = {},
                        a = 0;
                    if (ht.isArray(i)) {
                        for (o = he(t), s = i.length; a < s; a++) r[i[a]] = ht.css(t, i[a], !1, o);
                        return r
                    }
                    return n !== e ? ht.style(t, i, n) : ht.css(t, i)
                }, t, i, arguments.length > 1)
            },
            show: function() {
                return k(this, !0)
            },
            hide: function() {
                return k(this)
            },
            toggle: function(t) {
                return "boolean" == typeof t ? t ? this.show() : this.hide() : this.each(function() {
                    C(this) ? ht(this).show() : ht(this).hide()
                })
            }
        }), ht.extend({
            cssHooks: {
                opacity: {
                    get: function(t, e) {
                        if (e) {
                            var i = ce(t, "opacity");
                            return "" === i ? "1" : i
                        }
                    }
                }
            },
            cssNumber: {
                columnCount: !0,
                fillOpacity: !0,
                fontWeight: !0,
                lineHeight: !0,
                opacity: !0,
                order: !0,
                orphans: !0,
                widows: !0,
                zIndex: !0,
                zoom: !0
            },
            cssProps: {
                float: ht.support.cssFloat ? "cssFloat" : "styleFloat"
            },
            style: function(t, i, n, s) {
                if (t && 3 !== t.nodeType && 8 !== t.nodeType && t.style) {
                    var o, r, a, l = ht.camelCase(i),
                        h = t.style;
                    if (i = ht.cssProps[l] || (ht.cssProps[l] = x(h, l)), a = ht.cssHooks[i] || ht.cssHooks[l], n === e) return a && "get" in a && (o = a.get(t, !1, s)) !== e ? o : h[i];
                    if (!(r = typeof n, "string" === r && (o = ye.exec(n)) && (n = (o[1] + 1) * o[2] + parseFloat(ht.css(t, i)), r = "number"), null == n || "number" === r && isNaN(n) || ("number" !== r || ht.cssNumber[l] || (n += "px"), ht.support.clearCloneStyle || "" !== n || 0 !== i.indexOf("background") || (h[i] = "inherit"), a && "set" in a && (n = a.set(t, n, s)) === e))) try {
                        h[i] = n
                    } catch (t) {}
                }
            },
            css: function(t, i, n, s) {
                var o, r, a, l = ht.camelCase(i);
                return i = ht.cssProps[l] || (ht.cssProps[l] = x(t.style, l)), a = ht.cssHooks[i] || ht.cssHooks[l], a && "get" in a && (r = a.get(t, !0, n)), r === e && (r = ce(t, i, s)), "normal" === r && i in we && (r = we[i]), "" === n || n ? (o = parseFloat(r), !0 === n || ht.isNumeric(o) ? o || 0 : r) : r
            }
        }), t.getComputedStyle ? (he = function(e) {
            return t.getComputedStyle(e, null)
        }, ce = function(t, i, n) {
            var s, o, r, a = n || he(t),
                l = a ? a.getPropertyValue(i) || a[i] : e,
                h = t.style;
            return a && ("" !== l || ht.contains(t.ownerDocument, t) || (l = ht.style(t, i)), ve.test(l) && ge.test(i) && (s = h.width, o = h.minWidth, r = h.maxWidth, h.minWidth = h.maxWidth = h.width = l, l = a.width, h.width = s, h.minWidth = o, h.maxWidth = r)), l
        }) : X.documentElement.currentStyle && (he = function(t) {
            return t.currentStyle
        }, ce = function(t, i, n) {
            var s, o, r, a = n || he(t),
                l = a ? a[i] : e,
                h = t.style;
            return null == l && h && h[i] && (l = h[i]), ve.test(l) && !pe.test(i) && (s = h.left, o = t.runtimeStyle, r = o && o.left, r && (o.left = t.currentStyle.left), h.left = "fontSize" === i ? "1em" : l, l = h.pixelLeft + "px", h.left = s, r && (o.left = r)), "" === l ? "auto" : l
        }), ht.each(["height", "width"], function(t, e) {
            ht.cssHooks[e] = {
                get: function(t, i, n) {
                    if (i) return 0 === t.offsetWidth && fe.test(ht.css(t, "display")) ? ht.swap(t, _e, function() {
                        return D(t, e, n)
                    }) : D(t, e, n)
                },
                set: function(t, i, n) {
                    var s = n && he(t);
                    return T(t, i, n ? $(t, e, n, ht.support.boxSizing && "border-box" === ht.css(t, "boxSizing", !1, s), s) : 0)
                }
            }
        }), ht.support.opacity || (ht.cssHooks.opacity = {
            get: function(t, e) {
                return de.test((e && t.currentStyle ? t.currentStyle.filter : t.style.filter) || "") ? .01 * parseFloat(RegExp.$1) + "" : e ? "1" : ""
            },
            set: function(t, e) {
                var i = t.style,
                    n = t.currentStyle,
                    s = ht.isNumeric(e) ? "alpha(opacity=" + 100 * e + ")" : "",
                    o = n && n.filter || i.filter || "";
                i.zoom = 1, (e >= 1 || "" === e) && "" === ht.trim(o.replace(ue, "")) && i.removeAttribute && (i.removeAttribute("filter"), "" === e || n && !n.filter) || (i.filter = ue.test(o) ? o.replace(ue, s) : o + " " + s)
            }
        }), ht(function() {
            ht.support.reliableMarginRight || (ht.cssHooks.marginRight = {
                get: function(t, e) {
                    if (e) return ht.swap(t, {
                        display: "inline-block"
                    }, ce, [t, "marginRight"])
                }
            }), !ht.support.pixelPosition && ht.fn.position && ht.each(["top", "left"], function(t, e) {
                ht.cssHooks[e] = {
                    get: function(t, i) {
                        if (i) return i = ce(t, e), ve.test(i) ? ht(t).position()[e] + "px" : i
                    }
                }
            })
        }), ht.expr && ht.expr.filters && (ht.expr.filters.hidden = function(t) {
            return t.offsetWidth <= 0 && t.offsetHeight <= 0 || !ht.support.reliableHiddenOffsets && "none" === (t.style && t.style.display || ht.css(t, "display"))
        }, ht.expr.filters.visible = function(t) {
            return !ht.expr.filters.hidden(t)
        }), ht.each({
            margin: "",
            padding: "",
            border: "Width"
        }, function(t, e) {
            ht.cssHooks[t + e] = {
                expand: function(i) {
                    for (var n = 0, s = {}, o = "string" == typeof i ? i.split(" ") : [i]; n < 4; n++) s[t + xe[n] + e] = o[n] || o[n - 2] || o[0];
                    return s
                }
            }, ge.test(t) || (ht.cssHooks[t + e].set = T)
        });
        var ke = /%20/g,
            Te = /\[\]$/,
            $e = /\r?\n/g,
            De = /^(?:submit|button|image|reset|file)$/i,
            Se = /^(?:input|select|textarea|keygen)/i;
        ht.fn.extend({
            serialize: function() {
                return ht.param(this.serializeArray())
            },
            serializeArray: function() {
                return this.map(function() {
                    var t = ht.prop(this, "elements");
                    return t ? ht.makeArray(t) : this
                }).filter(function() {
                    var t = this.type;
                    return this.name && !ht(this).is(":disabled") && Se.test(this.nodeName) && !De.test(t) && (this.checked || !te.test(t))
                }).map(function(t, e) {
                    var i = ht(this).val();
                    return null == i ? null : ht.isArray(i) ? ht.map(i, function(t) {
                        return {
                            name: e.name,
                            value: t.replace($e, "\r\n")
                        }
                    }) : {
                        name: e.name,
                        value: i.replace($e, "\r\n")
                    }
                }).get()
            }
        }), ht.param = function(t, i) {
            var n, s = [],
                o = function(t, e) {
                    e = ht.isFunction(e) ? e() : null == e ? "" : e, s[s.length] = encodeURIComponent(t) + "=" + encodeURIComponent(e)
                };
            if (i === e && (i = ht.ajaxSettings && ht.ajaxSettings.traditional), ht.isArray(t) || t.jquery && !ht.isPlainObject(t)) ht.each(t, function() {
                o(this.name, this.value)
            });
            else
                for (n in t) E(n, t[n], i, o);
            return s.join("&").replace(ke, "+")
        }, ht.each("blur focus focusin focusout load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup error contextmenu".split(" "), function(t, e) {
            ht.fn[e] = function(t, i) {
                return arguments.length > 0 ? this.on(e, null, t, i) : this.trigger(e)
            }
        }), ht.fn.extend({
            hover: function(t, e) {
                return this.mouseenter(t).mouseleave(e || t)
            },
            bind: function(t, e, i) {
                return this.on(t, null, e, i)
            },
            unbind: function(t, e) {
                return this.off(t, null, e)
            },
            delegate: function(t, e, i, n) {
                return this.on(e, t, i, n)
            },
            undelegate: function(t, e, i) {
                return 1 === arguments.length ? this.off(t, "**") : this.off(e, t || "**", i)
            }
        });
        var Ae, Ee, Ie = ht.now(),
            Pe = /\?/,
            Ne = /#.*$/,
            Me = /([?&])_=[^&]*/,
            Oe = /^(.*?):[ \t]*([^\r\n]*)\r?$/gm,
            He = /^(?:about|app|app-storage|.+-extension|file|res|widget):$/,
            je = /^(?:GET|HEAD)$/,
            ze = /^\/\//,
            Le = /^([\w.+-]+:)(?:\/\/([^\/?#:]*)(?::(\d+)|)|)/,
            Re = ht.fn.load,
            We = {},
            Fe = {},
            qe = "*/".concat("*");
        try {
            Ee = K.href
        } catch (t) {
            Ee = X.createElement("a"), Ee.href = "", Ee = Ee.href
        }
        Ae = Le.exec(Ee.toLowerCase()) || [], ht.fn.load = function(t, i, n) {
            if ("string" != typeof t && Re) return Re.apply(this, arguments);
            var s, o, r, a = this,
                l = t.indexOf(" ");
            return l >= 0 && (s = t.slice(l, t.length), t = t.slice(0, l)), ht.isFunction(i) ? (n = i, i = e) : i && "object" == typeof i && (r = "POST"), a.length > 0 && ht.ajax({
                url: t,
                type: r,
                dataType: "html",
                data: i
            }).done(function(t) {
                o = arguments, a.html(s ? ht("<div>").append(ht.parseHTML(t)).find(s) : t)
            }).complete(n && function(t, e) {
                a.each(n, o || [t.responseText, e, t])
            }), this
        }, ht.each(["ajaxStart", "ajaxStop", "ajaxComplete", "ajaxError", "ajaxSuccess", "ajaxSend"], function(t, e) {
            ht.fn[e] = function(t) {
                return this.on(e, t)
            }
        }), ht.extend({
            active: 0,
            lastModified: {},
            etag: {},
            ajaxSettings: {
                url: Ee,
                type: "GET",
                isLocal: He.test(Ae[1]),
                global: !0,
                processData: !0,
                async: !0,
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                accepts: {
                    "*": qe,
                    text: "text/plain",
                    html: "text/html",
                    xml: "application/xml, text/xml",
                    json: "application/json, text/javascript"
                },
                contents: {
                    xml: /xml/,
                    html: /html/,
                    json: /json/
                },
                responseFields: {
                    xml: "responseXML",
                    text: "responseText",
                    json: "responseJSON"
                },
                converters: {
                    "* text": String,
                    "text html": !0,
                    "text json": ht.parseJSON,
                    "text xml": ht.parseXML
                },
                flatOptions: {
                    url: !0,
                    context: !0
                }
            },
            ajaxSetup: function(t, e) {
                return e ? N(N(t, ht.ajaxSettings), e) : N(ht.ajaxSettings, t)
            },
            ajaxPrefilter: I(We),
            ajaxTransport: I(Fe),
            ajax: function(t, i) {
                function n(t, i, n, s) {
                    var o, u, y, b, w, C = i;
                    2 !== _ && (_ = 2, l && clearTimeout(l), c = e, a = s || "", x.readyState = t > 0 ? 4 : 0, o = t >= 200 && t < 300 || 304 === t, n && (b = M(d, x, n)), b = O(d, b, x, o), o ? (d.ifModified && (w = x.getResponseHeader("Last-Modified"), w && (ht.lastModified[r] = w), (w = x.getResponseHeader("etag")) && (ht.etag[r] = w)), 204 === t || "HEAD" === d.type ? C = "nocontent" : 304 === t ? C = "notmodified" : (C = b.state, u = b.data, y = b.error, o = !y)) : (y = C, !t && C || (C = "error", t < 0 && (t = 0))), x.status = t, x.statusText = (i || C) + "", o ? g.resolveWith(p, [u, C, x]) : g.rejectWith(p, [x, C, y]), x.statusCode(v), v = e, h && f.trigger(o ? "ajaxSuccess" : "ajaxError", [x, d, o ? u : y]), m.fireWith(p, [x, C]), h && (f.trigger("ajaxComplete", [x, d]), --ht.active || ht.event.trigger("ajaxStop")))
                }
                "object" == typeof t && (i = t, t = e), i = i || {};
                var s, o, r, a, l, h, c, u, d = ht.ajaxSetup({}, i),
                    p = d.context || d,
                    f = d.context && (p.nodeType || p.jquery) ? ht(p) : ht.event,
                    g = ht.Deferred(),
                    m = ht.Callbacks("once memory"),
                    v = d.statusCode || {},
                    y = {},
                    b = {},
                    _ = 0,
                    w = "canceled",
                    x = {
                        readyState: 0,
                        getResponseHeader: function(t) {
                            var e;
                            if (2 === _) {
                                if (!u)
                                    for (u = {}; e = Oe.exec(a);) u[e[1].toLowerCase()] = e[2];
                                e = u[t.toLowerCase()]
                            }
                            return null == e ? null : e
                        },
                        getAllResponseHeaders: function() {
                            return 2 === _ ? a : null
                        },
                        setRequestHeader: function(t, e) {
                            var i = t.toLowerCase();
                            return _ || (t = b[i] = b[i] || t, y[t] = e), this
                        },
                        overrideMimeType: function(t) {
                            return _ || (d.mimeType = t), this
                        },
                        statusCode: function(t) {
                            var e;
                            if (t)
                                if (_ < 2)
                                    for (e in t) v[e] = [v[e], t[e]];
                                else x.always(t[x.status]);
                            return this
                        },
                        abort: function(t) {
                            var e = t || w;
                            return c && c.abort(e), n(0, e), this
                        }
                    };
                if (g.promise(x).complete = m.add, x.success = x.done, x.error = x.fail, d.url = ((t || d.url || Ee) + "").replace(Ne, "").replace(ze, Ae[1] + "//"), d.type = i.method || i.type || d.method || d.type, d.dataTypes = ht.trim(d.dataType || "*").toLowerCase().match(ut) || [""], null == d.crossDomain && (s = Le.exec(d.url.toLowerCase()), d.crossDomain = !(!s || s[1] === Ae[1] && s[2] === Ae[2] && (s[3] || ("http:" === s[1] ? "80" : "443")) === (Ae[3] || ("http:" === Ae[1] ? "80" : "443")))), d.data && d.processData && "string" != typeof d.data && (d.data = ht.param(d.data, d.traditional)), P(We, d, i, x), 2 === _) return x;
                h = d.global, h && 0 == ht.active++ && ht.event.trigger("ajaxStart"), d.type = d.type.toUpperCase(), d.hasContent = !je.test(d.type), r = d.url, d.hasContent || (d.data && (r = d.url += (Pe.test(r) ? "&" : "?") + d.data, delete d.data), !1 === d.cache && (d.url = Me.test(r) ? r.replace(Me, "$1_=" + Ie++) : r + (Pe.test(r) ? "&" : "?") + "_=" + Ie++)), d.ifModified && (ht.lastModified[r] && x.setRequestHeader("If-Modified-Since", ht.lastModified[r]), ht.etag[r] && x.setRequestHeader("If-None-Match", ht.etag[r])), (d.data && d.hasContent && !1 !== d.contentType || i.contentType) && x.setRequestHeader("Content-Type", d.contentType), x.setRequestHeader("Accept", d.dataTypes[0] && d.accepts[d.dataTypes[0]] ? d.accepts[d.dataTypes[0]] + ("*" !== d.dataTypes[0] ? ", " + qe + "; q=0.01" : "") : d.accepts["*"]);
                for (o in d.headers) x.setRequestHeader(o, d.headers[o]);
                if (d.beforeSend && (!1 === d.beforeSend.call(p, x, d) || 2 === _)) return x.abort();
                w = "abort";
                for (o in {
                        success: 1,
                        error: 1,
                        complete: 1
                    }) x[o](d[o]);
                if (c = P(Fe, d, i, x)) {
                    x.readyState = 1, h && f.trigger("ajaxSend", [x, d]), d.async && d.timeout > 0 && (l = setTimeout(function() {
                        x.abort("timeout")
                    }, d.timeout));
                    try {
                        _ = 1, c.send(y, n)
                    } catch (t) {
                        if (!(_ < 2)) throw t;
                        n(-1, t)
                    }
                } else n(-1, "No Transport");
                return x
            },
            getJSON: function(t, e, i) {
                return ht.get(t, e, i, "json")
            },
            getScript: function(t, i) {
                return ht.get(t, e, i, "script")
            }
        }), ht.each(["get", "post"], function(t, i) {
            ht[i] = function(t, n, s, o) {
                return ht.isFunction(n) && (o = o || s, s = n, n = e), ht.ajax({
                    url: t,
                    type: i,
                    dataType: o,
                    data: n,
                    success: s
                })
            }
        }), ht.ajaxSetup({
            accepts: {
                script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"
            },
            contents: {
                script: /(?:java|ecma)script/
            },
            converters: {
                "text script": function(t) {
                    return ht.globalEval(t), t
                }
            }
        }), ht.ajaxPrefilter("script", function(t) {
            t.cache === e && (t.cache = !1), t.crossDomain && (t.type = "GET", t.global = !1)
        }), ht.ajaxTransport("script", function(t) {
            if (t.crossDomain) {
                var i, n = X.head || ht("head")[0] || X.documentElement;
                return {
                    send: function(e, s) {
                        i = X.createElement("script"), i.async = !0, t.scriptCharset && (i.charset = t.scriptCharset), i.src = t.url, i.onload = i.onreadystatechange = function(t, e) {
                            (e || !i.readyState || /loaded|complete/.test(i.readyState)) && (i.onload = i.onreadystatechange = null, i.parentNode && i.parentNode.removeChild(i), i = null, e || s(200, "success"))
                        }, n.insertBefore(i, n.firstChild)
                    },
                    abort: function() {
                        i && i.onload(e, !0)
                    }
                }
            }
        });
        var Be = [],
            Ue = /(=)\?(?=&|$)|\?\?/;
        ht.ajaxSetup({
            jsonp: "callback",
            jsonpCallback: function() {
                var t = Be.pop() || ht.expando + "_" + Ie++;
                return this[t] = !0, t
            }
        }), ht.ajaxPrefilter("json jsonp", function(i, n, s) {
            var o, r, a, l = !1 !== i.jsonp && (Ue.test(i.url) ? "url" : "string" == typeof i.data && !(i.contentType || "").indexOf("application/x-www-form-urlencoded") && Ue.test(i.data) && "data");
            if (l || "jsonp" === i.dataTypes[0]) return o = i.jsonpCallback = ht.isFunction(i.jsonpCallback) ? i.jsonpCallback() : i.jsonpCallback, l ? i[l] = i[l].replace(Ue, "$1" + o) : !1 !== i.jsonp && (i.url += (Pe.test(i.url) ? "&" : "?") + i.jsonp + "=" + o), i.converters["script json"] = function() {
                return a || ht.error(o + " was not called"), a[0]
            }, i.dataTypes[0] = "json", r = t[o], t[o] = function() {
                a = arguments
            }, s.always(function() {
                t[o] = r, i[o] && (i.jsonpCallback = n.jsonpCallback, Be.push(o)), a && ht.isFunction(r) && r(a[0]), a = r = e
            }), "script"
        });
        var Ye, Ve, Qe = 0,
            Ke = t.ActiveXObject && function() {
                var t;
                for (t in Ye) Ye[t](e, !0)
            };
        ht.ajaxSettings.xhr = t.ActiveXObject ? function() {
            return !this.isLocal && H() || j()
        } : H, Ve = ht.ajaxSettings.xhr(), ht.support.cors = !!Ve && "withCredentials" in Ve, (Ve = ht.support.ajax = !!Ve) && ht.ajaxTransport(function(i) {
            if ((!i.crossDomain || ht.support.cors) && window.location.href != i.url) {
                var n;
                return {
                    send: function(s, o) {
                        var r, a, l = i.xhr();
                        if (i.username ? l.open(i.type, i.url, i.async, i.username, i.password) : l.open(i.type, i.url, i.async), i.xhrFields)
                            for (a in i.xhrFields) l[a] = i.xhrFields[a];
                        i.mimeType && l.overrideMimeType && l.overrideMimeType(i.mimeType), i.crossDomain || s["X-Requested-With"] || (s["X-Requested-With"] = "XMLHttpRequest");
                        try {
                            for (a in s) l.setRequestHeader(a, s[a])
                        } catch (t) {}
                        l.send(i.hasContent && i.data || null), n = function(t, s) {
                            var a, h, c, u;
                            try {
                                if (n && (s || 4 === l.readyState))
                                    if (n = e, r && (l.onreadystatechange = ht.noop, Ke && delete Ye[r]), s) 4 !== l.readyState && l.abort();
                                    else {
                                        u = {}, a = l.status, h = l.getAllResponseHeaders(), "string" == typeof l.responseText && (u.text = l.responseText);
                                        try {
                                            c = l.statusText
                                        } catch (t) {
                                            c = ""
                                        }
                                        a || !i.isLocal || i.crossDomain ? 1223 === a && (a = 204) : a = u.text ? 200 : 404
                                    }
                            } catch (t) {
                                s || o(-1, t)
                            }
                            u && o(a, c, u, h)
                        }, i.async ? 4 === l.readyState ? setTimeout(n) : (r = ++Qe, Ke && (Ye || (Ye = {}, ht(t).unload(Ke)), Ye[r] = n), l.onreadystatechange = n) : n()
                    },
                    abort: function() {
                        n && n(e, !0)
                    }
                }
            }
        });
        var Xe, Ge, Ze = /^(?:toggle|show|hide)$/,
            Je = new RegExp("^(?:([+-])=|)(" + ct + ")([a-z%]*)$", "i"),
            ti = /queueHooks$/,
            ei = [F],
            ii = {
                "*": [function(t, e) {
                    var i = this.createTween(t, e),
                        n = i.cur(),
                        s = Je.exec(e),
                        o = s && s[3] || (ht.cssNumber[t] ? "" : "px"),
                        r = (ht.cssNumber[t] || "px" !== o && +n) && Je.exec(ht.css(i.elem, t)),
                        a = 1,
                        l = 20;
                    if (r && r[3] !== o) {
                        o = o || r[3], s = s || [], r = +n || 1;
                        do {
                            a = a || ".5", r /= a, ht.style(i.elem, t, r + o)
                        } while (a !== (a = i.cur() / n) && 1 !== a && --l)
                    }
                    return s && (r = i.start = +r || +n || 0, i.unit = o, i.end = s[1] ? r + (s[1] + 1) * s[2] : +s[2]), i
                }]
            };
        ht.Animation = ht.extend(R, {
            tweener: function(t, e) {
                ht.isFunction(t) ? (e = t, t = ["*"]) : t = t.split(" ");
                for (var i, n = 0, s = t.length; n < s; n++) i = t[n], ii[i] = ii[i] || [], ii[i].unshift(e)
            },
            prefilter: function(t, e) {
                e ? ei.unshift(t) : ei.push(t)
            }
        }), ht.Tween = q, q.prototype = {
            constructor: q,
            init: function(t, e, i, n, s, o) {
                this.elem = t, this.prop = i, this.easing = s || "swing", this.options = e, this.start = this.now = this.cur(), this.end = n, this.unit = o || (ht.cssNumber[i] ? "" : "px")
            },
            cur: function() {
                var t = q.propHooks[this.prop];
                return t && t.get ? t.get(this) : q.propHooks._default.get(this)
            },
            run: function(t) {
                var e, i = q.propHooks[this.prop];
                return this.options.duration ? this.pos = e = ht.easing[this.easing](t, this.options.duration * t, 0, 1, this.options.duration) : this.pos = e = t, this.now = (this.end - this.start) * e + this.start, this.options.step && this.options.step.call(this.elem, this.now, this), i && i.set ? i.set(this) : q.propHooks._default.set(this), this
            }
        }, q.prototype.init.prototype = q.prototype, q.propHooks = {
            _default: {
                get: function(t) {
                    var e;
                    return null == t.elem[t.prop] || t.elem.style && null != t.elem.style[t.prop] ? (e = ht.css(t.elem, t.prop, ""), e && "auto" !== e ? e : 0) : t.elem[t.prop]
                },
                set: function(t) {
                    ht.fx.step[t.prop] ? ht.fx.step[t.prop](t) : t.elem.style && (null != t.elem.style[ht.cssProps[t.prop]] || ht.cssHooks[t.prop]) ? ht.style(t.elem, t.prop, t.now + t.unit) : t.elem[t.prop] = t.now
                }
            }
        }, q.propHooks.scrollTop = q.propHooks.scrollLeft = {
            set: function(t) {
                t.elem.nodeType && t.elem.parentNode && (t.elem[t.prop] = t.now)
            }
        }, ht.each(["toggle", "show", "hide"], function(t, e) {
            var i = ht.fn[e];
            ht.fn[e] = function(t, n, s) {
                return null == t || "boolean" == typeof t ? i.apply(this, arguments) : this.animate(B(e, !0), t, n, s)
            }
        }), ht.fn.extend({
            fadeTo: function(t, e, i, n) {
                return this.filter(C).css("opacity", 0).show().end().animate({
                    opacity: e
                }, t, i, n)
            },
            animate: function(t, e, i, n) {
                var s = ht.isEmptyObject(t),
                    o = ht.speed(e, i, n),
                    r = function() {
                        var e = R(this, ht.extend({}, t), o);
                        (s || ht._data(this, "finish")) && e.stop(!0)
                    };
                return r.finish = r, s || !1 === o.queue ? this.each(r) : this.queue(o.queue, r)
            },
            stop: function(t, i, n) {
                var s = function(t) {
                    var e = t.stop;
                    delete t.stop, e(n)
                };
                return "string" != typeof t && (n = i, i = t, t = e), i && !1 !== t && this.queue(t || "fx", []), this.each(function() {
                    var e = !0,
                        i = null != t && t + "queueHooks",
                        o = ht.timers,
                        r = ht._data(this);
                    if (i) r[i] && r[i].stop && s(r[i]);
                    else
                        for (i in r) r[i] && r[i].stop && ti.test(i) && s(r[i]);
                    for (i = o.length; i--;) o[i].elem !== this || null != t && o[i].queue !== t || (o[i].anim.stop(n), e = !1, o.splice(i, 1));
                    !e && n || ht.dequeue(this, t)
                })
            },
            finish: function(t) {
                return !1 !== t && (t = t || "fx"), this.each(function() {
                    var e, i = ht._data(this),
                        n = i[t + "queue"],
                        s = i[t + "queueHooks"],
                        o = ht.timers,
                        r = n ? n.length : 0;
                    for (i.finish = !0, ht.queue(this, t, []), s && s.stop && s.stop.call(this, !0), e = o.length; e--;) o[e].elem === this && o[e].queue === t && (o[e].anim.stop(!0), o.splice(e, 1));
                    for (e = 0; e < r; e++) n[e] && n[e].finish && n[e].finish.call(this);
                    delete i.finish
                })
            }
        }), ht.each({
            slideDown: B("show"),
            slideUp: B("hide"),
            slideToggle: B("toggle"),
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
            ht.fn[t] = function(t, i, n) {
                return this.animate(e, t, i, n)
            }
        }), ht.speed = function(t, e, i) {
            var n = t && "object" == typeof t ? ht.extend({}, t) : {
                complete: i || !i && e || ht.isFunction(t) && t,
                duration: t,
                easing: i && e || e && !ht.isFunction(e) && e
            };
            return n.duration = ht.fx.off ? 0 : "number" == typeof n.duration ? n.duration : n.duration in ht.fx.speeds ? ht.fx.speeds[n.duration] : ht.fx.speeds._default, null != n.queue && !0 !== n.queue || (n.queue = "fx"), n.old = n.complete, n.complete = function() {
                ht.isFunction(n.old) && n.old.call(this), n.queue && ht.dequeue(this, n.queue)
            }, n
        }, ht.easing = {
            linear: function(t) {
                return t
            },
            swing: function(t) {
                return .5 - Math.cos(t * Math.PI) / 2
            }
        }, ht.timers = [], ht.fx = q.prototype.init, ht.fx.tick = function() {
            var t, i = ht.timers,
                n = 0;
            for (Xe = ht.now(); n < i.length; n++)(t = i[n])() || i[n] !== t || i.splice(n--, 1);
            i.length || ht.fx.stop(), Xe = e
        }, ht.fx.timer = function(t) {
            t() && ht.timers.push(t) && ht.fx.start()
        }, ht.fx.interval = 13, ht.fx.start = function() {
            Ge || (Ge = setInterval(ht.fx.tick, ht.fx.interval))
        }, ht.fx.stop = function() {
            clearInterval(Ge), Ge = null
        }, ht.fx.speeds = {
            slow: 600,
            fast: 200,
            _default: 400
        }, ht.fx.step = {}, ht.expr && ht.expr.filters && (ht.expr.filters.animated = function(t) {
            return ht.grep(ht.timers, function(e) {
                return t === e.elem
            }).length
        }), ht.fn.offset = function(t) {
            if (arguments.length) return t === e ? this : this.each(function(e) {
                ht.offset.setOffset(this, t, e)
            });
            var i, n, s = {
                    top: 0,
                    left: 0
                },
                o = this[0],
                r = o && o.ownerDocument;
            if (r) return i = r.documentElement, ht.contains(i, o) ? (typeof o.getBoundingClientRect !== Q && (s = o.getBoundingClientRect()), n = U(r), {
                top: s.top + (n.pageYOffset || i.scrollTop) - (i.clientTop || 0),
                left: s.left + (n.pageXOffset || i.scrollLeft) - (i.clientLeft || 0)
            }) : s
        }, ht.offset = {
            setOffset: function(t, e, i) {
                var n = ht.css(t, "position");
                "static" === n && (t.style.position = "relative");
                var s, o, r = ht(t),
                    a = r.offset(),
                    l = ht.css(t, "top"),
                    h = ht.css(t, "left"),
                    c = ("absolute" === n || "fixed" === n) && ht.inArray("auto", [l, h]) > -1,
                    u = {},
                    d = {};
                c ? (d = r.position(), s = d.top, o = d.left) : (s = parseFloat(l) || 0, o = parseFloat(h) || 0), ht.isFunction(e) && (e = e.call(t, i, a)), null != e.top && (u.top = e.top - a.top + s), null != e.left && (u.left = e.left - a.left + o), "using" in e ? e.using.call(t, u) : r.css(u)
            }
        }, ht.fn.extend({
            position: function() {
                if (this[0]) {
                    var t, e, i = {
                            top: 0,
                            left: 0
                        },
                        n = this[0];
                    return "fixed" === ht.css(n, "position") ? e = n.getBoundingClientRect() : (t = this.offsetParent(), e = this.offset(), ht.nodeName(t[0], "html") || (i = t.offset()), i.top += ht.css(t[0], "borderTopWidth", !0), i.left += ht.css(t[0], "borderLeftWidth", !0)), {
                        top: e.top - i.top - ht.css(n, "marginTop", !0),
                        left: e.left - i.left - ht.css(n, "marginLeft", !0)
                    }
                }
            },
            offsetParent: function() {
                return this.map(function() {
                    for (var t = this.offsetParent || G; t && !ht.nodeName(t, "html") && "static" === ht.css(t, "position");) t = t.offsetParent;
                    return t || G
                })
            }
        }), ht.each({
            scrollLeft: "pageXOffset",
            scrollTop: "pageYOffset"
        }, function(t, i) {
            var n = /Y/.test(i);
            ht.fn[t] = function(s) {
                return ht.access(this, function(t, s, o) {
                    var r = U(t);
                    if (o === e) return r ? i in r ? r[i] : r.document.documentElement[s] : t[s];
                    r ? r.scrollTo(n ? ht(r).scrollLeft() : o, n ? o : ht(r).scrollTop()) : t[s] = o
                }, t, s, arguments.length, null)
            }
        }), ht.each({
            Height: "height",
            Width: "width"
        }, function(t, i) {
            ht.each({
                padding: "inner" + t,
                content: i,
                "": "outer" + t
            }, function(n, s) {
                ht.fn[s] = function(s, o) {
                    var r = arguments.length && (n || "boolean" != typeof s),
                        a = n || (!0 === s || !0 === o ? "margin" : "border");
                    return ht.access(this, function(i, n, s) {
                        var o;
                        return ht.isWindow(i) ? i.document.documentElement["client" + t] : 9 === i.nodeType ? (o = i.documentElement, Math.max(i.body["scroll" + t], o["scroll" + t], i.body["offset" + t], o["offset" + t], o["client" + t])) : s === e ? ht.css(i, n, a) : ht.style(i, n, s, a)
                    }, i, r ? s : e, r, null)
                }
            })
        }), ht.fn.size = function() {
            return this.length
        }, ht.fn.andSelf = ht.fn.addBack, "object" == typeof module && module && "object" == typeof module.exports ? module.exports = ht : (t.jQuery = t.$ = ht, "function" == typeof define && define.amd && define("jquery", [], function() {
            return ht
        }))
    }(window), function(t, e) {
        function i(e, i) {
            var s, o, r, a = e.nodeName.toLowerCase();
            return "area" === a ? (s = e.parentNode, o = s.name, !(!e.href || !o || "map" !== s.nodeName.toLowerCase()) && (!!(r = t("img[usemap=#" + o + "]")[0]) && n(r))) : (/input|select|textarea|button|object/.test(a) ? !e.disabled : "a" === a ? e.href || i : i) && n(e)
        }

        function n(e) {
            return t.expr.filters.visible(e) && !t(e).parents().andSelf().filter(function() {
                return "hidden" === t.css(this, "visibility")
            }).length
        }
        var s = 0,
            o = /^ui-id-\d+$/;
        t.ui = t.ui || {}, t.ui.version || (t.extend(t.ui, {
            version: "1.9.2",
            keyCode: {
                BACKSPACE: 8,
                COMMA: 188,
                DELETE: 46,
                DOWN: 40,
                END: 35,
                ENTER: 13,
                ESCAPE: 27,
                HOME: 36,
                LEFT: 37,
                NUMPAD_ADD: 107,
                NUMPAD_DECIMAL: 110,
                NUMPAD_DIVIDE: 111,
                NUMPAD_ENTER: 108,
                NUMPAD_MULTIPLY: 106,
                NUMPAD_SUBTRACT: 109,
                PAGE_DOWN: 34,
                PAGE_UP: 33,
                PERIOD: 190,
                RIGHT: 39,
                SPACE: 32,
                TAB: 9,
                UP: 38
            }
        }), t.fn.extend({
            _focus: t.fn.focus,
            focus: function(e, i) {
                return "number" == typeof e ? this.each(function() {
                    var n = this;
                    setTimeout(function() {
                        t(n).focus(), i && i.call(n)
                    }, e)
                }) : this._focus.apply(this, arguments)
            },
            scrollParent: function() {
                var e;
                return e = t.ui.ie && /(static|relative)/.test(this.css("position")) || /absolute/.test(this.css("position")) ? this.parents().filter(function() {
                    return /(relative|absolute|fixed)/.test(t.css(this, "position")) && /(auto|scroll)/.test(t.css(this, "overflow") + t.css(this, "overflow-y") + t.css(this, "overflow-x"))
                }).eq(0) : this.parents().filter(function() {
                    return /(auto|scroll)/.test(t.css(this, "overflow") + t.css(this, "overflow-y") + t.css(this, "overflow-x"))
                }).eq(0), /fixed/.test(this.css("position")) || !e.length ? t(document) : e
            },
            zIndex: function(i) {
                if (i !== e) return this.css("zIndex", i);
                if (this.length)
                    for (var n, s, o = t(this[0]); o.length && o[0] !== document;) {
                        if (("absolute" === (n = o.css("position")) || "relative" === n || "fixed" === n) && (s = parseInt(o.css("zIndex"), 10), !isNaN(s) && 0 !== s)) return s;
                        o = o.parent()
                    }
                return 0
            },
            uniqueId: function() {
                return this.each(function() {
                    this.id || (this.id = "ui-id-" + ++s)
                })
            },
            removeUniqueId: function() {
                return this.each(function() {
                    o.test(this.id) && t(this).removeAttr("id")
                })
            }
        }), t.extend(t.expr[":"], {
            data: t.expr.createPseudo ? t.expr.createPseudo(function(e) {
                return function(i) {
                    return !!t.data(i, e)
                }
            }) : function(e, i, n) {
                return !!t.data(e, n[3])
            },
            focusable: function(e) {
                return i(e, !isNaN(t.attr(e, "tabindex")))
            },
            tabbable: function(e) {
                var n = t.attr(e, "tabindex"),
                    s = isNaN(n);
                return (s || n >= 0) && i(e, !s)
            }
        }), t(function() {
            var e = document.body,
                i = e.appendChild(i = document.createElement("div"));
            i.offsetHeight, t.extend(i.style, {
                minHeight: "100px",
                height: "auto",
                padding: 0,
                borderWidth: 0
            }), t.support.minHeight = 100 === i.offsetHeight, t.support.selectstart = "onselectstart" in i, e.removeChild(i).style.display = "none"
        }), t("<a>").outerWidth(1).jquery || t.each(["Width", "Height"], function(i, n) {
            function s(e, i, n, s) {
                return t.each(o, function() {
                    i -= parseFloat(t.css(e, "padding" + this)) || 0, n && (i -= parseFloat(t.css(e, "border" + this + "Width")) || 0), s && (i -= parseFloat(t.css(e, "margin" + this)) || 0)
                }), i
            }
            var o = "Width" === n ? ["Left", "Right"] : ["Top", "Bottom"],
                r = n.toLowerCase(),
                a = {
                    innerWidth: t.fn.innerWidth,
                    innerHeight: t.fn.innerHeight,
                    outerWidth: t.fn.outerWidth,
                    outerHeight: t.fn.outerHeight
                };
            t.fn["inner" + n] = function(i) {
                return i === e ? a["inner" + n].call(this) : this.each(function() {
                    t(this).css(r, s(this, i) + "px")
                })
            }, t.fn["outer" + n] = function(e, i) {
                return "number" != typeof e ? a["outer" + n].call(this, e) : this.each(function() {
                    t(this).css(r, s(this, e, !0, i) + "px")
                })
            }
        }), t("<a>").data("a-b", "a").removeData("a-b").data("a-b") && (t.fn.removeData = function(e) {
            return function(i) {
                return arguments.length ? e.call(this, t.camelCase(i)) : e.call(this)
            }
        }(t.fn.removeData)), function() {
            var e = /msie ([\w.]+)/.exec(navigator.userAgent.toLowerCase()) || [];
            t.ui.ie = !!e.length, t.ui.ie6 = 6 === parseFloat(e[1], 10)
        }(), t.fn.extend({
            disableSelection: function() {
                return this.bind((t.support.selectstart ? "selectstart" : "mousedown") + ".ui-disableSelection", function(t) {
                    t.preventDefault()
                })
            },
            enableSelection: function() {
                return this.unbind(".ui-disableSelection")
            }
        }), t.extend(t.ui, {
            plugin: {
                add: function(e, i, n) {
                    var s, o = t.ui[e].prototype;
                    for (s in n) o.plugins[s] = o.plugins[s] || [], o.plugins[s].push([i, n[s]])
                },
                call: function(t, e, i) {
                    var n, s = t.plugins[e];
                    if (s && t.element[0].parentNode && 11 !== t.element[0].parentNode.nodeType)
                        for (n = 0; n < s.length; n++) t.options[s[n][0]] && s[n][1].apply(t.element, i)
                }
            },
            contains: t.contains,
            hasScroll: function(e, i) {
                if ("hidden" === t(e).css("overflow")) return !1;
                var n = i && "left" === i ? "scrollLeft" : "scrollTop",
                    s = !1;
                return e[n] > 0 || (e[n] = 1, s = e[n] > 0, e[n] = 0, s)
            },
            isOverAxis: function(t, e, i) {
                return t > e && t < e + i
            },
            isOver: function(e, i, n, s, o, r) {
                return t.ui.isOverAxis(e, n, o) && t.ui.isOverAxis(i, s, r)
            }
        }))
    }(jQuery), function(t, e) {
        var i = 0,
            n = Array.prototype.slice,
            s = t.cleanData;
        t.cleanData = function(e) {
            for (var i, n = 0; null != (i = e[n]); n++) try {
                t(i).triggerHandler("remove")
            } catch (t) {}
            s(e)
        }, t.widget = function(e, i, n) {
            var s, o, r, a, l = e.split(".")[0];
            e = e.split(".")[1], s = l + "-" + e, n || (n = i, i = t.Widget), t.expr[":"][s.toLowerCase()] = function(e) {
                return !!t.data(e, s)
            }, t[l] = t[l] || {}, o = t[l][e], r = t[l][e] = function(t, e) {
                if (!this._createWidget) return new r(t, e);
                arguments.length && this._createWidget(t, e)
            }, t.extend(r, o, {
                version: n.version,
                _proto: t.extend({}, n),
                _childConstructors: []
            }), a = new i, a.options = t.widget.extend({}, a.options), t.each(n, function(e, s) {
                t.isFunction(s) && (n[e] = function() {
                    var t = function() {
                            return i.prototype[e].apply(this, arguments)
                        },
                        n = function(t) {
                            return i.prototype[e].apply(this, t)
                        };
                    return function() {
                        var e, i = this._super,
                            o = this._superApply;
                        return this._super = t, this._superApply = n, e = s.apply(this, arguments), this._super = i, this._superApply = o, e
                    }
                }())
            }), r.prototype = t.widget.extend(a, {
                widgetEventPrefix: o ? a.widgetEventPrefix : e
            }, n, {
                constructor: r,
                namespace: l,
                widgetName: e,
                widgetBaseClass: s,
                widgetFullName: s
            }), o ? (t.each(o._childConstructors, function(e, i) {
                var n = i.prototype;
                t.widget(n.namespace + "." + n.widgetName, r, i._proto)
            }), delete o._childConstructors) : i._childConstructors.push(r), t.widget.bridge(e, r)
        }, t.widget.extend = function(i) {
            for (var s, o, r = n.call(arguments, 1), a = 0, l = r.length; a < l; a++)
                for (s in r[a]) o = r[a][s], r[a].hasOwnProperty(s) && o !== e && (t.isPlainObject(o) ? i[s] = t.isPlainObject(i[s]) ? t.widget.extend({}, i[s], o) : t.widget.extend({}, o) : i[s] = o);
            return i
        }, t.widget.bridge = function(i, s) {
            var o = s.prototype.widgetFullName || i;
            t.fn[i] = function(r) {
                var a = "string" == typeof r,
                    l = n.call(arguments, 1),
                    h = this;
                return r = !a && l.length ? t.widget.extend.apply(null, [r].concat(l)) : r, a ? this.each(function() {
                    var n, s = t.data(this, o);
                    return s ? t.isFunction(s[r]) && "_" !== r.charAt(0) ? (n = s[r].apply(s, l), n !== s && n !== e ? (h = n && n.jquery ? h.pushStack(n.get()) : n, !1) : void 0) : t.error("no such method '" + r + "' for " + i + " widget instance") : t.error("cannot call methods on " + i + " prior to initialization; attempted to call method '" + r + "'")
                }) : this.each(function() {
                    var e = t.data(this, o);
                    e ? e.option(r || {})._init() : t.data(this, o, new s(r, this))
                }), h
            }
        }, t.Widget = function() {}, t.Widget._childConstructors = [], t.Widget.prototype = {
            widgetName: "widget",
            widgetEventPrefix: "",
            defaultElement: "<div>",
            options: {
                disabled: !1,
                create: null
            },
            _createWidget: function(e, n) {
                n = t(n || this.defaultElement || this)[0], this.element = t(n), this.uuid = i++, this.eventNamespace = "." + this.widgetName + this.uuid, this.options = t.widget.extend({}, this.options, this._getCreateOptions(), e), this.bindings = t(), this.hoverable = t(), this.focusable = t(), n !== this && (t.data(n, this.widgetName, this), t.data(n, this.widgetFullName, this), this._on(!0, this.element, {
                    remove: function(t) {
                        t.target === n && this.destroy()
                    }
                }), this.document = t(n.style ? n.ownerDocument : n.document || n), this.window = t(this.document[0].defaultView || this.document[0].parentWindow)), this._create(), this._trigger("create", null, this._getCreateEventData()), this._init()
            },
            _getCreateOptions: t.noop,
            _getCreateEventData: t.noop,
            _create: t.noop,
            _init: t.noop,
            destroy: function() {
                this._destroy(), this.element.unbind(this.eventNamespace).removeData(this.widgetName).removeData(this.widgetFullName).removeData(t.camelCase(this.widgetFullName)), this.widget().unbind(this.eventNamespace).removeAttr("aria-disabled").removeClass(this.widgetFullName + "-disabled ui-state-disabled"), this.bindings.unbind(this.eventNamespace), this.hoverable.removeClass("ui-state-hover"), this.focusable.removeClass("ui-state-focus")
            },
            _destroy: t.noop,
            widget: function() {
                return this.element
            },
            option: function(i, n) {
                var s, o, r, a = i;
                if (0 === arguments.length) return t.widget.extend({}, this.options);
                if ("string" == typeof i)
                    if (a = {}, s = i.split("."), i = s.shift(), s.length) {
                        for (o = a[i] = t.widget.extend({}, this.options[i]), r = 0; r < s.length - 1; r++) o[s[r]] = o[s[r]] || {}, o = o[s[r]];
                        if (i = s.pop(), n === e) return o[i] === e ? null : o[i];
                        o[i] = n
                    } else {
                        if (n === e) return this.options[i] === e ? null : this.options[i];
                        a[i] = n
                    } return this._setOptions(a), this
            },
            _setOptions: function(t) {
                var e;
                for (e in t) this._setOption(e, t[e]);
                return this
            },
            _setOption: function(t, e) {
                return this.options[t] = e, "disabled" === t && (this.widget().toggleClass(this.widgetFullName + "-disabled ui-state-disabled", !!e).attr("aria-disabled", e), this.hoverable.removeClass("ui-state-hover"), this.focusable.removeClass("ui-state-focus")), this
            },
            enable: function() {
                return this._setOption("disabled", !1)
            },
            disable: function() {
                return this._setOption("disabled", !0)
            },
            _on: function(e, i, n) {
                var s, o = this;
                "boolean" != typeof e && (n = i, i = e, e = !1), n ? (i = s = t(i), this.bindings = this.bindings.add(i)) : (n = i, i = this.element, s = this.widget()), t.each(n, function(n, r) {
                    function a() {
                        if (e || !0 !== o.options.disabled && !t(this).hasClass("ui-state-disabled")) return ("string" == typeof r ? o[r] : r).apply(o, arguments)
                    }
                    "string" != typeof r && (a.guid = r.guid = r.guid || a.guid || t.guid++);
                    var l = n.match(/^(\w+)\s*(.*)$/),
                        h = l[1] + o.eventNamespace,
                        c = l[2];
                    c ? s.delegate(c, h, a) : i.bind(h, a)
                })
            },
            _off: function(t, e) {
                e = (e || "").split(" ").join(this.eventNamespace + " ") + this.eventNamespace, t.unbind(e).undelegate(e)
            },
            _delay: function(t, e) {
                function i() {
                    return ("string" == typeof t ? n[t] : t).apply(n, arguments)
                }
                var n = this;
                return setTimeout(i, e || 0)
            },
            _hoverable: function(e) {
                this.hoverable = this.hoverable.add(e), this._on(e, {
                    mouseenter: function(e) {
                        t(e.currentTarget).addClass("ui-state-hover")
                    },
                    mouseleave: function(e) {
                        t(e.currentTarget).removeClass("ui-state-hover")
                    }
                })
            },
            _focusable: function(e) {
                this.focusable = this.focusable.add(e), this._on(e, {
                    focusin: function(e) {
                        t(e.currentTarget).addClass("ui-state-focus")
                    },
                    focusout: function(e) {
                        t(e.currentTarget).removeClass("ui-state-focus")
                    }
                })
            },
            _trigger: function(e, i, n) {
                var s, o, r = this.options[e];
                if (n = n || {}, i = t.Event(i), i.type = (e === this.widgetEventPrefix ? e : this.widgetEventPrefix + e).toLowerCase(), i.target = this.element[0], o = i.originalEvent, o)
                    for (s in o) s in i || (i[s] = o[s]);
                return this.element.trigger(i, n), !(t.isFunction(r) && !1 === r.apply(this.element[0], [i].concat(n)) || i.isDefaultPrevented())
            }
        }, t.each({
            show: "fadeIn",
            hide: "fadeOut"
        }, function(e, i) {
            t.Widget.prototype["_" + e] = function(n, s, o) {
                "string" == typeof s && (s = {
                    effect: s
                });
                var r, a = s ? !0 === s || "number" == typeof s ? i : s.effect || i : e;
                s = s || {}, "number" == typeof s && (s = {
                    duration: s
                }), r = !t.isEmptyObject(s), s.complete = o, s.delay && n.delay(s.delay), r && t.effects && (t.effects.effect[a] || !1 !== t.uiBackCompat && t.effects[a]) ? n[e](s) : a !== e && n[a] ? n[a](s.duration, s.easing, o) : n.queue(function(i) {
                    t(this)[e](), o && o.call(n[0]), i()
                })
            }
        }), !1 !== t.uiBackCompat && (t.Widget.prototype._getCreateOptions = function() {
            return t.metadata && t.metadata.get(this.element[0])[this.widgetName]
        })
    }(jQuery), function(t, e) {
        var i = !1;
        t(document).mouseup(function(t) {
            i = !1
        }), t.widget("ui.mouse", {
            version: "1.9.2",
            options: {
                cancel: "input,textarea,button,select,option",
                distance: 1,
                delay: 0
            },
            _mouseInit: function() {
                var e = this;
                this.element.bind("mousedown." + this.widgetName, function(t) {
                    return e._mouseDown(t)
                }).bind("click." + this.widgetName, function(i) {
                    if (!0 === t.data(i.target, e.widgetName + ".preventClickEvent")) return t.removeData(i.target, e.widgetName + ".preventClickEvent"), i.stopImmediatePropagation(), !1
                }), this.started = !1
            },
            _mouseDestroy: function() {
                this.element.unbind("." + this.widgetName), this._mouseMoveDelegate && t(document).unbind("mousemove." + this.widgetName, this._mouseMoveDelegate).unbind("mouseup." + this.widgetName, this._mouseUpDelegate)
            },
            _mouseDown: function(e) {
                if (!i) {
                    this._mouseStarted && this._mouseUp(e), this._mouseDownEvent = e;
                    var n = this,
                        s = 1 === e.which,
                        o = !("string" != typeof this.options.cancel || !e.target.nodeName) && t(e.target).closest(this.options.cancel).length;
                    return !(s && !o && this._mouseCapture(e)) || (this.mouseDelayMet = !this.options.delay, this.mouseDelayMet || (this._mouseDelayTimer = setTimeout(function() {
                        n.mouseDelayMet = !0
                    }, this.options.delay)), this._mouseDistanceMet(e) && this._mouseDelayMet(e) && (this._mouseStarted = !1 !== this._mouseStart(e), !this._mouseStarted) ? (e.preventDefault(), !0) : (!0 === t.data(e.target, this.widgetName + ".preventClickEvent") && t.removeData(e.target, this.widgetName + ".preventClickEvent"), this._mouseMoveDelegate = function(t) {
                        return n._mouseMove(t)
                    }, this._mouseUpDelegate = function(t) {
                        return n._mouseUp(t)
                    }, t(document).bind("mousemove." + this.widgetName, this._mouseMoveDelegate).bind("mouseup." + this.widgetName, this._mouseUpDelegate), e.preventDefault(), i = !0, !0))
                }
            },
            _mouseMove: function(e) {
                return !t.ui.ie || document.documentMode >= 9 || e.button ? this._mouseStarted ? (this._mouseDrag(e), e.preventDefault()) : (this._mouseDistanceMet(e) && this._mouseDelayMet(e) && (this._mouseStarted = !1 !== this._mouseStart(this._mouseDownEvent, e), this._mouseStarted ? this._mouseDrag(e) : this._mouseUp(e)), !this._mouseStarted) : this._mouseUp(e)
            },
            _mouseUp: function(e) {
                return t(document).unbind("mousemove." + this.widgetName, this._mouseMoveDelegate).unbind("mouseup." + this.widgetName, this._mouseUpDelegate), this._mouseStarted && (this._mouseStarted = !1, e.target === this._mouseDownEvent.target && t.data(e.target, this.widgetName + ".preventClickEvent", !0), this._mouseStop(e)), !1
            },
            _mouseDistanceMet: function(t) {
                return Math.max(Math.abs(this._mouseDownEvent.pageX - t.pageX), Math.abs(this._mouseDownEvent.pageY - t.pageY)) >= this.options.distance
            },
            _mouseDelayMet: function(t) {
                return this.mouseDelayMet
            },
            _mouseStart: function(t) {},
            _mouseDrag: function(t) {},
            _mouseStop: function(t) {},
            _mouseCapture: function(t) {
                return !0
            }
        })
    }(jQuery), function(t, e) {
        t.widget("ui.draggable", t.ui.mouse, {
            version: "1.9.2",
            widgetEventPrefix: "drag",
            options: {
                addClasses: !0,
                appendTo: "parent",
                axis: !1,
                connectToSortable: !1,
                containment: !1,
                cursor: "auto",
                cursorAt: !1,
                grid: !1,
                handle: !1,
                helper: "original",
                iframeFix: !1,
                opacity: !1,
                refreshPositions: !1,
                revert: !1,
                revertDuration: 500,
                scope: "default",
                scroll: !0,
                scrollSensitivity: 20,
                scrollSpeed: 20,
                snap: !1,
                snapMode: "both",
                snapTolerance: 20,
                stack: !1,
                zIndex: !1
            },
            _create: function() {
                "original" == this.options.helper && !/^(?:r|a|f)/.test(this.element.css("position")) && (this.element[0].style.position = "relative"), this.options.addClasses && this.element.addClass("ui-draggable"), this.options.disabled && this.element.addClass("ui-draggable-disabled"), this._mouseInit()
            },
            _destroy: function() {
                this.element.removeClass("ui-draggable ui-draggable-dragging ui-draggable-disabled"), this._mouseDestroy()
            },
            _mouseCapture: function(e) {
                var i = this.options;
                return !(this.helper || i.disabled || t(e.target).is(".ui-resizable-handle")) && (this.handle = this._getHandle(e), !!this.handle && (t(!0 === i.iframeFix ? "iframe" : i.iframeFix).each(function() {
                    t('<div class="ui-draggable-iframeFix" style="background: #fff;"></div>').css({
                        width: this.offsetWidth + "px",
                        height: this.offsetHeight + "px",
                        position: "absolute",
                        opacity: "0.001",
                        zIndex: 1e3
                    }).css(t(this).offset()).appendTo("body")
                }), !0))
            },
            _mouseStart: function(e) {
                var i = this.options;
                return this.helper = this._createHelper(e), this.helper.addClass("ui-draggable-dragging"), this._cacheHelperProportions(), t.ui.ddmanager && (t.ui.ddmanager.current = this), this._cacheMargins(), this.cssPosition = this.helper.css("position"), this.scrollParent = this.helper.scrollParent(), this.offset = this.positionAbs = this.element.offset(), this.offset = {
                    top: this.offset.top - this.margins.top,
                    left: this.offset.left - this.margins.left
                }, t.extend(this.offset, {
                    click: {
                        left: e.pageX - this.offset.left,
                        top: e.pageY - this.offset.top
                    },
                    parent: this._getParentOffset(),
                    relative: this._getRelativeOffset()
                }), this.originalPosition = this.position = this._generatePosition(e), this.originalPageX = e.pageX, this.originalPageY = e.pageY, i.cursorAt && this._adjustOffsetFromHelper(i.cursorAt), i.containment && this._setContainment(), !1 === this._trigger("start", e) ? (this._clear(), !1) : (this._cacheHelperProportions(), t.ui.ddmanager && !i.dropBehaviour && t.ui.ddmanager.prepareOffsets(this, e), this._mouseDrag(e, !0), t.ui.ddmanager && t.ui.ddmanager.dragStart(this, e), !0)
            },
            _mouseDrag: function(e, i) {
                if (this.position = this._generatePosition(e), this.positionAbs = this._convertPositionTo("absolute"), !i) {
                    var n = this._uiHash();
                    if (!1 === this._trigger("drag", e, n)) return this._mouseUp({}), !1;
                    this.position = n.position
                }
                return this.options.axis && "y" == this.options.axis || (this.helper[0].style.left = this.position.left + "px"), this.options.axis && "x" == this.options.axis || (this.helper[0].style.top = this.position.top + "px"), t.ui.ddmanager && t.ui.ddmanager.drag(this, e), !1
            },
            _mouseStop: function(e) {
                var i = !1;
                t.ui.ddmanager && !this.options.dropBehaviour && (i = t.ui.ddmanager.drop(this, e)), this.dropped && (i = this.dropped, this.dropped = !1);
                for (var n = this.element[0], s = !1; n && (n = n.parentNode);) n == document && (s = !0);
                if (!s && "original" === this.options.helper) return !1;
                if ("invalid" == this.options.revert && !i || "valid" == this.options.revert && i || !0 === this.options.revert || t.isFunction(this.options.revert) && this.options.revert.call(this.element, i)) {
                    var o = this;
                    t(this.helper).animate(this.originalPosition, parseInt(this.options.revertDuration, 10), function() {
                        !1 !== o._trigger("stop", e) && o._clear()
                    })
                } else !1 !== this._trigger("stop", e) && this._clear();
                return !1
            },
            _mouseUp: function(e) {
                return t("div.ui-draggable-iframeFix").each(function() {
                    this.parentNode.removeChild(this)
                }), t.ui.ddmanager && t.ui.ddmanager.dragStop(this, e), t.ui.mouse.prototype._mouseUp.call(this, e)
            },
            cancel: function() {
                return this.helper.is(".ui-draggable-dragging") ? this._mouseUp({}) : this._clear(), this
            },
            _getHandle: function(e) {
                var i = !this.options.handle || !t(this.options.handle, this.element).length;
                return t(this.options.handle, this.element).find("*").andSelf().each(function() {
                    this == e.target && (i = !0)
                }), i
            },
            _createHelper: function(e) {
                var i = this.options,
                    n = t.isFunction(i.helper) ? t(i.helper.apply(this.element[0], [e])) : "clone" == i.helper ? this.element.clone().removeAttr("id") : this.element;
                return n.parents("body").length || n.appendTo("parent" == i.appendTo ? this.element[0].parentNode : i.appendTo), n[0] != this.element[0] && !/(fixed|absolute)/.test(n.css("position")) && n.css("position", "absolute"), n
            },
            _adjustOffsetFromHelper: function(e) {
                "string" == typeof e && (e = e.split(" ")), t.isArray(e) && (e = {
                    left: +e[0],
                    top: +e[1] || 0
                }), "left" in e && (this.offset.click.left = e.left + this.margins.left), "right" in e && (this.offset.click.left = this.helperProportions.width - e.right + this.margins.left), "top" in e && (this.offset.click.top = e.top + this.margins.top), "bottom" in e && (this.offset.click.top = this.helperProportions.height - e.bottom + this.margins.top)
            },
            _getParentOffset: function() {
                this.offsetParent = this.helper.offsetParent();
                var e = this.offsetParent.offset();
                return "absolute" == this.cssPosition && this.scrollParent[0] != document && t.contains(this.scrollParent[0], this.offsetParent[0]) && (e.left += this.scrollParent.scrollLeft(), e.top += this.scrollParent.scrollTop()), (this.offsetParent[0] == document.body || this.offsetParent[0].tagName && "html" == this.offsetParent[0].tagName.toLowerCase() && t.ui.ie) && (e = {
                    top: 0,
                    left: 0
                }), {
                    top: e.top + (parseInt(this.offsetParent.css("borderTopWidth"), 10) || 0),
                    left: e.left + (parseInt(this.offsetParent.css("borderLeftWidth"), 10) || 0)
                }
            },
            _getRelativeOffset: function() {
                if ("relative" == this.cssPosition) {
                    var t = this.element.position();
                    return {
                        top: t.top - (parseInt(this.helper.css("top"), 10) || 0) + this.scrollParent.scrollTop(),
                        left: t.left - (parseInt(this.helper.css("left"), 10) || 0) + this.scrollParent.scrollLeft()
                    }
                }
                return {
                    top: 0,
                    left: 0
                }
            },
            _cacheMargins: function() {
                this.margins = {
                    left: parseInt(this.element.css("marginLeft"), 10) || 0,
                    top: parseInt(this.element.css("marginTop"), 10) || 0,
                    right: parseInt(this.element.css("marginRight"), 10) || 0,
                    bottom: parseInt(this.element.css("marginBottom"), 10) || 0
                }
            },
            _cacheHelperProportions: function() {
                this.helperProportions = {
                    width: this.helper.outerWidth(),
                    height: this.helper.outerHeight()
                }
            },
            _setContainment: function() {
                var e = this.options;
                if ("parent" == e.containment && (e.containment = this.helper[0].parentNode), "document" != e.containment && "window" != e.containment || (this.containment = ["document" == e.containment ? 0 : t(window).scrollLeft() - this.offset.relative.left - this.offset.parent.left, "document" == e.containment ? 0 : t(window).scrollTop() - this.offset.relative.top - this.offset.parent.top, ("document" == e.containment ? 0 : t(window).scrollLeft()) + t("document" == e.containment ? document : window).width() - this.helperProportions.width - this.margins.left, ("document" == e.containment ? 0 : t(window).scrollTop()) + (t("document" == e.containment ? document : window).height() || document.body.parentNode.scrollHeight) - this.helperProportions.height - this.margins.top]), /^(document|window|parent)$/.test(e.containment) || e.containment.constructor == Array) e.containment.constructor == Array && (this.containment = e.containment);
                else {
                    var i = t(e.containment),
                        n = i[0];
                    if (!n) return;
                    var s = (i.offset(), "hidden" != t(n).css("overflow"));
                    this.containment = [(parseInt(t(n).css("borderLeftWidth"), 10) || 0) + (parseInt(t(n).css("paddingLeft"), 10) || 0), (parseInt(t(n).css("borderTopWidth"), 10) || 0) + (parseInt(t(n).css("paddingTop"), 10) || 0), (s ? Math.max(n.scrollWidth, n.offsetWidth) : n.offsetWidth) - (parseInt(t(n).css("borderLeftWidth"), 10) || 0) - (parseInt(t(n).css("paddingRight"), 10) || 0) - this.helperProportions.width - this.margins.left - this.margins.right, (s ? Math.max(n.scrollHeight, n.offsetHeight) : n.offsetHeight) - (parseInt(t(n).css("borderTopWidth"), 10) || 0) - (parseInt(t(n).css("paddingBottom"), 10) || 0) - this.helperProportions.height - this.margins.top - this.margins.bottom], this.relative_container = i
                }
            },
            _convertPositionTo: function(e, i) {
                i || (i = this.position);
                var n = "absolute" == e ? 1 : -1,
                    s = (this.options, "absolute" != this.cssPosition || this.scrollParent[0] != document && t.contains(this.scrollParent[0], this.offsetParent[0]) ? this.scrollParent : this.offsetParent),
                    o = /(html|body)/i.test(s[0].tagName);
                return {
                    top: i.top + this.offset.relative.top * n + this.offset.parent.top * n - ("fixed" == this.cssPosition ? -this.scrollParent.scrollTop() : o ? 0 : s.scrollTop()) * n,
                    left: i.left + this.offset.relative.left * n + this.offset.parent.left * n - ("fixed" == this.cssPosition ? -this.scrollParent.scrollLeft() : o ? 0 : s.scrollLeft()) * n
                }
            },
            _generatePosition: function(e) {
                var i = this.options,
                    n = "absolute" != this.cssPosition || this.scrollParent[0] != document && t.contains(this.scrollParent[0], this.offsetParent[0]) ? this.scrollParent : this.offsetParent,
                    s = /(html|body)/i.test(n[0].tagName),
                    o = e.pageX,
                    r = e.pageY;
                if (this.originalPosition) {
                    var a;
                    if (this.containment) {
                        if (this.relative_container) {
                            var l = this.relative_container.offset();
                            a = [this.containment[0] + l.left, this.containment[1] + l.top, this.containment[2] + l.left, this.containment[3] + l.top]
                        } else a = this.containment;
                        e.pageX - this.offset.click.left < a[0] && (o = a[0] + this.offset.click.left), e.pageY - this.offset.click.top < a[1] && (r = a[1] + this.offset.click.top), e.pageX - this.offset.click.left > a[2] && (o = a[2] + this.offset.click.left), e.pageY - this.offset.click.top > a[3] && (r = a[3] + this.offset.click.top)
                    }
                    if (i.grid) {
                        var h = i.grid[1] ? this.originalPageY + Math.round((r - this.originalPageY) / i.grid[1]) * i.grid[1] : this.originalPageY;
                        r = a && (h - this.offset.click.top < a[1] || h - this.offset.click.top > a[3]) ? h - this.offset.click.top < a[1] ? h + i.grid[1] : h - i.grid[1] : h;
                        var c = i.grid[0] ? this.originalPageX + Math.round((o - this.originalPageX) / i.grid[0]) * i.grid[0] : this.originalPageX;
                        o = a && (c - this.offset.click.left < a[0] || c - this.offset.click.left > a[2]) ? c - this.offset.click.left < a[0] ? c + i.grid[0] : c - i.grid[0] : c
                    }
                }
                return {
                    top: r - this.offset.click.top - this.offset.relative.top - this.offset.parent.top + ("fixed" == this.cssPosition ? -this.scrollParent.scrollTop() : s ? 0 : n.scrollTop()),
                    left: o - this.offset.click.left - this.offset.relative.left - this.offset.parent.left + ("fixed" == this.cssPosition ? -this.scrollParent.scrollLeft() : s ? 0 : n.scrollLeft())
                }
            },
            _clear: function() {
                this.helper.removeClass("ui-draggable-dragging"), this.helper[0] != this.element[0] && !this.cancelHelperRemoval && this.helper.remove(), this.helper = null, this.cancelHelperRemoval = !1
            },
            _trigger: function(e, i, n) {
                return n = n || this._uiHash(), t.ui.plugin.call(this, e, [i, n]), "drag" == e && (this.positionAbs = this._convertPositionTo("absolute")), t.Widget.prototype._trigger.call(this, e, i, n)
            },
            plugins: {},
            _uiHash: function(t) {
                return {
                    helper: this.helper,
                    position: this.position,
                    originalPosition: this.originalPosition,
                    offset: this.positionAbs
                }
            }
        }), t.ui.plugin.add("draggable", "connectToSortable", {
            start: function(e, i) {
                var n = t(this).data("draggable"),
                    s = n.options,
                    o = t.extend({}, i, {
                        item: n.element
                    });
                n.sortables = [], t(s.connectToSortable).each(function() {
                    var i = t.data(this, "sortable");
                    i && !i.options.disabled && (n.sortables.push({
                        instance: i,
                        shouldRevert: i.options.revert
                    }), i.refreshPositions(), i._trigger("activate", e, o))
                })
            },
            stop: function(e, i) {
                var n = t(this).data("draggable"),
                    s = t.extend({}, i, {
                        item: n.element
                    });
                t.each(n.sortables, function() {
                    this.instance.isOver ? (this.instance.isOver = 0, n.cancelHelperRemoval = !0, this.instance.cancelHelperRemoval = !1, this.shouldRevert && (this.instance.options.revert = !0), this.instance._mouseStop(e), this.instance.options.helper = this.instance.options._helper, "original" == n.options.helper && this.instance.currentItem.css({
                        top: "auto",
                        left: "auto"
                    })) : (this.instance.cancelHelperRemoval = !1, this.instance._trigger("deactivate", e, s))
                })
            },
            drag: function(e, i) {
                var n = t(this).data("draggable"),
                    s = this;
                t.each(n.sortables, function(o) {
                    var r = !1,
                        a = this;
                    this.instance.positionAbs = n.positionAbs, this.instance.helperProportions = n.helperProportions, this.instance.offset.click = n.offset.click, this.instance._intersectsWith(this.instance.containerCache) && (r = !0, t.each(n.sortables, function() {
                        return this.instance.positionAbs = n.positionAbs, this.instance.helperProportions = n.helperProportions, this.instance.offset.click = n.offset.click, this != a && this.instance._intersectsWith(this.instance.containerCache) && t.ui.contains(a.instance.element[0], this.instance.element[0]) && (r = !1), r
                    })), r ? (this.instance.isOver || (this.instance.isOver = 1, this.instance.currentItem = t(s).clone().removeAttr("id").appendTo(this.instance.element).data("sortable-item", !0), this.instance.options._helper = this.instance.options.helper, this.instance.options.helper = function() {
                        return i.helper[0]
                    }, e.target = this.instance.currentItem[0], this.instance._mouseCapture(e, !0), this.instance._mouseStart(e, !0, !0), this.instance.offset.click.top = n.offset.click.top, this.instance.offset.click.left = n.offset.click.left, this.instance.offset.parent.left -= n.offset.parent.left - this.instance.offset.parent.left, this.instance.offset.parent.top -= n.offset.parent.top - this.instance.offset.parent.top, n._trigger("toSortable", e), n.dropped = this.instance.element, n.currentItem = n.element, this.instance.fromOutside = n), this.instance.currentItem && this.instance._mouseDrag(e)) : this.instance.isOver && (this.instance.isOver = 0, this.instance.cancelHelperRemoval = !0, this.instance.options.revert = !1, this.instance._trigger("out", e, this.instance._uiHash(this.instance)), this.instance._mouseStop(e, !0), this.instance.options.helper = this.instance.options._helper, this.instance.currentItem.remove(), this.instance.placeholder && this.instance.placeholder.remove(), n._trigger("fromSortable", e), n.dropped = !1)
                })
            }
        }), t.ui.plugin.add("draggable", "cursor", {
            start: function(e, i) {
                var n = t("body"),
                    s = t(this).data("draggable").options;
                n.css("cursor") && (s._cursor = n.css("cursor")), n.css("cursor", s.cursor)
            },
            stop: function(e, i) {
                var n = t(this).data("draggable").options;
                n._cursor && t("body").css("cursor", n._cursor)
            }
        }), t.ui.plugin.add("draggable", "opacity", {
            start: function(e, i) {
                var n = t(i.helper),
                    s = t(this).data("draggable").options;
                n.css("opacity") && (s._opacity = n.css("opacity")), n.css("opacity", s.opacity)
            },
            stop: function(e, i) {
                var n = t(this).data("draggable").options;
                n._opacity && t(i.helper).css("opacity", n._opacity)
            }
        }), t.ui.plugin.add("draggable", "scroll", {
            start: function(e, i) {
                var n = t(this).data("draggable");
                n.scrollParent[0] != document && "HTML" != n.scrollParent[0].tagName && (n.overflowOffset = n.scrollParent.offset())
            },
            drag: function(e, i) {
                var n = t(this).data("draggable"),
                    s = n.options,
                    o = !1;
                n.scrollParent[0] != document && "HTML" != n.scrollParent[0].tagName ? (s.axis && "x" == s.axis || (n.overflowOffset.top + n.scrollParent[0].offsetHeight - e.pageY < s.scrollSensitivity ? n.scrollParent[0].scrollTop = o = n.scrollParent[0].scrollTop + s.scrollSpeed : e.pageY - n.overflowOffset.top < s.scrollSensitivity && (n.scrollParent[0].scrollTop = o = n.scrollParent[0].scrollTop - s.scrollSpeed)), s.axis && "y" == s.axis || (n.overflowOffset.left + n.scrollParent[0].offsetWidth - e.pageX < s.scrollSensitivity ? n.scrollParent[0].scrollLeft = o = n.scrollParent[0].scrollLeft + s.scrollSpeed : e.pageX - n.overflowOffset.left < s.scrollSensitivity && (n.scrollParent[0].scrollLeft = o = n.scrollParent[0].scrollLeft - s.scrollSpeed))) : (s.axis && "x" == s.axis || (e.pageY - t(document).scrollTop() < s.scrollSensitivity ? o = t(document).scrollTop(t(document).scrollTop() - s.scrollSpeed) : t(window).height() - (e.pageY - t(document).scrollTop()) < s.scrollSensitivity && (o = t(document).scrollTop(t(document).scrollTop() + s.scrollSpeed))), s.axis && "y" == s.axis || (e.pageX - t(document).scrollLeft() < s.scrollSensitivity ? o = t(document).scrollLeft(t(document).scrollLeft() - s.scrollSpeed) : t(window).width() - (e.pageX - t(document).scrollLeft()) < s.scrollSensitivity && (o = t(document).scrollLeft(t(document).scrollLeft() + s.scrollSpeed)))), !1 !== o && t.ui.ddmanager && !s.dropBehaviour && t.ui.ddmanager.prepareOffsets(n, e)
            }
        }), t.ui.plugin.add("draggable", "snap", {
            start: function(e, i) {
                var n = t(this).data("draggable"),
                    s = n.options;
                n.snapElements = [], t(s.snap.constructor != String ? s.snap.items || ":data(draggable)" : s.snap).each(function() {
                    var e = t(this),
                        i = e.offset();
                    this != n.element[0] && n.snapElements.push({
                        item: this,
                        width: e.outerWidth(),
                        height: e.outerHeight(),
                        top: i.top,
                        left: i.left
                    })
                })
            },
            drag: function(e, i) {
                for (var n = t(this).data("draggable"), s = n.options, o = s.snapTolerance, r = i.offset.left, a = r + n.helperProportions.width, l = i.offset.top, h = l + n.helperProportions.height, c = n.snapElements.length - 1; c >= 0; c--) {
                    var u = n.snapElements[c].left,
                        d = u + n.snapElements[c].width,
                        p = n.snapElements[c].top,
                        f = p + n.snapElements[c].height;
                    if (u - o < r && r < d + o && p - o < l && l < f + o || u - o < r && r < d + o && p - o < h && h < f + o || u - o < a && a < d + o && p - o < l && l < f + o || u - o < a && a < d + o && p - o < h && h < f + o) {
                        if ("inner" != s.snapMode) {
                            var g = Math.abs(p - h) <= o,
                                m = Math.abs(f - l) <= o,
                                v = Math.abs(u - a) <= o,
                                y = Math.abs(d - r) <= o;
                            g && (i.position.top = n._convertPositionTo("relative", {
                                top: p - n.helperProportions.height,
                                left: 0
                            }).top - n.margins.top), m && (i.position.top = n._convertPositionTo("relative", {
                                top: f,
                                left: 0
                            }).top - n.margins.top), v && (i.position.left = n._convertPositionTo("relative", {
                                top: 0,
                                left: u - n.helperProportions.width
                            }).left - n.margins.left), y && (i.position.left = n._convertPositionTo("relative", {
                                top: 0,
                                left: d
                            }).left - n.margins.left)
                        }
                        var b = g || m || v || y;
                        if ("outer" != s.snapMode) {
                            var g = Math.abs(p - l) <= o,
                                m = Math.abs(f - h) <= o,
                                v = Math.abs(u - r) <= o,
                                y = Math.abs(d - a) <= o;
                            g && (i.position.top = n._convertPositionTo("relative", {
                                top: p,
                                left: 0
                            }).top - n.margins.top), m && (i.position.top = n._convertPositionTo("relative", {
                                top: f - n.helperProportions.height,
                                left: 0
                            }).top - n.margins.top), v && (i.position.left = n._convertPositionTo("relative", {
                                top: 0,
                                left: u
                            }).left - n.margins.left), y && (i.position.left = n._convertPositionTo("relative", {
                                top: 0,
                                left: d - n.helperProportions.width
                            }).left - n.margins.left)
                        }!n.snapElements[c].snapping && (g || m || v || y || b) && n.options.snap.snap && n.options.snap.snap.call(n.element, e, t.extend(n._uiHash(), {
                            snapItem: n.snapElements[c].item
                        })), n.snapElements[c].snapping = g || m || v || y || b
                    } else n.snapElements[c].snapping && n.options.snap.release && n.options.snap.release.call(n.element, e, t.extend(n._uiHash(), {
                        snapItem: n.snapElements[c].item
                    })), n.snapElements[c].snapping = !1
                }
            }
        }), t.ui.plugin.add("draggable", "stack", {
            start: function(e, i) {
                var n = t(this).data("draggable").options,
                    s = t.makeArray(t(n.stack)).sort(function(e, i) {
                        return (parseInt(t(e).css("zIndex"), 10) || 0) - (parseInt(t(i).css("zIndex"), 10) || 0)
                    });
                if (s.length) {
                    var o = parseInt(s[0].style.zIndex) || 0;
                    t(s).each(function(t) {
                        this.style.zIndex = o + t
                    }), this[0].style.zIndex = o + s.length
                }
            }
        }), t.ui.plugin.add("draggable", "zIndex", {
            start: function(e, i) {
                var n = t(i.helper),
                    s = t(this).data("draggable").options;
                n.css("zIndex") && (s._zIndex = n.css("zIndex")), n.css("zIndex", s.zIndex)
            },
            stop: function(e, i) {
                var n = t(this).data("draggable").options;
                n._zIndex && t(i.helper).css("zIndex", n._zIndex)
            }
        })
    }(jQuery), function(t, e) {
        t.widget("ui.droppable", {
            version: "1.9.2",
            widgetEventPrefix: "drop",
            options: {
                accept: "*",
                activeClass: !1,
                addClasses: !0,
                greedy: !1,
                hoverClass: !1,
                scope: "default",
                tolerance: "intersect"
            },
            _create: function() {
                var e = this.options,
                    i = e.accept;
                this.isover = 0, this.isout = 1, this.accept = t.isFunction(i) ? i : function(t) {
                    return t.is(i)
                }, this.proportions = {
                    width: this.element[0].offsetWidth,
                    height: this.element[0].offsetHeight
                }, t.ui.ddmanager.droppables[e.scope] = t.ui.ddmanager.droppables[e.scope] || [], t.ui.ddmanager.droppables[e.scope].push(this), e.addClasses && this.element.addClass("ui-droppable")
            },
            _destroy: function() {
                for (var e = t.ui.ddmanager.droppables[this.options.scope], i = 0; i < e.length; i++) e[i] == this && e.splice(i, 1);
                this.element.removeClass("ui-droppable ui-droppable-disabled")
            },
            _setOption: function(e, i) {
                "accept" == e && (this.accept = t.isFunction(i) ? i : function(t) {
                    return t.is(i)
                }), t.Widget.prototype._setOption.apply(this, arguments)
            },
            _activate: function(e) {
                var i = t.ui.ddmanager.current;
                this.options.activeClass && this.element.addClass(this.options.activeClass), i && this._trigger("activate", e, this.ui(i))
            },
            _deactivate: function(e) {
                var i = t.ui.ddmanager.current;
                this.options.activeClass && this.element.removeClass(this.options.activeClass), i && this._trigger("deactivate", e, this.ui(i))
            },
            _over: function(e) {
                var i = t.ui.ddmanager.current;
                i && (i.currentItem || i.element)[0] != this.element[0] && this.accept.call(this.element[0], i.currentItem || i.element) && (this.options.hoverClass && this.element.addClass(this.options.hoverClass), this._trigger("over", e, this.ui(i)))
            },
            _out: function(e) {
                var i = t.ui.ddmanager.current;
                i && (i.currentItem || i.element)[0] != this.element[0] && this.accept.call(this.element[0], i.currentItem || i.element) && (this.options.hoverClass && this.element.removeClass(this.options.hoverClass), this._trigger("out", e, this.ui(i)))
            },
            _drop: function(e, i) {
                var n = i || t.ui.ddmanager.current;
                if (!n || (n.currentItem || n.element)[0] == this.element[0]) return !1;
                var s = !1;
                return this.element.find(":data(droppable)").not(".ui-draggable-dragging").each(function() {
                    var e = t.data(this, "droppable");
                    if (e.options.greedy && !e.options.disabled && e.options.scope == n.options.scope && e.accept.call(e.element[0], n.currentItem || n.element) && t.ui.intersect(n, t.extend(e, {
                            offset: e.element.offset()
                        }), e.options.tolerance)) return s = !0, !1
                }), !s && (!!this.accept.call(this.element[0], n.currentItem || n.element) && (this.options.activeClass && this.element.removeClass(this.options.activeClass), this.options.hoverClass && this.element.removeClass(this.options.hoverClass), this._trigger("drop", e, this.ui(n)), this.element))
            },
            ui: function(t) {
                return {
                    draggable: t.currentItem || t.element,
                    helper: t.helper,
                    position: t.position,
                    offset: t.positionAbs
                }
            }
        }), t.ui.intersect = function(e, i, n) {
            if (!i.offset) return !1;
            var s = (e.positionAbs || e.position.absolute).left,
                o = s + e.helperProportions.width,
                r = (e.positionAbs || e.position.absolute).top,
                a = r + e.helperProportions.height,
                l = i.offset.left,
                h = l + i.proportions.width,
                c = i.offset.top,
                u = c + i.proportions.height;
            switch (n) {
                case "fit":
                    return l <= s && o <= h && c <= r && a <= u;
                case "intersect":
                    return l < s + e.helperProportions.width / 2 && o - e.helperProportions.width / 2 < h && c < r + e.helperProportions.height / 2 && a - e.helperProportions.height / 2 < u;
                case "pointer":
                    var d = (e.positionAbs || e.position.absolute).left + (e.clickOffset || e.offset.click).left,
                        p = (e.positionAbs || e.position.absolute).top + (e.clickOffset || e.offset.click).top;
                    return t.ui.isOver(p, d, c, l, i.proportions.height, i.proportions.width);
                case "touch":
                    return (r >= c && r <= u || a >= c && a <= u || r < c && a > u) && (s >= l && s <= h || o >= l && o <= h || s < l && o > h);
                default:
                    return !1
            }
        }, t.ui.ddmanager = {
            current: null,
            droppables: {
                default: []
            },
            prepareOffsets: function(e, i) {
                var n = t.ui.ddmanager.droppables[e.options.scope] || [],
                    s = i ? i.type : null,
                    o = (e.currentItem || e.element).find(":data(droppable)").andSelf();
                t: for (var r = 0; r < n.length; r++)
                    if (!(n[r].options.disabled || e && !n[r].accept.call(n[r].element[0], e.currentItem || e.element))) {
                        for (var a = 0; a < o.length; a++)
                            if (o[a] == n[r].element[0]) {
                                n[r].proportions.height = 0;
                                continue t
                            } n[r].visible = "none" != n[r].element.css("display"), n[r].visible && ("mousedown" == s && n[r]._activate.call(n[r], i), n[r].offset = n[r].element.offset(), n[r].proportions = {
                            width: n[r].element[0].offsetWidth,
                            height: n[r].element[0].offsetHeight
                        })
                    }
            },
            drop: function(e, i) {
                var n = !1;
                return t.each(t.ui.ddmanager.droppables[e.options.scope] || [], function() {
                    this.options && (!this.options.disabled && this.visible && t.ui.intersect(e, this, this.options.tolerance) && (n = this._drop.call(this, i) || n), !this.options.disabled && this.visible && this.accept.call(this.element[0], e.currentItem || e.element) && (this.isout = 1, this.isover = 0, this._deactivate.call(this, i)))
                }), n
            },
            dragStart: function(e, i) {
                e.element.parentsUntil("body").bind("scroll.droppable", function() {
                    e.options.refreshPositions || t.ui.ddmanager.prepareOffsets(e, i)
                })
            },
            drag: function(e, i) {
                e.options.refreshPositions && t.ui.ddmanager.prepareOffsets(e, i), t.each(t.ui.ddmanager.droppables[e.options.scope] || [], function() {
                    if (!this.options.disabled && !this.greedyChild && this.visible) {
                        var n = t.ui.intersect(e, this, this.options.tolerance),
                            s = n || 1 != this.isover ? n && 0 == this.isover ? "isover" : null : "isout";
                        if (s) {
                            var o;
                            if (this.options.greedy) {
                                var r = this.options.scope,
                                    a = this.element.parents(":data(droppable)").filter(function() {
                                        return t.data(this, "droppable").options.scope === r
                                    });
                                a.length && (o = t.data(a[0], "droppable"), o.greedyChild = "isover" == s ? 1 : 0)
                            }
                            o && "isover" == s && (o.isover = 0, o.isout = 1, o._out.call(o, i)), this[s] = 1, this["isout" == s ? "isover" : "isout"] = 0, this["isover" == s ? "_over" : "_out"].call(this, i), o && "isout" == s && (o.isout = 0, o.isover = 1, o._over.call(o, i))
                        }
                    }
                })
            },
            dragStop: function(e, i) {
                e.element.parentsUntil("body").unbind("scroll.droppable"), e.options.refreshPositions || t.ui.ddmanager.prepareOffsets(e, i)
            }
        }
    }(jQuery), function(t, e) {
        t.widget("ui.resizable", t.ui.mouse, {
            version: "1.9.2",
            widgetEventPrefix: "resize",
            options: {
                alsoResize: !1,
                animate: !1,
                animateDuration: "slow",
                animateEasing: "swing",
                aspectRatio: !1,
                autoHide: !1,
                containment: !1,
                ghost: !1,
                grid: !1,
                handles: "e,s,se",
                helper: !1,
                maxHeight: null,
                maxWidth: null,
                minHeight: 10,
                minWidth: 10,
                zIndex: 1e3
            },
            _create: function() {
                var e = this,
                    i = this.options;
                if (this.element.addClass("ui-resizable"), t.extend(this, {
                        _aspectRatio: !!i.aspectRatio,
                        aspectRatio: i.aspectRatio,
                        originalElement: this.element,
                        _proportionallyResizeElements: [],
                        _helper: i.helper || i.ghost || i.animate ? i.helper || "ui-resizable-helper" : null
                    }), this.element[0].nodeName.match(/canvas|textarea|input|select|button|img/i) && (this.element.wrap(t('<div class="ui-wrapper" style="overflow: hidden;"></div>').css({
                        position: this.element.css("position"),
                        width: this.element.outerWidth(),
                        height: this.element.outerHeight(),
                        top: this.element.css("top"),
                        left: this.element.css("left")
                    })), this.element = this.element.parent().data("resizable", this.element.data("resizable")), this.elementIsWrapper = !0, this.element.css({
                        marginLeft: this.originalElement.css("marginLeft"),
                        marginTop: this.originalElement.css("marginTop"),
                        marginRight: this.originalElement.css("marginRight"),
                        marginBottom: this.originalElement.css("marginBottom")
                    }), this.originalElement.css({
                        marginLeft: 0,
                        marginTop: 0,
                        marginRight: 0,
                        marginBottom: 0
                    }), this.originalResizeStyle = this.originalElement.css("resize"), this.originalElement.css("resize", "none"), this._proportionallyResizeElements.push(this.originalElement.css({
                        position: "static",
                        zoom: 1,
                        display: "block"
                    })), this.originalElement.css({
                        margin: this.originalElement.css("margin")
                    }), this._proportionallyResize()), this.handles = i.handles || (t(".ui-resizable-handle", this.element).length ? {
                        n: ".ui-resizable-n",
                        e: ".ui-resizable-e",
                        s: ".ui-resizable-s",
                        w: ".ui-resizable-w",
                        se: ".ui-resizable-se",
                        sw: ".ui-resizable-sw",
                        ne: ".ui-resizable-ne",
                        nw: ".ui-resizable-nw"
                    } : "e,s,se"), this.handles.constructor == String) {
                    "all" == this.handles && (this.handles = "n,e,s,w,se,sw,ne,nw");
                    var n = this.handles.split(",");
                    this.handles = {};
                    for (var s = 0; s < n.length; s++) {
                        var o = t.trim(n[s]),
                            r = "ui-resizable-" + o,
                            a = t('<div class="ui-resizable-handle ' + r + '"></div>');
                        a.css({
                            zIndex: i.zIndex
                        }), "se" == o && a.addClass("ui-icon ui-icon-gripsmall-diagonal-se"), this.handles[o] = ".ui-resizable-" + o, this.element.append(a)
                    }
                }
                this._renderAxis = function(e) {
                    e = e || this.element;
                    for (var i in this.handles) {
                        if (this.handles[i].constructor == String && (this.handles[i] = t(this.handles[i], this.element).show()), this.elementIsWrapper && this.originalElement[0].nodeName.match(/textarea|input|select|button/i)) {
                            var n = t(this.handles[i], this.element),
                                s = 0;
                            s = /sw|ne|nw|se|n|s/.test(i) ? n.outerHeight() : n.outerWidth();
                            var o = ["padding", /ne|nw|n/.test(i) ? "Top" : /se|sw|s/.test(i) ? "Bottom" : /^e$/.test(i) ? "Right" : "Left"].join("");
                            e.css(o, s), this._proportionallyResize()
                        }
                        t(this.handles[i]).length
                    }
                }, this._renderAxis(this.element), this._handles = t(".ui-resizable-handle", this.element).disableSelection(), this._handles.mouseover(function() {
                    if (!e.resizing) {
                        if (this.className) var t = this.className.match(/ui-resizable-(se|sw|ne|nw|n|e|s|w)/i);
                        e.axis = t && t[1] ? t[1] : "se"
                    }
                }), i.autoHide && (this._handles.hide(), t(this.element).addClass("ui-resizable-autohide").mouseenter(function() {
                    i.disabled || (t(this).removeClass("ui-resizable-autohide"), e._handles.show())
                }).mouseleave(function() {
                    i.disabled || e.resizing || (t(this).addClass("ui-resizable-autohide"), e._handles.hide())
                })), this._mouseInit()
            },
            _destroy: function() {
                this._mouseDestroy();
                var e = function(e) {
                    t(e).removeClass("ui-resizable ui-resizable-disabled ui-resizable-resizing").removeData("resizable").removeData("ui-resizable").unbind(".resizable").find(".ui-resizable-handle").remove()
                };
                if (this.elementIsWrapper) {
                    e(this.element);
                    var i = this.element;
                    this.originalElement.css({
                        position: i.css("position"),
                        width: i.outerWidth(),
                        height: i.outerHeight(),
                        top: i.css("top"),
                        left: i.css("left")
                    }).insertAfter(i), i.remove()
                }
                return this.originalElement.css("resize", this.originalResizeStyle), e(this.originalElement), this
            },
            _mouseCapture: function(e) {
                var i = !1;
                for (var n in this.handles) t(this.handles[n])[0] == e.target && (i = !0);
                return !this.options.disabled && i
            },
            _mouseStart: function(e) {
                var n = this.options,
                    s = this.element.position(),
                    o = this.element;
                this.resizing = !0, this.documentScroll = {
                    top: t(document).scrollTop(),
                    left: t(document).scrollLeft()
                }, (o.is(".ui-draggable") || /absolute/.test(o.css("position"))) && o.css({
                    position: "absolute",
                    top: s.top,
                    left: s.left
                }), this._renderProxy();
                var r = i(this.helper.css("left")),
                    a = i(this.helper.css("top"));
                n.containment && (r += t(n.containment).scrollLeft() || 0, a += t(n.containment).scrollTop() || 0), this.offset = this.helper.offset(), this.position = {
                    left: r,
                    top: a
                }, this.size = this._helper ? {
                    width: o.outerWidth(),
                    height: o.outerHeight()
                } : {
                    width: o.width(),
                    height: o.height()
                }, this.originalSize = this._helper ? {
                    width: o.outerWidth(),
                    height: o.outerHeight()
                } : {
                    width: o.width(),
                    height: o.height()
                }, this.originalPosition = {
                    left: r,
                    top: a
                }, this.sizeDiff = {
                    width: o.outerWidth() - o.width(),
                    height: o.outerHeight() - o.height()
                }, this.originalMousePosition = {
                    left: e.pageX,
                    top: e.pageY
                }, this.aspectRatio = "number" == typeof n.aspectRatio ? n.aspectRatio : this.originalSize.width / this.originalSize.height || 1;
                var l = t(".ui-resizable-" + this.axis).css("cursor");
                return t("body").css("cursor", "auto" == l ? this.axis + "-resize" : l), o.addClass("ui-resizable-resizing"), this._propagate("start", e), !0
            },
            _mouseDrag: function(t) {
                var e = this.helper,
                    i = (this.options, this.originalMousePosition),
                    n = this.axis,
                    s = t.pageX - i.left || 0,
                    o = t.pageY - i.top || 0,
                    r = this._change[n];
                if (!r) return !1;
                var a = r.apply(this, [t, s, o]);
                return this._updateVirtualBoundaries(t.shiftKey), (this._aspectRatio || t.shiftKey) && (a = this._updateRatio(a, t)), a = this._respectSize(a, t), this._propagate("resize", t), e.css({
                    top: this.position.top + "px",
                    left: this.position.left + "px",
                    width: this.size.width + "px",
                    height: this.size.height + "px"
                }), !this._helper && this._proportionallyResizeElements.length && this._proportionallyResize(), this._updateCache(a), this._trigger("resize", t, this.ui()), !1
            },
            _mouseStop: function(e) {
                this.resizing = !1;
                var i = this.options,
                    n = this;
                if (this._helper) {
                    var s = this._proportionallyResizeElements,
                        o = s.length && /textarea/i.test(s[0].nodeName),
                        r = o && t.ui.hasScroll(s[0], "left") ? 0 : n.sizeDiff.height,
                        a = o ? 0 : n.sizeDiff.width,
                        l = {
                            width: n.helper.width() - a,
                            height: n.helper.height() - r
                        },
                        h = parseInt(n.element.css("left"), 10) + (n.position.left - n.originalPosition.left) || null,
                        c = parseInt(n.element.css("top"), 10) + (n.position.top - n.originalPosition.top) || null;
                    i.animate || this.element.css(t.extend(l, {
                        top: c,
                        left: h
                    })), n.helper.height(n.size.height), n.helper.width(n.size.width), this._helper && !i.animate && this._proportionallyResize()
                }
                return t("body").css("cursor", "auto"), this.element.removeClass("ui-resizable-resizing"), this._propagate("stop", e), this._helper && this.helper.remove(), !1
            },
            _updateVirtualBoundaries: function(t) {
                var e, i, s, o, r, a = this.options;
                r = {
                    minWidth: n(a.minWidth) ? a.minWidth : 0,
                    maxWidth: n(a.maxWidth) ? a.maxWidth : 1 / 0,
                    minHeight: n(a.minHeight) ? a.minHeight : 0,
                    maxHeight: n(a.maxHeight) ? a.maxHeight : 1 / 0
                }, (this._aspectRatio || t) && (e = r.minHeight * this.aspectRatio, s = r.minWidth / this.aspectRatio, i = r.maxHeight * this.aspectRatio, o = r.maxWidth / this.aspectRatio, e > r.minWidth && (r.minWidth = e), s > r.minHeight && (r.minHeight = s), i < r.maxWidth && (r.maxWidth = i), o < r.maxHeight && (r.maxHeight = o)), this._vBoundaries = r
            },
            _updateCache: function(t) {
                this.options;
                this.offset = this.helper.offset(), n(t.left) && (this.position.left = t.left), n(t.top) && (this.position.top = t.top), n(t.height) && (this.size.height = t.height), n(t.width) && (this.size.width = t.width)
            },
            _updateRatio: function(t, e) {
                var i = (this.options, this.position),
                    s = this.size,
                    o = this.axis;
                return n(t.height) ? t.width = t.height * this.aspectRatio : n(t.width) && (t.height = t.width / this.aspectRatio), "sw" == o && (t.left = i.left + (s.width - t.width), t.top = null), "nw" == o && (t.top = i.top + (s.height - t.height), t.left = i.left + (s.width - t.width)), t
            },
            _respectSize: function(t, e) {
                var i = (this.helper, this._vBoundaries),
                    s = (this._aspectRatio || e.shiftKey, this.axis),
                    o = n(t.width) && i.maxWidth && i.maxWidth < t.width,
                    r = n(t.height) && i.maxHeight && i.maxHeight < t.height,
                    a = n(t.width) && i.minWidth && i.minWidth > t.width,
                    l = n(t.height) && i.minHeight && i.minHeight > t.height;
                a && (t.width = i.minWidth), l && (t.height = i.minHeight), o && (t.width = i.maxWidth), r && (t.height = i.maxHeight);
                var h = this.originalPosition.left + this.originalSize.width,
                    c = this.position.top + this.size.height,
                    u = /sw|nw|w/.test(s),
                    d = /nw|ne|n/.test(s);
                a && u && (t.left = h - i.minWidth), o && u && (t.left = h - i.maxWidth), l && d && (t.top = c - i.minHeight), r && d && (t.top = c - i.maxHeight);
                var p = !t.width && !t.height;
                return p && !t.left && t.top ? t.top = null : p && !t.top && t.left && (t.left = null), t
            },
            _proportionallyResize: function() {
                this.options;
                if (this._proportionallyResizeElements.length)
                    for (var e = this.helper || this.element, i = 0; i < this._proportionallyResizeElements.length; i++) {
                        var n = this._proportionallyResizeElements[i];
                        if (!this.borderDif) {
                            var s = [n.css("borderTopWidth"), n.css("borderRightWidth"), n.css("borderBottomWidth"), n.css("borderLeftWidth")],
                                o = [n.css("paddingTop"), n.css("paddingRight"), n.css("paddingBottom"), n.css("paddingLeft")];
                            this.borderDif = t.map(s, function(t, e) {
                                return (parseInt(t, 10) || 0) + (parseInt(o[e], 10) || 0)
                            })
                        }
                        n.css({
                            height: e.height() - this.borderDif[0] - this.borderDif[2] || 0,
                            width: e.width() - this.borderDif[1] - this.borderDif[3] || 0
                        })
                    }
            },
            _renderProxy: function() {
                var e = this.element,
                    i = this.options;
                if (this.elementOffset = e.offset(), this._helper) {
                    this.helper = this.helper || t('<div style="overflow:hidden;"></div>');
                    var n = t.ui.ie6 ? 1 : 0,
                        s = t.ui.ie6 ? 2 : -1;
                    this.helper.addClass(this._helper).css({
                        width: this.element.outerWidth() + s,
                        height: this.element.outerHeight() + s,
                        position: "absolute",
                        left: this.elementOffset.left - n + "px",
                        top: this.elementOffset.top - n + "px",
                        zIndex: ++i.zIndex
                    }), this.helper.appendTo("body").disableSelection()
                } else this.helper = this.element
            },
            _change: {
                e: function(t, e, i) {
                    return {
                        width: this.originalSize.width + e
                    }
                },
                w: function(t, e, i) {
                    var n = (this.options, this.originalSize);
                    return {
                        left: this.originalPosition.left + e,
                        width: n.width - e
                    }
                },
                n: function(t, e, i) {
                    var n = (this.options, this.originalSize);
                    return {
                        top: this.originalPosition.top + i,
                        height: n.height - i
                    }
                },
                s: function(t, e, i) {
                    return {
                        height: this.originalSize.height + i
                    }
                },
                se: function(e, i, n) {
                    return t.extend(this._change.s.apply(this, arguments), this._change.e.apply(this, [e, i, n]))
                },
                sw: function(e, i, n) {
                    return t.extend(this._change.s.apply(this, arguments), this._change.w.apply(this, [e, i, n]))
                },
                ne: function(e, i, n) {
                    return t.extend(this._change.n.apply(this, arguments), this._change.e.apply(this, [e, i, n]))
                },
                nw: function(e, i, n) {
                    return t.extend(this._change.n.apply(this, arguments), this._change.w.apply(this, [e, i, n]))
                }
            },
            _propagate: function(e, i) {
                t.ui.plugin.call(this, e, [i, this.ui()]), "resize" != e && this._trigger(e, i, this.ui())
            },
            plugins: {},
            ui: function() {
                return {
                    originalElement: this.originalElement,
                    element: this.element,
                    helper: this.helper,
                    position: this.position,
                    size: this.size,
                    originalSize: this.originalSize,
                    originalPosition: this.originalPosition
                }
            }
        }), t.ui.plugin.add("resizable", "alsoResize", {
            start: function(e, i) {
                var n = t(this).data("resizable"),
                    s = n.options,
                    o = function(e) {
                        t(e).each(function() {
                            var e = t(this);
                            e.data("resizable-alsoresize", {
                                width: parseInt(e.width(), 10),
                                height: parseInt(e.height(), 10),
                                left: parseInt(e.css("left"), 10),
                                top: parseInt(e.css("top"), 10)
                            })
                        })
                    };
                "object" != typeof s.alsoResize || s.alsoResize.parentNode ? o(s.alsoResize) : s.alsoResize.length ? (s.alsoResize = s.alsoResize[0], o(s.alsoResize)) : t.each(s.alsoResize, function(t) {
                    o(t)
                })
            },
            resize: function(e, i) {
                var n = t(this).data("resizable"),
                    s = n.options,
                    o = n.originalSize,
                    r = n.originalPosition,
                    a = {
                        height: n.size.height - o.height || 0,
                        width: n.size.width - o.width || 0,
                        top: n.position.top - r.top || 0,
                        left: n.position.left - r.left || 0
                    },
                    l = function(e, n) {
                        t(e).each(function() {
                            var e = t(this),
                                s = t(this).data("resizable-alsoresize"),
                                o = {},
                                r = n && n.length ? n : e.parents(i.originalElement[0]).length ? ["width", "height"] : ["width", "height", "top", "left"];
                            t.each(r, function(t, e) {
                                var i = (s[e] || 0) + (a[e] || 0);
                                i && i >= 0 && (o[e] = i || null)
                            }), e.css(o)
                        })
                    };
                "object" != typeof s.alsoResize || s.alsoResize.nodeType ? l(s.alsoResize) : t.each(s.alsoResize, function(t, e) {
                    l(t, e)
                })
            },
            stop: function(e, i) {
                t(this).removeData("resizable-alsoresize")
            }
        }), t.ui.plugin.add("resizable", "animate", {
            stop: function(e, i) {
                var n = t(this).data("resizable"),
                    s = n.options,
                    o = n._proportionallyResizeElements,
                    r = o.length && /textarea/i.test(o[0].nodeName),
                    a = r && t.ui.hasScroll(o[0], "left") ? 0 : n.sizeDiff.height,
                    l = r ? 0 : n.sizeDiff.width,
                    h = {
                        width: n.size.width - l,
                        height: n.size.height - a
                    },
                    c = parseInt(n.element.css("left"), 10) + (n.position.left - n.originalPosition.left) || null,
                    u = parseInt(n.element.css("top"), 10) + (n.position.top - n.originalPosition.top) || null;
                n.element.animate(t.extend(h, u && c ? {
                    top: u,
                    left: c
                } : {}), {
                    duration: s.animateDuration,
                    easing: s.animateEasing,
                    step: function() {
                        var i = {
                            width: parseInt(n.element.css("width"), 10),
                            height: parseInt(n.element.css("height"), 10),
                            top: parseInt(n.element.css("top"), 10),
                            left: parseInt(n.element.css("left"), 10)
                        };
                        o && o.length && t(o[0]).css({
                            width: i.width,
                            height: i.height
                        }), n._updateCache(i), n._propagate("resize", e)
                    }
                })
            }
        }), t.ui.plugin.add("resizable", "containment", {
            start: function(e, n) {
                var s = t(this).data("resizable"),
                    o = s.options,
                    r = s.element,
                    a = o.containment,
                    l = a instanceof t ? a.get(0) : /parent/.test(a) ? r.parent().get(0) : a;
                if (l)
                    if (s.containerElement = t(l), /document/.test(a) || a == document) s.containerOffset = {
                        left: 0,
                        top: 0
                    }, s.containerPosition = {
                        left: 0,
                        top: 0
                    }, s.parentData = {
                        element: t(document),
                        left: 0,
                        top: 0,
                        width: t(document).width(),
                        height: t(document).height() || document.body.parentNode.scrollHeight
                    };
                    else {
                        var h = t(l),
                            c = [];
                        t(["Top", "Right", "Left", "Bottom"]).each(function(t, e) {
                            c[t] = i(h.css("padding" + e))
                        }), s.containerOffset = h.offset(), s.containerPosition = h.position(), s.containerSize = {
                            height: h.innerHeight() - c[3],
                            width: h.innerWidth() - c[1]
                        };
                        var u = s.containerOffset,
                            d = s.containerSize.height,
                            p = s.containerSize.width,
                            f = t.ui.hasScroll(l, "left") ? l.scrollWidth : p,
                            g = t.ui.hasScroll(l) ? l.scrollHeight : d;
                        s.parentData = {
                            element: l,
                            left: u.left,
                            top: u.top,
                            width: f,
                            height: g
                        }
                    }
            },
            resize: function(e, i) {
                var n = t(this).data("resizable"),
                    s = n.options,
                    o = (n.containerSize, n.containerOffset),
                    r = (n.size, n.position),
                    a = n._aspectRatio || e.shiftKey,
                    l = {
                        top: 0,
                        left: 0
                    },
                    h = n.containerElement;
                h[0] != document && /static/.test(h.css("position")) && (l = o), r.left < (n._helper ? o.left : 0) && (n.size.width = n.size.width + (n._helper ? n.position.left - o.left : n.position.left - l.left), a && (n.size.height = n.size.width / n.aspectRatio), n.position.left = s.helper ? o.left : 0), r.top < (n._helper ? o.top : 0) && (n.size.height = n.size.height + (n._helper ? n.position.top - o.top : n.position.top), a && (n.size.width = n.size.height * n.aspectRatio), n.position.top = n._helper ? o.top : 0), n.offset.left = n.parentData.left + n.position.left, n.offset.top = n.parentData.top + n.position.top;
                var c = Math.abs((n._helper, n.offset.left - l.left + n.sizeDiff.width)),
                    u = Math.abs((n._helper ? n.offset.top - l.top : n.offset.top - o.top) + n.sizeDiff.height),
                    d = n.containerElement.get(0) == n.element.parent().get(0),
                    p = /relative|absolute/.test(n.containerElement.css("position"));
                d && p && (c -= n.parentData.left), c + n.size.width >= n.parentData.width && (n.size.width = n.parentData.width - c, a && (n.size.height = n.size.width / n.aspectRatio)), u + n.size.height >= n.parentData.height && (n.size.height = n.parentData.height - u, a && (n.size.width = n.size.height * n.aspectRatio))
            },
            stop: function(e, i) {
                var n = t(this).data("resizable"),
                    s = n.options,
                    o = (n.position, n.containerOffset),
                    r = n.containerPosition,
                    a = n.containerElement,
                    l = t(n.helper),
                    h = l.offset(),
                    c = l.outerWidth() - n.sizeDiff.width,
                    u = l.outerHeight() - n.sizeDiff.height;
                n._helper && !s.animate && /relative/.test(a.css("position")) && t(this).css({
                    left: h.left - r.left - o.left,
                    width: c,
                    height: u
                }), n._helper && !s.animate && /static/.test(a.css("position")) && t(this).css({
                    left: h.left - r.left - o.left,
                    width: c,
                    height: u
                })
            }
        }), t.ui.plugin.add("resizable", "ghost", {
            start: function(e, i) {
                var n = t(this).data("resizable"),
                    s = n.options,
                    o = n.size;
                n.ghost = n.originalElement.clone(), n.ghost.css({
                    opacity: .25,
                    display: "block",
                    position: "relative",
                    height: o.height,
                    width: o.width,
                    margin: 0,
                    left: 0,
                    top: 0
                }).addClass("ui-resizable-ghost").addClass("string" == typeof s.ghost ? s.ghost : ""), n.ghost.appendTo(n.helper)
            },
            resize: function(e, i) {
                var n = t(this).data("resizable");
                n.options;
                n.ghost && n.ghost.css({
                    position: "relative",
                    height: n.size.height,
                    width: n.size.width
                })
            },
            stop: function(e, i) {
                var n = t(this).data("resizable");
                n.options;
                n.ghost && n.helper && n.helper.get(0).removeChild(n.ghost.get(0))
            }
        }), t.ui.plugin.add("resizable", "grid", {
            resize: function(e, i) {
                var n = t(this).data("resizable"),
                    s = n.options,
                    o = n.size,
                    r = n.originalSize,
                    a = n.originalPosition,
                    l = n.axis;
                s._aspectRatio || e.shiftKey;
                s.grid = "number" == typeof s.grid ? [s.grid, s.grid] : s.grid;
                var h = Math.round((o.width - r.width) / (s.grid[0] || 1)) * (s.grid[0] || 1),
                    c = Math.round((o.height - r.height) / (s.grid[1] || 1)) * (s.grid[1] || 1);
                /^(se|s|e)$/.test(l) ? (n.size.width = r.width + h, n.size.height = r.height + c) : /^(ne)$/.test(l) ? (n.size.width = r.width + h, n.size.height = r.height + c, n.position.top = a.top - c) : /^(sw)$/.test(l) ? (n.size.width = r.width + h, n.size.height = r.height + c, n.position.left = a.left - h) : (n.size.width = r.width + h, n.size.height = r.height + c, n.position.top = a.top - c, n.position.left = a.left - h)
            }
        });
        var i = function(t) {
                return parseInt(t, 10) || 0
            },
            n = function(t) {
                return !isNaN(parseInt(t, 10))
            }
    }(jQuery), function(t, e) {
        t.widget("ui.selectable", t.ui.mouse, {
            version: "1.9.2",
            options: {
                appendTo: "body",
                autoRefresh: !0,
                distance: 0,
                filter: "*",
                tolerance: "touch"
            },
            _create: function() {
                var e = this;
                this.element.addClass("ui-selectable"), this.dragged = !1;
                var i;
                this.refresh = function() {
                    i = t(e.options.filter, e.element[0]), i.addClass("ui-selectee"), i.each(function() {
                        var e = t(this),
                            i = e.offset();
                        t.data(this, "selectable-item", {
                            element: this,
                            $element: e,
                            left: i.left,
                            top: i.top,
                            right: i.left + e.outerWidth(),
                            bottom: i.top + e.outerHeight(),
                            startselected: !1,
                            selected: e.hasClass("ui-selected"),
                            selecting: e.hasClass("ui-selecting"),
                            unselecting: e.hasClass("ui-unselecting")
                        })
                    })
                }, this.refresh(), this.selectees = i.addClass("ui-selectee"), this._mouseInit(), this.helper = t("<div class='ui-selectable-helper'></div>")
            },
            _destroy: function() {
                this.selectees.removeClass("ui-selectee").removeData("selectable-item"), this.element.removeClass("ui-selectable ui-selectable-disabled"), this._mouseDestroy()
            },
            _mouseStart: function(e) {
                var i = this;
                if (this.opos = [e.pageX, e.pageY], !this.options.disabled) {
                    var n = this.options;
                    this.selectees = t(n.filter, this.element[0]), this._trigger("start", e), t(n.appendTo).append(this.helper), this.helper.css({
                        left: e.clientX,
                        top: e.clientY,
                        width: 0,
                        height: 0
                    }), n.autoRefresh && this.refresh(), this.selectees.filter(".ui-selected").each(function() {
                        var n = t.data(this, "selectable-item");
                        n.startselected = !0, !e.metaKey && !e.ctrlKey && (n.$element.removeClass("ui-selected"), n.selected = !1, n.$element.addClass("ui-unselecting"), n.unselecting = !0, i._trigger("unselecting", e, {
                            unselecting: n.element
                        }))
                    }), t(e.target).parents().andSelf().each(function() {
                        var n = t.data(this, "selectable-item");
                        if (n) {
                            var s = !e.metaKey && !e.ctrlKey || !n.$element.hasClass("ui-selected");
                            return n.$element.removeClass(s ? "ui-unselecting" : "ui-selected").addClass(s ? "ui-selecting" : "ui-unselecting"), n.unselecting = !s, n.selecting = s, n.selected = s, s ? i._trigger("selecting", e, {
                                selecting: n.element
                            }) : i._trigger("unselecting", e, {
                                unselecting: n.element
                            }), !1
                        }
                    })
                }
            },
            _mouseDrag: function(e) {
                var i = this;
                if (this.dragged = !0, !this.options.disabled) {
                    var n = this.options,
                        s = this.opos[0],
                        o = this.opos[1],
                        r = e.pageX,
                        a = e.pageY;
                    if (s > r) {
                        var l = r;
                        r = s, s = l
                    }
                    if (o > a) {
                        var l = a;
                        a = o, o = l
                    }
                    return this.helper.css({
                        left: s,
                        top: o,
                        width: r - s,
                        height: a - o
                    }), this.selectees.each(function() {
                        var l = t.data(this, "selectable-item");
                        if (l && l.element != i.element[0]) {
                            var h = !1;
                            "touch" == n.tolerance ? h = !(l.left > r || l.right < s || l.top > a || l.bottom < o) : "fit" == n.tolerance && (h = l.left > s && l.right < r && l.top > o && l.bottom < a), h ? (l.selected && (l.$element.removeClass("ui-selected"), l.selected = !1), l.unselecting && (l.$element.removeClass("ui-unselecting"), l.unselecting = !1), l.selecting || (l.$element.addClass("ui-selecting"), l.selecting = !0, i._trigger("selecting", e, {
                                selecting: l.element
                            }))) : (l.selecting && ((e.metaKey || e.ctrlKey) && l.startselected ? (l.$element.removeClass("ui-selecting"), l.selecting = !1, l.$element.addClass("ui-selected"), l.selected = !0) : (l.$element.removeClass("ui-selecting"), l.selecting = !1, l.startselected && (l.$element.addClass("ui-unselecting"), l.unselecting = !0), i._trigger("unselecting", e, {
                                unselecting: l.element
                            }))), l.selected && !e.metaKey && !e.ctrlKey && !l.startselected && (l.$element.removeClass("ui-selected"), l.selected = !1, l.$element.addClass("ui-unselecting"), l.unselecting = !0, i._trigger("unselecting", e, {
                                unselecting: l.element
                            })))
                        }
                    }), !1
                }
            },
            _mouseStop: function(e) {
                var i = this;
                this.dragged = !1;
                this.options;
                return t(".ui-unselecting", this.element[0]).each(function() {
                    var n = t.data(this, "selectable-item");
                    n.$element.removeClass("ui-unselecting"), n.unselecting = !1, n.startselected = !1, i._trigger("unselected", e, {
                        unselected: n.element
                    })
                }), t(".ui-selecting", this.element[0]).each(function() {
                    var n = t.data(this, "selectable-item");
                    n.$element.removeClass("ui-selecting").addClass("ui-selected"), n.selecting = !1, n.selected = !0, n.startselected = !0, i._trigger("selected", e, {
                        selected: n.element
                    })
                }), this._trigger("stop", e), this.helper.remove(), !1
            }
        })
    }(jQuery), function(t, e) {
        t.widget("ui.sortable", t.ui.mouse, {
            version: "1.9.2",
            widgetEventPrefix: "sort",
            ready: !1,
            options: {
                appendTo: "parent",
                axis: !1,
                connectWith: !1,
                containment: !1,
                cursor: "auto",
                cursorAt: !1,
                dropOnEmpty: !0,
                forcePlaceholderSize: !1,
                forceHelperSize: !1,
                grid: !1,
                handle: !1,
                helper: "original",
                items: "> *",
                opacity: !1,
                placeholder: !1,
                revert: !1,
                scroll: !0,
                scrollSensitivity: 20,
                scrollSpeed: 20,
                scope: "default",
                tolerance: "intersect",
                zIndex: 1e3
            },
            _create: function() {
                var t = this.options;
                this.containerCache = {}, this.element.addClass("ui-sortable"), this.refresh(), this.floating = !!this.items.length && ("x" === t.axis || /left|right/.test(this.items[0].item.css("float")) || /inline|table-cell/.test(this.items[0].item.css("display"))), this.offset = this.element.offset(), this._mouseInit(), this.ready = !0
            },
            _destroy: function() {
                this.element.removeClass("ui-sortable ui-sortable-disabled"), this._mouseDestroy();
                for (var t = this.items.length - 1; t >= 0; t--) this.items[t].item.removeData(this.widgetName + "-item");
                return this
            },
            _setOption: function(e, i) {
                "disabled" === e ? (this.options[e] = i, this.widget().toggleClass("ui-sortable-disabled", !!i)) : t.Widget.prototype._setOption.apply(this, arguments)
            },
            _mouseCapture: function(e, i) {
                var n = this;
                if (this.reverting) return !1;
                if (this.options.disabled || "static" == this.options.type) return !1;
                this._refreshItems(e);
                var s = null;
                t(e.target).parents().each(function() {
                    if (t.data(this, n.widgetName + "-item") == n) return s = t(this), !1
                });
                if (t.data(e.target, n.widgetName + "-item") == n && (s = t(e.target)), !s) return !1;
                if (this.options.handle && !i) {
                    var o = !1;
                    if (t(this.options.handle, s).find("*").andSelf().each(function() {
                            this == e.target && (o = !0)
                        }), !o) return !1
                }
                return this.currentItem = s, this._removeCurrentsFromItems(), !0
            },
            _mouseStart: function(e, i, n) {
                var s = this.options;
                if (this.currentContainer = this, this.refreshPositions(), this.helper = this._createHelper(e), this._cacheHelperProportions(), this._cacheMargins(), this.scrollParent = this.helper.scrollParent(), this.offset = this.currentItem.offset(), this.offset = {
                        top: this.offset.top - this.margins.top,
                        left: this.offset.left - this.margins.left
                    }, t.extend(this.offset, {
                        click: {
                            left: e.pageX - this.offset.left,
                            top: e.pageY - this.offset.top
                        },
                        parent: this._getParentOffset(),
                        relative: this._getRelativeOffset()
                    }), this.helper.css("position", "absolute"), this.cssPosition = this.helper.css("position"), this.originalPosition = this._generatePosition(e), this.originalPageX = e.pageX, this.originalPageY = e.pageY, s.cursorAt && this._adjustOffsetFromHelper(s.cursorAt), this.domPosition = {
                        prev: this.currentItem.prev()[0],
                        parent: this.currentItem.parent()[0]
                    }, this.helper[0] != this.currentItem[0] && this.currentItem.hide(), this._createPlaceholder(), s.containment && this._setContainment(), s.cursor && (t("body").css("cursor") && (this._storedCursor = t("body").css("cursor")), t("body").css("cursor", s.cursor)), s.opacity && (this.helper.css("opacity") && (this._storedOpacity = this.helper.css("opacity")), this.helper.css("opacity", s.opacity)),
                    s.zIndex && (this.helper.css("zIndex") && (this._storedZIndex = this.helper.css("zIndex")), this.helper.css("zIndex", s.zIndex)), this.scrollParent[0] != document && "HTML" != this.scrollParent[0].tagName && (this.overflowOffset = this.scrollParent.offset()), this._trigger("start", e, this._uiHash()), this._preserveHelperProportions || this._cacheHelperProportions(), !n)
                    for (var o = this.containers.length - 1; o >= 0; o--) this.containers[o]._trigger("activate", e, this._uiHash(this));
                return t.ui.ddmanager && (t.ui.ddmanager.current = this), t.ui.ddmanager && !s.dropBehaviour && t.ui.ddmanager.prepareOffsets(this, e), this.dragging = !0, this.helper.addClass("ui-sortable-helper"), this._mouseDrag(e), !0
            },
            _mouseDrag: function(e) {
                if (this.position = this._generatePosition(e), this.positionAbs = this._convertPositionTo("absolute"), this.lastPositionAbs || (this.lastPositionAbs = this.positionAbs), this.options.scroll) {
                    var i = this.options,
                        n = !1;
                    this.scrollParent[0] != document && "HTML" != this.scrollParent[0].tagName ? (this.overflowOffset.top + this.scrollParent[0].offsetHeight - e.pageY < i.scrollSensitivity ? this.scrollParent[0].scrollTop = n = this.scrollParent[0].scrollTop + i.scrollSpeed : e.pageY - this.overflowOffset.top < i.scrollSensitivity && (this.scrollParent[0].scrollTop = n = this.scrollParent[0].scrollTop - i.scrollSpeed), this.overflowOffset.left + this.scrollParent[0].offsetWidth - e.pageX < i.scrollSensitivity ? this.scrollParent[0].scrollLeft = n = this.scrollParent[0].scrollLeft + i.scrollSpeed : e.pageX - this.overflowOffset.left < i.scrollSensitivity && (this.scrollParent[0].scrollLeft = n = this.scrollParent[0].scrollLeft - i.scrollSpeed)) : (e.pageY - t(document).scrollTop() < i.scrollSensitivity ? n = t(document).scrollTop(t(document).scrollTop() - i.scrollSpeed) : t(window).height() - (e.pageY - t(document).scrollTop()) < i.scrollSensitivity && (n = t(document).scrollTop(t(document).scrollTop() + i.scrollSpeed)), e.pageX - t(document).scrollLeft() < i.scrollSensitivity ? n = t(document).scrollLeft(t(document).scrollLeft() - i.scrollSpeed) : t(window).width() - (e.pageX - t(document).scrollLeft()) < i.scrollSensitivity && (n = t(document).scrollLeft(t(document).scrollLeft() + i.scrollSpeed))), !1 !== n && t.ui.ddmanager && !i.dropBehaviour && t.ui.ddmanager.prepareOffsets(this, e)
                }
                this.positionAbs = this._convertPositionTo("absolute"), this.options.axis && "y" == this.options.axis || (this.helper[0].style.left = this.position.left + "px"), this.options.axis && "x" == this.options.axis || (this.helper[0].style.top = this.position.top + "px");
                for (var s = this.items.length - 1; s >= 0; s--) {
                    var o = this.items[s],
                        r = o.item[0],
                        a = this._intersectsWithPointer(o);
                    if (a && (o.instance === this.currentContainer && !(r == this.currentItem[0] || this.placeholder[1 == a ? "next" : "prev"]()[0] == r || t.contains(this.placeholder[0], r) || "semi-dynamic" == this.options.type && t.contains(this.element[0], r)))) {
                        if (this.direction = 1 == a ? "down" : "up", "pointer" != this.options.tolerance && !this._intersectsWithSides(o)) break;
                        this._rearrange(e, o), this._trigger("change", e, this._uiHash());
                        break
                    }
                }
                return this._contactContainers(e), t.ui.ddmanager && t.ui.ddmanager.drag(this, e), this._trigger("sort", e, this._uiHash()), this.lastPositionAbs = this.positionAbs, !1
            },
            _mouseStop: function(e, i) {
                if (e) {
                    if (t.ui.ddmanager && !this.options.dropBehaviour && t.ui.ddmanager.drop(this, e), this.options.revert) {
                        var n = this,
                            s = this.placeholder.offset();
                        this.reverting = !0, t(this.helper).animate({
                            left: s.left - this.offset.parent.left - this.margins.left + (this.offsetParent[0] == document.body ? 0 : this.offsetParent[0].scrollLeft),
                            top: s.top - this.offset.parent.top - this.margins.top + (this.offsetParent[0] == document.body ? 0 : this.offsetParent[0].scrollTop)
                        }, parseInt(this.options.revert, 10) || 500, function() {
                            n._clear(e)
                        })
                    } else this._clear(e, i);
                    return !1
                }
            },
            cancel: function() {
                if (this.dragging) {
                    this._mouseUp({
                        target: null
                    }), "original" == this.options.helper ? this.currentItem.css(this._storedCSS).removeClass("ui-sortable-helper") : this.currentItem.show();
                    for (var e = this.containers.length - 1; e >= 0; e--) this.containers[e]._trigger("deactivate", null, this._uiHash(this)), this.containers[e].containerCache.over && (this.containers[e]._trigger("out", null, this._uiHash(this)), this.containers[e].containerCache.over = 0)
                }
                return this.placeholder && (this.placeholder[0].parentNode && this.placeholder[0].parentNode.removeChild(this.placeholder[0]), "original" != this.options.helper && this.helper && this.helper[0].parentNode && this.helper.remove(), t.extend(this, {
                    helper: null,
                    dragging: !1,
                    reverting: !1,
                    _noFinalSort: null
                }), this.domPosition.prev ? t(this.domPosition.prev).after(this.currentItem) : t(this.domPosition.parent).prepend(this.currentItem)), this
            },
            serialize: function(e) {
                var i = this._getItemsAsjQuery(e && e.connected),
                    n = [];
                return e = e || {}, t(i).each(function() {
                    var i = (t(e.item || this).attr(e.attribute || "id") || "").match(e.expression || /(.+)[-=_](.+)/);
                    i && n.push((e.key || i[1] + "[]") + "=" + (e.key && e.expression ? i[1] : i[2]))
                }), !n.length && e.key && n.push(e.key + "="), n.join("&")
            },
            toArray: function(e) {
                var i = this._getItemsAsjQuery(e && e.connected),
                    n = [];
                return e = e || {}, i.each(function() {
                    n.push(t(e.item || this).attr(e.attribute || "id") || "")
                }), n
            },
            _intersectsWith: function(t) {
                var e = this.positionAbs.left,
                    i = e + this.helperProportions.width,
                    n = this.positionAbs.top,
                    s = n + this.helperProportions.height,
                    o = t.left,
                    r = o + t.width,
                    a = t.top,
                    l = a + t.height,
                    h = this.offset.click.top,
                    c = this.offset.click.left,
                    u = n + h > a && n + h < l && e + c > o && e + c < r;
                return "pointer" == this.options.tolerance || this.options.forcePointerForContainers || "pointer" != this.options.tolerance && this.helperProportions[this.floating ? "width" : "height"] > t[this.floating ? "width" : "height"] ? u : o < e + this.helperProportions.width / 2 && i - this.helperProportions.width / 2 < r && a < n + this.helperProportions.height / 2 && s - this.helperProportions.height / 2 < l
            },
            _intersectsWithPointer: function(e) {
                var i = "x" === this.options.axis || t.ui.isOverAxis(this.positionAbs.top + this.offset.click.top, e.top, e.height),
                    n = "y" === this.options.axis || t.ui.isOverAxis(this.positionAbs.left + this.offset.click.left, e.left, e.width),
                    s = i && n,
                    o = this._getDragVerticalDirection(),
                    r = this._getDragHorizontalDirection();
                return !!s && (this.floating ? r && "right" == r || "down" == o ? 2 : 1 : o && ("down" == o ? 2 : 1))
            },
            _intersectsWithSides: function(e) {
                var i = t.ui.isOverAxis(this.positionAbs.top + this.offset.click.top, e.top + e.height / 2, e.height),
                    n = t.ui.isOverAxis(this.positionAbs.left + this.offset.click.left, e.left + e.width / 2, e.width),
                    s = this._getDragVerticalDirection(),
                    o = this._getDragHorizontalDirection();
                return this.floating && o ? "right" == o && n || "left" == o && !n : s && ("down" == s && i || "up" == s && !i)
            },
            _getDragVerticalDirection: function() {
                var t = this.positionAbs.top - this.lastPositionAbs.top;
                return 0 != t && (t > 0 ? "down" : "up")
            },
            _getDragHorizontalDirection: function() {
                var t = this.positionAbs.left - this.lastPositionAbs.left;
                return 0 != t && (t > 0 ? "right" : "left")
            },
            refresh: function(t) {
                return this._refreshItems(t), this.refreshPositions(), this
            },
            _connectWith: function() {
                var t = this.options;
                return t.connectWith.constructor == String ? [t.connectWith] : t.connectWith
            },
            _getItemsAsjQuery: function(e) {
                var i = [],
                    n = [],
                    s = this._connectWith();
                if (s && e)
                    for (var o = s.length - 1; o >= 0; o--)
                        for (var r = t(s[o]), a = r.length - 1; a >= 0; a--) {
                            var l = t.data(r[a], this.widgetName);
                            l && l != this && !l.options.disabled && n.push([t.isFunction(l.options.items) ? l.options.items.call(l.element) : t(l.options.items, l.element).not(".ui-sortable-helper").not(".ui-sortable-placeholder"), l])
                        }
                n.push([t.isFunction(this.options.items) ? this.options.items.call(this.element, null, {
                    options: this.options,
                    item: this.currentItem
                }) : t(this.options.items, this.element).not(".ui-sortable-helper").not(".ui-sortable-placeholder"), this]);
                for (var o = n.length - 1; o >= 0; o--) n[o][0].each(function() {
                    i.push(this)
                });
                return t(i)
            },
            _removeCurrentsFromItems: function() {
                var e = this.currentItem.find(":data(" + this.widgetName + "-item)");
                this.items = t.grep(this.items, function(t) {
                    for (var i = 0; i < e.length; i++)
                        if (e[i] == t.item[0]) return !1;
                    return !0
                })
            },
            _refreshItems: function(e) {
                this.items = [], this.containers = [this];
                var i = this.items,
                    n = [
                        [t.isFunction(this.options.items) ? this.options.items.call(this.element[0], e, {
                            item: this.currentItem
                        }) : t(this.options.items, this.element), this]
                    ],
                    s = this._connectWith();
                if (s && this.ready)
                    for (var o = s.length - 1; o >= 0; o--)
                        for (var r = t(s[o]), a = r.length - 1; a >= 0; a--) {
                            var l = t.data(r[a], this.widgetName);
                            l && l != this && !l.options.disabled && (n.push([t.isFunction(l.options.items) ? l.options.items.call(l.element[0], e, {
                                item: this.currentItem
                            }) : t(l.options.items, l.element), l]), this.containers.push(l))
                        }
                for (var o = n.length - 1; o >= 0; o--)
                    for (var h = n[o][1], c = n[o][0], a = 0, u = c.length; a < u; a++) {
                        var d = t(c[a]);
                        d.data(this.widgetName + "-item", h), i.push({
                            item: d,
                            instance: h,
                            width: 0,
                            height: 0,
                            left: 0,
                            top: 0
                        })
                    }
            },
            refreshPositions: function(e) {
                this.offsetParent && this.helper && (this.offset.parent = this._getParentOffset());
                for (var i = this.items.length - 1; i >= 0; i--) {
                    var n = this.items[i];
                    if (n.instance == this.currentContainer || !this.currentContainer || n.item[0] == this.currentItem[0]) {
                        var s = this.options.toleranceElement ? t(this.options.toleranceElement, n.item) : n.item;
                        e || (n.width = s.outerWidth(), n.height = s.outerHeight());
                        var o = s.offset();
                        n.left = o.left, n.top = o.top
                    }
                }
                if (this.options.custom && this.options.custom.refreshContainers) this.options.custom.refreshContainers.call(this);
                else
                    for (var i = this.containers.length - 1; i >= 0; i--) {
                        var o = this.containers[i].element.offset();
                        this.containers[i].containerCache.left = o.left, this.containers[i].containerCache.top = o.top, this.containers[i].containerCache.width = this.containers[i].element.outerWidth(), this.containers[i].containerCache.height = this.containers[i].element.outerHeight()
                    }
                return this
            },
            _createPlaceholder: function(e) {
                e = e || this;
                var i = e.options;
                if (!i.placeholder || i.placeholder.constructor == String) {
                    var n = i.placeholder;
                    i.placeholder = {
                        element: function() {
                            var i = t(document.createElement(e.currentItem[0].nodeName)).addClass(n || e.currentItem[0].className + " ui-sortable-placeholder").removeClass("ui-sortable-helper")[0];
                            return n || (i.style.visibility = "hidden"), i
                        },
                        update: function(t, s) {
                            n && !i.forcePlaceholderSize || (s.height() || s.height(e.currentItem.innerHeight() - parseInt(e.currentItem.css("paddingTop") || 0, 10) - parseInt(e.currentItem.css("paddingBottom") || 0, 10)), s.width() || s.width(e.currentItem.innerWidth() - parseInt(e.currentItem.css("paddingLeft") || 0, 10) - parseInt(e.currentItem.css("paddingRight") || 0, 10)))
                        }
                    }
                }
                e.placeholder = t(i.placeholder.element.call(e.element, e.currentItem)), e.currentItem.after(e.placeholder), i.placeholder.update(e, e.placeholder)
            },
            _contactContainers: function(e) {
                for (var i = null, n = null, s = this.containers.length - 1; s >= 0; s--)
                    if (!t.contains(this.currentItem[0], this.containers[s].element[0]))
                        if (this._intersectsWith(this.containers[s].containerCache)) {
                            if (i && t.contains(this.containers[s].element[0], i.element[0])) continue;
                            i = this.containers[s], n = s
                        } else this.containers[s].containerCache.over && (this.containers[s]._trigger("out", e, this._uiHash(this)), this.containers[s].containerCache.over = 0);
                if (i)
                    if (1 === this.containers.length) this.containers[n]._trigger("over", e, this._uiHash(this)), this.containers[n].containerCache.over = 1;
                    else {
                        for (var o = 1e4, r = null, a = this.containers[n].floating ? "left" : "top", l = this.containers[n].floating ? "width" : "height", h = this.positionAbs[a] + this.offset.click[a], c = this.items.length - 1; c >= 0; c--)
                            if (t.contains(this.containers[n].element[0], this.items[c].item[0]) && this.items[c].item[0] != this.currentItem[0]) {
                                var u = this.items[c].item.offset()[a],
                                    d = !1;
                                Math.abs(u - h) > Math.abs(u + this.items[c][l] - h) && (d = !0, u += this.items[c][l]), Math.abs(u - h) < o && (o = Math.abs(u - h), r = this.items[c], this.direction = d ? "up" : "down")
                            } if (!r && !this.options.dropOnEmpty) return;
                        this.currentContainer = this.containers[n], r ? this._rearrange(e, r, null, !0) : this._rearrange(e, null, this.containers[n].element, !0), this._trigger("change", e, this._uiHash()), this.containers[n]._trigger("change", e, this._uiHash(this)), this.options.placeholder.update(this.currentContainer, this.placeholder), this.containers[n]._trigger("over", e, this._uiHash(this)), this.containers[n].containerCache.over = 1
                    }
            },
            _createHelper: function(e) {
                var i = this.options,
                    n = t.isFunction(i.helper) ? t(i.helper.apply(this.element[0], [e, this.currentItem])) : "clone" == i.helper ? this.currentItem.clone() : this.currentItem;
                return n.parents("body").length || t("parent" != i.appendTo ? i.appendTo : this.currentItem[0].parentNode)[0].appendChild(n[0]), n[0] == this.currentItem[0] && (this._storedCSS = {
                    width: this.currentItem[0].style.width,
                    height: this.currentItem[0].style.height,
                    position: this.currentItem.css("position"),
                    top: this.currentItem.css("top"),
                    left: this.currentItem.css("left")
                }), ("" == n[0].style.width || i.forceHelperSize) && n.width(this.currentItem.width()), ("" == n[0].style.height || i.forceHelperSize) && n.height(this.currentItem.height()), n
            },
            _adjustOffsetFromHelper: function(e) {
                "string" == typeof e && (e = e.split(" ")), t.isArray(e) && (e = {
                    left: +e[0],
                    top: +e[1] || 0
                }), "left" in e && (this.offset.click.left = e.left + this.margins.left), "right" in e && (this.offset.click.left = this.helperProportions.width - e.right + this.margins.left), "top" in e && (this.offset.click.top = e.top + this.margins.top), "bottom" in e && (this.offset.click.top = this.helperProportions.height - e.bottom + this.margins.top)
            },
            _getParentOffset: function() {
                this.offsetParent = this.helper.offsetParent();
                var e = this.offsetParent.offset();
                return "absolute" == this.cssPosition && this.scrollParent[0] != document && t.contains(this.scrollParent[0], this.offsetParent[0]) && (e.left += this.scrollParent.scrollLeft(), e.top += this.scrollParent.scrollTop()), (this.offsetParent[0] == document.body || this.offsetParent[0].tagName && "html" == this.offsetParent[0].tagName.toLowerCase() && t.ui.ie) && (e = {
                    top: 0,
                    left: 0
                }), {
                    top: e.top + (parseInt(this.offsetParent.css("borderTopWidth"), 10) || 0),
                    left: e.left + (parseInt(this.offsetParent.css("borderLeftWidth"), 10) || 0)
                }
            },
            _getRelativeOffset: function() {
                if ("relative" == this.cssPosition) {
                    var t = this.currentItem.position();
                    return {
                        top: t.top - (parseInt(this.helper.css("top"), 10) || 0) + this.scrollParent.scrollTop(),
                        left: t.left - (parseInt(this.helper.css("left"), 10) || 0) + this.scrollParent.scrollLeft()
                    }
                }
                return {
                    top: 0,
                    left: 0
                }
            },
            _cacheMargins: function() {
                this.margins = {
                    left: parseInt(this.currentItem.css("marginLeft"), 10) || 0,
                    top: parseInt(this.currentItem.css("marginTop"), 10) || 0
                }
            },
            _cacheHelperProportions: function() {
                this.helperProportions = {
                    width: this.helper.outerWidth(),
                    height: this.helper.outerHeight()
                }
            },
            _setContainment: function() {
                var e = this.options;
                if ("parent" == e.containment && (e.containment = this.helper[0].parentNode), "document" != e.containment && "window" != e.containment || (this.containment = [0 - this.offset.relative.left - this.offset.parent.left, 0 - this.offset.relative.top - this.offset.parent.top, t("document" == e.containment ? document : window).width() - this.helperProportions.width - this.margins.left, (t("document" == e.containment ? document : window).height() || document.body.parentNode.scrollHeight) - this.helperProportions.height - this.margins.top]), !/^(document|window|parent)$/.test(e.containment)) {
                    var i = t(e.containment)[0],
                        n = t(e.containment).offset(),
                        s = "hidden" != t(i).css("overflow");
                    this.containment = [n.left + (parseInt(t(i).css("borderLeftWidth"), 10) || 0) + (parseInt(t(i).css("paddingLeft"), 10) || 0) - this.margins.left, n.top + (parseInt(t(i).css("borderTopWidth"), 10) || 0) + (parseInt(t(i).css("paddingTop"), 10) || 0) - this.margins.top, n.left + (s ? Math.max(i.scrollWidth, i.offsetWidth) : i.offsetWidth) - (parseInt(t(i).css("borderLeftWidth"), 10) || 0) - (parseInt(t(i).css("paddingRight"), 10) || 0) - this.helperProportions.width - this.margins.left, n.top + (s ? Math.max(i.scrollHeight, i.offsetHeight) : i.offsetHeight) - (parseInt(t(i).css("borderTopWidth"), 10) || 0) - (parseInt(t(i).css("paddingBottom"), 10) || 0) - this.helperProportions.height - this.margins.top]
                }
            },
            _convertPositionTo: function(e, i) {
                i || (i = this.position);
                var n = "absolute" == e ? 1 : -1,
                    s = (this.options, "absolute" != this.cssPosition || this.scrollParent[0] != document && t.contains(this.scrollParent[0], this.offsetParent[0]) ? this.scrollParent : this.offsetParent),
                    o = /(html|body)/i.test(s[0].tagName);
                return {
                    top: i.top + this.offset.relative.top * n + this.offset.parent.top * n - ("fixed" == this.cssPosition ? -this.scrollParent.scrollTop() : o ? 0 : s.scrollTop()) * n,
                    left: i.left + this.offset.relative.left * n + this.offset.parent.left * n - ("fixed" == this.cssPosition ? -this.scrollParent.scrollLeft() : o ? 0 : s.scrollLeft()) * n
                }
            },
            _generatePosition: function(e) {
                var i = this.options,
                    n = "absolute" != this.cssPosition || this.scrollParent[0] != document && t.contains(this.scrollParent[0], this.offsetParent[0]) ? this.scrollParent : this.offsetParent,
                    s = /(html|body)/i.test(n[0].tagName);
                "relative" == this.cssPosition && (this.scrollParent[0] == document || this.scrollParent[0] == this.offsetParent[0]) && (this.offset.relative = this._getRelativeOffset());
                var o = e.pageX,
                    r = e.pageY;
                if (this.originalPosition && (this.containment && (e.pageX - this.offset.click.left < this.containment[0] && (o = this.containment[0] + this.offset.click.left), e.pageY - this.offset.click.top < this.containment[1] && (r = this.containment[1] + this.offset.click.top), e.pageX - this.offset.click.left > this.containment[2] && (o = this.containment[2] + this.offset.click.left), e.pageY - this.offset.click.top > this.containment[3] && (r = this.containment[3] + this.offset.click.top)), i.grid)) {
                    var a = this.originalPageY + Math.round((r - this.originalPageY) / i.grid[1]) * i.grid[1];
                    r = this.containment && (a - this.offset.click.top < this.containment[1] || a - this.offset.click.top > this.containment[3]) ? a - this.offset.click.top < this.containment[1] ? a + i.grid[1] : a - i.grid[1] : a;
                    var l = this.originalPageX + Math.round((o - this.originalPageX) / i.grid[0]) * i.grid[0];
                    o = this.containment && (l - this.offset.click.left < this.containment[0] || l - this.offset.click.left > this.containment[2]) ? l - this.offset.click.left < this.containment[0] ? l + i.grid[0] : l - i.grid[0] : l
                }
                return {
                    top: r - this.offset.click.top - this.offset.relative.top - this.offset.parent.top + ("fixed" == this.cssPosition ? -this.scrollParent.scrollTop() : s ? 0 : n.scrollTop()),
                    left: o - this.offset.click.left - this.offset.relative.left - this.offset.parent.left + ("fixed" == this.cssPosition ? -this.scrollParent.scrollLeft() : s ? 0 : n.scrollLeft())
                }
            },
            _rearrange: function(t, e, i, n) {
                i ? i[0].appendChild(this.placeholder[0]) : e.item[0].parentNode.insertBefore(this.placeholder[0], "down" == this.direction ? e.item[0] : e.item[0].nextSibling), this.counter = this.counter ? ++this.counter : 1;
                var s = this.counter;
                this._delay(function() {
                    s == this.counter && this.refreshPositions(!n)
                })
            },
            _clear: function(e, i) {
                this.reverting = !1;
                var n = [];
                if (!this._noFinalSort && this.currentItem.parent().length && this.placeholder.before(this.currentItem), this._noFinalSort = null, this.helper[0] == this.currentItem[0]) {
                    for (var s in this._storedCSS) "auto" != this._storedCSS[s] && "static" != this._storedCSS[s] || (this._storedCSS[s] = "");
                    this.currentItem.css(this._storedCSS).removeClass("ui-sortable-helper")
                } else this.currentItem.show();
                this.fromOutside && !i && n.push(function(t) {
                    this._trigger("receive", t, this._uiHash(this.fromOutside))
                }), (this.fromOutside || this.domPosition.prev != this.currentItem.prev().not(".ui-sortable-helper")[0] || this.domPosition.parent != this.currentItem.parent()[0]) && !i && n.push(function(t) {
                    this._trigger("update", t, this._uiHash())
                }), this !== this.currentContainer && (i || (n.push(function(t) {
                    this._trigger("remove", t, this._uiHash())
                }), n.push(function(t) {
                    return function(e) {
                        t._trigger("receive", e, this._uiHash(this))
                    }
                }.call(this, this.currentContainer)), n.push(function(t) {
                    return function(e) {
                        t._trigger("update", e, this._uiHash(this))
                    }
                }.call(this, this.currentContainer))));
                for (var s = this.containers.length - 1; s >= 0; s--) i || n.push(function(t) {
                    return function(e) {
                        t._trigger("deactivate", e, this._uiHash(this))
                    }
                }.call(this, this.containers[s])), this.containers[s].containerCache.over && (n.push(function(t) {
                    return function(e) {
                        t._trigger("out", e, this._uiHash(this))
                    }
                }.call(this, this.containers[s])), this.containers[s].containerCache.over = 0);
                if (this._storedCursor && t("body").css("cursor", this._storedCursor), this._storedOpacity && this.helper.css("opacity", this._storedOpacity), this._storedZIndex && this.helper.css("zIndex", "auto" == this._storedZIndex ? "" : this._storedZIndex), this.dragging = !1, this.cancelHelperRemoval) {
                    if (!i) {
                        this._trigger("beforeStop", e, this._uiHash());
                        for (var s = 0; s < n.length; s++) n[s].call(this, e);
                        this._trigger("stop", e, this._uiHash())
                    }
                    return this.fromOutside = !1, !1
                }
                if (i || this._trigger("beforeStop", e, this._uiHash()), this.placeholder[0].parentNode.removeChild(this.placeholder[0]), this.helper[0] != this.currentItem[0] && this.helper.remove(), this.helper = null, !i) {
                    for (var s = 0; s < n.length; s++) n[s].call(this, e);
                    this._trigger("stop", e, this._uiHash())
                }
                return this.fromOutside = !1, !0
            },
            _trigger: function() {
                !1 === t.Widget.prototype._trigger.apply(this, arguments) && this.cancel()
            },
            _uiHash: function(e) {
                var i = e || this;
                return {
                    helper: i.helper,
                    placeholder: i.placeholder || t([]),
                    position: i.position,
                    originalPosition: i.originalPosition,
                    offset: i.positionAbs,
                    item: i.currentItem,
                    sender: e ? e.element : null
                }
            }
        })
    }(jQuery), jQuery.effects || function(t, e) {
        var i = !1 !== t.uiBackCompat,
            n = "ui-effects-";
        t.effects = {
                effect: {}
            },
            function(e, i) {
                function n(t, e, i) {
                    var n = d[e.type] || {};
                    return null == t ? i || !e.def ? null : e.def : (t = n.floor ? ~~t : parseFloat(t), isNaN(t) ? e.def : n.mod ? (t + n.mod) % n.mod : 0 > t ? 0 : n.max < t ? n.max : t)
                }

                function s(t) {
                    var i = c(),
                        n = i._rgba = [];
                    return t = t.toLowerCase(), g(h, function(e, s) {
                        var o, r = s.re.exec(t),
                            a = r && s.parse(r),
                            l = s.space || "rgba";
                        if (a) return o = i[l](a), i[u[l].cache] = o[u[l].cache], n = i._rgba = o._rgba, !1
                    }), n.length ? ("0,0,0,0" === n.join() && e.extend(n, r.transparent), i) : r[t]
                }

                function o(t, e, i) {
                    return i = (i + 1) % 1, 6 * i < 1 ? t + (e - t) * i * 6 : 2 * i < 1 ? e : 3 * i < 2 ? t + (e - t) * (2 / 3 - i) * 6 : t
                }
                var r, a = "backgroundColor borderBottomColor borderLeftColor borderRightColor borderTopColor color columnRuleColor outlineColor textDecorationColor textEmphasisColor".split(" "),
                    l = /^([\-+])=\s*(\d+\.?\d*)/,
                    h = [{
                        re: /rgba?\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*(?:,\s*(\d+(?:\.\d+)?)\s*)?\)/,
                        parse: function(t) {
                            return [t[1], t[2], t[3], t[4]]
                        }
                    }, {
                        re: /rgba?\(\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*(?:,\s*(\d+(?:\.\d+)?)\s*)?\)/,
                        parse: function(t) {
                            return [2.55 * t[1], 2.55 * t[2], 2.55 * t[3], t[4]]
                        }
                    }, {
                        re: /#([a-f0-9]{2})([a-f0-9]{2})([a-f0-9]{2})/,
                        parse: function(t) {
                            return [parseInt(t[1], 16), parseInt(t[2], 16), parseInt(t[3], 16)]
                        }
                    }, {
                        re: /#([a-f0-9])([a-f0-9])([a-f0-9])/,
                        parse: function(t) {
                            return [parseInt(t[1] + t[1], 16), parseInt(t[2] + t[2], 16), parseInt(t[3] + t[3], 16)]
                        }
                    }, {
                        re: /hsla?\(\s*(\d+(?:\.\d+)?)\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*(?:,\s*(\d+(?:\.\d+)?)\s*)?\)/,
                        space: "hsla",
                        parse: function(t) {
                            return [t[1], t[2] / 100, t[3] / 100, t[4]]
                        }
                    }],
                    c = e.Color = function(t, i, n, s) {
                        return new e.Color.fn.parse(t, i, n, s)
                    },
                    u = {
                        rgba: {
                            props: {
                                red: {
                                    idx: 0,
                                    type: "byte"
                                },
                                green: {
                                    idx: 1,
                                    type: "byte"
                                },
                                blue: {
                                    idx: 2,
                                    type: "byte"
                                }
                            }
                        },
                        hsla: {
                            props: {
                                hue: {
                                    idx: 0,
                                    type: "degrees"
                                },
                                saturation: {
                                    idx: 1,
                                    type: "percent"
                                },
                                lightness: {
                                    idx: 2,
                                    type: "percent"
                                }
                            }
                        }
                    },
                    d = {
                        byte: {
                            floor: !0,
                            max: 255
                        },
                        percent: {
                            max: 1
                        },
                        degrees: {
                            mod: 360,
                            floor: !0
                        }
                    },
                    p = c.support = {},
                    f = e("<p>")[0],
                    g = e.each;
                f.style.cssText = "background-color:rgba(1,1,1,.5)", p.rgba = f.style.backgroundColor.indexOf("rgba") > -1, g(u, function(t, e) {
                    e.cache = "_" + t, e.props.alpha = {
                        idx: 3,
                        type: "percent",
                        def: 1
                    }
                }), c.fn = e.extend(c.prototype, {
                    parse: function(o, a, l, h) {
                        if (o === i) return this._rgba = [null, null, null, null], this;
                        (o.jquery || o.nodeType) && (o = e(o).css(a), a = i);
                        var d = this,
                            p = e.type(o),
                            f = this._rgba = [];
                        return a !== i && (o = [o, a, l, h], p = "array"), "string" === p ? this.parse(s(o) || r._default) : "array" === p ? (g(u.rgba.props, function(t, e) {
                            f[e.idx] = n(o[e.idx], e)
                        }), this) : "object" === p ? (o instanceof c ? g(u, function(t, e) {
                            o[e.cache] && (d[e.cache] = o[e.cache].slice())
                        }) : g(u, function(e, i) {
                            var s = i.cache;
                            g(i.props, function(t, e) {
                                if (!d[s] && i.to) {
                                    if ("alpha" === t || null == o[t]) return;
                                    d[s] = i.to(d._rgba)
                                }
                                d[s][e.idx] = n(o[t], e, !0)
                            }), d[s] && t.inArray(null, d[s].slice(0, 3)) < 0 && (d[s][3] = 1, i.from && (d._rgba = i.from(d[s])))
                        }), this) : void 0
                    },
                    is: function(t) {
                        var e = c(t),
                            i = !0,
                            n = this;
                        return g(u, function(t, s) {
                            var o, r = e[s.cache];
                            return r && (o = n[s.cache] || s.to && s.to(n._rgba) || [], g(s.props, function(t, e) {
                                if (null != r[e.idx]) return i = r[e.idx] === o[e.idx]
                            })), i
                        }), i
                    },
                    _space: function() {
                        var t = [],
                            e = this;
                        return g(u, function(i, n) {
                            e[n.cache] && t.push(i)
                        }), t.pop()
                    },
                    transition: function(t, e) {
                        var i = c(t),
                            s = i._space(),
                            o = u[s],
                            r = 0 === this.alpha() ? c("transparent") : this,
                            a = r[o.cache] || o.to(r._rgba),
                            l = a.slice();
                        return i = i[o.cache], g(o.props, function(t, s) {
                            var o = s.idx,
                                r = a[o],
                                h = i[o],
                                c = d[s.type] || {};
                            null !== h && (null === r ? l[o] = h : (c.mod && (h - r > c.mod / 2 ? r += c.mod : r - h > c.mod / 2 && (r -= c.mod)), l[o] = n((h - r) * e + r, s)))
                        }), this[s](l)
                    },
                    blend: function(t) {
                        if (1 === this._rgba[3]) return this;
                        var i = this._rgba.slice(),
                            n = i.pop(),
                            s = c(t)._rgba;
                        return c(e.map(i, function(t, e) {
                            return (1 - n) * s[e] + n * t
                        }))
                    },
                    toRgbaString: function() {
                        var t = "rgba(",
                            i = e.map(this._rgba, function(t, e) {
                                return null == t ? e > 2 ? 1 : 0 : t
                            });
                        return 1 === i[3] && (i.pop(), t = "rgb("), t + i.join() + ")"
                    },
                    toHslaString: function() {
                        var t = "hsla(",
                            i = e.map(this.hsla(), function(t, e) {
                                return null == t && (t = e > 2 ? 1 : 0), e && e < 3 && (t = Math.round(100 * t) + "%"), t
                            });
                        return 1 === i[3] && (i.pop(), t = "hsl("), t + i.join() + ")"
                    },
                    toHexString: function(t) {
                        var i = this._rgba.slice(),
                            n = i.pop();
                        return t && i.push(~~(255 * n)), "#" + e.map(i, function(t) {
                            return t = (t || 0).toString(16), 1 === t.length ? "0" + t : t
                        }).join("")
                    },
                    toString: function() {
                        return 0 === this._rgba[3] ? "transparent" : this.toRgbaString()
                    }
                }), c.fn.parse.prototype = c.fn, u.hsla.to = function(t) {
                    if (null == t[0] || null == t[1] || null == t[2]) return [null, null, null, t[3]];
                    var e, i, n = t[0] / 255,
                        s = t[1] / 255,
                        o = t[2] / 255,
                        r = t[3],
                        a = Math.max(n, s, o),
                        l = Math.min(n, s, o),
                        h = a - l,
                        c = a + l,
                        u = .5 * c;
                    return e = l === a ? 0 : n === a ? 60 * (s - o) / h + 360 : s === a ? 60 * (o - n) / h + 120 : 60 * (n - s) / h + 240, i = 0 === u || 1 === u ? u : u <= .5 ? h / c : h / (2 - c), [Math.round(e) % 360, i, u, null == r ? 1 : r]
                }, u.hsla.from = function(t) {
                    if (null == t[0] || null == t[1] || null == t[2]) return [null, null, null, t[3]];
                    var e = t[0] / 360,
                        i = t[1],
                        n = t[2],
                        s = t[3],
                        r = n <= .5 ? n * (1 + i) : n + i - n * i,
                        a = 2 * n - r;
                    return [Math.round(255 * o(a, r, e + 1 / 3)), Math.round(255 * o(a, r, e)), Math.round(255 * o(a, r, e - 1 / 3)), s]
                }, g(u, function(t, s) {
                    var o = s.props,
                        r = s.cache,
                        a = s.to,
                        h = s.from;
                    c.fn[t] = function(t) {
                        if (a && !this[r] && (this[r] = a(this._rgba)), t === i) return this[r].slice();
                        var s, l = e.type(t),
                            u = "array" === l || "object" === l ? t : arguments,
                            d = this[r].slice();
                        return g(o, function(t, e) {
                            var i = u["object" === l ? t : e.idx];
                            null == i && (i = d[e.idx]), d[e.idx] = n(i, e)
                        }), h ? (s = c(h(d)), s[r] = d, s) : c(d)
                    }, g(o, function(i, n) {
                        c.fn[i] || (c.fn[i] = function(s) {
                            var o, r = e.type(s),
                                a = "alpha" === i ? this._hsla ? "hsla" : "rgba" : t,
                                h = this[a](),
                                c = h[n.idx];
                            return "undefined" === r ? c : ("function" === r && (s = s.call(this, c), r = e.type(s)), null == s && n.empty ? this : ("string" === r && (o = l.exec(s)) && (s = c + parseFloat(o[2]) * ("+" === o[1] ? 1 : -1)), h[n.idx] = s, this[a](h)))
                        })
                    })
                }), g(a, function(t, i) {
                    e.cssHooks[i] = {
                        set: function(t, n) {
                            var o, r, a = "";
                            if ("string" !== e.type(n) || (o = s(n))) {
                                if (n = c(o || n), !p.rgba && 1 !== n._rgba[3]) {
                                    for (r = "backgroundColor" === i ? t.parentNode : t;
                                        ("" === a || "transparent" === a) && r && r.style;) try {
                                        a = e.css(r, "backgroundColor"), r = r.parentNode
                                    } catch (t) {}
                                    n = n.blend(a && "transparent" !== a ? a : "_default")
                                }
                                n = n.toRgbaString()
                            }
                            try {
                                t.style[i] = n
                            } catch (t) {}
                        }
                    }, e.fx.step[i] = function(t) {
                        t.colorInit || (t.start = c(t.elem, i), t.end = c(t.end), t.colorInit = !0), e.cssHooks[i].set(t.elem, t.start.transition(t.end, t.pos))
                    }
                }), e.cssHooks.borderColor = {
                    expand: function(t) {
                        var e = {};
                        return g(["Top", "Right", "Bottom", "Left"], function(i, n) {
                            e["border" + n + "Color"] = t
                        }), e
                    }
                }, r = e.Color.names = {
                    aqua: "#00ffff",
                    black: "#000000",
                    blue: "#0000ff",
                    fuchsia: "#ff00ff",
                    gray: "#808080",
                    green: "#008000",
                    lime: "#00ff00",
                    maroon: "#800000",
                    navy: "#000080",
                    olive: "#808000",
                    purple: "#800080",
                    red: "#ff0000",
                    silver: "#c0c0c0",
                    teal: "#008080",
                    white: "#ffffff",
                    yellow: "#ffff00",
                    transparent: [null, null, null, 0],
                    _default: "#ffffff"
                }
            }(jQuery),
            function() {
                function i() {
                    var e, i, n = this.ownerDocument.defaultView ? this.ownerDocument.defaultView.getComputedStyle(this, null) : this.currentStyle,
                        s = {};
                    if (n && n.length && n[0] && n[n[0]])
                        for (i = n.length; i--;) e = n[i], "string" == typeof n[e] && (s[t.camelCase(e)] = n[e]);
                    else
                        for (e in n) "string" == typeof n[e] && (s[e] = n[e]);
                    return s
                }

                function n(e, i) {
                    var n, s, r = {};
                    for (n in i) s = i[n], e[n] !== s && !o[n] && (t.fx.step[n] || !isNaN(parseFloat(s))) && (r[n] = s);
                    return r
                }
                var s = ["add", "remove", "toggle"],
                    o = {
                        border: 1,
                        borderBottom: 1,
                        borderColor: 1,
                        borderLeft: 1,
                        borderRight: 1,
                        borderTop: 1,
                        borderWidth: 1,
                        margin: 1,
                        padding: 1
                    };
                t.each(["borderLeftStyle", "borderRightStyle", "borderBottomStyle", "borderTopStyle"], function(e, i) {
                    t.fx.step[i] = function(t) {
                        ("none" !== t.end && !t.setAttr || 1 === t.pos && !t.setAttr) && (jQuery.style(t.elem, i, t.end), t.setAttr = !0)
                    }
                }), t.effects.animateClass = function(e, o, r, a) {
                    var l = t.speed(o, r, a);
                    return this.queue(function() {
                        var o, r = t(this),
                            a = r.attr("class") || "",
                            h = l.children ? r.find("*").andSelf() : r;
                        h = h.map(function() {
                            return {
                                el: t(this),
                                start: i.call(this)
                            }
                        }), o = function() {
                            t.each(s, function(t, i) {
                                e[i] && r[i + "Class"](e[i])
                            })
                        }, o(), h = h.map(function() {
                            return this.end = i.call(this.el[0]), this.diff = n(this.start, this.end), this
                        }), r.attr("class", a), h = h.map(function() {
                            var e = this,
                                i = t.Deferred(),
                                n = jQuery.extend({}, l, {
                                    queue: !1,
                                    complete: function() {
                                        i.resolve(e)
                                    }
                                });
                            return this.el.animate(this.diff, n), i.promise()
                        }), t.when.apply(t, h.get()).done(function() {
                            o(), t.each(arguments, function() {
                                var e = this.el;
                                t.each(this.diff, function(t) {
                                    e.css(t, "")
                                })
                            }), l.complete.call(r[0])
                        })
                    })
                }, t.fn.extend({
                    _addClass: t.fn.addClass,
                    addClass: function(e, i, n, s) {
                        return i ? t.effects.animateClass.call(this, {
                            add: e
                        }, i, n, s) : this._addClass(e)
                    },
                    _removeClass: t.fn.removeClass,
                    removeClass: function(e, i, n, s) {
                        return i ? t.effects.animateClass.call(this, {
                            remove: e
                        }, i, n, s) : this._removeClass(e)
                    },
                    _toggleClass: t.fn.toggleClass,
                    toggleClass: function(i, n, s, o, r) {
                        return "boolean" == typeof n || n === e ? s ? t.effects.animateClass.call(this, n ? {
                            add: i
                        } : {
                            remove: i
                        }, s, o, r) : this._toggleClass(i, n) : t.effects.animateClass.call(this, {
                            toggle: i
                        }, n, s, o)
                    },
                    switchClass: function(e, i, n, s, o) {
                        return t.effects.animateClass.call(this, {
                            add: i,
                            remove: e
                        }, n, s, o)
                    }
                })
            }(),
            function() {
                function s(e, i, n, s) {
                    return t.isPlainObject(e) && (i = e, e = e.effect), e = {
                        effect: e
                    }, null == i && (i = {}), t.isFunction(i) && (s = i, n = null, i = {}), ("number" == typeof i || t.fx.speeds[i]) && (s = n, n = i, i = {}), t.isFunction(n) && (s = n, n = null), i && t.extend(e, i), n = n || i.duration, e.duration = t.fx.off ? 0 : "number" == typeof n ? n : n in t.fx.speeds ? t.fx.speeds[n] : t.fx.speeds._default, e.complete = s || i.complete, e
                }

                function o(e) {
                    return !(e && "number" != typeof e && !t.fx.speeds[e]) || "string" == typeof e && !t.effects.effect[e] && (!i || !t.effects[e])
                }
                t.extend(t.effects, {
                    version: "1.9.2",
                    save: function(t, e) {
                        for (var i = 0; i < e.length; i++) null !== e[i] && t.data(n + e[i], t[0].style[e[i]])
                    },
                    restore: function(t, i) {
                        var s, o;
                        for (o = 0; o < i.length; o++) null !== i[o] && (s = t.data(n + i[o]), s === e && (s = ""), t.css(i[o], s))
                    },
                    setMode: function(t, e) {
                        return "toggle" === e && (e = t.is(":hidden") ? "show" : "hide"), e
                    },
                    getBaseline: function(t, e) {
                        var i, n;
                        switch (t[0]) {
                            case "top":
                                i = 0;
                                break;
                            case "middle":
                                i = .5;
                                break;
                            case "bottom":
                                i = 1;
                                break;
                            default:
                                i = t[0] / e.height
                        }
                        switch (t[1]) {
                            case "left":
                                n = 0;
                                break;
                            case "center":
                                n = .5;
                                break;
                            case "right":
                                n = 1;
                                break;
                            default:
                                n = t[1] / e.width
                        }
                        return {
                            x: n,
                            y: i
                        }
                    },
                    createWrapper: function(e) {
                        if (e.parent().is(".ui-effects-wrapper")) return e.parent();
                        var i = {
                                width: e.outerWidth(!0),
                                height: e.outerHeight(!0),
                                float: e.css("float")
                            },
                            n = t("<div></div>").addClass("ui-effects-wrapper").css({
                                fontSize: "100%",
                                background: "transparent",
                                border: "none",
                                margin: 0,
                                padding: 0
                            }),
                            s = {
                                width: e.width(),
                                height: e.height()
                            },
                            o = document.activeElement;
                        try {
                            o.id
                        } catch (t) {
                            o = document.body
                        }
                        return e.wrap(n), (e[0] === o || t.contains(e[0], o)) && t(o).focus(), n = e.parent(), "static" === e.css("position") ? (n.css({
                            position: "relative"
                        }), e.css({
                            position: "relative"
                        })) : (t.extend(i, {
                            position: e.css("position"),
                            zIndex: e.css("z-index")
                        }), t.each(["top", "left", "bottom", "right"], function(t, n) {
                            i[n] = e.css(n), isNaN(parseInt(i[n], 10)) && (i[n] = "auto")
                        }), e.css({
                            position: "relative",
                            top: 0,
                            left: 0,
                            right: "auto",
                            bottom: "auto"
                        })), e.css(s), n.css(i).show()
                    },
                    removeWrapper: function(e) {
                        var i = document.activeElement;
                        return e.parent().is(".ui-effects-wrapper") && (e.parent().replaceWith(e), (e[0] === i || t.contains(e[0], i)) && t(i).focus()), e
                    },
                    setTransition: function(e, i, n, s) {
                        return s = s || {}, t.each(i, function(t, i) {
                            var o = e.cssUnit(i);
                            o[0] > 0 && (s[i] = o[0] * n + o[1])
                        }), s
                    }
                }), t.fn.extend({
                    effect: function() {
                        function e(e) {
                            function i() {
                                t.isFunction(o) && o.call(s[0]), t.isFunction(e) && e()
                            }
                            var s = t(this),
                                o = n.complete,
                                r = n.mode;
                            (s.is(":hidden") ? "hide" === r : "show" === r) ? i(): a.call(s[0], n, i)
                        }
                        var n = s.apply(this, arguments),
                            o = n.mode,
                            r = n.queue,
                            a = t.effects.effect[n.effect],
                            l = !a && i && t.effects[n.effect];
                        return t.fx.off || !a && !l ? o ? this[o](n.duration, n.complete) : this.each(function() {
                            n.complete && n.complete.call(this)
                        }) : a ? !1 === r ? this.each(e) : this.queue(r || "fx", e) : l.call(this, {
                            options: n,
                            duration: n.duration,
                            callback: n.complete,
                            mode: n.mode
                        })
                    },
                    _show: t.fn.show,
                    show: function(t) {
                        if (o(t)) return this._show.apply(this, arguments);
                        var e = s.apply(this, arguments);
                        return e.mode = "show", this.effect.call(this, e)
                    },
                    _hide: t.fn.hide,
                    hide: function(t) {
                        if (o(t)) return this._hide.apply(this, arguments);
                        var e = s.apply(this, arguments);
                        return e.mode = "hide", this.effect.call(this, e)
                    },
                    __toggle: t.fn.toggle,
                    toggle: function(e) {
                        if (o(e) || "boolean" == typeof e || t.isFunction(e)) return this.__toggle.apply(this, arguments);
                        var i = s.apply(this, arguments);
                        return i.mode = "toggle", this.effect.call(this, i)
                    },
                    cssUnit: function(e) {
                        var i = this.css(e),
                            n = [];
                        return t.each(["em", "px", "%", "pt"], function(t, e) {
                            i.indexOf(e) > 0 && (n = [parseFloat(i), e])
                        }), n
                    }
                })
            }(),
            function() {
                var e = {};
                t.each(["Quad", "Cubic", "Quart", "Quint", "Expo"], function(t, i) {
                    e[i] = function(e) {
                        return Math.pow(e, t + 2)
                    }
                }), t.extend(e, {
                    Sine: function(t) {
                        return 1 - Math.cos(t * Math.PI / 2)
                    },
                    Circ: function(t) {
                        return 1 - Math.sqrt(1 - t * t)
                    },
                    Elastic: function(t) {
                        return 0 === t || 1 === t ? t : -Math.pow(2, 8 * (t - 1)) * Math.sin((80 * (t - 1) - 7.5) * Math.PI / 15)
                    },
                    Back: function(t) {
                        return t * t * (3 * t - 2)
                    },
                    Bounce: function(t) {
                        for (var e, i = 4; t < ((e = Math.pow(2, --i)) - 1) / 11;);
                        return 1 / Math.pow(4, 3 - i) - 7.5625 * Math.pow((3 * e - 2) / 22 - t, 2)
                    }
                }), t.each(e, function(e, i) {
                    t.easing["easeIn" + e] = i, t.easing["easeOut" + e] = function(t) {
                        return 1 - i(1 - t)
                    }, t.easing["easeInOut" + e] = function(t) {
                        return t < .5 ? i(2 * t) / 2 : 1 - i(-2 * t + 2) / 2
                    }
                })
            }()
    }(jQuery), function(t, e) {
        var i = 0,
            n = {},
            s = {};
        n.height = n.paddingTop = n.paddingBottom = n.borderTopWidth = n.borderBottomWidth = "hide", s.height = s.paddingTop = s.paddingBottom = s.borderTopWidth = s.borderBottomWidth = "show", t.widget("ui.accordion", {
            version: "1.9.2",
            options: {
                active: 0,
                animate: {},
                collapsible: !1,
                event: "click",
                header: "> li > :first-child,> :not(li):even",
                heightStyle: "auto",
                icons: {
                    activeHeader: "ui-icon-triangle-1-s",
                    header: "ui-icon-triangle-1-e"
                },
                activate: null,
                beforeActivate: null
            },
            _create: function() {
                var e = this.accordionId = "ui-accordion-" + (this.element.attr("id") || ++i),
                    n = this.options;
                this.prevShow = this.prevHide = t(), this.element.addClass("ui-accordion ui-widget ui-helper-reset"), this.headers = this.element.find(n.header).addClass("ui-accordion-header ui-helper-reset ui-state-default ui-corner-all"), this._hoverable(this.headers), this._focusable(this.headers), this.headers.next().addClass("ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom").hide(), !n.collapsible && (!1 === n.active || null == n.active) && (n.active = 0), n.active < 0 && (n.active += this.headers.length), this.active = this._findActive(n.active).addClass("ui-accordion-header-active ui-state-active").toggleClass("ui-corner-all ui-corner-top"), this.active.next().addClass("ui-accordion-content-active").show(), this._createIcons(), this.refresh(), this.element.attr("role", "tablist"), this.headers.attr("role", "tab").each(function(i) {
                    var n = t(this),
                        s = n.attr("id"),
                        o = n.next(),
                        r = o.attr("id");
                    s || (s = e + "-header-" + i, n.attr("id", s)), r || (r = e + "-panel-" + i, o.attr("id", r)), n.attr("aria-controls", r), o.attr("aria-labelledby", s)
                }).next().attr("role", "tabpanel"), this.headers.not(this.active).attr({
                    "aria-selected": "false",
                    tabIndex: -1
                }).next().attr({
                    "aria-expanded": "false",
                    "aria-hidden": "true"
                }).hide(), this.active.length ? this.active.attr({
                    "aria-selected": "true",
                    tabIndex: 0
                }).next().attr({
                    "aria-expanded": "true",
                    "aria-hidden": "false"
                }) : this.headers.eq(0).attr("tabIndex", 0), this._on(this.headers, {
                    keydown: "_keydown"
                }), this._on(this.headers.next(), {
                    keydown: "_panelKeyDown"
                }), this._setupEvents(n.event)
            },
            _getCreateEventData: function() {
                return {
                    header: this.active,
                    content: this.active.length ? this.active.next() : t()
                }
            },
            _createIcons: function() {
                var e = this.options.icons;
                e && (t("<span>").addClass("ui-accordion-header-icon ui-icon " + e.header).prependTo(this.headers), this.active.children(".ui-accordion-header-icon").removeClass(e.header).addClass(e.activeHeader), this.headers.addClass("ui-accordion-icons"))
            },
            _destroyIcons: function() {
                this.headers.removeClass("ui-accordion-icons").children(".ui-accordion-header-icon").remove()
            },
            _destroy: function() {
                var t;
                this.element.removeClass("ui-accordion ui-widget ui-helper-reset").removeAttr("role"), this.headers.removeClass("ui-accordion-header ui-accordion-header-active ui-helper-reset ui-state-default ui-corner-all ui-state-active ui-state-disabled ui-corner-top").removeAttr("role").removeAttr("aria-selected").removeAttr("aria-controls").removeAttr("tabIndex").each(function() {
                    /^ui-accordion/.test(this.id) && this.removeAttribute("id")
                }), this._destroyIcons(), t = this.headers.next().css("display", "").removeAttr("role").removeAttr("aria-expanded").removeAttr("aria-hidden").removeAttr("aria-labelledby").removeClass("ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content ui-accordion-content-active ui-state-disabled").each(function() {
                    /^ui-accordion/.test(this.id) && this.removeAttribute("id")
                }), "content" !== this.options.heightStyle && t.css("height", "")
            },
            _setOption: function(t, e) {
                if ("active" === t) return void this._activate(e);
                "event" === t && (this.options.event && this._off(this.headers, this.options.event), this._setupEvents(e)), this._super(t, e), "collapsible" === t && !e && !1 === this.options.active && this._activate(0), "icons" === t && (this._destroyIcons(), e && this._createIcons()), "disabled" === t && this.headers.add(this.headers.next()).toggleClass("ui-state-disabled", !!e)
            },
            _keydown: function(e) {
                if (!e.altKey && !e.ctrlKey) {
                    var i = t.ui.keyCode,
                        n = this.headers.length,
                        s = this.headers.index(e.target),
                        o = !1;
                    switch (e.keyCode) {
                        case i.RIGHT:
                        case i.DOWN:
                            o = this.headers[(s + 1) % n];
                            break;
                        case i.LEFT:
                        case i.UP:
                            o = this.headers[(s - 1 + n) % n];
                            break;
                        case i.SPACE:
                        case i.ENTER:
                            this._eventHandler(e);
                            break;
                        case i.HOME:
                            o = this.headers[0];
                            break;
                        case i.END:
                            o = this.headers[n - 1]
                    }
                    o && (t(e.target).attr("tabIndex", -1), t(o).attr("tabIndex", 0), o.focus(), e.preventDefault())
                }
            },
            _panelKeyDown: function(e) {
                e.keyCode === t.ui.keyCode.UP && e.ctrlKey && t(e.currentTarget).prev().focus()
            },
            refresh: function() {
                var e, i, n = this.options.heightStyle,
                    s = this.element.parent();
                "fill" === n ? (t.support.minHeight || (i = s.css("overflow"), s.css("overflow", "hidden")), e = s.height(), this.element.siblings(":visible").each(function() {
                    var i = t(this),
                        n = i.css("position");
                    "absolute" !== n && "fixed" !== n && (e -= i.outerHeight(!0))
                }), i && s.css("overflow", i), this.headers.each(function() {
                    e -= t(this).outerHeight(!0)
                }), this.headers.next().each(function() {
                    t(this).height(Math.max(0, e - t(this).innerHeight() + t(this).height()))
                }).css("overflow", "auto")) : "auto" === n && (e = 0, this.headers.next().each(function() {
                    e = Math.max(e, t(this).css("height", "").height())
                }).height(e))
            },
            _activate: function(e) {
                var i = this._findActive(e)[0];
                i !== this.active[0] && (i = i || this.active[0], this._eventHandler({
                    target: i,
                    currentTarget: i,
                    preventDefault: t.noop
                }))
            },
            _findActive: function(e) {
                return "number" == typeof e ? this.headers.eq(e) : t()
            },
            _setupEvents: function(e) {
                var i = {};
                e && (t.each(e.split(" "), function(t, e) {
                    i[e] = "_eventHandler"
                }), this._on(this.headers, i))
            },
            _eventHandler: function(e) {
                var i = this.options,
                    n = this.active,
                    s = t(e.currentTarget),
                    o = s[0] === n[0],
                    r = o && i.collapsible,
                    a = r ? t() : s.next(),
                    l = n.next(),
                    h = {
                        oldHeader: n,
                        oldPanel: l,
                        newHeader: r ? t() : s,
                        newPanel: a
                    };
                e.preventDefault(), o && !i.collapsible || !1 === this._trigger("beforeActivate", e, h) || (i.active = !r && this.headers.index(s), this.active = o ? t() : s, this._toggle(h), n.removeClass("ui-accordion-header-active ui-state-active"), i.icons && n.children(".ui-accordion-header-icon").removeClass(i.icons.activeHeader).addClass(i.icons.header), o || (s.removeClass("ui-corner-all").addClass("ui-accordion-header-active ui-state-active ui-corner-top"), i.icons && s.children(".ui-accordion-header-icon").removeClass(i.icons.header).addClass(i.icons.activeHeader), s.next().addClass("ui-accordion-content-active")))
            },
            _toggle: function(e) {
                var i = e.newPanel,
                    n = this.prevShow.length ? this.prevShow : e.oldPanel;
                this.prevShow.add(this.prevHide).stop(!0, !0), this.prevShow = i, this.prevHide = n, this.options.animate ? this._animate(i, n, e) : (n.hide(), i.show(), this._toggleComplete(e)), n.attr({
                    "aria-expanded": "false",
                    "aria-hidden": "true"
                }), n.prev().attr("aria-selected", "false"), i.length && n.length ? n.prev().attr("tabIndex", -1) : i.length && this.headers.filter(function() {
                    return 0 === t(this).attr("tabIndex")
                }).attr("tabIndex", -1), i.attr({
                    "aria-expanded": "true",
                    "aria-hidden": "false"
                }).prev().attr({
                    "aria-selected": "true",
                    tabIndex: 0
                })
            },
            _animate: function(t, e, i) {
                var o, r, a, l = this,
                    h = 0,
                    c = t.length && (!e.length || t.index() < e.index()),
                    u = this.options.animate || {},
                    d = c && u.down || u,
                    p = function() {
                        l._toggleComplete(i)
                    };
                return "number" == typeof d && (a = d), "string" == typeof d && (r = d), r = r || d.easing || u.easing, a = a || d.duration || u.duration, e.length ? t.length ? (o = t.show().outerHeight(), e.animate(n, {
                    duration: a,
                    easing: r,
                    step: function(t, e) {
                        e.now = Math.round(t)
                    }
                }), t.hide().animate(s, {
                    duration: a,
                    easing: r,
                    complete: p,
                    step: function(t, i) {
                        i.now = Math.round(t), "height" !== i.prop ? h += i.now : "content" !== l.options.heightStyle && (i.now = Math.round(o - e.outerHeight() - h), h = 0)
                    }
                }), void 0) : e.animate(n, a, r, p) : t.animate(s, a, r, p)
            },
            _toggleComplete: function(t) {
                var e = t.oldPanel;
                e.removeClass("ui-accordion-content-active").prev().removeClass("ui-corner-top").addClass("ui-corner-all"), e.length && (e.parent()[0].className = e.parent()[0].className), this._trigger("activate", null, t)
            }
        }), !1 !== t.uiBackCompat && (function(t, e) {
            t.extend(e.options, {
                navigation: !1,
                navigationFilter: function() {
                    return this.href.toLowerCase() === location.href.toLowerCase()
                }
            });
            var i = e._create;
            e._create = function() {
                if (this.options.navigation) {
                    var e = this,
                        n = this.element.find(this.options.header),
                        s = n.next(),
                        o = n.add(s).find("a").filter(this.options.navigationFilter)[0];
                    o && n.add(s).each(function(i) {
                        if (t.contains(this, o)) return e.options.active = Math.floor(i / 2), !1
                    })
                }
                i.call(this)
            }
        }(jQuery, jQuery.ui.accordion.prototype), function(t, e) {
            t.extend(e.options, {
                heightStyle: null,
                autoHeight: !0,
                clearStyle: !1,
                fillSpace: !1
            });
            var i = e._create,
                n = e._setOption;
            t.extend(e, {
                _create: function() {
                    this.options.heightStyle = this.options.heightStyle || this._mergeHeightStyle(), i.call(this)
                },
                _setOption: function(t) {
                    "autoHeight" !== t && "clearStyle" !== t && "fillSpace" !== t || (this.options.heightStyle = this._mergeHeightStyle()), n.apply(this, arguments)
                },
                _mergeHeightStyle: function() {
                    var t = this.options;
                    return t.fillSpace ? "fill" : t.clearStyle ? "content" : t.autoHeight ? "auto" : void 0
                }
            })
        }(jQuery, jQuery.ui.accordion.prototype), function(t, e) {
            t.extend(e.options.icons, {
                activeHeader: null,
                headerSelected: "ui-icon-triangle-1-s"
            });
            var i = e._createIcons;
            e._createIcons = function() {
                this.options.icons && (this.options.icons.activeHeader = this.options.icons.activeHeader || this.options.icons.headerSelected), i.call(this)
            }
        }(jQuery, jQuery.ui.accordion.prototype), function(t, e) {
            e.activate = e._activate;
            var i = e._findActive;
            e._findActive = function(t) {
                return -1 === t && (t = !1), t && "number" != typeof t && -1 === (t = this.headers.index(this.headers.filter(t))) && (t = !1), i.call(this, t)
            }
        }(jQuery, jQuery.ui.accordion.prototype), jQuery.ui.accordion.prototype.resize = jQuery.ui.accordion.prototype.refresh, function(t, e) {
            t.extend(e.options, {
                change: null,
                changestart: null
            });
            var i = e._trigger;
            e._trigger = function(t, e, n) {
                var s = i.apply(this, arguments);
                return !!s && ("beforeActivate" === t ? s = i.call(this, "changestart", e, {
                    oldHeader: n.oldHeader,
                    oldContent: n.oldPanel,
                    newHeader: n.newHeader,
                    newContent: n.newPanel
                }) : "activate" === t && (s = i.call(this, "change", e, {
                    oldHeader: n.oldHeader,
                    oldContent: n.oldPanel,
                    newHeader: n.newHeader,
                    newContent: n.newPanel
                })), s)
            }
        }(jQuery, jQuery.ui.accordion.prototype), function(t, e) {
            t.extend(e.options, {
                animate: null,
                animated: "slide"
            });
            var i = e._create;
            e._create = function() {
                var t = this.options;
                null === t.animate && (t.animated ? "slide" === t.animated ? t.animate = 300 : "bounceslide" === t.animated ? t.animate = {
                    duration: 200,
                    down: {
                        easing: "easeOutBounce",
                        duration: 1e3
                    }
                } : t.animate = t.animated : t.animate = !1), i.call(this)
            }
        }(jQuery, jQuery.ui.accordion.prototype))
    }(jQuery), function(t, e) {
        var i = 0;
        t.widget("ui.autocomplete", {
            version: "1.9.2",
            defaultElement: "<input>",
            options: {
                appendTo: "body",
                autoFocus: !1,
                delay: 300,
                minLength: 1,
                position: {
                    my: "left top",
                    at: "left bottom",
                    collision: "none"
                },
                source: null,
                change: null,
                close: null,
                focus: null,
                open: null,
                response: null,
                search: null,
                select: null
            },
            pending: 0,
            _create: function() {
                var e, i, n;
                this.isMultiLine = this._isMultiLine(), this.valueMethod = this.element[this.element.is("input,textarea") ? "val" : "text"], this.isNewMenu = !0, this.element.addClass("ui-autocomplete-input").attr("autocomplete", "off"), this._on(this.element, {
                    keydown: function(s) {
                        if (this.element.prop("readOnly")) return e = !0, n = !0, i = !0, void 0;
                        e = !1, n = !1, i = !1;
                        var o = t.ui.keyCode;
                        switch (s.keyCode) {
                            case o.PAGE_UP:
                                e = !0, this._move("previousPage", s);
                                break;
                            case o.PAGE_DOWN:
                                e = !0, this._move("nextPage", s);
                                break;
                            case o.UP:
                                e = !0, this._keyEvent("previous", s);
                                break;
                            case o.DOWN:
                                e = !0, this._keyEvent("next", s);
                                break;
                            case o.ENTER:
                            case o.NUMPAD_ENTER:
                                this.menu.active && (e = !0, s.preventDefault(), this.menu.select(s));
                                break;
                            case o.TAB:
                                this.menu.active && this.menu.select(s);
                                break;
                            case o.ESCAPE:
                                this.menu.element.is(":visible") && (this._value(this.term), this.close(s), s.preventDefault());
                                break;
                            default:
                                i = !0, this._searchTimeout(s)
                        }
                    },
                    keypress: function(n) {
                        if (e) return e = !1, void n.preventDefault();
                        if (!i) {
                            var s = t.ui.keyCode;
                            switch (n.keyCode) {
                                case s.PAGE_UP:
                                    this._move("previousPage", n);
                                    break;
                                case s.PAGE_DOWN:
                                    this._move("nextPage", n);
                                    break;
                                case s.UP:
                                    this._keyEvent("previous", n);
                                    break;
                                case s.DOWN:
                                    this._keyEvent("next", n)
                            }
                        }
                    },
                    input: function(t) {
                        if (n) return n = !1, void t.preventDefault();
                        this._searchTimeout(t)
                    },
                    focus: function() {
                        this.selectedItem = null, this.previous = this._value()
                    },
                    blur: function(t) {
                        if (this.cancelBlur) return void delete this.cancelBlur;
                        clearTimeout(this.searching), this.close(t), this._change(t)
                    }
                }), this._initSource(), this.menu = t("<ul>").addClass("ui-autocomplete").appendTo(this.document.find(this.options.appendTo || "body")[0]).menu({
                    input: t(),
                    role: null
                }).zIndex(this.element.zIndex() + 1).hide().data("menu"), this._on(this.menu.element, {
                    mousedown: function(e) {
                        e.preventDefault(), this.cancelBlur = !0, this._delay(function() {
                            delete this.cancelBlur
                        });
                        var i = this.menu.element[0];
                        t(e.target).closest(".ui-menu-item").length || this._delay(function() {
                            var e = this;
                            this.document.one("mousedown", function(n) {
                                n.target !== e.element[0] && n.target !== i && !t.contains(i, n.target) && e.close()
                            })
                        })
                    },
                    menufocus: function(e, i) {
                        if (this.isNewMenu && (this.isNewMenu = !1, e.originalEvent && /^mouse/.test(e.originalEvent.type))) return this.menu.blur(), void this.document.one("mousemove", function() {
                            t(e.target).trigger(e.originalEvent)
                        });
                        var n = i.item.data("ui-autocomplete-item") || i.item.data("item.autocomplete");
                        !1 !== this._trigger("focus", e, {
                            item: n
                        }) ? e.originalEvent && /^key/.test(e.originalEvent.type) && this._value(n.value) : this.liveRegion.text(n.value)
                    },
                    menuselect: function(t, e) {
                        var i = e.item.data("ui-autocomplete-item") || e.item.data("item.autocomplete"),
                            n = this.previous;
                        this.element[0] !== this.document[0].activeElement && (this.element.focus(), this.previous = n, this._delay(function() {
                            this.previous = n, this.selectedItem = i
                        })), !1 !== this._trigger("select", t, {
                            item: i
                        }) && this._value(i.value), this.term = this._value(), this.close(t), this.selectedItem = i
                    }
                }), this.liveRegion = t("<span>", {
                    role: "status",
                    "aria-live": "polite"
                }).addClass("ui-helper-hidden-accessible").insertAfter(this.element), t.fn.bgiframe && this.menu.element.bgiframe(), this._on(this.window, {
                    beforeunload: function() {
                        this.element.removeAttr("autocomplete")
                    }
                })
            },
            _destroy: function() {
                clearTimeout(this.searching), this.element.removeClass("ui-autocomplete-input").removeAttr("autocomplete"), this.menu.element.remove(), this.liveRegion.remove()
            },
            _setOption: function(t, e) {
                this._super(t, e), "source" === t && this._initSource(), "appendTo" === t && this.menu.element.appendTo(this.document.find(e || "body")[0]), "disabled" === t && e && this.xhr && this.xhr.abort()
            },
            _isMultiLine: function() {
                return !!this.element.is("textarea") || !this.element.is("input") && this.element.prop("isContentEditable")
            },
            _initSource: function() {
                var e, i, n = this;
                t.isArray(this.options.source) ? (e = this.options.source, this.source = function(i, n) {
                    n(t.ui.autocomplete.filter(e, i.term))
                }) : "string" == typeof this.options.source ? (i = this.options.source, this.source = function(e, s) {
                    n.xhr && n.xhr.abort(), n.xhr = t.ajax({
                        url: i,
                        data: e,
                        dataType: "json",
                        success: function(t) {
                            s(t)
                        },
                        error: function() {
                            s([])
                        }
                    })
                }) : this.source = this.options.source
            },
            _searchTimeout: function(t) {
                clearTimeout(this.searching), this.searching = this._delay(function() {
                    this.term !== this._value() && (this.selectedItem = null, this.search(null, t))
                }, this.options.delay)
            },
            search: function(t, e) {
                return t = null != t ? t : this._value(), this.term = this._value(), t.length < this.options.minLength ? this.close(e) : !1 !== this._trigger("search", e) ? this._search(t) : void 0
            },
            _search: function(t) {
                this.pending++, this.element.addClass("ui-autocomplete-loading"), this.cancelSearch = !1, this.source({
                    term: t
                }, this._response())
            },
            _response: function() {
                var t = this,
                    e = ++i;
                return function(n) {
                    e === i && t.__response(n), --t.pending || t.element.removeClass("ui-autocomplete-loading")
                }
            },
            __response: function(t) {
                t && (t = this._normalize(t)), this._trigger("response", null, {
                    content: t
                }), !this.options.disabled && t && t.length && !this.cancelSearch ? (this._suggest(t), this._trigger("open")) : this._close()
            },
            close: function(t) {
                this.cancelSearch = !0, this._close(t)
            },
            _close: function(t) {
                this.menu.element.is(":visible") && (this.menu.element.hide(), this.menu.blur(), this.isNewMenu = !0, this._trigger("close", t))
            },
            _change: function(t) {
                this.previous !== this._value() && this._trigger("change", t, {
                    item: this.selectedItem
                })
            },
            _normalize: function(e) {
                return e.length && e[0].label && e[0].value ? e : t.map(e, function(e) {
                    return "string" == typeof e ? {
                        label: e,
                        value: e
                    } : t.extend({
                        label: e.label || e.value,
                        value: e.value || e.label
                    }, e)
                })
            },
            _suggest: function(e) {
                var i = this.menu.element.empty().zIndex(this.element.zIndex() + 1);
                this._renderMenu(i, e), this.menu.refresh(), i.show(), this._resizeMenu(), i.position(t.extend({ of: this.element
                }, this.options.position)), this.options.autoFocus && this.menu.next()
            },
            _resizeMenu: function() {
                var t = this.menu.element;
                t.outerWidth(Math.max(t.width("").outerWidth() + 1, this.element.outerWidth()))
            },
            _renderMenu: function(e, i) {
                var n = this;
                t.each(i, function(t, i) {
                    n._renderItemData(e, i)
                })
            },
            _renderItemData: function(t, e) {
                return this._renderItem(t, e).data("ui-autocomplete-item", e)
            },
            _renderItem: function(e, i) {
                return t("<li>").append(t("<a>").text(i.label)).appendTo(e)
            },
            _move: function(t, e) {
                return this.menu.element.is(":visible") ? this.menu.isFirstItem() && /^previous/.test(t) || this.menu.isLastItem() && /^next/.test(t) ? (this._value(this.term), void this.menu.blur()) : void this.menu[t](e) : void this.search(null, e)
            },
            widget: function() {
                return this.menu.element
            },
            _value: function() {
                return this.valueMethod.apply(this.element, arguments)
            },
            _keyEvent: function(t, e) {
                this.isMultiLine && !this.menu.element.is(":visible") || (this._move(t, e), e.preventDefault())
            }
        }), t.extend(t.ui.autocomplete, {
            escapeRegex: function(t) {
                return t.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, "\\$&")
            },
            filter: function(e, i) {
                var n = new RegExp(t.ui.autocomplete.escapeRegex(i), "i");
                return t.grep(e, function(t) {
                    return n.test(t.label || t.value || t)
                })
            }
        }), t.widget("ui.autocomplete", t.ui.autocomplete, {
            options: {
                messages: {
                    noResults: "No search results.",
                    results: function(t) {
                        return t + (t > 1 ? " results are" : " result is") + " available, use up and down arrow keys to navigate."
                    }
                }
            },
            __response: function(t) {
                var e;
                this._superApply(arguments), this.options.disabled || this.cancelSearch || (e = t && t.length ? this.options.messages.results(t.length) : this.options.messages.noResults, this.liveRegion.text(e))
            }
        })
    }(jQuery), function(t, e) {
        var i, n, s, o, r = "ui-button ui-widget ui-state-default ui-corner-all",
            a = "ui-button-icons-only ui-button-icon-only ui-button-text-icons ui-button-text-icon-primary ui-button-text-icon-secondary ui-button-text-only",
            l = function() {
                var e = t(this).find(":ui-button");
                setTimeout(function() {
                    e.button("refresh")
                }, 1)
            },
            h = function(e) {
                var i = e.name,
                    n = e.form,
                    s = t([]);
                return i && (s = n ? t(n).find("[name='" + i + "']") : t("[name='" + i + "']", e.ownerDocument).filter(function() {
                    return !this.form
                })), s
            };
        t.widget("ui.button", {
            version: "1.9.2",
            defaultElement: "<button>",
            options: {
                disabled: null,
                text: !0,
                label: null,
                icons: {
                    primary: null,
                    secondary: null
                }
            },
            _create: function() {
                this.element.closest("form").unbind("reset" + this.eventNamespace).bind("reset" + this.eventNamespace, l), "boolean" != typeof this.options.disabled ? this.options.disabled = !!this.element.prop("disabled") : this.element.prop("disabled", this.options.disabled), this._determineButtonType(), this.hasTitle = !!this.buttonElement.attr("title");
                var e = this,
                    a = this.options,
                    c = "checkbox" === this.type || "radio" === this.type,
                    u = c ? "" : "ui-state-active",
                    d = "ui-state-focus";
                null === a.label && (a.label = "input" === this.type ? this.buttonElement.val() : this.buttonElement.html()), this._hoverable(this.buttonElement), this.buttonElement.addClass(r).attr("role", "button").bind("mouseenter" + this.eventNamespace, function() {
                    a.disabled || this === i && t(this).addClass("ui-state-active")
                }).bind("mouseleave" + this.eventNamespace, function() {
                    a.disabled || t(this).removeClass(u)
                }).bind("click" + this.eventNamespace, function(t) {
                    a.disabled && (t.preventDefault(), t.stopImmediatePropagation())
                }), this.element.bind("focus" + this.eventNamespace, function() {
                    e.buttonElement.addClass(d)
                }).bind("blur" + this.eventNamespace, function() {
                    e.buttonElement.removeClass(d)
                }), c && (this.element.bind("change" + this.eventNamespace, function() {
                    o || e.refresh()
                }), this.buttonElement.bind("mousedown" + this.eventNamespace, function(t) {
                    a.disabled || (o = !1, n = t.pageX, s = t.pageY)
                }).bind("mouseup" + this.eventNamespace, function(t) {
                    a.disabled || n === t.pageX && s === t.pageY || (o = !0)
                })), "checkbox" === this.type ? this.buttonElement.bind("click" + this.eventNamespace, function() {
                    if (a.disabled || o) return !1;
                    t(this).toggleClass("ui-state-active"), e.buttonElement.attr("aria-pressed", e.element[0].checked)
                }) : "radio" === this.type ? this.buttonElement.bind("click" + this.eventNamespace, function() {
                    if (a.disabled || o) return !1;
                    t(this).addClass("ui-state-active"), e.buttonElement.attr("aria-pressed", "true");
                    var i = e.element[0];
                    h(i).not(i).map(function() {
                        return t(this).button("widget")[0]
                    }).removeClass("ui-state-active").attr("aria-pressed", "false")
                }) : (this.buttonElement.bind("mousedown" + this.eventNamespace, function() {
                    if (a.disabled) return !1;
                    t(this).addClass("ui-state-active"), i = this, e.document.one("mouseup", function() {
                        i = null
                    })
                }).bind("mouseup" + this.eventNamespace, function() {
                    if (a.disabled) return !1;
                    t(this).removeClass("ui-state-active")
                }).bind("keydown" + this.eventNamespace, function(e) {
                    if (a.disabled) return !1;
                    (e.keyCode === t.ui.keyCode.SPACE || e.keyCode === t.ui.keyCode.ENTER) && t(this).addClass("ui-state-active")
                }).bind("keyup" + this.eventNamespace, function() {
                    t(this).removeClass("ui-state-active")
                }), this.buttonElement.is("a") && this.buttonElement.keyup(function(e) {
                    e.keyCode === t.ui.keyCode.SPACE && t(this).click()
                })), this._setOption("disabled", a.disabled), this._resetButton()
            },
            _determineButtonType: function() {
                var t, e, i;
                this.element.is("[type=checkbox]") ? this.type = "checkbox" : this.element.is("[type=radio]") ? this.type = "radio" : this.element.is("input") ? this.type = "input" : this.type = "button", "checkbox" === this.type || "radio" === this.type ? (t = this.element.parents().last(), e = "label[for='" + this.element.attr("id") + "']", this.buttonElement = t.find(e), this.buttonElement.length || (t = t.length ? t.siblings() : this.element.siblings(), this.buttonElement = t.filter(e), this.buttonElement.length || (this.buttonElement = t.find(e))), this.element.addClass("ui-helper-hidden-accessible"), i = this.element.is(":checked"), i && this.buttonElement.addClass("ui-state-active"), this.buttonElement.prop("aria-pressed", i)) : this.buttonElement = this.element
            },
            widget: function() {
                return this.buttonElement
            },
            _destroy: function() {
                this.element.removeClass("ui-helper-hidden-accessible"), this.buttonElement.removeClass(r + " ui-state-hover ui-state-active  " + a).removeAttr("role").removeAttr("aria-pressed").html(this.buttonElement.find(".ui-button-text").html()), this.hasTitle || this.buttonElement.removeAttr("title")
            },
            _setOption: function(t, e) {
                if (this._super(t, e), "disabled" === t) return void(e ? this.element.prop("disabled", !0) : this.element.prop("disabled", !1));
                this._resetButton()
            },
            refresh: function() {
                var e = this.element.is("input, button") ? this.element.is(":disabled") : this.element.hasClass("ui-button-disabled");
                e !== this.options.disabled && this._setOption("disabled", e), "radio" === this.type ? h(this.element[0]).each(function() {
                    t(this).is(":checked") ? t(this).button("widget").addClass("ui-state-active").attr("aria-pressed", "true") : t(this).button("widget").removeClass("ui-state-active").attr("aria-pressed", "false")
                }) : "checkbox" === this.type && (this.element.is(":checked") ? this.buttonElement.addClass("ui-state-active").attr("aria-pressed", "true") : this.buttonElement.removeClass("ui-state-active").attr("aria-pressed", "false"))
            },
            _resetButton: function() {
                if ("input" === this.type) return void(this.options.label && this.element.val(this.options.label));
                var e = this.buttonElement.removeClass(a),
                    i = t("<span></span>", this.document[0]).addClass("ui-button-text").html(this.options.label).appendTo(e.empty()).text(),
                    n = this.options.icons,
                    s = n.primary && n.secondary,
                    o = [];
                n.primary || n.secondary ? (this.options.text && o.push("ui-button-text-icon" + (s ? "s" : n.primary ? "-primary" : "-secondary")), n.primary && e.prepend("<span class='ui-button-icon-primary ui-icon " + n.primary + "'></span>"), n.secondary && e.append("<span class='ui-button-icon-secondary ui-icon " + n.secondary + "'></span>"), this.options.text || (o.push(s ? "ui-button-icons-only" : "ui-button-icon-only"), this.hasTitle || e.attr("title", t.trim(i)))) : o.push("ui-button-text-only"), e.addClass(o.join(" "))
            }
        }), t.widget("ui.buttonset", {
            version: "1.9.2",
            options: {
                items: "button, input[type=button], input[type=submit], input[type=reset], input[type=checkbox], input[type=radio], a, :data(button)"
            },
            _create: function() {
                this.element.addClass("ui-buttonset")
            },
            _init: function() {
                this.refresh()
            },
            _setOption: function(t, e) {
                "disabled" === t && this.buttons.button("option", t, e), this._super(t, e)
            },
            refresh: function() {
                var e = "rtl" === this.element.css("direction");
                this.buttons = this.element.find(this.options.items).filter(":ui-button").button("refresh").end().not(":ui-button").button().end().map(function() {
                    return t(this).button("widget")[0]
                }).removeClass("ui-corner-all ui-corner-left ui-corner-right").filter(":first").addClass(e ? "ui-corner-right" : "ui-corner-left").end().filter(":last").addClass(e ? "ui-corner-left" : "ui-corner-right").end().end()
            },
            _destroy: function() {
                this.element.removeClass("ui-buttonset"), this.buttons.map(function() {
                    return t(this).button("widget")[0]
                }).removeClass("ui-corner-left ui-corner-right").end().button("destroy")
            }
        })
    }(jQuery), function($, undefined) {
        function Datepicker() {
            this.debug = !1, this._curInst = null, this._keyEvent = !1, this._disabledInputs = [], this._datepickerShowing = !1, this._inDialog = !1, this._mainDivId = "ui-datepicker-div", this._inlineClass = "ui-datepicker-inline", this._appendClass = "ui-datepicker-append", this._triggerClass = "ui-datepicker-trigger", this._dialogClass = "ui-datepicker-dialog", this._disableClass = "ui-datepicker-disabled", this._unselectableClass = "ui-datepicker-unselectable", this._currentClass = "ui-datepicker-current-day", this._dayOverClass = "ui-datepicker-days-cell-over", this.regional = [], this.regional[""] = {
                closeText: "Done",
                prevText: "Prev",
                nextText: "Next",
                currentText: "Today",
                monthNames: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                monthNamesShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                dayNames: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
                dayNamesShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
                dayNamesMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
                weekHeader: "Wk",
                dateFormat: "mm/dd/yy",
                firstDay: 0,
                isRTL: !1,
                showMonthAfterYear: !1,
                yearSuffix: ""
            }, this._defaults = {
                showOn: "focus",
                showAnim: "fadeIn",
                showOptions: {},
                defaultDate: null,
                appendText: "",
                buttonText: "...",
                buttonImage: "",
                buttonImageOnly: !1,
                hideIfNoPrevNext: !1,
                navigationAsDateFormat: !1,
                gotoCurrent: !1,
                changeMonth: !1,
                changeYear: !1,
                yearRange: "c-10:c+10",
                showOtherMonths: !1,
                selectOtherMonths: !1,
                showWeek: !1,
                calculateWeek: this.iso8601Week,
                shortYearCutoff: "+10",
                minDate: null,
                maxDate: null,
                duration: "fast",
                beforeShowDay: null,
                beforeShow: null,
                onSelect: null,
                onChangeMonthYear: null,
                onClose: null,
                numberOfMonths: 1,
                showCurrentAtPos: 0,
                stepMonths: 1,
                stepBigMonths: 12,
                altField: "",
                altFormat: "",
                constrainInput: !0,
                showButtonPanel: !1,
                autoSize: !1,
                disabled: !1
            }, $.extend(this._defaults, this.regional[""]), this.dpDiv = bindHover($('<div id="' + this._mainDivId + '" class="ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all"></div>'))
        }

        function bindHover(t) {
            var e = "button, .ui-datepicker-prev, .ui-datepicker-next, .ui-datepicker-calendar td a";
            return t.delegate(e, "mouseout", function() {
                $(this).removeClass("ui-state-hover"), -1 != this.className.indexOf("ui-datepicker-prev") && $(this).removeClass("ui-datepicker-prev-hover"), -1 != this.className.indexOf("ui-datepicker-next") && $(this).removeClass("ui-datepicker-next-hover")
            }).delegate(e, "mouseover", function() {
                $.datepicker._isDisabledDatepicker(instActive.inline ? t.parent()[0] : instActive.input[0]) || ($(this).parents(".ui-datepicker-calendar").find("a").removeClass("ui-state-hover"), $(this).addClass("ui-state-hover"), -1 != this.className.indexOf("ui-datepicker-prev") && $(this).addClass("ui-datepicker-prev-hover"), -1 != this.className.indexOf("ui-datepicker-next") && $(this).addClass("ui-datepicker-next-hover"))
            })
        }

        function extendRemove(t, e) {
            $.extend(t, e);
            for (var i in e) null != e[i] && e[i] != undefined || (t[i] = e[i]);
            return t
        }
        $.extend($.ui, {
            datepicker: {
                version: "1.9.2"
            }
        });
        var PROP_NAME = "datepicker",
            dpuuid = (new Date).getTime(),
            instActive;
        $.extend(Datepicker.prototype, {
            markerClassName: "hasDatepicker",
            maxRows: 4,
            log: function() {
                this.debug && console.log.apply("", arguments)
            },
            _widgetDatepicker: function() {
                return this.dpDiv
            },
            setDefaults: function(t) {
                return extendRemove(this._defaults, t || {}), this
            },
            _attachDatepicker: function(target, settings) {
                var inlineSettings = null;
                for (var attrName in this._defaults) {
                    var attrValue = target.getAttribute("date:" + attrName);
                    if (attrValue) {
                        inlineSettings = inlineSettings || {};
                        try {
                            inlineSettings[attrName] = eval(attrValue)
                        } catch (t) {
                            inlineSettings[attrName] = attrValue
                        }
                    }
                }
                var nodeName = target.nodeName.toLowerCase(),
                    inline = "div" == nodeName || "span" == nodeName;
                target.id || (this.uuid += 1, target.id = "dp" + this.uuid);
                var inst = this._newInst($(target), inline);
                inst.settings = $.extend({}, settings || {}, inlineSettings || {}), "input" == nodeName ? this._connectDatepicker(target, inst) : inline && this._inlineDatepicker(target, inst)
            },
            _newInst: function(t, e) {
                return {
                    id: t[0].id.replace(/([^A-Za-z0-9_-])/g, "\\\\$1"),
                    input: t,
                    selectedDay: 0,
                    selectedMonth: 0,
                    selectedYear: 0,
                    drawMonth: 0,
                    drawYear: 0,
                    inline: e,
                    dpDiv: e ? bindHover($('<div class="' + this._inlineClass + ' ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all"></div>')) : this.dpDiv
                }
            },
            _connectDatepicker: function(t, e) {
                var i = $(t);
                e.append = $([]), e.trigger = $([]), i.hasClass(this.markerClassName) || (this._attachments(i, e), i.addClass(this.markerClassName).keydown(this._doKeyDown).keypress(this._doKeyPress).keyup(this._doKeyUp).bind("setData.datepicker", function(t, i, n) {
                    e.settings[i] = n
                }).bind("getData.datepicker", function(t, i) {
                    return this._get(e, i)
                }), this._autoSize(e), $.data(t, PROP_NAME, e), e.settings.disabled && this._disableDatepicker(t))
            },
            _attachments: function(t, e) {
                var i = this._get(e, "appendText"),
                    n = this._get(e, "isRTL");
                e.append && e.append.remove(), i && (e.append = $('<span class="' + this._appendClass + '">' + i + "</span>"), t[n ? "before" : "after"](e.append)), t.unbind("focus", this._showDatepicker), e.trigger && e.trigger.remove();
                var s = this._get(e, "showOn");
                if (("focus" == s || "both" == s) && t.focus(this._showDatepicker), "button" == s || "both" == s) {
                    var o = this._get(e, "buttonText"),
                        r = this._get(e, "buttonImage");
                    e.trigger = $(this._get(e, "buttonImageOnly") ? $("<img/>").addClass(this._triggerClass).attr({
                        src: r,
                        alt: o,
                        title: o
                    }) : $('<button type="button"></button>').addClass(this._triggerClass).html("" == r ? o : $("<img/>").attr({
                        src: r,
                        alt: o,
                        title: o
                    }))), t[n ? "before" : "after"](e.trigger), e.trigger.click(function() {
                        return $.datepicker._datepickerShowing && $.datepicker._lastInput == t[0] ? $.datepicker._hideDatepicker() : $.datepicker._datepickerShowing && $.datepicker._lastInput != t[0] ? ($.datepicker._hideDatepicker(), $.datepicker._showDatepicker(t[0])) : $.datepicker._showDatepicker(t[0]), !1
                    })
                }
            },
            _autoSize: function(t) {
                if (this._get(t, "autoSize") && !t.inline) {
                    var e = new Date(2009, 11, 20),
                        i = this._get(t, "dateFormat");
                    if (i.match(/[DM]/)) {
                        var n = function(t) {
                            for (var e = 0, i = 0, n = 0; n < t.length; n++) t[n].length > e && (e = t[n].length, i = n);
                            return i
                        };
                        e.setMonth(n(this._get(t, i.match(/MM/) ? "monthNames" : "monthNamesShort"))),
                            e.setDate(n(this._get(t, i.match(/DD/) ? "dayNames" : "dayNamesShort")) + 20 - e.getDay())
                    }
                    t.input.attr("size", this._formatDate(t, e).length)
                }
            },
            _inlineDatepicker: function(t, e) {
                var i = $(t);
                i.hasClass(this.markerClassName) || (i.addClass(this.markerClassName).append(e.dpDiv).bind("setData.datepicker", function(t, i, n) {
                    e.settings[i] = n
                }).bind("getData.datepicker", function(t, i) {
                    return this._get(e, i)
                }), $.data(t, PROP_NAME, e), this._setDate(e, this._getDefaultDate(e), !0), this._updateDatepicker(e), this._updateAlternate(e), e.settings.disabled && this._disableDatepicker(t), e.dpDiv.css("display", "block"))
            },
            _dialogDatepicker: function(t, e, i, n, s) {
                var o = this._dialogInst;
                if (!o) {
                    this.uuid += 1;
                    var r = "dp" + this.uuid;
                    this._dialogInput = $('<input type="text" id="' + r + '" style="position: absolute; top: -100px; width: 0px;"/>'), this._dialogInput.keydown(this._doKeyDown), $("body").append(this._dialogInput), o = this._dialogInst = this._newInst(this._dialogInput, !1), o.settings = {}, $.data(this._dialogInput[0], PROP_NAME, o)
                }
                if (extendRemove(o.settings, n || {}), e = e && e.constructor == Date ? this._formatDate(o, e) : e, this._dialogInput.val(e), this._pos = s ? s.length ? s : [s.pageX, s.pageY] : null, !this._pos) {
                    var a = document.documentElement.clientWidth,
                        l = document.documentElement.clientHeight,
                        h = document.documentElement.scrollLeft || document.body.scrollLeft,
                        c = document.documentElement.scrollTop || document.body.scrollTop;
                    this._pos = [a / 2 - 100 + h, l / 2 - 150 + c]
                }
                return this._dialogInput.css("left", this._pos[0] + 20 + "px").css("top", this._pos[1] + "px"), o.settings.onSelect = i, this._inDialog = !0, this.dpDiv.addClass(this._dialogClass), this._showDatepicker(this._dialogInput[0]), $.blockUI && $.blockUI(this.dpDiv), $.data(this._dialogInput[0], PROP_NAME, o), this
            },
            _destroyDatepicker: function(t) {
                var e = $(t),
                    i = $.data(t, PROP_NAME);
                if (e.hasClass(this.markerClassName)) {
                    var n = t.nodeName.toLowerCase();
                    $.removeData(t, PROP_NAME), "input" == n ? (i.append.remove(), i.trigger.remove(), e.removeClass(this.markerClassName).unbind("focus", this._showDatepicker).unbind("keydown", this._doKeyDown).unbind("keypress", this._doKeyPress).unbind("keyup", this._doKeyUp)) : ("div" == n || "span" == n) && e.removeClass(this.markerClassName).empty()
                }
            },
            _enableDatepicker: function(t) {
                var e = $(t),
                    i = $.data(t, PROP_NAME);
                if (e.hasClass(this.markerClassName)) {
                    var n = t.nodeName.toLowerCase();
                    if ("input" == n) t.disabled = !1, i.trigger.filter("button").each(function() {
                        this.disabled = !1
                    }).end().filter("img").css({
                        opacity: "1.0",
                        cursor: ""
                    });
                    else if ("div" == n || "span" == n) {
                        var s = e.children("." + this._inlineClass);
                        s.children().removeClass("ui-state-disabled"), s.find("select.ui-datepicker-month, select.ui-datepicker-year").prop("disabled", !1)
                    }
                    this._disabledInputs = $.map(this._disabledInputs, function(e) {
                        return e == t ? null : e
                    })
                }
            },
            _disableDatepicker: function(t) {
                var e = $(t),
                    i = $.data(t, PROP_NAME);
                if (e.hasClass(this.markerClassName)) {
                    var n = t.nodeName.toLowerCase();
                    if ("input" == n) t.disabled = !0, i.trigger.filter("button").each(function() {
                        this.disabled = !0
                    }).end().filter("img").css({
                        opacity: "0.5",
                        cursor: "default"
                    });
                    else if ("div" == n || "span" == n) {
                        var s = e.children("." + this._inlineClass);
                        s.children().addClass("ui-state-disabled"), s.find("select.ui-datepicker-month, select.ui-datepicker-year").prop("disabled", !0)
                    }
                    this._disabledInputs = $.map(this._disabledInputs, function(e) {
                        return e == t ? null : e
                    }), this._disabledInputs[this._disabledInputs.length] = t
                }
            },
            _isDisabledDatepicker: function(t) {
                if (!t) return !1;
                for (var e = 0; e < this._disabledInputs.length; e++)
                    if (this._disabledInputs[e] == t) return !0;
                return !1
            },
            _getInst: function(t) {
                try {
                    return $.data(t, PROP_NAME)
                } catch (t) {
                    throw "Missing instance data for this datepicker"
                }
            },
            _optionDatepicker: function(t, e, i) {
                var n = this._getInst(t);
                if (2 == arguments.length && "string" == typeof e) return "defaults" == e ? $.extend({}, $.datepicker._defaults) : n ? "all" == e ? $.extend({}, n.settings) : this._get(n, e) : null;
                var s = e || {};
                if ("string" == typeof e && (s = {}, s[e] = i), n) {
                    this._curInst == n && this._hideDatepicker();
                    var o = this._getDateDatepicker(t, !0),
                        r = this._getMinMaxDate(n, "min"),
                        a = this._getMinMaxDate(n, "max");
                    extendRemove(n.settings, s), null !== r && s.dateFormat !== undefined && s.minDate === undefined && (n.settings.minDate = this._formatDate(n, r)), null !== a && s.dateFormat !== undefined && s.maxDate === undefined && (n.settings.maxDate = this._formatDate(n, a)), this._attachments($(t), n), this._autoSize(n), this._setDate(n, o), this._updateAlternate(n), this._updateDatepicker(n)
                }
            },
            _changeDatepicker: function(t, e, i) {
                this._optionDatepicker(t, e, i)
            },
            _refreshDatepicker: function(t) {
                var e = this._getInst(t);
                e && this._updateDatepicker(e)
            },
            _setDateDatepicker: function(t, e) {
                var i = this._getInst(t);
                i && (this._setDate(i, e), this._updateDatepicker(i), this._updateAlternate(i))
            },
            _getDateDatepicker: function(t, e) {
                var i = this._getInst(t);
                return i && !i.inline && this._setDateFromField(i, e), i ? this._getDate(i) : null
            },
            _doKeyDown: function(t) {
                var e = $.datepicker._getInst(t.target),
                    i = !0,
                    n = e.dpDiv.is(".ui-datepicker-rtl");
                if (e._keyEvent = !0, $.datepicker._datepickerShowing) switch (t.keyCode) {
                    case 9:
                        $.datepicker._hideDatepicker(), i = !1;
                        break;
                    case 13:
                        var s = $("td." + $.datepicker._dayOverClass + ":not(." + $.datepicker._currentClass + ")", e.dpDiv);
                        s[0] && $.datepicker._selectDay(t.target, e.selectedMonth, e.selectedYear, s[0]);
                        var o = $.datepicker._get(e, "onSelect");
                        if (o) {
                            var r = $.datepicker._formatDate(e);
                            o.apply(e.input ? e.input[0] : null, [r, e])
                        } else $.datepicker._hideDatepicker();
                        return !1;
                    case 27:
                        $.datepicker._hideDatepicker();
                        break;
                    case 33:
                        $.datepicker._adjustDate(t.target, t.ctrlKey ? -$.datepicker._get(e, "stepBigMonths") : -$.datepicker._get(e, "stepMonths"), "M");
                        break;
                    case 34:
                        $.datepicker._adjustDate(t.target, t.ctrlKey ? +$.datepicker._get(e, "stepBigMonths") : +$.datepicker._get(e, "stepMonths"), "M");
                        break;
                    case 35:
                        (t.ctrlKey || t.metaKey) && $.datepicker._clearDate(t.target), i = t.ctrlKey || t.metaKey;
                        break;
                    case 36:
                        (t.ctrlKey || t.metaKey) && $.datepicker._gotoToday(t.target), i = t.ctrlKey || t.metaKey;
                        break;
                    case 37:
                        (t.ctrlKey || t.metaKey) && $.datepicker._adjustDate(t.target, n ? 1 : -1, "D"), i = t.ctrlKey || t.metaKey, t.originalEvent.altKey && $.datepicker._adjustDate(t.target, t.ctrlKey ? -$.datepicker._get(e, "stepBigMonths") : -$.datepicker._get(e, "stepMonths"), "M");
                        break;
                    case 38:
                        (t.ctrlKey || t.metaKey) && $.datepicker._adjustDate(t.target, -7, "D"), i = t.ctrlKey || t.metaKey;
                        break;
                    case 39:
                        (t.ctrlKey || t.metaKey) && $.datepicker._adjustDate(t.target, n ? -1 : 1, "D"), i = t.ctrlKey || t.metaKey, t.originalEvent.altKey && $.datepicker._adjustDate(t.target, t.ctrlKey ? +$.datepicker._get(e, "stepBigMonths") : +$.datepicker._get(e, "stepMonths"), "M");
                        break;
                    case 40:
                        (t.ctrlKey || t.metaKey) && $.datepicker._adjustDate(t.target, 7, "D"), i = t.ctrlKey || t.metaKey;
                        break;
                    default:
                        i = !1
                } else 36 == t.keyCode && t.ctrlKey ? $.datepicker._showDatepicker(this) : i = !1;
                i && (t.preventDefault(), t.stopPropagation())
            },
            _doKeyPress: function(t) {
                var e = $.datepicker._getInst(t.target);
                if ($.datepicker._get(e, "constrainInput")) {
                    var i = $.datepicker._possibleChars($.datepicker._get(e, "dateFormat")),
                        n = String.fromCharCode(t.charCode == undefined ? t.keyCode : t.charCode);
                    return t.ctrlKey || t.metaKey || n < " " || !i || i.indexOf(n) > -1
                }
            },
            _doKeyUp: function(t) {
                var e = $.datepicker._getInst(t.target);
                if (e.input.val() != e.lastVal) try {
                    $.datepicker.parseDate($.datepicker._get(e, "dateFormat"), e.input ? e.input.val() : null, $.datepicker._getFormatConfig(e)) && ($.datepicker._setDateFromField(e), $.datepicker._updateAlternate(e), $.datepicker._updateDatepicker(e))
                } catch (t) {
                    $.datepicker.log(t)
                }
                return !0
            },
            _showDatepicker: function(t) {
                if (t = t.target || t, "input" != t.nodeName.toLowerCase() && (t = $("input", t.parentNode)[0]), !$.datepicker._isDisabledDatepicker(t) && $.datepicker._lastInput != t) {
                    var e = $.datepicker._getInst(t);
                    $.datepicker._curInst && $.datepicker._curInst != e && ($.datepicker._curInst.dpDiv.stop(!0, !0), e && $.datepicker._datepickerShowing && $.datepicker._hideDatepicker($.datepicker._curInst.input[0]));
                    var i = $.datepicker._get(e, "beforeShow"),
                        n = i ? i.apply(t, [t, e]) : {};
                    if (!1 !== n) {
                        extendRemove(e.settings, n), e.lastVal = null, $.datepicker._lastInput = t, $.datepicker._setDateFromField(e), $.datepicker._inDialog && (t.value = ""), $.datepicker._pos || ($.datepicker._pos = $.datepicker._findPos(t), $.datepicker._pos[1] += t.offsetHeight);
                        var s = !1;
                        $(t).parents().each(function() {
                            return !(s |= "fixed" == $(this).css("position"))
                        });
                        var o = {
                            left: $.datepicker._pos[0],
                            top: $.datepicker._pos[1]
                        };
                        if ($.datepicker._pos = null, e.dpDiv.empty(), e.dpDiv.css({
                                position: "absolute",
                                display: "block",
                                top: "-1000px"
                            }), $.datepicker._updateDatepicker(e), o = $.datepicker._checkOffset(e, o, s), e.dpDiv.css({
                                position: $.datepicker._inDialog && $.blockUI ? "static" : s ? "fixed" : "absolute",
                                display: "none",
                                left: o.left + "px",
                                top: o.top + "px"
                            }), !e.inline) {
                            var r = $.datepicker._get(e, "showAnim"),
                                a = $.datepicker._get(e, "duration"),
                                l = function() {
                                    var t = e.dpDiv.find("iframe.ui-datepicker-cover");
                                    if (t.length) {
                                        var i = $.datepicker._getBorders(e.dpDiv);
                                        t.css({
                                            left: -i[0],
                                            top: -i[1],
                                            width: e.dpDiv.outerWidth(),
                                            height: e.dpDiv.outerHeight()
                                        })
                                    }
                                };
                            e.dpDiv.zIndex($(t).zIndex() + 1), $.datepicker._datepickerShowing = !0, $.effects && ($.effects.effect[r] || $.effects[r]) ? e.dpDiv.show(r, $.datepicker._get(e, "showOptions"), a, l) : e.dpDiv[r || "show"](r ? a : null, l), (!r || !a) && l(), e.input.is(":visible") && !e.input.is(":disabled") && e.input.focus(), $.datepicker._curInst = e
                        }
                    }
                }
            },
            _updateDatepicker: function(t) {
                this.maxRows = 4;
                var e = $.datepicker._getBorders(t.dpDiv);
                instActive = t, t.dpDiv.empty().append(this._generateHTML(t)), this._attachHandlers(t);
                var i = t.dpDiv.find("iframe.ui-datepicker-cover");
                !i.length || i.css({
                    left: -e[0],
                    top: -e[1],
                    width: t.dpDiv.outerWidth(),
                    height: t.dpDiv.outerHeight()
                }), t.dpDiv.find("." + this._dayOverClass + " a").mouseover();
                var n = this._getNumberOfMonths(t),
                    s = n[1];
                if (t.dpDiv.removeClass("ui-datepicker-multi-2 ui-datepicker-multi-3 ui-datepicker-multi-4").width(""), s > 1 && t.dpDiv.addClass("ui-datepicker-multi-" + s).css("width", 17 * s + "em"), t.dpDiv[(1 != n[0] || 1 != n[1] ? "add" : "remove") + "Class"]("ui-datepicker-multi"), t.dpDiv[(this._get(t, "isRTL") ? "add" : "remove") + "Class"]("ui-datepicker-rtl"), t == $.datepicker._curInst && $.datepicker._datepickerShowing && t.input && t.input.is(":visible") && !t.input.is(":disabled") && t.input[0] != document.activeElement && t.input.focus(), t.yearshtml) {
                    var o = t.yearshtml;
                    setTimeout(function() {
                        o === t.yearshtml && t.yearshtml && t.dpDiv.find("select.ui-datepicker-year:first").replaceWith(t.yearshtml), o = t.yearshtml = null
                    }, 0)
                }
            },
            _getBorders: function(t) {
                var e = function(t) {
                    return {
                        thin: 1,
                        medium: 2,
                        thick: 3
                    } [t] || t
                };
                return [parseFloat(e(t.css("border-left-width"))), parseFloat(e(t.css("border-top-width")))]
            },
            _checkOffset: function(t, e, i) {
                var n = t.dpDiv.outerWidth(),
                    s = t.dpDiv.outerHeight(),
                    o = t.input ? t.input.outerWidth() : 0,
                    r = t.input ? t.input.outerHeight() : 0,
                    a = document.documentElement.clientWidth + (i ? 0 : $(document).scrollLeft()),
                    l = document.documentElement.clientHeight + (i ? 0 : $(document).scrollTop());
                return e.left -= this._get(t, "isRTL") ? n - o : 0, e.left -= i && e.left == t.input.offset().left ? $(document).scrollLeft() : 0, e.top -= i && e.top == t.input.offset().top + r ? $(document).scrollTop() : 0, e.left -= Math.min(e.left, e.left + n > a && a > n ? Math.abs(e.left + n - a) : 0), e.top -= Math.min(e.top, e.top + s > l && l > s ? Math.abs(s + r) : 0), e
            },
            _findPos: function(t) {
                for (var e = this._getInst(t), i = this._get(e, "isRTL"); t && ("hidden" == t.type || 1 != t.nodeType || $.expr.filters.hidden(t));) t = t[i ? "previousSibling" : "nextSibling"];
                var n = $(t).offset();
                return [n.left, n.top]
            },
            _hideDatepicker: function(t) {
                var e = this._curInst;
                if (e && (!t || e == $.data(t, PROP_NAME)) && this._datepickerShowing) {
                    var i = this._get(e, "showAnim"),
                        n = this._get(e, "duration"),
                        s = function() {
                            $.datepicker._tidyDialog(e)
                        };
                    $.effects && ($.effects.effect[i] || $.effects[i]) ? e.dpDiv.hide(i, $.datepicker._get(e, "showOptions"), n, s) : e.dpDiv["slideDown" == i ? "slideUp" : "fadeIn" == i ? "fadeOut" : "hide"](i ? n : null, s), i || s(), this._datepickerShowing = !1;
                    var o = this._get(e, "onClose");
                    o && o.apply(e.input ? e.input[0] : null, [e.input ? e.input.val() : "", e]), this._lastInput = null, this._inDialog && (this._dialogInput.css({
                        position: "absolute",
                        left: "0",
                        top: "-100px"
                    }), $.blockUI && ($.unblockUI(), $("body").append(this.dpDiv))), this._inDialog = !1
                }
            },
            _tidyDialog: function(t) {
                t.dpDiv.removeClass(this._dialogClass).unbind(".ui-datepicker-calendar")
            },
            _checkExternalClick: function(t) {
                if ($.datepicker._curInst) {
                    var e = $(t.target),
                        i = $.datepicker._getInst(e[0]);
                    (e[0].id != $.datepicker._mainDivId && 0 == e.parents("#" + $.datepicker._mainDivId).length && !e.hasClass($.datepicker.markerClassName) && !e.closest("." + $.datepicker._triggerClass).length && $.datepicker._datepickerShowing && (!$.datepicker._inDialog || !$.blockUI) || e.hasClass($.datepicker.markerClassName) && $.datepicker._curInst != i) && $.datepicker._hideDatepicker()
                }
            },
            _adjustDate: function(t, e, i) {
                var n = $(t),
                    s = this._getInst(n[0]);
                this._isDisabledDatepicker(n[0]) || (this._adjustInstDate(s, e + ("M" == i ? this._get(s, "showCurrentAtPos") : 0), i), this._updateDatepicker(s))
            },
            _gotoToday: function(t) {
                var e = $(t),
                    i = this._getInst(e[0]);
                if (this._get(i, "gotoCurrent") && i.currentDay) i.selectedDay = i.currentDay, i.drawMonth = i.selectedMonth = i.currentMonth, i.drawYear = i.selectedYear = i.currentYear;
                else {
                    var n = new Date;
                    i.selectedDay = n.getDate(), i.drawMonth = i.selectedMonth = n.getMonth(), i.drawYear = i.selectedYear = n.getFullYear()
                }
                this._notifyChange(i), this._adjustDate(e)
            },
            _selectMonthYear: function(t, e, i) {
                var n = $(t),
                    s = this._getInst(n[0]);
                s["selected" + ("M" == i ? "Month" : "Year")] = s["draw" + ("M" == i ? "Month" : "Year")] = parseInt(e.options[e.selectedIndex].value, 10), this._notifyChange(s), this._adjustDate(n)
            },
            _selectDay: function(t, e, i, n) {
                var s = $(t);
                if (!$(n).hasClass(this._unselectableClass) && !this._isDisabledDatepicker(s[0])) {
                    var o = this._getInst(s[0]);
                    o.selectedDay = o.currentDay = $("a", n).html(), o.selectedMonth = o.currentMonth = e, o.selectedYear = o.currentYear = i, this._selectDate(t, this._formatDate(o, o.currentDay, o.currentMonth, o.currentYear))
                }
            },
            _clearDate: function(t) {
                var e = $(t);
                this._getInst(e[0]);
                this._selectDate(e, "")
            },
            _selectDate: function(t, e) {
                var i = $(t),
                    n = this._getInst(i[0]);
                e = null != e ? e : this._formatDate(n), n.input && n.input.val(e), this._updateAlternate(n);
                var s = this._get(n, "onSelect");
                s ? s.apply(n.input ? n.input[0] : null, [e, n]) : n.input && n.input.trigger("change"), n.inline ? this._updateDatepicker(n) : (this._hideDatepicker(), this._lastInput = n.input[0], "object" != typeof n.input[0] && n.input.focus(), this._lastInput = null)
            },
            _updateAlternate: function(t) {
                var e = this._get(t, "altField");
                if (e) {
                    var i = this._get(t, "altFormat") || this._get(t, "dateFormat"),
                        n = this._getDate(t),
                        s = this.formatDate(i, n, this._getFormatConfig(t));
                    $(e).each(function() {
                        $(this).val(s)
                    })
                }
            },
            noWeekends: function(t) {
                var e = t.getDay();
                return [e > 0 && e < 6, ""]
            },
            iso8601Week: function(t) {
                var e = new Date(t.getTime());
                e.setDate(e.getDate() + 4 - (e.getDay() || 7));
                var i = e.getTime();
                return e.setMonth(0), e.setDate(1), Math.floor(Math.round((i - e) / 864e5) / 7) + 1
            },
            parseDate: function(t, e, i) {
                if (null == t || null == e) throw "Invalid arguments";
                if ("" == (e = "object" == typeof e ? e.toString() : e + "")) return null;
                var n = (i ? i.shortYearCutoff : null) || this._defaults.shortYearCutoff;
                n = "string" != typeof n ? n : (new Date).getFullYear() % 100 + parseInt(n, 10);
                for (var s = (i ? i.dayNamesShort : null) || this._defaults.dayNamesShort, o = (i ? i.dayNames : null) || this._defaults.dayNames, r = (i ? i.monthNamesShort : null) || this._defaults.monthNamesShort, a = (i ? i.monthNames : null) || this._defaults.monthNames, l = -1, h = -1, c = -1, u = -1, d = !1, p = function(e) {
                        var i = y + 1 < t.length && t.charAt(y + 1) == e;
                        return i && y++, i
                    }, f = function(t) {
                        var i = p(t),
                            n = "@" == t ? 14 : "!" == t ? 20 : "y" == t && i ? 4 : "o" == t ? 3 : 2,
                            s = new RegExp("^\\d{1," + n + "}"),
                            o = e.substring(v).match(s);
                        if (!o) throw "Missing number at position " + v;
                        return v += o[0].length, parseInt(o[0], 10)
                    }, g = function(t, i, n) {
                        var s = $.map(p(t) ? n : i, function(t, e) {
                                return [
                                    [e, t]
                                ]
                            }).sort(function(t, e) {
                                return -(t[1].length - e[1].length)
                            }),
                            o = -1;
                        if ($.each(s, function(t, i) {
                                var n = i[1];
                                if (e.substr(v, n.length).toLowerCase() == n.toLowerCase()) return o = i[0], v += n.length, !1
                            }), -1 != o) return o + 1;
                        throw "Unknown name at position " + v
                    }, m = function() {
                        if (e.charAt(v) != t.charAt(y)) throw "Unexpected literal at position " + v;
                        v++
                    }, v = 0, y = 0; y < t.length; y++)
                    if (d) "'" != t.charAt(y) || p("'") ? m() : d = !1;
                    else switch (t.charAt(y)) {
                        case "d":
                            c = f("d");
                            break;
                        case "D":
                            g("D", s, o);
                            break;
                        case "o":
                            u = f("o");
                            break;
                        case "m":
                            h = f("m");
                            break;
                        case "M":
                            h = g("M", r, a);
                            break;
                        case "y":
                            l = f("y");
                            break;
                        case "@":
                            var b = new Date(f("@"));
                            l = b.getFullYear(), h = b.getMonth() + 1, c = b.getDate();
                            break;
                        case "!":
                            var b = new Date((f("!") - this._ticksTo1970) / 1e4);
                            l = b.getFullYear(), h = b.getMonth() + 1, c = b.getDate();
                            break;
                        case "'":
                            p("'") ? m() : d = !0;
                            break;
                        default:
                            m()
                    }
                if (v < e.length) {
                    var _ = e.substr(v);
                    if (!/^\s+/.test(_)) throw "Extra/unparsed characters found in date: " + _
                }
                if (-1 == l ? l = (new Date).getFullYear() : l < 100 && (l += (new Date).getFullYear() - (new Date).getFullYear() % 100 + (l <= n ? 0 : -100)), u > -1)
                    for (h = 1, c = u;;) {
                        var w = this._getDaysInMonth(l, h - 1);
                        if (c <= w) break;
                        h++, c -= w
                    }
                var b = this._daylightSavingAdjust(new Date(l, h - 1, c));
                if (b.getFullYear() != l || b.getMonth() + 1 != h || b.getDate() != c) throw "Invalid date";
                return b
            },
            ATOM: "yy-mm-dd",
            COOKIE: "D, dd M yy",
            ISO_8601: "yy-mm-dd",
            RFC_822: "D, d M y",
            RFC_850: "DD, dd-M-y",
            RFC_1036: "D, d M y",
            RFC_1123: "D, d M yy",
            RFC_2822: "D, d M yy",
            RSS: "D, d M y",
            TICKS: "!",
            TIMESTAMP: "@",
            W3C: "yy-mm-dd",
            _ticksTo1970: 24 * (718685 + Math.floor(492.5) - Math.floor(19.7) + Math.floor(4.925)) * 60 * 60 * 1e7,
            formatDate: function(t, e, i) {
                if (!e) return "";
                var n = (i ? i.dayNamesShort : null) || this._defaults.dayNamesShort,
                    s = (i ? i.dayNames : null) || this._defaults.dayNames,
                    o = (i ? i.monthNamesShort : null) || this._defaults.monthNamesShort,
                    r = (i ? i.monthNames : null) || this._defaults.monthNames,
                    a = function(e) {
                        var i = d + 1 < t.length && t.charAt(d + 1) == e;
                        return i && d++, i
                    },
                    l = function(t, e, i) {
                        var n = "" + e;
                        if (a(t))
                            for (; n.length < i;) n = "0" + n;
                        return n
                    },
                    h = function(t, e, i, n) {
                        return a(t) ? n[e] : i[e]
                    },
                    c = "",
                    u = !1;
                if (e)
                    for (var d = 0; d < t.length; d++)
                        if (u) "'" != t.charAt(d) || a("'") ? c += t.charAt(d) : u = !1;
                        else switch (t.charAt(d)) {
                            case "d":
                                c += l("d", e.getDate(), 2);
                                break;
                            case "D":
                                c += h("D", e.getDay(), n, s);
                                break;
                            case "o":
                                c += l("o", Math.round((new Date(e.getFullYear(), e.getMonth(), e.getDate()).getTime() - new Date(e.getFullYear(), 0, 0).getTime()) / 864e5), 3);
                                break;
                            case "m":
                                c += l("m", e.getMonth() + 1, 2);
                                break;
                            case "M":
                                c += h("M", e.getMonth(), o, r);
                                break;
                            case "y":
                                c += a("y") ? e.getFullYear() : (e.getYear() % 100 < 10 ? "0" : "") + e.getYear() % 100;
                                break;
                            case "@":
                                c += e.getTime();
                                break;
                            case "!":
                                c += 1e4 * e.getTime() + this._ticksTo1970;
                                break;
                            case "'":
                                a("'") ? c += "'" : u = !0;
                                break;
                            default:
                                c += t.charAt(d)
                        }
                return c
            },
            _possibleChars: function(t) {
                for (var e = "", i = !1, n = function(e) {
                        var i = s + 1 < t.length && t.charAt(s + 1) == e;
                        return i && s++, i
                    }, s = 0; s < t.length; s++)
                    if (i) "'" != t.charAt(s) || n("'") ? e += t.charAt(s) : i = !1;
                    else switch (t.charAt(s)) {
                        case "d":
                        case "m":
                        case "y":
                        case "@":
                            e += "0123456789";
                            break;
                        case "D":
                        case "M":
                            return null;
                        case "'":
                            n("'") ? e += "'" : i = !0;
                            break;
                        default:
                            e += t.charAt(s)
                    }
                return e
            },
            _get: function(t, e) {
                return t.settings[e] !== undefined ? t.settings[e] : this._defaults[e]
            },
            _setDateFromField: function(t, e) {
                if (t.input.val() != t.lastVal) {
                    var i, n, s = this._get(t, "dateFormat"),
                        o = t.lastVal = t.input ? t.input.val() : null;
                    i = n = this._getDefaultDate(t);
                    var r = this._getFormatConfig(t);
                    try {
                        i = this.parseDate(s, o, r) || n
                    } catch (t) {
                        this.log(t), o = e ? "" : o
                    }
                    t.selectedDay = i.getDate(), t.drawMonth = t.selectedMonth = i.getMonth(), t.drawYear = t.selectedYear = i.getFullYear(), t.currentDay = o ? i.getDate() : 0, t.currentMonth = o ? i.getMonth() : 0, t.currentYear = o ? i.getFullYear() : 0, this._adjustInstDate(t)
                }
            },
            _getDefaultDate: function(t) {
                return this._restrictMinMax(t, this._determineDate(t, this._get(t, "defaultDate"), new Date))
            },
            _determineDate: function(t, e, i) {
                var n = null == e || "" === e ? i : "string" == typeof e ? function(e) {
                    try {
                        return $.datepicker.parseDate($.datepicker._get(t, "dateFormat"), e, $.datepicker._getFormatConfig(t))
                    } catch (t) {}
                    for (var i = (e.toLowerCase().match(/^c/) ? $.datepicker._getDate(t) : null) || new Date, n = i.getFullYear(), s = i.getMonth(), o = i.getDate(), r = /([+-]?[0-9]+)\s*(d|D|w|W|m|M|y|Y)?/g, a = r.exec(e); a;) {
                        switch (a[2] || "d") {
                            case "d":
                            case "D":
                                o += parseInt(a[1], 10);
                                break;
                            case "w":
                            case "W":
                                o += 7 * parseInt(a[1], 10);
                                break;
                            case "m":
                            case "M":
                                s += parseInt(a[1], 10), o = Math.min(o, $.datepicker._getDaysInMonth(n, s));
                                break;
                            case "y":
                            case "Y":
                                n += parseInt(a[1], 10), o = Math.min(o, $.datepicker._getDaysInMonth(n, s))
                        }
                        a = r.exec(e)
                    }
                    return new Date(n, s, o)
                }(e) : "number" == typeof e ? isNaN(e) ? i : function(t) {
                    var e = new Date;
                    return e.setDate(e.getDate() + t), e
                }(e) : new Date(e.getTime());
                return n = n && "Invalid Date" == n.toString() ? i : n, n && (n.setHours(0), n.setMinutes(0), n.setSeconds(0), n.setMilliseconds(0)), this._daylightSavingAdjust(n)
            },
            _daylightSavingAdjust: function(t) {
                return t ? (t.setHours(t.getHours() > 12 ? t.getHours() + 2 : 0), t) : null
            },
            _setDate: function(t, e, i) {
                var n = !e,
                    s = t.selectedMonth,
                    o = t.selectedYear,
                    r = this._restrictMinMax(t, this._determineDate(t, e, new Date));
                t.selectedDay = t.currentDay = r.getDate(), t.drawMonth = t.selectedMonth = t.currentMonth = r.getMonth(), t.drawYear = t.selectedYear = t.currentYear = r.getFullYear(), (s != t.selectedMonth || o != t.selectedYear) && !i && this._notifyChange(t), this._adjustInstDate(t), t.input && t.input.val(n ? "" : this._formatDate(t))
            },
            _getDate: function(t) {
                return !t.currentYear || t.input && "" == t.input.val() ? null : this._daylightSavingAdjust(new Date(t.currentYear, t.currentMonth, t.currentDay))
            },
            _attachHandlers: function(t) {
                var e = this._get(t, "stepMonths"),
                    i = "#" + t.id.replace(/\\\\/g, "\\");
                t.dpDiv.find("[data-handler]").map(function() {
                    var t = {
                        prev: function() {
                            window["DP_jQuery_" + dpuuid].datepicker._adjustDate(i, -e, "M")
                        },
                        next: function() {
                            window["DP_jQuery_" + dpuuid].datepicker._adjustDate(i, +e, "M")
                        },
                        hide: function() {
                            window["DP_jQuery_" + dpuuid].datepicker._hideDatepicker()
                        },
                        today: function() {
                            window["DP_jQuery_" + dpuuid].datepicker._gotoToday(i)
                        },
                        selectDay: function() {
                            return window["DP_jQuery_" + dpuuid].datepicker._selectDay(i, +this.getAttribute("data-month"), +this.getAttribute("data-year"), this), !1
                        },
                        selectMonth: function() {
                            return window["DP_jQuery_" + dpuuid].datepicker._selectMonthYear(i, this, "M"), !1
                        },
                        selectYear: function() {
                            return window["DP_jQuery_" + dpuuid].datepicker._selectMonthYear(i, this, "Y"), !1
                        }
                    };
                    $(this).bind(this.getAttribute("data-event"), t[this.getAttribute("data-handler")])
                })
            },
            _generateHTML: function(t) {
                var e = new Date;
                e = this._daylightSavingAdjust(new Date(e.getFullYear(), e.getMonth(), e.getDate()));
                var i = this._get(t, "isRTL"),
                    n = this._get(t, "showButtonPanel"),
                    s = this._get(t, "hideIfNoPrevNext"),
                    o = this._get(t, "navigationAsDateFormat"),
                    r = this._getNumberOfMonths(t),
                    a = this._get(t, "showCurrentAtPos"),
                    l = this._get(t, "stepMonths"),
                    h = 1 != r[0] || 1 != r[1],
                    c = this._daylightSavingAdjust(t.currentDay ? new Date(t.currentYear, t.currentMonth, t.currentDay) : new Date(9999, 9, 9)),
                    u = this._getMinMaxDate(t, "min"),
                    d = this._getMinMaxDate(t, "max"),
                    p = t.drawMonth - a,
                    f = t.drawYear;
                if (p < 0 && (p += 12, f--), d) {
                    var g = this._daylightSavingAdjust(new Date(d.getFullYear(), d.getMonth() - r[0] * r[1] + 1, d.getDate()));
                    for (g = u && g < u ? u : g; this._daylightSavingAdjust(new Date(f, p, 1)) > g;) --p < 0 && (p = 11, f--)
                }
                t.drawMonth = p, t.drawYear = f;
                var m = this._get(t, "prevText");
                m = o ? this.formatDate(m, this._daylightSavingAdjust(new Date(f, p - l, 1)), this._getFormatConfig(t)) : m;
                var v = this._canAdjustMonth(t, -1, f, p) ? '<a class="ui-datepicker-prev ui-corner-all" data-handler="prev" data-event="click" title="' + m + '"><span class="ui-icon ui-icon-circle-triangle-' + (i ? "e" : "w") + '">' + m + "</span></a>" : s ? "" : '<a class="ui-datepicker-prev ui-corner-all ui-state-disabled" title="' + m + '"><span class="ui-icon ui-icon-circle-triangle-' + (i ? "e" : "w") + '">' + m + "</span></a>",
                    y = this._get(t, "nextText");
                y = o ? this.formatDate(y, this._daylightSavingAdjust(new Date(f, p + l, 1)), this._getFormatConfig(t)) : y;
                var b = this._canAdjustMonth(t, 1, f, p) ? '<a class="ui-datepicker-next ui-corner-all" data-handler="next" data-event="click" title="' + y + '"><span class="ui-icon ui-icon-circle-triangle-' + (i ? "w" : "e") + '">' + y + "</span></a>" : s ? "" : '<a class="ui-datepicker-next ui-corner-all ui-state-disabled" title="' + y + '"><span class="ui-icon ui-icon-circle-triangle-' + (i ? "w" : "e") + '">' + y + "</span></a>",
                    _ = this._get(t, "currentText"),
                    w = this._get(t, "gotoCurrent") && t.currentDay ? c : e;
                _ = o ? this.formatDate(_, w, this._getFormatConfig(t)) : _;
                var x = t.inline ? "" : '<button type="button" class="ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all" data-handler="hide" data-event="click">' + this._get(t, "closeText") + "</button>",
                    C = n ? '<div class="ui-datepicker-buttonpane ui-widget-content">' + (i ? x : "") + (this._isInRange(t, w) ? '<button type="button" class="ui-datepicker-current ui-state-default ui-priority-secondary ui-corner-all" data-handler="today" data-event="click">' + _ + "</button>" : "") + (i ? "" : x) + "</div>" : "",
                    k = parseInt(this._get(t, "firstDay"), 10);
                k = isNaN(k) ? 0 : k;
                for (var T = this._get(t, "showWeek"), D = this._get(t, "dayNames"), S = (this._get(t, "dayNamesShort"), this._get(t, "dayNamesMin")), A = this._get(t, "monthNames"), E = this._get(t, "monthNamesShort"), I = this._get(t, "beforeShowDay"), P = this._get(t, "showOtherMonths"), N = this._get(t, "selectOtherMonths"), M = (this._get(t, "calculateWeek") || this.iso8601Week, this._getDefaultDate(t)), O = "", H = 0; H < r[0]; H++) {
                    var j = "";
                    this.maxRows = 4;
                    for (var z = 0; z < r[1]; z++) {
                        var L = this._daylightSavingAdjust(new Date(f, p, t.selectedDay)),
                            R = " ui-corner-all",
                            W = "";
                        if (h) {
                            if (W += '<div class="ui-datepicker-group', r[1] > 1) switch (z) {
                                case 0:
                                    W += " ui-datepicker-group-first", R = " ui-corner-" + (i ? "right" : "left");
                                    break;
                                case r[1] - 1:
                                    W += " ui-datepicker-group-last", R = " ui-corner-" + (i ? "left" : "right");
                                    break;
                                default:
                                    W += " ui-datepicker-group-middle", R = ""
                            }
                            W += '">'
                        }
                        W += '<div class="ui-datepicker-header ui-widget-header ui-helper-clearfix' + R + '">' + (/all|left/.test(R) && 0 == H ? i ? b : v : "") + (/all|right/.test(R) && 0 == H ? i ? v : b : "") + this._generateMonthYearHeader(t, p, f, u, d, H > 0 || z > 0, A, E) + '</div><table class="ui-datepicker-calendar"><thead><tr>';
                        for (var F = T ? '<th class="ui-datepicker-week-col">' + this._get(t, "weekHeader") + "</th>" : "", q = 0; q < 7; q++) {
                            var B = (q + k) % 7;
                            F += "<th" + ((q + k + 6) % 7 >= 5 ? ' class="ui-datepicker-week-end"' : "") + '><span title="' + D[B] + '">' + S[B] + "</span></th>"
                        }
                        W += F + "</tr></thead><tbody>";
                        var U = this._getDaysInMonth(f, p);
                        f == t.selectedYear && p == t.selectedMonth && (t.selectedDay = Math.min(t.selectedDay, U));
                        var Y = (this._getFirstDayOfMonth(f, p) - k + 7) % 7,
                            V = Math.ceil((Y + U) / 7),
                            Q = h && this.maxRows > V ? this.maxRows : V;
                        this.maxRows = Q;
                        for (var K = this._daylightSavingAdjust(new Date(f, p, 1 - Y)), X = 0; X < Q; X++) {
                            W += "<tr>";
                            for (var G = T ? '<td class="ui-datepicker-week-col">' + this._get(t, "calculateWeek")(K) + "</td>" : "", q = 0; q < 7; q++) {
                                var Z = I ? I.apply(t.input ? t.input[0] : null, [K]) : [!0, ""],
                                    J = K.getMonth() != p,
                                    tt = J && !N || !Z[0] || u && K < u || d && K > d;
                                G += '<td class="' + ((q + k + 6) % 7 >= 5 ? " ui-datepicker-week-end" : "") + (J ? " ui-datepicker-other-month" : "") + (K.getTime() == L.getTime() && p == t.selectedMonth && t._keyEvent || M.getTime() == K.getTime() && M.getTime() == L.getTime() ? " " + this._dayOverClass : "") + (tt ? " " + this._unselectableClass + " ui-state-disabled" : "") + (J && !P ? "" : " " + Z[1] + (K.getTime() == c.getTime() ? " " + this._currentClass : "") + (K.getTime() == e.getTime() ? " ui-datepicker-today" : "")) + '"' + (J && !P || !Z[2] ? "" : ' title="' + Z[2] + '"') + (tt ? "" : ' data-handler="selectDay" data-event="click" data-month="' + K.getMonth() + '" data-year="' + K.getFullYear() + '"') + ">" + (J && !P ? "&#xa0;" : tt ? '<span class="ui-state-default">' + K.getDate() + "</span>" : '<a class="ui-state-default' + (K.getTime() == e.getTime() ? " ui-state-highlight" : "") + (K.getTime() == c.getTime() ? " ui-state-active" : "") + (J ? " ui-priority-secondary" : "") + '" href="#">' + K.getDate() + "</a>") + "</td>", K.setDate(K.getDate() + 1), K = this._daylightSavingAdjust(K)
                            }
                            W += G + "</tr>"
                        }
                        p++, p > 11 && (p = 0, f++), W += "</tbody></table>" + (h ? "</div>" + (r[0] > 0 && z == r[1] - 1 ? '<div class="ui-datepicker-row-break"></div>' : "") : ""), j += W
                    }
                    O += j
                }
                return O += C + ($.ui.ie6 && !t.inline ? '<iframe src="javascript:false;" class="ui-datepicker-cover" frameborder="0"></iframe>' : ""), t._keyEvent = !1, O
            },
            _generateMonthYearHeader: function(t, e, i, n, s, o, r, a) {
                var l = this._get(t, "changeMonth"),
                    h = this._get(t, "changeYear"),
                    c = this._get(t, "showMonthAfterYear"),
                    u = '<div class="ui-datepicker-title">',
                    d = "";
                if (o || !l) d += '<span class="ui-datepicker-month">' + r[e] + "</span>";
                else {
                    var p = n && n.getFullYear() == i,
                        f = s && s.getFullYear() == i;
                    d += '<select class="ui-datepicker-month" data-handler="selectMonth" data-event="change">';
                    for (var g = 0; g < 12; g++)(!p || g >= n.getMonth()) && (!f || g <= s.getMonth()) && (d += '<option value="' + g + '"' + (g == e ? ' selected="selected"' : "") + ">" + a[g] + "</option>");
                    d += "</select>"
                }
                if (c || (u += d + (!o && l && h ? "" : "&#xa0;")), !t.yearshtml)
                    if (t.yearshtml = "", o || !h) u += '<span class="ui-datepicker-year">' + i + "</span>";
                    else {
                        var m = this._get(t, "yearRange").split(":"),
                            v = (new Date).getFullYear(),
                            y = function(t) {
                                var e = t.match(/c[+-].*/) ? i + parseInt(t.substring(1), 10) : t.match(/[+-].*/) ? v + parseInt(t, 10) : parseInt(t, 10);
                                return isNaN(e) ? v : e
                            },
                            b = y(m[0]),
                            _ = Math.max(b, y(m[1] || ""));
                        for (b = n ? Math.max(b, n.getFullYear()) : b, _ = s ? Math.min(_, s.getFullYear()) : _, t.yearshtml += '<select class="ui-datepicker-year" data-handler="selectYear" data-event="change">'; b <= _; b++) t.yearshtml += '<option value="' + b + '"' + (b == i ? ' selected="selected"' : "") + ">" + b + "</option>";
                        t.yearshtml += "</select>", u += t.yearshtml, t.yearshtml = null
                    } return u += this._get(t, "yearSuffix"), c && (u += (!o && l && h ? "" : "&#xa0;") + d), u += "</div>"
            },
            _adjustInstDate: function(t, e, i) {
                var n = t.drawYear + ("Y" == i ? e : 0),
                    s = t.drawMonth + ("M" == i ? e : 0),
                    o = Math.min(t.selectedDay, this._getDaysInMonth(n, s)) + ("D" == i ? e : 0),
                    r = this._restrictMinMax(t, this._daylightSavingAdjust(new Date(n, s, o)));
                t.selectedDay = r.getDate(), t.drawMonth = t.selectedMonth = r.getMonth(), t.drawYear = t.selectedYear = r.getFullYear(), ("M" == i || "Y" == i) && this._notifyChange(t)
            },
            _restrictMinMax: function(t, e) {
                var i = this._getMinMaxDate(t, "min"),
                    n = this._getMinMaxDate(t, "max"),
                    s = i && e < i ? i : e;
                return s = n && s > n ? n : s
            },
            _notifyChange: function(t) {
                var e = this._get(t, "onChangeMonthYear");
                e && e.apply(t.input ? t.input[0] : null, [t.selectedYear, t.selectedMonth + 1, t])
            },
            _getNumberOfMonths: function(t) {
                var e = this._get(t, "numberOfMonths");
                return null == e ? [1, 1] : "number" == typeof e ? [1, e] : e
            },
            _getMinMaxDate: function(t, e) {
                return this._determineDate(t, this._get(t, e + "Date"), null)
            },
            _getDaysInMonth: function(t, e) {
                return 32 - this._daylightSavingAdjust(new Date(t, e, 32)).getDate()
            },
            _getFirstDayOfMonth: function(t, e) {
                return new Date(t, e, 1).getDay()
            },
            _canAdjustMonth: function(t, e, i, n) {
                var s = this._getNumberOfMonths(t),
                    o = this._daylightSavingAdjust(new Date(i, n + (e < 0 ? e : s[0] * s[1]), 1));
                return e < 0 && o.setDate(this._getDaysInMonth(o.getFullYear(), o.getMonth())), this._isInRange(t, o)
            },
            _isInRange: function(t, e) {
                var i = this._getMinMaxDate(t, "min"),
                    n = this._getMinMaxDate(t, "max");
                return (!i || e.getTime() >= i.getTime()) && (!n || e.getTime() <= n.getTime())
            },
            _getFormatConfig: function(t) {
                var e = this._get(t, "shortYearCutoff");
                return e = "string" != typeof e ? e : (new Date).getFullYear() % 100 + parseInt(e, 10), {
                    shortYearCutoff: e,
                    dayNamesShort: this._get(t, "dayNamesShort"),
                    dayNames: this._get(t, "dayNames"),
                    monthNamesShort: this._get(t, "monthNamesShort"),
                    monthNames: this._get(t, "monthNames")
                }
            },
            _formatDate: function(t, e, i, n) {
                e || (t.currentDay = t.selectedDay, t.currentMonth = t.selectedMonth, t.currentYear = t.selectedYear);
                var s = e ? "object" == typeof e ? e : this._daylightSavingAdjust(new Date(n, i, e)) : this._daylightSavingAdjust(new Date(t.currentYear, t.currentMonth, t.currentDay));
                return this.formatDate(this._get(t, "dateFormat"), s, this._getFormatConfig(t))
            }
        }), $.fn.datepicker = function(t) {
            if (!this.length) return this;
            $.datepicker.initialized || ($(document).mousedown($.datepicker._checkExternalClick).find(document.body).append($.datepicker.dpDiv), $.datepicker.initialized = !0);
            var e = Array.prototype.slice.call(arguments, 1);
            return "string" != typeof t || "isDisabled" != t && "getDate" != t && "widget" != t ? "option" == t && 2 == arguments.length && "string" == typeof arguments[1] ? $.datepicker["_" + t + "Datepicker"].apply($.datepicker, [this[0]].concat(e)) : this.each(function() {
                "string" == typeof t ? $.datepicker["_" + t + "Datepicker"].apply($.datepicker, [this].concat(e)) : $.datepicker._attachDatepicker(this, t)
            }) : $.datepicker["_" + t + "Datepicker"].apply($.datepicker, [this[0]].concat(e))
        }, $.datepicker = new Datepicker, $.datepicker.initialized = !1, $.datepicker.uuid = (new Date).getTime(), $.datepicker.version = "1.9.2", window["DP_jQuery_" + dpuuid] = $
    }(jQuery), function(t, e) {
        var i = "ui-dialog ui-widget ui-widget-content ui-corner-all ",
            n = {
                buttons: !0,
                height: !0,
                maxHeight: !0,
                maxWidth: !0,
                minHeight: !0,
                minWidth: !0,
                width: !0
            },
            s = {
                maxHeight: !0,
                maxWidth: !0,
                minHeight: !0,
                minWidth: !0
            };
        t.widget("ui.dialog", {
            version: "1.9.2",
            options: {
                autoOpen: !0,
                buttons: {},
                closeOnEscape: !0,
                closeText: "close",
                dialogClass: "",
                draggable: !0,
                hide: null,
                height: "auto",
                maxHeight: !1,
                maxWidth: !1,
                minHeight: 150,
                minWidth: 150,
                modal: !1,
                position: {
                    my: "center",
                    at: "center",
                    of: window,
                    collision: "fit",
                    using: function(e) {
                        var i = t(this).css(e).offset().top;
                        i < 0 && t(this).css("top", e.top - i)
                    }
                },
                resizable: !0,
                show: null,
                stack: !0,
                title: "",
                width: 300,
                zIndex: 1e3
            },
            _create: function() {
                this.originalTitle = this.element.attr("title"),
                    "string" != typeof this.originalTitle && (this.originalTitle = ""), this.oldPosition = {
                        parent: this.element.parent(),
                        index: this.element.parent().children().index(this.element)
                    }, this.options.title = this.options.title || this.originalTitle;
                var e, n, s, o, r, a = this,
                    l = this.options,
                    h = l.title || "&#160;";
                e = (this.uiDialog = t("<div>")).addClass(i + l.dialogClass).css({
                    display: "none",
                    outline: 0,
                    zIndex: l.zIndex
                }).attr("tabIndex", -1).keydown(function(e) {
                    l.closeOnEscape && !e.isDefaultPrevented() && e.keyCode && e.keyCode === t.ui.keyCode.ESCAPE && (a.close(e), e.preventDefault())
                }).mousedown(function(t) {
                    a.moveToTop(!1, t)
                }).appendTo("body"), this.element.show().removeAttr("title").addClass("ui-dialog-content ui-widget-content").appendTo(e), n = (this.uiDialogTitlebar = t("<div>")).addClass("ui-dialog-titlebar  ui-widget-header  ui-corner-all  ui-helper-clearfix").bind("mousedown", function() {
                    e.focus()
                }).prependTo(e), s = t("<a href='#'></a>").addClass("ui-dialog-titlebar-close  ui-corner-all").attr("role", "button").click(function(t) {
                    t.preventDefault(), a.close(t)
                }).appendTo(n), (this.uiDialogTitlebarCloseText = t("<span>")).addClass("ui-icon ui-icon-closethick").text(l.closeText).appendTo(s), o = t("<span>").uniqueId().addClass("ui-dialog-title").html(h).prependTo(n), r = (this.uiDialogButtonPane = t("<div>")).addClass("ui-dialog-buttonpane ui-widget-content ui-helper-clearfix"), (this.uiButtonSet = t("<div>")).addClass("ui-dialog-buttonset").appendTo(r), e.attr({
                    role: "dialog",
                    "aria-labelledby": o.attr("id")
                }), n.find("*").add(n).disableSelection(), this._hoverable(s), this._focusable(s), l.draggable && t.fn.draggable && this._makeDraggable(), l.resizable && t.fn.resizable && this._makeResizable(), this._createButtons(l.buttons), this._isOpen = !1, t.fn.bgiframe && e.bgiframe(), this._on(e, {
                    keydown: function(i) {
                        if (l.modal && i.keyCode === t.ui.keyCode.TAB) {
                            var n = t(":tabbable", e),
                                s = n.filter(":first"),
                                o = n.filter(":last");
                            return i.target !== o[0] || i.shiftKey ? i.target === s[0] && i.shiftKey ? (o.focus(1), !1) : void 0 : (s.focus(1), !1)
                        }
                    }
                })
            },
            _init: function() {
                this.options.autoOpen && this.open()
            },
            _destroy: function() {
                var t, e = this.oldPosition;
                this.overlay && this.overlay.destroy(), this.uiDialog.hide(), this.element.removeClass("ui-dialog-content ui-widget-content").hide().appendTo("body"), this.uiDialog.remove(), this.originalTitle && this.element.attr("title", this.originalTitle), t = e.parent.children().eq(e.index), t.length && t[0] !== this.element[0] ? t.before(this.element) : e.parent.append(this.element)
            },
            widget: function() {
                return this.uiDialog
            },
            close: function(e) {
                var i, n, s = this;
                if (this._isOpen && !1 !== this._trigger("beforeClose", e)) return this._isOpen = !1, this.overlay && this.overlay.destroy(), this.options.hide ? this._hide(this.uiDialog, this.options.hide, function() {
                    s._trigger("close", e)
                }) : (this.uiDialog.hide(), this._trigger("close", e)), t.ui.dialog.overlay.resize(), this.options.modal && (i = 0, t(".ui-dialog").each(function() {
                    this !== s.uiDialog[0] && (n = t(this).css("z-index"), isNaN(n) || (i = Math.max(i, n)))
                }), t.ui.dialog.maxZ = i), this
            },
            isOpen: function() {
                return this._isOpen
            },
            moveToTop: function(e, i) {
                var n, s = this.options;
                return s.modal && !e || !s.stack && !s.modal ? this._trigger("focus", i) : (s.zIndex > t.ui.dialog.maxZ && (t.ui.dialog.maxZ = s.zIndex), this.overlay && (t.ui.dialog.maxZ += 1, t.ui.dialog.overlay.maxZ = t.ui.dialog.maxZ, this.overlay.$el.css("z-index", t.ui.dialog.overlay.maxZ)), n = {
                    scrollTop: this.element.scrollTop(),
                    scrollLeft: this.element.scrollLeft()
                }, t.ui.dialog.maxZ += 1, this.uiDialog.css("z-index", t.ui.dialog.maxZ), this.element.attr(n), this._trigger("focus", i), this)
            },
            open: function() {
                if (!this._isOpen) {
                    var e, i = this.options,
                        n = this.uiDialog;
                    return this._size(), this._position(i.position), n.show(i.show), this.overlay = i.modal ? new t.ui.dialog.overlay(this) : null, this.moveToTop(!0), e = this.element.find(":tabbable"), e.length || (e = this.uiDialogButtonPane.find(":tabbable"), e.length || (e = n)), e.eq(0).focus(), this._isOpen = !0, this._trigger("open"), this
                }
            },
            _createButtons: function(e) {
                var i = this,
                    n = !1;
                this.uiDialogButtonPane.remove(), this.uiButtonSet.empty(), "object" == typeof e && null !== e && t.each(e, function() {
                    return !(n = !0)
                }), n ? (t.each(e, function(e, n) {
                    var s, o;
                    n = t.isFunction(n) ? {
                        click: n,
                        text: e
                    } : n, n = t.extend({
                        type: "button"
                    }, n), o = n.click, n.click = function() {
                        o.apply(i.element[0], arguments)
                    }, s = t("<button></button>", n).appendTo(i.uiButtonSet), t.fn.button && s.button()
                }), this.uiDialog.addClass("ui-dialog-buttons"), this.uiDialogButtonPane.appendTo(this.uiDialog)) : this.uiDialog.removeClass("ui-dialog-buttons")
            },
            _makeDraggable: function() {
                function e(t) {
                    return {
                        position: t.position,
                        offset: t.offset
                    }
                }
                var i = this,
                    n = this.options;
                this.uiDialog.draggable({
                    cancel: ".ui-dialog-content, .ui-dialog-titlebar-close",
                    handle: ".ui-dialog-titlebar",
                    containment: "document",
                    start: function(n, s) {
                        t(this).addClass("ui-dialog-dragging"), i._trigger("dragStart", n, e(s))
                    },
                    drag: function(t, n) {
                        i._trigger("drag", t, e(n))
                    },
                    stop: function(s, o) {
                        n.position = [o.position.left - i.document.scrollLeft(), o.position.top - i.document.scrollTop()], t(this).removeClass("ui-dialog-dragging"), i._trigger("dragStop", s, e(o)), t.ui.dialog.overlay.resize()
                    }
                })
            },
            _makeResizable: function(e) {
                function i(t) {
                    return {
                        originalPosition: t.originalPosition,
                        originalSize: t.originalSize,
                        position: t.position,
                        size: t.size
                    }
                }
                e = void 0 === e ? this.options.resizable : e;
                var n = this,
                    s = this.options,
                    o = this.uiDialog.css("position"),
                    r = "string" == typeof e ? e : "n,e,s,w,se,sw,ne,nw";
                this.uiDialog.resizable({
                    cancel: ".ui-dialog-content",
                    containment: "document",
                    alsoResize: this.element,
                    maxWidth: s.maxWidth,
                    maxHeight: s.maxHeight,
                    minWidth: s.minWidth,
                    minHeight: this._minHeight(),
                    handles: r,
                    start: function(e, s) {
                        t(this).addClass("ui-dialog-resizing"), n._trigger("resizeStart", e, i(s))
                    },
                    resize: function(t, e) {
                        n._trigger("resize", t, i(e))
                    },
                    stop: function(e, o) {
                        t(this).removeClass("ui-dialog-resizing"), s.height = t(this).height(), s.width = t(this).width(), n._trigger("resizeStop", e, i(o)), t.ui.dialog.overlay.resize()
                    }
                }).css("position", o).find(".ui-resizable-se").addClass("ui-icon ui-icon-grip-diagonal-se")
            },
            _minHeight: function() {
                var t = this.options;
                return "auto" === t.height ? t.minHeight : Math.min(t.minHeight, t.height)
            },
            _position: function(e) {
                var i, n = [],
                    s = [0, 0];
                e ? (("string" == typeof e || "object" == typeof e && "0" in e) && (n = e.split ? e.split(" ") : [e[0], e[1]], 1 === n.length && (n[1] = n[0]), t.each(["left", "top"], function(t, e) {
                    +n[t] === n[t] && (s[t] = n[t], n[t] = e)
                }), e = {
                    my: n[0] + (s[0] < 0 ? s[0] : "+" + s[0]) + " " + n[1] + (s[1] < 0 ? s[1] : "+" + s[1]),
                    at: n.join(" ")
                }), e = t.extend({}, t.ui.dialog.prototype.options.position, e)) : e = t.ui.dialog.prototype.options.position, i = this.uiDialog.is(":visible"), i || this.uiDialog.show(), this.uiDialog.position(e), i || this.uiDialog.hide()
            },
            _setOptions: function(e) {
                var i = this,
                    o = {},
                    r = !1;
                t.each(e, function(t, e) {
                    i._setOption(t, e), t in n && (r = !0), t in s && (o[t] = e)
                }), r && this._size(), this.uiDialog.is(":data(resizable)") && this.uiDialog.resizable("option", o)
            },
            _setOption: function(e, n) {
                var s, o, r = this.uiDialog;
                switch (e) {
                    case "buttons":
                        this._createButtons(n);
                        break;
                    case "closeText":
                        this.uiDialogTitlebarCloseText.text("" + n);
                        break;
                    case "dialogClass":
                        r.removeClass(this.options.dialogClass).addClass(i + n);
                        break;
                    case "disabled":
                        n ? r.addClass("ui-dialog-disabled") : r.removeClass("ui-dialog-disabled");
                        break;
                    case "draggable":
                        s = r.is(":data(draggable)"), s && !n && r.draggable("destroy"), !s && n && this._makeDraggable();
                        break;
                    case "position":
                        this._position(n);
                        break;
                    case "resizable":
                        o = r.is(":data(resizable)"), o && !n && r.resizable("destroy"), o && "string" == typeof n && r.resizable("option", "handles", n), !o && !1 !== n && this._makeResizable(n);
                        break;
                    case "title":
                        t(".ui-dialog-title", this.uiDialogTitlebar).html("" + (n || "&#160;"))
                }
                this._super(e, n)
            },
            _size: function() {
                var e, i, n, s = this.options,
                    o = this.uiDialog.is(":visible");
                this.element.show().css({
                    width: "auto",
                    minHeight: 0,
                    height: 0
                }), s.minWidth > s.width && (s.width = s.minWidth), e = this.uiDialog.css({
                    height: "auto",
                    width: s.width
                }).outerHeight(), i = Math.max(0, s.minHeight - e), "auto" === s.height ? t.support.minHeight ? this.element.css({
                    minHeight: i,
                    height: "auto"
                }) : (this.uiDialog.show(), n = this.element.css("height", "auto").height(), o || this.uiDialog.hide(), this.element.height(Math.max(n, i))) : this.element.height(Math.max(s.height - e, 0)), this.uiDialog.is(":data(resizable)") && this.uiDialog.resizable("option", "minHeight", this._minHeight())
            }
        }), t.extend(t.ui.dialog, {
            uuid: 0,
            maxZ: 0,
            getTitleId: function(t) {
                var e = t.attr("id");
                return e || (this.uuid += 1, e = this.uuid), "ui-dialog-title-" + e
            },
            overlay: function(e) {
                this.$el = t.ui.dialog.overlay.create(e)
            }
        }), t.extend(t.ui.dialog.overlay, {
            instances: [],
            oldInstances: [],
            maxZ: 0,
            events: t.map("focus,mousedown,mouseup,keydown,keypress,click".split(","), function(t) {
                return t + ".dialog-overlay"
            }).join(" "),
            create: function(e) {
                0 === this.instances.length && (setTimeout(function() {
                    t.ui.dialog.overlay.instances.length && t(document).bind(t.ui.dialog.overlay.events, function(e) {
                        if (t(e.target).zIndex() < t.ui.dialog.overlay.maxZ) return !1
                    })
                }, 1), t(window).bind("resize.dialog-overlay", t.ui.dialog.overlay.resize));
                var i = this.oldInstances.pop() || t("<div>").addClass("ui-widget-overlay");
                return t(document).bind("keydown.dialog-overlay", function(n) {
                    var s = t.ui.dialog.overlay.instances;
                    0 !== s.length && s[s.length - 1] === i && e.options.closeOnEscape && !n.isDefaultPrevented() && n.keyCode && n.keyCode === t.ui.keyCode.ESCAPE && (e.close(n), n.preventDefault())
                }), i.appendTo(document.body).css({
                    width: this.width(),
                    height: this.height()
                }), t.fn.bgiframe && i.bgiframe(), this.instances.push(i), i
            },
            destroy: function(e) {
                var i = t.inArray(e, this.instances),
                    n = 0; - 1 !== i && this.oldInstances.push(this.instances.splice(i, 1)[0]), 0 === this.instances.length && t([document, window]).unbind(".dialog-overlay"), e.height(0).width(0).remove(), t.each(this.instances, function() {
                    n = Math.max(n, this.css("z-index"))
                }), this.maxZ = n
            },
            height: function() {
                var e, i;
                return t.ui.ie ? (e = Math.max(document.documentElement.scrollHeight, document.body.scrollHeight), i = Math.max(document.documentElement.offsetHeight, document.body.offsetHeight), e < i ? t(window).height() + "px" : e + "px") : t(document).height() + "px"
            },
            width: function() {
                var e, i;
                return t.ui.ie ? (e = Math.max(document.documentElement.scrollWidth, document.body.scrollWidth), i = Math.max(document.documentElement.offsetWidth, document.body.offsetWidth), e < i ? t(window).width() + "px" : e + "px") : t(document).width() + "px"
            },
            resize: function() {
                var e = t([]);
                t.each(t.ui.dialog.overlay.instances, function() {
                    e = e.add(this)
                }), e.css({
                    width: 0,
                    height: 0
                }).css({
                    width: t.ui.dialog.overlay.width(),
                    height: t.ui.dialog.overlay.height()
                })
            }
        }), t.extend(t.ui.dialog.overlay.prototype, {
            destroy: function() {
                t.ui.dialog.overlay.destroy(this.$el)
            }
        })
    }(jQuery), function(t, e) {
        var i = /up|down|vertical/,
            n = /up|left|vertical|horizontal/;
        t.effects.effect.blind = function(e, s) {
            var o, r, a, l = t(this),
                h = ["position", "top", "bottom", "left", "right", "height", "width"],
                c = t.effects.setMode(l, e.mode || "hide"),
                u = e.direction || "up",
                d = i.test(u),
                p = d ? "height" : "width",
                f = d ? "top" : "left",
                g = n.test(u),
                m = {},
                v = "show" === c;
            l.parent().is(".ui-effects-wrapper") ? t.effects.save(l.parent(), h) : t.effects.save(l, h), l.show(), o = t.effects.createWrapper(l).css({
                overflow: "hidden"
            }), r = o[p](), a = parseFloat(o.css(f)) || 0, m[p] = v ? r : 0, g || (l.css(d ? "bottom" : "right", 0).css(d ? "top" : "left", "auto").css({
                position: "absolute"
            }), m[f] = v ? a : r + a), v && (o.css(p, 0), g || o.css(f, a + r)), o.animate(m, {
                duration: e.duration,
                easing: e.easing,
                queue: !1,
                complete: function() {
                    "hide" === c && l.hide(), t.effects.restore(l, h), t.effects.removeWrapper(l), s()
                }
            })
        }
    }(jQuery), function(t, e) {
        t.effects.effect.bounce = function(e, i) {
            var n, s, o, r = t(this),
                a = ["position", "top", "bottom", "left", "right", "height", "width"],
                l = t.effects.setMode(r, e.mode || "effect"),
                h = "hide" === l,
                c = "show" === l,
                u = e.direction || "up",
                d = e.distance,
                p = e.times || 5,
                f = 2 * p + (c || h ? 1 : 0),
                g = e.duration / f,
                m = e.easing,
                v = "up" === u || "down" === u ? "top" : "left",
                y = "up" === u || "left" === u,
                b = r.queue(),
                _ = b.length;
            for ((c || h) && a.push("opacity"), t.effects.save(r, a), r.show(), t.effects.createWrapper(r), d || (d = r["top" === v ? "outerHeight" : "outerWidth"]() / 3), c && (o = {
                    opacity: 1
                }, o[v] = 0, r.css("opacity", 0).css(v, y ? 2 * -d : 2 * d).animate(o, g, m)), h && (d /= Math.pow(2, p - 1)), o = {}, o[v] = 0, n = 0; n < p; n++) s = {}, s[v] = (y ? "-=" : "+=") + d, r.animate(s, g, m).animate(o, g, m), d = h ? 2 * d : d / 2;
            h && (s = {
                opacity: 0
            }, s[v] = (y ? "-=" : "+=") + d, r.animate(s, g, m)), r.queue(function() {
                h && r.hide(), t.effects.restore(r, a), t.effects.removeWrapper(r), i()
            }), _ > 1 && b.splice.apply(b, [1, 0].concat(b.splice(_, f + 1))), r.dequeue()
        }
    }(jQuery), function(t, e) {
        t.effects.effect.clip = function(e, i) {
            var n, s, o, r = t(this),
                a = ["position", "top", "bottom", "left", "right", "height", "width"],
                l = t.effects.setMode(r, e.mode || "hide"),
                h = "show" === l,
                c = e.direction || "vertical",
                u = "vertical" === c,
                d = u ? "height" : "width",
                p = u ? "top" : "left",
                f = {};
            t.effects.save(r, a), r.show(), n = t.effects.createWrapper(r).css({
                overflow: "hidden"
            }), s = "IMG" === r[0].tagName ? n : r, o = s[d](), h && (s.css(d, 0), s.css(p, o / 2)), f[d] = h ? o : 0, f[p] = h ? 0 : o / 2, s.animate(f, {
                queue: !1,
                duration: e.duration,
                easing: e.easing,
                complete: function() {
                    h || r.hide(), t.effects.restore(r, a), t.effects.removeWrapper(r), i()
                }
            })
        }
    }(jQuery), function(t, e) {
        t.effects.effect.drop = function(e, i) {
            var n, s = t(this),
                o = ["position", "top", "bottom", "left", "right", "opacity", "height", "width"],
                r = t.effects.setMode(s, e.mode || "hide"),
                a = "show" === r,
                l = e.direction || "left",
                h = "up" === l || "down" === l ? "top" : "left",
                c = "up" === l || "left" === l ? "pos" : "neg",
                u = {
                    opacity: a ? 1 : 0
                };
            t.effects.save(s, o), s.show(), t.effects.createWrapper(s), n = e.distance || s["top" === h ? "outerHeight" : "outerWidth"](!0) / 2, a && s.css("opacity", 0).css(h, "pos" === c ? -n : n), u[h] = (a ? "pos" === c ? "+=" : "-=" : "pos" === c ? "-=" : "+=") + n, s.animate(u, {
                queue: !1,
                duration: e.duration,
                easing: e.easing,
                complete: function() {
                    "hide" === r && s.hide(), t.effects.restore(s, o), t.effects.removeWrapper(s), i()
                }
            })
        }
    }(jQuery), function(t, e) {
        t.effects.effect.explode = function(e, i) {
            function n() {
                b.push(this), b.length === u * d && s()
            }

            function s() {
                p.css({
                    visibility: "visible"
                }), t(b).remove(), g || p.hide(), i()
            }
            var o, r, a, l, h, c, u = e.pieces ? Math.round(Math.sqrt(e.pieces)) : 3,
                d = u,
                p = t(this),
                f = t.effects.setMode(p, e.mode || "hide"),
                g = "show" === f,
                m = p.show().css("visibility", "hidden").offset(),
                v = Math.ceil(p.outerWidth() / d),
                y = Math.ceil(p.outerHeight() / u),
                b = [];
            for (o = 0; o < u; o++)
                for (l = m.top + o * y, c = o - (u - 1) / 2, r = 0; r < d; r++) a = m.left + r * v, h = r - (d - 1) / 2, p.clone().appendTo("body").wrap("<div></div>").css({
                    position: "absolute",
                    visibility: "visible",
                    left: -r * v,
                    top: -o * y
                }).parent().addClass("ui-effects-explode").css({
                    position: "absolute",
                    overflow: "hidden",
                    width: v,
                    height: y,
                    left: a + (g ? h * v : 0),
                    top: l + (g ? c * y : 0),
                    opacity: g ? 0 : 1
                }).animate({
                    left: a + (g ? 0 : h * v),
                    top: l + (g ? 0 : c * y),
                    opacity: g ? 1 : 0
                }, e.duration || 500, e.easing, n)
        }
    }(jQuery), function(t, e) {
        t.effects.effect.fade = function(e, i) {
            var n = t(this),
                s = t.effects.setMode(n, e.mode || "toggle");
            n.animate({
                opacity: s
            }, {
                queue: !1,
                duration: e.duration,
                easing: e.easing,
                complete: i
            })
        }
    }(jQuery), function(t, e) {
        t.effects.effect.fold = function(e, i) {
            var n, s, o = t(this),
                r = ["position", "top", "bottom", "left", "right", "height", "width"],
                a = t.effects.setMode(o, e.mode || "hide"),
                l = "show" === a,
                h = "hide" === a,
                c = e.size || 15,
                u = /([0-9]+)%/.exec(c),
                d = !!e.horizFirst,
                p = l !== d,
                f = p ? ["width", "height"] : ["height", "width"],
                g = e.duration / 2,
                m = {},
                v = {};
            t.effects.save(o, r), o.show(), n = t.effects.createWrapper(o).css({
                overflow: "hidden"
            }), s = p ? [n.width(), n.height()] : [n.height(), n.width()], u && (c = parseInt(u[1], 10) / 100 * s[h ? 0 : 1]), l && n.css(d ? {
                height: 0,
                width: c
            } : {
                height: c,
                width: 0
            }), m[f[0]] = l ? s[0] : c, v[f[1]] = l ? s[1] : 0, n.animate(m, g, e.easing).animate(v, g, e.easing, function() {
                h && o.hide(), t.effects.restore(o, r), t.effects.removeWrapper(o), i()
            })
        }
    }(jQuery), function(t, e) {
        t.effects.effect.highlight = function(e, i) {
            var n = t(this),
                s = ["backgroundImage", "backgroundColor", "opacity"],
                o = t.effects.setMode(n, e.mode || "show"),
                r = {
                    backgroundColor: n.css("backgroundColor")
                };
            "hide" === o && (r.opacity = 0), t.effects.save(n, s), n.show().css({
                backgroundImage: "none",
                backgroundColor: e.color || "#ffff99"
            }).animate(r, {
                queue: !1,
                duration: e.duration,
                easing: e.easing,
                complete: function() {
                    "hide" === o && n.hide(), t.effects.restore(n, s), i()
                }
            })
        }
    }(jQuery), function(t, e) {
        t.effects.effect.pulsate = function(e, i) {
            var n, s = t(this),
                o = t.effects.setMode(s, e.mode || "show"),
                r = "show" === o,
                a = "hide" === o,
                l = r || "hide" === o,
                h = 2 * (e.times || 5) + (l ? 1 : 0),
                c = e.duration / h,
                u = 0,
                d = s.queue(),
                p = d.length;
            for (!r && s.is(":visible") || (s.css("opacity", 0).show(), u = 1), n = 1; n < h; n++) s.animate({
                opacity: u
            }, c, e.easing), u = 1 - u;
            s.animate({
                opacity: u
            }, c, e.easing), s.queue(function() {
                a && s.hide(), i()
            }), p > 1 && d.splice.apply(d, [1, 0].concat(d.splice(p, h + 1))), s.dequeue()
        }
    }(jQuery), function(t, e) {
        t.effects.effect.puff = function(e, i) {
            var n = t(this),
                s = t.effects.setMode(n, e.mode || "hide"),
                o = "hide" === s,
                r = parseInt(e.percent, 10) || 150,
                a = r / 100,
                l = {
                    height: n.height(),
                    width: n.width(),
                    outerHeight: n.outerHeight(),
                    outerWidth: n.outerWidth()
                };
            t.extend(e, {
                effect: "scale",
                queue: !1,
                fade: !0,
                mode: s,
                complete: i,
                percent: o ? r : 100,
                from: o ? l : {
                    height: l.height * a,
                    width: l.width * a,
                    outerHeight: l.outerHeight * a,
                    outerWidth: l.outerWidth * a
                }
            }), n.effect(e)
        }, t.effects.effect.scale = function(e, i) {
            var n = t(this),
                s = t.extend(!0, {}, e),
                o = t.effects.setMode(n, e.mode || "effect"),
                r = parseInt(e.percent, 10) || (0 === parseInt(e.percent, 10) ? 0 : "hide" === o ? 0 : 100),
                a = e.direction || "both",
                l = e.origin,
                h = {
                    height: n.height(),
                    width: n.width(),
                    outerHeight: n.outerHeight(),
                    outerWidth: n.outerWidth()
                },
                c = {
                    y: "horizontal" !== a ? r / 100 : 1,
                    x: "vertical" !== a ? r / 100 : 1
                };
            s.effect = "size", s.queue = !1, s.complete = i, "effect" !== o && (s.origin = l || ["middle", "center"], s.restore = !0), s.from = e.from || ("show" === o ? {
                height: 0,
                width: 0,
                outerHeight: 0,
                outerWidth: 0
            } : h), s.to = {
                height: h.height * c.y,
                width: h.width * c.x,
                outerHeight: h.outerHeight * c.y,
                outerWidth: h.outerWidth * c.x
            }, s.fade && ("show" === o && (s.from.opacity = 0, s.to.opacity = 1), "hide" === o && (s.from.opacity = 1, s.to.opacity = 0)), n.effect(s)
        }, t.effects.effect.size = function(e, i) {
            var n, s, o, r = t(this),
                a = ["position", "top", "bottom", "left", "right", "width", "height", "overflow", "opacity"],
                l = ["position", "top", "bottom", "left", "right", "overflow", "opacity"],
                h = ["width", "height", "overflow"],
                c = ["fontSize"],
                u = ["borderTopWidth", "borderBottomWidth", "paddingTop", "paddingBottom"],
                d = ["borderLeftWidth", "borderRightWidth", "paddingLeft", "paddingRight"],
                p = t.effects.setMode(r, e.mode || "effect"),
                f = e.restore || "effect" !== p,
                g = e.scale || "both",
                m = e.origin || ["middle", "center"],
                v = r.css("position"),
                y = f ? a : l,
                b = {
                    height: 0,
                    width: 0,
                    outerHeight: 0,
                    outerWidth: 0
                };
            "show" === p && r.show(), n = {
                height: r.height(),
                width: r.width(),
                outerHeight: r.outerHeight(),
                outerWidth: r.outerWidth()
            }, "toggle" === e.mode && "show" === p ? (r.from = e.to || b, r.to = e.from || n) : (r.from = e.from || ("show" === p ? b : n), r.to = e.to || ("hide" === p ? b : n)), o = {
                from: {
                    y: r.from.height / n.height,
                    x: r.from.width / n.width
                },
                to: {
                    y: r.to.height / n.height,
                    x: r.to.width / n.width
                }
            }, "box" !== g && "both" !== g || (o.from.y !== o.to.y && (y = y.concat(u), r.from = t.effects.setTransition(r, u, o.from.y, r.from), r.to = t.effects.setTransition(r, u, o.to.y, r.to)), o.from.x !== o.to.x && (y = y.concat(d), r.from = t.effects.setTransition(r, d, o.from.x, r.from), r.to = t.effects.setTransition(r, d, o.to.x, r.to))), ("content" === g || "both" === g) && o.from.y !== o.to.y && (y = y.concat(c).concat(h), r.from = t.effects.setTransition(r, c, o.from.y, r.from), r.to = t.effects.setTransition(r, c, o.to.y, r.to)), t.effects.save(r, y), r.show(), t.effects.createWrapper(r), r.css("overflow", "hidden").css(r.from), m && (s = t.effects.getBaseline(m, n), r.from.top = (n.outerHeight - r.outerHeight()) * s.y, r.from.left = (n.outerWidth - r.outerWidth()) * s.x, r.to.top = (n.outerHeight - r.to.outerHeight) * s.y, r.to.left = (n.outerWidth - r.to.outerWidth) * s.x), r.css(r.from), "content" !== g && "both" !== g || (u = u.concat(["marginTop", "marginBottom"]).concat(c), d = d.concat(["marginLeft", "marginRight"]), h = a.concat(u).concat(d), r.find("*[width]").each(function() {
                var i = t(this),
                    n = {
                        height: i.height(),
                        width: i.width(),
                        outerHeight: i.outerHeight(),
                        outerWidth: i.outerWidth()
                    };
                f && t.effects.save(i, h), i.from = {
                    height: n.height * o.from.y,
                    width: n.width * o.from.x,
                    outerHeight: n.outerHeight * o.from.y,
                    outerWidth: n.outerWidth * o.from.x
                }, i.to = {
                    height: n.height * o.to.y,
                    width: n.width * o.to.x,
                    outerHeight: n.height * o.to.y,
                    outerWidth: n.width * o.to.x
                }, o.from.y !== o.to.y && (i.from = t.effects.setTransition(i, u, o.from.y, i.from), i.to = t.effects.setTransition(i, u, o.to.y, i.to)), o.from.x !== o.to.x && (i.from = t.effects.setTransition(i, d, o.from.x, i.from), i.to = t.effects.setTransition(i, d, o.to.x, i.to)), i.css(i.from), i.animate(i.to, e.duration, e.easing, function() {
                    f && t.effects.restore(i, h)
                })
            })), r.animate(r.to, {
                queue: !1,
                duration: e.duration,
                easing: e.easing,
                complete: function() {
                    0 === r.to.opacity && r.css("opacity", r.from.opacity), "hide" === p && r.hide(), t.effects.restore(r, y), f || ("static" === v ? r.css({
                        position: "relative",
                        top: r.to.top,
                        left: r.to.left
                    }) : t.each(["top", "left"], function(t, e) {
                        r.css(e, function(e, i) {
                            var n = parseInt(i, 10),
                                s = t ? r.to.left : r.to.top;
                            return "auto" === i ? s + "px" : n + s + "px"
                        })
                    })), t.effects.removeWrapper(r), i()
                }
            })
        }
    }(jQuery), function(t, e) {
        t.effects.effect.shake = function(e, i) {
            var n, s = t(this),
                o = ["position", "top", "bottom", "left", "right", "height", "width"],
                r = t.effects.setMode(s, e.mode || "effect"),
                a = e.direction || "left",
                l = e.distance || 20,
                h = e.times || 3,
                c = 2 * h + 1,
                u = Math.round(e.duration / c),
                d = "up" === a || "down" === a ? "top" : "left",
                p = "up" === a || "left" === a,
                f = {},
                g = {},
                m = {},
                v = s.queue(),
                y = v.length;
            for (t.effects.save(s, o), s.show(), t.effects.createWrapper(s), f[d] = (p ? "-=" : "+=") + l, g[d] = (p ? "+=" : "-=") + 2 * l, m[d] = (p ? "-=" : "+=") + 2 * l, s.animate(f, u, e.easing), n = 1; n < h; n++) s.animate(g, u, e.easing).animate(m, u, e.easing);
            s.animate(g, u, e.easing).animate(f, u / 2, e.easing).queue(function() {
                "hide" === r && s.hide(), t.effects.restore(s, o), t.effects.removeWrapper(s), i()
            }), y > 1 && v.splice.apply(v, [1, 0].concat(v.splice(y, c + 1))), s.dequeue()
        }
    }(jQuery), function(t, e) {
        t.effects.effect.slide = function(e, i) {
            var n, s = t(this),
                o = ["position", "top", "bottom", "left", "right", "width", "height"],
                r = t.effects.setMode(s, e.mode || "show"),
                a = "show" === r,
                l = e.direction || "left",
                h = "up" === l || "down" === l ? "top" : "left",
                c = "up" === l || "left" === l,
                u = {};
            t.effects.save(s, o), s.show(), n = e.distance || s["top" === h ? "outerHeight" : "outerWidth"](!0), t.effects.createWrapper(s).css({
                overflow: "hidden"
            }), a && s.css(h, c ? isNaN(n) ? "-" + n : -n : n), u[h] = (a ? c ? "+=" : "-=" : c ? "-=" : "+=") + n, s.animate(u, {
                queue: !1,
                duration: e.duration,
                easing: e.easing,
                complete: function() {
                    "hide" === r && s.hide(), t.effects.restore(s, o), t.effects.removeWrapper(s), i()
                }
            })
        }
    }(jQuery), function(t, e) {
        t.effects.effect.transfer = function(e, i) {
            var n = t(this),
                s = t(e.to),
                o = "fixed" === s.css("position"),
                r = t("body"),
                a = o ? r.scrollTop() : 0,
                l = o ? r.scrollLeft() : 0,
                h = s.offset(),
                c = {
                    top: h.top - a,
                    left: h.left - l,
                    height: s.innerHeight(),
                    width: s.innerWidth()
                },
                u = n.offset(),
                d = t('<div class="ui-effects-transfer"></div>').appendTo(document.body).addClass(e.className).css({
                    top: u.top - a,
                    left: u.left - l,
                    height: n.innerHeight(),
                    width: n.innerWidth(),
                    position: o ? "fixed" : "absolute"
                }).animate(c, e.duration, e.easing, function() {
                    d.remove(), i()
                })
        }
    }(jQuery), function(t, e) {
        var i = !1;
        t.widget("ui.menu", {
            version: "1.9.2",
            defaultElement: "<ul>",
            delay: 300,
            options: {
                icons: {
                    submenu: "ui-icon-carat-1-e"
                },
                menus: "ul",
                position: {
                    my: "left top",
                    at: "right top"
                },
                role: "menu",
                blur: null,
                focus: null,
                select: null
            },
            _create: function() {
                this.activeMenu = this.element, this.element.uniqueId().addClass("ui-menu ui-widget ui-widget-content ui-corner-all").toggleClass("ui-menu-icons", !!this.element.find(".ui-icon").length).attr({
                    role: this.options.role,
                    tabIndex: 0
                }).bind("click" + this.eventNamespace, t.proxy(function(t) {
                    this.options.disabled && t.preventDefault()
                }, this)), this.options.disabled && this.element.addClass("ui-state-disabled").attr("aria-disabled", "true"), this._on({
                    "mousedown .ui-menu-item > a": function(t) {
                        t.preventDefault()
                    },
                    "click .ui-state-disabled > a": function(t) {
                        t.preventDefault()
                    },
                    "click .ui-menu-item:has(a)": function(e) {
                        var n = t(e.target).closest(".ui-menu-item");
                        !i && n.not(".ui-state-disabled").length && (i = !0, this.select(e), n.has(".ui-menu").length ? this.expand(e) : this.element.is(":focus") || (this.element.trigger("focus", [!0]), this.active && 1 === this.active.parents(".ui-menu").length && clearTimeout(this.timer)))
                    },
                    "mouseenter .ui-menu-item": function(e) {
                        var i = t(e.currentTarget);
                        i.siblings().children(".ui-state-active").removeClass("ui-state-active"), this.focus(e, i)
                    },
                    mouseleave: "collapseAll",
                    "mouseleave .ui-menu": "collapseAll",
                    focus: function(t, e) {
                        var i = this.active || this.element.children(".ui-menu-item").eq(0);
                        e || this.focus(t, i)
                    },
                    blur: function(e) {
                        this._delay(function() {
                            t.contains(this.element[0], this.document[0].activeElement) || this.collapseAll(e)
                        })
                    },
                    keydown: "_keydown"
                }), this.refresh(), this._on(this.document, {
                    click: function(e) {
                        t(e.target).closest(".ui-menu").length || this.collapseAll(e), i = !1
                    }
                })
            },
            _destroy: function() {
                this.element.removeAttr("aria-activedescendant").find(".ui-menu").andSelf().removeClass("ui-menu ui-widget ui-widget-content ui-corner-all ui-menu-icons").removeAttr("role").removeAttr("tabIndex").removeAttr("aria-labelledby").removeAttr("aria-expanded").removeAttr("aria-hidden").removeAttr("aria-disabled").removeUniqueId().show(), this.element.find(".ui-menu-item").removeClass("ui-menu-item").removeAttr("role").removeAttr("aria-disabled").children("a").removeUniqueId().removeClass("ui-corner-all ui-state-hover").removeAttr("tabIndex").removeAttr("role").removeAttr("aria-haspopup").children().each(function() {
                    var e = t(this);
                    e.data("ui-menu-submenu-carat") && e.remove()
                }), this.element.find(".ui-menu-divider").removeClass("ui-menu-divider ui-widget-content")
            },
            _keydown: function(e) {
                function i(t) {
                    return t.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, "\\$&")
                }
                var n, s, o, r, a, l = !0;
                switch (e.keyCode) {
                    case t.ui.keyCode.PAGE_UP:
                        this.previousPage(e);
                        break;
                    case t.ui.keyCode.PAGE_DOWN:
                        this.nextPage(e);
                        break;
                    case t.ui.keyCode.HOME:
                        this._move("first", "first", e);
                        break;
                    case t.ui.keyCode.END:
                        this._move("last", "last", e);
                        break;
                    case t.ui.keyCode.UP:
                        this.previous(e);
                        break;
                    case t.ui.keyCode.DOWN:
                        this.next(e);
                        break;
                    case t.ui.keyCode.LEFT:
                        this.collapse(e);
                        break;
                    case t.ui.keyCode.RIGHT:
                        this.active && !this.active.is(".ui-state-disabled") && this.expand(e);
                        break;
                    case t.ui.keyCode.ENTER:
                    case t.ui.keyCode.SPACE:
                        this._activate(e);
                        break;
                    case t.ui.keyCode.ESCAPE:
                        this.collapse(e);
                        break;
                    default:
                        l = !1, s = this.previousFilter || "", o = String.fromCharCode(e.keyCode), r = !1, clearTimeout(this.filterTimer), o === s ? r = !0 : o = s + o, a = new RegExp("^" + i(o), "i"), n = this.activeMenu.children(".ui-menu-item").filter(function() {
                            return a.test(t(this).children("a").text())
                        }), n = r && -1 !== n.index(this.active.next()) ? this.active.nextAll(".ui-menu-item") : n, n.length || (o = String.fromCharCode(e.keyCode), a = new RegExp("^" + i(o), "i"), n = this.activeMenu.children(".ui-menu-item").filter(function() {
                            return a.test(t(this).children("a").text())
                        })), n.length ? (this.focus(e, n), n.length > 1 ? (this.previousFilter = o, this.filterTimer = this._delay(function() {
                            delete this.previousFilter
                        }, 1e3)) : delete this.previousFilter) : delete this.previousFilter
                }
                l && e.preventDefault()
            },
            _activate: function(t) {
                this.active.is(".ui-state-disabled") || (this.active.children("a[aria-haspopup='true']").length ? this.expand(t) : this.select(t))
            },
            refresh: function() {
                var e, i = this.options.icons.submenu,
                    n = this.element.find(this.options.menus);
                n.filter(":not(.ui-menu)").addClass("ui-menu ui-widget ui-widget-content ui-corner-all").hide().attr({
                    role: this.options.role,
                    "aria-hidden": "true",
                    "aria-expanded": "false"
                }).each(function() {
                    var e = t(this),
                        n = e.prev("a"),
                        s = t("<span>").addClass("ui-menu-icon ui-icon " + i).data("ui-menu-submenu-carat", !0);
                    n.attr("aria-haspopup", "true").prepend(s), e.attr("aria-labelledby", n.attr("id"))
                }), e = n.add(this.element), e.children(":not(.ui-menu-item):has(a)").addClass("ui-menu-item").attr("role", "presentation").children("a").uniqueId().addClass("ui-corner-all").attr({
                    tabIndex: -1,
                    role: this._itemRole()
                }), e.children(":not(.ui-menu-item)").each(function() {
                    var e = t(this);
                    /[^\-—–\s]/.test(e.text()) || e.addClass("ui-widget-content ui-menu-divider")
                }), e.children(".ui-state-disabled").attr("aria-disabled", "true"), this.active && !t.contains(this.element[0], this.active[0]) && this.blur()
            },
            _itemRole: function() {
                return {
                    menu: "menuitem",
                    listbox: "option"
                } [this.options.role]
            },
            focus: function(t, e) {
                var i, n;
                this.blur(t, t && "focus" === t.type), this._scrollIntoView(e), this.active = e.first(), n = this.active.children("a").addClass("ui-state-focus"), this.options.role && this.element.attr("aria-activedescendant", n.attr("id")), this.active.parent().closest(".ui-menu-item").children("a:first").addClass("ui-state-active"), t && "keydown" === t.type ? this._close() : this.timer = this._delay(function() {
                    this._close()
                }, this.delay), i = e.children(".ui-menu"), i.length && /^mouse/.test(t.type) && this._startOpening(i), this.activeMenu = e.parent(), this._trigger("focus", t, {
                    item: e
                })
            },
            _scrollIntoView: function(e) {
                var i, n, s, o, r, a;
                this._hasScroll() && (i = parseFloat(t.css(this.activeMenu[0], "borderTopWidth")) || 0, n = parseFloat(t.css(this.activeMenu[0], "paddingTop")) || 0, s = e.offset().top - this.activeMenu.offset().top - i - n, o = this.activeMenu.scrollTop(), r = this.activeMenu.height(), a = e.height(), s < 0 ? this.activeMenu.scrollTop(o + s) : s + a > r && this.activeMenu.scrollTop(o + s - r + a))
            },
            blur: function(t, e) {
                e || clearTimeout(this.timer), this.active && (this.active.children("a").removeClass("ui-state-focus"), this.active = null, this._trigger("blur", t, {
                    item: this.active
                }))
            },
            _startOpening: function(t) {
                clearTimeout(this.timer), "true" === t.attr("aria-hidden") && (this.timer = this._delay(function() {
                    this._close(), this._open(t)
                }, this.delay))
            },
            _open: function(e) {
                var i = t.extend({ of: this.active
                }, this.options.position);
                clearTimeout(this.timer), this.element.find(".ui-menu").not(e.parents(".ui-menu")).hide().attr("aria-hidden", "true"), e.show().removeAttr("aria-hidden").attr("aria-expanded", "true").position(i)
            },
            collapseAll: function(e, i) {
                clearTimeout(this.timer), this.timer = this._delay(function() {
                    var n = i ? this.element : t(e && e.target).closest(this.element.find(".ui-menu"));
                    n.length || (n = this.element), this._close(n), this.blur(e), this.activeMenu = n
                }, this.delay)
            },
            _close: function(t) {
                t || (t = this.active ? this.active.parent() : this.element), t.find(".ui-menu").hide().attr("aria-hidden", "true").attr("aria-expanded", "false").end().find("a.ui-state-active").removeClass("ui-state-active")
            },
            collapse: function(t) {
                var e = this.active && this.active.parent().closest(".ui-menu-item", this.element);
                e && e.length && (this._close(), this.focus(t, e))
            },
            expand: function(t) {
                var e = this.active && this.active.children(".ui-menu ").children(".ui-menu-item").first();
                e && e.length && (this._open(e.parent()), this._delay(function() {
                    this.focus(t, e)
                }))
            },
            next: function(t) {
                this._move("next", "first", t)
            },
            previous: function(t) {
                this._move("prev", "last", t)
            },
            isFirstItem: function() {
                return this.active && !this.active.prevAll(".ui-menu-item").length
            },
            isLastItem: function() {
                return this.active && !this.active.nextAll(".ui-menu-item").length
            },
            _move: function(t, e, i) {
                var n;
                this.active && (n = "first" === t || "last" === t ? this.active["first" === t ? "prevAll" : "nextAll"](".ui-menu-item").eq(-1) : this.active[t + "All"](".ui-menu-item").eq(0)), n && n.length && this.active || (n = this.activeMenu.children(".ui-menu-item")[e]()), this.focus(i, n)
            },
            nextPage: function(e) {
                var i, n, s;
                if (!this.active) return void this.next(e);
                this.isLastItem() || (this._hasScroll() ? (n = this.active.offset().top, s = this.element.height(), this.active.nextAll(".ui-menu-item").each(function() {
                    return i = t(this), i.offset().top - n - s < 0
                }), this.focus(e, i)) : this.focus(e, this.activeMenu.children(".ui-menu-item")[this.active ? "last" : "first"]()))
            },
            previousPage: function(e) {
                var i, n, s;
                if (!this.active) return void this.next(e);
                this.isFirstItem() || (this._hasScroll() ? (n = this.active.offset().top, s = this.element.height(), this.active.prevAll(".ui-menu-item").each(function() {
                    return i = t(this), i.offset().top - n + s > 0
                }), this.focus(e, i)) : this.focus(e, this.activeMenu.children(".ui-menu-item").first()))
            },
            _hasScroll: function() {
                return this.element.outerHeight() < this.element.prop("scrollHeight")
            },
            select: function(e) {
                this.active = this.active || t(e.target).closest(".ui-menu-item");
                var i = {
                    item: this.active
                };
                this.active.has(".ui-menu").length || this.collapseAll(e, !0), this._trigger("select", e, i)
            }
        })
    }(jQuery), function(t, e) {
        function i(t, e, i) {
            return [parseInt(t[0], 10) * (d.test(t[0]) ? e / 100 : 1), parseInt(t[1], 10) * (d.test(t[1]) ? i / 100 : 1)]
        }

        function n(e, i) {
            return parseInt(t.css(e, i), 10) || 0
        }
        t.ui = t.ui || {};
        var s, o = Math.max,
            r = Math.abs,
            a = Math.round,
            l = /left|center|right/,
            h = /top|center|bottom/,
            c = /[\+\-]\d+%?/,
            u = /^\w+/,
            d = /%$/,
            p = t.fn.position;
        t.position = {
                scrollbarWidth: function() {
                    if (s !== e) return s;
                    var i, n, o = t("<div style='display:block;width:50px;height:50px;overflow:hidden;'><div style='height:100px;width:auto;'></div></div>"),
                        r = o.children()[0];
                    return t("body").append(o), i = r.offsetWidth, o.css("overflow", "scroll"), n = r.offsetWidth, i === n && (n = o[0].clientWidth), o.remove(), s = i - n
                },
                getScrollInfo: function(e) {
                    var i = e.isWindow ? "" : e.element.css("overflow-x"),
                        n = e.isWindow ? "" : e.element.css("overflow-y"),
                        s = "scroll" === i || "auto" === i && e.width < e.element[0].scrollWidth,
                        o = "scroll" === n || "auto" === n && e.height < e.element[0].scrollHeight;
                    return {
                        width: s ? t.position.scrollbarWidth() : 0,
                        height: o ? t.position.scrollbarWidth() : 0
                    }
                },
                getWithinInfo: function(e) {
                    var i = t(e || window),
                        n = t.isWindow(i[0]);
                    return {
                        element: i,
                        isWindow: n,
                        offset: i.offset() || {
                            left: 0,
                            top: 0
                        },
                        scrollLeft: i.scrollLeft(),
                        scrollTop: i.scrollTop(),
                        width: n ? i.width() : i.outerWidth(),
                        height: n ? i.height() : i.outerHeight()
                    }
                }
            }, t.fn.position = function(e) {
                if (!e || !e.of) return p.apply(this, arguments);
                e = t.extend({}, e);
                var s, d, f, g, m, v = t(e.of),
                    y = t.position.getWithinInfo(e.within),
                    b = t.position.getScrollInfo(y),
                    _ = v[0],
                    w = (e.collision || "flip").split(" "),
                    x = {};
                return 9 === _.nodeType ? (d = v.width(), f = v.height(), g = {
                    top: 0,
                    left: 0
                }) : t.isWindow(_) ? (d = v.width(), f = v.height(), g = {
                    top: v.scrollTop(),
                    left: v.scrollLeft()
                }) : _.preventDefault ? (e.at = "left top", d = f = 0, g = {
                    top: _.pageY,
                    left: _.pageX
                }) : (d = v.outerWidth(), f = v.outerHeight(), g = v.offset()), m = t.extend({}, g), t.each(["my", "at"], function() {
                    var t, i, n = (e[this] || "").split(" ");
                    1 === n.length && (n = l.test(n[0]) ? n.concat(["center"]) : h.test(n[0]) ? ["center"].concat(n) : ["center", "center"]), n[0] = l.test(n[0]) ? n[0] : "center", n[1] = h.test(n[1]) ? n[1] : "center", t = c.exec(n[0]), i = c.exec(n[1]), x[this] = [t ? t[0] : 0, i ? i[0] : 0], e[this] = [u.exec(n[0])[0], u.exec(n[1])[0]]
                }), 1 === w.length && (w[1] = w[0]), "right" === e.at[0] ? m.left += d : "center" === e.at[0] && (m.left += d / 2), "bottom" === e.at[1] ? m.top += f : "center" === e.at[1] && (m.top += f / 2), s = i(x.at, d, f), m.left += s[0], m.top += s[1], this.each(function() {
                    var l, h, c = t(this),
                        u = c.outerWidth(),
                        p = c.outerHeight(),
                        _ = n(this, "marginLeft"),
                        C = n(this, "marginTop"),
                        k = u + _ + n(this, "marginRight") + b.width,
                        T = p + C + n(this, "marginBottom") + b.height,
                        $ = t.extend({}, m),
                        D = i(x.my, c.outerWidth(), c.outerHeight());
                    "right" === e.my[0] ? $.left -= u : "center" === e.my[0] && ($.left -= u / 2), "bottom" === e.my[1] ? $.top -= p : "center" === e.my[1] && ($.top -= p / 2), $.left += D[0], $.top += D[1], t.support.offsetFractions || ($.left = a($.left), $.top = a($.top)), l = {
                        marginLeft: _,
                        marginTop: C
                    }, t.each(["left", "top"], function(i, n) {
                        t.ui.position[w[i]] && t.ui.position[w[i]][n]($, {
                            targetWidth: d,
                            targetHeight: f,
                            elemWidth: u,
                            elemHeight: p,
                            collisionPosition: l,
                            collisionWidth: k,
                            collisionHeight: T,
                            offset: [s[0] + D[0], s[1] + D[1]],
                            my: e.my,
                            at: e.at,
                            within: y,
                            elem: c
                        })
                    }), t.fn.bgiframe && c.bgiframe(), e.using && (h = function(t) {
                        var i = g.left - $.left,
                            n = i + d - u,
                            s = g.top - $.top,
                            a = s + f - p,
                            l = {
                                target: {
                                    element: v,
                                    left: g.left,
                                    top: g.top,
                                    width: d,
                                    height: f
                                },
                                element: {
                                    element: c,
                                    left: $.left,
                                    top: $.top,
                                    width: u,
                                    height: p
                                },
                                horizontal: n < 0 ? "left" : i > 0 ? "right" : "center",
                                vertical: a < 0 ? "top" : s > 0 ? "bottom" : "middle"
                            };
                        d < u && r(i + n) < d && (l.horizontal = "center"), f < p && r(s + a) < f && (l.vertical = "middle"), o(r(i), r(n)) > o(r(s), r(a)) ? l.important = "horizontal" : l.important = "vertical", e.using.call(this, t, l)
                    }), c.offset(t.extend($, {
                        using: h
                    }))
                })
            }, t.ui.position = {
                fit: {
                    left: function(t, e) {
                        var i, n = e.within,
                            s = n.isWindow ? n.scrollLeft : n.offset.left,
                            r = n.width,
                            a = t.left - e.collisionPosition.marginLeft,
                            l = s - a,
                            h = a + e.collisionWidth - r - s;
                        e.collisionWidth > r ? l > 0 && h <= 0 ? (i = t.left + l + e.collisionWidth - r - s, t.left += l - i) : t.left = h > 0 && l <= 0 ? s : l > h ? s + r - e.collisionWidth : s : l > 0 ? t.left += l : h > 0 ? t.left -= h : t.left = o(t.left - a, t.left)
                    },
                    top: function(t, e) {
                        var i, n = e.within,
                            s = n.isWindow ? n.scrollTop : n.offset.top,
                            r = e.within.height,
                            a = t.top - e.collisionPosition.marginTop,
                            l = s - a,
                            h = a + e.collisionHeight - r - s;
                        e.collisionHeight > r ? l > 0 && h <= 0 ? (i = t.top + l + e.collisionHeight - r - s, t.top += l - i) : t.top = h > 0 && l <= 0 ? s : l > h ? s + r - e.collisionHeight : s : l > 0 ? t.top += l : h > 0 ? t.top -= h : t.top = o(t.top - a, t.top)
                    }
                },
                flip: {
                    left: function(t, e) {
                        var i, n, s = e.within,
                            o = s.offset.left + s.scrollLeft,
                            a = s.width,
                            l = s.isWindow ? s.scrollLeft : s.offset.left,
                            h = t.left - e.collisionPosition.marginLeft,
                            c = h - l,
                            u = h + e.collisionWidth - a - l,
                            d = "left" === e.my[0] ? -e.elemWidth : "right" === e.my[0] ? e.elemWidth : 0,
                            p = "left" === e.at[0] ? e.targetWidth : "right" === e.at[0] ? -e.targetWidth : 0,
                            f = -2 * e.offset[0];
                        c < 0 ? ((i = t.left + d + p + f + e.collisionWidth - a - o) < 0 || i < r(c)) && (t.left += d + p + f) : u > 0 && ((n = t.left - e.collisionPosition.marginLeft + d + p + f - l) > 0 || r(n) < u) && (t.left += d + p + f)
                    },
                    top: function(t, e) {
                        var i, n, s = e.within,
                            o = s.offset.top + s.scrollTop,
                            a = s.height,
                            l = s.isWindow ? s.scrollTop : s.offset.top,
                            h = t.top - e.collisionPosition.marginTop,
                            c = h - l,
                            u = h + e.collisionHeight - a - l,
                            d = "top" === e.my[1],
                            p = d ? -e.elemHeight : "bottom" === e.my[1] ? e.elemHeight : 0,
                            f = "top" === e.at[1] ? e.targetHeight : "bottom" === e.at[1] ? -e.targetHeight : 0,
                            g = -2 * e.offset[1];
                        c < 0 ? (n = t.top + p + f + g + e.collisionHeight - a - o, t.top + p + f + g > c && (n < 0 || n < r(c)) && (t.top += p + f + g)) : u > 0 && (i = t.top - e.collisionPosition.marginTop + p + f + g - l, t.top + p + f + g > u && (i > 0 || r(i) < u) && (t.top += p + f + g))
                    }
                },
                flipfit: {
                    left: function() {
                        t.ui.position.flip.left.apply(this, arguments), t.ui.position.fit.left.apply(this, arguments)
                    },
                    top: function() {
                        t.ui.position.flip.top.apply(this, arguments), t.ui.position.fit.top.apply(this, arguments)
                    }
                }
            },
            function() {
                var e, i, n, s, o, r = document.getElementsByTagName("body")[0],
                    a = document.createElement("div");
                e = document.createElement(r ? "div" : "body"), n = {
                    visibility: "hidden",
                    width: 0,
                    height: 0,
                    border: 0,
                    margin: 0,
                    background: "none"
                }, r && t.extend(n, {
                    position: "absolute",
                    left: "-1000px",
                    top: "-1000px"
                });
                for (o in n) e.style[o] = n[o];
                e.appendChild(a), i = r || document.documentElement, i.insertBefore(e, i.firstChild), a.style.cssText = "position: absolute; left: 10.7432222px;", s = t(a).offset().left, t.support.offsetFractions = s > 10 && s < 11, e.innerHTML = "", i.removeChild(e)
            }(), !1 !== t.uiBackCompat && function(t) {
                var i = t.fn.position;
                t.fn.position = function(n) {
                    if (!n || !n.offset) return i.call(this, n);
                    var s = n.offset.split(" "),
                        o = n.at.split(" ");
                    return 1 === s.length && (s[1] = s[0]), /^\d/.test(s[0]) && (s[0] = "+" + s[0]), /^\d/.test(s[1]) && (s[1] = "+" + s[1]), 1 === o.length && (/left|center|right/.test(o[0]) ? o[1] = "center" : (o[1] = o[0], o[0] = "center")), i.call(this, t.extend(n, {
                        at: o[0] + s[0] + " " + o[1] + s[1],
                        offset: e
                    }))
                }
            }(jQuery)
    }(jQuery), function(t, e) {
        t.widget("ui.progressbar", {
            version: "1.9.2",
            options: {
                value: 0,
                max: 100
            },
            min: 0,
            _create: function() {
                this.element.addClass("ui-progressbar ui-widget ui-widget-content ui-corner-all").attr({
                    role: "progressbar",
                    "aria-valuemin": this.min,
                    "aria-valuemax": this.options.max,
                    "aria-valuenow": this._value()
                }), this.valueDiv = t("<div class='ui-progressbar-value ui-widget-header ui-corner-left'></div>").appendTo(this.element), this.oldValue = this._value(), this._refreshValue()
            },
            _destroy: function() {
                this.element.removeClass("ui-progressbar ui-widget ui-widget-content ui-corner-all").removeAttr("role").removeAttr("aria-valuemin").removeAttr("aria-valuemax").removeAttr("aria-valuenow"), this.valueDiv.remove()
            },
            value: function(t) {
                return void 0 === t ? this._value() : (this._setOption("value", t), this)
            },
            _setOption: function(t, e) {
                "value" === t && (this.options.value = e, this._refreshValue(), this._value() === this.options.max && this._trigger("complete")), this._super(t, e)
            },
            _value: function() {
                var t = this.options.value;
                return "number" != typeof t && (t = 0), Math.min(this.options.max, Math.max(this.min, t))
            },
            _percentage: function() {
                return 100 * this._value() / this.options.max
            },
            _refreshValue: function() {
                var t = this.value(),
                    e = this._percentage();
                this.oldValue !== t && (this.oldValue = t, this._trigger("change")), this.valueDiv.toggle(t > this.min).toggleClass("ui-corner-right", t === this.options.max).width(e.toFixed(0) + "%"), this.element.attr("aria-valuenow", t)
            }
        })
    }(jQuery), function(t, e) {
        t.widget("ui.slider", t.ui.mouse, {
            version: "1.9.2",
            widgetEventPrefix: "slide",
            options: {
                animate: !1,
                distance: 0,
                max: 100,
                min: 0,
                orientation: "horizontal",
                range: !1,
                step: 1,
                value: 0,
                values: null
            },
            _create: function() {
                var e, i, n = this.options,
                    s = this.element.find(".ui-slider-handle").addClass("ui-state-default ui-corner-all"),
                    o = [];
                for (this._keySliding = !1, this._mouseSliding = !1, this._animateOff = !0, this._handleIndex = null, this._detectOrientation(), this._mouseInit(), this.element.addClass("ui-slider ui-slider-" + this.orientation + " ui-widget ui-widget-content ui-corner-all" + (n.disabled ? " ui-slider-disabled ui-disabled" : "")), this.range = t([]), n.range && (!0 === n.range && (n.values || (n.values = [this._valueMin(), this._valueMin()]), n.values.length && 2 !== n.values.length && (n.values = [n.values[0], n.values[0]])), this.range = t("<div></div>").appendTo(this.element).addClass("ui-slider-range ui-widget-header" + ("min" === n.range || "max" === n.range ? " ui-slider-range-" + n.range : ""))), i = n.values && n.values.length || 1, e = s.length; e < i; e++) o.push("<a class='ui-slider-handle ui-state-default ui-corner-all' href='#'></a>");
                this.handles = s.add(t(o.join("")).appendTo(this.element)), this.handle = this.handles.eq(0), this.handles.add(this.range).filter("a").click(function(t) {
                    t.preventDefault()
                }).mouseenter(function() {
                    n.disabled || t(this).addClass("ui-state-hover")
                }).mouseleave(function() {
                    t(this).removeClass("ui-state-hover")
                }).focus(function() {
                    n.disabled ? t(this).blur() : (t(".ui-slider .ui-state-focus").removeClass("ui-state-focus"), t(this).addClass("ui-state-focus"))
                }).blur(function() {
                    t(this).removeClass("ui-state-focus")
                }), this.handles.each(function(e) {
                    t(this).data("ui-slider-handle-index", e)
                }), this._on(this.handles, {
                    keydown: function(e) {
                        var i, n, s, o, r = t(e.target).data("ui-slider-handle-index");
                        switch (e.keyCode) {
                            case t.ui.keyCode.HOME:
                            case t.ui.keyCode.END:
                            case t.ui.keyCode.PAGE_UP:
                            case t.ui.keyCode.PAGE_DOWN:
                            case t.ui.keyCode.UP:
                            case t.ui.keyCode.RIGHT:
                            case t.ui.keyCode.DOWN:
                            case t.ui.keyCode.LEFT:
                                if (e.preventDefault(), !this._keySliding && (this._keySliding = !0, t(e.target).addClass("ui-state-active"), i = this._start(e, r), !1 === i)) return
                        }
                        switch (o = this.options.step, n = s = this.options.values && this.options.values.length ? this.values(r) : this.value(), e.keyCode) {
                            case t.ui.keyCode.HOME:
                                s = this._valueMin();
                                break;
                            case t.ui.keyCode.END:
                                s = this._valueMax();
                                break;
                            case t.ui.keyCode.PAGE_UP:
                                s = this._trimAlignValue(n + (this._valueMax() - this._valueMin()) / 5);
                                break;
                            case t.ui.keyCode.PAGE_DOWN:
                                s = this._trimAlignValue(n - (this._valueMax() - this._valueMin()) / 5);
                                break;
                            case t.ui.keyCode.UP:
                            case t.ui.keyCode.RIGHT:
                                if (n === this._valueMax()) return;
                                s = this._trimAlignValue(n + o);
                                break;
                            case t.ui.keyCode.DOWN:
                            case t.ui.keyCode.LEFT:
                                if (n === this._valueMin()) return;
                                s = this._trimAlignValue(n - o)
                        }
                        this._slide(e, r, s)
                    },
                    keyup: function(e) {
                        var i = t(e.target).data("ui-slider-handle-index");
                        this._keySliding && (this._keySliding = !1, this._stop(e, i), this._change(e, i), t(e.target).removeClass("ui-state-active"))
                    }
                }), this._refreshValue(), this._animateOff = !1
            },
            _destroy: function() {
                this.handles.remove(), this.range.remove(), this.element.removeClass("ui-slider ui-slider-horizontal ui-slider-vertical ui-slider-disabled ui-widget ui-widget-content ui-corner-all"), this._mouseDestroy()
            },
            _mouseCapture: function(e) {
                var i, n, s, o, r, a, l, h = this,
                    c = this.options;
                return !c.disabled && (this.elementSize = {
                    width: this.element.outerWidth(),
                    height: this.element.outerHeight()
                }, this.elementOffset = this.element.offset(), i = {
                    x: e.pageX,
                    y: e.pageY
                }, n = this._normValueFromMouse(i), s = this._valueMax() - this._valueMin() + 1, this.handles.each(function(e) {
                    var i = Math.abs(n - h.values(e));
                    s > i && (s = i, o = t(this), r = e)
                }), !0 === c.range && this.values(1) === c.min && (r += 1, o = t(this.handles[r])), !1 !== this._start(e, r) && (this._mouseSliding = !0, this._handleIndex = r, o.addClass("ui-state-active").focus(), a = o.offset(), l = !t(e.target).parents().andSelf().is(".ui-slider-handle"), this._clickOffset = l ? {
                    left: 0,
                    top: 0
                } : {
                    left: e.pageX - a.left - o.width() / 2,
                    top: e.pageY - a.top - o.height() / 2 - (parseInt(o.css("borderTopWidth"), 10) || 0) - (parseInt(o.css("borderBottomWidth"), 10) || 0) + (parseInt(o.css("marginTop"), 10) || 0)
                }, this.handles.hasClass("ui-state-hover") || this._slide(e, r, n), this._animateOff = !0, !0))
            },
            _mouseStart: function() {
                return !0
            },
            _mouseDrag: function(t) {
                var e = {
                        x: t.pageX,
                        y: t.pageY
                    },
                    i = this._normValueFromMouse(e);
                return this._slide(t, this._handleIndex, i), !1
            },
            _mouseStop: function(t) {
                return this.handles.removeClass("ui-state-active"), this._mouseSliding = !1, this._stop(t, this._handleIndex), this._change(t, this._handleIndex), this._handleIndex = null, this._clickOffset = null, this._animateOff = !1, !1
            },
            _detectOrientation: function() {
                this.orientation = "vertical" === this.options.orientation ? "vertical" : "horizontal"
            },
            _normValueFromMouse: function(t) {
                var e, i, n, s, o;
                return "horizontal" === this.orientation ? (e = this.elementSize.width, i = t.x - this.elementOffset.left - (this._clickOffset ? this._clickOffset.left : 0)) : (e = this.elementSize.height, i = t.y - this.elementOffset.top - (this._clickOffset ? this._clickOffset.top : 0)), n = i / e, n > 1 && (n = 1), n < 0 && (n = 0), "vertical" === this.orientation && (n = 1 - n), s = this._valueMax() - this._valueMin(), o = this._valueMin() + n * s, this._trimAlignValue(o)
            },
            _start: function(t, e) {
                var i = {
                    handle: this.handles[e],
                    value: this.value()
                };
                return this.options.values && this.options.values.length && (i.value = this.values(e), i.values = this.values()), this._trigger("start", t, i)
            },
            _slide: function(t, e, i) {
                var n, s, o;
                this.options.values && this.options.values.length ? (n = this.values(e ? 0 : 1), 2 === this.options.values.length && !0 === this.options.range && (0 === e && i > n || 1 === e && i < n) && (i = n), i !== this.values(e) && (s = this.values(), s[e] = i, o = this._trigger("slide", t, {
                    handle: this.handles[e],
                    value: i,
                    values: s
                }), n = this.values(e ? 0 : 1), !1 !== o && this.values(e, i, !0))) : i !== this.value() && !1 !== (o = this._trigger("slide", t, {
                    handle: this.handles[e],
                    value: i
                })) && this.value(i)
            },
            _stop: function(t, e) {
                var i = {
                    handle: this.handles[e],
                    value: this.value()
                };
                this.options.values && this.options.values.length && (i.value = this.values(e), i.values = this.values()), this._trigger("stop", t, i)
            },
            _change: function(t, e) {
                if (!this._keySliding && !this._mouseSliding) {
                    var i = {
                        handle: this.handles[e],
                        value: this.value()
                    };
                    this.options.values && this.options.values.length && (i.value = this.values(e), i.values = this.values()), this._trigger("change", t, i)
                }
            },
            value: function(t) {
                return arguments.length ? (this.options.value = this._trimAlignValue(t), this._refreshValue(), this._change(null, 0), void 0) : this._value()
            },
            values: function(e, i) {
                var n, s, o;
                if (arguments.length > 1) return this.options.values[e] = this._trimAlignValue(i), this._refreshValue(), this._change(null, e), void 0;
                if (!arguments.length) return this._values();
                if (!t.isArray(arguments[0])) return this.options.values && this.options.values.length ? this._values(e) : this.value();
                for (n = this.options.values, s = arguments[0], o = 0; o < n.length; o += 1) n[o] = this._trimAlignValue(s[o]), this._change(null, o);
                this._refreshValue()
            },
            _setOption: function(e, i) {
                var n, s = 0;
                switch (t.isArray(this.options.values) && (s = this.options.values.length), t.Widget.prototype._setOption.apply(this, arguments), e) {
                    case "disabled":
                        i ? (this.handles.filter(".ui-state-focus").blur(), this.handles.removeClass("ui-state-hover"), this.handles.prop("disabled", !0), this.element.addClass("ui-disabled")) : (this.handles.prop("disabled", !1), this.element.removeClass("ui-disabled"));
                        break;
                    case "orientation":
                        this._detectOrientation(), this.element.removeClass("ui-slider-horizontal ui-slider-vertical").addClass("ui-slider-" + this.orientation), this._refreshValue();
                        break;
                    case "value":
                        this._animateOff = !0, this._refreshValue(), this._change(null, 0), this._animateOff = !1;
                        break;
                    case "values":
                        for (this._animateOff = !0, this._refreshValue(), n = 0; n < s; n += 1) this._change(null, n);
                        this._animateOff = !1;
                        break;
                    case "min":
                    case "max":
                        this._animateOff = !0, this._refreshValue(), this._animateOff = !1
                }
            },
            _value: function() {
                var t = this.options.value;
                return t = this._trimAlignValue(t)
            },
            _values: function(t) {
                var e, i, n;
                if (arguments.length) return e = this.options.values[t], e = this._trimAlignValue(e);
                for (i = this.options.values.slice(), n = 0; n < i.length; n += 1) i[n] = this._trimAlignValue(i[n]);
                return i
            },
            _trimAlignValue: function(t) {
                if (t <= this._valueMin()) return this._valueMin();
                if (t >= this._valueMax()) return this._valueMax();
                var e = this.options.step > 0 ? this.options.step : 1,
                    i = (t - this._valueMin()) % e,
                    n = t - i;
                return 2 * Math.abs(i) >= e && (n += i > 0 ? e : -e), parseFloat(n.toFixed(5))
            },
            _valueMin: function() {
                return this.options.min
            },
            _valueMax: function() {
                return this.options.max
            },
            _refreshValue: function() {
                var e, i, n, s, o, r = this.options.range,
                    a = this.options,
                    l = this,
                    h = !this._animateOff && a.animate,
                    c = {};
                this.options.values && this.options.values.length ? this.handles.each(function(n) {
                    i = (l.values(n) - l._valueMin()) / (l._valueMax() - l._valueMin()) * 100, c["horizontal" === l.orientation ? "left" : "bottom"] = i + "%", t(this).stop(1, 1)[h ? "animate" : "css"](c, a.animate), !0 === l.options.range && ("horizontal" === l.orientation ? (0 === n && l.range.stop(1, 1)[h ? "animate" : "css"]({
                        left: i + "%"
                    }, a.animate), 1 === n && l.range[h ? "animate" : "css"]({
                        width: i - e + "%"
                    }, {
                        queue: !1,
                        duration: a.animate
                    })) : (0 === n && l.range.stop(1, 1)[h ? "animate" : "css"]({
                        bottom: i + "%"
                    }, a.animate), 1 === n && l.range[h ? "animate" : "css"]({
                        height: i - e + "%"
                    }, {
                        queue: !1,
                        duration: a.animate
                    }))), e = i
                }) : (n = this.value(), s = this._valueMin(), o = this._valueMax(), i = o !== s ? (n - s) / (o - s) * 100 : 0, c["horizontal" === this.orientation ? "left" : "bottom"] = i + "%", this.handle.stop(1, 1)[h ? "animate" : "css"](c, a.animate), "min" === r && "horizontal" === this.orientation && this.range.stop(1, 1)[h ? "animate" : "css"]({
                    width: i + "%"
                }, a.animate), "max" === r && "horizontal" === this.orientation && this.range[h ? "animate" : "css"]({
                    width: 100 - i + "%"
                }, {
                    queue: !1,
                    duration: a.animate
                }), "min" === r && "vertical" === this.orientation && this.range.stop(1, 1)[h ? "animate" : "css"]({
                    height: i + "%"
                }, a.animate), "max" === r && "vertical" === this.orientation && this.range[h ? "animate" : "css"]({
                    height: 100 - i + "%"
                }, {
                    queue: !1,
                    duration: a.animate
                }))
            }
        })
    }(jQuery), function(t) {
        function e(t) {
            return function() {
                var e = this.element.val();
                t.apply(this, arguments), this._refresh(), e !== this.element.val() && this._trigger("change")
            }
        }
        t.widget("ui.spinner", {
            version: "1.9.2",
            defaultElement: "<input>",
            widgetEventPrefix: "spin",
            options: {
                culture: null,
                icons: {
                    down: "ui-icon-triangle-1-s",
                    up: "ui-icon-triangle-1-n"
                },
                incremental: !0,
                max: null,
                min: null,
                numberFormat: null,
                page: 10,
                step: 1,
                change: null,
                spin: null,
                start: null,
                stop: null
            },
            _create: function() {
                this._setOption("max", this.options.max), this._setOption("min", this.options.min), this._setOption("step", this.options.step), this._value(this.element.val(), !0), this._draw(), this._on(this._events), this._refresh(), this._on(this.window, {
                    beforeunload: function() {
                        this.element.removeAttr("autocomplete")
                    }
                })
            },
            _getCreateOptions: function() {
                var e = {},
                    i = this.element;
                return t.each(["min", "max", "step"], function(t, n) {
                    var s = i.attr(n);
                    void 0 !== s && s.length && (e[n] = s)
                }), e
            },
            _events: {
                keydown: function(t) {
                    this._start(t) && this._keydown(t) && t.preventDefault()
                },
                keyup: "_stop",
                focus: function() {
                    this.previous = this.element.val()
                },
                blur: function(t) {
                    if (this.cancelBlur) return void delete this.cancelBlur;
                    this._refresh(), this.previous !== this.element.val() && this._trigger("change", t)
                },
                mousewheel: function(t, e) {
                    if (e) return !(!this.spinning && !this._start(t)) && (this._spin((e > 0 ? 1 : -1) * this.options.step, t), clearTimeout(this.mousewheelTimer), this.mousewheelTimer = this._delay(function() {
                        this.spinning && this._stop(t)
                    }, 100), t.preventDefault(), void 0)
                },
                "mousedown .ui-spinner-button": function(e) {
                    function i() {
                        this.element[0] === this.document[0].activeElement || (this.element.focus(), this.previous = n, this._delay(function() {
                            this.previous = n
                        }))
                    }
                    var n;
                    n = this.element[0] === this.document[0].activeElement ? this.previous : this.element.val(), e.preventDefault(), i.call(this), this.cancelBlur = !0, this._delay(function() {
                        delete this.cancelBlur, i.call(this)
                    }), !1 !== this._start(e) && this._repeat(null, t(e.currentTarget).hasClass("ui-spinner-up") ? 1 : -1, e)
                },
                "mouseup .ui-spinner-button": "_stop",
                "mouseenter .ui-spinner-button": function(e) {
                    if (t(e.currentTarget).hasClass("ui-state-active")) return !1 !== this._start(e) && void this._repeat(null, t(e.currentTarget).hasClass("ui-spinner-up") ? 1 : -1, e)
                },
                "mouseleave .ui-spinner-button": "_stop"
            },
            _draw: function() {
                var t = this.uiSpinner = this.element.addClass("ui-spinner-input").attr("autocomplete", "off").wrap(this._uiSpinnerHtml()).parent().append(this._buttonHtml());
                this.element.attr("role", "spinbutton"), this.buttons = t.find(".ui-spinner-button").attr("tabIndex", -1).button().removeClass("ui-corner-all"), this.buttons.height() > Math.ceil(.5 * t.height()) && t.height() > 0 && t.height(t.height()), this.options.disabled && this.disable()
            },
            _keydown: function(e) {
                var i = this.options,
                    n = t.ui.keyCode;
                switch (e.keyCode) {
                    case n.UP:
                        return this._repeat(null, 1, e), !0;
                    case n.DOWN:
                        return this._repeat(null, -1, e), !0;
                    case n.PAGE_UP:
                        return this._repeat(null, i.page, e), !0;
                    case n.PAGE_DOWN:
                        return this._repeat(null, -i.page, e), !0
                }
                return !1
            },
            _uiSpinnerHtml: function() {
                return "<span class='ui-spinner ui-widget ui-widget-content ui-corner-all'></span>"
            },
            _buttonHtml: function() {
                return "<a class='ui-spinner-button ui-spinner-up ui-corner-tr'><span class='ui-icon " + this.options.icons.up + "'>&#9650;</span></a><a class='ui-spinner-button ui-spinner-down ui-corner-br'><span class='ui-icon " + this.options.icons.down + "'>&#9660;</span></a>"
            },
            _start: function(t) {
                return !(!this.spinning && !1 === this._trigger("start", t)) && (this.counter || (this.counter = 1), this.spinning = !0, !0)
            },
            _repeat: function(t, e, i) {
                t = t || 500, clearTimeout(this.timer), this.timer = this._delay(function() {
                    this._repeat(40, e, i)
                }, t), this._spin(e * this.options.step, i)
            },
            _spin: function(t, e) {
                var i = this.value() || 0;
                this.counter || (this.counter = 1), i = this._adjustValue(i + t * this._increment(this.counter)), this.spinning && !1 === this._trigger("spin", e, {
                    value: i
                }) || (this._value(i), this.counter++)
            },
            _increment: function(e) {
                var i = this.options.incremental;
                return i ? t.isFunction(i) ? i(e) : Math.floor(e * e * e / 5e4 - e * e / 500 + 17 * e / 200 + 1) : 1
            },
            _precision: function() {
                var t = this._precisionOf(this.options.step);
                return null !== this.options.min && (t = Math.max(t, this._precisionOf(this.options.min))), t
            },
            _precisionOf: function(t) {
                var e = t.toString(),
                    i = e.indexOf(".");
                return -1 === i ? 0 : e.length - i - 1
            },
            _adjustValue: function(t) {
                var e, i, n = this.options;
                return e = null !== n.min ? n.min : 0, i = t - e, i = Math.round(i / n.step) * n.step, t = e + i, t = parseFloat(t.toFixed(this._precision())), null !== n.max && t > n.max ? n.max : null !== n.min && t < n.min ? n.min : t
            },
            _stop: function(t) {
                this.spinning && (clearTimeout(this.timer), clearTimeout(this.mousewheelTimer), this.counter = 0, this.spinning = !1, this._trigger("stop", t))
            },
            _setOption: function(t, e) {
                if ("culture" === t || "numberFormat" === t) {
                    var i = this._parse(this.element.val());
                    return this.options[t] = e, void this.element.val(this._format(i))
                }("max" === t || "min" === t || "step" === t) && "string" == typeof e && (e = this._parse(e)), this._super(t, e), "disabled" === t && (e ? (this.element.prop("disabled", !0), this.buttons.button("disable")) : (this.element.prop("disabled", !1), this.buttons.button("enable")))
            },
            _setOptions: e(function(t) {
                this._super(t), this._value(this.element.val())
            }),
            _parse: function(t) {
                return "string" == typeof t && "" !== t && (t = window.Globalize && this.options.numberFormat ? Globalize.parseFloat(t, 10, this.options.culture) : +t), "" === t || isNaN(t) ? null : t
            },
            _format: function(t) {
                return "" === t ? "" : window.Globalize && this.options.numberFormat ? Globalize.format(t, this.options.numberFormat, this.options.culture) : t
            },
            _refresh: function() {
                this.element.attr({
                    "aria-valuemin": this.options.min,
                    "aria-valuemax": this.options.max,
                    "aria-valuenow": this._parse(this.element.val())
                })
            },
            _value: function(t, e) {
                var i;
                "" !== t && null !== (i = this._parse(t)) && (e || (i = this._adjustValue(i)), t = this._format(i)), this.element.val(t), this._refresh()
            },
            _destroy: function() {
                this.element.removeClass("ui-spinner-input").prop("disabled", !1).removeAttr("autocomplete").removeAttr("role").removeAttr("aria-valuemin").removeAttr("aria-valuemax").removeAttr("aria-valuenow"), this.uiSpinner.replaceWith(this.element)
            },
            stepUp: e(function(t) {
                this._stepUp(t)
            }),
            _stepUp: function(t) {
                this._spin((t || 1) * this.options.step)
            },
            stepDown: e(function(t) {
                this._stepDown(t)
            }),
            _stepDown: function(t) {
                this._spin((t || 1) * -this.options.step)
            },
            pageUp: e(function(t) {
                this._stepUp((t || 1) * this.options.page)
            }),
            pageDown: e(function(t) {
                this._stepDown((t || 1) * this.options.page)
            }),
            value: function(t) {
                if (!arguments.length) return this._parse(this.element.val());
                e(this._value).call(this, t)
            },
            widget: function() {
                return this.uiSpinner
            }
        })
    }(jQuery), function(t, e) {
        function i() {
            return ++s
        }

        function n(t) {
            return t.hash.length > 1 && t.href.replace(o, "") === location.href.replace(o, "").replace(/\s/g, "%20")
        }
        var s = 0,
            o = /#.*$/;
        t.widget("ui.tabs", {
            version: "1.9.2",
            delay: 300,
            options: {
                active: null,
                collapsible: !1,
                event: "click",
                heightStyle: "content",
                hide: null,
                show: null,
                activate: null,
                beforeActivate: null,
                beforeLoad: null,
                load: null
            },
            _create: function() {
                var e = this,
                    i = this.options,
                    n = i.active,
                    s = location.hash.substring(1);
                this.running = !1, this.element.addClass("ui-tabs ui-widget ui-widget-content ui-corner-all").toggleClass("ui-tabs-collapsible", i.collapsible).delegate(".ui-tabs-nav > li", "mousedown" + this.eventNamespace, function(e) {
                    t(this).is(".ui-state-disabled") && e.preventDefault()
                }).delegate(".ui-tabs-anchor", "focus" + this.eventNamespace, function() {
                    t(this).closest("li").is(".ui-state-disabled") && this.blur()
                }), this._processTabs(), null === n && (s && this.tabs.each(function(e, i) {
                    if (t(i).attr("aria-controls") === s) return n = e, !1
                }), null === n && (n = this.tabs.index(this.tabs.filter(".ui-tabs-active"))), null !== n && -1 !== n || (n = !!this.tabs.length && 0)), !1 !== n && -1 === (n = this.tabs.index(this.tabs.eq(n))) && (n = !i.collapsible && 0), i.active = n, !i.collapsible && !1 === i.active && this.anchors.length && (i.active = 0), t.isArray(i.disabled) && (i.disabled = t.unique(i.disabled.concat(t.map(this.tabs.filter(".ui-state-disabled"), function(t) {
                    return e.tabs.index(t)
                }))).sort()), !1 !== this.options.active && this.anchors.length ? this.active = this._findActive(this.options.active) : this.active = t(), this._refresh(), this.active.length && this.load(i.active)
            },
            _getCreateEventData: function() {
                return {
                    tab: this.active,
                    panel: this.active.length ? this._getPanelForTab(this.active) : t()
                }
            },
            _tabKeydown: function(e) {
                var i = t(this.document[0].activeElement).closest("li"),
                    n = this.tabs.index(i),
                    s = !0;
                if (!this._handlePageNav(e)) {
                    switch (e.keyCode) {
                        case t.ui.keyCode.RIGHT:
                        case t.ui.keyCode.DOWN:
                            n++;
                            break;
                        case t.ui.keyCode.UP:
                        case t.ui.keyCode.LEFT:
                            s = !1, n--;
                            break;
                        case t.ui.keyCode.END:
                            n = this.anchors.length - 1;
                            break;
                        case t.ui.keyCode.HOME:
                            n = 0;
                            break;
                        case t.ui.keyCode.SPACE:
                            return e.preventDefault(), clearTimeout(this.activating), this._activate(n), void 0;
                        case t.ui.keyCode.ENTER:
                            return e.preventDefault(), clearTimeout(this.activating), this._activate(n !== this.options.active && n), void 0;
                        default:
                            return
                    }
                    e.preventDefault(), clearTimeout(this.activating), n = this._focusNextTab(n, s), e.ctrlKey || (i.attr("aria-selected", "false"), this.tabs.eq(n).attr("aria-selected", "true"), this.activating = this._delay(function() {
                        this.option("active", n)
                    }, this.delay))
                }
            },
            _panelKeydown: function(e) {
                this._handlePageNav(e) || e.ctrlKey && e.keyCode === t.ui.keyCode.UP && (e.preventDefault(), this.active.focus())
            },
            _handlePageNav: function(e) {
                return e.altKey && e.keyCode === t.ui.keyCode.PAGE_UP ? (this._activate(this._focusNextTab(this.options.active - 1, !1)), !0) : e.altKey && e.keyCode === t.ui.keyCode.PAGE_DOWN ? (this._activate(this._focusNextTab(this.options.active + 1, !0)), !0) : void 0
            },
            _findNextTab: function(e, i) {
                for (var n = this.tabs.length - 1; - 1 !== t.inArray(function() {
                        return e > n && (e = 0), e < 0 && (e = n), e
                    }(), this.options.disabled);) e = i ? e + 1 : e - 1;
                return e
            },
            _focusNextTab: function(t, e) {
                return t = this._findNextTab(t, e), this.tabs.eq(t).focus(), t
            },
            _setOption: function(t, e) {
                return "active" === t ? void this._activate(e) : "disabled" === t ? void this._setupDisabled(e) : (this._super(t, e), "collapsible" === t && (this.element.toggleClass("ui-tabs-collapsible", e), !e && !1 === this.options.active && this._activate(0)), "event" === t && this._setupEvents(e), "heightStyle" === t && this._setupHeightStyle(e), void 0)
            },
            _tabId: function(t) {
                return t.attr("aria-controls") || "ui-tabs-" + i()
            },
            _sanitizeSelector: function(t) {
                return t ? t.replace(/[!"$%&'()*+,.\/:;<=>?@\[\]\^`{|}~]/g, "\\$&") : ""
            },
            refresh: function() {
                var e = this.options,
                    i = this.tablist.children(":has(a[href])");
                e.disabled = t.map(i.filter(".ui-state-disabled"), function(t) {
                    return i.index(t)
                }), this._processTabs(), !1 !== e.active && this.anchors.length ? this.active.length && !t.contains(this.tablist[0], this.active[0]) ? this.tabs.length === e.disabled.length ? (e.active = !1, this.active = t()) : this._activate(this._findNextTab(Math.max(0, e.active - 1), !1)) : e.active = this.tabs.index(this.active) : (e.active = !1, this.active = t()), this._refresh()
            },
            _refresh: function() {
                this._setupDisabled(this.options.disabled), this._setupEvents(this.options.event), this._setupHeightStyle(this.options.heightStyle), this.tabs.not(this.active).attr({
                    "aria-selected": "false",
                    tabIndex: -1
                }), this.panels.not(this._getPanelForTab(this.active)).hide().attr({
                    "aria-expanded": "false",
                    "aria-hidden": "true"
                }), this.active.length ? (this.active.addClass("ui-tabs-active ui-state-active").attr({
                    "aria-selected": "true",
                    tabIndex: 0
                }), this._getPanelForTab(this.active).show().attr({
                    "aria-expanded": "true",
                    "aria-hidden": "false"
                })) : this.tabs.eq(0).attr("tabIndex", 0)
            },
            _processTabs: function() {
                var e = this;
                this.tablist = this._getList().addClass("ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all").attr("role", "tablist"), this.tabs = this.tablist.find("> li:has(a[href])").addClass("ui-state-default ui-corner-top").attr({
                    role: "tab",
                    tabIndex: -1
                }), this.anchors = this.tabs.map(function() {
                    return t("a", this)[0]
                }).addClass("ui-tabs-anchor").attr({
                    role: "presentation",
                    tabIndex: -1
                }), this.panels = t(), this.anchors.each(function(i, s) {
                    var o, r, a, l = t(s).uniqueId().attr("id"),
                        h = t(s).closest("li"),
                        c = h.attr("aria-controls");
                    n(s) ? (o = s.hash, r = e.element.find(e._sanitizeSelector(o))) : (a = e._tabId(h), o = "#" + a, r = e.element.find(o), r.length || (r = e._createPanel(a), r.insertAfter(e.panels[i - 1] || e.tablist)), r.attr("aria-live", "polite")), r.length && (e.panels = e.panels.add(r)), c && h.data("ui-tabs-aria-controls", c), h.attr({
                        "aria-controls": o.substring(1),
                        "aria-labelledby": l
                    }), r.attr("aria-labelledby", l)
                }), this.panels.addClass("ui-tabs-panel ui-widget-content ui-corner-bottom").attr("role", "tabpanel")
            },
            _getList: function() {
                return this.element.find("ol,ul").eq(0)
            },
            _createPanel: function(e) {
                return t("<div>").attr("id", e).addClass("ui-tabs-panel ui-widget-content ui-corner-bottom").data("ui-tabs-destroy", !0)
            },
            _setupDisabled: function(e) {
                t.isArray(e) && (e.length ? e.length === this.anchors.length && (e = !0) : e = !1);
                for (var i, n = 0; i = this.tabs[n]; n++) !0 === e || -1 !== t.inArray(n, e) ? t(i).addClass("ui-state-disabled").attr("aria-disabled", "true") : t(i).removeClass("ui-state-disabled").removeAttr("aria-disabled");
                this.options.disabled = e
            },
            _setupEvents: function(e) {
                var i = {
                    click: function(t) {
                        t.preventDefault()
                    }
                };
                e && t.each(e.split(" "), function(t, e) {
                    i[e] = "_eventHandler"
                }), this._off(this.anchors.add(this.tabs).add(this.panels)), this._on(this.anchors, i), this._on(this.tabs, {
                    keydown: "_tabKeydown"
                }), this._on(this.panels, {
                    keydown: "_panelKeydown"
                }), this._focusable(this.tabs), this._hoverable(this.tabs)
            },
            _setupHeightStyle: function(e) {
                var i, n, s = this.element.parent();
                "fill" === e ? (t.support.minHeight || (n = s.css("overflow"), s.css("overflow", "hidden")), i = s.height(), this.element.siblings(":visible").each(function() {
                    var e = t(this),
                        n = e.css("position");
                    "absolute" !== n && "fixed" !== n && (i -= e.outerHeight(!0))
                }), n && s.css("overflow", n), this.element.children().not(this.panels).each(function() {
                    i -= t(this).outerHeight(!0)
                }), this.panels.each(function() {
                    t(this).height(Math.max(0, i - t(this).innerHeight() + t(this).height()))
                }).css("overflow", "auto")) : "auto" === e && (i = 0, this.panels.each(function() {
                    i = Math.max(i, t(this).height("").height())
                }).height(i))
            },
            _eventHandler: function(e) {
                var i = this.options,
                    n = this.active,
                    s = t(e.currentTarget),
                    o = s.closest("li"),
                    r = o[0] === n[0],
                    a = r && i.collapsible,
                    l = a ? t() : this._getPanelForTab(o),
                    h = n.length ? this._getPanelForTab(n) : t(),
                    c = {
                        oldTab: n,
                        oldPanel: h,
                        newTab: a ? t() : o,
                        newPanel: l
                    };
                e.preventDefault(), o.hasClass("ui-state-disabled") || o.hasClass("ui-tabs-loading") || this.running || r && !i.collapsible || !1 === this._trigger("beforeActivate", e, c) || (i.active = !a && this.tabs.index(o), this.active = r ? t() : o, this.xhr && this.xhr.abort(), !h.length && !l.length && t.error("jQuery UI Tabs: Mismatching fragment identifier."), l.length && this.load(this.tabs.index(o), e), this._toggle(e, c))
            },
            _toggle: function(e, i) {
                function n() {
                    o.running = !1, o._trigger("activate", e, i)
                }

                function s() {
                    i.newTab.closest("li").addClass("ui-tabs-active ui-state-active"), r.length && o.options.show ? o._show(r, o.options.show, n) : (r.show(), n())
                }
                var o = this,
                    r = i.newPanel,
                    a = i.oldPanel;
                this.running = !0, a.length && this.options.hide ? this._hide(a, this.options.hide, function() {
                        i.oldTab.closest("li").removeClass("ui-tabs-active ui-state-active"), s()
                    }) : (i.oldTab.closest("li").removeClass("ui-tabs-active ui-state-active"), a.hide(), s()), a.attr({
                        "aria-expanded": "false",
                        "aria-hidden": "true"
                    }), i.oldTab.attr("aria-selected", "false"), r.length && a.length ? i.oldTab.attr("tabIndex", -1) : r.length && this.tabs.filter(function() {
                        return 0 === t(this).attr("tabIndex")
                    }).attr("tabIndex", -1), r.attr({
                        "aria-expanded": "true",
                        "aria-hidden": "false"
                    }),
                    i.newTab.attr({
                        "aria-selected": "true",
                        tabIndex: 0
                    })
            },
            _activate: function(e) {
                var i, n = this._findActive(e);
                n[0] !== this.active[0] && (n.length || (n = this.active), i = n.find(".ui-tabs-anchor")[0], this._eventHandler({
                    target: i,
                    currentTarget: i,
                    preventDefault: t.noop
                }))
            },
            _findActive: function(e) {
                return !1 === e ? t() : this.tabs.eq(e)
            },
            _getIndex: function(t) {
                return "string" == typeof t && (t = this.anchors.index(this.anchors.filter("[href$='" + t + "']"))), t
            },
            _destroy: function() {
                this.xhr && this.xhr.abort(), this.element.removeClass("ui-tabs ui-widget ui-widget-content ui-corner-all ui-tabs-collapsible"), this.tablist.removeClass("ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all").removeAttr("role"), this.anchors.removeClass("ui-tabs-anchor").removeAttr("role").removeAttr("tabIndex").removeData("href.tabs").removeData("load.tabs").removeUniqueId(), this.tabs.add(this.panels).each(function() {
                    t.data(this, "ui-tabs-destroy") ? t(this).remove() : t(this).removeClass("ui-state-default ui-state-active ui-state-disabled ui-corner-top ui-corner-bottom ui-widget-content ui-tabs-active ui-tabs-panel").removeAttr("tabIndex").removeAttr("aria-live").removeAttr("aria-busy").removeAttr("aria-selected").removeAttr("aria-labelledby").removeAttr("aria-hidden").removeAttr("aria-expanded").removeAttr("role")
                }), this.tabs.each(function() {
                    var e = t(this),
                        i = e.data("ui-tabs-aria-controls");
                    i ? e.attr("aria-controls", i) : e.removeAttr("aria-controls")
                }), this.panels.show(), "content" !== this.options.heightStyle && this.panels.css("height", "")
            },
            enable: function(i) {
                var n = this.options.disabled;
                !1 !== n && (i === e ? n = !1 : (i = this._getIndex(i), n = t.isArray(n) ? t.map(n, function(t) {
                    return t !== i ? t : null
                }) : t.map(this.tabs, function(t, e) {
                    return e !== i ? e : null
                })), this._setupDisabled(n))
            },
            disable: function(i) {
                var n = this.options.disabled;
                if (!0 !== n) {
                    if (i === e) n = !0;
                    else {
                        if (i = this._getIndex(i), -1 !== t.inArray(i, n)) return;
                        n = t.isArray(n) ? t.merge([i], n).sort() : [i]
                    }
                    this._setupDisabled(n)
                }
            },
            load: function(e, i) {
                e = this._getIndex(e);
                var s = this,
                    o = this.tabs.eq(e),
                    r = o.find(".ui-tabs-anchor"),
                    a = this._getPanelForTab(o),
                    l = {
                        tab: o,
                        panel: a
                    };
                n(r[0]) || (this.xhr = t.ajax(this._ajaxSettings(r, i, l)), this.xhr && "canceled" !== this.xhr.statusText && (o.addClass("ui-tabs-loading"), a.attr("aria-busy", "true"), this.xhr.success(function(t) {
                    setTimeout(function() {
                        a.html(t), s._trigger("load", i, l)
                    }, 1)
                }).complete(function(t, e) {
                    setTimeout(function() {
                        "abort" === e && s.panels.stop(!1, !0), o.removeClass("ui-tabs-loading"), a.removeAttr("aria-busy"), t === s.xhr && delete s.xhr
                    }, 1)
                })))
            },
            _ajaxSettings: function(e, i, n) {
                var s = this;
                return {
                    url: e.attr("href"),
                    beforeSend: function(e, o) {
                        return s._trigger("beforeLoad", i, t.extend({
                            jqXHR: e,
                            ajaxSettings: o
                        }, n))
                    }
                }
            },
            _getPanelForTab: function(e) {
                var i = t(e).attr("aria-controls");
                return this.element.find(this._sanitizeSelector("#" + i))
            }
        }), !1 !== t.uiBackCompat && (t.ui.tabs.prototype._ui = function(t, e) {
            return {
                tab: t,
                panel: e,
                index: this.anchors.index(t)
            }
        }, t.widget("ui.tabs", t.ui.tabs, {
            url: function(t, e) {
                this.anchors.eq(t).attr("href", e)
            }
        }), t.widget("ui.tabs", t.ui.tabs, {
            options: {
                ajaxOptions: null,
                cache: !1
            },
            _create: function() {
                this._super();
                var e = this;
                this._on({
                    tabsbeforeload: function(i, n) {
                        if (t.data(n.tab[0], "cache.tabs")) return void i.preventDefault();
                        n.jqXHR.success(function() {
                            e.options.cache && t.data(n.tab[0], "cache.tabs", !0)
                        })
                    }
                })
            },
            _ajaxSettings: function(e, i, n) {
                var s = this.options.ajaxOptions;
                return t.extend({}, s, {
                    error: function(t, e) {
                        try {
                            s.error(t, e, n.tab.closest("li").index(), n.tab[0])
                        } catch (t) {}
                    }
                }, this._superApply(arguments))
            },
            _setOption: function(t, e) {
                "cache" === t && !1 === e && this.anchors.removeData("cache.tabs"), this._super(t, e)
            },
            _destroy: function() {
                this.anchors.removeData("cache.tabs"), this._super()
            },
            url: function(t) {
                this.anchors.eq(t).removeData("cache.tabs"), this._superApply(arguments)
            }
        }), t.widget("ui.tabs", t.ui.tabs, {
            abort: function() {
                this.xhr && this.xhr.abort()
            }
        }), t.widget("ui.tabs", t.ui.tabs, {
            options: {
                spinner: "<em>Loading&#8230;</em>"
            },
            _create: function() {
                this._super(), this._on({
                    tabsbeforeload: function(t, e) {
                        if (t.target === this.element[0] && this.options.spinner) {
                            var i = e.tab.find("span"),
                                n = i.html();
                            i.html(this.options.spinner), e.jqXHR.complete(function() {
                                i.html(n)
                            })
                        }
                    }
                })
            }
        }), t.widget("ui.tabs", t.ui.tabs, {
            options: {
                enable: null,
                disable: null
            },
            enable: function(e) {
                var i, n = this.options;
                (e && !0 === n.disabled || t.isArray(n.disabled) && -1 !== t.inArray(e, n.disabled)) && (i = !0), this._superApply(arguments), i && this._trigger("enable", null, this._ui(this.anchors[e], this.panels[e]))
            },
            disable: function(e) {
                var i, n = this.options;
                (e && !1 === n.disabled || t.isArray(n.disabled) && -1 === t.inArray(e, n.disabled)) && (i = !0), this._superApply(arguments), i && this._trigger("disable", null, this._ui(this.anchors[e], this.panels[e]))
            }
        }), t.widget("ui.tabs", t.ui.tabs, {
            options: {
                add: null,
                remove: null,
                tabTemplate: "<li><a href='#{href}'><span>#{label}</span></a></li>"
            },
            add: function(i, n, s) {
                s === e && (s = this.anchors.length);
                var o, r, a = this.options,
                    l = t(a.tabTemplate.replace(/#\{href\}/g, i).replace(/#\{label\}/g, n)),
                    h = i.indexOf("#") ? this._tabId(l) : i.replace("#", "");
                return l.addClass("ui-state-default ui-corner-top").data("ui-tabs-destroy", !0), l.attr("aria-controls", h), o = s >= this.tabs.length, r = this.element.find("#" + h), r.length || (r = this._createPanel(h), o ? s > 0 ? r.insertAfter(this.panels.eq(-1)) : r.appendTo(this.element) : r.insertBefore(this.panels[s])), r.addClass("ui-tabs-panel ui-widget-content ui-corner-bottom").hide(), o ? l.appendTo(this.tablist) : l.insertBefore(this.tabs[s]), a.disabled = t.map(a.disabled, function(t) {
                    return t >= s ? ++t : t
                }), this.refresh(), 1 === this.tabs.length && !1 === a.active && this.option("active", 0), this._trigger("add", null, this._ui(this.anchors[s], this.panels[s])), this
            },
            remove: function(e) {
                e = this._getIndex(e);
                var i = this.options,
                    n = this.tabs.eq(e).remove(),
                    s = this._getPanelForTab(n).remove();
                return n.hasClass("ui-tabs-active") && this.anchors.length > 2 && this._activate(e + (e + 1 < this.anchors.length ? 1 : -1)), i.disabled = t.map(t.grep(i.disabled, function(t) {
                    return t !== e
                }), function(t) {
                    return t >= e ? --t : t
                }), this.refresh(), this._trigger("remove", null, this._ui(n.find("a")[0], s[0])), this
            }
        }), t.widget("ui.tabs", t.ui.tabs, {
            length: function() {
                return this.anchors.length
            }
        }), t.widget("ui.tabs", t.ui.tabs, {
            options: {
                idPrefix: "ui-tabs-"
            },
            _tabId: function(e) {
                var n = e.is("li") ? e.find("a[href]") : e;
                return n = n[0], t(n).closest("li").attr("aria-controls") || n.title && n.title.replace(/\s/g, "_").replace(/[^\w\u00c0-\uFFFF\-]/g, "") || this.options.idPrefix + i()
            }
        }), t.widget("ui.tabs", t.ui.tabs, {
            options: {
                panelTemplate: "<div></div>"
            },
            _createPanel: function(e) {
                return t(this.options.panelTemplate).attr("id", e).addClass("ui-tabs-panel ui-widget-content ui-corner-bottom").data("ui-tabs-destroy", !0)
            }
        }), t.widget("ui.tabs", t.ui.tabs, {
            _create: function() {
                var t = this.options;
                null === t.active && t.selected !== e && (t.active = -1 !== t.selected && t.selected), this._super(), t.selected = t.active, !1 === t.selected && (t.selected = -1)
            },
            _setOption: function(t, e) {
                if ("selected" !== t) return this._super(t, e);
                var i = this.options;
                this._super("active", -1 !== e && e), i.selected = i.active, !1 === i.selected && (i.selected = -1)
            },
            _eventHandler: function() {
                this._superApply(arguments), this.options.selected = this.options.active, !1 === this.options.selected && (this.options.selected = -1)
            }
        }), t.widget("ui.tabs", t.ui.tabs, {
            options: {
                show: null,
                select: null
            },
            _create: function() {
                this._super(), !1 !== this.options.active && this._trigger("show", null, this._ui(this.active.find(".ui-tabs-anchor")[0], this._getPanelForTab(this.active)[0]))
            },
            _trigger: function(t, e, i) {
                var n, s, o = this._superApply(arguments);
                return !!o && ("beforeActivate" === t ? (n = i.newTab.length ? i.newTab : i.oldTab, s = i.newPanel.length ? i.newPanel : i.oldPanel, o = this._super("select", e, {
                    tab: n.find(".ui-tabs-anchor")[0],
                    panel: s[0],
                    index: n.closest("li").index()
                })) : "activate" === t && i.newTab.length && (o = this._super("show", e, {
                    tab: i.newTab.find(".ui-tabs-anchor")[0],
                    panel: i.newPanel[0],
                    index: i.newTab.closest("li").index()
                })), o)
            }
        }), t.widget("ui.tabs", t.ui.tabs, {
            select: function(t) {
                if (-1 === (t = this._getIndex(t))) {
                    if (!this.options.collapsible || -1 === this.options.selected) return;
                    t = this.options.selected
                }
                this.anchors.eq(t).trigger(this.options.event + this.eventNamespace)
            }
        }), function() {
            var e = 0;
            t.widget("ui.tabs", t.ui.tabs, {
                options: {
                    cookie: null
                },
                _create: function() {
                    var t, e = this.options;
                    null == e.active && e.cookie && (t = parseInt(this._cookie(), 10), -1 === t && (t = !1), e.active = t), this._super()
                },
                _cookie: function(i) {
                    var n = [this.cookie || (this.cookie = this.options.cookie.name || "ui-tabs-" + ++e)];
                    return arguments.length && (n.push(!1 === i ? -1 : i), n.push(this.options.cookie)), t.cookie.apply(null, n)
                },
                _refresh: function() {
                    this._super(), this.options.cookie && this._cookie(this.options.active, this.options.cookie)
                },
                _eventHandler: function() {
                    this._superApply(arguments), this.options.cookie && this._cookie(this.options.active, this.options.cookie)
                },
                _destroy: function() {
                    this._super(), this.options.cookie && this._cookie(null, this.options.cookie)
                }
            })
        }(), t.widget("ui.tabs", t.ui.tabs, {
            _trigger: function(e, i, n) {
                var s = t.extend({}, n);
                return "load" === e && (s.panel = s.panel[0], s.tab = s.tab.find(".ui-tabs-anchor")[0]), this._super(e, i, s)
            }
        }), t.widget("ui.tabs", t.ui.tabs, {
            options: {
                fx: null
            },
            _getFx: function() {
                var e, i, n = this.options.fx;
                return n && (t.isArray(n) ? (e = n[0], i = n[1]) : e = i = n), n ? {
                    show: i,
                    hide: e
                } : null
            },
            _toggle: function(t, e) {
                function i() {
                    s.running = !1, s._trigger("activate", t, e)
                }

                function n() {
                    e.newTab.closest("li").addClass("ui-tabs-active ui-state-active"), o.length && a.show ? o.animate(a.show, a.show.duration, function() {
                        i()
                    }) : (o.show(), i())
                }
                var s = this,
                    o = e.newPanel,
                    r = e.oldPanel,
                    a = this._getFx();
                if (!a) return this._super(t, e);
                s.running = !0, r.length && a.hide ? r.animate(a.hide, a.hide.duration, function() {
                    e.oldTab.closest("li").removeClass("ui-tabs-active ui-state-active"), n()
                }) : (e.oldTab.closest("li").removeClass("ui-tabs-active ui-state-active"), r.hide(), n())
            }
        }))
    }(jQuery), function(t) {
        function e(e, i) {
            var n = (e.attr("aria-describedby") || "").split(/\s+/);
            n.push(i), e.data("ui-tooltip-id", i).attr("aria-describedby", t.trim(n.join(" ")))
        }

        function i(e) {
            var i = e.data("ui-tooltip-id"),
                n = (e.attr("aria-describedby") || "").split(/\s+/),
                s = t.inArray(i, n); - 1 !== s && n.splice(s, 1), e.removeData("ui-tooltip-id"), n = t.trim(n.join(" ")), n ? e.attr("aria-describedby", n) : e.removeAttr("aria-describedby")
        }
        var n = 0;
        t.widget("ui.tooltip", {
            version: "1.9.2",
            options: {
                content: function() {
                    return t(this).attr("title")
                },
                hide: !0,
                items: "[title]:not([disabled])",
                position: {
                    my: "left top+15",
                    at: "left bottom",
                    collision: "flipfit flip"
                },
                show: !0,
                tooltipClass: null,
                track: !1,
                close: null,
                open: null
            },
            _create: function() {
                this._on({
                    mouseover: "open",
                    focusin: "open"
                }), this.tooltips = {}, this.parents = {}, this.options.disabled && this._disable()
            },
            _setOption: function(e, i) {
                var n = this;
                if ("disabled" === e) return this[i ? "_disable" : "_enable"](), void(this.options[e] = i);
                this._super(e, i), "content" === e && t.each(this.tooltips, function(t, e) {
                    n._updateContent(e)
                })
            },
            _disable: function() {
                var e = this;
                t.each(this.tooltips, function(i, n) {
                    var s = t.Event("blur");
                    s.target = s.currentTarget = n[0], e.close(s, !0)
                }), this.element.find(this.options.items).andSelf().each(function() {
                    var e = t(this);
                    e.is("[title]") && e.data("ui-tooltip-title", e.attr("title")).attr("title", "")
                })
            },
            _enable: function() {
                this.element.find(this.options.items).andSelf().each(function() {
                    var e = t(this);
                    e.data("ui-tooltip-title") && e.attr("title", e.data("ui-tooltip-title"))
                })
            },
            open: function(e) {
                var i = this,
                    n = t(e ? e.target : this.element).closest(this.options.items);
                n.length && !n.data("ui-tooltip-id") && (n.attr("title") && n.data("ui-tooltip-title", n.attr("title")), n.data("ui-tooltip-open", !0), e && "mouseover" === e.type && n.parents().each(function() {
                    var e, n = t(this);
                    n.data("ui-tooltip-open") && (e = t.Event("blur"), e.target = e.currentTarget = this, i.close(e, !0)), n.attr("title") && (n.uniqueId(), i.parents[this.id] = {
                        element: this,
                        title: n.attr("title")
                    }, n.attr("title", ""))
                }), this._updateContent(n, e))
            },
            _updateContent: function(t, e) {
                var i, n = this.options.content,
                    s = this,
                    o = e ? e.type : null;
                if ("string" == typeof n) return this._open(e, t, n);
                (i = n.call(t[0], function(i) {
                    t.data("ui-tooltip-open") && s._delay(function() {
                        e && (e.type = o), this._open(e, t, i)
                    })
                })) && this._open(e, t, i)
            },
            _open: function(i, n, s) {
                function o(t) {
                    h.of = t, r.is(":hidden") || r.position(h)
                }
                var r, a, l, h = t.extend({}, this.options.position);
                if (s) {
                    if (r = this._find(n), r.length) return void r.find(".ui-tooltip-content").html(s);
                    n.is("[title]") && (i && "mouseover" === i.type ? n.attr("title", "") : n.removeAttr("title")), r = this._tooltip(n), e(n, r.attr("id")), r.find(".ui-tooltip-content").html(s), this.options.track && i && /^mouse/.test(i.type) ? (this._on(this.document, {
                        mousemove: o
                    }), o(i)) : r.position(t.extend({ of: n
                    }, this.options.position)), r.hide(), this._show(r, this.options.show), this.options.show && this.options.show.delay && (l = setInterval(function() {
                        r.is(":visible") && (o(h.of), clearInterval(l))
                    }, t.fx.interval)), this._trigger("open", i, {
                        tooltip: r
                    }), a = {
                        keyup: function(e) {
                            if (e.keyCode === t.ui.keyCode.ESCAPE) {
                                var i = t.Event(e);
                                i.currentTarget = n[0], this.close(i, !0)
                            }
                        },
                        remove: function() {
                            this._removeTooltip(r)
                        }
                    }, i && "mouseover" !== i.type || (a.mouseleave = "close"), i && "focusin" !== i.type || (a.focusout = "close"), this._on(!0, n, a)
                }
            },
            close: function(e) {
                var n = this,
                    s = t(e ? e.currentTarget : this.element),
                    o = this._find(s);
                this.closing || (s.data("ui-tooltip-title") && s.attr("title", s.data("ui-tooltip-title")), i(s), o.stop(!0), this._hide(o, this.options.hide, function() {
                    n._removeTooltip(t(this))
                }), s.removeData("ui-tooltip-open"), this._off(s, "mouseleave focusout keyup"), s[0] !== this.element[0] && this._off(s, "remove"), this._off(this.document, "mousemove"), e && "mouseleave" === e.type && t.each(this.parents, function(e, i) {
                    t(i.element).attr("title", i.title), delete n.parents[e]
                }), this.closing = !0, this._trigger("close", e, {
                    tooltip: o
                }), this.closing = !1)
            },
            _tooltip: function(e) {
                var i = "ui-tooltip-" + n++,
                    s = t("<div>").attr({
                        id: i,
                        role: "tooltip"
                    }).addClass("ui-tooltip ui-widget ui-corner-all ui-widget-content " + (this.options.tooltipClass || ""));
                return t("<div>").addClass("ui-tooltip-content").appendTo(s), s.appendTo(this.document[0].body), t.fn.bgiframe && s.bgiframe(), this.tooltips[i] = e, s
            },
            _find: function(e) {
                var i = e.data("ui-tooltip-id");
                return i ? t("#" + i) : t()
            },
            _removeTooltip: function(t) {
                t.remove(), delete this.tooltips[t.attr("id")]
            },
            _destroy: function() {
                var e = this;
                t.each(this.tooltips, function(i, n) {
                    var s = t.Event("blur");
                    s.target = s.currentTarget = n[0], e.close(s, !0), t("#" + i).remove(), n.data("ui-tooltip-title") && (n.attr("title", n.data("ui-tooltip-title")), n.removeData("ui-tooltip-title"))
                })
            }
        })
    }(jQuery), "undefined" == typeof jQuery) throw new Error("Bootstrap's JavaScript requires jQuery");
if (+ function(t) {
        "use strict";
        var e = t.fn.jquery.split(" ")[0].split(".");
        if (e[0] < 2 && e[1] < 9 || 1 == e[0] && 9 == e[1] && e[2] < 1 || e[0] > 3) throw new Error("Bootstrap's JavaScript requires jQuery version 1.9.1 or higher, but lower than version 4")
    }(jQuery), function(t) {
        "use strict";

        function e() {
            var t = document.createElement("bootstrap"),
                e = {
                    WebkitTransition: "webkitTransitionEnd",
                    MozTransition: "transitionend",
                    OTransition: "oTransitionEnd otransitionend",
                    transition: "transitionend"
                };
            for (var i in e)
                if (void 0 !== t.style[i]) return {
                    end: e[i]
                };
            return !1
        }
        t.fn.emulateTransitionEnd = function(e) {
            var i = !1,
                n = this;
            t(this).one("bsTransitionEnd", function() {
                i = !0
            });
            var s = function() {
                i || t(n).trigger(t.support.transition.end)
            };
            return setTimeout(s, e), this
        }, t(function() {
            t.support.transition = e(), t.support.transition && (t.event.special.bsTransitionEnd = {
                bindType: t.support.transition.end,
                delegateType: t.support.transition.end,
                handle: function(e) {
                    if (t(e.target).is(this)) return e.handleObj.handler.apply(this, arguments)
                }
            })
        })
    }(jQuery), function(t) {
        "use strict";

        function e(e) {
            return this.each(function() {
                var i = t(this),
                    s = i.data("bs.alert");
                s || i.data("bs.alert", s = new n(this)), "string" == typeof e && s[e].call(i)
            })
        }
        var i = '[data-dismiss="alert"]',
            n = function(e) {
                t(e).on("click", i, this.close)
            };
        n.VERSION = "3.3.7", n.TRANSITION_DURATION = 150, n.prototype.close = function(e) {
            function i() {
                r.detach().trigger("closed.bs.alert").remove()
            }
            var s = t(this),
                o = s.attr("data-target");
            o || (o = s.attr("href"), o = o && o.replace(/.*(?=#[^\s]*$)/, ""));
            var r = t("#" === o ? [] : o);
            e && e.preventDefault(), r.length || (r = s.closest(".alert")), r.trigger(e = t.Event("close.bs.alert")), e.isDefaultPrevented() || (r.removeClass("in"), t.support.transition && r.hasClass("fade") ? r.one("bsTransitionEnd", i).emulateTransitionEnd(n.TRANSITION_DURATION) : i())
        };
        var s = t.fn.alert;
        t.fn.alert = e, t.fn.alert.Constructor = n, t.fn.alert.noConflict = function() {
            return t.fn.alert = s, this
        }, t(document).on("click.bs.alert.data-api", i, n.prototype.close)
    }(jQuery), function(t) {
        "use strict";

        function e(e) {
            return this.each(function() {
                var n = t(this),
                    s = n.data("bs.button"),
                    o = "object" == typeof e && e;
                s || n.data("bs.button", s = new i(this, o)), "toggle" == e ? s.toggle() : e && s.setState(e)
            })
        }
        var i = function(e, n) {
            this.$element = t(e), this.options = t.extend({}, i.DEFAULTS, n), this.isLoading = !1
        };
        i.VERSION = "3.3.7", i.DEFAULTS = {
            loadingText: "loading..."
        }, i.prototype.setState = function(e) {
            var i = "disabled",
                n = this.$element,
                s = n.is("input") ? "val" : "html",
                o = n.data();
            e += "Text", null == o.resetText && n.data("resetText", n[s]()), setTimeout(t.proxy(function() {
                n[s](null == o[e] ? this.options[e] : o[e]), "loadingText" == e ? (this.isLoading = !0, n.addClass(i).attr(i, i).prop(i, !0)) : this.isLoading && (this.isLoading = !1, n.removeClass(i).removeAttr(i).prop(i, !1))
            }, this), 0)
        }, i.prototype.toggle = function() {
            var t = !0,
                e = this.$element.closest('[data-toggle="buttons"]');
            if (e.length) {
                var i = this.$element.find("input");
                "radio" == i.prop("type") ? (i.prop("checked") && (t = !1), e.find(".active").removeClass("active"), this.$element.addClass("active")) : "checkbox" == i.prop("type") && (i.prop("checked") !== this.$element.hasClass("active") && (t = !1), this.$element.toggleClass("active")), i.prop("checked", this.$element.hasClass("active")), t && i.trigger("change")
            } else this.$element.attr("aria-pressed", !this.$element.hasClass("active")), this.$element.toggleClass("active")
        };
        var n = t.fn.button;
        t.fn.button = e, t.fn.button.Constructor = i, t.fn.button.noConflict = function() {
            return t.fn.button = n, this
        }, t(document).on("click.bs.button.data-api", '[data-toggle^="button"]', function(i) {
            var n = t(i.target).closest(".btn");
            e.call(n, "toggle"), t(i.target).is('input[type="radio"], input[type="checkbox"]') || (i.preventDefault(), n.is("input,button") ? n.trigger("focus") : n.find("input:visible,button:visible").first().trigger("focus"))
        }).on("focus.bs.button.data-api blur.bs.button.data-api", '[data-toggle^="button"]', function(e) {
            t(e.target).closest(".btn").toggleClass("focus", /^focus(in)?$/.test(e.type))
        })
    }(jQuery), function(t) {
        "use strict";

        function e(e) {
            return this.each(function() {
                var n = t(this),
                    s = n.data("bs.carousel"),
                    o = t.extend({}, i.DEFAULTS, n.data(), "object" == typeof e && e),
                    r = "string" == typeof e ? e : o.slide;
                s || n.data("bs.carousel", s = new i(this, o)), "number" == typeof e ? s.to(e) : r ? s[r]() : o.interval && s.pause().cycle()
            })
        }
        var i = function(e, i) {
            this.$element = t(e), this.$indicators = this.$element.find(".carousel-indicators"), this.options = i, this.paused = null, this.sliding = null, this.interval = null, this.$active = null, this.$items = null, this.options.keyboard && this.$element.on("keydown.bs.carousel", t.proxy(this.keydown, this)), "hover" == this.options.pause && !("ontouchstart" in document.documentElement) && this.$element.on("mouseenter.bs.carousel", t.proxy(this.pause, this)).on("mouseleave.bs.carousel", t.proxy(this.cycle, this))
        };
        i.VERSION = "3.3.7", i.TRANSITION_DURATION = 600, i.DEFAULTS = {
            interval: 5e3,
            pause: "hover",
            wrap: !0,
            keyboard: !0
        }, i.prototype.keydown = function(t) {
            if (!/input|textarea/i.test(t.target.tagName)) {
                switch (t.which) {
                    case 37:
                        this.prev();
                        break;
                    case 39:
                        this.next();
                        break;
                    default:
                        return
                }
                t.preventDefault()
            }
        }, i.prototype.cycle = function(e) {
            return e || (this.paused = !1), this.interval && clearInterval(this.interval), this.options.interval && !this.paused && (this.interval = setInterval(t.proxy(this.next, this), this.options.interval)), this
        }, i.prototype.getItemIndex = function(t) {
            return this.$items = t.parent().children(".item"), this.$items.index(t || this.$active)
        }, i.prototype.getItemForDirection = function(t, e) {
            var i = this.getItemIndex(e);
            if (("prev" == t && 0 === i || "next" == t && i == this.$items.length - 1) && !this.options.wrap) return e;
            var n = "prev" == t ? -1 : 1,
                s = (i + n) % this.$items.length;
            return this.$items.eq(s)
        }, i.prototype.to = function(t) {
            var e = this,
                i = this.getItemIndex(this.$active = this.$element.find(".item.active"));
            if (!(t > this.$items.length - 1 || t < 0)) return this.sliding ? this.$element.one("slid.bs.carousel", function() {
                e.to(t)
            }) : i == t ? this.pause().cycle() : this.slide(t > i ? "next" : "prev", this.$items.eq(t))
        }, i.prototype.pause = function(e) {
            return e || (this.paused = !0), this.$element.find(".next, .prev").length && t.support.transition && (this.$element.trigger(t.support.transition.end), this.cycle(!0)), this.interval = clearInterval(this.interval), this
        }, i.prototype.next = function() {
            if (!this.sliding) return this.slide("next")
        }, i.prototype.prev = function() {
            if (!this.sliding) return this.slide("prev")
        }, i.prototype.slide = function(e, n) {
            var s = this.$element.find(".item.active"),
                o = n || this.getItemForDirection(e, s),
                r = this.interval,
                a = "next" == e ? "left" : "right",
                l = this;
            if (o.hasClass("active")) return this.sliding = !1;
            var h = o[0],
                c = t.Event("slide.bs.carousel", {
                    relatedTarget: h,
                    direction: a
                });
            if (this.$element.trigger(c), !c.isDefaultPrevented()) {
                if (this.sliding = !0, r && this.pause(), this.$indicators.length) {
                    this.$indicators.find(".active").removeClass("active");
                    var u = t(this.$indicators.children()[this.getItemIndex(o)]);
                    u && u.addClass("active")
                }
                var d = t.Event("slid.bs.carousel", {
                    relatedTarget: h,
                    direction: a
                });
                return t.support.transition && this.$element.hasClass("slide") ? (o.addClass(e), o[0].offsetWidth, s.addClass(a), o.addClass(a), s.one("bsTransitionEnd", function() {
                    o.removeClass([e, a].join(" ")).addClass("active"), s.removeClass(["active", a].join(" ")), l.sliding = !1, setTimeout(function() {
                        l.$element.trigger(d)
                    }, 0)
                }).emulateTransitionEnd(i.TRANSITION_DURATION)) : (s.removeClass("active"), o.addClass("active"), this.sliding = !1, this.$element.trigger(d)), r && this.cycle(), this
            }
        };
        var n = t.fn.carousel;
        t.fn.carousel = e, t.fn.carousel.Constructor = i, t.fn.carousel.noConflict = function() {
            return t.fn.carousel = n, this
        };
        var s = function(i) {
            var n, s = t(this),
                o = t(s.attr("data-target") || (n = s.attr("href")) && n.replace(/.*(?=#[^\s]+$)/, ""));
            if (o.hasClass("carousel")) {
                var r = t.extend({}, o.data(), s.data()),
                    a = s.attr("data-slide-to");
                a && (r.interval = !1), e.call(o, r), a && o.data("bs.carousel").to(a), i.preventDefault()
            }
        };
        t(document).on("click.bs.carousel.data-api", "[data-slide]", s).on("click.bs.carousel.data-api", "[data-slide-to]", s), t(window).on("load", function() {
            t('[data-ride="carousel"]').each(function() {
                var i = t(this);
                e.call(i, i.data())
            })
        })
    }(jQuery), function(t) {
        "use strict";

        function e(e) {
            var i, n = e.attr("data-target") || (i = e.attr("href")) && i.replace(/.*(?=#[^\s]+$)/, "");
            return t(n)
        }

        function i(e) {
            return this.each(function() {
                var i = t(this),
                    s = i.data("bs.collapse"),
                    o = t.extend({}, n.DEFAULTS, i.data(), "object" == typeof e && e);
                !s && o.toggle && /show|hide/.test(e) && (o.toggle = !1), s || i.data("bs.collapse", s = new n(this, o)), "string" == typeof e && s[e]()
            })
        }
        var n = function(e, i) {
            this.$element = t(e), this.options = t.extend({}, n.DEFAULTS, i), this.$trigger = t('[data-toggle="collapse"][href="#' + e.id + '"],[data-toggle="collapse"][data-target="#' + e.id + '"]'), this.transitioning = null, this.options.parent ? this.$parent = this.getParent() : this.addAriaAndCollapsedClass(this.$element, this.$trigger), this.options.toggle && this.toggle()
        };
        n.VERSION = "3.3.7", n.TRANSITION_DURATION = 350, n.DEFAULTS = {
            toggle: !0
        }, n.prototype.dimension = function() {
            return this.$element.hasClass("width") ? "width" : "height"
        }, n.prototype.show = function() {
            if (!this.transitioning && !this.$element.hasClass("in")) {
                var e, s = this.$parent && this.$parent.children(".panel").children(".in, .collapsing");
                if (!(s && s.length && (e = s.data("bs.collapse")) && e.transitioning)) {
                    var o = t.Event("show.bs.collapse");
                    if (this.$element.trigger(o), !o.isDefaultPrevented()) {
                        s && s.length && (i.call(s, "hide"), e || s.data("bs.collapse", null));
                        var r = this.dimension();
                        this.$element.removeClass("collapse").addClass("collapsing")[r](0).attr("aria-expanded", !0), this.$trigger.removeClass("collapsed").attr("aria-expanded", !0), this.transitioning = 1;
                        var a = function() {
                            this.$element.removeClass("collapsing").addClass("collapse in")[r](""), this.transitioning = 0, this.$element.trigger("shown.bs.collapse")
                        };
                        if (!t.support.transition) return a.call(this);
                        var l = t.camelCase(["scroll", r].join("-"));
                        this.$element.one("bsTransitionEnd", t.proxy(a, this)).emulateTransitionEnd(n.TRANSITION_DURATION)[r](this.$element[0][l])
                    }
                }
            }
        }, n.prototype.hide = function() {
            if (!this.transitioning && this.$element.hasClass("in")) {
                var e = t.Event("hide.bs.collapse");
                if (this.$element.trigger(e), !e.isDefaultPrevented()) {
                    var i = this.dimension();
                    this.$element[i](this.$element[i]())[0].offsetHeight, this.$element.addClass("collapsing").removeClass("collapse in").attr("aria-expanded", !1), this.$trigger.addClass("collapsed").attr("aria-expanded", !1), this.transitioning = 1;
                    var s = function() {
                        this.transitioning = 0, this.$element.removeClass("collapsing").addClass("collapse").trigger("hidden.bs.collapse")
                    };
                    return t.support.transition ? void this.$element[i](0).one("bsTransitionEnd", t.proxy(s, this)).emulateTransitionEnd(n.TRANSITION_DURATION) : s.call(this)
                }
            }
        }, n.prototype.toggle = function() {
            this[this.$element.hasClass("in") ? "hide" : "show"]()
        }, n.prototype.getParent = function() {
            return t(this.options.parent).find('[data-toggle="collapse"][data-parent="' + this.options.parent + '"]').each(t.proxy(function(i, n) {
                var s = t(n);
                this.addAriaAndCollapsedClass(e(s), s)
            }, this)).end()
        }, n.prototype.addAriaAndCollapsedClass = function(t, e) {
            var i = t.hasClass("in");
            t.attr("aria-expanded", i), e.toggleClass("collapsed", !i).attr("aria-expanded", i)
        };
        var s = t.fn.collapse;
        t.fn.collapse = i, t.fn.collapse.Constructor = n, t.fn.collapse.noConflict = function() {
            return t.fn.collapse = s, this
        }, t(document).on("click.bs.collapse.data-api", '[data-toggle="collapse"]', function(n) {
            var s = t(this);
            s.attr("data-target") || n.preventDefault();
            var o = e(s),
                r = o.data("bs.collapse"),
                a = r ? "toggle" : s.data();
            i.call(o, a)
        })
    }(jQuery), function(t) {
        "use strict";

        function e(e) {
            var i = e.attr("data-target");
            i || (i = e.attr("href"), i = i && /#[A-Za-z]/.test(i) && i.replace(/.*(?=#[^\s]*$)/, ""));
            var n = i && t(i);
            return n && n.length ? n : e.parent()
        }

        function i(i) {
            i && 3 === i.which || (t(s).remove(), t(o).each(function() {
                var n = t(this),
                    s = e(n),
                    o = {
                        relatedTarget: this
                    };
                s.hasClass("open") && (i && "click" == i.type && /input|textarea/i.test(i.target.tagName) && t.contains(s[0], i.target) || (s.trigger(i = t.Event("hide.bs.dropdown", o)), i.isDefaultPrevented() || (n.attr("aria-expanded", "false"), s.removeClass("open").trigger(t.Event("hidden.bs.dropdown", o)))))
            }))
        }

        function n(e) {
            return this.each(function() {
                var i = t(this),
                    n = i.data("bs.dropdown");
                n || i.data("bs.dropdown", n = new r(this)), "string" == typeof e && n[e].call(i)
            })
        }
        var s = ".dropdown-backdrop",
            o = '[data-toggle="dropdown"]',
            r = function(e) {
                t(e).on("click.bs.dropdown", this.toggle)
            };
        r.VERSION = "3.3.7", r.prototype.toggle = function(n) {
            var s = t(this);
            if (!s.is(".disabled, :disabled")) {
                var o = e(s),
                    r = o.hasClass("open");
                if (i(), !r) {
                    "ontouchstart" in document.documentElement && !o.closest(".navbar-nav").length && t(document.createElement("div")).addClass("dropdown-backdrop").insertAfter(t(this)).on("click", i);
                    var a = {
                        relatedTarget: this
                    };
                    if (o.trigger(n = t.Event("show.bs.dropdown", a)), n.isDefaultPrevented()) return;
                    s.trigger("focus").attr("aria-expanded", "true"), o.toggleClass("open").trigger(t.Event("shown.bs.dropdown", a))
                }
                return !1
            }
        }, r.prototype.keydown = function(i) {
            if (/(38|40|27|32)/.test(i.which) && !/input|textarea/i.test(i.target.tagName)) {
                var n = t(this);
                if (i.preventDefault(), i.stopPropagation(), !n.is(".disabled, :disabled")) {
                    var s = e(n),
                        r = s.hasClass("open");
                    if (!r && 27 != i.which || r && 27 == i.which) return 27 == i.which && s.find(o).trigger("focus"), n.trigger("click");
                    var a = s.find(".dropdown-menu li:not(.disabled):visible a");
                    if (a.length) {
                        var l = a.index(i.target);
                        38 == i.which && l > 0 && l--, 40 == i.which && l < a.length - 1 && l++, ~l || (l = 0), a.eq(l).trigger("focus")
                    }
                }
            }
        };
        var a = t.fn.dropdown;
        t.fn.dropdown = n, t.fn.dropdown.Constructor = r, t.fn.dropdown.noConflict = function() {
            return t.fn.dropdown = a, this
        }, t(document).on("click.bs.dropdown.data-api", i).on("click.bs.dropdown.data-api", ".dropdown form", function(t) {
            t.stopPropagation()
        }).on("click.bs.dropdown.data-api", o, r.prototype.toggle).on("keydown.bs.dropdown.data-api", o, r.prototype.keydown).on("keydown.bs.dropdown.data-api", ".dropdown-menu", r.prototype.keydown)
    }(jQuery), function(t) {
        "use strict";

        function e(e, n) {
            return this.each(function() {
                var s = t(this),
                    o = s.data("bs.modal"),
                    r = t.extend({}, i.DEFAULTS, s.data(), "object" == typeof e && e);
                o || s.data("bs.modal", o = new i(this, r)), "string" == typeof e ? o[e](n) : r.show && o.show(n)
            })
        }
        var i = function(e, i) {
            this.options = i, this.$body = t(document.body), this.$element = t(e), this.$dialog = this.$element.find(".modal-dialog"), this.$backdrop = null, this.isShown = null, this.originalBodyPad = null, this.scrollbarWidth = 0, this.ignoreBackdropClick = !1, this.options.remote && this.$element.find(".modal-content").load(this.options.remote, t.proxy(function() {
                this.$element.trigger("loaded.bs.modal")
            }, this))
        };
        i.VERSION = "3.3.7", i.TRANSITION_DURATION = 300, i.BACKDROP_TRANSITION_DURATION = 150, i.DEFAULTS = {
            backdrop: !0,
            keyboard: !0,
            show: !0
        }, i.prototype.toggle = function(t) {
            return this.isShown ? this.hide() : this.show(t)
        }, i.prototype.show = function(e) {
            var n = this,
                s = t.Event("show.bs.modal", {
                    relatedTarget: e
                });
            this.$element.trigger(s), this.isShown || s.isDefaultPrevented() || (this.isShown = !0, this.checkScrollbar(), this.setScrollbar(), this.$body.addClass("modal-open"), this.escape(), this.resize(), this.$element.on("click.dismiss.bs.modal", '[data-dismiss="modal"]', t.proxy(this.hide, this)), this.$dialog.on("mousedown.dismiss.bs.modal", function() {
                n.$element.one("mouseup.dismiss.bs.modal", function(e) {
                    t(e.target).is(n.$element) && (n.ignoreBackdropClick = !0)
                })
            }), this.backdrop(function() {
                var s = t.support.transition && n.$element.hasClass("fade");
                n.$element.parent().length || n.$element.appendTo(n.$body), n.$element.show().scrollTop(0), n.adjustDialog(), s && n.$element[0].offsetWidth, n.$element.addClass("in"), n.enforceFocus();
                var o = t.Event("shown.bs.modal", {
                    relatedTarget: e
                });
                s ? n.$dialog.one("bsTransitionEnd", function() {
                    n.$element.trigger("focus").trigger(o)
                }).emulateTransitionEnd(i.TRANSITION_DURATION) : n.$element.trigger("focus").trigger(o)
            }))
        }, i.prototype.hide = function(e) {
            e && e.preventDefault(), e = t.Event("hide.bs.modal"), this.$element.trigger(e), this.isShown && !e.isDefaultPrevented() && (this.isShown = !1, this.escape(), this.resize(), t(document).off("focusin.bs.modal"), this.$element.removeClass("in").off("click.dismiss.bs.modal").off("mouseup.dismiss.bs.modal"), this.$dialog.off("mousedown.dismiss.bs.modal"), t.support.transition && this.$element.hasClass("fade") ? this.$element.one("bsTransitionEnd", t.proxy(this.hideModal, this)).emulateTransitionEnd(i.TRANSITION_DURATION) : this.hideModal())
        }, i.prototype.enforceFocus = function() {
            t(document).off("focusin.bs.modal").on("focusin.bs.modal", t.proxy(function(t) {
                document === t.target || this.$element[0] === t.target || this.$element.has(t.target).length || this.$element.trigger("focus")
            }, this))
        }, i.prototype.escape = function() {
            this.isShown && this.options.keyboard ? this.$element.on("keydown.dismiss.bs.modal", t.proxy(function(t) {
                27 == t.which && this.hide()
            }, this)) : this.isShown || this.$element.off("keydown.dismiss.bs.modal")
        }, i.prototype.resize = function() {
            this.isShown ? t(window).on("resize.bs.modal", t.proxy(this.handleUpdate, this)) : t(window).off("resize.bs.modal")
        }, i.prototype.hideModal = function() {
            var t = this;
            this.$element.hide(), this.backdrop(function() {
                t.$body.removeClass("modal-open"), t.resetAdjustments(), t.resetScrollbar(), t.$element.trigger("hidden.bs.modal")
            })
        }, i.prototype.removeBackdrop = function() {
            this.$backdrop && this.$backdrop.remove(), this.$backdrop = null
        }, i.prototype.backdrop = function(e) {
            var n = this,
                s = this.$element.hasClass("fade") ? "fade" : "";
            if (this.isShown && this.options.backdrop) {
                var o = t.support.transition && s;
                if (this.$backdrop = t(document.createElement("div")).addClass("modal-backdrop " + s).appendTo(this.$body), this.$element.on("click.dismiss.bs.modal", t.proxy(function(t) {
                        return this.ignoreBackdropClick ? void(this.ignoreBackdropClick = !1) : void(t.target === t.currentTarget && ("static" == this.options.backdrop ? this.$element[0].focus() : this.hide()))
                    }, this)), o && this.$backdrop[0].offsetWidth, this.$backdrop.addClass("in"), !e) return;
                o ? this.$backdrop.one("bsTransitionEnd", e).emulateTransitionEnd(i.BACKDROP_TRANSITION_DURATION) : e()
            } else if (!this.isShown && this.$backdrop) {
                this.$backdrop.removeClass("in");
                var r = function() {
                    n.removeBackdrop(), e && e()
                };
                t.support.transition && this.$element.hasClass("fade") ? this.$backdrop.one("bsTransitionEnd", r).emulateTransitionEnd(i.BACKDROP_TRANSITION_DURATION) : r()
            } else e && e()
        }, i.prototype.handleUpdate = function() {
            this.adjustDialog()
        }, i.prototype.adjustDialog = function() {
            var t = this.$element[0].scrollHeight > document.documentElement.clientHeight;
            this.$element.css({
                paddingLeft: !this.bodyIsOverflowing && t ? this.scrollbarWidth : "",
                paddingRight: this.bodyIsOverflowing && !t ? this.scrollbarWidth : ""
            })
        }, i.prototype.resetAdjustments = function() {
            this.$element.css({
                paddingLeft: "",
                paddingRight: ""
            })
        }, i.prototype.checkScrollbar = function() {
            var t = window.innerWidth;
            if (!t) {
                var e = document.documentElement.getBoundingClientRect();
                t = e.right - Math.abs(e.left)
            }
            this.bodyIsOverflowing = document.body.clientWidth < t, this.scrollbarWidth = this.measureScrollbar()
        }, 
        // i.prototype.setScrollbar = function() {
        //     var t = parseInt(this.$body.css("padding-right") || 0, 10);
        //     this.originalBodyPad = document.body.style.paddingRight || "", this.bodyIsOverflowing && this.$body.css("padding-right", t + this.scrollbarWidth)
        // }, 
        // i.prototype.resetScrollbar = function() {
        //     this.$body.css("padding-right", this.originalBodyPad)
        // }, 
        i.prototype.measureScrollbar = function() {
            var t = document.createElement("div");
            t.className = "modal-scrollbar-measure", this.$body.append(t);
            var e = t.offsetWidth - t.clientWidth;
            return this.$body[0].removeChild(t), e
        };
        var n = t.fn.modal;
        t.fn.modal = e, t.fn.modal.Constructor = i, t.fn.modal.noConflict = function() {
            return t.fn.modal = n, this
        }, t(document).on("click.bs.modal.data-api", '[data-toggle="modal"]', function(i) {
            var n = t(this),
                s = n.attr("href"),
                o = t(n.attr("data-target") || s && s.replace(/.*(?=#[^\s]+$)/, "")),
                r = o.data("bs.modal") ? "toggle" : t.extend({
                    remote: !/#/.test(s) && s
                }, o.data(), n.data());
            n.is("a") && i.preventDefault(), o.one("show.bs.modal", function(t) {
                t.isDefaultPrevented() || o.one("hidden.bs.modal", function() {
                    n.is(":visible") && n.trigger("focus")
                })
            }), e.call(o, r, this)
        })
    }(jQuery), function(t) {
        "use strict";

        function e(e) {
            return this.each(function() {
                var n = t(this),
                    s = n.data("bs.tooltip"),
                    o = "object" == typeof e && e;
                !s && /destroy|hide/.test(e) || (s || n.data("bs.tooltip", s = new i(this, o)), "string" == typeof e && s[e]())
            })
        }
        var i = function(t, e) {
            this.type = null, this.options = null, this.enabled = null, this.timeout = null, this.hoverState = null, this.$element = null, this.inState = null, this.init("tooltip", t, e)
        };
        i.VERSION = "3.3.7", i.TRANSITION_DURATION = 150, i.DEFAULTS = {
            animation: !0,
            placement: "top",
            selector: !1,
            template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',
            trigger: "hover focus",
            title: "",
            delay: 0,
            html: !1,
            container: !1,
            viewport: {
                selector: "body",
                padding: 0
            }
        }, i.prototype.init = function(e, i, n) {
            if (this.enabled = !0, this.type = e, this.$element = t(i), this.options = this.getOptions(n), this.$viewport = this.options.viewport && t(t.isFunction(this.options.viewport) ? this.options.viewport.call(this, this.$element) : this.options.viewport.selector || this.options.viewport), this.inState = {
                    click: !1,
                    hover: !1,
                    focus: !1
                }, this.$element[0] instanceof document.constructor && !this.options.selector) throw new Error("`selector` option must be specified when initializing " + this.type + " on the window.document object!");
            for (var s = this.options.trigger.split(" "), o = s.length; o--;) {
                var r = s[o];
                if ("click" == r) this.$element.on("click." + this.type, this.options.selector, t.proxy(this.toggle, this));
                else if ("manual" != r) {
                    var a = "hover" == r ? "mouseenter" : "focusin",
                        l = "hover" == r ? "mouseleave" : "focusout";
                    this.$element.on(a + "." + this.type, this.options.selector, t.proxy(this.enter, this)), this.$element.on(l + "." + this.type, this.options.selector, t.proxy(this.leave, this))
                }
            }
            this.options.selector ? this._options = t.extend({}, this.options, {
                trigger: "manual",
                selector: ""
            }) : this.fixTitle()
        }, i.prototype.getDefaults = function() {
            return i.DEFAULTS
        }, i.prototype.getOptions = function(e) {
            return e = t.extend({}, this.getDefaults(), this.$element.data(), e), e.delay && "number" == typeof e.delay && (e.delay = {
                show: e.delay,
                hide: e.delay
            }), e
        }, i.prototype.getDelegateOptions = function() {
            var e = {},
                i = this.getDefaults();
            return this._options && t.each(this._options, function(t, n) {
                i[t] != n && (e[t] = n)
            }), e
        }, i.prototype.enter = function(e) {
            var i = e instanceof this.constructor ? e : t(e.currentTarget).data("bs." + this.type);
            return i || (i = new this.constructor(e.currentTarget, this.getDelegateOptions()), t(e.currentTarget).data("bs." + this.type, i)), e instanceof t.Event && (i.inState["focusin" == e.type ? "focus" : "hover"] = !0), i.tip().hasClass("in") || "in" == i.hoverState ? void(i.hoverState = "in") : (clearTimeout(i.timeout), i.hoverState = "in", i.options.delay && i.options.delay.show ? void(i.timeout = setTimeout(function() {
                "in" == i.hoverState && i.show()
            }, i.options.delay.show)) : i.show())
        }, i.prototype.isInStateTrue = function() {
            for (var t in this.inState)
                if (this.inState[t]) return !0;
            return !1
        }, i.prototype.leave = function(e) {
            var i = e instanceof this.constructor ? e : t(e.currentTarget).data("bs." + this.type);
            if (i || (i = new this.constructor(e.currentTarget, this.getDelegateOptions()), t(e.currentTarget).data("bs." + this.type, i)), e instanceof t.Event && (i.inState["focusout" == e.type ? "focus" : "hover"] = !1), !i.isInStateTrue()) return clearTimeout(i.timeout), i.hoverState = "out", i.options.delay && i.options.delay.hide ? void(i.timeout = setTimeout(function() {
                "out" == i.hoverState && i.hide()
            }, i.options.delay.hide)) : i.hide()
        }, i.prototype.show = function() {
            var e = t.Event("show.bs." + this.type);
            if (this.hasContent() && this.enabled) {
                this.$element.trigger(e);
                var n = t.contains(this.$element[0].ownerDocument.documentElement, this.$element[0]);
                if (e.isDefaultPrevented() || !n) return;
                var s = this,
                    o = this.tip(),
                    r = this.getUID(this.type);
                this.setContent(), o.attr("id", r), this.$element.attr("aria-describedby", r), this.options.animation && o.addClass("fade");
                var a = "function" == typeof this.options.placement ? this.options.placement.call(this, o[0], this.$element[0]) : this.options.placement,
                    l = /\s?auto?\s?/i,
                    h = l.test(a);
                h && (a = a.replace(l, "") || "top"), o.detach().css({
                    top: 0,
                    left: 0,
                    display: "block"
                }).addClass(a).data("bs." + this.type, this), this.options.container ? o.appendTo(this.options.container) : o.insertAfter(this.$element), this.$element.trigger("inserted.bs." + this.type);
                var c = this.getPosition(),
                    u = o[0].offsetWidth,
                    d = o[0].offsetHeight;
                if (h) {
                    var p = a,
                        f = this.getPosition(this.$viewport);
                    a = "bottom" == a && c.bottom + d > f.bottom ? "top" : "top" == a && c.top - d < f.top ? "bottom" : "right" == a && c.right + u > f.width ? "left" : "left" == a && c.left - u < f.left ? "right" : a, o.removeClass(p).addClass(a)
                }
                var g = this.getCalculatedOffset(a, c, u, d);
                this.applyPlacement(g, a);
                var m = function() {
                    var t = s.hoverState;
                    s.$element.trigger("shown.bs." + s.type), s.hoverState = null, "out" == t && s.leave(s)
                };
                t.support.transition && this.$tip.hasClass("fade") ? o.one("bsTransitionEnd", m).emulateTransitionEnd(i.TRANSITION_DURATION) : m()
            }
        }, i.prototype.applyPlacement = function(e, i) {
            var n = this.tip(),
                s = n[0].offsetWidth,
                o = n[0].offsetHeight,
                r = parseInt(n.css("margin-top"), 10),
                a = parseInt(n.css("margin-left"), 10);
            isNaN(r) && (r = 0), isNaN(a) && (a = 0), e.top += r, e.left += a, t.offset.setOffset(n[0], t.extend({
                using: function(t) {
                    n.css({
                        top: Math.round(t.top),
                        left: Math.round(t.left)
                    })
                }
            }, e), 0), n.addClass("in");
            var l = n[0].offsetWidth,
                h = n[0].offsetHeight;
            "top" == i && h != o && (e.top = e.top + o - h);
            var c = this.getViewportAdjustedDelta(i, e, l, h);
            c.left ? e.left += c.left : e.top += c.top;
            var u = /top|bottom/.test(i),
                d = u ? 2 * c.left - s + l : 2 * c.top - o + h,
                p = u ? "offsetWidth" : "offsetHeight";
            n.offset(e), this.replaceArrow(d, n[0][p], u)
        }, i.prototype.replaceArrow = function(t, e, i) {
            this.arrow().css(i ? "left" : "top", 50 * (1 - t / e) + "%").css(i ? "top" : "left", "")
        }, i.prototype.setContent = function() {
            var t = this.tip(),
                e = this.getTitle();
            t.find(".tooltip-inner")[this.options.html ? "html" : "text"](e), t.removeClass("fade in top bottom left right")
        }, i.prototype.hide = function(e) {
            function n() {
                "in" != s.hoverState && o.detach(), s.$element && s.$element.removeAttr("aria-describedby").trigger("hidden.bs." + s.type), e && e()
            }
            var s = this,
                o = t(this.$tip),
                r = t.Event("hide.bs." + this.type);
            if (this.$element.trigger(r), !r.isDefaultPrevented()) return o.removeClass("in"), t.support.transition && o.hasClass("fade") ? o.one("bsTransitionEnd", n).emulateTransitionEnd(i.TRANSITION_DURATION) : n(), this.hoverState = null, this
        }, i.prototype.fixTitle = function() {
            var t = this.$element;
            (t.attr("title") || "string" != typeof t.attr("data-original-title")) && t.attr("data-original-title", t.attr("title") || "").attr("title", "")
        }, i.prototype.hasContent = function() {
            return this.getTitle()
        }, i.prototype.getPosition = function(e) {
            e = e || this.$element;
            var i = e[0],
                n = "BODY" == i.tagName,
                s = i.getBoundingClientRect();
            null == s.width && (s = t.extend({}, s, {
                width: s.right - s.left,
                height: s.bottom - s.top
            }));
            var o = window.SVGElement && i instanceof window.SVGElement,
                r = n ? {
                    top: 0,
                    left: 0
                } : o ? null : e.offset(),
                a = {
                    scroll: n ? document.documentElement.scrollTop || document.body.scrollTop : e.scrollTop()
                },
                l = n ? {
                    width: t(window).width(),
                    height: t(window).height()
                } : null;
            return t.extend({}, s, a, l, r)
        }, i.prototype.getCalculatedOffset = function(t, e, i, n) {
            return "bottom" == t ? {
                top: e.top + e.height,
                left: e.left + e.width / 2 - i / 2
            } : "top" == t ? {
                top: e.top - n,
                left: e.left + e.width / 2 - i / 2
            } : "left" == t ? {
                top: e.top + e.height / 2 - n / 2,
                left: e.left - i
            } : {
                top: e.top + e.height / 2 - n / 2,
                left: e.left + e.width
            }
        }, i.prototype.getViewportAdjustedDelta = function(t, e, i, n) {
            var s = {
                top: 0,
                left: 0
            };
            if (!this.$viewport) return s;
            var o = this.options.viewport && this.options.viewport.padding || 0,
                r = this.getPosition(this.$viewport);
            if (/right|left/.test(t)) {
                var a = e.top - o - r.scroll,
                    l = e.top + o - r.scroll + n;
                a < r.top ? s.top = r.top - a : l > r.top + r.height && (s.top = r.top + r.height - l)
            } else {
                var h = e.left - o,
                    c = e.left + o + i;
                h < r.left ? s.left = r.left - h : c > r.right && (s.left = r.left + r.width - c)
            }
            return s
        }, i.prototype.getTitle = function() {
            var t = this.$element,
                e = this.options;
            return t.attr("data-original-title") || ("function" == typeof e.title ? e.title.call(t[0]) : e.title)
        }, i.prototype.getUID = function(t) {
            do {
                t += ~~(1e6 * Math.random())
            } while (document.getElementById(t));
            return t
        }, i.prototype.tip = function() {
            if (!this.$tip && (this.$tip = t(this.options.template), 1 != this.$tip.length)) throw new Error(this.type + " `template` option must consist of exactly 1 top-level element!");
            return this.$tip
        }, i.prototype.arrow = function() {
            return this.$arrow = this.$arrow || this.tip().find(".tooltip-arrow")
        }, i.prototype.enable = function() {
            this.enabled = !0
        }, i.prototype.disable = function() {
            this.enabled = !1
        }, i.prototype.toggleEnabled = function() {
            this.enabled = !this.enabled
        }, i.prototype.toggle = function(e) {
            var i = this;
            e && ((i = t(e.currentTarget).data("bs." + this.type)) || (i = new this.constructor(e.currentTarget, this.getDelegateOptions()), t(e.currentTarget).data("bs." + this.type, i))), e ? (i.inState.click = !i.inState.click, i.isInStateTrue() ? i.enter(i) : i.leave(i)) : i.tip().hasClass("in") ? i.leave(i) : i.enter(i)
        }, i.prototype.destroy = function() {
            var t = this;
            clearTimeout(this.timeout), this.hide(function() {
                t.$element.off("." + t.type).removeData("bs." + t.type), t.$tip && t.$tip.detach(), t.$tip = null, t.$arrow = null, t.$viewport = null, t.$element = null
            })
        };
        var n = t.fn.tooltip;
        t.fn.tooltip = e, t.fn.tooltip.Constructor = i, t.fn.tooltip.noConflict = function() {
            return t.fn.tooltip = n, this
        }
    }(jQuery), function(t) {
        "use strict";

        function e(e) {
            return this.each(function() {
                var n = t(this),
                    s = n.data("bs.popover"),
                    o = "object" == typeof e && e;
                !s && /destroy|hide/.test(e) || (s || n.data("bs.popover", s = new i(this, o)), "string" == typeof e && s[e]())
            })
        }
        var i = function(t, e) {
            this.init("popover", t, e)
        };
        if (!t.fn.tooltip) throw new Error("Popover requires tooltip.js");
        i.VERSION = "3.3.7", i.DEFAULTS = t.extend({}, t.fn.tooltip.Constructor.DEFAULTS, {
            placement: "right",
            trigger: "click",
            content: "",
            template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
        }), i.prototype = t.extend({}, t.fn.tooltip.Constructor.prototype), i.prototype.constructor = i, i.prototype.getDefaults = function() {
            return i.DEFAULTS
        }, i.prototype.setContent = function() {
            var t = this.tip(),
                e = this.getTitle(),
                i = this.getContent();
            t.find(".popover-title")[this.options.html ? "html" : "text"](e), t.find(".popover-content").children().detach().end()[this.options.html ? "string" == typeof i ? "html" : "append" : "text"](i), t.removeClass("fade top bottom left right in"), t.find(".popover-title").html() || t.find(".popover-title").hide()
        }, i.prototype.hasContent = function() {
            return this.getTitle() || this.getContent()
        }, i.prototype.getContent = function() {
            var t = this.$element,
                e = this.options;
            return t.attr("data-content") || ("function" == typeof e.content ? e.content.call(t[0]) : e.content)
        }, i.prototype.arrow = function() {
            return this.$arrow = this.$arrow || this.tip().find(".arrow")
        };
        var n = t.fn.popover;
        t.fn.popover = e, t.fn.popover.Constructor = i, t.fn.popover.noConflict = function() {
            return t.fn.popover = n, this
        }
    }(jQuery), function(t) {
        "use strict";

        function e(i, n) {
            this.$body = t(document.body), this.$scrollElement = t(t(i).is(document.body) ? window : i), this.options = t.extend({}, e.DEFAULTS, n), this.selector = (this.options.target || "") + " .nav li > a", this.offsets = [], this.targets = [], this.activeTarget = null, this.scrollHeight = 0, this.$scrollElement.on("scroll.bs.scrollspy", t.proxy(this.process, this)), this.refresh(), this.process()
        }

        function i(i) {
            return this.each(function() {
                var n = t(this),
                    s = n.data("bs.scrollspy"),
                    o = "object" == typeof i && i;
                s || n.data("bs.scrollspy", s = new e(this, o)), "string" == typeof i && s[i]()
            })
        }
        e.VERSION = "3.3.7", e.DEFAULTS = {
            offset: 10
        }, e.prototype.getScrollHeight = function() {
            return this.$scrollElement[0].scrollHeight || Math.max(this.$body[0].scrollHeight, document.documentElement.scrollHeight)
        }, e.prototype.refresh = function() {
            var e = this,
                i = "offset",
                n = 0;
            this.offsets = [], this.targets = [], this.scrollHeight = this.getScrollHeight(), t.isWindow(this.$scrollElement[0]) || (i = "position", n = this.$scrollElement.scrollTop()), this.$body.find(this.selector).map(function() {
                var e = t(this),
                    s = e.data("target") || e.attr("href"),
                    o = /^#./.test(s) && t(s);
                return o && o.length && o.is(":visible") && [
                    [o[i]().top + n, s]
                ] || null
            }).sort(function(t, e) {
                return t[0] - e[0]
            }).each(function() {
                e.offsets.push(this[0]), e.targets.push(this[1])
            })
        }, e.prototype.process = function() {
            var t, e = this.$scrollElement.scrollTop() + this.options.offset,
                i = this.getScrollHeight(),
                n = this.options.offset + i - this.$scrollElement.height(),
                s = this.offsets,
                o = this.targets,
                r = this.activeTarget;
            if (this.scrollHeight != i && this.refresh(), e >= n) return r != (t = o[o.length - 1]) && this.activate(t);
            if (r && e < s[0]) return this.activeTarget = null, this.clear();
            for (t = s.length; t--;) r != o[t] && e >= s[t] && (void 0 === s[t + 1] || e < s[t + 1]) && this.activate(o[t])
        }, e.prototype.activate = function(e) {
            this.activeTarget = e, this.clear();
            var i = this.selector + '[data-target="' + e + '"],' + this.selector + '[href="' + e + '"]',
                n = t(i).parents("li").addClass("active");
            n.parent(".dropdown-menu").length && (n = n.closest("li.dropdown").addClass("active")), n.trigger("activate.bs.scrollspy")
        }, e.prototype.clear = function() {
            t(this.selector).parentsUntil(this.options.target, ".active").removeClass("active")
        };
        var n = t.fn.scrollspy;
        t.fn.scrollspy = i, t.fn.scrollspy.Constructor = e, t.fn.scrollspy.noConflict = function() {
            return t.fn.scrollspy = n, this
        }, t(window).on("load.bs.scrollspy.data-api", function() {
            t('[data-spy="scroll"]').each(function() {
                var e = t(this);
                i.call(e, e.data())
            })
        })
    }(jQuery), function(t) {
        "use strict";

        function e(e) {
            return this.each(function() {
                var n = t(this),
                    s = n.data("bs.tab");
                s || n.data("bs.tab", s = new i(this)), "string" == typeof e && s[e]()
            })
        }
        var i = function(e) {
            this.element = t(e)
        };
        i.VERSION = "3.3.7", i.TRANSITION_DURATION = 150, i.prototype.show = function() {
            var e = this.element,
                i = e.closest("ul:not(.dropdown-menu)"),
                n = e.data("target");
            if (n || (n = e.attr("href"), n = n && n.replace(/.*(?=#[^\s]*$)/, "")), !e.parent("li").hasClass("active")) {
                var s = i.find(".active:last a"),
                    o = t.Event("hide.bs.tab", {
                        relatedTarget: e[0]
                    }),
                    r = t.Event("show.bs.tab", {
                        relatedTarget: s[0]
                    });
                if (s.trigger(o), e.trigger(r), !r.isDefaultPrevented() && !o.isDefaultPrevented()) {
                    var a = t(n);
                    this.activate(e.closest("li"), i), this.activate(a, a.parent(), function() {
                        s.trigger({
                            type: "hidden.bs.tab",
                            relatedTarget: e[0]
                        }), e.trigger({
                            type: "shown.bs.tab",
                            relatedTarget: s[0]
                        })
                    })
                }
            }
        }, i.prototype.activate = function(e, n, s) {
            function o() {
                r.removeClass("active").find("> .dropdown-menu > .active").removeClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded", !1), e.addClass("active").find('[data-toggle="tab"]').attr("aria-expanded", !0), a ? (e[0].offsetWidth, e.addClass("in")) : e.removeClass("fade"), e.parent(".dropdown-menu").length && e.closest("li.dropdown").addClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded", !0), s && s()
            }
            var r = n.find("> .active"),
                a = s && t.support.transition && (r.length && r.hasClass("fade") || !!n.find("> .fade").length);
            r.length && a ? r.one("bsTransitionEnd", o).emulateTransitionEnd(i.TRANSITION_DURATION) : o(), r.removeClass("in")
        };
        var n = t.fn.tab;
        t.fn.tab = e, t.fn.tab.Constructor = i, t.fn.tab.noConflict = function() {
            return t.fn.tab = n, this
        };
        var s = function(i) {
            i.preventDefault(), e.call(t(this), "show")
        };
        t(document).on("click.bs.tab.data-api", '[data-toggle="tab"]', s).on("click.bs.tab.data-api", '[data-toggle="pill"]', s)
    }(jQuery), function(t) {
        "use strict";

        function e(e) {
            return this.each(function() {
                var n = t(this),
                    s = n.data("bs.affix"),
                    o = "object" == typeof e && e;
                s || n.data("bs.affix", s = new i(this, o)), "string" == typeof e && s[e]()
            })
        }
        var i = function(e, n) {
            this.options = t.extend({}, i.DEFAULTS, n), this.$target = t(this.options.target).on("scroll.bs.affix.data-api", t.proxy(this.checkPosition, this)).on("click.bs.affix.data-api", t.proxy(this.checkPositionWithEventLoop, this)), this.$element = t(e), this.affixed = null, this.unpin = null, this.pinnedOffset = null, this.checkPosition()
        };
        i.VERSION = "3.3.7", i.RESET = "affix affix-top affix-bottom", i.DEFAULTS = {
            offset: 0,
            target: window
        }, i.prototype.getState = function(t, e, i, n) {
            var s = this.$target.scrollTop(),
                o = this.$element.offset(),
                r = this.$target.height();
            if (null != i && "top" == this.affixed) return s < i && "top";
            if ("bottom" == this.affixed) return null != i ? !(s + this.unpin <= o.top) && "bottom" : !(s + r <= t - n) && "bottom";
            var a = null == this.affixed,
                l = a ? s : o.top,
                h = a ? r : e;
            return null != i && s <= i ? "top" : null != n && l + h >= t - n && "bottom"
        }, i.prototype.getPinnedOffset = function() {
            if (this.pinnedOffset) return this.pinnedOffset;
            this.$element.removeClass(i.RESET).addClass("affix");
            var t = this.$target.scrollTop(),
                e = this.$element.offset();
            return this.pinnedOffset = e.top - t
        }, i.prototype.checkPositionWithEventLoop = function() {
            setTimeout(t.proxy(this.checkPosition, this), 1)
        }, i.prototype.checkPosition = function() {
            if (this.$element.is(":visible")) {
                var e = this.$element.height(),
                    n = this.options.offset,
                    s = n.top,
                    o = n.bottom,
                    r = Math.max(t(document).height(), t(document.body).height());
                "object" != typeof n && (o = s = n), "function" == typeof s && (s = n.top(this.$element)), "function" == typeof o && (o = n.bottom(this.$element));
                var a = this.getState(r, e, s, o);
                if (this.affixed != a) {
                    null != this.unpin && this.$element.css("top", "");
                    var l = "affix" + (a ? "-" + a : ""),
                        h = t.Event(l + ".bs.affix");
                    if (this.$element.trigger(h), h.isDefaultPrevented()) return;
                    this.affixed = a, this.unpin = "bottom" == a ? this.getPinnedOffset() : null, this.$element.removeClass(i.RESET).addClass(l).trigger(l.replace("affix", "affixed") + ".bs.affix")
                }
                "bottom" == a && this.$element.offset({
                    top: r - e - o
                })
            }
        };
        var n = t.fn.affix;
        t.fn.affix = e, t.fn.affix.Constructor = i, t.fn.affix.noConflict = function() {
            return t.fn.affix = n, this
        }, t(window).on("load", function() {
            t('[data-spy="affix"]').each(function() {
                var i = t(this),
                    n = i.data();
                n.offset = n.offset || {}, null != n.offsetBottom && (n.offset.bottom = n.offsetBottom), null != n.offsetTop && (n.offset.top = n.offsetTop), e.call(i, n)
            })
        })
    }(jQuery), function(t) {
        var e = -1,
            i = -1,
            n = function(e) {
                var i = null,
                    n = [];
                return t(e).each(function() {
                    var e = t(this),
                        o = e.offset().top - s(e.css("margin-top")),
                        r = 0 < n.length ? n[n.length - 1] : null;
                    null === r ? n.push(e) : 1 >= Math.floor(Math.abs(i - o)) ? n[n.length - 1] = r.add(e) : n.push(e), i = o
                }), n
            },
            s = function(t) {
                return parseFloat(t) || 0
            },
            o = t.fn.matchHeight = function(e) {
                if ("remove" === e) {
                    var i = this;
                    return this.css("height", ""), t.each(o._groups, function(t, e) {
                        e.elements = e.elements.not(i)
                    }), this
                }
                return 1 >= this.length ? this : (e = void 0 === e || e, o._groups.push({
                    elements: this,
                    byRow: e
                }), o._apply(this, e), this)
            };
        o._groups = [], o._throttle = 80, o._maintainScroll = !1, o._beforeUpdate = null, o._afterUpdate = null, o._apply = function(e, i) {
            var r = t(e),
                a = [r],
                l = t(window).scrollTop(),
                h = t("html").outerHeight(!0),
                c = r.parents().filter(":hidden");
            return c.css("display", "block"), i && (r.each(function() {
                var e = t(this),
                    i = "inline-block" === e.css("display") ? "inline-block" : "block";
                e.data("style-cache", e.attr("style")), e.css({
                    display: i,
                    "padding-top": "0",
                    "padding-bottom": "0",
                    "margin-top": "0",
                    "margin-bottom": "0",
                    "border-top-width": "0",
                    "border-bottom-width": "0",
                    height: "100px"
                })
            }), a = n(r), r.each(function() {
                var e = t(this);
                e.attr("style", e.data("style-cache") || "").css("height", "")
            })), t.each(a, function(e, n) {
                var o = t(n),
                    r = 0;
                i && 1 >= o.length || (o.each(function() {
                    var e = t(this),
                        i = "inline-block" === e.css("display") ? "inline-block" : "block";
                    e.css({
                        display: i,
                        height: ""
                    }), e.outerHeight(!1) > r && (r = e.outerHeight(!1)), e.css("display", "")
                }), o.each(function() {
                    var e = t(this),
                        i = 0;
                    "border-box" !== e.css("box-sizing") && (i += s(e.css("border-top-width")) + s(e.css("border-bottom-width")), i += s(e.css("padding-top")) + s(e.css("padding-bottom"))), e.css("height", r - i)
                }))
            }), c.css("display", ""), o._maintainScroll && t(window).scrollTop(l / h * t("html").outerHeight(!0)), this
        }, o._applyDataApi = function() {
            var e = {};
            t("[data-match-height], [data-mh]").each(function() {
                var i = t(this),
                    n = i.attr("data-match-height") || i.attr("data-mh");
                e[n] = n in e ? e[n].add(i) : i
            }), t.each(e, function() {
                this.matchHeight(!0)
            })
        };
        var r = function(e) {
            o._beforeUpdate && o._beforeUpdate(e, o._groups), t.each(o._groups, function() {
                o._apply(this.elements, this.byRow)
            }), o._afterUpdate && o._afterUpdate(e, o._groups)
        };
        o._update = function(n, s) {
            if (s && "resize" === s.type) {
                var a = t(window).width();
                if (a === e) return;
                e = a
            }
            n ? -1 === i && (i = setTimeout(function() {
                r(s), i = -1
            }, o._throttle)) : r(s)
        }, t(o._applyDataApi), t(window).bind("load", function(t) {
            o._update(!1, t)
        }), t(window).bind("resize orientationchange", function(t) {
            o._update(!0, t)
        })
    }(jQuery), function(t, e) {
        "use strict";

        function i(e) {
            e = t.extend({}, m, e || {}), null === p && (p = t("body"));
            for (var i = t(this), s = 0, o = i.length; o > s; s++) n(i.eq(s), e);
            return i
        }

        function n(i, n) {
            if (!i.hasClass(f.base)) {
                n = t.extend({}, n, i.data(d + "-options"));
                var a = "";
                a += '<div class="' + f.bar + '">', a += '<div class="' + f.track + '">', a += '<div class="' + f.handle + '">', a += "</div></div></div>", n.paddingRight = parseInt(i.css("padding-right"), 10), n.paddingBottom = parseInt(i.css("padding-bottom"), 10), i.addClass([f.base, n.customClass].join(" ")).wrapInner('<div class="' + f.content + '" />').prepend(a), n.horizontal && i.addClass(f.isHorizontal);
                var l = t.extend({
                    $scroller: i,
                    $content: i.find(u(f.content)),
                    $bar: i.find(u(f.bar)),
                    $track: i.find(u(f.track)),
                    $handle: i.find(u(f.handle))
                }, n);
                l.trackMargin = parseInt(l.trackMargin, 10), l.$content.on("scroll." + d, l, s), l.$scroller.on(g.start, u(f.track), l, o).on(g.start, u(f.handle), l, r).data(d, l), v.reset.apply(i), t(e).one("load", function() {
                    v.reset.apply(i)
                })
            }
        }

        function s(t) {
            t.preventDefault(), t.stopPropagation();
            var e = t.data,
                i = {};
            if (e.horizontal) {
                var n = e.$content.scrollLeft();
                0 > n && (n = 0);
                var s = n / e.scrollRatio;
                s > e.handleBounds.right && (s = e.handleBounds.right), i = {
                    left: s
                }
            } else {
                var o = e.$content.scrollTop();
                0 > o && (o = 0);
                var r = o / e.scrollRatio;
                r > e.handleBounds.bottom && (r = e.handleBounds.bottom), i = {
                    top: r
                }
            }
            e.$handle.css(i)
        }

        function o(t) {
            t.preventDefault(), t.stopPropagation();
            var e = t.data,
                i = t.originalEvent,
                n = e.$track.offset(),
                s = void 0 !== i.targetTouches ? i.targetTouches[0] : null,
                o = s ? s.pageX : t.clientX,
                r = s ? s.pageY : t.clientY;
            e.horizontal ? (e.mouseStart = o, e.handleLeft = o - n.left - e.handleWidth / 2, c(e, e.handleLeft)) : (e.mouseStart = r, e.handleTop = r - n.top - e.handleHeight / 2, c(e, e.handleTop)), a(e)
        }

        function r(t) {
            t.preventDefault(), t.stopPropagation();
            var e = t.data,
                i = t.originalEvent,
                n = void 0 !== i.targetTouches ? i.targetTouches[0] : null,
                s = n ? n.pageX : t.clientX,
                o = n ? n.pageY : t.clientY;
            e.horizontal ? (e.mouseStart = s, e.handleLeft = parseInt(e.$handle.css("left"), 10)) : (e.mouseStart = o, e.handleTop = parseInt(e.$handle.css("top"), 10)), a(e)
        }

        function a(t) {
            t.$content.off(u(d)), p.on(g.move, t, l).on(g.end, t, h)
        }

        function l(t) {
            t.preventDefault(), t.stopPropagation();
            var e = t.data,
                i = t.originalEvent,
                n = 0,
                s = 0,
                o = void 0 !== i.targetTouches ? i.targetTouches[0] : null,
                r = o ? o.pageX : t.clientX,
                a = o ? o.pageY : t.clientY;
            e.horizontal ? (s = e.mouseStart - r, n = e.handleLeft - s) : (s = e.mouseStart - a, n = e.handleTop - s), c(e, n)
        }

        function h(t) {
            t.preventDefault(), t.stopPropagation();
            var e = t.data;
            e.$content.on("scroll.scroller", e, s), p.off(".scroller")
        }

        function c(t, e) {
            var i = {};
            if (t.horizontal) {
                e < t.handleBounds.left && (e = t.handleBounds.left), e > t.handleBounds.right && (e = t.handleBounds.right);
                var n = Math.round(e * t.scrollRatio);
                i = {
                    left: e
                }, t.$content.scrollLeft(n)
            } else {
                e < t.handleBounds.top && (e = t.handleBounds.top), e > t.handleBounds.bottom && (e = t.handleBounds.bottom);
                var s = Math.round(e * t.scrollRatio);
                i = {
                    top: e
                }, t.$content.scrollTop(s)
            }
            t.$handle.css(i)
        }

        function u(t) {
            return "." + t
        }
        var d = "scroller",
            p = null,
            f = {
                base: "scroller",
                content: "scroller-content",
                bar: "scroller-bar",
                track: "scroller-track",
                handle: "scroller-handle",
                isHorizontal: "scroller-horizontal",
                isSetup: "scroller-setup",
                isActive: "scroller-active"
            },
            g = {
                start: "touchstart." + d + " mousedown." + d,
                move: "touchmove." + d + " mousemove." + d,
                end: "touchend." + d + " mouseup." + d
            },
            m = {
                customClass: "",
                duration: 0,
                handleSize: 0,
                horizontal: !1,
                trackMargin: 0
            },
            v = {
                defaults: function(e) {
                    return m = t.extend(m, e || {}), "object" != typeof this || t(this)
                },
                destroy: function() {
                    return t(this).each(function(e, i) {
                        var n = t(i).data(d);
                        n && (n.$scroller.removeClass([n.customClass, f.base, f.isActive].join(" ")), n.$bar.remove(), n.$content.contents().unwrap(), n.$content.off(u(d)), n.$scroller.off(u(d)).removeData(d))
                    })
                },
                scroll: function(e, i) {
                    return t(this).each(function() {
                        var n = t(this).data(d),
                            s = i || m.duration;
                        if ("number" != typeof e) {
                            var o = t(e);
                            if (o.length > 0) {
                                var r = o.position();
                                e = n.horizontal ? r.left + n.$content.scrollLeft() : r.top + n.$content.scrollTop()
                            } else e = n.$content.scrollTop()
                        }
                        var a = n.horizontal ? {
                            scrollLeft: e
                        } : {
                            scrollTop: e
                        };
                        n.$content.stop().animate(a, s)
                    })
                },
                reset: function() {
                    return t(this).each(function() {
                        var e = t(this).data(d);
                        if (e) {
                            e.$scroller.addClass(f.isSetup);
                            var i = {},
                                n = {},
                                s = {},
                                o = 0,
                                r = !0;
                            if (e.horizontal) {
                                e.barHeight = e.$content[0].offsetHeight - e.$content[0].clientHeight, e.frameWidth = e.$content.outerWidth(), e.trackWidth = e.frameWidth - 2 * e.trackMargin, e.scrollWidth = e.$content[0].scrollWidth, e.ratio = e.trackWidth / e.scrollWidth, e.trackRatio = e.trackWidth / e.scrollWidth, e.handleWidth = e.handleSize > 0 ? e.handleSize : e.trackWidth * e.trackRatio, e.scrollRatio = (e.scrollWidth - e.frameWidth) / (e.trackWidth - e.handleWidth), e.handleBounds = {
                                    left: 0,
                                    right: e.trackWidth - e.handleWidth
                                }, e.$content.css({
                                    paddingBottom: e.barHeight + e.paddingBottom
                                });
                                o = e.$content.scrollLeft() * e.ratio, r = e.scrollWidth <= e.frameWidth, i = {
                                    width: e.frameWidth
                                }, n = {
                                    width: e.trackWidth,
                                    marginLeft: e.trackMargin,
                                    marginRight: e.trackMargin
                                }, s = {
                                    width: e.handleWidth
                                }
                            } else {
                                e.barWidth = e.$content[0].offsetWidth - e.$content[0].clientWidth, e.frameHeight = e.$content.outerHeight(), e.trackHeight = e.frameHeight - 2 * e.trackMargin, e.scrollHeight = e.$content[0].scrollHeight, e.ratio = e.trackHeight / e.scrollHeight, e.trackRatio = e.trackHeight / e.scrollHeight, e.handleHeight = e.handleSize > 0 ? e.handleSize : e.trackHeight * e.trackRatio, e.scrollRatio = (e.scrollHeight - e.frameHeight) / (e.trackHeight - e.handleHeight), e.handleBounds = {
                                    top: 0,
                                    bottom: e.trackHeight - e.handleHeight
                                };
                                o = e.$content.scrollTop() * e.ratio, r = e.scrollHeight <= e.frameHeight, i = {
                                    height: e.frameHeight
                                }, n = {
                                    height: e.trackHeight,
                                    marginBottom: e.trackMargin,
                                    marginTop: e.trackMargin
                                }, s = {
                                    height: e.handleHeight
                                }
                            }
                            r ? e.$scroller.removeClass(f.isActive) : e.$scroller.addClass(f.isActive), e.$bar.css(i), e.$track.css(n), e.$handle.css(s), c(e, o), e.$scroller.removeClass(f.isSetup)
                        }
                    })
                }
            };
        t.fn[d] = function(t) {
            return v[t] ? v[t].apply(this, Array.prototype.slice.call(arguments, 1)) : "object" != typeof t && t ? this : i.apply(this, arguments)
        }, t[d] = function(t) {
            "defaults" === t && v.defaults.apply(this, Array.prototype.slice.call(arguments, 1))
        }
    }(jQuery), function(t) {
        "function" == typeof define && define.amd ? define(["jquery"], t) : t("object" == typeof exports ? require("jquery") : jQuery)
    }(function(t) {
        var e = function() {
                if (t && t.fn && t.fn.select2 && t.fn.select2.amd) var e = t.fn.select2.amd;
                var e;
                return function() {
                        if (!e || !e.requirejs) {
                            e ? i = e : e = {};
                            var t, i, n;
                            ! function(e) {
                                function s(t, e) {
                                    return _.call(t, e)
                                }

                                function o(t, e) {
                                    var i, n, s, o, r, a, l, h, c, u, d, p = e && e.split("/"),
                                        f = y.map,
                                        g = f && f["*"] || {};
                                    if (t && "." === t.charAt(0))
                                        if (e) {
                                            for (t = t.split("/"), r = t.length - 1, y.nodeIdCompat && x.test(t[r]) && (t[r] = t[r].replace(x, "")), t = p.slice(0, p.length - 1).concat(t), c = 0; c < t.length; c += 1)
                                                if ("." === (d = t[c])) t.splice(c, 1), c -= 1;
                                                else if (".." === d) {
                                                if (1 === c && (".." === t[2] || ".." === t[0])) break;
                                                c > 0 && (t.splice(c - 1, 2), c -= 2)
                                            }
                                            t = t.join("/")
                                        } else 0 === t.indexOf("./") && (t = t.substring(2));
                                    if ((p || g) && f) {
                                        for (i = t.split("/"), c = i.length; c > 0; c -= 1) {
                                            if (n = i.slice(0, c).join("/"), p)
                                                for (u = p.length; u > 0; u -= 1)
                                                    if ((s = f[p.slice(0, u).join("/")]) && (s = s[n])) {
                                                        o = s, a = c;
                                                        break
                                                    } if (o) break;
                                            !l && g && g[n] && (l = g[n], h = c)
                                        }!o && l && (o = l, a = h), o && (i.splice(0, a, o), t = i.join("/"))
                                    }
                                    return t
                                }

                                function r(t, i) {
                                    return function() {
                                        var n = w.call(arguments, 0);
                                        return "string" != typeof n[0] && 1 === n.length && n.push(null), p.apply(e, n.concat([t, i]))
                                    }
                                }

                                function a(t) {
                                    return function(e) {
                                        return o(e, t)
                                    }
                                }

                                function l(t) {
                                    return function(e) {
                                        m[t] = e
                                    }
                                }

                                function h(t) {
                                    if (s(v, t)) {
                                        var i = v[t];
                                        delete v[t], b[t] = !0, d.apply(e, i)
                                    }
                                    if (!s(m, t) && !s(b, t)) throw new Error("No " + t);
                                    return m[t]
                                }

                                function c(t) {
                                    var e, i = t ? t.indexOf("!") : -1;
                                    return i > -1 && (e = t.substring(0, i), t = t.substring(i + 1, t.length)), [e, t]
                                }

                                function u(t) {
                                    return function() {
                                        return y && y.config && y.config[t] || {}
                                    }
                                }
                                var d, p, f, g, m = {},
                                    v = {},
                                    y = {},
                                    b = {},
                                    _ = Object.prototype.hasOwnProperty,
                                    w = [].slice,
                                    x = /\.js$/;
                                f = function(t, e) {
                                    var i, n = c(t),
                                        s = n[0];
                                    return t = n[1], s && (s = o(s, e), i = h(s)), s ? t = i && i.normalize ? i.normalize(t, a(e)) : o(t, e) : (t = o(t, e), n = c(t), s = n[0], t = n[1], s && (i = h(s))), {
                                        f: s ? s + "!" + t : t,
                                        n: t,
                                        pr: s,
                                        p: i
                                    }
                                }, g = {
                                    require: function(t) {
                                        return r(t)
                                    },
                                    exports: function(t) {
                                        var e = m[t];
                                        return void 0 !== e ? e : m[t] = {}
                                    },
                                    module: function(t) {
                                        return {
                                            id: t,
                                            uri: "",
                                            exports: m[t],
                                            config: u(t)
                                        }
                                    }
                                }, d = function(t, i, n, o) {
                                    var a, c, u, d, p, y, _ = [],
                                        w = typeof n;
                                    if (o = o || t, "undefined" === w || "function" === w) {
                                        for (i = !i.length && n.length ? ["require", "exports", "module"] : i, p = 0; p < i.length; p += 1)
                                            if (d = f(i[p], o), "require" === (c = d.f)) _[p] = g.require(t);
                                            else if ("exports" === c) _[p] = g.exports(t), y = !0;
                                        else if ("module" === c) a = _[p] = g.module(t);
                                        else if (s(m, c) || s(v, c) || s(b, c)) _[p] = h(c);
                                        else {
                                            if (!d.p) throw new Error(t + " missing " + c);
                                            d.p.load(d.n, r(o, !0), l(c), {}), _[p] = m[c]
                                        }
                                        u = n ? n.apply(m[t], _) : void 0, t && (a && a.exports !== e && a.exports !== m[t] ? m[t] = a.exports : u === e && y || (m[t] = u))
                                    } else t && (m[t] = n)
                                }, t = i = p = function(t, i, n, s, o) {
                                    if ("string" == typeof t) return g[t] ? g[t](i) : h(f(t, i).f);
                                    if (!t.splice) {
                                        if (y = t, y.deps && p(y.deps, y.callback), !i) return;
                                        i.splice ? (t = i, i = n, n = null) : t = e
                                    }
                                    return i = i || function() {}, "function" == typeof n && (n = s, s = o), s ? d(e, t, i, n) : setTimeout(function() {
                                        d(e, t, i, n)
                                    }, 4), p
                                }, p.config = function(t) {
                                    return p(t)
                                }, t._defined = m, n = function(t, e, i) {
                                    if ("string" != typeof t) throw new Error("See almond README: incorrect module build, no module name");
                                    e.splice || (i = e, e = []), s(m, t) || s(v, t) || (v[t] = [t, e, i])
                                }, n.amd = {
                                    jQuery: !0
                                }
                            }(), e.requirejs = t, e.require = i, e.define = n
                        }
                    }(), e.define("almond", function() {}), e.define("jquery", [], function() {
                        var e = t || $;
                        return null == e && console && console.error && console.error("Select2: An instance of jQuery or a jQuery-compatible library was not found. Make sure that you are including jQuery before Select2 on your web page."), e
                    }), e.define("select2/utils", ["jquery"], function(t) {
                        function e(t) {
                            var e = t.prototype,
                                i = [];
                            for (var n in e) {
                                "function" == typeof e[n] && "constructor" !== n && i.push(n)
                            }
                            return i
                        }
                        var i = {};
                        i.Extend = function(t, e) {
                            function i() {
                                this.constructor = t
                            }
                            var n = {}.hasOwnProperty;
                            for (var s in e) n.call(e, s) && (t[s] = e[s]);
                            return i.prototype = e.prototype, t.prototype = new i, t.__super__ = e.prototype, t
                        }, i.Decorate = function(t, i) {
                            function n() {
                                var e = Array.prototype.unshift,
                                    n = i.prototype.constructor.length,
                                    s = t.prototype.constructor;
                                n > 0 && (e.call(arguments, t.prototype.constructor), s = i.prototype.constructor), s.apply(this, arguments)
                            }

                            function s() {
                                this.constructor = n
                            }
                            var o = e(i),
                                r = e(t);
                            i.displayName = t.displayName, n.prototype = new s;
                            for (var a = 0; a < r.length; a++) {
                                var l = r[a];
                                n.prototype[l] = t.prototype[l]
                            }
                            for (var h = 0; h < o.length; h++) {
                                var c = o[h];
                                n.prototype[c] = function(t) {
                                    var e = function() {};
                                    t in n.prototype && (e = n.prototype[t]);
                                    var s = i.prototype[t];
                                    return function() {
                                        return Array.prototype.unshift.call(arguments, e), s.apply(this, arguments)
                                    }
                                }(c)
                            }
                            return n
                        };
                        var n = function() {
                            this.listeners = {}
                        };
                        return n.prototype.on = function(t, e) {
                            this.listeners = this.listeners || {}, t in this.listeners ? this.listeners[t].push(e) : this.listeners[t] = [e]
                        }, n.prototype.trigger = function(t) {
                            var e = Array.prototype.slice,
                                i = e.call(arguments, 1);
                            this.listeners = this.listeners || {}, null == i && (i = []), 0 === i.length && i.push({}), i[0]._type = t, t in this.listeners && this.invoke(this.listeners[t], e.call(arguments, 1)), "*" in this.listeners && this.invoke(this.listeners["*"], arguments)
                        }, n.prototype.invoke = function(t, e) {
                            for (var i = 0, n = t.length; n > i; i++) t[i].apply(this, e)
                        }, i.Observable = n, i.generateChars = function(t) {
                            for (var e = "", i = 0; t > i; i++) {
                                e += Math.floor(36 * Math.random()).toString(36)
                            }
                            return e
                        }, i.bind = function(t, e) {
                            return function() {
                                t.apply(e, arguments)
                            }
                        }, i._convertData = function(t) {
                            for (var e in t) {
                                var i = e.split("-"),
                                    n = t;
                                if (1 !== i.length) {
                                    for (var s = 0; s < i.length; s++) {
                                        var o = i[s];
                                        o = o.substring(0, 1).toLowerCase() + o.substring(1), o in n || (n[o] = {}), s == i.length - 1 && (n[o] = t[e]), n = n[o]
                                    }
                                    delete t[e]
                                }
                            }
                            return t
                        }, i.hasScroll = function(e, i) {
                            var n = t(i),
                                s = i.style.overflowX,
                                o = i.style.overflowY;
                            return (s !== o || "hidden" !== o && "visible" !== o) && ("scroll" === s || "scroll" === o || (n.innerHeight() < i.scrollHeight || n.innerWidth() < i.scrollWidth))
                        }, i.escapeMarkup = function(t) {
                            var e = {
                                "\\": "&#92;",
                                "&": "&amp;",
                                "<": "&lt;",
                                ">": "&gt;",
                                '"': "&quot;",
                                "'": "&#39;",
                                "/": "&#47;"
                            };
                            return "string" != typeof t ? t : String(t).replace(/[&<>"'\/\\]/g, function(t) {
                                return e[t]
                            })
                        }, i.appendMany = function(e, i) {
                            if ("1.7" === t.fn.jquery.substr(0, 3)) {
                                var n = t();
                                t.map(i, function(t) {
                                    n = n.add(t)
                                }), i = n
                            }
                            e.append(i)
                        }, i
                    }), e.define("select2/results", ["jquery", "./utils"], function(t, e) {
                        function i(t, e, n) {
                            this.$element = t, this.data = n, this.options = e, i.__super__.constructor.call(this)
                        }
                        return e.Extend(i, e.Observable), i.prototype.render = function() {
                            var e = t('<ul class="select2-results__options" role="tree"></ul>');
                            return this.options.get("multiple") && e.attr("aria-multiselectable", "true"), this.$results = e, e
                        }, i.prototype.clear = function() {
                            this.$results.empty()
                        }, i.prototype.displayMessage = function(e) {
                            var i = this.options.get("escapeMarkup");
                            this.clear(), this.hideLoading();
                            var n = t('<li role="treeitem" aria-live="assertive" class="select2-results__option"></li>'),
                                s = this.options.get("translations").get(e.message);
                            n.append(i(s(e.args))), n[0].className += " select2-results__message", this.$results.append(n)
                        }, i.prototype.hideMessages = function() {
                            this.$results.find(".select2-results__message").remove()
                        }, i.prototype.append = function(t) {
                            this.hideLoading();
                            var e = [];
                            if (null == t.results || 0 === t.results.length) return void(0 === this.$results.children().length && this.trigger("results:message", {
                                message: "noResults"
                            }));
                            t.results = this.sort(t.results);
                            for (var i = 0; i < t.results.length; i++) {
                                var n = t.results[i],
                                    s = this.option(n);
                                e.push(s)
                            }
                            this.$results.append(e)
                        }, i.prototype.position = function(t, e) {
                            e.find(".select2-results").append(t)
                        }, i.prototype.sort = function(t) {
                            return this.options.get("sorter")(t)
                        }, i.prototype.highlightFirstItem = function() {
                            var t = this.$results.find(".select2-results__option[aria-selected]"),
                                e = t.filter("[aria-selected=true]");
                            e.length > 0 ? e.first().trigger("mouseenter") : t.first().trigger("mouseenter"), this.ensureHighlightVisible()
                        }, i.prototype.setClasses = function() {
                            var e = this;
                            this.data.current(function(i) {
                                var n = t.map(i, function(t) {
                                    return t.id.toString()
                                });
                                e.$results.find(".select2-results__option[aria-selected]").each(function() {
                                    var e = t(this),
                                        i = t.data(this, "data"),
                                        s = "" + i.id;
                                    null != i.element && i.element.selected || null == i.element && t.inArray(s, n) > -1 ? e.attr("aria-selected", "true") : e.attr("aria-selected", "false")
                                })
                            })
                        }, i.prototype.showLoading = function(t) {
                            this.hideLoading();
                            var e = this.options.get("translations").get("searching"),
                                i = {
                                    disabled: !0,
                                    loading: !0,
                                    text: e(t)
                                },
                                n = this.option(i);
                            n.className += " loading-results", this.$results.prepend(n)
                        }, i.prototype.hideLoading = function() {
                            this.$results.find(".loading-results").remove()
                        }, i.prototype.option = function(e) {
                            var i = document.createElement("li");
                            i.className = "select2-results__option";
                            var n = {
                                role: "treeitem",
                                "aria-selected": "false"
                            };
                            e.disabled && (delete n["aria-selected"], n["aria-disabled"] = "true"), null == e.id && delete n["aria-selected"], null != e._resultId && (i.id = e._resultId), e.title && (i.title = e.title), e.children && (n.role = "group", n["aria-label"] = e.text, delete n["aria-selected"]);
                            for (var s in n) {
                                var o = n[s];
                                i.setAttribute(s, o)
                            }
                            if (e.children) {
                                var r = t(i),
                                    a = document.createElement("strong");
                                a.className = "select2-results__group", t(a), this.template(e, a);
                                for (var l = [], h = 0; h < e.children.length; h++) {
                                    var c = e.children[h],
                                        u = this.option(c);
                                    l.push(u)
                                }
                                var d = t("<ul></ul>", {
                                    class: "select2-results__options select2-results__options--nested"
                                });
                                d.append(l), r.append(a), r.append(d)
                            } else this.template(e, i);
                            return t.data(i, "data", e), i
                        }, i.prototype.bind = function(e, i) {
                            var n = this,
                                s = e.id + "-results";
                            this.$results.attr("id", s), e.on("results:all", function(t) {
                                n.clear(), n.append(t.data), e.isOpen() && (n.setClasses(), n.highlightFirstItem())
                            }), e.on("results:append", function(t) {
                                n.append(t.data), e.isOpen() && n.setClasses()
                            }), e.on("query", function(t) {
                                n.hideMessages(), n.showLoading(t)
                            }), e.on("select", function() {
                                e.isOpen() && (n.setClasses(), n.highlightFirstItem())
                            }), e.on("unselect", function() {
                                e.isOpen() && (n.setClasses(), n.highlightFirstItem())
                            }), e.on("open", function() {
                                n.$results.attr("aria-expanded", "true"), n.$results.attr("aria-hidden", "false"), n.setClasses(), n.ensureHighlightVisible()
                            }), e.on("close", function() {
                                n.$results.attr("aria-expanded", "false"), n.$results.attr("aria-hidden", "true"), n.$results.removeAttr("aria-activedescendant")
                            }), e.on("results:toggle", function() {
                                var t = n.getHighlightedResults();
                                0 !== t.length && t.trigger("mouseup")
                            }), e.on("results:select", function() {
                                var t = n.getHighlightedResults();
                                if (0 !== t.length) {
                                    var e = t.data("data");
                                    "true" == t.attr("aria-selected") ? n.trigger("close", {}) : n.trigger("select", {
                                        data: e
                                    })
                                }
                            }), e.on("results:previous", function() {
                                var t = n.getHighlightedResults(),
                                    e = n.$results.find("[aria-selected]"),
                                    i = e.index(t);
                                if (0 !== i) {
                                    var s = i - 1;
                                    0 === t.length && (s = 0);
                                    var o = e.eq(s);
                                    o.trigger("mouseenter");
                                    var r = n.$results.offset().top,
                                        a = o.offset().top,
                                        l = n.$results.scrollTop() + (a - r);
                                    0 === s ? n.$results.scrollTop(0) : 0 > a - r && n.$results.scrollTop(l)
                                }
                            }), e.on("results:next", function() {
                                var t = n.getHighlightedResults(),
                                    e = n.$results.find("[aria-selected]"),
                                    i = e.index(t),
                                    s = i + 1;
                                if (!(s >= e.length)) {
                                    var o = e.eq(s);
                                    o.trigger("mouseenter");
                                    var r = n.$results.offset().top + n.$results.outerHeight(!1),
                                        a = o.offset().top + o.outerHeight(!1),
                                        l = n.$results.scrollTop() + a - r;
                                    0 === s ? n.$results.scrollTop(0) : a > r && n.$results.scrollTop(l)
                                }
                            }), e.on("results:focus", function(t) {
                                t.element.addClass("select2-results__option--highlighted")
                            }), e.on("results:message", function(t) {
                                n.displayMessage(t)
                            }), t.fn.mousewheel && this.$results.on("mousewheel", function(t) {
                                var e = n.$results.scrollTop(),
                                    i = n.$results.get(0).scrollHeight - e + t.deltaY,
                                    s = t.deltaY > 0 && e - t.deltaY <= 0,
                                    o = t.deltaY < 0 && i <= n.$results.height();
                                s ? (n.$results.scrollTop(0), t.preventDefault(), t.stopPropagation()) : o && (n.$results.scrollTop(n.$results.get(0).scrollHeight - n.$results.height()), t.preventDefault(), t.stopPropagation())
                            }), this.$results.on("mouseup", ".select2-results__option[aria-selected]", function(e) {
                                var i = t(this),
                                    s = i.data("data");
                                return "true" === i.attr("aria-selected") ? void(n.options.get("multiple") ? n.trigger("unselect", {
                                    originalEvent: e,
                                    data: s
                                }) : n.trigger("close", {})) : void n.trigger("select", {
                                    originalEvent: e,
                                    data: s
                                })
                            }), this.$results.on("mouseenter", ".select2-results__option[aria-selected]", function(e) {
                                var i = t(this).data("data");
                                n.getHighlightedResults().removeClass("select2-results__option--highlighted"), n.trigger("results:focus", {
                                    data: i,
                                    element: t(this)
                                })
                            })
                        }, i.prototype.getHighlightedResults = function() {
                            return this.$results.find(".select2-results__option--highlighted")
                        }, i.prototype.destroy = function() {
                            this.$results.remove()
                        }, i.prototype.ensureHighlightVisible = function() {
                            var t = this.getHighlightedResults();
                            if (0 !== t.length) {
                                var e = this.$results.find("[aria-selected]"),
                                    i = e.index(t),
                                    n = this.$results.offset().top,
                                    s = t.offset().top,
                                    o = this.$results.scrollTop() + (s - n),
                                    r = s - n;
                                o -= 2 * t.outerHeight(!1), 2 >= i ? this.$results.scrollTop(0) : (r > this.$results.outerHeight() || 0 > r) && this.$results.scrollTop(o)
                            }
                        }, i.prototype.template = function(e, i) {
                            var n = this.options.get("templateResult"),
                                s = this.options.get("escapeMarkup"),
                                o = n(e, i);
                            null == o ? i.style.display = "none" : "string" == typeof o ? i.innerHTML = s(o) : t(i).append(o)
                        }, i
                    }), e.define("select2/keys", [], function() {
                        return {
                            BACKSPACE: 8,
                            TAB: 9,
                            ENTER: 13,
                            SHIFT: 16,
                            CTRL: 17,
                            ALT: 18,
                            ESC: 27,
                            SPACE: 32,
                            PAGE_UP: 33,
                            PAGE_DOWN: 34,
                            END: 35,
                            HOME: 36,
                            LEFT: 37,
                            UP: 38,
                            RIGHT: 39,
                            DOWN: 40,
                            DELETE: 46
                        }
                    }), e.define("select2/selection/base", ["jquery", "../utils", "../keys"], function(t, e, i) {
                        function n(t, e) {
                            this.$element = t, this.options = e, n.__super__.constructor.call(this)
                        }
                        return e.Extend(n, e.Observable), n.prototype.render = function() {
                            var e = t('<span class="select2-selection" role="combobox"  aria-haspopup="true" aria-expanded="false"></span>');
                            return this._tabindex = 0, null != this.$element.data("old-tabindex") ? this._tabindex = this.$element.data("old-tabindex") : null != this.$element.attr("tabindex") && (this._tabindex = this.$element.attr("tabindex")), e.attr("title", this.$element.attr("title")), e.attr("tabindex", this._tabindex), this.$selection = e, e
                        }, n.prototype.bind = function(t, e) {
                            var n = this,
                                s = (t.id, t.id + "-results");
                            this.container = t, this.$selection.on("focus", function(t) {
                                n.trigger("focus", t)
                            }), this.$selection.on("blur", function(t) {
                                n._handleBlur(t)
                            }), this.$selection.on("keydown", function(t) {
                                n.trigger("keypress", t), t.which === i.SPACE && t.preventDefault()
                            }), t.on("results:focus", function(t) {
                                n.$selection.attr("aria-activedescendant", t.data._resultId)
                            }), t.on("selection:update", function(t) {
                                n.update(t.data)
                            }), t.on("open", function() {
                                n.$selection.attr("aria-expanded", "true"), n.$selection.attr("aria-owns", s), n._attachCloseHandler(t)
                            }), t.on("close", function() {
                                n.$selection.attr("aria-expanded", "false"), n.$selection.removeAttr("aria-activedescendant"), n.$selection.removeAttr("aria-owns"), n.$selection.focus(), n._detachCloseHandler(t)
                            }), t.on("enable", function() {
                                n.$selection.attr("tabindex", n._tabindex)
                            }), t.on("disable", function() {
                                n.$selection.attr("tabindex", "-1")
                            })
                        }, n.prototype._handleBlur = function(e) {
                            var i = this;
                            window.setTimeout(function() {
                                document.activeElement == i.$selection[0] || t.contains(i.$selection[0], document.activeElement) || i.trigger("blur", e)
                            }, 1)
                        }, n.prototype._attachCloseHandler = function(e) {
                            t(document.body).on("mousedown.select2." + e.id, function(e) {
                                var i = t(e.target),
                                    n = i.closest(".select2");
                                t(".select2.select2-container--open").each(function() {
                                    var e = t(this);
                                    this != n[0] && e.data("element").select2("close")
                                })
                            })
                        }, n.prototype._detachCloseHandler = function(e) {
                            t(document.body).off("mousedown.select2." + e.id)
                        }, n.prototype.position = function(t, e) {
                            e.find(".selection").append(t)
                        }, n.prototype.destroy = function() {
                            this._detachCloseHandler(this.container)
                        }, n.prototype.update = function(t) {
                            throw new Error("The `update` method must be defined in child classes.")
                        }, n
                    }), e.define("select2/selection/single", ["jquery", "./base", "../utils", "../keys"], function(t, e, i, n) {
                        function s() {
                            s.__super__.constructor.apply(this, arguments)
                        }
                        return i.Extend(s, e), s.prototype.render = function() {
                            var t = s.__super__.render.call(this);
                            return t.addClass("select2-selection--single"), t.html('<span class="select2-selection__rendered"></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span>'), t
                        }, s.prototype.bind = function(t, e) {
                            var i = this;
                            s.__super__.bind.apply(this, arguments);
                            var n = t.id + "-container";
                            this.$selection.find(".select2-selection__rendered").attr("id", n), this.$selection.attr("aria-labelledby", n), this.$selection.on("mousedown", function(t) {
                                1 === t.which && i.trigger("toggle", {
                                    originalEvent: t
                                })
                            }), this.$selection.on("focus", function(t) {}), this.$selection.on("blur", function(t) {}), t.on("focus", function(e) {
                                t.isOpen() || i.$selection.focus()
                            }), t.on("selection:update", function(t) {
                                i.update(t.data)
                            })
                        }, s.prototype.clear = function() {
                            this.$selection.find(".select2-selection__rendered").empty()
                        }, s.prototype.display = function(t, e) {
                            var i = this.options.get("templateSelection");
                            return this.options.get("escapeMarkup")(i(t, e))
                        }, s.prototype.selectionContainer = function() {
                            return t("<span></span>")
                        }, s.prototype.update = function(t) {
                            if (0 === t.length) return void this.clear();
                            var e = t[0],
                                i = this.$selection.find(".select2-selection__rendered"),
                                n = this.display(e, i);
                            i.empty().append(n), i.prop("title", e.title || e.text)
                        }, s
                    }), e.define("select2/selection/multiple", ["jquery", "./base", "../utils"], function(t, e, i) {
                        function n(t, e) {
                            n.__super__.constructor.apply(this, arguments)
                        }
                        return i.Extend(n, e), n.prototype.render = function() {
                            var t = n.__super__.render.call(this);
                            return t.addClass("select2-selection--multiple"), t.html('<ul class="select2-selection__rendered"></ul>'), t
                        }, n.prototype.bind = function(e, i) {
                            var s = this;
                            n.__super__.bind.apply(this, arguments), this.$selection.on("click", function(t) {
                                s.trigger("toggle", {
                                    originalEvent: t
                                })
                            }), this.$selection.on("click", ".select2-selection__choice__remove", function(e) {
                                if (!s.options.get("disabled")) {
                                    var i = t(this),
                                        n = i.parent(),
                                        o = n.data("data");
                                    s.trigger("unselect", {
                                        originalEvent: e,
                                        data: o
                                    })
                                }
                            })
                        }, n.prototype.clear = function() {
                            this.$selection.find(".select2-selection__rendered").empty()
                        }, n.prototype.display = function(t, e) {
                            var i = this.options.get("templateSelection");
                            return this.options.get("escapeMarkup")(i(t, e))
                        }, n.prototype.selectionContainer = function() {
                            return t('<li class="select2-selection__choice"><span class="select2-selection__choice__remove" role="presentation">&times;</span></li>')
                        }, n.prototype.update = function(t) {
                            if (this.clear(), 0 !== t.length) {
                                for (var e = [], n = 0; n < t.length; n++) {
                                    var s = t[n],
                                        o = this.selectionContainer(),
                                        r = this.display(s, o);
                                    o.append(r), o.prop("title", s.title || s.text), o.data("data", s), e.push(o)
                                }
                                var a = this.$selection.find(".select2-selection__rendered");
                                i.appendMany(a, e)
                            }
                        }, n
                    }), e.define("select2/selection/placeholder", ["../utils"], function(t) {
                        function e(t, e, i) {
                            this.placeholder = this.normalizePlaceholder(i.get("placeholder")), t.call(this, e, i)
                        }
                        return e.prototype.normalizePlaceholder = function(t, e) {
                            return "string" == typeof e && (e = {
                                id: "",
                                text: e
                            }), e
                        }, e.prototype.createPlaceholder = function(t, e) {
                            var i = this.selectionContainer();
                            return i.html(this.display(e)), i.addClass("select2-selection__placeholder").removeClass("select2-selection__choice"), i
                        }, e.prototype.update = function(t, e) {
                            var i = 1 == e.length && e[0].id != this.placeholder.id;
                            if (e.length > 1 || i) return t.call(this, e);
                            this.clear();
                            var n = this.createPlaceholder(this.placeholder);
                            this.$selection.find(".select2-selection__rendered").append(n)
                        }, e
                    }), e.define("select2/selection/allowClear", ["jquery", "../keys"], function(t, e) {
                        function i() {}
                        return i.prototype.bind = function(t, e, i) {
                            var n = this;
                            t.call(this, e, i), null == this.placeholder && this.options.get("debug") && window.console && console.error && console.error("Select2: The `allowClear` option should be used in combination with the `placeholder` option."), this.$selection.on("mousedown", ".select2-selection__clear", function(t) {
                                n._handleClear(t)
                            }), e.on("keypress", function(t) {
                                n._handleKeyboardClear(t, e)
                            })
                        }, i.prototype._handleClear = function(t, e) {
                            if (!this.options.get("disabled")) {
                                var i = this.$selection.find(".select2-selection__clear");
                                if (0 !== i.length) {
                                    e.stopPropagation();
                                    for (var n = i.data("data"), s = 0; s < n.length; s++) {
                                        var o = {
                                            data: n[s]
                                        };
                                        if (this.trigger("unselect", o), o.prevented) return
                                    }
                                    this.$element.val(this.placeholder.id).trigger("change"), this.trigger("toggle", {})
                                }
                            }
                        }, i.prototype._handleKeyboardClear = function(t, i, n) {
                            n.isOpen() || (i.which == e.DELETE || i.which == e.BACKSPACE) && this._handleClear(i)
                        }, i.prototype.update = function(e, i) {
                            if (e.call(this, i), !(this.$selection.find(".select2-selection__placeholder").length > 0 || 0 === i.length)) {
                                var n = t('<span class="select2-selection__clear">&times;</span>');
                                n.data("data", i), this.$selection.find(".select2-selection__rendered").prepend(n)
                            }
                        }, i
                    }), e.define("select2/selection/search", ["jquery", "../utils", "../keys"], function(t, e, i) {
                        function n(t, e, i) {
                            t.call(this, e, i)
                        }
                        return n.prototype.render = function(e) {
                            var i = t('<li class="select2-search select2-search--inline"><input class="select2-search__field" type="search" tabindex="-1" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" role="textbox" aria-autocomplete="list" /></li>');
                            this.$searchContainer = i, this.$search = i.find("input");
                            var n = e.call(this);
                            return this._transferTabIndex(), n
                        }, n.prototype.bind = function(t, e, n) {
                            var s = this;
                            t.call(this, e, n), e.on("open", function() {
                                s.$search.trigger("focus")
                            }), e.on("close", function() {
                                s.$search.val(""), s.$search.removeAttr("aria-activedescendant"), s.$search.trigger("focus")
                            }), e.on("enable", function() {
                                s.$search.prop("disabled", !1), s._transferTabIndex()
                            }), e.on("disable", function() {
                                s.$search.prop("disabled", !0)
                            }), e.on("focus", function(t) {
                                s.$search.trigger("focus")
                            }), e.on("results:focus", function(t) {
                                s.$search.attr("aria-activedescendant", t.id)
                            }), this.$selection.on("focusin", ".select2-search--inline", function(t) {
                                s.trigger("focus", t)
                            }), this.$selection.on("focusout", ".select2-search--inline", function(t) {
                                s._handleBlur(t)
                            }), this.$selection.on("keydown", ".select2-search--inline", function(t) {
                                if (t.stopPropagation(), s.trigger("keypress", t), s._keyUpPrevented = t.isDefaultPrevented(), t.which === i.BACKSPACE && "" === s.$search.val()) {
                                    var e = s.$searchContainer.prev(".select2-selection__choice");
                                    if (e.length > 0) {
                                        var n = e.data("data");
                                        s.searchRemoveChoice(n), t.preventDefault()
                                    }
                                }
                            });
                            var o = document.documentMode,
                                r = o && 11 >= o;
                            this.$selection.on("input.searchcheck", ".select2-search--inline", function(t) {
                                return r ? void s.$selection.off("input.search input.searchcheck") : void s.$selection.off("keyup.search")
                            }), this.$selection.on("keyup.search input.search", ".select2-search--inline", function(t) {
                                if (r && "input" === t.type) return void s.$selection.off("input.search input.searchcheck");
                                var e = t.which;
                                e != i.SHIFT && e != i.CTRL && e != i.ALT && e != i.TAB && s.handleSearch(t)
                            })
                        }, n.prototype._transferTabIndex = function(t) {
                            this.$search.attr("tabindex", this.$selection.attr("tabindex")), this.$selection.attr("tabindex", "-1")
                        }, n.prototype.createPlaceholder = function(t, e) {
                            this.$search.attr("placeholder", e.text)
                        }, n.prototype.update = function(t, e) {
                            var i = this.$search[0] == document.activeElement;
                            this.$search.attr("placeholder", ""), t.call(this, e), this.$selection.find(".select2-selection__rendered").append(this.$searchContainer), this.resizeSearch(), i && this.$search.focus()
                        }, n.prototype.handleSearch = function() {
                            if (this.resizeSearch(), !this._keyUpPrevented) {
                                var t = this.$search.val();
                                this.trigger("query", {
                                    term: t
                                })
                            }
                            this._keyUpPrevented = !1
                        }, n.prototype.searchRemoveChoice = function(t, e) {
                            this.trigger("unselect", {
                                data: e
                            }), this.$search.val(e.text), this.handleSearch()
                        }, n.prototype.resizeSearch = function() {
                            this.$search.css("width", "25px");
                            var t = "";
                            if ("" !== this.$search.attr("placeholder")) t = this.$selection.find(".select2-selection__rendered").innerWidth();
                            else {
                                t = .75 * (this.$search.val().length + 1) + "em"
                            }
                            this.$search.css("width", t)
                        }, n
                    }), e.define("select2/selection/eventRelay", ["jquery"], function(t) {
                        function e() {}
                        return e.prototype.bind = function(e, i, n) {
                            var s = this,
                                o = ["open", "opening", "close", "closing", "select", "selecting", "unselect", "unselecting"],
                                r = ["opening", "closing", "selecting", "unselecting"];
                            e.call(this, i, n), i.on("*", function(e, i) {
                                if (-1 !== t.inArray(e, o)) {
                                    i = i || {};
                                    var n = t.Event("select2:" + e, {
                                        params: i
                                    });
                                    s.$element.trigger(n), -1 !== t.inArray(e, r) && (i.prevented = n.isDefaultPrevented())
                                }
                            })
                        }, e
                    }), e.define("select2/translation", ["jquery", "require"], function(t, e) {
                        function i(t) {
                            this.dict = t || {}
                        }
                        return i.prototype.all = function() {
                            return this.dict
                        }, i.prototype.get = function(t) {
                            return this.dict[t]
                        }, i.prototype.extend = function(e) {
                            this.dict = t.extend({}, e.all(), this.dict)
                        }, i._cache = {}, i.loadPath = function(t) {
                            if (!(t in i._cache)) {
                                var n = e(t);
                                i._cache[t] = n
                            }
                            return new i(i._cache[t])
                        }, i
                    }), e.define("select2/diacritics", [], function() {
                        return {
                            "Ⓐ": "A",
                            "Ａ": "A",
                            "À": "A",
                            "Á": "A",
                            "Â": "A",
                            "Ầ": "A",
                            "Ấ": "A",
                            "Ẫ": "A",
                            "Ẩ": "A",
                            "Ã": "A",
                            "Ā": "A",
                            "Ă": "A",
                            "Ằ": "A",
                            "Ắ": "A",
                            "Ẵ": "A",
                            "Ẳ": "A",
                            "Ȧ": "A",
                            "Ǡ": "A",
                            "Ä": "A",
                            "Ǟ": "A",
                            "Ả": "A",
                            "Å": "A",
                            "Ǻ": "A",
                            "Ǎ": "A",
                            "Ȁ": "A",
                            "Ȃ": "A",
                            "Ạ": "A",
                            "Ậ": "A",
                            "Ặ": "A",
                            "Ḁ": "A",
                            "Ą": "A",
                            "Ⱥ": "A",
                            "Ɐ": "A",
                            "Ꜳ": "AA",
                            "Æ": "AE",
                            "Ǽ": "AE",
                            "Ǣ": "AE",
                            "Ꜵ": "AO",
                            "Ꜷ": "AU",
                            "Ꜹ": "AV",
                            "Ꜻ": "AV",
                            "Ꜽ": "AY",
                            "Ⓑ": "B",
                            "Ｂ": "B",
                            "Ḃ": "B",
                            "Ḅ": "B",
                            "Ḇ": "B",
                            "Ƀ": "B",
                            "Ƃ": "B",
                            "Ɓ": "B",
                            "Ⓒ": "C",
                            "Ｃ": "C",
                            "Ć": "C",
                            "Ĉ": "C",
                            "Ċ": "C",
                            "Č": "C",
                            "Ç": "C",
                            "Ḉ": "C",
                            "Ƈ": "C",
                            "Ȼ": "C",
                            "Ꜿ": "C",
                            "Ⓓ": "D",
                            "Ｄ": "D",
                            "Ḋ": "D",
                            "Ď": "D",
                            "Ḍ": "D",
                            "Ḑ": "D",
                            "Ḓ": "D",
                            "Ḏ": "D",
                            "Đ": "D",
                            "Ƌ": "D",
                            "Ɗ": "D",
                            "Ɖ": "D",
                            "Ꝺ": "D",
                            "Ǳ": "DZ",
                            "Ǆ": "DZ",
                            "ǲ": "Dz",
                            "ǅ": "Dz",
                            "Ⓔ": "E",
                            "Ｅ": "E",
                            "È": "E",
                            "É": "E",
                            "Ê": "E",
                            "Ề": "E",
                            "Ế": "E",
                            "Ễ": "E",
                            "Ể": "E",
                            "Ẽ": "E",
                            "Ē": "E",
                            "Ḕ": "E",
                            "Ḗ": "E",
                            "Ĕ": "E",
                            "Ė": "E",
                            "Ë": "E",
                            "Ẻ": "E",
                            "Ě": "E",
                            "Ȅ": "E",
                            "Ȇ": "E",
                            "Ẹ": "E",
                            "Ệ": "E",
                            "Ȩ": "E",
                            "Ḝ": "E",
                            "Ę": "E",
                            "Ḙ": "E",
                            "Ḛ": "E",
                            "Ɛ": "E",
                            "Ǝ": "E",
                            "Ⓕ": "F",
                            "Ｆ": "F",
                            "Ḟ": "F",
                            "Ƒ": "F",
                            "Ꝼ": "F",
                            "Ⓖ": "G",
                            "Ｇ": "G",
                            "Ǵ": "G",
                            "Ĝ": "G",
                            "Ḡ": "G",
                            "Ğ": "G",
                            "Ġ": "G",
                            "Ǧ": "G",
                            "Ģ": "G",
                            "Ǥ": "G",
                            "Ɠ": "G",
                            "Ꞡ": "G",
                            "Ᵹ": "G",
                            "Ꝿ": "G",
                            "Ⓗ": "H",
                            "Ｈ": "H",
                            "Ĥ": "H",
                            "Ḣ": "H",
                            "Ḧ": "H",
                            "Ȟ": "H",
                            "Ḥ": "H",
                            "Ḩ": "H",
                            "Ḫ": "H",
                            "Ħ": "H",
                            "Ⱨ": "H",
                            "Ⱶ": "H",
                            "Ɥ": "H",
                            "Ⓘ": "I",
                            "Ｉ": "I",
                            "Ì": "I",
                            "Í": "I",
                            "Î": "I",
                            "Ĩ": "I",
                            "Ī": "I",
                            "Ĭ": "I",
                            "İ": "I",
                            "Ï": "I",
                            "Ḯ": "I",
                            "Ỉ": "I",
                            "Ǐ": "I",
                            "Ȉ": "I",
                            "Ȋ": "I",
                            "Ị": "I",
                            "Į": "I",
                            "Ḭ": "I",
                            "Ɨ": "I",
                            "Ⓙ": "J",
                            "Ｊ": "J",
                            "Ĵ": "J",
                            "Ɉ": "J",
                            "Ⓚ": "K",
                            "Ｋ": "K",
                            "Ḱ": "K",
                            "Ǩ": "K",
                            "Ḳ": "K",
                            "Ķ": "K",
                            "Ḵ": "K",
                            "Ƙ": "K",
                            "Ⱪ": "K",
                            "Ꝁ": "K",
                            "Ꝃ": "K",
                            "Ꝅ": "K",
                            "Ꞣ": "K",
                            "Ⓛ": "L",
                            "Ｌ": "L",
                            "Ŀ": "L",
                            "Ĺ": "L",
                            "Ľ": "L",
                            "Ḷ": "L",
                            "Ḹ": "L",
                            "Ļ": "L",
                            "Ḽ": "L",
                            "Ḻ": "L",
                            "Ł": "L",
                            "Ƚ": "L",
                            "Ɫ": "L",
                            "Ⱡ": "L",
                            "Ꝉ": "L",
                            "Ꝇ": "L",
                            "Ꞁ": "L",
                            "Ǉ": "LJ",
                            "ǈ": "Lj",
                            "Ⓜ": "M",
                            "Ｍ": "M",
                            "Ḿ": "M",
                            "Ṁ": "M",
                            "Ṃ": "M",
                            "Ɱ": "M",
                            "Ɯ": "M",
                            "Ⓝ": "N",
                            "Ｎ": "N",
                            "Ǹ": "N",
                            "Ń": "N",
                            "Ñ": "N",
                            "Ṅ": "N",
                            "Ň": "N",
                            "Ṇ": "N",
                            "Ņ": "N",
                            "Ṋ": "N",
                            "Ṉ": "N",
                            "Ƞ": "N",
                            "Ɲ": "N",
                            "Ꞑ": "N",
                            "Ꞥ": "N",
                            "Ǌ": "NJ",
                            "ǋ": "Nj",
                            "Ⓞ": "O",
                            "Ｏ": "O",
                            "Ò": "O",
                            "Ó": "O",
                            "Ô": "O",
                            "Ồ": "O",
                            "Ố": "O",
                            "Ỗ": "O",
                            "Ổ": "O",
                            "Õ": "O",
                            "Ṍ": "O",
                            "Ȭ": "O",
                            "Ṏ": "O",
                            "Ō": "O",
                            "Ṑ": "O",
                            "Ṓ": "O",
                            "Ŏ": "O",
                            "Ȯ": "O",
                            "Ȱ": "O",
                            "Ö": "O",
                            "Ȫ": "O",
                            "Ỏ": "O",
                            "Ő": "O",
                            "Ǒ": "O",
                            "Ȍ": "O",
                            "Ȏ": "O",
                            "Ơ": "O",
                            "Ờ": "O",
                            "Ớ": "O",
                            "Ỡ": "O",
                            "Ở": "O",
                            "Ợ": "O",
                            "Ọ": "O",
                            "Ộ": "O",
                            "Ǫ": "O",
                            "Ǭ": "O",
                            "Ø": "O",
                            "Ǿ": "O",
                            "Ɔ": "O",
                            "Ɵ": "O",
                            "Ꝋ": "O",
                            "Ꝍ": "O",
                            "Ƣ": "OI",
                            "Ꝏ": "OO",
                            "Ȣ": "OU",
                            "Ⓟ": "P",
                            "Ｐ": "P",
                            "Ṕ": "P",
                            "Ṗ": "P",
                            "Ƥ": "P",
                            "Ᵽ": "P",
                            "Ꝑ": "P",
                            "Ꝓ": "P",
                            "Ꝕ": "P",
                            "Ⓠ": "Q",
                            "Ｑ": "Q",
                            "Ꝗ": "Q",
                            "Ꝙ": "Q",
                            "Ɋ": "Q",
                            "Ⓡ": "R",
                            "Ｒ": "R",
                            "Ŕ": "R",
                            "Ṙ": "R",
                            "Ř": "R",
                            "Ȑ": "R",
                            "Ȓ": "R",
                            "Ṛ": "R",
                            "Ṝ": "R",
                            "Ŗ": "R",
                            "Ṟ": "R",
                            "Ɍ": "R",
                            "Ɽ": "R",
                            "Ꝛ": "R",
                            "Ꞧ": "R",
                            "Ꞃ": "R",
                            "Ⓢ": "S",
                            "Ｓ": "S",
                            "ẞ": "S",
                            "Ś": "S",
                            "Ṥ": "S",
                            "Ŝ": "S",
                            "Ṡ": "S",
                            "Š": "S",
                            "Ṧ": "S",
                            "Ṣ": "S",
                            "Ṩ": "S",
                            "Ș": "S",
                            "Ş": "S",
                            "Ȿ": "S",
                            "Ꞩ": "S",
                            "Ꞅ": "S",
                            "Ⓣ": "T",
                            "Ｔ": "T",
                            "Ṫ": "T",
                            "Ť": "T",
                            "Ṭ": "T",
                            "Ț": "T",
                            "Ţ": "T",
                            "Ṱ": "T",
                            "Ṯ": "T",
                            "Ŧ": "T",
                            "Ƭ": "T",
                            "Ʈ": "T",
                            "Ⱦ": "T",
                            "Ꞇ": "T",
                            "Ꜩ": "TZ",
                            "Ⓤ": "U",
                            "Ｕ": "U",
                            "Ù": "U",
                            "Ú": "U",
                            "Û": "U",
                            "Ũ": "U",
                            "Ṹ": "U",
                            "Ū": "U",
                            "Ṻ": "U",
                            "Ŭ": "U",
                            "Ü": "U",
                            "Ǜ": "U",
                            "Ǘ": "U",
                            "Ǖ": "U",
                            "Ǚ": "U",
                            "Ủ": "U",
                            "Ů": "U",
                            "Ű": "U",
                            "Ǔ": "U",
                            "Ȕ": "U",
                            "Ȗ": "U",
                            "Ư": "U",
                            "Ừ": "U",
                            "Ứ": "U",
                            "Ữ": "U",
                            "Ử": "U",
                            "Ự": "U",
                            "Ụ": "U",
                            "Ṳ": "U",
                            "Ų": "U",
                            "Ṷ": "U",
                            "Ṵ": "U",
                            "Ʉ": "U",
                            "Ⓥ": "V",
                            "Ｖ": "V",
                            "Ṽ": "V",
                            "Ṿ": "V",
                            "Ʋ": "V",
                            "Ꝟ": "V",
                            "Ʌ": "V",
                            "Ꝡ": "VY",
                            "Ⓦ": "W",
                            "Ｗ": "W",
                            "Ẁ": "W",
                            "Ẃ": "W",
                            "Ŵ": "W",
                            "Ẇ": "W",
                            "Ẅ": "W",
                            "Ẉ": "W",
                            "Ⱳ": "W",
                            "Ⓧ": "X",
                            "Ｘ": "X",
                            "Ẋ": "X",
                            "Ẍ": "X",
                            "Ⓨ": "Y",
                            "Ｙ": "Y",
                            "Ỳ": "Y",
                            "Ý": "Y",
                            "Ŷ": "Y",
                            "Ỹ": "Y",
                            "Ȳ": "Y",
                            "Ẏ": "Y",
                            "Ÿ": "Y",
                            "Ỷ": "Y",
                            "Ỵ": "Y",
                            "Ƴ": "Y",
                            "Ɏ": "Y",
                            "Ỿ": "Y",
                            "Ⓩ": "Z",
                            "Ｚ": "Z",
                            "Ź": "Z",
                            "Ẑ": "Z",
                            "Ż": "Z",
                            "Ž": "Z",
                            "Ẓ": "Z",
                            "Ẕ": "Z",
                            "Ƶ": "Z",
                            "Ȥ": "Z",
                            "Ɀ": "Z",
                            "Ⱬ": "Z",
                            "Ꝣ": "Z",
                            "ⓐ": "a",
                            "ａ": "a",
                            "ẚ": "a",
                            "à": "a",
                            "á": "a",
                            "â": "a",
                            "ầ": "a",
                            "ấ": "a",
                            "ẫ": "a",
                            "ẩ": "a",
                            "ã": "a",
                            "ā": "a",
                            "ă": "a",
                            "ằ": "a",
                            "ắ": "a",
                            "ẵ": "a",
                            "ẳ": "a",
                            "ȧ": "a",
                            "ǡ": "a",
                            "ä": "a",
                            "ǟ": "a",
                            "ả": "a",
                            "å": "a",
                            "ǻ": "a",
                            "ǎ": "a",
                            "ȁ": "a",
                            "ȃ": "a",
                            "ạ": "a",
                            "ậ": "a",
                            "ặ": "a",
                            "ḁ": "a",
                            "ą": "a",
                            "ⱥ": "a",
                            "ɐ": "a",
                            "ꜳ": "aa",
                            "æ": "ae",
                            "ǽ": "ae",
                            "ǣ": "ae",
                            "ꜵ": "ao",
                            "ꜷ": "au",
                            "ꜹ": "av",
                            "ꜻ": "av",
                            "ꜽ": "ay",
                            "ⓑ": "b",
                            "ｂ": "b",
                            "ḃ": "b",
                            "ḅ": "b",
                            "ḇ": "b",
                            "ƀ": "b",
                            "ƃ": "b",
                            "ɓ": "b",
                            "ⓒ": "c",
                            "ｃ": "c",
                            "ć": "c",
                            "ĉ": "c",
                            "ċ": "c",
                            "č": "c",
                            "ç": "c",
                            "ḉ": "c",
                            "ƈ": "c",
                            "ȼ": "c",
                            "ꜿ": "c",
                            "ↄ": "c",
                            "ⓓ": "d",
                            "ｄ": "d",
                            "ḋ": "d",
                            "ď": "d",
                            "ḍ": "d",
                            "ḑ": "d",
                            "ḓ": "d",
                            "ḏ": "d",
                            "đ": "d",
                            "ƌ": "d",
                            "ɖ": "d",
                            "ɗ": "d",
                            "ꝺ": "d",
                            "ǳ": "dz",
                            "ǆ": "dz",
                            "ⓔ": "e",
                            "ｅ": "e",
                            "è": "e",
                            "é": "e",
                            "ê": "e",
                            "ề": "e",
                            "ế": "e",
                            "ễ": "e",
                            "ể": "e",
                            "ẽ": "e",
                            "ē": "e",
                            "ḕ": "e",
                            "ḗ": "e",
                            "ĕ": "e",
                            "ė": "e",
                            "ë": "e",
                            "ẻ": "e",
                            "ě": "e",
                            "ȅ": "e",
                            "ȇ": "e",
                            "ẹ": "e",
                            "ệ": "e",
                            "ȩ": "e",
                            "ḝ": "e",
                            "ę": "e",
                            "ḙ": "e",
                            "ḛ": "e",
                            "ɇ": "e",
                            "ɛ": "e",
                            "ǝ": "e",
                            "ⓕ": "f",
                            "ｆ": "f",
                            "ḟ": "f",
                            "ƒ": "f",
                            "ꝼ": "f",
                            "ⓖ": "g",
                            "ｇ": "g",
                            "ǵ": "g",
                            "ĝ": "g",
                            "ḡ": "g",
                            "ğ": "g",
                            "ġ": "g",
                            "ǧ": "g",
                            "ģ": "g",
                            "ǥ": "g",
                            "ɠ": "g",
                            "ꞡ": "g",
                            "ᵹ": "g",
                            "ꝿ": "g",
                            "ⓗ": "h",
                            "ｈ": "h",
                            "ĥ": "h",
                            "ḣ": "h",
                            "ḧ": "h",
                            "ȟ": "h",
                            "ḥ": "h",
                            "ḩ": "h",
                            "ḫ": "h",
                            "ẖ": "h",
                            "ħ": "h",
                            "ⱨ": "h",
                            "ⱶ": "h",
                            "ɥ": "h",
                            "ƕ": "hv",
                            "ⓘ": "i",
                            "ｉ": "i",
                            "ì": "i",
                            "í": "i",
                            "î": "i",
                            "ĩ": "i",
                            "ī": "i",
                            "ĭ": "i",
                            "ï": "i",
                            "ḯ": "i",
                            "ỉ": "i",
                            "ǐ": "i",
                            "ȉ": "i",
                            "ȋ": "i",
                            "ị": "i",
                            "į": "i",
                            "ḭ": "i",
                            "ɨ": "i",
                            "ı": "i",
                            "ⓙ": "j",
                            "ｊ": "j",
                            "ĵ": "j",
                            "ǰ": "j",
                            "ɉ": "j",
                            "ⓚ": "k",
                            "ｋ": "k",
                            "ḱ": "k",
                            "ǩ": "k",
                            "ḳ": "k",
                            "ķ": "k",
                            "ḵ": "k",
                            "ƙ": "k",
                            "ⱪ": "k",
                            "ꝁ": "k",
                            "ꝃ": "k",
                            "ꝅ": "k",
                            "ꞣ": "k",
                            "ⓛ": "l",
                            "ｌ": "l",
                            "ŀ": "l",
                            "ĺ": "l",
                            "ľ": "l",
                            "ḷ": "l",
                            "ḹ": "l",
                            "ļ": "l",
                            "ḽ": "l",
                            "ḻ": "l",
                            "ſ": "l",
                            "ł": "l",
                            "ƚ": "l",
                            "ɫ": "l",
                            "ⱡ": "l",
                            "ꝉ": "l",
                            "ꞁ": "l",
                            "ꝇ": "l",
                            "ǉ": "lj",
                            "ⓜ": "m",
                            "ｍ": "m",
                            "ḿ": "m",
                            "ṁ": "m",
                            "ṃ": "m",
                            "ɱ": "m",
                            "ɯ": "m",
                            "ⓝ": "n",
                            "ｎ": "n",
                            "ǹ": "n",
                            "ń": "n",
                            "ñ": "n",
                            "ṅ": "n",
                            "ň": "n",
                            "ṇ": "n",
                            "ņ": "n",
                            "ṋ": "n",
                            "ṉ": "n",
                            "ƞ": "n",
                            "ɲ": "n",
                            "ŉ": "n",
                            "ꞑ": "n",
                            "ꞥ": "n",
                            "ǌ": "nj",
                            "ⓞ": "o",
                            "ｏ": "o",
                            "ò": "o",
                            "ó": "o",
                            "ô": "o",
                            "ồ": "o",
                            "ố": "o",
                            "ỗ": "o",
                            "ổ": "o",
                            "õ": "o",
                            "ṍ": "o",
                            "ȭ": "o",
                            "ṏ": "o",
                            "ō": "o",
                            "ṑ": "o",
                            "ṓ": "o",
                            "ŏ": "o",
                            "ȯ": "o",
                            "ȱ": "o",
                            "ö": "o",
                            "ȫ": "o",
                            "ỏ": "o",
                            "ő": "o",
                            "ǒ": "o",
                            "ȍ": "o",
                            "ȏ": "o",
                            "ơ": "o",
                            "ờ": "o",
                            "ớ": "o",
                            "ỡ": "o",
                            "ở": "o",
                            "ợ": "o",
                            "ọ": "o",
                            "ộ": "o",
                            "ǫ": "o",
                            "ǭ": "o",
                            "ø": "o",
                            "ǿ": "o",
                            "ɔ": "o",
                            "ꝋ": "o",
                            "ꝍ": "o",
                            "ɵ": "o",
                            "ƣ": "oi",
                            "ȣ": "ou",
                            "ꝏ": "oo",
                            "ⓟ": "p",
                            "ｐ": "p",
                            "ṕ": "p",
                            "ṗ": "p",
                            "ƥ": "p",
                            "ᵽ": "p",
                            "ꝑ": "p",
                            "ꝓ": "p",
                            "ꝕ": "p",
                            "ⓠ": "q",
                            "ｑ": "q",
                            "ɋ": "q",
                            "ꝗ": "q",
                            "ꝙ": "q",
                            "ⓡ": "r",
                            "ｒ": "r",
                            "ŕ": "r",
                            "ṙ": "r",
                            "ř": "r",
                            "ȑ": "r",
                            "ȓ": "r",
                            "ṛ": "r",
                            "ṝ": "r",
                            "ŗ": "r",
                            "ṟ": "r",
                            "ɍ": "r",
                            "ɽ": "r",
                            "ꝛ": "r",
                            "ꞧ": "r",
                            "ꞃ": "r",
                            "ⓢ": "s",
                            "ｓ": "s",
                            "ß": "s",
                            "ś": "s",
                            "ṥ": "s",
                            "ŝ": "s",
                            "ṡ": "s",
                            "š": "s",
                            "ṧ": "s",
                            "ṣ": "s",
                            "ṩ": "s",
                            "ș": "s",
                            "ş": "s",
                            "ȿ": "s",
                            "ꞩ": "s",
                            "ꞅ": "s",
                            "ẛ": "s",
                            "ⓣ": "t",
                            "ｔ": "t",
                            "ṫ": "t",
                            "ẗ": "t",
                            "ť": "t",
                            "ṭ": "t",
                            "ț": "t",
                            "ţ": "t",
                            "ṱ": "t",
                            "ṯ": "t",
                            "ŧ": "t",
                            "ƭ": "t",
                            "ʈ": "t",
                            "ⱦ": "t",
                            "ꞇ": "t",
                            "ꜩ": "tz",
                            "ⓤ": "u",
                            "ｕ": "u",
                            "ù": "u",
                            "ú": "u",
                            "û": "u",
                            "ũ": "u",
                            "ṹ": "u",
                            "ū": "u",
                            "ṻ": "u",
                            "ŭ": "u",
                            "ü": "u",
                            "ǜ": "u",
                            "ǘ": "u",
                            "ǖ": "u",
                            "ǚ": "u",
                            "ủ": "u",
                            "ů": "u",
                            "ű": "u",
                            "ǔ": "u",
                            "ȕ": "u",
                            "ȗ": "u",
                            "ư": "u",
                            "ừ": "u",
                            "ứ": "u",
                            "ữ": "u",
                            "ử": "u",
                            "ự": "u",
                            "ụ": "u",
                            "ṳ": "u",
                            "ų": "u",
                            "ṷ": "u",
                            "ṵ": "u",
                            "ʉ": "u",
                            "ⓥ": "v",
                            "ｖ": "v",
                            "ṽ": "v",
                            "ṿ": "v",
                            "ʋ": "v",
                            "ꝟ": "v",
                            "ʌ": "v",
                            "ꝡ": "vy",
                            "ⓦ": "w",
                            "ｗ": "w",
                            "ẁ": "w",
                            "ẃ": "w",
                            "ŵ": "w",
                            "ẇ": "w",
                            "ẅ": "w",
                            "ẘ": "w",
                            "ẉ": "w",
                            "ⱳ": "w",
                            "ⓧ": "x",
                            "ｘ": "x",
                            "ẋ": "x",
                            "ẍ": "x",
                            "ⓨ": "y",
                            "ｙ": "y",
                            "ỳ": "y",
                            "ý": "y",
                            "ŷ": "y",
                            "ỹ": "y",
                            "ȳ": "y",
                            "ẏ": "y",
                            "ÿ": "y",
                            "ỷ": "y",
                            "ẙ": "y",
                            "ỵ": "y",
                            "ƴ": "y",
                            "ɏ": "y",
                            "ỿ": "y",
                            "ⓩ": "z",
                            "ｚ": "z",
                            "ź": "z",
                            "ẑ": "z",
                            "ż": "z",
                            "ž": "z",
                            "ẓ": "z",
                            "ẕ": "z",
                            "ƶ": "z",
                            "ȥ": "z",
                            "ɀ": "z",
                            "ⱬ": "z",
                            "ꝣ": "z",
                            "Ά": "Α",
                            "Έ": "Ε",
                            "Ή": "Η",
                            "Ί": "Ι",
                            "Ϊ": "Ι",
                            "Ό": "Ο",
                            "Ύ": "Υ",
                            "Ϋ": "Υ",
                            "Ώ": "Ω",
                            "ά": "α",
                            "έ": "ε",
                            "ή": "η",
                            "ί": "ι",
                            "ϊ": "ι",
                            "ΐ": "ι",
                            "ό": "ο",
                            "ύ": "υ",
                            "ϋ": "υ",
                            "ΰ": "υ",
                            "ω": "ω",
                            "ς": "σ"
                        }
                    }), e.define("select2/data/base", ["../utils"], function(t) {
                        function e(t, i) {
                            e.__super__.constructor.call(this)
                        }
                        return t.Extend(e, t.Observable), e.prototype.current = function(t) {
                            throw new Error("The `current` method must be defined in child classes.")
                        }, e.prototype.query = function(t, e) {
                            throw new Error("The `query` method must be defined in child classes.")
                        }, e.prototype.bind = function(t, e) {}, e.prototype.destroy = function() {}, e.prototype.generateResultId = function(e, i) {
                            var n = e.id + "-result-";
                            return n += t.generateChars(4), n += null != i.id ? "-" + i.id.toString() : "-" + t.generateChars(4)
                        }, e
                    }), e.define("select2/data/select", ["./base", "../utils", "jquery"], function(t, e, i) {
                        function n(t, e) {
                            this.$element = t, this.options = e, n.__super__.constructor.call(this)
                        }
                        return e.Extend(n, t), n.prototype.current = function(t) {
                            var e = [],
                                n = this;
                            this.$element.find(":selected").each(function() {
                                var t = i(this),
                                    s = n.item(t);
                                e.push(s)
                            }), t(e)
                        }, n.prototype.select = function(t) {
                            var e = this;
                            if (t.selected = !0, i(t.element).is("option")) return t.element.selected = !0, void this.$element.trigger("change");
                            if (this.$element.prop("multiple")) this.current(function(n) {
                                var s = [];
                                t = [t], t.push.apply(t, n);
                                for (var o = 0; o < t.length; o++) {
                                    var r = t[o].id; - 1 === i.inArray(r, s) && s.push(r)
                                }
                                e.$element.val(s), e.$element.trigger("change")
                            });
                            else {
                                var n = t.id;
                                this.$element.val(n), this.$element.trigger("change")
                            }
                        }, n.prototype.unselect = function(t) {
                            var e = this;
                            if (this.$element.prop("multiple")) return t.selected = !1, i(t.element).is("option") ? (t.element.selected = !1, void this.$element.trigger("change")) : void this.current(function(n) {
                                for (var s = [], o = 0; o < n.length; o++) {
                                    var r = n[o].id;
                                    r !== t.id && -1 === i.inArray(r, s) && s.push(r)
                                }
                                e.$element.val(s), e.$element.trigger("change")
                            })
                        }, n.prototype.bind = function(t, e) {
                            var i = this;
                            this.container = t, t.on("select", function(t) {
                                i.select(t.data)
                            }), t.on("unselect", function(t) {
                                i.unselect(t.data)
                            })
                        }, n.prototype.destroy = function() {
                            this.$element.find("*").each(function() {
                                i.removeData(this, "data")
                            })
                        }, n.prototype.query = function(t, e) {
                            var n = [],
                                s = this;
                            this.$element.children().each(function() {
                                var e = i(this);
                                if (e.is("option") || e.is("optgroup")) {
                                    var o = s.item(e),
                                        r = s.matches(t, o);
                                    null !== r && n.push(r)
                                }
                            }), e({
                                results: n
                            })
                        }, n.prototype.addOptions = function(t) {
                            e.appendMany(this.$element, t)
                        }, n.prototype.option = function(t) {
                            var e;
                            t.children ? (e = document.createElement("optgroup"), e.label = t.text) : (e = document.createElement("option"), void 0 !== e.textContent ? e.textContent = t.text : e.innerText = t.text), t.id && (e.value = t.id), t.disabled && (e.disabled = !0), t.selected && (e.selected = !0), t.title && (e.title = t.title);
                            var n = i(e),
                                s = this._normalizeItem(t);
                            return s.element = e, i.data(e, "data", s), n
                        }, n.prototype.item = function(t) {
                            var e = {};
                            if (null != (e = i.data(t[0], "data"))) return e;
                            if (t.is("option")) e = {
                                id: t.val(),
                                text: t.text(),
                                disabled: t.prop("disabled"),
                                selected: t.prop("selected"),
                                title: t.prop("title")
                            };
                            else if (t.is("optgroup")) {
                                e = {
                                    text: t.prop("label"),
                                    children: [],
                                    title: t.prop("title")
                                };
                                for (var n = t.children("option"), s = [], o = 0; o < n.length; o++) {
                                    var r = i(n[o]),
                                        a = this.item(r);
                                    s.push(a)
                                }
                                e.children = s
                            }
                            return e = this._normalizeItem(e), e.element = t[0], i.data(t[0], "data", e), e
                        }, n.prototype._normalizeItem = function(t) {
                            i.isPlainObject(t) || (t = {
                                id: t,
                                text: t
                            }), t = i.extend({}, {
                                text: ""
                            }, t);
                            var e = {
                                selected: !1,
                                disabled: !1
                            };
                            return null != t.id && (t.id = t.id.toString()), null != t.text && (t.text = t.text.toString()), null == t._resultId && t.id && null != this.container && (t._resultId = this.generateResultId(this.container, t)), i.extend({}, e, t)
                        }, n.prototype.matches = function(t, e) {
                            return this.options.get("matcher")(t, e)
                        }, n
                    }), e.define("select2/data/array", ["./select", "../utils", "jquery"], function(t, e, i) {
                        function n(t, e) {
                            var i = e.get("data") || [];
                            n.__super__.constructor.call(this, t, e), this.addOptions(this.convertToOptions(i))
                        }
                        return e.Extend(n, t), n.prototype.select = function(t) {
                            var e = this.$element.find("option").filter(function(e, i) {
                                return i.value == t.id.toString()
                            });
                            0 === e.length && (e = this.option(t), this.addOptions(e)), n.__super__.select.call(this, t)
                        }, n.prototype.convertToOptions = function(t) {
                            for (var n = this, s = this.$element.find("option"), o = s.map(function() {
                                    return n.item(i(this)).id
                                }).get(), r = [], a = 0; a < t.length; a++) {
                                var l = this._normalizeItem(t[a]);
                                if (i.inArray(l.id, o) >= 0) {
                                    var h = s.filter(function(t) {
                                            return function() {
                                                return i(this).val() == t.id
                                            }
                                        }(l)),
                                        c = this.item(h),
                                        u = i.extend(!0, {}, l, c),
                                        d = this.option(u);
                                    h.replaceWith(d)
                                } else {
                                    var p = this.option(l);
                                    if (l.children) {
                                        var f = this.convertToOptions(l.children);
                                        e.appendMany(p, f)
                                    }
                                    r.push(p)
                                }
                            }
                            return r
                        }, n
                    }), e.define("select2/data/ajax", ["./array", "../utils", "jquery"], function(t, e, i) {
                        function n(t, e) {
                            this.ajaxOptions = this._applyDefaults(e.get("ajax")), null != this.ajaxOptions.processResults && (this.processResults = this.ajaxOptions.processResults), n.__super__.constructor.call(this, t, e)
                        }
                        return e.Extend(n, t), n.prototype._applyDefaults = function(t) {
                            var e = {
                                data: function(t) {
                                    return i.extend({}, t, {
                                        q: t.term
                                    })
                                },
                                transport: function(t, e, n) {
                                    var s = i.ajax(t);
                                    return s.then(e), s.fail(n), s
                                }
                            };
                            return i.extend({}, e, t, !0)
                        }, n.prototype.processResults = function(t) {
                            return t
                        }, n.prototype.query = function(t, e) {
                            function n() {
                                var n = o.transport(o, function(n) {
                                    var o = s.processResults(n, t);
                                    s.options.get("debug") && window.console && console.error && (o && o.results && i.isArray(o.results) || console.error("Select2: The AJAX results did not return an array in the `results` key of the response.")), e(o)
                                }, function() {
                                    n.status && "0" === n.status || s.trigger("results:message", {
                                        message: "errorLoading"
                                    })
                                });
                                s._request = n
                            }
                            var s = this;
                            null != this._request && (i.isFunction(this._request.abort) && this._request.abort(), this._request = null);
                            var o = i.extend({
                                type: "GET"
                            }, this.ajaxOptions);
                            "function" == typeof o.url && (o.url = o.url.call(this.$element, t)), "function" == typeof o.data && (o.data = o.data.call(this.$element, t)),
                                this.ajaxOptions.delay && null != t.term ? (this._queryTimeout && window.clearTimeout(this._queryTimeout), this._queryTimeout = window.setTimeout(n, this.ajaxOptions.delay)) : n()
                        }, n
                    }), e.define("select2/data/tags", ["jquery"], function(t) {
                        function e(e, i, n) {
                            var s = n.get("tags"),
                                o = n.get("createTag");
                            void 0 !== o && (this.createTag = o);
                            var r = n.get("insertTag");
                            if (void 0 !== r && (this.insertTag = r), e.call(this, i, n), t.isArray(s))
                                for (var a = 0; a < s.length; a++) {
                                    var l = s[a],
                                        h = this._normalizeItem(l),
                                        c = this.option(h);
                                    this.$element.append(c)
                                }
                        }
                        return e.prototype.query = function(t, e, i) {
                            function n(t, o) {
                                for (var r = t.results, a = 0; a < r.length; a++) {
                                    var l = r[a],
                                        h = null != l.children && !n({
                                            results: l.children
                                        }, !0);
                                    if (l.text === e.term || h) return !o && (t.data = r, void i(t))
                                }
                                if (o) return !0;
                                var c = s.createTag(e);
                                if (null != c) {
                                    var u = s.option(c);
                                    u.attr("data-select2-tag", !0), s.addOptions([u]), s.insertTag(r, c)
                                }
                                t.results = r, i(t)
                            }
                            var s = this;
                            return this._removeOldTags(), null == e.term || null != e.page ? void t.call(this, e, i) : void t.call(this, e, n)
                        }, e.prototype.createTag = function(e, i) {
                            var n = t.trim(i.term);
                            return "" === n ? null : {
                                id: n,
                                text: n
                            }
                        }, e.prototype.insertTag = function(t, e, i) {
                            e.unshift(i)
                        }, e.prototype._removeOldTags = function(e) {
                            (this._lastTag, this.$element.find("option[data-select2-tag]")).each(function() {
                                this.selected || t(this).remove()
                            })
                        }, e
                    }), e.define("select2/data/tokenizer", ["jquery"], function(t) {
                        function e(t, e, i) {
                            var n = i.get("tokenizer");
                            void 0 !== n && (this.tokenizer = n), t.call(this, e, i)
                        }
                        return e.prototype.bind = function(t, e, i) {
                            t.call(this, e, i), this.$search = e.dropdown.$search || e.selection.$search || i.find(".select2-search__field")
                        }, e.prototype.query = function(e, i, n) {
                            function s(e) {
                                var i = r._normalizeItem(e);
                                if (!r.$element.find("option").filter(function() {
                                        return t(this).val() === i.id
                                    }).length) {
                                    var n = r.option(i);
                                    n.attr("data-select2-tag", !0), r._removeOldTags(), r.addOptions([n])
                                }
                                o(i)
                            }

                            function o(t) {
                                r.trigger("select", {
                                    data: t
                                })
                            }
                            var r = this;
                            i.term = i.term || "";
                            var a = this.tokenizer(i, this.options, s);
                            a.term !== i.term && (this.$search.length && (this.$search.val(a.term), this.$search.focus()), i.term = a.term), e.call(this, i, n)
                        }, e.prototype.tokenizer = function(e, i, n, s) {
                            for (var o = n.get("tokenSeparators") || [], r = i.term, a = 0, l = this.createTag || function(t) {
                                    return {
                                        id: t.term,
                                        text: t.term
                                    }
                                }; a < r.length;) {
                                var h = r[a];
                                if (-1 !== t.inArray(h, o)) {
                                    var c = r.substr(0, a),
                                        u = t.extend({}, i, {
                                            term: c
                                        }),
                                        d = l(u);
                                    null != d ? (s(d), r = r.substr(a + 1) || "", a = 0) : a++
                                } else a++
                            }
                            return {
                                term: r
                            }
                        }, e
                    }), e.define("select2/data/minimumInputLength", [], function() {
                        function t(t, e, i) {
                            this.minimumInputLength = i.get("minimumInputLength"), t.call(this, e, i)
                        }
                        return t.prototype.query = function(t, e, i) {
                            return e.term = e.term || "", e.term.length < this.minimumInputLength ? void this.trigger("results:message", {
                                message: "inputTooShort",
                                args: {
                                    minimum: this.minimumInputLength,
                                    input: e.term,
                                    params: e
                                }
                            }) : void t.call(this, e, i)
                        }, t
                    }), e.define("select2/data/maximumInputLength", [], function() {
                        function t(t, e, i) {
                            this.maximumInputLength = i.get("maximumInputLength"), t.call(this, e, i)
                        }
                        return t.prototype.query = function(t, e, i) {
                            return e.term = e.term || "", this.maximumInputLength > 0 && e.term.length > this.maximumInputLength ? void this.trigger("results:message", {
                                message: "inputTooLong",
                                args: {
                                    maximum: this.maximumInputLength,
                                    input: e.term,
                                    params: e
                                }
                            }) : void t.call(this, e, i)
                        }, t
                    }), e.define("select2/data/maximumSelectionLength", [], function() {
                        function t(t, e, i) {
                            this.maximumSelectionLength = i.get("maximumSelectionLength"), t.call(this, e, i)
                        }
                        return t.prototype.query = function(t, e, i) {
                            var n = this;
                            this.current(function(s) {
                                var o = null != s ? s.length : 0;
                                return n.maximumSelectionLength > 0 && o >= n.maximumSelectionLength ? void n.trigger("results:message", {
                                    message: "maximumSelected",
                                    args: {
                                        maximum: n.maximumSelectionLength
                                    }
                                }) : void t.call(n, e, i)
                            })
                        }, t
                    }), e.define("select2/dropdown", ["jquery", "./utils"], function(t, e) {
                        function i(t, e) {
                            this.$element = t, this.options = e, i.__super__.constructor.call(this)
                        }
                        return e.Extend(i, e.Observable), i.prototype.render = function() {
                            var e = t('<span class="select2-dropdown"><span class="select2-results"></span></span>');
                            return e.attr("dir", this.options.get("dir")), this.$dropdown = e, e
                        }, i.prototype.bind = function() {}, i.prototype.position = function(t, e) {}, i.prototype.destroy = function() {
                            this.$dropdown.remove()
                        }, i
                    }), e.define("select2/dropdown/search", ["jquery", "../utils"], function(t, e) {
                        function i() {}
                        return i.prototype.render = function(e) {
                            var i = e.call(this),
                                n = t('<span class="select2-search select2-search--dropdown"><input class="select2-search__field" type="search" tabindex="-1" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" role="textbox" /></span>');
                            return this.$searchContainer = n, this.$search = n.find("input"), i.prepend(n), i
                        }, i.prototype.bind = function(e, i, n) {
                            var s = this;
                            e.call(this, i, n), this.$search.on("keydown", function(t) {
                                s.trigger("keypress", t), s._keyUpPrevented = t.isDefaultPrevented()
                            }), this.$search.on("input", function(e) {
                                t(this).off("keyup")
                            }), this.$search.on("keyup input", function(t) {
                                s.handleSearch(t)
                            }), i.on("open", function() {
                                s.$search.attr("tabindex", 0), s.$search.focus(), window.setTimeout(function() {
                                    s.$search.focus()
                                }, 0)
                            }), i.on("close", function() {
                                s.$search.attr("tabindex", -1), s.$search.val("")
                            }), i.on("focus", function() {
                                i.isOpen() && s.$search.focus()
                            }), i.on("results:all", function(t) {
                                if (null == t.query.term || "" === t.query.term) {
                                    s.showSearch(t) ? s.$searchContainer.removeClass("select2-search--hide") : s.$searchContainer.addClass("select2-search--hide")
                                }
                            })
                        }, i.prototype.handleSearch = function(t) {
                            if (!this._keyUpPrevented) {
                                var e = this.$search.val();
                                this.trigger("query", {
                                    term: e
                                })
                            }
                            this._keyUpPrevented = !1
                        }, i.prototype.showSearch = function(t, e) {
                            return !0
                        }, i
                    }), e.define("select2/dropdown/hidePlaceholder", [], function() {
                        function t(t, e, i, n) {
                            this.placeholder = this.normalizePlaceholder(i.get("placeholder")), t.call(this, e, i, n)
                        }
                        return t.prototype.append = function(t, e) {
                            e.results = this.removePlaceholder(e.results), t.call(this, e)
                        }, t.prototype.normalizePlaceholder = function(t, e) {
                            return "string" == typeof e && (e = {
                                id: "",
                                text: e
                            }), e
                        }, t.prototype.removePlaceholder = function(t, e) {
                            for (var i = e.slice(0), n = e.length - 1; n >= 0; n--) {
                                var s = e[n];
                                this.placeholder.id === s.id && i.splice(n, 1)
                            }
                            return i
                        }, t
                    }), e.define("select2/dropdown/infiniteScroll", ["jquery"], function(t) {
                        function e(t, e, i, n) {
                            this.lastParams = {}, t.call(this, e, i, n), this.$loadingMore = this.createLoadingMore(), this.loading = !1
                        }
                        return e.prototype.append = function(t, e) {
                            this.$loadingMore.remove(), this.loading = !1, t.call(this, e), this.showLoadingMore(e) && this.$results.append(this.$loadingMore)
                        }, e.prototype.bind = function(e, i, n) {
                            var s = this;
                            e.call(this, i, n), i.on("query", function(t) {
                                s.lastParams = t, s.loading = !0
                            }), i.on("query:append", function(t) {
                                s.lastParams = t, s.loading = !0
                            }), this.$results.on("scroll", function() {
                                var e = t.contains(document.documentElement, s.$loadingMore[0]);
                                if (!s.loading && e) {
                                    s.$results.offset().top + s.$results.outerHeight(!1) + 50 >= s.$loadingMore.offset().top + s.$loadingMore.outerHeight(!1) && s.loadMore()
                                }
                            })
                        }, e.prototype.loadMore = function() {
                            this.loading = !0;
                            var e = t.extend({}, {
                                page: 1
                            }, this.lastParams);
                            e.page++, this.trigger("query:append", e)
                        }, e.prototype.showLoadingMore = function(t, e) {
                            return e.pagination && e.pagination.more
                        }, e.prototype.createLoadingMore = function() {
                            var e = t('<li class="select2-results__option select2-results__option--load-more"role="treeitem" aria-disabled="true"></li>'),
                                i = this.options.get("translations").get("loadingMore");
                            return e.html(i(this.lastParams)), e
                        }, e
                    }), e.define("select2/dropdown/attachBody", ["jquery", "../utils"], function(t, e) {
                        function i(e, i, n) {
                            this.$dropdownParent = n.get("dropdownParent") || t(document.body), e.call(this, i, n)
                        }
                        return i.prototype.bind = function(t, e, i) {
                            var n = this,
                                s = !1;
                            t.call(this, e, i), e.on("open", function() {
                                n._showDropdown(), n._attachPositioningHandler(e), s || (s = !0, e.on("results:all", function() {
                                    n._positionDropdown(), n._resizeDropdown()
                                }), e.on("results:append", function() {
                                    n._positionDropdown(), n._resizeDropdown()
                                }))
                            }), e.on("close", function() {
                                n._hideDropdown(), n._detachPositioningHandler(e)
                            }), this.$dropdownContainer.on("mousedown", function(t) {
                                t.stopPropagation()
                            })
                        }, i.prototype.destroy = function(t) {
                            t.call(this), this.$dropdownContainer.remove()
                        }, i.prototype.position = function(t, e, i) {
                            e.attr("class", i.attr("class")), e.removeClass("select2"), e.addClass("select2-container--open"), e.css({
                                position: "absolute",
                                top: -999999
                            }), this.$container = i
                        }, i.prototype.render = function(e) {
                            var i = t("<span></span>"),
                                n = e.call(this);
                            return i.append(n), this.$dropdownContainer = i, i
                        }, i.prototype._hideDropdown = function(t) {
                            this.$dropdownContainer.detach()
                        }, i.prototype._attachPositioningHandler = function(i, n) {
                            var s = this,
                                o = "scroll.select2." + n.id,
                                r = "resize.select2." + n.id,
                                a = "orientationchange.select2." + n.id,
                                l = this.$container.parents().filter(e.hasScroll);
                            l.each(function() {
                                t(this).data("select2-scroll-position", {
                                    x: t(this).scrollLeft(),
                                    y: t(this).scrollTop()
                                })
                            }), l.on(o, function(e) {
                                var i = t(this).data("select2-scroll-position");
                                t(this).scrollTop(i.y)
                            }), t(window).on(o + " " + r + " " + a, function(t) {
                                s._positionDropdown(), s._resizeDropdown()
                            })
                        }, i.prototype._detachPositioningHandler = function(i, n) {
                            var s = "scroll.select2." + n.id,
                                o = "resize.select2." + n.id,
                                r = "orientationchange.select2." + n.id;
                            this.$container.parents().filter(e.hasScroll).off(s), t(window).off(s + " " + o + " " + r)
                        }, i.prototype._positionDropdown = function() {
                            var e = t(window),
                                i = this.$dropdown.hasClass("select2-dropdown--above"),
                                n = this.$dropdown.hasClass("select2-dropdown--below"),
                                s = null,
                                o = this.$container.offset();
                            o.bottom = o.top + this.$container.outerHeight(!1);
                            var r = {
                                height: this.$container.outerHeight(!1)
                            };
                            r.top = o.top, r.bottom = o.top + r.height;
                            var a = {
                                    height: this.$dropdown.outerHeight(!1)
                                },
                                l = {
                                    top: e.scrollTop(),
                                    bottom: e.scrollTop() + e.height()
                                },
                                h = l.top < o.top - a.height,
                                c = l.bottom > o.bottom + a.height,
                                u = {
                                    left: o.left,
                                    top: r.bottom
                                },
                                d = this.$dropdownParent;
                            "static" === d.css("position") && (d = d.offsetParent());
                            var p = d.offset();
                            u.top -= p.top, u.left -= p.left, i || n || (s = "below"), c || !h || i ? !h && c && i && (s = "below") : s = "above", ("above" == s || i && "below" !== s) && (u.top = r.top - p.top - a.height), null != s && (this.$dropdown.removeClass("select2-dropdown--below select2-dropdown--above").addClass("select2-dropdown--" + s), this.$container.removeClass("select2-container--below select2-container--above").addClass("select2-container--" + s)), this.$dropdownContainer.css(u)
                        }, i.prototype._resizeDropdown = function() {
                            var t = {
                                width: this.$container.outerWidth(!1) + "px"
                            };
                            this.options.get("dropdownAutoWidth") && (t.minWidth = t.width, t.position = "relative", t.width = "auto"), this.$dropdown.css(t)
                        }, i.prototype._showDropdown = function(t) {
                            this.$dropdownContainer.appendTo(this.$dropdownParent), this._positionDropdown(), this._resizeDropdown()
                        }, i
                    }), e.define("select2/dropdown/minimumResultsForSearch", [], function() {
                        function t(e) {
                            for (var i = 0, n = 0; n < e.length; n++) {
                                var s = e[n];
                                s.children ? i += t(s.children) : i++
                            }
                            return i
                        }

                        function e(t, e, i, n) {
                            this.minimumResultsForSearch = i.get("minimumResultsForSearch"), this.minimumResultsForSearch < 0 && (this.minimumResultsForSearch = 1 / 0), t.call(this, e, i, n)
                        }
                        return e.prototype.showSearch = function(e, i) {
                            return !(t(i.data.results) < this.minimumResultsForSearch) && e.call(this, i)
                        }, e
                    }), e.define("select2/dropdown/selectOnClose", [], function() {
                        function t() {}
                        return t.prototype.bind = function(t, e, i) {
                            var n = this;
                            t.call(this, e, i), e.on("close", function(t) {
                                n._handleSelectOnClose(t)
                            })
                        }, t.prototype._handleSelectOnClose = function(t, e) {
                            if (e && null != e.originalSelect2Event) {
                                var i = e.originalSelect2Event;
                                if ("select" === i._type || "unselect" === i._type) return
                            }
                            var n = this.getHighlightedResults();
                            if (!(n.length < 1)) {
                                var s = n.data("data");
                                null != s.element && s.element.selected || null == s.element && s.selected || this.trigger("select", {
                                    data: s
                                })
                            }
                        }, t
                    }), e.define("select2/dropdown/closeOnSelect", [], function() {
                        function t() {}
                        return t.prototype.bind = function(t, e, i) {
                            var n = this;
                            t.call(this, e, i), e.on("select", function(t) {
                                n._selectTriggered(t)
                            }), e.on("unselect", function(t) {
                                n._selectTriggered(t)
                            })
                        }, t.prototype._selectTriggered = function(t, e) {
                            var i = e.originalEvent;
                            i && i.ctrlKey || this.trigger("close", {
                                originalEvent: i,
                                originalSelect2Event: e
                            })
                        }, t
                    }), e.define("select2/i18n/en", [], function() {
                        return {
                            errorLoading: function() {
                                return "The results could not be loaded."
                            },
                            inputTooLong: function(t) {
                                var e = t.input.length - t.maximum,
                                    i = "Please delete " + e + " character";
                                return 1 != e && (i += "s"), i
                            },
                            inputTooShort: function(t) {
                                return "Please enter " + (t.minimum - t.input.length) + " or more characters"
                            },
                            loadingMore: function() {
                                return "Loading more results…"
                            },
                            maximumSelected: function(t) {
                                var e = "You can only select " + t.maximum + " item";
                                return 1 != t.maximum && (e += "s"), e
                            },
                            noResults: function() {
                                return "No results found"
                            },
                            searching: function() {
                                return "Searching…"
                            }
                        }
                    }), e.define("select2/defaults", ["jquery", "require", "./results", "./selection/single", "./selection/multiple", "./selection/placeholder", "./selection/allowClear", "./selection/search", "./selection/eventRelay", "./utils", "./translation", "./diacritics", "./data/select", "./data/array", "./data/ajax", "./data/tags", "./data/tokenizer", "./data/minimumInputLength", "./data/maximumInputLength", "./data/maximumSelectionLength", "./dropdown", "./dropdown/search", "./dropdown/hidePlaceholder", "./dropdown/infiniteScroll", "./dropdown/attachBody", "./dropdown/minimumResultsForSearch", "./dropdown/selectOnClose", "./dropdown/closeOnSelect", "./i18n/en"], function(t, e, i, n, s, o, r, a, l, h, c, u, d, p, f, g, m, v, y, b, _, w, x, C, k, T, $, D, S) {
                        function A() {
                            this.reset()
                        }
                        return A.prototype.apply = function(u) {
                            if (u = t.extend(!0, {}, this.defaults, u), null == u.dataAdapter) {
                                if (null != u.ajax ? u.dataAdapter = f : null != u.data ? u.dataAdapter = p : u.dataAdapter = d, u.minimumInputLength > 0 && (u.dataAdapter = h.Decorate(u.dataAdapter, v)), u.maximumInputLength > 0 && (u.dataAdapter = h.Decorate(u.dataAdapter, y)), u.maximumSelectionLength > 0 && (u.dataAdapter = h.Decorate(u.dataAdapter, b)), u.tags && (u.dataAdapter = h.Decorate(u.dataAdapter, g)), (null != u.tokenSeparators || null != u.tokenizer) && (u.dataAdapter = h.Decorate(u.dataAdapter, m)), null != u.query) {
                                    var S = e(u.amdBase + "compat/query");
                                    u.dataAdapter = h.Decorate(u.dataAdapter, S)
                                }
                                if (null != u.initSelection) {
                                    var A = e(u.amdBase + "compat/initSelection");
                                    u.dataAdapter = h.Decorate(u.dataAdapter, A)
                                }
                            }
                            if (null == u.resultsAdapter && (u.resultsAdapter = i, null != u.ajax && (u.resultsAdapter = h.Decorate(u.resultsAdapter, C)), null != u.placeholder && (u.resultsAdapter = h.Decorate(u.resultsAdapter, x)), u.selectOnClose && (u.resultsAdapter = h.Decorate(u.resultsAdapter, $))), null == u.dropdownAdapter) {
                                if (u.multiple) u.dropdownAdapter = _;
                                else {
                                    var E = h.Decorate(_, w);
                                    u.dropdownAdapter = E
                                }
                                if (0 !== u.minimumResultsForSearch && (u.dropdownAdapter = h.Decorate(u.dropdownAdapter, T)), u.closeOnSelect && (u.dropdownAdapter = h.Decorate(u.dropdownAdapter, D)), null != u.dropdownCssClass || null != u.dropdownCss || null != u.adaptDropdownCssClass) {
                                    var I = e(u.amdBase + "compat/dropdownCss");
                                    u.dropdownAdapter = h.Decorate(u.dropdownAdapter, I)
                                }
                                u.dropdownAdapter = h.Decorate(u.dropdownAdapter, k)
                            }
                            if (null == u.selectionAdapter) {
                                if (u.multiple ? u.selectionAdapter = s : u.selectionAdapter = n, null != u.placeholder && (u.selectionAdapter = h.Decorate(u.selectionAdapter, o)), u.allowClear && (u.selectionAdapter = h.Decorate(u.selectionAdapter, r)), u.multiple && (u.selectionAdapter = h.Decorate(u.selectionAdapter, a)), null != u.containerCssClass || null != u.containerCss || null != u.adaptContainerCssClass) {
                                    var P = e(u.amdBase + "compat/containerCss");
                                    u.selectionAdapter = h.Decorate(u.selectionAdapter, P)
                                }
                                u.selectionAdapter = h.Decorate(u.selectionAdapter, l)
                            }
                            if ("string" == typeof u.language)
                                if (u.language.indexOf("-") > 0) {
                                    var N = u.language.split("-"),
                                        M = N[0];
                                    u.language = [u.language, M]
                                } else u.language = [u.language];
                            if (t.isArray(u.language)) {
                                var O = new c;
                                u.language.push("en");
                                for (var H = u.language, j = 0; j < H.length; j++) {
                                    var z = H[j],
                                        L = {};
                                    try {
                                        L = c.loadPath(z)
                                    } catch (t) {
                                        try {
                                            z = this.defaults.amdLanguageBase + z, L = c.loadPath(z)
                                        } catch (t) {
                                            u.debug && window.console && console.warn && console.warn('Select2: The language file for "' + z + '" could not be automatically loaded. A fallback will be used instead.');
                                            continue
                                        }
                                    }
                                    O.extend(L)
                                }
                                u.translations = O
                            } else {
                                var R = c.loadPath(this.defaults.amdLanguageBase + "en"),
                                    W = new c(u.language);
                                W.extend(R), u.translations = W
                            }
                            return u
                        }, A.prototype.reset = function() {
                            function e(t) {
                                function e(t) {
                                    return u[t] || t
                                }
                                return t.replace(/[^\u0000-\u007E]/g, e)
                            }

                            function i(n, s) {
                                if ("" === t.trim(n.term)) return s;
                                if (s.children && s.children.length > 0) {
                                    for (var o = t.extend(!0, {}, s), r = s.children.length - 1; r >= 0; r--) {
                                        null == i(n, s.children[r]) && o.children.splice(r, 1)
                                    }
                                    return o.children.length > 0 ? o : i(n, o)
                                }
                                var a = e(s.text).toUpperCase(),
                                    l = e(n.term).toUpperCase();
                                return a.indexOf(l) > -1 ? s : null
                            }
                            this.defaults = {
                                amdBase: "./",
                                amdLanguageBase: "./i18n/",
                                closeOnSelect: !0,
                                debug: !1,
                                dropdownAutoWidth: !1,
                                escapeMarkup: h.escapeMarkup,
                                language: S,
                                matcher: i,
                                minimumInputLength: 0,
                                maximumInputLength: 0,
                                maximumSelectionLength: 0,
                                minimumResultsForSearch: 0,
                                selectOnClose: !1,
                                sorter: function(t) {
                                    return t
                                },
                                templateResult: function(t) {
                                    return t.text
                                },
                                templateSelection: function(t) {
                                    return t.text
                                },
                                theme: "default",
                                width: "resolve"
                            }
                        }, A.prototype.set = function(e, i) {
                            var n = t.camelCase(e),
                                s = {};
                            s[n] = i;
                            var o = h._convertData(s);
                            t.extend(this.defaults, o)
                        }, new A
                    }), e.define("select2/options", ["require", "jquery", "./defaults", "./utils"], function(t, e, i, n) {
                        function s(e, s) {
                            if (this.options = e, null != s && this.fromElement(s), this.options = i.apply(this.options), s && s.is("input")) {
                                var o = t(this.get("amdBase") + "compat/inputData");
                                this.options.dataAdapter = n.Decorate(this.options.dataAdapter, o)
                            }
                        }
                        return s.prototype.fromElement = function(t) {
                            var i = ["select2"];
                            null == this.options.multiple && (this.options.multiple = t.prop("multiple")), null == this.options.disabled && (this.options.disabled = t.prop("disabled")), null == this.options.language && (t.prop("lang") ? this.options.language = t.prop("lang").toLowerCase() : t.closest("[lang]").prop("lang") && (this.options.language = t.closest("[lang]").prop("lang"))), null == this.options.dir && (t.prop("dir") ? this.options.dir = t.prop("dir") : t.closest("[dir]").prop("dir") ? this.options.dir = t.closest("[dir]").prop("dir") : this.options.dir = "ltr"), t.prop("disabled", this.options.disabled), t.prop("multiple", this.options.multiple), t.data("select2Tags") && (this.options.debug && window.console && console.warn && console.warn('Select2: The `data-select2-tags` attribute has been changed to use the `data-data` and `data-tags="true"` attributes and will be removed in future versions of Select2.'), t.data("data", t.data("select2Tags")), t.data("tags", !0)), t.data("ajaxUrl") && (this.options.debug && window.console && console.warn && console.warn("Select2: The `data-ajax-url` attribute has been changed to `data-ajax--url` and support for the old attribute will be removed in future versions of Select2."), t.attr("ajax--url", t.data("ajaxUrl")), t.data("ajax--url", t.data("ajaxUrl")));
                            var s = {};
                            s = e.fn.jquery && "1." == e.fn.jquery.substr(0, 2) && t[0].dataset ? e.extend(!0, {}, t[0].dataset, t.data()) : t.data();
                            var o = e.extend(!0, {}, s);
                            o = n._convertData(o);
                            for (var r in o) e.inArray(r, i) > -1 || (e.isPlainObject(this.options[r]) ? e.extend(this.options[r], o[r]) : this.options[r] = o[r]);
                            return this
                        }, s.prototype.get = function(t) {
                            return this.options[t]
                        }, s.prototype.set = function(t, e) {
                            this.options[t] = e
                        }, s
                    }), e.define("select2/core", ["jquery", "./options", "./utils", "./keys"], function(t, e, i, n) {
                        var s = function(t, i) {
                            null != t.data("select2") && t.data("select2").destroy(), this.$element = t, this.id = this._generateId(t), i = i || {}, this.options = new e(i, t), s.__super__.constructor.call(this);
                            var n = t.attr("tabindex") || 0;
                            t.data("old-tabindex", n), t.attr("tabindex", "-1");
                            var o = this.options.get("dataAdapter");
                            this.dataAdapter = new o(t, this.options);
                            var r = this.render();
                            this._placeContainer(r);
                            var a = this.options.get("selectionAdapter");
                            this.selection = new a(t, this.options), this.$selection = this.selection.render(), this.selection.position(this.$selection, r);
                            var l = this.options.get("dropdownAdapter");
                            this.dropdown = new l(t, this.options), this.$dropdown = this.dropdown.render(), this.dropdown.position(this.$dropdown, r);
                            var h = this.options.get("resultsAdapter");
                            this.results = new h(t, this.options, this.dataAdapter), this.$results = this.results.render(), this.results.position(this.$results, this.$dropdown);
                            var c = this;
                            this._bindAdapters(), this._registerDomEvents(), this._registerDataEvents(), this._registerSelectionEvents(), this._registerDropdownEvents(), this._registerResultsEvents(), this._registerEvents(), this.dataAdapter.current(function(t) {
                                c.trigger("selection:update", {
                                    data: t
                                })
                            }), t.addClass("select2-hidden-accessible"), t.attr("aria-hidden", "true"), this._syncAttributes(), t.data("select2", this)
                        };
                        return i.Extend(s, i.Observable), s.prototype._generateId = function(t) {
                            var e = "";
                            return e = null != t.attr("id") ? t.attr("id") : null != t.attr("name") ? t.attr("name") + "-" + i.generateChars(2) : i.generateChars(4), e = e.replace(/(:|\.|\[|\]|,)/g, ""), e = "select2-" + e
                        }, s.prototype._placeContainer = function(t) {
                            t.insertAfter(this.$element);
                            var e = this._resolveWidth(this.$element, this.options.get("width"));
                            null != e && t.css("width", e)
                        }, s.prototype._resolveWidth = function(t, e) {
                            var i = /^width:(([-+]?([0-9]*\.)?[0-9]+)(px|em|ex|%|in|cm|mm|pt|pc))/i;
                            if ("resolve" == e) {
                                var n = this._resolveWidth(t, "style");
                                return null != n ? n : this._resolveWidth(t, "element")
                            }
                            if ("element" == e) {
                                var s = t.outerWidth(!1);
                                return 0 >= s ? "auto" : s + "px"
                            }
                            if ("style" == e) {
                                var o = t.attr("style");
                                if ("string" != typeof o) return null;
                                for (var r = o.split(";"), a = 0, l = r.length; l > a; a += 1) {
                                    var h = r[a].replace(/\s/g, ""),
                                        c = h.match(i);
                                    if (null !== c && c.length >= 1) return c[1]
                                }
                                return null
                            }
                            return e
                        }, s.prototype._bindAdapters = function() {
                            this.dataAdapter.bind(this, this.$container), this.selection.bind(this, this.$container), this.dropdown.bind(this, this.$container), this.results.bind(this, this.$container)
                        }, s.prototype._registerDomEvents = function() {
                            var e = this;
                            this.$element.on("change.select2", function() {
                                e.dataAdapter.current(function(t) {
                                    e.trigger("selection:update", {
                                        data: t
                                    })
                                })
                            }), this.$element.on("focus.select2", function(t) {
                                e.trigger("focus", t)
                            }), this._syncA = i.bind(this._syncAttributes, this), this._syncS = i.bind(this._syncSubtree, this), this.$element[0].attachEvent && this.$element[0].attachEvent("onpropertychange", this._syncA);
                            var n = window.MutationObserver || window.WebKitMutationObserver || window.MozMutationObserver;
                            null != n ? (this._observer = new n(function(i) {
                                t.each(i, e._syncA), t.each(i, e._syncS)
                            }), this._observer.observe(this.$element[0], {
                                attributes: !0,
                                childList: !0,
                                subtree: !1
                            })) : this.$element[0].addEventListener && (this.$element[0].addEventListener("DOMAttrModified", e._syncA, !1), this.$element[0].addEventListener("DOMNodeInserted", e._syncS, !1), this.$element[0].addEventListener("DOMNodeRemoved", e._syncS, !1))
                        }, s.prototype._registerDataEvents = function() {
                            var t = this;
                            this.dataAdapter.on("*", function(e, i) {
                                t.trigger(e, i)
                            })
                        }, s.prototype._registerSelectionEvents = function() {
                            var e = this,
                                i = ["toggle", "focus"];
                            this.selection.on("toggle", function() {
                                e.toggleDropdown()
                            }), this.selection.on("focus", function(t) {
                                e.focus(t)
                            }), this.selection.on("*", function(n, s) {
                                -1 === t.inArray(n, i) && e.trigger(n, s)
                            })
                        }, s.prototype._registerDropdownEvents = function() {
                            var t = this;
                            this.dropdown.on("*", function(e, i) {
                                t.trigger(e, i)
                            })
                        }, s.prototype._registerResultsEvents = function() {
                            var t = this;
                            this.results.on("*", function(e, i) {
                                t.trigger(e, i)
                            })
                        }, s.prototype._registerEvents = function() {
                            var t = this;
                            this.on("open", function() {
                                t.$container.addClass("select2-container--open")
                            }), this.on("close", function() {
                                t.$container.removeClass("select2-container--open")
                            }), this.on("enable", function() {
                                t.$container.removeClass("select2-container--disabled")
                            }), this.on("disable", function() {
                                t.$container.addClass("select2-container--disabled")
                            }), this.on("blur", function() {
                                t.$container.removeClass("select2-container--focus")
                            }), this.on("query", function(e) {
                                t.isOpen() || t.trigger("open", {}), this.dataAdapter.query(e, function(i) {
                                    t.trigger("results:all", {
                                        data: i,
                                        query: e
                                    })
                                })
                            }), this.on("query:append", function(e) {
                                this.dataAdapter.query(e, function(i) {
                                    t.trigger("results:append", {
                                        data: i,
                                        query: e
                                    })
                                })
                            }), this.on("keypress", function(e) {
                                var i = e.which;
                                t.isOpen() ? i === n.ESC || i === n.TAB || i === n.UP && e.altKey ? (t.close(), e.preventDefault()) : i === n.ENTER ? (t.trigger("results:select", {}), e.preventDefault()) : i === n.SPACE && e.ctrlKey ? (t.trigger("results:toggle", {}), e.preventDefault()) : i === n.UP ? (t.trigger("results:previous", {}), e.preventDefault()) : i === n.DOWN && (t.trigger("results:next", {}), e.preventDefault()) : (i === n.ENTER || i === n.SPACE || i === n.DOWN && e.altKey) && (t.open(), e.preventDefault())
                            })
                        }, s.prototype._syncAttributes = function() {
                            this.options.set("disabled", this.$element.prop("disabled")), this.options.get("disabled") ? (this.isOpen() && this.close(), this.trigger("disable", {})) : this.trigger("enable", {})
                        }, s.prototype._syncSubtree = function(t, e) {
                            var i = !1,
                                n = this;
                            if (!t || !t.target || "OPTION" === t.target.nodeName || "OPTGROUP" === t.target.nodeName) {
                                if (e)
                                    if (e.addedNodes && e.addedNodes.length > 0)
                                        for (var s = 0; s < e.addedNodes.length; s++) {
                                            var o = e.addedNodes[s];
                                            o.selected && (i = !0)
                                        } else e.removedNodes && e.removedNodes.length > 0 && (i = !0);
                                    else i = !0;
                                i && this.dataAdapter.current(function(t) {
                                    n.trigger("selection:update", {
                                        data: t
                                    })
                                })
                            }
                        }, s.prototype.trigger = function(t, e) {
                            var i = s.__super__.trigger,
                                n = {
                                    open: "opening",
                                    close: "closing",
                                    select: "selecting",
                                    unselect: "unselecting"
                                };
                            if (void 0 === e && (e = {}), t in n) {
                                var o = n[t],
                                    r = {
                                        prevented: !1,
                                        name: t,
                                        args: e
                                    };
                                if (i.call(this, o, r), r.prevented) return void(e.prevented = !0)
                            }
                            i.call(this, t, e)
                        }, s.prototype.toggleDropdown = function() {
                            this.options.get("disabled") || (this.isOpen() ? this.close() : this.open())
                        }, s.prototype.open = function() {
                            this.isOpen() || this.trigger("query", {})
                        }, s.prototype.close = function() {
                            this.isOpen() && this.trigger("close", {})
                        }, s.prototype.isOpen = function() {
                            return this.$container.hasClass("select2-container--open")
                        }, s.prototype.hasFocus = function() {
                            return this.$container.hasClass("select2-container--focus")
                        }, s.prototype.focus = function(t) {
                            this.hasFocus() || (this.$container.addClass("select2-container--focus"), this.trigger("focus", {}))
                        }, s.prototype.enable = function(t) {
                            this.options.get("debug") && window.console && console.warn && console.warn('Select2: The `select2("enable")` method has been deprecated and will be removed in later Select2 versions. Use $element.prop("disabled") instead.'), (null == t || 0 === t.length) && (t = [!0]);
                            var e = !t[0];
                            this.$element.prop("disabled", e)
                        }, s.prototype.data = function() {
                            this.options.get("debug") && arguments.length > 0 && window.console && console.warn && console.warn('Select2: Data can no longer be set using `select2("data")`. You should consider setting the value instead using `$element.val()`.');
                            var t = [];
                            return this.dataAdapter.current(function(e) {
                                t = e
                            }), t
                        }, s.prototype.val = function(e) {
                            if (this.options.get("debug") && window.console && console.warn && console.warn('Select2: The `select2("val")` method has been deprecated and will be removed in later Select2 versions. Use $element.val() instead.'), null == e || 0 === e.length) return this.$element.val();
                            var i = e[0];
                            t.isArray(i) && (i = t.map(i, function(t) {
                                return t.toString()
                            })), this.$element.val(i).trigger("change")
                        }, s.prototype.destroy = function() {
                            this.$container.remove(), this.$element[0].detachEvent && this.$element[0].detachEvent("onpropertychange", this._syncA), null != this._observer ? (this._observer.disconnect(), this._observer = null) : this.$element[0].removeEventListener && (this.$element[0].removeEventListener("DOMAttrModified", this._syncA, !1), this.$element[0].removeEventListener("DOMNodeInserted", this._syncS, !1), this.$element[0].removeEventListener("DOMNodeRemoved", this._syncS, !1)), this._syncA = null, this._syncS = null, this.$element.off(".select2"), this.$element.attr("tabindex", this.$element.data("old-tabindex")), this.$element.removeClass("select2-hidden-accessible"), this.$element.attr("aria-hidden", "false"), this.$element.removeData("select2"), this.dataAdapter.destroy(), this.selection.destroy(), this.dropdown.destroy(), this.results.destroy(), this.dataAdapter = null, this.selection = null, this.dropdown = null, this.results = null
                        }, s.prototype.render = function() {
                            var e = t('<span class="select2 select2-container"><span class="selection"></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>');
                            return e.attr("dir", this.options.get("dir")), this.$container = e, this.$container.addClass("select2-container--" + this.options.get("theme")), e.data("element", this.$element), e
                        }, s
                    }), e.define("select2/compat/utils", ["jquery"], function(t) {
                        function e(e, i, n) {
                            var s, o, r = [];
                            s = t.trim(e.attr("class")), s && (s = "" + s, t(s.split(/\s+/)).each(function() {
                                0 === this.indexOf("select2-") && r.push(this)
                            })), s = t.trim(i.attr("class")), s && (s = "" + s, t(s.split(/\s+/)).each(function() {
                                0 !== this.indexOf("select2-") && null != (o = n(this)) && r.push(o)
                            })), e.attr("class", r.join(" "))
                        }
                        return {
                            syncCssClasses: e
                        }
                    }), e.define("select2/compat/containerCss", ["jquery", "./utils"], function(t, e) {
                        function i(t) {
                            return null
                        }

                        function n() {}
                        return n.prototype.render = function(n) {
                            var s = n.call(this),
                                o = this.options.get("containerCssClass") || "";
                            t.isFunction(o) && (o = o(this.$element));
                            var r = this.options.get("adaptContainerCssClass");
                            if (r = r || i, -1 !== o.indexOf(":all:")) {
                                o = o.replace(":all:", "");
                                var a = r;
                                r = function(t) {
                                    var e = a(t);
                                    return null != e ? e + " " + t : t
                                }
                            }
                            var l = this.options.get("containerCss") || {};
                            return t.isFunction(l) && (l = l(this.$element)), e.syncCssClasses(s, this.$element, r), s.css(l), s.addClass(o), s
                        }, n
                    }), e.define("select2/compat/dropdownCss", ["jquery", "./utils"], function(t, e) {
                        function i(t) {
                            return null
                        }

                        function n() {}
                        return n.prototype.render = function(n) {
                            var s = n.call(this),
                                o = this.options.get("dropdownCssClass") || "";
                            t.isFunction(o) && (o = o(this.$element));
                            var r = this.options.get("adaptDropdownCssClass");
                            if (r = r || i, -1 !== o.indexOf(":all:")) {
                                o = o.replace(":all:", "");
                                var a = r;
                                r = function(t) {
                                    var e = a(t);
                                    return null != e ? e + " " + t : t
                                }
                            }
                            var l = this.options.get("dropdownCss") || {};
                            return t.isFunction(l) && (l = l(this.$element)), e.syncCssClasses(s, this.$element, r), s.css(l), s.addClass(o), s
                        }, n
                    }), e.define("select2/compat/initSelection", ["jquery"], function(t) {
                        function e(t, e, i) {
                            i.get("debug") && window.console && console.warn && console.warn("Select2: The `initSelection` option has been deprecated in favor of a custom data adapter that overrides the `current` method. This method is now called multiple times instead of a single time when the instance is initialized. Support will be removed for the `initSelection` option in future versions of Select2"), this.initSelection = i.get("initSelection"), this._isInitialized = !1, t.call(this, e, i)
                        }
                        return e.prototype.current = function(e, i) {
                            var n = this;
                            return this._isInitialized ? void e.call(this, i) : void this.initSelection.call(null, this.$element, function(e) {
                                n._isInitialized = !0, t.isArray(e) || (e = [e]), i(e)
                            })
                        }, e
                    }), e.define("select2/compat/inputData", ["jquery"], function(t) {
                        function e(t, e, i) {
                            this._currentData = [], this._valueSeparator = i.get("valueSeparator") || ",", "hidden" === e.prop("type") && i.get("debug") && console && console.warn && console.warn("Select2: Using a hidden input with Select2 is no longer supported and may stop working in the future. It is recommended to use a `<select>` element instead."), t.call(this, e, i)
                        }
                        return e.prototype.current = function(e, i) {
                            function n(e, i) {
                                var s = [];
                                return e.selected || -1 !== t.inArray(e.id, i) ? (e.selected = !0, s.push(e)) : e.selected = !1, e.children && s.push.apply(s, n(e.children, i)), s
                            }
                            for (var s = [], o = 0; o < this._currentData.length; o++) {
                                var r = this._currentData[o];
                                s.push.apply(s, n(r, this.$element.val().split(this._valueSeparator)))
                            }
                            i(s)
                        }, e.prototype.select = function(e, i) {
                            if (this.options.get("multiple")) {
                                var n = this.$element.val();
                                n += this._valueSeparator + i.id, this.$element.val(n), this.$element.trigger("change")
                            } else this.current(function(e) {
                                t.map(e, function(t) {
                                    t.selected = !1
                                })
                            }), this.$element.val(i.id), this.$element.trigger("change")
                        }, e.prototype.unselect = function(t, e) {
                            var i = this;
                            e.selected = !1, this.current(function(t) {
                                for (var n = [], s = 0; s < t.length; s++) {
                                    var o = t[s];
                                    e.id != o.id && n.push(o.id)
                                }
                                i.$element.val(n.join(i._valueSeparator)), i.$element.trigger("change")
                            })
                        }, e.prototype.query = function(t, e, i) {
                            for (var n = [], s = 0; s < this._currentData.length; s++) {
                                var o = this._currentData[s],
                                    r = this.matches(e, o);
                                null !== r && n.push(r)
                            }
                            i({
                                results: n
                            })
                        }, e.prototype.addOptions = function(e, i) {
                            var n = t.map(i, function(e) {
                                return t.data(e[0], "data")
                            });
                            this._currentData.push.apply(this._currentData, n)
                        }, e
                    }), e.define("select2/compat/matcher", ["jquery"], function(t) {
                        function e(e) {
                            function i(i, n) {
                                var s = t.extend(!0, {}, n);
                                if (null == i.term || "" === t.trim(i.term)) return s;
                                if (n.children) {
                                    for (var o = n.children.length - 1; o >= 0; o--) {
                                        var r = n.children[o];
                                        e(i.term, r.text, r) || s.children.splice(o, 1)
                                    }
                                    if (s.children.length > 0) return s
                                }
                                return e(i.term, n.text, n) ? s : null
                            }
                            return i
                        }
                        return e
                    }), e.define("select2/compat/query", [], function() {
                        function t(t, e, i) {
                            i.get("debug") && window.console && console.warn && console.warn("Select2: The `query` option has been deprecated in favor of a custom data adapter that overrides the `query` method. Support will be removed for the `query` option in future versions of Select2."), t.call(this, e, i)
                        }
                        return t.prototype.query = function(t, e, i) {
                            e.callback = i, this.options.get("query").call(null, e)
                        }, t
                    }), e.define("select2/dropdown/attachContainer", [], function() {
                        function t(t, e, i) {
                            t.call(this, e, i)
                        }
                        return t.prototype.position = function(t, e, i) {
                            i.find(".dropdown-wrapper").append(e), e.addClass("select2-dropdown--below"), i.addClass("select2-container--below")
                        }, t
                    }), e.define("select2/dropdown/stopPropagation", [], function() {
                        function t() {}
                        return t.prototype.bind = function(t, e, i) {
                            t.call(this, e, i);
                            var n = ["blur", "change", "click", "dblclick", "focus", "focusin", "focusout", "input", "keydown", "keyup", "keypress", "mousedown", "mouseenter", "mouseleave", "mousemove", "mouseover", "mouseup", "search", "touchend", "touchstart"];
                            this.$dropdown.on(n.join(" "), function(t) {
                                t.stopPropagation()
                            })
                        }, t
                    }), e.define("select2/selection/stopPropagation", [], function() {
                        function t() {}
                        return t.prototype.bind = function(t, e, i) {
                            t.call(this, e, i);
                            var n = ["blur", "change", "click", "dblclick", "focus", "focusin", "focusout", "input", "keydown", "keyup", "keypress", "mousedown", "mouseenter", "mouseleave", "mousemove", "mouseover", "mouseup", "search", "touchend", "touchstart"];
                            this.$selection.on(n.join(" "), function(t) {
                                t.stopPropagation()
                            })
                        }, t
                    }),
                    function(i) {
                        "function" == typeof e.define && e.define.amd ? e.define("jquery-mousewheel", ["jquery"], i) : "object" == typeof exports ? module.exports = i : i(t)
                    }(function(t) {
                        function e(e) {
                            var r = e || window.event,
                                a = l.call(arguments, 1),
                                h = 0,
                                u = 0,
                                d = 0,
                                p = 0,
                                f = 0,
                                g = 0;
                            if (e = t.event.fix(r), e.type = "mousewheel", "detail" in r && (d = -1 * r.detail), "wheelDelta" in r && (d = r.wheelDelta), "wheelDeltaY" in r && (d = r.wheelDeltaY), "wheelDeltaX" in r && (u = -1 * r.wheelDeltaX), "axis" in r && r.axis === r.HORIZONTAL_AXIS && (u = -1 * d, d = 0), h = 0 === d ? u : d, "deltaY" in r && (d = -1 * r.deltaY, h = d), "deltaX" in r && (u = r.deltaX, 0 === d && (h = -1 * u)), 0 !== d || 0 !== u) {
                                if (1 === r.deltaMode) {
                                    var m = t.data(this, "mousewheel-line-height");
                                    h *= m, d *= m, u *= m
                                } else if (2 === r.deltaMode) {
                                    var v = t.data(this, "mousewheel-page-height");
                                    h *= v, d *= v, u *= v
                                }
                                if (p = Math.max(Math.abs(d), Math.abs(u)), (!o || o > p) && (o = p, n(r, p) && (o /= 40)), n(r, p) && (h /= 40, u /= 40, d /= 40), h = Math[h >= 1 ? "floor" : "ceil"](h / o), u = Math[u >= 1 ? "floor" : "ceil"](u / o), d = Math[d >= 1 ? "floor" : "ceil"](d / o), c.settings.normalizeOffset && this.getBoundingClientRect) {
                                    var y = this.getBoundingClientRect();
                                    f = e.clientX - y.left, g = e.clientY - y.top
                                }
                                return e.deltaX = u, e.deltaY = d, e.deltaFactor = o, e.offsetX = f, e.offsetY = g, e.deltaMode = 0, a.unshift(e, h, u, d), s && clearTimeout(s), s = setTimeout(i, 200), (t.event.dispatch || t.event.handle).apply(this, a)
                            }
                        }

                        function i() {
                            o = null
                        }

                        function n(t, e) {
                            return c.settings.adjustOldDeltas && "mousewheel" === t.type && e % 120 == 0
                        }
                        var s, o, r = ["wheel", "mousewheel", "DOMMouseScroll", "MozMousePixelScroll"],
                            a = "onwheel" in document || document.documentMode >= 9 ? ["wheel"] : ["mousewheel", "DomMouseScroll", "MozMousePixelScroll"],
                            l = Array.prototype.slice;
                        if (t.event.fixHooks)
                            for (var h = r.length; h;) t.event.fixHooks[r[--h]] = t.event.mouseHooks;
                        var c = t.event.special.mousewheel = {
                            version: "3.1.12",
                            setup: function() {
                                if (this.addEventListener)
                                    for (var i = a.length; i;) this.addEventListener(a[--i], e, !1);
                                else this.onmousewheel = e;
                                t.data(this, "mousewheel-line-height", c.getLineHeight(this)), t.data(this, "mousewheel-page-height", c.getPageHeight(this))
                            },
                            teardown: function() {
                                if (this.removeEventListener)
                                    for (var i = a.length; i;) this.removeEventListener(a[--i], e, !1);
                                else this.onmousewheel = null;
                                t.removeData(this, "mousewheel-line-height"), t.removeData(this, "mousewheel-page-height")
                            },
                            getLineHeight: function(e) {
                                var i = t(e),
                                    n = i["offsetParent" in t.fn ? "offsetParent" : "parent"]();
                                return n.length || (n = t("body")), parseInt(n.css("fontSize"), 10) || parseInt(i.css("fontSize"), 10) || 16
                            },
                            getPageHeight: function(e) {
                                return t(e).height()
                            },
                            settings: {
                                adjustOldDeltas: !0,
                                normalizeOffset: !0
                            }
                        };
                        t.fn.extend({
                            mousewheel: function(t) {
                                return t ? this.bind("mousewheel", t) : this.trigger("mousewheel")
                            },
                            unmousewheel: function(t) {
                                return this.unbind("mousewheel", t)
                            }
                        })
                    }), e.define("jquery.select2", ["jquery", "jquery-mousewheel", "./select2/core", "./select2/defaults"], function(t, e, i, n) {
                        if (null == t.fn.select2) {
                            var s = ["open", "close", "destroy"];
                            t.fn.select2 = function(e) {
                                if ("object" == typeof(e = e || {})) return this.each(function() {
                                    var n = t.extend(!0, {}, e);
                                    new i(t(this), n)
                                }), this;
                                if ("string" == typeof e) {
                                    var n, o = Array.prototype.slice.call(arguments, 1);
                                    return this.each(function() {
                                        var i = t(this).data("select2");
                                        null == i && window.console && console.error && console.error("The select2('" + e + "') method was called on an element that is not using Select2."), n = i[e].apply(i, o)
                                    }), t.inArray(e, s) > -1 ? this : n
                                }
                                throw new Error("Invalid arguments for Select2: " + e)
                            }
                        }
                        return null == t.fn.select2.defaults && (t.fn.select2.defaults = n), i
                    }), {
                        define: e.define,
                        require: e.require
                    }
            }(),
            i = e.require("jquery.select2");
        return t.fn.select2.amd = e, i
    }), function(t) {
        function e(e) {
            return e.classList ? e.classList : t(e).attr("class").match(/\S+/gi)
        }
        t.fn.ShareLink = function(i) {
            function n(t) {
                var e = r[t];
                return e = e.replace(/{url}/g, encodeURIComponent(i.url)), e = e.replace(/{title}/g, encodeURIComponent(i.title)), e = e.replace(/{text}/g, encodeURIComponent(i.text)), e = e.replace(/{image}/g, encodeURIComponent(i.image))
            }
            var s = {
                    title: "",
                    text: "",
                    image: "",
                    url: window.location.href,
                    class_prefix: "s_"
                },
                i = t.extend({}, s, i),
                o = i.class_prefix.length,
                r = {
                    twitter: "https://twitter.com/intent/tweet?url={url}&text={text}",
                    pinterest: "https://www.pinterest.com/pin/create/button/?media={image}&url={url}&description={text}",
                    facebook: "https://www.facebook.com/sharer.php?s=100&p[title]={title}&u={url}&t={title}&p[summary]={text}&p[url]={url}",
                    vk: "https://vkontakte.ru/share.php?url={url}&title={title}&description={text}&image={image}&noparse=true",
                    linkedin: "https://www.linkedin.com/shareArticle?mini=true&url={url}&title={title}&summary={text}&source={url}",
                    myworld: "https://connect.mail.ru/share?url={url}&title={title}&description={text}&imageurl={image}",
                    odnoklassniki: "http://odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st._surl={url}&st.comments={text}",
                    tumblr: "https://tumblr.com/share?s=&v=3&t={title}&u={url}",
                    blogger: "https://blogger.com/blog-this.g?t={text}&n={title}&u={url}",
                    delicious: "https://delicious.com/save?url={url}&title={title}",
                    plus: "https://plus.google.com/share?url={url}",
                    digg: "https://digg.com/submit?url={url}&title={title}",
                    reddit: "http://reddit.com/submit?url={url}&title={title}",
                    stumbleupon: "https://www.stumbleupon.com/submit?url={url}&title={title}",
                    pocket: "https://getpocket.com/edit?url={url}&title={title}",
                    chiq: "http://www.chiq.com/create/bookmarklet?u={url}&i={image}&d={title}&c={url}",
                    qrifier: "http://qrifier.com/q?inc=qr&type=url&size=350&string={url}",
                    qrsrc: "http://www.qrsrc.com/default.aspx?shareurl={url}",
                    qzone: "http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url={url}",
                    tulinq: "http://www.tulinq.com/enviar?url={url}&title={title}",
                    misterwong: "http://www.mister-wong.com/index.php?action=addurl&bm_url={url}&bm_description={title}&bm_notice=",
                    sto_zakladok: "http://www.100zakladok.ru/save/?bmurl={url}&bmtitle={title}",
                    two_linkme: "http://www.2linkme.com/?collegamento={url}&id=2lbar",
                    adifni: "http://www.adifni.com/account/bookmark/?bookmark_url={url}",
                    amazonwishlist: "http://www.amazon.com/gp/wishlist/static-add?u={url}&t={title}",
                    amenme: "http://www.amenme.com/AmenMe/Amens/AmenToThis.aspx?url={url}&title={title}",
                    aim: "http://lifestream.aol.com/share/?url={url}&title={title}&description={text} ",
                    aolmail: "http://webmail.aol.com/25045/aol/en-us/Mail/compose-message.aspx?to=&subject={title}&body={{content}}",
                    arto: "http://www.arto.com/section/linkshare/?lu={url}&ln={title}",
                    baidu: "http://cang.baidu.com/do/add?it={title}&iu={url}&fr=ien&dc={text}",
                    bitly: "https://bitly.com/a/bitmarklet?u={url}",
                    bizsugar: "http://www.bizsugar.com/bizsugarthis.php?url={url}",
                    blinklist: "http://www.blinklist.com/blink?u={url}&t={title}&d={text}",
                    blip: "http://blip.pl/dashboard?body={title}%3A%20{url}",
                    blogmarks: "http://blogmarks.net/my/new.php?mini=1&simple=1&url={url}&title={title}&content={text}",
                    blurpalicious: "http://www.blurpalicious.com/submit/?url={url}&title={title}&desc={text}",
                    bobrdobr: "http://bobrdobr.ru/addext.html?url={url}&title={title}&desc={text}",
                    bonzobox: "http://bonzobox.com/toolbar/add?u={url}&t={title}&desc={text}",
                    bookmerkende: "http://www.bookmerken.de/?url={url}&title={title}",
                    box: "https://www.box.net/api/1.0/import?import_as=link&url={url}&name={title}&description={text}",
                    bryderi: "http://bryderi.se/add.html?u={url}",
                    buddymarks: "http://buddymarks.com/add_bookmark.php?bookmark_title={title}&bookmark_url={url}&bookmark_desc={text}",
                    camyoo: "http://www.camyoo.com/note.html?url={url}",
                    care2: "http://www.care2.com/news/compose?sharehint=news&share[share_type]news&bookmarklet=Y&share[title]={title}&share[link_url]={url}&share[content]={text}",
                    citeulike: "http://www.citeulike.org/posturl?url={url}&title={title}",
                    classicalplace: "http://www.classicalplace.com/?u={url}&t={title}&c={text}",
                    cosmiq: "http://www.cosmiq.de/lili/my/add?url={url}",
                    diggita: "http://www.diggita.it/submit.php?url={url}&title={title}",
                    diigo: "http://www.diigo.com/post?url={url}&title={title}&desc={text}",
                    domelhor: "http://domelhor.net/submit.php?url={url}&title={title}",
                    dotnetshoutout: "http://dotnetshoutout.com/Submit?url={url}&title={title}",
                    douban: "http://www.douban.com/recommend/?url={url}&title={title}",
                    dropjack: "http://www.dropjack.com/submit.php?url={url}",
                    edelight: "http://www.edelight.de/geschenk/neu?purl={url}",
                    ekudos: "http://www.ekudos.nl/artikel/nieuw?url={url}&title={title}&desc={text}",
                    elefantapl: "http://elefanta.pl/member/bookmarkNewPage.action?url={url}&title={title}&bookmarkVO.notes=",
                    embarkons: "http://www.embarkons.com/sharer.php?u={url}&t={title}",
                    evernote: "http://www.evernote.com/clip.action?url={url}&title={title}",
                    extraplay: "http://www.extraplay.com/members/share.php?url={url}&title={title}&desc={text}",
                    ezyspot: "http://www.ezyspot.com/submit?url={url}&title={title}",
                    fabulously40: "http://fabulously40.com/writeblog?subject={title}&body={url}",
                    informazione: "http://fai.informazione.it/submit.aspx?url={url}&title={title}&desc={text}",
                    fark: "http://www.fark.com/cgi/farkit.pl?u={url}&h={title}",
                    farkinda: "http://www.farkinda.com/submit?url={url}",
                    favable: "http://www.favable.com/oexchange?url={url}&title={title}&desc={text}",
                    favlogde: "http://www.favlog.de/submit.php?url={url}",
                    flaker: "http://flaker.pl/add2flaker.php?title={title}&url={url}",
                    folkd: "http://www.folkd.com/submit/{url}",
                    fresqui: "http://fresqui.com/enviar?url={url}",
                    friendfeed: "http://friendfeed.com/share?url={url}&title={title}",
                    funp: "http://funp.com/push/submit/?url={url}",
                    fwisp: "http://fwisp.com/submit.php?url={url}",
                    givealink: "http://givealink.org/bookmark/add?url={url}&title={title}",
                    gmail: "http://mail.google.com/mail/?view=cm&fs=1&to=&su={title}&body={text}&ui=1",
                    goodnoows: "http://goodnoows.com/add/?url={url}",
                    google: "http://www.google.com/bookmarks/mark?op=add&bkmk={url}&title={title}&annotation={text}",
                    googletranslate: "http://translate.google.com/translate?hl=en&u={url}&tl=en&sl=auto",
                    greaterdebater: "http://greaterdebater.com/submit/?url={url}&title={title}",
                    hackernews: "http://news.ycombinator.com/submitlink?u={url}&t={title}",
                    hatena: "http://b.hatena.ne.jp/bookmarklet?url={url}&btitle={title}",
                    hedgehogs: "http://www.hedgehogs.net/mod/bookmarks/add.php?address={url}&title={title}",
                    hotmail: "http://www.hotmail.msn.com/secure/start?action=compose&to=&subject={title}&body={{content}}",
                    w3validator: "http://validator.w3.org/check?uri={url}&charset=%28detect+automatically%29&doctype=Inline&group=0",
                    ihavegot: "http://www.ihavegot.com/share/?url={url}&title={title}&desc={text}",
                    instapaper: "http://www.instapaper.com/edit?url={url}&title={title}&summary={text}",
                    isociety: "http://isociety.be/share/?url={url}&title={title}&desc={text}",
                    iwiw: "http://iwiw.hu/pages/share/share.jsp?v=1&u={url}&t={title}",
                    jamespot: "http://www.jamespot.com/?action=spotit&u={url}&t={title}",
                    jumptags: "http://www.jumptags.com/add/?url={url}&title={title}",
                    kaboodle: "http://www.kaboodle.com/grab/addItemWithUrl?url={url}&pidOrRid=pid=&redirectToKPage=true",
                    kaevur: "http://kaevur.com/submit.php?url={url}",
                    kledy: "http://www.kledy.de/submit.php?url={url}&title={title}",
                    librerio: "http://www.librerio.com/inbox?u={url}&t={title}",
                    linkuj: "http://linkuj.cz?id=linkuj&url={url}&title={title}&description={text}&imgsrc=",
                    livejournal: "http://www.livejournal.com/update.bml?subject={title}&event={url}",
                    logger24: "http://logger24.com/?url={url}",
                    mashbord: "http://mashbord.com/plugin-add-bookmark?url={url}",
                    meinvz: "http://www.meinvz.net/Suggest/Selection/?u={url}&desc={title}&prov=addthis.com",
                    mekusharim: "http://mekusharim.walla.co.il/share/share.aspx?url={url}&title={title}",
                    memori: "http://memori.ru/link/?sm=1&u_data[url]={url}",
                    meneame: "http://www.meneame.net/submit.php?url={url}",
                    mixi: "http://mixi.jp/share.pl?u={url}",
                    moemesto: "http://moemesto.ru/post.php?url={url}&title={title}",
                    myspace: "http://www.myspace.com/Modules/PostTo/Pages/?u={url}&t={title}&c=",
                    n4g: "http://www.n4g.com/tips.aspx?url={url}&title={title}",
                    netlog: "http://www.netlog.com/go/manage/links/?view=save&origin=external&url={url}&title={title}&description={text}",
                    netvouz: "http://netvouz.com/action/submitBookmark?url={url}&title={title}&popup=no&description={text}",
                    newstrust: "http://newstrust.net/submit?url={url}&title={title}&ref=addthis",
                    newsvine: "http://www.newsvine.com/_tools/seed&save?u={url}&h={title}&s={text}",
                    nujij: "http://nujij.nl/jij.lynkx?u={url}&t={title}&b={text}",
                    oknotizie: "http://oknotizie.virgilio.it/post?title={title}&url={url}",
                    oyyla: "http://www.oyyla.com/gonder?phase=2&url={url}",
                    pdfonline: "http://savepageaspdf.pdfonline.com/pdfonline/pdfonline.asp?cURL={url}",
                    pdfmyurl: "http://pdfmyurl.com?url={url}",
                    phonefavs: "http://phonefavs.com/bookmarks?action=add&address={url}&title={title}",
                    plaxo: "http://www.plaxo.com/events?share_link={url}&desc={text}",
                    plurk: "http://www.plurk.com/m?content={url}+({title})&qualifier=shares ",
                    posteezy: "http://posteezy.com/node/add/story?title={title}&body={url}",
                    pusha: "http://www.pusha.se/posta?url={url}&title={title}&description={text}",
                    rediff: "http://share.rediff.com/bookmark/addbookmark?title={title}&bookmarkurl={url}",
                    redkum: "http://www.redkum.com/add?url={url}&step=1&title={title}",
                    scoopat: "http://scoop.at/submit?url={url}&title={title}&body={text}",
                    sekoman: "http://sekoman.lv/home?status={title}&url={url}",
                    shaveh: "http://shaveh.co.il/submit.php?url={url}&title={title}",
                    shetoldme: "http://shetoldme.com/publish?url={url}&title={title}&body={text}",
                    sinaweibo: "http://v.t.sina.com.cn/share/share.php?url={url}&title={title}",
                    sodahead: "http://www.sodahead.com/news/submit/?url={url}&title={title}",
                    sonico: "http://www.sonico.com/share.php?url={url}&title={title}",
                    springpad: "http://springpadit.com/s?type=lifemanagr.Bookmark&url={url}&name={title}",
                    startaid: "http://www.startaid.com/index.php?st=AddBrowserLink&type=Detail&v=3&urlname={url}&urltitle={title}&urldesc={text}",
                    startlap: "http://www.startlap.hu/sajat_linkek/addlink.php?url={url}&title={title}",
                    studivz: "http://www.studivz.net/Suggest/Selection/?u={url}&desc={title}&prov=addthis.com",
                    stuffpit: "http://www.stuffpit.com/add.php?produrl={url}",
                    stumpedia: "http://www.stumpedia.com/submit?url={url}",
                    svejo: "http://svejo.net/story/submit_by_url?url={url}&title={title}&summary={text}",
                    symbaloo: "http://www.symbaloo.com/en/add/?url={url}&title={title}",
                    thewebblend: "http://thewebblend.com/submit?url={url}&title={title}",
                    thinkfinity: "http://www.thinkfinity.org/favorite-bookmarklet.jspa?url={url}&subject={title}",
                    thisnext: "http://www.thisnext.com/pick/new/submit/url/?description={text}&name={title}&url={url}",
                    tuenti: "http://www.tuenti.com/share?url={url}",
                    typepad: "http://www.typepad.com/services/quickpost/post?v=2&qp_show=ac&qp_title={title}&qp_href={url}&qp_text={text}",
                    viadeo: "http://www.viadeo.com/shareit/share/?url={url}&title={title}&urlaffiliate=32005&encoding=UTF-8",
                    virb: "http://virb.com/share?external&v=2&url={url}&title={title}",
                    visitezmonsite: "http://www.visitezmonsite.com/publier?url={url}&title={title}&body={text}",
                    vybralisme: "http://vybrali.sme.sk/sub.php?url={url}",
                    webnews: "http://www.webnews.de/einstellen?url={url}&title={title}",
                    wirefan: "http://www.wirefan.com/grpost.php?d=&u={url}&h={title}&d={text}",
                    wordpress: "http://wordpress.com/wp-admin/press-this.php?u={url}&t={title}&s={text}&v=2",
                    wowbored: "http://www.wowbored.com/submit.php?url={url}",
                    wykop: "http://www.wykop.pl/dodaj?url={url}&title={title}&desc={text}",
                    yahoobkm: "http://bookmarks.yahoo.com/toolbar/savebm?opener=tb&u={url}&t={title}&d={text}",
                    yahoomail: "http://compose.mail.yahoo.com/?To=&Subject={title}&body={{content}}",
                    yammer: "https://www.yammer.com/home/bookmarklet?bookmarklet_pop=1&u={url}&t={title}",
                    yardbarker: "http://www.yardbarker.com/author/new/?pUrl={url}&pHead={title}",
                    yigg: "http://www.yigg.de/neu?exturl={url}&exttitle={title}&extdesc={text}",
                    yoolink: "http://go.yoolink.to/addorshare?url_value={url}&title={title}",
                    yorumcuyum: "http://www.yorumcuyum.com/?baslik={title}&link={url}",
                    youmob: "http://youmob.com/mobit.aspx?title={title}&mob={url}",
                    zakladoknet: "http://zakladok.net/link/?u={url}&t={title}",
                    ziczac: "http://ziczac.it/a/segnala/?gurl={url}&gtit={title}",
                    whatsapp: "whatsapp://send?text={url} {title}"
                };
            return this.each(function(s, a) {
                for (var l = e(a), s = 0; s < l.length; s++) {
                    var h = l[s];
                    if (h.substr(0, o) == i.class_prefix && r[h.substr(o)]) {
                        var c = n(h.substr(o));
                        t(a).attr("href", c).click(function() {
                            if (-1 === t(this).attr("href").indexOf("http://") && -1 === t(this).attr("href").indexOf("https://")) return window.open(t(this).attr("href")) && !1;
                            var e = screen.width,
                                n = screen.height,
                                s = i.width ? i.width : e - .2 * e,
                                o = i.height ? i.height : n - .2 * n,
                                r = e / 2 - s / 2,
                                a = n / 2 - o / 2,
                                l = "toolbar=0,status=0,width=" + s + ",height=" + o + ",top=" + a + ",left=" + r;
                            return window.open(t(this).attr("href"), "", l) && !1
                        })
                    }
                }
            })
        }, t.fn.ShareCounter = function(i) {
            function n(e, i) {
                t.ajax({
                    type: "GET",
                    dataType: "jsonp",
                    url: "https://api.facebook.com/restserver.php",
                    data: {
                        method: "links.getStats",
                        urls: [e],
                        format: "json"
                    }
                }).done(function(t) {
                    i(t[0].share_count)
                }).fail(function() {
                    i(0)
                })
            }

            function s(e, i) {
                void 0 === window.VK && (VK = {}), VK.Share = {
                    count: function(t, e) {
                        i(e)
                    }
                }, t.ajax({
                    type: "GET",
                    dataType: "jsonp",
                    url: "https://vk.com/share.php",
                    data: {
                        act: "count",
                        index: 0,
                        url: e
                    }
                }).fail(function(t, e) {
                    "parsererror" != e && i(0)
                })
            }

            function o(e, i) {
                t.ajax({
                    type: "GET",
                    dataType: "jsonp",
                    url: "https://connect.mail.ru/share_count",
                    jsonp: "func",
                    data: {
                        url_list: e,
                        callback: "1"
                    }
                }).done(function(t) {
                    i(t[e].shares)
                }).fail(function(t) {
                    i(0)
                })
            }

            function r(e, i) {
                t.ajax({
                    type: "GET",
                    dataType: "jsonp",
                    url: "https://www.linkedin.com/countserv/count/share",
                    data: {
                        url: e,
                        format: "jsonp"
                    }
                }).done(function(t) {
                    i(t.count)
                }).fail(function() {
                    i(0)
                })
            }

            function a(e, i) {
                ODKL = {
                    updateCount: function(t, e) {
                        i(e)
                    }
                }, t.ajax({
                    type: "GET",
                    dataType: "jsonp",
                    url: "https://ok.ru/dk",
                    data: {
                        "st.cmd": "extLike",
                        ref: e
                    }
                }).fail(function(t, e) {
                    "parsererror" != e && i(0)
                })
            }

            function l(e, i) {
                t.ajax({
                    type: "GET",
                    dataType: "jsonp",
                    url: "https://api.pinterest.com/v1/urls/count.json",
                    data: {
                        url: e
                    }
                }).done(function(t) {
                    i(t.count)
                }).fail(function() {
                    i(0)
                })
            }

            function h(e, i) {
                t.ajax({
                    type: "POST",
                    url: "https://clients6.google.com/rpc",
                    processData: !0,
                    contentType: "application/json",
                    data: JSON.stringify({
                        method: "pos.plusones.get",
                        id: location.href,
                        params: {
                            nolog: !0,
                            id: e,
                            source: "widget",
                            userId: "@viewer",
                            groupId: "@self"
                        },
                        jsonrpc: "2.0",
                        key: "p",
                        apiVersion: "v1"
                    })
                }).done(function(t) {
                    i(t.result.metadata.globalCounts.count)
                }).fail(function() {
                    i(0)
                })
            }
            var c = {
                    url: window.location.href,
                    class_prefix: "c_",
                    display_counter_from: 0
                },
                i = t.extend({}, c, i),
                u = i.class_prefix.length,
                d = {
                    facebook: n,
                    vk: s,
                    myworld: o,
                    linkedin: r,
                    odnoklassniki: a,
                    pinterest: l,
                    plus: h
                };
            return this.each(function(n, s) {
                for (var o = e(s), n = 0; n < o.length; n++) {
                    var r = o[n];
                    r.substr(0, u) == i.class_prefix && d[r.substr(u)] && d[r.substr(u)](i.url, function(e) {
                        e >= i.display_counter_from && t(s).text(e)
                    })
                }
            })
        }
    }(jQuery), function(t, e, i, n) {
        function s(e, i) {
            this.settings = null, this.options = t.extend({}, s.Defaults, i), this.$element = t(e), this._handlers = {}, this._plugins = {}, this._supress = {}, this._current = null, this._speed = null, this._coordinates = [], this._breakpoint = null, this._width = null, this._items = [], this._clones = [], this._mergers = [], this._widths = [], this._invalidated = {}, this._pipe = [], this._drag = {
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
            }, t.each(["onResize", "onThrottledResize"], t.proxy(function(e, i) {
                this._handlers[i] = t.proxy(this[i], this)
            }, this)), t.each(s.Plugins, t.proxy(function(t, e) {
                this._plugins[t.charAt(0).toLowerCase() + t.slice(1)] = new e(this)
            }, this)), t.each(s.Workers, t.proxy(function(e, i) {
                this._pipe.push({
                    filter: i.filter,
                    run: t.proxy(i.run, this)
                })
            }, this)), this.setup(), this.initialize()
        }
        s.Defaults = {
            items: 3,
            loop: !1,
            center: !1,
            rewind: !1,
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
        }, s.Width = {
            Default: "default",
            Inner: "inner",
            Outer: "outer"
        }, s.Type = {
            Event: "event",
            State: "state"
        }, s.Plugins = {}, s.Workers = [{
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
                    i = !this.settings.autoWidth,
                    n = this.settings.rtl,
                    s = {
                        width: "auto",
                        "margin-left": n ? e : "",
                        "margin-right": n ? "" : e
                    };
                !i && this.$stage.children().css(s), t.css = s
            }
        }, {
            filter: ["width", "items", "settings"],
            run: function(t) {
                var e = (this.width() / this.settings.items).toFixed(3) - this.settings.margin,
                    i = null,
                    n = this._items.length,
                    s = !this.settings.autoWidth,
                    o = [];
                for (t.items = {
                        merge: !1,
                        width: e
                    }; n--;) i = this._mergers[n], i = this.settings.mergeFit && Math.min(i, this.settings.items) || i, t.items.merge = i > 1 || t.items.merge, o[n] = s ? e * i : this._items[n].width();
                this._widths = o
            }
        }, {
            filter: ["items", "settings"],
            run: function() {
                var e = [],
                    i = this._items,
                    n = this.settings,
                    s = Math.max(2 * n.items, 4),
                    o = 2 * Math.ceil(i.length / 2),
                    r = n.loop && i.length ? n.rewind ? s : Math.max(s, o) : 0,
                    a = "",
                    l = "";
                for (r /= 2; r--;) e.push(this.normalize(e.length / 2, !0)), a += i[e[e.length - 1]][0].outerHTML, e.push(this.normalize(i.length - 1 - (e.length - 1) / 2, !0)), l = i[e[e.length - 1]][0].outerHTML + l;
                this._clones = e, t(a).addClass("cloned").appendTo(this.$stage), t(l).addClass("cloned").prependTo(this.$stage)
            }
        }, {
            filter: ["width", "items", "settings"],
            run: function() {
                for (var t = this.settings.rtl ? 1 : -1, e = this._clones.length + this._items.length, i = -1, n = 0, s = 0, o = []; ++i < e;) n = o[i - 1] || 0, s = this._widths[this.relative(i)] + this.settings.margin, o.push(n + s * t);
                this._coordinates = o
            }
        }, {
            filter: ["width", "items", "settings"],
            run: function() {
                var t = this.settings.stagePadding,
                    e = this._coordinates,
                    i = {
                        width: Math.ceil(Math.abs(e[e.length - 1])) + 2 * t,
                        "padding-left": t || "",
                        "padding-right": t || ""
                    };
                this.$stage.css(i)
            }
        }, {
            filter: ["width", "items", "settings"],
            run: function(t) {
                var e = this._coordinates.length,
                    i = !this.settings.autoWidth,
                    n = this.$stage.children();
                if (i && t.items.merge)
                    for (; e--;) t.css.width = this._widths[this.relative(e)], n.eq(e).css(t.css);
                else i && (t.css.width = t.items.width, n.css(t.css))
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
                var t, e, i, n, s = this.settings.rtl ? 1 : -1,
                    o = 2 * this.settings.stagePadding,
                    r = this.coordinates(this.current()) + o,
                    a = r + this.width() * s,
                    l = [];
                for (i = 0, n = this._coordinates.length; i < n; i++) t = this._coordinates[i - 1] || 0, e = Math.abs(this._coordinates[i]) + o * s, (this.op(t, "<=", r) && this.op(t, ">", a) || this.op(e, "<", r) && this.op(e, ">", a)) && l.push(i);
                this.$stage.children(".active").removeClass("active"), this.$stage.children(":eq(" + l.join("), :eq(") + ")").addClass("active"), this.settings.center && (this.$stage.children(".center").removeClass("center"), this.$stage.children().eq(this.current()).addClass("center"))
            }
        }], s.prototype.initialize = function() {
            if (this.enter("initializing"), this.trigger("initialize"), this.$element.toggleClass(this.settings.rtlClass, this.settings.rtl), this.settings.autoWidth && !this.is("pre-loading")) {
                var e, i, n;
                e = this.$element.find("img"), i = this.settings.nestedItemSelector ? "." + this.settings.nestedItemSelector : void 0, n = this.$element.children(i).width(), e.length && n <= 0 && this.preloadAutoWidthImages(e)
            }
            this.$element.addClass(this.options.loadingClass), this.$stage = t("<" + this.settings.stageElement + ' class="' + this.settings.stageClass + '"/>').wrap('<div class="' + this.settings.stageOuterClass + '"/>'), this.$element.append(this.$stage.parent()), this.replace(this.$element.children().not(this.$stage.parent())), this.$element.is(":visible") ? this.refresh() : this.invalidate("width"), this.$element.removeClass(this.options.loadingClass).addClass(this.options.loadedClass), this.registerEventHandlers(), this.leave("initializing"), this.trigger("initialized")
        }, s.prototype.setup = function() {
            var e = this.viewport(),
                i = this.options.responsive,
                n = -1,
                s = null;
            i ? (t.each(i, function(t) {
                t <= e && t > n && (n = Number(t))
            }), s = t.extend({}, this.options, i[n]), "function" == typeof s.stagePadding && (s.stagePadding = s.stagePadding()), delete s.responsive, s.responsiveClass && this.$element.attr("class", this.$element.attr("class").replace(new RegExp("(" + this.options.responsiveClass + "-)\\S+\\s", "g"), "$1" + n))) : s = t.extend({}, this.options), this.trigger("change", {
                property: {
                    name: "settings",
                    value: s
                }
            }), this._breakpoint = n, this.settings = s, this.invalidate("settings"), this.trigger("changed", {
                property: {
                    name: "settings",
                    value: this.settings
                }
            })
        }, s.prototype.optionsLogic = function() {
            this.settings.autoWidth && (this.settings.stagePadding = !1, this.settings.merge = !1)
        }, s.prototype.prepare = function(e) {
            var i = this.trigger("prepare", {
                content: e
            });
            return i.data || (i.data = t("<" + this.settings.itemElement + "/>").addClass(this.options.itemClass).append(e)), this.trigger("prepared", {
                content: i.data
            }), i.data
        }, s.prototype.update = function() {
            for (var e = 0, i = this._pipe.length, n = t.proxy(function(t) {
                    return this[t]
                }, this._invalidated), s = {}; e < i;)(this._invalidated.all || t.grep(this._pipe[e].filter, n).length > 0) && this._pipe[e].run(s), e++;
            this._invalidated = {}, !this.is("valid") && this.enter("valid")
        }, s.prototype.width = function(t) {
            switch (t = t || s.Width.Default) {
                case s.Width.Inner:
                case s.Width.Outer:
                    return this._width;
                default:
                    return this._width - 2 * this.settings.stagePadding + this.settings.margin
            }
        }, s.prototype.refresh = function() {
            this.enter("refreshing"), this.trigger("refresh"), this.setup(), this.optionsLogic(), this.$element.addClass(this.options.refreshClass), this.update(), this.$element.removeClass(this.options.refreshClass), this.leave("refreshing"), this.trigger("refreshed")
        }, s.prototype.onThrottledResize = function() {
            e.clearTimeout(this.resizeTimer), this.resizeTimer = e.setTimeout(this._handlers.onResize, this.settings.responsiveRefreshRate)
        }, s.prototype.onResize = function() {
            return !!this._items.length && (this._width !== this.$element.width() && (!!this.$element.is(":visible") && (this.enter("resizing"), this.trigger("resize").isDefaultPrevented() ? (this.leave("resizing"), !1) : (this.invalidate("width"), this.refresh(), this.leave("resizing"), void this.trigger("resized")))))
        }, s.prototype.registerEventHandlers = function() {
            t.support.transition && this.$stage.on(t.support.transition.end + ".owl.core", t.proxy(this.onTransitionEnd, this)), !1 !== this.settings.responsive && this.on(e, "resize", this._handlers.onThrottledResize), this.settings.mouseDrag && (this.$element.addClass(this.options.dragClass), this.$stage.on("mousedown.owl.core", t.proxy(this.onDragStart, this)), this.$stage.on("dragstart.owl.core selectstart.owl.core", function() {
                return !1
            })), this.settings.touchDrag && (this.$stage.on("touchstart.owl.core", t.proxy(this.onDragStart, this)), this.$stage.on("touchcancel.owl.core", t.proxy(this.onDragEnd, this)))
        }, s.prototype.onDragStart = function(e) {
            var n = null;
            3 !== e.which && (t.support.transform ? (n = this.$stage.css("transform").replace(/.*\(|\)| /g, "").split(","), n = {
                x: n[16 === n.length ? 12 : 4],
                y: n[16 === n.length ? 13 : 5]
            }) : (n = this.$stage.position(), n = {
                x: this.settings.rtl ? n.left + this.$stage.width() - this.width() + this.settings.margin : n.left,
                y: n.top
            }), this.is("animating") && (t.support.transform ? this.animate(n.x) : this.$stage.stop(), this.invalidate("position")), this.$element.toggleClass(this.options.grabClass, "mousedown" === e.type), this.speed(0), this._drag.time = (new Date).getTime(), this._drag.target = t(e.target), this._drag.stage.start = n, this._drag.stage.current = n, this._drag.pointer = this.pointer(e), t(i).on("mouseup.owl.core touchend.owl.core", t.proxy(this.onDragEnd, this)), t(i).one("mousemove.owl.core touchmove.owl.core", t.proxy(function(e) {
                var n = this.difference(this._drag.pointer, this.pointer(e));
                t(i).on("mousemove.owl.core touchmove.owl.core", t.proxy(this.onDragMove, this)), Math.abs(n.x) < Math.abs(n.y) && this.is("valid") || (e.preventDefault(), this.enter("dragging"), this.trigger("drag"))
            }, this)))
        }, s.prototype.onDragMove = function(t) {
            var e = null,
                i = null,
                n = null,
                s = this.difference(this._drag.pointer, this.pointer(t)),
                o = this.difference(this._drag.stage.start, s);
            this.is("dragging") && (t.preventDefault(), this.settings.loop ? (e = this.coordinates(this.minimum()), i = this.coordinates(this.maximum() + 1) - e, o.x = ((o.x - e) % i + i) % i + e) : (e = this.settings.rtl ? this.coordinates(this.maximum()) : this.coordinates(this.minimum()), i = this.settings.rtl ? this.coordinates(this.minimum()) : this.coordinates(this.maximum()), n = this.settings.pullDrag ? -1 * s.x / 5 : 0, o.x = Math.max(Math.min(o.x, e + n), i + n)), this._drag.stage.current = o, this.animate(o.x))
        }, s.prototype.onDragEnd = function(e) {
            var n = this.difference(this._drag.pointer, this.pointer(e)),
                s = this._drag.stage.current,
                o = n.x > 0 ^ this.settings.rtl ? "left" : "right";
            t(i).off(".owl.core"), this.$element.removeClass(this.options.grabClass), (0 !== n.x && this.is("dragging") || !this.is("valid")) && (this.speed(this.settings.dragEndSpeed || this.settings.smartSpeed), this.current(this.closest(s.x, 0 !== n.x ? o : this._drag.direction)), this.invalidate("position"), this.update(), this._drag.direction = o, (Math.abs(n.x) > 3 || (new Date).getTime() - this._drag.time > 300) && this._drag.target.one("click.owl.core", function() {
                return !1
            })), this.is("dragging") && (this.leave("dragging"), this.trigger("dragged"))
        }, s.prototype.closest = function(e, i) {
            var n = -1,
                s = this.width(),
                o = this.coordinates();
            return this.settings.freeDrag || t.each(o, t.proxy(function(t, r) {
                return "left" === i && e > r - 30 && e < r + 30 ? n = t : "right" === i && e > r - s - 30 && e < r - s + 30 ? n = t + 1 : this.op(e, "<", r) && this.op(e, ">", o[t + 1] || r - s) && (n = "left" === i ? t + 1 : t), -1 === n
            }, this)), this.settings.loop || (this.op(e, ">", o[this.minimum()]) ? n = e = this.minimum() : this.op(e, "<", o[this.maximum()]) && (n = e = this.maximum())), n
        }, s.prototype.animate = function(e) {
            var i = this.speed() > 0;
            this.is("animating") && this.onTransitionEnd(), i && (this.enter("animating"), this.trigger("translate")), t.support.transform3d && t.support.transition ? this.$stage.css({
                transform: "translate3d(" + e + "px,0px,0px)",
                transition: this.speed() / 1e3 + "s"
            }) : i ? this.$stage.animate({
                left: e + "px"
            }, this.speed(), this.settings.fallbackEasing, t.proxy(this.onTransitionEnd, this)) : this.$stage.css({
                left: e + "px"
            })
        }, s.prototype.is = function(t) {
            return this._states.current[t] && this._states.current[t] > 0
        }, s.prototype.current = function(t) {
            if (void 0 === t) return this._current;
            if (0 !== this._items.length) {
                if (t = this.normalize(t), this._current !== t) {
                    var e = this.trigger("change", {
                        property: {
                            name: "position",
                            value: t
                        }
                    });
                    void 0 !== e.data && (t = this.normalize(e.data)), this._current = t, this.invalidate("position"), this.trigger("changed", {
                        property: {
                            name: "position",
                            value: this._current
                        }
                    })
                }
                return this._current
            }
        }, s.prototype.invalidate = function(e) {
            return "string" === t.type(e) && (this._invalidated[e] = !0, this.is("valid") && this.leave("valid")), t.map(this._invalidated, function(t, e) {
                return e
            })
        }, s.prototype.reset = function(t) {
            void 0 !== (t = this.normalize(t)) && (this._speed = 0, this._current = t, this.suppress(["translate", "translated"]), this.animate(this.coordinates(t)), this.release(["translate", "translated"]))
        }, s.prototype.normalize = function(t, e) {
            var i = this._items.length,
                n = e ? 0 : this._clones.length;
            return !this.isNumeric(t) || i < 1 ? t = void 0 : (t < 0 || t >= i + n) && (t = ((t - n / 2) % i + i) % i + n / 2), t
        }, s.prototype.relative = function(t) {
            return t -= this._clones.length / 2, this.normalize(t, !0)
        }, s.prototype.maximum = function(t) {
            var e, i, n, s = this.settings,
                o = this._coordinates.length;
            if (s.loop) o = this._clones.length / 2 + this._items.length - 1;
            else if (s.autoWidth || s.merge) {
                for (e = this._items.length, i = this._items[--e].width(), n = this.$element.width(); e-- && !((i += this._items[e].width() + this.settings.margin) > n););
                o = e + 1
            } else o = s.center ? this._items.length - 1 : this._items.length - s.items;
            return t && (o -= this._clones.length / 2), Math.max(o, 0)
        }, s.prototype.minimum = function(t) {
            return t ? 0 : this._clones.length / 2
        }, s.prototype.items = function(t) {
            return void 0 === t ? this._items.slice() : (t = this.normalize(t, !0), this._items[t])
        }, s.prototype.mergers = function(t) {
            return void 0 === t ? this._mergers.slice() : (t = this.normalize(t, !0), this._mergers[t])
        }, s.prototype.clones = function(e) {
            var i = this._clones.length / 2,
                n = i + this._items.length,
                s = function(t) {
                    return t % 2 == 0 ? n + t / 2 : i - (t + 1) / 2
                };
            return void 0 === e ? t.map(this._clones, function(t, e) {
                return s(e)
            }) : t.map(this._clones, function(t, i) {
                return t === e ? s(i) : null
            })
        }, s.prototype.speed = function(t) {
            return void 0 !== t && (this._speed = t), this._speed
        }, s.prototype.coordinates = function(e) {
            var i, n = 1,
                s = e - 1;
            return void 0 === e ? t.map(this._coordinates, t.proxy(function(t, e) {
                return this.coordinates(e)
            }, this)) : (this.settings.center ? (this.settings.rtl && (n = -1, s = e + 1), i = this._coordinates[e], i += (this.width() - i + (this._coordinates[s] || 0)) / 2 * n) : i = this._coordinates[s] || 0, i = Math.ceil(i))
        }, s.prototype.duration = function(t, e, i) {
            return 0 === i ? 0 : Math.min(Math.max(Math.abs(e - t), 1), 6) * Math.abs(i || this.settings.smartSpeed)
        }, s.prototype.to = function(t, e) {
            var i = this.current(),
                n = null,
                s = t - this.relative(i),
                o = (s > 0) - (s < 0),
                r = this._items.length,
                a = this.minimum(),
                l = this.maximum();
            this.settings.loop ? (!this.settings.rewind && Math.abs(s) > r / 2 && (s += -1 * o * r), t = i + s, (n = ((t - a) % r + r) % r + a) !== t && n - s <= l && n - s > 0 && (i = n - s, t = n, this.reset(i))) : this.settings.rewind ? (l += 1, t = (t % l + l) % l) : t = Math.max(a, Math.min(l, t)), this.speed(this.duration(i, t, e)), this.current(t), this.$element.is(":visible") && this.update()
        }, s.prototype.next = function(t) {
            t = t || !1, this.to(this.relative(this.current()) + 1, t)
        }, s.prototype.prev = function(t) {
            t = t || !1, this.to(this.relative(this.current()) - 1, t)
        }, s.prototype.onTransitionEnd = function(t) {
            if (void 0 !== t && (t.stopPropagation(), (t.target || t.srcElement || t.originalTarget) !== this.$stage.get(0))) return !1;
            this.leave("animating"), this.trigger("translated")
        }, s.prototype.viewport = function() {
            var n;
            return this.options.responsiveBaseElement !== e ? n = t(this.options.responsiveBaseElement).width() : e.innerWidth ? n = e.innerWidth : i.documentElement && i.documentElement.clientWidth ? n = i.documentElement.clientWidth : console.warn("Can not detect viewport width."), n
        }, s.prototype.replace = function(e) {
            this.$stage.empty(), this._items = [], e && (e = e instanceof jQuery ? e : t(e)), this.settings.nestedItemSelector && (e = e.find("." + this.settings.nestedItemSelector)), e.filter(function() {
                return 1 === this.nodeType
            }).each(t.proxy(function(t, e) {
                e = this.prepare(e), this.$stage.append(e), this._items.push(e), this._mergers.push(1 * e.find("[data-merge]").addBack("[data-merge]").attr("data-merge") || 1)
            }, this)), this.reset(this.isNumeric(this.settings.startPosition) ? this.settings.startPosition : 0), this.invalidate("items")
        }, s.prototype.add = function(e, i) {
            var n = this.relative(this._current);
            i = void 0 === i ? this._items.length : this.normalize(i, !0), e = e instanceof jQuery ? e : t(e), this.trigger("add", {
                content: e,
                position: i
            }), e = this.prepare(e), 0 === this._items.length || i === this._items.length ? (0 === this._items.length && this.$stage.append(e), 0 !== this._items.length && this._items[i - 1].after(e), this._items.push(e), this._mergers.push(1 * e.find("[data-merge]").addBack("[data-merge]").attr("data-merge") || 1)) : (this._items[i].before(e), this._items.splice(i, 0, e), this._mergers.splice(i, 0, 1 * e.find("[data-merge]").addBack("[data-merge]").attr("data-merge") || 1)), this._items[n] && this.reset(this._items[n].index()), this.invalidate("items"), this.trigger("added", {
                content: e,
                position: i
            })
        }, s.prototype.remove = function(t) {
            void 0 !== (t = this.normalize(t, !0)) && (this.trigger("remove", {
                content: this._items[t],
                position: t
            }), this._items[t].remove(), this._items.splice(t, 1), this._mergers.splice(t, 1), this.invalidate("items"), this.trigger("removed", {
                content: null,
                position: t
            }))
        }, s.prototype.preloadAutoWidthImages = function(e) {
            e.each(t.proxy(function(e, i) {
                this.enter("pre-loading"), i = t(i), t(new Image).one("load", t.proxy(function(t) {
                    i.attr("src", t.target.src), i.css("opacity", 1), this.leave("pre-loading"), !this.is("pre-loading") && !this.is("initializing") && this.refresh()
                }, this)).attr("src", i.attr("src") || i.attr("data-src") || i.attr("data-src-retina"))
            }, this))
        }, s.prototype.destroy = function() {
            this.$element.off(".owl.core"), this.$stage.off(".owl.core"), t(i).off(".owl.core"), !1 !== this.settings.responsive && (e.clearTimeout(this.resizeTimer), this.off(e, "resize", this._handlers.onThrottledResize));
            for (var n in this._plugins) this._plugins[n].destroy();
            this.$stage.children(".cloned").remove(), this.$stage.unwrap(), this.$stage.children().contents().unwrap(), this.$stage.children().unwrap(), this.$element.removeClass(this.options.refreshClass).removeClass(this.options.loadingClass).removeClass(this.options.loadedClass).removeClass(this.options.rtlClass).removeClass(this.options.dragClass).removeClass(this.options.grabClass).attr("class", this.$element.attr("class").replace(new RegExp(this.options.responsiveClass + "-\\S+\\s", "g"), "")).removeData("owl.carousel")
        }, s.prototype.op = function(t, e, i) {
            var n = this.settings.rtl;
            switch (e) {
                case "<":
                    return n ? t > i : t < i;
                case ">":
                    return n ? t < i : t > i;
                case ">=":
                    return n ? t <= i : t >= i;
                case "<=":
                    return n ? t >= i : t <= i
            }
        }, s.prototype.on = function(t, e, i, n) {
            t.addEventListener ? t.addEventListener(e, i, n) : t.attachEvent && t.attachEvent("on" + e, i)
        }, s.prototype.off = function(t, e, i, n) {
            t.removeEventListener ? t.removeEventListener(e, i, n) : t.detachEvent && t.detachEvent("on" + e, i)
        }, s.prototype.trigger = function(e, i, n, o, r) {
            var a = {
                    item: {
                        count: this._items.length,
                        index: this.current()
                    }
                },
                l = t.camelCase(t.grep(["on", e, n], function(t) {
                    return t
                }).join("-").toLowerCase()),
                h = t.Event([e, "owl", n || "carousel"].join(".").toLowerCase(), t.extend({
                    relatedTarget: this
                }, a, i));
            return this._supress[e] || (t.each(this._plugins, function(t, e) {
                e.onTrigger && e.onTrigger(h)
            }), this.register({
                type: s.Type.Event,
                name: e
            }), this.$element.trigger(h), this.settings && "function" == typeof this.settings[l] && this.settings[l].call(this, h)), h
        }, s.prototype.enter = function(e) {
            t.each([e].concat(this._states.tags[e] || []), t.proxy(function(t, e) {
                void 0 === this._states.current[e] && (this._states.current[e] = 0), this._states.current[e]++
            }, this))
        }, s.prototype.leave = function(e) {
            t.each([e].concat(this._states.tags[e] || []), t.proxy(function(t, e) {
                this._states.current[e]--
            }, this))
        }, s.prototype.register = function(e) {
            if (e.type === s.Type.Event) {
                if (t.event.special[e.name] || (t.event.special[e.name] = {}), !t.event.special[e.name].owl) {
                    var i = t.event.special[e.name]._default;
                    t.event.special[e.name]._default = function(t) {
                        return !i || !i.apply || t.namespace && -1 !== t.namespace.indexOf("owl") ? t.namespace && t.namespace.indexOf("owl") > -1 : i.apply(this, arguments)
                    }, t.event.special[e.name].owl = !0
                }
            } else e.type === s.Type.State && (this._states.tags[e.name] ? this._states.tags[e.name] = this._states.tags[e.name].concat(e.tags) : this._states.tags[e.name] = e.tags, this._states.tags[e.name] = t.grep(this._states.tags[e.name], t.proxy(function(i, n) {
                return t.inArray(i, this._states.tags[e.name]) === n
            }, this)))
        }, s.prototype.suppress = function(e) {
            t.each(e, t.proxy(function(t, e) {
                this._supress[e] = !0
            }, this))
        }, s.prototype.release = function(e) {
            t.each(e, t.proxy(function(t, e) {
                delete this._supress[e]
            }, this))
        }, s.prototype.pointer = function(t) {
            var i = {
                x: null,
                y: null
            };
            return t = t.originalEvent || t || e.event, t = t.touches && t.touches.length ? t.touches[0] : t.changedTouches && t.changedTouches.length ? t.changedTouches[0] : t, t.pageX ? (i.x = t.pageX, i.y = t.pageY) : (i.x = t.clientX, i.y = t.clientY), i
        }, s.prototype.isNumeric = function(t) {
            return !isNaN(parseFloat(t))
        }, s.prototype.difference = function(t, e) {
            return {
                x: t.x - e.x,
                y: t.y - e.y
            }
        }, t.fn.owlCarousel = function(e) {
            var i = Array.prototype.slice.call(arguments, 1);
            return this.each(function() {
                var n = t(this),
                    o = n.data("owl.carousel");
                o || (o = new s(this, "object" == typeof e && e), n.data("owl.carousel", o), t.each(["next", "prev", "to", "destroy", "refresh", "replace", "add", "remove"], function(e, i) {
                    o.register({
                        type: s.Type.Event,
                        name: i
                    }), o.$element.on(i + ".owl.carousel.core", t.proxy(function(t) {
                        t.namespace && t.relatedTarget !== this && (this.suppress([i]), o[i].apply(this, [].slice.call(arguments, 1)), this.release([i]))
                    }, o))
                })), "string" == typeof e && "_" !== e.charAt(0) && o[e].apply(o, i)
            })
        }, t.fn.owlCarousel.Constructor = s
    }(window.Zepto || window.jQuery, window, document), function(t, e, i, n) {
        var s = function(e) {
            this._core = e, this._interval = null, this._visible = null, this._handlers = {
                "initialized.owl.carousel": t.proxy(function(t) {
                    t.namespace && this._core.settings.autoRefresh && this.watch()
                }, this)
            }, this._core.options = t.extend({}, s.Defaults, this._core.options), this._core.$element.on(this._handlers)
        };
        s.Defaults = {
            autoRefresh: !0,
            autoRefreshInterval: 500
        }, s.prototype.watch = function() {
            this._interval || (this._visible = this._core.$element.is(":visible"), this._interval = e.setInterval(t.proxy(this.refresh, this), this._core.settings.autoRefreshInterval))
        }, s.prototype.refresh = function() {
            this._core.$element.is(":visible") !== this._visible && (this._visible = !this._visible, this._core.$element.toggleClass("owl-hidden", !this._visible), this._visible && this._core.invalidate("width") && this._core.refresh())
        }, s.prototype.destroy = function() {
            var t, i;
            e.clearInterval(this._interval);
            for (t in this._handlers) this._core.$element.off(t, this._handlers[t]);
            for (i in Object.getOwnPropertyNames(this)) "function" != typeof this[i] && (this[i] = null)
        }, t.fn.owlCarousel.Constructor.Plugins.AutoRefresh = s
    }(window.Zepto || window.jQuery, window, document), function(t, e, i, n) {
        var s = function(e) {
            this._core = e, this._loaded = [], this._handlers = {
                "initialized.owl.carousel change.owl.carousel resized.owl.carousel": t.proxy(function(e) {
                    if (e.namespace && this._core.settings && this._core.settings.lazyLoad && (e.property && "position" == e.property.name || "initialized" == e.type))
                        for (var i = this._core.settings, n = i.center && Math.ceil(i.items / 2) || i.items, s = i.center && -1 * n || 0, o = (e.property && void 0 !== e.property.value ? e.property.value : this._core.current()) + s, r = this._core.clones().length, a = t.proxy(function(t, e) {
                                this.load(e)
                            }, this); s++ < n;) this.load(r / 2 + this._core.relative(o)), r && t.each(this._core.clones(this._core.relative(o)), a), o++
                }, this)
            }, this._core.options = t.extend({}, s.Defaults, this._core.options), this._core.$element.on(this._handlers)
        };
        s.Defaults = {
            lazyLoad: !1
        }, s.prototype.load = function(i) {
            var n = this._core.$stage.children().eq(i),
                s = n && n.find(".owl-lazy");
            !s || t.inArray(n.get(0), this._loaded) > -1 || (s.each(t.proxy(function(i, n) {
                var s, o = t(n),
                    r = e.devicePixelRatio > 1 && o.attr("data-src-retina") || o.attr("data-src");
                this._core.trigger("load", {
                    element: o,
                    url: r
                }, "lazy"), o.is("img") ? o.one("load.owl.lazy", t.proxy(function() {
                    o.css("opacity", 1), this._core.trigger("loaded", {
                        element: o,
                        url: r
                    }, "lazy")
                }, this)).attr("src", r) : (s = new Image, s.onload = t.proxy(function() {
                    o.css({
                        "background-image": 'url("' + r + '")',
                        opacity: "1"
                    }), this._core.trigger("loaded", {
                        element: o,
                        url: r
                    }, "lazy")
                }, this), s.src = r)
            }, this)), this._loaded.push(n.get(0)))
        }, s.prototype.destroy = function() {
            var t, e;
            for (t in this.handlers) this._core.$element.off(t, this.handlers[t]);
            for (e in Object.getOwnPropertyNames(this)) "function" != typeof this[e] && (this[e] = null)
        }, t.fn.owlCarousel.Constructor.Plugins.Lazy = s
    }(window.Zepto || window.jQuery, window, document), function(t, e, i, n) {
        var s = function(e) {
            this._core = e, this._handlers = {
                "initialized.owl.carousel refreshed.owl.carousel": t.proxy(function(t) {
                    t.namespace && this._core.settings.autoHeight && this.update()
                }, this),
                "changed.owl.carousel": t.proxy(function(t) {
                    t.namespace && this._core.settings.autoHeight && "position" == t.property.name && this.update()
                }, this),
                "loaded.owl.lazy": t.proxy(function(t) {
                    t.namespace && this._core.settings.autoHeight && t.element.closest("." + this._core.settings.itemClass).index() === this._core.current() && this.update()
                }, this)
            }, this._core.options = t.extend({}, s.Defaults, this._core.options), this._core.$element.on(this._handlers)
        };
        s.Defaults = {
            autoHeight: !1,
            autoHeightClass: "owl-height"
        }, s.prototype.update = function() {
            var e = this._core._current,
                i = e + this._core.settings.items,
                n = this._core.$stage.children().toArray().slice(e, i),
                s = [],
                o = 0;
            t.each(n, function(e, i) {
                s.push(t(i).height())
            }), o = Math.max.apply(null, s), this._core.$stage.parent().height(o).addClass(this._core.settings.autoHeightClass)
        }, s.prototype.destroy = function() {
            var t, e;
            for (t in this._handlers) this._core.$element.off(t, this._handlers[t]);
            for (e in Object.getOwnPropertyNames(this)) "function" != typeof this[e] && (this[e] = null)
        }, t.fn.owlCarousel.Constructor.Plugins.AutoHeight = s
    }(window.Zepto || window.jQuery, window, document), function(t, e, i, n) {
        var s = function(e) {
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
                        var i = t(e.content).find(".owl-video");
                        i.length && (i.css("display", "none"), this.fetch(i, t(e.content)))
                    }
                }, this)
            }, this._core.options = t.extend({}, s.Defaults, this._core.options), this._core.$element.on(this._handlers), this._core.$element.on("click.owl.video", ".owl-video-play-icon", t.proxy(function(t) {
                this.play(t)
            }, this))
        };
        s.Defaults = {
            video: !1,
            videoHeight: !1,
            videoWidth: !1
        }, s.prototype.fetch = function(t, e) {
            var i = function() {
                    return t.attr("data-vimeo-id") ? "vimeo" : t.attr("data-vzaar-id") ? "vzaar" : "youtube"
                }(),
                n = t.attr("data-vimeo-id") || t.attr("data-youtube-id") || t.attr("data-vzaar-id"),
                s = t.attr("data-width") || this._core.settings.videoWidth,
                o = t.attr("data-height") || this._core.settings.videoHeight,
                r = t.attr("href");
            if (!r) throw new Error("Missing video URL.");
            if (n = r.match(/(http:|https:|)\/\/(player.|www.|app.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com)|vzaar\.com)\/(video\/|videos\/|embed\/|channels\/.+\/|groups\/.+\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/), n[3].indexOf("youtu") > -1) i = "youtube";
            else if (n[3].indexOf("vimeo") > -1) i = "vimeo";
            else {
                if (!(n[3].indexOf("vzaar") > -1)) throw new Error("Video URL not supported.");
                i = "vzaar"
            }
            n = n[6], this._videos[r] = {
                type: i,
                id: n,
                width: s,
                height: o
            }, e.attr("data-video", r), this.thumbnail(t, this._videos[r])
        }, s.prototype.thumbnail = function(e, i) {
            var n, s, o, r = i.width && i.height ? 'style="width:' + i.width + "px;height:" + i.height + 'px;"' : "",
                a = e.find("img"),
                l = "src",
                h = "",
                c = this._core.settings,
                u = function(t) {
                    s = '<div class="owl-video-play-icon"></div>', n = c.lazyLoad ? '<div class="owl-video-tn ' + h + '" ' + l + '="' + t + '"></div>' : '<div class="owl-video-tn" style="opacity:1;background-image:url(' + t + ')"></div>', e.after(n), e.after(s)
                };
            if (e.wrap('<div class="owl-video-wrapper"' + r + "></div>"), this._core.settings.lazyLoad && (l = "data-src", h = "owl-lazy"), a.length) return u(a.attr(l)), a.remove(), !1;
            "youtube" === i.type ? (o = "//img.youtube.com/vi/" + i.id + "/hqdefault.jpg", u(o)) : "vimeo" === i.type ? t.ajax({
                type: "GET",
                url: "//vimeo.com/api/v2/video/" + i.id + ".json",
                jsonp: "callback",
                dataType: "jsonp",
                success: function(t) {
                    o = t[0].thumbnail_large, u(o)
                }
            }) : "vzaar" === i.type && t.ajax({
                type: "GET",
                url: "//vzaar.com/api/videos/" + i.id + ".json",
                jsonp: "callback",
                dataType: "jsonp",
                success: function(t) {
                    o = t.framegrab_url, u(o)
                }
            })
        }, s.prototype.stop = function() {
            this._core.trigger("stop", null, "video"), this._playing.find(".owl-video-frame").remove(), this._playing.removeClass("owl-video-playing"), this._playing = null, this._core.leave("playing"), this._core.trigger("stopped", null, "video")
        }, s.prototype.play = function(e) {
            var i, n = t(e.target),
                s = n.closest("." + this._core.settings.itemClass),
                o = this._videos[s.attr("data-video")],
                r = o.width || "100%",
                a = o.height || this._core.$stage.height();
            this._playing || (this._core.enter("playing"), this._core.trigger("play", null, "video"), s = this._core.items(this._core.relative(s.index())), this._core.reset(s.index()), "youtube" === o.type ? i = '<iframe width="' + r + '" height="' + a + '" src="//www.youtube.com/embed/' + o.id + "?autoplay=1&rel=0&v=" + o.id + '" frameborder="0" allowfullscreen></iframe>' : "vimeo" === o.type ? i = '<iframe src="//player.vimeo.com/video/' + o.id + '?autoplay=1" width="' + r + '" height="' + a + '" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>' : "vzaar" === o.type && (i = '<iframe frameborder="0"height="' + a + '"width="' + r + '" allowfullscreen mozallowfullscreen webkitAllowFullScreen src="//view.vzaar.com/' + o.id + '/player?autoplay=true"></iframe>'), t('<div class="owl-video-frame">' + i + "</div>").insertAfter(s.find(".owl-video")), this._playing = s.addClass("owl-video-playing"))
        }, s.prototype.isInFullScreen = function() {
            var e = i.fullscreenElement || i.mozFullScreenElement || i.webkitFullscreenElement;
            return e && t(e).parent().hasClass("owl-video-frame")
        }, s.prototype.destroy = function() {
            var t, e;
            this._core.$element.off("click.owl.video");
            for (t in this._handlers) this._core.$element.off(t, this._handlers[t]);
            for (e in Object.getOwnPropertyNames(this)) "function" != typeof this[e] && (this[e] = null)
        }, t.fn.owlCarousel.Constructor.Plugins.Video = s
    }(window.Zepto || window.jQuery, window, document), function(t, e, i, n) {
        var s = function(e) {
            this.core = e, this.core.options = t.extend({}, s.Defaults, this.core.options), this.swapping = !0, this.previous = void 0, this.next = void 0, this.handlers = {
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
        s.Defaults = {
            animateOut: !1,
            animateIn: !1
        }, s.prototype.swap = function() {
            if (1 === this.core.settings.items && t.support.animation && t.support.transition) {
                this.core.speed(0);
                var e, i = t.proxy(this.clear, this),
                    n = this.core.$stage.children().eq(this.previous),
                    s = this.core.$stage.children().eq(this.next),
                    o = this.core.settings.animateIn,
                    r = this.core.settings.animateOut;
                this.core.current() !== this.previous && (r && (e = this.core.coordinates(this.previous) - this.core.coordinates(this.next), n.one(t.support.animation.end, i).css({
                    left: e + "px"
                }).addClass("animated owl-animated-out").addClass(r)), o && s.one(t.support.animation.end, i).addClass("animated owl-animated-in").addClass(o))
            }
        }, s.prototype.clear = function(e) {
            t(e.target).css({
                left: ""
            }).removeClass("animated owl-animated-out owl-animated-in").removeClass(this.core.settings.animateIn).removeClass(this.core.settings.animateOut), this.core.onTransitionEnd()
        }, s.prototype.destroy = function() {
            var t, e;
            for (t in this.handlers) this.core.$element.off(t, this.handlers[t]);
            for (e in Object.getOwnPropertyNames(this)) "function" != typeof this[e] && (this[e] = null)
        }, t.fn.owlCarousel.Constructor.Plugins.Animate = s
    }(window.Zepto || window.jQuery, window, document), function(t, e, i, n) {
        var s = function(e) {
            this._core = e, this._timeout = null, this._paused = !1, this._handlers = {
                "changed.owl.carousel": t.proxy(function(t) {
                    t.namespace && "settings" === t.property.name ? this._core.settings.autoplay ? this.play() : this.stop() : t.namespace && "position" === t.property.name && this._core.settings.autoplay && this._setAutoPlayInterval()
                }, this),
                "initialized.owl.carousel": t.proxy(function(t) {
                    t.namespace && this._core.settings.autoplay && this.play()
                }, this),
                "play.owl.autoplay": t.proxy(function(t, e, i) {
                    t.namespace && this.play(e, i)
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
            }, this._core.$element.on(this._handlers), this._core.options = t.extend({}, s.Defaults, this._core.options)
        };
        s.Defaults = {
            autoplay: !1,
            autoplayTimeout: 5e3,
            autoplayHoverPause: !1,
            autoplaySpeed: !1
        }, s.prototype.play = function(t, e) {
            this._paused = !1, this._core.is("rotating") || (this._core.enter("rotating"), this._setAutoPlayInterval())
        }, s.prototype._getNextTimeout = function(n, s) {
            return this._timeout && e.clearTimeout(this._timeout), e.setTimeout(t.proxy(function() {
                this._paused || this._core.is("busy") || this._core.is("interacting") || i.hidden || this._core.next(s || this._core.settings.autoplaySpeed)
            }, this), n || this._core.settings.autoplayTimeout)
        }, s.prototype._setAutoPlayInterval = function() {
            this._timeout = this._getNextTimeout()
        }, s.prototype.stop = function() {
            this._core.is("rotating") && (e.clearTimeout(this._timeout), this._core.leave("rotating"))
        }, s.prototype.pause = function() {
            this._core.is("rotating") && (this._paused = !0)
        }, s.prototype.destroy = function() {
            var t, e;
            this.stop();
            for (t in this._handlers) this._core.$element.off(t, this._handlers[t]);
            for (e in Object.getOwnPropertyNames(this)) "function" != typeof this[e] && (this[e] = null)
        }, t.fn.owlCarousel.Constructor.Plugins.autoplay = s
    }(window.Zepto || window.jQuery, window, document), function(t, e, i, n) {
        "use strict";
        var s = function(e) {
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
            }, this._core.options = t.extend({}, s.Defaults, this._core.options), this.$element.on(this._handlers)
        };
        s.Defaults = {
            nav: !1,
            navText: ["prev", "next"],
            navSpeed: !1,
            navElement: "div",
            navContainer: !1,
            navContainerClass: "owl-nav",
            navClass: ["owl-prev d-sm-none", "owl-next d-sm-none"],
            slideBy: 1,
            dotClass: "owl-dot",
            dotsClass: "owl-dots",
            dots: !0,
            dotsEach: !1,
            dotsData: !1,
            dotsSpeed: !1,
            dotsContainer: !1
        }, s.prototype.initialize = function() {
            var e, i = this._core.settings;
            this._controls.$relative = (i.navContainer ? t(i.navContainer) : t("<div>").addClass(i.navContainerClass).appendTo(this.$element)).addClass("disabled"), this._controls.$previous = t("<" + i.navElement + ">").addClass(i.navClass[0]).html(i.navText[0]).prependTo(this._controls.$relative).on("click", t.proxy(function(t) {
                this.prev(i.navSpeed)
            }, this)), this._controls.$next = t("<" + i.navElement + ">").addClass(i.navClass[1]).html(i.navText[1]).appendTo(this._controls.$relative).on("click", t.proxy(function(t) {
                this.next(i.navSpeed)
            }, this)), i.dotsData || (this._templates = [t("<div>").addClass(i.dotClass).append(t("<span>")).prop("outerHTML")]), this._controls.$absolute = (i.dotsContainer ? t(i.dotsContainer) : t("<div>").addClass(i.dotsClass).appendTo(this.$element)).addClass("disabled"), this._controls.$absolute.on("click", "div", t.proxy(function(e) {
                var n = t(e.target).parent().is(this._controls.$absolute) ? t(e.target).index() : t(e.target).parent().index();
                e.preventDefault(), this.to(n, i.dotsSpeed)
            }, this));
            for (e in this._overrides) this._core[e] = t.proxy(this[e], this)
        }, s.prototype.destroy = function() {
            var t, e, i, n;
            for (t in this._handlers) this.$element.off(t, this._handlers[t]);
            for (e in this._controls) this._controls[e].remove();
            for (n in this.overides) this._core[n] = this._overrides[n];
            for (i in Object.getOwnPropertyNames(this)) "function" != typeof this[i] && (this[i] = null)
        }, s.prototype.update = function() {
            var t, e, i, n = this._core.clones().length / 2,
                s = n + this._core.items().length,
                o = this._core.maximum(!0),
                r = this._core.settings,
                a = r.center || r.autoWidth || r.dotsData ? 1 : r.dotsEach || r.items;
            if ("page" !== r.slideBy && (r.slideBy = Math.min(r.slideBy, r.items)), r.dots || "page" == r.slideBy)
                for (this._pages = [], t = n, e = 0, i = 0; t < s; t++) {
                    if (e >= a || 0 === e) {
                        if (this._pages.push({
                                start: Math.min(o, t - n),
                                end: t - n + a - 1
                            }), Math.min(o, t - n) === o) break;
                        e = 0, ++i
                    }
                    e += this._core.mergers(this._core.relative(t))
                }
        }, s.prototype.draw = function() {
            var e, i = this._core.settings,
                n = this._core.items().length <= i.items,
                s = this._core.relative(this._core.current()),
                o = i.loop || i.rewind;
            this._controls.$relative.toggleClass("disabled", !i.nav || n), i.nav && (this._controls.$previous.toggleClass("disabled", !o && s <= this._core.minimum(!0)), this._controls.$next.toggleClass("disabled", !o && s >= this._core.maximum(!0))), this._controls.$absolute.toggleClass("disabled", !i.dots || n), i.dots && (e = this._pages.length - this._controls.$absolute.children().length, i.dotsData && 0 !== e ? this._controls.$absolute.html(this._templates.join("")) : e > 0 ? this._controls.$absolute.append(new Array(e + 1).join(this._templates[0])) : e < 0 && this._controls.$absolute.children().slice(e).remove(), this._controls.$absolute.find(".active").removeClass("active"), this._controls.$absolute.children().eq(t.inArray(this.current(), this._pages)).addClass("active"))
        }, s.prototype.onTrigger = function(e) {
            var i = this._core.settings;
            e.page = {
                index: t.inArray(this.current(), this._pages),
                count: this._pages.length,
                size: i && (i.center || i.autoWidth || i.dotsData ? 1 : i.dotsEach || i.items)
            }
        }, s.prototype.current = function() {
            var e = this._core.relative(this._core.current());
            return t.grep(this._pages, t.proxy(function(t, i) {
                return t.start <= e && t.end >= e
            }, this)).pop()
        }, s.prototype.getPosition = function(e) {
            var i, n, s = this._core.settings;
            return "page" == s.slideBy ? (i = t.inArray(this.current(), this._pages), n = this._pages.length, e ? ++i : --i, i = this._pages[(i % n + n) % n].start) : (i = this._core.relative(this._core.current()), n = this._core.items().length, e ? i += s.slideBy : i -= s.slideBy), i
        }, s.prototype.next = function(e) {
            t.proxy(this._overrides.to, this._core)(this.getPosition(!0), e)
        }, s.prototype.prev = function(e) {
            t.proxy(this._overrides.to, this._core)(this.getPosition(!1), e)
        }, s.prototype.to = function(e, i, n) {
            var s;
            !n && this._pages.length ? (s = this._pages.length, t.proxy(this._overrides.to, this._core)(this._pages[(e % s + s) % s].start, i)) : t.proxy(this._overrides.to, this._core)(e, i)
        }, t.fn.owlCarousel.Constructor.Plugins.Navigation = s
    }(window.Zepto || window.jQuery, window, document), function(t, e, i, n) {
        "use strict";
        var s = function(i) {
            this._core = i, this._hashes = {}, this.$element = this._core.$element, this._handlers = {
                "initialized.owl.carousel": t.proxy(function(i) {
                    i.namespace && "URLHash" === this._core.settings.startPosition && t(e).trigger("hashchange.owl.navigation")
                }, this),
                "prepared.owl.carousel": t.proxy(function(e) {
                    if (e.namespace) {
                        var i = t(e.content).find("[data-hash]").addBack("[data-hash]").attr("data-hash");
                        if (!i) return;
                        this._hashes[i] = e.content
                    }
                }, this),
                "changed.owl.carousel": t.proxy(function(i) {
                    if (i.namespace && "position" === i.property.name) {
                        var n = this._core.items(this._core.relative(this._core.current())),
                            s = t.map(this._hashes, function(t, e) {
                                return t === n ? e : null
                            }).join();
                        if (!s || e.location.hash.slice(1) === s) return;
                        e.location.hash = s
                    }
                }, this)
            }, this._core.options = t.extend({}, s.Defaults, this._core.options), this.$element.on(this._handlers), t(e).on("hashchange.owl.navigation", t.proxy(function(t) {
                var i = e.location.hash.substring(1),
                    n = this._core.$stage.children(),
                    s = this._hashes[i] && n.index(this._hashes[i]);
                void 0 !== s && s !== this._core.current() && this._core.to(this._core.relative(s), !1, !0)
            }, this))
        };
        s.Defaults = {
            URLhashListener: !1
        }, s.prototype.destroy = function() {
            var i, n;
            t(e).off("hashchange.owl.navigation");
            for (i in this._handlers) this._core.$element.off(i, this._handlers[i]);
            for (n in Object.getOwnPropertyNames(this)) "function" != typeof this[n] && (this[n] = null)
        }, t.fn.owlCarousel.Constructor.Plugins.Hash = s
    }(window.Zepto || window.jQuery, window, document), function(t, e, i, n) {
        function s(e, i) {
            var s = !1,
                o = e.charAt(0).toUpperCase() + e.slice(1);
            return t.each((e + " " + a.join(o + " ") + o).split(" "), function(t, e) {
                if (r[e] !== n) return s = !i || e, !1
            }), s
        }

        function o(t) {
            return s(t, !0)
        }
        var r = t("<support>").get(0).style,
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
            h = {
                csstransforms: function() {
                    return !!s("transform")
                },
                csstransforms3d: function() {
                    return !!s("perspective")
                },
                csstransitions: function() {
                    return !!s("transition")
                },
                cssanimations: function() {
                    return !!s("animation")
                }
            };
        h.csstransitions() && (t.support.transition = new String(o("transition")), t.support.transition.end = l.transition.end[t.support.transition]), h.cssanimations() && (t.support.animation = new String(o("animation")), t.support.animation.end = l.animation.end[t.support.animation]), h.csstransforms() && (t.support.transform = new String(o("transform")), t.support.transform3d = h.csstransforms3d())
    }(window.Zepto || window.jQuery, window, document), function(t) {
        t.fn.extend({
            hideMaxListItems: function(e) {
                var i = {
                        max: 3,
                        speed: 1e3,
                        moreText: "READ MORE",
                        lessText: "READ LESS",
                        moreHTML: '<p class="maxlist-more"><a href="#"></a></p>'
                    },
                    e = t.extend(i, e);
                return this.each(function() {
                    var i, n = e,
                        s = t(this).children("li").length;
                    if (s > 0 && n.speed > 0 ? (i = Math.round(n.speed / s)) < 1 && (i = 1) : i = 0, s > 0 && s > n.max) {
                        t(this).children("li").each(function(e) {
                            e + 1 > n.max && (t(this).hide(0), t(this).addClass("maxlist-hidden"))
                        });
                        var o = s - n.max,
                            r = n.moreText,
                            a = n.lessText;
                        o > 0 && (r = r.replace("[COUNT]", o), a = a.replace("[COUNT]", o)), t(this).after(n.moreHTML), t(this).next(".maxlist-more").children("a").text(r), t(this).next(".maxlist-more").children("a").click(function(e) {
                            var s = t(this).parent().prev("ul, ol").children("li");
                            if (s = s.slice(n.max), t(this).text() == r) {
                                t(this).text(a);
                                var o = 0;
                                ! function() {
                                    t(s[o++] || []).slideToggle(i, arguments.callee)
                                }()
                            } else {
                                t(this).text(r);
                                var o = s.length - 1;
                                ! function() {
                                    t(s[o--] || []).slideToggle(i, arguments.callee)
                                }()
                            }
                            e.preventDefault()
                        })
                    }
                })
            }
        })
    }(jQuery), void 0 === carouselItems) var carouselItems = 0;
if (void 0 === carouselAutoplay) var carouselAutoplay = !1;
if (void 0 === carouselAutoplayTimeout) var carouselAutoplayTimeout = 1e3;
if (void 0 === carouselLang) var carouselLang = {
    navText: {
        prev: "prev",
        next: "next"
    }
};

// HIDE MAX LIST ITEMS JQUERY PLUGIN
// Version: 1.34
// Author: www.joshuawinn.com
// Usage: Free and Open Source. WTFPL: http://sam.zoy.org/wtfpl/
(function($){
$.fn.extend({ 
hideMaxListItems: function(options) 
{
    // DEFAULT VALUES
    var defaults = {
        max: 3,
        speed: 1000,
        moreText:'View More',
        lessText:'View Less',
        moreHTML:'<p class="maxlist-more"><a href="#"></a></p>', // requires class and child <a>
    };
    var options =  $.extend(defaults, options);
    
    // FOR EACH MATCHED ELEMENT
    return this.each(function() {
        var op = options;
        var totalListItems = $(this).children("li").length;
        var speedPerLI;
        
        // Get animation speed per LI; Divide the total speed by num of LIs. 
        // Avoid dividing by 0 and make it at least 1 for small numbers.
        if ( totalListItems > 0 && op.speed > 0  ) { 
            speedPerLI = Math.round( op.speed / totalListItems );
            if ( speedPerLI < 1 ) { speedPerLI = 1; }
        } else { 
            speedPerLI = 0; 
        }
        
        // If list has more than the "max" option
        if ( (totalListItems > 0) && (totalListItems > op.max) )
        {
            // Initial Page Load: Hide each LI element over the max
            $(this).children("li").each(function(index) {
                if ( (index+1) > op.max ) {
                    $(this).hide(0);
                    $(this).addClass('maxlist-hidden');
                }
            });
            // Replace [COUNT] in "moreText" or "lessText" with number of items beyond max
            var howManyMore = totalListItems - op.max;
            var newMoreText = op.moreText;
            var newLessText = op.lessText;
            
            if (howManyMore > 0){
                newMoreText = newMoreText.replace("[COUNT]", howManyMore);
                newLessText = newLessText.replace("[COUNT]", howManyMore);
            }
            // Add "Read More" button
            $(this).after(op.moreHTML);
            // Add "Read More" text
            $(this).next(".maxlist-more").children("a").text(newMoreText);
            
            // Click events on "Read More" button: Slide up and down
            $(this).next(".maxlist-more").children("a").click(function(e)
            {
                // Get array of children past the maximum option 
                var listElements = $(this).parent().prev("ul, ol").children("li"); 
                listElements = listElements.slice(op.max);
                
                // Sequentially slideToggle the list items
                // For more info on this awesome function: http://goo.gl/dW0nM
                if ( $(this).text() == newMoreText ){
                    $(this).text(newLessText);
                    var i = 0; 
                    (function() { $(listElements[i++] || []).slideToggle(speedPerLI,arguments.callee); })();
                } 
                else {          
                    $(this).text(newMoreText);
                    var i = listElements.length - 1; 
                    (function() { $(listElements[i--] || []).slideToggle(speedPerLI,arguments.callee); })();
                }
                
                // Prevent Default Click Behavior (Scrolling)
                e.preventDefault();
            });
        }
    });
}
});
})(jQuery); // End jQuery Plugin


$(document).ready(function() {
        var t = !1;
        "rtl" === $("html").attr("dir") && (t = !0);
        var e = $(".featured-list-slider"),
            i = {
                0: {
                    items: 1,
                    nav: !0
                },
                600: {
                    items: 3,
                    nav: !1
                },
                1e3: {
                    items: 5,
                    nav: !1,
                    loop: carouselItems > 5
                }
            };
        e.owlCarousel({
            rtl: t,
            nav: !1,
            navText: [carouselLang.navText.prev, carouselLang.navText.next],
            responsiveClass: !0,
            responsive: i,
            autoplay: carouselAutoplay,
            autoplayTimeout: carouselAutoplayTimeout,
            autoplayHoverPause: !0
        }), $("#ajaxTabs li > a").click(function() {
            return $("#allAds").empty().append("<div id='loading text-center'> <br> <img class='center-block' src='images/loading.gif' alt='Loading' /> <br> </div>"), $("#ajaxTabs li").removeClass("active"), $(this).parent("li").addClass("active"), $.ajax({
                url: this.href,
                success: function(t) {
                    $("#allAds").empty().append(t), $(".tooltipHere").tooltip("hide")
                }
            }), !1
        }), urls = $("#ajaxTabs li:first-child a").attr("href"), $("#allAds").empty().append("<div id='loading text-center'> <br> <img class='center-block' src='images/loading.gif' alt='Loading' /> <br>  </div>"), $.ajax({
            url: urls,
            success: function(t) {
                // $("#allAds").empty().append(t), $(".tooltipHere").tooltip("hide"), $(function() {
                //     $(".hasGridView .item-list").addClass("make-grid"), $(".hasGridView .item-list").matchHeight(), $.fn.matchHeight._apply(".hasGridView .item-list")
                // })
            }
        });
        var n = $(".item-list"),
            s = $(".item-list .add-desc-box"),
            o = $(".adds-wrapper"),
            r = readCookie("listing_display_mode");
        r ? ".grid-view" == r ? gridView(".grid-view", n, s, o) : ".list-view" == r ? listView(".list-view", n, s, o) : ".compact-view" == r ? compactView(".compact-view", n, s, o) : listView(".list-view", n, s, o) : createCookie("listing_display_mode", ".list-view", 7), $(".list-view,#ajaxTabs li a").click(function(t) {
            t.preventDefault(), listView(".list-view", n, s, o), createCookie("listing_display_mode", ".list-view", 7)
        }), $(".grid-view").click(function(t) {
            t.preventDefault(), gridView(this, n, s, o), createCookie("listing_display_mode", ".grid-view", 7)
        }), $(function() {
            // $(".hasGridView .item-list").matchHeight(), $.fn.matchHeight._apply(".hasGridView .item-list")
        }), $(function() {
            // $(".row-featured .f-category").matchHeight(), $.fn.matchHeight._apply(".row-featured .f-category")
        }), $(function() {
            // $(".has-equal-div > div").matchHeight(), $.fn.matchHeight._apply(".row-featured .f-category")
        }), $(".compact-view").click(function(t) {
            t.preventDefault(), compactView(this, n, s, o), createCookie("listing_display_mode", ".compact-view", 7)
        }),
        //  $(".long-list").hideMaxListItems({
        //     max: 8,
        //     speed: 500,
        //     moreText: (typeof langLayout !== 'undefined') ? langLayout.hideMaxListItems.moreText + " ([COUNT])" :'',
        //     lessText: (typeof langLayout !== 'undefined') ? langLayout.hideMaxListItems.lessText : '',
        // }), $(".long-list-user").hideMaxListItems({
        //     max: 12,
        //     speed: 500,
        //     moreText: (typeof langLayout !== 'undefined') ? langLayout.hideMaxListItems.moreText + " ([COUNT])" :'',
        //     lessText: (typeof langLayout !== 'undefined') ? langLayout.hideMaxListItems.lessText : '',
        // }), $(".long-list-home").hideMaxListItems({
        //     max: 3,
        //     speed: 500,
        //     moreText: (typeof langLayout !== 'undefined') ? langLayout.hideMaxListItems.moreText + " ([COUNT])":'',
        //     lessText: (typeof langLayout !== 'undefined') ? langLayout.hideMaxListItems.lessText : '',
        // }), 
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        }),
        //  $(".scrollbar").scroller(), $(window).bind("resize load", function() {
        //     $(this).width() < 767 ? ($(".cat-collapse").collapse("hide"), $(".cat-collapse").on("shown.bs.collapse", function() {
        //         $(this).prev(".cat-title").find(".icon-down-open-big").addClass("active-panel")
        //     }), $(".cat-collapse").on("hidden.bs.collapse", function() {
        //         $(this).prev(".cat-title").find(".icon-down-open-big").removeClass("active-panel")
        //     })) : $(".cat-collapse").removeClass("out").addClass("in").css("height", "auto")
        // }),
         $(".tbtn").click(function() {
            $(".themeControll").toggleClass("active")
        }), $("input:radio").click(function() {
            $("input:radio#job-seeker:checked").length > 0 ? ($(".forJobSeeker").removeClass("hide"), $(".forJobFinder").addClass("hide")) : ($(".forJobFinder").removeClass("hide"), $(".forJobSeeker").addClass("hide"))
        }), $(".filter-toggle").click(function() {
            $(".mobile-filter-sidebar").prepend("<div class='closeFilter'>X</div>"), t ? $(".mobile-filter-sidebar").animate({
                right: "0"
            }, 250, "linear", function() {}) : $(".mobile-filter-sidebar").animate({
                left: "0"
            }, 250, "linear", function() {}), $(".menu-overly-mask").addClass("is-visible")
        }), $(".menu-overly-mask").click(function() {
            t ? $(".mobile-filter-sidebar").animate({
                right: "-251px"
            }, 250, "linear", function() {}) : $(".mobile-filter-sidebar").animate({
                left: "-251px"
            }, 250, "linear", function() {}), $(".menu-overly-mask").removeClass("is-visible")
        }), $(document).on("click", ".closeFilter", function() {
            t ? $(".mobile-filter-sidebar").animate({
                right: "-251px"
            }, 250, "linear", function() {}) : $(".mobile-filter-sidebar").animate({
                left: "-251px"
            }, 250, "linear", function() {}), $(".menu-overly-mask").removeClass("is-visible")
        }), $("#browseAdminCities").on("shown.bs.modal", function(t) {
            $("ul.list-link li a").click(function() {
                $("ul.list-link li a").removeClass("active"), $(this).addClass("active"), $(".cityName").text($(this).text()), $("#browseAdminCities").modal("hide")
            })
        }), $("#checkAll").click(function() {
            $(".add-img-selector input:checkbox").not(this).prop("checked", this.checked)
        })
    }),
    function(t) {
        function e(e) {
            void 0 == window.DOMParser && window.ActiveXObject && (DOMParser = function() {}, DOMParser.prototype.parseFromString = function(t) {
                var e = new ActiveXObject("Microsoft.XMLDOM");
                return e.async = "false", e.loadXML(t), e
            });
            try {
                var i = (new DOMParser).parseFromString(e, "text/xml");
                if (!t.isXMLDoc(i)) throw "Unable to parse XML";
                if (1 == t("parsererror", i).length) throw "Error: " + t(i).text();
                return i
            } catch (e) {
                var n = void 0 == e.name ? e : e.name + ": " + e.message;
                return void t(document).trigger("xmlParseError", [n])
            }
        }

        function i(e, i, n) {
            (e.context ? t(e.context) : t.event).trigger(i, n)
        }

        function n(e, i) {
            var s = !0;
            return "string" == typeof i ? t.isFunction(e.test) ? e.test(i) : e == i : (t.each(e, function(o) {
                if (void 0 === i[o]) return s = !1;
                "object" == typeof i[o] && null !== i[o] ? (s && t.isArray(i[o]) && (s = t.isArray(e[o]) && i[o].length === e[o].length), s = s && n(e[o], i[o])) : s = e[o] && t.isFunction(e[o].test) ? s && e[o].test(i[o]) : s && e[o] == i[o]
            }), s)
        }

        function s(e, i) {
            return e[i] === t.mockjaxSettings[i]
        }

        function o(e, i) {
            if (t.isFunction(e)) return e(i);
            if (t.isFunction(e.url.test)) {
                if (!e.url.test(i.url)) return null
            } else {
                var s = e.url.indexOf("*");
                if (e.url !== i.url && -1 === s || !new RegExp(e.url.replace(/[-[\]{}()+?.,\\^$|#\s]/g, "\\$&").replace(/\*/g, ".+")).test(i.url)) return null
            }
            return !e.data || i.data && n(e.data, i.data) ? e && e.type && e.type.toLowerCase() != i.type.toLowerCase() ? null : e : null
        }

        function r(i, n, o) {
            var r = function(s) {
                return function() {
                    return function() {
                        var s;
                        this.status = i.status, this.statusText = i.statusText, this.readyState = 4, t.isFunction(i.response) && i.response(o), "json" == n.dataType && "object" == typeof i.responseText ? this.responseText = JSON.stringify(i.responseText) : "xml" == n.dataType ? "string" == typeof i.responseXML ? (this.responseXML = e(i.responseXML), this.responseText = i.responseXML) : this.responseXML = i.responseXML : this.responseText = i.responseText, "number" != typeof i.status && "string" != typeof i.status || (this.status = i.status), "string" == typeof i.statusText && (this.statusText = i.statusText), s = this.onreadystatechange || this.onload, t.isFunction(s) ? (i.isTimeout && (this.status = -1), s.call(this, i.isTimeout ? "timeout" : void 0)) : i.isTimeout && (this.status = -1)
                    }.apply(s)
                }
            }(this);
            i.proxy ? m({
                global: !1,
                url: i.proxy,
                type: i.proxyType,
                data: i.data,
                dataType: "script" === n.dataType ? "text/plain" : n.dataType,
                complete: function(t) {
                    i.responseXML = t.responseXML, i.responseText = t.responseText, s(i, "status") && (i.status = t.status), s(i, "statusText") && (i.statusText = t.statusText), this.responseTimer = setTimeout(r, i.responseTime || 0)
                }
            }) : !1 === n.async ? r() : this.responseTimer = setTimeout(r, i.responseTime || 50)
        }

        function a(e, i, n, s) {
            return e = t.extend(!0, {}, t.mockjaxSettings, e), void 0 === e.headers && (e.headers = {}), e.contentType && (e.headers["content-type"] = e.contentType), {
                status: e.status,
                statusText: e.statusText,
                readyState: 1,
                open: function() {},
                send: function() {
                    s.fired = !0, r.call(this, e, i, n)
                },
                abort: function() {
                    clearTimeout(this.responseTimer)
                },
                setRequestHeader: function(t, i) {
                    e.headers[t] = i
                },
                getResponseHeader: function(t) {
                    return e.headers && e.headers[t] ? e.headers[t] : "last-modified" == t.toLowerCase() ? e.lastModified || (new Date).toString() : "etag" == t.toLowerCase() ? e.etag || "" : "content-type" == t.toLowerCase() ? e.contentType || "text/plain" : void 0
                },
                getAllResponseHeaders: function() {
                    var i = "";
                    return t.each(e.headers, function(t, e) {
                        i += t + ": " + e + "\n"
                    }), i
                }
            }
        }

        function l(t, e, i) {
            if (h(t), t.dataType = "json", t.data && b.test(t.data) || b.test(t.url)) {
                u(t, e, i);
                var n = /^(\w+:)?\/\/([^\/?#]+)/,
                    s = n.exec(t.url),
                    o = s && (s[1] && s[1] !== location.protocol || s[2] !== location.host);
                if (t.dataType = "script", "GET" === t.type.toUpperCase() && o) {
                    var r = c(t, e, i);
                    return r || !0
                }
            }
            return null
        }

        function h(t) {
            "GET" === t.type.toUpperCase() ? b.test(t.url) || (t.url += (/\?/.test(t.url) ? "&" : "?") + (t.jsonp || "callback") + "=?") : t.data && b.test(t.data) || (t.data = (t.data ? t.data + "&" : "") + (t.jsonp || "callback") + "=?")
        }

        function c(e, i, n) {
            var s = n && n.context || e,
                o = null;
            return i.response && t.isFunction(i.response) ? i.response(n) : "object" == typeof i.responseText ? t.globalEval("(" + JSON.stringify(i.responseText) + ")") : t.globalEval("(" + i.responseText + ")"), d(e, s, i), p(e, s), t.Deferred && (o = new t.Deferred, "object" == typeof i.responseText ? o.resolveWith(s, [i.responseText]) : o.resolveWith(s, [t.parseJSON(i.responseText)])), o
        }

        function u(t, e, i) {
            var n = i && i.context || t,
                s = t.jsonpCallback || "jsonp" + _++;
            t.data && (t.data = (t.data + "").replace(b, "=" + s + "$1")), t.url = t.url.replace(b, "=" + s + "$1"), window[s] = window[s] || function(i) {
                data = i, d(t, n, e), p(t, n), window[s] = void 0;
                try {
                    delete window[s]
                } catch (t) {}
                head && head.removeChild(script)
            }
        }

        function d(t, e, n) {
            t.success && t.success.call(e, n.responseText || "", status, {}), t.global && i(t, "ajaxSuccess", [{}, t])
        }

        function p(e, n) {
            e.complete && e.complete.call(n, {}, status), e.global && i("ajaxComplete", [{}, e]), e.global && !--t.active && t.event.trigger("ajaxStop")
        }

        function f(e, i) {
            var n, s, r;
            "object" == typeof e ? (i = e, e = void 0) : (i = i || {}, i.url = e), s = t.extend(!0, {}, t.ajaxSettings, i);
            for (var h = 0; h < v.length; h++)
                if (v[h] && (r = o(v[h], s))) return y.push(s), t.mockjaxSettings.log(r, s), s.dataType && "JSONP" === s.dataType.toUpperCase() && (n = l(s, r, i)) ? n : (r.cache = s.cache, r.timeout = s.timeout, r.global = s.global, g(r, i), function(e, i, s, o) {
                    n = m.call(t, t.extend(!0, {}, s, {
                        xhr: function() {
                            return a(e, i, s, o)
                        }
                    }))
                }(r, s, i, v[h]), n);
            if (!0 === t.mockjaxSettings.throwUnmocked) throw "AJAX not mocked: " + i.url;
            return m.apply(t, [i])
        }

        function g(t, e) {
            if (t.url instanceof RegExp && t.hasOwnProperty("urlParams")) {
                var i = t.url.exec(e.url);
                if (1 !== i.length) {
                    i.shift();
                    var n = 0,
                        s = i.length,
                        o = t.urlParams.length,
                        r = Math.min(s, o),
                        a = {};
                    for (n; n < r; n++) {
                        a[t.urlParams[n]] = i[n]
                    }
                    e.urlParams = a
                }
            }
        }
        var m = t.ajax,
            v = [],
            y = [],
            b = /=\?(&|$)/,
            _ = (new Date).getTime();
        t.extend({
            ajax: f
        }), t.mockjaxSettings = {
            log: function(e, i) {
                if (!1 !== e.logging && (void 0 !== e.logging || !1 !== t.mockjaxSettings.logging) && window.console && console.log) {
                    var n = "MOCK " + i.type.toUpperCase() + ": " + i.url,
                        s = t.extend({}, i);
                    if ("function" == typeof console.log) console.log(n, s);
                    else try {
                        console.log(n + " " + JSON.stringify(s))
                    } catch (t) {
                        console.log(n)
                    }
                }
            },
            logging: !0,
            status: 200,
            statusText: "OK",
            responseTime: 500,
            isTimeout: !1,
            throwUnmocked: !1,
            contentType: "text/plain",
            response: "",
            responseText: "",
            responseXML: "",
            proxy: "",
            proxyType: "GET",
            lastModified: null,
            etag: "",
            headers: {
                etag: "IJF@H#@923uf8023hFO@I#H#",
                "content-type": "text/plain"
            }
        }, t.mockjax = function(t) {
            var e = v.length;
            return v[e] = t, e
        }, t.mockjaxClear = function(t) {
            1 == arguments.length ? v[t] = null : v = [], y = []
        }, t.mockjax.handler = function(t) {
            if (1 == arguments.length) return v[t]
        }, t.mockjax.mockedAjaxCalls = function() {
            return y
        }
    }(jQuery),
    function(t) {
        "use strict";
        "function" == typeof define && define.amd ? define(["jquery"], t) : t("object" == typeof exports && "function" == typeof require ? require("jquery") : jQuery)
    }(function(t) {
        "use strict";

        function e(i, n) {
            var s = this;
            s.element = i, s.el = t(i), s.suggestions = [], s.badQueries = [], s.selectedIndex = -1, s.currentValue = s.element.value, s.timeoutId = null, s.cachedResponse = {}, s.onChangeTimeout = null, s.onChange = null, s.isLocal = !1, s.suggestionsContainer = null, s.noSuggestionsContainer = null, s.options = t.extend({}, e.defaults, n), s.classes = {
                selected: "autocomplete-selected",
                suggestion: "autocomplete-suggestion"
            }, s.hint = null, s.hintValue = "", s.selection = null, s.initialize(), s.setOptions(n)
        }

        function i(t, e, i) {
            return -1 !== t.value.toLowerCase().indexOf(i)
        }

        function n(e) {
            return "string" == typeof e ? t.parseJSON(e) : e
        }

        function s(t, e) {
            if (!e) return t.value;
            var i = "(" + r.escapeRegExChars(e) + ")";
            return t.value.replace(new RegExp(i, "gi"), "<strong>$1</strong>").replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/&lt;(\/?strong)&gt;/g, "<$1>")
        }

        function o(t, e) {
            return '<div class="autocomplete-group">' + e + "</div>"
        }
        var r = function() {
                return {
                    escapeRegExChars: function(t) {
                        return t.replace(/[|\\{}()[\]^$+*?.]/g, "\\$&")
                    },
                    createNode: function(t) {
                        var e = document.createElement("div");
                        return e.className = t, e.style.position = "absolute", e.style.display = "none", e
                    }
                }
            }(),
            a = {
                ESC: 27,
                TAB: 9,
                RETURN: 13,
                LEFT: 37,
                UP: 38,
                RIGHT: 39,
                DOWN: 40
            },
            l = t.noop;
        e.utils = r, t.Autocomplete = e, e.defaults = {
            ajaxSettings: {},
            autoSelectFirst: !1,
            appendTo: "body",
            serviceUrl: null,
            lookup: null,
            onSelect: null,
            width: "auto",
            minChars: 1,
            maxHeight: 300,
            deferRequestBy: 0,
            params: {},
            formatResult: s,
            formatGroup: o,
            delimiter: null,
            zIndex: 9999,
            type: "GET",
            noCache: !1,
            onSearchStart: l,
            onSearchComplete: l,
            onSearchError: l,
            preserveInput: !1,
            containerClass: "autocomplete-suggestions",
            tabDisabled: !1,
            dataType: "text",
            currentRequest: null,
            triggerSelectOnValidInput: !0,
            preventBadQueries: !0,
            lookupFilter: i,
            paramName: "query",
            transformResult: n,
            showNoSuggestionNotice: !1,
            noSuggestionNotice: "No results",
            orientation: "bottom",
            forceFixPosition: !1
        }, e.prototype = {
            initialize: function() {
                var i, n = this,
                    s = "." + n.classes.suggestion,
                    o = n.classes.selected,
                    r = n.options;
                n.element.setAttribute("autocomplete", "off"), n.noSuggestionsContainer = t('<div class="autocomplete-no-suggestion"></div>').html(this.options.noSuggestionNotice).get(0), n.suggestionsContainer = e.utils.createNode(r.containerClass), i = t(n.suggestionsContainer), i.appendTo(r.appendTo || "body"), "auto" !== r.width && i.css("width", r.width), i.on("mouseover.autocomplete", s, function() {
                    n.activate(t(this).data("index"))
                }), i.on("mouseout.autocomplete", function() {
                    n.selectedIndex = -1, i.children("." + o).removeClass(o)
                }), i.on("click.autocomplete", s, function() {
                    n.select(t(this).data("index"))
                }), i.on("click.autocomplete", function() {
                    clearTimeout(n.blurTimeoutId)
                }), n.fixPositionCapture = function() {
                    n.visible && n.fixPosition()
                }, t(window).on("resize.autocomplete", n.fixPositionCapture), n.el.on("keydown.autocomplete", function(t) {
                    n.onKeyPress(t)
                }), n.el.on("keyup.autocomplete", function(t) {
                    n.onKeyUp(t)
                }), n.el.on("blur.autocomplete", function() {
                    n.onBlur()
                }), n.el.on("focus.autocomplete", function() {
                    n.onFocus()
                }), n.el.on("change.autocomplete", function(t) {
                    n.onKeyUp(t)
                }), n.el.on("input.autocomplete", function(t) {
                    n.onKeyUp(t)
                })
            },
            onFocus: function() {
                var t = this;
                t.fixPosition(), t.el.val().length >= t.options.minChars && t.onValueChange()
            },
            onBlur: function() {
                var t = this;
                t.blurTimeoutId = setTimeout(function() {
                    t.hide()
                }, 200)
            },
            abortAjax: function() {
                var t = this;
                t.currentRequest && (t.currentRequest.abort(), t.currentRequest = null)
            },
            setOptions: function(e) {
                var i = this,
                    n = i.options;
                this.options = t.extend({}, n, e), i.isLocal = Array.isArray(n.lookup), i.isLocal && (n.lookup = i.verifySuggestionsFormat(n.lookup)), n.orientation = i.validateOrientation(n.orientation, "bottom"), t(i.suggestionsContainer).css({
                    "max-height": n.maxHeight + "px",
                    width: n.width + "px",
                    "z-index": n.zIndex
                })
            },
            clearCache: function() {
                this.cachedResponse = {}, this.badQueries = []
            },
            clear: function() {
                this.clearCache(), this.currentValue = "", this.suggestions = []
            },
            disable: function() {
                var t = this;
                t.disabled = !0, clearTimeout(t.onChangeTimeout), t.abortAjax()
            },
            enable: function() {
                this.disabled = !1
            },
            fixPosition: function() {
                var e = this,
                    i = t(e.suggestionsContainer),
                    n = i.parent().get(0);
                if (n === document.body || e.options.forceFixPosition) {
                    var s = e.options.orientation,
                        o = i.outerHeight(),
                        r = e.el.outerHeight(),
                        a = e.el.offset(),
                        l = {
                            top: a.top,
                            left: a.left
                        };
                    if ("auto" === s) {
                        var h = t(window).height(),
                            c = t(window).scrollTop(),
                            u = -c + a.top - o,
                            d = c + h - (a.top + r + o);
                        s = Math.max(u, d) === u ? "top" : "bottom"
                    }
                    if (l.top += "top" === s ? -o : r, n !== document.body) {
                        var p, f = i.css("opacity");
                        e.visible || i.css("opacity", 0).show(), p = i.offsetParent().offset(), l.top -= p.top, l.left -= p.left, e.visible || i.css("opacity", f).hide()
                    }
                    "auto" === e.options.width && (l.width = e.el.outerWidth() + "px"), i.css(l)
                }
            },
            isCursorAtEnd: function() {
                var t, e = this,
                    i = e.el.val().length,
                    n = e.element.selectionStart;
                return "number" == typeof n ? n === i : !document.selection || (t = document.selection.createRange(), t.moveStart("character", -i), i === t.text.length)
            },
            onKeyPress: function(t) {
                var e = this;
                if (!e.disabled && !e.visible && t.which === a.DOWN && e.currentValue) return void e.suggest();
                if (!e.disabled && e.visible) {
                    switch (t.which) {
                        case a.ESC:
                            e.el.val(e.currentValue), e.hide();
                            break;
                        case a.RIGHT:
                            if (e.hint && e.options.onHint && e.isCursorAtEnd()) {
                                e.selectHint();
                                break
                            }
                            return;
                        case a.TAB:
                            if (e.hint && e.options.onHint) return void e.selectHint();
                            if (-1 === e.selectedIndex) return void e.hide();
                            if (e.select(e.selectedIndex), !1 === e.options.tabDisabled) return;
                            break;
                        case a.RETURN:
                            if (-1 === e.selectedIndex) return void e.hide();
                            e.select(e.selectedIndex);
                            break;
                        case a.UP:
                            e.moveUp();
                            break;
                        case a.DOWN:
                            e.moveDown();
                            break;
                        default:
                            return
                    }
                    t.stopImmediatePropagation(), t.preventDefault()
                }
            },
            onKeyUp: function(t) {
                var e = this;
                if (!e.disabled) {
                    switch (t.which) {
                        case a.UP:
                        case a.DOWN:
                            return
                    }
                    clearTimeout(e.onChangeTimeout), e.currentValue !== e.el.val() && (e.findBestHint(), e.options.deferRequestBy > 0 ? e.onChangeTimeout = setTimeout(function() {
                        e.onValueChange()
                    }, e.options.deferRequestBy) : e.onValueChange())
                }
            },
            onValueChange: function() {
                var e = this,
                    i = e.options,
                    n = e.el.val(),
                    s = e.getQuery(n);
                return e.selection && e.currentValue !== s && (e.selection = null, (i.onInvalidateSelection || t.noop).call(e.element)), clearTimeout(e.onChangeTimeout), e.currentValue = n, e.selectedIndex = -1, i.triggerSelectOnValidInput && e.isExactMatch(s) ? void e.select(0) : void(s.length < i.minChars ? e.hide() : e.getSuggestions(s))
            },
            isExactMatch: function(t) {
                var e = this.suggestions;
                return 1 === e.length && e[0].value.toLowerCase() === t.toLowerCase()
            },
            getQuery: function(e) {
                var i, n = this.options.delimiter;
                return n ? (i = e.split(n), t.trim(i[i.length - 1])) : e
            },
            getSuggestionsLocal: function(e) {
                var i, n = this,
                    s = n.options,
                    o = e.toLowerCase(),
                    r = s.lookupFilter,
                    a = parseInt(s.lookupLimit, 10);
                return i = {
                    suggestions: t.grep(s.lookup, function(t) {
                        return r(t, e, o)
                    })
                }, a && i.suggestions.length > a && (i.suggestions = i.suggestions.slice(0, a)), i
            },
            getSuggestions: function(e) {
                var i, n, s, o, r = this,
                    a = r.options,
                    l = a.serviceUrl;
                if (a.params[a.paramName] = e, !1 !== a.onSearchStart.call(r.element, a.params)) {
                    if (n = a.ignoreParams ? null : a.params, t.isFunction(a.lookup)) return void a.lookup(e, function(t) {
                        r.suggestions = t.suggestions, r.suggest(), a.onSearchComplete.call(r.element, e, t.suggestions)
                    });
                    r.isLocal ? i = r.getSuggestionsLocal(e) : (t.isFunction(l) && (l = l.call(r.element, e)), s = l + "?" + t.param(n || {}), i = r.cachedResponse[s]), i && Array.isArray(i.suggestions) ? (r.suggestions = i.suggestions, r.suggest(), a.onSearchComplete.call(r.element, e, i.suggestions)) : r.isBadQuery(e) ? a.onSearchComplete.call(r.element, e, []) : (r.abortAjax(), o = {
                        url: l,
                        data: n,
                        type: a.type,
                        dataType: a.dataType
                    }, t.extend(o, a.ajaxSettings), r.currentRequest = t.ajax(o).done(function(t) {
                        var i;
                        r.currentRequest = null, i = a.transformResult(t, e), r.processResponse(i, e, s), a.onSearchComplete.call(r.element, e, i.suggestions)
                    }).fail(function(t, i, n) {
                        a.onSearchError.call(r.element, e, t, i, n)
                    }))
                }
            },
            isBadQuery: function(t) {
                if (!this.options.preventBadQueries) return !1;
                for (var e = this.badQueries, i = e.length; i--;)
                    if (0 === t.indexOf(e[i])) return !0;
                return !1
            },
            hide: function() {
                var e = this,
                    i = t(e.suggestionsContainer);
                t.isFunction(e.options.onHide) && e.visible && e.options.onHide.call(e.element, i), e.visible = !1, e.selectedIndex = -1, clearTimeout(e.onChangeTimeout), t(e.suggestionsContainer).hide(), e.signalHint(null)
            },
            suggest: function() {
                if (!this.suggestions.length) return void(this.options.showNoSuggestionNotice ? this.noSuggestions() : this.hide());
                var e, i = this,
                    n = i.options,
                    s = n.groupBy,
                    o = n.formatResult,
                    r = i.getQuery(i.currentValue),
                    a = i.classes.suggestion,
                    l = i.classes.selected,
                    h = t(i.suggestionsContainer),
                    c = t(i.noSuggestionsContainer),
                    u = n.beforeRender,
                    d = "",
                    p = function(t, i) {
                        var o = t.data[s];
                        return e === o ? "" : (e = o, n.formatGroup(t, e))
                    };
                return n.triggerSelectOnValidInput && i.isExactMatch(r) ? void i.select(0) : (t.each(i.suggestions, function(t, e) {
                    s && (d += p(e, 0)), d += '<div class="' + a + '" data-index="' + t + '">' + o(e, r, t) + "</div>"
                }), this.adjustContainerWidth(), c.detach(), h.html(d), t.isFunction(u) && u.call(i.element, h, i.suggestions), i.fixPosition(), h.show(), n.autoSelectFirst && (i.selectedIndex = 0, h.scrollTop(0), h.children("." + a).first().addClass(l)), i.visible = !0, void i.findBestHint())
            },
            noSuggestions: function() {
                var e = this,
                    i = e.options.beforeRender,
                    n = t(e.suggestionsContainer),
                    s = t(e.noSuggestionsContainer);
                this.adjustContainerWidth(), s.detach(), n.empty(), n.append(s), t.isFunction(i) && i.call(e.element, n, e.suggestions), e.fixPosition(), n.show(), e.visible = !0
            },
            adjustContainerWidth: function() {
                var e, i = this,
                    n = i.options,
                    s = t(i.suggestionsContainer);
                "auto" === n.width ? (e = i.el.outerWidth(), s.css("width", e > 0 ? e : 300)) : "flex" === n.width && s.css("width", "")
            },
            findBestHint: function() {
                var e = this,
                    i = e.el.val().toLowerCase(),
                    n = null;
                i && (t.each(e.suggestions, function(t, e) {
                    var s = 0 === e.value.toLowerCase().indexOf(i);
                    return s && (n = e), !s
                }), e.signalHint(n))
            },
            signalHint: function(e) {
                var i = "",
                    n = this;
                e && (i = n.currentValue + e.value.substr(n.currentValue.length)), n.hintValue !== i && (n.hintValue = i, n.hint = e, (this.options.onHint || t.noop)(i))
            },
            verifySuggestionsFormat: function(e) {
                return e.length && "string" == typeof e[0] ? t.map(e, function(t) {
                    return {
                        value: t,
                        data: null
                    }
                }) : e
            },
            validateOrientation: function(e, i) {
                return e = t.trim(e || "").toLowerCase(), -1 === t.inArray(e, ["auto", "bottom", "top"]) && (e = i), e
            },
            processResponse: function(t, e, i) {
                var n = this,
                    s = n.options;
                t.suggestions = n.verifySuggestionsFormat(t.suggestions), s.noCache || (n.cachedResponse[i] = t, s.preventBadQueries && !t.suggestions.length && n.badQueries.push(e)), e === n.getQuery(n.currentValue) && (n.suggestions = t.suggestions, n.suggest())
            },
            activate: function(e) {
                var i, n = this,
                    s = n.classes.selected,
                    o = t(n.suggestionsContainer),
                    r = o.find("." + n.classes.suggestion);
                return o.find("." + s).removeClass(s), n.selectedIndex = e, -1 !== n.selectedIndex && r.length > n.selectedIndex ? (i = r.get(n.selectedIndex), t(i).addClass(s), i) : null
            },
            selectHint: function() {
                var e = this,
                    i = t.inArray(e.hint, e.suggestions);
                e.select(i)
            },
            select: function(t) {
                var e = this;
                e.hide(), e.onSelect(t)
            },
            moveUp: function() {
                var e = this;
                if (-1 !== e.selectedIndex) return 0 === e.selectedIndex ? (t(e.suggestionsContainer).children().first().removeClass(e.classes.selected), e.selectedIndex = -1, e.el.val(e.currentValue), void e.findBestHint()) : void e.adjustScroll(e.selectedIndex - 1)
            },
            moveDown: function() {
                var t = this;
                t.selectedIndex !== t.suggestions.length - 1 && t.adjustScroll(t.selectedIndex + 1)
            },
            adjustScroll: function(e) {
                var i = this,
                    n = i.activate(e);
                if (n) {
                    var s, o, r, a = t(n).outerHeight();
                    s = n.offsetTop, o = t(i.suggestionsContainer).scrollTop(), r = o + i.options.maxHeight - a, o > s ? t(i.suggestionsContainer).scrollTop(s) : s > r && t(i.suggestionsContainer).scrollTop(s - i.options.maxHeight + a), i.options.preserveInput || i.el.val(i.getValue(i.suggestions[e].value)), i.signalHint(null)
                }
            },
            onSelect: function(e) {
                var i = this,
                    n = i.options.onSelect,
                    s = i.suggestions[e];
                i.currentValue = i.getValue(s.value), i.currentValue === i.el.val() || i.options.preserveInput || i.el.val(i.currentValue), i.signalHint(null), i.suggestions = [], i.selection = s, t.isFunction(n) && n.call(i.element, s)
            },
            getValue: function(t) {
                var e, i, n = this,
                    s = n.options.delimiter;
                return s ? (e = n.currentValue, i = e.split(s), 1 === i.length ? t : e.substr(0, e.length - i[i.length - 1].length) + t) : t
            },
            dispose: function() {
                var e = this;
                e.el.off(".autocomplete").removeData("autocomplete"), t(window).off("resize.autocomplete", e.fixPositionCapture), t(e.suggestionsContainer).remove()
            }
        }, t.fn.devbridgeAutocomplete = function(i, n) {
            var s = "autocomplete";
            return arguments.length ? this.each(function() {
                var o = t(this),
                    r = o.data(s);
                "string" == typeof i ? r && "function" == typeof r[i] && r[i](n) : (r && r.dispose && r.dispose(), r = new e(this, i), o.data(s, r))
            }) : this.first().data(s)
        }, t.fn.autocomplete || (t.fn.autocomplete = t.fn.devbridgeAutocomplete)
    }), $(document).ready(function() {
        var t = $('meta[name="csrf-token"]').attr("content");
        t && $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": t
            }
        })
        // ,
        //  $("input#locSearch").devbridgeAutocomplete({
        //     zIndex: 1492,
        //     serviceUrl: siteUrl + "/ajax/countries/" + countryCode + "/cities/autocomplete",
        //     type: "post",
        //     data: {
        //         city: $(this).val(),
        //         _token: $("input[name=_token]").val()
        //     },
        //     minChars: 1,
        //     onSelect: function(t) {
        //         $("#lSearch").val(t.data)
        //     }
        // })
    }),
    function(t) {
        t.widget("ui.tagit", {
            options: {
                allowDuplicates: !1,
                caseSensitive: !0,
                fieldName: "tags",
                placeholderText: null,
                readOnly: !1,
                removeConfirmation: !1,
                tagLimit: null,
                availableTags: [],
                autocomplete: {},
                showAutocompleteOnFocus: !1,
                allowSpaces: !1,
                singleField: !1,
                singleFieldDelimiter: ",",
                singleFieldNode: null,
                animate: !0,
                tabIndex: null,
                beforeTagAdded: null,
                afterTagAdded: null,
                beforeTagRemoved: null,
                afterTagRemoved: null,
                onTagClicked: null,
                onTagLimitExceeded: null,
                onTagAdded: null,
                onTagRemoved: null,
                tagSource: null
            },
            _create: function() {
                var e = this;
                this.element.is("input") ? (this.tagList = t("<ul></ul>").insertAfter(this.element), this.options.singleField = !0, this.options.singleFieldNode = this.element, this.element.addClass("tagit-hidden-field")) : this.tagList = this.element.find("ul, ol").andSelf().last(), this.tagInput = t('<input type="text" />').addClass("ui-widget-content"), this.options.readOnly && this.tagInput.attr("disabled", "disabled"), this.options.tabIndex && this.tagInput.attr("tabindex", this.options.tabIndex), this.options.placeholderText && this.tagInput.attr("placeholder", this.options.placeholderText), this.options.autocomplete.source || (this.options.autocomplete.source = function(e, i) {
                    var n = e.term.toLowerCase(),
                        s = t.grep(this.options.availableTags, function(t) {
                            return 0 === t.toLowerCase().indexOf(n)
                        });
                    this.options.allowDuplicates || (s = this._subtractArray(s, this.assignedTags())), i(s)
                }), this.options.showAutocompleteOnFocus && (this.tagInput.focus(function(t, i) {
                    e._showAutocomplete()
                }), void 0 === this.options.autocomplete.minLength && (this.options.autocomplete.minLength = 0)), t.isFunction(this.options.autocomplete.source) && (this.options.autocomplete.source = t.proxy(this.options.autocomplete.source, this)), t.isFunction(this.options.tagSource) && (this.options.tagSource = t.proxy(this.options.tagSource, this)), this.tagList.addClass("tagit").addClass("ui-widget ui-widget-content ui-corner-all").append(t('<li class="tagit-new"></li>').append(this.tagInput)).click(function(i) {
                    var n = t(i.target);
                    n.hasClass("tagit-label") ? (n = n.closest(".tagit-choice"), n.hasClass("removed") || e._trigger("onTagClicked", i, {
                        tag: n,
                        tagLabel: e.tagLabel(n)
                    })) : e.tagInput.focus()
                });
                var i = !1;
                if (this.options.singleField)
                    if (this.options.singleFieldNode) {
                        var n = t(this.options.singleFieldNode),
                            s = n.val().split(this.options.singleFieldDelimiter);
                        n.val(""), t.each(s, function(t, n) {
                            e.createTag(n, null, !0), i = !0
                        })
                    } else this.options.singleFieldNode = t('<input type="hidden" style="display:none;" value="" name="' + this.options.fieldName + '" />'), this.tagList.after(this.options.singleFieldNode);
                i || this.tagList.children("li").each(function() {
                    t(this).hasClass("tagit-new") || (e.createTag(t(this).text(), t(this).attr("class"), !0), t(this).remove())
                }), this.tagInput.keydown(function(i) {
                    if (i.which == t.ui.keyCode.BACKSPACE && "" === e.tagInput.val()) {
                        var n = e._lastTag();
                        !e.options.removeConfirmation || n.hasClass("remove") ? e.removeTag(n) : e.options.removeConfirmation && n.addClass("remove ui-state-highlight")
                    } else e.options.removeConfirmation && e._lastTag().removeClass("remove ui-state-highlight");
                    (i.which === t.ui.keyCode.COMMA && !1 === i.shiftKey || i.which === t.ui.keyCode.ENTER || i.which == t.ui.keyCode.TAB && "" !== e.tagInput.val() || i.which == t.ui.keyCode.SPACE && !0 !== e.options.allowSpaces && ('"' != t.trim(e.tagInput.val()).replace(/^s*/, "").charAt(0) || '"' == t.trim(e.tagInput.val()).charAt(0) && '"' == t.trim(e.tagInput.val()).charAt(t.trim(e.tagInput.val()).length - 1) && 0 != t.trim(e.tagInput.val()).length - 1)) && (i.which === t.ui.keyCode.ENTER && "" === e.tagInput.val() || i.preventDefault(), e.options.autocomplete.autoFocus && e.tagInput.data("autocomplete-open") || (e.tagInput.autocomplete("close"), e.createTag(e._cleanedInput())))
                }).blur(function(t) {
                    e.tagInput.data("autocomplete-open") || e.createTag(e._cleanedInput())
                }), (this.options.availableTags || this.options.tagSource || this.options.autocomplete.source) && (n = {
                    select: function(t, i) {
                        return e.createTag(i.item.value), !1
                    }
                }, t.extend(n, this.options.autocomplete), n.source = this.options.tagSource || n.source, this.tagInput.autocomplete(n).bind("autocompleteopen.tagit", function(t, i) {
                    e.tagInput.data("autocomplete-open", !0)
                }).bind("autocompleteclose.tagit", function(t, i) {
                    e.tagInput.data("autocomplete-open", !1)
                }), this.tagInput.autocomplete("widget").addClass("tagit-autocomplete"))
            },
            destroy: function() {
                return t.Widget.prototype.destroy.call(this), this.element.unbind(".tagit"), this.tagList.unbind(".tagit"), this.tagInput.removeData("autocomplete-open"), this.tagList.removeClass("tagit ui-widget ui-widget-content ui-corner-all tagit-hidden-field"), this.element.is("input") ? (this.element.removeClass("tagit-hidden-field"), this.tagList.remove()) : (this.element.children("li").each(function() {
                    t(this).hasClass("tagit-new") ? t(this).remove() : (t(this).removeClass("tagit-choice ui-widget-content ui-state-default ui-state-highlight ui-corner-all remove tagit-choice-editable tagit-choice-read-only"), t(this).text(t(this).children(".tagit-label").text()))
                }), this.singleFieldNode && this.singleFieldNode.remove()), this
            },
            _cleanedInput: function() {
                return t.trim(this.tagInput.val().replace(/^"(.*)"$/, "$1"))
            },
            _lastTag: function() {
                return this.tagList.find(".tagit-choice:last:not(.removed)")
            },
            _tags: function() {
                return this.tagList.find(".tagit-choice:not(.removed)")
            },
            assignedTags: function() {
                var e = this,
                    i = [];
                return this.options.singleField ? (i = t(this.options.singleFieldNode).val().split(this.options.singleFieldDelimiter), "" === i[0] && (i = [])) : this._tags().each(function() {
                    i.push(e.tagLabel(this))
                }), i
            },
            _updateSingleTagsField: function(e) {
                t(this.options.singleFieldNode).val(e.join(this.options.singleFieldDelimiter)).trigger("change")
            },
            _subtractArray: function(e, i) {
                for (var n = [], s = 0; s < e.length; s++) - 1 == t.inArray(e[s], i) && n.push(e[s]);
                return n
            },
            tagLabel: function(e) {
                return this.options.singleField ? t(e).find(".tagit-label:first").text() : t(e).find("input:first").val()
            },
            _showAutocomplete: function() {
                this.tagInput.autocomplete("search", "")
            },
            _findTagByLabel: function(e) {
                var i = this,
                    n = null;
                return this._tags().each(function(s) {
                    if (i._formatStr(e) == i._formatStr(i.tagLabel(this))) return n = t(this), !1
                }), n
            },
            _isNew: function(t) {
                return !this._findTagByLabel(t)
            },
            _formatStr: function(e) {
                return this.options.caseSensitive ? e : t.trim(e.toLowerCase())
            },
            _effectExists: function(e) {
                return Boolean(t.effects && (t.effects[e] || t.effects.effect && t.effects.effect[e]))
            },
            createTag: function(e, i, n) {
                var s = this;
                if (e = t.trim(e), this.options.preprocessTag && (e = this.options.preprocessTag(e)), "" === e) return !1;
                if (!this.options.allowDuplicates && !this._isNew(e)) return e = this._findTagByLabel(e), !1 !== this._trigger("onTagExists", null, {
                    existingTag: e,
                    duringInitialization: n
                }) && this._effectExists("highlight") && e.effect("highlight"), !1;
                if (this.options.tagLimit && this._tags().length >= this.options.tagLimit) return this._trigger("onTagLimitExceeded", null, {
                    duringInitialization: n
                }), !1;
                var o = t(this.options.onTagClicked ? '<a class="tagit-label"></a>' : '<span class="tagit-label"></span>').text(e),
                    r = t("<li></li>").addClass("tagit-choice ui-widget-content ui-state-default ui-corner-all").addClass(i).append(o);
                this.options.readOnly ? r.addClass("tagit-choice-read-only") : (r.addClass("tagit-choice-editable"), i = t("<span></span>").addClass("ui-icon ui-icon-close"), i = t('<a><span class="text-icon">×</span></a>').addClass("tagit-close").append(i).click(function(t) {
                    s.removeTag(r)
                }), r.append(i)), this.options.singleField || (o = o.html(), r.append('<input type="hidden" value="' + o + '" name="' + this.options.fieldName + '" class="tagit-hidden-field" />')), !1 !== this._trigger("beforeTagAdded", null, {
                    tag: r,
                    tagLabel: this.tagLabel(r),
                    duringInitialization: n
                }) && (this.options.singleField && (o = this.assignedTags(), o.push(e), this._updateSingleTagsField(o)), this._trigger("onTagAdded", null, r), this.tagInput.val(""), this.tagInput.parent().before(r), this._trigger("afterTagAdded", null, {
                    tag: r,
                    tagLabel: this.tagLabel(r),
                    duringInitialization: n
                }), this.options.showAutocompleteOnFocus && !n && setTimeout(function() {
                    s._showAutocomplete()
                }, 0))
            },
            removeTag: function(e, i) {
                if (i = void 0 === i ? this.options.animate : i, e = t(e), this._trigger("onTagRemoved", null, e), !1 !== this._trigger("beforeTagRemoved", null, {
                        tag: e,
                        tagLabel: this.tagLabel(e)
                    })) {
                    if (this.options.singleField) {
                        var n = this.assignedTags(),
                            s = this.tagLabel(e),
                            n = t.grep(n, function(t) {
                                return t != s
                            });
                        this._updateSingleTagsField(n)
                    }
                    if (i) {
                        e.addClass("removed");
                        var n = this._effectExists("blind") ? ["blind", {
                                direction: "horizontal"
                            }, "fast"] : ["fast"],
                            o = this;
                        n.push(function() {
                            e.remove(), o._trigger("afterTagRemoved", null, {
                                tag: e,
                                tagLabel: o.tagLabel(e)
                            })
                        }), e.fadeOut("fast").hide.apply(e, n).dequeue()
                    } else e.remove(), this._trigger("afterTagRemoved", null, {
                        tag: e,
                        tagLabel: this.tagLabel(e)
                    })
                }
            },
            removeTagByLabel: function(t, e) {
                var i = this._findTagByLabel(t);
                if (!i) throw "No such tag exists with the name '" + t + "'";
                this.removeTag(i, e)
            },
            removeAll: function() {
                var t = this;
                this._tags().each(function(e, i) {
                    t.removeTag(i, !1)
                })
            }
        })
    }(jQuery),
    function(t, e) {
        "use strict";
        "function" == typeof define && define.amd ? define(["jquery"], function(i) {
            return t.waitingDialog = e(i)
        }) : t.waitingDialog = t.waitingDialog || e(t.jQuery)
    }(this, function(t) {
        "use strict";

        function e(e) {
            return e && e.remove(), t('<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;"><div class="modal-dialog modal-m"><div class="modal-content"><div class="modal-header" style="display: none;"></div><div class="modal-body"><div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div></div></div></div></div>')
        }
        var i, n;
        return {
            show: function(s, o) {
                void 0 === o && (o = {}), void 0 === s && (s = "Loading"), n = t.extend({
                    headerText: "",
                    headerSize: 3,
                    headerClass: "",
                    dialogSize: "m",
                    progressType: "",
                    contentElement: "p",
                    contentClass: "content",
                    onHide: null,
                    onShow: null
                }, o);
                var r, a;
                i = e(i), i.find(".modal-dialog").attr("class", "modal-dialog").addClass("modal-" + n.dialogSize), i.find(".progress-bar").attr("class", "progress-bar"), n.progressType && i.find(".progress-bar").addClass("progress-bar-" + n.progressType), r = t("<h" + n.headerSize + " />"), r.css({
                    margin: 0
                }), n.headerClass && r.addClass(n.headerClass), a = t("<" + n.contentElement + " />"), n.contentClass && a.addClass(n.contentClass), !1 === n.headerText ? (a.html(s), i.find(".modal-body").prepend(a)) : n.headerText ? (r.html(n.headerText), i.find(".modal-header").html(r).show(), a.html(s), i.find(".modal-body").prepend(a)) : (r.html(s), i.find(".modal-header").html(r).show()), "function" == typeof n.onHide && i.off("hidden.bs.modal").on("hidden.bs.modal", function() {
                    n.onHide.call(i)
                }), "function" == typeof n.onShow && i.off("shown.bs.modal").on("shown.bs.modal", function() {
                    n.onShow.call(i)
                }), i.modal()
            },
            hide: function() {
                void 0 !== i && i.modal("hide")
            },
            message: function(t) {
                return void 0 !== i ? void 0 !== t ? i.find(".modal-header>h" + n.headerSize).html(t) : i.find(".modal-header>h" + n.headerSize).html() : void 0
            }
        }
    }), $.fn.goValidate = function() {
        var t = this,
            e = t.find("input:text"),
            i = {
                name: {
                    regex: /^[A-Za-z]{3,}$/
                },
                pass: {
                    regex: /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/
                },
                email: {
                    regex: /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/
                },
                phone: {
                    regex: /^[2-9]\d{2}-\d{3}-\d{4}$/
                }
            },
            n = function(t, e) {
                var n = !0,
                    s = "";
                return !e && /required/.test(t) ? (s = "This field is required", n = !1) : (t = t.split(/\s/), $.each(t, function(t, o) {
                    i[o] && e && !i[o].regex.test(e) && (n = !1, s = i[o].error)
                })), {
                    isValid: n,
                    error: s
                }
            },
            s = function(t) {
                var e = t.attr("class"),
                    i = t.val(),
                    s = n(e, i);
                t.removeClass("invalid"), $("#form-error").addClass("hide"), s.isValid ? t.popover("hide") : (t.addClass("invalid"), void 0 !== t.data("shown") && 0 != t.data("shown") || t.popover("show"))
            };
        return e.keyup(function() {
            s($(this))
        }), e.on("shown.bs.popover", function() {
            $(this).data("shown", !0)
        }), e.on("hidden.bs.popover", function() {
            $(this).data("shown", !1)
        }), t.submit(function(i) {
            e.each(function() {
                ($(this).is(".required") || $(this).hasClass("invalid")) && s($(this))
            }), t.find("input.invalid").length && (i.preventDefault(), $("#form-error").toggleClass("hide"))
        }), this
    }, $("form").goValidate(), $(document).ready(function() {
        var t = $('meta[name="csrf-token"]').attr("content");
        t && $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": t
            }
        }), $(".showphone").click(function() {
            showPhone()
        })
    }), $(document).ready(function() {
        var t = $('meta[name="csrf-token"]').attr("content");
        t && $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": t
            }
        }), $("#subCatsList h5 a").click(function() {
            return $("#subCatsList").hide(), $("#catsList").show(), !1
        }), $(".make-favorite, .save-job, a.saved-job").click(function() {
            alert();
            savePost(this)
        }), $("#saveSearch").click(function() {
            saveSearch(this)
        })
    });