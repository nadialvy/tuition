<template>
    <div id="wrapper">
      <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion navbar-default" id="accordionSidebar">
          <!-- Sidebar - Brand -->
          <a class="sidebar-brand d-flex align-items-center justify-content-center navbar-default" href="index.html">
              <div class="sidebar-brand-icon">
                  <!-- <i class="fas fa-laugh-wink"></i> -->
                  <img src="../assets/logo-fix.png" alt="" width="130" height="auto">
              </div>
              <!-- <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div> -->
          </a>

          <!-- Divider -->
          <hr class="sidebar-divider my-0">

          <!-- Nav Item - Tables -->
          <router-link to="/dashboard">
            <li class="nav-item">
                <a class="nav-link">
                    <i class="bi bi-speedometer"></i>
                    <span>Dashboard</span></a>
            </li>
          </router-link>

          <router-link to="/student">
            <li class="nav-item">
                <a class="nav-link custom">
                    <i class="bi bi-person-fill"></i>
                    <span>Student</span></a>
            </li>
          </router-link>

          <router-link to="/officer">
            <li class="nav-item">
                <a class="nav-link custom">
                    <i class="bi bi-person-fill"></i>
                    <span>Officer</span></a>
            </li>
          </router-link>

          <router-link to="/grade">
            <li class="nav-item custom">
                <a class="nav-link">
                     <i class="bi bi-file-bar-graph-fill"></i>
                    <span>Grade</span></a>
            </li>
          </router-link>

          <router-link to="/tuition">
            <li class="nav-item custom">
                <a class="nav-link">
                    <i class="fas fa-money-bill"></i>
                    <span>Tuition</span></a>
            </li>
          </router-link>

        <router-link to="/payment">
            <li class="nav-item custom">
                <a class="nav-link">
                    <i class="bi bi-wallet-fill"></i>
                    <span>Payment</span></a>
            </li>
        </router-link>

      </ul>
      
      <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
          <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow ">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Search -->
                <form
                    class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                            aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                    <li class="nav-item dropdown no-arrow d-sm-none">
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-search fa-fw"></i>
                        </a>
                        <!-- Dropdown - Messages -->
                        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                            aria-labelledby="searchDropdown">
                            <form class="form-inline mr-auto w-100 navbar-search">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light border-0 small"
                                        placeholder="Search for..." aria-label="Search"
                                        aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{this.user_name}} - {{this.user_type}}</span>
                            <img class="img-profile rounded-circle"
                                src="img/undraw_profile.svg">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                Settings
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                Activity Log
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal" @click="Logout">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>

                </ul>

            </nav>
            <!-- End of Topbar -->
            
            <!-- COTENT IS HERE  -->
          <div class="container-fluid">
                <router-view></router-view>
          </div>
        </div>
      </div>
    </div>
</template>

<script>

export default{
    name: 'template-component',
    data(){
        return{
            user_name: '',
            user_type: '',
        }
    },
    methods: {
        Logout(){
            this.$store.commit('logout')
            this.$router.push('/login')
        },
        getUserName(){
            this.user_name = localStorage.getItem('user_name')
        },
        getUserType(){
            this.user_type = localStorage.getItem('user_type')
        }
    },
    mounted(){
        this.getUserName()
        this.getUserType()
    }
}
</script>

<style scoped>
    .custom{
        margin-top: -30px;
    }
</style>
