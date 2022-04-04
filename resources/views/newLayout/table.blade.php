@extends('newLayout.layouts.newLayout')
@section('title')
    Table
@endsection
@section('content')
<style>
    
table {
  margin: 1em 0;
  border-collapse: collapse;
  border: 0.1em solid #d6d6d6;
}

caption {
  text-align: left;
  font-style: italic;
  padding: 0.25em 0.5em 0.5em 0.5em;
}

th,
td {
  padding: 0.25em 0.5em 0.25em 1em;
  vertical-align: text-top;
  text-align: left;
  text-indent: -0.5em;
}

th {
  vertical-align: bottom;
  background-color: #666;
  color: #fff;
}

tr:nth-child(even) th[scope=row] {
  background-color: #f2f2f2;
}

tr:nth-child(odd) th[scope=row] {
  background-color: #fff;
}

tr:nth-child(even) {
  background-color: rgba(0, 0, 0, 0.05);
}

tr:nth-child(odd) {
  background-color: rgba(255, 255, 255, 0.05);
}



.overlay {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background: rgba(0, 0, 0, 0.7);
  transition: opacity 500ms;
  visibility: hidden;
  opacity: 0;
}
.overlay:target {
  visibility: visible;
  opacity: 1;
}


.popup {
  margin: 70px auto;
  padding: 20px;
  background: #fff;
  border-radius: 5px;
  width: 50% ;
  position: relative;
  transition: all 5s ease-in-out;
 
  

}

.popup h2 {
  margin-top: 0;
  color: #333;
  font-family: Tahoma, Arial, sans-serif;

}
.popup .close {
  position: absolute;
  top: 20px;
  right: 30px;
  transition: all 200ms;
  font-size: 30px;
  font-weight: bold;
  text-decoration: none;
  color: #333;

}
.popup .close:hover {
  color: #FF9800;
}
.popup .content {
  max-height: calc(100vh - 210px);
    overflow-y: auto;
}

@media screen and (max-width: 700px){
  .box{
    width: 70%;
  }
  .popup{
    width: 70%;
  }
}


#timedate {
  font: small-caps lighter auto/150% "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif;
  text-align:left;
 
  margin: 40px auto;
  color:#fff;
  padding: 20px ;
}




.dropdown {
  position: relative;
  display: inline-block;
}



.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
 
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: #f1f1f1}

.dropdown:hover .dropdown-content {
  display: block;
  left: 0px;
  top: 0px;
  position: absolute;
  margin: 0rem 0rem -4rem  -4rem;
  
}


   .hidden{
   display: none;
   }
   .game-btn .card:hover{
       background: #fdb244;
   }
   .active-game-btn .card{
       background: #fdb244;
   }
   /* body{
      background-image: url('{{asset('uploads/'.$activeGame['image'])}}');
      background-size: cover;
   } */
