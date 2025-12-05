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
        <title>Secur IT | Moje Wpisy</title>
    </head>
    <body>
        <div class="tlo"></div>
        <main class="main">
            <?php include("nav.php"); ?>
            <div class="my-posts-hero">
                <h1 class="my-posts-title">Moje Wpisy</h1>
                <p class="my-posts-subtitle">Zarządzaj swoimi artykułami i śledź ich status</p>
                
                <?php
                    include('../DB/db_posts.php');
                    $baza = new db_posts();
                    $baza->databaseConnect();
                    
                    $id_user = $_SESSION['id_user'];
                    $data = $baza->selectAllPostsById($id_user);
                    
                    $total_posts = 0;
                    $approved_posts = 0;
                    $pending_posts = 0;
                    $rejected_posts = 0;
                    
                    if (!empty($data)) {
                        $posts_array = [];
                        while($row = mysqli_fetch_assoc($data)) {
                            $posts_array[] = $row;
                            $total_posts++;
                            if ($row['approval_date']) {
                                $approved_posts++;
                            } else {
                                $pending_posts++;
                            }
                        }
                        $data = $posts_array;
                    }
                ?>
                
                <div class="posts-dashboard">
                    <div class="dashboard-card">
                        <div class="dashboard-icon">
                            <i class="fa fa-file-text"></i>
                        </div>
                        <div class="dashboard-number" id="total-count"><?php echo $total_posts; ?></div>
                        <div class="dashboard-label">Wszystkie wpisy</div>
                    </div>
                    <div class="dashboard-card">
                        <div class="dashboard-icon">
                            <i class="fa fa-check-circle"></i>
                        </div>
                        <div class="dashboard-number" id="approved-count"><?php echo $approved_posts; ?></div>
                        <div class="dashboard-label">Zatwierdzone</div>
                    </div>
                    <div class="dashboard-card">
                        <div class="dashboard-icon">
                            <i class="fa fa-clock-o"></i>
                        </div>
                        <div class="dashboard-number" id="pending-count"><?php echo $pending_posts; ?></div>
                        <div class="dashboard-label">Oczekujące</div>
                    </div>
                </div>
            </div>

            <div class="posts-container">
                <div class="posts-controls">
                    <div class="posts-actions">
                        <a href="add_post.php" class="action-button">
                            <i class="fa fa-plus"></i>
                            <span>Dodaj Nowy Wpis</span>
                        </a>
                    </div>
                    
                    <div class="posts-filters">
                        <button class="filter-button active" data-filter="all">
                            <i class="fa fa-list"></i>
                            <span>Wszystkie</span>
                        </button>
                        <button class="filter-button" data-filter="approved">
                            <i class="fa fa-check"></i>
                            <span>Zatwierdzone</span>
                        </button>
                        <button class="filter-button" data-filter="pending">
                            <i class="fa fa-clock-o"></i>
                            <span>Oczekujące</span>
                        </button>
                    </div>
                </div>

                <?php if (!empty($data) && count($data) > 0): ?>
                <div class="posts-grid" id="posts-grid">
                    <?php foreach($data as $row): ?>
                    <?php
                        $is_approved = !empty($row['approval_date']);
                        $status = $is_approved ? 'approved' : 'pending';
                        $status_text = $is_approved ? 'Opublikowany' : 'Oczekuje na moderację';
                        $status_icon = $is_approved ? 'fa-check-circle' : 'fa-clock-o';
                        
                        $content_length = strlen($row['content']);
                        $read_time = max(1, round($content_length / 1000));
                        
                    ?>
                    <article class="post-card" data-status="<?php echo $status; ?>">

                        
                        <div class="post-status <?php echo $status; ?>">
                            <i class="fa <?php echo $status_icon; ?>"></i>
                            <span><?php echo $status_text; ?></span>
                        </div>
                        
                        <div class="post-header">
                            <h3 class="post-title"><?php echo htmlspecialchars($row['title']); ?></h3>
                            <div class="post-meta">
                                <div class="post-meta-item">
                                    <i class="fa fa-calendar"></i>
                                    <span><?php echo date('d.m.Y', strtotime($row['date_added'])); ?></span>
                                </div>
                                <?php if ($is_approved): ?>
                                <div class="post-meta-item">
                                    <i class="fa fa-globe"></i>
                                    <span><?php echo date('d.m.Y', strtotime($row['approval_date'])); ?></span>
                                </div>
                                <?php endif; ?>
                                <div class="post-meta-item">
                                    <i class="fa fa-clock"></i>
                                    <span><?php echo $read_time; ?> min</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="post-content">
                            <?php echo htmlspecialchars($row['content']); ?>
                        </div>
                        
                        <div class="post-actions">
                            <div class="post-stats">
                                
                                <div class="post-stat">
                                    <i class="fa fa-comment"></i>
                                    <span><?php echo rand(0, 15); ?></span>
                                </div>
                                <div class="post-stat">
                                    <i class="fa fa-heart"></i>
                                    <span><?php echo rand(0, 25); ?></span>
                                </div>
                            </div>
                            <div class="post-buttons">
                                <a href="#" class="post-button edit" onclick="editPost(<?php echo $row['id']; ?>)">
                                    <i class="fa fa-edit"></i>
                                    <span>Edytuj</span>
                                </a>
                                <a href="#" class="post-button delete" onclick="deletePost(<?php echo $row['id']; ?>)">
                                    <i class="fa fa-trash"></i>
                                    <span>Usuń</span>
                                </a>
                            </div>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="no-posts">
                    <div class="no-posts-icon">
                        <i class="fa fa-file-text-o"></i>
                    </div>
                    <h3 class="no-posts-title">Nie masz jeszcze żadnych wpisów</h3>
                    <p class="no-posts-text">Rozpocznij swoją przygodę z pisaniem i podziel się swoją wiedzą ze społecznością cyberbezpieczeństwa.</p>
                    <a href="add_post.php" class="no-posts-cta">
                        <i class="fa fa-plus"></i>
                        <span>Napisz pierwszy wpis</span>
                    </a>
                </div>
                <?php endif; ?>
            </div>

            <?php 
                $baza->close();
                include("footer.php"); 
            ?>
        </main>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                animateCounters();
                
                setupFilters();
                
                setupCardAnimations();
            });

            function animateCounters() {
                const counters = [
                    { id: 'total-count', target: <?php echo $total_posts; ?> },
                    { id: 'approved-count', target: <?php echo $approved_posts; ?> },
                    { id: 'pending-count', target: <?php echo $pending_posts; ?> }
                ];

                counters.forEach(counter => {
                    animateCounter(counter.id, counter.target);
                });
            }

            function animateCounter(id, target) {
                const element = document.getElementById(id);
                let current = 0;
                const increment = target / 30;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }
                    element.textContent = Math.floor(current);
                }, 50);
            }

            function setupFilters() {
                const filterButtons = document.querySelectorAll('.filter-button');
                const postCards = document.querySelectorAll('.post-card');

                filterButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        filterButtons.forEach(btn => btn.classList.remove('active'));
                        this.classList.add('active');

                        const filter = this.dataset.filter;

                        postCards.forEach(card => {
                            const cardStatus = card.dataset.status;
                            
                            if (filter === 'all' || filter === cardStatus) {
                                card.style.display = 'block';
                                card.style.animation = 'fadeIn 0.5s ease';
                            } else {
                                card.style.display = 'none';
                            }
                        });
                    });
                });
            }

            function setupCardAnimations() {
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

                const postCards = document.querySelectorAll('.post-card');
                postCards.forEach((card, index) => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(30px)';
                    card.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
                    observer.observe(card);
                });
            }

            function editPost(postId) {
                console.log('Edytuj wpis:', postId);
            }

            function deletePost(postId) {
                if (confirm('Czy na pewno chcesz usunąć ten wpis? Ta akcja jest nieodwracalna.')) {
                    console.log('Usuń wpis:', postId);
                }
            }

            const style = document.createElement('style');
            style.textContent = `
                @keyframes fadeIn {
                    from { opacity: 0; transform: translateY(20px); }
                    to { opacity: 1; transform: translateY(0); }
                }
            `;
            document.head.appendChild(style);
        </script>
    </body>
</html>
