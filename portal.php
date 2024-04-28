
<style>
	header.masthead{
		background-image: url('<?php echo validate_image($_settings->info('cover')) ?>') !important;
	}
	header.masthead .container{
		background:#0000006b;
	}
</style>
<!-- Masthead-->
<style>
   <!-- Nunito Sans Font -->
<style>
    /* Import the Nunito Sans font */
    @import url('https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&display=swap');

    /* Apply styles to the masthead */
    header.masthead {
        background-color: #2e7d32; /* Green background */
        padding: 100px 0; /* Adjust padding as needed */
        text-align: center;
    }

    /* Style the masthead headings with Nunito Sans */
    .masthead-subheading, .masthead-heading {
        font-family: 'Nunito Sans', sans-serif; /* Use Nunito Sans font */
        color: #fff; /* White text color */
        margin-bottom: 20px; /* Adjust margin as needed */
    }

    /* Style the View Tours button with Nunito Sans */
    .btn.btn-success.btn-xl.text-uppercase {
        font-family: 'Nunito Sans', sans-serif; /* Use Nunito Sans font */
        background-color: #4caf50; /* Green button color */
        border-color: #4caf50; /* Green button border color */
        color: #fff; /* White text color */
        padding: 10px 20px; /* Adjust padding as needed */
        font-size: 20px; /* Adjust font size as needed */
        transition: background-color 0.3s, border-color 0.3s, color 0.3s; /* Add smooth transition */
    }

    .btn.btn-success.btn-xl.text-uppercase:hover {
        background-color: #388e3c; /* Darker green on hover */
        border-color: #388e3c; /* Darker green border on hover */
    }
</style>

<!-- Masthead -->
<header class="masthead">
    <div class="container">
        <div class="masthead-subheading">Welcome To Farm de Leticia Website</div>
        <a class="btn btn-success btn-xl text-uppercase" href="#home" style="background-color: #4CAF50; border-color: #4CAF50; box-shadow: 0 8px #3E9142; transition: background-color 0.3s, border-color 0.3s, box-shadow 0.3s; text-shadow: 0 2px 2px rgba(0, 0, 0, 0.3);">Visit Packages</a>
    </div>
</header>

