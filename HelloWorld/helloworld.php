<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

class HelloWorld extends Module
{
    public function __construct()
    {
        $this->name = 'helloworld';
        $this->tab = 'administration';
        $this->version = '1.0.1';
        $this->author = '5prstov';
        $this->need_instance = 0;

        parent::__construct();

        $this->displayName = $this->l('Hello World');
        $this->description = $this->l('A simple Hello World module.');
    }

    public function install()
    {
        return parent::install() && $this->registerHook('displayHome');
    }

    public function uninstall()
    {
        return parent::uninstall();
    }

    public function hookDisplayHome($params)
    {
        return $this->display(__FILE__, 'views/templates/hook/helloworld.tpl');
    }
}
