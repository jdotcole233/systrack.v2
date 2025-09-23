<center>
	<table width="900px"
		style="border-radius: 5px; box-shadow: 1px 2px 3px #000;-webkit-box-shadow: 1px 2px 3px #000;-moz-box-shadow: 1px 2px 3px #000;"
		cellspacing="10px;">
		<tr height="100px">

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
				<p>Dear {{$client_name}}</p>
				<p>With respect to your job request " {{$job_title}} " made with Firmus Advisory, we are pleased to
					inform you :</p>
				{!! $client_message !!}
				<br>
				<br>
				<br>
				Your reference number : {{$job_reference_number}}
				<br>
				<br>
				<a href="https://firmusadvisoryapp.com/track">
					<button
						style="width:150px; height:40px; border-radius:5px 5px 5px 5px; border:0px solid; background-color: #023368; color:white; font-size: 14px; box-shadow: 0px 3px 5px 1px black;">
						Check Progress
					</button>
				</a>

				@if ($review_company)
					<a href="https://www.google.com/search?sca_esv=7a3965c0a183f446&rlz=1C1GCEU_enGH1044GH1044&sxsrf=AE3TifPW3-oSjsgyPab1uaPClNmrDZUJQw:1758591846016&si=AMgyJEtREmoPL4P1I5IDCfuA8gybfVI2d5Uj7QMwYCZHKDZ-Exb9BXZ8u_JS1pL9cjWz2wdcGrOzDhfAcNWwvnc9tX2UYVjx7CCig1E0XBfZLqjUgNtCOObBEid3E1Y2NfZ_3xROkFed&q=Firmus+Advisory+Reviews&sa=X&ved=2ahUKEwi_r6WS4e2PAxWkT0EAHXV-PaEQ0bkNegQIJBAE&biw=1512&bih=857&dpr=2">
						<button
							style="width:150px; height:40px; border-radius:5px 5px 5px 5px; border:0px solid; background-color: #a86d32; color:white; font-size: 14px; box-shadow: 0px 3px 5px 1px black;">
							Add a review
						</button>
					</a>
				@endif

				<br>
				<br>
				<p>Thank you</p>
				<p>Best Regards<br>
					Firmus Advisory</p>
			</td>
		</tr>

		<tr height="50px">
			<td colspan="3" style="background-color: #023368; color: #fff;">
				<center>
					<p>&copy; 2017 Firmus Advisory.</p>
				</center>
			</td>
		</tr>
	</table>
</center>