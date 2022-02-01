<div class="container" style="">
    <h1 class="text-center col-12">Every product in the database</h1>
    <?php if(session()->get('userType') == 'Client'): ?>
    <a href="<?=base_url()?>/generateWorkout"><input type="button" class="btn btn-success mb-3" value="Generate Custom Workout"></a>
    <?php endif; ?>

    <?php if(session()->get('userType') == 'Moderator'): ?>
    <a href="<?=base_url()?>/addWorkout"><input type="button" class="btn btn-success mb-3" value="Add Workout"></a>
    <?php endif; ?>
    <div class="row">
    
                <?php if (session()->get('wishlist-add')): ?>
                    <div class="alert alert-success col-md-6 offset-3 text-center" role="alert">
                        <?= session()->get('wishlist-add') ?>
                    </div>
                <?php endif; ?>
                
                <?php if (session()->get('cart-add')): ?>
                    <div class="alert alert-success col-md-6 offset-3 text-center" role="alert">
                        <?= session()->get('cart-add') ?>
                    </div>
                <?php endif; ?>
                <?php if (session()->get('cart-remove')): ?>
                    <div class="alert alert-danger col-md-6 offset-3 text-center" role="alert">
                        <?= session()->get('cart-remove') ?>
                    </div>
                <?php endif; ?>
                <form class="d-flex input-group w-50 offset-3 mb-4 mt-4" action="<?php echo base_url();?>/browseproducts" method="post">
                    <input
                    type="search"
                    class="form-control"
                    placeholder="Product name"
                    aria-label="Search"
                    name="key"
                    value="<?= set_value('key',$key) ?>"
                    />
                    <button
                    class="btn btn-outline-primary"
                    type="submit"
                    data-mdb-ripple-color="dark"
                    >
                    Search
                    </button>
                    <button
                    class="btn btn-outline-warning"
                    type="submit"
                    data-mdb-ripple-color="dark"
                    >
                    <a href="<?php echo base_url(); ?>/browseproducts">Clear</a>
                    </button>
                </form>
            <?php
                //echo '<div class="row justify-content-md-center">';
                //echo '<div class="container"';
                echo '<div class="card-deck">';
    foreach($product_data->getResult() as $row)
    {
        
        echo "<div class='col-md-4'>";
                    echo '<div class="card">';

                    echo '<img class="card-img-top" src="'.base_url().'/assets/images/products/full/'.$row->photo.'" alt="Card image cap">';
                    echo '<div class="card-header">';
                    echo "<h5 class='card-title'>$row->description</h5>";
                    echo "<p class='card-subtitle'>Supplied by $row->supplier</p>";
                    echo "<p class='card-subtitle pt-3 font-weight-bold'>Price: €$row->bulkSalePrice</p>";
                    echo '</div>';
                    echo '<div class="card-body">';
                    echo '<form class="" action="'.base_url().'/addToCart/'.$row->produceCode.'/" method="get">';
                    echo '<div class="row justify-content-md-center">';
                    echo '<input type="submit" class="btn btn-primary" name="submit" value="Add to cart">';
                    if(!(in_array($row->produceCode,$productsOnWishlist)))
                        echo '<a href="'.base_url().'/addToWishlist/'.$row->produceCode.'/" class="btn btn-warning ">Add to wishlist</a>';
                    echo '</div>';
                    echo '<div class="row mt-2 justify-content-md-left">';
                    echo '<label for="quantity" class="ml-3">Quantity:</label>';
                    echo '<input class="col-md-3 p-1 ml-1" type="number" name="quantity" id="quantity" min="1" max="'.$row->quantityInStock.'">';
                    echo '<a href="'.base_url().'/browseproducts/'.$row->produceCode.'" class="btn btn-info ml-1">View</a>';
                    echo '</div>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
        
    }
    echo '</div>';
    echo '</div>';
    echo '</div>';
                //echo '</div>';
            ?>
            
        </div>
</div> 