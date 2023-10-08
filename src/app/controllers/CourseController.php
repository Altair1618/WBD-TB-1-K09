<?php

class CourseController {
    public function getManyCourses($params) {
        if (!isset($params['q-search'])) $params['q-search'] = null;
        if (!isset($params['q-fakultas'])) $params['q-fakultas'] = null;
        if (!isset($params['q-kode_prodi'])) $params['q-kode_prodi'] = null;
        if (!isset($params['q-sort_param'])) $params['q-sort_param'] = 'nama';
        if (!isset($params['q-sort_order'])) $params['q-sort_order'] = 'asc';

        require_once MODELS_DIR . 'MataKuliah.php';
        $mata_kuliah = new MataKuliahRepository();
        $params['courses'] = $mata_kuliah->getMataKuliahFiltered($params['q-search'], $params['q-fakultas'], $params['q-kode_prodi'], $params['q-sort_param'], $params['q-sort_order'], $params['page'], ITEMS_PER_PAGE);

        for ($i = 0; $i < count($params['courses']); $i++) {
            $params['courses'][$i]['pengajar'] = 'Yudhistira Dwi Wardhana Asnar';
        }

        $item_count = $mata_kuliah->getMataKuliahFilteredCount($params['q-search'], $params['q-fakultas'], $params['q-kode_prodi']);
        $params['page_count'] = ceil($item_count / ITEMS_PER_PAGE);

        return $params;
    }

    public function getCatalogData($params) {
        if (!isset($params['q-search'])) $params['q-search'] = null;
        if (!isset($params['q-fakultas'])) $params['q-fakultas'] = null;
        if (!isset($params['q-kode_prodi'])) $params['q-kode_prodi'] = null;
        if (!isset($params['q-sort_param'])) $params['q-sort_param'] = 'nama';
        if (!isset($params['q-sort_order'])) $params['q-sort_order'] = 'asc';

        require_once MODELS_DIR . 'MataKuliah.php';
        $mata_kuliah = new MataKuliahRepository();
        $params['courses'] = $mata_kuliah->getCatalog($params['q-search'], $params['q-fakultas'], $params['q-kode_prodi'], $params['q-sort_param'], $params['q-sort_order'], $params['page'], ITEMS_PER_PAGE);

        for ($i = 0; $i < count($params['courses']); $i++) {
            $params['courses'][$i]['pengajar'] = 'Yudhistira Dwi Wardhana Asnar';
        }

        $item_count = $mata_kuliah->getCatalogCount($params['q-search'], $params['q-fakultas'], $params['q-kode_prodi']);
        $params['page_count'] = ceil($item_count / ITEMS_PER_PAGE);

        return $params;
    }

    public function getManyCoursesByUser($params) {
        if (!isset($params['q-search'])) $params['q-search'] = null;
        if (!isset($params['q-fakultas'])) $params['q-fakultas'] = null;
        if (!isset($params['q-kode_prodi'])) $params['q-kode_prodi'] = null;
        if (!isset($params['q-sort_param'])) $params['q-sort_param'] = 'nama';
        if (!isset($params['q-sort_order'])) $params['q-sort_order'] = 'asc';

        require_once MODELS_DIR . 'MataKuliah.php';
        $mata_kuliah = new MataKuliahRepository();
        $params['courses'] = $mata_kuliah->getMataKuliahFilteredWithUser($params['q-search'], $params['q-fakultas'], $params['q-kode_prodi'], $params['q-sort_param'], $params['q-sort_order'], $params['page'], ITEMS_PER_PAGE);

        for ($i = 0; $i < count($params['courses']); $i++) {
            $params['courses'][$i]['pengajar'] = 'Yudhistira Dwi Wardhana Asnar';
        }

        $item_count = $mata_kuliah->getMataKuliahFilteredWithUserCount($params['q-search'], $params['q-fakultas'], $params['q-kode_prodi']);
        $params['page_count'] = ceil($item_count / ITEMS_PER_PAGE);

        return $params;
    }

