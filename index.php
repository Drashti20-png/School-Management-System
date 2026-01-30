\<?php
session_start();
if (!isset($_SESSION['principal_id']) || $_SESSION['role'] !== "Principal") {
    header("Location: ../login.php?error=Access denied");
    exit;
}

include "../DB_connection.php";

// Principal details
$principal_id = $_SESSION['principal_id'];
$stmt = $conn->prepare("SELECT * FROM principal WHERE principal_id = ?");
$stmt->execute([$principal_id]);
$principal = $stmt->fetch(PDO::FETCH_ASSOC);

// Counts
$studentCount = $conn->query("SELECT COUNT(*) FROM students")->fetchColumn();
$teacherCount = $conn->query("SELECT COUNT(*) FROM teacher")->fetchColumn();
$registrarCount = $conn->query("SELECT COUNT(*) FROM registrar_office")->fetchColumn();

// Fetch recent notices
$noticeStmt = $conn->prepare("SELECT * FROM notices WHERE posted_by = ? ORDER BY created_at DESC LIMIT 5");
$noticeStmt->execute([$principal_id]);
$notices = $noticeStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Principal Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
body {
    background-color: #FFB6C1;
    font-family: 'Segoe UI', sans-serif;
}
.navbar { box-shadow: 0 3px 10px rgba(0,0,0,0.1); }

/* Gradient Cards */
.card-gradient { background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%); color: #fff; }
.card-gradient-2 { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: #fff; }
.card-gradient-3 { background: linear-gradient(135deg, #f7971e 0%, #ffd200 100%); color: #fff; }

.card {
    border-radius: 1rem;
    transition: all 0.3s ease-in-out;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.card h5 { font-size: 1rem; margin-bottom:0.3rem; }
.card h3 { font-size: 1.5rem; color:#fff; }
.card i { font-size: 1.8rem; }

.profile-card { text-align: center; background: #fff; }
.profile-card img { 
    width: 100px; 
    height: 100px; 
    border-radius: 50%; 
    object-fit: cover; 
    border: 3px solid #0d6efd; 
    display:block; 
    margin:0 auto; 
}

.mini-chart { width: 250px; height: 250px; margin: 0 auto; }

.notice-card { max-height: 220px; overflow-y: auto; border-radius: 0.75rem; background: #fff; padding:10px;}
.notice-card li { border:none; padding:8px 0; border-bottom:1px solid #dee2e6; }
.notice-card li:last-child { border-bottom:none; }

.animate-counter { font-weight:bold; font-size:1.6rem; }
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="#">Principal Panel</a>
        <div class="d-flex">
            <span class="me-3">
                Welcome, <?= htmlspecialchars($principal['fname']." ".$principal['lname']); ?>
            </span>
            <a href="../logout.php" class="btn btn-outline-primary btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row g-4">
        <!-- Profile Card -->
        <div class="col-lg-4">
            <div class="card profile-card shadow p-4">
                <?php 
                // Check if image exists, else show default
                $imagePath = "../uploads/" . $principal['image'];
                if(!empty($principal['image']) && file_exists($imagePath)) {
                    echo '<img src="'. htmlspecialchars($imagePath) .'" alt="Principal Photo">';
                } else {
                    echo '<img src="../uploads/2151237437.png.jpg" alt="Principal Photo">';
                }
                ?>
                <h5 class="mt-3 fw-bold"><?= htmlspecialchars($principal['fname']." ".$principal['lname']); ?></h5>
                <p>Qualification: <?= htmlspecialchars($principal['qualification']); ?></p>
                <p><i class="bi bi-envelope me-1"></i> <?= htmlspecialchars($principal['email_address']); ?></p>
                <p><i class="bi bi-telephone me-1"></i> <?= htmlspecialchars($principal['phone_number']); ?></p>
            </div>
        </div>

        <!-- Dashboard Cards -->
        <div class="col-lg-8">
            <div class="row g-3 mb-4">
                <!-- Students Card -->
                <div class="col-md-4">
                    <div class="card card-gradient text-center p-4 shadow-sm">
                        <i class="bi bi-people-fill"></i>
                        <h5 class="mt-2">Total Students</h5>
                        <div class="animate-counter" data-target="<?= $studentCount ?>">0</div>
                    </div>
                </div>

                <!-- Teachers Card -->
                <div class="col-md-4">
                    <div class="card card-gradient-2 text-center p-4 shadow-sm">
                        <i class="bi bi-person-lines-fill"></i>
                        <h5 class="mt-2">Teachers</h5>
                        <div class="animate-counter" data-target="<?= $teacherCount ?>">0</div>
                    </div>
                </div>

                <!-- Registrar Office Card -->
                <div class="col-md-4">
                    <div class="card card-gradient-3 text-center p-4 shadow-sm">
                        <i class="bi bi-building"></i>
                        <h5 class="mt-2">Registrar Office</h5>
                        <div class="animate-counter" data-target="<?= $registrarCount ?>">0</div>
                    </div>
                </div>
            </div>

            <!-- Mini Chart -->
            <div class="card shadow-sm p-3 mb-4 text-center">
                <h5 class="mb-3 fw-bold">School Overview</h5>
                <canvas id="schoolChart" class="mini-chart"></canvas>
            </div>

            <!-- Notices -->
            <div class="card shadow-sm p-3">
                <h5 class="fw-bold mb-3">Post a Notice</h5>
                <form method="post" action="post_notice.php" class="mb-3">
                    <textarea name="notice" class="form-control mb-2" rows="3" placeholder="Write your announcement..." required></textarea>
                    <button type="submit" class="btn btn-primary btn-sm">Post Notice</button>
                </form>

                <h6 class="fw-bold mb-2">Recent Notices</h6>
                <ul class="list-group list-group-flush notice-card">
                    <?php if ($notices): ?>
                        <?php foreach ($notices as $notice): ?>
                            <li>
                                <small class="text-muted"><?= date("d M Y, H:i", strtotime($notice['created_at'])) ?></small><br>
                                <?= htmlspecialchars($notice['notice']) ?>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted mb-0">No notices posted yet.</p>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
// Animate counters
const counters = document.querySelectorAll('.animate-counter');
counters.forEach(counter => {
    const updateCount = () => {
        const target = +counter.getAttribute('data-target');
        let count = +counter.innerText;
        const increment = Math.ceil(target / 100);
        if(count < target){
            counter.innerText = count + increment;
            setTimeout(updateCount, 20);
        } else {
            counter.innerText = target;
        }
    };
    updateCount();
});

// Chart.js Doughnut
const ctx = document.getElementById('schoolChart').getContext('2d');
new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Students', 'Teachers', 'Registrar Office'],
        datasets: [{
            data: [<?= $studentCount ?>, <?= $teacherCount ?>, <?= $registrarCount ?>],
            backgroundColor: ['#0d6efd','#198754','#ffc107'],
            borderColor: '#ffffff',
            borderWidth: 2
        }]
    },
    options: {
        plugins: { legend: { position: 'bottom', labels: { font:{size:14}, color:'#333' } } },
        cutout: '70%',
        responsive: true
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
