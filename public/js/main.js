'use strict';

const d = document;

// Desabilita el clic derecho!
// d.addEventListener('contextmenu', e => e.preventDefault());
window.oncontextmenu = (e) => { e.preventDefault(); }

d.addEventListener('DOMContentLoaded', () => {
    // initDeleteFlash();
    initErrorFields();
    initFlashes();
    initDeleteDialog();
    formSubmissionHandler();
});

function initDeleteFlash() {
    let obj = d.querySelectorAll('.alert');
    if (obj) {
        obj.forEach(el => { setTimeout(function () { el.remove(); }, 3000); });
    }
}

// Evitar enviar el formulario presionando la tecla ENTER en un input field
function formSubmissionHandler() {
    const formEl = d.querySelector('form');
    if (!formEl) return;
    // También se puede utilizar el evento onkeydown
    formEl.onkeypress = function (evt) {
        var iKeyCode;
        if (evt.target.tagName != 'TEXTAREA') {
            if (evt.code)
                iKeyCode = evt.code;
            if (iKeyCode == 'Enter')
                return false;
        }

    }
}

function initFlashes() {
    var flashes = $("#flashes");
    if (!flashes.length) {
        return;
    }
    setTimeout(function () {
        flashes.slideUp("slow");
    }, 3000);
}

function initDeleteDialog() {
    var deleteDialog = $('#delete-dialog');
    var deleteLink = $('#delete-link');
    deleteDialog.dialog({
        autoOpen: false,
        modal: true,
        resizable: false,
        width: 476,
        buttons: {
            'Aceptar': function () {
                $(this).dialog('close');
                location.href = deleteLink.attr('href');
            },
            'Cancelar': function () {
                $(this).dialog('close');
            }
        }
    });
    deleteLink.click(function () {
        deleteDialog.dialog('open');
        return false;
    });
}

// Captura el primer error que exista en los formularios de registro
function initErrorFields() {
    let obj = d.querySelector('.is-invalid');
    if (obj) {
        obj.focus();
    }
}

/* Lógica volver a arriba */
var mybutton = d.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function () { scrollFunction() };

function scrollFunction() {
    if (d.body.scrollTop > 20 || d.documentElement.scrollTop > 20) {
        mybutton.style.display = "block";
    } else {
        mybutton.style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    d.body.scrollTop = 0;
    d.documentElement.scrollTop = 0;
}

/* Fin de la lógica de volver a arriba*/