    public function showMyCourses($params) {
        if (!isset($params['page'])) $params['page'] = 1;
        
        require_once MODELS_DIR . 'Fakultas.php';
        $fakultas = new FakultasRepository();

        require_once MODELS_DIR . 'ProgramStudi.php';
        $program_studi = new ProgramStudiRepository();

        $params['fakultas'] = $fakultas->getFakultasList();
        $params['program_studi'] = $program_studi->getProgramStudiList();

        require_once VIEWS_DIR . 'user/myCourses.php';
    }

    public function getCoursesHTML($params) {
        $params = $this->getManyCoursesByUser($params);

        $body_html = '';
        if (!isset($params['courses']) || count($params['courses']) == 0) {
            $body_html = "
            <div class='body-main'>
                <p class='empty-message'>Tidak ada mata kuliah yang sesuai</p>
            </div>
            ";
        } else {
            $body_html = "
            <div class='body-main'>
            ";

            foreach ($params['courses'] as $course) {
                if (!isset($course['image'])) {
                    $course['image'] = '/assets/images/Course_Default.svg';
                }

                $body_html .= "
                <div class='course-card'>
                    <img class='course-image' src='{$course['image']}' alt='course-image'>

                    <div class='course-info'>
                        <p class='course-code'> {$course['kode']} </p>
                        <p class='course-name'> {$course['nama']} </p>
                        <p class='course-lecturer'> {$course['pengajar']} </p>

                        <div class='course-button-container'>
                            <a class='course-detail-button' href='/courses/{$course['kode']}'>LIHAT</a>
                        </div>
                    </div>
                </div>
                ";
            }

            $body_html .= "
            </div>

            <div id='body-footer' class='body-footer'>
                <div class='page-container'>
            ";
            
            if ($params['page'] > 1) {
                $target = $params['page'] - 1;
                $body_html .= "
                    <button class='page-button'>
                        PREV
                    </button>
                    <button class='page-button'>
                        {$target}
                    </button>
                ";
            }

            $body_html .= "
                </div>

                <button id='current-page-button' class='current-page-button'>
                    {$params['page']}
                </button>

                <div class='page-container'>
            ";
            
            if ($params['page'] < $params['page_count']) {
                $target = $params['page'] + 1;
                $body_html .= "
                    <button class='page-button'>
                        {$target}
                    </button>
                    <button class='page-button'>
                        NEXT
                    </button>
                ";
            }

            $body_html .= "
                </div>
            </div>
            ";
        }

        echo $body_html;
    }

    public function showCourseCatalog($params) {
        if (!isset($params['page'])) $params['page'] = 1;
        
        require_once MODELS_DIR . 'Fakultas.php';
        $fakultas = new FakultasRepository();

        require_once MODELS_DIR . 'ProgramStudi.php';
        $program_studi = new ProgramStudiRepository();

        $params['fakultas'] = $fakultas->getFakultasList();
        $params['program_studi'] = $program_studi->getProgramStudiList();

        require_once VIEWS_DIR . 'user/courseCatalog.php';
    }

    public function getCatalogHTML($params) {
        $params = $this->getCatalogData($params);

        $body_html = '';
        if (!isset($params['courses']) || count($params['courses']) == 0) {
            $body_html = "
            <div class='body-main'>
                <p class='empty-message'>Tidak ada katalog mata kuliah yang sesuai</p>
            </div>
            ";
        } else {
            $body_html = "
            <div class='body-main'>
            ";

            foreach ($params['courses'] as $course) {
                if (!isset($course['image'])) {
                    $course['image'] = '/assets/images/Course_Default.svg';
                }

                $body_html .= "
                <div class='course-card'>
                    <img class='course-image' src='{$course['image']}' alt='course-image'>

                    <div class='course-info'>
                        <p class='course-code'> {$course['kode']} </p>
                        <p class='course-name'> {$course['nama']} </p>
                        <p class='course-lecturer'> {$course['pengajar']} </p>

                        <div class='course-button-container'>
                            <form action='/api/enroll?kode=" . $course['kode'] . "&user=" . $_SESSION['user']['id'] . "' method='POST' class='course-button-container'>
                                <button class='course-enroll-button' type='submit'>DAFTAR</a>
                            </form>
                        </div>
                    </div>
                </div>
                ";
            }

            $body_html .= "
            </div>

            <div id='body-footer' class='body-footer'>
                <div class='page-container'>
            ";
            
            if ($params['page'] > 1) {
                $target = $params['page'] - 1;
                $body_html .= "
                    <button class='page-button'>
                        PREV
                    </button>
                    <button class='page-button'>
                        {$target}
                    </button>
                    ";
                }
                
            $body_html .= "
                </div>

                <button id='current-page-button' class='current-page-button'>
                    {$params['page']}
                </button>

                <div class='page-container'>
            ";
            
            if ($params['page'] < $params['page_count']) {
                $target = $params['page'] + 1;
                $body_html .= "
                    <button class='page-button'>
                        {$target}
                    </button>
                    <button class='page-button'>
                        NEXT
                    </button>
                    ";
                }
                
            $body_html .= "
                </div>
                </div>
            ";
        }

        echo $body_html;
    }

