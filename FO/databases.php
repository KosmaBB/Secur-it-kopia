<?php
    include_once('../include/functions.php');
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="./script.js" defer></script>
        <script src="https://kit.fontawesome.com/1deffa5961.js" crossorigin="anonymous"></script>
        <link rel="shortcut icon" href="../images/ikona.png">
        <title>Secur IT | Usługi - Bazy Danych</title>
    </head>
    <body>
        <div class="tlo"></div>
        <main class="main">
            <?php

                include("nav.php");
            ?>
            
            <div class="services-section">
                <?php
                    include('../DB/db_services.php');
                    $baza = new db_services();
                    $baza->databaseConnect();
                    $data = $baza->selectServices_databases();

                    if (!empty($data) && mysqli_num_rows($data) > 0) {
                ?>
                <div class="carousel-container">
                    <div class="carousel">
                        <?php
                        while ($row = mysqli_fetch_assoc($data)) {
                            echo "<div class='carousel-item' data-description='".$row['description']."' data-id='".$row['id_service']."'>
                                <h3>".$row['name']."</h3>
                                <p class='price'>".$row['price']." PLN</p>";
                                
                            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                                echo "<button class='add-to-cart' data-id='".$row['id_service']."'>Dodaj do koszyka</button>";
                            } else {
                                echo "<button class='add-to-cart' disabled>Zaloguj się, aby dodać</button>";
                            }
                            
                            echo "</div>";
                        }
                        ?>
                    </div>
                    <button class="carousel-nav prev"><i class="fa fa-chevron-left"></i></button>
                    <button class="carousel-nav next"><i class="fa fa-chevron-right"></i></button>
                </div>
                <div class="service-details hidden">
                    <h3 id="service-name"></h3>
                    <p id="service-description"></p>
                    <button id="close-details" class="add-to-cart">Zamknij</button>
                </div>
                <?php
                    } else {
                        echo "<p class='no-services'>Brak dostępnych usług.</p>";
                    }
                    $baza->close();
                ?>
            </div>
            
            <?php
                include("footer.php");
            ?>
        </main>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const carouselContainer = document.querySelector('.carousel-container');
                if (!carouselContainer) {
                    console.error('Carousel container not found');
                    return;
                }

                const carousel = document.querySelector('.carousel');
                const items = document.querySelectorAll('.carousel-item');
                if (items.length === 0) {
                    console.error('No carousel items found');
                    return;
                }
                
                console.log('Found', items.length, 'carousel items');
                
                const prevBtn = document.querySelector('.carousel-nav.prev');
                const nextBtn = document.querySelector('.carousel-nav.next');
                const serviceDetails = document.querySelector('.service-details');
                const serviceName = document.getElementById('service-name');
                const serviceDescription = document.getElementById('service-description');
                const closeDetailsBtn = document.getElementById('close-details');
                
                let currentIndex = 0;
                let startX, moveX;
                let isAnimating = false;
                
                const backgroundImages = [
                    '../images/uslugi/db1.jpg', 
                    '../images/uslugi/db2.jpg',
                    '../images/uslugi/db3.jpg'
                ];
                
                function initCarousel() {
                    console.log('Initializing carousel');
                    
                    items.forEach((item, index) => {
                        const bgIndex = index % backgroundImages.length;
                        item.style.backgroundImage = `url(${backgroundImages[bgIndex]})`;
                        item.style.backgroundSize = 'cover';
                        item.style.backgroundPosition = 'center';
                    });
                    
                    positionItems();
                    
                    if (prevBtn) prevBtn.addEventListener('click', goToPrev);
                    if (nextBtn) nextBtn.addEventListener('click', goToNext);
                    
                    document.addEventListener('keydown', handleKeyDown);
                    
                    carousel.addEventListener('touchstart', handleTouchStart, { passive: true });
                    carousel.addEventListener('touchmove', handleTouchMove, { passive: false });
                    carousel.addEventListener('touchend', handleTouchEnd, { passive: true });
                    
                    items.forEach(item => {
                        item.addEventListener('click', function(e) {
                            if (!e.target.classList.contains('add-to-cart')) {
                                showServiceDetails(this);
                            }
                        });
                        
                        const addToCartBtn = item.querySelector('.add-to-cart');
                        if (addToCartBtn && !addToCartBtn.disabled) {
                            addToCartBtn.addEventListener('click', function(e) {
                                e.stopPropagation();
                                addToCart(item);
                            });
                        }
                    });
                    
                    if (closeDetailsBtn) {
                        closeDetailsBtn.addEventListener('click', function() {
                            serviceDetails.classList.remove('visible');
                            
                            setTimeout(() => {
                                serviceDetails.classList.add('hidden');
                            }, 500);
                        });
                    }
                    
                    showItem(0);
                }
                
                function positionItems() {
                    items.forEach((item, index) => {
                        const offset = index - currentIndex;
                        
                        item.style.transform = 'translate(-50%, -50%) rotateX(5deg)';
                        item.classList.remove('active');
                        item.style.opacity = '0';
                        item.style.zIndex = '1';
                        
                        if (offset === 0) {
                            item.classList.add('active');
                            item.style.opacity = '1';
                            item.style.zIndex = '10';
                        } else {
                            const xPosition = offset * 120;
                            const scale = 1 - Math.abs(offset) * 0.2;
                            const opacity = Math.max(0, 1 - Math.abs(offset) * 0.5);
                            
                            item.style.transform = `translate(${xPosition}%, -50%) rotateX(5deg) scale(${scale})`;
                            item.style.opacity = opacity.toString();
                            item.style.zIndex = (10 - Math.abs(offset)).toString();
                        }
                    });
                }
                
                function showItem(index) {
                    if (index < 0) {
                        index = items.length - 1;
                    } else if (index >= items.length) {
                        index = 0;
                    }
                    
                    currentIndex = index;
                    positionItems();
                }
                
                function goToPrev() {
                    if (isAnimating) return;
                    isAnimating = true;
                    showItem(currentIndex - 1);
                    setTimeout(() => { isAnimating = false; }, 500);
                }
                
                function goToNext() {
                    if (isAnimating) return;
                    isAnimating = true;
                    showItem(currentIndex + 1);
                    setTimeout(() => { isAnimating = false; }, 500);
                }
                
                function handleKeyDown(e) {
                    if (e.key === 'ArrowLeft') {
                        goToPrev();
                    } else if (e.key === 'ArrowRight') {
                        goToNext();
                    }
                }
                
                function handleTouchStart(e) {
                    startX = e.touches[0].clientX;
                }
                
                function handleTouchMove(e) {
                    if (!startX) return;
                    
                    moveX = e.touches[0].clientX;
                    const diff = moveX - startX;
                    
                    if (Math.abs(diff) > 10) {
                        e.preventDefault();
                    }
                }
                
                function handleTouchEnd(e) {
                    if (!startX || !moveX) return;
                    
                    const diff = moveX - startX;
                    const threshold = 50; // Minimum swipe distance
                    
                    if (diff > threshold) {
                        goToPrev();
                    } else if (diff < -threshold) {
                        goToNext();
                    }
                    
                    startX = null;
                    moveX = null;
                }
                
                function showServiceDetails(item) {
                    const name = item.querySelector('h3').textContent;
                    const description = item.getAttribute('data-description');
                    
                    serviceName.textContent = name;
                    serviceDescription.textContent = description;
                    
                    serviceDetails.classList.remove('hidden');
                    
                    void serviceDetails.offsetWidth;
                    
                    setTimeout(() => {
                        serviceDetails.classList.add('visible');
                    }, 10);
                }
                
                function addToCart(item) {
                    const id = item.getAttribute('data-id');
                    const name = item.querySelector('h3').textContent;
                    const price = item.querySelector('.price').textContent;
                    
                    const btn = item.querySelector('.add-to-cart');
                    btn.textContent = 'Dodano!';
                    btn.style.backgroundColor = '#4CAF50';
                    
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'databases.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            console.log('Added to cart successfully');
                        }
                    };
                    xhr.send('opcja=dodaj&id_service=' + id);
                    
                    setTimeout(() => {
                        btn.textContent = 'Dodaj do koszyka';
                        btn.style.backgroundColor = '';
                    }, 1500);
                    
                    console.log(`Added to cart: ${name} - ${price}`);
                }
                
                function addTiltEffect() {
                    items.forEach(item => {
                        item.addEventListener('mousemove', function(e) {
                            if (!item.classList.contains('active')) return;
                            
                            const rect = item.getBoundingClientRect();
                            const x = e.clientX - rect.left;
                            const y = e.clientY - rect.top;
                            
                            const xPercent = x / rect.width;
                            const yPercent = y / rect.height;
                            
                            const tiltX = (yPercent - 0.5) * 10; // Tilt up/down
                            const tiltY = (0.5 - xPercent) * 10; // Tilt left/right
                            
                            item.style.transform = `translate(-50%, -50%) rotateX(${5 + tiltX}deg) rotateY(${tiltY}deg)`;
                        });
                        
                        item.addEventListener('mouseleave', function() {
                            if (item.classList.contains('active')) {
                                item.style.transform = 'translate(-50%, -50%) rotateX(5deg)';
                            }
                        });
                    });
                }
                
                console.log('DOM loaded, initializing carousel');
                initCarousel();
                addTiltEffect();
                
                window.addEventListener('resize', positionItems);
            });
        </script>
    </body>
</html>