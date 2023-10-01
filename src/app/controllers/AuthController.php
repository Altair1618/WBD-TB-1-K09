<?php

class AuthController {
    public function showSignInPage() {
        require_once VIEWS_DIR . 'auth/sign-in.php';
    }

    public function showSignUpPage() {
        require_once VIEWS_DIR . 'auth/sign-up.php';
    }

    public function signIn() {
        // TODO: Implement Sign In process
        Router::getInstance()->redirect('/');
    }

    public function signUp() {
        // TODO: Implement Sign Up process
        Router::getInstance()->redirect('/');
    }

    public function signOut() {
        // TODO: Delete User from Session or anything that implemented in signIn
        Router::getInstance()->redirect('/signin');
    }
}