<!DOCTYPE html> <!-- HTML5 document -->
<html>
    <head>
        <title>Sample Brisbane Logistics Carton Cloud App</title> <!-- Page title -->
    </head>
    <body>
        <h1 style="text-align: center;">Sample Brisbane Logistics Carton Cloud App</h1> <!-- Heading -->
        <br><br>
<style>
    .site-map {
        font-family: var(--font-sans);
        -webkit-font-smoothing: antialiased;
        line-height: 1.2;
        padding: 40px 0 10px;
        width: 938px;
        margin: 0 auto;
        position: relative;
        overflow: hidden;
    }

    .site-map .site-map-section {
        float: left;
        padding: 0;
        width: 938px;
        margin-bottom: 30px;
        position: relative;
        font-size: 12px;
    }

    .site-map .site-map-section a {
        text-decoration: none;
    }

    .site-map .site-map-section h2 {
        border-bottom: 1px solid hsl(var(--color-fg-5));
        margin: 0 0 15px;
        padding: 0 0 8px 0;
        color: hsl(var(--color-fg-base));
        clear: both;
        display: block;
        font-size: 1.5em;
        -webkit-margin-before: 0.83em;
        -webkit-margin-after: 0.83em;
        -webkit-margin-start: 0;
        -webkit-margin-end: 0;
        font-weight: bold;
    }

    .site-map-entry {
        float: left;
        width: 50%;
        min-height: 63px;
        max-height: 70px;
        padding-top: 10px;
        position: relative;
        overflow: hidden;
    }

    .site-map-entry a.name {
        text-decoration: none;
        padding-left: 20px;
        font-size: 16px;
    }

    .site-map-entry.site-map-super-user-entry a.name {
        padding-left: 6px;
    }

    .site-map-entry p {
        color: hsl(var(--color-fg-3));
        padding-left: 20px;
        margin-top: 3px;
        line-height: 1.6;
        font-size: 12px;
    }
</style>

<div class="site-map">
    
<section class="site-map-section">
    <a id="Addresses">
        <h2>Addresses</h2>
    </a>

                <div class="site-map-entry">
        <a href="/addresses" class="name">Addresses</a><p>Manage the address records here</p>    </div>

                <div class="site-map-entry">
        <a href="/addressstrings" class="name">Address Strings</a><p>Manage the address strings which are linked to addresses</p>    </div>

                <div class="site-map-entry">
        <a href="/addressdefaultinstructions" class="name">Default instructions</a><p>Specify the default instructions for each address</p>    </div>

                <div class="site-map-entry">
        <a href="/addresstodeliveryrunmapping" class="name">Address to Delivery Run Mapping</a><p>Manage address to delivery run mapping</p>    </div>

                <div class="site-map-entry">
        <a href="/deliveryaddresstoonforwarderaddressmapping" class="name">Delivery Address to Onforwarder Address Mapping</a><p>Manage delivery address to onforwarder address mapping</p>    </div>

                <div class="site-map-entry">
        <a href="/addresstoinvoicecustomermapping" class="name">Address to Invoice Customer Mapping</a><p>Manage address to Invoice Customer mapping</p>    </div>

    </section>

<section class="site-map-section">
    <a id="Contacts">
        <h2>Contacts</h2>
    </a>

                <div class="site-map-entry">
        <a href="/contacts" class="name">Contacts</a><p>Manage contact records here</p>    </div>

                <div class="site-map-entry">
        <a href="/users" class="name">Users</a><p>Manage users who have access to this CartonCloud account</p>    </div>

                <div class="site-map-entry">
        <a href="/customers" class="name">Customers</a><p>Manage customers</p>    </div>

                <div class="site-map-entry">
        <a href="/drivers" class="name">Drivers</a><p>Manage drivers and view their delivery history</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/Suppliers" class="name">Suppliers</a><p>Manage customers</p>    </div>

    </section>

<section class="site-map-section">
    <a id="Documents">
        <h2>Documents</h2>
    </a>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/Documents" class="name">Documents</a><p>View or Manage Uploaded Documents</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/DocumentTemplates" class="name">Document Templates</a><p>Manage Customizable Document Templates (POD, Packing Slips, etc)</p>    </div>

    </section>

