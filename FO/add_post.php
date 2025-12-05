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
        <title>Secur IT | Dodaj Wpis</title>
    </head>
    <body>
        <div class="tlo"></div>
        <main class="main">
            <?php include("nav.php"); ?>
            
            <div class="add-post-hero">
                <h1 class="add-post-title">Stwórz Nowy Wpis</h1>
                <p class="add-post-subtitle">Podziel się swoją wiedzą ze społecznością cyberbezpieczeństwa</p>
            </div>

            <?php
                include('../DB/db_posts.php');
                $baza = new db_posts();
                $success_message = '';
                
                if(!empty($_GET)){
                    $baza->databaseConnect();
                    $id_user = $_SESSION['id_user'];
                    $title = htmlspecialchars($_GET['title']);
                    $content = htmlspecialchars($_GET['content']);
                    $date_added = date("Y-m-d H:i:s");
                    
                    if($baza->insertPost($id_user, $title, $content, $date_added)) {
                        $success_message = 'Wpis został pomyślnie dodany i oczekuje na moderację!';
                    }
                }
            ?>

            <div class="add-post-container">
                <div class="form-section">
                    
                    <?php if($success_message): ?>
                    <div class="success-message">
                        <i class="fa fa-check-circle"></i>
                        <span><?php echo $success_message; ?></span>
                    </div>
                    <?php endif; ?>

                    <div class="form-header">
                        <div class="form-icon">
                            <i class="fa fa-edit"></i>
                        </div>
                        <h2 class="form-title">Nowy Wpis</h2>
                    </div>

                    <form action="add_post.php" method="get" class="add-post-form" id="post-form">
                        <div class="form-group">
                            <label for="title">
                                <i class="fa fa-heading"></i>
                                Tytuł wpisu
                            </label>
                            <input 
                                type="text" 
                                id="title" 
                                name="title" 
                                class="title-input"
                                placeholder="Wpisz przyciągający tytuł..." 
                                maxlength="200" 
                                required
                                autocomplete="off"
                            >
                            <div class="char-counter" id="title-counter">0/200</div>
                        </div>

                        <div class="form-group">
                            <label for="content">
                                <i class="fa fa-file-text"></i>
                                Treść wpisu
                            </label>
                            <div class="form-tools">
                                <button type="button" class="tool-button" onclick="insertText('**', '**')" title="Pogrubienie">
                                    <i class="fa fa-bold"></i>
                                    <span>Bold</span>
                                </button>
                                <button type="button" class="tool-button" onclick="insertText('*', '*')" title="Kursywa">
                                    <i class="fa fa-italic"></i>
                                    <span>Italic</span>
                                </button>
                                <button type="button" class="tool-button" onclick="insertText('\n\n### ', '')" title="Nagłówek">
                                    <i class="fa fa-header"></i>
                                    <span>H3</span>
                                </button>
                                <button type="button" class="tool-button" onclick="insertText('\n- ', '')" title="Lista">
                                    <i class="fa fa-list"></i>
                                    <span>Lista</span>
                                </button>
                                <button type="button" class="tool-button" onclick="insertText('\n> ', '')" title="Cytat">
                                    <i class="fa fa-quote-left"></i>
                                    <span>Cytat</span>
                                </button>
                            </div>
                            <textarea 
                                id="content" 
                                name="content" 
                                class="content-textarea"
                                placeholder="Napisz treść swojego wpisu... Możesz używać podstawowego formatowania Markdown."
                                required
                            ></textarea>
                            <div class="char-counter" id="content-counter">0 znaków</div>
                        </div>

                        <div class="submit-section">
                            <div class="auto-save-indicator" id="auto-save">
                                <i class="fa fa-circle"></i>
                                <span>Gotowy do wysłania</span>
                            </div>
                            <div style="display: flex; gap: 15px;">
                                <button type="button" class="draft-button" onclick="saveDraft()">
                                    <i class="fa fa-save"></i>
                                    <span>Zapisz szkic</span>
                                </button>
                                <button type="submit" class="submit-button" id="submit-btn">
                                    <i class="fa fa-paper-plane"></i>
                                    <span>Opublikuj wpis</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            <?php include("footer.php"); ?>
        </main>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const titleInput = document.getElementById('title');
                const contentTextarea = document.getElementById('content');
                const titleCounter = document.getElementById('title-counter');
                const contentCounter = document.getElementById('content-counter');
                const submitBtn = document.getElementById('submit-btn');
                const autoSaveIndicator = document.getElementById('auto-save');

                loadDraft();



                function updateCounters() {
                    const titleLength = titleInput.value.length;
                    const contentLength = contentTextarea.value.length;

                    titleCounter.textContent = `${titleLength}/200`;
                    titleCounter.className = 'char-counter';
                    if (titleLength > 160) titleCounter.classList.add('warning');
                    if (titleLength > 180) titleCounter.classList.add('danger');

                    contentCounter.textContent = `${contentLength} znaków`;

                    const isValid = titleLength > 0 && contentLength > 10;
                    submitBtn.disabled = !isValid;
                }

                let autoSaveTimeout;
                function autoSave() {
                    clearTimeout(autoSaveTimeout);
                    autoSaveTimeout = setTimeout(() => {
                        saveDraft();
                        showAutoSaveStatus('saved');
                    }, 2000);
                    showAutoSaveStatus('saving');
                }

                function showAutoSaveStatus(status) {
                    const indicator = autoSaveIndicator;
                    indicator.className = `auto-save-indicator ${status}`;
                    
                    switch(status) {
                        case 'saving':
                            indicator.innerHTML = '<i class="fa fa-spinner fa-spin"></i><span>Zapisywanie...</span>';
                            break;
                        case 'saved':
                            indicator.innerHTML = '<i class="fa fa-check"></i><span>Zapisano szkic</span>';
                            setTimeout(() => {
                                indicator.className = 'auto-save-indicator';
                                indicator.innerHTML = '<i class="fa fa-circle"></i><span>Gotowy do wysłania</span>';
                            }, 2000);
                            break;
                    }
                }

                // Event listeners
                titleInput.addEventListener('input', function() {
                    updateCounters();
                    autoSave();
                });

                contentTextarea.addEventListener('input', function() {
                    updateCounters();
                    autoSave();
                });

                updateCounters();

                // Form submission
                document.getElementById('post-form').addEventListener('submit', function(e) {
                    const title = titleInput.value.trim();
                    const content = contentTextarea.value.trim();

                    if (!title || content.length < 10) {
                        e.preventDefault();
                        alert('Proszę wypełnić wszystkie pola. Treść musi mieć co najmniej 10 znaków.');
                        return;
                    }

                    // Clear draft on successful submission
                    localStorage.removeItem('post_draft');
                    
                    // Show loading state
                    submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i><span>Publikowanie...</span>';
                    submitBtn.disabled = true;
                });
            });

            // Text formatting functions
            function insertText(before, after) {
                const textarea = document.getElementById('content');
                const start = textarea.selectionStart;
                const end = textarea.selectionEnd;
                const selectedText = textarea.value.substring(start, end);
                const replacement = before + selectedText + after;
                
                textarea.value = textarea.value.substring(0, start) + replacement + textarea.value.substring(end);
                textarea.focus();
                textarea.setSelectionRange(start + before.length, start + before.length + selectedText.length);
                
                // Trigger input event to update preview
                textarea.dispatchEvent(new Event('input'));
            }

            // Draft management
            function saveDraft() {
                const draft = {
                    title: document.getElementById('title').value,
                    content: document.getElementById('content').value,
                    timestamp: new Date().toISOString()
                };
                localStorage.setItem('post_draft', JSON.stringify(draft));
            }

            function loadDraft() {
                const draft = localStorage.getItem('post_draft');
                if (draft) {
                    const data = JSON.parse(draft);
                    document.getElementById('title').value = data.title || '';
                    document.getElementById('content').value = data.content || '';
                    
                    // Update preview and counters
                    setTimeout(() => {
                        document.getElementById('title').dispatchEvent(new Event('input'));
                        document.getElementById('content').dispatchEvent(new Event('input'));
                    }, 100);
                }
            }

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey || e.metaKey) {
                    switch(e.key) {
                        case 's':
                            e.preventDefault();
                            saveDraft();
                            break;
                        case 'Enter':
                            e.preventDefault();
                            document.getElementById('post-form').submit();
                            break;
                    }
                }
            });
        </script>
    </body>
</html>
