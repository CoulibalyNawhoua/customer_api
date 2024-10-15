<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class SettingController extends Controller
{
    public function email_setting_create() {

        

        $mail_mailer = env('MAIL_MAILER');
        $mail_host = env('MAIL_HOST');
        $mail_port = env('MAIL_PORT');
        $mail_from_address = env('MAIL_FROM_ADDRESS');
        $mail_from_name = env('MAIL_FROM_ADDRESS');
        $mail_username = env('MAIL_USERNAME');
        $mail_password = env('MAIL_PASSWORD');
        $mail_encryption = env('MAIL_ENCRYPTION');

        $data = [
            'mail_mailer'=> $mail_mailer,
            'mail_host'=> $mail_host,
            'mail_port'=> $mail_port,
            'mail_from_address'=> $mail_from_address,
            'mail_from_name'=> $mail_from_name,
            'mail_username'=> $mail_username,
            'mail_password'=> $mail_password,
            'mail_encryption'=> $mail_encryption,
        ];

        return response()->json($data);
        
    }

    public function email_setting_update(Request $request) {
        
        $toReplace = [
            'MAIL_MAILER='.env('MAIL_HOST'),
            'MAIL_HOST="'.env('MAIL_HOST').'"',
            'MAIL_PORT='.env('MAIL_PORT'),
            'MAIL_FROM_ADDRESS="'.env('MAIL_FROM_ADDRESS').'"',
            'MAIL_FROM_NAME="'.env('MAIL_FROM_NAME').'"',
            'MAIL_USERNAME="'.env('MAIL_USERNAME').'"',
            'MAIL_PASSWORD="'.env('MAIL_PASSWORD').'"',
            'MAIL_ENCRYPTION="'.env('MAIL_ENCRYPTION').'"',
        ];

        $replaceWith = [
            'MAIL_MAILER='.$request->mail_mailer,
            'MAIL_HOST="'.$request->mail_host.'"',
            'MAIL_PORT='.$request->mail_port,
            'MAIL_FROM_ADDRESS="'.$request->mail_from_address.'"',
            'MAIL_FROM_NAME="'.$request->mail_from_name.'"',
            'MAIL_USERNAME="'.$request->mail_username.'"',
            'MAIL_PASSWORD="'.$request->mail_password.'"',
            'MAIL_ENCRYPTION="'.$request->mail_encryption.'"',
        ];

        try {
            file_put_contents(base_path('.env'), str_replace($toReplace, $replaceWith, file_get_contents(base_path('.env'))));
            Artisan::call('cache:clear');

            return response()->json(['success' => 'Configuration de messagerie mise à jour avec succès !']);
        } catch (Exception $e) {
            return response()->json(['success' => $e->getMessage()]);
        }


    }
}
