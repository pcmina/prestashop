<?php

class MyPaymentMethodValidationModuleFrontController extends ModuleFrontController
{
    public function postProcess()
    {
        $cart = $this->context->cart;

        if (!$this->module->active || !$cart->id) {
            Tools::redirect('index.php?controller=order&step=1');
        }

        // Create an order with a status for manual processing
        $this->module->validateOrder(
            $cart->id,
            Configuration::get('PS_OS_BANKWIRE'), // Custom order status for pending payment
            $cart->getOrderTotal(true, Cart::BOTH),
            $this->module->displayName,
            null,
            [],
            (int)$this->context->currency->id,
            false,
            $this->context->customer->secure_key
        );

        Tools::redirect('index.php?controller=order-confirmation&id_cart='.$cart->id.'&id_module='.$this->module->id.'&id_order='.$this->module->currentOrder.'&key='.$this->context->customer->secure_key);
    }
}
