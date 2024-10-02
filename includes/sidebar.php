 <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item border-bottom">
            <a href="dashboard" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt mr-3 text-success"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item border-bottom">
            <a href="admin_profile" class="nav-link">
              <i class="bi bi-person mr-4 text-success"></i>
              <p>
                Profile
              </p>
            </a>
          </li>
          <li class="nav-item border-bottom">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy mr-3 text-success"></i>
              <p>
                Add
                <i class="fas fa-angle-left mr-3 right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item border-bottom">
                <a href="admin_signup" class="nav-link">
                  <i class="bi bi-person-plus mr-2 text-success"></i>
                  <p>Add Admin</p>
                </a>
              </li>
              <!-- <li class="nav-item border-bottom">
                <a href="add_faculty" class="nav-link">
                  <i class="bi bi-book mr-2 text-success"></i>
                  <p>Add Faculty</p>
                </a>
              </li> -->
              <li class="nav-item border-bottom">
                <a href="add_program" class="nav-link">
                  <i class="bi bi-award mr-2 text-success"></i>
                  <p>
                    Add Program
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item border-bottom">
            <a href="manage_faculty_&_program" class="nav-link">
              <i class="bi bi-gear mr-3 text-success"></i>
              <p>
                Manage
              </p>
            </a>
          </li>
          <li class="nav-item border-bottom">
            <a class="nav-link" href="applications">
              <i class="bi bi-list-check mr-3 text-success"></i>
              <p>
                Applications
              </p>
            </a>
          </li>
          <li class="nav-item border-bottom">
            <a href="approved_applicants" class="nav-link">
              <i class="bi bi-building-check mr-3 text-success"></i>
              <p>
                Approved
              </p>
            </a>
          </li>
          <li class="nav-item border-bottom">
            <a href="rejected_applicants" class="nav-link">
              <i class="bi bi-building-x mr-3 text-success"></i>
              <p>
                Rejected
              </p>
            </a>
          </li>
          <li class="nav-item border-bottom">
            <a href="undicided_applicants" class="nav-link">
              <i class="bi bi-person-plus mr-3 text-success"></i>
              <p>
                Transfer Request
              <i class="badge badge-danger text-white"><?=$total_counts?></i>
              </p>
            </a>
          </li>
          <li class="nav-item border-bottom">
            <a href="../logout" class="nav-link">
              <i class="bi bi-person-circle mr-3 text-success"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->