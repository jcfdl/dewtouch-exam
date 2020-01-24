<div class="row-fluid">
	<div class="span6">
		<?php
			$base_url = array('controller' => 'Record', 'action' => 'index');
			// $base_url = Router::url( $this->here, true);
    	echo $this->Form->create("Filter", array('url' => $base_url, 'class' => 'filter', 'inputDefaults' => array(
        'label' => false,
        'div' => false
    	)));
		?>
			<div id="table_records_length" class="dataTables_length">		
				<label>		
				<?php 
					echo $this->Form->input("limit", array('label' => false, 'options' => $limit_option, 'id'=>'limit_filter'));
				?>
				records per page</label>
			</div>
		</div>
	<div class="span6">
		<div class="dataTables_filter" id="table_records_filter">
			<label>Search: 
				<input name="data[Filter][search]" type="text" aria-controls="table_records" class="mb-0" value="<?php echo $search; ?>">				
				<button type="submit"><i class="icon-search"></i></button>
			</label>
		</div>
		<?php 
    	echo $this->Form->end();
    ?>
	</div>
</div>
<div class="row-fluid">
	<table class="table table-bordered" id="table_records">
		<thead>
			<tr>
				<th>
					<?php echo $this->Paginator->sort('id', 'ID'); ?>
				</th>
				<th>
					<?php echo $this->Paginator->sort('name', 'NAME'); ?>						
				</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($records as $record):?>
			<tr>
				<td><?php echo $record['Record']['id']?></td>
				<td><?php echo $record['Record']['name']?></td>
			</tr>	
			<?php endforeach;?>
		</tbody>
	</table>	
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
<?php $this->start('script_own')?>
<script>
// $(document).ready(function(){
// 	$("#table_records").dataTable({
// 		"processing": true,
//     "serverSide": true,
//     "ajax": {
//         "url": "/interview-dewtouch/Record/getRows",
//         "type": "POST"
//     },
//     "columns": {
//     	"data": "id",
//     	"data": "name"
//     }			
// 	});
// })
	$('#limit_filter').on('change', function() {
		this.form.submit();
	});
</script>
<?php $this->end()?>