<div class="wrap tb-app-wrap">
	<h2>Settings</h2>
	<form id="tb-app-form" method="post" action="">
		<?php wp_nonce_field( 'tb_settings_save', 'tb_nonce' ); ?>
		<input type="hidden" name="tb_app_settings_saved" value="1" />
		<div class="tool-box">
			<h3>Sedan [Holder Caprice or Similar]</h3>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="sedan-first-km">1st km</label></th>
					<td>$<input type="text" id="sedan-first-km" name="sedan_first_km" placeholder="base" value="<?php tb_field('sedan_first_km') ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="sedan-next-49">Next 49kms</label></th>
					<td>$<input type="text" id="sedan-next-49" name="sedan_next_49" placeholder="per km" value="<?php tb_field('sedan_next_49') ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="sedan-after-50">After 50 kms</label></th>
					<td>$<input type="text" id="sedan-after-50" name="sedan_after_50" placeholder="per km" value="<?php tb_field('sedan_after_50') ?>" /></td>
				</tr>
			</table>
		</div>
		<div class="tool-box">
			<h3>Van [Mercedes Benz Viaro or Similar]</h3>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="benz-first-km">1st Kilometer</label></th>
					<td>$<input type="text" id="benz-first-km" name="van_first_km" placeholder="base" value="<?php tb_field('van_first_km') ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="benz-next-49">Next 49kms</label></th>
					<td>$<input type="text" id="benz-next-49" name="van_next_49" placeholder="per km" value="<?php tb_field('van_next_49') ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="benz-after-50">After 50 kms</label></th>
					<td>$<input type="text" id="benz-after-50" name="van_after_50" placeholder="per km" value="<?php tb_field('van_after_50') ?>" /></td>
				</tr>
			</table>
		</div>
		<div class="tool-box">
			<table class="form-table">
				<tr valign="top">
					<td>
						<h3>Discount for Surcharges</h3>
						<table class="form-table">
							<tr valign="top">
								<th scope="row"><label for="peak-time">Peak time <br />(4AM - 10AM and 3PM-10PM)</label></th>
								<td><input type="text" id="peak-time" name="peak_time" placeholder="surcharge" value="<?php tb_field('peak_time') ?>" />%</td>
							</tr>
							<tr valign="top">
								<th scope="row"><label for="off-peak-time">Off peak time (11AM - 2:59PM)</label></th>
								<td><input type="text" id="off-peak-time" name="off_peak_time" placeholder="discount" value="<?php tb_field('off_peak_time') ?>" />%</td>
							</tr>
							<tr valign="top">
								<th scope="row"><label for="night-time">Night time</label></th>
								<td><input type="text" id="night-time" name="night_time" placeholder="surcharge" value="<?php tb_field('night_time') ?>" />%</td>
							</tr>
						</table>
					</td>
					<td>
						<h3>Special Days</h3>
						<table class="form-table">
							<tr valign="top">
								<td>1<input type="text" id="start-date-1" class="datepicker" name="start_date_1" placeholder="start date" value="<?php tb_field('start_date_1') ?>" /></td>
								<td><input type="text" id="end-date-1" class="datepicker" name="end_date_1" placeholder="end date" value="<?php tb_field('end_date_1') ?>" /></td>
								<td><input type="text" id="surcharge-1" name="surcharge_1" placeholder="surcharge" value="<?php tb_field('surcharge_1') ?>" />%</td>
							</tr>
							<tr valign="top">
								<td>2<input type="text" id="start-date-2" class="datepicker" name="start_date_2" placeholder="start date" value="<?php tb_field('start_date_2') ?>" /></td>
								<td><input type="text" id="end-date-2" class="datepicker" name="end_date_2" placeholder="end date" value="<?php tb_field('end_date_2') ?>" /></td>
								<td><input type="text" id="surcharge-2" name="surcharge_2" placeholder="surcharge" value="<?php tb_field('surcharge_2') ?>" />%</td>
							</tr>
							<tr valign="top">
								<td>3<input type="text" id="start-date-3" class="datepicker" name="start_date_3" placeholder="start date" value="<?php tb_field('start_date_3') ?>" /></td>
								<td><input type="text" id="end-date-3" class="datepicker" name="end_date_3" placeholder="end date" value="<?php tb_field('end_date_3') ?>" /></td>
								<td><input type="text" id="surcharge-3" name="surcharge_3" placeholder="surcharge" value="<?php tb_field('surcharge_3') ?>" />%</td>
							</tr>
							<tr valign="top">
								<td>4<input type="text" id="start-date-4" class="datepicker" name="start_date_4" placeholder="start date" value="<?php tb_field('start_date_4') ?>" /></td>
								<td><input type="text" id="end-date-4" class="datepicker" name="end_date_4" placeholder="end date" value="<?php tb_field('end_date_4') ?>" /></td>
								<td><input type="text" id="surcharge-4" name="surcharge_4" placeholder="surcharge" value="<?php tb_field('surcharge_4') ?>" />%</td>
							</tr>
							<tr valign="top">
								<td>5<input type="text" id="start-date-5" class="datepicker" name="start_date_5" placeholder="start date" value="<?php tb_field('start_date_5') ?>" /></td>
								<td><input type="text" id="end-date-5" class="datepicker" name="end_date_5" placeholder="end date" value="<?php tb_field('end_date_5') ?>" /></td>
								<td><input type="text" id="surcharge-5" name="surcharge_5" placeholder="surcharge" value="<?php tb_field('surcharge_5') ?>" />%</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
		<div class="tool-box">
			<h3>Additional charge</h3>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="baby-seat">Baby seat</label></th>
					<td>$<input type="text" id="baby-seat" name="baby_seat" placeholder="cost per seat" value="<?php tb_field('baby_seat') ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="ariport-pickup">Airport pickup</label></th>
					<td>$<input type="text" id="ariport-pickup" name="airport_pickup" placeholder="parking cost" value="<?php tb_field('airport_pickup') ?>" /></td>
				</tr>
			</table>
		</div>
		<p class="submit"><input name="submit" id="submit" class="button button-primary" value="Save Changes" type="submit"></p>
	</form>
</div>