<div class="alert  ">
<button class="close" data-dismiss="alert"></button>
Question: Advanced Input Field</div>
<p>
	1. Make the Description, Quantity, Unit price field as text at first. When user clicks the text, it changes to input field for use to edit. Refer to the following video.
</p>
<p>
	2. When user clicks the add button at left top of table, it wil auto insert a new row into the table with empty value. Pay attention to the input field name. For example the quantity field
	<?php echo htmlentities('<input name="data[1][quantity]" class="">')?> ,  you have to change the data[1][quantity] to other name such as data[2][quantity] or data["any other not used number"][quantity]
</p>
<div class="alert alert-success">
<button class="close" data-dismiss="alert"></button>
The table you start with</div>

<table id="inventory" class="table table-striped table-bordered table-hover">
	<thead>
		<th class="w-5">
			<span id="add_item_button" class="btn mini green addbutton" onclick="insertRow();">
				<i class="icon-plus"></i>
			</span>
		</th>
		<th class="w-50">Description</th>
		<th class="w-15">Quantity</th>
		<th class="w-15">Unit Price</th>
		<th class="w-15">Amount</th>
	</thead>
	<tbody id="tabledata">
		<!-- <tr>
		<td></td>
		<td><textarea name="data[1][description]" class="m-wrap  description required" rows="2" ></textarea></td>
		<td><input name="data[1][quantity]" class=""></td>
		<td><input name="data[1][unit_price]"  class=""></td>	
	</tr> -->
	</tbody>
</table>
<p></p>
<div class="alert alert-info ">
	<button class="close" data-dismiss="alert"></button>
	Video Instruction
</div>
<p style="text-align:left;">
	<video width="78%"   controls>
	  <source src="/video/q3_2.mov">
	Your browser does not support the video tag.
	</video>
</p>
<style>
	.hide {
		display: none !important; 
	}
	.w-20 {
		width: 20%;
	}
	.w-5 {
		width: 5%;
	}
	.w-10 {
		width: 10%;
	}
	.w-15 {
		width: 15%;
	}
	.w-50 {
		width: 50%;
	}
	#inventory {
		table-layout: fixed;
		overflow: hidden;
	}
	textarea, input {
		width: 100%;
		padding: 0 !important;
	}
	textarea {
		resize: vertical;
	}
</style>
<?php $this->start('script_own');?>
<script>
	function getRows() {
		$.ajax({
			url: '/Js/getRows',
			method: 'POST',
			dataType: 'html',
			success: function(data) {
				$('#tabledata').html(data);
			}
		})
	}

	function insertRow() {
		$.ajax({
			url: '/Js/insertRow',
			method: 'POST',
			dataType: 'html',
			success: function(data) {
				getRows();
			}
		})
	}	

	function deleteRow(id) {
		$.ajax({
			url: '/Js/deleteRow',
			method: 'POST',
			dataType: 'html',
			data: {id: id},
			success: function(data) {
				getRows();
			}
		})
	}

	function updateRow(value, field, id) {
		$.ajax({
			url: '/Js/UpdateRow',
			method: 'POST',
			dataType: 'html',
			data: {value: value, field: field, id:id},
			success: function(data) {
				// updateAmount();
			}
		})
	}

	function updateAmount(value, field, id) {
		var amount;
		if(field == 'quantity') {
			$('td[data-field="'+field+'"][data-id="'+id+'"] p').html(value);
			var price = $('td[data-field="price"][data-id="'+id+'"] p').html();
			amount = value * parseFloat((price == '') ? 0 : price);
			$('.amount[data-id="'+id+'"]').html(amount.toFixed(2));
		} else if(field == 'price') {
			$('td[data-field="'+field+'"][data-id="'+id+'"] p').html(value);
			var price = $('td[data-field="quantity"][data-id="'+id+'"] p').html();
			amount = value * parseFloat((price == '') ? 0 : price);	
			$('.amount[data-id="'+id+'"]').html(amount.toFixed(2));
		} else {
			$('td[data-field="'+field+'"][data-id="'+id+'"] p').html(value);
		}
		updateTotalAmount();
	}

	function updateTotalAmount() {
		var total = 0;
		$('.amount').each(function(i, obj) {
			total += parseFloat($(this).html());
		});
		$('.total').empty();
		$('.total').html('Total: '+ total);
	}

	$(document).ready(function(){
		// $("#add_item_button").click(function(){
		// 	insertRow();
		// });
		getRows();		

		$('#inventory').on('click', 'td', function() {
			var field = $(this).attr('data-field');
			$(this).find('p').addClass('hide');
			$(this).find('[data-field="'+ field +'"]').removeClass('hide');	
			$(this).find('[data-field="'+ field +'"]').focus();
		})
		$('#inventory').on('blur', 'textarea, input', function() {
			$(this).addClass('hide');			
			var value = $(this).val();
			var field = $(this).attr('data-field');
			var id = $(this).attr('data-id');
			updateRow(value, field, id);
			updateAmount(value, field, id);
			$(this).closest('td').find('p').removeClass('hide');
		})
	});
</script>
<?php $this->end();?>

