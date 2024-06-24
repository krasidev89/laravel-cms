<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('backend.profile.show');
    }

    /**
     * Update the resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($request->get('_form') == 'update-password') {
            $data = $request->validate([
                'current_password' => ['required', 'current_password'],
                'password' => ['required', 'confirmed', Password::defaults()]
            ]);

            $withSuccess = __('Profile password updated successfully!');
        } else {
            $data = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . \Auth::id() . ',id']
            ]);

            $withSuccess = __('Profile updated successfully!');
        }

        \Auth::user()->update($data);

        return redirect()->route('backend.profile.show')
            ->withSuccess($withSuccess);
    }

    /**
     * Remove the resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $profile = \Auth::user();

        \Auth::logout();

        session()->invalidate();

        session()->regenerateToken();

        $profile->forceDelete();

        return redirect()->route('login');
    }
}
