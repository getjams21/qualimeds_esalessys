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
                                <a href="/ProductCategories">Product Categories</a>
                            </li>
                            <li>
                                <a href="/Products">Products</a>
                            </li>
                            <li>
                                <a href="/Suppliers">Suppliers</a>
                            </li>
                            <li>
                                <a href="/customers">Customers</a>
                            </li>
                            <li>
                                <a href="/branches">Branches</a>
                            </li>
                            <li>
                                <a href="/banks">Banks</a>
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
                            <a href="/PurchaseOrders">Purchase_Orders</a>
                        </li>
                        <li>
                            <a href="/SalesOrders">Sales_Orders</a>
                        </li>
                        <li>
                            <a href="/SalesInvoice">Sales Invoice</a>
                        </li>
                        <li>
                            <a href="/Bills">Bills</a>
                        </li>
                        <li>
                            <a href="/BillPayments">Bill Payments</a>
                        </li>
                    </ul>
                </li>
                <li class="sidehead">
                    <a href="#">
                        <b>Inventories</b>
                    </a>
                    <ul class="sidecontent collapse" >
                        <li>
                            <a href="/stocks-transfer">Stock Transfers</a>
                        </li>
                    </ul>
                </li>
                <li class="sidehead">
                    <a href="#">
                        <b>Security</b>
                    </a>
                    <ul class="sidecontent collapse" >
                        @if(Auth::user()->UserType == 1 || Auth::user()->UserType == 11)
                            <li>
                                <a href="/Users">Users</a>
                            </li>
                        @endif
                        <li>
                            <a href="update-account" >Update Account</a>
                        </li>   
                    </ul>
                </li>
            </ul>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

       
