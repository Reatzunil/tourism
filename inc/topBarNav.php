 <!-- Navigation-->
 <style>
    /* Import the Nunito Sans font */
    @import url('https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&display=swap');

    /* Styling for the navbar-brand */
    .navbar-brand .text-waring {
        font-family: 'Nunito Sans', sans-serif; /* Use Nunito Sans font */
        color: #fff !important; /* White text color */
    }
</style>


<!-- Navigation bar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-shrink" id="mainNav">
    <div class="container-fluid">
        <a class="navbar-brand" href="#page-top"><span class="text-waring">Farm de Leticia</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars ms-1"></i>
        </button>
        <!-- Other navbar content -->
    

                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                        <li class="nav-item"><a class="nav-link" href="<?php echo $page !='home' ? './':''  ?>">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="./?page=packages">Packages</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo $page !='home' ? './':''  ?>#about">About</a></li>
                        <?php if(isset($_SESSION['userdata'])): ?>
                          <li class="nav-item"><a class="nav-link" href="./?page=my_account"><i class="fa fa-user"></i> Hi, <?php  echo $_settings->userdata('firstname') ?>!</a></li>
                          <li class="nav-item"><a class="nav-link" href="logout.php"><i class="fa fa-sign-out-alt"></i></a></li>
                        <?php else: ?>
                          <li class="nav-item"><a class="nav-link" href="javascript:void(0)" id="login_btn">Login</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
</div>
</nav>
<script>
  $(function(){
    $('#login_btn').click(function(){
      uni_modal("","login.php","large")
    })
    $('#navbarResponsive').on('show.bs.collapse', function () {
        $('#mainNav').addClass('navbar-shrink')
    })
    $('#navbarResponsive').on('hidden.bs.collapse', function () {
        if($('body').offset.top == 0)
          $('#mainNav').removeClass('navbar-shrink')
    })
  })
</script>