<center>
	<table width="900px" style="border-radius: 5px; box-shadow: 1px 2px 3px #000;-webkit-box-shadow: 1px 2px 3px #000;-moz-box-shadow: 1px 2px 3px #000;" cellspacing="10px;">
		<tr height="100px" >

			<td colspan="2" style="background-color: #fffddd;"> <img src="https://firmusadvisory.com/wp-content/uploads/2017/07/logo_firmus-1.png"> </td>

			<td style="background-color: #023368; padding: 10px;">
				<a href="https://firmusadvisory.com/contact-us/" target="_blank" style="color: #fff;">Contact</a>
				<a href="https://firmusadvisory.com/contact-us/" target="_blank" style="color: #fff;">Help</a>
			</td>
		</tr>

		<tr>
			<td colspan="3" style="background-color: #f4f4f4; padding: 20px; color: #000;">
				{!! $client_message !!}

				<p>Best Regards<br>
					{{$employee_name->first_name}} {{$employee_name->other_name}} {{$employee_name->last_name}}<br>
					{{$employee_name->position}}<br>
				 Firmus Advisory</p>
			</td>
		</tr>

		<tr height="50px">
			<td colspan="3" style="background-color: #023368; color: #fff;">
				<center><p>&copy; 2017 Firmus Advisory.</p></center>
			</td>
		</tr>
	</table>
</center>