<section class="site-map-section">
    <a id="Integrations">
        <h2>Integrations</h2>
    </a>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/FtpUsers" class="name">FTP Users</a><p>Manage FTP users</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/EmailParsingLogs" class="name">Import Log</a><p>View results of imports into the system</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/Parsers/uploadFile" class="name">Parse a File</a><p>Upload a file to the parser</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/Parsers" class="name">Parsers</a><p>Manage Parsers</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/integrations" class="name">Self-Managed Integrations</a><p>Connect &amp; Manage your own Integrations</p>    </div>

    </section>

<section class="site-map-section">
    <a id="Invoice_Settings">
        <h2>Invoice Settings</h2>
    </a>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/Invoices" class="name">Invoices</a><p>Create, manage, upload and send invoices</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/Bills" class="name">Bills</a><p>Create, manage, upload and send bills</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/FuelPriceHistories" class="name">Fuel Levy</a><p>Change the fuel levy</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/fee-categories" class="name">Fee Categories (Previously "Charge Subclasses")</a><p>Manage Fee Categories in different models</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/DefaultAdhocChargeConfig" class="name">Adhoc Charges</a><p>Set up global adhoc charges</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/rate-cards" class="name">Rate Cards</a><p>Manage charges standard for different customers</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/calculator-templates" class="name">Surcharges</a><p>Manage Surcharges for Transport Rates</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/configurations/accounts" class="name">Accounts</a><p>Manage Accounts</p>    </div>

    </section>

<section class="site-map-section">
    <a id="Logs">
        <h2>Logs</h2>
    </a>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/DeletionLogs" class="name">Deletion Logs</a><p>View or delete the deletion Logs</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/RemotePrinters" class="name">Print Log</a><p>View Print Logs</p>    </div>

    </section>

<section class="site-map-section">
    <a id="Reports">
        <h2>Reports</h2>
    </a>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/SaleOrders/packReport" class="name">Sale Order Reports</a><p>View Sale Order summary reports</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/Products/stockMovement" class="name">Stock Movement Reports</a><p>View movements of stock</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/Customers/stockCustom" class="name">Customer Stock Reports</a><p>View stock reports for a given Customer</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/Consignments/report" class="name">Consignment Report</a><p>View reports on Consignments</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/Consignments/consignmentInvoiceReport" class="name">Consignment Invoice Reports</a><p>View reports on what Consignments have Invoices</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/DiscrepancyReports" class="name">Discrepancy Reports</a><p>View reports on Consignment Errors</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/Users/oldAppVersionReport" class="name">Mobile App Version Report</a><p>View reports on mobile app version usage</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/rate-cards/report" class="name">Rate Card Report</a><p>View rates for a Rate Card</p>    </div>

    </section>

<section class="site-map-section">
    <a id="Product_Settings">
        <h2>Product Settings</h2>
    </a>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/Products" class="name">Products</a><p>Manage Products</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/ProductGroups" class="name">Product Groups</a><p>Manage Product groups</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/ProductTypes" class="name">Product Types</a><p>Manage Product types</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/ProductPackagings" class="name">Product Packaging</a><p>Manage Product packagings</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/units-of-measure" class="name">Units of Measure (Previously "Product Units of Measure")</a><p>Manage Units of Measure</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/ProductStatuses" class="name">Product Statuses</a><p>Manage Product Statuses</p>    </div>

    </section>

<section class="site-map-section">
    <a id="Tools">
        <h2>Tools</h2>
    </a>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/Tools" class="name">Tools</a><p>Various system-tools for advanced users</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/RegexDefinitions" class="name">Regex Definitions</a><p>Define regex definitions</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/document-templates/generate-zpl" class="name">ZPL Generator</a><p>Build, edit, and preview ZPL Document Templates</p>    </div>

    </section>

