<div class="container">
<?php 
use App\Helpers\HelperTable;
$session = session();
if($session->get('loggedIn')){
        echo "<h1>Welcome home ".$session->get('firstname')."</h1>";
        ?>
        <div class="container">
            <div class="row">
            <img class="mx-auto" src="<?=base_url()?>\assets\images\site\logo2.png" alt="Card image cap">
            </div>
        <div class="row">  
            <div class="col-md-4">
            <a href="<?=base_url()?>/browseproducts">
                <div class="card">
                    <h3 class="card-header">Browse</h3>
                    <img class="card-img p-1" src="<?=base_url()?>/assets/images/products/full/carrots.jpg" alt="Card image cap">
                    </a>
                    <p class="card-subtitle p-4">Browse our tasteful range</p>       
                </div>
            </div>
            <div class="col-md-4">
            <a href="<?=base_url()?>/wishlist" style="text-decoration: none;">
                <div class="card">
                    <h3 class="card-header">Wishlist</h3>
                    <img class="card-img p-1" src="<?=base_url()?>\assets\images\site\wishlist.jpg" alt="Card image cap">
                    </a>
                    <p class="card-subtitle p-4">What have you been wishing for lately?</p>
                           
                </div>
                
            </div>
            <div class="col-md-4">
            <a href="<?=base_url()?>/orders">
                <div class="card">
                    <h3 class="card-header">Orders</h3>
                    <img class="card-img p-1" src="<?=base_url()?>\assets\images\site\order.jpg" alt="Card image cap">
                    </a>
                    <p class="card-subtitle p-4">Check up on how your orders are doing</p>       
                </div>
            </div>
        </div>
        
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
<?php }
else
    redirect()->to(base_url() + '/')

?>
</div>