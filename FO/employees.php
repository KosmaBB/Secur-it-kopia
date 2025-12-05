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
        <title>Secur IT | Cyber Team</title>
        <style>
            .hex-container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 80px 20px;
                position: relative;
            }

            .hex-title {
                text-align: center;
                font-size: 3.5rem;
                font-weight: 700;
                color: var(--holo-text);
                margin-bottom: 60px;
                text-transform: uppercase;
                letter-spacing: 3px;
                text-shadow: 0 0 30px rgba(0, 204, 255, 0.8);
                position: relative;
            }

            .hex-title::before {
                content: '';
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 200px;
                height: 200px;
                background: conic-gradient(from 0deg, transparent, var(--holo-primary), transparent);
                border-radius: 50%;
                opacity: 0.3;
                z-index: -1;
                animation: rotate 4s linear infinite;
            }

            .hex-subtitle {
                text-align: center;
                font-size: 1.2rem;
                color: var(--holo-text-muted);
                margin-bottom: 40px;
                text-transform: uppercase;
                letter-spacing: 2px;
            }

            .hex-grid {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 20px;
                margin-top: 40px;
            }

            .hex-employee {
                position: relative;
                width: 200px;
                height: 230px;
                margin: 20px;
                transition: all 0.4s ease;
            }

            .hex-shape {
                position: relative;
                width: 200px;
                height: 200px;
                background: var(--holo-card-bg);
                border: 2px solid var(--holo-border);
                clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
                transition: all 0.4s ease;
                overflow: hidden;
                cursor: pointer;
                backdrop-filter: blur(10px);
            }

            .hex-employee:hover .hex-shape {
                border-color: var(--holo-primary);
                box-shadow: 0 0 30px rgba(0, 204, 255, 0.6);
                transform: scale(1.1);
            }

            .hex-photo {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 120px;
                height: 120px;
                border-radius: 50%;
                object-fit: cover;
                border: 3px solid var(--holo-primary);
                transition: all 0.4s ease;
            }

            .hex-employee:hover .hex-photo {
                box-shadow: 0 0 20px rgba(0, 204, 255, 0.8);
                transform: translate(-50%, -50%) scale(1.1);
            }

            .hex-overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: linear-gradient(45deg, rgba(0, 204, 255, 0.1), rgba(255, 0, 234, 0.1));
                opacity: 0;
                transition: opacity 0.4s ease;
                clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
            }

            .hex-employee:hover .hex-overlay {
                opacity: 1;
            }

            .hex-info {
                position: absolute;
                bottom: 0;
                left: 50%;
                transform: translateX(-50%);
                text-align: center;
                width: 100%;
            }

            .hex-name {
                font-size: 1.1rem;
                font-weight: 600;
                color: var(--holo-text);
                margin-bottom: 5px;
                text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
            }

            .hex-position {
                font-size: 0.9rem;
                color: var(--holo-primary);
                font-weight: 500;
                margin-bottom: 3px;
            }

            .hex-department {
                font-size: 0.8rem;
                color: var(--holo-text-muted);
                background: rgba(0, 204, 255, 0.1);
                padding: 2px 8px;
                border-radius: 10px;
                display: inline-block;
                border: 1px solid rgba(0, 204, 255, 0.2);
            }

            .hex-scan {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 2px;
                background: linear-gradient(90deg, transparent, var(--holo-primary), transparent);
                opacity: 0;
                animation: hexScan 3s linear infinite;
                clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
            }

            .hex-employee:hover .hex-scan {
                opacity: 0.8;
            }

            @keyframes hexScan {
                0% { top: 0; }
                100% { top: 100%; }
            }

            @keyframes rotate {
                from { transform: translate(-50%, -50%) rotate(0deg); }
                to { transform: translate(-50%, -50%) rotate(360deg); }
            }

            .no-employees {
                text-align: center;
                font-size: 1.5rem;
                color: var(--holo-text-muted);
                padding: 60px 20px;
                background: var(--holo-card-bg);
                border: 1px solid var(--holo-border);
                border-radius: 15px;
                backdrop-filter: blur(10px);
            }

            @media (max-width: 768px) {
                .hex-title {
                    font-size: 2.5rem;
                    letter-spacing: 2px;
                }
                
                .hex-employee {
                    width: 150px;
                    height: 180px;
                    margin: 15px;
                }
                
                .hex-shape {
                    width: 150px;
                    height: 150px;
                }
                
                .hex-photo {
                    width: 90px;
                    height: 90px;
                }

                .hex-name {
                    font-size: 1rem;
                }

                .hex-position {
                    font-size: 0.8rem;
                }
            }

            @media (max-width: 480px) {
                .hex-employee {
                    width: 120px;
                    height: 150px;
                    margin: 10px;
                }
                
                .hex-shape {
                    width: 120px;
                    height: 120px;
                }
                
                .hex-photo {
                    width: 70px;
                    height: 70px;
                }

                .hex-name {
                    font-size: 0.9rem;
                }

                .hex-position {
                    font-size: 0.75rem;
                }
            }
        </style>
    </head>
    <body>
        <div class="tlo"></div>
        <main class="main">
            <?php include("nav.php"); ?>
            
            <div class="hex-container">
                <h1 class="hex-title">Cyber Team</h1>
                <p class="hex-subtitle">Elitarni specjaliści cyberbezpieczeństwa</p>

                <?php
                    include('../DB/db_employees.php');
                    $baza = new db_employees();
                    $baza->databaseConnect();
                    $data = $baza->selectEmployee();
                    
                    if (!empty($data) && mysqli_num_rows($data) > 0) {
                ?>
                <div class="hex-grid">
                    <?php
                        while($row = mysqli_fetch_assoc($data)) {
                            echo "<div class='hex-employee'>";
                            echo "<div class='hex-shape'>";
                            echo "<div class='hex-scan'></div>";
                            echo "<div class='hex-overlay'></div>";
                            echo "<img class='hex-photo' src='".$row['photo']."' alt='".$row['first_name']." ".$row['last_name']."'>";
                            echo "</div>";
                            echo "<div class='hex-info'>";
                            echo "<div class='hex-name'>".$row['first_name']." ".$row['last_name']."</div>";
                            echo "<div class='hex-position'>".$row['name']."</div>";
                            if(!empty($row['department_name'])){
                                echo "<div class='hex-department'>".$row['department_name']."</div>";
                            }
                            echo "</div>";
                            echo "</div>";
                        }
                    ?>
                </div>
                <?php
                    } else {
                        echo "<div class='no-employees'>Brak pracowników do wyświetlenia</div>";
                    }
                    $baza->close();
                ?>
            </div>
            
            <?php include("footer.php"); ?>
        </main>
    </body>
</html>
