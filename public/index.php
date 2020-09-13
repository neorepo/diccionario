<?php

// define('BASE_URL', 'http://localhost/diccionario');
// define('DOCUMENT_ROOT', dirname(__DIR__));

class Index {

    const DEFAULT_PAGE = 'list';
    const PAGE_DIR = '../page/';
    const LAYOUT_DIR = '../views/';

    private static $CLASSES = [
        'Config' => '/../config/Config.php',
        'Flash' => '/../src/Flash.php',
        'Utils' => '/../src/Utils.php',
        'BaseDao' => '/../dao/BaseDao.php',
        'PalabraDao' => '/../dao/PalabraDao.php',
        'Palabra' => '/../src/Palabra.php',
        'PalabraMapper' => '/../src/PalabraMapper.php',
        'NotFoundException' => '/../src/NotFoundException.php',
    ];

    /**
     * System config.
     */
    public function init() {
        // error reporting - all errors for development (ensure you have display_errors = On in your php.ini file)
        error_reporting(E_ALL | E_STRICT);
        mb_internal_encoding('UTF-8');
        set_exception_handler([$this, 'handleException']);
        spl_autoload_register([$this, 'loadClass']);
        // session
        session_start();
    }

    public function loadClass($name) {
        if (!array_key_exists($name, self::$CLASSES)) {
            die('Class "' . $name . '" not found.');
        }
        require_once __DIR__ . self::$CLASSES[$name];
    }

    public function handleException($ex) {
        $extra = ['message' => $ex->getMessage()];
        if ($ex instanceof NotFoundException) {
            header('HTTP/1.0 404 Not Found');
            $this->runPage('404', $extra);
        } else {
            // TODO log exception
            header('HTTP/1.1 500 Internal Server Error');
            $this->runPage('500', $extra);
        }
    }

    private function getPage() {
        $page = self::DEFAULT_PAGE; // list

        if (array_key_exists('page', $_GET)) {
            $page = $_GET['page'];
        }
        return $this->checkPage($page);
    }

    private function checkPage($page) {
        // i => no sensible a mayúsculas y minúsculas
        if (!preg_match('/^[a-z0-9-]+$/i', $page)) {
            // TODO log attempt, redirect attacker, ...
            throw new NotFoundException('Unsafe page "' . $page . '" requested');
        }
        if (!$this->hasScript($page) && !$this->hasTemplate($page)) {
            // TODO log attempt, redirect attacker, ...
            throw new NotFoundException('Página "' . $page . '" no encontrada.');
        }
        return $page;
    }

    /**
     * Run the application!
     */
    public function run() {
        $this->runPage($this->getPage());
    }

    private function runPage($page, array $extra = []) {
        $run = false;
        if ($this->hasScript($page)) {
            $run = true;
            require $this->getScript($page);
        }
        if ($this->hasTemplate($page)) {
            $run = true;
            // data for main template
            $template = $this->getTemplate($page);
            $flashes = null;
            if (Flash::hasFlashes()) {
                $flashes = Flash::getFlashes();
            }
            // main template (layout)
            require self::LAYOUT_DIR . 'base.html';
        }
        if (!$run) {
            die('Page "' . $page . '" has neither script nor template!');
        }
    }

    private function getScript($page) {
        //PAGE_DIR = ../page/
        return self::PAGE_DIR . $page . '.php';
    }

    private function getTemplate($page) {
        return self::PAGE_DIR . $page . '.html';
    }

    private function hasScript($page) {
        return file_exists($this->getScript($page));
    }

    private function hasTemplate($page) {
        return file_exists($this->getTemplate($page));
    }
}

$index = new Index;
$index->init();
$index->run();