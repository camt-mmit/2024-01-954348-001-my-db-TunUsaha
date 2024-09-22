<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected string $title = 'Users';
    protected int $itemsPerPage = 10;

    protected function getQuery(): Builder
    {
        return User::orderBy('id');
    }

    protected function getItemsPerPage(): int
    {
        return $this->itemsPerPage;
    }

    protected function getListViewName(): string
    {
        return 'users.list';
    }

    public function list(Request $request): View
{
    $search = $request->query('term');
    $query = $this->getQuery()->when($search, function ($query) use ($search) {
        return $query->where('name', 'like', "%{$search}%")
                     ->orWhere('email', 'like', "%{$search}%")
                     ->orWhere('role', 'like', "%{$search}%");
    });

    $users = $query->paginate($this->getItemsPerPage());

    return view($this->getListViewName(), [
        'title' => 'User List',
        'search' => ['term' => $search],
        'users' => $users,
    ]);
}


    public function show(string $email): View
    {
        $user = User::where('email', $email)->firstOrFail();
        return view('users.view', [
            'title' => 'User Details',
            'user' => $user,
        ]);
    }

    public function showCreateForm(): View
    {
        Gate::authorize('create', User::class); // Authorization check
        return view('users.create-form', [
            'title' => 'Create New User',
        ]);
    }

    public function create(Request $request): RedirectResponse
    {
        Gate::authorize('create', User::class); // Authorization check

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|string|in:ADMIN,USER', // ทำให้ต้องมีการระบุ
        ]);


        $user = User::create(array_merge($validatedData, [
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]));


        return redirect()
            ->route('users.list')
            ->with('status', "User {$user->name} was created.");
    }

    public function showEditForm(string $userId): View
    {
        Gate::authorize('update', User::class); // Authorization check

        $user = User::findOrFail($userId);
        return view('users.edit-form', [
            'user' => $user,
            'title' => "Edit User: " . $user->name,
        ]);
    }

    public function update(Request $request, string $userId): RedirectResponse
    {
        Gate::authorize('update', User::class); // Authorization check

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $userId,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user = User::findOrFail($userId);
        $user->update(array_filter($validatedData, fn($value) => !is_null($value)));

        return redirect()
            ->route('users.list')
            ->with('status', "User {$user->name} was updated.");
    }

    public function delete(string $userId): RedirectResponse
{
    $userToDelete = User::findOrFail($userId);

    // ตรวจสอบการอนุญาต
    Gate::authorize('delete', [$userToDelete]); // ส่งตัวแปรที่ต้องการลบ

    $userToDelete->delete();

    return redirect()
        ->route('users.list')
        ->with('status', "User {$userToDelete->name} was deleted.");
}


    public function showSelf(): View
{
    $user = Auth::user(); // ใช้ Auth แทน auth()
    return view('users.self', [
        'user' => $user,
    ]);
}

/*public function updateSelf(Request $request): RedirectResponse
{
    $user = Auth::user();

    // ตรวจสอบว่า $user ไม่ใช่ null
    if (!$user) {
        return redirect()->route('login')->with('error', 'Please log in first.');
    }

    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:6|confirmed',
    ]);

    // ใช้ array_filter เพื่อไม่ให้ส่งค่าที่เป็น null
    $user->fill(array_filter($validatedData, fn($value) => !is_null($value)));

    // ถ้ามีการเปลี่ยนแปลงรหัสผ่าน ให้ทำการเข้ารหัส
    if (!empty($validatedData['password'])) {
        $user->password = bcrypt($validatedData['password']);
    }

    $user->save(); // ใช้ save แทน update

    return redirect()
        ->route('users.self')
        ->with('status', "Your profile has been updated.");
}*/

}
