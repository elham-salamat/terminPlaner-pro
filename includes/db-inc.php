
 <?php

 $serverName="localhost";
 $dbUserName="root";
 $dbPassword="";
 $dbName="terminplaner";

 $dbConnect = mysqli_connect($serverName,$dbUserName,$dbPassword,$dbName);

 if (!$dbConnect){
     die("connection failed: ". mysqli_connect_error());
 }
