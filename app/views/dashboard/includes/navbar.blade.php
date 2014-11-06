<div class="wrapper" >
<nav class="navbar navbar-success navbar-fixed-top nav-bg" role="navigation">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand logo-sm" href="/">
      </a> 
      <!-- <a class="navbar-brand logo-text" href="/">
      	<font size="6" color="white"><b> ualimeds</b></font>
      </a> -->
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse navbar-align" id="bs-example-navbar-collapse-1">
   
      <ul class="nav navbar-nav navbar-right">

        <li class="dropdown" >
          <a class="dropdown-toggle"  id="dropdownMenu1" data-toggle="dropdown" >
            {{Auth::user()->username}}
            </a>
       <!--      <ul class="dropdown-menu side-dropdown" role="menu" aria-labelledby="dropdownMenu1" >
              <li>
                <a href="#" >
                    <i class="fa fa-tachometer"></i> Dashboard
                  </a>
              </li>
              <li>
                  <a href="#" >
                    <span class="glyphicon glyphicon-user"></span> Account
                  </a>
              </li>
              <li  class="divider"></li>
              <li>
                  <a href="/logout" ><span class="glyphicon glyphicon-log-out"></span> Logout</a>
              </li>
            </ul> -->

        </li>
        <li  class="divider-vertical"></li>
        <li>
         <a href="#" data-toggle="popover" data-placement="bottom"
        data-content="Settings"
       class="red-tooltip pops"><i class="fa fa-gear"></i></a>
        </li>
        <li>
         <a href="/logout" data-toggle="tooltip" data-placement="bottom"
       title=""  data-content="Logout"
       class="red-tooltip pops"><i class="fa fa-sign-out"></i></a>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</div>
