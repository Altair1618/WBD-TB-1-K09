<?php

class PageController {
    public function home($params) {
        header('Location: /courses');

        return;
    }

    public function courses($params) {
        if (!isset($_SESSION['isAuthenticated']) || !$_SESSION['isAuthenticated']) {
            header('Location: /signin');
            return;
        }
        
        if ($_SESSION['user']['tipe'] == PENGGUNA_TIPE_MAHASISWA) {
            require_once CONTROLLERS_DIR . 'CourseController.php';

            $controller = new CourseController();
            $controller->showMyCourses($params);
        } else {
            require_once CONTROLLERS_DIR . 'ErrorController.php';

            $params['errorCode'] = 403;
            $controller = new ErrorController();
            $controller->showErrorPage($params);
        }
    }

    public function catalog($params) {
        if (!isset($_SESSION['isAuthenticated']) || !$_SESSION['isAuthenticated']) {
            header('Location: /signin');
            return;
        }
        
        if ($_SESSION['user']['tipe'] == PENGGUNA_TIPE_MAHASISWA) {
            require_once CONTROLLERS_DIR . 'CourseController.php';

            $controller = new CourseController();
            $controller->showCourseCatalog($params);
        } else {
            require_once CONTROLLERS_DIR . 'ErrorController.php';

            $params['errorCode'] = 403;
            $controller = new ErrorController();
            $controller->showErrorPage($params);
        }
    }
}
