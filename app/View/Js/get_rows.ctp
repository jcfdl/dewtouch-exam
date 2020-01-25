<?php if(empty($records)): ?>				
	<tr>
		<td colspan="100">No data found!</>
	</tr>
	<tr>
		<td colspan="4"></td>
		<td>Total: 0.00</td>
	</tr>				
<?php else: ?>
	<?php $total = 0.00; ?>
	<?php foreach($records AS $key => $value): ?>
		<tr>
			<td>
				<span class="btn mini red deletebutton" onclick="deleteRow(<?= $value['Inventory']['id']; ?>)">
					<i class="icon-remove"></i>
				</span>
			</td>
			<td data-id="<?= $value['Inventory']['id']; ?>" data-field="description">
				<p><?= $value['Inventory']['description']; ?></p>
				<textarea data-id="<?= $value['Inventory']['id']; ?>" data-field="description" name="data[<?= $value['Inventory']['id']; ?>][description]" class="hide"><?= $value['Inventory']['description']; ?></textarea>
			</td>
			<td data-id="<?= $value['Inventory']['id']; ?>" data-field="quantity">
				<p><?= $value['Inventory']['quantity']; ?></p>
				<input data-id="<?= $value['Inventory']['id']; ?>" data-field="quantity" type="number" name="data[<?= $value['Inventory']['id']; ?>][quantity]" value="<?= $value['Inventory']['quantity']; ?>" class="hide">
			</td>
			<td data-id="<?= $value['Inventory']['id']; ?>" data-field="price">
				<p><?= $value['Inventory']['price']; ?></p>
				<input data-id="<?= $value['Inventory']['id']; ?>" data-field="price" type="number" step='0.01' name="data[<?= $value['Inventory']['id']; ?>][price]" value="<?= $value['Inventory']['price']; ?>" class="hide">
			</td>
			<td class="amount" data-id="<?= $value['Inventory']['id']; ?>">
				<?= $value['Inventory']['amount']; ?>
			</td>
		</tr>
		<?php $total += $value['Inventory']['amount']; ?>
	<?php endforeach; ?>
	<tr>
		<td colspan="4"></td>
		<td class="total">Total: <?= number_format($total, 2); ?></td>
	</tr>	
<?php endif; ?>