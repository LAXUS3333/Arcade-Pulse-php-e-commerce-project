<?php
include('./SignUp/database.php');

function getProduct(){
    global $conn;
    $select="select * from `accessories`" ;
$result=mysqli_query($conn,$select);

while ($row=mysqli_fetch_assoc($result)) {
    $ID=$row['ID'];
    $Title=$row['Title'];
    $Description=$row['Description'];
    $Image=$row['Image'];
    $Price=$row['Price'];

    echo"<div class='card'>
        <img class='img' src='Products/$Image' alt=''>
        <h2>$Title</h2>
        <p>$Description</p>
        <p class='price'>$Price $</p>
        <a href='details.php?ID=$ID'>Show Details</a>
    </div>";
}
}

function getCard(){
    global $conn;
    $s="select * from `cards`" ;
$r=mysqli_query($conn,$s);

while ($row=mysqli_fetch_assoc($r)) {
    $I=$row['ID'];
    $Titl=$row['Title'];
    $Descriptio=$row['Description'];
    $Imag=$row['Image'];
    $Pric=$row['Price'];

    echo"<div class='card'>
        <img class='img' src='Cards/$Imag' alt=''>
        <h2>$Titl</h2>
        <p>$Descriptio</p>
        <p class='price'>$Pric $</p>
        <a href='card_details.php?ID=$I'>Show Details</a>
    </div>";
}
}

function details(){
    global $conn;
    if (isset($_GET['ID'])) {
        $ID=$_GET['ID'];
    $select="select * from `accessories` where ID=$ID" ;
$result=mysqli_query($conn,$select);

while ($row=mysqli_fetch_assoc($result)) {
    $ID=$row['ID'];
    $Title=$row['Title'];
    $Description=$row['Description'];
    $Image=$row['Image'];
    $Price=$row['Price'];

    echo"<div class='detail'>
    <div class='left'>  
        <img class='img' src='Products/$Image' alt=''>
    </div>
    <div class='right'>
        <h2>$Title</h2>
        <p>$Description</p>
        <p class='price'>$Price $</p>
        <a href='index.php?cart=$ID'>Add to Cart</a>
    </div>
    </div>";
}
    }
}

function cards(){
    global $conn;
    if (isset($_GET['ID'])) {
        $I=$_GET['ID'];
    $s="select * from `cards` where ID=$I" ;
    $r=mysqli_query($conn,$s);

    while ($row=mysqli_fetch_assoc($r)) {
        $I=$row['ID'];
        $Titl=$row['Title'];
        $Descriptio=$row['Description'];
        $Imag=$row['Image'];
        $Pric=$row['Price'];

    echo"<div class='detail'>
    <div class='left'>  
        <img class='img' src='Cards/$Imag' alt=''>
    </div>
    <div class='right'>
        <h2>$Titl</h2>
        <p>$Descriptio</p>
        <p class='price'>$Pric $</p>
        <a href='index.php?cart=$I'>Add to Cart</a>
    </div>
    </div>";
}
    }
}

function searchProduct(){
    global $conn;
    if(isset($_GET['product'])){
        $search_data=$_GET['data'];
    $search="select * from `accessories` where Title like '%$search_data%'" ;
$result=mysqli_query($conn,$search);
$num_of_rows=mysqli_num_rows($result);
$searc="select * from `cards` where Title like '%$search_data%'";
$re=mysqli_query($conn,$searc);
$num_of_ro=mysqli_num_rows($re);
if ($num_of_ro==0 && $num_of_rows==0) {
    echo"<h2 class='t'>Nothing found with this title.</h2>";
}

while ($row=mysqli_fetch_assoc($result)) {
    $ID=$row['ID'];
    $Title=$row['Title'];
    $Description=$row['Description'];
    $Image=$row['Image'];
    $Price=$row['Price'];

    echo"<div class='card'>
        <img class='img' src='Products/$Image' alt=''>
        <h2>$Title</h2>
        <p>$Description</p>
        <p class='price'>$Price $</p>
    </div>";
}
    }

while ($ro=mysqli_fetch_assoc($re)) {
    $I=$ro['ID'];
    $Titl=$ro['Title'];
    $Descriptio=$ro['Description'];
    $Imag=$ro['Image'];
    $Pric=$ro['Price'];

    echo"<div class='card'>
        <img class='img' src='Cards/$Imag' alt=''>
        <h2>$Titl</h2>
        <p>$Descriptio</p>
        <p class='price'>$Pric $</p>
    </div>";
}

}

