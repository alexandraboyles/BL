<?php
namespace App\Routing;

class Routes
{
    public static function register(RouteRegistry $router): void
    {
        // Home routes
        $router->get('/', 'App\Controller\HomeController', 'index', 'home');
        $router->get('/home', 'App\Controller\HomeController', 'index', 'home.alt');
        // Addresses - use lowercase for route consistency
        $router->resource('addresses', 'App\Controller\AddressController');
        // Address Default Instructions - fix capitalization
        $router->resource('addressdefaultinstructions', 'App\Controller\AddressDefaultInstructionsController');
        $router->resource('deliveryaddresstoonforwarderaddressmapping', 'App\Controller\DeliveryAddressToOnforwarderAddressMappingController');
        $router->resource('addressstrings', 'App\Controller\AddressStringsController');
        $router->resource('addresstodeliveryrunmapping', 'App\Controller\AddressToDeliveryRunMappingController');
        $router->resource('addresstoinvoicecustomermapping', 'App\Controller\AddressToInvoiceCustomerMappingController');
        $router->resource('contacts', 'App\Controller\ContactsController');
        $router->resource('users', 'App\Controller\UsersController');
        $router->resource('drivers', 'App\Controller\DriversController');
        $router->resource('customers', 'App\Controller\CustomersController');
        $router->resource('suppliers', 'App\Controller\SuppliersController');
        $router->resource('documents', 'App\Controller\DocumentsController');
        $router->resource('ftpusers', 'App\Controller\FTPUsersController');
        $router->resource('parsers', 'App\Controller\ParsersController');
        $router->resource('invoices', 'App\Controller\InvoicesController');
        $router->resource('feecategories', 'App\Controller\FeeCategoriesController');
        $router->resource('ratecards', 'App\Controller\RateCardsController');
        $router->resource('accounts', 'App\Controller\AccountsController');
        $router->resource('bills', 'App\Controller\BillsController');
        $router->resource('adhoccharges', 'App\Controller\AdhocChargesController');
        $router->resource('surcharges', 'App\Controller\SurchargesController');
        $router->resource('products', 'App\Controller\ProductsController');
    }
}