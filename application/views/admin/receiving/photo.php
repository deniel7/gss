<div id="page-wrapper">

<div class="col-lg-10">
<h1>Photo</h1>


<div class="blk">
    <div class="hdr">Nomor Transaksi : <?php echo $orderno_gtron; ?></div>
</div>
<div class="content">
<button id="upload">Upload</button>
<div class="row">
	<div class="col-lg-12">
		<div class="col-lg-3">
	
			<video id="video" autoplay></video>
		</div>
		<div class="col-lg-3">
			
			<button id="snap" style="text-align: left">Capture</button>
			<button id="new" style="text-align: right">New</button><br/>

		
		</div>
		<div class="col-lg-3">
								<canvas id="canvas" width="640" height="480"></canvas>
		</div>
	</div>
</div>

<script>
		// Put event listeners into place
		window.addEventListener("DOMContentLoaded", function() {
			// Grab elements, create settings, etc.
			var canvas = document.getElementById("canvas"),
				context = canvas.getContext("2d"),
				video = document.getElementById("video"),
				videoObj = { "video": true },
				errBack = function(error) {
					console.log("Video capture error: ", error.code); 
				};

			// Put video listeners into place
			if(navigator.getUserMedia) { // Standard
				navigator.getUserMedia(videoObj, function(stream) {
					video.src = stream;
					video.play();
				}, errBack);
			} else if(navigator.webkitGetUserMedia) { // WebKit-prefixed
				navigator.webkitGetUserMedia(videoObj, function(stream){
					video.src = window.webkitURL.createObjectURL(stream);
					video.play();
				}, errBack);
			} else if(navigator.mozGetUserMedia) { // WebKit-prefixed
				navigator.mozGetUserMedia(videoObj, function(stream){
					video.src = window.URL.createObjectURL(stream);
					video.play();
				}, errBack);
			}

			// Trigger photo take
			document.getElementById("snap").addEventListener("click", function() {
				context.drawImage(video, 0, 0, 640, 480);
				// Littel effects
				$('#video').fadeOut('slow');
				$('#canvas').fadeIn('slow');
				$('#snap').hide();
				$('#new').show();
				// Allso show upload button
				//$('#upload').show();
			});
			
			// Capture New Photo
			document.getElementById("new").addEventListener("click", function() {
				$('#video').fadeIn('slow');
				$('#canvas').fadeOut('slow');
				$('#snap').show();
				$('#new').hide();
			});
			// Upload image to sever 
			document.getElementById("upload").addEventListener("click", function(){
				var dataUrl = canvas.toDataURL();
				$.ajax({
				  type: "POST",
				  url: "<?php echo base_url()."admin/receiving/photo_save/".$orderno_gtron; ?>",
				  
				  data: { 
					 imgBase64: dataUrl
				  }
				}).done(function(msg) {alert(msg);
				  console.log('saved');
				 // Do Any thing you want
				 //alert('berhasil');
				});
			});
		}, false);

	</script>



</div>

</div>