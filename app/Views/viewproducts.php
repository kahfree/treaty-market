<div class="container">

    <h1>All Products in The Database</h1>
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
    echo '<td><p><a href="'.base_url().'/removeproduct/'.$product_data[$i]->produceCode.'/">Remove</a></p>';
    echo '<p><a href="'.base_url().'/editproduct/'.$product_data[$i]->produceCode.'/">Edit</a></p>';
    echo '</td></tr>';
}
echo '</table>';
?>
</div>