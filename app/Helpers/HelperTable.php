<?php
namespace App\Helpers;
Class HelperTable {
    
    
    
   
    public static function generateTABLE($resultSet){
        //This STATIC method returns a HTML table as a string
        //It takes one argument - $resultSet which must contain an object
        //of the $resultSet class
        $table='';  //start with an empty string
        
        //generate the HTML table
        $i=0;
        $resultSet->data_seek(0);  //point to the first row in the result set
        $table.= '<table border="1">';
        while ($row = $resultSet->fetch_assoc()) {  //fetch associative array
            while ($i===0)  //trick to generate the HTML table headings
            {   $table.=  '<tr>';
                foreach($row as $key=>$value){
                    $table.=  "<th>$key</th>"; //echo the keys as table headings for the first row of the HTML table
                }
                $table.=  '</tr>';
                $i=1;  
            }

            $table.=  '<tr>';
            foreach($row as $value){
                $table.=  "<td>$value</td>";
                }
            $table.=  '</tr>';
        }
        $table.=  '<table>';
        
        return $table;
    }

    public static function arrayToTable($userType){
        $session = session();
        echo '<h3>'.$userType.' Details</h3>';
        echo '<table class="table table-striped">';
        echo '<tr><th>FirstName</th><th>LastName</th><th>email</th><th>Logged In</th><th>User Type</th></tr>';
		    echo '<tr>';
		    echo '<td>'.$session->get('firstname').'</td>';
            echo '<td>'.$session->get('lastname').'</td>';
            echo '<td>'.$session->get('email').'</td>';
            echo '<td>'.$session->get('loggedIn').'</td>';
            echo '<td>'.$session->get('userType').'</td>';
		    echo '</tr>';
echo '</table>';
    }

    public static function productsToTable($products, $quantities){
        echo '<table class="table table-striped">';
        echo '<tr><th>Description</th><th>category</th><th>quantity</th><th>photo</th></tr>';
        for($i = 0; $i < count($products); $i++){
		    echo '<tr>';
		    echo '<td>'.$products[$i]->description.'</td>';
            echo '<td>'.$products[$i]->category.'</td>';
            echo '<td>'.$quantities[$i].'</td>';
            echo '<td>'.$products[$i]->photo.'</td>';
		    echo '</tr>';
        }
echo '</table>';
    }
    
    
}

