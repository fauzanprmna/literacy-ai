<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::query()
            ->latest()
            ->paginate(10);

        return view('user.index', [
            'users' => $users,
            'pageTitle' => 'User',
            'pageHeader' => 'Daftar User',
            'pageDescription' => 'Kelola semua user sistem.',
            'createRoute' => 'user.create',
            'showImportButton' => true,
            'importRoute' => 'users.import.form',
        ]);
    }

    public function mahasiswaIndex(): View
    {
        $users = User::query()
            ->where('role', 'mahasiswa')
            ->latest()
            ->paginate(10);

        return view('user.index', [
            'users' => $users,
            'pageTitle' => 'Mahasiswa',
            'pageHeader' => 'Daftar Mahasiswa',
            'pageDescription' => 'Kelola semua user mahasiswa.',
            'createRoute' => 'user.mahasiswa.create',
            'showImportButton' => true,
            'importRoute' => 'mahasiswa.import.form',
        ]);
    }

    public function dosenIndex(): View
    {
        $users = User::query()
            ->where('role', 'dosen')
            ->latest()
            ->paginate(10);

        return view('user.index', [
            'users' => $users,
            'pageTitle' => 'Dosen',
            'pageHeader' => 'Daftar Dosen',
            'pageDescription' => 'Kelola semua user dosen.',
            'createRoute' => 'user.dosen.create',
            'showImportButton' => true,
            'importRoute' => 'dosen.import.form',
        ]);
    }

    public function create(): View
    {
        return view('user.create', [
            'pageTitle' => 'Tambah User',
            'pageHeader' => 'Tambah User',
            'formAction' => route('user.store'),
        ]);
    }

    public function createMahasiswa(): View
    {
        return view('user.create', [
            'pageTitle' => 'Tambah Mahasiswa',
            'pageHeader' => 'Tambah Mahasiswa',
            'formAction' => route('user.mahasiswa.store'),
            'fixedRole' => 'mahasiswa',
        ]);
    }

    public function createDosen(): View
    {
        return view('user.create', [
            'pageTitle' => 'Tambah Dosen',
            'pageHeader' => 'Tambah Dosen',
            'formAction' => route('user.dosen.store'),
            'fixedRole' => 'dosen',
        ]);
    }

    public function store(UserRequest $request): RedirectResponse
    {
        User::create($request->validated());

        return redirect()
            ->route('user.index')
            ->with('success', 'User berhasil dibuat.');
    }

    public function storeMahasiswa(UserRequest $request): RedirectResponse
    {
        User::create($request->validated());

        return redirect()
            ->route('user.mahasiswa.index')
            ->with('success', 'Mahasiswa berhasil dibuat.');
    }

    public function storeDosen(UserRequest $request): RedirectResponse
    {
        User::create($request->validated());

        return redirect()
            ->route('user.dosen.index')
            ->with('success', 'Dosen berhasil dibuat.');
    }

    public function show(User $user): View
    {
        return view('user.show', compact('user'));
    }

    public function edit(User $user): View
    {
        return view('user.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $user->update($request->validated());

        return redirect()
            ->route('user.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()
            ->route('user.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
