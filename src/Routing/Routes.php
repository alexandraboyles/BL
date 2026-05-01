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
        
    }
}