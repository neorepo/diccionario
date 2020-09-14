'use strict';

document.addEventListener('DOMContentLoaded', () => {
    // initDeleteFlash();
    initErrorFields();
    initFlashes();
    initDeleteDialog();
    initPreventFormSubmit();
});

function initDeleteFlash() {
    if (document.querySelector('.alert')) {
        document.querySelectorAll('.alert').forEach(el => {
            setTimeout(function () { el.remove(); }, 3000);
        });
    }
}

function initPreventFormSubmit() {
    // Evitar enviar el formulario presionando la tecla ENTER en un input field
    if (document.querySelector('form')) {
        // También se puede utilizar el evento onkeydown
        document.querySelector('form').onkeypress = (e) => {
            if (e.key === "Enter") {
                // Evitamos que se ejecuté el evento
                e.preventDefault();
                // Retornamos false
                return false;
            }
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
                location.href = deleteLink.attr('href');// page=delete&id=?
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

function initErrorFields() {
    // Captura el primer error que exista en los formularios de registro
    if (document.querySelector('.is-invalid')) {
        document.querySelector('.is-invalid').focus();
    }
}

/* Lógica volver a arriba */
var mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function () { scrollFunction() };

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        mybutton.style.display = "block";
    } else {
        mybutton.style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}

/* Fin de la lógica de volver a arriba*/