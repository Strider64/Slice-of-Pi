function hasClass(ele, cls) {
    return !!ele.className.match(new RegExp('(\\s|^)' + cls + '(\\s|$)'));
}

function addClass(ele, cls) {
    if (!hasClass(ele, cls))
        ele.className += " " + cls;
}

function removeClass(ele, cls) {
    if (hasClass(ele, cls)) {
        var reg = new RegExp('(\\s|^)' + cls + '(\\s|$)');
        ele.className = ele.className.replace(reg, ' ');
    }
}

var el = document.getElementById('sticky');

window.onscroll = function () {
    //console.log(window.pageYOffset);
    if (window.pageYOffset >= 100) {
        //console.log("True");
        addClass(el, 'navbar-fixed');
    } else {
        //console.log("False");
        removeClass(el, 'navbar-fixed');
    }
}