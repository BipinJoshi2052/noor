<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}" />
    <title>Lucky Spin App Example</title>
    <link href="{{asset('css/jquerysctipttop.css')}}" rel="stylesheet" type="text/css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{asset('css/spinner.css')}}" rel="stylesheet" />

  </head>
  <body>

       <div class="players-div">
        <div class="card">
          <div class="card-header">
           
            <div class="text-center">
              All Players
            </div>
            {{-- <input type="text" placeholder="Search"> --}}
          </div>
          <div class="card-body">  
            <div class="row">
              <div class="col-12">
                
              <div class="text-center players-total">
                Total : 0
              </div>
              </div>
            </div>          
            <ul class="list-group list-group-flush player-list-div">
              {{-- <li class="p-0 mb-1 d-flex justify-content-between player-list-li">
                <div class="player-div p-2">
                  Bipin 
                </div>
                <div class="palyer-total bg-dark text-white p-2">200</div>
              </li>
              <li class="p-0 mb-1 d-flex justify-content-between player-list-li">
                <div class="player-div p-2">
                  Bipin
                  
                </div>
                <div class="palyer-total bg-dark text-white p-2">200</div>
              </li>
              <li class="p-0 mb-1 d-flex justify-content-between player-list-li">
                <div class="player-div p-2">
                  Bipin
                  
                </div>
                <div class="palyer-total bg-dark text-white p-2">200</div>
              </li> --}}
            </ul>
          </div>
          <!-- <div class="card-body">
            <h5 class="card-title"></h5>
            <ul>
              <li>Bipin</li>
              <li>Prasun </li>
              <li>Anish</li>
            </ul>
          </div> -->
        </div>
      </div>
    <div class="mainbox" id="mainbox">
      <div class="box" id="box">
            @if(isset($final) && !empty($final))
            @php
                $total_half = round((count($final))/2);
                $count = 1;
            @endphp
            
            <div class="box1">
              @foreach ($final as $key => $value)
                @if ($key < $total_half)
                  <span class="font span{{$key+1}}"><b>{{$value['form']['full_name']}}</b></span>
                @endif
              @endforeach
            </div>
            <div class="box2">
              @foreach ($final as $key1 => $value)
                @if ($key1 >= $total_half)
                  <span class="font span{{$count++}}"><b>{{$value['form']['full_name']}}</b></span>
                @endif
              @endforeach
            </div>
              
              {{-- @foreach ($final as $key => $value)
                @if ($key < $total  _half)
                <div class="box1">
                  <span class="font span{{$key+1}}"><b>{{$value['form']['full_name']}}</b></span>
                </div>                
                  
                @else
                  <div class="box2">
                    <span class="font span{{$key+1}}"><b>{{$value['form']['full_name']}}</b></span>
                  </div>
                @endif
              @endforeach --}}
            @endif
        {{-- final --}}
        {{-- <div class="box1">
          <span class="font span1"><b>Samsung Tab A6</b></span>
          <span class="font span2"><b>JBL Speaker</b></span>
          <span class="font span3"><b>Magic Roaster</b></span>
          <span class="font span4"><b>Sepeda Aviator</b></span>
          <span class="font span5"><b>Rice Cooker<br/>Philips</b></span>
        </div>
        <div class="box2">
          <span class="font span1"><b>Lunch Box Lock&Lock</b></span>
          <span class="font span2"><b>Air Cooler <br />Sanken</b></span>
          <span class="font span3"><b>Ipad Mini 4</b></span>
          <span class="font span4"><b>Exclusive Gift</b></span>
          <span class="font span5"><b>Electrolux <br />Blender</b></span>
        </div> --}}
      </div>
      <button class="spin" onclick="spin()">SPIN</button>
    </div>
    <audio
      controls="controls"
      id="applause"
      src="{{asset('img/applause.mp3')}}"
      type="audio/mp3"
    ></audio>
    <audio
      controls="controls"
      id="wheel"
      src="{{asset('img/wheel.mp3')}}"
      type="audio/mp3"
    ></audio>
    
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script type="text/javascript">
        function gimmick(el) {
            var exists = document.getElementById('gimmick')
            if (exists) {
                exists.parentNode.removeChild(exists);
                return false;
            }
        
            var element = document.querySelector(el);
            var canvas = document.createElement('canvas'),
                ctx = canvas.getContext('2d'),
                focused = false;
        
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            canvas.id = 'gimmick'
        
            var coin = new Image();
            coin.src = 'http://i.imgur.com/5ZW2MT3.png'
            // 440 wide, 40 high, 10 states
            coin.onload = function () {
                element.appendChild(canvas)
                focused = true;
                drawloop();
            }
            var coins = []
        
            function drawloop() {
                if (focused) {
                    requestAnimationFrame(drawloop);
                }
                
                ctx.clearRect(0, 0, canvas.width, canvas.height)
        
                if (Math.random() < .3) {
                    coins.push({
                        x: Math.random() * canvas.width | 0,
                        y: -50,
                        dy: 3,
                        s: 0.5 + Math.random(),
                        state: Math.random() * 10 | 0
                    })
                }
                var i = coins.length
                while (i--) {
                    var x = coins[i].x
                    var y = coins[i].y
                    var s = coins[i].s
                    var state = coins[i].state
                    coins[i].state = (state > 9) ? 0 : state + 0.1
                    coins[i].dy += 0.3
                    coins[i].y += coins[i].dy
        
                    ctx.drawImage(coin, 44 * Math.floor(state), 0, 44, 40, x, y, 44 * s, 40 * s)
        
                    if (y > canvas.height) {
                        coins.splice(i, 1);
                    }
                }
            }
        
        }
        jQuery(document).ready(function() {
              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                  }
              });
              var actionType = "GET";
              var ajaxurl = '/user-spinner';
              $.ajax({
                  type: actionType,
                  url: ajaxurl,
                  data: {
                  },
                  dataType: 'json',
                  beforeSend: function() {
                    $(".player-list-div").html('Getting Players....');
                  },
                  success: function(data) {
                      optionLoop = '';
                      options = data;
                      options.forEach(function(index) {
                          optionLoop +=
                              '<li class="p-0 mb-1 d-flex justify-content-between player-list-li"><div class="player-div p-2">' + index.form.full_name + '</div><div class="palyer-total bg-dark text-white p-2">' + index.total + '</div></li>';
                      });
                      $(".player-list-div").html(optionLoop);
                      $(".players-total").html('Total : '+data.length);
                  },
                  error: function(data) {
                      toastr.error('Error', data.responseText);
                  }
              });
        });
        
        </script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{asset('js/script.js')}}"></script>
    <script type="text/javascript">


</script>

  </body>
</html>
