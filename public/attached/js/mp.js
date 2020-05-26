// JavaScript Document
/*DEVELOPED BY JORGE SALDAÑA*/
// ___________________________
// _____****_________****_____
// ____******_______******____
// __***********_***********__
// __***********************__
// __*****_____________*****__
// ___****_____________****___
// ___***____*******____***___
// ___***____**___***___***___
// ____**____*******____**____
// ____**____**_________**____
// ____*_____**__________*____
// ___________________________
/*####MOUSTACHED##PLUMBER####*/

class general_funct {
  set_invalid(selector) {
    selector.classList.remove("input_valid");
    selector.className += " input_invalid";
  }
  set_valid(selector) {
    selector.classList.remove("input_invalid");
    selector.className += " input_valid";
  }
  set_neutral(selector) {
    selector.classList.remove("input_valid");
    selector.classList.remove("input_invalid");
  }
  validatedate(inputText) {
    
    var valid = true;
    var dateformat = /^(0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])[\/\-]\d{4}$/;
    // var dateformat = /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/;
    // Match the date format through regular expression
    if (inputText.value.match(dateformat)) {
      //Test which seperator is used '/' or '-'
      var opera1 = inputText.value.split('/');
      var opera2 = inputText.value.split('-');
      var lopera1 = opera1.length;
      var lopera2 = opera2.length;
      // Extract the string into month, date and year
      if (lopera1 > 1) {
        var pdate = inputText.value.split('/');
      }
      else if (lopera2 > 1) {
        var pdate = inputText.value.split('-');
      }
      var mm = parseInt(pdate[0]);
      var dd = parseInt(pdate[1]);
      var yy = parseInt(pdate[2]);
      // Create list of days of a month [assume there is no leap year by default]
      var ListofDays = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
      if (mm == 1 || mm > 2) {
        if (dd > ListofDays[mm - 1]) {
          cls_general.shot_toast('Fecha Invalida');
          return valid = false;
        }
      }
      if (mm == 2) {
        var lyear = false;
        if ((!(yy % 4) && yy % 100) || !(yy % 400)) {
          lyear = true;
        }
        if ((lyear == false) && (dd >= 29)) {
          cls_general.shot_toast('Fecha Invalidadada');
          return valid = false;
        }
        if ((lyear == true) && (dd > 29)) {
          cls_general.shot_toast('Fecha Invalidadada');
          return valid = false;
        }
      }
    }
    else {
      inputText.className += " invalid";
      cls_general.shot_toast('Fecha Invalidadadada');
      return valid = false;
    }
    return valid;
  }
  // ###############3   VERIFICAR VACIOS
  isEmpty(field,set_invalid=true) {
    if (field.value.length === 0 || /^\s+$/.test(field.value)) {
      if (set_invalid) {  field.className += " invalid";  }
      return 0;  //Vacio
    } else {
      if (set_invalid) { field.classList.remove('invalid'); }
      return 1;  //Lleno
    }
  } 
  is_empty_var(string) {
    if (string === null || string.length === 0 || /^\s+$/.test(string)) {
      return 0;  //Vacio
    } else {
      return 1;  //Lleno
    }
  }
  set_empty(selector) {
    selector.value = '';
    this.set_neutral(selector);
  }
  // #########        LARAVEL REQUEST-fetch
  laravel_request(url, method, funcion, body_json = '') //method es un string
  {
    var myHeaders = new Headers({ "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'), "Content-Type": "application/json" });
    var myInit = { method: method, headers: myHeaders, mode: 'cors', cache: 'default' };
    if (body_json != '') {
      myInit['body'] = body_json
    }
    var myRequest = new Request(url, myInit);
    fetch(myRequest)
      .then(function (response) {
        return response.json();
      })
      .then(function (json_obj) {
        if (json_obj) {
          funcion(json_obj);
        }
      })
      .catch(function (error) {
        console.log(error);
      });
  }
  // #########        ASYNC-AWAIT LARAVEL REQUEST-fetch
  async async_laravel_request(url, method, funcion, body_json = '') //method es un string
  {
    /* Creado por: Jorge Saldaña, jorgesaldar@gmail.com */
    var myHeaders = new Headers({ "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'), "Content-Type": "application/json" });
    var myInit = { method: method, headers: myHeaders, mode: 'cors', cache: 'default' };
    if (body_json != '') {
      myInit['body'] = body_json
    }
    var myRequest = new Request(url, myInit);
    let response = await fetch(myRequest)
    let json_obj = await response.json();
    if (json_obj) { funcion(json_obj); }
  }

  shot_toast(message,opt={}) {
    var counter = $('#toast_container').find('div').length
    var content = `
      <div id="toast_${counter+1}" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
          <strong class="mr-auto">Notification</strong>
          <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="toast-body">
          ${message}
        </div>
      </div>
    `
    document.getElementById("toast_container").innerHTML += content;     
    var option = { "delay": 2000 };
    for (const a in opt) {
      option[a] = opt[a];
    }    
    $('.toast').toast(option);

    $(`#toast_${counter + 1}`).toast('show');
    setTimeout(() => {
      $(`#toast_${counter + 1}`).toast('hide');
    }, 6000);
  }
  date_converter(from, to, string) {
    var raw_fecha = string.split('-');
    var from_splited = from.split('');
    var array_fecha = {};
    for (const a in from_splited) {
      array_fecha[from_splited[a]] = raw_fecha[a];
    }
    var to_splited = to.split('');
    return array_fecha[to_splited[0]] + '-' + array_fecha[to_splited[1]] + '-' + array_fecha[to_splited[2]];
  }
  datetime_converter(from, to, datetime) {
    var split = datetime.split(' ');
    var string = split[0];
    var raw_fecha = string.split('-');
    var from_splited = from.split('');
    var array_fecha = {};
    for (const a in from_splited) {
      array_fecha[from_splited[a]] = raw_fecha[a];
    }
    var to_splited = to.split('');
    return array_fecha[to_splited[0]] + '-' + array_fecha[to_splited[1]] + '-' + array_fecha[to_splited[2]]+' '+split[1];
  }
  //  ###### FUNCION DE REPORTE A PPT
  validFranz(selector, raw_acept, alt = '') { // raw_acept = array; selector = "string"
    var characters = '';
    for (var i in raw_acept) {
      switch (raw_acept[i]) {
        case 'number': characters += '0123456789'; break;
        case 'symbol': characters += '¡!¿?@&%$"#º\''; break;
        case 'punctuation': characters += ',.:;'; break;
        case 'mathematic': characters += '+-*/='; break;
        case 'close': characters += '[]{}()<>'; break;
        case 'word': characters += ' abcdefghijklmnñopqrstuvwxyzáéíóú'; break;
      }
    }
    $("#" + selector).validCampoFranz(characters + alt);
  }
  isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
  }
}
//   #######################     GENERALES



