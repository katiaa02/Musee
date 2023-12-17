<?php 

if (!isset($_SESSION)) { 
    session_start();
}
?>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="../index.php"> <span>Musé</span>EVASION</a>
            <nav class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </nav>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="../index.php">Accueil<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="precherche.php">Musées</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../contact.php">Contact</a>
                    </li>
                    <?php
                if (isset($_SESSION['username'])) { ?>
                      <li class="nav-item"> <a class="nav-link" href="../Favoris/favorites.php">Favoris</a> </li>
                    <?php }?>
                </ul>
                <?php
                if (isset($_SESSION['username'])) {
                    $username = $_SESSION['username'];
                    echo '<div class="navbar-nav ml-auto">
                        <ul class="navbar-nav mr-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link mx-2 dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false" onclick="toggleDropdownMenu()">
                                ' . $username . '
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" id="navbarDropdownMenu">
                                <a class="dropdown-item" href="../profil.php">Profil</a>
                                <a class="dropdown-item" href="../auth/logout.php">Déconnexion</a>
                            </div>


                        </li>
                        </ul>
                    </div>';
                }
                else {
                    $buttonText = 'Se connecter';
                    echo '<a class="btn custom-btn ml-auto" onclick="window.location.href=\'../auth/connexion.php\'">
                        <span class="icon">
                            <svg style="margin-right: 6px; margin-bottom: 2px;" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z"/>
                            </svg>' . $buttonText . '
                        </span> 
                        </a>';
                }?>
            </div>
        </nav>
        
    </header>
        <!-- Scripts Bootstrap (jQuery et Popper.js) -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
                        function toggleDropdownMenu() {
                            var dropdownMenu = document.getElementById("navbarDropdownMenu");
                            dropdownMenu.classList.toggle("show");
                        }

                        window.onclick = function(event) {
                            if (!event.target.matches('.dropdown-toggle')) {
                                var dropdownMenu = document.getElementById("navbarDropdownMenu");
                                if (dropdownMenu.classList.contains('show')) {
                                    dropdownMenu.classList.remove('show');
                                }
                            }
                        }
        </script>