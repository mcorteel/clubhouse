var setInnerHTML = function(elm, html) {
    elm.innerHTML = html;
    Array.from(elm.querySelectorAll("script")).forEach( oldScript => {
        const newScript = document.createElement("script");
        Array.from(oldScript.attributes)
        .forEach( attr => newScript.setAttribute(attr.name, attr.value) );
        newScript.appendChild(document.createTextNode(oldScript.innerHTML));
        oldScript.parentNode.replaceChild(newScript, oldScript);
    });
}

// Tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
tooltipTriggerList.forEach(function (el) {
    new bootstrap.Tooltip(el);
});

const modal = new bootstrap.Modal(document.getElementById('modal'));

$('body').on('click', '.modal-link', function(e) {
    e.preventDefault();
    const modalContent = document.querySelector('#modal .modal-content');
    modalContent.innerHTML = '<h1 class="text-center"><i class="fas fa-spinner fa-spin"></i></h1>';
    const url = $(this).attr('href') || $(this).data('url');
    fetch(url)
        .then(response => {
            if(response.status === 403) {
                return '<p class="alert alert-danger m-0">Désolé, l\'accès à cette page est interdit !</p>';
            } else if(response.status === 404) {
                return '<p class="alert alert-danger m-0">Désolé, cette page est introuvable !</p>';
            }
            return response.text();
        })
        .then(data => setInnerHTML(modalContent, data));
    modal.show();
});

window.addEventListener('hashchange', function(e) {
    let hash = document.location.hash.substr(1);
    console.log(hash);
    $('#tab_' + hash).addClass('active').siblings().removeClass('active');
    let trigger = $('#' + hash + '_toggle');
    $(trigger).closest('.nav').find('.nav-link').removeClass('active');
    $(trigger).addClass('active');
});

window.dispatchEvent(new HashChangeEvent("hashchange"));
