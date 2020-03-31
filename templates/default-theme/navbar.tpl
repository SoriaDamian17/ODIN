<header id="topnav">
  <div class="topbar-main">
      <div class="container">

          <!-- LOGO -->
          <div class="topbar-left" data-link="true" data-controller="AdminAccess" data-token="{$tools->getToken('AdminAccess')}">
              <a href="#" class="logo">
                  <i class="zmdi zmdi-group-work icon-c-logo"></i>
                  <span>Odin</span>
              </a>
              <!-- Mobile menu toggle-->
                <a href="#" id="c-button--slide-left" class="navbar-toggle c-button">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </a>
                <!-- End mobile menu toggle-->
          </div>
          <!-- End Logo container-->


          <div class="menu-extras">

              <ul class="nav navbar-nav pull-right">
                  <li class="nav-item">
                      <!-- slide Manteinace-->
                      <div class="btn-maintenance">
                        <a href="#" title="Modo Mantenimiento">
                            <input type="checkbox"  data-size="small",data-size="large" data-plugin="switchery" data-color="#3db9dc" name="maintenance"/>
                            <span>Mantenimiento</span>
                        </a>
                      <div>
                      <!-- End slide Manteinace-->
                  </li>                 

                  <li class="nav-item dropdown notification-list">
                      <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                          <i class="zmdi zmdi-notifications-none noti-icon"></i>
                          <span class="noti-icon-badge"></span>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-lg" aria-labelledby="Preview">
                          <!-- item-->
                          <div class="dropdown-item noti-title">
                              <h5><small><span class="label label-danger pull-xs-right">7</span>Notificaciones</small></h5>
                          </div>

                          <!-- item-->
                          <a href="javascript:void(0);" class="dropdown-item notify-item">
                              <div class="notify-icon bg-success"><i class="icon-bubble"></i></div>
                              <p class="notify-details">Robert S. Taylor commented on Admin<small class="text-muted">1min ago</small></p>
                          </a>

                          <!-- item-->
                          <a href="javascript:void(0);" class="dropdown-item notify-item">
                              <div class="notify-icon bg-info"><i class="icon-user"></i></div>
                              <p class="notify-details">New user registered.<small class="text-muted">1min ago</small></p>
                          </a>

                          <!-- item-->
                          <a href="javascript:void(0);" class="dropdown-item notify-item">
                              <div class="notify-icon bg-danger"><i class="icon-like"></i></div>
                              <p class="notify-details">Carlos Crouch liked <b>Admin</b><small class="text-muted">1min ago</small></p>
                          </a>

                          <!-- All-->
                          <a href="javascript:void(0);" class="dropdown-item notify-item notify-all">
                              View All
                          </a>

                      </div>
                  </li>

                  <li class="nav-item dropdown notification-list">
                      <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                          <i class="zmdi zmdi-email noti-icon"></i>
                          <span class="noti-icon-badge"></span>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-arrow-success dropdown-lg" aria-labelledby="Preview">
                          <!-- item-->
                          <div class="dropdown-item noti-title bg-success">
                              <h5><small><span class="label label-danger pull-xs-right">7</span>Mensajes</small></h5>
                          </div>

                          <!-- item-->
                          <a href="javascript:void(0);" class="dropdown-item notify-item">
                              <div class="notify-icon bg-faded">
                                  <img src="templates/{$theme}/images/users/avatar-2.jpg" alt="img" class="img-circle img-fluid">
                              </div>
                              <p class="notify-details">
                                  <b>Robert Taylor</b>
                                  <span>New tasks needs to be done</span>
                                  <small class="text-muted">1min ago</small>
                              </p>
                          </a>

                          <!-- item-->
                          <a href="javascript:void(0);" class="dropdown-item notify-item">
                              <div class="notify-icon bg-faded">
                                  <img src="templates/{$theme}/images/users/avatar-3.jpg" alt="img" class="img-circle img-fluid">
                              </div>
                              <p class="notify-details">
                                  <b>Carlos Crouch</b>
                                  <span>New tasks needs to be done</span>
                                  <small class="text-muted">1min ago</small>
                              </p>
                          </a>

                          <!-- item-->
                          <a href="javascript:void(0);" class="dropdown-item notify-item">
                              <div class="notify-icon bg-faded">
                                  <img src="templates/{$theme}/images/users/avatar-4.jpg" alt="img" class="img-circle img-fluid">
                              </div>
                              <p class="notify-details">
                                  <b>Robert Taylor</b>
                                  <span>New tasks needs to be done</span>
                                  <small class="text-muted">1min ago</small>
                              </p>
                          </a>

                          <!-- All-->
                          <a href="javascript:void(0);" class="dropdown-item notify-item notify-all">
                              View All
                          </a>

                      </div>
                  </li>

                  <li class="nav-item dropdown notification-list">
                      <a class="nav-link waves-effect waves-light right-bar-toggle" href="javascript:void(0);">
                          <i class="zmdi zmdi-format-subject noti-icon"></i>
                      </a>
                  </li>

                  <li class="nav-item dropdown notification-list">
                      <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                          <img src="templates/{$theme}/images/users/avatar-1.jpg" alt="user" class="img-circle">
                      </a>
                      <div class="dropdown-menu dropdown-menu-right dropdown-arrow profile-dropdown " aria-labelledby="Preview">
                          <!-- item-->
                          <div class="dropdown-item noti-title">
                              <h5 class="text-overflow"><small>Welcome ! John</small> </h5>
                          </div>

                          <!-- item-->
                          <a href="javascript:void(0);" class="dropdown-item notify-item">
                              <i class="zmdi zmdi-account-circle"></i> <span>Profile</span>
                          </a>

                          <!-- item-->
                          <a href="javascript:void(0);" class="dropdown-item notify-item">
                              <i class="zmdi zmdi-settings"></i> <span>Settings</span>
                          </a>

                          <!-- item-->
                          <a href="javascript:void(0);" class="dropdown-item notify-item">
                              <i class="zmdi zmdi-lock-open"></i> <span>Lock Screen</span>
                          </a>

                          <!-- item-->
                          <a href="javascript:void(0);" class="dropdown-item notify-item">
                              <i class="zmdi zmdi-power"></i> <span>Logout</span>
                          </a>

                      </div>
                  </li>

              </ul>

          </div> <!-- end menu-extras -->

          <div class="clearfix"></div>

      </div> <!-- end container -->
  </div>
  <!-- end topbar-main -->
  <div class="navbar-custom active">
      <div class="container">
          <div id="navigation" class="active">
              {include file='templates/default-theme/menu.tpl'}
          </div>
      </div>
  </div>
</header>
