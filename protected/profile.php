<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
include("contents/permission.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Profile</title>
    <?php include("components/links.php") ?>
    <link rel="stylesheet" href="../assets/css/protected/profile.css">
</head>
<body>
<!-- Sidebar -->
<?php @include("components/sidebar.php") ?>

<!-- Main Content -->
<div class="main-content">
    <!-- Top Bar -->
    <?php @include("components/topbar.php") ?>

    <div class="container-fluid px-3 py-3">
        <!-- Personal Info -->
        <div class="border border-1 border-mute shadow-lg bg-white rounded p-3 mb-4">
            <div class="mb-3">
                <h5 class="fw-bold">Personal Information</h5>
            </div>

            <div class="row g-3">
                <div class="col-md-4">
                    <label class='text-secondary' for="name">Name</label>
                    <input id="name" type="text" class="form-control fw-bold text-capitalize"
                        value="<?= htmlspecialchars($name ?? '') ?>"
                        onfocus="changeBackground(this)"
                        onblur="saveData(this, '<?= htmlspecialchars($id) ?>', 'name')" />
                </div>

                <div class="col-md-4">
                    <label class='text-secondary' for="password">Password</label>
                    <input id="password" type="password" class="form-control fw-bold text-capitalize"
                        value="<?= htmlspecialchars($password ?? '') ?>"
                        onfocus="changeBackground(this)"
                        onblur="saveData(this, '<?= htmlspecialchars($id) ?>', 'password')" />
                </div>

                <div class="col-md-4">
                    <label class='text-secondary' for="family">Marital Status</label>
                    <select id="family" name="family" class="form-control fw-bold capitalize"
                        onfocus="changeBackground(this)"
                        onblur="saveData(this, '<?= htmlspecialchars($id) ?>', 'family')">
                        <option value="single" <?=  htmlspecialchars($family ?? '') === 'single' ? 'selected' : '' ?>>Single</option>
                        <option value="married" <?=  htmlspecialchars($family ?? '') === 'married' ? 'selected' : '' ?>>Married</option>
                        <option value="divorced" <?=  htmlspecialchars($family ?? '') === 'divorced' ? 'selected' : '' ?>>Divorced</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="border border-1 border-mute shadow-lg bg-white rounded p-3 mb-4">
            <div class="mb-3">
                <h5 class="fw-bold">Contact Information</h5>
            </div>

            <div class="row g-3">
            <div class="col-md-4">
    <label class="text-secondary">Email address</label>
    <input type="text"
        class="form-control fw-bold text-success"
        value="john.doe@example.com"
        onfocus="changeBackground(this)"
        onblur="saveData(this, '1', 'email')" />
</div>

<div class="col-md-4">
    <label class="text-secondary">Phone number</label>
    <input type="number"
        class="form-control fw-bold"
        value="08012345678"
        onfocus="changeBackground(this)"
        onblur="saveData(this, '1', 'phone')" />
</div>

<div class="col-md-4">
    <label class="text-secondary">Date of Birth (Y-m-d)</label>
    <input type="date"
        class="form-control fw-bold"
        value="1990-05-12"
        onfocus="changeBackground(this)"
        onblur="saveData(this, '1', 'dob')" />
</div>

            </div>
        </div>

        <!-- Address -->
        <div class="border border-1 border-mute shadow-lg bg-white rounded p-3 mb-4">
            <div class="mb-3">
                <h5 class="fw-bold">Address</h5>
            </div>

            <div class="row g-3">
                <div class="col-md-3">
                    <label class='text-secondary'>Country</label>
                    <input type="text" class="form-control fw-bold text-capitalize border-mute" value="Nigeria" disabled />
                </div>

                <div class="col-md-3">
                    <label for="state" class="form-label">State</label>
                    <select name="state" id="state" class="form-control fw-bold text-capitalize border-mute location"
                        onfocus="changeBackground(this)"
                        onblur="saveData(this, '<?= htmlspecialchars($id) ?>', 'state')">
                        <option value="">Select State</option>
                        <?php 
                        include("contents/getstates.php"); 
                        foreach ($states as $st): 
                            $selected = ($st === ($state ?? '')) ? "selected" : "";
                        ?>
                            <option value="<?= htmlspecialchars($st) ?>" <?= $selected ?>>
                                <?= htmlspecialchars($st) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="lga" class="form-label text-secondary">LGA</label>
                    <select id="lga" class="form-control fw-bold text-capitalize border-mute lga"
                        onfocus="changeBackground(this)"
                        onblur="saveData(this, '<?= htmlspecialchars($id) ?>', 'lga')">
                        <option value="">Select LGA</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class='text-secondary'>Full Address</label>
                    <input type="text" class="form-control fw-bold text-capitalize border-mute"
                        value="<?= htmlspecialchars($address ?? '') ?>"
                        onfocus="changeBackground(this)"
                        onblur="saveData(this, '<?= htmlspecialchars($id) ?>', 'address')" />
                </div>
            </div>
        </div>

        <!-- About -->
        <div class="border border-1 border-mute shadow-lg bg-white rounded p-3 mb-4">
            <div class="mb-3">
                <h5 class="fw-bold">About</h5>
            </div>
            <div class="form-group">
                <label class='text-secondary'>Bio</label>
                <textarea class="form-control fw-bold" rows="4"
                    onfocus="changeBackground(this)"
                    onblur="saveData(this, '<?= htmlspecialchars($id); ?>','bio');"><?= htmlspecialchars($bio); ?></textarea>
            </div>
        </div>

        <!-- Banking Details -->
        <div class="border border-1 border-mute shadow-lg bg-white rounded p-3 mb-4">
            <div class="mb-3">
                <h5 class="fw-bold">Banking Details</h5>
            </div>
            <form id="bankForm">
                <div class="row g-3">
                    <?php
                    $bank_fields = [
                        ['label' => 'Bank name', 'field' => 'bank_name', 'value' => $bank_name ?? ''],
                        ['label' => 'Bank account', 'field' => 'bank_account', 'value' => $bank_account ?? ''],
                        ['label' => 'Bank balance', 'field' => 'bank_balance', 'value' => $bank_balance ?? '']
                    ];
                    foreach ($bank_fields as $bank): ?>
                        <div class="col-md-4">
                            <label class="text-secondary"><?= htmlspecialchars($bank['label']) ?></label>
                            <input type="text" class="form-control border-mute"
                                value="<?= htmlspecialchars($bank['value']) ?>" />
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="mt-3">
                    <button name="submit" id="submit" class="btn btn-success shadow">
                        <span class="submit-note">Submit</span>
                        <span class="spinner-border text-white" style="display:none"></span>
                    </button>
                </div>
            </form>
        </div>

        <div class='border border-1 border-mute shadow-lg bg-white rounded p-3 mb-4'>

          <div class='mt-3'>            
               <h5 class="fw-bold">Next of Kin</h5>
          </div>

          <div class='d-flex justify-content-between align-items-center flex-md-row flex-column'>
          <div class="d-flex flex-row flex-column">
    <label class="text-secondary" for="next_of_kin_name">Name</label>
    <input 
        class="border border-2 border-mute form-control" 
        type="text" 
        name="next_of_kin_name" 
        id="next_of_kin_name"
    >
</div>

<div class="d-flex flex-row flex-column">
    <label class="text-secondary" for="next_of_kin_address">Address</label>
    <input 
        class="border border-2 border-mute form-control" 
        type="text" 
        name="next_of_kin_address" 
        id="next_of_kin_address"
    >
</div>

<div class="d-flex flex-row flex-column">
    <label class="text-secondary" for="next_of_kin_telephone">Phone number</label>
    <input 
        class="border border-2 border-mute form-control" 
        type="text" 
        name="next_of_kin_telephone" 
        id="next_of_kin_telephone"
    >
</div>

<div class="d-flex flex-row flex-column">
    <label class="text-secondary" for="next_of_kin_relationship">Relationship</label>
    <input 
        class="border border-2 border-mute form-control" 
        type="text" 
        name="next_of_kin_relationship" 
        id="next_of_kin_relationship"
    >
</div>

<div class="d-flex flex-row flex-column">
    <label class="text-secondary" for="pin">PIN</label>
    <input 
        class="border border-2 border-mute form-control" 
        type="text" 
        name="pin" 
        id="pin"
        value='<?= htmlspecialchars($pin) ?>'
    >
</div>
            
          </div>

          <div class='position-relative left-0 translate-start mt-4'>

              <button id='saveNextOfKin' class='btn btn-primary'>Submit</button>

          </div>

        </div>

    </div>
</div>

<script src="../assets/js/profile.js"></script>
</body>
</html>
