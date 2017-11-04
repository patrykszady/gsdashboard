<table id="vendors" class="table table-striped table-hover">
	<thead>
	<tr>
		<th>Business Name</th>
		<th>YTD Paid</th>
		<th>Actions</th>
	</tr>
	</thead>

	<tbody>
		@if($biz_type == 'Sub')

			@foreach ($subs as $vendor)
				@include('vendors._table_tr')
			@endforeach

		@elseif($biz_type == 'Retail')

			@foreach ($retail as $vendor)
				@include('vendors._table_tr')
			@endforeach
			
		@endif
	</tbody>
</table>