<!-- Services -->
<section class="page-section" id="home" style="background-color: #F5F5F5; padding: 50px 0;">
    <div class="container">
        <h2 class="text-center" style="font-family: 'Nunito Sans', sans-serif; color: #000;">Packages</h2>
        <div class="d-flex w-100 justify-content-center">
            <hr class="border-warning" style="border: 3px solid; width: 15%;">
        </div>
        <!-- Tour Packages -->
        <div class="row mt-4" id="tour-packages">
            <?php
            $packages = $conn->query("SELECT * FROM `packages` ORDER BY RAND() LIMIT 3");
            while($row = $packages->fetch_assoc()):
                $cover='';
                if(is_dir(base_app.'uploads/package_'.$row['id'])){
                    $img = scandir(base_app.'uploads/package_'.$row['id']);
                    $k = array_search('.',$img);
                    if($k !== false)
                        unset($img[$k]);
                    $k = array_search('..',$img);
                    if($k !== false)
                        unset($img[$k]);
                    $cover = isset($img[2]) ? 'uploads/package_'.$row['id'].'/'.$img[2] : "";
                }
                $row['description'] = strip_tags(stripslashes(html_entity_decode($row['description'])));
                $review = $conn->query("SELECT * FROM `rate_review` WHERE package_id='{$row['id']}'");
                $review_count = $review->num_rows;
                $rate = 0;
                while($r= $review->fetch_assoc()){
                    $rate += $r['rate'];
                }
                if($rate > 0 && $review_count > 0)
                    $rate = number_format($rate/$review_count,0,"");
            ?>
            <div class="col-md-4 mb-4">
                <div class="card rounded-0">
                    <img class="card-img-top" src="<?php echo validate_image($cover) ?>" alt="<?php echo $row['title'] ?>" style="object-fit: cover; height: 200px;">
                    <div class="card-body">
                        <h5 class="card-title truncate-1 w-100" style="font-family: 'Nunito Sans', sans-serif;"><?php echo $row['title'] ?></h5>
                        <div class="stars stars-small">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <input disabled class="star star-<?php echo $i ?>" id="star-<?php echo $i ?>" type="radio" name="star" <?php echo $rate == $i ? "checked" : '' ?>>
                                <label class="star star-<?php echo $i ?>" for="star-<?php echo $i ?>"></label>
                            <?php endfor; ?>
                        </div>
                        <p class="card-text truncate"><?php echo $row['description'] ?></p>
                        <div class="d-flex justify-content-end">
                           <a href="./?page=view_package&id=<?php echo md5($row['id']) ?>" class="btn btn-success btn-flat btn-warning" style="background-color: #4CAF50; border-color: #4CAF50; box-shadow: 0 4px #3E9142; transition: background-color 0.3s, border-color 0.3s, box-shadow 0.3s;">View Package <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <!-- Search Bar -->
        <div class="row mt-4">
            <div class="col-md-6 offset-md-3">
                <form id="search-form">
                    <div class="input-group">
                        <input type="text" class="form-control" id="search-input" placeholder="Search for packages..." aria-label="Search for packages..." aria-describedby="search-button">
                        <button class="btn btn-warning" type="submit" id="search-button" style="background-color: #FFC107; border-color: #FFC107; box-shadow: 0 4px #FFA000; transition: background-color 0.3s, border-color 0.3s, box-shadow 0.3s;">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    // Immediate search functionality using JavaScript
    document.getElementById('search-form').addEventListener('submit', function(e) {
        e.preventDefault();
        var searchInput = document.getElementById('search-input').value.toLowerCase();
        var packages = document.getElementById('tour-packages').getElementsByClassName('card-title');
        for (var i = 0; i < packages.length; i++) {
            var title = packages[i].innerText.toLowerCase();
            if (title.indexOf(searchInput) > -1) {
                packages[i].closest('.col-md-4').style.display = '';
            } else {
                packages[i].closest('.col-md-4').style.display = 'none';
            }
        }
    });
</script>

<!-- About-->
<section class="page-section" id="about" style="background-color: #4CAF50;">
    <div class="container">
        <div class="text-center">
            <h2 class="section-heading text-uppercase">About Us</h2>
        </div>
        <div>
            <div class="card w-100">
                <div class="card-body">
                    <?php echo file_get_contents(base_app.'about.html') ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Location Map -->
<section class="page-section" id="location-map">
    <div class="container">
        <div class="text-center">
            <h2 class="section-heading text-uppercase">Location</h2>
            <h3 class="section-subheading text-muted">Find us on the map.</h3>
        </div>
        <!-- Google Maps Embed -->
        <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="https://www.google.com/maps/embed?pb=!1m28!1m12!1m3!1d11485.488333386825!2d124.4298398689453!3d7.191224601307978!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m13!3e6!4m5!1s0x32693819d8642e67%3A0x9c538f4e982487b7!2s7.1958528%2C%20124.4626944!3m2!1d7.1958528!2d124.4626944!4m5!1s0x3269396e14a5d793%3A0x6d0c27255b2c0135!2s7.1884519%2C%20124.5626134!3m2!1d7.1884519!2d124.5626134!5e0!3m2!1sen!2sus!4v1649012790047!5m2!1sen!2sus" allowfullscreen></iframe>
        </div>
    </div>
</section>
<script>
$(function(){
	$('#contactForm').submit(function(e){
		e.preventDefault()
		$.ajax({
			url:_base_url_+"classes/Master.php?f=save_inquiry",
			method:"POST",
			data:$(this).serialize(),
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("an error occured",'error')
				end_loader()
			},
			success:function(resp){
				if(typeof resp == 'object' && resp.status == 'success'){
					alert_toast("Inquiry sent",'success')
					$('#contactForm').get(0).reset()
				}else{
					console.log(resp)
					alert_toast("an error occured",'error')
					end_loader()
				}
			}
		})
	})
})
</script>