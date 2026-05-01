<?php
include '../../common/importwebsitefile.php';
$pageTitle = "IT Cell Team | Gyanmanjari Innovative University | GMIU";
$meta_description = "Meet the IT Cell team at GMIU – a dedicated group of professionals ensuring technology support and digital innovation.";
?>
<!doctype html>
<html lang="zxx">
<head>
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; include '../include/importcss.php'; ?>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins', sans-serif; }
        :root { --p:#ba2a21; --g:linear-gradient(135deg, #ba2a21, #e84040); --sh:0 20px 40px -10px rgba(0,0,0,.15); }
        .single-courses-area { background:linear-gradient(135deg,#f8f9fc,#f0f2f8); padding:60px 0 80px; position:relative; overflow:hidden; }
        .single-courses-area::before, .single-courses-area::after { content:''; position:absolute; border-radius:50%; pointer-events:none; }
        .single-courses-area::before { top:-120px; right:-120px; width:420px; height:420px; background:radial-gradient(circle,rgba(186,42,33,.08),transparent 70%); }
        .single-courses-area::after { bottom:-100px; left:-100px; width:360px; height:360px; background:radial-gradient(circle,rgba(10,28,61,.06),transparent 70%); }
        .it-cell-section { padding-bottom:50px; }
        .section-header { text-align:center; margin-bottom:40px; }
        .section-badge { display:inline-flex; align-items:center; gap:8px; background:rgba(186,42,33,.1); border:1px solid rgba(186,42,33,.2); color:var(--p); font-size:12px; font-weight:600; padding:7px 18px; border-radius:50px; margin-bottom:14px; text-transform:uppercase; }
        .section-title { font-size:clamp(1.6rem, 3vw, 2.1rem); font-weight:800; color:#0a1c3d; }
        .section-title span { background:var(--g); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }
        .section-divider { display:flex; align-items:center; justify-content:center; gap:10px; margin-top:6px; }
        .section-divider::before, .section-divider::after { content:''; width:60px; height:2px; background:linear-gradient(90deg,transparent,var(--p)); }
        .section-divider::after { background:linear-gradient(90deg,var(--p),transparent); }
        .section-divider-dot { width:8px; height:8px; border-radius:50%; background:var(--p); box-shadow:0 0 0 3px rgba(186,42,33,.2); }
        .destination-card { width:100%; aspect-ratio:4/6; position:relative; animation:fadeUp .8s cubic-bezier(.2,.8,.2,1) both; margin:0 auto 30px; transition:.6s; }
        .card-inner { position:absolute; inset:0; border-radius:24px; overflow:hidden; background:#fff; box-shadow:var(--sh); border:1px solid #fff; }
        .destination-card:hover .card-inner { transform:translateY(-8px); box-shadow:0 35px 70px -15px rgba(0,0,0,.3); }
        .bg-layer { position:absolute; inset:0; background-size:cover; background-position:top; transition:1.2s; background-color:#f3f4f6; }
        .destination-card:hover .bg-layer { transform:scale(1.1); }
        .gradient-layer { position:absolute; inset:0; background:linear-gradient(to top, #0a1c3d 0%, rgba(10,28,61,.5) 30%, transparent 60%); opacity:.9; transition:.5s; }
        .destination-card:hover .gradient-layer { opacity:1; }
        .content-layer { position:absolute; inset:0; display:flex; flex-direction:column; justify-content:flex-end; padding:30px 24px; color:#fff; z-index:2; }
        .destination-card h3 { font-size:1.4rem; font-weight:700; background:var(--g); border-radius:12px; text-align:center; box-shadow:0 8px 15px rgba(0,0,0,.2); border:1px solid rgba(255,255,255,.2); color:#fff!important; transform:translateY(50px); transition:.5s cubic-bezier(.4,0,.2,1); }
        .destination-card:hover h3 { transform:translateY(-10px); box-shadow:0 12px 20px rgba(186,42,33,.3); }
        .action-row { display:flex; justify-content:center; align-items:center; gap:12px; background:rgba(255,255,255,.12); backdrop-filter:blur(10px); border:1px solid rgba(255,255,255,.2); border-radius:14px; padding:10px; transform:translateY(60px); opacity:0; transition:.5s; transition-delay:.05s; }
        .destination-card:hover .action-row { transform:translateY(0); opacity:1; }
        .explore-btn { display:flex; align-items:center; justify-content:center; background:rgba(255,255,255,.2); border:1px solid rgba(255,255,255,.3); border-radius:12px; width:48px; height:48px; color:#fff!important; transition:.3s; }
        .explore-btn:hover { background:#fff; color:var(--p)!important; transform:translateY(-3px); box-shadow:0 5px 12px rgba(0,0,0,.2); }
        .explore-btn.main-connect { width:auto; border-radius:12px; padding:0 20px; gap:10px; background:var(--g); border:none; }
        .explore-btn.main-connect:hover { transform:translateY(-3px); background:#fff; color:var(--p)!important; }
        .explore-btn span { font-size:1rem; font-weight:600; }
        .explore-btn i { font-size:1.4rem; }
        @media (max-width:600px) { .action-row, h3 { transform:translateY(0)!important; opacity:1!important; } .destination-card:hover h3 { transform:translateY(-5px); } }
        @keyframes fadeUp { from { opacity:0; transform:translateY(40px); } to { opacity:1; transform: translateY(0); } }
         .card-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
        }
          /* Default (mobile first) */
        .card-grid > div {
            width: 100%; /* 1 per row */
        }
        
        /* Tablet */
        @media (min-width: 600px) {
            .card-grid > div {
                width: calc(50% - 20px); /* 2 per row */
            }
        }
        
        /* Desktop */
        @media (min-width: 992px) {
            .card-grid > div {
                width: calc(25% - 20px); /* 4 per row */
            }
        }
    </style>
</head>
<body class="courses">
    <?php include '../include/importheader.php'; ?>
    <section class="hero"><div class="img"></div><div class="container"><div class="cont"><div class="top"><h1>IT CELL TEAM</h1></div><p style="margin-top:5px;"><span><a href="<?php echo $base_url_website;?>" style="color:#727272">Home</a><i class='fa fa-angle-right'></i></span> <span class="b-active">IT CELL TEAM</span></p><hr></div></div></section>
    <div class="single-courses-area">
        <div class="container">
            <div class="single-curses-contert">
                <?php
                $leadership = [
                    ["Prof. Prashant Viradiya", "pjv.webp", [["url" => "https://www.linkedin.com/in/prashant-j-viradiya", "icon" => "fab fa-linkedin"], ["url" => "https://prashantviradiya.co.in/", "icon" => "fa-sharp fa-solid fa-globe"]]],
                    ["Prof. Pruthviraj Parmar", "pvp.webp", [["url" => "https://www.linkedin.com/in/pruthvirajparmar", "icon" => "fab fa-linkedin"], ["url" => "https://www.linkedin.com/in/pruthvirajparmar", "icon" => "fa-sharp fa-solid fa-globe"]]],
                    // ["Vidhi Rathod", "vdr.png", [["url" => "", "icon" => "fab fa-linkedin"], ["url" => "", "icon" => "fa-sharp fa-solid fa-globe"]]]
                ];
                $team = [
                    ["Akshar Rathod", "akki.png", [["url" => "https://in.linkedin.com/in/akshar-rathod", "icon" => "fab fa-linkedin"], ["url" => "https://aksharrathod.netlify.app/", "icon" => "fa-sharp fa-solid fa-globe"]]],
                    ["Dev Dholakiya", "dkd.png", [["url" => "https://www.linkedin.com/in/dev-dholakiya-0b885a220", "icon" => "fab fa-linkedin"], ["url" => "https://devdholakiya.netlify.app/", "icon" => "fa-sharp fa-solid fa-globe"]]],
                  
                    ["Vidhi Rathod", "vdr.png", [["url" => "#", "icon" => "fab fa-linkedin"], ["url" => "https://in.linkedin.com/in/vidhi-rathod-737a74233", "icon" => "fa-sharp fa-solid fa-globe"]]],
                    ["Romit Keshvani", "romitk.png", [["url" => "https://in.linkedin.com/in/romit-keshvani-a96480264", "icon" => "fab fa-linkedin"], ["url" => "https://in.linkedin.com/in/romit-keshvani-a96480264", "icon" => "fa-sharp fa-solid fa-globe"]]],
                   
                    ["Om Bhatt", "om_bhatt.png", [["url" => "https://www.linkedin.com/in/bhatt-om-577010224/", "icon" => "fab fa-linkedin"], ["url" => "http://ombhatt.42web.io/", "icon" => "fa-sharp fa-solid fa-globe"]]],
                    ["Bhumit Jograna", "bhumit.png", [["url" => "#", "icon" => "fab fa-linkedin"], ["url" => "http://jograna.duckdns.org", "icon" => "fa-sharp fa-solid fa-globe"]]],
                   
                  
                ];
                $currentintern=[   
                    ["Deep Joshi", "deep.png", [["url" => "https://www.linkedin.com/in/deep-joshi-068484311/", "icon" => "fab fa-linkedin"],["url" => "https://derugonew.netlify.app/", "icon" => "fa-sharp fa-solid fa-globe"]]],
                    ["Rudra Dodiya", "rudra.png", [["url" => "https://www.linkedin.com/in/rudra-dodiya/", "icon" => "fab fa-linkedin"],["url" => "https://derugonew.netlify.app/", "icon" => "fa-sharp fa-solid fa-globe"]]],
                    ["Gopal chudasama", "gopal.png", [["url" => "https://www.linkedin.com/in/gopalchudasama/", "icon" => "fab fa-linkedin"],["url" => "https://derugonew.netlify.app/", "icon" => "fa-sharp fa-solid fa-globe"]]],
                 ];
                 $intern=[
                    ["Devang Bhatt", "devangbhatt.webp", [["url" => "https://www.linkedin.com/in/devang-bhatt-9948b7260", "icon" => "fab fa-linkedin"], ["url" => "https://www.linkedin.com/in/devang-bhatt-9948b7260", "icon" => "fa-sharp fa-solid fa-globe"]]],
                    ["Manan Gundigara", "manan.png", [["url" => "https://www.linkedin.com/in/manan-gundigara", "icon" => "fab fa-linkedin"], ["url" => "https://www.linkedin.com/in/manan-gundigara", "icon" => "fa-sharp fa-solid fa-globe"]]],
                    ["Jay Nirmal", "jaynirmal.png", [["url" => "https://in.linkedin.com/in/jay-nirmal-0728b6302", "icon" => "fab fa-linkedin"], ["url" => "https://in.linkedin.com/in/jay-nirmal-0728b6302", "icon" => "fa-sharp fa-solid fa-globe"]]],
                    ["Dev Patel", "dev.png", [["url" => "https://www.linkedin.com/in/dev-patel-b41a52235/", "icon" => "fab fa-linkedin"], ["url" => "https://www.linkedin.com/in/dev-patel-b41a52235/", "icon" => "fa-sharp fa-solid fa-globe"]]],
                    ["Dhruvgiri Goswami", "dhruvgiri.png", [["url" => "https://www.linkedin.com/in/dhruvgiri-goswami", "icon" => "fab fa-linkedin"], ["url" => "https://dhruvgiri.in", "icon" => "fa-sharp fa-solid fa-globe"]]],
                    ["Rijvan Juneja", "rijvan.png", [["url" => "https://www.linkedin.com/in/rijvan-juneja", "icon" => "fab fa-linkedin"], ["url" => "https://juneja.netlify.app/", "icon" => "fa-sharp fa-solid fa-globe"]]],
                    ["Soham Mandaliya", "soham.png", [["url" => "https://www.linkedin.com/in/soham-mandaliya", "icon" => "fab fa-linkedin"], ["url" => "https://sohamandaliya.netlify.app/", "icon" => "fa-sharp fa-solid fa-globe"]]],
                    ["Dhyey Patel", "dhyey.png", [["url" => "https://www.linkedin.com/in/dhyey-patel-16394922a", "icon" => "fab fa-linkedin"], ["url" => "https://www.linkedin.com/in/dhyey-patel-16394922a", "icon" => "fa-sharp fa-solid fa-globe"]]],
                    ["Pratham Joshi", "pratham.png", [["url" => "https://www.linkedin.com/in/joshi-pratham-015b4a22a", "icon" => "fab fa-linkedin"], ["url" => "https://prathamjoshi.netlify.app", "icon" => "fa-sharp fa-solid fa-globe"]]],
                    ["Shruti Thesiya", "shruti.png", [["url" => "https://www.linkedin.com/in/shruti-patel-5a765a268", "icon" => "fab fa-linkedin"], ["url" => "https://www.linkedin.com/in/shruti-patel-5a765a268", "icon" => "fa-sharp fa-solid fa-globe"]]],
                    ["Khushi Rupera", "khushi.png", [["url" => "https://www.linkedin.com/in/khushi-rupera", "icon" => "fab fa-linkedin"], ["url" => "https://www.linkedin.com/in/khushi-rupera", "icon" => "fa-sharp fa-solid fa-globe"]]],
                    ["Jay Chudasama", "jay.png", [["url" => "https://www.linkedin.com/in/chudasama-jay-16a341250", "icon" => "fab fa-linkedin"], ["url" => "https://www.linkedin.com/in/chudasama-jay-16a341250", "icon" => "fa-sharp fa-solid fa-globe"]]],
                    ["Madhav Rathod", "madhav.png", [["url" => "https://www.linkedin.com/in/madhav-rathod-62118324a/", "icon" => "fab fa-linkedin"], ["url" => "https://www.linkedin.com/in/madhav-rathod-62118324a/", "icon" => "fa-sharp fa-solid fa-globe"]]]
                ];

                $renderCard = function($name, $img, $links, $idx) use ($website_assets_url) {
                    $delay = 0.1 * ($idx + 1);
                    $html = "<div class='destination-card' style='animation-delay:{$delay}s'><div class='card-inner'>";
                    $html .= "<div class='bg-layer' style='background-image:url(\"{$website_assets_url}images/it_cell_team/{$img}\")'></div>";
                    $html .= "<div class='gradient-layer'></div><div class='content-layer'><h3>$name</h3><div class='action-row'>";
                    foreach ($links as $i => $link) {
                        $cls = $i == 0 ? "explore-btn main-connect" : "explore-btn";
                        $txt = $i == 0 ? "<span>Connect</span>" : "";
                        $html .= "<a href='{$link['url']}' target='_blank' class='$cls'>$txt<i class='{$link['icon']}'></i></a>";
                    }
                    echo $html . "</div></div></div></div>";
                };

                $sections = [
                    ['Leadership', 'fa-star', 'Head of <span>IT Cell</span>', $leadership, 'col-xl-4 col-lg-4 col-md-6'],
                    ['Our staff', 'fa-users', 'IT Cell <span>Staff Members</span>', $team, 'col-xl-4 col-lg-4 col-md-6'],
                    ['Our Intern', 'fa-users', 'IT Cell <span>interns</span>', $currentintern, 'col-xl-4 col-lg-4 col-md-6'],
                    ['Our team', 'fa-users', 'IT Cell <span>Team Members</span>', $intern, 'col-xl-4 col-lg-4 col-md-6'],
                    
                    
                ];

                foreach($sections as $s) { ?>
                    <section class="it-cell-section">
                        <div class="section-header"><div class="section-badge"><i class="fa-solid <?=$s[1]?>"></i> <?=$s[0]?></div><h2 class="section-title"><?=$s[2]?></h2><div class="section-divider"><div class="section-divider-dot"></div></div></div>
                        <div class="card-grid">
                            <?php foreach($s[3] as $i => $m) { 
                                echo "<div>"; 
                                $renderCard($m[0], $m[1], $m[2], $i); 
                                echo "</div>"; 
                            } ?>
                        </div>
                    </section>
                <?php } ?>
            </div></div></div>
        </div>
    </div>
    <?php include '../include/importfooter.php'; include '../include/importjs.php'; ?>
</body>
</html>