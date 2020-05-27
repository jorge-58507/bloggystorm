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
	<div class="col-sm-12 pb-2">
		<div class="btn-group btn-group-toggle" data-toggle="buttons">
			<label class="btn btn-secondary active">
				<input type="radio" name="sort" value="DESC" id="order_desc" checked><i class="fa fa-sort-alpha-down"></i>
			</label>
			<label class="btn btn-secondary">
				<input type="radio" name="sort" value="ASC" id="order_asc"><i class="fa fa-sort-alpha-up"></i>
			</label>
		</div>
		<button type="button" id="btn_sync" class="btn btn-outline-success"><i class="fa fa-sync"></i></button>
	</div>
	<div class="accordion" id="accordion_post">
		{{-- CONTENIDO --}}
	</div>

@endsection
@section('javascript')
  <script src="{{ asset('attached/js/app.js') }}" type="text/javascript"></script>
  <script src="{{ asset('attached/js/mp.js') }}" type="text/javascript"></script>

	<script type="text/javascript">
    const cls_general = new general_funct();
		const cls_post = new class_post(JSON.parse('<?php echo json_encode($post);?>'));
		class_post.prototype.post_list = cls_post.post_published;

		// var array_sort = document.getElementsByName('sort');
		// for(i = 0; i < array_sort.length; i++) {
		// 	if(array_sort[i].checked){
		// 		var sort = array_sort[i].value
		// 	}
		// }
		var sort = $('label.active input').val()			
		cls_post.index(cls_post.post_published,sort);

		$("input[name=sort]").click( ()=>{ 
			$("#btn_sync").click();
		});
		$("#btn_sync").on("click",()=>{
			var sort = $('label.active input').val()			
			var url = 'post_sync/'+sort;
			var method = 'GET';
			var funcion = function (data_obj) {
				class_post.prototype.post_list = data_obj['data'];
				cls_post.index(cls_post.post_list,sort);				
			}
			cls_general.async_laravel_request(url, method, funcion)

		});

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

