 <aside style="background-color:var(--primary-color) " class="shadow1 app-sidebar  shadow" data-bs-theme="dark">
     <div class="sidebar-brand">
         <a href="./index.html" class="brand-link">
             {{-- <img src="./assets/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image opacity-75 shadow" /> --}}
             <span class="brand-text fw-light text-uppercase">{{ $user?->organization?->name ?? "Surkhet Business One" }}</span>
         </a>
     </div>
     <div class="sidebar-wrapper">
         <nav class="mt-2">
             <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation"
                 aria-label="Main navigation" data-accordion="false" id="navigation">

                 <li class="nav-item">
                     <a href="{{ route('home') }}" class="nav-link">
                         <i class="nav-icon bi bi-speedometer"></i>
                         <p>Dashboard</p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="#" class="nav-link">
                         <i class="nav-icon fa fa-chair"></i>
                         <p>
                             Front Office
                             <i class="nav-arrow bi bi-chevron-right"></i>
                         </p>
                     </a>
                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="./widgets/small-box.html" class="nav-link">
                                 <i class="nav-icon bi bi-circle"></i>
                                 <p>Visitor Book</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="./widgets/info-box.html" class="nav-link">
                                 <i class="nav-icon bi bi-circle"></i>
                                 <p>Phone Call Log</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="./widgets/cards.html" class="nav-link">
                                 <i class="nav-icon bi bi-circle"></i>
                                 <p>Postal Dispatch</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="./widgets/cards.html" class="nav-link">
                                 <i class="nav-icon bi bi-circle"></i>
                                 <p>Postal Receive</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="./widgets/cards.html" class="nav-link">
                                 <i class="nav-icon bi bi-circle"></i>
                                 <p>Complain</p>
                             </a>
                         </li>
                     </ul>
                 </li>
                 <li class="nav-item">
                     <a href="#" class="nav-link">
                         <i class="nav-icon fa fa-users"></i>
                         <p>
                             human resource
                             <i class="nav-arrow bi bi-chevron-right"></i>
                         </p>
                     </a>
                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="{{ route('employee.index') }}" class="nav-link">
                                 <i class="nav-icon bi bi-circle"></i>
                                 <p>Employee</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{ route('role.index') }}" class="nav-link">
                                 <i class="nav-icon bi bi-circle"></i>
                                 <p>Role</p>
                             </a>
                         </li>

                     </ul>
                 </li>
                 <li class="nav-item">
                     <a href="{{ route('organization.setting') }}" class="nav-link">
                         <i class="nav-icon fa fa-gears"></i>
                         <p>Settings</p>
                     </a>
                 </li>
             </ul>
             <!--end::Sidebar Menu-->
         </nav>
     </div>
     <!--end::Sidebar Wrapper-->
 </aside>
