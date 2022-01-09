<?php

    echo '<div class="container">';

    echo "<div class='col-12 mb-2 '>";
    echo "<h1 class='m-2'>Order #".$order->orderNumber."'s Details</h1>";
                    echo '<div class="card">';
                    
                    echo '<div class="card-header">';
                    echo "<h5 class='card-title'><span class=''><a href='".base_url().'/amendorderdetails/'.$order->orderNumber."'>Amend Order Details</a></span><span class='float-right'><span class='font-weight-bold'>Status: </span> ";
                    switch($order->status)
                    {
                        case "Shipped":
                            echo "<span class='text-success'>".$order->status."</span></span></h5>";
                            break;
                        case "In Process":
                            echo "<span class='text-warning'>".$order->status."</span></span></h5>";
                            break;
                    }
                    echo '<ul class="list-group list-group-flush">';
                    echo ' <li class="list-group-item"><span class="font-weight-bold">Order Date:</span> '.$order->orderDate.'</li>';
                    echo '<li class="list-group-item"><span class="font-weight-bold">Required Date:</span> '.$order->requiredDate.'</li>';
                    echo '<li class="list-group-item"><span class="font-weight-bold">Shipped Date:</span> '.$order->shippedDate.'</li>';
                    echo '</ul>';
                    
                    echo '</div>';
                    echo '</div>';

    echo "<h1 class='m-2'>Products on Order #".$order->orderNumber."</h1>";        
    echo '</div>';


    echo '<div class="card-deck">';
    for($i = 0; $i < count($products); $i++)
    {
        
        echo "<div class='col-md-4'>";
                    echo '<div class="card">';

                    echo '<img class="card-img-top" src="'.base_url().'/assets/images/products/full/'.$products[$i]->photo.'" alt="Card image cap">';
                    echo '<div class="card-header">';
                    echo "<h5 class='card-title'><span class='font-weight-bold'>".$products[$i]->description." </span> </h5>";
                    echo '<h6 class="card-subtitle mb-2 text-muted">Category: '.$products[$i]->category.'  </h6>';
                    echo '</div>';
                    echo '<div class="card-body">';
                   
                    echo '<h6 class="card-text pb-0 mb-0"><span class="font-weight-bold">Quantity:</span> '.$order_details[$i]->quantityOrdered.' <span class="float-right"><span class="font-weight-bold">Price: </span>'.$order_details[$i]->priceEach.'</span></h6>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
        
    }
    echo '</div>';
    echo '</div>';
    echo '</div>';
?>