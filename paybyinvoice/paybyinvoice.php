<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

class PayByInvoice extends PaymentModule
{
    public function __construct()
    {
        $this->name = 'paybyinvoice';
        $this->tab = 'payments_gateways';
        $this->version = '1.0.0';
        $this->author = '5P';
        $this->need_instance = 0;
        $this->logo = 'logo.png';

        $this->ps_versions_compliancy = ['min' => '1.7.0.0', 'max' => _PS_VERSION_];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Pay by Invoice');
        $this->description = $this->l('Allows customers to pay using Invoice.');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
    }

    public function install()
    {
        return parent::install() &&
            $this->registerHook('paymentOptions') &&
            $this->registerHook('paymentReturn') &&
            $this->installOrderStatus();
    }

    public function uninstall()
    {
        // Uninstall the custom order status
        if (!$this->uninstallOrderStatus()) {
            return false; // If the order status could not be removed, return false
        }
        // Remove the configuration for the order status ID
        if (!Configuration::deleteByName('AWI_ORDER_STATUS_ID')) {
            return false; // If we failed to delete the configuration value, return false
        }
        // Make sure to call parent uninstall method to ensure PrestaShop does its own cleanup
        if (!parent::uninstall()) {
            return false; // If the parent uninstall method fails, return false
        }

        return true; // Everything has been cleaned up properly
    }

    // Create a custom order status for invoice payments
    private function installOrderStatus()
    {
    
        // Create a new OrderState object
        $status = new OrderState();
        $status->color = '#FFA500'; // Choose a color for the status
        $status->send_email = false; // Whether to send an email when the status changes
        $status->logable = false; // Whether the status should be logged
        $status->invoice = false; // Not related to invoice generation
        $status->shipped = false; // Set to true if the order is shipped
        $status->delivered = false; // Set to true if the order is delivered
        $status->paid = false; // This status represents orders that are not paid yet
    
        // Set the name for the status in all languages
        $languages = Language::getLanguages();
        foreach ($languages as $language) {
            $status->name[$language['id_lang']] = 'Awaiting Invoice Payment';  // Default name
        }
    
        // Save the order state (status)
        if ($status->add()) {
            // Update the module's configuration with the new status ID
            Configuration::updateValue('AWI_ORDER_STATUS_ID', $status->id);
        } else {
            // Handle error if the status cannot be added
            $this->_errors[] = $this->l('Failed to create the order status.');
        }
    
        return true;
    }

    private function uninstallOrderStatus()
    {
        // Retrieve the custom order status using the ID stored in configuration
        $orderStatusId = Configuration::get('AWI_ORDER_STATUS_ID');
        
        if ($orderStatusId) {
            // Attempt to delete the custom order status
            $status = new OrderState($orderStatusId);
            if ($status->delete()) {
                return true; // If deletion was successful
            }
        }
    
        return false; // If the order status could not be deleted
    }

    public function hookPaymentOptions($params)
    {
        if (!$this->active) {
            return;
        }

        $paymentOption = new \PrestaShop\PrestaShop\Core\Payment\PaymentOption();
        $paymentOption->setCallToActionText($this->l('Pay by Invoice'))
                      ->setAction($this->context->link->getModuleLink($this->name, 'validation', [], true))
                      ->setAdditionalInformation($this->fetch('module:paybyinvoice/views/templates/front/payment_infos.tpl'));

        return [$paymentOption];
    }

    public function hookPaymentReturn($params)
    {
        if (!$this->active) {
            return;
        }

        return $this->fetch('module:paybyinvoice/views/templates/front/payment_return.tpl');
    }
}
