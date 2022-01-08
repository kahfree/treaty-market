<?php
echo '<div class="container justify-content-md-center mx-auto">';
echo '<h1>All of '.session()->get('firstname').'\'s orders</h1>';
    foreach($customer_orders as $order)
    {
        
        echo "<div class='col-12 mb-2 '>";
                    echo '<div class="card">';
                    
                    echo '<div class="card-header">';
                    echo "<h5 class='card-title'><span class='font-weight-bold'>Order #".$order->orderNumber." </span> <span class='float-right'><span class='font-weight-bold'>Status: </span> ";
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
                    echo '<div class="card-body p-2">';
                   
                    echo '<h6 class="card-text pb-0 mb-0"><a href="'.base_url().'/orderdetails/'.$order->orderNumber.'">View Details</a> <span class="float-right"><a href="">Amend</a></span></h6>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
        
    }
    echo '</div>';
echo '</div>';
echo '</div>';
?>