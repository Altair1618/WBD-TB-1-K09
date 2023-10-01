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
        require_once VIEWS_DIR . 'home/homepage.php';
    }

    public function signUp() {
        // TODO: Implement Sign Up process
        require_once VIEWS_DIR . 'home/homepage.php';
    }
}