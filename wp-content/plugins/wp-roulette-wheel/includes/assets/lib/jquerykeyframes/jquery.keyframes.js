/**
 * StyleFix 1.0.3 & PrefixFree 1.0.7
 * @author Lea Verou
 * MIT license
 */
(function($) {

	"use strict";
	var e = !1;
	var n = "animation";
	var t = "";
	var prefix = "";
	var i = ["Webkit", "Moz", "O", "ms", "Khtml"];
	$(document).ready(function() {
		var o = document.body.style;
		if (void 0 !== o.animationName && (e = !0), e === !1)
			for (var a = 0; a < i.length; a++)
				if (void 0 !== o[i[a] + "AnimationName"]) {
					prefix = i[a], n = prefix + "Animation", t = "-" + prefix.toLowerCase() + "-", e = !0;
					break
				}
			});
	var o = function(e, n) {
		return $.keyframe.debug && console.log(e + " " + n), $("<style>" + n + "</style>").attr({
			"class": "keyframe-style",
			id: e,
			type: "text/css"
		}).appendTo("head")
	};
	$.keyframe = {
		debug: !1,
		getVendorPrefix: function() {
			return t;
		},
		isSupported: function() {
			return e;
		},
		generate: function(e) {
			var i = e.name || "",
			a = "@" + t + "keyframes " + i + " {";
			for (var r in e)
				if ("name" !== r && "media" !== r && "complete" !== r) {
					a += r + " {";
					for (var s in e[r]) a += s + ":" + e[r][s] + ";";
						a += "}"
				}
				window.PrefixFree ? a = PrefixFree.prefixCSS(a + "}") : a += "}", e.media && (a = "@media " + e.media + "{" + a + "}");
				var f = $("style#" + e.name);
				if (f.length > 0) {
					f.html(a);
					var l = $("*").filter(function() {
						return (this.style[n + "Name"] === i);
					});
					l.each(function() {
						var e = $(this),
						n = e.data("keyframeOptions");
						e.resetKeyframe(function() {
							e.playKeyframe(n)
						})
					})
				} else o(i, a)
			},
			define: function(e) {
				if (e.length)
					for (var n = 0; n < e.length; n++) {
						var t = e[n];
						this.generate(t);
					} else this.generate(e);
				}
			};
			var a = "animation-play-state",
			r = "running";
			$.fn.resetKeyframe = function(e) {
				$(this).css(t + a, r).css(t + "animation", "none");
				e && setTimeout(e, 1)
			}, $.fn.pauseKeyframe = function() {
				$(this).css(t + a, "paused");
			}, $.fn.resumeKeyframe = function() {
				$(this).css(t + a, r);
			}, $.fn.playKeyframe = function(e, n) {
				var i = function(e) {
					return e = $.extend({
						duration: "0s",
						timingFunction: "ease",
						delay: "0s",
						iterationCount: 1,
						direction: "normal",
						fillMode: "forwards"
					}, e), [e.name, e.duration, e.timingFunction, e.delay, e.iterationCount, e.direction, e.fillMode].join(" ")
				},
				o = "";
				if ($.isArray(e)) {
					for (var s = [], f = 0; f < e.length; f++) s.push("string" == typeof e[f] ? e[f] : i(e[f]));
						o = s.join(", ");
				} else o = "string" == typeof e ? e : i(e);
				var l = t + "animation",
				m = ["webkit", "moz", "MS", "o", ""];
				!n && e.complete && (n = e.complete);
				var c = function(e, n, t) {
					for (var i = 0; i < m.length; i++) {
						m[i] || (n = n.toLowerCase());
						var o = m[i] + n;
						e.off(o).on(o, t)
					}
				};
				return this.each(function() {
					var i = $(this).addClass("boostKeyframe").css(t + a, r).css(l, o).data("keyframeOptions", e);
					n && (c(i, "AnimationIteration", n), c(i, "AnimationEnd", n))
				}), this
			}, o("boost-keyframe", " .boostKeyframe{" + t + "transform:scale3d(1,1,1);}")
		})(jQuery);