    <!-- Sidebar -->
     <div id="sidebar-wrapper" class="col-md-1 hidden-print" style="padding-left:0;">
            <div id="showSidebar sidebar">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#" class="active">
                            {{fullname(Auth::user());}}
                    </a>
                </li>
                @if(Auth::user()->UserType == 1 || Auth::user()->UserType == 11)
                    <li class="sidehead">
                        <a href="#">
                            <b>File Maintenance </b>
                        </a>
                        <ul class="sidecontent collapse" >
                            <li>
                                <a href="/ProductCategories" id="SBProductCategories">Product Categories</a>
                            </li>
                            <li>
                                <a href="/Products" id="SBProducts">Products</a>
                            </li>
                            <li>
                                <a href="/Suppliers" id="SBSuppliers">Suppliers</a>
                            </li>
                            <li>
                                <a href="/customers" id="SBCustomers">Customers</a>
                            </li>
                            <li>
                                <a href="/branches" id="SBBranches">Branches</a>
                            </li>
                            <li>
                                <a href="/banks" id="SBBanks">Banks</a>
                            </li>
                        </ul>
                    </li>
                @endif
                <li class="sidehead">
                    <a href="#">
                        <b>Transactions </b>
                    </a>
                    <ul class="sidecontent collapse" >
                        <li>
                            <a href="/PurchaseOrders" id="SBPurchaseOrders">Purchase Orders</a>
                        </li>
                        <li>
                            <a href="/Bills" id="SBBills">Bills</a>
                        </li>
                        <li>
                            <a href="/BillPayments" id="SBBillPayments">Bill Payments</a>
                        </li>
                        <li>
                            <a href="/SalesOrders" id="SBSalesOrders">Sales Orders</a>
                        </li>
                        <li>
                            <a href="/SalesInvoice" id="SBSalesInvoice">Sales Invoice</a>
                        </li>
                        <li>
                            <a href="/SalesPayment" id="SBSalesPayment">Sales Payments</a>
                        </li>
                       
                    </ul>
                </li>
                <li class="sidehead">
                    <a href="#">
                        <b>Inventories</b>
                    </a>
                    <ul class="sidecontent collapse" >
                        <li>
                            <a href="/stocks-transfer" id="SBStockTransfer">Stock Transfers</a>
                        </li>
                        <li>
                            <a href="/inventory-adjustment" id="SBInventoryAdjustment">Inventory Adjustments</a>
                        </li>
                        <li>
                            <a href="/customer-return" id="SBCustomerReturn">Return Good Stocks</a>
                        </li>
                        <li>
                            <a href="/supplier-return" id="SBSupplierReturn">Return To Supplier</a>
                        </li>
                        <li>
                            <a href="/damages" id="SBDamages">Damages</a>
                        </li>
                    </ul>
                </li>
                 @if(Auth::user()->UserType == 1 || Auth::user()->UserType == 11)
                <li>
                    <a href="/reports" id="SBReports">Reports</a>
                </li>
                @endif
                <li class="sidehead">
                    <a href="#">
                        <b>Security</b>
                    </a>
                    <ul class="sidecontent collapse" >
                        @if(Auth::user()->UserType == 1 || Auth::user()->UserType == 11)
                            <li>
                                <a href="/Users" id="SBUsers">Users</a>
                            </li>
                        @endif
                        <li>
                            <a href="update-account"  id="SBUpdateAccount">Update Account</a>
                        </li>   
                    </ul>
                </li>
            </ul>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

       
