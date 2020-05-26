@extends('layouts.app')

@section('content')
<?php  $post = $compacted_data['data']; ?>
  <!-- Modal -->
	<div class="modal fade" id="modal_post" tabindex="-1" role="dialog" aria-labelledby="efficiency" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 70%;">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modal_title"></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12 text-right">
							<span id="modal_date"></span>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12" id="modal_body" style="height:300px; overflow:auto;">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>																																																																																	{{-- /*####MOUSTACHED##PLUMBER####*/ --}}
	<!-- Modal -->  
	<div class="flex-center position-ref full-height">
		<div class="title m-b-md text-center">
			<a href="https://www.freepik.es/fotos-vectores-gratis/personas"><img src="{{ asset('attached/img/img_001.jpg')}}" alt="" width="600px" style="border-radius: 200px; padding-top: 20px;"></a>
			<p>Bloggy Storm</p>
		</div>
	</div>
	<div class="accordion" id="accordion_post">
		<div class="card">
			<div class="card-header" id="headingOne">
				<button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
					<span class="badge badge-secondary">FECHA</span>
					<h4 class="mb-3">${post['tx_post_title']}</h4>
				</button>
			</div>

			<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
				<div class="card-body">
					Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header" id="headingTwo">
				<h2 class="mb-0">
					<button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
						Collapsible Group Item #2
					</button>
				</h2>
			</div>
			<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
				<div class="card-body">
					Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header" id="headingThree">
				<h2 class="mb-0">
					<button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
						Collapsible Group Item #3
					</button>
				</h2>
			</div>
			<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
				<div class="card-body">
					Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
				</div>
			</div>
		</div>
	</div>

@endsection
@section('javascript')
  <script src="{{ asset('attached/js/app.js') }}" type="text/javascript"></script>
  <script src="{{ asset('attached/js/mp.js') }}" type="text/javascript"></script>

	<script type="text/javascript">
    const cls_general = new general_funct();
		const cls_post = new class_post(JSON.parse('<?php echo json_encode($post);?>'));
		class_post.prototype.post_list = cls_post.post_published;
		cls_post.index(cls_post.post_published);


		// $(document).ready(function(){
		// 	$("a").on('click', function(event) {
		// 		if (this.hash !== "") {
		// 			event.preventDefault();
		// 			var hash = this.hash;
		// 			$('html, body').animate({
		// 				scrollTop: $(hash).offset().top
		// 			}, 800, function(){
		// 				window.location.hash = hash;
		// 			});
		// 		}
		// 	});
		// });
	</script>
@endsection