    public function showCourseDetail($params) {
        require_once MODELS_DIR . 'MataKuliah.php';
        $mata_kuliah = new MataKuliahRepository();
        $params['course'] = $mata_kuliah->getMataKuliah($params['id']);
        $params['pengajar'] = 'Yudhistira Dwi Wardhana Asnar';
        
        require_once MODELS_DIR . 'Modul.php';
        $modul = new ModulRepository();
        $params['modules'] = $modul->getModulByMatKul($params['id']);

        require_once VIEWS_DIR . 'user/courseDetail.php';
    }

    public function getCoursesTaught($params) {
        if (!isset($params['q-search'])) $params['q-search'] = null;
        if (!isset($params['q-fakultas'])) $params['q-fakultas'] = null;
        if (!isset($params['q-kode_prodi'])) $params['q-kode_prodi'] = null;
        if (!isset($params['q-sort_param'])) $params['q-sort_param'] = 'nama';
        if (!isset($params['q-sort_order'])) $params['q-sort_order'] = 'asc';

        require_once MODELS_DIR . 'MataKuliah.php';
        $mata_kuliah = new MataKuliahRepository();
        $params['courses'] = $mata_kuliah->getMataKuliahFilteredWithUser($params['q-search'], $params['q-fakultas'], $params['q-kode_prodi'], $params['q-sort_param'], $params['q-sort_order'], $params['page'], ITEMS_PER_PAGE);

        for ($i = 0; $i < count($params['courses']); $i++) {
            $params['courses'][$i]['jumlah_peserta'] = $mata_kuliah->getEnrolledStudentCount($params['courses'][$i]['kode']);
        }

        $item_count = $mata_kuliah->getMataKuliahFilteredWithUserCount($params['q-search'], $params['q-fakultas'], $params['q-kode_prodi']);
        $params['page_count'] = ceil($item_count / ITEMS_PER_PAGE);

        return $params;
    }

    public function showCoursesTaught($params) {
        if (!isset($params['page'])) $params['page'] = 1;
        
        require_once MODELS_DIR . 'Fakultas.php';
        $fakultas = new FakultasRepository();

        require_once MODELS_DIR . 'ProgramStudi.php';
        $program_studi = new ProgramStudiRepository();

        $params['fakultas'] = $fakultas->getFakultasList();
        $params['program_studi'] = $program_studi->getProgramStudiList();

        require_once VIEWS_DIR . 'lecturer/coursesTaught.php';
    }

