<nav class="navbar">
  <div class="navbar-brand-container">
    <a class="navbar-brand" href="/">
      LearnIt!
    </a>
  </div>

  <div id="navbar-hamburger-menu" class="navbar-hamburger-menu">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="16" viewBox="0 0 20 16" fill="none">
      <path d="M0 1.33333C0 0.595833 0.638393 0 1.42857 0H18.5714C19.3616 0 20 0.595833 20 1.33333C20 2.07083 19.3616 2.66667 18.5714 2.66667H1.42857C0.638393 2.66667 0 2.07083 0 1.33333ZM0 8C0 7.2625 0.638393 6.66667 1.42857 6.66667H18.5714C19.3616 6.66667 20 7.2625 20 8C20 8.7375 19.3616 9.33333 18.5714 9.33333H1.42857C0.638393 9.33333 0 8.7375 0 8ZM20 14.6667C20 15.4042 19.3616 16 18.5714 16H1.42857C0.638393 16 0 15.4042 0 14.6667C0 13.9292 0.638393 13.3333 1.42857 13.3333H18.5714C19.3616 13.3333 20 13.9292 20 14.6667Z" fill="black"/>
    </svg>
  </div>

  <ul id="navbar-menu" class="navbar-menu">
    <li class="navbar-menu-item">
      <a class="navbar-menu-link" href="/courses">Mata Kuliah Saya</a>
    </li>
    <li class="navbar-menu-item">
      <a class="navbar-menu-link" href="/catalog">Katalog Mata Kuliah</a>
    </li>
    <li class="navbar-menu-item">
      <a class="navbar-menu-link" href="/settings">Pengaturan</a>
    </li>
    <li class="navbar-menu-item">
      <form action="/signout" method="POST">
        <button class="navbar-menu-link" type="submit">Sign Out</button>
      </form>
    </li>
  </ul>
</nav>

<script src="/scripts/navbar/navbar.js"></script>