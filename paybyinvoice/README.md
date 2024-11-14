# Pay by Invoice  - Prestashop Payment Module

Paybyinvoice is a custom payment module for Prestashop that allows customers to complete orders using "Pay by Invoice". This module is designed for custom payment options, like paying by bank transfer or invoicing.

## Features
* Adds a new payment option on the checkout page.
* Displays custom instructions for using the payment method.
* Confirms payment on the order confirmation page.
* Easily customizable for different payment needs.

## Customization
### Display Text

You can customize the text shown to customers by editing the following files:
* Checkout Instructions: views/templates/front/payment_infos.tpl
* Order Confirmation Message: views/templates/front/payment_return.tpl

### Payment Processing Logic

To customize the payment processing logic, edit controllers/front/validation.php. You can adjust the order status or add custom handling for different scenarios.

## Development

This module is designed for Prestashop 1.7.x and is compatible with the following versions:

    Minimum Version: Prestashop 1.7.0
    Tested Up To: Prestashop 1.7.7

## Extending and Customizing 
* **Adding Configuration Options**: Use `getContent()` in `mypaymentmethod.php` to add a configuration page in the back office.
* **Form Management**: Use `renderForm()` and Prestashop’s `HelperForm` class to create forms for configuring module settings.”

