
<div id="message1">

<?php 
	$base_url = array('controller' => 'Format', 'action' => 'q1_submit');
?>
<?php echo $this->Form->create('Type',array('url'=>$base_url, 'id'=>'form_type','type'=>'file','class'=>'','method'=>'POST','autocomplete'=>'off','inputDefaults'=>array(
				
				'label'=>false,'div'=>false,'type'=>'text','required'=>false)))?>
	
<?php echo __("Hi, please choose a type below:")?>
<br><br>

<?php $options_new = array(
 		'Type1' => __('<span class="showDialog" data-id="dialog_1" style="color:blue">Type1</span><div id="dialog_1" class="hide dialog" title="Type 1">
 				<span style="display:inline-block"><ul><li>Description .......</li>
 				<li>Description 2</li></ul></span>
 				</div>'),
		'Type2' => __('<span class="showDialog" data-id="dialog_2" style="color:blue">Type2</span><div id="dialog_2" class="hide dialog" title="Type 2">
 				<span style="display:inline-block"><ul><li>Desc 1 .....</li>
 				<li>Desc 2...</li></ul></span>
 				</div>')
		);
?>

<?php $options_new = array(
 		'Type1' => __('<div class="tooltip showTooltip" data-id="dialog_1" style="color:blue">Type1<div id="dialog_1" class="tooltiptext" title="Type 1">
 				<span style="display:inline-block"><ul><li>Description .......</li>
 				<li>Description 2</li></ul></span>
 				</div></div>'),
		'Type2' => __('<div class="tooltip showTooltip" data-id="dialog_2" style="color:blue">Type2<div id="dialog_2" class="tooltiptext" title="Type 2">
 				<span style="display:inline-block"><ul><li>Desc 1 .....</li>
 				<li>Desc 2...</li></ul></span>
 				</div></div>')
		);
?>

<?php echo $this->Form->input('type', array('legend'=>false, 'type' => 'radio', 'options'=>$options_new,'before'=>'<label class="radio line notcheck">','after'=>'</label>' ,'separator'=>'</label><label class="radio line notcheck">', 'required'=>true));?>




<?php echo $this->Form->end('Save');?>

</div>

<style>
/*.showDialog:hover{
	text-decoration: underline;
}

#message1 .radio{
	vertical-align: top;
	font-size: 13px;
}

.control-label{
	font-weight: bold;
}

.wrap {
	white-space: pre-wrap;
}*/

</style>

<style>
	.tooltip {
	  position: relative;
	  display: inline-block;
	  /*border-bottom: 1px dotted black;*/
	  font-size: 13px; 
	  opacity: 1;
	}

	.tooltip .tooltiptext {
	  visibility: hidden;
	  width: 150px;
	  background-color: #fff;
	  color: #000;
	  text-align: center;
	  /*padding: 5px 0;*/
	  /*border-radius: 6px !important;*/
	  border: 1px solid lightgrey;
	  box-shadow: 1px 1px 1px 1px rgba(0,0,0,0.05);

	  position: absolute;
	  z-index: 1;
	  left: 300%;
	  top: -16px;
	  margin-left: -60px;


	  opacity: 0;
	  transition: opacity 0.3s;
	}

	.tooltip .tooltiptext::after {
	  content: " ";
	  position: absolute;
	  top: 50%;
	  right: 100%;
	  margin-top: -10px;
	  border-width: 10px;
	  border-style: solid;
	  border-color: transparent #fff transparent transparent;
	}

	.tooltip .tooltiptext::before {
	  content: " ";
	  position: absolute;
	  top: 48%;
	  right: 100%;
	  margin-top: -10px;
	  border-width: 12px;
	  border-style: solid;
	  border-color: transparent lightgrey transparent transparent;
	}

	.tooltip:hover .tooltiptext {
	  visibility: visible;
	  opacity: 1;
	}
</style>

<?php $this->start('script_own')?>
<script>
$(document).ready(function(){
	$(".dialog").dialog({
		autoOpen: false,
		width: '500px',
		modal: true,
		dialogClass: 'ui-dialog-blue'
	});

	$(".showDialog").click(function(){ 
		var id = $(this).data('id'); 
		$("#"+id).dialog('open'); 
	});
})
</script>
<?php $this->end()?>