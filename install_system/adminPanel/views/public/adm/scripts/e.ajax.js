/**
 * 
 * @param {string} url - адрес
 * @param {object} data - Данные для сервера
 * @param {function} funSuccess - функция вызывается при успехе
 * @param {function} funError  - функция вызывается при ошибке
 * @param {object} element - элемент инициатор
 */
function ajaxAction(url, data, funSuccess, funError, element) {
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(data)
    })
        .then(response => {
            if (response.ok) {
                response.text().then(d => {
                    funSuccess(d);
                });
            } else {
                response.text().then(d => {
                    funError();
                });
            }
            if (element && data.href) {
                element.setAttribute('href', data.href);
            }
        })
        .catch(error => {
            console.log(error);
        })
}

/**
 * Активация скриптов 
 */
function setInnerHTMLScript(el) {
    let scripts = [...el.getElementsByTagName("script")];
    for (let script of scripts) {
        let working = document.createElement("script");
        working.innerHTML = script.innerHTML;
        script.replaceWith(working);
    }
}

/**
 * Возвращает все атрибуты тега
 */
function dataElementsForAax(e) {
    let data = {};
    let atts = e.attributes;
    let n = atts.length;
    for (i = 0; i < n; i++) {
        let att = atts[i];
        data[att.nodeName] = att.nodeValue;
    }
    e.removeAttribute('href');
    return data;
}

/**
 * Возвращает url 
 */
function urlElementForAjax(e) {
    let u1 = e.getAttribute('data-url');
    let u2 = e.getAttribute('href');
    return u1 ? u1 : u2;
}

document.addEventListener("DOMContentLoaded", () => {

    document.querySelectorAll('.ajaxLoad').forEach(function (e) {
        console.log(1);
        this.addEventListener('load', function (event) {
            console.log(2);
            let url = urlElementForAjax(e);
            let data = dataElementsForAax(e);
            ajaxAction(url, data,
                function (d) {
                    e.innerHTML = d;
                },
                function (d) {
                    console.log(d);
                }, e);
        });
    });

    document.querySelectorAll('.ajaxClick').forEach(function (e) {
        e.addEventListener('click', function (event) {
            let id = e.getAttribute('data-id');
            let url = urlElementForAjax(e);
            let data = dataElementsForAax(e);
            ajaxAction(url, data,
                function (d) {
                    let el = document.getElementById(id);
                    el.innerHTML = d;
                    setInnerHTMLScript(el);
                },
                function (d) {
                    console.log(d);
                }, e);
        });
    });

});

function ajaxClick(e) {
    let id = e.getAttribute('data-id');
    let url = urlElementForAjax(e);
    let data = dataElementsForAax(e);
    ajaxAction(url, data,
        function(d) {
            let el = document.getElementById(id);
            el.innerHTML = d;
            setInnerHTMLScript(el);
        },
        function(d) {
            console.log(d);
        }, e);
}