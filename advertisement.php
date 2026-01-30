<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advertisement - Yanshi School</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f0f9ff, #cbebff, #a1dbff);
            font-family: 'Segoe UI', sans-serif;
        }
        .ad-container {
            max-width: 900px;
            margin: 50px auto;
            text-align: center;
        }
        .carousel-item img {
            height: 400px;
            object-fit: cover;
            border-radius: 15px;
        }
        .ad-text {
            margin-top: 20px;
        }
        .btn-visit {
            border-radius: 50px;
            padding: 12px 30px;
            font-size: 18px;
            font-weight: 600;
            transition: all 0.3s ease-in-out;
        }
        .btn-visit:hover {
            transform: scale(1.08);
        }
    </style>
</head>
<body>
    <div class="ad-container animate__animated animate__fadeInUp">
        <h2 class="text-primary mb-3">📢 Admissions Open 2025-26</h2>
        <h5 class="text-danger fw-bold">Starting from: <u>1st April 2025</u></h5>
        <p class="fw-semibold text-dark">For Classes: Std. 1 to Std. 9</p>

        <!-- Bootstrap Carousel -->
        <div id="adCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="/school-management-system-php/uploads/7916607.jpg" class="d-block w-100" alt="Admission Banner">
                </div>
                <div class="carousel-item">
                    <img src="/school-management-system-php/uploads/medium-shot-girl-playing-table.jpg" class="d-block w-100" alt="School Campus">
                </div>
                <div class="carousel-item">
                    <img src="/school-management-system-php/uploads/rosario-fernandes-jrzrs0JF0ug-unsplash.jpg" class="d-block w-100" alt="School Activities">
                </div>
            </div>

            <!-- Carousel Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#adCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#adCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <div class="ad-text mt-4">
            <p class="fs-5 text-secondary">
                Join <b>Yanshi School</b> for world-class education, modern facilities, and holistic student development.
                Limited seats available – Apply today!
            </p>
            <a href="http://localhost/school-management-system-php/index.php" class="btn btn-primary btn-visit">
                🌐 Visit School Management System
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
