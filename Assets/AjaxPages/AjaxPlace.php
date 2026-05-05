<option value"">----Select----</option>

<?php
 include("../Connection/Connection.php"); 
	  $selqry="select * from tbl_place where district_id=".$_GET["did"];
	  $resopt=$con->query($selqry);
	  while($dataopt=$resopt->fetch_assoc())
	  {
		  ?>
          <option value="<?php echo $dataopt["place_id"] ?>">
          <?php echo $dataopt["place_name"] ?>
          </option>
          <?php
	  }
	    ?>