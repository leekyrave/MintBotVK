<?php

/*
* by KenKup
* vk.com/kenkup
* v2.1 FIX
*/

$js = file_get_contents(dirname(__FILE__) . "/react_js.txt"); // получаем код, который нужно выполнить

// выполняем его

?>
<script type="text/javascript" src="https://arizona-rp.com/aes.min.js" ></script>
<script type='text/javascript'> 
	<?php echo $js; ?>
</script>