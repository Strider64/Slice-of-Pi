var button = document.getElementById("blogSubmitBtn");
var selectBtn = document.getElementById("selectBtn");

function serializeFormById(id) {
    function add(name, value) {
        result +=
                (result ? '&' : '') +
                encodeURIComponent(name) +
                '=' +
                encodeURIComponent(value);
    }
    var form = document.getElementById(id);
    var result = '';

    for (var i = 0, e; e = form.elements[i]; i++)
        if (e.name)
            switch (e.tagName) {
                case 'INPUT':
                switch (e.type) {
                    case 'file' :
                        // to-do, add serialization for browsers that support it
                        throw new TypeError('Cannot Serialize a <input type="file">');
                    case 'checkbox':
                    case 'radio':
                        if (!e.checked)
                            continue;
                }
                case 'BUTTON':
                case 'TEXTAREA':
                    add(e.name, e.value);
                    break;
                case 'SELECT':
                    add(e.name, e.options[e.selectedIndex].value);
            }

    return result;
}

function displayBlog(url, formData, callback) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 2) {
            //console.log(xhr.status);
        }
        if (xhr.readyState == 4 && xhr.status == 200) {
            //console.log(xhr.readyState);
            callback(xhr.responseText);
        }
    }; // End of Ready State:
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.send(formData);
}

function generateHTML(json) {
    var status = json[0];
    json.shift();
    var ajaxPostings = document.getElementById("ajaxPostings");
    for (var i = 0; i < json.length; i++) {

        /* Create article element */
        var article = document.createElement('article');
        var cmsClass = document.createAttribute('class');
        cmsClass.value = 'cms';
        article.setAttributeNode(cmsClass);
        ajaxPostings.appendChild(article); // Append it to main div element with id of blogPostings:
        /* Create a h2 heading element */
        var h2 = document.createElement('h2');
        h2.textContent = json[i].heading;
        article.appendChild(h2); // Append it article element:
        /* Create a h3 heading Element */
        var h3 = document.createElement('h3');
        h3.textContent = 'Created on ' + json[i].date_added + " by " + json[i].author;
        article.appendChild(h3);

        var figure = document.createElement('figure');
        var figureClass = document.createAttribute('class');
        figureClass.value = 'imageStyle';
        figure.setAttributeNode(figureClass);
        article.appendChild(figure);
        var img = document.createElement('img');
        var src = document.createAttribute('src');
        src.value = json[i].image_path;
        img.setAttributeNode(src);
        figure.appendChild(img);

        p = document.createElement('p');
        p.textContent = json[i].content;
        article.appendChild(p);
        if (status) {
            var div = document.createElement('div');
            var systemClass = document.createAttribute('class');
            systemClass.value = 'system';
            div.setAttributeNode(systemClass);
            article.appendChild(div);

            var a = document.createElement('a');
            var deleteClass = document.createAttribute('class');
            deleteClass.value = 'delete';
            a.setAttributeNode(deleteClass);
            var href = document.createAttribute('href');
            href.value = 'delete_page.php?id=' + encodeURI(json[i].id);
            a.setAttributeNode(href);
            a.textContent = "Delete";
            div.appendChild(a);

            var a = document.createElement('a');
            var editClass = document.createAttribute('class');
            editClass.value = 'edit';
            a.setAttributeNode(editClass);
            var href = document.createAttribute('href');
            href.value = 'edit/' + encodeURI(json[i].id);
            a.setAttributeNode(href);
            a.textContent = "Edit";
            div.appendChild(a);
        } else {

        }
    }
}

/*
 * Display Initial Blog 
 */
function ajaxCall(onlineStatus) {
    removeElementsByClass('cms');
    var url = 'select_user.php';
    var myData = 'user_id=' + onlineStatus + '&submit=submit'; // id might be different on a different website:
    displayBlog(url, myData, function (result) {

        var json = JSON.parse(result);
        console.log(json);
        if (json.status === "empty") {
            console.log("It's empty!");
            window.location.replace("members_page.php");
        } else {
            generateHTML(json);
        }

    });

}

document.getElementById('blogPostings').style.display = 'none';
document.getElementById('ajaxPostings').style.display = "block";
var onlineStatus = document.getElementById('website').getAttribute('data-bind');
console.log('id', onlineStatus);

ajaxCall(onlineStatus);



/*
 * Display Blog that user selects
 */
function selectUser() {
    removeElementsByClass('cms');
    var url = 'select_user.php';
    var form_data = serializeFormById('selectBlog');
    displayBlog(url, form_data, function (result) {
        //console.log(result);
        var json = JSON.parse(result);
        generateHTML(json)
    });
}

function removeElementsByClass(className) {
    var elements = document.getElementsByClassName(className);
    while (elements.length > 0) {
        elements[0].parentNode.removeChild(elements[0]);
    }
}

if (selectBtn !== null) {
    button.style['display'] = 'none';
    selectBtn.addEventListener("mouseleave", function (event) {
        event.preventDefault();
        selectUser();
    }); // End of addEventListener Function: 
}

var eraseable = document.getElementsByClassName("eraseable");

for (var i = 0; i < eraseable.length; i++) {
    eraseable[i].addEventListener('click', delFunction, false); //bind delFunction on click to eraseables
}

function delFunction() {
    var msg = confirm("Are you sure?");
    if (msg == true) {
        this.remove(); //remove the clicked element if confirmed
    }
}