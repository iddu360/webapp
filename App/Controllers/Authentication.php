<?php
/**
 * Created by PhpStorm.
 * User: AlKo
 * Date: 2019-02-18
 * Time: 01:25
 */

namespace App\Controllers;

use App\Config;
use App\Models\User;
use Core\Auth;
use Core\Hash;
use Core\Session;
use \Core\View;


class Authentication extends \Core\Controller
{

    /*
     * Session initialisieren
     */
    protected function before()
    {
        Session::init();
    }


    /*********************
     * GET Actions
     *********************/

    /*
     * Zeigt Login Page
     */
    public function signInAction()
    {
        View::renderTemplate('Authentication/signin.html');
    }

    /*
     * Zeigt Registrierungs Page
     */
    public function signUpAction()
    {
        View::renderTemplate('Authentication/signup.html');
    }


    /*********************
     * POST Actions
     *********************/

    /*
     *  Sucht den Nutzer mit dem übergebenen Passwort und startet die Session
     */
    public function loginAction()
    {

        $user = User::login($_POST['credential'], Hash::create('sha256', $_POST['password'],
            Config::HASH_KEY));

        if (!is_null($user)) {
            Auth::startSession($user);
            header('location: ' . Config::URL);
        } else {
            echo 'Login failed';
        }

    }

    /*
     * Registriert einen Benutzen mit den übergebenen Daten, prüft ob dieser schon vorhanden ist und gibt eine Message
     * aus
     */
    public function registerAction()
    {

        $user = new User(null, $_POST['firstname'], $_POST['name'], $_POST['username'], $_POST['email'],
            $_POST['mobile_number'], $_POST['plz'], $_POST['street'], $_POST['country'], $_POST['city']);

        if ($user->areCredentialsAvailable()) {

            if ($user->add(Hash::create('sha256', $_POST['password'], Config::HASH_KEY))) {

                $message = 'Registrierung erfolgreich! Logge dich jetzt ein!';

            } else {
                $message = 'Registrierung fehlgeschlagen! Unbekannter Fehler!';
            }

        } else {
            $message = 'Registrierung fehlgeschlagen! Der Benutzername existiert schon!';
        }
        echo $message;
        View::renderTemplate('Authentication/signup.html', array('message' => $message));

    }

    /*
     * Loggt einen Nutzer aus und beendet die Session
     */
    public function logoutAction()
    {
        Session::destroy();
        header('location: ' . Config::URL);
    }
}