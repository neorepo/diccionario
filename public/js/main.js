﻿'use strict';

const d = document;

// Desabilita el clic derecho!
// d.addEventListener('contextmenu', e => e.preventDefault());

d.addEventListener('DOMContentLoaded', () => {
    // initDeleteFlash();
    // preventKeyboard();
    initErrorFields();
    initFlashes();
    initDeleteDialog();
    formSubmissionHandler();
});

// Previene la apertura de herramientas del desarrollador
function preventKeyboard() {
    window.oncontextmenu = (e) => { e.preventDefault(); }
    window.onkeydown = (e) => {
        if ((e.ctrlKey && e.shiftKey && e.keyCode == 73) ||
            (e.ctrlKey && e.keyCode == 85)) {
            e.preventDefault();
        }
    }
}

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
let btnEl = document.getElementById("gototop");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function () { scrollFunction() };

btnEl.onclick = backToTop;

function backToTop() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        btnEl.style.display = "block";
    } else {
        btnEl.style.display = "none";
    }
}