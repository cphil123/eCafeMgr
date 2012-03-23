<?

$base_url = $_GET['ref'];
header("Content-type: text/javascript");
echo '
var webhome = \'' . $base_url . '\';

function _goto(cnt) {
    if (cnt != \'\') {
        location.href = webhome + cnt;
    } else {
        location.href = webhome;
    }
}

function openwin(cnt) {
	window.open(webhome + cnt);
}

function goselect(val, realm, uri) {
	uris = uri.split("/");
	location.href = webhome + realm + \'/grid/\' + uris[0] + \'/\' + val + \'/\' + uris[2] + \'/\' + uris[3];
}

function setvalue(obj, val) {
    document.getElementById(obj).value = val;
}

function getvalue(obj) {
    return document.getElementById(obj).value;
}

var layerdroppeddown = false;
var layerboxdrop = null;

function _select2(txt4, id, ftxt4, fid) {
    var element = document.getElementsByName(txt4);
	for (var i = 0; i < element.length; i++) {
		element[i].value = ftxt4;
	}
	document.getElementById(id).value = fid;
    layerboxdrop.style.display = \'none\';
    layerdroppeddown = false;
}

function _select3(txt3, txt4, id, ftxt3, ftxt4, fid) {
    var element = document.getElementsByName(txt3);
	for (var i = 0; i < element.length; i++) {
		element[i].value = ftxt3;
	}
    var element = document.getElementsByName(txt4);
	for (var i = 0; i < element.length; i++) {
		element[i].value = ftxt4;
	}
    document.getElementById(id).value = fid;
    layerboxdrop.style.display = \'none\';
    layerdroppeddown = false;
}

function _select4(txt2, txt3, txt4, id, ftxt2, ftxt3, ftxt4, fid) {
    var element = document.getElementsByName(txt2);
	for (var i = 0; i < element.length; i++) {
		element[i].value = ftxt2;
	}
    var element = document.getElementsByName(txt3);
	for (var i = 0; i < element.length; i++) {
		element[i].value = ftxt3;
	}
    var element = document.getElementsByName(txt4);
	for (var i = 0; i < element.length; i++) {
		element[i].value = ftxt4;
	}
    document.getElementById(id).value = fid;
    layerboxdrop.style.display = \'none\';
    layerdroppeddown = false;
}

function _select5(txt1, txt2, txt3, txt4, id, ftxt1, ftxt2, ftxt3, ftxt4, fid) {
    var element = document.getElementsByName(txt1);
	for (var i = 0; i < element.length; i++) {
		element[i].value = ftxt1;
	}
    var element = document.getElementsByName(txt2);
	for (var i = 0; i < element.length; i++) {
		element[i].value = ftxt2;
	}
    var element = document.getElementsByName(txt3);
	for (var i = 0; i < element.length; i++) {
		element[i].value = ftxt3;
	}
    var element = document.getElementsByName(txt4);
	for (var i = 0; i < element.length; i++) {
		element[i].value = ftxt4;
	}
    document.getElementById(id).value = fid;
    layerboxdrop.style.display = \'none\';
    layerdroppeddown = false;
}

function _toggle(dropbox, undropfirst) {
    layerboxdrop = document.getElementById(dropbox);
    if (layerdroppeddown) {
        if (layerboxdrop.style.display == \'none\') {
            layerdroppeddown = true;
        } else {
            document.getElementById(dropbox).style.display = \'none\';
            layerdroppeddown = false;
        }
    } else {
        document.getElementById(dropbox).style.display = \'\';
        layerdroppeddown = true;
    }
}

function formpost(id, action) {
    var f = document.getElementById(id);
    if (isInputValid()) {
        f.action = action;
        f.submit();
    }
}

function checkThis(obj) {
	var kol = obj.cells.length - 1;
	if (obj.cells.item(kol).childNodes[0].childNodes[0].checked) {
		obj.cells.item(kol).childNodes[0].childNodes[0].checked = false;
		obj.style.background = \'#FFFFFF\';
	} else {
		obj.cells.item(kol).childNodes[0].childNodes[0].checked = true;
		obj.style.background = \'#D5FF7D\';
	}
}

function togglePanelFilter(obj) {
	var panel = document.getElementById(obj);
	var sign = document.getElementById(\'panelsign\');
	if (panel.style.display == \'none\') {
		sign.className = \'expand\';
		panel.style.display = \'\';
	} else {
		sign.className = \'collapse\';
		panel.style.display = \'none\';
	}
	return true;
}

window.onload = function() {
	for(var i = 0, l = document.getElementsByTagName(\'input\').length; i < l; i++) {
		if(document.getElementsByTagName(\'input\').item(i).type == \'text\') {
			document.getElementsByTagName(\'input\').item(i).setAttribute(\'autocomplete\', \'off\');
		};
	};
};

	';
?>