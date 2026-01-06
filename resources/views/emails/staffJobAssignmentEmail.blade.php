<center>
	<table width="900px" style="border-radius: 5px; box-shadow: 1px 2px 3px #000;-webkit-box-shadow: 1px 2px 3px #000;-moz-box-shadow: 1px 2px 3px #000;" cellspacing="10px;">
		<tr height="100px" >

			<td colspan="2" style="background-color: #fffddd; width: 30%; padding-left: 20px;">
				<img src="{{ $message->embed(public_path('images/firmus_logo.png')) }}">
			</td>

			<td style="background-color: #023368; padding: 10px;">
				<a href="https://firmusadvisory.com/contact-us/" target="_blank" style="color: #fff;">Contact</a>
				<a href="https://firmusadvisory.com/contact-us/" target="_blank" style="color: #fff;">Help</a>
			</td>
		</tr>

    <tr>
      <td colspan="3" style="background-color: #f4f4f4; padding: 20px; color: #000;">
         <p>Dear {{ $assigned_to }}</p>
         <p>Job: <strong>{{ $job_name }}</strong> with reference number <strong>{{ $reference_number }}</strong> created on <strong>{{ $created_date }}</strong> has been {{ $action ? 'assigned' : 'unassigned' }} to you by <strong>{{ $assignee_from }}</strong> </p>
        <p>Kind Regards</p>
        <p>{{ $assigned_to }}</p>
      </td>
    </tr>

		<tr height="50px">
			<td colspan="3" style="background-color: #023368; color: #fff;">
				<center><p>&copy; 2017 Firmus Advisory.</p></center>
			</td>
		</tr>
	</table>
</center>