</style>
<div class="row">
    <div class="col-lg-12" style="padding-bottom:20px;">
       <div class="card">
          <div class="card-header pb-0 p-3">
             <h6 class="mb-0">Categories</h6>
          </div>
          <div class="row">
                @if (isset($games) && !empty($games))
                    @foreach($games as $game)    
                        @php
                            $query = $_GET;
                            $query['game'] = $game['title'];
                            $query_result = http_build_query($query);
                        @endphp  
                        
                          
                     
                            <div class="col-xl-3 col-sm-3 mb-xl-0 mb-4">   
                                <a class="mb-1 game-btn {{(str_replace(' ','-',$game['title']))}}-{{($game['id'])}} {{(isset($activeGame) && $activeGame['id'] == $game['id'])?'active-game-btn':''}}" 
                            href="{{url('/table?').$query_result}}"
                            data-title="{{($game['title'])}}" 
                            data-balance="{{($game['balance'])}}"
                            >
                                <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="d-flex align-items-center">
                                            <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                                <i class="ni ni-mobile-button text-white opacity-10"></i>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-dark text-sm">{{$game['title']}}</h6>
                                                <span class="text-xs">{{($game['balance'])}}</span>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                        </a>
                            </div>
                    @endforeach                                
                @else
                    No games available
                @endif
          </div>
       </div>
    </div>
 </div>
 <div class="row" style="padding-bottom:40px;">
    <div class="col-xl-12 col-sm-12 mb-xl-0 mb-4">
       <div class="card">
          <div class="card-body p-3">
             <div class="row">
                <div class="col-8">
                   <div class="numbers">
                      <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Player </p>
                      <h5 class="font-weight-bolder">
                        {{count($activeGame['form_games'])}}
                      </h5>
                   </div>
                </div>
                <div class="col-4 text-end">
                   <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                      <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
 </div>
 <div class="row">
    <div class="col-12">
       <div class="card mb-4">
          <div class="card-header pb-0">
             <h6>Authors table</h6>
             <div class="row">
                <div class="col-10">
                   <div class="input-group">
                      <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                      <input type="text" class="form-control" class="search-user" id="search-user" placeholder="Search User">
                   </div>
                </div>
                <div class="col-2">
                   <button  class="btn  btn-primary mb-0" style="background-color:#FF9800;"  > <a href="#popup3" style="color:white;">ADD USER</a></button>
                </div>
                <div id="popup3" class="overlay">
                   <div class="popup">
                      <h2>User</h2>
                      <a class="close" href="#">&times;</a>
                      <div class="content ">
                         <label for="cars">User:</label>
                         <select name="User" class="form-control"  id="cars">
                            <option value="w">Volvo</option>
                            <option value="x">Saab</option>
                            <option value="y">Mercedes</option>
                            <option value="z">Audi</option>
                         </select>
                         <br>
                         <label for="cars">Game Id:</label>
                         <input class="form-control" type="text" value="">
                         <br>
                         <button  class="btn  btn-primary mb-0" style="background-color:#FF9800;"  >ADD</button>
                      </div>
                   </div>
                </div>
             </div>
          </div>
          <div class="card-body px-0 pt-0 pb-2">
             <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                   <thead class="sticky" >
                      <tr  >
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">SN</th>
                         <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Game Id </th>
                         <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Fb Name</th>
                         <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Balance</th>
                         <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Bonus</th>
                         <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Redeem</th>
                         <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tips</th>
                         <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                         <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">History</th>
                         {{-- <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th> --}}
                      </tr>
                   </thead>
                   <tbody>
                    @if (isset($activeGame))
                        @if (!empty($activeGame) && !empty($activeGame['form_games']))
                            @php
                                $count = 1;
                            @endphp
                            @foreach($activeGame['form_games'] as $a => $num)
                            <tr id="form-games-div-{{$a+1}}">
                                
                                <td>
                                    <div class="d-flex px-2 py-1 " >
                                       <div class="d-flex  justify-content-center text-center">
                                          <h6 class=" mb-0 text-sm" >{{$count++}}</h6>
                                       </div>
                                    </div>
                                 </td>
                                <td>
                                   <div class="d-flex px-2 py-1 " >
                                      <div class="d-flex  justify-content-center text-center">
                                        <a href="#popup1" class="user-full-history" data-gameId="{{($num['game_id'])}}" href="javascript:void(0);" data-userId="{{$num['form']['id']}}" data-game="{{$activeGame['id']}}">

                                        <h6 class=" mb-0 text-sm" > 
                                            {{($num['game_id'])}}
                                        </h6>
                                    </a>

                                         {{-- <a class="user-full-history" href="javascript:void(0);" data-userId="{{$num['form']['id']}}" data-game="{{$activeGame['id']}}">
                                            <h6 class=" mb-0 text-sm" >{{($num['game_id'])}}</h6>
                                         </a> --}}
                                         <div id="popup1" class="overlay">
                                         <div class="popup">
                                            <h2><span class="user-name">Users</span> History in {{(isset($activeGame) && $activeGame['id'] != '')?$activeGame['name']:''}}</h2>
                                            <a class="close" href="#">&times;</a>
                                            <div class="content ">
                                               <div class="row" style="padding-top:20px;">
                                                  <div class="col-12">
                                                     <div class="card mb-4">
                                                        <div class="card-header pb-0">
                                                           <h6>Authors table</h6>
                                                        </div>
                                                        <div class="card-body px-0 pt-0 pb-2">
                                                           <div class="table-responsive p-0">
                                                              <table class="table align-items-center mb-0">
                                                                 <thead class="sticky" >
                                                                    <tr  >
                                                                       <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                                                       <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amoount</th>
                                                                       <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Type</th>
                                                                       <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created by</th>
                                                                    </tr>
                                                                 </thead>
                                                                 <tbody  class="user-history-body">
                                                                    
                                                                 </tbody>
                                                              </table>
                                                           </div>
                                                        </div>
                                                     </div>
                                                  </div>
                                               </div>
                                            </div >
                                        </div >
                                         </div >
                                      </div>
                                   </div>
                                </td>
                                <td>
                                   <div class="d-flex px-2 py-1  align-middle text-center" >
                                      <div class="d-flex  justify-content-left">
                                        <a href="#popup2" class="form-full-history" data-gameId="{{($num['game_id'])}}"  data-userId="{{$num['form']['id']}}" data-game="{{$activeGame['id']}}">
                                            <h6 class=" mb-0 text-sm" > 
                                                
                                                {{(isset($num['form']['facebook_name']) && !empty($num['form']['facebook_name']))?$num['form']['facebook_name']:'Empty'}}
                                            </h6>
                                        </a>
                                      </div >
                                      <div id="popup2" class="overlay">
                                         <div class="popup">
                                            <h2><span class="user-name">Users</span> All History</h2>
                                            <a class="close" href="#">&times;</a>
                                            <div class="content ">
                                               <div class="row" style="padding-top:20px;">
                                                  <div class="col-12">
                                                     <div class="card mb-4">
                                                        <div class="card-header pb-0">
                                                           <h6>Authors table</h6>
                                                        </div>
                                                        <div class="card-body px-0 pt-0 pb-2">
                                                            <div class="row">
                                                                <div class="col-xl-4 col-sm-12 mb-xl-0 mb-4">   
                                                                    <div class="card">
                                                                        <div class="card-body p-3">
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="d-flex align-items-center">
                                                                                    <div class="d-flex flex-column">
                                                                                        <h6 class="mb-1 text-dark text-sm">Total Tip : <span class="total-tip">0</span> </h6>
                                                                                    </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-4 col-sm-12 mb-xl-0 mb-4">   
                                                                    <div class="card">
                                                                        <div class="card-body p-3">
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="d-flex align-items-center">
                                                                                    <div class="d-flex flex-column">
                                                                                        <h6 class="mb-1 text-dark text-sm">Total Balance : <span class="total-balance">0</span>  </h6>
                                                                                    </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-4 col-sm-12 mb-xl-0 mb-4">   
                                                                    <div class="card">
                                                                        <div class="card-body p-3">
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="d-flex align-items-center">
                                                                                    <div class="d-flex flex-column">
                                                                                        <h6 class="mb-1 text-dark text-sm">Total Redeem : <span class="total-redeem">0</span> </h6>
                                                                                    </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-4 col-sm-12 mb-xl-0 mb-4">   
                                                                    <div class="card">
                                                                        <div class="card-body p-3">
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="d-flex align-items-center">
                                                                                    <div class="d-flex flex-column">
                                                                                        <h6 class="mb-1 text-dark text-sm">Total Bonus : <span class="total-refer">0</span> </h6>
                                                                                    </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-4 col-sm-12 mb-xl-0 mb-4">   
                                                                    <div class="card">
                                                                        <div class="card-body p-3">
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="d-flex align-items-center">
                                                                                    <div class="d-flex flex-column">
                                                                                        <h6 class="mb-1 text-dark text-sm">Total Amount : <span class="total-amount">0</span></h6>
                                                                                    </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-4 col-sm-12 mb-xl-0 mb-4">   
                                                                    <div class="card">
                                                                        <div class="card-body p-3">
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="d-flex align-items-center">
                                                                                    <div class="d-flex flex-column">
                                                                                        <h6 class="mb-1 text-dark text-sm">Total Profit : <span class="total-profit">0</span> </h6>
                                                                                    </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                           <div class="table-responsive p-0">
                                                              <table class="table align-items-center mb-0">
                                                                 <thead class="sticky" >
                                                                    <tr  >
                                                                       <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                                                       <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Game</th>
                                                                       <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amoount</th>
                                                                       <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Type</th>
                                                                       <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created by</th>
                                                                    </tr>
                                                                 </thead>
                                                                 <tbody  style="text-align: center!important;" class="user-history-body">
                                                                  
                                                                 </tbody>
                                                              </table>
                                                           </div>
                                                        </div>
                                                     </div>
                                                  </div>
                                               </div>
                                            </div >
                                         </div >
                                      </div >
                                   </div>
                                </td>
                                <td>
                                   <div class=" px-2 py-1 align-middle text-center" >
                                      <div class=" badge d-flex  bg-gradient-success justify-content-center">
                                         <div class="d-flex px-2 py-1" >
                                            <div class="d-flex  justify-content-left">
                                               <h6 class=" mb-0 text-sm" style="color:white;" >$</h6>
                                            </div >
                                         </div>
                                         <div class="d-flex px-2 py-1" contenteditable>
                                            <div class="d-flex  justify-content-left">
                                               <h6 class=" mb-0 text-sm" style="color:white;" >XYZ</h6>
                                            </div >
                                         </div>
                                      </div >
                                   </div>
                                </td>
                                <td>
                                   <div class=" px-2 py-1 align-middle text-center" >
                                      <div class=" badge d-flex  bg-gradient-success justify-content-center">
                                         <div class="d-flex px-2 py-1" >
                                            <div class="d-flex  justify-content-left">
                                               <h6 class=" mb-0 text-sm" style="color:white;" >$</h6>
                                            </div >
                                         </div>
                                         <div class="d-flex px-2 py-1" contenteditable>
                                            <div class="d-flex  justify-content-left">
                                               <h6 class=" mb-0 text-sm" style="color:white;" >XYZ</h6>
                                            </div >
                                         </div>
                                      </div >
                                   </div>
                                </td>
                                <td>
                                   <div class=" px-2 py-1 align-middle text-center" >
                                      <div class=" badge d-flex  bg-gradient-success justify-content-center">
                                         <div class="d-flex px-2 py-1" >
                                            <div class="d-flex  justify-content-left">
                                               <h6 class=" mb-0 text-sm" style="color:white;" >$</h6>
                                            </div >
                                         </div>
                                         <div class="d-flex px-2 py-1" contenteditable>
                                            <div class="d-flex  justify-content-left">
                                               <h6 class=" mb-0 text-sm" style="color:white;" >XYZ</h6>
                                            </div >
                                         </div>
                                      </div >
                                   </div>
                                </td>
                                <td>
                                   <div class=" px-2 py-1 align-middle text-center" >
                                      <div class=" badge d-flex  bg-gradient-success justify-content-center">
                                         <div class="d-flex px-2 py-1" >
                                            <div class="d-flex  justify-content-left">
                                               <h6 class=" mb-0 text-sm" style="color:white;" >$</h6>
                                            </div >
                                         </div>
                                         <div class="d-flex px-2 py-1" contenteditable>
                                            <div class="d-flex  justify-content-left">
                                               <h6 class=" mb-0 text-sm" style="color:white;" >XYZ</h6>
                                            </div >
                                         </div>
                                      </div >
                                   </div>
                                </td>
                                <td class=" text-center ">		
                                   <button  class="btn  btn-primary mb-0" style="background-color:#FF9800;"  >Update</button>
                                </td>
                                <td class=" text-center ">
                                   <select  class="btn  btn-primary mb-0" style="background-color:#FF9800;"    id="cars" >
                                      Update
                                      <option disabled selected value> View </option>
                                      <option value="w">  <a href="#">Remove</a></option>
                                      <option value="x">  <a href="#popup2">Balance</a></option>
                                      <option value="y"><a href="#">Redeem</a></option>
                                   </select>
                                   <!--
                                      <div class="dropdown" >			
                                      
                                      <button  class="btn  btn-primary mb-0" style="background-color:#FF9800;"  >View</button>
                                      
                                      <div class="dropdown-content ">
                                      <a href="#">Remove</a>
                                      <a href="#popup2">Balance</a>
                                      <a href="#">Redeem</a>
                                      </div>
                                      </div>
                                      -->
                                   <div id="popup2" class="overlay">
                                      <div class="popup">
                                         <h2>User</h2>
                                         <a class="close" href="#">&times;</a>
                                         <div class="content ">
                                            <div class="row">
                                               <div class="col-12">
                                                  <div class="card mb-4">
                                                     <div class="card-header pb-0">
                                                        <h6>User History</h6>
                                                     </div>
                                                     <div class="card-body px-0 pt-0 pb-2">
                                                        <div class="table-responsive p-0">
                                                           <table class="table align-items-center mb-0">
                                                              <thead class="sticky" >
                                                                 <tr  >
                                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date </th>
                                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Amount</th>
                                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created By</th>
                                                                 </tr>
                                                              </thead>
                                                              <tbody>
                                                                 <tr>
                                                                    <td>
                                                                       <div class="d-flex px-2 py-1">
                                                                          <div class="d-flex flex-column justify-content-center">
                                                                             <h6 class=" mb-0 text-sm">12/2/2022</h6>
                                                                          </div>
                                                                       </div>
                                                                    </td>
                                                                    <td class="align-middle text-center ">
                                                                       <span class="badge  bg-gradient-success">0 $</span>
                                                                    </td>
                                                                    <td>
                                                                       <h6 class=" mb-0 text-sm">XYZ</h6>
                                                                    </td>
                                                                 </tr>
                                                              </tbody>
                                                           </table>
                                                        </div>
                                                     </div>
                                                  </div>
                                               </div>
                                            </div>
                                         </div>
                                      </div>
                                   </div>
                                </td>
                             </tr>
                            @endforeach
                        @else
                            <tr>
                                <td> No Users in this game.</td>
                            </tr>
                        @endif
                    @else
                        <tr>
                            <td>Please choose a game first.</td>
                            </tr>
                    @endif
                   </tbody>
                </table>
             </div>
          </div>
       </div>
    </div>
 </div>
{{-- Redeem History Modal --}}
<div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
   <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h3 class="modal-title color-white" id="exampleModalLongTitle"><i class="fa fa-scroll" style="width: 50px;"></i>Redeem</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="row">
               <table>
                  <thead>
                     <tr>
                        <th class="text-center">Date</th>
                        <th>To</th>
                        <th class="text-center">Amount</th>
                        <th class="text-center">Users Name</th>
                     </tr>
                  </thead>
                  <tbody style="text-align: center!important;">
                     @if (isset($history) && !empty($history))
                     @foreach($history as $a => $num)
                     @if ($num['type'] == 'redeem')
                     <tr>
                        <td>{{date('D, M-d, Y H:i:a', strtotime($num['created_at']))}}</td>
                        <td>{{ (!empty($num['form_games']))?$num['form_games']['game_id']:'Deleted Player'}}</td>
                        <td class="text-center">{{$num['amount_loaded']}}</td>
                        <td>{{(isset($num['form']['full_name']) && !empty($num['form']['full_name'])?$num['form']['full_name']:'empty')}}</td>
                     </tr>
                     @endif
                     @endforeach
                     @else
                     <tr>
                        <td>History Empty</td>
                     </tr>
                     @endif
                  </tbody>
               </table>
            </div>
         </div>
         {{-- 
         <div class="modal-footer">
            <button type="button" class="btn btn-success text-center load-btn" data-user="" data-userId="">Load</button>
         </div>
         --}}
      </div>
   </div>
