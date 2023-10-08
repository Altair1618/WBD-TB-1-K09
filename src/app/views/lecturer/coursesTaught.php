<!DOCTYPE html>
<html lang="en">

<head>
  <title>LearnIt!</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="/styles/global.css" rel="stylesheet">
  <link href="/styles/navbar/navbar.css" rel="stylesheet">
  <link href="/styles/course/myCourses.css" rel="stylesheet">
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
  <?php require_once COMPONENTS_DIR . 'navbar.php'; ?>

  <div class="body-container">
    <div class="body-header">
      <p class="page-title"> Mata Kuliah Saya </p>

      <div class="search-bar-container">
        <div class="search-bar">
          <input type="text" id="search-input" class="search-input" placeholder="Ketikkan kode/nama mata kuliah">
  
          <button type="submit" id="search-button" class="search-button" >
            <img class="search-button" src="/assets/icons/Search_Button.svg" alt="search">
          </button>
        </div>
  
        <a href="/courses/add">  
          <button class="add-course-button">
            TAMBAH
          </button>
        </a>
      </div>

      <div class="filter-sort-bar">
        <div class="filter-bar">
          <label class="selector-label" for="fakultas-selector">Fakultas:</label>
          <select id="fakultas-selector" class="selector">
            <option value="all"></option>
            <?php foreach ($params['fakultas'] as $fakultas): ?>
              <option value="<?=$fakultas['kode']; ?>"><?=$fakultas['kode']; ?></option>
            <?php endforeach; ?>
          </select>
          
          <label class="selector-label" for="prodi-selector">Prodi:</label>
          <select id="prodi-selector" class="selector">
            <option value="all"></option>
            <?php foreach ($params['program_studi'] as $program_studi): ?>
              <option value="<?=$program_studi['kode']; ?>"><?=$program_studi['kode'] . ' - ' . $program_studi['nama']; ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="sort-bar">
          <label class="selector-label" for="sort-selector">Urut Berdasarkan:</label>
          <select id="sort-selector" class="selector">
            <option value="nama">Nama</option>
            <option value="kode">Kode</option>
          </select>
          
          <label class="selector-label" for="order-selector">Mode Urutan:</label>
          <select id="order-selector" class="selector">
            <option value="asc">A-Z</option>
            <option value="desc">Z-A</option>
          </select>
        </div>
      </div>
    </div>

    <div id="body-main-container" class="body-main-container">
      <?php if (isset($_SESSION['messages']) && $_SESSION['messages'] != null): ?>
        <?php foreach ($_SESSION['messages'] as $message): ?>
          <div class="message-container">
            <p class="message-text">
              <?=$message; ?>
            </p>

            <svg class="message-close-button" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M13.7296 1.64106C14.1415 1.2161 14.0759 0.584899 13.5801 0.231803C13.0843 -0.121293 12.3479 -0.0650481 11.936 0.359917L7 5.43763L2.06401 0.359917C1.65207 -0.0650481 0.915684 -0.121293 0.419898 0.231803C-0.0758883 0.584899 -0.141507 1.2161 0.270433 1.64106L5.47983 7L0.270433 12.3589C-0.141507 12.7839 -0.0758883 13.4151 0.419898 13.7682C0.915684 14.1213 1.65207 14.065 2.06401 13.6401L7 8.56237L11.936 13.6401C12.3479 14.065 13.0843 14.1213 13.5801 13.7682C14.0759 13.4151 14.1415 12.7839 13.7296 12.3589L8.52017 7L13.7296 1.64106Z" fill="black"/>
            </svg>
          </div>

        <?php endforeach; ?>
        
        <?php unset($_SESSION['messages']); ?>
      <?php endif; ?>

      <?php
        $controller = new CourseController();
        $controller->getCoursesTaughtHTML($params);
      ?>
    </div>
  </div>

  <script src="/scripts/course/coursesTaught.js"></script>
</body>

</html>
