<!DOCTYPE html>
<html>
<head>
<title></title>

<link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/bootstrap/dist/css/bootstrap.min.css">
<script src="<?php echo base_url(); ?>/public/assets/jquery-3.6.0.min.js"></script>
<script src="<?php echo base_url(); ?>/public/assets/bootstrap/dist/js/bootstrap.min.js"></script>
<style>
	@font-face {
		font-family: 'Kanit-Light';
		src: url(<?php echo base_url(); ?>/public/assets/fonts/Kanit-Light.ttf)
	}
	* {
		font-family: 'Kanit-Light';
	}
</style>
</head>
<body>
	<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
		<h1>ระบบ แปลง LONG URL ไป  SHORT URL</h1>
    </div>
	<div class="container">
		<div class="row mt-2">
			<div class="col-12">
				<div class="card text-center mb-3">
					<div class="card-header" style="text-align:left !important">
						ระบบ แปลง URL
					</div>
					<div class="card-body" style="text-align:left !important">
						<div>
							<label for="url" class="form-label">URL</label>
 				 			<input type="text" class="form-control" id="url" placeholder="ระบุ URL" onkeypress="inputClaerValid()">
							<div id="urlValid" class="invalid-feedback d-none">
								กรุณาระบุ URL ให้ถูกต้อง
							</div>
						</div>
						<a style="cursor: pointer;color: #FFFFFF" class="btn btn-primary mt-3" onclick="convertURL()">แปลงข้อมูล</a>
					</div>
				</div>

				<div class="card d-none" id="result">
					<div class="card-body">
						<h1></h1>
						<img src="" />
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="backDrop" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel" style="background: rgba(0, 0, 0, 0);border: rgba(0, 0, 0, 0);">
		<div class="modal-dialog modal-sm" role="document" style="background: rgba(0, 0, 0, 0);border: rgba(0, 0, 0, 0);">
			<div class="modal-content" style="background: rgba(0, 0, 0, 0);border: rgba(0, 0, 0, 0);">
				<div class="modal-body text-center" style="background: rgba(0, 0, 0, 0);border: rgba(0, 0, 0, 0);">
					<div class="spinner-border m-5" role="status">
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		const inputClaerValid = () => {
			$("#result").addClass('d-none')
			$("#url").removeClass("is-invalid")
			$("#urlValid").addClass("d-none")
		}
		const validURL = (str) => {
			var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
				'((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
				'((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
				'(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
				'(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
				'(\\#[-a-z\\d_]*)?$','i'); // fragment locator
			return !!pattern.test(str);
		}
		const convertURL = () => {
			if(validURL($("#url").val())){
				$("#url").removeClass("is-invalid")
				$("#urlValid").addClass("d-none")
				$("#backDrop").modal({
					backdrop: "static", 
					keyboard: false,
					show: true 
				});
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>/conventURL",
					data: {
						url : $("#url").val()
					},
					cache: false,
					success: function(data){
						let infor = JSON.parse(data)
						$("#result").removeClass('d-none');
						$("#result h1").html(infor.url);
						$("#result img").attr("src",infor.qrCode);
						setTimeout(function(){ 
							$('#backDrop').modal('hide');
						},1000);
					}
				});
				$("#backDrop").modal('hide');
			}else{
				$("#url").addClass("is-invalid")
				$("#urlValid").removeClass("d-none")
			}
		}
		$( document ).ready(function() {
			
		});
	</script>
</body>
</html>