</div>
{{-- Load History Modal --}}
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
   <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h3 class="modal-title color-white" id="exampleModalLongTitle"><i class="fa fa-scroll" style="width: 50px;"></i>History</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="row">
               <table>
                  <thead>
                     <tr>
                        <th class="text-center">Date</th>
                        <th>To</th>
                        <th class="text-center">Amount</th>
                        <th class="text-center">Users Name</th>
                     </tr>
                  </thead>
                  <tbody style="text-align: center!important;">
                     @if (isset($history) && !empty($history))
                     @foreach($history as $a => $num)
                     @if ($num['type'] == 'load')
                     <tr>
                        <td>{{date('D, M-d, Y H:i:a', strtotime($num['created_at']))}}</td>
                        <td>{{ (!empty($num['form_games']))?$num['form_games']['game_id']:'Deleted Player'}}</td>
                        <td class="text-center">{{$num['amount_loaded']}}</td>
                        <td>{{(isset($num['form']['full_name']) && !empty($num['form']['full_name'])?$num['form']['full_name']:'empty')}}</td>
                     </tr>
                     @endif
                     @endforeach
                     @else
                     <tr>
                        <td>History Empty</td>
                     </tr>
                     @endif
                  </tbody>
               </table>
            </div>
         </div>
         {{-- 
         <div class="modal-footer">
            <button type="button" class="btn btn-success text-center load-btn" data-user="" data-userId="">Load</button>
         </div>
         --}}
      </div>
   </div>
