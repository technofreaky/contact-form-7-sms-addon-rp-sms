<form method="post">
	<table class="form-table">
		<tr>
			<th> <?php echo __('Auth Key :',CF7SI_TXT); ?> </th>
			<td>
				<input type="text" class="regular-text" name="authKey" value="<?php echo get_option(CF7SI_DB_SLUG.'authKey',''); ?>" /> <p class="description">You Need an Auth Key to use RP SMS Plugin. <a target="_blank" href="http://sms.rpsms.in/">Click here</a> to get auth key</p>
			</td>
		</tr>
		
		<tr>
			<th> <?php echo __('Route :',CF7SI_TXT); ?> </th>
			<td>
				<input type="text" class="regular-text" name="route" value="<?php echo get_option(CF7SI_DB_SLUG.'route',''); ?>" /> 
				<p class="description">For Transactional Use : 4 & Promotional Use : 1</p>
			</td>
		</tr>
		
		<tr>
			<th> <?php echo __('Sender ID :',CF7SI_TXT); ?> </th>
			<td>
				<input type="text" min="3" data-validate="min" class="regular-text" name="senderID" value="<?php echo get_option(CF7SI_DB_SLUG.'senderID',''); ?>" /> 
				<p class="description">Required SIX Digit Alphabet Only . Eg : <code>RPGSMS</code></p>
			</td>
		</tr>
		<tr>
			<td><input type="submit" name="save_api_settings" value="Update API" class="button button-primary" /> </td>
		</tr>
	</table>
</form>

<hr/>
<h3>SMS Balance</h3>
<table class="form-table" style="max-width:50%;">
	<tr>
		<th> Transactional SMS : <?php echo contact_form_7_sms_addon_rp_sms()->func()->get_balance(4); ?> </th> 
		<th> Buy SMS Credits (Online) <a href="http://sms.rpsms.in" class="button button-primary">Click Here </a></th>
	</tr>
	<tr>
		<th> Promotional SMS : <?php echo contact_form_7_sms_addon_rp_sms()->func()->get_balance(1); ?></th>
		<th> <span style="color:red;">Sales & Support : +91-96585 90066</span></th>
	</tr>
</table>

