<?php
    include_once ('../include/functions.php');
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
        <title>Secur IT | Centrum Wpisów</title>

    </head>
    <body>
        <div class="tlo"></div>
        <main class="main">
            <?php include("nav.php"); ?>
            <div class="posts-hero">
                <div class="posts-hero-content">
                    <h1 class="posts-title">Centrum Wpisów</h1>
                    <p class="posts-subtitle">Odkryj najnowsze artykuły, insights i aktualności ze świata cyberbezpieczeństwa</p>
                    
                    <div class="posts-stats">
                        <div class="stat-item">
                            <span class="stat-number" id="total-posts">0</span>
                            <span class="stat-label">Wszystkie wpisy</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number" id="this-month">0</span>
                            <span class="stat-label">W tym miesiącu</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number" id="active-authors">0</span>
                            <span class="stat-label">Aktywni autorzy</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="posts-container">
                <div class="posts-controls">
                    <?php if($id_user !== 0): ?>
                    <div class="posts-actions">
                        <a href="add_post.php" class="action-button primary">
                            <i class="fa fa-plus"></i>
                            <span>Dodaj Wpis</span>
                        </a>
                        <a href="my_posts.php" class="action-button secondary">
                            <i class="fa fa-user-edit"></i>
                            <span>Moje Wpisy</span>
                        </a>
                    </div>
                    <?php endif; ?>
                    
                    <div class="posts-search">
                        <div class="search-container">
                            <input type="text" class="search-input" placeholder="Szukaj wpisów..." id="search-posts">
                            <i class="fa fa-search search-icon"></i>
                        </div>
                        <div class="filter-dropdown">
                            <div class="filter-button" id="filter-toggle">
                                <i class="fa fa-filter"></i>
                                <span>Filtruj</span>
                                <i class="fa fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                    include('../DB/db_posts.php');
                    $baza = new db_posts();
                    $baza->databaseConnect();
                    $data = $baza->selectCheckedPost();
                    
                    if (!empty($data) && mysqli_num_rows($data) > 0) {
                        $post_count = mysqli_num_rows($data);
                ?>
                <div class="posts-grid" id="posts-grid">
                    <?php
                        while($row = mysqli_fetch_assoc($data)) {
                            $content_length = strlen($row['content']);
                            $read_time = max(1, round($content_length / 1000));
                            
                            echo "<article class='post-card' data-title='" . strtolower($row['title']) . "' data-content='" . strtolower($row['content']) . "'>";
                            echo "<div class='scan-line'></div>";
                            
                            echo "<div class='post-header'>";
                            echo "<div>";
                            echo "<h3 class='post-title'>" . htmlspecialchars($row['title']) . "</h3>";
                            echo "<div class='post-meta'>";
                            echo "<div class='post-date'>";
                            echo "<i class='fa fa-calendar'></i>";
                            echo "<span>" . date('d.m.Y', strtotime($row['approval_date'])) . "</span>";
                            echo "</div>";
                            echo "<div class='post-author'>";
                            echo "<i class='fa fa-user'></i>";
                            echo "<span>Autor</span>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            
                            echo "<div class='post-content'>";
                            echo htmlspecialchars($row['content']);
                            echo "</div>";
                            
                            echo "<div class='post-actions'>";
                            echo "<a href='#' class='read-more'>";
                            echo "<span>Czytaj więcej</span>";
                            echo "<i class='fa fa-arrow-right'></i>";
                            echo "</a>";
                            echo "<div class='post-stats'>";
                            echo "<div class='post-stat'>";
                            echo "<i class='fa fa-clock'></i>";
                            echo "<span>" . $read_time . " min</span>";
                            echo "</div>";
                            echo "<div class='post-stat'>";
                            echo "<i class='fa fa-eye'></i>";
                            echo "<span>" . rand(50, 500) . "</span>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            
                            echo "</article>";
                        }
                    ?>
                </div>
                <?php
                    } else {
                ?>
                <div class="no-posts">
                    <div class="no-posts-icon">
                        <i class="fa fa-file-text-o"></i>
                    </div>
                    <h3 class="no-posts-title">Brak wpisów</h3>
                    <p class="no-posts-text">Nie ma jeszcze żadnych opublikowanych wpisów. Bądź pierwszy!</p>
                </div>
                <?php
                    }
                    $baza->close();
                ?>
            </div>

            <?php if($id_user !== 0): ?>
            <a href="add_post.php" class="floating-add-button" title="Dodaj nowy wpis">
                <i class="fa fa-plus"></i>
            </a>
            <?php endif; ?>

            <?php include("footer.php"); ?>
        </main>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const totalPosts = <?php echo isset($post_count) ? $post_count : 0; ?>;
                const thisMonth = Math.floor(totalPosts * 0.3);
                const activeAuthors = Math.floor(totalPosts * 0.2);

                animateCounter('total-posts', totalPosts);
                animateCounter('this-month', thisMonth);
                animateCounter('active-authors', activeAuthors);

                function animateCounter(id, target) {
                    const element = document.getElementById(id);
                    let current = 0;
                    const increment = target / 50;
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= target) {
                            current = target;
                            clearInterval(timer);
                        }
                        element.textContent = Math.floor(current);
                    }, 30);
                }
                const searchInput = document.getElementById('search-posts');
                const postsGrid = document.getElementById('posts-grid');
                const postCards = document.querySelectorAll('.post-card');

                if (searchInput) {
                    searchInput.addEventListener('input', function() {
                        const searchTerm = this.value.toLowerCase();
                        
                        postCards.forEach(card => {
                            const title = card.dataset.title;
                            const content = card.dataset.content;
                            
                            if (title.includes(searchTerm) || content.includes(searchTerm)) {
                                card.style.display = 'block';
                                card.style.animation = 'fadeIn 0.5s ease';
                            } else {
                                card.style.display = 'none';
                            }
                        });
                    });
                }

                const observerOptions = {
                    threshold: 0.1,
                    rootMargin: '0px 0px -50px 0px'
                };

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                        }
                    });
                }, observerOptions);

                postCards.forEach((card, index) => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(30px)';
                    card.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
                    observer.observe(card);
                });
            });
        </script>
    </body>
</html>