<section class="site-map-section">
    <a id="Transport">
        <h2>Transport</h2>
    </a>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/Consignments" class="name">Consignments</a><p>Manage Consignments</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/Manifests" class="name">Manifests</a><p>Manage Manifests</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/Deliveries" class="name">Run Sheets</a><p>Manage and export drivers run sheets</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/DeliveryRuns" class="name">Delivery Runs</a><p>Manage delivery runs and perform driver allocations</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/ConsignmentErrors" class="name">Consignment Errors</a><p>Manage consignment errors and DMA reports from the field</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/DeliveryRuns/checkAvailableDate" class="name">View Service Days</a><p>Check which days a particular area is serviced via postcode/ suburb search</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/Consignments/bulkAllocation" class="name">Bulk Allocations</a><p>Manage consignments allocation, delivery run, delivery run date</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/Vehicles" class="name">Vehicles</a><p>Create and edit Vehicles</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/transport-products" class="name">Transport Products</a><p>Manage your Transport products against consignment items</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/transport-lane-cards/default/transport-lanes" class="name">Transport Lanes</a><p>Manage Transport Lanes</p>    </div>

    </section>

<section class="site-map-section">
    <a id="Transport_Settings">
        <h2>Transport Settings</h2>
    </a>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/BankingSheets" class="name">Banking Sheets</a><p>View or Manage Banking sheets</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/carriers" class="name">Carriers</a><p>Manage carriers and change their settings</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/ConsignmentCashOnDeliveries" class="name">Cash On Deliveries</a><p>View or Manage Consignment Cash on deliveries</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/ConsignmentHistoryDeliveryStatuses" class="name">Consignment Delivery Cancelled Statuses</a><p>Manage consignment delivery cancelled statuses and whether they are charged</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/ConsignmentErrors/configuration" class="name">Consignment Errors Settings</a><p>Consignment error settings</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/DeliveryRuns/customSort" class="name">Delivery Run List Sort</a><p>Sort the delivery run list</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/zone-sets" class="name">Zone Sets</a><p>Manage Zone Sets</p>    </div>

    </section>

<section class="site-map-section">
    <a id="Organisation_Settings">
        <h2>Organisation Settings</h2>
    </a>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/Configurations/edit" class="name">Organisation Settings</a><p>View or Manage the Organisation Settings</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/CustomFields" class="name">Custom Fields</a><p>View or Manage Custom Fields</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/CustomerEmails/indexAdmin" class="name">Notification Settings</a><p>View or Manage the Email Notification Settings</p>    </div>

    </section>

<section class="site-map-section">
    <a id="Warehouse">
        <h2>Warehouse</h2>
    </a>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/PurchaseOrders" class="name">Purchase Orders</a><p>Manage Purchase Orders (incoming stock)</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/SaleOrders" class="name">Sale Orders</a><p>Manage Sale Orders (outgoing stock)</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/PurchaseOrderProducts/scanAllocation" class="name">Scan product allocation</a><p>Use the barcode scanner to allocate products in warehouse</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/outbound-orders/pack" class="name">Pack Sale Order</a><p>Pack Sale Orders for dispatch</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/StockTakes" class="name">Stocktakes</a><p>Take a Stocktake of current inventory</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/StoragePeriods" class="name">Storage Periods</a><p>View the Storage Periods</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/Shipments" class="name">Shipments</a><p>Manage Shipments</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/Containers" class="name">Containers</a><p>Manage incoming/outgoing Containers</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/Pallets/bulkPrint" class="name">Pallet Label Printing</a><p>Print Pallet Labels</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/SaleOrders/scanSaleOrderTote" class="name">Scan Order / Tote</a><p>Scan the barcode of a tote or sales order to quickly navigate to the packing screen</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/replenishments" class="name">Replenishments</a><p>Run a Replenishment</p>    </div>

    </section>

<section class="site-map-section">
    <a id="Warehouse_Settings">
        <h2>Warehouse Settings</h2>
    </a>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/Warehouses" class="name">Warehouses</a><p>Manage warehouses</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/WarehouseLocations" class="name">Warehouse Locations</a><p>Manage warehouse locations</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/WavePicks" class="name">Wave Picks</a><p>View Wave Picks</p>    </div>

                <div class="site-map-entry">
        <a href="/Brisbane_Logistics/SaleOrderPriorityStatuses" class="name">Sale Order Priority Status</a><p>Set the priorities of the sale order status</p>    </div>

    </section>
</div>
    </div>
</div>

</body>

</html>