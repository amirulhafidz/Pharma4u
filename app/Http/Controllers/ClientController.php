<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mail\Websitemail;
use App\Models\Client;
use App\Models\City;


class ClientController extends Controller
{
    public function ClientLogin()
    {
        return view('client.client_login');
    }


    public function ClientLoginSubmit(Request $request)
    {
        
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $check = $request->all();
        $data = [
            'email' => $check['email'],
            'password' => $check['password'],
        ];
        if (Auth::guard('client')->attempt($data)) {
            return redirect()->route('client.dashboard')->with('success', 'Login Successfully');
        } else {
            return redirect()->route('client.login')->with('error', 'Invalid Credentials');
        }
    }

    public function ClientRegister()
    {
        return view('client.client_register');
    }

    public function ClientRegisterSubmit(Request $request)
    {
        $request->validate([
            'name' => ['required','string','max:200'],
            'email' => ['required','string','unique:clients'],

        ]);

        Client::insert([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'role' => 'client',
            'status' => '0',

        ]);

        $notification = array(
            'message' => 'Client Updated Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->route('client.login')->with($notification);
    }

    public function ClientForgetPassword()
    {
        return view('client.client_forget_password');
    }

    public function ClientPasswordSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $client_data = Client::where('email', $request->email)->first();
        if (!$client_data) {
            return redirect()->back()->with('error', 'Email not found');
        }
        $token = hash('sha256', time());
        $client_data->token = $token;
        $client_data->update();

        $reset_link = url('client/reset-password/' . $token . '/' .
            $request->email);
        $subject = "Reset Password";
        $message = "Please Click on th elink below to reset password <br>";
        $message .= "<a href='" . $reset_link . "'>Click Here </a>";

        \Mail::to($request->email)->send(new Websitemail(
            $subject,
            $message
        ));
        return redirect()->back()->with('success', 'Reset Password Link Send On Your Email');

    }

    public function ClientResetPassword($token, $email)
    {
        $client_data = Client::where('email', $email)->where(
            'token',
            $token
        )->first();

        if (!$client_data) {
            return redirect()->route('client.client_login')->with(
                'error',
                'Invalid Token or Email'
            );
        }
        return view('client.client_reset_password', compact('token', 'email'));

    }

    public function ClientResetPasswordSubmit(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ]);

        $client_data = Client::where('email', $request->email)->where
        ('token', operator: $request->token)->first();
        $client_data->password = Hash::make($request->password);
        $client_data->token = "";
        $client_data->update();

        return redirect()->route('client.login')->with(
            'success',
            'Password Reset Successfully'
        );
    }

    public function ClientDashboard(){
        return view('client.index');
    }

    public function ClientLogout()
    {

        Auth::guard('client')->logout();
        return redirect()->route('client.login')->with('success', 'Logout Successfully');
    }

    //private method
    public function ClientProfile()
    {
        $city = City::latest()->get();
        $id = Auth::guard('client')->id();
        $profileData = Client::find($id);
        return view('client.client_profile', compact('profileData' , 'city'));
    }


    public function ClientProfileStore(Request $request)
    {
        $id = Auth::guard('client')->id();
        $data = Client::find($id);

        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->city_id = $request->city_id;
        $data->shop_info = $request->shop_info;


        $oldPhotoPath = $data->photo;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/client_images'), $filename);
            $data->photo = $filename;

            if ($oldPhotoPath && $oldPhotoPath !== $filename) {
                $this->deleteOldImage($oldPhotoPath);
            }
        }

        if ($request->hasFile('cover_photo')) {
            $file1 = $request->file('cover_photo');
            $filename1 = time() . '.' . $file1->getClientOriginalExtension();
            $file1->move(public_path('upload/client_images'), $filename1);
            $data->cover_photo = $filename1;
        }

        $data->save();
        $notification = array(
            'message' => 'Profile Updated Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }

    private function deleteOldImage(string $oldPhotoPath): void
    {
        $fullPath = public_path('upload/client_images/' . $oldPhotoPath);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }
    //end private method

    public function ClientChangePassword()
    {
        $id = Auth::guard('client')->id();
        $profileData = Client::find($id);
        return view('client.client_change_Password', compact
        ('profileData'));
    }

    public function ClientPasswordUpdate(Request $request)
    {
        $client = Auth::guard('client')->user();
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        if (!Hash::check($request->old_password, $client->password)) {
            $notification = array(
                'message' => 'Old Password Does not Match!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
        /// Update new passwd
        Client::whereId($client->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        $notification = array(
            'message' => 'Password Change Successfully',
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }

}
