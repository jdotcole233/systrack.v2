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
				<p>Message from: {{$client_name}}</p>
				
        <p>Notification has been recieved on {{$reference_number}}, for Job {{$job_title}}: </p>
        {!! $client_message !!}
			</td>
		</tr>

		<tr height="50px">
			<td colspan="3" style="background-color: #023368; color: #fff;">
				<center><p>&copy; 2017 Firmus Advisory.</p></center>
			</td>
		</tr>
	</table>
</center>
