<div class="main-sidebar">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="<?php echo ADMIN_URL; ?>dashboard.php">Admin Panel</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="<?php echo ADMIN_URL; ?>dashboard.php"></a>
    </div>

    <ul class="sidebar-menu">

        <li class="<?php if($cur_page == 'dashboard.php') { echo 'active'; } ?>">
          <a class="nav-link" href="<?php echo ADMIN_URL; ?>dashboard.php">
            <i class="fas fa-hand-point-right"></i> 
            <span>Dashboard</span>
          </a>
        </li>

        <li class="<?php if($cur_page == 'location-view.php' || $cur_page == 'location-edit.php' || $cur_page == 'location-add.php') { echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo ADMIN_URL; ?>location-view.php">
                <i class="fas fa-hand-point-right"></i> Location
            </a>
        </li>

        <li class="<?php if($cur_page == 'type-view.php' || $cur_page == 'type-edit.php' || $cur_page == 'type-add.php') { echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo ADMIN_URL; ?>type-view.php">
                <i class="fas fa-hand-point-right"></i> Type
            </a>
        </li>

        <li class="<?php if($cur_page == 'amenity-view.php' || $cur_page == 'amenity-edit.php' || $cur_page == 'amenity-add.php') { echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo ADMIN_URL; ?>amenity-view.php">
                <i class="fas fa-hand-point-right"></i> Amenity
            </a>
        </li>

        <li class="<?php if($cur_page == 'property-view.php') { echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo ADMIN_URL; ?>property-view.php">
                <i class="fas fa-hand-point-right"></i> Properties
            </a>
        </li>

        <li class="<?php if($cur_page == 'order-view.php') { echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo ADMIN_URL; ?>order-view.php">
                <i class="fas fa-hand-point-right"></i> Orders
            </a>
        </li>

        <li class="<?php if($cur_page == 'message-view.php' || $cur_page == 'message-detail.php') { echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo ADMIN_URL; ?>message-view.php">
                <i class="fas fa-hand-point-right"></i> Messages
            </a>
        </li>

        <li class="<?php if($cur_page == 'customer-view.php') { echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo ADMIN_URL; ?>customer-view.php">
                <i class="fas fa-hand-point-right"></i> Customers
            </a>
        </li>

        <li class="<?php if($cur_page == 'agent-view.php') { echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo ADMIN_URL; ?>agent-view.php">
                <i class="fas fa-hand-point-right"></i> Agents
            </a>
        </li>

        <li class="<?php if($cur_page == 'why-choose-view.php' || $cur_page == 'why-choose-add.php' || $cur_page == 'why-choose-edit.php') { echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo ADMIN_URL; ?>why-choose-view.php">
                <i class="fas fa-hand-point-right"></i> Why Choose Us?
            </a>
        </li>

        <li class="<?php if($cur_page == 'post-view.php' || $cur_page == 'post-add.php' || $cur_page == 'post-edit.php') { echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo ADMIN_URL; ?>post-view.php">
                <i class="fas fa-hand-point-right"></i> Blog
            </a>
        </li>

        <li class="<?php if($cur_page == 'faq-view.php' || $cur_page == 'faq-add.php' || $cur_page == 'faq-edit.php') { echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo ADMIN_URL; ?>faq-view.php">
                <i class="fas fa-hand-point-right"></i> FAQ
            </a>
        </li>

        <li class="<?php if($cur_page == 'terms-view.php') { echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo ADMIN_URL; ?>terms-view.php">
                <i class="fas fa-hand-point-right"></i> Terms
            </a>
        </li>

        <li class="<?php if($cur_page == 'privacy-view.php') { echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo ADMIN_URL; ?>privacy-view.php">
                <i class="fas fa-hand-point-right"></i> Privacy
            </a>
        </li>

        <li class="<?php if($cur_page == 'setting.php') { echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo ADMIN_URL; ?>setting.php">
                <i class="fas fa-hand-point-right"></i> <span>Website Setting</span>
            </a>
        </li> 

        <li class="<?php if($cur_page == 'package-view.php' || $cur_page == 'package-add.php' || $cur_page == 'package-edit.php') { echo 'active'; } ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>package-view.php"><i class="fas fa-hand-point-right"></i> <span>Packages</span></a></li>

        <!--
        <li class="<?php if($cur_page == 'form.php') { echo 'active'; } ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>form.php"><i class="fas fa-hand-point-right"></i> <span>Form</span></a></li>

        <li class="<?php if($cur_page == 'table.php') { echo 'active'; } ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>table.php"><i class="fas fa-hand-point-right"></i> <span>Table</span></a></li>

        <li class="<?php if($cur_page == 'invoice.php') { echo 'active'; } ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>invoice.php"><i class="fas fa-hand-point-right"></i> <span>Invoice</span></a></li>
        -->

    </ul>
  </aside>
</div>