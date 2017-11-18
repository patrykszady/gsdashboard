<table {{ $biz_type == 'Sub' ? "'id=vendors_datatable'" : ''}} class="table table-striped table-hover" id="vendors_datatable">
	<thead>
	<tr>
		<th>Business Name</th>
		<th>YTD Paid</th>
		<th>Balance</th>
{{-- 		<th>Actions</th> --}}
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

