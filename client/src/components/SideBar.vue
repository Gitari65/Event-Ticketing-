<template>
    <div class="main-container d-flex">
      <div class="sidebar" id="side_nav" :class="{ active: isSidebarActive }">
        <div class="header-box px-2 pt-3 pb-4 d-flex justify-content-between">
          <h1 class="fs-4">
            <span class="bg-white text-dark rounded shadow px-2 me-2">
                <a class="navbar-brand" href="#"><img src="../assets/images/ticketlogo1.png" class="logo" alt="logo"/></a>
            </span>
        
          </h1>
          <button class="btn d-md-none d-block close-btn px-1 py-0 text-white" @click="toggleSidebar">close<i class="fal fa-stream"></i></button>
        </div>
        <ul class="list-unstyled px-2">
          <li :class="{ active: activeTab === 'dashboard' }" @click="activateTab('dashboard')">
            <a href="#" class="text-decoration-none px-3 py-2 d-block">
              <i class="fal fa-home"></i> Dashboard
            </a>
          </li>
          <li class=""><a href="#" class="text-decoration-none px-3 py-2 d-block"><i class="fal fa-list"></i>
                        Projects</a></li>
                        <li class=""><a href="#" class="text-decoration-none px-3 py-2 d-block"><i
                            class="fal fa-envelope-open-text"></i> Services</a></li>
                <li class=""><a href="#" class="text-decoration-none px-3 py-2 d-block"><i class="fal fa-users"></i>
                        messages</a></li>
                <li class=""><a href="#" class="text-decoration-none px-3 py-2 d-block"><i
                            class="fal fa-envelope-open-text"></i> Services</a></li>
                <li class=""><a href="#" class="text-decoration-none px-3 py-2 d-block"><i class="fal fa-users"></i>
                        Customers</a></li>
           
            <hr class="h-color mx-2">
          <!-- Add other list items here -->
        </ul>
        <hr class="h-color mx-2">
        <ul class="list-unstyled px-2">
          <!-- Add more list items here -->
        </ul>
      </div>
      <div class="content">
        <nav class="navbar navbar-expand-md navbar-light bg-light">
          <!-- Navbar content -->
        </nav>
        <!-- <div class="dashboard-content px-3 pt-4">
          <h2 class="fs-5">Dashboard</h2>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum, totam? Sequi alias eveniet ut quas
            ullam delectus et quasi incidunt rem deserunt asperiores reiciendis assumenda doloremque provident,
            dolores aspernatur neque.</p>
        </div> -->
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        isSidebarActive: false,
        activeTab: 'dashboard'
      };
    },
    methods: {
      toggleSidebar() {
        this.isSidebarActive = !this.isSidebarActive;
      },
      activateTab(tabName) {
        this.activeTab = tabName;
      }
    }
  };
  </script>
  

  
<style >
body{
 background: #eee;
}

#side_nav{
 background: #07407b;
 min-width: 250px;
 max-width: 250px;
 transition: all 0.3s;
}
#side_nav .logo{
    height:60px;
}

.content{
   min-height: 100vh;
   width: 100%;
}
hr.h-color{
  background: #eee;
}

.sidebar li.active{
   background: #eee;
   border-radius: 8px;
}

.sidebar li.active a, .sidebar li.active a:hover {
 color: #000;
}
.sidebar li a{
 color: #fff;
}

@media(max-width: 767px){
 #side_nav{
   margin-left: -250px;
   position: absolute;
   min-height: 100vh;
   z-index: 1;

 }
 #side_nav.active{
   margin-left: 0;
  }
}

</style>