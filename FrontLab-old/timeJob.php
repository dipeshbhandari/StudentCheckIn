<?php
function connectsql(){
        $host = "printserver";
        $username = "printserver";
        $password = "password";

        $link = mysql_connect($host,$username,$password);
        mysql_select_db("printserver", $link);

        return $link;
}


function doSQL($query){

        $result = mysql_query($query, connectsql());

        return $result;
}

$sql = "UPDATE patronsInOut SET timeOut=NOW() WHERE timeOut IS NULL";
doSQL($sql);


?>
