<?php
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://kit.fontawesome.com/1deffa5961.js" crossorigin="anonymous"></script>
        <link rel="shortcut icon" href="../images/ikona.png">
        <title>Secur IT | O Firmie</title>
    </head>
    <body>
        <div class="tlo"></div>
        <div class="progress-bar"></div>
        
        <main class="main">
            <?php

                include("nav.php");
            ?>
            
            <div class="scroll-container">
                <?php
                    include('../DB/db_about_company.php');
                    $baza = new db_about_company();
                    $baza->databaseConnect();
                    $data = $baza->selectAbout_company();
                    
                    if (!empty($data) && mysqli_num_rows($data) > 0) {
                        $count = 0;
                        $backgrounds = [
                            '../images/about/bg1.jpg',
                            '../images/about/bg2.jpg',
                            '../images/about/bg3.jpg',
                            '../images/about/bg4.jpg',
                            '../images/about/bg5.jpg'
                        ];
                        
                        $images = [
                            '../images/about/company1.jpg',
                            // company2.jpg zastąpione przez mapę
                            '../images/about/company3.jpg',
                            '../images/about/company4.jpg',
                            '../images/about/company5.jpg'
                        ];
                        
                        while($row = mysqli_fetch_assoc($data)) {
                            $bgIndex = $count % count($backgrounds);
                            $isEven = $count % 2 === 0;
                            
                            echo "<section class='section' id='section-".$count."'>";
                            echo "<div class='section-bg' style='background-image: url(".$backgrounds[$bgIndex].");'></div>";
                            echo "<div class='section-content'>";
                            
                            if ($isEven) {
                                // Standard layout
                                echo "<h2 class='section-title'>".$row['title']."</h2>";
                                echo "<div class='section-description'>".$row['description']."</div>";
                                
                                // Jeśli to druga sekcja (index 1), dodaj mapę zamiast zdjęcia
                                if ($count === 1) {
                                    echo "<div id='company-map-container'>";
                                    echo "<h2>Obszar działania naszej firmy</h2>";
                                    // Google Maps iframe z zaznaczoną Częstochową i okręgiem 100km
                                    echo "<iframe id='company-map-iframe' src='https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d326152.6720706466!2d19.12030000000001!3d50.81180000000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1spl!2spl!4v1716493500000!5m2!1spl!2spl' allowfullscreen='' loading='lazy' referrerpolicy='no-referrer-when-downgrade'></iframe>";
                                    echo "<div class='operation-area-info'>";
                                    echo "<h3>Gdzie nas znajdziesz?</h3>";
                                    echo "<p>Świadczymy usługi w całym powiecie częstochowskim i okolicach</p>";
                                    echo "<p>Ale jesteśmy wstanie podjąć się każdego wyzwania!</p>";
                                    echo "</div>";
                                    echo "</div>";
                                } else {
                                    $imgIndex = ($count > 1) ? $count - 1 : $count; // Dostosowanie indeksu po usunięciu company2.jpg
                                    echo "<div class='section-image-container'>";
                                    echo "<img src='".$images[$imgIndex]."' alt='".$row['title']."' class='section-image'>";
                                    echo "</div>";
                                }
                            } else {
                                // Split layout
                                echo "<div class='section-split'>";
                                echo "<div class='section-text'>";
                                echo "<h2 class='section-title'>".$row['title']."</h2>";
                                echo "<div class='section-description'>".$row['description']."</div>";
                                echo "</div>";
                                echo "<div class='section-media'>";
                                
                                // Jeśli to druga sekcja (index 1), dodaj mapę zamiast zdjęcia
                                if ($count === 1) {
                                    echo "<div id='company-map-container'>";
                                    echo "<h2>Secur-IT </h2>";
                                    // Google Maps iframe z zaznaczoną Częstochową
                                    echo "<iframe id='company-map-iframe' src='https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d326152.6720706466!2d19.12030000000001!3d50.81180000000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1spl!2spl!4v1716493500000!5m2!1spl!2spl' allowfullscreen='' loading='lazy' referrerpolicy='no-referrer-when-downgrade'></iframe>";
                                    echo "<div class='operation-area-info'>";
                                    echo "<h3>Gdzie nas znajdziesz?</h3>";
                                    echo "<p>Świadczymy usługi w całym powiecie częstochowskim i okolicach</p>";
                                    echo "<p>Ale jesteśmy wstanie podjąć się każdego wyzwania!</p>";
                                    echo "</div>";
                                    echo "</div>";
                                } else {
                                    $imgIndex = ($count > 1) ? $count - 1 : $count; // Dostosowanie indeksu po usunięciu company2.jpg
                                    echo "<img src='".$images[$imgIndex]."' alt='".$row['title']."' class='section-image'>";
                                }
                                
                                echo "</div>";
                                echo "</div>";
                            }
                            
                            echo "</div>";
                            echo "</section>";
                            
                            $count++;
                        }
                    } else {
                        echo "<section class='section visible'>";
                        echo "<div class='section-content'>";
                        echo "<h2 class='section-title'>Brak informacji</h2>";
                        echo "<p class='section-description'>Aktualnie nie ma dostępnych informacji o firmie.</p>";
                        echo "</div>";
                        echo "</section>";
                    }
                    $baza->close();
                ?>
            </div>
            
            <div class="scroll-indicator">
                <div class="scroll-indicator-text">Scroll</div>
                <div class="scroll-indicator-icon"></div>
            </div>
            
            <?php
                include("footer.php");
            ?>
        </main>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Get all sections
                const sections = document.querySelectorAll('.section');
                const scrollIndicator = document.querySelector('.scroll-indicator');
                const progressBar = document.querySelector('.progress-bar');
                
                // Set up Intersection Observer
                const observerOptions = {
                    root: null, // viewport
                    rootMargin: '-10% 0px',
                    threshold: 0.1 // trigger when 10% of the element is visible
                };
                
                const observer = new IntersectionObserver(function(entries, observer) {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('visible');
                        }
                    });
                }, observerOptions);
                
                // Observe each section
                sections.forEach(section => {
                    observer.observe(section);
                });
                
                // Update progress bar and hide scroll indicator when scrolling
                window.addEventListener('scroll', function() {
                    // Calculate scroll progress
                    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                    const scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                    const scrollProgress = (scrollTop / scrollHeight) * 100;
                    
                    // Update progress bar width
                    progressBar.style.width = scrollProgress + '%';
                    
                    // Hide scroll indicator after scrolling a bit
                    if (scrollTop > 100) {
                        scrollIndicator.classList.add('hidden');
                    } else {
                        scrollIndicator.classList.remove('hidden');
                    }
                });
                
                // Make first section visible immediately
                if (sections.length > 0) {
                    setTimeout(() => {
                        sections[0].classList.add('visible');
                    }, 300);
                }
                
                // Smooth scroll for anchor links
                document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                    anchor.addEventListener('click', function(e) {
                        e.preventDefault();
                        
                        const targetId = this.getAttribute('href');
                        const targetElement = document.querySelector(targetId);
                        
                        if (targetElement) {
                            targetElement.scrollIntoView({
                                behavior: 'smooth'
                            });
                        }
                    });
                });
            });
        </script>
    </body>
</html>