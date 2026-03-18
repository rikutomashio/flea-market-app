<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user();

        $defaultAddress = $user->addresses()
            ->where('is_default', true)
            ->first();

        return view('profile.edit', compact('user', 'defaultAddress'));
    }

    public function update(ProfileRequest $request)
{
    $data = $request->validated();

    $user = $request->user();

    $user->fill($data);

    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    if ($request->hasFile('profile_image')) {

        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }

        $path = $request->file('profile_image')->store('profile_images', 'public');

        $user->profile_image = $path;
    }

    $user->save();

    $defaultAddress = $user->addresses()->where('is_default', true)->first();

    $addressData = [
        'postal_code' => $data['postal_code'],
        'prefecture'  => $data['prefecture'],
        'city'        => $data['city'],
        'street'      => $data['street'],
        'building'    => $data['building'] ?? null,
    ];

    if ($defaultAddress) {
        $defaultAddress->update($addressData);
    } else {
        $user->addresses()->create($addressData + ['is_default' => true]);
    }

    return redirect()->route('mypage')->with('status', 'profile-updated');
}
}