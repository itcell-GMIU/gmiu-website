<?php
include '../../common/importwebsitefile.php';

$pageTitle = 'All Programs | Gyanmanjari Innovative University';
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/home.css">
    
    <style>
          .courses header .header-body {
          
            min-height: 0 !important;
        }
       
        body:before {
            display: none !important;
        }
        .all-programs-hero {
            background: linear-gradient(rgba(30, 38, 74, 0.8), rgba(30, 38, 74, 0.8)), url('https://gmiu.edu.in/gmiu/website_assets/images/campus.png');
            background-size: cover;
            background-position: center;
            padding: 100px 0;
            color: #fff;
            text-align: center;
        }

        .all-programs-hero h1 {
            font-size: 48px;
            font-weight: 800;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        .all-programs-hero p {
            font-size: 18px;
            color: rgba(255,255,255,0.9);
            max-width: 700px;
            margin: 0 auto;
        }

        .level-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
            padding: 80px 0;
        }

        @media (max-width: 767px) {
            .level-grid {
                grid-template-columns: 1fr;
            }
        }

        .level-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: 0.4s;
            text-decoration: none !important;
            display: flex;
            flex-direction: column;
            border: 1px solid #f1f5f9;
            height: 100%;
        }

        .level-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(186, 42, 33, 0.15);
            border-color: #ba2a21;
        }

        .level-placeholder {
            height: 250px;
            width: 100%;
            background: linear-gradient(135deg, #1e264a 0%, #ba2a21 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 60px;
            font-weight: 900;
            color: rgba(255,255,255,0.2);
            letter-spacing: 5px;
            text-transform: uppercase;
            text-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .level-content {
            padding: 35px;
            text-align: left;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .level-badge {
            display: inline-block;
            background: #fceceb;
            color: #ba2a21;
            padding: 6px 15px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            margin-bottom: 15px;
        }

        .level-content h3 {
            font-size: 28px;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 15px;
            text-align: left;
        }

        .level-content p {
            color: #64748b;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .level-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
        }

        .level-link {
            color: #ba2a21;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .level-count {
            font-size: 13px;
            color: #94a3b8;
            font-weight: 600;
        }

        .breadcrumb-wrap {
            background: #f8fafc;
            padding: 15px 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .breadcrumb-wrap a {
            color: #64748b;
            text-decoration: none;
            font-size: 14px;
        }

        .breadcrumb-wrap span {
            color: #ba2a21;
            font-weight: 600;
            font-size: 14px;
        }
    </style>
</head>

<body class="courses">
    <?php include '../include/importheader.php'; ?>

    <div class="all-programs-hero">
        <div class="container">
            <h1>Academic Programs</h1>
            <p>Discover a wide range of industry-aligned programs designed to shape the next generation of global innovators and leaders.</p>
        </div>
    </div>

    <div class="breadcrumb-wrap">
        <div class="container">
            <a href="<?php echo $base_url_website; ?>">Home</a> <i class="fa fa-angle-right" style="margin: 0 10px; color: #cbd5e1;"></i>
            <span>All Programs</span>
        </div>
    </div>

    <div class="container">
        <div class="level-grid">
            <?php
            $levels = [
                ['id' => 5, 'name' => 'Diploma Programs', 'short' => 'diploma', 'img' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&q=80&w=800', 'desc' => 'Gain practical skills and foundational knowledge in engineering and vocational disciplines.'],
                ['id' => 1, 'name' => 'Undergraduate (UG)', 'short' => 'ug', 'img' => 'https://images.unsplash.com/photo-1541339907198-e08756ebafe1?auto=format&fit=crop&q=80&w=800', 'desc' => 'Comprehensive bachelor degree programs with a focus on professional excellence and industrial readiness.'],
                ['id' => 2, 'name' => 'Postgraduate (PG)', 'short' => 'pg', 'img' => 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?auto=format&fit=crop&q=80&w=800', 'desc' => 'Advanced master degree programs for specialization and leadership in your chosen field.'],
                ['id' => 7, 'name' => 'Doctoral (Ph.D.)', 'short' => 'phd', 'img' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?auto=format&fit=crop&q=80&w=800', 'desc' => 'Contribute to the world of knowledge through research-intensive doctoral studies and innovation.'],
            ];

            foreach ($levels as $level) {
                // Count programs for this level
                $count_query = "SELECT COUNT(*) as total FROM tbl_program WHERE level_id = {$level['id']} AND is_active = 1 AND is_delete = 0";
                $count_res = mysqli_query($con, $count_query);
                $count_data = mysqli_fetch_assoc($count_res);
                $total_programs = $count_data['total'];
                ?>
                <a href="<?php echo $base_url_website_faculty . $level['short'] . '/'; ?>" class="level-card">
                    <div class="level-placeholder"><?php echo strtoupper($level['short']); ?></div>
                    <div class="level-content">
                        <div>
                            <span class="level-badge"><?php echo strtoupper($level['short']); ?> Level</span>
                            <h3><?php echo $level['name']; ?></h3>
                            <p><?php echo $level['desc']; ?></p>
                        </div>
                        <div class="level-footer">
                            <span class="level-link">View All Programs <i class="fa fa-arrow-right"></i></span>
                            <span class="level-count"><?php echo $total_programs; ?> Programs Available</span>
                        </div>
                    </div>
                </a>
            <?php } ?>
        </div>
    </div>

    <?php include '../include/importfooter.php' ?>
    <?php include '../include/importjs.php'; ?>
</body>

</html>
