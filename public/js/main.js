'use strict';

document.addEventListener('DOMContentLoaded', () => {

    if (document.querySelector('.alert')) {
        document.querySelectorAll('.alert').forEach(el => {
            fadeOut(el);
        });
    }

    initFlashes();
    initDeleteDialog();
});

function fadeOut(el) {
    setTimeout(function () { /*el.style.display = 'none';*/ el.remove(); }, 13000);
}

//Get the button
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

function initFlashes() {
    var flashes = $("#flashes");
    if (!flashes.length) {
        return;
    }
    setTimeout(function() {
        flashes.slideUp("slow");
    }, 3000);
}

function initDeleteDialog() {
    var deleteDialog = $('#delete-dialog');
    var deleteLink = $('#delete-link');
    deleteDialog.dialog({
        autoOpen: false,
        modal: true,
        width: 476,
        buttons: {
            'OK': function() {
                $(this).dialog('close');
                location.href = deleteLink.attr('href');// page=delete&id=?
            },
            'Cancel': function() {
                $(this).dialog('close');
            }
        }
    });
    deleteLink.click(function() {
        deleteDialog.dialog('open');
        return false;
    });
}