    public function getCoursesTaughtHTML($params) {
        $params = $this->getCoursesTaught($params);

        $body_html = '';
        if (!isset($params['courses']) || count($params['courses']) == 0) {
            $body_html = "
            <div class='body-main'>
                <p class='empty-message'>Tidak ada mata kuliah diajarkan yang sesuai</p>
            </div>
            ";
        } else {
            $body_html = "
            <div class='body-main'>
            ";

            foreach ($params['courses'] as $course) {
                if (!isset($course['image'])) {
                    $course['image'] = '/assets/images/Course_Default.svg';
                }

                $body_html .= "
                <div class='course-card'>
                    <img class='course-image' src='{$course['image']}' alt='course-image'>

                    <div class='course-info'>
                        <p class='course-code'> {$course['kode']} </p>
                        <p class='course-name'> {$course['nama']} </p>
                        <p class='course-lecturer'> Jumlah Peserta: {$course['jumlah_peserta']} </p>

                        <div class='course-button-container'>
                            <a class='course-detail-button' href='/courses/{$course['kode']}'>LIHAT</a>

                            <a aria-label='course-edit-button' href='/courses/{$course['kode']}/edit'>
                                <svg width='16' height='15' viewBox='0 0 16 15' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                    <path d='M14.3977 0.48621C13.7495 -0.16207 12.7015 -0.16207 12.0533 0.48621L11.1623 1.37427L14.0603 4.27229L14.9513 3.38127C15.5996 2.73299 15.5996 1.68509 14.9513 1.0368L14.3977 0.48621ZM5.54086 6.99862C5.36029 7.17919 5.22116 7.4012 5.14123 7.6469L4.26502 10.2755C4.17917 10.5301 4.24726 10.8113 4.43671 11.0037C4.62616 11.1962 4.90738 11.2613 5.16492 11.1754L7.79356 10.2992C8.0363 10.2193 8.25831 10.0802 8.44184 9.8996L13.3942 4.94425L10.4933 2.04327L5.54086 6.99862ZM3.27928 1.73837C1.71038 1.73837 0.4375 3.01125 0.4375 4.58015V12.1582C0.4375 13.7271 1.71038 15 3.27928 15H10.8574C12.4263 15 13.6991 13.7271 13.6991 12.1582V9.31644C13.6991 8.79249 13.2758 8.36918 12.7519 8.36918C12.2279 8.36918 11.8046 8.79249 11.8046 9.31644V12.1582C11.8046 12.6822 11.3813 13.1055 10.8574 13.1055H3.27928C2.75533 13.1055 2.33202 12.6822 2.33202 12.1582V4.58015C2.33202 4.05619 2.75533 3.63289 3.27928 3.63289H6.12106C6.64501 3.63289 7.06832 3.20958 7.06832 2.68563C7.06832 2.16168 6.64501 1.73837 6.12106 1.73837H3.27928Z' fill='black'/>
                                </svg>
                            </a>
    
                            <form action='/courses/{$course['kode']}/delete' method='POST'>
                                <button aria-label='course-delete-button' type='submit'>
                                    <svg width='14' height='15' viewBox='0 0 14 15' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                        <g clip-path='url(#clip0_155_780)'>
                                            <path d='M4.39844 0.518555L4.1875 0.9375H1.375C0.856445 0.9375 0.4375 1.35645 0.4375 1.875C0.4375 2.39355 0.856445 2.8125 1.375 2.8125H12.625C13.1436 2.8125 13.5625 2.39355 13.5625 1.875C13.5625 1.35645 13.1436 0.9375 12.625 0.9375H9.8125L9.60156 0.518555C9.44336 0.199219 9.11816 0 8.76367 0H5.23633C4.88184 0 4.55664 0.199219 4.39844 0.518555ZM12.625 3.75H1.375L1.99609 13.6816C2.04297 14.4229 2.6582 15 3.39941 15H10.6006C11.3418 15 11.957 14.4229 12.0039 13.6816L12.625 3.75Z' fill='black'/>
                                        </g>
            
                                        <defs>
                                            <clipPath id='clip0_155_780'>
                                                <rect width='13.125' height='15' fill='white' transform='translate(0.4375)'/>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                ";
            }

            $body_html .= "
            </div>

            <div id='body-footer' class='body-footer'>
                <div class='page-container'>
            ";
            
            if ($params['page'] > 1) {
                $target = $params['page'] - 1;
                $body_html .= "
                    <button class='page-button'>
                        PREV
                    </button>
                    <button class='page-button'>
                        {$target}
                    </button>
                ";
            }

            $body_html .= "
                </div>

                <button id='current-page-button' class='current-page-button'>
                    {$params['page']}
                </button>

                <div class='page-container'>
            ";
            
            if ($params['page'] < $params['page_count']) {
                $target = $params['page'] + 1;
                $body_html .= "
                    <button class='page-button'>
                        {$target}
                    </button>
                    <button class='page-button'>
                        NEXT
                    </button>
                ";
            }

            $body_html .= "
                </div>
            </div>
            ";
        }

        echo $body_html;
    }
}