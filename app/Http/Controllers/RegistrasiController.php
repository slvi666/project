<?php

namespace App\Http\Controllers;

use App\Models\Registrasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\RegistrasiImport;

class RegistrasiController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $role = $request->query('role');

        $query = Registrasi::query();

        if ($role) {
            $query->where('role_name', $role);
        }

        $users = $query->get();

        return view('registrasi.index', compact('users', 'role'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('registrasi.create'); // Return view with form to create a new user
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_name' => 'required|in:siswa,guru,Admin,Orang Tua,Perpustakaan',
        ]);

        Registrasi::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_name' => $request->role_name,
        ]);

        return redirect()->route('registrasi.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     *
     * @param  \App\Models\Registrasi  $registrasi
     * @return \Illuminate\Http\Response
     */
    public function show(Registrasi $registrasi)
    {
        return view('registrasi.show', compact('registrasi')); // Return view with user data
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  \App\Models\Registrasi  $registrasi
     * @return \Illuminate\Http\Response
     */
    public function edit(Registrasi $registrasi)
    {
        return view('registrasi.edit', compact('registrasi')); // Return view with form to edit user
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Registrasi  $registrasi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Registrasi $registrasi)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $registrasi->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role_name' => 'required|in:siswa,guru,Admin,Orang Tua,Perpustakaan',
        ]);

        $registrasi->name = $request->name;
        $registrasi->email = $request->email;
        if ($request->filled('password')) {
            $registrasi->password = Hash::make($request->password);
        }
        $registrasi->role_name = $request->role_name;
        $registrasi->save();

        return redirect()->route('registrasi.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  \App\Models\Registrasi  $registrasi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Registrasi $registrasi)
    {
        $registrasi->delete();

        return redirect()->route('registrasi.index')->with('success', 'User deleted successfully.');
    }



public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv',
    ]);

    Excel::import(new RegistrasiImport, $request->file('file'));

    return redirect()->route('registrasi.index')->with('success', 'Users imported successfully.');
}

}