</div>
{{-- Add User Modal --}}
<style>
   @media (min-width: 992px){
      .modal-lg {
         max-width: 1025px;
      }
   }
   @media (min-width: 576px){
      .modal-dialog {
         max-width: 628px;
         margin: 30px auto;
      }
   }
   .add-user-modal label{
      width: 70px;
   }
</style>
<div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <form action="{{route('addUser')}}" method="post">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-user-plus" style="width: 50px;"></i>Add User</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body add-user-modal">
               @csrf
               <input type="hidden" name="account_id" value="{{$activeGame['id']}}">
               <div class="form-control col-12">
                  <label for="id">User</label>
                  <select name="id" id="id" class="select2" required>
                     @if (isset($forms) && !empty($forms))
                     @foreach($forms as $a => $num)
                     <option value="{{$num['id']}}">{{$num['full_name']}}  [{{(!empty($num['facebook_name'])?$num['facebook_name']:'empty')}}]</option>
                     @endforeach
                     @else
                     <option disabled>No Users</option>
                     @endif
                  </select>
                  Full Name [ Facebook Name ]
               </div>
               <div class="form-control col-12">
                  <label for="game_id">Game Id</label>
                  <input type="text" name="game_id" id="game_id" required>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary">Add</button>
            </div>
         </form>
      </div>
   </div>
