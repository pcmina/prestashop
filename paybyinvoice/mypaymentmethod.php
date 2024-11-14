<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

class MyPaymentMethod extends PaymentModule
{
    public function __construct()
    {
        $this->name = 'mypaymentmethod';
        $this->tab = 'payments_gateways';
        $this->version = '1.0.0';
        $this->author = 'Your Name';
        $this->need_instance = 0;

        $this->ps_versions_compliancy = ['min' => '1.7.0.0', 'max' => _PS_VERSION_];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('My Payment Method');
        $this->description = $this->l('Allows customers to pay using My Payment Method.');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
    }

    public function install()
    {
        return parent::install() &&
            $this->registerHook('paymentOptions') &&
            $this->registerHook('paymentReturn');
    }

    public function uninstall()
    {
        return parent::uninstall();
    }

    public function hookPaymentOptions($params)
    {
        if (!$this->active) {
            return;
        }

        $paymentOption = new \PrestaShop\PrestaShop\Core\Payment\PaymentOption();
        $paymentOption->setCallToActionText($this->l('Pay with My Payment Method'))
                      ->setAction($this->context->link->getModuleLink($this->name, 'validation', [], true))
                      ->setAdditionalInformation($this->fetch('module:mypaymentmethod/views/templates/front/payment_infos.tpl'));

        return [$paymentOption];
    }

    public function hookPaymentReturn($params)
    {
        if (!$this->active) {
            return;
        }

        return $this->fetch('module:mypaymentmethod/views/templates/front/payment_return.tpl');
    }
}
