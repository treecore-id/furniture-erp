<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class AppSettingController extends Controller
{
    public function edit(): Response
    {
        return Inertia::render('settings/AppSetting');
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_logo' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $company_logo = $request->file('company_logo');
        $logo_url = null;

        DB::beginTransaction();

        try {
            AppSetting::where('key_name', 'company_name')->update(['value' => $validated['company_name']]);

            if ($company_logo) {
                $logo_setting = AppSetting::where('key_name', 'company_logo')->firstOrFail();
                $oldUrl = $logo_setting->value;

                $path = $company_logo->store('images/logo', 'public');
                $logo_url = Storage::url($path);

                $logo_setting->update(['value' => $logo_url]);

                if ($oldUrl && Storage::disk('public')->exists(str_replace('/storage/', '', $oldUrl))) {
                    Storage::disk('public')->delete(str_replace('/storage/', '', $oldUrl));
                }
            }

            $newLogoUrl = AppSetting::where('key_name', 'company_logo')->value('value');

            Cache::forget('app_settings_config');
            DB::commit();

            Session::flash('new_logo_url', $newLogoUrl);
            Session::flash('success', $this->messages['update_success']);
            return back();
        } catch (\Exception $e) {
            Log::error('Failed to save setting data: ' . $e->getMessage(), [
                'input_data' => $validated
            ]);
            Session::flash('error', $this->messages['save_failed']);
            return back()->withInput();
        }
    }
}