</div>
{{-- User History All Modal --}}
<div class="modal fade" id="exampleModalCenter5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         {{-- 
         <form action="{{route('addUser')}}" method="post">
         --}}
         <div class="modal-header">
            <h5 class="modal-title text-white" id="exampleModalLabel"><i class="fa fa-user-plus" style="width: 50px;"></i><span class="user-history-heading">User History</span></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="col-12 display-inline-flex">
               <div class="form-control">
                  <select name="type" id="" class="filter-type">
                     <option value="all">All</option>
                     <option value="load">Load</option>
                     <option value="redeem">Redeem</option>
                     <option value="refer">Bonus</option>
                     <option value="tip">Tip</option>
                     {{-- <option value="cashAppLoad">Cash App</option> --}}
                  </select>
               </div>
               <div class="form-control">   
                  <input type="date" name="start" class="filter-start">
               </div>
               <div class="form-control">   
                  <input type="date" name="end" class="filter-end">
               </div>
               <div class="form-control">   
                  <button class="filter-history" data-userId="" data-game="">Go</button>
               </div>
            </div>
            <div class="col-12">
               <table>
                  <thead>
                     <tr>
                        <th class="text-center">Date</th>
                        <th class="text-center form-history-related hidden">Game</th>
                        <th class="text-center">Amount</th>
                        <th class="text-center">Type</th>
                        <th class="text-center">Created By</th>
                     </tr>
                  </thead>
                  <tbody style="text-align: center!important;" class="user-history-body">
                  </tbody>
               </table>
            </div>
         </div>
         {{-- 
         <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Add</button>
         </div>
         --}}
      </div>
   </div>
