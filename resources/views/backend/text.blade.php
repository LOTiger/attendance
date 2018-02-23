<html>
<head>
    <title>JSEncrypt Example</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script src="{{asset('backend/bower_components/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('js/jsencrypt.min.js')}}"></script>
</head>
<body>
<script type="text/javascript">
    function do_encrypt() {
        var encrypt = new JSEncrypt();
        encrypt.setPublicKey($('#pubkey').val());
        var encrypted = encrypt.encrypt($('#input').val());

        // Decrypt with the private key...
        var decrypt = new JSEncrypt();
        decrypt.setPrivateKey($('#privkey').val());
        var uncrypted = decrypt.decrypt(encrypted);

        var $bstr1=decrypt.encrypt($('#input').val());
        var $bstr2=encrypt.decrypt($bstr1);

        // Now a simple check to see if the round-trip worked.
        if (uncrypted == $('#input').val()) {
            $('#pubkeyencode').val(encrypted);
//            $('#privkeydecode').val(uncrypted);
            $('#privkeyencode').val($bstr1);
            $('#pubkeydecode').val($bstr2);
        }
        else {
            alert('Something went wrong....');
        }
    }
</script>
<label for="privkey">Private Key</label><br/>
<textarea id="privkey" rows="15" cols="65">
{{$req['prikey']}}
</textarea><br/>
<label for="pubkey">Public Key</label><br/>
<textarea id="pubkey" rows="15" cols="65">
{{$req['pubkey']}}
</textarea><br/>
<label for="input">需要加密的数据:</label><br/>
<textarea id="input" name="input" type="text" rows=4 cols=70>This is a test!</textarea><br/>
<input id="testme" type="button" onClick="do_encrypt();" value="Test Me!!!" /><br/>
<form method="post" action="">
    {{csrf_field()}}
<label for="pubkey">公钥加密</label><br/>
<textarea id="pubkeyencode" rows="5" cols="65" name="pubkeyencode"></textarea><br/>
<button type="submit">提交公钥加密后的数据，解密得。。。</button><br>
<label for="pubkey">私钥解密</label><br/>
<textarea id="privkeydecode" rows="5" cols="65">{{isset($req['pridekey'])?$req['pridekey']:null}}</textarea><br/>
</form>

</body>
</html>


