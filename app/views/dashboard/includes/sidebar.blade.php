    <!-- Sidebar -->
     <div id="sidebar-wrapper" class="col-md-1 hidden-print" style="padding-left:0;">
            <div id="showSidebar sidebar">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#" class="active">
                            {{Auth::user()->username}}
                    </a>
                </li>
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
                <li class="sidehead">
                    <a href="#">
                        <b>Security</b>
                    </a>
                    <ul class="sidecontent collapse" >
                        <li>
                            <a href="/Users">Users</a>
                        </li>
                        <li>
                            <a href="#" >Update Account</a>
                        </li>   
                    </ul>
                </li>
            </ul>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

       
