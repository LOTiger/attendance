<form method="post" action="{{route('test')}}">
    <input name="password">
    <input type="radio" name="deoren" value="0">解密</input>
    <input type="radio" name="deoren" value="1">加密</input>
    {{csrf_field()}}
    <button type="submit">提交</button>

</form>


