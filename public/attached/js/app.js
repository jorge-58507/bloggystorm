// JavaScript Document
class class_post {
  constructor(post_published=[]) {
    if (post_published.length > 0) {
      this.post_published = post_published
    }
  }
  index(post_list){
    var content = ''; var counter = 0;
    for (const a in post_list) {
      content += `
        <div class="card">
          <div class="card-header" id="headingOne">
            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse${counter}" aria-expanded="true" aria-controls="collapseOne">
              <span class="badge badge-secondary">${cls_general.datetime_converter('ymd','mdy',post_list[a]['tx_post_date'])}</span>
              <h4 class="mb-3">${post_list[a]['tx_post_title']}</h4>
            </button>
          </div>

          <div id="collapse${counter}" class="collapse post overflow-auto"data-parent="#accordion_post">
            <div class="card-body px-2">
              <p> ${post_list[a]['tx_post_content']}</p>
              <button type="button" class="btn btn-primary" onclick="cls_post.read(${post_list[a]['ai_post_id']})">Read It!</button>
            </div>
          </div>
        </div>
      `;
      counter++;
    }
    document.getElementById("accordion_post").innerHTML = content;
  }
  read(post_id){
    var url = 'post/'+post_id+'/edit';
    var method = 'GET';
    var funcion = function (data_obj) {
      cls_post.load_modal(data_obj['data']['post'][0]);
    }
    cls_general.async_laravel_request(url, method, funcion)
  }
  create(str){
    var date = new Date();
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
    var month = date.getMonth() + 1;
    var today_formated = `${(month < 10) ? '0' + (date.getMonth() + 1) : (date.getMonth() + 1) }/${date.getDate()}/${date.getFullYear()}`;
    var content = `
    <div class="container pt-4">
      <form method="POST" action="" onsubmit="cls_post.save(event)">
        <div class="form-group row">
          <label for="post_date" class="col-md-3 col-form-label text-md-right">Date to Publish</label>
          <div class="col-md-4">
            <input id="post_date" type="text" class="form-control" name="post_date" value="${today_formated}" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label for="post_title" class="col-md-3 col-form-label text-md-right">Title</label>
          <div class="col-md-8">
            <input id="post_title" type="text" class="form-control" name="post_title" placeholder="Title">
          </div>
        </div>
        <div class="form-group row">
          <label for="post_content" class="col-md-3 col-form-label text-md-right">Content</label>
          <div class="col-md-8">
            <textarea  id="post_content" class="col-md-12 form-control" name="post_content"  cols="30" rows="10"></textarea>
          </div>
        </div>
        <div class="form-group row mb-0">
          <div class="col-md-8 offset-md-4">
            <button type="submit" id="btn_save_post" class="btn btn-primary btn-lg">Save</button>
          </div>
        </div>

      </form>
    </div>
    `;
    document.getElementById('container_target').innerHTML = content;
    document.getElementById('post_title').focus();
    cls_general.validFranz('post_title', ['number', 'word','symbol','punctuation','mathematic']);
    $('#post_date').datepicker({
      uiLibrary: 'bootstrap4',
      minDate: today
    });

  }
  validate_new_post(array_form){
    var valid = true;
    for (let a = 0; a < array_form.length; a++) {
      if (cls_general.isEmpty(array_form[a]) === 0) {
        valid = false;
      }
    }
    return valid;
  }
  save(event){
    event.preventDefault();
    document.getElementById("btn_save_post").disabled = true
    setTimeout(() => {  document.getElementById("btn_save_post").disabled = false }, 3000);
    var input_date = document.getElementById('post_date');
    var valid = cls_general.validatedate(input_date);
    if (!valid) { return false; }else{    /* Verifying Date Introduced */
      var date_introduced = document.getElementById('post_date').value;
      var splited = date_introduced.split("/"); 
      var date = new Date();  date.setFullYear(splited[2]); date.setMonth(splited[0]); date.setDate(splited[1]);  date.setHours(0); date.setMinutes(0); date.setSeconds(0); date.setMilliseconds(0);
      var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
      if (date < today) { cls_general.shot_toast("Verify Date"); return false; }
    }
    const array_form = [
      document.getElementById('post_title'),
      document.getElementById('post_content'),
    ];
    var valid = this.validate_new_post(array_form);
    if (!valid) { cls_general.shot_toast("Please Verify."); return false; }

    var url = 'post';
    var method = 'POST';
    var body = JSON.stringify({ a: array_form[0].value, b: array_form[1].value, c: document.getElementById('post_date').value });
    var funcion = function (data_obj) {
      cls_post.render_post_published(data_obj['data']['post_published']);
      cls_post.render_post_notpublished(data_obj['data']['post_notpublished']);
      if (data_obj['status'] === 'success') { 
        cls_post.clear_form();  
      }else{
        cls_general.shot_toast(data_obj['message']);
      }
    }
    cls_general.async_laravel_request(url, method, funcion, body)
    
  }
  delete(id){
    var url = 'post/'+id;
    var method = 'DELETE';
    var funcion = function (data_obj) {
      cls_post.render_post_published(data_obj['data']['post_published']);
      cls_post.render_post_notpublished(data_obj['data']['post_notpublished']);

      cls_general.shot_toast(data_obj['message']);
    }
    cls_general.async_laravel_request(url, method, funcion)
  }
  clear_form(){
    document.getElementById('post_title').value = '';
    document.getElementById('post_content').value = '';
  }
  render_post_published(post_published) {
    var content = ''; var counter = 0;
    for (const a in post_published) {
      content += `
      <li class="list-group-item px-1 py-0 text-wrap text-truncate w-100 mh_70 bg-secondary text-white cursor_pointer" 
      title="${post_published[a]['tx_post_title']}" onclick="cls_post.loadpost(${post_published[a]['ai_post_id']}); $('#modal_post').modal('hide'); $('.navbar-toggler').click();">
      <small>${cls_general.datetime_converter('ymd', 'mdy', post_published[a]['tx_post_date'])}</small>
      <p class="font-weight-bold">${post_published[a]['tx_post_title']}</p>
      </li>
      `;
      counter++;
    }
    if (counter < 1) {
      content += `
        <li class="list-group-item px-1 py-0 text-wrap text-truncate w-100 mh_70 bg-secondary text-white">
          <small>Nothing Here</small>
          <p class="font-weight-bold">&nbsp;</p>
        </li>
      `;
    }
    document.getElementById("container_published").innerHTML = content;
    document.getElementById("container_modal_published").innerHTML = content;
    // $("#container_published").html(content);
  }
  render_post_notpublished(post_notpublished) {
    var content = ''; var counter = 0;
    for (const a in post_notpublished) {
      content += `
        <li class="list-group-item px-1 py-0 text-wrap text-truncate w-100 mh_70 bg-secondary text-white cursor_pointer" 
        title="${post_notpublished[a]['tx_post_title']}" onclick="cls_post.loadpost(${post_notpublished[a]['ai_post_id']}); $('#modal_post').modal('hide');">
          <small>${cls_general.datetime_converter('ymd', 'mdy', post_notpublished[a]['tx_post_date'])}</small>
          <p class="font-weight-bold">${post_notpublished[a]['tx_post_title']}</p>
        </li>
      `;
      counter++;
    }
    if (counter < 1) {
      content += `
        <li class="list-group-item px-1 py-0 text-wrap text-truncate w-100 mh_70 bg-secondary text-white">
          <small>Nothing Here</small>
          <p class="font-weight-bold">&nbsp;</p>
        </li>
      `;
    }
    document.getElementById("container_notpublished").innerHTML = content;
    document.getElementById("container_modal_notpublished").innerHTML = content;
  }
  loadpost(id) {
    var url = 'post/'+id;
    var method = 'GET';
    var funcion = function (data_obj) {
      var post = data_obj['data']['post'][0];
      var button = '';
      if (data_obj['data']['authorized'] === 1) {
        button += `
          <button type="button" class="btn btn-danger" onclick="cls_post.delete(${post['ai_post_id']})"><i class="fa fa-times"></i></button>
        `;
      }
      var content = `
        <section class="py-4 py-lg-5">
          <div class="mb-3 text-right">
            ${cls_general.datetime_converter('ymd','mdy',post['tx_post_date'])}
          </div>
          <div class="w-100 text-center">
          <h4 class="mb-3">${post['tx_post_title']}</h4>
          </div>
          <div class="row">
            <div class="col-md-1 text-center d-none d-md-block">
              <h1><i class="fas fa-quote-left"></i></h1>
            </div>
            <div class="col-md-10 col-sm-12 mb-4">
              <p class="lead">
                ${post['tx_post_content']}              
              </p>
            </div>
          </div>
          <div class="row">
            <div  class="col-sm-12 mr-3 mb-2">
              ${button}
              <button type="button" class="btn btn-primary" onclick="cls_post.toggle_comments()">
                Comments <span class="badge badge-light">1</span>
              </button>
              <a href="#" class="btn btn-outline-dark"><i class="fa fa-facebook"></i></a>
              <a href="#" class="btn btn-outline-dark"><i class="fa fa-twitter"></i></a>
              <a href="#" class="btn btn-outline-dark"><i class="fa fa-instagram"></i></a>
              <button type="button" class="btn btn"></button>
            </div>
            <div id="container_comment" class="col-sm-12 h-3">
              <div class="comment_box w-100">
                <div class="col-sm-12 font-weight-bold">Petter Johnson</div>
                <div class="col-sm-12">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Porro reiciendis molestias, tenetur hic cupiditate, sequi optio tempore aspernatur asperiores doloribus quis, beatae commodi facere quos tempora. Temporibus, sapiente? Ducimus, fugit?</div>
                <div class="col-sm-12 text-right">
                  <button type="button" class="btn btn-outline-primary">Answer</button>
                </div>
              </div>
            </div>
          </div>
        </section>
      `;
      $("#container_target").html(content);
    }
    cls_general.async_laravel_request(url, method, funcion)
  }
  toggle_comments(){
    $("#container_comment").toggle('slow');
  }
  load_modal(post_data){
    console.log(post_data);
    document.getElementById("modal_title").innerHTML = post_data['tx_post_title']
    console.log(post_data['tx_post_date']);
    
    document.getElementById("modal_date").innerHTML = cls_general.datetime_converter('ymd', 'mdy', post_data['tx_post_date'])
    var content = `
      <section class="py-4 py-lg-5">
        <div class="row">
          <div class="col-md-10 col-sm-12 mb-4">
            <p class="lead">
              ${post_data['tx_post_content']}              
            </p>
          </div>
        </div>
        <div class="row">
          <div  class="col-sm-12 mr-3 mb-2">
            <button type="button" class="btn btn-primary" onclick="cls_post.toggle_comments()">
              Comments <span class="badge badge-light">1</span>
            </button>
            <a href="#" class="btn btn-outline-dark"><i class="fa fa-facebook"></i></a>
            <a href="#" class="btn btn-outline-dark"><i class="fa fa-twitter"></i></a>
            <a href="#" class="btn btn-outline-dark"><i class="fa fa-instagram"></i></a>
            <button type="button" class="btn btn"></button>
          </div>
          <div id="container_comment" class="col-sm-12 h-3">
            <div class="comment_box w-100">
              <div class="col-sm-12 font-weight-bold">Petter Johnson</div>
              <div class="col-sm-12">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Porro reiciendis molestias, tenetur hic cupiditate, sequi optio tempore aspernatur asperiores doloribus quis, beatae commodi facere quos tempora. Temporibus, sapiente? Ducimus, fugit?</div>
              <div class="col-sm-12 text-right">
                <button type="button" class="btn btn-outline-primary">Answer</button>
              </div>
            </div>
          </div>
        </div>
      </section>
    `;
    document.getElementById("modal_body").innerHTML = content;
    $("#container_modal").html(content);
    $('#modal_post').modal('show')
  }
  get_api(){
    // var url = 'https://sq1-api-test.herokuapp.com/posts';
    var url = 'get_api';
    var method = 'GET';
    var funcion = function (data_obj) {
      cls_post.render_post_published(data_obj['data']['post_published']);
      cls_post.render_post_notpublished(data_obj['data']['post_notpublished']);

      cls_general.shot_toast(data_obj['message'])
    }
    cls_general.async_laravel_request(url, method, funcion)
  }
}