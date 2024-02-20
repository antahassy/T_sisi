@extends('admin_layout/index')
@section('content')
<?php
	$sess_id = Session::get('user.id');
	$session = DB::table('tb_user')->where('id', $sess_id)->first();
	$id_group = DB::table('tb_user_group_2')->where('id_user', $sess_id)->first()->id_group;
	$level_group = DB::table('tb_user_group')->where('id', $id_group)->first();
?>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
		<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
			<div class="d-flex align-items-center flex-wrap mr-2">
				<?php
					if(in_array('2', $akses_menu)){
						echo '<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">' . $active_menu . '</h5>';
						echo '<div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>';
						echo '<a href="#" class="btn btn-light-success font-weight-bolder btn-sm" id="btn_add">Tambah Data</a>';
					}else{
						echo '<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">' . $active_menu . '</h5>';
					}
				?>
			</div>
			<div class="d-flex align-items-center">
			</div>
		</div>
	</div>
	<div class="d-flex flex-column-fluid">
		<div class="container">
			<div class="row" id="main_content">
				<div class="col-lg-12 col-xxl-4 order-1 order-xxl-2">
					<div class="card card-custom card-stretch gutter-b">
						<div class="card-body pt-10 text_data">
							Hello <span style="font-weight: 800;">{{ $session->username }}</span>, welcome
							<br>
							Your access level as <span style="font-weight: 800;">{{ $level_group->description }}</span>
							<!-- <div>
								<button id="btn_api">Test</button>
							</div> -->
							<div class="row">
								<div class="col-md-6">
									<label>Bintang</label>
									<input type="text" name="bintang" id="bintang" class="form-control" placeholder="masukkan angka">
									<div class="result_bintang" style="margin-top: 25px;"></div>
								</div>
								<div class="col-md-6">
									<label>Angka</label>
									<input type="text" name="angka" id="angka" class="form-control" placeholder="masukkan angka">
									<div class="result_angka" style="margin-top: 25px;"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		var delay = (function(){
			var timer = 0;
			return function(callback, ms){
				clearTimeout (timer);
				timer = setTimeout(callback, ms);
			};
		})();
		bintang();
		angka();
		function bintang(){
			$('#bintang').on('keyup', function(){
				var value = $(this).val();
				delay(function(){
					var yy = "0";
					for (let i = 1; i <= value; i++) {
						for (let j = 1; j <= value - i; j++) {
							yy += " ";
						}
						for (let k = 0; k < 2 * i - 1; k++) {
							yy += "*";
						}
						yy += "\n";
					}
					$('.result_bintang').text('F12 for console');
					console.log(yy);
				}, 500 );
			});
		}
		function angka(){
			$('#angka').on('keyup', function(){
				var value = $(this).val();
				delay(function(){
					let xx = "";
					for (let i = 1; i <= value; i++) {
						for (let j = (value - 1); j >= i; j--) {
							xx += " ";
						}
						for (let k = 1; k <= i; k ++) {
							xx += k;
						}
						xx += "\n";
					}
					$('.result_angka').text('F12 for console');
					console.log(xx);
				}, 500 );
			});
		}
	});
</script>
@endsection