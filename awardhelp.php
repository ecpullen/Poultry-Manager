<?php 
include 'mysql.php';
$ret = [];
$ret[0] = "<select id='div' name='div' required><option default></option><option value='Large Fowl'>Large Fowl</option><option value='Bantam'>Bantam</option><option value='Waterfowl'>Waterfowl</option><option value='Pigeon'>Pigeon</option></select>";
$ret[1] = "<select id='class' name='class' required><option default></option>";
$classes = get_all_cla();
foreach($classes as $cla){
	$ret[1] = $ret[1]."<option value = '$cla[classname]'>$cla[classname]";
}
$ret[1] = $ret[1]."</select>";
$ret[2] = "<select id='div' name='div' required><option default></option><option value='Large Fowl'>Large Fowl</option><option value='Bantam'>Bantam</option><option value='Waterfowl'>Waterfowl</option></select><input type='text' name='breed' required placeholder='Breed'>";
$ret[3] = "<select id='div' name='div' required><option default></option><option value='Large Fowl'>Large Fowl</option><option value='Bantam'>Bantam</option><option value='Waterfowl'>Waterfowl</option></select><input type='text' name='breed' required placeholder='Breed'><div><input type='text' name='variety' required placeholder='Variety'>Frizzled:<input type='checkbox' name='frizzle' value = '1'></div>";
$ret[4] = "<select id='div' name='div' required><option default></option><option value='Large Fowl'>Large Fowl</option><option value='Bantam'>Bantam</option><option value='Waterfowl'>Waterfowl</option></select><input type='text' name='breed' required placeholder='Breed'><div><input type='text' name='variety' required placeholder='Variety'> Frizzled:<input type='checkbox' name='frizzle' value = '1'></div><select id='age' name='age' required><option default></option><option value='1'>Cock</option><option value='2'>Hen</option><option value='3'>Cockerel</option><option value='4'>Pullet</option>";
echo implode(",",$ret);
?>