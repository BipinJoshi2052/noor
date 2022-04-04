<?php

namespace App\Http\Controllers;
session_start();
use App\Models\Form;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Response;

class FormController extends Controller
{
    public function __construct() {
        $this->middleware('auth', ['except' => [
            'store','checkCaptcha','go'
        ]]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd('Sorry');
        return view('welcome');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function checkCaptcha(Request $request){
         $entered_captcha=strtoupper($request->captcha);
        $generated_captcha=strtoupper($_SESSION['captcha_token']);
        if($entered_captcha!=$generated_captcha) {
            return Response::json('false');
        }
        return Response::json('true');
     }
    public function store(Request $request, Form $form)
    {
        // if(!isset($_SESSION['captcha_token'])) die("invalid captcha");
        // $entered_captcha=strtoupper($request->captcha_token);
        // $generated_captcha=strtoupper($_SESSION['captcha_token']);
        // if($entered_captcha!=$generated_captcha) die("invalid captcha");

           $request->validate([

            'full_name' => 'required|min:3|max:20',
            'facebook_name' => 'required|min:7|unique:forms,facebook_name'.$form->id,
            'game_id' => 'required|min:7|unique:forms,game_id'.$form->id,
            'number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|unique:forms,number'.$form->id,
             'mail' => 'required',
         
        ]);
        $interval = Carbon::today();
        $daysToAdd = 30;
        $interval = $interval->addDays($daysToAdd);
        $final = date($interval);
        $count = 0;
        
     
        
        
           
        $formdata = array(
            'full_name'=>$request->full_name,
            'number'=>   $request->number,
            'email' =>   $request->email,
             'mail' =>   $request->mail,
            'r_id'  =>   $request->r_id,
             'game_id' => $request->game_id,
            'facebook_name'=>$request->facebook_name,
            'intervals'=>$final,
            'count'=> $count
        );


      $boyname  = $request->full_name;
      
     $sendtext = $boyname . ' ' . 'has joined to the club.
Yayyy ';
   
        Form::create($formdata);
      
                $number  =  '1'.$request->number;
                $basic  = new \Vonage\Client\Credentials\Basic("e20bd554", "M5arJoXIrJ8Kat1r");
                $client = new \Vonage\Client($basic);
              
  $sendtextuser = 'Congratulation '.$boyname . '!!! ' . '
  
Welcome to Noor Games Club. You will get a $40 reward each month for playing at-least of $400 or more inside a month.
We will inform you consequently once you are qualified to claim ';
        $message = $client->message()->send([
            'to' => $number,
            'from' => '18337222376',
            'text' => $sendtextuser
        ]);
        
        $basic  = new \Vonage\Client\Credentials\Basic("e20bd554", "M5arJoXIrJ8Kat1r");
        $client = new \Vonage\Client($basic);
        $message = $client->message()->send([
            'to' => '19292684435',
            'from' => '18337222376',
            'text' => $sendtext
        ]);


        return redirect('success')->with('success', 'You should be receiving the confirmation text on the number that you registered. Stay connected with Noor Games for much exciting Bonus & Reward.Happy Playing');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function show(Form $form)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    // public function edit(Form $form)
    // {

    //     return view('forms.edit', compact('form'));
    // }
      public function edit($id)
    {
        $form = Form::where('id',$id)->first();

        return view('forms.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $form = Form::find($id);
        $this->validate($request, [
            'full_name' => 'required',
           
            'number' => 'required',
            
        ]);
        $form->full_name = $request->full_name;
        $form->email = $request->email;
        $form->intervals = $request->intervals;
        
        $form->number = $request->number;
          $form->count = $request->count;
        $form->note = $request->note;
        $form->facebook_name = $request->facebook_name;
        $form->game_id = $request->game_id;
        $form->save();
        return redirect(route('home'))->with('message', " Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
        $form = Form::where('id',$id)->delete();
    //   Form::find($id)->delete($id);
  
   return redirect(route('home'))->with('message', " Deleted Successfully");
    }
    
      public function saveNote(Request $request)
    {
        $formdata = array(
            'note'       =>   isset($request->note)?($request->note):null,
        );
        $sql = Form::find($request->cid);  
        $sql->note = isset($request->note)?($request->note):null;
        if(!$sql->save()){
            return Response::json(['error' => $sql],404);
        }
            return Response::json('Note Saved');
    }
    
    public function restorePlayers($id)
    {
        $form = Form::withTrashed()->find($id);
        if(!is_null($form))
        {
            $form->restore();
        }
          return redirect(route('home'))->with('message', " Player restored Successfully");
    }
    
     public function forceDeletePlayers($id)
    {
        $form = Form::withTrashed()->find($id);
        if(!is_null($form))
        {
            $form->forceDelete();
        }
          return redirect(route('home'))->with('message', " Player deleted Successfully");
    }
 
}