</div>
{{-- User History Modal --}}
<div class="modal fade" id="exampleModalCenter3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         {{-- 
         <form action="{{route('addUser')}}" method="post">
         --}}
         <div class="modal-header">
            <h5 class="modal-title text-white" id="exampleModalLabel"><i class="fa fa-user-plus" style="width: 50px;"></i><span class="user-history-heading">User History</span></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <table>
               <thead>
                  <tr>
                     <th class="text-center">Date</th>
                     <th class="text-center">Amount</th>
                     {{-- 
                     <th class="text-center">Prev</th>
                     <th class="text-center">Amount</th>
                     --}}
                     <th class="text-center">Created By</th>
                  </tr>
               </thead>
               <tbody style="text-align: center!important;" class="user-history-body">
               </tbody>
            </table>
         </div>
         {{-- 
         <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Add</button>
         </div>
         --}}
      </div>
   </div>
</div>
{{-- Redeem History Modal --}}
<div class="modal fade" id="exampleModalCenter4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
   <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h3 class="modal-title color-white" id="exampleModalLongTitle"><i class="fa fa-scroll" style="width: 50px;"></i>Redeem</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="row">
               <table>
                  <thead>
                     <tr>
                        <th class="text-center">Date</th>
                        <th>To</th>
                        <th class="text-center">Amount</th>
                        <th class="text-center">Users Name</th>
                     </tr>
                  </thead>
                  <tbody style="text-align: center!important;">
                     @if (isset($history) && !empty($history))
                     @foreach($history as $a => $num)
                     @if ($num['type'] == 'refer')
                     <tr>
                        <td>{{date('D, M-d, Y H:i:a', strtotime($num['created_at']))}}</td>
                        <td>{{ (!empty($num['form_games']))?$num['form_games']['game_id']:'Deleted Player'}}</td>
                        <td class="text-center">{{$num['amount_loaded']}}</td>
                        <td>{{(isset($num['form']['full_name']) && !empty($num['form']['full_name'])?$num['form']['full_name']:'empty')}}</td>
                     </tr>
                     @endif
                     @endforeach
                     @else
                     <tr>
                        <td>History Empty</td>
                     </tr>
                     @endif
                  </tbody>
               </table>
            </div>
         </div>
         {{-- 
         <div class="modal-footer">
            <button type="button" class="btn btn-success text-center load-btn" data-user="" data-userId="">Load</button>
         </div>
         --}}
      </div>
   </div>
