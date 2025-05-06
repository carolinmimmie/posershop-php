<?php
require_once("Models/Database.php");
require_once("Models/Cart.php");
function SortButtons($paramName, $paramValue)
{
?>
    <div class="mb-5">
        <a href="?sortCol=price&sortOrder=asc&<?php echo $paramName; ?>=<?php echo urlencode($paramValue); ?>" class="btn btn-dark">Lågt pris</a>
        <a href="?sortCol=price&sortOrder=desc&<?php echo $paramName; ?>=<?php echo urlencode($paramValue); ?>" class="btn btn-dark">Högt pris</a>
        <a href="?sortCol=title&sortOrder=asc&<?php echo $paramName; ?>=<?php echo urlencode($paramValue); ?>" class="btn btn-dark">A–Ö</a>
        <a href="?sortCol=title&sortOrder=desc&<?php echo $paramName; ?>=<?php echo urlencode($paramValue); ?>" class="btn btn-dark">Ö–A</a>
    </div>
<?php
}
