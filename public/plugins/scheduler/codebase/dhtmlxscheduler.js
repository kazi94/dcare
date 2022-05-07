/*
@license

dhtmlxScheduler v.5.2.1 Stardard
This software is covered by GPL license. You also can obtain Commercial or Enterprise license to use it in non-GPL project - please contact sales@dhtmlx.com. Usage without proper license is prohibited.

(c) Dinamenta, UAB.

*/
! function () {
    function dtmlXMLLoaderObject(t, e, i, a) {
        return this.xmlDoc = "", this.async = void 0 === i || i, this.onloadAction = t || null, this.mainObject = e || null, this.waitCall = null, this.rSeed = a || !1, this
    }

    function dhtmlDragAndDropObject() {
        return window.dhtmlDragAndDrop ? window.dhtmlDragAndDrop : (this.lastLanding = 0, this.dragNode = 0, this.dragStartNode = 0, this.dragStartObject = 0, this.tempDOMU = null, this.tempDOMM = null, this.waitDrag = 0, window.dhtmlDragAndDrop = this, this)
    }

    function _dhtmlxError(t, e, i) {
        return this.catches || (this.catches = []), this
    }

    function dhtmlXHeir(t, e) {
        for (var i in e) "function" == typeof e[i] && (t[i] = e[i]);
        return t
    }
    window.dhtmlx || (dhtmlx = function (t) {
            for (var e in t) dhtmlx[e] = t[e];
            return dhtmlx
        }), dhtmlx.extend_api = function (t, e, i) {
            var a = window[t];
            a && (window[t] = function (t) {
                var i;
                if (t && "object" == typeof t && !t.tagName) {
                    i = a.apply(this, e._init ? e._init(t) : arguments);
                    for (var n in dhtmlx) e[n] && this[e[n]](dhtmlx[n]);
                    for (var n in t) e[n] ? this[e[n]](t[n]) : 0 === n.indexOf("on") && this.attachEvent(n, t[n])
                } else i = a.apply(this, arguments);
                return e._patch && e._patch(this), i || this
            }, window[t].prototype = a.prototype, i && dhtmlXHeir(window[t].prototype, i))
        }, dhtmlxAjax = {
            get: function (t, e) {
                var i = new dtmlXMLLoaderObject(!0);
                return i.async = arguments.length < 3, i.waitCall = e, i.loadXML(t), i
            },
            post: function (t, e, i) {
                var a = new dtmlXMLLoaderObject(!0);
                return a.async = arguments.length < 4, a.waitCall = i, a.loadXML(t, !0, e), a
            },
            getSync: function (t) {
                return this.get(t, null, !0)
            },
            postSync: function (t, e) {
                return this.post(t, e, null, !0)
            }
        }, window.dtmlXMLLoaderObject = dtmlXMLLoaderObject, dtmlXMLLoaderObject.count = 0, dtmlXMLLoaderObject.prototype.waitLoadFunction = function (t) {
            var e = !0;
            return this.check = function () {
                if (t && t.onloadAction && (!t.xmlDoc.readyState || 4 == t.xmlDoc.readyState)) {
                    if (!e) return;
                    e = !1, dtmlXMLLoaderObject.count++, "function" == typeof t.onloadAction && t.onloadAction(t.mainObject, null, null, null, t), t.waitCall && (t.waitCall.call(this, t),
                        t.waitCall = null)
                }
            }, this.check
        }, dtmlXMLLoaderObject.prototype.getXMLTopNode = function (t, e) {
            var i;
            if (this.xmlDoc.responseXML) {
                var a = this.xmlDoc.responseXML.getElementsByTagName(t);
                if (0 === a.length && -1 != t.indexOf(":")) var a = this.xmlDoc.responseXML.getElementsByTagName(t.split(":")[1]);
                i = a[0]
            } else i = this.xmlDoc.documentElement;
            if (i) return this._retry = !1, i;
            if (!this._retry && _isIE) {
                this._retry = !0;
                var e = this.xmlDoc;
                return this.loadXMLString(this.xmlDoc.responseText.replace(/^[\s]+/, ""), !0),
                    this.getXMLTopNode(t, e)
            }
            return dhtmlxError.throwError("LoadXML", "Incorrect XML", [e || this.xmlDoc, this.mainObject]), document.createElement("div")
        }, dtmlXMLLoaderObject.prototype.loadXMLString = function (t, e) {
            if (_isIE) this.xmlDoc = new ActiveXObject("Microsoft.XMLDOM"), this.xmlDoc.async = this.async, this.xmlDoc.onreadystatechange = function () {}, this.xmlDoc.loadXML(t);
            else {
                var i = new DOMParser;
                this.xmlDoc = i.parseFromString(t, "text/xml")
            }
            e || (this.onloadAction && this.onloadAction(this.mainObject, null, null, null, this), this.waitCall && (this.waitCall(), this.waitCall = null))
        }, dtmlXMLLoaderObject.prototype.loadXML = function (t, e, i, a) {
            this.rSeed && (t += (-1 != t.indexOf("?") ? "&" : "?") + "a_dhx_rSeed=" + (new Date).valueOf()), this.filePath = t, !_isIE && window.XMLHttpRequest ? this.xmlDoc = new XMLHttpRequest : this.xmlDoc = new ActiveXObject("Microsoft.XMLHTTP"), this.async && (this.xmlDoc.onreadystatechange = new this.waitLoadFunction(this)),
                "string" == typeof e ? this.xmlDoc.open(e, t, this.async) : this.xmlDoc.open(e ? "POST" : "GET", t, this.async), a ? (this.xmlDoc.setRequestHeader("User-Agent", "dhtmlxRPC v0.1 (" + navigator.userAgent + ")"), this.xmlDoc.setRequestHeader("Content-type", "text/xml")) : e && this.xmlDoc.setRequestHeader("Content-type", "application/x-www-form-urlencoded"), this.xmlDoc.setRequestHeader("X-Requested-With", "XMLHttpRequest"), this.xmlDoc.send(i), this.async || new this.waitLoadFunction(this)()
        },
        dtmlXMLLoaderObject.prototype.destructor = function () {
            return this._filterXPath = null, this._getAllNamedChilds = null, this._retry = null, this.async = null, this.rSeed = null, this.filePath = null, this.onloadAction = null, this.mainObject = null, this.xmlDoc = null, this.doXPath = null, this.doXPathOpera = null, this.doXSLTransToObject = null, this.doXSLTransToString = null, this.loadXML = null, this.loadXMLString = null, this.doSerialization = null, this.xmlNodeToJSON = null, this.getXMLTopNode = null, this.setXSLParamValue = null, null
        },
        dtmlXMLLoaderObject.prototype.xmlNodeToJSON = function (t) {
            for (var e = {}, i = 0; i < t.attributes.length; i++) e[t.attributes[i].name] = t.attributes[i].value;
            e._tagvalue = t.firstChild ? t.firstChild.nodeValue : "";
            for (var i = 0; i < t.childNodes.length; i++) {
                var a = t.childNodes[i].tagName;
                a && (e[a] || (e[a] = []), e[a].push(this.xmlNodeToJSON(t.childNodes[i])))
            }
            return e
        }, window.dhtmlDragAndDropObject = dhtmlDragAndDropObject, dhtmlDragAndDropObject.prototype.removeDraggableItem = function (t) {
            t.onmousedown = null, t.dragStarter = null,
                t.dragLanding = null
        }, dhtmlDragAndDropObject.prototype.addDraggableItem = function (t, e) {
            t.onmousedown = this.preCreateDragCopy, t.dragStarter = e, this.addDragLanding(t, e)
        }, dhtmlDragAndDropObject.prototype.addDragLanding = function (t, e) {
            t.dragLanding = e
        }, dhtmlDragAndDropObject.prototype.preCreateDragCopy = function (t) {
            if (!t && !window.event || 2 != (t || event).button) return window.dhtmlDragAndDrop.waitDrag ? (window.dhtmlDragAndDrop.waitDrag = 0, document.body.onmouseup = window.dhtmlDragAndDrop.tempDOMU,
                document.body.onmousemove = window.dhtmlDragAndDrop.tempDOMM, !1) : (window.dhtmlDragAndDrop.dragNode && window.dhtmlDragAndDrop.stopDrag(t), window.dhtmlDragAndDrop.waitDrag = 1, window.dhtmlDragAndDrop.tempDOMU = document.body.onmouseup, window.dhtmlDragAndDrop.tempDOMM = document.body.onmousemove, window.dhtmlDragAndDrop.dragStartNode = this, window.dhtmlDragAndDrop.dragStartObject = this.dragStarter, document.body.onmouseup = window.dhtmlDragAndDrop.preCreateDragCopy,
                document.body.onmousemove = window.dhtmlDragAndDrop.callDrag, window.dhtmlDragAndDrop.downtime = (new Date).valueOf(), !(!t || !t.preventDefault) && (t.preventDefault(), !1))
        }, dhtmlDragAndDropObject.prototype.callDrag = function (t) {
            t || (t = window.event);
            var e = window.dhtmlDragAndDrop;
            if (!((new Date).valueOf() - e.downtime < 100)) {
                if (!e.dragNode) {
                    if (!e.waitDrag) return e.stopDrag(t, !0);
                    if (e.dragNode = e.dragStartObject._createDragNode(e.dragStartNode, t), !e.dragNode) return e.stopDrag();
                    e.dragNode.onselectstart = function () {
                        return !1
                    }, e.gldragNode = e.dragNode, document.body.appendChild(e.dragNode), document.body.onmouseup = e.stopDrag, e.waitDrag = 0, e.dragNode.pWindow = window, e.initFrameRoute()
                }
                if (e.dragNode.parentNode != window.document.body && e.gldragNode) {
                    var i = e.gldragNode;
                    e.gldragNode.old && (i = e.gldragNode.old), i.parentNode.removeChild(i);
                    var a = e.dragNode.pWindow;
                    if (i.pWindow && i.pWindow.dhtmlDragAndDrop.lastLanding && i.pWindow.dhtmlDragAndDrop.lastLanding.dragLanding._dragOut(i.pWindow.dhtmlDragAndDrop.lastLanding), _isIE) {
                        var n = document.createElement("div");
                        n.innerHTML = e.dragNode.outerHTML, e.dragNode = n.childNodes[0]
                    } else e.dragNode = e.dragNode.cloneNode(!0);
                    e.dragNode.pWindow = window, e.gldragNode.old = e.dragNode, document.body.appendChild(e.dragNode), a.dhtmlDragAndDrop.dragNode = e.dragNode
                }
                e.dragNode.style.left = t.clientX + 15 + (e.fx ? -1 * e.fx : 0) + (document.body.scrollLeft || document.documentElement.scrollLeft) + "px", e.dragNode.style.top = t.clientY + 3 + (e.fy ? -1 * e.fy : 0) + (document.body.scrollTop || document.documentElement.scrollTop) + "px";
                var r;
                r = t.srcElement ? t.srcElement : t.target, e.checkLanding(r, t)
            }
        }, dhtmlDragAndDropObject.prototype.calculateFramePosition = function (t) {
            if (window.name) {
                for (var e = parent.frames[window.name].frameElement.offsetParent, i = 0, a = 0; e;) i += e.offsetLeft, a += e.offsetTop,
                    e = e.offsetParent;
                if (parent.dhtmlDragAndDrop) {
                    var n = parent.dhtmlDragAndDrop.calculateFramePosition(1);
                    i += 1 * n.split("_")[0], a += 1 * n.split("_")[1]
                }
                if (t) return i + "_" + a;
                this.fx = i, this.fy = a
            }
            return "0_0"
        }, dhtmlDragAndDropObject.prototype.checkLanding = function (t, e) {
            t && t.dragLanding ? (this.lastLanding && this.lastLanding.dragLanding._dragOut(this.lastLanding), this.lastLanding = t, this.lastLanding = this.lastLanding.dragLanding._dragIn(this.lastLanding, this.dragStartNode, e.clientX, e.clientY, e),
                this.lastLanding_scr = _isIE ? e.srcElement : e.target) : t && "BODY" != t.tagName ? this.checkLanding(t.parentNode, e) : (this.lastLanding && this.lastLanding.dragLanding._dragOut(this.lastLanding, e.clientX, e.clientY, e), this.lastLanding = 0, this._onNotFound && this._onNotFound())
        }, dhtmlDragAndDropObject.prototype.stopDrag = function (t, e) {
            var i = window.dhtmlDragAndDrop;
            if (!e) {
                i.stopFrameRoute();
                var a = i.lastLanding;
                i.lastLanding = null,
                    a && a.dragLanding._drag(i.dragStartNode, i.dragStartObject, a, _isIE ? event.srcElement : t.target)
            }
            i.lastLanding = null, i.dragNode && i.dragNode.parentNode == document.body && i.dragNode.parentNode.removeChild(i.dragNode), i.dragNode = 0, i.gldragNode = 0, i.fx = 0, i.fy = 0, i.dragStartNode = 0, i.dragStartObject = 0, document.body.onmouseup = i.tempDOMU, document.body.onmousemove = i.tempDOMM, i.tempDOMU = null, i.tempDOMM = null, i.waitDrag = 0
        }, dhtmlDragAndDropObject.prototype.stopFrameRoute = function (t) {
            t && window.dhtmlDragAndDrop.stopDrag(1, 1);
            for (var e = 0; e < window.frames.length; e++) try {
                window.frames[e] != t && window.frames[e].dhtmlDragAndDrop && window.frames[e].dhtmlDragAndDrop.stopFrameRoute(window)
            } catch (t) {}
            try {
                parent.dhtmlDragAndDrop && parent != window && parent != t && parent.dhtmlDragAndDrop.stopFrameRoute(window)
            } catch (t) {}
        }, dhtmlDragAndDropObject.prototype.initFrameRoute = function (t, e) {
            t && (window.dhtmlDragAndDrop.preCreateDragCopy(),
                window.dhtmlDragAndDrop.dragStartNode = t.dhtmlDragAndDrop.dragStartNode, window.dhtmlDragAndDrop.dragStartObject = t.dhtmlDragAndDrop.dragStartObject, window.dhtmlDragAndDrop.dragNode = t.dhtmlDragAndDrop.dragNode, window.dhtmlDragAndDrop.gldragNode = t.dhtmlDragAndDrop.dragNode, window.document.body.onmouseup = window.dhtmlDragAndDrop.stopDrag, window.waitDrag = 0, !_isIE && e && (!_isFF || _FFrv < 1.8) && window.dhtmlDragAndDrop.calculateFramePosition());
            try {
                parent.dhtmlDragAndDrop && parent != window && parent != t && parent.dhtmlDragAndDrop.initFrameRoute(window)
            } catch (t) {}
            for (var i = 0; i < window.frames.length; i++) try {
                window.frames[i] != t && window.frames[i].dhtmlDragAndDrop && window.frames[i].dhtmlDragAndDrop.initFrameRoute(window, !t || e ? 1 : 0)
            } catch (t) {}
        }, _isFF = !1, _isIE = !1, _isOpera = !1, _isKHTML = !1, _isMacOS = !1, _isChrome = !1, _FFrv = !1, _KHTMLrv = !1, _OperaRv = !1, -1 != navigator.userAgent.indexOf("Macintosh") && (_isMacOS = !0),
        navigator.userAgent.toLowerCase().indexOf("chrome") > -1 && (_isChrome = !0), -1 != navigator.userAgent.indexOf("Safari") || -1 != navigator.userAgent.indexOf("Konqueror") ? (_KHTMLrv = parseFloat(navigator.userAgent.substr(navigator.userAgent.indexOf("Safari") + 7, 5)), _KHTMLrv > 525 ? (_isFF = !0, _FFrv = 1.9) : _isKHTML = !0) : -1 != navigator.userAgent.indexOf("Opera") ? (_isOpera = !0, _OperaRv = parseFloat(navigator.userAgent.substr(navigator.userAgent.indexOf("Opera") + 6, 3))) : -1 != navigator.appName.indexOf("Microsoft") ? (_isIE = !0,
            -1 == navigator.appVersion.indexOf("MSIE 8.0") && -1 == navigator.appVersion.indexOf("MSIE 9.0") && -1 == navigator.appVersion.indexOf("MSIE 10.0") || "BackCompat" == document.compatMode || (_isIE = 8)) : "Netscape" == navigator.appName && -1 != navigator.userAgent.indexOf("Trident") ? _isIE = 8 : (_isFF = !0, _FFrv = parseFloat(navigator.userAgent.split("rv:")[1])), dtmlXMLLoaderObject.prototype.doXPath = function (t, e, i, a) {
            if (_isKHTML || !_isIE && !window.XPathResult) return this.doXPathOpera(t, e);
            if (_isIE) return e || (e = this.xmlDoc.nodeName ? this.xmlDoc : this.xmlDoc.responseXML), e || dhtmlxError.throwError("LoadXML", "Incorrect XML", [e || this.xmlDoc, this.mainObject]), i && e.setProperty("SelectionNamespaces", "xmlns:xsl='" + i + "'"), "single" == a ? e.selectSingleNode(t) : e.selectNodes(t) || new Array(0);
            var n = e;
            e || (e = this.xmlDoc.nodeName ? this.xmlDoc : this.xmlDoc.responseXML), e || dhtmlxError.throwError("LoadXML", "Incorrect XML", [e || this.xmlDoc, this.mainObject]), -1 != e.nodeName.indexOf("document") ? n = e : (n = e,
                e = e.ownerDocument);
            var r = XPathResult.ANY_TYPE;
            "single" == a && (r = XPathResult.FIRST_ORDERED_NODE_TYPE);
            var s = [],
                o = e.evaluate(t, n, function (t) {
                    return i
                }, r, null);
            if (r == XPathResult.FIRST_ORDERED_NODE_TYPE) return o.singleNodeValue;
            for (var d = o.iterateNext(); d;) s[s.length] = d, d = o.iterateNext();
            return s
        }, _dhtmlxError.prototype.catchError = function (t, e) {
            this.catches[t] = e
        }, _dhtmlxError.prototype.throwError = function (t, e, i) {
            return this.catches[t] ? this.catches[t](t, e, i) : this.catches.ALL ? this.catches.ALL(t, e, i) : (window.alert("Error type: " + arguments[0] + "\nDescription: " + arguments[1]), null)
        }, window.dhtmlxError = new _dhtmlxError, dtmlXMLLoaderObject.prototype.doXPathOpera = function (t, e) {
            var i = t.replace(/[\/]+/gi, "/").split("/"),
                a = null,
                n = 1;
            if (!i.length) return [];
            if ("." == i[0]) a = [e];
            else {
                if ("" !== i[0]) return [];
                a = (this.xmlDoc.responseXML || this.xmlDoc).getElementsByTagName(i[n].replace(/\[[^\]]*\]/g, "")), n++
            }
            for (n; n < i.length; n++) a = this._getAllNamedChilds(a, i[n]);
            return -1 != i[n - 1].indexOf("[") && (a = this._filterXPath(a, i[n - 1])), a
        }, dtmlXMLLoaderObject.prototype._filterXPath = function (t, e) {
            for (var i = [], e = e.replace(/[^\[]*\[\@/g, "").replace(/[\[\]\@]*/g, ""), a = 0; a < t.length; a++) t[a].getAttribute(e) && (i[i.length] = t[a]);
            return i
        }, dtmlXMLLoaderObject.prototype._getAllNamedChilds = function (t, e) {
            var i = [];
            _isKHTML && (e = e.toUpperCase());
            for (var a = 0; a < t.length; a++)
                for (var n = 0; n < t[a].childNodes.length; n++) _isKHTML ? t[a].childNodes[n].tagName && t[a].childNodes[n].tagName.toUpperCase() == e && (i[i.length] = t[a].childNodes[n]) : t[a].childNodes[n].tagName == e && (i[i.length] = t[a].childNodes[n]);
            return i
        }, void 0 === window.dhtmlxEvent && (window.dhtmlxEvent = function (t, e, i) {
            t.addEventListener ? t.addEventListener(e, i, !1) : t.attachEvent && t.attachEvent("on" + e, i)
        }), dtmlXMLLoaderObject.prototype.xslDoc = null,
        dtmlXMLLoaderObject.prototype.setXSLParamValue = function (t, e, i) {
            i || (i = this.xslDoc), i.responseXML && (i = i.responseXML);
            var a = this.doXPath("/xsl:stylesheet/xsl:variable[@name='" + t + "']", i, "http://www.w3.org/1999/XSL/Transform", "single");
            a && (a.firstChild.nodeValue = e)
        }, dtmlXMLLoaderObject.prototype.doXSLTransToObject = function (t, e) {
            t || (t = this.xslDoc), t.responseXML && (t = t.responseXML), e || (e = this.xmlDoc), e.responseXML && (e = e.responseXML);
            var i;
            if (_isIE) {
                i = new ActiveXObject("Msxml2.DOMDocument.3.0");
                try {
                    e.transformNodeToObject(t, i)
                } catch (a) {
                    i = e.transformNode(t)
                }
            } else this.XSLProcessor || (this.XSLProcessor = new XSLTProcessor, this.XSLProcessor.importStylesheet(t)), i = this.XSLProcessor.transformToDocument(e);
            return i
        }, dtmlXMLLoaderObject.prototype.doXSLTransToString = function (t, e) {
            var i = this.doXSLTransToObject(t, e);
            return "string" == typeof i ? i : this.doSerialization(i)
        }, dtmlXMLLoaderObject.prototype.doSerialization = function (t) {
            return t || (t = this.xmlDoc), t.responseXML && (t = t.responseXML),
                _isIE ? t.xml : (new XMLSerializer).serializeToString(t)
        }, dhtmlxEventable = function (obj) {
            obj.attachEvent = function (t, e, i) {
                return t = "ev_" + t.toLowerCase(), this[t] || (this[t] = new this.eventCatcher(i || this)), t + ":" + this[t].addEvent(e)
            }, obj.callEvent = function (t, e) {
                return t = "ev_" + t.toLowerCase(), !this[t] || this[t].apply(this, e)
            }, obj.checkEvent = function (t) {
                return !!this["ev_" + t.toLowerCase()]
            }, obj.eventCatcher = function (obj) {
                var dhx_catch = [],
                    z = function () {
                        for (var t = !0, e = 0; e < dhx_catch.length; e++)
                            if (dhx_catch[e]) {
                                var i = dhx_catch[e].apply(obj, arguments);
                                t = t && i
                            } return t
                    };
                return z.addEvent = function (ev) {
                    return "function" != typeof ev && (ev = eval(ev)), !!ev && dhx_catch.push(ev) - 1
                }, z.removeEvent = function (t) {
                    dhx_catch[t] = null
                }, z
            }, obj.detachEvent = function (t) {
                if (t) {
                    var e = t.split(":");
                    this[e[0]].removeEvent(e[1])
                }
            }, obj.detachAllEvents = function () {
                for (var t in this) 0 === t.indexOf("ev_") && (this.detachEvent(t), this[t] = null)
            }, obj = null
        }, window.dhtmlx || (window.dhtmlx = {}),
        function () {
            function t(t, e) {
                setTimeout(function () {
                    if (t.box) {
                        var a = t.callback;
                        i(!1), t.box.parentNode.removeChild(t.box), dhtmlx.callEvent("onAfterMessagePopup", [t.box]), c = t.box = null, a && a(e)
                    }
                }, 1)
            }

            function e(e) {
                if (c) {
                    e = e || event;
                    var i = e.which || event.keyCode,
                        a = !1;
                    if (dhtmlx.message.keyboard) {
                        if (13 == i || 32 == i) {
                            var n = e.target || e.srcElement;
                            scheduler._getClassName(n).indexOf("dhtmlx_popup_button") > -1 && n.click ? n.click() : (t(c, !0), a = !0)
                        }
                        27 == i && (t(c, !1), a = !0)
                    }
                    if (a) return e.preventDefault && e.preventDefault(), !(e.cancelBubble = !0)
                } else;
            }

            function i(t) {
                i.cover || (i.cover = document.createElement("div"), i.cover.onkeydown = e, i.cover.className = "dhx_modal_cover", document.body.appendChild(i.cover));
                document.body.scrollHeight;
                i.cover.style.display = t ? "inline-block" : "none"
            }

            function a(t, e, i) {
                return "<div " + scheduler._waiAria.messageButtonAttrString(t) + "class='dhtmlx_popup_button dhtmlx_" + (i || t || "").toLowerCase().replace(/ /g, "_") + "_button' result='" + e + "' ><div>" + t + "</div></div>"
            }

            function n(t) {
                u.area || (u.area = document.createElement("div"),
                    u.area.className = "dhtmlx_message_area", u.area.style[u.position] = "5px", document.body.appendChild(u.area)), u.hide(t.id);
                var e = document.createElement("div");
                return e.innerHTML = "<div>" + t.text + "</div>", e.className = "dhtmlx-info dhtmlx-" + t.type, e.onclick = function () {
                    u.hide(t.id), t = null
                }, scheduler._waiAria.messageInfoAttr(e), "bottom" == u.position && u.area.firstChild ? u.area.insertBefore(e, u.area.firstChild) : u.area.appendChild(e), t.expire > 0 && (u.timers[t.id] = window.setTimeout(function () {
                    u.hide(t.id)
                }, t.expire)), u.pull[t.id] = e, e = null, t.id
            }

            function r(e, i, n) {
                var r = document.createElement("div");
                r.className = " dhtmlx_modal_box dhtmlx-" + e.type, r.setAttribute("dhxbox", 1);
                var s = scheduler.uid();
                scheduler._waiAria.messageModalAttr(r, s);
                var o = "",
                    d = !1;
                if (e.width && (r.style.width = e.width), e.height && (r.style.height = e.height), e.title && (o += '<div class="dhtmlx_popup_title" id="' + s + '">' + e.title + "</div>", d = !0),
                    o += '<div class="dhtmlx_popup_text" ' + (d ? "" : ' id="' + s + '" ') + "><span>" + (e.content ? "" : e.text) + '</span></div><div  class="dhtmlx_popup_controls">', i) {
                    var _ = e.ok || scheduler.locale.labels.message_ok;
                    void 0 === _ && (_ = "OK"), o += a(_, !0, "ok")
                }
                if (n) {
                    var l = e.cancel || scheduler.locale.labels.message_cancel;
                    void 0 === l && (l = "Cancel"), o += a(l, !1, "cancel")
                }
                if (e.buttons)
                    for (var h = 0; h < e.buttons.length; h++) o += a(e.buttons[h], h);
                if (o += "</div>", r.innerHTML = o, e.content) {
                    var u = e.content;
                    "string" == typeof u && (u = document.getElementById(u)), "none" == u.style.display && (u.style.display = ""), r.childNodes[e.title ? 1 : 0].appendChild(u)
                }
                return r.onclick = function (i) {
                    i = i || event;
                    var a = i.target || i.srcElement,
                        n = scheduler._getClassName(a);
                    if (n || (a = a.parentNode), n = scheduler._getClassName(a), "dhtmlx_popup_button" == n.split(" ")[0]) {
                        var r = a.getAttribute("result");
                        r = "true" == r || "false" != r && r, t(e, r)
                    }
                }, e.box = r, c = e, r
            }

            function s(t, a, n) {
                var s = t.tagName ? t : r(t, a, n);
                t.hidden || i(!0), document.body.appendChild(s);
                var o = Math.abs(Math.floor(((window.innerWidth || document.documentElement.offsetWidth) - s.offsetWidth) / 2)),
                    d = Math.abs(Math.floor(((window.innerHeight || document.documentElement.offsetHeight) - s.offsetHeight) / 2));
                return "top" == t.position ? s.style.top = "-3px" : s.style.top = d + "px", s.style.left = o + "px", s.onkeydown = e, dhtmlx.modalbox.focus(s), t.hidden && dhtmlx.modalbox.hide(s), dhtmlx.callEvent("onMessagePopup", [s]), s
            }

            function o(t) {
                return s(t, !0, !1)
            }

            function d(t) {
                return s(t, !0, !0)
            }

            function _(t) {
                return s(t)
            }

            function l(t, e, i) {
                return "object" != typeof t && ("function" == typeof e && (i = e, e = ""), t = {
                    text: t,
                    type: e,
                    callback: i
                }), t
            }

            function h(t, e, i, a) {
                return "object" != typeof t && (t = {
                    text: t,
                    type: e,
                    expire: i,
                    id: a
                }), t.id = t.id || u.uid(), t.expire = t.expire || u.expire, t
            }
            var c = null;
            document.attachEvent ? document.attachEvent("onkeydown", e) : document.addEventListener("keydown", e, !0), dhtmlx.alert = function () {
                var t = l.apply(this, arguments);
                return t.type = t.type || "confirm", o(t)
            }, dhtmlx.confirm = function () {
                var t = l.apply(this, arguments);
                return t.type = t.type || "alert", d(t)
            }, dhtmlx.modalbox = function () {
                var t = l.apply(this, arguments);
                return t.type = t.type || "alert", _(t)
            }, dhtmlx.modalbox.hide = function (t) {
                for (; t && t.getAttribute && !t.getAttribute("dhxbox");) t = t.parentNode;
                t && (t.parentNode.removeChild(t), i(!1))
            }, dhtmlx.modalbox.focus = function (t) {
                setTimeout(function () {
                    var e = scheduler._getFocusableNodes(t);
                    e.length && e[0].focus && e[0].focus()
                }, 1)
            };
            var u = dhtmlx.message = function (t, e, i, a) {
                switch (t = h.apply(this, arguments), t.type = t.type || "info",
                    t.type.split("-")[0]) {
                    case "alert":
                        return o(t);
                    case "confirm":
                        return d(t);
                    case "modalbox":
                        return _(t);
                    default:
                        return n(t)
                }
            };
            u.seed = (new Date).valueOf(), u.uid = function () {
                return u.seed++
            }, u.expire = 4e3, u.keyboard = !0, u.position = "top", u.pull = {}, u.timers = {}, u.hideAll = function () {
                for (var t in u.pull) u.hide(t)
            }, u.hide = function (t) {
                var e = u.pull[t];
                e && e.parentNode && (window.setTimeout(function () {
                        e.parentNode.removeChild(e), e = null
                    }, 2e3), e.className += " hidden", u.timers[t] && window.clearTimeout(u.timers[t]),
                    delete u.pull[t])
            }
        }(), dhtmlx.attachEvent || dhtmlxEventable(dhtmlx);
    var dataProcessor = window.dataProcessor = function (t) {
        return this.serverProcessor = t, this.action_param = "!nativeeditor_status", this.object = null, this.updatedRows = [], this.autoUpdate = !0, this.updateMode = "cell", this._tMode = "GET", this._headers = null, this._payload = null, this.post_delim = "_", this._waitMode = 0, this._in_progress = {}, this._invalid = {}, this.mandatoryFields = [], this.messages = [], this.styles = {
            updated: "font-weight:bold;",
            inserted: "font-weight:bold;",
            deleted: "text-decoration : line-through;",
            invalid: "background-color:FFE0E0;",
            invalid_cell: "border-bottom:2px solid red;",
            error: "color:red;",
            clear: "font-weight:normal;text-decoration:none;"
        }, this.enableUTFencoding(!0), dhtmlxEventable(this), this
    };
    dataProcessor.prototype = {
        setTransactionMode: function (t, e) {
            "object" == typeof t ? (this._tMode = t.mode || this._tMode, void 0 !== t.headers && (this._headers = t.headers), void 0 !== t.payload && (this._payload = t.payload)) : (this._tMode = t,
                this._tSend = e), "REST" == this._tMode && (this._tSend = !1, this._endnm = !0), "JSON" == this._tMode && (this._tSend = !1, this._endnm = !0, this._headers = this._headers || {}, this._headers["Content-type"] = "application/json")
        },
        escape: function (t) {
            return this._utf ? encodeURIComponent(t) : escape(t)
        },
        enableUTFencoding: function (t) {
            this._utf = !!t
        },
        setDataColumns: function (t) {
            this._columns = "string" == typeof t ? t.split(",") : t
        },
        getSyncState: function () {
            return !this.updatedRows.length
        },
        enableDataNames: function (t) {
            this._endnm = !!t
        },
        enablePartialDataSend: function (t) {
            this._changed = !!t
        },
        setUpdateMode: function (t, e) {
            this.autoUpdate = "cell" == t, this.updateMode = t, this.dnd = e
        },
        ignore: function (t, e) {
            this._silent_mode = !0, t.call(e || window), this._silent_mode = !1
        },
        setUpdated: function (t, e, i) {
            if (!this._silent_mode) {
                var a = this.findRow(t);
                i = i || "updated";
                var n = this.obj.getUserData(t, this.action_param);
                n && "updated" == i && (i = n), e ? (this.set_invalid(t, !1), this.updatedRows[a] = t, this.obj.setUserData(t, this.action_param, i),
                    this._in_progress[t] && (this._in_progress[t] = "wait")) : this.is_invalid(t) || (this.updatedRows.splice(a, 1), this.obj.setUserData(t, this.action_param, "")), e || this._clearUpdateFlag(t), this.markRow(t, e, i), e && this.autoUpdate && this.sendData(t)
            }
        },
        _clearUpdateFlag: function (t) {},
        markRow: function (t, e, i) {
            var a = "",
                n = this.is_invalid(t);
            if (n && (a = this.styles[n], e = !0), this.callEvent("onRowMark", [t, e, i, n]) && (a = this.styles[e ? i : "clear"] + a, this.obj[this._methods[0]](t, a), n && n.details)) {
                a += this.styles[n + "_cell"];
                for (var r = 0; r < n.details.length; r++) n.details[r] && this.obj[this._methods[1]](t, r, a)
            }
        },
        getState: function (t) {
            return this.obj.getUserData(t, this.action_param)
        },
        is_invalid: function (t) {
            return this._invalid[t]
        },
        set_invalid: function (t, e, i) {
            i && (e = {
                value: e,
                details: i,
                toString: function () {
                    return this.value.toString()
                }
            }), this._invalid[t] = e
        },
        checkBeforeUpdate: function (t) {
            return !0
        },
        sendData: function (t) {
            if (!this._waitMode || "tree" != this.obj.mytype && !this.obj._h2) {
                if (this.obj.editStop && this.obj.editStop(),
                    void 0 === t || this._tSend) return this.sendAllData();
                if (this._in_progress[t]) return !1;
                if (this.messages = [], !this.checkBeforeUpdate(t) && this.callEvent("onValidationError", [t, this.messages])) return !1;
                this._beforeSendData(this._getRowData(t), t)
            }
        },
        _beforeSendData: function (t, e) {
            if (!this.callEvent("onBeforeUpdate", [e, this.getState(e), t])) return !1;
            this._sendData(t, e)
        },
        serialize: function (t, e) {
            if ("string" == typeof t) return t;
            if (void 0 !== e) return this.serialize_one(t, "");
            var i = [],
                a = [];
            for (var n in t) t.hasOwnProperty(n) && (i.push(this.serialize_one(t[n], n + this.post_delim)), a.push(n));
            return i.push("ids=" + this.escape(a.join(","))), (scheduler.security_key || dhtmlx.security_key) && i.push("dhx_security=" + (scheduler.security_key || dhtmlx.security_key)), i.join("&")
        },
        serialize_one: function (t, e) {
            if ("string" == typeof t) return t;
            var i = [];
            for (var a in t)
                if (t.hasOwnProperty(a)) {
                    if (("id" == a || a == this.action_param) && "REST" == this._tMode) continue;
                    i.push(this.escape((e || "") + a) + "=" + this.escape(t[a]))
                } return i.join("&")
        },
        _applyPayload: function (t) {
            var e = this.obj.$ajax;
            if (this._payload)
                for (var i in this._payload) t = t + e.urlSeparator(t) + this.escape(i) + "=" + this.escape(this._payload[i]);
            return t
        },
        _sendData: function (t, e) {
            if (t) {
                if (!this.callEvent("onBeforeDataSending", e ? [e, this.getState(e), t] : [null, null, t])) return !1;
                e && (this._in_progress[e] = (new Date).valueOf());
                var i = this,
                    a = function (a) {
                        var n = [];
                        if (e) n.push(e);
                        else if (t)
                            for (var r in t) n.push(r);
                        return i.afterUpdate(i, a, n)
                    },
                    n = this.obj.$ajax,
                    r = this.serverProcessor + (this._user ? n.urlSeparator(this.serverProcessor) + ["dhx_user=" + this._user, "dhx_version=" + this.obj.getUserData(0, "version")].join("&") : ""),
                    s = this._applyPayload(r);
                if ("GET" == this._tMode) n.query({
                    url: s + n.urlSeparator(s) + this.serialize(t, e),
                    method: "GET",
                    callback: a,
                    headers: this._headers
                });
                else if ("POST" == this._tMode) n.query({
                    url: s,
                    method: "POST",
                    headers: this._headers,
                    data: this.serialize(t, e),
                    callback: a
                });
                else if ("JSON" == this._tMode) {
                    var o = t[this.action_param],
                        d = {};
                    for (var _ in t) d[_] = t[_];
                    delete d[this.action_param], delete d.id, delete d.gr_id, n.query({
                        url: s,
                        method: "POST",
                        headers: this._headers,
                        callback: a,
                        data: JSON.stringify({
                            id: e,
                            action: o,
                            data: d
                        })
                    })
                } else if ("REST" == this._tMode) {
                    var l = this.getState(e),
                        h = r.replace(/(\&|\?)editing\=true/, ""),
                        d = "",
                        c = "post";
                    "inserted" == l ? d = this.serialize(t, e) : "deleted" == l ? (c = "DELETE", h = h + ("/" == h.slice(-1) ? "" : "/") + e) : (c = "PUT", d = this.serialize(t, e), h = h + ("/" == h.slice(-1) ? "" : "/") + e),
                        h = this._applyPayload(h), n.query({
                            url: h,
                            method: c,
                            headers: this._headers,
                            data: d,
                            callback: a
                        })
                }
                this._waitMode++
            }
        },
        sendAllData: function () {
            if (this.updatedRows.length) {
                this.messages = [];
                for (var t = !0, e = 0; e < this.updatedRows.length; e++) t &= this.checkBeforeUpdate(this.updatedRows[e]);
                if (!t && !this.callEvent("onValidationError", ["", this.messages])) return !1;
                if (this._tSend) this._sendData(this._getAllData());
                else
                    for (var e = 0; e < this.updatedRows.length; e++)
                        if (!this._in_progress[this.updatedRows[e]]) {
                            if (this.is_invalid(this.updatedRows[e])) continue;
                            if (this._beforeSendData(this._getRowData(this.updatedRows[e]), this.updatedRows[e]), this._waitMode && ("tree" == this.obj.mytype || this.obj._h2)) return
                        }
            }
        },
        _getAllData: function (t) {
            for (var e = {}, i = !1, a = 0; a < this.updatedRows.length; a++) {
                var n = this.updatedRows[a];
                if (!this._in_progress[n] && !this.is_invalid(n)) {
                    var r = this._getRowData(n);
                    this.callEvent("onBeforeUpdate", [n, this.getState(n), r]) && (e[n] = r, i = !0, this._in_progress[n] = (new Date).valueOf())
                }
            }
            return i ? e : null
        },
        setVerificator: function (t, e) {
            this.mandatoryFields[t] = e || function (t) {
                return "" !== t
            }
        },
        clearVerificator: function (t) {
            this.mandatoryFields[t] = !1
        },
        findRow: function (t) {
            var e = 0;
            for (e = 0; e < this.updatedRows.length && t != this.updatedRows[e]; e++);
            return e
        },
        defineAction: function (t, e) {
            this._uActions || (this._uActions = []), this._uActions[t] = e
        },
        afterUpdateCallback: function (t, e, i, a) {
            var n = t,
                r = "error" != i && "invalid" != i;
            if (r || this.set_invalid(t, i),
                this._uActions && this._uActions[i] && !this._uActions[i](a)) return delete this._in_progress[n];
            "wait" != this._in_progress[n] && this.setUpdated(t, !1);
            var s = t;
            switch (i) {
                case "inserted":
                case "insert":
                    e != t && (this.setUpdated(t, !1), this.obj[this._methods[2]](t, e), t = e);
                    break;
                case "delete":
                case "deleted":
                    return this.obj.setUserData(t, this.action_param, "true_deleted"), this.obj[this._methods[3]](t, e), delete this._in_progress[n], this.callEvent("onAfterUpdate", [t, i, e, a])
            }
            "wait" != this._in_progress[n] ? (r && this.obj.setUserData(t, this.action_param, ""), delete this._in_progress[n]) : (delete this._in_progress[n], this.setUpdated(e, !0, this.obj.getUserData(t, this.action_param))), this.callEvent("onAfterUpdate", [s, i, e, a])
        },
        _errorResponse: function (t, e) {
            return this.obj && this.obj.callEvent && this.obj.callEvent("onSaveError", [e, t.xmlDoc]), this.cleanUpdate(e)
        },
        afterUpdate: function (t, e, i) {
            var a = this.obj.$ajax;
            if (200 !== e.xmlDoc.status) return void this._errorResponse(e, i);
            if (window.JSON) {
                var n;
                try {
                    n = JSON.parse(e.xmlDoc.responseText)
                } catch (t) {
                    e.xmlDoc.responseText.length || (n = {})
                }
                if (n) {
                    var r = n.action || this.getState(i) || "updated",
                        s = n.sid || i[0],
                        o = n.tid || i[0];
                    return t.afterUpdateCallback(s, o, r, n), void t.finalizeUpdate()
                }
            }
            var d = a.xmltop("data", e.xmlDoc);
            if (!d) return this._errorResponse(e, i);
            var _ = a.xpath("//data/action", d);
            _.length || this._errorResponse(e, i);
            for (var l = 0; l < _.length; l++) {
                var h = _[l],
                    r = h.getAttribute("type"),
                    s = h.getAttribute("sid"),
                    o = h.getAttribute("tid");
                t.afterUpdateCallback(s, o, r, h)
            }
            t.finalizeUpdate()
        },
        cleanUpdate: function (t) {
            if (t)
                for (var e = 0; e < t.length; e++) delete this._in_progress[t[e]]
        },
        finalizeUpdate: function () {
            this._waitMode && this._waitMode--, ("tree" == this.obj.mytype || this.obj._h2) && this.updatedRows.length && this.sendData(), this.callEvent("onAfterUpdateFinish", []), this.updatedRows.length || this.callEvent("onFullSync", [])
        },
        init: function (t) {
            this.obj = t, this.obj._dp_init && this.obj._dp_init(this)
        },
        setOnAfterUpdate: function (t) {
            this.attachEvent("onAfterUpdate", t)
        },
        enableDebug: function (t) {},
        setOnBeforeUpdateHandler: function (t) {
            this.attachEvent("onBeforeDataSending", t)
        },
        setAutoUpdate: function (t, e) {
            t = t || 2e3, this._user = e || (new Date).valueOf(), this._need_update = !1, this._update_busy = !1, this.attachEvent("onAfterUpdate", function (t, e, i, a) {
                this.afterAutoUpdate(t, e, i, a)
            }), this.attachEvent("onFullSync", function () {
                this.fullSync()
            });
            var i = this;
            window.setInterval(function () {
                i.loadUpdate()
            }, t)
        },
        afterAutoUpdate: function (t, e, i, a) {
            return "collision" != e || (this._need_update = !0, !1)
        },
        fullSync: function () {
            return this._need_update && (this._need_update = !1, this.loadUpdate()), !0
        },
        getUpdates: function (t, e) {
            var i = this.obj.$ajax;
            if (this._update_busy) return !1;
            this._update_busy = !0, i.get(t, e)
        },
        _v: function (t) {
            return t.firstChild ? t.firstChild.nodeValue : ""
        },
        _a: function (t) {
            for (var e = [], i = 0; i < t.length; i++) e[i] = this._v(t[i]);
            return e
        },
        loadUpdate: function () {
            var t = this.obj.$ajax,
                e = this,
                i = this.obj.getUserData(0, "version"),
                a = this.serverProcessor + t.urlSeparator(this.serverProcessor) + ["dhx_user=" + this._user, "dhx_version=" + i].join("&");
            a = a.replace("editing=true&", ""), this.getUpdates(a, function (i) {
                var a = t.xpath("//userdata", i);
                e.obj.setUserData(0, "version", e._v(a[0]));
                var n = t.xpath("//update", i);
                if (n.length) {
                    e._silent_mode = !0;
                    for (var r = 0; r < n.length; r++) {
                        var s = n[r].getAttribute("status"),
                            o = n[r].getAttribute("id"),
                            d = n[r].getAttribute("parent");
                        switch (s) {
                            case "inserted":
                                e.callEvent("insertCallback", [n[r], o, d]);
                                break;
                            case "updated":
                                e.callEvent("updateCallback", [n[r], o, d]);
                                break;
                            case "deleted":
                                e.callEvent("deleteCallback", [n[r], o, d])
                        }
                    }
                    e._silent_mode = !1
                }
                e._update_busy = !1, e = null
            })
        }
    }, window.dataProcessor && !dataProcessor.prototype.init_original && (dataProcessor.prototype.init_original = dataProcessor.prototype.init, dataProcessor.prototype.init = function (t) {
        this.init_original(t), t._dataprocessor = this, this.setTransactionMode("POST", !0),
            this.serverProcessor += (-1 != this.serverProcessor.indexOf("?") ? "&" : "?") + "editing=true"
    }), dhtmlxError.catchError("LoadXML", function (t, e, i) {
        var a = i[0].responseText;
        switch (scheduler.config.ajax_error) {
            case "alert":
                window.alert(a);
                break;
            case "console":
                window.console.log(a)
        }
    });
    var Scheduler = {
        _seed: 0
    };
    Scheduler.plugin = function (t) {
        this._schedulerPlugins.push(t), t(window.scheduler)
    }, Scheduler._schedulerPlugins = [], Scheduler.getSchedulerInstance = function () {
        var t = {
            version: "5.2.1"
        };
        dhtmlxEventable(t),
            t._detachDomEvent = function (t, e, i) {
                t.removeEventListener ? t.removeEventListener(e, i, !1) : t.detachEvent && t.detachEvent("on" + e, i)
            }, t._init_once = function () {
                function e(t) {
                    for (var e = document.body; t && t != e;) t = t.parentNode;
                    return !(e != t)
                }

                function i() {
                    return {
                        w: window.innerWidth || document.documentElement.clientWidth,
                        h: window.innerHeight || document.documentElement.clientHeight
                    }
                }

                function a(t, e) {
                    return t.w == e.w && t.h == e.h
                }
                var n = i();
                dhtmlxEvent(window, "resize", function () {
                    e(t._obj) && (window.clearTimeout(t._resize_timer), t._resize_timer = window.setTimeout(function () {
                        var r = i();
                        if (!a(n, r)) {
                            if (!e(t._obj)) return;
                            t.callEvent("onSchedulerResize", []) && (t.updateView(), t.callEvent("onAfterSchedulerResize", []))
                        }
                        n = r
                    }, 100))
                }), t._init_once = function () {}
            }, t.init = function (e, i, a) {
                i = i || t._currentDate(), a = a || "week", this._obj && this.unset_actions(), this._obj = "string" == typeof e ? document.getElementById(e) : e, this.$container = this._obj,
                    this.config.wai_aria_attributes && this.config.wai_aria_application_role && this.$container.setAttribute("role", "application"), this._skin_init && t._skin_init(), t.date.init(), this._els = [], this._scroll = !0, this._quirks = _isIE && "BackCompat" == document.compatMode, this._quirks7 = _isIE && -1 == navigator.appVersion.indexOf("MSIE 8"), this.get_elements(), this.init_templates(), this.set_actions(), this._init_once(), this._init_touch_events(), this.set_sizes(), t.callEvent("onSchedulerReady", []), this.setCurrentView(i, a)
            },
            t.xy = {
                min_event_height: 40,
                scale_width: 50,
                scroll_width: 18,
                scale_height: 20,
                month_scale_height: 20,
                menu_width: 25,
                margin_top: 0,
                margin_left: 0,
                editor_width: 140,
                month_head_height: 22,
                event_header_height: 14
            }, t.keys = {
                edit_save: 13,
                edit_cancel: 27
            }, t.bind = function (t, e) {
                return t.bind ? t.bind(e) : function () {
                    return t.apply(e, arguments)
                }
            }, t.set_sizes = function () {
                var e = this._x = this._obj.clientWidth - this.xy.margin_left,
                    i = this._y = this._obj.clientHeight - this.xy.margin_top,
                    a = this._table_view ? 0 : this.xy.scale_width + this.xy.scroll_width,
                    n = this._table_view ? -1 : this.xy.scale_width,
                    r = this.$container.querySelector(".dhx_cal_scale_placeholder");
                t._is_material_skin() ? (r || (r = document.createElement("div"), r.className = "dhx_cal_scale_placeholder", this.$container.insertBefore(r, this._els.dhx_cal_header[0])), r.style.display = "block",
                    this.set_xy(r, e, this.xy.scale_height + 1, 0, this.xy.nav_height + (this._quirks ? -1 : 1))) : r && r.parentNode.removeChild(r), this.set_xy(this._els.dhx_cal_navline[0], e, this.xy.nav_height, 0, 0), this.set_xy(this._els.dhx_cal_header[0], e - a, this.xy.scale_height, n, this.xy.nav_height + (this._quirks ? -1 : 1));
                var s = this._els.dhx_cal_navline[0].offsetHeight;
                s > 0 && (this.xy.nav_height = s);
                var o = this.xy.scale_height + this.xy.nav_height + (this._quirks ? -2 : 0);
                this.set_xy(this._els.dhx_cal_data[0], e, i - (o + 2), 0, o + 2)
            },
            t.set_xy = function (t, e, i, a, n) {
                t.style.width = Math.max(0, e) + "px", t.style.height = Math.max(0, i) + "px", arguments.length > 3 && (t.style.left = a + "px", t.style.top = n + "px")
            }, t.get_elements = function () {
                for (var e = this._obj.getElementsByTagName("DIV"), i = 0; i < e.length; i++) {
                    var a = t._getClassName(e[i]),
                        n = e[i].getAttribute("name") || "";
                    a && (a = a.split(" ")[0]), this._els[a] || (this._els[a] = []), this._els[a].push(e[i]);
                    var r = t.locale.labels[n || a];
                    "string" != typeof r && n && !e[i].innerHTML && (r = n.split("_")[0]),
                        r && (this._waiAria.labelAttr(e[i], r), e[i].innerHTML = r)
                }
            }, t.unset_actions = function () {
                for (var t in this._els)
                    if (this._click[t])
                        for (var e = 0; e < this._els[t].length; e++) this._els[t][e].onclick = null;
                this._obj.onselectstart = null, this._obj.onmousemove = null, this._obj.onmousedown = null, this._obj.onmouseup = null, this._obj.ondblclick = null, this._obj.oncontextmenu = null
            }, t.set_actions = function () {
                for (var e in this._els)
                    if (this._click[e])
                        for (var i = 0; i < this._els[e].length; i++) this._els[e][i].onclick = t._click[e];
                this._obj.onselectstart = function (t) {
                    return !1
                }, this._obj.onmousemove = function (e) {
                    t._temp_touch_block || t._on_mouse_move(e || event)
                }, this._obj.onmousedown = function (e) {
                    t._ignore_next_click || t._on_mouse_down(e || event)
                }, this._obj.onmouseup = function (e) {
                    t._ignore_next_click || t._on_mouse_up(e || event)
                }, this._obj.ondblclick = function (e) {
                    t._on_dbl_click(e || event)
                }, this._obj.oncontextmenu = function (e) {
                    var i = e || event,
                        a = i.target || i.srcElement;
                    return t.callEvent("onContextMenu", [t._locate_event(a), i])
                }
            },
            t.select = function (e) {
                this._select_id != e && (t._close_not_saved(), this.editStop(!1), this.unselect(), this._select_id = e, this.updateEvent(e))
            }, t.unselect = function (t) {
                if (!t || t == this._select_id) {
                    var e = this._select_id;
                    this._select_id = null, e && this.getEvent(e) && this.updateEvent(e)
                }
            }, t.getState = function () {
                return {
                    mode: this._mode,
                    date: new Date(this._date),
                    min_date: new Date(this._min_date),
                    max_date: new Date(this._max_date),
                    editor_id: this._edit_id,
                    lightbox_id: this._lightbox_id,
                    new_event: this._new_event,
                    select_id: this._select_id,
                    expanded: this.expanded,
                    drag_id: this._drag_id,
                    drag_mode: this._drag_mode
                }
            }, t._click = {
                dhx_cal_data: function (e) {
                    if (t._ignore_next_click) return e.preventDefault && e.preventDefault(), e.cancelBubble = !0, t._ignore_next_click = !1, !1;
                    var i = e ? e.target : event.srcElement,
                        a = t._locate_event(i);
                    if (e = e || event, a) {
                        if (!t.callEvent("onClick", [a, e]) || t.config.readonly) return
                    } else t.callEvent("onEmptyClick", [t.getActionData(e).date, e]);
                    if (a && t.config.select) {
                        t.select(a);
                        var n = t._getClassName(i); - 1 != n.indexOf("_icon") && t._click.buttons[n.split(" ")[1].replace("icon_", "")](a)
                    } else t._close_not_saved(), (new Date).valueOf() - (t._new_event || 0) > 500 && t.unselect()
                },
                dhx_cal_prev_button: function () {
                    t._click.dhx_cal_next_button(0, -1)
                },
                dhx_cal_next_button: function (e, i) {
                    t.setCurrentView(t.date.add(t.date[t._mode + "_start"](new Date(t._date)), i || 1, t._mode))
                },
                dhx_cal_today_button: function () {
                    t.callEvent("onBeforeTodayDisplayed", []) && t.setCurrentView(t._currentDate())
                },
                dhx_cal_tab: function () {
                    var e = this.getAttribute("name"),
                        i = e.substring(0, e.search("_tab"));
                    t.setCurrentView(t._date, i)
                },
                buttons: {
                    delete: function (e) {
                        var i = t.locale.labels.confirm_deleting;
                        t._dhtmlx_confirm(i, t.locale.labels.title_confirm_deleting, function () {
                            t.deleteEvent(e)
                        })
                    },
                    edit: function (e) {
                        t.edit(e)
                    },
                    save: function (e) {
                        t.editStop(!0)
                    },
                    details: function (e) {
                        t.showLightbox(e)
                    },
                    cancel: function (e) {
                        t.editStop(!1)
                    }
                }
            }, t._dhtmlx_confirm = function (t, e, i) {
                if (!t) return i();
                var a = {
                    text: t
                };
                e && (a.title = e), i && (a.callback = function (t) {
                    t && i()
                }), dhtmlx.confirm(a)
            }, t.addEventNow = function (e, i, a) {
                var n = {};
                t._isObject(e) && !t._isDate(e) && (n = e, e = null);
                var r = 6e4 * (this.config.event_duration || this.config.time_step);
                e || (e = n.start_date || Math.round(t._currentDate().valueOf() / r) * r);
                var s = new Date(e);
                if (!i) {
                    var o = this.config.first_hour;
                    o > s.getHours() && (s.setHours(o), e = s.valueOf()), i = e.valueOf() + r
                }
                var d = new Date(i);
                s.valueOf() == d.valueOf() && d.setTime(d.valueOf() + r), n.start_date = n.start_date || s, n.end_date = n.end_date || d,
                    n.text = n.text || this.locale.labels.new_event, n.id = this._drag_id = n.id || this.uid(), this._drag_mode = "new-size", this._loading = !0;
                var _ = this.addEvent(n);
                return this.callEvent("onEventCreated", [this._drag_id, a]), this._loading = !1, this._drag_event = {}, this._on_mouse_up(a), _
            }, t._on_dbl_click = function (e, i) {
                if (i = i || e.target || e.srcElement, !this.config.readonly) {
                    var a = t._getClassName(i).split(" ")[0];
                    switch (a) {
                        case "dhx_scale_holder":
                        case "dhx_scale_holder_now":
                        case "dhx_month_body":
                        case "dhx_wa_day_data":
                            if (!t.config.dblclick_create) break;
                            this.addEventNow(this.getActionData(e).date, null, e);
                            break;
                        case "dhx_cal_event":
                        case "dhx_wa_ev_body":
                        case "dhx_agenda_line":
                        case "dhx_grid_event":
                        case "dhx_cal_event_line":
                        case "dhx_cal_event_clear":
                            var n = this._locate_event(i);
                            if (!this.callEvent("onDblClick", [n, e])) return;
                            this.config.details_on_dblclick || this._table_view || !this.getEvent(n)._timed || !this.config.select ? this.showLightbox(n) : this.edit(n);
                            break;
                        case "dhx_time_block":
                        case "dhx_cal_container":
                            return;
                        default:
                            var r = this["dblclick_" + a];
                            if (r) r.call(this, e);
                            else if (i.parentNode && i != this) return t._on_dbl_click(e, i.parentNode)
                    }
                }
            }, t._get_column_index = function (t) {
                var e = 0;
                if (this._cols) {
                    for (var i = 0, a = 0; i + this._cols[a] < t && a < this._cols.length;) i += this._cols[a], a++;
                    if (e = a + (this._cols[a] ? (t - i) / this._cols[a] : 0), this._ignores && e >= this._cols.length)
                        for (; e >= 1 && this._ignores[Math.floor(e)];) e--
                }
                return e
            }, t._week_indexes_from_pos = function (t) {
                if (this._cols) {
                    var e = this._get_column_index(t.x);
                    return t.x = Math.min(this._cols.length - 1, Math.max(0, Math.ceil(e) - 1)), t.y = Math.max(0, Math.ceil(60 * t.y / (this.config.time_step * this.config.hour_size_px)) - 1) + this.config.first_hour * (60 / this.config.time_step), t
                }
                return t
            }, t._mouse_coords = function (e) {
                var i, a = document.body,
                    n = document.documentElement;
                i = _isIE || !e.pageX && !e.pageY ? {
                        x: e.clientX + (a.scrollLeft || n.scrollLeft || 0) - a.clientLeft,
                        y: e.clientY + (a.scrollTop || n.scrollTop || 0) - a.clientTop
                    } : {
                        x: e.pageX,
                        y: e.pageY
                    },
                    i.x -= this.$domHelpers.getAbsoluteLeft(this._obj) + (this._table_view ? 0 : this.xy.scale_width), i.y -= this.$domHelpers.getAbsoluteTop(this._obj) + this.xy.nav_height + (this._dy_shift || 0) + this.xy.scale_height - this._els.dhx_cal_data[0].scrollTop, i.ev = e;
                var r = this["mouse_" + this._mode];
                if (r) i = r.call(this, i);
                else if (this._table_view) {
                    var s = this._get_column_index(i.x);
                    if (!this._cols || !this._colsS) return i;
                    var o = 0;
                    for (o = 1; o < this._colsS.heights.length && !(this._colsS.heights[o] > i.y); o++);
                    i.y = Math.ceil(24 * (Math.max(0, s) + 7 * Math.max(0, o - 1)) * 60 / this.config.time_step), (t._drag_mode || "month" == this._mode) && (i.y = 24 * (Math.max(0, Math.ceil(s) - 1) + 7 * Math.max(0, o - 1)) * 60 / this.config.time_step), "move" == this._drag_mode && t._ignores_detected && t.config.preserve_length && (i._ignores = !0, this._drag_event._event_length || (this._drag_event._event_length = this._get_real_event_length(this._drag_event.start_date, this._drag_event.end_date, {
                        x_step: 1,
                        x_unit: "day"
                    }))), i.x = 0
                } else i = this._week_indexes_from_pos(i);
                return i.timestamp = +new Date, i
            }, t._close_not_saved = function () {
                if ((new Date).valueOf() - (t._new_event || 0) > 500 && t._edit_id) {
                    var e = t.locale.labels.confirm_closing;
                    t._dhtmlx_confirm(e, t.locale.labels.title_confirm_closing, function () {
                        t.editStop(t.config.positive_closing)
                    }), e && (this._drag_id = this._drag_pos = this._drag_mode = null)
                }
            }, t._correct_shift = function (e, i) {
                return e -= 6e4 * (new Date(t._min_date).getTimezoneOffset() - new Date(e).getTimezoneOffset()) * (i ? -1 : 1)
            }, t._is_pos_changed = function (t, e) {
                function i(t, e, i) {
                    return !!(Math.abs(t - e) > i)
                }
                if (!t || !this._drag_pos) return !0;
                var a = 5;
                return !!(this._drag_pos.has_moved || !this._drag_pos.timestamp || e.timestamp - this._drag_pos.timestamp > 100 || i(t.ev.clientX, e.ev.clientX, a) || i(t.ev.clientY, e.ev.clientY, a))
            }, t._correct_drag_start_date = function (e) {
                var i;
                t.matrix && (i = t.matrix[t._mode]), i = i || {
                    x_step: 1,
                    x_unit: "day"
                }, e = new Date(e);
                var a = 1;
                return (i._start_correction || i._end_correction) && (a = 60 * (i.last_hour || 0) - (60 * e.getHours() + e.getMinutes()) || 1),
                    1 * e + (t._get_fictional_event_length(e, a, i) - a)
            }, t._correct_drag_end_date = function (e, i) {
                var a;
                t.matrix && (a = t.matrix[t._mode]), a = a || {
                    x_step: 1,
                    x_unit: "day"
                };
                var n = 1 * e + t._get_fictional_event_length(e, i, a);
                return new Date(1 * n - (t._get_fictional_event_length(n, -1, a, -1) + 1))
            }, t._on_mouse_move = function (e) {
                if (this._drag_mode) {
                    var i = this._mouse_coords(e);
                    if (this._is_pos_changed(this._drag_pos, i)) {
                        var a, n;
                        if (this._edit_id != this._drag_id && this._close_not_saved(), !this._drag_mode) return;
                        var r = null;
                        if (this._drag_pos && !this._drag_pos.has_moved && (r = this._drag_pos, r.has_moved = !0), this._drag_pos = i, this._drag_pos.has_moved = !0, "create" == this._drag_mode) {
                            if (r && (i = r), this._close_not_saved(), this.unselect(this._select_id), this._loading = !0, a = this._get_date_from_pos(i).valueOf(), !this._drag_start) {
                                return this.callEvent("onBeforeEventCreated", [e, this._drag_id]) ? (this._loading = !1, void(this._drag_start = a)) : void(this._loading = !1)
                            }
                            n = a, this._drag_start;
                            var s = new Date(this._drag_start),
                                o = new Date(n);
                            "day" != this._mode && "week" != this._mode || s.getHours() != o.getHours() || s.getMinutes() != o.getMinutes() || (o = new Date(this._drag_start + 1e3)), this._drag_id = this.uid(), this.addEvent(s, o, this.locale.labels.new_event, this._drag_id, i.fields), this.callEvent("onEventCreated", [this._drag_id, e]), this._loading = !1, this._drag_mode = "new-size"
                        }
                        var d, _ = this.getEvent(this._drag_id);
                        if (t.matrix && (d = t.matrix[t._mode]), d = d || {
                                x_step: 1,
                                x_unit: "day"
                            },
                            "move" == this._drag_mode) a = this._min_date.valueOf() + 6e4 * (i.y * this.config.time_step + 24 * i.x * 60), !i.custom && this._table_view && (a += 1e3 * this.date.time_part(_.start_date)), !this._table_view && this._dragEventBody && void 0 === this._drag_event._move_event_shift && (this._drag_event._move_event_shift = a - _.start_date), this._drag_event._move_event_shift && (a -= this._drag_event._move_event_shift), a = this._correct_shift(a), i._ignores && this.config.preserve_length && this._table_view ? (a = t._correct_drag_start_date(a),
                            n = t._correct_drag_end_date(a, this._drag_event._event_length)) : n = _.end_date.valueOf() - (_.start_date.valueOf() - a);
                        else {
                            if (a = _.start_date.valueOf(), n = _.end_date.valueOf(), this._table_view) {
                                var l = this._min_date.valueOf() + i.y * this.config.time_step * 6e4 + (i.custom ? 0 : 864e5);
                                if ("month" == this._mode)
                                    if (l = this._correct_shift(l, !1), this._drag_from_start) {
                                        var h = 864e5;
                                        l <= t.date.date_part(new Date(n + h - 1)).valueOf() && (a = l - h)
                                    } else n = l;
                                else this.config.preserve_length ? i.resize_from_start ? a = t._correct_drag_start_date(l) : n = t._correct_drag_end_date(l, 0) : i.resize_from_start ? a = l : n = l
                            } else {
                                var c = this.date.date_part(new Date(_.end_date.valueOf() - 1)).valueOf(),
                                    u = new Date(c);
                                n = c + i.y * this.config.time_step * 6e4, n += 6e4 * (new Date(n).getTimezoneOffset() - u.getTimezoneOffset()), this._els.dhx_cal_data[0].style.cursor = "s-resize", "week" != this._mode && "day" != this._mode || (n = this._correct_shift(n))
                            }
                            if ("new-size" == this._drag_mode)
                                if (n <= this._drag_start) {
                                    var g = i.shift || (this._table_view && !i.custom ? 864e5 : 0);
                                    a = n - (i.shift ? 0 : g), n = this._drag_start + (g || 6e4 * this.config.time_step)
                                } else a = this._drag_start;
                            else n <= a && (n = a + 6e4 * this.config.time_step)
                        }
                        var f = new Date(n - 1),
                            v = new Date(a);
                        if ("move" == this._drag_mode && t.config.limit_drag_out && (+v < +t._min_date || +n > +t._max_date)) {
                            if (+_.start_date < +t._min_date || +_.end_date > +t._max_date) v = new Date(_.start_date), n = new Date(_.end_date);
                            else {
                                var m = n - v; + v < +t._min_date ? (v = new Date(t._min_date), i._ignores && this.config.preserve_length && this._table_view ? (v = new Date(t._correct_drag_start_date(v)), d._start_correction && (v = new Date(v.valueOf() + d._start_correction)), n = new Date(1 * v + this._get_fictional_event_length(v, this._drag_event._event_length, d))) : n = new Date(+v + m)) : (n = new Date(t._max_date), i._ignores && this.config.preserve_length && this._table_view ? (d._end_correction && (n = new Date(n.valueOf() - d._end_correction)),
                                    n = new Date(1 * n - this._get_fictional_event_length(n, 0, d, !0)), v = new Date(1 * n - this._get_fictional_event_length(n, this._drag_event._event_length, d, !0)), this._ignores_detected && (v = t.date.add(v, d.x_step, d.x_unit), n = new Date(1 * n - this._get_fictional_event_length(n, 0, d, !0)), n = t.date.add(n, d.x_step, d.x_unit))) : v = new Date(+n - m))
                            }
                            var f = new Date(n - 1)
                        }
                        if (!this._table_view && this._dragEventBody && !t.config.all_timed && (!t._get_section_view() && i.x != this._get_event_sday({
                                start_date: new Date(a),
                                end_date: new Date(a)
                            }) || new Date(a).getHours() < this.config.first_hour)) {
                            var m = n - v;
                            if ("move" == this._drag_mode) {
                                var h = this._min_date.valueOf() + 24 * i.x * 60 * 6e4;
                                v = new Date(h), v.setHours(this.config.first_hour), n = new Date(v.valueOf() + m), f = new Date(n - 1)
                            }
                        }
                        if (!this._table_view && !t.config.all_timed && (!t.getView() && i.x != this._get_event_sday({
                                start_date: new Date(n),
                                end_date: new Date(n)
                            }) || new Date(n).getHours() >= this.config.last_hour)) {
                            var m = n - v,
                                h = this._min_date.valueOf() + 24 * i.x * 60 * 6e4;
                            n = t.date.date_part(new Date(h)),
                                n.setHours(this.config.last_hour), f = new Date(n - 1), "move" == this._drag_mode && (v = new Date(+n - m))
                        }
                        if (this._table_view || f.getDate() == v.getDate() && f.getHours() < this.config.last_hour || t._allow_dnd)
                            if (_.start_date = v, _.end_date = new Date(n), this.config.update_render) {
                                var p = t._els.dhx_cal_data[0].scrollTop;
                                this.update_view(), t._els.dhx_cal_data[0].scrollTop = p
                            } else this.updateEvent(this._drag_id);
                        this._table_view && this.for_rendered(this._drag_id, function (t) {
                                t.className += " dhx_in_move dhx_cal_event_drag"
                            }),
                            this.callEvent("onEventDrag", [this._drag_id, this._drag_mode, e])
                    }
                } else if (t.checkEvent("onMouseMove")) {
                    var x = this._locate_event(e.target || e.srcElement);
                    this.callEvent("onMouseMove", [x, e])
                }
            }, t._on_mouse_down = function (e, i) {
                if (2 != e.button && !this.config.readonly && !this._drag_mode) {
                    i = i || e.target || e.srcElement;
                    var a = t._getClassName(i).split(" ")[0];
                    switch (this.config.drag_event_body && "dhx_body" == a && i.parentNode && -1 === i.parentNode.className.indexOf("dhx_cal_select_menu") && (a = "dhx_event_move",
                        this._dragEventBody = !0), a) {
                        case "dhx_cal_event_line":
                        case "dhx_cal_event_clear":
                            this._table_view && (this._drag_mode = "move");
                            break;
                        case "dhx_event_move":
                        case "dhx_wa_ev_body":
                            this._drag_mode = "move";
                            break;
                        case "dhx_event_resize":
                            this._drag_mode = "resize";
                            t._getClassName(i).indexOf("dhx_event_resize_end") < 0 ? t._drag_from_start = !0 : t._drag_from_start = !1;
                            break;
                        case "dhx_scale_holder":
                        case "dhx_scale_holder_now":
                        case "dhx_month_body":
                        case "dhx_matrix_cell":
                        case "dhx_marked_timespan":
                            this._drag_mode = "create";
                            break;
                        case "":
                            if (i.parentNode) return t._on_mouse_down(e, i.parentNode);
                            break;
                        default:
                            if ((!t.checkEvent("onMouseDown") || t.callEvent("onMouseDown", [a, e])) && i.parentNode && i != this && "dhx_body" != a) return t._on_mouse_down(e, i.parentNode);
                            this._drag_mode = null, this._drag_id = null
                    }
                    if (this._drag_mode) {
                        var n = this._locate_event(i);
                        if (this.config["drag_" + this._drag_mode] && this.callEvent("onBeforeDrag", [n, this._drag_mode, e])) {
                            if (this._drag_id = n,
                                (this._edit_id != this._drag_id || this._edit_id && "create" == this._drag_mode) && this._close_not_saved(), !this._drag_mode) return;
                            this._drag_event = t._lame_clone(this.getEvent(this._drag_id) || {}), this._drag_pos = this._mouse_coords(e)
                        } else this._drag_mode = this._drag_id = 0
                    }
                    this._drag_start = null
                }
            }, t._get_private_properties = function (t) {
                var e = {};
                for (var i in t) 0 === i.indexOf("_") && (e[i] = !0);
                return e
            }, t._clear_temporary_properties = function (t, e) {
                var i = this._get_private_properties(t),
                    a = this._get_private_properties(e);
                for (var n in a) i[n] || delete e[n]
            }, t._on_mouse_up = function (e) {
                if (!e || 2 != e.button || !this._mobile) {
                    if (this._drag_mode && this._drag_id) {
                        this._els.dhx_cal_data[0].style.cursor = "default";
                        var i = this._drag_id,
                            a = this._drag_mode,
                            n = !this._drag_pos || this._drag_pos.has_moved;
                        delete this._drag_event._move_event_shift;
                        var r = this.getEvent(this._drag_id);
                        if (n && (this._drag_event._dhx_changed || !this._drag_event.start_date || r.start_date.valueOf() != this._drag_event.start_date.valueOf() || r.end_date.valueOf() != this._drag_event.end_date.valueOf())) {
                            var s = "new-size" == this._drag_mode;
                            if (this.callEvent("onBeforeEventChanged", [r, e, s, this._drag_event]))
                                if (this._drag_id = this._drag_mode = null, s && this.config.edit_on_create) {
                                    if (this.unselect(), this._new_event = new Date,
                                        this._table_view || this.config.details_on_create || !this.config.select || !this.isOneDayEvent(this.getEvent(i))) return t.callEvent("onDragEnd", [i, a, e]), this.showLightbox(i);
                                    this._drag_pos = !0, this._select_id = this._edit_id = i
                                } else this._new_event || this.callEvent(s ? "onEventAdded" : "onEventChanged", [i, this.getEvent(i)]);
                            else s ? this.deleteEvent(r.id, !0) : (this._drag_event._dhx_changed = !1, this._clear_temporary_properties(r, this._drag_event), t._lame_copy(r, this._drag_event), this.updateEvent(r.id))
                        }
                        this._drag_pos && (this._drag_pos.has_moved || !0 === this._drag_pos) && (this._drag_id = this._drag_mode = null, this.render_view_data()), t.callEvent("onDragEnd", [i, a, e])
                    }
                    this._drag_id = null, this._drag_mode = null, this._drag_pos = null
                }
            }, t._trigger_dyn_loading = function () {
                return !(!this._load_mode || !this._load()) && (this._render_wait = !0, !0)
            }, t.update_view = function () {
                this._reset_ignores();
                var t = this[this._mode + "_view"];
                if (t ? t(!0) : this._reset_scale(), this._trigger_dyn_loading()) return !0;
                this.render_view_data()
            },
            t.isViewExists = function (e) {
                return !!(t[e + "_view"] || t.date[e + "_start"] && t.templates[e + "_date"] && t.templates[e + "_scale_date"])
            }, t._set_aria_buttons_attrs = function () {
                for (var t = ["dhx_cal_next_button", "dhx_cal_prev_button", "dhx_cal_tab", "dhx_cal_today_button"], e = 0; e < t.length; e++)
                    for (var i = this._els[t[e]], a = 0; i && a < i.length; a++) {
                        var n = i[a].getAttribute("name"),
                            r = this.locale.labels[t[e]];
                        n && (r = this.locale.labels[n] || r),
                            "dhx_cal_next_button" == t[e] ? r = this.locale.labels.next : "dhx_cal_prev_button" == t[e] && (r = this.locale.labels.prev), this._waiAria.headerButtonsAttributes(i[a], r || "")
                    }
            }, t.updateView = function (t, e) {
                t = t || this._date, e = e || this._mode;
                var i = "dhx_cal_data",
                    a = this._obj,
                    n = "dhx_scheduler_" + this._mode,
                    r = "dhx_scheduler_" + e;
                this._mode && -1 != a.className.indexOf(n) ? a.className = a.className.replace(n, r) : a.className += " " + r;
                var s, o = "dhx_multi_day",
                    d = !(this._mode != e || !this.config.preserve_scroll) && this._els[i][0].scrollTop;
                this._els[o] && this._els[o][0] && (s = this._els[o][0].scrollTop), this[this._mode + "_view"] && e && this._mode != e && this[this._mode + "_view"](!1), this._close_not_saved(), this._els[o] && (this._els[o][0].parentNode.removeChild(this._els[o][0]), this._els[o] = null), this._mode = e, this._date = t, this._table_view = "month" == this._mode, this._dy_shift = 0, this._set_aria_buttons_attrs();
                var _ = this._els.dhx_cal_tab;
                if (_)
                    for (var l = 0; l < _.length; l++) {
                        var h = _[l],
                            c = h.className;
                        c = c.replace(/ active/g, ""),
                            h.getAttribute("name") == this._mode + "_tab" ? (c += " active", this._waiAria.headerToggleState(h, !0)) : this._waiAria.headerToggleState(h, !1), h.className = c
                    }
                this.update_view(), "number" == typeof d && (this._els[i][0].scrollTop = d), "number" == typeof s && this._els[o] && this._els[o][0] && (this._els[o][0].scrollTop = s)
            }, t.setCurrentView = function (t, e) {
                this.callEvent("onBeforeViewChange", [this._mode, this._date, e || this._mode, t || this._date]) && (this.updateView(t, e), this.callEvent("onViewChange", [this._mode, this._date]))
            },
            t._render_x_header = function (t, e, i, a, n) {
                n = n || 0;
                var r = document.createElement("div");
                r.className = "dhx_scale_bar", this.templates[this._mode + "_scalex_class"] && (r.className += " " + this.templates[this._mode + "_scalex_class"](i));
                var s = this._cols[t] - 1;
                "month" == this._mode && 0 === t && this.config.left_border && (r.className += " dhx_scale_bar_border", e += 1), this.set_xy(r, s, this.xy.scale_height - 2, e, n);
                var o = this.templates[this._mode + "_scale_date"](i, this._mode);
                r.innerHTML = o, this._waiAria.dayHeaderAttr(r, o),
                    a.appendChild(r)
            }, t._get_columns_num = function (e, i) {
                var a = 7;
                if (!t._table_view) {
                    var n = t.date["get_" + t._mode + "_end"];
                    n && (i = n(e)), a = Math.round((i.valueOf() - e.valueOf()) / 864e5)
                }
                return a
            }, t._get_timeunit_start = function () {
                return this.date[this._mode + "_start"](new Date(this._date.valueOf()))
            }, t._get_view_end = function () {
                var e = this._get_timeunit_start(),
                    i = t.date.add(e, 1, this._mode);
                if (!t._table_view) {
                    var a = t.date["get_" + t._mode + "_end"];
                    a && (i = a(e))
                }
                return i
            }, t._calc_scale_sizes = function (t, e, i) {
                var a = t,
                    n = this._get_columns_num(e, i);
                this._process_ignores(e, n, "day", 1);
                for (var r = n - this._ignores_detected, s = 0; s < n; s++) this._ignores[s] ? (this._cols[s] = 0, r++) : this._cols[s] = Math.floor(a / (r - s)), a -= this._cols[s], this._colsS[s] = (this._cols[s - 1] || 0) + (this._colsS[s - 1] || (this._table_view ? 0 : this.xy.scale_width + 2));
                this._colsS.col_length = n, this._colsS[n] = this._cols[n - 1] + this._colsS[n - 1] || 0
            }, t._set_scale_col_size = function (t, e, i) {
                var a = this.config;
                this.set_xy(t, e - 1, a.hour_size_px * (a.last_hour - a.first_hour), i + this.xy.scale_width + 1, 0)
            }, t._render_scales = function (e, i) {
                var a = new Date(t._min_date),
                    n = new Date(t._max_date),
                    r = this.date.date_part(t._currentDate()),
                    s = parseInt(e.style.width, 10),
                    o = new Date(this._min_date),
                    d = this._get_columns_num(a, n);
                this._calc_scale_sizes(s, a, n);
                var _ = 0;
                e.innerHTML = "";
                for (var l = 0; l < d; l++) {
                    if (this._ignores[l] || this._render_x_header(l, _, o, e), !this._table_view) {
                        var h = document.createElement("div"),
                            c = "dhx_scale_holder";
                        o.valueOf() == r.valueOf() && (c = "dhx_scale_holder_now"), this._ignores_detected && this._ignores[l] && (c += " dhx_scale_ignore"), h.className = c + " " + this.templates.week_date_class(o, r), this._waiAria.dayColumnAttr(h, o), this._set_scale_col_size(h, this._cols[l], _), i.appendChild(h), this.callEvent("onScaleAdd", [h, o])
                    }
                    _ += this._cols[l], o = this.date.add(o, 1, "day"), o = this.date.day_start(o)
                }
            }, t._reset_scale = function () {
                if (this.templates[this._mode + "_date"]) {
                    var e = this._els.dhx_cal_header[0],
                        i = this._els.dhx_cal_data[0],
                        a = this.config;
                    e.innerHTML = "", i.innerHTML = "";
                    var n = (a.readonly || !a.drag_resize ? " dhx_resize_denied" : "") + (a.readonly || !a.drag_move ? " dhx_move_denied" : "");
                    i.className = "dhx_cal_data" + n, this._scales = {}, this._cols = [], this._colsS = {
                        height: 0
                    }, this._dy_shift = 0, this.set_sizes();
                    var r, s, o = this._get_timeunit_start(),
                        d = t._get_view_end();
                    r = s = this._table_view ? t.date.week_start(o) : o, this._min_date = r;
                    var _ = this.templates[this._mode + "_date"](o, d, this._mode);
                    if (this._els.dhx_cal_date[0].innerHTML = _, this._waiAria.navBarDateAttr(this._els.dhx_cal_date[0], _), this._max_date = d, t._render_scales(e, i), this._table_view) this._reset_month_scale(i, o, s);
                    else if (this._reset_hours_scale(i, o, s), a.multi_day) {
                        var l = "dhx_multi_day";
                        this._els[l] && (this._els[l][0].parentNode.removeChild(this._els[l][0]), this._els[l] = null);
                        var h = this._els.dhx_cal_navline[0],
                            c = h.offsetHeight + this._els.dhx_cal_header[0].offsetHeight + 1,
                            u = document.createElement("div");
                        u.className = l, u.style.visibility = "hidden", this.set_xy(u, Math.max(this._colsS[this._colsS.col_length] + this.xy.scroll_width - 2, 0), 0, 0, c), i.parentNode.insertBefore(u, i);
                        var g = u.cloneNode(!0);
                        g.className = l + "_icon", g.style.visibility = "hidden", this.set_xy(g, this.xy.scale_width, 0, 0, c), u.appendChild(g), this._els[l] = [u, g], this._els[l][0].onclick = this._click.dhx_cal_data
                    }
                }
            },
            t._reset_hours_scale = function (e, i, a) {
                var n = document.createElement("div");
                n.className = "dhx_scale_holder";
                for (var r = new Date(1980, 1, 1, this.config.first_hour, 0, 0), s = 1 * this.config.first_hour; s < this.config.last_hour; s++) {
                    var o = document.createElement("div");
                    o.className = "dhx_scale_hour", o.style.height = this.config.hour_size_px + "px";
                    var d = this.xy.scale_width;
                    this.config.left_border && (o.className += " dhx_scale_hour_border"), o.style.width = d + "px";
                    var _ = t.templates.hour_scale(r);
                    o.innerHTML = _,
                        this._waiAria.hourScaleAttr(o, _), n.appendChild(o), r = this.date.add(r, 1, "hour")
                }
                e.appendChild(n), this.config.scroll_hour && (e.scrollTop = this.config.hour_size_px * (this.config.scroll_hour - this.config.first_hour))
            }, t._currentDate = function () {
                return t.config.now_date ? new Date(t.config.now_date) : new Date
            }, t._reset_ignores = function () {
                this._ignores = {}, this._ignores_detected = 0
            }, t._process_ignores = function (e, i, a, n, r) {
                this._reset_ignores();
                var s = t["ignore_" + this._mode];
                if (s)
                    for (var o = new Date(e), d = 0; d < i; d++) s(o) && (this._ignores_detected += 1, this._ignores[d] = !0, r && i++), o = t.date.add(o, n, a), t.date[a + "_start"] && (o = t.date[a + "_start"](o))
            }, t._render_month_scale = function (e, i, a, n) {
                function r(e) {
                    var i = t._colsS.height;
                    return void 0 !== t._colsS.heights[e + 1] && (i = t._colsS.heights[e + 1] - (t._colsS.heights[e] || 0)), i
                }
                var s = t.date.add(i, 1, "month"),
                    o = new Date(a),
                    d = t._currentDate();
                this.date.date_part(d), this.date.date_part(a),
                    n = n || Math.ceil(Math.round((s.valueOf() - a.valueOf()) / 864e5) / 7);
                for (var _ = [], l = 0; l <= 7; l++) {
                    var h = (this._cols[l] || 0) - 1;
                    0 === l && this.config.left_border && (h -= 1), _[l] = h + "px"
                }
                var c = 0,
                    u = document.createElement("table");
                u.setAttribute("cellpadding", "0"), u.setAttribute("cellspacing", "0");
                var g = document.createElement("tbody");
                u.appendChild(g);
                for (var f = [], l = 0; l < n; l++) {
                    var v = document.createElement("tr");
                    g.appendChild(v);
                    for (var m = Math.max(r(l) - t.xy.month_head_height, 0), p = 0; p < 7; p++) {
                        var x = document.createElement("td");
                        v.appendChild(x);
                        var b = "";
                        a < i ? b = "dhx_before" : a >= s ? b = "dhx_after" : a.valueOf() == d.valueOf() && (b = "dhx_now"), this._ignores_detected && this._ignores[p] && (b += " dhx_scale_ignore"), x.className = b + " " + this.templates.month_date_class(a, d);
                        var y = "dhx_month_body",
                            w = "dhx_month_head";
                        if (0 === p && this.config.left_border && (y += " dhx_month_body_border", w += " dhx_month_head_border"), this._ignores_detected && this._ignores[p]) x.appendChild(document.createElement("div")),
                            x.appendChild(document.createElement("div"));
                        else {
                            this._waiAria.monthCellAttr(x, a);
                            var D = document.createElement("div");
                            D.className = w, D.innerHTML = this.templates.month_day(a), x.appendChild(D);
                            var E = document.createElement("div");
                            E.className = y, E.style.height = m + "px", E.style.width = _[p], x.appendChild(E)
                        }
                        f.push(a);
                        var A = a.getDate();
                        a = this.date.add(a, 1, "day"), a.getDate() - A > 1 && (a = new Date(a.getFullYear(), a.getMonth(), A + 1, 12, 0))
                    }
                    t._colsS.heights[l] = c, c += r(l)
                }
                this._min_date = o, this._max_date = a,
                    e.innerHTML = "", e.appendChild(u), this._scales = {};
                for (var S = e.getElementsByTagName("div"), l = 0; l < f.length; l++) {
                    var e = S[2 * l + 1],
                        k = f[l];
                    this._scales[+k] = e
                }
                for (var l = 0; l < f.length; l++) {
                    var k = f[l];
                    this.callEvent("onScaleAdd", [this._scales[+k], k])
                }
                return this._max_date
            }, t._reset_month_scale = function (e, i, a, n) {
                var r = t.date.add(i, 1, "month"),
                    s = t._currentDate();
                this.date.date_part(s), this.date.date_part(a), n = n || Math.ceil(Math.round((r.valueOf() - a.valueOf()) / 864e5) / 7);
                var o = Math.floor(e.clientHeight / n) - this.xy.month_head_height;
                return this._colsS.height = o + this.xy.month_head_height, this._colsS.heights = [], t._render_month_scale(e, i, a, n)
            }, t.getView = function (e) {
                return e || (e = t.getState().mode), t.matrix && t.matrix[e] ? t.matrix[e] : t._props && t._props[e] ? t._props[e] : null
            }, t.getLabel = function (t, e) {
                for (var i = this.config.lightbox.sections, a = 0; a < i.length; a++)
                    if (i[a].map_to == t)
                        for (var n = i[a].options, r = 0; r < n.length; r++)
                            if (n[r].key == e) return n[r].label;
                return ""
            },
            t.updateCollection = function (e, i) {
                var a = t.serverList(e);
                return !!a && (a.splice(0, a.length), a.push.apply(a, i || []), t.callEvent("onOptionsLoad", []), t.resetLightbox(), !0)
            }, t._lame_clone = function (e, i) {
                var a, n, r;
                for (i = i || [], a = 0; a < i.length; a += 2)
                    if (e === i[a]) return i[a + 1];
                if (e && "object" == typeof e) {
                    for (r = {}, n = [Array, Date, Number, String, Boolean], a = 0; a < n.length; a++) e instanceof n[a] && (r = a ? new n[a](e) : new n[a]);
                    i.push(e, r);
                    for (a in e) Object.prototype.hasOwnProperty.apply(e, [a]) && (r[a] = t._lame_clone(e[a], i))
                }
                return r || e
            }, t._lame_copy = function (t, e) {
                for (var i in e) e.hasOwnProperty(i) && (t[i] = e[i]);
                return t
            }, t._get_date_from_pos = function (t) {
                var e = this._min_date.valueOf() + 6e4 * (t.y * this.config.time_step + 24 * (this._table_view ? 0 : t.x) * 60);
                return new Date(this._correct_shift(e))
            }, t.getActionData = function (t) {
                var e = this._mouse_coords(t);
                return {
                    date: this._get_date_from_pos(e),
                    section: e.section
                }
            }, t._focus = function (t, e) {
                if (t && t.focus)
                    if (this._mobile) window.setTimeout(function () {
                        t.focus()
                    }, 10);
                    else try {
                        e && t.select && t.offsetWidth && t.select(), t.focus()
                    } catch (t) {}
            }, t._get_real_event_length = function (e, i, a) {
                var n, r = i - e,
                    s = a._start_correction + a._end_correction || 0,
                    o = this["ignore_" + this._mode],
                    d = 0;
                a.render ? (d = this._get_date_index(a, e), n = this._get_date_index(a, i)) : n = Math.round(r / 60 / 60 / 1e3 / 24);
                for (var _ = !0; d < n;) {
                    var l = t.date.add(i, -a.x_step, a.x_unit);
                    o && o(i) && (!_ || _ && o(l)) ? r -= i - l : (_ = !1, r -= s), i = l, n--
                }
                return r
            }, t._get_fictional_event_length = function (e, i, a, n) {
                var r = new Date(e),
                    s = n ? -1 : 1;
                if (a._start_correction || a._end_correction) {
                    var o;
                    o = n ? 60 * r.getHours() + r.getMinutes() - 60 * (a.first_hour || 0) : 60 * (a.last_hour || 0) - (60 * r.getHours() + r.getMinutes());
                    var d = 60 * (a.last_hour - a.first_hour),
                        _ = Math.ceil((i / 6e4 - o) / d);
                    _ < 0 && (_ = 0), i += _ * (1440 - d) * 60 * 1e3
                }
                var l, h = new Date(1 * e + i * s),
                    c = this["ignore_" + this._mode],
                    u = 0;
                for (a.render ? (u = this._get_date_index(a, r), l = this._get_date_index(a, h)) : l = Math.round(i / 60 / 60 / 1e3 / 24); u * s <= l * s;) {
                    var g = t.date.add(r, a.x_step * s, a.x_unit);
                    c && c(r) && (i += (g - r) * s, l += s), r = g, u += s
                }
                return i
            }, t._get_section_view = function () {
                return this.getView()
            }, t._get_section_property = function () {
                return this.matrix && this.matrix[this._mode] ? this.matrix[this._mode].y_property : this._props && this._props[this._mode] ? this._props[this._mode].map_to : null
            }, t._is_initialized = function () {
                var t = this.getState();
                return this._obj && t.date && t.mode
            }, t._is_lightbox_open = function () {
                var t = this.getState();
                return null !== t.lightbox_id && void 0 !== t.lightbox_id
            }, t._getClassName = function (t) {
                if (!t) return "";
                var e = t.className || "";
                return e.baseVal && (e = e.baseVal), e.indexOf || (e = ""), e || ""
            }, t.event = window.dhtmlxEvent, t.eventRemove = function (t, e, i) {
                t.removeEventListener ? t.removeEventListener(e, i, !1) : t.detachEvent && t.detachEvent("on" + e, i)
            },
            function () {
                function e(e) {
                    var i = !1,
                        a = !1;
                    if (window.getComputedStyle) {
                        var n = window.getComputedStyle(e, null);
                        i = n.display, a = n.visibility
                    } else e.currentStyle && (i = e.currentStyle.display, a = e.currentStyle.visibility);
                    var r = !1,
                        s = t._locate_css({
                            target: e
                        }, "dhx_form_repeat", !1);
                    return s && (r = !("0px" != s.style.height)), r = r || !e.offsetHeight, "none" != i && "hidden" != a && !r
                }

                function i(t) {
                    return !isNaN(t.getAttribute("tabindex")) && 1 * t.getAttribute("tabindex") >= 0
                }

                function a(t) {
                    return !{
                        a: !0,
                        area: !0
                    } [t.nodeName.loLowerCase()] || !!t.getAttribute("href")
                }

                function n(t) {
                    return !{
                        input: !0,
                        select: !0,
                        textarea: !0,
                        button: !0,
                        object: !0
                    } [t.nodeName.toLowerCase()] || !t.hasAttribute("disabled")
                }
                t._getFocusableNodes = function (t) {
                    for (var r = t.querySelectorAll(["a[href]", "area[href]", "input", "select", "textarea", "button", "iframe", "object", "embed", "[tabindex]", "[contenteditable]"].join(", ")), s = Array.prototype.slice.call(r, 0), o = 0; o < s.length; o++) {
                        var d = s[o];
                        (i(d) || n(d) || a(d)) && e(d) || (s.splice(o, 1), o--)
                    }
                    return s
                }
            }(), t._trim = function (t) {
                return (String.prototype.trim || function () {
                    return this.replace(/^\s+|\s+$/g, "")
                }).apply(t)
            }, t._isDate = function (t) {
                return !(!t || "object" != typeof t) && !!(t.getFullYear && t.getMonth && t.getDate)
            },
            t._isObject = function (t) {
                return t && "object" == typeof t
            },
            function () {
                function e(t) {
                    return (t + "").replace(n, " ").replace(r, " ")
                }

                function i(t) {
                    return (t + "").replace(s, "&#39;")
                }

                function a() {
                    return !t.config.wai_aria_attributes
                }
                var n = new RegExp("<(?:.|\n)*?>", "gm"),
                    r = new RegExp(" +", "gm"),
                    s = new RegExp("'", "gm");
                t._waiAria = {
                    getAttributeString: function (t) {
                        var a = [" "];
                        for (var n in t)
                            if ("function" != typeof t[n] && "object" != typeof t[n]) {
                                var r = i(e(t[n]));
                                a.push(n + "='" + r + "'")
                            } return a.push(" "), a.join(" ")
                    },
                    setAttributes: function (t, i) {
                        for (var a in i) t.setAttribute(a, e(i[a]));
                        return t
                    },
                    labelAttr: function (t, e) {
                        return this.setAttributes(t, {
                            "aria-label": e
                        })
                    },
                    label: function (e) {
                        return t._waiAria.getAttributeString({
                            "aria-label": e
                        })
                    },
                    hourScaleAttr: function (t, e) {
                        this.labelAttr(t, e)
                    },
                    monthCellAttr: function (e, i) {
                        this.labelAttr(e, t.templates.day_date(i))
                    },
                    navBarDateAttr: function (t, e) {
                        this.labelAttr(t, e)
                    },
                    dayHeaderAttr: function (t, e) {
                        this.labelAttr(t, e)
                    },
                    dayColumnAttr: function (e, i) {
                        this.dayHeaderAttr(e, t.templates.day_date(i))
                    },
                    headerButtonsAttributes: function (t, e) {
                        return this.setAttributes(t, {
                            role: "button",
                            "aria-label": e
                        })
                    },
                    headerToggleState: function (t, e) {
                        return this.setAttributes(t, {
                            "aria-pressed": e ? "true" : "false"
                        })
                    },
                    getHeaderCellAttr: function (e) {
                        return t._waiAria.getAttributeString({
                            "aria-label": e
                        })
                    },
                    eventAttr: function (t, e) {
                        this._eventCommonAttr(t, e)
                    },
                    _eventCommonAttr: function (i, a) {
                        a.setAttribute("aria-label", e(t.templates.event_text(i.start_date, i.end_date, i))),
                            t.config.readonly && a.setAttribute("aria-readonly", !0), i.$dataprocessor_class && a.setAttribute("aria-busy", !0), a.setAttribute("aria-selected", t.getState().select_id == i.id ? "true" : "false")
                    },
                    setEventBarAttr: function (t, e) {
                        this._eventCommonAttr(t, e)
                    },
                    _getAttributes: function (t, e) {
                        var i = {
                            setAttribute: function (t, e) {
                                this[t] = e
                            }
                        };
                        return t.apply(this, [e, i]), i
                    },
                    eventBarAttrString: function (t) {
                        return this.getAttributeString(this._getAttributes(this.setEventBarAttr, t))
                    },
                    agendaHeadAttrString: function () {
                        return this.getAttributeString({
                            role: "row"
                        })
                    },
                    agendaHeadDateString: function (t) {
                        return this.getAttributeString({
                            role: "columnheader",
                            "aria-label": t
                        })
                    },
                    agendaHeadDescriptionString: function (t) {
                        return this.agendaHeadDateString(t)
                    },
                    agendaDataAttrString: function () {
                        return this.getAttributeString({
                            role: "grid"
                        })
                    },
                    agendaEventAttrString: function (t) {
                        var e = this._getAttributes(this._eventCommonAttr, t);
                        return e.role = "row", this.getAttributeString(e)
                    },
                    agendaDetailsBtnString: function () {
                        return this.getAttributeString({
                            role: "button",
                            "aria-label": t.locale.labels.icon_details
                        })
                    },
                    gridAttrString: function () {
                        return this.getAttributeString({
                            role: "grid"
                        })
                    },
                    gridRowAttrString: function (t) {
                        return this.agendaEventAttrString(t)
                    },
                    gridCellAttrString: function (t, e, i) {
                        return this.getAttributeString({
                            role: "gridcell",
                            "aria-label": [void 0 === e.label ? e.id : e.label, ": ", i]
                        })
                    },
                    mapAttrString: function () {
                        return this.gridAttrString()
                    },
                    mapRowAttrString: function (t) {
                        return this.gridRowAttrString(t)
                    },
                    mapDetailsBtnString: function () {
                        return this.agendaDetailsBtnString()
                    },
                    minicalHeader: function (t, e) {
                        this.setAttributes(t, {
                            id: e + "",
                            "aria-live": "assertice",
                            "aria-atomic": "true"
                        })
                    },
                    minicalGrid: function (t, e) {
                        this.setAttributes(t, {
                            "aria-labelledby": e + "",
                            role: "grid"
                        })
                    },
                    minicalRow: function (t) {
                        this.setAttributes(t, {
                            role: "row"
                        })
                    },
                    minicalDayCell: function (e, i) {
                        var a = i.valueOf() < t._max_date.valueOf() && i.valueOf() >= t._min_date.valueOf();
                        this.setAttributes(e, {
                            role: "gridcell",
                            "aria-label": t.templates.day_date(i),
                            "aria-selected": a ? "true" : "false"
                        })
                    },
                    minicalHeadCell: function (t) {
                        this.setAttributes(t, {
                            role: "columnheader"
                        })
                    },
                    weekAgendaDayCell: function (e, i) {
                        var a = e.querySelector(".dhx_wa_scale_bar"),
                            n = e.querySelector(".dhx_wa_day_data"),
                            r = t.uid() + "";
                        this.setAttributes(a, {
                            id: r
                        }), this.setAttributes(n, {
                            "aria-labelledby": r
                        })
                    },
                    weekAgendaEvent: function (t, e) {
                        this.eventAttr(e, t)
                    },
                    lightboxHiddenAttr: function (t) {
                        t.setAttribute("aria-hidden", "true")
                    },
                    lightboxVisibleAttr: function (t) {
                        t.setAttribute("aria-hidden", "false")
                    },
                    lightboxSectionButtonAttrString: function (t) {
                        return this.getAttributeString({
                            role: "button",
                            "aria-label": t,
                            tabindex: "0"
                        })
                    },
                    yearHeader: function (t, e) {
                        this.setAttributes(t, {
                            id: e + ""
                        })
                    },
                    yearGrid: function (t, e) {
                        this.minicalGrid(t, e)
                    },
                    yearHeadCell: function (t) {
                        return this.minicalHeadCell(t)
                    },
                    yearRow: function (t) {
                        return this.minicalRow(t)
                    },
                    yearDayCell: function (t) {
                        this.setAttributes(t, {
                            role: "gridcell"
                        })
                    },
                    lightboxAttr: function (t) {
                        t.setAttribute("role", "dialog"), t.setAttribute("aria-hidden", "true"),
                            t.firstChild.setAttribute("role", "heading")
                    },
                    lightboxButtonAttrString: function (e) {
                        return this.getAttributeString({
                            role: "button",
                            "aria-label": t.locale.labels[e],
                            tabindex: "0"
                        })
                    },
                    eventMenuAttrString: function (e) {
                        return this.getAttributeString({
                            role: "button",
                            "aria-label": t.locale.labels[e]
                        })
                    },
                    lightboxHeader: function (t, e) {
                        t.setAttribute("aria-label", e)
                    },
                    lightboxSelectAttrString: function (e) {
                        var i = "";
                        switch (e) {
                            case "%Y":
                                i = t.locale.labels.year;
                                break;
                            case "%m":
                                i = t.locale.labels.month;
                                break;
                            case "%d":
                                i = t.locale.labels.day;
                                break;
                            case "%H:%i":
                                i = t.locale.labels.hour + " " + t.locale.labels.minute
                        }
                        return t._waiAria.getAttributeString({
                            "aria-label": i
                        })
                    },
                    messageButtonAttrString: function (t) {
                        return "tabindex='0' role='button' aria-label='" + t + "'"
                    },
                    messageInfoAttr: function (t) {
                        t.setAttribute("role", "alert")
                    },
                    messageModalAttr: function (t, e) {
                        t.setAttribute("role", "dialog"), e && t.setAttribute("aria-labelledby", e)
                    },
                    quickInfoAttr: function (t) {
                        t.setAttribute("role", "dialog")
                    },
                    quickInfoHeaderAttrString: function () {
                        return " role='heading' "
                    },
                    quickInfoHeader: function (t, e) {
                        t.setAttribute("aria-label", e)
                    },
                    quickInfoButtonAttrString: function (e) {
                        return t._waiAria.getAttributeString({
                            role: "button",
                            "aria-label": e,
                            tabindex: "0"
                        })
                    },
                    tooltipAttr: function (t) {
                        t.setAttribute("role", "tooltip")
                    },
                    tooltipVisibleAttr: function (t) {
                        t.setAttribute("aria-hidden", "false")
                    },
                    tooltipHiddenAttr: function (t) {
                        t.setAttribute("aria-hidden", "true")
                    }
                };
                for (var o in t._waiAria) t._waiAria[o] = function (t) {
                    return function () {
                        return a() ? " " : t.apply(this, arguments)
                    }
                }(t._waiAria[o])
            }(), t.$domHelpers = {
                getAbsoluteLeft: function (t) {
                    return this.getOffset(t).left
                },
                getAbsoluteTop: function (t) {
                    return this.getOffset(t).top
                },
                getOffsetSum: function (t) {
                    for (var e = 0, i = 0; t;) e += parseInt(t.offsetTop), i += parseInt(t.offsetLeft), t = t.offsetParent;
                    return {
                        top: e,
                        left: i
                    }
                },
                getOffsetRect: function (t) {
                    var e = t.getBoundingClientRect(),
                        i = 0,
                        a = 0;
                    if (/Mobi/.test(navigator.userAgent)) {
                        var n = document.createElement("div");
                        n.style.position = "absolute",
                            n.style.left = "0px", n.style.top = "0px", n.style.width = "1px", n.style.height = "1px", document.body.appendChild(n);
                        var r = n.getBoundingClientRect();
                        i = e.top - r.top, a = e.left - r.left, n.parentNode.removeChild(n)
                    } else {
                        var s = document.body,
                            o = document.documentElement,
                            d = window.pageYOffset || o.scrollTop || s.scrollTop,
                            _ = window.pageXOffset || o.scrollLeft || s.scrollLeft,
                            l = o.clientTop || s.clientTop || 0,
                            h = o.clientLeft || s.clientLeft || 0;
                        i = e.top + d - l, a = e.left + _ - h
                    }
                    return {
                        top: Math.round(i),
                        left: Math.round(a)
                    }
                },
                getOffset: function (t) {
                    return t.getBoundingClientRect ? this.getOffsetRect(t) : this.getOffsetSum(t)
                }
            }, t.$env = {
                isIE: navigator.userAgent.indexOf("MSIE") >= 0 || navigator.userAgent.indexOf("Trident") >= 0,
                isIE6: !window.XMLHttpRequest && navigator.userAgent.indexOf("MSIE") >= 0,
                isIE7: navigator.userAgent.indexOf("MSIE 7.0") >= 0 && navigator.userAgent.indexOf("Trident") < 0,
                isIE8: navigator.userAgent.indexOf("MSIE 8.0") >= 0 && navigator.userAgent.indexOf("Trident") >= 0,
                isOpera: navigator.userAgent.indexOf("Opera") >= 0,
                isChrome: navigator.userAgent.indexOf("Chrome") >= 0,
                isKHTML: navigator.userAgent.indexOf("Safari") >= 0 || navigator.userAgent.indexOf("Konqueror") >= 0,
                isFF: navigator.userAgent.indexOf("Firefox") >= 0,
                isIPad: navigator.userAgent.search(/iPad/gi) >= 0,
                isEdge: -1 != navigator.userAgent.indexOf("Edge")
            }, t.$ajax = {
                _obj: t,
                cache: !0,
                method: "get",
                parse: function (e) {
                    if ("string" != typeof e) return e;
                    var i;
                    return e = e.replace(/^[\s]+/, ""),
                        window.DOMParser && !t.$env.isIE ? i = (new window.DOMParser).parseFromString(e, "text/xml") : window.ActiveXObject !== window.undefined && (i = new window.ActiveXObject("Microsoft.XMLDOM"), i.async = "false", i.loadXML(e)), i
                },
                xmltop: function (t, e, i) {
                    if (void 0 === e.status || e.status < 400) {
                        var a = e.responseXML ? e.responseXML || e : this.parse(e.responseText || e);
                        if (a && null !== a.documentElement && !a.getElementsByTagName("parsererror").length) return a.getElementsByTagName(t)[0]
                    }
                    return -1 !== i && this._obj.callEvent("onLoadXMLError", ["Incorrect XML", arguments[1], i]), document.createElement("DIV")
                },
                xpath: function (e, i) {
                    if (i.nodeName || (i = i.responseXML || i), t.$env.isIE) return i.selectNodes(e) || [];
                    for (var a, n = [], r = (i.ownerDocument || i).evaluate(e, i, null, XPathResult.ANY_TYPE, null);;) {
                        if (!(a = r.iterateNext())) break;
                        n.push(a)
                    }
                    return n
                },
                query: function (t) {
                    this._call(t.method || "GET", t.url, t.data || "", t.async || !0, t.callback, null, t.headers)
                },
                get: function (t, e) {
                    this._call("GET", t, null, !0, e)
                },
                getSync: function (t) {
                    return this._call("GET", t, null, !1)
                },
                put: function (t, e, i) {
                    this._call("PUT", t, e, !0, i)
                },
                del: function (t, e, i) {
                    this._call("DELETE", t, e, !0, i)
                },
                post: function (t, e, i) {
                    1 == arguments.length ? e = "" : 2 != arguments.length || "function" != typeof e && "function" != typeof window[e] ? e = String(e) : (i = e, e = ""), this._call("POST", t, e, !0, i)
                },
                postSync: function (t, e) {
                    return e = null === e ? "" : String(e), this._call("POST", t, e, !1)
                },
                getLong: function (t, e) {
                    this._call("GET", t, null, !0, e, {
                        url: t
                    })
                },
                postLong: function (t, e, i) {
                    2 != arguments.length || "function" != typeof e && (window[e], 0) || (i = e, e = ""), this._call("POST", t, e, !0, i, {
                        url: t,
                        postData: e
                    })
                },
                _call: function (t, e, i, a, n, r, s) {
                    var o = this._obj,
                        d = window.XMLHttpRequest && !o.$env.isIE ? new XMLHttpRequest : new ActiveXObject("Microsoft.XMLHTTP"),
                        _ = null !== navigator.userAgent.match(/AppleWebKit/) && null !== navigator.userAgent.match(/Qt/) && null !== navigator.userAgent.match(/Safari/);
                    if (a && (d.onreadystatechange = function () {
                            if (4 == d.readyState || _ && 3 == d.readyState) {
                                if ((200 != d.status || "" === d.responseText) && !o.callEvent("onAjaxError", [d])) return;
                                window.setTimeout(function () {
                                    "function" == typeof n && n.apply(window, [{
                                        xmlDoc: d,
                                        filePath: e
                                    }]), r && (void 0 !== r.postData ? this.postLong(r.url, r.postData, n) : this.getLong(r.url, n)), n = null, d = null
                                }, 1)
                            }
                        }), "GET" != t || this.cache || (e += (e.indexOf("?") >= 0 ? "&" : "?") + "dhxr" + (new Date).getTime() + "=1"), d.open(t, e, a),
                        s)
                        for (var l in s) d.setRequestHeader(l, s[l]);
                    else "POST" == t.toUpperCase() || "PUT" == t || "DELETE" == t ? d.setRequestHeader("Content-Type", "application/x-www-form-urlencoded") : "GET" == t && (i = null);
                    if (d.setRequestHeader("X-Requested-With", "XMLHttpRequest"), d.send(i), !a) return {
                        xmlDoc: d,
                        filePath: e
                    }
                },
                urlSeparator: function (t) {
                    return -1 != t.indexOf("?") ? "&" : "?"
                }
            };
        var e = function (t, e) {
            for (var i = "var temp=date.match(/[a-zA-Z]+|[0-9]+/g);", a = t.match(/%[a-zA-Z]/g), n = 0; n < a.length; n++) switch (a[n]) {
                case "%j":
                case "%d":
                    i += "set[2]=temp[" + n + "]||1;";
                    break;
                case "%n":
                case "%m":
                    i += "set[1]=(temp[" + n + "]||1)-1;";
                    break;
                case "%y":
                    i += "set[0]=temp[" + n + "]*1+(temp[" + n + "]>50?1900:2000);";
                    break;
                case "%g":
                case "%G":
                case "%h":
                case "%H":
                    i += "set[3]=temp[" + n + "]||0;";
                    break;
                case "%i":
                    i += "set[4]=temp[" + n + "]||0;";
                    break;
                case "%Y":
                    i += "set[0]=temp[" + n + "]||0;";
                    break;
                case "%a":
                case "%A":
                    i += "set[3]=set[3]%12+((temp[" + n + "]||'').toLowerCase()=='am'?0:12);";
                    break;
                case "%s":
                    i += "set[5]=temp[" + n + "]||0;";
                    break;
                case "%M":
                    i += "set[1]=this.locale.date.month_short_hash[temp[" + n + "]]||0;";
                    break;
                case "%F":
                    i += "set[1]=this.locale.date.month_full_hash[temp[" + n + "]]||0;"
            }
            var r = "set[0],set[1],set[2],set[3],set[4],set[5]";
            return e && (r = " Date.UTC(" + r + ")"), new Function("date", "var set=[0,0,1,0,0,0]; " + i + " return new Date(" + r + ");")
        };
        t.date = {
                init: function () {
                    for (var e = t.locale.date.month_short, i = t.locale.date.month_short_hash = {}, a = 0; a < e.length; a++) i[e[a]] = a;
                    for (var e = t.locale.date.month_full, i = t.locale.date.month_full_hash = {}, a = 0; a < e.length; a++) i[e[a]] = a
                },
                _bind_host_object: function (e) {
                    return e.bind ? e.bind(t) : function () {
                        return e.apply(t, arguments)
                    }
                },
                date_part: function (t) {
                    var e = new Date(t);
                    return t.setHours(0), t.setMinutes(0), t.setSeconds(0), t.setMilliseconds(0), t.getHours() && (t.getDate() < e.getDate() || t.getMonth() < e.getMonth() || t.getFullYear() < e.getFullYear()) && t.setTime(t.getTime() + 36e5 * (24 - t.getHours())), t
                },
                time_part: function (t) {
                    return (t.valueOf() / 1e3 - 60 * t.getTimezoneOffset()) % 86400
                },
                week_start: function (e) {
                    var i = e.getDay();
                    return t.config.start_on_monday && (0 === i ? i = 6 : i--), this.date_part(this.add(e, -1 * i, "day"))
                },
                month_start: function (t) {
                    return t.setDate(1), this.date_part(t)
                },
                year_start: function (t) {
                    return t.setMonth(0), this.month_start(t)
                },
                day_start: function (t) {
                    return this.date_part(t)
                },
                _add_days: function (t, e) {
                    var i = new Date(t.valueOf());
                    if (i.setDate(i.getDate() + e), e == Math.round(e) && e > 0) {
                        var a = +i - +t,
                            n = a % 864e5;
                        if (n && t.getTimezoneOffset() == i.getTimezoneOffset()) {
                            var r = n / 36e5;
                            i.setTime(i.getTime() + 60 * (24 - r) * 60 * 1e3)
                        }
                    }
                    return e >= 0 && !t.getHours() && i.getHours() && (i.getDate() < t.getDate() || i.getMonth() < t.getMonth() || i.getFullYear() < t.getFullYear()) && i.setTime(i.getTime() + 36e5 * (24 - i.getHours())), i
                },
                add: function (e, i, a) {
                    var n = new Date(e.valueOf());
                    switch (a) {
                        case "day":
                            n = t.date._add_days(n, i);
                            break;
                        case "week":
                            n = t.date._add_days(n, 7 * i);
                            break;
                        case "month":
                            n.setMonth(n.getMonth() + i);
                            break;
                        case "year":
                            n.setYear(n.getFullYear() + i);
                            break;
                        case "hour":
                            n.setTime(n.getTime() + 60 * i * 60 * 1e3);
                            break;
                        case "minute":
                            n.setTime(n.getTime() + 60 * i * 1e3);
                            break;
                        default:
                            return t.date["add_" + a](e, i, a)
                    }
                    return n
                },
                to_fixed: function (t) {
                    return t < 10 ? "0" + t : t
                },
                copy: function (t) {
                    return new Date(t.valueOf())
                },
                date_to_str: function (e, i) {
                    e = e.replace(/%[a-zA-Z]/g, function (t) {
                        switch (t) {
                            case "%d":
                                return '"+this.date.to_fixed(date.getDate())+"';
                            case "%m":
                                return '"+this.date.to_fixed((date.getMonth()+1))+"';
                            case "%j":
                                return '"+date.getDate()+"';
                            case "%n":
                                return '"+(date.getMonth()+1)+"';
                            case "%y":
                                return '"+this.date.to_fixed(date.getFullYear()%100)+"';
                            case "%Y":
                                return '"+date.getFullYear()+"';
                            case "%D":
                                return '"+this.locale.date.day_short[date.getDay()]+"';
                            case "%l":
                                return '"+this.locale.date.day_full[date.getDay()]+"';
                            case "%M":
                                return '"+this.locale.date.month_short[date.getMonth()]+"';
                            case "%F":
                                return '"+this.locale.date.month_full[date.getMonth()]+"';
                            case "%h":
                                return '"+this.date.to_fixed((date.getHours()+11)%12+1)+"';
                            case "%g":
                                return '"+((date.getHours()+11)%12+1)+"';
                            case "%G":
                                return '"+date.getHours()+"';
                            case "%H":
                                return '"+this.date.to_fixed(date.getHours())+"';
                            case "%i":
                                return '"+this.date.to_fixed(date.getMinutes())+"';
                            case "%a":
                                return '"+(date.getHours()>11?"pm":"am")+"';
                            case "%A":
                                return '"+(date.getHours()>11?"PM":"AM")+"';
                            case "%s":
                                return '"+this.date.to_fixed(date.getSeconds())+"';
                            case "%W":
                                return '"+this.date.to_fixed(this.date.getISOWeek(date))+"';
                            default:
                                return t
                        }
                    }), i && (e = e.replace(/date\.get/g, "date.getUTC"));
                    var a = new Function("date", 'return "' + e + '";');
                    return t.date._bind_host_object(a)
                },
                str_to_date: function (i, a, n) {
                    var r = e(i, a),
                        s = /^[0-9]{4}(\-|\/)[0-9]{2}(\-|\/)[0-9]{2} ?(([0-9]{1,2}:[0-9]{1,2})(:[0-9]{1,2})?)?$/,
                        o = /^[0-9]{2}\/[0-9]{2}\/[0-9]{4} ?(([0-9]{1,2}:[0-9]{2})(:[0-9]{1,2})?)?$/,
                        d = /^[0-9]{2}\-[0-9]{2}\-[0-9]{4} ?(([0-9]{1,2}:[0-9]{1,2})(:[0-9]{1,2})?)?$/,
                        _ = /^([\+-]?\d{4}(?!\d{2}\b))((-?)((0[1-9]|1[0-2])(\3([12]\d|0[1-9]|3[01]))?|W([0-4]\d|5[0-2])(-?[1-7])?|(00[1-9]|0[1-9]\d|[12]\d{2}|3([0-5]\d|6[1-6])))([T\s]((([01]\d|2[0-3])((:?)[0-5]\d)?|24\:?00)([\.,]\d+(?!:))?)?(\17[0-5]\d([\.,]\d+)?)?([zZ]|([\+-])([01]\d|2[0-3]):?([0-5]\d)?)?)?)?$/,
                        l = function (t) {
                            return s.test(String(t))
                        },
                        h = function (t) {
                            return o.test(String(t))
                        },
                        c = function (t) {
                            return d.test(String(t))
                        },
                        u = function (t) {
                            return _.test(t)
                        },
                        g = e("%Y-%m-%d %H:%i:%s", a),
                        f = e("%m/%d/%Y %H:%i:%s", a),
                        v = e("%d-%m-%Y %H:%i:%s", a);
                    return function (e) {
                        if (!n && !t.config.parse_exact_format) {
                            if (e && e.getISOWeek) return new Date(e);
                            if ("number" == typeof e) return new Date(e);
                            if (l(e)) return g(e);
                            if (h(e)) return f(e);
                            if (c(e)) return v(e);
                            if (u(e)) return new Date(e)
                        }
                        return r.call(t, e)
                    }
                },
                getISOWeek: function (t) {
                    if (!t) return !1;
                    t = this.date_part(new Date(t));
                    var e = t.getDay();
                    0 === e && (e = 7);
                    var i = new Date(t.valueOf());
                    i.setDate(t.getDate() + (4 - e));
                    var a = i.getFullYear(),
                        n = Math.round((i.getTime() - new Date(a, 0, 1).getTime()) / 864e5);
                    return 1 + Math.floor(n / 7)
                },
                getUTCISOWeek: function (t) {
                    return this.getISOWeek(this.convert_to_utc(t))
                },
                convert_to_utc: function (t) {
                    return new Date(t.getUTCFullYear(), t.getUTCMonth(), t.getUTCDate(), t.getUTCHours(), t.getUTCMinutes(), t.getUTCSeconds())
                }
            }, t.locale = {
                date: {
                    month_full: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                    month_short: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    day_full: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
                    day_short: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"]
                },
                labels: {
                    dhx_cal_today_button: "Today",
                    day_tab: "Day",
                    week_tab: "Week",
                    month_tab: "Month",
                    new_event: "New event",
                    icon_save: "Save",
                    icon_cancel: "Cancel",
                    icon_details: "Details",
                    icon_edit: "Edit",
                    icon_delete: "Delete",
                    confirm_closing: "",
                    confirm_deleting: "Event will be deleted permanently, are you sure?",
                    section_description: "Description",
                    section_time: "Time period",
                    full_day: "Full day",
                    confirm_recurring: "Do you want to edit the whole set of repeated events?",
                    section_recurring: "Repeat event",
                    button_recurring: "Disabled",
                    button_recurring_open: "Enabled",
                    button_edit_series: "Edit series",
                    button_edit_occurrence: "Edit occurrence",
                    agenda_tab: "Agenda",
                    date: "Date",
                    description: "Description",
                    year_tab: "Year",
                    week_agenda_tab: "Agenda",
                    grid_tab: "Grid",
                    drag_to_create: "Drag to create",
                    drag_to_move: "Drag to move",
                    message_ok: "OK",
                    message_cancel: "Cancel",
                    next: "Next",
                    prev: "Previous",
                    year: "Year",
                    month: "Month",
                    day: "Day",
                    hour: "Hour",
                    minute: "Minute"
                }
            }, t.config = {
                default_date: "%j %M %Y",
                month_date: "%F %Y",
                load_date: "%Y-%m-%d",
                week_date: "%l",
                day_date: "%D, %F %j",
                hour_date: "%H:%i",
                month_day: "%d",
                date_format: "%Y-%m-%d %H:%i",
                api_date: "%d-%m-%Y %H:%i",
                parse_exact_format: !1,
                preserve_length: !0,
                time_step: 5,
                start_on_monday: !0,
                first_hour: 0,
                last_hour: 24,
                readonly: !1,
                drag_resize: !0,
                drag_move: !0,
                drag_create: !0,
                drag_event_body: !0,
                dblclick_create: !0,
                edit_on_create: !0,
                details_on_create: !1,
                resize_month_events: !1,
                resize_month_timed: !1,
                cascade_event_display: !1,
                cascade_event_count: 4,
                cascade_event_margin: 30,
                multi_day: !0,
                multi_day_height_limit: 0,
                drag_lightbox: !0,
                preserve_scroll: !0,
                select: !0,
                server_utc: !1,
                touch: !0,
                touch_tip: !0,
                touch_drag: 500,
                quick_info_detached: !0,
                positive_closing: !1,
                drag_highlight: !0,
                limit_drag_out: !1,
                icons_edit: ["icon_save", "icon_cancel"],
                icons_select: ["icon_details", "icon_edit", "icon_delete"],
                buttons_left: ["dhx_save_btn", "dhx_cancel_btn"],
                buttons_right: ["dhx_delete_btn"],
                lightbox: {
                    sections: [{
                        name: "description",
                        map_to: "text",
                        type: "textarea",
                        focus: !0
                    }, {
                        name: "time",
                        height: 72,
                        type: "time",
                        map_to: "auto"
                    }]
                },
                highlight_displayed_event: !0,
                left_border: !1,
                ajax_error: "alert",
                delay_render: 0,
                timeline_swap_resize: !0,
                wai_aria_attributes: !0,
                wai_aria_application_role: !0
            }, t.config.buttons_left.$inital = t.config.buttons_left.join(), t.config.buttons_right.$inital = t.config.buttons_right.join(), t._helpers = {
                parseDate: function (e) {
                    return (t.templates.xml_date || t.templates.parse_date)(e)
                },
                formatDate: function (e) {
                    return (t.templates.xml_format || t.templates.format_date)(e)
                }
            }, t.templates = {}, t.init_templates = function () {
                var e = t.locale.labels;
                e.dhx_save_btn = e.icon_save, e.dhx_cancel_btn = e.icon_cancel,
                    e.dhx_delete_btn = e.icon_delete;
                var i = t.date.date_to_str,
                    a = t.config;
                (function (t, e) {
                    for (var i in e) t[i] || (t[i] = e[i])
                })(t.templates, {
                    day_date: i(a.default_date),
                    month_date: i(a.month_date),
                    week_date: function (e, i) {
                        return t.templates.day_date(e) + " &ndash; " + t.templates.day_date(t.date.add(i, -1, "day"))
                    },
                    day_scale_date: i(a.default_date),
                    month_scale_date: i(a.week_date),
                    week_scale_date: i(a.day_date),
                    hour_scale: i(a.hour_date),
                    time_picker: i(a.hour_date),
                    event_date: i(a.hour_date),
                    month_day: i(a.month_day),
                    load_format: i(a.load_date),
                    format_date: i(a.date_format, a.server_utc),
                    parse_date: t.date.str_to_date(a.date_format, a.server_utc),
                    api_date: t.date.str_to_date(a.api_date, !1, !1),
                    event_header: function (e, i, a) {
                        return t.templates.event_date(e) + " - " + t.templates.event_date(i)
                    },
                    event_text: function (t, e, i) {
                        return i.text
                    },
                    event_class: function (t, e, i) {
                        return ""
                    },
                    month_date_class: function (t) {
                        return ""
                    },
                    week_date_class: function (t) {
                        return ""
                    },
                    event_bar_date: function (e, i, a) {
                        return t.templates.event_date(e) + " "
                    },
                    event_bar_text: function (t, e, i) {
                        return i.text
                    },
                    month_events_link: function (t, e) {
                        return "<a>View more(" + e + " events)</a>"
                    },
                    drag_marker_class: function (t, e, i) {
                        return ""
                    },
                    drag_marker_content: function (t, e, i) {
                        return ""
                    },
                    tooltip_date_format: t.date.date_to_str("%Y-%m-%d %H:%i"),
                    tooltip_text: function (e, i, a) {
                        return "<b>Event:</b> " + a.text + "<br/><b>Start date:</b> " + t.templates.tooltip_date_format(e) + "<br/><b>End date:</b> " + t.templates.tooltip_date_format(i)
                    }
                }), this.callEvent("onTemplatesReady", [])
            },
            t.uid = function () {
                return this._seed || (this._seed = (new Date).valueOf()), this._seed++
            }, t._events = {}, t.clearAll = function () {
                this._events = {}, this._loaded = {}, this._edit_id = null, this._select_id = null, this._drag_id = null, this._drag_mode = null, this._drag_pos = null, this._new_event = null, this.clear_view(), this.callEvent("onClearAll", [])
            }, t.addEvent = function (e, i, a, n, r) {
                if (!arguments.length) return this.addEventNow();
                var s = e;
                1 != arguments.length && (s = r || {}, s.start_date = e, s.end_date = i, s.text = a, s.id = n),
                    s.id = s.id || t.uid(), s.text = s.text || "", "string" == typeof s.start_date && (s.start_date = this.templates.api_date(s.start_date)), "string" == typeof s.end_date && (s.end_date = this.templates.api_date(s.end_date));
                var o = 6e4 * (this.config.event_duration || this.config.time_step);
                s.start_date.valueOf() == s.end_date.valueOf() && s.end_date.setTime(s.end_date.valueOf() + o), s._timed = this.isOneDayEvent(s);
                var d = !this._events[s.id];
                return this._events[s.id] = s, this.event_updated(s),
                    this._loading || this.callEvent(d ? "onEventAdded" : "onEventChanged", [s.id, s]), s.id
            }, t.deleteEvent = function (t, e) {
                var i = this._events[t];
                (e || this.callEvent("onBeforeEventDelete", [t, i]) && this.callEvent("onConfirmedBeforeEventDelete", [t, i])) && (i && (this._select_id = null, delete this._events[t], this.event_updated(i), this._drag_id == i.id && (this._drag_id = null, this._drag_mode = null, this._drag_pos = null)), this.callEvent("onEventDeleted", [t, i]))
            }, t.getEvent = function (t) {
                return this._events[t]
            },
            t.setEvent = function (t, e) {
                e.id || (e.id = t), this._events[t] = e
            }, t.for_rendered = function (t, e) {
                for (var i = this._rendered.length - 1; i >= 0; i--) this._rendered[i].getAttribute("event_id") == t && e(this._rendered[i], i)
            }, t.changeEventId = function (t, e) {
                if (t != e) {
                    var i = this._events[t];
                    i && (i.id = e, this._events[e] = i, delete this._events[t]), this.for_rendered(t, function (t) {
                        t.setAttribute("event_id", e)
                    }), this._select_id == t && (this._select_id = e), this._edit_id == t && (this._edit_id = e), this.callEvent("onEventIdChange", [t, e])
                }
            },
            function () {
                for (var e = ["text", "Text", "start_date", "StartDate", "end_date", "EndDate"], i = function (e) {
                        return function (i) {
                            return t.getEvent(i)[e]
                        }
                    }, a = function (e) {
                        return function (i, a) {
                            var n = t.getEvent(i);
                            n[e] = a, n._changed = !0, n._timed = this.isOneDayEvent(n), t.event_updated(n, !0)
                        }
                    }, n = 0; n < e.length; n += 2) t["getEvent" + e[n + 1]] = i(e[n]), t["setEvent" + e[n + 1]] = a(e[n])
            }(), t.event_updated = function (t, e) {
                this.is_visible_events(t) ? this.render_view_data() : this.clear_event(t.id)
            }, t.is_visible_events = function (t) {
                if (t.start_date.valueOf() < this._max_date.valueOf() && this._min_date.valueOf() < t.end_date.valueOf()) {
                    var e = t.start_date.getHours(),
                        i = t.end_date.getHours() + t.end_date.getMinutes() / 60,
                        a = this.config.last_hour,
                        n = this.config.first_hour;
                    return !(!this._table_view && (i > a || i < n) && (e >= a || e < n)) || !!((t.end_date.valueOf() - t.start_date.valueOf()) / 36e5 > 24 - (this.config.last_hour - this.config.first_hour) || e < a && i >= n)
                }
                return !1
            }, t.isOneDayEvent = function (t) {
                return t.start_date.getFullYear() === t.end_date.getFullYear() && t.start_date.getMonth() === t.end_date.getMonth() && t.start_date.getDate() === t.end_date.getDate()
            }, t.get_visible_events = function (t) {
                var e = [];
                for (var i in this._events) this.is_visible_events(this._events[i]) && (t && !this._events[i]._timed || this.filter_event(i, this._events[i]) && e.push(this._events[i]));
                return e
            }, t.filter_event = function (t, e) {
                var i = this["filter_" + this._mode];
                return !i || i(t, e)
            }, t._is_main_area_event = function (t) {
                return !!t._timed
            }, t.render_view_data = function (t, e) {
                var i = !1;
                if (!t) {
                    if (i = !0, this._not_render) return void(this._render_wait = !0);
                    this._render_wait = !1, this.clear_view(), t = this.get_visible_events(!(this._table_view || this.config.multi_day))
                }
                for (var a = 0, n = t.length; a < n; a++) this._recalculate_timed(t[a]);
                if (this.config.multi_day && !this._table_view) {
                    for (var r = [], s = [], a = 0; a < t.length; a++) this._is_main_area_event(t[a]) ? r.push(t[a]) : s.push(t[a]);
                    this._rendered_location = this._els.dhx_multi_day[0], this._table_view = !0,
                        this.render_data(s, e), this._table_view = !1, this._rendered_location = this._els.dhx_cal_data[0], this._table_view = !1, this.render_data(r, e)
                } else {
                    var o = document.createDocumentFragment(),
                        d = this._els.dhx_cal_data[0];
                    this._rendered_location = o, this.render_data(t, e), d.appendChild(o), this._rendered_location = d
                }
                i && this.callEvent("onDataRender", [])
            }, t._view_month_day = function (e) {
                var i = t.getActionData(e).date;
                t.callEvent("onViewMoreClick", [i]) && t.setCurrentView(i, "day")
            }, t._render_month_link = function (e) {
                for (var i = this._rendered_location, a = this._lame_clone(e), n = e._sday; n < e._eday; n++) {
                    a._sday = n, a._eday = n + 1;
                    var r = t.date,
                        s = t._min_date;
                    s = r.add(s, a._sweek, "week"), s = r.add(s, a._sday, "day");
                    var o = t.getEvents(s, r.add(s, 1, "day")).length,
                        d = this._get_event_bar_pos(a),
                        _ = d.x2 - d.x,
                        l = document.createElement("div");
                    l.onclick = function (e) {
                            t._view_month_day(e || event)
                        }, l.className = "dhx_month_link", l.style.top = d.y + "px", l.style.left = d.x + "px", l.style.width = _ + "px", l.innerHTML = t.templates.month_events_link(s, o),
                        this._rendered.push(l), i.appendChild(l)
                }
            }, t._recalculate_timed = function (e) {
                if (e) {
                    var i;
                    i = "object" != typeof e ? this._events[e] : e, i && (i._timed = t.isOneDayEvent(i))
                }
            }, t.attachEvent("onEventChanged", t._recalculate_timed), t.attachEvent("onEventAdded", t._recalculate_timed), t.render_data = function (e, i) {
                e = this._pre_render_events(e, i);
                for (var a = {}, n = 0; n < e.length; n++)
                    if (this._table_view)
                        if ("month" != t._mode) this.render_event_bar(e[n]);
                        else {
                            var r = t.config.max_month_events;
                            r !== 1 * r || e[n]._sorder < r ? this.render_event_bar(e[n]) : void 0 !== r && e[n]._sorder == r && t._render_month_link(e[n])
                        }
                else {
                    var s = e[n],
                        o = t.locate_holder(s._sday);
                    if (!o) continue;
                    a[s._sday] || (a[s._sday] = {
                        real: o,
                        buffer: document.createDocumentFragment(),
                        width: o.clientWidth
                    });
                    var d = a[s._sday];
                    this.render_event(s, d.buffer, d.width)
                }
                for (var n in a) {
                    var d = a[n];
                    d.real && d.buffer && d.real.appendChild(d.buffer)
                }
            }, t._get_first_visible_cell = function (t) {
                for (var e = 0; e < t.length; e++)
                    if (-1 == (t[e].className || "").indexOf("dhx_scale_ignore")) return t[e];
                return t[0]
            }, t._pre_render_events = function (e, i) {
                var a = this.xy.bar_height,
                    n = this._colsS.heights,
                    r = this._colsS.heights = [0, 0, 0, 0, 0, 0, 0],
                    s = this._els.dhx_cal_data[0];
                if (e = this._table_view ? this._pre_render_events_table(e, i) : this._pre_render_events_line(e, i), this._table_view)
                    if (i) this._colsS.heights = n;
                    else {
                        var o = s.firstChild;
                        if (o.rows) {
                            for (var d = 0; d < o.rows.length; d++) {
                                r[d]++;
                                var _ = o.rows[d].cells,
                                    l = this._colsS.height - this.xy.month_head_height;
                                if (r[d] * a > l) {
                                    var h = l;
                                    1 * this.config.max_month_events !== this.config.max_month_events || r[d] <= this.config.max_month_events ? h = r[d] * a : (this.config.max_month_events + 1) * a > l && (h = (this.config.max_month_events + 1) * a);
                                    for (var c = 0; c < _.length; c++) _[c].childNodes[1].style.height = h + "px"
                                }
                                r[d] = (r[d - 1] || 0) + t._get_first_visible_cell(_).offsetHeight
                            }
                            if (r.unshift(0),
                                o.parentNode.offsetHeight < o.parentNode.scrollHeight && !t._colsS.scroll_fix && t.xy.scroll_width) {
                                var u = t._colsS,
                                    g = u[u.col_length],
                                    f = u.heights.slice();
                                g -= t.xy.scroll_width || 0, this._calc_scale_sizes(g, this._min_date, this._max_date), t._colsS.heights = f, this.set_xy(this._els.dhx_cal_header[0], g, this.xy.scale_height), t._render_scales(this._els.dhx_cal_header[0]), t._render_month_scale(this._els.dhx_cal_data[0], this._get_timeunit_start(), this._min_date), u.scroll_fix = !0
                            }
                        } else if (e.length || "visible" != this._els.dhx_multi_day[0].style.visibility || (r[0] = -1), e.length || -1 == r[0]) {
                            var v = (o.parentNode.childNodes, (r[0] + 1) * a + 1),
                                m = v,
                                p = v + "px";
                            this.config.multi_day_height_limit && (m = Math.min(v, this.config.multi_day_height_limit), p = m + "px"), s.style.top = this._els.dhx_cal_navline[0].offsetHeight + this._els.dhx_cal_header[0].offsetHeight + m + "px", s.style.height = this._obj.offsetHeight - parseInt(s.style.top, 10) - (this.xy.margin_top || 0) + "px";
                            var x = this._els.dhx_multi_day[0];
                            x.style.height = p, x.style.visibility = -1 == r[0] ? "hidden" : "visible";
                            var b = this._els.dhx_multi_day[1];
                            b.style.height = p, b.style.visibility = -1 == r[0] ? "hidden" : "visible", b.className = r[0] ? "dhx_multi_day_icon" : "dhx_multi_day_icon_small", this._dy_shift = (r[0] + 1) * a, this.config.multi_day_height_limit && (this._dy_shift = Math.min(this.config.multi_day_height_limit, this._dy_shift)), r[0] = 0, m != v && (s.style.top = parseInt(s.style.top) + 2 + "px", x.style.overflowY = "auto", b.style.position = "fixed", b.style.top = "",
                                b.style.left = "")
                        }
                    } return e
            }, t._get_event_sday = function (t) {
                var e = this.date.day_start(new Date(t.start_date));
                return Math.round((e.valueOf() - this._min_date.valueOf()) / 864e5)
            }, t._get_event_mapped_end_date = function (t) {
                var e = t.end_date;
                if (this.config.separate_short_events) {
                    var i = (t.end_date - t.start_date) / 6e4;
                    i < this._min_mapped_duration && (e = this.date.add(e, this._min_mapped_duration - i, "minute"))
                }
                return e
            }, t._pre_render_events_line = function (t, e) {
                t.sort(function (t, e) {
                    return t.start_date.valueOf() == e.start_date.valueOf() ? t.id > e.id ? 1 : -1 : t.start_date > e.start_date ? 1 : -1
                });
                var i = [],
                    a = [];
                this._min_mapped_duration = Math.ceil(60 * this.xy.min_event_height / this.config.hour_size_px);
                for (var n = 0; n < t.length; n++) {
                    var r = t[n],
                        s = r.start_date,
                        o = r.end_date,
                        d = s.getHours(),
                        _ = o.getHours();
                    if (r._sday = this._get_event_sday(r), this._ignores[r._sday]) t.splice(n, 1), n--;
                    else {
                        if (i[r._sday] || (i[r._sday] = []), !e) {
                            r._inner = !1;
                            for (var l = i[r._sday]; l.length;) {
                                var h = l[l.length - 1],
                                    c = this._get_event_mapped_end_date(h);
                                if (!(c.valueOf() <= r.start_date.valueOf())) break;
                                l.splice(l.length - 1, 1)
                            }
                            for (var u = l.length, g = !1, f = 0; f < l.length; f++) {
                                var h = l[f],
                                    c = this._get_event_mapped_end_date(h);
                                if (c.valueOf() <= r.start_date.valueOf()) {
                                    g = !0, r._sorder = h._sorder, u = f, r._inner = !0;
                                    break
                                }
                            }
                            if (l.length && (l[l.length - 1]._inner = !0), !g)
                                if (l.length)
                                    if (l.length <= l[l.length - 1]._sorder) {
                                        if (l[l.length - 1]._sorder)
                                            for (f = 0; f < l.length; f++) {
                                                for (var v = !1, m = 0; m < l.length; m++)
                                                    if (l[m]._sorder == f) {
                                                        v = !0;
                                                        break
                                                    } if (!v) {
                                                    r._sorder = f;
                                                    break
                                                }
                                            } else r._sorder = 0;
                                        r._inner = !0
                                    } else {
                                        var p = l[0]._sorder;
                                        for (f = 1; f < l.length; f++) l[f]._sorder > p && (p = l[f]._sorder);
                                        r._sorder = p + 1, r._inner = !1
                                    }
                            else r._sorder = 0;
                            l.splice(u, u == l.length ? 0 : 1, r), l.length > (l.max_count || 0) ? (l.max_count = l.length, r._count = l.length) : r._count = r._count ? r._count : 1
                        }(d < this.config.first_hour || _ >= this.config.last_hour) && (a.push(r), t[n] = r = this._copy_event(r), d < this.config.first_hour && (r.start_date.setHours(this.config.first_hour),
                            r.start_date.setMinutes(0)), _ >= this.config.last_hour && (r.end_date.setMinutes(0), r.end_date.setHours(this.config.last_hour)), r.start_date > r.end_date || d == this.config.last_hour) && (t.splice(n, 1), n--)
                    }
                }
                if (!e) {
                    for (var n = 0; n < t.length; n++) t[n]._count = i[t[n]._sday].max_count;
                    for (var n = 0; n < a.length; n++) a[n]._count = i[a[n]._sday].max_count
                }
                return t
            }, t._time_order = function (t) {
                t.sort(function (t, e) {
                    return t.start_date.valueOf() == e.start_date.valueOf() ? t._timed && !e._timed ? 1 : !t._timed && e._timed ? -1 : t.id > e.id ? 1 : -1 : t.start_date > e.start_date ? 1 : -1
                })
            }, t._is_any_multiday_cell_visible = function (e, i, a) {
                for (var n = this._cols.length, r = !1, s = e, o = !0; s < i;) {
                    o = !1;
                    var d = this.locate_holder_day(s, !1, a),
                        _ = d % n;
                    if (!this._ignores[_]) {
                        r = !0;
                        break
                    }
                    s = t.date.add(s, 1, "day")
                }
                return o || r
            }, t._pre_render_events_table = function (e, i) {
                this._time_order(e);
                for (var a, n = [], r = [
                        [],
                        [],
                        [],
                        [],
                        [],
                        [],
                        []
                    ], s = this._colsS.heights, o = this._cols.length, d = {}, _ = 0; _ < e.length; _++) {
                    var l = e[_],
                        h = l.id;
                    d[h] || (d[h] = {
                        first_chunk: !0,
                        last_chunk: !0
                    });
                    var c = d[h],
                        u = a || l.start_date,
                        g = l.end_date;
                    u < this._min_date && (c.first_chunk = !1, u = this._min_date), g > this._max_date && (c.last_chunk = !1, g = this._max_date);
                    var f = this.locate_holder_day(u, !1, l);
                    if (l._sday = f % o, !this._ignores[l._sday] || !l._timed) {
                        var v = this.locate_holder_day(g, !0, l) || o;
                        l._eday = v % o || o, l._length = v - f,
                            l._sweek = Math.floor((this._correct_shift(u.valueOf(), 1) - this._min_date.valueOf()) / (864e5 * o));
                        if (t._is_any_multiday_cell_visible(u, g, l)) {
                            var m, p = r[l._sweek];
                            for (m = 0; m < p.length && !(p[m]._eday <= l._sday); m++);
                            if (l._sorder && i || (l._sorder = m), l._sday + l._length <= o) a = null, n.push(l), p[m] = l, s[l._sweek] = p.length - 1, l._first_chunk = c.first_chunk, l._last_chunk = c.last_chunk;
                            else {
                                var x = this._copy_event(l);
                                x.id = l.id, x._length = o - l._sday, x._eday = o, x._sday = l._sday, x._sweek = l._sweek, x._sorder = l._sorder,
                                    x.end_date = this.date.add(u, x._length, "day"), x._first_chunk = c.first_chunk, c.first_chunk && (c.first_chunk = !1), n.push(x), p[m] = x, a = x.end_date, s[l._sweek] = p.length - 1, _--
                            }
                        }
                    }
                }
                return n
            }, t._copy_dummy = function () {
                var t = new Date(this.start_date),
                    e = new Date(this.end_date);
                this.start_date = t, this.end_date = e
            }, t._copy_event = function (t) {
                return this._copy_dummy.prototype = t, new this._copy_dummy
            }, t._rendered = [], t.clear_view = function () {
                for (var t = 0; t < this._rendered.length; t++) {
                    var e = this._rendered[t];
                    e.parentNode && e.parentNode.removeChild(e)
                }
                this._rendered = []
            }, t.updateEvent = function (t) {
                var e = this.getEvent(t);
                this.clear_event(t), e && this.is_visible_events(e) && this.filter_event(t, e) && (this._table_view || this.config.multi_day || e._timed) && (this.config.update_render ? this.render_view_data() : "month" != this.getState().mode || this.getState().drag_id || this.isOneDayEvent(e) ? this.render_view_data([e], !0) : this.render_view_data())
            }, t.clear_event = function (e) {
                this.for_rendered(e, function (e, i) {
                    e.parentNode && e.parentNode.removeChild(e), t._rendered.splice(i, 1)
                })
            }, t._y_from_date = function (t) {
                var e = 60 * t.getHours() + t.getMinutes();
                return Math.round((60 * e * 1e3 - 60 * this.config.first_hour * 60 * 1e3) * this.config.hour_size_px / 36e5) % (24 * this.config.hour_size_px)
            }, t._calc_event_y = function (e, i) {
                i = i || 0;
                var a = 60 * e.start_date.getHours() + e.start_date.getMinutes(),
                    n = 60 * e.end_date.getHours() + e.end_date.getMinutes() || 60 * t.config.last_hour;
                return {
                    top: this._y_from_date(e.start_date),
                    height: Math.max(i, (n - a) * this.config.hour_size_px / 60)
                }
            }, t.render_event = function (e, i, a) {
                var n = t.xy.menu_width,
                    r = this.config.use_select_menu_space ? 0 : n;
                if (!(e._sday < 0)) {
                    var s = t.locate_holder(e._sday);
                    if (s) {
                        i = i || s;
                        var o = this._calc_event_y(e, t.xy.min_event_height),
                            d = o.top,
                            _ = o.height,
                            l = e._count || 1,
                            h = e._sorder || 0;
                        a = a || s.clientWidth;
                        var c = Math.floor((a - r) / l),
                            u = h * c + 1;
                        if (e._inner || (c *= l - h), this.config.cascade_event_display) {
                            var g = this.config.cascade_event_count,
                                f = this.config.cascade_event_margin;
                            u = h % g * f;
                            var v = e._inner ? (l - h - 1) % g * f / 2 : 0;
                            c = Math.floor(a - r - u - v)
                        }
                        var m = this._render_v_bar(e, r + u, d, c, _, e._text_style, t.templates.event_header(e.start_date, e.end_date, e), t.templates.event_text(e.start_date, e.end_date, e));
                        if (this._waiAria.eventAttr(e, m), this._rendered.push(m), i.appendChild(m), u = u + parseInt(s.style.left, 10) + r, this._edit_id == e.id) {
                            m.style.zIndex = 1, c = Math.max(c - 4, t.xy.editor_width), m = document.createElement("div"), m.setAttribute("event_id", e.id), this._waiAria.eventAttr(e, m),
                                this.set_xy(m, c, _ - 20, u, d + (t.xy.event_header_height || 14)), m.className = "dhx_cal_event dhx_cal_editor", e.color && (m.style.backgroundColor = e.color);
                            var p = t.templates.event_class(e.start_date, e.end_date, e);
                            p && (m.className += " " + p);
                            var x = document.createElement("div");
                            this.set_xy(x, c - 6, _ - 26), x.style.cssText += ";margin:2px 2px 2px 2px;overflow:hidden;", m.appendChild(x), this._els.dhx_cal_data[0].appendChild(m), this._rendered.push(m), x.innerHTML = "<textarea class='dhx_cal_editor'>" + e.text + "</textarea>",
                                this._editor = x.querySelector("textarea"), this._quirks7 && (this._editor.style.height = _ - 12 + "px"), this._editor.onkeydown = function (e) {
                                    if ((e || event).shiftKey) return !0;
                                    var i = (e || event).keyCode;
                                    i == t.keys.edit_save && t.editStop(!0), i == t.keys.edit_cancel && t.editStop(!1), i != t.keys.edit_save && i != t.keys.edit_cancel || e.preventDefault && e.preventDefault()
                                }, this._editor.onselectstart = function (t) {
                                    return (t || event).cancelBubble = !0, !0
                                }, t._focus(this._editor, !0), this._els.dhx_cal_data[0].scrollLeft = 0
                        }
                        if (0 !== this.xy.menu_width && this._select_id == e.id) {
                            this.config.cascade_event_display && this._drag_mode && (m.style.zIndex = 1);
                            for (var b, y = this.config["icons_" + (this._edit_id == e.id ? "edit" : "select")], w = "", D = e.color ? "background-color: " + e.color + ";" : "", E = e.textColor ? "color: " + e.textColor + ";" : "", A = 0; A < y.length; A++) b = this._waiAria.eventMenuAttrString(y[A]), w += "<div class='dhx_menu_icon " + y[A] + "' style='" + D + E + "' title='" + this.locale.labels[y[A]] + "'" + b + "></div>";
                            var S = this._render_v_bar(e, u - n + 1, d, n, 20 * y.length + 26 - 2, "", "<div style='" + D + E + "' class='dhx_menu_head'></div>", w, !0);
                            S.style.left = u - n + 1, this._els.dhx_cal_data[0].appendChild(S), this._rendered.push(S)
                        }
                        this.config.drag_highlight && this._drag_id == e.id && this.highlightEventPosition(e)
                    }
                }
            }, t._render_v_bar = function (e, i, a, n, r, s, o, d, _) {
                var l = document.createElement("div"),
                    h = e.id,
                    c = _ ? "dhx_cal_event dhx_cal_select_menu" : "dhx_cal_event",
                    u = t.getState();
                u.drag_id == e.id && (c += " dhx_cal_event_drag"),
                    u.select_id == e.id && (c += " dhx_cal_event_selected");
                var g = t.templates.event_class(e.start_date, e.end_date, e);
                g && (c = c + " " + g), this.config.cascade_event_display && (c += " dhx_cal_event_cascade");
                var f = e.color ? "background-color:" + e.color + ";" : "",
                    v = e.textColor ? "color:" + e.textColor + ";" : "",
                    m = t._border_box_bvents(),
                    p = n - 2,
                    x = m ? p : n - 4,
                    b = m ? p : n - 6,
                    y = m ? p : n - (this._quirks ? 4 : 14),
                    w = m ? p - 2 : n - 8,
                    D = m ? r - this.xy.event_header_height - 1 : r - (this._quirks ? 20 : 30) + 1,
                    E = '<div event_id="' + h + '" class="' + c + '" style="position:absolute; top:' + a + "px; left:" + i + "px; width:" + x + "px; height:" + r + "px;" + (s || "") + '"></div>';
                l.innerHTML = E;
                var A = l.cloneNode(!0).firstChild;
                if (!_ && t.renderEvent(A, e, n, r, o, d)) return A;
                A = l.firstChild;
                var S = '<div class="dhx_event_move dhx_header" style=" width:' + b + "px;" + f + '" >&nbsp;</div>';
                S += '<div class="dhx_event_move dhx_title" style="' + f + v + '">' + o + "</div>", S += '<div class="dhx_body" style=" width:' + y + "px; height:" + D + "px;" + f + v + '">' + d + "</div>";
                var k = "dhx_event_resize dhx_footer";
                return (_ || !1 === e._drag_resize) && (k = "dhx_resize_denied " + k), S += '<div class="' + k + '" style=" width:' + w + "px;" + (_ ? " margin-top:-1px;" : "") + f + v + '" ></div>', A.innerHTML = S, A
            }, t.renderEvent = function () {
                return !1
            },
            t.locate_holder = function (t) {
                return "day" == this._mode ? this._els.dhx_cal_data[0].firstChild : this._els.dhx_cal_data[0].childNodes[t]
            }, t.locate_holder_day = function (t, e) {
                var i = Math.floor((this._correct_shift(t, 1) - this._min_date) / 864e5);
                return e && this.date.time_part(t) && i++, i
            }, t._get_dnd_order = function (t, e, i) {
                if (!this._drag_event) return t;
                this._drag_event._orig_sorder ? t = this._drag_event._orig_sorder : this._drag_event._orig_sorder = t;
                for (var a = e * t; a + e > i;) t--, a -= e;
                return t = Math.max(t, 0)
            },
            t._get_event_bar_pos = function (e) {
                var i = this._colsS[e._sday],
                    a = this._colsS[e._eday];
                a == i && (a = this._colsS[e._eday + 1]);
                var n = this.xy.bar_height,
                    r = e._sorder;
                if (e.id == this._drag_id) {
                    var s = this._colsS.heights[e._sweek + 1] - this._colsS.heights[e._sweek] - this.xy.month_head_height;
                    r = t._get_dnd_order(r, n, s)
                }
                var o = r * n;
                return {
                    x: i,
                    x2: a,
                    y: this._colsS.heights[e._sweek] + (this._colsS.height ? this.xy.month_scale_height + 2 : 2) + o
                }
            }, t.render_event_bar = function (e) {
                var i = this._rendered_location,
                    a = this._get_event_bar_pos(e),
                    n = a.y,
                    r = a.x,
                    s = a.x2,
                    o = "";
                if (s) {
                    var d = t.config.resize_month_events && "month" == this._mode && (!e._timed || t.config.resize_month_timed),
                        _ = document.createElement("div"),
                        l = e.hasOwnProperty("_first_chunk") && e._first_chunk,
                        h = e.hasOwnProperty("_last_chunk") && e._last_chunk,
                        c = d && (e._timed || l),
                        u = d && (e._timed || h),
                        g = "dhx_cal_event_clear";
                    e._timed && !d || (g = "dhx_cal_event_line"), l && (g += " dhx_cal_event_line_start"), h && (g += " dhx_cal_event_line_end"),
                        c && (o += "<div class='dhx_event_resize dhx_event_resize_start'></div>"), u && (o += "<div class='dhx_event_resize dhx_event_resize_end'></div>");
                    var f = t.templates.event_class(e.start_date, e.end_date, e);
                    f && (g += " " + f);
                    var v = e.color ? "background:" + e.color + ";" : "",
                        m = e.textColor ? "color:" + e.textColor + ";" : "",
                        p = ["position:absolute", "top:" + n + "px", "left:" + r + "px", "width:" + (s - r - 15) + "px", m, v, e._text_style || ""].join(";"),
                        x = "<div event_id='" + e.id + "' class='" + g + "' style='" + p + "'" + this._waiAria.eventBarAttrString(e) + ">";
                    d && (x += o), "month" == t.getState().mode && (e = t.getEvent(e.id)), e._timed && (x += t.templates.event_bar_date(e.start_date, e.end_date, e)), x += t.templates.event_bar_text(e.start_date, e.end_date, e) + "</div>", x += "</div>", _.innerHTML = x, this._rendered.push(_.firstChild), i.appendChild(_.firstChild)
                }
            }, t._locate_event = function (t) {
                for (var e = null; t && !e && t.getAttribute;) e = t.getAttribute("event_id"), t = t.parentNode;
                return e
            }, t._locate_css = function (e, i, a) {
                void 0 === a && (a = !0);
                for (var n = e.target || e.srcElement, r = ""; n;) {
                    if (r = t._getClassName(n)) {
                        var s = r.indexOf(i);
                        if (s >= 0) {
                            if (!a) return n;
                            var o = 0 === s || !t._trim(r.charAt(s - 1)),
                                d = s + i.length >= r.length || !t._trim(r.charAt(s + i.length));
                            if (o && d) return n
                        }
                    }
                    n = n.parentNode
                }
                return null
            }, t.edit = function (t) {
                this._edit_id != t && (this.editStop(!1, t), this._edit_id = t, this.updateEvent(t))
            }, t.editStop = function (t, e) {
                if (!e || this._edit_id != e) {
                    var i = this.getEvent(this._edit_id);
                    i && (t && (i.text = this._editor.value), this._edit_id = null, this._editor = null, this.updateEvent(i.id),
                        this._edit_stop_event(i, t))
                }
            }, t._edit_stop_event = function (t, e) {
                this._new_event ? (e ? this.callEvent("onEventAdded", [t.id, t]) : t && this.deleteEvent(t.id, !0), this._new_event = null) : e && this.callEvent("onEventChanged", [t.id, t])
            }, t.getEvents = function (t, e) {
                var i = [];
                for (var a in this._events) {
                    var n = this._events[a];
                    n && (!t && !e || n.start_date < e && n.end_date > t) && i.push(n)
                }
                return i
            }, t.getRenderedEvent = function (e) {
                if (e) {
                    for (var i = t._rendered, a = 0; a < i.length; a++) {
                        var n = i[a];
                        if (n.getAttribute("event_id") == e) return n
                    }
                    return null
                }
            }, t.showEvent = function (e, i) {
                var a = "number" == typeof e || "string" == typeof e ? t.getEvent(e) : e;
                if (i = i || t._mode, a && (!this.checkEvent("onBeforeEventDisplay") || this.callEvent("onBeforeEventDisplay", [a, i]))) {
                    var n = t.config.scroll_hour;
                    t.config.scroll_hour = a.start_date.getHours();
                    var r = t.config.preserve_scroll;
                    t.config.preserve_scroll = !1;
                    var s = a.color,
                        o = a.textColor;
                    if (t.config.highlight_displayed_event && (a.color = t.config.displayed_event_color, a.textColor = t.config.displayed_event_text_color),
                        t.setCurrentView(new Date(a.start_date), i), a.color = s, a.textColor = o, t.config.scroll_hour = n, t.config.preserve_scroll = r, t.matrix && t.matrix[i]) {
                        var d = t.getView(),
                            _ = d.y_property,
                            l = t.getRenderedEvent(a.id);
                        if (l || (l = t.getEvent(a.id)), l) {
                            var h = d.posFromSection(l[_]),
                                c = d.posFromDate(l.start_date),
                                u = t.$container.querySelector(".dhx_timeline_data_wrapper");
                            c -= (u.offsetWidth - d.dx) / 2, h = h - u.offsetHeight / 2 + d.dy / 2, d.scrollTo({
                                left: c,
                                top: h
                            })
                        }
                    }
                    t.callEvent("onAfterEventDisplay", [a, i])
                }
            },
            t._append_drag_marker = function (e) {
                if (!e.parentNode) {
                    var i = t._els.dhx_cal_data[0],
                        a = i.lastChild,
                        n = t._getClassName(a);
                    n.indexOf("dhx_scale_holder") < 0 && a.previousSibling && (a = a.previousSibling), n = t._getClassName(a), a && 0 === n.indexOf("dhx_scale_holder") && a.appendChild(e)
                }
            }, t._update_marker_position = function (e, i) {
                var a = t._calc_event_y(i, 0);
                e.style.top = a.top + "px", e.style.height = a.height + "px"
            }, t.highlightEventPosition = function (t) {
                var e = document.createElement("div");
                e.setAttribute("event_id", t.id),
                    this._rendered.push(e), this._update_marker_position(e, t);
                var i = this.templates.drag_marker_class(t.start_date, t.end_date, t),
                    a = this.templates.drag_marker_content(t.start_date, t.end_date, t);
                e.className = "dhx_drag_marker", i && (e.className += " " + i), a && (e.innerHTML = a), this._append_drag_marker(e)
            }, t._loaded = {}, t._load = function (e, i) {
                function a(e) {
                    t.on_load(e), t.callEvent("onLoadEnd", [])
                }
                if (e = e || this._load_url) {
                    e += (-1 == e.indexOf("?") ? "?" : "&") + "timeshift=" + (new Date).getTimezoneOffset(),
                        this.config.prevent_cache && (e += "&uid=" + this.uid());
                    var n;
                    if (i = i || this._date, this._load_mode) {
                        var r = this.templates.load_format;
                        for (i = this.date[this._load_mode + "_start"](new Date(i.valueOf())); i > this._min_date;) i = this.date.add(i, -1, this._load_mode);
                        n = i;
                        for (var s = !0; n < this._max_date;) n = this.date.add(n, 1, this._load_mode), this._loaded[r(i)] && s ? i = this.date.add(i, 1, this._load_mode) : s = !1;
                        var o = n;
                        do {
                            n = o, o = this.date.add(n, -1, this._load_mode)
                        } while (o > i && this._loaded[r(o)]);
                        if (n <= i) return !1;
                        for (t.$ajax.get(e + "&from=" + r(i) + "&to=" + r(n), a); i < n;) this._loaded[r(i)] = !0, i = this.date.add(i, 1, this._load_mode)
                    } else t.$ajax.get(e, a);
                    return this.callEvent("onXLS", []), this.callEvent("onLoadStart", []), !0
                }
            }, t._parsers = {}, t._parsers.xml = {
                canParse: function (e, i) {
                    if (i.responseXML && i.responseXML.firstChild) return !0;
                    try {
                        var a = t.$ajax.parse(i.responseText),
                            n = t.$ajax.xmltop("data", a);
                        if (n && "data" === n.tagName) return !0
                    } catch (t) {}
                    return !1
                },
                parse: function (e) {
                    var i;
                    if (e.xmlDoc.responseXML || (e.xmlDoc.responseXML = t.$ajax.parse(e.xmlDoc.responseText)), i = t.$ajax.xmltop("data", e.xmlDoc), "data" != i.tagName) return null;
                    var a = i.getAttribute("dhx_security");
                    a && (window.dhtmlx && (dhtmlx.security_key = a), t.security_key = a);
                    for (var n = t.$ajax.xpath("//coll_options", e.xmlDoc), r = 0; r < n.length; r++) {
                        var s = n[r].getAttribute("for"),
                            o = t.serverList[s];
                        o || (t.serverList[s] = o = []), o.splice(0, o.length);
                        for (var d = t.$ajax.xpath(".//item", n[r]), _ = 0; _ < d.length; _++) {
                            for (var l = d[_], h = l.attributes, c = {
                                    key: d[_].getAttribute("value"),
                                    label: d[_].getAttribute("label")
                                }, u = 0; u < h.length; u++) {
                                var g = h[u];
                                "value" != g.nodeName && "label" != g.nodeName && (c[g.nodeName] = g.nodeValue)
                            }
                            o.push(c)
                        }
                    }
                    n.length && t.callEvent("onOptionsLoad", []);
                    for (var f = t.$ajax.xpath("//userdata", e.xmlDoc), r = 0; r < f.length; r++) {
                        var v = t._xmlNodeToJSON(f[r]);
                        t._userdata[v.name] = v.text
                    }
                    var m = [];
                    i = t.$ajax.xpath("//event", e.xmlDoc);
                    for (var r = 0; r < i.length; r++) {
                        var p = m[r] = t._xmlNodeToJSON(i[r]);
                        t._init_event(p)
                    }
                    return m
                }
            }, t.json = t._parsers.json = {
                canParse: function (t) {
                    if (t && "object" == typeof t) return !0;
                    if ("string" == typeof t) try {
                        var e = JSON.parse(t);
                        return "[object Object]" === Object.prototype.toString.call(e) || "[object Array]" === Object.prototype.toString.call(e)
                    } catch (t) {
                        return !1
                    }
                    return !1
                },
                parse: function (e) {
                    var i = [];
                    "string" == typeof e && (e = JSON.parse(e)), i = "[object Array]" === Object.prototype.toString.call(e) ? e : e ? e.data : [], i = i || [], e.dhx_security && (window.dhtmlx && (dhtmlx.security_key = e.dhx_security),
                        t.security_key = e.dhx_security);
                    var a = e && e.collections ? e.collections : {},
                        n = !1;
                    for (var r in a)
                        if (a.hasOwnProperty(r)) {
                            n = !0;
                            var s = a[r],
                                o = t.serverList[r];
                            o || (t.serverList[r] = o = []), o.splice(0, o.length);
                            for (var d = 0; d < s.length; d++) {
                                var _ = s[d],
                                    l = {
                                        key: _.value,
                                        label: _.label
                                    };
                                for (var h in _)
                                    if (_.hasOwnProperty(h)) {
                                        if ("value" == h || "label" == h) continue;
                                        l[h] = _[h]
                                    } o.push(l)
                            }
                        } n && t.callEvent("onOptionsLoad", []);
                    for (var c = [], u = 0; u < i.length; u++) {
                        var g = i[u];
                        t._init_event(g), c.push(g)
                    }
                    return c
                }
            },
            t.ical = t._parsers.ical = {
                canParse: function (t) {
                    return "string" == typeof t && new RegExp("^BEGIN:VCALENDAR").test(t)
                },
                parse: function (t) {
                    var e = t.match(RegExp(this.c_start + "[^\f]*" + this.c_end, ""));
                    if (e.length) {
                        e[0] = e[0].replace(/[\r\n]+ /g, ""), e[0] = e[0].replace(/[\r\n]+(?=[a-z \t])/g, " "), e[0] = e[0].replace(/\;[^:\r\n]*:/g, ":");
                        for (var i, a = [], n = RegExp("(?:" + this.e_start + ")([^\f]*?)(?:" + this.e_end + ")", "g"); null !== (i = n.exec(e));) {
                            for (var r, s = {}, o = /[^\r\n]+[\r\n]+/g; null !== (r = o.exec(i[1]));) this.parse_param(r.toString(), s);
                            s.uid && !s.id && (s.id = s.uid), a.push(s)
                        }
                        return a
                    }
                },
                parse_param: function (t, e) {
                    var i = t.indexOf(":");
                    if (-1 != i) {
                        var a = t.substr(0, i).toLowerCase(),
                            n = t.substr(i + 1).replace(/\\\,/g, ",").replace(/[\r\n]+$/, "");
                        "summary" == a ? a = "text" : "dtstart" == a ? (a = "start_date", n = this.parse_date(n, 0, 0)) : "dtend" == a && (a = "end_date", n = this.parse_date(n, 0, 0)), e[a] = n
                    }
                },
                parse_date: function (e, i, a) {
                    var n = e.split("T"),
                        r = !1;
                    n[1] && (i = n[1].substr(0, 2), a = n[1].substr(2, 2), r = !("Z" != n[1][6]));
                    var s = n[0].substr(0, 4),
                        o = parseInt(n[0].substr(4, 2), 10) - 1,
                        d = n[0].substr(6, 2);
                    return t.config.server_utc || r ? new Date(Date.UTC(s, o, d, i, a)) : new Date(s, o, d, i, a)
                },
                c_start: "BEGIN:VCALENDAR",
                e_start: "BEGIN:VEVENT",
                e_end: "END:VEVENT",
                c_end: "END:VCALENDAR"
            }, t.on_load = function (t) {
                this.callEvent("onBeforeParse", []);
                var e, i = !1,
                    a = !1;
                for (var n in this._parsers) {
                    var r = this._parsers[n];
                    if (r.canParse(t.xmlDoc.responseText, t.xmlDoc)) {
                        try {
                            var s = t.xmlDoc.responseText;
                            "xml" === n && (s = t), e = r.parse(s), e || (i = !0)
                        } catch (t) {
                            i = !0
                        }
                        a = !0;
                        break
                    }
                }
                if (!a)
                    if (this._process && this[this._process]) try {
                        e = this[this._process].parse(t.xmlDoc.responseText)
                    } catch (t) {
                        i = !0
                    } else i = !0;
                (i || t.xmlDoc.status && t.xmlDoc.status >= 400) && (this.callEvent("onLoadError", [t.xmlDoc]), e = []), this._process_loading(e), this.callEvent("onXLE", []), this.callEvent("onParse", [])
            }, t._process_loading = function (t) {
                this._loading = !0, this._not_render = !0;
                for (var e = 0; e < t.length; e++) this.callEvent("onEventLoading", [t[e]]) && this.addEvent(t[e]);
                this._not_render = !1, this._render_wait && this.render_view_data(), this._loading = !1, this._after_call && this._after_call(), this._after_call = null
            }, t._init_event = function (e) {
                e.text = e.text || e._tagvalue || "", e.start_date = t._init_date(e.start_date), e.end_date = t._init_date(e.end_date)
            }, t._init_date = function (e) {
                return e ? "string" == typeof e ? t._helpers.parseDate(e) : new Date(e) : null
            }, t.json = {}, t.json.parse = function (e) {
                var i = [];
                "string" == typeof e && (e = JSON.parse(e)), i = "[object Array]" === Object.prototype.toString.call(e) ? e : e ? e.data : [], i = i || [], e.dhx_security && (window.dhtmlx && (dhtmlx.security_key = e.dhx_security), t.security_key = e.dhx_security);
                var a = e && e.collections ? e.collections : {},
                    n = !1;
                for (var r in a)
                    if (a.hasOwnProperty(r)) {
                        n = !0;
                        var s = a[r],
                            o = t.serverList[r];
                        o || (t.serverList[r] = o = []), o.splice(0, o.length);
                        for (var d = 0; d < s.length; d++) {
                            var _ = s[d],
                                l = {
                                    key: _.value,
                                    label: _.label
                                };
                            for (var h in _)
                                if (_.hasOwnProperty(h)) {
                                    if ("value" == h || "label" == h) continue;
                                    l[h] = _[h]
                                } o.push(l)
                        }
                    } n && t.callEvent("onOptionsLoad", []);
                for (var c = [], u = 0; u < i.length; u++) {
                    var g = i[u];
                    t._init_event(g), c.push(g)
                }
                return c
            }, t.parse = function (t, e) {
                this._process = e, this.on_load({
                    xmlDoc: {
                        responseText: t
                    }
                })
            }, t.load = function (t, e) {
                "string" == typeof e && (this._process = e, e = arguments[2]), this._load_url = t, this._after_call = e, this._load(t, this._date)
            }, t.setLoadMode = function (t) {
                "all" == t && (t = ""), this._load_mode = t
            }, t.serverList = function (t, e) {
                return e ? (this.serverList[t] = e.slice(0), this.serverList[t]) : (this.serverList[t] = this.serverList[t] || [], this.serverList[t])
            }, t._userdata = {}, t._xmlNodeToJSON = function (t) {
                for (var e = {}, i = 0; i < t.attributes.length; i++) e[t.attributes[i].name] = t.attributes[i].value;
                for (var i = 0; i < t.childNodes.length; i++) {
                    var a = t.childNodes[i];
                    1 == a.nodeType && (e[a.tagName] = a.firstChild ? a.firstChild.nodeValue : "")
                }
                return e.text || (e.text = t.firstChild ? t.firstChild.nodeValue : ""), e
            }, t.attachEvent("onXLS", function () {
                if (!0 === this.config.show_loading) {
                    var t;
                    t = this.config.show_loading = document.createElement("div"), t.className = "dhx_loading", t.style.left = Math.round((this._x - 128) / 2) + "px", t.style.top = Math.round((this._y - 15) / 2) + "px", this._obj.appendChild(t)
                }
            }), t.attachEvent("onXLE", function () {
                var t = this.config.show_loading;
                t && "object" == typeof t && (t.parentNode && t.parentNode.removeChild(t), this.config.show_loading = !0)
            }), t._lightbox_controls = {}, t.formSection = function (e) {
                var i = this.config.lightbox.sections,
                    a = 0;
                for (a; a < i.length && i[a].name != e; a++);
                var n = i[a];
                t._lightbox || t.getLightbox();
                var r = document.getElementById(n.id),
                    s = r.nextSibling,
                    o = {
                        section: n,
                        header: r,
                        node: s,
                        getValue: function (e) {
                            return t.form_blocks[n.type].get_value(s, e || {}, n)
                        },
                        setValue: function (e, i) {
                            return t.form_blocks[n.type].set_value(s, e, i || {}, n)
                        }
                    },
                    d = t._lightbox_controls["get_" + n.type + "_control"];
                return d ? d(o) : o
            }, t._lightbox_controls.get_template_control = function (t) {
                return t.control = t.node, t
            },
            t._lightbox_controls.get_select_control = function (t) {
                return t.control = t.node.getElementsByTagName("select")[0], t
            }, t._lightbox_controls.get_textarea_control = function (t) {
                return t.control = t.node.getElementsByTagName("textarea")[0], t
            }, t._lightbox_controls.get_time_control = function (t) {
                return t.control = t.node.getElementsByTagName("select"), t
            }, t._lightbox_controls.defaults = {
                template: {
                    height: 30
                },
                textarea: {
                    height: 200
                },
                select: {
                    height: 23
                },
                time: {
                    height: 20
                }
            }, t.form_blocks = {
                template: {
                    render: function (e) {
                        var i = t._lightbox_controls.defaults.template,
                            a = i ? i.height : 30;
                        return "<div class='dhx_cal_ltext dhx_cal_template' style='height:" + (e.height || a || 30) + "px;'></div>"
                    },
                    set_value: function (t, e, i, a) {
                        t.innerHTML = e || ""
                    },
                    get_value: function (t, e, i) {
                        return t.innerHTML || ""
                    },
                    focus: function (t) {}
                },
                textarea: {
                    render: function (e) {
                        var i = t._lightbox_controls.defaults.textarea,
                            a = i ? i.height : 200;
                        return "<div class='dhx_cal_ltext' style='height:" + (e.height || a || "130") + "px;'><textarea></textarea></div>"
                    },
                    set_value: function (e, i, a) {
                        t.form_blocks.textarea._get_input(e).value = i || ""
                    },
                    get_value: function (e, i) {
                        return t.form_blocks.textarea._get_input(e).value
                    },
                    focus: function (e) {
                        var i = t.form_blocks.textarea._get_input(e);
                        t._focus(i, !0)
                    },
                    _get_input: function (t) {
                        return t.getElementsByTagName("textarea")[0]
                    }
                },
                select: {
                    render: function (e) {
                        for (var i = t._lightbox_controls.defaults.select, a = i ? i.height : 23, n = (e.height || a || "23") + "px", r = "<div class='dhx_cal_ltext' style='height:" + n + ";'><select style='width:100%;'>", s = 0; s < e.options.length; s++) r += "<option value='" + e.options[s].key + "'>" + e.options[s].label + "</option>";
                        return r += "</select></div>"
                    },
                    set_value: function (t, e, i, a) {
                        var n = t.firstChild;
                        !n._dhx_onchange && a.onchange && (n.onchange = a.onchange, n._dhx_onchange = !0), void 0 === e && (e = (n.options[0] || {}).value), n.value = e || ""
                    },
                    get_value: function (t, e) {
                        return t.firstChild.value
                    },
                    focus: function (e) {
                        var i = e.firstChild;
                        t._focus(i, !0)
                    }
                },
                time: {
                    render: function (e) {
                        e.time_format || (e.time_format = ["%H:%i", "%d", "%m", "%Y"]), e._time_format_order = {};
                        var i = e.time_format,
                            a = t.config,
                            n = t.date.date_part(t._currentDate()),
                            r = 1440,
                            s = 0;
                        t.config.limit_time_select && (r = 60 * a.last_hour + 1, s = 60 * a.first_hour, n.setHours(a.first_hour));
                        for (var o = "", d = 0; d < i.length; d++) {
                            var _ = i[d];
                            d > 0 && (o += " ");
                            var l = "",
                                h = "";
                            switch (_) {
                                case "%Y":
                                    l = "dhx_lightbox_year_select", e._time_format_order[3] = d;
                                    for (var c = n.getFullYear() - 5, u = 0; u < 10; u++) h += "<option value='" + (c + u) + "'>" + (c + u) + "</option>";
                                    break;
                                case "%m":
                                    l = "dhx_lightbox_month_select", e._time_format_order[2] = d;
                                    for (var u = 0; u < 12; u++) h += "<option value='" + u + "'>" + this.locale.date.month_full[u] + "</option>";
                                    break;
                                case "%d":
                                    l = "dhx_lightbox_day_select", e._time_format_order[1] = d;
                                    for (var u = 1; u < 32; u++) h += "<option value='" + u + "'>" + u + "</option>";
                                    break;
                                case "%H:%i":
                                    l = "dhx_lightbox_time_select",
                                        e._time_format_order[0] = d;
                                    var u = s,
                                        g = n.getDate();
                                    for (e._time_values = []; u < r;) {
                                        h += "<option value='" + u + "'>" + this.templates.time_picker(n) + "</option>", e._time_values.push(u), n.setTime(n.valueOf() + 60 * this.config.time_step * 1e3);
                                        u = 24 * (n.getDate() != g ? 1 : 0) * 60 + 60 * n.getHours() + n.getMinutes()
                                    }
                            }
                            if (h) {
                                var f = t._waiAria.lightboxSelectAttrString(_);
                                o += "<select class='" + l + "' " + (e.readonly ? "disabled='disabled'" : "") + f + ">" + h + "</select> "
                            }
                        }
                        var v = t._lightbox_controls.defaults.select;
                        return "<div style='height:" + ((v ? v.height : 23) || 30) + "px;padding-top:0px;font-size:inherit;' class='dhx_section_time'>" + o + "<span style='font-weight:normal; font-size:10pt;'> &nbsp;&ndash;&nbsp; </span>" + o + "</div>"
                    },
                    set_value: function (e, i, a, n) {
                        function r(t, e, i) {
                            for (var a = n._time_values, r = 60 * i.getHours() + i.getMinutes(), s = r, o = !1, d = 0; d < a.length; d++) {
                                var _ = a[d];
                                if (_ === r) {
                                    o = !0;
                                    break
                                }
                                _ < r && (s = _)
                            }
                            t[e + l[0]].value = o ? r : s, o || s || (t[e + l[0]].selectedIndex = -1), t[e + l[1]].value = i.getDate(),
                                t[e + l[2]].value = i.getMonth(), t[e + l[3]].value = i.getFullYear()
                        }
                        var s, o, d = t.config,
                            _ = e.getElementsByTagName("select"),
                            l = n._time_format_order;
                        if (d.full_day) {
                            if (!e._full_day) {
                                var h = "<label class='dhx_fullday'><input type='checkbox' name='full_day' value='true'> " + t.locale.labels.full_day + "&nbsp;</label></input>";
                                t.config.wide_form || (h = e.previousSibling.innerHTML + h), e.previousSibling.innerHTML = h, e._full_day = !0
                            }
                            var c = e.previousSibling.getElementsByTagName("input")[0];
                            c.checked = 0 === t.date.time_part(a.start_date) && 0 === t.date.time_part(a.end_date), _[l[0]].disabled = c.checked, _[l[0] + _.length / 2].disabled = c.checked, c.onclick = function () {
                                if (c.checked) {
                                    var i = {};
                                    t.form_blocks.time.get_value(e, i, n), s = t.date.date_part(i.start_date), o = t.date.date_part(i.end_date), (+o == +s || +o >= +s && (0 !== a.end_date.getHours() || 0 !== a.end_date.getMinutes())) && (o = t.date.add(o, 1, "day"))
                                } else s = null, o = null;
                                _[l[0]].disabled = c.checked, _[l[0] + _.length / 2].disabled = c.checked, r(_, 0, s || a.start_date),
                                    r(_, 4, o || a.end_date)
                            }
                        }
                        if (d.auto_end_date && d.event_duration)
                            for (var u = function () {
                                    s = new Date(_[l[3]].value, _[l[2]].value, _[l[1]].value, 0, _[l[0]].value), o = new Date(s.getTime() + 60 * t.config.event_duration * 1e3), r(_, 4, o)
                                }, g = 0; g < 4; g++) _[g].onchange = u;
                        r(_, 0, a.start_date), r(_, 4, a.end_date)
                    },
                    get_value: function (e, i, a) {
                        var n = e.getElementsByTagName("select"),
                            r = a._time_format_order;
                        if (i.start_date = new Date(n[r[3]].value, n[r[2]].value, n[r[1]].value, 0, n[r[0]].value),
                            i.end_date = new Date(n[r[3] + 4].value, n[r[2] + 4].value, n[r[1] + 4].value, 0, n[r[0] + 4].value), !n[r[3]].value || !n[r[3] + 4].value) {
                            var s = t.getEvent(t._lightbox_id);
                            s && (i.start_date = s.start_date, i.end_date = s.end_date)
                        }
                        return i.end_date <= i.start_date && (i.end_date = t.date.add(i.start_date, t.config.time_step, "minute")), {
                            start_date: new Date(i.start_date),
                            end_date: new Date(i.end_date)
                        }
                    },
                    focus: function (e) {
                        t._focus(e.getElementsByTagName("select")[0])
                    }
                }
            }, t.showCover = function (t) {
                if (t) {
                    t.style.display = "block";
                    var e = window.pageYOffset || document.body.scrollTop || document.documentElement.scrollTop,
                        i = window.pageXOffset || document.body.scrollLeft || document.documentElement.scrollLeft,
                        a = window.innerHeight || document.documentElement.clientHeight;
                    t.style.top = e ? Math.round(e + Math.max((a - t.offsetHeight) / 2, 0)) + "px" : Math.round(Math.max((a - t.offsetHeight) / 2, 0) + 9) + "px",
                        document.documentElement.scrollWidth > document.body.offsetWidth ? t.style.left = Math.round(i + (document.body.offsetWidth - t.offsetWidth) / 2) + "px" : t.style.left = Math.round((document.body.offsetWidth - t.offsetWidth) / 2) + "px"
                }
                this.show_cover()
            }, t.showLightbox = function (t) {
                if (t) {
                    if (!this.callEvent("onBeforeLightbox", [t])) return void(this._new_event && (this._new_event = null));
                    var e = this.getLightbox();
                    this.showCover(e), this._fill_lightbox(t, e), this._waiAria.lightboxVisibleAttr(e), this.callEvent("onLightbox", [t])
                }
            }, t._fill_lightbox = function (e, i) {
                var a = this.getEvent(e),
                    n = i.getElementsByTagName("span"),
                    r = [];
                if (t.templates.lightbox_header) {
                    r.push("");
                    var s = t.templates.lightbox_header(a.start_date, a.end_date, a);
                    r.push(s), n[1].innerHTML = "", n[2].innerHTML = s
                } else {
                    var o = this.templates.event_header(a.start_date, a.end_date, a),
                        d = (this.templates.event_bar_text(a.start_date, a.end_date, a) || "").substr(0, 70);
                    r.push(o), r.push(d), n[1].innerHTML = o, n[2].innerHTML = d
                }
                this._waiAria.lightboxHeader(i, r.join(" "));
                for (var _ = this.config.lightbox.sections, l = 0; l < _.length; l++) {
                    var h = _[l],
                        c = t._get_lightbox_section_node(h),
                        u = this.form_blocks[h.type],
                        g = void 0 !== a[h.map_to] ? a[h.map_to] : h.default_value;
                    u.set_value.call(this, c, g, a, h), _[l].focus && u.focus.call(this, c)
                }
                t._lightbox_id = e
            }, t._get_lightbox_section_node = function (t) {
                return document.getElementById(t.id).nextSibling
            }, t._lightbox_out = function (t) {
                for (var e = this.config.lightbox.sections, i = 0; i < e.length; i++) {
                    var a = document.getElementById(e[i].id);
                    a = a ? a.nextSibling : a;
                    var n = this.form_blocks[e[i].type],
                        r = n.get_value.call(this, a, t, e[i]);
                    "auto" != e[i].map_to && (t[e[i].map_to] = r)
                }
                return t
            }, t._empty_lightbox = function (e) {
                var i = t._lightbox_id,
                    a = this.getEvent(i);
                this.getLightbox();
                this._lame_copy(a, e), this.setEvent(a.id, a), this._edit_stop_event(a, !0), this.render_view_data()
            }, t.hide_lightbox = function (e) {
                t.endLightbox(!1, this.getLightbox())
            }, t.hideCover = function (t) {
                t && (t.style.display = "none"), this.hide_cover()
            }, t.hide_cover = function () {
                this._cover && this._cover.parentNode.removeChild(this._cover), this._cover = null
            }, t.show_cover = function () {
                if (!this._cover) {
                    this._cover = document.createElement("div"), this._cover.className = "dhx_cal_cover";
                    var t = void 0 !== document.height ? document.height : document.body.offsetHeight,
                        e = document.documentElement ? document.documentElement.scrollHeight : 0;
                    this._cover.style.height = Math.max(t, e) + "px", document.body.appendChild(this._cover)
                }
            }, t.save_lightbox = function () {
                var t = this._lightbox_out({}, this._lame_copy(this.getEvent(this._lightbox_id)));
                this.checkEvent("onEventSave") && !this.callEvent("onEventSave", [this._lightbox_id, t, this._new_event]) || (this._empty_lightbox(t), this.hide_lightbox())
            }, t.startLightbox = function (t, e) {
                this._lightbox_id = t, this._custom_lightbox = !0, this._temp_lightbox = this._lightbox, this._lightbox = e, this.showCover(e)
            }, t.endLightbox = function (e, i) {
                var i = i || t.getLightbox(),
                    a = t.getEvent(this._lightbox_id);
                a && this._edit_stop_event(a, e),
                    e && t.render_view_data(), this.hideCover(i), this._custom_lightbox && (this._lightbox = this._temp_lightbox, this._custom_lightbox = !1), this._temp_lightbox = this._lightbox_id = null, this._waiAria.lightboxHiddenAttr(i), this.callEvent("onAfterLightbox", [])
            }, t.resetLightbox = function () {
                t._lightbox && !t._custom_lightbox && t._lightbox.parentNode.removeChild(t._lightbox), t._lightbox = null
            }, t.cancel_lightbox = function () {
                this.callEvent("onEventCancel", [this._lightbox_id, this._new_event]), this.hide_lightbox()
            },
            t._init_lightbox_events = function () {
                this.getLightbox().onclick = function (e) {
                        var i = e ? e.target : event.srcElement;
                        if (i.className || (i = i.previousSibling), !(i && i.className && t._getClassName(i).indexOf("dhx_btn_set") > -1) || (i = i.querySelector("[dhx_button]"))) {
                            var a = t._getClassName(i);
                            if (i && a) switch (a) {
                                case "dhx_save_btn":
                                    t.save_lightbox();
                                    break;
                                case "dhx_delete_btn":
                                    var n = t.locale.labels.confirm_deleting;
                                    t._dhtmlx_confirm(n, t.locale.labels.title_confirm_deleting, function () {
                                        t.deleteEvent(t._lightbox_id),
                                            t._new_event = null, t.hide_lightbox()
                                    });
                                    break;
                                case "dhx_cancel_btn":
                                    t.cancel_lightbox();
                                    break;
                                default:
                                    if (i.getAttribute("dhx_button")) t.callEvent("onLightboxButton", [a, i, e]);
                                    else {
                                        var r, s, o; - 1 != a.indexOf("dhx_custom_button") && (-1 != a.indexOf("dhx_custom_button_") ? (r = i.parentNode.getAttribute("index"), o = i.parentNode.parentNode) : (r = i.getAttribute("index"), o = i.parentNode, i = i.firstChild)), r && (s = t.form_blocks[t.config.lightbox.sections[r].type], s.button_click(r, i, o, o.nextSibling))
                                    }
                            }
                        }
                    },
                    this.getLightbox().onkeydown = function (e) {
                        var i = e || window.event,
                            a = e.target || e.srcElement,
                            n = a.querySelector("[dhx_button]");
                        switch (n || (n = a.parentNode.querySelector(".dhx_custom_button, .dhx_readonly")), (e || i).keyCode) {
                            case 32:
                                if ((e || i).shiftKey) return;
                                n && n.click && n.click();
                                break;
                            case t.keys.edit_save:
                                if ((e || i).shiftKey) return;
                                n && n.click ? n.click() : t.save_lightbox();
                                break;
                            case t.keys.edit_cancel:
                                t.cancel_lightbox()
                        }
                    }
            }, t.setLightboxSize = function () {
                var e = this._lightbox;
                if (e) {
                    var i = e.childNodes[1];
                    i.style.height = "0px", i.style.height = i.scrollHeight + "px", e.style.height = i.scrollHeight + t.xy.lightbox_additional_height + "px", i.style.height = i.scrollHeight + "px"
                }
            }, t._init_dnd_events = function () {
                dhtmlxEvent(document.body, "mousemove", t._move_while_dnd), dhtmlxEvent(document.body, "mouseup", t._finish_dnd), t._init_dnd_events = function () {}
            }, t._move_while_dnd = function (e) {
                if (t._dnd_start_lb) {
                    document.dhx_unselectable || (document.body.className += " dhx_unselectable", document.dhx_unselectable = !0);
                    var i = t.getLightbox(),
                        a = e && e.target ? [e.pageX, e.pageY] : [event.clientX, event.clientY];
                    i.style.top = t._lb_start[1] + a[1] - t._dnd_start_lb[1] + "px", i.style.left = t._lb_start[0] + a[0] - t._dnd_start_lb[0] + "px"
                }
            }, t._ready_to_dnd = function (e) {
                var i = t.getLightbox();
                t._lb_start = [parseInt(i.style.left, 10), parseInt(i.style.top, 10)], t._dnd_start_lb = e && e.target ? [e.pageX, e.pageY] : [event.clientX, event.clientY]
            }, t._finish_dnd = function () {
                t._lb_start && (t._lb_start = t._dnd_start_lb = !1,
                    document.body.className = document.body.className.replace(" dhx_unselectable", ""), document.dhx_unselectable = !1)
            }, t.getLightbox = function () {
                if (!this._lightbox) {
                    var e = document.createElement("div");
                    e.className = "dhx_cal_light", t.config.wide_form && (e.className += " dhx_cal_light_wide"), t.form_blocks.recurring && (e.className += " dhx_cal_light_rec"), /msie|MSIE 6/.test(navigator.userAgent) && (e.className += " dhx_ie6"), e.style.visibility = "hidden";
                    for (var i = this._lightbox_template, a = this.config.buttons_left, n = "", r = 0; r < a.length; r++) n = this._waiAria.lightboxButtonAttrString(a[r]), i += "<div " + n + " class='dhx_btn_set dhx_left_btn_set " + a[r] + "_set'><div dhx_button='1' class='" + a[r] + "'></div><div>" + t.locale.labels[a[r]] + "</div></div>";
                    a = this.config.buttons_right;
                    for (var r = 0; r < a.length; r++) n = this._waiAria.lightboxButtonAttrString(a[r]),
                        i += "<div " + n + " class='dhx_btn_set dhx_right_btn_set " + a[r] + "_set' style='float:right;'><div dhx_button='1' class='" + a[r] + "'></div><div>" + t.locale.labels[a[r]] + "</div></div>";
                    i += "</div>", e.innerHTML = i, t.config.drag_lightbox && (e.firstChild.onmousedown = t._ready_to_dnd, e.firstChild.onselectstart = function () {
                        return !1
                    }, e.firstChild.style.cursor = "move", t._init_dnd_events()), this._waiAria.lightboxAttr(e), document.body.insertBefore(e, document.body.firstChild), this._lightbox = e;
                    var s = this.config.lightbox.sections;
                    i = "";
                    for (var r = 0; r < s.length; r++) {
                        var o = this.form_blocks[s[r].type];
                        if (o) {
                            s[r].id = "area_" + this.uid();
                            var d = "";
                            if (s[r].button) {
                                var n = t._waiAria.lightboxSectionButtonAttrString(this.locale.labels["button_" + s[r].button]);
                                d = "<div " + n + " class='dhx_custom_button' index='" + r + "'><div class='dhx_custom_button_" + s[r].button + "'></div><div>" + this.locale.labels["button_" + s[r].button] + "</div></div>"
                            }
                            this.config.wide_form && (i += "<div class='dhx_wrap_section'>");
                            var _ = this.locale.labels["section_" + s[r].name];
                            "string" != typeof _ && (_ = s[r].name), i += "<div id='" + s[r].id + "' class='dhx_cal_lsection'>" + d + "<label>" + _ + "</label></div>" + o.render.call(this, s[r]), i += "</div>"
                        }
                    }
                    for (var l = e.getElementsByTagName("div"), r = 0; r < l.length; r++) {
                        var h = l[r];
                        if ("dhx_cal_larea" == t._getClassName(h)) {
                            h.innerHTML = i;
                            break
                        }
                    }
                    t._bindLightboxLabels(s), this.setLightboxSize(), this._init_lightbox_events(this), e.style.display = "none", e.style.visibility = "visible"
                }
                return this._lightbox
            },
            t._bindLightboxLabels = function (e) {
                for (var i = 0; i < e.length; i++) {
                    var a = e[i];
                    if (a.id && document.getElementById(a.id)) {
                        for (var n = document.getElementById(a.id), r = n.querySelector("label"), s = t._get_lightbox_section_node(a); s && !s.querySelector;) s = s.nextSibling;
                        var o = !0;
                        if (s) {
                            var d = s.querySelector("input, select, textarea");
                            d && (a.inputId = d.id || "input_" + t.uid(), d.id || (d.id = a.inputId), r.setAttribute("for", a.inputId), o = !1)
                        }
                        if (o) {
                            t.form_blocks[a.type].focus && (r.onclick = function (e) {
                                return function () {
                                    var i = t.form_blocks[e.type],
                                        a = t._get_lightbox_section_node(e);
                                    i && i.focus && i.focus.call(t, a)
                                }
                            }(a))
                        }
                    }
                }
            }, t.attachEvent("onEventIdChange", function (t, e) {
                this._lightbox_id == t && (this._lightbox_id = e)
            }), t._lightbox_template = "<div class='dhx_cal_ltitle'><span class='dhx_mark'>&nbsp;</span><span class='dhx_time'></span><span class='dhx_title'></span></div><div class='dhx_cal_larea'></div>", t._init_touch_events = function () {
                if (this.config.touch && (-1 != navigator.userAgent.indexOf("Mobile") || -1 != navigator.userAgent.indexOf("iPad") || -1 != navigator.userAgent.indexOf("Android") || -1 != navigator.userAgent.indexOf("Touch")) && !window.MSStream && (this.xy.scroll_width = 0, this._mobile = !0), this.config.touch) {
                    var t = !0;
                    try {
                        document.createEvent("TouchEvent")
                    } catch (e) {
                        t = !1
                    }
                    t ? this._touch_events(["touchmove", "touchstart", "touchend"], function (t) {
                        return t.touches && t.touches.length > 1 ? null : t.touches[0] ? {
                            target: t.target,
                            pageX: t.touches[0].pageX,
                            pageY: t.touches[0].pageY,
                            clientX: t.touches[0].clientX,
                            clientY: t.touches[0].clientY
                        } : t
                    }, function () {
                        return !1
                    }) : window.PointerEvent || window.navigator.pointerEnabled ? this._touch_events(["pointermove", "pointerdown", "pointerup"], function (t) {
                        return "mouse" == t.pointerType ? null : t
                    }, function (t) {
                        return !t || "mouse" == t.pointerType
                    }) : window.navigator.msPointerEnabled && this._touch_events(["MSPointerMove", "MSPointerDown", "MSPointerUp"], function (t) {
                        return t.pointerType == t.MSPOINTER_TYPE_MOUSE ? null : t
                    }, function (t) {
                        return !t || t.pointerType == t.MSPOINTER_TYPE_MOUSE
                    })
                }
            }, t._touch_events = function (e, i, a) {
                function n(e, i, n) {
                    e.addEventListener(i, function (e) {
                        if (t._is_lightbox_open()) return !0;
                        if (!a(e)) return n(e)
                    }, {
                        passive: !1
                    })
                }

                function r(e, i, a, n) {
                    if (!e || !i) return !1;
                    for (var r = e.target; r && r != t._obj;) r = r.parentNode;
                    if (r != t._obj) return !1;
                    if (t.matrix && t.matrix[t.getState().mode]) {
                        if (t.matrix[t.getState().mode].scrollable) return !1
                    }
                    var s = Math.abs(e.pageY - i.pageY),
                        o = Math.abs(e.pageX - i.pageX);
                    return s < n && o > a && (!s || o / s > 3) && (e.pageX > i.pageX ? t._click.dhx_cal_next_button() : t._click.dhx_cal_prev_button(), !0)
                }

                function s(e) {
                    if (!a(e)) {
                        var i = t.getState().drag_mode,
                            n = !!t.matrix && t.matrix[t._mode],
                            r = t.render_view_data;
                        return "create" == i && n && (t.render_view_data = function () {
                            for (var e = t.getState().drag_id, i = t.getEvent(e), a = n.y_property, r = t.getEvents(i.start_date, i.end_date), s = 0; s < r.length; s++) r[s][a] != i[a] && (r.splice(s, 1), s--);
                            i._sorder = r.length - 1, i._count = r.length, this.render_data([i], t.getState().mode)
                        }), t._on_mouse_move(e), "create" == i && n && (t.render_view_data = r), e.preventDefault && e.preventDefault(), e.cancelBubble = !0, !1
                    }
                }

                function o(e) {
                    a(e) || (t._hide_global_tip(), h && (t._on_mouse_up(i(e || event)), t._temp_touch_block = !1), t._drag_id = null, t._drag_mode = null, t._drag_pos = null, t._pointerDragId = null, clearTimeout(l), h = u = !1, c = !0)
                }
                var d, _, l, h, c, u, g = (-1 != navigator.userAgent.indexOf("Android") && navigator.userAgent.indexOf("WebKit"), 0);
                n(document.body, e[0], function (e) {
                        if (!a(e)) {
                            var n = i(e);
                            if (n) {
                                if (h) return s(n), e.preventDefault && e.preventDefault(), e.cancelBubble = !0, t._update_global_tip(), !1;
                                if (_ = i(e), u) return _ ? void((d.target != _.target || Math.abs(d.pageX - _.pageX) > 5 || Math.abs(d.pageY - _.pageY) > 5) && (c = !0, clearTimeout(l))) : void(c = !0)
                            }
                        }
                    }), n(this._els.dhx_cal_data[0], "touchcancel", o),
                    n(this._els.dhx_cal_data[0], "contextmenu", function (t) {
                        if (!a(t)) return u ? (t && t.preventDefault && t.preventDefault(), (t || event).cancelBubble = !0, !1) : void 0
                    }), n(this._obj, e[1], function (e) {
                        if (!a(e)) {
                            t._pointerDragId = e.pointerId;
                            var n;
                            if (h = c = !1, u = !0, !(n = _ = i(e))) return void(c = !0);
                            var r = new Date;
                            if (!c && !h && r - g < 250) return t._click.dhx_cal_data(n), window.setTimeout(function () {
                                n.type = "dblclick", t._on_dbl_click(n)
                            }, 50), e.preventDefault && e.preventDefault(), e.cancelBubble = !0, t._block_next_stop = !0, !1;
                            if (g = r,
                                !c && !h && t.config.touch_drag) {
                                var s = t._locate_event(document.activeElement),
                                    o = t._locate_event(n.target),
                                    f = d ? t._locate_event(d.target) : null;
                                if (s && o && s == o && s != f) return e.preventDefault && e.preventDefault(), e.cancelBubble = !0, t._ignore_next_click = !1, t._click.dhx_cal_data(n), d = n, !1;
                                l = setTimeout(function () {
                                    h = !0;
                                    var e = d.target,
                                        i = t._getClassName(e);
                                    e && -1 != i.indexOf("dhx_body") && (e = e.previousSibling), t._on_mouse_down(d, e), t._drag_mode && "create" != t._drag_mode && t.for_rendered(t._drag_id, function (e, i) {
                                        e.style.display = "none", t._rendered.splice(i, 1)
                                    }), t.config.touch_tip && t._show_global_tip(), t.updateEvent(t._drag_id)
                                }, t.config.touch_drag), d = n
                            }
                        }
                    }), n(this._els.dhx_cal_data[0], e[2], function (e) {
                        if (!a(e)) return !h && r(d, _, 200, 100) && (t._block_next_stop = !0), h && (t._ignore_next_click = !0, setTimeout(function () {
                            t._ignore_next_click = !1
                        }, 100)), o(e), t._block_next_stop ? (t._block_next_stop = !1, e.preventDefault && e.preventDefault(), e.cancelBubble = !0, !1) : void 0
                    }), dhtmlxEvent(document.body, e[2], o)
            },
            t._show_global_tip = function () {
                t._hide_global_tip();
                var e = t._global_tip = document.createElement("div");
                e.className = "dhx_global_tip", t._update_global_tip(1), document.body.appendChild(e)
            }, t._update_global_tip = function (e) {
                var i = t._global_tip;
                if (i) {
                    var a = "";
                    if (t._drag_id && !e) {
                        var n = t.getEvent(t._drag_id);
                        n && (a = "<div>" + (n._timed ? t.templates.event_header(n.start_date, n.end_date, n) : t.templates.day_date(n.start_date, n.end_date, n)) + "</div>")
                    }
                    "create" == t._drag_mode || "new-size" == t._drag_mode ? i.innerHTML = (t.locale.labels.drag_to_create || "Drag to create") + a : i.innerHTML = (t.locale.labels.drag_to_move || "Drag to move") + a
                }
            }, t._hide_global_tip = function () {
                var e = t._global_tip;
                e && e.parentNode && (e.parentNode.removeChild(e), t._global_tip = 0)
            }, t._dp_init = function (e) {
                e._methods = ["_set_event_text_style", "", "_dp_change_event_id", "_dp_hook_delete"], this._dp_change_event_id = function (e, i) {
                        t.getEvent(e) && t.changeEventId(e, i)
                    },
                    this._dp_hook_delete = function (i, a) {
                        if (t.getEvent(i)) return a && i != a && ("true_deleted" == this.getUserData(i, e.action_param) && this.setUserData(i, e.action_param, "updated"), this.changeEventId(i, a)), this.deleteEvent(a, !0)
                    }, this.attachEvent("onEventAdded", function (t) {
                        !this._loading && this._validId(t) && e.setUpdated(t, !0, "inserted")
                    }), this.attachEvent("onConfirmedBeforeEventDelete", function (t) {
                        if (this._validId(t)) {
                            var i = e.getState(t);
                            return "inserted" == i || this._new_event ? (e.setUpdated(t, !1),
                                !0) : "deleted" != i && ("true_deleted" == i || (e.setUpdated(t, !0, "deleted"), !1))
                        }
                    }), this.attachEvent("onEventChanged", function (t) {
                        !this._loading && this._validId(t) && e.setUpdated(t, !0, "updated")
                    }), t.attachEvent("onClearAll", function () {
                        e._in_progress = {}, e._invalid = {}, e.updatedRows = [], e._waitMode = 0
                    }), e._objToJson = function (t, i, a) {
                        a = a || "", i = i || {};
                        for (var n in t) 0 !== n.indexOf("_") && (t[n] && t[n].getUTCFullYear ? i[a + n] = this.obj._helpers.formatDate(t[n]) : t[n] && "object" == typeof t[n] ? e._objToJson(t[n], i, a + n + ".") : i[a + n] = t[n]);
                        return i
                    }, e._getRowData = function (t, e) {
                        var i = this.obj.getEvent(t);
                        return this._objToJson(i)
                    }, e._clearUpdateFlag = function () {}, e.attachEvent("insertCallback", t._update_callback), e.attachEvent("updateCallback", t._update_callback), e.attachEvent("deleteCallback", function (t, e) {
                        this.obj.getEvent(e) ? (this.obj.setUserData(e, this.action_param, "true_deleted"), this.obj.deleteEvent(e)) : this.obj._add_rec_marker && this.obj._update_callback(t, e)
                    })
            }, t._validId = function (t) {
                return !0
            }, t.setUserData = function (t, e, i) {
                if (t) {
                    var a = this.getEvent(t);
                    a && (a[e] = i)
                } else this._userdata[e] = i
            }, t.getUserData = function (t, e) {
                if (t) {
                    var i = this.getEvent(t);
                    return i ? i[e] : null
                }
                return this._userdata[e]
            }, t._set_event_text_style = function (e, i) {
                if (t.getEvent(e)) {
                    this.for_rendered(e, function (t) {
                        t.style.cssText += ";" + i
                    });
                    var a = this.getEvent(e);
                    a._text_style = i, this.event_updated(a)
                }
            }, t._update_callback = function (e, i) {
                var a = t._xmlNodeToJSON(e.firstChild);
                "none" == a.rec_type && (a.rec_pattern = "none"), a.text = a.text || a._tagvalue, a.start_date = t._helpers.parseDate(a.start_date), a.end_date = t._helpers.parseDate(a.end_date), t.addEvent(a), t._add_rec_marker && t.setCurrentView()
            }, t._skin_settings = {
                fix_tab_position: [1, 0],
                use_select_menu_space: [1, 0],
                wide_form: [1, 0],
                hour_size_px: [44, 42],
                displayed_event_color: ["#ff4a4a", "ffc5ab"],
                displayed_event_text_color: ["#ffef80", "7e2727"]
            }, t._skin_xy = {
                lightbox_additional_height: [90, 50],
                nav_height: [59, 22],
                bar_height: [24, 20]
            }, t._is_material_skin = function () {
                return (t.skin + "").indexOf("material") > -1
            }, t._border_box_bvents = function () {
                return t._is_material_skin()
            }, t._configure = function (t, e, i) {
                for (var a in e) void 0 === t[a] && (t[a] = e[a][i])
            }, t._skin_init = function () {
                if (!t.skin)
                    for (var e = document.getElementsByTagName("link"), i = 0; i < e.length; i++) {
                        var a = e[i].href.match("dhtmlxscheduler_([a-z]+).css");
                        if (a) {
                            t.skin = a[1];
                            break
                        }
                    }
                var n = 0;
                if (!t.skin || "classic" !== t.skin && "glossy" !== t.skin || (n = 1), t._is_material_skin()) {
                    var r = t.config.buttons_left.$inital,
                        s = t.config.buttons_right.$inital;
                    if (r && t.config.buttons_left.slice().join() == r && s && t.config.buttons_right.slice().join() == s) {
                        var o = t.config.buttons_left.slice();
                        t.config.buttons_left = t.config.buttons_right.slice(), t.config.buttons_right = o
                    }
                    t.xy.event_header_height = 18, t.xy.menu_width = 25,
                        t.xy.week_agenda_scale_height = 35, t.xy.map_icon_width = 38, t._lightbox_controls.defaults.textarea.height = 64, t._lightbox_controls.defaults.time.height = "auto"
                }
                if (this._configure(t.config, t._skin_settings, n), this._configure(t.xy, t._skin_xy, n), "flat" === t.skin && (t.xy.scale_height = 35, t.templates.hour_scale = function (t) {
                        var e = t.getMinutes();
                        return e = e < 10 ? "0" + e : e, "<span class='dhx_scale_h'>" + t.getHours() + "</span><span class='dhx_scale_m'>&nbsp;" + e + "</span>"
                    }), !n) {
                    var d = t.config.minicalendar;
                    d && (d.padding = 14), t.templates.event_bar_date = function (e, i, a) {
                        return "• <b>" + t.templates.event_date(e) + "</b> "
                    }, t.attachEvent("onTemplatesReady", function () {
                        var e = t.date.date_to_str("%d");
                        t.templates._old_month_day || (t.templates._old_month_day = t.templates.month_day);
                        var i = t.templates._old_month_day;
                        if (t.templates.month_day = function (a) {
                                if ("month" == this._mode) {
                                    var n = e(a);
                                    return 1 == a.getDate() && (n = t.locale.date.month_full[a.getMonth()] + " " + n),
                                        +a == +t.date.date_part(this._currentDate()) && (n = t.locale.labels.dhx_cal_today_button + " " + n), n
                                }
                                return i.call(this, a)
                            }, t.config.fix_tab_position) {
                            var a = t._els.dhx_cal_navline[0].getElementsByTagName("div"),
                                n = null,
                                r = 211,
                                s = [14, 75, 136],
                                o = 14;
                            t._is_material_skin() && (s = [16, 103, 192], r = 294, o = -1);
                            for (var d = 0; d < a.length; d++) {
                                var _ = a[d],
                                    l = _.getAttribute("name");
                                if (l) {
                                    switch (_.style.right = "auto", l) {
                                        case "day_tab":
                                            _.style.left = s[0] + "px", _.className += " dhx_cal_tab_first";
                                            break;
                                        case "week_tab":
                                            _.style.left = s[1] + "px";
                                            break;
                                        case "month_tab":
                                            _.style.left = s[2] + "px", _.className += " dhx_cal_tab_last";
                                            break;
                                        default:
                                            _.style.left = r + "px", _.className += " dhx_cal_tab_standalone", r = r + o + _.offsetWidth
                                    }
                                    _.className += " " + l
                                } else 0 === (_.className || "").indexOf("dhx_minical_icon") && _.parentNode == t._els.dhx_cal_navline[0] && (n = _)
                            }
                            n && (n.style.left = r + "px")
                        }
                    }), t._skin_init = function () {}
                }
            }, window.jQuery && function (t) {
                var e = 0,
                    i = [];
                t.fn.dhx_scheduler = function (a) {
                    if ("string" != typeof a) {
                        var n = [];
                        return this.each(function () {
                            if (this && this.getAttribute)
                                if (this.getAttribute("dhxscheduler")) n.push(window[this.getAttribute("dhxscheduler")]);
                                else {
                                    var t = "scheduler";
                                    e && (t = "scheduler" + (e + 1), window[t] = Scheduler.getSchedulerInstance());
                                    var i = window[t];
                                    this.setAttribute("dhxscheduler", t);
                                    for (var r in a) "data" != r && (i.config[r] = a[r]);
                                    this.getElementsByTagName("div").length || (this.innerHTML = '<div class="dhx_cal_navline"><div class="dhx_cal_prev_button">&nbsp;</div><div class="dhx_cal_next_button">&nbsp;</div><div class="dhx_cal_today_button"></div><div class="dhx_cal_date"></div><div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div><div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div><div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div></div><div class="dhx_cal_header"></div><div class="dhx_cal_data"></div>',
                                        this.className += " dhx_cal_container"), i.init(this, i.config.date, i.config.mode), a.data && i.parse(a.data), n.push(i), e++
                                }
                        }), 1 === n.length ? n[0] : n
                    }
                    if (i[a]) return i[a].apply(this, []);
                    t.error("Method " + a + " does not exist on jQuery.dhx_scheduler")
                }
            }(jQuery),
            function () {
                function e(t, e, i) {
                    e && (t._date = e), i && (t._mode = i)
                }
                var i = t.setCurrentView,
                    a = t.updateView,
                    n = null,
                    r = null,
                    s = function (i, s) {
                        var o = this;
                        window.clearTimeout(r), window.clearTimeout(n);
                        var d = o._date,
                            _ = o._mode;
                        e(this, i, s), r = setTimeout(function () {
                            if (!o.callEvent("onBeforeViewChange", [_, d, s || o._mode, i || o._date])) return void e(o, d, _);
                            a.call(o, i, s), o.callEvent("onViewChange", [o._mode, o._date]), window.clearTimeout(n), r = 0
                        }, t.config.delay_render)
                    },
                    o = function (i, s) {
                        var o = this,
                            d = arguments;
                        e(this, i, s), window.clearTimeout(n), n = setTimeout(function () {
                            r || a.apply(o, d)
                        }, t.config.delay_render)
                    };
                t.attachEvent("onSchedulerReady", function () {
                    t.config.delay_render ? (t.setCurrentView = s, t.updateView = o) : (t.setCurrentView = i, t.updateView = a)
                })
            }();
        for (var i = 0; i < Scheduler._schedulerPlugins.length; i++) Scheduler._schedulerPlugins[i](t);
        return t._internal_id = Scheduler._seed++, Scheduler.$syncFactory && Scheduler.$syncFactory(t), t
    }, window.scheduler = Scheduler.getSchedulerInstance(), window.Scheduler = {
        plugin: scheduler.bind(Scheduler.plugin, Scheduler)
    }, dhtmlx && dhtmlx.attaches && (dhtmlx.attaches.attachScheduler = function (t, e, i, a) {
        var i = i || '<div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div><div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div><div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>',
            n = document.createElement("DIV");
        return n.id = "dhxSchedObj_" + this._genStr(12),
            n.innerHTML = '<div id="' + n.id + '" class="dhx_cal_container" style="width:100%; height:100%;"><div class="dhx_cal_navline"><div class="dhx_cal_prev_button">&nbsp;</div><div class="dhx_cal_next_button">&nbsp;</div><div class="dhx_cal_today_button"></div><div class="dhx_cal_date"></div>' + i + '</div><div class="dhx_cal_header"></div><div class="dhx_cal_data"></div></div>', document.body.appendChild(n.firstChild), this.attachObject(n.id, !1, !0), this.vs[this.av].sched = a, this.vs[this.av].schedId = n.id,
            a.setSizes = a.updateView, a.destructor = function () {}, a.init(n.id, t, e), this.vs[this._viewRestore()].sched
    })
}();
//# sourceMappingURL=sources/dhtmlxscheduler.js.map
