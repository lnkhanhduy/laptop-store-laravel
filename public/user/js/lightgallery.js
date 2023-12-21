/*! lightgallery - v1.2.19 - 2016-05-17
 * http://sachinchoolur.github.io/lightGallery/
 * Copyright (c) 2016 Sachin N; Licensed Apache 2.0 */
!(function (a, b, c, d) {
    "use strict";
    function e(b, d) {
        if (
            ((this.el = b),
            (this.$el = a(b)),
            (this.s = a.extend({}, f, d)),
            this.s.dynamic &&
                "undefined" !== this.s.dynamicEl &&
                this.s.dynamicEl.constructor === Array &&
                !this.s.dynamicEl.length)
        )
            throw "When using dynamic mode, you must also define dynamicEl as an Array.";
        return (
            (this.modules = {}),
            (this.lGalleryOn = !1),
            (this.lgBusy = !1),
            (this.hideBartimeout = !1),
            (this.isTouch = "ontouchstart" in c.documentElement),
            this.s.slideEndAnimatoin && (this.s.hideControlOnEnd = !1),
            this.s.dynamic
                ? (this.$items = this.s.dynamicEl)
                : "this" === this.s.selector
                ? (this.$items = this.$el)
                : "" !== this.s.selector
                ? this.s.selectWithin
                    ? (this.$items = a(this.s.selectWithin).find(
                          this.s.selector
                      ))
                    : (this.$items = this.$el.find(a(this.s.selector)))
                : (this.$items = this.$el.children()),
            (this.$slide = ""),
            (this.$outer = ""),
            this.init(),
            this
        );
    }
    var f = {
        mode: "lg-slide",
        cssEasing: "ease",
        easing: "linear",
        speed: 600,
        height: "100%",
        width: "100%",
        addClass: "",
        startClass: "lg-start-zoom",
        backdropDuration: 150,
        hideBarsDelay: 6e3,
        useLeft: !1,
        closable: !0,
        loop: !0,
        escKey: !0,
        keyPress: !0,
        controls: !0,
        slideEndAnimatoin: !0,
        hideControlOnEnd: !1,
        mousewheel: !0,
        getCaptionFromTitleOrAlt: !0,
        appendSubHtmlTo: ".lg-sub-html",
        preload: 1,
        showAfterLoad: !0,
        selector: "",
        selectWithin: "",
        nextHtml: "",
        prevHtml: "",
        index: !1,
        iframeMaxWidth: "100%",
        download: !0,
        counter: !0,
        appendCounterTo: ".lg-toolbar",
        swipeThreshold: 50,
        enableSwipe: !0,
        enableDrag: !0,
        dynamic: !1,
        dynamicEl: [],
        galleryId: 1,
    };
    (e.prototype.init = function () {
        var c = this;
        c.s.preload > c.$items.length && (c.s.preload = c.$items.length);
        var d = b.location.hash;
        d.indexOf("lg=" + this.s.galleryId) > 0 &&
            ((c.index = parseInt(d.split("&slide=")[1], 10)),
            a("body").addClass("lg-from-hash"),
            a("body").hasClass("lg-on") ||
                setTimeout(function () {
                    c.build(c.index), a("body").addClass("lg-on");
                })),
            c.s.dynamic
                ? (c.$el.trigger("onBeforeOpen.lg"),
                  (c.index = c.s.index || 0),
                  a("body").hasClass("lg-on") ||
                      setTimeout(function () {
                          c.build(c.index), a("body").addClass("lg-on");
                      }))
                : c.$items.on("click.lgcustom", function (b) {
                      try {
                          b.preventDefault(), b.preventDefault();
                      } catch (d) {
                          b.returnValue = !1;
                      }
                      c.$el.trigger("onBeforeOpen.lg"),
                          (c.index = c.s.index || c.$items.index(this)),
                          a("body").hasClass("lg-on") ||
                              (c.build(c.index), a("body").addClass("lg-on"));
                  });
    }),
        (e.prototype.build = function (b) {
            var c = this;
            c.structure(),
                a.each(a.fn.lightGallery.modules, function (b) {
                    c.modules[b] = new a.fn.lightGallery.modules[b](c.el);
                }),
                c.slide(b, !1, !1),
                c.s.keyPress && c.keyPress(),
                c.$items.length > 1 &&
                    (c.arrow(),
                    setTimeout(function () {
                        c.enableDrag(), c.enableSwipe();
                    }, 50),
                    c.s.mousewheel && c.mousewheel()),
                c.counter(),
                c.closeGallery(),
                c.$el.trigger("onAfterOpen.lg"),
                c.$outer.on("mousemove.lg click.lg touchstart.lg", function () {
                    c.$outer.removeClass("lg-hide-items"),
                        clearTimeout(c.hideBartimeout),
                        (c.hideBartimeout = setTimeout(function () {
                            c.$outer.addClass("lg-hide-items");
                        }, c.s.hideBarsDelay));
                });
        }),
        (e.prototype.structure = function () {
            var c,
                d = "",
                e = "",
                f = 0,
                g = "",
                h = this;
            for (
                a("body").append('<div class="lg-backdrop"></div>'),
                    a(".lg-backdrop").css(
                        "transition-duration",
                        this.s.backdropDuration + "ms"
                    ),
                    f = 0;
                f < this.$items.length;
                f++
            )
                d += '<div class="lg-item"></div>';
            if (
                (this.s.controls &&
                    this.$items.length > 1 &&
                    (e =
                        '<div class="lg-actions"><div class="lg-prev lg-icon">' +
                        this.s.prevHtml +
                        '</div><div class="lg-next lg-icon">' +
                        this.s.nextHtml +
                        "</div></div>"),
                ".lg-sub-html" === this.s.appendSubHtmlTo &&
                    (g = '<div class="lg-sub-html"></div>'),
                (c =
                    '<div class="lg-outer ' +
                    this.s.addClass +
                    " " +
                    this.s.startClass +
                    '"><div class="lg" style="width:' +
                    this.s.width +
                    "; height:" +
                    this.s.height +
                    '"><div class="lg-inner">' +
                    d +
                    '</div><div class="lg-toolbar group"><span class="lg-close lg-icon"></span></div>' +
                    e +
                    g +
                    "</div></div>"),
                a("body").append(c),
                (this.$outer = a(".lg-outer")),
                (this.$slide = this.$outer.find(".lg-item")),
                this.s.useLeft
                    ? (this.$outer.addClass("lg-use-left"),
                      (this.s.mode = "lg-slide"))
                    : this.$outer.addClass("lg-use-css3"),
                h.setTop(),
                a(b).on("resize.lg orientationchange.lg", function () {
                    setTimeout(function () {
                        h.setTop();
                    }, 100);
                }),
                this.$slide.eq(this.index).addClass("lg-current"),
                this.doCss()
                    ? this.$outer.addClass("lg-css3")
                    : (this.$outer.addClass("lg-css"), (this.s.speed = 0)),
                this.$outer.addClass(this.s.mode),
                this.s.enableDrag &&
                    this.$items.length > 1 &&
                    this.$outer.addClass("lg-grab"),
                this.s.showAfterLoad &&
                    this.$outer.addClass("lg-show-after-load"),
                this.doCss())
            ) {
                var i = this.$outer.find(".lg-inner");
                i.css("transition-timing-function", this.s.cssEasing),
                    i.css("transition-duration", this.s.speed + "ms");
            }
            a(".lg-backdrop").addClass("in"),
                setTimeout(function () {
                    h.$outer.addClass("lg-visible");
                }, this.s.backdropDuration),
                this.s.download &&
                    this.$outer
                        .find(".lg-toolbar")
                        .append(
                            '<a id="lg-download" target="_blank" download class="lg-download lg-icon"></a>'
                        ),
                (this.prevScrollTop = a(b).scrollTop());
        }),
        (e.prototype.setTop = function () {
            if ("100%" !== this.s.height) {
                var c = a(b).height(),
                    d = (c - parseInt(this.s.height, 10)) / 2,
                    e = this.$outer.find(".lg");
                c >= parseInt(this.s.height, 10)
                    ? e.css("top", d + "px")
                    : e.css("top", "0px");
            }
        }),
        (e.prototype.doCss = function () {
            var a = function () {
                var a = [
                        "transition",
                        "MozTransition",
                        "WebkitTransition",
                        "OTransition",
                        "msTransition",
                        "KhtmlTransition",
                    ],
                    b = c.documentElement,
                    d = 0;
                for (d = 0; d < a.length; d++) if (a[d] in b.style) return !0;
            };
            return !!a();
        }),
        (e.prototype.isVideo = function (a, b) {
            var c;
            if (
                ((c = this.s.dynamic
                    ? this.s.dynamicEl[b].html
                    : this.$items.eq(b).attr("data-html")),
                !a && c)
            )
                return { html5: !0 };
            var d = a.match(
                    /\/\/(?:www\.)?youtu(?:\.be|be\.com)\/(?:watch\?v=|embed\/)?([a-z0-9\-\_\%]+)/i
                ),
                e = a.match(/\/\/(?:www\.)?vimeo.com\/([0-9a-z\-_]+)/i),
                f = a.match(/\/\/(?:www\.)?dai.ly\/([0-9a-z\-_]+)/i),
                g = a.match(
                    /\/\/(?:www\.)?(?:vk\.com|vkontakte\.ru)\/(?:video_ext\.php\?)(.*)/i
                );
            return d
                ? { youtube: d }
                : e
                ? { vimeo: e }
                : f
                ? { dailymotion: f }
                : g
                ? { vk: g }
                : void 0;
        }),
        (e.prototype.counter = function () {
            this.s.counter &&
                a(this.s.appendCounterTo).append(
                    '<div id="lg-counter"><span id="lg-counter-current">' +
                        (parseInt(this.index, 10) + 1) +
                        '</span> / <span id="lg-counter-all">' +
                        this.$items.length +
                        "</span></div>"
                );
        }),
        (e.prototype.addHtml = function (b) {
            var c,
                d = null;
            if (
                (this.s.dynamic
                    ? this.s.dynamicEl[b].subHtmlUrl
                        ? (c = this.s.dynamicEl[b].subHtmlUrl)
                        : (d = this.s.dynamicEl[b].subHtml)
                    : this.$items.eq(b).attr("data-sub-html-url")
                    ? (c = this.$items.eq(b).attr("data-sub-html-url"))
                    : ((d = this.$items.eq(b).attr("data-sub-html")),
                      this.s.getCaptionFromTitleOrAlt &&
                          !d &&
                          (d =
                              this.$items.eq(b).attr("title") ||
                              this.$items
                                  .eq(b)
                                  .find("img")
                                  .first()
                                  .attr("alt"))),
                !c)
            )
                if ("undefined" != typeof d && null !== d) {
                    var e = d.substring(0, 1);
                    ("." !== e && "#" !== e) || (d = a(d).html());
                } else d = "";
            ".lg-sub-html" === this.s.appendSubHtmlTo
                ? c
                    ? this.$outer.find(this.s.appendSubHtmlTo).load(c)
                    : this.$outer.find(this.s.appendSubHtmlTo).html(d)
                : c
                ? this.$slide.eq(b).load(c)
                : this.$slide.eq(b).append(d),
                "undefined" != typeof d &&
                    null !== d &&
                    ("" === d
                        ? this.$outer
                              .find(this.s.appendSubHtmlTo)
                              .addClass("lg-empty-html")
                        : this.$outer
                              .find(this.s.appendSubHtmlTo)
                              .removeClass("lg-empty-html")),
                this.$el.trigger("onAfterAppendSubHtml.lg", [b]);
        }),
        (e.prototype.preload = function (a) {
            var b = 1,
                c = 1;
            for (
                b = 1;
                b <= this.s.preload && !(b >= this.$items.length - a);
                b++
            )
                this.loadContent(a + b, !1, 0);
            for (c = 1; c <= this.s.preload && !(0 > a - c); c++)
                this.loadContent(a - c, !1, 0);
        }),
        (e.prototype.loadContent = function (c, d, e) {
            var f,
                g,
                h,
                i,
                j,
                k,
                l = this,
                m = !1,
                n = function (c) {
                    for (var d = [], e = [], f = 0; f < c.length; f++) {
                        var h = c[f].split(" ");
                        "" === h[0] && h.splice(0, 1),
                            e.push(h[0]),
                            d.push(h[1]);
                    }
                    for (var i = a(b).width(), j = 0; j < d.length; j++)
                        if (parseInt(d[j], 10) > i) {
                            g = e[j];
                            break;
                        }
                };
            if (l.s.dynamic) {
                if (
                    (l.s.dynamicEl[c].poster &&
                        ((m = !0), (h = l.s.dynamicEl[c].poster)),
                    (k = l.s.dynamicEl[c].html),
                    (g = l.s.dynamicEl[c].src),
                    l.s.dynamicEl[c].responsive)
                ) {
                    var o = l.s.dynamicEl[c].responsive.split(",");
                    n(o);
                }
                (i = l.s.dynamicEl[c].srcset), (j = l.s.dynamicEl[c].sizes);
            } else {
                if (
                    (l.$items.eq(c).attr("data-poster") &&
                        ((m = !0), (h = l.$items.eq(c).attr("data-poster"))),
                    (k = l.$items.eq(c).attr("data-html")),
                    (g =
                        l.$items.eq(c).attr("href") ||
                        l.$items.eq(c).attr("data-src")),
                    l.$items.eq(c).attr("data-responsive"))
                ) {
                    var p = l.$items.eq(c).attr("data-responsive").split(",");
                    n(p);
                }
                (i = l.$items.eq(c).attr("data-srcset")),
                    (j = l.$items.eq(c).attr("data-sizes"));
            }
            var q = !1;
            l.s.dynamic
                ? l.s.dynamicEl[c].iframe && (q = !0)
                : "true" === l.$items.eq(c).attr("data-iframe") && (q = !0);
            var r = l.isVideo(g, c);
            if (!l.$slide.eq(c).hasClass("lg-loaded")) {
                if (q)
                    l.$slide
                        .eq(c)
                        .prepend(
                            '<div class="lg-video-cont" style="max-width:' +
                                l.s.iframeMaxWidth +
                                '"><div class="lg-video"><iframe class="lg-object" frameborder="0" src="' +
                                g +
                                '"  allowfullscreen="true"></iframe></div></div>'
                        );
                else if (m) {
                    var s = "";
                    (s =
                        r && r.youtube
                            ? "lg-has-youtube"
                            : r && r.vimeo
                            ? "lg-has-vimeo"
                            : "lg-has-html5"),
                        l.$slide
                            .eq(c)
                            .prepend(
                                '<div class="lg-video-cont ' +
                                    s +
                                    ' "><div class="lg-video"><span class="lg-video-play"></span><img class="lg-object lg-has-poster" src="' +
                                    h +
                                    '" /></div></div>'
                            );
                } else
                    r
                        ? (l.$slide
                              .eq(c)
                              .prepend(
                                  '<div class="lg-video-cont "><div class="lg-video"></div></div>'
                              ),
                          l.$el.trigger("hasVideo.lg", [c, g, k]))
                        : l.$slide
                              .eq(c)
                              .prepend(
                                  '<div class="lg-img-wrap"><img class="lg-object lg-image" src="' +
                                      g +
                                      '" /></div>'
                              );
                if (
                    (l.$el.trigger("onAferAppendSlide.lg", [c]),
                    (f = l.$slide.eq(c).find(".lg-object")),
                    j && f.attr("sizes", j),
                    i)
                ) {
                    f.attr("srcset", i);
                    try {
                        picturefill({ elements: [f[0]] });
                    } catch (t) {
                        console.error(
                            "Make sure you have included Picturefill version 2"
                        );
                    }
                }
                ".lg-sub-html" !== this.s.appendSubHtmlTo && l.addHtml(c),
                    l.$slide.eq(c).addClass("lg-loaded");
            }
            l.$slide
                .eq(c)
                .find(".lg-object")
                .on("load.lg error.lg", function () {
                    var b = 0;
                    e && !a("body").hasClass("lg-from-hash") && (b = e),
                        setTimeout(function () {
                            l.$slide.eq(c).addClass("lg-complete"),
                                l.$el.trigger("onSlideItemLoad.lg", [
                                    c,
                                    e || 0,
                                ]);
                        }, b);
                }),
                r && r.html5 && !m && l.$slide.eq(c).addClass("lg-complete"),
                d === !0 &&
                    (l.$slide.eq(c).hasClass("lg-complete")
                        ? l.preload(c)
                        : l.$slide
                              .eq(c)
                              .find(".lg-object")
                              .on("load.lg error.lg", function () {
                                  l.preload(c);
                              }));
        }),
        (e.prototype.slide = function (b, c, d) {
            var e = this.$outer.find(".lg-current").index(),
                f = this;
            if (!f.lGalleryOn || e !== b) {
                var g = this.$slide.length,
                    h = f.lGalleryOn ? this.s.speed : 0,
                    i = !1,
                    j = !1;
                if (!f.lgBusy) {
                    if (this.s.download) {
                        var k;
                        (k = f.s.dynamic
                            ? f.s.dynamicEl[b].downloadUrl !== !1 &&
                              (f.s.dynamicEl[b].downloadUrl ||
                                  f.s.dynamicEl[b].src)
                            : "false" !==
                                  f.$items.eq(b).attr("data-download-url") &&
                              (f.$items.eq(b).attr("data-download-url") ||
                                  f.$items.eq(b).attr("href") ||
                                  f.$items.eq(b).attr("data-src"))),
                            k
                                ? (a("#lg-download").attr("href", k),
                                  f.$outer.removeClass("lg-hide-download"))
                                : f.$outer.addClass("lg-hide-download");
                    }
                    if (
                        (this.$el.trigger("onBeforeSlide.lg", [e, b, c, d]),
                        (f.lgBusy = !0),
                        clearTimeout(f.hideBartimeout),
                        ".lg-sub-html" === this.s.appendSubHtmlTo &&
                            setTimeout(function () {
                                f.addHtml(b);
                            }, h),
                        this.arrowDisable(b),
                        c)
                    ) {
                        var l = b - 1,
                            m = b + 1;
                        0 === b && e === g - 1
                            ? ((m = 0), (l = g - 1))
                            : b === g - 1 && 0 === e && ((m = 0), (l = g - 1)),
                            this.$slide.removeClass(
                                "lg-prev-slide lg-current lg-next-slide"
                            ),
                            f.$slide.eq(l).addClass("lg-prev-slide"),
                            f.$slide.eq(m).addClass("lg-next-slide"),
                            f.$slide.eq(b).addClass("lg-current");
                    } else
                        f.$outer.addClass("lg-no-trans"),
                            this.$slide.removeClass(
                                "lg-prev-slide lg-next-slide"
                            ),
                            e > b
                                ? ((j = !0),
                                  0 !== b ||
                                      e !== g - 1 ||
                                      d ||
                                      ((j = !1), (i = !0)))
                                : b > e &&
                                  ((i = !0),
                                  b !== g - 1 ||
                                      0 !== e ||
                                      d ||
                                      ((j = !0), (i = !1))),
                            j
                                ? (this.$slide.eq(b).addClass("lg-prev-slide"),
                                  this.$slide.eq(e).addClass("lg-next-slide"))
                                : i &&
                                  (this.$slide.eq(b).addClass("lg-next-slide"),
                                  this.$slide.eq(e).addClass("lg-prev-slide")),
                            setTimeout(function () {
                                f.$slide.removeClass("lg-current"),
                                    f.$slide.eq(b).addClass("lg-current"),
                                    f.$outer.removeClass("lg-no-trans");
                            }, 50);
                    f.lGalleryOn
                        ? (setTimeout(function () {
                              f.loadContent(b, !0, 0);
                          }, this.s.speed + 50),
                          setTimeout(function () {
                              (f.lgBusy = !1),
                                  f.$el.trigger("onAfterSlide.lg", [
                                      e,
                                      b,
                                      c,
                                      d,
                                  ]);
                          }, this.s.speed))
                        : (f.loadContent(b, !0, f.s.backdropDuration),
                          (f.lgBusy = !1),
                          f.$el.trigger("onAfterSlide.lg", [e, b, c, d])),
                        (f.lGalleryOn = !0),
                        this.s.counter && a("#lg-counter-current").text(b + 1);
                }
            }
        }),
        (e.prototype.goToNextSlide = function (a) {
            var b = this;
            b.lgBusy ||
                (b.index + 1 < b.$slide.length
                    ? (b.index++,
                      b.$el.trigger("onBeforeNextSlide.lg", [b.index]),
                      b.slide(b.index, a, !1))
                    : b.s.loop
                    ? ((b.index = 0),
                      b.$el.trigger("onBeforeNextSlide.lg", [b.index]),
                      b.slide(b.index, a, !1))
                    : b.s.slideEndAnimatoin &&
                      (b.$outer.addClass("lg-right-end"),
                      setTimeout(function () {
                          b.$outer.removeClass("lg-right-end");
                      }, 400)));
        }),
        (e.prototype.goToPrevSlide = function (a) {
            var b = this;
            b.lgBusy ||
                (b.index > 0
                    ? (b.index--,
                      b.$el.trigger("onBeforePrevSlide.lg", [b.index, a]),
                      b.slide(b.index, a, !1))
                    : b.s.loop
                    ? ((b.index = b.$items.length - 1),
                      b.$el.trigger("onBeforePrevSlide.lg", [b.index, a]),
                      b.slide(b.index, a, !1))
                    : b.s.slideEndAnimatoin &&
                      (b.$outer.addClass("lg-left-end"),
                      setTimeout(function () {
                          b.$outer.removeClass("lg-left-end");
                      }, 400)));
        }),
        (e.prototype.keyPress = function () {
            var c = this;
            this.$items.length > 1 &&
                a(b).on("keyup.lg", function (a) {
                    c.$items.length > 1 &&
                        (37 === a.keyCode &&
                            (a.preventDefault(), c.goToPrevSlide()),
                        39 === a.keyCode &&
                            (a.preventDefault(), c.goToNextSlide()));
                }),
                a(b).on("keydown.lg", function (a) {
                    c.s.escKey === !0 &&
                        27 === a.keyCode &&
                        (a.preventDefault(),
                        c.$outer.hasClass("lg-thumb-open")
                            ? c.$outer.removeClass("lg-thumb-open")
                            : c.destroy());
                });
        }),
        (e.prototype.arrow = function () {
            var a = this;
            this.$outer.find(".lg-prev").on("click.lg", function () {
                a.goToPrevSlide();
            }),
                this.$outer.find(".lg-next").on("click.lg", function () {
                    a.goToNextSlide();
                });
        }),
        (e.prototype.arrowDisable = function (a) {
            !this.s.loop &&
                this.s.hideControlOnEnd &&
                (a + 1 < this.$slide.length
                    ? this.$outer
                          .find(".lg-next")
                          .removeAttr("disabled")
                          .removeClass("disabled")
                    : this.$outer
                          .find(".lg-next")
                          .attr("disabled", "disabled")
                          .addClass("disabled"),
                a > 0
                    ? this.$outer
                          .find(".lg-prev")
                          .removeAttr("disabled")
                          .removeClass("disabled")
                    : this.$outer
                          .find(".lg-prev")
                          .attr("disabled", "disabled")
                          .addClass("disabled"));
        }),
        (e.prototype.setTranslate = function (a, b, c) {
            this.s.useLeft
                ? a.css("left", b)
                : a.css({
                      transform: "translate3d(" + b + "px, " + c + "px, 0px)",
                  });
        }),
        (e.prototype.touchMove = function (b, c) {
            var d = c - b;
            Math.abs(d) > 15 &&
                (this.$outer.addClass("lg-dragging"),
                this.setTranslate(this.$slide.eq(this.index), d, 0),
                this.setTranslate(
                    a(".lg-prev-slide"),
                    -this.$slide.eq(this.index).width() + d,
                    0
                ),
                this.setTranslate(
                    a(".lg-next-slide"),
                    this.$slide.eq(this.index).width() + d,
                    0
                ));
        }),
        (e.prototype.touchEnd = function (a) {
            var b = this;
            "lg-slide" !== b.s.mode && b.$outer.addClass("lg-slide"),
                this.$slide
                    .not(".lg-current, .lg-prev-slide, .lg-next-slide")
                    .css("opacity", "0"),
                setTimeout(function () {
                    b.$outer.removeClass("lg-dragging"),
                        0 > a && Math.abs(a) > b.s.swipeThreshold
                            ? b.goToNextSlide(!0)
                            : a > 0 && Math.abs(a) > b.s.swipeThreshold
                            ? b.goToPrevSlide(!0)
                            : Math.abs(a) < 5 &&
                              b.$el.trigger("onSlideClick.lg"),
                        b.$slide.removeAttr("style");
                }),
                setTimeout(function () {
                    b.$outer.hasClass("lg-dragging") ||
                        "lg-slide" === b.s.mode ||
                        b.$outer.removeClass("lg-slide");
                }, b.s.speed + 100);
        }),
        (e.prototype.enableSwipe = function () {
            var a = this,
                b = 0,
                c = 0,
                d = !1;
            a.s.enableSwipe &&
                a.isTouch &&
                a.doCss() &&
                (a.$slide.on("touchstart.lg", function (c) {
                    a.$outer.hasClass("lg-zoomed") ||
                        a.lgBusy ||
                        (c.preventDefault(),
                        a.manageSwipeClass(),
                        (b = c.originalEvent.targetTouches[0].pageX));
                }),
                a.$slide.on("touchmove.lg", function (e) {
                    a.$outer.hasClass("lg-zoomed") ||
                        (e.preventDefault(),
                        (c = e.originalEvent.targetTouches[0].pageX),
                        a.touchMove(b, c),
                        (d = !0));
                }),
                a.$slide.on("touchend.lg", function () {
                    a.$outer.hasClass("lg-zoomed") ||
                        (d
                            ? ((d = !1), a.touchEnd(c - b))
                            : a.$el.trigger("onSlideClick.lg"));
                }));
        }),
        (e.prototype.enableDrag = function () {
            var c = this,
                d = 0,
                e = 0,
                f = !1,
                g = !1;
            c.s.enableDrag &&
                !c.isTouch &&
                c.doCss() &&
                (c.$slide.on("mousedown.lg", function (b) {
                    c.$outer.hasClass("lg-zoomed") ||
                        ((a(b.target).hasClass("lg-object") ||
                            a(b.target).hasClass("lg-video-play")) &&
                            (b.preventDefault(),
                            c.lgBusy ||
                                (c.manageSwipeClass(),
                                (d = b.pageX),
                                (f = !0),
                                (c.$outer.scrollLeft += 1),
                                (c.$outer.scrollLeft -= 1),
                                c.$outer
                                    .removeClass("lg-grab")
                                    .addClass("lg-grabbing"),
                                c.$el.trigger("onDragstart.lg"))));
                }),
                a(b).on("mousemove.lg", function (a) {
                    f &&
                        ((g = !0),
                        (e = a.pageX),
                        c.touchMove(d, e),
                        c.$el.trigger("onDragmove.lg"));
                }),
                a(b).on("mouseup.lg", function (b) {
                    g
                        ? ((g = !1),
                          c.touchEnd(e - d),
                          c.$el.trigger("onDragend.lg"))
                        : (a(b.target).hasClass("lg-object") ||
                              a(b.target).hasClass("lg-video-play")) &&
                          c.$el.trigger("onSlideClick.lg"),
                        f &&
                            ((f = !1),
                            c.$outer
                                .removeClass("lg-grabbing")
                                .addClass("lg-grab"));
                }));
        }),
        (e.prototype.manageSwipeClass = function () {
            var a = this.index + 1,
                b = this.index - 1,
                c = this.$slide.length;
            this.s.loop &&
                (0 === this.index
                    ? (b = c - 1)
                    : this.index === c - 1 && (a = 0)),
                this.$slide.removeClass("lg-next-slide lg-prev-slide"),
                b > -1 && this.$slide.eq(b).addClass("lg-prev-slide"),
                this.$slide.eq(a).addClass("lg-next-slide");
        }),
        (e.prototype.mousewheel = function () {
            var a = this;
            a.$outer.on("mousewheel.lg", function (b) {
                b.deltaY &&
                    (b.deltaY > 0 ? a.goToPrevSlide() : a.goToNextSlide(),
                    b.preventDefault());
            });
        }),
        (e.prototype.closeGallery = function () {
            var b = this,
                c = !1;
            this.$outer.find(".lg-close").on("click.lg", function () {
                b.destroy();
            }),
                b.s.closable &&
                    (b.$outer.on("mousedown.lg", function (b) {
                        c = !!(
                            a(b.target).is(".lg-outer") ||
                            a(b.target).is(".lg-item ") ||
                            a(b.target).is(".lg-img-wrap")
                        );
                    }),
                    b.$outer.on("mouseup.lg", function (d) {
                        (a(d.target).is(".lg-outer") ||
                            a(d.target).is(".lg-item ") ||
                            (a(d.target).is(".lg-img-wrap") && c)) &&
                            (b.$outer.hasClass("lg-dragging") || b.destroy());
                    }));
        }),
        (e.prototype.destroy = function (c) {
            var d = this;
            c || d.$el.trigger("onBeforeClose.lg"),
                a(b).scrollTop(d.prevScrollTop),
                c &&
                    (d.s.dynamic || this.$items.off("click.lg click.lgcustom"),
                    a.removeData(d.el, "lightGallery")),
                this.$el.off(".lg.tm"),
                a.each(a.fn.lightGallery.modules, function (a) {
                    d.modules[a] && d.modules[a].destroy();
                }),
                (this.lGalleryOn = !1),
                clearTimeout(d.hideBartimeout),
                (this.hideBartimeout = !1),
                a(b).off(".lg"),
                a("body").removeClass("lg-on lg-from-hash"),
                d.$outer && d.$outer.removeClass("lg-visible"),
                a(".lg-backdrop").removeClass("in"),
                setTimeout(function () {
                    d.$outer && d.$outer.remove(),
                        a(".lg-backdrop").remove(),
                        c || d.$el.trigger("onCloseAfter.lg");
                }, d.s.backdropDuration + 50);
        }),
        (a.fn.lightGallery = function (b) {
            return this.each(function () {
                if (a.data(this, "lightGallery"))
                    try {
                        a(this).data("lightGallery").init();
                    } catch (c) {
                        console.error(
                            "lightGallery has not initiated properly"
                        );
                    }
                else a.data(this, "lightGallery", new e(this, b));
            });
        }),
        (a.fn.lightGallery.modules = {});
})(jQuery, window, document),
    (function (a, b, c, d) {
        "use strict";
        var e = {
                autoplay: !1,
                pause: 5e3,
                progressBar: !0,
                fourceAutoplay: !1,
                autoplayControls: !0,
                appendAutoplayControlsTo: ".lg-toolbar",
            },
            f = function (b) {
                return (
                    (this.core = a(b).data("lightGallery")),
                    (this.$el = a(b)),
                    this.core.$items.length < 2
                        ? !1
                        : ((this.core.s = a.extend({}, e, this.core.s)),
                          (this.interval = !1),
                          (this.fromAuto = !0),
                          (this.canceledOnTouch = !1),
                          (this.fourceAutoplayTemp =
                              this.core.s.fourceAutoplay),
                          this.core.doCss() || (this.core.s.progressBar = !1),
                          this.init(),
                          this)
                );
            };
        (f.prototype.init = function () {
            var a = this;
            a.core.s.autoplayControls && a.controls(),
                a.core.s.progressBar &&
                    a.core.$outer
                        .find(".lg")
                        .append(
                            '<div class="lg-progress-bar"><div class="lg-progress"></div></div>'
                        ),
                a.progress(),
                a.core.s.autoplay && a.startlAuto(),
                a.$el.on("onDragstart.lg.tm touchstart.lg.tm", function () {
                    a.interval && (a.cancelAuto(), (a.canceledOnTouch = !0));
                }),
                a.$el.on(
                    "onDragend.lg.tm touchend.lg.tm onSlideClick.lg.tm",
                    function () {
                        !a.interval &&
                            a.canceledOnTouch &&
                            (a.startlAuto(), (a.canceledOnTouch = !1));
                    }
                );
        }),
            (f.prototype.progress = function () {
                var a,
                    b,
                    c = this;
                c.$el.on("onBeforeSlide.lg.tm", function () {
                    c.core.s.progressBar &&
                        c.fromAuto &&
                        ((a = c.core.$outer.find(".lg-progress-bar")),
                        (b = c.core.$outer.find(".lg-progress")),
                        c.interval &&
                            (b.removeAttr("style"),
                            a.removeClass("lg-start"),
                            setTimeout(function () {
                                b.css(
                                    "transition",
                                    "width " +
                                        (c.core.s.speed + c.core.s.pause) +
                                        "ms ease 0s"
                                ),
                                    a.addClass("lg-start");
                            }, 20))),
                        c.fromAuto || c.core.s.fourceAutoplay || c.cancelAuto(),
                        (c.fromAuto = !1);
                });
            }),
            (f.prototype.controls = function () {
                var b = this,
                    c = '<span class="lg-autoplay-button lg-icon"></span>';
                a(this.core.s.appendAutoplayControlsTo).append(c),
                    b.core.$outer
                        .find(".lg-autoplay-button")
                        .on("click.lg", function () {
                            a(b.core.$outer).hasClass("lg-show-autoplay")
                                ? (b.cancelAuto(),
                                  (b.core.s.fourceAutoplay = !1))
                                : b.interval ||
                                  (b.startlAuto(),
                                  (b.core.s.fourceAutoplay =
                                      b.fourceAutoplayTemp));
                        });
            }),
            (f.prototype.startlAuto = function () {
                var a = this;
                a.core.$outer
                    .find(".lg-progress")
                    .css(
                        "transition",
                        "width " +
                            (a.core.s.speed + a.core.s.pause) +
                            "ms ease 0s"
                    ),
                    a.core.$outer.addClass("lg-show-autoplay"),
                    a.core.$outer.find(".lg-progress-bar").addClass("lg-start"),
                    (a.interval = setInterval(function () {
                        a.core.index + 1 < a.core.$items.length
                            ? (a.core.index = a.core.index)
                            : (a.core.index = -1),
                            a.core.index++,
                            (a.fromAuto = !0),
                            a.core.slide(a.core.index, !1, !1);
                    }, a.core.s.speed + a.core.s.pause));
            }),
            (f.prototype.cancelAuto = function () {
                clearInterval(this.interval),
                    (this.interval = !1),
                    this.core.$outer.find(".lg-progress").removeAttr("style"),
                    this.core.$outer.removeClass("lg-show-autoplay"),
                    this.core.$outer
                        .find(".lg-progress-bar")
                        .removeClass("lg-start");
            }),
            (f.prototype.destroy = function () {
                this.cancelAuto(),
                    this.core.$outer.find(".lg-progress-bar").remove();
            }),
            (a.fn.lightGallery.modules.autoplay = f);
    })(jQuery, window, document),
    (function (a, b, c, d) {
        "use strict";
        var e = { fullScreen: !0 },
            f = function (b) {
                return (
                    (this.core = a(b).data("lightGallery")),
                    (this.$el = a(b)),
                    (this.core.s = a.extend({}, e, this.core.s)),
                    this.init(),
                    this
                );
            };
        (f.prototype.init = function () {
            var a = "";
            if (this.core.s.fullScreen) {
                if (
                    !(
                        c.fullscreenEnabled ||
                        c.webkitFullscreenEnabled ||
                        c.mozFullScreenEnabled ||
                        c.msFullscreenEnabled
                    )
                )
                    return;
                (a = '<span class="lg-fullscreen lg-icon"></span>'),
                    this.core.$outer.find(".lg-toolbar").append(a),
                    this.fullScreen();
            }
        }),
            (f.prototype.requestFullscreen = function () {
                var a = c.documentElement;
                a.requestFullscreen
                    ? a.requestFullscreen()
                    : a.msRequestFullscreen
                    ? a.msRequestFullscreen()
                    : a.mozRequestFullScreen
                    ? a.mozRequestFullScreen()
                    : a.webkitRequestFullscreen && a.webkitRequestFullscreen();
            }),
            (f.prototype.exitFullscreen = function () {
                c.exitFullscreen
                    ? c.exitFullscreen()
                    : c.msExitFullscreen
                    ? c.msExitFullscreen()
                    : c.mozCancelFullScreen
                    ? c.mozCancelFullScreen()
                    : c.webkitExitFullscreen && c.webkitExitFullscreen();
            }),
            (f.prototype.fullScreen = function () {
                var b = this;
                a(c).on(
                    "fullscreenchange.lg webkitfullscreenchange.lg mozfullscreenchange.lg MSFullscreenChange.lg",
                    function () {
                        b.core.$outer.toggleClass("lg-fullscreen-on");
                    }
                ),
                    this.core.$outer
                        .find(".lg-fullscreen")
                        .on("click.lg", function () {
                            c.fullscreenElement ||
                            c.mozFullScreenElement ||
                            c.webkitFullscreenElement ||
                            c.msFullscreenElement
                                ? b.exitFullscreen()
                                : b.requestFullscreen();
                        });
            }),
            (f.prototype.destroy = function () {
                this.exitFullscreen(),
                    a(c).off(
                        "fullscreenchange.lg webkitfullscreenchange.lg mozfullscreenchange.lg MSFullscreenChange.lg"
                    );
            }),
            (a.fn.lightGallery.modules.fullscreen = f);
    })(jQuery, window, document),
    (function (a, b, c, d) {
        "use strict";
        var e = { pager: !1 },
            f = function (b) {
                return (
                    (this.core = a(b).data("lightGallery")),
                    (this.$el = a(b)),
                    (this.core.s = a.extend({}, e, this.core.s)),
                    this.core.s.pager &&
                        this.core.$items.length > 1 &&
                        this.init(),
                    this
                );
            };
        (f.prototype.init = function () {
            var b,
                c,
                d,
                e = this,
                f = "";
            if (
                (e.core.$outer
                    .find(".lg")
                    .append('<div class="lg-pager-outer"></div>'),
                e.core.s.dynamic)
            )
                for (var g = 0; g < e.core.s.dynamicEl.length; g++)
                    f +=
                        '<span class="lg-pager-cont"> <span class="lg-pager"></span><div class="lg-pager-thumb-cont"><span class="lg-caret"></span> <img src="' +
                        e.core.s.dynamicEl[g].thumb +
                        '" /></div></span>';
            else
                e.core.$items.each(function () {
                    f += e.core.s.exThumbImage
                        ? '<span class="lg-pager-cont"> <span class="lg-pager"></span><div class="lg-pager-thumb-cont"><span class="lg-caret"></span> <img src="' +
                          a(this).attr(e.core.s.exThumbImage) +
                          '" /></div></span>'
                        : '<span class="lg-pager-cont"> <span class="lg-pager"></span><div class="lg-pager-thumb-cont"><span class="lg-caret"></span> <img src="' +
                          a(this).find("img").attr("src") +
                          '" /></div></span>';
                });
            (c = e.core.$outer.find(".lg-pager-outer")),
                c.html(f),
                (b = e.core.$outer.find(".lg-pager-cont")),
                b.on("click.lg touchend.lg", function () {
                    var b = a(this);
                    (e.core.index = b.index()),
                        e.core.slide(e.core.index, !1, !1);
                }),
                c.on("mouseover.lg", function () {
                    clearTimeout(d), c.addClass("lg-pager-hover");
                }),
                c.on("mouseout.lg", function () {
                    d = setTimeout(function () {
                        c.removeClass("lg-pager-hover");
                    });
                }),
                e.core.$el.on("onBeforeSlide.lg.tm", function (a, c, d) {
                    b.removeClass("lg-pager-active"),
                        b.eq(d).addClass("lg-pager-active");
                });
        }),
            (f.prototype.destroy = function () {}),
            (a.fn.lightGallery.modules.pager = f);
    })(jQuery, window, document),
    (function (a, b, c, d) {
        "use strict";
        var e = {
                thumbnail: !0,
                animateThumb: !0,
                currentPagerPosition: "middle",
                thumbWidth: 100,
                thumbContHeight: 100,
                thumbMargin: 5,
                exThumbImage: !1,
                showThumbByDefault: !0,
                toogleThumb: !0,
                pullCaptionUp: !0,
                enableThumbDrag: !0,
                enableThumbSwipe: !0,
                swipeThreshold: 50,
                loadYoutubeThumbnail: !0,
                youtubeThumbSize: 1,
                loadVimeoThumbnail: !0,
                vimeoThumbSize: "thumbnail_small",
                loadDailymotionThumbnail: !0,
            },
            f = function (b) {
                return (
                    (this.core = a(b).data("lightGallery")),
                    (this.core.s = a.extend({}, e, this.core.s)),
                    (this.$el = a(b)),
                    (this.$thumbOuter = null),
                    (this.thumbOuterWidth = 0),
                    (this.thumbTotalWidth =
                        this.core.$items.length *
                        (this.core.s.thumbWidth + this.core.s.thumbMargin)),
                    (this.thumbIndex = this.core.index),
                    (this.left = 0),
                    this.init(),
                    this
                );
            };
        (f.prototype.init = function () {
            var a = this;
            this.core.s.thumbnail &&
                this.core.$items.length > 1 &&
                (this.core.s.showThumbByDefault &&
                    setTimeout(function () {
                        a.core.$outer.addClass("lg-thumb-open");
                    }, 700),
                this.core.s.pullCaptionUp &&
                    this.core.$outer.addClass("lg-pull-caption-up"),
                this.build(),
                this.core.s.animateThumb
                    ? (this.core.s.enableThumbDrag &&
                          !this.core.isTouch &&
                          this.core.doCss() &&
                          this.enableThumbDrag(),
                      this.core.s.enableThumbSwipe &&
                          this.core.isTouch &&
                          this.core.doCss() &&
                          this.enableThumbSwipe(),
                      (this.thumbClickable = !1))
                    : (this.thumbClickable = !0),
                this.toogle(),
                this.thumbkeyPress());
        }),
            (f.prototype.build = function () {
                function c(a, b, c) {
                    var d,
                        h = e.core.isVideo(a, c) || {},
                        i = "";
                    h.youtube || h.vimeo || h.dailymotion
                        ? h.youtube
                            ? (d = e.core.s.loadYoutubeThumbnail
                                  ? "//img.youtube.com/vi/" +
                                    h.youtube[1] +
                                    "/" +
                                    e.core.s.youtubeThumbSize +
                                    ".jpg"
                                  : b)
                            : h.vimeo
                            ? e.core.s.loadVimeoThumbnail
                                ? ((d =
                                      "//i.vimeocdn.com/video/error_" +
                                      g +
                                      ".jpg"),
                                  (i = h.vimeo[1]))
                                : (d = b)
                            : h.dailymotion &&
                              (d = e.core.s.loadDailymotionThumbnail
                                  ? "//www.dailymotion.com/thumbnail/video/" +
                                    h.dailymotion[1]
                                  : b)
                        : (d = b),
                        (f +=
                            '<div data-vimeo-id="' +
                            i +
                            '" class="lg-thumb-item" style="width:' +
                            e.core.s.thumbWidth +
                            "px; margin-right: " +
                            e.core.s.thumbMargin +
                            'px"><img src="' +
                            d +
                            '" /></div>'),
                        (i = "");
                }
                var d,
                    e = this,
                    f = "",
                    g = "",
                    h =
                        '<div class="lg-thumb-outer"><div class="lg-thumb group"></div></div>';
                switch (this.core.s.vimeoThumbSize) {
                    case "thumbnail_large":
                        g = "640";
                        break;
                    case "thumbnail_medium":
                        g = "200x150";
                        break;
                    case "thumbnail_small":
                        g = "100x75";
                }
                if (
                    (e.core.$outer.addClass("lg-has-thumb"),
                    e.core.$outer.find(".lg").append(h),
                    (e.$thumbOuter = e.core.$outer.find(".lg-thumb-outer")),
                    (e.thumbOuterWidth = e.$thumbOuter.width()),
                    e.core.s.animateThumb &&
                        e.core.$outer
                            .find(".lg-thumb")
                            .css({
                                width: e.thumbTotalWidth + "px",
                                position: "relative",
                            }),
                    this.core.s.animateThumb &&
                        e.$thumbOuter.css(
                            "height",
                            e.core.s.thumbContHeight + "px"
                        ),
                    e.core.s.dynamic)
                )
                    for (var i = 0; i < e.core.s.dynamicEl.length; i++)
                        c(
                            e.core.s.dynamicEl[i].src,
                            e.core.s.dynamicEl[i].thumb,
                            i
                        );
                else
                    e.core.$items.each(function (b) {
                        e.core.s.exThumbImage
                            ? c(
                                  a(this).attr("href") ||
                                      a(this).attr("data-src"),
                                  a(this).attr(e.core.s.exThumbImage),
                                  b
                              )
                            : c(
                                  a(this).attr("href") ||
                                      a(this).attr("data-src"),
                                  a(this).find("img").attr("src"),
                                  b
                              );
                    });
                e.core.$outer.find(".lg-thumb").html(f),
                    (d = e.core.$outer.find(".lg-thumb-item")),
                    d.each(function () {
                        var b = a(this),
                            c = b.attr("data-vimeo-id");
                        c &&
                            a.getJSON(
                                "//www.vimeo.com/api/v2/video/" +
                                    c +
                                    ".json?callback=?",
                                { format: "json" },
                                function (a) {
                                    b.find("img").attr(
                                        "src",
                                        a[0][e.core.s.vimeoThumbSize]
                                    );
                                }
                            );
                    }),
                    d.eq(e.core.index).addClass("active"),
                    e.core.$el.on("onBeforeSlide.lg.tm", function () {
                        d.removeClass("active"),
                            d.eq(e.core.index).addClass("active");
                    }),
                    d.on("click.lg touchend.lg", function () {
                        var b = a(this);
                        setTimeout(function () {
                            ((e.thumbClickable && !e.core.lgBusy) ||
                                !e.core.doCss()) &&
                                ((e.core.index = b.index()),
                                e.core.slide(e.core.index, !1, !0));
                        }, 50);
                    }),
                    e.core.$el.on("onBeforeSlide.lg.tm", function () {
                        e.animateThumb(e.core.index);
                    }),
                    a(b).on(
                        "resize.lg.thumb orientationchange.lg.thumb",
                        function () {
                            setTimeout(function () {
                                e.animateThumb(e.core.index),
                                    (e.thumbOuterWidth = e.$thumbOuter.width());
                            }, 200);
                        }
                    );
            }),
            (f.prototype.setTranslate = function (a) {
                this.core.$outer
                    .find(".lg-thumb")
                    .css({ transform: "translate3d(-" + a + "px, 0px, 0px)" });
            }),
            (f.prototype.animateThumb = function (a) {
                var b = this.core.$outer.find(".lg-thumb");
                if (this.core.s.animateThumb) {
                    var c;
                    switch (this.core.s.currentPagerPosition) {
                        case "left":
                            c = 0;
                            break;
                        case "middle":
                            c =
                                this.thumbOuterWidth / 2 -
                                this.core.s.thumbWidth / 2;
                            break;
                        case "right":
                            c = this.thumbOuterWidth - this.core.s.thumbWidth;
                    }
                    (this.left =
                        (this.core.s.thumbWidth + this.core.s.thumbMargin) * a -
                        1 -
                        c),
                        this.left >
                            this.thumbTotalWidth - this.thumbOuterWidth &&
                            (this.left =
                                this.thumbTotalWidth - this.thumbOuterWidth),
                        this.left < 0 && (this.left = 0),
                        this.core.lGalleryOn
                            ? (b.hasClass("on") ||
                                  this.core.$outer
                                      .find(".lg-thumb")
                                      .css(
                                          "transition-duration",
                                          this.core.s.speed + "ms"
                                      ),
                              this.core.doCss() ||
                                  b.animate(
                                      { left: -this.left + "px" },
                                      this.core.s.speed
                                  ))
                            : this.core.doCss() ||
                              b.css("left", -this.left + "px"),
                        this.setTranslate(this.left);
                }
            }),
            (f.prototype.enableThumbDrag = function () {
                var c = this,
                    d = 0,
                    e = 0,
                    f = !1,
                    g = !1,
                    h = 0;
                c.$thumbOuter.addClass("lg-grab"),
                    c.core.$outer
                        .find(".lg-thumb")
                        .on("mousedown.lg.thumb", function (a) {
                            c.thumbTotalWidth > c.thumbOuterWidth &&
                                (a.preventDefault(),
                                (d = a.pageX),
                                (f = !0),
                                (c.core.$outer.scrollLeft += 1),
                                (c.core.$outer.scrollLeft -= 1),
                                (c.thumbClickable = !1),
                                c.$thumbOuter
                                    .removeClass("lg-grab")
                                    .addClass("lg-grabbing"));
                        }),
                    a(b).on("mousemove.lg.thumb", function (a) {
                        f &&
                            ((h = c.left),
                            (g = !0),
                            (e = a.pageX),
                            c.$thumbOuter.addClass("lg-dragging"),
                            (h -= e - d),
                            h > c.thumbTotalWidth - c.thumbOuterWidth &&
                                (h = c.thumbTotalWidth - c.thumbOuterWidth),
                            0 > h && (h = 0),
                            c.setTranslate(h));
                    }),
                    a(b).on("mouseup.lg.thumb", function () {
                        g
                            ? ((g = !1),
                              c.$thumbOuter.removeClass("lg-dragging"),
                              (c.left = h),
                              Math.abs(e - d) < c.core.s.swipeThreshold &&
                                  (c.thumbClickable = !0))
                            : (c.thumbClickable = !0),
                            f &&
                                ((f = !1),
                                c.$thumbOuter
                                    .removeClass("lg-grabbing")
                                    .addClass("lg-grab"));
                    });
            }),
            (f.prototype.enableThumbSwipe = function () {
                var a = this,
                    b = 0,
                    c = 0,
                    d = !1,
                    e = 0;
                a.core.$outer
                    .find(".lg-thumb")
                    .on("touchstart.lg", function (c) {
                        a.thumbTotalWidth > a.thumbOuterWidth &&
                            (c.preventDefault(),
                            (b = c.originalEvent.targetTouches[0].pageX),
                            (a.thumbClickable = !1));
                    }),
                    a.core.$outer
                        .find(".lg-thumb")
                        .on("touchmove.lg", function (f) {
                            a.thumbTotalWidth > a.thumbOuterWidth &&
                                (f.preventDefault(),
                                (c = f.originalEvent.targetTouches[0].pageX),
                                (d = !0),
                                a.$thumbOuter.addClass("lg-dragging"),
                                (e = a.left),
                                (e -= c - b),
                                e > a.thumbTotalWidth - a.thumbOuterWidth &&
                                    (e = a.thumbTotalWidth - a.thumbOuterWidth),
                                0 > e && (e = 0),
                                a.setTranslate(e));
                        }),
                    a.core.$outer
                        .find(".lg-thumb")
                        .on("touchend.lg", function () {
                            a.thumbTotalWidth > a.thumbOuterWidth && d
                                ? ((d = !1),
                                  a.$thumbOuter.removeClass("lg-dragging"),
                                  Math.abs(c - b) < a.core.s.swipeThreshold &&
                                      (a.thumbClickable = !0),
                                  (a.left = e))
                                : (a.thumbClickable = !0);
                        });
            }),
            (f.prototype.toogle = function () {
                var a = this;
                a.core.s.toogleThumb &&
                    (a.core.$outer.addClass("lg-can-toggle"),
                    a.$thumbOuter.append(
                        '<span class="lg-toogle-thumb lg-icon"></span>'
                    ),
                    a.core.$outer
                        .find(".lg-toogle-thumb")
                        .on("click.lg", function () {
                            a.core.$outer.toggleClass("lg-thumb-open");
                        }));
            }),
            (f.prototype.thumbkeyPress = function () {
                var c = this;
                a(b).on("keydown.lg.thumb", function (a) {
                    38 === a.keyCode
                        ? (a.preventDefault(),
                          c.core.$outer.addClass("lg-thumb-open"))
                        : 40 === a.keyCode &&
                          (a.preventDefault(),
                          c.core.$outer.removeClass("lg-thumb-open"));
                });
            }),
            (f.prototype.destroy = function () {
                this.core.s.thumbnail &&
                    this.core.$items.length > 1 &&
                    (a(b).off(
                        "resize.lg.thumb orientationchange.lg.thumb keydown.lg.thumb"
                    ),
                    this.$thumbOuter.remove(),
                    this.core.$outer.removeClass("lg-has-thumb"));
            }),
            (a.fn.lightGallery.modules.Thumbnail = f);
    })(jQuery, window, document),
    (function (a, b, c, d) {
        "use strict";
        var e = {
                videoMaxWidth: "855px",
                youtubePlayerParams: !1,
                vimeoPlayerParams: !1,
                dailymotionPlayerParams: !1,
                vkPlayerParams: !1,
                videojs: !1,
                videojsOptions: {},
            },
            f = function (b) {
                return (
                    (this.core = a(b).data("lightGallery")),
                    (this.$el = a(b)),
                    (this.core.s = a.extend({}, e, this.core.s)),
                    (this.videoLoaded = !1),
                    this.init(),
                    this
                );
            };
        (f.prototype.init = function () {
            var b = this;
            b.core.$el.on("hasVideo.lg.tm", function (a, c, d, e) {
                if (
                    (b.core.$slide
                        .eq(c)
                        .find(".lg-video")
                        .append(b.loadVideo(d, "lg-object", !0, c, e)),
                    e)
                )
                    if (b.core.s.videojs)
                        try {
                            videojs(
                                b.core.$slide.eq(c).find(".lg-html5").get(0),
                                b.core.s.videojsOptions,
                                function () {
                                    b.videoLoaded || this.play();
                                }
                            );
                        } catch (f) {
                            console.error(
                                "Make sure you have included videojs"
                            );
                        }
                    else b.core.$slide.eq(c).find(".lg-html5").get(0).play();
            }),
                b.core.$el.on("onAferAppendSlide.lg.tm", function (a, c) {
                    b.core.$slide
                        .eq(c)
                        .find(".lg-video-cont")
                        .css("max-width", b.core.s.videoMaxWidth),
                        (b.videoLoaded = !0);
                });
            var c = function (a) {
                if (
                    a.find(".lg-object").hasClass("lg-has-poster") &&
                    a.find(".lg-object").is(":visible")
                )
                    if (a.hasClass("lg-has-video")) {
                        var c = a.find(".lg-youtube").get(0),
                            d = a.find(".lg-vimeo").get(0),
                            e = a.find(".lg-dailymotion").get(0),
                            f = a.find(".lg-html5").get(0);
                        if (c)
                            c.contentWindow.postMessage(
                                '{"event":"command","func":"playVideo","args":""}',
                                "*"
                            );
                        else if (d)
                            try {
                                $f(d).api("play");
                            } catch (g) {
                                console.error(
                                    "Make sure you have included froogaloop2 js"
                                );
                            }
                        else if (e) e.contentWindow.postMessage("play", "*");
                        else if (f)
                            if (b.core.s.videojs)
                                try {
                                    videojs(f).play();
                                } catch (g) {
                                    console.error(
                                        "Make sure you have included videojs"
                                    );
                                }
                            else f.play();
                        a.addClass("lg-video-playing");
                    } else {
                        a.addClass("lg-video-playing lg-has-video");
                        var h,
                            i,
                            j = function (c, d) {
                                if (
                                    (a
                                        .find(".lg-video")
                                        .append(
                                            b.loadVideo(
                                                c,
                                                "",
                                                !1,
                                                b.core.index,
                                                d
                                            )
                                        ),
                                    d)
                                )
                                    if (b.core.s.videojs)
                                        try {
                                            videojs(
                                                b.core.$slide
                                                    .eq(b.core.index)
                                                    .find(".lg-html5")
                                                    .get(0),
                                                b.core.s.videojsOptions,
                                                function () {
                                                    this.play();
                                                }
                                            );
                                        } catch (e) {
                                            console.error(
                                                "Make sure you have included videojs"
                                            );
                                        }
                                    else
                                        b.core.$slide
                                            .eq(b.core.index)
                                            .find(".lg-html5")
                                            .get(0)
                                            .play();
                            };
                        b.core.s.dynamic
                            ? ((h = b.core.s.dynamicEl[b.core.index].src),
                              (i = b.core.s.dynamicEl[b.core.index].html),
                              j(h, i))
                            : ((h =
                                  b.core.$items.eq(b.core.index).attr("href") ||
                                  b.core.$items
                                      .eq(b.core.index)
                                      .attr("data-src")),
                              (i = b.core.$items
                                  .eq(b.core.index)
                                  .attr("data-html")),
                              j(h, i));
                        var k = a.find(".lg-object");
                        a.find(".lg-video").append(k),
                            a.find(".lg-video-object").hasClass("lg-html5") ||
                                (a.removeClass("lg-complete"),
                                a
                                    .find(".lg-video-object")
                                    .on("load.lg error.lg", function () {
                                        a.addClass("lg-complete");
                                    }));
                    }
            };
            b.core.doCss() &&
            b.core.$items.length > 1 &&
            ((b.core.s.enableSwipe && b.core.isTouch) ||
                (b.core.s.enableDrag && !b.core.isTouch))
                ? b.core.$el.on("onSlideClick.lg.tm", function () {
                      var a = b.core.$slide.eq(b.core.index);
                      c(a);
                  })
                : b.core.$slide.on("click.lg", function () {
                      c(a(this));
                  }),
                b.core.$el.on("onBeforeSlide.lg.tm", function (c, d, e) {
                    var f = b.core.$slide.eq(d),
                        g = f.find(".lg-youtube").get(0),
                        h = f.find(".lg-vimeo").get(0),
                        i = f.find(".lg-dailymotion").get(0),
                        j = f.find(".lg-vk").get(0),
                        k = f.find(".lg-html5").get(0);
                    if (g)
                        g.contentWindow.postMessage(
                            '{"event":"command","func":"pauseVideo","args":""}',
                            "*"
                        );
                    else if (h)
                        try {
                            $f(h).api("pause");
                        } catch (l) {
                            console.error(
                                "Make sure you have included froogaloop2 js"
                            );
                        }
                    else if (i) i.contentWindow.postMessage("pause", "*");
                    else if (k)
                        if (b.core.s.videojs)
                            try {
                                videojs(k).pause();
                            } catch (l) {
                                console.error(
                                    "Make sure you have included videojs"
                                );
                            }
                        else k.pause();
                    j &&
                        a(j).attr(
                            "src",
                            a(j).attr("src").replace("&autoplay", "&noplay")
                        );
                    var m;
                    m = b.core.s.dynamic
                        ? b.core.s.dynamicEl[e].src
                        : b.core.$items.eq(e).attr("href") ||
                          b.core.$items.eq(e).attr("data-src");
                    var n = b.core.isVideo(m, e) || {};
                    (n.youtube || n.vimeo || n.dailymotion || n.vk) &&
                        b.core.$outer.addClass("lg-hide-download");
                }),
                b.core.$el.on("onAfterSlide.lg.tm", function (a, c) {
                    b.core.$slide.eq(c).removeClass("lg-video-playing");
                });
        }),
            (f.prototype.loadVideo = function (b, c, d, e, f) {
                var g = "",
                    h = 1,
                    i = "",
                    j = this.core.isVideo(b, e) || {};
                if ((d && (h = this.videoLoaded ? 0 : 1), j.youtube))
                    (i = "?wmode=opaque&autoplay=" + h + "&enablejsapi=1"),
                        this.core.s.youtubePlayerParams &&
                            (i =
                                i +
                                "&" +
                                a.param(this.core.s.youtubePlayerParams)),
                        (g =
                            '<iframe class="lg-video-object lg-youtube ' +
                            c +
                            '" width="560" height="315" src="//www.youtube.com/embed/' +
                            j.youtube[1] +
                            i +
                            '" frameborder="0" allowfullscreen></iframe>');
                else if (j.vimeo)
                    (i = "?autoplay=" + h + "&api=1"),
                        this.core.s.vimeoPlayerParams &&
                            (i =
                                i +
                                "&" +
                                a.param(this.core.s.vimeoPlayerParams)),
                        (g =
                            '<iframe class="lg-video-object lg-vimeo ' +
                            c +
                            '" width="560" height="315"  src="//player.vimeo.com/video/' +
                            j.vimeo[1] +
                            i +
                            '" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>');
                else if (j.dailymotion)
                    (i = "?wmode=opaque&autoplay=" + h + "&api=postMessage"),
                        this.core.s.dailymotionPlayerParams &&
                            (i =
                                i +
                                "&" +
                                a.param(this.core.s.dailymotionPlayerParams)),
                        (g =
                            '<iframe class="lg-video-object lg-dailymotion ' +
                            c +
                            '" width="560" height="315" src="//www.dailymotion.com/embed/video/' +
                            j.dailymotion[1] +
                            i +
                            '" frameborder="0" allowfullscreen></iframe>');
                else if (j.html5) {
                    var k = f.substring(0, 1);
                    ("." !== k && "#" !== k) || (f = a(f).html()), (g = f);
                } else
                    j.vk &&
                        ((i = "&autoplay=" + h),
                        this.core.s.vkPlayerParams &&
                            (i = i + "&" + a.param(this.core.s.vkPlayerParams)),
                        (g =
                            '<iframe class="lg-video-object lg-vk ' +
                            c +
                            '" width="560" height="315" src="http://vk.com/video_ext.php?' +
                            j.vk[1] +
                            i +
                            '" frameborder="0" allowfullscreen></iframe>'));
                return g;
            }),
            (f.prototype.destroy = function () {
                this.videoLoaded = !1;
            }),
            (a.fn.lightGallery.modules.video = f);
    })(jQuery, window, document),
    (function (a, b, c, d) {
        "use strict";
        var e = { scale: 1, zoom: !0, actualSize: !0, enableZoomAfter: 300 },
            f = function (c) {
                return (
                    (this.core = a(c).data("lightGallery")),
                    (this.core.s = a.extend({}, e, this.core.s)),
                    this.core.s.zoom &&
                        this.core.doCss() &&
                        (this.init(),
                        (this.zoomabletimeout = !1),
                        (this.pageX = a(b).width() / 2),
                        (this.pageY = a(b).height() / 2 + a(b).scrollTop())),
                    this
                );
            };
        (f.prototype.init = function () {
            var c = this,
                d =
                    '<span id="lg-zoom-in" class="lg-icon"></span><span id="lg-zoom-out" class="lg-icon"></span>';
            c.core.s.actualSize &&
                (d += '<span id="lg-actual-size" class="lg-icon"></span>'),
                this.core.$outer.find(".lg-toolbar").append(d),
                c.core.$el.on("onSlideItemLoad.lg.tm.zoom", function (b, d, e) {
                    var f = c.core.s.enableZoomAfter + e;
                    a("body").hasClass("lg-from-hash") && e
                        ? (f = 0)
                        : a("body").removeClass("lg-from-hash"),
                        (c.zoomabletimeout = setTimeout(function () {
                            c.core.$slide.eq(d).addClass("lg-zoomable");
                        }, f + 30));
                });
            var e = 1,
                f = function (d) {
                    var e,
                        f,
                        g = c.core.$outer.find(".lg-current .lg-image"),
                        h = (a(b).width() - g.width()) / 2,
                        i = (a(b).height() - g.height()) / 2 + a(b).scrollTop();
                    (e = c.pageX - h), (f = c.pageY - i);
                    var j = (d - 1) * e,
                        k = (d - 1) * f;
                    g
                        .css("transform", "scale3d(" + d + ", " + d + ", 1)")
                        .attr("data-scale", d),
                        g
                            .parent()
                            .css({ left: -j + "px", top: -k + "px" })
                            .attr("data-x", j)
                            .attr("data-y", k);
                },
                g = function () {
                    e > 1 ? c.core.$outer.addClass("lg-zoomed") : c.resetZoom(),
                        1 > e && (e = 1),
                        f(e);
                },
                h = function (d, f, h, i) {
                    var j,
                        k = f.width();
                    j = c.core.s.dynamic
                        ? c.core.s.dynamicEl[h].width || f[0].naturalWidth || k
                        : c.core.$items.eq(h).attr("data-width") ||
                          f[0].naturalWidth ||
                          k;
                    var l;
                    c.core.$outer.hasClass("lg-zoomed")
                        ? (e = 1)
                        : j > k && ((l = j / k), (e = l || 2)),
                        i
                            ? ((c.pageX = a(b).width() / 2),
                              (c.pageY = a(b).height() / 2 + a(b).scrollTop()))
                            : ((c.pageX =
                                  d.pageX ||
                                  d.originalEvent.targetTouches[0].pageX),
                              (c.pageY =
                                  d.pageY ||
                                  d.originalEvent.targetTouches[0].pageY)),
                        g(),
                        setTimeout(function () {
                            c.core.$outer
                                .removeClass("lg-grabbing")
                                .addClass("lg-grab");
                        }, 10);
                },
                i = !1;
            c.core.$el.on("onAferAppendSlide.lg.tm.zoom", function (a, b) {
                var d = c.core.$slide.eq(b).find(".lg-image");
                d.on("dblclick", function (a) {
                    h(a, d, b);
                }),
                    d.on("touchstart", function (a) {
                        i
                            ? (clearTimeout(i), (i = null), h(a, d, b))
                            : (i = setTimeout(function () {
                                  i = null;
                              }, 300)),
                            a.preventDefault();
                    });
            }),
                a(b).on(
                    "resize.lg.zoom scroll.lg.zoom orientationchange.lg.zoom",
                    function () {
                        (c.pageX = a(b).width() / 2),
                            (c.pageY = a(b).height() / 2 + a(b).scrollTop()),
                            f(e);
                    }
                ),
                a("#lg-zoom-out").on("click.lg", function () {
                    c.core.$outer.find(".lg-current .lg-image").length &&
                        ((e -= c.core.s.scale), g());
                }),
                a("#lg-zoom-in").on("click.lg", function () {
                    c.core.$outer.find(".lg-current .lg-image").length &&
                        ((e += c.core.s.scale), g());
                }),
                a("#lg-actual-size").on("click.lg", function (a) {
                    h(
                        a,
                        c.core.$slide.eq(c.core.index).find(".lg-image"),
                        c.core.index,
                        !0
                    );
                }),
                c.core.$el.on("onBeforeSlide.lg.tm", function () {
                    (e = 1), c.resetZoom();
                }),
                c.core.isTouch || c.zoomDrag(),
                c.core.isTouch && c.zoomSwipe();
        }),
            (f.prototype.resetZoom = function () {
                this.core.$outer.removeClass("lg-zoomed"),
                    this.core.$slide
                        .find(".lg-img-wrap")
                        .removeAttr("style data-x data-y"),
                    this.core.$slide
                        .find(".lg-image")
                        .removeAttr("style data-scale"),
                    (this.pageX = a(b).width() / 2),
                    (this.pageY = a(b).height() / 2 + a(b).scrollTop());
            }),
            (f.prototype.zoomSwipe = function () {
                var a = this,
                    b = {},
                    c = {},
                    d = !1,
                    e = !1,
                    f = !1;
                a.core.$slide.on("touchstart.lg", function (c) {
                    if (a.core.$outer.hasClass("lg-zoomed")) {
                        var d = a.core.$slide
                            .eq(a.core.index)
                            .find(".lg-object");
                        (f =
                            d.outerHeight() * d.attr("data-scale") >
                            a.core.$outer.find(".lg").height()),
                            (e =
                                d.outerWidth() * d.attr("data-scale") >
                                a.core.$outer.find(".lg").width()),
                            (e || f) &&
                                (c.preventDefault(),
                                (b = {
                                    x: c.originalEvent.targetTouches[0].pageX,
                                    y: c.originalEvent.targetTouches[0].pageY,
                                }));
                    }
                }),
                    a.core.$slide.on("touchmove.lg", function (g) {
                        if (a.core.$outer.hasClass("lg-zoomed")) {
                            var h,
                                i,
                                j = a.core.$slide
                                    .eq(a.core.index)
                                    .find(".lg-img-wrap");
                            g.preventDefault(),
                                (d = !0),
                                (c = {
                                    x: g.originalEvent.targetTouches[0].pageX,
                                    y: g.originalEvent.targetTouches[0].pageY,
                                }),
                                a.core.$outer.addClass("lg-zoom-dragging"),
                                (i = f
                                    ? -Math.abs(j.attr("data-y")) + (c.y - b.y)
                                    : -Math.abs(j.attr("data-y"))),
                                (h = e
                                    ? -Math.abs(j.attr("data-x")) + (c.x - b.x)
                                    : -Math.abs(j.attr("data-x"))),
                                (Math.abs(c.x - b.x) > 15 ||
                                    Math.abs(c.y - b.y) > 15) &&
                                    j.css({ left: h + "px", top: i + "px" });
                        }
                    }),
                    a.core.$slide.on("touchend.lg", function () {
                        a.core.$outer.hasClass("lg-zoomed") &&
                            d &&
                            ((d = !1),
                            a.core.$outer.removeClass("lg-zoom-dragging"),
                            a.touchendZoom(b, c, e, f));
                    });
            }),
            (f.prototype.zoomDrag = function () {
                var c = this,
                    d = {},
                    e = {},
                    f = !1,
                    g = !1,
                    h = !1,
                    i = !1;
                c.core.$slide.on("mousedown.lg.zoom", function (b) {
                    var e = c.core.$slide.eq(c.core.index).find(".lg-object");
                    (i =
                        e.outerHeight() * e.attr("data-scale") >
                        c.core.$outer.find(".lg").height()),
                        (h =
                            e.outerWidth() * e.attr("data-scale") >
                            c.core.$outer.find(".lg").width()),
                        c.core.$outer.hasClass("lg-zoomed") &&
                            a(b.target).hasClass("lg-object") &&
                            (h || i) &&
                            (b.preventDefault(),
                            (d = { x: b.pageX, y: b.pageY }),
                            (f = !0),
                            (c.core.$outer.scrollLeft += 1),
                            (c.core.$outer.scrollLeft -= 1),
                            c.core.$outer
                                .removeClass("lg-grab")
                                .addClass("lg-grabbing"));
                }),
                    a(b).on("mousemove.lg.zoom", function (a) {
                        if (f) {
                            var b,
                                j,
                                k = c.core.$slide
                                    .eq(c.core.index)
                                    .find(".lg-img-wrap");
                            (g = !0),
                                (e = { x: a.pageX, y: a.pageY }),
                                c.core.$outer.addClass("lg-zoom-dragging"),
                                (j = i
                                    ? -Math.abs(k.attr("data-y")) + (e.y - d.y)
                                    : -Math.abs(k.attr("data-y"))),
                                (b = h
                                    ? -Math.abs(k.attr("data-x")) + (e.x - d.x)
                                    : -Math.abs(k.attr("data-x"))),
                                k.css({ left: b + "px", top: j + "px" });
                        }
                    }),
                    a(b).on("mouseup.lg.zoom", function (a) {
                        f &&
                            ((f = !1),
                            c.core.$outer.removeClass("lg-zoom-dragging"),
                            !g ||
                                (d.x === e.x && d.y === e.y) ||
                                ((e = { x: a.pageX, y: a.pageY }),
                                c.touchendZoom(d, e, h, i)),
                            (g = !1)),
                            c.core.$outer
                                .removeClass("lg-grabbing")
                                .addClass("lg-grab");
                    });
            }),
            (f.prototype.touchendZoom = function (a, b, c, d) {
                var e = this,
                    f = e.core.$slide.eq(e.core.index).find(".lg-img-wrap"),
                    g = e.core.$slide.eq(e.core.index).find(".lg-object"),
                    h = -Math.abs(f.attr("data-x")) + (b.x - a.x),
                    i = -Math.abs(f.attr("data-y")) + (b.y - a.y),
                    j =
                        (e.core.$outer.find(".lg").height() - g.outerHeight()) /
                        2,
                    k = Math.abs(
                        g.outerHeight() * Math.abs(g.attr("data-scale")) -
                            e.core.$outer.find(".lg").height() +
                            j
                    ),
                    l =
                        (e.core.$outer.find(".lg").width() - g.outerWidth()) /
                        2,
                    m = Math.abs(
                        g.outerWidth() * Math.abs(g.attr("data-scale")) -
                            e.core.$outer.find(".lg").width() +
                            l
                    );
                (Math.abs(b.x - a.x) > 15 || Math.abs(b.y - a.y) > 15) &&
                    (d && (-k >= i ? (i = -k) : i >= -j && (i = -j)),
                    c && (-m >= h ? (h = -m) : h >= -l && (h = -l)),
                    d
                        ? f.attr("data-y", Math.abs(i))
                        : (i = -Math.abs(f.attr("data-y"))),
                    c
                        ? f.attr("data-x", Math.abs(h))
                        : (h = -Math.abs(f.attr("data-x"))),
                    f.css({ left: h + "px", top: i + "px" }));
            }),
            (f.prototype.destroy = function () {
                var c = this;
                c.core.$el.off(".lg.zoom"),
                    a(b).off(".lg.zoom"),
                    c.core.$slide.off(".lg.zoom"),
                    c.core.$el.off(".lg.tm.zoom"),
                    c.resetZoom(),
                    clearTimeout(c.zoomabletimeout),
                    (c.zoomabletimeout = !1);
            }),
            (a.fn.lightGallery.modules.zoom = f);
    })(jQuery, window, document),
    (function (a, b, c, d) {
        "use strict";
        var e = { hash: !0 },
            f = function (c) {
                return (
                    (this.core = a(c).data("lightGallery")),
                    (this.core.s = a.extend({}, e, this.core.s)),
                    this.core.s.hash &&
                        ((this.oldHash = b.location.hash), this.init()),
                    this
                );
            };
        (f.prototype.init = function () {
            var c,
                d = this;
            d.core.$el.on("onAfterSlide.lg.tm", function (a, c, e) {
                b.location.hash = "lg=" + d.core.s.galleryId + "&slide=" + e;
            }),
                a(b).on("hashchange.lg.hash", function () {
                    c = b.location.hash;
                    var a = parseInt(c.split("&slide=")[1], 10);
                    c.indexOf("lg=" + d.core.s.galleryId) > -1
                        ? d.core.slide(a, !1, !1)
                        : d.core.lGalleryOn && d.core.destroy();
                });
        }),
            (f.prototype.destroy = function () {
                this.core.s.hash &&
                    (this.oldHash &&
                    this.oldHash.indexOf("lg=" + this.core.s.galleryId) < 0
                        ? (b.location.hash = this.oldHash)
                        : history.pushState
                        ? history.pushState(
                              "",
                              c.title,
                              b.location.pathname + b.location.search
                          )
                        : (b.location.hash = ""),
                    this.core.$el.off(".lg.hash"));
            }),
            (a.fn.lightGallery.modules.hash = f);
    })(jQuery, window, document);
