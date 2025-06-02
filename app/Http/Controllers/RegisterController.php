<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        $enumValues = $this->getEnumValues('users', 'role');
        return view('backend.v_register.register', compact('enumValues'));
    }

    public function registerBackend(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[A-Z])(?=.*[\W_]).+$/',
            ],
        ]);

        $staffPicturePath = null;
        if ($request->hasFile('picture')) {
            $staffPicturePath = $request->file('picture')->storeAs(
                'backend/img/user',
                uniqid() . '_' . $request->file('picture')->getClientOriginalExtension(),
                'public'
            );
        }

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'picture' => $staffPicturePath,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'owner',
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Registration failed: ' . $e->getMessage())->withInput();
        }

        return redirect()->route('backend.login')->with('success', 'User registered successfully.');
    }

    private function getEnumValues($table, $column)
    {
        try {
            $row = DB::select("SHOW COLUMNS FROM $table LIKE '$column'");
            $enumString = $row[0]->Type ?? '';
            preg_match_all("/'([^']+)'/", $enumString, $matches);
            return $matches[1] ?? [];
        } catch (\Exception $e) {
            return [];
        }
    }
}