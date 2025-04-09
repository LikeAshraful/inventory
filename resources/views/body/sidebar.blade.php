            <div class="left-side-menu">

                <div class="h-100" data-simplebar>

                    <!-- User box -->
                    <div class="user-box text-center">
                        <img src="assets/images/users/user-1.jpg" alt="user-img" title="Mat Helme"
                            class="rounded-circle avatar-md">
                        <div class="dropdown">
                            <a href="javascript: void(0);" class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block"
                                data-bs-toggle="dropdown">Geneva Kennedy</a>
                            <div class="dropdown-menu user-pro-dropdown">

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="fe-user me-1"></i>
                                    <span>My Account</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="fe-settings me-1"></i>
                                    <span>Settings</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="fe-lock me-1"></i>
                                    <span>Lock Screen</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="fe-log-out me-1"></i>
                                    <span>Logout</span>
                                </a>

                            </div>
                        </div>
                        <p class="text-muted">Admin Head</p>
                    </div>

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">

                        <ul id="side-menu">

                            
                
                            <li>
                                <a href="{{url('/dashboard')}}">
                                    <i class="mdi mdi-view-dashboard-outline"></i>
                                    <span> Dashboards </span>
                                </a>
                            </li>
							
                            <li>
                                <a href="#supplier" data-bs-toggle="collapse">
                                    <i class="material-symbols-outlined">local_shipping</i>
                                    <span> Supplier </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="supplier">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{ route('supplier.add') }}">Supplier Entry</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('supplier.all') }}">Supplier Details</a>
                                        </li>
										<li>
                                            <a href="{{ route('supplier.invoice.report') }}">Supplier Invoice Report</a>
                                        </li>
										<li>
                                            <a href="{{ route('supplier.product.report') }}">Supplier Product Report</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
							
							<li>
                                <a href="#customer" data-bs-toggle="collapse">
                                    <i class="material-symbols-outlined">groups</i>
                                    <span> Customer </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="customer">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{ route('customer.add') }}">Customer Entry</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('customer.all') }}">Customer Details</a>
                                        </li>
										<li>
                                            <a href="{{ route('customer.invoice.report') }}">Customer Invoice Report</a>
                                        </li>
										<li>
                                            <a href="{{ route('customer.product.report') }}">Customer Product Report</a>
                                        </li>
										
                                    </ul>
                                </div>
                            </li>
							
							<li>
                                <a href="#units" data-bs-toggle="collapse">
                                    <i class="mdi mdi-cart-outline"></i>
                                    <span> Units </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="units">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{ route('unit.add') }}">Unit Entry</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('unit.all') }}">All Unit</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
							
							<li>
                                <a href="#category" data-bs-toggle="collapse">
                                    <i class="material-symbols-outlined">category</i>
                                    <span> Category </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="category">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{ route('category.add') }}">Category Entry</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('category.all') }}">All Category</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
							
							<li>
                                <a href="#product" data-bs-toggle="collapse">
                                    <i class="material-symbols-outlined">view_in_ar</i>
                                    <span> Product </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="product">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{ route('product.add') }}">Product Entry</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('product.all') }}">Product Details</a>
                                        </li>
										<li>
											<a href="{{ route('import.product') }}">Import Product </a>
										</li>
                                    </ul>
                                </div>
                            </li>
							
							<li>
                                <a href="#stock" data-bs-toggle="collapse">
                                    <i class="mdi mdi-cart-outline"></i>
                                    <span>Stock</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="stock">
                                    <ul class="nav-second-level">
                                        <li><a href="{{ route('stock.report') }}">Stock Report</a></li>
										<li><a href="{{ route('stock.category.wise') }}">Category Wise Report</a></li>
										<li><a href="{{ route('damage.add') }}">Add Damage / Lost</a></li>
                                    </ul>
                                </div>
                            </li>
							
							<li>
                                <a href="#purchase" data-bs-toggle="collapse">
                                    <i class="material-symbols-outlined">hourglass_bottom</i>
                                    <span> Purchase </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="purchase">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{ route('purchase.add') }}">Purchase Entry</a>
                                        </li>
										
                                        <li>
                                            <a href="{{ route('purchase.all') }}">Purchase Details</a>
                                        </li>
										
										<li>
                                            <a href="{{ route('purchase.invoice.report') }}">Purchase Invoice Report</a>
                                        </li>
										
										<li>
                                            <a href="{{ route('purchase.product.report') }}">Purchase Product Report</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
							
							<li>
                                <a href="#sale" data-bs-toggle="collapse">
                                    <i class="mdi mdi-cart-outline"></i>
                                    <span> Sales </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sale">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{ route('retailsale.add') }}">Retail Sale</a>
                                        </li>
										
                                        <li>
                                            <a href="{{ route('wholesale.add') }}">Wholesale</a>
                                        </li>
										
										<li>
                                            <a href="{{ route('invoice.all') }}">Sales Details</a>
                                        </li>
										
										<li>
                                            <a href="{{ route('sales.invoice.report') }}">Sales Invoice Report</a>
                                        </li>
										
										<li>
                                            <a href="{{ route('sales.product.report') }}">Sales Product Report</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
							
							<li>
                                <a href="#employee" data-bs-toggle="collapse">
                                    <i class="material-symbols-outlined">group</i>
                                    <span> Employee </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="employee">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{ route('add.employee') }}">Employee Entry</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('all.employee') }}">Employee Details</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>	
							<li>
                                <a href="#payment" data-bs-toggle="collapse">
                                    <i class="material-symbols-outlined">group</i>
                                    <span> Payment </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="payment">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{ route('customer.payment') }}">Customer Payment</a>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </li>

                            <li>
                                <a href="#sidebarCrm" data-bs-toggle="collapse">
                                    <i class="mdi mdi-account-multiple-outline"></i>
                                    <span> CRM </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarCrm">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="crm-dashboard.html">Dashboard</a>
                                        </li>
                                        <li>
                                            <a href="crm-contacts.html">Contacts</a>
                                        </li>
                                        <li>
                                            <a href="crm-opportunities.html">Opportunities</a>
                                        </li>
                                        <li>
                                            <a href="crm-leads.html">Leads</a>
                                        </li>
                                        <li>
                                            <a href="crm-customers.html">Customers</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li>
                                <a href="#sidebarEmail" data-bs-toggle="collapse">
                                    <i class="mdi mdi-email-multiple-outline"></i>
                                    <span> Email </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarEmail">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="email-inbox.html">Inbox</a>
                                        </li>
                                        <li>
                                            <a href="email-read.html">Read Email</a>
                                        </li>
                                        <li>
                                            <a href="email-compose.html">Compose Email</a>
                                        </li>
                                        <li>
                                            <a href="email-templates.html">Email Templates</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            

                            
                            <li class="menu-title mt-2">Custom</li>

                            <li>
                                <a href="#sidebarAuth" data-bs-toggle="collapse">
                                    <i class="mdi mdi-account-circle-outline"></i>
                                    <span> Auth Pages </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarAuth">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="auth-login.html">Log In</a>
                                        </li>
                                        <li>
                                            <a href="auth-login-2.html">Log In 2</a>
                                        </li>
                                        <li>
                                            <a href="auth-register.html">Register</a>
                                        </li>
                                        <li>
                                            <a href="auth-register-2.html">Register 2</a>
                                        </li>
                                        <li>
                                            <a href="auth-signin-signup.html">Signin - Signup</a>
                                        </li>
                                        <li>
                                            <a href="auth-signin-signup-2.html">Signin - Signup 2</a>
                                        </li>
                                        <li>
                                            <a href="auth-recoverpw.html">Recover Password</a>
                                        </li>
                                        <li>
                                            <a href="auth-recoverpw-2.html">Recover Password 2</a>
                                        </li>
                                        <li>
                                            <a href="auth-lock-screen.html">Lock Screen</a>
                                        </li>
                                        <li>
                                            <a href="auth-lock-screen-2.html">Lock Screen 2</a>
                                        </li>
                                        <li>
                                            <a href="auth-logout.html">Logout</a>
                                        </li>
                                        <li>
                                            <a href="auth-logout-2.html">Logout 2</a>
                                        </li>
                                        <li>
                                            <a href="auth-confirm-mail.html">Confirm Mail</a>
                                        </li>
                                        <li>
                                            <a href="auth-confirm-mail-2.html">Confirm Mail 2</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li>
                                <a href="#sidebarExpages" data-bs-toggle="collapse">
                                    <i class="mdi mdi-text-box-multiple-outline"></i>
                                    <span> Extra Pages </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarExpages">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="pages-starter.html">Starter</a>
                                        </li>
                                        <li>
                                            <a href="pages-timeline.html">Timeline</a>
                                        </li>
                                        <li>
                                            <a href="pages-sitemap.html">Sitemap</a>
                                        </li>
                                        <li>
                                            <a href="pages-invoice.html">Invoice</a>
                                        </li>
                                        <li>
                                            <a href="pages-faqs.html">FAQs</a>
                                        </li>
                                        <li>
                                            <a href="pages-search-results.html">Search Results</a>
                                        </li>
                                        <li>
                                            <a href="pages-pricing.html">Pricing</a>
                                        </li>
                                        <li>
                                            <a href="pages-maintenance.html">Maintenance</a>
                                        </li>
                                        <li>
                                            <a href="pages-coming-soon.html">Coming Soon</a>
                                        </li>
                                        <li>
                                            <a href="pages-gallery.html">Gallery</a>
                                        </li>
                                        <li>
                                            <a href="pages-404.html">Error 404</a>
                                        </li>
                                        <li>
                                            <a href="pages-404-two.html">Error 404 Two</a>
                                        </li>
                                        <li>
                                            <a href="pages-404-alt.html">Error 404-alt</a>
                                        </li>
                                        <li>
                                            <a href="pages-500.html">Error 500</a>
                                        </li>
                                        <li>
                                            <a href="pages-500-two.html">Error 500 Two</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                        </ul>

                    </div>
                    <!-- End Sidebar -->

                    <div class="clearfix"></div>

                </div>
                <!-- Sidebar -left -->

            </div>