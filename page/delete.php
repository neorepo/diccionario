<?php

$palabra = Utils::getPalabraByGetId();

$dao = new PalabraDao();
$dao->delete($palabra->getId());
Flash::addFlash('Palabra eliminada correctamente.');

Utils::redirect('list');