<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Print Timesheets</title>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<style type="text/css" media="print">
    div.page
    {
        page-break-after: always;
        page-break-inside: avoid;
    }
</style>
  </head>
  <body>
@foreach ($employees as $employee)

    <div class="container page">
        <div class="row">
            <div class="row">
	<div class="col-xs-12">
		

<table class="table table-striped table-hover">

	<thead>
		<th><h2>{{$employee->first_name}}</h2></th>
		@foreach ($days as $day)
			<th>{{date_format($day,"D")}}
				<br>
				{{date_format($day,"m/d")}}
			</th>		
		@endforeach
		<th>Total</th>
		<th>Address</th>
	</thead>
	@foreach ($projects as $project)
		<tbody style="padding-bottom:0px;padding-top:0px;margin-bottom:0px;margin-top:0px;">
			<td width="25%" style="padding-bottom:0px;padding-top:0px;margin-bottom:0px;margin-top:0px;">{{$project->getProjectname()}}</td>
			<td width="8%" style="padding-bottom:0px;padding-top:0px;margin-bottom:0px;margin-top:0px;"></td>
			<td width="8%" style="padding-bottom:0px;padding-top:0px;margin-bottom:0px;margin-top:0px;"></td>			
			<td width="8%" style="padding-bottom:0px;padding-top:0px;margin-bottom:0px;margin-top:0px;"></td>
			<td width="8%" style="padding-bottom:0px;padding-top:0px;margin-bottom:0px;margin-top:0px;"></td>
			<td width="8%" style="padding-bottom:0px;padding-top:0px;margin-bottom:0px;margin-top:0px;"></td>
			<td width="8%" style="padding-bottom:0px;padding-top:0px;margin-bottom:0px;margin-top:0px;"></td>
			<td style="padding-bottom:0px;padding-top:0px;margin-bottom:0px;margin-top:0px;"></td>
			<td style="padding-bottom:0px;padding-top:0px;margin-bottom:0px;margin-top:0px;">{{$project->address . $project->address_2}} <br>
				{{$project->city . ', ' . $project->state . ' ' . $project->zip_code}}

			</td>
		</tbody>
	@endforeach
</table>	
	</div>
	
</div>

        </div> <!-- /row -->
    </div> <!-- /container -->
     
  </body>
<style type="text/css">
    .page {
        overflow: hidden;
        page-break-after: always;
    }
</style>
@endforeach
</html>

