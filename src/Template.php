<?php

class Template {

    public function render($template, $data = []) {

        if ( file_exists('../views/' . $template . '.html') ) {

            extract($data);

            $template = '../views/' . $template . '.html';

            $flashes = null;
            if (Flash::hasFlashes()) {
                $flashes = Flash::getFlashes();
            }

            require '../views/base.html';
        }
        else {
            trigger_error('La plantilla ' . $template . ' no es válida', E_USER_ERROR);
        }
    }
}