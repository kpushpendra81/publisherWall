<?php
	
	try{
		$db = new PDO('mysql:host=localhost;dbname=publisher','root','');
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
		//echo "Database Connected Successfuly";
	}
	catch(PDOException $e){
		echo $e->getMessage();
	}
	
$page = isset($_GET['page']) ? (int)$_GET['page'] :1;

$nm = isset($_POST['network']) ? $_POST['network'] : '';
$perpage =24;
	$start = ($page>1) ? ($page*$perpage)-$perpage : 0;
if($nm !='')
{
$filter="where NetworkName = '$nm'";
$q="SELECT SQL_CALC_FOUND_ROWS SNO,  NetworkName, Img,bigImg FROM networks $filter";
}
else
{
$filter= '';
$q="SELECT SQL_CALC_FOUND_ROWS SNO,  NetworkName, Img,bigImg FROM networks $filter LIMIT {$start},24 ";
}

	
	$select = $db->prepare($q);
	$select->execute();
	$select= $select->fetchALL(PDO::FETCH_ASSOC);
	//echo "<pre>",print_r($select),"</pre>";
	//------page--------
	$total = $db->query("SELECT FOUND_ROWS() as total")->fetch()['total'];//total num of rows
 
	$pages = ceil($total / $perpage); // ceil() is used to rounding off values

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>publisherwall.com</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="keywords" content=" gfgfdh" />
<meta name="description" content=" fdgfdh" />
  <link rel="stylesheet" href="css/bootstrap.css">  
  <script src="js/bootstrap.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
 
  
  
  <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" />
</head>
<body>


  <div class="container-fluid text-center" style="background-color:powderblue;">
  
  
	  <div class="jumbotron">
	    <h1>PublisherWall</h1>
	   <form action='' method='post'>
        <p><label>Network Name:</label><input type='text' name='network' value='' class='auto'> <button type="submit" class="btn btn-default" name="find">FIND</button></p>
       
    </form>Total Networks-<?php echo $total; ?>
	  </div>
  
       
    	<div class="col-sm-12 col-xs-12">
    	<h3>ALL CPA Networks</h3>
      
    		<div class="row">
  
				  <?php
				 	foreach($select as $selects):				    
				    ?>
				    
					      
		    <div class="col-sm-2 col-xs-6"> 
		    	<a href="#"><img src="netBIGimg/<?php  echo $selects["bigImg"]; ?>" class="img-thumbnail" alt="<?php  echo $selects["NetworkName"]; ?>"  >
		    	<p><?php  echo $selects["NetworkName"]; ?></a><br></p>
		    </div>
					      
				    	
				    <?php endforeach; ?>
				   
				    
				    
		</div>
		
		
		<ul class="pagination">		
			<?php for($i=1;$i<=$pages;$i++):?>
			<li><a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
			<?php endfor;?>						
		</ul>


   
	</div>
 </div>

<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>    
<script type="text/javascript">
$(function() {
    
    //autocomplete
    $(".auto").autocomplete({
        source: "search.php",
        minLength: 1
    });                

});
</script>
</body>
</html>