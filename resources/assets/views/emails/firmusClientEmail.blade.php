
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
				 <p>Dear {{$client_name}}</p>
				 <p>With respect to your job request " {{$job_title}} " made with Firmus Advisory, we are pleased to inform you :</p>
				{!! $client_message !!}
				<br>
				<br>
				<br>
				Your reference number : {{$job_reference_number}}
				<br>
				<br>
 				<a href="http://systrack.firmusadvisory.com/track"><button style="width:150px; height:40px; border-radius:5px 5px 5px 5px; border:0px solid; background-color: #023368; color:white; font-size: 14px; box-shadow: 0px 3px 5px 1px black;" >Check Progress</button>
				</a>
				<br>
				<br>
				<p>Thank you</p>
				<p>Best Regards<br>
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
