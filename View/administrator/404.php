<!DOCTYPE html>
<html>
<head>
	<title>404 - Page not found.</title>
	<style type="text/css">
	  *{
	  	margin:0px;
	  	padding: 0px;

	  }
      .p404 {
		  width: 500px;
		  margin: auto;
		  padding: 20px;
		  height: 199px;
		  border: 2px solid #F00;
		  margin-top: 120px;
		  text-align: center;
		  line-height: 85px;
		}
	</style>
</head>
</body>
<div class="p404">
	<form action="<?=BASEURL;?>home/login" method="post">
		Name:<input type="text" name="name"><br>
		Password: <input type="pass" name="pass"><br>
		<input type="submit">
	</form>	

</div>	
</body>
</html>