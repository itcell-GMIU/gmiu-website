<?php
include '../../common/importwebsitefile.php';
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "Career at GMIU - Gyanmanjari Innovative University | GMIU"; 
        $meta_description = "Explore GMIU's career services for guidance, internships, job opportunities, and resources to support students in building successful careers.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include "../include/importhead.php"; ?>
    <?php include '../include/importcss.php'; ?>

    <style>
        body {
            background-color: #f9f9f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .role-table-wrapper {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            gap: 40px;
            flex-wrap: wrap;
        }

        .role-box {
            flex: 1;
            background-color: #ffffff;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-radius: 12px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            min-width: 280px;
        }

        .role-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .role-title {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #d32f2f;
            text-align: center;
        }

        .dropdown-designation select {
            padding: 10px 14px;
            border-radius: 8px;
            /*border: 1px solid #d32f2f;*/
            width: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 16px;
            color: #d32f2f;
            background-color: #fff;
            /*transition: background-color 0.3s ease, border-color 0.3s ease;*/
            /*appearance: none;*/
        }

       
       
        .btn-go {
            margin-top: 15px;
            display: inline-block;
            background-color: #d32f2f;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 8px;
            border: none;
            width: 100%;
            transition: background-color 0.3s ease;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 16px;
        }

        .btn-go:hover {
            background-color: #b71c1c;
            cursor: pointer;
        }
      
        @media (max-width: 768px) {
            .role-table-wrapper {
                flex-direction: column;
                gap: 20px;
            }

            .dropdown-designation select {
                font-size: 14px;
            }
        }
     
  
      .responsive-image-wrapper {
        width: 100%;
        display: flex;
        justify-content: center;
      }
     .custom-image {
        width: 100%;
        height: auto;
        border-radius: 12px;
    }

    .multi-image {
        display: flex;
        gap: 20px;
        justify-content: center;
        flex-wrap: wrap;
        /* stacks on mobile */
    }

   .multi-image img {
        max-height: 400px;
        /* keeps preview size consistent */
        width: auto;
        /* keep aspect ratio */
        height: auto;
        object-fit: contain;
        /* ensures full image is visible */
        border-radius: 12px;
    }

    /* On mobile (less than 768px), stack vertically */
    @media (max-width: 768px) {
        .multi-image img {
            flex: 1 1 100%;
            height: 400px;
            max-width: 100%;
        }
    }

    /* On desktop, keep side by side but limit size */
    @media (min-width: 768px) {
        .multi-image img {
            /*max-width: 400px;*/
            height: 400px;
            width: auto;
        }
    }
</style>


</head>

<body class="courses">
<?php include '../include/importheader.php'; ?>

<section class="hero">
    <div class="container">
        <div class="cont">
            <div class="top">
                <h1>Career at GMIU</h1>
            </div>
            <p style="margin-top:5px;">
                <span><a href="https://gmiu.edu.in/gmiu/website/" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                <span class="b-active">Career at GMIU</span>
            </p>
        </div>
    </div>
</section>

<div class="container">
    <section style="padding-bottom: 50px;">
        <div class="responsive-image-wrapper multi-image">
                <img src="images/career_post.jpg" alt="Recruitment Photo 1" class="custom-image">
                <img src="images/career_post2.png" alt="Recruitment Photo 2" class="custom-image">
            </div>
        

        <h3 class="gradText">Select Your Designation</h3>
        <div class="role-table-wrapper">
            <div class="role-box">
                <div class="role-title">Teaching Staff</div>
                <div class="dropdown-designation">
                   <!-- Teaching Staff Form -->
                    <form id="teachingForm">
                        <select name="designation_id" required>
                            <option value="">Select Designation</option>
                            <?php
                            $teaching_query = "SELECT id, slug , name FROM tbl_designation WHERE role_id = 1 AND is_active = 1 ORDER BY name ASC";
                            $teaching_result = mysqli_query($con, $teaching_query);
                            while ($row = mysqli_fetch_assoc($teaching_result)) {
                                echo '<option value="' . $row['slug'] . '">' . htmlspecialchars($row['name']) . '</option>';
                            }
                            ?>
                        </select>
                        <button type="submit" class="btn-go">Apply Now</button>
                    </form>

                </div>
            </div>
            <div class="role-box">
                <div class="role-title">Non-Teaching Staff</div>
                <div class="dropdown-designation">
                   <!-- Non-Teaching Staff Form -->
                    <form id="nonTeachingForm">
                        <select name="designation_id" required>
                            <option value="">Select Designation</option>
                            <?php
                            $non_teaching_query = "SELECT id, slug ,name FROM tbl_designation WHERE role_id = 2 AND is_active = 1 ORDER BY name ASC";
                            $non_teaching_result = mysqli_query($con, $non_teaching_query);
                            while ($row = mysqli_fetch_assoc($non_teaching_result)) {
                                echo '<option value="' . $row['slug'] . '">' . htmlspecialchars($row['name']) . '</option>';
                            }
                            ?>
                        </select>
                        <button type="submit" class="btn-go">Apply Now</button>
                    </form>

                </div>
            </div>
        </div>
    </section>
</div>

<?php include '../include/importfooter.php'; ?>
<?php include '../include/importjs.php'; ?>

<script>
   
    function setupFormRedirect(formId) {
        const form = document.getElementById(formId);
        form.addEventListener("submit", function (e) {
            e.preventDefault();
            const select = this.querySelector('select[name="designation_id"]');
            const slug = select.value;
            if (slug) {
                window.location.href = "career/" + slug;
            }
        });
    }

    setupFormRedirect("teachingForm");
    setupFormRedirect("nonTeachingForm");

</script>
</body>

</html>
