<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suitmedia</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
</head>
<body>
    <?php include 'template/navbar.php';?>

    <div class="hero">
        <div class="container">
            <div class="hero-box">
                <img src="src/math 2.jpg" alt="Banner" class="hero-img" />
                <div class="hero-overlay"></div>
                <div class="hero-content">
                    <h1>Ideas</h1>
                    <p>Where all our great things begin</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container-card">
        <div class="controls">
            <div class="controls-left">
                <div id="showingInfo" class="showing-info">Showing 1-10 of 100</div>
            </div>
            <div class="controls-right">
                <label>
                    Show per page:
                    <select id="perPageSelect">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                    </select>
                </label>
                
                <label>
                    Sort by:
                    <select id="sortSelect">
                        <option value="newest">Newest</option>
                        <option value="oldest">Oldest</option>
                    </select>
                </label>
            </div>
        </div>

        <div id="postContainer" class="grid"></div>
    
        <div id="pagination" class="pagination"></div>
    </div>

    <script src="script.js"></script>
</body>
</html>