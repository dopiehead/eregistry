<?php
// ====================== Initialize Auth and DB ======================
require("engine/auth.php");
$auth = new Auth(new Database());
$table = " "; $limit = " "; $number = " "; $order = " ";
$conn = $auth->getConnection();
$id = isset($_GET['id']) ? filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;
$u_id = base64_decode($id);

// ====================== Saved Searched User Info From Redirect ======================
include ("contents/search-info.php");

// ====================== Load User Info or Redirect ======================
if($u_id):
  include("contents/user-information.php");
  $extension = strtolower(pathinfo($image,PATHINFO_EXTENSION));
  $image_extension  = array('jpg','jpeg','png'); 
else:
  header("Location:index.php");
endif;
?>

<html lang="en">
<head>
     <!-- ====================== Page Head ====================== -->
     <?php @include("components/links.php") ?>
     <link rel="stylesheet" href="assets/css/userprofile.css">
     <title>Profile</title>
</head>
<body>
<!-- ====================== Navbar ====================== -->
<?php @include 'components/navbar.php' ?> 
<br><br>

<!-- ====================== Header Section ====================== -->
<div class="header">
    <h1><?= htmlspecialchars($name) ?></h1>
    <div class="windchime-logo">
        <div class="logo">Eregistry</div>
        <div class="subtitle">USER PERSONA</div>
    </div>
</div>

<!-- ====================== Main Container ====================== -->
<div class="container-fluid p-4">
    <div class="row">
        <!-- ====================== Left Column ====================== -->
        <div class="col-md-3">
            <div class="mb-3">
                <strong>Age:</strong><?= $auth->yearsAgo($dob) ?? null ?><br>
                <strong>Occupation:</strong> <?= htmlspecialchars($occupation) ?? null ?><br>
                <strong>Family:</strong> <?= htmlspecialchars($family) ?? null ?><br>
                <strong>Location:</strong> <?= htmlspecialchars($address).", ".htmlspecialchars($state); ?>
            </div>

            <!-- ====================== Profile Image ====================== -->
            <?php             
             if (!in_array($extension , $image_extension)) :
                  echo"<div class='text-center border border-mute border-2 profile-image'><span style='font-size:150px;' class='text-secondary text-uppercase h-100 w-100'>".substr($name,0,2)."</span></div>";                  
             else: ?> 
            <img src="<?= htmlspecialchars($image ? $image : 'https://placehold.co/400') ?>" alt="<?= htmlspecialchars($name) ?>" class="profile-image">
            <?php endif ?>

            <!-- ====================== Daily Quote ====================== -->
            <div class="quote-box">
                   <?php $table = "quotes";
                   if(!empty($table) && $table=="quotes"):
                     include("contents/table.php");
                     $limit = "limit";
                     $number = 1;
                     $order = " ORDER BY id ASC";
                     ?>
                <?= json_encode($quotes_daily ?? null)  ?>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- ====================== Middle Column ====================== -->
        <div class="col-md-6">
            <!-- ====================== Registry Tags ====================== -->
            <div class="mb-4">
                <div class="section-title text-capitalize"><?= htmlspecialchars($name)."'s ". " Registry" ?></div>
                <?php
                $personas = ['VEHICLE','PROPERTY','BIRTH','MARRIAGE','JOB'];
                foreach($personas as $persona): ?>
                  <div class="mb-2">
                    <span class="motivation-tag"><?= htmlspecialchars($persona)." REGISTRY" ?></span>
                  </div>
               <?php endforeach   ?>
            </div>
            
            <!-- ====================== Bio Section ====================== -->
            <div class="mb-4">
                <div class="section-title">Bio</div>
                <div class="bio-text">
                    <?= htmlspecialchars($bio) ?>
                </div>
            </div>
            
            <!-- ====================== Personality Section ====================== -->
            <div class="mb-4">
                <div class="section-title">Personality</div>
               
               <?php
                 $table = "traits";
                 if(!empty($table) && $table =='traits'):
                    include("contents/table.php");
                 endif;

                 $personalityTraits = [
                    ['label1' => 'EXTROVERT',  'label2' => 'INTROVERT',  'percent' => $introvert_extrovert ?? ''],
                    ['label1' => 'ANALYTICAL', 'label2' => 'CREATIVE',   'percent' => $analytical_creative ?? ''],
                    ['label1' => 'LOYAL',      'label2' => 'IMPULSIVE',  'percent' => $loyal_impulsive ?? ''],
                    ['label1' => 'PASSIVE',    'label2' => 'ACTIVE',     'percent' => $passive_active ?? ''],
                ];
                ?>

                <?php foreach ($personalityTraits as $trait): ?>
                    <div class="mb-3">
                        <div class="personality-bar">
                            <div class="personality-fill" style="width: <?= (int)$trait['percent'] ?>%;"></div>
                        </div>
                        <div class="personality-labels">
                            <span><?= htmlspecialchars($trait['label1']) ?></span>
                            <span><?= htmlspecialchars($trait['label2']) ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- ====================== Right Column ====================== -->
        <div class="col-md-3">
            <!-- ====================== Goals Section ====================== -->
            <div class="mb-4">
                <div class="section-title">Goals</div>
                <ul>
                <?php
                  $table = "goals";
                  if(!empty($table)){
                     $getuserGoals = $conn->prepare("SELECT * FROM $table WHERE u_id = ?");
                     $getuserGoals->bind_param("i",$u_id);
                     if($getuserGoals->execute()){
                        $result = $getuserGoals->get_result();
                        while($datafound = $result->fetch_assoc()){
                          echo"<li>{$datafound['goals']}</li>";
                     }                     
                   }
                  }
                 ?>
                </ul>
            </div>
            
            <!-- ====================== Trusted Brands ====================== -->
            <div class="mb-4">
                <div class="section-title">Trusted Brands</div>
                <div class="brand-logos">
                    <span style="color: #666; font-size: 24px; font-weight: bold;">eStores</span>
                    <span style="color: #999; font-size: 18px;">eReport</span>
                    <span style="color: #999; font-size: 18px; font-style: italic;">eFixit</span>
                    <span style="color: #999; font-size: 16px; border: 2px solid #999; border-radius: 50%; padding: 5px 8px;">Edirect</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ====================== Footer ====================== -->
<?php @include 'components/footer.php' ?> 
</body>
</html>
