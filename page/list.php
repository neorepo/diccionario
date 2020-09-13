<?php

$title = 'Lista de palabras';
$dao = new PalabraDao;

$palabras = $dao->getAll();
