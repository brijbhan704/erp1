<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;
use App\User;


class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('profile.edit');
    }

     public function show()
    {
        return view('profile.show');
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        
        auth()->user()->update($request->all());

        return back()->withStatus(__('Profile successfully updated.'));
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(Request $request)
    {

                 
            $request->old_password = openssl_decrypt(base64_decode($request->old_password),"AES-128-CBC",config('app.admin_enc_key'),OPENSSL_RAW_DATA,config('app.admin_enc_iv')); 
            $request->password = openssl_decrypt(base64_decode($request->new_password),"AES-128-CBC",config('app.admin_enc_key'),OPENSSL_RAW_DATA,config('app.admin_enc_iv')); 
            $request->password_confirmation = openssl_decrypt(base64_decode($request->confirm_password),"AES-128-CBC",config('app.admin_enc_key'),OPENSSL_RAW_DATA,config('app.admin_enc_iv')); 
              $request->merge([
                  'old_password' => $request->old_password,
                  'new_password' => $request->password,           
                  'confirm_password' => $request->password_confirmation,
              ]);

  $validator = Validator::make($request->all(), [            
                'password' => [
                'required',
                'string',
                'min:6',             // must be at least 10 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/',                
              ]
            ]);
            
            
            if($validator->fails()){       
              
              //$validator->errors()->add('field', );
                            
              $request->session()->flash('message.level', 'error');
              $request->session()->flash('message.content','Password should be min 6 char, alphanumeric,atleast one char capital and one special char');
             return back()->withPasswordStatus(__('Password should be min 6 char, alphanumeric,atleast one char capital and one special char'));
            }
             
    
        
        auth()->user()->update(['password' => Hash::make($request->get('password'))]);
        return back()->withPasswordStatus(__('Password successfully updated.'));
    }


      public function register(Request $request){
        try{

            $this->validate($request, [
            'name' => 'required|min:3|max:50',
            'email' => 'email',     
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6'
            ]);

            
            
            $register = DB::table('users')->insert([

                    'name' =>$request->name,
                    'email' =>$request->email,
                    'password' => Hash::make($request->Password)

            ]);
            // echo $register;die;
            return redirect('login')->withStatus('Registered Successfully');

        } catch(Exception $e){            
        abort(500, $e->message());
        }
     

    }

}