</div>
{{-- Form History Modal --}}
<div class="modal fade" id="exampleModalCenter6" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         {{-- 
         <form action="{{route('addUser')}}" method="post">
         --}}
         <div class="modal-header">
            <h5 class="modal-title text-white" id="exampleModalLabel"><i class="fa fa-user-plus" style="width: 50px;"></i><span class="user-history-heading">User History</span></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="col-12 display-inline-flex">
               <div class="card col-sm-12 col-md-12 col-lg-2">
                  <div class="card-body">
                  Total Tip : <span class="total-tip">0</span> 
                  </div>     
                  </div>
                  <div class="card col-sm-12 col-md-12 col-lg-2">
                  <div class="card-body">
                  Total Balance : <span class="total-balance">0</span> 
                  </div>     
                  </div>
                  <div class="card col-sm-12 col-md-12 col-lg-2">
                  <div class="card-body">
                  Total Redeem : <span class="total-redeem">0</span> 
                  </div>     
                  </div>
                  <div class="card col-sm-12 col-md-12 col-lg-2">
                  <div class="card-body">
                  Total Bonus : <span class="total-refer">0</span> 
                  </div>     
                  </div>
            
                  <div class="card col-sm-12 col-md-12 col-lg-2">
                  <div class="card-body">
                  Total Amount : <span class="total-amount">0</span> 
                  </div>     
                  </div>
                  <div class="card col-sm-12 col-md-12 col-lg-2">
                  <div class="card-body">
                  Total Profit : <span class="total-profit">0</span> 
                  </div>     
               </div>
           </div>
            <div class="col-12 display-inline-flex">
               <div class="form-control">
                  <select name="type" id="" class="filter-type1">
                     <option value="all">All</option>
                     <option value="load">Load</option>
                     <option value="redeem">Redeem</option>
                     <option value="refer">Bonus</option>
                     <option value="tip">Tip</option>
                     {{-- <option value="cashAppLoad">Cash App</option> --}}
                  </select>
               </div>
               <div class="form-control">   
                  <input type="date" name="start" class="filter-start1">
               </div>
               <div class="form-control">   
                  <input type="date" name="end" class="filter-end1">
               </div>
               <div class="form-control">   
                  <button class="filter-history form-all" data-userId="" data-game="">Go</button>
               </div>
            </div>
            <div class="col-12">
               <table>
                  <thead>
                     <tr>
                        <th class="text-center">Date</th>
                        <th class="text-center">Game</th>
                        <th class="text-center">Amount</th>
                        <th class="text-center">Type</th>
                        {{-- 
                        <th class="text-center">Prev</th>
                        <th class="text-center">Amount</th>
                        --}}
                        <th class="text-center">Created By</th>
                     </tr>
                  </thead>
                  <tbody style="text-align: center!important;" class="user-history-body">
                  </tbody>
               </table>
            </div>
         </div>
         {{-- 
         <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Add</button>
         </div>
         --}}
      </div>
   </div>
