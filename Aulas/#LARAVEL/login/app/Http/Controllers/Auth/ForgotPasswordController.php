<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    |Este controlador é responsável por manusear e-mails de redefinição de senha e
    |inclui uma característica que ajuda a enviar essas notificações de
    |seu aplicativo para seus usuários.Sinta-se à vontade para explorar este traço.
    |
    */

    use SendsPasswordResetEmails;
}
