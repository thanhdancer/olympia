<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Hello world </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
<style type="text/css">
	#bg{
		width: 1024px;
		height: 768px;
		margin: auto auto;
		background: #000000 url('images/olpia.jpg') no-repeat ;
		}
	body{
		background-color: #000000;
		}
</style>
<script type="text/javascript">
	$(document).ready(function(){
		$("button").click(function(){
			$("body").css("background-image", "url('images/bg.jpg')");
		})
	});
</script>
</head>
<body>

	<div id="bg">

	</div>
	<button>test</button>
</body>
</html>