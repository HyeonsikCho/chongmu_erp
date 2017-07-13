<?
?>
<html>
<head>
    <script type="text/javascript" src="/design_template/js/lib/jquery-1.11.2.min.js"></script>

<script>
$(document).ready(function() {
var test = "";
    $("#in_page_qty > option").each(function() {
        test += parseInt($(this).val()) + ',\n';
});

console.log(test);

$("#test").text('<div><button>123123123</button></div>');
console.log($("#test").text());
});
</script>
</head>
<body>

<div id="test"></div>

</body>
</html>

