      <nav id="sidebar" aria-label="Main Navigation">
          <!-- Side Header -->
          <div class="bg-header-dark">
              <div class="content-header bg-white-5">
                  <!-- Logo -->
                  <a class="fw-semibold text-white tracking-wide" href="index.html">
                      <span class="smini-visible">
                          D<span class="opacity-75">x</span>
                      </span>
                      <span class="smini-hidden">
                          iNVENTO<span class="opacity-75">LYNK</span>
                      </span>
                  </a>
                  <!-- END Logo -->

                  <!-- Options -->
                  {{-- <div>
              <!-- Toggle Sidebar Style -->
              <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
              <!-- Class Toggle, functionality initialized in Helpers.dmToggleClass() -->
              <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="class-toggle" data-target="#sidebar-style-toggler" data-class="fa-toggle-off fa-toggle-on" onclick="Dashmix.layout('sidebar_style_toggle');Dashmix.layout('header_style_toggle');">
                <i class="fa fa-toggle-off" id="sidebar-style-toggler"></i>
              </button>
              <!-- END Toggle Sidebar Style -->

              <!-- Dark Mode -->
              <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
              <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="class-toggle" data-target="#dark-mode-toggler" data-class="far fa" onclick="Dashmix.layout('dark_mode_toggle');">
                <i class="far fa-moon" id="dark-mode-toggler"></i>
              </button>
              <!-- END Dark Mode -->

              <!-- Close Sidebar, Visible only on mobile screens -->
              <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
              <button type="button" class="btn btn-sm btn-alt-secondary d-lg-none" data-toggle="layout" data-action="sidebar_close">
                <i class="fa fa-times-circle"></i>
              </button>
              <!-- END Close Sidebar -->
            </div> --}}
                  <!-- END Options -->
              </div>
          </div>
          <!-- END Side Header -->

          <!-- Sidebar Scrolling -->
          <div class="js-sidebar-scroll">
              <!-- Side Navigation -->
              <div class="content-side">
                  <ul class="nav-main">
                      <li class="nav-main-item">
                          <a class="nav-main-link {{ request()->is('dashboard') ? ' active' : '' }}" href="/dashboard">
                              <i class="nav-main-link-icon fa fa-dashboard"></i>
                              <span class="nav-main-link-name">Dashboard</span>
                              {{-- <span class="nav-main-link-badge badge rounded-pill bg-primary">8</span> --}}
                          </a>
                      </li>

                      <li class="nav-main-heading">MANAGEMENTS</li>
                      <li class="nav-main-item">
                          <a class="nav-main-link" href="be_pages_generic_blank.html">
                              <i class="nav-main-link-icon fa">&#128373;</i>
                              <span class="nav-main-link-name">Inspection</span>
                          </a>
                      </li>

                      <li class="nav-main-item">
                          <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                              aria-expanded="false" href="#">
                              <i class="nav-main-link-icon fa">&#128221;</i>
                              <span class="nav-main-link-name">Issuance</span>
                          </a>
                          <ul class="nav-main-submenu">
                              <li class="nav-main-item">
                                  <a class="nav-main-link" href="be_pages_generic_blank_block.html">
                                      <i class="nav-main-link-icon fa ">&#128221;</i>
                                      <span class="nav-main-link-name">PAR or Transfer</span>
                                  </a>
                              </li>
                              <li class="nav-main-item">
                                  <a class="nav-main-link" href="be_pages_generic_blank_block.html">
                                      <i class="nav-main-link-icon fa ">&#128221;</i>
                                      <span class="nav-main-link-name">ICS</span>
                                  </a>
                              </li>
                          </ul>
                      </li>

                      <li class="nav-main-item">
                          <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                              aria-expanded="false" href="#">
                              <i class="nav-main-link-icon fa">&#127959;</i>
                              <span class="nav-main-link-name">Warehouse</span>
                          </a>
                          <ul class="nav-main-submenu">
                              <li class="nav-main-item">
                                  <a class="nav-main-link" href="be_pages_generic_blank.html">
                                      <i class="nav-main-link-icon fa fa-sign-in"></i>
                                      <span class="nav-main-link-name">Entry</span>
                                  </a>
                              </li>
                              <li class="nav-main-item">
                                  <a class="nav-main-link" href="be_pages_generic_blank_block.html">
                                      <i class="nav-main-link-icon fa fa-sign-out"></i>
                                      <span class="nav-main-link-name">Exit</span>
                                  </a>
                              </li>
                          </ul>
                      </li>

                      <li class="nav-main-item">
                          <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                              aria-expanded="false" href="#">
                              <i class="nav-main-link-icon fa fa-sitemap"></i>
                              <span class="nav-main-link-name">Inventory</span>
                          </a>
                          <ul class="nav-main-submenu">
                              <li class="nav-main-item">
                                  <a class="nav-main-link" href="be_pages_generic_blank.html">
                                      <i class="nav-main-link-icon fa fa-cloud-download"></i>
                                      <span class="nav-main-link-name">Get Scanned Data</span>
                                  </a>
                              </li>
                              <li class="nav-main-item">
                                  <a class="nav-main-link" href="be_pages_generic_blank_block.html">
                                      <i class="nav-main-link-icon fa fa-list"></i>
                                      <span class="nav-main-link-name">Manual Inventory</span>
                                  </a>
                              </li>
                              <li class="nav-main-item">
                                  <a class="nav-main-link" href="be_pages_generic_blank_block.html">
                                      <i class="nav-main-link-icon fa fa-clone"></i>
                                      <span class="nav-main-link-name">Close Inventoty</span>
                                  </a>
                              </li>
                          </ul>
                      </li>

                      <li class="nav-main-item">
                          <a class="nav-main-link" href="be_pages_generic_blank.html">
                              <i class="nav-main-link-icon fa fa-history"></i>
                              <span class="nav-main-link-name">Item History Ledger</span>
                          </a>
                      </li>

                      <li class="nav-main-item">
                          <a class="nav-main-link" href="be_pages_generic_blank.html">
                              <i class="nav-main-link-icon fa fa-book"></i>
                              <span class="nav-main-link-name">Item Book Value</span>
                          </a>
                      </li>

                      <li class="nav-main-heading">VEHICLE</li>
                      <li class="nav-main-item">
                          <a class="nav-main-link" href="be_pages_generic_blank.html">
                              <i class="nav-main-link-icon fa fa-car"></i>
                              <span class="nav-main-link-name">Master File</span>
                          </a>
                      </li>
                      <li class="nav-main-item">
                          <a class="nav-main-link" href="be_pages_generic_blank.html">
                              <i class="nav-main-link-icon fa fa-address-card"></i>
                              <span class="nav-main-link-name">Registration</span>
                          </a>
                      </li>

                      <li class="nav-main-heading">POP-UPS</li>
                      <li class="nav-main-item {{ request()->is('file-maintenance/*') ? ' open' : '' }}">
                          <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                              aria-expanded="false" href="#">
                              <i class="nav-main-link-icon fa ">&#128194;</i>
                              <span class="nav-main-link-name">File Maintenance</span>
                          </a>
                          <ul class="nav-main-submenu">
                              <li class="nav-main-item {{ request()->is('file-maintenance/item-data/*') ? ' open' : '' }}">
                                  <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                                      aria-haspopup="true" aria-expanded="false" href="#">
                                      <i class="nav-main-link-icon fa fa-cubes"></i>
                                      <span class="nav-main-link-name">Item Data</span>
                                  </a>
                                  <ul class="nav-main-submenu">
                                      <li class="nav-main-item">
                                          <a class="nav-main-link {{ request()->is('file-maintenance/item-data/classification-list') ? ' active' : '' }}" href="/file-maintenance/item-data/classification-list">
                                              <i class="nav-main-link-icon fa fa-file"></i>
                                              <span class="nav-main-link-name">Classification</span>
                                          </a>
                                      </li>
                                      <li class="nav-main-item">
                                          <a class="nav-main-link {{ request()->is('file-maintenance/item-data/sub-classification-list') ? ' active' : '' }}" href="/file-maintenance/item-data/sub-classification-list">
                                              <i class="nav-main-link-icon fa fa-file"></i>
                                              <span class="nav-main-link-name">Sub Classification</span>
                                          </a>
                                      </li>
                                      <li class="nav-main-item">
                                          <a class="nav-main-link {{ request()->is('file-maintenance/item-data/item-master-list') ? ' active' : '' }}" href="/file-maintenance/item-data/item-master-list">
                                              <i class="nav-main-link-icon fa fa-file"></i>
                                              <span class="nav-main-link-name">Item Master Data</span>
                                          </a>
                                      </li>
                                      <li class="nav-main-item">
                                          <a class="nav-main-link {{ request()->is('file-maintenance/item-data/item-source-list') ? ' active' : '' }}" href="/file-maintenance/item-data/item-source-list">
                                              <i class="nav-main-link-icon fa fa-file"></i>
                                              <span class="nav-main-link-name">Item Source</span>
                                          </a>
                                      </li>
                                      <li class="nav-main-item">
                                          <a class="nav-main-link {{ request()->is('file-maintenance/item-data/uom-list') ? ' active' : '' }}" href="/file-maintenance/item-data/uom-list">
                                              <i class="nav-main-link-icon fa fa-file"></i>
                                              <span class="nav-main-link-name">Unit</span>
                                          </a>
                                      </li>
                                      <li class="nav-main-item">
                                          <a class="nav-main-link" href="be_pages_generic_blank_block.html">
                                              <i class="nav-main-link-icon fa fa-file"></i>
                                              <span class="nav-main-link-name">Status</span>
                                          </a>
                                      </li>
                                  </ul>
                              </li>
                          </ul>
                          <ul class="nav-main-submenu">
                              <li class="nav-main-item">
                                  <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                                      aria-haspopup="true" aria-expanded="false" href="#">
                                      <i class="nav-main-link-icon fa fa-location-arrow"></i>
                                      <span class="nav-main-link-name">Location</span>
                                  </a>
                                  <ul class="nav-main-submenu">
                                      <li class="nav-main-item">
                                          <a class="nav-main-link" href="be_pages_generic_blank_block.html">
                                              <i class="nav-main-link-icon fa fa-file"></i>
                                              <span class="nav-main-link-name">Building</span>
                                          </a>
                                      </li>
                                      <li class="nav-main-item">
                                          <a class="nav-main-link" href="be_pages_generic_blank_block.html">
                                              <i class="nav-main-link-icon fa fa-file"></i>
                                              <span class="nav-main-link-name">Actual Location</span>
                                          </a>
                                      </li>
                                  </ul>
                              </li>
                          </ul>
                          <ul class="nav-main-submenu">
                              <li class="nav-main-item">
                                  <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                                      aria-haspopup="true" aria-expanded="false" href="#">
                                      <i class="nav-main-link-icon fa fa-users"></i>
                                      <span class="nav-main-link-name">Employee Info</span>
                                  </a>
                                  <ul class="nav-main-submenu">
                                      <li class="nav-main-item">
                                          <a class="nav-main-link" href="be_pages_generic_blank_block.html">
                                              <i class="nav-main-link-icon fa fa-file"></i>
                                              <span class="nav-main-link-name">Department</span>
                                          </a>
                                      </li>
                                      <li class="nav-main-item">
                                          <a class="nav-main-link" href="be_pages_generic_blank_block.html">
                                              <i class="nav-main-link-icon fa fa-file"></i>
                                              <span class="nav-main-link-name">Position</span>
                                          </a>
                                      </li>
                                      <li class="nav-main-item">
                                          <a class="nav-main-link" href="be_pages_generic_blank_block.html">
                                              <i class="nav-main-link-icon fa fa-file"></i>
                                              <span class="nav-main-link-name">Status</span>
                                          </a>
                                      </li>
                                      <li class="nav-main-item">
                                          <a class="nav-main-link" href="be_pages_generic_blank_block.html">
                                              <i class="nav-main-link-icon fa fa-file"></i>
                                              <span class="nav-main-link-name">Employee</span>
                                          </a>
                                      </li>
                                  </ul>
                              </li>
                          </ul>
                      </li>

                      <li class="nav-main-heading">PERSONAL</li>
                      <li class="nav-main-item">
                          <a class="nav-main-link" href="be_pages_generic_blank_block.html">
                              <i class="nav-main-link-icon fa fa-user"></i>
                              <span class="nav-main-link-name">Profile</span>
                          </a>
                      </li>
                      <li class="nav-main-item">
                          <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                              aria-expanded="true" href="#">
                              <i class="nav-main-link-icon fa fa-cogs"></i>
                              <span class="nav-main-link-name">Settings</span>
                          </a>
                          <ul class="nav-main-submenu">
                              <li class="nav-main-item">
                                  <a class="nav-main-link" href="be_pages_generic_blank.html">
                                      <i class="nav-main-link-icon fa fa-inbox"></i>
                                      <span class="nav-main-link-name">Email Recipients</span>
                                  </a>
                              </li>
                          </ul>
                      </li>

                      <li class="nav-main-heading">SECURITY</li>
                      <li class="nav-main-item {{ request()->is('user/*') ? ' open' : '' }}">
                          <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                              aria-expanded="true" href="#">
                              <i class="nav-main-link-icon fa fa-cog"></i>
                              <span class="nav-main-link-name">User Management</span>
                          </a>
                          <ul class="nav-main-submenu">
                              <li class="nav-main-item">
                                  <a class="nav-main-link {{ request()->is('user/account-list') ? ' active' : '' }}"
                                      href="/user/account-list">
                                      <i class="nav-main-link-icon fa fa-user-circle"></i>
                                      <span class="nav-main-link-name">Accounts</span>
                                  </a>
                              </li>
                              <li class="nav-main-item">
                                  <a class="nav-main-link{{ request()->is('user/permissions') ? ' active' : '' }}"
                                      href="/user/permission">
                                      <i class="nav-main-link-icon fa fa-vcard"></i>
                                      <span class="nav-main-link-name">Permission</span>
                                  </a>
                              </li>
                              <li class="nav-main-item">
                                  <a class="nav-main-link" href="#">
                                      <i class="nav-main-link-icon fa fa-unlock"></i>
                                      <span class="nav-main-link-name">Change Password</span>
                                  </a>
                              </li>
                          </ul>
                      </li>

                      <li class="nav-main-heading">REPORTS</li>
                      <li class="nav-main-item">
                          <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                              aria-expanded="false" href="#">
                              <i class="nav-main-link-icon fa fa">&#128203;</i>
                              <span class="nav-main-link-name">Reports</span>
                          </a>
                          <ul class="nav-main-submenu">
                              <li class="nav-main-item">
                                  <a class="nav-main-link" href="be_pages_generic_blank.html">
                                      <i class="nav-main-link-icon fa fa">&#128203;</i>
                                      <span class="nav-main-link-name">Audit Trail</span>
                                  </a>
                              </li>
                          </ul>
                      </li>

                  </ul>
              </div>
              <!-- END Side Navigation -->
          </div>
          <!-- END Sidebar Scrolling -->
      </nav>
      <!-- END Sidebar -->
