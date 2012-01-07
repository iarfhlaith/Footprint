<pre>HTTP Request sent to: http://s3.amazonaws.com/footprint</re>
<pre>Signing String: 'GET


Fri, 11 Jan 2008 18:07:04 GMT
/footprint'</re>
<pre>Signature: 5o0SpaYxiLUDiC6gPgtmPKIIyfk=</re>
<pre><?xml version="1.0" encoding="UTF-8"?>
<ListBucketResult xmlns="http://s3.amazonaws.com/doc/2006-03-01/">
	<Name>footprint</Name>
	<Prefix></Prefix>
	<Marker></Marker>
	<MaxKeys>1000</MaxKeys>
	<IsTruncated>false</IsTruncated>
	<Contents>
		<Key>Luna_Blue.jpg</Key>
		<LastModified>2008-01-11T17:53:06.000Z</LastModified>
		<ETag>&quot;2b23c3437c7a185171bddb1dec7e3af5&quot;</ETag>
		<Size>14998</Size>
		<Owner>
			<ID>a5e014250c19c09eef6b0b2755672d11991f08aba4b2fccb6fbd6187a1df921d</ID>
			<DisplayName>webstrong</DisplayName>
		</Owner>
		<StorageClass>STANDARD</StorageClass>
	</Contents>
	<Contents>
		<Key>Static.jpg</Key>
		<LastModified>2008-01-11T18:04:02.000Z</LastModified>
		<ETag>&quot;3529390eed6a1f63f1491dd1aa3ea385&quot;</ETag>
		<Size>333744</Size>
		<Owner>
			<ID>a5e014250c19c09eef6b0b2755672d11991f08aba4b2fccb6fbd6187a1df921d</ID>
			<DisplayName>webstrong</DisplayName>
		</Owner>
		<StorageClass>STANDARD</StorageClass>
	</Contents>
</ListBucketResult>
</re>

<html>
<body>
<table>

<tr><td>
<img src="http://footprint.s3.amazonaws.com/Luna_Blue.jpg" />
</td></tr>


<tr><td>
<img src="http://footprint.s3.amazonaws.com/Static.jpg" />
</td></tr>


</table>

</body>
</html>