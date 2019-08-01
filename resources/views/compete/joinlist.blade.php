<script src="{{asset('jquery.js')}}"></script>
<table align="center">
    <caption><h3>我要竞猜</h3></caption>
    <tr>
        <td>
        	<h5>{{$data->name1}}</h5>
        </td>
        <td>
        	<h4>VS</h4>
        </td>
        <td>
        	<h5>{{$data->name2}}</h5>
        </td>
    </tr>
    <tr>
        <td>
        	<a href="{{url('/compete/join_admin')}}?qid={{$data->id}}&&req=1 ">胜</a>
        </td>
        <td>
        	<a href="{{url('/compete/join_admin')}}?qid={{$data->id}}&&req=2 ">平</a>
        </td>
        <td>
        	<a href="{{url('/compete/join_admin')}}?qid={{$data->id}}&&req=3 ">中</a>
        </td>
    </tr>
</table>