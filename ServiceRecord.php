<!DOCTYPE html>
<!--
Project:    Bitcraft Service Desk (An Open Source ITSM Web App)
Lead Devs:  Joshua Nasiatka, Allen Perry, Eugene Duffy
For:        Software Engineering
Dev Date:   Spring 2016
Status:     Staging; Idea Testing; Development
-->
<?php
  include("modules/mainhead.php");
  if ($myACL->hasPermission('hd_portal') != true) {
    header("location: /");
    exit;
  }
?>
<?php
    include_once 'modules/head.php';
    echo "<body class='hold-transition skin-$skin sidebar-mini'>
    <div class='wrapper'>";
		// build the user interface
		include_once 'modules/header.php';
		include_once 'modules/left_sidebar.php';
		?>

		<div class="content-wrapper">
      		<div class="ssp-title hd">
	          <h3>
	            <?php
	            $sr = $_GET['sr'];
				if ($sr == "all") {
					$now = getdate();
					$now = array($now[mday],$now[mon],$now[year]);
					echo "<i class='fa fa-table fa-2x pull-left'> </i>All Service Records<br><small>As of $now[1]-$now[0]-$now[2]</small>";
				} elseif (isset($sr) && is_numeric($sr)) {
	              echo "<i class='fa fa-pencil-square-o fa-2x pull-left'> </i>Service Record: $sr<br><small>Yes, every thing you do is neccessary to be written down</small>";
	            } elseif (isset($sr) && $sr == 'new'){
	              echo "<i class='fa fa-pencil-square-o fa-2x pull-left'> </i>Add New Service Record<br><small>Don't forget any valuable information</small>";
	            } elseif ($_GET['page'] == "configure") {
	              echo "<i class='fa fa-cog fa-2x pull-left'> </i>Service Desk Configuration<br><small>Configure all da things!</small>";
	            }
	    				else
	    					echo "Welcome to Service Record Central";
	            ?>
	    	  </h3>
      		</div>

			<section class="content">
				<div class="row">
					<div class="col-xs-12">
					  <?php //Show all service records ?>
					  <?php if ($sr == "all") { ?>
					    	<table id="records" class="table table-bordered table-striped">
					    		<thead>
                    	<?php $thead = "
					    			<tr>
					    				<th class='padding_fix'>SR#</th>
					    				<th class='padding_fix'>Category</th>
					    				<th class='padding_fix'>Status</th>
					    				<th class='padding_fix'>Requester</th>
					    				<th class='padding_fix'>Assigned Admin</th>
					    				<th class='padding_fix'>User Type</th>
					    				<th class='padding_fix'>Manufacturer</th>
					    				<th class='padding_fix'>Model</th>
					    				<th class='padding_fix'>Date Checked In</th>
					    				<th class='padding_fix'>Date Last Updated</th>
					    			</tr>"; echo $thead; ?>
					    		</thead>
					    		<tbody>
					    			<tr class="clickableRow" data-href="ServiceRecord.php?sr=1">
					    				<td>1</td>
					    				<td>Hardware</td>
					    				<td>In Progress</td>
					    				<td>Joshua Nasiatka</td>
					    				<td>helpdesktech</td>
					    				<td>Staff</td>
					    				<td>Apple, Inc.</td>
					    				<td>Macbook Pro (Retina)</td>
					    				<td>12/1/2015</td>
					    				<td>12/2/2015</td>
					    			</tr>
					    			<tr class="clickableRow" data-href="ServiceRecord.php?sr=2">
					    				<td>2</td>
					    				<td>Software</td>
					    				<td>Waiting for Pickup</td>
					    				<td>Help Desk</td>
					    				<td>helpdesktech</td>
					    				<td>Staff</td>
					    				<td>Dell, Inc.</td>
					    				<td>Studio XPS 15</td>
					    				<td>11/30/2015</td>
					    				<td>12/2/2015</td>
					    			</tr>
					    			<tr class="clickableRow" data-href="ServiceRecord.php?sr=3">
					    				<td>3</td>
					    				<td>Software</td>
					    				<td>Completed</td>
					    				<td>Allen Perry</td>
					    				<td>The Mac Admin</td>
					    				<td>Student</td>
					    				<td>Apple, Inc.</td>
					    				<td>Macbook Pro</td>
					    				<td>12/1/2015</td>
					    				<td>12/2/2015</td>
					    			</tr>
					    		</tbody>
					    		<tfoot>
                    <?= $thead ?>
					    		</tfoot>
				    		</table>
		    		  <?php } 
		    		  //show individual service record
		    		  elseif (isset($sr) && is_numeric($sr)) {
		    		  	echo "<p>Database table information is currently unavailable</p>";
		    		  	?>
		    		  	<p>The following form layout will need to be build:<br />
		    		  		SR# - Status
		    		  		Requesting User (name) - Type (student or faculty/staff)<br />
		    		  		Contact Phone:<br />
		    		  		Primary Email (pref. @student... or @fitchburgstate.edu):<br />
		    		  		Manufacturer (dropdown)<br />
		    		  		Model:<br />
		    		  		Serial Number: | Status: (Active/Out of Warranty); more warranty info<br />
		    		  		Who purchased laptop: <br />
		    		  		AC Adapter Included (dropdown)<br />
		    		  		Loaner Issue: Asset / charger yes/no<br />
		    		  		Password: (start off plaintext, move towards hash with preview)<br />
		    		  		Description (dropdown with general issues with option for other)<br />
		    		  		More details:<br />
		    		  		Do files need to be backed up? (dropdown)<br />
		    		  		Assigned admin<br />
		    		  		Checked in by &lt;assign to thou signed in&gt;<br />
		    		  		Pickup date<br />
		    		  		e-signature (drawing functionality)<br /></p>
		    		  	<p>Worksheet / Checklist<br />
		    		  		Dynamic note entries and checkboxes<br />
		    		  		Checklist for general tools with spots for detections => assign checkbox to the user who checked the box<br />
		    		  		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ccleaner, Mbam, etc.<br />
		    		  		add note button -> trigger modal => assign note to thou who submitted<br />

		    		  	</p>
		    		  	<?php
		    		  } elseif (isset($sr) && ($sr == "new")) {
			                $type = $_GET['type'];
			                if (isset($type) && ($type == '1')){
			                  include_once 'modules/service_record/templates/computer_repair.php';
			                } else {
			                  include_once 'modules/service_record/templates/sr_new.php';
			                }
			              } elseif ($_GET['page'] == "configure") {
			                echo "the configuration page will be here";
					    		  } else {
					    		  	//show welcome page
					    		  	echo "<p>You have reached this page in error</p>";
					    		  	echo "<p>Please return to the <a href='./'>Dashboard</a> or <a href='?sr=all'>Search for a Record</a></p>";
					    		  	echo "<script type='text/javascript'>window.location.href = './';</script>";
		    		  		}
		    		  ?>

				    </div>
			    </div>
			</section><!-- /.content -->
		</div><!-- /.content-wrapper -->
		<?php
		include_once 'modules/footer.php';
		include_once 'modules/control_sidebar.php'; ?>
    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->
	<!-- jQuery -->
    <script src="bower/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="bower/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="bower/AdminLTE/plugins/datatables/jquery.dataTables.js"></script>
    <script src="bower/AdminLTE/plugins/datatables/dataTables.bootstrap.js"></script>
    <!-- SlimScroll -->
    <script src="bower/AdminLTE/plugins/slimScroll/jquery.slimscroll.js"></script>
    <!-- FastClick -->
    <script src="bower/AdminLTE/plugins/fastclick/fastclick.min.js"></script>
    <!-- Select2 -->
    <script src="bower/AdminLTE/plugins/select2/select2.min.js"></script>
    <!-- AdminLTE App -->
    <script src="bower/AdminLTE/dist/js/app.min.js"></script>
    <!-- page script -->
    <script src="dist/js/sr_new_response.js"></script>
    <script>
      $(function () {
        $('#records').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
      });

      $(function() {
        $("#sr_type").select2();
        $("#sr_cat").select2();
        $("#sr_subcat").select2();
        $(".building").select2();
        $(".user-list").select2();
        $(".machine").select2();
        $(".request-type").select2();
      });
      $('ul#sdesk').toggle(200);

      jQuery(document).ready(function($) {
        $(".clickableRow").on("click",function() {
          if (this.parentNode.parentNode.getAttribute("id") === "downloads") {
            window.open($(this).attr("data-href"),"_blank");
          } else {
            document.location = $(this).attr("data-href");
          }
        });
      });
    </script>
    <?php
    include_once 'modules/modals.php'; ?>
  </body>
</html>