</div>
{{-- All History Modal --}}
<div class="modal fade" id="exampleModalCenter7" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document" style="max-width: 95%;">
      <div class="modal-content">
         {{-- 
         <form action="{{route('addUser')}}" method="post">
         --}}
         <div class="modal-header">
            <h5 class="modal-title text-white" id="exampleModalLabel"><i class="fa fa-user-plus" style="width: 50px;"></i><span class="user-history-heading">User History</span></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="col-12 display-inline-flex">
               <div class="form-control">
                  <select name="type" id="" class="filter-type12">
                     <option value="all">All</option>
                     <option value="load">Load</option>
                     <option value="redeem">Redeem</option>
                     <option value="refer">Bonus</option>
                     <option value="tip">Tip</option>
                     {{-- <option value="cashAppLoad">Cash App</option> --}}
                  </select>
               </div>
               <div class="form-control">   
                  <input type="date" name="start" class="filter-start12">
               </div>
               <div class="form-control">   
                  <input type="date" name="end" class="filter-end12">
               </div>
               <div class="form-control">   
                  <button class="filter-all-history user-all" data-userId="" data-game="">Go</button>
               </div>
            </div>
            <div class="col-12">
               <table>
                  <thead>
                     <tr>
                        <th class="text-center">Date</th>
                        <th class="text-center">FB Name</th>
                        <th class="text-center">Game</th>
                        <th class="text-center">Game Id</th>
                        <th class="text-center">Amount</th>
                        <th class="text-center">Type</th>
                        {{-- 
                        <th class="text-center">Prev</th>
                        <th class="text-center">Amount</th>
                        --}}
                        <th class="text-center">Created By</th>
                     </tr>
                  </thead>
                  <tbody style="text-align: center!important;" class="user-history-body">
                  </tbody>
               </table>
            </div>
         </div>
         {{-- 
         <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Add</button>
         </div>
         --}}
      </div>
   </div>
</div>
{{-- Undo Modal --}}
<div class="modal fade" id="exampleModalCenter8" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="max-width: 95%;">
     <div class="modal-content">
        <div class="modal-header">
           <h5 class="modal-title text-white" id="exampleModalLabel"><i class="fa fa-user-plus" style="width: 50px;"></i><span class="user-history-heading">User History</span></h5>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
           </button>
        </div>
        <div class="modal-body">
           <div class="col-12">
              <table>
                 <thead>
                    <tr>
                       <th class="text-center">Date</th>
                       <th class="text-center">FB Name</th>
                       <th class="text-center">Game</th>
                       <th class="text-center">Game Id</th>
                       <th class="text-center">Amount</th>
                       <th class="text-center">Type</th>
                       <th class="text-center">Action</th>
                    </tr>
                 </thead>
                 <tbody style="text-align: center!important;" class="undo-history-body">
                 </tbody>
              </table>
           </div>
        </div>        
     </div>
  </div>
</div>
@endsection
@section('script')
@php
   $time = 1;
   $setting = App\Models\Setting::where('type','data-reset-time')->first();
   if($setting != ""){
      $time = $setting->value;
   }
@endphp
<script>
   var time = '{{$time}}';
       function resetData(){
        $(".resetThis").each(function( index ) {
           $(this).text('$ 0');
           $(this).attr("data-balance",0);
       })
      //  toastr.success("Data Reset");
      //  console.log('asdfasdf');
   }
   // resetData();
   setInterval(resetData, 1000*time);
</script>
@endsection