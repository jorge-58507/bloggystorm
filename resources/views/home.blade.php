@extends('layouts.app')

@section('content')
@php
    $post_published = $compacted_data["post_published"];
    $post_notpublished = $compacted_data["post_notpublished"];
@endphp
	<!-- Modal -->
	<div class="modal fade" id="modal_post" tabindex="-1" role="dialog" aria-labelledby="modal_post" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Publications</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					{{-- PUBLISHED --}}
					<a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#published" aria-controls="published">Published <i class="fa fa-caret-down"></i></a>
					<div id="published" class="collapse">
						<ul id="container_modal_published" class="nav nav-small flex-column list-group list-group-flush">
						</ul>
					</div>
					{{-- NOT PUBLISHED --}}
					<a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#notpublished" aria-controls="notpublished">Not Published <i class="fa fa-caret-down"></i></a>
					<div id="notpublished" class="collapse">
						<ul id="container_modal_notpublished" class="nav nav-small flex-column list-group list-group-flush">
						</ul>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal -->

	<div id="side_nav" class="col-md-2 navbar navbar-expand-lg bg-dark navbar-dark d-none d-md-block">
		<div class=" navbar-collapse flex-column" id="navbar-collapse">
			<ul class="navbar-nav d-md-block col-sm-12">
				<li class="nav-item fs_50 text-center">
					<i onclick="cls_post.create()" class="nav-link fa fa-plus-square"></i>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#published" aria-controls="published">Published <i class="fa fa-caret-down"></i></a>
					<div id="published" class="collapse">
						<ul id="container_published" class="nav nav-small flex-column list-group list-group-flush">
						</ul>
					</div>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#notpublished" aria-controls="notpublished">Not Published <i class="fa fa-caret-down"></i></a>
					<div id="notpublished" class="collapse">
						<ul id="container_notpublished" class="nav nav-small flex-column list-group list-group-flush">
						</ul>
					</div>
				</li>
			</ul>
			<hr>
		</div>
	</div>
	<div class="main-container offset-md-2">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-11 col-xl-9" id="container_target">
          
				</div>
			</div>
		</div>
	</div>
@endsection
@section('javascript')

  <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
  <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
  <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>


  <script src="{{ asset('attached/js/app.js') }}" type="text/javascript"></script>
  <script src="{{ asset('attached/js/validCampoFranz.js') }}" type="text/javascript"></script>
  <script src="{{ asset('attached/js/mp.js') }}" type="text/javascript"></script>
  <script type="text/javascript">
    const cls_post = new class_post();
    const cls_general = new general_funct();
    var post_published = JSON.parse('<?php echo json_encode($post_published) ?>');
    cls_post.render_post_published(post_published);
    var post_notpublished = JSON.parse('<?php echo json_encode($post_notpublished) ?>');
    cls_post.render_post_notpublished(post_notpublished);
    @if ( auth()->user()->checkRole('admin'))
      setInterval(() => {
        cls_post.get_api();
      }, 1800000000);
    @endif

  // $('.toast').toast({autohide:false})
  // $( function(){
  //   $("#post_date").datepicker({
  //     changeMonth: true,
  //     changeYear: true, 
  //     dateFormat: 'dd-mm-yy'
  //   });
  // });
	// tippy('#add_post', {
	// 	content: 'New Post?'
	// });
</script>
@endsection