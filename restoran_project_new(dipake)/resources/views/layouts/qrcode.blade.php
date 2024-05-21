<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<style type="text/css">
	
		*		{padding:0; margin:0;}
		svg		{border:1px #eee solid;}



	</style>

	<script src="frontend/qrcode.min.js"></script>
</head>
<body>


<script>

	'use strict';

	var
	qrcodes = [

		/* with all available options: */
		 new QRCode({

			 msg   :  'https://shared.djncloud.my.id'
			,dim   :   256
			,pad   :   4
			,mtx   :  -1
			,ecl   :  "H"
			,ecb   :   1
			,pal   : ["#037", "#f2f4f8"]
			,vrb   :   0

		})
		
	];


	for( var c = 0; c < qrcodes.length; c++ ) {

		document.body.appendChild( qrcodes[ c ] );
	}

</script>

</body>
</html>