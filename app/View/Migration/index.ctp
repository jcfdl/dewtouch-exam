<div class="row-fluid">
	<div class="alert alert-info">
		<h3>Migration of data to multiple DB table</h3>
	</div>
	<div class="alert">
		<h3>Upload your file here</h3>
	</div>
	<?php
		$base_url = array('controller' => 'Migration', 'action' => 'import');
		echo $this->Form->create('FileUpload', array('url'=>$base_url, 'id'=>'import', 'enctype' => 'multipart/form-data'));
		echo $this->Form->input('file', array('label' => 'File Upload', 'type' => 'file', 'required'=>true));
		echo $this->Form->submit('Upload', array('class' => 'btn btn-primary'));
		echo $this->Form->end();
	?>
	<div class="alert alert-success">
		<h3>Data Imported</h3>
	</div>
	<table class="table table-bordered dataTable" id="table_orders">
		<thead>
			<tr>
				<th></th>
				<th>Date</th>
				<th>Ref No</th>				
				<th>Payment By</th>
				<th>Batch No</th>
				<th>Receipt No</th>
				<th>Cheque No</th>
				<th>Payment Description</th>
				<th>Renewal Year</th>
				<th>Subtotal</th>
				<th>Total Tax</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($records as $record):?>
				<tr class="item_tr">
					<td><span class="row-details row-details-close"></span></td>
					<td><?= $record['Transaction']['date'];?></td>
					<td><?= $record['Transaction']['ref_no'];?></td>					
					<td><?= $record['Transaction']['payment_method'];?></td>
					<td><?= $record['Transaction']['batch_no'];?></td>
					<td><?= $record['Transaction']['receipt_no'];?></td>
					<td><?= $record['Transaction']['cheque_no'];?></td>
					<td><?= $record['Transaction']['payment_type'];?></td>
					<td><?= $record['Transaction']['renewal_year'];?></td>
					<td><?= $record['Transaction']['subtotal'];?></td>
					<td><?= $record['Transaction']['tax'];?></td>
					<td><?= $record['Transaction']['total'];?></td>
				</tr>	
				<tr class="hide">
					<td></td>
					<td colspan="100">
						<table style="width: 100%">
							<thead>
								<th>Member Name</th>
								<th>Member No</th>
								<th>Member Pay Type</th>
								<th>Member Company</th>
							</thead>
							<tbody>
								<td><?= $record['Transaction']['member_name']?></td>
								<td><?= $record['Member']['type']?> <?= $record['Member']['no']?></td>
								<td><?= $record['Transaction']['member_paytype']?></td>
								<td><?= $record['Transaction']['member_company']?></td>
							</tbody>
						</table>
					</td>
				</tr>
			<?php endforeach;?>
		</tbody>
	</table>
	<div class="bg_load" style="display: none;"></div>
	<div class="load-wrapper" style="display: none;">
    <div class="inner">
        <span>L</span>
        <span>o</span>
        <span>a</span>
        <span>d</span>
        <span>i</span>
        <span>n</span>
        <span>g</span>
    </div>
	</div>
</div>
<div class="row-fluid">
	<div class="span6">
		<?php 
			echo $this->Paginator->counter(array(
  	 	'format' => 'Showing {:current} of {:count} total.'
			)); 
		?>
	</div>
	<div class="span6">
		<div class="pagination pull-right m-0">
	    <ul class="pagination">
		    <?php
	        echo $this->Paginator->prev(__('← Previous'), array('tag' => 'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
	        echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
	        echo $this->Paginator->next(__('Next →' ), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
		    ?>
			</ul>
		</div>
	</div>
</div>
<?php $this->start('script_own');?>
<script>
	$('#import').submit(function(e) {
		$('.bg_load').show();
		$('.load-wrapper').show();
	});
	$(document).ready(function(){
	
		$("body").on('click','tbody tr.item_tr',function(){

		  	if($(this).next().hasClass("hide")) {
				$(this).next().removeClass("hide");
		   		$(this).find("td").eq(0).find("span").eq(0).removeClass("row-details-close").addClass("row-details-open");
		 	}else{
		   		$(this).next().addClass("hide");
		   		$(this).find("td").eq(0).find("span").eq(0).removeClass("row-details-open").addClass("row-details-close");
		 	}

		  return false;
	 });
	
})
</script>
<?php $this->end(); ?>