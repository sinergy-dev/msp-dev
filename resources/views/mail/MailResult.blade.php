<div style="color: #141414;font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;">
	<p id="emailOpenHeader" style="margin: 0 0 10px;box-sizing: border-box;font-size: 14px;line-height: 1.42857143;color: #555;font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;font-weight: 400;">
	</p>
	<p>
		Dear Bu {{$users->name}},
		<br>Mohon dilakukan pembuatan ID Project untuk project dengan detail sebagai berikut:
		<br>
		<br>
		<br>
	</p>
	<table style="text-align: left;margin: 5px;">
		@if($pid_info->lead_id == 'MSPQUO')
		@else
		<tr>
			<th>Lead Id</th>
			<th>: 
				{{$pid_info->lead_id}}
			</th>
			<td></td>
		</tr>
		@endif
		<tr>
			<th>Nama Project</th>
			<th>:
				@if($pid_info->lead_id == 'MSPQUO')
				{{$pid_req->project}}
				@else
				{{$pid_info->opp_name}}
				@endif
			</th>
			<td></td>
		</tr>
		<tr>
			<th>Nama Sales</th>
			<th>:
			@if($pid_info->lead_id == 'MSPQUO')
			{{$pid_info->name}}
			@else
			{{$pid_req->name}}
			@endif
			</th>
			<td></td>
		</tr>
		<tr>
			<th>Amount</th>
			<th>:
				@if($pid_info->lead_id == 'MSPQUO')
				{{$pid_req->amount}}
				@else
				{{$pid_info->amount_pid}}
				@endif
			</th>
			<td></td>
		</tr>
		@if($pid_info->lead_id == 'MSPQUO')
		@else
		<tr>
			<th>No. PO</th>
			<th>:{{$pid_info->no_po}}</th>
			<td></td>
		</tr>
		@endif
		<tr>
			<th>No Quo</th>
			<th>:
				@if($pid_info->lead_id == 'MSPQUO')
				{{$pid_req->no_quotation}}
				@else
				{{$pid_info->quote_number2}}
				@endif
			</th>
			<td></td>
		</tr>
	</table>
	<br>
	Silahkan klik link berikut ini untuk membuat ID Project.<br>
	<table width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td>
				<table cellspacing="0" cellpadding="0">
					<tr>
						<td style="border-radius: 2px;" bgcolor="#ED2939">
							@if($pid_info->lead_id == 'MSPQUO')
							<a href="{{url($pid_req->url_create)}}" target="_blank" style="padding: 8px 12px; border: 1px solid #ED2939;border-radius: 2px;font-family: Helvetica, Arial, sans-serif;font-size: 14px; color: #ffffff;text-decoration: none;font-weight:bold;display: inline-block;">
								Create ID Project
							</a>
							@else
							<a href="{{url($pid_info->url_create)}}" target="_blank" style="padding: 8px 12px; border: 1px solid #ED2939;border-radius: 2px;font-family: Helvetica, Arial, sans-serif;font-size: 14px; color: #ffffff;text-decoration: none;font-weight:bold;display: inline-block;">
								Create ID Project
							</a>
							@endif
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<p>
		Mohon jangan membalas email ini, jika terdapat pertanyaan silahkan hubungi Team Developer (Ext: 384) atau email ke development@sinergy.co.id.
	</p>
	<p>
		Thanks<br>
		Best Regard,
	</p>
	<h5 style="color: #f39c12 !important;margin-top: 0px" class="text-yellow" ><i>Tech - Dev</i></h5>
	<p>
		----------------------------------------<br>
		PT. Sinergy Informasi Pratama (SIP)<br>
		| Inlingua Building 2nd Floor |<br>
		| Jl. Puri Raya, Blok A 2/3 No. 33-35 | Puri Indah |<br>
		| Kembangan | Jakarta 11610 – Indonesia |<br>
		| 
		| Phone | 021 - 58355599 |<br>
		----------------------------------------<br>
	</p>
</div>