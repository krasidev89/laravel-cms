<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::select('users.*');

            if ($request->get('trashed')) {
                $users->onlyTrashed();
            }

            $startDate = $request->get('start_date') ?? $request->get('end_date');
            $endDate = $request->get('end_date') ?? $request->get('start_date');

            if ($startDate && $endDate) {
                $users->createdBetween($startDate, $endDate);
            }

            $datatable = datatables()->eloquent($users);

            $datatable->addColumn('actions', function ($user) {
                return view('backend.users.table.table-actions', compact('user'));
            });

            return $datatable->make(true);
        }

        return view('backend.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()]
        ]);

        User::create($data);

        return redirect()->route('backend.users.index')
            ->withSuccess(__('User added successfully!'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('backend.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id . ',id'],
            'password' => ['nullable', 'confirmed', Password::defaults()]
        ]);

        if (is_null($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('backend.users.index')
            ->withSuccess(__('User updated successfully!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (!$user->is_admin) {
            return $user->delete();
        }
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function restore(User $user)
    {
        return $user->restore();
    }

    /**
     * Force delete the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(User $user)
    {
        return $user->forceDelete();
    }
}