function getIPAddress() {  
    //whether ip is from the share internet  
     if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
                $ip = $_SERVER['HTTP_CLIENT_IP'];  
        }  
    //whether ip is from the proxy  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
     }  
//whether ip is from the remote address  
    else{  
             $ip = $_SERVER['REMOTE_ADDR'];  
     }  
     return $ip;  
}  
// $ip = getIPAddress();  
// echo 'User Real IP Address - '.$ip;  

function cart(){
    global $conn;
    if (isset($_GET['cart'])) {
    $ip = getIPAddress();
    $get_ID=$_GET['cart'];
    $select_query="Select * from `cart_details` where IP='$ip' and ID=$get_ID";
    $result=mysqli_query($conn,$select_query);
    $num_of_rows=mysqli_num_rows($result);
    if ($num_of_rows>0) {
        echo"<script>alert('This is already present.')</script>";
        echo"<script>window.open('index.php')</script>";
    }
    else{
        $insert="Insert into `cart_details` (ID,IP) values ('$get_ID','$ip')";
        $result=mysqli_query($conn,$insert);
        echo"<script>alert('Added to cart.')</script>";
        echo"<script>window.open('index.php')</script>";
    }

}
}

function items(){
    global $conn;
    if (isset($_GET['cart'])) {
    $ip = getIPAddress();
    $select_query="Select * from `cart_details` where IP='$ip'";
    $result=mysqli_query($conn,$select_query);
    $num_of_rows=mysqli_num_rows($result);
    }

    else{
        $ip = getIPAddress();
        $select_query="Select * from `cart_details` where IP='$ip'";
        $result=mysqli_query($conn,$select_query);
        $num_of_rows=mysqli_num_rows($result);
    }

    echo "<div class='num'>Items in cart: $num_of_rows</div>";
}

function price(){
    global $conn;
    $i = getIPAddress();
    $total=0;
    $tota=0;
    $ok=0;
    $select_query="Select * from `cart_details` where IP='$i'";
    $result=mysqli_query($conn,$select_query);
    while ($row=mysqli_fetch_array($result)) {

        $ID=$row['ID'];
        $I=$row['ID'];
        $select2="select * from `cards` where ID=$I";
        $select="select * from `accessories` where ID=$ID" ;
        $result1=mysqli_query($conn,$select);
        while ($row_price=mysqli_fetch_array($result1)) {
            $Price=array($row_price['Price']);
            $values=array_sum($Price);
            $total+=$values;
        }
        $result2=mysqli_query($conn,$select2);
        while ($row_pric=mysqli_fetch_array($result2)) {
            $Pric=array($row_pric['Price']);
            $value=array_sum($Pric);
            $tota+=$value;
        }
        $ok=$total+$tota;
}


echo "<div class='num'>Total amount: $ok $</div>";
}

function remove(){
    global $conn;
    $select="select * from `cart_details`" ;
    $result=mysqli_query($conn,$select);
    
    while($row=mysqli_fetch_assoc($result) ){
        $ID=$row['ID'];
    if (isset($_POST['remove'])){

        $delete="Delete from `cart_details` where ID= $ID";
        $run_delete=mysqli_query($conn,$delete);


}
if ($run_delete){
    echo" <script>window.open(cart.php','_self')</script>";


}
    }
}
