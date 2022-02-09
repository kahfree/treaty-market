<div class="container">

    <h1>All Products in The Database</h1>
    <?php if (session()->get('success')): ?>
                    <div class="alert alert-success col-md-6 offset-3 text-center" role="alert">
                        <?= session()->get('success') ?>
                    </div>
                <?php endif; ?>
                
                <?php if (session()->get('error')): ?>
                    <div class="alert alert-danger col-md-6 offset-3 text-center" role="alert">
                        <?= session()->get('error') ?>
                    </div>
                <?php endif; ?>
                <form class="d-flex input-group w-50 offset-3 mb-4 mt-4" action="<?php echo base_url();?>/viewproducts" method="post">
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
                    <a href="<?php echo base_url(); ?>/viewproducts">Clear</a>
                    </button>
                </form>
    <a href="<?php echo base_url()?>/addproduct"><button class="btn btn-success float-right m-1">Add a Product</button></a>
<?php
echo '<table class="table table-striped col-12">';
echo '<tr><th>Produce Code</th><th>Description</th><th>Category</th><th>Supplier</th><th>Quantity</th><th>Buy Price</th><th>Sell Price</th><th>Photo</th><th>Options</th></tr>';



for($i = 0; $i < count($product_data); $i++){
    echo '<tr>';
    echo '<td>'.$product_data[$i]->produceCode.'</td>';
    echo '<td>'.$product_data[$i]->description.'</td>';
    echo '<td>'.$product_data[$i]->category.'</td>';
    echo '<td>'.$product_data[$i]->supplier.'</td>';
    echo '<td>'.$product_data[$i]->quantityInStock.'</td>';
    echo '<td>'.$product_data[$i]->bulkBuyPrice.'</td>';
    echo '<td>'.$product_data[$i]->bulkSalePrice.'</td>';
    echo '<td><img class="card-img-top" src="'.base_url().'/assets/images/products/thumbs/'.$product_data[$i]->photo.'" alt="Card image cap"></td>';
    echo '<td><p class="m-1"><a href="'.base_url().'/removeproduct/'.$product_data[$i]->produceCode.'/" style="text-decoration: none;"><button type="button" class="btn btn-outline-danger btn-sm btn-block">Remove</button></a></p>';
    echo '<p class="m-1"><a href="'.base_url().'/editproduct/'.$product_data[$i]->produceCode.'/" style="text-decoration: none;"><button type="button" class="btn btn-outline-warning btn-sm btn-block">Edit</button></a></p>';
    echo '<p class="m-1"><a href="'.base_url().'/browseproducts/'.$product_data[$i]->produceCode.'/" style="text-decoration: none;"><button type="button" class="btn btn-outline-primary btn-sm btn-block">View</button></a></p>';
    echo '</td></tr>';
}
echo '</table>';
?>
</div>