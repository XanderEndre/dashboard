<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request) : View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request) : RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request) : RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Set the user's custom theme color
     */
    public function updateThemeColor(Request $request) : RedirectResponse
    {
        $validatedData = $request->validate([
            'theme_color' => 'required|in:red,orange,yellow,green,blue,purple,pink'
        ]);

        // check if the users thing is dark mode:
        if ($validatedData['theme_color'] == 'darkMode') {
            session()->put('warehouse-dark-mode', '');
        }

        // Update the user's theme_color in the database
        auth()->user()->update(['theme_color' => $validatedData['theme_color']]);

        // update it locally
        session()->put('theme_color', auth()->user()->theme_color);


        return redirect()->back()->with('status', 'Theme color updated successfully!');
    }
}
