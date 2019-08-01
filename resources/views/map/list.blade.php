<center>
	<form>
		<h3><a href="{{url('map/address')}}">继续测量</a></h3>
		<table>
			<tr>
				<td>地名</td>
			</tr>
			<tr>
				<td>
					<textarea name="address" id="" cols="20" rows="5">{{$address}}</textarea>
				</td>
				<td>
					<span>经度{{$data['lng']}}</span>
					<br>
					<span>纬度{{$data['lat']}}</span>
				</td>
			</tr>
		</table>
	</form>
</center>
